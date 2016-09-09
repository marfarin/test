<?php
use webvimark\extensions\GridPageSize\GridPageSize;
use common\components\GhostHtml;
use common\models\rbacDB\AuthItemGroup;
use common\models\rbacDB\Permission;
use common\models\ConfigureRbac;
use yii\grid\GridView;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\Pjax;
use kartik\grid\GridView as Grid;

/**
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\rbacDB\search\PermissionSearch $searchModel
 * @var yii\web\View $this
 */
$this->title = Yii::t('app', 'Permissions');
$this->params['breadcrumbs'][] = $this->title;
$heading = '<h3 class="panel-title"><i class="glyphicon glyphicon-globe"></i> ' . $this->title . '</h3>';
$columns = [
    ['class' => 'yii\grid\SerialColumn', 'options' => ['style' => 'width:10px']],
    [
        'attribute' => 'description',
        'value' => function ($model) {
            if ($model->name == ConfigureRbac::getActualConfigureRbacInstance()->common_permission_name) {
                return Html::a(
                    $model->description,
                    ['view', 'id' => $model->name],
                    ['data-pjax' => 0, 'class' => 'label label-primary']
                );
            } else {
                return Html::a($model->description, ['view', 'id' => $model->name], ['data-pjax' => 0]);
            }
        },
        'format' => 'raw',
    ],
    'name',
    [
        'attribute' => 'group_code',
        'filter' => ArrayHelper::map(AuthItemGroup::find()->asArray()->all(), 'code', 'name'),
        'value' => function (Permission $model) {
            return $model->group_code ? $model->group->name : '';
        },
    ],
    [
        'class' => 'yii\grid\ActionColumn',
        'contentOptions' => ['style' => 'width:70px; text-align:center;'],
    ],
];
?>




        <?= Grid::widget([
            'id' => 'permission_grid',
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
                        Html::a(Yii::t('app', 'Create permission'), ['create'], ['data-pjax' => 0, 'class' => 'btn btn-success']) . ' ' .
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
            ]
        ]);
