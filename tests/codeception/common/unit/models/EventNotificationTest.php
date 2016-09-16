<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 15.09.16
 * Time: 22:20
 */

namespace codeception\common\unit\models;

use frontend\models\ConfigureModelEvent;
use frontend\models\EventClass;
use tests\codeception\common\fixtures\ConfigureModelEventFixture;
use tests\codeception\common\fixtures\NotificationTypeFixture;
use Codeception\Specify;
use common\components\EventNotificator;
use frontend\models\NotificationType;
use tests\codeception\common\unit\DbTestCase;
use yii\base\Event;

class EventNotificationTest extends DbTestCase
{
    use Specify;
    public function fixtures(){
        return [
            'notifications'=>[
                'class' => ConfigureModelEventFixture::className(),
                'dataFile' => '@tests/codeception/common/unit/fixtures/data/models/configure_model_event.php'
            ]
        ];
    }

    public function testInit(){
        $subscriber = (new EventNotificator())->bootstrap(\Yii::$app);
        $this->specify('Проверяем, что подписка на события прошла успешно', function() use ($subscriber){
            $notifications = ConfigureModelEvent::find()->all();
            foreach($notifications as $notification){
                expect('Должна быть успешной отписка от событиев', Event::off($notification->eventClass->class_name, $notification->eventClass->event_name))->true();
            }
        });
    }
}