<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sports_fitn_activities".
 *
 * @property integer $ID
 * @property string $Name
 * @property string $created_on
 * @property string $modified_on
 */
class SportsFitnActivities extends \common\models\base\baseSportsFitnActivities
{

    const SCENARIO_ADD = 'ADD';
    const SCENARIO_UPDATE = 'Update';

    public static function tableName()
    {
        return 'sports_fitn_activities';
    }

    public static function getSportsNames($SportsString)
    {
        return static::find()->select('Name')->where('ID In (' . $SportsString . ')')->all();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['Name', 'created_on', 'modified_on'], 'required'],
            [['created_on', 'modified_on'], 'safe'],
            [['Name'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'Name' => 'Sports Fitness Activities',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['Name', 'created_on', 'modified_on'],
            self::SCENARIO_UPDATE => ['Name', 'modified_on'],
        ];

    }
}
