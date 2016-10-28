<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "annual_income".
 *
 * @property integer $iAnnualIncomeID
 * @property string $vAnnualIncome
 * @property string $vStatus
 */
class baseAnnualIncome extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'annual_income';
    }

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
            'iAnnualIncomeID' => 'I Annual Income ID',
            'vAnnualIncome' => 'V Annual Income',
            'vStatus' => 'V Status',
        ];
    }
}
