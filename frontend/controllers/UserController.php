<?php
namespace frontend\controllers;

use common\components\CommonHelper;
use common\components\MessageHelper;
use common\components\SmsHelper;
use common\models\Tags;
use common\models\UserPhotos;
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
        return $this->render('index',
            ['model' => $model]
        );
    }

    public function actionMyProfile()
    {
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $id = Yii::$app->user->identity->id;
        $model = User::find()->joinWith([countryName, stateName, cityName, height, maritalStatusName, talukaName, districtName, gotraName, subCommunityName, communityName, religionName, educationLevelName, communityName, workingWithName, workingAsName, dietName, fatherStatus])->where(['id' => $id])->one();
        $USER_PHOTO_MODEL = new  UserPhotos();
        $USER_PHOTOS_LIST = $USER_PHOTO_MODEL->findByUserId($id);
        $COVER_PHOTO = CommonHelper::getCoverPhotos($TYPE = 'USER', $id, $model->cover_photo);
        $TAG_LIST = Tags::find()->orderBy('rand()')->all();   //orderBy(['rand()' => SORT_DESC]);
        $TAG_LIST_USER = UserTag::find()->joinWith([tagName])->where(['iUser_Id' => $id])->orderBy(['Name' => SORT_ASC])->all();
        return $this->render('my-profile',
            ['model' => $model, 'photo_model' => $USER_PHOTOS_LIST, 'COVER_PHOTO' => $COVER_PHOTO, 'TAG_LIST' => $TAG_LIST, 'TAG_LIST_USER' => $TAG_LIST_USER]

        );
    }

    public function actionDashboard($type = '')
    {
        if (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->identity->id;
            if($model = User::findOne($id)){
                $model->scenario = User::SCENARIO_REGISTER6;
                $VER_ARRAY = array();
                return $this->render('dashboard',[
                    'model' => $model,
                    'VER_ARRAY' => $VER_ARRAY,
                    'type' => $type
                ]);
            }else{
                return $this->redirect(Yii::getAlias('@web'));
            }
        }else{
            return $this->redirect(Yii::getAlias('@web'));
        }
    }

    public function actionPhotos()
    {
        if (!Yii::$app->user->isGuest) {
            /*$id = Yii::$app->user->identity->id;
            $USER_PHOTO_MODEL = new UserPhotos();
            $USER_PHOTOS_LIST = $USER_PHOTO_MODEL->findByUserId($id);
            return $this->render('photos', [
                'model' => $USER_PHOTOS_LIST
            ]);*/
            $id = Yii::$app->user->identity->id;
            $USER_PHOTO_MODEL = new UserPhotos();
            $USER_PHOTOS_LIST = $USER_PHOTO_MODEL->findByUserId($id);
            if ($model = User::findOne($id)) {
                $model->scenario = User::SCENARIO_REGISTER6;
                $target_dir = Yii::getAlias('@web') . '/uploads/';
                if (Yii::$app->request->post()) {
                    if ($model->eEmailVerifiedStatus == 'No' && $model->pin_email_vaerification == '') {
                        $PIN = CommonHelper::generateNumericUniqueToken(4);
                        $model->pin_email_vaerification = $PIN;
                        $MAIL_DATA = array("EMAIL" => $model->email, "EMAIL_TO" => $model->email, "NAME" => $model->First_Name . " " . $model->Last_Name, "PIN" => $PIN);
                        MailHelper::SendMail('EMAIL_VERIFICATION_PIN', $MAIL_DATA);
                    }
                    if ($model->ePhoneVerifiedStatus == 'No' && $model->pin_phone_vaerification == 0) {
                        $PIN_P = CommonHelper::generateNumericUniqueToken(4);
                        $model->pin_phone_vaerification = $PIN_P;
                        if ($model->Mobile != 0 && strlen($model->Mobile) == 10) {
                            $SMS_FLAG = SmsHelper::SendSMS($PIN_P, $model->Mobile);
                        }
                    }
                    $model->completed_step = $model->setCompletedStep('7');
                    if ($model->save($model)) {
                        $this->redirect(['site/verification']);
                    }
                }
                if ($model->propic != '')
                    $model->propic = $target_dir . $model->propic;

                return $this->render('photos', [
                    'model' => $USER_PHOTOS_LIST,
                    'model_user' => $model
                ]);
            } else {
                return $this->redirect(Yii::getAlias('@web'));
            }
        } else {
            return $this->redirect(Yii::getAlias('@web'));
        }

    }

    public function actionPhotoupload($id)
    {
        $id = Yii::$app->user->identity->id;
        if ($model = User::findOne($id)) {
            $model->scenario = User::SCENARIO_REGISTER6;
            $FILE_COUNT = count($_FILES);
            if ($FILE_COUNT != 0) {
                for ($CTR = 0; $CTR <= $FILE_COUNT; $CTR++) {
                    $PG = new UserPhotos();
                    if ($_FILES['fileInput_' . $CTR]['name'] != '') {
                        $CM_HELPER = new CommonHelper();
                        $PATH = $CM_HELPER->getUserUploadFolder(1) . "/" . $id . "/";
                        $URL = $CM_HELPER->getUserUploadFolder(2) . "/" . $id . "/";
                        $USER_SIZE_ARRAY = $CM_HELPER->getUserResizeRatio();
                        #$OLD_PHOTO = $model->propic;
                        $PHOTO_ARRAY = CommonHelper::photoUpload($id, $_FILES['fileInput_' . $CTR], $PATH, $URL, $USER_SIZE_ARRAY, '');
                        $PG->File_Name = $PHOTO_ARRAY['PHOTO'];
                        $PG->iUser_ID = $id;
                        $PG->Is_Profile_Photo = 'NO';
                        $PG->dtCreated = CommonHelper::getTime();
                        $PG->dtModified = CommonHelper::getTime();
                        $ACTION_FLAG = $PG->save();
                        if (!$ACTION_FLAG) {
                            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PHOTO_UPLOAD');
                        } else {
                            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PHOTO_UPLOAD');
                        }
                    }
                }
                //$this->redirect(['user/photos']);
            }
            $OUTPUT_HTML = '';
            $OUTPUT_HTML_ONE = '';
            $OUTPUT_HTML .= $this->getPhotoListOutput();
            $OUTPUT_HTML_ONE .= $this->getPhotoListOutputOne();
            $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE, 'OUTPUT' => $OUTPUT_HTML, 'OUTPUT_ONE' => $OUTPUT_HTML_ONE);
            Yii::$app->response->format = Response::FORMAT_JSON;
            return $return;

        } else {
            return $this->redirect(Yii::getAlias('@web'));
        }
    }

    /**
     * @return Action
     */
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
            #$OUTPUT_HTML .= $this->getPhotoListOutput();
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
                    $PROFILE_PHOTO .= CommonHelper::getPhotos('USER', $id, $PHOTO, '200');
                    $PROFILE_PHOTO_ONE = CommonHelper::getPhotos('USER', $id, $PHOTO, '30');
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PROFILE_PHOTO_SET');
                } else {
                    list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PROFILE_PHOTO_SET');
                }
            }

        }

        $OUTPUT_HTML .= $this->getPhotoListOutput();
        $OUTPUT_HTML_ONE .= $this->getPhotoListOutputOne();
        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE, 'OUTPUT' => $OUTPUT_HTML, 'OUTPUT_ONE' => $OUTPUT_HTML_ONE, 'PROFILE_PHOTO' => $PROFILE_PHOTO, 'PROFILE_PHOTO_ONE' => $PROFILE_PHOTO_ONE);
        #Yii::$app->response->format = Response::FORMAT_JSON;
        return json_encode($return);
    }


    public function actionEditMyinfo(){
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_EDIT_MY_INFO;
        $show = false;
        $popup = false;
        if(Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if(Yii::$app->request->post('save')){
                $tYourSelf_old = $model->tYourSelf;
                $model->tYourSelf = Yii::$app->request->post('User')['tYourSelf'];
                if (strcmp($tYourSelf_old, $model->tYourSelf) !== 0) {
                    $model->eStatusInOwnWord = 'Pending';
                    $popup = true;
                }
                if($model->validate()){
                    $model->save();
                    $show = false;
                }
            }
        }
        #return $this->actionRenderAjax($model,'_myinfo',true);
        return $this->actionRenderAjax($model, '_myinfo', $show, $popup);
    }

    function actionRenderAjax($model, $view, $show = false, $popup = false, $flag = false)
    {
        return $this->renderAjax($view, [
            'model' => $model,
            'show' => $show,
            'popup' => $popup,
            'flag' => $flag,
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
                $model->county_code = Yii::$app->request->post('User')['county_code'];
                $model->Mobile = $NewMobileNo;
                $model->Gender = Yii::$app->request->post('User')['Gender'];
                $model->mother_tongue = Yii::$app->request->post('User')['mother_tongue'];
                if($model->validate()){
                    if ($NewMobileNo != $OldMobileNo) {
                        $PIN_P = CommonHelper::generateNumericUniqueToken(4);
                        $model->pin_phone_vaerification = $PIN_P;
                        $model->ePhoneVerifiedStatus = 'No';
                        $model->completed_step = CommonHelper::unsetStep($model->completed_step, 8);
                        $SMS_FLAG = SmsHelper::SendSMS($PIN_P, $model->Mobile);
                        $popup = true;
                    }
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

        if(Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if(Yii::$app->request->post('save')){
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
                if($model->validate()){
                    $model->completed_step = $model->setCompletedStep('2');
                    $model->save();
                    $show = false;
                }
            }
        }
        //var_dump($show);
        return $this->actionRenderAjax($model,'_basicinfo',$show);
    }

    public function actionEditEducation()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_REGISTER2;
        $show = false;
        if(Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if(Yii::$app->request->post('save')){
                $model->iEducationLevelID = Yii::$app->request->post('User')['iEducationLevelID'];
                $model->iEducationFieldID = Yii::$app->request->post('User')['iEducationFieldID'];
                $model->iWorkingWithID = Yii::$app->request->post('User')['iWorkingWithID'];
                $model->iWorkingAsID = Yii::$app->request->post('User')['iWorkingAsID'];
                $model->iAnnualIncomeID = Yii::$app->request->post('User')['iAnnualIncomeID'];
                if($model->validate()) {
                    $model->completed_step = $model->setCompletedStep('3');
                    $model->save();
                    $show = false;
                }
            }
        }

        if ($show) {
            return $this->actionRenderAjax($model,'_education',true);
        }
        else {
            return $this->actionRenderAjax($model,'_education',false);
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
            return $this->actionRenderAjax($model,'_lifestyle',true);
        }
        else {
            return $this->actionRenderAjax($model,'_lifestyle',false);
        }
    }

    public function actionEditFamily() {
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
                if(is_array($family_property_array)) {
                    $model->vFamilyProperty = implode(",", $family_property_array);
                }
                else {
                    $model->vFamilyProperty = '';
                }
                $model->vDetailRelative = Yii::$app->request->post('User')['vDetailRelative'];
                if($model->validate()){
                    $model->completed_step = $model->setCompletedStep('5');
                    $model->save();
                    $show = false;
                }
            }
        }

        if($show) {
            return $this->actionRenderAjax($model,'_family',true);
        }
        else {
            return $this->actionRenderAjax($model,'_family',false);
        }
    }

    public function actionEditPreferences()
    {
        $id = Yii::$app->user->identity->id;
        $PartenersReligion = PartenersReligion::findByUserId($id) == NULL ? new PartenersReligion() : PartenersReligion::findByUserId($id);
        $UPP = UserPartnerPreference::findByUserId($id) == NULL ? new UserPartnerPreference() : UserPartnerPreference::findByUserId($id);
        $PartnersMaritalStatus = PartnersMaritalStatus::findByUserId($id) == NULL ? new PartnersMaritalStatus() : PartnersMaritalStatus::findByUserId($id);
        $PartnersGotra = PartnersGotra::findByUserId($id) == NULL ? new PartnersGotra() : PartnersGotra::findByUserId($id);
        $PartnersFathersStatus = PartnersFathersStatus::findByUserId($id) == NULL ? new PartnersFathersStatus() : PartnersFathersStatus::findByUserId($id);
        $PartnersMothersStatus = PartnersMothersStatus::findByUserId($id) == NULL ? new PartnersMothersStatus() : PartnersMothersStatus::findByUserId($id);
        $PartnersEducationalLevel = PartnersEducationalLevel::findByUserId($id) == NULL ? new PartnersEducationalLevel() : PartnersEducationalLevel::findByUserId($id);
        $PartnersEducationField = PartnersEducationField::findByUserId($id) == NULL ? new PartnersEducationField() : PartnersEducationField::findByUserId($id);
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
                if($PartenersReligion->iPartners_Religion_ID == ""){
                    $PartenersReligion->dtCreated = $CurrDate;
                }
                $PartenersReligion->save();

                $UPP->iUser_id = $id;
                $UPP->age_from = Yii::$app->request->post('UserPartnerPreference')['age_from'];
                $UPP->age_to = Yii::$app->request->post('UserPartnerPreference')['age_to'];
                $UPP->modified_on = $CurrDate;

                if($UPP->ID == ""){
                    $UPP->created_on = $CurrDate;
                }
                $UPP->save();

                $MaritalStatusID = Yii::$app->request->post('PartnersMaritalStatus')['iMarital_Status_ID'];
                $PartnersMaritalStatus->iUser_ID = $id;
                $PartnersMaritalStatus->iMarital_Status_ID = $MaritalStatusID;
                $PartnersMaritalStatus->dtModified = $CurrDate;
                if($PartnersMaritalStatus->iPartners_Marital_Status_ID == ""){
                    $PartnersMaritalStatus->dtCreated = $CurrDate;
                }
                $PartnersMaritalStatus->save();

                $GotraID = Yii::$app->request->post('PartnersGotra')['iGotra_ID'];
                $PartnersGotra->iUser_ID = $id;
                $PartnersGotra->iGotra_ID = $GotraID;
                $PartnersGotra->dtModified = $CurrDate;
                if($PartnersGotra->iPartners_Gotra_ID == ""){
                    $PartnersGotra->dtCreated = $CurrDate;
                }
                $PartnersGotra->save();
                $show = false;

                $FatherStatusID = Yii::$app->request->post('PartnersFathersStatus')['iFather_Status_ID'];
                $PartnersFathersStatus->iUser_ID = $id;
                $PartnersFathersStatus->iFather_Status_ID = $FatherStatusID;
                $PartnersFathersStatus->dtModified = $CurrDate;
                if($PartnersFathersStatus->iPartners_Fathers_ID == ""){
                    $PartnersFathersStatus->dtCreated = $CurrDate;
                }
                $PartnersFathersStatus->save();

                $MotherStatusID = Yii::$app->request->post('PartnersMothersStatus')['iMother_Status_ID'];
                $PartnersMothersStatus->iUser_ID = $id;
                $PartnersMothersStatus->iMother_Status_ID = $MotherStatusID;
                $PartnersMothersStatus->dtModified = $CurrDate;
                if($PartnersMothersStatus->iPartners_Mother_ID == ""){
                    $PartnersMothersStatus->dtCreated = $CurrDate;
                }
                $PartnersMothersStatus->save();

                $EducationLevelID = Yii::$app->request->post('PartnersEducationalLevel')['iEducation_Level_ID'];
                $PartnersEducationalLevel->iUser_ID = $id;
                $PartnersEducationalLevel->iEducation_Level_ID = $EducationLevelID;
                $PartnersEducationalLevel->dtModified = $CurrDate;
                if($PartnersEducationalLevel->iPartners_Educational_Level_ID == ""){
                    $PartnersEducationalLevel->dtCreated = $CurrDate;
                }
                $PartnersEducationalLevel->save();

                $EducationFieldID = Yii::$app->request->post('PartnersEducationField')['iEducation_Field_ID'];
                $PartnersEducationField->iUser_ID = $id;
                $PartnersEducationField->iEducation_Field_ID = $EducationFieldID;
                $PartnersEducationField->dtModified = $CurrDate;
                if($PartnersEducationField->iPartners_Education_Field_ID == ""){
                    $PartnersEducationField->dtCreated = $CurrDate;
                }
                $PartnersEducationField->save();

                $show = false;

            }
        }
        $myModel = [
            'PartenersReligion' => $PartenersReligion,
            'model' => $model,
            'UPP' => $UPP,
            'PartnersMaritalStatus' => $PartnersMaritalStatus,
            'PartnersGotra' => $PartnersGotra,
            'PartnersFathersStatus' => $PartnersFathersStatus,
            'PartnersMothersStatus' => $PartnersMothersStatus,
            'PartnersEducationalLevel' => $PartnersEducationalLevel,
            'PartnersEducationField' => $PartnersEducationField,
            'show' => $show
        ];
        return $this->renderAjax('_preferences', $myModel);
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
        $STATUS = "SUCCESS";
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
                //copy($PATH.$COVER_PHOTO_1, $PATH.'cover/'.$COVER_PHOTO_1);
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
    { //tag-suggestion-list
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
        if (Yii::$app->request->post() && (Yii::$app->request->post('verify') == 'PHONE_VERIFY')) {
            $show = true;
            $PIN = $model->pin_phone_vaerification;
            $PhonePin = Yii::$app->request->post('User')['phone_pin'];
            $model->phone_pin = $PhonePin;
            #echo $model->scenario ;
            if ($model->validate()) {
                if ($PIN == $PhonePin) {
                    $model->completed_step = $model->setCompletedStep('8');
                    $model->ePhoneVerifiedStatus = 'Yes';
                    $model->pin_phone_vaerification = 0;
                    $model->save();
                    $model->phone_pin = '';
                    $show = false;
                }
                $popup = true;
            } else {
                $model->ePhoneVerifiedStatus = 'No';
                #$popup = true;
            }
        }

        return $this->actionRenderAjax($model, '_verificationphone', $show, $popup);
    }

    public function actionPhoneNumberChange() # For Phone Number Change : VS
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_PHONE_NUMBER_CHANGE;
        $show = false;
        $popup = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('save') == 'PHONE_NUMBER_CHANGE')) {
            $show = true;
            $OldNumber = $model->county_code . $model->Mobile;
            $NewCountryCode = Yii::$app->request->post('User')['county_code'];
            $NewPhoneNumber = Yii::$app->request->post('User')['Mobile'];
            $NewNumber = $NewCountryCode . $NewPhoneNumber;
            $model->county_code = $NewCountryCode;
            $model->Mobile = $NewPhoneNumber;
            if ($model->validate()) {
                if ($OldNumber != $NewNumber) {
                    $PIN_P = CommonHelper::generateNumericUniqueToken(4);
                    $model->pin_phone_vaerification = $PIN_P;
                    $model->completed_step = CommonHelper::unsetStep($model->completed_step, 8);
                    $model->ePhoneVerifiedStatus = 'No';
                    if ($model->save()) {
                        $SMS_FLAG = SmsHelper::SendSMS($PIN_P, $model->Mobile);
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
        if (isset($_REQUEST['type']) && $_REQUEST['type'] == 10) { # For Resend PIN
            $flag = true;
            $PIN_P = CommonHelper::generateNumericUniqueToken(4);
            $model->pin_phone_vaerification = $PIN_P;
            $model->completed_step = CommonHelper::unsetStep($model->completed_step, 8);
            $model->ePhoneVerifiedStatus = 'No';
            if ($model->save()) {
                $SMS_FLAG = SmsHelper::SendSMS($PIN_P, $model->Mobile);
                $popup = true;
            } else {
                $popup = false;
            }
        }
        return $this->actionRenderAjax($model, '_verificationphone', $show, $popup, $flag);
    }

    public function actionEmailVerification()   # For Email Verification : VS
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_VERIFY_PIN_FOR_EMAIL;
        $show = false;
        $popup = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('verify') == 'EMAIL_VERIFY')) {
            $show = true;
            $PIN = $model->pin_email_vaerification;
            $EmailPin = Yii::$app->request->post('User')['email_pin'];
            $model->email_pin = $EmailPin;
            #echo $model->scenario ;
            if ($model->validate()) {
                if ($PIN == $EmailPin) {
                    $model->completed_step = $model->setCompletedStep('9');
                    $model->eEmailVerifiedStatus = 'Yes';
                    $model->pin_email_vaerification = '';
                    $model->save();
                    $model->email_pin = '';
                    $show = false;
                }
                $popup = true;
            } else {
                $model->eEmailVerifiedStatus = 'No';
                #$popup = true;
            }
        }
        return $this->actionRenderAjax($model, '_verificationemail', $show, $popup);
    }

    public function actionEmailIdChange() # For Email ID Change : VS
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_EMAIL_ID_CHANGE;
        $show = false;
        $popup = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('save') == 'EMAIL_ID_CHANGE')) {
            $show = true;
            $OldEmailId = $model->email;
            $NewEmailID = Yii::$app->request->post('User')['email'];
            $model->email = $NewEmailID;
            if ($model->validate()) {
                if ($OldEmailId != $NewEmailID) {
                    $PIN_P = CommonHelper::generateNumericUniqueToken(4);
                    $model->pin_email_vaerification = $PIN_P;
                    $model->completed_step = CommonHelper::unsetStep($model->completed_step, 9);
                    $model->eEmailVerifiedStatus = 'No';
                    if ($model->save()) {
                        $MAIL_DATA = array("EMAIL" => $NewEmailID, "EMAIL_TO" => $NewEmailID, "NAME" => $model->First_Name . " " . $model->Last_Name, "PIN" => $PIN_P);
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
        if (isset($_REQUEST['type']) && $_REQUEST['type'] == 10) { # For Resend PIN
            $flag = true;
            $PIN_P = CommonHelper::generateNumericUniqueToken(4);
            $model->pin_email_vaerification = $PIN_P;
            $model->completed_step = CommonHelper::unsetStep($model->completed_step, 8);
            $model->eEmailVerifiedStatus = 'No';
            if ($model->save()) {
                $MAIL_DATA = array("EMAIL" => $model->email, "EMAIL_TO" => $model->email, "NAME" => $model->First_Name . " " . $model->Last_Name, "PIN" => $PIN_P);
                $MAIL_STATUS = MailHelper::SendMail('EMAIL_VERIFICATION_PIN', $MAIL_DATA);
                $popup = true;
            } else {
                $popup = false;
            }
        }
        return $this->actionRenderAjax($model, '_verificationemail', $show, $popup, $flag);
    }

    public function actionProfileViewedBy()   #Profile Vied By Data
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        return $this->actionRenderAjax($model, '_profileviewedby');
    }

    public function actionProfile($uk = '') #Other User Profile View : VS
    {
        $id = Yii::$app->user->identity->id;
        #echo $uk;exit;echo $Registration_Number;exit;
        $model1 = User::findOne(['Registration_Number' => $uk]);
        $OtherUserId = $model1->id;
        $flag = false;
        $MatchCompatibility = array();
        $PhotoList = array();
        $model = array();
        $Title = $Message = '';
        if ($OtherUserId != $id) {
            $flag = true;
            $model = User::findOne($OtherUserId);
            $UserPhotoModel = new UserPhotos();
            $PhotoList = $UserPhotoModel->findByUserId($OtherUserId);
            $PartenersReligion = PartenersReligion::findByUserId($OtherUserId) == NULL ? new PartenersReligion() : PartenersReligion::findByUserId($OtherUserId);
            $UPP = UserPartnerPreference::findByUserId($OtherUserId) == NULL ? new UserPartnerPreference() : UserPartnerPreference::findByUserId($OtherUserId);
            $PartnersMaritalStatus = PartnersMaritalStatus::findByUserId($OtherUserId) == NULL ? new PartnersMaritalStatus() : PartnersMaritalStatus::findByUserId($OtherUserId);
            $PartnersGotra = PartnersGotra::findByUserId($OtherUserId) == NULL ? new PartnersGotra() : PartnersGotra::findByUserId($OtherUserId);
            $PartnersFathersStatus = PartnersFathersStatus::findByUserId($OtherUserId) == NULL ? new PartnersFathersStatus() : PartnersFathersStatus::findByUserId($OtherUserId);
            $PartnersMothersStatus = PartnersMothersStatus::findByUserId($OtherUserId) == NULL ? new PartnersMothersStatus() : PartnersMothersStatus::findByUserId($OtherUserId);
            $PartnersEducationalLevel = PartnersEducationalLevel::findByUserId($OtherUserId) == NULL ? new PartnersEducationalLevel() : PartnersEducationalLevel::findByUserId($OtherUserId);
            $PartnersEducationField = PartnersEducationField::findByUserId($OtherUserId) == NULL ? new PartnersEducationField() : PartnersEducationField::findByUserId($OtherUserId);

        } else if ($OtherUserId == $id) {
            $Title = "Access Denied";
            $Message = "You can't see your profile as user view.";
        } else {
            $Title = "Access Denied";
            $Message = "Trying to access invalid data.";
        }
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
        ]);
    }
}