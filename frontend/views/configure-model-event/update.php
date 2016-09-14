<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model frontend\models\ConfigureModelEvent */
/**
 * @var $default_data array
 * @var $default_data_users array
 */

$this->title = Yii::t('app', 'Update {modelClass}: ', [
    'modelClass' => 'Configure Model Event',
]) . $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Configure Model Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Update');
?>
<div class="configure-model-event-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'default_data' => $default_data,
        'default_data_users' => $default_data_users,
        'default_data_roles' => $default_data_roles,
        'default_data_notification' => $default_data_notification
    ]) ?>

</div>
