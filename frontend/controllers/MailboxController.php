<?php
namespace frontend\controllers;

use common\models\Mailbox;
use common\models\UserRequest;
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
        $id = Yii::$app->user->identity->id;
        $Model = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $id, 'send_request_status' => 'Yes'])->limit(10)->all();
        #CommonHelper::pr($Model);exit;
        return $this->render('inbox',
            ['model' => $Model]
        );
    }

    public function actionInboxSendMessage()
    {
        $id = Yii::$app->user->identity->id;
        $show = false;
        $flag = false;
        $popup = false;
        $ModelInbox = new Mailbox();
        $ModelInbox->scenario = Mailbox::SCENARIO_SEND_MESSAGE;
        if (Yii::$app->request->post() && (Yii::$app->request->post('ToUserId') != '')) {
            $model = User::findOne(Yii::$app->request->post('ToUserId'));
            $show = false;
        }
        if (Yii::$app->request->post() && (Yii::$app->request->post('Action') == 'SEND_MESSAGE')) {
            #CommonHelper::pr(Yii::$app->request->post());
            $ModelInbox->from_user_id = $id;
            $ModelInbox->to_user_id = Yii::$app->request->post('User')['ToUserId'];
            $ModelInbox->MailContent = Yii::$app->request->post('Mailbox')['MailContent'];
            $popup = true;
            if ($ModelInbox->save()) {
                $flag = true;
            } else {
                $flag = false;
            }
            $show = true;
        }
        $myModel = [
            'model' => $model,
            'modelInbox' => $ModelInbox,
            'ToUserId' => Yii::$app->request->post('ToUserId')
        ];
        return $this->actionRenderCall($myModel, '_sendmessage', $show, $popup, $flag);
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




}