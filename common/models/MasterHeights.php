<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_heights".
 *
 * @property integer $iHeightID
 * @property string $vName
 * @property double $Centimeters
 * @property string $eStatus
 */
class MasterHeights extends \common\models\base\baseMasterHeights
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_heights';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vName', 'Centimeters'], 'required'],
            [['Centimeters'], 'number'],
            [['eStatus'], 'string'],
            [['vName'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iHeightID' => 'Height ID',
            'vName' => 'Name',
            'Centimeters' => 'Centimeters',
            'eStatus' => 'Status',
        ];
    }
}
