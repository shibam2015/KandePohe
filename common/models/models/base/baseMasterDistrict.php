<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "master_district".
 *
 * @property integer $iDistrictID
 * @property string $vName
 * @property string $eStatus
 */
class baseMasterDistrict extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'master_district';
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
            'iDistrictID' => 'I District ID',
            'vName' => 'V Name',
            'eStatus' => 'E Status',
        ];
    }
}
