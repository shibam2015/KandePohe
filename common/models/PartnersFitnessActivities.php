<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_fitness_activities".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $fitness_id
 * @property string $is_partner_preference
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersFitnessActivities extends \common\models\base\basePartnersFitnessActivities
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_fitness_activities';
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
            [['user_id', 'fitness_id'], 'required'],
            [['user_id', 'fitness_id'], 'integer'],
            [['is_partner_preference'], 'string'],
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
            'fitness_id' => 'Fitness ID',
            'is_partner_preference' => 'Partner Preference',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function getFitnessActivityName()
    {
        return $this->hasOne(SportsFitnActivities::className(), ['ID' => 'fitness_id']);
    }

}
