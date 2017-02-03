<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_favourite_cousines".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $cousines_id
 * @property string $is_partner_preference
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersFavouriteCousines extends \common\models\base\basePartnersFavouriteMusic
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_favourite_cousines';
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
            [['user_id', 'cousines_id'], 'required'],
            [['user_id', 'cousines_id'], 'integer'],
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
            'cousines_id' => 'Cousines ID',
            'is_partner_preference' => 'Partner Preference',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function getCousinesName()
    {
        return $this->hasOne(FavouriteCousines::className(), ['ID' => 'cousines_id']);
    }
}
