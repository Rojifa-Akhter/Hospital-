<?php

namespace App\Http\Controllers;

use App\Library\Template;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Session;
use \PDF;
use PDO;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;
class IPDMedicationController extends Controller
{
    //
    public function __construct()
    {
        date_default_timezone_set('Asia/Dhaka');
    }
    public function medicationList(Request $request,$patient_no_fk, $admission_id)
    {

        $medication_list = DB::table("psn_t_prescription_med_ns_vw")->where('admission_no_fk',$admission_id)->where('PATIENT_NO_FK',$patient_no_fk)->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadView("admin.ipd.nurse_station.medication_worklist", ['medication_list' => $medication_list]);
    }


    public function medicationPopUp($admission_no, $med_no, $prescribed_med_pk)
    {
        $medication_no_pk = DB::table("psn_t_prescription_med_ns_vw")->where('pres_med_no_fk', $prescribed_med_pk)->first();
        // dd($medication_no_pk);
        return Template::loadView("admin.ipd.nurse_station.medication_pop_up", ['prescribed_med_adm_no_pk' => $medication_no_pk]);
    }

    public function storeMedicationPopUp(Request $request)
    {

        $patient_details=DB::table('ipd_admission_details admi')->select('admi.ns_receive_by','nsds.su_no_fk')->where('admi.admission_no_pk', $request->admission_id)->leftjoin('IPDS_NSDS nsds','nsds.nsds_no_pk','=','admi.ns_receive_by')->first();

        $sequence = DB::getSequence();
        $prescribed_med_admdtl_pk_no_seq = $sequence->nextValue('prescribed_med_admdtl_pk_no_seq');
        $dosage = explode('+', $request->dosage);
        $date = date('Y-m-d H:i:s');
        if($request->duration != null){
            $time = $request->duration;
            $newDate = date('Y-m-d H:i:s', strtotime($date . ' -' . $time . ' minutes'));
        }else{
            $newDate = date('Y-m-d H:i:s');
        }
        $duration_hour = $request->duration_hour;

        $newTime = date('Y-m-d H:i:s', strtotime($date . ' +' . $duration_hour . ' hours'));
        $pdo = DB::getPdo();

        // if ($request->transit_type == 2) {
            $transferIn = 'ISSUE';

        // }else{
        //     $transferIn = 'RECEIVE';
        // }
        $chalan_no = 0;//$request->indent;
        $chalan_date = date("d-m-Y"); //'date("Y-m-d");

        $module = 0;
        $in_au_entry_by = Auth::id();
        $in_au_entry_session = 'SESSION';
        $in_au_entry_hospital_pk_no = Session::get('user.ses_hospital_no_pk');
        $numelems = 500;
        $null = '';
        $out_itemreceive_uid = '';
        $service_unit= $request->serviceunit_no_fk;
        $demand_no= 0;//$request->demand_no;

            $store_su_no_fk = isset($patient_details->su_no_fk) ? $patient_details->su_no_fk : 0;
            $from_store_su_no_fk = isset($request->store_from) ? $request->store_from : 0;
            $po_no = '';
            $supplier_no_fk = isset($request->supplier_id) ? $request->supplier_id : 0;
            $stock_type = $request->stock_type;
            $item_pk_no = [];
            $item_pvms = [];
            $item_qty = [];
            $item_uom = [];
            $item_price = [];
            $item_entry_dtl = [];
            $empty_arr = [];
            $hdn_single_quantity = [];
            $item_uom_phur = [];
            $phur_qty = [];
            $demand_no_fk = 1;
            $in_au_entry_by = Auth::id();
            $in_au_entry_session = 'SESSION';
            $in_au_entry_hospital_pk_no = !empty(Session::get('user.ses_hospital_no_pk')) ? Session::get('user.ses_hospital_no_pk') : '0';
            $numelems = 500;
            $null = '';
            $out_itemtrans_uid = '0';
        $item_id[]=$request->item_pk_no;
        $item_qty[]=$dosage[0];
            if (!empty($item_id)) {
                for ($i = 0; $i < count($item_id); $i++) {
                        $item_pk_no[$i] = isset($item_id[$i]) ? $item_id[$i] : 0;
                        $item_pvms[$i] = $null;
                        $item_query[$i] = DB::table('sysc_serviceitem')->where('item_no_pk', $item_pk_no[$i])->first();
                        $supplier_name= $item_query[$i]->supplier_pk_no;
                        $item_uom[$i]= $item_query[$i]->uom_no_fk;
                        $item_qty[$i] = isset( $item_qty[$i]) ? $item_qty[$i] : 0;
                        $item_price[$i] =  $item_query[$i]->sales_price ?? 0;
                        $item_entry_dtl[$i] = $i + 1;
                        $empty_arr[$i] = 0;





                                // update medication dt
                    db::table('ipd_patindentdtl')
                    ->where([
                        'pres_med_no_fk' => $request->pres_med_pk_no, //need to change
                    ])->update([
                        'consumption_qty' =>  $item_qty[$i], //'nvl(consumption_qty  ,0)'+
                        'consumption_by' => auth::id(),
                        'consumption_at' => date('y-m-d'),
                        'consumption_ind' => 1,
                        'au_update_hospital_pk_no' => session::get('user.ses_hospital_no_pk')
                    ]);
                }
            }





        // $stock_adjustment = $pdo->prepare("begin

        //     pkg_pharmacy.prc_ipdindentinout(
        //     :in_challan_no,
        //     :in_challan_date,
        //     :in_store_su_no_fk,
        //     :in_demand_no_fk,
        //     :in_po_no,
        //     :in_supplier_no_fk,
        //     :in_transtype,
        //     :in_module_no_fk,
        //     :in_a_item_no_fk,
        //     :in_a_item_pvmsno,
        //     :in_a_item_qty,
        //     :in_a_item_uom,
        //     :in_a_freeitem_qty,
        //     :in_a_freeitem_uom,
        //     :in_a_item_price,
        //     :in_a_entry_serial_dtl,
        //     :in_au_entry_by,
        //     :in_au_entry_session,
        //     :in_au_entry_hospital_no_fk,
        //     :out_itemtrans_uid);
        //     end;
        //     ");
        //         $stock_adjustment->bindparam('in_challan_no', $chalan_no);
        //         $stock_adjustment->bindparam('in_challan_date', $chalan_date);
        //         $stock_adjustment->bindparam('in_store_su_no_fk', $store_su_no_fk);
        //         $stock_adjustment->bindparam('in_demand_no_fk', $demand_no);
        //         $stock_adjustment->bindparam('in_po_no', $po_no);
        //         $stock_adjustment->bindparam('in_supplier_no_fk', $supplier_name);


        //         $stock_adjustment->bindparam('in_transtype', $transferIn);
        //         $stock_adjustment->bindparam('in_module_no_fk', $module);
        //         $stock_adjustment->bindArray('in_a_item_no_fk', $item_pk_no, count($item_pk_no), $numelems, SQLT_INT);
        //         $stock_adjustment->bindArray('in_a_item_pvmsno', $item_pvms, count($item_pvms), $numelems, SQLT_CHR);
        //         $stock_adjustment->bindArray('in_a_item_qty', $item_qty, count($item_qty), $numelems, SQLT_INT);
        //         $stock_adjustment->bindArray('in_a_item_uom', $item_uom, count($item_uom), $numelems, SQLT_INT);
        //         $stock_adjustment->bindArray('in_a_freeitem_qty', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
        //         $stock_adjustment->bindArray('in_a_freeitem_uom', $empty_arr, count($empty_arr), $numelems, SQLT_INT);
        //         $stock_adjustment->bindArray('in_a_item_price', $item_price, count($item_price), $numelems, SQLT_FLT);
        //         $stock_adjustment->bindArray('in_a_entry_serial_dtl', $item_entry_dtl, count($item_entry_dtl), $numelems, SQLT_INT);

        //         $stock_adjustment->bindparam('in_au_entry_by', $in_au_entry_by);
        //         $stock_adjustment->bindparam('in_au_entry_session', $in_au_entry_session);
        //         $stock_adjustment->bindparam('in_au_entry_hospital_no_fk', $in_au_entry_hospital_pk_no);
        //         $stock_adjustment->bindParam(':out_itemtrans_uid', $out_itemtrans_uid, PDO::PARAM_STR, 500);


        //      $stock_adjustment->execute();


        // $sequence = DB::getSequence();
        // $prescribed_med_admdtl_pk_no_seq = $sequence->nextValue('prescribed_med_admdtl_pk_no_seq');
        // $dosage = explode('+', $request->dosage);
        // $time = $request->duration;
        // $date = date('Y-m-d H:i:s');
        // $duration_hour = $request->duration_hour;
        // $newDate = date('Y-m-d H:i:s', strtotime($date . ' -' . $time . ' minutes'));
        // $newTime = date('Y-m-d H:i:s', strtotime($date . ' +' . $duration_hour . ' hours'));

        $data = [
            'item_pk_no' => $request->item_pk_no,
            'item_qty' =>  isset($dosage[0]) ? $dosage[0] : 0,
            'admission_no_fk' => $request->admission_id,
            'status' => 1,
            'med_given_lasttime' =>  $newDate,
            'prescribed_med_adm_pk_no' => $request->prescribed_med_adm_pk_no,
            'prescribed_med_admdtl_pk_no' => $prescribed_med_admdtl_pk_no_seq,
            'pres_med_pk_no' => $request->pres_med_pk_no,
            'med_given_lasttime_by'=> Auth::user()->user_no_pk,
            'au_entry_hospital_pk_no'=>  Session::get('user.ses_hospital_no_pk'),
            'med_given_nexttime'=> $newTime,
        ];
        $data['au_entry_by'] = Auth::user()->user_no_pk;
        $data['au_entry_at'] = date('Y-m-d h:i:s');
        $data['au_entry_session'] = 'Medication';
        DB::table('ipd_prescription_med_nsadm')->insert($data);
        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success',];
        return response()->json($message);
    }

