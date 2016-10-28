<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "states".
 *
 * @property integer $iStateId
 * @property string $vStateName
 * @property integer $iCountryId
 * @property string $eStatus
 */
class States extends \common\models\base\baseStates
{
    /**
     * @inheritdoc
     */
    /*public static function tableName()
    {
        return 'states';
    }*/

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vStateName'], 'required'],
            [['iCountryId'], 'integer'],
            [['eStatus'], 'string'],
            [['vStateName'], 'string', 'max' => 30],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iStateId' => 'State ID',
            'vStateName' => 'State Name',
            'iCountryId' => 'Country Name',
            'eStatus' => 'Status',
        ];
    }

    public function getCountryName()
    {
        #echo " hello "; print_r($this->hasOne(Countries::className(), ['iCountryId' => 'iCountryId']));exit;
        return $this->hasOne(Countries::className(), ['iCountryId' => 'iCountryId']);
    }
}
