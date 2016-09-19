<?php

namespace common\models;

use Yii;

class EducationLevel extends \common\models\base\baseEducationLevel
{
    

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vEducationLevelName'], 'required'],
            [['status'], 'string'],
            [['vEducationLevelName'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iEducationLevelID' => 'Education Level ID',
            'vEducationLevelName' => 'Education Level',
            'status' => 'Status',
        ];
    }
}
