<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 11.04.16
 * Time: 14:57
 */

namespace frontend\assets;

use dmstr\web\AdminLteAsset;

class ExtendedAdminLteAsset extends AdminLteAsset
{
    public $depends = [
        'rmrevin\yii\fontawesome\AssetBundle',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'yii\bootstrap\BootstrapPluginAsset',
    ];
}