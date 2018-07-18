<?php

namespace app\controllers;

use app\models\Item;
use app\models\ItemDetails;
use app\models\Post;
use app\models\User;
use Kreait\Firebase\ServiceAccount;
use Yii;
use yii\filters\auth\HttpBasicAuth;
use yii\filters\Cors;
use yii\helpers\ArrayHelper;
use yii\web\Response;
use yii\web\View;
use Kreait\Firebase\Factory;

class AutoPrintController extends \yii\rest\Controller
{

    public $identity;

    protected function verbs()
    {
        return [
            'index' => ['POST', 'OPTIONS'],
        ];
    }

    public function behaviors()
    {
        $behaviors = parent::behaviors();
        $behaviors['contentNegotiator']['formats']['text/html'] = Response::FORMAT_JSON;
        return ArrayHelper::merge([
            [
                'class' => Cors::className(),
                'cors' => [
                    'Access-Control-Request-Method' => ['GET', 'HEAD', 'OPTIONS'],
                ],
            ],
        ], $behaviors);
        // return $behaviors;
    }

    public function actions()
    {
        header('Access-Control-Allow-Origin: *');
        header('Access-Control-Allow-Headers: authorization, content-type');
        return parent::actions();
    }

    public function actionReceive()
    {
        $order_id =0;
        if ($dataPost = \Yii::$app->request->rawBody) {
            $dataJsonPost = json_decode($dataPost, true);
            $company = $dataJsonPost['company'][0];
            $customer = $dataJsonPost['customer'][0];
            $item = new Item();
            $item->vat = !empty($dataJsonPost['vat']) ? $dataJsonPost['vat'] : '';
            $item->order_id = !empty($dataJsonPost['order_id']) ? intval($dataJsonPost['order_id']) : '';
            $order_id =!empty($dataJsonPost['order_id']) ? intval($dataJsonPost['order_id']) : '';
            $item->bill_id = !empty($dataJsonPost['bill_id']) ? $dataJsonPost['bill_id'] : '';
            $item->order_date = !empty($dataJsonPost['order_date']) ? $dataJsonPost['order_date'] : '';
            $item->company = $item->getCompany($company['name'], $company['address'], $company['road'], $company['sub_district'], $company['district'], $company['province'], $company['zip_code'], $company['phone'], $company['tax_id']);
            $item->customer = $item->getCustomer($customer['name'],$customer['school_name'], $customer['address'], $customer['phone'], $customer['tax_id']);
            $check=$item->save();
            if($check){
                foreach ($dataJsonPost['data'] as $model) {
                    $item_detail = new ItemDetails();
                    $item_detail->item_id = $item->id;
                    $item_detail->name = !empty($model['name']) ? $model['name'] : '';
                    $item_detail->class = !empty($model['class']) ? $model['class'] : '';
                    $item_detail->amount = !empty($model['amount']) ? $model['amount'] : '';
                    $item_detail->price = !empty($model['price']) ? $model['price'] : '';
                    $item_detail->save();
                }
                $serviceAccount = ServiceAccount::fromJsonFile(__DIR__ . '/google-service-account.json');
                $firebase = (new Factory)
                    ->withServiceAccount($serviceAccount)
                    ->withDatabaseUri('https://printer-order-6b8f0.firebaseio.com')
                    ->create();
                $database = $firebase->getDatabase();
                $newPost = $database
                    ->getReference('print-order')
                    ->push([
                        'id' => $item->id,
                        'status' => true,
                        'order_id'=>$order_id,
                        'create_at'=>Yii::$app->formatter->asDate('now', 'php:d-m-Y')
                    ]);
                return [
                    'status'=>'ok'
                ];
            }else{
                return [
                    'status'=>'not save'
                ];
            }



        }
    }

}
