<?php

namespace common\models\base;

use Yii;

/**
 * This is the model class for table "mailbox".
 *
 * @property integer $MailId
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property string $MailContent
 * @property string $subject
 * @property string $dtadded
 * @property string $from_reg_no
 * @property string $to_reg_no
 * @property string $status
 * @property string $msg_type
 */
class baseMailbox extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
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
            [['from_user_id', 'to_user_id', 'MailContent', 'subject', 'dtadded', 'from_reg_no', 'to_reg_no'], 'required'],
            [['from_user_id', 'to_user_id'], 'integer'],
            [['MailContent', 'subject', 'status', 'msg_type'], 'string'],
            [['dtadded', 'msg_type'], 'safe'],
            [['from_reg_no', 'to_reg_no'], 'string', 'max' => 15],
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
            'subject' => 'Subject',
            'dtadded' => 'added',
            'from_reg_no' => 'From Reg No',
            'to_reg_no' => 'To Reg No',
            'status' => 'Status',
            'msg_type' => 'Message Type',
        ];
    }
}
