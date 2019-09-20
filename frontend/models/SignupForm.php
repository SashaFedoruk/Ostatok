<?php
namespace frontend\models;

use yii\base\Model;
use common\models\User;

/**
 * Signup form
 */
class SignupForm extends Model
{
    public $username;
    public $email;
    public $password;
    public $city_id;
    public $firstname;
    public $lastname;
    public $phone = '';
    public $visible_email = 1;
    public $agreed_rules = 0;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['visible_email', 'default', 'value' => '1'],
            ['phone', 'default', 'value' => ''],

            ['username', 'trim'],
            ['username', 'required', 'message' => 'Обязательное поле.'],
            ['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким логином уже существует.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required', 'message' => 'Обязательное поле.'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            ['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'Пользователь с таким емейлом уже существует.'],

            ['password', 'required', 'message' => 'Обязательное поле.'],
            ['password', 'string', 'min' => 6],


            [['firstname', 'lastname', 'phone'], 'string', 'max' => 32],
            [['city_id', 'visible_email'], 'integer'],

            [['firstname', 'lastname','city_id', 'visible_email', 'agreed_rules'], 'required', 'message' => 'Обязательное поле.'],
            



        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function signup()
    {
        if (!$this->validate()) {
            return null;
        }
        
        $user = new User();
        $user->username = $this->username;
        $user->firstname = $this->firstname;
        $user->lastname = $this->lastname;
        $user->email = $this->email;
        $user->city_id = $this->city_id;
        $user->visible_email = $this->visible_email;
        $user->phone = $this->phone;
        $user->free_ads = 3;
        $user->money = 0;
        $user->setPassword($this->password);
        $user->generateAuthKey();
        
        return $user->save() ? $user : null;
    }
}
