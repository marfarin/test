<?php

use yii\widgets\ListView;
use yii\widgets\Pjax;
use yii\bootstrap\Html;
use kartik\form\ActiveForm;
/* @var $this yii\web\View */

$this->title = 'News';

//var_dump(\Yii::$app->getInstance());

//echo WLang::widget();
/*echo \lajax\languagepicker\widgets\LanguagePicker::widget([
    'skin' => \lajax\languagepicker\widgets\LanguagePicker::SKIN_BUTTON,
    'size' => \lajax\languagepicker\widgets\LanguagePicker::SIZE_SMALL
]);*/

?>
<?php Pjax::begin(); ?>
<div class="site-index">

    <div class="body-content">

        <div class="notification-type-search">

            <?php $form = ActiveForm::begin([
                'action' => ['index'],
                'method' => 'get',
            ]); ?>

            <?= Html::dropDownList('per-page', 3,
                array(3 => 3, 6 => 6, 9 => 9, 12 => 12, 1 => 1),
                array('id' => 'per-page')
            ) ?>

            <div class="form-group">
                <?= Html::submitButton(Yii::t('app', 'Search'), ['class' => 'btn btn-primary']) ?>
            </div>

            <?php ActiveForm::end(); ?>

        </div>

        <div class="row">
            <?=
            ListView::widget([
                'dataProvider' => $dataProvider,
                'itemView' => function ($model, $key, $index, $widget) {
                    $itemContent = $this->render('_item',['model' => $model]);

                    return $itemContent;
                },
                'pager' => [
                    'firstPageLabel' => 'First',
                    'lastPageLabel' => 'Last',
                    'maxButtonCount' => 4,
                    'options' => [
                        'class' => 'pagination col-xs-12'
                    ]
                ],
            ]);
            ?>

        </div>

    </div>
</div>
<?php Pjax::end(); ?>
