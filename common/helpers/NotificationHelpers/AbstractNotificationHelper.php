<?php

namespace common\helpers\NotificationHelpers;

use common\components\Model;
use common\models\rbacDB\Role;

/**
 * Created by PhpStorm.
 * User: panik
 * Date: 06.09.16
 * Time: 17:56
 */
abstract class AbstractNotificationHelper extends Model
{
    public $configureModelEvent;
    
    public $model;
    
    abstract protected function send();

    abstract protected function show();

    abstract protected function showed();
    
    protected function getHeader($user)
    {
        $header = $this->configureModelEvent->message_header;
        $templatePattern = '/{([^}]+)}/';
        $matches = [];
        preg_match_all($templatePattern,$header,$matches);
        $templates = array_unique($matches[1]);
        $model = $this->model;
        $author = $this->configureModelEvent->sender;
        foreach($templates as $template){
            $type = self::getTemplateType($template);
            switch($type){
                case 'user':
                    $field=substr($template,4);
                    $header = str_replace('{'.$template.'}',$user[$field],$header);
                    break;
                case 'model':
                    $field=substr($template,5);
                    $header = str_replace('{'.$template.'}',$model[$field],$header);
                    break;
                case 'author':
                    $field=substr($template,6);
                    $header = str_replace('{'.$template.'}',$author[$field],$header);
                    break;
                default:
                    $field=null;
                    $header = str_replace('{'.$template.'}',\Yii::$app->params[$template],$header);
                    break;
            }
        }
        return $header;
    }
    
    protected function getText($user)
    {
        $text = $this->configureModelEvent->message_header;
        $templatePattern = '/{([^}]+)}/';
        $matches = [];
        preg_match_all($templatePattern,$text,$matches);
        $templates = array_unique($matches[1]);
        $model = $this->model;
        $author = $this->configureModelEvent->sender;
        foreach($templates as $template){
            $type = self::getTemplateType($template);
            switch($type){
                case 'user':
                    $field=substr($template,4);
                    $text = str_replace('{'.$template.'}',$user[$field],$text);
                    break;
                case 'model':
                    $field=substr($template,5);
                    $text = str_replace('{'.$template.'}',$model[$field],$text);
                    break;
                case 'sender':
                    $field=substr($template,6);
                    $text = str_replace('{'.$template.'}',$author[$field],$text);
                    break;
                default:
                    $field=null;
                    $text = str_replace('{'.$template.'}',\Yii::$app->params[$template],$text);
                    break;
            }
        }
        return $text;
    }

    private static function getTemplateType($template)
    {
        $str = substr($template,0,6);
        if($str==='sender') return $str;
        $str = substr($str,0,5);
        if($str==='model') return $str;
        $str = substr($str,0,4);
        return $str==='user' ? $str : 'global';
    }

    protected function users()
    {
        $users = $this->configureModelEvent->users;
        $roles = $this->configureModelEvent->roles;
        /**
         * @var Role[] $roles
         */
        foreach ($roles as $role) {
           
        }
        
        return $users;
    }
}