<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "action".
 *
 * @property integer $id
 * @property string $controller_id
 * @property string $action_id
 * @property string $name
 *
 * @property \app\models\RoleAction[] $roleActions
 */
class Action extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'action';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['controller_id', 'action_id', 'name'], 'required'],
            [['controller_id', 'action_id', 'name'], 'string', 'max' => 50]
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'controller_id' => 'Controller ID',
            'action_id' => 'Action ID',
            'name' => 'Name',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getRoleActions()
    {
        return $this->hasMany(\app\models\RoleAction::className(), ['action_id' => 'id']);
    }




}
