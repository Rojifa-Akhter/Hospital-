<?php

namespace App\Http\Controllers;

namespace App\Http\Controllers;

use App;
use App\Core\Ambulance\Ambulance;
use App\Datatables\DataTableClass;
use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Billing;
use App\Models\LookupItem;
use App\Models\GrantUserService;
use App\Models\Item;
use App\Models\PhysiotherapySchedule;
use App\Core\TV\TVService;
use App\Core\TV\PharmacyTVService;
use App\Models\ServiceUnit;
use App\Repositories\BaseRepository as Repo;
use App\Repositories\BillingRepository;
use App\Traits\DatatablesLoader;
use App\Traits\LookupData;
use Auth;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
use DB;
use Illuminate\Http\Request;
use PDO;
use \PDF;
use Session;
use Carbon\Carbon;
use Response;
use View;

class AmbulanceController extends Controller
{
    use LookupData, DatatablesLoader;

    protected $base;
    protected $billingRepository;
    protected $Ambulance;
    public $patientId = "";

    public function __construct(Billing $billing, PhysiotherapySchedule $physiotherapyschedule,  TVService $tv_information, PharmacyTVService $pharmacy_tv_information,Ambulance $Ambulance)
    {
        $this->Ambulance=$Ambulance;
        $this->middleware('auth');
        $this->base = new Repo($billing);
        $this->billingRepository = new BillingRepository($billing, $tv_information, $pharmacy_tv_information);
       
        $this->physiotherapyschedule = new Repo($physiotherapyschedule);
        
    }

    public function ambulanceTripList(){
        return Template::loadView("admin.ambulance.ambulance_trip_list");
    }
    public function ambulanceTripGetData(){
        $bockedTrip_info=$this->Ambulance->bockedTripList();
        $bockedTripList = json_decode($bockedTrip_info->getContent(), true);
        // dd( $bockedTripList);
        return response()->json(["success" => true, "data" => $bockedTripList], 200);
    }
    public function ambulanceTripGetCompletedData(){
        $completedTripList=$this->Ambulance->CompletedTripList();
        $completedTripList = json_decode($completedTripList->getContent(), true);
        // dd( $completedTripList);
        return response()->json(["success" => true, "data" => $completedTripList], 200);
    }
    public function ambulanceTripSetup(){
        $ambulance_info=$this->Ambulance->ambulanceList();
        $ambulanceList = json_decode($ambulance_info->getContent(), true);
       
        return Template::loadView("admin.ambulance.ambulance_trip_setup", ['ambulance_info'=>$ambulanceList]);

    }
    public function ambulanceTripEdit($id){
        $trip_info=$this->Ambulance->tripList($id);
        $tripList = json_decode($trip_info->getContent(), true);
        $ambulance_info=$this->Ambulance->ambulanceList();
        $ambulanceList = json_decode($ambulance_info->getContent(), true);
   
        $assign_ambulance_info=DB::table('ambs_ambulance')->select('ambs_ambulance_name','ambs_ambulance_no_pk','no_plate')->where('ambs_ambulance_no_pk', $tripList['ambs_ambulance_no_fk'])->first();

        if ($assign_ambulance_info) {
            $assign_ambulance_info = (array)$assign_ambulance_info; // Casting the object to an associative array
        } else {
            $assign_ambulance_info = []; // Handle the case where no ambulance information is found
        }
        $ambulanceList = array_merge(array_merge($ambulanceList, [$assign_ambulance_info]));
        // dd($ambulanceList,$assign_ambulance_info,$tripList);
        return Template::loadView("admin.ambulance.ambulance_trip_setup", ['ambulance_info'=>$ambulanceList,'tripList'=>$tripList]);

    }
    public function ambulanceTripSave(Request $request){
     
     
      try {
        $saveData=  $this->Ambulance->ambulanceTripSave($request);
        return response()->json(['msg' => 'Data Saved Successfully', 'title' => 'Success'],200);

        } catch(\Exception $e) {

            return response()->json(['msg' => $e->getMessage(), 'title' => 'Error'],200);
        }
        // dd( $saveData);
    }
   
