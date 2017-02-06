<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_countries".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $country_id
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersCountries extends \common\models\base\basePartnersCountries
{
    const SCENARIO_ADD = 'ADD';
    const SCENARIO_UPDATE = 'Update';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_countries';
    }

    public static function findByUserId($UserId)
    {
        return static::findOne(['user_id' => $UserId]);
    }

    public static function findAllByUserId($UserId)
    {

        return static::findAll(['user_id' => $UserId]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'country_id'], 'required'],
            [['user_id', 'country_id'], 'integer'],
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
            'country_id' => 'Country',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['user_id', 'country_id', 'modified_on'],
            self::SCENARIO_UPDATE => ['user_id', 'country_id', 'modified_on'],
        ];

    }

    public function getCountryName()
    {
        return $this->hasOne(Countries::className(), ['iCountryId' => 'country_id']);
    }
}
