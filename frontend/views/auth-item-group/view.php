<?php

use Yii;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\rbacDB\AuthItemGroup $model
 */

$this->title = $model->name;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permission groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-group-view">

    <h2 class="lte-hide-title"><?= Yii::t('app', '«{group}» permission group', ['group'=>$model->name]) ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <p>
                <?= Html::a(
                    Yii::t('app', 'Edit'),
                    ['update', 'id' => $model->code],
                    ['class' => 'btn btn-sm btn-primary']
                ) ?>
                <?= Html::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
                <?= Html::a(Yii::t('app', 'Delete'), ['delete', 'id' => $model->code], [
                    'class' => 'btn btn-sm btn-danger pull-right',
                    'data' => [
                        'confirm' => Yii::t('app', 'Are you sure you want to delete this item?'),
                        'method' => 'post',
                    ],
                ]) ?>
            </p>

            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    'name',
                    'code',
                    'created_at:datetime',
                    'updated_at:datetime',
                ],
            ]) ?>

        </div>
    </div>
</div>
