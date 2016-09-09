<?php
/**
 * @var yii\widgets\ActiveForm $form
 * @var array $childRoles
 * @var array $allRoles
 * @var array $routes
 * @var array $currentRoutes
 * @var array $permissionsByGroup
 * @var array $currentPermissions
 * @var yii\rbac\Role $role
 */

use common\components\GhostHtml;
use common\models\rbacDB\Role;
use Yii;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;

$this->title = $role->description;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Roles'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h2 class="lte-hide-title"><?= Yii::t('app', '«{role}» role', ['role'=>$role->description]); ?></h2>

<?php if (Yii::$app->session->hasFlash('success')): ?>
    <div class="alert alert-success text-center">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

    <p>
        <?= GhostHtml::a(
            Yii::t('app', 'Edit'),
            ['update', 'id' => $role->name],
            ['class' => 'btn btn-sm btn-primary']
        ) ?>
        <?= GhostHtml::a(Yii::t('app', 'Create'), ['create'], ['class' => 'btn btn-sm btn-success']) ?>
    </p>

    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span> <?= Yii::t('app', 'Child roles') ?>
                    </strong>
                </div>
                <div class="panel-body">
                    <?= Html::beginForm(['set-child-roles', 'id' => $role->name]) ?>

                    <?php foreach ($allRoles as $aRole): ?>
                        <label>
                            <?php $isChecked = in_array(
                                $aRole['name'],
                                ArrayHelper::map($childRoles, 'name', 'name')
                            ) ? 'checked' : '' ?>
                            <input type="checkbox" <?= $isChecked ?> name="child_roles[]" value="<?= $aRole['name'] ?>">
                            <?= $aRole['description'] ?>
                        </label>

                        <?= GhostHtml::a(
                            '<span class="glyphicon glyphicon-edit"></span>',
                            ['/role/view', 'id' => $aRole['name']],
                            ['target' => '_blank']
                        ) ?>
                        <br/>
                    <?php endforeach ?>


                    <hr/>
                    <?= Html::submitButton(
                        '<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('app', 'Save'),
                        ['class' => 'btn btn-primary btn-sm']
                    ) ?>

                    <?= Html::endForm() ?>
                </div>
            </div>
        </div>

        <div class="col-sm-8">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span> <?= Yii::t('app', 'Permissions') ?>
                    </strong>
                </div>
                <div class="panel-body">
                    <?= Html::beginForm(['set-child-permissions', 'id' => $role->name]) ?>

                    <div class="row">
                        <?php foreach ($permissionsByGroup as $groupName => $permissions): ?>
                            <div class="col-sm-6">
                                <fieldset>
                                    <legend><?= $groupName ?></legend>

                                    <?php foreach ($permissions as $permission): ?>
                                        <label>
                                            <?php $isChecked = in_array(
                                                $permission->name,
                                                ArrayHelper::map(
                                                    $currentPermissions,
                                                    'name',
                                                    'name'
                                                )
                                            ) ? 'checked' : '' ?>
                                            <input type="checkbox" <?= $isChecked ?> name="child_permissions[]"
                                                   value="<?= $permission->name ?>">
                                            <?= $permission->description ?>
                                        </label>

                                        <?= GhostHtml::a(
                                            '<span class="glyphicon glyphicon-edit"></span>',
                                            ['/permission/view', 'id' => $permission->name],
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
    </div>

<?php
$this->registerJs(<<<JS

$('.role-help-btn').off('mouseover mouseleave')
	.on('mouseover', function(){
		var _t = $(this);
		_t.popover('show');
	}).on('mouseleave', function(){
		var _t = $(this);
		_t.popover('hide');
	});
JS
);
