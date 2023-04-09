<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "step".
 *
 * @property int $id
 * @property string $name
 * @property string $description
 * @property int $price
 * @property int $price_type
 * @property int $business_game_id
 *
 * @property BusinessGame $businessGame
 * @property StepUser[] $stepUsers
 */
class Step extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'step';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'description', 'price', 'price_type', 'business_game_id'], 'required'],
            [['price', 'price_type', 'business_game_id'], 'integer'],
            [['name', 'description'], 'string', 'max' => 1000],
            [['business_game_id'], 'exist', 'skipOnError' => true, 'targetClass' => BusinessGame::class, 'targetAttribute' => ['business_game_id' => 'id']],
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
            'description' => 'Description',
            'price' => 'Price',
            'price_type' => 'Price Type',
            'business_game_id' => 'Business Game ID',
        ];
    }

    /**
     * Gets query for [[BusinessGame]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getBusinessGame()
    {
        return $this->hasOne(BusinessGame::class, ['id' => 'business_game_id']);
    }

    /**
     * Gets query for [[StepUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getStepUsers()
    {
        return $this->hasMany(StepUser::class, ['step_id' => 'id']);
    }
}
