<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 16.09.16
 * Time: 0:57
 */

namespace tests\codeception\common\fixtures;

use yii\test\ActiveFixture;

class ConfigureModelEventFixture extends ActiveFixture
{
    public $modelClass = 'frontend\models\ConfigureModelEvent';

    public $depends = [
        'tests\codeception\common\fixtures\UserFixture',
        'tests\codeception\common\fixtures\EventClassFixture'
    ];
}