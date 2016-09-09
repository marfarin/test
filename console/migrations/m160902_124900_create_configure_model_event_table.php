<?php

use yii\db\Migration;

/**
 * Handles the creation for table `configure_model_event`.
 */
class m160902_124900_create_configure_model_event_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('configure_model_event', [
            'id' => $this->primaryKey(),
            'event_class_id' => $this->bigInteger(),
            'name' => $this->string(255)->notNull(),
            'description' => $this->text(),
            'from' => $this->bigInteger()->notNull(),
            'for_all' => $this->boolean()->notNull()->defaultValue(false),
            'message_text' => $this->text(),
            'message_header' => $this->text(),
        ]);
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropTable('configure_model_event');
    }
}
