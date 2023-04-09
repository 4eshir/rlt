<?php

namespace app\controllers;

use app\models\Achievment;
use app\models\CurrencyWallet;
use app\models\extended\APIConnector;
use app\models\HistoryWallet;
use app\models\Product;
use app\models\ProductUser;
use app\models\SearchProduct;
use app\models\User;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\UploadedFile;

/**
 * ProductController implements the CRUD actions for Product model.
 */
class ProductController extends Controller
{
    /**
     * @inheritDoc
     */
    public function behaviors()
    {
        return array_merge(
            parent::behaviors(),
            [
                'verbs' => [
                    'class' => VerbFilter::className(),
                    'actions' => [
                        'delete' => ['POST'],
                    ],
                ],
            ]
        );
    }

    public function actionConfirm($user_id, $product_id)
    {
        $model = $this->findModel($product_id);

        $buyInfo = ProductUser::find()->where(['product_id' => $product_id])->andWhere(['user_id' => $user_id])->andWhere(['confirm_id' => 1])->one();
        $buyInfo->confirm_id = 2;
        $buyInfo->save();

        $this->addTransactionAndHistory($model->currency_id, $user_id, $model->user_creator_id, 8, $model->price);

        /* Начисление очков опыта*/
        $userBuyer = User::find()->where(['id' => $buyInfo->user_id])->one();
        $userBuyer->addExp(10);
        $userBuyer->checkAchievment();
        $userSaller = User::find()->where(['id' => $model->user_creator_id])->one();
        $userSaller->addExp(20);
        $userSaller->checkAchievment();

        return $this->redirect('index?r=product/view&id='.$model->id);
    }

    public function actionRefund($user_id, $product_id)
    {
        $model = $this->findModel($product_id);

        $this->addTransactionAndHistory($model->currency_id, $user_id, $model->user_creator_id, 7, $model->price);

        $buyInfo = ProductUser::find()->where(['product_id' => $product_id])->andWhere(['user_id' => $user_id])->andWhere(['confirm_id' => 1])->one();
        $buyInfo->confirm_id = 4;
        $buyInfo->save();

        if ($model->count == 0)
            $model->status_id = 1;
        $model->count++;
        $model->save();

        return $this->redirect('index?r=product/view&id='.$model->id);
    }

    public function addTransactionAndHistory ($currency_id, $user_id_buy, $user_creator_id, $operation_id, $price)
    {
        $wallet_in = CurrencyWallet::find()->joinWith(['wallet wallet'])->where(['wallet.user_id' => $user_creator_id])->andWhere(['wallet.type_id' => 1])
            ->andWhere(['currency_id' => $currency_id])->one();
        $wallet_out = CurrencyWallet::find()->joinWith(['wallet wallet'])->where(['wallet.user_id' => $user_id_buy])->andWhere(['wallet.type_id' => 1])
            ->andWhere(['currency_id' => $currency_id])->one();
        $api = new APIConnector();

        if ($operation_id == 3)
        {
            if ($wallet_out->count >= $price)
            {
                $api->ExchangeCoins($price*(-1), $wallet_out->wallet->privateKey, $wallet_out->wallet->publicKey, $wallet_in->wallet->publicKey, $currency_id);

                $wallet_out->count = $wallet_out->count - $price;
                $wallet_out->save();
            }
            else
                return false;
        }
        if ($operation_id == 7)
        {
            $api->ExchangeCoins($price, $wallet_out->wallet->privateKey, $wallet_out->wallet->publicKey, $wallet_in->wallet->publicKey, $currency_id);

            $wallet_out->count = $wallet_out->count + $price;
            $wallet_out->save();
        }
        if ($operation_id == 8 && !empty($wallet_in))
        {
            $api->ExchangeCoins($price, $wallet_out->wallet->privateKey, $wallet_out->wallet->publicKey, $wallet_in->wallet->publicKey, $currency_id);

            $wallet_in->count = $wallet_in->count + $price;
            $wallet_in->save();
        }

        $history = new HistoryWallet();
        $history->currency_wallet_out_id = $wallet_out->id;
        if (!empty($wallet_out))
            $history->currency_wallet_in_id = $wallet_in->id;
        $history->operation_id = $operation_id;
        $history->count = $price;
        $history->date_time = date("Y-m-d H:m");
        $history->save();

        return true;
    }

