<?php

use yii\db\Migration;

/**
 * Class m190509_000751_create_table_news
 */
class m190509_000751_create_table_news extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->createTable('rubric', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255),
        ]);

        $this->createTable('news', [
           'id' => $this->primaryKey(),
           'title' => $this->string(255),
           'short_desc' => $this->string(255),
           'content' => $this->text(),
           'image' => $this->string(255),
           'rubric_id' => $this->integer()->notNull(),
           'likes' => $this->integer()->defaultValue(0),
            'created_at' => $this->dateTime().' DEFAULT NOW()'
        ]);

        $this->addForeignKey(
            'fk-news-rubric',
            'news',
            'rubric_id',
            'rubric',
            'id'
        );
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m190509_000751_create_table_news cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m190509_000751_create_table_news cannot be reverted.\n";

        return false;
    }
    */
}
