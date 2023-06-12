<?php

use yii\db\Migration;

/**
 * Class m230612_191510_add_main_tables
 */
class m230612_191510_add_main_tables extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        // add picture table. It contains views, likes, dislikes, etc
        $this->createTable('{{%picture}}', [
            'id' => $this->primaryKey(),
            // the original filename of uplaoded file
            'filename' => $this->string(255)->notNull(),
            // the date when the picture was uploaded
            'created_at' => $this->integer()->notNull(),
            // stores the number of views
            'views' => $this->integer()->notNull()->defaultValue(0),
            // stores the number of likes
            'likes' => $this->integer()->notNull()->defaultValue(0),
            // stores the number of dislikes
            'dislikes' => $this->integer()->notNull()->defaultValue(0),
            // stores the number of times it has been shared
            'shared' => $this->integer()->notNull()->defaultValue(0),
            // hidden pictures are not shown in the gallery
            'hidden' => $this->boolean()->notNull()->defaultValue(false),
            // the ip from the user who uploaded the picture
            'uploaded_from' => $this->string(15)->notNull(),
        ]);

    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230612_191510_add_main_tables cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230612_191510_add_main_tables cannot be reverted.\n";

        return false;
    }
    */
}
