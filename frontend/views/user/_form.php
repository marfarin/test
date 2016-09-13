<?php

use common\models\User;
use Yii;
use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use webvimark\extensions\BootstrapSwitch\BootstrapSwitch;

/**
 * @var yii\web\View $this
 * @var common\models\User $model
 * @var yii\bootstrap\ActiveForm $form
 */
?>

    <div class="user-form">

        <?php $form = ActiveForm::begin([
            'id' => 'user',
            'layout' => 'horizontal',
            'validateOnBlur' => false,
        ]); ?>

        <?= $form->field($model->loadDefaultValues(), 'status')
            ->dropDownList(User::getStatusList()) ?>

        <?= $form->field($model, 'username')->textInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>

        <?php if ($model->isNewRecord): ?>

            <?= $form->field($model, 'password')->passwordInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>

            <?= $form->field($model, 'repeat_password')->passwordInput(['maxlength' => 255, 'autocomplete' => 'off']) ?>
        <?php endif; ?>


        <?php if (User::hasPermission('bindUserToIp')):?>

            <?= $form->field($model, 'bind_to_ip')
                ->textInput(['maxlength' => 255])
                ->hint(Yii::t('app', 'For example:') . Yii::t('app', ' 123.34.56.78, 168.111.192.12')); ?>

        <?php endif; ?>

        <?php if (User::hasPermission('editUserEmail')): ?>

            <?= $form->field($model, 'email')->textInput(['maxlength' => 255]) ?>
            <?= $form->field($model, 'email_confirmed')->checkbox() ?>

        <?php endif; ?>


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

<?php BootstrapSwitch::widget() ?>