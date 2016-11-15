<?php

namespace common\models\base;

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
class baseUserRequestOp extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_request_op';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['from_user_id', 'to_user_id', 'date_send_request_from_to', 'date_accept_request_from_to', 'date_decline_request_from_to', 'date_block_from_to', 'send_request_status_to_from', 'date_send_request_to_from', 'date_accept_request_to_from', 'date_decline_request_to_from', 'date_block_to_from'], 'required'],
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
}
