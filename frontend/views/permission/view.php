<?php
/**
 * @var $this yii\web\View
 * @var yii\widgets\ActiveForm $form
 * @var array $routes
 * @var array $childRoutes
 * @var array $permissionsByGroup
 * @var array $childPermissions
 * @var yii\rbac\Permission $item
 */

use common\components\GhostHtml;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = $item->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Permissions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h2 class="lte-hide-title"><?= Yii::t('app', '«{permission}» permission', ['permission'=>$item->description]); ?></h2>


<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success text-center">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

    <p>
        <?= GhostHtml::a(
            Yii::t('app', 'Edit'),
            ['update', 'id' => $item->name],
            ['class' => 'btn btn-sm btn-primary']
        ) ?>
        <?= GhostHtml::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
    </p>

    <div class="row">
        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span> <?= Yii::t('app', 'Child permissions') ?>
                    </strong>
                </div>
                <div class="panel-body">

                    <?= Html::beginForm(['set-child-permissions', 'id' => $item->name]) ?>

                    <div class="row">
                        <?php foreach ($permissionsByGroup as $groupName => $permissions): ?>
                            <div class="col-sm-6">
                                <fieldset>
                                    <legend><?= $groupName ?></legend>

                                    <?php foreach ($permissions as $permission): ?>
                                        <label>
                                            <?php $isChecked = in_array(
                                                $permission->name,
                                                ArrayHelper::map($childPermissions, 'name', 'name')
                                            ) ? 'checked' : '' ?>
                                            <input type="checkbox" <?= $isChecked ?> name="child_permissions[]"
                                                   value="<?= $permission->name ?>">
                                            <?= $permission->description ?>
                                        </label>

                                        <?= GhostHtml::a(
                                            '<span class="glyphicon glyphicon-edit"></span>',
                                            ['view', 'id' => $permission->name],
                                            ['target' => '_blank']
                                        ) ?>
                                        <br/>
                                    <?php endforeach ?>

                                </fieldset>
                                <br/>
                            </div>


                        <?php endforeach ?>
                    </div>


                    <hr/>
                    <?= Html::submitButton(
                        '<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('app', 'Save'),
                        ['class' => 'btn btn-primary btn-sm']
                    ) ?>

                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>

        <div class="col-sm-6">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span> <?= Yii::t('app', 'Routes') ?>

                        <?= Html::a(
                            Yii::t('app', 'Refresh routes') . ' ' . Yii::t('app', '(and delete unused)'),
                            ['refresh-routes', 'id' => $item->name, 'deleteUnused' => 1],
                            [
                                'class' => 'btn btn-default btn-sm pull-right',
                                'style' => 'margin-top:-5px; text-transform:none;',
                                'data-confirm' => Yii::t(
                                    'app',
                                    'Routes that are not exists in this application will be deleted. Do not recommended for application with "advanced" structure, because frontend and append have they own set of routes.'
                                ),
                            ]
                        ) ?>

                        <?= Html::a(
                            Yii::t('app', 'Refresh routes'),
                            ['refresh-routes', 'id' => $item->name],
                            [
                                'class' => 'btn btn-default btn-sm pull-right',
                                'style' => 'margin-top:-5px; text-transform:none;',
                            ]
                        ) ?>


                    </strong>
                </div>

                <div class="panel-body">

                    <?= Html::beginForm(['set-child-routes', 'id' => $item->name]) ?>

                    <div class="row">
                        <div class="col-sm-3">
                            <?= Html::submitButton(
                                '<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('app', 'Save'),
                                ['class' => 'btn btn-primary btn-sm']
                            ) ?>
                        </div>

                        <div class="col-sm-6">
                            <input id="search-in-routes" autofocus="on" type="text" class="form-control input-sm"
                                   placeholder=<?= Yii::t('app', 'Search...')?>>
                        </div>

                        <div class="col-sm-3 text-right">
                            <span id="show-only-selected-routes" class="btn btn-default btn-sm">
                                <i class="fa fa-minus"></i> <?= Yii::t('app', 'Show only selected') ?>
                            </span>
                            <span id="show-all-routes" class="btn btn-default btn-sm hide">
                                <i class="fa fa-plus"></i> <?= Yii::t('app', 'Show all') ?>
                            </span>

                        </div>
                    </div>

                    <hr/>

                    <?= Html::checkboxList(
                                'child_routes',
                                ArrayHelper::map($childRoutes, 'name', 'name'),
                                ArrayHelper::map($routes, 'name', 'name'),
                                [
                                    'id' => 'routes-list',
                                    'separator' => '<div class="separator"></div>',
                                    'item' => function ($index, $label, $name, $checked, $value) {
                                        return Html::checkbox($name, $checked, [
                                            'value' => $value,
                                            'label' => '<span class="route-text">' . $label . '</span>',
                                            'labelOptions' => ['class' => 'route-label'],
                                        'class' => 'route-checkbox'
                                        ]);
                                    },
                                ]
                            ) ?>

                    <hr/>
                    <?= Html::submitButton(
                        '<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('app', 'Save'),
                        ['class' => 'btn btn-primary btn-sm']
                    ) ?>

                    <?= Html::endForm() ?>

                </div>
            </div>
        </div>
    </div>

<?php
$js = <<<JS

var routeCheckboxes = $('.route-checkbox');
var routeText = $('.route-text');

// For checked routes
var appgroundColor = '#D6FFDE';

function showAllRoutesapp() {
	$('#routes-list').find('.hide').each(function(){
		$(this).removeClass('hide');
	});
}

//Make tree-like structure by padding controllers and actions
routeText.each(function(){
	var _t = $(this);

	var chunks = _t.html().split('/').reverse();
	var margin = chunks.length * 40 - 40;

	if ( chunks[0] == '*' )
	{
		margin -= 40;
	}

	_t.closest('label').css('margin-left', margin);

});

// Highlight selected checkboxes
routeCheckboxes.each(function(){
	var _t = $(this);

	if ( _t.is(':checked') )
	{
		_t.closest('label').css('appground', appgroundColor);
	}
});

// Change appground on check/uncheck
routeCheckboxes.on('change', function(){
	var _t = $(this);

	if ( _t.is(':checked') )
	{
		_t.closest('label').css('appground', appgroundColor);
	}
	else
	{
		_t.closest('label').css('appground', 'none');
	}
});


// Hide on not selected routes
$('#show-only-selected-routes').on('click', function(){
	$(this).addClass('hide');
	$('#show-all-routes').removeClass('hide');

	routeCheckboxes.each(function(){
		var _t = $(this);

		if ( ! _t.is(':checked') )
		{
			_t.closest('label').addClass('hide');
			_t.closest('div.separator').addClass('hide');
		}
	});
});

// Show all routes app
$('#show-all-routes').on('click', function(){
	$(this).addClass('hide');
	$('#show-only-selected-routes').removeClass('hide');

	showAllRoutesapp();
});

// Search in routes and hide not matched
$('#search-in-routes').on('change keyup', function(){
	var input = $(this);

	if ( input.val() == '' )
	{
		showAllRoutesapp();
		return;
	}

	routeText.each(function(){
		var _t = $(this);

		if ( _t.html().indexOf(input.val()) > -1 )
		{
			_t.closest('label').removeClass('hide');
			_t.closest('div.separator').removeClass('hide');
		}
		else
		{
			_t.closest('label').addClass('hide');
			_t.closest('div.separator').addClass('hide');
		}
	});
});

JS;

$this->registerJs($js);
?>