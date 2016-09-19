<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "wightege".
 *
 * @property integer $iWightege
 * @property string $vWightegeName
 * @property string $vWightegePercent
 */
class baseWightege extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'wightege';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vWightegeName', 'vWightegePercent'], 'required'],
            [['vWightegeName', 'vWightegePercent'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iWightege' => 'I Wightege',
            'vWightegeName' => 'V Wightege Name',
            'vWightegePercent' => 'V Wightege Percent',
        ];
    }
}
