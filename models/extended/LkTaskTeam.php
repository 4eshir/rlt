<?php

namespace app\models\extended;

use app\models\TeamUser;
use app\models\TaskUser;
use app\models\Task;

use app\models\StepUser;
use app\models\BusinessGame;


use Yii;

class LkTaskTeam extends \yii\base\Model
{
    public $teams; // командные работы сотрудника
    public $tasks; // проекты обучения сотрудника

    public function rules()
    {
        
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
    }

    public function fill($id)
    {
        $steps = StepUser::find()->where(['user_id' => $id])->all();
        $sId = [];
        foreach ($steps as $step)
            $sId[] = $step->step->business_game_id;


        $this->teams = BusinessGame::find()->where(['IN', 'id', $sId])->all();
        $tasks = TaskUser::find()->where(['user_id' => $id])->all();
        $tIds = [];
        foreach ($tasks as $task) $tIds[] = $task->task_id;
        $this->tasks = Task::find()->where(['IN', 'id', $tIds])->all();
    }
}
