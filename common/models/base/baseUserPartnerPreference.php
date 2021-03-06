<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "user_partner_preference".
 *
 * @property integer $ID
 * @property integer $iUser_id
 * @property string $age_from
 * @property string $age_to
 * @property string $no_of_childs
 * @property string $childs_living_with_you
 * @property string $height_from
 * @property string $height_to
 * @property string $weight_from
 * @property string $weight_to
 * @property string $health_information
 * @property string $any_disability
 * @property string $manglik
 * @property string $drink
 * @property string $smoke
 * @property string $created_on
 * @property string $modified_on
 * @property string $LookingFor
 * @property integer $annual_income_from
 * @property integer $annual_income_to
 */
class baseUserPartnerPreference extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_partner_preference';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['iUser_id', 'age_from', 'age_to', 'no_of_childs', 'childs_living_with_you', 'height_from', 'height_to', 'weight_from', 'weight_to', 'health_information', 'created_on', 'modified_on', 'LookingFor', 'annual_income_from', 'annual_income_to'], 'required'],
            [['iUser_id', 'annual_income_from', 'annual_income_to'], 'integer'],
            [['age_from', 'age_to', 'no_of_childs', 'childs_living_with_you', 'height_from', 'height_to', 'weight_from', 'weight_to', 'health_information', 'any_disability', 'manglik', 'drink', 'smoke', 'LookingFor'], 'string'],
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
            'iUser_id' => 'I User ID',
            'age_from' => 'Age From',
            'age_to' => 'Age To',
            'no_of_childs' => 'No Of Childs',
            'childs_living_with_you' => 'Childs Living With You',
            'height_from' => 'Height From',
            'height_to' => 'Height To',
            'weight_from' => 'Weight From',
            'weight_to' => 'Weight To',
            'health_information' => 'Health Information',
            'any_disability' => 'Any Disability',
            'manglik' => 'Manglik',
            'drink' => 'Drink',
            'smoke' => 'Smoke',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
            'LookingFor' => 'Looking For',
            'annual_income_from' => 'Annual Income From',
            'annual_income_to' => 'Annual Income To',
        ];
    }
}
