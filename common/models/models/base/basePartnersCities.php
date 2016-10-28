<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "partners_cities".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $city_id
 * @property string $created_on
 * @property string $modified_on
 */
class basePartnersCities extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_cities';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'city_id'], 'required'],
            [['user_id', 'city_id'], 'integer'],
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
            'city_id' => 'City ID',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }
}
