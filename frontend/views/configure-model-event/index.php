<?php

use yii\helpers\Html;
use kartik\grid\GridView as Grid;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\web\JsExpression;

/* @var $this yii\web\View */
/* @var $searchModel frontend\models\search\ConfigureModelEventSearch */
/* @var $dataProvider yii\data\ActiveDataProvider */


$url = Url::to('/event-class/event-class-list');

$initScript = <<< SCRIPT
            function (element, callback) {
                var id=\$(element).val();
                if (id !== "") {
                    var result = [];
                    window.alert('start!');
                    jQuery.each(id, function(i, val){
                        $.ajax("{$url}?id=" + val, {
                            dataType: "json"
                        }).done(function(data) { result.push(data.results) });
                    });
                    callback(result);
                }
            }
            
SCRIPT;

$this->title = Yii::t('app', 'Configure Model Events');
$this->params['breadcrumbs'][] = $this->title;
$heading = '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> ' . $this->title . '</h3>';
$columns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'contentOptions' => ['class' => 'kartik-sheet-style'],
        'width' => '5%',
        'header' => '',
        'headerOptions' => ['class' => 'kartik-sheet-style']
    ],
    [
        'class'=>'kartik\grid\CheckboxColumn',
        'headerOptions'=>['class'=>'kartik-sheet-style'],
    ],
    [
        'attribute' => 'classNameEventName',
        'value' => 'eventClass.classNameEventName',
        'filterType'=>Grid::FILTER_SELECT2,
        'filter'=>'[]',//ArrayHelper::map(\frontend\models\EventClass::find()->select(['max(id) AS id', 'class_name'])->orderBy('class_name')->groupBy('class_name')->asArray()->all(), 'id', 'class_name'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>[
                'allowClear'=>true,
                'minimumInputLength' => 3,
                /*'language' => [
                    'errorLoading' => new JsExpression("function () { return 'Waiting for results...'; }"),
                ],*/
                'ajax' => [
                    'url' => Url::to('/event-class/event-class-list'),
                    'dataType' => 'json',
                    'data' => new JsExpression('function(params) { return {q:params.term}; }')
                ],
                'escapeMarkup' => new JsExpression('function (markup) { return markup; }'),
                'templateResult' => new JsExpression('function(city) { return city.text; }'),
                'templateSelection' => new JsExpression('function (city) { return city.text; }'),
                //'initSelection' => new JsExpression($initScript),
                'initialize' => true,


            ],
            'initValueText' => $eventInitValues
        ],
        'filterInputOptions'=>['placeholder'=>'Any author', 'multiple' => true, 'initValueText' => $eventInitValues],
        'format'=>'raw'
    ],
    'name',
    'description:ntext',
    [
        'attribute' => 'sender',
        'value' => 'sender.email',
        'filterType'=>Grid::FILTER_SELECT2,
        'filter'=>ArrayHelper::map(\common\models\User::find()->orderBy('email')->asArray()->all(), 'id', 'email'),
        'filterWidgetOptions'=>[
            'pluginOptions'=>['allowClear'=>true],
        ],
        'filterInputOptions'=>['placeholder'=>'Any author', 'multiple' => true],
        'format'=>'raw'
    ],
    'for_all:boolean',
    'message_text:ntext',
    'message_header:ntext',

    ['class' => 'yii\grid\ActionColumn'],
];

?>
<div class="configure-model-event-index">
    <?php  //echo $this->render('_search', ['model' => $searchModel]); ?>
    <?= Grid::widget([
        'dataProvider' => $dataProvider,
        'filterModel' => $searchModel,
        'columns' => $columns,
        'containerOptions' => ['style' => 'overflow: auto'], // only set when $responsive = false
        'headerRowOptions' => ['class' => 'kartik-sheet-style'],
        'filterRowOptions' => ['class' => 'kartik-sheet-style'],
        'pjax' => true,
        'toolbar' => [
            [
                'content' =>
                //Html::button('<i class="glyphicon glyphicon-plus"></i>', ['type'=>'button', 'title'=>Yii::t('app', 'Add Book'), 'class'=>'btn btn-success', 'onclick'=>'alert("This will launch the book creation form.\n\nDisabled for this demo!");']) . ' '.
                    Html::a(Yii::t('app', 'Create person'), ['create'], ['class' => 'btn btn-success']) . ' ' .
                    Html::a('<i class="glyphicon glyphicon-repeat"></i>', ['index'],
                        ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'Reset Grid')])
                //
            ],
            '{export}',
            '{toggleData}',
        ],
        // set export properties
        'export' => [
            'fontAwesome' => true
        ],
        // parameters from the demo form
        'bordered' => true,
        'striped' => false,
        'condensed' => false,
        'responsive' => false,
        'hover' => false,
        'showPageSummary' => false,
        'panel' => [
            'type' => Grid::TYPE_PRIMARY,
            'heading' => $heading,
            'footer' => false
        ],
        'persistResize' => false,
    ]); ?>
</div>
