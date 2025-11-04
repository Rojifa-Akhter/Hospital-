<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Traits\ItemData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
use setasign\Fpdf\Fpdf;
use setasign\Fpdi\Fpdi;
use App\Repositories\BaseRepository as Repo;
use App\Models\SampleCollection;
use App\Models\LabInvoiceDtl;
use App\Models\LabTestResult;
use App\Models\Organism;
use App\Models\Speciman;
use App\Models\Donor;
use App\Models\LabTestStructure;
use App\Models\LabTestStructureAnalyzer;
use App\Models\LabTestReferenceValue;
use App\Models\DefaultAttributeValueList;
use App\Traits\UtilitiesTrait;
use Illuminate\Support\Facades\Auth;
use PDO;
use App\Traits\LookupData;
use App\Traits\DatatablesLoader;
use App\Datatables\DataTableClass;
use \PDF;
use Session;
use Illuminate\Support\Facades\Route;
use DateTime;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Carbon;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Illuminate\Database\Console\Migrations\RollbackCommand;
use Illuminate\Support\Facades\DB as FacadesDB;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\Process\Process;
use Illuminate\Support\Facades\File;
use PhpParser\Node\Stmt\Break_;
use Symfony\Component\VarDumper\Cloner\Data;
use Illuminate\Support\Str;
use GuzzleHttp\Client;
use URL;
use Log;

class PathologyController extends Controller
{
    use DatatablesLoader, UtilitiesTrait, ItemData, LookupData;

    protected $model, $invoicedtl, $labtestresult;

    /**
     * Create a new controller instance.
     *
     * @return void
     */
    public function __construct(SampleCollection $samplecollection, LabInvoiceDtl $labinvoicedtl, LabTestResult $labtestresult, LabTestStructure $labTestStructure, Donor $Donor, LabTestStructureAnalyzer $labTestStructureAnalyzer, LabTestReferenceValue $labTestReferenceValue, DefaultAttributeValueList $DefaultAttributeValueList, Organism $Organism, Speciman $Speciman)
    {
        // $this->middleware('auth');

        $this->model = new Repo($samplecollection);
        $this->invoicedtl = new Repo($labinvoicedtl);
        $this->labtestresult = new Repo($labtestresult);
        $this->labTestStructure = new Repo($labTestStructure);
        $this->labTestStructureAnalyzer = new Repo($labTestStructureAnalyzer);
        $this->labTestReferenceValue = new Repo($labTestReferenceValue);
        $this->DefaultAttributeValueList = new Repo($DefaultAttributeValueList);
        $this->Organism = new Repo($Organism);
        $this->Speciman = new Repo($Speciman);
        $this->Donor = new Repo($Donor);
    }

    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
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
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function sampleCollectionCollect(Request $request)
    {
        $type = "collect";
        $prescription_uid = $request->prescription_uid;
        $sample_collection_arr = $invoice_item_arr = [];
        if ($prescription_uid != "") {
            $sample_collection_arr = DB::table("labt_samplecoll_wl_vw")
                ->select('labt_samplecoll_wl_vw.*', 'ipd_admitted_patlist_vw.new_bed_name', 'ipd_admitted_patlist_vw.new_ward_name', 'ipd_admitted_patlist_vw.new_su_name', 'ipd_admitted_patlist_vw.admission_no_pk')
                ->leftJoin("ipd_admitted_patlist_vw", "labt_samplecoll_wl_vw.admission_no_pk", "=", "ipd_admitted_patlist_vw.admission_no_pk")
                ->where("invoice_code", $prescription_uid)
                ->whereNull("sc_sample_coll_key_ind")
                ->orderBy("lab_code", "asc")->get()->toArray();

            $invoice_item_arr = DB::table("labt_invoicedtl_vw")->where("invoice_code", $prescription_uid)->whereNull("sc_sample_coll_key_ind")->orderBy("lab_code", "asc")->get()->toArray();
        }
        $prescription_id = 0;
        $machineName=$this->getLookupListByCode("LABELMACHINE");
        return Template::loadview("admin.pathology.sample_collection_list_collect", ["prescription_id" => $prescription_id, "sample_collection_arr" => $sample_collection_arr, "invoice_item_arr" => $invoice_item_arr, "type" => $type, "prescription_uid" => $prescription_uid,'machineName'=>$machineName]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */

    public function sampleCollectionPending()
    {
        $type = "pending";
        $today = date("m-d-Y", strtotime("1 Days"));
        $from_date = date("m-d-Y", strtotime("-1 Days"));

        $sample_collection_arr = DB::table("labt_samplecoll_wl_vw")
            ->select('labt_samplecoll_wl_vw.*', 'ipd_admitted_patlist_vw.new_bed_name', 'ipd_admitted_patlist_vw.new_ward_name', 'ipd_admitted_patlist_vw.new_su_name', 'ipd_admitted_patlist_vw.admission_no_pk')
            ->leftJoin("ipd_admitted_patlist_vw", "labt_samplecoll_wl_vw.admission_no_pk", "=", "ipd_admitted_patlist_vw.admission_no_pk")
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->whereRaw("invoice_datetime >=to_date('$from_date' ,'mm/dd/yyyy') and invoice_datetime <=to_date('$today' ,'mm/dd/yyyy')")
            ->orderBy("invoice_datetime", "desc")
            ->whereNull("sc_sample_coll_key_ind")
            ->orderBy("lab_code", "desc")->get()->toArray();
        // dd($sample_collection_arr);
        $prescription_id = '';
         $machineName=$this->getLookupListByCode("LABELMACHINE");
        return Template::loadview("admin.pathology.sample_collection_list_pending", ["sample_collection_arr" => $sample_collection_arr, "type" => $type, 'prescription_id' => $prescription_id,'machineName'=>$machineName]);
    }
    public function sampleCollectionPendingIpd()
    {
        $type = "pending";
        $today = date("m-d-Y", strtotime("1 Days"));
        $from_date = date("m-d-Y", strtotime("-1 Days"));

        $sample_collection_arr = DB::table("labt_samplecoll_wl_vw")
            ->select('labt_samplecoll_wl_vw.*', 'ipd_admitted_patlist_vw.new_bed_name', 'ipd_admitted_patlist_vw.new_ward_name', 'ipd_admitted_patlist_vw.new_su_name', 'ipd_admitted_patlist_vw.admission_no_pk')
            ->leftJoin("ipd_admitted_patlist_vw", "labt_samplecoll_wl_vw.admission_no_pk", "=", "ipd_admitted_patlist_vw.admission_no_pk")
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->where('ipd_admitted_patlist_vw.admission_no_pk', '!=', null)
            ->whereRaw("invoice_datetime >=to_date('$from_date' ,'mm/dd/yyyy') and invoice_datetime <=to_date('$today' ,'mm/dd/yyyy')")
            ->orderBy("invoice_datetime", "desc")
            ->whereNull("sc_sample_coll_key_ind")
            ->orderBy("lab_code", "desc")->get()->toArray();
        // dd($sample_collection_arr);
        $prescription_id = '';
         $machineName=$this->getLookupListByCode("LABELMACHINE");
        return Template::loadview("admin.pathology.sample_collection_list_pending_ipd", ["sample_collection_arr" => $sample_collection_arr, "type" => $type, 'prescription_id' => $prescription_id,'machineName'=>$machineName]);
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    public function sampleCollectionCollected()
    {
        $type = "collected";
        $today = date("m-d-Y", strtotime("1 Days"));
        $from_date = date("m-d-Y", strtotime("-1 Days"));
        $sample_collection_arr = DB::table("labt_samplecoll_wl_vw")
            ->select('labt_samplecoll_wl_vw.*', 'ipd_admitted_patlist_vw.new_bed_name', 'ipd_admitted_patlist_vw.new_ward_name', 'ipd_admitted_patlist_vw.new_su_name', 'ipd_admitted_patlist_vw.admission_no_pk')
            ->leftJoin("ipd_admitted_patlist_vw", "labt_samplecoll_wl_vw.admission_no_pk", "=", "ipd_admitted_patlist_vw.admission_no_pk")
            ->where("sc_sample_coll_key_ind", 1)
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->whereRaw("sc_sample_coll_keyed_time >=to_date('$from_date' ,'mm/dd/yyyy') and sc_sample_coll_keyed_time <=to_date('$today' ,'mm/dd/yyyy')")
            ->orderBy("sc_sample_coll_keyed_time", "desc")
            ->get()
            ->toArray();
        $print_type = 'collected';
        // dd($sample_collection_arr);
        $prescription_id = '';
         $machineName=$this->getLookupListByCode("LABELMACHINE");
        return Template::loadview("admin.pathology.sample_collection_list_collected", ["sample_collection_arr" => $sample_collection_arr, "type" => $type, 'prescription_id' => $prescription_id, 'print_type' => $print_type,'machineName'=>$machineName]);
    }
    public function sampleCollectionCollectedIpd()
    {
        $type = "collected";
        $today = date("m-d-Y", strtotime("1 Days"));
        $from_date = date("m-d-Y", strtotime("-1 Days"));
        $sample_collection_arr = DB::table("labt_samplecoll_wl_vw")
            ->select('labt_samplecoll_wl_vw.*', 'ipd_admitted_patlist_vw.new_bed_name', 'ipd_admitted_patlist_vw.new_ward_name', 'ipd_admitted_patlist_vw.new_su_name', 'ipd_admitted_patlist_vw.admission_no_pk')
            ->leftJoin("ipd_admitted_patlist_vw", "labt_samplecoll_wl_vw.admission_no_pk", "=", "ipd_admitted_patlist_vw.admission_no_pk")
            ->where("sc_sample_coll_key_ind", 1)
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->where('ipd_admitted_patlist_vw.admission_no_pk', '!=', null)
            ->whereRaw("sc_sample_coll_keyed_time >=to_date('$from_date' ,'mm/dd/yyyy') and sc_sample_coll_keyed_time <=to_date('$today' ,'mm/dd/yyyy')")
            ->orderBy("sc_sample_coll_keyed_time", "desc")
            ->get()
            ->toArray();
        $print_type = 'collected';
        // dd($sample_collection_arr);
        $prescription_id = '';
         $machineName=$this->getLookupListByCode("LABELMACHINE");
        return Template::loadview("admin.pathology.sample_collection_list_collected_ipd", ["sample_collection_arr" => $sample_collection_arr, "type" => $type, 'prescription_id' => $prescription_id, 'print_type' => $print_type,'machineName'=>$machineName]);
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    public function sampleCollectionPrint($lab_no_pk)
    {

        if(Session::get('user.ses_hospital_code') == 'DMHL'){
            $label_info = DB::table('labt_samplecoll_label_vw')
            ->select('item_code_list', 'lab_code', 'invoice_code', 'test_short_name_list', 'serviceunit_name', 'patient_name', 'patient_code', 'age', 'gender', 'sc_sample_coll_keyed_time', 'coll_seq', 'dob', 'invoice_date', 'lab_daily_serial_no', DB::raw("(INVOICE_CODE) as INVOICE_CODE_SL"))
            ->where('lab_no_pk', $lab_no_pk)
            ->first();
        }else{
            $label_info = DB::table('labt_samplecoll_label_vw')
            ->select('item_code_list', 'lab_code', 'invoice_code', 'test_short_name_list', 'serviceunit_name', 'patient_name', 'patient_code', 'age', 'gender', 'sc_sample_coll_keyed_time', 'coll_seq', 'dob', 'invoice_date', 'lab_daily_serial_no', DB::raw("(INVOICE_CODE || '/' || lab_daily_serial_no) as INVOICE_CODE_SL"))
            ->where('lab_no_pk', $lab_no_pk)
            ->first();
        }



        $barcode = new BarcodeGenerator();
        $barcode->setText($label_info->lab_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(8);
        $data['lab_no_barcode'] = $barcode->generate();
        $data['label_info'] = $label_info;

        if(Session::get('user.ses_hospital_code') == 'DMHL'){
            $pdf = PDF::loadView("admin.pathology.sample_print_dmhl", $data);
        }else{
            $pdf = PDF::loadView("admin.pathology.sample_print", $data);
        }
        return $pdf->stream("SM-$label_info->invoice_code.pdf");
    }
    public function sampleCollectionPrintV2(Request $request)
    {
        try {
            $lab_no = $request->lab_no;

            if ($request->print_type == "AUX") {
                $data = [
                    'print_type' => $request->print_type,
                    'label_print_ind' => 1,
                    'label_print_machine_name' => $request->machine_name,
                ];
            } else {
                $data = [
                    'print_type' => null,
                    'label_print_ind' => 1,
                    'label_print_machine_name' => $request->machine_name,
                ];
            }
            // dd($data);

            DB::table('labt_samplecoll')->where('lab_no_pk', $lab_no)->update($data);
            DB::commit();
            $message = ['meg' => 'Successful', 'print_ind' => 1];
        } catch (\Throwable $th) {
            DB::rollback();
            $message = ['meg' => $th->getMessage(), 'print_ind' => null];
        }
        return response()->json($message);
    }
    public function sampleCollectionPrintAllV2(Request $request)
    {
        try {
            $lab_no = $request->lab_no_array;
            if (!empty($lab_no)) {
                foreach ($lab_no as $key => $value) {
                    $data = [
                        'print_type' => null,
                        'label_print_ind' => 1,
                        'label_print_machine_name' => $request->machine_name,
                    ];
                    DB::table('labt_samplecoll')->where('lab_no_pk', $value)->update($data);
                }
            }
            DB::commit();
            $message = ['meg' => 'Successful', 'print_ind' => 1];
        } catch (\Throwable $th) {
            DB::rollback();
            $message = ['meg' => $th->getMessage(), 'print_ind' => null];
        }
        return response()->json($message);
    }
    public function temporaryLabelPrint($lab_no_pk)
    {

        $label_info = DB::table('labt_samplecoll_label_vw')
            ->select('item_code_list', 'lab_code', 'invoice_code', 'test_short_name_list', 'serviceunit_name', 'patient_name', 'patient_code', 'age', 'sc_sample_coll_keyed_time', 'coll_seq', 'dob', 'invoice_date', 'lab_daily_serial_no', DB::raw("(INVOICE_CODE || '/' || lab_daily_serial_no) as INVOICE_CODE_SL"))
            ->where('lab_no_pk', $lab_no_pk)
            ->first();

        $barcode = new BarcodeGenerator();
        $barcode->setText($label_info->invoice_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(8);

        $data['lab_no_barcode'] = $barcode->generate();
        $data['label_info'] = $label_info;
        // return view("admin.pathology.temporary_label_print", $data);

        $pdf = PDF::loadView("admin.pathology.temporary_label_print", $data);
        return $pdf->stream("SM-$label_info->invoice_code.pdf");
    }
    public function slideLabelPrint($lab_no_pk)
    {

        $label_info = DB::table('labt_samplecoll_label_vw')
            ->select('item_code_list', 'lab_code', 'invoice_code', 'test_short_name_list', 'serviceunit_name', 'patient_name', 'patient_code', 'age', 'sc_sample_coll_keyed_time', 'coll_seq', 'dob', 'invoice_date', 'lab_daily_serial_no', DB::raw("(INVOICE_CODE || '/' || lab_daily_serial_no) as INVOICE_CODE_SL"))
            ->where('lab_no_pk', $lab_no_pk)
            ->first();

        $barcode = new BarcodeGenerator();
        $barcode->setText($label_info->invoice_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(8);

        $data['lab_no_barcode'] = $barcode->generate();
        $data['label_info'] = $label_info;
        $pdf = PDF::loadView("admin.pathology.slide_label_print", $data);
        return $pdf->stream("SM-$label_info->invoice_code.pdf");
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    //     public function sampleBillInvoice($prescription_id)
    //     {

    //         DB::beginTransaction();
    //         try {

    //             $procedureName = "pkg_bafbilling.prc_billinvoice";
    //             $outError = $out_invoice_id = $out_invoice_no = '';
    //             $dataBindingArr = [
    //                 'in_prescription_no_fk' => $prescription_id,
    //                 'in_au_entry_by' => Auth::id(),
    //                 'in_au_entry_session' => 'session',
    //                 'in_au_entry_hospital_pk_no' => 1,
    //                 'out_invoice_no' => [
    //                     'value' => &$out_invoice_no,
    //                     'type'  => PDO::PARAM_INT
    //                 ],
    //                 'out_invoice_id' => [
    //                     'value' => &$out_invoice_id,
    //                     'type'  => PDO::PARAM_STR,
    //                     'length'=> 500
    //                 ],
    //                 'out_error' => [
    //                     'value' => &$outError,
    //                     'type'  => PDO::PARAM_STR,
    //                     'length'=> 500
    //                 ]
    //             ];
    //             $result = DB::executeProcedure($procedureName, $dataBindingArr);
    //             if ($outError == '000') {
    //                 DB::commit();
    //             }
    //             else
    //             {
    //                 DB::rollback();
    //             }

    //         } catch (\Exception $e) {

    //             DB::rollback();
    //         }
    //     }

    //      /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    public function searchSampleCollection(Request $request)
    {
        $prescription_id = $request->prescription_id;
        $lab_id = $request->lab_id;
        $admission_id = $request->admission_id;
        $type = $request->type;

        // Date-wise search
        $from_date = $request->input('search_date_from')  ? date('Y-m-d',strtotime(  $request->input('search_date_from'))) : null;

        $to_date = $request->input('search_date_to')
            ? date('Y-m-d',strtotime(  $request->input('search_date_to'))) : null;



            // $check_presc_in_invoice = DB::table("labt_invoicedtl a")->join("psn_t_prescription b","a.prescription_no_fk","=","b.prescription_no_pk")->where("b.prescription_uid", $prescription_id)->get()->toArray();

            // if($type == "collect" && empty($check_presc_in_invoice)){
        //     $this->sampleBillInvoice($prescription_id);
        // }

        $patient_info = DB::table("labt_invoicedtl_vw a")
        ->select("b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "b.pat_relation", "b.ref_patient_gender", "b.ref_blood_group", "b.ref_age", "b.blood_group_txt", "c.new_bed_name", "c.new_ward_name", "c.new_su_name", "c.admission_no_pk", DB::raw('pat_age(b.dob,nvl(b.dod,sysdate))pat_age'))
        ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
        ->leftJoin("ipd_admitted_patlist_vw c", "a.admission_no_pk", "=", "c.admission_no_pk")
        ->orWhere("a.invoice_code", $prescription_id)
        ->orWhere("a.lab_code", $lab_id)
        ->whereNull("a.sc_sample_coll_key_ind")
        ->first();
        $sampleCollectionCount=DB::table('labt_invoicedtl_vw')->where("invoice_code", $prescription_id)->where('sc_sample_coll_key_ind',1)->count();
        if ($type == "collected" || $type == "ipd_collected") {
            $print_type =  $type;


            if ($lab_id != null && $prescription_id != null) {
                $sample_collection_arr_data = DB::table("labt_samplecoll_wl_vw")
                ->select('labt_samplecoll_wl_vw.*', 'ipd_admitted_patlist_vw.new_bed_name', 'ipd_admitted_patlist_vw.new_ward_name', 'ipd_admitted_patlist_vw.new_su_name')
                ->leftJoin("ipd_admitted_patlist_vw", "labt_samplecoll_wl_vw.admission_no_pk", "=", "ipd_admitted_patlist_vw.admission_no_pk")
                ->Where("invoice_code", $prescription_id)
                ->Where("lab_code", $lab_id)
                ->where("sc_sample_coll_key_ind", 1)
                ->whereNull('cancel_ind');




                if ($type == "ipd_collected") {
                    $sample_collection_arr_data->where('labt_samplecoll_wl_vw.admission_no_pk', '!=', NULL);
                }
                // DATE FILTER ADDED HERE
                if ($from_date && $to_date) {
                    $sample_collection_arr_data->whereRaw("TRUNC(sc_sample_coll_keyed_time) BETWEEN '$from_date' and  '$to_date'");
                }
                $sample_collection_arr = $sample_collection_arr_data->orderBy("lab_code", "asc")->get()->toArray();

            } elseif ($lab_id == null && $prescription_id != null) {

                $sample_collection_arr_data = DB::table("labt_samplecoll_wl_vw")
                    ->select('labt_samplecoll_wl_vw.*', 'ipd_admitted_patlist_vw.new_bed_name', 'ipd_admitted_patlist_vw.new_ward_name', 'ipd_admitted_patlist_vw.new_su_name')
                    ->leftJoin("ipd_admitted_patlist_vw", "labt_samplecoll_wl_vw.admission_no_pk", "=", "ipd_admitted_patlist_vw.admission_no_pk")
                    ->Where("invoice_code", $prescription_id)
                    ->where("sc_sample_coll_key_ind", 1)
                    ->whereNull('cancel_ind');
                    if ($type == "ipd_collected") {
                        $sample_collection_arr_data->where('labt_samplecoll_wl_vw.admission_no_pk', '!=', NULL);
                    }
                    // DATE FILTER ADDED HERE
                if ($from_date && $to_date) {
                    $sample_collection_arr_data->whereRaw("TRUNC(sc_sample_coll_keyed_time) BETWEEN '$from_date' and  '$to_date'");
                }
                    $sample_collection_arr = $sample_collection_arr_data->orderBy("lab_code", "asc")->get()->toArray();
                } elseif ($lab_id == null && $prescription_id == null && $admission_id != null) {

                    $sample_collection_arr_data = DB::table("labt_samplecoll_wl_vw")
                    ->select('labt_samplecoll_wl_vw.*', 'ipd_admitted_patlist_vw.new_bed_name', 'ipd_admitted_patlist_vw.new_ward_name', 'ipd_admitted_patlist_vw.new_su_name')
                    ->leftJoin("ipd_admitted_patlist_vw", "labt_samplecoll_wl_vw.admission_no_pk", "=", "ipd_admitted_patlist_vw.admission_no_pk")
                    ->Where("ipd_admitted_patlist_vw.admission_no_pk", $admission_id)
                    ->where("sc_sample_coll_key_ind", 1)
                    ->whereNull('cancel_ind');
                    // if ($type == "ipd_collected") {
                        //     $sample_collection_arr_data->where('labt_samplecoll_wl_vw.admission_no_pk', '!=', NULL);
                        // }else{

                        // }
                        // DATE FILTER ADDED HERE
                        if ($from_date && $to_date) {
                            $sample_collection_arr_data->whereRaw("TRUNC(sc_sample_coll_keyed_time) BETWEEN '$from_date' and  '$to_date'");
                        }
                        $sample_collection_arr = $sample_collection_arr_data->orderBy("lab_code", "asc")->get()->toArray();
                } else {
                        $sample_collection_arr_data = DB::table("labt_samplecoll_wl_vw")
                        ->select('labt_samplecoll_wl_vw.*', 'ipd_admitted_patlist_vw.new_bed_name', 'ipd_admitted_patlist_vw.new_ward_name', 'ipd_admitted_patlist_vw.new_su_name')
                        ->leftJoin("ipd_admitted_patlist_vw", "labt_samplecoll_wl_vw.admission_no_pk", "=", "ipd_admitted_patlist_vw.admission_no_pk")
                    // ->Where("lab_code", $lab_id)
                    ->where("sc_sample_coll_key_ind", 1)
                    ->whereNull('cancel_ind');
                if ($type == "ipd_collected") {
                    $sample_collection_arr_data->where('labt_samplecoll_wl_vw.admission_no_pk', '!=', NULL);
                }
                // DATE FILTER ADDED HERE

                if ($from_date && $to_date) {
                    $sample_collection_arr_data->whereRaw("TRUNC(sc_sample_coll_keyed_time) BETWEEN '$from_date' and  '$to_date'");
                }

                $sample_collection_arr = $sample_collection_arr_data->orderBy("lab_code", "asc")->get()->toArray();
            //    dd($sample_collection_arr, $sample_collection_arr_data->get());
            }
        } else {
            $print_type = $type;
            if ($lab_id != null && $prescription_id != null) {
                $sample_collection_arr_data = DB::table("labt_samplecoll_wl_vw")
                ->select('labt_samplecoll_wl_vw.*', 'ipd_admitted_patlist_vw.new_bed_name', 'ipd_admitted_patlist_vw.new_ward_name', 'ipd_admitted_patlist_vw.new_su_name')
                    ->leftJoin("ipd_admitted_patlist_vw", "labt_samplecoll_wl_vw.admission_no_pk", "=", "ipd_admitted_patlist_vw.admission_no_pk")
                    ->Where("invoice_code", $prescription_id)
                    ->Where("lab_code", $lab_id)
                    ->where("sc_sample_coll_key_ind", NULL)
                    ->where('cancel_ind', NULL);
                if ($type == "ipd_collect") {
                    $sample_collection_arr_data->where('labt_samplecoll_wl_vw.admission_no_pk', '!=', NULL);
                }

                $sample_collection_arr = $sample_collection_arr_data->orderBy("lab_code", "asc")->get()->toArray();
            } elseif ($lab_id == null && $prescription_id != null) {

                $sample_collection_arr_data = DB::table("labt_samplecoll_wl_vw")
                ->select('labt_samplecoll_wl_vw.*', 'ipd_admitted_patlist_vw.new_bed_name', 'ipd_admitted_patlist_vw.new_ward_name', 'ipd_admitted_patlist_vw.new_su_name')
                ->leftJoin("ipd_admitted_patlist_vw", "labt_samplecoll_wl_vw.admission_no_pk", "=", "ipd_admitted_patlist_vw.admission_no_pk")
                ->Where("invoice_code", $prescription_id)
                ->where("sc_sample_coll_key_ind", NULL)
                ->where('cancel_ind', NULL);
                if ($type == "ipd_collect") {
                    $sample_collection_arr_data->where('labt_samplecoll_wl_vw.admission_no_pk', '!=', NULL);
                }
                $sample_collection_arr = $sample_collection_arr_data->orderBy("lab_code", "asc")->get()->toArray();
                // dd( $sample_collection_arr);

            } elseif ($lab_id == null && $prescription_id == null && $admission_id != null) {

                $sample_collection_arr_data = DB::table("labt_samplecoll_wl_vw")
                ->select('labt_samplecoll_wl_vw.*', 'ipd_admitted_patlist_vw.new_bed_name', 'ipd_admitted_patlist_vw.new_ward_name', 'ipd_admitted_patlist_vw.new_su_name')
                ->leftJoin("ipd_admitted_patlist_vw", "labt_samplecoll_wl_vw.admission_no_pk", "=", "ipd_admitted_patlist_vw.admission_no_pk")
                ->Where("ipd_admitted_patlist_vw.admission_no_pk", $admission_id)
                ->where("sc_sample_coll_key_ind", NULL)
                ->where('cancel_ind', NULL);
                if ($type == "ipd_collect") {
                    $sample_collection_arr_data->where('labt_samplecoll_wl_vw.admission_no_pk', '!=', NULL);
                }
                $sample_collection_arr = $sample_collection_arr_data->orderBy("lab_code", "asc")->get()->toArray();
                // dd( $sample_collection_arr);

            } else {
                $sample_collection_arr_data = DB::table("labt_samplecoll_wl_vw")
                ->select('labt_samplecoll_wl_vw.*', 'ipd_admitted_patlist_vw.new_bed_name', 'ipd_admitted_patlist_vw.new_ward_name', 'ipd_admitted_patlist_vw.new_su_name')
                ->leftJoin("ipd_admitted_patlist_vw", "labt_samplecoll_wl_vw.admission_no_pk", "=", "ipd_admitted_patlist_vw.admission_no_pk")
                    // ->Where("invoice_code", $prescription_id)
                    ->orWhere("lab_code", $lab_id)
                    ->where("sc_sample_coll_key_ind", NULL)
                    ->where('cancel_ind', NULL);
                    if ($type == "ipd_collect") {
                        $sample_collection_arr_data->where('labt_samplecoll_wl_vw.admission_no_pk', '!=', NULL);
                    }
                    $sample_collection_arr = $sample_collection_arr_data->orderBy("lab_code", "asc")->get()->toArray();
                };
            }
//             $sample_collection_arr = $sample_collection_arr_data->get(); // <-- execute
// dd($sample_collection_arr);





        if ($lab_id != null && $prescription_id != null) {
            $invoice_item_arr = DB::table("labt_invoicedtl_vw")
                ->orWhere("invoice_code", $prescription_id)
                ->Where("lab_code", $lab_id)
                ->whereNull("sc_sample_coll_key_ind")
                ->whereNull('cancel_ind')
                ->orderBy("lab_code", "asc")
                ->get()
                ->toArray();
        } elseif ($lab_id == null && $prescription_id != null) {
            $invoice_item_arr = DB::table("labt_invoicedtl_vw")
                ->orWhere("invoice_code", $prescription_id)
                ->whereNull("sc_sample_coll_key_ind")
                ->whereNull('cancel_ind')
                ->orderBy("lab_code", "asc")
                ->get()
                ->toArray();
            // dd($invoice_item_arr);
        } elseif ($lab_id == null && $prescription_id == null && $admission_id != null) {

            $invoice_item_arr = DB::table("labt_invoicedtl_vw")
                ->orWhere("admission_no_pk", $admission_id)
                ->whereNull("sc_sample_coll_key_ind")
                ->whereNull('cancel_ind')
                ->orderBy("lab_code", "asc")
                ->get()
                ->toArray();
                if(Session::get('user.ses_hospital_code') == 'DMHL'){
                    if(!empty($invoice_item_arr)){
                        $prescription_id = $invoice_item_arr[0]->invoice_no_fk;
                    }
                }

        } else {
            $invoice_item_arr = DB::table("labt_invoicedtl_vw")
                ->Where("lab_code", $lab_id)
                ->whereNull("sc_sample_coll_key_ind")
                ->whereNull('cancel_ind')
                ->orderBy("lab_code", "asc")
                ->get()
                ->toArray();
        }

        if ($type == "lab_no_split") {
            $type_collect = 'collect';

            return Template::loadview("admin.pathology.sample_collection_list_dtl", ["prescription_id" => $prescription_id, "sample_collection_arr" => $sample_collection_arr, "invoice_item_arr" => $invoice_item_arr, "type" => $type_collect, "patient_info" => $patient_info, 'print_type' => $type_collect,'sampleCollectionCount'=>$sampleCollectionCount]);
        } else {

            return Template::loadview("admin.pathology.sample_collection_list", ["prescription_id" => $prescription_id, "sample_collection_arr" => $sample_collection_arr, "invoice_item_arr" => $invoice_item_arr, "type" => $type, "patient_info" => $patient_info, 'print_type' => $print_type,'sampleCollectionCount'=>$sampleCollectionCount]);
        }
    }
    public function pathStrucSplit(Request $request)
    {
        try {
            $auth_id = Auth::id();
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $in_au_entry_session = 'session';
            $lab_no = $request->labId;
            $invoiceDtl = $request->invoiceDtl;
            DB::beginTransaction();
            $out_error = $out_lab_code = $lab_no_pk = "";
            $pdo2 = DB::getPdo();
            $pathStrucSplit = $pdo2->prepare("begin pkg_emr.pathology_struct_split(
                            :in_lab_no_pk,
                            :in_pathinvoicedtl_no_pk,
                            :in_au_entry_by,
                            :in_au_entry_session,
                            :in_au_entry_hospital_no_pk,
                            :out_error,
                            :out_lab_no_pk,
                            :out_lab_code
                        );
                            end;");

            $pathStrucSplit->bindParam(':in_lab_no_pk', $lab_no);
            $pathStrucSplit->bindParam(':in_pathinvoicedtl_no_pk', $invoiceDtl);
            $pathStrucSplit->bindParam(':in_au_entry_by', $auth_id);
            $pathStrucSplit->bindParam(':in_au_entry_session', $in_au_entry_session);
            $pathStrucSplit->bindParam(':in_au_entry_hospital_no_pk', $ses_hospital_id);
            $pathStrucSplit->bindParam(':out_error', $out_error, PDO::PARAM_STR, 500);
            $pathStrucSplit->bindParam(':out_lab_no_pk', $lab_no_pk, PDO::PARAM_STR, 500);
            $pathStrucSplit->bindParam(':out_lab_code', $out_lab_code, PDO::PARAM_STR, 500);
            $pathStrucSplit->execute();

            if ($out_error == 999) {
                DB::rollback();
                $message = ['msg' => 'Pay Amount Failled.', 'title' => 'Error'];
            } else {

                DB::commit();
                $message = ['msg' => 'New Bill created successfully.', 'insertedId' => $lab_no_pk, 'out_lab_code' => $out_lab_code, 'title' => 'Success'];
            }
        } catch (\Throwable $th) {
            $message = ['msg' => $th, 'title' => 'Error'];
        }

        return response()->json($message);
    }

    //      /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */
    public function storeSampleCollection(Request $request)
    {

        $id = $request->id;
        $auth_id = Auth::id();


        $dt = new DateTime('now', new \DateTimeZone('Asia/Dhaka'));
        $date = $dt->format('Y-m-d H:i');

        DB::beginTransaction();
        try {
            $chk_sample = $request->chk_sample;

            $ids = [];
            for ($i = 0; $i < sizeof($chk_sample); $i++) {
                $abgTest=DB::table('labt_samplecoll')->join('labt_invoicedtl','labt_invoicedtl.lab_no_fk','=','labt_samplecoll.lab_no_pk')->join('sysc_serviceitem','sysc_serviceitem.item_no_pk','=','labt_invoicedtl.item_no_fk')->where('lab_no_pk',$chk_sample[$i])->value('sysc_serviceitem.item_code');
                // dd($abgTest);
               
                if ($abgTest =="ABG") {
                    $data = [
                        'sc_sample_coll_key_ind' => 1,
                        'lab_rcv_from_sp_key_ind' => 1,
                        'sc_sample_coll_keyed_by' => $auth_id,
                        'sc_sample_coll_keyed_time' => $date,
                        'lab_rcv_from_sp_keyed_time' => $date
                    ];
                }else{
                     $data = [
                        'sc_sample_coll_key_ind' => 1,
                        'sc_sample_coll_keyed_by' => $auth_id,
                        'sc_sample_coll_keyed_time' => $date
                    ];
                }
                DB::table('labt_samplecoll')->where('lab_no_pk',$chk_sample[$i])->update($data);
                // $ids[] = $chk_sample[$i];
            }


            // $this->model->bulk_update($data, "lab_no_pk", $ids);

            $delivery_date = $request->delivery_date;
            $sample_item_dtl = $request->chk_sample_item_dtl;
            // dd( $chk_sample, $sample_item_dtl);
            $dtlids = [];
            for ($j = 0; $j < count($sample_item_dtl); $j++) {
                 $abgTes2=DB::table('labt_invoicedtl')->join('sysc_serviceitem','sysc_serviceitem.item_no_pk','=','labt_invoicedtl.item_no_fk')->where('pathinvoicedtl_no_pk',$sample_item_dtl[$j])->value('sysc_serviceitem.item_code');
                // dd($abgTes2);
                 if ($abgTes2 =="ABG") {
                     $dtldata = [
                        'sc_sample_coll_key_ind' => 1,                        
                        'lab_rcv_from_sp_key_ind'  =>1,
                        'lab_result_verify_key_ind'  =>1,
                        'lab_result_final_key_ind'  =>1,
                        'sc_sample_coll_keyed_by' => $auth_id,
                        'sc_sample_coll_keyed_time' => $date,
                        'report_delivery_date' => date("Y-m-d", strtotime($delivery_date[$j]))
                    ];
                 }else{
                     $dtldata = [
                        'sc_sample_coll_key_ind' => 1,
                        'sc_sample_coll_keyed_by' => $auth_id,
                        'sc_sample_coll_keyed_time' => $date,
                        'report_delivery_date' => date("Y-m-d", strtotime($delivery_date[$j]))
                    ];
                 }
                // $dtlids[] = $sample_item_dtl[$j];
                 DB::table('labt_invoicedtl')->where('pathinvoicedtl_no_pk',$sample_item_dtl[$j])->update($dtldata);
            }
            // dd($dtldata);
            // $this->invoicedtl->bulk_update($dtldata, "pathinvoicedtl_no_pk", $dtlids);
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function sampleReceive()
    {
        $department_data = $this->getServiceUnitByInd("PATHOLOGY_IND");
        $indicator = "pending";
        $receive_arr = DB::table("labt_samplelabrcv_wl_vw")
            ->select('labt_samplelabrcv_wl_vw.*', 'finc_invoicemst.patient_code', 'finc_invoicemst.admission_no_pk', 'patn_registration.patient_name')
            ->leftjoin('finc_invoicemst', 'finc_invoicemst.invoice_no_pk', '=', 'labt_samplelabrcv_wl_vw.invoice_no_fk')
            ->leftjoin('patn_registration', 'patn_registration.patient_no_pk', '=', 'finc_invoicemst.patient_no_fk')
            ->where("sc_sample_coll_key_ind", 1)
            ->whereNull("lab_rcv_from_sp_key_ind")
            ->where('report_delivery_date', '>=', Carbon::today())
            ->whereNull('cancel_ind')
            ->get();

        return Template::loadview("admin.pathology.sample_receive", [
            "department_data" => $department_data,
            "indicator" => $indicator,
            "receive_arr" => $receive_arr
        ]);
    }

    public function searchSampleReceive(Request $request)
    {
        $lab_no = $request->lab_no;
        $invoice_no = $request->invoice_no;
        $type = $request->type;

        $hospital_id = Session::get('user.ses_hospital_no_pk');

        if ($type == "pending") {
            $receive_arrs = DB::table("labt_samplelabrcv_wl_vw")
                ->select('labt_samplelabrcv_wl_vw.*', 'finc_invoicemst.patient_code', 'finc_invoicemst.admission_no_pk', 'patn_registration.patient_name')
                ->leftjoin('finc_invoicemst', 'finc_invoicemst.invoice_no_pk', '=', 'labt_samplelabrcv_wl_vw.invoice_no_fk')
                ->leftjoin('patn_registration', 'patn_registration.patient_no_pk', '=', 'finc_invoicemst.patient_no_fk')
                ->where('labt_samplelabrcv_wl_vw.au_entry_hospital_pk_no', $hospital_id)
                ->where("labt_samplelabrcv_wl_vw.sc_sample_coll_key_ind", 1)
                ->whereNull("labt_samplelabrcv_wl_vw.lab_rcv_from_sp_key_ind")
                ->whereNull('labt_samplelabrcv_wl_vw.cancel_ind');
            if ($invoice_no != "") {
                $receive_arrs->where("labt_samplelabrcv_wl_vw.invoice_no_fk", $invoice_no);
            }
            if ($lab_no != "") {
                $receive_arrs->where("labt_samplelabrcv_wl_vw.lab_uid", $lab_no);
            }

            $receive_arr = $receive_arrs->get();
            // dd($receive_arr);

            return Template::loadview("admin.pathology.sample_receive_list_pending", ["receive_arr" => $receive_arr]);
        } else {

            $receive_arrs = DB::table("labt_samplelabrcv_wl_vw")
                ->select('labt_samplelabrcv_wl_vw.*', 'finc_invoicemst.patient_code', 'finc_invoicemst.admission_no_pk', 'patn_registration.patient_name')
                ->leftjoin('finc_invoicemst', 'finc_invoicemst.invoice_no_pk', '=', 'labt_samplelabrcv_wl_vw.invoice_no_fk')
                ->leftjoin('patn_registration', 'patn_registration.patient_no_pk', '=', 'finc_invoicemst.patient_no_fk')
                ->where('labt_samplelabrcv_wl_vw.au_entry_hospital_pk_no', $hospital_id)

                ->where("labt_samplelabrcv_wl_vw.lab_rcv_from_sp_key_ind", 1)
                ->whereNull('labt_samplelabrcv_wl_vw.cancel_ind');
            if ($invoice_no != "") {
                $receive_arrs->where("labt_samplelabrcv_wl_vw.invoice_no_fk", $invoice_no);
            }
            if ($lab_no != "") {
                $receive_arrs->where("labt_samplelabrcv_wl_vw.lab_uid", $lab_no);
            }
            $receive_arr = $receive_arrs->get();
            // dd( $receive_arr);
            return Template::loadview("admin.pathology.sample_receive_list_received_list", ["receive_arr" => $receive_arr]);
        }
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    public function getPendingReceiveSample(Request $request)
    {
        $lab_no = $request->lab_no;
        $receive_arr = DB::table("labt_samplelabrcv_wl_vw")->where("lab_code", $lab_no)->whereNull("lab_rcv_from_sp_key_ind")->whereNull('cancel_ind')->get();
        return Template::loadview("admin.pathology.sample_receive_list_pending", ["receive_arr" => $receive_arr]);
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    public function getReceivedSample(Request $request)
    {
        $lab_no = $request->lab_no;
        $department_data = $this->getServiceUnitByInd("PATHOLOGY_IND");
        $indicator = "receive";
        $today = date("Y-m-d");
        $from_date = date("Y-m-d", strtotime("-7 Days"));
        $receive_arr = DB::table('labt_samplelabrcv_wl_vw')
            ->select(
                'labt_samplelabrcv_wl_vw.*',
                'finc_invoicemst.patient_code',
                'finc_invoicemst.admission_no_pk',
                'patn_registration.patient_name'
            )
            ->leftJoin('finc_invoicemst', 'finc_invoicemst.invoice_no_pk', '=', 'labt_samplelabrcv_wl_vw.invoice_no_fk')
            ->leftJoin('patn_registration', 'patn_registration.patient_no_pk', '=', 'finc_invoicemst.patient_no_fk')
            ->where('labt_samplelabrcv_wl_vw.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('labt_samplelabrcv_wl_vw.lab_rcv_from_sp_key_ind', 1)
            ->whereNull('labt_samplelabrcv_wl_vw.cancel_ind')
            ->whereRaw('TRUNC(labt_samplelabrcv_wl_vw.lab_rcv_from_sp_keyed_time) >= ?', [$from_date])
            ->whereRaw('TRUNC(labt_samplelabrcv_wl_vw.lab_rcv_from_sp_keyed_time) <= ?', [$today])
            ->orderBy('labt_samplelabrcv_wl_vw.lab_no_pk', 'desc')
            ->get();
        return Template::loadview("admin.pathology.sample_receive_list_received", ["receive_arr" => $receive_arr, "department_data" => $department_data, "indicator" => $indicator]);
    }
    public function getReceivedSampleList(Request $request)
    {
        $lab_no = $request->lab_no;
        $department_data = $this->getServiceUnitByInd("PATHOLOGY_IND");
        $indicator = "receive";
        $today = date("Y-m-d");
        $from_date = date("Y-m-d", strtotime("-7 Days"));
        $receive_arr = DB::table('labt_samplelabrcv_wl_vw')
            ->select(
                'labt_samplelabrcv_wl_vw.*',
                'finc_invoicemst.patient_code',
                'finc_invoicemst.admission_no_pk',
                'patn_registration.patient_name'
            )
            ->leftJoin('finc_invoicemst', 'finc_invoicemst.invoice_no_pk', '=', 'labt_samplelabrcv_wl_vw.invoice_no_fk')
            ->leftJoin('patn_registration', 'patn_registration.patient_no_pk', '=', 'finc_invoicemst.patient_no_fk')
            ->where('labt_samplelabrcv_wl_vw.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('labt_samplelabrcv_wl_vw.lab_rcv_from_sp_key_ind', 1)
            ->whereNull('labt_samplelabrcv_wl_vw.cancel_ind')
            ->whereRaw('TRUNC(labt_samplelabrcv_wl_vw.lab_rcv_from_sp_keyed_time) >= ?', [$from_date])
            ->whereRaw('TRUNC(labt_samplelabrcv_wl_vw.lab_rcv_from_sp_keyed_time) <= ?', [$today])
            ->orderBy('labt_samplelabrcv_wl_vw.lab_no_pk', 'desc')
            ->get();
        return Template::loadview("admin.pathology.sample_receive_list_received_list_v2", ["receive_arr" => $receive_arr, "department_data" => $department_data, "indicator" => $indicator]);
    }
    public function getReceivedSampleV2(Request $request)
    {

        return Template::loadview("admin.pathology.sample_receive_list_received_v2");
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    public function storeSampleReceive(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            if (!empty($request->itemArray)) {
                for ($i = 0; $i < count($request->itemArray); $i++) {
                    $lab_id = $request->itemArray[$i];
                    $data = [
                        'lab_rcv_from_sp_key_ind' => 1,
                        'lab_rcv_from_sp_keyed_by' => $auth_id,
                        'lab_rcv_from_sp_keyed_time' => date("Y-m-d H:i")
                    ];
                    LabInvoiceDtl::where("lab_no_fk", $lab_id)->update($data);
                    SampleCollection::where("lab_no_pk", $lab_id)->update($data);
                }
            } else {
                $lab_id = $request->lab_id;
                $data = [
                    'lab_rcv_from_sp_key_ind' => 1,
                    'lab_rcv_from_sp_keyed_by' => $auth_id,
                    'lab_rcv_from_sp_keyed_time' => date("Y-m-d H:i")
                ];
                LabInvoiceDtl::where("lab_no_fk", $lab_id)->update($data);
                SampleCollection::where("lab_no_pk", $lab_id)->update($data);
            }





            DB::commit();
            $message = ['msg' => 'Sample Receive completed Successfully', 'title' => 'Success', 'item' => $request->itemArray];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function storeSampleReceiveV2(Request $request)
    {
        $lab_id = $request->lab_id;
        $auth_id = Auth::id();
        $check_receive_ind = SampleCollection::where("lab_code", $lab_id)->where('lab_rcv_from_sp_key_ind', 1)->first();
        $check_lab_no = SampleCollection::where("lab_code", $lab_id)->first();
        // $lab_no= LabInvoiceDtl::select('lab_no_fk')->where("lab_code", $lab_id)->first();
        if ($check_lab_no->sc_sample_coll_key_ind == null) {
            $message = ['msg' => 'Sample is no collected yet ! pls collect sample first', 'title' => 'Error'];
            return response()->json($message);
        }

        if (!empty($check_receive_ind)) {
            $message = ['msg' => 'This Sample Already Received', 'title' => 'Error'];
            return response()->json($message);
        } elseif (empty($check_lab_no)) {
            $message = ['msg' => ' Sample ID Not Found', 'title' => 'Error'];
            return response()->json($message);
        }

        DB::beginTransaction();
        try {
            $lab_id = $request->lab_id;
            $data = [
                'lab_rcv_from_sp_key_ind' => 1,
                'lab_rcv_from_sp_keyed_by' => $auth_id,
                'lab_rcv_from_sp_keyed_time' => date("Y-m-d H:i")
            ];
            LabInvoiceDtl::where("lab_no_fk", $check_lab_no->lab_no_pk)->update($data);
            SampleCollection::where("lab_code", $lab_id)->update($data);


            DB::commit();
            $message = ['msg' => 'Sample Receive completed Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    public function resultEntry()
    {

        $type = 1;
        $today = date('d-m-Y', strtotime("-30 Days"));
        $operation = 'prepare';
        $hospital_id = Session::get('user.ses_hospital_no_pk');

        $user_service_unit =  DB::table('sysc_grant_su')
            ->select('su_no_fk')
            ->where('user_no_fk', Auth::user()->user_no_pk)
            ->where('status', 1)
            ->get();

        $user_service_list = 0;
        if (!empty($user_service_unit)) {
            $user_service_list = $user_service_unit->implode('su_no_fk', ',');
        }
        // dd( $user_service_unit, $user_service_list);
        $invoice_item_arr = DB::table("labt_invoicedtl_vw")
            ->select(
                'labt_invoicedtl_vw.invoice_date',
                'labt_invoicedtl_vw.invoice_code',
                'labt_invoicedtl_vw.lab_no_pk',
                'labt_invoicedtl_vw.lab_code',
                'labt_invoicedtl_vw.admission_no_pk',
                'labt_invoicedtl_vw.sc_sample_coll_keyed_time',
                'labt_invoicedtl_vw.lab_rcv_from_sp_keyed_time',
                'labt_invoicedtl_vw.item_name',
                'labt_invoicedtl_vw.sam_name',
                'labt_invoicedtl_vw.container_name',
                'labt_invoicedtl_vw.analyzer_ind',
                'labt_invoicedtl_vw.mac_result_date',
                'labt_invoicedtl_vw.lab_result_final_key_ind',
                'labt_invoicedtl_vw.lab_result_verify_key_ind',
                'labt_invoicedtl_vw.lab_result_prepared_key_ind',
                'labt_invoicedtl_vw.form_url',
                'labt_invoicedtl_vw.report_no_fk',
                'labt_invoicedtl_vw.status',
                'labt_invoicedtl_vw.delivery_status_no',
                'labt_invoicedtl_vw.report_url',
                'patn_registration.patient_code',
                'patn_registration.patient_name',
            )
            ->leftjoin('patn_registration', 'patn_registration.patient_no_pk', '=', 'labt_invoicedtl_vw.patient_no_fk')
            ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'labt_invoicedtl_vw.admission_no_pk')
            ->select('labt_invoicedtl_vw.*','ipd_admitted_patlist_vw.new_bed_name','ipd_admitted_patlist_vw.new_ward_name','ipd_admitted_patlist_vw.new_su_name')
            ->where('labt_invoicedtl_vw.au_entry_hospital_pk_no', $hospital_id)
            ->where("labt_invoicedtl_vw.lab_rcv_from_sp_key_ind", 1)
            ->whereNull("labt_invoicedtl_vw.lab_result_verify_key_ind")
            ->whereNull("labt_invoicedtl_vw.lab_result_final_key_ind")
            ->whereNull('labt_invoicedtl_vw.cancel_ind')
            ->whereRaw("labt_invoicedtl_vw.service_unit_no_fk in ($user_service_list)")
            ->whereRaw("labt_invoicedtl_vw.lab_rcv_from_sp_keyed_time >= to_date('$today','DD-MM-YYYY')")
            ->limit(50)
            // ->orderBy("labt_invoicedtl_vw.delivery_status_no", "desc")
            // ->orderBy("labt_invoicedtl_vw.lab_code", "desc")
            ->orderBy("labt_invoicedtl_vw.invoice_date", "desc")
            ->get()->toArray();
        // dd( $invoice_item_arr);
        $service_unit = DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')
        ->whereRaw("serviceunit_no_pk in ($user_service_list)")->where('pathology_ind', 1)->where('status', 1)->get();
        return Template::loadview("admin.pathology.result_entry", ["invoice_item_arr" => $invoice_item_arr, "type" => $type, "operation" => $operation, 'service_unit' => $service_unit]);
        // return Template::loadview("admin.pathology.result_entry",["operation" => $operation, "type" => $type]);
    }
    public function resultEntryMic()
    {
        $type = 1;
        $today = date('d-m-Y', strtotime("-7 Days"));
        $operation = 'prepare';
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $service_unit_no = Session::get('user.su_pk_no');
        $service_unit_name = Session::get('user.serviceunit');
        $invoice_item_arr = DB::table("labt_invoicedtl_vw")
            ->where('au_entry_hospital_pk_no', $hospital_id)
            ->where("lab_rcv_from_sp_key_ind", 1)
            ->where("service_unit_no_fk", $service_unit_no)
            ->whereNull("lab_result_verify_key_ind")
            ->whereNull("lab_result_final_key_ind")
            ->whereNull('cancel_ind')
            ->whereRaw("lab_rcv_from_sp_keyed_time >= to_date('$today','DD-MM-YYYY')")
            ->orderBy("lab_code", "desc")->get()->toArray();
        // dd( $service_unit_no);
        $service_unit = DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('pathology_ind', 1)->where('status', 1)->get();
        // dd($invoice_item_arr);
        return Template::loadview("admin.pathology.result_entry_mic", ["invoice_item_arr" => $invoice_item_arr, "type" => $type, "operation" => $operation, 'service_unit' => $service_unit, 'service_unit_name' => $service_unit_name]);
        // return Template::loadview("admin.pathology.result_entry",["operation" => $operation, "type" => $type]);
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    // public function verifiedResult()
    // {
    //     $type = 1;
    //     $today = date('d-m-Y', strtotime("-7 Days"));
    //     $user_service_unit =  DB::table('sysc_grant_su')
    //                     ->select('su_no_fk')
    //                     ->where('user_no_fk', Auth::user()->user_no_pk)
    //                     ->where('status', 1)
    //                     ->get();
    //                 $user_service_list = 0;
    //                 if (!empty($user_service_unit)) {
    //                     $user_service_list = $user_service_unit->implode('su_no_fk', ',');
    //                 }

    //     $operation = 'verify';
    //     $hospital_id = Session::get('user.ses_hospital_no_pk');
    //     $invoice_item_arr = DB::table("labt_invoicedtl_vw")
    //         ->select('labt_invoicedtl_vw.*', 'finc_invoicemst.patient_code', 'patn_registration.patient_name')
    //         ->leftjoin('finc_invoicemst', 'finc_invoicemst.invoice_no_pk', '=', 'labt_invoicedtl_vw.invoice_no_fk')
    //         ->leftjoin('patn_registration', 'patn_registration.patient_no_pk', '=', 'labt_invoicedtl_vw.patient_no_fk')
    //         ->where('labt_invoicedtl_vw.au_entry_hospital_pk_no', $hospital_id)
    //         ->where("labt_invoicedtl_vw.lab_rcv_from_sp_key_ind", 1)
    //         ->where("labt_invoicedtl_vw.lab_result_verify_key_ind", 1)
    //         ->whereNull("labt_invoicedtl_vw.lab_result_final_key_ind")
    //         ->whereNull('labt_invoicedtl_vw.cancel_ind')
    //         ->whereRaw("labt_invoicedtl_vw.lab_result_verify_keyed_time >= to_date('$today','DD-MM-YYYY')")
    //         // ->orderBy("labt_invoicedtl_vw.delivery_status_no", "desc")
    //         // ->orderBy("labt_invoicedtl_vw.lab_code", "desc")
    //         ->whereRaw("labt_invoicedtl_vw.service_unit_no_fk in ($user_service_list)")
    //         ->orderBy("labt_invoicedtl_vw.invoice_date", "desc")
    //         ->get()->toArray();
    //         // dd( $invoice_item_arr);
    //     $service_unit = DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('pathology_ind', 1)->where('status', 1)->get();
    //     return Template::loadview("admin.pathology.verified_result", ["invoice_item_arr" => $invoice_item_arr, "type" => $type, "operation" => $operation, 'service_unit' => $service_unit]);
    // }

    public function verifiedResult()
    {
        $type = 1;
        $today = date('d-m-Y', strtotime("-7 Days"));

        $user_service_unit = DB::table('sysc_grant_su')
            ->select('su_no_fk')
            ->where('user_no_fk', Auth::user()->user_no_pk)
            ->where('status', 1)
            ->get();

        $user_service_list = 0;
        if (!empty($user_service_unit)) {
            $user_service_list = $user_service_unit->implode('su_no_fk', ',');
        }

        $operation = 'verify';
        $hospital_id = Session::get('user.ses_hospital_no_pk');

        $invoice_item_arr = DB::table("labt_invoicedtl_vw")
            ->select(
                'labt_invoicedtl_vw.invoice_date',
                'labt_invoicedtl_vw.invoice_code',
                'labt_invoicedtl_vw.lab_no_pk',
                'labt_invoicedtl_vw.lab_code',
                'labt_invoicedtl_vw.admission_no_pk',
                'labt_invoicedtl_vw.sc_sample_coll_keyed_time',
                'labt_invoicedtl_vw.lab_rcv_from_sp_keyed_time',
                'labt_invoicedtl_vw.item_name',
                'labt_invoicedtl_vw.sam_name',
                'labt_invoicedtl_vw.container_name',
                'labt_invoicedtl_vw.analyzer_ind',
                'labt_invoicedtl_vw.mac_result_date',
                'labt_invoicedtl_vw.lab_result_final_key_ind',
                'labt_invoicedtl_vw.lab_result_verify_key_ind',
                'labt_invoicedtl_vw.lab_result_prepared_key_ind',
                'labt_invoicedtl_vw.form_url',
                'labt_invoicedtl_vw.report_no_fk',
                'labt_invoicedtl_vw.status',
                'labt_invoicedtl_vw.delivery_status_no',
                'labt_invoicedtl_vw.report_url',
                'patn_registration.patient_code',
                'patn_registration.patient_name',
                'ipd_admitted_patlist_vw.new_bed_name',
                'ipd_admitted_patlist_vw.new_ward_name',
                'ipd_admitted_patlist_vw.new_su_name'
            )
            ->leftjoin('patn_registration', 'patn_registration.patient_no_pk', '=', 'labt_invoicedtl_vw.patient_no_fk')
            ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'labt_invoicedtl_vw.admission_no_pk')
            ->where('labt_invoicedtl_vw.au_entry_hospital_pk_no', $hospital_id)
            ->where("labt_invoicedtl_vw.lab_rcv_from_sp_key_ind", 1)
            ->where("labt_invoicedtl_vw.lab_result_verify_key_ind", 1)
            ->whereNull("labt_invoicedtl_vw.lab_result_final_key_ind")
            ->whereNull('labt_invoicedtl_vw.cancel_ind')
            ->whereRaw("labt_invoicedtl_vw.lab_result_verify_keyed_time >= to_date('$today','DD-MM-YYYY')")
            ->whereRaw("labt_invoicedtl_vw.service_unit_no_fk in ($user_service_list)")
            ->orderBy("labt_invoicedtl_vw.invoice_date", "desc")
            ->get()->toArray();

        $service_unit = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            ->whereRaw("serviceunit_no_pk in ($user_service_list)")
            ->where('pathology_ind', 1)
            ->where('status', 1)
            ->get();

        return Template::loadview("admin.pathology.verified_result", [
            "invoice_item_arr" => $invoice_item_arr,
            "type" => $type,
            "operation" => $operation,
            'service_unit' => $service_unit
        ]);
    }

    public function verifiedResultMic()
    {
        $type = 1;
        $today = date('d-m-Y', strtotime("-7 Days"));

        $operation = 'verify';
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $service_unit_no = Session::get('user.su_pk_no');
        $service_unit_name = Session::get('user.serviceunit');
        $invoice_item_arr = DB::table("labt_invoicedtl_vw")
            ->where('au_entry_hospital_pk_no', $hospital_id)
            ->where("lab_rcv_from_sp_key_ind", 1)
            ->where("lab_result_verify_key_ind", 1)
            ->where("service_unit_no_fk", $service_unit_no)
            ->whereNull("lab_result_final_key_ind")
            ->whereNull('cancel_ind')
            ->whereRaw("lab_result_verify_keyed_time >= to_date('$today','DD-MM-YYYY')")
            ->orderBy("lab_code", "desc")->get()->toArray();
        $service_unit = DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('pathology_ind', 1)->where('status', 1)->get();
        return Template::loadview("admin.pathology.verified_result_mic", ["invoice_item_arr" => $invoice_item_arr, "type" => $type, "operation" => $operation, 'service_unit' => $service_unit, 'service_unit_name' => $service_unit_name]);
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    public function resultEntryForm($report_id, $type = 1, $lab_id)
    {
        $patient_info = [];
        $result_info_0 = DB::table("labt_testreporting_wl_vw")
            ->select('invoice_no_fk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("report_no_pk", $report_id)
            ->whereNull('cancel_ind')
            ->first();


        if (!empty($result_info_0)) {
            $prescription_id = $result_info_0->invoice_no_fk;

            $patient_info = DB::table("labt_invoicedtl_vw a")
                ->select("a.doctor_name", "b.patient_name", "b.patient_code", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "b.pat_relation", "b.ref_patient_gender", "b.ref_blood_group", "b.ref_age", "b.blood_group_txt", "b.mobile1", DB::raw('pat_age(b.dob,nvl(dod,sysdate))pat_age'))
                ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where("a.invoice_no_fk", $prescription_id)->first();
        }
        // dd($report_id);
        $hospital_id =   Session::get('user.ses_hospital_no_pk');
        $result_test_info = DB::select(DB::raw("select lab.*,sys.* from labt_testresultstruct_vw lab
                                                    left join sysc_serviceitem_vw sys
                                                    on lab.item_no_fk = sys.item_no_pk
                                                    where lab.report_no_fk = $report_id
                                                    and lab.au_entry_hospital_pk_no = $hospital_id
                                                    and lab.cancel_ind is null order by lab.item_name Asc,sl_no ASC"));

        // dd( $result_test_info);
        $result_info = DB::table("labt_testreporting_wl_vw as lab")
            ->select(
                "lab.invoice_code",
                "lab.item_no_fk",
                "lab.sam_name as sam_name",
                "lab.serviceunit_name",
                "lab.report_uid",
                "lab.interpretation",
                "lab.comments_text",
                "lab.note_text",
                "lab.result_prepared_keyed_by",
                "lab.result_verify_keyed_by",
                "lab.result_final_keyed_by",
                "lab.result_ent_keyed_by",
                "lab.report_no_pk",
                "lab.analyzer_desc",
                "lab.su_no_fk",
                "lab.image_upload",
                "lab.lab_code",
            )
            ->leftjoin('sysc_serviceitem_vw as ser', 'lab.item_no_fk', 'ser.item_no_pk')
            // ->where('lab.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("lab.report_no_pk", $report_id)
            ->first();

        $result_item = DB::select(DB::raw("select test_name_list from labt_samplelabrcv_wl_vw where lab_uid = $lab_id
                and au_entry_hospital_pk_no = $hospital_id  and cancel_ind is null"));
        $analyzer = DB::table('sysc_serviceitem')->select('item_code', 'item_name', 'interpretation', 'analyzer_text')->where('analyzer_ind', 1)->get();

        $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind", $result_info->su_no_fk);

        $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind", $result_info->su_no_fk);

        $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind", $result_info->su_no_fk);
        //    dd($finalize_by);
        $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind", $result_info->su_no_fk);
        $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind", $result_info->su_no_fk);

        $default_values = DB::table('labs_teststructval')->where('status', 1)->orderBy('sl_no', 'asc')->get();
        return Template::loadview("admin.pathology.result_entry_form", ["report_id" => $report_id, "result_info" => $result_info, "patient_info" => $patient_info, "result_test_info" => $result_test_info, "prepared_by" => $prepared_by, "verified_by" => $verified_by, "finalize_by" => $finalize_by, "type" => $type, "result_item" => $result_item, 'lab_id' => $lab_id, 'analyzer' => $analyzer, 'consult' => $consult, 'consult2' => $consult2, 'default_values' => $default_values]);
    }
    public function resultEntryFormCbc($report_id, $type = 1, $lab_id)
    {
        $patient_info = [];
        $result_info_0 = DB::table("labt_testreporting_wl_vw")
            ->select('invoice_no_fk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("report_no_pk", $report_id)
            ->whereNull('cancel_ind')
            ->first();

        if (!empty($result_info_0)) {
            $prescription_id = $result_info_0->invoice_no_fk;

            $patient_info = DB::table("labt_invoicedtl_vw a")
                ->select("b.patient_name", "b.patient_code", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "b.pat_relation", "b.ref_patient_gender", "b.ref_blood_group", "b.ref_age", "b.blood_group_txt", "b.mobile1", "a.doctor_name", DB::raw('pat_age(b.dob,nvl(dod,sysdate))pat_age'))
                ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where("a.invoice_no_fk", $prescription_id)->first();
        }
        $hospital_id =   Session::get('user.ses_hospital_no_pk');
        $result_test_info = DB::select(DB::raw("select lab.show_in_rep,lab.rpt_show_ind,
        lab.group_txt,
        lab.attr,
        lab.teststruct_no_fk,
        lab.result0,lab.default_ind,lab.machine_attrib,lab.testresult_no_pk,lab.unit,lab.referencevalue,lab.teststruct_uid  from labt_testresultstruct_vw lab
                                                    left join sysc_serviceitem_vw sys
                                                    on lab.item_no_fk = sys.item_no_pk
                                                    where lab.report_no_fk = $report_id
                                                    and lab.au_entry_hospital_pk_no = $hospital_id
                                                    and lab.cancel_ind is null order by lab.item_name Asc,sl_no ASC"));

        // dd( $result_test_info );
        $result_info = DB::table("labt_testreporting_wl_vw as lab")
            ->select(
                "lab.invoice_code",
                "lab.item_no_fk",
                "lab.sam_name as sam_name",
                "lab.serviceunit_name",
                "lab.report_uid",
                "lab.interpretation",
                "lab.comments_text",
                "lab.note_text",
                "lab.result_prepared_keyed_by",
                "lab.result_verify_keyed_by",
                "lab.result_final_keyed_by",
                "lab.result_ent_keyed_by",
                "lab.report_no_pk",
                "lab.analyzer_desc",
                "lab.su_no_fk",
                "lab.image_upload",
                "lab.lab_code",
            )
            ->leftjoin('sysc_serviceitem_vw as ser', 'lab.item_no_fk', 'ser.item_no_pk')
            // ->where('lab.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("lab.report_no_pk", $report_id)
            ->first();

        $result_item = DB::select(DB::raw("select test_name_list from labt_samplelabrcv_wl_vw where lab_uid = $lab_id
                and au_entry_hospital_pk_no = $hospital_id  and cancel_ind is null"));
        $analyzer = DB::table('sysc_serviceitem')->select('item_code', 'item_name', 'interpretation')->where('analyzer_ind', 1)->get();

        $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind", $result_info->su_no_fk);

        $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind", $result_info->su_no_fk);

        $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind", $result_info->su_no_fk);
        // dd( $verified_by );
        $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind", $result_info->su_no_fk);
        $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind", $result_info->su_no_fk);

        $default_values = DB::table('labs_teststructval')->where('status', 1)->orderBy('sl_no', 'asc')->get();
        // return View("admin.pathology.result_entry_form_cbc", ["report_id" => $report_id, "result_info" => $result_info, "patient_info" => $patient_info, "result_test_info" => $result_test_info, "prepared_by" => $prepared_by, "verified_by" => $verified_by, "finalize_by" => $finalize_by, "type" => $type, "result_item" => $result_item, 'lab_id' => $lab_id, 'analyzer' => $analyzer, 'consult' => $consult, 'consult2' => $consult2, 'default_values' => $default_values]);
        return Template::loadview("admin.pathology.result_entry_form_cbc", ["report_id" => $report_id, "result_info" => $result_info, "patient_info" => $patient_info, "result_test_info" => $result_test_info, "prepared_by" => $prepared_by, "verified_by" => $verified_by, "finalize_by" => $finalize_by, "type" => $type, "result_item" => $result_item, 'lab_id' => $lab_id, 'analyzer' => $analyzer, 'consult' => $consult, 'consult2' => $consult2, 'default_values' => $default_values]);
    }
    public function resultEntryFormElisa($report_id, $type = 1, $lab_id)
    {

        $patient_info = [];
        $result_info_0 = DB::table("labt_testreporting_wl_vw")
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("report_no_pk", $report_id)
            ->whereNull('cancel_ind')
            ->first();


        if (!empty($result_info_0)) {
            $prescription_id = $result_info_0->invoice_no_fk;

            $patient_info = DB::table("labt_invoicedtl_vw a")
                ->select("b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "b.pat_relation", "b.ref_patient_gender", "b.ref_blood_group", "b.ref_age", "b.blood_group_txt", "b.mobile1", "b.patient_code", "a.doctor_name", DB::raw('pat_age(b.dob,nvl(dod,sysdate))pat_age'))
                ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where("a.invoice_no_fk", $prescription_id)->first();
        }
        $hospital_id =   Session::get('user.ses_hospital_no_pk');
        $result_test_info = DB::select(DB::raw("select lab.*,sys.* from labt_testresultstruct_vw lab
                                                    left join sysc_serviceitem_vw sys
                                                    on lab.item_no_fk = sys.item_no_pk
                                                    where lab.report_no_fk = $report_id
                                                    and lab.au_entry_hospital_pk_no = $hospital_id
                                                    and lab.cancel_ind is null order by lab.item_name Asc,sl_no ASC"));

        // dd( $result_test_info);
        $result_info = DB::table("labt_testreporting_wl_vw as lab")
            ->select(
                "lab.invoice_code",
                "lab.item_no_fk",
                "lab.sam_name as sam_name",
                "lab.su_no_fk",
                "lab.serviceunit_name",
                "lab.report_uid",
                "lab.interpretation",
                "lab.comments_text",
                "lab.note_text",
                "lab.result_prepared_keyed_by",
                "lab.result_verify_keyed_by",
                "lab.result_final_keyed_by",
                "lab.result_ent_keyed_by",
                "lab.report_no_pk",
                "lab.analyzer_desc",
                "lab.lab_code",
            )
            ->leftjoin('sysc_serviceitem_vw as ser', 'lab.item_no_fk', 'ser.item_no_pk')
            // ->where('lab.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("lab.report_no_pk", $report_id)

            ->first();
        // dd($result_info);

        $result_item = DB::select(DB::raw("select test_name_list from labt_samplelabrcv_wl_vw where lab_uid = $lab_id
                and au_entry_hospital_pk_no = $hospital_id  and cancel_ind is null"));
        $analyzer = DB::table('sysc_serviceitem')->select('item_code', 'item_name', 'interpretation')->where('analyzer_ind', 1)->get();


        $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind", $result_info->su_no_fk);
        $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind", $result_info->su_no_fk);
        $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind", $result_info->su_no_fk);
        $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind", $result_info->su_no_fk);
        $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind", $result_info->su_no_fk);
        // dd($consult);
        return Template::loadview("admin.pathology.result_entry_form_elisa", ["report_id" => $report_id, "result_info" => $result_info, "patient_info" => $patient_info, "result_test_info" => $result_test_info, "prepared_by" => $prepared_by, "verified_by" => $verified_by, "finalize_by" => $finalize_by, "type" => $type, "result_item" => $result_item, 'lab_id' => $lab_id, 'analyzer' => $analyzer, 'consult' => $consult, 'consult2' => $consult2]);
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    public function storeResultEntry(Request $request)
    {
        $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
        // ->where("au_entry_hospital_no_fk", $ses_hospital_id)
        $id = $request->id;
        $auth_id = Auth::id();
        // dd($request->all());
        $dt = new DateTime('now', new \DateTimeZone('Asia/Dhaka'));
        $date = $dt->format('Y-m-d H:i:s');

        DB::beginTransaction();
        try {
            $interpretation     = $request->interpretation;
            $result_comments    = $request->result_comments;
            $result_note        = $request->result_note;
            $hdn_report_id      = $request->hdn_report_id;
            $result_prepared_by   = $request->result_prepared_by;
            $result_verified_by   = $request->result_verified_by;
            $result_finalize_by   = $request->result_finalize_by;
            $analyzer_txt   = $request->analyzer_txt;

            $testresult_no_pk   = $request->testresult_no_pk;
            $result             = $request->result;
            $show_in_rep        = $request->show_in_rep;

            $ids = [];
            for ($i = 0; $i < count($result); $i++) {
                $show_in_rep_val = 0;
                $ss = 'show_in_rep_' . $testresult_no_pk[$i];
                if (@$request->$ss  == "on") {
                    $show_in_rep_val = 1;
                    $data = [
                        'result0'       => $result[$i],
                        'show_in_rep'   => $show_in_rep_val,
                    ];
                } else {
                    $show_in_rep_val = 0;
                    $data = [
                        'result0'       => $result[$i],
                        'show_in_rep'   => $show_in_rep_val,
                    ];
                }
                $ids[] = $testresult_no_pk[$i];
                LabTestResult::where('testresult_no_pk', $testresult_no_pk[$i])->update($data);
            }
            // dd($request->action_type);
            if ($request->action_type == "prepare") {
                $report_data = [
                    'result_prepared_key_ind'    => 1,
                    'result_prepared_keyed_by'   => $result_prepared_by,
                    'result_prepared_keyed_time' => new DateTime('now'),
                    'interpretation'             => $interpretation,
                    'analyzer_desc'             => $analyzer_txt,
                    'comments_text'              => $result_comments,
                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,

                ];

                $invoice_data = [
                    'lab_result_prepared_key_ind'    => 1,
                    'lab_result_prepared_keyed_by'   => $result_prepared_by,
                    'lab_result_prepared_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];
                if (in_array(Session::get('user.ses_hospital_code'), ["DMHL"])) {
                    $report_data['result_verify_key_ind']      = 1;
                    $report_data['result_verify_keyed_by']     = $result_verified_by;
                    $report_data['result_verify_keyed_time']   = new DateTime('now');
                    $report_data['interpretation']             = $interpretation;
                    $report_data['analyzer_desc']              = $analyzer_txt;
                    $report_data['comments_text']              = $result_comments;
                    $report_data['note_text']                  = $result_note;
                    $report_data['au_update_hospital_pk_no'] = $ses_hospital_id;

                    $invoice_data['lab_result_verify_key_ind']    = 1;
                    $invoice_data['lab_result_verify_keyed_by']   = $result_verified_by;
                    $invoice_data['lab_result_verify_keyed_time'] = new DateTime('now');
                    $invoice_data['au_update_hospital_pk_no'] = $ses_hospital_id;
                }
            }

            if ($request->action_type == "verifiy") {
                $report_data = [
                    'result_verify_key_ind'      => 1,
                    'result_verify_keyed_by'     => $result_verified_by,
                    'result_verify_keyed_time'   => new DateTime('now'),
                    'interpretation'             => $interpretation,
                    'analyzer_desc'             => $analyzer_txt,
                    'comments_text'              => $result_comments,
                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_verify_key_ind'    => 1,
                    'lab_result_verify_keyed_by'   => $result_verified_by,
                    'lab_result_verify_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];
            }

            if ($request->action_type == "finalize") {
                $report_data = [
                    'result_final_key_ind'       => 1,
                    'result_final_keyed_by'      => $result_finalize_by,
                    'result_final_keyed_time'    => $date,
                    'interpretation'             => $interpretation,
                    'analyzer_desc'              => $analyzer_txt,
                    'comments_text'              => $result_comments,
                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no'   => $ses_hospital_id,

                ];
                if (in_array(Session::get('user.ses_hospital_code'), ["AMCSH"])) {
                    $report_data['result_prepared_key_ind']    = 1;
                    $report_data['result_prepared_keyed_by']   = $result_prepared_by;
                    $report_data['result_prepared_keyed_time'] = new DateTime('now');
                    $report_data['result_verify_key_ind']      = 1;
                    $report_data['result_verify_keyed_by']     = $result_verified_by;
                    $report_data['result_verify_keyed_time']   = new DateTime('now');
                    $report_data['result_ent_key_ind']         = 1;
                    $report_data['result_ent_keyed_by']        = $request->consultant;
                    $report_data['result_ent_keyed_time']      = new DateTime('now');
                    $report_data['result_con_key_ind']         = 1;
                    $report_data['result_con_keyed_by']       = $request->consultant2;
                    $report_data['result_con_keyed_time']     = $date;
                }
                $invoice_data = [
                    'lab_result_final_key_ind'    => 1,
                    'lab_result_final_keyed_by'   => $result_finalize_by,
                    'lab_result_final_keyed_time' => $date,
                    'au_update_hospital_pk_no' => $ses_hospital_id,

                ];
                if (in_array(Session::get('user.ses_hospital_code'), ["AMCSH"])) {
                    $invoice_data['lab_result_prepared_key_ind']    = 1;
                    $invoice_data['lab_result_prepared_keyed_by']   = $result_prepared_by;
                    $invoice_data['lab_result_prepared_keyed_time'] = new DateTime('now');
                    $invoice_data['lab_result_verify_key_ind']    = 1;
                    $invoice_data['lab_result_verify_keyed_by']   = $result_verified_by;
                    $invoice_data['lab_result_verify_keyed_time'] = new DateTime('now');
                    $invoice_data['lab_result_entry_key_ind']    = 1;
                    $invoice_data['lab_result_entry_keyed_by']   = $request->consultant;
                    $invoice_data['lab_result_entry_keyed_time'] = new DateTime('now');
                    $invoice_data['lab_result_con_key_ind'] = 1;
                    $invoice_data['lab_result_con_keyed_by'] = $request->consultant2;
                    $invoice_data['lab_result_con_keyed_time'] = new DateTime('now');
                }
                if (in_array(Session::get('user.ses_hospital_code'), ["UNICO", "DMHL"])) {
                    $data = array();
                    $data['report_rcb_ind'] = 1;
                    // $data['report_rcb_keyed_by'] = Auth::id();
                    $data['report_rcb_keyed_time'] = new DateTime('now');
                    $data['au_update_by'] =  $auth_id;
                    $data['au_update_at'] = date('Y-m-d');
                    $data['au_update_session'] = 'report receive';
                    $data['au_update_hospital_pk_no'] = $ses_hospital_id;
                    // DB::table('labt_testreporting')->where('report_no_pk', $hdn_report_id)->update($data);

                    $data['report_procees_ind'] = 1;
                    // $data['report_procees_keyed_by'] = Auth::id();
                    $data['report_procees_keyed_time'] = new DateTime('now');

                    // $data = array();
                    $data['report_deli_pending_ind'] = 1;
                    $data['au_entry_by'] = Auth::id();
                    $data['au_entry_at'] = new DateTime('now');
                    $data['au_entry_session'] = 'session';



                    DB::table('labt_testreporting')->where('report_no_pk', $hdn_report_id)->update($data);
                }
            }
            if ($request->action_type == "consultant") {

                $report_data = [
                    'result_ent_key_ind'       => 1,
                    'result_ent_keyed_by'      => $request->consultant,
                    'result_ent_keyed_time'    => new DateTime('now'),
                    'interpretation'             => $interpretation,
                    'analyzer_desc'             => $analyzer_txt,
                    'comments_text'              => $result_comments,
                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_entry_key_ind'    => 1,
                    'lab_result_entry_keyed_by'   => $request->consultant,
                    'lab_result_entry_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];
            }

            if ($request->file('file_upload') != '') {
                $file = $request->file('file_upload');

                $folderPath = public_path('images/uploads/attachment/');
                if (!file_exists($folderPath)) {
                    mkdir($folderPath, 0777, true);
                }
                $path = 'images/uploads/attachment/' . uniqid() . $hdn_report_id . "." . $file->getClientOriginalExtension();
                //delete file from folder
                $file_name = DB::table('labt_testreporting')->select('image_upload')->where('report_no_pk', $hdn_report_id)->first();
                $filePath = public_path($file_name->image_upload);

                if (!empty($file_name->image_upload) && file_exists($filePath)) {
                    // Delete the file
                    unlink($filePath);
                }
                //update file db and folder
                $report_data['image_upload'] = $path;
                $file->move($folderPath, $path);
            }





            $saveDate=  DB::table("labt_testreporting")->where("report_no_pk", $hdn_report_id)->update($report_data);
            LabInvoiceDtl::where("report_no_fk", $hdn_report_id)->update($invoice_data);
            DB::commit();
            // if ($saveDate > 0) {
             $sendSms=  $this->sendSmsMail($hdn_report_id,$request->action_type, $saveDate);
            // }


            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success','sms'=>$sendSms];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error','sms'=>$sendSms];
        }

        return response()->json($message);
    }

    public function sendSmsMail($report_no,$reportActionType,$reportUpateCount){

            if (Session::get('user.sms_send_ind')==1 || Session::get('user.email_send_ind')==1) {
               $invoiceData= DB::table('labt_invoicedtl')->select('finc_invoicemst_vw.invoice_no_pk','finc_invoicemst_vw.invoice_code','finc_invoicemst_vw.invoice_date','finc_invoicemst_vw.patient_code','finc_invoicemst_vw.mobile1','labt_invoicedtl.patient_no_fk','finc_invoicemst_vw.email')->where('report_no_fk',$report_no)->leftJoin('finc_invoicemst_vw','finc_invoicemst_vw.invoice_no_pk','=','labt_invoicedtl.invoice_no_fk')->first();

            }
            // if (Session::get('user.sms_send_ind')==1 && $reportUpateCount > 0 && $reportActionType == "finalize" && in_array(Session::get('user.ses_hospital_code'), ["UNICO"]) ) {
            if (Session::get('user.sms_send_ind')==1 &&  $reportActionType == "finalize" && in_array(Session::get('user.ses_hospital_code'), ["UNICO"]) ) {

                $total_item=DB::table('labt_invoicedtl')->where('invoice_no_fk',$invoiceData->invoice_no_pk)->where('cancel_ind',null)->count();
                $finalized_item=DB::table('labt_invoicedtl')->where('invoice_no_fk',$invoiceData->invoice_no_pk)->whereNotNull('lab_result_final_key_ind')->count();
                $last_report_item=$total_item-$finalized_item;
                 if ( $invoiceData  && $last_report_item <= 1) {
                        //   dd($report_no,$invoiceData, $invoiceData->invoice_no_pk, DB::table('labt_invoicedtl')->where('invoice_no_fk',$invoiceData->invoice_no_pk)->whereNotNull('lab_result_final_key_ind')->count());
                        $invoiceDate = $invoiceData->invoice_date !=''? date('d/m/Y',strtotime($invoiceData->invoice_date)):'';
                        // $downloadedUrl=route('patientPortal.showLoginForm');
                        $downloadedUrl="http://115.127.139.2:8085/h360_uhl/public/patient-portal/login";
                        $mailAddress=$invoiceData->email;
                        $smsText="Lab Report (Invoice: ".$invoiceData->invoice_code." dated ".$invoiceDate.") is ready. Your doctor can view it online  in OPD. Printed reports can be collected from Dispatch Counter at Ground Floor by producing Hospital ID Card / invoice.  Helpline - ".Session::get('user.hospital_telephone1');

                        $smsRequest = new Request([
                            'mobileNo' => $invoiceData->mobile1,
                            'text'     => $smsText,
                            'id'       => $invoiceData->invoice_no_pk,
                        ]);

                    app(\App\Http\Controllers\EMRController::class)->sendSmsLabReport($smsRequest);

                }

            }
            //   dd(Session::get('user.email_send_ind'),$saveDate,$reportActionType,Session::get('user.ses_hospital_code'));
            // if (Session::get('user.email_send_ind')==1 && $reportUpateCount > 0 && $reportActionType == "finalize" && in_array(Session::get('user.ses_hospital_code'), ["UNICO"]) ) {

            //     //  if ( $invoiceData  && DB::table('labt_invoicedtl')->where('invoice_no_fk',$invoiceData->invoice_no_pk)->whereNotNull('lab_result_final_key_ind')->count() <= 0) {
            //          $allReportId=DB::table('labt_invoicedtl')->select('report_no_fk')->where('invoice_no_fk',$invoiceData->invoice_no_pk)->whereNotNull('lab_result_final_key_ind')->whereNull('cancel_ind')->get()->toArray();
            //         //  dd($allReportId);
            //         $mailRequest = new Request([
            //                 'report_id' =>  $allReportId,
            //                 'pat_id'     => $invoiceData->patient_no_fk,
            //             ]);

            //         app(\App\Http\Controllers\EMRController::class)->sendMailLabReport($mailRequest);
            //     // }

            // }
    }
    public function storeResultEntryElisa(Request $request)
    {
        $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
        // ->where("au_entry_hospital_no_fk", $ses_hospital_id)
        $id = $request->id;
        $auth_id = Auth::id();
        // dd($request->all());

        DB::beginTransaction();
        try {
            $interpretation     = $request->interpretation;
            $result_comments    = $request->result_comments;
            $result_note        = $request->result_note;
            $hdn_report_id      = $request->hdn_report_id;
            $result_prepared_by   = $request->result_prepared_by;
            $result_verified_by   = $request->result_verified_by;
            $result_finalize_by   = $request->result_finalize_by;
            $analyzer_txt   = $request->analyzer_txt;

            $testresult_no_pk   = $request->testresult_no_pk;
            $result             = $request->result;
            $show_in_rep        = $request->show_in_rep;
            //dd($request->show_in_rep);
            $ids = [];
            $opinion = [];
            for ($i = 0; $i < count($result); $i++) {
                //dd($request->show_in_rep[$i]);
                $show_in_rep_val = 0;
                //if (isset($request->show_in_rep)) {
                $ss = 'show_in_rep_' . $testresult_no_pk[$i];
                $opinion[] = $request->input('opinion_' . $testresult_no_pk[$i]); //$request->opinion_.$testresult_no_pk[$i];
                // dd($opinion);
                if (@$request->$ss  == "on") {
                    $show_in_rep_val = 1;
                    $data = [
                        'result0'       => $result[$i],
                        // 'au_update_hospital_no_fk' => $ses_hospital_id,
                        'show_in_rep'   => $show_in_rep_val, //isset($show_in_rep[$i]) ? 1 :0
                        'result1'   => $opinion[$i], //isset($show_in_rep[$i]) ? 1 :0
                    ];
                } else {
                    $show_in_rep_val = 0;
                    $data = [
                        'result0'       => $result[$i],
                        // 'au_update_hospital_no_fk' => $ses_hospital_id,
                        'show_in_rep'   => $show_in_rep_val, //isset($show_in_rep[$i]) ? 1 :0
                        'result1'   => $opinion[$i], //isset($show_in_rep[$i]) ? 1 :0
                    ];
                }
                //}

                $ids[] = $testresult_no_pk[$i];

                LabTestResult::where('testresult_no_pk', $testresult_no_pk[$i])->update($data);
            }
            // dd($opinion, $result);

            if ($request->action_type == "prepare") {
                $report_data = [
                    'result_prepared_key_ind'    => 1,
                    'result_prepared_keyed_by'   => $result_prepared_by,
                    'result_prepared_keyed_time' => new DateTime('now'),
                    'interpretation'             => $interpretation,
                    'analyzer_desc'             => $analyzer_txt,
                    'comments_text'              => $result_comments,
                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_prepared_key_ind'    => 1,
                    'lab_result_prepared_keyed_by'   => $result_prepared_by,
                    'lab_result_prepared_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];


                if (in_array(Session::get('user.ses_hospital_code'), ["DMHL"])) {
                    $report_data['result_verify_key_ind']      = 1;
                    $report_data['result_verify_keyed_by']     = $result_verified_by;
                    $report_data['result_verify_keyed_time']   = new DateTime('now');
                    $report_data['interpretation']             = $interpretation;
                    $report_data['analyzer_desc']              = $analyzer_txt;
                    $report_data['comments_text']              = $result_comments;
                    $report_data['note_text']                  = $result_note;
                    $report_data['au_update_hospital_pk_no'] = $ses_hospital_id;

                    $invoice_data['lab_result_verify_key_ind']    = 1;
                    $invoice_data['lab_result_verify_keyed_by']   = $result_verified_by;
                    $invoice_data['lab_result_verify_keyed_time'] = new DateTime('now');
                    $invoice_data['au_update_hospital_pk_no'] = $ses_hospital_id;
                }
            }

            if ($request->action_type == "verifiy") {
                $report_data = [
                    'result_verify_key_ind'      => 1,
                    'result_verify_keyed_by'     => $result_verified_by,
                    'result_verify_keyed_time'   => new DateTime('now'),
                    'interpretation'             => $interpretation,
                    'analyzer_desc'             => $analyzer_txt,
                    'comments_text'              => $result_comments,
                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_verify_key_ind'    => 1,
                    'lab_result_verify_keyed_by'   => $result_verified_by,
                    'lab_result_verify_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];
            }

            if ($request->action_type == "finalize") {
                $report_data = [
                    'result_final_key_ind'       => 1,
                    'result_final_keyed_by'      => $result_finalize_by,
                    'result_final_keyed_time'    => new DateTime('now'),
                    'interpretation'             => $interpretation,
                    'analyzer_desc'             => $analyzer_txt,
                    'comments_text'              => $result_comments,
                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,

                ];
                if (in_array(Session::get('user.ses_hospital_code'), ["AMCSH"])) {
                    $report_data['result_prepared_key_ind']    = 1;
                    $report_data['result_prepared_keyed_by']   = $result_prepared_by;
                    $report_data['result_prepared_keyed_time'] = new DateTime('now');
                    $report_data['result_verify_key_ind']      = 1;
                    $report_data['result_verify_keyed_by']     = $result_verified_by;
                    $report_data['result_verify_keyed_time']   = new DateTime('now');
                    $report_data['result_ent_key_ind']       = 1;
                    $report_data['result_ent_keyed_by']      = $request->consultant;
                    $report_data['result_ent_keyed_time']    = new DateTime('now');
                    $report_data['result_con_key_ind'] = 1;
                    $report_data['result_con_keyed_by'] = $request->consultant2;
                    $report_data['result_con_keyed_time'] = new DateTime('now');
                }

                $invoice_data = [
                    'lab_result_final_key_ind'    => 1,
                    'lab_result_final_keyed_by'   => $result_finalize_by,
                    'lab_result_final_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no' => $ses_hospital_id,

                ];
                if (in_array(Session::get('user.ses_hospital_code'), ["AMCSH"])) {
                    $invoice_data['lab_result_prepared_key_ind']    = 1;
                    $invoice_data['lab_result_prepared_keyed_by']   = $result_prepared_by;
                    $invoice_data['lab_result_prepared_keyed_time'] = new DateTime('now');
                    $invoice_data['lab_result_verify_key_ind']    = 1;
                    $invoice_data['lab_result_verify_keyed_by']   = $result_verified_by;
                    $invoice_data['lab_result_verify_keyed_time'] = new DateTime('now');
                    $invoice_data['lab_result_entry_key_ind']    = 1;
                    $invoice_data['lab_result_entry_keyed_by']   = $request->consultant;
                    $invoice_data['lab_result_entry_keyed_time'] = new DateTime('now');
                    $invoice_data['lab_result_con_key_ind'] = 1;
                    $invoice_data['lab_result_con_keyed_by'] = $request->consultant2;
                    $invoice_data['lab_result_con_keyed_time'] = new DateTime('now');
                }
                if (in_array(Session::get('user.ses_hospital_code'), ["UNICO", "DMHL"])) {
                    $data = array();
                    $data['report_rcb_ind'] = 1;
                    // $data['report_rcb_keyed_by'] = Auth::id();
                    $data['report_rcb_keyed_time'] = new DateTime('now');
                    $data['au_update_by'] =  $auth_id;
                    $data['au_update_at'] = date('Y-m-d');
                    $data['au_update_session'] = 'report receive';
                    $data['au_update_hospital_pk_no'] = $ses_hospital_id;
                    // DB::table('labt_testreporting')->where('report_no_pk', $hdn_report_id)->update($data);

                    $data['report_procees_ind'] = 1;
                    // $data['report_procees_keyed_by'] = Auth::id();
                    $data['report_procees_keyed_time'] = new DateTime('now');

                    // $data = array();
                    $data['report_deli_pending_ind'] = 1;
                    $data['au_entry_by'] = Auth::id();
                    $data['au_entry_at'] = new DateTime('now');
                    $data['au_entry_session'] = 'session';


                    DB::table('labt_testreporting')->where('report_no_pk', $hdn_report_id)->update($data);
                }

                // dd($report_data , $invoice_data);
            }
            if ($request->action_type == "consultant") {

                $report_data = [
                    'result_ent_key_ind'       => 1,
                    'result_ent_keyed_by'      => $request->consultant,
                    'result_ent_keyed_time'    => new DateTime('now'),
                    'interpretation'             => $interpretation,
                    'analyzer_desc'             => $analyzer_txt,
                    'comments_text'              => $result_comments,
                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_entry_key_ind'    => 1,
                    'lab_result_entry_keyed_by'   => $request->consultant,
                    'lab_result_entry_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];
            }

            $saveDate= Db::table("labt_testreporting")->where("report_no_pk", $hdn_report_id)->update($report_data);
            LabInvoiceDtl::where("report_no_fk", $hdn_report_id)->update($invoice_data);

            if ($saveDate > 0) {
               $this->sendSmsMail($hdn_report_id,$request->action_type, $saveDate);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }



    // Callback function to filter only even numbers

    public function resultEntryPdf($report_id = "",$draft="",$type="")
    {

        $hospitalData=DB::table('wsec_hospital')->first();
        if (Auth::id()) {
            $auth_id = Auth::id();
            $hospital_code= Session::get('user.ses_hospital_code');
            $hospital_no_pk=Session::get('user.ses_hospital_no_pk');
        }else{
            $auth_id =0;
            $hospital_code=$hospitalData->hospital_code;
            $hospital_no_pk=$hospitalData->hospital_no_pk;
        }
        $to_date = date('Y-m-d');
        try {
            $report_header = DB::table("labt_testreportresultprint_vw")->select(
                'invoice_code',
                'patient_code',
                'report_code',
                'patient_name',
                'age',
                'dob',
                'gender_txt',
                'ref_doc_name',
                'ref_doc_name_degree1',
                'ref_doc_name_degree2',
                'ref_doc_name_degree3',
                'ward_name',
                'bed_name',
                'passport_no',
                'sam_name',
                'admission_no_pk',
                'lab_code',
                'order_date',
                'item_code_list',
                'report_test_name_list',
                'sc_sample_coll_keyed_time',
                'sample_received_time',
                'serviceunit_name',
                'analyzer_desc',
                'test_method',
                'interpretation',
                'comments_text',
                'note_text',
                'prepared_by',
                'pr_digital_signature_ind',
                'pr_doctor_signature_image',
                'pr_doctor_signature',
                'verified_by',
                'vr_digital_signature_ind',
                'vr_doctor_signature_image',
                'vr_doctor_signature',
                'finalized_by',
                'fin_digital_signature_ind',
                'fin_doctor_signature_image',
                'fin_doctor_signature',
                'ent_digital_signature_ind',
                'ent_doctor_signature_image',
                'ent_doctor_signature',
                'mobile1',
                'result_final_keyed_time',
                'result_print_key_ind'
            )->where('report_no_pk', $report_id)->first();
            // dd($report_header);
            $po_hospital_details = DB::table("wsec_hospital")->first();
            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {
                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }
            $data = DB::table("labt_testresultstruct_vw")->select('item_no_fk', 'item_name')->where('report_no_fk', $report_id)->where('show_in_rep', 1)->groupBy('item_no_fk', 'item_name')->get()->toArray();

            if($hospital_code == "DMHL"){
                    $report_data = DB::table("labt_testresultstruct_vw")
                        ->where('report_no_fk', $report_id)
                        ->where('show_in_rep', 1)
                        // ->where('result_final_key_ind', 1)
                        ->where('cancel_ind', null)
                        ->orderBy('sl_no', 'ASC')
                        ->orderBy('group_seq', 'ASC')
                        ->get()
                        ->toArray();
                }else{
                    $report_data = DB::table("labt_testresultstruct_vw")
                                    ->where('report_no_fk', $report_id)
                                    ->where('show_in_rep', 1)
                                    // ->where('result_final_key_ind', 1)
                                    ->where('cancel_ind', null)
                                    ->orderBy('sl_no', 'ASC')
                                    ->orderBy('group_seq', 'ASC')
                                    ->get()
                                    ->toArray();
                }
                // dd($draft);
            $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->orderBy('group_seq', 'ASC')
                ->first();
            $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';


            $attr_group = [];
            $result_data = [];
            $pat_dob = new \DateTime($report_header->dob);
            $invoice_date = new \DateTime($report_header->order_date);
            $interval = $invoice_date->diff($pat_dob);
            $dob = $interval->format('%y');
            $gender_text = strtoupper($report_header->gender_txt);

            foreach ($report_data as $k => $value) {
                if (in_array($hospital_code, ["UNICO", "IMPERIAL", "DMHL"]) && $value->graph_ind == 1) {
                    $ference_value = DB::table('labs_testreferencevalue')
                        ->where('teststruct_no_fk', $value->teststruct_no_fk)
                        ->get()->toArray();

                    if (!empty($ference_value) && count($ference_value) > 1 && $value->graph_ind == 1) {

                        $result_data_ind = 0;
                        $result_arrow_sign_ind = '';
                        $referencevalue_value = '';

                        foreach ($ference_value as $kye =>  $data) {

                            $age_range = range($data->low_age_yy, $data->high_age_yy);
                            $filteredArray =  in_array($dob, $age_range) ? true : false;

                            if ($filteredArray  == true &&  strtoupper($data->gender) == $gender_text && (float)str_replace(',', '', $value->result0) >= $data->low_result && (float)str_replace(',', '',           $value->result0) <= $data->high_result) {
                                $result_data_ind = 1;
                            }
                            if (in_array($hospital_code, ["UNICO"])) {

                                if ($filteredArray  == true &&  strtoupper($data->gender) == $gender_text && (float)str_replace(',', '', $value->result0) < $data->low_result) {
                                    $result_arrow_sign_ind = '⬇';
                                } elseif ($filteredArray  == true &&  strtoupper($data->gender) == $gender_text  && (float)str_replace(',', '', $value->result0) > $data->high_result) {
                                    $result_arrow_sign_ind = '⬆';
                                }
                            }
                            if ($filteredArray  == true  && strtoupper($data->gender) == $gender_text) {
                                 $referencevalue_value = $data->normal_result;
                                //$referencevalue_value =  $value->referencevalue;
                            }
                            // dd( $filteredArray,strtoupper($data->gender) , $gender_text);
                        }

                        $result_data = [
                            'attr' => $value->attr,
                            'result0' => $value->result0,
                            'unit' => $value->unit,
                            'referencevalue' => $referencevalue_value,
                            'result_data_ind' => $result_data_ind,
                            'result_arrow_sign_ind' => $result_arrow_sign_ind,
                            'graph_ind' => $value->graph_ind,
                            'test_method' => $value->test_method,
                        ];


                    } else {

                        $result_data_ind = 0;
                        $result_arrow_sign_ind = '';
                        $result_data = [
                            'attr' => $value->attr,
                            'result0' => $value->result0,
                            'unit' => $value->unit,
                            'referencevalue' => $value->referencevalue,
                            'result_data_ind' => $result_data_ind,
                            'result_arrow_sign_ind' => $result_arrow_sign_ind,
                            'graph_ind' => $value->graph_ind,
                            'test_method' => $value->test_method,
                        ];

                    }

                    $attr_group[$value->item_no_fk . '_' . $value->item_name . '_' . $value->item_code][$value->test_group_no_fk . '_' . $value->group_txt][] = (object) $result_data;

                } else {

                    $attr_group[$value->item_no_fk . '_' . $value->item_name . '_' . $value->item_code][$value->test_group_no_fk . '_' . $value->group_txt][] = $value;
                }

            }

            // dd($result_data_ind);
            if ($type==1) {
                // dd($type);
                 $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = $hospital_no_pk;
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
            }

            // dd( $attr_group);
            if ($hospital_code == "UNICO") {

                return view('admin.pathology.reports.biochemestry_report_v2', [
                    "report_varcode" => $report_varcode,
                    "report_label" => $report_label,
                    "invoice_varcode" => $invoice_varcode,
                    "report_header" => $report_header,
                    'po_hospital_details' => $po_hospital_details,
                    'data' => $data,
                    "report_data" => $report_data,
                    'attr_group' => $attr_group,
                    'patient_varcode' => $patient_varcode,
                    'draft' => $draft,
                ])->render();
            }elseif($hospital_code== "DMHL"){
                return view('admin.pathology.reports.biochemestry_report_dmhl', [
                    "report_varcode" => $report_varcode,
                    "report_label" => $report_label,
                    "invoice_varcode" => $invoice_varcode,
                    "report_header" => $report_header,
                    'po_hospital_details' => $po_hospital_details,
                    'data' => $data,
                    "report_data" => $report_data,
                    'attr_group' => $attr_group,
                    'patient_varcode' => $patient_varcode,
                    'draft' => $draft,
                ])->render();
            } else {
                return view('admin.pathology.reports.biochemestry_report', [
                    "report_varcode" => $report_varcode,
                    "report_label" => $report_label,
                    "invoice_varcode" => $invoice_varcode,
                    "report_header" => $report_header,
                    'po_hospital_details' => $po_hospital_details,
                    'data' => $data,
                    "report_data" => $report_data,
                    'attr_group' => $attr_group,
                    'patient_varcode' => $patient_varcode,
                    'draft' => $draft,
                ])->render();
            }
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
    public function resultEntryPdfV1($report_id = "",$draft="", $type="")
    {
        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        try {
            $report_header = DB::table("labt_testreportresultprint_vw")->select(
                'invoice_code',
                'patient_code',
                'report_code',
                'patient_name',
                'age',
                'dob',
                'gender_txt',
                'ref_doc_name',
                'ref_doc_name_degree1',
                'ref_doc_name_degree2',
                'ref_doc_name_degree3',
                'ward_name',
                'bed_name',
                'passport_no',
                'sam_name',
                'admission_no_pk',
                'lab_code',
                'order_date',
                'item_code_list',
                'report_test_name_list',
                'sc_sample_coll_keyed_time',
                'sample_received_time',
                'serviceunit_name',
                'analyzer_desc',
                'test_method',
                'interpretation',
                'comments_text',
                'note_text',
                'prepared_by',
                'pr_digital_signature_ind',
                'pr_doctor_signature_image',
                'pr_doctor_signature',
                'verified_by',
                'vr_digital_signature_ind',
                'vr_doctor_signature_image',
                'vr_doctor_signature',
                'finalized_by',
                'fin_digital_signature_ind',
                'fin_doctor_signature_image',
                'fin_doctor_signature',
                'ent_digital_signature_ind',
                'ent_doctor_signature_image',
                'ent_doctor_signature',
                'mobile1',
            )->where('report_no_pk', $report_id)->first();
            // dd($report_header);
            $po_hospital_details = DB::table("wsec_hospital")->first();
            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {
                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }
            $data = DB::table("labt_testresultstruct_vw")->select('item_no_fk', 'item_name')->where('report_no_fk', $report_id)->where('show_in_rep', 1)->groupBy('item_no_fk', 'item_name')->get()->toArray();

           if(Session::get('user.ses_hospital_code') == "DMHL"){
                    $report_data = DB::table("labt_testresultstruct_vw")
                        ->where('report_no_fk', $report_id)
                        ->where('show_in_rep', 1)
                        // ->where('result_final_key_ind', 1)
                        ->where('cancel_ind', null)
                        ->orderBy('sl_no', 'ASC')
                        ->orderBy('group_seq', 'ASC')
                        ->get()
                        ->toArray();
                }else{
                    $report_data = DB::table("labt_testresultstruct_vw")
                                    ->where('report_no_fk', $report_id)
                                    ->where('show_in_rep', 1)
                                    // ->where('result_final_key_ind', 1)
                                    ->where('cancel_ind', null)
                                    ->orderBy('sl_no', 'ASC')
                                    ->orderBy('group_seq', 'ASC')
                                    ->get()
                                    ->toArray();
                }

            $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->orderBy('group_seq', 'ASC')
                ->first();
            $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';


            $attr_group = [];
            $result_data = [];
            $pat_dob = new \DateTime($report_header->dob);
            $invoice_date = new \DateTime($report_header->order_date);
            $interval = $invoice_date->diff($pat_dob);
            $dob = $interval->format('%y');
            // dd($dob);
            $gender_text = strtoupper($report_header->gender_txt);
            foreach ($report_data as $k => $value) {
                if (in_array(Session::get('user.ses_hospital_code'), ["UNICO", "IMPERIAL", "DMHL"]) && $value->graph_ind == 1) {
                    $ference_value = DB::table('labs_testreferencevalue')
                        ->where('teststruct_no_fk', $value->teststruct_no_fk)
                        ->get()->toArray();

                    if (!empty($ference_value) && count($ference_value) > 1 && $value->graph_ind == 1) {

                        $result_data_ind = 0;
                        $result_arrow_sign_ind = '';
                        $referencevalue_value = '';

                        foreach ($ference_value as $kye =>  $data) {

                            $age_range = range($data->low_age_yy, $data->high_age_yy);
                            $filteredArray =  in_array($dob, $age_range) ? true : false;

                            if ($filteredArray  == true &&  strtoupper($data->gender) == $gender_text && (float)str_replace(',', '', $value->result0) >= $data->low_result && (float)str_replace(',', '', $value->result0) <= $data->high_result) {
                                $result_data_ind = 1;
                            }
                            if (in_array(Session::get('user.ses_hospital_code'), ["UNICO"])) {

                                if ($filteredArray  == true &&  strtoupper($data->gender) == $gender_text && (float)str_replace(',', '', $value->result0) < $data->low_result) {
                                    $result_arrow_sign_ind = '⬇';
                                } elseif ($filteredArray  == true &&  strtoupper($data->gender) == $gender_text  && (float)str_replace(',', '', $value->result0) > $data->high_result) {
                                    $result_arrow_sign_ind = '⬆';
                                }
                            }
                            if ($filteredArray  == true  && strtoupper($data->gender) == $gender_text) {
                                 $referencevalue_value = $data->normal_result;
                                //$referencevalue_value = $value->referencevalue;
                            }
                            // dd( $filteredArray,strtoupper($data->gender) , $gender_text);
                        }

                        $result_data = [
                            'attr' => $value->attr,
                            'result0' => $value->result0,
                            'unit' => $value->unit,
                            'referencevalue' => $referencevalue_value,
                            'result_data_ind' => $result_data_ind,
                            'result_arrow_sign_ind' => $result_arrow_sign_ind,
                            'graph_ind' => $value->graph_ind,
                            'test_method' => $value->test_method,
                        ];

                    } else {

                        $result_data_ind = 0;
                        $result_arrow_sign_ind = '';
                        $result_data = [
                            'attr' => $value->attr,
                            'result0' => $value->result0,
                            'unit' => $value->unit,
                            'referencevalue' => $value->referencevalue,
                            'result_data_ind' => $result_data_ind,
                            'result_arrow_sign_ind' => $result_arrow_sign_ind,
                            'graph_ind' => $value->graph_ind,
                        ];
                    }

                    $attr_group[$value->item_no_fk . '_' . $value->item_name . '_' . $value->item_code][$value->test_group_no_fk . '_' . $value->group_txt][] = (object) $result_data;
                } else {

                    $attr_group[$value->item_no_fk . '_' . $value->item_name . '_' . $value->item_code][$value->test_group_no_fk . '_' . $value->group_txt][] = $value;
                }
            }
            // dd($result_data_ind);
            if ($type==1) {
                $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
            // AU_UPDATE_BY
            $data['au_update_by'] = $auth_id;
            $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
            DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
            }

            // dd( $attr_group);
            return view('admin.pathology.reports.biochemestry_report', [
                "report_varcode" => $report_varcode,
                "report_label" => $report_label,
                "invoice_varcode" => $invoice_varcode,
                "report_header" => $report_header,
                'po_hospital_details' => $po_hospital_details,
                'data' => $data,
                "report_data" => $report_data,
                'attr_group' => $attr_group,
                'patient_varcode' => $patient_varcode,
                'draft' => $draft,
            ])->render();

        } catch (\Exception $e) {
            DB::rollback();
        }
    }
    public function resultEntryPdfUnireColumn4($report_id = "",$draft="" , $type="")
    {

         $hospitalData=DB::table('wsec_hospital')->first();
        if (Auth::id()) {
            $auth_id = Auth::id();
            $hospital_code= Session::get('user.ses_hospital_code');
            $hospital_no_pk=Session::get('user.ses_hospital_no_pk');
        }else{
            $auth_id =0;
            $hospital_code=$hospitalData->hospital_code;
            $hospital_no_pk=$hospitalData->hospital_no_pk;
        }
        $to_date = date('Y-m-d');
        try {
            $report_header = DB::table("labt_testreportresultprint_vw")->select(
                'invoice_code',
                'patient_code',
                'report_code',
                'patient_name',
                'age',
                'dob',
                'gender_txt',
                'ref_doc_name',
                'ref_doc_name_degree1',
                'ref_doc_name_degree2',
                'ref_doc_name_degree3',
                'ward_name',
                'bed_name',
                'passport_no',
                'sam_name',
                'admission_no_pk',
                'lab_code',
                'order_date',
                'item_code_list',
                'report_test_name_list',
                'sc_sample_coll_keyed_time',
                'sample_received_time',
                'serviceunit_name',
                'analyzer_desc',
                'test_method',
                'interpretation',
                'comments_text',
                'note_text',
                'prepared_by',
                'pr_digital_signature_ind',
                'pr_doctor_signature_image',
                'pr_doctor_signature',
                'verified_by',
                'vr_digital_signature_ind',
                'vr_doctor_signature_image',
                'vr_doctor_signature',
                'finalized_by',
                'fin_digital_signature_ind',
                'fin_doctor_signature_image',
                'fin_doctor_signature',
                'ent_digital_signature_ind',
                'ent_doctor_signature_image',
                'ent_doctor_signature',
                'mobile1',
                'result_final_keyed_time',
                'result_print_key_ind'

            )->where('report_no_pk', $report_id)->first();
            // dd($report_header);
            $po_hospital_details = DB::table("wsec_hospital")->first();
            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {
                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }
            $data = DB::table("labt_testresultstruct_vw")->select('item_no_fk', 'item_name')->where('report_no_fk', $report_id)->where('show_in_rep', 1)->groupBy('item_no_fk', 'item_name')->get()->toArray();

            $report_data = DB::table("labt_testresultstruct_vw")
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->where('cancel_ind', null)
                ->orderBy('sl_no', 'ASC')
                ->orderBy('group_seq', 'ASC')
                ->get()
                ->toArray();

            $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->orderBy('group_seq', 'ASC')
                ->first();
            $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';


            $attr_group = [];
            $result_data = [];
            $pat_dob = new \DateTime($report_header->dob);
            $invoice_date = new \DateTime($report_header->order_date);
            $interval = $invoice_date->diff($pat_dob);
            $dob = $interval->format('%y');
            // dd($dob);
            $gender_text = strtoupper($report_header->gender_txt);
            foreach ($report_data as $k => $value) {
                if (in_array($hospital_code, ["UNICO", "IMPERIAL", "DMHL"]) && $value->graph_ind == 1) {
                    $ference_value = DB::table('labs_testreferencevalue')
                        ->where('teststruct_no_fk', $value->teststruct_no_fk)
                        ->get()->toArray();

                    if (!empty($ference_value) && count($ference_value) > 1 && $value->graph_ind == 1) {

                        $result_data_ind = 0;
                        $result_arrow_sign_ind = '';
                        $referencevalue_value = '';

                        foreach ($ference_value as $kye =>  $data) {

                            $age_range = range($data->low_age_yy, $data->high_age_yy);
                            $filteredArray =  in_array($dob, $age_range) ? true : false;

                            if ($filteredArray  == true &&  strtoupper($data->gender) == $gender_text && (float)str_replace(',', '', $value->result0) >= $data->low_result && (float)str_replace(',', '', $value->result0) <= $data->high_result) {
                                $result_data_ind = 1;
                            }
                            if (in_array($hospital_code, ["UNICO"])) {

                                if ($filteredArray  == true &&  strtoupper($data->gender) == $gender_text && (float)str_replace(',', '', $value->result0) < $data->low_result) {
                                    $result_arrow_sign_ind = '⬇';
                                } elseif ($filteredArray  == true &&  strtoupper($data->gender) == $gender_text  && (float)str_replace(',', '', $value->result0) > $data->high_result) {
                                    $result_arrow_sign_ind = '⬆';
                                }
                            }
                            if ($filteredArray  == true  && strtoupper($data->gender) == $gender_text) {
                                $referencevalue_value = $data->normal_result;
                                // $referencevalue_value = $value->referencevalue;
                            }
                            // dd( $filteredArray,strtoupper($data->gender) , $gender_text);
                        }

                        $result_data = [
                            'attr' => $value->attr,
                            'result0' => $value->result0,
                            'unit' => $value->unit,
                            'referencevalue' => $referencevalue_value,
                            'result_data_ind' => $result_data_ind,
                            'result_arrow_sign_ind' => $result_arrow_sign_ind,
                            'graph_ind' => $value->graph_ind,
                        ];
                        // dd( $result_data);
                    } else {

                        $result_data_ind = 0;
                        $result_arrow_sign_ind = '';
                        $result_data = [
                            'attr' => $value->attr,
                            'result0' => $value->result0,
                            'unit' => $value->unit,
                            'referencevalue' => $value->referencevalue,
                            'result_data_ind' => $result_data_ind,
                            'result_arrow_sign_ind' => $result_arrow_sign_ind,
                            'graph_ind' => $value->graph_ind,
                        ];
                    }

                    $attr_group[$value->item_no_fk . '_' . $value->item_name . '_' . $value->item_code][$value->test_group_no_fk . '_' . $value->group_txt][] = (object) $result_data;
                } else {

                    $attr_group[$value->item_no_fk . '_' . $value->item_name . '_' . $value->item_code][$value->test_group_no_fk . '_' . $value->group_txt][] = $value;
                }
            }
            if ($type==1) {
                $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = $hospital_no_pk;
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
            }

            // dd( $report_header);

            if ($hospital_code == "UNICO") {

                return view('admin.pathology.reports.urine_report_pdf_column_4', [
                    "report_varcode" => $report_varcode,
                    "report_label" => $report_label,
                    "invoice_varcode" => $invoice_varcode,
                    "report_header" => $report_header,
                    'po_hospital_details' => $po_hospital_details,
                    'data' => $data,
                    "report_data" => $report_data,
                    'attr_group' => $attr_group,
                    'patient_varcode' => $patient_varcode,
                    'draft' => $draft,
                ])->render();
            } else {
                return view('admin.pathology.reports.biochemestry_report', [
                    "report_varcode" => $report_varcode,
                    "report_label" => $report_label,
                    "invoice_varcode" => $invoice_varcode,
                    "report_header" => $report_header,
                    'po_hospital_details' => $po_hospital_details,
                    'data' => $data,
                    "report_data" => $report_data,
                    'attr_group' => $attr_group,
                    'patient_varcode' => $patient_varcode,
                     'draft' => $draft,
                ])->render();
            }
        } catch (\Exception $e) {
            DB::rollback();
        }
    }
    public function resultEntryPdfElisa($report_id = "",$draft="",$type="")
    {
        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        try {
            $report_header = DB::table("labt_testreportresultprint_vw")->where('report_no_pk', $report_id)->first();
            $po_hospital_details = DB::table("wsec_hospital")->first();

            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {

                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }



            $data = DB::table("labt_testresultstruct_vw")->select('item_no_fk', 'item_name')->where('report_no_fk', $report_id)->where('show_in_rep', 1)->groupBy('item_no_fk', 'item_name')->get()->toArray();

              if(Session::get('user.ses_hospital_code') == "DMHL"){
                    $report_data = DB::table("labt_testresultstruct_vw")
                        ->where('report_no_fk', $report_id)
                        ->where('show_in_rep', 1)
                        // ->where('result_final_key_ind', 1)
                        ->where('cancel_ind', null)
                        ->orderBy('sl_no', 'ASC')
                        ->orderBy('group_seq', 'ASC')
                        ->get()
                        ->toArray();
                }else{
                    $report_data = DB::table("labt_testresultstruct_vw")
                                    ->where('report_no_fk', $report_id)
                                    ->where('show_in_rep', 1)
                                    // ->where('result_final_key_ind', 1)
                                    ->where('cancel_ind', null)
                                    ->orderBy('sl_no', 'ASC')
                                    ->orderBy('group_seq', 'ASC')
                                    ->get()
                                    ->toArray();
                }

            $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->first();
            $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';


            $attr_group = [];
            foreach ($report_data as $value) {
                $attr_group[$value->item_no_fk . '-' . $value->item_name][$value->test_group_no_fk . '-' . $value->group_txt][] = $value;
            }
            // dd($attr_group);
            if ($type==1) {
                $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
            ];
            // AU_UPDATE_BY
            $data['au_update_by'] = $auth_id;
            $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
            DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
            }



            // $pdf = PDF::loadView("admin.pathology.reports.biochemestry_report", ["prescription_barcode" => $prescription_barcode, "lbauid_barcode" => $lbauid_barcode, "report_header" => $report_header, 'po_hospital_details' => $po_hospital_details, 'data' => $data, "report_data" => $report_data, 'attr_group' => $attr_group]);




            return view('admin.pathology.reports.biochemestry_report_elisa', [
                "report_label" => $report_label,
                "report_varcode" => $report_varcode,
                "invoice_varcode" => $invoice_varcode,
                "report_header" => $report_header,
                'po_hospital_details' => $po_hospital_details,
                'data' => $data,
                "report_data" => $report_data,
                'attr_group' => $attr_group,
                'patient_varcode' => $patient_varcode,
                'draft' => $draft,
            ])->render();
        } catch (\Exception $e) {
            DB::rollback();
            // $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // return response()->json($message);
        // return $pdf->stream("BC-$report_id.pdf");
        // return @\PDF::loadHTML($html, 'utf-8')->stream();
    }


    public function resultEntryDraftPdf($report_id = "")
    {
        // dd($report_id);
        // $report_header = DB::table("labt_testreportresultprint_vw")->where('report_no_pk', $report_id)->first();
        $report_header = DB::table("labt_testreportresultprint_vw")->where('report_no_pk', $report_id)->first();
        $po_hospital_details = DB::table("wsec_hospital")->first();

        $report_varcode = "";
        $invoice_varcode = "";
        $patient_varcode = "";
        if (!empty($report_header)) {

            $barcode = new BarcodeGenerator();
            $barcode->setText($report_header->report_code);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $report_varcode = $barcode->generate();

            $barcode1 = new BarcodeGenerator();
            $barcode1->setText($report_header->invoice_code);
            $barcode1->setType(BarcodeGenerator::Code128);
            $barcode1->setScale(1);
            $barcode1->setLabel('');
            $barcode1->setThickness(25);
            $barcode1->setFontSize(10);
            $invoice_varcode = $barcode1->generate();

            $barcode2 = new BarcodeGenerator();
            $barcode2->setText($report_header->patient_code);
            $barcode2->setType(BarcodeGenerator::Code128);
            $barcode2->setScale(1);
            $barcode2->setLabel('');
            $barcode2->setThickness(25);
            $barcode2->setFontSize(10);
            $patient_varcode = $barcode2->generate();
        }


        $data = DB::table("labt_testresultstruct_vw")->select('item_no_fk', 'item_name')->where('report_no_fk', $report_id)->where('show_in_rep', 1)->groupBy('item_no_fk', 'item_name')->get()->toArray();

        $report_data = DB::table("labt_testresultstruct_vw")
            ->where('report_no_fk', $report_id)
            ->where('show_in_rep', 1)
            ->orderBy('sl_no', 'ASC')
            ->get()
            ->toArray();
        // dd( $report_data);
        $attr_group = [];
        foreach ($report_data as $value) {
            $attr_group[$value->test_group_no_fk . '-' . $value->group_txt][] = $value;
        }

        $pdf = PDF::loadView("admin.pathology.pathology_draft_print_report", ["report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, "report_header" => $report_header, 'po_hospital_details' => $po_hospital_details, 'data' => $data, "report_data" => $report_data, 'attr_group' => $attr_group, 'patient_varcode' => $patient_varcode]);
        return $pdf->stream("BC-$report_id.pdf");
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    public function resultSearch(Request $request)
    {
        $prescription_id = $request->prescription_id;
        $lab_id = $request->lab_id;
        $admission_id = $request->admission_no;
        $service_unit = $request->service_unit;
        $type = $request->hdn_type;
        $mail_type = $request->mailType;
        $from_date = $request->search_date_from;
        $to_date = $request->search_date_to;
        $applyWhereNull = in_array(Session::get('user.ses_hospital_code'), ["DMHL", "UNICO"]);
        $invoice_item_rs = DB::table("labt_invoicedtl_vw")
        ->select(
            'labt_invoicedtl_vw.invoice_date',
            'labt_invoicedtl_vw.invoice_code',
            'labt_invoicedtl_vw.lab_no_pk',
            'labt_invoicedtl_vw.lab_code',
            'labt_invoicedtl_vw.admission_no_pk',
            'labt_invoicedtl_vw.sc_sample_coll_keyed_time',
            'labt_invoicedtl_vw.lab_rcv_from_sp_keyed_time',
            'labt_invoicedtl_vw.item_name',
            'labt_invoicedtl_vw.sam_name',
            'labt_invoicedtl_vw.container_name',
            'labt_invoicedtl_vw.analyzer_ind',
            'labt_invoicedtl_vw.lab_result_final_key_ind',
            'labt_invoicedtl_vw.lab_result_verify_key_ind',
            'labt_invoicedtl_vw.lab_result_prepared_key_ind',
            'labt_invoicedtl_vw.delivery_status_no',
            'labt_invoicedtl_vw.form_url',
            'labt_invoicedtl_vw.report_no_fk',
            'labt_invoicedtl_vw.report_url',
            'labt_invoicedtl_vw.invoice_no_fk',
            'labt_invoicedtl_vw.mail_ind',
            'labt_invoicedtl_vw.email',

            'patn_registration.patient_code',
            'patn_registration.patient_name',
            'ipd_admitted_patlist_vw.new_bed_name',
            'ipd_admitted_patlist_vw.new_ward_name',
            'ipd_admitted_patlist_vw.new_su_name'
        )
        ->leftJoin('finc_invoicemst', 'finc_invoicemst.invoice_no_pk', '=', 'labt_invoicedtl_vw.invoice_no_fk')
        ->leftJoin('patn_registration', 'patn_registration.patient_no_pk', '=', 'labt_invoicedtl_vw.patient_no_fk')
        ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'labt_invoicedtl_vw.admission_no_pk')
        ->where('labt_invoicedtl_vw.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));

            // dd($type);
        if ($type == 1) {
            $invoice_item_rs->when($applyWhereNull, function ($query) {
                return $query->whereNull('labt_invoicedtl_vw.lab_result_final_key_ind');
            });
        }




        if (!empty($prescription_id)) {
            $invoice_item_rs->when($prescription_id, function ($query, $prescription_id) {
                return $query->where('labt_invoicedtl_vw.invoice_no_fk', $prescription_id);
            });
        }
        if (!empty($lab_id)) {
            $invoice_item_rs->when($lab_id, function ($query, $lab_id) {
                return $query->where('labt_invoicedtl_vw.lab_code', $lab_id);
            });
        }

        if (!empty($service_unit)) {
            $invoice_item_rs->when($service_unit, function ($query, $service_unit) {
                return $query->where('labt_invoicedtl_vw.service_unit_no_fk', $service_unit);
            });
        }

        if (!empty($admission_id)) {
            $invoice_item_rs->when($admission_id, function ($query, $admission_id) {
                return $query->where('labt_invoicedtl_vw.admission_no_pk', $admission_id);
            });
        }

        if ($request->hdn_operation != "finalized" &&  $request->hdn_operation == "finalize") {
            if (!empty($from_date) && !empty($to_date)) {
                $invoice_item_rs->where(DB::raw("trunc(labt_invoicedtl_vw.lab_result_verify_keyed_time)"), '>=', date('Y/m/d', strtotime(request('search_date_from'))));
                $invoice_item_rs->where(DB::raw("trunc(labt_invoicedtl_vw.lab_result_verify_keyed_time)"), '<=', date('Y/m/d', strtotime(request('search_date_to'))));
            } elseif (!empty($from_date)) {
                $invoice_item_rs->where(DB::raw("trunc(labt_invoicedtl_vw.lab_result_verify_keyed_time)"), '=', date('Y/m/d', strtotime(request('search_date_from'))));
            } elseif (!empty($to_date)) {
                $invoice_item_rs->where(DB::raw("labt_invoicedtl_vw.lab_result_verify_keyed_time"), '=', date('Y/m/d', strtotime(request('search_date_to'))));
            }
        } elseif ($request->hdn_operation != "finalized") {
            if (!empty($from_date) && !empty($to_date)) {
                $invoice_item_rs->where(DB::raw("trunc(labt_invoicedtl_vw.invoice_date)"), '>=', date('Y/m/d', strtotime(request('search_date_from'))));
                $invoice_item_rs->where(DB::raw("trunc(labt_invoicedtl_vw.invoice_date)"), '<=', date('Y/m/d', strtotime(request('search_date_to'))));
            } elseif (!empty($from_date)) {
                $invoice_item_rs->where(DB::raw("trunc(labt_invoicedtl_vw.invoice_date)"), '=', date('Y/m/d', strtotime(request('search_date_from'))));
            } elseif (!empty($to_date)) {
                $invoice_item_rs->where(DB::raw("labt_invoicedtl_vw.invoice_date"), '=', date('Y/m/d', strtotime(request('search_date_to'))));
            }
        }

        $invoice_item_rs->when($request, function ($query, $request) {
            $hdn_operation = $request->hdn_operation;


            if ($hdn_operation == "prepare") {

                if (Session::get('user.ses_hospital_code') == "UNICO") {

                    $user_service_unit =  DB::table('sysc_grant_su')
                        ->select('su_no_fk')
                        ->where('user_no_fk', Auth::user()->user_no_pk)
                        ->where('status', 1)
                        ->get();
                        // dd( $user_service_unit );
                    $user_service_list = 0;
                    if (!empty($user_service_unit)) {
                        $user_service_list = $user_service_unit->implode('su_no_fk', ',');
                    }
                    return $query->where("labt_invoicedtl_vw.lab_rcv_from_sp_key_ind", 1)
                        ->whereRaw("labt_invoicedtl_vw.service_unit_no_fk in ($user_service_list)")
                        ->whereNull("lab_result_verify_key_ind");
                } else {
                    return $query->where("labt_invoicedtl_vw.lab_rcv_from_sp_key_ind", 1)
                        ->whereNull("lab_result_verify_key_ind");
                }
            }

            if ($hdn_operation == "verify") {

                if (Session::get('user.ses_hospital_code') == "UNICO") {
                    $user_service_unit =  DB::table('sysc_grant_su')
                        ->select('su_no_fk')
                        ->where('user_no_fk', Auth::user()->user_no_pk)
                        ->where('status', 1)
                        ->get();
                    $user_service_list = 0;
                    if (!empty($user_service_unit)) {
                        $user_service_list = $user_service_unit->implode('su_no_fk', ',');
                    }
                    return $query->where("labt_invoicedtl_vw.lab_result_verify_key_ind", 1)
                        ->whereRaw("labt_invoicedtl_vw.service_unit_no_fk in ($user_service_list)")
                        ->whereNull("lab_result_final_key_ind");
                } else {
                    return $query->where("labt_invoicedtl_vw.lab_result_prepared_key_ind", 1)
                        ->whereNull("lab_result_final_key_ind");
                }
            }

            if ($hdn_operation == "finalize") {
                 if (Session::get('user.ses_hospital_code') == "UNICO") {
                    $user_service_unit =  DB::table('sysc_grant_su')
                        ->select('su_no_fk')
                        ->where('user_no_fk', Auth::user()->user_no_pk)
                        ->where('status', 1)
                        ->get();
                    $user_service_list = 0;
                    if (!empty($user_service_unit)) {
                        $user_service_list = $user_service_unit->implode('su_no_fk', ',');
                    }
                    return $query->where("labt_invoicedtl_vw.lab_result_verify_key_ind", 1)->whereNull('labt_invoicedtl_vw.lab_result_final_key_ind')->whereRaw("labt_invoicedtl_vw.service_unit_no_fk in ($user_service_list)");
                } else {
                    return $query->where("labt_invoicedtl_vw.lab_result_verify_key_ind", 1);
                }

                // if (in_array(Session::get('user.ses_hospital_code'), ["DMHL", "UNICO"])) {
                //     return $query->where("labt_invoicedtl_vw.lab_result_verify_key_ind", 1)->whereNull('labt_invoicedtl_vw.lab_result_final_key_ind')->whereRaw("labt_invoicedtl_vw.service_unit_no_fk in ($user_service_list)");
                // } else {
                //     return $query->where("labt_invoicedtl_vw.lab_result_verify_key_ind", 1);
                // }
            }

            if ($hdn_operation == "finalized") {
                $from_date = $request->search_date_from;
                $to_date = $request->search_date_to;
                //    dd( $from_date , $to_date);
                if (!empty($from_date) && !empty($to_date)) {
                    // dd($hdn_operation,$from_date, $to_date);
                    $query->where(DB::raw("trunc(labt_invoicedtl_vw.lab_result_final_keyed_time)"), '>=', date('Y-m-d', strtotime($from_date)))->where(DB::raw("trunc(labt_invoicedtl_vw.lab_result_final_keyed_time)"), '<=', date('Y-m-d', strtotime($to_date)));
                }
                // elseif (!empty($from_date)) {
                //     $query->where(DB::raw("trunc(labt_invoicedtl_vw.lab_result_final_keyed_time)"), '=', date('Y/m/d', strtotime(request('search_date_from'))));
                // } elseif (!empty($to_date)) {
                //     $query->where(DB::raw("labt_invoicedtl_vw.lab_result_final_keyed_time"), '=', date('Y/m/d', strtotime(request('search_date_to'))));
                // }
                return $query = $query->where("labt_invoicedtl_vw.lab_result_final_key_ind", 1);
            }
        });
        $operation = $request->hdn_operation;
        $applyWhereNull = Session::get('user.ses_hospital_code') == "DMHL";
        $invoice_item_arr = $invoice_item_rs
            // ->when($applyWhereNull, function ($query) {
            //     return $query->whereNull('labt_invoicedtl_vw.lab_result_final_key_ind');
            // })
            ->whereNull('labt_invoicedtl_vw.cancel_ind')
            // ->orderBy("labt_invoicedtl_vw.delivery_status_no", "desc")
            // ->orderBy("labt_invoicedtl_vw.invoice_no_fk", "desc")
            ->orderBy("labt_invoicedtl_vw.invoice_date", "desc")
            // ->orderBy("labt_invoicedtl_vw.item_name", "asc")
            ->get();
        // dd( $mail_type);
        return Template::loadview("admin.pathology.result_entry_list", ["invoice_item_arr" => $invoice_item_arr, "type" => $type, 'operation' => $operation, 'mailType' => $mail_type]);
    }
    public function resultPrintDeliverySearch(Request $request)
    {
        $prescription_id = $request->prescription_id;
        $lab_id = $request->lab_id;
        $admission_id = $request->admission_no;
        $service_unit = $request->service_unit;
        $type = $request->hdn_type;
        $mail_type = $request->mailType;
        // dd($type );
        $from_date = $request->search_date_from;
        $to_date = $request->search_date_to;
        $applyWhereNull = in_array(Session::get('user.ses_hospital_code'), ["DMHL", "UNICO"]);

        $invoice_item_rs = DB::table("labt_invoicedtl_vw")
            // ->select(
            //     'invoice_date',
            //     'invoice_code',
            //     'lab_no_pk',
            //     'lab_code',
            //     'admission_no_pk',
            //     'sc_sample_coll_keyed_time',
            //     'lab_rcv_from_sp_keyed_time',
            //     'item_name',
            //     'sam_name',
            //     'container_name',
            //     'analyzer_ind',
            //     'lab_result_final_key_ind',
            //     'lab_result_verify_key_ind',
            //     'lab_result_prepared_key_ind',
            //     'form_url',
            //     'report_no_fk',
            //     'report_url',
            //     'invoice_no_fk',
            //     'mail_ind',
            //     'email'

            // )
            ->select('labt_invoicedtl_vw.*', 'finc_invoicemst.patient_code', 'finc_invoicemst.customer_name as patient_name', 'labt_testreporting.report_delivered_ind')
            ->leftjoin('finc_invoicemst', 'finc_invoicemst.invoice_no_pk', '=', 'labt_invoicedtl_vw.invoice_no_fk')
            ->leftjoin('labt_testreporting', 'labt_testreporting.report_no_pk', '=', 'labt_invoicedtl_vw.report_no_fk')
            ->where('labt_invoicedtl_vw.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));

        if ($type == 1) {
            $invoice_item_rs->when($applyWhereNull, function ($query) {
                return $query->whereNull('labt_invoicedtl_vw.lab_result_final_key_ind');
            });
        }




        if (!empty($prescription_id)) {
            $invoice_item_rs->when($prescription_id, function ($query, $prescription_id) {
                return $query->where('labt_invoicedtl_vw.invoice_code', $prescription_id);
            });
        }
        if (!empty($lab_id)) {
            $invoice_item_rs->when($lab_id, function ($query, $lab_id) {
                return $query->where('labt_invoicedtl_vw.lab_code', $lab_id);
            });
        }
        if (!empty($service_unit)) {
            $invoice_item_rs->when($service_unit, function ($query, $service_unit) {
                return $query->where('labt_invoicedtl_vw.service_unit_no_fk', $service_unit);
            });
        }

        if (!empty($admission_id)) {
            $invoice_item_rs->when($admission_id, function ($query, $admission_id) {
                return $query->where('labt_invoicedtl_vw.admission_no_pk', $admission_id);
            });
        }

        if ($request->hdn_operation != "finalized" &&  $request->hdn_operation == "finalize") {
            if (!empty($from_date) && !empty($to_date)) {
                $invoice_item_rs->where(DB::raw("trunc(labt_invoicedtl_vw.lab_result_verify_keyed_time)"), '>=', date('Y/m/d', strtotime(request('search_date_from'))));
                $invoice_item_rs->where(DB::raw("trunc(labt_invoicedtl_vw.lab_result_verify_keyed_time)"), '<=', date('Y/m/d', strtotime(request('search_date_to'))));
            } elseif (!empty($from_date)) {
                $invoice_item_rs->where(DB::raw("trunc(labt_invoicedtl_vw.lab_result_verify_keyed_time)"), '=', date('Y/m/d', strtotime(request('search_date_from'))));
            } elseif (!empty($to_date)) {
                $invoice_item_rs->where(DB::raw("labt_invoicedtl_vw.lab_result_verify_keyed_time"), '=', date('Y/m/d', strtotime(request('search_date_to'))));
            }
        } elseif ($request->hdn_operation != "finalized") {
            if (!empty($from_date) && !empty($to_date)) {
                $invoice_item_rs->where(DB::raw("trunc(labt_invoicedtl_vw.invoice_date)"), '>=', date('Y/m/d', strtotime(request('search_date_from'))));
                $invoice_item_rs->where(DB::raw("trunc(labt_invoicedtl_vw.invoice_date)"), '<=', date('Y/m/d', strtotime(request('search_date_to'))));
            } elseif (!empty($from_date)) {
                $invoice_item_rs->where(DB::raw("trunc(labt_invoicedtl_vw.invoice_date)"), '=', date('Y/m/d', strtotime(request('search_date_from'))));
            } elseif (!empty($to_date)) {
                $invoice_item_rs->where(DB::raw("labt_invoicedtl_vw.invoice_date"), '=', date('Y/m/d', strtotime(request('search_date_to'))));
            }
        }

        $invoice_item_rs->when($request, function ($query, $request) {
            $hdn_operation = $request->hdn_operation;


            if ($hdn_operation == "prepare") {

                if (Session::get('user.ses_hospital_code') == "UNICO") {
                    $user_service_unit =  DB::table('sysc_grant_su')
                        ->select('su_no_fk')
                        ->where('user_no_fk', Auth::user()->user_no_pk)
                        ->where('status', 1)
                        ->get();
                    $user_service_list = 0;
                    if (!empty($user_service_unit)) {
                        $user_service_list = $user_service_unit->implode('su_no_fk', ',');
                    }
                    return $query->where("labt_invoicedtl_vw.lab_rcv_from_sp_key_ind", 1)
                        ->whereRaw("labt_invoicedtl_vw.service_unit_no_fk in ($user_service_list)")
                        ->whereNull("lab_result_verify_key_ind");
                } else {
                    return $query->where("labt_invoicedtl_vw.lab_rcv_from_sp_key_ind", 1)
                        ->whereNull("lab_result_verify_key_ind");
                }
            }

            if ($hdn_operation == "verify") {

                if (Session::get('user.ses_hospital_code') == "UNICO") {
                    $user_service_unit =  DB::table('sysc_grant_su')
                        ->select('su_no_fk')
                        ->where('user_no_fk', Auth::user()->user_no_pk)
                        ->where('status', 1)
                        ->get();
                    $user_service_list = 0;
                    if (!empty($user_service_unit)) {
                        $user_service_list = $user_service_unit->implode('su_no_fk', ',');
                    }
                    return $query->where("labt_invoicedtl_vw.lab_result_prepared_key_ind", 1)
                        ->whereRaw("labt_invoicedtl_vw.service_unit_no_fk in ($user_service_list)")
                        ->whereNull("lab_result_final_key_ind");
                } else {
                    return $query->where("labt_invoicedtl_vw.lab_result_prepared_key_ind", 1)
                        ->whereNull("lab_result_final_key_ind");
                }
            }

            if ($hdn_operation == "finalize") {

                if (in_array(Session::get('user.ses_hospital_code'), ["DMHL", "UNICO"])) {
                    return $query->where("labt_invoicedtl_vw.lab_result_verify_key_ind", 1)->whereNull('labt_invoicedtl_vw.lab_result_final_key_ind');
                } else {
                    return $query->where("labt_invoicedtl_vw.lab_result_verify_key_ind", 1);
                }
            }

            if ($hdn_operation == "finalized") {
                $from_date = $request->search_date_from;
                $to_date = $request->search_date_to;

                if (!empty($from_date) && !empty($to_date)) {
                    // dd($hdn_operation,$from_date, $to_date);
                    $query->where(DB::raw("trunc(labt_invoicedtl_vw.lab_result_final_keyed_time)"), '>=', date('Y-m-d', strtotime($from_date)))->where(DB::raw("trunc(labt_invoicedtl_vw.lab_result_final_keyed_time)"), '<=', date('Y-m-d', strtotime($to_date)));
                }
                return $query = $query->where("labt_invoicedtl_vw.lab_result_final_key_ind", 1);
            }
        });

        if ( $request->delivered_status == '1') {
                $invoice_item_rs->where('labt_testreporting.report_delivered_ind',1);
        }elseif ( $request->delivered_status == '0') {
            // dd( $request->delivered_status);
                $invoice_item_rs->whereNull('labt_testreporting.report_delivered_ind');
        }
        $operation = $request->hdn_operation;
        $applyWhereNull = Session::get('user.ses_hospital_code') == "DMHL";
        $invoice_item_arr = $invoice_item_rs
            // ->when($applyWhereNull, function ($query) {
            //     return $query->whereNull('labt_invoicedtl_vw.lab_result_final_key_ind');
            // })
            ->whereNull('labt_invoicedtl_vw.cancel_ind')
            ->orderBy("labt_invoicedtl_vw.invoice_no_fk", "desc")
            // ->orderBy("labt_invoicedtl_vw.item_name", "asc")
            ->get();
        // dd( $mail_type);
        //   dd( $invoice_item_arr);
        // dd($invoice_item_arr);
        $item_list = [];






        // forRadiology
         $prescription_id = $request->prescription_id;
        $lab_id = $request->lab_id;
        $admission_id = $request->admission_no;
        $service_unit = $request->service_unit;
        $type = $request->hdn_type;
        $mail_type = 1;
        // dd($type );
        $from_date = $request->search_date_from;
        $to_date = $request->search_date_to;
        $applyWhereNull = in_array(Session::get('user.ses_hospital_code'), ["DMHL", "UNICO"]);

        $item_list = DB::table('radt_invoicedtl_app_wl_vw as a')
            ->join('pat_registration_wl_vw as b', 'a.patient_no_fk', '=', 'b.patient_no_pk')
            ->select(
                'b.patient_name',
                'b.patient_code',
                'a.invoice_date',
                'a.invoice_code',
                'a.invoice_no_pk',
                'labt_invoicedtl_vw.mobile1',
                'a.radinvoicedtl_no_pk',
                'a.admission_no_pk',
                'a.ic_image_capture_keyed_time',
                'a.result_prepared_keyed_time',
                'a.finalize_keyed_time',
                'a.item_name',
                'a.status',
                // 'labt_invoicedtl_vw.report_no_fk',
                'a.delivery_dttm',
                'a.verify_key_ind',
                'a.result_prepared_key_ind',
                'a.finalize_key_ind',
                'labt_invoicedtl_vw.sms_ind',
                'labt_invoicedtl_vw.mail_ind',
                'wsec_hospital.email',
            )->leftjoin('WSEC_HOSPITAL','a.au_entry_hospital_pk_no','WSEC_HOSPITAL.HOSPITAL_NO_pK')
            ->leftjoin('labt_invoicedtl_vw','a.invoice_no_pk','labt_invoicedtl_vw.INVOICE_NO_FK')
           ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));


        if (!empty($prescription_id)) {
            $item_list->when($prescription_id, function ($query, $prescription_id) {
                return $query->where('a.invoice_code', $prescription_id);
            });
        }
        if (!empty($service_unit)) {
            $item_list->when($service_unit, function ($query, $service_unit) {
                return $query->where('a.service_unit_no_fk', $service_unit);
            });
        }

        if (!empty($admission_id)) {
            $item_list->when($admission_id, function ($query, $admission_id) {
                return $query->where('a.admission_no_pk', $admission_id);
            });
        }

            if (!empty($from_date) && !empty($to_date)) {
                $item_list->where(DB::raw("trunc(a.invoice_date)"), '>=', date('Y/m/d', strtotime(request('search_date_from'))));
                $item_list->where(DB::raw("trunc(a.invoice_date)"), '<=', date('Y/m/d', strtotime(request('search_date_to'))));
            } elseif (!empty($from_date)) {
                $item_list->where(DB::raw("trunc(a.invoice_date)"), '=', date('Y/m/d', strtotime(request('search_date_from'))));
            } elseif (!empty($to_date)) {
                $item_list->where(DB::raw("a.invoice_date"), '=', date('Y/m/d', strtotime(request('search_date_to'))));
            }

        $item_list = $item_list
            ->where('a.finalize_key_ind',1)
            ->whereNull('a.cancel_ind')
            ->orderBy("a.invoice_no_pk", "desc")
            // ->orderBy("labt_invoicedtl_vw.item_name", "asc")
            ->get();
        return Template::loadview("admin.pathology.result_entry_delivery_list", ["invoice_item_arr" => $invoice_item_arr,"item_list" => $item_list, "type" => $type, 'operation' => $operation, 'mailType' => $mail_type]);
    }
  public function resultPrintDeliverySearchRad(Request $request)
    {
        $prescription_id = $request->prescription_id;
        $lab_id = $request->lab_id;
        $admission_id = $request->admission_no;
        $service_unit = $request->service_unit;
        $type = $request->hdn_type;
        $mail_type = 1;
        // dd($type );
        $from_date = $request->search_date_from;
        $to_date = $request->search_date_to;
        $applyWhereNull = in_array(Session::get('user.ses_hospital_code'), ["DMHL", "UNICO"]);

        $invoice_item_rs = DB::table('radt_invoicedtl_app_wl_vw as a')
            ->join('pat_registration_wl_vw as b', 'a.patient_no_fk', '=', 'b.patient_no_pk')
            ->select(
                'b.patient_name',
                'b.patient_code',
                'a.invoice_date',
                'a.invoice_code',
                'a.invoice_no_pk',
                'a.radinvoicedtl_no_pk',
                'a.admission_no_pk',
                'a.ic_image_capture_keyed_time',
                'a.result_prepared_keyed_time',
                'a.finalize_keyed_time',
                'a.item_name',
                'a.status',
                'a.delivery_dttm',
                'a.verify_key_ind',
                'a.result_prepared_key_ind',
                'a.finalize_key_ind'
            )
           ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));




        if (!empty($prescription_id)) {
            $invoice_item_rs->when($prescription_id, function ($query, $prescription_id) {
                return $query->where('a.invoice_code', $prescription_id);
            });
        }
        if (!empty($service_unit)) {
            $invoice_item_rs->when($service_unit, function ($query, $service_unit) {
                return $query->where('a.service_unit_no_fk', $service_unit);
            });
        }

        if (!empty($admission_id)) {
            $invoice_item_rs->when($admission_id, function ($query, $admission_id) {
                return $query->where('a.admission_no_pk', $admission_id);
            });
        }

            if (!empty($from_date) && !empty($to_date)) {
                $invoice_item_rs->where(DB::raw("trunc(a.invoice_date)"), '>=', date('Y/m/d', strtotime(request('search_date_from'))));
                $invoice_item_rs->where(DB::raw("trunc(a.invoice_date)"), '<=', date('Y/m/d', strtotime(request('search_date_to'))));
            } elseif (!empty($from_date)) {
                $invoice_item_rs->where(DB::raw("trunc(a.invoice_date)"), '=', date('Y/m/d', strtotime(request('search_date_from'))));
            } elseif (!empty($to_date)) {
                $invoice_item_rs->where(DB::raw("a.invoice_date"), '=', date('Y/m/d', strtotime(request('search_date_to'))));
            }

        $invoice_item_arr = $invoice_item_rs
            ->where('a.finalize_key_ind',1)
            ->whereNull('a.cancel_ind')
            ->orderBy("a.invoice_no_pk", "desc")
            // ->orderBy("labt_invoicedtl_vw.item_name", "asc")
            ->get();

        return Template::loadview("admin.pathology.result_entry_delivery_list", ["item_list" => $invoice_item_arr, "type" => $type, 'mailType' => $mail_type]);
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    public function resultFinalize()
    {
        $type = 2;
        $today = date('d-m-Y', strtotime("-30 Days"));
        $operation = 'finalize';
        $user_service_unit =  DB::table('sysc_grant_su')
            ->where('user_no_fk', Auth::user()->user_no_pk)     //for Draft report 09/07/2023
            ->where('status', 1)
            ->get();
        $user_service_list = 0;
        if (!empty($user_service_unit)) {
            $user_service_list = $user_service_unit->implode('su_no_fk', ',');
        }
        $applyWhereNull = in_array(Session::get('user.ses_hospital_code'), ["DMHL", "UNICO","AMCSH"]);

        $applyWhereNullNot = !in_array(Session::get('user.ses_hospital_code'), ["DMHL", "UNICO" ,"AMCSH"]);


        // dd(  $subQuery);
        $invoice_item_arr =
            DB::table("labt_invoicedtl_vw")
            ->select('labt_invoicedtl_vw.*', 'finc_invoicemst.patient_code', 'finc_invoicemst.patient_no_fk', 'finc_invoicemst.customer_name as patient_name')
            ->leftjoin('finc_invoicemst', 'finc_invoicemst.invoice_no_pk', '=', 'labt_invoicedtl_vw.invoice_no_fk')
            ->leftJoin('ipd_admitted_patlist_vw', 'ipd_admitted_patlist_vw.admission_no_pk', '=', 'labt_invoicedtl_vw.admission_no_pk')
            ->select('labt_invoicedtl_vw.*','ipd_admitted_patlist_vw.new_bed_name','ipd_admitted_patlist_vw.new_ward_name','ipd_admitted_patlist_vw.new_su_name')

            // ->join('sysc_grant_su', 'sysc_grant_su.su_no_fk', '=', 'labt_invoicedtl_vw.service_unit_no_fk')
            ->where('labt_invoicedtl_vw.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("labt_invoicedtl_vw.lab_result_verify_key_ind", 1)
            ->when($applyWhereNull, function ($query) {
                return $query->whereNull('labt_invoicedtl_vw.lab_result_final_key_ind');
            })
            ->whereNull('labt_invoicedtl_vw.cancel_ind')
            // ->orderBy("lab_code", "desc")
            ->orderBy('labt_invoicedtl_vw.delivery_status_no', 'desc')
            ->orderBy('labt_invoicedtl_vw.lab_result_final_keyed_time', 'desc')
            ->whereRaw("labt_invoicedtl_vw.service_unit_no_fk in ($user_service_list)")
            ->whereRaw("labt_invoicedtl_vw.lab_result_verify_keyed_time >= to_date('$today','DD-MM-YYYY')")
            ->when($applyWhereNullNot, function ($query) {
                $today = date('d-m-Y', strtotime("-30 Days"));
                return $query->whereRaw("lab_result_final_keyed_time >= to_date('$today' ,'DD-MM-YYYY')");
            })
            ->get()
            ->toArray();
        //    dd( $invoice_item_arr);
        $service_unit = DB::table('sysc_serviceunit')
        ->select('serviceunit_no_pk', 'serviceunit_name')
        ->whereRaw("serviceunit_no_pk in ($user_service_list)")
        ->where('pathology_ind', 1)
        ->where('status', 1)->get();
        return Template::loadview("admin.pathology.result_finalize", ["invoice_item_arr" => $invoice_item_arr, "type" => $type, "operation" => $operation, 'service_unit' => $service_unit]);
        // return Template::loadview("admin.pathology.result_finalize", [ "type" => $type, "operation" => $operation]);
    }

    public function resultFinalized($mailType = "")
    {
        $type = 2;
        $beforday = date('d-m-Y', strtotime("-7 Days"));
        $today    = date('d-m-Y', strtotime("+1 Days"));
        $operation = 'finalized';

        // Get user service units
        $user_service_unit = DB::table('sysc_grant_su')
            ->where('user_no_fk', Auth::user()->user_no_pk)
            ->where('status', 1)
            ->get();

        $user_service_list = "0"; // default fallback
        if ($user_service_unit->isNotEmpty()) {
            // Remove duplicates
            $user_service_list = $user_service_unit->pluck('su_no_fk')->unique()->implode(',');
        }

        $applyWhereNull    = in_array(Session::get('user.ses_hospital_code'), ["DMHL", "UNICO", "AMCSH"]);
        $applyWhereNullNot = !$applyWhereNull;

        // Main invoice query
        $invoice_item_arr = DB::table('LABT_INVOICEDTL_VW')
            ->leftJoin('FINC_INVOICEMST', 'FINC_INVOICEMST.INVOICE_NO_PK', '=', 'LABT_INVOICEDTL_VW.INVOICE_NO_FK')
            ->leftJoin('IPD_ADMITTED_PATLIST_VW', 'IPD_ADMITTED_PATLIST_VW.ADMISSION_NO_PK', '=', 'LABT_INVOICEDTL_VW.ADMISSION_NO_PK')
            ->select(
                'LABT_INVOICEDTL_VW.*',
                'FINC_INVOICEMST.PATIENT_CODE',
                'FINC_INVOICEMST.PATIENT_NO_FK',
                'FINC_INVOICEMST.CUSTOMER_NAME as PATIENT_NAME',
                'IPD_ADMITTED_PATLIST_VW.NEW_BED_NAME',
                'IPD_ADMITTED_PATLIST_VW.NEW_WARD_NAME',
                'IPD_ADMITTED_PATLIST_VW.NEW_SU_NAME'
            )
            ->where('LABT_INVOICEDTL_VW.AU_ENTRY_HOSPITAL_PK_NO', Session::get('user.ses_hospital_no_pk'))
            ->where('LABT_INVOICEDTL_VW.LAB_RESULT_FINAL_KEY_IND', 1)
            ->whereNull('LABT_INVOICEDTL_VW.CANCEL_IND')
            ->whereRaw("LABT_INVOICEDTL_VW.SERVICE_UNIT_NO_FK in ($user_service_list)")
            ->whereRaw("TRUNC(LABT_INVOICEDTL_VW.LAB_RESULT_FINAL_KEYED_TIME) >= TO_DATE('$beforday', 'DD-MM-YYYY')")
            ->whereRaw("TRUNC(LABT_INVOICEDTL_VW.LAB_RESULT_FINAL_KEYED_TIME) <= TO_DATE('$today', 'DD-MM-YYYY')")
            ->orderByDesc('LABT_INVOICEDTL_VW.LAB_RESULT_FINAL_KEYED_TIME')
            ->get();

        // Get service units for dropdown
        $service_unit = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            ->whereRaw("serviceunit_no_pk in ($user_service_list)")
            ->where('pathology_ind', 1)
            ->where('status', 1)
            ->get();

        return Template::loadview(
            "admin.pathology.result_finalize",
            [
                "invoice_item_arr" => $invoice_item_arr,
                "type"             => $type,
                "operation"        => $operation,
                "service_unit"     => $service_unit,
                "mailType"         => $mailType
            ]
        );
    }


    public function resultFinalizedSendMail($mailType = 1)
    {
        $type = 2;
        $beforday = date('d-m-Y', strtotime("-7 Days"));
        $today = date('d-m-Y');
        $operation = 'finalized';
        // $user_service_unit =  DB::table('sysc_grant_su')
        //     // ->where('user_no_fk', Auth::user()->user_no_pk)     //for Draft report 09/07/2023
        //     ->where('status', 1)
        //     ->get();
        // $user_service_list = 0;
        // if (!empty($user_service_unit)) {
        //     $user_service_list = $user_service_unit->implode('su_no_fk', ',');
        // }

        $invoice_item_arr = DB::table("labt_invoicedtl_vw")
            ->select('labt_invoicedtl_vw.*', 'finc_invoicemst.patient_code', 'finc_invoicemst.patient_no_fk', 'finc_invoicemst.customer_name as patient_name')
            ->leftjoin('finc_invoicemst', 'finc_invoicemst.invoice_no_pk', '=', 'labt_invoicedtl_vw.invoice_no_fk')
            ->where('labt_invoicedtl_vw.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("labt_invoicedtl_vw.lab_result_final_key_ind", 1)
            ->whereNull('labt_invoicedtl_vw.cancel_ind')
            // ->orderBy("lab_code", "desc")
            ->orderBy('labt_invoicedtl_vw.lab_result_final_keyed_time', 'desc')
            // ->whereRaw("labt_invoicedtl_vw.service_unit_no_fk in ($user_service_list)")
            ->whereRaw("labt_invoicedtl_vw.lab_result_final_keyed_time >= to_date('$beforday','DD-MM-YYYY') and lab_result_final_keyed_time >= to_date('$today' ,'DD-MM-YYYY')")
            ->get()
            ->toArray();
        //   dd(  $invoice_item_arr);
        $service_unit = DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('pathology_ind', 1)->where('status', 1)->get();
        return Template::loadview("admin.pathology.result_finalize", ["invoice_item_arr" => $invoice_item_arr, "type" => $type, "operation" => $operation, 'service_unit' => $service_unit, 'mailType' => $mailType]);
        // return Template::loadview("admin.pathology.result_finalize", [ "type" => $type, "operation" => $operation]);
    }
    public function resultPrintSendMailDelivery($mailType = 1)
    {
        $type = 2;
        $pageType = "delivery";
        $beforday = date('d-m-Y', strtotime("-7 Days"));
        $today = date('d-m-Y');
        $operation = 'finalized';

        $invoice_item_arr = [];
        $item_list = [];
        //  DB::table("labt_invoicedtl_vw")
        //     ->select('labt_invoicedtl_vw.*','finc_invoicemst.patient_code','finc_invoicemst.patient_no_fk','finc_invoicemst.customer_name as patient_name','labt_testreporting.report_delivered_ind')
        //     ->leftjoin('finc_invoicemst','finc_invoicemst.invoice_no_pk','=','labt_invoicedtl_vw.invoice_no_fk')
        //     ->leftjoin('labt_testreporting','labt_testreporting.report_no_pk','=','labt_invoicedtl_vw.report_no_fk')
        //     ->where('labt_invoicedtl_vw.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //     ->where("labt_invoicedtl_vw.lab_result_final_key_ind", 1)
        //     ->whereNull('labt_invoicedtl_vw.cancel_ind')
        //     ->orderBy('labt_invoicedtl_vw.lab_result_final_keyed_time', 'desc')
        //     ->whereRaw("labt_invoicedtl_vw.lab_result_final_keyed_time >= to_date('$beforday','DD-MM-YYYY') and lab_result_final_keyed_time >= to_date('$today' ,'DD-MM-YYYY')")
        //     ->get()
        //     ->toArray();
        // dd( $invoice_item_arr);
        $service_unit = DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('pathology_ind', 1)->where('status', 1)->get();
        return Template::loadview("admin.pathology.result_finalized_print_delivery", ["invoice_item_arr" => $invoice_item_arr, "type" => $type, "operation" => $operation, 'service_unit' => $service_unit, 'mailType' => $mailType, 'pageType' => $pageType,'item_list' => $item_list]);
    }



    public function patPathTestHistory($id)
    {
        $item_pat = explode('*', $id);
        $item_id = $item_pat[0];
        $pat_id = $item_pat[1];
        // $get_invoice_no=DB::table('labt_invoicedtl_vw')->select('invoice_no_fk')->where('patient_no_fk',$pat_id)->where('item_no_pk',$item_id)->pluck('invoice_no_fk');
        // $lab_attr=
        // DB::table('labs_teststructure')
        // ->select('teststruct_no_pk','attr','teststruct_no_pk')
        // ->where('item_no_fk',$item_id)
        // ->where('STATUS',1)
        // ->where('hide_permanent',0)
        // ->orderBy('labs_teststructure.group_seq','asc')
        // ->get();
        // $report_data = DB::table("labt_testresultstruct_vw")
        // ->select('report_no_fk','result0','teststruct_no_fk','unit')
        // ->whereIn('invoice_no_fk',$get_invoice_no)
        // ->where('item_no_fk',$item_id)
        // ->where('show_in_rep', 1)
        // ->where('cancel_ind', null)
        // ->orderBy('invoice_no_fk', 'ASC')
        // ->orderBy('sl_no', 'ASC')
        // ->get()->groupBy('report_no_fk');

        $get_item_no = DB::table('labt_invoicedtl_vw')
            ->select('item_no_pk')
            ->where('patient_no_fk', $pat_id)
            // ->where('lab_result_final_key_ind',1)
            ->groupBy('item_no_pk', 'lab_result_final_keyed_time')
            ->orderBy('lab_result_final_keyed_time', 'desc')
            ->pluck('item_no_pk');
        $get_invoice_no = DB::table('labt_invoicedtl_vw')->select('invoice_no_fk')->where('patient_no_fk', $pat_id)->orderBy('invoice_no_fk', 'desc')->pluck('invoice_no_fk');

        // DB::table('labs_teststructure')
        // ->select('teststruct_no_pk','attr','teststruct_no_pk','item_no_fk','sysc_serviceitem.item_name')
        // ->leftjoin('sysc_serviceitem','sysc_serviceitem.item_no_pk','=','labs_teststructure.item_no_fk')
        // ->whereIn('item_no_fk',$get_item_no)
        // ->where('labs_teststructure.STATUS',1)
        // ->where('hide_permanent',0)
        // ->orderBy('group_seq','asc')
        // ->get()->groupBy('item_name');

        $lab_attrs = DB::table('labs_teststructure')
            ->select([
                'labs_teststructure.teststruct_no_pk',
                'labs_teststructure.attr',
                DB::raw('(SELECT LISTAGG(NORMAL_RESULT, \'*\') WITHIN GROUP (ORDER BY NORMAL_RESULT) AS normal_results FROM LABS_TESTREFERENCEVALUE WHERE TESTSTRUCT_NO_FK = labs_teststructure.teststruct_no_pk) AS normal_results'), // Use LISTAGG
                DB::raw('(SELECT LISTAGG(high_age_yy, \'*\') WITHIN GROUP (ORDER BY high_age_yy) AS high_age_yys FROM LABS_TESTREFERENCEVALUE WHERE TESTSTRUCT_NO_FK = labs_teststructure.teststruct_no_pk) AS high_age_yys'),
                DB::raw('(SELECT LISTAGG(LOW_AGE_YY, \'*\') WITHIN GROUP (ORDER BY LOW_AGE_YY) AS LOW_AGE_YY FROM LABS_TESTREFERENCEVALUE WHERE TESTSTRUCT_NO_FK = labs_teststructure.teststruct_no_pk) AS LOW_AGE_YY'),
                'sysc_serviceitem.item_name',
            ])
            ->leftJoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'labs_teststructure.item_no_fk')
            ->whereIn('item_no_fk', $get_item_no)
            ->where('labs_teststructure.STATUS', 1)
            ->where('hide_permanent', 0)
            // ->orderBy('group_seq','asc')
            ->orderBy('sysc_serviceitem.item_name', 'asc')
            ->get()->toArray();
        $lab_attr = [];
        if (!empty($lab_attrs)) {
            foreach ($lab_attrs as $value) {
                $lab_attr[$value->item_name][] = $value;
            }
        }

        $report_datas = DB::table("labt_testresultstruct_vw")
            ->select('labt_testresultstruct_vw.report_no_fk', 'labt_testresultstruct_vw.result0', 'labt_testresultstruct_vw.teststruct_no_fk', 'labt_testresultstruct_vw.unit', 'item_no_fk', 'sysc_serviceitem.item_name', 'labt_testresultstruct_vw.au_update_at', 'labt_testresultstruct_vw.au_entry_at', 'labt_testresultstruct_vw.lab_result_final_keyed_time')
            ->whereIn('labt_testresultstruct_vw.invoice_no_fk', $get_invoice_no)
            ->leftjoin('sysc_serviceitem', 'sysc_serviceitem.item_no_pk', '=', 'labt_testresultstruct_vw.item_no_fk')
            // ->leftjoin('labt_invoicedtl_vw','labt_invoicedtl_vw.report_no_fk','=','labt_testresultstruct_vw.report_no_fk')
            // ->whereIn('item_no_fk',$get_item_no)
            ->where('labt_testresultstruct_vw.show_in_rep', 1)
            ->where('labt_testresultstruct_vw.cancel_ind', null)
            ->orderBy('labt_testresultstruct_vw.invoice_no_fk', 'desc')
            ->orderBy('labt_testresultstruct_vw.sl_no', 'ASC')
            ->get();
        // dd( $report_datas);
        $report_data = [];
        if (!empty($report_datas)) {
            foreach ($report_datas as $key => $value) {
                $report_data[$value->item_name][$value->report_no_fk][] = $value;
            }
        }

        $item_list = [];
        return Template::loadview("admin.pathology.show_path_history", ["report_data" => $report_data, "lab_attr" => $lab_attr,'item_list' => $item_list]);
    }
    public function patRadTestHistory($id)
    {
        $item_pat = explode('*', $id);
        $item_id = $item_pat[0];
        $pat_id = $item_pat[1];

        $get_item_no = DB::table('RADT_INVOICEDTL_VW')
            ->select('item_no_fk')
            ->where('patient_no_fk', $pat_id)
            // ->where('lab_result_final_key_ind',1)
            ->groupBy('item_no_fk', 'finalize_keyed_time')
            ->orderBy('finalize_keyed_time', 'desc')
            ->pluck('item_no_fk');
        $get_invoice_no = DB::table('radt_invoicedtl_vw')->select('invoice_no_fk')->where('patient_no_fk', $pat_id)->orderBy('invoice_no_fk', 'desc')->pluck('invoice_no_fk');

        $radiology_appointments_data = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("radt_reporting b", "a.radinvoicedtl_no_pk", "b.radinvoicedtl_no_fk")
            ->select(
                "b.result0",
                "a.item_name",
                "a.invoice_code",
                'a.item_code'
            )
            ->whereIn("a.invoice_code", $get_invoice_no)
            ->get();
        // dd( $radiology_appointments_data);

        $rad_attr = [];
        if (!empty($radiology_appointments_data)) {
            foreach ($radiology_appointments_data as $value) {
                $rad_attr[$value->item_name][] = $value;
            }
        }

        $report_data = [];
        if (!empty($radiology_appointments_data)) {
            foreach ($radiology_appointments_data as $key => $value) {
                $report_data[$value->item_name][] = $value;
            }
        }

        return Template::loadview("admin.radiology_v2.reports.show_rad_history_v2", ["radiology_appointments_data" => $radiology_appointments_data, "rad_attr" => $rad_attr, "report_data" => $report_data]);
    }

    public function resultFinalizeMic()
    {
        $type = 2;
        $today = date('d-m-Y', strtotime("-7 Days"));
        $operation = 'finalize';
        $service_unit_no = Session::get('user.su_pk_no');
        $grant_su_no = DB::table('sysc_grant_servieceunit_vw')
            ->select('serviceunit_no_pk')->where('USER_NO_PK', Auth::id())->get();
        $hospital = Session::get('user.ses_hospital_no_pk');
        $su_ids = [];

        if (!empty($grant_su_no)) {
            foreach ($grant_su_no as $key => $value) {
                $su_ids[$key] = $value->serviceunit_no_pk;
            }
        }

        $service_unit_name = Session::get('user.serviceunit');
        $invoice_item_arr = DB::table("labt_invoicedtl_vw")
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("lab_result_verify_key_ind", 1)
            ->whereIn("service_unit_no_fk", $su_ids)
            ->whereNull('cancel_ind')
            // ->orderBy("lab_code", "desc")
            ->orderBy('lab_result_final_keyed_time', 'desc')
            ->whereRaw("lab_result_verify_keyed_time >= to_date('$today','DD-MM-YYYY') and lab_result_final_keyed_time >= to_date('$today' ,'DD-MM-YYYY')")
            ->get()
            ->toArray();
        // dd($invoice_item_arr);
        $service_unit = DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('pathology_ind', 1)->where('status', 1)->get();
        return Template::loadview("admin.pathology.result_finalize_mic", ["invoice_item_arr" => $invoice_item_arr, "type" => $type, "operation" => $operation, 'service_unit' => $service_unit, 'service_unit_name' => $service_unit_name]);
        // return Template::loadview("admin.pathology.result_finalize", [ "type" => $type, "operation" => $operation]);
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */


    //     public function store(Request $request)
    //     {
    //         //
    //     }

    //     /**
    //      * Display the specified resource.
    //      *
    //      * @param  int  $id
    //      * @return \Illuminate\Http\Response
    //      */
    public function show($id = "")
    {
        $radinvoicedtl_no_pk = explode('_', $id);
        // dd(intval($radinvoicedtl_no_pk[0]));
        // $filePath = public_path('images/uploads/cv/text2.docx');
        // $sourceFilePath = $filePath;
        // $destinationFilePath = 'D:\xampp\htdocs\h360\public\images\uploads\radiology_report\radiology_report_1.docx';
        // File::copy($sourceFilePath, $destinationFilePath);
        // $content = "Hello, world for radiology";
        // $sourceFilePaths = public_path('images/uploads/cv/source.md');
        // file_put_contents($sourceFilePaths, $content);
        // $command = 'cp ' . $sourceFilePaths . ' ' . $destinationFilePath;
        // $process = new Process($command);
        // $process = new Process(['start', 'winword.exe', $destinationFilePath]);
        // $process->run();
        // return 'Word document opened successfully!';

        $radiology_appointment_data = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("radt_reporting b", "a.radinvoicedtl_no_pk", "b.radinvoicedtl_no_fk")
            ->select(
                "a.invoice_code",
                "a.radinvoicedtl_no_pk",
                "a.prescription_no_fk",
                "a.report_delivary_date",
                "b.rad_report_no_pk",
                "b.rad_report_uid",
                "b.result0",
                "a.img_app_dttm",
                "a.patient_no_fk",
                "a.delivery_dttm",
                "prepared_full_name",
                "prepared_doc_degree_1",
                "prepared_doc_degree_2",
                "prepared_doc_degree_3",
                "prepared_doc_degree_4",
                "verify_full_name",
                "verify_doc_degree_1",
                "verify_doc_degree_2",
                "verify_doc_degree_3",
                "verify_doc_degree_4",
                "final_full_name",
                "finalized_doc_degree_1",
                "finalized_doc_degree_2",
                "finalized_doc_degree_3",
                "finalized_doc_degree_4",
                "fn_specialization",
                "vr_specialization",
                "pr_specialization",
                "a.item_name",
                "a.doctor_signature_pr",
                "a.doctor_signature_vr",
                "a.doctor_signature_fin",
                "a.ref_doc_name",
                'a.serviceunit_name',
                'a.accession_id',
                'doctor_signature',
                'a.item_code'
            )
            ->where("a.radinvoicedtl_no_pk", intval($radinvoicedtl_no_pk[1]))->first();
        $patient_info = DB::table("finc_voucherwise_vw a")
            ->select("a.invoice_code", "b.patient_code", "b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "a.first_ref_doc_name", "b.salutation", "b.passport_no")
            ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
            ->where("a.invoice_code", $radiology_appointment_data->invoice_code)->first();

        $po_hospital_details = DB::table("wsec_hospital")->first();

        $app_barcode = '';
        $invoice_barcode = '';

        if (!empty($radiology_appointment_data)) {
            $barcode = new BarcodeGenerator();
            $barcode->setText($radiology_appointment_data->rad_report_uid);
            $barcode->setType(BarcodeGenerator::Code128);
            $barcode->setLabel('');
            $barcode->setScale(1);
            $barcode->setThickness(25);
            $barcode->setFontSize(10);
            $app_barcode = $barcode->generate();

            $barcode1 = new BarcodeGenerator();
            $barcode1->setText($radiology_appointment_data->invoice_code);
            $barcode1->setType(BarcodeGenerator::Code128);
            $barcode1->setScale(1);
            $barcode1->setLabel('');
            $barcode1->setThickness(25);
            $barcode1->setFontSize(10);
            $invoice_barcode = $barcode1->generate();
        }

        $template = DB::table('rads_resulttemplate')->select('report_text_html')->where('result_template_no_pk', intval($radinvoicedtl_no_pk[0]))->where('status', 1)->first();
        // dd($template);
        $content = view('admin.radiology.reports.radiology_report_word_file', [
            "app_barcode" => $app_barcode,
            "invoice_barcode" => $invoice_barcode,
            "patient_info" => $patient_info,
            "radiology_appointment_data" => $radiology_appointment_data,
            "po_hospital_details" => $po_hospital_details,
            "template" => $template,
        ])->render();
        $name = $radinvoicedtl_no_pk[1] . '.doc';
        $headers = [
            "Content-Type" => "application/vnd.openxmlformats-officedocument.wordprocessingml.document",
            "Content-Disposition" => "attachment;Filename=$name",
        ];

        // Save the file to the destination path
        $destinationFilePath = public_path('images/uploads/radiology_report/' . $name);
        if (File::exists(public_path('images/uploads/radiology_report/' . $name))) {
            File::delete(public_path('images/uploads/radiology_report/' . $name));
            file_put_contents($destinationFilePath, $content);
            // $process = new Process(['start', 'winword.exe', $destinationFilePath]);
            // $process->run();
        } else {
            file_put_contents($destinationFilePath, $content);
            // $process = new Process(['start', 'winword.exe', $destinationFilePath]);
            // $process->run();

        }
    }
    function openWord($id)
    {
        $destinationFilePath = public_path('images/uploads/radiology_report/' . $id . '.doc');
        // $process = new Process(['start', 'winword.exe', $destinationFilePath]);
        // $process->run();


        if (file_exists($destinationFilePath)) {
            return response()->download($destinationFilePath);
        } else {
            return response()->json(['error' => 'File not found.'], 404);
        }
    }

    //     /**
    //      * Show the form for editing the specified resource.
    //      *
    //      * @param  int  $id
    //      * @return \Illuminate\Http\Response
    //      */
    //     public function edit($id)
    //     {
    //         //
    //     }

    //     /**
    //      * Update the specified resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @param  int  $id
    //      * @return \Illuminate\Http\Response
    //      */
    //     public function update(Request $request, $id)
    //     {
    //         //
    //     }

    //     /**
    //      * Remove the specified resource from storage.
    //      *
    //      * @param  int  $id
    //      * @return \Illuminate\Http\Response
    //      */
    //     public function destroy($id)
    //     {
    //         //
    //     }

    //Added By Nazmul 13/05/2021 start
    public function pathologyTestWiseAttrEntry()
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $examList = DB::table('sysc_serviceitem_vw')
            ->select('item_no_pk', 'item_type', 'item_code', 'item_name', 'item_type_name', 'itemtype_no_fk', 'serviceunit_no_fk', 'serviceunit_name', 'item_short_name', 'sam_no_fk', 'sam_name', 'test_temp_no_fk', 'temp_name', 'status', 'au_entry_at')
            ->where('item_type', 'LAB')
            ->where('au_entry_hospital_pk_no', $hospital_id)
            ->get()->toArray();
        $labs_testAttrGroup = DB::table('labs_testattrgroup')->select('test_group_no_pk', 'attrgroup')->where('au_entry_hospital_pk_no', $hospital_id)->where('status', 1)->get();

        $labs_ageGroup = DB::table('labs_testreferencevalue_group')->select('ref_group_no_pk', 'group_name')->where('au_entry_hospital_pk_no', $hospital_id)->where('status', 1)->get();
        $labs_sample = DB::table("labs_sample")->select('sam_no_pk', 'sam_name')->where('au_entry_hospital_pk_no', $hospital_id)->where('status', 1)->get();
        $labs_template = DB::table("labs_testtemplate")->select('test_temp_no_pk', 'temp_name')->where('au_entry_hospital_pk_no', $hospital_id)->where('status', 1)->get();
        $service_unit = DB::table('sysc_serviceunit')->where('au_entry_hospital_pk_no', $hospital_id)->where('pathology_ind', '1' and 'status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->get();
        $analyzerList = DB::table('sysc_serviceitem')->where('au_entry_hospital_pk_no', $hospital_id)->where('analyzer_ind', '1' and 'status', '1')->select('item_no_pk', 'item_name', 'item_code')->get();

        return Template::loadview("admin.pathology.pathology_test_wise_attr_entry", [
            'examList' => $examList,
            'labs_sample' => $labs_sample,
            'labs_template' => $labs_template,
            'service_unit' => $service_unit,
            'labs_testAttrGroup' => $labs_testAttrGroup,
            'labs_ageGroup' => $labs_ageGroup,
            'analyzerList' => $analyzerList
        ]);
    }

    public function pathologyTestWiseAttrList(Request $request)
    {
        $attrList = DB::table('labs_teststructure tst_str')
            ->select('tst_str.*', 'attr_grp.attrgroup')
            ->leftJoin('labs_testattrgroup attr_grp', 'tst_str.test_group_no_fk', '=', 'attr_grp.test_group_no_pk')
            ->where('tst_str.item_no_fk', $request->exam_id_hidden)
            ->orderBy('tst_str.sl_no', 'asc')
            ->get()->toArray();
        // dd($attrList);

        return Template::loadview("admin.pathology.pathology_test_wise_attr_list", [
            'attrList' => $attrList
        ]);
    }

    public function pathologyTestWiseAttrAnalyzerList(Request $request)
    {
        // dd($request->all());
        $analyzer_list = DB::table('labs_teststructure_analyzer')
            ->select('analyzerattr_no_pk', 'analyzerattr_code', 'teststruct_no', 'analyzer_no', 'analyzer_name', 'machine_attrib', 'panel_attrib', 'normal_result', 'unit', 'status')
            ->where('teststruct_no', $request->teststruct_no_pk)
            ->orderBy('analyzerattr_no_pk', 'asc')
            ->get()->toArray();
        // dd($analyzer_list);
        return Template::loadview("admin.pathology.pathology_test_wise_attr_analyzer_list", [
            'analyzer_list' => $analyzer_list
        ]);
    }

    public function PathTestAttrRefvalList(Request $request)
    {
        // dd($request->teststruct_no_pk);
        $refvalList = DB::table('labs_testreferencevalue attrRefVal')
            ->select('attrRefVal.*', 'attrRefValGrp.group_name')
            ->leftJoin('labs_testreferencevalue_group attrRefValGrp', 'attrRefVal.ref_group_no_fk', '=', 'attrRefValGrp.ref_group_no_pk')
            ->where('teststruct_no_fk', $request->teststruct_no_pk)
            ->orderBy('referencevalue_no_pk', 'asc')
            ->get()->toArray();

        return Template::loadview("admin.pathology.pathology_test_wise_attr_test_referencevalue_list", [
            'refvalList' => $refvalList
        ]);
    }

    public function storePathTestAttrEntry(Request $request)
    {
        // dd($request->request->all());
        $id = $request->teststruct_no_pk;
        $auth_id = Auth::id();
        // dd($auth_id);
        try {
            $data = [
                'item_no_fk' => $request->item_no,
                'sl_no' => $request->sl_no,
                'teststruct_uid' => $request->attr_code,
                'attr' => $request->attr_attr,
                'unit' => $request->attr_unit,
                'result_input_type' => 1,
                'test_group_no_fk' => $request->attr_ag,
                'group_seq' => $request->attr_gs,
                'show_ind' => isset($request->attr_sf) ? 1 : 0,
                'hide_permanent' => isset($request->attr_hp) ? 1 : 0,
                'graph_ind' => isset($request->attr_gi) ? 1 : 0,
                'rpt_show_ind' => isset($request->show_column) ? 1 : 0,
                'status' => isset($request->attr_status) ? 1 : 0
            ];
            if ($id == "" || $id == 0) {
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');
                $this->labTestStructure->create($data);
            } else {
                // AU_UPDATE_BY
                // $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');
                // $this->labTestStructure->update($data, $id);
                DB::table('labs_teststructure')->where('teststruct_no_pk', $id)->update($data);
                DB::commit();
            }

            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {

            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function storePathTestAttrAnalyser(Request $request)
    {

        $id = $request->analyzerattr_no_pk;

        $auth_id = Auth::id();
        try {
            $data = [
                'teststruct_no' => $request->teststruct_no,
                'analyzer_no' => $request->analyzer,
                'machine_attrib' => $request->matchine_attribute,
                'panel_attrib' => $request->panel_attribute,
                'normal_result' => $request->normal_result,
                'unit' => $request->unit,
                'analyzer_name' => $request->analyzer_name_hidden,
                'status' => isset($request->analyzer_status) ? 1 : 0
            ];
            if ($id == "") {

                $data['au_entry_by'] = $auth_id;
                $data['au_entry_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');
                $this->labTestStructureAnalyzer->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_no_fk'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labs_teststructure_analyzer')->where('analyzerattr_no_pk', $id)->update($data);
            }

            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {

            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function storePathTestAttrRefvalEntry(Request $request)
    {

        // dd($request->all());
        $id = $request->attrrefval_referencevalue_no_pk;
        $auth_id = Auth::id();
        try {
            $data = [
                'teststruct_no_fk' => $request->attrrefval_teststruct_no,
                'gender' => $request->gender,
                'ref_group_no_fk' => $request->age_group,
                'low_age_dd' => $request->low_age_dd,
                'high_age_dd' => $request->high_age_dd,
                'low_age_mm' => $request->low_age_mm,
                'high_age_mm' => $request->high_age_mm,
                'low_age_yy' => $request->low_age_yy,
                'high_age_yy' => $request->high_age_yy,
                'normal_result' => $request->normal_result,
                'com_operator' => $request->com_operator,
                'low_result' => $request->low_result,
                'high_result' => $request->high_result,
                'low_critical_result' => $request->low_critical_result,
                'high_critical_result' => $request->high_critical_result,
                'status' => 1
            ];

            if ($id == "") {
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_session'] = $auth_id;
                $data['au_entry_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                $this->labTestReferenceValue->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_session'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                $this->labTestReferenceValue->update($data, $id);
            }

            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {

            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function removePathTestAttrRefval(Request $request)
    {
        $id = $request->referencevalue_no_pk;
        // dd($id);
        try {
            if ($id != "") {
                // $this->labTestReferenceValue->delete($id);
                DB::table('labs_testreferencevalue')->where('referencevalue_no_pk', $id)->delete();
                DB::commit();
            }
            $message = ['msg' => 'Data Deleted Successfully', 'title' => 'Delete'];
        } catch (\Exception $e) {

            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function pathologyTestWiseAttrEntryExamList(Request $request)
    {
        $query = DB::table('sysc_serviceitem_vw');

        if (!empty($request->exam_type)) {
            $query->whereItemType($request->exam_type);
        }

        if (!empty($request->exam_id)) {
            $query->whereItemCode($request->exam_id);
        }
        if (!empty($request->exam_name)) {
            $query->whereItemName($request->exam_name);
        }
        if (!empty($request->exam_sample)) {
            $query->whereSamNoFk($request->exam_sample);
        }
        if (!empty($request->exam_department)) {
            $query->whereServiceunitNoFk($request->exam_department);
        }
        if (!empty($request->exam_template)) {
            $query->whereTestTempNoFk($request->exam_template);
        }
        if (isset($request->inlineRadioOptions)) {
            if ($request->inlineRadioOptions == 'active') {
                $query->whereStatus(1);
            } elseif ($request->inlineRadioOptions == 'inactive') {
                $query->whereStatus(0);
            }
        }
        $examList = $query->get()->toArray();
        return Template::loadview("admin.pathology.pathology_test_wise_attr_entry_exam_list", [
            'examList' => $examList
        ]);
    }
    //    Pta autocomplete
    public function ptaItemAutocomplete(Request $request)
    {
        return response()->json($this->getItemListAutoComplete($request->search_data, $request->item_type));
    }
    public function attrReportPdf($id)
    {
        $item_no_pk = $id;

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $item_wise_attr = DB::select("select teststruct_no_pk,teststruct_code,item_no_fk,sl_no,attr,unit,default_value,test_group_pk_no,default_value1,default_value2,default_value3,group_seq,val_formula,val_nof,res_frm_sam,show_ind,hide_permanent,graph_ind,test_group_id,status,item_code,item_name,single_test_ind,sam_name,container_name,serviceunit_name,temp_name
            from labs_teststructure_vw  where item_no_fk =  $item_no_pk order by sl_no asc");


        $attr_list = [];
        if (!empty($item_wise_attr)) {
            foreach ($item_wise_attr as $attr_data) {
                $attr_list[$attr_data->item_name . "_" . $attr_data->item_no_fk . "_" . $attr_data->item_code . "_" . $attr_data->sam_name . "_" . $attr_data->container_name . "_" . $attr_data->temp_name . "_" . $attr_data->single_test_ind . "_" . $attr_data->serviceunit_name] = $item_wise_attr;
            }
        }


        $from_date = date('d/m/Y');
        $title = "Test Attribute Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.pathology.attr_name_list_print", ['barcode_no' => $barcode_no, 'attr_list' => $attr_list, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrait');
        return $pdf->download('item_wise_attr.pdf');
        // dd($request->item_no);
    }

    public function itemWiseAttrReportPdf(Request $request)
    {

        $query = DB::table('labs_teststructure_vw')->select('teststruct_no_pk', 'teststruct_code', 'item_no_fk', 'sl_no', 'attr', 'unit', 'default_value', 'test_group_pk_no', 'default_value1', 'default_value2', 'default_value3', 'group_seq', 'val_formula', 'val_nof', 'res_frm_sam', 'show_ind', 'hide_permanent', 'graph_ind', 'test_group_id', 'status', 'item_code', 'item_name', 'single_test_ind', 'sam_name', 'container_name', 'serviceunit_name', 'temp_name',);

        if (!empty($request->exam_type)) {
            $query->where('item_type', $request->exam_type);
        }

        if (!empty($request->exam_id)) {
            $query->where('item_code', $request->exam_id);
        }
        if (!empty($request->exam_name)) {
            $query->where('item_name', $request->exam_name);
        }
        if (!empty($request->exam_sample)) {
            $query->where('sam_no_pk', $request->exam_sample);
        }
        if (!empty($request->exam_department)) {
            $query->where('serviceunit_no_pk', $request->exam_department);
        }
        if (!empty($request->exam_template)) {
            $query->where('test_temp_no_pk', $request->exam_template);
        }
        if (isset($request->inlineRadioOptions)) {
            if ($request->inlineRadioOptions == 'active') {
                $query->where('su_status', 1);
            } elseif ($request->inlineRadioOptions == 'inactive') {
                $query->where('su_status', 0);
            }
        }
        $item_wise_attr = $query->groupBy('item_name', 'item_no_fk', 'teststruct_no_pk', 'teststruct_code', 'sl_no', 'attr', 'unit', 'default_value', 'test_group_pk_no', 'default_value1', 'default_value2', 'default_value3', 'group_seq', 'val_formula', 'val_nof', 'res_frm_sam', 'show_ind', 'hide_permanent', 'graph_ind', 'test_group_id', 'status', 'item_code', 'single_test_ind', 'sam_name', 'container_name', 'serviceunit_name', 'temp_name', 'sl_no')->orderBy('item_name', 'asc')->get()->toArray();
        $attr_list = [];
        if (!empty($item_wise_attr)) {
            foreach ($item_wise_attr as $attr_data) {

                $attr_list[$attr_data->item_name . "_" . $attr_data->item_no_fk . "_" . $attr_data->item_code . "_" . $attr_data->sam_name . "_" . $attr_data->container_name . "_" . $attr_data->temp_name . "_" . $attr_data->single_test_ind . "_" . $attr_data->serviceunit_name][] = $attr_data;

                // $attr_data->item_no_fk."_".$attr_data->item_code."_".$attr_data->item_name."_".$attr_data->sam_name."_".$attr_data->container_name."_".$attr_data->temp_name."_".$attr_data->single_test_ind."_".$attr_data->serviceunit_name
            }
        }
        // dd($attr_list);

        // return Template::loadview("admin.pathology.pathology_test_wise_attr_entry_exam_list", [
        //     'examList' => $examList
        // ]);



        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // $item_wise_attr = DB::select("select teststruct_no_pk,teststruct_code,item_no_fk,sl_no,attr,unit,default_value,test_group_pk_no,default_value1,default_value2,default_value3,group_seq,val_formula,val_nof,res_frm_sam,show_ind,hide_permanent,graph_ind,test_group_id,status,item_code,item_name,single_test_ind,sam_name,container_name,serviceunit_name,temp_name
        //     from labs_teststructure_vw  where item_no_fk =  $item_no_pk order by item_name");


        // $attr_list = [];
        // if (!empty($item_wise_attr)) {
        //     foreach ($item_wise_attr as $attr_data) {
        //         $attr_list[$attr_data->item_no_fk."_".$attr_data->item_code."_".$attr_data->item_name."_".$attr_data->sam_name."_".$attr_data->container_name."_".$attr_data->temp_name."_".$attr_data->single_test_ind."_".$attr_data->serviceunit_name] = $item_wise_attr;
        //     }
        // }


        $from_date = date('d/m/Y');
        $title = "Test Attribute Report";
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();

        $pdf = PDF::loadView("admin.pathology.attr_name_list_print", ['barcode_no' => $barcode_no, 'attr_list' => $attr_list, 'po_hospital_details' => $po_hospital_details])->setPaper('a4', 'portrait');
        return $pdf->download('item_wise_attr.pdf');
        // dd($request->item_no);
    }


    public function PatPrintForm($id)
    {
        $print_id = $id;
        return Template::loadView('admin.pathology.process.print_form', ['print_id' => $print_id]);
    }

    public function skipVerify(Request $request)
    {
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        \Illuminate\Support\Facades\DB::beginTransaction();
        try {

            $report_data = [
                'result_verify_key_ind' => 1,
                'result_verify_keyed_by' => $auth_id,
                'result_verify_keyed_time' => date("y-m-d"),
                'result_final_key_ind' => 1,
                'result_final_keyed_by' => $auth_id,
                'result_final_keyed_time' => date("y-m-d"),
                'au_entry_hospital_pk_no' => $ses_hospital_id
            ];
            $invoice_data = [
                'lab_result_verify_key_ind' => 1,
                'lab_result_verify_keyed_by' => $auth_id,
                'lab_result_verify_keyed_time' => date("Y-m-d"),
                'lab_result_final_key_ind' => 1,
                'lab_result_final_keyed_by' => $auth_id,
                'lab_result_final_keyed_time' => date("Y-m-d"),
                'au_entry_hospital_pk_no' => $ses_hospital_id
            ];


            Db::table("labt_testreporting")->where("report_no_pk", $request->hid_value)->update($report_data);
            LabInvoiceDtl::where("report_no_fk", $request->hid_value)->update($invoice_data);


            DB::commit();
            $message = ['msg' => 'Data saved successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // dd($data);
        return response()->json($message);
    }
    public function printAllBarcode($invoice_id)
    {
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        if ($po_hospital_details->hospital_code == 'DMHL') {
            $label_info = DB::table('labt_samplecoll_label_vw')
                ->select('item_code_list', 'lab_code', 'invoice_code', 'test_short_name_list', 'serviceunit_name', 'patient_name', 'patient_code', 'age', 'gender', 'sc_sample_coll_keyed_time', 'coll_seq', 'dob', 'invoice_date', 'lab_daily_serial_no', DB::raw("(INVOICE_CODE) as INVOICE_CODE_SL"))
                ->where('invoice_code', $invoice_id)
                ->get();
        } else {
            $label_info = DB::table('labt_samplecoll_label_vw')
                ->select('item_code_list', 'lab_code', 'invoice_code', 'test_short_name_list', 'serviceunit_name', 'patient_name', 'patient_code', 'age', 'gender', 'sc_sample_coll_keyed_time', 'coll_seq', 'dob', 'invoice_date', 'lab_daily_serial_no', DB::raw("(INVOICE_CODE || '/' || lab_daily_serial_no) as INVOICE_CODE_SL"))
                ->where('invoice_code', $invoice_id)
                ->get();
        }


        $label = [];
        if (!empty($label_info)) {
            foreach ($label_info as $lab) {
                $barcode = new BarcodeGenerator();
                $barcode->setText($lab->lab_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(8);
                $lab->barcode = $barcode->generate();
            }
        }

        $data = [];
        $data = ['barcode' => $label_info];

        if ($po_hospital_details->hospital_code == 'DIGILAB') {
            $pdf = PDF::loadView("admin.pathology.sample_print_all_digilab", $data);
            return $pdf->stream("allBarCode.pdf");
        } else {
            $pdf = PDF::loadView("admin.pathology.sample_print_all", $data);
            return $pdf->stream("allBarCode.pdf");
        }
    }

    public function receiveAllItem(Request $request, $lab_id)
    {
        // dd($lab_id);
        $id = $request->id;
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {
            $lab_id = $request->lab_id;
            $data = [
                'lab_rcv_from_sp_key_ind' => 1,
                'lab_rcv_from_sp_keyed_by' => $auth_id,
                'lab_rcv_from_sp_keyed_time' => date("Y-m-d")
            ];
            echo $lab_id;

            LabInvoiceDtl::where("lab_no_fk", $lab_id)->update($data);
            SampleCollection::where("lab_no_pk", $lab_id)->update($data);

            DB::commit();
            $message = ['msg' => 'Sample Receive completed Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }


    public function reportPrintValidate(Request $request)
    {

        $result = DB::selectOne("select pkg_billing.fnc_get_paystatus($request->invoice_id) as value from dual");

        // return $result->value; // prints 6
        // if ($result->value =="PASS") {
        //     return response()->json($result->value);
        // }else{

        // }
        return response()->json($result->value);
        // dd($result->value);

    }



    public function resultEntryFormColumn2($report_id, $type = 1, $lab_id = '')
    {
        $hospital_id =   Session::get('user.ses_hospital_no_pk');
        $patient_info = [];
        $result_info = DB::table("labt_testreporting_wl_vw as lab")
            ->select(
                "lab.invoice_no_fk",
                "lab.invoice_code",
                "lab.item_no_fk",
                "lab.sam_name as sam_name",
                "lab.su_no_fk",
                "lab.serviceunit_name",
                "lab.report_uid",
                "lab.interpretation",
                "lab.comments_text",
                "lab.note_text",
                "lab.result_prepared_keyed_by",
                "lab.result_verify_keyed_by",
                "lab.result_final_keyed_by",
                "lab.result_ent_keyed_by",
                "lab.report_no_pk",
                "lab.analyzer_desc"
            )
            ->leftjoin('sysc_serviceitem_vw as ser', 'lab.item_no_fk', 'ser.item_no_pk')
            // ->where('lab.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("lab.report_no_pk", $report_id)

            ->first();
        // dd($result_info);

        if (!empty($result_info)) {
            $prescription_id = $result_info->invoice_no_fk;

            $patient_info = DB::table("labt_invoicedtl_vw a")
                ->select("b.patient_name", "b.patient_code", "a.doctor_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "b.pat_relation", "b.ref_patient_gender", "b.ref_blood_group", "b.ref_age", "b.blood_group_txt", "b.mobile1", DB::raw('pat_age(b.dob,nvl(dod,sysdate))pat_age'))
                ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                ->where("a.invoice_no_fk", $prescription_id)->first();
        }

        // $result_test_info = DB::table("labt_testresultstruct_vw")->where("report_no_fk", $report_id)->orderBy('sl_no', 'ASC')->get()->toArray();
        $result_test_info = DB::select(DB::raw("select lab.show_in_rep,
        lab.group_txt,
        lab.attr,
        lab.teststruct_no_fk,
        lab.result0,lab.default_ind,lab.machine_attrib,lab.testresult_no_pk,lab.unit,lab.referencevalue,lab.result_final_key_ind,lab.delivery_status_no  from labt_testresultstruct_vw lab
                                                    left join sysc_serviceitem_vw sys
                                                    on lab.item_no_fk = sys.item_no_pk
                                                    where lab.report_no_fk = $report_id
                                                    and lab.au_entry_hospital_pk_no = $hospital_id
                                                    and lab.cancel_ind is null order by lab.item_name Asc,sl_no ASC"));
        $result_item = DB::select(DB::raw("select test_name_list from labt_samplelabrcv_wl_vw where lab_uid = $lab_id
        and au_entry_hospital_pk_no = $hospital_id  and cancel_ind is null"));

        // $prepared_by = $this->getPathologyResultEntryByUser("save_ind");
        // $verified_by = $this->getPathologyResultEntryByUser("verify_ind");
        // $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind");

        $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind", $result_info->su_no_fk);
        $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind", $result_info->su_no_fk);
        $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind", $result_info->su_no_fk);
        $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind", $result_info->su_no_fk);
        $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind", $result_info->su_no_fk);


        $analyzer = DB::table('sysc_serviceitem')->select('item_code', 'item_name', 'interpretation')->where('analyzer_ind', 1)->get();

        $default_values = DB::table('labs_teststructval')->select('teststruct_no_fk', 'test_result')->where('status', 1)->orderBy('sl_no', 'asc')->get();
        // dd($default_values);
        return Template::loadview("admin.pathology.result_entry_form_2column", ["report_id" => $report_id, "result_info" => $result_info, "patient_info" => $patient_info, "result_test_info" => $result_test_info, "prepared_by_columns" => $prepared_by, "verified_by_columns" => $verified_by, "finalize_by_columns" => $finalize_by, "type" => $type, 'result_item' => $result_item, 'lab_id' => $lab_id, 'analyzer' => $analyzer, 'default_values' => $default_values, 'consult' => $consult, 'consult2' => $consult2]);
    }
    public function medicalExaminationReport($report_id, $type = 1, $lab_id = '')
    {
        $hospital_id =   Session::get('user.ses_hospital_no_pk');
        $patient_info = [];
        $result_info = DB::table("labt_testreporting_wl_vw")->where("report_no_pk", $report_id)->first();
        if (!empty($result_info)) {
            $prescription_id = $result_info->invoice_no_fk;

            $patient_info = DB::table("labt_invoicedtl_vw a")
                ->select("b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "b.pat_relation", "b.ref_patient_gender", "b.ref_blood_group", "b.ref_age", "b.blood_group_txt", "b.mobile1")
                ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                ->where("a.invoice_no_fk", $prescription_id)->first();
        }

        $result_test_info = DB::table("labt_testresultstruct_vw")->where("report_no_fk", $report_id)->orderBy('sl_no', 'ASC')->get()->toArray();

        $result_item = DB::select(DB::raw("select test_name_list from labt_samplelabrcv_wl_vw where lab_uid = $lab_id
        and au_entry_hospital_pk_no = $hospital_id  and cancel_ind is null"));

        // $prepared_by = $this->getPathologyResultEntryByUser("save_ind");
        // $verified_by = $this->getPathologyResultEntryByUser("verify_ind");
        // $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind");
        $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind", $result_info->su_no_fk);
        $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind", $result_info->su_no_fk);
        $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind", $result_info->su_no_fk);
        $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind", $result_info->su_no_fk);
        $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind", $result_info->su_no_fk);


        $analyzer = DB::table('sysc_serviceitem')->select('item_code', 'item_name', 'interpretation')->where('analyzer_ind', 1)->get();

        $default_values = DB::table('labs_teststructval')->where('status', 1)->orderBy('sl_no', 'asc')->get();
        // dd($default_values);
        return Template::loadview("admin.pathology.medical_examination_report", ["report_id" => $report_id, "result_info" => $result_info, "patient_info" => $patient_info, "result_test_info" => $result_test_info, "prepared_by_columns" => $prepared_by, "verified_by_columns" => $verified_by, "finalize_by_columns" => $finalize_by, "type" => $type, 'result_item' => $result_item, 'lab_id' => $lab_id, 'analyzer' => $analyzer, 'default_values' => $default_values, 'consult' => $consult, 'consult2' => $consult2]);
    }
    public function resultEntryPdfColumn2($report_id,$draft="",$type="")
    {
        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        try {
            $report_header = DB::table("labt_testreportresultprint_vw")->where('report_no_pk', $report_id)->first();
            // dd($report_header);
            $result_prepared_by = Auth::id();
            $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
            $invoice_data = [
                'lab_result_print_key_ind' => 1,
                'lab_result_print_keyed_by' => $result_prepared_by,
                'lab_result_print_keyed_time' => date("Y-m-d"),
                'au_update_hospital_pk_no' => $ses_hospital_id,
            ];
            LabInvoiceDtl::where("report_no_fk", $report_id)->update($invoice_data);

            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {

                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }

            $report_data = DB::table("labt_testresultstruct_vw")
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->get()->toArray();
            $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->first();
            $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';


            $attr_group = [];
            foreach ($report_data as $value) {
                $attr_group[$value->item_no_fk . '|' . $value->item_name . '`' . $value->item_code][$value->test_group_no_fk . '|' . $value->group_txt][] = $value;
            }

            $po_hospital_details = DB::table("wsec_hospital")->first();
            if (Session::get('user.ses_hospital_code') == "UNICO") {
                $pdf = PDF::loadView("admin.pathology.reports.biochemistry_report_col_2_v2", [
                    "report_label" => $report_label,
                    "po_hospital_details" => $po_hospital_details,
                    "report_varcode" => $report_varcode,
                    "invoice_varcode" => $invoice_varcode,
                    'patient_varcode' => $patient_varcode,
                    "report_header" => $report_header,
                    "report_data" => $report_data,
                    'attr_group' => $attr_group,
                    'draft' => $draft,
                ])->setPaper('Letter', 'portrait');
            } else {
                return View("admin.pathology.reports.biochemistry_report_col_2", [
                    "report_label" => $report_label,
                    "po_hospital_details" => $po_hospital_details,
                    "report_varcode" => $report_varcode,
                    "invoice_varcode" => $invoice_varcode,
                    'patient_varcode' => $patient_varcode,
                    "report_header" => $report_header,
                    "report_data" => $report_data,
                    'attr_group' => $attr_group,
                    'draft' => $draft,
                ]);

                // ->setPaper('Letter', 'portrait');
            }

            if ($type == 1) {
                $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
            }

        } catch (\Exception $e) {
            DB::rollback();
            // $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return $pdf->stream("BC-$report_id.pdf");
    }
    public function resultEntryStoolPdfColumn2($report_id,$draft="",$type="")
    {
        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        try {

            $report_header = DB::table("labt_testreportresultprint_vw")->where('report_no_pk', $report_id)->first();
            // dd($report_header);
            $result_prepared_by = Auth::id();
            $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
            $invoice_data = [
                'lab_result_print_key_ind' => 1,
                'lab_result_print_keyed_by' => $result_prepared_by,
                'lab_result_print_keyed_time' => date("Y-m-d"),
                'au_update_hospital_pk_no' => $ses_hospital_id,
            ];
            LabInvoiceDtl::where("report_no_fk", $report_id)->update($invoice_data);

            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {

                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }

            $report_data = DB::table("labt_testresultstruct_vw")
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->get()->toArray();


            $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->first();
            $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';


            $attr_group = [];
            $attr_group2 = [];
            foreach ($report_data as $value) {
                $attr_group[$value->item_no_fk . '-' . $value->item_name . '`' . $value->item_code][$value->test_group_no_fk . '-' . $value->group_txt][] = $value;
                $attr_group2[$value->item_no_fk . '-' . $value->item_name . '`' . $value->item_code][$value->test_group_no_fk . '-' . $value->group_txt][] = $value;
            }

            $po_hospital_details = DB::table("wsec_hospital")->first();

            // $pdf = PDF::loadView("admin.pathology.reports.biochemistry_report_stool_col_2",[
            return view("admin.pathology.reports.biochemistry_report_stool_col_2", [
                "report_label" => $report_label,
                "po_hospital_details" => $po_hospital_details,
                "report_varcode" => $report_varcode,
                "invoice_varcode" => $invoice_varcode,
                'patient_varcode' => $patient_varcode,
                "report_header" => $report_header,
                "report_data" => $report_data,
                'attr_group' => $attr_group,
                'attr_group2' => $attr_group2,
                'draft' => $draft,
            ]);

            if ($type==1) {
                $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
            }

        } catch (\Exception $e) {
            DB::rollback();
            // $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return $pdf->stream("BC-$report_id.pdf");
    }
    public function resultEntryPdfPBFColumn2($report_id,$draft="",$type="")
    {
        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        try {



            $report_header = DB::table("labt_testreportresultprint_vw")->where('report_no_pk', $report_id)->first();

            $result_prepared_by = Auth::id();
            $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
            $invoice_data = [
                'lab_result_print_key_ind' => 1,
                'lab_result_print_keyed_by' => $result_prepared_by,
                'lab_result_print_keyed_time' => date("Y-m-d"),
                'au_update_hospital_pk_no' => $ses_hospital_id,
            ];
            LabInvoiceDtl::where("report_no_fk", $report_id)->update($invoice_data);

            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {

                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }

            $report_data = DB::table("labt_testresultstruct_vw")
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->get()->toArray();
            $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->first();
            $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';

            //    dd($report_header);

            $attr_group = [];
            foreach ($report_data as $value) {
                $attr_group[$value->item_no_fk . '-' . $value->item_name . '`' . $value->item_code][$value->test_group_no_fk . '-' . $value->group_txt][] = $value;
            }
            // dd($attr_group);
            $po_hospital_details = DB::table("wsec_hospital")->first();
            if (Session::get('user.ses_hospital_code')=='UNICO') {
                $pdf = PDF::loadView("admin.pathology.reports.biochemistry_report_col_2_pbf_v2", ["report_label" => $report_label, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'attr_group' => $attr_group,'draft'=>$draft]);
            }else{
                $pdf = PDF::loadView("admin.pathology.reports.biochemistry_report_col_2_pbf", ["report_label" => $report_label, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'attr_group' => $attr_group,'draft'=>$draft]);
            }

            if ($type==1) {
                $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
            }


        } catch (\Exception $e) {
            DB::rollback();
            // $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            dd($e);
        }
        return $pdf->stream("BC-$report_id.pdf");
    }

    public function specialReport($report_id,$draft="",$type="")
    {
        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        try {
            $report_header = DB::table("labt_testreportresultprint_vw")->where('report_no_pk', $report_id)->first();
            $result_prepared_by = Auth::id();
            $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
            $invoice_data = [
                'lab_result_print_key_ind' => 1,
                'lab_result_print_keyed_by' => $result_prepared_by,
                'lab_result_print_keyed_time' => date("Y-m-d"),
                'au_update_hospital_pk_no' => $ses_hospital_id,
            ];
            LabInvoiceDtl::where("report_no_fk", $report_id)->update($invoice_data);

            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {

                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }

            $report_data = DB::table("labt_testresultstruct_vw")
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->skip(0)->take(19)->get()->toArray();

            $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->first();
            $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';


            $report_data_last = DB::table("labt_testresultstruct_vw")
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->skip(19)->take(38)->get()->toArray();

            $report_data_last_gmc = DB::table("labt_testresultstruct_vw")
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->get()->toArray();


            $attr_group = [];
            foreach ($report_data as $value) {
                $attr_group[$value->test_group_no_fk . '_' . $value->group_txt][] = $value;
            }



            $attr_group_last = [];
            foreach ($report_data_last as $value_last) {
                $attr_group_last[$value_last->test_group_no_fk . '_' . $value_last->group_txt][] = $value_last;
            }
            $attr_group_last_gmc = [];
            foreach ($report_data_last_gmc as $value_last) {
                $attr_group_last_gmc[$value_last->test_group_no_fk . '_' . $value_last->group_txt][] = $value_last;
            }


            $po_hospital_details = DB::table("wsec_hospital")->first();

            // $pdf = PDF::loadView("admin.pathology.urine_report_pdf", ["po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'attr_group' => $attr_group, 'report_data_last' => $report_data_last, 'attr_group_last' => $attr_group_last]);

            return view("admin.pathology.urine_report_pdf", ["report_label" => $report_label, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'attr_group' => $attr_group, 'report_data_last' => $report_data_last, 'attr_group_last' => $attr_group_last, 'attr_group_last_gmc' => $attr_group_last_gmc,'draft'=>$draft]);

            if ($type==1) {
                $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
            }

        } catch (\Exception $e) {
            DB::rollback();
            // $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return $pdf->stream("BC-$report_id.pdf");
    }

    public function specialReportCbc($report_id = "",$draft="",$type="")
    {
        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        try {
            $report_header = DB::table("labt_testreportresultprint_vw")->where('report_no_pk', $report_id)->first();
            // dd($report_header);
            $po_hospital_details = DB::table("wsec_hospital")->first();

            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {

                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }


            $data = DB::table("labt_testresultstruct_vw")->select('item_no_fk', 'item_name')->where('report_no_fk', $report_id)->where('show_in_rep', 1)->groupBy('item_no_fk', 'item_name')->get()->toArray();

            $report_data = DB::table("labt_testresultstruct_vw")
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->get()
                ->toArray();
            $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->first();
            $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';

            $attr_group = [];
            foreach ($report_data as $value) {
                $attr_group[$value->test_group_no_fk . '-' . $value->group_txt][] = $value;
            }
            if ($type==1) {
                 $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);

            }


            // $pdf = PDF::loadView("admin.pathology.reports.biochemestry_report", ["prescription_barcode" => $prescription_barcode, "lbauid_barcode" => $lbauid_barcode, "report_header" => $report_header, 'po_hospital_details' => $po_hospital_details, 'data' => $data, "report_data" => $report_data, 'attr_group' => $attr_group]);


            $html = view('admin.pathology.reports.biochemistry_report_cbc', [
                "report_label" => $report_label,
                "report_varcode" => $report_varcode,
                "invoice_varcode" => $invoice_varcode,
                'patient_varcode' => $patient_varcode,
                "report_header" => $report_header,
                'po_hospital_details' => $po_hospital_details,
                'data' => $data,
                "report_data" => $report_data,
                'attr_group' => $attr_group,
                'draft' => $draft,
            ])->render();
        } catch (\Exception $e) {
            DB::rollback();
            // $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // return response()->json($message);
        // return $pdf->stream("BC-$report_id.pdf");
        return @\PDF::loadHTML($html, 'utf-8')->stream();
    }


    public function addAttrValue($id)
    {
        //    dd($id);
        $att_val = DB::table('labs_teststructure')->where('teststruct_no_pk', $id)->first();
        $data = DB::table('labs_teststructval')->where('teststruct_no_fk', $id)->orderBy('sl_no', 'ASC')->get();

        return Template::loadview("admin.pathology.def_att_value", ['id' => $id, 'att_val' => $att_val, 'data' => $data]);
    }

    public function storeDefaultValue(Request $request)
    {

        // dd($request->all());
        $id = $request->id;
        $auth_id = Auth::id();


        DB::beginTransaction();
        try {

            $test_result = $request->test_result;
            $arry_val = array_filter($request->def_value);
            // $arry_val = array_fill_keys(array_keys(array_filter($request->def_value)),0);
            $arry_test = array_values(array_filter($test_result));

            //  dd( $request->item_id,$request->id);
            DB::table('labs_teststructval')->where('teststruct_no_fk', $request->id)->delete();
            $result_txt = [];
            $defult_ind = [];
            $sl_no = [];
            $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            for ($i = 0; $i < count($arry_val); $i++) {
                $item_id = explode('`', $arry_val[$i]);
                $result_txt[$i] = $item_id[2];

                $defult_ind[$i] = 1;

                $data = [
                    'test_result' =>  $result_txt[$i],
                    'default_ind' =>  $defult_ind[$i],
                    'status' =>  $defult_ind[$i],
                    'au_entry_by' =>  Auth::id(),
                    // 'au_entry_at' => date('Y-m-d'),
                    'au_entry_session' =>  'session',
                    'au_entry_hospital_pk_no' =>  $ses_hospital_id,
                    'teststruct_no_fk' =>  $item_id[1],
                    'item_no_fk' =>  $item_id[0],
                    'sl_no' =>  $item_id[3],
                ];
                $this->DefaultAttributeValueList->create($data);
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

    public function resultEntryFormMic($report_id, $type = 1, $lab_id)
    {

        $patient_info = [];
        $result_info_0 = DB::table("labt_testreporting_wl_vw")
            ->select('invoice_no_fk')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("report_no_pk", $report_id)
            ->whereNull('cancel_ind')
            ->first();


        if (!empty($result_info_0)) {
            $prescription_id = $result_info_0->invoice_no_fk;

            $patient_info = DB::table("labt_invoicedtl_vw a")
                ->select("a.doctor_name", "b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "b.pat_relation", "b.ref_patient_gender", "b.ref_blood_group", "b.ref_age", "b.blood_group_txt", "b.mobile1", DB::raw('pat_age(b.dob,nvl(dod,sysdate))pat_age'))
                ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where("a.invoice_no_fk", $prescription_id)->first();
        }
        $hospital_id =   Session::get('user.ses_hospital_no_pk');
        $result_test_infos = DB::table('microbiology_antibiotic')->where('status', 1);
        if (Session::get('user.ses_hospital_code')=="UNICO") {
             $result_test_info=  $result_test_infos->orderBy('microbiology_name', 'asc')->get();
        }else{
             $result_test_info=  $result_test_infos->orderBy('microbiology_no_pk', 'asc')->get();
        }


        $labt_testresultstruct = DB::table('labt_testresultstruct_vw')->where('report_no_fk', $report_id)->get();
        // dd($result_test_info);

        $result_info = DB::table("labt_testreporting_wl_vw as lab")
            ->select(
                "lab.invoice_code",
                "lab.item_no_fk",
                "lab.sam_name as sam_name",
                "lab.su_no_fk",
                "lab.serviceunit_name",
                "lab.report_uid",
                "lab.interpretation",
                "lab.comments_text",
                "lab.note_text",
                "lab.result_prepared_keyed_by",
                "lab.result_verify_keyed_by",
                "lab.result_final_keyed_by",
                "lab.result_ent_keyed_by",
                "lab.report_no_pk",
                "lab.analyzer_desc",
                "lab.invoice_no_fk",
                "lab.lab_code",
            )
            ->leftjoin('sysc_serviceitem_vw as ser', 'lab.item_no_fk', 'ser.item_no_pk')
            // ->where('lab.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("lab.report_no_pk", $report_id)
            ->first();

        $result_info_1 = DB::table("labt_testreporting_wl_vw as lab")
            ->select(
                "lab.item_no_fk",
                "lab.sam_name as sam_name",
                "lab.serviceunit_name",
                "lab.report_uid",
                "lab.interpretation",
                "lab.comments_text",
                "lab.note_text",
                "lab.result_prepared_keyed_by",
                "lab.result_verify_keyed_by",
                "lab.result_final_keyed_by",
                "lab.result_ent_keyed_by",
                "lab.report_no_pk",
                "lab.analyzer_desc",
                "lab.invoice_no_fk",
                "lab.organism_a",
                "lab.organism_b",
                "lab.organism_a_u",
                "lab.organism_b_u",
                "lab.organism_c",
                "lab.organism_c_u",
                "lab.incubation_temp",
                "lab.incubation_condition",
                "lab.colony_count",
                "lab.colony_count_a",
                "lab.colony_count_b",
                "lab.incubation_time",
                'lab.test_method',
                'lab.gram_stain_smear',
                'lab.epithelialv',
                'lab.biochemical_test',
                'lab.identity_mark',
                'lab.pus_cells',
                'lab.rbc',
                'lab.structure',
                'lab.microscope_examination',
                'lab.sensitivity',
                'lab.colony_pattern'
            )
            ->leftjoin('sysc_serviceitem_vw as ser', 'lab.item_no_fk', 'ser.item_no_pk')
            // ->where('lab.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("lab.report_no_pk", $report_id)
            ->first();

        // dd($result_info_1);


        $rs_dt = DB::select(DB::raw("select lab.*,sys.* from labt_testresultstruct_vw lab
            left join sysc_serviceitem_vw sys
            on lab.item_no_fk = sys.item_no_pk
            where lab.report_no_fk = $report_id
            and lab.au_entry_hospital_pk_no = $hospital_id
            and lab.cancel_ind is null order by lab.item_name Asc,sl_no ASC"));

        $result_item = DB::select(DB::raw("select test_name_list from labt_samplelabrcv_wl_vw where lab_uid = $lab_id
                and au_entry_hospital_pk_no = $hospital_id  and cancel_ind is null"));


        $analyzer = DB::table('sysc_serviceitem')->select('item_code', 'item_name', 'interpretation')->where('analyzer_ind', 1)->get();




        $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind", $result_info->su_no_fk);
        $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind", $result_info->su_no_fk);
        $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind", $result_info->su_no_fk);
        $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind", $result_info->su_no_fk);
        $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind", $result_info->su_no_fk);
        // dd($consult);


        $incubationtime = $this->getLookupListByCode("INCUBATIONTIME");
        $incubationtemp = $this->getLookupListByCode("INCUBATIONTEMP");
        $incubationcolonycount = $this->getLookupListByCode("INCUBATIONCOLONYCOUNT");
        $incubationcond = $this->getLookupListByCode("INCUBATIONCOND");
        $rbc = $this->getLookupListByCode("RBC");


        $antivitic = DB::table("microbiology_antibiotic")->where('status', 1)->orderBy('microbiology_no_pk', 'asc')->get();
        $becteria = DB::table("microbiology_bacteria")->where('status', 1)->get();

        // FOR gmc
        $microscope = $this->getLookupListByCode("MICROSCOPEEXAMINATION");
        $gramstain = $this->getLookupListByCode("GRAMSTAIN");
        $sensityvity = $this->getLookupListByCode("SENSITYVITY");
        $biochemical_test = $this->getLookupListByCode("BIOCHEMICALTEST");
        $colonypattern = $this->getLookupListByCode("COLONYPATTERN");

        return Template::loadview("admin.pathology.result_entry_form_mic", [
            "report_id" => $report_id,
            "result_info" => $result_info,
            "rs_dt" => $rs_dt,
            "result_info_1" => $result_info_1,
            "patient_info" => $patient_info,
            "result_test_info" => $result_test_info,
            "prepared_by_columns" => $prepared_by,
            "verified_by_columns" => $verified_by,
            "finalize_by_columns" => $finalize_by,
            "type" => $type,
            "result_item" => $result_item,
            'lab_id' => $lab_id,
            'analyzer' => $analyzer,
            "incubationtime" => $incubationtime,
            "incubationtemp" => $incubationtemp,
            "incubationcolonycount" => $incubationcolonycount,
            "incubationcond" => $incubationcond,
            "antivitic" => $antivitic,
            "becteria" => $becteria,
            "microscope" => $microscope,
            "gramstain" => $gramstain,
            "sensityvity" => $sensityvity,
            "rbc" => $rbc,
            "biochemical_test" => $biochemical_test,
            "consult" => $consult,
            "consult2" => $consult2,
            "labt_testresultstruct" => $labt_testresultstruct,
            "colonypattern" => $colonypattern,

        ]);
    }



    public function storeResultEntryMic(Request $request)
    {
        $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();
        //dd($request->all());
        $dt = new DateTime('now', new \DateTimeZone('Asia/Dhaka'));
        $date = $dt->format('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            $result_note        = $request->result_note;
            $result_comm        = $request->result_comm;
            $hdn_report_id      = $request->hdn_report_id;
            $hdn_invoice_id      = $request->hdn_invoice_id;
            $hdn_item_id      = $request->hdn_item_id;
            $result_prepared_by   = $request->result_prepared_by;
            $result_verified_by   = $request->result_verified_by;
            $result_finalize_by   = $request->result_finalize_by;

            $orgnsm_name_1   = $request->orgnsm_name_1;
            $orgnsm_name_2   = $request->orgnsm_name_2;
            $orgnsm_name_3   = $request->orgnsm_name_3;
            $orgnsm_name_4   = $request->orgnsm_name_4;
            $incu_temp   = $request->incu_temp;
            $incu_time   = $request->incu_time;
            $incu_cond   = $request->incu_cond;
            $colony_count   = $request->colony_count_a;
            $colony_countA   = $request->colony_count_b;
            $colony_count_B   = $request->colony_count_c;
            $colony_pattern   = $request->colony_pattern;

            $testresult_no_pk   = $request->testresult_no_pk;
            $testresult_value   = $request->testresult_value;
            $result             = $request->result;
            $show_in_rep        = $request->show_in_rep;

            // for GMC
            $mic_data   = $request->mic_data;
            $grm_stain   = $request->grm_stain;
            $sensitivity   = $request->sensitivity;
            $bio_test   = $request->bio_test;
            $rbc   = $request->rbc;
            $epithelial   = $request->epithelial;
            $pus_cells   = $request->pus_cells;
            // End
            //  dd($testresult_no_pk,$testresult_value, $result,$show_in_rep );
            $ids = [];

            DB::table('labt_testresult')->where('report_no_fk', $hdn_report_id)->delete();
            if (!empty($show_in_rep)) {
                for ($i = 0; $i < count($show_in_rep); $i++) {
                    // dd($show_in_rep_val)
                    $result_data = $show_in_rep[$i];
                    $sequence = DB::getSequence();
                    $testresult_no_pk_seq = $sequence->nextValue('testresult_no_pk_seq');
                    $show_in_rep_val = 0;
                    //$ss = 'show_in_rep_' . $testresult_no_pk[$i];

                    $reuslt_entry = DB::table('labt_testresult')->where('report_no_fk', $hdn_report_id)->where('teststruct_no_fk', $result_data)->first();
                    $id = isset($reuslt_entry->teststruct_no_fk) && !empty($reuslt_entry->teststruct_no_fk) ? $reuslt_entry->teststruct_no_fk : "";
                    // dd( $reuslt_entry);
                    $result0req = 'result_' . $result_data . '_1';
                    $result1req = 'result_' . $result_data . '_2';
                    $result2req = 'result_' . $result_data . '_3';
                    $attrRequest = 'testresult_value_' . $result_data;
                    $data = [
                        // 'testresult_no_pk' => $testresult_no_pk_seq,
                        'testresult_code' => 'R' . ($testresult_no_pk_seq + 1), //'R'.$testresult_no_pk_seq
                        'report_no_fk' => $hdn_report_id,
                        'item_no_fk' => $hdn_item_id,
                        'invoice_no_fk' => $hdn_invoice_id,
                        'au_entry_hospital_pk_no' => $ses_hospital_id,
                        'au_entry_session' => $ses_hospital_id,
                        // 'au_entry_at' => date("Y-m-d"),
                        // 'au_entry_by' => $auth_id,
                        'result0'      => isset($request->$result0req) ? $request->$result0req  : '',
                        'result1'     => isset($request->$result1req) ? $request->$result1req : '',
                        'result2'     => isset($request->$result2req) ? $request->$result2req : '',
                        'attr'       => $request->$attrRequest,
                        'teststruct_no_fk' => $result_data,

                        'show_in_rep'   => 1, //isset($show_in_rep[$i]) ? 1 :0

                    ];
                    if ($id == "") {
                        $data['au_entry_by'] =  $auth_id;
                        // $data['au_entry_at'] =date("Y-m-d");
                        $this->labtestresult->create($data);
                        // DB::table('labt_testresult')->insert($data);
                    } else {
                        $data['au_update_by'] = $auth_id;
                        // $data['au_update_at'] = date("Y-m-d");
                        LabTestResult::where('report_no_fk', $hdn_report_id)->where('teststruct_no_fk', $result_data)->update($data);
                    }
                }
                // dd($data);
            }

            if ($request->action_type == "prepare") {
                $report_data = [
                    'result_prepared_key_ind'    => 1,
                    'result_prepared_keyed_by'   => $result_prepared_by,
                    'result_prepared_keyed_time' => new DateTime('now'),
                    'organism_a'               => $orgnsm_name_1,
                    'organism_b'               => $orgnsm_name_2,
                    'organism_c'             => $orgnsm_name_3,
                    // 'organism_b_u'             => $orgnsm_name_4,
                    'incubation_temp'          => $incu_temp,
                    'incubation_time'          => $incu_time,
                    'incubation_condition'     => $incu_cond,
                    'colony_count'             => $colony_count,
                    'colony_count_a'           => $colony_countA,
                    'colony_count_b'           => $colony_count_B,
                    'colony_pattern'           => $colony_pattern,
                    'note_text'                => $result_note,
                    'comments_text'                => $result_comm,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_prepared_key_ind'    => 1,
                    'lab_result_prepared_keyed_by'   => $result_prepared_by,
                    'lab_result_prepared_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no'       => $ses_hospital_id,
                ];

                if (in_array(Session::get('user.ses_hospital_code'), ["DMHL"])) {
                    $report_data['result_verify_key_ind']      = 1;
                    $report_data['result_verify_keyed_by']     = $result_verified_by;
                    $report_data['result_verify_keyed_time']   = new DateTime('now');
                    $report_data['note_text']                  = $result_note;
                    $report_data['au_update_hospital_pk_no']   = $ses_hospital_id;
                    $report_data['incubation_temp']            = $incu_temp;
                    $report_data['incubation_time']            = $incu_time;
                    $report_data['incubation_condition']       = $incu_cond;
                    $report_data['colony_count']               = $colony_count;
                    $report_data['colony_count_a']             = $colony_countA;
                    $report_data['colony_count_b']             = $colony_count_B;
                    $report_data['colony_pattern']             = $colony_pattern;
                    $report_data['note_text']                  = $result_note;
                    $report_data['comments_text']              = $result_comm;

                    $invoice_data['lab_result_verify_key_ind']    = 1;
                    $invoice_data['lab_result_verify_keyed_by']   = $result_verified_by;
                    $invoice_data['lab_result_verify_keyed_time'] = new DateTime('now');
                    $invoice_data['au_update_hospital_pk_no'] = $ses_hospital_id;
                }
            }

            if ($request->action_type == "verifiy") {
                $report_data = [
                    'result_verify_key_ind'      => 1,
                    'result_verify_keyed_by'     => $result_verified_by,
                    'result_verify_keyed_time'   => new DateTime('now'),
                    'organism_a'                 => $orgnsm_name_1,
                    'organism_b'                 => $orgnsm_name_2,
                    'organism_c'               => $orgnsm_name_3,
                    // 'organism_b_u'               => $orgnsm_name_4,
                    'incubation_temp'            => $incu_temp,
                    'incubation_time'            => $incu_time,
                    'incubation_condition'       => $incu_cond,
                    'colony_count'             => $colony_count,
                    'colony_count_a'           => $colony_countA,
                    'colony_count_b'           => $colony_count_B,
                    'colony_pattern'           => $colony_pattern,
                    'note_text'                  => $result_note,
                    'comments_text'                => $result_comm,
                    'au_update_hospital_pk_no'   => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_verify_key_ind'    => 1,
                    'lab_result_verify_keyed_by'   => $result_verified_by,
                    'lab_result_verify_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no'     => $ses_hospital_id,
                ];
            }

            if ($request->action_type == "finalize") {
                $report_data = [
                    'result_final_key_ind'       => 1,
                    'result_final_keyed_by'      => $result_finalize_by,
                    'result_final_keyed_time'    => $date,
                    'organism_a'                 => $orgnsm_name_1,
                    'organism_b'                 => $orgnsm_name_2,
                    'organism_c'               => $orgnsm_name_3,
                    // 'organism_b_u'               => $orgnsm_name_4,
                    'incubation_temp'            => $incu_temp,
                    'incubation_time'            => $incu_time,
                    'incubation_condition'       => $incu_cond,
                    'colony_count'             => $colony_count,
                    'colony_count_a'           => $colony_countA,
                    'colony_count_b'           => $colony_count_B,
                    'colony_pattern'           => $colony_pattern,
                    'note_text'                  => $result_note,
                    'comments_text'                => $result_comm,
                    'au_update_hospital_pk_no'   => $ses_hospital_id,

                    'microscope_examination'     => $mic_data,
                    'gram_stain_smear'           => $grm_stain,
                    'sensitivity'                => $sensitivity,
                    'biochemical_test'           => $bio_test,
                    'rbc'                        => $rbc,
                    'epithelialv'                => $epithelial,
                    'pus_cells'                  => $pus_cells,


                    // TEST_METHOD
                    // GRAM_STAIN_SMEAR
                    // EPITHELIALV
                    // BIOCHEMICAL_TEST
                    // IDENTITY_MARK
                    // PUS_CELLS, RBC
                    // STRUCTURE
                    // microscope_examination
                    // sensitivity




                ];

                if (in_array(Session::get('user.ses_hospital_code'), ["AMCSH"])) {
                    $report_data['result_prepared_key_ind']    = 1;
                    $report_data['result_prepared_keyed_by']   = $result_prepared_by;
                    $report_data['result_prepared_keyed_time'] = new DateTime('now');
                    $report_data['result_verify_key_ind']      = 1;
                    $report_data['result_verify_keyed_by']     = $result_verified_by;
                    $report_data['result_verify_keyed_time']   = new DateTime('now');
                    $report_data['result_ent_key_ind']       = 1;
                    $report_data['result_ent_keyed_by']      = $request->consultant;
                    $report_data['result_ent_keyed_time']    = new DateTime('now');
                    $report_data['result_con_key_ind'] = 1;
                    $report_data['result_con_keyed_by'] = $request->consultant2;
                    $report_data['result_con_keyed_time'] = new DateTime('now');
                }

                $invoice_data = [
                    'lab_result_final_key_ind'    => 1,
                    'lab_result_final_keyed_by'   => $result_finalize_by,
                    'lab_result_final_keyed_time' => $date,
                    'au_update_hospital_pk_no' => $ses_hospital_id,

                ];
                if (in_array(Session::get('user.ses_hospital_code'), ["AMCSH"])) {
                    $invoice_data['lab_result_prepared_key_ind']    = 1;
                    $invoice_data['lab_result_prepared_keyed_by']   = $result_prepared_by;
                    $invoice_data['lab_result_prepared_keyed_time'] = new DateTime('now');
                    $invoice_data['lab_result_verify_key_ind']    = 1;
                    $invoice_data['lab_result_verify_keyed_by']   = $result_verified_by;
                    $invoice_data['lab_result_verify_keyed_time'] = new DateTime('now');
                    $invoice_data['lab_result_entry_key_ind']    = 1;
                    $invoice_data['lab_result_entry_keyed_by']   = $request->consultant;
                    $invoice_data['lab_result_entry_keyed_time'] = new DateTime('now');
                    $invoice_data['lab_result_con_key_ind'] = 1;
                    $invoice_data['lab_result_con_keyed_by'] = $request->consultant2;
                    $invoice_data['lab_result_con_keyed_time'] = new DateTime('now');
                }
                if (in_array(Session::get('user.ses_hospital_code'), ["UNICO", "DMHL"])) {
                    $data = array();
                    $data['report_rcb_ind'] = 1;
                    // $data['report_rcb_keyed_by'] = Auth::id();
                    $data['report_rcb_keyed_time'] = new DateTime('now');
                    $data['au_update_by'] =  $auth_id;
                    $data['au_update_at'] = date('Y-m-d');
                    $data['au_update_session'] = 'report receive';
                    $data['au_update_hospital_pk_no'] = $ses_hospital_id;
                    // DB::table('labt_testreporting')->where('report_no_pk', $hdn_report_id)->update($data);

                    $data['report_procees_ind'] = 1;
                    // $data['report_procees_keyed_by'] = Auth::id();
                    $data['report_procees_keyed_time'] = new DateTime('now');

                    // $data = array();
                    $data['report_deli_pending_ind'] = 1;
                    $data['au_entry_by'] = Auth::id();
                    $data['au_entry_at'] = new DateTime('now');
                    $data['au_entry_session'] = 'session';

                    // dd($data);

                    DB::table('labt_testreporting')->where('report_no_pk', $hdn_report_id)->update($data);
                }
            }
            if ($request->action_type == "consultant") {

                $report_data = [
                    'result_ent_key_ind'       => 1,
                    'result_ent_keyed_by'      => $request->consultant,
                    'result_ent_keyed_time'    => new DateTime('now'),
                    'organism_a'               => $orgnsm_name_1,
                    'organism_b'               => $orgnsm_name_2,
                    'organism_c'             => $orgnsm_name_3,
                    // 'organism_b_u'             => $orgnsm_name_4,
                    'incubation_temp'          => $incu_temp,
                    'incubation_time'          => $incu_time,
                    'incubation_condition'     => $incu_cond,
                    'colony_count'             => $colony_count,
                    'colony_count_a'           => $colony_countA,
                    'colony_count_b'           => $colony_count_B,
                    'colony_pattern'           => $colony_pattern,
                    'note_text'                => $result_note,
                    'comments_text'                => $result_comm,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_entry_key_ind'    => 1,
                    'lab_result_entry_keyed_by'   => $request->consultant,
                    'lab_result_entry_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];
            }
            // dd($hdn_report_id,$report_data, $invoice_data);
             $saveDate=Db::table("labt_testreporting")->where("report_no_pk", $hdn_report_id)->update($report_data);
            DB::table('labt_invoicedtl')->where("report_no_fk", $hdn_report_id)->update($invoice_data);
            // LabInvoiceDtl::where("report_no_fk", $hdn_report_id)->update($invoice_data);

            // if ($saveDate > 0) {
               $this->sendSmsMail($hdn_report_id,$request->action_type, $saveDate);
            // }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }


    public function resultEntryPdfMic($report_id,$draft="",$type="")
    {

        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        // try {
            $report_header = DB::table("labt_testreportresultprint_vw")->where('report_no_pk', $report_id)->first();

            // dd($report_header);
            $result_prepared_by = Auth::id();
            $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
            $invoice_data = [
                'lab_result_print_key_ind' => 1,
                'lab_result_print_keyed_by' => $result_prepared_by,
                'lab_result_print_keyed_time' => date("Y-m-d"),
                'au_update_hospital_pk_no' => $ses_hospital_id,
            ];
            // dd($report_header);
            LabInvoiceDtl::where("report_no_fk", $report_id)->update($invoice_data);

            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {

                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }

            $report_data = DB::table("labt_testresultstruct_vw")
                ->select('attr', 'result0', 'result1', 'result2')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('attr', 'ASC')
                ->get()->toArray();

            $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->first();

            $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';
            $report_data_1 = DB::table("labt_testresultstruct_vw")
                ->select('attr', 'result0', 'result1', 'result2')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                // ->skip(10)->take(18)
                ->where('result0', 'S')
                ->get()->toArray();

            $report_data_2 = DB::table("labt_testresultstruct_vw")
                ->select('attr', 'result0', 'result1', 'result2')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                // ->skip(10)->take(18)
                ->where('result0', 'R')
                ->get()->toArray();



            $incuvation_dt = DB::select(DB::raw("SELECT dt1.lookupdata_name incubation_temp,
                   dt2.lookupdata_name incubation_condition,
                   dt3.lookupdata_name colony_count,
                   dt10.lookupdata_name colony_count_a,
                   dt11.lookupdata_name colony_count_b,
                   dt4.lookupdata_name incubation_time,
                   dt4.lookupdata_name stucture,
                   dt6.lookupdata_name sensitivity,
                   dt7.lookupdata_name biochemical_test,
                   dt8.lookupdata_name gram_stain_smear,
                   dt9.lookupdata_name microscope_examination,
                   lab.rbc,
                   lab.epithelialv,
                   lab.pus_cells,
                   lab.colony_pattern
              FROM labt_testreporting lab
                   LEFT JOIN sysc_lookupdata dt1
                      ON lab.incubation_temp = dt1.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt2
                      ON lab.incubation_condition = dt2.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt3
                      ON lab.colony_count = dt3.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt4
                      ON lab.incubation_time = dt4.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt6
                      ON lab.sensitivity = dt6.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt7
                      ON lab.biochemical_test = dt7.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt8
                      ON lab.gram_stain_smear = dt8.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt9
                      ON lab.microscope_examination = dt9.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt10
                      ON lab.COLONY_COUNT_A = dt10.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt11
                      ON lab.COLONY_COUNT_B = dt11.lookupdata_no_pk
                    where lab.report_no_pk = $report_id"));

            $po_hospital_details = DB::table("wsec_hospital")->first();
            $result_organism = DB::table('labt_testreporting')->where('report_no_pk', $report_id)->first();

            if ($po_hospital_details->hospital_code == 'GMC') {
                return view("admin.pathology.microbiology_report_pdf", ['incuvation_dt' => $incuvation_dt, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'report_data_1' => $report_data_1, 'report_data_2' => $report_data_2])->render();
            }elseif(Session::get('user.ses_hospital_code')=="UNICO"){
                if (isset($report_header->organism_c)) {

                    return view("admin.pathology.reports.microbiology.microbiology_report_pdf_three_columns", ["result_organism" => $result_organism, "report_label" => $report_label, 'incuvation_dt' => $incuvation_dt, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'report_data_1' => $report_data_1, 'report_data_2' => $report_data_2,'draft'=>$draft])->render();
                } elseif (isset($report_header->organism_b)) {

                    return view("admin.pathology.reports.microbiology.microbiology_report_pdf_two_columns", ["result_organism" => $result_organism, "report_label" => $report_label, 'incuvation_dt' => $incuvation_dt, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'report_data_1' => $report_data_1, 'report_data_2' => $report_data_2,'draft'=>$draft])->render();
                } else {

                    return view("admin.pathology.reports.microbiology.microbiology_report_pdf_single_columns_v2", ["result_organism" => $result_organism, "report_label" => $report_label, 'incuvation_dt' => $incuvation_dt, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'report_data_1' => $report_data_1, 'report_data_2' => $report_data_2,'draft'=>$draft])->render();
                }
            }else {
                if (isset($report_header->organism_c)) {

                    return view("admin.pathology.reports.microbiology.microbiology_report_pdf_three_columns", ["result_organism" => $result_organism, "report_label" => $report_label, 'incuvation_dt' => $incuvation_dt, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'report_data_1' => $report_data_1, 'report_data_2' => $report_data_2,'draft'=>$draft])->render();
                } elseif (isset($report_header->organism_b)) {

                    return view("admin.pathology.reports.microbiology.microbiology_report_pdf_two_columns", ["result_organism" => $result_organism, "report_label" => $report_label, 'incuvation_dt' => $incuvation_dt, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'report_data_1' => $report_data_1, 'report_data_2' => $report_data_2,'draft'=>$draft])->render();
                } else {

                    return view("admin.pathology.reports.microbiology.microbiology_report_pdf_single_columns", ["result_organism" => $result_organism, "report_label" => $report_label, 'incuvation_dt' => $incuvation_dt, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'report_data_1' => $report_data_1, 'report_data_2' => $report_data_2,'draft'=>$draft])->render();
                }
            }
            if ($type==1) {
                $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
            }

        // } catch (\Exception $e) {
        //     DB::rollback();

        // }
        // return $pdf->stream("MC-$report_id.pdf");
        // return @\PDF::loadHTML($html, 'utf-8')->stream();

    }




    // Organism Setup
    public function organism()
    {
        return Template::loadview("admin.settings.organism.organism_list");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function organismcreate()
    {
        return Template::loadview("admin.settings.organism.create_organism");
    }

    public function organismForm()
    {
        return Template::loadview("admin.settings.organism.create_organism_form");
    }

    public function organismStore(Request $request)
    {
        // dd($request->all());
        // return $request;
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $sequence = DB::getSequence();
        $bacteria_no_pk_seq = $sequence->nextValue('bacteria_no_pk_seq');
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [
                'bacteria_no_pk' => $bacteria_no_pk_seq,
                'bacteria_uid' => $request->organism_UID,
                'bacteria_name' => $request->organism_name,
                'status' => $request->organism_status ? 1 : null,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];

            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                $this->Organism->create($data);
            } else {
                // dd($id, $data);
                // $data['au_update_by'] = $auth_id;
                // $this->Organism->update($data, $id);
                DB::table('microbiology_bacteria')->where('bacteria_no_pk', $id)->update($data);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function organismAllData(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'microbiology_bacteria';
        // Table's primary key
        $primaryKey = 'bacteria_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'bacteria_uid', 'dt' => 1),
            array('db' => 'bacteria_name', 'dt' => 2),
            array('db' => 'status',   'dt' => 3),
            array('db' => 'bacteria_no_pk',   'dt' => 4),
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function organismEdit($id)
    {
        // dd($id);
        // $data = $this->Organism->show($id);
        $data = DB::table('microbiology_bacteria')->where('bacteria_no_pk', $id)->first();
        return Template::loadView("admin.settings.organism.create_organism_form", ['organism' => $data]);
    }





    // antivitic Setup
    public function antivitic()
    {
        return Template::loadview("admin.settings.antivitic.antivitic_list");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function oantiviticcreate()
    {
        return Template::loadview("admin.settings.antivitic.create_antivitic");
    }

    public function antiviticForm()
    {
        return Template::loadview("admin.settings.antivitic.create_antivitic_form");
    }

    public function antiviticStore(Request $request)
    {
        // dd($request->all());
        // return $request;
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $sequence = DB::getSequence();
        $antivitic_no_pk_seq = $sequence->nextValue('microbiology_no_pk_seq');
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [
                'microbiology_no_pk' => $antivitic_no_pk_seq,
                'microbilology_uid' => $request->antivitic_UID,
                'microbiology_name' => $request->antivitic_name,
                'status' => $request->antivitic_status ? 1 : null,
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];

            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                $this->Speciman->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                // $this->Speciman->update($data, $id);
                DB::table('microbiology_antibiotic')->where('microbiology_no_pk', $id)->update($data);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function antiviticAllData(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'microbiology_antibiotic';
        // Table's primary key
        $primaryKey = 'microbiology_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'microbilology_uid', 'dt' => 1),
            array('db' => 'microbiology_name', 'dt' => 2),
            array('db' => 'status', 'dt' => 3),
            array('db' => 'microbiology_no_pk',   'dt' => 4),
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function antiviticEdit($id)
    {
        // dd($id);
        // $data = $this->Organism->show($id);
        $data = DB::table('microbiology_antibiotic')->where('microbiology_no_pk', $id)->first();
        // dd($data);
        return Template::loadView("admin.settings.antivitic.create_antivitic_form", ['data' => $data]);
    }


    // Cross Maching


    public function resultEntryFormCm($report_id, $type = 1, $lab_id)
    {


        $patient_info = [];
        $result_info_0 = DB::table("labt_testreporting_wl_vw")
            // ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("report_no_pk", $report_id)
            ->whereNull('cancel_ind')
            ->first();

        if (!empty($result_info_0)) {
            $prescription_id = $result_info_0->invoice_no_fk;

            $patient_info = DB::table("labt_invoicedtl_vw a")
                ->select("a.doctor_name", "b.patient_name", "b.patient_no_pk", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "b.pat_relation", "b.ref_patient_gender", "b.ref_blood_group", "b.ref_age", "b.blood_group_txt", "b.mobile1", DB::raw('pat_age(b.dob,nvl(dod,sysdate))pat_age'))
                ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where("a.invoice_no_fk", $prescription_id)->first();
        }


        $hospital_id =   Session::get('user.ses_hospital_no_pk');
        $result_test_info = DB::table('microbiology_antibiotic')->where('status', 1)->get();


        $result_info = DB::table("labt_testreporting_wl_vw as lab")
            ->select(
                "lab.item_no_fk",
                "lab.sam_name as sam_name",
                "lab.serviceunit_name",
                "lab.report_uid",
                "lab.interpretation",
                "lab.comments_text",
                "lab.note_text",
                "lab.result_prepared_keyed_by",
                "lab.result_verify_keyed_by",
                "lab.result_final_keyed_by",
                "lab.result_ent_keyed_by",
                "lab.report_no_pk",
                "lab.analyzer_desc",
                "lab.invoice_no_fk",
                "lab.su_no_fk",
            )
            ->leftjoin('sysc_serviceitem_vw as ser', 'lab.item_no_fk', 'ser.item_no_pk')
            // ->where('lab.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("lab.report_no_pk", $report_id)
            ->first();


        $result_info_1 = DB::table("labt_testreporting_wl_vw as lab")
            ->select(
                "lab.item_no_fk",
                "lab.sam_name as sam_name",
                "lab.serviceunit_name",
                "lab.report_uid",
                "lab.interpretation",
                "lab.comments_text",
                "lab.note_text",
                "lab.result_prepared_keyed_by",
                "lab.result_verify_keyed_by",
                "lab.result_final_keyed_by",
                "lab.result_ent_keyed_by",
                "lab.report_no_pk",
                "lab.analyzer_desc",
                "lab.invoice_no_fk",
                "lab.organism_a",
                "lab.organism_b",
                "lab.organism_a_u",
                "lab.organism_b_u",
                "lab.organism_c",
                "lab.organism_c_u",
            )
            ->leftjoin('sysc_serviceitem_vw as ser', 'lab.item_no_fk', 'ser.item_no_pk')
            // ->where('lab.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("lab.report_no_pk", $report_id)
            ->first();

        // dd($result_info_1);


        $rs_dt = DB::select(DB::raw("select lab.*,sys.* from labt_testresultstruct_vw lab
            left join sysc_serviceitem_vw sys
            on lab.item_no_fk = sys.item_no_pk
            where lab.report_no_fk = $report_id
            and lab.au_entry_hospital_pk_no = $hospital_id
            and lab.cancel_ind is null order by lab.item_name Asc,sl_no ASC"));

        $result_item = DB::select(DB::raw("select test_name_list from labt_samplelabrcv_wl_vw where lab_uid = $lab_id
                and au_entry_hospital_pk_no = $hospital_id  and cancel_ind is null"));


        $analyzer = DB::table('sysc_serviceitem')->select('item_code', 'item_name', 'interpretation')->where('analyzer_ind', 1)->get();
        $donar = DB::table('labt_donerinfo')->where('report_no_fk', $report_id)->first();


        // $prepared_by = $this->getPathologyResultEntryByUser("save_ind");
        // $verified_by = $this->getPathologyResultEntryByUser("verify_ind");
        // $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind");
        $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind", $result_info->su_no_fk);
        $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind", $result_info->su_no_fk);
        $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind", $result_info->su_no_fk);
        $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind", $result_info->su_no_fk);
        $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind", $result_info->su_no_fk);

        $incubationtime = $this->getLookupListByCode("INCUBATIONTIME");
        $incubationtemp = $this->getLookupListByCode("INCUBATIONTEMP");
        $incubationcolonycount = $this->getLookupListByCode("INCUBATIONCOLONYCOUNT");
        $incubationcond = $this->getLookupListByCode("INCUBATIONCOND");
        $antivitic = DB::table("microbiology_antibiotic")->get();
        $becteria = DB::table("microbiology_bacteria")->get();
        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $bloodg = $this->getLookupListByCode("BLOODG");

        return Template::loadview("admin.pathology.cross_maching_form", [
            "report_id" => $report_id,
            "result_info" => $result_info,
            "rs_dt" => $rs_dt,
            "result_info_1" => $result_info_1,
            "patient_info" => $patient_info,
            "result_test_info" => $result_test_info,
            "prepared_by_columns" => $prepared_by,
            "verified_by_columns" => $verified_by,
            "finalize_by_columns" => $finalize_by,
            "type" => $type,
            "result_item" => $result_item,
            'lab_id' => $lab_id,
            'analyzer' => $analyzer,
            "incubationtime" => $incubationtime,
            "incubationtemp" => $incubationtemp,
            "incubationcolonycount" => $incubationcolonycount,
            "incubationcond" => $incubationcond,
            "antivitic" => $antivitic,
            "becteria" => $becteria,
            "marital_status" => $marital_status,
            "gender" => $gender,
            "bloodg" => $bloodg,
            "donar" => $donar,
            "consult" => $consult,
            "consult2" => $consult2,


        ]);
    }



    public function storeResultEntryCm(Request $request)
    {
        $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
        // ->where("au_entry_hospital_no_fk", $ses_hospital_id)
        $id = $request->donar_no;
        $auth_id = Auth::id();
        $sequence = DB::getSequence();
        $donor_no_pk_seq = $sequence->nextValue('testresult_no_pk_seq');
        //    dd($request->all());

        DB::beginTransaction();
        try {
            $result_note        = $request->result_note;
            $hdn_report_id      = $request->hdn_report_id;
            $hdn_invoice_id      = $request->hdn_invoice_id;
            $hdn_item_id      = $request->hdn_item_id;
            $result_prepared_by   = $request->result_prepared_by;
            $result_verified_by   = $request->result_verified_by;
            $result_finalize_by   = $request->result_finalize_by;

            $data = [
                'doner_age' => $request->donor_age,
                'doner_beg_no' => $request->bag_no,
                'doner_blood' => $request->donor_blood_group,
                'doner_code' => 'D' . $donor_no_pk_seq,
                'doner_gender' => $request->donor_gender,
                'doner_hbsag' => $request->HbsAG,
                'doner_hcp' => $request->hcb,
                'doner_hiv' => $request->hib,
                'doner_mp' => $request->mp,
                'doner_vdrl' => $request->vdrl,
                'anti_hbc_total' => $request->anti_hbc_total,
                'doner_name' => $request->donor_name,
                'doner_rh_typing' => $request->rh_typing,
                'donor_marital_status' => $request->donor_marital_status,
                'status' => 1,
                'type_of_blood_component' => $request->type_of_blood,
                'type_of_donations' => $request->type_of_donation,
                'doner_room_temp' => $request->cms,

                'patient_age' => $request->hdn_age,
                'patient_blood_group' => $request->hdn_blood_group_txt,
                'patient_rh_typing' => $request->pat_rh_typing,
                'patient_gender' => $request->hdn_gender_txt,
                'patient_name' => $request->hdn_patient_name,
                'patient_no_fk' => $request->hdn_patient_no_pk,
                'invoice_no_fk' => $request->hdn_invoice_id,
                'report_no_fk' => $hdn_report_id
            ];

            if ($id == null) {
                // dd($data);
                $data['au_entry_by'] = $auth_id;
                $this->Donor->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->Donor->update($data, $id);
            }



            if ($request->action_type == "prepare") {
                $report_data = [
                    'result_prepared_key_ind'    => 1,
                    'result_prepared_keyed_by'   => $result_prepared_by,
                    'result_prepared_keyed_time' => new DateTime('now'),

                    'note_text'                => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_prepared_key_ind'    => 1,
                    'lab_result_prepared_keyed_by'   => $result_prepared_by,
                    'lab_result_prepared_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no'       => $ses_hospital_id,
                ];
                if (in_array(Session::get('user.ses_hospital_code'), ["DMHL"])) {
                    $report_data['result_verify_key_ind']      = 1;
                    $report_data['result_verify_keyed_by']     = $result_verified_by;
                    $report_data['result_verify_keyed_time']   = new DateTime('now');
                    $report_data['note_text']                  = $result_note;
                    $report_data['au_update_hospital_pk_no'] = $ses_hospital_id;

                    $invoice_data['lab_result_verify_key_ind']    = 1;
                    $invoice_data['lab_result_verify_keyed_by']   = $result_verified_by;
                    $invoice_data['lab_result_verify_keyed_time'] = new DateTime('now');
                    $invoice_data['au_update_hospital_pk_no'] = $ses_hospital_id;
                }
            }

            if ($request->action_type == "verifiy") {
                $report_data = [
                    'result_verify_key_ind'      => 1,
                    'result_verify_keyed_by'     => $result_verified_by,
                    'result_verify_keyed_time'   => new DateTime('now'),

                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no'   => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_verify_key_ind'    => 1,
                    'lab_result_verify_keyed_by'   => $result_verified_by,
                    'lab_result_verify_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no'     => $ses_hospital_id,
                ];
            }

            if ($request->action_type == "finalize") {
                $report_data = [
                    'result_final_key_ind'       => 1,
                    'result_final_keyed_by'      => $result_finalize_by,
                    'result_final_keyed_time'    => new DateTime('now'),

                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no'   => $ses_hospital_id,


                ];
                if (in_array(Session::get('user.ses_hospital_code'), ["AMCSH"])) {
                    $report_data['result_prepared_key_ind']    = 1;
                    $report_data['result_prepared_keyed_by']   = $result_prepared_by;
                    $report_data['result_prepared_keyed_time'] = new DateTime('now');
                    $report_data['result_verify_key_ind']      = 1;
                    $report_data['result_verify_keyed_by']     = $result_verified_by;
                    $report_data['result_verify_keyed_time']   = new DateTime('now');
                    $report_data['result_ent_key_ind']       = 1;
                    $report_data['result_ent_keyed_by']      = $request->consultant;
                    $report_data['result_ent_keyed_time']    = new DateTime('now');
                    $report_data['result_con_key_ind'] = 1;
                    $report_data['result_con_keyed_by'] = $request->consultant2;
                    $report_data['result_con_keyed_time'] = new DateTime('now');
                }

                $invoice_data = [
                    'lab_result_final_key_ind'    => 1,
                    'lab_result_final_keyed_by'   => $result_finalize_by,
                    'lab_result_final_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                if (in_array(Session::get('user.ses_hospital_code'), ["AMCSH"])) {
                    $invoice_data['lab_result_prepared_key_ind']    = 1;
                    $invoice_data['lab_result_prepared_keyed_by']   = $result_prepared_by;
                    $invoice_data['lab_result_prepared_keyed_time'] = new DateTime('now');
                    $invoice_data['lab_result_verify_key_ind']    = 1;
                    $invoice_data['lab_result_verify_keyed_by']   = $result_verified_by;
                    $invoice_data['lab_result_verify_keyed_time'] = new DateTime('now');
                    $invoice_data['lab_result_entry_key_ind']    = 1;
                    $invoice_data['lab_result_entry_keyed_by']   = $request->consultant;
                    $invoice_data['lab_result_entry_keyed_time'] = new DateTime('now');
                    $invoice_data['lab_result_con_key_ind'] = 1;
                    $invoice_data['lab_result_con_keyed_by'] = $request->consultant2;
                    $invoice_data['lab_result_con_keyed_time'] = new DateTime('now');
                }
                if (in_array(Session::get('user.ses_hospital_code'), ["UNICO", "DMHL"])) {
                    $data = array();
                    $data['report_rcb_ind'] = 1;
                    // $data['report_rcb_keyed_by'] = Auth::id();
                    $data['report_rcb_keyed_time'] = new DateTime('now');
                    $data['au_update_by'] =  $auth_id;
                    $data['au_update_at'] = date('Y-m-d');
                    $data['au_update_session'] = 'report receive';
                    $data['au_update_hospital_pk_no'] = $ses_hospital_id;
                    // DB::table('labt_testreporting')->where('report_no_pk', $hdn_report_id)->update($data);

                    $data['report_procees_ind'] = 1;
                    // $data['report_procees_keyed_by'] = Auth::id();
                    $data['report_procees_keyed_time'] = new DateTime('now');

                    // $data = array();
                    $data['report_deli_pending_ind'] = 1;
                    $data['au_entry_by'] = Auth::id();
                    $data['au_entry_at'] = new DateTime('now');
                    $data['au_entry_session'] = 'session';


                    DB::table('labt_testreporting')->where('report_no_pk', $hdn_report_id)->update($data);
                }
            }
            if ($request->action_type == "consultant") {

                $report_data = [
                    'result_ent_key_ind'       => 1,
                    'result_ent_keyed_by'      => $request->consultant,
                    'result_ent_keyed_time'    => new DateTime('now'),

                    'note_text'                => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_entry_key_ind'    => 1,
                    'lab_result_entry_keyed_by'   => $request->consultant,
                    'lab_result_entry_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];
            }

            $saveDate= Db::table("labt_testreporting")->where("report_no_pk", $hdn_report_id)->update($report_data);
            LabInvoiceDtl::where("report_no_fk", $hdn_report_id)->update($invoice_data);

            if ($saveDate > 0) {
               $this->sendSmsMail($hdn_report_id,$request->action_type, $saveDate);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }


    public function resultEntryPdfCm($report_id,$draft="",$type="")
    {

        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        try {
            $report_header = DB::table("labt_testreportresultprint_vw")->where('report_no_pk', $report_id)->first();
            // dd($report_header);
            $result_prepared_by = Auth::id();
            $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
            $invoice_data = [
                'lab_result_print_key_ind' => 1,
                'lab_result_print_keyed_by' => $result_prepared_by,
                'lab_result_print_keyed_time' => date("Y-m-d"),
                'au_update_hospital_pk_no' => $ses_hospital_id,
            ];
            LabInvoiceDtl::where("report_no_fk", $report_id)->update($invoice_data);

            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {

                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }

            $report_data = DB::table("labt_testresultstruct_vw")
                ->select('attr', 'result0')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->skip(0)->take(9)->get()->toArray();
            $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->first();
            $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';

            $report_data_1 = DB::table("labt_testresultstruct_vw")

                ->select('attr', 'result0')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->skip(10)->take(18)->get()->toArray();
            $donor_info = db::table('labt_donerinfo donor')
                ->select('donor.*', 'dt1.lookupdata_name as blood', 'dt.lookupdata_name as gender_txt', 'dt2.lookupdata_name as pat_blood')
                ->where('donor.report_no_fk', $report_id)
                ->leftjoin('sysc_lookupdata dt', 'donor.doner_gender', 'dt.lookupdata_no_pk')
                ->leftjoin('sysc_lookupdata dt1', 'donor.doner_blood', 'dt1.lookupdata_no_pk')
                ->leftjoin('patn_registration pat', 'donor.patient_no_fk', 'pat.patient_no_pk')
                ->leftjoin('sysc_lookupdata dt2', 'donor.patient_blood_group', 'dt2.lookupdata_no_pk')
                ->first();
            // dd( $donor_info->anti_hbc_total);
            $po_hospital_details = DB::table("wsec_hospital")->first();

            // dd($donor_info);
            return view("admin.pathology.cm_report_pdf", ["report_label" => $report_label, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, 'donor_info' => $donor_info,'draft'=>$draft]);

            if ($type==1) {
                 $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
            }

        } catch (\Exception $e) {
            DB::rollback();
            // $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // return $pdf->stream("MC-$report_id.pdf");
        // return @\PDF::loadHTML($html, 'utf-8')->stream();

    }



    // Gram Stain


    public function resultGramStain($report_id, $type = 1, $lab_id)
    {

        $patient_info = [];
        $result_info_0 = DB::table("labt_testreporting_wl_vw")
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("report_no_pk", $report_id)
            ->whereNull('cancel_ind')
            ->first();


        if (!empty($result_info_0)) {
            $prescription_id = $result_info_0->invoice_no_fk;

            $patient_info = DB::table("labt_invoicedtl_vw a")
                ->select("b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "b.pat_relation", "b.ref_patient_gender", "b.ref_blood_group", "b.ref_age", "b.blood_group_txt", "b.mobile1")
                ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where("a.invoice_no_fk", $prescription_id)->first();
        }
        $hospital_id =   Session::get('user.ses_hospital_no_pk');
        $result_test_info = DB::table('microbiology_antibiotic')->where('status', 1)->get();

        $labt_testresultstruct = DB::table('labt_testresultstruct_vw')->where('report_no_fk', $report_id)->get();
        // dd($result_test_info);

        $result_info = DB::table("labt_testreporting_wl_vw as lab")
            ->select(
                "lab.item_no_fk",
                "lab.sam_name as sam_name",
                "lab.serviceunit_name",
                "lab.report_uid",
                "lab.interpretation",
                "lab.comments_text",
                "lab.note_text",
                "lab.result_prepared_keyed_by",
                "lab.result_verify_keyed_by",
                "lab.result_final_keyed_by",
                "lab.result_ent_keyed_by",
                "lab.report_no_pk",
                "lab.analyzer_desc",
                "lab.invoice_no_fk",
                "lab.su_no_fk",
                "lab.lab_code",
            )
            ->leftjoin('sysc_serviceitem_vw as ser', 'lab.item_no_fk', 'ser.item_no_pk')
            // ->where('lab.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("lab.report_no_pk", $report_id)
            ->first();

        $result_info_1 = DB::table("labt_testreporting_wl_vw as lab")
            ->select(
                "lab.item_no_fk",
                "lab.sam_name as sam_name",
                "lab.serviceunit_name",
                "lab.report_uid",
                "lab.interpretation",
                "lab.comments_text",
                "lab.note_text",
                "lab.result_prepared_keyed_by",
                "lab.result_verify_keyed_by",
                "lab.result_final_keyed_by",
                "lab.result_ent_keyed_by",
                "lab.report_no_pk",
                "lab.analyzer_desc",
                "lab.invoice_no_fk",
                "lab.organism_a",
                "lab.organism_b",
                "lab.organism_a_u",
                "lab.organism_b_u",
                "lab.organism_c",
                "lab.organism_c_u",
                "lab.incubation_temp",
                "lab.incubation_condition",
                "lab.colony_count",
                "lab.incubation_time",
                'lab.test_method',
                'lab.gram_stain_smear',
                'lab.epithelialv',
                'lab.biochemical_test',
                'lab.identity_mark',
                'lab.pus_cells',
                'lab.rbc',
                'lab.structure',
                'lab.microscope_examination',
                'lab.sensitivity',
                'lab.gram_diplococci',
                'lab.candida'
            )
            ->leftjoin('sysc_serviceitem_vw as ser', 'lab.item_no_fk', 'ser.item_no_pk')
            // ->where('lab.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("lab.report_no_pk", $report_id)
            ->first();



        $rs_dt = DB::select(DB::raw("select lab.*,sys.* from labt_testresultstruct_vw lab
            left join sysc_serviceitem_vw sys
            on lab.item_no_fk = sys.item_no_pk
            where lab.report_no_fk = $report_id
            and lab.au_entry_hospital_pk_no = $hospital_id
            and lab.cancel_ind is null order by lab.item_name Asc,sl_no ASC"));

        $result_item = DB::select(DB::raw("select test_name_list from labt_samplelabrcv_wl_vw where lab_uid = $lab_id
                and au_entry_hospital_pk_no = $hospital_id  and cancel_ind is null"));


        $analyzer = DB::table('sysc_serviceitem')->select('item_code', 'item_name', 'interpretation')->where('analyzer_ind', 1)->get();



        $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind", $result_info->su_no_fk);
        $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind", $result_info->su_no_fk);
        $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind", $result_info->su_no_fk);
        $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind", $result_info->su_no_fk);
        $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind", $result_info->su_no_fk);


        $incubationtime = $this->getLookupListByCode("INCUBATIONTIME");
        $incubationtemp = $this->getLookupListByCode("INCUBATIONTEMP");
        $incubationcolonycount = $this->getLookupListByCode("INCUBATIONCOLONYCOUNT");
        $incubationcond = $this->getLookupListByCode("INCUBATIONCOND");
        $rbc = $this->getLookupListByCode("RBC");


        $antivitic = DB::table("microbiology_antibiotic")->get();
        $becteria = DB::table("microbiology_bacteria")->get();

        // FOR gmc
        $microscope = $this->getLookupListByCode("MICROSCOPEEXAMINATION");
        $gramstain = $this->getLookupListByCode("GRAMSTAIN");
        $sensityvity = $this->getLookupListByCode("SENSITYVITY");
        $biochemical_test = $this->getLookupListByCode("BIOCHEMICALTEST");

        return Template::loadview("admin.pathology.result_entry_form_gram_statin", [
            "report_id" => $report_id,
            "result_info" => $result_info,
            "rs_dt" => $rs_dt,
            "result_info_1" => $result_info_1,
            "patient_info" => $patient_info,
            "result_test_info" => $result_test_info,
            "prepared_by_columns" => $prepared_by,
            "verified_by_columns" => $verified_by,
            "finalize_by_columns" => $finalize_by,
            "type" => $type,
            "result_item" => $result_item,
            'lab_id' => $lab_id,
            'analyzer' => $analyzer,
            "incubationtime" => $incubationtime,
            "incubationtemp" => $incubationtemp,
            "incubationcolonycount" => $incubationcolonycount,
            "incubationcond" => $incubationcond,
            "antivitic" => $antivitic,
            "becteria" => $becteria,
            "microscope" => $microscope,
            "gramstain" => $gramstain,
            "sensityvity" => $sensityvity,
            "rbc" => $rbc,
            "biochemical_test" => $biochemical_test,
            "consult" => $consult,
            "consult2" => $consult2,
            "labt_testresultstruct" => $labt_testresultstruct

        ]);
    }



    public function storeResultGramStain(Request $request)
    {
        $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();
        //  dd($request->all());

        DB::beginTransaction();
        try {
            $result_note        = $request->result_note;
            $hdn_report_id      = $request->hdn_report_id;
            $hdn_invoice_id      = $request->hdn_invoice_id;
            $hdn_item_id      = $request->hdn_item_id;
            $result_prepared_by   = $request->result_prepared_by;
            $result_verified_by   = $request->result_verified_by;
            $result_finalize_by   = $request->result_finalize_by;

            $orgnsm_name_1   = $request->orgnsm_name_1;
            $orgnsm_name_2   = $request->orgnsm_name_2;
            $orgnsm_name_3   = $request->orgnsm_name_3;
            $orgnsm_name_4   = $request->orgnsm_name_4;
            $incu_temp   = $request->incu_temp;
            $incu_time   = $request->incu_time;
            $incu_cond   = $request->incu_cond;
            $colony_count   = $request->colony_count;

            $testresult_no_pk   = $request->testresult_no_pk;
            $testresult_value   = $request->testresult_value;
            $result             = $request->result;
            $show_in_rep        = $request->show_in_rep;

            // for GMC
            $mic_data   = $request->mic_data;
            $grm_stain   = $request->grm_stain;
            $sensitivity   = $request->sensitivity;
            $bio_test   = $request->bio_test;
            $rbc   = $request->rbc;
            $epithelial   = $request->epithelial;
            $pus_cells   = $request->pus_cells;
            $gram_diplococci   = $request->gram_diplococci;
            $candida   = $request->candida;
            $gram_stain   = $request->gram_stain;
            // End
            //  dd($testresult_no_pk,$testresult_value, $result,$show_in_rep );
            $ids = [];
            DB::table('labt_testresult')->where('report_no_fk', $hdn_report_id)->delete();
            if (!empty($show_in_rep)) {
                for ($i = 0; $i < count($show_in_rep); $i++) {
                    // dd($show_in_rep_val)
                    $result_data = explode('_', $show_in_rep[$i]);
                    $sequence = DB::getSequence();
                    $testresult_no_pk_seq = $sequence->nextValue('testresult_no_pk_seq');
                    $show_in_rep_val = 0;
                    $ss = 'show_in_rep_' . $testresult_no_pk[$i];

                    $reuslt_entry = DB::table('labt_testresult')->where('report_no_fk', $hdn_report_id)->where('teststruct_no_fk', $result_data[1])->first();
                    $id = isset($reuslt_entry->teststruct_no_fk) && !empty($reuslt_entry->teststruct_no_fk) ? $reuslt_entry->teststruct_no_fk : "";
                    // dd( $reuslt_entry);
                    $data = [
                        // 'testresult_no_pk' => $testresult_no_pk_seq,
                        'testresult_code' => 'R' . ($testresult_no_pk_seq + 1), //'R'.$testresult_no_pk_seq
                        'report_no_fk' => $hdn_report_id,
                        'item_no_fk' => $hdn_item_id,
                        'invoice_no_fk' => $hdn_invoice_id,
                        'au_entry_hospital_pk_no' => $ses_hospital_id,
                        'au_entry_session' => 'Session',
                        // 'au_entry_at' => date("Y-m-d"),
                        'au_entry_by' => $auth_id,

                        'result0'       => $result_data[2],
                        'attr'       => $result_data[0],
                        'teststruct_no_fk' => $result_data[1],
                        'show_in_rep'   => 1, //isset($show_in_rep[$i]) ? 1 :0

                    ];
                    if ($id == "") {
                        // dd($data);
                        $data['au_entry_by'] = $auth_id;
                        $this->labtestresult->create($data);
                    } else {
                        $data['au_update_by'] = $auth_id;
                        LabTestResult::where('report_no_fk', $hdn_report_id)->where('teststruct_no_fk', $result_data[1])->update($data);
                    }
                }
            }
            if ($request->action_type == "prepare") {
                $report_data = [
                    'result_prepared_key_ind'    => 1,
                    'result_prepared_keyed_by'   => $result_prepared_by,
                    'result_prepared_keyed_time' => date("Y-m-d"),
                    'organism_a'               => $orgnsm_name_1,
                    'organism_b'               => $orgnsm_name_2,
                    'organism_c'             => $orgnsm_name_3,
                    // 'organism_b_u'             => $orgnsm_name_4,
                    'incubation_temp'          => $incu_temp,
                    'incubation_time'          => $incu_time,
                    'incubation_condition'     => $incu_cond,
                    'colony_count'             => $colony_count,
                    'note_text'                => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_prepared_key_ind'    => 1,
                    'lab_result_prepared_keyed_by'   => $result_prepared_by,
                    'lab_result_prepared_keyed_time' => date("Y-m-d"),
                    'au_update_hospital_pk_no'       => $ses_hospital_id,
                ];
            }

            if ($request->action_type == "verifiy") {
                $report_data = [
                    'result_verify_key_ind'      => 1,
                    'result_verify_keyed_by'     => $result_verified_by,
                    'result_verify_keyed_time'   => date("Y-m-d"),
                    'organism_a'                 => $orgnsm_name_1,
                    'organism_b'                 => $orgnsm_name_2,
                    'organism_c'               => $orgnsm_name_3,
                    // 'organism_b_u'               => $orgnsm_name_4,
                    'incubation_temp'            => $incu_temp,
                    'incubation_time'            => $incu_time,
                    'incubation_condition'       => $incu_cond,
                    'colony_count'               => $colony_count,
                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no'   => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_verify_key_ind'    => 1,
                    'lab_result_verify_keyed_by'   => $result_verified_by,
                    'lab_result_verify_keyed_time' => date("Y-m-d"),
                    'au_update_hospital_pk_no'     => $ses_hospital_id,
                ];
            }

            if ($request->action_type == "finalize") {
                $report_data = [
                    'result_final_key_ind'       => 1,
                    'result_final_keyed_by'      => $result_finalize_by,
                    'result_final_keyed_time'    => date("Y-m-d"),
                    'organism_a'                 => $orgnsm_name_1,
                    'organism_b'                 => $orgnsm_name_2,
                    'organism_c'               => $orgnsm_name_3,
                    // 'organism_b_u'               => $orgnsm_name_4,
                    'incubation_temp'            => $incu_temp,
                    'incubation_time'            => $incu_time,
                    'incubation_condition'       => $incu_cond,
                    'colony_count'               => $colony_count,
                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no'   => $ses_hospital_id,

                    'microscope_examination'     => $mic_data,
                    'gram_stain_smear'           => $grm_stain,
                    'sensitivity'                => $sensitivity,
                    'biochemical_test'           => $bio_test,
                    'rbc'                        => $rbc,
                    'epithelialv'                => $epithelial,
                    'pus_cells'                  => $pus_cells,
                    'gram_diplococci'                  => $gram_stain . '_' . $gram_diplococci,
                    'candida'                  => $candida,



                ];
                if (in_array(Session::get('user.ses_hospital_code'), ["AMCSH"])) {
                    $report_data['result_prepared_key_ind']    = 1;
                    $report_data['result_prepared_keyed_by']   = $result_prepared_by;
                    $report_data['result_prepared_keyed_time'] = date("Y-m-d");
                    $report_data['result_verify_key_ind']      = 1;
                    $report_data['result_verify_keyed_by']     = $result_verified_by;
                    $report_data['result_verify_keyed_time']   = date("Y-m-d");
                    $report_data['result_ent_key_ind']       = 1;
                    $report_data['result_ent_keyed_by']      = $request->consultant;
                    $report_data['result_ent_keyed_time']    = date("Y-m-d");
                    $report_data['result_con_key_ind'] = 1;
                    $report_data['result_con_keyed_by'] = $request->consultant2;
                    $report_data['result_con_keyed_time'] = date("Y-m-d");
                }
                $invoice_data = [
                    'lab_result_final_key_ind'    => 1,
                    'lab_result_final_keyed_by'   => $result_finalize_by,
                    'lab_result_final_keyed_time' => date("Y-m-d"),
                    'au_update_hospital_pk_no' => $ses_hospital_id,

                ];
                if (in_array(Session::get('user.ses_hospital_code'), ["AMCSH"])) {
                    $invoice_data['lab_result_prepared_key_ind']    = 1;
                    $invoice_data['lab_result_prepared_keyed_by']   = $result_prepared_by;
                    $invoice_data['lab_result_prepared_keyed_time'] = date("Y-m-d");
                    $invoice_data['lab_result_verify_key_ind']    = 1;
                    $invoice_data['lab_result_verify_keyed_by']   = $result_verified_by;
                    $invoice_data['lab_result_verify_keyed_time'] = date("Y-m-d");
                    $invoice_data['lab_result_entry_key_ind']    = 1;
                    $invoice_data['lab_result_entry_keyed_by']   = $request->consultant;
                    $invoice_data['lab_result_entry_keyed_time'] = date("Y-m-d");
                    $invoice_data['lab_result_con_key_ind'] = 1;
                    $invoice_data['lab_result_con_keyed_by'] = $request->consultant2;
                    $invoice_data['lab_result_con_keyed_time'] = date("Y-m-d");
                }
                if (in_array(Session::get('user.ses_hospital_code'), ["UNICO", "DMHL"])) {
                    $data = array();
                    $data['report_rcb_ind'] = 1;
                    // $data['report_rcb_keyed_by'] = Auth::id();
                    $data['report_rcb_keyed_time'] = new DateTime('now');
                    $data['au_update_by'] =  $auth_id;
                    $data['au_update_at'] = date('Y-m-d');
                    $data['au_update_session'] = 'report receive';
                    $data['au_update_hospital_pk_no'] = $ses_hospital_id;
                    // DB::table('labt_testreporting')->where('report_no_pk', $hdn_report_id)->update($data);

                    $data['report_procees_ind'] = 1;
                    // $data['report_procees_keyed_by'] = Auth::id();
                    $data['report_procees_keyed_time'] = new DateTime('now');

                    // $data = array();
                    $data['report_deli_pending_ind'] = 1;
                    $data['au_entry_by'] = Auth::id();
                    $data['au_entry_at'] = new DateTime('now');
                    $data['au_entry_session'] = 'session';
                    DB::table('labt_testreporting')->where('report_no_pk', $hdn_report_id)->update($data);
                }
            }
            if ($request->action_type == "consultant") {

                $report_data = [
                    'result_ent_key_ind'       => 1,
                    'result_ent_keyed_by'      => $request->consultant,
                    'result_ent_keyed_time'    => date("Y-m-d"),
                    'organism_a'               => $orgnsm_name_1,
                    'organism_b'               => $orgnsm_name_2,
                    'organism_c'             => $orgnsm_name_3,
                    // 'organism_b_u'             => $orgnsm_name_4,
                    'incubation_temp'          => $incu_temp,
                    'incubation_time'          => $incu_time,
                    'incubation_condition'     => $incu_cond,
                    'colony_count'             => $colony_count,
                    'note_text'                => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_entry_key_ind'    => 1,
                    'lab_result_entry_keyed_by'   => $request->consultant,
                    'lab_result_entry_keyed_time' => date("Y-m-d"),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];
            }

            $saveDate=    Db::table("labt_testreporting")->where("report_no_pk", $hdn_report_id)->update($report_data);
            LabInvoiceDtl::where("report_no_fk", $hdn_report_id)->update($invoice_data);

            if ($saveDate > 0) {
               $this->sendSmsMail($hdn_report_id,$request->action_type, $saveDate);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }


    public function resultGramStainPdf($report_id,$draft="",$type="")
    {
        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        try {
            $report_header = DB::table("labt_testreportresultprint_vw")->where('report_no_pk', $report_id)->first();
            // dd($report_header);
            $result_prepared_by = Auth::id();
            $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
            $invoice_data = [
                'lab_result_print_key_ind' => 1,
                'lab_result_print_keyed_by' => $result_prepared_by,
                'lab_result_print_keyed_time' => date("Y-m-d"),
                'au_update_hospital_pk_no' => $ses_hospital_id,
            ];
            LabInvoiceDtl::where("report_no_fk", $report_id)->update($invoice_data);

            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {

                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }

            $report_data = DB::table("labt_testresultstruct_vw")
                ->select('attr', 'result0')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->skip(0)->take(9)->get()->toArray();

            $report_data_1 = DB::table("labt_testresultstruct_vw")
                ->select('attr', 'result0')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->skip(10)->take(18)->get()->toArray();




            $incuvation_dt = DB::select(DB::raw("SELECT dt1.lookupdata_name incubation_temp,
                                                dt2.lookupdata_name incubation_condition,
                                                dt3.lookupdata_name colony_count,
                                                dt4.lookupdata_name incubation_time,
                                                dt4.lookupdata_name stucture,
                                                dt6.lookupdata_name sensitivity,
                                                dt7.lookupdata_name biochemical_test,
                                                dt8.lookupdata_name gram_stain_smear,
                                                dt9.lookupdata_name microscope_examination,
                                                lab.rbc,
                                                lab.EPITHELIALV,
                                                lab.PUS_CELLS,
                                                lab.gram_diplococci,
                                                lab.candida
                                            FROM labt_testreporting lab
                                                LEFT JOIN sysc_lookupdata dt1
                                                    ON lab.incubation_temp = dt1.lookupdata_no_pk
                                                LEFT JOIN sysc_lookupdata dt2
                                                    ON lab.incubation_condition = dt2.lookupdata_no_pk
                                                LEFT JOIN sysc_lookupdata dt3
                                                    ON lab.colony_count = dt3.lookupdata_no_pk
                                                LEFT JOIN sysc_lookupdata dt4
                                                    ON lab.structure = dt4.lookupdata_no_pk
                                                LEFT JOIN sysc_lookupdata dt6
                                                    ON lab.sensitivity = dt6.lookupdata_no_pk
                                                LEFT JOIN sysc_lookupdata dt7
                                                    ON lab.biochemical_test = dt7.lookupdata_no_pk
                                                LEFT JOIN sysc_lookupdata dt8
                                                    ON lab.gram_stain_smear = dt8.lookupdata_no_pk
                                                LEFT JOIN sysc_lookupdata dt9
                                                    ON lab.microscope_examination = dt9.lookupdata_no_pk  where lab.report_no_pk = $report_id"));
            $po_hospital_details = DB::table("wsec_hospital")->first();


            return view("admin.pathology.gram_stain_report_pdf", ['incuvation_dt' => $incuvation_dt, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'report_data_1' => $report_data_1,'draft'=>$draft])->render();

            if ($type==1) {
                $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
            }

        } catch (\Exception $e) {
            DB::rollback();
            // $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // return $pdf->stream("MC-$report_id.pdf");
        // return @\PDF::loadHTML($html, 'utf-8')->stream();

    }



    // AFB Report

    public function resultAfbForm($report_id, $type = 1, $lab_id)
    {

        $patient_info = [];
        $result_info_0 = DB::table("labt_testreporting_wl_vw")
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("report_no_pk", $report_id)
            ->whereNull('cancel_ind')
            ->first();


        if (!empty($result_info_0)) {
            $prescription_id = $result_info_0->invoice_no_fk;

            $patient_info = DB::table("labt_invoicedtl_vw a")
                ->select("b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "b.pat_relation", "b.ref_patient_gender", "b.ref_blood_group", "b.ref_age", "b.blood_group_txt", "b.mobile1")
                ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where("a.invoice_no_fk", $prescription_id)->first();
        }
        $hospital_id =   Session::get('user.ses_hospital_no_pk');
        $result_test_info = DB::table('microbiology_antibiotic')->where('status', 1)->get();

        $labt_testresultstruct = DB::table('labt_testresultstruct_vw')->where('report_no_fk', $report_id)->get();
        // dd($result_test_info);

        $result_info = DB::table("labt_testreporting_wl_vw as lab")
            ->select(
                "lab.item_no_fk",
                "lab.sam_name as sam_name",
                "lab.serviceunit_name",
                "lab.report_uid",
                "lab.interpretation",
                "lab.comments_text",
                "lab.note_text",
                "lab.result_prepared_keyed_by",
                "lab.result_verify_keyed_by",
                "lab.result_final_keyed_by",
                "lab.result_ent_keyed_by",
                "lab.report_no_pk",
                "lab.analyzer_desc",
                "lab.invoice_no_fk",
                "lab.su_no_fk",
                "lab.lab_code",
            )
            ->leftjoin('sysc_serviceitem_vw as ser', 'lab.item_no_fk', 'ser.item_no_pk')
            // ->where('lab.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("lab.report_no_pk", $report_id)
            ->first();

        $result_info_1 = DB::table("labt_testreporting_wl_vw as lab")
            ->select(
                "lab.item_no_fk",
                "lab.sam_name as sam_name",
                "lab.serviceunit_name",
                "lab.report_uid",
                "lab.interpretation",
                "lab.comments_text",
                "lab.note_text",
                "lab.result_prepared_keyed_by",
                "lab.result_verify_keyed_by",
                "lab.result_final_keyed_by",
                "lab.result_ent_keyed_by",
                "lab.report_no_pk",
                "lab.analyzer_desc",
                "lab.invoice_no_fk",
                'lab.result',
                'lab.reference_value'
            )
            ->leftjoin('sysc_serviceitem_vw as ser', 'lab.item_no_fk', 'ser.item_no_pk')
            // ->where('lab.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("lab.report_no_pk", $report_id)
            ->first();

        $result_item = DB::select(DB::raw("select test_name_list from labt_samplelabrcv_wl_vw where lab_uid = $lab_id
                and au_entry_hospital_pk_no = $hospital_id  and cancel_ind is null"));

        $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind", $result_info->su_no_fk);
        $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind", $result_info->su_no_fk);
        $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind", $result_info->su_no_fk);
        $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind", $result_info->su_no_fk);
        $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind", $result_info->su_no_fk);
        return Template::loadview("admin.pathology.result_entry_afb", [
            "report_id" => $report_id,
            "result_info" => $result_info,
            "result_info_1" => $result_info_1,
            "patient_info" => $patient_info,
            "result_test_info" => $result_test_info,
            "prepared_by_columns" => $prepared_by,
            "verified_by_columns" => $verified_by,
            "finalize_by_columns" => $finalize_by,
            "type" => $type,
            "result_item" => $result_item,
            'lab_id' => $lab_id,
            "consult" => $consult,
            "consult2" => $consult2,
            "labt_testresultstruct" => $labt_testresultstruct

        ]);
    }



    public function storeResultAfb(Request $request)
    {
        $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();
        //  dd($request->all());

        DB::beginTransaction();
        try {
            $result_note        = $request->result_note;
            $hdn_report_id      = $request->hdn_report_id;
            $hdn_invoice_id      = $request->hdn_invoice_id;
            $hdn_item_id      = $request->hdn_item_id;
            $result_prepared_by   = $request->result_prepared_by;
            $result_verified_by   = $request->result_verified_by;
            $result_finalize_by   = $request->result_finalize_by;

            $orgnsm_name_1   = $request->orgnsm_name_1;
            $orgnsm_name_2   = $request->orgnsm_name_2;
            $orgnsm_name_3   = $request->orgnsm_name_3;
            $orgnsm_name_4   = $request->orgnsm_name_4;
            $incu_temp   = $request->incu_temp;
            $incu_time   = $request->incu_time;
            $incu_cond   = $request->incu_cond;
            $colony_count   = $request->colony_count;

            $testresult_no_pk   = $request->testresult_no_pk;
            $testresult_value   = $request->testresult_value;
            $result             = $request->result;
            $show_in_rep        = $request->show_in_rep;

            // for GMC
            $mic_data   = $request->mic_data;
            $grm_stain   = $request->grm_stain;
            $sensitivity   = $request->sensitivity;
            $bio_test   = $request->bio_test;
            $rbc   = $request->rbc;
            $epithelial   = $request->epithelial;
            $pus_cells   = $request->pus_cells;
            $gram_diplococci   = $request->gram_diplococci;
            $candida   = $request->candida;
            $result   = $request->result;
            $normal_ref_value   = $request->normal_ref_value;
            // End
            //  dd($testresult_no_pk,$testresult_value, $result,$show_in_rep );
            $ids = [];
            DB::table('labt_testresult')->where('report_no_fk', $hdn_report_id)->delete();
            if (!empty($show_in_rep)) {
                for ($i = 0; $i < count($show_in_rep); $i++) {
                    // dd($show_in_rep_val)
                    $result_data = explode('_', $show_in_rep[$i]);
                    $sequence = DB::getSequence();
                    $testresult_no_pk_seq = $sequence->nextValue('testresult_no_pk_seq');
                    $show_in_rep_val = 0;
                    $ss = 'show_in_rep_' . $testresult_no_pk[$i];

                    $reuslt_entry = DB::table('labt_testresult')->where('report_no_fk', $hdn_report_id)->where('teststruct_no_fk', $result_data[1])->first();
                    $id = isset($reuslt_entry->teststruct_no_fk) && !empty($reuslt_entry->teststruct_no_fk) ? $reuslt_entry->teststruct_no_fk : "";
                    // dd( $reuslt_entry);
                    $data = [
                        // 'testresult_no_pk' => $testresult_no_pk_seq,
                        'testresult_code' => 'R' . ($testresult_no_pk_seq + 1), //'R'.$testresult_no_pk_seq
                        'report_no_fk' => $hdn_report_id,
                        'item_no_fk' => $hdn_item_id,
                        'invoice_no_fk' => $hdn_invoice_id,
                        'au_entry_hospital_pk_no' => $ses_hospital_id,
                        'au_entry_session' => 'Session',
                        // 'au_entry_at' => date("Y-m-d"),
                        'au_entry_by' => $auth_id,

                        'result0'       => $result_data[2],
                        'attr'       => $result_data[0],
                        'teststruct_no_fk' => $result_data[1],
                        'show_in_rep'   => 1, //isset($show_in_rep[$i]) ? 1 :0

                    ];
                    if ($id == "") {
                        // dd($data);
                        $data['au_entry_by'] = $auth_id;
                        $this->labtestresult->create($data);
                    } else {
                        $data['au_update_by'] = $auth_id;
                        LabTestResult::where('report_no_fk', $hdn_report_id)->where('teststruct_no_fk', $result_data[1])->update($data);
                    }
                }
            }
            if ($request->action_type == "prepare") {
                $report_data = [
                    'result_prepared_key_ind'    => 1,
                    'result_prepared_keyed_by'   => $result_prepared_by,
                    'result_prepared_keyed_time' => date("Y-m-d"),
                    'organism_a'               => $orgnsm_name_1,
                    'organism_b'               => $orgnsm_name_2,
                    'organism_c'             => $orgnsm_name_3,
                    // 'organism_b_u'             => $orgnsm_name_4,
                    'incubation_temp'          => $incu_temp,
                    'incubation_time'          => $incu_time,
                    'incubation_condition'     => $incu_cond,
                    'colony_count'             => $colony_count,
                    'note_text'                => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_prepared_key_ind'    => 1,
                    'lab_result_prepared_keyed_by'   => $result_prepared_by,
                    'lab_result_prepared_keyed_time' => date("Y-m-d"),
                    'au_update_hospital_pk_no'       => $ses_hospital_id,
                ];
            }

            if ($request->action_type == "verifiy") {
                $report_data = [
                    'result_verify_key_ind'      => 1,
                    'result_verify_keyed_by'     => $result_verified_by,
                    'result_verify_keyed_time'   => date("Y-m-d"),
                    'organism_a'                 => $orgnsm_name_1,
                    'organism_b'                 => $orgnsm_name_2,
                    'organism_c'               => $orgnsm_name_3,
                    // 'organism_b_u'               => $orgnsm_name_4,
                    'incubation_temp'            => $incu_temp,
                    'incubation_time'            => $incu_time,
                    'incubation_condition'       => $incu_cond,
                    'colony_count'               => $colony_count,
                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no'   => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_verify_key_ind'    => 1,
                    'lab_result_verify_keyed_by'   => $result_verified_by,
                    'lab_result_verify_keyed_time' => date("Y-m-d"),
                    'au_update_hospital_pk_no'     => $ses_hospital_id,
                ];
            }

            if ($request->action_type == "finalize") {
                $report_data = [
                    'result_final_key_ind'       => 1,
                    'result_final_keyed_by'      => $result_finalize_by,
                    'result_final_keyed_time'    => date("Y-m-d"),
                    // 'organism_a'                 => $orgnsm_name_1,
                    // 'organism_b'                 => $orgnsm_name_2,
                    // 'organism_c'               => $orgnsm_name_3,
                    // // 'organism_b_u'               => $orgnsm_name_4,
                    // 'incubation_temp'            => $incu_temp,
                    // 'incubation_time'            => $incu_time,
                    // 'incubation_condition'       => $incu_cond,
                    // 'colony_count'               => $colony_count,
                    'note_text'                  => $result_note,
                    // 'au_update_hospital_pk_no'   => $ses_hospital_id,

                    // 'microscope_examination'     => $mic_data,
                    // 'gram_stain_smear'           => $grm_stain,
                    // 'sensitivity'                => $sensitivity,
                    // 'biochemical_test'           => $bio_test,
                    // 'rbc'                        => $rbc,
                    // 'epithelialv'                => $epithelial,
                    // 'pus_cells'                  => $pus_cells,
                    // 'gram_diplococci'            => $gram_diplococci,
                    // 'candida'                    => $candida,

                    'result'                    => $result,
                    'reference_value'           => $normal_ref_value,



                ];
                if (in_array(Session::get('user.ses_hospital_code'), ["AMCSH"])) {
                    $report_data['result_prepared_key_ind']    = 1;
                    $report_data['result_prepared_keyed_by']   = $result_prepared_by;
                    $report_data['result_prepared_keyed_time'] = date("Y-m-d");
                    $report_data['result_verify_key_ind']      = 1;
                    $report_data['result_verify_keyed_by']     = $result_verified_by;
                    $report_data['result_verify_keyed_time']   = date("Y-m-d");
                    $report_data['result_ent_key_ind']       = 1;
                    $report_data['result_ent_keyed_by']      = $request->consultant;
                    $report_data['result_ent_keyed_time']    = date("Y-m-d");
                    $report_data['result_con_key_ind'] = 1;
                    $report_data['result_con_keyed_by'] = $request->consultant2;
                    $report_data['result_con_keyed_time'] = date("Y-m-d");
                }
                $invoice_data = [
                    'lab_result_final_key_ind'    => 1,
                    'lab_result_final_keyed_by'   => $result_finalize_by,
                    'lab_result_final_keyed_time' => date("Y-m-d"),
                    'au_update_hospital_pk_no' => $ses_hospital_id,

                ];
                if (in_array(Session::get('user.ses_hospital_code'), ["AMCSH"])) {
                    $invoice_data['lab_result_prepared_key_ind']    = 1;
                    $invoice_data['lab_result_prepared_keyed_by']   = $result_prepared_by;
                    $invoice_data['lab_result_prepared_keyed_time'] = date("Y-m-d");
                    $invoice_data['lab_result_verify_key_ind']    = 1;
                    $invoice_data['lab_result_verify_keyed_by']   = $result_verified_by;
                    $invoice_data['lab_result_verify_keyed_time'] = date("Y-m-d");
                    $invoice_data['lab_result_entry_key_ind']    = 1;
                    $invoice_data['lab_result_entry_keyed_by']   = $request->consultant;
                    $invoice_data['lab_result_entry_keyed_time'] = date("Y-m-d");
                    $invoice_data['lab_result_con_key_ind'] = 1;
                    $invoice_data['lab_result_con_keyed_by'] = $request->consultant2;
                    $invoice_data['lab_result_con_keyed_time'] = date("Y-m-d");
                }

                if (in_array(Session::get('user.ses_hospital_code'), ["UNICO", "DMHL"])) {
                    $data = array();
                    $data['report_rcb_ind'] = 1;
                    // $data['report_rcb_keyed_by'] = Auth::id();
                    $data['report_rcb_keyed_time'] = new DateTime('now');
                    $data['au_update_by'] =  $auth_id;
                    $data['au_update_at'] = date('Y-m-d');
                    $data['au_update_session'] = 'report receive';
                    $data['au_update_hospital_pk_no'] = $ses_hospital_id;
                    // DB::table('labt_testreporting')->where('report_no_pk', $hdn_report_id)->update($data);

                    $data['report_procees_ind'] = 1;
                    // $data['report_procees_keyed_by'] = Auth::id();
                    $data['report_procees_keyed_time'] = new DateTime('now');
                    // $data = array();
                    $data['report_deli_pending_ind'] = 1;
                    $data['au_entry_by'] = Auth::id();
                    $data['au_entry_at'] = new DateTime('now');
                    $data['au_entry_session'] = 'session';



                    DB::table('labt_testreporting')->where('report_no_pk', $hdn_report_id)->update($data);
                }
            }
            if ($request->action_type == "consultant") {

                $report_data = [
                    'result_ent_key_ind'       => 1,
                    'result_ent_keyed_by'      => $request->consultant,
                    'result_ent_keyed_time'    => date("Y-m-d"),
                    'organism_a'               => $orgnsm_name_1,
                    'organism_b'               => $orgnsm_name_2,
                    'organism_c'             => $orgnsm_name_3,
                    // 'organism_b_u'             => $orgnsm_name_4,
                    'incubation_temp'          => $incu_temp,
                    'incubation_time'          => $incu_time,
                    'incubation_condition'     => $incu_cond,
                    'colony_count'             => $colony_count,
                    'note_text'                => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_entry_key_ind'    => 1,
                    'lab_result_entry_keyed_by'   => $request->consultant,
                    'lab_result_entry_keyed_time' => date("Y-m-d"),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];
            }

            $saveDate=   Db::table("labt_testreporting")->where("report_no_pk", $hdn_report_id)->update($report_data);
            LabInvoiceDtl::where("report_no_fk", $hdn_report_id)->update($invoice_data);

            if ($saveDate > 0) {
               $this->sendSmsMail($hdn_report_id,$request->action_type, $saveDate);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }


    public function resultAfbPdf($report_id,$draft="",$type="")
    {
        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        try {
            $report_header = DB::table("labt_testreportresultprint_vw")->where('report_no_pk', $report_id)->first();
            // dd($report_header);
            $result_prepared_by = Auth::id();
            $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
            $invoice_data = [
                'lab_result_print_key_ind' => 1,
                'lab_result_print_keyed_by' => $result_prepared_by,
                'lab_result_print_keyed_time' => date("Y-m-d"),
                'au_update_hospital_pk_no' => $ses_hospital_id,
            ];
            LabInvoiceDtl::where("report_no_fk", $report_id)->update($invoice_data);

            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {

                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }

            $report_data = DB::table("labt_testresultstruct_vw")
                ->select('attr', 'result0')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->skip(0)->take(9)->get()->toArray();

            $report_data_1 = DB::table("labt_testresultstruct_vw")
                ->select('attr', 'result0')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->skip(10)->take(18)->get()->toArray();




            $incuvation_dt = DB::select(DB::raw("SELECT
                                                lab.REFERENCE_VALUE,
                                                lab.RESULT
                                            FROM labt_testreporting lab where lab.report_no_pk = $report_id"));
            // dd($incuvation_dt);
            $po_hospital_details = DB::table("wsec_hospital")->first();


            return view("admin.pathology.path_afb_report", ['incuvation_dt' => $incuvation_dt, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'report_data_1' => $report_data_1,'draft'=>$draft])->render();

            if ($type==1) {
                $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
            }

        } catch (\Exception $e) {
            DB::rollback();
            // $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // return $pdf->stream("MC-$report_id.pdf");
        // return @\PDF::loadHTML($html, 'utf-8')->stream();

    }


    // CSF Report
    public function resultCsfForm($report_id, $type = 1, $lab_id = '')
    {
        $hospital_id =   Session::get('user.ses_hospital_no_pk');
        $patient_info = [];
        $result_info = DB::table("labt_testreporting_wl_vw")->where("report_no_pk", $report_id)->first();
        if (!empty($result_info)) {
            $prescription_id = $result_info->invoice_no_fk;

            $patient_info = DB::table("labt_invoicedtl_vw a")
                ->select("b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "b.pat_relation", "b.ref_patient_gender", "b.ref_blood_group", "b.ref_age", "b.blood_group_txt", "b.mobile1")
                ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                ->where("a.invoice_no_fk", $prescription_id)->first();
        }

        $result_test_info = DB::table("labt_testresultstruct_vw")->where("report_no_fk", $report_id)->orderBy('sl_no', 'ASC')->get()->toArray();

        $result_item = DB::select(DB::raw("select test_name_list from labt_samplelabrcv_wl_vw where lab_uid = $lab_id
        and au_entry_hospital_pk_no = $hospital_id  and cancel_ind is null"));

        // $prepared_by = $this->getPathologyResultEntryByUser("save_ind");
        // $verified_by = $this->getPathologyResultEntryByUser("verify_ind");
        // $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind");
        $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind", $result_info->su_no_fk);
        $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind", $result_info->su_no_fk);
        $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind", $result_info->su_no_fk);
        $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind", $result_info->su_no_fk);
        $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind", $result_info->su_no_fk);


        $analyzer = DB::table('sysc_serviceitem')->select('item_code', 'item_name', 'interpretation')->where('analyzer_ind', 1)->get();

        $default_values = DB::table('labs_teststructval')->where('status', 1)->orderBy('sl_no', 'asc')->get();
        return Template::loadview("admin.pathology.result_entry_form_2column", ["report_id" => $report_id, "result_info" => $result_info, "patient_info" => $patient_info, "result_test_info" => $result_test_info, "prepared_by_columns" => $prepared_by, "verified_by_columns" => $verified_by, "finalize_by_columns" => $finalize_by, "type" => $type, 'result_item' => $result_item, 'lab_id' => $lab_id, 'analyzer' => $analyzer, 'default_values' => $default_values, 'consult' => $consult, 'consult2' => $consult2]);
    }
    public function resultCsfPdf($report_id,$draft="",$type="")
    {
        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        try {



            $report_header = DB::table("labt_testreportresultprint_vw")->where('report_no_pk', $report_id)->first();
            // dd($report_header);
            $result_prepared_by = Auth::id();
            $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
            $invoice_data = [
                'lab_result_print_key_ind' => 1,
                'lab_result_print_keyed_by' => $result_prepared_by,
                'lab_result_print_keyed_time' => date("Y-m-d"),
                'au_update_hospital_pk_no' => $ses_hospital_id,
            ];
            LabInvoiceDtl::where("report_no_fk", $report_id)->update($invoice_data);

            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {

                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }

            $report_data = DB::table("labt_testresultstruct_vw")
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->get()->toArray();

            //    dd($report_header);

            $attr_group = [];
            foreach ($report_data as $value) {
                $attr_group[$value->item_no_fk . '-' . $value->item_name][$value->test_group_no_fk . '-' . $value->group_txt][] = $value;
            }
            // dd($attr_group);
            $po_hospital_details = DB::table("wsec_hospital")->first();

            $pdf = PDF::loadView("admin.pathology.csf_report_pdf", ["po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'attr_group' => $attr_group,'draft'=>$draft]);

            if ($type==1) {
                $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
            }

        } catch (\Exception $e) {
            DB::rollback();
            // $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return $pdf->stream("BC-$report_id.pdf");
    }
    public function  getTypeWiseMicrobiologyReport(Request  $request)
    {
        $hospital = DB::table('wsec_hospital')
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->first();
        $result_test_info = DB::table('microbiology_antibiotic')->where('status', 1)->orderBy('microbiology_no_pk', 'asc')->get();
        if ($request->organism_type == 2 && $request->orgnsm_name_2 != "") {

            return Template::loadView("admin.pathology.microbiology.microbiology_two_columns_report", [
                "result_test_info" => $result_test_info,
                "hospital" => $hospital,
                "orgnsm_name_1" => $request->orgnsm_name_1,
                "orgnsm_name_2" => $request->orgnsm_name_2
            ]);
        } else {
            if ($request->organism_type != 3) {
                return Template::loadView("admin.pathology.microbiology.microbiology_single_columns_report", [
                    "result_test_info" => $result_test_info,
                    "hospital" => $hospital,
                    "orgnsm_name_1" => $request->orgnsm_name_1,
                    "orgnsm_name_2" => $request->orgnsm_name_2
                ]);
            }
        }
        if ($request->organism_type == 3 && $request->orgnsm_name_3 != "") {
            return Template::loadView("admin.pathology.microbiology.microbiology_three_columns_report", [
                "result_test_info" => $result_test_info,
                "hospital" => $hospital,
                "orgnsm_name_1" => $request->orgnsm_name_1,
                "orgnsm_name_2" => $request->orgnsm_name_2,
                "orgnsm_name_3" => $request->orgnsm_name_3
            ]);
        } else {
            return Template::loadView("admin.pathology.microbiology.microbiology_two_columns_report", [
                "result_test_info" => $result_test_info,
                "hospital" => $hospital,
                "orgnsm_name_1" => $request->orgnsm_name_1,
                "orgnsm_name_2" => $request->orgnsm_name_2
            ]);
        }
    }

    public function histopathResultEntryFormMic($report_id, $type = 1, $lab_id)
    {
        $patient_info = [];
        $result_info_0 = DB::table("labt_testreporting_wl_vw")
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("report_no_pk", $report_id)
            ->whereNull('cancel_ind')
            ->first();


        if (!empty($result_info_0)) {
            $prescription_id = $result_info_0->invoice_no_fk;

            $patient_info = DB::table("labt_invoicedtl_vw a")
                ->select("b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "b.pat_relation", "b.ref_patient_gender", "b.ref_blood_group", "b.ref_age", "b.blood_group_txt", "b.mobile1")
                ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where("a.invoice_no_fk", $prescription_id)->first();
        }
        $hospital_id =   Session::get('user.ses_hospital_no_pk');
        $result_test_info = DB::table('microbiology_antibiotic')->where('status', 1)->orderBy('microbiology_no_pk', 'asc')->get();

        $labt_testresultstruct = DB::table('labt_testresultstruct_vw')->where('report_no_fk', $report_id)->get();
        // dd($result_test_info);

        $result_info = DB::table("labt_testreporting_wl_vw as lab")
            ->select(
                "lab.item_no_fk",
                "lab.sam_name as sam_name",
                "lab.su_no_fk",
                "lab.serviceunit_name",
                "lab.report_uid",
                "lab.interpretation",
                "lab.comments_text",
                "lab.note_text",
                "lab.result_prepared_keyed_by",
                "lab.result_verify_keyed_by",
                "lab.result_final_keyed_by",
                "lab.result_ent_keyed_by",
                "lab.report_no_pk",
                "lab.analyzer_desc",
                "lab.invoice_no_fk",
                "lab.histro_lab_id",
                "lab.histro_report_header",
                "lab.note_text_clob",
                "ser.report_header",
                "lab.lab_code",
            )
            ->leftjoin('sysc_serviceitem_vw as ser', 'lab.item_no_fk', 'ser.item_no_pk')
            // ->where('lab.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("lab.report_no_pk", $report_id)
            ->first();
        // dd( $report_id,$result_info);
        $result_info_1 = DB::table("labt_testreporting_wl_vw as lab")
            ->select(
                "lab.item_no_fk",
                "lab.sam_name as sam_name",
                "lab.serviceunit_name",
                "lab.report_uid",
                "lab.interpretation",
                "lab.comments_text",
                "lab.note_text",
                "lab.result_prepared_keyed_by",
                "lab.result_verify_keyed_by",
                "lab.result_final_keyed_by",
                "lab.result_ent_keyed_by",
                "lab.report_no_pk",
                "lab.analyzer_desc",
                "lab.invoice_no_fk",
                "lab.organism_a",
                "lab.organism_b",
                "lab.organism_a_u",
                "lab.organism_b_u",
                "lab.organism_c",
                "lab.organism_c_u",
                "lab.incubation_temp",
                "lab.incubation_condition",
                "lab.colony_count",
                "lab.incubation_time",
                'lab.test_method',
                'lab.gram_stain_smear',
                'lab.epithelialv',
                'lab.biochemical_test',
                'lab.identity_mark',
                'lab.pus_cells',
                'lab.rbc',
                'lab.structure',
                'lab.microscope_examination',
                'lab.sensitivity',
            )
            ->leftjoin('sysc_serviceitem_vw as ser', 'lab.item_no_fk', 'ser.item_no_pk')
            // ->where('lab.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("lab.report_no_pk", $report_id)
            ->first();


        $rs_dt = DB::select(DB::raw("select lab.*,sys.* from labt_testresultstruct_vw lab
            left join sysc_serviceitem_vw sys
            on lab.item_no_fk = sys.item_no_pk
            where lab.report_no_fk = $report_id
            and lab.au_entry_hospital_pk_no = $hospital_id
            and lab.cancel_ind is null order by lab.item_name Asc,sl_no ASC"));

        $result_item = DB::select(DB::raw("select test_name_list from labt_samplelabrcv_wl_vw where lab_uid = $lab_id
                and au_entry_hospital_pk_no = $hospital_id  and cancel_ind is null"));


        $analyzer = DB::table('sysc_serviceitem')->select('item_code', 'item_name', 'interpretation')->where('analyzer_ind', 1)->get();




        // dd($result_info->su_no_fk);
        $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind", $result_info->su_no_fk);
        $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind", $result_info->su_no_fk);
        $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind", $result_info->su_no_fk);
        $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind", $result_info->su_no_fk);
        $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind", $result_info->su_no_fk);
        // dd($consult);


        $incubationtime = $this->getLookupListByCode("INCUBATIONTIME");
        $incubationtemp = $this->getLookupListByCode("INCUBATIONTEMP");
        $incubationcolonycount = $this->getLookupListByCode("INCUBATIONCOLONYCOUNT");
        $incubationcond = $this->getLookupListByCode("INCUBATIONCOND");
        $rbc = $this->getLookupListByCode("RBC");


        $antivitic = DB::table("microbiology_antibiotic")->where('status', 1)->orderBy('microbiology_no_pk', 'asc')->get();
        $becteria = DB::table("microbiology_bacteria")->where('status', 1)->get();

        // FOR gmc
        $microscope = $this->getLookupListByCode("MICROSCOPEEXAMINATION");
        $gramstain = $this->getLookupListByCode("GRAMSTAIN");
        $sensityvity = $this->getLookupListByCode("SENSITYVITY");
        $biochemical_test = $this->getLookupListByCode("BIOCHEMICALTEST");
        $templateNames = DB::table('labs_testtemplate')->select('temp_name', 'note', 'histopath_note_clob')->where('note_ind', 1)->where('status', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->orderBy('AU_ENTRY_AT', 'asc')->get();
        // $templateNames = [];

        return Template::loadview("admin.pathology.result_entry_form_histro", [
            "report_id" => $report_id,
            "result_info" => $result_info,
            "rs_dt" => $rs_dt,
            "result_info_1" => $result_info_1,
            "patient_info" => $patient_info,
            "result_test_info" => $result_test_info,
            "prepared_by_columns" => $prepared_by,
            "verified_by_columns" => $verified_by,
            "finalize_by_columns" => $finalize_by,
            "type" => $type,
            "result_item" => $result_item,
            'lab_id' => $lab_id,
            'analyzer' => $analyzer,
            "incubationtime" => $incubationtime,
            "incubationtemp" => $incubationtemp,
            "incubationcolonycount" => $incubationcolonycount,
            "incubationcond" => $incubationcond,
            "antivitic" => $antivitic,
            "becteria" => $becteria,
            "microscope" => $microscope,
            "gramstain" => $gramstain,
            "sensityvity" => $sensityvity,
            "rbc" => $rbc,
            "biochemical_test" => $biochemical_test,
            "consult" => $consult,
            "consult2" => $consult2,
            "labt_testresultstruct" => $labt_testresultstruct,
            "templateNames" => $templateNames
        ]);
    }


    public function histopathStoreResultEntry(Request $request)
    {
        $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();
        // dd($request->all());
        $dt = new DateTime('now', new \DateTimeZone('Asia/Dhaka'));
        $date = $dt->format('Y-m-d H:i:s');
        DB::beginTransaction();
        try {
            $result_note        = $request->result_note;
            $result_comm        = $request->result_comm;
            $hdn_report_id      = $request->hdn_report_id;
            $hdn_invoice_id      = $request->hdn_invoice_id;
            $hdn_item_id      = $request->hdn_item_id;
            $result_prepared_by   = $request->result_prepared_by;
            $result_verified_by   = $request->result_verified_by;
            $result_finalize_by   = $request->result_finalize_by;

            $orgnsm_name_1   = $request->orgnsm_name_1;
            $orgnsm_name_2   = $request->orgnsm_name_2;
            $orgnsm_name_3   = $request->orgnsm_name_3;
            $orgnsm_name_4   = $request->orgnsm_name_4;
            $incu_temp   = $request->incu_temp;
            $incu_time   = $request->incu_time;
            $incu_cond   = $request->incu_cond;
            $colony_count   = $request->colony_count;

            $testresult_no_pk   = $request->testresult_no_pk;
            $testresult_value   = $request->testresult_value;
            $result             = $request->result;
            $show_in_rep        = $request->show_in_rep;

            // for GMC
            $mic_data   = $request->mic_data;
            $grm_stain   = $request->grm_stain;
            $sensitivity   = $request->sensitivity;
            $bio_test   = $request->bio_test;
            $rbc   = $request->rbc;
            $epithelial   = $request->epithelial;
            $pus_cells   = $request->pus_cells;
            // End
            //  dd($testresult_no_pk,$testresult_value, $result,$show_in_rep );
            $ids = [];



            if ($request->action_type == "prepare") {
                $report_data = [
                    'result_prepared_key_ind'    => 1,
                    'result_prepared_keyed_by'   => $result_prepared_by,
                    'result_prepared_keyed_time' => new DateTime('now'),
                    'sam_name' => $request->sam_name,
                    'histro_lab_id' => $request->histro_lab_id,
                    'histro_report_header' => $request->histro_lab_id,
                    'note_text_clob'                => $result_note,
                    'comments_text'                => $result_comm,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_prepared_key_ind'    => 1,
                    'lab_result_prepared_keyed_by'   => $result_prepared_by,
                    'lab_result_prepared_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no'       => $ses_hospital_id,
                ];
            }

            if ($request->action_type == "verifiy") {
                $report_data = [
                    // 'result_verify_key_ind'      => 1,
                    // 'result_verify_keyed_by'     => $result_verified_by,
                    // 'result_verify_keyed_time'   => new DateTime('now'),
                    'sam_name' => $request->sam_name,
                    'histro_lab_id' => $request->histro_lab_id,
                    'histro_report_header' => $request->histro_lab_id,
                    'note_text_clob'                  => $result_note,
                    'comments_text'                => $result_comm,
                    'au_update_hospital_pk_no'   => $ses_hospital_id,
                ];

                $invoice_data = [
                    // 'lab_result_verify_key_ind'    => 1,
                    // 'lab_result_verify_keyed_by'   => $result_verified_by,
                    // 'lab_result_verify_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no'     => $ses_hospital_id,
                ];
                if ($request->hdn_draft_id !=1) {
                    $report_data['result_verify_key_ind'] = 1;
                    $report_data['result_verify_keyed_by']   = $result_verified_by;
                    $report_data['result_verify_keyed_time']  = new DateTime('now');
                    $invoice_data['lab_result_verify_key_ind'] = 1;
                    $invoice_data['lab_result_verify_keyed_by']   = $result_verified_by;
                    $invoice_data['lab_result_verify_keyed_time'] = new DateTime('now');
                }
            }

            if ($request->action_type == "finalize") {
                $report_data = [
                    // 'result_final_key_ind'       => 1,
                    // 'result_final_keyed_by'      => $result_finalize_by,
                    // 'result_final_keyed_time'    => $date,
                    'sam_name' => $request->sam_name,
                    'histro_lab_id' => $request->histro_lab_id,
                    'histro_report_header' => $request->histro_report_header,
                    // 'note_text'                  => $result_note,
                    'note_text_clob'                  => $result_note,
                    'comments_text'                => $result_comm,
                    'au_update_hospital_pk_no'   => $ses_hospital_id,

                    'microscope_examination'     => $mic_data,
                    'gram_stain_smear'           => $grm_stain,
                    'sensitivity'                => $sensitivity,
                    'biochemical_test'           => $bio_test,
                    'rbc'                        => $rbc,
                    'epithelialv'                => $epithelial,
                    'pus_cells'                  => $pus_cells,

                ];
                if (in_array(Session::get('user.ses_hospital_code'), ["AMCSH"])) {
                    $report_data['result_prepared_key_ind']    = 1;
                    $report_data['result_prepared_keyed_by']   = $result_prepared_by;
                    $report_data['result_prepared_keyed_time'] = new DateTime('now');
                    $report_data['result_verify_key_ind']      = 1;
                    $report_data['result_verify_keyed_by']     = $result_verified_by;
                    $report_data['result_verify_keyed_time']   = new DateTime('now');
                    $report_data['result_ent_key_ind']       = 1;
                    $report_data['result_ent_keyed_by']      = $request->consultant;
                    $report_data['result_ent_keyed_time']    = new DateTime('now');
                    $report_data['result_con_key_ind'] = 1;
                    $report_data['result_con_keyed_by'] = $request->consultant2;
                    $report_data['result_con_keyed_time'] = new DateTime('now');
                }
                $invoice_data = [
                    // 'lab_result_final_key_ind'    => 1,
                    // 'lab_result_final_keyed_by'   => $result_finalize_by,
                    // 'lab_result_final_keyed_time' => $date,
                    'au_update_hospital_pk_no' => $ses_hospital_id,

                ];
                if (in_array(Session::get('user.ses_hospital_code'), ["AMCSH"])) {
                    $invoice_data['lab_result_prepared_key_ind']    = 1;
                    $invoice_data['lab_result_prepared_keyed_by']   = $result_prepared_by;
                    $invoice_data['lab_result_prepared_keyed_time'] = new DateTime('now');
                    $invoice_data['lab_result_verify_key_ind']    = 1;
                    $invoice_data['lab_result_verify_keyed_by']   = $result_verified_by;
                    $invoice_data['lab_result_verify_keyed_time'] = new DateTime('now');
                    $invoice_data['lab_result_entry_key_ind']    = 1;
                    $invoice_data['lab_result_entry_keyed_by']   = $request->consultant;
                    $invoice_data['lab_result_entry_keyed_time'] = new DateTime('now');
                    $invoice_data['lab_result_con_key_ind'] = 1;
                    $invoice_data['lab_result_con_keyed_by'] = $request->consultant2;
                    $invoice_data['lab_result_con_keyed_time'] = new DateTime('now');
                }
                if (in_array(Session::get('user.ses_hospital_code'), ["UNICO", "DMHL"])) {
                    $data = array();

                    // $data['report_rcb_keyed_by'] = Auth::id();
                    $data['report_rcb_keyed_time'] = new DateTime('now');
                    $data['au_update_by'] =  $auth_id;
                    $data['au_update_at'] = date('Y-m-d');
                    $data['au_update_session'] = 'report receive';
                    $data['au_update_hospital_pk_no'] = $ses_hospital_id;
                    // DB::table('labt_testreporting')->where('report_no_pk', $hdn_report_id)->update($data);


                    // $data['report_procees_keyed_by'] = Auth::id();
                    $data['report_procees_keyed_time'] = new DateTime('now');

                    // $data = array();

                    $data['au_entry_by'] = Auth::id();
                    $data['au_entry_at'] = new DateTime('now');
                    $data['au_entry_session'] = 'session';
                    DB::table('labt_testreporting')->where('report_no_pk', $hdn_report_id)->update($data);
                }

                 if ($request->hdn_draft_id !=1) {
                     $report_data['result_final_key_ind'] = 1;
                     $report_data['result_final_keyed_by']      = $result_finalize_by;
                     $report_data['result_final_keyed_time']    = $date;
                     $invoice_data['lab_result_final_key_ind'] = 1;
                     $invoice_data['lab_result_final_keyed_by']   = $result_finalize_by;
                     $invoice_data['lab_result_final_keyed_time'] = $date;
                     $data['report_rcb_ind'] = 1;
                     $data['report_procees_ind'] = 1;
                     $data['report_deli_pending_ind'] = 1;
                }
            }
            if ($request->action_type == "consultant") {

                $report_data = [
                    'result_ent_key_ind'       => 1,
                    'result_ent_keyed_by'      => $request->consultant,
                    'result_ent_keyed_time'    => new DateTime('now'),
                    'sam_name' => $request->sam_name,
                    'histro_lab_id' => $request->histro_lab_id,
                    'note_text_clob'               => $result_note,
                    'comments_text'                => $result_comm,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_entry_key_ind'    => 1,
                    'lab_result_entry_keyed_by'   => $request->consultant,
                    'lab_result_entry_keyed_time' => new DateTime('now'),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];
            }

            $saveDate=  DB::table("labt_testreporting")->where("report_no_pk", $hdn_report_id)->update($report_data);
            LabInvoiceDtl::where("report_no_fk", $hdn_report_id)->update($invoice_data);

            if ($saveDate > 0) {
               $this->sendSmsMail($hdn_report_id,$request->action_type, $saveDate);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function resultEntryPdfPcr($report_id = "",$draft="" ,$type="")
    {
        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        try {
            $report_header = DB::table("labt_testreportresultprint_vw")->where('report_no_pk', $report_id)->first();
            $report_header1 =  DB::table("labt_testreporting")->where("report_no_pk", $report_id)->first();
            // dd($report_header);
            $result_prepared_by = Auth::id();
            $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
            $invoice_data = [
                'lab_result_print_key_ind' => 1,
                'lab_result_print_keyed_by' => $result_prepared_by,
                'lab_result_print_keyed_time' => new DateTime('now'),
                'au_update_hospital_pk_no' => $ses_hospital_id,
            ];
            LabInvoiceDtl::where("report_no_fk", $report_id)->update($invoice_data);

            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {

                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }

            $report_data = DB::table("labt_testresultstruct_vw")
                ->select('attr', 'result0', 'result1', 'result2')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('teststruct_no_fk', 'ASC')
                // ->skip(0)->take(9)
                // ->where('result0','I')
                ->get()->toArray();
            $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->first();
            $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';
            $report_data_1 = DB::table("labt_testresultstruct_vw")
                ->select('attr', 'result0', 'result1', 'result2')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                // ->skip(10)->take(18)
                ->where('result0', 'S')
                ->get()->toArray();

            $report_data_2 = DB::table("labt_testresultstruct_vw")
                ->select('attr', 'result0', 'result1', 'result2')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                // ->skip(10)->take(18)
                ->where('result0', 'R')
                ->get()->toArray();




            $incuvation_dt = DB::select(DB::raw("select dt1.lookupdata_name incubation_temp,
                                                dt2.lookupdata_name incubation_condition,
                                                dt3.lookupdata_name colony_count,
                                                dt4.lookupdata_name incubation_time,
                                                dt4.lookupdata_name stucture,
                                                dt6.lookupdata_name sensitivity,
                                                dt7.lookupdata_name biochemical_test,
                                                dt8.lookupdata_name gram_stain_smear,
                                                dt9.lookupdata_name microscope_examination,
                                                lab.rbc,
                                                lab.epithelialv,
                                                lab.pus_cells
                                                from labt_testreporting lab
                                                left join sysc_lookupdata dt1
                                                on lab.incubation_temp = dt1.lookupdata_no_pk
                                                left join sysc_lookupdata dt2
                                                on lab.incubation_condition = dt2.lookupdata_no_pk
                                                left join sysc_lookupdata dt3
                                                on lab.colony_count = dt3.lookupdata_no_pk
                                                left join sysc_lookupdata dt4
                                                on lab.incubation_time = dt4.lookupdata_no_pk
                                                left join sysc_lookupdata dt6
                                                on lab.sensitivity = dt6.lookupdata_no_pk
                                                left join sysc_lookupdata dt7
                                                on lab.biochemical_test = dt7.lookupdata_no_pk
                                                left join sysc_lookupdata dt8
                                                on lab.gram_stain_smear = dt8.lookupdata_no_pk
                                                left join sysc_lookupdata dt9
                                                on lab.microscope_examination = dt9.lookupdata_no_pk
                                                 where lab.report_no_pk = $report_id"));
            // dd(    $report_data , $incuvation_dt);
            // org.bacteria_name org_a left join microbiology_bacteria org   on lab.organism_a = org.bacteria_no_pk
            $po_hospital_details = DB::table("wsec_hospital")->first();
            // dd( $incuvation_dt);
            $result_organism = DB::table('labt_testreporting')->where('report_no_pk', $report_id)->first();

            $note_text_clob = DB::table('labt_testreporting')->select('note_text_clob')->where('report_no_pk', $report_id)->first()->note_text_clob;
            // dd($note_text_clob);

            return view("admin.pathology.biochemestry_report_pcr", ["note_text_clob" => $note_text_clob, "report_header1" => $report_header1, "result_organism" => $result_organism, "report_label" => $report_label, 'incuvation_dt' => $incuvation_dt, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'report_data_1' => $report_data_1, 'report_data_2' => $report_data_2,'draft'=>$draft])->render();


            // $pdf = pdf::loadview("admin.pathology.reports.histropathology.histropathology_report_pdf", ["report_header1" => $report_header1, "result_organism" => $result_organism, "report_label" => $report_label, 'incuvation_dt' => $incuvation_dt, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'report_data_1' => $report_data_1, 'report_data_2' => $report_data_2]);
            // return $pdf->stream("histopathology_report.pdf");

            if ($type==1) {
                $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
            }


        } catch (\Exception $e) {
            DB::rollback();
            // $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            //dd($e->getMessage());
        }
        // return $pdf->stream("MC-$report_id.pdf");
        // return @\PDF::loadHTML($html, 'utf-8')->stream();

    }

    public function histopathResultEntryPdf($report_id,$draft="",$type="")
    {
        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        try {

            $report_header = DB::table("labt_testreportresultprint_vw")->select('labt_testreportresultprint_vw.*','labt_testreporting.note_text_clob as note')->leftJoin('labt_testreporting','labt_testreporting.report_no_pk','=','labt_testreportresultprint_vw.report_no_pk')->where('labt_testreportresultprint_vw.report_no_pk', $report_id)->first();

            $report_header1 =  DB::table("labt_testreporting")->where("report_no_pk", $report_id)->first();
            // dd($report_header);
            $result_prepared_by = Auth::id();
            $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
            $invoice_data = [
                'lab_result_print_key_ind' => 1,
                'lab_result_print_keyed_by' => $result_prepared_by,
                'lab_result_print_keyed_time' => date("Y-m-d"),
                'au_update_hospital_pk_no' => $ses_hospital_id,
            ];
            LabInvoiceDtl::where("report_no_fk", $report_id)->update($invoice_data);

            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {

                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }

            $report_data = DB::table("labt_testresultstruct_vw")
                ->select('attr', 'result0', 'result1', 'result2')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('teststruct_no_fk', 'ASC')
                // ->skip(0)->take(9)
                // ->where('result0','I')
                ->get()->toArray();
            $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->first();
            $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';
            $report_data_1 = DB::table("labt_testresultstruct_vw")
                ->select('attr', 'result0', 'result1', 'result2')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                // ->skip(10)->take(18)
                ->where('result0', 'S')
                ->get()->toArray();

            $report_data_2 = DB::table("labt_testresultstruct_vw")
                ->select('attr', 'result0', 'result1', 'result2')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                // ->skip(10)->take(18)
                ->where('result0', 'R')
                ->get()->toArray();




            $incuvation_dt = DB::select(DB::raw("select dt1.lookupdata_name incubation_temp,
                                                dt2.lookupdata_name incubation_condition,
                                                dt3.lookupdata_name colony_count,
                                                dt4.lookupdata_name incubation_time,
                                                dt4.lookupdata_name stucture,
                                                dt6.lookupdata_name sensitivity,
                                                dt7.lookupdata_name biochemical_test,
                                                dt8.lookupdata_name gram_stain_smear,
                                                dt9.lookupdata_name microscope_examination,
                                                lab.rbc,
                                                lab.epithelialv,
                                                lab.pus_cells
                                                from labt_testreporting lab
                                                left join sysc_lookupdata dt1
                                                on lab.incubation_temp = dt1.lookupdata_no_pk
                                                left join sysc_lookupdata dt2
                                                on lab.incubation_condition = dt2.lookupdata_no_pk
                                                left join sysc_lookupdata dt3
                                                on lab.colony_count = dt3.lookupdata_no_pk
                                                left join sysc_lookupdata dt4
                                                on lab.incubation_time = dt4.lookupdata_no_pk
                                                left join sysc_lookupdata dt6
                                                on lab.sensitivity = dt6.lookupdata_no_pk
                                                left join sysc_lookupdata dt7
                                                on lab.biochemical_test = dt7.lookupdata_no_pk
                                                left join sysc_lookupdata dt8
                                                on lab.gram_stain_smear = dt8.lookupdata_no_pk
                                                left join sysc_lookupdata dt9
                                                on lab.microscope_examination = dt9.lookupdata_no_pk
                                                 where lab.report_no_pk = $report_id"));
            // dd(    $report_data , $incuvation_dt);
            // org.bacteria_name org_a left join microbiology_bacteria org   on lab.organism_a = org.bacteria_no_pk
            $po_hospital_details = DB::table("wsec_hospital")->first();
            // dd( $incuvation_dt);
            $result_organism = DB::table('labt_testreporting')->where('report_no_pk', $report_id)->first();


            if (Session::get('user.ses_hospital_code')=="UNICO") {

                  return view("admin.pathology.reports.histropathology.histropathology_report_pdf_v2", ["report_header1" => $report_header1, "result_organism" => $result_organism, "report_label" => $report_label, 'incuvation_dt' => $incuvation_dt, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'report_data_1' => $report_data_1, 'report_data_2' => $report_data_2,'draft'=>$draft])->render();
            }else{
                  return view("admin.pathology.reports.histropathology.histropathology_report_pdf", ["report_header1" => $report_header1, "result_organism" => $result_organism, "report_label" => $report_label, 'incuvation_dt' => $incuvation_dt, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'report_data_1' => $report_data_1, 'report_data_2' => $report_data_2,'draft'=>$draft])->render();
            }



            // $pdf = pdf::loadview("admin.pathology.reports.histropathology.histropathology_report_pdf", ["report_header1" => $report_header1, "result_organism" => $result_organism, "report_label" => $report_label, 'incuvation_dt' => $incuvation_dt, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'report_data_1' => $report_data_1, 'report_data_2' => $report_data_2]);
            // return $pdf->stream("histopathology_report.pdf");

            if ($type==1) {
                $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
            }


        } catch (\Exception $e) {
            DB::rollback();
            // $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            //dd($e->getMessage());
        }
        // return $pdf->stream("MC-$report_id.pdf");
        // return @\PDF::loadHTML($html, 'utf-8')->stream();

    }


    // Test Template

    public function createTestTemplate()
    {

        return Template::loadview("admin.settings.template.create_testtemplate", ['gender' => $gender, 'pathology' => $pathology, 'default_analyzer' => $default_analyzer, 'container_ind' => $container_ind, 'labs_testtemplate' => $labs_testtemplate, 'labs_sample' => $labs_sample]);
    }

    public function testTemplateStore(PathologyItemSetupRequest $request)
    {
        $id = $request->id;
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {

            $data = [
                'item_code' => $request->exam_setup_item_id,
                'active_stat' => $request->exam_active,
            ];

            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                $response = $this->itemModel->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->itemModel->update($data, $id);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }




    //3 column report
    public function resultEntryPdf3Column($report_id = "",$draft="" ,$type="")
    {
        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        try {
            $report_header = DB::table("labt_testreportresultprint_vw")->where('report_no_pk', $report_id)->first();
            // dd($report_header);
            $po_hospital_details = DB::table("wsec_hospital")->first();

            $report_varcode = "";
            $invoice_varcode = "";
            $patient_varcode = "";
            if (!empty($report_header)) {

                $barcode = new BarcodeGenerator();
                $barcode->setText($report_header->report_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $report_varcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report_header->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_varcode = $barcode1->generate();

                $barcode2 = new BarcodeGenerator();
                $barcode2->setText($report_header->patient_code);
                $barcode2->setType(BarcodeGenerator::Code128);
                $barcode2->setScale(1);
                $barcode2->setLabel('');
                $barcode2->setThickness(25);
                $barcode2->setFontSize(10);
                $patient_varcode = $barcode2->generate();
            }



            $data = DB::table("labt_testresultstruct_vw")->select('item_no_fk', 'item_name')->where('report_no_fk', $report_id)->where('show_in_rep', 1)->groupBy('item_no_fk', 'item_name')->get()->toArray();

            $report_data = DB::table("labt_testresultstruct_vw")
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->orderBy('group_seq', 'ASC')
                ->get()
                ->toArray();

            $report_label_query = DB::table("labt_testresultstruct_vw labtvw")
                ->join("sysc_serviceitem sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                ->where('report_no_fk', $report_id)
                ->where('show_in_rep', 1)
                ->orderBy('sl_no', 'ASC')
                ->orderBy('group_seq', 'ASC')
                ->first();
            $report_label = isset($report_label_query->plain_text) ? $report_label_query->plain_text : '';


            $attr_group = [];
            foreach ($report_data as $value) {
                $attr_group[$value->item_no_fk . '-' . $value->item_name][$value->test_group_no_fk . '-' . $value->group_txt][] = $value;
            }
            // dd($attr_group);
            if ($type==1) {
                $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                ];
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);

            }


            // $pdf = PDF::loadView("admin.pathology.reports.biochemestry_report", ["prescription_barcode" => $prescription_barcode, "lbauid_barcode" => $lbauid_barcode, "report_header" => $report_header, 'po_hospital_details' => $po_hospital_details, 'data' => $data, "report_data" => $report_data, 'attr_group' => $attr_group]);




            return view('admin.pathology.reports.biochemestry_report_3column', [

                "report_varcode" => $report_varcode,
                "report_label" => $report_label,
                "invoice_varcode" => $invoice_varcode,
                "report_header" => $report_header,
                'po_hospital_details' => $po_hospital_details,
                'data' => $data,
                "report_data" => $report_data,
                'attr_group' => $attr_group,
                'patient_varcode' => $patient_varcode,
                'draft' => $draft,
            ])->render();
        } catch (\Exception $e) {
            DB::rollback();
            // $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // return response()->json($message);
        // return $pdf->stream("BC-$report_id.pdf");
        // return @\PDF::loadHTML($html, 'utf-8')->stream();
    }






    public function printAllReport($admission_id)
    {
        // dd($admission_id);
        $label_info = DB::table('labt_samplecoll_label_vw')
            ->select('item_code_list', 'lab_code', 'invoice_code', 'test_short_name_list', 'serviceunit_name', 'patient_name', 'age', 'sc_sample_coll_keyed_time', 'coll_seq', 'dob', 'invoice_date')
            ->where('invoice_code', $invoice_id)
            ->get();

        $label = [];
        if (!empty($label_info)) {
            foreach ($label_info as $lab) {
                $barcode = new BarcodeGenerator();
                $barcode->setText($lab->lab_code);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(8);
                $lab->barcode = $barcode->generate();
            }
        }
        $data = [];
        // dd( $label_info);
        $data = ['barcode' => $label_info];
        // dd( $label_info);
        $pdf = PDF::loadView("admin.pathology.sample_print_all", $data);
        return $pdf->stream("allBarCode.pdf");
    }

    public function phamacyBarcodePrint($item_no_pk)
    {

        $label_info = DB::table('service_item_list_vw')->select('item_code', 'item_name', 'sales_price')->where('item_type', 'MED')->where('item_no_pk', $item_no_pk)->first();


        // dd($label_info->item_code);
        $title = $label_info->item_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        // $data['item_code'] = $barcode->generate();
        // $data['label_info'] = $label_info;
        $pdf = pdf::loadview("admin.phamacy.sample_print", ['barcode_no' => $barcode_no, 'label_info' => $label_info]);
        return $pdf->stream("sm-$label_info->item_code.pdf");
    }

    public function phamacyBarcodePrintAll($item_no_pk)
    {

        $label_info = DB::table('service_item_list_vw')->select('item_code', 'item_name', 'sales_price')->where('item_type', 'MED')->where('item_no_pk', $item_no_pk)->first();


        // dd($label_info->item_code);
        $title = $label_info->item_code;
        $barcode = new BarcodeGenerator();
        $barcode->setText($title);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $barcode_no = $barcode->generate();
        // $data['item_code'] = $barcode->generate();
        // $data['label_info'] = $label_info;
        $pdf = pdf::loadview("admin.phamacy.sample_print_all", ['barcode_no' => $barcode_no, 'label_info' => $label_info]);
        return $pdf->stream("sm-$label_info->item_code.pdf");
    }




    //    ========= Quee Management Pahology Added By Nazmul ====

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
        return Template::loadView("admin.dashboards.tv_screen_pathology", [
            'appointment_rs' => $appointment_rs,
            'voice_rs' => $voice_rs
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
            'appointment_rs' => $appointment_rs,
            'voice_rs' => $voice_rs
        ]);
    }
    public function saveLabTestTemplateHis(Request $request)
    {
        $template = DB::table('labs_testtemplate')->select('test_temp_no_pk')->where('temp_name', $request->template_name)->first();
        $auth_id = Auth::id();
        DB::beginTransaction();
        $sequence = DB::getSequence();
        $test_temp_no_pk = $sequence->nextValue('test_temp_no_pk_seq');

        try {
            $data = [
                'temp_name' => $request->template_name,
                'histopath_note_clob' => $request->result_note,
            ];
            // dd($template->test_temp_no_pk);
            if (!isset($template->test_temp_no_pk)) {
                $data['test_temp_no_pk'] = $test_temp_no_pk;
                $data['note_ind'] = 1;
                $data['status'] = 1;
                $data['au_entry_by'] = $auth_id;
                $data['au_entry_at'] =  date('Y-m-d h:i:s');
                $data['au_entry_session'] =   'session';
                $data['au_entry_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                db::table("labs_testtemplate")
                    ->insert($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $data['au_update_at'] =  date('Y-m-d h:i:s');
                $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
                DB::table('labs_testtemplate')
                    ->where('test_temp_no_pk', $template->test_temp_no_pk)
                    ->update($data);
            }
            DB::commit();
            $message = ['msg' => 'Note Template Added Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
      public function mergeReports(Request $request)
    {
        $reportIds = explode(',', $request->reports);

        if (empty($reportIds)) {
            return response()->json(['error' => 'No report IDs found'], 400);
        }

        // প্রথম রিপোর্ট থেকে invoice বের করা
        $invoice_id = DB::table('labt_invoicedtl')
            ->where('REPORT_NO_FK', $reportIds[0])
            ->value('invoice_no_fk');

        $pdfFiles = [];

        foreach ($reportIds as $reportId) {

            // 🔹 Step 1: Route name fetch
            $reportRouteName = DB::table('labt_invoicedtl_vw')
                ->where('REPORT_NO_FK', $reportId)
                ->value('REPORT_URL'); // Example: 'path.bc-report-pdf-mic'

            if (!$reportRouteName) continue;

            // 🔹 Step 2: Route object
            $route = Route::getRoutes()->getByName($reportRouteName);

            if (!$route) continue;

            // 🔹 Step 3: Controller@method
            $controllerAction = $route->getActionName();
            Log::info("Calling route: {$reportRouteName} for report_id: {$reportId}");
            // 🔹 Step 4: Internal call
            $html = app()->call($controllerAction, [
                'report_id' => $reportId,
                'draft' => '',
                'customCss' => 'padding-top: 30px;'
            ]);

            // 🔹 Step 5: Save individual PDF
            $path = storage_path("app/reports/report_{$reportId}_" . uniqid() . ".pdf");
            $html = '<body style="padding-top:15px;font: size 12px;">' . $html . '</body>';
            Pdf::loadHTML($html)
                ->setPaper('A4', 'portrait')
                ->save($path);

            $pdfFiles[] = $path;
        }

        if (empty($pdfFiles)) {
            return response()->json(['error' => 'No PDFs generated'], 400);
        }

        // 🔹 Step 6: Merge PDFs with FPDI
        $pdf = new Fpdi();

        foreach ($pdfFiles as $file) {
            $pageCount = $pdf->setSourceFile($file);

            for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                $tplId = $pdf->importPage($pageNo);
                $size = $pdf->getTemplateSize($tplId);

                $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
                $pdf->AddPage($orientation, [$size['width'], $size['height']]);
                $pdf->useTemplate($tplId);
            }
        }

        // 🔹 Step 7: Save merged file
        $mergedFile = storage_path("app/reports/invoice_{$invoice_id}_merged.pdf");
        $pdf->Output($mergedFile, 'F');

        // 🔹 Step 8: Return merged file for download
        return response()->download($mergedFile);
    }


}
