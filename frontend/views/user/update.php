<?php

use common\models\User;
use webvimark\extensions\BootstrapSwitch\BootstrapSwitch;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\User $model
 */

$this->title = Yii::t('app', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-update">

    <h2 class="lte-hide-title"><?= Yii::t('app', '«{user}» user', ['user'=>$model->username]) ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <?= $this->render('_form', compact('model')) ?>
        </div>
    </div>

</div>