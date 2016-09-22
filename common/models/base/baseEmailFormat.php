<?php

namespace common\models\base;

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
class baseEmailFormat extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
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
            'iEmailFormatId' => 'I Email Format ID',
            'vEmailFormatTitle' => 'V Email Format Title',
            'vEmailFormatType' => 'V Email Format Type',
            'vEmailFormatSubject' => 'V Email Format Subject',
            'tEmailFormatDesc' => 'T Email Format Desc',
            'vDescriptionDisplay' => 'V Description Display',
            'vTags' => 'V Tags',
        ];
    }
}
