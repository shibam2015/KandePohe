<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_fathers_status".
 *
 * @property integer $iPartners_Fathers_ID
 * @property integer $iUser_ID
 * @property integer $iFather_Status_ID
 * @property string $dtCreated
 * @property string $dtModified
 */
class PartnersFathersStatus extends \common\models\base\basePartnersFathersStatus
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_fathers_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            //[['iUser_ID', 'iFather_Status_ID'], 'required'],
            //[['iUser_ID', 'iFather_Status_ID'], 'integer'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iPartners_Fathers_ID' => 'I Partners  Fathers  ID',
            'iUser_ID' => 'I User  ID',
            'iFather_Status_ID' => 'Father Status',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }

    public static function findByUserId($userid) {

        return static::findOne(['iUser_id' => $userid]);
    }

    public function getFatherStatus() {

        return $this->hasOne(MasterFmStatus ::className(), ['iFMStatusID' => 'iFather_Status_ID']);
    }
}
