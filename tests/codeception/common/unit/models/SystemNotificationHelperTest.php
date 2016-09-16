<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 15.09.16
 * Time: 22:46
 */

namespace codeception\common\unit\models;

use Codeception\Specify;
use tests\codeception\common\fixtures\AlertUserQueryFixture;
use tests\codeception\common\unit\DbTestCase;
use tests\codeception\common\fixtures\ConfigureModelEventFixture;
use frontend\models\NotificationType;
use frontend\models\ConfigureModelEvent;
use common\models\User;
use frontend\models\AlertUserQuery;
use common\helpers\NotificationHelpers\SenderFactory;

class SystemNotificationHelperTest extends DbTestCase
{

    use Specify;

    public function fixtures(){
        return [
            'configureModelEvents' => ConfigureModelEventFixture::className(),
            'alertUserQuery' => AlertUserQueryFixture::className()
        ];
    }

    public function testSend(){
        $notificationType = NotificationType::findOne(1);
        $configureModelEvent = ConfigureModelEvent::findOne(1);
        $user = User::findOne(11);
        $configureModelEvent->link('users', $user);
        $model = User::findOne(12);
        $sender = SenderFactory::getSender($notificationType, $configureModelEvent, $model);
        $this->specify('Проверка корректности отправки сообщения', function() use ($sender, $configureModelEvent, $user, $model){
            //очищаем выходную папку сообщений
            $emailPath = \Yii::$app->basePath . '\runtime\mail\*';
            array_map('unlink', glob($emailPath));
            $sender->send();
            $messages = AlertUserQuery::find()->all();
            expect('В сообщениях должна быть одна запись', count($messages))->equals(1);
            $message=$messages[0];
            expect('Проверка заголовка сообщения', $message->title)
                ->equals($configureModelEvent->sender->username.$user->username.$model->username);
            expect('Проверка текста сообщения', $message->txt)
                ->equals($configureModelEvent->sender->username.$user->username.$model->username);
            expect('Проверка отправителя', $message->from_user_id)
                ->equals($configureModelEvent->from);
            expect('Проверка адресата', $message->to_user_id)
                ->equals($user->id);
            expect('Сообщение не должно быть прочитаным', $message->readed_at)
                ->null();

        });
        $configureModelEvent->unlinkAll('users', true);
    }
}