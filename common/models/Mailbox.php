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
    const SEND_INTEREST = 'SendInterest';
    const ACCEPT_INTEREST = 'AcceptInterest';
    const DECLINE_INTEREST = 'DeclineInterest';
    const CANCEL_INTEREST = 'CancelInterest';
    const CUSTOM_MESSAGE = 'Custom';

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
            ->orWhere(['from_user_id' => $Id, 'to_user_id' => $ToUserId])
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

    /* INBOX TAB START */
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
            ->andwhere(['msg_type' => self::ACCEPT_INTEREST])
            ->limit($Limit)
            ->groupBy(['to_user_id', 'from_user_id'])
            ->all();
    }

    public static function getInboxDeclinedList($Id, $Limit = '')
    {
        $WhereLimit = '';
        if ($Limit == '') {
            $Limit = 0;
        }
        return Static::find()
            ->where(['from_user_id' => $Id])
            ->andwhere(['msg_type' => self::DECLINE_INTEREST])
            ->limit($Limit)
            ->groupBy(['to_user_id', 'from_user_id'])
            ->all();
    }

    public static function getInboxRepliedList($Id, $Limit = '')
    {
        $WhereLimit = '';
        if ($Limit == '') {
            $Limit = 0;
        }
        $Sql = "SELECT * FROM
                  (SELECT *
                      FROM mailbox
                      WHERE
                          from_user_id = $Id
		              GROUP BY from_user_id, to_user_id
                  )AS records
                ORDER BY dtadded  ";
        $Data = Static::findBySql($Sql)->all();
        return $Data;
    }
    /* INBOX TAB END  */

    /* SENT TAB START */
    public static function getSentboxAll($Id, $Limit = '')
    {
        $WhereLimit = '';
        if ($Limit == '') {
            $Limit = 0;
        }
        $Sql = "SELECT * FROM
                  (SELECT *
                      FROM mailbox
                      WHERE
                          from_user_id = $Id
		              GROUP BY from_user_id, to_user_id
                  )AS records
                ORDER BY dtadded DESC";
        $Data = Static::findBySql($Sql)->all();
        return $Data;
    }

    public static function getSentboxUnread($Id, $Limit = '')
    {
        $WhereLimit = '';
        if ($Limit == '') {
            $Limit = 0;
        }
        $Sql = "SELECT * FROM
                  (SELECT *
                      FROM mailbox
                      WHERE
                          from_user_id = $Id AND read_status = 'No'
		              GROUP BY from_user_id, to_user_id
                  )AS records
                ORDER BY dtadded DESC";
        $Data = Static::findBySql($Sql)->all();
        return $Data;
    }

    public static function getSentboxAccepted($Id, $Limit = '')
    {
        $WhereLimit = '';
        if ($Limit == '') {
            $Limit = 0;
        }
        $Data = Static::find()
            ->where(['to_user_id' => $Id])
            ->andwhere(['msg_type' => self::ACCEPT_INTEREST])
            ->limit($Limit)
            ->groupBy(['to_user_id', 'from_user_id'])
            ->all();
        return $Data;
    }

    public static function getSentboxDeclined($Id, $Limit = '')
    {
        $WhereLimit = '';
        if ($Limit == '') {
            $Limit = 0;
        }
        $Data = Static::find()
            ->where(['to_user_id' => $Id])
            ->andwhere(['msg_type' => self::DECLINE_INTEREST])
            ->limit($Limit)
            ->groupBy(['to_user_id', 'from_user_id'])
            ->all();
        return $Data;
    }

    public static function getSentboxReplied($Id, $Limit = '')
    {
        $WhereLimit = '';
        if ($Limit == '') {
            $Limit = 0;
        }
        $Sql = "SELECT * FROM
                  (SELECT *
                      FROM mailbox
                      WHERE
                          to_user_id = $Id
		              GROUP BY from_user_id, to_user_id
                  )AS records
                ORDER BY dtadded DESC";
        $Data = Static::findBySql($Sql)->all();
        return $Data;
    }

    public static function getSentboxReadNotReplied($Id, $Limit = '')
    {
        $WhereLimit = '';
        if ($Limit == '') {
            $Limit = 0;
        }
        $Sql = "SELECT * FROM
                  (SELECT *
                      FROM mailbox
                      WHERE
                          to_user_id = $Id AND read_status = 'Yes'
		              GROUP BY from_user_id, to_user_id
                  )AS records
                ORDER BY dtadded DESC";
        $Data = Static::findBySql($Sql)->all();
        return $Data;
    }
    /* SENT TAB END */

    public static function getComposeMailUserList($Id)
    {
        $Sql = "SELECT * FROM mailbox
                  WHERE (msg_type in ('" . self::ACCEPT_INTEREST . "','" . self::SEND_INTEREST . "')) AND ((to_user_id=$Id) OR (from_user_id=$Id)) GROUP BY to_user_id,from_user_id";
        $Data = Static::findBySql($Sql)->all();
        return $Data;
    }

    public static function getUnreadMailCount($Id)
    {
        return Static::find()
            ->where(['to_user_id' => $Id])
            ->andWhere(['!=', 'from_user_id', $Id])
            ->andwhere(['read_status' => 'NO'])
            ->groupBy(['to_user_id', 'from_user_id'])
            ->count();
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
            'to_user_id' => 'To User ',
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
