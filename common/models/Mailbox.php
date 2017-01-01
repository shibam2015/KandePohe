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

    public static function getLastMailDetails($Id, $ToUserId)
    {
        $LastMessageDetails = Static::find()
            ->where(['from_user_id' => $ToUserId, 'to_user_id' => $Id])
            #->orWhere(['from_user_id' => $Id, 'to_user_id' => $ToUserId])
            ->orderBy(['MailId' => SORT_DESC])->one();
        return $LastMessageDetails;

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

    public static function updateFromToReadStatus($FromUserId, $ToUserId)
    {
        return static::updateAll(array('read_status' => 'Yes'), 'from_user_id="' . $FromUserId . '" AND to_user_id="' . $ToUserId . '"');
    }

    public static function getInboxList($Id, $Limit = '')
    {
        $WhereLimit = '';
        if ($Limit == '') {
            $Limit = 0;
        }
        return Static::find()
            ->where(['to_user_id' => $Id])
            ->limit($Limit)
            ->groupBy(['to_user_id', 'from_user_id'])
            ->all();
        #->orderBy(['MailId' => SORT_DESC])->all();
    }

    public static function getInboxNewList($Id, $Limit = '')
    {
        $WhereLimit = '';
        if ($Limit == '') {
            $Limit = 0;
        }
        return Static::find()
            ->where(['to_user_id' => $Id])
            ->andWhere(['!=', 'from_user_id', $Id])
            ->andwhere(['read_status' => 'NO'])
            ->limit($Limit)
            ->groupBy(['to_user_id', 'from_user_id'])
            ->all();
    }

    public static function getInboxAcceptedList($Id, $Limit = '')
    {
        $WhereLimit = '';
        if ($Limit == '') {
            $Limit = 0;
        }
        return Static::find()
            ->where(['from_user_id' => $Id])
            ->andwhere(['msg_type' => 'AcceptInterest'])
            ->limit($Limit)
            ->groupBy(['to_user_id', 'from_user_id'])
            ->all();
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

    public function getFromUserInfo()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }

    public function getToUserInfo()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }

}
