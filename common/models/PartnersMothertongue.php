<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_mothertongue".
 *
 * @property integer $iPartners_Mothertongue_ID
 * @property integer $iUser_ID
 * @property integer $iMothertongue_ID
 * @property string $dtCreated
 * @property string $dtModified
 */
class PartnersMothertongue extends \common\models\base\basePartnersMothertongue
{
    const SCENARIO_ADD = 'ADD';
    const SCENARIO_UPDATE = 'Update';
    public static function tableName()
    {
        return 'partners_mothertongue';
    }

    public static function findByUserId($userid)
    {
        return static::findOne(['iUser_ID' => $userid]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iUser_ID', 'iMothertongue_ID'], 'required'],
            [['iUser_ID', 'iMothertongue_ID'], 'integer'],
            [['dtCreated', 'dtModified'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iPartners_Mothertongue_ID' => 'Partners  Mothertongue  ID',
            'iUser_ID' => 'User  ID',
            'iMothertongue_ID' => 'Mothertongue',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['iUser_ID', 'iMothertongue_ID', 'dtModified'],
            self::SCENARIO_UPDATE => ['iUser_ID', 'iMothertongue_ID', 'dtModified'],
        ];
    }

    public function getPartnersMothertongueName()
    {
        return $this->hasOne(MotherTongue::className(), ['ID' => 'iMothertongue_ID']);
    }
}
