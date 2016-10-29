<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "master_taluka".
 *
 * @property integer $iTalukaID
 * @property string $vName
 * @property string $eStatus
 */
class baseMasterTaluka extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_taluka';
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
            'iTalukaID' => 'I Taluka ID',
            'vName' => 'V Name',
            'eStatus' => 'E Status',
        ];
    }
}
