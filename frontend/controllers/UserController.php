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
        return $this->render('my-profile',
            ['model' => $model, 'photo_model' => $USER_PHOTOS_LIST]
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
        if(Yii::$app->request->post()){
            User::updateAll(['tYourSelf' => Yii::$app->request->post('User')['tYourSelf']], ['id' => $id]);
            return $this->renderAjax('_myinfo',[
                'model' => $model,
                'form'  => false,

            ]);
        }
        else{
            return $this->renderAjax('_myinfo',[
                'model' => $model,
                'form'  => true,
            ]);
        }
    }

}



