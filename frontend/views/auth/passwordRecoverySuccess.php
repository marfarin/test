<?php

use Yii;

/**
 * @var yii\web\View $this
 */

$this->title = Yii::t('app', 'Password recovery');
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="password-recovery-success">

    <div class="alert alert-success text-center">
        <?= Yii::t('app', 'Check your E-mail for further instructions') ?>
    </div>

</div>
