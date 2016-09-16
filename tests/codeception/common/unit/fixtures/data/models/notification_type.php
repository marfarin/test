<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 16.09.16
 * Time: 1:31
 */

return [
    'notification_type_1' => [
        'id' => 1,
        'class_name' => 'common\helpers\NotificationHelpers\SystemNotificationHelper',
        'name' => 'System',
        'description' => 'System'

    ],
    'notification_type_2' => [
        'id' => 2,
        'class_name' => 'common\helpers\NotificationHelpers\EmailNotificationHelper',
        'name' => 'Email',
        'description' => 'Email'
    ]
];