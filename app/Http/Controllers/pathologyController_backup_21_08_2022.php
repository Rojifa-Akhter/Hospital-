<?php

namespace App\Http\Controllers;

use App\Library\Template;
use App\Traits\ItemData;
use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use DB;
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
use DateTime;
use Illuminate\Support\Carbon;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use Illuminate\Database\Console\Migrations\RollbackCommand;
use Illuminate\Support\Facades\DB as FacadesDB;

class pathologyController_backup_21_08_2022 extends Controller
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
        $this->middleware('auth');

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
                ->where("invoice_code", $prescription_uid)
                ->whereNull("sc_sample_coll_key_ind")
                ->orderBy("lab_code", "asc")->get()->toArray();

            $invoice_item_arr = DB::table("labt_invoicedtl_vw")->where("invoice_code", $prescription_uid)->whereNull("sc_sample_coll_key_ind")->orderBy("lab_code", "asc")->get()->toArray();
        }
        $prescription_id = 0;

        return Template::loadview("admin.pathology.sample_collection_list_collect", ["prescription_id" => $prescription_id, "sample_collection_arr" => $sample_collection_arr, "invoice_item_arr" => $invoice_item_arr, "type" => $type, "prescription_uid" => $prescription_uid]);
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
        $sample_collection_arr = DB::table("labt_samplecoll_wl_vw")
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->whereNull("sc_sample_coll_key_ind")
            ->orderBy("lab_code", "desc")->get()->toArray();
        $prescription_id = '';
        return Template::loadview("admin.pathology.sample_collection_list_pending", ["sample_collection_arr" => $sample_collection_arr, "type" => $type, 'prescription_id' => $prescription_id]);
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
        $today = date("m-d-Y");
        $from_date = date("m-d-Y", strtotime("-7 Days"));
        $sample_collection_arr = DB::table("labt_samplecoll_wl_vw")
            ->where("sc_sample_coll_key_ind", 1)
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->whereRaw("sc_sample_coll_keyed_time >=to_date('$from_date' ,'mm/dd/yyyy') and sc_sample_coll_keyed_time <=to_date('$today' ,'mm/dd/yyyy')")
            ->orderBy("lab_code", "desc")
            ->get()
            ->toArray();
        $prescription_id = '';
        return Template::loadview("admin.pathology.sample_collection_list_collected", ["sample_collection_arr" => $sample_collection_arr, "type" => $type, 'prescription_id' => $prescription_id]);
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    public function sampleCollectionPrint($lab_no_pk)
    {

        $label_info = DB::table('labt_samplecoll_label_vw')->select('item_code_list', 'lab_code', 'invoice_code', 'test_short_name_list', 'serviceunit_name', 'patient_name', 'age', 'sc_sample_coll_keyed_time')->where('lab_no_pk', $lab_no_pk)->first();
        // dd($label_info);

        $barcode = new BarcodeGenerator();
        $barcode->setText($label_info->lab_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(8);
        // $barcode = new BarcodeGenerator();
        // $barcode->setText(optional($label_info)->invoice_code);
        // $barcode->setType(BarcodeGenerator::Code128);
        // $barcode->setLabel(optional($label_info)->invoice_code);
        // $barcode->setScale(1);
        // $barcode->setThickness(25);
        // $barcode->setFontSize(8);

        $data['lab_no_barcode'] = $barcode->generate();
        $data['label_info'] = $label_info;
        // return View("admin.pathology.sample_print", $data);
        $pdf = PDF::loadView("admin.pathology.sample_print", $data);
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
        $type = $request->type;

        // $check_presc_in_invoice = DB::table("labt_invoicedtl a")->join("psn_t_prescription b","a.prescription_no_fk","=","b.prescription_no_pk")->where("b.prescription_uid", $prescription_id)->get()->toArray();

        // if($type == "collect" && empty($check_presc_in_invoice)){
        //     $this->sampleBillInvoice($prescription_id);
        // }

        $patient_info = DB::table("labt_invoicedtl_vw a")
            ->select("b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "b.pat_relation", "b.ref_patient_gender", "b.ref_blood_group", "b.ref_age", "b.blood_group_txt")
            ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
            ->orWhere("a.invoice_code", $prescription_id)
            ->orWhere("a.lab_code", $lab_id)
            ->whereNull("sc_sample_coll_key_ind")
            ->first();
        // dd($patient_info);
        if ($type == "collected") {


            if ($lab_id != null && $prescription_id != null) {
                $sample_collection_arr = DB::table("labt_samplecoll_wl_vw")
                    ->Where("invoice_code", $prescription_id)
                    ->Where("lab_code", $lab_id)
                    ->where("sc_sample_coll_key_ind", 1)
                    ->whereNull('cancel_ind')
                    ->orderBy("lab_code", "asc")->get()->toArray();
            } elseif ($lab_id == null && $prescription_id != null) {
                $sample_collection_arr = DB::table("labt_samplecoll_wl_vw")
                    ->Where("invoice_code", $prescription_id)
                    ->where("sc_sample_coll_key_ind", 1)
                    ->whereNull('cancel_ind')
                    ->orderBy("lab_code", "asc")->get()->toArray();
            } else {
                $sample_collection_arr = DB::table("labt_samplecoll_wl_vw")
                    ->Where("lab_code", $lab_id)
                    ->where("sc_sample_coll_key_ind", 1)
                    ->whereNull('cancel_ind')
                    ->orderBy("lab_code", "asc")->get()->toArray();
            }
        } else {

            if ($lab_id != null && $prescription_id != null) {
                $sample_collection_arr = DB::table("labt_samplecoll_wl_vw")
                    ->Where("invoice_code", $prescription_id)
                    ->Where("lab_code", $lab_id)
                    ->where("sc_sample_coll_key_ind", NULL)
                    ->where('cancel_ind', NULL)
                    ->orderBy("lab_code", "asc")->get()->toArray();
            } elseif ($lab_id == null && $prescription_id != null) {
                $sample_collection_arr = DB::table("labt_samplecoll_wl_vw")
                    ->Where("invoice_code", $prescription_id)
                    ->where("sc_sample_coll_key_ind", NULL)
                    ->where('cancel_ind', NULL)
                    ->orderBy("lab_code", "asc")->get()->toArray();
            } else {
                $sample_collection_arr = DB::table("labt_samplecoll_wl_vw")
                    // ->Where("invoice_code", $prescription_id)
                    ->orWhere("lab_code", $lab_id)
                    ->where("sc_sample_coll_key_ind", NULL)
                    ->where('cancel_ind', NULL)
                    ->orderBy("lab_code", "asc")->get()->toArray();
            }
            // dd($sample_collection_arr);
        }





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
        } else {
            $invoice_item_arr = DB::table("labt_invoicedtl_vw")
                ->Where("lab_code", $lab_id)
                ->whereNull("sc_sample_coll_key_ind")
                ->whereNull('cancel_ind')
                ->orderBy("lab_code", "asc")
                ->get()
                ->toArray();
        }
      
        return Template::loadview("admin.pathology.sample_collection_list", ["prescription_id" => $prescription_id, "sample_collection_arr" => $sample_collection_arr, "invoice_item_arr" => $invoice_item_arr, "type" => $type, "patient_info" => $patient_info]);
    }

    //      /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */
    public function storeSampleCollection(Request $request)
    {
        //dd($request->all());
        $id = $request->id;
        $auth_id = Auth::id();


        $dt = new DateTime('now', new \DateTimeZone('Asia/Dhaka'));
        $date = $dt->format('Y-m-d H:i');

        DB::beginTransaction();
        try {
            $chk_sample = $request->chk_sample;

            $ids = [];
            for ($i = 0; $i < sizeof($chk_sample); $i++) {
                $data = [
                    'sc_sample_coll_key_ind' => 1,
                    'sc_sample_coll_keyed_by' => $auth_id,
                    'sc_sample_coll_keyed_time' => $date
                ];
                $ids[] = $chk_sample[$i];
            }


            $this->model->bulk_update($data, "lab_no_pk", $ids);

            $delivery_date = $request->delivery_date;
            $sample_item_dtl = $request->chk_sample_item_dtl;

            $ids = [];
            for ($j = 0; $j < count($sample_item_dtl); $j++) {
                $dtldata = [
                    'sc_sample_coll_key_ind' => 1,
                    'sc_sample_coll_keyed_by' => $auth_id,
                    'sc_sample_coll_keyed_time' => $date,
                    'report_delivery_date' => date("Y-m-d", strtotime($delivery_date[$j]))
                ];
                $dtlids[] = $sample_item_dtl[$j];
            }

            $this->invoicedtl->bulk_update($dtldata, "pathinvoicedtl_no_pk", $dtlids);
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    //      /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */
    public function sampleReceive()
    {
        // onclick="pathologyFunc.getReceiveSamples(this)"
        $department_data = $this->getServiceUnitByInd("PATHOLOGY_IND");
        $indicator = "pending";
        $receive_arr = DB::table("labt_samplelabrcv_wl_vw")
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
        // return Template::loadview("admin.pathology.sample_receive");
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    public function searchSampleReceive(Request $request)
    {
        $lab_no = $request->lab_no;
        $type = $request->type;
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        if ($type == "pending") {
            $receive_arr = DB::table("labt_samplelabrcv_wl_vw")->where('au_entry_hospital_pk_no', $hospital_id)->where("invoice_no_fk", $lab_no)->where("sc_sample_coll_key_ind", 1)->whereNull("lab_rcv_from_sp_key_ind")->whereNull('cancel_ind')->get();


            return Template::loadview("admin.pathology.sample_receive_list_pending", ["receive_arr" => $receive_arr]);
        } else {

            $receive_arr = DB::table("labt_samplelabrcv_wl_vw")->where('au_entry_hospital_pk_no', $hospital_id)->where("invoice_no_fk", $lab_no)->where("lab_rcv_from_sp_key_ind", 1)->whereNull('cancel_ind')->get();

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
        $today = date("m-d-Y");
        $from_date = date("m-d-Y", strtotime("-7 Days"));
        $receive_arr = DB::table("labt_samplelabrcv_wl_vw")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->where("lab_rcv_from_sp_key_ind", 1)->whereNull('cancel_ind')
            ->whereRaw("lab_rcv_from_sp_keyed_time>=to_date('$from_date','mm/dd/yyyy') and lab_rcv_from_sp_keyed_time<=to_date('$today','mm/dd/yyyy')")
            ->orderBy('lab_no_pk', 'desc')->get(); //->where("lab_code", $lab_no)
        return Template::loadview("admin.pathology.sample_receive_list_received", ["receive_arr" => $receive_arr, "department_data" => $department_data, "indicator" => $indicator]);
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
                        'lab_rcv_from_sp_keyed_time' => date("Y-m-d")
                    ];
                    LabInvoiceDtl::where("lab_no_fk", $lab_id)->update($data);
                    SampleCollection::where("lab_no_pk", $lab_id)->update($data);
                }
            } else {
                $lab_id = $request->lab_id;
                $data = [
                    'lab_rcv_from_sp_key_ind' => 1,
                    'lab_rcv_from_sp_keyed_by' => $auth_id,
                    'lab_rcv_from_sp_keyed_time' => date("Y-m-d")
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

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    public function resultEntry()
    {
        $type = 1;
        $today = date('d-m-Y', strtotime("-7 Days"));
        $operation = 'prepare';
        $hospital_id = Session::get('user.ses_hospital_no_pk');

        $user_service_unit =  DB::table('sysc_grant_su')
            ->where('user_no_fk', Auth::user()->user_no_pk)
            ->where('status', 1)
            ->get();
        $user_service_list = 0;
        if (!empty($user_service_unit)) {
            $user_service_list = $user_service_unit->implode('su_no_fk', ',');
        }

        $invoice_item_arr = DB::table("labt_invoicedtl_vw")
            ->where('au_entry_hospital_pk_no', $hospital_id)
            ->where("lab_rcv_from_sp_key_ind", 1)
            ->whereNull("lab_result_verify_key_ind")
            ->whereNull("lab_result_final_key_ind")
            ->whereNull('cancel_ind')
            ->whereRaw("service_unit_no_fk in ($user_service_list)")
            ->whereRaw("lab_rcv_from_sp_keyed_time >= to_date('$today','DD-MM-YYYY')")
            ->orderBy("lab_code", "desc")->get()->toArray();
// dd( $invoice_item_arr);
        $service_unit = DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('pathology_ind', 1)->where('status', 1)->get();
        // dd($invoice_item_arr);
        return Template::loadview("admin.pathology.result_entry", ["invoice_item_arr" => $invoice_item_arr, "type" => $type, "operation" => $operation, 'service_unit' => $service_unit]);
        // return Template::loadview("admin.pathology.result_entry",["operation" => $operation, "type" => $type]);
    }
    public function resultEntryMic()
    {
        $type = 1;
        $today = date('d-m-Y', strtotime("-7 Days"));
        $operation = 'prepare';
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $service_unit_no=Session::get('user.su_pk_no');
        $service_unit_name=Session::get('user.serviceunit');
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
        return Template::loadview("admin.pathology.result_entry_mic", ["invoice_item_arr" => $invoice_item_arr, "type" => $type, "operation" => $operation, 'service_unit' => $service_unit,'service_unit_name'=>$service_unit_name]);
        // return Template::loadview("admin.pathology.result_entry",["operation" => $operation, "type" => $type]);
    }

    //     /**
    //      * Store a newly created resource in storage.
    //      *
    //      * @param  \Illuminate\Http\Request  $request
    //      * @return \Illuminate\Http\Response
    //      */

    public function verifiedResult()
    {
        $type = 1;
        $today = date('d-m-Y', strtotime("-7 Days"));

        $operation = 'verify';
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $invoice_item_arr = DB::table("labt_invoicedtl_vw")
            ->where('au_entry_hospital_pk_no', $hospital_id)
            ->where("lab_rcv_from_sp_key_ind", 1)
            ->where("lab_result_verify_key_ind", 1)
            ->whereNull("lab_result_final_key_ind")
            ->whereNull('cancel_ind')
            ->whereRaw("lab_result_verify_keyed_time >= to_date('$today','DD-MM-YYYY')")
            ->orderBy("lab_code", "desc")->get()->toArray();
        $service_unit = DB::table('sysc_serviceunit')->select('serviceunit_no_pk', 'serviceunit_name')->where('pathology_ind', 1)->where('status', 1)->get();
        return Template::loadview("admin.pathology.verified_result", ["invoice_item_arr" => $invoice_item_arr, "type" => $type, "operation" => $operation, 'service_unit' => $service_unit]);
    }
    public function verifiedResultMic()
    {
        // $type = 1;
        // $today = date('d-m-Y', strtotime("-7 Days"));

        //     ->first();

        // $result_item = DB::select(DB::raw("select test_name_list from labt_samplelabrcv_wl_vw where lab_uid = $lab_id
        //         and au_entry_hospital_pk_no = $hospital_id  and cancel_ind is null"));
        // $analyzer = DB::table('sysc_serviceitem')->select('item_code', 'item_name', 'interpretation')->where('analyzer_ind', 1)->get();


        // $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind",$result_info->su_no_fk);
        // $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind",$result_info->su_no_fk);
        // $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind",$result_info->su_no_fk);
        // $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind",$result_info->su_no_fk);
        // $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind",$result_info->su_no_fk);
        // // dd($consult);
        // return Template::loadview("admin.pathology.result_entry_form_elisa", ["report_id" => $report_id, "result_info" => $result_info, "patient_info" => $patient_info, "result_test_info" => $result_test_info, "prepared_by" => $prepared_by, "verified_by" => $verified_by, "finalize_by" => $finalize_by, "type" => $type, "result_item" => $result_item, 'lab_id' => $lab_id, 'analyzer' => $analyzer, 'consult' => $consult, 'consult2' => $consult2]);

        $type = 1;
        $today = date('d-m-Y', strtotime("-7 Days"));

        $operation = 'verify';
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $service_unit_no=Session::get('user.su_pk_no');
        $service_unit_name=Session::get('user.serviceunit');
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
        return Template::loadview("admin.pathology.verified_result_mic", ["invoice_item_arr" => $invoice_item_arr, "type" => $type, "operation" => $operation, 'service_unit' => $service_unit,'service_unit_name'=>$service_unit_name]);
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
        $date = $dt->format('Y-m-d H:i');
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
            // dd($result_note);
            $ids = [];

            for ($i = 0; $i < count($result); $i++) {
                //dd($request->show_in_rep[$i]);
                $show_in_rep_val = 0;
                //if (isset($request->show_in_rep)) {
                $ss = 'show_in_rep_' . $testresult_no_pk[$i];

                // dd($opinion);
                if (@$request->$ss  == "on") {
                    $show_in_rep_val = 1;
                    $data = [
                        'result0'       => $result[$i],
                        // 'au_update_hospital_no_fk' => $ses_hospital_id,
                        'show_in_rep'   => $show_in_rep_val, //isset($show_in_rep[$i]) ? 1 :0

                    ];
                } else {
                    $show_in_rep_val = 0;
                    $data = [
                        'result0'       => $result[$i],
                        // 'au_update_hospital_no_fk' => $ses_hospital_id,
                        'show_in_rep'   => $show_in_rep_val, //isset($show_in_rep[$i]) ? 1 :0

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
                    'result_prepared_keyed_time' => date("Y-m-d"),
                    'interpretation'             => $interpretation,
                    'analyzer_desc'             => $analyzer_txt,
                    'comments_text'              => $result_comments,
                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_prepared_key_ind'    => 1,
                    'lab_result_prepared_keyed_by'   => $result_prepared_by,
                    'lab_result_prepared_keyed_time' => date("Y-m-d"),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];
            }

            if ($request->action_type == "verifiy") {
                $report_data = [
                    'result_verify_key_ind'      => 1,
                    'result_verify_keyed_by'     => $result_verified_by,
                    'result_verify_keyed_time'   => date("Y-m-d"),
                    'interpretation'             => $interpretation,
                    'analyzer_desc'             => $analyzer_txt,
                    'comments_text'              => $result_comments,
                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_verify_key_ind'    => 1,
                    'lab_result_verify_keyed_by'   => $result_verified_by,
                    'lab_result_verify_keyed_time' => date("Y-m-d"),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];
            }

            if ($request->action_type == "finalize") {
                $report_data = [
                    'result_final_key_ind'       => 1,
                    'result_final_keyed_by'      => $result_finalize_by,
                    'result_final_keyed_time'    => $date,
                    'interpretation'             => $interpretation,
                    'analyzer_desc'             => $analyzer_txt,
                    'comments_text'              => $result_comments,
                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                    'result_prepared_key_ind'    => 1,
                    'result_prepared_keyed_by'   => $result_prepared_by,
                    'result_prepared_keyed_time' => date("Y-m-d"),
                    'result_verify_key_ind'      => 1,
                    'result_verify_keyed_by'     => $result_verified_by,
                    'result_verify_keyed_time'   => date("Y-m-d"),
                    'result_ent_key_ind'       => 1,
                    'result_ent_keyed_by'      => $request->consultant,
                    'result_ent_keyed_time'    => date("Y-m-d"),

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

            $attr_group = [];
            foreach ($report_data as $value) {
                $attr_group[$value->item_no_fk . '-' . $value->item_name][$value->test_group_no_fk . '-' . $value->group_txt][] = $value;
            }
            // dd($attr_group);
            $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
            ];
            // AU_UPDATE_BY
            $data['au_update_by'] = $auth_id;
            $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
            DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);


            // $pdf = PDF::loadView("admin.pathology.reports.biochemestry_report", ["prescription_barcode" => $prescription_barcode, "lbauid_barcode" => $lbauid_barcode, "report_header" => $report_header, 'po_hospital_details' => $po_hospital_details, 'data' => $data, "report_data" => $report_data, 'attr_group' => $attr_group]);




            return view('admin.pathology.reports.biochemestry_report_elisa', [
                "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, "report_header" => $report_header, 'po_hospital_details' => $po_hospital_details, 'data' => $data, "report_data" => $report_data, 'attr_group' => $attr_group, 'patient_varcode' => $patient_varcode
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
        $analyzer_list = DB::table('labs_teststructure_analyzer')
            ->select('analyzerattr_no_pk', 'analyzerattr_code', 'teststruct_no', 'analyzer_no', 'analyzer_name', 'machine_attrib', 'panel_attrib', 'normal_result', 'unit', 'status')
            ->where('teststruct_no', $request->teststruct_no_pk)
            ->orderBy('analyzerattr_no_pk', 'asc')
            ->get()->toArray();

        return Template::loadview("admin.pathology.pathology_test_wise_attr_analyzer_list", [
            'analyzer_list' => $analyzer_list
        ]);
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


            $attr_group = [];
            $attr_group2 = [];
            foreach ($report_data as $value) {
                $attr_group[$value->item_no_fk . '-' . $value->item_name . '`' . $value->item_code][$value->test_group_no_fk . '-' . $value->group_txt][] = $value;
                $attr_group2[$value->item_no_fk . '-' . $value->item_name . '`' . $value->item_code][$value->test_group_no_fk . '-' . $value->group_txt][] = $value;
            }

            $po_hospital_details = DB::table("wsec_hospital")->first();

            // $pdf = PDF::loadView("admin.pathology.reports.biochemistry_report_stool_col_2",[
            return view("admin.pathology.reports.biochemistry_report_stool_col_2", [
                "po_hospital_details" => $po_hospital_details,
                "report_varcode" => $report_varcode,
                "invoice_varcode" => $invoice_varcode,
                'patient_varcode' => $patient_varcode,
                "report_header" => $report_header,
                "report_data" => $report_data,
                'attr_group' => $attr_group,
                'attr_group2' => $attr_group2
            ]);


            $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
            ];
            // AU_UPDATE_BY
            $data['au_update_by'] = $auth_id;
            $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
            DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
        } catch (\Exception $e) {
            DB::rollback();
            // $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return $pdf->stream("BC-$report_id.pdf");
    }
    public function resultEntryPdfPBFColumn2($report_id)
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

            //    dd($report_header);

            $attr_group = [];
            foreach ($report_data as $value) {
                $attr_group[$value->item_no_fk . '-' . $value->item_name . '`' . $value->item_code][$value->test_group_no_fk . '-' . $value->group_txt][] = $value;
            }
            // dd($attr_group);
            $po_hospital_details = DB::table("wsec_hospital")->first();

            $pdf = PDF::loadView("admin.pathology.reports.biochemistry_report_col_2_pbf", ["po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'attr_group' => $attr_group]);


            $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
            ];
            // AU_UPDATE_BY
            $data['au_update_by'] = $auth_id;
            $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
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

            return view("admin.pathology.urine_report_pdf", ["po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'attr_group' => $attr_group, 'report_data_last' => $report_data_last, 'attr_group_last' => $attr_group_last,'attr_group_last_gmc'=>$attr_group_last_gmc]);


            $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
            ];
            // AU_UPDATE_BY
            $data['au_update_by'] = $auth_id;
            $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
            DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
        } catch (\Exception $e) {
            DB::rollback();
            // $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return $pdf->stream("BC-$report_id.pdf");
    }

    public function specialReportCbc($report_id = "")
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

            $attr_group = [];
            foreach ($report_data as $value) {
                $attr_group[$value->test_group_no_fk . '-' . $value->group_txt][] = $value;
            }
            $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
            ];
            // AU_UPDATE_BY
            $data['au_update_by'] = $auth_id;
            $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
            DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);


            // $pdf = PDF::loadView("admin.pathology.reports.biochemestry_report", ["prescription_barcode" => $prescription_barcode, "lbauid_barcode" => $lbauid_barcode, "report_header" => $report_header, 'po_hospital_details' => $po_hospital_details, 'data' => $data, "report_data" => $report_data, 'attr_group' => $attr_group]);


            $html = view('admin.pathology.reports.biochemistry_report_cbc', [
                "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, 'po_hospital_details' => $po_hospital_details, 'data' => $data, "report_data" => $report_data, 'attr_group' => $attr_group
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
                    'au_entry_hospital_pk_no' =>  141,
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
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("report_no_pk", $report_id)
            ->whereNull('cancel_ind')
            ->first();


        if (!empty($result_info_0)) {
            $prescription_id = $result_info_0->invoice_no_fk;

                'lab.sensitivity',
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




        $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind",$result_info->su_no_fk);
        $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind",$result_info->su_no_fk);
        $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind",$result_info->su_no_fk);
        $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind",$result_info->su_no_fk);
        $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind",$result_info->su_no_fk);
        // dd($consult);


        $incubationtime = $this->getLookupListByCode("INCUBATIONTIME");
        $incubationtemp = $this->getLookupListByCode("INCUBATIONTEMP");
        $incubationcolonycount = $this->getLookupListByCode("INCUBATIONCOLONYCOUNT");
        $incubationcond = $this->getLookupListByCode("INCUBATIONCOND");
        $rbc = $this->getLookupListByCode("RBC");


        $antivitic = DB::table("microbiology_antibiotic")->where('status', 1)->get();
        $becteria = DB::table("microbiology_bacteria")->where('status', 1)->get();

        // FOR gmc
        $microscope = $this->getLookupListByCode("MICROSCOPEEXAMINATION");
        $gramstain = $this->getLookupListByCode("GRAMSTAIN");
        $sensityvity = $this->getLookupListByCode("SENSITYVITY");
        $biochemical_test = $this->getLookupListByCode("BIOCHEMICALTEST");

        return Template::loadview("admin.pathology.result_entry_form_mic", [
            "report_id" => $report_id, "result_info" => $result_info, "rs_dt" => $rs_dt, "result_info_1" => $result_info_1, "patient_info" => $patient_info, "result_test_info" => $result_test_info, "prepared_by_columns" => $prepared_by, "verified_by_columns" => $verified_by, "finalize_by_columns" => $finalize_by, "type" => $type, "result_item" => $result_item, 'lab_id' => $lab_id, 'analyzer' => $analyzer, "incubationtime" => $incubationtime,
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



    public function storeResultEntryMic(Request $request)
    {
        $ses_hospital_id =   Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();
        //  dd($request->all());
        $dt = new DateTime('now', new \DateTimeZone('Asia/Dhaka'));
        $date = $dt->format('Y-m-d H:i');
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
                    'lab_result_verify_keyed_time' => date("Y-m-d"),
                    'lab_result_entry_key_ind'    => 1,
                    'lab_result_entry_keyed_by'   => $request->consultant,
                    'lab_result_entry_keyed_time' => date("Y-m-d"),
                    'lab_result_con_key_ind' => 1,
                    'lab_result_con_keyed_by' => $request->consultant2,
                    'lab_result_con_keyed_time' => date("Y-m-d")
                ];
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
                    'comments_text'                => $result_comm,
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];

                $invoice_data = [
                    'lab_result_entry_key_ind'    => 1,
                    'lab_result_entry_keyed_by'   => $request->consultant,
                    'lab_result_entry_keyed_time' => date("Y-m-d"),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                ];
            }

            Db::table("labt_testreporting")->where("report_no_pk", $hdn_report_id)->update($report_data);
            LabInvoiceDtl::where("report_no_fk", $hdn_report_id)->update($invoice_data);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }


    public function resultEntryPdfMic($report_id)
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


        // $prepared_by = $this->getPathologyResultEntryByUser("save_ind");
        // $verified_by = $this->getPathologyResultEntryByUser("verify_ind");
        // $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind");
        $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind",$result_info->su_no_fk);
        $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind",$result_info->su_no_fk);
        $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind",$result_info->su_no_fk);
        $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind",$result_info->su_no_fk);
        $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind",$result_info->su_no_fk);

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
            "report_id" => $report_id, "result_info" => $result_info, "rs_dt" => $rs_dt, "result_info_1" => $result_info_1, "patient_info" => $patient_info, "result_test_info" => $result_test_info, "prepared_by_columns" => $prepared_by, "verified_by_columns" => $verified_by, "finalize_by_columns" => $finalize_by, "type" => $type, "result_item" => $result_item, 'lab_id' => $lab_id, 'analyzer' => $analyzer, "incubationtime" => $incubationtime,
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
                    'result_final_keyed_time'    => date("Y-m-d"),

                    'note_text'                  => $result_note,
                    'au_update_hospital_pk_no'   => $ses_hospital_id,

                    'result_prepared_key_ind'    => 1,
                    'result_prepared_keyed_by'   => $result_prepared_by,
                    'result_prepared_keyed_time' => date("Y-m-d"),

                    'result_verify_key_ind'      => 1,
                    'result_verify_keyed_by'     => $result_verified_by,
                    'result_verify_keyed_time'   => date("Y-m-d"),

                    'result_ent_key_ind'       => 1,
                    'result_ent_keyed_by'      => $request->consultant,
                    'result_ent_keyed_time'    => date("Y-m-d"),

                    'result_con_key_ind' => 1,
                    'result_con_keyed_by' => $request->consultant2,
                    'result_con_keyed_time' => date("Y-m-d"),


                ];

                $invoice_data = [
                    'lab_result_final_key_ind'    => 1,
                    'lab_result_final_keyed_by'   => $result_finalize_by,
                    'lab_result_final_keyed_time' => date("Y-m-d"),
                    'au_update_hospital_pk_no' => $ses_hospital_id,

                    'lab_result_prepared_key_ind'    => 1,
                    'lab_result_prepared_keyed_by'   => $result_prepared_by,
                    'lab_result_prepared_keyed_time' => date("Y-m-d"),

                    'lab_result_verify_key_ind'    => 1,
                    'lab_result_verify_keyed_by'   => $result_verified_by,
                    'lab_result_verify_keyed_time' => date("Y-m-d"),

                    'lab_result_entry_key_ind'    => 1,
                    'lab_result_entry_keyed_by'   => $request->consultant,
                    'lab_result_entry_keyed_time' => date("Y-m-d"),

                    'lab_result_con_key_ind' => 1,
                    'lab_result_con_keyed_by' => $request->consultant2,
                    'lab_result_con_keyed_time' => date("Y-m-d")

                ];
            }
            if ($request->action_type == "consultant") {

                $report_data = [
                    'result_ent_key_ind'       => 1,
                    'result_ent_keyed_by'      => $request->consultant,
                    'result_ent_keyed_time'    => date("Y-m-d"),

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

            Db::table("labt_testreporting")->where("report_no_pk", $hdn_report_id)->update($report_data);
            LabInvoiceDtl::where("report_no_fk", $hdn_report_id)->update($invoice_data);


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

            $po_hospital_details = DB::table("wsec_hospital")->first();

            // dd($donor_info);
            return view("admin.pathology.cm_report_pdf", ["po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, 'donor_info' => $donor_info]);


            $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
            ];
            // AU_UPDATE_BY
            $data['au_update_by'] = $auth_id;
            $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
            DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
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

        $rs_dt = DB::select(DB::raw("select lab.*,sys.* from labt_testresultstruct_vw lab
            left join sysc_serviceitem_vw sys
            on lab.item_no_fk = sys.item_no_pk
            where lab.report_no_fk = $report_id
            and lab.au_entry_hospital_pk_no = $hospital_id
            and lab.cancel_ind is null order by lab.item_name Asc,sl_no ASC"));

        $result_item = DB::select(DB::raw("select test_name_list from labt_samplelabrcv_wl_vw where lab_uid = $lab_id
                and au_entry_hospital_pk_no = $hospital_id  and cancel_ind is null"));


        $analyzer = DB::table('sysc_serviceitem')->select('item_code', 'item_name', 'interpretation')->where('analyzer_ind', 1)->get();



        $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind",$result_info->su_no_fk);
        $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind",$result_info->su_no_fk);
        $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind",$result_info->su_no_fk);
        $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind",$result_info->su_no_fk);
        $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind",$result_info->su_no_fk);


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
            "report_id" => $report_id, "result_info" => $result_info, "rs_dt" => $rs_dt, "result_info_1" => $result_info_1, "patient_info" => $patient_info, "result_test_info" => $result_test_info, "prepared_by_columns" => $prepared_by, "verified_by_columns" => $verified_by, "finalize_by_columns" => $finalize_by, "type" => $type, "result_item" => $result_item, 'lab_id' => $lab_id, 'analyzer' => $analyzer, "incubationtime" => $incubationtime,
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


                    'result_prepared_key_ind'    => 1,
                    'result_prepared_keyed_by'   => $result_prepared_by,
                    'result_prepared_keyed_time' => date("Y-m-d"),
                    'result_verify_key_ind'      => 1,
                    'result_verify_keyed_by'     => $result_verified_by,
                    'result_verify_keyed_time'   => date("Y-m-d"),
                    'result_ent_key_ind'       => 1,
                    'result_ent_keyed_by'      => $request->consultant,
                    'result_ent_keyed_time'    => date("Y-m-d"),

                    'result_con_key_ind' => 1,
                    'result_con_keyed_by' => $request->consultant2,
                    'result_con_keyed_time' => date("Y-m-d"),
                ];

                $invoice_data = [
                    'lab_result_final_key_ind'    => 1,
                    'lab_result_final_keyed_by'   => $result_finalize_by,
                    'lab_result_final_keyed_time' => date("Y-m-d"),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                    'lab_result_prepared_key_ind'    => 1,
                    'lab_result_prepared_keyed_by'   => $result_prepared_by,
                    'lab_result_prepared_keyed_time' => date("Y-m-d"),
                    'lab_result_verify_key_ind'    => 1,
                    'lab_result_verify_keyed_by'   => $result_verified_by,
                    'lab_result_verify_keyed_time' => date("Y-m-d"),
                    'lab_result_entry_key_ind'    => 1,
                    'lab_result_entry_keyed_by'   => $request->consultant,
                    'lab_result_entry_keyed_time' => date("Y-m-d"),
                    'lab_result_con_key_ind' => 1,
                    'lab_result_con_keyed_by' => $request->consultant2,
                    'lab_result_con_keyed_time' => date("Y-m-d")
                ];
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

            Db::table("labt_testreporting")->where("report_no_pk", $hdn_report_id)->update($report_data);
            LabInvoiceDtl::where("report_no_fk", $hdn_report_id)->update($invoice_data);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }


    public function resultGramStainPdf($report_id)
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


                    'result_prepared_key_ind'    => 1,
                    'result_prepared_keyed_by'   => $result_prepared_by,
                    'result_prepared_keyed_time' => date("Y-m-d"),
                    'result_verify_key_ind'      => 1,
                    'result_verify_keyed_by'     => $result_verified_by,
                    'result_verify_keyed_time'   => date("Y-m-d"),
                    'result_ent_key_ind'       => 1,
                    'result_ent_keyed_by'      => $request->consultant,
                    'result_ent_keyed_time'    => date("Y-m-d"),

                    'result_con_key_ind' => 1,
                    'result_con_keyed_by' => $request->consultant2,
                    'result_con_keyed_time' => date("Y-m-d"),
                ];

                $invoice_data = [
                    'lab_result_final_key_ind'    => 1,
                    'lab_result_final_keyed_by'   => $result_finalize_by,
                    'lab_result_final_keyed_time' => date("Y-m-d"),
                    'au_update_hospital_pk_no' => $ses_hospital_id,
                    'lab_result_prepared_key_ind'    => 1,
                    'lab_result_prepared_keyed_by'   => $result_prepared_by,
                    'lab_result_prepared_keyed_time' => date("Y-m-d"),
                    'lab_result_verify_key_ind'    => 1,
                    'lab_result_verify_keyed_by'   => $result_verified_by,
                    'lab_result_verify_keyed_time' => date("Y-m-d"),
                    'lab_result_entry_key_ind'    => 1,
                    'lab_result_entry_keyed_by'   => $request->consultant,
                    'lab_result_entry_keyed_time' => date("Y-m-d"),
                    'lab_result_con_key_ind' => 1,
                    'lab_result_con_keyed_by' => $request->consultant2,
                    'lab_result_con_keyed_time' => date("Y-m-d")
                ];
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

            Db::table("labt_testreporting")->where("report_no_pk", $hdn_report_id)->update($report_data);
            LabInvoiceDtl::where("report_no_fk", $hdn_report_id)->update($invoice_data);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }


    public function resultAfbPdf($report_id)
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


            return view("admin.pathology.path_afb_report", ['incuvation_dt' => $incuvation_dt, "po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'report_data_1' => $report_data_1])->render();


            $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
            ];
            // AU_UPDATE_BY
            $data['au_update_by'] = $auth_id;
            $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
            DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
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
        $prepared_by = $this->getPathologyResultEntryByUser("save_ind", "labresult_list1_ind",$result_info->su_no_fk);
        $verified_by = $this->getPathologyResultEntryByUser("verify_ind", "labresult_list2_ind",$result_info->su_no_fk);
        $finalize_by = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list3_ind",$result_info->su_no_fk);
        $consult = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list4_ind",$result_info->su_no_fk);
        $consult2 = $this->getPathologyResultEntryByUser("finalize_ind", "labresult_list5_ind",$result_info->su_no_fk);


        $analyzer = DB::table('sysc_serviceitem')->select('item_code', 'item_name', 'interpretation')->where('analyzer_ind', 1)->get();

        $default_values = DB::table('labs_teststructval')->where('status', 1)->orderBy('sl_no', 'asc')->get();
        return Template::loadview("admin.pathology.result_entry_form_2column", ["report_id" => $report_id, "result_info" => $result_info, "patient_info" => $patient_info, "result_test_info" => $result_test_info, "prepared_by_columns" => $prepared_by, "verified_by_columns" => $verified_by, "finalize_by_columns" => $finalize_by, "type" => $type, 'result_item' => $result_item, 'lab_id' => $lab_id, 'analyzer' => $analyzer, 'default_values' => $default_values, 'consult' => $consult, 'consult2' => $consult2]);
    }
    public function resultCsfPdf($report_id)
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

            $pdf = PDF::loadView("admin.pathology.csf_report_pdf", ["po_hospital_details" => $po_hospital_details, "report_varcode" => $report_varcode, "invoice_varcode" => $invoice_varcode, 'patient_varcode' => $patient_varcode, "report_header" => $report_header, "report_data" => $report_data, 'attr_group' => $attr_group]);


            $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
            ];
            // AU_UPDATE_BY
            $data['au_update_by'] = $auth_id;
            $data['au_update_hospital_pk_no'] = Session::get('user.ses_hospital_no_pk');
            DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);
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
        $result_test_info = DB::table('microbiology_antibiotic')->where('status', 1)->get();
        if ($request->organism_type == 2 && $request->orgnsm_name_2 != "") {

            return Template::loadView("admin.pathology.microbiology.microbiology_two_columns_report", [
                "result_test_info" => $result_test_info, "hospital" => $hospital, "orgnsm_name_1" => $request->orgnsm_name_1, "orgnsm_name_2" => $request->orgnsm_name_2
            ]);
        } else {
            if ($request->organism_type != 3) {
                return Template::loadView("admin.pathology.microbiology.microbiology_single_columns_report", [
                    "result_test_info" => $result_test_info, "hospital" => $hospital, "orgnsm_name_1" => $request->orgnsm_name_1, "orgnsm_name_2" => $request->orgnsm_name_2
                ]);
            }
        }
        if ($request->organism_type == 3 && $request->orgnsm_name_3 != "") {
            return Template::loadView("admin.pathology.microbiology.microbiology_three_columns_report", [
                "result_test_info" => $result_test_info, "hospital" => $hospital, "orgnsm_name_1" => $request->orgnsm_name_1, "orgnsm_name_2" => $request->orgnsm_name_2, "orgnsm_name_3" => $request->orgnsm_name_3
            ]);
        } else {
            return Template::loadView("admin.pathology.microbiology.microbiology_two_columns_report", [
                "result_test_info" => $result_test_info, "hospital" => $hospital, "orgnsm_name_1" => $request->orgnsm_name_1, "orgnsm_name_2" => $request->orgnsm_name_2
            ]);
        }
    }
}
