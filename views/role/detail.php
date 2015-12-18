<?php

use yii\helpers\Html;
use \yii\bootstrap\ActiveForm;

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
        class RoleClass {
            public static $role_id;
        }

        RoleClass::$role_id = $model->id;

        function isChecked($menu_id){

            $role_menu = \app\models\RoleMenu::find()->where(["menu_id"=>$menu_id, "role_id"=>RoleClass::$role_id])->one();
            if($role_menu){
                return TRUE;
            }
            return FALSE;
        }

        function getAllChild($parent_id, $level = 0){
            foreach(\app\models\Menu::find()->where(["parent_id"=>$parent_id])->all() as $menu){
                ?>
                    <div class="form-group" style="padding-left: <?= $level * 20 ?>px">
                        <label>
                            <input type="checkbox" name="menu[]" value="<?= $menu->id ?>" class="minimal" <?= isChecked($menu->id) ? "checked" : "" ?>>
                        </label>
                        <label style="padding-left: 10px"> <?= $menu->name; ?></label>
                    </div>
                <?php
                getAllChild($menu->id, $level + 1);
            }
        }

        getAllChild(NULL);
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

'); ?>
