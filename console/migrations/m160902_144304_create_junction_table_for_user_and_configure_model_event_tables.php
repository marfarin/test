<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user_configure_model_event`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `configure_model_event`
 */
class m160902_144304_create_junction_table_for_user_and_configure_model_event_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_configure_model_event', [
            'user_id' => $this->integer(),
            'configure_model_event_id' => $this->integer(),
            'PRIMARY KEY(user_id, configure_model_event_id)',
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-user_configure_model_event-user_id',
            'user_configure_model_event',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-user_configure_model_event-user_id',
            'user_configure_model_event',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `configure_model_event_id`
        $this->createIndex(
            'idx-user_configure_model_event-configure_model_event_id',
            'user_configure_model_event',
            'configure_model_event_id'
        );

        // add foreign key for table `configure_model_event`
        $this->addForeignKey(
            'fk-user_configure_model_event-configure_model_event_id',
            'user_configure_model_event',
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
        // drops foreign key for table `user`
        $this->dropForeignKey(
            'fk-user_configure_model_event-user_id',
            'user_configure_model_event'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-user_configure_model_event-user_id',
            'user_configure_model_event'
        );

        // drops foreign key for table `configure_model_event`
        $this->dropForeignKey(
            'fk-user_configure_model_event-configure_model_event_id',
            'user_configure_model_event'
        );

        // drops index for column `configure_model_event_id`
        $this->dropIndex(
            'idx-user_configure_model_event-configure_model_event_id',
            'user_configure_model_event'
        );

        $this->dropTable('user_configure_model_event');
    }
}
