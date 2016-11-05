<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_states".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $state_id
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersStates extends \common\models\base\basePartnersStates
{
    const SCENARIO_ADD = 'ADD';
    const SCENARIO_UPDATE = 'Update';
    public static function tableName()
    {
        return 'partners_states';
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
            [['user_id', 'state_id'], 'required'],
            [['user_id', 'state_id'], 'integer'],
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
            'state_id' => 'State',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['user_id', 'state_id', 'modified_on'],
            self::SCENARIO_UPDATE => ['user_id', 'state_id', 'modified_on'],
        ];

    }

    public function getStateName()
    {
        return $this->hasOne(States::className(), ['iStateId' => 'state_id']);
    }
}
