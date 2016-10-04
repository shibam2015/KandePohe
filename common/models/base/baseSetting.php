<?php

namespace common\models\base;

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
class baseSetting extends \yii\db\ActiveRecord
{
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
            'eStatus' => 'E Status',
            'ConfigType' => 'Config Type',
            'ElemetType' => 'Elemet Type',
        ];
    }
}
