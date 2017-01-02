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
        return $this->render('inbox',
            [
                'Id' => $Id,
                'Model' => '',
                'MailArray' => 10,
                'MailUnreadCount' => 20
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

    public function actionMoreConversation($uk = '') # VS
    {
        if (Yii::$app->user->isGuest || $uk == '') {
            return $this->redirect(['inbox']);
        }
        $Id = Yii::$app->user->identity->id;
        list($UserModel, $MessageModel, $OtherInformation, $HandleErrors) = $this->actionMoreConversationCommon($Id, $uk);
        if ($UserModel) {
            return $this->render('moreconversation',
                [
                    'Id' => $Id,
                    'UserModel' => $UserModel,
                    'MessageModel' => $MessageModel,
                    'OtherInformation' => $OtherInformation[0],
                    'HandleErrors' => $HandleErrors,
                ]
            );
        } else {
            return $this->redirect(['inbox']);
        }
    }

    public function actionMoreConversationCommon($Id, $uk, $Type = 'Inbox')
    {
        $OtherUserId = User::getIdNo($uk); # Get User Using Registration_Number.
        #var_dump($OtherUserId);
        #CommonHelper::pr($OtherUserId);exit;
        if (!Yii::$app->user->isGuest && $OtherUserId != NULL) {
            if ($Type == 'Inbox') {
                Mailbox::updateFromToReadStatus($OtherUserId, $Id); # Update Read Stats 'Yes'.
                $MessageModel = UserRequestOp::getMoreConversationInbox($Id, $OtherUserId);
            } else {
                $MessageModel = UserRequestOp::getMoreConversationSentBox($Id, $OtherUserId);
            }
            $UserModel = User::getUserFullInfromation($OtherUserId);
            $OtherInformationArray = array();
            if (count($MessageModel)) {
                list($TotalMailCount, $LastMail) = $this->getLastMailInfoAndUnreadMailCount($Id, $OtherUserId);
                $OtherInformationArray[0]['MailTotalCount'] = $TotalMailCount;
                $OtherInformationArray[0]['LastMailDate'] = $LastMail->dtadded;
                $OtherInformationArray[0]['LastMailReadStatus'] = $LastMail->read_status;
            } else {
                $HandleErrors = array('NoDataFound');
            }
            return array(
                $UserModel, # User Information
                $MessageModel, # Message Information
                $OtherInformationArray, # Last Message Information
                $HandleErrors, # Handel Errors
            );
        } else {
            return array(
                false
            );
        }
    }

    public function getLastMailInfoAndUnreadMailCount($Id, $ToUserId)
    {
        #$LastMessageDetails = Mailbox::getLastMail($Id, $ToUserId);
        $LastMessageDetails = Mailbox::getLastMailDetails($Id, $ToUserId);
        $TotalMailCount = Mailbox::getMailListCount($Id, $ToUserId);
        return array($TotalMailCount, $LastMessageDetails);

    }

    /* INBOX TAB Start */
    public function actionAll($Type = 'Inbox') #VS Inbox ALL Tab
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $Id = Yii::$app->user->identity->id;
        if ($Type == 'Inbox') {
            $ModelBox = Mailbox::getInboxList($Id, 10);
        } else {
            $ModelBox = UserRequestOp::getSendBoxList($Id, 10);
        }
        $OtherInformationArray = array();
        foreach ($ModelBox as $Key => $Value) {
            if ($Id == $Value->from_user_id) {
                $ToUserId = $Value->to_user_id;
            } else {
                $ToUserId = $Value->from_user_id;
            }
            list($TotalMailCount, $LastMail) = $this->getLastMailInfoAndUnreadMailCount($Id, $ToUserId);
            $OtherInformationArray[$ToUserId]['MailTotalCount'] = $TotalMailCount;
            $OtherInformationArray[$ToUserId]['LastMailDate'] = $LastMail->dtadded;
            $OtherInformationArray[$ToUserId]['LastMailReadStatus'] = $LastMail->read_status;
            if ($Type == 'Inbox') {
                if ($Value->from_user_id == $Id) {
                    $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->toUserInfo;
                } else {
                    $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->fromUserInfo;
                }
            }
        }
        return $this->render('all',
            [
                'Id' => $Id,
                'ModelBox' => $ModelBox,
                'OtherInformationArray' => $OtherInformationArray,
                'MailUnreadCount' => 10,//$MailUnreadCount
                'Type' => $Type,
            ]
        );
    }

    public function actionNew($Type = 'Inbox') #VS Inbox NEW Tab
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $Id = Yii::$app->user->identity->id;
        if ($Type == 'Inbox') {
            $ModelBox = Mailbox::getInboxNewList($Id, 10);
        } else {
            #$ModelBox = UserRequestOp::getSendBoxNweList($Id, 10);
        }
        $OtherInformationArray = array();
        foreach ($ModelBox as $Key => $Value) {
            if ($Id == $Value->from_user_id) {
                $ToUserId = $Value->to_user_id;
            } else {
                $ToUserId = $Value->from_user_id;
            }
            list($TotalMailCount, $LastMail) = $this->getLastMailInfoAndUnreadMailCount($Id, $ToUserId);
            $OtherInformationArray[$ToUserId]['MailTotalCount'] = $TotalMailCount;
            $OtherInformationArray[$ToUserId]['LastMailDate'] = $LastMail->dtadded;
            $OtherInformationArray[$ToUserId]['LastMailReadStatus'] = $LastMail->read_status;
            if ($Type == 'Inbox') {
                if ($Value->from_user_id == $Id) {
                    $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->toUserInfo;
                } else {
                    $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->fromUserInfo;
                }
            }
        }
        return $this->render('_inboxlist',
            [
                'Id' => $Id,
                'ModelBox' => $ModelBox,
                'OtherInformationArray' => $OtherInformationArray,
                'MailUnreadCount' => 10,//$MailUnreadCount
                'Type' => $Type,
            ]
        );
    }

    public function actionAccepted($Type = 'Inbox') #VS Inbox ACCEPTED Tab
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $Id = Yii::$app->user->identity->id;
        if ($Type == 'Inbox') {
            $ModelBox = Mailbox::getInboxAcceptedList($Id, 10);
        } else {
            #$ModelBox = UserRequestOp::getSendBoxNweList($Id, 10);
        }
        $OtherInformationArray = array();
        foreach ($ModelBox as $Key => $Value) {
            if ($Id == $Value->from_user_id) {
                $ToUserId = $Value->to_user_id;
            } else {
                $ToUserId = $Value->from_user_id;
            }
            list($TotalMailCount, $LastMail) = $this->getLastMailInfoAndUnreadMailCount($Id, $ToUserId);
            $OtherInformationArray[$ToUserId]['MailTotalCount'] = $TotalMailCount;
            $OtherInformationArray[$ToUserId]['LastMailDate'] = $LastMail->dtadded;
            $OtherInformationArray[$ToUserId]['LastMailReadStatus'] = $LastMail->read_status;
            if ($Type == 'Inbox') {
                if ($Value->from_user_id == $Id) {
                    $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->toUserInfo;
                } else {
                    $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->fromUserInfo;
                }
            }
        }
        return $this->render('_inboxlist',
            [
                'Id' => $Id,
                'ModelBox' => $ModelBox,
                'OtherInformationArray' => $OtherInformationArray,
                'MailUnreadCount' => 10,//$MailUnreadCount
                'Type' => $Type,
            ]
        );
    }

    public function actionNotinterested($Type = 'Inbox') #VS Inbox NOT-INTERESTED Tab
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $Id = Yii::$app->user->identity->id;
        if ($Type == 'Inbox') {
            $ModelBox = Mailbox::getInboxDeclinedList($Id, 10);
        } else {
            #$ModelBox = UserRequestOp::getSendBoxNweList($Id, 10);
        }
        $OtherInformationArray = array();
        foreach ($ModelBox as $Key => $Value) {
            if ($Id == $Value->from_user_id) {
                $ToUserId = $Value->to_user_id;
            } else {
                $ToUserId = $Value->from_user_id;
            }
            list($TotalMailCount, $LastMail) = $this->getLastMailInfoAndUnreadMailCount($Id, $ToUserId);
            $OtherInformationArray[$ToUserId]['MailTotalCount'] = $TotalMailCount;
            $OtherInformationArray[$ToUserId]['LastMailDate'] = $LastMail->dtadded;
            $OtherInformationArray[$ToUserId]['LastMailReadStatus'] = $LastMail->read_status;
            if ($Type == 'Inbox') {
                if ($Value->from_user_id == $Id) {
                    $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->toUserInfo;
                } else {
                    $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->fromUserInfo;
                }
            }
        }
        return $this->render('_inboxlist',
            [
                'Id' => $Id,
                'ModelBox' => $ModelBox,
                'OtherInformationArray' => $OtherInformationArray,
                'MailUnreadCount' => 10,//$MailUnreadCount
                'Type' => $Type,
            ]
        );
    }

    public function actionReplied($Type = 'Inbox')#VS Inbox REPLIED Tab
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $Id = Yii::$app->user->identity->id;
        if ($Type == 'Inbox') {
            $ModelBox = Mailbox::getInboxRepliedList($Id, 10);
        } else {
            #$ModelBox = UserRequestOp::getSendBoxNweList($Id, 10);
        }
        $OtherInformationArray = array();
        foreach ($ModelBox as $Key => $Value) {
            if ($Id == $Value->from_user_id) {
                $ToUserId = $Value->to_user_id;
            } else {
                $ToUserId = $Value->from_user_id;
            }
            list($TotalMailCount, $LastMail) = $this->getLastMailInfoAndUnreadMailCount($Id, $ToUserId);
            $OtherInformationArray[$ToUserId]['MailTotalCount'] = $TotalMailCount;
            $OtherInformationArray[$ToUserId]['LastMailDate'] = $LastMail->dtadded;
            $OtherInformationArray[$ToUserId]['LastMailReadStatus'] = $LastMail->read_status;
            if ($Type == 'Inbox') {
                if ($Value->from_user_id == $Id) {
                    $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->toUserInfo;
                } else {
                    $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->fromUserInfo;
                }
            }
        }
        return $this->render('_inboxlist',
            [
                'Id' => $Id,
                'ModelBox' => $ModelBox,
                'OtherInformationArray' => $OtherInformationArray,
                'MailUnreadCount' => 10,//$MailUnreadCount
                'Type' => $Type,
            ]
        );
    }

    /* INBOX TAB END */


    public function actionLastMsg($uk = '')
    {
        $Id = Yii::$app->user->identity->id;
        $request = Yii::$app->request;
        $params = $request->bodyParams;
        $uk = $params['uk'];

        if (Yii::$app->user->isGuest || $uk == '') {
            return $this->redirect(['inbox']);
        }
        $FromUserId = User::find()->select('id,Registration_Number,First_Name, Last_Name')->where(['Registration_Number' => $uk])->one();
        if ($FromUserId == null) {
            return $this->redirect(['inbox']);
        }

        #$MailUnreadCount = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $Id, 'send_request_status' => 'Yes'])->count();

        $LastMail = Mailbox::getLastMail($Id, $FromUserId->id);
        $MailArray = new \stdClass();
        if ($Id == $LastMail->to_user_id) {
            #if($LastMail->msg_type=='SendInterest'){
            $MailArray->FullName = $FromUserId->FullName;
            $MailArray->LastMailContent = str_replace('#NAME#', $FromUserId->FullName, $LastMail->MailContent);
            #}
        } else if ($Id == $LastMail->from_user_id) {
            $MailArray->FullName = Yii::$app->user->identity->FullName;
            $MailArray->LastMailContent = str_replace('#NAME#  has', 'You have been', $LastMail->MailContent);
            //you have been accepted
        } else {
            $MailArray->LastMailContent = str_replace('#NAME#', $FromUserId->FullName, $LastMail->MailContent);
        }
        #$LastMail->MailContent = $LastMailContent;
        #CommonHelper::pr($LastMail);
        #$LastMail = Mailbox::find()->where(['from_user_id' => $FromUserId->id, 'to_user_id' => $Id])->orderBy('MailId')->one();
        #CommonHelper::pr($LastMail);exit;
        /*$MailCount = Mailbox::find()->where(['from_user_id' => $Model->from_user_id, 'to_user_id' => $Id])
            ->orWhere(['from_user_id' => $Id, 'to_user_id' => $Model->from_user_id])
            ->count();
        $MailConversation = Mailbox::find()->where(['from_user_id' => $Model->from_user_id, 'to_user_id' => $Id])
            ->orWhere(['from_user_id' => $Id, 'to_user_id' => $Model->from_user_id])
            ->orderBy(['MailId' => SORT_DESC])
            ->all();
        $MailArray[$Model->id]['LastMsg'] = str_replace("#NAME#", $Model->fromUserInfo->fullName, $LastMail->MailContent);
        $MailArray[$Model->id]['MsgCount'] = $MailCount;*/
        $myModel = [
            'LastMail' => $LastMail,
            'Id' => $Id,
            'FromUserId' => $FromUserId,
            'MailArray' => $MailArray
        ];
        $HtmlOutput = $this->renderAjax('_last_msg_section', $myModel);
        $Output = array("HtmlOutput" => $HtmlOutput, "Notification" => array());
        return json_encode($Output);
        #return $this->renderAjax('_last_msg_section', $myModel);
    }

    public function actionMoreCoversationAll($uk = '')
    {
        $Id = Yii::$app->user->identity->id;
        $request = Yii::$app->request;
        $params = $request->bodyParams;
        $uk = $params['uk'];
        if (Yii::$app->user->isGuest || $uk == '') {
            return $this->redirect(['inbox']);
        }
        $FromUserId = User::find()->select('id,Registration_Number,First_Name, Last_Name')->where(['Registration_Number' => $uk])->one();
        if ($FromUserId == null) {
            return $this->redirect(['inbox']);
        }

        $MailList = Mailbox::getMailList($Id, $FromUserId->id);
        $MailListArray = array();
        foreach ($MailList as $KeyMail => $ValueMail) {
            #CommonHelper::pr($ValueMail);
            if ($Id == $ValueMail->to_user_id) {

                $MailListArray[$KeyMail]['Registration_Number'] = $FromUserId->Registration_Number;
                $MailListArray[$KeyMail]['FullName'] = $FromUserId->First_Name;
                $MailListArray[$KeyMail]['MailContent'] = str_replace('#NAME#', $FromUserId->FullName, $ValueMail->MailContent);
                $MailListArray[$KeyMail]['Date'] = $ValueMail->dtadded;
                if ($ValueMail->msg_type == 'SendInterest') {
                    $mailBoxSendInterestRECEIVER = str_replace('#GENDER#', (Yii::$app->user->identity->Gender == 'MALE') ? 'She' : 'He', Yii::$app->params['mailBoxSendInterestReceiver']);
                    $MailListArray[$KeyMail]['Subject'] = $mailBoxSendInterestRECEIVER;
                    $MailListArray[$KeyMail]['MailContent'] = str_replace('#NAME#', $FromUserId->FullName, $ValueMail->MailContent);
                } else {
                    $MailListArray[$KeyMail]['Subject'] = str_replace('#NAME#', $FromUserId->FullName, $ValueMail->MailContent);
                }
            } else if ($Id == $ValueMail->from_user_id) {
                $MailListArray[$KeyMail]['Registration_Number'] = Yii::$app->user->identity->Registration_Number;
                $MailListArray[$KeyMail]['FullName'] = 'You';//Yii::$app->user->identity->First_Name;
                $MailListArray[$KeyMail]['MailContent'] = str_replace('#NAME#  has', 'You have been', $ValueMail->MailContent);
                $MailListArray[$KeyMail]['Date'] = $ValueMail->dtadded;
                if ($ValueMail->msg_type == 'SendInterest') {
                    $mailBoxSendInterestSender = str_replace('#GENDER#', (Yii::$app->user->identity->Gender == 'MALE') ? 'her' : 'him', Yii::$app->params['mailBoxSendInterestSender']);
                    $MailListArray[$KeyMail]['Subject'] = $mailBoxSendInterestSender;
                    $MailListArray[$KeyMail]['MailContent'] = $mailBoxSendInterestSender;
                } else if ($ValueMail->msg_type == 'AcceptInterest') {
                    $MailListArray[$KeyMail]['Subject'] = str_replace('#NAME#  has', 'You have been', $ValueMail->MailContent);
                } else {
                    $MailListArray[$KeyMail]['Subject'] = str_replace('#NAME#', $FromUserId->FullName, $ValueMail->MailContent);
                }
            }
        }
        #CommonHelper::pr($MailListArray);exit;
        $myModel = [
            'MailList' => $MailList,
            'MailListArray' => $MailListArray
        ];
        $HtmlOutput = $this->renderAjax('_moreconversation', $myModel);
        $Output = array("HtmlOutput" => $HtmlOutput, "Notification" => array());
        return json_encode($Output);
        #$Model = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $Id, 'from_user_id' => $FromUserId->id, 'send_request_status' => ['Yes', 'Accepted']])->one();
        #$MailUnreadCount = UserRequest::find()->joinWith([fromUserInfo])->where(['to_user_id' => $Id, 'send_request_status' => 'Yes'])->count();
        /*if ($Model != null) {
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
            $HtmlOutput = $this->renderAjax('_moreconversation', $myModel);
            $Output = array("HtmlOutput" => $HtmlOutput, "Notification" => array());
            return json_encode($Output);
            #return $this->renderAjax('_moreconversation', $myModel);
        }*/
    }

    public function actionMoreCoversationAll_oldone_v($uk = '')
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
            $HtmlOutput = $this->renderAjax('_moreconversation', $myModel);
            $Output = array("HtmlOutput" => $HtmlOutput);
            return json_encode($Output);
            #return $this->renderAjax('_moreconversation', $myModel);
        }
    }

    public function actionAcceptDecline() //Not Usefull any more
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


    /* SENT BOX TAB Start */
    public function actionSentbox() #VS SentBox
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $Id = Yii::$app->user->identity->id;
        return $this->render('sentbox',
            [
                'Id' => $Id,
                'Model' => '',
                'MailArray' => 10,
                'MailUnreadCount' => 20,
                'MainMenu' => 'SentBox'
            ]
        );
    }

    public function actionSentboxAll()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $Id = Yii::$app->user->identity->id;
        $ModelBox = Mailbox::getSentboxAll($Id, 10);
        #CommonHelper::pr($ModelBox);exit;
        $OtherInformationArray = array();
        foreach ($ModelBox as $Key => $Value) {
            if ($Id == $Value->from_user_id) {
                $ToUserId = $Value->to_user_id;
            } else {
                $ToUserId = $Value->from_user_id;
            }
            list($TotalMailCount, $LastMail) = $this->getLastMailInfoAndUnreadMailCount($Id, $ToUserId);
            $OtherInformationArray[$ToUserId]['MailTotalCount'] = $TotalMailCount;
            $OtherInformationArray[$ToUserId]['LastMailDate'] = $LastMail->dtadded;
            $OtherInformationArray[$ToUserId]['LastMailReadStatus'] = $LastMail->read_status;
            if ($Value->from_user_id == $Id) {
                $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->toUserInfo;
            } else {
                $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->fromUserInfo;
            }
        }
        return $this->render('_sentboxtab',
            [
                'Id' => $Id,
                'ModelBox' => $ModelBox,
                'OtherInformationArray' => $OtherInformationArray,
                'MailUnreadCount' => 10,//$MailUnreadCount
                'MainMenu' => 'SentBox'
            ]
        );
    }

    public function actionSentboxUnread()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $Id = Yii::$app->user->identity->id;
        $ModelBox = Mailbox::getSentboxUnread($Id, 10);
        #CommonHelper::pr($ModelBox);exit;
        $OtherInformationArray = array();
        foreach ($ModelBox as $Key => $Value) {
            if ($Id == $Value->from_user_id) {
                $ToUserId = $Value->to_user_id;
            } else {
                $ToUserId = $Value->from_user_id;
            }
            list($TotalMailCount, $LastMail) = $this->getLastMailInfoAndUnreadMailCount($Id, $ToUserId);
            $OtherInformationArray[$ToUserId]['MailTotalCount'] = $TotalMailCount;
            $OtherInformationArray[$ToUserId]['LastMailDate'] = $LastMail->dtadded;
            $OtherInformationArray[$ToUserId]['LastMailReadStatus'] = $LastMail->read_status;
            if ($Value->from_user_id == $Id) {
                $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->toUserInfo;
            } else {
                $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->fromUserInfo;
            }
        }
        return $this->render('_sentboxtab',
            [
                'Id' => $Id,
                'ModelBox' => $ModelBox,
                'OtherInformationArray' => $OtherInformationArray,
                'MailUnreadCount' => 10,//$MailUnreadCount
                'MainMenu' => 'SentBox'
            ]
        );
    }

    public function actionSentboxAccepted()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $Id = Yii::$app->user->identity->id;
        $ModelBox = Mailbox::getSentboxAccepted($Id, 10);
        #CommonHelper::pr($ModelBox);exit;
        $OtherInformationArray = array();
        foreach ($ModelBox as $Key => $Value) {
            if ($Id == $Value->from_user_id) {
                $ToUserId = $Value->to_user_id;
            } else {
                $ToUserId = $Value->from_user_id;
            }
            list($TotalMailCount, $LastMail) = $this->getLastMailInfoAndUnreadMailCount($Id, $ToUserId);
            $OtherInformationArray[$ToUserId]['MailTotalCount'] = $TotalMailCount;
            $OtherInformationArray[$ToUserId]['LastMailDate'] = $LastMail->dtadded;
            $OtherInformationArray[$ToUserId]['LastMailReadStatus'] = $LastMail->read_status;
            if ($Value->from_user_id == $Id) {
                $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->toUserInfo;
            } else {
                $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->fromUserInfo;
            }
        }
        return $this->render('_sentboxtab',
            [
                'Id' => $Id,
                'ModelBox' => $ModelBox,
                'OtherInformationArray' => $OtherInformationArray,
                'MailUnreadCount' => 10,//$MailUnreadCount
                'MainMenu' => 'SentBox'
            ]
        );
    }

    public function actionSentboxDeclined()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $Id = Yii::$app->user->identity->id;
        $ModelBox = Mailbox::getSentboxDeclined($Id, 10);
        #CommonHelper::pr($ModelBox);exit;
        $OtherInformationArray = array();
        foreach ($ModelBox as $Key => $Value) {
            if ($Id == $Value->from_user_id) {
                $ToUserId = $Value->to_user_id;
            } else {
                $ToUserId = $Value->from_user_id;
            }
            list($TotalMailCount, $LastMail) = $this->getLastMailInfoAndUnreadMailCount($Id, $ToUserId);
            $OtherInformationArray[$ToUserId]['MailTotalCount'] = $TotalMailCount;
            $OtherInformationArray[$ToUserId]['LastMailDate'] = $LastMail->dtadded;
            $OtherInformationArray[$ToUserId]['LastMailReadStatus'] = $LastMail->read_status;
            if ($Value->from_user_id == $Id) {
                $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->toUserInfo;
            } else {
                $OtherInformationArray[$ToUserId]['ModelInfo'] = $Value->fromUserInfo;
            }
        }
        return $this->render('_sentboxtab',
            [
                'Id' => $Id,
                'ModelBox' => $ModelBox,
                'OtherInformationArray' => $OtherInformationArray,
                'MailUnreadCount' => 10,//$MailUnreadCount
                'MainMenu' => 'SentBox'
            ]
        );
    }

    /* SENT BOX TAB END */

}