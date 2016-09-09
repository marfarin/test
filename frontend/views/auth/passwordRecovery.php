<?php

use Yii;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\forms\PasswordRecoveryForm $model
 */

$this->title = Yii::t('app', 'Password recovery');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="password-recovery">

    <h2 class="text-center"><?= $this->title ?></h2>

    <?php if (Yii::$app->session->hasFlash('error')): ?>
        <div class="alert-alert-warning text-center">
            <?= Yii::$app->session->getFlash('error') ?>
        </div>
    <?php endif; ?>

    <?php $form = ActiveForm::begin([
        'id' => 'user',
        'layout' => 'horizontal',
        'validateOnBlur' => false,
    ]); ?>

    <?= $form->field($model, 'email')->textInput(['maxlength' => 255, 'autofocus' => true]) ?>

    <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-sm-2">{image}</div><div class="col-sm-3">{input}</div></div>',
        'captchaAction' => ['/auth/captcha']
    ]) ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?= Html::submitButton(
                '<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('app', 'Recover'),
                ['class' => 'btn btn-primary']
            ) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
