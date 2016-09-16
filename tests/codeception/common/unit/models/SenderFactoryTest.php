<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 15.09.16
 * Time: 22:44
 */

namespace codeception\common\unit\models;


use frontend\models\ConfigureModelEvent;
use frontend\models\NotificationType;
use tests\codeception\common\fixtures\NotificationTypeFixture;
use tests\codeception\common\unit\DbTestCase;
use Codeception\Specify;
use common\helpers\NotificationHelpers\EmailNotificationHelper;
use common\helpers\NotificationHelpers\SystemNotificationHelper;
use common\helpers\NotificationHelpers\SenderFactory;
use yii\base\Model;

class SenderFactoryTest extends DbTestCase
{
    /**
     * Использовать генерацию данных в БД
     */
    use Specify;
    public function fixtures(){
        return [
            'notificationTypes'=>[
                'class' => NotificationTypeFixture::className(),
                'dataFile' => '@tests/codeception/common/unit/fixtures/data/models/notification_type.php'
            ]
        ];
    }

    public function testFindIdentity(){
        $this->specify('Проверка работы фабричной функции', function(){

            $notificationTypeEmail = NotificationType::findOne(2);
            $configureModelEvent = new ConfigureModelEvent();

            $notificationTypeSystem = NotificationType::findOne(1);

            $sender = SenderFactory::getSender($notificationTypeSystem, $configureModelEvent, $notificationTypeEmail);

            expect('Класс должен быть app\components\senders\BrowserSender', $sender)
                ->isInstanceOf(SystemNotificationHelper::className());

            $sender = SenderFactory::getSender($notificationTypeEmail, $configureModelEvent, $notificationTypeEmail);

            expect('Класс должен быть app\components\senders\EmailSender', $sender)
                ->isInstanceOf(EmailNotificationHelper::className());

        });
    }
}