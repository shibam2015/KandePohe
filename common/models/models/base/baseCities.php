<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property integer $iCityId
 * @property string $vCityName
 * @property integer $iStateId
 * @property string $eStatus
 */
class baseCities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vCityName', 'iStateId'], 'required'],
            [['iStateId'], 'integer'],
            [['eStatus'], 'string'],
            [['vCityName'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iCityId' => 'I City ID',
            'vCityName' => 'V City Name',
            'iStateId' => 'I State ID',
            'eStatus' => 'E Status',
        ];
    }
}
