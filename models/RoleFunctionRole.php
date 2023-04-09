<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "role_function_role".
 *
 * @property int $id
 * @property int $role_id
 * @property int $role_function_id
 *
 * @property Role $role
 * @property RoleFunction $roleFunction
 */
class RoleFunctionRole extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'role_function_role';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['role_id', 'role_function_id'], 'required'],
            [['role_id', 'role_function_id'], 'integer'],
            [['role_function_id'], 'exist', 'skipOnError' => true, 'targetClass' => RoleFunction::class, 'targetAttribute' => ['role_function_id' => 'id']],
            [['role_id'], 'exist', 'skipOnError' => true, 'targetClass' => Role::class, 'targetAttribute' => ['role_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'role_function_id' => 'Role Function ID',
        ];
    }

    /**
     * Gets query for [[Role]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(Role::class, ['id' => 'role_id']);
    }

    /**
     * Gets query for [[RoleFunction]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getRoleFunction()
    {
        return $this->hasOne(RoleFunction::class, ['id' => 'role_function_id']);
    }
}
