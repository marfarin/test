<?php

use yii\db\Migration;

/**
 * Handles the creation for table `auth_item_child`.
 */
class m160902_124224_create_auth_item_child_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('auth_item_child', [
            'parent' => $this->string(64)->notNull(),
            'child' => $this->string(64)->notNull(),
            'PRIMARY KEY (parent, child)',
        ],
            'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB'
        );
        
        $this->addForeignKey('fk-auth_item_child-parent', 'auth_item_child', 'parent', 'auth_item', 'name');
        $this->addForeignKey('fk-auth_item_child-child', 'auth_item_child', 'child', 'auth_item', 'name');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-auth_item_child-parent', 'auth_item_child');
        $this->dropForeignKey('fk-auth_item_child-child', 'auth_item_child');
        $this->dropTable('auth_item_child');
    }
}
