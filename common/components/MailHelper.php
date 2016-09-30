<?php
/**
 *
 */
namespace common\components;

use common\models\EmailFormat;
use Yii;

class MailHelper
{

    /*function __construct(argument) {

    }*/

    public static function SendMail($TYPE, $DB_INFO = '', $newsid = '')
    {
        $EMAIL_TEMPLATE = EmailFormat::findOne(['vEmailFormatType' => $TYPE]);
        $TO_EMAIL = '';
        $FROM_EMAIL = '';
        $ADMIN_EMAIL = 'parmarvikrantr@gmail.com';
        switch ($TYPE) {
            /** FRONT SIDE  **/

            case "VERIFY_ACCOUNT": # First verification Mail
                $TO_EMAIL = $DB_INFO['EMAIL'];
                $key_arr = Array("#NAME#", "#EMAILTO#", "#ACTIVATION_LINK#");
                $val_arr = Array($DB_INFO['NAME'], $DB_INFO['EMAIL'], $DB_INFO['ACTIVATION_LINK']);
                break;

            case "EMAIL_VERIFICATION_PIN": # For Email verification Pin
                $TO_EMAIL = $DB_INFO['EMAIL'];
                $key_arr = Array("#NAME#", "#EMAILTO#", "#PIN#");
                $val_arr = Array($DB_INFO['NAME'], $DB_INFO['EMAIL'], $DB_INFO['PIN']);
                break;

            case "IN_OWN_WORDS_APPROVE": # For In Own Words Approve
                $TO_EMAIL = $DB_INFO['EMAIL'];
                $key_arr = Array("#NAME#", '#COMMENT#');
                $val_arr = Array($DB_INFO['NAME'], $DB_INFO['COMMENT']);
                break;

            case "IN_OWN_WORDS_DISAPPROVE": # For In Own Words DisApprove
                $TO_EMAIL = $DB_INFO['EMAIL'];
                $key_arr = Array("#NAME#", '#COMMENT#');
                $val_arr = Array($DB_INFO['NAME'], $DB_INFO['COMMENT']);
                break;

            case "PROFILE_PHOTO_APPROVE": # For Profile Photo Approve
                $TO_EMAIL = $DB_INFO['EMAIL'];
                $key_arr = Array("#NAME#", '#COMMENT#');
                $val_arr = Array($DB_INFO['NAME'], $DB_INFO['COMMENT']);
                break;

            case "PROFILE_PHOTO_DISAPPROVE": # For Profile Photo DisApprove
                $TO_EMAIL = $DB_INFO['EMAIL'];
                $key_arr = Array("#NAME#", '#COMMENT#');
                $val_arr = Array($DB_INFO['NAME'], $DB_INFO['COMMENT']);
                break;

            case "FORGOT_PASSWORD": # For Forgot Password
                $TO_EMAIL = $DB_INFO['EMAIL'];
                $key_arr = Array("#NAME#", '#LINK#');
                $val_arr = Array($DB_INFO['NAME'], $DB_INFO['LINK']);
                break;

            /* ADMIN MAIL */

            case "ADMIN_DELETE_ACCOUNT_USER": # For Forgot Password
                $TO_EMAIL = $ADMIN_EMAIL;
                $key_arr = Array("#NAME#", '#EMAIL#', '#LINK#');
                $val_arr = Array($DB_INFO['NAME'], $DB_INFO['EMAIL'], $DB_INFO['LINK']);
                break;

        }

        #$TO_EMAIL = 'parmarvikrantr@gmail.com';
        #$maillanguage = $this->get_user_preffered_language($to_email);
        $MAIL_SUBJECT = $EMAIL_TEMPLATE->vEmailFormatSubject;//$res[0]['vSubject_'.$maillanguage];
        $MAIL_TITLE = $EMAIL_TEMPLATE->vEmailFormatTitle;//$res[0]['vSubject_'.$maillanguage];
        $MAIL_SUBJECT = '=?UTF-8?B?' . base64_encode($MAIL_SUBJECT) . '?=';
        $MAIL_MESSAGE = $EMAIL_TEMPLATE->tEmailFormatDesc;//$res[0]['vBody_'.$maillanguage];
        $MAIL_MESSAGE = str_replace($key_arr, $val_arr, $MAIL_MESSAGE);
        $MAIL_MESSAGE = MailHelper::mailFormat($MAIL_MESSAGE, $MAIL_TITLE);
        #echo " <br> TMESSAGE <br>".$MAIL_MESSAGE;
        $response = Yii::$app->mailer->compose()
            ->setTo($TO_EMAIL)
            #->setFrom('kandepohetest@gmail.com')
            ->setFrom(['kandepohetest@gmail.com' => Yii::$app->name])
            #->setFrom('no-replay@vcodertechnolab.com')
            ->setSubject($MAIL_SUBJECT)
            ->setHtmlBody($MAIL_MESSAGE)
            ->send();
        #exit;
        return $response;


    }

    public static function mailFormat($BODY_CONTENT, $TITLE)
    {
        #echo "Asdas ";exit;
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
                                                        <img src="' . CommonHelper::getLogo() . '" width="157" height="61"
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

    function general_mail_format_html($mail_body)
    {
        global $tconfig, $Emaillogodis;
        $mail_str = "";
        $mail_str = '<style type="text/css">
			p {font-size: 12px; color: #444444; !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; line-height: 1.5;}
			span {font-size: 12px; color: #00000; !important; font-family: "Lucida Grande", "Lucida Sans", "Lucida Sans Unicode", sans-serif; line-height: 1.5;}
			</style>
			
			<table id="main" width="600" align="center" cellpadding="0" cellspacing="15" bgcolor="ffffff" style="border:2px solid #c3c3c3">
			<tr>
			<td>
			<table id="header" cellpadding="10" cellspacing="0" align="center" bgcolor="8fb3e9">
			<tr>
			<td width="570" bgcolor="#ffffff" style="background-color:#fff; border-top:1px solid ' . SITE_COLOR . '; border-left:1px solid ' . SITE_COLOR . '; border-right:1px solid ' . SITE_COLOR . ';"><img src="' . $Emaillogodis . '"></td>
			</tr>
			<tr>
			<td width="570" align="right" bgcolor="' . SITE_COLOR . '" style="color:#fff;border-left:1px solid ' . SITE_COLOR . '; border-right:1px solid ' . SITE_COLOR . ';"><span>' . date("F j, Y") . '</span></td>
			</tr>
			</table>
			</td>
			</tr>
			<tr>
			<td></td>
			</tr>
			<tr>
			<td>
			<table id="content-2" cellpadding="0" cellspacing="0" align="center">
			<tr>
			<td width="570">' . $mail_body . '</td>
			</tr>
			</table>
			</td>
			</tr>
			</table>';
        return $mail_str;
    }

}

?>


