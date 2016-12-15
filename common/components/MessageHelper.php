<?php
/**
 *     Use For : Message or Notification.
 *            Ex : MessageHelper::getMessageNotification('S','ACCOUNT_DELETE');
 */
namespace common\components;

use Yii;
use common\models\SiteMessages;
class MessageHelper
{
    public static function getMessageNotification($MessageType = 'S', $MessageAction = '', $DB_INFO = '')
    {
        $MessageDbForValue = SiteMessages::findOne(['message_action' => $MessageAction, 'message_type' => $MessageType]);
        $MessageDbForTitle = SiteMessages::findOne(['message_action' => $MessageAction, 'message_type' => 'T']);
        #CommonHelper::pr($MessageDbForValue);CommonHelper::pr($MessageDbForTitle);exit;
        $NotificationContentArray = array('#NAME#', '#EMAIL_TO#', '#EMAIL#', '#USER_NAME#');
        foreach ($NotificationContentArray as $Key => $Value) {
            $Array_Key = str_replace('#', '', $Value);
            if (array_key_exists($Array_Key, $DB_INFO)) {
                $MessageDbForValue->message_value = str_replace($Value, $DB_INFO[$Array_Key], $MessageDbForValue->message_value);
            }
        }
        return array($MessageType, $MessageDbForValue->message_value, $MessageDbForTitle->message_value);
    }
}

?>