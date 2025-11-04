<?php

namespace App\Http\Controllers;

use App\Models\Menu;
use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Session;

class RolePermissionController extends Controller
{
    public function rolePermission(){   
        ini_set('max_execution_time',0) ;
        $roles = $this->getRoles();
        // $allMenus = $this->allMenus();
        $allMenus = Menu::with([
            'submenu' => function ($q) {
                $q->select('menu_no_pk', 'parent_menu_no_fk', 'menu_code', 'menu_icon', 'menu_name', 'menu_link', 'sl_no');
                $q->orderBy('sl_no','asc');
                $q->with([
                    'pages' => function ($query) {
                        $query->select('features_no_pk', 'features_code', 'features_name', 'features_name_2nd', 'features_type', 'sl_no', 'menu_no_pk');
                        $query->orderBy('sl_no','asc');
                    }
                ]);
            }
            ])->select('menu_no_pk', 'parent_menu_no_fk', 'menu_code', 'menu_icon', 'menu_name', 'menu_link', 'sl_no')
                ->where('parent_menu_no_fk',0)
                ->orderBy('sl_no','asc')
                ->get();
        
        foreach($allMenus as $item){
            $data = (object) [
                'menu_no_pk' => $item->menu_no_pk,
                'menu_name'  => 'Features',
                'sl' => 1,
                'pages' => $this->pages($item->menu_no_pk)
            ];
            $item->submenu->push($data);
        }
        
        return Template::loadview('admin.settings.role_permission.role_permission', compact('roles','allMenus'));
    }

    public function userRolePermission(){
        ini_set('max_execution_time',0) ;
        
        $roles = $this->getRoles();       
        $hospitals = DB::table('wsec_hospital')->select('hospital_no_pk','hospital_code','hospital_name','status')->get();
        $users = DB::table('wsec_user')
                    ->leftJoin('wsec_role','wsec_role.role_no_pk','=','wsec_user.role_no_fk')
                    ->select('wsec_user.user_no_pk','wsec_user.role_no_fk','wsec_user.user_fullname','wsec_user.user_code','wsec_user.status','wsec_role.role_name')
                    ->orderBy('wsec_user.user_code', 'asc')
                    ->get();        
        // $allMenus = $this->allMenus();

        $allMenus = Menu::with([
            'submenu' => function ($q) {
                $q->select('menu_no_pk', 'parent_menu_no_fk', 'menu_code', 'menu_icon', 'menu_name', 'menu_link', 'sl_no');
                $q->orderBy('sl_no','asc');
                $q->with([
                    'pages' => function ($query) {
                        $query->select('features_no_pk', 'features_code', 'features_name', 'features_name_2nd', 'features_type', 'sl_no', 'menu_no_pk');
                        $query->orderBy('sl_no','asc');
                    }
                ]);
            }
            ])->select('menu_no_pk', 'parent_menu_no_fk', 'menu_code', 'menu_icon', 'menu_name', 'menu_link', 'sl_no')
                ->where('parent_menu_no_fk',0)
                ->orderBy('sl_no','asc')
                ->get();
        
        foreach($allMenus as $item){
            $data = (object) [
                'menu_no_pk' => $item->menu_no_pk,
                'menu_name'  => 'Features',
                'sl' => 1,
                'pages' => $this->pages($item->menu_no_pk)
            ];
            $item->submenu->push($data);
        }
        return Template::loadview('admin.settings.role_permission.user_role_permission', compact('roles','allMenus','hospitals','users')); 
    }

