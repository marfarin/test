<?php
/**
 * @var yii\widgets\ActiveForm $form
 * @var common\models\rbacDB\Permission $model
 */

use Yii;

$this->title = Yii::t('app', 'Edit');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->description, 'url' => ['view', 'id' => $model->name]];
$this->params['breadcrumbs'][] = $this->title;

?>

<h2 class="lte-hide-title"><?= Yii::t('app', '«{permission}» permission', ['permission'=>$model->description]) ?></h2>

<div class="panel panel-default">
    <div class="panel-body">
        <?= $this->render('_form', [
            'model' => $model,
        ]) ?>
    </div>
</div>