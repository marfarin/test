<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 23.05.16
 * Time: 13:22
 */

namespace common\components;

use frontend\models\AlertUserQuery;
use frontend\models\ConfigureModelEvent;
use yii\base\BootstrapInterface;
use yii\base\Event;
use app\components\senders\SenderFactory;

class EventNotificator implements BootstrapInterface
{
    public function bootstrap($app)
    {
        \Yii::$app->on(\yii\base\Application::EVENT_BEFORE_REQUEST, function ($event) {
            $data = AlertUserQuery::find()->where('readed_at is null')->andWhere(['recipient_id' => \Yii::$app->user->id])->all();
            $flashes = [];
            foreach ($data as $item) {
                $flashes[$item->id] = $item->header.' '.$item->text;
            }
            \Yii::$app->session->setFlash('error', $flashes);
        });
        $events = ConfigureModelEvent::find()->all();
        foreach ($events as $userEvent) {
            $className = $userEvent->eventClass->class_name;
            $eventName = $userEvent->eventClass->event_name;
            Event::on($className::className(), $eventName, function ($event) use ($userEvent) {
                foreach ($userEvent->notificationTypes as $notificationType) {
                    $sender = SenderFactory::getSender($notificationType->class_name, $userEvent, $event->sender);
                    $sender->send();
                }
            });
        }
    }
}