<?php

namespace app\models;

use Yii;
use yii\base\Model;
use app\models\User;

class LoginForm extends Model
{
    public $username;
    public $password;

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['username', 'password'], 'required'],
            ['password', 'validatePassword'],
        ];
    }

    /**
     * Validates the password.
     * This method serves as the inline validation for the password field.
     *
     * @param string $attribute the attribute currently being validated
     * @param array $params the additional name-value pairs given in the rule
     */
    public function validatePassword($attribute, $params)
    {
        if (!$this->hasErrors()) {
            $user = $this->getUser();

            if (!$user || !$user->validatePassword($this->password)) {
                $this->addError($attribute, 'Incorrect username or password.');
            }
        }
    }

    /**
     * Logs in the user.
     *
     * @return bool whether the user is logged in successfully
     */
    public function login()
    {
        if ($this->validate()) {
            $user = $this->getUser();
            return Yii::$app->user->login($user);
        }

        return false;
    }

    /**
     * Finds the user based on the provided username.
     *
     * @return User|null the user model or null if the user is not found
     */
    protected function getUser()
    {
        return User::findByUsername($this->username);
    }

    public static function findByUsername($username)
    {
        return User::find()
            ->joinWith('teacher') // Assuming there is a relation between User and Teacher models
            ->where(['username' => $username])
            ->one();
    }
}
