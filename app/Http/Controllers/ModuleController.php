<?php

namespace App\Http\Controllers;

use App\Models\Module;
use App\Library\Template;
use Illuminate\Http\Request;
use App\Traits\DatatablesLoader;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Session;
use App\Repositories\BaseRepository as Repo;

class ModuleController extends Controller
{
    use DatatablesLoader;
    protected $model;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Module $module)
    {
        $this->middleware('auth');

        $this->model = new Repo($module);
    }
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Template::loadview("admin.settings.module.module_list");
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return Template::loadview("admin.settings.module.create_module");
    }

    public function create_form()
    {
        return Template::loadview("admin.settings.module.create_module_form");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        //return $request;
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [
                'module_code' => $request->module_code,
                'module_name' => $request->module_name,
                'module_desc' => $request->module_desc,
                'status' => $request->module_status,
            ];

            if ($id == null) {
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_session'] = 'S0901';
                $data['au_entry_hospital_pk_no'] = $ses_hospital_id;
                //  return $data;
                $this->model->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $data = $this->model->show($id);
        return Template::loadView("admin.settings.module.create_module_form", ['module' => $data]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        //
    }

    public function getAllModule(Request $request)
    {
       // $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'module_code',
            'module_name',
            'module_desc',
            'module_no_pk',
        );

        $sql = "SELECT  '' as sl,module_code, module_name, module_desc,module_no_pk, rownum rownumber, au_update_at,au_entry_at from sysc_module";
        $order_by_column = "module_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);

        echo json_encode($json_data);
    }

    public function getUserModuleMenu(Request $request)
    {
        $menu_list = "";
        $menu_id = $request->menu_id;
        $auth_id = Auth::id();
        $menus = DB::select("select a.parent_menu_no_fk,a.menu_name, b.menu_no_pk, b.features_no_pk, b.features_code, b.features_name, b.page_url, b.sl_no,a.menu_link, a.menu_icon
    		from wsec_menutree a, wsec_menufeatures b, wsec_userfeaturesprivs c
    		where a.menu_no_pk=b.menu_no_pk and b.features_no_pk=c.features_no_fk and a.status=1 and b.status=1 and c.status=1 and c.user_no_fk=$auth_id  and a.menu_no_pk=$menu_id
    		group by a.parent_menu_no_fk,a.menu_name,b.menu_no_pk, b.features_no_pk, b.features_code, b.features_name, b.page_url, b.sl_no,a.menu_link, a.menu_icon
    		order by  b.sl_no asc");

        if (!empty($menus)) {
            foreach ($menus as $childMenu) {
                $childMenus[$childMenu->menu_no_pk][] = $childMenu;
                $menu_ids[$childMenu->menu_no_pk] = $childMenu->menu_no_pk;
                if ($childMenu->parent_menu_no_fk > 0)
                    $menu_ids[] = $childMenu->parent_menu_no_fk;
            }

            if (!empty($menu_ids)) {
                $menus = DB::select('select a.menu_no_pk, a.parent_menu_no_fk, a.menu_code, a.menu_icon,a.menu_name, c.menu_name parent_menu_name, c.menu_link, a.sl_no
    				from wsec_menutree a
    				left join wsec_menutree c on a.parent_menu_no_fk=c.menu_no_pk
    				where a.status=1 and a.menu_no_pk in(' . implode(",", $menu_ids) . ')
    				group by a.menu_no_pk, a.parent_menu_no_fk, a.menu_code, a.menu_icon,a.menu_name,c.menu_name, c.menu_link, a.sl_no order by a.sl_no');

                $tree = self::menuTree($menus);
                $menu_list = self::generateSubMenu($tree, $childMenus);
            }

            //$tree = self::menuTree($menus);
            //$menu_list = self::generateSubMenu($tree, $childMenus);
        }
        //dd($tree);
        return $menu_list;
    }

    public static function menuTree($dataset, $parent = 0)
    {
        $tree = array();

        foreach ($dataset as $id => $node) {
            if ($node->parent_menu_no_fk != $parent) continue;
            $node->children = self::menuTree($dataset, $node->menu_no_pk);
            $tree[$id] = $node;
        }

        return $tree;
    }

    private static function generateSubMenu($tree, $childMenus, $parent_id = '')
    {



        if ($parent_id == "") {
            $data = '<ul class="sidebar-menu tree" data-widget="tree">';
        } else {
            $data = '<ul class="treeview-menu" style="display:none">';
        }
        //dd($tree);
        foreach ($tree as $item) {
            $menu_id = $item->menu_no_pk;
            $child_menus = isset($childMenus[$menu_id]) ? $childMenus[$menu_id] : [];
            /*echo "<pre>";
    		print_r($child_menus);
    		echo "</pre>";*/
            if (!empty($child_menus)) {
                //$page_route = ($item->page_url =='#')?'#':route($item->page_url);
                //$data .= '<li class="treeview" style="height: auto;"><a href="' . $page_route . '" rel="tab"><i class="'.$item->menu_icon.'"></i> ' . $item->features_name . '';
                $data .= '<li class="treeview" style="height: auto;"><a href="' . $item->menu_link . '"><i class="' . $item->menu_icon . '"></i> ' . $item->menu_name . '';
                $data .= '<span class="pull-right-container"><i class="fa fa-angle-left pull-right"></i></span></a>';
            }

            if (!empty($child_menus)) {
                $data .= '<ul class="treeview-menu" style="display:none">';
                foreach ($child_menus as $childMenu) {
                    $page_route = ($childMenu->page_url == '#') ? '#' : route($childMenu->page_url);
                    $data .= "<li><a href='" . $page_route . "' rel='tab'><i class='far fa-circle'></i> " . $childMenu->features_name . "</a></li>";
                }
                $data .= '</ul>';
            }

            if (count($item->children) > 0) {
                $data .= self::generateSubMenu($item->children, $childMenus, $menu_id);
            }
            $data .= '</li>';
        }

        $data .= '</ul>';

        return $data;
    }
}
