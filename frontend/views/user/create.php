<?php

use Yii;
use yii\helpers\Html;

/**
 * @var yii\web\View $this
 * @var common\models\User $model
 */

$this->title = Yii::t('app', 'Create');
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="user-create">

    <h2 class="lte-hide-title"><?= Yii::t('app', 'New') . ' ' . Yii::t('app', 'user'); ?></h2>

    <?= $this->render('_form', compact('model')) ?>

</div>
