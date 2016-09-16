<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 16.09.16
 * Time: 1:58
 */

return [
    'create_user' => [
        'id' => 1,
        'class_name' => 'common\models\User',
        'event_name' => 'beforeInsert',
    ],
    'update_user' => [
        'id' => 2,
        'class_name' => 'common\models\User',
        'event_name' => 'beforeUpdate',
    ],
    'delete_user' => [
        'id' => 3,
        'class_name' => 'common\models\User',
        'event_name' => 'beforeDelete',
    ],
    'create_news' => [
        'id' => 4,
        'class_name' => 'frontend\models\News',
        'event_name' => 'beforeInsert',
    ]
];