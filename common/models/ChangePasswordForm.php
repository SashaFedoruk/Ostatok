<?php
namespace common\models;

use Yii;
use yii\base\Model;
use common\models\User;

/**
 * Change password form for current user only
 */
class ChangePasswordForm extends Model
{
    public $id;
    public $password;
    public $confirm_password;

    /**
     * @var \common\models\User
     */
    private $_user;

    /**
     * Creates a form model given a token.
     *
     * @param  string                          $token
     * @param  array                           $config name-value pairs that will be used to initialize the object properties
     * @throws \yii\base\InvalidParamException if token is empty or not valid
     */
    public function __construct($id, $config = [])
    {
        $this->_user = User::findIdentity($id);

        $this->id = $this->_user->id;
        parent::__construct($config);
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['password','confirm_password'], 'required', 'message' => 'Это поле не может быть пустым.'],
            [['password','confirm_password'], 'string', 'min' => 6, 'message' => 'Длина пароля меньше 6 символов.'],
            ['confirm_password', 'compare', 'compareAttribute' => 'password', 'message' => 'Пароли не совпадают.'],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'password' => 'Новый пароль',
            'confirm_password' => 'Повторите пароль',
        ];
    }
    /**
     * Changes password.
     *
     * @return boolean if password was changed.
     */
    public function changePassword()
    {
        $user = $this->_user;
        $user->setPassword($this->password);

        return $user->save(false);
    }
}