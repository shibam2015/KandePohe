<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_subcommunity".
 *
 * @property integer $iPartners_Subcommunity_ID
 * @property integer $iUser_ID
 * @property integer $iSub_Community_ID
 * @property string $dtCreated
 * @property string $dtModified
 */
class PartnersSubcommunity extends \common\models\base\basePartnersSubcommunity
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_subcommunity';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iUser_ID', 'iSub_Community_ID'], 'required'],
            [['iUser_ID', 'iSub_Community_ID'], 'integer'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iPartners_Subcommunity_ID' => 'I Partners  Subcommunity  ID',
            'iUser_ID' => 'I User  ID',
            'iSub_Community_ID' => 'I Sub  Community  ID',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }
}
