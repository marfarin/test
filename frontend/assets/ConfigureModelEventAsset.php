<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 08.09.16
 * Time: 10:33
 */

namespace frontend\assets;

use yii\web\AssetBundle;

class ConfigureModelEventAsset extends AssetBundle
{
    public $basePath = '@webroot';
    public $baseUrl = '@web';
    public $css = [];
    public $js = [
        'js/paste_text_button.js'
    ];
    public $depends = [
        'frontend\assets\AppAsset',
    ];
}