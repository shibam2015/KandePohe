<?php
namespace frontend\controllers;

use common\models\Mailbox;
use common\models\UserPhotos;
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

/**
 * Site controller
 */
class SearchController extends Controller
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

    }

    public function actionBasicSearch()
    {
        $request = Yii::$app->request;
        $session = Yii::$app->session;
        $params = $request->bodyParams;
        #CommonHelper::pr($params);exit;
        //http://localhost/KandePohe/search/basic-search?search-type=basic&profile-for=FEMALE&Community=1&sub-community=1&agerange=19&height=2
        if (Yii::$app->user->isGuest) {
            $TempModel = new User();
        } else {
            $id = Yii::$app->user->identity->id;
            $TempModel = User::findOne($id);
            $WhereId = " AND user.id != " . $id;
        }

        if ($TempModel->load(Yii::$app->request->post())) {
            $Gender = $params['User']['Profile_for'];
            $Community = $params['User']['iCommunity_ID'];
            $SubCommunity = $params['User']['iSubCommunity_ID'];
            $Height = $params['User']['iHeightID'];
            $ReligionID = $params['User']['iReligion_ID'];
            $MaritalStatusID = $params['User']['Marital_Status'];
            if ($params['User']['Agerange'] != '') {
                list($AgeFrom, $AgeTo) = explode("-", $params['User']['Agerange']);
            } else {

                $AgeFrom = $params['User']['AgeFrom'];
                $AgeTo = $params['User']['AgeTo'];
            }

            $session->set('Profile_for', $Gender);
            $session->set('iCommunity_ID', $Community);
            $session->set('iSubCommunity_ID', $SubCommunity);
            $session->set('iHeightID', $Height);
            $session->set('iReligion_ID', $ReligionID);
            $session->set('Marital_Status', $MaritalStatusID);
            $session->set('AgeFrom', $AgeFrom);
            $session->set('AgeTo', $AgeTo);
        } else {
            $Gender = $session->get('Profile_for');
            $Community = $session->get('iCommunity_ID');
            $SubCommunity = $session->get('iSubCommunity_ID');
            $Height = $session->get('iHeightID');
            $ReligionID = $session->get('iReligion_ID');
            $MaritalStatusID = $session->get('Marital_Status');
            $AgeFrom = $session->get('AgeFrom');
            $AgeTo = $session->get('AgeTo');
        }
        $WHERE = '';
        if ($Gender == '') {
            if ($TempModel->Gender == 'MALE') {
                $WHERE .= " AND user.Gender = 'FEMALE'";
            } else if ($TempModel->Gender == 'FEMALE') {
                $WHERE .= " AND user.Gender = 'MALE'";
            }
        }
        $WHERE .= ($Gender != '') ? ' AND user.Gender = "' . $Gender . '" ' : '';

        $WHERE .= ($Community != '') ? ' AND user.iCommunity_ID = "' . $Community . '" ' : '';
        $WHERE .= ($SubCommunity != '') ? ' AND user.iSubCommunity_ID = "' . $SubCommunity . '" ' : '';
        $WHERE .= ($Height != '') ? ' AND user.iHeightID = "' . $Height . '" ' : '';
        $WHERE .= ($ReligionID != '') ? ' AND user.iReligion_ID = "' . $ReligionID . '" ' : '';
        $WHERE .= ($MaritalStatusID != '') ? ' AND user.Marital_Status = "' . $MaritalStatusID . '" ' : '';
        $WHERE .= ($AgeFrom != '') ? ' AND user.Age >= "' . $AgeFrom . '" ' : '';
        $WHERE .= ($AgeTo != '') ? ' AND user.Age <= "' . $AgeTo . '" ' : '';
        $WHERE .= $WhereId;
        $Limit = Yii::$app->params['searchingLimit'];
        $Offset = (Yii::$app->request->get('Offset') == 0) ? 0 : Yii::$app->request->get('Offset');
        $Page = (Yii::$app->request->get('page') == 0 || Yii::$app->request->get('page') == '') ? 0 : Yii::$app->request->get('page');
        if ($Page) {
            $Page = $Page - 1;
            $Offset = $Limit * $Page;
        } else {
            $Page = 0;
            $Offset = 0;
        }

        $TotalRecords = count(User::searchBasic($WHERE, 0));
        $Model = User::searchBasic($WHERE, $Offset, $Limit);

        $UserPhotoModel = new UserPhotos();
        $Photos = array();
        if (count($Model)) {
            foreach ($Model as $SK => $SV) {
                $PhotoList = $UserPhotoModel->findByUserId($SV->id);
                if (count($PhotoList)) {
                    $Photos[$SV->id] = $PhotoList;
                } else {
                    $Photos[$SV->id] = CommonHelper::getUserDefaultPhoto();
                }
            }
        }
        #$id = Yii::$app->user->identity->id;
        #$TempModel = ($id != null) ? User::findOne($id) : array();
        $TempModel->iCommunity_ID = $Community;
        $TempModel->iSubCommunity_ID = $SubCommunity;
        $TempModel->iReligion_ID = $ReligionID;
        $TempModel->Marital_Status = $MaritalStatusID;
        $TempModel->iHeightID = $Height;
        $TempModel->Profile_for = $Gender;
        $TempModel->AgeFrom = $AgeFrom;
        $TempModel->AgeTo = $AgeTo;
        return $this->render('searchlist',
            [
                'Model' => $Model,
                'TotalRecords' => $TotalRecords,
                'Photos' => $Photos,
                'Offset' => $Offset,
                'Limit' => $Limit,
                'Page' => $Page,
                'TempModel' => $TempModel

            ]
        );
    }

    public function actionAdvancedSearch()
    {
        $request = Yii::$app->request;
        $session = Yii::$app->session;
        $params = $request->bodyParams;
        #CommonHelper::pr($params);exit;
        //http://localhost/KandePohe/search/basic-search?search-type=basic&profile-for=FEMALE&Community=1&sub-community=1&agerange=19&height=2
        if (Yii::$app->user->isGuest) {
            $TempModel = new User();
        } else {
            $id = Yii::$app->user->identity->id;
            $TempModel = User::findOne($id);
        }

        if ($TempModel->load(Yii::$app->request->post())) {
            $Gender = $params['User']['Profile_for'];
            $Community = $params['User']['iCommunity_ID'];
            $SubCommunity = $params['User']['iSubCommunity_ID'];
            $Height = $params['User']['iHeightID'];
            $ReligionID = $params['User']['iReligion_ID'];
            $MaritalStatusID = $params['User']['Marital_Status'];
            if ($params['User']['Agerange'] != '') {
                list($AgeFrom, $AgeTo) = explode("-", $params['User']['Agerange']);
            } else {

                $AgeFrom = $params['User']['AgeFrom'];
                $AgeTo = $params['User']['AgeTo'];
            }

            $session->set('Profile_for', $Gender);
            $session->set('iCommunity_ID', $Community);
            $session->set('iSubCommunity_ID', $SubCommunity);
            $session->set('iHeightID', $Height);
            $session->set('iReligion_ID', $ReligionID);
            $session->set('Marital_Status', $MaritalStatusID);
            $session->set('AgeFrom', $AgeFrom);
            $session->set('AgeTo', $AgeTo);
        } else {
            $Gender = $session->get('Profile_for');
            $Community = $session->get('iCommunity_ID');
            $SubCommunity = $session->get('iSubCommunity_ID');
            $Height = $session->get('iHeightID');
            $ReligionID = $session->get('iReligion_ID');
            $MaritalStatusID = $session->get('Marital_Status');
            $AgeFrom = $session->get('AgeFrom');
            $AgeTo = $session->get('AgeTo');
        }
        $WHERE = '';
        $WHERE .= ($Gender != '') ? ' AND user.Gender = "' . $Gender . '" ' : '';
        $WHERE .= ($Community != '') ? ' AND user.iCommunity_ID = "' . $Community . '" ' : '';
        $WHERE .= ($SubCommunity != '') ? ' AND user.iSubCommunity_ID = "' . $SubCommunity . '" ' : '';
        $WHERE .= ($Height != '') ? ' AND user.iHeightID = "' . $Height . '" ' : '';
        $WHERE .= ($ReligionID != '') ? ' AND user.iReligion_ID = "' . $ReligionID . '" ' : '';
        $WHERE .= ($MaritalStatusID != '') ? ' AND user.Marital_Status = "' . $MaritalStatusID . '" ' : '';
        $WHERE .= ($AgeFrom != '') ? ' AND user.Age >= "' . $AgeFrom . '" ' : '';
        $WHERE .= ($AgeTo != '') ? ' AND user.Age <= "' . $AgeTo . '" ' : '';
        $Limit = Yii::$app->params['searchingLimit'];
        $Offset = (Yii::$app->request->get('Offset') == 0) ? 0 : Yii::$app->request->get('Offset');
        $Page = (Yii::$app->request->get('page') == 0 || Yii::$app->request->get('page') == '') ? 0 : Yii::$app->request->get('page');
        if ($Page) {
            $Page = $Page - 1;
            $Offset = $Limit * $Page;
        } else {
            $Page = 0;
            $Offset = 0;
        }

        $TotalRecords = count(User::searchBasic($WHERE, 0));
        $Model = User::searchBasic($WHERE, $Offset, $Limit);

        $UserPhotoModel = new UserPhotos();
        $Photos = array();
        if (count($Model)) {
            foreach ($Model as $SK => $SV) {
                $PhotoList = $UserPhotoModel->findByUserId($SV->id);
                if (count($PhotoList)) {
                    $Photos[$SV->id] = $PhotoList;
                } else {
                    $Photos[$SV->id] = CommonHelper::getUserDefaultPhoto();
                }
            }
        }
        #$id = Yii::$app->user->identity->id;
        #$TempModel = ($id != null) ? User::findOne($id) : array();
        $TempModel->iCommunity_ID = $Community;
        $TempModel->iSubCommunity_ID = $SubCommunity;
        $TempModel->iReligion_ID = $ReligionID;
        $TempModel->Marital_Status = $MaritalStatusID;
        $TempModel->iHeightID = $Height;
        $TempModel->Profile_for = $Gender;
        $TempModel->AgeFrom = $AgeFrom;
        $TempModel->AgeTo = $AgeTo;
        return $this->render('advancesearch',
            [
                'Model' => $Model,
                'TotalRecords' => $TotalRecords,
                'Photos' => $Photos,
                'Offset' => $Offset,
                'Limit' => $Limit,
                'Page' => $Page,
                'TempModel' => $TempModel

            ]
        );
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
    }