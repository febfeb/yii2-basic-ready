<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "role_menu".
 *
 * @property integer $id
 * @property integer $role_id
 * @property integer $menu_id
 *
 * @property \app\models\Role $role
 * @property \app\models\Menu $menu
 */
class RoleMenu extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role_menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'menu_id'], 'required'],
            [['role_id', 'menu_id'], 'integer']
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'role_id' => 'Role ID',
            'menu_id' => 'Menu ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRole()
    {
        return $this->hasOne(\app\models\Role::className(), ['id' => 'role_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenu()
    {
        return $this->hasOne(\app\models\Menu::className(), ['id' => 'menu_id']);
    }




}
