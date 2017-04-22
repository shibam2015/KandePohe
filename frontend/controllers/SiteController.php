<?php
namespace frontend\controllers;

use common\components\MessageHelper;
use common\components\SmsHelper;
use common\models\Cities;
use common\models\otherlibraries\Compressimage;
use common\models\SiteCms;
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
#use frontend\components\CommonHelper;
use common\components\CommonHelper;
use common\components\MailHelper;
use common\models\User;

//use common\models\PartenersReligion;
//use common\models\PartnersMaritalStatus;
use common\models\UserPartnerPreference;

use common\models\PartnersAnnualIncome;
use common\models\PartnersBodyType;
use common\models\PartnersCharan;
use common\models\PartnersCities;
use common\models\PartnersCommunity;
use common\models\PartnersCountries;
use common\models\PartnersDiet;
use common\models\PartnersDrink;
use common\models\PartnersFamilyAffluenceLevel;
use common\models\PartnersFamilyType;
use common\models\PartnersFavouriteCousines;
use common\models\PartnersFavouriteMusic;
use common\models\PartnersFavouriteReads;
use common\models\PartnersFitnessActivities;
use common\models\PartnersInterest;
use common\models\PartnersMothertongue;
use common\models\PartnersNadi;
use common\models\PartnersNakshtra;
use common\models\PartnersPreferredDressType;
use common\models\PartnersPreferredMovies;
use common\models\PartnersRaashi;
use common\models\PartnersReligion;
use common\models\PartnersSkinTone;
use common\models\PartnersSmoke;
use common\models\PartnersSpectacles;
use common\models\PartnersStates;
use common\models\PartnersSubcommunity;
use common\models\PartnerWorkingAs;
use common\models\PartnerWorkingWith;
use common\models\PartenersReligion;
//use common\models\UserPartnerPreference;
use common\models\PartnersMaritalStatus;
use common\models\PartnersGotra;
use common\models\PartnersFathersStatus;
use common\models\PartnersMothersStatus;
use common\models\PartnersEducationalLevel;
use common\models\PartnersEducationField;

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
    public function actionIndex($ref = '')
    {
        $model = new User();
        $model->scenario = User::SCENARIO_REGISTER;
        if ($model->load(Yii::$app->request->post())) {
            #CommonHelper::pr($_REQUEST);exit;
            #  return $this->redirect(['search/basic-search','search-type' => 'basic']);
            return $this->redirect(['search/basic-search',
                    'search-type' => 'basic',
                    'profile-for' => Yii::$app->request->post('User')['Profile_for'],
                    'Community' => Yii::$app->request->post('User')['iCommunity_ID'],
                    'sub-community' => Yii::$app->request->post('User')['iSubCommunity_ID'],
                    'agerange' => Yii::$app->request->post('User')['Agerange'],
                    'height' => Yii::$app->request->post('User')['iHeightID'],
                ]
            );
            exit;
        }
        if (Yii::$app->user->isGuest) {
            $FeaturedMembers = User::findFeaturedMembers(4);
        } else {
            $FeaturedMembers = User::findFeaturedMembersLogin(4, Yii::$app->user->identity->id, Yii::$app->user->identity->Gender);
        }
        #CommonHelper::pr($FeaturedMembers);exit;
        //return $this->redirect(Yii::$app->request->referrer);
        return $this->render('index',
            [
                'model' => $model,
                'FeaturedMembers' => $FeaturedMembers,
                'ref' => $ref,
            ]
        );
    }

    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        //die('hii');
        if (!Yii::$app->user->isGuest) {
            //return $this->goHome();
            $this->redirect(['/dashboard']);
        }

        $model = new LoginForm();

        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {

            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
            Yii::$app->end();
        }

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $UserModel = User::findOne(Yii::$app->user->identity->id);
            $UserModel->scenario = User::SCENARIO_LAST_LOGIN;
            $UserModel->LastLoginTime = CommonHelper::getTime();
            $UserModel->save();
            $this->redirect(['/dashboard']);
        } else {

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
    public function actionAboutUs()
    {
        $SiteCMSModel = SiteCms::findOne(['type' => 'ABOUT_US']);

        #CommonHelper::pr($SiteCMSModel);
        return $this->render('about_us',
            [
                'SiteCMSModel' => $SiteCMSModel,

            ]
        );

    }

    public function actionTermsOfUse()
    {
        $SiteCMSModel = SiteCms::findOne(['type' => 'TERMS_OF_USE_OR_SERVICE_AGREEMENT']);
        #CommonHelper::pr($SiteCMSModel);
        return $this->render('terms_of_condition',
            [
                'SiteCMSModel' => $SiteCMSModel,

            ]
        );

    }

    public function actionContactUs()
    {
        $model = new ContactForm();
        $STATUS = $MESSAGE = $TITLE = '';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['helpEmail'])) {
                #Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'CONTACT_US');
                $model->name = '';
                $model->email = '';
                $model->phone = '';
                $model->message = '';
            } else {
                #Yii::$app->session->setFlash('error', 'There was an error sending email.');
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'CONTACT_US');
            }
            #return $this->refresh();

        }
        return $this->render('contact_us', [
            'model' => $model,
            'STATUS' => $STATUS,
            'MESSAGE' => $MESSAGE,
            'TITLE' => $TITLE,

        ]);
    }

    public function actionHelpFeedback()
    {
        $model = new ContactForm();
        $STATUS = $MESSAGE = $TITLE = '';
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['helpEmail'])) {
                #Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'CONTACT_US');
                $model->name = '';
                $model->email = '';
                $model->phone = '';
                $model->message = '';
            } else {
                #Yii::$app->session->setFlash('error', 'There was an error sending email.');
                list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'CONTACT_US');
            }
            #return $this->refresh();

        }
        return $this->render('help_feedback', [
            'model' => $model,
            'STATUS' => $STATUS,
            'MESSAGE' => $MESSAGE,
            'TITLE' => $TITLE,

        ]);
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
        $model = new User;
        $model->scenario = User::SCENARIO_REGISTER;
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post())) {
            Yii::$app->response->format = Response::FORMAT_JSON;
            return ActiveForm::validate($model);
            Yii::$app->end();
        }

        if ($model->load(Yii::$app->request->post()) ) {
            //get verify response data
            $password = $model->password_hash;
            $email = $model->email;
            $model->password_hash=$model->setPassword($password);
            $model->repeat_password=$model->password_hash;
            $model->toc=$model->toc[0];
            $model->status= 1;
            $region_id = $model->iReligion_ID;
            #$U_R_ID = $model->generateUniqueRandomNumber(9);
            $U_R_ID = CommonHelper::generateUniqueRandomNumber(9);
            $model->Registration_Number = $U_R_ID;
            $model->completed_step = $model->setCompletedStep('1');
            $model->Age = CommonHelper::ageCalculator($model->DOB);
            //CommonHelper::pr(Yii::$app->request->post());
            $model->new_county_code = Yii::$app->request->post('User')['county_code'];
            $model->new_phone_no = Yii::$app->request->post('User')['Mobile'];
            $model->LastLoginTime = CommonHelper::getTime();
            $model->IP_Address = CommonHelper::getIPAddress();
            #CommonHelper::pr(Yii::$app->request->post());exit;
            /*$model->save();
            var_dump($model->errors);
            die();*/
            if($model->save()){
                $OUTPUT ='';
                #$OUTPUT ='';
                $EMAIL_ID = $model->email;
                $OUTPUT .='
                          <div class="row">
                            <div class="col-sm-10 col-sm-offset-1 text-center">
                              <h4 class="mrg-bt-30 text-dark">'.$EMAIL_ID.'</h4>
                              <h4 class="mrg-bt-30"><span class="text-success"><strong>&#10003;</strong></span>
                              A confirmation email was sent to '.$EMAIL_ID.'
                              To confirm your account, please click the link in the message.
                              If you do not see the email in your Inbox, please check your Spam box.
                            </h4>
                            </div>
                          </div>';
                $UID = $model->id;
                #$activation_link = Yii::$app->urlManager->createAbsoluteUrl(['site/activationaccount','id'=> base64_encode($model->id)]);
                $activation_link = '';
                $activation_link .= Yii::$app->urlManager->createAbsoluteUrl(['site/activeaccount']);
                $activation_link .= "?id=".base64_encode($model->id);
                #$activation_link1 = Yii::$app->urlManager->createUrl(['site/activeaccount']);
                #$activation_link1 = $activation_link1."?id=".base64_encode($model->id);
                #$OUTPUT .= $activation_link1;
                //$return = array('status' => 200,'message' => 'success','OUTPUT'=>$OUTPUT);

                $MAIL_DATA = array("EMAIL" => $model->email, "EMAIL_TO" => $model->email, "NAME" => ucwords($model->First_Name . " " . $model->Last_Name), "ACTIVATION_LINK" => $activation_link);
                MailHelper::SendMail('VERIFY_ACCOUNT', $MAIL_DATA);

                $model1 = new LoginForm();
                $model1->password = $password;
                $model1->email = $email;

                if ($model1->login()) {
                    $this->redirect(['site/basic-details']);
                } else {

                }

            }
            else {
                $this->goHome();

            }


        }else{
            $OUTPUT ='';
            #$OUTPUT1 ='';
            $OUTPUT .='
                          <div class="row">
                            <div class="col-sm-10 col-sm-offset-1 text-center">
                              <h4 class="mrg-bt-30 text-dark"></h4>
                              <h4 class="mrg-bt-30"><span class="text-success"><strong>&#735;</strong></span>
                              There is something wrong with signup
                            </h4>
                            </div>
                          </div>';
            //$return = array('status' => 200, 'message' => 'error', 'OUTPUT' => $OUTPUT);
        }

        //Yii::$app->response->format = Response::FORMAT_JSON;
        // return $return;
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        //$model->scenario = User::SCENARIO_SFP;
        $commonhelper = new CommonHelper();
        if (Yii::$app->request->isAjax && $model->load(Yii::$app->request->post()))
        {
            Yii::$app->response->format = Response::FORMAT_JSON;
            $returnData = ActiveForm::validate($model);

            if(Yii::$app->request->post('vStatus')==1 && count($returnData)==0){
                if ($model->sendEmail()) {
                    $returnData['status'] = 1;
                    $returnData['email'] = Yii::$app->request->post('PasswordResetRequestForm')['email'];
                }
                else {
                    $returnData['status'] = 0;
                }

            }
            else {
                $returnData['status'] = 0;
            }
            return $returnData;
        }
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
        $commonhelper = new CommonHelper();
        //$id = $commonhelper->encryptor('decrypt',Yii::$app->request->get('id'));
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }
        if($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()){
            Yii::$app->session->setFlash('success', 'New password was saved.');

            return $this->redirect(Yii::$app->homeUrl . '?ref=cps');
        }
        return $this->render('reset-password',[
            'model' => $model
        ]);

    }

    public function actionActiveaccount($id){
        $id = base64_decode($id);
        if($model = User::findOne($id)){
            $model->scenario = User::SCENARIO_FIRST_VERIFICATION;
            $model->eFirstVerificationMailStatus = 'YES';
            if($model->save($model)){
                $this->redirect(['site/basic-details']);
            }else{
                #$this->redirect('index.php');
            }
        }else{
            #$this->redirect('index.php');
        }

    }
    public function actionBasicDetails($id='')
    {
        if (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->identity->id;
            if($model = User::findOne($id)){
                $model->scenario = User::SCENARIO_REGISTER1;
                if($model->load(Yii::$app->request->post())){
                    $model->completed_step = $model->setCompletedStep('2');
                    $AreaName = Yii::$app->request->post('User')['vAreaName'];
                    //$iDistrictID = Yii::$app->request->post('User')['iDistrictID'];
                    if (Yii::$app->request->post('User')['iCountryId'] != 101) {
                        $model->iDistrictID = 1;
                        $model->iTalukaID = 1;
                    }
                    $CityName = $model->cityName->vCityName;
                    $StateName = $model->stateName->vStateName;
                    $CountryName = $model->countryName->vCountryName;
                    $Address = $AreaName . " " . $CityName . " " . $StateName . " " . $CountryName;
                    $LatLongArray = CommonHelper::getLatLong($Address);
                    $model->latitude = $LatLongArray['latitude'];
                    $model->longitude = $LatLongArray['longitude'];
                    if($model->save()){
                        $this->redirect(['site/education-occupation']);
                    }
                }
                return $this->render('register1',[
                    'model' => $model,
                    'CurrentStep' => 2,
                ]);
            }else{
                return $this->redirect(Yii::getAlias('@web'));
            }
        }else{
            return $this->redirect(Yii::getAlias('@web'));
        }
    }


    public function actionEducationOccupation($id='')
    {
        if (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->identity->id;
            if($model = User::findOne($id)){
                $model->scenario = User::SCENARIO_REGISTER2;
                if($model->load(Yii::$app->request->post())){
                    $model->completed_step = $model->setCompletedStep('3');
                    if($model->save()){
                        $this->redirect(['site/life-style']);
                    }
                }
                return $this->render('register2',[
                    'model' => $model,
                    'CurrentStep' => 3,
                ]);

            }else{
                return $this->redirect(Yii::getAlias('@web'));
            }
        }else{
            return $this->redirect(Yii::getAlias('@web'));
        }
    }

    public function actionLifeStyle($id='')
    {
        if (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->identity->id;
            if($model = User::findOne($id)){
                $model->scenario = User::SCENARIO_REGISTER3;
                if($model->load(Yii::$app->request->post())){
                    $model->completed_step = $model->setCompletedStep('4');
                    if($model->save()){
                        $this->redirect(['site/about-family']);
                    }
                }
                return $this->render('register3',[
                    'model' => $model,
                    'CurrentStep' => 4,
                ]);
            }else{
                return $this->redirect(Yii::getAlias('@web'));
            }
        }else{
            return $this->redirect(Yii::getAlias('@web'));
        }
    }

    public function actionPartnerPreferences()
    {

        if (!Yii::$app->user->isGuest) {
            $Id = Yii::$app->user->identity->id;
            $model = User::findOne($Id);
            if ($model->eEmailVerifiedStatus != 'Yes' && $model->ePhoneVerifiedStatus != 'Yes') {
                return $this->redirect([Yii::$app->params['userVerification']]);
                #return $this->redirect(['site/verification']);
                exit;
            }
            $PartenersReligion = PartenersReligion::findAllByUserId($Id) == NULL ? new PartenersReligion() : PartenersReligion::findAllByUserId($Id);
            $PartnersMaritalStatus = PartnersMaritalStatus::findAllByUserId($Id) == NULL ? new PartnersMaritalStatus() : PartnersMaritalStatus::findAllByUserId($Id);
            $PartnersGotra = PartnersGotra::findAllByUserId($Id) == NULL ? new PartnersGotra() : PartnersGotra::findAllByUserId($Id);
            $PartnersCommunity = PartnersCommunity::findAllByUserId($Id) == NULL ? new PartnersCommunity() : PartnersCommunity::findAllByUserId($Id);
            $PartnersSubCommunity = PartnersSubcommunity::findAllByUserId($Id) == NULL ? new PartnersSubcommunity() : PartnersSubcommunity::findAllByUserId($Id);
            $UPP = UserPartnerPreference::findByUserId($Id) == NULL ? new UserPartnerPreference() : UserPartnerPreference::findByUserId($Id);
            $PartnersMothertongue = PartnersMothertongue::findByUserId($Id) == NULL ? new PartnersMothertongue() : PartnersMothertongue::findByUserId($Id);
            $PartnersRaashi = PartnersRaashi::findByUserId($Id) == NULL ? new PartnersRaashi() : PartnersRaashi::findByUserId($Id);
            $PartnersCharan = PartnersCharan::findByUserId($Id) == NULL ? new PartnersCharan() : PartnersCharan::findByUserId($Id);
            $PartnersNakshtra = PartnersNakshtra::findByUserId($Id) == NULL ? new PartnersNakshtra() : PartnersNakshtra::findByUserId($Id);
            $PartnersNadi = PartnersNadi::findByUserId($Id) == NULL ? new PartnersNadi() : PartnersNadi::findByUserId($Id);
            $PartnersSkinTone = PartnersSkinTone::findAllByUserId($Id) == NULL ? new PartnersSkinTone() : PartnersSkinTone::findAllByUserId($Id);
            $PartnersBodyType = PartnersBodyType::findAllByUserId($Id) == NULL ? new PartnersBodyType() : PartnersBodyType::findAllByUserId($Id);
            $PartnersDiet = PartnersDiet::findAllByUserId($Id) == NULL ? new PartnersDiet() : PartnersDiet::findAllByUserId($Id);
            $PartnersSpectacles = PartnersSpectacles::findAllByUserId($Id) == NULL ? new PartnersSpectacles() : PartnersSpectacles::findAllByUserId($Id);
            $PartnersSmoke = PartnersSmoke::findAllByUserId($Id) == NULL ? new PartnersSmoke() : PartnersSmoke::findAllByUserId($Id);
            $PartnersDrink = PartnersDrink::findAllByUserId($Id) == NULL ? new PartnersDrink() : PartnersDrink::findAllByUserId($Id);
            $PartnersEducationalLevel = PartnersEducationalLevel::findAllByUserId($Id) == NULL ? new PartnersEducationalLevel() : PartnersEducationalLevel::findAllByUserId($Id);
            $PartnersEducationField = PartnersEducationField::findAllByUserId($Id) == NULL ? new PartnersEducationField() : PartnersEducationField::findAllByUserId($Id);
            $PartnerWorkingAS = PartnerWorkingAs::findAllByUserId($Id) == NULL ? new PartnerWorkingAs() : PartnerWorkingAs::findAllByUserId($Id);
            $PartnerWorkingWith = PartnerWorkingWith::findAllByUserId($Id) == NULL ? new PartnerWorkingWith() : PartnerWorkingWith::findAllByUserId($Id);
            $AI = PartnersAnnualIncome::findByUserId($Id) == NULL ? new PartnersAnnualIncome() : PartnersAnnualIncome::findByUserId($Id);
            $PartnersInterest = PartnersInterest::findAllByUserId($Id) == NULL ? new PartnersInterest() : PartnersInterest::findAllByUserId($Id);
            $PartnersReads = PartnersFavouriteReads::findAllByUserId($Id) == NULL ? new PartnersFavouriteReads() : PartnersFavouriteReads::findAllByUserId($Id);
            $PartnersMusic = PartnersFavouriteMusic::findAllByUserId($Id) == NULL ? new PartnersFavouriteMusic() : PartnersFavouriteMusic::findAllByUserId($Id);
            $PartnersCousins = PartnersFavouriteCousines::findAllByUserId($Id) == NULL ? new PartnersFavouriteCousines() : PartnersFavouriteCousines::findAllByUserId($Id);
            $PartnersFitnessActivity = PartnersFitnessActivities::findAllByUserId($Id) == NULL ? new PartnersFitnessActivities() : PartnersFitnessActivities::findAllByUserId($Id);
            $PartnersDressStyle = PartnersPreferredDressType::findAllByUserId($Id) == NULL ? new PartnersPreferredDressType() : PartnersPreferredDressType::findAllByUserId($Id);
            $PartnersMovies = PartnersPreferredMovies::findAllByUserId($Id) == NULL ? new PartnersPreferredMovies() : PartnersPreferredMovies::findAllByUserId($Id);
            $PartnersFamilyALevel = PartnersFamilyAffluenceLevel::findAllByUserId($Id) == NULL ? new PartnersFamilyAffluenceLevel() : PartnersFamilyAffluenceLevel::findAllByUserId($Id);
            $PartnersFamilyTypeS = PartnersFamilyType::findAllByUserId($Id) == NULL ? new PartnersFamilyType() : PartnersFamilyType::findAllByUserId($Id);
            $PartnersCountries = PartnersCountries::findAllByUserId($Id) == NULL ? new PartnersCountries() : PartnersCountries::findAllByUserId($Id);
            $PartnersStates = PartnersStates::findAllByUserId($Id) == NULL ? new PartnersStates() : PartnersStates::findAllByUserId($Id);
            $PartnersCities = PartnersCities::findAllByUserId($Id) == NULL ? new PartnersCities() : PartnersCities::findAllByUserId($Id);
            $UPP->scenario = UserPartnerPreference::SCENARIO_PREFERENCE;
            if ((Yii::$app->request->post() || Yii::$app->request->post('register11'))) {
                $CurrDate = CommonHelper::getTime();
                $UPP->iUser_id = $Id;
                $UPP->age_from = Yii::$app->request->post('UserPartnerPreference')['age_from'];
                $UPP->age_to = Yii::$app->request->post('UserPartnerPreference')['age_to'];
                $UPP->manglik = Yii::$app->request->post('UserPartnerPreference')['manglik'];
                $UPP->height_from = Yii::$app->request->post('UserPartnerPreference')['height_from'];
                $UPP->height_to = Yii::$app->request->post('UserPartnerPreference')['height_to'];
                $UPP->drink = Yii::$app->request->post('UserPartnerPreference')['drink'];
                $UPP->smoke = Yii::$app->request->post('UserPartnerPreference')['smoke'];
                $UPP->modified_on = $CurrDate;
                if (Yii::$app->request->post('UserPartnerPreference')['annual_income_from'] == '') {
                    $annual_income_from = 0;
                } else {
                    $annual_income_from = Yii::$app->request->post('UserPartnerPreference')['annual_income_from'];
                }
                if (Yii::$app->request->post('UserPartnerPreference')['annual_income_to'] == '') {
                    $annual_income_to = 0;
                } else {
                    $annual_income_to = Yii::$app->request->post('UserPartnerPreference')['annual_income_to'];
                }

                $UPP->annual_income_from = $annual_income_from;
                $UPP->annual_income_to = $annual_income_to;
                $UPP->LookingFor = Yii::$app->request->post('UserPartnerPreference')['LookingFor'];
                if ($UPP->validate()) {
                    $model->completed_step = $model->setCompletedStep('-1'); //25 For Partner Preferences
                    $model->save();
                    if ($UPP->ID == "") {
                        $UPP->created_on = $CurrDate;
                    }
                    $UPP->save();
                }

                $ReligionId = Yii::$app->request->post('PartenersReligion')['iReligion_ID'];
                PartnersReligion::deleteAll(['iUser_ID' => $Id]);
                if (count($ReligionId)) {
                    foreach ($ReligionId as $RK => $RV) {
                        $PRObj = new PartenersReligion();
                        $PRObj->iUser_ID = $Id;
                        $PRObj->iReligion_ID = $RV;
                        $PRObj->dtModified = $CurrDate;
                        $PRObj->dtCreated = $CurrDate;
                        $STK = $PRObj->save();
                    }
                }
                $PartenersReligion = PartenersReligion::findAllByUserId($Id);

                $MaritalStatusID = Yii::$app->request->post('PartnersMaritalStatus')['iMarital_Status_ID'];
                PartnersMaritalStatus::deleteAll(['iUser_ID' => $Id]);
                if (count($MaritalStatusID)) {
                    foreach ($MaritalStatusID as $RK => $RV) {
                        $PMSObj = new PartnersMaritalStatus();
                        $PMSObj->iUser_ID = $Id;
                        $PMSObj->iMarital_Status_ID = $RV;
                        $PMSObj->dtModified = $CurrDate;
                        $PMSObj->dtCreated = $CurrDate;
                        $STK = $PMSObj->save();
                    }
                }
                $PartnersMaritalStatus = PartnersMaritalStatus::findAllByUserId($Id);

                $GotraIDs = Yii::$app->request->post('PartnersGotra')['iGotra_ID'];
                PartnersGotra::deleteAll(['iUser_ID' => $Id]);
                if (count($GotraIDs)) {
                    foreach ($GotraIDs as $RK => $RV) {
                        $PGotraObj = new PartnersGotra();
                        $PGotraObj->iUser_ID = $Id;
                        $PGotraObj->iGotra_ID = $RV;
                        $PGotraObj->dtModified = $CurrDate;
                        $PGotraObj->dtCreated = $CurrDate;
                        $STK = $PGotraObj->save();
                    }
                }
                $PartnersGotra = PartnersGotra::findAllByUserId($Id);


                #if ($UPP->validate()) {

                #  }

                $RaashiID = Yii::$app->request->post('PartnersRaashi')['raashi_id'];
                if ($RaashiID != '') {
                    $PartnersRaashi->user_id = $Id;
                    $PartnersRaashi->raashi_id = $RaashiID;
                    $PartnersRaashi->modified_on = $CurrDate;
                    if ($PartnersRaashi->ID == "") {
                        $PartnersRaashi->created_on = $CurrDate;
                    }
                    $PartnersRaashi->save();
                }

                $CharanID = Yii::$app->request->post('PartnersCharan')['charan_id'];
                if ($CharanID != '') {
                    $PartnersCharan->user_id = $Id;
                    $PartnersCharan->charan_id = $CharanID;
                    $PartnersCharan->modified_on = $CurrDate;
                    if ($PartnersCharan->ID == "") {
                        $PartnersCharan->created_on = $CurrDate;
                    }
                    $PartnersCharan->save();
                }


                $NakshtraID = Yii::$app->request->post('PartnersNakshtra')['nakshtra_id'];
                if ($NakshtraID != '') {
                    $PartnersNakshtra->user_id = $Id;
                    $PartnersNakshtra->nakshtra_id = $NakshtraID;
                    $PartnersNakshtra->modified_on = $CurrDate;
                    if ($PartnersNakshtra->ID == "") {
                        $PartnersNakshtra->created_on = $CurrDate;
                    }
                    $PartnersNakshtra->save();
                }


                $NadiID = Yii::$app->request->post('PartnersNadi')['nadi_id'];
                if ($NadiID != '') {
                    $PartnersNadi->user_id = $Id;
                    $PartnersNadi->nadi_id = $NadiID;
                    $PartnersNadi->modified_on = $CurrDate;
                    if ($PartnersNadi->ID == "") {
                        $PartnersNadi->created_on = $CurrDate;
                    }
                    $PartnersNadi->save();
                }


                $MotherID = Yii::$app->request->post('PartnersMothertongue')['iMothertongue_ID'];
                if ($MotherID !== '') {
                    $PartnersMothertongue->scenario = PartnersMothertongue::SCENARIO_ADD;
                    $PartnersMothertongue->iUser_ID = $Id;
                    $PartnersMothertongue->iMothertongue_ID = $MotherID;
                    $PartnersMothertongue->dtModified = $CurrDate;
                    if ($PartnersMothertongue->iPartners_Mothertongue_ID == "") {
                        $PartnersMothertongue->dtCreated = $CurrDate;
                    }
                    $PartnersMothertongue->save();
                }


                $SkinToneIDs = Yii::$app->request->post('PartnersSkinTone')['iSkin_Tone_ID'];
                PartnersSkinTone::deleteAll(['iUser_ID' => $Id]);
                if (count($SkinToneIDs)) {
                    foreach ($SkinToneIDs as $RK => $RV) {
                        $PSkinToneObj = new PartnersSkinTone();
                        $PSkinToneObj->iUser_ID = $Id;
                        $PSkinToneObj->iSkin_Tone_ID = $RV;
                        $STK = $PSkinToneObj->save();
                    }
                }
                $PartnersSkinTone = PartnersSkinTone::findAllByUserId($Id);

                $BodyTypeIDs = Yii::$app->request->post('PartnersBodyType')['iBody_Type_ID'];
                PartnersBodyType::deleteAll(['iUser_ID' => $Id]);
                if (count($BodyTypeIDs)) {
                    foreach ($BodyTypeIDs as $RK => $RV) {
                        $PBodyTypeObj = new PartnersBodyType();
                        $PBodyTypeObj->iUser_ID = $Id;
                        $PBodyTypeObj->iBody_Type_ID = $RV;
                        $STK = $PBodyTypeObj->save();
                    }
                }
                $PartnersBodyType = PartnersBodyType::findAllByUserId($Id);

                $DietIDs = Yii::$app->request->post('PartnersDiet')['diet_id'];
                PartnersDiet::deleteAll(['user_id' => $Id]);
                if (count($DietIDs)) {
                    foreach ($DietIDs as $RK => $RV) {
                        $PDietObj = new PartnersDiet();
                        $PDietObj->user_id = $Id;
                        $PDietObj->diet_id = $RV;
                        $STK = $PDietObj->save();
                    }
                }
                $PartnersDiet = PartnersDiet::findAllByUserId($Id);

                $SpectaclesTypes = Yii::$app->request->post('PartnersSpectacles')['type'];
                PartnersSpectacles::deleteAll(['user_id' => $Id]);
                if (count($SpectaclesTypes)) {
                    foreach ($SpectaclesTypes as $RK => $RV) {
                        $PSpectaclesObj = new PartnersSpectacles();
                        $PSpectaclesObj->user_id = $Id;
                        $PSpectaclesObj->type = $RV;
                        $STK = $PSpectaclesObj->save();
                    }
                }
                $PartnersSpectacles = PartnersSpectacles::findAllByUserId($Id);

                $SmokeTypes = Yii::$app->request->post('PartnersSmoke')['smoke_type'];
                PartnersSmoke::deleteAll(['user_id' => $Id]);
                if (count($SmokeTypes)) {
                    foreach ($SmokeTypes as $RK => $RV) {
                        $PSmokeObj = new PartnersSmoke();
                        $PSmokeObj->user_id = $Id;
                        $PSmokeObj->smoke_type = $RV;
                        $STK = $PSmokeObj->save();
                    }
                }
                $PartnersSmoke = PartnersSmoke::findAllByUserId($Id);

                $DrinkTypes = Yii::$app->request->post('PartnersDrink')['drink_type'];
                PartnersDrink::deleteAll(['user_id' => $Id]);
                if (count($DrinkTypes)) {
                    foreach ($DrinkTypes as $RK => $RV) {
                        $PDrinkObj = new PartnersDrink();
                        //  $PDrinkObj->scenario = PartnersDrink::SCENARIO_PREF;
                        $PDrinkObj->user_id = $Id;
                        $PDrinkObj->drink_type = $RV;
                        $STK = $PDrinkObj->save();
                    }
                }
                $PartnersDrink = PartnersDrink::findAllByUserId($Id);

                $CommunityID = Yii::$app->request->post('PartnersCommunity')['iCommunity_ID'];
                PartnersCommunity::deleteAll(['iUser_ID' => $Id]);
                if (count($CommunityID)) {
                    foreach ($CommunityID as $RK => $RV) {
                        $PartnersCommunity = new PartnersCommunity();
                        $PartnersCommunity->scenario = PartnersCommunity::SCENARIO_ADD;
                        $PartnersCommunity->iUser_ID = $Id;
                        $PartnersCommunity->iCommunity_ID = $RV;
                        $STK = $PartnersCommunity->save();
                    }
                }
                $PartnersCommunity = PartnersCommunity::findAllByUserId($Id);

                $SubCommuIDs = Yii::$app->request->post('PartnersSubcommunity')['iSub_Community_ID'];
                PartnersSubcommunity::deleteAll(['iUser_ID' => $Id]);
                if (count($SubCommuIDs)) {
                    foreach ($SubCommuIDs as $RK => $RV) {
                        $PartnersSubCommunity = new PartnersSubcommunity();
                        $PartnersSubCommunity->scenario = PartnersSubcommunity::SCENARIO_ADD;
                        $PartnersSubCommunity->iUser_ID = $Id;
                        $PartnersSubCommunity->iSub_Community_ID = $RV;
                        $STK = $PartnersSubCommunity->save();
                    }
                }
                $PartnersSubCommunity = PartnersSubcommunity::findAllByUserId($Id);
                $EducationLevelIDs = Yii::$app->request->post('PartnersEducationalLevel')['iEducation_Level_ID'];
                PartnersEducationalLevel::deleteAll(['iUser_ID' => $Id]);
                if (count($EducationLevelIDs)) {
                    foreach ($EducationLevelIDs as $RK => $RV) {
                        $PEduLvlObj = new PartnersEducationalLevel();
                        $PEduLvlObj->iUser_ID = $Id;
                        $PEduLvlObj->iEducation_Level_ID = $RV;
                        $STK = $PEduLvlObj->save();
                    }
                }
                $PartnersEducationalLevel = PartnersEducationalLevel::findAllByUserId($Id);

                $EducationFieldIDs = Yii::$app->request->post('PartnersEducationField')['iEducation_Field_ID'];
                PartnersEducationField::deleteAll(['iUser_ID' => $Id]);
                if (count($EducationFieldIDs)) {
                    foreach ($EducationFieldIDs as $RK => $RV) {
                        $PEduFieldObj = new PartnersEducationField();
                        $PEduFieldObj->iUser_ID = $Id;
                        $PEduFieldObj->iEducation_Field_ID = $RV;
                        $STK = $PEduFieldObj->save();
                    }
                }
                $PartnersEducationField = PartnersEducationField::findAllByUserId($Id);


                $WorkingAsIDs = Yii::$app->request->post('PartnerWorkingAs')['iWorking_As_ID'];
                PartnerWorkingAs::deleteAll(['iUser_ID' => $Id]);
                if (count($WorkingAsIDs)) {
                    foreach ($WorkingAsIDs as $RK => $RV) {
                        $PWorkingAsObj = new PartnerWorkingAs();
                        $PWorkingAsObj->iUser_ID = $Id;
                        $PWorkingAsObj->iWorking_As_ID = $RV;
                        $STK = $PWorkingAsObj->save();
                    }
                }
                $PartnerWorkingAS = PartnerWorkingAs::findAllByUserId($Id);

                $WorkingWithIDs = Yii::$app->request->post('PartnerWorkingWith')['iWorking_With_ID'];
                PartnerWorkingWith::deleteAll(['iUser_ID' => $Id]);
                if (count($WorkingWithIDs)) {
                    foreach ($WorkingWithIDs as $RK => $RV) {
                        $PWorkingWithObj = new PartnerWorkingWith();
                        $PWorkingWithObj->iUser_ID = $Id;
                        $PWorkingWithObj->iWorking_With_ID = $RV;
                        $STK = $PWorkingWithObj->save();
                    }
                }
                $PartnerWorkingWith = PartnerWorkingWith::findAllByUserId($Id);

                $InterestIDs = Yii::$app->request->post('PartnersInterest')['interest_id'];
                PartnersInterest::deleteAll(['user_id' => $Id]);
                if (count($InterestIDs)) {
                    foreach ($InterestIDs as $RK => $RV) {
                        $PInterestObj = new PartnersInterest();
                        $PInterestObj->user_id = $Id;
                        $PInterestObj->interest_id = $RV;
                        $STK = $PInterestObj->save();
                    }
                }
                $PartnersInterest = PartnersInterest::findAllByUserId($Id);

                $ReadsIDs = Yii::$app->request->post('PartnersFavouriteReads')['read_id'];
                PartnersFavouriteReads::deleteAll(['user_id' => $Id]);
                if (count($ReadsIDs)) {
                    foreach ($ReadsIDs as $RK => $RV) {
                        $PReadsObj = new PartnersFavouriteReads();
                        $PReadsObj->user_id = $Id;
                        $PReadsObj->read_id = $RV;
                        $STK = $PReadsObj->save();
                    }
                }
                $PartnersReads = PartnersFavouriteReads::findAllByUserId($Id);

                $MusicIDs = Yii::$app->request->post('PartnersFavouriteMusic')['music_name_id'];
                PartnersFavouriteMusic::deleteAll(['user_id' => $Id]);
                if (count($MusicIDs)) {
                    foreach ($MusicIDs as $RK => $RV) {
                        $PMusicObj = new PartnersFavouriteMusic();
                        $PMusicObj->user_id = $Id;
                        $PMusicObj->music_name_id = $RV;
                        $STK = $PMusicObj->save();
                    }
                }
                $PartnersMusic = PartnersFavouriteMusic::findAllByUserId($Id);

                $CousinsIDs = Yii::$app->request->post('PartnersFavouriteCousines')['cousines_id'];
                PartnersFavouriteCousines::deleteAll(['user_id' => $Id]);
                if (count($CousinsIDs)) {
                    foreach ($CousinsIDs as $RK => $RV) {
                        $PCousinsObj = new PartnersFavouriteCousines();
                        $PCousinsObj->user_id = $Id;
                        $PCousinsObj->cousines_id = $RV;
                        $STK = $PCousinsObj->save();
                    }
                }
                $PartnersCousins = PartnersFavouriteCousines::findAllByUserId($Id);

                $FitnessIDs = Yii::$app->request->post('PartnersFitnessActivities')['fitness_id'];
                PartnersFitnessActivities::deleteAll(['user_id' => $Id]);
                if (count($FitnessIDs)) {
                    foreach ($FitnessIDs as $RK => $RV) {
                        $PFitnessObj = new PartnersFitnessActivities();
                        $PFitnessObj->user_id = $Id;
                        $PFitnessObj->fitness_id = $RV;
                        $STK = $PFitnessObj->save();
                    }
                }
                $PartnersFitnessActivity = PartnersFitnessActivities::findAllByUserId($Id);

                $DressStyleIDs = Yii::$app->request->post('PartnersPreferredDressType')['dress_style_id'];
                PartnersPreferredDressType::deleteAll(['user_id' => $Id]);
                if (count($DressStyleIDs)) {
                    foreach ($DressStyleIDs as $RK => $RV) {
                        $PDressStyleObj = new PartnersPreferredDressType();
                        $PDressStyleObj->user_id = $Id;
                        $PDressStyleObj->dress_style_id = $RV;
                        $STK = $PDressStyleObj->save();
                    }
                }
                $PartnersDressStyle = PartnersPreferredDressType::findAllByUserId($Id);

                $MoviesIDs = Yii::$app->request->post('PartnersPreferredMovies')['movie_id'];
                PartnersPreferredMovies::deleteAll(['user_id' => $Id]);
                if (count($MoviesIDs)) {
                    foreach ($MoviesIDs as $RK => $RV) {
                        $PMoviesObj = new PartnersPreferredMovies();
                        $PMoviesObj->user_id = $Id;
                        $PMoviesObj->movie_id = $RV;
                        $STK = $PMoviesObj->save();
                    }
                }
                $PartnersMovies = PartnersPreferredMovies::findAllByUserId($Id);

                $FamilyALevelIDs = Yii::$app->request->post('PartnersFamilyAffluenceLevel')['family_affluence_level_id'];
                PartnersFamilyAffluenceLevel::deleteAll(['user_id' => $Id]);
                if (count($FamilyALevelIDs)) {
                    foreach ($FamilyALevelIDs as $RK => $RV) {
                        $PFamilyLevelObj = new PartnersFamilyAffluenceLevel();
                        $PFamilyLevelObj->user_id = $Id;
                        $PFamilyLevelObj->family_affluence_level_id = $RV;
                        $STK = $PFamilyLevelObj->save();

                    }
                }
                $PartnersFamilyALevel = PartnersFamilyAffluenceLevel::findAllByUserId($Id);

                $FamilyTypeIDs = Yii::$app->request->post('PartnersFamilyType')['family_type'];
                PartnersFamilyType::deleteAll(['user_id' => $Id]);
                if (count($FamilyTypeIDs)) {
                    foreach ($FamilyTypeIDs as $RK => $RV) {
                        $PartnersFamilyTypeS = new PartnersFamilyType();
                        $PartnersFamilyTypeS->user_id = $Id;
                        $PartnersFamilyTypeS->family_type = $RV;
                        $STK = $PartnersFamilyTypeS->save();
                    }
                }
                $PartnersFamilyTypeS = PartnersFamilyType::findAllByUserId($Id);
                $CountryIDs = Yii::$app->request->post('PartnersCountries')['country_id'];
                PartnersCountries::deleteAll(['user_id' => $Id]);
                if (count($CountryIDs)) {
                    foreach ($CountryIDs as $RK => $RV) {
                        $PartnersCountries = new PartnersCountries();
                        $PartnersCountries->scenario = PartnersCountries::SCENARIO_ADD;
                        $PartnersCountries->user_id = $Id;
                        $PartnersCountries->country_id = $RV;
                        $STK = $PartnersCountries->save();
                    }
                }
                $PartnersCountries = PartnersCountries::findAllByUserId($Id);

                $StateIDs = Yii::$app->request->post('PartnersStates')['state_id'];
                PartnersStates::deleteAll(['user_id' => $Id]);
                if (count($StateIDs)) {
                    foreach ($StateIDs as $RK => $RV) {
                        $PartnersStates = new PartnersStates();
                        $PartnersStates->scenario = PartnersStates::SCENARIO_ADD;
                        $PartnersStates->user_id = $Id;
                        $PartnersStates->state_id = $RV;
                        $STK = $PartnersStates->save();
                    }
                }
                $PartnersStates = PartnersStates::findAllByUserId($Id);

                $CitiesIDs = Yii::$app->request->post('PartnersCities')['city_id'];
                PartnersCities::deleteAll(['user_id' => $Id]);
                if (count($CitiesIDs)) {
                    foreach ($CitiesIDs as $RK => $RV) {
                        $PartnersCities = new PartnersCities();
                        $PartnersCities->scenario = PartnersCities::SCENARIO_ADD;
                        $PartnersCities->user_id = $Id;
                        $PartnersCities->city_id = $RV;
                        $STK = $PartnersCities->save();
                    }
                }
                $PartnersCities = PartnersCities::findAllByUserId($Id);

                return $this->redirect([Yii::$app->params['userDashboard']]);
                exit;
            }
            $PartenersReligionIDs = CommonHelper::convertArrayToString($PartenersReligion, 'iReligion_ID');
            $PartnersMaritalPreferences = CommonHelper::convertArrayToString($PartnersMaritalStatus, 'iMarital_Status_ID');
            $PartnersGotraPreferences = CommonHelper::convertArrayToString($PartnersGotra, 'iGotra_ID');
            $PartnersSkinTone = CommonHelper::convertArrayToString($PartnersSkinTone, 'iSkin_Tone_ID');
            $PartnersBodyType = CommonHelper::convertArrayToString($PartnersBodyType, 'iBody_Type_ID');
            $PartnersDiet = CommonHelper::convertArrayToString($PartnersDiet, 'diet_id');
            $PartnersSpectacles = CommonHelper::convertArrayToString($PartnersSpectacles, 'type');
            $PartnersSmoke = CommonHelper::convertArrayToString($PartnersSmoke, 'smoke_type');
            $PartnersDrink = CommonHelper::convertArrayToString($PartnersDrink, 'drink_type');
            $PartnersCommunity = CommonHelper::convertArrayToString($PartnersCommunity, 'iCommunity_ID');
            $PartnersSubCommunity = CommonHelper::convertArrayToString($PartnersSubCommunity, 'iSub_Community_ID');
            $PartenersEduLevelArray = CommonHelper::convertArrayToString($PartnersEducationalLevel, 'iEducation_Level_ID');
            $PartenersEduFieldArray = CommonHelper::convertArrayToString($PartnersEducationField, 'iEducation_Field_ID');
            $PartenersWorkingAsArray = CommonHelper::convertArrayToString($PartnerWorkingAS, 'iWorking_As_ID');
            $PartenersWorkingWithArray = CommonHelper::convertArrayToString($PartnerWorkingWith, 'iWorking_With_ID');
            $PartenersInterestArray = CommonHelper::convertArrayToString($PartnersInterest, 'interest_id');
            $PartenersFavReadsArray = CommonHelper::convertArrayToString($PartnersReads, 'read_id');
            $PartenersMusicArray = CommonHelper::convertArrayToString($PartnersMusic, 'music_name_id');
            $PartenersCousinsArray = CommonHelper::convertArrayToString($PartnersCousins, 'cousines_id');
            $PartenersFitnessArray = CommonHelper::convertArrayToString($PartnersFitnessActivity, 'fitness_id');
            $PartenersDressStyleArray = CommonHelper::convertArrayToString($PartnersDressStyle, 'dress_style_id');
            $PartenersMoviesArray = CommonHelper::convertArrayToString($PartnersMovies, 'movie_id');
            $PartnersFamilyALevel = CommonHelper::convertArrayToString($PartnersFamilyALevel, 'family_affluence_level_id');
            $PartnersFamilyTypeS = CommonHelper::convertArrayToString($PartnersFamilyTypeS, 'family_type');
            $PartnersCountries = CommonHelper::convertArrayToString($PartnersCountries, 'country_id');

#CommonHelper::pr($PartnersCountries);exit;
            $PartnersStates = CommonHelper::convertArrayToString($PartnersStates, 'state_id');
            # CommonHelper::pr($PartnersStates);exit;
            $PartnersCities = CommonHelper::convertArrayToString($PartnersCities, 'city_id');

            return $this->render('partner_preferences', [
                'PartenersReligion' => $PartenersReligion,
                'PartenersReligionIDs' => $PartenersReligionIDs,
                'PartnersMaritalPreferences' => $PartnersMaritalPreferences,
                'PartnersGotraPreferences' => $PartnersGotraPreferences,
                'model' => $model,
                'UPP' => $UPP,
                'PartnersMaritalStatus' => $PartnersMaritalStatus,
                'PartnersGotra' => $PartnersGotra,
                'PartnersMothertongue' => $PartnersMothertongue,
                'PartnersCommunity' => $PartnersCommunity,
                'PartnersSubCommunity' => $PartnersSubCommunity,
                'show' => $show,
                'PartnersRaashi' => $PartnersRaashi,
                'PartnersCharan' => $PartnersCharan,
                'PartnersNakshtra' => $PartnersNakshtra,
                'PartnersNadi' => $PartnersNadi,
                'PartnersSkinTone' => $PartnersSkinTone,
                'PartnersBodyType' => $PartnersBodyType,
                'PartnersDiet' => $PartnersDiet,
                'PartnersSpectacles' => $PartnersSpectacles,
                'PartnersSmoke' => $PartnersSmoke,
                'PartnersDrink' => $PartnersDrink,
                'PartenersEduLevelArray' => $PartenersEduLevelArray,
                'PartenersEduFieldArray' => $PartenersEduFieldArray,
                'PartenersWorkingAsArray' => $PartenersWorkingAsArray,
                'PartenersWorkingWithArray' => $PartenersWorkingWithArray,
                'AI' => $AI,
                'PartenersInterestArray' => $PartenersInterestArray,
                'PartenersFavReadsArray' => $PartenersFavReadsArray,
                'PartenersMusicArray' => $PartenersMusicArray,
                'PartenersCousinsArray' => $PartenersCousinsArray,
                'PartenersFitnessArray' => $PartenersFitnessArray,
                'PartenersDressStyleArray' => $PartenersDressStyleArray,
                'PartenersMoviesArray' => $PartenersMoviesArray,
                'PartnersFamilyALevel' => $PartnersFamilyALevel,
                'PartnersFamilyTypeS' => $PartnersFamilyTypeS,
                'PartnersStates' => $PartnersStates,
                'PartnersCountries' => $PartnersCountries,
                'PartnersCities' => $PartnersCities,
                'CountryIDs' => $CountryIDs,
                'StatesIDs' => $StatesIDs,
            ]);
        } else {
            return $this->redirect(Yii::getAlias('@web'));
        }
    }

    public function actionAboutFamily($id='')
    {
        if (!Yii::$app->user->isGuest) {
            #$id = base64_decode($id);
            $id = Yii::$app->user->identity->id;
            if($model = User::findOne($id)){
                $model->scenario = User::SCENARIO_REGISTER4;
                if($model->load(Yii::$app->request->post())){
                    #echo "<pre>"; print_r($model->scenario);exit;
                    $vFamilyProperty_ARRAY = Yii::$app->request->post('User');

                    if(is_array($vFamilyProperty_ARRAY['vFamilyProperty'])){
                        $model->vFamilyProperty = implode(",",$vFamilyProperty_ARRAY['vFamilyProperty']);
                    }
                    else {
                        $model->vFamilyProperty = '';
                    }

                    $model->completed_step = $model->setCompletedStep('5');
                    if (Yii::$app->request->post('User')['iCountryCAId'] != 101) {
                        $model->iDistrictCAID = 1;
                        $model->iTalukaCAID = 1;
                    }

                    if($model->save()){
                        $this->redirect(['site/about-yourself']);
                    }
                }
                return $this->render('register4',[
                    'model' => $model,
                    'CurrentStep' => 5,
                ]);

            }else{
                return $this->redirect(Yii::getAlias('@web'));
            }
        }else{
            return $this->redirect(Yii::getAlias('@web'));
        }

    }

    public function actionAboutYourself($ref = '')
    {
        if (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->identity->id;
            if($model = User::findOne($id)){
                $tYourSelf_old = $model->tYourSelf;
                $model->scenario = User::SCENARIO_REGISTER5;
                if($model->load(Yii::$app->request->post())){
                    $model->completed_step = $model->setCompletedStep('6');
                    if (strcmp($tYourSelf_old, $model->tYourSelf) !== 0) {
                        $model->eStatusInOwnWord = 'Pending';
                    }
                    if($model->save()){
                        $PhotoSection = \common\models\User::weightedCheck(7);
                        if ($PhotoSection || Yii::$app->user->identity->propic != '') {
                            $this->redirect(['/photos']);
                        } else {
                            $this->redirect(['/about-yourself', 'ref' => 'first']);
                        }
                    }
                }
                return $this->render('register5',[
                    'model' => $model,
                    'CurrentStep' => 6,
                    'ref' => $ref
                ]);
            }else{
                return $this->redirect(Yii::getAlias('@web'));
            }
        }else{
            return $this->redirect(Yii::getAlias('@web'));
        }

    }
    public function actionMyPhotos($id='')
    {
        if (!Yii::$app->user->isGuest) {
            #$id = base64_decode($id);
            $id = Yii::$app->user->identity->id;
            #   $id = base64_decode($id);
            if($model = User::findOne($id)){

                $model->scenario = User::SCENARIO_REGISTER6;
                $target_dir = Yii::getAlias('@web').'/uploads/';
                if(Yii::$app->request->post()){
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
                        $this->redirect(['/verification']);
                    }
                }
                if($model->propic !='')
                    $model->propic = $target_dir.$model->propic;
                return $this->render('register6',[
                    'model' => $model
                ]);
            }else{
                return $this->redirect(Yii::getAlias('@web'));
            }

        }else{
            return $this->redirect(Yii::getAlias('@web'));
        }

    }

    public function actionPhotoupload($id){
        if (Yii::$app->user->isGuest) {
            return $this->goHome();
        }
        $id = base64_decode($id);

        if($model = User::findOne($id)){
            #echo "<pre>"; print_r(":hiiii");exit;

            $model->scenario = User::SCENARIO_REGISTER6;
            #if($model->load(Yii::$app->request->post())){

            $target_dir = Yii::getAlias('@frontend') .'/web/uploads/';
            $target_file = $target_dir . basename($_FILES["fileInput"]["name"]);
            if ($_FILES['fileInput']['name'] !='') {
                // Start
                #$PHOTO_NAME = $generalfuncobj->photoUpload($iUserId,$_FILES['vPhotoCard'],$PATH,$URL,$VISITING_CARD_SIZE_ARRAY,'');
                $CM_HELPER = new CommonHelper();
                $PATH = $CM_HELPER->getUserUploadFolder(1) . "/" . $id . "/";
                $URL = $CM_HELPER->getUserUploadFolder(2) . "/" . $id . "/";
                $USER_SIZE_ARRAY = $CM_HELPER->getUserResizeRatio();
                $OLD_PHOTO = $model->propic;
                $PHOTO_ARRAY = CommonHelper::photoUpload($id, $_FILES['fileInput'], $PATH, $URL, $USER_SIZE_ARRAY, $OLD_PHOTO);
                #echo "<pre>"; print_r($PHOTO_ARRAY);
                #exit;
                // END
                $model->propic = $PHOTO_ARRAY['PHOTO'];//$_FILES['fileInput']['name'];
                $model->eStatusPhotoModify = 'Pending';
                /*if (move_uploaded_file($_FILES["fileInput"]["tmp_name"], $target_file)) {

                    echo "The file ". basename( $_FILES["fileInput"]["name"]). " has been uploaded.";
                } else {
                    echo "Sorry, there was an error uploading your file.";
                }*/
                //var_dump(fileInput);
                if ($model->save()) {
                }
            }
            #}

        }else{
            return $this->redirect(Yii::getAlias('@web'));
        }
    }

    public function actionVerification($id='',$msg='')
    {
        if (!Yii::$app->user->isGuest) {
            #$id = base64_decode($id);
            $id = Yii::$app->user->identity->id;
            #$id = base64_decode($id);
            if($model = User::findOne($id)){
                if ($model->eEmailVerifiedStatus == 'Yes' && Yii::$app->user->identity->ePhoneVerifiedStatus == 'Yes') {
                    $TempArray = explode(",", Yii::$app->user->identity->completed_step);
                    /*if (!in_array('-1', $TempArray)) {
                        echo " asdasdasd";exit;
                        return $this->redirect(['site/partner-preferences']);
                        exit;
                    }*/
                }

                $model->scenario = User::SCENARIO_REGISTER7;
                $model1 = User::findOne($id);
                $model1->scenario = User::SCENARIO_REGISTER8;
                if($model->load(Yii::$app->request->post())){
                    #echo "<pre>";print_r(Yii::$app->request->post());echo "</pre>";
                    $USERARRAY = Yii::$app->request->post('User');
                    $PIN = $USERARRAY['email_pin'];
                    if($PIN !=''){
                        if($model->pin_email_vaerification == $PIN){
                            $model->eEmailVerifiedStatus = 'Yes';
                            $model->completed_step = $model->setCompletedStep('9');
                            $model->save($model);
                            #$this->redirect(['user/dashboard','id'=>base64_encode($id)]);
                            $model->email_verification_msg = 'Successfully Verified.';
                            $model->error_class = 'SUCCESS';
                            return $this->render('register7', [
                                'model' => $model
                            ]);
                        }else{
                            $model->email_verification_msg = 'Incorrect PIN. Please Enter Valid PIN.';
                            $model->error_class = 'error';
                            return $this->render('register7',[
                                'model' => $model
                            ]);
                            //Oops! Please ensure all fields are valid
                        }
                    }
                }
                if($msg !='') {
                    $model->email_verification_msg = $msg;
                    $model->error_class = 'success';
                }

                return $this->render('register7',[
                    'model' => $model,
                    'model1' => $model1
                ]);

            }else{
                return $this->redirect(Yii::getAlias('@web'));
            }
        }else{
            return $this->redirect(Yii::getAlias('@web'));
        }


    }

    public function actionResendEmailPin($id = '')
    {
        $STATUS = $MESSAGE = '';
        if (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->identity->id;
            if($model = User::findOne($id)){
                $model->scenario = User::SCENARIO_REGISTER6;
                $PIN = CommonHelper::generateNumericUniqueToken(4);
                $model->pin_email_vaerification = $PIN;
                if ($model->save($model)) {
                    $MAIL_DATA = array("EMAIL" => $model->email, "EMAIL_TO" => $model->email, "NAME" => $model->First_Name . " " . $model->Last_Name, "PIN" => $PIN);
                    $MAIL_STATUS = MailHelper::SendMail('EMAIL_VERIFICATION_PIN', $MAIL_DATA);
                    if ($MAIL_STATUS) {
                        list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'PIN_RESEND_FOR_EMAIL');
                    } else {
                        list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PIN_RESEND_FOR_EMAIL');
                    }
                }

            }else{
                return $this->redirect(Yii::getAlias('@web'));
            }
        }else{
            return $this->redirect(Yii::getAlias('@web'));
        }
        $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE);
        return json_encode($return);

    }
    public function actionVerificationEmailPin()
    {
        $STATUS = $MESSAGE = '';
        if (!Yii::$app->user->isGuest) {
            $id = Yii::$app->user->identity->id;
            if ($model = User::findOne($id)) {
                #$model->scenario = User::SCENARIO_REGISTER7;
                #$USERARRAY = Yii::$app->request->post('User');
                #$PIN = $USERARRAY['PHONE_PIN'];
                $PIN = $_REQUEST['EMAIL_PIN'];
                if ($PIN != '') {
                    if ($model->pin_email_vaerification == $PIN) {
                        $model->eEmailVerifiedStatus = 'Yes';
                        $model->completed_step = $model->setCompletedStep('9');
                        if ($model->save($model)) {
                            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('S', 'EMAIL_VERIFICATION');
                        } else {
                            list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'EMAIL_VERIFICATION');
                        }
                        if ($model->ePhoneVerifiedStatus == 'Yes') {
                            $this->redirect(['/dashboard', 'type' => base64_encode("VERIFICATION-DONE")]);
                        }
                    } else {
                        list($STATUS, $MESSAGE, $TITLE) = MessageHelper::getMessageNotification('E', 'PIN_INCORRECT_FOR_EMAIL');
                    }
                } else {
                    $MESSAGE = 'Please Enter PIN.';
                    $STATUS = 'ERROR';
                    $TITLE = 'Information';
                }
                $return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'TITLE' => $TITLE);
                return json_encode($return);
            } else {
                return $this->redirect(Yii::getAlias('@web'));
            }
        } else {
            return $this->redirect(Yii::getAlias('@web'));
        }


    }

}