    public function getUserList($hospital_id){
        $users = DB::table('wsec_user')
                    ->leftJoin('wsec_role','wsec_role.role_no_pk','=','wsec_user.role_no_fk')
                    ->select('wsec_user.user_no_pk','wsec_user.role_no_fk','wsec_user.user_fullname','wsec_user.user_code','wsec_user.status','wsec_role.role_name','wsec_user.status');
            if(!empty($hospital_id)){
                
                $users->where('wsec_user.au_entry_hospital_pk_no',$hospital_id);
            }
         $users = $users->orderBy('wsec_user.user_code', 'asc');
         $users = $users->get();

        $data = [];
        $d="<option value=''>Select User</option>";
        

        
        if(count($users)>0){
                       
            foreach($users as $item){
                    if($item->user_fullname != null && $item->status == 1){    
                        if(!empty($item->user_code)){
                            $d.='<option value='.$item->user_no_pk.'>'.$item->user_code.' - '.$item->user_fullname.'</option>'; 
                        }
                        else{
                            $d.='<option value='.$item->user_no_pk.'>'.$item->user_fullname.'</option>';                                               
                        }

                    }                  
            }

            array_push($data,$d);
            return $data;
            
        }
        else{
            return "<option value=''>Not Found</option>";
        }  
    }
    
    public function getRoles(){
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');       
        $get_roles = DB::table('wsec_role')->select('role_no_pk','role_code','role_name','role_desc','status')->orderBy('role_name','asc')->get();        
        return $get_roles;
    }

    public function allMenus(){
      $menu =  DB::table('wsec_menutree')               
                ->select('menu_no_pk', 'parent_menu_no_fk', 'menu_code', 'menu_icon', 'menu_name', 'menu_link', 'sl_no')
                ->where('parent_menu_no_fk',0)  
                ->orderBy('sl_no','asc')           
                ->get();

        foreach ($menu as $key => $value) {
            $value->submenu = $this->subMenu($value->menu_no_pk);
        }        
        return $menu;
    }

    public function subMenu($parent_id){
        $sub_menu =  DB::table('wsec_menutree')               
                        ->select('menu_no_pk', 'parent_menu_no_fk', 'menu_code', 'menu_icon', 'menu_name', 'menu_link', 'sl_no')
                        ->where('parent_menu_no_fk',$parent_id)    
                        ->orderBy('sl_no','asc')           
                        ->get()->toArray(); 

        if(count($sub_menu) == 0) {
            $demo_data = [];
            $data = (object) [
                'menu_no_pk' => $parent_id,
                'menu_name'  => 'Features',
                'sl' => 1,
                'pages' => $this->pages($parent_id)
            ];

            array_push($demo_data,$data);            
            return $demo_data;
        } 
        else{   
                     
            foreach ($sub_menu as $key => $value) {
                $value->pages = $this->pages($value->menu_no_pk);
            } 

            $pages =  $this->pages($parent_id);
            if(count($pages)>0){
                $data = (object) [
                    'menu_no_pk' => $parent_id,
                    'menu_name'  => 'Features',
                    'sl' => 1,
                    'pages' => $pages
                ];
                array_push($sub_menu,$data);  
            }
            
        }            
        
        return $sub_menu;
    }

    public function pages($sub_parent_id){
        $sub_menu =  DB::table('wsec_menufeatures')               
                        ->select('features_no_pk', 'features_code', 'features_name', 'features_name_2nd', 'features_type', 'sl_no','menu_no_pk')
                        ->where('menu_no_pk',$sub_parent_id)   
                        ->orderBy('sl_no','asc')            
                        ->get()->toArray(); 
        return $sub_menu;
    }

    public function saveRolePermission(Request $request){
        $request->validate([
            'role' => 'required'
        ]);
    
        try {                                   
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            
            $sequence = DB::getSequence();
            DB::beginTransaction();
            DB::table('wsec_rolefeaturesprivs')->where('role_no_fk',$request->role_hidden)->delete();
            foreach ($request->permission as $key => $value) {
                $featurs = explode('-', $value);               

                $role_features_pk = $sequence->nextValue('rolefeatures_no_pk_seq');
                    
                    $value = [
                        'rolefeatures_no_pk' => $role_features_pk,
                        'menu_no_fk' => $featurs[0],
                        'features_no_fk' => $featurs[1],
                        'role_no_fk' => $request->role_hidden,
                        'status' => 1,
                        'au_entry_at' => $au_entry_at,
                        'au_entry_by' => Auth::id(),
                        'au_entry_session' => $entry_session,
                        'au_entry_hospital_pk_no' => $hospital_pk_no,               
                    ];

                DB::table('wsec_rolefeaturesprivs')->insert($value);
            }
            DB::commit();   
            return response()->json(['success' => true, 'message' => 'Successfully Saved'], 200);
            
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        }       
    }

