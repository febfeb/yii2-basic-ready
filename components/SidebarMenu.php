<?php

namespace app\components;

use yii\bootstrap\Widget;
use yii\helpers\Html;
use yii\helpers\Url;
use app\models\Menu;

class SidebarMenu extends Widget
{
    public $roleId;
    public $headerTitle = "NAVIGATION OKE";

    public function init()
    {
        parent::init();
    }

    public function run()
    {
        parent::run();
        $items = [
            Html::tag("li", $this->headerTitle, ["class"=>"header"])
        ];

        foreach($this->getTopMenu() as $item){
            $items[] = $item;
        }

        return Html::ul($items, ["class"=>"sidebar-menu", "encode"=>FALSE]);
    }

    private function getTopMenu(){
        $output = [];
        foreach(Menu::find()->where(["parent_id"=>NULL])->all() as $menu){
            if($this->hasAccess($menu->id)) {
                $childMenu = $this->getChildMenu($menu->id);
                $liClass = "treeview".($childMenu["isActive"] || $this->isActive($menu)?" active":"");
                $label = "<i class='".$menu->icon."'></i> <span>".$menu->name . "</span>";
                if ($childMenu["output"]) {
                    $label .= "<i class='fa fa-angle-left pull-right'></i>";
                }
                $li = Html::tag("li", Html::a($label, $this->getUrl($menu)).$childMenu["output"], ["class"=>$liClass]);
                $output[] = $li;
            }
        }
        return $output;
    }

    private function getChildMenu($parent_id){
        $items = [];

        $thereIsActive = FALSE;
        $menus = Menu::find()->where(["parent_id"=>$parent_id])->all();
        foreach($menus as $menu){
            if($this->hasAccess($menu->id)) {
                if ($this->isActive($menu)) {
                    $thereIsActive = TRUE;
                }
                $icon = "<i class=\"fa fa-circle-o\"></i> ";
                $items[] = Html::tag("li", Html::a($icon . $menu->name, $this->getUrl($menu)), ["class"=>($this->isActive($menu) ? "active" : "")]);
            }
        }
        if(count($menus) == 0){
            return [
                "isActive" => FALSE,
                "output" => ""
            ];
        }

        return [
            "isActive" => $thereIsActive,
            "output" => Html::ul($items, ["class"=>"treeview-menu", "encode"=>FALSE])
        ];
    }

    /**
     * @param $menuId
     * @return bool
     */
    private function hasAccess($menuId){
        $roleMenu = \app\models\RoleMenu::find()->where(["menu_id"=>$menuId, "role_id"=>$this->roleId])->one();
        if($roleMenu){
            return TRUE;
        }else{
            return FALSE;
        }
    }

    /**
     * @param $menu
     * @return string
     */
    private function getUrl($menu){
        if($menu->controller == NULL){
            return "#";
        }else{
            return Url::to([$menu->controller."/".$menu->action]);
        }
    }

    /**
     * @param $menu
     * @return bool
     */
    private function isActive($menu){
        if(\Yii::$app->controller->id == $menu->controller){
            return TRUE;
        }
        return FALSE;
    }
}