    public function actionBuy($id)
    {
        $model = $this->findModel($id);
        if ($model->status_id == 1)
        {
            if ($this->addTransactionAndHistory($model->currency_id, Yii::$app->user->identity->getId(), $model->user_creator_id, 3, $model->price))
            {
                $buyInfo = new ProductUser();
                $buyInfo->product_id = $model->id;
                $buyInfo->user_id = Yii::$app->user->identity->getId();
                $buyInfo->date = date("Y.m.d");
                $buyInfo->confirm_id = 1;
                $buyInfo->save();

                $model->count--;
                if ($model->count == 0)
                    $model->status_id = 2;
                $model->save();
                Yii::$app->session->setFlash("success", "Товар оплачен. Ожидайте подтверждение от продавца.");

                if ($model->status_id = 2)
                {
                    $achievement = new Achievment();
                    $achievement->Fire($buyInfo->user_id);
                }
            }
            else
            {
                Yii::$app->session->setFlash("danger", "Недостаточно средств для покупки товара!");

                $achievement = new Achievment();
                $achievement->Desperate(Yii::$app->user->identity->getId());
            }

        }

        return $this->redirect('index?r=product/view&id='.$model->id);
    }

    public function actionRevocation($id)
    {
        $model = $this->findModel($id);

        $user = Yii::$app->user->identity->getId();
        $buyInfo = ProductUser::find()->where(['product_id' => $id])->andWhere(['user_id' => $user])->andWhere(['confirm_id' => 1])->one();
        if (!empty($buyInfo))
        {
            $this->addTransactionAndHistory($model->currency_id, $buyInfo->user_id, $model->user_creator_id, 7, $model->price);

            $buyInfo->confirm_id = 3;
            $buyInfo->save();

            if ($model->count == 0)
                $model->status_id = 1;
            $model->count++;
            $model->save();
        }

        return $this->redirect('index?r=product/view&id='.$model->id);
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchProduct();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Product model.
     * @param int $id ID
     * @return string
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Product model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Product();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->photosFile = UploadedFile::getInstances($model, 'photosFile');
                if ($model->photosFile !== null)
                    $model->uploadPhotosFile();

                $model->user_creator_id = Yii::$app->user->identity->getId();
                $model->status_id = 1;
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->id]);
            }
        } else {
            $model->loadDefaultValues();
        }

        return $this->render('create', [
            'model' => $model,
        ]);
    }

    /**
     * Updates an existing Product model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        $buyInfo = ProductUser::find()->where(['product_id' => $model->id])->andWhere(['confirm_id' => 1])->all();
        if (empty($buyInfo))
        {
            if ($this->request->isPost && $model->load($this->request->post())) {
                $model->photosFile = UploadedFile::getInstances($model, 'photosFile');
                if ($model->photosFile !== null)
                    $model->uploadPhotosFile(10);
                if ($model->count > 0)
                    $model->status_id = 1;
                else
                    $model->status_id = 2;
                $model->save(false);
                return $this->redirect(['view', 'id' => $model->id]);
            }

            return $this->render('update', [
                'model' => $model,
            ]);
        }
        else
        {
            Yii::$app->session->setFlash("danger", "Невозможно изменить товар, который ожидает подтверждения покупки!");
            return $this->redirect('index?r=product/view&id='.$model->id);
        }
    }

    /**
     * Deletes an existing Product model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $model = $this->findModel($id);

        $buyInfo = ProductUser::find()->where(['product_id' => $model->id])->andWhere(['confirm_id' => 1])->all();
        if (empty($buyInfo))
        {
            $model->delete();
        }
        else
        {
            Yii::$app->session->setFlash("danger", "Невозможно удалить товар из маркетплейса, который ожидает подтверждения покупки!");
        }

        return $this->redirect('index?r=product/view&id='.$model->id);
    }

    public function actionDeleteFile($fileName = null, $modelId = null)
    {
        $model = Product::find()->where(['id' => $modelId])->one();

        if ($fileName !== null && !Yii::$app->user->isGuest && $modelId !== null) {

            $result = '';
            $split = explode(" ", $model->photo);
            $deleteFile = '';
            for ($i = 0; $i < count($split) - 1; $i++) {
                if ($split[$i] !== $fileName) {
                    $result = $result . $split[$i] . ' ';
                } else
                    $deleteFile = $split[$i];
            }
            $model->photo = $result;
            $model->save(false);
        }
        return $this->redirect('index?r=product/update&id='.$model->id);
    }

    /**
     * Finds the Product model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Product the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Product::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }

    /**
     * Lists all Product models.
     *
     * @return string
     */
    public function actionMarket()
    {
        $searchModel = new SearchProduct();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('market', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }
}
