<?php

use yii\db\Migration;

/**
 * Handles the creation for table `notification_type_configure_model_event`.
 * Has foreign keys to the tables:
 *
 * - `notification_type`
 * - `configure_model_event`
 */
class m160902_135455_create_junction_table_for_notification_type_and_configure_model_event_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('notification_type_configure_model_event', [
            'notification_type_id' => $this->integer(),
            'configure_model_event_id' => $this->integer(),
            'PRIMARY KEY(notification_type_id, configure_model_event_id)',
        ]);

        // creates index for column `notification_type_id`
        $this->createIndex(
            'idx-notification_type_configure_model_event-notification_type_id',
            'notification_type_configure_model_event',
            'notification_type_id'
        );

        // add foreign key for table `notification_type`
        $this->addForeignKey(
            'fk-notification_type_configure_model_event-notification_type_id',
            'notification_type_configure_model_event',
            'notification_type_id',
            'notification_type',
            'id',
            'CASCADE'
        );

        // creates index for column `configure_model_event_id`
        $this->createIndex(
            'idx-notification_type_configure_model_event-model_event_id',
            'notification_type_configure_model_event',
            'configure_model_event_id'
        );

        // add foreign key for table `configure_model_event`
        $this->addForeignKey(
            'fk-notification_type_configure_model_event-model_event_id',
            'notification_type_configure_model_event',
            'configure_model_event_id',
            'configure_model_event',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        // drops foreign key for table `notification_type`
        $this->dropForeignKey(
            'fk-notification_type_configure_model_event-notification_type_id',
            'notification_type_configure_model_event'
        );

        // drops index for column `notification_type_id`
        $this->dropIndex(
            'idx-notification_type_configure_model_event-notification_type_id',
            'notification_type_configure_model_event'
        );

        // drops foreign key for table `configure_model_event`
        $this->dropForeignKey(
            'fk-notification_type_configure_model_event-model_event_id',
            'notification_type_configure_model_event'
        );

        // drops index for column `configure_model_event_id`
        $this->dropIndex(
            'idx-notification_type_configure_model_event-model_event_id',
            'notification_type_configure_model_event'
        );

        $this->dropTable('notification_type_configure_model_event');
    }
}
