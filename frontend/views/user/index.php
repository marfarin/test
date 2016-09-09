<?php

use common\components\GhostHtml;
use common\models\rbacDB\Role;
use common\models\User;
use yii\helpers\Html;
use yii\helpers\ArrayHelper;
use yii\helpers\Url;
use yii\widgets\Pjax;
use webvimark\extensions\GridBulkActions\GridBulkActions;
use webvimark\extensions\GridPageSize\GridPageSize;
use yii\grid\GridView;
use kartik\grid\GridView as Grid;

/**
 * @var yii\web\View $this
 * @var yii\data\ActiveDataProvider $dataProvider
 * @var common\models\search\UserSearch $searchModel
 */

$this->title = Yii::t('app', 'Users');
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
        'class' => 'webvimark\components\StatusColumn',
        'attribute' => 'superadmin',
        'visible' => Yii::$app->user->isSuperadmin,
    ],

    [
        'attribute' => 'username',
        'value' => function (User $model) {
            return Html::a($model->username, ['view', 'id' => $model->id], ['data-pjax' => 0]);
        },
        'format' => 'raw',
    ],
    [
        'attribute' => 'email',
        'format' => 'raw',
        'visible' => User::hasPermission('viewUserEmail'),
    ],
    [
        'class' => 'webvimark\components\StatusColumn',
        'attribute' => 'email_confirmed',
        'visible' => User::hasPermission('viewUserEmail'),
    ],
    [
        'attribute' => 'gridRoleSearch',
        'filter' => ArrayHelper::map(
            Role::getAvailableRoles(Yii::$app->user->isSuperAdmin),
            'name',
            'description'
        ),
        'value' => function (User $model) {
            return implode(', ', ArrayHelper::map($model->roles, 'name', 'description'));
        },
        'format' => 'raw',
        'visible' => User::hasPermission('viewUserRoles'),
    ],
    [
        'attribute' => 'registration_ip',
        'value' => function (User $model) {
            return Html::a(
                $model->registration_ip,
                "http://ipinfo.io/" . $model->registration_ip,
                ["target" => "_blank"]
            );
        },
        'format' => 'raw',
        'visible' => User::hasPermission('viewRegistrationIp'),
    ],
    [
        'value' => function (User $model) {
            return GhostHtml::a(
                Yii::t('app', 'Roles and permissions'),
                ['/user-permission/set', 'id' => $model->id],
                ['class' => 'btn btn-sm btn-primary', 'data-pjax' => 0]
            );
        },
        'format' => 'raw',
        'visible' => User::canRoute('/user-permission/set'),
        'options' => [
            'width' => '10px',
        ],
    ],
    [
        'value' => function (User $model) {
            return GhostHtml::a(
                Yii::t('app', 'Change password'),
                ['change-password', 'id' => $model->id],
                ['class' => 'btn btn-sm btn-default', 'data-pjax' => 0]
            );
        },
        'format' => 'raw',
        'options' => [
            'width' => '10px',
        ],
    ],
    [
        'class' => 'webvimark\components\StatusColumn',
        'attribute' => 'status',
        'optionsArray' => [
            [User::STATUS_ACTIVE, Yii::t('app', 'Active'), 'success'],
            [User::STATUS_INACTIVE, Yii::t('app', 'Inactive'), 'warning'],
            [User::STATUS_BANNED, Yii::t('app', 'Banned'), 'danger'],
        ],
    ],
    ['class' => 'yii\grid\CheckboxColumn', 'options' => ['style' => 'width:10px']],
    [
        'class' => 'yii\grid\ActionColumn',
        'contentOptions' => ['style' => 'width:70px; text-align:center;'],
    ],

    //['class' => 'yii\grid\ActionColumn'],
];
?>
<div class="user-index">

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
                            Html::a(Yii::t('app', 'Create user'), ['create'], ['class' => 'btn btn-success', 'data-pjax' => 0]) . ' ' .
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
                ]
            ]); ?>
</div>