    public function patMedicationChartReport($patient_no_fk, $admission_id)
    {
        PDF::setOptions(['isPhpEnabled', 'true']);
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        $ipd_admission = DB::table('ipd_admitted_patlist_vw')->where('admission_no_pk', $admission_id)->first();

        $barcode = new BarcodeGenerator();
        $barcode->setText($ipd_admission->admission_no_pk);
        // $barcode->setText('62542525245');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $admission_barcode = $barcode->generate();
        $pat_code = new BarcodeGenerator();
        $pat_code->setText($ipd_admission->patient_code);
        // $barcode->setText('62542525245');
        $pat_code->setType(BarcodeGenerator::Code128);
        $pat_code->setLabel('');
        $pat_code->setScale(1);
        $pat_code->setThickness(25);
        $pat_code->setFontSize(10);
        $pat_barcode = $pat_code->generate();

        $userInfo = Auth::user();

      //  $patient_vitals =  DB::table('psn_t_patvitals')->where("admission_no_fk", $admission_id)->orderby('au_entry_at','asc')->get();
         $medication_charts_info = DB::table('psn_t_prescription_med_vw med')

         ->join('ipd_prescription_med_nsadm adm','med.prescription_med_no_pk','=','adm.pres_med_pk_no')
         ->where('med.patient_no_fk',$patient_no_fk)
         ->where('med.admission_pk_no',$admission_id)
         ->orderBy('adm.med_given_lasttime','asc')->get();




        //dd($medication_charts_info);
        if(isset($medication_charts_info))
        {
            $medication_chart = [];
            $medication_time = [];
            $medication_time_after = [];
            $medication = [];
            $medicine_date = [];
            $medicine_with_date = [];
            foreach($medication_charts_info as $row)
            {
                $med_date = date("Y-m-d", strtotime($row->med_given_lasttime));
                $med_time = date("h:i:s", strtotime($row->med_given_lasttime));
                $med_name = $row->item_name;
                array_push($medication_time,[
                    'medicine' => $row->item_name,
                    'med_date' => $med_date,
                    'med_time' => $med_time,
                    'route' => $row->route
                ]);

                array_push($medication_time_after,[
                    'medicine' => $row->item_name,
                    'med_date' => $med_date,
                    'med_time' => $med_time,
                    'route' => $row->route
                ]);

                array_push($medication,[
                    'medicine' => $row->item_name,
                    'route' => $row->route,
                    'dosage' => $row->dosage
                ]);

                array_push($medicine_date,[
                    'med_date' => $med_date
                ]);

                array_push($medicine_with_date, [
                    'med_date' => $med_date,
                    'medicine' => $row->item_name
                ]);

                $medication_chart [$row->item_name.'~'.$row->dosage.'~'.$row->route][date('Y-m-d',strtotime( $row->med_given_lasttime))][] =date('h
                :i:s',strtotime( $row->med_given_lasttime));
            }
        }
        // dd($medication_chart);
     //dd(  $medication_chart );
       //return view("admin.ipd.reports.medication_chart", ["medication_chart" => $medication_chart, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode,'medication_time' => $medication_time,'medication' => $medication]);

        $pdf = PDF::loadView("admin.ipd.reports.medication_chart", ["medication_chart" => $medication_chart, "userInfo" => $userInfo, "po_hospital_details" => $po_hospital_details, "admission_info" => $ipd_admission, 'admission_barcode' => $admission_barcode, "pat_barcode" => $pat_barcode,'medication_time' => $medication_time,'medication_time_after' => $medication_time_after,'medication' => $medication,'medicine_date' => $medicine_date,'medicine_with_date' => $medicine_with_date]);
       return $pdf->stream("medication_chart-report.pdf", array("Attachment" => false));
    }
}
