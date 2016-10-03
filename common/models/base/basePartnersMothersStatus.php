<?php

namespace common\models\base;

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
class basePartnersMothersStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_mothers_status';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iUser_ID', 'iMother_Status_ID'], 'required'],
            [['iUser_ID', 'iMother_Status_ID'], 'integer'],
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
            'iMother_Status_ID' => 'I Mother  Status  ID',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }
}
