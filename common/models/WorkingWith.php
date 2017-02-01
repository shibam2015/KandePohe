<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "working_with".
 *
 * @property integer $iWorkingWithID
 * @property string $vWorkingWithName
 * @property string $eStatus
 */
class WorkingWith extends \common\models\base\baseWorkingWith
{
    public static function getWorkingWithNames($iWorkingWithID)
    {
        return static::find()->select('vWorkingWithName')->where('iWorkingWithID In (' . $iWorkingWithID . ')')->all();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vWorkingWithName'], 'required'],
            [['eStatus'], 'string'],
            [['vWorkingWithName'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iWorkingWithID' => 'Working With ID',
            'vWorkingWithName' => 'Working With ',
            'eStatus' => 'Status',
        ];
    }
}
