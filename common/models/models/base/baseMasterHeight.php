<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "master_height".
 *
 * @property integer $iHeightID
 * @property string $vName
 * @property string $eStatus
 */
class baseMasterHeight extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_height';
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
            'iHeightID' => 'I Height ID',
            'vName' => 'V Name',
            'eStatus' => 'E Status',
        ];
    }
}
