<?php
/**     Helper For : SMS
 *   #9738023400
 */
namespace common\components;

use Yii;

class SmsHelper
{
    public static function SendSMS($CODE, $MOBILE_NO)
    {
        #$CODE = 8485;
        #$MOBILE_NO = '8000255245';
        if ($CODE != '' && $MOBILE_NO != '') {
            $UserName = "kotp-parsley"; //use your sms api username
            $Password = "kaptrans";  //enter your password
            $DestinationMobileNo = $MOBILE_NO;//reciever 10 digit number (use comma (,) for multiple users. eg: 9999999999,8888888888,7777777777)
            $Message = "Your OTP is " . $CODE . " for  completing your registration on Kande-Pohe.com. Code is valid only for 15 minutes. Team Kande Pohe Marathi Matrimony.";//sms content
            $SenderId = 'KPMATR';//use your sms api sender id
            #$sms_url = sprintf("http://123.63.33.43/blank/sms/user/urlsmstemp.php?username=XXXXXX&pass=XXXXX&senderid=XXXXX&dest_mobileno=XXXXX&message=XXXXXX&mtype=UNI&response=Y", $username, $pass , $senderid, $dest_mobileno, $message, urlencode($sms) );
            $sms_url = '';
            $sms_url .= "http://103.16.101.52:8080/sendsms/bulksms?";
            //&password=" . $dest_mobileno . "&sender=" . $senderid . "&message=" . urlencode($sms);
            $sms_url .= "username=" . $UserName;
            $sms_url .= "&password=" . $Password;
            $sms_url .= "&type=0";
            $sms_url .= "&dlr=1";
            $sms_url .= "&destination=" . $DestinationMobileNo;
            $sms_url .= "&source=" . $SenderId;
            $sms_url .= "&message=" . urlencode($Message);
            #echo $sms_url;
            //http://103.16.101.52:8080/sendsms/bulksms?username=kotp-parsley&password=kaptrans&type=0&dlr=1&destination=8000255245&source=KPMATR&message=test
            $SMSResponse = SmsHelper::openurl($sms_url);
            $TempArray = explode("|", $SMSResponse);
            #CommonHelper::pr($SMSResponse);exit;
            if ($TempArray[0] == 1701) {
                return array('S', '');
            } else {
                return array('E', Yii::$app->params['smsGetwayError']);
            }
        } else {
            return array('E', Yii::$app->params['smsGetwayError']);
        }
    }

    function openurl($url)
    {

        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $url);
        curl_setopt($ch, CURLOPT_POST, 1);
        curl_setopt($ch, CURLOPT_POSTFIELDS, $postvars);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, 1);
        curl_setopt($ch, CURLOPT_TIMEOUT, '3');
        $content = trim(curl_exec($ch));
        curl_close($ch);
        return $content;
        #echo $url;
    }
}

?>
