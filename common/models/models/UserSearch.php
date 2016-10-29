<?php

namespace common\models;

use Yii;
use yii\base\Model;
use yii\data\ActiveDataProvider;
use common\models\User;

/**
 * UserSearch represents the model behind the search form about `common\models\User`.
 */
class UserSearch extends User
{
    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'status', 'created_at', 'updated_at', 'Age', 'Marital_Status', 'iReligion_ID', 'iEducationLevelID', 'iEducationFieldID', 'iWorkingWithID', 'iWorkingAsID', 'iAnnualIncomeID', 'iCommunity_ID', 'iSubCommunity_ID', 'iDistrictID', 'iGotraID', 'iMaritalStatusID', 'iTalukaID', 'iCountryId', 'iStateId', 'iCityId', 'noc', 'iHeightID', 'iFatherStatusID', 'iMotherStatusID', 'iFatherWorkingAsID', 'iMotherWorkingAsID', 'nob', 'nos', 'iCountryCAId', 'iStateCAId', 'iDistrictCAID', 'iTalukaCAID', 'iCityCAId', 'completed_step'], 'integer'],
            [['auth_key', 'password_hash', 'password_reset_token', 'email', 'Registration_Number', 'Mobile', 'Profile_created_for', 'First_Name', 'Last_Name', 'Gender', 'DOB', 'Time_of_Birth', 'Birth_Place', 'eFirstVerificationMailStatus', 'toc', 'county_code', 'vAreaName', 'cnb', 'vSkinTone', 'vBodyType', 'vSmoke', 'vDrink', 'vSpectaclesLens', 'vDiet', 'tYourSelf', 'vDisability', 'propic', 'pin_email_vaerification', 'eSameAddress', 'vAreaNameCA', 'vNativePlaceCA', 'vParentsResiding', 'vFamilyAffluenceLevel', 'vFamilyType', 'vFamilyProperty', 'vDetailRelative', 'eEmailVerifiedStatus', 'ePhoneVerifiedStatus'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function scenarios()
    {
        // bypass scenarios() implementation in the parent class
        return Model::scenarios();
    }

    /**
     * Creates data provider instance with search query applied
     *
     * @param array $params
     *
     * @return ActiveDataProvider
     */
    public function search($params)
    {
        $query = User::find();


        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'DOB' => $this->DOB,
            'Time_of_Birth' => $this->Time_of_Birth,
            'Age' => $this->Age,
            'Marital_Status' => $this->Marital_Status,
            'iReligion_ID' => $this->iReligion_ID,
            'iEducationLevelID' => $this->iEducationLevelID,
            'iEducationFieldID' => $this->iEducationFieldID,
            'iWorkingWithID' => $this->iWorkingWithID,
            'iWorkingAsID' => $this->iWorkingAsID,
            'iAnnualIncomeID' => $this->iAnnualIncomeID,
            'iCommunity_ID' => $this->iCommunity_ID,
            'iSubCommunity_ID' => $this->iSubCommunity_ID,
            'iDistrictID' => $this->iDistrictID,
            'iGotraID' => $this->iGotraID,
            'iMaritalStatusID' => $this->iMaritalStatusID,
            'iTalukaID' => $this->iTalukaID,
            'iCountryId' => $this->iCountryId,
            'iStateId' => $this->iStateId,
            'iCityId' => $this->iCityId,
            'noc' => $this->noc,
            'iHeightID' => $this->iHeightID,
            'iFatherStatusID' => $this->iFatherStatusID,
            'iMotherStatusID' => $this->iMotherStatusID,
            'iFatherWorkingAsID' => $this->iFatherWorkingAsID,
            'iMotherWorkingAsID' => $this->iMotherWorkingAsID,
            'nob' => $this->nob,
            'nos' => $this->nos,
            'iCountryCAId' => $this->iCountryCAId,
            'iStateCAId' => $this->iStateCAId,
            'iDistrictCAID' => $this->iDistrictCAID,
            'iTalukaCAID' => $this->iTalukaCAID,
            'iCityCAId' => $this->iCityCAId,
            'completed_step' => $this->completed_step,
        ]);

        $query->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'Registration_Number', $this->Registration_Number])
            ->andFilterWhere(['like', 'Mobile', $this->Mobile])
            ->andFilterWhere(['like', 'Profile_created_for', $this->Profile_created_for])
            ->andFilterWhere(['like', 'First_Name', $this->First_Name])
            ->andFilterWhere(['like', 'Last_Name', $this->Last_Name])
            ->andFilterWhere(['like', 'Gender', $this->Gender])
            ->andFilterWhere(['like', 'Birth_Place', $this->Birth_Place])
            ->andFilterWhere(['like', 'eFirstVerificationMailStatus', $this->eFirstVerificationMailStatus])
            ->andFilterWhere(['like', 'toc', $this->toc])
            ->andFilterWhere(['like', 'county_code', $this->county_code])
            ->andFilterWhere(['like', 'vAreaName', $this->vAreaName])
            ->andFilterWhere(['like', 'cnb', $this->cnb])
            ->andFilterWhere(['like', 'vSkinTone', $this->vSkinTone])
            ->andFilterWhere(['like', 'vBodyType', $this->vBodyType])
            ->andFilterWhere(['like', 'vSmoke', $this->vSmoke])
            ->andFilterWhere(['like', 'vDrink', $this->vDrink])
            ->andFilterWhere(['like', 'vSpectaclesLens', $this->vSpectaclesLens])
            ->andFilterWhere(['like', 'vDiet', $this->vDiet])
            ->andFilterWhere(['like', 'tYourSelf', $this->tYourSelf])
            ->andFilterWhere(['like', 'vDisability', $this->vDisability])
            ->andFilterWhere(['like', 'propic', $this->propic])
            ->andFilterWhere(['like', 'pin_email_vaerification', $this->pin_email_vaerification])
            ->andFilterWhere(['like', 'eSameAddress', $this->eSameAddress])
            ->andFilterWhere(['like', 'vAreaNameCA', $this->vAreaNameCA])
            ->andFilterWhere(['like', 'vNativePlaceCA', $this->vNativePlaceCA])
            ->andFilterWhere(['like', 'vParentsResiding', $this->vParentsResiding])
            ->andFilterWhere(['like', 'vFamilyAffluenceLevel', $this->vFamilyAffluenceLevel])
            ->andFilterWhere(['like', 'vFamilyType', $this->vFamilyType])
            ->andFilterWhere(['like', 'vFamilyProperty', $this->vFamilyProperty])
            ->andFilterWhere(['like', 'vDetailRelative', $this->vDetailRelative])
            ->andFilterWhere(['like', 'eEmailVerifiedStatus', $this->eEmailVerifiedStatus])
            ->andFilterWhere(['like', 'ePhoneVerifiedStatus', $this->ePhoneVerifiedStatus]);

        return $dataProvider;
    }

    public function searchActive($params)
    {
        $query = User::find()->where(['status' => 1]);
        #echo $query->createCommand()->sql;
        #print_r($query->createCommand()->getRawSql());
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'DOB' => $this->DOB,
            'Time_of_Birth' => $this->Time_of_Birth,
            'Age' => $this->Age,
            'Marital_Status' => $this->Marital_Status,
            'iReligion_ID' => $this->iReligion_ID,
            'iEducationLevelID' => $this->iEducationLevelID,
            'iEducationFieldID' => $this->iEducationFieldID,
            'iWorkingWithID' => $this->iWorkingWithID,
            'iWorkingAsID' => $this->iWorkingAsID,
            'iAnnualIncomeID' => $this->iAnnualIncomeID,
            'iCommunity_ID' => $this->iCommunity_ID,
            'iSubCommunity_ID' => $this->iSubCommunity_ID,
            'iDistrictID' => $this->iDistrictID,
            'iGotraID' => $this->iGotraID,
            'iMaritalStatusID' => $this->iMaritalStatusID,
            'iTalukaID' => $this->iTalukaID,
            'iCountryId' => $this->iCountryId,
            'iStateId' => $this->iStateId,
            'iCityId' => $this->iCityId,
            'noc' => $this->noc,
            'iHeightID' => $this->iHeightID,
            'iFatherStatusID' => $this->iFatherStatusID,
            'iMotherStatusID' => $this->iMotherStatusID,
            'iFatherWorkingAsID' => $this->iFatherWorkingAsID,
            'iMotherWorkingAsID' => $this->iMotherWorkingAsID,
            'nob' => $this->nob,
            'nos' => $this->nos,
            'iCountryCAId' => $this->iCountryCAId,
            'iStateCAId' => $this->iStateCAId,
            'iDistrictCAID' => $this->iDistrictCAID,
            'iTalukaCAID' => $this->iTalukaCAID,
            'iCityCAId' => $this->iCityCAId,
            'completed_step' => $this->completed_step,
        ]);

        $query->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'Registration_Number', $this->Registration_Number])
            ->andFilterWhere(['like', 'Mobile', $this->Mobile])
            ->andFilterWhere(['like', 'Profile_created_for', $this->Profile_created_for])
            ->andFilterWhere(['like', 'First_Name', $this->First_Name])
            ->andFilterWhere(['like', 'Last_Name', $this->Last_Name])
            ->andFilterWhere(['like', 'Gender', $this->Gender])
            ->andFilterWhere(['like', 'Birth_Place', $this->Birth_Place])
            ->andFilterWhere(['like', 'eFirstVerificationMailStatus', $this->eFirstVerificationMailStatus])
            ->andFilterWhere(['like', 'toc', $this->toc])
            ->andFilterWhere(['like', 'county_code', $this->county_code])
            ->andFilterWhere(['like', 'vAreaName', $this->vAreaName])
            ->andFilterWhere(['like', 'cnb', $this->cnb])
            ->andFilterWhere(['like', 'vSkinTone', $this->vSkinTone])
            ->andFilterWhere(['like', 'vBodyType', $this->vBodyType])
            ->andFilterWhere(['like', 'vSmoke', $this->vSmoke])
            ->andFilterWhere(['like', 'vDrink', $this->vDrink])
            ->andFilterWhere(['like', 'vSpectaclesLens', $this->vSpectaclesLens])
            ->andFilterWhere(['like', 'vDiet', $this->vDiet])
            ->andFilterWhere(['like', 'tYourSelf', $this->tYourSelf])
            ->andFilterWhere(['like', 'vDisability', $this->vDisability])
            ->andFilterWhere(['like', 'propic', $this->propic])
            ->andFilterWhere(['like', 'pin_email_vaerification', $this->pin_email_vaerification])
            ->andFilterWhere(['like', 'eSameAddress', $this->eSameAddress])
            ->andFilterWhere(['like', 'vAreaNameCA', $this->vAreaNameCA])
            ->andFilterWhere(['like', 'vNativePlaceCA', $this->vNativePlaceCA])
            ->andFilterWhere(['like', 'vParentsResiding', $this->vParentsResiding])
            ->andFilterWhere(['like', 'vFamilyAffluenceLevel', $this->vFamilyAffluenceLevel])
            ->andFilterWhere(['like', 'vFamilyType', $this->vFamilyType])
            ->andFilterWhere(['like', 'vFamilyProperty', $this->vFamilyProperty])
            ->andFilterWhere(['like', 'vDetailRelative', $this->vDetailRelative])
            ->andFilterWhere(['like', 'eEmailVerifiedStatus', $this->eEmailVerifiedStatus])
            ->andFilterWhere(['like', 'ePhoneVerifiedStatus', $this->ePhoneVerifiedStatus]);

        return $dataProvider;
    }

    public function searchApprove($params)
    {
        $query = User::find()->where(['status' => 5]); // 5 For Approve
        #echo $query->createCommand()->sql;
        #print_r($query->createCommand()->getRawSql());
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'DOB' => $this->DOB,
            'Time_of_Birth' => $this->Time_of_Birth,
            'Age' => $this->Age,
            'Marital_Status' => $this->Marital_Status,
            'iReligion_ID' => $this->iReligion_ID,
            'iEducationLevelID' => $this->iEducationLevelID,
            'iEducationFieldID' => $this->iEducationFieldID,
            'iWorkingWithID' => $this->iWorkingWithID,
            'iWorkingAsID' => $this->iWorkingAsID,
            'iAnnualIncomeID' => $this->iAnnualIncomeID,
            'iCommunity_ID' => $this->iCommunity_ID,
            'iSubCommunity_ID' => $this->iSubCommunity_ID,
            'iDistrictID' => $this->iDistrictID,
            'iGotraID' => $this->iGotraID,
            'iMaritalStatusID' => $this->iMaritalStatusID,
            'iTalukaID' => $this->iTalukaID,
            'iCountryId' => $this->iCountryId,
            'iStateId' => $this->iStateId,
            'iCityId' => $this->iCityId,
            'noc' => $this->noc,
            'iHeightID' => $this->iHeightID,
            'iFatherStatusID' => $this->iFatherStatusID,
            'iMotherStatusID' => $this->iMotherStatusID,
            'iFatherWorkingAsID' => $this->iFatherWorkingAsID,
            'iMotherWorkingAsID' => $this->iMotherWorkingAsID,
            'nob' => $this->nob,
            'nos' => $this->nos,
            'iCountryCAId' => $this->iCountryCAId,
            'iStateCAId' => $this->iStateCAId,
            'iDistrictCAID' => $this->iDistrictCAID,
            'iTalukaCAID' => $this->iTalukaCAID,
            'iCityCAId' => $this->iCityCAId,
            'completed_step' => $this->completed_step,
        ]);

        $query->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'Registration_Number', $this->Registration_Number])
            ->andFilterWhere(['like', 'Mobile', $this->Mobile])
            ->andFilterWhere(['like', 'Profile_created_for', $this->Profile_created_for])
            ->andFilterWhere(['like', 'First_Name', $this->First_Name])
            ->andFilterWhere(['like', 'Last_Name', $this->Last_Name])
            ->andFilterWhere(['like', 'Gender', $this->Gender])
            ->andFilterWhere(['like', 'Birth_Place', $this->Birth_Place])
            ->andFilterWhere(['like', 'eFirstVerificationMailStatus', $this->eFirstVerificationMailStatus])
            ->andFilterWhere(['like', 'toc', $this->toc])
            ->andFilterWhere(['like', 'county_code', $this->county_code])
            ->andFilterWhere(['like', 'vAreaName', $this->vAreaName])
            ->andFilterWhere(['like', 'cnb', $this->cnb])
            ->andFilterWhere(['like', 'vSkinTone', $this->vSkinTone])
            ->andFilterWhere(['like', 'vBodyType', $this->vBodyType])
            ->andFilterWhere(['like', 'vSmoke', $this->vSmoke])
            ->andFilterWhere(['like', 'vDrink', $this->vDrink])
            ->andFilterWhere(['like', 'vSpectaclesLens', $this->vSpectaclesLens])
            ->andFilterWhere(['like', 'vDiet', $this->vDiet])
            ->andFilterWhere(['like', 'tYourSelf', $this->tYourSelf])
            ->andFilterWhere(['like', 'vDisability', $this->vDisability])
            ->andFilterWhere(['like', 'propic', $this->propic])
            ->andFilterWhere(['like', 'pin_email_vaerification', $this->pin_email_vaerification])
            ->andFilterWhere(['like', 'eSameAddress', $this->eSameAddress])
            ->andFilterWhere(['like', 'vAreaNameCA', $this->vAreaNameCA])
            ->andFilterWhere(['like', 'vNativePlaceCA', $this->vNativePlaceCA])
            ->andFilterWhere(['like', 'vParentsResiding', $this->vParentsResiding])
            ->andFilterWhere(['like', 'vFamilyAffluenceLevel', $this->vFamilyAffluenceLevel])
            ->andFilterWhere(['like', 'vFamilyType', $this->vFamilyType])
            ->andFilterWhere(['like', 'vFamilyProperty', $this->vFamilyProperty])
            ->andFilterWhere(['like', 'vDetailRelative', $this->vDetailRelative])
            ->andFilterWhere(['like', 'eEmailVerifiedStatus', $this->eEmailVerifiedStatus])
            ->andFilterWhere(['like', 'ePhoneVerifiedStatus', $this->ePhoneVerifiedStatus]);

        return $dataProvider;
    }

    public function searchInOwnWords($params)
    {
        $query = User::find()->where(['eStatusInOwnWord' => ['Disapprove', 'Pending']]); // 5 For Approve
        #echo $query->createCommand()->sql;
        #print_r($query->createCommand()->getRawSql());
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'DOB' => $this->DOB,
            'Time_of_Birth' => $this->Time_of_Birth,
            'Age' => $this->Age,
            'Marital_Status' => $this->Marital_Status,
            'iReligion_ID' => $this->iReligion_ID,
            'iEducationLevelID' => $this->iEducationLevelID,
            'iEducationFieldID' => $this->iEducationFieldID,
            'iWorkingWithID' => $this->iWorkingWithID,
            'iWorkingAsID' => $this->iWorkingAsID,
            'iAnnualIncomeID' => $this->iAnnualIncomeID,
            'iCommunity_ID' => $this->iCommunity_ID,
            'iSubCommunity_ID' => $this->iSubCommunity_ID,
            'iDistrictID' => $this->iDistrictID,
            'iGotraID' => $this->iGotraID,
            'iMaritalStatusID' => $this->iMaritalStatusID,
            'iTalukaID' => $this->iTalukaID,
            'iCountryId' => $this->iCountryId,
            'iStateId' => $this->iStateId,
            'iCityId' => $this->iCityId,
            'noc' => $this->noc,
            'iHeightID' => $this->iHeightID,
            'iFatherStatusID' => $this->iFatherStatusID,
            'iMotherStatusID' => $this->iMotherStatusID,
            'iFatherWorkingAsID' => $this->iFatherWorkingAsID,
            'iMotherWorkingAsID' => $this->iMotherWorkingAsID,
            'nob' => $this->nob,
            'nos' => $this->nos,
            'iCountryCAId' => $this->iCountryCAId,
            'iStateCAId' => $this->iStateCAId,
            'iDistrictCAID' => $this->iDistrictCAID,
            'iTalukaCAID' => $this->iTalukaCAID,
            'iCityCAId' => $this->iCityCAId,
            'completed_step' => $this->completed_step,
        ]);

        $query->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'Registration_Number', $this->Registration_Number])
            ->andFilterWhere(['like', 'Mobile', $this->Mobile])
            ->andFilterWhere(['like', 'Profile_created_for', $this->Profile_created_for])
            ->andFilterWhere(['like', 'First_Name', $this->First_Name])
            ->andFilterWhere(['like', 'Last_Name', $this->Last_Name])
            ->andFilterWhere(['like', 'Gender', $this->Gender])
            ->andFilterWhere(['like', 'Birth_Place', $this->Birth_Place])
            ->andFilterWhere(['like', 'eFirstVerificationMailStatus', $this->eFirstVerificationMailStatus])
            ->andFilterWhere(['like', 'toc', $this->toc])
            ->andFilterWhere(['like', 'county_code', $this->county_code])
            ->andFilterWhere(['like', 'vAreaName', $this->vAreaName])
            ->andFilterWhere(['like', 'cnb', $this->cnb])
            ->andFilterWhere(['like', 'vSkinTone', $this->vSkinTone])
            ->andFilterWhere(['like', 'vBodyType', $this->vBodyType])
            ->andFilterWhere(['like', 'vSmoke', $this->vSmoke])
            ->andFilterWhere(['like', 'vDrink', $this->vDrink])
            ->andFilterWhere(['like', 'vSpectaclesLens', $this->vSpectaclesLens])
            ->andFilterWhere(['like', 'vDiet', $this->vDiet])
            ->andFilterWhere(['like', 'tYourSelf', $this->tYourSelf])
            ->andFilterWhere(['like', 'vDisability', $this->vDisability])
            ->andFilterWhere(['like', 'propic', $this->propic])
            ->andFilterWhere(['like', 'pin_email_vaerification', $this->pin_email_vaerification])
            ->andFilterWhere(['like', 'eSameAddress', $this->eSameAddress])
            ->andFilterWhere(['like', 'vAreaNameCA', $this->vAreaNameCA])
            ->andFilterWhere(['like', 'vNativePlaceCA', $this->vNativePlaceCA])
            ->andFilterWhere(['like', 'vParentsResiding', $this->vParentsResiding])
            ->andFilterWhere(['like', 'vFamilyAffluenceLevel', $this->vFamilyAffluenceLevel])
            ->andFilterWhere(['like', 'vFamilyType', $this->vFamilyType])
            ->andFilterWhere(['like', 'vFamilyProperty', $this->vFamilyProperty])
            ->andFilterWhere(['like', 'vDetailRelative', $this->vDetailRelative])
            ->andFilterWhere(['like', 'eEmailVerifiedStatus', $this->eEmailVerifiedStatus])
            ->andFilterWhere(['like', 'ePhoneVerifiedStatus', $this->ePhoneVerifiedStatus]);

        return $dataProvider;
    }

    public function searchProfilePhoto($params)
    {
        $query = User::find()->where(['eStatusPhotoModify' => ['Disapprove', 'Pending']]); // 5 For Approve
        #echo $query->createCommand()->sql;
        #print_r($query->createCommand()->getRawSql());
        // add conditions that should always apply here

        $dataProvider = new ActiveDataProvider([
            'query' => $query,
        ]);

        $this->load($params);

        if (!$this->validate()) {
            // uncomment the following line if you do not want to return any records when validation fails
            // $query->where('0=1');
            return $dataProvider;
        }
        // grid filtering conditions
        $query->andFilterWhere([
            'id' => $this->id,
            'status' => $this->status,
            'created_at' => $this->created_at,
            'updated_at' => $this->updated_at,
            'DOB' => $this->DOB,
            'Time_of_Birth' => $this->Time_of_Birth,
            'Age' => $this->Age,
            'Marital_Status' => $this->Marital_Status,
            'iReligion_ID' => $this->iReligion_ID,
            'iEducationLevelID' => $this->iEducationLevelID,
            'iEducationFieldID' => $this->iEducationFieldID,
            'iWorkingWithID' => $this->iWorkingWithID,
            'iWorkingAsID' => $this->iWorkingAsID,
            'iAnnualIncomeID' => $this->iAnnualIncomeID,
            'iCommunity_ID' => $this->iCommunity_ID,
            'iSubCommunity_ID' => $this->iSubCommunity_ID,
            'iDistrictID' => $this->iDistrictID,
            'iGotraID' => $this->iGotraID,
            'iMaritalStatusID' => $this->iMaritalStatusID,
            'iTalukaID' => $this->iTalukaID,
            'iCountryId' => $this->iCountryId,
            'iStateId' => $this->iStateId,
            'iCityId' => $this->iCityId,
            'noc' => $this->noc,
            'iHeightID' => $this->iHeightID,
            'iFatherStatusID' => $this->iFatherStatusID,
            'iMotherStatusID' => $this->iMotherStatusID,
            'iFatherWorkingAsID' => $this->iFatherWorkingAsID,
            'iMotherWorkingAsID' => $this->iMotherWorkingAsID,
            'nob' => $this->nob,
            'nos' => $this->nos,
            'iCountryCAId' => $this->iCountryCAId,
            'iStateCAId' => $this->iStateCAId,
            'iDistrictCAID' => $this->iDistrictCAID,
            'iTalukaCAID' => $this->iTalukaCAID,
            'iCityCAId' => $this->iCityCAId,
            'completed_step' => $this->completed_step,
        ]);

        $query->andFilterWhere(['like', 'auth_key', $this->auth_key])
            ->andFilterWhere(['like', 'password_hash', $this->password_hash])
            ->andFilterWhere(['like', 'password_reset_token', $this->password_reset_token])
            ->andFilterWhere(['like', 'email', $this->email])
            ->andFilterWhere(['like', 'Registration_Number', $this->Registration_Number])
            ->andFilterWhere(['like', 'Mobile', $this->Mobile])
            ->andFilterWhere(['like', 'Profile_created_for', $this->Profile_created_for])
            ->andFilterWhere(['like', 'First_Name', $this->First_Name])
            ->andFilterWhere(['like', 'Last_Name', $this->Last_Name])
            ->andFilterWhere(['like', 'Gender', $this->Gender])
            ->andFilterWhere(['like', 'Birth_Place', $this->Birth_Place])
            ->andFilterWhere(['like', 'eFirstVerificationMailStatus', $this->eFirstVerificationMailStatus])
            ->andFilterWhere(['like', 'toc', $this->toc])
            ->andFilterWhere(['like', 'county_code', $this->county_code])
            ->andFilterWhere(['like', 'vAreaName', $this->vAreaName])
            ->andFilterWhere(['like', 'cnb', $this->cnb])
            ->andFilterWhere(['like', 'vSkinTone', $this->vSkinTone])
            ->andFilterWhere(['like', 'vBodyType', $this->vBodyType])
            ->andFilterWhere(['like', 'vSmoke', $this->vSmoke])
            ->andFilterWhere(['like', 'vDrink', $this->vDrink])
            ->andFilterWhere(['like', 'vSpectaclesLens', $this->vSpectaclesLens])
            ->andFilterWhere(['like', 'vDiet', $this->vDiet])
            ->andFilterWhere(['like', 'tYourSelf', $this->tYourSelf])
            ->andFilterWhere(['like', 'vDisability', $this->vDisability])
            ->andFilterWhere(['like', 'propic', $this->propic])
            ->andFilterWhere(['like', 'pin_email_vaerification', $this->pin_email_vaerification])
            ->andFilterWhere(['like', 'eSameAddress', $this->eSameAddress])
            ->andFilterWhere(['like', 'vAreaNameCA', $this->vAreaNameCA])
            ->andFilterWhere(['like', 'vNativePlaceCA', $this->vNativePlaceCA])
            ->andFilterWhere(['like', 'vParentsResiding', $this->vParentsResiding])
            ->andFilterWhere(['like', 'vFamilyAffluenceLevel', $this->vFamilyAffluenceLevel])
            ->andFilterWhere(['like', 'vFamilyType', $this->vFamilyType])
            ->andFilterWhere(['like', 'vFamilyProperty', $this->vFamilyProperty])
            ->andFilterWhere(['like', 'vDetailRelative', $this->vDetailRelative])
            ->andFilterWhere(['like', 'eEmailVerifiedStatus', $this->eEmailVerifiedStatus])
            ->andFilterWhere(['like', 'ePhoneVerifiedStatus', $this->ePhoneVerifiedStatus]);

        return $dataProvider;
    }
}
