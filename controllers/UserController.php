<?php

namespace app\controllers;

use app\models\User;
use app\models\Wallet;
use app\models\CurrencyWallet;
use app\models\HistoryWallet;
use app\models\extended\AddCoinsModel;
use app\models\extended\APIConnector;
use app\models\SearchUser;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use Yii;

/**
 * UserController implements the CRUD actions for User model.
 */
class UserController extends Controller
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

    /**
     * Lists all User models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchUser();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single User model.
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
     * Creates a new User model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new User();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                $model->setPassword($model->password_hash);
                $model->generateAuthKey();
                $model->save();
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
     * Updates an existing User model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);
        $model->prepare();

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    public function actionAddCoins($id)
    {
        $model = new AddCoinsModel();
        $model->user_id = $id;

        if ($this->request->isPost && $model->load($this->request->post())) {

            $model->save();

            $wallet = Wallet::find()->where(['user_id' => $id])->andWhere(['type_id' => $model->walletType])->one();

            $result = APIConnector::AddCoins($model->count, $wallet->publicKey, $model->currencyType);

            $currencyWallet = CurrencyWallet::find()->where(['wallet_id' => $wallet->id])->andWhere(['currency_id' => $model->currencyType])->one();
            $history = new HistoryWallet();
            $history->currency_wallet_in_id = $currencyWallet->id;
            $history->currency_wallet_out_id = null;
            $history->operation_id = 6;
            $history->count = $model->count;
            $history->date_time = date('Y-m-d h:i:s');
            $history->save();
            
            Yii::$app->session->setFlash('success', 'Средства успешно начислены');
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('add-coins', [
            'model' => $model,
        ]);
    }

    public function actionDeleteCoins($id)
    {
        $model = new AddCoinsModel();
        $model->user_id = $id;

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->count *= -1;
            $model->save();

            $wallet = Wallet::find()->where(['user_id' => $id])->andWhere(['type_id' => $model->walletType])->one();
            $currencyWallet = CurrencyWallet::find()->where(['wallet_id' => $wallet->id])->andWhere(['currency_id' => $model->currencyType])->one();
            $history = new HistoryWallet();
            $history->currency_wallet_out_id = $currencyWallet->id;
            $history->currency_wallet_in_id = null;
            $history->operation_id = 6;
            $history->count = $model->count * -1;
            $history->date_time = date('Y-m-d h:i:s');
            $history->save();

            Yii::$app->session->setFlash('success', 'Средства успешно списаны');
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('delete-coins', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing User model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    /**
     * Finds the User model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return User the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = User::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
