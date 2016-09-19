<?php

namespace common\models;

use Yii;

class Religion extends \common\models\base\baseReligion
{
    
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
            'iReligion_ID' => 'Religion  ID',
            'vName' => 'Religion Name',
            'eStatus' => 'Religion Status',
        ];
    }
}
