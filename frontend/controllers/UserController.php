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
#        $model = new Wightege();
        #print_R($model->findModel(2));
        $PERCENTAGE = 0;
        $STEP_ARRAY = explode(",", $x);
        foreach ($STEP_ARRAY as $k => $v) {
            if ($v != '') {
                if ($model = Wightege::findOne($v)) {
                    $PERCENTAGE += $model->vWightegePercent;
                }
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
		return $this->render('my-profile',
            ['model' => $model]
        );
    }

    public function actionDashboard() {
        //$id = base64_decode(getUserUploadFolder$id);
        if (!Yii::$app->user->isGuest) {
            #$id = base64_decode($id);
            $id = Yii::$app->user->identity->id;
            #$id = base64_decode($id);
            if($model = User::findOne($id)){
                #if($model->eFirstVerificationMailStatus == 'YES' ){
                    $model->scenario = User::SCENARIO_REGISTER6;
                #$target_dir = Yii::getAlias('@web').'/uploads/';
                #$target_dir_default = Yii::getAlias('@web').'/images/';
                /*if($model->propic !='')
                    $model->propic = \common\components\CommonHelper::getPhotos('USER',$id,$model->propic,200);
                else
                    $model->propic = CommonHelper::getUserDefaultPhoto();*/
                    return $this->render('dashboard',[
                        'model' => $model
                    ]);
                /*}else{
                    return $this->redirect(Yii::getAlias('@web'));
                }*/

            }else{
                return $this->redirect(Yii::getAlias('@web'));
            }
        }else{
            return $this->redirect(Yii::getAlias('@web'));
        }

        #return $this->render('dashboard');
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
                        $PG->save();
                    }
                }

                //$this->redirect(['user/photos']);
            }
            $OUTPUT_HTML = $this->getPhotoListOutput();
            $return = array('STATUS' => 200, 'message' => 'Photo List', 'OUTPUT' => $OUTPUT_HTML);
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
            $IMG = CommonHelper::getPhotos('USER', Yii::$app->user->identity->id, $V['File_Name'], 140);
            $OUTPUT_HTML .= '<div class="col-md-3 col-sm-3 col-xs-6">
                                                                <a class="selected" href="#">';

            $OUTPUT_HTML .= '<img src="' . $IMG . '" height="140" class="img-responsive" alt="Full view" style="height:140px;">';
            $OUTPUT_HTML .= '</a>

                                                                <a href="javascript:void(0)" class="pull-left profile_set" data-id="' . $V['iPhoto_ID'] . '"> Profile pic</a>

                                                                <a href="javascript:void(0)" class="pull-right profile_delete" data-id="' . $V['iPhoto_ID'] . '"> <i aria-hidden="true"
                                                                                                   class="fa fa-trash-o"></i>
                                                                </a>

                                                            </div>';

        }
        return $OUTPUT_HTML;
    }

    /**
     * @return string
     */
    public function actionPhotoOperation()
    {
        ob_start();
        ob_get_clean();
        $PG = new UserPhotos();
        $CM_HELPER = new CommonHelper();
        $id = Yii::$app->user->identity->id;
        $P_ID = Yii::$app->request->post('P_ID');
        $P_TYPE = Yii::$app->request->post('P_TYPE');
        if ($P_ID != '' && $P_TYPE == 'PHOTO_DELETE' && $P_TYPE != '') {
            $USER_PHOTOS_LIST = $PG->findByPhotoId($id, $P_ID);
            if (count($USER_PHOTOS_LIST) != 0) {
                $PATH = $CM_HELPER->getUserUploadFolder(1) . "/" . $id . "/";
                $USER_SIZE_ARRAY = $CM_HELPER->getUserResizeRatio();
                $CM_HELPER->photoDeleteFromFolder($PATH, $USER_SIZE_ARRAY, $USER_PHOTOS_LIST->File_Name);
                $USER_PHOTOS_LIST->delete();

            }
        } else {

        }
        $OUTPUT_HTML = $this->getPhotoListOutput();
        $return = array('STATUS' => 200, 'message' => 'Photo List', 'OUTPUT' => $OUTPUT_HTML);
        #echo "<pre>"; print_r($return);
        Yii::$app->response->format = Response::FORMAT_JSON;
        return $return;

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

