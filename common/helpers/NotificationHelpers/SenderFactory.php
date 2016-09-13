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

class SenderFactory
{
    /**
     * @param string $senderClass
     * @param ConfigureModelEvent $configureModelEvent
     * @param \yii\base\Model $model
     * @return mixed
     */
    public static function getSender($senderClass, $configureModelEvent, $model)
    {
        $senderClass = $senderClass::className();
        $sender = new $senderClass;
        if ($sender instanceof AbstractNotificationHelper) {
            /**
             * @var AbstractNotificationHelper $sender
             */
            $sender->model = $model;
            $sender->configureModelEvent = $configureModelEvent;
            return $sender;
        }
        return null;
    }
}