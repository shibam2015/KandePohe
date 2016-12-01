<?php
namespace frontend\controllers;

use common\models\Mailbox;
use common\models\UserRequest;
use common\models\UserRequestOp;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

use common\models\User;
use yii\widgets\ActiveForm;
use yii\web\Response;
use common\components\MailHelper;
use common\components\CommonHelper;
use common\components\MessageHelper;
use common\components\SmsHelper;
use frontend\controllers\UserController;
/**
 * Site controller
 */
class MailboxController extends Controller
{
    /**
     * @inheritdoc
     */
    /*public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
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
    }*/
    public $STATUS;
    public $MESSAGE;
    public $TITLE;

    /**
     * @inheritdoc
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],

        ];
    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        return $this->redirect(['inbox']);
    }

    public function actionInbox()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $Id = Yii::$app->user->identity->id;
        /*$Model = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $Id, 'send_request_status' => 'Yes'])->limit(10)->all();
        $MailUnreadCount = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $Id, 'send_request_status' => 'Yes'])->count();
        #CommonHelper::pr($Model);exit;
        $MailArray = array();
        foreach ($Model as $Key => $Value) {
            #CommonHelper::pr($Value->id);exit;
            $LastMail = Mailbox::find()->where(['from_user_id' => $Value->from_user_id, 'to_user_id' => $Id])->orderBy('MailId')->one();
            $MailCount = Mailbox::find()->where(['from_user_id' => $Value->from_user_id, 'to_user_id' => $Id])->count();
            $MailCount += Mailbox::find()->where(['from_user_id' => $Id, 'to_user_id' => $Value->from_user_id])->count();
            $MailArray[$Value->id]['LastMsg'] = str_replace("#NAME#", $Value->fromUserInfo->fullName, $LastMail->MailContent);
            $MailArray[$Value->id]['MsgCount'] = $MailCount;
        }*/
        #CommonHelper::pr($MailArray);exit;
        return $this->render('inbox');
    }


    function actionRenderCall($model, $view, $show = false, $popup = false, $flag = false, $temp = array())
    {
        return $this->renderAjax($view, [
            'model' => $model,
            'show' => $show,
            'popup' => $popup,
            'flag' => $flag,
            'temp' => $temp,
        ]);
    }


    public function actionAll($Type = 'Inbox')
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $Id = Yii::$app->user->identity->id;
        return $this->renderAjax('_inbox',
            [
                'Id' => $Id,
            ]
        );
    }

    public function actionDirPagination()
    {
        return $this->render('dirPagination', []);
    }

    public function actionGetData()
    {
        $num_rec_per_page = 10;
        $Type = 'Inbox';
        $Id = Yii::$app->user->identity->id;
        $Page = Yii::$app->request->get('page');
        if ($Type == 'Inbox') {
            $ModelBox = UserRequestOp::getInboxList($Id, 10);
        } else {
            $ModelBox = UserRequestOp::getSendBoxList($Id, 10);
        }
        CommonHelper::pr($_GET);
        exit;
        if (isset($_GET["page"])) {
            $Page = $_GET["page"];
        } else {
            $Page = 1;
        };
        $start_from = ($Page - 1) * $num_rec_per_page;

        if (!empty($_GET["search"])) {
            $sqlTotal = "SELECT * FROM items
			WHERE (title LIKE '%" . $_GET["search"] . "%' OR description LIKE '%" . $_GET["search"] . "%')";
            $sql = "SELECT * FROM items
			WHERE (title LIKE '%" . $_GET["search"] . "%' OR description LIKE '%" . $_GET["search"] . "%')
			LIMIT $start_from, $num_rec_per_page";
        } else {
            $sqlTotal = "SELECT * FROM items";
            $sql = "SELECT * FROM items LIMIT $start_from, $num_rec_per_page";
        }

        $result = $mysqli->query($sql);

        while ($row = $result->fetch_assoc()) {
            $json[] = $row;
        }
        $data['data'] = $json;

        $result = mysqli_query($mysqli, $sqlTotal);
        $data['total'] = mysqli_num_rows($result);

        echo json_encode($data);
        exit;
    }


}