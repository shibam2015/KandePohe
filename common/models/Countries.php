<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "countries".
 *
 * @property integer $iCountryId
 * @property string $vCode
 * @property string $vCountryName
 * @property string $eStatus
 */
class Countries extends \common\models\base\baseCountries
{
    /**
     * @inheritdoc
     */
    /*public static function tableName()
    {
        return 'countries';
    }*/

    public static function getCountryName($iCountryId)
    {
        return static::find()->select('vCountryName')->where('iCountryId In (' . $iCountryId . ')')->all();
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
            'iCountryId' => 'Country ID',
            'vCode' => 'Code',
            'vCountryName' => 'Country Name',
            'eStatus' => 'Status',
        ];
    }
}
