<?php
namespace frontend\controllers;

use common\components\CommonHelper;
use common\components\MessageHelper;
use common\components\SmsHelper;
use common\models\Mailbox;
use common\models\PartnersAnnualIncome;
use common\models\PartnersBodyType;
use common\models\PartnersCharan;
use common\models\PartnersCities;
use common\models\PartnersCommunity;
use common\models\PartnersCountries;
use common\models\PartnersDiet;
use common\models\PartnersDrink;
use common\models\PartnersFamilyAffluenceLevel;
use common\models\PartnersFamilyType;
use common\models\PartnersFavouriteCousines;
use common\models\PartnersFavouriteMusic;
use common\models\PartnersFavouriteReads;
use common\models\PartnersFitnessActivities;
use common\models\PartnersInterest;
use common\models\PartnersMothertongue;
use common\models\PartnersNadi;
use common\models\PartnersNakshtra;
use common\models\PartnersPreferredDressType;
use common\models\PartnersPreferredMovies;
use common\models\PartnersRaashi;
use common\models\PartnersReligion;
use common\models\PartnersSkinTone;
use common\models\PartnersSmoke;
use common\models\PartnersSpectacles;
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

        //if ($PERCENTAGE <= 50) $PERCENTAGE -= 1;
//        if ($PERCENTAGE != 0) $PERCENTAGE += 5;
//#echo $PERCENTAGE;exit;
        return $PERCENTAGE;
    }

    public function beforeAction($action)
    {
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
        $USER_PHOTOS_LIST = $USER_PHOTO_MODEL->findByUserId($id, 6);
        $UserTotalPhotoCount = $USER_PHOTO_MODEL->findByUserId($id);
        $COVER_PHOTO = CommonHelper::getCoverPhotos($TYPE = 'USER', $id, $model->cover_photo);
        $TAG_LIST = Tags::find()->orderBy('rand()')->all();   //orderBy(['rand()' => SORT_DESC]);
        $TAG_LIST_USER = UserTag::find()->joinWith([tagName])->where(['iUser_Id' => $id])->orderBy(['Name' => SORT_ASC])->all();
        $Gender = (Yii::$app->user->identity->Gender == 'MALE') ? 'FEMALE' : 'MALE';
        list($SimilarProfile, $SuccessStories) = $this->actionRightSideBar($Gender, $id, 3);
        return $this->render('my-profile',
            ['model' => $model, 'UserTotalPhotoCount' => $UserTotalPhotoCount, 'photo_model' => $USER_PHOTOS_LIST, 'COVER_PHOTO' => $COVER_PHOTO, 'TAG_LIST' => $TAG_LIST, 'TAG_LIST_USER' => $TAG_LIST_USER, 'SimilarProfile' => $SimilarProfile, 'tab' => $tab]

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
            $Id = Yii::$app->user->identity->id;
            if ($model = User::findOne($Id)) {
                CommonHelper::checkVerification();
                $model->scenario = User::SCENARIO_REGISTER6;
                $VER_ARRAY = array();
                $Gender = (Yii::$app->user->identity->Gender == 'MALE') ? 'FEMALE' : 'MALE';
                #$ProfileViedByMembers = UserRequest::findProfileViewedByUserList($Id, 4);
                $ProfileViedByMembers = UserRequestOp::findProfileViewedByUserList($Id, 4);
                //$RecentlyJoinedMembers = User::findRecentJoinedUserLists($Id,$Gender, 4);
                $RecentlyJoinedMembers = User::findRecentJoinedUserList($Gender, 4);
                //echo $RecentlyJoinedMembers->createCommand()->sql;exit;
                list($SimilarProfile, $SuccessStories) = $this->actionRightSideBar($Gender, $Id, 3);

                #Shortlist User
                $ShortList = UserRequestOp::getShortList($Id, 0, 3);
                foreach ($ShortList as $Key => $Value) {
                    #CommonHelper::pr($Value);exit;
                    if ($Value->from_user_id == $Id) {
                        $ShortListInfo[$Key] = $Value->toUserInfo;
                    } else {
                        $ShortListInfo[$Key] = $Value->fromUserInfo;
                    }
                }
                #CommonHelper::pr($ModelInfo);
                #CommonHelper::pr($ShortList);exit;


                # My Preferences Start
                # Location Wise
                $PC = PartnersCities::findByUserId($Id);
                $PS = PartnersStates::findByUserId($Id);
                $PCS = PartnersCountries::findByUserId($Id);
                $PreferencesLocation = User::getPreferencesLocation($Gender, $Id, $PC->city_id, $PS->state_id, $PCS->country_id);

                # Education Wise
                $iEducationLevelID = PartnersEducationalLevel::findByUserId($Id);
                $iEducationFieldID = PartnersEducationField::findByUserId($Id);
                $PreferencesEducation = User::getPreferencesEducation($Gender, $Id, $iEducationLevelID->iEducation_Level_ID, $iEducationFieldID->iEducation_Field_ID);

                # Profession Wise
                $iWorkingWithID = PartnerWorkingWith::findByUserId($Id);
                $iWorkingAsID = PartnerWorkingAs::findByUserId($Id);
                $iAnnualIncomeID = PartnersAnnualIncome::findByUserId($Id);
                $PreferencesProfession = User::getPreferencesProfession($Gender, $Id, $iWorkingWithID->iWorking_With_ID, $iWorkingAsID->iWorking_As_ID, $iAnnualIncomeID->annual_income_id);

                # Personal ( My Preferences ) Wise
                $iReligion_ID = PartnersReligion::findByUserId($Id);
                $iMaritalStatusID = PartnersMaritalStatus::findByUserId($Id);
                $PreferencesPersonal = User::getPreferencesPersonal($Gender, $Id, $iReligion_ID->iReligion_ID, $iMaritalStatusID->iMarital_Status_ID);
                //CommonHelper::pr($PreferencesPersonal);exit;
                #echo count($PreferencesPersonal);exit;
                # My Preferences End
                $TotalInboxCount = Mailbox::getUnreadMailCount($Id);
                return $this->render('dashboard', [
                    'model' => $model,
                    'VER_ARRAY' => $VER_ARRAY,
                    'type' => $type,
                    'RecentlyJoinedMembers' => $RecentlyJoinedMembers,
                    'ProfileViedByMembers' => $ProfileViedByMembers,
                    'SimilarProfile' => $SimilarProfile,
                    'ShortListUser' => $ShortListInfo,

                    'PreferencesLocation' => $PreferencesLocation,
                    'PreferencesEducation' => $PreferencesEducation,
                    'PreferencesProfession' => $PreferencesProfession,
                    'PreferencesPersonal' => $PreferencesPersonal,
                    'TotalInboxCount' => $TotalInboxCount,
                ]);
            } else {
                return $this->redirect(Yii::getAlias('@web'));
            }
        } else {
            return $this->redirect(Yii::getAlias('@web'));
        }
    }

    public function actionPhotos($ref = '')
    {
        if (!Yii::$app->user->isGuest) {
            //CommonHelper::checkVerification();
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
                        $MAIL_DATA = array("EMAIL" => $model->email, "EMAIL_TO" => $model->email, "NAME" => $model->FullName, "PIN" => $PIN, 'MINUTES' => Yii::$app->params['timePinValidate']);
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
        #$model->scenario = User::SCENARIO_EDIT_PERSONAL_INFO;
        $model->scenario = User::SCENARIO_EDIT_PERSONAL_INFO_BASIC_INFO;
        $show = false;
        $popup = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if (Yii::$app->request->post('save')) {
                # $NewMobileNo = Yii::$app->request->post('User')['Mobile'];
                # $OldMobileNo = $model->Mobile;
                $model->First_Name = Yii::$app->request->post('User')['First_Name'];
                $model->Last_Name = Yii::$app->request->post('User')['Last_Name'];
                $model->Profile_created_for = Yii::$app->request->post('User')['Profile_created_for'];
                $model->DOB = Yii::$app->request->post('User')['DOB'];
                // echo "hii";
                // die();
                $model->Age = CommonHelper::ageCalculator(Yii::$app->request->post('User')['DOB']);
                # $model->county_code = $model->county_code;//Yii::$app->request->post('User')['county_code'];
                #   $model->Mobile = $model->Mobile;//$NewMobileNo;
                $model->Gender = Yii::$app->request->post('User')['Gender'];
                $model->mother_tongue = Yii::$app->request->post('User')['mother_tongue'];
                #CommonHelper::pr( Yii::$app->request->post());

                #Start  Second Step
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

                $CityName = $model->cityName->vCityName;
                $StateName = $model->stateName->vStateName;
                $CountryName = $model->countryName->vCountryName;
                $Address = $model->vAreaName . " " . $CityName . " " . $StateName . " " . $CountryName;
                $LatLongArray = CommonHelper::getLatLong($Address);
                $model->latitude = $LatLongArray['latitude'];
                $model->longitude = $LatLongArray['longitude'];
                #End Second Step


                if ($model->validate()) {
                    #if ($NewMobileNo != $OldMobileNo) {
                    /*$TimeOut = CommonHelper::getDateTimeToString(CommonHelper::getTime());
                    $PIN_P = CommonHelper::generateNumericUniqueToken(4);
                    //new_phone_no
                    $model->new_phone_no = $NewMobileNo;
                    $model->pin_phone_vaerification = $PIN_P;
                    $model->ePhoneVerifiedStatus = 'No';
                    $model->pin_phone_time = $TimeOut;
                    $model->completed_step = CommonHelper::unsetStep($model->completed_step, 8);
                    $SMSArray = array("OTP" => $PIN_P);
                    $SMSFlag = SmsHelper::SendSMS($NewMobileNo, 'PHONE_OTP', $SMSArray);
                    $popup = true;*/
                    # }
                    #$model->Mobile = $OldMobileNo;
                    #  var_dump($model->save());exit;
                    $model->completed_step = $model->setCompletedStep('2');
                    if ($model->save())
                        $show = false;
                    else
                        $show = true;
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

                $CityName = $model->cityName->vCityName;
                $StateName = $model->stateName->vStateName;
                $CountryName = $model->countryName->vCountryName;
                $Address = $model->vAreaName . " " . $CityName . " " . $StateName . " " . $CountryName;
                $LatLongArray = CommonHelper::getLatLong($Address);
                $model->latitude = $LatLongArray['latitude'];
                $model->longitude = $LatLongArray['longitude'];

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
            if (Yii::$app->request->post('save')) {
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
            if (Yii::$app->request->post('save')) {
                $model->iHeightID = Yii::$app->request->post('User')['iHeightID'];
                $model->vSkinTone = Yii::$app->request->post('User')['vSkinTone'];
                $model->vBodyType = Yii::$app->request->post('User')['vBodyType'];
                $model->vSmoke = Yii::$app->request->post('User')['vSmoke'];
                $model->vDrink = Yii::$app->request->post('User')['vDrink'];
                $model->vSpectaclesLens = Yii::$app->request->post('User')['vSpectaclesLens'];
                $model->vDiet = Yii::$app->request->post('User')['vDiet'];
                $model->weight = Yii::$app->request->post('User')['weight'];
                if ($model->validate()) {
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
            if (Yii::$app->request->post('save')) {
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
        } else {
            return $this->actionRenderAjax($model, '_family', false);
        }
    }

    public function actionEditPreferences()
    {
        $Id = Yii::$app->user->identity->id;
        $PartenersReligion = PartenersReligion::findAllByUserId($Id) == NULL ? new PartenersReligion() : PartenersReligion::findAllByUserId($Id);
        $PartnersMaritalStatus = PartnersMaritalStatus::findAllByUserId($Id) == NULL ? new PartnersMaritalStatus() : PartnersMaritalStatus::findAllByUserId($Id);
        $PartnersGotra = PartnersGotra::findAllByUserId($Id) == NULL ? new PartnersGotra() : PartnersGotra::findAllByUserId($Id);

        $PartnersCommunity = PartnersCommunity::findAllByUserId($Id) == NULL ? new PartnersCommunity() : PartnersCommunity::findAllByUserId($Id);
        $PartnersSubCommunity = PartnersSubcommunity::findAllByUserId($Id) == NULL ? new PartnersSubcommunity() : PartnersSubcommunity::findAllByUserId($Id);


        $UPP = UserPartnerPreference::findByUserId($Id) == NULL ? new UserPartnerPreference() : UserPartnerPreference::findByUserId($Id);

        $PartnersMothertongue = PartnersMothertongue::findByUserId($Id) == NULL ? new PartnersMothertongue() : PartnersMothertongue::findByUserId($Id);

        $PartnersRaashi = PartnersRaashi::findByUserId($Id) == NULL ? new PartnersRaashi() : PartnersRaashi::findByUserId($Id);
        $PartnersCharan = PartnersCharan::findByUserId($Id) == NULL ? new PartnersCharan() : PartnersCharan::findByUserId($Id);
        $PartnersNakshtra = PartnersNakshtra::findByUserId($Id) == NULL ? new PartnersNakshtra() : PartnersNakshtra::findByUserId($Id);
        $PartnersNadi = PartnersNadi::findByUserId($Id) == NULL ? new PartnersNadi() : PartnersNadi::findByUserId($Id);

        $PartnersSkinTone = PartnersSkinTone::findAllByUserId($Id) == NULL ? new PartnersSkinTone() : PartnersSkinTone::findAllByUserId($Id);
        $PartnersBodyType = PartnersBodyType::findAllByUserId($Id) == NULL ? new PartnersBodyType() : PartnersBodyType::findAllByUserId($Id);
        $PartnersDiet = PartnersDiet::findAllByUserId($Id) == NULL ? new PartnersDiet() : PartnersDiet::findAllByUserId($Id);
        $PartnersSpectacles = PartnersSpectacles::findAllByUserId($Id) == NULL ? new PartnersSpectacles() : PartnersSpectacles::findAllByUserId($Id);
        $PartnersSmoke = PartnersSmoke::findAllByUserId($Id) == NULL ? new PartnersSmoke() : PartnersSmoke::findAllByUserId($Id);
        $PartnersDrink = PartnersDrink::findAllByUserId($Id) == NULL ? new PartnersDrink() : PartnersDrink::findAllByUserId($Id);

        $model = User::findOne($Id);
        #CommonHelper::pr($PartnersSmoke);exit;
        #echo " 111=> ";CommonHelper::pr($PartenersReligionIDs);echo "<=";exit;
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if (Yii::$app->request->post('save')) {
                $show = false;

                $CurrDate = CommonHelper::getTime();
                $UPP->scenario = UserPartnerPreference::SCENARIO_PREFERENCE;
                $UPP->iUser_id = $Id;
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

                $ReligionId = Yii::$app->request->post('PartenersReligion')['iReligion_ID'];
                PartnersReligion::deleteAll(['iUser_ID' => $Id]);
                if (count($ReligionId)) {
                    foreach ($ReligionId as $RK => $RV) {
                        $PRObj = new PartenersReligion();
                        $PRObj->iUser_ID = $Id;
                        $PRObj->iReligion_ID = $RV;
                        $PRObj->dtModified = $CurrDate;
                        $PRObj->dtCreated = $CurrDate;
                        $STK = $PRObj->save();
                    }
                }
                $PartenersReligion = PartenersReligion::findAllByUserId($Id);

                $MaritalStatusID = Yii::$app->request->post('PartnersMaritalStatus')['iMarital_Status_ID'];
                PartnersMaritalStatus::deleteAll(['iUser_ID' => $Id]);
                if (count($MaritalStatusID)) {
                    foreach ($MaritalStatusID as $RK => $RV) {
                        $PMSObj = new PartnersMaritalStatus();
                        $PMSObj->iUser_ID = $Id;
                        $PMSObj->iMarital_Status_ID = $RV;
                        $PMSObj->dtModified = $CurrDate;
                        $PMSObj->dtCreated = $CurrDate;
                        $STK = $PMSObj->save();
                    }
                }
                $PartnersMaritalStatus = PartnersMaritalStatus::findAllByUserId($Id);

                $GotraIDs = Yii::$app->request->post('PartnersGotra')['iGotra_ID'];
                PartnersGotra::deleteAll(['iUser_ID' => $Id]);
                if (count($GotraIDs)) {
                    foreach ($GotraIDs as $RK => $RV) {
                        $PGotraObj = new PartnersGotra();
                        $PGotraObj->iUser_ID = $Id;
                        $PGotraObj->iGotra_ID = $RV;
                        $PGotraObj->dtModified = $CurrDate;
                        $PGotraObj->dtCreated = $CurrDate;
                        $STK = $PGotraObj->save();
                    }
                }
                $PartnersGotra = PartnersGotra::findAllByUserId($Id);


                $RaashiID = Yii::$app->request->post('PartnersRaashi')['raashi_id'];
                if ($RaashiID != '') {
                    $PartnersRaashi->user_id = $Id;
                    $PartnersRaashi->raashi_id = $RaashiID;
                    $PartnersRaashi->modified_on = $CurrDate;
                    if ($PartnersRaashi->ID == "") {
                        $PartnersRaashi->created_on = $CurrDate;
                    }
                    $PartnersRaashi->save();
                }
                $CharanID = Yii::$app->request->post('PartnersCharan')['charan_id'];
                if ($CharanID != '') {
                    $PartnersCharan->user_id = $Id;
                    $PartnersCharan->charan_id = $CharanID;
                    $PartnersCharan->modified_on = $CurrDate;
                    if ($PartnersCharan->ID == "") {
                        $PartnersCharan->created_on = $CurrDate;
                    }
                    $PartnersCharan->save();
                }

                $NakshtraID = Yii::$app->request->post('PartnersNakshtra')['nakshtra_id'];
                if ($NakshtraID != '') {
                    $PartnersNakshtra->user_id = $Id;
                    $PartnersNakshtra->nakshtra_id = $NakshtraID;
                    $PartnersNakshtra->modified_on = $CurrDate;
                    if ($PartnersNakshtra->ID == "") {
                        $PartnersNakshtra->created_on = $CurrDate;
                    }
                    $PartnersNakshtra->save();
                }

                $NadiID = Yii::$app->request->post('PartnersNadi')['nadi_id'];
                if ($NadiID != '') {
                    $PartnersNadi->user_id = $Id;
                    $PartnersNadi->nadi_id = $NadiID;
                    $PartnersNadi->modified_on = $CurrDate;
                    if ($PartnersNadi->ID == "") {
                        $PartnersNadi->created_on = $CurrDate;
                    }
                    $PartnersNadi->save();
                }

                $MotherID = Yii::$app->request->post('PartnersMothertongue')['iMothertongue_ID'];
                if ($MotherID !== '') {
                    $PartnersMothertongue->scenario = PartnersMothertongue::SCENARIO_ADD;
                    $PartnersMothertongue->iUser_ID = $Id;
                    $PartnersMothertongue->iMothertongue_ID = $MotherID;
                    $PartnersMothertongue->dtModified = $CurrDate;
                    if ($PartnersMothertongue->iPartners_Mothertongue_ID == "") {
                        $PartnersMothertongue->dtCreated = $CurrDate;
                    }
                    $PartnersMothertongue->save();
                }

                $SkinToneIDs = Yii::$app->request->post('PartnersSkinTone')['iSkin_Tone_ID'];
                PartnersSkinTone::deleteAll(['iUser_ID' => $Id]);
                if (count($SkinToneIDs)) {
                    foreach ($SkinToneIDs as $RK => $RV) {
                        $PSkinToneObj = new PartnersSkinTone();
                        $PSkinToneObj->iUser_ID = $Id;
                        $PSkinToneObj->iSkin_Tone_ID = $RV;
                        $STK = $PSkinToneObj->save();
                    }
                }
                $PartnersSkinTone = PartnersSkinTone::findAllByUserId($Id);

                $BodyTypeIDs = Yii::$app->request->post('PartnersBodyType')['iBody_Type_ID'];
                PartnersBodyType::deleteAll(['iUser_ID' => $Id]);
                if (count($BodyTypeIDs)) {
                    foreach ($BodyTypeIDs as $RK => $RV) {
                        $PBodyTypeObj = new PartnersBodyType();
                        $PBodyTypeObj->iUser_ID = $Id;
                        $PBodyTypeObj->iBody_Type_ID = $RV;
                        $STK = $PBodyTypeObj->save();
                    }
                }
                $PartnersBodyType = PartnersBodyType::findAllByUserId($Id);

                $DietIDs = Yii::$app->request->post('PartnersDiet')['diet_id'];
                PartnersDiet::deleteAll(['user_id' => $Id]);
                if (count($DietIDs)) {
                    foreach ($DietIDs as $RK => $RV) {
                        $PDietObj = new PartnersDiet();
                        $PDietObj->user_id = $Id;
                        $PDietObj->diet_id = $RV;
                        $STK = $PDietObj->save();
                    }
                }
                $PartnersDiet = PartnersDiet::findAllByUserId($Id);

                $SpectaclesTypes = Yii::$app->request->post('PartnersSpectacles')['type'];
                PartnersSpectacles::deleteAll(['user_id' => $Id]);
                if (count($SpectaclesTypes)) {
                    foreach ($SpectaclesTypes as $RK => $RV) {
                        $PSpectaclesObj = new PartnersSpectacles();
                        $PSpectaclesObj->user_id = $Id;
                        $PSpectaclesObj->type = $RV;
                        $STK = $PSpectaclesObj->save();
                    }
                }
                $PartnersSpectacles = PartnersSpectacles::findAllByUserId($Id);

                $SmokeTypes = Yii::$app->request->post('PartnersSmoke')['smoke_type'];
                PartnersSmoke::deleteAll(['user_id' => $Id]);
                if (count($SmokeTypes)) {
                    foreach ($SmokeTypes as $RK => $RV) {
                        $PSmokeObj = new PartnersSmoke();
                        $PSmokeObj->user_id = $Id;
                        $PSmokeObj->smoke_type = $RV;
                        $STK = $PSmokeObj->save();
                    }
                }
                $PartnersSmoke = PartnersSmoke::findAllByUserId($Id);

                $DrinkTypes = Yii::$app->request->post('PartnersDrink')['drink_type'];
                PartnersDrink::deleteAll(['user_id' => $Id]);
                if (count($DrinkTypes)) {
                    foreach ($DrinkTypes as $RK => $RV) {
                        $PDrinkObj = new PartnersDrink();
                        $PDrinkObj->user_id = $Id;
                        $PDrinkObj->drink_type = $RV;
                        $STK = $PDrinkObj->save();
                    }
                }
                $PartnersDrink = PartnersDrink::findAllByUserId($Id);

                $CommunityID = Yii::$app->request->post('PartnersCommunity')['iCommunity_ID'];
                PartnersCommunity::deleteAll(['iUser_ID' => $Id]);
                if (count($CommunityID)) {
                    foreach ($CommunityID as $RK => $RV) {
                        $PartnersCommunity = new PartnersCommunity();
                        $PartnersCommunity->scenario = PartnersCommunity::SCENARIO_ADD;
                        $PartnersCommunity->iUser_ID = $Id;
                        $PartnersCommunity->iCommunity_ID = $RV;
                        $STK = $PartnersCommunity->save();
                    }
                }
                $PartnersCommunity = PartnersCommunity::findAllByUserId($Id);

                $SubCommuIDs = Yii::$app->request->post('PartnersSubcommunity')['iSub_Community_ID'];
                PartnersSubcommunity::deleteAll(['iUser_ID' => $Id]);
                if (count($SubCommuIDs)) {
                    foreach ($SubCommuIDs as $RK => $RV) {
                        $PartnersSubCommunity = new PartnersSubcommunity();
                        $PartnersSubCommunity->scenario = PartnersSubcommunity::SCENARIO_ADD;
                        $PartnersSubCommunity->iUser_ID = $Id;
                        $PartnersSubCommunity->iSub_Community_ID = $RV;
                        $STK = $PartnersSubCommunity->save();
                    }
                }
                $PartnersSubCommunity = PartnersSubcommunity::findAllByUserId($Id);

            }
        }
        $PartenersReligionIDs = CommonHelper::convertArrayToString($PartenersReligion, 'iReligion_ID');
        $PartnersMaritalPreferences = CommonHelper::convertArrayToString($PartnersMaritalStatus, 'iMarital_Status_ID');
        $PartnersGotraPreferences = CommonHelper::convertArrayToString($PartnersGotra, 'iGotra_ID');
        $PartnersSkinTone = CommonHelper::convertArrayToString($PartnersSkinTone, 'iSkin_Tone_ID');
        $PartnersBodyType = CommonHelper::convertArrayToString($PartnersBodyType, 'iBody_Type_ID');
        $PartnersDiet = CommonHelper::convertArrayToString($PartnersDiet, 'diet_id');
        $PartnersSpectacles = CommonHelper::convertArrayToString($PartnersSpectacles, 'type');
        $PartnersSmoke = CommonHelper::convertArrayToString($PartnersSmoke, 'smoke_type');
        $PartnersDrink = CommonHelper::convertArrayToString($PartnersDrink, 'drink_type');
        $PartnersCommunity = CommonHelper::convertArrayToString($PartnersCommunity, 'iCommunity_ID');
        $PartnersSubCommunity = CommonHelper::convertArrayToString($PartnersSubCommunity, 'iSub_Community_ID');
        #CommonHelper::pr($PartnersSmoke);exit;
        $myModel = [
            'PartenersReligion' => $PartenersReligion,
            'PartenersReligionIDs' => $PartenersReligionIDs,
            'PartnersMaritalPreferences' => $PartnersMaritalPreferences,
            'PartnersGotraPreferences' => $PartnersGotraPreferences,
            'model' => $model,
            'UPP' => $UPP,
            'PartnersMaritalStatus' => $PartnersMaritalStatus,
            'PartnersGotra' => $PartnersGotra,
            'PartnersMothertongue' => $PartnersMothertongue,
            'PartnersCommunity' => $PartnersCommunity,
            'PartnersSubCommunity' => $PartnersSubCommunity,
            'show' => $show,
            'PartnersRaashi' => $PartnersRaashi,
            'PartnersCharan' => $PartnersCharan,
            'PartnersNakshtra' => $PartnersNakshtra,
            'PartnersNadi' => $PartnersNadi,
            'PartnersSkinTone' => $PartnersSkinTone,
            'PartnersBodyType' => $PartnersBodyType,
            'PartnersDiet' => $PartnersDiet,
            'PartnersSpectacles' => $PartnersSpectacles,
            'PartnersSmoke' => $PartnersSmoke,
            'PartnersDrink' => $PartnersDrink,

        ];
        return $this->renderAjax('_preferences', $myModel);
    }

    public function actionEditPreferencesProfession()
    {
        $Id = Yii::$app->user->identity->id;
        $UPP = UserPartnerPreference::findByUserId($Id) == NULL ? new UserPartnerPreference() : UserPartnerPreference::findByUserId($Id);
        $PartnersEducationalLevel = PartnersEducationalLevel::findAllByUserId($Id) == NULL ? new PartnersEducationalLevel() : PartnersEducationalLevel::findAllByUserId($Id);
        $PartnersEducationField = PartnersEducationField::findAllByUserId($Id) == NULL ? new PartnersEducationField() : PartnersEducationField::findAllByUserId($Id);
        $PartnerWorkingAS = PartnerWorkingAs::findAllByUserId($Id) == NULL ? new PartnerWorkingAs() : PartnerWorkingAs::findAllByUserId($Id);
        $PartnerWorkingWith = PartnerWorkingWith::findAllByUserId($Id) == NULL ? new PartnerWorkingWith() : PartnerWorkingWith::findAllByUserId($Id);
        $AI = PartnersAnnualIncome::findByUserId($Id) == NULL ? new PartnersAnnualIncome() : PartnersAnnualIncome::findByUserId($Id);
        $model = User::findOne($Id);
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if (Yii::$app->request->post('save')) {
                $show = false;
                $EducationLevelIDs = Yii::$app->request->post('PartnersEducationalLevel')['iEducation_Level_ID'];
                PartnersEducationalLevel::deleteAll(['iUser_ID' => $Id]);
                if (count($EducationLevelIDs)) {
                    foreach ($EducationLevelIDs as $RK => $RV) {
                        $PEduLvlObj = new PartnersEducationalLevel();
                        $PEduLvlObj->iUser_ID = $Id;
                        $PEduLvlObj->iEducation_Level_ID = $RV;
                        $STK = $PEduLvlObj->save();
                    }
                }
                $PartnersEducationalLevel = PartnersEducationalLevel::findAllByUserId($Id);

                $EducationFieldIDs = Yii::$app->request->post('PartnersEducationField')['iEducation_Field_ID'];
                PartnersEducationField::deleteAll(['iUser_ID' => $Id]);
                if (count($EducationFieldIDs)) {
                    foreach ($EducationFieldIDs as $RK => $RV) {
                        $PEduFieldObj = new PartnersEducationField();
                        $PEduFieldObj->iUser_ID = $Id;
                        $PEduFieldObj->iEducation_Field_ID = $RV;
                        $STK = $PEduFieldObj->save();
                    }
                }
                $PartnersEducationField = PartnersEducationField::findAllByUserId($Id);


                $WorkingAsIDs = Yii::$app->request->post('PartnerWorkingAs')['iWorking_As_ID'];
                PartnerWorkingAs::deleteAll(['iUser_ID' => $Id]);
                if (count($WorkingAsIDs)) {
                    foreach ($WorkingAsIDs as $RK => $RV) {
                        $PWorkingAsObj = new PartnerWorkingAs();
                        $PWorkingAsObj->iUser_ID = $Id;
                        $PWorkingAsObj->iWorking_As_ID = $RV;
                        $STK = $PWorkingAsObj->save();
                    }
                }
                $PartnerWorkingAS = PartnerWorkingAs::findAllByUserId($Id);

                $WorkingWithIDs = Yii::$app->request->post('PartnerWorkingWith')['iWorking_With_ID'];
                PartnerWorkingWith::deleteAll(['iUser_ID' => $Id]);
                if (count($WorkingWithIDs)) {
                    foreach ($WorkingWithIDs as $RK => $RV) {
                        $PWorkingWithObj = new PartnerWorkingWith();
                        $PWorkingWithObj->iUser_ID = $Id;
                        $PWorkingWithObj->iWorking_With_ID = $RV;
                        $STK = $PWorkingWithObj->save();
                    }
                }
                $PartnerWorkingWith = PartnerWorkingWith::findAllByUserId($Id);
                $UPP->scenario = UserPartnerPreference::SCENARIO_PREFERENCE;
                $UPP->annual_income_from = Yii::$app->request->post('UserPartnerPreference')['annual_income_from'];
                $UPP->annual_income_to = Yii::$app->request->post('UserPartnerPreference')['annual_income_to'];
                $UPP->save();
            }
        }
        $PartenersEduLevelArray = CommonHelper::convertArrayToString($PartnersEducationalLevel, 'iEducation_Level_ID');
        $PartenersEduFieldArray = CommonHelper::convertArrayToString($PartnersEducationField, 'iEducation_Field_ID');
        $PartenersWorkingAsArray = CommonHelper::convertArrayToString($PartnerWorkingAS, 'iWorking_As_ID');
        $PartenersWorkingWithArray = CommonHelper::convertArrayToString($PartnerWorkingWith, 'iWorking_With_ID');
        $myModel = [
            //'model' => $model,
            'PartenersEduLevelArray' => $PartenersEduLevelArray,
            'PartenersEduFieldArray' => $PartenersEduFieldArray,
            'PartenersWorkingAsArray' => $PartenersWorkingAsArray,
            'PartenersWorkingWithArray' => $PartenersWorkingWithArray,
            'UPP' => $UPP,
            'AI' => $AI,
            'show' => $show
        ];
        return $this->renderAjax('_profession', $myModel);
    }

    public function actionEditPreferencesHobby()
    {
        $Id = Yii::$app->user->identity->id;
        $PartnersInterest = PartnersInterest::findAllByUserId($Id) == NULL ? new PartnersInterest() : PartnersInterest::findAllByUserId($Id);
        $PartnersReads = PartnersFavouriteReads::findAllByUserId($Id) == NULL ? new PartnersFavouriteReads() : PartnersFavouriteReads::findAllByUserId($Id);
        $PartnersMusic = PartnersFavouriteMusic::findAllByUserId($Id) == NULL ? new PartnersFavouriteMusic() : PartnersFavouriteMusic::findAllByUserId($Id);
        $PartnersCousins = PartnersFavouriteCousines::findAllByUserId($Id) == NULL ? new PartnersFavouriteCousines() : PartnersFavouriteCousines::findAllByUserId($Id);
        $PartnersFitnessActivity = PartnersFitnessActivities::findAllByUserId($Id) == NULL ? new PartnersFitnessActivities() : PartnersFitnessActivities::findAllByUserId($Id);
        $PartnersDressStyle = PartnersPreferredDressType::findAllByUserId($Id) == NULL ? new PartnersPreferredDressType() : PartnersPreferredDressType::findAllByUserId($Id);
        $PartnersMovies = PartnersPreferredMovies::findAllByUserId($Id) == NULL ? new PartnersPreferredMovies() : PartnersPreferredMovies::findAllByUserId($Id);

        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if (Yii::$app->request->post('save')) {
                $show = false;
                $InterestIDs = Yii::$app->request->post('PartnersInterest')['interest_id'];
                PartnersInterest::deleteAll(['user_id' => $Id]);
                if (count($InterestIDs)) {
                    foreach ($InterestIDs as $RK => $RV) {
                        $PInterestObj = new PartnersInterest();
                        $PInterestObj->user_id = $Id;
                        $PInterestObj->interest_id = $RV;
                        $STK = $PInterestObj->save();
                    }
                }
                $PartnersInterest = PartnersInterest::findAllByUserId($Id);

                $ReadsIDs = Yii::$app->request->post('PartnersFavouriteReads')['read_id'];
                PartnersFavouriteReads::deleteAll(['user_id' => $Id]);
                if (count($ReadsIDs)) {
                    foreach ($ReadsIDs as $RK => $RV) {
                        $PReadsObj = new PartnersFavouriteReads();
                        $PReadsObj->user_id = $Id;
                        $PReadsObj->read_id = $RV;
                        $STK = $PReadsObj->save();
                    }
                }
                $PartnersReads = PartnersFavouriteReads::findAllByUserId($Id);

                $MusicIDs = Yii::$app->request->post('PartnersFavouriteMusic')['music_name_id'];
                PartnersFavouriteMusic::deleteAll(['user_id' => $Id]);
                if (count($MusicIDs)) {
                    foreach ($MusicIDs as $RK => $RV) {
                        $PMusicObj = new PartnersFavouriteMusic();
                        $PMusicObj->user_id = $Id;
                        $PMusicObj->music_name_id = $RV;
                        $STK = $PMusicObj->save();
                    }
                }
                $PartnersMusic = PartnersFavouriteMusic::findAllByUserId($Id);

                $CousinsIDs = Yii::$app->request->post('PartnersFavouriteCousines')['cousines_id'];
                PartnersFavouriteCousines::deleteAll(['user_id' => $Id]);
                if (count($CousinsIDs)) {
                    foreach ($CousinsIDs as $RK => $RV) {
                        $PCousinsObj = new PartnersFavouriteCousines();
                        $PCousinsObj->user_id = $Id;
                        $PCousinsObj->cousines_id = $RV;
                        $STK = $PCousinsObj->save();
                    }
                }
                $PartnersCousins = PartnersFavouriteCousines::findAllByUserId($Id);

                $FitnessIDs = Yii::$app->request->post('PartnersFitnessActivities')['fitness_id'];
                PartnersFitnessActivities::deleteAll(['user_id' => $Id]);
                if (count($FitnessIDs)) {
                    foreach ($FitnessIDs as $RK => $RV) {
                        $PFitnessObj = new PartnersFitnessActivities();
                        $PFitnessObj->user_id = $Id;
                        $PFitnessObj->fitness_id = $RV;
                        $STK = $PFitnessObj->save();
                    }
                }
                $PartnersFitnessActivity = PartnersFitnessActivities::findAllByUserId($Id);

                $DressStyleIDs = Yii::$app->request->post('PartnersPreferredDressType')['dress_style_id'];
                PartnersPreferredDressType::deleteAll(['user_id' => $Id]);
                if (count($DressStyleIDs)) {
                    foreach ($DressStyleIDs as $RK => $RV) {
                        $PDressStyleObj = new PartnersPreferredDressType();
                        $PDressStyleObj->user_id = $Id;
                        $PDressStyleObj->dress_style_id = $RV;
                        $STK = $PDressStyleObj->save();
                    }
                }
                $PartnersDressStyle = PartnersPreferredDressType::findAllByUserId($Id);

                $MoviesIDs = Yii::$app->request->post('PartnersPreferredMovies')['movie_id'];
                PartnersPreferredMovies::deleteAll(['user_id' => $Id]);
                if (count($MoviesIDs)) {
                    foreach ($MoviesIDs as $RK => $RV) {
                        $PMoviesObj = new PartnersPreferredMovies();
                        $PMoviesObj->user_id = $Id;
                        $PMoviesObj->movie_id = $RV;
                        $STK = $PMoviesObj->save();
                    }
                }
                $PartnersMovies = PartnersPreferredMovies::findAllByUserId($Id);

            }
        }
        $PartenersInterestArray = CommonHelper::convertArrayToString($PartnersInterest, 'interest_id');
        $PartenersFavReadsArray = CommonHelper::convertArrayToString($PartnersReads, 'read_id');
        $PartenersMusicArray = CommonHelper::convertArrayToString($PartnersMusic, 'music_name_id');
        $PartenersCousinsArray = CommonHelper::convertArrayToString($PartnersCousins, 'cousines_id');
        $PartenersFitnessArray = CommonHelper::convertArrayToString($PartnersFitnessActivity, 'fitness_id');
        $PartenersDressStyleArray = CommonHelper::convertArrayToString($PartnersDressStyle, 'dress_style_id');
        $PartenersMoviesArray = CommonHelper::convertArrayToString($PartnersMovies, 'movie_id');
        $myModel = [
            'PartenersInterestArray' => $PartenersInterestArray,
            'PartenersFavReadsArray' => $PartenersFavReadsArray,
            'PartenersMusicArray' => $PartenersMusicArray,
            'PartenersCousinsArray' => $PartenersCousinsArray,
            'PartenersFitnessArray' => $PartenersFitnessArray,
            'PartenersDressStyleArray' => $PartenersDressStyleArray,
            'PartenersMoviesArray' => $PartenersMoviesArray,
            'show' => $show
        ];
        return $this->renderAjax('_hobby_partners', $myModel);
    }

    public function actionEditPreferencesFamily()
    {
        $Id = Yii::$app->user->identity->id;
        $PartnersFamilyALevel = PartnersFamilyAffluenceLevel::findAllByUserId($Id) == NULL ? new PartnersFamilyAffluenceLevel() : PartnersFamilyAffluenceLevel::findAllByUserId($Id);
        $PartnersFamilyTypeS = PartnersFamilyType::findAllByUserId($Id) == NULL ? new PartnersFamilyType() : PartnersFamilyType::findAllByUserId($Id);

        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if (Yii::$app->request->post('save')) {
                $show = false;
                $FamilyALevelIDs = Yii::$app->request->post('PartnersFamilyAffluenceLevel')['family_affluence_level_id'];
                PartnersFamilyAffluenceLevel::deleteAll(['user_id' => $Id]);
                if (count($FamilyALevelIDs)) {
                    foreach ($FamilyALevelIDs as $RK => $RV) {
                        $PFamilyLevelObj = new PartnersFamilyAffluenceLevel();
                        $PFamilyLevelObj->user_id = $Id;
                        $PFamilyLevelObj->family_affluence_level_id = $RV;
                        $STK = $PFamilyLevelObj->save();

                    }
                }
                $PartnersFamilyALevel = PartnersFamilyAffluenceLevel::findAllByUserId($Id);

                $FamilyTypeIDs = Yii::$app->request->post('PartnersFamilyType')['family_type'];
                PartnersFamilyType::deleteAll(['user_id' => $Id]);
                if (count($FamilyTypeIDs)) {
                    foreach ($FamilyTypeIDs as $RK => $RV) {
                        $PartnersFamilyTypeS = new PartnersFamilyType();
                        $PartnersFamilyTypeS->user_id = $Id;
                        $PartnersFamilyTypeS->family_type = $RV;
                        $STK = $PartnersFamilyTypeS->save();
                    }
                }
                $PartnersFamilyTypeS = PartnersFamilyType::findAllByUserId($Id);
            }
        }
        $PartnersFamilyALevel = CommonHelper::convertArrayToString($PartnersFamilyALevel, 'family_affluence_level_id');
        $PartnersFamilyTypeS = CommonHelper::convertArrayToString($PartnersFamilyTypeS, 'family_type');
        $myModel = [
            'PartnersFamilyALevel' => $PartnersFamilyALevel,
            'PartnersFamilyTypeS' => $PartnersFamilyTypeS,
            'show' => $show
        ];
        return $this->renderAjax('_family_partners', $myModel);
    }

    public function actionEditPreferencesLocation()
    {
        $Id = Yii::$app->user->identity->id;
        $PartnersCountries = PartnersCountries::findAllByUserId($Id) == NULL ? new PartnersCountries() : PartnersCountries::findAllByUserId($Id);
        $PartnersStates = PartnersStates::findAllByUserId($Id) == NULL ? new PartnersStates() : PartnersStates::findAllByUserId($Id);
        $PartnersCities = PartnersCities::findAllByUserId($Id) == NULL ? new PartnersCities() : PartnersCities::findAllByUserId($Id);
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if (Yii::$app->request->post('save')) {
                $show = false;
                $CurrDate = CommonHelper::getTime();

                $CountryIDs = Yii::$app->request->post('PartnersCountries')['country_id'];
                PartnersCountries::deleteAll(['user_id' => $Id]);
                if (count($CountryIDs)) {
                    foreach ($CountryIDs as $RK => $RV) {
                        $PartnersCountries = new PartnersCountries();
                        $PartnersCountries->scenario = PartnersCountries::SCENARIO_ADD;
                        $PartnersCountries->user_id = $Id;
                        $PartnersCountries->country_id = $RV;
                        $STK = $PartnersCountries->save();
                    }
                }
                $PartnersCountries = PartnersCountries::findAllByUserId($Id);

                $StateIDs = Yii::$app->request->post('PartnersStates')['state_id'];
                PartnersStates::deleteAll(['user_id' => $Id]);
                if (count($StateIDs)) {
                    foreach ($StateIDs as $RK => $RV) {
                        $PartnersStates = new PartnersStates();
                        $PartnersStates->scenario = PartnersStates::SCENARIO_ADD;
                        $PartnersStates->user_id = $Id;
                        $PartnersStates->state_id = $RV;
                        $STK = $PartnersStates->save();
                    }
                }
                $PartnersStates = PartnersStates::findAllByUserId($Id);

                $CitiesIDs = Yii::$app->request->post('PartnersCities')['city_id'];
                PartnersCities::deleteAll(['user_id' => $Id]);
                if (count($CitiesIDs)) {
                    foreach ($CitiesIDs as $RK => $RV) {
                        $PartnersCities = new PartnersCities();
                        $PartnersCities->scenario = PartnersCities::SCENARIO_ADD;
                        $PartnersCities->user_id = $Id;
                        $PartnersCities->city_id = $RV;
                        $STK = $PartnersCities->save();
                    }
                }
                $PartnersCities = PartnersCities::findAllByUserId($Id);
            }
        }
        $PartnersCountries = CommonHelper::convertArrayToString($PartnersCountries, 'country_id');
        $PartnersStates = CommonHelper::convertArrayToString($PartnersStates, 'state_id');
        $PartnersCities = CommonHelper::convertArrayToString($PartnersCities, 'city_id');
        #$CountryIDs = CommonHelper::removeComma(implode(",", $PartnersCountries));
        #$StatesIDs = CommonHelper::removeComma(implode(",", $PartnersStates));
        #CommonHelper::pr($PartnersCountries);
        $myModel = [
            'PartnersStates' => $PartnersStates,
            'PartnersCountries' => $PartnersCountries,
            'PartnersCities' => $PartnersCities,
            'CountryIDs' => $CountryIDs,
            'StatesIDs' => $StatesIDs,
            'show' => $show
        ];
        return $this->renderAjax('_location', $myModel);
    }

    public function actionEditPreferencesLocation1()
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
                $CurrDate = CommonHelper::getTime();
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
                $UPP->scenario = UserPartnerPreference::SCENARIO_PREFERENCE;
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

    public function actionEditContactDetail()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_CONTACT_DETAILS;
        $show = false;
        $popup = false;
        $EmailArray = array();
        $EMailFlag = $PhoneFlag = 0;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if (Yii::$app->request->post('save')) {
                #CommonHelper::pr(Yii::$app->request->post());
                $OldEmailId = $model->email;
                $NewEmailID = Yii::$app->request->post('User')['email'];
                $model->email = $NewEmailID;

                #Phone Start
                $OldNumber = $model->new_county_code . $model->new_phone_no;
                $OldCountryCode = $model->county_code;
                $OldMobileNo = $model->Mobile;
                $NewCountryCode = Yii::$app->request->post('User')['county_code'];
                $NewPhoneNumber = Yii::$app->request->post('User')['Mobile'];
                $NewNumber = $NewCountryCode . $NewPhoneNumber;
                $model->county_code = $NewCountryCode;
                $model->Mobile = $NewPhoneNumber;
                #Phone END
                if ($model->validate()) {
                    $show = false;
                    if ($OldEmailId != $NewEmailID) {
                        $TimeOut = CommonHelper::getDateTimeToString(CommonHelper::getTime());
                        $PIN_P = CommonHelper::generateNumericUniqueToken(4);
                        $model->pin_email_vaerification = $PIN_P;
                        $model->completed_step = CommonHelper::unsetStep($model->completed_step, 9);
                        $model->eEmailVerifiedStatus = 'No';
                        $model->pin_email_time = $TimeOut;
                        $EMailFlag = 1;
                        /*if ($model->save()) {
                            $MAIL_DATA = array("EMAIL" => $NewEmailID, "EMAIL_TO" => $NewEmailID, "NAME" => $model->First_Name . " " . $model->Last_Name, "PIN" => $PIN_P, "MINUTES" => Yii::$app->params['timePinValidate']);
                            $MAIL_STATUS = MailHelper::SendMail('EMAIL_VERIFICATION_PIN', $MAIL_DATA);
                            $show = false;
                            $EmailArray['Status']='S';
                            $EmailArray['popup']='1'; // Yes
                        }*/
                    }
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
                        $PhoneFlag = 1;
                        /*if ($model->save()) {
                            $SMSArray = array("OTP" => $PIN_P);
                            $SMSFlag = SmsHelper::SendSMS($NewPhoneNumber, 'PHONE_OTP', $SMSArray);
                            #$SMSFlag = SmsHelper::SendSMS($PIN_P, $NewPhoneNumber);
                            $flag = true;
                            $show = false;
                        }*/
                    }
                    if ($model->save()) {
                        if ($EMailFlag) {
                            $MAIL_DATA = array("EMAIL" => $NewEmailID, "EMAIL_TO" => $NewEmailID, "NAME" => $model->First_Name . " " . $model->Last_Name, "PIN" => $PIN_P, "MINUTES" => Yii::$app->params['timePinValidate']);
                            $MAIL_STATUS = MailHelper::SendMail('EMAIL_VERIFICATION_PIN', $MAIL_DATA);
                            $show = false;
                            $EmailArray['Status'] = 'S';
                            $EmailArray['popup'] = '1'; // Yes
                        }
                        if ($PhoneFlag) {
                            $SMSArray = array("OTP" => $PIN_P);
                            $SMSFlag = SmsHelper::SendSMS($NewPhoneNumber, 'PHONE_OTP', $SMSArray);
                            $show = false;
                        }
                    }
                }
            }
        }
        $TModel = array('model' => $model, 'EmailArray' => $EmailArray);
        return $this->actionRenderAjax($TModel, '_contact_detail', $show);
    }

    public function actionEditPermanentAddress()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_PERMANENT_ADDRESS;
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if (Yii::$app->request->post('save')) {
                $model->iCountryId = Yii::$app->request->post('User')['iCountryId'];
                $model->iStateId = Yii::$app->request->post('User')['iStateId'];
                $model->iCityId = Yii::$app->request->post('User')['iCityId'];
                $model->iDistrictID = Yii::$app->request->post('User')['iDistrictID'];
                $model->iTalukaID = Yii::$app->request->post('User')['iTalukaID'];
                $model->vAreaName = Yii::$app->request->post('User')['vAreaName'];

                $CityName = $model->cityName->vCityName;
                $StateName = $model->stateName->vStateName;
                $CountryName = $model->countryName->vCountryName;
                $Address = $model->vAreaName . " " . $CityName . " " . $StateName . " " . $CountryName;
                $LatLongArray = CommonHelper::getLatLong($Address);
                $model->latitude = $LatLongArray['latitude'];
                $model->longitude = $LatLongArray['longitude'];

                if ($model->validate()) {
                    $model->completed_step = $model->setCompletedStep('2');
                    $model->save();
                    $show = false;
                }
            }
        }
        return $this->actionRenderAjax($model, '_permanent_address', $show);
    }

    public function actionEditCurrentAddress()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_CURRENT_ADDRESS;
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if (Yii::$app->request->post('save')) {
                $model->iCountryCAId = Yii::$app->request->post('User')['iCountryCAId'];
                $model->iStateCAId = Yii::$app->request->post('User')['iStateCAId'];
                $model->iCityCAId = Yii::$app->request->post('User')['iCityCAId'];
                $model->iDistrictCAID = Yii::$app->request->post('User')['iDistrictCAID'];
                $model->iTalukaCAID = Yii::$app->request->post('User')['iTalukaCAID'];
                $model->vAreaNameCA = Yii::$app->request->post('User')['vAreaNameCA'];

                /*$CityName = $model->cityNameCA->vCityName;
                $StateName = $model->stateNameCA->vStateName;
                $CountryName = $model->countryNameCA->vCountryName;
                $Address = $model->vAreaNameCA . " " . $CityName . " " . $StateName . " " . $CountryName;
                $LatLongArray = CommonHelper::getLatLong($Address);
                $model->latitude = $LatLongArray['latitude'];
                $model->longitude = $LatLongArray['longitude'];*/

                if ($model->validate()) {
                    $model->completed_step = $model->setCompletedStep('2');
                    $model->save();
                    $show = false;
                }
            }
        }
        return $this->actionRenderAjax($model, '_current_address', $show);
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
        $temp['MultipleProfile'] = 0;
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

                        #START For Multiple Profile Check
                        $NewNumber = $model->new_county_code . $model->new_phone_no;
                        $MultiplePhones = User::checkMultiplePhoneNumber($id, $model->new_county_code, $model->new_phone_no);
                        #CommonHelper::pr($MultiplePhones);
                        if (count($MultiplePhones) > 0) {
                            $model->alternative_county_code = $model->new_county_code;
                            $model->Mobile_Alternative_No = $model->new_phone_no;
                            $model->Mobile_Multiple_Status = 1;
                            $temp['MultipleProfile'] = 1;
                        } else {
                            $model->county_code = $model->new_county_code;
                            $model->Mobile = $model->new_phone_no;
                            $model->Mobile_Multiple_Status = 0;
                            $temp['MultipleProfile'] = 0;
                        }
                        #END For Multiple Profile Check
                        $model->completed_step = $model->setCompletedStep('8');
                        $model->ePhoneVerifiedStatus = 'Yes';
                        $model->pin_phone_vaerification = 0;
                        $model->pin_phone_time = 0;
                        $model->save();
                        # var_dump($model->save());
                        $model->phone_pin = '';
                        /*$model->completed_step = $model->setCompletedStep('8');
                        $model->ePhoneVerifiedStatus = 'Yes';
                        $model->pin_phone_vaerification = 0;
                        $model->pin_phone_time = 0;
                        $model->county_code = $model->new_county_code;
                        $model->Mobile = $model->new_phone_no;

                        $model->save();
                        $model->phone_pin = '';*/
                        $show = false;
                    } else {
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
        list($temp['StartTime'], $temp['RemainingTime']) = CommonHelper::getTimeDifference($model->pin_phone_time);
        return $this->actionRenderAjax($model, '_verificationphone', $show, $popup, $flag, $temp);
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
            //$OldNumber = $model->new_county_code . $model->new_phone_no;
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

                $model->county_code = Yii::$app->request->post('User')['county_code'];
                $model->Mobile = Yii::$app->request->post('User')['Mobile'];
                $popup = false;
                $show = false;
                $flag = false;
            }
        } else {
            if ($model->ePhoneVerifiedStatus == 'No') {
                $model->county_code = $model->new_county_code;
                $model->Mobile = $model->new_phone_no;
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
                if ($Status != '') {
                    list($temp['StartTime'], $temp['RemainingTime']) = CommonHelper::getTimeDifference($model->pin_phone_time);
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
            $PartenersReligion = PartenersReligion::findAllByUserId($ToUserId) == NULL ? new PartenersReligion() : PartenersReligion::findAllByUserId($ToUserId);
            $PartnersMaritalStatus = PartnersMaritalStatus::findAllByUserId($ToUserId) == NULL ? new PartnersMaritalStatus() : PartnersMaritalStatus::findAllByUserId($ToUserId);
            $PartnersGotra = PartnersGotra::findAllByUserId($ToUserId) == NULL ? new PartnersGotra() : PartnersGotra::findAllByUserId($ToUserId);
            $PartnersCommunity = PartnersCommunity::findAllByUserId($ToUserId) == NULL ? new PartnersCommunity() : PartnersCommunity::findAllByUserId($ToUserId);
            $PartnersSubCommunity = PartnersSubcommunity::findAllByUserId($ToUserId) == NULL ? new PartnersSubcommunity() : PartnersSubcommunity::findAllByUserId($ToUserId);

            $UPP = UserPartnerPreference::findByUserId($ToUserId) == NULL ? new UserPartnerPreference() : UserPartnerPreference::findByUserId($ToUserId);
            $PartnersFathersStatus = PartnersFathersStatus::findByUserId($ToUserId) == NULL ? new PartnersFathersStatus() : PartnersFathersStatus::findByUserId($ToUserId);
            $PartnersMothersStatus = PartnersMothersStatus::findByUserId($ToUserId) == NULL ? new PartnersMothersStatus() : PartnersMothersStatus::findByUserId($ToUserId);

            $PartnersMothertongue = PartnersMothertongue::findByUserId($ToUserId) == NULL ? new PartnersMothertongue() : PartnersMothertongue::findByUserId($ToUserId);
            $PartnersRaashi = PartnersRaashi::findByUserId($ToUserId) == NULL ? new PartnersRaashi() : PartnersRaashi::findByUserId($ToUserId);
            $PartnersCharan = PartnersCharan::findByUserId($ToUserId) == NULL ? new PartnersCharan() : PartnersCharan::findByUserId($ToUserId);
            $PartnersNakshtra = PartnersNakshtra::findByUserId($ToUserId) == NULL ? new PartnersNakshtra() : PartnersNakshtra::findByUserId($ToUserId);
            $PartnersNadi = PartnersNadi::findByUserId($ToUserId) == NULL ? new PartnersNadi() : PartnersNadi::findByUserId($ToUserId);


            $PartnersSkinTone = PartnersSkinTone::findAllByUserId($ToUserId) == NULL ? new PartnersSkinTone() : PartnersSkinTone::findAllByUserId($ToUserId);
            $PartnersBodyType = PartnersBodyType::findAllByUserId($ToUserId) == NULL ? new PartnersBodyType() : PartnersBodyType::findAllByUserId($ToUserId);
            $PartnersDiet = PartnersDiet::findAllByUserId($ToUserId) == NULL ? new PartnersDiet() : PartnersDiet::findAllByUserId($ToUserId);
            $PartnersSpectacles = PartnersSpectacles::findAllByUserId($ToUserId) == NULL ? new PartnersSpectacles() : PartnersSpectacles::findAllByUserId($ToUserId);
            $PartnersSmoke = PartnersSmoke::findAllByUserId($ToUserId) == NULL ? new PartnersSmoke() : PartnersSmoke::findAllByUserId($ToUserId);
            $PartnersDrink = PartnersDrink::findAllByUserId($ToUserId) == NULL ? new PartnersDrink() : PartnersDrink::findAllByUserId($ToUserId);

            $PartnersEducationalLevel = PartnersEducationalLevel::findAllByUserId($ToUserId) == NULL ? new PartnersEducationalLevel() : PartnersEducationalLevel::findAllByUserId($ToUserId);
            $PartnersEducationField = PartnersEducationField::findAllByUserId($ToUserId) == NULL ? new PartnersEducationField() : PartnersEducationField::findAllByUserId($ToUserId);
            $PartnerWorkingAS = PartnerWorkingAs::findAllByUserId($ToUserId) == NULL ? new PartnerWorkingAs() : PartnerWorkingAs::findAllByUserId($ToUserId);
            $PartnerWorkingWith = PartnerWorkingWith::findAllByUserId($ToUserId) == NULL ? new PartnerWorkingWith() : PartnerWorkingWith::findAllByUserId($ToUserId);

            $PartnersCountries = PartnersCountries::findAllByUserId($ToUserId) == NULL ? new PartnersCountries() : PartnersCountries::findAllByUserId($ToUserId);
            $PartnersStates = PartnersStates::findAllByUserId($ToUserId) == NULL ? new PartnersStates() : PartnersStates::findAllByUserId($ToUserId);
            $PartnersCities = PartnersCities::findAllByUserId($ToUserId) == NULL ? new PartnersCities() : PartnersCities::findAllByUserId($ToUserId);

            $PartnersFamilyALevel = PartnersFamilyAffluenceLevel::findAllByUserId($ToUserId) == NULL ? new PartnersFamilyAffluenceLevel() : PartnersFamilyAffluenceLevel::findAllByUserId($ToUserId);
            $PartnersFamilyTypeS = PartnersFamilyType::findAllByUserId($ToUserId) == NULL ? new PartnersFamilyType() : PartnersFamilyType::findAllByUserId($ToUserId);


            $PartnersInterest = PartnersInterest::findAllByUserId($ToUserId) == NULL ? new PartnersInterest() : PartnersInterest::findAllByUserId($ToUserId);
            $PartnersReads = PartnersFavouriteReads::findAllByUserId($ToUserId) == NULL ? new PartnersFavouriteReads() : PartnersFavouriteReads::findAllByUserId($ToUserId);
            $PartnersMusic = PartnersFavouriteMusic::findAllByUserId($ToUserId) == NULL ? new PartnersFavouriteMusic() : PartnersFavouriteMusic::findAllByUserId($ToUserId);
            $PartnersCousins = PartnersFavouriteCousines::findAllByUserId($ToUserId) == NULL ? new PartnersFavouriteCousines() : PartnersFavouriteCousines::findAllByUserId($ToUserId);
            $PartnersFitnessActivity = PartnersFitnessActivities::findAllByUserId($ToUserId) == NULL ? new PartnersFitnessActivities() : PartnersFitnessActivities::findAllByUserId($ToUserId);
            $PartnersDressStyle = PartnersPreferredDressType::findAllByUserId($ToUserId) == NULL ? new PartnersPreferredDressType() : PartnersPreferredDressType::findAllByUserId($ToUserId);
            $PartnersMovies = PartnersPreferredMovies::findAllByUserId($ToUserId) == NULL ? new PartnersPreferredMovies() : PartnersPreferredMovies::findAllByUserId($ToUserId);


        } else if ($ToUserId == $id) {
            $Title = Yii::$app->params['accessDenied'];
            $Message = Yii::$app->params['accessDeniedYourProfile'];
        } else {
            $Title = Yii::$app->params['accessDenied'];
            $Message = Yii::$app->params['accessDeniedInvalid'];
        }
        $Gender = (Yii::$app->user->identity->Gender == 'MALE') ? 'FEMALE' : 'MALE';
        list($SimilarProfile, $SuccessStories) = $this->actionRightSideBar($Gender, $id, 3);

        $PartenersReligionIDs = CommonHelper::convertArrayToString($PartenersReligion, 'iReligion_ID');
        $PartnersMaritalPreferences = CommonHelper::convertArrayToString($PartnersMaritalStatus, 'iMarital_Status_ID');
        $PartnersGotraPreferences = CommonHelper::convertArrayToString($PartnersGotra, 'iGotra_ID');
        $PartnersSkinTone = CommonHelper::convertArrayToString($PartnersSkinTone, 'iSkin_Tone_ID');
        $PartnersBodyType = CommonHelper::convertArrayToString($PartnersBodyType, 'iBody_Type_ID');
        $PartnersDiet = CommonHelper::convertArrayToString($PartnersDiet, 'diet_id');
        $PartnersSpectacles = CommonHelper::convertArrayToString($PartnersSpectacles, 'type');
        $PartnersSmoke = CommonHelper::convertArrayToString($PartnersSmoke, 'smoke_type');
        $PartnersDrink = CommonHelper::convertArrayToString($PartnersDrink, 'drink_type');
        $PartnersCommunity = CommonHelper::convertArrayToString($PartnersCommunity, 'iCommunity_ID');
        $PartnersSubCommunity = CommonHelper::convertArrayToString($PartnersSubCommunity, 'iSub_Community_ID');

        $PartenersEduLevelArray = CommonHelper::convertArrayToString($PartnersEducationalLevel, 'iEducation_Level_ID');
        $PartenersEduFieldArray = CommonHelper::convertArrayToString($PartnersEducationField, 'iEducation_Field_ID');
        $PartenersWorkingAsArray = CommonHelper::convertArrayToString($PartnerWorkingAS, 'iWorking_As_ID');
        $PartenersWorkingWithArray = CommonHelper::convertArrayToString($PartnerWorkingWith, 'iWorking_With_ID');

        $PartnersCountries = CommonHelper::convertArrayToString($PartnersCountries, 'country_id');
        $PartnersStates = CommonHelper::convertArrayToString($PartnersStates, 'state_id');
        $PartnersCities = CommonHelper::convertArrayToString($PartnersCities, 'city_id');

        $PartnersFamilyALevel = CommonHelper::convertArrayToString($PartnersFamilyALevel, 'family_affluence_level_id');
        $PartnersFamilyTypeS = CommonHelper::convertArrayToString($PartnersFamilyTypeS, 'family_type');

        $PartenersInterestArray = CommonHelper::convertArrayToString($PartnersInterest, 'interest_id');
        $PartenersFavReadsArray = CommonHelper::convertArrayToString($PartnersReads, 'read_id');
        $PartenersMusicArray = CommonHelper::convertArrayToString($PartnersMusic, 'music_name_id');
        $PartenersCousinsArray = CommonHelper::convertArrayToString($PartnersCousins, 'cousines_id');
        $PartenersFitnessArray = CommonHelper::convertArrayToString($PartnersFitnessActivity, 'fitness_id');
        $PartenersDressStyleArray = CommonHelper::convertArrayToString($PartnersDressStyle, 'dress_style_id');
        $PartenersMoviesArray = CommonHelper::convertArrayToString($PartnersMovies, 'movie_id');

        return $this->render('profile', [
            'model' => $model,
            'MatchCompatibility' => $MatchCompatibility,
            'PhotoList' => $PhotoList,
            'flag' => $flag,
            'Message' => $Message,
            'Title' => $Title,
            'PartenersReligion' => $PartenersReligion,
            'PartenersReligionIDs' => $PartenersReligionIDs,
            'UPP' => $UPP,
            'PartnersFathersStatus' => $PartnersFathersStatus,
            'PartnersMothersStatus' => $PartnersMothersStatus,
            'PartnersEducationalLevel' => $PartnersEducationalLevel,
            'PartnersEducationField' => $PartnersEducationField,
            'SimilarProfile' => $SimilarProfile,

            'PartnersMaritalPreferences' => $PartnersMaritalPreferences,
            'PartnersGotraPreferences' => $PartnersGotraPreferences,
            'PartnersMaritalStatus' => $PartnersMaritalStatus,
            'PartnersGotra' => $PartnersGotra,
            'PartnersCommunity' => $PartnersCommunity,
            'PartnersSubCommunity' => $PartnersSubCommunity,

            'PartnersRaashi' => $PartnersRaashi,
            'PartnersCharan' => $PartnersCharan,
            'PartnersNakshtra' => $PartnersNakshtra,
            'PartnersNadi' => $PartnersNadi,

            'PartnersSkinTone' => $PartnersSkinTone,
            'PartnersBodyType' => $PartnersBodyType,
            'PartnersDiet' => $PartnersDiet,
            'PartnersSpectacles' => $PartnersSpectacles,
            'PartnersSmoke' => $PartnersSmoke,
            'PartnersDrink' => $PartnersDrink,

            'PartnersMothertongue' => $PartnersMothertongue,

            'PartenersEduLevelArray' => $PartenersEduLevelArray,
            'PartenersEduFieldArray' => $PartenersEduFieldArray,
            'PartenersWorkingAsArray' => $PartenersWorkingAsArray,
            'PartenersWorkingWithArray' => $PartenersWorkingWithArray,

            'PartnersStates' => $PartnersStates,
            'PartnersCountries' => $PartnersCountries,
            'PartnersCities' => $PartnersCities,

            'PartnersFamilyALevel' => $PartnersFamilyALevel,
            'PartnersFamilyTypeS' => $PartnersFamilyTypeS,

            'PartenersInterestArray' => $PartenersInterestArray,
            'PartenersFavReadsArray' => $PartenersFavReadsArray,
            'PartenersMusicArray' => $PartenersMusicArray,
            'PartenersCousinsArray' => $PartenersCousinsArray,
            'PartenersFitnessArray' => $PartenersFitnessArray,
            'PartenersDressStyleArray' => $PartenersDressStyleArray,
            'PartenersMoviesArray' => $PartenersMoviesArray,
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
            'PhotoSetType' => Yii::$app->request->post('PhotoSetType'),
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
        #$id = Yii::$app->user->identity->id-;
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

    public function actionProfilePhotoRemove()
    {
        $Id = Yii::$app->user->identity->id;
        $UserModel = User::findOne($Id);
        $ProPic = $UserModel->propic;
        if ($ProPic != '') {
            $UserPhotoSizeArray = Yii::$app->params['sizeUserPhoto'];
            $ProfilePhotoPath = CommonHelper::getUserUploadFolder(3, $Id);
            $DeletePhotoFromFolder = 1;
            #list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PROFILE_PHOTO_DELETE');
            foreach ($UserPhotoSizeArray as $SizeKey => $SizeValue) {
                if (!unlink($ProfilePhotoPath . $SizeValue . $ProPic)) {
                    $DeletePhotoFromFolder = 0;
                }
            }
            if ($DeletePhotoFromFolder) {
                $UserModel->propic = '';
                if ($UserModel->save()) {
                    $PG = new UserPhotos();
                    $PG->updateIsProfilePhoto($Id);
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PROFILE_PHOTO_DELETE');
                } else {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PROFILE_PHOTO_DELETE');
                }
            } else {
                $DeletePhotoFromFolder = 0;
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PROFILE_PHOTO_DELETE');
            }
        } else {
            $DeletePhotoFromFolder = 0;
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('W', 'PROFILE_PHOTO_DELETE');
        }
        $ProfilePhoto = CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, "200" . '', 200, '', 'Yes');
        $ProfilePhotoThumb = CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, "30" . '', 200, '', 'Yes');
        $return = array('DeletePhototStatus' => $DeletePhotoFromFolder, 'STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'ProfilePhoto' => $ProfilePhoto, 'ProfilePhotoThumb' => $ProfilePhotoThumb);
        return json_encode($return);

    }

    public function actionSetting()
    { #Setting : Privacy Option.
        $Id = Yii::$app->user->identity->id;
        CommonHelper::checkVerification();
        $UserModel = User::findOne($Id);
        #$model->scenario = User::SCENARIO_EDIT_MY_INFO;
        $show = false;
        return $this->render('settings', [
            'UserModel' => $UserModel,
        ]);

    }

    public function actionSavePrivacyOption() #For Save Privacy Options.
    {
        $Id = Yii::$app->user->identity->id;
        $UserModel = User::findOne($Id);
        if (Yii::$app->request->post('ACTION') == 'PRIVACY-PHONE') {
            $UserModel->phone_privacy = Yii::$app->request->post('phone_privacy');
        } else if (Yii::$app->request->post('ACTION') == 'PRIVACY-PHOTO') {
            $UserModel->photo_privacy = Yii::$app->request->post('photo_privacy');
        } else if (Yii::$app->request->post('ACTION') == 'PRIVACY-VISITOR') {
            $UserModel->visitor_setting = Yii::$app->request->post('visitor_setting');
        }

        if ($UserModel->save()) {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PRIVACY_SETTING');
        } else {
            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PRIVACY_SETTING');
        }
        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE);
        return json_encode($return);
        exit;
    }

    public function actionMultipleProfileOption() #For Multiple Profile Options
    {
        $Id = Yii::$app->user->identity->id;
        $UserModel = User::findOne($Id);
        $RedirectURL = Yii::getAlias('@web');
        if (Yii::$app->request->post('ACTION') == 'MULTIPLE-PROFILE') {
            #CommonHelper::pr(Yii::$app->request->post());
            $MultipleProfileStatus = Yii::$app->request->post('MultipleProfileStatus');
            $UserModel->multiple_profile_status = $MultipleProfileStatus;

            if ($MultipleProfileStatus == 1) { # Keep This Profile, Delete Others
                $DeleteAllUser = User::checkMultiplePhoneNumber($Id, $UserModel->new_county_code, $UserModel->new_phone_no);
                foreach ($DeleteAllUser as $DK => $DV) {
                    #  CommonHelper::pr($DV->id);
                    $DelUserId = $DV->id;
                    $DeleteUserPhotos = UserPhotos::deleteAll(['iUser_ID' => $DelUserId]);
                    $DeleteUserRequest = UserRequestOp::deleteAll(" from_user_id = '" . $DelUserId . "' OR to_user_id = '" . $DelUserId . "'");
                    $DeleteUserMailbox = Mailbox::deleteAll(" from_user_id = '" . $DelUserId . "' OR to_user_id = '" . $DelUserId . "'");
                    $DeleteCurrentUser = User::deleteAll(['id' => $DelUserId]);
                }
                $UserModel->county_code = $UserModel->new_county_code;
                $UserModel->Mobile = $UserModel->new_phone_no;
            } else if ($MultipleProfileStatus == 2) { # Provide Alternate No. For This Profile
                #$MultipleProfileReason
                $UserModel->Mobile_Alternative_No = $UserModel->new_phone_no;
                $UserModel->alternative_county_code = $UserModel->new_county_code;
            } else if ($MultipleProfileStatus == 3) { # Will Use Old Profile, Delete This One
                #$DeleteCurrentUser = User::deleteCurrentProfile($Id);
                $DeleteCurrentUserPhotos = UserPhotos::deleteAll(['iUser_ID' => $Id]);
                $DeleteCurrentUserRequest = UserRequestOp::deleteAll(" from_user_id = '" . $Id . "' OR to_user_id = '" . $Id . "'");
                $DeleteCurrentUserMailbox = Mailbox::deleteAll(" from_user_id = '" . $Id . "' OR to_user_id = '" . $Id . "'");
                $DeleteCurrentUser = User::deleteAll(['id' => $Id]);

                $DeleteCurrentUser = User::deleteAll(['id' => $Id]);
                #return $this->redirect(Yii::getAlias('@web'));
                $RedirectURL = Yii::getAlias('@web');
                if ($DeleteCurrentUser) {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PROFILE_DELETE_CURRENT_USER');
                } else {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PROFILE_DELETE_CURRENT_USER');
                }
                $PopUpType = 0;

            } else if ($MultipleProfileStatus == 4) { # I Wish To Have Multiple Profiles
                $MultipleProfileReason = Yii::$app->request->post('MultipleProfileReason');
                $UserModel->multiple_profile_reason = $MultipleProfileReason;

                $UserModel->county_code = $UserModel->new_county_code;
                $UserModel->Mobile = $UserModel->new_phone_no;
            }
            #var_dump($UserModel->save());
            if ($MultipleProfileStatus != 3) {
                $PopUpType = 1;
                if ($UserModel->save()) {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'MULTIPLE_PROFILE');
                } else {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'MULTIPLE_PROFILE');
                }
            }

        } else {
            $STATUS = 'E';
            $MESSAGE = Yii::$app->params['errorMessage'];
        }
        if ($UserModel->eEmailVerifiedStatus == 'Yes' && $UserModel->ePhoneVerifiedStatus == 'Yes') {
            $RedirectURL = 'site/partner-preferences';
        }

        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE, 'POPUPTYPE' => $PopUpType, 'REDIRECTURL' => $RedirectURL);
        return json_encode($return);
        exit;
    }
}
