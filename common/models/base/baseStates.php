<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "states".
 *
 * @property integer $iStateId
 * @property string $vStateName
 * @property integer $iCountryId
 * @property string $eStatus
 */
class baseStates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'states';
    }

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
            'iStateId' => 'I State ID',
            'vStateName' => 'V State Name',
            'iCountryId' => 'I Country ID',
            'eStatus' => 'E Status',
        ];
    }
}
