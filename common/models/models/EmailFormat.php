<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "email_format".
 *
 * @property integer $iEmailFormatId
 * @property string $vEmailFormatTitle
 * @property string $vEmailFormatType
 * @property string $vEmailFormatSubject
 * @property string $tEmailFormatDesc
 * @property string $vDescriptionDisplay
 * @property string $vTags
 */
class EmailFormat extends \common\models\base\baseEmailFormat
{
    const SCENARIO_ADD = 'ADD';
    const SCENARIO_UPDATE = 'Update';

    public static function tableName()
    {
        return 'email_format';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vEmailFormatTitle', 'vEmailFormatType', 'vEmailFormatSubject', 'tEmailFormatDesc', 'vDescriptionDisplay', 'vTags'], 'required'],
            [['tEmailFormatDesc', 'vDescriptionDisplay', 'vTags'], 'string'],
            [['vEmailFormatTitle'], 'string', 'max' => 255],
            [['vEmailFormatType'], 'string', 'max' => 100],
            [['vEmailFormatSubject'], 'string', 'max' => 400],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iEmailFormatId' => 'Email Format ID',
            'vEmailFormatTitle' => ' Email Format Title',
            'vEmailFormatType' => ' Email Format Type',
            'vEmailFormatSubject' => ' Email Format Subject',
            'tEmailFormatDesc' => ' Email Format Desc',
            'vDescriptionDisplay' => ' Description Display',
            'vTags' => 'Tags',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['vEmailFormatTitle', 'vEmailFormatType', 'vEmailFormatSubject', 'tEmailFormatDesc'],
            self::SCENARIO_UPDATE => ['vEmailFormatTitle', 'vEmailFormatSubject', 'tEmailFormatDesc'],
        ];

    }
}
