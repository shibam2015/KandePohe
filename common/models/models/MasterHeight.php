<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_height".
 *
 * @property integer $iHeightID
 * @property string $vName
 * @property string $eStatus
 */
class MasterHeight extends \common\models\base\baseMasterHeight
{
    /**
     * @inheritdoc
     */
    /*public static function tableName()
    {
        return 'master_height';
    }*/

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
            'iHeightID' => 'Height ID',
            'vName' => 'Height',
            'eStatus' => 'Status',
        ];
    }
}
