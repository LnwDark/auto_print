<?php

use yii\db\Migration;

/**
 * Class m180710_072023_item_details
 */
class m180710_072023_item_details extends Migration
{

    public function up()
    {
        $this->createTable('item_details',[
            'id'=>$this->primaryKey(),
            'item_id'=>$this->integer(),
            'name'=>$this->string(),
            'class'=>$this->string(),
            'amount'=>$this->string(),
            'price'=>$this->float(7,2),
        ]);
    }

    public function down()
    {
        $this->dropTable('item_details');
    }
}
