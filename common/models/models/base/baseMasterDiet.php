<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "master_diet".
 *
 * @property integer $iDietID
 * @property string $vName
 * @property string $eStatus
 */
class baseMasterDiet extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_diet';
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
            'iDietID' => 'I Diet ID',
            'vName' => 'V Name',
            'eStatus' => 'E Status',
        ];
    }
}
