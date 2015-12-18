<?php

namespace app\models\base;

use Yii;

/**
 * This is the base-model class for table "role_action".
 *
 * @property integer $id
 * @property integer $role_id
 * @property integer $action_id
 *
 * @property \app\models\Role $role
 * @property \app\models\Action $action
 */
class RoleAction extends \yii\db\ActiveRecord
{



    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'role_action';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['role_id', 'action_id'], 'required'],
            [['role_id', 'action_id'], 'integer']
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
            'action_id' => 'Action ID',
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
    public function getAction()
    {
        return $this->hasOne(\app\models\Action::className(), ['id' => 'action_id']);
    }




}
