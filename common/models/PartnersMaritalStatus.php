<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_marital_status".
 *
 * @property integer $iPartners_Marital_Status_ID
 * @property integer $iUser_ID
 * @property integer $iMarital_Status_ID
 * @property string $dtCreated
 * @property string $dtModified
 */
class PartnersMaritalStatus extends \common\models\base\basePartnersMaritalStatus
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_marital_status';
    }

    public static function findByUserId($UserID)
    {

        return static::findOne(['iUser_id' => $UserID]);
    }

    public static function findAllByUserId($UserID)
    {

        return static::findAll(['iUser_id' => $UserID]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['iUser_ID', 'iMarital_Status_ID'], 'required'],
            //[['iUser_ID', 'iMarital_Status_ID'], 'integer'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iPartners_Marital_Status_ID' => 'I Partners  Marital  Status  ID',
            'iUser_ID' => 'I User  ID',
            'iMarital_Status_ID' => 'Marital Status',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }

    public function getMaritalStatusName()
    {
        return $this->hasOne(MasterMaritalStatus::className(), ['iMaritalStatusID' => 'iMarital_Status_ID']);
    }
}
