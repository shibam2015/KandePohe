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
    public static function getMessageNotification($MessageType = 'S', $MessageAction = '')
    {
        $MessageDbForValue = SiteMessages::findOne(['message_action' => $MessageAction, 'message_type' => $MessageType]);
        $MessageDbForTitle = SiteMessages::findOne(['message_action' => $MessageAction, 'message_type' => 'T']);
        #CommonHelper::pr($MessageDbForValue);CommonHelper::pr($MessageDbForTitle);exit;
        return array($MessageType, $MessageDbForValue->message_value, $MessageDbForTitle->message_value);
    }
}

?>