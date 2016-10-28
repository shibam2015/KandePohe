<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "wightege".
 *
 * @property integer $iWightege
 * @property string $vWightegeName
 * @property string $vWightegePercent
 */
class Wightege extends \common\models\base\baseWightege
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
            [['vWightegeName'], 'string'],
            [['vWightegePercent'], 'integer'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iWightege' => 'Wightege',
            'vWightegeName' => 'Step Name',
            'vWightegePercent' => 'Wightege In Percent',
        ];
    }
}
