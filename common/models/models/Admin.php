<?php

namespace common\models;

use Yii;
use yii\base\NotSupportedException;
#use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;
use yii\web\IdentityInterface;


/**
 * This is the model class for table "admin".
 *
 * @property integer $iAdminId
 * @property string $vFirstName
 * @property string $vLastName
 * @property string $vEmail
 * @property string $vPassword
 * @property string $eStatus
 */
//class User extends \common\models\base\baseUser implements IdentityInterface
class Admin extends \common\models\base\baseAdmin implements IdentityInterface
{

    const STATUS_DELETED = 0;
    const STATUS_ACTIVE = 'Active';
    const SCENARIO_ADD = 'ADD';
    const SCENARIO_UPDATE = 'Update';
    public $auth_key;
    public $password_reset_token;

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return '{{%admin}}';
    }

    /**
     * @inheritdoc
     */
    public static function findIdentity($id)
    {
        return static::findOne(['iAdminId' => $id, 'eStatus' => self::STATUS_ACTIVE]);
    }

    /**
     * @inheritdoc
     */
    public static function findIdentityByAccessToken($token, $type = null)
    {
        throw new NotSupportedException('"findIdentityByAccessToken" is not implemented.');
    }

    public static function findByEmail($email)
    {
        return static::findOne(['vEmail' => $email]);

    }

    /**
     * @inheritdoc
     */
    public function behaviors()
    {
        return [
            //           TimestampBehavior::className(),
        ];
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vFirstName', 'vLastName', 'vEmail', 'vPassword'], 'required'],
            [['vFirstName', 'vLastName', 'vEmail', 'vPassword', 'eStatus'], 'string'],
            [['vEmail'], 'email'],
            #[['vEmail'], 'unique'],

        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iAdminId' => 'Admin ID',
            'vFirstName' => 'First Name',
            'vLastName' => 'Last Name',
            'vEmail' => 'Email',
            'vPassword' => 'Password',
            'eStatus' => 'Status',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['vFirstName', 'vLastName', 'vEmail', 'vPassword', 'eStatus'],
            self::SCENARIO_UPDATE => ['vFirstName', 'vLastName', 'vEmail', 'eStatus'],
        ];

    }

    public function validatePassword($password)
    {
        return Yii::$app->security->validatePassword($password, $this->vPassword);
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

}
