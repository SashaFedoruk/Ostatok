<?php
namespace common\models;

use yii\base\Model;

/**
 * Signup form
 */
class UserUpdateForm extends Model
{
    public $model;
    public $username;
    public $email;
    public $password;
    public $city_id;
    public $firstname;
    public $lastname;
    public $phone;
    public $visible_email;

    /**
     * UserUpdateForm constructor.
     * @param User $model
     */

    public function __construct($model)
    {
        $this->model = $model;
        $this->username = $model->username;
        $this->email = $model->email;
        $this->city_id = $model->city_id;
        $this->firstname = $model->firstname;
        $this->lastname = $model->lastname;
        $this->phone = $model->phone;
        $this->visible_email = $model->visible_email;
    }


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['username', 'trim'],
            ['username', 'required'],
            //['username', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This username has already been taken.'],
            ['username', 'string', 'min' => 2, 'max' => 255],

            ['email', 'trim'],
            ['email', 'required'],
            ['email', 'email'],
            ['email', 'string', 'max' => 255],
            //['email', 'unique', 'targetClass' => '\common\models\User', 'message' => 'This email address has already been taken.'],

//            ['password', 'required'],
  //          ['password', 'string', 'min' => 6],


            [['firstname', 'lastname', 'phone'], 'string', 'max' => 32],
            [['city_id', 'visible_email'], 'integer'],

            [['firstname', 'lastname','city_id', 'visible_email'], 'required'],



        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'username' => 'Логин',
            'email' => 'Email',
            'firstname' => 'Имя',
            'lastname' => 'Фамилия',
            'city_id' => 'Город',
            'phone' => 'Номер телефона',
            'visible_email' => 'Отображать емейл для других пользователей'
        ];
    }

    /**
     * Signs user up.
     *
     * @return User|null the saved model or null if saving fails
     */
    public function save()
    {
        if (!$this->validate()) {
            return null;
        }

        $this->model->username = $this->username;
        $this->model->firstname = $this->firstname;
        $this->model->lastname = $this->lastname;
        $this->model->email = $this->email;
        $this->model->city_id = $this->city_id;
        $this->model->visible_email = $this->visible_email;
        $this->model->phone = $this->phone;
       //$this->model->setPassword($this->password);
      //  $this->model->generateAuthKey();

        return $this->model->save() ? $this->model : null;
    }
}
