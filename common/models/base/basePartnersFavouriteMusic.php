<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "partners_favourite_music".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $music_name_id
 * @property string $is_partner_preference
 * @property string $created_on
 * @property string $modified_on
 */
class basePartnersFavouriteMusic extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_favourite_music';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'music_name_id'], 'required'],
            [['user_id', 'music_name_id'], 'integer'],
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
            'music_name_id' => 'Music Name ID',
            'is_partner_preference' => 'Is Partner Preference',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }
}
