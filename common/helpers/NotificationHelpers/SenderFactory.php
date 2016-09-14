<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 07.09.16
 * Time: 15:45
 */

namespace common\helpers\NotificationHelpers;

use common\helpers\NotificationHelpers\AbstractNotificationHelper;
use frontend\models\ConfigureModelEvent;
use frontend\models\NotificationType;

class SenderFactory
{
    /**
     * @param NotificationType $senderClass
     * @param ConfigureModelEvent $configureModelEvent
     * @param \yii\base\Model $model
     * @return mixed
     */
    public static function getSender($notificationType, $configureModelEvent, $model)
    {
        $senderClass = $notificationType->class_name;
        $senderClass = $senderClass::className();
        $sender = new $senderClass;
        if ($sender instanceof AbstractNotificationHelper) {
            /**
             * @var AbstractNotificationHelper $sender
             */
            $sender->model = $model;
            $sender->configureModelEvent = $configureModelEvent;
            $sender->users = $sender->getUsers($notificationType);
            return $sender;
        }
        return null;
    }
}