<?php

use yii\db\Migration;
use common\models\User;

class m160902_124338_insert_superadmin_to_user extends Migration
{
    public function up()
    {
        $user = new User();
        $user->superadmin = 1;
        $user->status = User::STATUS_ACTIVE;
        $user->username = 'superadmin';
        $user->password = 'superadmin';
        $user->save(false);
    }

    public function down()
    {
        $user = User::findByUsername('superadmin');

        if ($user) {
            $user->delete();
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
