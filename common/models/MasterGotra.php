<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "master_gotra".
 *
 * @property integer $iGotraID
 * @property string $vName
 * @property string $eStatus
 */
class MasterGotra extends \common\models\base\baseMasterGotra
{
    /**
     * @inheritdoc
     */
    /*public static function tableName()
    {
        return 'master_gotra';
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
            'iGotraID' => 'Gotra ID',
            'vName' => 'Gotra Name',
            'eStatus' => 'Gotra Status',
        ];
    }
}
