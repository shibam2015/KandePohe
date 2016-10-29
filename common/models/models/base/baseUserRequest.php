<?php

namespace common\models\base;

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
class baseUserRequest extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_request';
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
}
