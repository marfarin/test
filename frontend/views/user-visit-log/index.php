<?php

use webvimark\extensions\DateRangePicker\DateRangePicker;
use yii\helpers\Html;
use yii\widgets\Pjax;
use webvimark\extensions\GridPageSize\GridPageSize;
use yii\grid\GridView;
use kartik\grid\GridView as Grid;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\UserVisitLogSearch $searchModel
 */

$this->title = Yii::t('app', 'Visit log');
$this->params['breadcrumbs'][] = $this->title;
$heading = '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> ' . $this->title . '</h3>';
$columns = [
    ['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width:10px']],
    [
        'attribute' => 'user_id',
        'value' => function ($model) {
            return Html::a(
                @$model->user->username,
                ['view', 'id' => $model->id],
                ['data-pjax' => 0]
            );
        },
        'format' => 'raw',
    ],
    'language',
    'os',
    'browser',
    [
        'attribute' => 'ip',
        'value' => function ($model) {
            return Html::a($model->ip, "http://ipinfo.io/" . $model->ip, ["target" => "_blank"]);
        },
        'format' => 'raw',
    ],
    [
        'class' => '\kartik\grid\DataColumn',
        'attribute' => 'visit_time',
        'pageSummary' => false,
        'filterType' => Grid::FILTER_DATE_RANGE,
        'format' => ['date', 'php:d.m.Y H:i:s']
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'template' => '{view}',
        'contentOptions' => ['style' => 'width:70px; text-align:center;'],
    ],
];
?>

<?= Grid::widget([
    'id' => 'role_grid',
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
                Html::a(
                    '<i class="glyphicon glyphicon-repeat"></i>',
                    ['index'],
                    ['data-pjax' => 1, 'class' => 'btn btn-default', 'title' => Yii::t('app', 'Reset grid')]
                )
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
    ],
    'persistResize' => false,
    'toggleDataOptions' => [
        'confirmMsg' => Yii::t(
            'app',
            'There {totalCount, plural, ' .
            '=0{ is no records.} ' .
            '=1{ is one record. Are you sure you want to display it?}' .
            'other{are # records. Are you sure you want to display them all?}' .
            '}',
            ['totalCount' => $dataProvider->getTotalCount()]
        )
    ],
]);
