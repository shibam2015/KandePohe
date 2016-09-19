<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "cities".
 *
 * @property integer $iCityId
 * @property string $vCityName
 * @property integer $iStateId
 * @property string $eStatus
 */
class Cities extends \common\models\base\baseCities
{
    /**
     * @inheritdoc
     */
    /*public static function tableName()
    {
        return 'cities';
    }*/

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
            'iCityId' => 'City ID',
            'vCityName' => 'City Name',
            'iStateId' => 'State ID',
            'eStatus' => 'City Status',
        ];
    }
    
     /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(User::className(), ['iCityId' => 'iCityId']);
    } 
}
