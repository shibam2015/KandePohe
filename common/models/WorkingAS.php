<?php

namespace common\models;

use Yii;

class WorkingAS extends \common\models\base\baseWorkingAS
{
    
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
            'iWorkingAsID' => 'Working As ID',
            'vWorkingAsName' => 'Working As',
            'eStatus' => 'Status',
        ];
    }
}
