<?php

namespace App\Http\ViewComposers;

use Illuminate\Contracts\View\View;
use DB;
use Auth;
use Session;
class MenuViewComposer {

	public function compose(View $view) {
		$menu_list = $module_list = '';
		if(Auth::check()){

			$auth_id = Auth::id();
			$childMenus = $menu_ids = [];
			$menus = DB::select("select a.parent_menu_no_fk,a.menu_name, b.menu_no_pk, b.features_no_pk, b.features_code, b.features_name, b.page_url, b.sl_no
				from wsec_menutree a, wsec_menufeatures b, wsec_userfeaturesprivs c
				where a.menu_no_pk=b.menu_no_pk and b.features_no_pk=c.features_no_fk and a.status=1 and b.status=1 and c.status=1 and c.user_no_fk=$auth_id
				group by a.parent_menu_no_fk,a.menu_name,b.menu_no_pk, b.features_no_pk, b.features_code, b.features_name, b.page_url, b.sl_no
				order by  b.sl_no asc");

			if(!empty($menus))
			{
				foreach ($menus as $childMenu) {
					$childMenus[$childMenu->menu_no_pk][] = $childMenu;
					$menu_ids[$childMenu->menu_no_pk] = $childMenu->menu_no_pk;
					if($childMenu->parent_menu_no_fk>0)
						$menu_ids[] = $childMenu->parent_menu_no_fk;
				}
				if(!empty($menu_ids))
				{
					$menus = DB::select('select a.menu_no_pk, a.parent_menu_no_fk, a.menu_code, a.menu_icon,a.menu_name, c.menu_name parent_menu_name, c.menu_link, a.sl_no
						from wsec_menutree a
						left join wsec_menutree c on a.parent_menu_no_fk=c.menu_no_pk
						where a.status=1 and a.menu_no_pk in('.implode(",",$menu_ids).')
						group by a.menu_no_pk, a.parent_menu_no_fk, a.menu_code, a.menu_icon,a.menu_name,c.menu_name, c.menu_link, a.sl_no order by a.sl_no');

					$tree = self::menuTree($menus);
					$menu_list = self::generateSubMenu($tree, $childMenus);
					$module_list = self::generateMenu($menus);
				}
			}
			$view->with('module_list', $module_list)->with('menu_list', $menu_list);
		}
	}

	public static function menuTree($dataset, $parent = 0)
	{
		$tree = array();

		foreach ($dataset as $id => $node)
		{
			if ($node->parent_menu_no_fk != $parent) continue;
			$node->children = self::menuTree($dataset, $node->menu_no_pk);
			$tree[$id] = $node;
		}

		return $tree;
	}

	private static function generateMenu($dataset)
	{
		$data = '<div class="menu-icons"><div class="nav flex-column nav-pills" id="v-pills-tab" role="tablist" aria-orientation="vertical">';

		foreach ($dataset as $node)
		{
			if($node->parent_menu_no_fk == 0)
			{
				$data .= "<a class='main-menu active' id='v-pills-patient-tab' data-toggle='pill' href='#".$node->menu_code."' role='tab' aria-controls='v-pills-patient' aria-selected='true'><i class='".$node->menu_icon."'></i><div>".$node->menu_code."</div></a>";
			}
		}

		$data .= '</div></div>';

		return $data;
	}

	private static function generateSubMenu($tree, $childMenus, $parent_id='')
	{   
        $class_name = '';
        if (Session::get('user.ses_hospital_code') == 'UNICO') {
            $class_name = 'uhl-side-bar-menu';
        }

		if($parent_id == ""){
			$data = '<ul class="sidebar-menu '. $class_name.'" data-widget="tree">';
		}
		else{
			$data = '<ul class="treeview-menu" style="display: none;">';
		}

		foreach ($tree as $item)
		{
			$menu_id = $item->menu_no_pk;
			$child_menus = isset($childMenus[$menu_id])?$childMenus[$menu_id]:[];
			if(!empty($item->children) || !empty($child_menus))
			{
				$data .= '<li class="treeview" style="height: auto;"><a href="' . $item->menu_link . '"><i class="'.$item->menu_icon.'"></i> ' . $item->menu_name . '';

				$data .= '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
			}

			if(!empty($child_menus))
			{
				$data .= '<ul class="treeview-menu" style="display: none;">';
				foreach ($child_menus as $childMenu)
				{
					$page_route = ($childMenu->page_url =='#')?'#':route($childMenu->page_url);
					$data .= "<li><a href='".$page_route."' rel='tab'  onclick='setSession($item->menu_no_pk)'><i class='far fa-circle'></i> ".$childMenu->features_name."</a></li>";
				}
				$data .= '</ul>';
			}

			if (count($item->children) > 0)
			{
				$data .= self::generateSubMenu($item->children, $childMenus, $menu_id);
			}
			$data .= '</li>';
		}

		$data .= '</ul>';

		return $data;
	}
}
