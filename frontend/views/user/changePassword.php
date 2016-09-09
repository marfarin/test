<?php

use Yii;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\User $model
 */

$this->title = Yii::t('app', 'Change password');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->username, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = Yii::t('app', 'Change password');
?>
<div class="user-update">

    <h2 class="lte-hide-title"><?= Yii::t('app', '«{user}» user', ['user'=>$model->username]) ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <div class="user-form">

                <?php $form = ActiveForm::begin([
                    'id' => 'user',
                    'layout' => 'horizontal',
                ]); ?>

                <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>

                <?= $form->field($model, 'repeat_password')->passwordInput([
                    'maxlength' => 255,
                    'autocomplete' => 'off'
                ]) ?>


                <div class="form-group">
                    <div class="col-sm-offset-3 col-sm-9">
                        <?php if ($model->isNewRecord): ?>
                            <?= Html::submitButton(
                                '<span class="glyphicon glyphicon-plus-sign"></span> ' . Yii::t('app', 'Create'),
                                ['class' => 'btn btn-success']
                            ) ?>
                        <?php else: ?>
                            <?= Html::submitButton(
                                '<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('app', 'Save'),
                                ['class' => 'btn btn-primary']
                            ) ?>
                        <?php endif; ?>
                    </div>
                </div>

                <?php ActiveForm::end(); ?>

            </div>
        </div>
    </div>

</div>
