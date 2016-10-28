<?php

namespace common\models;

use Yii;

class AnnualIncome extends \common\models\base\baseAnnualIncome
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['vAnnualIncome'], 'required'],
            [['vStatus'], 'string'],
            [['vAnnualIncome'], 'string', 'max' => 250],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'iAnnualIncomeID' => 'Annual Income ID',
            'vAnnualIncome' => 'Annual Income',
            'vStatus' => 'Status',
        ];
    }
}
