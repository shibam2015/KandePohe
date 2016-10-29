<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_cities".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $city_id
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersCities extends \common\models\base\basePartnersCities
{
    const SCENARIO_ADD = 'ADD';
    const SCENARIO_UPDATE = 'Update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_cities';
    }

    public static function findByUserId($userid)
    {
        return static::findOne(['user_id' => $userid]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'city_id'], 'required'],
            [['user_id', 'city_id'], 'integer'],
            [['created_on', 'modified_on'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'user_id' => 'User ID',
            'city_id' => 'City',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['user_id', 'city_id', 'modified_on'],
            self::SCENARIO_UPDATE => ['user_id', 'city_id', 'modified_on'],
        ];
    }

    public function getCityName()
    {
        return $this->hasOne(Cities::className(), ['iCityId' => 'city_id']);
    }

}
