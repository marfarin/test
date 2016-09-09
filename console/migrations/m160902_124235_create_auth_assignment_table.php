<?php

use yii\db\Migration;

/**
 * Handles the creation for table `auth_assignment`.
 */
class m160902_124235_create_auth_assignment_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('auth_assignment', [
            'item_name' => $this->string(64)->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp(),
            'PRIMARY KEY (item_name, user_id)',
        ],
            'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB'
        );
        $this->addForeignKey('fk-auth_assignment-parent', 'auth_assignment', 'item_name', 'auth_item', 'name');
        $this->addForeignKey('fk-auth_assignment-child', 'auth_assignment', 'user_id', 'user', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-auth_assignment-parent', 'auth_assignment');
        $this->dropForeignKey('fk-auth_assignment-child', 'auth_assignment');
        $this->dropTable('auth_assignment');
    }
}
