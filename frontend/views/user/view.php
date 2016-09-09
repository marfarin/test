<?php

use common\components\GhostHtml;
use common\models\rbacDB\Role;
use common\models\User;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\User $model
 */

$this->title = $model->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-view">

    <h2 class="lte-hide-title"><?= Yii::t('app', '«{user}» user', ['user'=>$this->title]); ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <p>
                <?= GhostHtml::a(
                    Yii::t('app', 'Edit'),
                    ['update', 'id' => $model->id],
                    ['class' => 'btn btn-sm btn-primary']
                ) ?>
                <?= GhostHtml::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
                <?= GhostHtml::a(
                    Yii::t('app', 'Roles and permissions'),
                    ['/user-permission/set', 'id' => $model->id],
                    ['class' => 'btn btn-sm btn-default']
                ) ?>

                <?= GhostHtml::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->id], [
                    'class' => 'btn btn-sm btn-danger pull-right',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this user?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'id',
                    [
                        'attribute' => 'status',
                        'value' => User::getStatusValue($model->status),
                    ],
                    'username',
                    [
                        'attribute' => 'email',
                        'value' => $model->email,
                        'format' => 'email',
                        'visible' => User::hasPermission('viewUserEmail'),
                    ],
                    [
                        'attribute' => 'email_confirmed',
                        'value' => $model->email_confirmed,
                        'format' => 'boolean',
                        'visible' => User::hasPermission('viewUserEmail'),
                    ],
                    [
                        'label' => Yii::t('app', 'Roles'),
                        'value' => implode('<br>',
                            ArrayHelper::map(Role::getUserRoles($model->id), 'name', 'description')),
                        'visible' => User::hasPermission('viewUserRoles'),
                        'format' => 'raw',
                    ],
                    [
                        'attribute' => 'bind_to_ip',
                        'visible' => User::hasPermission('bindUserToIp'),
                    ],
                    array(
                        'attribute' => 'registration_ip',
                        'value' => Html::a($model->registration_ip, "http://ipinfo.io/" . $model->registration_ip,
                            ["target" => "_blank"]),
                        'format' => 'raw',
                        'visible' => User::hasPermission('viewRegistrationIp'),
                    ),
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>

        </div>
    </div>
</div>
