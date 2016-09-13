<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 06.09.16
 * Time: 18:08
 */

namespace common\helpers\NotificationHelpers;


use frontend\models\AlertUserQuery;

class SystemNotificationHelper extends AbstractNotificationHelper
{
    public function show()
    {

    }

    public function send()
    {
        $users = $this->users();
        $author = $this->configureModelEvent->sender;
        foreach ($users as $user) {
            $notification = new AlertUserQuery();
            $notification->recipient_id = $user->id;
            $notification->sender_id = $author->id;
            $notification->header = $this->getHeader($user);
            $notification->text = $this->getText($user);
            $notification->save();
        }
    }

    public function showed()
    {
        // TODO: Implement showed() method.
    }
}