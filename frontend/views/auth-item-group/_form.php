<?php

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;

/**
 * @var yii\web\View $this
 * @var common\models\rbacDB\AuthItemGroup $model
 * @var yii\bootstrap\ActiveForm $form
 */
?>
<div class="auth-item-group-form">

    <?php $form = ActiveForm::begin([
        'id' => 'auth-item-group-form',
        'layout' => 'horizontal',
        'validateOnBlur' => false,

    ]); ?>

    <?= $form->field($model, 'name')->textInput([
        'maxlength' => 255,
        'autofocus' => $model->isNewRecord ? true : false
    ]) ?>

    <?= $form->field($model, 'code')->textInput(['maxlength' => 64]) ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?php
            if ($model->isNewRecord) {
                echo Html::submitButton(
                    '<span class="glyphicon glyphicon-plus-sign"></span> ' . Yii::t('app', 'Create'),
                    ['class' => 'btn btn-success']
                );
            } else {
                echo Html::submitButton(
                    '<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('app', 'Save'),
                    ['class' => 'btn btn-primary']
                );
            }
            ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>

