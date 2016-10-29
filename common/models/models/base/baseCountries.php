<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property integer $iCountryId
 * @property string $vCode
 * @property string $vCountryName
 * @property string $eStatus
 */
class baseCountries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vCode', 'vCountryName'], 'required'],
            [['eStatus'], 'string'],
            [['vCode'], 'string', 'max' => 3],
            [['vCountryName'], 'string', 'max' => 150],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iCountryId' => 'I Country ID',
            'vCode' => 'V Code',
            'vCountryName' => 'V Country Name',
            'eStatus' => 'E Status',
        ];
    }
}
