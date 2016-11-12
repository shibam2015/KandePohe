<?php
namespace frontend\models;

use yii\base\Model;
use yii\base\InvalidParamException;
use common\models\User;

/**
 * Password reset form
 */
class ResetPasswordForm extends Model
{
    public $password;
    public $repassword;
    public $email;

    /**
     * @var \common\models\User
     */
    private $_user;


    /**
     * Creates a form model given a token.
     *
     * @param string $token
     * @param array $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($token, $config = [])
    {
        if (empty($token) || !is_string($token)) {
            throw new InvalidParamException('Password reset token cannot be blank.');
        }
        $this->_user = User::findByPasswordResetToken($token);
        if (!$this->_user) {
            throw new InvalidParamException('Wrong password reset token.');
        }
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password'], 'required', 'message' => 'Please create your New password.'],
            [['repassword'], 'required', 'message' => 'Please re-type your New password.'],
             [['password','repassword'], 'string', 'min' => 6],
            [['password', 'repassword'], 'string', 'length' => [6, 255]],
            [['repassword'], 'compare', 'compareAttribute' => 'password', 'message' => "New password and Retype Password is not matching. Please try again."],
        ];
    }

    /**
     * Resets password.
     *
     * @return boolean if password was reset.
     */
    public function resetPassword()
    {
        $user = $this->_user;
        $user->password_hash = $user->setPassword($this->password);
        $user->removePasswordResetToken();

        return $user->save(false);
    }
}