    public function ambulanceSetup(){
       
        return Template::loadView("admin.ambulance.ambulance_setup");

    }
    public function ambulanceSetupEdit($id){
       
        $find_ambulance_info=$this->Ambulance->fineAmbulanceInfo($id);
        $find_ambulanceList = json_decode($find_ambulance_info->getContent(), true);  
       
        return Template::loadView("admin.ambulance.ambulance_setup", ['ambulance_info'=>$find_ambulanceList]);

    }
    public function ambulanceSetupList(){
       
        $all_ambulance_info=$this->Ambulance->allAmbulanceInfo();
        $all_ambulanceList = json_decode($all_ambulance_info->getContent(), true);  
       
        return Template::loadView("admin.ambulance.ambulance_setup_list", ['ambulance_info'=>$all_ambulanceList]);

    }
    public function ambulanceSetupSave(Request $request){
     
     
        try {
          $saveData=  $this->Ambulance->ambulanceSetupSave($request);
          return response()->json(['msg' => 'Data Saved Successfully', 'title' => 'Success'],200);
  
          } catch(\Exception $e) {
  
              return response()->json(['msg' => $e->getMessage(), 'title' => 'Error'],200);
          }
          // dd( $saveData);
      }
    public function ambulanceBilling($id = ""){
        $patientId = explode('-', $id);
        // dd($id);
        $trip_info=$this->Ambulance->tripList($id);
        $tripList = json_decode($trip_info->getContent(), true);
            $patient_info = [];
            $item_info = [];
            $ref_info = [];
            $item_type = "";
            $page_type = "";
            $service_id = "";
        
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $reg_type = $this->getLookupListByCode("REGTYPE");

        $marital_status = $this->getLookupListByCode("MARSTS");
        $gender = $this->getLookupListByCode("GENDER");
        $bloodg = $this->getLookupListByCode("BLOODG");
        $disctype = $this->getLookupListByCodeCustomKey("lookupdata_code", "DISCTYPE");
        $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $service_unit = ServiceUnit::where('status', '1')->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        //$service_point = ServiceUnit::where('cash_counter_ind', '1')->where("status","1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')->orderBy('serviceunit_name', 'asc')->get();
        $service_point = GrantUserService::where('user_no_pk', auth()->user()->user_no_pk)->where("GRANTSU_STATUS", "1")->where("cash_counter_ind", "1")->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code', 'grantsu_status', 'default_ind')->orderBy('serviceunit_name', 'asc')->get();
        $bank_name = $this->getLookupListByCode("AGENTBANKING");

        $item_type=DB::table('sysc_itemtype_workflow')->select('workflow_code')->where('service_billing_ind',1)->where('status',1)->orderBy('workflow_code','asc')->get()->toArray();
        $item_type_list=[];
        if (!empty($item_type)) {
            foreach ($item_type as $key => $value) {
                $item_type_list[]=$value->workflow_code;
            }
        }
    $item_type_lists=!empty($item_type_list) ? implode(',',$item_type_list)  :'';

        $pay_mode = ["CS" => "Cash"];

        $check = request('su');

        return Template::loadView("admin.ambulance.ambulance-billing", [
            'marital_status' => $marital_status,
            'gender' => $gender,
            'bloodg' => $bloodg,
            'disctype' => $disctype,
            'paymodes' => $paymodes,
            'reg_type' => $reg_type,
            'service_unit' => $service_unit,
            'service_point' => $service_point,
            'patientId' => $patient_info,
            'check' => $check,
            'item_info' => $item_info,
            'item_type' => $item_type,
            'page_type' => $page_type,
            'service_id' => $service_id,
            'bank_name' => $bank_name,
            'ref_info' => $ref_info,
            'po_hospital_details' => $po_hospital_details,
            'item_type_lists' => $item_type_lists,
            'trip_info' => $tripList,

        ]);

    }

