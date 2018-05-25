<?php
namespace App\Services\Nav;

class MenuService 
{
    public function __construct()
    {
        $this->menu_roles = config('menurole');
        $this->menu_g     = config('menug');
        $this->smenus    = config('menugs');
    }
    
    private function getRoleMenus($roles)
    {
        $menu_roles = $this->menu_roles;
        $sub_menus_index = [];
        foreach ($roles as $role) {
            if (isset($menu_roles[$role])) {
                $sub_menus_index = array_merge($sub_menus_index, $menu_roles[$role]);
            }
        }
        return $sub_menus_index;
    }
    
    private function setGMenus($sub_menus_index)
    {
        
        $menu_g = $this->menu_g;
        
        if (in_array('*', $sub_menus_index, TRUE )) {
            return array_map(function($item){
                $item['subNavIndex'] = $item['subIndex'];
                unset($item['subIndex']);
                return $item;
            }, $menu_g);
        }
        
        $re = [];
        foreach ($menu_g as $item) {
            $item['subNavIndex'] = array_intersect($item['subIndex'], $sub_menus_index);
            unset($item['subIndex']);
            if (!empty($item['subNavIndex'])) {
                $re[] = $item;
            }
            
        }
        return $re;
    }
    
    private function setGsMenus($gMenus)
    {
        $smenus = $this->smenus;
        foreach ($gMenus as &$value) {
            $value['subNav'] = array_map(function($item)use($smenus){
                return isset($smenus[$item]) ? $smenus[$item] : new Object();
            }, $value['subNavIndex']);
                unset($value['subNavIndex']);
        }
        return  $gMenus;
    }
    
    public function getMenus($roles)
    {
        $roleMenus = $this->getRoleMenus($roles);
        $gMenus  = $this->setGMenus($roleMenus );
        $menus   = $this->setGsMenus($gMenus);
        return $menus;
    }
}