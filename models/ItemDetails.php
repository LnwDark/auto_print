<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "item_details".
 *
 * @property int $id
 * @property int $item_id
 * @property string $name
 * @property string $class
 * @property string $amount
 * @property double $price
 */
class ItemDetails extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item_details';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'class', 'amount','price'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'item_id' => 'Item ID',
            'name' => 'Name',
            'class' => 'Class',
            'amount' => 'Amount',
            'price' => 'Price',
        ];
    }
}
