<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "master_marital_status".
 *
 * @property integer $iMaritalStatusID
 * @property string $vName
 * @property string $eStatus
 */
class baseMasterMaritalStatus extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_marital_status';
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
            'iMaritalStatusID' => 'I Marital Status ID',
            'vName' => 'V Name',
            'eStatus' => 'E Status',
        ];
    }
}
