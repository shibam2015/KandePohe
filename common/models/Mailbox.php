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

    public static function getLastMail($Id, $ToUserId)
    {
        $LastMessage = Static::find()
            ->where(['from_user_id' => $ToUserId, 'to_user_id' => $Id])
            ->orWhere(['from_user_id' => $Id, 'to_user_id' => $ToUserId])
            ->orderBy(['MailId' => SORT_DESC])->one();
        return $LastMessage;

    }

    public static function getMailList($Id, $ToUserId)
    {
        $LastMessage = Static::find()
            ->where(['from_user_id' => $ToUserId, 'to_user_id' => $Id])
            ->orWhere(['from_user_id' => $Id, 'to_user_id' => $ToUserId])
            ->orderBy(['MailId' => SORT_DESC])->all();
        return $LastMessage;

    }

    public static function getMailListCount($Id, $ToUserId)
    {
        return Static::find()
            ->where(['from_user_id' => $ToUserId, 'to_user_id' => $Id])
            ->orWhere(['from_user_id' => $Id, 'to_user_id' => $ToUserId])
            ->orderBy(['MailId' => SORT_DESC])->count();

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_user_id', 'to_user_id', 'MailContent', 'subject', 'dtadded', 'from_reg_no', 'to_reg_no'], 'required'],
            [['from_user_id', 'to_user_id'], 'integer'],
            [['MailContent', 'subject', 'status'], 'string'],
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
            'dtadded' => 'Dtadded',
            'from_reg_no' => 'From Reg No',
            'to_reg_no' => 'To Reg No',
            'status' => 'Status',
            'msg_type' => 'Message Type'
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_ADD => ['from_user_id', 'to_user_id', 'MailContent', 'subject', 'dtadded', 'from_reg_no', 'to_reg_no'],
            self::SCENARIO_UPDATE => ['from_user_id', 'to_user_id', 'MailContent', 'subject', 'dtadded', 'from_reg_no', 'to_reg_no'],
            self::SCENARIO_SEND_MESSAGE => ['from_user_id', 'to_user_id', 'MailContent', 'subject', 'dtadded', 'from_reg_no', 'to_reg_no', 'msg_type'],
        ];
    }

    public function getMailBox()
    {
        return $this->hasOne(Mailbox::className(), ['ID' => 'RaashiId']);
    }
}
