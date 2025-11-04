<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Exception;
use App\Library\Template;
use Illuminate\Support\Facades\DB;
use App\Models\ItemType;
use App\Models\ExamForeignDTL;
use App\Models\ServiceUnit;
use App\Traits\DatatablesLoader;
use Cache;
use PDF;
use PDO;
use Auth;
use App;
use Session;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use App\Traits\LookupData;

class FinancialReportController extends Controller
{
    use LookupData;
    public function __construct()
    {
        $this->middleware('auth');
    }
    public function itemWiseFincReport()
    {
        $to_date = date('Y-m-d');
        $data = DB::table('finc_inv_itemdtl_vw')->select(DB::raw('sum(current_item_qty) as current_item_qty'), DB::raw('sum(total_item_amt) as total_item_amt'), DB::raw('sum(disc_amount) as disc_amount'), DB::raw('sum(ledgerdtl_amt_payment) as ledgerdtl_amt_payment'), 'item_name', 'serviceunit_no_fk', 'serviceunit_name')->groupBy('item_name', 'serviceunit_no_fk', 'serviceunit_name')->whereIn('module_code', ["OPD", 'IPD'])->where(DB::raw('trunc(invoice_date)'), $to_date)->get();
        $serviceUnitData = [];
        $service_unit = DB::table('sysc_serviceunit')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', 1)->get();
        $module_code = DB::table('sysc_module')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('status', 1)
            ->get();

        $item_type =DB::table('item_type_vw')->select('item_name',  'itemtype_no_pk','itemtype_code')->get();
        //  DB::table('sysc_lookup_data')->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_desc')->where('status', 1)->where('lookup_code', 'ITEMTYPE')->get();
        // $item_type = DB::table('sysc_itemtype_workflow')->select('workflow_no_pk', 'workflow_code', 'workflow_name')->where('status', 1)->get();
        return Template::loadView("admin.reports.pharmacy.itemWiseFincReport", ['serviceUnitData' => $serviceUnitData, 'service_unit' => $service_unit, 'module_code' => $module_code, 'item_type' => $item_type]);
    }
    public function financialReportData(Request $request)
    {
        $hospital_info = DB::table("wsec_hospital")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $form_date = date('Y-m-d', strtotime($request->date_from));
        $to_date = date('Y-m-d', strtotime($request->date_to));
        $department = $request->department;
        $module = $request->module;
        $item_type = $request->item_type;
        $item_id = $request->item_id;
        // DB::raw('sum(nvl(item_qty,0)-nvl(cancel_qty,0)) as current_item_qty')
        $data = DB::table('core_c026_sum_dt_invitm_aut_vw')
            ->select(DB::raw('sum(nvl(item_qty,0)-nvl(cancel_qty,0)) as current_item_qty'), DB::raw('sum(case when trunc(ledgertrn_date)=trunc(invoice_date) then nvl(item_qty,0)-nvl(cancel_qty,0) else 0 end) as todays_item_qty'), DB::raw('sum(nvl(net_item_cost,0)-nvl(item_wise_service,0)) as total_item_amt'), DB::raw('sum(item_wise_discount) as disc_amount'), DB::raw('sum(item_wise_collection) as ledgerdtl_amt_payment'), DB::raw('sum(item_wise_service) as service_charge'), 'item_name', 'serviceunit_no_fk', 'serviceunit_name', 'item_no_fk')->orderBy('item_name', 'asc')->groupBy('item_name', 'serviceunit_no_fk', 'serviceunit_name', 'item_no_fk')
            ->whereRaw("trunc(ledgertrn_date) between '$form_date' and '$to_date'");
            // ->where('net_collection_amt', '!=', 0);
            //->where(DB::raw('nvl(cancel_ind,0)'),'!=',1);

        if ($department != "") {
            $data->where(function ($query) use ($department) {
                $query->where('serviceunit_no_fk', '=', $department);
            });
        }

        if ($module != "") {
            if ($module == "PHR") {
                $data->where(function ($query) use ($module) {
                    //$query->whereIn('module_code', ['PHR', 'PHR-I']);
                });
            } else {
                $data->where(function ($query) use ($module) {
                    //$query->where('module_code', '=',  $module);
                });
            }
        }

        if ($item_type != "") {

            $data->where(function ($query) use ($item_type) {

                $query->where('item_type', '=',  $item_type);
            });
        }
        if ($item_id != "") {

            $data->where(function ($query) use ($item_id) {
                $query->where('item_no_fk', '=',  $item_id);
            });
        }


        $serviceUnitData = [];
        foreach ($data->get() as  $value) {
            $serviceUnitData[$value->serviceunit_no_fk . '_' . $value->serviceunit_name][] = $value;
        }
        // dd($serviceUnitData);

        return Template::loadView("admin.reports.pharmacy.itemWiseFincReport_table", ['serviceUnitData' => $serviceUnitData, 'form_date' => $form_date, 'to_date' => $to_date, 'department' => $department, 'hospital_info' => $hospital_info]);
    }
    public function itemWiseFincReportPdf(Request $request)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $form_date = date('Y-m-d', strtotime($request->date_from));
        $to_date = date('Y-m-d', strtotime($request->date_to));
        $department = $request->department;
        $module = $request->module;
        $item_type = $request->item_type;
        $item_id = $request->item_id;
        // $data = DB::table('core_c025_finc_invoice_item_vw')->select(DB::raw('sum(item_qty) as current_item_qty'), DB::raw('sum(item_sales_amt) as total_item_amt'), DB::raw('sum(item_wise_discount) as disc_amount'), DB::raw('sum(item_wise_collection) as ledgerdtl_amt_payment'), DB::raw('sum(item_wise_service) as service_charge'), 'item_name', 'serviceunit_no_fk', 'serviceunit_name', 'item_no_fk')->groupBy('item_name', 'serviceunit_no_fk', 'serviceunit_name', 'item_no_fk')
        //     // ->whereIn('module_code',["OPD",'IPD','PHR','PHR-I'])
        //     ->whereRaw("trunc(invoice_date) between '$form_date' and '$to_date'")
        //     ->where(DB::raw('nvl(cancel_ind,0)'),'!=',1);


        // $data = DB::table('core_c026_sum_dt_invitm_aut_vw')->select(DB::raw('sum(item_qty) as current_item_qty'), DB::raw('sum(net_item_cost) as total_item_amt'), DB::raw('sum(item_wise_discount) as disc_amount'), DB::raw('sum(item_wise_collection) as ledgerdtl_amt_payment'), DB::raw('sum(item_wise_service) as service_charge'), 'item_name', 'serviceunit_no_fk', 'serviceunit_name', 'item_no_fk')->groupBy('item_name', 'serviceunit_no_fk', 'serviceunit_name', 'item_no_fk')

        //     ->whereRaw("trunc(ledgertrn_date) between '$form_date' and '$to_date'");

        $data = DB::table('core_c026_sum_dt_invitm_aut_vw')->select(DB::raw('sum(nvl(item_qty,0)-nvl(cancel_qty,0)) as current_item_qty'), DB::raw('sum(case when trunc(ledgertrn_date)=trunc(invoice_date) then nvl(item_qty,0)-nvl(cancel_qty,0) else 0 end) as todays_item_qty'), DB::raw('sum(nvl(net_item_cost,0)-nvl(item_wise_service,0)) as total_item_amt'), DB::raw('sum(item_wise_discount) as disc_amount'), DB::raw('sum(item_wise_collection) as ledgerdtl_amt_payment'), DB::raw('sum(item_wise_service) as service_charge'), 'item_name', 'serviceunit_no_fk', 'serviceunit_name', 'item_no_fk')->groupBy('item_name', 'serviceunit_no_fk', 'serviceunit_name', 'item_no_fk')
            // ->whereIn('module_code',["OPD",'IPD','PHR','PHR-I'])
            ->whereRaw("trunc(ledgertrn_date) between '$form_date' and '$to_date'");
            // ->where('net_collection_amt', '!=', 0);


        if ($department != "") {
            $data->where(function ($query) use ($department) {
                $query->where('serviceunit_no_fk', '=', $department);
            });
        }
        if ($module != "") {
            if ($module == "PHR") {
                $data->where(function ($query) use ($module) {
                    //  $query->whereIn('module_code', ['PHR', 'PHR-I']);
                });
            } else {
                $data->where(function ($query) use ($module) {
                    // $query->where('module_code', '=',  $module);
                });
            }
        }
        if ($item_type != "") {

            $data->where(function ($query) use ($item_type) {
                $query->where('item_type', '=',  $item_type);
            });
        }
        if ($item_id != "") {

            $data->where(function ($query) use ($item_id) {
                $query->where('item_no_fk', '=',  $item_id);
            });
        }

