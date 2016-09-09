<?php

use yii\db\Migration;

/**
 * Handles the creation for table `configure_rbac`.
 */
class m160902_124449_create_configure_rbac_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('configure_rbac', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'use_email_as_login' => $this->boolean()->notNull()->defaultValue(false),
            'email_confirmation_required' => $this->boolean()->notNull()->defaultValue(false),
            'common_permission_name' => $this->string()->notNull()->defaultValue('commonPermission'),
            'confirmation_token_expire' => $this->integer()->notNull()->defaultValue(3600),
            'user_can_have_multiple_roles' => $this->boolean()->notNull()->defaultValue(true),
            'max_attempts' => $this->integer()->notNull()->defaultValue(5),
            'attempts_timeout' => $this->integer()->notNull()->defaultValue(60),
            'deleted' => $this->boolean()->notNull()->defaultValue(false),
        ]);
        $this->insert('configure_rbac', ['name' => 'default configure']);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('configure_rbac');
    }
}
