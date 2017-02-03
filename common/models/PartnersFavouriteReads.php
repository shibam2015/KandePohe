<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_favourite_reads".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $read_id
 * @property string $is_partner_preference
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersFavouriteReads extends \common\models\base\basePartnersFavouriteReads
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_favourite_reads';
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
            [['user_id', 'read_id'], 'required'],
            [['user_id', 'read_id'], 'integer'],
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
            'read_id' => 'Read ID',
            'is_partner_preference' => 'Partner Preference',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function getFavouriteReadsName()
    {
        return $this->hasOne(FavouriteReads::className(), ['ID' => 'read_id']);
    }
}
