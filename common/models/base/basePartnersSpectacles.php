<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "partners_spectacles".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property string $type
 * @property string $is_partner_preference
 * @property string $created_on
 * @property string $modified_on
 */
class basePartnersSpectacles extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_spectacles';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'type'], 'required'],
            [['user_id'], 'integer'],
            [['is_partner_preference'], 'string'],
            [['created_on', 'modified_on'], 'safe'],
            [['type'], 'string', 'max' => 100],
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
            'type' => 'Type',
            'is_partner_preference' => 'Is Partner Preference',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }
}