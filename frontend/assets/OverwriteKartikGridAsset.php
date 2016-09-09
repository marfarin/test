<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 19.04.16
 * Time: 16:12
 */

namespace frontend\assets;

use kartik\grid\GridViewAsset;

class OverwriteKartikGridAsset extends GridViewAsset
{
    public $depends = [
        'yii\web\JqueryAsset',
        'yii\web\YiiAsset',
        'yii\bootstrap\BootstrapAsset',
        'dmstr\web\AdminLteAsset',
    ];
}