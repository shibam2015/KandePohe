<?php
namespace frontend\controllers;

use common\components\CommonHelper;
use common\components\MessageHelper;
use common\components\SmsHelper;
use common\models\Mailbox;
use common\models\PartnersAnnualIncome;
use common\models\PartnersCities;
use common\models\PartnersCommunity;
use common\models\PartnersCountries;
use common\models\PartnersMothertongue;
use common\models\PartnersStates;
use common\models\PartnersSubcommunity;
use common\models\PartnerWorkingAs;
use common\models\PartnerWorkingWith;
use common\models\Tags;
use common\models\UserPhotos;
use common\models\UserRequest;
use common\models\UserRequestOp;
use common\models\UserTag;
use common\models\Wightege;
use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
#use frontend\components\CommonHelper;

use common\models\User;
use common\models\PartenersReligion;
use common\models\UserPartnerPreference;
use common\models\PartnersMaritalStatus;
use common\models\PartnersGotra;
use common\models\PartnersFathersStatus;
use common\models\PartnersMothersStatus;
use common\models\PartnersEducationalLevel;
use common\models\PartnersEducationField;
use yii\widgets\ActiveForm;
use yii\web\Response;
use common\components\MailHelper;

/**
 * Site controller
 */
class UserController extends Controller
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

    public static function profileCompleteness($x)
    {
        #$id = Yii::$app->user->identity->id;
        #$USER = User::findOne($id);
        $PERCENTAGE = 0;
        $STEP_ARRAY = explode(",", $x);
        foreach ($STEP_ARRAY as $k => $v) {
            if ($v != '') {
                if ($model = Wightege::findOne($v)) {
                    $PERCENTAGE += $model->vWightegePercent;
                }
                #if($USER->ePhoneVerifiedStatus =='Yes'){ $PERCENTAGE += $model->vWightegePercent;}
                #if($USER->eEmailVerifiedStatus =='Yes'){ $PERCENTAGE += $model->vWightegePercent;}
            }
        }

        if ($PERCENTAGE <= 50) $PERCENTAGE -= 1;
        if ($PERCENTAGE != 0) $PERCENTAGE += 5;

        return $PERCENTAGE;
    }

    public function beforeAction($action) {
        //$this->enableCsrfValidation = false;
        return parent::beforeAction($action);
    }

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
        $model = new User();
        $model->scenario = User::SCENARIO_REGISTER;
        return $this->redirect(['user/dashboard']);
        /*return $this->render('index',
            ['model' => $model]
        );*/
    }

    public function actionMyProfile($tab = '')
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        CommonHelper::checkVerification();
        $id = Yii::$app->user->identity->id;
        $model = User::find()->joinWith([countryName, stateName, cityName, height, maritalStatusName, talukaName, districtName, gotraName, subCommunityName, communityName, religionName, educationLevelName, communityName, workingWithName, workingAsName, dietName, fatherStatus])->where(['id' => $id])->one();
        $USER_PHOTO_MODEL = new  UserPhotos();
        $USER_PHOTOS_LIST = $USER_PHOTO_MODEL->findByUserId($id);
        $COVER_PHOTO = CommonHelper::getCoverPhotos($TYPE = 'USER', $id, $model->cover_photo);
        $TAG_LIST = Tags::find()->orderBy('rand()')->all();   //orderBy(['rand()' => SORT_DESC]);
        $TAG_LIST_USER = UserTag::find()->joinWith([tagName])->where(['iUser_Id' => $id])->orderBy(['Name' => SORT_ASC])->all();
        $Gender = (Yii::$app->user->identity->Gender == 'MALE') ? 'FEMALE' : 'MALE';
        list($SimilarProfile, $SuccessStories) = $this->actionRightSideBar($Gender, $id, 3);
        return $this->render('my-profile',
            ['model' => $model, 'photo_model' => $USER_PHOTOS_LIST, 'COVER_PHOTO' => $COVER_PHOTO, 'TAG_LIST' => $TAG_LIST, 'TAG_LIST_USER' => $TAG_LIST_USER, 'SimilarProfile' => $SimilarProfile, 'tab' => $tab]

        );
    }

    public function actionRightSideBar($Gender, $Id, $Limit = 3)
    {
        $SimilarProfile = User::findRecentJoinedUserList($Gender, $Id, $Limit); #TODO : Change recent joined user list with Similer Profile.
        return array($SimilarProfile, 'Success Stories');
    }

    public function actionDashboard($type = '')
    {
        if (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->identity->id;
            if($model = User::findOne($id)){
                CommonHelper::checkVerification();
                $model->scenario = User::SCENARIO_REGISTER6;
                $VER_ARRAY = array();
                $Gender = (Yii::$app->user->identity->Gender == 'MALE') ? 'FEMALE' : 'MALE';
                #$ProfileViedByMembers = UserRequest::findProfileViewedByUserList($id, 4);
                $ProfileViedByMembers = UserRequestOp::findProfileViewedByUserList($id, 4);
                //$RecentlyJoinedMembers = User::findRecentJoinedUserLists($id,$Gender, 4);
                $RecentlyJoinedMembers = User::findRecentJoinedUserList($Gender, 4);
                //echo $RecentlyJoinedMembers->createCommand()->sql;exit;
                list($SimilarProfile, $SuccessStories) = $this->actionRightSideBar($Gender, $id, 3);

                #Shortlist User
                $ShortList = UserRequestOp::getShortList($id, 0, 3);
                foreach ($ShortList as $Key => $Value) {
                    #CommonHelper::pr($Value);exit;
                    if ($Value->from_user_id == $id) {
                        $ShortListInfo[$Key] = $Value->toUserInfo;
                    } else {
                        $ShortListInfo[$Key] = $Value->fromUserInfo;
                    }
                }
                #CommonHelper::pr($ModelInfo);
                #CommonHelper::pr($ShortList);exit;

                return $this->render('dashboard',[
                    'model' => $model,
                    'VER_ARRAY' => $VER_ARRAY,
                    'type' => $type,
                    'RecentlyJoinedMembers' => $RecentlyJoinedMembers,
                    'ProfileViedByMembers' => $ProfileViedByMembers,
                    'SimilarProfile' => $SimilarProfile,
                    'ShortListUser' => $ShortListInfo,
                ]);
            }else{
                return $this->redirect(Yii::getAlias('@web'));
            }
        }else{
            return $this->redirect(Yii::getAlias('@web'));
        }
    }

    public function actionPhotos($ref = '')
    {
        if (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->identity->id;
            $USER_PHOTO_MODEL = new UserPhotos();
            $USER_PHOTOS_LIST = $USER_PHOTO_MODEL->findByUserId($id);
            if ($model = User::findOne($id)) {
                $model->scenario = User::SCENARIO_REGISTER6;
                $target_dir = Yii::getAlias('@web') . '/uploads/';
                if (Yii::$app->request->post()) {
                    $TimeOut = CommonHelper::getDateTimeToString(CommonHelper::getTime());
                    if ($model->eEmailVerifiedStatus == 'No' && $model->pin_email_vaerification == '') {
                        $PIN = CommonHelper::generateNumericUniqueToken(4);
                        $model->pin_email_vaerification = $PIN;
                        $model->pin_email_time = $TimeOut;
                        $MAIL_DATA = array("EMAIL" => $model->email, "EMAIL_TO" => $model->email, "NAME" => $model->FullName, "PIN" => $PIN,'MINUTES'=> Yii::$app->params['timePinValidate']);
                        MailHelper::SendMail('EMAIL_VERIFICATION_PIN', $MAIL_DATA);
                    }
                    if ($model->ePhoneVerifiedStatus == 'No' && $model->pin_phone_vaerification == 0) {
                        $PIN_P = CommonHelper::generateNumericUniqueToken(4);
                        $model->pin_phone_vaerification = $PIN_P;
                        $model->pin_phone_time = $TimeOut;
                        if ($model->Mobile != 0 && strlen($model->Mobile) == 10) {
                            #$SMSFlag = SmsHelper::SendSMS($PIN_P, $model->Mobile);
                            $SMSArray = array("OTP" => $PIN_P);
                            $SMSFlag = SmsHelper::SendSMS($model->new_phone_no, 'PHONE_OTP', $SMSArray);
                            #$SMSFlag = SmsHelper::SendSMS($PIN_P, $model->new_phone_no);
                        }
                    }
                    #echo "<br> *** 4 ***";
                    $model->completed_step = $model->setCompletedStep('7');
                    if ($model->save($model)) {
                      #  echo "<br> *** 5 ***";exit;
                        $this->redirect(['site/verification']);
                    }
                }
                if ($model->propic != '')
                    $model->propic = $target_dir . $model->propic;
                return $this->render('photos', [
                    'model' => $USER_PHOTOS_LIST,
                    'model_user' => $model,
                    'USER_APPROVED' => \common\models\User::weightedCheck(10),
                    'ref' => $ref
                ]);
            } else {
                return $this->redirect(Yii::getAlias('@web'));
            }
        } else {
            return $this->redirect(Yii::getAlias('@web'));
        }

    }

    public function actionPhotoUpload($id)
    {
        $id = Yii::$app->user->identity->id;
        if ($model = User::findOne($id)) {
            $FILE_COUNT = count($_FILES);
            $UserPhotos = new UserPhotos();
            $MaximumPhotoLimit = Yii::$app->params['total_files_allowed'];
            $TotalUploadPhotos = $UserPhotos->totalUploadPhotos($id);
            $TotalUploads = $TotalUploadPhotos + count($_FILES["__files"]['name']);
            $RemainingLimit = $MaximumPhotoLimit - $TotalUploadPhotos;
            if ($TotalUploads <= $MaximumPhotoLimit) {
                $model->scenario = User::SCENARIO_REGISTER6;
                if ($FILE_COUNT != 0) {
                    $CM_HELPER = new CommonHelper();
                    $PATH = $CM_HELPER->getUserUploadFolder(1) . $id . "/";
                    $URL = $CM_HELPER->getUserUploadFolder(2) . $id . "/";
                    $USER_SIZE_ARRAY = $CM_HELPER->getUserResizeRatio();
                    $PHOTO_ARRAY = CommonHelper::photoUploads($id, $_FILES["__files"], $PATH, $URL, $USER_SIZE_ARRAY, '');
                    if ($PHOTO_ARRAY['STATUS']) {
                        if (is_array($PHOTO_ARRAY['PhotoArray'])) {
                            foreach ($PHOTO_ARRAY['PhotoArray']['images'] as $PhotoKey => $PhotoValue) {
                                $PG = new UserPhotos();
                                $PG->iUser_ID = $id;
                                $PG->Is_Profile_Photo = 'NO';
                                $PG->dtCreated = CommonHelper::getTime();
                                $PG->dtModified = CommonHelper::getTime();
                                $PG->File_Name = $PhotoValue;
                                $ACTION_FLAG = $PG->save();
                            }
                        }
                        if ($ACTION_FLAG) {
                            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PHOTO_UPLOAD');
                        } else {
                            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PHOTO_UPLOAD');
                        }
                    } else {
                        list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PHOTO_UPLOAD');
                        $MESSAGE = $PHOTO_ARRAY['MESSAGE'];
                    }
                }
                $USER_PHOTOS_LIST = $UserPhotos->findByUserId($id);
                $myModel = [
                    'model' => $USER_PHOTOS_LIST,
                ];
                $HtmlOutput = $this->renderAjax('_photolist', $myModel);
            } else {
                $STATUS = 'E';
                $MESSAGE = CommonHelper::replaceNotificationMessage(Yii::$app->params['uploadLimitError'], array('LIMIT' => $RemainingLimit));
                $TITLE = Yii::$app->params['titleWarrning'];
            }
            $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE, 'HtmlOutput' => $HtmlOutput);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $return;
        } else {
            return $this->redirect(Yii::getAlias('@web'));
        }
    }

    /**
     * @return string
     */
    public function actionPhotoOperation()
    {
        $PG = new UserPhotos();
        $CM_HELPER = new CommonHelper();
        $id = Yii::$app->user->identity->id;
        $P_ID = Yii::$app->request->post('P_ID');
        $P_TYPE = Yii::$app->request->post('P_TYPE');
        $OUTPUT_HTML = '';
        $OUTPUT_HTML_ONE = '';
        $PROFILE_PHOTO = '';
        $PROFILE_PHOTO_ONE = '';
        if ($P_ID != '' && $P_TYPE == 'PHOTO_DELETE' && $P_TYPE != '') {
            $USER_PHOTOS_LIST = $PG->findByPhotoId($id, $P_ID);
            if (count($USER_PHOTOS_LIST) != 0) {
                $IS_PROFILE = $USER_PHOTOS_LIST->Is_Profile_Photo;
                $PHOTO = $USER_PHOTOS_LIST->File_Name;
                $PATH = $CM_HELPER->getUserUploadFolder(1) . "/" . $id . "/";
                $USER_SIZE_ARRAY = $CM_HELPER->getUserResizeRatio();
                $CM_HELPER->photoDeleteFromFolder($PATH, $USER_SIZE_ARRAY, $PHOTO);
                $ACTION_FLAG = $USER_PHOTOS_LIST->delete();
                if ($IS_PROFILE == 'YES') {
                    $PROFILE_PHOTO = CommonHelper::getPhotos('USER', $id, $PHOTO, '200');
                    $PROFILE_PHOTO_ONE = CommonHelper::getPhotos('USER', $id, $PHOTO, '30');
                }
                if ($ACTION_FLAG) {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PHOTO_DELETE');
                } else {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PHOTO_DELETE');

                }
            }
        } else {
            $PG->updateIsProfilePhoto($id);
            $USER_PHOTOS_LIST = $PG->findByPhotoId($id, $P_ID);
            if (count($USER_PHOTOS_LIST) != 0) {
                $USER_MODEL = User::findOne($id);
                #echo "<pre>";print_R($USER_MODEL);
                $PHOTO = $USER_PHOTOS_LIST->File_Name;
                $USER_MODEL->propic = $PHOTO;
                $USER_MODEL->eStatusPhotoModify = 'Pending';
                $USER_MODEL->completed_step = $USER_MODEL->setCompletedStep('7');
                $USER_MODEL->save();
                $ACTION_FLAG = $USER_MODEL->save();
                $USER_PHOTOS_LIST->Is_Profile_Photo = 'YES';
                $USER_PHOTOS_LIST->eStatus = 'Pending';
                $USER_PHOTOS_LIST->save();
                if ($ACTION_FLAG) {
                    $PROFILE_PHOTO .= CommonHelper::getPhotos('USER', $id, Yii::$app->params['thumbnailPrefix'] . "200_" . $PHOTO, '200');
                    $PROFILE_PHOTO_ONE = CommonHelper::getPhotos('USER', $id, Yii::$app->params['thumbnailPrefix'] . "30_" . $PHOTO, '30');
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PROFILE_PHOTO_SET');
                } else {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PROFILE_PHOTO_SET');
                }
            }
        }
        $USER_PHOTOS_LIST = $PG->findByUserId($id);
        $myModel = [
            'model' => $USER_PHOTOS_LIST,
        ];
        $HtmlOutput = $this->renderAjax('_photolist', $myModel);
        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE, 'HtmlOutput' => $HtmlOutput, 'PROFILE_PHOTO' => $PROFILE_PHOTO, 'PROFILE_PHOTO_ONE' => $PROFILE_PHOTO_ONE);
        return json_encode($return);
    }

    public function actionEditMyinfo()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_EDIT_MY_INFO;
        $show = false;
        $popup = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if (Yii::$app->request->post('save')) {
                $tYourSelf_old = $model->tYourSelf;
                $model->tYourSelf = Yii::$app->request->post('User')['tYourSelf'];
                if (strcmp($tYourSelf_old, $model->tYourSelf) !== 0) {
                    $model->eStatusInOwnWord = 'Pending';
                    $popup = true;
                }
                if ($model->validate()) {
                    $model->save();
                    $show = false;
                }
            }
        }
        #return $this->actionRenderAjax($model,'_myinfo',true);
        return $this->actionRenderAjax($model, '_myinfo', $show, $popup);
    }

    function actionRenderAjax($model, $view, $show = false, $popup = false, $flag = false, $temp = array())
    {
        return $this->renderAjax($view, [
            'model' => $model,
            'show' => $show,
            'popup' => $popup,
            'flag' => $flag,
            'temp' => $temp,
        ]);
    }

    public function actionEditPersonalInfo()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_EDIT_PERSONAL_INFO;
        $show = false;
        $popup = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if(Yii::$app->request->post('save')){
                $NewMobileNo = Yii::$app->request->post('User')['Mobile'];
                $OldMobileNo = $model->Mobile;
                $model->First_Name = Yii::$app->request->post('User')['First_Name'];
                $model->Last_Name = Yii::$app->request->post('User')['Last_Name'];
                $model->Profile_created_for = Yii::$app->request->post('User')['Profile_created_for'];
                $model->DOB = Yii::$app->request->post('User')['DOB'];
                $model->Age = CommonHelper::ageCalculator(Yii::$app->request->post('User')['DOB']);
                $model->county_code = Yii::$app->request->post('User')['county_code'];
                $model->Mobile = $NewMobileNo;
                $model->Gender = Yii::$app->request->post('User')['Gender'];
                $model->mother_tongue = Yii::$app->request->post('User')['mother_tongue'];
                if($model->validate()){
                    if ($NewMobileNo != $OldMobileNo) {
                        $TimeOut = CommonHelper::getDateTimeToString(CommonHelper::getTime());
                        $PIN_P = CommonHelper::generateNumericUniqueToken(4);
                        //new_phone_no
                        $model->new_phone_no = $NewMobileNo;
                        $model->pin_phone_vaerification = $PIN_P;
                        $model->ePhoneVerifiedStatus = 'No';
                        $model->pin_phone_time = $TimeOut;
                        $model->completed_step = CommonHelper::unsetStep($model->completed_step, 8);
                        $SMSArray = array("OTP" => $PIN_P);
                        $SMSFlag = SmsHelper::SendSMS($NewMobileNo, 'PHONE_OTP', $SMSArray);
                        #$SMSFlag = SmsHelper::SendSMS($PIN_P, $NewMobileNo);
                        $popup = true;
                    }
                    $model->Mobile = $OldMobileNo;
                    $model->save();
                    $show = false;
                }
            }
        }

        return $this->actionRenderAjax($model, '_personalinfo', $show, $popup);
    }

    public function actionEditBasicInfo()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_REGISTER1;
        $show = false;

        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if (Yii::$app->request->post('save')) {
                $model->iReligion_ID = Yii::$app->request->post('User')['iReligion_ID'];
                $model->iCommunity_ID = Yii::$app->request->post('User')['iCommunity_ID'];
                $model->iSubCommunity_ID = Yii::$app->request->post('User')['iSubCommunity_ID'];
                $model->iGotraID = Yii::$app->request->post('User')['iGotraID'];
                $model->iMaritalStatusID = Yii::$app->request->post('User')['iMaritalStatusID'];
                $model->noc = Yii::$app->request->post('User')['noc'];
                $model->iCountryId = Yii::$app->request->post('User')['iCountryId'];
                $model->iStateId = Yii::$app->request->post('User')['iStateId'];
                $model->iCityId = Yii::$app->request->post('User')['iCityId'];
                $model->iDistrictID = Yii::$app->request->post('User')['iDistrictID'];
                $model->iTalukaID = Yii::$app->request->post('User')['iTalukaID'];
                $model->vAreaName = Yii::$app->request->post('User')['vAreaName'];
                if ($model->validate()) {
                    $model->completed_step = $model->setCompletedStep('2');
                    $model->save();
                    $show = false;
                }
            }
        }
        //var_dump($show);
        return $this->actionRenderAjax($model, '_basicinfo', $show);
    }

    public function actionEditEducation()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_REGISTER2;
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if(Yii::$app->request->post('save')){
                $model->iEducationLevelID = Yii::$app->request->post('User')['iEducationLevelID'];
                $model->iEducationFieldID = Yii::$app->request->post('User')['iEducationFieldID'];
                $model->iWorkingWithID = Yii::$app->request->post('User')['iWorkingWithID'];
                $model->iWorkingAsID = Yii::$app->request->post('User')['iWorkingAsID'];
                $model->iAnnualIncomeID = Yii::$app->request->post('User')['iAnnualIncomeID'];
                if ($model->validate()) {
                    $model->completed_step = $model->setCompletedStep('3');
                    $model->save();
                    $show = false;
                }
            }
        }

        if ($show) {
            return $this->actionRenderAjax($model, '_education', true);
        } else {
            return $this->actionRenderAjax($model, '_education', false);
        }
    }

    public function actionEditLifestyle()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_EDIT_LIFESTYLE;
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if(Yii::$app->request->post('save')){
                $model->iHeightID = Yii::$app->request->post('User')['iHeightID'];
                $model->vSkinTone = Yii::$app->request->post('User')['vSkinTone'];
                $model->vBodyType = Yii::$app->request->post('User')['vBodyType'];
                $model->vSmoke = Yii::$app->request->post('User')['vSmoke'];
                $model->vDrink = Yii::$app->request->post('User')['vDrink'];
                $model->vSpectaclesLens = Yii::$app->request->post('User')['vSpectaclesLens'];
                $model->vDiet = Yii::$app->request->post('User')['vDiet'];
                $model->weight = Yii::$app->request->post('User')['weight'];
                if($model->validate()){
                    $model->completed_step = $model->setCompletedStep('4');
                    $model->save();
                    $show = false;
                }
            }
        }

        if ($show) {
            return $this->actionRenderAjax($model, '_lifestyle', true);
        } else {
            return $this->actionRenderAjax($model, '_lifestyle', false);
        }
    }

    public function actionEditFamily()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_REGISTER4;
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if(Yii::$app->request->post('save')){
                $model->iFatherStatusID = Yii::$app->request->post('User')['iFatherStatusID'];
                $model->iFatherWorkingAsID = Yii::$app->request->post('User')['iFatherWorkingAsID'];
                $model->iMotherStatusID = Yii::$app->request->post('User')['iMotherStatusID'];
                $model->iMotherWorkingAsID = Yii::$app->request->post('User')['iMotherWorkingAsID'];
                $model->nob = Yii::$app->request->post('User')['nob'];
                $model->nos = Yii::$app->request->post('User')['nos'];
                $model->iCountryCAId = Yii::$app->request->post('User')['iCountryCAId'];
                $model->iStateCAId = Yii::$app->request->post('User')['iStateCAId'];
                $model->iCityCAId = Yii::$app->request->post('User')['iCityCAId'];
                $model->iDistrictCAID = Yii::$app->request->post('User')['iDistrictCAID'];
                $model->iTalukaCAID = Yii::$app->request->post('User')['iTalukaCAID'];
                $model->vAreaNameCA = Yii::$app->request->post('User')['vAreaNameCA'];
                $model->vNativePlaceCA = Yii::$app->request->post('User')['vNativePlaceCA'];
                $model->vParentsResiding = Yii::$app->request->post('User')['vParentsResiding'];
                $model->vFamilyAffluenceLevel = Yii::$app->request->post('User')['vFamilyAffluenceLevel'];
                $model->vFamilyType = Yii::$app->request->post('User')['vFamilyType'];
                $family_property_array = Yii::$app->request->post('User')['vFamilyProperty'];
                if (is_array($family_property_array)) {
                    $model->vFamilyProperty = implode(",", $family_property_array);
                } else {
                    $model->vFamilyProperty = '';
                }
                $model->vDetailRelative = Yii::$app->request->post('User')['vDetailRelative'];
                if ($model->validate()) {
                    $model->completed_step = $model->setCompletedStep('5');
                    $model->save();
                    $show = false;
                }
            }
        }

        if ($show) {
            return $this->actionRenderAjax($model, '_family', true);
        }
        else {
            return $this->actionRenderAjax($model, '_family', false);
        }
    }

    public function actionEditPreferences()
    {
        $id = Yii::$app->user->identity->id;
        $PartenersReligion = PartenersReligion::findByUserId($id) == NULL ? new PartenersReligion() : PartenersReligion::findByUserId($id);
        $UPP = UserPartnerPreference::findByUserId($id) == NULL ? new UserPartnerPreference() : UserPartnerPreference::findByUserId($id);
        $PartnersMaritalStatus = PartnersMaritalStatus::findByUserId($id) == NULL ? new PartnersMaritalStatus() : PartnersMaritalStatus::findByUserId($id);
        $PartnersGotra = PartnersGotra::findByUserId($id) == NULL ? new PartnersGotra() : PartnersGotra::findByUserId($id);
        $PartnersMothertongue = PartnersMothertongue::findByUserId($id) == NULL ? new PartnersMothertongue() : PartnersMothertongue::findByUserId($id);
        //$MasterHeight = MasterHeight::findByUserId($id) == NULL ? new MasterHeight() : MasterHeight::findByUserId($id);
        $PartnersCommunity = PartnersCommunity::findByUserId($id) == NULL ? new PartnersCommunity() : PartnersCommunity::findByUserId($id);
        $PartnersSubCommunity = PartnersSubcommunity::findByUserId($id) == NULL ? new PartnersSubcommunity() : PartnersSubcommunity::findByUserId($id);
        $model = User::findOne($id);
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if(Yii::$app->request->post('save')){
                $CurrDate = date('Y-m-d H:i:s');

                $ReligionId = Yii::$app->request->post('PartenersReligion')['iReligion_ID'];
                $PartenersReligion->iUser_ID = $id;
                $PartenersReligion->iReligion_ID = $ReligionId;
                $PartenersReligion->dtModified = $CurrDate;
                if ($PartenersReligion->iPartners_Religion_ID == "") {
                    $PartenersReligion->dtCreated = $CurrDate;
                }
                $PartenersReligion->save();

                $UPP->iUser_id = $id;
                $UPP->age_from = Yii::$app->request->post('UserPartnerPreference')['age_from'];
                $UPP->age_to = Yii::$app->request->post('UserPartnerPreference')['age_to'];
                $UPP->manglik = Yii::$app->request->post('UserPartnerPreference')['manglik'];
                $UPP->height_from = Yii::$app->request->post('UserPartnerPreference')['height_from'];
                $UPP->height_to = Yii::$app->request->post('UserPartnerPreference')['height_to'];
                $UPP->drink = Yii::$app->request->post('UserPartnerPreference')['drink'];
                $UPP->smoke = Yii::$app->request->post('UserPartnerPreference')['smoke'];
                $UPP->modified_on = $CurrDate;

                if ($UPP->ID == "") {
                    $UPP->created_on = $CurrDate;
                }
                $UPP->save();

                $MaritalStatusID = Yii::$app->request->post('PartnersMaritalStatus')['iMarital_Status_ID'];
                $PartnersMaritalStatus->iUser_ID = $id;
                $PartnersMaritalStatus->iMarital_Status_ID = $MaritalStatusID;
                $PartnersMaritalStatus->dtModified = $CurrDate;
                if ($PartnersMaritalStatus->iPartners_Marital_Status_ID == "") {
                    $PartnersMaritalStatus->dtCreated = $CurrDate;
                }
                $PartnersMaritalStatus->save();

                $GotraID = Yii::$app->request->post('PartnersGotra')['iGotra_ID'];
                $PartnersGotra->iUser_ID = $id;
                $PartnersGotra->iGotra_ID = $GotraID;
                $PartnersGotra->dtModified = $CurrDate;
                if ($PartnersGotra->iPartners_Gotra_ID == "") {
                    $PartnersGotra->dtCreated = $CurrDate;
                }
                $PartnersGotra->save();
                $show = false;

                $MotherID = Yii::$app->request->post('PartnersMothertongue')['iMothertongue_ID'];
                $PartnersMothertongue->scenario = PartnersMothertongue::SCENARIO_ADD;
                $PartnersMothertongue->iUser_ID = $id;
                $PartnersMothertongue->iMothertongue_ID = $MotherID;
                $PartnersMothertongue->dtModified = $CurrDate;
                if ($PartnersMothertongue->iPartners_Mothertongue_ID == "") {
                    $PartnersMothertongue->dtCreated = $CurrDate;
                }
                $PartnersMothertongue->save();
                $show = false;

                $CommunityID = Yii::$app->request->post('PartnersCommunity')['iCommunity_ID'];
                $PartnersCommunity->scenario = PartnersCommunity::SCENARIO_ADD;
                $PartnersCommunity->iUser_ID = $id;
                $PartnersCommunity->iCommunity_ID = $CommunityID;
                $PartnersCommunity->dtModified = $CurrDate;
                if ($PartnersCommunity->iPartners_Community_ID == "") {
                    $PartnersCommunity->dtCreated = $CurrDate;
                }
                $PartnersCommunity->save();
                $show = false;

                $SubCommuID = Yii::$app->request->post('PartnersSubcommunity')['iSub_Community_ID'];
                //CommonHelper::pr($PartnersSubCommunity);exit;
                $PartnersSubCommunity->scenario = PartnersSubcommunity::SCENARIO_ADD;
                $PartnersSubCommunity->iUser_ID = $id;
                $PartnersSubCommunity->iSub_Community_ID = $SubCommuID;
                $PartnersSubCommunity->dtModified = $CurrDate;
                if ($PartnersSubCommunity->iPartners_Subcommunity_ID == "") {
                    $PartnersSubCommunity->dtCreated = $CurrDate;
                }
                $PartnersSubCommunity->save();
                $show = false;
            }
        }
        $myModel = [
            'PartenersReligion' => $PartenersReligion,
            'model' => $model,
            'UPP' => $UPP,
            'PartnersMaritalStatus' => $PartnersMaritalStatus,
            'PartnersGotra' => $PartnersGotra,
            'PartnersMothertongue' => $PartnersMothertongue,
            'PartnersCommunity' => $PartnersCommunity,
            'PartnersSubCommunity' => $PartnersSubCommunity,
            'show' => $show
        ];
        return $this->renderAjax('_preferences', $myModel);
    }

    public function actionEditPreferencesProfession()
    {
        $id = Yii::$app->user->identity->id;
        $PartnersEducationalLevel = PartnersEducationalLevel::findByUserId($id) == NULL ? new PartnersEducationalLevel() : PartnersEducationalLevel::findByUserId($id);
        $PartnersEducationField = PartnersEducationField::findByUserId($id) == NULL ? new PartnersEducationField() : PartnersEducationField::findByUserId($id);
        $PW = PartnerWorkingAs::findByUserId($id) == NULL ? new PartnerWorkingAs() : PartnerWorkingAs::findByUserId($id);
        $WorkingW = PartnerWorkingWith::findByUserId($id) == NULL ? new PartnerWorkingWith() : PartnerWorkingWith::findByUserId($id);
        $AI = PartnersAnnualIncome::findByUserId($id) == NULL ? new PartnersAnnualIncome() : PartnersAnnualIncome::findByUserId($id);
        $model = User::findOne($id);
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if (Yii::$app->request->post('save')) {
                $EducationLevelID = Yii::$app->request->post('PartnersEducationalLevel')['iEducation_Level_ID'];
                $PartnersEducationalLevel->iUser_ID = $id;
                $PartnersEducationalLevel->iEducation_Level_ID = $EducationLevelID;
                $PartnersEducationalLevel->save();

                $EducationFieldID = Yii::$app->request->post('PartnersEducationField')['iEducation_Field_ID'];
                $PartnersEducationField->iUser_ID = $id;
                $PartnersEducationField->iEducation_Field_ID = $EducationFieldID;
                $PartnersEducationField->save();
                $show = false;

                $PWI = Yii::$app->request->post('PartnerWorkingAs')['iWorking_As_ID'];
                $PW->iUser_ID = $id;
                $PW->iWorking_As_ID = $PWI;
                $PW->save();
                $show = false;

                $WorkingId = Yii::$app->request->post('PartnerWorkingWith')['iWorking_With_ID'];
                //$WorkingW->scenario = PartnerWorkingWith::SCENARIO_ADD;
                $WorkingW->iUser_ID = $id;
                $WorkingW->iWorking_With_ID = $WorkingId;
                //$WorkingW->dtModified = $CurrDate;
                //if($WorkingW->ID == ""){
                //   $WorkingW->dtCreated = $CurrDate;
                // }
                $WorkingW->save();
                $show = false;

                $AnuualId = Yii::$app->request->post('PartnersAnnualIncome')['annual_income_id'];
                //$WorkingW->scenario = PartnerWorkingWith::SCENARIO_ADD;
                $AI->user_id = $id;
                $AI->annual_income_id = $AnuualId;
                //$WorkingW->dtModified = $CurrDate;
                //if($WorkingW->ID == ""){
                //   $WorkingW->dtCreated = $CurrDate;
                // }
                $AI->save();
                $show = false;

                /*  $PartnerWorkingWithId = Yii::$app->request->post('PartnerWorkingWith')['iWorking_With_ID'];
                  $PartnerWorkingWith->iUser_ID = $id;
                  $PartnerWorkingWith->iWorking_With_ID = $PartnerWorkingWithId;
                  $show = false;

                  $PartnersAnnualIncomeId = Yii::$app->request->post('PartnersAnnualIncome')['annual_income_id'];
                  $PartnersAnnualIncome->iUser_ID = $id;
                  $PartnersAnnualIncome->annual_income_id = $PartnersAnnualIncomeId;
                  $show = false;*/

            }
        }
        $myModel = [
            //'model' => $model,
            'PartnersEducationalLevel' => $PartnersEducationalLevel,
            'PartnersEducationField' => $PartnersEducationField,
            'PW' => $PW,
            'WorkingW' => $WorkingW,
            'AI' => $AI,
            //'PartnerWorkingWith' => $PartnerWorkingWith,
            //'PartnersAnnualIncome' => $PartnersAnnualIncome,
            'show' => $show
        ];
        return $this->renderAjax('_profession', $myModel);
    }

    public function actionEditPreferencesLocation()
    {
        $id = Yii::$app->user->identity->id;
        $UPP = UserPartnerPreference::findByUserId($id) == NULL ? new UserPartnerPreference() : UserPartnerPreference::findByUserId($id);
        $PC = PartnersCities::findByUserId($id) == NULL ? new PartnersCities() : PartnersCities::findByUserId($id);
        $PS = PartnersStates::findByUserId($id) == NULL ? new PartnersStates() : PartnersStates::findByUserId($id);
        $PCS = PartnersCountries::findByUserId($id) == NULL ? new PartnersCountries() : PartnersCountries::findByUserId($id);
        $model = User::findOne($id);
        $show = false;
        #CommonHelper::pr($PartenersCities);exit;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if (Yii::$app->request->post('save')) {
                $CurrDate = date('Y-m-d H:i:s');
                $CitiesId = Yii::$app->request->post('PartnersCities')['city_id'];
                $PC->scenario = PartnersCities::SCENARIO_ADD;
                $PC->user_id = $id;
                $PC->city_id = $CitiesId;
                $PC->modified_on = $CurrDate;
                if ($PC->ID == "") {
                    $PC->created_on = $CurrDate;
                }
                $PC->save();

                $StateId = Yii::$app->request->post('PartnersStates')['state_id'];
                $PS->scenario = PartnersStates::SCENARIO_ADD;
                $PS->user_id = $id;
                $PS->state_id = $StateId;
                $PS->modified_on = $CurrDate;
                if ($PS->ID == "") {
                    $PS->created_on = $CurrDate;
                }
                $PS->save();

                $CountriesId = Yii::$app->request->post('PartnersCountries')['country_id'];
                $PCS->scenario = PartnersCountries::SCENARIO_ADD;
                $PCS->user_id = $id;
                $PCS->country_id = $CountriesId;
                $PCS->modified_on = $CurrDate;
                if ($PCS->ID == "") {
                    $PCS->created_on = $CurrDate;
                }
                $PCS->save();
                $show = false;
            }
        }
        $myModel = [
            'PC' => $PC,
            // 'PartnersMaritalStatus' => $PartnersMaritalStatus,
            //'PartnersFathersStatus' => $PartnersFathersStatus,
            #'model' => $model,
            'PS' => $PS,
            'PCS' => $PCS,
            'show' => $show
        ];
        return $this->renderAjax('_location', $myModel);
    }

    public function actionEditLookingFor()
    {
        $id = Yii::$app->user->identity->id;
        $UPP = UserPartnerPreference::findByUserId($id) == NULL ? new UserPartnerPreference() : UserPartnerPreference::findByUserId($id);
        $model = User::findOne($id);
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if (Yii::$app->request->post('save')) {
                $UPP->iUser_id = $id;
                $UPP->LookingFor = Yii::$app->request->post('UserPartnerPreference')['LookingFor'];
                $UPP->save();
                $show = false;
            }
        }
        $myModel = [
            'model' => $model,
            'UPP' => $UPP,
            'show' => $show
        ];
        return $this->renderAjax('_looking', $myModel);
    }

    public function actionEditHoroscope()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_REGISTER10;
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if (Yii::$app->request->post('save')) {
                $model->RaashiId = Yii::$app->request->post('User')['RaashiId'];
                $model->CharanId = Yii::$app->request->post('User')['CharanId'];
                $model->NadiId = Yii::$app->request->post('User')['NadiId'];
                $model->NakshtraId = Yii::$app->request->post('User')['NakshtraId'];
                $model->iGotraID = Yii::$app->request->post('User')['iGotraID'];
                $model->Mangalik = Yii::$app->request->post('User')['Mangalik'];
                if ($model->validate()) {
                    $model->save();
                    $show = false;
                }
            }
        }

        if ($show) {
            return $this->actionRenderAjax($model, '_horoscope', true);
        } else {
            return $this->actionRenderAjax($model, '_horoscope', false);
        }
    }

    public function actionEditHobby()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_REGISTER10;
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;

            if (Yii::$app->request->post('save')) {
                #CommonHelper::pr(Yii::$app->request->post());exit;
                // $InterestArray = Yii::$app->request->post('User')['InterestID'];
                $model->InterestID = "," . implode(",", $_POST['User']['InterestID']);
                //$model->InterestID = (is_array($InterestArray)) ? "," . implode(",", $InterestArray) : '';
                // $ReadsArray = Yii::$app->request->post('User')['FavioriteReadID'];
                $model->FavioriteReadID = "," . implode(",", $_POST['User']['FavioriteReadID']);
                //  $model->FavioriteReadID = (is_array($ReadsArray)) ? "," . implode(",", $ReadsArray) : '';

                // $MusicArray = Yii::$app->request->post('User')['FaviouriteMusicID'];
                $model->FaviouriteMusicID = implode(",", $_POST['User']['FaviouriteMusicID']);
                //$model->FaviouriteMusicID = (is_array($MusicArray)) ? "," . implode(",", $MusicArray) : '';

                //$CousinesArray = Yii::$app->request->post('User')['FavouriteCousinesID'];
                $model->FavouriteCousinesID = implode(",", $_POST['User']['FavouriteCousinesID']);
                //$model->FavouriteCousinesID = (is_array($CousinesArray)) ? "," . implode(",", $CousinesArray) : '';

                //$SportsArray = Yii::$app->request->post('User')['SportsFittnessID'];
                $model->SportsFittnessID = implode(",", $_POST['User']['SportsFittnessID']);
                // $model->SportsFittnessID = (is_array($SportsArray)) ? "," . implode(",", $SportsArray) : '';

                //$DressArray = Yii::$app->request->post('User')['PreferredDressID'];
                $model->PreferredDressID = implode(",", $_POST['User']['PreferredDressID']);
                //$model->PreferredDressID = (is_array($DressArray)) ? "," . implode(",", $DressArray) : '';

                // $MovieArray = Yii::$app->request->post('User')['PreferredMovieID'];
                $model->PreferredMovieID = implode(",", $_POST['User']['PreferredMovieID']);
                // $model->PreferredMovieID = (is_array($MovieArray)) ? "," . implode(",", $MovieArray) : '';

                if ($model->validate()) {
                    $model->save();
                    $show = false;
                }
            }
        }

        if ($show) {
            return $this->actionRenderAjax($model, '_hobby', true);
        } else {
            return $this->actionRenderAjax($model, '_hobby', false);
        }
    }

    public function actionCoverupload()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $session_uid = $id;
        $ACTION = Yii::$app->request->post('ACTION');
        #$path = 'http://localhost/KandePohe//frontend/web/uploads/users/2/cover/14748796851.jpg';
        $COVER_PHOTO = CommonHelper::getCoverPhotos('USER', $id, $model->cover_photo, '');
        $bgSave = '';
        if ($ACTION == 'REPOSITION') {
            $bgSave .= '<div id="uX' . $session_uid . '" class="bgSaveRP wallbutton blackButton">&nbsp; Save &nbsp;</div>';
        } else {
            $bgSave .= '<div id="uX' . $session_uid . '" class="bgSave wallbutton blackButton">&nbsp; Save &nbsp;</div>';
        }
        $bgSave .= '<div id="uX' . $session_uid . '" class="bgCancel wallbutton blackButton">Cancel</div>';
        $ABC = $bgSave . '<img src="' . $COVER_PHOTO . '"  id="timelineBGload" class="headerimage ui-corner-all" style="top:' . $model->cover_background_position . '"/>';
        $RES = array("ABC" => $ABC);
        echo json_encode($RES);
        exit;
    }

    public function actionCoverphotoback()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $session_uid = $id;
        $ACTION = Yii::$app->request->post('ACTION');
        $COVER_PHOTO = CommonHelper::getCoverPhotos('USER', $id, $model->cover_photo, '');
        $bgSave = '';
        $ABC = '';
        if ($ACTION == 'CANCEL') {
            $ABC = $bgSave . '<img src="' . $COVER_PHOTO . '"  id="timelineBGload" class="bgImagecover" style="margin-top:' . $model->cover_background_position . '"/>';
        } else if ($ACTION == 'DELETE') {
            $OLD_PHOTO = $model->cover_photo;
            $model->cover_photo = '';
            $model->cover_background_position = '';
            $ACTION_FLAG = $model->save();
            $PATH = CommonHelper::getUserUploadFolder(1) . "/" . $id . "/cover/";
            CommonHelper::photoDeleteFromFolder($PATH, array(), $OLD_PHOTO);
            $COVER_PHOTO = CommonHelper::getCoverPhotos('USER', $id, '', '');
            $ABC = $bgSave . '<img src="' . $COVER_PHOTO . '"  id="timelineBGload" class="bgImagecover" />';
        }

        $RES = array("ABC" => $ABC);
        echo json_encode($RES);
        exit;
    }

    public function actionSaveCoverPhoto($position = '')
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $P_ID = Yii::$app->request->post('position');
        $position = $P_ID;
        if ($position != '') {
            $CM_HELPER = new CommonHelper();
            $PATH = $CM_HELPER->getUserUploadFolder(1) . "/" . $id . "/cover/";
            $URL = $CM_HELPER->getUserUploadFolder(2) . "/" . $id . "/cover/";
            #$USER_SIZE_ARRAY = $CM_HELPER->getUserResizeRatio();
            $OLD_PHOTO = $model->cover_photo;
            $FILE_COUNT = count($_FILES);

            if ($FILE_COUNT != 0) {
                $PHOTO_ARRAY = $CM_HELPER->coverPhotoUpload($id, $_FILES['cover_photo'], $PATH, $URL, '', $OLD_PHOTO);
                $model->cover_photo = $PHOTO_ARRAY['PHOTO'];
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'COVER_PHOTO_SET');
            } else {
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'COVER_PHOTO_SET');
            }

            $model->cover_background_position = $position;
            $ACTION_FLAG = $model->save();
            if (!$ACTION_FLAG) {
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'COVER_PHOTO_UPLOAD');
            }
        }
        $OUTPUT_HTML = '';
        $OUTPUT_HTML_ONE = '';
        $OUTPUT_HTML .= $this->getPhotoListOutput();
        $OUTPUT_HTML_ONE .= $this->getPhotoListOutputOne();

        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE, 'OUTPUT' => $OUTPUT_HTML, 'OUTPUT_ONE' => $OUTPUT_HTML_ONE);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
    }

    public function getPhotoListOutput()
    {
        $PG = new UserPhotos();
        $id = Yii::$app->user->identity->id;
        $USER_PHOTOS_LIST = $PG->findByUserId($id);
        $OUTPUT_HTML = '';
        foreach ($USER_PHOTOS_LIST as $K => $V) {
            $SELECTED = '';
            if ($V['Is_Profile_Photo'] == 'YES') {
                $SELECTED = "selected";
            }
            $IMG = CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name'], 140);
            $OUTPUT_HTML .= '<div class="col-md-3 col-sm-3 col-xs-6">
                                                                <a class="selected" href="#">';

            $OUTPUT_HTML .= '<img src="' . $IMG . '" height="140" class="img-responsive ' . $SELECTED . '" alt="Full view" style="height:140px;">';
            $OUTPUT_HTML .= '</a>

                                                                <a href="javascript:void(0)" class="pull-left  profile_set" data-id="' . $V['iPhoto_ID'] . '" data-target="#photodelete" data-toggle="modal"> Profile pic</a>

                                                                <a href="javascript:void(0)" class="pull-right profile_delete" data-id="' . $V['iPhoto_ID'] . '" data-target="#photodelete" data-toggle="modal"> <i aria-hidden="true"
                                                                                                   class="fa fa-trash-o"></i>
                                                                </a>

                                                            </div>';

        }
        return $OUTPUT_HTML;
    }

    public function getPhotoListOutputOne()
    {
        $PG = new UserPhotos();
        $id = Yii::$app->user->identity->id;
        $USER_PHOTOS_LIST = $PG->findByUserId($id);
        $OUTPUT_HTML = '';
        foreach ($USER_PHOTOS_LIST as $K => $V) {
            $SELECTED = '';
            if ($V['Is_Profile_Photo'] == 'YES') {
                $SELECTED = "selected";
            }
            $IMG = CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name'], 140);
            $OUTPUT_HTML .= '<div class="col-md-3 col-sm-3 col-xs-6">
                                 <a href="javascript:void(0)" class="pull-left profile_set" data-id="' . $V['iPhoto_ID'] . '"
                                       data-target="#photodelete" data-toggle="modal">';
            $OUTPUT_HTML .= '<img src="' . $IMG . '" height="140" class="img-responsive ' . $SELECTED . '" alt="Full view" style="height:140px;">';
            $OUTPUT_HTML .= '</a></div>';

        }
        return $OUTPUT_HTML;
    }

    public function actionSaveprivacySetting()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $user_privacy_option = $P_ID = Yii::$app->request->post('user_privacy_option');
        $model->user_privacy_option = $user_privacy_option;
        if ($model->save()) {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PRIVACY_SETTING');
        } else {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PRIVACY_SETTING');
        }
        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE);
        return json_encode($return);
    }

    public function actionGetCoverPhotoFromPhoto($position = '')
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $STATUS = "S";
        $MESSAGE = '';
        $ACTION = Yii::$app->request->post('ACTION');
        $P_ID = Yii::$app->request->post('P_ID');
        $ABC = '';
        if ($ACTION == 'GET_PHOTO_FROM_PHOTOS') {
            $session_uid = $id;
            $PG = new UserPhotos();
            $USER_PHOTOS_LIST = $PG->findByPhotoId($id, $P_ID);
            if (count($USER_PHOTOS_LIST) != 0) {
                $CM_HELPER = new CommonHelper();
                $PHOTO = $USER_PHOTOS_LIST->File_Name;
                $PATH = $CM_HELPER->getUserUploadFolder(1) . "/" . $id . "/";
                $URL = $CM_HELPER->getUserUploadFolder(2) . "/" . $id . "/";
                $COVER_PHOTO_1 = $PHOTO;
                $USER_SIZE_ARRAY = $CM_HELPER->getUserResizeRatio();
                copy($PATH . $COVER_PHOTO_1, $PATH . 'cover/' . $COVER_PHOTO_1);
                $COVER_PHOTO = CommonHelper::getPhotos('USER', $id, $COVER_PHOTO_1, '');
                $bgSave = '';
                $bgSave .= '<div id="uX' . $session_uid . '" class="bgSaveFP wallbutton blackButton">&nbsp; Save &nbsp;</div>';
                $bgSave .= '<div id="uX' . $session_uid . '" class="bgCancel wallbutton blackButton">Cancel</div>';
                $ABC = $bgSave . '<img src="' . $COVER_PHOTO . '"  id="timelineBGload" class="headerimage ui-corner-all" style="top:2px;"/>';
            }
            $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, "ABC" => $ABC);
            //Yii::$app->response->format = Response::FORMAT_JSON;
            return json_encode($return);
        }
    }

    public function actionSaveCoverPhotoFromPhoto($position = '')
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);

        $position = Yii::$app->request->post('position');
        $P_ID = Yii::$app->request->post('P_ID');
        if ($position != '') {
            $PG = new UserPhotos();
            $USER_PHOTOS_LIST = $PG->findByPhotoId($id, $P_ID);
            if (count($USER_PHOTOS_LIST) != 0) {
                $CM_HELPER = new CommonHelper();
                $PHOTO = $USER_PHOTOS_LIST->File_Name;
                $PATH = $CM_HELPER->getUserUploadFolder(1) . "/" . $id . "/";
                $URL = $CM_HELPER->getUserUploadFolder(2) . "/" . $id . "/";
                $USER_SIZE_ARRAY = $CM_HELPER->getUserResizeRatio();
                if (!is_dir($PATH . 'cover/')) {
                    mkdir($PATH . 'cover/', 0777);
                }
                copy($PATH . $PHOTO, $PATH . 'cover/' . $PHOTO);
                CommonHelper::photoDeleteFromFolder($PATH . 'cover/', array(), $model->cover_photo);
                $model->cover_photo = $PHOTO;
                $model->cover_background_position = $position;
                $ACTION_FLAG = $model->save();
                if (!$ACTION_FLAG) {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'COVER_PHOTO_SET');
                } else {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'COVER_PHOTO_SET');
                }
            }
            $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE);
            //Yii::$app->response->format = Response::FORMAT_JSON;
            return json_encode($return);
        }
    }

    public function actionHideProfile()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $HS = '';
        $OUTPUT = '';
        if ($model->hide_profile == 'Yes') {
            $HS = 'No';
            $OUTPUT .= '<a href="javascript:void(0)" data-target="#hideProfile"
                                data-toggle="modal" class="hideshowmenu" data-name="No">
                                <i class="fa fa-eye-slash"></i> Hide Profile</a>';
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PROFILE_SHOW');
        } else {
            $HS = 'Yes';
            $OUTPUT .= '<a href="javascript:void(0)" data-target="#hideProfile"
                                data-toggle="modal" class="hideshowmenu" data-name="Yes">
                                <i class="fa fa-eye"></i> Show Profile</a>';
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PROFILE_HIDE');
        }
        $model->hide_profile = $HS;
        $model->save();
        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'OUTPUT' => $OUTPUT, 'TITLE' => $TITLE);
        #$Yii::$app->response->format = Response::FORMAT_JSON;
        return json_encode($return);
    }

    public function actionAccountDelete() # Account Delete
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->status = STATUS_DELETED;
        if ($model->save()) {
            $LINK = CommonHelper::getSiteUrl('BACKEND') . 'user/' . $id;
            $MAIL_DATA = array("EMAIL" => $model->email, "EMAIL_TO" => $model->email, "NAME" => $model->First_Name . " " . $model->Last_Name, "LINK" => $LINK);
            MailHelper::SendMail('ADMIN_DELETE_ACCOUNT_USER', $MAIL_DATA);
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'ACCOUNT_DELETE');
            Yii::$app->user->logout();
        } else {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'ACCOUNT_DELETE');
        }
        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE);
        //Yii::$app->response->format = Response::FORMAT_JSON;
        return json_encode($return);
    }

    public function actionTagList()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('TagId') != '' && Yii::$app->request->post('TagId') != 0)) {
            $show = true;
            $TagId = Yii::$app->request->post('TagId');
            if ($TagId) {
                $USER_TAG = new UserTag();
                $USER_TAG->iUser_Id = $id;
                $USER_TAG->tag_id = $TagId;
                $USER_TAG->save();
            }
        }
        $TAG_LIST_USER = UserTag::find()->joinWith([tagName])->where(['iUser_Id' => $id])->orderBy(['Name' => SORT_ASC])->all();
        return $this->actionRenderAjax($TAG_LIST_USER, '_tags', $show);
    }

    public function actionAddAllTags()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('TagId') != '' && Yii::$app->request->post('TagId') != 0)) {
            $show = true;
            $TAG_LIST = Tags::find()->all();
            $TAG_LIST_USER = UserTag::find()->where(['iUser_Id' => $id])->all();
            $IN_USER_TAG_LIST = array();
            foreach ($TAG_LIST_USER as $TK => $TV) {
                array_push($IN_USER_TAG_LIST, $TV['tag_id']);
            }
            foreach ($TAG_LIST as $K => $V) {
                if (!in_array($V['ID'], $IN_USER_TAG_LIST)) {
                    $USER_TAG = new UserTag();
                    $USER_TAG->iUser_Id = $id;
                    $USER_TAG->tag_id = $V['ID'];
                    $ACTION_FLAG = $USER_TAG->save();
                }
            }
        }
        $TAG_LIST_USER = UserTag::find()->joinWith([tagName])->where(['iUser_Id' => $id])->orderBy(['Name' => SORT_ASC])->all();
        return $this->actionRenderAjax($TAG_LIST_USER, '_tags', $show);
    }

    public function actionTagDelete()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        if (Yii::$app->request->post() && (Yii::$app->request->post('TagId') != '' && Yii::$app->request->post('TagId') != 0)) {
            $TagId = Yii::$app->request->post('TagId');
            if ($TagId) {
                UserTag::deleteAll(['id' => $TagId]);
            }
        }
    }

    public function actionTagSuggestionList()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $show = false;
        $UserTagList = array();
        $TAG_LIST_USER = UserTag::find()->joinWith([tagName])->where(['iUser_Id' => $id])->orderBy(['Name' => SORT_ASC])->all();
        if (count($TAG_LIST_USER) != 0) {
            foreach ($TAG_LIST_USER as $TK => $TV) {
                array_push($UserTagList, $TV->tag_id);
            }
        }
        $TAG_LIST = Tags::find()->where(['not in', 'ID', $UserTagList])->orderBy('rand()')->all();
        return $this->actionRenderAjax($TAG_LIST, '_tagssuggestion', $show);
    }

    public function actionTagCount()
    { //tag-suggestion-list
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $show = false;
        $TAG_LIST_USER = UserTag::find()->joinWith([tagName])->where(['iUser_Id' => $id])->orderBy(['Name' => SORT_ASC])->all();
        $TAG_LIST = Tags::find()->orderBy('rand()')->all();
        $TAG_COUNT = count($TAG_LIST_USER) . "/" . count($TAG_LIST);
        return $this->actionRenderAjax($TAG_COUNT, '_tagscount', $show);
    }

    public function actionPhoneVerification()   # For Phone Verification : VS
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_VERIFY_PIN_FOR_PHONE;
        $show = false;
        $popup = false;
        $flag = false;
        $temp = array();
        if (Yii::$app->request->post() && (Yii::$app->request->post('verify') == 'PHONE_VERIFY')) {
            $show = true;
            $PIN = $model->pin_phone_vaerification;
            $PhonePin = Yii::$app->request->post('User')['phone_pin'];
            $model->phone_pin = $PhonePin;
            #echo $model->scenario ;
            #var_dump($model->validate());
            if ($model->validate()) {
                if ($PIN == $PhonePin) {
                    list($temp['StartTime'], $temp['RemainingTime']) = CommonHelper::getTimeDifference($model->pin_phone_time);
                    //if($Difference > 0 && $Difference <=  Yii::$app->params['timePinValidate']){
                    if ($temp['StartTime'] > 0 && $temp['StartTime'] <= Yii::$app->params['timePinValidate']) {
                        #$model->new_phone_no = $model->new_phone_no;
                        $model->completed_step = $model->setCompletedStep('8');
                        $model->ePhoneVerifiedStatus = 'Yes';
                        $model->pin_phone_vaerification = 0;
                        $model->pin_phone_time = 0;
                        $model->county_code = $model->new_county_code;
                        $model->Mobile = $model->new_phone_no;

                        $model->save();
                        $model->phone_pin = '';
                        $show = false;
                    }else{
                        $temp['Error'] = 1;
                    }
                }
                $popup = true;
            } else {
                $model->ePhoneVerifiedStatus = 'No';
                #$popup = true;
            }
        }
        //$model = User::findOne($id);
        //echo CommonHelper::getDateTimeToString(CommonHelper::getTime());
        list($temp['StartTime'],$temp['RemainingTime']) = CommonHelper::getTimeDifference($model->pin_phone_time);
        return $this->actionRenderAjax($model, '_verificationphone', $show, $popup,$flag,$temp);
    }
    public function actionPhoneNumberChange() # For Phone Number Change : VS
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_PHONE_NUMBER_CHANGE;
        $show = false;
        $popup = false;
        $temp = array();
        if (Yii::$app->request->post() && (Yii::$app->request->post('save') == 'PHONE_NUMBER_CHANGE')) {
            $show = true;
            $OldNumber = $model->county_code . $model->Mobile;
            $OldCountryCode = $model->county_code;
            $OldMobileNo = $model->Mobile;
            $NewCountryCode = Yii::$app->request->post('User')['county_code'];
            $NewPhoneNumber = Yii::$app->request->post('User')['Mobile'];
            $NewNumber = $NewCountryCode . $NewPhoneNumber;
            $model->county_code = $NewCountryCode;
            $model->Mobile = $NewPhoneNumber;
            if ($model->validate()) {
                if ($OldNumber != $NewNumber) {
                    $TimeOut = CommonHelper::getDateTimeToString(CommonHelper::getTime());
                    $PIN_P = CommonHelper::generateNumericUniqueToken(4);
                    $model->pin_phone_vaerification = $PIN_P;
                    $model->new_county_code = $NewCountryCode;
                    $model->new_phone_no = $NewPhoneNumber;
                    $model->completed_step = CommonHelper::unsetStep($model->completed_step, 8);
                    $model->ePhoneVerifiedStatus = 'No';
                    $model->pin_phone_time = $TimeOut;

                    $model->county_code = $OldCountryCode;
                    $model->Mobile = $OldMobileNo;
                    if ($model->save()) {
                        $SMSArray = array("OTP" => $PIN_P);
                        $SMSFlag = SmsHelper::SendSMS($NewPhoneNumber, 'PHONE_OTP', $SMSArray);
                        #$SMSFlag = SmsHelper::SendSMS($PIN_P, $NewPhoneNumber);
                        $flag = true;
                        $show = false;
                    } else {
                        $flag = false;
                    }
                    $popup = true;
                } else {
                    $popup = false;
                    $show = false;
                    $flag = true;
                }
            } else {
                $popup = false;
                $show = false;
                $flag = true;
            }
        }
        return $this->actionRenderAjax($model, '_changephone', $show, $popup, $flag);
    }

    public function actionPhonePinResend() # For Phone Pin Resend : VS
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_RESEND_PIN_FOR_PHONE;
        $show = false;
        $popup = false;
        $temp = array();
        if (isset($_REQUEST['type']) && $_REQUEST['type'] == 10) { # For Resend PIN
            $flag = true;
            $TimeOut = CommonHelper::getDateTimeToString(CommonHelper::getTime());
            $PIN_P = CommonHelper::generateNumericUniqueToken(4);
            $model->pin_phone_vaerification = $PIN_P;
            $model->pin_phone_time = $TimeOut;
            $model->completed_step = CommonHelper::unsetStep($model->completed_step, 8);
            $model->ePhoneVerifiedStatus = 'No';
            if ($model->save()) {
                $SMSArray = array("OTP" => $PIN_P);
                list($Status, $Message) = SmsHelper::SendSMS($model->new_phone_no, 'PHONE_OTP', $SMSArray);
                #list($Status, $Message) = SmsHelper::SendSMS($PIN_P, $model->new_phone_no);
                $temp['Status'] = $Status;
                $temp['Message'] = $Message;
                $popup = true;
                if($Status!=''){
                    list($temp['StartTime'],$temp['RemainingTime']) = CommonHelper::getTimeDifference($model->pin_phone_time);
                }
            } else {
                $popup = false;
            }
        }
        return $this->actionRenderAjax($model, '_verificationphone', $show, $popup, $flag, $temp);
    }

    public function actionEmailVerification()   # For Email Verification : VS
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_VERIFY_PIN_FOR_EMAIL;
        $show = false;
        $popup = false;
        $flag = false;
        $temp = array();
        if (Yii::$app->request->post() && (Yii::$app->request->post('verify') == 'EMAIL_VERIFY')) {
            $show = true;
            $PIN = $model->pin_email_vaerification;
            $EmailPin = Yii::$app->request->post('User')['email_pin'];
            $model->email_pin = $EmailPin;
            if ($model->validate()) {
                if ($PIN == $EmailPin) {
                    #$Difference = CommonHelper::getTimeDifference($model->pin_email_time);
                    list($temp['StartTime'], $temp['RemainingTime']) = CommonHelper::getTimeDifference($model->pin_email_time);
                    #if ($Difference > 0 && $Difference <= Yii::$app->params['timePinValidate']) {
                    if ($temp['StartTime'] > 0 && $temp['StartTime'] <= Yii::$app->params['timePinValidate']) {
                        $model->completed_step = $model->setCompletedStep('9');
                        $model->eEmailVerifiedStatus = 'Yes';
                        $model->pin_email_vaerification = '0';
                        $model->pin_email_time = 0;
                        $model->save();
                        $model->email_pin = '';
                        $show = false;
                    } else {
                        $temp['Error'] = 1;
                    }
                }
                $popup = true;
            } else {
                $model->eEmailVerifiedStatus = 'No';
                #$popup = true;
            }
        }
        list($temp['StartTime'], $temp['RemainingTime']) = CommonHelper::getTimeDifference($model->pin_email_time);
        return $this->actionRenderAjax($model, '_verificationemail', $show, $popup, $flag, $temp);
    }

    public function actionEmailIdChange() # For Email ID Change : VS
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_EMAIL_ID_CHANGE;
        $show = false;
        $popup = false;
        $temp = array();
        if (Yii::$app->request->post() && (Yii::$app->request->post('save') == 'EMAIL_ID_CHANGE')) {
            $show = true;
            $OldEmailId = $model->email;
            $NewEmailID = Yii::$app->request->post('User')['email'];
            $model->email = $NewEmailID;
            if ($model->validate()) {
                if ($OldEmailId != $NewEmailID) {
                    $TimeOut = CommonHelper::getDateTimeToString(CommonHelper::getTime());
                    $PIN_P = CommonHelper::generateNumericUniqueToken(4);
                    $model->pin_email_vaerification = $PIN_P;
                    $model->completed_step = CommonHelper::unsetStep($model->completed_step, 9);
                    $model->eEmailVerifiedStatus = 'No';
                    $model->pin_email_time = $TimeOut;
                    if ($model->save()) {
                        $MAIL_DATA = array("EMAIL" => $NewEmailID, "EMAIL_TO" => $NewEmailID, "NAME" => $model->First_Name . " " . $model->Last_Name, "PIN" => $PIN_P, "MINUTES" => Yii::$app->params['timePinValidate']);
                        $MAIL_STATUS = MailHelper::SendMail('EMAIL_VERIFICATION_PIN', $MAIL_DATA);
                        $flag = true;
                        $show = false;
                    } else {
                        $flag = false;
                    }
                    $popup = true;
                } else {
                    $popup = false;
                    $show = false;
                    $flag = true;
                }
            } else {
                $popup = false;
                $show = false;
                #$flag = true;
                $flag = false;
            }
        }
        return $this->actionRenderAjax($model, '_changeemail', $show, $popup, $flag);
    }

    public function actionEmailPinResend() # For EMail PIN Resend : VS
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_RESEND_PIN_FOR_EMAIL;
        $show = false;
        $popup = false;
        $temp = array();
        if (isset($_REQUEST['type']) && $_REQUEST['type'] == 10) { # For Resend PIN
            $flag = true;
            $TimeOut = CommonHelper::getDateTimeToString(CommonHelper::getTime());
            $PIN_P = CommonHelper::generateNumericUniqueToken(4);
            $model->pin_email_vaerification = $PIN_P;
            $model->pin_email_time = $TimeOut;
            $model->completed_step = CommonHelper::unsetStep($model->completed_step, 8);
            $model->eEmailVerifiedStatus = 'No';
            if ($model->save()) {
                $MAIL_DATA = array("EMAIL" => $model->email, "EMAIL_TO" => $model->email, "NAME" => $model->First_Name . " " . $model->Last_Name, "PIN" => $PIN_P, "MINUTES" => Yii::$app->params['timePinValidate']);
                $MAIL_STATUS = MailHelper::SendMail('EMAIL_VERIFICATION_PIN', $MAIL_DATA);
                $popup = true;
                #$model = User::findOne($id);
                //echo CommonHelper::getDateTimeToString(CommonHelper::getTime());
                list($temp['StartTime'], $temp['RemainingTime']) = CommonHelper::getTimeDifference($model->pin_email_time);
            } else {
                $popup = false;
            }
        }
        return $this->actionRenderAjax($model, '_verificationemail', $show, $popup, $flag, $temp);
    }

    public function actionProfile($uk = '', $source = '') #Other User Profile View : VS
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $id = Yii::$app->user->identity->id;
        #echo $uk;exit;echo $Registration_Number;exit;
        $model1 = User::findOne(['Registration_Number' => $uk]);
        $ToUserId = $model1->id;

        /* Insert Record for As Your Profile Viewed By Section Start */
        $this->actionProfileViewedBy($id, $ToUserId);
        /* Insert Record for As Your Profile Viewed By Section End */

        $flag = false;
        $MatchCompatibility = array();
        $PhotoList = array();
        $model = array();
        $Title = $Message = '';
        if ($ToUserId != $id) {
            $flag = true;
            $model = User::findOne($ToUserId);
            $UserPhotoModel = new UserPhotos();
            $PhotoList = $UserPhotoModel->findByUserId($ToUserId);
            $PartenersReligion = PartenersReligion::findByUserId($ToUserId) == NULL ? new PartenersReligion() : PartenersReligion::findByUserId($ToUserId);
            $UPP = UserPartnerPreference::findByUserId($ToUserId) == NULL ? new UserPartnerPreference() : UserPartnerPreference::findByUserId($ToUserId);
            $PartnersMaritalStatus = PartnersMaritalStatus::findByUserId($ToUserId) == NULL ? new PartnersMaritalStatus() : PartnersMaritalStatus::findByUserId($ToUserId);
            $PartnersGotra = PartnersGotra::findByUserId($ToUserId) == NULL ? new PartnersGotra() : PartnersGotra::findByUserId($ToUserId);
            $PartnersFathersStatus = PartnersFathersStatus::findByUserId($ToUserId) == NULL ? new PartnersFathersStatus() : PartnersFathersStatus::findByUserId($ToUserId);
            $PartnersMothersStatus = PartnersMothersStatus::findByUserId($ToUserId) == NULL ? new PartnersMothersStatus() : PartnersMothersStatus::findByUserId($ToUserId);
            $PartnersEducationalLevel = PartnersEducationalLevel::findByUserId($ToUserId) == NULL ? new PartnersEducationalLevel() : PartnersEducationalLevel::findByUserId($ToUserId);
            $PartnersEducationField = PartnersEducationField::findByUserId($ToUserId) == NULL ? new PartnersEducationField() : PartnersEducationField::findByUserId($ToUserId);

        } else if ($ToUserId == $id) {
            $Title = Yii::$app->params['accessDenied'];
            $Message = Yii::$app->params['accessDeniedYourProfile'];
        } else {
            $Title = Yii::$app->params['accessDenied'];
            $Message = Yii::$app->params['accessDeniedInvalid'];
        }
        $Gender = (Yii::$app->user->identity->Gender == 'MALE') ? 'FEMALE' : 'MALE';
        list($SimilarProfile, $SuccessStories) = $this->actionRightSideBar($Gender, $id, 3);
        return $this->render('profile', [
            'model' => $model,
            'MatchCompatibility' => $MatchCompatibility,
            'PhotoList' => $PhotoList,
            'flag' => $flag,
            'Message' => $Message,
            'Title' => $Title,
            'PartenersReligion' => $PartenersReligion,
            'UPP' => $UPP,
            'PartnersMaritalStatus' => $PartnersMaritalStatus,
            'PartnersGotra' => $PartnersGotra,
            'PartnersFathersStatus' => $PartnersFathersStatus,
            'PartnersMothersStatus' => $PartnersMothersStatus,
            'PartnersEducationalLevel' => $PartnersEducationalLevel,
            'PartnersEducationField' => $PartnersEducationField,
            'SimilarProfile' => $SimilarProfile,
        ]);
    }

    public function actionProfileViewedBy($Id, $ToUserId)
    {
        $Model = UserRequestOp::checkUsers($Id, $ToUserId) == NULL ? new UserRequestOp() : UserRequestOp::checkUsers($Id, $ToUserId);
        $Temp = 0;
        $Model->scenario = UserRequest::SCENARIO_PROFILE_VIEWED_BY;
        if ($Model->id) {
            if ($Id == $Model->from_user_id) {
                if ($Model->profile_viewed_from_to == 'No') {
                    $Temp = 1;
                    $Model->profile_viewed_from_to = 'Yes';
                }
            } else if ($Id == $Model->to_user_id) {
                if ($Model->profile_viewed_to_from == 'No') {
                    $Temp = 1;
                    $Model->profile_viewed_to_from = 'Yes';
                }
            }
        } else {
            $Temp = 1;
            $Model->from_user_id = $Id; #who logged in.
            $Model->to_user_id = $ToUserId;
            $Model->profile_viewed_from_to = 'Yes';
        }
        if ($Temp) {
            if ($Model->save()) {
                $this->actionMailSendRequest($Id, $ToUserId, 'VIEW_PROFILE_OF');
                return 'S';
            } else {
                return 'E';
            }
        }
    }

    public function actionMailSendRequest($id, $ToUserId, $MailType)
    {
        $Model = User::findOne($id);
        $UserModel = User::findOne($ToUserId);
        $PG = new UserPhotos();
        $USER_PHOTOS_LIST = $PG->findByProfilePhoto($id);
        /*if (count($USER_PHOTOS_LIST) != 0) {
            $PHOTO = CommonHelper::getPhotos('USER', $id, "200" . $USER_PHOTOS_LIST->File_Name, 200, '', 'Yes');
        } else {
            $PHOTO = CommonHelper::getUserDefaultPhoto();
        }*/
        $PHOTO = CommonHelper::getPhotos('USER', $id, "200" . $Model->propic, 200, '', 'Yes');
        $LINK = CommonHelper::getSiteUrl('FRONTEND', 1) . 'user/profile?uk=' . $Model->Registration_Number;
        $PHOTO = '<img src="' . $PHOTO . '" width="200"  alt="Profile Photo">';
        $MAIL_DATA = array("EMAIL_TO" => $UserModel->email, "NAME" => $UserModel->FullName, "USER_NAME" => $Model->FullName, "TODAY_DATE" => date('d-m-Y'), "AGE" => CommonHelper::getAge($Model->DOB), "HEIGHT" => CommonHelper::setInputVal($Model->height->vName, 'text'), "RELIGION" => CommonHelper::setInputVal($Model->religionName->vName, 'text'), "MOTHER_TONGUE" => CommonHelper::setInputVal($Model->motherTongue->Name, 'text'), "COMMUNITY" => CommonHelper::setInputVal($Model->communityName->vName, 'text'), "LOCATION" => CommonHelper::setInputVal($Model->cityName->vCityName, 'text') . ', ' . CommonHelper::setInputVal($Model->countryName->vCountryName, 'text'), "EDUCATION" => CommonHelper::setInputVal($Model->educationLevelName->vEducationLevelName, 'text'), "PROFESSION" => CommonHelper::setInputVal($Model->workingAsName->vWorkingAsName, 'text'), "ABOUT_ME" => CommonHelper::truncate($Model->tYourSelf, 100), 'LINK' => $LINK, 'PHOTO' => $PHOTO);
        #echo "<pre>";print_r($MAIL_DATA);#exit;
        if ($Model->Gender == 'MALE') {
            $MAIL_STATUS = MailHelper::SendMail($MailType . '_GROOM', $MAIL_DATA);
        } else {
            $MAIL_STATUS = MailHelper::SendMail($MailType . '_BRIDE', $MAIL_DATA);
        }
        return $MAIL_STATUS;
    }

    public function actionSendEmailProfile()
    {
        #echo "<pre>";print_r($_REQUEST);exit;

        $UserId = Yii::$app->request->post('ToUserId');
        $id = Yii::$app->user->identity->id;
        $MAIL_STATUS = $this->actionMailSendRequest($id, $UserId, 'PROFILE_OF');
        if ($MAIL_STATUS) {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'SEND_PROFILE_WITH_EMAIL');
        } else {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'SEND_PROFILE_WITH_EMAIL');
        }

        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE);
        return json_encode($return);
    }

    public function actionUserRequest() # For User Request : VS
    {
        $Id = Yii::$app->user->identity->id;
        $model = User::findOne($Id);
        $show = $popup = false;
        $temp = array();
        if (Yii::$app->request->post() && (count(Yii::$app->request->post()) > 0)) {
            $RequestAction = Yii::$app->request->post('Action');
            $ToUserId = Yii::$app->request->post('ToUserId');
            $Page = Yii::$app->request->post('Page');
            if ($RequestAction == 'SEND_INTEREST') {
                $temp['Action'] = 'SEND_INTEREST';
                $temp['STATUS'] = $this->actionSendInterest($Id, $ToUserId, 'SEND_INTEREST_OF');
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification($temp['STATUS'], 'SEND_INTEREST');
                $temp['MESSAGE'] = $MESSAGE;
            } else if ($RequestAction == 'Accept Interest') {
                $temp['Action'] = 'ACCEPT_INTEREST';
                $temp['STATUS'] = $this->actionAcceptInterest($Id, $ToUserId, 'ACCEPT_INTEREST_OF');
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification($temp['STATUS'], 'ACCEPT_INTEREST');
                $temp['MESSAGE'] = $MESSAGE;
                if ($Page != 'PROFILE') {
                    return json_encode($temp);
                    exit;
                }
            } else if ($RequestAction == 'Decline Interest') {
                $temp['Action'] = 'DECLINE_INTEREST';
                $temp['STATUS'] = $this->actionDeclineInterest($Id, $ToUserId, 'DECLINE_INTEREST_OF');
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification($temp['STATUS'], 'DECLINE_INTEREST');
                $temp['MESSAGE'] = $MESSAGE;
                if ($Page != 'PROFILE') {
                    return json_encode($temp);
                    exit;
                }
            } else if ($RequestAction == 'Cancel Interest') {
                $temp['Action'] = 'CANCEL_INTEREST';
                $temp['STATUS'] = $this->actionCancelInterest($Id, $ToUserId, 'CANCEL_INTEREST_OF');
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification($temp['STATUS'], 'CANCEL_INTEREST');
                $temp['MESSAGE'] = $MESSAGE;
                if ($Page != 'PROFILE') {
                    return json_encode($temp);
                    exit;
                }
            } else if ($RequestAction == 'Block User') {
                $temp['Action'] = 'BLOCK_USER';
                $temp['STATUS'] = $this->actionUserBlock($Id, $ToUserId, 'BLOCK_USER_OF');
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification($temp['STATUS'], 'BLOCK_USER');
                $temp['MESSAGE'] = $MESSAGE;
                $temp['TITLE'] = $TITLE;
                if ($Page != 'PROFILE') {
                    return json_encode($temp);
                    exit;
                }
            } else if ($RequestAction == 'SHORTLIST_USER') {
                $temp['Action'] = 'SHORTLIST_USER';
                $temp['STATUS'] = $this->actionUserShortList($Id, $ToUserId, 'SHORTLIST_USER_OF');
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification($temp['STATUS'], 'SHORTLIST_USER', array("NAME" => Yii::$app->request->post('Name')));
                $temp['STATUS'] = $STATUS;
                $temp['MESSAGE'] = $MESSAGE;
                $temp['TITLE'] = $TITLE;
                if ($Page != 'PROFILE') {
                    return json_encode($temp);
                    exit;
                }
            }
        }
        #$modelUser = UserRequestOp::checkUsers($Id, $ToUserId);
        $modelUser = UserRequestOp::checkSendInterest($Id, $ToUserId);
        $ToUserInfo = User::getUserInfroamtion($ToUserId);
        $myModel = [
            'ToUserId' => $ToUserId,
            'model' => $model,
            'modelUser' => $modelUser,
            'ToUserInfo' => $ToUserInfo,
            'temp' => $temp,
        ];
        $HtmlOutput = $this->actionRenderAjax($myModel, '_requests', $show, true, true, $temp);
        $Output = array("HtmlOutput" => $HtmlOutput, "Notification" => $temp);
        return json_encode($Output);
    }

    public function actionSendInterest($Id, $ToUserId, $MailType)
    {
        $Model = UserRequestOp::checkUsers($Id, $ToUserId) == NULL ? new UserRequestOp() : UserRequestOp::checkUsers($Id, $ToUserId);
        $Temp = 0;
        $Model->scenario = UserRequestOp::SCENARIO_SEND_INTEREST;
        if ($Model->id) {
            if ($Id == $Model->from_user_id) {
                if ($Model->send_request_status_from_to == 'No') {
                    if ($Model->send_request_status_to_from == 'No') {
                        $Temp = 1;
                        $Model->send_request_status_from_to = 'Yes';
                        $Model->date_send_request_from_to = CommonHelper::getCurrentDate();
                    } else {
                        return 'W';
                    }
                } else {
                    return 'I';
                }
            } else if ($Id == $Model->to_user_id) {
                if ($Model->send_request_status_to_from == 'No') {
                    if ($Model->send_request_status_from_to == 'No') {
                        $Temp = 1;
                        $Model->send_request_status_to_from = 'Yes';
                        $Model->date_send_request_to_from = CommonHelper::getCurrentDate();
                    } else {
                        return 'W';
                    }
                } else {
                    return 'I';
                }
            }
        } else {
            $Temp = 1;
            $Model->from_user_id = $Id; #who logged in.
            $Model->to_user_id = $ToUserId;
            $Model->send_request_status_from_to = 'Yes';
            $Model->date_send_request_from_to = CommonHelper::getCurrentDate();
        }
        if ($Temp) {
            if ($Model->save()) {
                $this->actionMailBoxLog($Id, $ToUserId, Yii::$app->params['sendInterestMessage'], 'SendInterest');
                $this->actionMailSendRequest($Id, $ToUserId, $MailType);
                $SMSUSerInformation = User::getSMSUserInformation($ToUserId);
                if ($SMSUSerInformation->ePhoneVerifiedStatus == 'Yes') {
                    $Gender = ($SMSUSerInformation->Gender == 'MALE') ? 'his' : 'her';
                    $SMSArray = array("NAME" => $SMSUSerInformation->FullName, "LINK" => 'Kandepohe.com', "GENDER" => $Gender);
                    $SMSFlag = SmsHelper::SendSMS($SMSUSerInformation->Mobile, 'INTEREST_SEND', $SMSArray);
                }
                return 'S';
            } else {
                return 'E';
            }
        }

    }

    public function actionMailBoxLog($Id, $ToUserId, $Content, $MessageType = 'Custom')
    {
        $MailBoxModel = new Mailbox();
        $MailBoxModel->scenario = Mailbox::SCENARIO_SEND_MESSAGE;
        $MailBoxModel->from_user_id = $Id;
        $MailBoxModel->to_user_id = $ToUserId;
        $MailBoxModel->from_reg_no = User::getRegisterNo($Id);
        $MailBoxModel->to_reg_no = User::getRegisterNo($ToUserId);
        $MailBoxModel->subject = $Content;
        $MailBoxModel->MailContent = $Content;
        $MailBoxModel->msg_type = $MessageType;
        $MailBoxModel->dtadded = CommonHelper::getTime();
        if ($MailBoxModel->save()) {
            return 'S';
        } else {
            return 'E';
        }
    }

    public function actionAcceptInterest($Id, $ToUserId, $MailType)
    {
        $Model = UserRequestOp::checkUsers($Id, $ToUserId) == NULL ? new UserRequestOp() : UserRequestOp::checkUsers($Id, $ToUserId);
        $Temp = 0;
        $Model->scenario = UserRequestOp::SCENARIO_ACCEPT_INTEREST;
        if ($Model->id) {
            if ($Id == $Model->from_user_id) {
                if ($Model->send_request_status_to_from == 'Yes') {
                    $Temp = 1;
                    $Model->send_request_status_to_from = 'Accepted';
                    $Model->date_accept_request_to_from = CommonHelper::getCurrentDate();
                } else if ($Model->send_request_status_to_from == 'No') {
                    return 'IN';
                } else if ($Model->send_request_status_to_from == 'Accepted') {
                    return 'IA';
                } else {
                    return 'W';
                }
            } else if ($Id == $Model->to_user_id) {
                if ($Model->send_request_status_from_to == 'Yes') {
                    $Temp = 1;
                    $Model->send_request_status_from_to = 'Accepted';
                    $Model->date_accept_request_from_to = CommonHelper::getCurrentDate();
                } else if ($Model->send_request_status_from_to == 'No') {
                    return 'IN';
                } else if ($Model->send_request_status_from_to == 'Accepted') {
                    return 'IA';
                } else {
                    return 'W';
                }
            }
        } else {
            return 'W';
        }
        if ($Temp) {
            if ($Model->save()) {
                $this->actionMailBoxLog($Id, $ToUserId, Yii::$app->params['acceptInterestMessage'], 'AcceptInterest');
                $this->actionMailSendRequest($Id, $ToUserId, $MailType);
                return 'S';
            } else {
                return 'E';
            }
        }
    }

    public function actionDeclineInterest($Id, $ToUserId, $MailType)
    {
        $Model = UserRequestOp::checkUsers($Id, $ToUserId) == NULL ? new UserRequestOp() : UserRequestOp::checkUsers($Id, $ToUserId);
        $Temp = 0;
        $Model->scenario = UserRequestOp::SCENARIO_DECLINE_INTEREST;
        if ($Model->id) {
            if ($Id == $Model->from_user_id) {
                if ($Model->send_request_status_to_from == 'Yes') {
                    $Temp = 1;
                    $Model->send_request_status_to_from = 'Rejected';
                    $Model->date_accept_request_to_from = CommonHelper::getCurrentDate();
                } else if ($Model->send_request_status_to_from == 'No') {
                    return 'IN';
                } else if ($Model->send_request_status_to_from == 'Rejected') {
                    return 'IR';
                } else {
                    return 'W';
                }
            } else if ($Id == $Model->to_user_id) {
                if ($Model->send_request_status_from_to == 'Yes') {
                    $Temp = 1;
                    $Model->send_request_status_from_to = 'Rejected';
                    $Model->date_accept_request_from_to = CommonHelper::getCurrentDate();
                } else if ($Model->send_request_status_from_to == 'No') {
                    return 'IN';
                } else if ($Model->send_request_status_from_to == 'Rejected') {
                    return 'IR';
                } else {
                    return 'W';
                }
            }
        } else {
            return 'W';
        }
        if ($Temp) {
            if ($Model->save()) {
                $this->actionMailBoxLog($Id, $ToUserId, Yii::$app->params['declineInterestMessage'], 'DeclineInterest');
                $this->actionMailSendRequest($Id, $ToUserId, $MailType);
                return 'S';
            } else {
                return 'E';
            }
        }
    }

    public function actionCancelInterest($Id, $ToUserId, $MailType)
    {
        $Model = UserRequestOp::checkUsers($Id, $ToUserId) == NULL ? new UserRequestOp() : UserRequestOp::checkUsers($Id, $ToUserId);
        $Temp = 0;
        $Model->scenario = UserRequestOp::SCENARIO_CANCEL_INTEREST;
        if ($Model->id) {
            if ($Id == $Model->from_user_id) {
                if ($Model->send_request_status_from_to == 'Yes') {
                    $Temp = 1;
                    $Model->send_request_status_from_to = 'No';
                    #$Model->date_send_request_from_to = CommonHelper::getCurrentDate();
                } else if ($Model->send_request_status_from_to == 'No') {
                    return 'IN';
                } else if ($Model->send_request_status_from_to == 'Rejected') {
                    return 'IR';
                } else if ($Model->send_request_status_from_to == 'Accepted') {
                    return 'IA';
                } else {
                    return 'W';
                }

            } else if ($Id == $Model->to_user_id) {
                if ($Model->send_request_status_to_from == 'Yes') {
                    $Temp = 1;
                    $Model->send_request_status_to_from = 'No';
                    #$Model->date_send_request_to_from = CommonHelper::getCurrentDate();
                } else if ($Model->send_request_status_to_from == 'No') {
                    return 'IN';
                } else if ($Model->send_request_status_to_from == 'Rejected') {
                    return 'IR';
                } else if ($Model->send_request_status_to_from == 'Accepted') {
                    return 'IA';
                } else {
                    return 'W';
                }
            }
        } else {
            return 'W';
        }
        if ($Temp) {
            if ($Model->save()) {
                $this->actionMailBoxLog($Id, $ToUserId, Yii::$app->params['cancelInterestMessage'], 'CancelInterest');
                $this->actionMailSendRequest($Id, $ToUserId, $MailType);
                return 'S';
            } else {
                return 'E';
            }
        }
    }

    public function actionUserBlock($Id, $ToUserId, $MailType)
    {
        $Model = UserRequestOp::checkUsers($Id, $ToUserId) == NULL ? new UserRequestOp() : UserRequestOp::checkUsers($Id, $ToUserId);
        $Temp = 0;
        $Model->scenario = UserRequestOp::SCENARIO_CANCEL_INTEREST;
        if ($Model->id) {
            if ($Id == $Model->from_user_id) {
                if ($Model->send_request_status_from_to == 'Yes') {
                    $Temp = 1;
                    $Model->send_request_status_from_to = 'No';
                } else if ($Model->send_request_status_from_to == 'No') {
                    return 'IN';
                } else if ($Model->send_request_status_from_to == 'Rejected') {
                    return 'IR';
                } else if ($Model->send_request_status_from_to == 'Accepted') {
                    return 'IA';
                } else {
                    return 'W';
                }

            } else if ($Id == $Model->to_user_id) {
                if ($Model->send_request_status_to_from == 'Yes') {
                    $Temp = 1;
                    $Model->send_request_status_to_from = 'No';
                } else if ($Model->send_request_status_to_from == 'No') {
                    return 'IN';
                } else if ($Model->send_request_status_to_from == 'Rejected') {
                    return 'IR';
                } else if ($Model->send_request_status_to_from == 'Accepted') {
                    return 'IA';
                } else {
                    return 'W';
                }
            }
        } else {
            return 'W';
        }
        if ($Temp) {
            if ($Model->save()) {
                $this->actionMailBoxLog($Id, $ToUserId, Yii::$app->params['cancelInterestMessage'], 'CancelInterest');
                //$this->actionMailSendRequest($Id, $ToUserId, $MailType);
                return 'S';
            } else {
                return 'E';
            }
        }
    }

    public function actionUserShortList($Id, $ToUserId, $MailType)
    {
        $Model = UserRequestOp::checkUsers($Id, $ToUserId) == NULL ? new UserRequestOp() : UserRequestOp::checkUsers($Id, $ToUserId);
        $Temp = 0;
        $Model->scenario = UserRequestOp::SCENARIO_SHORTLIST_INTEREST;
        if ($Model->id) {
            if ($Id == $Model->from_user_id) {
                if ($Model->short_list_status_from_to == 'No') {
                    $Temp = 1;
                    $Model->short_list_status_from_to = 'Yes';
                } else if ($Model->short_list_status_from_to == 'Yes') {
                    return 'UB';
                } else {
                    return 'W';
                }

            } else if ($Id == $Model->to_user_id) {
                if ($Model->short_list_status_to_from == 'No') {
                    $Temp = 1;
                    $Model->short_list_status_to_from = 'Yes';
                } else if ($Model->short_list_status_to_from == 'Yes') {
                    return 'UB';
                } else {
                    return 'W';
                }
            }
        } else {
            return 'W';
        }
        if ($Temp) {
            if ($Model->save()) {
                //$this->actionMailBoxLog($Id, $ToUserId, Yii::$app->params['cancelInterestMessage'], 'CancelInterest');
                $this->actionMailSendRequest($Id, $ToUserId, $MailType);
                return 'S';
            } else {
                return 'E';
            }
        }
    }

    public function actionSendIntDashboard()
    {
        $Id = Yii::$app->user->identity->id;
        $ToUserId = Yii::$app->request->post('ToUserId');
        $Flag = $this->actionSendInterest($Id, $ToUserId, 'SEND_INTEREST_OF');
        if ($Flag == 'S') {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'SEND_INTEREST');
        } else if ($Flag == 'E') {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'SEND_INTEREST');
        } else if ($Flag == 'I') {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('I', 'SEND_INTEREST');
        } else {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('W', 'SEND_INTEREST');
        }
        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE);
        return json_encode($return);
    }

    public function actionInterestAccept()
    {
        $Id = Yii::$app->user->identity->id;
        $ToUserId = Yii::$app->request->post('ToUserId');
        $Flag = $this->actionSendInterest($Id, $ToUserId, 'SEND_INTEREST_OF');
        if ($Flag == 'S') {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'SEND_INTEREST');
        } else if ($Flag == 'E') {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'SEND_INTEREST');
        } else if ($Flag == 'I') {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('I', 'SEND_INTEREST');
        } else {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('W', 'SEND_INTEREST');
        }
        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE);
        return json_encode($return);
    }

    public function actionPhotoPopUp()
    {
        $UserPhoto = new UserPhotos();
        $Id = Yii::$app->user->identity->id;
        $UserPhotoList = $UserPhoto->findByUserId($Id);
        $myModel = [
            'model' => $UserPhotoList,
        ];
        $HtmlOutput = $this->renderAjax('_photolistpopup', $myModel);
        $Output = array("HtmlOutput" => $HtmlOutput);
        return json_encode($Output);
    }


    /****
     *  Set Profil Photo set with Cropping Size
     * */
    public function actionSetProfilePhoto()
    {
        $Id = Yii::$app->user->identity->id;
        $ProfilePhotoPath = CommonHelper::getUserUploadFolder(3, $Id);
        $Photo = Yii::$app->request->post('image_name');
        $PhotoId = Yii::$app->request->post('image_id');
        $PID = Yii::$app->request->post('image_id');
        if ($Photo != '' && $PhotoId = !'') {
            list($txt, $ext) = explode(".", $Photo);
            $ActualImageName = $Photo;
            if (1) {
                $ProfilePhotoSize = CommonHelper::getUserResizeRatio();
                if (isset($_POST['t']) and $_POST['t'] == "ajax") {
                    extract(Yii::$app->request->post());
                    $MainImagePath = $ProfilePhotoPath . $ActualImageName;
                    foreach ($ProfilePhotoSize as $KeySize => $ValueSize) {
                        $t_width = $ValueSize;     // Maximum thumbnail width
                        $t_height = $ValueSize;    // Maximum thumbnail height
                        #rand()."_"
                        $NewImagePath = $ProfilePhotoPath . $ValueSize . $ActualImageName;
                        $ratio = ($t_width / $w1);
                        $nw = ceil($w1 * $ratio);
                        $nh = ceil($h1 * $ratio);
                        $nimg = imagecreatetruecolor($nw, $nh);
                        $im_src = imagecreatefromjpeg($MainImagePath);
                        imagecopyresampled($nimg, $im_src, 0, 0, $x1, $y1, $nw, $nh, $w1, $h1);
                        imagejpeg($nimg, $NewImagePath, 90);
                    }

                    /* Set Profile photo Name into database Store */
                    $PG = new UserPhotos();
                    $PG->updateIsProfilePhoto($Id);
                    $UserPhotosModel = $PG->findByPhotoId($Id, $PID);
                    if (count($UserPhotosModel) != 0) {
                        CommonHelper::ProfilePhotoDeleteFromFolder($ProfilePhotoPath, $ProfilePhotoSize, Yii::$app->user->identity->propic); # Delete Photos from Directory.
                        $UserModel = User::findOne($Id);
                        $UserModel->propic = $ActualImageName;
                        $UserModel->eStatusPhotoModify = 'Pending';
                        $UserModel->completed_step = $UserModel->setCompletedStep('7');

                        $ACTION_FLAG = $UserModel->save();
                        $UserPhotosModel->Is_Profile_Photo = 'YES';
                        #$UserPhotosModel->eStatus = 'Pending';
                        $UserPhotosModel->save();
                        $ProfilePhotoURL = CommonHelper::getUserUploadFolder(4, $Id);
                        if ($ACTION_FLAG) {
                            $ProfilePhoto = $ProfilePhotoURL . "200" . $ActualImageName . '?' . time();
                            $ProfilePhotoThumb = $ProfilePhotoURL . "30" . $ActualImageName . '?' . time();
                            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PROFILE_PHOTO_SET');
                        } else {
                            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PROFILE_PHOTO_SET');
                        }
                    }
                    /* Set Profile photo Name into database  END */
                    #$ProfilePhotoURL = CommonHelper::getUserUploadFolder(4, $Id);
                    #$ProfilePhoto = $ProfilePhotoURL . "200" .Yii::$app->params['profilePrefix'].  $ActualImageName.'?'.time();
                    #$ProfilePhotoThumb = $ProfilePhotoURL . "30" .Yii::$app->params['profilePrefix']. $ActualImageName.'?'.time();
                    #list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PROFILE_PHOTO_SET');
                    unlink($MainImagePath);
                }
            } else {
                $MESSAGE = Yii::$app->params['photoCopyError'];
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PROFILE_PHOTO_SET');
            }
        } else {
            $STATUS = 'E';
            $MESSAGE = Yii::$app->params['photoMissingError'];
        }
        $TITLE = 'Profile Photo';
        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE, 'ProfilePhoto' => $ProfilePhoto, 'ProfilePhotoThumb' => $ProfilePhotoThumb);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
    }

    public function actionSetProfilePhotoOne()
    {
        $Id = Yii::$app->user->identity->id;
        $ProfilePhotoPath = CommonHelper::getUserUploadFolder(3, $Id);
        $Photo = Yii::$app->request->post('imgName');
        $PhotoId = Yii::$app->request->post('imgId');
        $PID = Yii::$app->request->post('imgId');
        if ($Photo != '' && $PhotoId = !'') {
            list($txt, $ext) = explode(".", $Photo);
            $ActualImageName = $Photo;
            if ($ActualImageName != '') {
                $Data = $_REQUEST;
                $ProfilePhotoSize = CommonHelper::getUserResizeRatio();
                $TempImageName = Yii::$app->params['profilePrefix'] . rand();
                $Data['ImageName'] = $TempImageName;
                $NewFileName = $ProfilePhotoPath . $TempImageName;
                $TempArray = CommonHelper::commonCroppingUpload($Data, $NewFileName);
                //CommonHelper::pr($TempArray);
                $NewProfilePhotoName = $TempArray['picname'];
                if (1) {
                    $MainImagePath = $ProfilePhotoPath . $NewProfilePhotoName;
                    foreach ($ProfilePhotoSize as $KeySize => $ValueSize) {
                        $w1 = $h1 = Yii::$app->params['cropSize'];
                        $t_width = $ValueSize;     // Maximum thumbnail width
                        $t_height = $ValueSize;    // Maximum thumbnail height
                        $NewImagePath = $ProfilePhotoPath . $ValueSize . $NewProfilePhotoName;
                        $ratio = ($t_width / $w1);
                        $nw = ceil($w1 * $ratio);
                        $nh = ceil($h1 * $ratio);
                        $nimg = imagecreatetruecolor($nw, $nh);
                        $im_src = imagecreatefromjpeg($MainImagePath);
                        //imagecopyresampled($nimg, $im_src, 0, 0 , 0, 200, $nw, $nh, $w1, $h1);
                        imagecopyresampled($nimg, $im_src, 0, 0, 0, 0, $nw, $nh, $w1, $h1);
                        imagejpeg($nimg, $NewImagePath, 100);
                    }
                    /* Set Profile photo Name into database Store */
                    $PG = new UserPhotos();
                    $PG->updateIsProfilePhoto($Id);
                    $UserPhotosModel = $PG->findByPhotoId($Id, $PID);

                    if (count($UserPhotosModel) != 0) {
                        CommonHelper::ProfilePhotoDeleteFromFolder($ProfilePhotoPath, $ProfilePhotoSize, Yii::$app->user->identity->propic); # Delete Photos from Directory.
                        $UserModel = User::findOne($Id);
                        $UserModel->propic = $NewProfilePhotoName;
                        $UserModel->eStatusPhotoModify = 'Pending';
                        $UserModel->completed_step = $UserModel->setCompletedStep('7');

                        $ACTION_FLAG = $UserModel->save();
                        $UserPhotosModel->Is_Profile_Photo = 'YES';
                        //$UserPhotosModel->eStatus = 'Pending';
                        $UserPhotosModel->save();
                        $ProfilePhotoURL = CommonHelper::getUserUploadFolder(4, $Id);
                        if ($ACTION_FLAG) {
                            $ProfilePhoto = $ProfilePhotoURL . "200" . $NewProfilePhotoName . '?' . time();
                            $ProfilePhotoThumb = $ProfilePhotoURL . "30" . $NewProfilePhotoName . '?' . time();
                            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PROFILE_PHOTO_SET');
                        } else {
                            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PROFILE_PHOTO_SET');
                        }
                    }
                    /* Set Profile photo Name into database  END */
                    #$ProfilePhotoURL = CommonHelper::getUserUploadFolder(4, $Id);
                    #$ProfilePhoto = $ProfilePhotoURL . "200" .Yii::$app->params['profilePrefix'].  $ActualImageName.'?'.time();
                    #$ProfilePhotoThumb = $ProfilePhotoURL . "30" .Yii::$app->params['profilePrefix']. $ActualImageName.'?'.time();
                    #list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PROFILE_PHOTO_SET');
                    unlink($MainImagePath);
                }
            } else {
                $MESSAGE = Yii::$app->params['photoCopyError'];
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PROFILE_PHOTO_SET');
            }
        } else {
            $STATUS = 'E';
            $MESSAGE = Yii::$app->params['photoMissingError'];
        }
        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => 'Profile Photo', 'ProfilePhoto' => $ProfilePhoto, 'ProfilePhotoThumb' => $ProfilePhotoThumb);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
    }

    /**
     * @For Photo Move to Profile Directory with Resize.
     * @return string
     */
    public function actionPhotoCropping()
    {
        $Id = Yii::$app->user->identity->id;
        $ProfilePhotoPath = CommonHelper::getUserUploadFolder(3, $Id);
        $ActualImagePATH = CommonHelper::getUserUploadFolder(1) . $Id . "/";
        $MaxWidth = Yii::$app->params['maxWidth'];
        $PHOTO = Yii::$app->request->post('image_name');
        $FileName = $ActualImagePATH . $PHOTO;
        list($orig_width, $orig_height) = getimagesize($FileName);
        if (!is_dir($ProfilePhotoPath)) {
            mkdir($ProfilePhotoPath, 0777);
        }
        $width = $orig_width;
        $height = $orig_height;
        $max_width = 500;
        $max_height = 350;
        # taller
        if ($height > $max_height) {
            $width = ($max_height / $height) * $width;
            $height = $max_height;
        }
        # wider
        if ($width > $max_width) {
            $height = ($max_width / $width) * $height;
            $width = $max_width;
        }
        list($txt, $ext) = explode(".", $PHOTO);
        #$ActualImageName = Yii::$app->params['profilePrefix'] . "_" . $txt . '.' . $ext;
        $ActualImageName = $TempImageName = Yii::$app->params['profilePrefix'] . rand() . "_" . $txt . '.' . $ext;
        $image_p = imagecreatetruecolor($width, $height);
        $image = imagecreatefromjpeg($FileName);
        imagecopyresampled($image_p, $image, 0, 0, 0, 0,
            $width, $height, $orig_width, $orig_height);
        imagejpeg($image_p, $ProfilePhotoPath . $ActualImageName, 90);
        $ProfilePhotoURL = CommonHelper::getUserUploadFolder(4, $Id);
        $return = array('PhotoCrop' => $ProfilePhotoURL . $ActualImageName . '?' . time(), 'ImageName' => $ActualImageName, 'ImagePath' => $ProfilePhotoPath . $ActualImageName);
        return json_encode($return);
    }

    public function actionUserProfile($uk = '')
    {
        /*if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }*/
        if (!isset($uk) || $uk == '') {
            if (Yii::$app->user->isGuest) {
                return $this->goHome();
            } else {
                return $this->redirect(['user/dashboard']);
            }
        }
        #$id = Yii::$app->user->identity->id;
        $UserId = User::getIdNo($uk);
        if ($UserId) {
            if (!Yii::$app->user->isGuest) {
                if ($UserId == Yii::$app->user->identity->id) {
                    return $this->redirect(['user/my-profile']);
                }
            }
            $model = User::find()->joinWith([countryName, stateName, cityName, height, maritalStatusName, talukaName, districtName, gotraName, subCommunityName, communityName, religionName, educationLevelName, communityName, workingWithName, workingAsName, dietName, fatherStatus])->where(['id' => $UserId])->one();
            if ($model->status == User::STATUS_ACTIVE || $model->status == User::STATUS_APPROVE) {
                $USER_PHOTO_MODEL = new  UserPhotos();
                $USER_PHOTOS_LIST = $USER_PHOTO_MODEL->findByUserId($UserId);
                $COVER_PHOTO = CommonHelper::getCoverPhotos($TYPE = 'USER', $UserId, $model->cover_photo);

                $Gender = ($model->Gender == 'MALE') ? 'MALE' : 'FEMALE';
                list($SimilarProfile, $SuccessStories) = $this->actionRightSideBar($Gender, $UserId, 3);
                #Preferences
                $PartenersReligion = PartenersReligion::findByUserId($UserId) == NULL ? new PartenersReligion() : PartenersReligion::findByUserId($UserId);
                $UPP = UserPartnerPreference::findByUserId($UserId) == NULL ? new UserPartnerPreference() : UserPartnerPreference::findByUserId($UserId);
                $PartnersMaritalStatus = PartnersMaritalStatus::findByUserId($UserId) == NULL ? new PartnersMaritalStatus() : PartnersMaritalStatus::findByUserId($UserId);
                $PartnersGotra = PartnersGotra::findByUserId($UserId) == NULL ? new PartnersGotra() : PartnersGotra::findByUserId($UserId);
                $PartnersMothertongue = PartnersMothertongue::findByUserId($UserId) == NULL ? new PartnersMothertongue() : PartnersMothertongue::findByUserId($UserId);
                //$MasterHeight = MasterHe`ight::findByUserId($UserId) == NULL ? new MasterHeight() : MasterHeight::findByUserId($UserId);
                $PartnersCommunity = PartnersCommunity::findByUserId($UserId) == NULL ? new PartnersCommunity() : PartnersCommunity::findByUserId($UserId);
                $PartnersSubCommunity = PartnersSubcommunity::findByUserId($UserId) == NULL ? new PartnersSubcommunity() : PartnersSubcommunity::findByUserId($UserId);

                $PartnersEducationalLevel = PartnersEducationalLevel::findByUserId($UserId) == NULL ? new PartnersEducationalLevel() : PartnersEducationalLevel::findByUserId($UserId);
                $PartnersEducationField = PartnersEducationField::findByUserId($UserId) == NULL ? new PartnersEducationField() : PartnersEducationField::findByUserId($UserId);
                $PW = PartnerWorkingAs::findByUserId($UserId) == NULL ? new PartnerWorkingAs() : PartnerWorkingAs::findByUserId($UserId);
                $WorkingW = PartnerWorkingWith::findByUserId($UserId) == NULL ? new PartnerWorkingWith() : PartnerWorkingWith::findByUserId($UserId);
                $AI = PartnersAnnualIncome::findByUserId($UserId) == NULL ? new PartnersAnnualIncome() : PartnersAnnualIncome::findByUserId($UserId);


                $PC = PartnersCities::findByUserId($UserId) == NULL ? new PartnersCities() : PartnersCities::findByUserId($UserId);
                $PS = PartnersStates::findByUserId($UserId) == NULL ? new PartnersStates() : PartnersStates::findByUserId($UserId);
                $PCS = PartnersCountries::findByUserId($UserId) == NULL ? new PartnersCountries() : PartnersCountries::findByUserId($UserId);
                $TAG_LIST_USER = UserTag::find()->joinWith([tagName])->where(['iUser_Id' => $UserId])->orderBy(['Name' => SORT_ASC])->all();
                $Flag = 1;
                return $this->render('user-profile',
                    ['model' => $model, 'photo_model' => $USER_PHOTOS_LIST, 'COVER_PHOTO' => $COVER_PHOTO, 'TAG_LIST' => $TAG_LIST, 'TAG_LIST_USER' => $TAG_LIST_USER, 'SimilarProfile' => $SimilarProfile, 'flag' => $Flag,
                        'PartenersReligion' => $PartenersReligion,
                        'UPP' => $UPP,
                        'PartnersMaritalStatus' => $PartnersMaritalStatus,
                        'PartnersGotra' => $PartnersGotra,
                        'PartnersMothertongue' => $PartnersMothertongue,
                        'PartnersCommunity' => $PartnersCommunity,
                        'PartnersSubCommunity' => $PartnersSubCommunity,
                        'PartnersEducationalLevel' => $PartnersEducationalLevel,
                        'PartnersEducationField' => $PartnersEducationField,
                        'PW' => $PW,
                        'WorkingW' => $WorkingW,
                        'AI' => $AI,
                        'PC' => $PC,
                        'PS' => $PS,
                        'PCS' => $PCS,
                        'TAG_LIST_USER' => $TAG_LIST_USER,
                    ]
                );
            } else if ($model->status == User::STATUS_BLOCK || $model->status == User::STATUS_INACTIVE || $model->status == User::STATUS_PENDING) {
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'USER_BLOCK_INACTIVE_PENDING');
                $Flag = 2;
            } else if ($model->status == User::STATUS_DELETED || $model->status == User::STATUS_DISAPPROVE) {
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'USER_DELETED_DISAPPROVE');
                $Flag = 3;
            }
            return $this->render('user-profile',
                ['flag' => $Flag, 'STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE]
            );
        } else {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'USER_NOT_EXIST');
            return $this->render('user-profile',
                ['flag' => 0, 'STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE]
            );
        }
    }

    public function actionPhotoDelete()
    {
        unlink(Yii::$app->request->post('ImagePath'));
    }
}

