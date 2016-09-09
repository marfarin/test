<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 06.09.16
 * Time: 18:08
 */

namespace common\helpers\NotifiactionHelpers;


use common\helpers\NotificationHelpers\AbstractNotificationHelper;
use yii\db\ActiveRecordInterface;

class EmailNotificationHelper extends AbstractNotificationHelper
{
    public function send()
    {
        $users = $this->users();
        $model=$params['model'];
        $notification=$params['notification'];
        $author = $this->configureModelEvent->sender;
        foreach($users as $user){
            $htmlBody = $this->getText($user);
            \Yii::$app->mailer->compose()
                ->setFrom($author->email)
                ->setTo($user->email)
                ->setSubject($this->getHeader($user))
                ->setTextBody(preg_replace('/<[^>]+>/','',$htmlBody))
                ->setHtmlBody($htmlBody)
                ->send();
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