<?php

use Yii;
use yii\helpers\Html;
use yii\widgets\DetailView;

/**
 * @var yii\web\View $this
 * @var common\models\UserVisitLog $model
 */

$this->title = $model->id;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Visit log'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-visit-log-view">


    <div class="panel panel-default">
        <div class="panel-body">
            <h2 class="lte-hide-title"><?= Yii::t('app', 'Visit log') . ' #' . $model->id ?></h2>
            <?= DetailView::widget([
                'model' => $model,
                'attributes' => [
                    [
                        'attribute' => 'user_id',
                        'value' => @$model->user->username,
                    ],
                    'ip',
                    'language',
                    'os',
                    'browser',
                    'user_agent',
                    'visit_time:datetime',
                ],
            ]) ?>

        </div>
    </div>
</div>
