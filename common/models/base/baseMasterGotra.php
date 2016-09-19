<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "master_gotra".
 *
 * @property integer $iGotraID
 * @property string $vName
 * @property string $eStatus
 */
class baseMasterGotra extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_gotra';
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
            'iGotraID' => 'I Gotra ID',
            'vName' => 'V Name',
            'eStatus' => 'E Status',
        ];
    }
}
