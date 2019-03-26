<?php

namespace backend\controllers;

use backend\models\CreateProductForm;
use backend\models\CreatePropertyCategoriesForm;
use common\models\AdsStats;
use common\models\City;
use common\models\Decoration;
use common\models\Producent;
use common\models\Product;
use common\models\AdsForm;
use common\models\Ads;
use common\models\ProductSearch;
use common\models\PropertyProduct;
use yii\behaviors\TimestampBehavior;
use yii\web\NotFoundHttpException;
use common\models\Property;
use backend\models\CreateProperyValuesForm;
use Yii;
use yii\helpers\ArrayHelper;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;
use common\models\LoginForm;
use common\models\UserUpdateForm;
use common\models\User;
use common\models\Category;
use common\models\ChangePasswordForm;
use yii\helpers\Html;

use dosamigos\multiselect\MultiSelectListBox;
use yii\web\JsExpression;

use yii\data\ActiveDataProvider;


/**
 * Site controller
 */
class SiteController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'actions' => ['login', 'error'],
                        'allow' => true,
                    ],
                    [
                        'actions' => ['logout', 'index', 'update-user', 'create-category', 'properties',
                            'get-property-values', 'delete-property', 'delete-category', 'property-categories',
                            'get-properties-for-category', 'add-product', 'create-producent', 'delete-producent',
                            'get-fields-for-category', 'products', 'delete-product', 'view-product', 'update-product',
                            'create-ads', 'get-producents-by-category-id', 'products-by-category-id-and-producent-id', 'all-active-ads',
                            'all-archive-ads', 'delete-ads', 'update-ads', 'publish-ads', 'create-decoration', 'delete-decoration',
                            'decorations-by-category-id-and-producent-id', 'users-list', 'stats', 'copy-ads'


                        ],
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post', 'get'],
                ],
            ],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
        ];
    }

    public function actionError()
    {
        $exception = Yii::$app->errorHandler->exception;
        return $this->render('error', ['name' => 'Ошибка', 'message' => 'Страница не найдена.']);
    }

    /**
     * Displays homepage.
     *
     * @return string
     */
    public function actionIndex()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }
        return $this->redirect(['update-user']);
    }

    public function actionUsersList()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['login']);
        }
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->orderBy(['created_at' => SORT_DESC]),
            'pagination' => [
                'pageSize' => 10,
            ],
        ]);
        return $this->render('users-list', [
            'dataProvider' => $dataProvider,
        ]);

    }
    public function actionCopyAds($id)
    {
        $categories = Category::find()->where(['parent_id' => null])->all();

        foreach ($categories as $key => $el) {
            if ($el->getCountProducts() == 0) {
                unset($categories[$key]);
            }
        }
        $categoriesList = ArrayHelper::map($categories, 'id', 'name');

        $producents = Producent::find()->all();
        $producentsList = ArrayHelper::map($producents, 'id', 'name');


        $adsModel = $this->findAdsModel($id);
        $height_id = PropertyProduct::find()->select(['property.id'])->joinWith(['property'])->where(['property_product.product_id' => $adsModel->product->id])->andWhere(['property.parent_id' => 5])->one();
        $model = new AdsForm();


        $model->price = $adsModel->price;
        $model->width = $adsModel->width;
        $model->length = $adsModel->length;
        $model->product_id = $adsModel->product_id;
        $model->user_id = $adsModel->user_id;
        $model->category_id = $adsModel->product->category_id;
        $model->producent_id = $adsModel->product->producent_id;
        $model->decoration_id = $adsModel->product->decoration_id;
        $model->height_id = $height_id->id;
        $model->user_id = yii::$app->user->id;

        //producents
        $category = $this->findCategoryModel($model->category_id);
        $rez = [];
        //$i = 0;
        foreach ($category->products as $el) {
            if (!array_key_exists($el->producent->id, $rez)) {
                $rez[$el->producent->id] = $el->producent->name;
            }
        }
        $producentsList = $rez;

        //decorations
        $decorationsId = Product::find()->select(['decoration_id'])->distinct()->where(['category_id' => $model->category_id])->andWhere(['producent_id' => $model->producent_id])->all();
        $decorationsId = ArrayHelper::getColumn($decorationsId, 'decoration_id');
        $decorations = Decoration::find()->where(['in', 'id', $decorationsId])->orderBy('name')->all();
        $decorationsList = ArrayHelper::map($decorations, 'id', 'name');
        //heights
        $productsId = Product::find()->distinct()->where(['category_id' => $model->category_id])->andWhere(['producent_id' => $model->producent_id])
            ->andWhere(['decoration_id' => $model->decoration_id])->all();

        $productsId = ArrayHelper::getColumn($productsId, 'id');
        $propertyId = PropertyProduct::find()->distinct()->joinWith(['property'])->where(['property.parent_id' => 5])->andWhere(['in', 'product_id', $productsId])->orderBy(['property.name' => SORT_DESC])->all();
        $heightsList = ArrayHelper::map($propertyId, 'prop_id', 'property.name');
        //products
        $productsId = PropertyProduct::find()->select(['product_id'])->where(['prop_id' => $model->height_id])->joinWith('product')->andWhere(['product.producent_id' => $model->producent_id])->andWhere(['product.decoration_id' => $model->decoration_id])->orderBy(['product.name' => SORT_DESC])->all();
        $productsId = ArrayHelper::getColumn($productsId, 'product_id');
        $productsList = Product::find()->where(['in', 'id', $productsId])->all();
        $productsList = ArrayHelper::map($productsList, 'id', 'name');

        if (($model->load(Yii::$app->request->post()) || $model->load(Yii::$app->request->get()))) {
            $model->save();
//            if($user->free_ads - 1 >= 0) {
//                $user->free_ads--;
//                $user->save();
//                $model->save();
//
//            } else if ($user->money - $price > 0){
//                $user->money -= $price;
//                $user->save();
//                $model->save();
//            } else {
//                return $this->redirect(['site/update-user'
//                ]);
//            }

            return $this->redirect(['site/all-active-ads'
            ]);
        }

        return $this->render('copy-ads', [
            'model' => $model,
            'categoriesList' => $categoriesList,
            'producentsList' => $producentsList,
            'decorationsList' => $decorationsList,
            'heightsList' => $heightsList,
            'productsList' => $productsList
        ]);
    }
    public function actionStats()
    {
        $adsStats = AdsStats::find();
        $users = User::find();


        $time = date('U', strtotime('-1 day'));
        $stats = [];
        $stats[0] = ['ads' => $adsStats->where(['between', 'publish_at',  $time,  date('U')])->count(), 'users' => $users->where(['between', 'created_at',  $time,  date('U')])->count()];

        $time = date('U', strtotime('-7 day'));
        $stats[1] = ['ads' => $adsStats->where(['between', 'publish_at',  $time,  date('U')])->count(), 'users' => $users->where(['between', 'created_at',  $time,  date('U')])->count()];


        $time = date('U', strtotime('-1 months'));
        $stats[2] = ['ads' => $adsStats->where(['between', 'publish_at',  $time,  date('U')])->count(), 'users' => $users->where(['between', 'created_at',  $time,  date('U')])->count()];

        $time = date('U', strtotime('-6 months'));
        $stats[3] = ['ads' => $adsStats->where(['between', 'publish_at',  $time,  date('U')])->count(), 'users' => $users->where(['between', 'created_at',  $time,  date('U')])->count()];

        $time = date('U', strtotime('-12 months'));
        $stats[4] = ['ads' => $adsStats->where(['between', 'publish_at',  $time,  date('U')])->count(), 'users' => $users->where(['between', 'created_at',  $time,  date('U')])->count()];

        $stats[5] = ['ads' => $adsStats->count(), 'users' => $users->count()];


        return $this->render('stats', [
            'stats' => $stats,
        ]);
    }
    /**
     * Login action.
     *
     * @return string
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->redirect(['update-user']);
            // return $this->goHome();
        }

        $model = new LoginForm();
        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            return $this->redirect(['update-user']);
        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Logout action.
     *
     * @return string
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }


    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateUser()
    {
        $citiesList = ArrayHelper::map(City::find()->all(), 'id', 'name');

        $model = $this->findUserModel(Yii::$app->user->id);
        $updateModel = new UserUpdateForm($model);
        $changePasswordModel = new ChangePasswordForm(Yii::$app->user->identity);


        if ($updateModel->load(Yii::$app->request->post()) && $updateModel->save()) {
            return $this->redirect(['update-user', 'model' => $updateModel, 'citiesList' => $citiesList]);
        } else if ($changePasswordModel->load(Yii::$app->request->post()) && $changePasswordModel->validate() && $changePasswordModel->changePassword()) {
            Yii::$app->session->setFlash('success', 'Password Changed!');
        }

        return $this->render('update-user', [
            'model' => $updateModel,
            'citiesList' => $citiesList,
            'changePasswordModel' => $changePasswordModel
        ]);
    }


    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateCategory()
    {
        $categories = Category::find()->where(['parent_id' => null])->all();
        array_unshift($categories, ['id' => null, 'name' => 'none']);


        $model = new Category();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create-category',
                'model' => $model,
                'categoriesList' => $categories,
            ]);
        }

        return $this->render('create_category', [
            'model' => $model,
            'categoriesList' => $categories,
        ]);
    }
    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateDecoration()
    {
        $decorations = Decoration::find()->all();


        $model = new Decoration();

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['create-decoration',
                'model' => $model,
                'decorationsList' => $decorations,
            ]);
        }

        return $this->render('create-decoration', [
            'model' => $model,
            'decorationsList' => $decorations,
        ]);
    }
    /**
     * Deletes an existing Property model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteDecoration($id)
    {
        $model = Decoration::findOne(['id' => $id]);
        foreach ($model->products as $el) {
            $this->actionDeleteProduct($el->id);
        }

        $model->delete();

        return $this->redirect(['site/create-decoration']);
    }
    /**
     * Lists all Product models.
     * @return mixed
     */
    public function actionProducts()
    {
//        $dataProvider = new ActiveDataProvider([
////            'query' => Product::find(),
////        ]);

        $searchModel = new ProductSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('products', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);


//        return $this->render('products', [
//            'dataProvider' => $dataProvider,
//        ]);
    }

    /**
     * Creates a new Category model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionProperties()
    {
        $properties = Property::find()->where(['parent_id' => null])->all();
        $propertiesWithotAnyField = ArrayHelper::map(Property::find()->where(['parent_id' => null])->andWhere(['isAnyField' => 0])->all(), 'id', 'name');
        $propertiesList = ArrayHelper::map($properties, 'id', 'name');


        $model = new Property();
        $cpvForm = new CreateProperyValuesForm();

        if (($model->load(Yii::$app->request->post()) && $model->save())
            || ($cpvForm->load(Yii::$app->request->post()) && $cpvForm->save())) {
            $model->name = "";
            return $this->redirect(['properties',
                'model' => $model,
                'propertiesList' => $propertiesList,
                'propertiesWithotAnyField' => $propertiesWithotAnyField,
                'cpvForm' => $cpvForm,
            ]);
        }

        return $this->render('properties', [
            'model' => $model,
            'propertiesList' => $propertiesList,
            'propertiesWithotAnyField' => $propertiesWithotAnyField,
            'cpvForm' => $cpvForm,
        ]);
    }


    /**
     * Add properties to categories.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionPropertyCategories()
    {
        $categories = Category::find()->where(['parent_id' => null])->all();
        $categoriesList = ArrayHelper::map($categories, 'id', 'name');


        $cpcForm = new CreatePropertyCategoriesForm();

        if ($cpcForm->load(Yii::$app->request->post()) && $cpcForm->save()) {
            return $this->redirect(['property-categories',
                'model' => $cpcForm,
                'categoriesList' => $categoriesList
            ]);
        }

        return $this->render('property-categories', [
            'model' => $cpcForm,
            'categoriesList' => $categoriesList
        ]);
    }


    /**
     * Create producent.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateProducent()
    {
        $producers = Producent::find()->all();
        $producentsList = ArrayHelper::map($producers, 'id', 'name');

        $producent = new Producent();
        $producent->code = "empty";


        if ($producent->load(Yii::$app->request->post()) && $producent->save()) {
            return $this->redirect(['create-producent',
                'model' => $producent,
                'producentsList' => $producentsList
            ]);
        }

        return $this->render('create-producent', [
            'model' => $producent,
            'producentsList' => $producentsList
        ]);
    }

    /**
     * Create Product.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAddProduct()
    {
        $categories = Category::find()->where(['parent_id' => null])->all();
        $categoriesList = ArrayHelper::map($categories, 'id', 'name');


        $product = new Product();


        if ($product->load(Yii::$app->request->post()) && $product->save()) {
            return $this->redirect(['add-product',
                'model' => $product,
                'categoriesList' => $categoriesList,
            ]);
        }

        return $this->render('add-product', [
            'model' => $product,
            'categoriesList' => $categoriesList,
        ]);
    }

    /**
     * All Ads.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAllActiveAds()
    {
        //$model = Ads::find()->where(['status' => 1])->all();
        $model = Ads::find()->where(['status' => 1])->andWhere(['user_id' => YII::$app->user->id])->orderBy(['updated_at' => SORT_DESC])->all();

        return $this->render('all-active-ads', [
            'model' => $model
        ]);
    }
    /**
     * Archive Ads.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAllArchiveAds()
    {
        $model = Ads::find()->where(['status' => 0])->all();

        return $this->render('all-archive-ads', [
            'model' => $model
        ]);
    }

    /**
     * Create Ads.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateAds()
    {
        $categories = Category::find()->where(['parent_id' => null])->all();
        foreach ($categories as $key => $el){
            if($el->getCountProducts() == 0){
                unset($categories[$key]);
            }
        }
        $categoriesList = ArrayHelper::map($categories, 'id', 'name');

        $producents = Producent::find()->all();
        $producentsList = ArrayHelper::map($producents, 'id', 'name');


        $model = new AdsForm();

        $model->user_id = yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['site/all-active-ads'
            ]);
        }

        return $this->render('create-ads', [
            'model' => $model,
            'categoriesList' => $categoriesList
        ]);
    }
    /**
     * Update Ads.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateAds($id)
    {
        $categories = Category::find()->where(['parent_id' => null])->all();

        foreach ($categories as $key => $el){
            if($el->getCountProducts() == 0){
                unset($categories[$key]);
            }
        }
        $categoriesList = ArrayHelper::map($categories, 'id', 'name');

        $producents = Producent::find()->all();
        $producentsList = ArrayHelper::map($producents, 'id', 'name');


        $adsModel = $this->findAdsModel($id);
        $model = new AdsForm();
        $model->status = $adsModel->status;
        $model->price = $adsModel->price;
        $model->width = $adsModel->width;
        $model->length = $adsModel->length;
        $model->product_id = $adsModel->product_id;
        $model->user_id = $adsModel->user_id;
        $model->category_id = $adsModel->product->category_id;
        $model->producent_id = $adsModel->product->producent_id;
        $model->id = $adsModel->id;


        $model->user_id = yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update-ads', 'id' => $model->id]);
        }

        return $this->render('update-ads', [
            'model' => $model,
            'categoriesList' => $categoriesList
        ]);
    }
    /**
     * Publish Ads.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionPublishAds($id)
    {
        $adsModel = $this->findAdsModel($id);
        $adsModel->status = 1;
        $adsModel->created_at = date('U');

        if ($adsModel->save()) {
            $tmp = new AdsStats();
            $tmp->ads_id = $adsModel->getPrimaryKey();
            $tmp->save();

            return $this->redirect(['site/all-active-ads']);
        }

        return $this->redirect(['site/all-active-ads']);
    }


    public function actionGetProducentsByCategoryId()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $id = (int)$data['category_id'];
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            $category = $this->findCategoryModel($id);
            $rez = [];
            //$i = 0;
            foreach ($category->products as $el) {
                if (!array_key_exists($el->producent->id, $rez)) {
                    $rez[$el->producent->id] = $el->producent;
                }
            }
            // $rez = ArrayHelper::map($rez, 'id', 'name');

            return ['search' => $rez];
        }
    }

    public function actionProductsByCategoryIdAndProducentId()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $category_id = (int)$data['category_id'];
            $producent_id = (int)$data['producent_id'];
            $decoration_id = (int)$data['decoration_id'];
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $products = Product::find()->where(['category_id' => $category_id])->andWhere(['producent_id' => $producent_id])->andWhere(['decoration_id' => $decoration_id])->all();
            $rez = ArrayHelper::map($products, 'id', 'name');

            return ['search' => $products];
        }
    }

    public function actionDecorationsByCategoryIdAndProducentId()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $category_id = (int)$data['category_id'];
            $producent_id = (int)$data['producent_id'];
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $decorationsId = Product::find()->select(['decoration_id'])->distinct()->where(['category_id' => $category_id])->andWhere(['producent_id' => $producent_id])->all();
            $decorationsId = ArrayHelper::getColumn($decorationsId, 'decoration_id');
            $decorations = Decoration::find()->where(['in', 'id', $decorationsId])->orderBy('name')->all();
            $rez = ArrayHelper::map($decorations, 'id', 'name');


            return ['search' => $rez];
        }
    }
//    public function actionGetProducentsByCategoryId(){
//        if (Yii::$app->request->isAjax) {
//            $data = Yii::$app->request->post();
//            $id = (int)$data['category_id'];
//            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//            $category = $this->findCategoryModel($id);
//            $rez = [];
//            //$i = 0;
//            foreach ($category->products as $el){
//                if(!array_key_exists($el->producent->id, $rez)){
//                    $rez[$el->producent->id] = $el->producent;
//                }
//            }
//           // $rez = ArrayHelper::map($rez, 'id', 'name');
//
//            return ['search' => $rez];
//        }
//    }
//    public function actionProductsByCategoryIdAndProducentId(){
//        if (Yii::$app->request->isAjax) {
//            $data = Yii::$app->request->post();
//            $category_id = (int)$data['category_id'];
//            $producent_id = (int)$data['producent_id'];
//            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//
//            $products = Product::find()->where(['category_id' => $category_id])->andWhere(['producent_id' => $producent_id])->all();
//           $rez = ArrayHelper::map($products, 'id', 'name');
//
//            return ['search' => $products];
//        }
//    }


    public function actionGetPropertyValues()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $id = (int)$data['id'];
            $search = Property::getPropertyById($id);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            if (!$search || count($search->properties) == 0) {
                return ['search' => ''];
            }
            $rez = '<ul><li><b>' . $search->name . '</b><ul>';
            $childProperties = $search->getProperties()->all();
            $childPropertiesMap = ArrayHelper::map($childProperties, 'id', 'name');
            foreach ($childPropertiesMap as $el) {
                $rez .= '<li>' . Html::a(Html::img('img/Admin/delete.png'), ['delete-property', 'id' => array_search($el, $childPropertiesMap)], [
                        'class' => '',
                        'data' => [
                            'confirm' => 'Вы уверены что хотите удалить это значение?',
                            'method' => 'post',
                        ],
                    ]) . ' ' . $el . '</li>';


            }
            $rez .= '</ul></li></ul>';
            return ['search' => $rez];

        }
    }

    public function actionGetPropertiesForCategory()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $id = (int)$data['id'];

            $search = Category::getCategoryById($id);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;


            $properties = $search->getPropertyCategories()->all();


            $selectedProperties = ArrayHelper::getColumn($properties, 'prop_id');
            $allProps = Property::find()->where(['parent_id' => null])->all();
            $map = ArrayHelper::map($allProps, 'id', 'name');
            $rez = MultiSelectListBox::widget([
                'id' => "multiselect",
                "options" => ['multiple' => "multiple"], // for the actual multiselect
                'data' => $map, // data as array
                'value' => $selectedProperties, // if preselected
                'name' => 'CreatePropertyCategoriesForm[values]', // name for the form
                "clientOptions" =>
                    [
                        "includeSelectAllOption" => true,
                        'numberDisplayed' => 2
                    ],
            ]);
            return ['rez' => $rez];

        }
    }


    public function actionGetFieldsForCategory()
    {
        $model = new CreateProductForm();
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $id = (int)$data['id'];

            $search = Category::getCategoryById($id);
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $producents = Producent::find()->all();
            $producentsList = ArrayHelper::map($producents, 'id', 'name');


            $decorations = Decoration::find()->orderBy('name')->all();
            $decorationsList = ArrayHelper::map($decorations, 'id', 'name', 'code');

            $properties = $search->propertyCategories;
            $rez = [];
            $i = 0;
            foreach ($properties as $el) {
                $rez[$i++] = $el->prop;
            }


            $model->category_id = $id;
            $rez = $this->renderPartial('_form_add_product_fields', [
                'model' => $model,
                'data' => $rez,
                'producentsList' => $producentsList,
                'decorationsList' => $decorationsList
            ]);
            return ['rez' => $rez];

        } else if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['add-product']);
        }
        //echo json_encode($model);
        return $this->redirect(['add-product']);

    }

    /**
     * View Product.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionViewProduct($id)
    {
        $this->layout = "unauth-main-layout";
        $model = $this->findProductModel($id);
        return $this->render('view-product', [
            'model' => $model
        ]);
    }

    /**
     * Update Product.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionUpdateProduct($id)
    {
        $product = $this->findProductModel($id);

        $category = $product->category;

        $producents = Producent::find()->all();
        $producentsList = ArrayHelper::map($producents, 'id', 'name');


        $propertiesCategory = $category->propertyCategories;
        $propertiesProduct = $product->getPropertyProducts();
        $rez = [];
        $i = 0;
        foreach ($propertiesCategory as $el) {
            $rez[$i]['prop_id'] = $el->prop_id;
            $rez[$i]['prop_name'] = $el->prop->name;
            $curPropPruduct = $el->prop->getChildPropertyWhere(['parent_id' => $el->prop->id]);
            if (isset($curPropPruduct)) {
                if ($el->prop->isAnyField == 0) {
                    $rez[$i]['value_id'] = $curPropPruduct->name;

                } else {
                    $rez[$i]['value'] = $curPropPruduct->name;
                }
            }
            $i++;
        }

        $model = new CreateProductForm();
        $model->name = $product->name;
        $model->producent_id = $product->producent_id;
        $model->category_id = $product->category_id;
        $model->values = $rez;
        $model->decoration_id = $product->decoration_id;
        $model->product_id = $product->id;

        $categories = Category::find()->where(['parent_id' => null])->all();
        $categoriesList = ArrayHelper::map($categories, 'id', 'name');
        $producents = Producent::find()->all();
        $producentsList = ArrayHelper::map($producents, 'id', 'name');
        $decorations = Decoration::find()->orderBy('name')->all();
        $decorationsList = ArrayHelper::map($decorations, 'id', 'name', 'code');
        YII::warning($model->values);
        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            return $this->redirect(['update-product',
                'model' => $model,
                'categoriesList' => $categoriesList,
                'producentsList' => $producentsList,
                'decorationsList' => $decorationsList
            ]);
        }

        return $this->render('update-product', [
            'model' => $model,
            'categoriesList' => $categoriesList,
            'producentsList' => $producentsList,
            'decorationsList' => $decorationsList
        ]);

    }

    /**
     * Deletes an existing Property model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteProperty($id)
    {
        $prop = $this->findPropertyModel($id);
        foreach ($prop->properties as $el) {
            foreach ($el->propertyCategories as $el1){
                $el1->delete();
            }
            foreach ($el->propertyProducts as $el1){
                $el1->delete();
            }
            foreach ($el->properties as $el1){
                $el1->delete();
            }
            $el->delete();
        }
        foreach ($prop->propertyCategories as $el) {
            $el->delete();
        }
        foreach ($prop->propertyProducts as $el) {
            $el->delete();
        }
        $prop->delete();

        return $this->redirect(['properties']);
    }

    /**
     * Deletes an existing Ads model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteAds($id)
    {
        $ads = $this->findAdsModel($id);
        $ads->status = 0;
        $ads->save();

        return $this->redirect(['site/all-active-ads']);
    }

    /**
     * Deletes an existing Property model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteCategory($id)
    {
        $category = $this->findCategoryModel($id);
        foreach ($category->categories as $el) {
            $el->delete();
        }
        foreach ($category->propertyCategories as $el) {
            $el->delete();
        }
        foreach ($category->products as $el) {
            $this->actionDeleteProduct($el->id);
        }
        $category->delete();

        return $this->redirect(['site/create-category']);
    }

    /**
     * Deletes an existing Producent model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteProducent($id)
    {
        $producent = $this->findProducentModel($id);
        foreach ($producent->ads as $el) {
            $el->delete();
        }
        foreach ($producent->products as $el) {
            $el->delete();
        }
        $producent->delete();

        return $this->redirect(['create-producent']);
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDeleteProduct($id)
    {
        $product = $this->findProductModel($id);
        foreach ($product->propertyProducts as $el) {
            $el->delete();
        }
        foreach ($product->ads as $el) {
            $el->delete();
        }

        $product->delete();

        return $this->redirect(['products']);
    }


    /**
     * Finds the Property model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Property the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findPropertyModel($id)
    {
        if (($model = Property::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Property model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Category the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findCategoryModel($id)
    {
        if (($model = Category::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Producent model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Producent the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findProducentModel($id)
    {
        if (($model = Producent::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findUserModel($id)
    {
        if (($model = User::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findProductModel($id)
    {
        if (($model = Product::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
    /**
     * Finds the Ads model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Ads the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findAdsModel($id)
    {
        if (($model = Ads::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

}