    public function getrolePermission($id){
       $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $data = DB::table('wsec_rolefeaturesprivs')
                ->leftJoin('wsec_menutree','wsec_menutree.menu_no_pk','=','wsec_rolefeaturesprivs.menu_no_fk')
                ->where('wsec_rolefeaturesprivs.role_no_fk',$id)
                ->where('wsec_rolefeaturesprivs.au_entry_hospital_pk_no', $hospital_pk_no)
                ->select([
                    'wsec_rolefeaturesprivs.features_no_fk',
                    DB::raw('CASE WHEN wsec_menutree.parent_menu_no_fk = 0  THEN wsec_menutree.menu_no_pk ELSE wsec_menutree.parent_menu_no_fk END AS final_menu_pk')
                ])
                ->get();

        $total_menu = collect($data)->groupBy('final_menu_pk')->toArray();
        $count_data = [];
        foreach($total_menu as $key => $value){
            $temp = [
                'parent_id' => $key,
                'count'  => count($value)
            ];
            array_push($count_data,$temp);
        }

        return response()->json(['data'=> $data,'count_data' => $count_data], 200);
    }
    
    public function getMultipleRolePermission(Request $request){
        
        $allData = $request->data;
        $roleData = array_filter($allData, function ($value) {
            return $value !== null;
        });
        
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $data = DB::table('wsec_rolefeaturesprivs')
                ->leftJoin('wsec_menutree','wsec_menutree.menu_no_pk','=','wsec_rolefeaturesprivs.menu_no_fk')
                ->whereIn('wsec_rolefeaturesprivs.role_no_fk',$roleData)
                ->where('wsec_rolefeaturesprivs.au_entry_hospital_pk_no', $hospital_pk_no)
                ->select([
                    'wsec_rolefeaturesprivs.features_no_fk',
                    DB::raw('CASE WHEN wsec_menutree.parent_menu_no_fk = 0  THEN wsec_menutree.menu_no_pk ELSE wsec_menutree.parent_menu_no_fk END AS final_menu_pk')
                ])
                ->distinct('wsec_rolefeaturesprivs.features_no_fk')
                ->get();

        $total_menu = collect($data)->groupBy('final_menu_pk')->toArray();
        $count_data = [];
        
        foreach($total_menu as $key => $value){
            $temp = [
                'parent_id' => $key,
                'count'  => count($value)
            ];
            array_push($count_data,$temp);
        }

        return response()->json(['data'=> $data,'count_data' => $count_data], 200);
    }

    public function getUserRolePermission($id){
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $data = DB::table('wsec_userfeaturesprivs')
                 ->leftJoin('wsec_menutree','wsec_menutree.menu_no_pk','=','wsec_userfeaturesprivs.menu_no_fk')
                 ->where('wsec_userfeaturesprivs.user_no_fk',$id)
                //  ->where('wsec_userfeaturesprivs.au_entry_hospital_pk_no', $hospital_pk_no)
                 ->select([
                     'wsec_userfeaturesprivs.features_no_fk',
                     DB::raw('CASE WHEN wsec_menutree.parent_menu_no_fk = 0  THEN wsec_menutree.menu_no_pk ELSE wsec_menutree.parent_menu_no_fk END AS final_menu_pk')
                 ])
                 ->get();
 
         $total_menu = collect($data)->groupBy('final_menu_pk')->toArray();
         $count_data = [];
         foreach($total_menu as $key => $value){
             $temp = [
                 'parent_id' => $key,
                 'count'  => count($value)
             ];
             array_push($count_data,$temp);
         }
 
         $roles = DB::table('wsec_user_roles')->where('user_no_fk',$id)
                    ->join('wsec_role','wsec_role.role_no_pk','=','wsec_user_roles.role_no_fk')
                    ->select('wsec_user_roles.user_roles_no_pk','wsec_user_roles.role_no_fk','wsec_user_roles.user_no_fk','wsec_role.role_name')
                    ->where('wsec_user_roles.status',1)
                    ->get();
         
         return response()->json(['data'=> $data,'count_data' => $count_data,'roles' => $roles], 200);
     }

