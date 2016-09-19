<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_district".
 *
 * @property integer $iDistrictID
 * @property string $vName
 * @property string $eStatus
 */
class MasterDistrict extends \common\models\base\baseMasterDistrict
{
    /**
     * @inheritdoc
     */
    /*public static function tableName()
    {
        return 'master_district';
    }*/

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
            'iDistrictID' => 'District ID',
            'vName' => 'District Name',
            'eStatus' => 'District Status',
        ];
    }
}
