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
            'iSmsFormatId' => 'I Sms Format ID',
            'vSmsFormatType' => 'V Sms Format Type',
            'vSmsInformation' => 'V Sms Information',
            'vSmsMessage' => 'V Sms Message',
            'vComment' => 'V Comment',
        ];
    }
}
