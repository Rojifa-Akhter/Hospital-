<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Library\Template;
use Session;
use DB;
use Illuminate\Support\Facades\Auth;

class InvFinancialRequisitionApproval extends Controller
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

        //dd(Session::get('user.inv_proc_ind'));
        if (Session::get('user.inv_auth_chairman_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                //->where('su_no_fk', Session::get('user.su_pk_no'))
                ->whereIn('pur_requisition_no_pk', function($query){
                    return $query->select('pur_requisition_no_pk')
                        ->from('inv_purchase_requisitiondtl')
                        ->where('is_stock_ok','=',0);
                })
                ->orderBy('pur_requisition_no_pk', 'desc')
                ->get();
        }

        if (Session::get('user.inv_store_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                //->where('su_no_fk', Session::get('user.su_pk_no'))
                ->whereIn('pur_requisition_no_pk', function($query){
                    return $query->select('pur_requisition_no_pk')
                        ->from('inv_purchase_requisitiondtl')
                        ->where('is_stock_ok','=',0);
                })
                ->orderBy('pur_requisition_no_pk', 'desc')
                ->get();
        }

        if (Session::get('user.inv_proc_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->whereIn('pur_requisition_no_pk', function($query){
                    return $query->select('pur_requisition_no_pk')
                        ->from('inv_purchase_requisitiondtl')
                        ->where('is_stock_ok','=',0);
                })
                ->orderBy('pur_requisition_no_pk', 'desc')
                ->get();
        }

        //dd(Session::get('user.inv_store_ind'),Session::get('user.inv_proc_ind'));

        if (Session::get('user.inv_manager_acc_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->whereIn('pur_requisition_no_pk', function($query){
                    return $query->select('pur_requisition_no_pk')
                        ->from('inv_purchase_requisitiondtl')
                        ->where('is_stock_ok','=',0);
                })
                ->orderBy('pur_requisition_no_pk', 'desc')
                ->get();
        }

        if (Session::get('user.inv_gen_man_proc_ind') == 1) {
            
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->whereIn('pur_requisition_no_pk', function($query){
                    return $query->select('pur_requisition_no_pk')
                        ->from('inv_purchase_requisitiondtl')
                        ->where('is_stock_ok','=',0);
                })
                ->orderBy('pur_requisition_no_pk', 'desc')
                ->get();
               
        }

        if (Session::get('user.inv_director_acc_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->whereIn('pur_requisition_no_pk', function($query){
                    return $query->select('pur_requisition_no_pk')
                        ->from('inv_purchase_requisitiondtl')
                        ->where('is_stock_ok','=',0);
                })
                ->orderBy('pur_requisition_no_pk', 'desc')
                ->get();
        }


        if (Session::get('user.inv_auth_admin_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                //->where('su_no_fk', Session::get('user.su_pk_no'))
                ->whereIn('pur_requisition_no_pk', function($query){
                    return $query->select('pur_requisition_no_pk')
                        ->from('inv_purchase_requisitiondtl')
                        ->where('is_stock_ok','=',0);
                })
                ->orderBy('pur_requisition_no_pk', 'desc')
                ->get();
        }
        if (Session::get('user.inv_director_admin_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->whereIn('pur_requisition_no_pk', function($query){
                    return $query->select('pur_requisition_no_pk')
                        ->from('inv_purchase_requisitiondtl')
                        ->where('is_stock_ok','=',0);
                })
                ->orderBy('pur_requisition_no_pk', 'desc')
                ->get();
        }

        if (Session::get('user.inv_hod_ind') == 1) {
            $my_requsition = DB::table('inv_purchase_requisitionmst')
                ->whereIn('pur_requisition_no_pk', function($query){
                    return $query->select('pur_requisition_no_pk')
                        ->from('inv_purchase_requisitiondtl')
                        ->where('is_stock_ok','=',0);
                })
                ->orderBy('pur_requisition_no_pk', 'desc')
                ->get();
        }
        // dd((Session::get('user.inv_hod_ind') == 1));
        return Template::loadView("admin.inventory.requisition.requisition_approval_list", ['my_requsition' => $my_requsition, 'approval_ind' => $approval_ind]);
    }
}
