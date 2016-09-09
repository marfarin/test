<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 01.06.16
 * Time: 11:57
 */

namespace common\helpers;

use yii\helpers\FileHelper;

class ClassListHelper extends FileHelper
{
    static $classes = [];

    /**
     * @param string $path
     * @return \ReflectionClass[]
     */
    public static function getClassList($path)
    {
        $directory = new \RecursiveDirectoryIterator($path, \RecursiveDirectoryIterator::SKIP_DOTS);
        $iterator = new \RecursiveIteratorIterator($directory);
        $phpFiles = new \RegexIterator($iterator, '/^.+\.php$/i');
        $fqcns = [];
        foreach ($phpFiles as $phpFile) {
            $content = file_get_contents($phpFile->getRealPath());
            $tokens = token_get_all($content);
            try {
                $className = self::findClassNameFile($tokens);
                if (is_subclass_of($className, 'yii\base\Model')) {
                    $fqcns[] = new \ReflectionClass($className);
                }
            } catch (\Error $e) {

            }
        }
        return $fqcns;
    }

    /**
     * @param \ReflectionClass $className
     * @return array
     */
    public static function getConstantList(\ReflectionClass $className)
    {
        return $className->getConstants();
    }

    /**
     * @param $tokens
     * @return string
     */
    private static function findClassNameFile($tokens)
    {
        $namespace = '';
        for ($index = 0; isset($tokens[$index]); $index++) {
            if (!isset($tokens[$index][0])) {
                continue;
            }
            if (T_NAMESPACE === $tokens[$index][0]) {
                $index += 2; // Skip namespace keyword and whitespace
                while (isset($tokens[$index]) && is_array($tokens[$index])) {
                    $namespace .= $tokens[$index++][1];
                }
            }
            if (T_CLASS === $tokens[$index][0]) {
                $index += 2; // Skip class keyword and whitespace
                $className = $namespace.'\\'.$tokens[$index][1];
                return $className;
            }
        }
        return null;
    }
}
