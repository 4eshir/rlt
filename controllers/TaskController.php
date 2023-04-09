<?php

namespace app\controllers;

use app\models\Task;
use app\models\User;
use app\models\Wallet;
use app\models\extended\APIConnector;
use app\models\CurrencyWallet;
use app\models\TaskUser;
use app\models\TaskUserConfirm;
use app\models\SearchTask;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;


use Yii;

/**
 * TaskController implements the CRUD actions for Task model.
 */
class TaskController extends Controller
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
     * Lists all Task models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchTask();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Task model.
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
     * Creates a new Task model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Task();

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                //добавляем опыт
                $mainUser = User::find()->where(['id' => Yii::$app->user->identity->getId()])->one();
                $mainUser->addExp(20);

                $model->user_creator_id = Yii::$app->user->identity->getId();
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
     * Updates an existing Task model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Task model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param int $id ID
     * @return \yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionDelete($id)
    {
        //снимаем опыт
        $mainUser = User::find()->where(['id' => Yii::$app->user->identity->getId()])->one();
        $mainUser->addExp(-20);

        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionJoin($id)
    {
        $join = new TaskUser();
        $join->user_id = Yii::$app->user->identity->getId();
        $join->task_id = $id;
        $join->date = date('Y-m-d');
        $join->save();

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionConfirm($id)
    {
        $taskUser = TaskUserConfirm::find()->where(['id' => $id])->one();
        $wallet = Wallet::find()->where(['user_id' => $taskUser->user_hr_id])->andWhere(['type_id' => 2])->one();
        $currencyWallet = CurrencyWallet::find()->where(['wallet_id' => $wallet->id])->andWhere(['currency_id' => $taskUser->taskUser->task->currency_id])->one();

        if ($currencyWallet->count >= $taskUser->taskUser->task->price)
        {

            $currencyWallet->count -= $taskUser->taskUser->task->price;
            $currencyWallet->save();
            $wallet1 = Wallet::find()->where(['user_id' => $taskUser->taskUser->user_id])->andWhere(['type_id' => 1])->one();
            $currencyWallet1 = CurrencyWallet::find()->where(['wallet_id' => $wallet1->id])->andWhere(['currency_id' => $taskUser->taskUser->task->currency_id])->one();
            $currencyWallet1->count += $taskUser->taskUser->task->price;
            $currencyWallet1->save();

            APIConnector::ExchangeCoins($taskUser->taskUser->task->price, $wallet->privateKey, $wallet->publicKey, $wallet1->publicKey, $taskUser->taskUser->task->currency_id);

            //добавляем опыт
            $mainUser = User::find()->where(['id' => $taskUser->taskUser->user_id])->one();
            $mainUser->addExp(15);
            $mainUser->checkAchievment();
        }
        else
        {
            Yii::$app->session->setFlash('danger', 'Недостаточно средств для оплаты задания!');
            return $this->redirect(['view', 'id' => $taskUser->taskUser->task_id]);
        }

        $taskUser->confirm = 1;
        $taskUser->save();

        return $this->redirect(['view', 'id' => $taskUser->taskUser->task_id]);
    }

    public function actionComplete($id)
    {
        $complete = new TaskUserConfirm();
        $join = TaskUser::find()->where(['user_id' => Yii::$app->user->identity->getId()])->andWhere(['task_id' => $id])->orderBy(['id' => SORT_DESC])->all();
        $complete->task_user_id = $join[0]->id;
        $complete->user_hr_id = $join[0]->task->user_creator_id;
        $complete->date = date('Y-m-d');
        $complete->confirm = 0;
        $complete->save();

        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionQuit($id)
    {
        $join = TaskUser::find()->where(['task_id' => $id])->orderBy(['id' => SORT_DESC])->all();
        $complete = TaskUserConfirm::find()->where(['task_user_id' => $join[0]->id])->andWhere(['confirm' => 0])->one();

        if ($complete !== null) $complete->delete();
        if ($join[0] !== null) $join[0]->delete();

        

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    /**
     * Finds the Task model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Task the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Task::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
