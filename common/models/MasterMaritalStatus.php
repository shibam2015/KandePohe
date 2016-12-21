<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_marital_status".
 *
 * @property integer $iMaritalStatusID
 * @property string $vName
 * @property string $eStatus
 */
class MasterMaritalStatus extends \common\models\base\baseMasterMaritalStatus
{

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
            'iMaritalStatusID' => 'Marital Status ID',
            'vName' => 'Marital Status',
            'eStatus' => 'Marital Status Status',
        ];
    }
}
