<?php

namespace app\models;

use Yii;
use yii\helpers\Json;

/**
 * This is the model class for table "item".
 *
 * @property int $id
 * @property int $order_id
 * @property string $company
 * @property string $customer
 * @property string $bill_id
 * @property string $order_date
 * @property bool $vat
 */
class Item extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'item';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['order_id'], 'default', 'value' => null],
            [['company', 'customer'], 'string'],
            [['order_date'], 'safe'],
            [['vat'], 'boolean'],
            [['bill_id'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'order_id' => 'Order ID',
            'company' => 'Company',
            'customer' => 'Customer',
            'bill_id' => 'Bill ID',
            'order_date' => 'Order Date',
            'vat' => 'Vat',
        ];
    }


    public function getCompany($name, $address, $road,$sub_district,$district,$province,$zip_code,$phone,$tax_id)
    {
        $dataArray = [];
        $dataArray['name'] = !empty($name) ? $name : '';
        $dataArray['address'] = !empty($address) ? $address : '';
        $dataArray['road'] = !empty($road) ? $road : '';
        $dataArray['sub_district'] = !empty($sub_district) ? $sub_district : '';
        $dataArray['district'] = !empty($district) ? $district : '';
        $dataArray['province'] = !empty($province) ? $province : '';
        $dataArray['zip_code'] = !empty($zip_code) ? $zip_code : '';
        $dataArray['phone'] = !empty($phone) ? $phone : '';
        $dataArray['tax_id'] = !empty($tax_id) ? $tax_id : '';
        return Json::encode($dataArray);
    }
    public function getCustomer($name,$school,$address,$phone,$tax_id){
        $dataArray = [];
        $dataArray['name'] = !empty($name) ? $name : '';
        $dataArray['school_name'] = !empty($school) ? $school : '';
        $dataArray['address'] = !empty($address) ? $address : '';
        $dataArray['phone'] = !empty($phone) ? $phone : '';
        $dataArray['tax_id'] = !empty($tax_id) ? $tax_id : '';
        return Json::encode($dataArray);
    }
}
