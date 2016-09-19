<?php
namespace frontend\controllers;

use Yii;
use yii\base\InvalidParamException;
use yii\web\BadRequestHttpException;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;
use common\models\User;
use common\models\PartenersReligion;
use yii\widgets\ActiveForm;
use yii\web\Response;

/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * @inheritdoc
     */
    public function behaviors()
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
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

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->goBack();
        } else {
            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending email.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
      }

    public function actionRegister() {
        //$model = new Registration();
        $model = new User;
        $model->scenario = User::SCENARIO_REGISTER;
        // AJAX Validation
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
            Yii::$app->end();
        }

        if ($model->load(Yii::$app->request->post()) ) {
            
            $model->password_hash=$model->setPassword($model->password_hash);
            $model->repeat_password=$model->password_hash;
            $region_id = $model->iReligion_ID;

             #print_r($model);
            #$model->save();
              #  print_r($model->errors);

            /*if($model->save()){
                $id = $model->id;
                $model1 = new PartenersReligion();   

                $model1->iUser_ID = $id;
                $model1->iReligion_ID = $region_id;
                $model1->save();
               # print_r($model1->errors);
            }*/

            if($model->save()){
                $OUTPUT ='';
                #$OUTPUT ='';
                /*$OUTPUT .='
                          <div class="row">
                            <div class="col-sm-10 col-sm-offset-1 text-center">
                              <h4 class="mrg-bt-30 text-dark">'.$EMAIL_ID.'</h4>
                              <h4 class="mrg-bt-30"><span class="text-success"><strong>&#10003;</strong></span>
                              A confirmation email was sent to '.$EMAIL_ID.'
                              To confirm your account, please click the link in the message.
                              If you do not see the email in your Inbox, please check your Spam box.
                            </h4>
                            </div>
                          </div>';*/
                $UID = $model->id;
                #$activation_link = Yii::$app->urlManager->createAbsoluteUrl(['site/activationaccount','id'=> base64_encode($model->id)]);
                $activation_link = '';
                $activation_link .= Yii::$app->urlManager->createAbsoluteUrl(['site/activeaccount']);
                $OUTPUT .= $activation_link."&id=".base64_encode($model->id);
                $activation_link .= "&type=fone_verfication&id=".base64_encode($model->id);
                $return = array('status' => 200,'message' => 'success','OUTPUT'=>$OUTPUT);
                $to      = $model->email;
                $subject = 'Please verify your kande-pohe.com account';
                $message = "";
                #$message .= 'hi '."\r\n";
                /*$message .= "Dear ".$model->fname.",
                        You've entered ".$to." as the email address for your Kande-pohe.com Account. To start using your Shaadi profile, confirm your email by clicking the button below.

                        Verify Your Account from below URL.
                        Alternatively, copy and paste the below URL in a new browser window instead and hit Enter.
                        ";*/
                $message .= $activation_link;
                $headers = 'From: no-replay@vcodertechnolab.com.md-in-59.webhostbox.net' . "\r\n" .'Reply-To: webmaster@example.com' . "\r\n" .'X-Mailer: PHP/' . phpversion();
                //mail($to, $subject, $message, $headers);

                $this->redirect(['site/register2','id'=>base64_encode($UID)]);
            }
            else {
                $OUTPUT ='';
                #$OUTPUT1 ='';
                $OUTPUT .='
                          <div class="row">
                            <div class="col-sm-10 col-sm-offset-1 text-center">
                              <h4 class="mrg-bt-30 text-dark">'.$EMAIL_ID.'</h4>
                              <h4 class="mrg-bt-30"><span class="text-success"><strong>&#735;</strong></span>
                              There is something wrong with signup
                            </h4>
                            </div>
                          </div>';
                $return = array('status' => 200, 'message' => 'error', 'OUTPUT' => $OUTPUT);
            }
        }

        /*return $this->render('index',[
            //'registrationModel' => $model,
            'model' => $model,
        ]);*/
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for email provided.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
    }

    public function actionRegister1($id)
    {
        $id = base64_decode($id);
        if($model = User::findOne($id)){
            $model->scenario = User::SCENARIO_REGISTER2;
            if($model->load(Yii::$app->request->post())){
                if($model->save()){
                    
                    $this->redirect(['site/register3','id'=>base64_encode($id)]);
                }
            }
            return $this->render('register2',[
                'model' => $model
            ]);
        }else{
            return $this->redirect('index.php');
        }
    }


    public function actionRegister2($id)
    {
        $id = base64_decode($id);
        if($model = User::findOne($id)){
            $model->scenario = User::SCENARIO_REGISTER2;
            if($model->load(Yii::$app->request->post())){
                if($model->save()){
                    
                    $this->redirect(['site/register3','id'=>base64_encode($id)]);
                }
            }
            return $this->render('register2',[
                'model' => $model
            ]);
        }else{
            return $this->redirect('index.php');
        }
    }

    public function actionRegister3($id)
    {
        $id = base64_decode($id);
        if($model = User::findOne($id)){
            $model->scenario = User::SCENARIO_REGISTER3;
            if(Yii::$app->request->post()){
                
                if($model->save($model)){
                    $this->redirect(['site/register4','id'=>base64_encode($id)]);
                }
            }
            return $this->render('register3',[
                'model' => $model
            ]);
        }else{
            return $this->redirect('index.php');
        }
    }
}
