<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "religion".
 *
 * @property integer $iReligion_ID
 * @property string $vName
 * @property string $eStatus
 */
class baseReligion extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'religion';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vName'], 'required'],
            [['eStatus'], 'string'],
            [['vName'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iReligion_ID' => 'I Religion  ID',
            'vName' => 'V Name',
            'eStatus' => 'E Status',
        ];
    }
}
