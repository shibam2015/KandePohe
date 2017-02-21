<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_raashi".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $raashi_id
 * @property string $is_partner_preference
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersRaashi extends \common\models\base\basePartnersRaashi
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_raashi';
    }

    public static function findByUserId($userid)
    {

        return static::findOne(['user_id' => $userid]);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'raashi_id'], 'required'],
            [['user_id', 'raashi_id'], 'integer'],
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
            'raashi_id' => 'Raashi',
            'is_partner_preference' => 'Is Partner Preference',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function getRaashiName()
    {
        return $this->hasOne(Raashi::className(), ['ID' => 'raashi_id']);
    }
}
