<?php

namespace app\controllers;

use app\models\Item;
use app\models\ItemDetails;
use app\models\Post;
use kartik\mpdf\Pdf;
use Mpdf\Mpdf;
use Yii;
use yii\filters\AccessControl;
use yii\helpers\Json;
use yii\helpers\Url;
use yii\web\Controller;
use yii\web\Response;
use yii\filters\VerbFilter;
use app\models\LoginForm;
use app\models\ContactForm;

use Kreait\Firebase\Factory;
use Kreait\Firebase\ServiceAccount;

class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout'],
                'rules' => [
                    [
                        'actions' => ['logout'],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        return $this->render('index');
    }

    /**
     * Login action.
     *
     * @return Response|string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        }

        $model->password = '';
        return $this->render('login', [
            'model' => $model,
        ]);
    }

    /**
     * Logout action.
     *
     * @return Response
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return Response|string
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->contact(Yii::$app->params['adminEmail'])) {
            Yii::$app->session->setFlash('contactFormSubmitted');

            return $this->refresh();
        }
        return $this->render('contact', [
            'model' => $model,
        ]);
    }

    /**
     * Displays about page.
     *
     * @return string
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    public function actionReport($id)
    {
        $params = Yii::$app->params;
        $fontDirs = $params['defaultConfig']['fontDir'];
        $fontData = $params['defaultFontConfig']['fontdata'];
//        $data = json_decode(file_get_contents("http://localhost:3000"), true);
//        $rawData = $data['data'];
        if (isset($id)) {
            $dataItem = Item::find()->where(['id' => $id])->one();
            if (isset($dataItem)) {

                $company = Json::decode($dataItem->company, true);
                $customer = Json::decode($dataItem->customer, true);
                $rawData = ItemDetails::find()->where(['item_id' => $id])->all();
                $page = 0;
                $pang = 'ต้นฉบับ';
                $mpdf = new Mpdf([
                    'fontDir' => array_merge($fontDirs, [
                        Url::base() . 'fonts/sukhumvit',
                    ]),
                    'fontdata' => $fontData + ['sukhumvit' => $params['SetFontSukhumvit']],
                    'default_font_size' => 10,
                    'default_font' => 'sukhumvit',
                    'mode' => 'utf-8',
                    'format' => 'A4',
                    'margin_top' => 108,
                    'margin_left' => 15,
                    'margin_right' => 10,
                    'margin_bottom' => 50,
                ]);
                $stylesheet = file_get_contents(Url::base() . 'css/mpdf.css');
                $totalrow = count($rawData);
                $pagesize = 20;
                $sum = $totalrow / $pagesize;
                function ReadNumber($number)
                {
                    $position_call = array("แสน", "หมื่น", "พัน", "ร้อย", "สิบ", "");
                    $number_call = array("", "หนึ่ง", "สอง", "สาม", "สี่", "ห้า", "หก", "เจ็ด", "แปด", "เก้า");
                    $number = $number + 0;
                    $ret = "";
                    if ($number == 0) return $ret;
                    if ($number > 1000000) {
                        $ret .= ReadNumber(intval($number / 1000000)) . "ล้าน";
                        $number = intval(fmod($number, 1000000));
                    }

                    $divider = 100000;
                    $pos = 0;
                    while ($number > 0) {
                        $d = intval($number / $divider);
                        $ret .= (($divider == 10) && ($d == 2)) ? "ยี่" :
                            ((($divider == 10) && ($d == 1)) ? "" :
                                ((($divider == 1) && ($d == 1) && ($ret != "")) ? "เอ็ด" : $number_call[$d]));
                        $ret .= ($d ? $position_call[$pos] : "");
                        $number = $number % $divider;
                        $divider = $divider / 10;
                        $pos++;
                    }
                    return $ret;
                }
                function FormatBaht($amount_number)
                {
                    $amount_number = number_format($amount_number, 2, ".", "");
                    $pt = strpos($amount_number, ".");
                    $number = $fraction = "";
                    if ($pt === false)
                        $number = $amount_number;
                    else {
                        $number = substr($amount_number, 0, $pt);
                        $fraction = substr($amount_number, $pt + 1);
                    }

                    $ret = "";
                    $baht = ReadNumber($number);
                    if ($baht != "")
                        $ret .= $baht . "บาท";

                    $satang = ReadNumber($fraction);
                    if ($satang != "")
                        $ret .= $satang . "สตางค์";
                    else
                        $ret .= "ถ้วน";
                    return $ret;
                }

                for ($i = 0; $i < $sum; $i++) {
                    $page = $i + 1;
                    //  $page =2;
                    $start = $page * $pagesize - $pagesize;
                    //  exit;
                    $end = $page * $pagesize - 1;
                    $lastindex = count($rawData) - 1;
                    if ($end > $lastindex) {
                        $end = $lastindex;
                    }

                    $Totaling = 0;
                    foreach ($rawData as $m) $Totaling += $m['price'];  //sum
                    $totalTH = FormatBaht($Totaling);

                    $content = $this->renderPartial('invoice', [
                        'model' => $rawData,
                        'start' => $start,
                        'end' => $end,
                    ]);
                    $footer = $this->renderPartial('_footer', [
                        'dataItem' => $dataItem,
                        'Totaling' => $Totaling,
                        'totalTH' => $totalTH
                    ]);
                    $mpdf->SetHTMLHeader($this->renderPartial('_header', [
                        'dataItem' => $dataItem,
                        'company' => $company,
                        'customer' => $customer,
                        'pageNo' => $page,
                        'pang' => $pang
                    ]), 2);
                    $mpdf->WriteHTML($stylesheet, 1);
                    $mpdf->SetHTMLFooter($footer);
                    $mpdf->SetTitle('ใบเสร็จรับเงิน');
                    $mpdf->WriteHTML($content, 2);
                }

                $path_dir = Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'file_print';
                if (!file_exists($path_dir)) {
                    mkdir($path_dir, 0777);
                }
                $filename = 'order_' . $id . '.pdf';
                $path = Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'file_print' . DIRECTORY_SEPARATOR;
//                $mpdf->Output();
                $mpdf->Output($path . $filename, 'F');
                $py = Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'python' . DIRECTORY_SEPARATOR . 'thingD.py';
                $read = exec("python3 " . $py . " " . $path . " " . $filename);
                if ($read === 'ok') {
                echo 'success';
                }else{
                    echo 'not';
                }
            } else {
                return 'fail';
            }
        }
    }



    public function actionAddressed($id)
    {
        $dataItem = Item::find()->where(['id' => $id])->one();
        if (isset($dataItem)) {
            $company = Json::decode($dataItem->company, true);
            $customer = Json::decode($dataItem->customer, true);
        }
        $params = Yii::$app->params;
        $fontDirs = $params['defaultConfig']['fontDir'];
        $fontData = $params['defaultFontConfig']['fontdata'];
        $mpdf = new Mpdf([
            'fontDir' => array_merge($fontDirs, [
                Url::base() . 'fonts/THSarabun',
            ]),
            'fontdata' => $fontData + [
                    'thsarabun' => [
                        'R' => 'THSarabun.ttf',
                        'B' => 'THSarabun Bold.ttf',
                        'I' => 'THSarabun Italic.ttf',
                        'BI' => 'THSarabun BoldItalic.ttf',
                    ]
                ],
//            'default_font_size' => 10,
            'default_font' => 'thsarabun',
            'mode' => 'utf-8',
            'format' => [117, 231],
            'language' => 'th',
            'margin_top' => 10,
            'margin_left' => 10,
            'margin_right' => 10,
            'margin_bottom' => 10,
            'mirrorMargins' => true,
            'orientation' => 'L',
        ]);
        $stylesheet = file_get_contents(Url::base() . 'css/letterStyle.css');
//        $mpdf->Image(Url::base() .'img/NGLogo.jpg', 90, 90, 0, 0, 'jpg', '', true, false);
        $mpdf->WriteHTML($stylesheet, 1);
        $mpdf->WriteHTML($this->renderPartial('letter',[
            'customer'=>$customer,
            'company'=>$company
        ]), 2);
        $filename = 'letter_' . $id . '.pdf';
        $path = Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'file_print' . DIRECTORY_SEPARATOR;
        $mpdf->Output($path . $filename, 'F');
        $py = Yii::getAlias('@app') . DIRECTORY_SEPARATOR . 'web' . DIRECTORY_SEPARATOR . 'python' . DIRECTORY_SEPARATOR . 'thingD.py';
        $read = exec("python3 " . $py . " " . $path . " " . $filename);
    }


}