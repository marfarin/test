<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user_visit_log`.
 */
class m160902_124538_create_user_visit_log_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_visit_log', [
            'id' => $this->primaryKey(),
            'token' => $this->string()->notNull(),
            'ip' => $this->string(15)->notNull(),
            'language' => $this->char(2)->notNull(),
            'user_agent' => $this->string()->notNull(),
            'browser' => $this->string(20),
            'os' => $this->string(20),
            'user_id' => $this->integer(),
            'visit_time' => $this->timestamp()->notNull(),
        ]);
        
        $this->addForeignKey('fk-user_visit_log-user_id', 'user_visit_log', 'user_id', 'user', 'id', 'SET NULL', 'CASCADE');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-user_visit_log-user_id', 'user_visit_log');
        $this->dropTable('user_visit_log');
    }
}
