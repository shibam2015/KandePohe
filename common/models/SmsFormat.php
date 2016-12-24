<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sms_format".
 *
 * @property integer $iSmsFormatId
 * @property string $vSmsFormatType
 * @property string $vSmsInformation
 * @property string $vSmsMessage
 * @property string $vComment
 */
class SmsFormat extends \common\models\base\baseSmsFormat
{
    /**
     * @inheritdoc
     */
    const SCENARIO_ADD = 'ADD';
    const SCENARIO_UPDATE = 'Update';

    public static function tableName()
    {
        return 'sms_format';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vSmsFormatType', 'vSmsInformation', 'vSmsMessage', 'vComment'], 'required'],
            [['vSmsMessage', 'vComment'], 'string'],
            [['vSmsFormatType', 'vSmsInformation'], 'string', 'max' => 100],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iSmsFormatId' => 'Sms Format ID',
            'vSmsFormatType' => 'Sms Format Type',
            'vSmsInformation' => 'Sms Information',
            'vSmsMessage' => 'Sms Message',
            'vComment' => 'Comment',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['vSmsFormatType', 'vSmsInformation', 'vSmsMessage', 'vComment'],
            self::SCENARIO_UPDATE => ['vSmsFormatType', 'vSmsInformation', 'vSmsMessage', 'vComment'],
        ];

    }
}
