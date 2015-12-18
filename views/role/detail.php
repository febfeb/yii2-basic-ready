<?php

use yii\helpers\Html;
use \yii\base\Module;
use \yii\bootstrap\ActiveForm;
use \yii\helpers\Inflector;

/**
 * @var yii\web\View $this
 * @var app\models\Role $model
 */

$this->title = 'Role ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'Roles', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => "Set Menu untuk ".$model->name, 'url' => ['view', 'id' => $model->id]];
?>
<?php $form = ActiveForm::begin(['id' => 'my-form']); ?>
<div class="box box-success">
    <div class="box-header">
        <h3 class="box-title">Choose Menu for Role <?= $model->name; ?></h3>
    </div>
    <div class="box-body">
        <?php
        function isChecked($role_id, $menu_id){

            $role_menu = \app\models\RoleMenu::find()->where(["menu_id"=>$menu_id, "role_id"=>$role_id])->one();
            if($role_menu){
                return TRUE;
            }
            return FALSE;
        }

        function hasAccessToAction($role_id, $action_id){
            $role_menu = \app\models\RoleAction::find()->where(["action_id"=>$action_id, "role_id"=>$role_id])->one();
            if($role_menu){
                return TRUE;
            }
            return FALSE;
        }

        function showCheckbox($name, $value, $label, $checked = FALSE){
            ?>
            <label>
                <input type="checkbox" name="<?= $name ?>" value="<?= $value ?>" class="minimal actions" <?= $checked ? "checked" : "" ?>>
            </label>
            <label style="padding: 0px 20px 0px 5px"> <?= $label; ?></label>
            <?php
        }

        function getAllChild($role_id, $parent_id=NULL, $level = 0){
            foreach(\app\models\Menu::find()->where(["parent_id"=>$parent_id])->all() as $menu){
                ?>
                    <div class="form-group" style="padding-left: <?= $level * 20 ?>px">
                        <label>
                            <input type="checkbox" name="menu[]" value="<?= $menu->id ?>" class="minimal" <?= isChecked($role_id, $menu->id) ? "checked" : "" ?>>
                        </label>
                        <label style="padding-left: 10px"> <?= $menu->name; ?></label>
                    </div>
                <?php

                //Show All Actions
                $camelName = Inflector::id2camel($menu->controller);
                $fullControllerName = "app\\controllers\\".$camelName."Controller";
                if(class_exists($fullControllerName)){
                    $reflection = new ReflectionClass($fullControllerName);
                    $methods = $reflection->getMethods();

                    echo "<div class=\"form-group\" style=\"padding-left: ".($level * 20 + 10)."px;\">";
                    echo "<label><input type=\"checkbox\" class=\"minimal select-all\" ></label><label style=\"padding: 0px 20px 0px 5px\"> Select All</label>";
                    foreach($methods as $method){
                        if(substr($method->name, 0, 6) == "action" && $method->name != "actions"){
                            $camelAction = substr($method->name, 6);
                            $id = Inflector::camel2id($camelAction);
                            $name = Inflector::camel2words($camelAction);
                            $action = \app\models\Action::find()->where(["action_id"=>$id, "controller_id"=>$menu->controller])->one();
                            if($action == NULL){
                                //If the action not in database, save it !
                                $action = new \app\models\Action();
                                $action->action_id = $id;
                                $action->controller_id = $menu->controller;
                                $action->name = $name;
                                $action->save();
                            }
                            showCheckbox("action[]", $action->id, $name, hasAccessToAction($role_id, $action->id));
                        }
                    }
                    echo "</div>";
                }

                getAllChild($role_id, $menu->id, $level + 1);
            }
        }

        getAllChild($model->id, NULL);
        ?>

    </div>
    <div class="box-footer">
        <button class="btn btn-info" type="button" id="select_all_btn">
            <i class="fa fa-check"></i> Select/Deselect All
        </button>
        <button class="btn btn-success" type="submit">
            <i class="fa fa-save"></i> Save
        </button>
    </div>
</div>
<?php ActiveForm::end(); ?>

<?php $this->registerJs('

$("#select_all_btn").click(function(){
    $(".minimal").iCheck("toggle");
});

$(".select-all").on("ifClicked", function(){

    if($(this).prop("checked")){
        $(this).closest(".form-group").find(".actions").iCheck("uncheck");
    }else{
        $(this).closest(".form-group").find(".actions").iCheck("check");
    }
});

'); ?>
