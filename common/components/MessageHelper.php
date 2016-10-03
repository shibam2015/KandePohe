<?php
/**
 *     Use For : Message or Notification.
 */
namespace common\components;

use common\models\EmailFormat;
use Yii;

class MessageHelper
{

    public static function getMessageNotification($TYPE = 'S', $ACTION = '')
    {
        // Replace #email#;
        return array('Success', 'Hello', 'Test Msg');
    }
}

?>