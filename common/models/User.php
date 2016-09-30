<?php
namespace common\models;

use common\components\CommonHelper;
use Yii;
use yii\base\NotSupportedException;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;

/**
 * User model
 *
 * @property integer $id
 * @property string $username
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property string $auth_key
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $password write-only password
 */

class User extends \common\models\base\baseUser implements IdentityInterface
{
    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 1;
    const STATUS_INACTIVE = 2;
    const STATUS_PENDING = 3;
    const STATUS_DISAPPROVE = 4;
    const STATUS_APPROVE = 5;
    const STATUS_BLOCK = 6;

    const SCENARIO_LOGIN = 'login';
    const SCENARIO_REGISTER = 'register';
    const SCENARIO_REGISTER1 = 'register1';
    const SCENARIO_REGISTER2 = 'register2';
    const SCENARIO_REGISTER3 = 'register3';
    const SCENARIO_REGISTER4 = 'register4';
    const SCENARIO_REGISTER5 = 'register5';
    const SCENARIO_REGISTER6 = 'register6';
    const SCENARIO_REGISTER7 = 'register7';
    const SCENARIO_REGISTER8 = 'register8';
    const SCENARIO_REGISTER9 = 'register9';
    const SCENARIO_FP = 'Forgot Password';
    const SCENARIO_SFP = 'Set Forgot Password';
    const SCENARIO_FIRST_VERIFICATION = 'Firstverification';
    const SCENARIO_EDIT_MY_INFO = 'Edit My Info';
    const SCENARIO_EDIT_PERSONAL_INFO = 'Edit Personal Info';
    const SCENARIO_EDIT_LIFESTYLE = 'Edit Lyfestyle and Appearance';
    public $repeat_password;
    public $email_pin;
    public $phone_pin;
    public $email_verification_msg;
    public $error_class;
    public $commentInOwnWordsAdmin;
   // public $captcha;
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%user}}';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['id' => $id, 'status' => [self::STATUS_ACTIVE, self::STATUS_APPROVE]]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    /**
     * Finds user by username
     *
     * @param string $username
     * @return static|null
     */
    public static function findByUsername($username)
    {
        return static::findOne(['username' => $username, 'status' => [self::STATUS_ACTIVE, self::STATUS_APPROVE]]);
    }

    public static function findByEmail($email)
    {

        return static::findOne(['email' => $email]);
    }

    public static function checkEmailVerify($email)
    {
        return static::findOne(['email' => $email, 'status' => [self::STATUS_ACTIVE, self::STATUS_APPROVE]]);
    }

    /**
     * Finds user by password reset token
     *
     * @param string $token password reset token
     * @return static|null
     */
    public static function findByPasswordResetToken($token)
    {
        if (!static::isPasswordResetTokenValid($token)) {
            return null;
        }

        return static::findOne([
            'password_reset_token' => $token,
            'status' => [self::STATUS_ACTIVE, self::STATUS_APPROVE],
        ]);
    }

    /**
     * Finds out if password reset token is valid
     *
     * @param string $token password reset token
     * @return boolean
     */
    public static function isPasswordResetTokenValid($token)
    {
        if (empty($token)) {
            return false;
        }

        $timestamp = (int)substr($token, strrpos($token, '_') + 1);
        $expire = Yii::$app->params['user.passwordResetTokenExpire'];
        return $timestamp + $expire >= time();
    }

    /**
     * FOR GET STATUS NAME
     */
    public static function findByApprove($id)
    {
        #echo "========= ".$email;exit;
        #return static::findOne(['email' => $email]);
    }

    public static function wightegeCheck($type)
    {
        $iUserId = Yii::$app->user->identity->id;
        $USER = User::findOne($iUserId);

        $completed_step = $USER->completed_step;
        if ($type == 8) {
            if ($USER->ePhoneVerifiedStatus == 'Yes') {
                return 1;
            }
        }
        if ($type == 9) {
            if ($USER->eEmailVerifiedStatus == 'Yes') {
                return 1;
            }
        }
        $STEP_ARRAY = explode(",", $completed_step);
        if (in_array($type, $STEP_ARRAY)) {
            return 1;
        } else {
            return 0;
        }
    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_key', 'password_hash', 'email', 'created_at', 'updated_at', 'Registration_Number', 'Mobile', 'First_Name', 'Last_Name', 'DOB', 'Time_of_Birth', 'Age', 'Birth_Place', 'Marital_Status', 'iReligion_ID', 'iEducationLevelID', 'iEducationFieldID', 'iWorkingWithID', 'iWorkingAsID', 'iAnnualIncomeID', 'iCommunity_ID', 'county_code', 'iDistrictID', 'iMaritalStatusID', 'iTalukaID', 'iCountryId', 'iStateId', 'iCityId','Profile_created_for','repeat_password','Gender','toc','iHeightID','vSkinTone','vBodyType','vSmoke','vDrink','vDiet','iFatherStatusID','iMotherStatusID','nob','nos','iCountryCAId','iStateCAId','iDistrictCAID','iTalukaCAID','iCityCAId','vParentsResiding','mother_tongue','weight', 'phone_pin', 'email_pin'], 'required'],
            [['status', 'created_at', 'updated_at', 'Age', 'Marital_Status', 'iReligion_ID', 'iEducationLevelID', 'iEducationFieldID', 'iWorkingWithID', 'iWorkingAsID', 'iAnnualIncomeID', 'iCommunity_ID', 'iDistrictID', 'iGotraID', 'iMaritalStatusID'], 'integer'],
            [['Profile_created_for', 'Gender', 'eFirstVerificationMailStatus'], 'string'],
            [['DOB', 'Time_of_Birth','cnb','iSubCommunity_ID','vAreaName','iGotraID'], 'safe'],
            [['DOB'],'checkDobYear'],
            [['noc','nob','nos','weight'],'integer','integerOnly'=>true,'min' => 0],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['Registration_Number', 'Birth_Place'], 'string', 'max' => 250],
            [['Mobile'], 'string', 'max' => 20],
            [['First_Name', 'Last_Name'], 'string', 'max' => 100],
            [['county_code'], 'string', 'max' => 5],
            [['First_Name', 'Last_Name'], 'string', 'max' => 100],
            [['email_pin', 'phone_pin'], 'string', 'max' => 4, 'min' => 4],
            // [['username'], 'unique'],
             [['email'], 'unique'],
            //[['captcha'], \himiklab\yii2\recaptcha\ReCaptchaValidator::className(), 'secret' => '6Lc2xSgTAAAAAC37FZoNHA6KreseSCE5TrORJIbp'],
           // [['captcha'],'required'],
           // [['captcha'],'captcha'],
            [['email'], 'email'],
            [['password_hash','repeat_password'], 'string', 'length' => [6,255]],
            [['tYourSelf'], 'string','max' => '100'],
            [['tYourSelf'], 'required', 'on' => self::SCENARIO_EDIT_MY_INFO],
            [['repeat_password'],'compare','compareAttribute' => 'password_hash', 'message'=>"Passwords don't match"],
            [['password_reset_token'], 'unique'],
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_LOGIN => ['password_hash'],
            self::SCENARIO_REGISTER => ['email', 'password_hash', 'repeat_password', 'First_Name', 'Last_Name', 'DOB', 'Gender', 'Profile_created_for','Mobile','county_code','toc','Registration_Number'],
            self::SCENARIO_REGISTER1 => ['iReligion_ID','First_Name', 'Last_Name','iCommunity_ID', 'iSubCommunity_ID', 'iDistrictID', 'iGotraID', 'iMaritalStatusID', 'iTalukaID', 'iCountryId', 'iStateId', 'iCityId', 'noc', 'vAreaName','cnb'],
            self::SCENARIO_REGISTER2 => ['First_Name', 'Last_Name','iEducationLevelID', 'iEducationFieldID', 'iWorkingWithID', 'iWorkingAsID', 'iAnnualIncomeID'],
            self::SCENARIO_REGISTER3 => ['iHeightID', 'vSkinTone','vBodyType', 'vSmoke', 'vDrink', 'vSpectaclesLens', 'vDiet'],
            self::SCENARIO_EDIT_LIFESTYLE => ['iHeightID', 'vSkinTone','vBodyType', 'vSmoke', 'vDrink', 'vSpectaclesLens', 'vDiet','weight'],
            self::SCENARIO_REGISTER4 => ['completed_step','iFatherStatusID', 'iFatherWorkingAsID','iMotherStatusID', 'iMotherWorkingAsID','nob','nos','eSameAddress','iCountryCAId','iStateCAId','iDistrictCAID','iTalukaCAID','vAreaNameCA','iCityCAId','vNativePlaceCA','vParentsResiding','vFamilyAffluenceLevel','vFamilyType','vFamilyProperty','vDetailRelative'],
            self::SCENARIO_REGISTER5 => ['tYourSelf', 'vDisability','eStatusInOwnWord'],
            self::SCENARIO_REGISTER6 => ['propic', 'pin_email_vaerification', 'pin_phone_vaerification'],
            self::SCENARIO_REGISTER7 => ['email_pin', 'pin_email_vaerification', 'eEmailVerifiedStatus'],
            #self::SCENARIO_REGISTER7 => ['email_pin','phone_pin','pin_email_vaerification','eEmailVerifiedStatus','pin_phone_vaerification','ePhoneVerifiedStatus'],
            self::SCENARIO_REGISTER8 => ['phone_pin', 'pin_phone_vaerification', 'ePhoneVerifiedStatus'],
            self::SCENARIO_REGISTER9 => ['Mobile', 'county_code'],
            self::SCENARIO_FIRST_VERIFICATION => ['eFirstVerificationMailStatus'],
            self::SCENARIO_FP => ['email'],
            "default"=>array('id'),
            self::SCENARIO_FP => ['email','password_hash','password_reset_token'],
            self::SCENARIO_SFP => ['email','password_reset_token'],
            self::SCENARIO_EDIT_MY_INFO => ['tYourSelf'],
            self::SCENARIO_EDIT_PERSONAL_INFO => ['First_Name', 'Last_Name', 'DOB', 'Gender', 'Profile_created_for','Mobile','county_code','mother_tongue','Marital_Status'],
        ];

    }

    public function checkDobYear($attribute,$params)
    {
        $date1 = date('Y-m-d');
        $date2 = $this->DOB;
        $diff = abs(strtotime($date2) - strtotime($date1));
        $years = floor($diff / (365*60*60*24));

        if($this->Gender == 'FEMALE'){
            if($years < 18)
            $this->addError('DOB', 'Your age should be grater than 18 Years');
        }
        else {
            if($years < 21)
                $this->addError('DOB', 'Your age should be grater than 21 Years');
        }

    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'username' => 'Username',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password',
            'repeat_password' => 'Retype Password',
            'password_reset_token' => 'Password Reset Token',
            'email' => 'Email',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
            'Registration_Number' => 'Registration  Number',
            'Mobile' => 'Mobile',
            'Profile_created_for' => 'Profile Created For',
            'First_Name' => 'First  Name',
            'Last_Name' => 'Last  Name',
            'Gender' => 'Gender',
            'DOB' => 'Dob',
            'Time_of_Birth' => 'Time Of  Birth',
            'Age' => 'Age',
            'Birth_Place' => 'Birth  Place',
            'Marital_Status' => 'Marital  Status',
            'iReligion_ID' => 'Religion',
            'toc' => 'Tearms & Condition',
            'iEducationLevelID' => 'Education Level',
            'iEducationFieldID' => 'Education Field',
            'iWorkingWithID' => 'Working With',
            'iWorkingAsID' => 'Working As',
            'iAnnualIncomeID' => 'Annual Income',
            'county_code' => 'Country Code',
            'iCommunity_ID' => 'Community',
            'iSubCommunity_ID' => 'Sub Community',
            'iDistrictID' => 'District',
            'iGotraID' => 'Gotra',
            'iMaritalStatusID' => 'Marital Status',
            'iTalukaID' => 'Taluka',
            'iCountryId' => 'Country',
            'iStateId' => 'State',
            'iCityId' => 'City',
            'noc' => 'Number Of Children',
            'vAreaName' => 'Area Name',
            'cnb' => 'Caste No Bar',
            'iHeightID' => 'Height',
            'vSkinTone' => 'Skin Tone',
            'vBodyType' => 'Body Type',
            'vSmoke' => 'Smoke',
            'vDrink' => 'Drink',
            'vSpectaclesLens' => 'Spectacles Lens',
            'vDiet' => 'vDiet',
            'tYourSelf' => 'About Yourself',
            'propic' => 'Profile Pic',
            'vDisability' => 'Disability',
            'email_pin' => 'Email PIN',
            'phone_pin' => 'Phone PIN',
            'iFatherStatusID' => 'Father Status',
            'iFatherWorkingAsID' => 'Father Working As',
            'iMotherStatusID' => 'Mother Status',
            'iMotherWorkingAsID' => 'Mother Working As',
            'nob' => 'Number Of Brothers',
            'nos' => 'Number Of Sisters',
            'eSameAddress' => 'Same Address',
            'iCountryCAId' => 'Country',
            'iStateCAId' => 'State',
            'iDistrictCAID' => 'District',
            'iTalukaCAID' => 'Taluka',
            'vAreaNameCA' => 'Area Name',
            'iCityCAId' => 'City',
            'vNativePlaceCA' => 'Native Place',
            'vParentsResiding' => 'Parents Residing At',
            'vFamilyAffluenceLevel' => 'Family Affluence Level',
            'vFamilyType' => 'Family Type',
            'vFamilyProperty' => 'Family Property',
            'vDetailRelative' => 'Details About Relatives',
            'completed_step' => 'completed_step',
            'eEmailVerifiedStatus' => 'Email Verified Status',
            'ePhoneVerifiedStatus' => 'Phone Verified Status',
            'eStatusInOwnWord' => 'Status In Own Word',
            'eStatusPhotoModify' => 'Status Of Profile Pic',
            'weight' => 'Weight(in KG)'
        ];
    }

    /**
     * @inheritdoc
     */
    public function getId()
    {
        return $this->getPrimaryKey();
    }

    /**
     * @inheritdoc
     */
    public function validateAuthKey($authKey)
    {
        return $this->getAuthKey() === $authKey;
    }

    /**
     * @inheritdoc
     */
    public function getAuthKey()
    {
        return $this->auth_key;
    }

    /**
     * Validates password
     *
     * @param string $password password to validate
     * @return boolean if password provided is valid for current user
     */
    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->password_hash);
    }

    /**
     * Generates password hash from password and sets it to the model
     *
     * @param string $password
     */
    public function setPassword($password)
    {
        return Yii::$app->security->generatePasswordHash($password);
    }

    /**
     * Generates "remember me" authentication key
     */
    public function generateAuthKey()
    {
        $this->auth_key = Yii::$app->security->generateRandomString();
    }

    /**
     * Generates new password reset token
     */
    public function generatePasswordResetToken()
    {
        $this->password_reset_token = Yii::$app->security->generateRandomString() . '_' . time();
    }

    /**
     * Removes password reset token
     */
    public function removePasswordResetToken()
    {
        $this->password_reset_token = null;
    }

    public function getFullName(){
        return $this->First_Name.' '.$this->Last_Name;
    }

    public function getReligionName()
    {
        return $this->hasOne(Religion::className(), ['iReligion_ID' => 'iReligion_ID']);
    }

    public function getCommunityName()
    {
        return $this->hasOne(MasterCommunity::className(), ['iCommunity_ID' => 'iCommunity_ID']);
    }

    public function getSubCommunityName()
    {
        return $this->hasOne(MasterCommunitySub::className(), ['iSubCommunity_ID' => 'iSubCommunity_ID']);
    }

    public function getDistrictName()
    {
        return $this->hasOne(MasterDistrict::className(), ['iDistrictID' => 'iDistrictID']);
    }

    public function getGotraName()
    {
        return $this->hasOne(MasterGotra::className(), ['iGotraID' => 'iGotraID']);
    }

    public function getMaritalStatusName()
    {
        return $this->hasOne(MasterMaritalStatus::className(), ['iMaritalStatusID' => 'iMaritalStatusID']);
    }

    public function getTalukaName()
    {
        return $this->hasOne(MasterTaluka::className(), ['iTalukaID' => 'iTalukaID']);
    }

    public function getCountryName()
    {
        return $this->hasOne(Countries::className(), ['iCountryId' => 'iCountryId']);
    }

    public function getStateName()
    {
        return $this->hasOne(States::className(), ['iStateId' => 'iStateId']);
    }

    public function getCityName()
    {
        return $this->hasOne(Cities ::className(), ['iCityId' => 'iCityId']);
    }

    public function getCountryNameCA()
    {
        return $this->hasOne(Countries::className(), ['iCountryId' => 'iCountryCAId']);
    }

    public function getStateNameCA()
    {
        return $this->hasOne(States::className(), ['iStateId' => 'iStateCAId']);
    }

    public function getCityNameCA()
    {
        return $this->hasOne(Cities ::className(), ['iCityId' => 'iCityCAId']);
    }

    public function getDistrictNameCA()
    {
        return $this->hasOne(MasterDistrict::className(), ['iDistrictID' => 'iDistrictCAID']);
    }

    public function getTalukaNameCA()
    {
        return $this->hasOne(MasterTaluka::className(), ['iTalukaID' => 'iTalukaCAID']);
    }

    public function getNativePlaceCA()
    {
        #return $this->hasOne(Nati::className(), ['iTalukaID' => 'iTalukaCAID']);
    }

    public function getEducationLevelName()
    {
        return $this->hasOne(EducationLevel ::className(), ['iEducationLevelID' => 'iEducationLevelID']);
    }

    public function getEducationFieldName()
    {
        return $this->hasOne(EducationField ::className(), ['iEducationFieldID' => 'iEducationFieldID']);
    }

    public function getWorkingWithName()
    {
        return $this->hasOne(WorkingWith ::className(), ['iWorkingWithID' => 'iWorkingWithID']);
    }

    public function getWorkingAsName()
    {
        return $this->hasOne(WorkingAS ::className(), ['iWorkingAsID' => 'iWorkingAsID']);
    }

    public function getAnnualIncome()
    {
        return $this->hasOne(AnnualIncome ::className(), ['iAnnualIncomeID' => 'iAnnualIncomeID']);
    }

    public function getHeight()
    {
        return $this->hasOne(MasterHeight ::className(), ['iHeightID' => 'iHeightID']);
    }

    public function getDietName()
    {
        return $this->hasOne(MasterDiet ::className(), ['iDietID' => 'vDiet']);
    }

    public function getFatherStatus()
    {
        $ABC = $this->hasOne(MasterFmStatus ::className(), ['iFMStatusID' => 'iFatherStatusID']);

        return $ABC;
    }

    public function getFatherStatusId()
    {
        return $this->hasOne(WorkingAS ::className(), ['iWorkingAsID' => 'iFatherWorkingAsID']);
    }

    public function getMotherStatus()
    {
        $ABC = $this->hasOne(MasterFmStatus ::className(), ['iFMStatusID' => 'iMotherStatusID']);

        return $ABC;
    }

    public function getMotherStatusId()
    {
        return $this->hasOne(WorkingAS ::className(), ['iWorkingAsID' => 'iMotherWorkingAsID']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getICity()
    {
        return $this->hasOne(Cities::className(), ['iCityId' => 'iCityId']);
    }

    public function getMotherTongue()
    {
        return $this->hasOne(MotherTongue::className(), ['ID' => 'mother_tongue']);
    }

    function getUserInfo(){
        /*$query = new Query;
        $query	->select([
                'user.First_Name',
                'master_community.vName as  cName'
            ])
            ->from('user')
            ->join('LEFT JOIN', 'master_community',
                'master_community.iCommunity_ID  = user.iCommunity_ID')
            ->LIMIT(5)	;

        $command = $query->createCommand();
        print_r($query->createCommand()->getRawSql());exit;
        $data = $command->queryAll();*/
        $sql = 'SELECT * FROM user WHERE 1=1';
        $query = User::findBySql($sql)->all();
        #echo $query->createCommand()->sql;
        echo "<pre>"; print_r($query);
        exit;

    }

    public function getPermentAddress()
    {
        return $this->vAreaName.", ".$this->talukaName->vName.", ".$this->districtName->vName.", ".$this->cityName->vCityName.", ".$this->stateName->vStateName.", ".$this->countryName->vCountryName;
    }

    public function getCurrentAddress()
    {
        return $this->vAreaNameCA.", ".$this->talukaNameCA->vName.", ".$this->districtNameCA->vName.", ".$this->cityNameCA->vCityName.", ".$this->stateNameCA->vStateName.", ".$this->countryNameCA->vCountryName;
    }

    public function generateUniqueRandomNumber($length = 9) {
        $PREFIX = CommonHelper::generatePrefix();
        $RANDOM_USER_NUMBER = $PREFIX.CommonHelper::generateNumericUniqueToken($length);
        if(!$this->findOne(['Registration_Number' => $RANDOM_USER_NUMBER]))
            return $RANDOM_USER_NUMBER;
        else
            return $this->generateUniqueRandomNumber($length);

    }

    public function getDisplayMobile(){
        return ($this->county_code != '') ? $this->county_code . " " . $this->Mobile : $this->Mobile;
    }

    public function setCompletedStep($step) {
        $returnVal = $this->completed_step;
        if($returnVal==""){
            $returnVal = $step;
        }
        else {
            $arrStep = explode(',', $returnVal);
            if(!in_array($step, $arrStep)){
                $returnVal = $returnVal.','.$step;
            }
        }
        return $returnVal;
    }

}

