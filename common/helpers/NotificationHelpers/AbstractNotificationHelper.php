<?php

namespace common\helpers\NotificationHelpers;

use yii\base\Model;
use common\models\rbacDB\Role;
use common\models\User;
use frontend\models\ConfigureModelEvent;

/**
 * Created by PhpStorm.
 * User: panik
 * Date: 06.09.16
 * Time: 17:56
 */

/**
 * Class AbstractNotificationHelper
 * @package common\helpers\NotificationHelpers
 * @property ConfigureModelEvent $configureModelEvent
 * @property Model $model
 * @property User[] $users
 */
abstract class AbstractNotificationHelper extends Model
{
    public $configureModelEvent;
    
    public $model;

    public $users;
    
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

        return $this->parseText($templates, $user, $header);
    }
    
    protected function getText($user)
    {
        $text = $this->configureModelEvent->message_header;
        $templatePattern = '/{([^}]+)}/';
        $matches = [];
        preg_match_all($templatePattern,$text,$matches);
        $templates = array_unique($matches[1]);

        return $this->parseText($templates, $user, $text);
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

    /**
     * @param string[] $templates
     * @param User $user
     * @param string $text
     * @return string
     */
    protected function parseText($templates, $user, $text)
    {

        $model = $this->model;
        $author = $this->configureModelEvent->sender;
        foreach($templates as $template) {
            $type = self::getTemplateType($template);
            switch ($type) {
                case 'user':
                    $field = substr($template, 5);
                    $text = str_replace('{' . $template . '}', $user[$field], $text);
                    break;
                case 'model':
                    $field = substr($template, 6);
                    $text = str_replace('{' . $template . '}', $model[$field], $text);
                    break;
                case 'sender':
                    $field = substr($template, 7);
                    $text = str_replace('{' . $template . '}', $author[$field], $text);
                    break;
                default:
                    $field = null;
                    $text = str_replace('{' . $template . '}', \Yii::$app->params[$template], $text);
                    break;
            }
        }
        return $text;
    }

    /**
     * @param $notificationType
     * @return User[]
     */
    public function getUsers($notificationType)
    {
        $users = $this->configureModelEvent->users;
        $roles = $this->configureModelEvent->roles;

        /**
         * @var Role[] $roles
         */

        $userByRole = [];

        foreach ($roles as $role) {
            array_merge($userByRole, $role->users);
        }


        $uniqueUsers = [];

        foreach ($userByRole as $item) {
            $uniqueUsers[$item->id] = $item;
        }

        foreach ($users as $item) {
            $uniqueUsers[$item->id] = $item;
        }

        $filteredUsers = [];



        /**
         * @var User[] $uniqueUsers
         */
        foreach ($uniqueUsers as $uniqueUser) {

            if (!empty($uniqueUser->notificationTypeId[$notificationType->id])) {
                $filteredUsers[] = $uniqueUser;
            } elseif (empty($uniqueUser->notificationTypeId)) {
                $filteredUsers[] = $uniqueUser;
            }

        }

        return $filteredUsers;
    }
}