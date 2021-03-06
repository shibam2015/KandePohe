<?php

namespace frontend\models;

use Yii;
use yii\base\Model;
use common\components\MailHelper;
/**
 * ContactForm is the model behind the contact form.
 */
class ContactForm extends Model
{
    public $name;
    public $email;
    public $phone;
    public $message;
    public $verifyCode;

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // name, email, subject and body are required
            [['name', 'email', 'phone', 'message'], 'required'],
            // email has to be a valid email address
            ['email', 'email'],
            ['phone', 'match', 'pattern' => '/^[0-9]{10}$/', 'message' => 'Please enter 10 digit valid phone number.'],
            // verifyCode needs to be entered correctly
            ['verifyCode', 'captcha'],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'verifyCode' => 'Verification Code',
        ];
    }

    /**
     * Sends an email to the specified email address using the information collected by this model.
     *
     * @param string $email the target email address
     * @return boolean whether the email was sent
     */
    public function sendEmail($email)
    {

        $MAIL_DATA = array("EMAIL" => $this->email, "EMAIL_TO" => $email, "NAME" => $this->name, "PHONE" => $this->phone, "CONTACT_US_MESSAGE" => $this->message, "TODAY_DATE" => date('Y-m-d'));
        return MailHelper::SendMail('CONTACT_US', $MAIL_DATA);
        /*return Yii::$app->mailer->compose()
            ->setTo($email)
            ->setFrom([$this->email => $this->name])
            ->setSubject($this->subject)
            ->setTextBody($this->body)
            ->send();*/
    }
}
