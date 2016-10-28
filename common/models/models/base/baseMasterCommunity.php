<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "master_community".
 *
 * @property integer $iCommunity_ID
 * @property string $vName
 * @property string $eStatus
 */
class baseMasterCommunity extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_community';
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
            'iCommunity_ID' => 'I Community  ID',
            'vName' => 'V Name',
            'eStatus' => 'E Status',
        ];
    }
}
