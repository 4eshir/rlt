<?php

namespace app\controllers;

use app\models\BusinessGame;
use app\models\StepUser;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

use Yii;

/**
 * BusinessGameController implements the CRUD actions for BusinessGame model.
 */
class BusinessGameController extends Controller
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
     * Lists all BusinessGame models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => BusinessGame::find(),
            /*
            'pagination' => [
                'pageSize' => 50
            ],
            'sort' => [
                'defaultOrder' => [
                    'id' => SORT_DESC,
                ]
            ],
            */
        ]);

        return $this->render('index', [
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single BusinessGame model.
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
     * Creates a new BusinessGame model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return string|\yii\web\Response
     */
    public function actionCreate()
    {
        $model = new BusinessGame();

        if ($this->request->isPost) {
            if ($model->load($this->request->post()) && $model->save()) {
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
     * Updates an existing BusinessGame model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param int $id ID
     * @return string|\yii\web\Response
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionUpdate($id)
    {
        $model = $this->findModel($id);

        if ($this->request->isPost && $model->load($this->request->post()) && $model->save()) {
            return $this->redirect(['view', 'id' => $model->id]);
        }

        return $this->render('update', [
            'model' => $model,
        ]);
    }

    /**
     * Deletes an existing BusinessGame model.
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

    public function actionGameup()
    {
        $model = BusinessGame::find()->where(['id' => 1])->one();
        return $this->render('gameup', [
            'model' => $model,
        ]);
    }

    public function actionGamedown()
    {
        $model = BusinessGame::find()->where(['id' => 2])->one();
        return $this->render('gamedown', [
            'model' => $model,
        ]);
    }

    public function actionResult($s1, $s2)
    {
        $step = new StepUser();
        $step->user_id = Yii::$app->user->identity->getId();
        $step->step_id = 1;
        $step->end_key = 1;
        $step->log = 'Ознакомился с лотом';
        $step->save();

        $step = new StepUser();
        $step->user_id = Yii::$app->user->identity->getId();
        $step->step_id = 2;
        $step->end_key = $s1;
        $step->log = 'Сделал ставку';
        $step->save();

        $step = new StepUser();
        $step->user_id = Yii::$app->user->identity->getId();
        $step->step_id = 3;
        $step->end_key = $s2;
        $step->log = 'Сделал ставку';
        $step->save();

        $step = new StepUser();
        $step->user_id = Yii::$app->user->identity->getId();
        $step->step_id = 4;
        $step->end_key = $s1 + $s2 == 2 ? 1 : 0;
        $step->log = 'Завершил игру';
        $step->save();

        return $this->render('view', [
            'model' => $this->findModel(1),
        ]);
    }

    public function actionResult2($s1, $s2)
    {
        $step = new StepUser();
        $step->user_id = Yii::$app->user->identity->getId();
        $step->step_id = 5;
        $step->end_key = 1;
        $step->log = 'Ознакомился с тендером';
        $step->save();

        $step = new StepUser();
        $step->user_id = Yii::$app->user->identity->getId();
        $step->step_id = 6;
        $step->end_key = $s1;
        $step->log = 'Изменил сумму';
        $step->save();

        $step = new StepUser();
        $step->user_id = Yii::$app->user->identity->getId();
        $step->step_id = 7;
        $step->end_key = $s2;
        $step->log = 'Изменил сумму';
        $step->save();

        $step = new StepUser();
        $step->user_id = Yii::$app->user->identity->getId();
        $step->step_id = 8;
        $step->end_key = $s1 + $s2 == 2 ? 1 : 0;
        $step->log = 'Завершил игру';
        $step->save();

        return $this->render('view', [
            'model' => $this->findModel(2),
        ]);
    }

    /**
     * Finds the BusinessGame model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return BusinessGame the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = BusinessGame::findOne(['id' => $id])) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
