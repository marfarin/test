<?php

use yii\db\Migration;
use common\models\rbacDB\Permission;
use common\models\ConfigureRbac;

class m160902_124513_insert_common_permisison_to_auth_item extends Migration
{
    public function up()
    {
        Permission::create(ConfigureRbac::getActualConfigureRbacInstance()->common_permission_name);
    }

    public function down()
    {
        $permission = Permission::findOne(['name' => ConfigureRbac::getActualConfigureRbacInstance()->common_permission_name]);

        if ($permission) {
            $permission->delete();
        }
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
