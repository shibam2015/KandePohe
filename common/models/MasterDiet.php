<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_diet".
 *
 * @property integer $iDietID
 * @property string $vName
 * @property string $eStatus
 */
class MasterDiet extends \common\models\base\baseMasterDiet
{
    /**
     * @inheritdoc
     */
    /*public static function tableName()
    {
        return 'master_diet';
    }*/

    public static function getDietNames($iDietID)
    {
        return static::find()->select('vName')->where('iDietID In (' . $iDietID . ')')->all();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vName'], 'required'],
            [['vName', 'eStatus'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iDietID' => 'Diet ID',
            'vName' => 'Diet',
            'eStatus' => 'Status',
        ];
    }

}
