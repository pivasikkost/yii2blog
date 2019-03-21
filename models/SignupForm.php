<?php

namespace app\models;

use Yii;
use yii\base\Model;

class SignupForm extends Model
{

    public $username;
    public $email;
    public $password;

    /**
     * @return array the validation rules.
     */
    public function rules()
    {
        return [
            [['username', 'email'], 'trim'],
            [['username', 'email', 'password'], 'required'],
            ['username', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\app\models\User', 'message' => 'This email address has already been taken.'],
            ['password', 'string', 'min' => 6],
        ];
    }

    /**
     * @return array the attribute labels.
     */
    public function attributeLabels() // Used for localization
    {
        return [
            'username' => 'Username',
            'email' => 'Email',
            'password' => 'Password',
        ];
    }

    /**
     * Sign up a user using the provided username, email and password.
     * @return bool|null whether the user is registered sccesfully
     */
    public function signup()
    {

        if (!$this->validate()) {
            return null;
        }
        $user = new User();
        $user->username = $this->username;
        $user->email = $this->email;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        $user->created_at = time();
        $user->updated_at = $user->created_at;
        return $user->save() ? $user : null;
    }
}
