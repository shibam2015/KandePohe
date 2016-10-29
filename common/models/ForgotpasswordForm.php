<?php
namespace common\models;

use Yii;
use yii\base\Model;

/**
 * Login form
 */
class ForgotpasswordForm extends Model
{
    public $email;
    #public $password;
    #public $rememberMe = true;

    private $_user;


    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            // username and password are both required
            #[['email'], 'required'],
            ['email', 'required', 'message' => 'Please enter your email address.'],
            // rememberMe must be a boolean value
     #       ['rememberMe', 'boolean'],
            // password is validated by validatePassword()
      #      ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for password.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();
            /*if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect email or password.');
            }*/
           /* else if (!$user || !$user->checkEmailVerify($this->email)) {
                 $this->addError($attribute, 'Please verify your email for login');   
            }*/
        }
    }

    /**
     * Finds user by [[username]]
     *
     * @return User|null
     */
    protected function getUser()
    {
        if ($this->_user === null) {
            $this->_user = User::findByEmail($this->email);
        }
        return $this->_user;
    }

    /**
     * Logs in a user using the provided username and password.
     *
     * @return boolean whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            return Yii::$app->user->login($this->getUser());
        } else {
            return false;
        }
    }
}
