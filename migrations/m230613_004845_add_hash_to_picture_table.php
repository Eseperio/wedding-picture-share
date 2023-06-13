<?php

use yii\db\Migration;

/**
 * Class m230613_004845_add_hash_to_picture_table
 */
class m230613_004845_add_hash_to_picture_table extends Migration
{
    /**
     * {@inheritdoc}
     */
    public function safeUp()
    {
        $this->addColumn('picture', 'hash', $this->string(32)->notNull());
    }

    /**
     * {@inheritdoc}
     */
    public function safeDown()
    {
        echo "m230613_004845_add_hash_to_picture_table cannot be reverted.\n";

        return false;
    }

    /*
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {

    }

    public function down()
    {
        echo "m230613_004845_add_hash_to_picture_table cannot be reverted.\n";

        return false;
    }
    */
}
