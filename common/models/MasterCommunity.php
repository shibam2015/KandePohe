<?php

namespace common\models;

use Yii;

class MasterCommunity extends \common\models\base\baseMasterCommunity
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
            'iCommunity_ID' => 'Community ID',
            'vName' => 'Community',
            'eStatus' => 'Community Status',
        ];
    }
}
