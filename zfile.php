http://blog.neattutorials.com/angularjs-and-yii2-part-2-authentication/

Yii::$app->homeUrl

setTimeout(function(){

}, 3000);

# FOR LOADER
$('.main-section').pleaseWait();
$('#test').pleaseWait('stop');


$PIN_P = CommonHelper::generateNumericUniqueToken(4);
$model->pin_phone_vaerification = $PIN_P;
$SMS_FLAG = SmsHelper::SendSMS($PIN_P, $model->Mobile);



#echo $query->createCommand()->sql;
#print_r($query->createCommand()->getRawSql());

return $this->redirect(Yii::$app->request->referrer);  // Last Url

list($year, $month, $day) = explode("-", $dob);


http://demos.krajee.com/editable#usage-inline


Yii::$app->params['uploadPath'] = Yii::$app->basePath . '/uploads/';
Yii::$app->params['uploadUrl'] = Yii::$app->urlManager->baseUrl . '/uploads/';


<!-- JSON -->

$return = array('STATUS' => $STATUS, 'MESSAGE' => $MESSAGE, 'OUTPUT' => $OUTPUT_HTML);
#Yii::$app->response->format = Response::FORMAT_JSON;
return json_encode($return);exit;


<!-- NOTIFICATION -->
notificationPopup(DataObject.STATUS, DataObject.MESSAGE);


<!-- GET USER PHOTO PROFILE-->
public static function getPhotos($TYPE = 'USER', $ID, $PHOTO, $SIZE)


<!-- Complete Meter -->
1 => mandatory Step
2 => Basic Details
3 => Education &amp; Occupation
4 => Lifestyle &amp; Appearance
5 => Family
6 => About Yourself
7 => Profile Photo
8 => Phone Verification
9 => Email Verification
10 => Approved User
11 => Facebook User
//setCompletedStep()
//wightegeCheck($7)

1,2,3,4,5,6,7,9,10

<!-- Mail -->
use common\components\MailHelper;
MailHelper::mailFormate("asd asd ad a asd asd a","Vikrant");
exit;

MailHelper::SendMail('EMAIL_VERIFICATION_PIN');
exit;


$MAIL_DATA = array("EMAIL"=>$model->email,"NAME"=>$model->First_Name." ".$model->Last_Name);
MailHelper::SendMail('VERIFY_ACCOUNT',$MAIL_DATA);

\common\components\MailHelper::SendMail('VERIFY_ACCOUNT',array());

list($STATUS, $MESSAGE, $TITLE) = \common\components\MessageHelper::getMessageNotification();
echo " ST => ".$STATUS." === > MS ".$MESSAGE." ===> ".$TITLE;


->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name . '.com'])


-----------------------------------

SELECT * FROM table WHERE 3 IN (NUMBERS) AND 15 IN (NUMBERS)
using the IN will look into a comma separated string eg. these two

WHERE banana IN ('apple', 'banana', 'coconut')
WHERE 3 IN (2,3,6,8,90)


echo CommonHelper::getSiteUrlLogo();exit;


-------------------------------------------------
On successful verification of Mobile and email PIN, redirect user to Dashboard with popup saying “Verification is successful”
Cropping


<button class="btn btn-default" id="waitMe_ex_close" onclick="loaderStop()">STOP</button>
<button class="btn btn-default" id="waitMe_ex_close" onclick="loaderStart()">start</button>