<?php

namespace common\models;

use common\components\CommonHelper;
use Yii;

/**
 * This is the model class for table "user_request_op".
 *
 * @property integer $id
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property string $send_request_status_from_to
 * @property string $short_list_status_from_to
 * @property string $block_status_from_to
 * @property string $like_status_from_to
 * @property string $profile_viewed_from_to
 * @property string $phone_number_viewed_from_to
 * @property string $date_send_request_from_to
 * @property string $date_accept_request_from_to
 * @property string $date_decline_request_from_to
 * @property string $date_block_from_to
 * @property string $send_request_status_to_from
 * @property string $short_list_status_to_from
 * @property string $block_status_to_from
 * @property string $like_status_to_from
 * @property string $profile_viewed_to_from
 * @property string $phone_number_viewed_to_from
 * @property string $date_send_request_to_from
 * @property string $date_accept_request_to_from
 * @property string $date_decline_request_to_from
 * @property string $date_block_to_from
 */
class UserRequestOp extends \common\models\base\baseUserRequestOp
{
    const SCENARIO_SEND_INTEREST = 'SEND INTEREST';
    const SCENARIO_PROFILE_VIEWED_BY = 'PROFILE VIEWED BY';
    const SCENARIO_ACCEPT_INTEREST = 'Accept Interest Request';
    const SCENARIO_DECLINE_INTEREST = 'Decline Interest Request';
    const SCENARIO_CANCEL_INTEREST = 'Cancel Interest Request';
    const SCENARIO_SHORTLIST_INTEREST = 'Short List User Request';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_request_op';
    }

    public static function findProfileViewedByUserList($id, $Limit)
    {
        $sql = "SELECT user_request_op.*, user.DOB, user.iHeightID FROM user_request_op  LEFT JOIN  user ON user.status IN ('" . User::STATUS_ACTIVE . "','" . User::STATUS_APPROVE . "')  WHERE (user_request_op.from_user_id = " . $id . " AND user_request_op.profile_viewed_to_from = 'Yes' ) OR (user_request_op.to_user_id = " . $id . " AND user_request_op.profile_viewed_from_to = 'Yes') GROUP BY user_request_op.id ORDER BY user_request_op.id DESC LIMIT " . $Limit;
        return Static::findBySql($sql)->all();
        #return static::find()->joinWith([fromUserInfo])->where(['to_user_id' => $id, 'profile_viewed_from_to' => 'Yes'])->orderBy(['id' => SORT_DESC])->limit($Limit)->all();
    }

    public static function checkSendInterest($id, $ToUserId)
    {
        return static::find()
            ->where("((from_user_id = $id AND to_user_id = $ToUserId ) OR (from_user_id = $ToUserId AND to_user_id = $id ))")
            ->one();
        /*return static::find()
            ->where("((from_user_id = $id AND to_user_id = $ToUserId ) OR (from_user_id = $ToUserId AND to_user_id = $id )) AND  (send_request_status_to_from = 'Yes' OR send_request_status_from_to = 'Yes' )")
            ->one();*/
    }

    public static function checkUsers($id, $ToUserId)
    {
        return static::find()
            ->where("(from_user_id = $id AND to_user_id = $ToUserId) OR (from_user_id = $ToUserId AND to_user_id = $id)")
            ->one();
    }

    public static function getInboxList($id, $Limit = '')
    {
        $WhereLimit = '';
        if ($Limit != '') {
            $WhereLimit = ' LIMIT ' . $Limit;
        }
        $sql = "SELECT user_request_op.*, user.DOB, user.iHeightID FROM user_request_op LEFT JOIN  user ON user.status IN ('" . User::STATUS_ACTIVE . "','" . User::STATUS_APPROVE . "')  WHERE (user_request_op.to_user_id = " . $id . " AND user_request_op.send_request_status_from_to != 'No' ) OR (user_request_op.from_user_id = " . $id . " AND user_request_op.send_request_status_to_from != 'No') GROUP BY user_request_op.id ORDER BY user_request_op.id DESC " . $WhereLimit;
        return Static::findBySql($sql)->all();
        /*$sql = "SELECT user_request_op.*, user.DOB, user.iHeightID FROM user_request_op LEFT JOIN  user ON user.status IN ('" . User::STATUS_ACTIVE . "','" . User::STATUS_APPROVE . "')  WHERE (user_request_op.to_user_id = " . $id . " AND user_request_op.send_request_status_from_to != 'No' ) OR (user_request_op.from_user_id = " . $id . " AND user_request_op.send_request_status_to_from != 'No') GROUP BY user_request_op.id ORDER BY user_request_op.id DESC LIMIT " . $Limit;*/


    }

    public static function getMoreConversationInbox($Id, $ToUserId)
    {
        $sql = "SELECT user_request_op.*, user.DOB, user.iHeightID FROM user_request_op LEFT JOIN  user ON user.status IN ('" . User::STATUS_ACTIVE . "','" . User::STATUS_APPROVE . "')  WHERE (user_request_op.from_user_id = " . $ToUserId . " AND user_request_op.to_user_id = " . $Id . " OR user_request_op.send_request_status_from_to != 'No' ) OR (user_request_op.to_user_id = " . $ToUserId . " AND user_request_op.from_user_id = " . $Id . " OR user_request_op.send_request_status_to_from != 'No') GROUP BY user_request_op.id ORDER BY user_request_op.id DESC ";
        return Static::findBySql($sql)->one();
        /*$sql = "SELECT user_request_op.*, user.DOB, user.iHeightID FROM user_request_op LEFT JOIN  user ON user.status IN ('" . User::STATUS_ACTIVE . "','" . User::STATUS_APPROVE . "')  WHERE (user_request_op.from_user_id = " . $ToUserId . " AND user_request_op.to_user_id = " . $Id . " AND user_request_op.send_request_status_from_to != 'No' ) OR (user_request_op.to_user_id = " . $ToUserId . " AND user_request_op.from_user_id = " . $Id . " AND user_request_op.send_request_status_to_from != 'No') GROUP BY user_request_op.id ORDER BY user_request_op.id DESC ";*/

    }

    public static function getSendBoxList($id, $Limit)
    {
        $sql = "SELECT user_request_op.*, user.DOB, user.iHeightID FROM user_request_op LEFT JOIN  user ON user.status IN ('" . User::STATUS_ACTIVE . "','" . User::STATUS_APPROVE . "')  WHERE (user_request_op.from_user_id = " . $id . " AND  user_request_op.send_request_status_from_to != 'No' ) OR (user_request_op.to_user_id = " . $id . " AND  user_request_op.send_request_status_to_from != 'No') GROUP BY user_request_op.id ORDER BY user_request_op.id DESC LIMIT " . $Limit;
        return Static::findBySql($sql)->all();
        /*$sql = "SELECT user_request_op.*, user.DOB, user.iHeightID FROM user_request_op LEFT JOIN  user ON user.status IN ('" . User::STATUS_ACTIVE . "','" . User::STATUS_APPROVE . "')  WHERE (user_request_op.from_user_id = " . $id . " AND user_request_op.send_request_status_from_to != 'No' ) OR (user_request_op.to_user_id = " . $id . " AND user_request_op.send_request_status_to_from != 'No') GROUP BY user_request_op.id ORDER BY user_request_op.id DESC LIMIT " . $Limit;*/

    }

    public static function getMoreConversationSentBox($Id, $ToUserId)
    {
        $sql = "SELECT user_request_op.*, user.DOB, user.iHeightID FROM user_request_op LEFT JOIN  user ON user.status IN ('" . User::STATUS_ACTIVE . "','" . User::STATUS_APPROVE . "')  WHERE (user_request_op.from_user_id = " . $Id . " AND user_request_op.to_user_id = " . $ToUserId . " AND user_request_op.send_request_status_from_to != 'No' ) OR (user_request_op.to_user_id = " . $Id . " AND user_request_op.from_user_id = " . $ToUserId . " AND user_request_op.send_request_status_to_from != 'No') GROUP BY user_request_op.id ORDER BY user_request_op.id DESC ";
        return Static::findBySql($sql)->one();

    }

    public static function getShortList($id, $Limit = '', $Offset = '')
    {
        $WhereLimit = '';
        if ($Limit != '') {
            $WhereLimit = ' LIMIT ' . $Limit;
        }
        $sql = "SELECT user_request_op.*, user.DOB, user.iHeightID FROM user_request_op LEFT JOIN  user ON user.status IN ('" . User::STATUS_ACTIVE . "','" . User::STATUS_APPROVE . "')  WHERE (user_request_op.to_user_id = " . $id . " AND user_request_op.short_list_status_from_to != 'No' ) OR (user_request_op.from_user_id = " . $id . " AND user_request_op.short_list_status_to_from != 'No') GROUP BY user_request_op.id ORDER BY user_request_op.id DESC " . $WhereLimit;
        return Static::findBySql($sql)->offset($Offset)->limit($Limit)->all();

    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_user_id', 'to_user_id', 'date_send_request_from_to', 'date_accept_request_from_to', 'date_decline_request_from_to', 'date_block_from_to', 'send_request_status_to_from', 'date_send_request_to_from', 'date_accept_request_to_from', 'date_decline_request_to_from', 'date_block_to_from'], 'safe'],
            [['from_user_id', 'to_user_id'], 'integer'],
            [['send_request_status_from_to', 'short_list_status_from_to', 'block_status_from_to', 'like_status_from_to', 'profile_viewed_from_to', 'phone_number_viewed_from_to', 'send_request_status_to_from', 'short_list_status_to_from', 'block_status_to_from', 'like_status_to_from', 'profile_viewed_to_from', 'phone_number_viewed_to_from'], 'string'],
            [['date_send_request_from_to', 'date_accept_request_from_to', 'date_decline_request_from_to', 'date_block_from_to', 'date_send_request_to_from', 'date_accept_request_to_from', 'date_decline_request_to_from', 'date_block_to_from'], 'safe'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'from_user_id' => 'From User ID',
            'to_user_id' => 'To User ID',
            'send_request_status_from_to' => 'Send Request Status From To',
            'short_list_status_from_to' => 'Short List Status From To',
            'block_status_from_to' => 'Block Status From To',
            'like_status_from_to' => 'Like Status From To',
            'profile_viewed_from_to' => 'Profile Viewed From To',
            'phone_number_viewed_from_to' => 'Phone Number Viewed From To',
            'date_send_request_from_to' => 'Date Send Request From To',
            'date_accept_request_from_to' => 'Date Accept Request From To',
            'date_decline_request_from_to' => 'Date Decline Request From To',
            'date_block_from_to' => 'Date Block From To',
            'send_request_status_to_from' => 'Send Request Status To From',
            'short_list_status_to_from' => 'Short List Status To From',
            'block_status_to_from' => 'Block Status To From',
            'like_status_to_from' => 'Like Status To From',
            'profile_viewed_to_from' => 'Profile Viewed To From',
            'phone_number_viewed_to_from' => 'Phone Number Viewed To From',
            'date_send_request_to_from' => 'Date Send Request To From',
            'date_accept_request_to_from' => 'Date Accept Request To From',
            'date_decline_request_to_from' => 'Date Decline Request To From',
            'date_block_to_from' => 'Date Block To From',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_SEND_INTEREST => ['from_user_id', 'to_user_id', 'send_request_status_from_to', 'send_request_status_to_from', 'date_send_request_from_to', 'date_send_request_to_from'],
            self::SCENARIO_PROFILE_VIEWED_BY => ['from_user_id', 'to_user_id', 'profile_viewed_from_to', 'profile_viewed_to_from'],
            self::SCENARIO_ACCEPT_INTEREST => ['from_user_id', 'to_user_id', 'send_request_status_from_to', 'date_accept_request_from_to', 'send_request_status_to_from', 'date_accept_request_to_from'],
            self::SCENARIO_DECLINE_INTEREST => ['from_user_id', 'to_user_id', 'send_request_status_from_to', 'date_decline_request_from_to', 'send_request_status_to_from', 'date_decline_request_to_from'],
            self::SCENARIO_CANCEL_INTEREST => ['from_user_id', 'to_user_id', 'send_request_status_from_to', 'send_request_status_to_from'],
            self::SCENARIO_SHORTLIST_INTEREST => ['from_user_id', 'to_user_id', 'short_list_status_from_to', 'short_list_status_to_from'],

        ];

    }

    public function findSendRequest($id, $ToUserId)
    {
        return static::findOne(['from_user_id' => $id, 'to_user_id' => $ToUserId]);
    }

    public function getFromUserInfo()
    {
        return $this->hasOne(User::className(), ['id' => 'from_user_id']);
    }

    public function getToUserInfo()
    {
        return $this->hasOne(User::className(), ['id' => 'to_user_id']);
    }

    public function getUserInfo()
    {
        return $this->hasOne(User::className(), ['status' => [User::STATUS_ACTIVE, User::STATUS_APPROVE]]);
    }
}
