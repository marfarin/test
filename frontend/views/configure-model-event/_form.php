<?php

use kartik\widgets\DepDrop;
use kartik\widgets\Select2;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\web\JsExpression;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model frontend\models\ConfigureModelEvent */
/* @var $form yii\widgets\ActiveForm */
/* @var $default_data array */
/* @var $default_data_users */

\frontend\assets\ConfigureModelEventAsset::register($this);

$processResults = <<< SCRIPT
function (data) {
    return {
        results: $.map(data.results, function (item) {
            return {
                text: item.text,
                id: item.id
            }
        })
    };
}

SCRIPT;

$url = Url::to('/user/user-list');

$initScript = <<< SCRIPT
            function(element, callback) {
                var id;
                id = $(element).val();
                if (id !== "") {
                    return $.ajax({
                        url: "{$url}",
                        type: "GET",
                        dataType: "json",
                        data: {
                            id: id
                        }
                    }).done(function(data) {
                        var results;
                        results = [];
                        results.push({
                            id: data.results.id,
                            text: data.results.text
                        });
                        callback(results[0]);
                    });
                }
            }
            
SCRIPT;

$urlRole = Url::to('/role/role-list');

$initRoleScript = <<< SCRIPT
            function (element, callback) {
                var id=\$(element).val();
                if (id !== "") {
                    var result = [];
                    jQuery.each(id, function(i, val){
                        $.ajax("{$urlRole}?id=" + val, {
                            dataType: "json"
                        }).done(function(data) { result.push(data.results) });
                    });
                    callback(result);
                }
            }
            
SCRIPT;

$urlNotificationType = Url::to('/notification-type/ajax-notification-type-list');
$initNotificationTypeScript = <<< SCRIPT
            function (element, callback) {
                var id=\$(element).val();
                if (id !== "") {
                    var result = [];
                    jQuery.each(id, function(i, val){
                        $.ajax("{$urlNotificationType}?id=" + val, {
                            dataType: "json"
                        }).done(function(data) { result.push(data.results) });
                    });
                    callback(result);
                }
            }
            
SCRIPT;


$userFields = (new \common\models\User())->attributeLabels();
$senderName = empty($model->from) ? '' : \common\models\User::findOne($model->from)->username;
?>

