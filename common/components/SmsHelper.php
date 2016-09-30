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
            $username = "kapsbulk1"; //use your sms api username
            $pass = "Kaptrans*10000";  //enter your password
            $WKEY = "A18e2a3f84d385bf3d746b56ee864a7ba";
            $dest_mobileno = $MOBILE_NO;//reciever 10 digit number (use comma (,) for multiple users. eg: 9999999999,8888888888,7777777777)
            $sms = "OTP for your mobile number verification is " . $CODE . ". Do not share this OTP with anyone for security reasons
";//sms content
            $senderid = 'KAPMSG';//use your sms api sender id
            #$sms_url = sprintf("http://123.63.33.43/blank/sms/user/urlsmstemp.php?username=XXXXXX&pass=XXXXX&senderid=XXXXX&dest_mobileno=XXXXX&message=XXXXXX&mtype=UNI&response=Y", $username, $pass , $senderid, $dest_mobileno, $message, urlencode($sms) );
            $sms_url = "http://trans.kapsystem.com/api/web2sms.php?workingkey=" . $WKEY . "&to=" . $dest_mobileno . "&sender=" . $senderid . "&message=" . urlencode($sms);
            $SMS_RESPONSE = SmsHelper::openurl($sms_url);
            #echo "<pre>"; print_r($SMS_RESPONSE);exit;
            return 1;
        } else {
            return 0;
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
        #echo $url;
    }
}

?>


