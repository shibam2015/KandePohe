<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_nadi".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $nadi_id
 * @property string $is_partner_preference
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersNadi extends \common\models\base\basePartnersNadi
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_nadi';
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
            [['user_id', 'nadi_id'], 'required'],
            [['user_id', 'nadi_id'], 'integer'],
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
            'nadi_id' => 'Nadi',
            'is_partner_preference' => 'Is Partner Preference',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function getNadiName()
    {
        return $this->hasOne(Nadi::className(), ['ID' => 'nadi_id']);
    }
}