        // dd( $data->get(),$form_date ,$to_date);
        $serviceUnitData = [];
        foreach ($data->get() as  $value) {
            $serviceUnitData[$value->serviceunit_no_fk . '_' . $value->serviceunit_name][] = $value;
        }
        // dd($serviceUnitData);
        $pdf = PDF::loadView("admin.reports.pharmacy.item_wise_financial_pdf", ['serviceUnitData' => $serviceUnitData, 'form_date' => $form_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrait');
        return $pdf->stream('item_wise_financial_pdf.pdf');
    }

    public function itemWiseFincReportDtl($form_date = "", $to_date = "", $item_no)
    {
        // dd($item_no);
        $form_date_data = date('Y-m-d', strtotime($form_date));
        $to_date_data = date('Y-m-d', strtotime($to_date));
        $item_no_fk = $item_no;
        $data = DB::table('core_c026_sum_dt_invitm_aut_vw')
            ->select(DB::raw("invoice_date,item_name,item_rate,sum(nvl(item_qty,0)-nvl(cancel_qty,0)) as current_item_qty,sum(item_wise_discount) as disc_amount,sum(item_wise_service) as service_charge,sum(item_wise_collection) as ledgerdtl_amt_payment,invoice_no_pk"))
            ->where('item_no_fk', $item_no_fk)
            ->where('net_collection_amt', '!=', 0)
            ->whereBetween(DB::raw('trunc(ledgertrn_date)'), [$form_date_data, $to_date_data])
            ->groupByRaw('invoice_date,item_name,item_rate,invoice_no_pk')
            ->orderBy('invoice_date', 'desc')
            ->get();
        // dd($data);
        return Template::loadView("admin.reports.pharmacy.itemWiseFincReportDtl", ['form_date' => $form_date, 'to_date' => $to_date, 'data' => $data, 'item_no_fk' => $item_no_fk]);
    }


    public function itemWiseFincReportDtlPdf($form_date = "", $to_date = "", $item_no)
    {
        // dd("item_no_fk");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        // $item_no_fk = $item_no;
        $form_date_data = date('Y-m-d', strtotime($form_date));
        $to_date_data = date('Y-m-d', strtotime($to_date));
        $item_no_fk = $item_no;
        $data = DB::table('core_c026_sum_dt_invitm_aut_vw')
            ->select(DB::raw("invoice_date,item_name,item_rate,sum(nvl(item_qty,0)-nvl(cancel_qty,0)) as current_item_qty,sum(item_wise_discount) as disc_amount,sum(item_wise_service) as service_charge,sum(item_wise_collection) as ledgerdtl_amt_payment,invoice_no_pk"))
            ->where('item_no_fk', $item_no_fk)
            ->where('net_collection_amt', '!=', 0)
            ->whereBetween(DB::raw('trunc(ledgertrn_date)'), [$form_date_data, $to_date_data])
            ->groupByRaw('invoice_date,item_name,item_rate,invoice_no_pk')
            ->orderBy('invoice_date', 'desc')
            ->get();
        // dd($data);
        $pdf = PDF::loadView("admin.reports.pharmacy.itemWiseFincReportDtlPdf", ['po_hospital_details' => $po_hospital_details, 'form_date' => $form_date, 'to_date' => $to_date, 'data' => $data, 'item_no_fk' => $item_no_fk]);
        return $pdf->stream('item_wise_financial_details_pdf.pdf');
    }


    // Item wise financial count

    public function itemWiseFincCount()
    {
        $to_date = date('Y-m-d');
        $data = DB::table('finc_inv_itemdtl_vw')->select(DB::raw('sum(current_item_qty) as current_item_qty'), DB::raw('sum(total_item_amt) as total_item_amt'), DB::raw('sum(disc_amount) as disc_amount'), DB::raw('sum(ledgerdtl_amt_payment) as ledgerdtl_amt_payment'), 'item_name', 'serviceunit_no_fk', 'serviceunit_name')->groupBy('item_name', 'serviceunit_no_fk', 'serviceunit_name')->whereIn('module_code', ["OPD", 'IPD'])->where(DB::raw('trunc(invoice_date)'), $to_date)->get();
        $serviceUnitData = [];
        $service_unit = DB::table('sysc_serviceunit')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where('status', 1)->get();
        $module_code = DB::table('sysc_module')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('status', 1)
            ->get();

        $item_type =DB::table('item_type_vw')->select('item_name',  'itemtype_no_pk','itemtype_code')->get();
        //  DB::table('sysc_lookup_data')->select('lookupdata_no_pk', 'lookupdata_code', 'lookupdata_desc')->where('status', 1)->where('lookup_code', 'ITEMTYPE')->get();
        // $item_type = DB::table('sysc_itemtype_workflow')->select('workflow_no_pk', 'workflow_code', 'workflow_name')->where('status', 1)->get();
        return Template::loadView("admin.reports.pharmacy.itemWiseFincCount", ['serviceUnitData' => $serviceUnitData, 'service_unit' => $service_unit, 'module_code' => $module_code, 'item_type' => $item_type]);
    }

    public function financialCountData(Request $request)
    {

        $hospital_info = DB::table("wsec_hospital")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $form_date = date('Y-m-d', strtotime($request->date_from));
        $to_date = date('Y-m-d', strtotime($request->date_to));
        $department = $request->department;
        $module = $request->module;
        $item_type = $request->item_type;
        $item_id = $request->item_id;
        $data = DB::table('finc_invoicedtl_detail_vw')->select(DB::raw('sum(item_qty-nvl(cancel_qty,0)) as item_qty'), 'finc_invoicedtl_detail_vw.ity_group_header_name', 'finc_invoicedtl_detail_vw.item_no_fk', 'finc_invoicedtl_detail_vw.item_serviceunit_no_fk', 'finc_invoicedtl_detail_vw.item_serviceunit_name', 'finc_invoicedtl_detail_vw.item_name', 'finc_invoicedtl_detail_vw.item_type')->orderBy('item_name', 'asc')->groupBy('ity_group_header_name', 'item_serviceunit_no_fk', 'item_serviceunit_name', 'item_name', 'item_type', 'item_no_fk')->whereBetween(DB::raw('trunc(invoice_date)'), [$form_date, $to_date]);

        if ($department != "") {
            $data->where(function ($query) use ($department) {
                $query->where('su_no_fk', '=', $department);
            });
        }

        if ($module != "") {
            if ($module == "PHR") {
                $data->where(function ($query) use ($module) {
                    //$query->whereIn('module_code', ['PHR', 'PHR-I']);
                });
            } else {
                $data->where(function ($query) use ($module) {
                    //$query->where('module_code', '=',  $module);
                });
            }
        }

        if ($item_type != "") {

            $data->where(function ($query) use ($item_type) {

                $query->where('item_type', '=',  $item_type);
            });
        }
        if ($item_id != "") {

            $data->where(function ($query) use ($item_id) {
                $query->where('item_no_fk', '=',  $item_id);
            });
        }
        // dd($module,$item_type,$data->get());

        $serviceUnitData = [];
        foreach ($data->get() as  $value) {
            $serviceUnitData[$value->item_serviceunit_no_fk . '_' . $value->item_serviceunit_name][] = $value;
        }
        // dd($serviceUnitData);

        return Template::loadView("admin.reports.pharmacy.itemWiseFincCount_table", ['serviceUnitData' => $serviceUnitData, 'form_date' => $form_date, 'to_date' => $to_date, 'department' => $department, 'hospital_info' => $hospital_info]);
    }


    public function itemWiseFincCountPdf(Request $request)
    {

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();

        $form_date = date('Y-m-d', strtotime($request->date_from));
        $to_date = date('Y-m-d', strtotime($request->date_to));
        $department = $request->department;
        $module = $request->module;
        $item_type = $request->item_type;
        $item_id = $request->item_id;

        $data = DB::table('finc_invoicedtl_detail_vw')->select(DB::raw('sum(item_qty-nvl(cancel_qty,0)) as item_qty'), 'finc_invoicedtl_detail_vw.ity_group_header_name', 'finc_invoicedtl_detail_vw.item_serviceunit_no_fk', 'finc_invoicedtl_detail_vw.item_serviceunit_name', 'finc_invoicedtl_detail_vw.item_name', 'finc_invoicedtl_detail_vw.item_type')->orderBy('item_name', 'asc')->groupBy('ity_group_header_name', 'item_serviceunit_no_fk', 'item_serviceunit_name', 'item_name', 'item_type')->whereBetween(DB::raw('trunc(invoice_date)'), [$form_date, $to_date]);

        if ($department != "") {
            $data->where(function ($query) use ($department) {
                $query->where('su_no_fk', '=', $department);
            });
        }
        if ($module != "") {
            if ($module == "PHR") {
                $data->where(function ($query) use ($module) {
                    //  $query->whereIn('module_code', ['PHR', 'PHR-I']);
                });
            } else {
                $data->where(function ($query) use ($module) {
                    // $query->where('module_code', '=',  $module);
                });
            }
        }
        if ($item_type != "") {

            $data->where(function ($query) use ($item_type) {
                $query->where('item_type', '=',  $item_type);
            });
        }
        if ($item_id != "") {

            $data->where(function ($query) use ($item_id) {
                $query->where('item_no_fk', '=',  $item_id);
            });
        }

        // dd( $data->get(),$form_date ,$to_date);
        $serviceUnitData = [];
        foreach ($data->get() as  $value) {
            $serviceUnitData[$value->item_serviceunit_no_fk . '_' . $value->item_serviceunit_name][] = $value;
        }
        // dd($serviceUnitData);
        $pdf = PDF::loadView("admin.reports.pharmacy.item_wise_financial_count_pdf", ['serviceUnitData' => $serviceUnitData, 'form_date' => $form_date, 'to_date' => $to_date, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrait');
        return $pdf->stream('item_wise_financial_count_pdf.pdf');
    }

    public function itemWiseFincCountDtl($form_date = "", $to_date = "", $item_no)
    {
        $form_date_data = date('Y-m-d', strtotime($form_date));
        $to_date_data = date('Y-m-d', strtotime($to_date));
        $item_no_fk = $item_no;
        $data = DB::table('core_c026_sum_dt_invitm_aut_vw')
            ->select(DB::raw("invoice_date,item_name,item_rate,sum(nvl(item_qty,0)-nvl(cancel_qty,0)) as current_item_qty,sum(item_wise_discount) as disc_amount,sum(item_wise_service) as service_charge,sum(item_wise_collection) as ledgerdtl_amt_payment,invoice_no_pk"))
            ->where('item_no_fk', $item_no_fk)
            ->whereBetween(DB::raw('trunc(ledgertrn_date)'), [$form_date_data, $to_date_data])
            ->groupByRaw('invoice_date,item_name,item_rate,invoice_no_pk')
            ->orderBy('invoice_date', 'desc')
            ->get();
        // dd($data);
        return Template::loadView("admin.reports.pharmacy.itemWiseFincCountDtl", ['form_date' => $form_date, 'to_date' => $to_date, 'data' => $data, 'item_no_fk' => $item_no_fk,  ]);
    }

    public function itemWiseFincCountItemDtlPdf($form_date = "", $to_date = "", $item_no)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))->first();
        $form_date_data = date('Y-m-d', strtotime($form_date));
        $to_date_data = date('Y-m-d', strtotime($to_date));
        $item_no_fk = $item_no;
        $data = DB::table('core_c026_sum_dt_invitm_aut_vw')
            ->select(DB::raw("invoice_date,item_name,item_rate,sum(nvl(item_qty,0)-nvl(cancel_qty,0)) as current_item_qty,sum(item_wise_discount) as disc_amount,sum(item_wise_service) as service_charge,sum(item_wise_collection) as ledgerdtl_amt_payment,invoice_no_pk"))
            ->where('item_no_fk', $item_no_fk)
            ->whereBetween(DB::raw('trunc(ledgertrn_date)'), [$form_date_data, $to_date_data])
            ->groupByRaw('invoice_date,item_name,item_rate,invoice_no_pk')
            ->orderBy('invoice_date', 'desc')
            ->get();
        // dd($data);

        $pdf = PDF::loadView("admin.reports.pharmacy.itemWiseFincCountItemDtlPdf", ['po_hospital_details' => $po_hospital_details, 'form_date' => $form_date, 'to_date' => $to_date, 'data' => $data, 'item_no_fk' => $item_no_fk]);
        return $pdf->stream('item_wise_financial_count_item_details_pdf.pdf');
    }

