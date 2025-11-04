<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use DB;
use App\Library\Template;
use Illuminate\Support\Facades\Auth;
use App\Traits\DatatablesLoader;
use App\Traits\HospitalStoreData;
use App\Traits\ItemData;
use App\Traits\LookupData;
use App\Traits\UtilitiesTrait;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use PDO;
use PDF;

class StoreAdjustmentController extends Controller
{
    use DatatablesLoader, LookupData, ItemData, UtilitiesTrait, HospitalStoreData;
    //
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function stock_consumption()
    {
        $my_stores = DB::table('sysc_user_store_su_privs_vw')
            ->where('user_no_fk', Auth::id())
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->whereRaw('(hospital_store_ind = 1 or pharmacy_ind = 1 or med_store_ind=1 )')
            ->get();

        $all_stores = DB::table('sysc_serviceunit')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereRaw('(hospital_store_ind = 1 or pharmacy_ind = 1 or med_store_ind=1 )')
            ->get();
        // dd( $my_stores );
        $event = $this->getLookupListByCode('EVENT');
        return Template::loadView("admin.store.stock_consumption.stock_consumption", ['all_stores' => $all_stores, 'my_stores' => $my_stores, 'event' => $event]);
    }
    public function store_stock_consumption(Request $request)
    {
        if ($request->store_from == '') {
            $message = ['msg' => 'Please Select a Issue From.', 'title' => 'Error'];
            return response()->json($message);
        }
        // if ($request->store_to == '' && $request->events == '' && $request->hdn_patient_id == '') {
        //     $message = ['msg' => "Please Select any issue.", 'title' => 'Error'];
        //     return response()->json($message);
        // }
        if (empty($request->item_ids)) {
            $message = ['msg' => "Please Select any Item.", 'title' => 'Error'];
            return response()->json($message);
        }

        // try {
        $issue_to = '';
        if (isset($request->hdn_patient_id)) {
            $issue_to = 'PATIENT';
        }
        if (isset($request->events)) {
            $issue_to = 'EVENT';
        }
        if (isset($request->store_to)) {
            $issue_to = 'STORE';
        }
        if (isset($request->hdn_doctor_id)) {
            $issue_to = 'EMPLOYEE';
        }

        $chalan_date = isset($request->date) ? date("Y-m-d", strtotime($request->date)) : date('Y-m-d');
        $store_from = isset($request->store_from) ? $request->store_from : 0;
        $store_to = isset($request->store_to) ? $request->store_to : 0;
        $referance = isset($request->referance) ? $request->referance : '';
        $hdn_patient_id = isset($request->hdn_patient_id) ? $request->hdn_patient_id : 0;
        $events = isset($request->events) ? $request->events : 0;
        $hdn_doctor_id = isset($request->hdn_doctor_id) ? $request->hdn_doctor_id : 0;
        if ($events != 0) {
            $event = explode("_", $events);
        } else {
            $event[0] = 0;
        }
        $others_name = isset($request->others_name) ? $request->others_name : '';

        $item_pk_no = [];
        $item_pvms = [];
        $item_qty = [];
        $item_uom = [];
        $item_price = [];
        $item_entry_dtl = [];
        $txt_batch = [];
        $batch_qty = [];
        $txt_expire_date = [];

        $demand_no_fk = 1;
        $in_au_entry_by = Auth::id();
        $in_au_entry_session = 'SESSION';
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $numelems = 500;
        $null = '';
        $out_itemtrans_uid = '0';
        $zero = 0;

        if (!empty($request->txt_batch)) {
            for ($i = 0; $i < count($request->txt_batch); $i++) {
                if ($request->item_quantities[$i] != null) {
                    $item_data = explode('_', $request->txt_batch[$i]);
                    $item_arr[$i] =  $item_data[0];
                    $item_level_remarks[$i] = 0;
                    $item_batch_no[$i] =  $item_data[1];
                    $txt_batch[$i] = $item_batch_no[$i] != "0" ?  $item_batch_no[$i] : "";


                    $item_pk_no[$i] = isset($request->item_ids[$i]) ? $request->item_ids[$i] : 0;
                    $item_pvms[$i] = $null;
                    $item_qty[$i] = isset($request->item_quantities[$i]) ? $request->item_quantities[$i] : 0;
                    $item_uom[$i] = isset($request->item_uoms[$i]) ? $request->item_uoms[$i] : 0; //
                    $item_price[$i] = isset($request->item_prices[$i]) ? $request->item_prices[$i] : 0;
                    $item_entry_dtl[$i] = $i + 1;
                    $exp = explode('_', $request->txt_expire_date[$i]);
                    $txt_expire_date[$i] = $exp[1] != 0 ?  str_replace('-', '', $exp[1]) : "";
                    $checker = $request->input('hdn_item_qnty_' . $item_arr[$i]);
                    $qty_exp = explode('_', $request->batch_qty[$i]);
                    if ($request->batch_qty[$i] != null) {
                        $batch_qty[$i] = isset($request->batch_qty[$i]) ? $qty_exp[1] : $checker[0];
                    } else {
                        $batch_qty[$i] = isset($request->batch_qty[$i]) ? $qty_exp[1] : $request->item_quantities[$i];
                    }
                }
            }
        }
        //isset($request->item_uoms[$i]) ? $request->item_uoms[$i] :

        $pdo = DB::getPdo();
        $stock_adjustment = $pdo->prepare("begin
             pkg_pharmacy.prc_itemissue_ph(
            :in_issue_to,
            :in_issue_ref_no,
            :in_issue_date,
            :in_store_from_su_no_fk,
            :in_store_to_su_no_fk,
            :in_patient_no_fk,
            :in_event_lookup_no_fk,
            :in_event_name,
            :in_a_item_no_fk,
            :in_item_batch_fk,
            :in_item_expiry_dt,
            :in_a_item_pvmsno,
            :in_a_item_qty,
            :in_a_item_uom,
            :in_a_item_price,
            :in_a_entry_serial_dtl,
            :in_au_entry_by,
            :in_au_entry_session,
            :in_au_entry_hospital_no_fk,
            :out_itemissue_uid);
            end;
            ");
        $stock_adjustment->bindparam('in_issue_to', $issue_to);
        $stock_adjustment->bindparam('in_issue_ref_no', $referance);
        $stock_adjustment->bindparam('in_issue_date', $chalan_date);
        $stock_adjustment->bindparam('in_store_from_su_no_fk', $store_from);
        $stock_adjustment->bindparam('in_store_to_su_no_fk', $store_to);
        $stock_adjustment->bindparam('in_patient_no_fk', $hdn_patient_id);
        $stock_adjustment->bindparam('in_event_lookup_no_fk', $event[0]);
        $stock_adjustment->bindparam('in_event_name', $others_name);
        $stock_adjustment->bindArray('in_a_item_no_fk', $item_pk_no, count($item_pk_no), $numelems, SQLT_INT);
        $stock_adjustment->bindArray('in_item_batch_fk', $txt_batch, count($txt_batch), $numelems, SQLT_CHR);
        $stock_adjustment->bindArray('in_item_expiry_dt', $txt_expire_date, count($txt_expire_date), $numelems, SQLT_CHR);
        $stock_adjustment->bindArray('in_a_item_pvmsno', $item_pvms, count($item_pvms), $numelems, SQLT_CHR);
        $stock_adjustment->bindArray('in_a_item_qty', $batch_qty, count($batch_qty), $numelems, SQLT_INT);
        $stock_adjustment->bindArray('in_a_item_uom', $item_uom, count($item_uom), $numelems, SQLT_INT);
        $stock_adjustment->bindArray('in_a_item_price', $item_price, count($item_price), $numelems, SQLT_INT);
        $stock_adjustment->bindArray('in_a_entry_serial_dtl', $item_entry_dtl, count($item_entry_dtl), $numelems, SQLT_INT);

        $stock_adjustment->bindparam('in_au_entry_by', $in_au_entry_by);
        $stock_adjustment->bindparam('in_au_entry_session', $in_au_entry_session);
        $stock_adjustment->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);

        $stock_adjustment->bindParam(':out_itemissue_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);

        $stock_adjustment->execute();

        DB::commit();

        $message = ['msg' => 'Data saved successfully. Received UID : ' . $out_itemtrans_uid, 'title' => 'Success'];
        // } catch (\Exception $e) {

        //     DB::rollback();
        //     $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }
        return response()->json($message);
    }
    public function stock_issue_worklist()
    {
        $stores = DB::table('sysc_user_store_su_privs_vw')
            ->where('user_no_fk', Auth::id())
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->whereRaw('(hospital_store_ind = 1 or pharmacy_ind = 1 or med_store_ind=1 )')
            ->get();
        $issue_worklist = DB::table('phr_itemissue_vw')->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->orderBy('itemissue_no_pk', 'desc')->get();
        return Template::loadView("admin.store.stock_consumption.stock_issue_worklist", ['issue_worklist' => $issue_worklist, 'stores' => $stores]);
    }
    public function search_stock_issue_worklist(Request $request)
    {
        $store_cond = '';
        $session = Session::get('user.ses_hospital_no_pk');
        $where_cond = ($store_cond == '') ? 'where ' : 'and ';
        $store_cond .= isset($request->store_id) ? $where_cond . " store_from_su_no_fk ='" . $request->store_id . "' and au_entry_hospital_no_fk='$session'" : '';

        $where_cond = ($store_cond == '') ? 'where ' : 'and ';
        $store_cond .= isset($request->issue_to) ? $where_cond . " issue_to ='" . $request->issue_to . "' and au_entry_hospital_no_fk='$session'" : '';

        $where_cond = ($store_cond == '') ? 'where ' : 'and ';
        if (isset($request->fm_date) && isset($request->to_date)) {
            $store_cond .= $where_cond . " issue_date between '" . $request->fm_date . "' and '" . $request->to_date . "' and au_entry_hospital_no_fk='$session'";
        } elseif (isset($request->fm_date)) {
            $store_cond .= $where_cond . " issue_date = '" . $request->fm_date . "' and au_entry_hospital_no_fk='$session' ";
        } elseif (isset($request->to_date)) {
            $store_cond .= $where_cond . " issue_date = '" . $request->to_date . "' and au_entry_hospital_no_fk='$session'";
        }

        $issue_worklist = DB::select("select * from phr_itemissue_vw $store_cond ");
        return Template::loadView("admin.store.stock_consumption.item_issue_worklist_table", ['issue_worklist' => $issue_worklist]);
    }
    public function export_stock_issue(Request $request)
    {
        if ($request->type == 1) {
            $store_cond = '';
            $session = Session::get('user.ses_hospital_no_pk');
            $where_cond = ($store_cond == '') ? 'where ' : 'and ';
            $store_cond .= isset($request->store_id) ? $where_cond . " store_from_su_no_fk ='" . $request->store_id . "' and au_entry_hospital_no_fk='$session'" : '';

            $where_cond = ($store_cond == '') ? 'where ' : 'and ';
            $store_cond .= isset($request->issue_to) ? $where_cond . " issue_to ='" . $request->issue_to . "' and au_entry_hospital_no_fk='$session'" : '';

            $where_cond = ($store_cond == '') ? 'where ' : 'and ';
            if (isset($request->fm_date) && isset($request->to_date)) {
                $store_cond .= $where_cond . " issue_date between '" . $request->fm_date . "' and '" . $request->to_date . "' and au_entry_hospital_no_fk='$session'";
            } elseif (isset($request->fm_date)) {
                $store_cond .= $where_cond . " issue_date = '" . $request->fm_date . "' and au_entry_hospital_no_fk='$session' ";
            } elseif (isset($request->to_date)) {
                $store_cond .= $where_cond . " issue_date = '" . $request->to_date . "' and au_entry_hospital_no_fk='$session'";
            }

            $issue_worklist = DB::select("select * from phr_itemissue_vw $store_cond");
            $issue_from = isset($request->fm_date) ? date("d/m/Y", strtotime($request->fm_date)) : '';
            $issue_to = isset($request->to_date) ? date("d/m/Y", strtotime($request->to_date)) : '';
            $store = isset($request->store_id) ? $request->store_id : '';
            $pdf = PDF::loadView("admin.store.stock_consumption.consuption_report_pdf", ['store' => $store, 'issue_worklist' => $issue_worklist, 'issue_from' => $issue_from, 'issue_to' => $issue_to]);
            return $pdf->stream("Consumation-report.pdf");
        }
    }
}
