<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "partners_family_type".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property string $family_type
 * @property string $created_on
 * @property string $modified_on
 */
class basePartnersFamilyType extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_family_type';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'family_type'], 'required'],
            [['user_id'], 'integer'],
            [['created_on', 'modified_on'], 'safe'],
            [['family_type'], 'string', 'max' => 50],
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
            'family_type' => 'Family Type',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }
}