<?php

use yii\db\Migration;

/**
 * Handles the creation for table `auth_item_group`.
 */
class m160902_124310_create_auth_item_group_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('auth_item_group', [
            'code' => 'varchar(64) NOT NULL',
            'name' => 'varchar(255) NOT NULL',
            'created_at' => 'int',
            'updated_at' => 'int',
            'PRIMARY KEY (code)',
        ],
            'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB'
        );

        $this->addForeignKey('fk-auth_item_group-code', 'auth_item', 'group_code', 'auth_item_group', 'code', 'SET NULL', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-auth_item_group-code', 'auth_item');
        $this->dropTable('auth_item_group');
    }
}
