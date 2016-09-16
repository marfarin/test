<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 15.09.16
 * Time: 22:43
 */

namespace codeception\common\unit\models;

use Codeception\Specify;
use common\helpers\ClassListHelper;
use tests\codeception\common\unit\DbTestCase;
use yii\base\Model;

class ClassListHelperTest extends DbTestCase
{
    use Specify;
    public function testGetClassInheritance(){
        $result = ClassListHelper::getClassList(\Yii::getAlias('@frontend'));
        $this->specify('проверяем полученный результат', function() use ($result){
            expect('Результат не должен быть пустым', count($result)>0)->true();
            foreach($result as $r){
                expect('Элемент должен быть экземпляром требуемого класса',
                    $r->isSubclassOf(Model::className()))->true();
            }
        });
    }
}