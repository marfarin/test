<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 19.04.16
 * Time: 16:21
 */

namespace frontend\assets;

use yii\bootstrap\BootstrapAsset;

class OverwriteBootstrapAsset extends BootstrapAsset
{
    public $depends = [
        'dmstr\web\AdminLteAsset',
    ];
}