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
        $Gender = Yii::$app->request->get('profile-for');
        $Community = Yii::$app->request->get('iCommunity_ID');
        $WHERE = ($Gender != '') ? ' AND user.Gender="' . $Gender . '" ' : '' OR ($Community != '') ? ' AND user.iCommunity_ID="' . $Community . '" ' : '';
        $Limit = Yii::$app->params['searchingLimit'];

        $Offset = (Yii::$app->request->get('Offset') == 0) ? 0 : Yii::$app->request->get('Offset');
        $Page = (Yii::$app->request->get('page') == 0) ? 0 : Yii::$app->request->get('page');
        if (isset($Page)) {
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
        return $this->render('searchlist',
            [
                'Model' => $Model,
                'TotalRecords' => $TotalRecords,
                'Photos' => $Photos,
                'Offset' => $Offset,
                'Limit' => $Limit,
                'Page' => $Page
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