<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_taluka".
 *
 * @property integer $iTalukaID
 * @property string $vName
 * @property string $eStatus
 */
class MasterTaluka extends \common\models\base\baseMasterTaluka
{
    /**
     * @inheritdoc
     */
    /*public static function tableName()
    {
        return 'master_taluka';
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
            'iTalukaID' => 'Taluka ID',
            'vName' => 'Taluka Name',
            'eStatus' => 'Taluka Status',
        ];
    }
}
