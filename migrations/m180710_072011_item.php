<?php

use yii\db\Migration;

/**
 * Class m180710_072011_item
 */
class m180710_072011_item extends Migration
{



    public function up()
    {
        $this->createTable('item', [
            'id' => $this->primaryKey(),
            'order_id'=>$this->integer(),
            'company' => $this->text(),
            'customer' =>$this->text(),
            'bill_id'=>$this->string(),
            'order_date'=>$this->date(),
            'vat'=>$this->boolean()
        ]);
    }

    public function down()
    {
        $this->dropTable('item');
    }
}
