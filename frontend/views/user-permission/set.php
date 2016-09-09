<?php
/**
 * @var yii\web\View $this
 * @var array $permissionsByGroup
 * @var \common\models\User $user
 */
use common\components\GhostHtml;
use common\models\rbacDB\Role;
use yii\bootstrap\BootstrapPluginAsset;
use yii\helpers\ArrayHelper;
use yii\helpers\Html;
BootstrapPluginAsset::register($this);
$this->title = Yii::t('app', 'Roles and permissions for user:') . ' ' . $user->username;
$this->params['breadcrumbs'][] = ['label' => Yii::t('app', 'Users'), 'url' => ['/user-management/user/index']];
$this->params['breadcrumbs'][] = $this->title;
?>

    <h2 class="lte-hide-title"><?= $this->title ?></h2>

<?php if ( Yii::$app->session->hasFlash('success') ): ?>
    <div class="alert alert-success text-center">
        <?= Yii::$app->session->getFlash('success') ?>
    </div>
<?php endif; ?>

    <div class="row">
        <div class="col-sm-4">
            <div class="panel panel-default">
                <div class="panel-heading">
                    <strong>
                        <span class="glyphicon glyphicon-th"></span> <?= Yii::t('app', 'Roles') ?>
                    </strong>
                </div>
                <div class="panel-body">

                    <?= Html::beginForm(['set-roles', 'id'=>$user->id]) ?>

                    <?php foreach (Role::getAvailableRoles() as $aRole): ?>
                        <label>
                            <?php $isChecked = in_array($aRole['name'], ArrayHelper::map(Role::getUserRoles($user->id), 'name', 'name')) ? 'checked' : '' ?>

                            <?php if (\common\models\ConfigureRbac::getActualConfigureRbacInstance()->user_can_have_multiple_roles ): ?>
                                <input type="checkbox" <?= $isChecked ?> name="roles[]" value="<?= $aRole['name'] ?>">

                            <?php else: ?>
                                <input type="radio" <?= $isChecked ?> name="roles" value="<?= $aRole['name'] ?>">

                            <?php endif; ?>

                            <?= $aRole['description'] ?>
                        </label>

                        <?= GhostHtml::a(
                        '<span class="glyphicon glyphicon-edit"></span>',
                        ['/user-management/role/view', 'id'=>$aRole['name']],
                        ['target'=>'_blank']
                    ) ?>
                        <br/>
                    <?php endforeach ?>

                    <br/>

                    <?php if ( Yii::$app->user->isSuperadmin OR Yii::$app->user->id != $user->id ): ?>

                        <?= Html::submitButton(
                            '<span class="glyphicon glyphicon-ok"></span> ' . Yii::t('app', 'Save'),
                            ['class'=>'btn btn-primary btn-sm']
                        ) ?>
                    <?php else: ?>
                        <div class="alert alert-warning well-sm text-center">
                            <?= Yii::t('app', 'You can not change own permissions') ?>
                        </div>
                    <?php endif; ?>


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

                    <div class="row">
                        <?php foreach ($permissionsByGroup as $groupName => $permissions): ?>

                            <div class="col-sm-6">
                                <fieldset>
                                    <legend><?= $groupName ?></legend>

                                    <ul>
                                        <?php foreach ($permissions as $permission): ?>
                                            <li>
                                                <?= $permission->description ?>

                                                <?= GhostHtml::a(
                                                    '<span class="glyphicon glyphicon-edit"></span>',
                                                    ['/user-management/permission/view', 'id'=>$permission->name],
                                                    ['target'=>'_blank']
                                                ) ?>
                                            </li>
                                        <?php endforeach ?>
                                    </ul>
                                </fieldset>

                                <br/>
                            </div>

                        <?php endforeach ?>

                    </div>

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
?>