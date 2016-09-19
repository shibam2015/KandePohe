<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\components\CommonHelper;
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
    	
    	$id = Yii::$app->user->identity->id;
    	$model = User::find()->joinWith([countryName,stateName,cityName,height,maritalStatusName,talukaName,districtName,gotraName,subCommunityName,communityName,religionName,educationLevelName,communityName,workingWithName,workingAsName,dietName,fatherStatus])->where(['id' => $id])->one();    
		return $this->render('my-profile',
            ['model' => $model]
        );	
    }
    
    public function actionDashboard() {
        //$id = base64_decode($id);
        if (!Yii::$app->user->isGuest) {
            #$id = base64_decode($id);
            $id = Yii::$app->user->identity->id;
            #$id = base64_decode($id);
            if($model = User::findOne($id)){
                #if($model->eFirstVerificationMailStatus == 'YES' ){
                    $model->scenario = User::SCENARIO_REGISTER6;
                    $target_dir = Yii::getAlias('@web').'/uploads/';
                    $target_dir_default = Yii::getAlias('@web').'/images/';
                    if($model->propic !='')
                        $model->propic = $target_dir.$model->propic;
                    else
                        $model->propic = $target_dir_default.'placeholder.jpg';

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
}
