<?php

namespace App\Http\Controllers;

use App\Datatables\DataTableClass;
use App\Traits\DatatablesLoader;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Traits\MailEngine;
use App\Library\Template;
use Illuminate\Support\Facades\Session;
use DB;

class DashboardController extends Controller
{
    use MailEngine;
    use DatatablesLoader;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct()
    {
        $this->middleware('auth');
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\Contracts\Support\Renderable
     */

    public function tvScreen()
    {
        $requestDepts = \Illuminate\Support\Facades\DB::table('sysc_serviceunit')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->get(['serviceunit_name', 'serviceunit_no_pk']);
        $room_number = Room::select("room_name", "room_no_pk")
            ->where("status", 1)->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->get();


        //        tv screen part
        $ses_hospital_id = Session::get('user.ses_hospital_id');
        $appointment_date = date("Y-m-d");
        $appointment_rs = DB::table("patn_appointment_vw a")
            ->select("a.*", "b.prescription_no_pk", 'b.room_name', 'b.patient_type')
            ->leftJoin('psn_t_prescription_vw b', function ($join) {
                $appointment_date = date("Y-m-d");
                $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                    ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
            })
            ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.LOOKUPDATA_NO_PK")
            ->orderBy("b.room_name", "asc")
            ->orderBy("a.slot_sl", "asc")
            ->where("a.appoint_date", $appointment_date)
            ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
            ->get();

        // dd($appointment_rs);

        $voice_rs = DB::table("patn_appointment_vw a")
            // ->select("a.*", "b.prescription_no_pk", 'b.room_name', 'b.patient_type')
            ->leftJoin('psn_t_prescription_vw b', function ($join) {
                $appointment_date = date("Y-m-d");
                $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                    ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
            })
            // ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.LOOKUPDATA_NO_PK")
            ->orderBy("a.slot_sl", "asc")
            ->where("a.appoint_date", $appointment_date)
            ->where('a.appoint_status', 1)
            ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
            ->where('a.cancel_ind', 0)
            ->limit(2)
            ->get();

        //        end
        return Template::loadView("admin.dashboards.tv_screen", [
            'appointment_rs' => $appointment_rs, 'voice_rs' => $voice_rs
        ]);
    }

    public function tvScreenDataTable()
    {
        $ses_hospital_id    = Session::get('user.ses_hospital_id');
        $appointment_date   = date("Y-m-d");
        $appointment_rs = DB::table("patn_appointment_vw a")
            ->select("a.*", "b.prescription_no_pk", 'b.room_name', 'b.patient_type')
            ->leftJoin('psn_t_prescription_vw b', function ($join) {
                $appointment_date = date("Y-m-d");
                $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                    ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
            })
            ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.LOOKUPDATA_NO_PK")
            ->orderBy("b.room_name", "asc")
            ->orderBy("a.slot_sl", "asc")
            ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
            ->where("a.appoint_date", $appointment_date)->get();


        // $voice_rs = DB::table("patn_appointment_vw a")
        //     ->select("a.*", "b.prescription_no_pk", 'b.room_name', 'b.patient_type')
        //     ->leftJoin('psn_t_prescription_vw b', function ($join) {
        //         $appointment_date = date("Y-m-d");
        //         $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
        //             ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
        //     })
        //     ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.LOOKUPDATA_NO_PK")
        //     //            ->orderBy("b.room_name", "asc")
        //     ->orderBy("a.slot_sl", "asc")
        //     ->where("a.appoint_date", $appointment_date)
        //     ->where('a.appoint_status', 1)
        //     ->where('a.cancel_ind', 0)
        //     ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
        //     ->limit(2)
        //     ->get();

        $voice_rs = DB::table("patn_appointment_vw a")
            // ->select("a.*", "b.prescription_no_pk", 'b.room_name', 'b.patient_type')
            ->leftJoin('psn_t_prescription_vw b', function ($join) {
                $appointment_date = date("Y-m-d");
                $join->on('a.appoint_no_pk', '=', 'b.appoint_no_fk')
                    ->whereRaw(" trunc(b.au_entry_at)=TO_DATE('$appointment_date', 'YYYY/mm/dd')");
            })
            // ->leftJoin("sysc_lookupdata c", "a.priority_no_fk", "=", "c.LOOKUPDATA_NO_PK")
            ->orderBy("a.slot_sl", "asc")
            ->where("a.appoint_date", $appointment_date)
            ->where('a.appoint_status', 1)
            ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
            ->where('a.cancel_ind', 0)
            ->limit(2)
            ->get();

        return Template::loadView("admin.dashboards.tv_screen_data_table", [
            'appointment_rs' => $appointment_rs, 'voice_rs' => $voice_rs
        ]);
    }

    public function DeptWiseRoom(Request $request)
    {
        $room_number = Room::select("room_name", "room_no_pk")
            ->where("status", 1)
            ->where('serviceunit_no_fk', $request->dept_val)
            ->get();
        return Template::loadView("admin.dashboards.room_list", ['room_number' => $room_number]);
    }


    public function index()
    {
        return view('admin.dashboards.dashboard_admin');
    }

    public function commonPage()
    {
        return template::loadview('admin.dashboards.common-page');
    }
    public function managementDashboard()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $to_date = date('d-m-Y');
        $service_unit = DB::table('SYSC_SERVICEUNIT')->where('CLINICAL_IND', '1')->get();
        $shift = db::select('select  * from hrms_shift where status = 1');
        // $shift = db::select('select  * from hrms_shift s left join hrms_schedule h on s.shift_no_pk = h.shift_no_fk');
        $consultant_data = DB::select("select a.appoint_date,a.doctor_no_fk,
                                       a.doctor_room_in,
                                      a.doctor_room_in_time,
                                       a.doctor_room_out,
                                      a.doctor_room_out_time,
                                       per.degree1,
                                       per.degree2,
                                       per.degree3,
                                       per.degree4,
                                       per.salutation,
                                        ser.serviceunit_name,
                                             to_char (a.start_time, 'hh24:mi:ss') start_time,
                                             to_char (a.end_time, 'hh24:mi:ss') end_time,
                                             a.doctor_name,
                                             sum (case when a.appoint_type_code = 'newcons' then 1 else 0 end)
                                                total_new,
                                             sum (case when a.appoint_type_code = 'followup' then 1 else 0 end)
                                                total_followup
                                        from doctor_wise_appoint_consult_vw a
                                        left join sysc_serviceunit ser
                                        on ser.serviceunit_no_pk = a.su_no_fk
                                         left join hrms_personnel per
                                          on a.doctor_no_fk = per.person_no_pk
                                       where a.status = 1
                                             and trunc (a.appoint_date) = to_date ('$to_date', 'dd/mm/yyyy')
                                        and a.au_entry_hospital_pk_no = $ses_hospital_id
                                    group by a.appoint_date,
                                       a.doctor_room_in,
                                      a.doctor_room_in_time,
                                       a.doctor_room_out,
                                      a.doctor_room_out_time,
                                       per.degree1,
                                       per.degree2,
                                       per.degree3,
                                       per.degree4,
                                       a.start_time,
                                       a.end_time,
                                        a.doctor_name,ser.serviceunit_name,
                                        per.salutation,a.doctor_no_fk");
        //        dd($consultant_data);
        $consultant_data_count = count(DB::select("select a.doctor_no_fk,a.appoint_date,to_char(A.START_TIME,'hh24:mi:ss') start_time,to_char(A.END_TIME,'hh24:mi:ss') END_TIME, a.doctor_name,sum(case when a.appoint_type_code = 'NEWCONS' then 1 else 0 end) total_new, sum(case when a.appoint_type_code = 'FOLLOWUP' then 1 else 0 end) total_followup from doctor_wise_appoint_consult_vw a where a.status=1 and trunc(a.appoint_date) =to_date('$to_date','dd/mm/yyyy')   and a.au_entry_hospital_pk_no = $ses_hospital_id  group by  a.doctor_no_fk,a.appoint_date,a.doctor_name,A.START_TIME,A.END_TIME"));
        $consultant = db::select("select distinct(d.SCHEDULE_NO_FK) ,count(d.doctor_no_fk) as total_app  from DOCTOR_WISE_APPOINT_CONSULT_VW d
                     left join hrms_schedule S
                     on s.SCHEDULE_NO_pk = D.SCHEDULE_NO_FK
                      where D.SCHEDULE_NO_FK=  S.SCHEDULE_NO_pk
                       and trunc(d.appoint_date) =trunc(sysdate)
                       and d.au_entry_hospital_pk_no = $ses_hospital_id
                       group by d.SCHEDULE_NO_FK");
        // Chart Data
        $consultant_chart_data = db::select("select sh.shift_code ,count(d.patient_no_fk) as total_app  from doctor_wise_appoint_consult_vw d
                     left join hrms_schedule s
                     left join hrms_shift sh
                     on shift_no_pk = s.shift_no_fk
                     on s.schedule_no_pk = d.schedule_no_fk
                      where d.schedule_no_fk=  s.schedule_no_pk
                       and trunc(d.appoint_date) = trunc(sysdate)
                       and d.au_entry_hospital_pk_no = $ses_hospital_id
                       group by sh.shift_code");
        //         dd($consultant_chart_data);
        // $account_pie = DB::select("select round (sum (ledgerdtl_amt_payment_lab), 2)
        //                            + round (sum (ledgerdtl_amt_payment_rad), 2)
        //                               investigation,
        //                            round (sum (ledgerdtl_amt_payment_hos)) ipd,
        //                            round (sum (ledgerdtl_amt_payment_phr)) pharmacy,
        //                            round (sum (ledgerdtl_amt_payment_amb)) ambulance,
        //                            round (sum (ledgerdtl_amt_payment_others)) other,
        //                              round (sum (ledgerdtl_amt_payment_lab))
        //                            + round (sum (ledgerdtl_amt_payment_rad))
        //                            + round (sum (ledgerdtl_amt_payment_phr))
        //                            + round (sum (ledgerdtl_amt_payment_amb))
        //                            + round (sum (ledgerdtl_amt_payment_hos))
        //                            + round (sum (ledgerdtl_amt_payment_others))
        //                               total_collection
        //                       from finc_summarystatement_dt_vw
        //                      "); // where to_char (trunc (invoice_date), 'mm') = to_char (sysdate, 'mm') and au_entry_hospital_pk_no= $ses_hospital_id

        $account_pie = DB::select("select round (sum (rad_amt), 2)
                             + round (sum (lab_amt), 2)
                                investigation,
                             round (sum (ipd_service_amt)) ipd,
                             round (sum (pharmacy_amt)) pharmacy,
                             round (sum (sur_amt)) ambulance,
                             round (sum (all_other_amt)) other,
                               round (sum (lab_amt))
                             + round (sum (rad_amt))
                             + round (sum (pharmacy_amt))
                             + round (sum (sur_amt))
                             + round (sum (sur_amt))
                             + round (sum (all_other_amt))
                                total_collection
                        from finc_dashboard_accounts_dt_vw
                       ");

        $account_pie_chart =  json_encode($account_pie);
        //        hr
        $hr_data = DB::select(DB::raw("SELECT
                                 trunc(attendance_date) attendance_date,
                                count(a.person_no_fk) total_emp,
                                sum(case when trunc(a.attendance_date)=trunc(sysdate) and attendance_status = 1 then 1 else 0 end)  attend,
                                sum(case when   trunc(a.attendance_date)=trunc(sysdate) and a.attendance_status = 2 then 1 else 0 end) late,
                                sum(case when   trunc(a.attendance_date)=trunc(sysdate) and a.attendance_status=3 then 1 else 0 end) leave,
                                sum(case when   trunc(a.attendance_date)=trunc(sysdate) and a.attendance_status=4 then 1 else 0 end) lwp,
                                sum(case when   trunc(a.attendance_date)=trunc(sysdate) and a.attendance_status=5 then 1 else 0 end) absent,
                                sum(case when   trunc(a.attendance_date)=trunc(sysdate) and a.attendance_status=6 then 1 else 0 end) dayoff
                                from hrms_attendance_daily a left join hrms_personnel p
                                on a.person_no_fk=p.person_no_pk
                                  where  trunc(attendance_date)=trunc(sysdate) and a.au_entry_hospital_pk_no = $ses_hospital_id
                               group by  trunc(attendance_date)"));
        $hr_chart_data = json_encode($hr_data);
        //Dashboard All Data

        $dashboard = DB::select(DB::raw("select dash_key,dash_value, heading_name from SYSC_DASHBOARDMST where TO_CHAR(dash_date,'MM')=TO_CHAR(sysdate,'MM') ")); // and au_entry_hospital_no_fk = '$ses_hospital_id'

        $dashboard_data = [];
        if (!empty($dashboard)) {
            foreach ($dashboard as  $value) {
                $dashboard_data[$value->dash_key] = $value->dash_value . "_" . $value->heading_name;
            }
        }

        $consultant_chart_data =  json_encode($consultant_chart_data);
        $purchase_requisition = DB::select(DB::raw("select
                                    mst.INV_REQUISITION_NO_PK,
                                    mst.INV_REQUISITION_DATE,
                                    ITEM_NO_FK,
                                    dtl.PVMSNO,
                                    dtl.ITEM_NAME,
                                    dtl.REQ_QUANTITY,
                                    mst.AU_ENTRY_BY,
                                    (ser.PURCHASE_PRICE * dtl.REQ_QUANTITY) Amount,
                                    us.user_name
                                    from INV_REQUISITIONMST mst join INV_REQUISITIONDTL dtl
                                    on mst.INV_REQUISITION_NO_PK=dtl.INV_REQUISITION_NO_fK
                                    join sysc_serviceitem ser
                                    on ser.item_no_pk=dtl.item_no_fk
                                    join wsec_user us
                                    on us.user_no_pk=mst.au_entry_by
                                    where to_char(mst.INV_REQUISITION_DATE,'mm')=to_char(sysdate,'MM') and mst.au_entry_hospital_pk_no = $ses_hospital_id "));
        $purchase_order = DB::select(DB::raw("select mst.PURCHASEORDER_NO_PK,
                                                mst.PURCHASE_DATE,
                                                mst.AU_ENTRY_BY,
                                                mst.INV_REQUISITION_NO_FK,
                                                chd.ENTRY_QTY,
                                                chd.approved_qty,
                                                us.user_name,
                                                ser.item_name,ser.sales_price
                                                from INV_PURCHASEORDER_MST mst join INV_PURCHASEORDER_CHD chd
                                                on mst.purchaseorder_no_pk=chd.purchaseorder_no_fk
                                                join sysc_serviceitem ser
                                                on ser.item_no_pk=chd.item_no_fk
                                                join wsec_user us
                                                on us.user_no_pk=mst.au_entry_by
                                                where to_char(mst.PURCHASE_DATE,'mm')=to_char(sysdate,'MM') and mst.au_entry_hospital_no_fk = $ses_hospital_id "));
        $marketing_data = DB::select(DB::raw("select act.activitydtl_date,
                                               per.full_name,
                                               mst.task_name,
                                               mst.task_des,act.task_note
                                          from hrms_personnel_actdtl act
                                               left join hrms_personnel per
                                                  on per.person_no_pk = act.person_no_fk
                                               left join hrms_personnel_actmst mst
                                                  on mst.activity_no_pk = activity_no_fk
                                                  where to_char (trunc (act.activitydtl_date), 'mm') = to_char (sysdate, 'mm')
                                                  and act.au_entry_hospital_pk_no = $ses_hospital_id
                                                  "));

        return template::loadview('admin.dashboards.management_dashboard_v3', [
            'service_unit' => $service_unit,
            'shift' => $shift,
            'consultant_data' => $consultant_data,
            'consultant_data_count' => $consultant_data_count,
            'consultant' => $consultant,
            'consultant_chart_data' => $consultant_chart_data,
            'dashboard_data' => $dashboard_data,
            'purchase_requisition' => $purchase_requisition,
            'purchase_order' => $purchase_order,
            'account_pie_chart' => $account_pie_chart,
            'hr_chart_data' => $hr_chart_data,
            'marketing_data' => $marketing_data
        ]);
    }

    public function investigationPopup($type, Request $request)
    {
        $type = $type;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $req_dept = DB::table("SYSC_SERVICEUNIT")->select('serviceunit_no_pk', 'serviceunit_name')->where('au_entry_hospital_pk_no',  $ses_hospital_id)->get()->toArray();
        $popup = DB::select(DB::raw("select dash_key,dash_value, heading_name from sysc_dashboardmst where au_entry_hospital_no_fk =  $ses_hospital_id"));
        $popup_sales_data = [];
        if (!empty($popup)) {
            foreach ($popup as  $value) {
                $popup_sales_data[$value->dash_key] = $value->dash_value . "_" . $value->heading_name;
            }
        }

        return template::loadview('admin.dashboards.investigation_popup', [
            'type'              => $type,
            'requestDepts'      => $req_dept,
            // 'pop_up_list_data'  => $pop_up_list_data,
            'popup_sales_data' =>  $popup_sales_data
        ]);
    }

    public function investigationPopupData(Request $request)
    {
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $where = "au_entry_hospital_pk_no =$hospital_id";

        if ($request->id == 1) {
            $table = 'management_popup';
            $primaryKey = 'person_no_pk';
            $columns = array(
                array('db' => 'person_no_pk', 'dt' => 0),
                array('db' => 'ledger_date', 'dt' => 1),
                array('db' => 'item_name', 'dt' => 2),
                array('db' => 'full_name', 'dt' => 3),
                array('db' => 'serviceunit_name', 'dt' => 4),
                array('db' => 'sales', 'dt' => 5),
                array('db' => 'amount', 'dt' => 6),
            );
            if (!empty($where)) {
                echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
            } else {

                echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
            }
            // echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        } elseif ($request->id == 2) {
            $table = 'management_popup_ipd_vw';
            $primaryKey = 'person_no_pk';
            $columns = array(
                array('db' => 'person_no_pk', 'dt' => 0),
                array('db' => 'ledger_date', 'dt' => 1),
                array('db' => 'item_name', 'dt' => 2),
                array('db' => 'full_name', 'dt' => 3),
                array('db' => 'serviceunit_name', 'dt' => 4),
                array('db' => 'sales', 'dt' => 5),
                array('db' => 'amount', 'dt' => 6),
            );
            if (!empty($where)) {
                echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
            } else {

                echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
            }
            // echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        } elseif ($request->id == 3) {
            $table = 'management_popup_phr';
            $primaryKey = 'person_no_pk';
            $columns = array(
                array('db' => 'person_no_pk', 'dt' => 0),
                array('db' => 'ledger_date', 'dt' => 1),
                array('db' => 'item_name', 'dt' => 2),
                array('db' => 'full_name', 'dt' => 3),
                array('db' => 'serviceunit_name', 'dt' => 4),
                array('db' => 'sales', 'dt' => 5),
                array('db' => 'amount', 'dt' => 6),
            );
            if (!empty($where)) {
                echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
            } else {

                echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
            }
            // echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        } elseif ($request->id == 4) {
            $table = 'management_popup_amb';
            $primaryKey = 'person_no_pk';
            $columns = array(
                array('db' => 'person_no_pk', 'dt' => 0),
                array('db' => 'ledger_date', 'dt' => 1),
                array('db' => 'item_name', 'dt' => 2),
                array('db' => 'full_name', 'dt' => 3),
                array('db' => 'serviceunit_name', 'dt' => 4),
                array('db' => 'sales', 'dt' => 5),
                array('db' => 'amount', 'dt' => 6),
            );
            if (!empty($where)) {
                echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
            } else {

                echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
            }
            // echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        } elseif ($request->id == 5) {
            $table = 'management_popup_others';
            $primaryKey = 'person_no_pk';
            $columns = array(
                array('db' => 'person_no_pk', 'dt' => 0),
                array('db' => 'ledger_date', 'dt' => 1),
                array('db' => 'item_name', 'dt' => 2),
                array('db' => 'full_name', 'dt' => 3),
                array('db' => 'serviceunit_name', 'dt' => 4),
                array('db' => 'sales', 'dt' => 5),
                array('db' => 'amount', 'dt' => 6),
            );
            if (!empty($where)) {
                echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
            } else {

                echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
            }
            // echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }

        //echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
    }






    public function date_factor(Request $request)
    {
        $to_date = $request->date_value;
        $consultant_data = db::select("select a.appoint_date,a.doctor_no_fk,
                                       a.doctor_room_in,
                                      a.doctor_room_in_time,
                                       a.doctor_room_out,
                                      a.doctor_room_out_time,
                                       per.degree1,
                                       per.degree2,
                                       per.degree3,
                                       per.degree4,
                                       per.salutation,
                                        ser.serviceunit_name,
                                             to_char (a.start_time, 'hh24:mi:ss') start_time,
                                             to_char (a.end_time, 'hh24:mi:ss') end_time,
                                             a.doctor_name,
                                             sum (case when a.appoint_type_code = 'newcons' then 1 else 0 end)
                                                total_new,
                                             sum (case when a.appoint_type_code = 'followup' then 1 else 0 end)
                                                total_followup
                                        from doctor_wise_appoint_consult_vw a
                                        left join sysc_serviceunit ser
                                        on ser.serviceunit_no_pk = a.su_no_fk
                                         left join hrms_personnel per
                                          on a.doctor_no_fk = per.person_no_pk
                                       where a.status = 1
                                             and trunc(a.appoint_date) = TO_DATE('$to_date','MM/DD/YYYY')
                                    group by a.appoint_date,
                                       a.doctor_room_in,
                                      a.doctor_room_in_time,
                                       a.doctor_room_out,
                                      a.doctor_room_out_time,
                                       per.degree1,
                                       per.degree2,
                                       per.degree3,
                                       per.degree4,
                                       a.start_time,
                                       a.end_time,
                                        a.doctor_name,ser.serviceunit_name,
                                        per.salutation,a.doctor_no_fk ");
        //        dd($consultant_data);
        return template::loadview('admin.dashboards.consultant_data', ['consultant_data' => $consultant_data]);
    }
    public function shift_factor(Request $request)
    {
        $shift = $request->shift_value;
        //        $consultant_data = DB::table('doctor_wise_appoint_consult_vw')->where('schedule_no_fk', $request->shift_value)->get();
        $consultant_data = DB::select("select a.appoint_date,a.doctor_no_fk,
                                       a.doctor_room_in,
                                      a.doctor_room_in_time,
                                       a.doctor_room_out,
                                      a.doctor_room_out_time,
                                       per.degree1,
                                       per.degree2,
                                       per.degree3,
                                       per.degree4,
                                       per.salutation,
                                        ser.serviceunit_name,
                                             to_char (a.start_time, 'hh24:mi:ss') start_time,
                                             to_char (a.end_time, 'hh24:mi:ss') end_time,
                                             a.doctor_name,
                                             sum (case when a.appoint_type_code = 'newcons' then 1 else 0 end)
                                                total_new,
                                             sum (case when a.appoint_type_code = 'followup' then 1 else 0 end)
                                                total_followup
                                        from doctor_wise_appoint_consult_vw a
                                        left join sysc_serviceunit ser
                                        on ser.serviceunit_no_pk = a.su_no_fk
                                         left join hrms_personnel per
                                          on a.doctor_no_fk = per.person_no_pk
                                       where a.status = 1
                                             and a.shift_no_fk = '$shift'
                                    group by a.appoint_date,
                                       a.doctor_room_in,
                                      a.doctor_room_in_time,
                                       a.doctor_room_out,
                                      a.doctor_room_out_time,
                                       per.degree1,
                                       per.degree2,
                                       per.degree3,
                                       per.degree4,
                                       a.start_time,
                                       a.end_time,
                                        a.doctor_name,ser.serviceunit_name,
                                        per.salutation,a.doctor_no_fk");
        //        dd($consultant_data);
        return template::loadview('admin.dashboards.consultant_data', ['consultant_data' => $consultant_data]);
    }
    public function service_factor(Request $request)
    {
        //        $consultant_data = DB::table('doctor_wise_appoint_consult_vw')->where('su_no_fk', $request->service_value)->get();
        $service = $request->service_value;
        $consultant_data = DB::select("select a.appoint_date,a.doctor_no_fk,
                                       a.doctor_room_in,
                                      a.doctor_room_in_time,
                                       a.doctor_room_out,
                                      a.doctor_room_out_time,
                                       per.degree1,
                                       per.degree2,
                                       per.degree3,
                                       per.degree4,
                                       per.salutation,
                                        ser.serviceunit_name,
                                             to_char (a.start_time, 'hh24:mi:ss') start_time,
                                             to_char (a.end_time, 'hh24:mi:ss') end_time,
                                             a.doctor_name,
                                             sum (case when a.appoint_type_code = 'newcons' then 1 else 0 end)
                                                total_new,
                                             sum (case when a.appoint_type_code = 'followup' then 1 else 0 end)
                                                total_followup
                                        from doctor_wise_appoint_consult_vw a
                                        left join sysc_serviceunit ser
                                        on ser.serviceunit_no_pk = a.su_no_fk
                                         left join hrms_personnel per
                                          on a.doctor_no_fk = per.person_no_pk
                                       where a.status = 1
                                             and ser.serviceunit_no_pk = '$service'
                                    group by a.appoint_date,
                                       a.doctor_room_in,
                                      a.doctor_room_in_time,
                                       a.doctor_room_out,
                                      a.doctor_room_out_time,
                                       per.degree1,
                                       per.degree2,
                                       per.degree3,
                                       per.degree4,
                                       a.start_time,
                                       a.end_time,
                                        a.doctor_name,ser.serviceunit_name,
                                        per.salutation,a.doctor_no_fk ");
        return template::loadview('admin.dashboards.consultant_data', ['consultant_data' => $consultant_data]);
    }
    //    Pie chart
    public function hr_pie_chart()
    {
        $hr_admin = DB::select("SELECT
             TRUNC(ATTENDANCE_DATE) ATTENDANCE_DATE,
            COUNT(A.PERSON_NO_FK) TOTAL_EMP,
            SUM(CASE WHEN TRUNC(A.ATTENDANCE_DATE)=TRUNC(SYSDATE) AND ATTENDANCE_STATUS IN (1,2) THEN 1 ELSE 0 END)  PRESENT,
            SUM(CASE WHEN   TRUNC(A.ATTENDANCE_DATE)=TRUNC(SYSDATE) AND A.ATTENDANCE_STATUS=2 THEN 1 ELSE 0 END) LATE,
            SUM(CASE WHEN   TRUNC(A.ATTENDANCE_DATE)=TRUNC(SYSDATE) AND A.ATTENDANCE_STATUS=5 THEN 1 ELSE 0 END) LEAVE,
            SUM(CASE WHEN   TRUNC(A.ATTENDANCE_DATE)=TRUNC(SYSDATE) AND A.ATTENDANCE_STATUS=7 THEN 1 ELSE 0 END) OFFDAY
            FROM HRMS_ATTENDANCE_DAILY A LEFT JOIN HRMS_PERSONNEL P
            ON A.PERSON_NO_FK=P.PERSON_NO_PK
            WHERE  TRUNC(ATTENDANCE_DATE)=TRUNC(SYSDATE)
            GROUP BY  TRUNC(ATTENDANCE_DATE)
            ORDER BY TRUNC(ATTENDANCE_DATE), 1");
        return json_encode($hr_admin);
    }

    //dashboard refresh
    public function refresh()
    {
        // procedure start
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            $pdo = DB::getPdo();
            $dashdata = $pdo->prepare("begin pkg_tools.prc_exec_dashboard_keyquery(:in_au_entry_hospital_pk_no) ; end;");
            $dashdata->bindParam(':in_au_entry_hospital_pk_no', $hospital_id);
            $dashdata->execute();
            DB::commit();
        } catch (\Exception $e) {
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            return response()->json($message);
            DB::rollback();
        }
        return redirect()->route("db.v1");
        // endProcedure
    }

    //dashboard refresh
    public function pharmacyRefresh()
    {
        // procedure start

        $hospital_id = Session::get('user.ses_hospital_no_pk');

        DB::beginTransaction();
        try {
            $procedureName = "pkg_tools.prc_exec_dashboard_keyquery";
            $dataBindingArr = [
                'in_au_entry_hospital_pk_no' => $hospital_id,
            ];

            $result = DB::executeProcedure($procedureName, $dataBindingArr);


            DB::commit();
            return redirect()->route("pharmacy.dashboard");
        } catch (\Exception $e) {


            DB::rollback();
        }
        // endProcedure

    }
    //    search
    public function searchData(Request $request)
    {
        $type = $request->type;
        $doctor_id = $request->doctor_id;
        $item_id = $request->item_id;
        $dept = $request->department_wise_filter;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($doctor_id != "") ? " $clause per.person_no_pk = $doctor_id" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($item_id != "") ? " $clause  item.item_code = '$item_id'" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($dept != "") ? " $clause ser.serviceunit_no_pk = $dept" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(mst.ledger_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= "$clause mst.au_entry_hospital_pk_no=$ses_hospital_id";
        //dd($sql_cond);

        if ($type == '1') {
            $pop_up_list_data = DB::select("select  mst.ledger_date,(
                CASE
                   WHEN itm.ITEM_TYPE = 'LAB' THEN dtl.LEDGERDTL_AMT_SALES
                   ELSE 0
                END)
               +
            ( (
                CASE
                   WHEN itm.ITEM_TYPE = 'RAD' THEN dtl.LEDGERDTL_AMT_SALES
                   ELSE 0
                END))
               sales ,
               ROUND (
                (
                  CASE
                     WHEN itm.ITEM_TYPE = 'LAB' THEN dtl.LEDGERDTL_AMT_PAYMENT
                     ELSE 0
                  END),
               2)
               +
            ROUND (
                (
                  CASE
                     WHEN itm.ITEM_TYPE = 'RAD' THEN dtl.LEDGERDTL_AMT_PAYMENT
                     ELSE 0
                  END),
               2)
               amount  ,
                (
               CASE
                  WHEN itm.ITEM_TYPE = 'LAB' THEN dtl.LEDGERDTL_AMT_DISCOUNT
                  ELSE 0
               END)
                +
               (
               CASE
                  WHEN itm.ITEM_TYPE = 'RAD' THEN dtl.LEDGERDTL_AMT_DISCOUNT
                  ELSE 0
               END)
               discount,
               itm.item_name,
               PER.FULL_NAME,
               ser.serviceunit_name from finc_ledgermst mst
               join finc_ledgerdtl dtl on
               mst.ledger_no_pk=dtl.ledger_no_fk join sysc_serviceitem itm
               on dtl.item_no_fk=itm.item_no_pk
               join sysc_serviceunit ser
               on ser.serviceunit_no_pk=itm.SERVICEUNIT_NO_FK
                join hrms_personnel per
               on MST.PATIENT_NO_FK = PER.PERSON_NO_PK
                WHERE TO_CHAR (TRUNC (dtl.ledgerdtl_date), 'MM') = TO_CHAR (SYSDATE, 'MM') $sql_cond
            ");
        } elseif ($type == '2') {
            $pop_up_list_data = DB::select("select  mst.ledger_date,(
               CASE
                  WHEN itm.ITEM_TYPE IN ('IPD', 'BED', 'OT')
                  THEN
                     dtl.LEDGERDTL_AMT_SALES
                  ELSE
                     0
               END)
               sales,
               CASE
                  WHEN itm.ITEM_TYPE IN ('IPD', 'BED', 'OT')
                  THEN
                     dtl.LEDGERDTL_AMT_PAYMENT
                  ELSE
                     0
               END
               amount  ,
               CASE
                  WHEN itm.ITEM_TYPE IN ('IPD', 'BED', 'OT')
                  THEN
                     dtl.LEDGERDTL_AMT_DISCOUNT
                  ELSE
                     0
               END
               discount,
               itm.item_name,
               PER.FULL_NAME,
               ser.serviceunit_name from finc_ledgermst mst
               join finc_ledgerdtl dtl on
               mst.ledger_no_pk=dtl.ledger_no_fk join sysc_serviceitem itm
               on dtl.item_no_fk=itm.item_no_pk
               join sysc_serviceunit ser
               on ser.serviceunit_no_pk=itm.SERVICEUNIT_NO_FK
                join hrms_personnel per
               on MST.PATIENT_NO_FK = PER.PERSON_NO_PK
                WHERE TO_CHAR (TRUNC (dtl.ledgerdtl_date), 'MM') = TO_CHAR (SYSDATE, 'MM')  $sql_cond");
        } elseif ($type == '3') {
            $pop_up_list_data = DB::select("SELECT FINC_SUMMARYSTATEMENT_DT_VW.*, ROUND(LEDGERDTL_AMT_PAYMENT_PHR) FROM FINC_SUMMARYSTATEMENT_DT_VW WHERE to_char(TRUNC(INVOICE_DATE),'MM')=to_char(sysdate,'MM')");
        } elseif ($type == '4') {
            $pop_up_list_data = DB::select("select  mst.ledger_date,(
               CASE
                  WHEN itm.ITEM_TYPE = 'AMB' THEN dtl.LEDGERDTL_AMT_SALES
                  ELSE 0
               END)
               sales,
              CASE
                  WHEN itm.ITEM_TYPE = 'AMB' THEN dtl.LEDGERDTL_AMT_PAYMENT
                  ELSE 0
               END
               amount  ,
              CASE
                  WHEN itm.ITEM_TYPE = 'AMB' THEN dtl.LEDGERDTL_AMT_DISCOUNT
                  ELSE 0
               END
               discount,
               itm.item_name,
               PER.FULL_NAME,
               ser.serviceunit_name from finc_ledgermst mst
               join finc_ledgerdtl dtl on
               mst.ledger_no_pk=dtl.ledger_no_fk join sysc_serviceitem itm
               on dtl.item_no_fk=itm.item_no_pk
               join sysc_serviceunit ser
               on ser.serviceunit_no_pk=itm.SERVICEUNIT_NO_FK
                join hrms_personnel per
               on MST.PATIENT_NO_FK = PER.PERSON_NO_PK
                WHERE TO_CHAR (TRUNC (dtl.ledgerdtl_date), 'MM') = TO_CHAR (SYSDATE, 'MM')  $sql_cond");
        } elseif ($type == '5') {
            $pop_up_list_data = DB::select("select  mst.ledger_date,(
               CASE
                  WHEN itm.ITEM_TYPE NOT IN
                          ('CON',
                           'SERVICE',
                           'LAB',
                           'RAD',
                           'AMB',
                           'IPD',
                           'BED',
                           'OT',
                           'MED')
                  THEN
                     dtl.LEDGERDTL_AMT_SALES
                  ELSE
                     0
               END)
               sales,
             CASE
                  WHEN itm.ITEM_TYPE NOT IN
                          ('CON',
                           'SERVICE',
                           'LAB',
                           'RAD',
                           'AMB',
                           'IPD',
                           'BED',
                           'OT',
                           'MED')
                  THEN
                     dtl.LEDGERDTL_AMT_PAYMENT
                  ELSE
                     0
               END
               amount  ,
              CASE
                  WHEN itm.ITEM_TYPE NOT IN
                          ('CON',
                           'SERVICE',
                           'LAB',
                           'RAD',
                           'AMB',
                           'IPD',
                           'BED',
                           'OT',
                           'MED')
                  THEN
                     dtl.LEDGERDTL_AMT_DISCOUNT
                  ELSE
                     0
               END
               discount,
               itm.item_name,
               PER.FULL_NAME,
               ser.serviceunit_name from finc_ledgermst mst
               join finc_ledgerdtl dtl on
               mst.ledger_no_pk=dtl.ledger_no_fk join sysc_serviceitem itm
               on dtl.item_no_fk=itm.item_no_pk
               join sysc_serviceunit ser
               on ser.serviceunit_no_pk=itm.SERVICEUNIT_NO_FK
                join hrms_personnel per
               on MST.PATIENT_NO_FK = PER.PERSON_NO_PK
                WHERE TO_CHAR (TRUNC (dtl.ledgerdtl_date), 'MM') = TO_CHAR (SYSDATE, 'MM')  $sql_cond");
        }
        return Template::loadView("admin.dashboards.dashboard_popup_list", [
            'pop_up_list_data'  => $pop_up_list_data,
            'type' => $type
        ]);
    }
    public  function dashboardEmployees($type)
    {
        $type = $type;
        $popup_total_manpower = DB::select(DB::raw('select dash_key,dash_value, heading_name from sysc_dashboardmst'));
        $popup_total_manpower_sales_data = [];
        if (!empty($popup_total_manpower)) {
            foreach ($popup_total_manpower as  $value) {
                $popup_total_manpower_sales_data[$value->dash_key] = $value->dash_value . "_" . $value->heading_name;
            }
        }
        if ($type == '2') {
            $hr_list_data = DB::select("select * from HRMS_ATTENDANCE_DAILY_VW where ATTENDANCE_STATUS= 2 and ATTENDANCE_DATE=trunc(sysdate)");
        } elseif ($type == '3') {
            $hr_list_data = DB::select("select * from HRMS_ATTENDANCE_DAILY_VW where ATTENDANCE_STATUS= 3 and ATTENDANCE_DATE=trunc(sysdate)");
        } elseif ($type == '4') {
            $hr_list_data = DB::select("select * from HRMS_ATTENDANCE_DAILY_VW where ATTENDANCE_STATUS= 4 and ATTENDANCE_DATE=trunc(sysdate)");
        } elseif ($type == '5') {
            $hr_list_data = DB::select("select * from HRMS_ATTENDANCE_DAILY_VW where ATTENDANCE_STATUS= 5 and ATTENDANCE_DATE=trunc(sysdate)");
        } elseif ($type == '6') {
            $hr_list_data = DB::select("select * from HRMS_ATTENDANCE_DAILY_VW where ATTENDANCE_STATUS= 6 and ATTENDANCE_DATE=trunc(sysdate)");
        }

        $req_dept = DB::table("SYSC_SERVICEUNIT")->select('serviceunit_no_pk', 'serviceunit_name')->get()->toArray();


        return Template::loadView('admin.dashboards.hr.total_manpower', [
            'requestDepts' => $req_dept,
            'type' => $type,
            'hr_data' => $hr_list_data,
            'popup_total_manpower_sales_data' => $popup_total_manpower_sales_data
        ]);
    }
    public function dashboardsearchData(Request $request)
    {
        // dd($request->all());
        $type = $request->type;
        $dept = $request->department_wise_filter;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($dept != "") ? " $clause serviceunit_no_fk = $dept" : "";
        $clause = ($sql_cond == "") ? " and" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ATTENDANCE_DATE) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
        if ($type == '2') {
            $hr_list_data = DB::select("select * from HRMS_ATTENDANCE_DAILY_VW where ATTENDANCE_STATUS= 2 and ATTENDANCE_DATE=trunc(sysdate) $sql_cond");
        } elseif ($type == '3') {
            $hr_list_data = DB::select("select * from HRMS_ATTENDANCE_DAILY_VW where ATTENDANCE_STATUS= 3 and ATTENDANCE_DATE=trunc(sysdate) $sql_cond");
        } elseif ($type == '4') {
            $hr_list_data = DB::select("select * from HRMS_ATTENDANCE_DAILY_VW where ATTENDANCE_STATUS= 4 and ATTENDANCE_DATE=trunc(sysdate) $sql_cond");
        } elseif ($type == '5') {
            $hr_list_data = DB::select("select * from HRMS_ATTENDANCE_DAILY_VW where ATTENDANCE_STATUS= 5 and ATTENDANCE_DATE=trunc(sysdate) $sql_cond");
        } elseif ($type == '6') {
            $hr_list_data = DB::select("select * from HRMS_ATTENDANCE_DAILY_VW where ATTENDANCE_STATUS= 6 and ATTENDANCE_DATE=trunc(sysdate) $sql_cond");
        }
        return Template::loadView('admin.dashboards.hr.hr_list_data', [
            'hr_data' => $hr_list_data,
        ]);
    }
    public function commonDashboard(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $appointments = DB::select(DB::raw("select app.full_name,
                                                    app.gender_txt,
                                                    app.mobile1,
                                                    app.patient_dob,
                                                    app.patient_name,
                                                    app.patient_no_pk,
                                                    app.patient_photo,
                                                    app.start_time,
                                                    app.end_time,
                                                    pat.call_ind,
                                                    pat.email_ind,
                                                    pat.sms_ind,app.specialization
                                                from    dash_patn_app_vw app
                                                    left join
                                                        pat_history_tracking pat
                                                    on app.patient_no_pk = pat.patient_no_fk  where app.au_entry_hospital_pk_no = $ses_hospital_id  order by app.appoint_no_pk desc "));
            //        dd($appointments);
            $last_day_appointment = db::select(db::raw("select patient_name,

                                                            gender_txt,
                                                            patient_dob,
                                                            blood_group,
                                                            age,
                                                            mobile1,
                                                            doctor_no_fk,
                                                            full_name,
                                                            specialization,
                                                            patient_photo,
                                                            patient_no_pk
                                                        from patn_appointment_vw
                                                        where appoint_date = trunc (sysdate - 1) and au_entry_hospital_pk_no  = $ses_hospital_id "));
            $unattendant_patients = db::select(db::raw("select * from psn_unattent_pat_list where
            APPOINT_STATUS = 3 and au_entry_hospital_pk_no  = $ses_hospital_id
            and appoint_date between trunc (sysdate - 7) and trunc (sysdate)"));

            $unattendant_patients_last = db::select(db::raw("select * from psn_unattent_pat_list
            where appoint_date between trunc (sysdate - 14) and trunc (sysdate -7 ) and au_entry_hospital_pk_no  = $ses_hospital_id"));

            $follow_up = db::select(db::raw("select * from psn_followup_vw
            where trunc (next_followup_dt) between trunc (sysdate) and trunc (sysdate + 7)
            order by next_followup_dt asc"));
            $last_s_followup = db::select(db::raw("select * from psn_followup_vw  where trunc (next_followup_dt) between trunc (sysdate - 7) and trunc (sysdate) order by next_followup_dt asc"));
            $schedules_doctors = db::table('dash_doctor_schdule_vw')->where('au_entry_hospital_pk_no', $ses_hospital_id)->where('schedule_dt', carbon::today())->whereNotNull('person_no_pk')->get();
            $all_doctors = db::select("select distinct person_no_pk,full_name from dash_doctor_schdule_vw where au_entry_hospital_pk_no = $ses_hospital_id ");
            $dueCollectionData = DB::table('finc_summarystatement_dt_vw')->where(DB::raw('trunc(invoice_date)'), date('Y-m-d'))->first();


            return Template::loadview("admin.uhl.dashboard", [
                'appointments' => $appointments,
                'unattendant_patients' => $unattendant_patients,
                'schedules_doctors' => $schedules_doctors,
                'all_doctors' => $all_doctors,
                'last_day_appointment' => $last_day_appointment,
                'unattendant_patients_last' => $unattendant_patients_last,
                "follow_up" => $follow_up,
                "last_s_followup" => $last_s_followup,
                "dueCollectionData" => $dueCollectionData,
            ]);
    }
}
