<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 08.09.16
 * Time: 16:28
 */

namespace frontend\assets;


use yii\web\AssetBundle;

class ShowedButton extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [
        'js/showed_button.js'
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}