    // Close Item wise financial count


    public function medicalExaminationReport()
    {
        $pat_info = [];
        return Template::loadView("admin.pathology.medical_examination_form", ['pat_info' => $pat_info]);
    }

    public function madicalExaminationPatInfo(Request $request)
    {
        $pat_info = DB::table('finc_inv_c022_sum_amount_vw')->leftjoin('patient_info_vw', 'finc_inv_c022_sum_amount_vw.patient_no_pk', '=', 'patient_info_vw.patient_no_pk')->where('invoice_no_pk', $request->invoice_id)->first();
        // dd(  $pat_info);
        return Template::loadView("admin.pathology.medical_examination_pat_info", ['pat_info' => $pat_info]);
    }
    public function madicalExaminationStore(Request $request)
    {
        // dd($request->all());
        $hospital_no_pk = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();

        $sequence = DB::getSequence();
        $me = $sequence->nextValue('exam_foreign_wor_dtl_no_pk_seq');

        try {
            $data1 = [
                'patient_name'  => $request->name,
                'patient_no_fk' => $request->patient_no_pk,
                'exam_foreign_wor_dtl_no_pk' => $me,

            ];


            $data = [
                'patient_name' => $request->name,
                'fathers_name' => $request->fathers_name,
                // 'dob' => $request->dob != "" ? date('y-m-d', strtotime($request->dob)) : "",
                'patient_no_fk' => $request->patient_no_pk,
                'gender_text' => $request->sex,
                'passport_no' => $request->passport,
                'height' => $request->height,
                'weight' => $request->weight,
                'citizenship' => $request->citizenship,
                // =>$request->mental_illness_yes,
                // 'mental_illness_ind' => $request->mental_illness_yes,
                'mental_illness' => $request->mental_illness_brief,
                // 'epilepsy' => $request->epilepsy_yes,
                // 'epilepsy_ind' => $request->epilepsy_yes_ind,


                //  au_update_session, blood_film, blood_film_abnormal_ind, blood_pressure,
                //  blood_pressure_ind, chest, chest_abnormal_ind, chronic_asthma, chronic_asthma_ind,
                //   citizenship, clinic_address, colour_vision, colour_vision_abnormal_ind, diabetes_mellitus,
                //   diabetes_mellitus_ind, diastolic, dob, doctor_name, doctor_no_fk, doctor_signature,
                //    doctore_signature_date, ecg, ecg_abnormal_ind, ecg_compulsory, ecg_compulsory_ind, ecg_ind,
                //     endocrine, endocrine_ind, enlarged_liver, enlarged_liver_ind, enlarged_spleen,
                //      enlarged_spleen_ind, exam_foreign_worker_no_pk, fathers_name,
                //      gender_no_fk, gender_text, genito_unary, genito_unary_ind, hbs, hbs_abnormal_ind, hearing,
                //      heart_disese, heart_disese_ind, height, hernia, hernia_ind, hiv, hiv_abnormal_ind, hypertension,
                //       hypertension_ind, limb_movement, limb_movement_ind, malaria, malaria_ind, mental_illness,
                //       mental_illness_ind, mental_state, mental_state_ind, occupation, operation, operation_ind, other_significant,
                //       other_significant_ind, passport_no, patient_name, patient_no_fk, patient_signature, pregnance, pregnance_abnormal_ind,
                //       respiratory_system, respiratory_system_ind, severe_varicose, severe_varicose_ind, signature_date, significant_amputation,
                //       significant_amputation_ind, significant_deformity, significant_deformity_ind, skin_chronic, skin_chronic_ind, status, sugar,
                //        sugar_abnormal_ind, systolic, telephone_number, tuberculosis, tuberculosis_ind, urine, urine_abnormal_ind, vdrl, vdrl_abnormal_ind,
                //        vision, vision_abnormal_ind, vision_acuity, vision_acuity_ind, vision_acuity_leftteye, vision_acuity_leftteye_ab_ind, vision_acuity_righteye,
                //        vision_acuity_righteye_ab_ind, weight

                'epilepsy'    => $request->epilepsy_yes_brief,
                // 'chronic_asthma_ind'    => $request->chronic_asthma_yes,
                'chronic_asthma'        => $request->chronic_asthma_yes_ind,
                'chronic_asthma' => $request->chronic_asthma_yes_brief,
                'diabetes_mellitus'    => $request->diabetes_mellitus_yes,
                'diabetes_mellitus_ind' => $request->diabetes_mellitus_yes_ind,

                // =>$request->hypertension_yes,
                'hypertension_ind'     => $request->hypertension_yes_ind,
                'hypertension'         => $request->hypertension_yes_brief,

                // start
                'tuberculosis'  => $request->tuberculosis_yes,
                'tuberculosis_ind' => $request->tuberculosis_yes_ind,
                // =>$request->tuberculosis_yes_brief,
                'heart_disese'  => $request->heart_disease_yes,
                'heart_disese_ind' => $request->heart_disease_yes_ind,
                // =>$request->heart_disease_yes_brief,
                'malaria'   => $request->malaria_yes,
                'malaria_ind' => $request->malaria_yes_ind,
                // =>$request->malaria_yes_brief,
                'operation'  => $request->operations_yes,
                'operation_ind'    => $request->operations_yes_ind,
                // =>$request->operations_yes_brief,




                // ok
                //      =>$request->bp_result,
                //     'BLOOD_PRESSURE_IND' =>$request->bp_result_ind,
                //      =>$request->heart_disease_result,
                //      'HEART_DISEASE_AB_IND'=>$request->heart_disease_result_ind,
                //      =>$request->ecg_result,
                //      'ECG_IND'=>$request->ecg_result_ind,
                //      =>$request->severe_varicose_result,
                //      'SEVERE_VARICOSE_IND'=>$request->severe_varicose_result_ind,
                //      =>$request->anaemia_result,
                //      'ANAEMIA_HB'=>$request->anaemia_text,
                //      'ANAEMIA_HB_IND'=>$request->anaemia_result_ind,
                //      =>$request->respiratory_result,
                //      'RESPIRATORY_SYSTEM_IND'=>$request->respiratory_result_ind,
                //      =>$request->hernia_result,
                //      'HERNIA_IND'=>$request->hernia_result_ind,
                //      =>$request->enlarger_liver_result,
                //      'ENLARGED_LIVER_IND'=>$request->enlarger_liver_result_ind,
                //      =>$request->enlarged_spleen_result,
                //      'ENLARGED_SPLEEN_IND'=>$request->enlarged_spleen_result_ind,
                //      =>$request->genito_urinary_result,
                //      'GENITO_UNARY_IND'=>$request->genito_urinary_result_ind,
                //      =>$request->skin_chronic_result,
                //      'SKIN_CHRONIC_IND'=>$request->skin_chronic_result_ind,
                //      =>$request->significant_limb_result,
                //      'SIGNIFICANT_AMPUTATION_IND'=>$request->significant_limb_result_ind,
                //      =>$request->limb_movement_result,
                //      'LIMB_MOVEMENT_IND'=>$request->limb_movement_result_ind,
                //      =>$request->significant_spinal_result,
                //      'SIGNIFICANT_DEFORMITY_IND'=>$request->significant_spinal_result_ind,
                //      =>$request->singificant_abnormalitis_result,
                //     'OTHER_SIGNIFICANT_IND' =>$request->singificant_abnormalitis_result_ind,
                //      =>$request->endocrine_disorders_result,
                //      'ENDOCRINE_IND'=>$request->endocrine_disorders_result_ind,
                //      =>$request->mental_state_result,
                //      'MENTAL_STATE_IND'=>$request->mental_state_result_ind,
                //      =>$request->chest_x_ray,


                // 'chest_abnormal_ind' => $request->chest_x_ray_ind,
                'hbs' => $request->hbsag,
                // 'hbs_abnormal_ind' => $request->hbsag_ind,
                'ecg' => $request->ecg,
                'ecg_abnormal_ind' => $request->ecg_ind,
                'urine' => $request->urine,
                'urine_abnormal_ind' => $request->urine_ind,
                'albumin' => $request->albumin,
                'albumin_abnormal_ind' => $request->albumin_ind,
                'sugar' => $request->sugar,
                'sugar_abnormal_ind' => $request->sugar_ind,
                'pregnance' => $request->pregnancy,
                'pregnance_abnormal_ind' => $request->pregnancy_ind,
                'vdrl' => $request->vdrl,
                'vdrl_abnormal_ind' => $request->vdrl_ind,
                'hearing' => $request->hearing_unable,
                'hearing_abnormal_ind' => $request->hearing_unable_ind,
                'vision' => $request->vision,
                'vision_abnormal_ind' => $request->vision_ind,
                'vision_acuity' => $request->vision_acuity,
                'vision_acuity_ind' => $request->vision_acuity_ind,
                'vision_acuity_righteye' => $request->right_eye,
                'vision_acuity_righteye_ab_ind' => $request->right_eye_ind,
                'vision_acuity_leftteye' => $request->left_eye,
                'vision_acuity_leftteye_ab_ind' => $request->left_eye_ind,
                'colour_vision' => $request->color_vision,
                'colour_vision_abnormal_ind' => $request->color_vision_ind,
                'any_organic' => $request->any_organic_eye_disease,
                'any_organic_abnormal_ind' => $request->any_organic_eye_disease_ind,
                'hiv' => $request->hiv,


                // 'hiv_abnormal_ind' => $request->hiv_inv,
                'doctor_name' => $request->doctor_name,
                'doctor_no_fk' => $request->hdn_doctor_id,

            ];

            // dd($request->hiv_inv);



            // $data['exam_foreign_wor_dtl_no_pk'] = $me;
            $data['AU_ENTRY_BY'] =  $auth_id;
            $data['AU_ENTRY_AT'] = date('Y-m-d');
            $data['AU_ENTRY_SESSION'] = 'session';
            $data['au_entry_hospital_pk_no'] = $hospital_no_pk;
            DB::table('medical_exam_foreign_worker_dtl')->insert($data1);



            $sequence1 = DB::getSequence();
            $me1 = $sequence1->nextValue('exam_foreign_worker_no_pk_seq');
            $data['exam_foreign_worker_no_pk'] = $me1;
            $data['AU_ENTRY_BY'] =  $auth_id;
            $data['AU_ENTRY_AT'] = date('Y-m-d');
            $data['AU_ENTRY_SESSION'] = 'session';
            $data['au_entry_hospital_pk_no'] = $hospital_no_pk;
            DB::table('labt_med_exam_foreigner_worker')->insert($data);


            DB::commit();
            $this->message = ['msg' => 'Data saved successfully.', 'title' => 'Success'];
        } catch (\Throwable $th) {
            DB::rollback();
            $this->message = ['msg' => 'Failled.', 'title' => 'Error'];
        }
        return response()->json($this->message);


        //         $data['au_entry_by'] = $auth_id;
        //         $this->itemTypeModel->create($data);

        //     DB::commit();
        //     $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }

        // return response()->json($message);

    }

