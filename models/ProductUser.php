<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "product_user".
 *
 * @property int $id
 * @property int $product_id
 * @property int $user_id
 * @property string $date
 *
 * @property Product $product
 * @property User $user
 * @property Confirm $confirm_id
 */
class ProductUser extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'product_user';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['product_id', 'user_id', 'date'], 'required'],
            [['product_id', 'user_id', 'confirm_id'], 'integer'],
            [['date'], 'safe'],
            [['product_id'], 'exist', 'skipOnError' => true, 'targetClass' => Product::class, 'targetAttribute' => ['product_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::class, 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'product_id' => 'Product ID',
            'user_id' => 'User ID',
            'date' => 'Date',
            'confirm_id' => 'Confirm',
        ];
    }

    /**
     * Gets query for [[Product]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getProduct()
    {
        return $this->hasOne(Product::class, ['id' => 'product_id']);
    }

    /**
     * Gets query for [[User]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::class, ['id' => 'user_id']);
    }

    /**
     * Gets query for [[Confirm]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getConfirm()
    {
        return $this->hasOne(Confirm::class, ['id' => 'confirm_id']);
    }
}
