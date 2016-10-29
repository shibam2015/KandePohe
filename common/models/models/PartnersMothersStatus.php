<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_mothers_status".
 *
 * @property integer $iPartners_Mother_ID
 * @property integer $iUser_ID
 * @property integer $iMother_Status_ID
 * @property string $dtCreated
 * @property string $dtModified
 */
class PartnersMothersStatus extends \common\models\base\basePartnersMothersStatus
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_mothers_status';
    }

    public static function findByUserId($userid)
    {

        return static::findOne(['iUser_id' => $userid]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // [['iUser_ID', 'iMother_Status_ID'], 'required'],
            //[['iUser_ID', 'iMother_Status_ID'], 'integer'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iPartners_Mother_ID' => 'I Partners  Mother  ID',
            'iUser_ID' => 'I User  ID',
            'iMother_Status_ID' => 'Mother Status',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }

    public function getMotherStatus()
    {

        return $this->hasOne(MasterFmStatus::className(), ['iFMStatusID' => 'iMother_Status_ID']);
    }
}
