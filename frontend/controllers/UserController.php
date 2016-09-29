<?php
namespace frontend\controllers;

use common\components\CommonHelper;
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
        #Yii::$app->session->setFlash('error', 'This is the message');
        /*Yii::$app->session->setFlash('warning', 'bla bla bla bla 1');
        Yii::$app->session->setFlash('success', 'bla bla 2');
        Yii::$app->session->setFlash('error', 'bla bla 3');*/
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

    public function actionDashboard()
    {
        //$id = base64_decode(getUserUploadFolder$id);
        if (!Yii::$app->user->isGuest) {
            #$id = base64_decode($id);
            $id = Yii::$app->user->identity->id;
            if($model = User::findOne($id)){
                $model->scenario = User::SCENARIO_REGISTER6;
                return $this->render('dashboard',[
                    'model' => $model
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
            #$id = base64_decode($id);
            $id = Yii::$app->user->identity->id;
            #$id = base64_decode($id);
            $USER_PHOTO_MODEL = new UserPhotos();
            $USER_PHOTOS_LIST = $USER_PHOTO_MODEL->findByUserId($id);
            return $this->render('photos', [
                'model' => $USER_PHOTOS_LIST
            ]);
        } else {
            return $this->redirect(Yii::getAlias('@web'));
        }

    }

    public function actionPhotoupload($id)
    {
        #$id = base64_decode($id);
        $id = Yii::$app->user->identity->id;
        $STATUS = "SUCCESS";
        $MESSAGE = 'Photo Upload Successfully.';
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
                            $STATUS = "ERROR";
                            $MESSAGE = 'Photo Not Uploaded. Please Try Again !';
                        }
                    }
                }
                //$this->redirect(['user/photos']);
            }
            $OUTPUT_HTML = '';
            $OUTPUT_HTML_ONE = '';
            $OUTPUT_HTML .= $this->getPhotoListOutput();
            $OUTPUT_HTML_ONE .= $this->getPhotoListOutputOne();
            $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'OUTPUT' => $OUTPUT_HTML, 'OUTPUT_ONE' => $OUTPUT_HTML_ONE);
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
                    $STATUS = 'SUCCESS';
                    $MESSAGE = 'Photo Deleted Successfully.';
                } else {
                    $STATUS = 'ERROR';
                    $MESSAGE = 'Photo Not Deleted. Please Try Again !';

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
                    $STATUS = 'SUCCESS';
                    $MESSAGE = 'Photo Set AS Profile Photo.';
                    $PROFILE_PHOTO .= CommonHelper::getPhotos('USER', $id, $PHOTO, '200');
                    $PROFILE_PHOTO_ONE = CommonHelper::getPhotos('USER', $id, $PHOTO, '30');
                } else {
                    $STATUS = 'ERROR';
                    $MESSAGE = 'Photo Not Set As Profile Photo. Please Try Again !';
                }
            }

        }

        $OUTPUT_HTML .= $this->getPhotoListOutput();
        $OUTPUT_HTML_ONE .= $this->getPhotoListOutputOne();
        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'OUTPUT' => $OUTPUT_HTML, 'OUTPUT_ONE' => $OUTPUT_HTML_ONE, 'PROFILE_PHOTO' => $PROFILE_PHOTO, 'PROFILE_PHOTO_ONE' => $PROFILE_PHOTO_ONE);
        #Yii::$app->response->format = Response::FORMAT_JSON;
        return json_encode($return);
        exit;

    }

    public function actionEditMyinfo(){
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_EDIT_MY_INFO;
        $show = false;
        if(Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {

            if(Yii::$app->request->post('save')){
                $tYourSelf_old = $model->tYourSelf;
                $model->tYourSelf = Yii::$app->request->post('User')['tYourSelf'];
                if (strcmp($tYourSelf_old, $model->tYourSelf) !== 0) {
                    $model->eStatusInOwnWord = 'Pending';
                }
                if($model->validate()){
                    $model->save();
                    $show = false;
                }
                else {
                    $show = true;
                }
            }
            else {
                $show = true;
            }


        }
        else {
            $show = false;
        }

        if($show) {
            return $this->actionRenderAjax($model,'_myinfo',true);
        }
        else {
            return $this->actionRenderAjax($model,'_myinfo',false);
        }
    }

    function actionRenderAjax($model, $view, $show = false)
    {
        return $this->renderAjax($view, [
            'model' => $model,
            'show' => $show,
        ]);
    }

    public function actionEditPersonalInfo()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_EDIT_PERSONAL_INFO;
        $show = false;
        if (Yii::$app->request->post() && (Yii::$app->request->post('cancel') == '0' || Yii::$app->request->post('save'))) {
            $show = true;
            if(Yii::$app->request->post('save')){
                $model->First_Name = Yii::$app->request->post('User')['First_Name'];
                $model->Last_Name = Yii::$app->request->post('User')['Last_Name'];
                $model->Profile_created_for = Yii::$app->request->post('User')['Profile_created_for'];
                $model->DOB = Yii::$app->request->post('User')['DOB'];
                $model->county_code = Yii::$app->request->post('User')['county_code'];
                $model->Mobile = Yii::$app->request->post('User')['Mobile'];
                $model->Gender = Yii::$app->request->post('User')['Gender'];
                if($model->validate()){
                    $model->save();
                    $show = false;
                }
            }
        }
        if($show) {
            return $this->actionRenderAjax($model,'_personalinfo',true);
        }
        else {
            return $this->actionRenderAjax($model,'_personalinfo',false);
        }
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

        if ($show) {
            return $this->actionRenderAjax($model,'_basicinfo',true);
        }
        else {
            return $this->actionRenderAjax($model,'_basicinfo',false);
        }
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
        $model->scenario = User::SCENARIO_REGISTER3;
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

    public function actionSavecoverphoto($position = '')
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $STATUS = "SUCCESS";
        $MESSAGE = 'Cover Photo Upload Successfully.';
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
            } else {
                $STATUS = "SUCCESS";
                $MESSAGE = 'Cover Photo Set Successfully.';
                //$PHOTO_ARRAY = $CM_HELPER->coverPhotoUpload($id, $_FILES['cover_photo'], $PATH, $URL, '', $OLD_PHOTO);
            }

            $model->cover_background_position = $position;
            $ACTION_FLAG = $model->save();
            if (!$ACTION_FLAG) {
                $STATUS = "ERROR";
                $MESSAGE = 'Photo Not Uploaded. Please Try Again !';
            }
        }
        $OUTPUT_HTML = '';
        $OUTPUT_HTML_ONE = '';
        $OUTPUT_HTML .= $this->getPhotoListOutput();
        $OUTPUT_HTML_ONE .= $this->getPhotoListOutputOne();

        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'OUTPUT' => $OUTPUT_HTML, 'OUTPUT_ONE' => $OUTPUT_HTML_ONE);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;
    }

    public function actionSaveprivacySetting()
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $user_privacy_option = $P_ID = Yii::$app->request->post('user_privacy_option');
        $model->user_privacy_option = $user_privacy_option;
        $ACTION_FLAG = $model->save();
        $STATUS = "SUCCESS";
        $MESSAGE = 'Privacy Setting Save Successfully.';
        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE);
        #$Yii::$app->response->format = Response::FORMAT_JSON;
        #return $return;
        return json_encode($return);
        exit;
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
                    $STATUS = "ERROR";
                    $MESSAGE = 'Cover Photo Not Set. Please Try Again !';
                } else {
                    $STATUS = "SUCCESS";
                    $MESSAGE = 'Cover Photo Set Successfully.';
                }
            }
            $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE);
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
        $STATUS = "SUCCESS";

        if ($model->hide_profile == 'Yes') {
            $HS = 'No';
            $OUTPUT .= '<a href="javascript:void(0)" data-target="#hideProfile"
                                data-toggle="modal" class="hideshowmenu" data-name="No">
                                <i class="fa fa-eye-slash"></i> Hide Profile</a>';
            $MESSAGE = 'Your Profile Show Successfully.';
        } else {
            $HS = 'Yes';
            $OUTPUT .= '<a href="javascript:void(0)" data-target="#hideProfile"
                                data-toggle="modal" class="hideshowmenu" data-name="Yes">
                                <i class="fa fa-eye"></i> Show Profile</a>';
            $MESSAGE = 'Your Profile Hide Successfully.';
        }
        $model->hide_profile = $HS;
        $ACTION_FLAG = $model->save();
        if (!$ACTION_FLAG) {
            $STATUS = 'ERROR';
        }

        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'OUTPUT' => $OUTPUT);
        #$Yii::$app->response->format = Response::FORMAT_JSON;
        #return $return;
        return json_encode($return);
        exit;
    }

    public function actionSuggestTagAdd() # Add Tag which are in suggested list
    {
        $id = Yii::$app->user->identity->id;
        $ACTION = Yii::$app->request->post('ACTION');
        $STATUS = $MESSAGE = $USER_TAG_LIST = $TAG_LIST_SUGGEST = '';
        if ($ACTION != '' && $ACTION == 'ADD-TAG') {
            $TAG_ID = Yii::$app->request->post('TAG_ID');
            $USER_TAG = new UserTag();
            $USER_TAG->iUser_Id = $id;
            $USER_TAG->tag_id = $TAG_ID;
            $ACTION_FLAG = $USER_TAG->save();
            if (!$ACTION_FLAG) {
                $STATUS = "ERROR";
                $MESSAGE = 'Tag Not Added. Please Try Again !';
            } else {
                $STATUS = "SUCCESS";
                $MESSAGE = 'Tag Added Successfully.';
                $TAG_LIST_USER = UserTag::find()->joinWith([tagName])->where(['iUser_Id' => $id])->orderBy(['Name' => SORT_ASC])->all();
                foreach ($TAG_LIST_USER as $TK => $TV) {
                    $USER_TAG_LIST .= '<span class="tag label label-danger" id="tag_delete_' . $TV->id . '">
                                           ' . $TV->tagName->Name . '
                                          <i data-role="remove" class="fa fa-times tag_delete"
                                                               data-id="' . $TV->id . '"></i>
                                       </span> &nbsp;';
                }
            }
        } else if ($ACTION != '' && $ACTION == 'ADD-ALL-TAG') {
            $TAG_LIST = Tags::find()->all();
            $TAG_LIST_USER = UserTag::find()->where(['iUser_Id' => $id])->all();
            $IN_USER_TAG_LIST = array();
            foreach ($TAG_LIST_USER as $TK => $TV) {
                array_push($IN_USER_TAG_LIST, $TV['tag_id']);
            }
            foreach ($TAG_LIST as $K => $V) {
                if (!in_array($V['ID'], $IN_USER_TAG_LIST)) {
                    #echo " <br> if ",$V['ID'];
                    $USER_TAG = new UserTag();
                    $USER_TAG->iUser_Id = $id;
                    $USER_TAG->tag_id = $V['ID'];
                    $ACTION_FLAG = $USER_TAG->save();
                }
            }
            $STATUS = "SUCCESS";
            $MESSAGE = 'All Tag Added Successfully.';
            $TAG_LIST_USER = UserTag::find()->joinWith([tagName])->where(['iUser_Id' => $id])->orderBy(['Name' => SORT_ASC])->all();
            foreach ($TAG_LIST_USER as $TK => $TV) {
                $USER_TAG_LIST .= '<span class="tag label label-danger">
                                           ' . $TV->tagName->Name . '
                                          <i data-role="remove" class="fa fa-times"></i>
                                       </span> &nbsp;';
                #echo "<pre>";print_r($IN_USER_TAG_LIST);exit;
            }
            $TAG_LIST_SUGGEST = '<span class="tag label label-default">Tag Suggestion Not Available</span>';

        } else if ($ACTION != '' && $ACTION == 'DELETE-TAG') {
            $TAG_ID = Yii::$app->request->post('TAG_ID');
            UserTag::deleteAll(['id' => $TAG_ID]);
            $TAG_LIST = Tags::find()->all();
            $TAG_LIST_USER = UserTag::find()->joinWith([tagName])->where(['iUser_Id' => $id])->orderBy(['Name' => SORT_ASC])->all();
            $IN_USER_TAG_LIST = array();
            foreach ($TAG_LIST_USER as $TK => $TV) {
                array_push($IN_USER_TAG_LIST, $TV['tag_id']);
            }
            $STATUS = "SUCCESS";
            $MESSAGE = 'Tag Deleted Successfully.';
            foreach ($TAG_LIST_USER as $TK => $TV) {
            }
            foreach ($TAG_LIST as $TK => $TV) {
                if (!in_array($TV['ID'], $IN_USER_TAG_LIST)) {
                    $TAG_LIST_SUGGEST .= '<button class="btn btn-default suggest_tag" data-id="' . $TV['ID'] . '">' . $TV['Name'] . '</button> &nbsp;';
                }
            }
        }

        $TAG_LIST = Tags::find()->all();
        $TAG_LIST_USER = UserTag::find()->where(['iUser_Id' => $id])->all();
        $TAG_COUNT = count($TAG_LIST_USER) . "/" . count($TAG_LIST);
        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, "USER_TAG_LIST" => $USER_TAG_LIST, 'TAG_LIST_SUGGEST' => $TAG_LIST_SUGGEST, 'TAG_COUNT' => $TAG_COUNT);
        #Yii::$app->response->format = Response::FORMAT_JSON;
        return json_encode($return);
        exit;
    }

    public function actionAccountDelete() # Account Delete
    {
        $id = Yii::$app->user->identity->id;
        $model = User::findOne($id);
        $STATUS = "SUCCESS";
        $MESSAGE = 'Your Profile successfully deleted. <br>Please Wait for a few second.';
        $model->status = STATUS_DELETED;
        $model->save();
        $LINK = CommonHelper::getSiteUrl('BACKEND') . 'user/' . $id;
        $MAIL_DATA = array("EMAIL" => $model->email, "NAME" => $model->First_Name . " " . $model->Last_Name, "LINK" => $LINK);
        MailHelper::SendMail('ADMIN_DELETE_ACCOUNT_USER', $MAIL_DATA);
        Yii::$app->user->logout();

        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE);
        //Yii::$app->response->format = Response::FORMAT_JSON;
        return json_encode($return);
    }
}
