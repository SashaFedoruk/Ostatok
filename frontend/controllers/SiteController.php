<?php

namespace frontend\controllers;

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
use common\models\PropertyCategory;

use frontend\models\TopUpForm;
use LiqPay;
use yii\behaviors\TimestampBehavior;
use yii\data\Pagination;
use yii\helpers\Url;
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
use common\models\AdsFilterForm;

use dosamigos\multiselect\MultiSelectListBox;
use yii\web\JsExpression;

use yii\data\ActiveDataProvider;
use frontend\models\PasswordResetRequestForm;
use frontend\models\ResetPasswordForm;
use frontend\models\SignupForm;
use frontend\models\ContactForm;


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
                'only' => ['logout', 'signup'],
                'rules' => [
                    [
                        'actions' => ['signup'],
                        'allow' => true,
                        'roles' => ['?'],
                    ],
                    [
                        'actions' => ['logout', 'index', 'update-user', 'create-category', 'properties',
                            'get-property-values', 'delete-property', 'delete-category', 'property-categories',
                            'get-properties-for-category', 'add-product', 'create-producent', 'delete-producent',
                            'get-fields-for-category', 'products', 'delete-product', 'view-product', 'update-product',
                            'create-ads', 'get-producents-by-category-id', 'products-by-category-id-and-producent-id', 'decorations-by-category-id-and-producent-id', 'heights-by-category-id-and-producent-id', 'all-active-ads',
                            'all-archive-ads', 'delete-ads', 'update-ads', 'publish-ads', 'search', 'copy-ads', 'create-ads-by-product-id'],
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
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionError()
    {
        $this->layout = "unauth-main-layout";
        $exception = Yii::$app->errorHandler->exception;
        return $this->render('error', ['name' => 'Ошибка', 'message' => 'Страница не найдена.']);
    }

    public function actionContactForm()
    {

        if (Yii::$app->request->post() && Yii::$app->request->post('ContactForm') != null) {

            $data = Yii::$app->request->post('ContactForm');
            $model = new ContactForm();
            $model->name = $data['name'];
            $model->body = $data['body'];
            $model->email = $data['email'];
            $model->sendEmail();
            //return "aaa ".$model->name;
            return $this->redirect(Yii::$app->request->referrer);
        }
    }

    public function actionCreateAdsBtn()
    {
        if (Yii::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        return $this->redirect(['site/create-ads']);
    }

    public function actionSetCityCookie($city_id)
    {
        if ($city_id == -1) {
            Yii::$app->response->cookies->remove('city');
            Yii::$app->response->cookies->remove('city_id');
        } else {
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'city',
                'value' => City::findOne(['id' => $city_id])->name
            ]));
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'city_id',
                'value' => $city_id
            ]));
        }
        return $this->redirect(Yii::$app->request->referrer ?: Yii::$app->homeUrl);

    }
    public function actionAutomateSendToArchive()
    {
//        $this->layout = "";
//        echo "Cur Time: ". gmdate("Y-m-d", strtotime('-30 days'))."<br>";
//        $ads = Ads::find()->where(['<=', 'created_at', strtotime('-30 days') ])->andWhere(['status' => 1])->all();
//        foreach($ads as $el){
//            echo gmdate("Y-m-d", $el->created_at)." ".$el->user_id." ".$el->user->firstname."<br>";
//            $el->status = 0;
//            $el->created_at = strtotime('now');
//            $el->save();
//        }
//        return 0;

    }

    public function actionSearch()
    {
//        Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
//        return ['search' => 'hello'];
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $data = $data['text'];

            $params = explode('\s*', $data);
//            foreach ($params as $idx => $el){
//                $params[$idx] = '%'.$el.'%';
//
//            }
            $products = Product::find()->where(['like', 'name', $params])->limit(3)->all();
//            $products = Product::find()->where(['like', 'name', $params[0]]);
//            foreach ($params as $el){
//                $products = $products->andWhere(['like', 'name', '\%$el\%']);
//            }
//            $products = $products->limit(3)->all();

            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $rez = "";
            foreach ($products as $el) {
                $rez .= $this->renderPartial('_partial-search-rezult-item', [
                    'model' => $el
                ]);
            }

            return ['search' => $rez];
        }
        if (Yii::$app->request->get()) {
            $name = Yii::$app->request->get('ProductSearch')['name'];
            $params = explode('\s*', $name);
            $products = Product::find()->where(['like', 'name', $params]);

            $countQuery = clone $products;
            $pages = new Pagination(['totalCount' => $countQuery->count()]);
            $pages->setPageSize(12);
            $products = $products->offset($pages->offset)
                ->limit($pages->limit)
                ->all();

            return $this->render('view-products', [
                'model' => $products,
                'pages' => $pages
            ]);
        }

    }

    /**
     * Displays homepage.
     *
     * @return mixed
     */
    public function actionIndex()
    {
        $categories = Category::find()->joinWith(['products'])->groupBy(['category.id'])->having(['>', 'count(category.id)', '0'])->orderBy(['count(category.id)' => SORT_DESC])->all();

        return $this->render('index', [
            'model' => $categories
        ]);
    }

    /**
     * Catalog.
     *
     * @return mixed
     */
    public function actionCatalog()
    {
        //$categories = Category::find()->joinWith(['products'])->groupBy(['category.id'])->having(['>', 'count(category.id)', '0'])->all();
        $categories = Category::find()->joinWith(['products'])->groupBy(['category.id'])->where(['category.id' => 15])->having(['>', 'count(category.id)', '0'])->orderBy(['count(category.id)' => SORT_DESC])->all();

        $categories = array_merge($categories, Category::find()->joinWith(['products'])->groupBy(['category.id'])->where(['!=', 'category.id', 15])->having(['>', 'count(category.id)', '0'])->orderBy(['count(category.id)' => SORT_DESC])->all());

//        $categories = Category::find()->where(['id' => 15])->joinWith(['products'])->groupBy(['category.id'])->having(['>', 'count(category.id)', '0'])->orderBy(['count(category.id)' => SORT_DESC])->all();


        return $this->render('catalog', [
            'model' => $categories
        ]);
    }

    /**
     * ViewProducts by CategoryId.
     * @param integer $categoryId
     * @param integer $producentId
     * @return mixed
     */
    public function actionViewProducts($categoryId, $producentId = -1)
    {
        $products = Product::find()->where(['product.category_id' => $categoryId]);

        if ($producentId != -1) {
            $products->andWhere(['producent_id' => $producentId]);
        }

//        if (isset(Yii::$app->request->cookies['city_id'])) {
//            $products = $products->joinWith(['ads'])->groupBy(['product.id'])->leftJoin('user', 'ads.user_id = user.id')->where(['user.city_id' => Yii::$app->request->cookies['city_id']->value]);
//            $products = $products->orderBy(['count(ads.id)' => SORT_DESC]);
//        }

        $products = $products->addOrderBy('name');


//        if (isset(Yii::$app->request->cookies['city_id'])) {
//            $cityId = Yii::$app->request->cookies['city_id']->value;
//            $ads->joinWith(['user'])->where(['city_id' => $cityId]);
//        }
//        $products = $products->joinWith(['ads'])->groupBy(['product.id'])->having(['>', 'count(ads.id)', '0']);

        $countQuery = clone $products;
        $pages = new Pagination(['totalCount' => $countQuery->count()]);
        $pages->setPageSize(12);

        $products = $products->offset($pages->offset)
            ->limit($pages->limit)
            ->all();

        return $this->render('view-products', [
            'model' => $products,
            'pages' => $pages
        ]);
    }


    /**
     * Logs in a user.
     *
     * @return mixed
     */
    public function actionLogin()
    {
        if (!Yii::$app->user->isGuest) {
            return $this->goHome();
        }

        $model = new LoginForm();
        $signUpModel = new SignupForm();

        if ($model->load(Yii::$app->request->post()) && $model->login()) {
            $user = User::findOne(['id' => Yii::$app->user->id]);
            if (isset(Yii::$app->request->cookies['city'])) {
                Yii::$app->response->cookies->remove('city');
                Yii::$app->response->cookies->remove('city_id');
            }
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'city',
                'value' => City::findOne(['id' => $user->city_id])->name
            ]));
            Yii::$app->response->cookies->add(new \yii\web\Cookie([
                'name' => 'city_id',
                'value' => $user->city_id
            ]));


            return $this->redirect(['index']);
        } else if ($signUpModel->load(Yii::$app->request->post()) && $user = $signUpModel->signup()) {
            YII::warning("Start signup");
            if (Yii::$app->getUser()->login($user)) {
                $user = User::findOne(['id' => Yii::$app->user->id]);
                if (isset(Yii::$app->request->cookies['city'])) {
                    Yii::$app->response->cookies->remove('city');
                    Yii::$app->response->cookies->remove('city_id');
                }
                Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'city',
                    'value' => City::findOne(['id' => $user->city_id])->name
                ]));
                Yii::$app->response->cookies->add(new \yii\web\Cookie([
                    'name' => 'city_id',
                    'value' => $user->city_id
                ]));
                return $this->redirect(['index']);
            }

        } else {
            $model->password = '';

            return $this->render('login', [
                'model' => $model,
                'signUpModel' => $signUpModel
            ]);
        }
    }

    /**
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdateUser()
    {


        $this->layout = "admin-panel";
        $citiesList = ArrayHelper::map(City::find()->all(), 'id', 'name');

        $model = $this->findUserModel(Yii::$app->user->id);
        $updateModel = new UserUpdateForm($model);
        $changePasswordModel = new ChangePasswordForm(Yii::$app->user->identity);

        $topUpFrom = new TopUpForm();

        if ($updateModel->load(Yii::$app->request->post()) && $updateModel->save()) {
            return $this->redirect(['update-user', 'model' => $updateModel, 'citiesList' => $citiesList]);
        } else if ($changePasswordModel->load(Yii::$app->request->post()) && $changePasswordModel->validate() && $changePasswordModel->changePassword()) {
            Yii::$app->session->setFlash('success', 'Password Changed!');
        } else if ($topUpFrom->load(Yii::$app->request->post()) && $topUpFrom->validate()) {
            $urlBase = 'https://www.liqpay.ua/api/3/checkout';
            $public_key = "i20684610351";
            $private_key = "zId2rRZxbHZiGVywZ0a6yLQ86mw4DESrHevD5z0R";
            //$liqpay = new LiqPay($public_key, $private_key);

            $json_string = [
                "public_key" => $public_key,
                "version" => "3",
                "action" => "pay",
                "amount" => $topUpFrom->money,
                "currency" => "UAH",
                "description" => "test",
                "order_id" => base64_encode(time() . $model->id),
                "sandbox" => "1",
                "server_url" => Url::toRoute(['site/require-payment'])
            ];


            $data = base64_encode(json_encode($json_string));
            $sign_string = $private_key . $data . $private_key;
            $signature = base64_encode(sha1($sign_string, 1));
            //$signature = "cTl+sKMdL6O3XG3SFoC0ZadJ4zc=";
//            echo $signature;
//            return null;


//json_string = {"public_key":"i00000000","version":"3","action":"pay","amount":"3","currency":"UAH","description":"test","order_id":"000001"}
            return $this->redirect('https://www.liqpay.com/api/3/checkout?data=' . $data . '&signature=' . $signature);


        }

        return $this->render('update-user', [
            'model' => $updateModel,
            'citiesList' => $citiesList,
            'changePasswordModel' => $changePasswordModel,
            'topUpModel' => $topUpFrom
        ]);
    }

    public function actionRequirePayment()
    {
        return null;
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
            $height_id = (int)$data['height_id'];
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            //$products = Product::find()->where(['product.category_id' => $category_id])->andWhere(['product.producent_id' => $producent_id])->andWhere(['product.decoration_id' => $decoration_id]);
            // $products = $products->joinWith('propertyproduct')->andWhere(['propertyproduct.prop_id' => $height_id])->all();
            //$rez = ArrayHelper::map($products->all(), 'product.id', 'product.name');
            $productsId = PropertyProduct::find()->select(['product_id'])->where(['prop_id' => $height_id])->joinWith('product')->andWhere(['product.producent_id' => $producent_id])->andWhere(['product.decoration_id' => $decoration_id])->orderBy(['product.name' => SORT_DESC])->all();
            $productsId = ArrayHelper::getColumn($productsId, 'product_id');
            $products = Product::find()->where(['in', 'id', $productsId])->all();

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

    public function actionHeightsByCategoryIdAndProducentId()
    {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $category_id = (int)$data['category_id'];
            $producent_id = (int)$data['producent_id'];
            $decoration_id = (int)$data['decoration_id'];
            Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;

            $productsId = Product::find()->distinct()->where(['category_id' => $category_id])->andWhere(['producent_id' => $producent_id])
                ->andWhere(['decoration_id' => $decoration_id])->all();


            $productsId = ArrayHelper::getColumn($productsId, 'id');
            //$decorations = Decoration::find()->where(['in', 'id', $decorationsId])->orderBy('name')->all();
            $propertyId = PropertyProduct::find()->distinct()->joinWith(['property'])->where(['property.parent_id' => 5])->andWhere(['in', 'product_id', $productsId])->orderBy(['property.name' => SORT_DESC])->all();

            $rez = ArrayHelper::map($propertyId, 'prop_id', 'property.name');
            //$rez = ArrayHelper::map($productsId, 'id', 'name');


            return ['search' => $rez];
        }
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
     * View Product.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
    public function actionViewProduct($id)
    {
        $filterModel = new AdsFilterForm();
        $model = $this->findProductModel($id);
        $ads = $model->getAds();
        if (isset(Yii::$app->request->cookies['city_id'])) {
            $cityId = Yii::$app->request->cookies['city_id']->value;
            $ads = $ads->joinWith(['user'])->where(['city_id' => $cityId]);
        }
        $ads = $ads->andWhere(["ads.status" => 1]);

        if ($filterModel->load(Yii::$app->request->post())) {
            if ($filterModel->minSize != null) {
                $ads = $ads->andWhere('width >=' . (float)$filterModel->minSize);
            }
            if ($filterModel->maxSize != null) {
                $ads = $ads->andWhere('length >=' . (float)$filterModel->maxSize);
            }
            if ($filterModel->sortBy != null) {
                $list = [1 => 'По дате', 2 => 'По макс. цене', 3 => 'По мин. цене'];
                if ($filterModel->sortBy == 1) {
                    $ads = $ads->orderBy(['updated_at' => SORT_DESC]);
                } else if ($filterModel->sortBy == 2) {
                    $ads = $ads->orderBy(['price' => SORT_DESC]);
                } else if ($filterModel->sortBy == 3) {
                    $ads = $ads->orderBy(['price' => SORT_ASC]);
                }

            }
//            $this->layout = "";
////            
//            return $filterModel->sortBy;

        } else {
            $ads = $ads->orderBy(['updated_at' => SORT_DESC]);
        }
        $ads = $ads->all();


        return $this->render('view-product', [
            'model' => $model,
            'filterModel' => $filterModel,
            'ads' => $ads
        ]);
    }

    /**
     * All Ads.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAllActiveAds()
    {
        $this->layout = "admin-panel";
        $model = Ads::find()->where(['status' => 1])->andWhere(['user_id' => YII::$app->user->id])->orderBy(['updated_at' => SORT_DESC]);
        $sum = $model->sum('price');
        $count = $model->count();

        $model = $model->all();
        return $this->render('all-active-ads', [
            'model' => $model,
            'sum' => $sum,
            'count' => $count
        ]);
    }

    public function actionCreateAdsByProductId($id)
    {
        if (YII::$app->user->isGuest) {
            return $this->redirect(['site/login']);
        }
        $this->layout = "admin-panel";
        $categories = Category::find()->where(['parent_id' => null])->all();

        foreach ($categories as $key => $el) {
            if ($el->getCountProducts() == 0) {
                unset($categories[$key]);
            }
        }
        $categoriesList = ArrayHelper::map($categories, 'id', 'name');

        $producents = Producent::find()->all();
        $producentsList = ArrayHelper::map($producents, 'id', 'name');


        //$adsModel = $this->findAdsModel($id);
        $product = $this->findProductModel($id);
        $height_id = PropertyProduct::find()->select(['property.id'])->joinWith(['property'])->where(['property_product.product_id' => $product->id])->andWhere(['property.parent_id' => 5])->one();
        $model = new AdsForm();


        $model->product_id = $product->id;
        $model->category_id = $product->category_id;
        $model->producent_id = $product->producent_id;
        $model->decoration_id = $product->decoration_id;
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

    public function actionCopyAds($id)
    {
        $this->layout = "admin-panel";
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

    /**
     * Archive Ads.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionAllArchiveAds()
    {
        $this->layout = "admin-panel";
        $model = Ads::find()->where(['status' => 0])->andWhere(['user_id' => YII::$app->user->id])->orderBy(['updated_at' => SORT_DESC]);
        $sum = $model->sum('price');
        $count = $model->count();
        $model = $model->all();

        return $this->render('all-archive-ads', [
            'model' => $model,
            'sum' => $sum,
            'count' => $count
        ]);
    }

    public function getPrice($width, $length)
    {
        $size = $width * $length / 1000000;
        $price = 0;
        if ($size <= 0.5) {
            $price = 25;
        } else if ($size <= 1) {
            $price = 40;
        } else if ($size > 1) {
            $price = 55;
        }
        return $price;
    }

    /**
     * Create Ads.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreateAds()
    {
        $this->layout = "admin-panel";
        $categories = Category::find()->where(['parent_id' => null])->joinWith(['products'])->groupBy(['category.id'])->having(['>', 'count(category.id)', '0'])->orderBy(['count(category.id)' => SORT_DESC])->all();;
        foreach ($categories as $key => $el) {
            if ($el->getCountProducts() == 0) {
                unset($categories[$key]);
            }
        }
        $categoriesList = ArrayHelper::map($categories, 'id', 'name');

        $producents = Producent::find()->all();
        $producentsList = ArrayHelper::map($producents, 'id', 'name');


        $model = new AdsForm();

        $model->user_id = yii::$app->user->id;

        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
//            $user = User::findOne(['id' =>  yii::$app->user->id]);
//            $price = $this->getPrice($model->width, $model->length);
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
        $this->layout = "admin-panel";
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

        $model->status = $adsModel->status;
        $model->price = $adsModel->price;
        $model->width = $adsModel->width;
        $model->length = $adsModel->length;
        $model->product_id = $adsModel->product_id;
        $model->user_id = $adsModel->user_id;
        $model->category_id = $adsModel->product->category_id;
        $model->producent_id = $adsModel->product->producent_id;
        $model->decoration_id = $adsModel->product->decoration_id;
        $model->id = $adsModel->id;
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

        if (($model->load(Yii::$app->request->post()) || $model->load(Yii::$app->request->get())) && $model->save()) {
            return $this->redirect(['site/all-archive-ads']);
        }

        return $this->render('update-ads', [
            'model' => $model,
            'categoriesList' => $categoriesList,
            'producentsList' => $producentsList,
            'decorationsList' => $decorationsList,
            'heightsList' => $heightsList,
            'productsList' => $productsList
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
        $this->layout = "admin-panel";
        $adsModel = $this->findAdsModel($id);


        $user = User::findOne(['id' => yii::$app->user->id]);
        $price = $this->getPrice($adsModel->width, $adsModel->length);
        $adsModel->status = 1;
        $adsModel->created_at = date('U');

        if ($adsModel->save()) {
            $tmp = new AdsStats();
            $tmp->ads_id = $adsModel->getPrimaryKey();
            $tmp->save();
        }
//            if($user->free_ads - 1 >= 0) {
//                $user->free_ads--;
//                $user->save();
//                $adsModel->save();
//
//            } else if ($user->money - $price > 0){
//                $user->money -= $price;
//                $user->save();
//                $adsModel->save();
//            } else {
//                return $this->redirect(['site/update-user']);
//            }


        return $this->redirect(['site/all-active-ads']);
    }


    /**
     * Logs out the current user.
     *
     * @return mixed
     */
    public function actionLogout()
    {
        Yii::$app->user->logout();

        return $this->goHome();
    }

    /**
     * Displays contact page.
     *
     * @return mixed
     */
    public function actionContact()
    {
        $model = new ContactForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail(Yii::$app->params['adminEmail'])) {
                Yii::$app->session->setFlash('success', 'Thank you for contacting us. We will respond to you as soon as possible.');
            } else {
                Yii::$app->session->setFlash('error', 'There was an error sending your message.');
            }

            return $this->refresh();
        } else {
            return $this->render('contact', [
                'model' => $model,
            ]);
        }
    }

    /**
     * Displays about page.
     *
     * @return mixed
     */
    public function actionAbout()
    {
        return $this->render('about');
    }

    /**
     * Signs user up.
     *
     * @return mixed
     */
    public function actionSignup()
    {
        $model = new SignupForm();
        if ($model->load(Yii::$app->request->post())) {
            if ($user = $model->signup()) {
                if (Yii::$app->getUser()->login($user)) {
                    return $this->goHome();
                }
            }
        }

        return $this->render('signup', [
            'model' => $model,
        ]);
    }

    /**
     * Requests password reset.
     *
     * @return mixed
     */
    public function actionRequestPasswordReset()
    {
        $model = new PasswordResetRequestForm();
        if ($model->load(Yii::$app->request->post()) && $model->validate()) {
            if ($model->sendEmail()) {
                Yii::$app->session->setFlash('success', 'Check your email for further instructions.');

                return $this->goHome();
            } else {
                Yii::$app->session->setFlash('error', 'Sorry, we are unable to reset password for the provided email address.');
            }
        }

        return $this->render('requestPasswordResetToken', [
            'model' => $model,
        ]);
    }

    /**
     * Resets password.
     *
     * @param string $token
     * @return mixed
     * @throws BadRequestHttpException
     */
    public function actionResetPassword($token)
    {
        try {
            $model = new ResetPasswordForm($token);
        } catch (InvalidParamException $e) {
            throw new BadRequestHttpException($e->getMessage());
        }

        if ($model->load(Yii::$app->request->post()) && $model->validate() && $model->resetPassword()) {
            Yii::$app->session->setFlash('success', 'New password saved.');

            return $this->goHome();
        }

        return $this->render('resetPassword', [
            'model' => $model,
        ]);
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

    public function actionAddDb()
    {



//        $arr = '';
//
//        $data = explode("\n", $arr);
//        $this->layout = "";
//        $i = 0;
//        foreach ($data as $el) {
//            if ($el != "") {
//                $cur = json_decode(trim($el), true);
//                $tmp = Product::findOne(['name' => $cur['name']]);
//                if($tmp == null){
//
//
//                foreach ($cur as $key => $value) {
//                    if ($key != "name" && $key != "img" && $key != "decoration" && $key != "Коллекция") {
//                        if ($key != "Производитель") {
//                            $prop = Property::findOne(['name' => $key, 'parent_id' => null]);
//                            if ($prop == null) {
//                                $prop = new Property();
//                                $prop->name = $key;
//                                $prop->parent_id = null;
//                                $i++;
//                                $prop->save();
//                            }
//                            $newPropValue = Property::findOne(['name' => $value, 'parent_id' => $prop->getPrimaryKey()]);
//                            if ($newPropValue == null) {
//                                $newPropValue = new Property();
//                                $newPropValue->name = $value;
//                                $newPropValue->parent_id = $prop->getPrimaryKey();
//                                $newPropValue->isAnyField = 0;
//                               $newPropValue->save();
//                                $i++;
//
//                                //return $newPropValue->name.' || '.$newPropValue->parent_id.' || '.($newPropValue->validate() == true ? '1':'2');
//                            }
//                        } else {
//                            $producent = Producent::findOne(['name' => $value]);
//                            if ($producent == null) {
//                                $producent = new Producent();
//                                $producent->name = $value;
//                                $producent->code = "0";
//                                $i++;
//                                $producent->save();
//                                //return $key . ' none1';
//                            }
//                        }
//                    }
//                }
//                }
//            }
//        }
//        $rez = "";
//        $i = 0;
//        $catId = 15;
//
//        foreach ($data as $el) {
//
//            if ($el != "") {
//                $cur = json_decode($el, true);
//                $prod = Product::findOne(['name' => $cur['name']]);
////                if(isset($cur['img']) && $prod->imgUrl == ""){
////                    $i++;
////                    $prod->imgUrl = "https://viyar.ua".$cur['img'];
////                    $prod->save();
////                }
//                $prod = Product::findOne(['name' => $cur['name']]);
//                if ($prod != null) {
//                    $i++;
//                    $rez .= $prod->name."<br>";
//                    continue;
//                }
//
//                $prod = new Product();
//                //$prod->name = $cur['name'];
//                $prod->name = $cur['name'];
//
//                $decoration = Decoration::findOne(['code' => "123123"]);
//                if ($decoration == null) {
//                    $decoration = Decoration::findOne(['name' => 'Другое']);
//                }
//                $prod->decoration_id = $decoration->id;
//                $prod->imgUrl = $cur['img'];
//                $prod->category_id = $catId;
//                $prod->producent_id = Producent::findOne(['name' => $cur['Производитель']])->id;
//                $prod->save();
//                //$i++;
//
//
//                foreach ($cur as $key => $value) {
//                    if ($key != "name" && $key != "img" && $key != "decoration" && $key != "Коллекция" && $key != "Производитель") {
//                        $prop = Property::findOne(['name' => $value]);
//                        if($prop == null) {
//                            continue;
//                        }
//                        $propCategory = PropertyCategory::findOne(['prop_id' => $prop->parent->id, 'category_id' => $catId]);
//                        if ($propCategory == null) {
//                            $propCategory = new PropertyCategory();
//                            $propCategory->category_id = $catId;
//                            $propCategory->prop_id = $prop->parent->id;
//                            $propCategory->save();
//                        }
//                        $prodProp = new PropertyProduct();
//                        $prodProp->product_id = $prod->getPrimaryKey();
//                        $prodProp->prop_id = $prop->id;
//                        $prodProp->save();
//
//                    }
//
//                }
//
//            }
//        }
        //return $i." ".$rez;
        //return $cur['name'];

    }
}
