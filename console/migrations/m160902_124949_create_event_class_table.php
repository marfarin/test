<?php

use yii\db\Migration;

/**
 * Handles the creation for table `event_class`.
 */
class m160902_124949_create_event_class_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('event_class', [
            'id' => $this->primaryKey(),
            'class_name' => $this->string(255)->notNull(),
            'event_name' => $this->string(255)->notNull(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('event_class');
    }
}
