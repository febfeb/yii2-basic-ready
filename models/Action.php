<?php

namespace app\models;

use Yii;
use \app\models\base\Action as BaseAction;

/**
 * This is the model class for table "action".
 */
class Action extends BaseAction
{
    public static function getAccess($controllerId){
        $rules = [];
        if($controllerId == "site"){
            $rules[] = [
                'actions' => ['login', 'register', 'error', 'logout'],
                'allow' => true,
            ];
        }

        if(\Yii::$app->user->identity != NULL) {
            $allowed = Action::getAllowedAction($controllerId, \Yii::$app->user->identity->role_id);
            if(count($allowed) != 0) {
                $rules[] = [
                    'actions' => $allowed,
                    'allow' => true,
                    'roles' => ['@'],
                ];
            }
        }

        $rules[] = [
            'allow' => false,
        ];

        return [
            'as beforeRequest' => [
                'class' => 'yii\filters\AccessControl',
                'rules' => $rules,
            ],
        ];
    }

    public static function getAllowedAction($controllerId, $role_id){
        //TODO: Using cache to speed process
        $output = [];
        foreach(Action::find()->where(["controller_id"=>$controllerId])->all() as $action){
            //bypass for super admin
            if($role_id == 1){
                $output[] = $action->action_id;
            }else {
                $roleAction = RoleAction::find()->where(["action_id" => $action->id, "role_id" => $role_id])->one();
                if ($roleAction) {
                    $output[] = $action->action_id;
                }
            }
        }
        return $output;
    }
}
