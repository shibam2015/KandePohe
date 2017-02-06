<?php

namespace common\models;

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
class PartnersCommunity extends \common\models\base\basePartnersCommunity
{
    const SCENARIO_ADD = 'ADD';
    const SCENARIO_UPDATE = 'Update';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_community';
    }

    public static function findByUserId($userid)
    {

        return static::findOne(['iUser_ID' => $userid]);
    }

    public static function findAllByUserId($UserId)
    {

        return static::findAll(['iUser_ID' => $UserId]);
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
            'iPartners_Community_ID' => 'Partners Community ID',
            'iUser_ID' => 'User ID',
            'iCommunity_ID' => 'Community',
            'dtCreated' => 'Dt Created',
            'dtModified' => 'Dt Modified',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['iUser_ID', 'iCommunity_ID', 'dtModified'],
            self::SCENARIO_UPDATE => ['iUser_ID', 'iCommunity_ID', 'dtModified'],
        ];
    }

    public function getCommunityName()
    {
        return $this->hasOne(MasterCommunity::className(), ['iCommunity_ID' => 'iCommunity_ID']);
    }
}
