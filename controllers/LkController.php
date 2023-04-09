<?php

namespace app\controllers;

use app\models\extended\LkModel;
use app\models\extended\WriteModel;
use app\models\Role;
use app\models\Chat;
use app\models\SearchRole;
use Yii;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RoleController implements the CRUD actions for Role model.
 */
class LkController extends Controller
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
     * Lists all Role models.
     *
     * @return string
     */
    public function actionIndex()
    {
        $model = $this->findModel(Yii::$app->user->identity->getId());

        if ($this->request->isPost)
        {
            $model->moneyInfo->save($this->request->post());
            return $this->redirect(['lk/index', 'id' => Yii::$app->user->identity->getId()]);
        }

        return $this->render('index', [
            'model' => $model
        ]);
    }

    public function actionChat()
    {
        $model = new Chat();

        if ($this->request->isPost)
        {
            $result = $model->saveNew($this->request->post());
            return $this->redirect(['lk/single-chat', 'type' => $result["Chat"]["type"]]);
            //return $this->redirect(['lk/single-chat&type='. $query["Chat"]["type"] . '&user_id=' . $query["Chat"]["user_id"]]);
        }

        return $this->render('chat', [
            'model' => $model
        ]);
    }

    public function actionSingleChat($type)
    {
        $model = null;

        if ($type == 1)
            $model = Chat::find()->where(['user_out_id' => Yii::$app->user->identity])->all();
        else
            $model = Chat::find()->where(['user_in_id' => Yii::$app->user->identity])->all();

        return $this->render('single-chat', [
            'model' => $model
        ]);
    }

    public function actionWrite()
    {
        $model = new WriteModel();

        if ($this->request->isPost)
        {
            $model->save($this->request->post());
            return $this->redirect('lk/chat');
        }

        return $this->render('write', [
            'model' => $model
        ]);
    }


    /**
     * Finds the Role model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param int $id ID
     * @return Role the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        $model = new LkModel();
        $model->fill($id);

        return $model;
    }
}
