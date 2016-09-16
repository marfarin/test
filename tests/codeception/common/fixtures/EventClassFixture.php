<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 16.09.16
 * Time: 1:57
 */

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

class EventClassFixture extends ActiveFixture
{
    public $modelClass = 'frontend\models\EventClass';
}