    public function storeAmbulanceBilling(Request $request){

        if (Session::get('user.ses_hospital_version') == "V0") {

            return $this->billingRepository->ambulanceBillCreateOrUpdateV1($request, $request->id);
        } else {
            return $this->billingRepository->abmulanceBillcreateOrUpdate($request, $request->id);
        }

    }

    public function ambulanceBillInvoice($invoice_id, $trx = "")
    {
        // dd($invoice_id);
        $page_type = "";

        // $paymodes = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $ledger_no_trx = DB::table("finc_ledgermst")
            ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = isset($ledger_no_trx->ledger_no_pk) ? $ledger_no_trx->ledger_no_pk : 0;
        $paymood = DB::table("finc_ledger_paymood")
            ->select('pay_amount','pay_mood_type','paymood')
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
            ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','admission_date','invoice_remarks','au_entry_by','au_entry_at','patient_type_code','age','invoice_no_pk')
            ->where("invoice_no_pk", $invoice_id)
            ->first();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_doc','disc_amt_by_hosp','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            // ->where("DISC_AMT_BY_DOC", '!=', 0)
            // ->whereNotNull("DISC_AMT_BY_DOC")
            // ->orWhere("DISC_AMT_BY_HOSP" ,'!=', 0)
            ->orderBy("ledger_no_pk", "desc")
            ->first();

        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->select('new_bed_name','bed_name')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }

        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();
        //dd($invoice_mst_info);
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "invoicedtl_no_pk", "item_rate_orig", "service_charge", "cancel_ind")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "invoicedtl_no_pk", "item_rate_orig", "service_charge", "cancel_ind")
            ->orderBy('invoicedtl_no_pk', 'asc')
            ->get();

        // $ledger_payment = DB::select("SELECT sum(pay_amount) pay_amount  FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id and ledger_no_fk = $l_date");
        // if (isset($ledger_payment)) {
        //     foreach ($ledger_payment as $value) {
        //         $ledger_pay_amount = $value;
        //     }
        // }


        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), 'invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->first();

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        return Template::loadView("admin.ambulance.ambulance-billing-invoice", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'paymood' => $paymood,'page_type' => $page_type, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount, 'bed_details' => $bed_details]);


    }

    public function ambulancebillInvoicePrintA5($invoice_id, $page = "", $trx = "")
    {
        // dd($trx);

        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $ledger_no_trx = DB::table("finc_ledgermst")
            ->select('ledger_code')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();
        $l_date = isset($ledger_no_trx->ledger_code) ? $ledger_no_trx->ledger_code : 0;
        $paymood = DB::table("FINC_LEDGER_PAYMOOD")
            ->select('pay_amount','pay_mood_type')
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->orderBy("LEDGER_NO_FK", "DESC")
            ->get();
        // dd($paymood);
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','admission_date','invoice_remarks','au_entry_by','invoice_no_pk')
            ->where("invoice_no_pk", $invoice_id)
            ->first();
        $bed_details = '';
        if (isset($invoice_mst_info->admission_no_pk)) {
            $ipd_adm = DB::table('ipd_admitted_patlist_vw')->select('new_bed_name','bed_name')->where('admission_no_pk', $invoice_mst_info->admission_no_pk)->first();
            $bed_details = !empty($ipd_adm->new_bed_name) ? strtoupper($ipd_adm->new_bed_name) : $ipd_adm->bed_name;
        }
        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_doc','disc_amt_by_hosp','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();



        $ledger_no = DB::select("SELECT * FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id and ledger_no_fk= $l_date");

        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "invoicedtl_no_pk", "disc_amount", "item_rate_orig", "service_charge", "cancel_ind", "item_type", "su_sl_no")

            ->orderBy('su_sl_no', 'asc')
            ->orderBy('invoicedtl_no_pk', 'asc')

            ->get();
        // dd( $invoice_dtls_info);
        // ->where("invoice_no_fk", $invoice_id)
        // ->get();
        $item_type = DB::table("finc_invoicedtl_vw")
            ->where("invoice_no_fk", $invoice_mst_info->invoice_no_pk)
            ->select("item_type_name")->first();
        // dd($item_type);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();

        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();
        $userInfo = Auth::user();


        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), DB::raw('sum(service_charge_dtl) as service_charge_dtl'), 'invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee', 'ledger_amt_vat')->first();

        // dd( $finc_inv_sum_amount);

        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk','collection','refund')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        $pdf = App::make('dompdf.wrapper');

        $collector_info = DB::table('finc_ledgertrn')
            ->select('finc_ledgertrn.ledgertrn_datetime', 'wsec_user.user_fullname')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'finc_ledgertrn.au_entry_by')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_fk', '=', $invoice_id)
            ->get();
        $ambulance_data=DB::table('ambt_ambulancetrip')
        ->leftJoin('hrms_personnel','hrms_personnel.person_no_pk','=','ambt_ambulancetrip.person_no_fk')
        ->select('hrms_personnel.full_name','ambt_ambulancetrip.*')
        ->where('invoice_no_fk',$invoice_id)
        ->first();
        // dd($ambulance_data);
        if ($po_hospital_details->hospital_code != 'KBMH') {
            $pdf = PDF::loadView("admin.ambulance.ambulance-billing-invoice-print", ['collector_info' => $collector_info, 'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,  'paymood' => $paymood,  'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount, 'bed_details' => $bed_details,'ambulance_data'=>$ambulance_data])->setPaper('a5', 'portrait');
        } else {
            $pdf = PDF::loadView("admin.billing.billing_invoice_print_kbmh", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,  'paymood' => $paymood,  'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount])->setPaper('a5', 'portrait');
        }
        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }

    public function billingList(Request $request)
    {

        $corporate_info = DB::table('ccm_corporateclient_vw')->select('ccm_client_no_pk', 'ccm_client_code', 'ccm_client_name')->where('active_status', '=', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        // dd( $corporate_info);
        return Template::loadView("admin.ambulance.ambulance-billing-list", ['corporate_info' => $corporate_info]);
    }

    public function billList(Request $request)
    {

        // $table = 'billing_list_vw';
        // $table = 'finc_inv_billing_list_vw';
        $table = 'finc_amb_inv_billing_list_vw';
        // Table's primary key
        $primaryKey = 'invoice_no_pk';
        $to_date=date('Y-m-d');
        $hospital_id =  Session::get('user.ses_hospital_no_pk');
        $where = "trunc(INVOICE_DATE) = '$to_date' and au_entry_hospital_pk_no =$hospital_id and  invoice_trn_list is not null and module_code ='AMB'"; //and module_code in ('OPD','OPDC','HSPOS') and (not serviceunit_name='IPD')and module_code in ('OPD','OPDC','HSPOS') and (not serviceunit_name='IPD')

        $columns = array(
            array('db' => 'start_from_location', 'dt' => 0),
            array('db' => 'ended_to_location', 'dt' => 1),
            array('db' => 'remarks_text', 'dt' => 2),
            array('db' => 'item_no_fk', 'dt' => 3),
            array('db' => 'amb_name', 'dt' => 4),
            array('db' => 'invoice', 'dt' => 5),
            array('db' => 'invoice_no_pk', 'dt' => 6),
            array('db' => 'invoice_code', 'dt' => 7),
            array('db' => 'invoice_date', 'dt' => 8),
            array('db' => 'patient_no_fk', 'dt' => 9),
            array('db' => 'patient_name', 'dt' => 10),
            array('db' => 'patient_gender', 'dt' => 11),
            array('db' => 'phone_mobile', 'dt' => 12),
            array('db' => 'au_entry_time', 'dt' => 13),
            array('db' => 'au_update_at', 'dt' => 14),
            array('db' => 'au_entry_hospital_pk_no', 'dt' => 15),
            array('db' => 'au_entry_by', 'dt' => 16),
            array('db' => 'cashier_name', 'dt' => 17),
            array('db' => 'admission_no_fk', 'dt' => 18),
            array('db' => 'module_code', 'dt' => 19),
            array('db' => 'invoice_trn_list', 'dt' => 20),
            array('db' => 'sales', 'dt' => 21),
            array('db' => 'due', 'dt' => 22),
            array('db' => 'sales_cancel', 'dt' => 23),
            array('db' => 'ledger_amt_sales', 'dt' => 24),
            array('db' => 'discount', 'dt' => 25),
            array('db' => 'collection', 'dt' => 26),
            array('db' => 'refund', 'dt' => 27),
            array('db' => 'trip_patient_type', 'dt' => 28),

        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function searchBillList(Request $request)
    {

        $invoice_id = $request->invoice_id;
        $patient_id = $request->hdn_patient_id;
        $doctor_code = $request->hdn_doctor_id;
        $admission_id = $request->admission_id;
        $corporate_name = $request->corporate_name;
        $full_bill = $request->full_paid;
        $due_bill = $request->due_bill;
        $all_paid = $request->all_paid;

        $opd = ''; //"module_code IN ('OPD', 'OPDC','IPD') and serviceunit_name not IN ('IPD') ";

        $date_from = $request->date_from ? date('Y-m-d', strtotime($request->date_from)) : '';
        $date_to = $request->date_to ? date('Y-m-d', strtotime($request->date_to)) : "";

        $sql_cond = $opd;
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $invoice_id != "" ? " $clause invoice_code = '$invoice_id'" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $date_from && $date_to != "" ? " $clause to_char(invoice_date,'YYYY-MM-DD') between '$date_from' and '$date_to' " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $patient_id != "" ? " $clause patient_no_fk = $patient_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        // $sql_cond .= $doctor_code != "" ? " $clause person_no_fk = $doctor_code " : "";
        // $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $admission_id != "" ? " $clause admission_no_fk = $admission_id " : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        // $sql_cond .= $corporate_name != "" ? "$clause ccm_client_no_fk = $corporate_name" : "";
        // $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $due_bill != "" ? " $clause due > 0" : "";
        // $sql_cond .= $due_bill != "" ? " $clause ((urgent_fee +ledger_amt_sales) - ledger_amt_discount) - ledger_amt_payment > 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $full_bill != "" ? "$clause due = 0" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause invoice_no_pk is not null" : "";
        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= $sql_cond != "" ? "$clause au_entry_hospital_pk_no =" . Session::get('user.ses_hospital_no_pk') : "";

        // $clause = ($sql_cond != "") ? " and" : " ";
        // $sql_cond .= $sql_cond != "" ? "$clause module_code in ('OPD','OPDC','HSPOS') and (not serviceunit_name='IPD')"  : "";

        $clause = ($sql_cond != "") ? " and" : " ";
        $sql_cond .= ($request->bill_type) != "" ? "$clause " . $request->bill_type . " > 0"  : "";

        $table ='finc_amb_inv_billing_list_vw';// 'finc_inv_billing_list_vw';
        $primaryKey = 'invoice_no_pk';

        // $data=DB::select("select coun(invoice_no_pk) from finc_inv_billing_list_vw  $sql_cond");
        // dd($data);
        $columns = array(
            array('db' => 'start_from_location', 'dt' => 0),
            array('db' => 'ended_to_location', 'dt' => 1),
            array('db' => 'remarks_text', 'dt' => 2),
            array('db' => 'item_no_fk', 'dt' => 3),
            array('db' => 'amb_name', 'dt' => 4),
            array('db' => 'invoice', 'dt' => 5),
            array('db' => 'invoice_no_pk', 'dt' => 6),
            array('db' => 'invoice_code', 'dt' => 7),
            array('db' => 'invoice_date', 'dt' => 8),
            array('db' => 'patient_no_fk', 'dt' => 9),
            array('db' => 'patient_name', 'dt' => 10),
            array('db' => 'patient_gender', 'dt' => 11),
            array('db' => 'phone_mobile', 'dt' => 12),
            array('db' => 'au_entry_time', 'dt' => 13),
            array('db' => 'au_update_at', 'dt' => 14),
            array('db' => 'au_entry_hospital_pk_no', 'dt' => 15),
            array('db' => 'au_entry_by', 'dt' => 16),
            array('db' => 'cashier_name', 'dt' => 17),
            array('db' => 'admission_no_fk', 'dt' => 18),
            array('db' => 'module_code', 'dt' => 19),
            array('db' => 'invoice_trn_list', 'dt' => 20),
            array('db' => 'sales', 'dt' => 21),
            array('db' => 'due', 'dt' => 22),
            array('db' => 'sales_cancel', 'dt' => 23),
            array('db' => 'ledger_amt_sales', 'dt' => 24),
            array('db' => 'discount', 'dt' => 25),
            array('db' => 'collection', 'dt' => 26),
            array('db' => 'refund', 'dt' => 27),
            array('db' => 'trip_patient_type', 'dt' => 28),

        );
        // dd(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        if (!empty($sql_cond)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $sql_cond));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function bill_invoice_app_print($invoice_id, $page = "", $trx = "")
    {

        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // $pay_mode = $this->getLookupListByCodeCustomKey("lookupdata_code", "PAYMODE");
        //     $ledger_no = DB::table("finc_ledgermst")
        //     ->where("invoice_no_fk", $invoice_id)
        //     ->where("ledgertrn_no_fk", $trx)
        //     ->where("trn_type_code", 'PAYMENT')
        //     // ->orWhere("trn_type_code", 'SALES')
        //     ->orderBy("LEDGER_CODE", "DESC")
        //     ->first();

        // $l_date = isset($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;

        // dd($paymood);
        // $invoice_mst_info = DB::table("finc_invoicemst_sum_vw")
        //     ->where("invoice_no_pk", $invoice_id)
        //     ->first();

        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','au_entry_at','patient_type_code','age','invoice_remarks','invoice_no_pk','appoint_service_no_fk','au_entry_by','doc_serviceunit_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_datetime", "DESC")
            ->first();
        $app_id = $invoice_mst_info->appoint_service_no_fk != "" ? $invoice_mst_info->appoint_service_no_fk : '';
        $appoint_type = '';
        if ($app_id != "") {
            $appoint_type = DB::table('patn_appointment_vw')->select('appoint_typename')->where('appoint_no_pk', $app_id)->first()->appoint_typename;
        }
        // dd( $appoint_type);

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_hosp','disc_amt_by_doc','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            // ->where("DISC_AMT_BY_DOC", '!=', 0)
            // ->whereNotNull("DISC_AMT_BY_DOC")
            // ->orWhere("DISC_AMT_BY_HOSP" ,'!=', 0)
            ->orderBy("ledger_no_pk", "desc")
            ->first();
        // dd($ledgermst_paydisc);
        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();

    //     $total_sale = DB::select("SELECT SUM(ledger_amt_payment) ledger_amt_payment FROM finc_invoicemst_sum_vw
    //   WHERE invoice_no_pk = $invoice_id");
    //     foreach ($total_sale as $value) {
    //         $total_sales = $value;
    //     }
    //     $total_discount = DB::select("SELECT SUM(ledger_amt_discount) ledger_amt_discount FROM finc_invoicemst_sum_vw
    //   WHERE invoice_no_pk = $invoice_id");
    //     foreach ($total_discount as $dis) {
    //         $total_dis = $dis;
    //     }
    //     $ledger_payment = DB::select("SELECT sum(pay_amount) pay_amount  FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id");

    //     if (isset($ledger_payment)) {
    //         foreach ($ledger_payment as $value) {
    //             $ledger_pay_amount = $value;
    //         }
    //     }

        // $ledger_no = DB::select("SELECT * FROM FINC_LEDGER_PAYMOOD WHERE LEDGER_NO_FK=(SELECT max(LEDGER_NO_FK) FROM FINC_LEDGER_PAYMOOD) AND invoice_no_fk = $invoice_id ");


        $ledger_no_trx = DB::table("finc_ledgermst")
            ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = isset($ledger_no_trx->ledger_no_pk) ? $ledger_no_trx->ledger_no_pk : 0;
        $paymood = DB::table("finc_ledger_paymood")
        ->select('paymood','pay_amount','pay_mood_type')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledger_no_fk", $l_date)
            ->get();

        // $ledger_no = DB::table("FINC_LEDGER_PAYMOOD")
        //     ->where("invoice_no_fk", $invoice_id)
        //     ->where("LEDGER_NO_FK", $l_date)
        //     ->orderBy("LEDGER_NO_FK", "DESC")
        //     ->get();
        $ledger_no = DB::select("SELECT paymood,pay_mood_type, pay_amount FROM FINC_LEDGER_PAYMOOD WHERE  invoice_no_fk = $invoice_id and ledger_no_fk = $l_date");

        // $invoice_dtls_info = DB::table("finc_invoicedtl_vw")
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
        ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "disc_perc", "disc_amount", "item_vat", "item_rate_orig", "service_charge", "cancel_ind")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->get();
        // ->where("invoice_no_fk", $invoice_id)
        // ->get();
        // $item_type = DB::table("finc_invoicedtl_vw")
        //     ->where("invoice_no_fk", $invoice_mst_info->invoice_no_pk)
        //     ->select("item_type_name")->first();
        // dd($item_type);
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_mst_info->invoice_code);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $invoice_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($invoice_mst_info->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();
        // $item_sub_total = DB::select("select SUM(item_rate) item_rate FROM finc_invoicedtl where invoice_no_fk = $invoice_id and cancel_ind is null");
        // foreach ($item_sub_total as $value) {
        //     $sub_total = $value->item_rate;
        // }

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'), 'invoice_no_pk', 'urgent_fee')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee')->first();
        // dd(  $finc_inv_sum_amount);
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        $preparedBy = DB::table('wsec_user')->select('user_name')->where('user_no_pk', $invoice_mst_info->au_entry_by)->first();
        $pdf = App::make('dompdf.wrapper');
        //return view("admin.billing.billing_invoice_print", ['invoice_id'=>$invoice_id,'invoice_mst_info' => $invoice_mst_info,'invoice_dtls_info' => $invoice_dtls_info,'pay_mode' => $pay_mode,'invoice_barcode'=>$invoice_barcode , 'userInfo' => $userInfo,'pat_barcode' => $pat_barcode]);
        // dd($invoice_mst_info);

        $collector_info = DB::table('finc_ledgertrn')
            ->select('finc_ledgertrn.ledgertrn_datetime', 'wsec_user.user_fullname')
            ->join('wsec_user', 'wsec_user.user_no_pk', 'finc_ledgertrn.au_entry_by')
            ->where('ledgertrn_no_pk', '<=', $trx)
            ->where('invoice_no_fk', '=', $invoice_id)
            ->get();

        $pdf = PDF::loadView("admin.ambulance.billing_invoice_app_print", ['collector_info' => $collector_info, 'invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'invoice_barcode' => $invoice_barcode, 'userInfo' => $userInfo, 'pat_barcode' => $pat_barcode,  'paymood' => $paymood, 'ledger_no' => $ledger_no, 'page' => $page, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'ledgermst_paydisc' => $ledgermst_paydisc,  'appoint_type' => $appoint_type, 'preparedBy' => $preparedBy, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount])->setPaper('a5', 'portrait');

        return $pdf->stream("invoice.pdf", array("Attachment" => false));
    }

    public function bill_invoice_app($invoice_id, $trx = "")
    {

        $page_type = "";

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $ledger_no = DB::table("finc_ledgermst")
            ->select('ledger_no_pk')
            ->where("invoice_no_fk", $invoice_id)
            ->where("ledgertrn_no_fk", $trx)
            ->where("trn_type_code", 'PAYMENT')
            // ->orWhere("trn_type_code", 'SALES')
            ->orderBy("LEDGER_CODE", "DESC")
            ->first();

        $l_date = isset($ledger_no->ledger_no_pk) ? $ledger_no->ledger_no_pk : 0;

        $paymood = DB::table("finc_ledger_paymood")
        ->select('paymood','pay_amount','pay_mood_type')
            ->where("invoice_no_fk", $invoice_id)
            ->where("LEDGER_NO_FK", $l_date)
            ->get();
        $invoice_mst_info = DB::table("finc_inv_patientdetail_vw")
        ->select('invoice_code','patient_code','patient_name','dob','gender_txt','mobile1','present_addr','doctor_name','first_doc_name','person_code','second_doc_name','report_delivary_date','invoice_date','report_delivary_datetime','admission_no_pk','au_entry_at','patient_type_code','age','invoice_remarks','invoice_no_pk')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_datetime", "DESC")
            ->first();

        $ledgermst_paydisc = DB::table("finc_ledgermst_paydisc_vw")
        ->select('disc_amt_by_hosp','disc_amt_by_doc','disc_amt_request_name')
            ->where("invoice_no_pk", $invoice_id)
            ->orderBy("ledger_no_pk", "desc")
            ->first();

        $discout_by = DB::table('FINC_INVOICEMST_SUM_VW inv')->select('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->join('finc_ledgermst mst', 'inv.INVOICE_NO_PK', '=', 'mst.invoice_no_fk')->leftJoin('hrms_personnel per', 'per.person_no_pk', '=', 'mst.DISC_AMT_BY_DOC_NO_FK')->where('inv.INVOICE_NO_PK', $invoice_id)->whereNotNull('mst.DISC_AMT_BY_DOC_NO_FK')->groupBy('inv.INVOICE_NO_PK', 'MST.DISC_AMT_BY_DOC_NO_FK', 'per.full_name')->first();
        //dd($invoice_mst_info);
        $invoice_dtls_info = DB::table("finc_inv_itemdtl_vw")
        ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee", "cancel_qty", "disc_perc", "disc_amount", "item_vat", "item_rate_orig", "service_charge", "cancel_ind")
            ->where("invoice_no_fk", $invoice_id)
            ->select("item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->groupBy("itemtype_no_fk", "item_code", "report_delivery_date", "delivery_status_lookup_no_fk", "item_qty", "item_rate", "itemtype_no_fk", "item_name", "urgent_fee")
            ->get();

        $finc_inv_sum_amount = DB::table('finc_inv_c022_sum_amount_vw')->select(DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(net_sales) as net_sales'), DB::raw('sum(collection) as collection'), DB::raw('sum(due) as due'), DB::raw('sum(refund) as refund'), DB::raw('sum(net_collection) as net_collection'),'invoice_no_pk', 'urgent_fee')->where('ledgertrn_no_pk', '<=', $trx)->where('invoice_no_pk', $invoice_id)->groupby('invoice_no_pk', 'urgent_fee')->first();
        $finc_inv_collection_amount = DB::table('finc_inv_c022_sum_amount_vw')->select('ledgertrn_no_pk')->where('ledgertrn_no_pk', '=', $trx)->where('invoice_no_pk', $invoice_id)->first();

        return Template::loadView("admin.ambulance.billing_invoice_app", ['invoice_id' => $invoice_id, 'invoice_mst_info' => $invoice_mst_info, 'invoice_dtls_info' => $invoice_dtls_info,  'paymood' => $paymood, 'page_type' => $page_type, 'discout_by' => $discout_by, 'po_hospital_details' => $po_hospital_details, 'finc_inv_sum_amount' => $finc_inv_sum_amount, 'finc_inv_collection_amount' => $finc_inv_collection_amount]);
    }
}
