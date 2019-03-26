<?php

namespace common\models;

use Yii;

use yii\helpers\ArrayHelper;

/**
 * This is the model class for table "category".
 *
 * @property int $id
 * @property string $name
 * @property int $parent_id
 *
 * @property Category $parent
 * @property Category[] $categories
 * @property Product[] $products
 * @property PropertyCategory[] $propertyCategories
 */
class Category extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'category';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required', 'message' => 'Это поле не может быть пустым.'],
            [['parent_id'], 'integer'],
            [['name'], 'string', 'max' => 32, 'message' => 'Название больше 32 символов.'],
            [['parent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['parent_id' => 'id']],
            ['name', 'unique', 'targetClass' => '\common\models\Category', 'message' => 'Данное значение уже есть в базе данных.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Название',
            'parent_id' => 'Главная категория',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(Category::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getCategories()
    {
        return $this->hasMany(Category::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getProducts()
    {
        return $this->hasMany(Product::className(), ['category_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPropertyCategories()
    {
        return $this->hasMany(PropertyCategory::className(), ['category_id' => 'id']);
    }
    /**
     * @return int
     */
    public function getCountProducts()
    {
        return count($this->products);
    }
    /**
     * @param integer $id
     * @return Category
     */

    public static function  getCategoryById($id){
        return Category::find()->where(['id' => $id])->one();
    }
    public static function getFilterList()
    {
        $list = Category::find()->all();
        foreach ($list as $key => $el){
            if(count($el->products) == 0){
                unset($list[$key]);
            }
        }
        return ArrayHelper::map($list, 'id', 'name');
    }
}
