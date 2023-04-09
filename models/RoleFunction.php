<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role_function".
 *
 * @property int $id
 * @property string $name
 *
 * @property RoleFunctionRole[] $roleFunctionRoles
 */
class RoleFunction extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role_function';
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
     * Gets query for [[RoleFunctionRoles]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoleFunctionRoles()
    {
        return $this->hasMany(RoleFunctionRole::class, ['role_function_id' => 'id']);
    }
}
