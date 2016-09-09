<?php

use yii\db\Migration;
use common\models\rbacDB\Permission;
use common\models\rbacDB\Role;
use common\models\rbacDB\AuthItemGroup;
use common\models\rbacDB\Route;

class m160902_124651_create_basic_user_permissions extends Migration
{
    public function up()
    {
        Route::refreshRoutes();

        Role::create('Admin');

        // ================= User management permissions =================
        $group = new AuthItemGroup();
        $group->name = 'User management';
        $group->code = 'userManagement';
        $group->save(false);


        Role::assignRoutesViaPermission('Admin', 'viewUsers', [
            '/user/index',
            '/user/view',
            '/user/grid-page-size',
        ], 'View users', $group->code);

        Role::assignRoutesViaPermission('Admin', 'createUsers', ['/user/create'], 'Create users', $group->code);

        Role::assignRoutesViaPermission('Admin', 'editUsers', [
            '/user/update',
            '/user/bulk-activate',
            '/user/bulk-deactivate',
        ], 'Edit users', $group->code);

        Role::assignRoutesViaPermission('Admin', 'deleteUsers', [
            '/user/delete',
            '/user/bulk-delete',
        ], 'Delete users', $group->code);

        Role::assignRoutesViaPermission(
            'Admin',
            'changeUserPassword',
            ['/user/change-password'],
            'Change user password',
            $group->code
        );

        Role::assignRoutesViaPermission('Admin', 'assignRolesToUsers', [
            '/user-permission/set',
            '/user-permission/set-roles',
        ], 'Assign roles to users', $group->code);


        Permission::assignRoutes('viewVisitLog', [
            '/user-visit-log/index',
            '/user-visit-log/grid-page-size',
            '/user-visit-log/view',
        ], 'View visit log', $group->code);


        Permission::create('viewUserRoles', 'View user roles', $group->code);
        Permission::create('viewRegistrationIp', 'View registration IP', $group->code);
        Permission::create('viewUserEmail', 'View user email', $group->code);
        Permission::create('editUserEmail', 'Edit user email', $group->code);
        Permission::create('bindUserToIp', 'Bind user to IP', $group->code);


        Permission::addChildren('assignRolesToUsers', ['viewUsers', 'viewUserRoles']);
        Permission::addChildren('changeUserPassword', ['viewUsers']);
        Permission::addChildren('deleteUsers', ['viewUsers']);
        Permission::addChildren('createUsers', ['viewUsers']);
        Permission::addChildren('editUsers', ['viewUsers']);
        Permission::addChildren('editUserEmail', ['viewUserEmail']);


        // ================= User common permissions =================
        $group = new AuthItemGroup();
        $group->name = 'User common permission';
        $group->code = 'userCommonPermissions';
        $group->save(false);

        Role::assignRoutesViaPermission(
            'Admin',
            'changeOwnPassword',
            ['/auth/change-own-password'],
            'Change own password',
            $group->code
        );
    }

    public function down()
    {
        echo "m160902_124651_create_basic_user_permissions cannot be reverted.\n";

        return false;
    }

    /*
    // Use safeUp/safeDown to run migration code within a transaction
    public function safeUp()
    {
    }

    public function safeDown()
    {
    }
    */
}
