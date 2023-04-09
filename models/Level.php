<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "level".
 *
 * @property int $id
 * @property int $name
 * @property int $experience_count
 *
 * @property Achievment[] $achievments
 */
class Level extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'level';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'experience_count'], 'required'],
            [['name', 'experience_count'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'experience_count' => 'Experience Count',
        ];
    }

    /**
     * Gets query for [[Achievments]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getAchievments()
    {
        return $this->hasMany(Achievment::class, ['level_id' => 'id']);
    }
}
