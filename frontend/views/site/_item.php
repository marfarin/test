<?php
/**
 * Created by PhpStorm.
 * User: panik
 * Date: 16.09.16
 * Time: 13:04
 */

?>

<div class="col-lg-4">
    <h2>Heading</h2>

    <p><?= $model->preview ?></p>
    <?php if (!Yii::$app->user->isGuest) { ?>
    <p><?= \yii\helpers\Html::tag('a', 'Смотреть подробности', ['class' => 'btn btn-default', 'href' => \yii\helpers\Url::to(['site/view-news', 'id' => $model->id])]) ?></p>
    <?php } ?>
</div>