    /* role crud*/
    
    public function roleEntryV1(){
        $roles = $this->getRoles();
        return Template::loadview('admin.settings.role_permission.role_entry', compact('roles'));
    }

    public function getRoleV1(){
        $roles = $this->getRoles();
        return response()->json(['success' => true, 'data' => $roles], 200);
    }

    public function saveRoleV1(Request $request){
        $request->validate([
            'role_name' => 'required'
        ]);
        

        try {
            ini_set('max_execution_time',0);
            
            DB::beginTransaction();
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $sequence = DB::getSequence();
            $role_pk = $sequence->nextValue('role_no_pk_seq');
            $data = [
                'role_no_pk' => $role_pk,
                'role_code' => $request->role_code,
                'role_name' => $request->role_name,
                'status' => $request->status,
                'role_desc' => $request->notes,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no, 
            ];
            if(!DB::table('wsec_role')->where('role_name',$request->role_name)->exists()){
                DB::table('wsec_role')->insert($data);
                $last_role_id = DB::table('wsec_role')->orderByDesc('role_no_pk')->value('role_no_pk');
            }
            else{
                return response()->json(['success' => false, 'message' => 'Role Name Already Exists!'], 422);  
            }


            if($request->copy_role != null){
               $prev_role = DB::table('wsec_rolefeaturesprivs')->where('role_no_fk',$request->copy_role)->get();

               foreach($prev_role as $item){
                    $role_per_pk = $sequence->nextValue('rolefeatures_no_pk_seq');
                    
                    $value = [
                        'rolefeatures_no_pk' => $role_per_pk,
                        'menu_no_fk' => $item->menu_no_fk,
                        'features_no_fk' => $item->features_no_fk,
                        'role_no_fk' => $last_role_id,
                        'status' => 1,
                        'au_entry_at' => $au_entry_at,
                        'au_entry_by' => Auth::id(),
                        'au_entry_session' => $entry_session,
                        'au_entry_hospital_pk_no' => $hospital_pk_no,               
                    ];
                                       
                    DB::table('wsec_rolefeaturesprivs')->insert($value);
               }
            }
            DB::commit();
            $roles = $this->getRoles();
            return response()->json(['success' => true, 'message' => 'Successfully Saved', 'data' => $roles], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        }
    }

    public function editRoleV1($id){
        $roles = $this->getRoles();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');       
        $role_info = DB::table('wsec_role')->select('role_no_pk','role_code','role_name','role_desc','status')->where('role_no_pk', $id)->first();        
        return Template::loadView("admin.settings.role_permission.modal.edit_role_setup", compact('roles','role_info'));
    }
    
    public function updateRoleV1(Request $request){
        $request->validate([
            'role_no_pk' => 'required',
            'role_name' => 'required'
        ]);

        try {
            ini_set('max_execution_time',0);
            
            DB::beginTransaction();
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $sequence = DB::getSequence();
            $role_pk = $request->role_no_pk;
            $data = [
                'role_no_pk' => $role_pk,
                'role_code' => $request->role_code,
                'role_name' => $request->role_name,
                'status' => $request->status,
                'role_desc' => $request->notes,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_pk_no' => $hospital_pk_no, 
            ];
            
            if(!DB::table('wsec_role')->where('role_name',$request->role_name)->where('role_no_pk','!=',$role_pk)->exists()){
                DB::table('wsec_role')->where('role_no_pk',$role_pk)->update($data);              
            }
            else{
                return response()->json(['success' => false, 'message' => 'Role Name Already Exists!'], 422);  
            }


            if($request->copy_role != null){
                
                DB::table('wsec_rolefeaturesprivs')->where('role_no_fk',$role_pk)->delete();
                $prev_role = DB::table('wsec_rolefeaturesprivs')->where('role_no_fk',$request->copy_role)->get();
                foreach($prev_role as $item){
                
                    $role_per_pk = $sequence->nextValue('rolefeatures_no_pk_seq');
                        
                    $value = [
                        'rolefeatures_no_pk' => $role_per_pk,
                        'menu_no_fk' => $item->menu_no_fk,
                        'features_no_fk' => $item->features_no_fk,
                        'role_no_fk' => $role_pk,
                        'status' => 1,
                        'au_entry_at' => $au_entry_at,
                        'au_entry_by' => Auth::id(),
                        'au_entry_session' => $entry_session,
                        'au_entry_hospital_pk_no' => $hospital_pk_no,               
                    ];
                                        
                    DB::table('wsec_rolefeaturesprivs')->insert($value);
               }
            }
            DB::commit();
            return response()->json(['success' => true, 'msg' => 'Successfully Updated','title' => 'Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'msg' => $th->getMessage(), 'title' => 'Error'], 422);
        }
    }


    public function saveUserRolePermission(Request $request){
        $request->validate([
            'user_hidden' => 'required'
        ]);
        
        try {
            
            ini_set('max_execution_time',0);
            DB::beginTransaction();
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $sequence = DB::getSequence();
            
            
            if(count($request->role_hidden) > 0){
                // DB::table('wsec_user_roles')->where('user_no_fk',$request->user_hidden)->delete();

                $roles = explode(",", $request->role_hidden[0]);
                foreach($roles as $value){
                    $role_pk = $sequence->nextValue('user_roles_no_pk_seq');
      
                    $data = [   
                            'user_roles_no_pk' => $role_pk,            
                            'role_no_fk' => $value,
                            'user_no_fk' => $request->user_hidden,
                            'status' => 1,
                            'au_entry_at' => $au_entry_at,
                            'au_entry_by' => Auth::id(),
                            'au_entry_session' => $entry_session,
                            'au_entry_hospital_pk_no' => $hospital_pk_no, 
                        ];   
                        
                    if(!DB::table('wsec_user_roles')->where('user_no_fk',$request->user_hidden)->where('role_no_fk',$value)->exists()){
                        DB::table('wsec_user_roles')->insert($data);                  
                    }
                     
                }               
            }
            $roles_has = explode(",", $request->role_hidden[0]);

           if(empty($roles_has[0])){
             DB::table('wsec_userfeaturesprivs')->where('user_no_fk',$request->user_hidden)->delete();
           }
           
            if(isset($request->permission)){
                foreach ($request->permission as $key => $value) {
                    $featurs = explode('-', $value);               
    
                    $users_features_pk = $sequence->nextValue('userfeatures_no_pk_seq');
                        
                        $value = [
                            'user_no_fk' => $request->user_hidden,
                            'userfeatures_no_pk' => $users_features_pk,
                            'menu_no_fk' => $featurs[0],
                            'features_no_fk' => $featurs[1],
                            // 'role_no_fk' => $request->role_hidden,
                            'status' => 1,
                            'can_view' => 1,
                            'can_modify' => 1,
                            'can_remove' => 1,
                            'can_share' => 1,
                            'status' => 1,
                            'grant_dt' => $au_entry_at,
                            'au_entry_at' => $au_entry_at,
                            'au_entry_by' => Auth::id(),
                            'au_entry_session' => $entry_session,
                            'au_entry_hospital_pk_no' => $hospital_pk_no,               
                        ];   
                    $identify = [
                        'user_no_fk' => $request->user_hidden,
                        'features_no_fk' => $featurs[1]
                    ];
                    DB::table('wsec_userfeaturesprivs')->updateOrInsert($identify, $value);
                } 
            }
            

            DB::commit();

            $roles_list = DB::table('wsec_user_roles')->where('user_no_fk',$request->user_hidden)
                    ->join('wsec_role','wsec_role.role_no_pk','=','wsec_user_roles.role_no_fk')
                    ->select('wsec_user_roles.user_roles_no_pk','wsec_user_roles.role_no_fk','wsec_user_roles.user_no_fk','wsec_role.role_name')
                    ->where('wsec_user_roles.status',1)
                    ->get();
                    
            return response()->json(['success' => true, 'message' => 'Successfully Saved','roles' => $roles_list], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage()], 422);
        }
    }

    public function checkUserPermission(){
        $hospitals = DB::table('wsec_hospital')->select('hospital_no_pk','hospital_code','hospital_name','status')->get();
        $users = DB::table('wsec_user')
                    ->leftJoin('wsec_role','wsec_role.role_no_pk','=','wsec_user.role_no_fk')
                    ->select('wsec_user.user_no_pk','wsec_user.role_no_fk','wsec_user.user_fullname','wsec_user.user_code','wsec_user.status','wsec_role.role_name')
                    ->get();
        return Template::loadview('admin.settings.role_permission.check_user_role_permission', compact('hospitals','users')); 
    }

    public function checkUserPrivs($id){
        $data = DB::table('wsec_menufeatures')
                    ->leftJoin('wsec_userfeaturesprivs',function($q) use ($id) {
                        $q->on('wsec_menufeatures.features_no_pk', '=', 'wsec_userfeaturesprivs.features_no_fk');
                        $q->where('user_no_fk',$id);
                    })
                       
                    ->leftJoin('wsec_user','wsec_user.user_no_pk','=','wsec_userfeaturesprivs.user_no_fk')              
                    ->leftJoin('wsec_role','wsec_role.role_no_pk','=','wsec_user.role_no_fk')              
                    ->select('wsec_menufeatures.features_name','wsec_userfeaturesprivs.status','wsec_userfeaturesprivs.grant_dt','wsec_userfeaturesprivs.menu_no_fk','wsec_userfeaturesprivs.user_no_fk','wsec_user.user_fullname','wsec_role.role_name')
                    ->selectRaw("CASE WHEN wsec_userfeaturesprivs.user_no_fk IS NOT NULL THEN 'Yes' ELSE 'No' END AS privs")
                    ->get();
        return response()->json(['success' => true, 'data' => $data],200);
    }

    public function deleteUserRoles(Request $request){
       $request->validate([
        'role_id' => 'required',
        'user_id' => 'required'
       ]);

       try {
            DB::beginTransaction();
            $prev_role_permission = DB::table('wsec_rolefeaturesprivs')->where('role_no_fk',$request->role_id)->pluck('features_no_fk')->toArray();
            DB::table('wsec_userfeaturesprivs')->where('user_no_fk',$request->user_id)->whereIn('features_no_fk',$prev_role_permission)->delete();
            DB::table('wsec_user_roles')->where('user_no_fk',$request->user_id)->where('role_no_fk',$request->role_id)->delete();

            $roles = DB::table('wsec_user_roles')->where('user_no_fk',$request->user_id)
                ->join('wsec_role','wsec_role.role_no_pk','=','wsec_user_roles.role_no_fk')
                ->select('wsec_user_roles.user_roles_no_pk','wsec_user_roles.role_no_fk','wsec_user_roles.user_no_fk','wsec_role.role_name')
                ->where('wsec_user_roles.status',1)
                ->get();
            DB::commit();
            return response()->json(['Success' => true,'title' => 'Success' ,'message' => 'Successfully Deleted', 'roles' => $roles], 200);    
       } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['Success' => false,'title' => 'Failed' ,'message' => $th->getMessage()], 422);
       }   
    }
}