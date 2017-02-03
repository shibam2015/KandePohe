<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "partners_preferred_dress_type".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $dress_style_id
 * @property string $is_partner_preference
 * @property string $created_on
 * @property string $modified_on
 */
class basePartnersPreferredDressType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_preferred_dress_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'dress_style_id'], 'required'],
            [['user_id', 'dress_style_id'], 'integer'],
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
            'dress_style_id' => 'Dress Style ID',
            'is_partner_preference' => 'Is Partner Preference',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }
}
