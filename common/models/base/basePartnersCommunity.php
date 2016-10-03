<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "partners_community".
 *
 * @property integer $iPartners_Community_ID
 * @property integer $iUser_ID
 * @property integer $iCommunity_ID
 * @property string $dtCreated
 * @property string $dtModified
 */
class basePartnersCommunity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_community';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iUser_ID', 'iCommunity_ID'], 'required'],
            [['iUser_ID', 'iCommunity_ID'], 'integer'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iPartners_Community_ID' => 'I Partners  Community  ID',
            'iUser_ID' => 'I User  ID',
            'iCommunity_ID' => 'I Community  ID',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }
}