<div class="configure-model-event-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'name')->textInput(['maxlength' => true]) ?>

    <?= $form->field($model, 'description')->textarea(['rows' => 6]) ?>

    <?= $form->field($model, 'from')->textInput()->widget(Select2::className(), [
        //'initValueText' => $cityDesc, // set the initial display text
        'id' => 'sender_id',
        'initValueText' => $senderName,
        'options' => ['placeholder' => 'Search for a sender ...'],
        'pluginOptions' => [
            'allowClear' => false,
            'minimumInputLength' => 1,
            /*'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],*/
            'ajax' => [
                'url' => Url::to('/user/user-list'),
                'dataType' => 'json',
                'type' => 'GET',
                'data' => new JsExpression(PHP_EOL . 'function(params) { return {q:params.term}; }'),
                'processResults' => new JsExpression(PHP_EOL.$processResults),
                'cache' => false
            ],
            'escapeMarkup' => new JsExpression(PHP_EOL . 'function (markup) { return markup; }'),
            'templateResult' => new JsExpression(PHP_EOL . 'function(city) { return city.text; }'),
            'templateSelection' => new JsExpression(PHP_EOL . 'function (city) { return city.text; }'),
            //'initSelection' => new JsExpression(PHP_EOL . $initScript),
        ],
    ]) ?>

    <?= $form->field($model, 'userId')->widget(Select2::className(), [
        //'initValueText' => $cityDesc, // set the initial display text
        'options' => ['placeholder' => 'Search for a sender ...', 'multiple' => true],
        'initValueText' => $default_data_users,
        'pluginOptions' => [
            'allowClear' => false,
            'minimumInputLength' => 1,
            /*'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],*/
            'ajax' => [
                'url' => $url,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return city.text; }'),
            'templateSelection' => new JsExpression('function (city) { return city.text; }'),
            //'initSelection' => new JsExpression($initScript),
            'multiple' => true,
            //'initialize' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'roleId')->widget(Select2::className(), [
        'initValueText' => $default_data_roles, // set the initial display text
        'options' => ['placeholder' => 'Search for a sender ...', 'multiple' => true],
        'pluginOptions' => [
            'allowClear' => false,
            'minimumInputLength' => 1,
            /*'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],*/
            'ajax' => [
                'url' => $urlRole,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return city.text; }'),
            'templateSelection' => new JsExpression('function (city) { return city.text; }'),
            //'initSelection' => new JsExpression($initRoleScript),
            'multiple' => true,
            //'initialize' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'className')->textInput()->widget(Select2::className(), [
        //'initValueText' => $cityDesc, // set the initial display text
        'options' => ['placeholder' => 'Search for a sender ...'],
        'pluginOptions' => [
            'allowClear' => false,
            'minimumInputLength' => 1,
            /*'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],*/
            'ajax' => [
                'url' => Url::to('/event-class/class-list'),
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return city.text; }'),
            'templateSelection' => new JsExpression('function (city) { return city.text; }'),
            'initialize' => true,
        ],
    ]) ?>

    <?= $form->field($model, 'event_class_id')->widget(DepDrop::className(), [
        'data' => $default_data,
        'options' => ['placeholder' => 'Select ...'],
        'type' => DepDrop::TYPE_SELECT2,
        'select2Options' => ['pluginOptions' => ['allowClear' => true]],
        'pluginOptions' => [
            'depends' => ['configuremodelevent-classname'],
            'url' => Url::to(['/event-class/dep-event']),
            'params' => ['input-type-1', 'input-type-2']
            //'loadingText' => 'Loading child level 1 ...',
            //'initialize' => true,
        ]
    ]);
    ?>

    <?= $form->field($model, 'for_all')->checkbox() ?>

    <div id="copy_header_buttons" class="form-group">
        <?php
        foreach ($userFields as $key => $userField) {
            echo Html::button('ADMIN ' . $userField,
                ['class' => 'btn btn-success copy-to-header', 'value' => '{admin.' . $key . '}']);
            echo Html::button('USER ' . $userField,
                ['class' => 'btn btn-success copy-to-header', 'value' => '{user.' . $key . '}']);
        }
        ?>
    </div>
    <?= $form->field($model, 'message_header')->textarea(['rows' => 6]) ?>

    <div id="copy_text_buttons" class="form-group">
        <?php
        foreach ($userFields as $key => $userField) {
            echo Html::button('ADMIN ' . $userField,
                ['class' => 'btn btn-success copy-to-text', 'value' => '{admin.' . $key . '}']);
            echo Html::button('USER ' . $userField,
                ['class' => 'btn btn-success copy-to-text', 'value' => '{user.' . $key . '}']);
        }
        ?>
    </div>
    <?= $form->field($model, 'message_text')->textarea(['rows' => 6])->hint('') ?>

    <?= $form->field($model, 'notificationTypeId')->widget(Select2::className(), [
        'initValueText' => $default_data_notification, // set the initial display text
        'options' => [
            'placeholder' => 'Search for a sender ...',
            'multiple' => true
        ],
        'pluginOptions' => [
            'allowClear' => false,
            'minimumInputLength' => 3,
            /*'language' => [
                'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
            ],*/
            'ajax' => [
                'url' => $urlNotificationType,
                'dataType' => 'json',
                'data' => new JsExpression('function(params) { return {q:params.term}; }')
            ],
            'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
            'templateResult' => new JsExpression('function(city) { return city.text; }'),
            'templateSelection' => new JsExpression('function (city) { return city.text; }'),
            //'initSelection' => new JsExpression($initNotificationTypeScript),
            'multiple' => true,
        ],
    ]) ?>

    <div class="form-group">
        <?= Html::submitButton($model->isNewRecord ? Yii::t('app', 'Create') : Yii::t('app', 'Update'),
            ['class' => $model->isNewRecord ? 'btn btn-success' : 'btn btn-primary']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
