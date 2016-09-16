<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 09.09.16
 * Time: 12:11
 */

use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

$this->title = Yii::t('app', 'Set notification type');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <div class="user-form">
        <?php $form = ActiveForm::begin([
            'id' => 'user',
            'layout' => 'horizontal',
            'validateOnBlur' => false,
        ]); ?>

        <?= $form->field($model, 'notificationTypeId')->widget(\kartik\widgets\Select2::className(), [
            'data' => $data,
            'maintainOrder' => true,
            'toggleAllSettings' => [
                'selectLabel' => '<i class="glyphicon glyphicon-ok-circle"></i> Tag All',
                'unselectLabel' => '<i class="glyphicon glyphicon-remove-circle"></i> Untag All',
                'selectOptions' => ['class' => 'text-success'],
                'unselectOptions' => ['class' => 'text-danger'],
            ],
            'options' => ['placeholder' => 'Select a color ...', 'multiple' => true],
            'pluginOptions' => [
                'tags' => true,
                'maximumInputLength' => 10
            ],
        ]); ?>

        <?= Html::submitButton(
            '<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('app', 'Save'),
            ['class' => 'btn btn-primary']
        ) ?>

        
        <?php ActiveForm::end(); ?>
    </div>


</div>