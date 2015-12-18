<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "role".
 *
 * @property integer $id
 * @property string $name
 *
 * @property \app\models\RoleMenu[] $roleMenus
 * @property \app\models\User[] $users
 */
class Role extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleMenus()
    {
        return $this->hasMany(\app\models\RoleMenu::className(), ['role_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUsers()
    {
        return $this->hasMany(\app\models\User::className(), ['role_id' => 'id']);
    }




}
