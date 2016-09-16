<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 06.09.16
 * Time: 18:08
 */

namespace common\helpers\NotificationHelpers;

class EmailNotificationHelper extends AbstractNotificationHelper
{
    public function send()
    {
        $users = $this->users;
        $author = $this->configureModelEvent->sender;
        foreach ($users as $user) {
            if ($user->notificationTypeId) {
                $htmlBody = $this->getText($user);
                \Yii::$app->mailer->compose()
                    ->setFrom($author->email)
                    ->setTo($user->email)
                    ->setSubject($this->getHeader($user))
                    ->setTextBody(preg_replace('/<[^>]+>/', '', $htmlBody))
                    ->setHtmlBody($htmlBody)
                    ->send();
            }
        }
    }

    protected function show()
    {

    }

    protected function showed()
    {
        // TODO: Implement showed() method.
    }

}