<?php

use yii\helpers\Html;


/* @var $this yii\web\View */
/* @var $model frontend\models\ConfigureModelEvent */

$this->title = Yii::t('app', 'Create Configure Model Event');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Configure Model Events'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="configure-model-event-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'default_data' => []
    ]) ?>

</div>
