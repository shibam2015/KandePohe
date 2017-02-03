<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "partners_family_affluence_level".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $family_affluence_level_id
 * @property string $created_on
 * @property string $modified_on
 */
class basePartnersFamilyAffluenceLevel extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_family_affluence_level';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'family_affluence_level_id'], 'required'],
            [['user_id', 'family_affluence_level_id'], 'integer'],
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
            'family_affluence_level_id' => 'Family Affluence Level ID',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }
}
