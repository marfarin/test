<?php

use Yii;
use yii\bootstrap\ActiveForm;
use yii\captcha\Captcha;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\forms\RegistrationForm $model
 */

$this->title = Yii::t('app', 'Registration');
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="user-registration">

    <h2 class="text-center"><?= $this->title ?></h2>

    <?php $form = ActiveForm::begin([
        'id' => 'user',
        'layout' => 'horizontal',
        'validateOnBlur' => false,
    ]); ?>

    <?= $form->field($model, 'username')->textInput([
        'maxlength' => 50,
        'autocomplete' => 'off',
        'autofocus' => true
    ]) ?>

    <?= $form->field($model, 'email')->textInput([
        'maxlength' => 255,
        'autocomplete' => 'off',
        'autofocus' => true
    ]) ?>

    <?= $form->field($model, 'repeat_email')->textInput([
        'maxlength' => 255,
        'autocomplete' => 'off',
        'autofocus' => true
    ]) ?>

    <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>

    <?= $form->field($model, 'captcha')->widget(Captcha::className(), [
        'template' => '<div class="row"><div class="col-sm-2">{image}</div><div class="col-sm-3">{input}</div></div>',
        'captchaAction' => ['/auth/captcha']
    ]) ?>

    <div class="form-group">
        <div class="col-sm-offset-3 col-sm-9">
            <?= Html::submitButton(
                '<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('app', 'Register'),
                ['class' => 'btn btn-primary']
            ) ?>
        </div>
    </div>

    <?php ActiveForm::end(); ?>

</div>
