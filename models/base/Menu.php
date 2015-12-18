<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "menu".
 *
 * @property integer $id
 * @property string $name
 * @property string $controller
 * @property string $action
 * @property string $icon
 * @property integer $order
 * @property integer $parent_id
 *
 * @property \app\models\Menu $parent
 * @property \app\models\Menu[] $menus
 * @property \app\models\RoleMenu[] $roleMenus
 */
class Menu extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'menu';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'controller', 'icon'], 'required'],
            [['order', 'parent_id'], 'integer'],
            [['name', 'controller', 'action', 'icon'], 'string', 'max' => 50]
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
            'controller' => 'Controller',
            'action' => 'Action',
            'icon' => 'Icon',
            'order' => 'Order',
            'parent_id' => 'Parent ID',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getParent()
    {
        return $this->hasOne(\app\models\Menu::className(), ['id' => 'parent_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getMenus()
    {
        return $this->hasMany(\app\models\Menu::className(), ['parent_id' => 'id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleMenus()
    {
        return $this->hasMany(\app\models\RoleMenu::className(), ['menu_id' => 'id']);
    }




}
