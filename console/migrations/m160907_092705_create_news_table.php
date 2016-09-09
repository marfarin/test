<?php

use yii\db\Migration;

/**
 * Handles the creation for table `news`.
 */
class m160907_092705_create_news_table extends Migration
{
    /**
     * @inheritdoc
     */
    public function up()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'author_id' => $this->integer()->notNull(),
            'preview' => $this->string(255)->notNull(),
            'news' => $this->text()->notNull(),
            'created_at' => $this->timestamp()->notNull(),
            'updated_at' => $this->timestamp()->notNull()
        ]);
        
        $this->createIndex('idx-news-author_id', 'news', 'author_id');
        $this->addForeignKey('fk-news-author_id', 'news', 'author_id', 'user', 'id');
    }

    /**
     * @inheritdoc
     */
    public function down()
    {
        $this->dropForeignKey('fk-news-author_id', 'news');
        $this->dropTable('news');
    }
}
