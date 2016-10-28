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
        $Model = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $Id, 'send_request_status' => 'Yes'])->limit(10)->all();
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
        }
        #CommonHelper::pr($MailArray);exit;
        return $this->render('inbox',
            [
                'model' => $Model,
                'MailArray' => $MailArray,
                'MailUnreadCount' => $MailUnreadCount
            ]
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
            $ModelInbox->from_reg_no = User::getRegisterNo($id);
            $ModelInbox->to_reg_no = User::getRegisterNo(Yii::$app->request->post('User')['ToUserId']);
            $ModelInbox->subject = Yii::$app->request->post('Mailbox')['MailContent'];
            $ModelInbox->dtadded = CommonHelper::getTime();
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

    public function actionMoreConversation($uk = '')
    {
        $Id = Yii::$app->user->identity->id;
        list($Model, $MailUnreadCount) = $this->actionMoreConversationCommon($Id, $uk);
        return $this->render('moreconversation',
            [
                'model' => $Model,
                'MailUnreadCount' => $MailUnreadCount
            ]
        );
    }

    public function actionMoreConversationCommon($Id, $uk = '')
    {
        $FromUserId = User::find()->select('id')->where(['Registration_Number' => $uk])->one();
        if (Yii::$app->user->isGuest || $uk == '' || $FromUserId == null) {
            return $this->redirect(['inbox']);
        }
        #echo " 1- ";
        $Model = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $Id, 'from_user_id' => $FromUserId->id, 'send_request_status' => ['Yes', 'Accepted']])->one();
        $MailUnreadCount = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $Id, 'send_request_status' => 'Yes'])->count();

        if ($Model != null) {
            #   echo " 2- ";
            $MailArray = array();
            $LastMail = Mailbox::find()->where(['from_user_id' => $Model->from_user_id, 'to_user_id' => $Id])->orderBy('MailId')->one();
            $MailCount = Mailbox::find()->where(['from_user_id' => $Model->from_user_id, 'to_user_id' => $Id])
                ->orWhere(['from_user_id' => $Id, 'to_user_id' => $Model->from_user_id])
                ->count();
            $MailConversation = Mailbox::find()->where(['from_user_id' => $Model->from_user_id, 'to_user_id' => $Id])
                ->orWhere(['from_user_id' => $Id, 'to_user_id' => $Model->from_user_id])
                ->orderBy(['MailId' => SORT_DESC])
                ->all();
            $MailArray[$Model->id]['LastMsg'] = str_replace("#NAME#", $Model->fromUserInfo->fullName, $LastMail->MailContent);
            $MailArray[$Model->id]['MsgCount'] = $MailCount;

            #CommonHelper::pr($MailConversation);exit;

            return array(
                $Model,
                $MailArray,
                $MailConversation,
                $MailUnreadCount,
            );
            /*
            'model' => $Model,
                    'MailArray' => $MailArray,
                    'MailConversation' => $MailConversation,
                    'MailUnreadCount' => $MailUnreadCount,
            */

            #return $allData;
        } else {
            return $this->redirect(['inbox']);
        }
    }

    public function actionMoreConversation1($uk = '')
    {
        $Id = Yii::$app->user->identity->id;
        $FromUserId = User::find()->select('id')->where(['Registration_Number' => $uk])->one();
        if (Yii::$app->user->isGuest || $uk == '' || $FromUserId == null) {
            return $this->redirect(['inbox']);
        }
        $Model = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $Id, 'from_user_id' => $FromUserId->id, 'send_request_status' => ['Yes', 'Accepted']])->one();
        $MailUnreadCount = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $Id, 'send_request_status' => 'Yes'])->count();
        if ($Model != null) {
            $MailArray = array();
            $LastMail = Mailbox::find()->where(['from_user_id' => $Model->from_user_id, 'to_user_id' => $Id])->orderBy('MailId')->one();
            $MailCount = Mailbox::find()->where(['from_user_id' => $Model->from_user_id, 'to_user_id' => $Id])
                ->orWhere(['from_user_id' => $Id, 'to_user_id' => $Model->from_user_id])
                ->count();
            $MailConversation = Mailbox::find()->where(['from_user_id' => $Model->from_user_id, 'to_user_id' => $Id])
                ->orWhere(['from_user_id' => $Id, 'to_user_id' => $Model->from_user_id])
                ->orderBy(['MailId' => SORT_DESC])
                ->all();
            $MailArray[$Model->id]['LastMsg'] = str_replace("#NAME#", $Model->fromUserInfo->fullName, $LastMail->MailContent);
            $MailArray[$Model->id]['MsgCount'] = $MailCount;

            #CommonHelper::pr($MailConversation);exit;
            return $this->render('moreconversation',
                [
                    'model' => $Model,
                    'MailArray' => $MailArray,
                    'MailConversation' => $MailConversation,
                    'MailUnreadCount' => $MailUnreadCount,
                ]
            );
            /*$myModel = [
                'model' => $Model,
                'MailArray' => $MailArray,
                'MailConversation' => $MailConversation,
                'MailUnreadCount' => $MailUnreadCount,
            ];
            return $this->renderAjax('_moreconversation', $myModel);*/
        } else {
            return $this->redirect(['inbox']);
        }
    }

    public function actionNew()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $Id = Yii::$app->user->identity->id;
        return $this->render('new',
            [
                'model' => $Id
            ]
        );
    }

    public function actionAll()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $Id = Yii::$app->user->identity->id;
        $Model = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $Id, 'send_request_status' => 'Yes'])->limit(10)->all();
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
        }

        return $this->render('all',
            [
                'model' => $Model,
                'MailArray' => $MailArray,
                'MailUnreadCount' => $MailUnreadCount
            ]
        );
    }

    public function actionLastMsg($uk = '')
    {
        $Id = Yii::$app->user->identity->id;
        $uk = Yii::$app->request->post('uk');
        $FromUserId = User::find()->select('id')->where(['Registration_Number' => $uk])->one();
        if (Yii::$app->user->isGuest || $uk == '' || $FromUserId == null) {
            return $this->redirect(['inbox']);
        }
        $Model = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $Id, 'from_user_id' => $FromUserId->id, 'send_request_status' => ['Yes', 'Accepted']])->one();
        $MailUnreadCount = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $Id, 'send_request_status' => 'Yes'])->count();
        if ($Model != null) {
            $MailArray = array();
            $LastMail = Mailbox::find()->where(['from_user_id' => $Model->from_user_id, 'to_user_id' => $Id])->orderBy('MailId')->one();
            $MailCount = Mailbox::find()->where(['from_user_id' => $Model->from_user_id, 'to_user_id' => $Id])
                ->orWhere(['from_user_id' => $Id, 'to_user_id' => $Model->from_user_id])
                ->count();
            $MailConversation = Mailbox::find()->where(['from_user_id' => $Model->from_user_id, 'to_user_id' => $Id])
                ->orWhere(['from_user_id' => $Id, 'to_user_id' => $Model->from_user_id])
                ->orderBy(['MailId' => SORT_DESC])
                ->all();
            $MailArray[$Model->id]['LastMsg'] = str_replace("#NAME#", $Model->fromUserInfo->fullName, $LastMail->MailContent);
            $MailArray[$Model->id]['MsgCount'] = $MailCount;
            $myModel = [
                'model' => $Model,
                'MailArray' => $MailArray,
                'MailConversation' => $MailConversation,
                'MailUnreadCount' => $MailUnreadCount,
            ];
            return $this->renderAjax('_last_msg_section', $myModel);
        }

    }

    public function actionMoreCoversationAll($uk = '')
    {
        $Id = Yii::$app->user->identity->id;
        $uk = Yii::$app->request->post('uk');
        $FromUserId = User::find()->select('id')->where(['Registration_Number' => $uk])->one();
        if (Yii::$app->user->isGuest || $uk == '' || $FromUserId == null) {
            return $this->redirect(['inbox']);
        }
        $Model = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $Id, 'from_user_id' => $FromUserId->id, 'send_request_status' => ['Yes', 'Accepted']])->one();
        $MailUnreadCount = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $Id, 'send_request_status' => 'Yes'])->count();
        if ($Model != null) {
            $MailArray = array();
            $LastMail = Mailbox::find()->where(['from_user_id' => $Model->from_user_id, 'to_user_id' => $Id])->orderBy('MailId')->one();
            $MailCount = Mailbox::find()->where(['from_user_id' => $Model->from_user_id, 'to_user_id' => $Id])
                ->orWhere(['from_user_id' => $Id, 'to_user_id' => $Model->from_user_id])
                ->count();
            $MailConversation = Mailbox::find()->where(['from_user_id' => $Model->from_user_id, 'to_user_id' => $Id])
                ->orWhere(['from_user_id' => $Id, 'to_user_id' => $Model->from_user_id])
                ->orderBy(['MailId' => SORT_DESC])
                ->all();
            $MailArray[$Model->id]['LastMsg'] = str_replace("#NAME#", $Model->fromUserInfo->fullName, $LastMail->MailContent);
            $MailArray[$Model->id]['MsgCount'] = $MailCount;
            $myModel = [
                'model' => $Model,
                'MailArray' => $MailArray,
                'MailConversation' => $MailConversation,
                'MailUnreadCount' => $MailUnreadCount,
            ];
            return $this->renderAjax('_moreconversation', $myModel);
        }
    }

    public function actionAcceptDecline()
    {
        $Id = Yii::$app->user->identity->id;
        $ToUserId = Yii::$app->request->post('ToUserId');
        $Action = Yii::$app->request->post('Action');
        $RequestModel = new UserRequest();
        $ModelUser = User::findOne($Id);
        $ModelToUser = User::findOne($ToUserId);
        if ($Action == 'Accept') {
            $Model = $RequestModel->checkUsers($ToUserId, $Id);
            if ($Model->id) {
                $Model->scenario = UserRequest::SCENARIO_ACCEPT_INTEREST;
                $Model->send_request_status = 'Accepted';
                $Model->date_accept_request = CommonHelper::getTime();

                if ($Model->save()) {
                    $UserController = new UserController();
                    $ConvoStatus = $UserController->actionMailBoxLog($Id, $ToUserId, Yii::$app->params['requestAccepted']);
                    #CommonHelper::pr($ConvoStatus);exit;
                    if ($ConvoStatus == 'S') {
                        $LINK = CommonHelper::getSiteUrl('FRONTEND', 1) . 'user/profile?uk=' . $ModelUser->Registration_Number;
                        $GenderType = ($ModelUser->Gender == 'MALE') ? 'He' : 'She';
                        $MAIL_DATA = array("EMAIL" => $ModelToUser->email, "EMAIL_TO" => $ModelToUser->email, "NAME" => $ModelToUser->FullName, "USER_NAME" => $ModelUser->FullName, "REGISTER_NO" => $ModelUser->Registration_Number, 'LINK' => $LINK, 'GENDER_TYPE' => $GenderType);
                        MailHelper::SendMail('INTEREST_REQUEST_ACCEPT', $MAIL_DATA);
                        list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'REQUEST_ACCEPTED');
                    } else {
                        list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'REQUEST_ACCEPTED');
                    }
                } else {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'REQUEST_ACCEPTED');
                }

            }
        }
        #CommonHelper::pr(Yii::$app->request->post());exit;
        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE);
        return json_encode($return);

    }
}