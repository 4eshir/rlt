<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "confirm".
 *
 * @property int $id
 * @property string $name
 *
 * @property ProductUser[] $productUsers
 */
class Confirm extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'confirm';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 1000],
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
        ];
    }

    /**
     * Gets query for [[ProductUsers]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProductUsers()
    {
        return $this->hasMany(ProductUser::class, ['confirm_id' => 'id']);
    }
}
