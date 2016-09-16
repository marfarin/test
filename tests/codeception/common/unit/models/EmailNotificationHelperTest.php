<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 15.09.16
 * Time: 22:46
 */

namespace codeception\common\unit\models;

use tests\codeception\common\fixtures\ConfigureModelEventFixture;
use Codeception\Specify;
use common\helpers\NotificationHelpers\SenderFactory;
use common\models\User;
use frontend\models\ConfigureModelEvent;
use frontend\models\NotificationType;
use tests\codeception\common\unit\DbTestCase;

class EmailNotificationHelperTest extends DbTestCase
{
    use Specify;

    public function fixtures(){
        return [
            'configureModelEvents' => ConfigureModelEventFixture::className(),
        ];
    }

    public function testSend(){
        var_dump(\Yii::$app->mailer);
        $notificationType = NotificationType::findOne(2);
        $configureModelEvent = ConfigureModelEvent::findOne(1);
        $user = User::findOne(11);
        $configureModelEvent->link('users', $user);
        $model = User::findOne(12);
        $sender = SenderFactory::getSender($notificationType, $configureModelEvent, $model);
        $this->specify('Проверка корректности отправки сообщения', function() use ($sender){
            //очищаем выходную папку сообщений
            $emailPath = \Yii::$app->basePath . '\runtime\mail\*';
            array_map('unlink', glob($emailPath));

            $sender->send();
            $activeUsers = User::find()->where(['id'=>11])->count();
            expect('В папке сообщений должно появиться столько сообщений, сколько активных пользователей',
                count(glob($emailPath)))->equals($activeUsers);

        });
        $configureModelEvent->unlinkAll('users', true);
    }
}