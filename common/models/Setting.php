<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "setting".
 *
 * @property integer $id
 * @property string $SettingName
 * @property string $UseFor
 * @property string $SettingValue
 * @property string $eStatus
 * @property string $ConfigType
 * @property string $ElemetType
 */
class Setting extends \common\models\base\baseSetting
{

    const SCENARIO_ADD = 'ADD';
    const SCENARIO_UPDATE = 'Update';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'setting';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['SettingName', 'UseFor', 'SettingValue'], 'required'],
            [['SettingName', 'UseFor', 'SettingValue', 'eStatus', 'ConfigType', 'ElemetType'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'SettingName' => 'Setting Name',
            'UseFor' => 'Use For',
            'SettingValue' => 'Setting Value',
            'eStatus' => 'Status',
            'ConfigType' => 'Config Type',
            'ElemetType' => 'Elemet Type',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['SettingName', 'UseFor', 'SettingValue', 'eStatus', 'ConfigType', 'ElemetType'],
            self::SCENARIO_UPDATE => ['SettingName', 'UseFor', 'SettingValue', 'eStatus', 'ConfigType', 'ElemetType'],
        ];

    }
}
