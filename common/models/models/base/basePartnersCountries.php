<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "partners_countries".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $country_id
 * @property string $created_on
 * @property string $modified_on
 */
class basePartnersCountries extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_countries';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'country_id'], 'required'],
            [['user_id', 'country_id'], 'integer'],
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
            'country_id' => 'Country ID',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }
}
