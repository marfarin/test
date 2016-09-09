<?php

use yii\db\Migration;

/**
 * Handles the creation for table `user_notification_type`.
 * Has foreign keys to the tables:
 *
 * - `user`
 * - `notification_type`
 */
class m160908_145731_create_junction_table_for_user_and_notification_type_tables extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('user_notification_type', [
            'user_id' => $this->integer(),
            'notification_type_id' => $this->integer(),
            'PRIMARY KEY(user_id, notification_type_id)',
        ]);

        // creates index for column `user_id`
        $this->createIndex(
            'idx-user_notification_type-user_id',
            'user_notification_type',
            'user_id'
        );

        // add foreign key for table `user`
        $this->addForeignKey(
            'fk-user_notification_type-user_id',
            'user_notification_type',
            'user_id',
            'user',
            'id',
            'CASCADE'
        );

        // creates index for column `notification_type_id`
        $this->createIndex(
            'idx-user_notification_type-notification_type_id',
            'user_notification_type',
            'notification_type_id'
        );

        // add foreign key for table `notification_type`
        $this->addForeignKey(
            'fk-user_notification_type-notification_type_id',
            'user_notification_type',
            'notification_type_id',
            'notification_type',
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
            'fk-user_notification_type-user_id',
            'user_notification_type'
        );

        // drops index for column `user_id`
        $this->dropIndex(
            'idx-user_notification_type-user_id',
            'user_notification_type'
        );

        // drops foreign key for table `notification_type`
        $this->dropForeignKey(
            'fk-user_notification_type-notification_type_id',
            'user_notification_type'
        );

        // drops index for column `notification_type_id`
        $this->dropIndex(
            'idx-user_notification_type-notification_type_id',
            'user_notification_type'
        );

        $this->dropTable('user_notification_type');
    }
}
