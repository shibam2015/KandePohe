<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "partners_family_values".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $family_values_id
 * @property string $created_on
 * @property string $modified_on
 */
class PartnersFamilyValues extends \common\models\base\basePartnersFamilyValues
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_family_values';
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
            [['user_id', 'family_values_id'], 'required'],
            [['user_id', 'family_values_id'], 'integer'],
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
            'family_values_id' => 'Family Values ID',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }

    public function getFamilyValueName()
    {
        return $this->hasOne(Famil::className(), ['ID' => 'family_values_id']);
    }
}
