<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "mailbox".
 *
 * @property integer $MailId
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property string $MailContent
 */
class Mailbox extends \common\models\base\baseMailbox
{
    const SCENARIO_ADD = 'ADD';
    const SCENARIO_UPDATE = 'Update';
    const SCENARIO_SEND_MESSAGE = 'Send Message';

    public static function tableName()
    {
        return 'mailbox';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            #[['from_user_id', 'to_user_id', 'MailContent'], 'required'],
            [['MailContent'], 'required'],
            [['from_user_id', 'to_user_id'], 'integer'],
            [['MailContent'], 'string'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'MailId' => 'Mail ID',
            'from_user_id' => 'From User ID',
            'to_user_id' => 'To User ID',
            'MailContent' => 'Mail Content',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['from_user_id', 'to_user_id', 'MailContent'],
            self::SCENARIO_UPDATE => ['from_user_id', 'to_user_id', 'MailContent'],
            self::SCENARIO_SEND_MESSAGE => ['from_user_id', 'to_user_id', 'MailContent'],

        ];

    }

    public function getMailBox()
    {
        return $this->hasOne(Mailbox::className(), ['ID' => 'RaashiId']);
    }
}
