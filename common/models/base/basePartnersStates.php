<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "partners_states".
 *
 * @property integer $ID
 * @property integer $user_id
 * @property integer $state_id
 * @property string $created_on
 * @property string $modified_on
 */
class basePartnersStates extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'partners_states';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id', 'state_id'], 'required'],
            [['user_id', 'state_id'], 'integer'],
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
            'state_id' => 'State ID',
            'created_on' => 'Created On',
            'modified_on' => 'Modified On',
        ];
    }
}
