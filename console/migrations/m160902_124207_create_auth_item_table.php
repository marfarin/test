<?php

use yii\db\Migration;

/**
 * Handles the creation for table `auth_item`.
 */
class m160902_124207_create_auth_item_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('auth_item', [
            'name' => $this->string(64)->notNull(),
            'type' => $this->integer()->notNull(),
            'description' => $this->text(),
            'rule_name' => $this->string(64),
            'group_code' => $this->string(64),
            'data' => $this->text(),
            'created_at' => $this->timestamp(),
            'updated_at' => $this->timestamp(),
            
            'PRIMARY KEY (name)'
        ],
            'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB'
        );
        $this->addForeignKey('fk-auth_item-rule_name', 'auth_item', 'rule_name', 'auth_rule', 'name');
        $this->createIndex('idx-auth_item-type', 'auth_item', 'type');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-auth_item-rule_name', 'auth_item');
        $this->dropTable('auth_item');
    }
}
