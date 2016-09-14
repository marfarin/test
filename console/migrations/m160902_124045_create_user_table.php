<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user`.
 */
class m160902_124045_create_user_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user', [
            'id' => $this->primaryKey(),
            'username' => $this->string()->notNull(),
            'email' => $this->string(128),
            'email_confirmed' => $this->smallInteger(1)->notNull()->defaultValue(0),
            'auth_key' => $this->string(32)->notNull(),
            'password_hash' => $this->string()->notNull(),
            'confirmation_token' => $this->string(),
            'status' => $this->integer()->notNull()->defaultValue(1),
            'superadmin' => $this->boolean()->defaultValue(false),
            'registration_ip' => $this->string(15),
            'bind_to_ip' => $this->string(),
            'created_at' => $this->timestamp()->defaultValue(null),
            'updated_at' => $this->timestamp()->defaultValue(null),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('user');
    }
}
