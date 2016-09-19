<?php
namespace backend\controllers;

use Yii;
use yii\web\Controller;

use common\models\ForgotpasswordForm;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\User;
use common\models\PartenersReligion;
use yii\widgets\ActiveForm;
use yii\web\Response;


/**
 * Site controller
 */
class MyController extends Controller
{
    public function actionError()
    {
        $error = Yii::app()->errorHandler->error;
        if ($error)
            $this->render('error', array('error'=>$error));
        else
            throw new CHttpException(404, 'Page not found.');
    }
}
