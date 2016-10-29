<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_fm_status".
 *
 * @property integer $iFMStatusID
 * @property string $vName
 * @property string $eStatus
 */
class MasterFmStatus extends \common\models\base\baseMasterFmStatus
{
    /**
     * @inheritdoc
     */
    /*public static function tableName()
    {
        return 'master_fm_status';
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
            'iFMStatusID' => 'I Fmstatus ID',
            'vName' => 'V Name',
            'eStatus' => 'E Status',
        ];
    }
}
