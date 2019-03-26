<?php

namespace backend\models;

use common\models\Category;
use common\models\Decoration;
use common\models\Producent;
use common\models\Product;
use common\models\Property;
use common\models\PropertyProduct;
use Yii;
use yii\base\Model;
use yii\helpers\ArrayHelper;
use yii\web\NotFoundHttpException;

/**
 * CreateProductForm form
 */
class CreateProductForm extends Model
{
    public $category_id;
    public $producent_id;
    public $decoration_id;
    public $name;
    public $values = [];
    public $product_id = null;


    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['category_id', 'producent_id', 'name', 'decoration_id'], 'required'],
            [['category_id', 'producent_id', 'product_id', 'decoration_id'], 'integer'],
            [['values'], 'safe'],
            [['name'], 'string'],
            [['category_id'], 'exist', 'skipOnError' => true, 'targetClass' => Category::className(), 'targetAttribute' => ['category_id' => 'id']],
            [['producent_id'], 'exist', 'skipOnError' => true, 'targetClass' => Producent::className(), 'targetAttribute' => ['producent_id' => 'id']],
            [['decoration_id'], 'exist', 'skipOnError' => true, 'targetClass' => Decoration::className(), 'targetAttribute' => ['decoration_id' => 'id']],


        ];
    }


    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'values' => 'Значения',
            'category_id' => 'Категория',
            'producent_id' => 'Производитель',
            'decoration_id' => 'Декор',
            'name' => 'Название',
        ];
    }

    /**
     * Signs user up.
     *
     * @return CreateProductForm|null the saved model or null if saving fails
     */
    public function save()
    {

        if (!$this->validate()) {
            return null;
        }
        $propsProduct = [];
        if (isset($this->product_id)) {
            $product = Product::findOne(['id' => $this->product_id]);
            $propsProduct = ArrayHelper::map($product->getPropertyProducts()->all(), 'id', 'prop.parent_id');
            YII::warning($propsProduct);
        } else {
            $product = new Product();
        }
        $product->name = $this->name;
        $product->category_id = $this->category_id;
        $product->producent_id = $this->producent_id;
        $product->decoration_id = $this->decoration_id;
        if (!$product->validate()) {
            return null;
        }
        $product->save();


        foreach ($this->values as $key => $el) {
            $idPropProd = array_search($el['prop_id'], $propsProduct);
            $prop = new Property();
            $propProduct = new PropertyProduct();
            if ($idPropProd != false) {
                $propProduct = PropertyProduct::findOne(['id' => $idPropProd]);
                $prop = $propProduct->prop;
            }

            if (isset($el['value_id'])) {
                $propProduct->prop_id = (int)$el['value_id'];
            } else {
                $prop->isAnyField = 1;
                $prop->name = $el['value'];
                $prop->parent_id = (int)$el['prop_id'];
                if($prop->name == "" && $idPropProd != false){
                    foreach ($prop->propertyProducts as $el){
                        $el->delete();
                    }
                    foreach ($prop->propertyCategories as $el){
                        $el->delete();
                    }
                    $prop->delete();

                    continue;

                }
                if (!$prop->validate()) {
                    return null;
                }
                $prop->save();
                $propProduct->prop_id = $prop->getPrimaryKey();
            }

            $propProduct->product_id = $product->getPrimaryKey();
            if (!$propProduct->validate()) {
                return null;
            }
            $propProduct->save();
        }

        return null;
    }
}
