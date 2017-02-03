<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_interest".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $interest_id
 * @property string $is_partner_preference
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersInterest extends \common\models\base\basePartnersInterest
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_interest';
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
            [['user_id', 'interest_id'], 'required'],
            [['user_id', 'interest_id'], 'integer'],
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
            'interest_id' => 'Interest ID',
            'is_partner_preference' => 'Partner Preference',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function getInterestName()
    {
        return $this->hasOne(Interests::className(), ['ID' => 'interest_id']);
    }
}
