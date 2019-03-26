<?php
namespace common\models;

use yii\base\Model;

/**
 * Ads form
 */
class AdsForm extends Model
{
    public $category_id;
    public $producent_id;
    public $decoration_id;
    public $height_id;
    public $id = null;
    public $user_id;
    public $product_id;
    public $status = 1;
    public $price;
    public $width;
    public $length;




    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            ['status', 'default', 'value' => '1'],
            [['category_id', 'producent_id', 'decoration_id', 'price'], 'required', 'message' => 'Это поле обязательное.'],
            [['category_id', 'producent_id', 'decoration_id'], 'integer'],
            [['user_id', 'product_id', 'status', 'width', 'length'], 'required', 'message' => 'Это поле обязательное.'],
            [['user_id', 'product_id', 'status', 'width', 'length'], 'integer', 'message' => 'Недопустимое значение.'],
            [['price'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id'], 'message' => 'Недопустимое значение.'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id'], 'message' => 'Недопустимое значение.'],
            [['decoration_id'], 'exist', 'skipOnError' => true, 'targetClass' => Decoration::className(), 'targetAttribute' => ['decoration_id' => 'id'], 'message' => 'Недопустимое значение.'],

        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'category_id' => 'Категория',
            'producent_id' => 'Производитель',
            'decoration_id' => 'Декорация',
            'height_id' => 'Толщина',
            'user_id' => 'User ID',
            'product_id' => 'Продукт',
            'status' => 'Статус',
            'price' => 'Цена',
            'width' => 'Ширина, мм',
            'length' => 'Длина, мм',
        ];
    }

    /**
     * Signs user up.
     *
     * @return AdsForm|null the saved model or null if saving fails
     */
    public function save()
    {
        if (!$this->validate()) {
            return null;
        }

        if(isset($this->id)){
            $model = Ads::findOne(['id' => $this->id]);
        } else {
            $model = new Ads();
        }

        $model->user_id = $this->user_id;
        $model->product_id = $this->product_id;
        $model->status = $this->status;
        $model->price = $this->price;
        $model->width = $this->width;
        $model->length = $this->length;

        if(!$model->validate()){
            return null;
        }
        if($model->save()){
            $tmp = new AdsStats();
            $tmp->ads_id = $model->getPrimaryKey();
            $tmp->save();
            return $this;
        }

        return null;
    }
}
