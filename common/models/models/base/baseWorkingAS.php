<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "working_as".
 *
 * @property integer $iWorkingAsID
 * @property string $vWorkingAsName
 * @property string $eStatus
 */
class baseWorkingAS extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'working_as';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vWorkingAsName'], 'required'],
            [['eStatus'], 'string'],
            [['vWorkingAsName'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iWorkingAsID' => 'I Working As ID',
            'vWorkingAsName' => 'V Working As Name',
            'eStatus' => 'E Status',
        ];
    }
}
