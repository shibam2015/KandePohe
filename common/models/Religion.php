<?php

namespace common\models;

use common\components\CommonHelper;
use Yii;

class Religion extends \common\models\base\baseReligion
{

    public static function getReligionNames($RelisionIds)
    {
        return static::find()->select('vName')->where('iReligion_ID In (' . $RelisionIds . ')')->all();
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
            'iReligion_ID' => 'Religion ID',
            'vName' => 'Religion',
            'eStatus' => 'Religion Status',
        ];
    }
}
