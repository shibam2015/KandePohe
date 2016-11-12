<?php
/**
 *     Use For : Sending Mail.
 */
namespace common\components;

use common\models\EmailFormat;
use Yii;
class MailHelper
{
    public static function SendMail($TYPE, $DB_INFO = '', $newsid = '')
    {
        $EMAIL_TEMPLATE = EmailFormat::findOne(['vEmailFormatType' => $TYPE]);
        #TO_EMAIL = 'parmarvikrantr@gmail.com';
        $TO_EMAIL = Yii::$app->params['adminEmail'];
        $MailContentArray = array('#NAME#', '#EMAIL_TO#', '#EMAIL#', '#ACTIVATION_LINK#', '#PIN#', '#COMMENT#', '#LINK#', '#EMAIL#', '#USER_NAME#', '#TODAY_DATE#', '#AGE#', '#HEIGHT#', '#RELIGION#', '#MOTHER_TONGUE#', '#COMMUNITY#', '#LOCATION#', '#EDUCATION#', '#PROFESSION#', '#ABOUT_ME#', '#PHOTO#');
        $MAIL_MESSAGE = $EMAIL_TEMPLATE->tEmailFormatDesc;
        foreach ($MailContentArray as $Key => $Value) {
            $Array_Key = str_replace('#', '', $Value);
            if (array_key_exists($Array_Key, $DB_INFO)) {
                $MAIL_MESSAGE = str_replace($Value, $DB_INFO[$Array_Key], $MAIL_MESSAGE);
                if ($Array_Key == 'EMAIL_TO') {
                    $TO_EMAIL = $DB_INFO[$Array_Key];
                }
                if ($Array_Key == 'ADMIN_EMAIL') {
                    $TO_EMAIL = Yii::$app->params['adminEmail'];
                }
            }
        }
        $TO_EMAIL = 'parmarvikrantr@gmail.com';
        $MAIL_SUBJECT = $EMAIL_TEMPLATE->vEmailFormatSubject;
        $MAIL_TITLE = $EMAIL_TEMPLATE->vEmailFormatTitle;
        $MAIL_SUBJECT = '=?UTF-8?B?' . base64_encode($MAIL_SUBJECT) . '?=';
        $MAIL_MESSAGE = MailHelper::mailFormat($MAIL_MESSAGE, $MAIL_TITLE);
        #echo " <br> TMESSAGE <br>".$MAIL_MESSAGE;exit;
        #$response = 1;
        $response = Yii::$app->mailer->compose()
            ->setTo($TO_EMAIL)
            #->setFrom(['kandepohetest@gmail.com' => Yii::$app->name])
            ->setFrom([Yii::$app->params['supportEmail'] => Yii::$app->name])
            ->setSubject($MAIL_SUBJECT)
            ->setHtmlBody($MAIL_MESSAGE)
            ->send();
        return $response;
    }

    public static function mailFormat($BODY_CONTENT, $TITLE)
    {
        $LOGO = CommonHelper::getSiteUrlLogo();
        $message = '';
        $message .= '
                <html>
                <head>
                <title>' . $TITLE . '</title>
                </head>
                <body>
                <div style="margin: 0;">
                    <table style="border-collapse: collapse;" border="0" width="100%" cellspacing="0" cellpadding="0" bgcolor="#F7F3F0">
                        <tbody>
                            <tr>
                                <td valign="top">
                                    <center style="width: 100%;">
                                        <div style="font-size: 1px; line-height: 1px; max-height: 0px; max-width: 0px; overflow: hidden; font-family: sans-serif;">&nbsp;</div>
                                        <div style="max-width: 600px;">
                                            <table style="background-color: #ea0b44 !important; max-width: 600px; border-top: 7px solid #FFC107;" border="0" width="100%" cellspacing="0" cellpadding="0" align="center" bgcolor="#ea0b44">
                                                <tbody>
                                                    <tr>
                                                        <td style="text-align: center; padding: 15px 0; font-family: sans-serif; font-weight: bold; color: #000000; font-size: 30px;">
                                                        <img src="' . $LOGO . '" width="157" height="61"
                                              alt="logo">
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table style="max-width: 600px; border-radius: 5px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="center" bgcolor="#FFFFFF">
                                                <tbody>
                                                    <tr>
                                                        <td>
                                                            <table border="0" width="100%" cellspacing="0" cellpadding="0">
                                                                <tbody>
                                                                    <tr>
                                                                        <td style="padding: 20px; font-family: sans-serif; line-height: 24px; color: #555555; font-size: 15px;">' . $BODY_CONTENT . '</td>
                                                                    </tr>
                                                                    <tr>
                                                                         <td>&nbsp;</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                            <table style="background-color: #ea0b44 !important; max-width: 600px; border-radius: 5px;" border="0" width="100%" cellspacing="0" cellpadding="0" align="left" bgcolor="#ea0b44">
                                                <tbody>
                                                    <tr>
                                                        <td style="padding: 20px; width: 100%; font-size: 12px; font-family: sans-serif; line-height: 19px; text-align: left; color: #fff;">&copy; ' . date('Y') . ' ' . CommonHelper::siteName() . ' <br /><br /></td>
                                                    </tr>
                                                </tbody>
                                             </table>
                                      
                                      </div>
                                    </center>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                    <div class="yj6qo">&nbsp;</div>
                    <div class="adL">&nbsp;</div>
                    </div>
                </body>
                </html>';
        return $message;
    }
}
?>
