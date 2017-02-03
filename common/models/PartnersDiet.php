<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_diet".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $diet_id
 * @property string $is_partner_preference
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersDiet extends \common\models\base\basePartnersDiet
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_diet';
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
            [['user_id', 'diet_id'], 'required'],
            [['user_id', 'diet_id'], 'integer'],
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
            'diet_id' => 'Diet ID',
            'is_partner_preference' => 'Partner Preference',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function getDietName()
    {
        return $this->hasOne(MasterDiet::className(), ['iDietID' => 'diet_id']);
    }
}
