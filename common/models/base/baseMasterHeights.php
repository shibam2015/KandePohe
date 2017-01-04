<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "master_heights".
 *
 * @property integer $iHeightID
 * @property string $name
 * @property double $Centimeters
 * @property string $eStatus
 */
class baseMasterHeights extends \yii\db\ActiveRecord
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
            [['name', 'Centimeters'], 'required'],
            [['Centimeters'], 'number'],
            [['eStatus'], 'string'],
            [['name'], 'string', 'max' => 20],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iHeightID' => 'I Height ID',
            'name' => 'Name',
            'Centimeters' => 'Centimeters',
            'eStatus' => 'E Status',
        ];
    }
}
