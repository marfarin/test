<?php

use Yii;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\rbacDB\AuthItemGroup $model
 */

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permission groups'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="auth-item-group-create">

    <h2 class="lte-hide-title"><?= Yii::t('app', 'New') . ' ' . Yii::t('app', 'permission group'); ?></h2>

    <div class="panel panel-default">
        <div class="panel-body">

            <?= $this->render('_form', compact('model')) ?>
        </div>
    </div>

</div>
