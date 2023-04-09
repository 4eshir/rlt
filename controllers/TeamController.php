<?php

namespace app\controllers;

use app\models\Team;
use app\models\User;
use app\models\extended\PayModel;
use app\models\TeamUser;
use app\models\SearchTeam;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\helpers\Html;

use Yii;

/**
 * TeamController implements the CRUD actions for Team model.
 */
class TeamController extends Controller
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
     * Lists all Team models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $searchModel = new SearchTeam();
        $dataProvider = $searchModel->search($this->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Team model.
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
     * Creates a new Team model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new Team();
        $model->status_id = 1;

        if ($this->request->isPost) {
            if ($model->load($this->request->post())) {
                if ($model->status_id == 0) $model->status_id = 2;
                //добавляем опыт
                $mainUser = User::find()->where(['id' => Yii::$app->user->identity->getId()])->one();
                $mainUser->addExp(25);

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
     * Updates an existing Team model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post())) {
            if ($model->status_id == 0) $model->status_id = 2;
            //снимаем опыт
            $mainUser = User::find()->where(['id' => Yii::$app->user->identity->getId()])->one();
            $mainUser->addExp(-25);
            $model->save();
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing Team model.
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

    public function actionJoin($id)
    {
        $teamUser = TeamUser::find()->where(['team_id' => $id])->andWhere(['user_id' => Yii::$app->user->identity->getId()])->one();
        if ($teamUser == null)
        {
            //добавляем опыт
            $mainUser = User::find()->where(['id' => Yii::$app->user->identity->getId()])->one();
            $mainUser->addExp(25);

            $teamUser = new TeamUser();
            $teamUser->team_id = $id;
            $teamUser->user_id = Yii::$app->user->identity->getId();
            $teamUser->save();
        }

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionQuit($id)
    {
        //снимаем опыт
        $mainUser = User::find()->where(['id' => Yii::$app->user->identity->getId()])->one();
        $mainUser->addExp(-25);

        $teamUser = TeamUser::find()->where(['team_id' => $id])->andWhere(['user_id' => Yii::$app->user->identity->getId()])->one();
        if ($teamUser !== null) $teamUser->delete();

        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionPay($id)
    {
        $model = new PayModel();
        $model->id = $id;

        if ($this->request->isPost && $model->load($this->request->post())) {
            $model->save();
            return $this->redirect(['view', 'id' => $id]);
        }

        return $this->render('pay', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Team model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Team the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Team::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
