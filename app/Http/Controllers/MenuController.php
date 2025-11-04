<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Http\Requests\MenuRequest;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use App\Repositories\BaseRepository as Repo;
use Illuminate\Support\Facades\DB;
use App\Models\Menu;
use Auth;;

use App\Http\Requests\MenuFeaturesRequest;
use App\Http\Requests\MenuPrivilegeRequest;
use App\Models\MenuFeature;
use App\Models\MenuPrivilege;
use App\Models\RolePrivilege;
use App\Models\UserRoles;
use App\Models\ServiceUnit;
use Session;




class MenuController extends Controller
{

    use DatatablesLoader;
    protected $model, $model2, $model3, $model4, $model5;
    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(Menu $menu, MenuFeature $MenuFeature, MenuPrivilege $MenuPrivilege, UserRoles $UserRole, RolePrivilege $RolePrivilege)
    {
        $this->middleware('auth');

        $this->model = new Repo($menu);
        $this->model2 = new Repo($MenuFeature);
        $this->model3 = new Repo($MenuPrivilege);
        $this->model4 = new Repo($UserRole);
        $this->model5 = new Repo($RolePrivilege);
    }


    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        return Template::loadview("admin.menu.menu_list");
    }



    public function create()
    {
        $parent_menu = DB::table('wsec_menutree')->select('menu_no_pk', 'menu_name')->where('parent_menu_no_fk', '=', '0')->get();

        return Template::loadview("admin.menu.create_menu", ['parent_menu' => $parent_menu]);
    }

    public function getAllMenus(Request $request)
    {

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'menu_code',
            'menu_name',
            'sl_no',
            'menu_link',
            'menu_icon',
            'status',
            'menu_no_pk'
        );

        $sql = "SELECT '' as sl,  menu_code, menu_name, sl_no,menu_link,menu_icon, case when status=1 then 'Active' else 'Inactive' end as status, menu_no_pk, rownum rownumber, au_update_at, au_entry_at FROM wsec_menutree";
        // where au_entry_hospital_pk_no = $ses_hospital_id
        // $sql = "select '' as sl, a.menu_code,a.parent_menu_no_fk,a.menu_name,a.menu_name_nls,a.sl_no, a.menu_link,a.menu_icon, case when a.status=1 then 'Active' else 'Inactive' end as status, a.menu_no_pk, rownum rownumber,a.au_update_at,a.au_entry_at from wsec_menutree a left join wsec_menutree pm on pm.menu_no_pk = a.parent_menu_no_fk";
        $order_by_column = "menu_no_pk";


        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);


        echo json_encode($json_data);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function create_form()
    {
        $parent_menu = DB::table('wsec_menutree')->select('menu_no_pk', 'menu_name')->where('parent_menu_no_fk', '=', '0')->get();
        return Template::loadview("admin.menu.create_menu_form", ['parent_menu' => $parent_menu]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */



    public function store(MenuRequest $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $id = $request->id;
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $data = [
                'menu_code'          => $request->menu_id,
                'parent_menu_no_fk'  => $request->parent_menu,
                'menu_name'          => $request->menu_name,
                'menu_name_nls'      => $request->menu_name_nis,
                'sl_no'              => $request->serial_number,
                'menu_link'          => $request->page_link,
                'menu_icon'          => $request->menu_icon,
                'status'             => $request->menu_status ? 1 : 0,
                'au_entry_hospital_pk_no' => $ses_hospital_id
            ];

            if ($id == null) {
                $data['au_entry_by'] = $auth_id;

                $response = $this->model->create($data);
                $last_id  = $response->menu_no_pk;
            } else {
                $data['au_update_by'] = $auth_id;
                $this->model->update($data, $id);
                $last_id = $id;
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $last_id];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
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
        $parent_menu = DB::table('wsec_menutree')->select('menu_no_pk', 'menu_name')->where('parent_menu_no_fk', '=', '0')->get();

        return Template::loadView("admin.menu.create_menu_form", ['data' => $data, 'parent_menu' => $parent_menu]);
    }



    //menu feature ...
    public function getTable()
    {

        return Template::loadview("admin.menu.menu_list_feature");
    }
    public function create_feature_form()
    {
        $parent_menu = DB::table('wsec_menutree')->select('menu_no_pk', 'menu_name')->orderBy('menu_name', 'asc')->get();
        // $menuFeature=MenuFeature::where('status', '1')->get();
        // dd($menuFeature);
        return Template::loadview("admin.menu.create_menu_feature_form", ['parent_menu' => $parent_menu]);
    }



    public function storeMenuFeature(MenuFeaturesRequest $request)
    {

        // $menu=explode("_",$request->module_menu);
        $id = $request->id;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            $data = [
                'menu_no_pk'          => $request->module_menu,
                'features_code'       => $request->Features_id,
                'features_name'       => $request->features_name,
                'sl_no'              => $request->serial_number,
                'page_url'          => $request->page_link,
                'status'             => $request->status ? 1 : null,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];

            if ($id == null) {
                $data['au_entry_by'] = $auth_id;

                $response = $this->model2->create($data);
                $last_id  = $response->features_no_pk;
            } else {
                $data['au_update_by'] = $auth_id;
                $this->model2->update($data, $id);
                $last_id = $id;
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $last_id];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }


    public function getAllMenuFeture(Request $request)
    {

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'module',
            'features_code',
            'features_name',
            'sl_no',
            'page_url',
            'features_no_pk'
        );


        $sql = "select '' as sl, module, features_code,features_name, sl_no,page_url, features_no_pk, rownum rownumber, au_update_at,au_entry_at  from MENU_FEATURE_VW ";
        // where AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id
        $order_by_column = "features_no_pk";


        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);


        echo json_encode($json_data);
    }



    public function create_feature_editForm($id)
    {
        $menuFeature = $this->model2->show($id);
        $parent_menu = DB::table('wsec_menutree')->select('menu_no_pk', 'menu_name')->where('status', '=', '1')->orderBy('menu_name', 'asc')->get();

        // dd($menuFeature);
        return Template::loadview("admin.menu.create_menu_feature_form", ['parent_menu' => $parent_menu, 'menuFeature' => $menuFeature]);
    }

    //menu privilege..


    public function create_privilege_form()
    {
        $users = DB::table('wsec_user')->get();
        $role = DB::table('wsec_role')->get();
        $module = DB::table('WSEC_MENUTREE')->where('status', '=', 1)->get();
        $features = DB::table('wsec_menufeatures')->leftJoin('wsec_menutree', function ($join) {
            $join->on('wsec_menutree.menu_no_pk', '=', 'wsec_menufeatures.menu_no_pk');
        })->get();

        $menu_feature = [];
        if (!empty($features)) {
            foreach ($features as $app) {
                $menu_feature[$app->menu_no_pk][$app->features_no_pk] = $app->menu_name . '_' . $app->features_name;
            }
        }

        return Template::loadview("admin.menu.create_menu_privilege_form", ['users' => $users,  'module' => $module, 'role' => $role, 'menu_feature' => $menu_feature]);
    }


    public function storeMenuPrivilege(Request $request)
    {
        // $menu=explode("_",$request->menu_name);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $feature = $request->menu_name;

        $id = $request->id;
        $auth_id = Auth::id();

        DB::beginTransaction();
        // dd( $request->user_name);
        try {
            DB::table('wsec_userfeaturesprivs')->where('user_no_fk', $request->user_name)->delete();
            for ($i = 0; $i < sizeof($feature); $i++) {
                $feature_menu = explode("_", $feature[$i]);
                $data = [
                    'user_no_fk'            => $request->user_name,
                    'features_no_fk'        => $feature_menu[0],
                    'role_no_fk'            => $request->role_name,
                    'grant_dt'              => date('Y/m/d', strtotime($request->grant_date)),
                    'menu_no_fk'            => $feature_menu[1],
                    'status'                =>  1,
                    'au_entry_by'           => $auth_id,
                    'AU_ENTRY_HOSPITAL_PK_NO'           => $po_hospital_details,

                ];
                // dd($data);
                $response = $this->model3->create($data);
            }

            // dd($data);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }




    public function getPrivilegeTable()
    {
        $id = '';
        // $service_unit = ServiceUnit::where('status', '1')->select('su_no_pk', 'su_name', 'su_uid')->orderBy("su_name", "asc")->get();
        $hospital = DB::table("wsec_hospital")->select("hospital_no_pk", "hospital_name")->orderBy("hospital_name", "asc")->where("status", 1)->get();

        $ses_hospital_id = Session::get('user.ses_hospital_id');

        $users = DB::table('wsec_user')->where('au_entry_hospital_pk_no', $ses_hospital_id)->get();
        //dd($users);
        $role = DB::table('wsec_role')->where('au_entry_hospital_pk_no', $ses_hospital_id)->orderBy('role_name')->get();
        $module = DB::table('WSEC_MENUTREE')->where('status', '=', 1)->where('au_entry_hospital_pk_no', $ses_hospital_id)->get();
        $features = DB::table('wsec_menufeatures')->leftJoin('wsec_menutree', function ($join) {
            $join->on('wsec_menutree.menu_no_pk', '=', 'wsec_menufeatures.menu_no_pk');
        })->get();

        $menu_feature = [];
        if (!empty($features)) {
            foreach ($features as $app) {
                $menu_feature[$app->menu_no_pk][$app->features_no_pk] = $app->menu_name . '_' . $app->features_name;
            }
        }

        return Template::loadview("admin.menu.menu_privilege_list", [
            'role' => $role,
            'users' => $users,
            'module' => $module,
            'menu_feature' => $menu_feature,
            // 'service_unit' => $service_unit,
            'hospital' => $hospital,
            'user_id' => $id
        ]);
    }

    public function menuPrivilegeEmpSearch(Request $request)
    {

        // dd($request->su_name);
        $hospital = $request->hospital_name;
        // $su_name= $request->su_name;

        $hospital_con = ($hospital != "") ? " and u.au_entry_hospital_pk_no =  $hospital" : "";
        // $su_name_con= ($su_name != "") ? " and p.serviceunit_no_fk = $su_name" : "" ;

        $sql = DB::select("SELECT u.user_fullname full_name  ,u.user_no_pk, u.user_code FROM wsec_user u where u.status=1 $hospital_con ");
        // left Join sys_personnel p on p.person_no_pk = u.person_no_fk

        return Template::loadview("admin.menu.menu_privilege_emp_list", ['emp_info' => $sql]);
    }

    public function menuPrivilegeEmpInfo(Request $request)
    {

        // dd($request->emp_hidden);
        $id = $request->emp_hidden;

        $features = DB::table('wsec_menufeatures')->leftJoin('wsec_menutree', function ($join) {
            $join->on('wsec_menutree.menu_no_pk', '=', 'wsec_menufeatures.menu_no_pk');
        })->get();

        $menu_feature = [];
        if (!empty($features)) {
            foreach ($features as $app) {
                $menu_feature[$app->menu_no_pk][$app->features_no_pk] = $app->menu_name . '_' . $app->features_name;
            }
        }

        $role_feature_data = DB::table('wsec_userfeaturesprivs')
            ->leftJoin('wsec_menufeatures', 'wsec_menufeatures.features_no_pk', '=', 'wsec_userfeaturesprivs.features_no_fk')
            ->leftJoin('wsec_menutree', 'wsec_menutree.menu_no_pk', '=', 'wsec_userfeaturesprivs.menu_no_fk')
            ->where('user_no_fk', '=', $id)->get();

        $features = [];
        $grant_date = '';
        if (!empty($role_feature_data)) {
            foreach ($role_feature_data as $feadrop) {
                $grant_date = $feadrop->grant_dt;
                $features[$feadrop->features_no_fk] = $feadrop->features_no_fk;
            }
        }

        $users = DB::table('wsec_user')->where('user_no_pk', $id)->get();
        $role = DB::table('wsec_role')->get();


        $doctor_info = DB::table('wsec_user u')->select('u.user_no_pk')->where('u.user_no_pk', $id)->first();

        // DB::select("SELECT u.user_fullname full_name , p.photo_name ,p.person_no_pk FROM wsec_user u left Join sys_personnel p on p.person_no_pk = u.person_no_fk where u.status=1 $hospital_con $su_name_con");


        // dd($menu_feature);

        return Template::loadview("admin.menu.menu_privilege_emp_info", ['users' => $users, 'features' => $features, 'role' => $role, "menu_feature" => $menu_feature, "grant_date" => $grant_date, 'doctor_info' => $doctor_info, 'user_id' => $id]);
    }




    public function create_privilege_editForm($id)
    {
        $features = DB::table('wsec_menufeatures')->leftJoin('wsec_menutree', function ($join) {
            $join->on('wsec_menutree.menu_no_pk', '=', 'wsec_menufeatures.menu_no_pk');
        })->get();

        $menu_feature = [];
        if (!empty($features)) {
            foreach ($features as $app) {
                $menu_feature[$app->menu_no_pk][$app->features_no_pk] = $app->menu_name . '_' . $app->features_name;
            }
        }

        $role_feature_data = DB::table('wsec_userfeaturesprivs')
            ->leftJoin('wsec_menufeatures', 'wsec_menufeatures.features_no_pk', '=', 'wsec_userfeaturesprivs.features_no_fk')
            ->leftJoin('wsec_menutree', 'wsec_menutree.menu_no_pk', '=', 'wsec_userfeaturesprivs.menu_no_fk')
            ->where('user_no_fk', '=', $id)->get();

        $features = [];
        $grant_date = '';
        if (!empty($role_feature_data)) {
            foreach ($role_feature_data as $feadrop) {
                $grant_date = $feadrop->grant_dt;
                $features[$feadrop->features_no_fk] = $feadrop->features_no_fk;
            }
        }

        $users = DB::table('wsec_user')->where('user_no_pk', $id)->get();
        $role = DB::table('wsec_role')->get();

        $view = Template::loadview("admin.menu.create_menu_privilege_form", ['users' => $users, 'features' => $features, 'role' => $role, 'menu_feature' => $menu_feature, "grant_date" => $grant_date]);
        // return $feature ;
        return  $view;
    }




    //role...


    public function createRole()
    {
        return Template::loadview("admin.menu.create_role_user");
    }
    public function createRoleForm()
    {

        return Template::loadview("admin.menu.create_role_form");
    }
    public function getRole()
    {

        return Template::loadview("admin.menu.role_list");
    }

    public function roleStore(Request $Request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $id = $Request->id;
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $data = [
                'role_name'  => $Request->role_name,
                'role_desc'  => $Request->desc_name,
                'status'     => $Request->status ? 1 : 0,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];
            // dd($data);
            if ($id == "") {
                $data['au_entry_by'] = $auth_id;
                $this->model4->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->model4->update($data, $id);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }


    public function getAllRole(Request $request)
    {

        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $columns = array(
            'sl',
            'role_name',
            'role_desc',
            'status',
            'role_no_pk'
        );


        $sql = "select '' as sl, role_name, role_desc,status, role_no_pk, rownum rownumber, au_update_at,au_entry_at  from WSEC_ROLE  where AU_ENTRY_HOSPITAL_PK_NO = $ses_hospital_id ";
        $order_by_column = "role_no_pk";


        $json_data = $this->datatable($request, $sql, $order_by_column, 'ASC', $columns);


        echo json_encode($json_data);
    }

    public function create_role_editForm($id)
    {
        $role = $this->model4->show($id);

        return Template::loadview("admin.menu.create_role_form", ['role' => $role]);
    }

    public function createUserRoleForm($id)
    {
        $roleid = $id;
        // dd($roleid);
        $users = DB::table('wsec_user')->get();

        // $features = DB::table('WSEC_MENUFEATURES')->where('status', '=', 1)->get();
        $module = DB::table('WSEC_MENUTREE')->where('status', '=', 1)->get();
        // dd($features );

        $features = DB::table('wsec_menufeatures')->leftJoin('wsec_menutree', function ($join) {
            $join->on('wsec_menutree.menu_no_pk', '=', 'wsec_menufeatures.menu_no_pk');
        })->get();

        $menu_feature = [];
        if (!empty($features)) {
            foreach ($features as $app) {
                $menu_feature[$app->menu_no_pk][$app->features_no_pk] = $app->menu_name . '_' . $app->features_name;
            }
        }

        $role_feature_data = DB::table('wsec_rolefeaturesprivs')
            ->leftJoin('wsec_menufeatures', 'wsec_menufeatures.features_no_pk', '=', 'wsec_rolefeaturesprivs.features_no_fk')
            ->leftJoin('wsec_menutree', 'wsec_menutree.menu_no_pk', '=', 'wsec_rolefeaturesprivs.menu_no_fk')
            ->where('role_no_fk', '=', $id)->get();

        $features = [];
        if (!empty($role_feature_data)) {
            foreach ($role_feature_data as $feadrop) {
                $features[$feadrop->features_no_fk] = $feadrop->features_no_fk;
            }
        }

        return Template::loadview("admin.menu.create_user_role", ['users' => $users, 'menu_feature' => $menu_feature, 'module' => $module, 'roleid' => $roleid, 'features' => $features]);
    }

    public function storeRolePrivilege(Request $request)
    {
        $featurePrivs = $request->menu_name;
        // dd($featurePrivs);
        $id = $request->id;
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            // DB::table('wsec_rolefeaturesprivs')->where('role_no_fk', $request->roleid)->delete('role_no_fk');

            for ($i = 0; $i < sizeof($featurePrivs); $i++) {
                $feature_menu = explode("_", $featurePrivs[$i]);
                $data = [
                    'role_no_fk'  => $request->roleid,
                    'menu_no_fk'  => $feature_menu[1],
                    'features_no_fk'  => $feature_menu[0],
                    'au_entry_by'  => $auth_id,
                    'status'     => 1
                ];
                //$data['au_entry_by'] = $auth_id;

                $this->model5->create($data);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function userRolefeaturesDropdown(Request $request)
    {
        $features = DB::table('wsec_menufeatures')->leftJoin('wsec_menutree', function ($join) {
            $join->on('wsec_menutree.menu_no_pk', '=', 'wsec_menufeatures.menu_no_pk');
        })->get();

        $menu_feature = [];
        if (!empty($features)) {
            foreach ($features as $app) {
                $menu_feature[$app->menu_no_pk][$app->features_no_pk] = $app->menu_name . '_' . $app->features_name;
            }
        }

        $role_feature_data = DB::table('wsec_rolefeaturesprivs')
            ->leftJoin('wsec_menufeatures', 'wsec_menufeatures.features_no_pk', '=', 'wsec_rolefeaturesprivs.features_no_fk')
            ->leftJoin('wsec_menutree', 'wsec_menutree.menu_no_pk', '=', 'wsec_rolefeaturesprivs.menu_no_fk')
            ->where('role_no_fk', '=', $request->role_id)->get();

        $features = [];
        if (!empty($role_feature_data)) {
            foreach ($role_feature_data as $feadrop) {
                $features[$feadrop->features_no_fk] = $feadrop->features_no_fk;
            }
        }
        return Template::loadview("admin.menu.menu_features", ['menu_feature' => $menu_feature, 'features' => $features]);
    }

    public function userRolePrivisDropdown(Request $request)
    {
        $features = DB::table('wsec_menufeatures')->leftJoin('wsec_menutree', function ($join) {
            $join->on('wsec_menutree.menu_no_pk', '=', 'wsec_menufeatures.menu_no_pk');
        })->get();

        $menu_feature = [];
        if (!empty($features)) {
            foreach ($features as $app) {
                $menu_feature[$app->menu_no_pk][$app->features_no_pk] = $app->menu_name . '_' . $app->features_name;
            }
        }

        $role_feature_data = DB::table('wsec_rolefeaturesprivs')
            ->leftJoin('wsec_menufeatures', 'wsec_menufeatures.features_no_pk', '=', 'wsec_rolefeaturesprivs.features_no_fk')
            ->leftJoin('wsec_menutree', 'wsec_menutree.menu_no_pk', '=', 'wsec_rolefeaturesprivs.menu_no_fk')
            ->where('role_no_fk', '=', $request->role_id)->get();

        $features = [];
        if (!empty($role_feature_data)) {
            foreach ($role_feature_data as $feadrop) {
                $features[$feadrop->features_no_fk] = $feadrop->features_no_fk;
            }
        }
        return Template::loadview("admin.menu.menu_features", ['menu_feature' => $menu_feature, 'features' => $features]);
    }
}