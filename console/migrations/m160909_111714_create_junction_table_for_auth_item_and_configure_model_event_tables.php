<?php

use yii\db\Migration;

/**
 * Handles the creation for table `auth_item_configure_model_event`.
 * Has foreign keys to the tables:
 *
 * - `auth_item`
 * - `configure_model_event`
 */
class m160909_111714_create_junction_table_for_auth_item_and_configure_model_event_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('auth_item_configure_model_event', [
            'auth_item_id' => $this->string(64),
            'configure_model_event_id' => $this->integer(),
            'PRIMARY KEY(auth_item_id, configure_model_event_id)',
        ]);

        // creates index for column `auth_item_id`
        $this->createIndex(
            'idx-auth_item_configure_model_event-auth_item_id',
            'auth_item_configure_model_event',
            'auth_item_id'
        );

        // add foreign key for table `auth_item`
        $this->addForeignKey(
            'fk-auth_item_configure_model_event-auth_item_id',
            'auth_item_configure_model_event',
            'auth_item_id',
            'auth_item',
            'name',
            'CASCADE'
        );

        // creates index for column `configure_model_event_id`
        $this->createIndex(
            'idx-auth_item_configure_model_event-configure_model_event_id',
            'auth_item_configure_model_event',
            'configure_model_event_id'
        );

        // add foreign key for table `configure_model_event`
        $this->addForeignKey(
            'fk-auth_item_configure_model_event-configure_model_event_id',
            'auth_item_configure_model_event',
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
        // drops foreign key for table `auth_item`
        $this->dropForeignKey(
            'fk-auth_item_configure_model_event-auth_item_id',
            'auth_item_configure_model_event'
        );

        // drops index for column `auth_item_id`
        $this->dropIndex(
            'idx-auth_item_configure_model_event-auth_item_id',
            'auth_item_configure_model_event'
        );

        // drops foreign key for table `configure_model_event`
        $this->dropForeignKey(
            'fk-auth_item_configure_model_event-configure_model_event_id',
            'auth_item_configure_model_event'
        );

        // drops index for column `configure_model_event_id`
        $this->dropIndex(
            'idx-auth_item_configure_model_event-configure_model_event_id',
            'auth_item_configure_model_event'
        );

        $this->dropTable('auth_item_configure_model_event');
    }
}
