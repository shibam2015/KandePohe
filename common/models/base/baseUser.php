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
 * @property string $eFirstVerificationMailStatus
 * @property integer $iEducationLevelID
 * @property integer $iEducationFieldID
 * @property integer $iWorkingWithID
 * @property integer $iWorkingAsID
 * @property integer $iAnnualIncomeID
 * @property integer $iCommunity_ID
 * @property string $toc
 * @property string $county_code
 * @property integer $iSubCommunity_ID
 * @property integer $iDistrictID
 * @property integer $iGotraID
 * @property integer $iMaritalStatusID
 * @property integer $iTalukaID
 * @property integer $iCountryId
 * @property integer $iStateId
 * @property integer $iCityId
 * @property integer $noc
 * @property string $vAreaName
 * @property string $cnb
 * @property integer $iHeightID
 * @property string $vSkinTone
 * @property string $vBodyType
 * @property string $vSmoke
 * @property string $vDrink
 * @property string $vSpectaclesLens
 * @property string $vDiet
 * @property string $tYourSelf
 * @property string $vDisability
 * @property string $propic
 * @property integer $iFatherStatusID
 * @property integer $iMotherStatusID
 * @property integer $iFatherWorkingAsID
 * @property integer $iMotherWorkingAsID
 * @property integer $nob
 * @property integer $nos
 * @property string $eSameAddress
 * @property integer $iCountryCAId
 * @property integer $iStateCAId
 * @property integer $iDistrictCAID
 * @property integer $iTalukaCAID
 * @property string $vAreaNameCA
 * @property integer $iCityCAId
 * @property string $vNativePlaceCA
 * @property string $vParentsResiding
 * @property string $vFamilyAffluenceLevel
 * @property string $vFamilyType
 * @property string $vFamilyProperty
 * @property string $vDetailRelative
 * @property string $completed_step
 * @property string $pin_email_vaerification
 * @property integer $pin_phone_vaerification
 * @property string $pin_email_time
 * @property string $pin_phone_time
 * @property string $eEmailVerifiedStatus
 * @property string $ePhoneVerifiedStatus
 * @property string $eStatusPhotoModify
 * @property string $eStatusInOwnWord
 * @property string $weight
 * @property string $cover_background_position
 * @property string $cover_photo
 * @property string $user_privacy_option
 * @property string $hide_profile
 * @property integer $mother_tongue
 * @property string $LastLoginTime
 * @property integer $RaashiId
 * @property integer $NakshtraId
 * @property integer $GanId
 * @property integer $CharanId
 * @property string $Mangalik
 * @property integer $NadiId
 * @property string $InterestID
 * @property string $FavioriteReadID
 * @property string $FaviouriteMusicID
 * @property string $FavouriteCousinesID
 * @property string $SportsFittnessID
 * @property string $PreferredDressID
 * @property string $PreferredMovieID
 * @property string $vDisabilityDescription
 * @property integer $NobM
 * @property integer $NosM
 * @property string $new_phone_no
 * @property string $new_email_id
 * @property string $new_county_code
 * @property string $latitude
 * @property string $longitude
 * @property integer $multiple_profile_status
 * @property string $multiple_profile_reason
 * @property string $phone_privacy
 * @property string $photo_privacy
 * @property string $visitor_setting
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
            [['auth_key', 'password_hash', 'email', 'created_at', 'updated_at', 'Registration_Number', 'Mobile', 'First_Name', 'Last_Name', 'DOB', 'Time_of_Birth', 'Age', 'Birth_Place', 'Marital_Status', 'iReligion_ID', 'iEducationLevelID', 'iEducationFieldID', 'iWorkingWithID', 'iWorkingAsID', 'iAnnualIncomeID', 'iCommunity_ID', 'county_code', 'iSubCommunity_ID', 'iDistrictID', 'iGotraID', 'iMaritalStatusID', 'iTalukaID', 'iCountryId', 'iStateId', 'iCityId', 'noc', 'vAreaName', 'iHeightID', 'vSkinTone', 'vBodyType', 'vSmoke', 'vDrink', 'vSpectaclesLens', 'vDiet', 'tYourSelf', 'vDisability', 'propic', 'iFatherStatusID', 'iMotherStatusID', 'iFatherWorkingAsID', 'iMotherWorkingAsID', 'nob', 'nos', 'iCountryCAId', 'iStateCAId', 'iDistrictCAID', 'iTalukaCAID', 'vAreaNameCA', 'iCityCAId', 'vNativePlaceCA', 'vParentsResiding', 'vFamilyAffluenceLevel', 'vFamilyType', 'vFamilyProperty', 'vDetailRelative', 'completed_step', 'pin_email_vaerification', 'pin_phone_vaerification', 'weight', 'cover_background_position', 'cover_photo', 'mother_tongue', 'LastLoginTime', 'RaashiId', 'NakshtraId', 'GanId', 'CharanId', 'NadiId', 'InterestID', 'FavioriteReadID', 'FaviouriteMusicID', 'FavouriteCousinesID', 'SportsFittnessID', 'PreferredDressID', 'PreferredMovieID', 'vDisabilityDescription', 'NobM', 'NosM', 'new_phone_no', 'new_email_id', 'new_county_code', 'latitude', 'longitude', 'multiple_profile_reason'], 'required'],
            [['status', 'created_at', 'updated_at', 'Age', 'Marital_Status', 'iReligion_ID', 'iEducationLevelID', 'iEducationFieldID', 'iWorkingWithID', 'iWorkingAsID', 'iAnnualIncomeID', 'iCommunity_ID', 'iSubCommunity_ID', 'iDistrictID', 'iGotraID', 'iMaritalStatusID', 'iTalukaID', 'iCountryId', 'iStateId', 'iCityId', 'noc', 'iHeightID', 'iFatherStatusID', 'iMotherStatusID', 'iFatherWorkingAsID', 'iMotherWorkingAsID', 'nob', 'nos', 'iCountryCAId', 'iStateCAId', 'iDistrictCAID', 'iTalukaCAID', 'iCityCAId', 'pin_phone_vaerification', 'pin_email_time', 'pin_phone_time', 'mother_tongue', 'RaashiId', 'NakshtraId', 'GanId', 'CharanId', 'NadiId', 'NobM', 'NosM', 'multiple_profile_status'], 'integer'],
            [['Profile_created_for', 'Gender', 'eFirstVerificationMailStatus', 'toc', 'vAreaName', 'cnb', 'vSkinTone', 'vBodyType', 'vSmoke', 'vDrink', 'vSpectaclesLens', 'vDiet', 'tYourSelf', 'vDisability', 'propic', 'eSameAddress', 'vAreaNameCA', 'vNativePlaceCA', 'vParentsResiding', 'vFamilyAffluenceLevel', 'vFamilyType', 'vFamilyProperty', 'vDetailRelative', 'pin_email_vaerification', 'eEmailVerifiedStatus', 'ePhoneVerifiedStatus', 'eStatusPhotoModify', 'eStatusInOwnWord', 'user_privacy_option', 'hide_profile', 'Mangalik', 'InterestID', 'FavioriteReadID', 'FaviouriteMusicID', 'FavouriteCousinesID', 'SportsFittnessID', 'PreferredDressID', 'PreferredMovieID', 'vDisabilityDescription', 'multiple_profile_reason', 'phone_privacy', 'photo_privacy', 'visitor_setting'], 'string'],
            [['DOB', 'Time_of_Birth', 'LastLoginTime'], 'safe'],
            [['auth_key'], 'string', 'max' => 32],
            [['password_hash', 'password_reset_token', 'email'], 'string', 'max' => 255],
            [['Registration_Number', 'Birth_Place'], 'string', 'max' => 250],
            [['Mobile', 'new_email_id', 'latitude', 'longitude'], 'string', 'max' => 20],
            [['First_Name', 'Last_Name', 'completed_step'], 'string', 'max' => 100],
            [['county_code', 'new_county_code'], 'string', 'max' => 5],
            [['weight', 'cover_background_position'], 'string', 'max' => 50],
            [['cover_photo', 'new_phone_no'], 'string', 'max' => 200],
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
            'eFirstVerificationMailStatus' => 'E First Verification Mail Status',
            'iEducationLevelID' => 'I Education Level ID',
            'iEducationFieldID' => 'I Education Field ID',
            'iWorkingWithID' => 'I Working With ID',
            'iWorkingAsID' => 'I Working As ID',
            'iAnnualIncomeID' => 'I Annual Income ID',
            'iCommunity_ID' => 'I Community  ID',
            'toc' => 'Toc',
            'county_code' => 'County Code',
            'iSubCommunity_ID' => 'I Sub Community  ID',
            'iDistrictID' => 'I District ID',
            'iGotraID' => 'I Gotra ID',
            'iMaritalStatusID' => 'I Marital Status ID',
            'iTalukaID' => 'I Taluka ID',
            'iCountryId' => 'I Country ID',
            'iStateId' => 'I State ID',
            'iCityId' => 'I City ID',
            'noc' => 'Noc',
            'vAreaName' => 'V Area Name',
            'cnb' => 'Cnb',
            'iHeightID' => 'I Height ID',
            'vSkinTone' => 'V Skin Tone',
            'vBodyType' => 'V Body Type',
            'vSmoke' => 'V Smoke',
            'vDrink' => 'V Drink',
            'vSpectaclesLens' => 'V Spectacles Lens',
            'vDiet' => 'V Diet',
            'tYourSelf' => 'T Your Self',
            'vDisability' => 'V Disability',
            'propic' => 'Propic',
            'iFatherStatusID' => 'I Father Status ID',
            'iMotherStatusID' => 'I Mother Status ID',
            'iFatherWorkingAsID' => 'I Father Working As ID',
            'iMotherWorkingAsID' => 'I Mother Working As ID',
            'nob' => 'Nob',
            'nos' => 'Nos',
            'eSameAddress' => 'E Same Address',
            'iCountryCAId' => 'I Country Caid',
            'iStateCAId' => 'I State Caid',
            'iDistrictCAID' => 'I District Caid',
            'iTalukaCAID' => 'I Taluka Caid',
            'vAreaNameCA' => 'V Area Name Ca',
            'iCityCAId' => 'I City Caid',
            'vNativePlaceCA' => 'V Native Place Ca',
            'vParentsResiding' => 'V Parents Residing',
            'vFamilyAffluenceLevel' => 'V Family Affluence Level',
            'vFamilyType' => 'V Family Type',
            'vFamilyProperty' => 'V Family Property',
            'vDetailRelative' => 'V Detail Relative',
            'completed_step' => 'Completed Step',
            'pin_email_vaerification' => 'Pin Email Vaerification',
            'pin_phone_vaerification' => 'Pin Phone Vaerification',
            'pin_email_time' => 'Pin Email Time',
            'pin_phone_time' => 'Pin Phone Time',
            'eEmailVerifiedStatus' => 'E Email Verified Status',
            'ePhoneVerifiedStatus' => 'E Phone Verified Status',
            'eStatusPhotoModify' => 'E Status Photo Modify',
            'eStatusInOwnWord' => 'E Status In Own Word',
            'weight' => 'Weight',
            'cover_background_position' => 'Cover Background Position',
            'cover_photo' => 'Cover Photo',
            'user_privacy_option' => 'User Privacy Option',
            'hide_profile' => 'Hide Profile',
            'mother_tongue' => 'Mother Tongue',
            'LastLoginTime' => 'Last Login Time',
            'RaashiId' => 'Raashi ID',
            'NakshtraId' => 'Nakshtra ID',
            'GanId' => 'Gan ID',
            'CharanId' => 'Charan ID',
            'Mangalik' => 'Mangalik',
            'NadiId' => 'Nadi ID',
            'InterestID' => 'Interest ID',
            'FavioriteReadID' => 'Faviorite Read ID',
            'FaviouriteMusicID' => 'Faviourite Music ID',
            'FavouriteCousinesID' => 'Favourite Cousines ID',
            'SportsFittnessID' => 'Sports Fittness ID',
            'PreferredDressID' => 'Preferred Dress ID',
            'PreferredMovieID' => 'Preferred Movie ID',
            'vDisabilityDescription' => 'V Disability Description',
            'NobM' => 'Nob M',
            'NosM' => 'Nos M',
            'new_phone_no' => 'New Phone No',
            'new_email_id' => 'New Email ID',
            'new_county_code' => 'New County Code',
            'latitude' => 'Latitude',
            'longitude' => 'Longitude',
            'multiple_profile_status' => 'Multiple Profile Status',
            'multiple_profile_reason' => 'Multiple Profile Reason',
            'phone_privacy' => 'Phone Privacy',
            'photo_privacy' => 'Photo Privacy',
            'visitor_setting' => 'Visitor Setting',
        ];
    }
}
