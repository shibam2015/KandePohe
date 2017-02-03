<?php

namespace common\models\base;

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
class basePartnersFamilyValues extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_family_values';
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
}