    public function medicalExaminationFormPdf($exam_id)
    {
        $data = DB::table('labt_med_exam_foreigner_worker')->where('exam_foreign_worker_no_pk', $exam_id)->first();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $title = $data->patient_no_fk;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_patient_no = $barcode->generate();

        $title = $data->exam_foreign_worker_no_pk;
        $pat_barcode = new BarcodeGenerator();
        $pat_barcode->setText($title);
        $pat_barcode->setType(BarcodeGenerator::Code128);
        $pat_barcode->setLabel('');
        $pat_barcode->setScale(1);
        $pat_barcode->setThickness(25);
        $pat_barcode->setFontSize(10);
        $barcode_examid_no = $pat_barcode->generate();
        return view("admin.pathology.medical_examination_report_print", ['barcode_patient_no' => $barcode_patient_no, 'po_hospital_details' => $po_hospital_details, 'barcode_examid_no' => $barcode_examid_no, 'data' => $data]);
    }


    // Employee Performance Report
    public function employeePerformanceReport()
    {
        $item_type = ItemType::where('status', '1')->select('item_type_name', 'itemtype_no_pk')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $dept = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->orderBy('serviceunit_name', 'asc')->get();
        return Template::loadView("admin.reports.financial.employee_performance_report", [
            'item_type' => $item_type,
            'dept'      => $dept,
            'data_arr' => '',
        ]);
    }
    public function employeePerformanceReportData(Request $request)
    {
        // dd($request->all());
        // return $report_data;
        $item_type = $request->item_type;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $dept = $request->dept;
        $emp_id = $request->doctor_id;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($emp_id != "") ? " $clause person_no_fk =$emp_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_type != "") ? " $clause itemtype_no_fk = $item_type" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($dept != "") ? " $clause serviceunit_no_fk = $dept" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledgertrn_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        $report_data = DB::select("select item_type_head,
               sum (item_wise_collection) collection,
               trunc (ledgertrn_date) ledgertrn_date,
               user_fullname
          from finc_c027_daily_stmt_kbmh_vw $sql_cond
      group by item_type_head,
               trunc (ledgertrn_date),
               user_fullname order by ledgertrn_date asc ");
        $data_arr = [];
        foreach ($report_data as $data) {
            $data_arr[$data->item_type_head][$data->user_fullname][] =  $data;
        }
        // dd($data_arr);
        $dept_data = DB::select("select item_type_head,
                sum (item_wise_collection) collection,
                trunc (ledgertrn_date) ledgertrn_date
                from finc_c027_daily_stmt_kbmh_vw $sql_cond
                group by item_type_head, trunc (ledgertrn_date)
                order by ledgertrn_date asc");


        return Template::loadView("admin.reports.financial.emp_performance_report_table", ['data' => $report_data, 'data_arr' => $data_arr, 'dept_data' => $dept_data]);
        // return Template::loadView("admin.reports.financial.emp_performance_report_table");
    }

    public function employeePerformanceReportPdf(Request $request)
    {
        $item_type = $request->item_type;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $dept = $request->dept;
        $emp_id = $request->doctor_id;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($emp_id != "") ? " $clause person_no_fk =$emp_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_type != "") ? " $clause itemtype_no_fk = $item_type" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($dept != "") ? " $clause serviceunit_no_fk = $dept" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledgertrn_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        //     $report_data = DB::select("select item_type_head,
        //            sum (item_wise_collection) collection,
        //            trunc (ledgertrn_date) ledgertrn_date,
        //            user_fullname
        //       from finc_c027_daily_stmt_kbmh_vw $sql_cond
        //   group by item_type_head,
        //            trunc (ledgertrn_date),
        //            user_fullname order by ledgertrn_date asc ");
        //     $data_arr = [];
        //     foreach ($report_data as $data) {
        //         $data_arr[$data->user_fullname.'~'.$data->ledgertrn_date][] =  $data;
        //     }


        // $dept_data = DB::select("select item_type_head,
        // sum (item_wise_collection) collection,
        // trunc (ledgertrn_date) ledgertrn_date
        // from finc_c027_daily_stmt_kbmh_vw $sql_cond
        // group by item_type_head, trunc (ledgertrn_date)
        // order by ledgertrn_date asc");


        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        // $pdf = PDF::loadView("admin.reports.financial.emp_performance_report_pdf", [
        //     'data' => $report_data, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'data_arr' => $data_arr,'dept_data'=>$dept_data
        // ]);
        // return $pdf->download('employee_performance_report.pdf');
        return view("admin.reports.financial.emp_performance_report_pdf", ['po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to]);
    }

    public function employeePerformanceReportPdfMonthly(Request $request)
    {
        $item_type = $request->item_type;
        $date_from = $request->date_from;
        $date_to = $request->date_to;
        $dept = $request->dept;
        $emp_id = $request->doctor_id;
        if (!empty($request->date_from) && !empty($request->date_to)) {

            $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($emp_id != "") ? " $clause person_no_fk =$emp_id" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($item_type != "") ? " $clause itemtype_no_fk = $item_type" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($dept != "") ? " $clause serviceunit_no_fk = $dept" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(ledgertrn_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";



        $report_data = DB::select("select item_type_head,
               sum (item_wise_collection) collection,
               trunc (ledgertrn_date) ledgertrn_date,
               user_fullname
          from finc_c027_daily_stmt_kbmh_vw $sql_cond
      group by item_type_head,
               trunc (ledgertrn_date),
               user_fullname order by ledgertrn_date asc ");
        echo "select item_type_head,
               sum (item_wise_collection) collection,
               trunc (ledgertrn_date) ledgertrn_date,
               user_fullname
          from finc_c027_daily_stmt_kbmh_vw $sql_cond
      group by item_type_head,
               trunc (ledgertrn_date),
               user_fullname order by ledgertrn_date asc ";

        dd($report_data);
        $data_arr = [];
        foreach ($report_data as $data) {
            $data_arr[$data->user_fullname . '~' . $data->ledgertrn_date][] =  $data;
        }


        $dept_data = DB::select("select item_type_head,
        sum (item_wise_collection) collection,
        trunc (ledgertrn_date) ledgertrn_date
        from finc_c027_daily_stmt_kbmh_vw $sql_cond
        group by item_type_head, trunc (ledgertrn_date)
        order by ledgertrn_date asc");


        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $title = '123456';
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.reports.financial.emp_performance_report_pdf", [
            'data' => $report_data, 'po_hospital_details' => $po_hospital_details, 'barcode_no' => $barcode_no, 'from_date' => $date_from, 'to_date' => $date_to, 'data_arr' => $data_arr, 'dept_data' => $dept_data
        ]);
        return $pdf->download('employee_performance_report.pdf');
    }


    // financial account
    public function financialReport()
    {

        return Template::loadView("admin.uhl.hospital-financial-reports", [
            'column_name' => '',
            'row_name' => [],
            'parent_dt' => [],
            'requestDepts'      => DB::table('sysc_serviceunit_vw')
                //->where('ipd_ind', 1)
                ->get(['serviceunit_name', 'serviceunit_no_pk'])
                ->toArray(),
            'major_group_list'  => DB::table('sysc_itemtype')->select('item_type_name', 'itemtype_no_pk')->where('major_group_ind', 1)->get(),
            'modules'           => DB::table('sysc_module')->select('module_name', 'module_no_pk')->get(),
            'minor_group_list'  => DB::table('sysc_itemtype')->select('item_type_name', 'itemtype_no_pk')->where('minor_group_ind', 1)->get(),

        ]);
    }


    public function hospitalFinancialReportSearch(Request $request)
    {
        // dd($request->all());

        $major_group = $request->major_group;
        $minor_group = $request->minor_group;
        $allowed_dates = $request->allowed_dates;
        $allowed_dates_to = $request->allowed_dates_to;
        $department = $request->department;
        if (!empty($request->allowed_dates) && !empty($request->allowed_dates_to)) {

            $date_from = "$request->allowed_dates"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->allowed_dates_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($department != "") ? " $clause item_serviceunit_no_fk=$department" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        //         $report_data = db::select("  select item_serviceunit_name,
        //         module_code,
        //         sum (pat_count) pat_total,
        //         patient_type_code,
        //         ity_group_header_name,
        //         item_serviceunit_no_fk,
        //         par_itemtype_no_fk,
        //         ity_group_header_no,
        //         sum (day_sum_item_qty) item_total_qty,
        //         sum (day_sum_cancel_qty) item_total_cancel_qty,
        //         sum (day_sum_invoicedtl_amt_sales) item_total_amt_sales,
        //         sum (day_sum_invoicedtl_amt_payment) item_total_amt_payment,
        //         sum (day_sum_invoicedtl_amt_dis) item_total_amt_discoutn
        //    from rpt_01_finc_invoicedtl_detail_vw $sql_cond
        // group by item_serviceunit_name,
        //         module_code,
        //         patient_type_code,
        //         ity_group_header_name,
        //         item_serviceunit_no_fk,
        //         par_itemtype_no_fk,
        //         ity_group_header_no
        // order by 1, 2");

        $report_data = db::select("SELECT item_serviceunit_name,
                                SUM (pat_count) pat_total,
                                ity_group_header_name,
                                item_serviceunit_no_fk,
                                SUM (day_sum_item_qty) item_total_qty,
                                SUM (day_sum_invoicedtl_amt_payment) item_total_amt_payment
                                FROM rpt_01_finc_invoicedtl_detail_vw $sql_cond
                                GROUP BY item_serviceunit_name,
                                ity_group_header_name,
                                item_serviceunit_no_fk,
                                par_itemtype_no_fk,
                                ity_group_header_no
                                ORDER BY 1, 2");

        $parent_dt = [];
        $parent_dt_data = $parent_dt;

        if (!empty($report_data)) {
            foreach ($report_data as  $p_dt) {
                $parent_dt[$p_dt->ity_group_header_name][] =  $p_dt;
            }
        }
        $column_name = DB::select(DB::raw("select patient_type_code,count(*) from rpt_01_finc_invoicedtl_detail_vw group by patient_type_code"));
        $column_name2 = DB::select(DB::raw("select module_code,count(*) from rpt_01_finc_invoicedtl_detail_vw group by module_code"));
        // dd($column_name);
        $row_name = DB::select(DB::raw("select module_code,
                                        sum (pat_count) pat_total,
                                        par_itemtype_no_fk,
                                        par_item_type_name,
                                        ity_group_header_no,
                                        ity_group_header_name,
                                        item_serviceunit_name,
                                        patient_type_code,
                                        item_serviceunit_no_fk,
                                        sum (day_sum_invoicedtl_amt_payment) item_total_amt_payment
                                    from rpt_01_finc_invoicedtl_detail_vw $sql_cond
                                group by module_code,
                                        par_itemtype_no_fk,
                                        par_item_type_name,
                                        ity_group_header_no,
                                        ity_group_header_name,
                                        item_serviceunit_name,
                                        patient_type_code,
                                        item_serviceunit_no_fk
                                order by ity_group_header_name, item_serviceunit_name asc"));
        return Template::loadview("admin.uhl.financial_report.hospital_financial_list", [
            'report_data' => $report_data,
            'parent_dt' => $parent_dt,
            'column_name' => $column_name,
            'column_name2' => $column_name2,
            'row_name' => $row_name,
        ]);
    }

    // public function get_module_details($patn_code)
    // {
    //     $module_name = '';
    //     $module_name = db::select(db::raw(" select module_code,
    //                         sum (pat_count) pat_total,
    //                         sum (day_sum_item_qty) item_total_qty,
    //                         sum (day_sum_invoicedtl_amt_payment) item_total_amt_payment
    //                 from rpt_01_finc_invoicedtl_detail_vw
    //                 where module_code = '$patn_code' and trunc (invoice_date) between to_date ('19/02/2023', 'dd/mm/yyyy')
    //                                                 and to_date ('19/02/2023', 'dd/mm/yyyy')
    //                 group by module_code "));
    //     return $module_name;
    // }

    public function get_module_details()
    {
        $module_name = '';
        $module_name = db::select(db::raw("  SELECT module_code,
                                SUM (pat_count) pat_total,
                                SUM (day_sum_item_qty) item_total_qty,
                                SUM (day_sum_invoicedtl_amt_payment) item_total_amt_payment
                        FROM rpt_01_finc_invoicedtl_detail_vw
                        WHERE TRUNC (invoice_date) BETWEEN TO_DATE ('19/02/2023', 'dd/mm/yyyy')
                                                        AND TO_DATE ('19/02/2023', 'dd/mm/yyyy')
                        GROUP BY module_code "));
        return $module_name;
    }

    public function get_patient_details($dept)
    {
        $patient_details = '';
        $patient_details = db::select(db::raw(" select
        item_serviceunit_name,
        sum(pat_count) pat_total,
        sum (day_sum_item_qty) item_total_qty,
        sum (day_sum_cancel_qty) item_total_cancel_qty,
        sum (day_sum_invoicedtl_amt_sales) item_total_amt_sales,
        sum (day_sum_invoicedtl_amt_payment) item_total_amt_payment,
        sum (day_sum_invoicedtl_amt_dis) item_total_amt_discoutn
        from rpt_01_finc_invoicedtl_detail_vw where
        trunc(invoice_date) between TO_DATE('19/02/2023','DD/MM/YYYY') and TO_DATE('19/02/2023','DD/MM/YYYY')
        group by
                item_serviceunit_name
        order by 1, 2"));

        return $patient_details;
    }

    public function get_dept_details()
    {
        $dept_details = '';
        $dept_details = db::select(db::raw("SELECT module_code,
                                    ITY_GROUP_HEADER_NAME,
                                    SUM (pat_count) pat_total,
                                    SUM (day_sum_item_qty) item_total_qty,
                                    SUM (day_sum_cancel_qty) item_total_cancel_qty,
                                    SUM (day_sum_invoicedtl_amt_sales) item_total_amt_sales,
                                    SUM (day_sum_invoicedtl_amt_payment) item_total_amt_payment
                            FROM rpt_01_finc_invoicedtl_detail_vw
                            WHERE TRUNC (invoice_date) BETWEEN TO_DATE ('19/02/2023', 'DD/MM/YYYY')
                                                                AND TO_DATE ('19/02/2023', 'DD/MM/YYYY')
                            GROUP BY module_code, ITY_GROUP_HEADER_NAME
                            ORDER BY 1, 2"));

        return $dept_details;
    }



    // Hospital Financial Report
    public function dhospitalFinancialReportPdf(Request $request)
    {
        // dd($request->hdn_report_type);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // dd($request->all());

        $major_group = $request->major_group;
        $minor_group = $request->minor_group;
        $allowed_dates = $request->allowed_dates;
        $allowed_dates_to = $request->allowed_dates_to;
        $department = $request->department;
        if (!empty($request->allowed_dates) && !empty($request->allowed_dates_to)) {

            $date_from = "$request->allowed_dates"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->allowed_dates_to"; //date('Y/m/d', strtotime($request->date_to));
        } else {
            $date_from = "";
            $date_to = "";
        }
        if ($request->hdn_report_type == 'PDF') {
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($department != "") ? " $clause item_serviceunit_no_fk=$department" : "";
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";


            $report_data = db::select("select * from FINC_INVOICEDTL_DETAIL_MG_VW $sql_cond order by invoice_date,ITEM_SERVICEUNIT_NAME asc");
            // echo "select * from FINC_INVOICEDTL_DETAIL_MG_VW $sql_cond";

            $parent_dt = [];
            $parent_dt_data = $parent_dt;

            if (!empty($report_data)) {
                foreach ($report_data as  $p_dt) {
                    $parent_dt[$p_dt->ity_group_header_name][] =  $p_dt;
                }
            }
            $column_name = DB::select(DB::raw("select patient_type_code,count(*) from rpt_01_finc_invoicedtl_detail_vw group by patient_type_code"));
            $column_name2 = DB::select(DB::raw("select module_code,count(*) from rpt_01_finc_invoicedtl_detail_vw group by module_code"));


            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
            $pdf = PDF::loadView("admin.uhl.financial_report.hospital_financial_report_pdf", [
                'barcode_no' => $barcode_no, 'report_data' => $report_data,
                'parent_dt' => $parent_dt, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details
            ])->setPaper('a4', 'landscape');
            return $pdf->stream('hospital_financial_Report.pdf');
        } else if ($request->hdn_report_type == 'EXCEL') {
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($department != "") ? " $clause item_serviceunit_no_fk=$department" : "";
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";


            $report_data = db::select("select * from FINC_INVOICEDTL_DETAIL_MG_VW $sql_cond order by invoice_date,ITEM_SERVICEUNIT_NAME asc");
            // echo "select * from FINC_INVOICEDTL_DETAIL_MG_VW $sql_cond";

            $parent_dt = [];
            $parent_dt_data = $parent_dt;

            if (!empty($report_data)) {
                foreach ($report_data as  $p_dt) {
                    $parent_dt[$p_dt->ity_group_header_name][] =  $p_dt;
                }
            }
            $column_name = DB::select(DB::raw("select patient_type_code,count(*) from rpt_01_finc_invoicedtl_detail_vw group by patient_type_code"));
            $column_name2 = DB::select(DB::raw("select module_code,count(*) from rpt_01_finc_invoicedtl_detail_vw group by module_code"));

            $pdf = [
                'report_data' => $report_data,
                'parent_dt' => $parent_dt, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details
            ];

            $fileToExport = "hospital_financial_report";
            $html = View("admin.uhl.financial_report.hospital_financial_report_excel")->with($pdf);
            header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
            header("Content-type: application/vnd.ms-excel");
            return $html;
        } elseif ($request->hdn_report_type == 'IPD') {
            // dd($request->hdn_report_type);
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($department != "") ? " $clause item_serviceunit_no_fk=$department" : "";
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(admission_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

            // dd($sql_cond);
            $report_data = db::select("  SELECT
                    department,
                    COUNT (1) total_admission,
                    SUM (sales) sales,
                    SUM (discount) discount,
                    SUM (payment) payment,
                    SUM (GENERAL) GENERAL,
                    SUM (STAFF) STAFF,
                    SUM (STUDENT) STUDENT,
                    SUM (POOR) POOR,
                    SUM (SPECIAL) SPECIAL,
                    SUM (CORPORATE) CORPORATE,
                    SUM (ACADEMIC) ACADEMIC
                FROM rpt_ipd_patcount_amt $sql_cond
                GROUP BY  department
                ORDER BY department");
            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();

            if($request->hdn_download_type == 'PDF') {
                $pdf = PDF::loadView("admin.uhl.financial_report.hospital_financial_report_ipd", [
                    'barcode_no' => $barcode_no, 'report_data' => $report_data, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details
                ])->setPaper('a4', 'landscape');
                return $pdf->stream('hospital_financial_Report_ipd.pdf');
            }

            if($request->hdn_download_type == 'EXCEL') {
                $data = ['barcode_no' => $barcode_no, 'report_data' => $report_data, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details];
                $fileToExport = "hospital_financial_report_ipd_excel";
                $html = View("admin.uhl.financial_report.hospital_financial_report_ipd_excel")->with($data);
                header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
                header("Content-type: application/vnd.ms-excel");
                return $html;
            }
        } elseif ($request->hdn_report_type == 'OPD') {
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($department != "") ? " $clause serviceunit_no_pk=$department" : "";
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(appoint_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $report_data = db::select("  SELECT SERVICEUNIT_NAME,
            SUM (PATIENT_CNT_TOTAL) PATIENT_CNT_TOTAL,
            SUM (PATIENT_CNT_NEWCONS) PATIENT_CNT_NEWCONS,
            SUM (PATIENT_CNT_FOLLOWUP) PATIENT_CNT_FOLLOWUP,
            SUM (PATIENT_CNT_CORPORATE) PATIENT_CNT_CORPORATE,
            SUM (PATIENT_CNT_FREE_ACA) PATIENT_CNT_FREE_ACA,
            SUM (LEDGER_AMT_SALES) LEDGER_AMT_SALES,
            SUM (LEDGER_AMT_PAYMENT) LEDGER_AMT_PAYMENT,
            SUM (LEDGER_AMT_DISCOUNT) LEDGER_AMT_DISCOUNT
                FROM RPT_03_OPD_PAT_COUNT_SU_DT_VW $sql_cond
                GROUP BY SERVICEUNIT_NAME ");
            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();

            if($request->hdn_download_type == 'PDF') {
                $pdf = PDF::loadView("admin.uhl.financial_report.hospital_financial_report_opd", [
                    'barcode_no' => $barcode_no, 'report_data' => $report_data,
                    'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details
                ])->setPaper('a4', 'landscape');
                return $pdf->stream('hospital_financial_Report.pdf');
            }

            if($request->hdn_download_type == 'EXCEL') {
                $data = ['barcode_no' => $barcode_no, 'report_data' => $report_data, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details];
                $fileToExport = "hospital_financial_report_opd_excel";
                $html = View("admin.uhl.financial_report.hospital_financial_report_opd_excel")->with($data);
                header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
                header("Content-type: application/vnd.ms-excel");
                return $html;
            }
        } elseif ($request->hdn_report_type == 'PATHOLOGY') {
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($department != "") ? " $clause serviceunit_no_pk=$department" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $report_data = db::select(" SELECT item_serviceunit_name,
            SUM (item_qty_investigation) item_qty_investigation,
            SUM (item_qty_opd) item_qty_opd,
            SUM (item_qty_ipd) item_qty_ipd,
            SUM (item_qty_corp) item_qty_corp,
            SUM (item_qty_academic) item_qty_academic,
            SUM (invoicedtl_amt_discount) invoicedtl_amt_discount,
            SUM (invoicedtl_amt_payment) invoicedtl_amt_payment,
            SUM (INVOICEDTL_AMT_SALES) INVOICEDTL_AMT_SALES
                FROM FINC_INVOICEDTL_DETAIL_MG_VW
                WHERE ITY_GROUP_HEADER_NAME = 'PATHOLOGY'  $sql_cond
                GROUP BY item_serviceunit_name order by item_serviceunit_name asc ");
            // dd($report_data);
            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();

            if($request->hdn_download_type == 'PDF') {
                $pdf = PDF::loadView("admin.uhl.financial_report.hospital_financial_report_pathology", [
                    'barcode_no' => $barcode_no, 'report_data' => $report_data,
                    'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details
                ])->setPaper('a4', 'landscape');
                return $pdf->stream('hospital_financial_Report.pdf');
            }

            if($request->hdn_download_type == 'EXCEL') {
                $data = ['barcode_no' => $barcode_no, 'report_data' => $report_data, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details];
                $fileToExport = "hospital_financial_report_pathology_excel";
                $html = View("admin.uhl.financial_report.hospital_financial_report_pathology_excel")->with($data);
                header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
                header("Content-type: application/vnd.ms-excel");
                return $html;
            }
        } elseif ($request->hdn_report_type == 'RADIOLOGY') {
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($department != "") ? " $clause ITEM_SERVICEUNIT_NAME='$department'" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $report_data = db::select("  SELECT item_serviceunit_name,
            SUM (item_qty_investigation) item_qty_investigation,
            SUM (item_qty_opd) item_qty_opd,
            SUM (item_qty_ipd) item_qty_ipd,
            SUM (item_qty_corp) item_qty_corp,
            SUM (item_qty_academic) item_qty_academic,
            SUM (invoicedtl_amt_discount) invoicedtl_amt_discount,
            SUM (invoicedtl_amt_payment) invoicedtl_amt_payment,
            SUM (INVOICEDTL_AMT_SALES) INVOICEDTL_AMT_SALES
                FROM FINC_INVOICEDTL_DETAIL_MG_VW
                WHERE ITY_GROUP_HEADER_NAME = 'RADIOLOGY'
                $sql_cond
                GROUP BY item_serviceunit_name order by item_serviceunit_name asc ");
            // dd($report_data);
            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
            $pdf = PDF::loadView("admin.uhl.financial_report.hospital_financial_report_radiology", [
                'barcode_no' => $barcode_no, 'report_data' => $report_data,
                'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details
            ])->setPaper('a4', 'landscape');
            return $pdf->stream('hospital_financial_Report.pdf');
        } elseif ($request->hdn_report_type == 'OT') {
            // dd($request->hdn_report_type);
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($department != "") ? " $clause serviceunit_no_pk=$department" : "";
            $clause = ($sql_cond == "") ? " where" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $report_data = db::select("  SELECT department,
                        SUM (total_sales) sales,
                        SUM (invoicedtl_amt_discount) discount,
                        SUM (invoicedtl_amt_payment) payment,
                        SUM (minor) minor,
                        SUM (major) major,sum(qty) total_qty
                FROM rpt_ot_patcount_amt $sql_cond
            GROUP BY department ");
            //  dd($report_data);
            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();

            if($request->hdn_download_type == 'PDF') {
                $pdf = PDF::loadView("admin.uhl.financial_report.hospital_financial_report_ot", [
                    'barcode_no' => $barcode_no, 'report_data' => $report_data,
                    'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details
                ])->setPaper('a4', 'landscape');
                return $pdf->stream('hospital_financial_Report.pdf');
            }
            
            if($request->hdn_download_type == 'EXCEL') {
                $data = ['barcode_no' => $barcode_no, 'report_data' => $report_data, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details];
                $fileToExport = "hospital_financial_report_ot_excel";
                $html = View("admin.uhl.financial_report.hospital_financial_report_ot_excel")->with($data);
                header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
                header("Content-type: application/vnd.ms-excel");
                return $html;
            }            
        } elseif ($request->hdn_report_type == 'ICU') {
            // dd($request->hdn_report_type);
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($department != "") ? " $clause serviceunit_no_pk=$department" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(ADMISSION_DATE) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $report_data = db::select("select * from rpt_opdbeddept_patcount_amt where department = 'ICU' $sql_cond order by ADMISSION_DATE asc ");
            //  dd($report_data);
            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
            $pdf = PDF::loadView("admin.uhl.financial_report.hospital_financial_report_icu", [
                'barcode_no' => $barcode_no, 'report_data' => $report_data,
                'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'dept' => $request->hdn_report_type
            ])->setPaper('a4', 'landscape');
            return $pdf->stream('hospital_financial_Report.pdf');
        } elseif ($request->hdn_report_type == 'NICU') {
            // dd($request->hdn_report_type);
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($department != "") ? " $clause serviceunit_no_pk=$department" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(ADMISSION_DATE) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $report_data = db::select("select * from rpt_opdbeddept_patcount_amt where department = 'NICU' $sql_cond order by ADMISSION_DATE asc ");
            //  dd($report_data);
            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
            $pdf = PDF::loadView("admin.uhl.financial_report.hospital_financial_report_icu", [
                'barcode_no' => $barcode_no, 'report_data' => $report_data,
                'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'dept' => $request->hdn_report_type
            ])->setPaper('a4', 'landscape');
            return $pdf->stream('hospital_financial_Report.pdf');
        } elseif ($request->hdn_report_type == 'CCU') {
            // dd($request->hdn_report_type);
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($department != "") ? " $clause serviceunit_no_pk=$department" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(ADMISSION_DATE) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $report_data = db::select("select * from rpt_opdbeddept_patcount_amt where department = 'CCU' $sql_cond order by ADMISSION_DATE asc ");
            //  dd($report_data);
            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
            $pdf = PDF::loadView("admin.uhl.financial_report.hospital_financial_report_icu", [
                'barcode_no' => $barcode_no, 'report_data' => $report_data,
                'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'dept' => $request->hdn_report_type
            ])->setPaper('a4', 'landscape');
            return $pdf->stream('hospital_financial_Report.pdf');
        } elseif($request->hdn_report_type == 'PICU') {
            // dd($request->hdn_report_type);
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($department != "") ? " $clause serviceunit_no_pk=$department" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(ADMISSION_DATE) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $report_data = db::select("select * from rpt_opdbeddept_patcount_amt where department = 'PICU' $sql_cond order by ADMISSION_DATE asc ");
            //  dd($report_data);
            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
            $pdf = PDF::loadView("admin.uhl.financial_report.hospital_financial_report_icu", [
                'barcode_no' => $barcode_no, 'report_data' => $report_data,
                'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'dept' => $request->hdn_report_type
            ])->setPaper('a4', 'landscape');
            return $pdf->stream('hospital_financial_Report.pdf');
        } elseif ($request->hdn_report_type == 'PHARMACY') {
            // dd($request->hdn_report_type);
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($department != "") ? " $clause serviceunit_no_pk=$department" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(ledger_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $report_data = db::select("SELECT TRUNC (ledger_date) ledger_date,
            SUM (DECODE (MOD.MODULE_CODE, 'PHR-I', LEDGER_AMT_SALES)) ipd_sales,
            SUM (DECODE (MOD.MODULE_CODE, 'PHR', LEDGER_AMT_SALES)) opd_sales,
            NVL (SUM (DECODE (MOD.MODULE_CODE, 'PHR-O', LEDGER_AMT_SALES)), 0)
               ot_sales,
            NVL (SUM (DECODE (MOD.MODULE_CODE, 'PHR-E', LEDGER_AMT_SALES)), 0)
               emr_sales,
            SUM (LEDGER_AMT_SALES) total_sales,
            SUM (LEDGER_AMT_DISCOUNT) discount,
            SUM (LEDGER_AMT_SALES) - SUM (LEDGER_AMT_DISCOUNT) net_sales,
            SUM (LEDGER_AMT_PAYMENT) phr_net_collection
                FROM finc_ledgermst mst, sysc_module MOD
                WHERE mst.module_no_fk = MOD.module_no_pk
                AND MOD.MODULE_CODE IN ('PHR', 'PHR-I', 'PHR-O', 'PHR-E','PHR-D')  $sql_cond
                GROUP BY TRUNC (ledger_date)
                ORDER BY 1");

            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();

            if($request->hdn_download_type == 'PDF') {
                $pdf = PDF::loadView("admin.uhl.financial_report.hospital_financial_report_pharmacy", [
                    'barcode_no' => $barcode_no, 'report_data' => $report_data,
                    'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'dept' => $request->hdn_report_type
                ])->setPaper('a4', 'landscape');
                return $pdf->stream('hospital_financial_Report.pdf');
            }
            
            if($request->hdn_download_type == 'EXCEL') {
                $data = ['barcode_no' => $barcode_no, 'report_data' => $report_data, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details];
                $fileToExport = "hospital_financial_report_pharmacy_excel";
                $html = View("admin.uhl.financial_report.hospital_financial_report_pharmacy_excel")->with($data);
                header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
                header("Content-type: application/vnd.ms-excel");
                return $html;
            }
        } elseif ($request->hdn_report_type == 'PHARMACY') {
            // dd($request->hdn_report_type);
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($department != "") ? " $clause serviceunit_no_pk=$department" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(ledger_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $report_data = db::select("SELECT TRUNC (ledger_date) ledger_date,
            SUM (DECODE (MOD.MODULE_CODE, 'PHR-I', LEDGER_AMT_SALES)) ipd_sales,
            SUM (DECODE (MOD.MODULE_CODE, 'PHR', LEDGER_AMT_SALES)) opd_sales,
            NVL (SUM (DECODE (MOD.MODULE_CODE, 'PHR-O', LEDGER_AMT_SALES)), 0)
               ot_sales,
            NVL (SUM (DECODE (MOD.MODULE_CODE, 'PHR-E', LEDGER_AMT_SALES)), 0)
               emr_sales,
            SUM (LEDGER_AMT_SALES) total_sales,
            SUM (LEDGER_AMT_DISCOUNT) discount,
            SUM (LEDGER_AMT_SALES) - SUM (LEDGER_AMT_DISCOUNT) net_sales,
            SUM (LEDGER_AMT_PAYMENT) phr_net_collection
                FROM finc_ledgermst mst, sysc_module MOD
                WHERE mst.module_no_fk = MOD.module_no_pk
                AND MOD.MODULE_CODE IN ('PHR', 'PHR-I', 'PHR-O', 'PHR-E','PHR-D')  $sql_cond
                GROUP BY TRUNC (ledger_date)
                ORDER BY 1");

            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
            $pdf = PDF::loadView("admin.uhl.financial_report.hospital_financial_report_pharmacy", [
                'barcode_no' => $barcode_no, 'report_data' => $report_data,
                'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'dept' => $request->hdn_report_type
            ])->setPaper('a4', 'landscape');
            return $pdf->stream('hospital_financial_Report.pdf');
        } elseif ($request->hdn_report_type == 'PHARMACY') {
            // dd($request->hdn_report_type);
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($department != "") ? " $clause serviceunit_no_pk=$department" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(ledger_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $report_data = db::select("SELECT TRUNC (ledger_date) ledger_date,
            SUM (DECODE (MOD.MODULE_CODE, 'PHR-I', LEDGER_AMT_SALES)) ipd_sales,
            SUM (DECODE (MOD.MODULE_CODE, 'PHR', LEDGER_AMT_SALES)) opd_sales,
            NVL (SUM (DECODE (MOD.MODULE_CODE, 'PHR-O', LEDGER_AMT_SALES)), 0)
               ot_sales,
            NVL (SUM (DECODE (MOD.MODULE_CODE, 'PHR-E', LEDGER_AMT_SALES)), 0)
               emr_sales,
            SUM (LEDGER_AMT_SALES) total_sales,
            SUM (LEDGER_AMT_DISCOUNT) discount,
            SUM (LEDGER_AMT_SALES) - SUM (LEDGER_AMT_DISCOUNT) net_sales,
            SUM (LEDGER_AMT_PAYMENT) phr_net_collection
                FROM finc_ledgermst mst, sysc_module MOD
                WHERE mst.module_no_fk = MOD.module_no_pk
                AND MOD.MODULE_CODE IN ('PHR', 'PHR-I', 'PHR-O', 'PHR-E','PHR-D')  $sql_cond
                GROUP BY TRUNC (ledger_date)
                ORDER BY 1");

            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
            $pdf = PDF::loadView("admin.uhl.financial_report.hospital_financial_report_pharmacy", [
                'barcode_no' => $barcode_no, 'report_data' => $report_data,
                'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'dept' => $request->hdn_report_type
            ])->setPaper('a4', 'landscape');
            return $pdf->stream('hospital_financial_Report.pdf');
        } elseif ($request->hdn_report_type == 'PHARMACYSUMMARY') {
            // dd($request->hdn_report_type);
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($department != "") ? " $clause serviceunit_no_pk=$department" : "";
            $clause = ($sql_cond == "") ? " and" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(ledger_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $report_data = db::select("SELECT
            SUM (DECODE (MOD.MODULE_CODE, 'PHR-I', LEDGER_AMT_SALES)) ipd_sales,
            SUM (DECODE (MOD.MODULE_CODE, 'PHR', LEDGER_AMT_SALES)) opd_sales,
            NVL (SUM (DECODE (MOD.MODULE_CODE, 'PHR-O', LEDGER_AMT_SALES)), 0)
               ot_sales,
            NVL (SUM (DECODE (MOD.MODULE_CODE, 'PHR-E', LEDGER_AMT_SALES)), 0)
               emr_sales,
            SUM (LEDGER_AMT_SALES) total_sales,
            SUM (LEDGER_AMT_DISCOUNT) discount,
            SUM (LEDGER_AMT_SALES) - SUM (LEDGER_AMT_DISCOUNT) net_sales,
            SUM (LEDGER_AMT_PAYMENT) phr_net_collection
                FROM finc_ledgermst mst, sysc_module MOD
                WHERE mst.module_no_fk = MOD.module_no_pk
                AND MOD.MODULE_CODE IN ('PHR', 'PHR-I', 'PHR-O', 'PHR-E','PHR-D')  $sql_cond
                ORDER BY 1");

            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();

            if($request->hdn_download_type == 'PDF') {
                $pdf = PDF::loadView("admin.uhl.financial_report.hospital_financial_report_pharmacy_summary", [
                    'barcode_no' => $barcode_no, 'report_data' => $report_data,
                    'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'dept' => $request->hdn_report_type
                ])->setPaper('a4', 'landscape');
                return $pdf->stream('hospital_financial_Report.pdf');
            }
            
            if($request->hdn_download_type == 'EXCEL') {
                $data = ['barcode_no' => $barcode_no, 'report_data' => $report_data, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details];
                $fileToExport = "hospital_financial_report_pharmacy_summary_excel";
                $html = View("admin.uhl.financial_report.hospital_financial_report_pharmacy_summary_excel")->with($data);
                header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
                header("Content-type: application/vnd.ms-excel");
                return $html;
            }            
        } elseif ($request->hdn_report_type == 'DAILYSTATEMENT') {
            // dd($request->hdn_report_type);
            $sql_cond = "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
            // $clause = ($sql_cond == "") ? " where" : " and";
            // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
            $clause = ($sql_cond == "") ? " WHERE" : " and";
            $sql_cond .= ($department != "") ? " $clause su_name ='$department'" : "";
            $clause = ($sql_cond == "") ? " WHERE" : " and";
            $sql_cond .= ($date_from != "") ? " $clause trunc(INVOICE_DATE) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";
            $report_data = db::select("  SELECT su_name,
            SUM (TOT_OPD) opd,
            SUM (TOT_OT) ot,
            SUM (TOT_PHYSIO) procedu_re,
            SUM (TOT_PATHO) pathology,
            SUM (TOT_RAD) radiology,
            SUM (TOTAL_IPD) ipd_adm,
            SUM (TOT_ETT) TOT_ETT,
            SUM (TOT_ENDOSCOPY) endoscopy,
            SUM (TOT_ECHO) echo,
            SUM (TOT_DIALYSIS) dyalysis,
            sum(tot_dressing) dressing
            FROM finc_dailystatement_doc_DETAIL_vw $sql_cond
            GROUP BY su_name
            ORDER BY su_name ASC");

            $title = Auth::user()->user_no_pk . ',' . Auth::user()->user_code;
            $barcode = new BarcodeGenerator();
            $barcode->setText($title);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $barcode_no = $barcode->generate();
            $pdf = PDF::loadView("admin.uhl.financial_report.hospital_financial_report_dailystatement", [
                'barcode_no' => $barcode_no, 'report_data' => $report_data,
                'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details, 'dept' => $request->hdn_report_type
            ])->setPaper('a4', 'landscape');
            return $pdf->stream('hospital_financial_Report.pdf');
        }
    }

    // public function hospitalFinancialReportExcel(Request $request)
    // {
    //     dd($request->all());
    //     $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
    //     $service_unit = $request->request_department;
    //     if (!empty($request->date_from) && !empty($request->date_to)) {

    //         $date_from = "$request->date_from"; //date('Y/m/d', strtotime($request->date_from));
    //         $date_to = "$request->date_to"; //date('Y/m/d', strtotime($request->date_to));

    //     } else {
    //         $date_from = "";
    //         $date_to = "";
    //     }

    //     $sql_cond = "";
    //     $clause = ($sql_cond == "") ? " and" : " and";
    //     $sql_cond .= ($service_unit != "") ? " $clause su_no_fk=$service_unit" : "";
    //     $clause = ($sql_cond == "") ? " and" : " and";
    //     $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

    //     $report_data = db::select("select department_name,no_of_invoice,
    //                 round (sales) sales,
    //                 round (payment) payment,
    //                 round (discount) discount
    //         from (  select su_no_fk,
    //                         fnc_serviceunitname (su_no_fk) department_name,
    //                         count(1) no_of_invoice,
    //                         sum (item_rate * (item_qty - nvl (cancel_qty, 0))) sales,
    //                         sum (invoicedtl_amt_payment) payment,
    //                         sum (invoicedtl_amt_discount) discount
    //                     from finc_invoicedtl dtl, finc_invoicemst mst
    //                     where nvl (cancel_ind, 0) = 0
    //                         and dtl.invoice_no_fk = mst.invoice_no_pk
    //                         $sql_cond
    //                 group by su_no_fk)
    //         order by 1");
    //     $dept_detail_data = $report_data;

    //     $pdf = ['dept_detail_data' => $dept_detail_data, 'from_date' => $date_from, 'to_date' => $date_to, 'po_hospital_details' => $po_hospital_details];

    //     $fileToExport = "department_wise_summary_performance_report"; //dept_sum_wise_report_excel
    //     $html = View("admin.pcrm.referral_v2.IndividualReferralDetails.dept_wise_summmary_excel")->with($pdf);
    //     header("Content-Disposition: attachment; filename=" . $fileToExport . '.xls');
    //     header("Content-type: application/vnd.ms-excel");
    //     return $html;
    // }










    public function hospital2FinancialReportSearch(Request $request)
    {
        //  dd($request->all());

        $major_group = $request->major_group;
        $minor_group = $request->minor_group;
        $allowed_dates = $request->allowed_dates;
        $allowed_dates_to = $request->allowed_dates_to;
        $department = $request->department;
        if (!empty($request->allowed_dates) && !empty($request->allowed_dates_to)) {

            $date_from = "$request->allowed_dates"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->allowed_dates_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }

        $sql_cond = "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($major_group != "") ? " $clause par_itemtype_no_fk=$major_group" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($minor_group != "") ? " $clause ity_group_header_no=$minor_group" : "";
        // $clause = ($sql_cond == "") ? " where" : " and";
        // $sql_cond .= ($department != "") ? " $clause item_serviceunit_no_fk=$department" : "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";


        $report_data = db::select("select * from FINC_INVOICEDTL_DETAIL_MG_VW $sql_cond order by invoice_date,ITEM_SERVICEUNIT_NAME asc");
        // echo "select * from FINC_INVOICEDTL_DETAIL_MG_VW $sql_cond";

        $parent_dt = [];
        $parent_dt_data = $parent_dt;

        if (!empty($report_data)) {
            foreach ($report_data as  $p_dt) {
                $parent_dt[$p_dt->ity_group_header_name][] =  $p_dt;
            }
        }
        $column_name = DB::select(DB::raw("select patient_type_code,count(*) from rpt_01_finc_invoicedtl_detail_vw group by patient_type_code"));
        $column_name2 = DB::select(DB::raw("select module_code,count(*) from rpt_01_finc_invoicedtl_detail_vw group by module_code"));

        return Template::loadview("admin.uhl.financial_report.hospital_financial_list", [
            'report_data' => $report_data,
            'parent_dt' => $parent_dt,
            'column_name' => $column_name,
            'column_name2' => $column_name2,
        ]);
    }

    public function medicalExaminationReportList()
    {
        return Template::loadview("admin.uhl.financial_report.medical_examination_list", [
            'data' => DB::table('labt_med_exam_foreigner_worker')->get()
        ]);
    }
}
