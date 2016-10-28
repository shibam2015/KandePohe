<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "user".
 *
 * @property integer $id
 * @property string $auth_key
 * @property string $password_hash
 * @property string $password_reset_token
 * @property string $email
 * @property integer $status
 * @property integer $created_at
 * @property integer $updated_at
 * @property string $Registration_Number
 * @property string $Mobile
 * @property string $Profile_created_for
 * @property string $First_Name
 * @property string $Last_Name
 * @property string $Gender
 * @property string $DOB
 * @property string $Time_of_Birth
 * @property integer $Age
 * @property string $Birth_Place
 * @property integer $Marital_Status
 * @property integer $iReligion_ID
 * @property integer $iEducationLevelID
 * @property integer $iEducationFieldID
 * @property integer $iWorkingWithID
 * @property integer $iWorkingAsID
 * @property integer $iAnnualIncomeID
 */
class baseUser extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['auth_key', 'password_hash', 'email', 'created_at', 'updated_at', 'Registration_Number', 'Mobile', 'First_Name', 'Last_Name', 'DOB', 'Time_of_Birth', 'Age', 'Birth_Place', 'Marital_Status', 'iReligion_ID', 'iEducationLevelID', 'iEducationFieldID', 'iWorkingWithID', 'iWorkingAsID', 'iAnnualIncomeID'], 'required'],
            [['status', 'created_at', 'updated_at', 'Age', 'Marital_Status', 'iReligion_ID', 'iEducationLevelID', 'iEducationFieldID', 'iWorkingWithID', 'iWorkingAsID', 'iAnnualIncomeID'], 'integer'],
            [['Profile_created_for', 'Gender'], 'string'],
            [['DOB', 'Time_of_Birth'], 'safe'],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['Registration_Number', 'Birth_Place'], 'string', 'max' => 250],
            [['Mobile'], 'string', 'max' => 20],
            [['First_Name', 'Last_Name'], 'string', 'max' => 100],
            [['password_reset_token'], 'unique'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'auth_key' => 'Auth Key',
            'password_hash' => 'Password Hash',
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
            'iReligion_ID' => 'I Religion  ID',
            'iEducationLevelID' => 'I Education Level ID',
            'iEducationFieldID' => 'I Education Field ID',
            'iWorkingWithID' => 'I Working With ID',
            'iWorkingAsID' => 'I Working As ID',
            'iAnnualIncomeID' => 'I Annual Income ID',
        ];
    }
}
