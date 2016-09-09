<?php

use yii\db\Migration;

/**
 * Handles the creation for table `auth_rule`.
 */
class m160902_124156_create_auth_rule_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('auth_rule', [
            'name' => $this->string(64)->notNull(),
            'data' => $this->text(),
            'created_at' => $this->integer(),
            'updated_at' => $this->integer(),
            'PRIMARY KEY (name)',
        ],
            'CHARACTER SET utf8 COLLATE utf8_general_ci ENGINE=InnoDB'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('auth_rule');
    }
}
