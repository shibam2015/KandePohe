<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "site_messages".
 *
 * @property integer $id
 * @property string $message_action
 * @property string $message_type
 * @property string $message_value
 */
class baseSiteMessages extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'site_messages';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['message_action', 'message_value', 'Subject'], 'required'],
            [['message_type', 'message_value'], 'string'],
            [['message_action'], 'string', 'max' => 200],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'message_action' => 'Message Action',
            'message_type' => 'Message Type',
            'message_value' => 'Message Value',
            'Subject' => 'Subject',
        ];
    }
}
