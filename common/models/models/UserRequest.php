<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "user_request".
 *
 * @property integer $id
 * @property integer $from_user_id
 * @property integer $to_user_id
 * @property string $send_request_status
 * @property string $short_list_status
 * @property string $block_status
 * @property string $like_status
 * @property string $profile_viewed
 * @property string $phone_number_viewed
 * @property string $date_send_request
 * @property string $date_accept_request
 * @property string $date_decline_request
 * @property string $date_block
 */
class UserRequest extends \common\models\base\baseUserRequest
{
    const SCENARIO_SEND_INTEREST = 'SEND INTEREST';
    const SCENARIO_PROFILE_VIEWED_BY = 'PROFILE VIEWED BY';

    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_request';
    }

    public static function findProfileViewedByUserList($id, $Limit)
    {
        return static::find()->joinWith([fromUserInfo])->where(['to_user_id' => $id, 'profile_viewed' => 'Yes'])->limit($Limit)->all();

    }

    public static function checkSendInterest($id, $ToUserId)
    {
        return static::find()
            ->where("(from_user_id = $id AND to_user_id = $ToUserId OR (from_user_id = $ToUserId AND to_user_id = $id)) AND  send_request_status = 'Yes' ")
            ->one();
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['id', 'from_user_id', 'to_user_id', 'date_send_request', 'date_accept_request', 'date_decline_request', 'date_block'], 'required'],
            [['id', 'from_user_id', 'to_user_id'], 'integer'],
            [['send_request_status', 'short_list_status', 'block_status', 'like_status', 'profile_viewed', 'phone_number_viewed'], 'string'],
            [['date_send_request', 'date_accept_request', 'date_decline_request', 'date_block'], 'safe'],
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
            'send_request_status' => 'Send Request Status',
            'short_list_status' => 'Short List Status',
            'block_status' => 'Block Status',
            'like_status' => 'Like Status',
            'profile_viewed' => 'Profile Viewed',
            'phone_number_viewed' => 'Phone Number Viewed',
            'date_send_request' => 'Date Send Request',
            'date_accept_request' => 'Date Accept Request',
            'date_decline_request' => 'Date Decline Request',
            'date_block' => 'Date Block',
        ];
    }

    public function scenarios()
    {
        return [
            self::SCENARIO_SEND_INTEREST => ['from_user_id', 'to_user_id', 'send_request_status', 'date_send_request'],
            self::SCENARIO_PROFILE_VIEWED_BY => ['from_user_id', 'to_user_id', 'profile_viewed'],

        ];

    }

    public function findSendRequest($id, $ToUserId)
    {
        return static::findOne(['from_user_id' => $id, 'to_user_id' => $ToUserId]);
    }

    public function checkUsers($id, $ToUserId)
    {
        return static::find()
            ->where("from_user_id = $id AND to_user_id = $ToUserId")
            ->one();
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
