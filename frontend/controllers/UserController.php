<?php
namespace frontend\controllers;

use common\components\CommonHelper;
use common\models\UserPhotos;
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

    public function actionMyProfile(){
        #Yii::$app->session->setFlash('error', 'This is the message');
        /*Yii::$app->session->setFlash('warning', 'bla bla bla bla 1');
        Yii::$app->session->setFlash('success', 'bla bla 2');
        Yii::$app->session->setFlash('error', 'bla bla 3');*/

        $id = Yii::$app->user->identity->id;
        $model = User::find()->joinWith([countryName, stateName, cityName, height, maritalStatusName, talukaName, districtName, gotraName, subCommunityName, communityName, religionName, educationLevelName, communityName, workingWithName, workingAsName, dietName, fatherStatus])->where(['id' => $id])->one();
        $USER_PHOTO_MODEL = new  UserPhotos();
        $USER_PHOTOS_LIST = $USER_PHOTO_MODEL->findByUserId($id);
        $COVER_PHOTO = CommonHelper::getCoverPhotos($TYPE = 'USER', $id, $model->cover_photo);
        return $this->render('my-profile',
            ['model' => $model, 'photo_model' => $USER_PHOTOS_LIST, 'COVER_PHOTO' => $COVER_PHOTO]
        );
    }

    public function actionDashboard() {
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
        $id = base64_decode($id);
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
        if(Yii::$app->request->post()){
            if(Yii::$app->request->post('cancel')){
                $show = false;  
            }
            else {
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
        }
        else {
            $show = true;
        }
        
        if($show) {
            return $this->renderAjax('_myinfo',[
                'model' => $model,
                'show' => true,
            ]);
        }
        else {
            return $this->renderAjax('_myinfo',[
                'model' => $model,
                'show' => false,
            ]);
        }
    }

    public function actionEditPersonalInfo()
    {
        $show = true;
        $id = Yii::$app->user->identity->id;
        if (Yii::$app->request->post()) {
            $updateArray = array(
                'First_Name' => Yii::$app->request->post('User')['First_Name'],
                'Last_Name' => Yii::$app->request->post('User')['Last_Name'],
                'iHeightID' => Yii::$app->request->post('User')['iHeightID'],
                'iMaritalStatusID' => Yii::$app->request->post('User')['iMaritalStatusID'],
            );
            User::updateAll($updateArray, ['id' => $id]);
            $show = false;
        }
        $model = User::findOne($id);
        return $this->renderAjax('_personalinfo', [
            'model' => $model,
            'show' => $show,
        ]);
    }

    public function actionEditBasicInfo()
    {
        $show = true;
        $id = Yii::$app->user->identity->id;
        if (Yii::$app->request->post()) {
            $updateArray = array(
                'iReligion_ID' => Yii::$app->request->post('User')['iReligion_ID'],
                'iCommunity_ID' => Yii::$app->request->post('User')['iCommunity_ID'],
                'iSubCommunity_ID' => Yii::$app->request->post('User')['iSubCommunity_ID'],
                'iGotraID' => Yii::$app->request->post('User')['iGotraID'],
                'iCountryId' => Yii::$app->request->post('User')['iCountryId'],
                'iStateId' => Yii::$app->request->post('User')['iStateId'],
                'iCityId' => Yii::$app->request->post('User')['iCityId'],
                'iDistrictID' => Yii::$app->request->post('User')['iDistrictID'],
                'iTalukaID' => Yii::$app->request->post('User')['iTalukaID'],
                'vAreaName' => Yii::$app->request->post('User')['vAreaName'],
            );
            User::updateAll($updateArray, ['id' => $id]);
            $show = false;
        }
        $model = User::findOne($id);
        return $this->renderAjax('_basicinfo', [
            'model' => $model,
            'show' => $show,
        ]);
    }

    public function actionEditEducation()
    {
        $show = true;
        $id = Yii::$app->user->identity->id;
        if (Yii::$app->request->post()) {
            $updateArray = array(
                'iEducationLevelID' => Yii::$app->request->post('User')['iEducationLevelID'],
                'iEducationFieldID' => Yii::$app->request->post('User')['iEducationFieldID'],
                'iWorkingWithID' => Yii::$app->request->post('User')['iWorkingWithID'],
                'iWorkingAsID' => Yii::$app->request->post('User')['iWorkingAsID'],
                'iAnnualIncomeID' => Yii::$app->request->post('User')['iAnnualIncomeID'],
            );
            User::updateAll($updateArray, ['id' => $id]);
            $show = false;
        }
        $model = User::findOne($id);
        return $this->renderAjax('_education', [
            'model' => $model,
            'show' => $show,
        ]);
    }

    public function actionEditLifestyle()
    {
        $show = true;
        $id = Yii::$app->user->identity->id;
        if (Yii::$app->request->post()) {
            $updateArray = array(
                'iHeightID' => Yii::$app->request->post('User')['iHeightID'],
                'vSkinTone' => Yii::$app->request->post('User')['vSkinTone'],
                'vBodyType' => Yii::$app->request->post('User')['vBodyType'],
                'vSmoke' => Yii::$app->request->post('User')['vSmoke'],
                'vDrink' => Yii::$app->request->post('User')['vDrink'],
                'vSpectaclesLens' => Yii::$app->request->post('User')['vSpectaclesLens'],
                'vDiet' => Yii::$app->request->post('User')['vDiet'],
            );
            User::updateAll($updateArray, ['id' => $id]);
            $show = false;
        }
        $model = User::findOne($id);
        return $this->renderAjax('_lifestyle', [
            'model' => $model,
            'show' => $show,
        ]);
    }

    public function actionEditFamily()
    {
        $show = true;
        $id = Yii::$app->user->identity->id;
        if (Yii::$app->request->post()) {
            $updateArray = array(
                'iFatherStatusID' => Yii::$app->request->post('User')['iFatherStatusID'],
                'iFatherWorkingAsID' => Yii::$app->request->post('User')['iFatherWorkingAsID'],
                'iMotherStatusID' => Yii::$app->request->post('User')['iMotherStatusID'],
                'iMotherWorkingAsID' => Yii::$app->request->post('User')['iMotherWorkingAsID'],
                'nob' => Yii::$app->request->post('User')['nob'],
                'nos' => Yii::$app->request->post('User')['nos'],
                'iCountryCAId' => Yii::$app->request->post('User')['iCountryCAId'],
                'iStateCAId' => Yii::$app->request->post('User')['iStateCAId'],
                'iCityCAId' => Yii::$app->request->post('User')['iCityCAId'],
                'iDistrictCAID' => Yii::$app->request->post('User')['iDistrictCAID'],
                'iTalukaCAID' => Yii::$app->request->post('User')['iTalukaCAID'],
                'vAreaNameCA' => Yii::$app->request->post('User')['vAreaNameCA'],
                'vNativePlaceCA' => Yii::$app->request->post('User')['vNativePlaceCA'],
                'vParentsResiding' => Yii::$app->request->post('User')['vParentsResiding'],
                'vFamilyAffluenceLevel' => Yii::$app->request->post('User')['vFamilyAffluenceLevel'],
                'vFamilyType' => Yii::$app->request->post('User')['vFamilyType'],
                'vFamilyProperty' => Yii::$app->request->post('User')['vFamilyProperty'],
                'vDetailRelative' => Yii::$app->request->post('User')['vDetailRelative'],
            );
            User::updateAll($updateArray, ['id' => $id]);
            $show = false;
        }
        $model = User::findOne($id);
        $model->scenario = User::SCENARIO_REGISTER4;
        return $this->renderAjax('_family', [
            'model' => $model,
            'show' => $show,
        ]);
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

}



