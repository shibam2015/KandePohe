<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "working_with".
 *
 * @property integer $iWorkingWithID
 * @property string $vWorkingWithName
 * @property string $eStatus
 */
class baseWorkingWith extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'working_with';
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
            'iWorkingWithID' => 'I Working With ID',
            'vWorkingWithName' => 'V Working With Name',
            'eStatus' => 'E Status',
        ];
    }
}
