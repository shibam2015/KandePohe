<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_drink".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property string $drink_type
 * @property string $is_partner_preference
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersDrink extends \common\models\base\basePartnersSmoke
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_drink';
    }

    public static function findAllByUserId($UserId)
    {

        return static::findAll(['user_id' => $UserId]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'drink_type'], 'required'],
            [['user_id'], 'integer'],
            [['is_partner_preference'], 'string'],
            [['created_on', 'modified_on'], 'safe'],
            [['drink_type'], 'string', 'max' => 100],
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
            'drink_type' => 'Drink Type',
            'is_partner_preference' => 'Partner Preference',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }
}
