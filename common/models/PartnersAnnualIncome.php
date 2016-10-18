<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_annual_income".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $annual_income_id
 * @property string $is_partner_preference
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersAnnualIncome extends \common\models\base\basePartnersAnnualIncome
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_annual_income';
    }

    public static function findByUserId($userid)
    {

        return static::findOne(['user_id' => $userid]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'annual_income_id'], 'required'],
            [['user_id', 'annual_income_id'], 'integer'],
            [['is_partner_preference'], 'string'],
            [['created_on', 'modified_on'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'ID' => 'ID',
            'user_id' => 'User ID',
            'annual_income_id' => 'Annual Income',
            'is_partner_preference' => 'Is Partner Preference',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function getAnnualIncomeName()
    {
        return $this->hasOne(AnnualIncome::className(), ['iAnnualIncomeID' => 'annual_income_id']);
    }
}
