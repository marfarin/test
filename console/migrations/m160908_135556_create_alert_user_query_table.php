<?php

use yii\db\Migration;

/**
 * Handles the creation for table `alert_user_query`.
 */
class m160908_135556_create_alert_user_query_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('alert_user_query', [
            'id' => $this->primaryKey(),
            'header'=>$this->string(256)->notNull(),
            'text'=>$this->text()->notNull(),
            'sender_id'=>$this->integer()->notNull(),
            'recipient_id'=>$this->integer()->notNull(),
            'created_at'=>$this->timestamp()->notNull(),
            'readed_at'=>$this->timestamp()->defaultValue(null)
        ]);

        $this->createIndex(
            'idx-alert_user_query-sender_id',
            'alert_user_query',
            'sender_id'
        );
        $this->addForeignKey(
            'fk-alert_user_query-sender_id',
            'alert_user_query',
            'sender_id',
            'user',
            'id',
            'CASCADE'
        );
        $this->createIndex(
            'idx-browser_messages-recipient_id',
            'alert_user_query',
            'recipient_id'
        );
        $this->addForeignKey(
            'fk-browser_messages-recipient_id',
            'alert_user_query',
            'recipient_id',
            'user',
            'id',
            'CASCADE'
        );
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-alert_user_query-sender_id','alert_user_query');
        $this->dropIndex('idx-alert_user_query-sender_id','alert_user_query');
        $this->dropForeignKey('fk-browser_messages-recipient_id','alert_user_query');
        $this->dropIndex('idx-browser_messages-recipient_id','alert_user_query');
        $this->dropTable('alert_user_query');
    }
}
