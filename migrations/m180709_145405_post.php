<?php

use yii\db\Migration;

/**
 * Class m180709_145405_post
 */
class m180709_145405_post extends Migration
{
    
    // Use up()/down() to run migration code without a transaction.
    public function up()
    {
        $this->createTable('post', [
            'id' => $this->primaryKey(),
            'title' => $this->string(),
            'content' =>$this->text(),
        ]);
    }

    public function down()
    {
        $this->dropTable('post');
    }
}
