<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Template;
use Session;
use DB;
use Illuminate\Support\Facades\Auth;

class InvPurchaseRequisitionApproval extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
                //
        $approval_ind = 1;
        $my_requsition = [];
        //dd(Session::get('user.inv_auth_chairman_ind'));
        if (Session::get('user.inv_auth_chairman_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->whereIn('pur_requisition_no_pk', function($query){
                    return $query->select('pur_requisition_no_pk')
                        ->from('inv_purchase_requisitiondtl')
                        ->where('is_stock_ok','=',0);
                })
                ->orderBy('pur_requisition_date', 'desc')
                //->where('su_no_fk', Session::get('user.su_pk_no'))
                ->get();
        }
        if (Session::get('user.inv_auth_director_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->whereIn('pur_requisition_no_pk', function($query){
                    return $query->select('pur_requisition_no_pk')
                        ->from('inv_purchase_requisitiondtl')
                        ->where('is_stock_ok','=',0);
                })
                ->orderBy('pur_requisition_date', 'desc')
                //->where('su_no_fk', Session::get('user.su_pk_no'))
                ->get();
        }
        if (Session::get('user.inv_auth_admin_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->whereIn('pur_requisition_no_pk', function($query){
                    return $query->select('pur_requisition_no_pk')
                        ->from('inv_purchase_requisitiondtl')
                        ->where('is_stock_ok','=',0);
                })
                ->orderBy('pur_requisition_date', 'desc')
                //->where('su_no_fk', Session::get('user.su_pk_no'))
                ->get();
        }
        if (Session::get('user.inv_director_admin_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->whereIn('pur_requisition_no_pk', function($query){
                    return $query->select('pur_requisition_no_pk')
                        ->from('inv_purchase_requisitiondtl')
                        ->where('is_stock_ok','=',0);
                })
                ->orderBy('pur_requisition_date', 'desc')
                ->get();
        }
        
        if (intval(Session::get('user.inv_hod_ind')) == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->where('su_no_fk', Session::get('user.su_pk_no'))
                ->whereIn('pur_requisition_no_pk', function($query){
                    return $query->select('pur_requisition_no_pk')
                        ->from('inv_purchase_requisitiondtl')
                        ->where('is_stock_ok','=',0);
                })
                ->orderBy('pur_requisition_date', 'desc')
                ->get();
        }

        if (Session::get('user.inv_store_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->whereIn('pur_requisition_no_pk', function($query){
                    return $query->select('pur_requisition_no_pk')
                        ->from('inv_purchase_requisitiondtl')
                        ->where('is_stock_ok','=',0);
                })
                ->orderBy('pur_requisition_date', 'desc')
                //->where('su_no_fk', Session::get('user.su_pk_no'))
                ->get();
        }

        // dd((Session::get('user.inv_hod_ind') == 1));
        return Template::loadView("admin.inventory.requisition.requisition_approval_list", ['my_requsition' => $my_requsition, 'approval_ind' => $approval_ind]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
       
        //$hospital_admin = DB::table("employee_info_vw")->where('inv_director_admin_ind',1)->where('person_no_pk',12727)->first();
        //$hospital_director = DB::table("employee_info_vw")->where('inv_auth_director_ind',1)->where('person_no_pk',12729)->first();

        $requ_info = DB::table('inv_purchase_requisitionmst')->where('pur_requisition_no_pk', $request->hdn_requisition_no)->first();

        if (Session::get('user.inv_auth_chairman_ind') == 1) {
            $data["recommended_ind"] = 1;
            $data["recommended_name"] =  Auth::user()->user_fullname;
            $data["recommended_by"] =  Auth::user()->user_no_pk;
            $data["recommended_at"] = date('Y-m-d h:i:s');
        }
        if (Session::get('user.inv_auth_director_ind') == 1) {
            $data["direc__ind"] = 1;
            $data["direc_name"] =  Auth::user()->user_fullname;
            $data["direc_by"] =  Auth::user()->user_no_pk;
            $data["direc_at"] = date('Y-m-d h:i:s');

            // $data["direc_admin_ind"] = 1;
            // $data["direc_admin_name"] =  $hospital_admin->full_name;
            // $data["direc_admin_by"] =  $hospital_admin->person_no_pk;
            // $data["direc_admin_at"] = date('Y-m-d h:i:s');
        }
        if (Session::get('user.inv_auth_admin_ind') == 1) {
            $data["reviewed_ind"] = 1;
            $data["reviewed_name"] =  Auth::user()->user_fullname;
            $data["reviewed_by"] =  Auth::user()->user_no_pk;
            $data["reviewed_at"] = date('Y-m-d h:i:s');
        }

        if ($requ_info->reviewed_ind != 1) {
            if (Session::get('user.inv_hod_ind') == 1) {
                $data["reviewed_ind"] = 1;
                $data["reviewed_name"] =  Auth::user()->user_fullname;
                $data["reviewed_by"] =  Auth::user()->user_no_pk;
                $data["reviewed_at"] = date('Y-m-d h:i:s');
            }
        }

        if (Session::get('user.inv_director_admin_ind') == 1) {

            

            $data["direc_admin_ind"] = 1;
            $data["direc_admin_name"] =  Auth::user()->user_fullname;
            $data["direc_admin_by"] =  Auth::user()->user_no_pk;
            $data["direc_admin_at"] = date('Y-m-d h:i:s');


            // $data["direc__ind"] = 1;
            // $$data["direc_name"] =  @$hospital_director->full_name;
            // $data["direc_by"] = @$hospital_director->person_no_pk;
            // $data["direc_at"] = date('Y-m-d h:i:s');
        }

        if ($requ_info->store_ind != 1) {
            if (Session::get('user.inv_store_ind') == 1) {
                $data["store_ind"] = 1;
                $data["store_at"] =  date('Y-m-d h:i:s');
                $data["store_by"] =  Auth::user()->user_no_pk;
                $data["store_person_name"] = Auth::user()->user_fullname;
            }
        }


        if ($requ_info->proc_ind != 1) {
            if (Session::get('user.inv_proc_ind') == 1) {
                $data["proc_ind"] = 1;
                $data["proc_at"] =  date('Y-m-d h:i:s');
                $data["proc_by"] =  Auth::user()->user_no_pk;
                $data["proc_person_name"] = Auth::user()->user_fullname;
            }
        }

        if (Session::get('user.inv_manager_acc_ind') == 1) {
            $data["manager_acc_ind"] = 1;
            $data["manager_acc_at"] =  date('Y-m-d h:i:s');
            $data["manager_acc_by"] =  Auth::user()->user_no_pk;
            $data["manager_acc_name"] = Auth::user()->user_fullname;
        }

        if ($requ_info->gen_man_ind != 1) {
            if (Session::get('user.inv_gen_man_proc_ind') == 1) {
                $data["gen_man_ind"] = 1;
                $data["gm_remarks"] = $request->gm_remarks;
                $data["gen_man_at"] =  date('Y-m-d h:i:s');
                $data["gen_man_by"] =  Auth::user()->user_no_pk;
                $data["gen_man_name"] = Auth::user()->user_fullname;
            }
        }

        if (Session::get('user.inv_director_acc_ind') == 1) {
            $data["dir_acc_ind"] = 1;
            $data["dir_acc_at"] =  date('Y-m-d h:i:s');
            $data["dir_acc_by"] =  Auth::user()->user_no_pk;
            $data["dir_acc_name"] = Auth::user()->user_fullname;
        }

        if (Session::get('user.inv_auth_chairman_ind') == 1) {
            $data["chairman_ind"] = 1;
            $data["chairman_at"] =  date('Y-m-d h:i:s');
            $data["chairman_by"] =  Auth::user()->user_no_pk;
            $data["chairman_name"] = Auth::user()->user_fullname;
        }

        DB::table('inv_purchase_requisitionmst')->where('pur_requisition_no_pk', $request->hdn_requisition_no)->update($data);
        DB::commit();

        if (Session::get('user.inv_store_ind') == 1) {
            for ($i = 0; $i < count($request->pur_requisitiondtl_no_pk); $i++) {
                if (isset($request->is_stock_ok) && @$request->is_stock_ok[$i] == "on") {
                    $data2['is_stock_ok'] = 1;
                    DB::table('inv_purchase_requisitiondtl')->where('pur_requisitiondtl_no_pk', $request->pur_requisitiondtl_no_pk[$i])->update($data2);
                    DB::commit();
                } else {
                    $data2['is_stock_ok'] = 0;
                    DB::table('inv_purchase_requisitiondtl')->where('pur_requisitiondtl_no_pk', $request->pur_requisitiondtl_no_pk[$i])->update($data2);
                    DB::commit();
                }
            }
        }

        if (Session::get('user.inv_proc_ind') == 1 || Session::get('user.inv_manager_acc_ind') == 1 || Session::get('user.inv_gen_man_proc_ind') == 1 || Session::get('user.inv_director_acc_ind') == 1 || Session::get('user.inv_auth_chairman_ind') == 1) {
            for ($i = 0; $i < count($request->pur_requisitiondtl_no_pk); $i++) {
                $data2['approval_qty'] = $request->item_app_quantities[$i];
                $data2['rate'] = $request->item_rates[$i];
                $data2['estimated_price'] = $request->item_app_quantities[$i] * $request->item_rates[$i];
                DB::table('inv_purchase_requisitiondtl')->where('pur_requisitiondtl_no_pk', $request->pur_requisitiondtl_no_pk[$i])->update($data2);
                DB::commit();
            }
        }
        $message = ['msg' => 'Requisition Approved successfully. <br>', 'title' => 'Success'];
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
        //
        $my_requsition = DB::table('inv_purchase_requisitionmst')
            ->where('pur_requisition_no_pk', $id)
            ->first();

        if (Session::get('user.inv_store_ind') == 1) {
            $my_requsition_dtls = DB::table('inv_purchase_requisitiondtl')
                ->where('pur_requisition_no_pk', $id)
                ->where('is_stock_ok', 0)
                ->get();
        } elseif (Session::get('user.inv_proc_ind') == 1) {
            $my_requsition_dtls = DB::table('inv_purchase_requisitiondtl')
                ->where('pur_requisition_no_pk', $id)
                ->where('is_stock_ok', 0)
                ->get();
        } elseif (Session::get('user.inv_manager_acc_ind') == 1) {
            $my_requsition_dtls = DB::table('inv_purchase_requisitiondtl')
                ->where('pur_requisition_no_pk', $id)
                ->where('is_stock_ok', 0)
                ->get();
        } elseif (Session::get('user.inv_gen_man_proc_ind') == 1) {
            $my_requsition_dtls = DB::table('inv_purchase_requisitiondtl')
                ->where('pur_requisition_no_pk', $id)
                ->where('is_stock_ok', 0)
                ->get();
        } elseif (Session::get('user.inv_director_acc_ind') == 1) {
            $my_requsition_dtls = DB::table('inv_purchase_requisitiondtl')
                ->where('pur_requisition_no_pk', $id)
                ->where('is_stock_ok', 0)
                ->get();
        } elseif (Session::get('user.inv_auth_chairman_ind') == 1) {
            $my_requsition_dtls = DB::table('inv_purchase_requisitiondtl')
                ->where('pur_requisition_no_pk', $id)
                ->where('is_stock_ok', 0)
                ->get();
        } else {
            $my_requsition_dtls = DB::table('inv_purchase_requisitiondtl')
                ->where('pur_requisition_no_pk', $id)
                ->get();
        }
        return Template::loadView("admin.inventory.requisition.approval.create_approval", [
            'my_requsition' => $my_requsition,
            'my_requsition_dtls' => $my_requsition_dtls,
        ]);
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
}
