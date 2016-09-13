<?php

namespace frontend\controllers;

use webvimark\components\BaseController;
use common\models\rbacDB\Permission;
use common\models\rbacDB\Role;
use common\models\User;
use common\components\GhostAccessControl;
use yii\web\NotFoundHttpException;
use Yii;

class UserPermissionController extends BaseController
{

    public function behaviors()
    {
        return [
            'ghost-access' => [
                'class' => GhostAccessControl::className(),
            ],
        ];
    }

    /**
     * @param int $id User ID
     *
     * @throws \yii\web\NotFoundHttpException
     * @return string
     */
    public function actionSet($id)
    {
        $user = User::findOne($id);

        if (!$user) {
            throw new NotFoundHttpException('User not found');
        }

        $permissionsByGroup = [];
        $permissions = Permission::find()
            ->andWhere([
                'auth_item' . '.name' => array_keys(Permission::getUserPermissions($user->id))
            ])
            ->joinWith('group')
            ->all();

        foreach ($permissions as $permission) {
            $permissionsByGroup[@$permission->group->name][] = $permission;
        }

        return $this->renderIsAjax('set', compact('user', 'permissionsByGroup'));
    }

    /**
     * @param int $id - User ID
     *
     * @return \yii\web\Response
     */
    public function actionSetRoles($id)
    {
        if (!Yii::$app->user->isSuperadmin && Yii::$app->user->id == $id) {
            Yii::$app->session->setFlash(
                'error',
                Yii::t('app', 'You can not change own permissions')
            );

            return $this->redirect(['set', 'id' => $id]);
        }

        $oldAssignments = array_keys(Role::getUserRoles($id));

        // To be sure that user didn't attempt to assign himself some unavailable roles
        $newAssignments = array_intersect(
            Role::getAvailableRoles(Yii::$app->user->isSuperAdmin, true),
            (array)Yii::$app->request->post('roles', [])
        );

        $toAssign = array_diff($newAssignments, $oldAssignments);
        $toRevoke = array_diff($oldAssignments, $newAssignments);

        foreach ($toRevoke as $role) {
            User::revokeRole($id, $role);
        }

        foreach ($toAssign as $role) {
            User::assignRole($id, $role);
        }

        Yii::$app->session->setFlash('success', Yii::t('app', 'Saved'));

        return $this->redirect(['set', 'id' => $id]);
    }
}