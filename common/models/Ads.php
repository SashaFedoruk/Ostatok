<?php

namespace common\models;

use Yii;
use yii\db\ActiveRecord;

/**
 * This is the model class for table "{{%ads}}".
 *
 * @property int $id
 * @property int $user_id
 * @property int $product_id
 * @property int $status
 * @property float $price
 * @property int $width
 * @property int $length
 * @property int $created_at
 * @property int $updated_at
 *
 * @property User $user
 * @property Product $product
 * @property AdsStats[] $adsStats
 */
class Ads extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return '{{%ads}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id', 'product_id', 'status', 'price', 'width', 'length'], 'required', 'message' => 'Это поле обязательное.'],
            [['user_id', 'product_id', 'status', 'width', 'length', 'created_at', 'updated_at'], 'integer'],
            [['price'], 'number'],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::className(), 'targetAttribute' => ['product_id' => 'id']],
        ];
    }
    public function behaviors()
    {
        return [
            'timestamp' => [
                'class' => 'yii\behaviors\TimestampBehavior',
                'attributes' => [
                    ActiveRecord::EVENT_BEFORE_INSERT => ['created_at', 'updated_at'],
                    ActiveRecord::EVENT_BEFORE_UPDATE => ['updated_at'],
                ],
            ],
        ];
    }
    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'product_id' => 'Продукт',
            'status' => 'Статус',
            'price' => 'Цена',
            'width' => 'Ширина, мм',
            'length' => 'Длина, мм',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::className(), ['id' => 'product_id']);
    }
    /**
     * @return \yii\db\ActiveQuery
     */
    public function getAdsStats()
    {
        return $this->hasMany(AdsStats::className(), ['ads_id' => 'id']);
    }


}
