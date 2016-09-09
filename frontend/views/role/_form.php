<?php
/**
 * @var yii\widgets\ActiveForm $form
 * @var common\models\rbacDB\Role $model
 */
use common\models\rbacDB\AuthItemGroup;
use Yii;
use yii\bootstrap\ActiveForm;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

?>

<?php $form = ActiveForm::begin([
    'id' => 'role-form',
    'layout' => 'horizontal',
    'validateOnBlur' => false,
]) ?>

<?= $form->field($model, 'description')->textInput([
    'maxlength' => 255,
    'autofocus' => $model->isNewRecord ? true : false
]) ?>

<?= $form->field($model, 'name')->textInput(['maxlength' => 64]) ?>


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
<?php ActiveForm::end() ?>