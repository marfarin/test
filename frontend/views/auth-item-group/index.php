<?php

use common\components\GhostHtml;
use yii\helpers\Html;
use yii\helpers\Url;
use yii\helpers\ArrayHelper;
use yii\widgets\Pjax;
use webvimark\extensions\GridBulkActions\GridBulkActions;
use webvimark\extensions\GridPageSize\GridPageSize;
use yii\grid\GridView;
use kartik\grid\GridView as Grid;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\rbacDB\search\AuthItemGroupSearch $searchModel
 */

$this->title = Yii::t('app', 'Permission groups');
$this->params['breadcrumbs'][] = $this->title;
$heading = '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> ' . $this->title . '</h3>';
$columns = [
    [
        'class' => 'kartik\grid\SerialColumn',
        'options' => ['style' => 'width:10px']
    ],
    [
        'attribute' => 'name',
        'value' => function ($model) {
            return Html::a($model->name, ['update', 'id' => $model->code], ['data-pjax' => 0]);
        },
        'format' => 'raw',
    ],
    'code',
    ['class' => 'yii\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
    [
        'class' => 'yii\grid\ActionColumn',
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
                Html::a(Yii::t('app', 'Create permission group'), ['create'], ['data-pjax' => 0, 'class' => 'btn btn-success']) . ' ' .
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
        'footer' => false
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
]); ?>
