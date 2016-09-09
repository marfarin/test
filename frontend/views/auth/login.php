<?php
/**
 * @var $this yii\web\View
 * @var $model common\models\forms\LoginForm
 */

use common\components\GhostHtml;
use yii\bootstrap\ActiveForm;
use yii\helpers\Html;

?>

    <div class="container" id="login-wrapper">
        <div class="row">
            <div class="col-md-4 col-md-offset-4">
                <div class="panel panel-default">
                    <div class="panel-heading">
                        <h3 class="panel-title"><?= Yii::t('app', 'Authorization') ?></h3>
                    </div>
                    <div class="panel-body">

                        <?php $form = ActiveForm::begin([
                            'id' => 'login-form',
                            'options' => ['autocomplete' => 'off'],
                            'validateOnBlur' => false,
                            'fieldConfig' => [
                                'template' => "{input}\n{error}",
                            ],
                        ]) ?>

                        <?= $form->field($model, 'username')
                            ->textInput([
                                'placeholder' => $model->getAttributeLabel('username'),
                                'autocomplete' => 'off'
                            ]) ?>

                        <?= $form->field($model, 'password')
                            ->passwordInput([
                                'placeholder' => $model->getAttributeLabel('password'),
                                'autocomplete' => 'off'
                            ]) ?>

                        <?= $form->field($model, 'rememberMe')->checkbox(['value' => true]) ?>

                        <?= Html::submitButton(
                            Yii::t('app', 'Login'),
                            ['class' => 'btn btn-lg btn-primary btn-block']
                        ) ?>

                        <div class="row registration-block">
                            <div class="col-sm-6">
                                <?= GhostHtml::a(
                                    Yii::t('app', 'Registration'),
                                    ['/auth/registration']
                                ) ?>
                            </div>
                            <div class="col-sm-6 text-right">
                                <?= GhostHtml::a(
                                    Yii::t('app', 'Forgot password?'),
                                    ['/auth/password-recovery']
                                ) ?>
                            </div>
                        </div>


                        <?php ActiveForm::end() ?>
                    </div>
                </div>
            </div>
        </div>
    </div>

<?php
$css = <<<CSS
html, body {
	appground: #eee;
	-webkit-box-shadow: inset 0 0 100px rgba(0,0,0,.5);
	box-shadow: inset 0 0 100px rgba(0,0,0,.5);
	height: 100%;
	min-height: 100%;
	position: relative;
}
#login-wrapper {
	position: relative;
	top: 30%;
}
#login-wrapper .registration-block {
	margin-top: 15px;
}
CSS;

$this->registerCss($css);
?>