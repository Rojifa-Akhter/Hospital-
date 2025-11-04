<?php

namespace App\Http\Controllers;

use \PDF;
use View;
use Image;
use DateTime;
use Response;
use App\Models\Room;
use App\Models\Doctor;
use App\Library\Template;
use App\Models\Radiology;
use App\Models\ItemWiseRoomRadiology;
use App\Models\Menu;
use App\Traits\LookupData;
use App\Models\ServiceUnit;
use Illuminate\Http\Request;
use App\Traits\UtilitiesTrait;
use Illuminate\Database\Seeder;
use App\Traits\DatatablesLoader;
use Illuminate\Support\Facades\DB;
use App\Jobs\RunWordFileActionsJob;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Queue;
use Symfony\Component\Process\Process;
use App\Models\RadiologyReportTemplate;
use Carbon\Carbon;
use Barryvdh\Snappy\Facades\SnappyPdf;
use App\Models\RadiologyAutocomplete;
use App\Models\UserWiseRoomRadiology;
use App\Datatables\DataTableClass;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Storage;
use App\Repositories\BaseRepository as Repo;
use App\Http\Requests\RadiologyTemplateRequest;
use App\Http\Requests\MenuFeaturesRequest;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class RadiologyController extends Controller
{
    use LookupData, DatatablesLoader, UtilitiesTrait;
    protected $model;
    protected $model2;
    protected $model3;
    protected $model4;
    protected $model5;
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function __construct(RadiologyAutocomplete $RadiologyAutocomplete, ItemWiseRoomRadiology $ItemWiseRoomRadiology, UserWiseRoomRadiology $UserWiseRoomRadiology, Radiology $radiology, RadiologyReportTemplate $RadiologyReportTemplate)
    {
        $this->middleware('auth');

        $this->model = new Repo($radiology);
        $this->model2 = new Repo($RadiologyReportTemplate);
        $this->model3 = new Repo($UserWiseRoomRadiology);
        $this->model4 = new Repo($RadiologyAutocomplete);
        $this->model5 = new Repo($ItemWiseRoomRadiology);
    }

    public function index()
    {
        $departments = ServiceUnit::select('serviceunit_no_pk', 'serviceunit_name')->get();
        $rooms = Room::select('room_no_pk', 'room_name')->get();
        return Template::loadview("admin.radiology.appointment_list", [
            'departments' => $departments,
            'rooms' => $rooms
        ]);
    }

    public function get_appointment_list_by_search(Request $request)
    {
        // return $request;
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $appointment_rs = DB::table("radt_invoicedtl_vw")
            ->orWhere('serviceunit_no_fk', $request->appointment_list_department)
            ->orWhere('room_pk_no', $request->appointment_list_room)
            ->whereBetween('img_app_dttm', [$from_date, $to_date])
            // ->where(function($query) use ($from_date, $to_date){
            //     $query->wherebetween('img_app_dttm', [$from_date,$to_date])
            //           ->orwherebetween('delivery_dttm', [$from_date,$to_date])
            //   })
            ->get();

        return Template::loadView("admin.radiology.appointment_list_table", ['appointment_rs' => $appointment_rs]);
    }

    public function get_imagecapture_list_by_search(Request $request)
    {
        // return $request;
        $from_date = date('Y-m-d', strtotime($request->from_date));
        $to_date = date('Y-m-d', strtotime($request->to_date));
        $radiology_data = DB::table('radt_invoicedtl AS rt')->select('pr.patient_name', 'pr.dob', 'rt.rabinvoicedtl_no_pk', 'rt.invoice_code', 'rt.accession_id', 'iu.item_name', 'rt.img_app_sl_no', 'rt.img_app_dttm', 'room.room_name', 'rt.ic_image_capture_key_ind')
            ->join('patn_registration AS pr', 'pr.patient_no_pk', '=', 'rt.patient_pk_no')
            ->join('sysc_serviceitem AS iu', 'iu.item_no_pk', '=', 'rt.item_no_fk')
            ->join('sysc_room AS room', 'room.room_no_pk', '=', 'rt.room_pk_no')
            ->orWhere('invoice_code', $request->radio_prescription_id)
            // ->orWhere('room_pk_no', $request->appointment_list_room)
            ->whereBetween('img_app_dttm', [$from_date, $to_date])
            // ->orderBy('rt.rabinvoicedtl_no_pk')
            ->get();
        // $radiology_data = DB::table("radt_invoicedtl")
        //         ->orWhere('invoice_code',$request->radio_prescription_id)
        //         // ->orWhere('invoice_code',$request->appointment_list_department)
        //         ->orWhere('room_pk_no', $request->appointment_list_room)
        //         ->whereBetween('img_app_dttm',  [$from_date, $to_date])
        //         // ->where(function($query) use ($from_date, $to_date){
        //         //     $query->wherebetween('img_app_dttm', [$from_date,$to_date])
        //         //           ->orwherebetween('delivery_dttm', [$from_date,$to_date])
        //         //   })
        //         ->get();
        return $radiology_data;

        return Template::loadView("admin.radiology.image_capture_table", ['radiology_data' => $radiology_data]);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */


    public function create()
    {

        $rooms = Room::select('room_no_pk', 'room_name')->get();
        $doctors = Doctor::select('person_no_pk', 'full_name')->get();
        $priority = $this->getLookupListByCode("PRIORITY");
        $specialist = $this->getLookupListByCode("DOCSPL");
        return Template::loadview("admin.radiology.create_appointment", [
            'priority' => $priority,
            'rooms' => $rooms,
            'specialist' => $specialist,
            'doctors' => $doctors
        ]);
    }



    public function radiologyAppointmentList()
    {
        // $date = date("Y/m/d");

        // $radiologyAppointment = DB::table("radt_invoicedtl_app_wl_vw a")
        //     ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
        //     ->select("a.prescription_no_fk", "a.item_name", "a.patient_no_fk", "b.patient_name", "a.serviceunit_name", "a.room_name", "a.img_app_sl_no", "a.img_app_dttm", "a.radinvoicedtl_no_pk", "a.invoice_no_pk")
        //     ->whereRaw(DB::raw("trunc(img_app_dttm) ='$date'"))
        //     ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
        //     ->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();

        $rooms = DB::select('SELECT ROOM.ROOM_NO_PK, ROOM.ROOM_NAME
                FROM    sysc_room room
                    JOIN
                        sysc_serviceunit unit
                    ON ROOM.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                WHERE UNIT.RADIOLOGY_IND = 1');
        // $image_capture = DB::table("radt_reporting_img")->select("radinvoicedtl_no_pk")->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->get();
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $department = DB::table("sysc_serviceunit_vw a")
            ->select("a.serviceunit_name", "a.serviceunit_no_pk")
            ->where([
                ["a.radiology_ind", "=", 1],
                ["a.status", "=", 1],
                ["a.au_entry_hospital_pk_no", $hospital_id]
            ])->get();

        return Template::loadview("admin.radiology.appointment_list", [
            'department' => $department,
            'rooms' => $rooms,

        ]);
    }
    public function radiologyImageCapture()
    {
        $today = date("d-m-Y");
        // $radiologyAppointment = DB::table("radt_invoicedtl_app_wl_vw a")
        //     ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
        //     ->select("a.radinvoicedtl_no_pk", "a.item_name", "a.prescription_no_fk", "a.patient_no_fk", "b.patient_name", "a.serviceunit_name", "a.room_name", "a.img_app_sl_no", "a.img_app_dttm", "a.img_app_sl_no", 'a.ic_image_capture_key_ind', 'a.invoice_code', 'a.ic_image_capture_keyed_by', 'a.ic_image_capture_keyed_time', 'a.delivery_dttm')
        //     ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //     ->whereRaw("a.img_app_dttm = to_date('$today','DD-MM-YYYY')")->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();
        $radiologyAppointment = [];

        $image_capture = DB::table("radt_reporting_img")->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->select("radinvoicedtl_no_pk")->get();

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $department = DB::table("sysc_serviceunit_vw a")
            // ->join("sysc_grant_su b", "a.serviceunit_no_pk", "b.su_no_fk")
            ->select("a.serviceunit_name", "a.serviceunit_no_pk")
            ->where([
                ["a.radiology_ind", "=", 1],
                ["a.status", "=", 1],
                ["a.au_entry_hospital_pk_no", "=", $hospital_id]
            ])->get();

        $rooms = Room::select('room_no_pk', 'room_name')->where("au_entry_hospital_no_fk", $hospital_id)->get();

        return Template::loadview("admin.radiology.image_capture", ["radiologyAppointment" => $radiologyAppointment, "department" => $department, "rooms" => $rooms, 'image_capture' => $image_capture]);
    }
    public function radiologyImageCapturePopup($id)
    {
        $image = DB::table("radt_reporting_img")->select("radinvoicedtl_no_pk", "rad_report_imgno_pk", "resultimg_path", "image_caption")->where("radinvoicedtl_no_pk", $id)->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->orderBy("rad_report_imgno_pk", "asc")->get();
        $image_count = count($image);
        return Template::loadview("admin.radiology.reports.image_capture_popup", ["id" => $id, 'image' => $image, 'image_count' => $image_count]);
    }

    public function radiologyImageCapturePopupemr($id)
    {
        $image = DB::table("radt_reporting_img")->select("radinvoicedtl_no_pk", "rad_report_imgno_pk", "resultimg_path", "image_caption")->where("radinvoicedtl_no_pk", $id)->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->orderBy("rad_report_imgno_pk", "asc")->get();
        $image_count = count($image);
        return Template::loadview("admin.radiology.reports.image_capture_popup_emr", ["id" => $id, 'image' => $image, 'image_count' => $image_count]);
    }
    public function radiologyImageCaptureDelete(Request $request)
    {
        DB::table('radt_reporting_img')->where("rad_report_imgno_pk", $request->id)->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->delete();
        return;
        // Template::loadview("admin.radiology.reports.image_capture_popup", ["id" => $id,'image'=>$image]);

    }


    public function radiologyCreateAppointment()
    {

        $doctors = Doctor::select('person_no_pk', 'full_name')->where("status", 1)->where("doctor_ind", 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $priority = $this->getLookupListByCode("PRIORITY");
        $specialist = $this->getLookupListByCode("DOCSPL");
        $app = DB::table('radt_invoicedtl_app_wl_vw')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();

        // $rooms = DB::table("sys_user_room_privs_vw")
        //     ->where('user_no_fk', Auth::user()->user_no_pk)
        //     ->get();
        return Template::loadview("admin.radiology.create_appointment", [
            'doctors' => $doctors,
            'specialist' => $specialist,
            "priority" => $priority,
            "app" => $app
        ]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function imageCapture()
    {
        $departments = ServiceUnit::select('serviceunit_no_pk', 'serviceunit_name')->get();
        $rooms = Room::select('room_no_pk', 'room_name')->get();
        $radiology_data = DB::table('radt_invoicedtl AS rt')->select('pr.patient_name', 'pr.dob', 'rt.rabinvoicedtl_no_pk', 'rt.invoice_code', 'rt.accession_id', 'iu.item_name', 'rt.img_app_sl_no', 'rt.img_app_dttm', 'room.room_name', 'rt.ic_image_capture_key_ind')
            ->join('patn_registration AS pr', 'pr.patient_no_pk', '=', 'rt.patient_pk_no')
            ->join('sysc_serviceitem AS iu', 'iu.item_no_pk', '=', 'rt.item_no_fk')
            ->join('sysc_room AS room', 'room.room_no_pk', '=', 'rt.room_pk_no')
            ->get();
        // return $radiology_data;
        return Template::loadview("admin.radiology.image_capture", [
            'departments' => $departments,
            'rooms' => $rooms,
            'radiology_data' => $radiology_data
        ]);
    }

    public function imagecapture_update(Request $request)
    {
        // return response()->json($request);
        // $id = $request->id;
        $auth_id = Auth::id();

        $radiology_update = Radiology::where('rabinvoicedtl_no_pk', '=', $request->id)
            ->update([
                'ic_image_capture_key_ind' => 1,
                'ic_image_capture_keyed_by' => $auth_id,
                'ic_image_capture_keyed_time' => date('Y-m-d', strtotime(now()))
            ]);
        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        return response()->json($message);
        // return redirect()->back();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */

    public function resultEntry()
    {
        return Template::loadview("admin.radiology.result_entry");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function patientIDCard()
    {
        return Template::loadview("admin.components.patient_information");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */





    public function createAppointmentCard()
    {
        return Template::loadview("admin.appointment.create_appointment_card");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */


    public function createAppointmentCardPrint()
    {
        return Template::loadview("admin.appointment.appointment_card_print");
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */




    public function store(Request $request)
    {
        // return $request;

        // App\Flight::where('active', 1)
        //   ->where('destination', 'San Diego')
        //   ->update(['delayed' => 1]);
        $id = $request->inv_voucher_no;
        // dd($id);
        $auth_id = Auth::id();

        $start_date = date('Y-m-d', strtotime($request->radio_appointment_date));
        $delivary_date = date('Y-m-d', strtotime($request->radio_delivery_date));

        $radiology_update = Radiology::where('invoicedtl_no_fk', '=', $id)
            ->update([
                'img_app_dttm' => $start_date,
                'img_app_sl_no' => 0,
                'img_app_ind' => 1,
                'img_app_by' => Auth::id(),
                'room_pk_no' => $request->radio_room_no,
                'priority_lup_pk_no' => $request->radio_priority,
                'delivery_dttm' => $delivary_date,
            ]);
        // dd($radiology_update);
        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];

        // $selected_item = DB::table('radt_invoicedtl_vw')->where('invoicedtl_no_fk', '=', $id)->select('item_no_fk','item_name','serviceunit_no_fk')->first();
        // return response()->json($message);

        return redirect()->back();
        // return response()->json($radiology_update);

        // $auth_id = Auth::id();

        // $start_date = date('Y-m-d', strtotime($request->radio_appointment_date));
        // $delivary_date = date('Y-m-d', strtotime($request->radio_delivery_date));

        // DB::beginTransaction();
        // try {

        //     $data = [
        //                 'img_app_dttm' => $start_date,
        //                 'img_app_sl_no' => 0,
        //                 'img_app_ind' => 1,
        //                 'img_app_by' => Auth::id(),
        //                 'room_pk_no' => $request->radio_room_no,
        //                 'priority_lup_pk_no' => $request->radio_priority,
        //                 'delivery_dttm' => $delivary_date,
        //             ];

        //     if($id == null)
        //     {
        //         // AU_ENTRY_BY
        //         $data['au_entry_by'] = $auth_id;
        //         // return $data;
        //         $this->model->create($data);

        //     }
        //     else
        //     {
        //         // AU_UPDATE_BY
        //         $data['au_update_by'] = $auth_id;
        //         $this->model->update($data, $id);
        //     }


        //     DB::commit();
        //     $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        // }
        // catch (\Exception $e)
        // {
        //     DB::rollback();
        //     $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }

        // return response()->json($message);
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
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id) {}

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

    public function invoiceInfoJson(Request $request)
    {
        $invoice_info = DB::table('finc_invoicemst_vw')
            ->where('invoice_code', '=', $request->invoice_code)
            ->select('patient_no_pk', 'patient_code', 'patient_name', 'gender_txt', 'dob', 'age', 'mobile1', 'blood_group')->first();
        // return $invoice_info;

        $invest_info = DB::table('radt_invoicedtl_vw')->where('invoice_code', '=', $request->invoice_code)->select('item_no_fk', 'item_name', 'serviceunit_no_fk', 'invoicedtl_no_fk')->first();

        $invoice_data = [];
        // if (!empty($invoice_info)) {
        $invoice_data = array(
            'patient_id' => $invoice_info->patient_no_pk,
            'patient_code' => $invoice_info->patient_code,
            'patient_name' => $invoice_info->patient_name,
            'age' => $invoice_info->age,
            'gender' => $invoice_info->gender_txt,
            'dob' => $invoice_info->dob,
            'contact' => $invoice_info->mobile1,
            'blood_group' => $invoice_info->blood_group
        );
        // print_r($invoice_data);
        // die();
        return response()->json(['invoice_code' => $request->invoice_code, 'invoice_data' => $invoice_data, 'invest_info' => $invest_info]);
        // }
        // $data[invest_info] = $invest_info;
        // $data[invoice_data] = $invoice_data;
        // return $data;

    }
    public function getRoom(Request $request)
    {
        $res_array = array();
        $rooms = DB::table('sysc_room_su_vw')->where('serviceunit_no_fk', '=', $request->get_room)->select('room_no_pk', 'room_code', 'room_name')->get();
        foreach ($rooms as $record) {
            $res_array[] = array(
                'room_no_pk' => $record->room_no_pk,
                'room_code' => $record->room_code,
                'room_name' => $record->room_name
            );
        }

        return response()->json($res_array);
    }
    public function getAllRadiology(Request $request)
    {
        $columns = array(
            array('db' => 'invoice_code'),
            array('db' => 'patient_id'),
            array('db' => 'patient_name'),
            array('db' => 'img_app_sl_no'),
            array('db' => 'investigation_name'),
            array('db' => 'name_room'),
            array('db' => 'img_app_dttm')
        );

        $sql = "SELECT a.invoice_code, patient.patient_code patient_id, patient.patient_name patient_name, a.img_app_sl_no, item.item_name investigation_name, room.room_name name_room, a.img_app_dttm, rownum rownumber, a.au_update_at, a.au_entry_at
        FROM radt_invoicedtl_vw a
        LEFT JOIN sysc_serviceitem item on item.item_no_pk =  a.item_no_fk
        LEFT JOIN patn_registration patient on patient.patient_no_pk =  a.patient_pk_no
        LEFT JOIN sysc_room room on room.room_no_pk =  a.room_pk_no";
        $order_by_column = "rabinvoicedtl_no_pk";

        $json_data = $this->datatable($request, $sql, $order_by_column, 'DESC', $columns);

        echo json_encode($json_data);
    }


    public function radiologySearchPatientInfo(Request $request)
    {
        $voucher_no = $request->voucher_no;

        $patient_info = DB::table("radt_invoicedtl_app_wl_vw a")
            ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
            ->where("invoice_no_pk", $voucher_no)
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->first();
        // dd($patient_info);
        // $test_info = DB::table("radt_invoicedtl_app_wl_vw a")
        //     ->leftJoin("pat_registration_wl_vw b", "a.PATIENT_NO_FK", "=", "b.PATIENT_NO_PK")
        //     ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //     ->where("invoice_no_pk", $voucher_no)->get();
        /*->select("a.ic_image_capture_keyed_by", "a.ic_image_capture_keyed_time",
            "b.base_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo","b.ref_patient_photo",
            "b.ref_patient_name_rank",
            "b.pat_relation", "b.ref_patient_base", "b.ref_patient_gender", "b.ref_blood_group",
            "b.ref_age", "a.img_app_dttm", "a.serviceunit_name", "a.room_name", "a.prescription_dttm", "a.radinvoicedtl_no_pk")
        ->select("b.patient_name_rank", "a.ic_image_capture_keyed_by", "a.ic_image_capture_keyed_time",
            "b.base_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo",
            "b.ref_patient_name_rank",
            "b.pat_relation", "b.ref_patient_base", "b.ref_patient_gender", "b.ref_blood_group",
            "b.ref_age","a.img_app_dttm","a.serviceunit_name","a.room_name","a.prescription_dttm","a.radinvoicedtl_no_pk")
        */

        // $rooms = DB::table("sys_user_room_privs_vw")
        //     ->where('user_no_fk', Auth::user()->user_no_pk)
        //     ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
        //     ->get();
        $priority = $this->getLookupListByCode("PRIORITY");
        return Template::loadview("admin.components.patient_info_min", ["patient_info" => $patient_info, 'priority' => $priority]);
    }
    public function radiologySearchPatientInvestigation(Request $request)
    {

        $invoice_id = $request->invoice_id;
        $hospital_id = Session::get('user.ses_hospital_code');

        $test_info = DB::table("radt_invoicedtl_app_wl_vw a")
            ->select('a.item_name', 'a.invoice_date', 'a.img_app_dttm', 'a.room_name', 'a.serviceunit_no_fk', 'a.radinvoicedtl_no_pk', 'a.invoice_no_pk')
            ->leftJoin("PAT_REGISTRATION_WL_VW b", "a.PATIENT_NO_FK", "=", "b.PATIENT_NO_PK")
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("invoice_no_pk", $invoice_id)
            ->whereNull('cancel_ind')
            ->get();


        if ($hospital_id != 'UNICO') {
            return Template::loadview("admin.radiology.radiology_search_data", ["test_info" => $test_info]);
        } else {
            return Template::loadview("admin.radiology_v2.appointment.radiology_search_data_v2", ["test_info" => $test_info]);
        }
    }
    public function radiologySearchPatientAppData(Request $request)
    {
        $invoice_id = $request->invoice_id;

        $patient_info = DB::select("select b.patient_name,AGE as pat_age,
            b.gender_txt,
            b.marital_status_txt,
            b.blood_group_txt,
            b.mobile1,
            pat_age(b.dob,nvl(dod,sysdate))pat_age,
            b.patient_code,
            b.service_number,
            a.FULL_NAME as DOCTOR_NAME,
            b.patient_photo,
            b.gender_txt from RADT_INVOICEDTL_APP_WL_VW a left join PAT_REGISTRATION_WL_VW b on A.PATIENT_NO_FK = B.PATIENT_NO_PK where a.invoice_code = '$invoice_id' ");

        // $rooms = DB::table("sys_user_room_privs_vw")
        //     ->where('user_no_fk', Auth::user()->user_no_pk)
        //     ->get();
        $priority = $this->getLookupListByCode("PRIORITY");
        return Template::loadview("admin.components.patient_info_rad", ["patient_info" => $patient_info[0], 'priority' => $priority]);
    }

    public function getRediologyRoom(Request $request)
    {
        // $getServiceUnit = DB::table("radt_invoicedtl_app_wl_vw")
        //     ->select(
        //         "serviceunit_no_fk",
        //         "radinvoicedtl_no_pk"
        //     )->where("serviceunit_no_fk", $request->id)
        //     ->get()
        //     ->first();
        // dd($getServiceUnit);
        //Service Control View.
        // dd($request->id);
        $room_number = DB::table("sysc_user_room_privs_vw")
            ->select("room_no_pk", "room_name")
            // ->where("user_no_fk", Auth::id())
            // ->where("serviceunit_no_fk", $request->id)
            ->get();


        $data = '';
        // $data .= '
        //     <option value="" selected="selected">Select Room</option>
        //     ';
        if (!empty($room_number)) {
            foreach ($room_number as $value) {
                $data .= ' <option value="' . $value->room_no_pk . '">
                        ' .
                    $value->room_name . '
                        </option>';
            }
        }

        echo $data;
    }
    public function storeRadiologyAppointment(Request $request)
    {
        $id = $request->inv_voucher_no;
        $auth_id = Auth::id();
        DB::beginTransaction();
        $demolist = DB::table("radt_invoicedtl_app_wl_vw")->select("serviceunit_no_fk")
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('serviceunit_no_fk', $id)->first();

        // dd(date("d/m/Y", strtotime($request->input("radio_appointment_date"))));
        $testlist = DB::table("radt_invoicedtl_app_wl_vw")
            ->select("img_app_sl_no")
            ->where("img_app_dttm", date("Y/m/d", strtotime($request->input("radio_appointment_date"))))
            // ->where("serviceunit_no_fk", $demolist->serviceunit_no_fk)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->orderBy("radinvoicedtl_no_pk", "desc")->first();
        if (!empty($testlist->img_app_sl_no)) {
            $serial = $testlist->img_app_sl_no + 1;
        } else {
            $serial = 1;
        }
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        try {
            $data = [
                "img_app_dttm" => date("Y/m/d", strtotime($request->radio_appointment_date)),
                "img_app_sl_no" => $serial,
                "img_app_ind" => 1,
                "room_no_fk" => $request->radio_room_no,
                "priority_lup_no_fk" => $request->radio_priority,
                "delivery_dttm" => date("Y/m/d", strtotime($request->radio_delivery_date)),
                "au_entry_hospital_pk_no" => $hospital_id,
            ];


            $data['au_update_by'] = $auth_id;
            DB::table('radt_invoicedtl')->where('radinvoicedtl_no_pk', $id)->update($data);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success', 'insert_id' => $id];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function generateIntervals(Request $request)
    {
        // dd($request->room_id,Session::get('user.ses_person_no_fk'));
        // dd($request->all());
        // dd($request->radio_appointment_date);A240814222304-01


        $room_selection = DB::table('RADT_ROOM_SHEDULESETUP')->select('room_no_fk')->where('su_no_fk', $request->dept_id)->orderByDesc('au_entry_at')->first()->room_no_fk;
        // dd($room_selection);
        $shedule = DB::table("radt_room_shedulesetup")
            ->where('room_no_fk', $room_selection)
            // ->where('person_no_fk', Session::get('user.ses_person_no_fk'))
            ->first();
        // dd($shedule);
        //
        $startTime = $request->query('start_time', $shedule->start_time);
        $endTime = $request->query('end_time', $shedule->end_time);

        $start = Carbon::createFromFormat('H:i', $startTime);
        $end = Carbon::createFromFormat('H:i', $endTime);

        $intervals = [];
        $avg_interval = $shedule->avg_time ? (int) $shedule->avg_time : 10;

        while ($start < $end) {
            $nextStart = $start->copy()->addMinutes($avg_interval);
            if ($nextStart > $end) {
                break;
            }

            $intervals[] = [
                'start' => $start->format('h:i A'),
                'end' => $nextStart->format('h:i A'),
            ];

            $start = $nextStart;
        }

        $appoint_date = date('Y-m-d', strtotime($request->radio_appointment_date));
        $selectedSchedules = DB::table('RADT_PAT_SHEDULE')
            ->where('appoint_date', $appoint_date)
            ->get(['shed_str_time', 'radt_app_sl', 'radinvoicedtl_no_fk'])
            ->mapWithKeys(function ($schedule) {
                return [
                    $schedule->shed_str_time => [
                        'radt_app_sl' => $schedule->radt_app_sl,
                        'radinvoicedtl_no_fk' => $schedule->radinvoicedtl_no_fk
                    ]
                ];
            })
            ->toArray();
        $totalSlots = count($intervals);

        return Template::loadView("admin.radiology.radiology_schedule", [
            'start_time' => $request->query('start_time'),
            'end_time' => $request->query('end_time'),
            'intervals' => $intervals,
            'total_slots' => $totalSlots,
            'startTime' => Carbon::createFromFormat('H:i', $startTime),
            'endTime' => Carbon::createFromFormat('H:i', $endTime),
            'avg_interval' => $avg_interval,
            'selectedSchedules' => $selectedSchedules,
        ]);
    }
    public function storeBookSchedule(Request $request)
    {
        $id = $request->input('id');
        $start = $request->input('start');
        $end = $request->input('end');
        $app_id = $request->input('app_id');
        $inv_voucher_no = $request->input('inv_voucher_no');


        if (isset($request->radio_appointment_date) && !empty($request->radio_appointment_date)) {
            $parsedDate = strtotime($request->radio_appointment_date);
            $appoint_date = $parsedDate ? date("Y/m/d", $parsedDate) : date("Y/m/d");
        } else {

            $parsedDate = strtotime($request->date);
            $appoint_date = $parsedDate ? date("Y/m/d", $parsedDate) : date("Y/m/d");
        }


        $details_data = DB::table("RADT_INVOICEDTL_APP_WL_VW")
            ->where('invoice_code', DB::raw("'$app_id'"))
            ->first();
        $patient_no_fk = $details_data->patient_no_fk;
        // $patient_code = $details_data->patient_code;
        $patient_name = $details_data->patient_name;
        // $appoint_no_pk = $details_data->appoint_no_pk;
        // $appoint_code = $details_data->appoint_code;
        $su_no_fk = $details_data->serviceunit_no_fk;
        $room_no_fk = $details_data->room_no_fk;
        $sequence = DB::getSequence();
        $pat_shedule_no_pk_seq = $sequence->nextValue('pat_shedule_no_pk_seq');
        DB::table("radt_pat_shedule")->insert([
            'pat_shedule_no_pk' => $pat_shedule_no_pk_seq,
            'pat_shedule_uid' => $pat_shedule_no_pk_seq,
            'radt_app_sl' => $id,
            'shed_str_time' => $start,
            'shed_end_time' => $end,
            'patient_no_fk' => $patient_no_fk,
            // 'patient_code' => $patient_code,
            'patient_name' => $patient_name,
            // 'appoint_no_fk' => $appoint_no_pk,
            // 'appoint_code' => $appoint_code,
            'su_no_fk' => $su_no_fk,
            'room_no_fk' => $room_no_fk,
            'appoint_date' => $appoint_date,
            'radinvoicedtl_no_fk' => $inv_voucher_no,
        ]);
        // return response()->json(['message' => 'Schedule booked successfully!']);
    }

    public function dateWiseGenerateIntervals(Request $request)
    {
        // dd($request->room_id,Session::get('user.ses_person_no_fk'));
        // dd($request->all());
        // dd($request->radio_appointment_date);A240814222304-01


        // $room_selection = DB::table('RADT_ROOM_SHEDULESETUP')->select('room_no_fk')->where('su_no_fk',$request->dept_id)->orderByDesc('au_entry_at')->first()->room_no_fk;
        //   dd($room_selection);
        $shedule = DB::table("radt_room_shedulesetup")
            ->where('room_no_fk', $request->radio_room_no)
            ->where('person_no_fk', Session::get('user.ses_person_no_fk'))
            ->first();
        // dd($shedule);
        //
        $startTime = $request->query('start_time', $shedule->start_time);
        $endTime = $request->query('end_time', $shedule->end_time);

        $start = Carbon::createFromFormat('H:i', $startTime);
        $end = Carbon::createFromFormat('H:i', $endTime);

        $intervals = [];
        $avg_interval = $shedule->avg_time ? (int) $shedule->avg_time : 10;

        while ($start < $end) {
            $nextStart = $start->copy()->addMinutes($avg_interval);
            if ($nextStart > $end) {
                break;
            }

            $intervals[] = [
                'start' => $start->format('h:i A'),
                'end' => $nextStart->format('h:i A'),
            ];

            $start = $nextStart;
        }

        $appoint_date = date('Y-m-d', strtotime($request->radio_appointment_date));
        $selectedSchedules = DB::table('RADT_PAT_SHEDULE')
            ->where('appoint_date', $appoint_date)
            ->get(['shed_str_time', 'radt_app_sl', 'radinvoicedtl_no_fk'])
            ->mapWithKeys(function ($schedule) {
                return [
                    $schedule->shed_str_time => [
                        'radt_app_sl' => $schedule->radt_app_sl,
                        'radinvoicedtl_no_fk' => $schedule->radinvoicedtl_no_fk
                    ]
                ];
            })
            ->toArray();
        $totalSlots = count($intervals);

        return Template::loadView("admin.radiology.radiology_schedule", [
            'start_time' => $request->query('start_time'),
            'end_time' => $request->query('end_time'),
            'intervals' => $intervals,
            'total_slots' => $totalSlots,
            'startTime' => Carbon::createFromFormat('H:i', $startTime),
            'endTime' => Carbon::createFromFormat('H:i', $endTime),
            'avg_interval' => $avg_interval,
            'selectedSchedules' => $selectedSchedules,
        ]);
    }


    public function radiologySearchAppointment(Request $request)
    {
        $appointment_list_department = $request->appointment_list_department;
        $appointment_list_room = $request->room_no_fk;
        $invoice_id = $request->invoice_id;
        $appointment_list_form = $request->appointment_list_form;
        $appointment_list_to = $request->appointment_list_to;
        $from_date = date("d-m-Y", strtotime($request->appointment_list_form));
        $to_date = date("d-m-Y", strtotime($request->appointment_list_to));
        $date_cond = ($request->appointment_list_form != "") ? " a.invoice_date between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')" : "";
        $appointment_qeury = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->select(
                "a.radinvoicedtl_no_pk",
                "a.item_name",
                "b.patient_name",
                "a.serviceunit_name",
                "a.room_name",
                "a.img_app_sl_no",
                "a.img_app_dttm",
                "a.invoice_date",
                // "a.img_app_sl_no",
                // 'a.ic_image_capture_key_ind',
                // 'a.ic_image_capture_keyed_by',
                // 'a.ic_image_capture_keyed_time',
                // 'a.delivery_dttm',
                "a.invoice_no_pk",
                // "a.appoint_code",
                // "a.radinvoicedtl_no_pk"
            )->where('a.img_app_ind', 1);
        if ($date_cond != "") {
            $appointment_qeury->when($date_cond, function ($query, $date_cond) {
                return $query->whereRaw(DB::raw($date_cond));
            });
        }
        if ($appointment_list_room != "") {
            $appointment_qeury->when($appointment_list_room, function ($query, $appointment_list_room) {
                return $query->where('a.room_no_fk', $appointment_list_room);
            });
        }

        if ($invoice_id != "") {
            $appointment_qeury->when($invoice_id, function ($query, $invoice_id) {
                return $query->where('a.invoice_no_pk', $invoice_id);
            });
        }
        if ($appointment_list_department != "") {
            $appointment_qeury->when($appointment_list_department, function ($query, $appointment_list_department) {
                return $query->where('a.serviceunit_no_fk', $appointment_list_department);
            });
        }
        $radiologyAppointment = $appointment_qeury->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();

        return Template::loadview("admin.radiology.appointment_list_table", ["radiologyAppointment" => $radiologyAppointment]);
    }


    public function get_appointment_card($radinvoicedtl_no_pk)
    {
        $appointment_card = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->select(
                "a.invoice_no_pk",
                "b.patient_name",
                "a.patient_no_fk",
                "a.invoicedtl_no_fk",
                "a.invoice_code",
                "a.invoice_date",
                "a.room_name",
                "a.item_name",
                "a.img_app_sl_no",
                "a.img_app_dttm",
                "a.radinvoicedtl_no_pk",
                "b.patient_code",
                "a.serviceunit_name",
                "a.accession_id"
            )
            ->where("a.radinvoicedtl_no_pk", $radinvoicedtl_no_pk)
            ->first();

        return Template::loadView('admin.radiology.appointment_card', ['appointment_card' => $appointment_card]);
    }

    public function get_appointment_card_print($radinvoicedtl_no_pk)
    {
        $appointment = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->join('radt_pat_shedule radt', 'a.radinvoicedtl_no_pk', 'radt.radinvoicedtl_no_fk')
            ->select(
                // "a.appoint_code",
                "b.patient_name",
                "a.patient_no_fk",
                "a.invoicedtl_no_fk",
                "a.invoice_code",
                "a.invoice_date",
                "a.room_name",
                "a.item_name",
                "radt.radt_app_sl as img_app_sl_no",
                "a.img_app_dttm",
                "a.radinvoicedtl_no_pk",
                "b.patient_code",
                "a.serviceunit_name",
                "a.accession_id",
                "b.present_addr",
                'b.gender_txt',
                'b.service_number',
                'radt.shed_str_time',
                'b.age'
            )
            ->where("a.radinvoicedtl_no_pk", $radinvoicedtl_no_pk)
            ->first();
        // dd($appointment);

        $app_barcode = '';
        $barcode = new BarcodeGenerator();
        $barcode->setText($appointment->invoice_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $app_barcode = $barcode->generate();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        // dd($appointment);
        return View("admin.radiology.appointment_card_print", ['app_barcode' => $app_barcode, 'appointment' => $appointment, 'po_hospital_details' => $po_hospital_details]);

        // return $pdf->stream('radiology-appointment-card.pdf');
    }


    public function searchImagePrescription(Request $request)
    {

        $voucher_no = $request->invoice_id;

        $appointment_list_department = $request->type;
        $serviceunit = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            ->where('serviceunit_no_pk', $appointment_list_department)
            ->first();
        $menutype = $serviceunit->serviceunit_name;


        $appointment_list_room = $request->appointment_list_room;
        $appointment_list_form = $request->appointment_list_form;
        $appointment_list_to = $request->appointment_list_to;
        $from_date = date("d-m-Y", strtotime($request->appointment_list_form));
        $to_date = date("d-m-Y", strtotime($request->appointment_list_to));


        $date_cond = ($request->appointment_list_form != "") ? " a.invoice_date between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')" : "";
        $appointment_qeury = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->select(
                "a.admission_no_pk",
                "a.invoice_date",
                "a.radinvoicedtl_no_pk",
                "a.item_name",
                "a.prescription_no_fk",
                "a.patient_no_fk",
                "b.gender_txt",
                "b.patient_name",
                "b.patient_photo",
                "b.patient_code",
                "a.serviceunit_name",
                "a.room_name",
                "a.img_app_sl_no",
                "a.img_app_dttm",
                "a.img_app_sl_no",
                'a.ic_image_capture_key_ind',
                'a.invoice_code',
                'a.ic_image_capture_keyed_by',
                'a.ic_image_capture_keyed_time',
                'a.delivery_dttm',
                'a.bed_name',
            )
            ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'));
        if ($date_cond != "") {
            $appointment_qeury->when($date_cond, function ($query, $date_cond) {
                return $query->whereRaw(DB::raw($date_cond));
            });
        }
        if ($appointment_list_room != "") {
            $appointment_qeury->when($appointment_list_room, function ($query, $appointment_list_room) {
                return $query->where('a.room_no_fk', $appointment_list_room);
            });
        }
        if ($appointment_list_department != "") {
            $appointment_qeury->when($appointment_list_department, function ($query, $appointment_list_department) {
                return $query->where('a.serviceunit_no_fk', $appointment_list_department);
            });
        }
        $appointment_qeury->when($voucher_no, function ($query, $voucher_no) {
            return $query->where('a.invoice_code', $voucher_no);
        });
        $radiologyAppointment = $appointment_qeury->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();
        $image_capture = DB::table("radt_reporting_img")->select("radinvoicedtl_no_pk")->get();

        if (Session::get('user.ses_hospital_code') == 'UNICO') {
            return Template::loadview("admin.radiology_v2.image_capture.image_capture_table_v2", ["radiologyAppointment" => $radiologyAppointment, 'image_capture' => $image_capture, 'menutype' => $menutype]);
        } else {
            return Template::loadview("admin.radiology.image_capture_table", ["radiologyAppointment" => $radiologyAppointment, 'image_capture' => $image_capture, 'menutype' => $menutype]);
        }
    }


    public function searchImageCollected(Request $request)
    {
        $voucher_no = $request->invoice_id;

        $appointment_list_department = $request->type;
        $appointment_list_room = $request->appointment_list_room;
        $appointment_list_form = $request->appointment_list_form;
        $appointment_list_to = $request->appointment_list_to;
        $from_date = date("d-m-Y", strtotime($request->appointment_list_form));
        $to_date = date("d-m-Y", strtotime($request->appointment_list_to));


        $date_cond = ($request->appointment_list_form != "") ? " a.img_app_dttm between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')" : "";
        $appointment_qeury = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->select("a.admission_no_pk", "a.invoice_date", "a.radinvoicedtl_no_pk", "a.item_name", "a.prescription_no_fk", "a.patient_no_fk", "b.patient_name", "a.serviceunit_name", "a.room_name", "a.img_app_sl_no", "a.img_app_dttm", "a.img_app_sl_no", 'a.ic_image_capture_key_ind', 'a.invoice_code', 'a.ic_image_capture_keyed_by', 'a.ic_image_capture_keyed_time', 'a.delivery_dttm')
            ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
            ->where('ic_image_capture_key_ind', 1);
        if ($date_cond != "") {
            $appointment_qeury->when($date_cond, function ($query, $date_cond) {
                return $query->whereRaw(DB::raw($date_cond));
            });
        }
        if ($appointment_list_room != "") {
            $appointment_qeury->when($appointment_list_room, function ($query, $appointment_list_room) {
                return $query->where('a.room_no_fk', $appointment_list_room);
            });
        }
        if ($appointment_list_department != "") {
            $appointment_qeury->when($appointment_list_department, function ($query, $appointment_list_department) {
                return $query->where('a.serviceunit_no_fk', $appointment_list_department);
            });
        }
        $appointment_qeury->when($voucher_no, function ($query, $voucher_no) {
            return $query->where('a.invoice_code', $voucher_no);
        });
        $radiologyAppointment = $appointment_qeury->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();
        $image_capture = DB::table("radt_reporting_img")->select("radinvoicedtl_no_pk")->get();

        return Template::loadview("admin.radiology_v2.image_capture.image_capture_table_collected_list", ["radiologyAppointment" => $radiologyAppointment, 'image_capture' => $image_capture]);
    }

    public function searchImagePending(Request $request)
    {
        // dd($request->all());
        $voucher_no = $request->invoice_id;

        $appointment_list_department = $request->type;
        $appointment_list_room = $request->appointment_list_room;
        $appointment_list_form = $request->appointment_list_form;
        $appointment_list_to = $request->appointment_list_to;
        $from_date = date("d-m-Y", strtotime($request->appointment_list_form));
        $to_date = date("d-m-Y", strtotime($request->appointment_list_to));


        $date_cond = ($request->appointment_list_form != "") ? " a.img_app_dttm between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')" : "";
        $appointment_qeury = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->select("a.admission_no_pk", "a.invoice_date", "a.radinvoicedtl_no_pk", "a.item_name", "a.prescription_no_fk", "a.patient_no_fk", "b.patient_name", "a.serviceunit_name", "a.room_name", "a.img_app_sl_no", "a.img_app_dttm", "a.img_app_sl_no", 'a.ic_image_capture_key_ind', 'a.invoice_code', 'a.ic_image_capture_keyed_by', 'a.ic_image_capture_keyed_time', 'a.delivery_dttm')
            ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
            ->whereNull('ic_image_capture_key_ind');
        if ($date_cond != "") {
            $appointment_qeury->when($date_cond, function ($query, $date_cond) {
                return $query->whereRaw(DB::raw($date_cond));
            });
        }
        if ($appointment_list_room != "") {
            $appointment_qeury->when($appointment_list_room, function ($query, $appointment_list_room) {
                return $query->where('a.room_no_fk', $appointment_list_room);
            });
        }
        if ($appointment_list_department != "") {
            $appointment_qeury->when($appointment_list_department, function ($query, $appointment_list_department) {
                return $query->where('a.serviceunit_no_fk', $appointment_list_department);
            });
        }
        $appointment_qeury->when($voucher_no, function ($query, $voucher_no) {
            return $query->where('a.invoice_code', $voucher_no);
        });
        $radiologyAppointment = $appointment_qeury->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();
        $image_capture = DB::table("radt_reporting_img")->select("radinvoicedtl_no_pk")->get();

        return Template::loadview("admin.radiology_v2.image_capture.image_capture_table_pending_list", ["radiologyAppointment" => $radiologyAppointment, 'image_capture' => $image_capture]);
    }


    public function UpdateImageApointment(Request $request)
    {
        $id = $request->capture_id;
        $form_data = $request->ing_upload;
        $files = $request->file('img_upload');


        $auth_id = Auth::id();
        DB::beginTransaction();
        // try {
        $hospital_no_pk = $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $radinvoicedtl_no = DB::table('radt_invoicedtl')->select("radinvoicedtl_no_pk")->where("radinvoicedtl_no_pk", $id)->first()->radinvoicedtl_no_pk;
        $image_sl = DB::table('radt_reporting_img')->select("sl_no", "rad_report_imgno_pk")->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->where("radinvoicedtl_no_pk", $radinvoicedtl_no)->orderBy("sl_no", "desc")->first();

        $image_name = [];
        $image_caption = [];
        $length = $request->file('img_upload');
        // dd( $length);

        $count = $length ? count($length) : "";


        // if ($length != null ) {
        //     $index=0;
        //     foreach ($request->caption as $key => $value) {
        //         $value_exp=explode('_',$value);
        //         if ( $value_exp[1] == "") {
        //             $img_id[$index++] = $value_exp[0];
        //         }

        //     }
        //     for ($i = 0; $i < $count; $i++) {
        //         $sequence = DB::getSequence();
        //         $rad_report_imgno_pk_seq = $sequence->nextValue('rad_report_imgno_pk_seq');
        //         $image_name = $id . ($rad_report_imgno_pk_seq) . "." . $length[$i]->getClientOriginalExtension();
        //         // $image_id=$request->image_id[$i];
        //         $image_caption =$img_id[$i];
        //         $sl=0;
        //         if ($image_sl !=null) {
        //           $sl= $image_sl->sl_no + 1;
        //         }else{
        //             $sl= $i + 1;
        //         }



        //         $update_image = [
        //             "rad_report_imgno_pk" => $rad_report_imgno_pk_seq,
        //             "radinvoicedtl_no_pk" => $radinvoicedtl_no,
        //             "resultimg_path" => $image_name,
        //             "image_caption" => $image_caption,
        //             "sl_no" => $sl,
        //             'au_entry_session' => "session",
        //             'au_entry_hospital_no_fk' => $hospital_no_pk,

        //         ];
        //         DB::table('radt_reporting_img')->insert($update_image);

        //         $this->uploadImages($length[$i], $id . $rad_report_imgno_pk_seq, 'images/uploads/image_capture/', 'images/uploads/image_capture/thumb/');
        //     }
        // }
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $image_cunt = $request->caption ? $request->caption : "";
        if ($image_cunt != null) {
            $index = 0;
            foreach ($request->caption as $key => $value) {
                $value_exp = explode('_', $value);
                if ($value_exp[1] != "") {
                    $img_id[$index++] = $value_exp[0];
                }
            }
            for ($j = 0; $j < count($img_id); $j++) {
                $image_id = $request->image_id[$j];
                $image_caption = $img_id[$j];

                $capture_image = [
                    "image_caption" => $image_caption,
                    "au_entry_hospital_no_fk" => $hospital_id,
                ];
                DB::table('radt_reporting_img')->where("rad_report_imgno_pk", $image_id)->update($capture_image);
            }
        }

        $data = [
            "ic_image_capture_key_ind" => 1,
            "ic_image_capture_keyed_by" => $auth_id,
            "ic_image_capture_keyed_time" => date("Y/m/d"),
            "au_entry_hospital_pk_no" => $hospital_id,
        ];

        DB::table('radt_invoicedtl')->where('radinvoicedtl_no_pk', $id)->update($data);

        DB::commit();
        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        // } catch (\Exception $e) {
        //     DB::rollback();
        //     $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        // }
        return response()->json($message);
    }
    public function UpdateImageApointmentPreview(Request $request)
    {
        $id = $request->capture_id;
        $form_data = $request->ing_upload;
        $files = $request->file('img_upload');
        // dd($files);


        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $hospital_no_pk = $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
            $radinvoicedtl_no = DB::table('radt_invoicedtl')->select("radinvoicedtl_no_pk")->where("radinvoicedtl_no_pk", $id)->first()->radinvoicedtl_no_pk;
            $image_sl = DB::table('radt_reporting_img')->select("sl_no", "rad_report_imgno_pk")->where("radinvoicedtl_no_pk", $radinvoicedtl_no)->orderBy("sl_no", "desc")->first();

            $image_name = [];
            $image_caption = [];
            $length = $request->file('img_upload');
            // dd( $length);

            $count = $length ? count($length) : "";

            // dd($img_id);
            if ($length != null) {
                $index = 0;
                foreach ($request->caption as $key => $value) {
                    $value_exp = explode('_', $value);
                    if ($value_exp[1] == "") {
                        $img_id[$index++] = $value_exp[0];
                    }
                }
                for ($i = 0; $i < $count; $i++) {
                    $sequence = DB::getSequence();
                    $rad_report_imgno_pk_seq = $sequence->nextValue('rad_report_imgno_pk_seq');
                    $image_name = $id . ($rad_report_imgno_pk_seq) . "." . $length[$i]->getClientOriginalExtension();
                    // $image_id=$request->image_id[$i];
                    $image_caption = $img_id[$i];
                    $sl = 0;
                    if ($image_sl != null) {
                        $sl = $image_sl->sl_no + 1;
                    } else {
                        $sl = $i + 1;
                    }



                    $update_image = [
                        "rad_report_imgno_pk" => $rad_report_imgno_pk_seq,
                        "radinvoicedtl_no_pk" => $radinvoicedtl_no,
                        "resultimg_path" => $image_name,
                        "image_caption" => $image_caption,
                        "sl_no" => $sl,
                        'au_entry_session' => "session",
                        'au_entry_hospital_no_fk' => $hospital_no_pk,

                    ];
                    DB::table('radt_reporting_img')->insert($update_image);

                    $this->uploadImages($length[$i], $id . $rad_report_imgno_pk_seq, 'images/uploads/image_capture/', 'images/uploads/image_capture/thumb/');
                }
            }
            $image_cunt = $request->caption ? $request->caption : "";
            if ($image_cunt != null) {
                $index = 0;
                foreach ($request->caption as $key => $value) {
                    $value_exp = explode('_', $value);
                    if ($value_exp[1] != "") {
                        $img_id[$index++] = $value_exp[0];
                    }
                }
                for ($j = 0; $j < count($img_id); $j++) {
                    $image_id = $request->image_id[$j];
                    $image_caption = $img_id[$j];

                    $capture_image = [
                        "image_caption" => $image_caption,
                    ];
                    DB::table('radt_reporting_img')->where("rad_report_imgno_pk", $image_id)->update($capture_image);
                }
            }

            $data = [
                "ic_image_capture_key_ind" => 1,
                "ic_image_capture_keyed_by" => $auth_id,
                "ic_image_capture_keyed_time" => date("Y/m/d"),
            ];

            // DB::table('radt_invoicedtl')->where('radinvoicedtl_no_pk', $id)->update($data);

            $image = DB::table("radt_reporting_img")->select("radinvoicedtl_no_pk", "rad_report_imgno_pk", "resultimg_path", "image_caption")->where("radinvoicedtl_no_pk", $id)->orderBy("rad_report_imgno_pk", "asc")->get();
            $image_count = count($image);


            DB::commit();
            return view("admin.radiology.reports.image_capture_list", ["id" => $id, 'image' => $image, 'image_count' => $image_count]);
            // $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success','img'=>$image_data];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        //return $message;

    }
    public function radiologyResultEntryWorklist()
    {
        // $rooms = DB::table("SYS_USER_ROOM_PRIVS_VW")
        // ->where('user_no_fk', "=", Auth::user()->user_no_pk)->get();
        $rooms = DB::select('SELECT ROOM.ROOM_NO_PK, ROOM.ROOM_NAME
        FROM    sysc_room room
            JOIN
                sysc_serviceunit unit
            ON ROOM.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
        WHERE UNIT.RADIOLOGY_IND = 1');
        $department = DB::table("sysc_serviceunit_vw a")
            ->join("sysc_grant_su b", "a.serviceunit_no_pk", "b.su_no_fk")
            ->select("a.serviceunit_name", "a.serviceunit_no_pk")
            ->where([
                ["a.radiology_ind", "=", 1],
                ["a.status", "=", 1],
                ["b.user_no_fk", "=", Auth::id()],
                ["a.au_entry_hospital_pk_no", "=", Session::get('user.ses_hospital_no_pk')]
            ])->get();
        // dd($department);
        $date = date("Y/m/d");
        // $radiologyAppointment = DB::table("radt_invoicedtl_app_wl_vw a")
        //     ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
        //     ->select(
        //         "a.invoice_code",
        //         "a.appoint_code",
        //         "a.item_name",
        //         "a.radinvoicedtl_no_pk",
        //         "a.patient_no_fk",
        //         "b.patient_name",
        //         "a.serviceunit_name",
        //         "a.room_name",
        //         "a.img_app_sl_no",
        //         "a.img_app_dttm",
        //         "a.delivery_dttm",
        //         "a.ic_image_capture_key_ind",
        //         'a.verify_key_ind',
        //         'a.result_prepared_key_ind',
        //         'a.finalize_key_ind',
        //         'a.invoice_date',
        //         'a.admission_no_pk',
        //     )
        //     ->whereRaw(DB::raw("trunc(img_app_dttm) ='$date'"))
        //     ->where("ic_image_capture_key_ind", 1)
        //     ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
        //     ->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();
        $radiologyAppointment = [];
        $ind_flag = 1;
        $template_name = DB::table("rads_resulttemplate")->select("template_name", "result_template_no_pk", "report_text_html")
            // ->where("su_no_fk", $radiology_appointment_data->serviceunit_no_fk)    for gmc
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->orderByDesc('au_entry_at')
            ->get();

        return Template::loadview("admin.radiology.radiology_result_entry", ["radiologyAppointment" => $radiologyAppointment, "rooms" => $rooms, "ind_flag" => $ind_flag, "department" => $department, 'template_name' => $template_name]);
    }
    public function radiologyResultEntryWorklistDirect()
    {
        $rooms = Room::select('room_no_pk', 'room_name')->get();
        if (Session::get('user.ses_hospital_code') != 'UNICO') {
            $department = DB::table("sysc_serviceunit_vw a")
                ->join("sysc_grant_su b", "a.serviceunit_no_pk", "b.su_no_fk")
                ->select("a.serviceunit_name", "a.serviceunit_no_pk")
                ->where([
                    ["a.radiology_ind", "=", 1],
                    ["a.status", "=", 1],
                    ["b.user_no_fk", "=", Auth::id()],
                    ["a.au_entry_hospital_pk_no", "=", Session::get('user.ses_hospital_no_pk')]
                ])->get();
        } else {
            $codes = [
                'CT-SCAN',
                'MRI',
                'USG',
                'X-Ray',
                'MAMMO',
                'BMD'
                // 'Clinical & Interventional Neurology',
                // 'Clinical & Interventional Cardiology',
            ];

            $department = DB::table('sysc_serviceunit as a')
                ->select('a.serviceunit_name', 'a.serviceunit_no_pk')
                ->where('a.radiology_ind', 1)
                ->where('a.status', 1)
                ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->whereIn('a.SERVICEUNIT_CODE', $codes)
                ->get();
        }
        $ind_flag = 1;
        return Template::loadview("admin.radiology.radiology_result_entry_direct", ["rooms" => $rooms, "ind_flag" => $ind_flag, "department" => $department]);
    }
    public function getRadiologyTemplateInfo(Request $request)
    {
        $template_info = DB::table("rads_resulttemplate r")
            ->select("r.result_template_no_pk", "r.report_text_html")
            ->where("r.result_template_no_pk", $request->template_data)
            ->first();
        $temp = isset($template_info->report_text_html) ? $template_info->report_text_html : " ";
        echo $temp;
    }
    public function radiologyResultEntry($radinvoicedtl_no_pk = "", $type = "", Request $request)
    {
        ini_set('max_execution_time', 0);
        $radiology_appointment_data = DB::table("radt_invoicedtl_app_wl_vw")->select("item_name", "invoice_no_pk", 'serviceunit_no_fk')
            ->where("radinvoicedtl_no_pk", $radinvoicedtl_no_pk)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();

        $invoice_code = isset($radiology_appointment_data) ? $radiology_appointment_data->invoice_no_pk : "";

        $radiology_result_data = DB::table("radt_reporting")
            ->select('rad_report_no_pk', 'result0', 'result_prepared_keyed_by', 'result_verify_keyed_by', 'result_final_keyed_by')
            ->where("radinvoicedtl_no_fk", $radinvoicedtl_no_pk)
            ->where("au_entry_hospital_no_fk", Session::get('user.ses_hospital_no_pk'))
            ->first();
        $patient_info = DB::table("FINC_INVOICEMST a")
            ->select("b.patient_code", "b.patient_name", "b.age", "b.gender_txt", "b.blood_group_txt", "b.marital_status_txt", "b.patient_photo", "b.mobile1", DB::raw('pat_age(b.dob,nvl(dod,sysdate))pat_age'),)
            ->Join("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
            ->where("a.invoice_no_pk", $invoice_code)
            ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
            ->first();
        // dd($invoice_code);

        $image_capture = DB::table("radt_reporting_img")
            ->select("radinvoicedtl_no_pk", "resultimg_path", "image_caption", "rad_report_imgno_pk")
            ->where("au_entry_hospital_no_fk", Session::get('user.ses_hospital_no_pk'))
            ->where("radinvoicedtl_no_pk", $radinvoicedtl_no_pk)->get();


        $prepared_by = $this->getRadiologyResultEntryByUser("save_ind");
        $verified_by = $this->getRadiologyResultEntryByUser("verify_ind");
        $finalize_by = $this->getRadiologyResultEntryByUser("finalize_ind");
        // dd($prepared_by);

        $template_name = DB::table("rads_resulttemplate")->select("template_name", "result_template_no_pk", "report_text_html")
            // ->where("su_no_fk", $radiology_appointment_data->serviceunit_no_fk)    for gmc
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->orderByDesc('au_entry_at')
            ->get();


        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        if ($po_hospital_details->hospital_code == 'KBMH' || $po_hospital_details->hospital_code == 'EWMCH') {
            return Template::loadview(
                "admin.radiology.result_entry_kbmh",
                [
                    "patient_info" => $patient_info,
                    "prepared_by" => $prepared_by,
                    "verified_by" => $verified_by,
                    "finalize_by" => $finalize_by,
                    "template_name" => $template_name,
                    "type" => $type,
                    "radinvoicedtl_no_pk" => $radinvoicedtl_no_pk,
                    "radiology_result_data" => $radiology_result_data,
                    "image_capture" => $image_capture,
                    "radiology_appointment_data" => $radiology_appointment_data,
                ]
            );
        } else {
            return Template::loadview(
                "admin.radiology.result_entry",
                [
                    "patient_info" => $patient_info,
                    "prepared_by" => $prepared_by,
                    "verified_by" => $verified_by,
                    "finalize_by" => $finalize_by,
                    "template_name" => $template_name,
                    "type" => $type,
                    "radinvoicedtl_no_pk" => $radinvoicedtl_no_pk,
                    "radiology_result_data" => $radiology_result_data,
                    "image_capture" => $image_capture,
                    "radiology_appointment_data" => $radiology_appointment_data,
                ]
            );
        }
    }


    public function allRedTemp()
    {
        $template_name = DB::table("rads_resulttemplate")->select("template_name", "result_template_no_pk", "report_text_html")
            // ->where("su_no_fk", $radiology_appointment_data->serviceunit_no_fk)    for gmc
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->get();

        $templates = [];

        foreach ($template_name as $template) {
            array_push($templates, [
                'id' => $template->result_template_no_pk,
                'fullname' => htmlspecialchars($template->report_text_html),
                'username' => $template->template_name
            ]);
        }
        // dd( response()->json( $template_name));
        return response()->json($templates);
    }

    public function storeRadiologyResultEntry(Request $request)
    {
        // dd($request->all());
        $auth_id = Auth::id();
        DB::beginTransaction();

        $radiology_appointment_data = DB::table("radt_invoicedtl_app_wl_vw")
            ->where("radinvoicedtl_no_pk", $request->rad_id)->first();
        $sequence = DB::getSequence();
        $rad_report_no_pk_seq = $sequence->nextValue('rad_report_no_pk_seq');
        // dd(date("d/m/Y", strtotime($request->input("radio_appointment_date"))));
        try {
            if ($request->action_type == "prepare") {
                // dd($request->all());
                $data = [
                    /*  "rad_report_uid"            =>$request->,*/
                    "rad_report_no_pk" => $rad_report_no_pk_seq,
                    "rad_report_uid" => $rad_report_no_pk_seq,
                    "radinvoicedtl_no_fk" => $radiology_appointment_data->radinvoicedtl_no_pk,
                    "invoice_no_fk" => $radiology_appointment_data->invoice_no_pk,
                    "invoicedtl_no_fk" => $radiology_appointment_data->invoicedtl_no_fk,
                    "result0" => $request->editor_content,
                    "result_prepared_key_ind" => 1,
                    "result_prepared_keyed_by" => $request->result_prepared_by,
                    "result_prepared_keyed_time" => date("Y/m/d"),
                    "au_entry_hospital_no_fk" => Session::get('user.ses_hospital_no_pk'),

                    // for ewmch start
                    "result_verify_key_ind" => 1,
                    'au_entry_by' => Auth::id(),
                    'au_entry_at' => date("Y-m-d H:i"),
                    "result_verify_keyed_by" => $request->result_prepared_by,
                    "result_verify_keyed_time" => date("Y/m/d"),
                    // for ewmch end

                ];
                $invoice_data = [
                    'result_prepared_key_ind' => 1,
                    'result_prepared_keyed_by' => $request->result_prepared_by,
                    'result_prepared_keyed_time' => date("Y-m-d"),
                    "au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),

                    // for ewmch start
                    'verify_key_ind' => 1,
                    'au_entry_by' => Auth::id(),
                    'au_entry_at' => date("Y-m-d H:i"),
                    'verify_keyed_by' => $request->result_prepared_by,
                    'verify_keyed_time' => date("Y-m-d"),
                    // for ewmch end

                ];
            }
            if ($request->action_type == "verified") {
                // dd($request->editor_content);
                $data = [
                    /*  "rad_report_uid"            =>$request->,*/
                    "radinvoicedtl_no_fk" => $radiology_appointment_data->radinvoicedtl_no_pk,
                    "invoice_no_fk" => $radiology_appointment_data->invoice_no_pk,
                    "invoicedtl_no_fk" => $radiology_appointment_data->invoicedtl_no_fk,
                    "result0" => $request->editor_content,
                    "result_verify_key_ind" => 1,
                    'au_entry_by' => Auth::id(),
                    'au_entry_at' => date("Y-m-d H:i"),
                    "result_verify_keyed_by" => $request->result_verified_by,
                    "result_verify_keyed_time" => date("Y/m/d"),
                    "au_entry_hospital_no_fk" => Session::get('user.ses_hospital_no_pk'),
                ];
                $invoice_data = [
                    'verify_key_ind' => 1,
                    'au_entry_by' => Auth::id(),
                    'au_entry_at' => date("Y-m-d H:i"),
                    'verify_keyed_by' => $request->result_verified_by,
                    'verify_keyed_time' => date("Y-m-d"),
                    "au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),
                ];
            }
            if ($request->action_type == "finalized") {
                $data = [
                    /*  "rad_report_uid"            =>$request->,*/
                    "rad_report_no_pk" => $rad_report_no_pk_seq,
                    "rad_report_uid" => $rad_report_no_pk_seq,
                    "radinvoicedtl_no_fk" => $radiology_appointment_data->radinvoicedtl_no_pk,
                    "invoice_no_fk" => $radiology_appointment_data->invoice_no_pk,
                    "invoicedtl_no_fk" => $radiology_appointment_data->invoicedtl_no_fk,
                    "result0" => $request->editor_content,
                    "result_final_key_ind" => 1,
                    "result_final_keyed_by" => $request->result_consultant,
                    "result_ent_keyed_time" => date("Y/m/d"),
                    "result_prepared_key_ind" => 1,
                    "result_prepared_keyed_by" => $request->result_prepared_by,
                    "result_prepared_keyed_time" => date("Y/m/d"),
                    "result_verify_key_ind" => 1,
                    'au_entry_by' => Auth::id(),
                    'au_entry_at' => date("Y-m-d H:i"),
                    "result_verify_keyed_by" => $request->result_prepared_by,
                    "result_verify_keyed_time" => date("Y/m/d"),
                    "au_entry_hospital_no_fk" => Session::get('user.ses_hospital_no_pk'),
                ];

                $invoice_data = [
                    'finalize_key_ind' => 1,
                    'finalize_keyed_by' => $request->result_consultant,
                    'finalize_keyed_time' => date("Y-m-d H:i"),
                    'result_prepared_key_ind' => 1,
                    'result_prepared_keyed_by' => $request->result_prepared_by,
                    'result_prepared_keyed_time' => date("Y-m-d"),
                    'verify_key_ind' => 1,
                    'au_entry_by' => Auth::id(),
                    'au_entry_at' => date("Y-m-d H:i"),
                    'verify_keyed_by' => $request->result_prepared_by,
                    'verify_keyed_time' => date("Y-m-d H:i"),
                    'au_entry_at' => date("Y-m-d H:i"),
                    "au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),
                ];
            }

            $image_id = $request->inage_no;
            $image_id_count = $request->inage_no ? $request->inage_no : "";

            if ($image_id_count) {

                for ($i = 0; $i < count($image_id_count); $i++) {
                    $img_data = [
                        'rad_report_no_fk' => $request->rad_report_id,
                        'au_entry_hospital_no_fk' => Session::get('user.ses_hospital_no_pk')
                    ];
                    DB::table('radt_reporting_img')->where('rad_report_imgno_pk', $image_id_count[$i])->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->update($img_data);
                }
            }
            // dd( $data, $invoice_data);
            DB::table('radt_reporting')->where('rad_report_no_pk', $request->rad_report_id)->update($data);
            DB::table('radt_invoicedtl')->where('radinvoicedtl_no_pk', $request->rad_id)->update($invoice_data);
            DB::commit();
            $message = ['msg' => 'Data saved successfully', 'title' => 'Success', 'rad_id' => $request->rad_id];
            return response()->json($message, 200);
        } catch (\Exception $e) {

            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
            return response()->json($message, 422);
        }
        // dd($data);


    }

    public function radiologyResultFinalizeWorklist(Request $request)
    {
        // $rooms = DB::table("SYS_USER_ROOM_PRIVS_VW")
        // ->where('user_no_fk', "=", Auth::user()->user_no_pk)->get();
        $rooms = Room::select('room_no_pk', 'room_name')->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->get();

        $department = DB::table("sysc_serviceunit_vw a")
            ->join("sysc_grant_su b", "a.serviceunit_no_pk", "b.su_no_fk")
            ->select("a.serviceunit_name", "a.serviceunit_no_pk")
            ->where([
                ["a.radiology_ind", "=", 1],
                ["a.status", "=", 1],

                ["b.user_no_fk", "=", Auth::id()],
                ["a.au_entry_hospital_pk_no", "=", Session::get('user.ses_hospital_no_pk')]
            ])->get();

        $date = date("Y/m/d");
        // $radiologyAppointment = DB::table("radt_invoicedtl_app_wl_vw a")
        //     ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
        //     ->select(
        //         "a.invoice_code",
        //         "a.prescription_no_fk",
        //         "a.item_name",
        //         "a.radinvoicedtl_no_pk",
        //         "a.patient_no_fk",
        //         "b.patient_name",
        //         "a.serviceunit_name",
        //         "a.room_name",
        //         "a.img_app_sl_no",
        //         "a.img_app_dttm",
        //         "a.delivery_dttm",
        //         "a.ic_image_capture_key_ind",
        //         "a.verify_key_ind",
        //         "a.result_prepared_key_ind",
        //         'a.verify_key_ind',
        //         'a.finalize_key_ind',
        //         'a.invoice_date',
        //         'a.admission_no_pk',
        //     )
        //     ->whereRaw(DB::raw("trunc(invoice_date) ='$date'"))
        //     ->where('a.verify_key_ind', 1)
        //     ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        //     ->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();
        $ind_flag = 2;
        $type = 2;
        return Template::loadview("admin.radiology.radiology_final_result_entry", ["radiologyAppointment" => [], "rooms" => $rooms, "department" => $department, "ind_flag" => $ind_flag, "type" => $type]);
    }

    public function searchResultFinalizeEntryList(Request $request)
    {
        $prescription_id = $request->invoice_id;

        $appointment_list_department = $request->appointment_list_department;
        $appointment_list_room = $request->appointment_list_room;
        $appointment_list_to = $request->appointment_list_to;
        $from_date = date("d-m-Y", strtotime($request->appointment_list_form));
        $to_date = date("d-m-Y", strtotime($request->appointment_list_to));
        $date_cond = !empty($request->appointment_list_form) ? " trunc(a.invoice_date) between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')" : "";
        $appointment_qeury = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->select("a.invoice_code", "a.radinvoicedtl_no_pk", "a.item_name", "a.prescription_no_fk", "a.patient_no_fk", "b.patient_name", "a.serviceunit_name", "a.room_name", "a.img_app_sl_no", "a.img_app_dttm", "a.img_app_sl_no", 'a.ic_image_capture_key_ind', 'a.ic_image_capture_keyed_by', 'a.ic_image_capture_keyed_time', 'a.delivery_dttm', 'a.verify_key_ind', 'a.result_prepared_key_ind', 'a.finalize_key_ind', 'a.invoice_date', 'a.admission_no_pk')
            ->where("a.verify_key_ind", 1);

        if (!empty($date_cond)) {
            $appointment_qeury->when($date_cond, function ($query, $date_cond) {
                return $query->whereRaw(DB::raw($date_cond));
            });
        }
        if ($appointment_list_room != "") {
            $appointment_qeury->when($appointment_list_room, function ($query, $appointment_list_room) {
                return $query->where('a.room_no_fk', $appointment_list_room);
            });
        }
        if ($appointment_list_department != "0") {
            $appointment_qeury->when($appointment_list_department, function ($query, $appointment_list_department) {
                return $query->where('a.serviceunit_no_fk', $appointment_list_department);
            });
        }
        $appointment_qeury->when($prescription_id, function ($query, $prescription_id) {
            return $query->where('a.invoice_code', $prescription_id);
        });

        $radiologyAppointment = $appointment_qeury->orderBy('a.radinvoicedtl_no_pk', 'desc')->get();

        $ind_flag = 2;
        if (Session::get('user.ses_hospital_code') != "UNICO") {
            return Template::loadview("admin.radiology.radiology_result_entry_list", ["radiologyAppointment" => $radiologyAppointment, "ind_flag" => $ind_flag]);
        } else {
            return Template::loadview("admin.radiology_v2.result.radiology_result_entry_list_v2", ["radiologyAppointment" => $radiologyAppointment, "ind_flag" => $ind_flag]);
        }
    }

    public function searchResultEntryList(Request $request)
    {
        //dd('tst');
        $voucher_no = $request->invoice_id;

        $appointment_list_department = $request->appointment_list_department;
        $appointment_list_room = $request->room_no_fk;
        // $appointment_list_form = $request->appointment_list_form;
        $appointment_list_to = $request->appointment_list_to;

        $from_date = date("d-m-Y", strtotime($request->appointment_list_form));
        $to_date = date("d-m-Y", strtotime($request->appointment_list_to));
        $date_cond = ($request->appointment_list_form != "") ? " a.img_app_dttm between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')" : "";
        $appointment_qeury = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->select("a.invoice_code", "a.invoice_date", "a.radinvoicedtl_no_pk", "a.item_name", "a.prescription_no_fk", "a.admission_no_pk", "a.patient_no_fk", "b.patient_name", "a.serviceunit_name", "a.room_name", "a.img_app_sl_no", "a.img_app_dttm", "a.img_app_sl_no", 'a.ic_image_capture_key_ind', 'a.ic_image_capture_keyed_by', 'a.ic_image_capture_keyed_time', 'a.delivery_dttm', 'a.verify_key_ind', 'a.result_prepared_key_ind', 'a.finalize_key_ind')
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));
        // ->where("ic_image_capture_key_ind", 1)
        if ($date_cond != "") {
            $appointment_qeury->when($date_cond, function ($query, $date_cond) {
                return $query->whereRaw(DB::raw($date_cond));
            });
        }
        if ($appointment_list_room != "") {
            $appointment_qeury->when($appointment_list_room, function ($query, $appointment_list_room) {
                return $query->where('a.room_no_fk', $appointment_list_room);
            });
        }
        if ($appointment_list_department != "0") {
            $appointment_qeury->when($appointment_list_department, function ($query, $appointment_list_department) {
                return $query->where('a.serviceunit_no_fk', $appointment_list_department);
            });
        }
        $appointment_qeury->when($voucher_no, function ($query, $voucher_no) {
            return $query->where('a.invoice_code', $voucher_no);
        });
        $radiologyAppointment = $appointment_qeury->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();
        // dd($radiologyAppointment);
        $ind_flag = 1;
        $template_name = DB::table("rads_resulttemplate")->select("template_name", "result_template_no_pk", "report_text_html")
            // ->where("su_no_fk", $radiology_appointment_data->serviceunit_no_fk)    for gmc
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->orderByDesc('au_entry_at')
            ->get();
        if (Session::get('user.ses_hospital_code') != "UNICO") {
            return Template::loadview("admin.radiology.radiology_result_entry_list", ["radiologyAppointment" => $radiologyAppointment, "ind_flag" => $ind_flag]);
        } else {
            return Template::loadview("admin.radiology_v2.result.radiology_result_entry_list_v2", ["radiologyAppointment" => $radiologyAppointment, "ind_flag" => $ind_flag]);
        }
        // return Template::loadview("admin.radiology.radiology_result_entry_list", ["radiologyAppointment" => $radiologyAppointment, "ind_flag" => $ind_flag, 'template_name' => $template_name]);
    }
    public function searchResultEntryListDirect(Request $request)
    {
        $voucher_no = $request->voucher_no;
        $hdn_patient_id = $request->hdn_patient_id;
        $status_check = $request->status_check;

        $appointment_list_department = $request->appointment_list_department;
        $appointment_list_room = $request->room_no_fk;
        // $appointment_list_form = $request->appointment_list_form;
        $appointment_list_to = $request->appointment_list_to;

        $from_date = date("d-m-Y", strtotime($request->appointment_list_form));
        $to_date = date("d-m-Y", strtotime($request->appointment_list_to . ' + 1 days'));
        $date_cond = ($request->appointment_list_form != "") ? " a.invoice_date between to_date('$from_date','DD-MM-YYYY') and to_date('$to_date','DD-MM-YYYY')" : "";
        if (Session::get('user.ses_hospital_code') == "UNICO") {
            $appointment_qeury = DB::table("radt_invoicedtl_app_wl_vw a")
                ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
                ->join("sysc_serviceunit unit", "unit.serviceunit_no_pk", "a.serviceunit_no_fk")
                ->select("b.mobile1", "b.gender_txt", "b.patient_photo", "a.finalize_keyed_by", "a.invoice_code", "a.admission_no_pk", "a.radinvoicedtl_no_pk", "a.item_code", "a.item_name", "a.prescription_no_fk", "a.patient_code", "a.patient_no_fk", "b.patient_name", "a.serviceunit_name", "a.room_name", "a.img_app_sl_no", "a.img_app_dttm", "a.img_app_sl_no", 'a.ic_image_capture_key_ind', 'a.ic_image_capture_keyed_by', 'a.ic_image_capture_keyed_time', 'a.delivery_dttm', 'a.verify_key_ind', 'a.result_prepared_key_ind', 'a.finalize_key_ind', 'a.invoice_date', 'a.invoice_no_pk')
                ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->whereIn('unit.SERVICEUNIT_CODE', ['CT‑SCAN', 'MRI', 'USG', 'X‑Ray', 'MAMMO', 'BMD']);
        } else {
            $appointment_qeury = DB::table("radt_invoicedtl_app_wl_vw a")
                ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
                ->select("b.mobile1", "b.gender_txt", "b.patient_photo", "a.finalize_keyed_by", "a.invoice_code", "a.admission_no_pk", "a.radinvoicedtl_no_pk", "a.item_name", "a.prescription_no_fk", "a.patient_code", "a.patient_no_fk", "b.patient_name", "a.serviceunit_name", "a.room_name", "a.img_app_sl_no", "a.img_app_dttm", "a.img_app_sl_no", 'a.ic_image_capture_key_ind', 'a.ic_image_capture_keyed_by', 'a.ic_image_capture_keyed_time', 'a.delivery_dttm', 'a.verify_key_ind', 'a.result_prepared_key_ind', 'a.finalize_key_ind', 'a.invoice_date', 'a.invoice_no_pk')
                ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'));
        }



        if ($date_cond != "") {
            $appointment_qeury->when($date_cond, function ($query, $date_cond) {
                return $query->whereRaw(DB::raw($date_cond));
            });
        }
        // if ($appointment_list_room != "") {
        //     $appointment_qeury->when($appointment_list_room, function ($query, $appointment_list_room) {
        //         return $query->where('a.room_no_fk', $appointment_list_room);
        //     });
        // }
        if ($appointment_list_department != "0") {
            $appointment_qeury->when($appointment_list_department, function ($query, $appointment_list_department) {
                return $query->where('a.serviceunit_no_fk', $appointment_list_department);
            });
        }
        $appointment_qeury->when($voucher_no, function ($query, $voucher_no) {
            return $query->where('a.invoice_code', $voucher_no);
        });

        $appointment_qeury->when($hdn_patient_id, function ($query, $hdn_patient_id) {
            return $query->where('a.patient_no_fk', $hdn_patient_id);
        });



        $appointment_qeury
            ->when($status_check == 1, function ($query) {
                return $query->where('a.finalize_key_ind', 1);
            });
        $appointment_qeury
            ->when($status_check == 2, function ($query) {
                return $query->whereNull('a.finalize_key_ind');
            });


        $radiologyAppointment = $appointment_qeury->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();
        $ind_flag = 1;
        // dd($radiologyAppointment);
        return Template::loadview("admin.radiology.radiology_result_entry_list_direct", ["radiologyAppointment" => $radiologyAppointment, "ind_flag" => $ind_flag]);
    }



    public function resultEntryPdf($radinvoicedtl_no_pk)
    {
        try {
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
                    "a.finalize_keyed_time",
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
                    'a.admission_no_pk',
                    'a.ward_name',
                    'a.bed_name',
                    'a.item_code'
                )
                ->where("a.radinvoicedtl_no_pk", $radinvoicedtl_no_pk)->first();
            $patient_info = DB::table("finc_voucherwise_vw a")
                ->select("a.invoice_code", "b.patient_code", "b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "a.first_ref_doc_name", "b.salutation", "b.passport_no", DB::raw('pat_age(b.dob,nvl(dod,sysdate))pat_age'))
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

            $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => Auth::id(),
                'result_print_keyed_time' => date('Y-m-d h:i'),
            ];

            DB::table('radt_reporting')->where('radinvoicedtl_no_fk', $radinvoicedtl_no_pk)->update($data);

            if ($po_hospital_details->hospital_code == 'KBMH') {

                if ($radiology_appointment_data->item_code == 'S268355623a' || $radiology_appointment_data->item_code == 'S26833997ee' || $radiology_appointment_data->item_code == 'S26835562' || $radiology_appointment_data->item_code == 'S26834005') {
                    $pdf = PDF::loadView("admin.radiology.reports.radiology_report_kbmh_echo", [
                        "app_barcode" => $app_barcode,
                        "invoice_barcode" => $invoice_barcode,
                        "patient_info" => $patient_info,
                        "radiology_appointment_data" => $radiology_appointment_data,
                        "po_hospital_details" => $po_hospital_details
                    ]);
                    return $pdf->download('radiology_2Page.pdf');
                } else {
                    return view("admin.radiology.reports.radiology_report_kbmh", [
                        "app_barcode" => $app_barcode,
                        "invoice_barcode" => $invoice_barcode,
                        "patient_info" => $patient_info,
                        "radiology_appointment_data" => $radiology_appointment_data,
                        "po_hospital_details" => $po_hospital_details
                    ]);
                }
            } else {


                if (Session::get('user.ses_hospital_code') == "EWMCH") {
                    return view("admin.radiology.reports.radiology_report_ewmch", [
                        "app_barcode" => $app_barcode,
                        "invoice_barcode" => $invoice_barcode,
                        "patient_info" => $patient_info,
                        "radiology_appointment_data" => $radiology_appointment_data,
                        "po_hospital_details" => $po_hospital_details
                    ]);
                } else if (Session::get('user.ses_hospital_code') == "DMHL" || Session::get('user.ses_hospital_code') == "DIGILAB") {

                    return View("admin.radiology.reports.radiology_report_v1", [
                        "app_barcode" => $app_barcode,
                        "invoice_barcode" => $invoice_barcode,
                        "patient_info" => $patient_info,
                        "radiology_appointment_data" => $radiology_appointment_data,
                        "po_hospital_details" => $po_hospital_details
                    ]);
                } else {

                    return view("admin.radiology.reports.radiology_report", [
                        "app_barcode" => $app_barcode,
                        "invoice_barcode" => $invoice_barcode,
                        "patient_info" => $patient_info,
                        "radiology_appointment_data" => $radiology_appointment_data,
                        "po_hospital_details" => $po_hospital_details
                    ]);
                }
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['msg' => $e->getMessage(), 'title' => 'Error']);
        };
    }

    public function resultEntryPdfV1($radinvoicedtl_no_pk)
    {
        try {
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
                    'a.admission_no_pk',
                    'a.ward_name',
                    'a.bed_name',
                    'a.item_code'
                )
                ->where("a.radinvoicedtl_no_pk", $radinvoicedtl_no_pk)->first();
            $patient_info = DB::table("finc_voucherwise_vw a")
                ->select("a.invoice_code", "b.patient_code", "b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "a.first_ref_doc_name", "b.salutation", "b.passport_no", DB::raw('pat_age(b.dob,nvl(dod,sysdate))pat_age'))
                ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                ->where("a.invoice_code", $radiology_appointment_data->invoice_code)->first();

            $po_hospital_details = DB::table("wsec_hospital")->first();
            $app_barcode = '';
            $invoice_barcode = '';

            if (empty($radiology_appointment_data)) {
                return view("admin.components.error_alert");
            }

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

            $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => Auth::id(),
                'result_print_keyed_time' => date('Y-m-d h:i'),
            ];
            DB::table('radt_reporting')->where('radinvoicedtl_no_fk', $radinvoicedtl_no_pk)->update($data);

            if ($po_hospital_details->hospital_code == 'KBMH') {
                if ($radiology_appointment_data->item_code == 'S268355623a' || $radiology_appointment_data->item_code == 'S26833997ee' || $radiology_appointment_data->item_code == 'S26835562' || $radiology_appointment_data->item_code == 'S26834005') {
                    $pdf = PDF::loadView("admin.radiology.reports.radiology_report_kbmh_echo", [
                        "app_barcode" => $app_barcode,
                        "invoice_barcode" => $invoice_barcode,
                        "patient_info" => $patient_info,
                        "radiology_appointment_data" => $radiology_appointment_data,
                        "po_hospital_details" => $po_hospital_details
                    ]);
                    return $pdf->download('radiology_2Page.pdf');
                } else {
                    return view("admin.radiology.reports.radiology_report_kbmh", [
                        "app_barcode" => $app_barcode,
                        "invoice_barcode" => $invoice_barcode,
                        "patient_info" => $patient_info,
                        "radiology_appointment_data" => $radiology_appointment_data,
                        "po_hospital_details" => $po_hospital_details
                    ]);
                }
            } else if (Session::get('user.ses_hospital_code') == "EWMCH") {
                return view("admin.radiology.reports.radiology_report_v1_ewmch", [
                    "app_barcode" => $app_barcode,
                    "invoice_barcode" => $invoice_barcode,
                    "patient_info" => $patient_info,
                    "radiology_appointment_data" => $radiology_appointment_data,
                    "po_hospital_details" => $po_hospital_details
                ]);
            } else if (Session::get('user.ses_hospital_code') == "UNICO") {
                return view("admin.radiology.reports.radiology_report_v1_uhl", [
                    "app_barcode" => $app_barcode,
                    "invoice_barcode" => $invoice_barcode,
                    "patient_info" => $patient_info,
                    "radiology_appointment_data" => $radiology_appointment_data,
                    "po_hospital_details" => $po_hospital_details
                ]);
            } else if (Session::get('user.ses_hospital_code') == "DMHL") {
                return view("admin.radiology.reports.radiology_report_v1_dmhl", [
                    "app_barcode" => $app_barcode,
                    "invoice_barcode" => $invoice_barcode,
                    "patient_info" => $patient_info,
                    "radiology_appointment_data" => $radiology_appointment_data,
                    "po_hospital_details" => $po_hospital_details
                ]);
            } else if (Session::get('user.ses_hospital_code') == "IMPERIAL") {
                return view("admin.radiology.reports.radiology_report_v1_imperial", [
                    "app_barcode" => $app_barcode,
                    "invoice_barcode" => $invoice_barcode,
                    "patient_info" => $patient_info,
                    "radiology_appointment_data" => $radiology_appointment_data,
                    "po_hospital_details" => $po_hospital_details
                ]);
            } else {
                return View("admin.radiology.reports.radiology_report_v1", [
                    "app_barcode" => $app_barcode,
                    "invoice_barcode" => $invoice_barcode,
                    "patient_info" => $patient_info,
                    "radiology_appointment_data" => $radiology_appointment_data,
                    "po_hospital_details" => $po_hospital_details
                ]);


                // $dom_pdf = $pdf->getDomPDF();
                // $canvas = $dom_pdf->get_canvas();
                // $canvas->page_text(520, 820, "Page {PAGE_NUM} of {PAGE_COUNT}", null, 10, array(0, 0, 0));

                // return $pdf->stream('radiology_report.pdf');
            }
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'title' => 'Error']);
        };
    }


    public function resultEntryPdfAll($radinvoicedtl_no_pk)
    {

        $report_id_exp = explode('_', $radinvoicedtl_no_pk);
        $report_id_arr = array_filter($report_id_exp);

        $radiology_appointment_data = [];
        $patient_info = [];
        $rad_barcode = [];
        for ($i = 0; $i < count($report_id_arr); $i++) {
            // $appointment[] =  DB::table('labt_report_procees_vw')
            // ->where('invoice_no_fk', $report_id_arr[$i])
            // ->first();

            $radiology_appointment_data[] = DB::table("radt_invoicedtl_app_wl_vw a")
                ->leftjoin("radt_reporting b", "a.radinvoicedtl_no_pk", "b.radinvoicedtl_no_fk")
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
                    'a.accession_id'
                )
                ->where("a.radinvoicedtl_no_pk", $report_id_arr[$i])->first();

            $patient_info[] = DB::table("finc_voucherwise_vw a")
                ->select("a.invoice_code", "b.patient_code", "b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "a.first_ref_doc_name", 'b.patient_code')
                ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                ->where("a.invoice_code", $radiology_appointment_data[$i]->invoice_code)->first();


            $app_barcode = '';
            $invoice_barcode = '';


            if (!empty($radiology_appointment_data)) {
                $barcode = new BarcodeGenerator();
                $barcode->setText($radiology_appointment_data[$i]->rad_report_uid);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $app_barcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($radiology_appointment_data[$i]->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setScale(1);
                $barcode1->setLabel('');
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_barcode = $barcode1->generate();
            }
        }

        $po_hospital_details = DB::table("wsec_hospital")->first();


        /*return Template::loadView("admin.radiology.reports.radiology_report",[
                "prescription_barcode"          => $prescription_barcode,
                "rad_barcode"                   => $rad_barcode,
                "patient_info"                  => $patient_info,
                "radiology_appointment_data"    => $radiology_appointment_data
            ]);*/
        //$report_data = DB::table("labt_testresultstruct_vw")->where('report_no_fk', $report_id)->where('show_in_rep', 1)->get()->toArray();

        $pdf = PDF::loadView("admin.radiology.reports.radiology_report", [
            "app_barcode" => $app_barcode,
            "invoice_barcode" => $invoice_barcode,
            "patient_info" => $patient_info,
            "radiology_appointment_data" => $radiology_appointment_data,
            "po_hospital_details" => $po_hospital_details
        ]);
        return $pdf->download("Radiology_Report.pdf");
    }

    public function reportTemplateBuild()
    {
        $department = DB::table("sysc_serviceunit ")->where('radiology_ind', '=', 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        return Template::loadview("admin.radiology.report_template_build", ['department' => $department]);
    }

    public function reportRemplate()
    {
        // $department= DB::table("sys_serviceunit ")->where('radiology_ind', '=', 1)->get();
        return Template::loadview("admin.radiology.report_template_list");
    }

    public function reportRemplateLoad()
    {
        $templates = DB::table('rads_resulttemplate_vw')->where('status', 1)->get();
        return response()->json($templates);
    }


    public function templateStore(Request $request)
    {
        // return $request->desc;
        // dd($request->editor_content, $request);
        $id = $request->id;

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [
                'su_no_fk' => $request->department_name,
                'result_template_uid' => $request->template_uid,
                'template_name' => $request->template_name,
                'report_text_html' => $request->editor_content,
                'sl_no' => $request->sl_no,
                'template_date' => date('Y,m,d', strtotime($request->template_date)),
                'default_ind' => isset($request->default_ind) ? 1 : 0,
                'share_ind' => isset($request->share_ind) ? 1 : 0,
                'general_ind' => isset($request->general_ind) ? 1 : 0,
                'status' => isset($request->status) ? 1 : 0,
                'au_entry_hospital_no_fk' => $hospital_id,
            ];

            if ($id == null) {
                $data['au_entry_by'] = $auth_id;
                $this->model2->create($data);
            } else {
                // dd( $data);
                $data['au_update_by'] = $auth_id;
                $this->model2->update($data, $id);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function getAllReportTemplate(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $columns = array(
            'sl',
            'su_name',
            'result_template_uid',
            'template_name',
            'sl_no',
            'report_text_html',
            'template_date',
            'default_ind',
            'share_ind',
            'general_ind',
            'status',
            'result_template_no_pk'
        );

        $yes = '<span class="badge badge-md badge-success "> Yes</span>';
        $no = '<span class="badge badge-md badge-secondary"> No</span>';
        $sql = "select '' as sl, su_name, result_template_uid,template_name,sl_no, report_text_html, TO_CHAR(template_date, 'dd/mm/yyyy') template_date,  CASE WHEN default_ind  =1  THEN '$yes' ELSE '$no' END AS default_ind,   CASE WHEN share_ind  =1  THEN '$yes' ELSE '$no' END AS share_ind ,CASE WHEN general_ind  =1  THEN '$yes' ELSE '$no' END AS  general_ind, CASE WHEN status  =1  THEN '$yes' ELSE '$no' END AS  status, result_template_no_pk, rownum rownumber, au_update_at, au_entry_at  from rads_resulttemplate_vw ";


        // where au_entry_hospital_no_fk = $ses_hospital_id


        $order_by_column = "result_template_no_pk";


        $json_data = $this->datatable($request, $sql, $order_by_column, 'DESC', $columns);

        // dd($json_data);
        echo json_encode($json_data);
    }

    public function templateEdit($id)
    {
        $template = $this->model2->show($id);
        // $template= $this->model->show($id);
        // dd($template);
        $department = DB::table("sysc_serviceunit ")->where('radiology_ind', '=', 1)->get();
        return Template::loadview("admin.radiology.report_template_build", ['department' => $department, 'template' => $template]);
    }
    public function templateDel($id)
    {
        $template = $this->model2->show($id);
        // $template= $this->model->show($id);
        // dd($template->result_template_no_pk);
        try {
            DB::table("rads_resulttemplate_vw ")->where('result_template_no_pk', $template->result_template_no_pk)->delete();
            DB::commit();
            $message = ['msg' => 'Bill create successfully.', 'title' => 'Success'];
        } catch (\Throwable $th) {
            DB::rollback();
            $message = ['msg' => ' Failled.', 'title' => 'Error'];
        }
        return response()->json($message);
    }

    //        Added By Nazmul 30may 2021
    public function reportProcessPathology()
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $type = 2;
        $operation = 'finalize';
        $service_unit = DB::table('sysc_serviceunit')
            ->where('pathology_ind', '1' and 'status', '1')
            ->where('au_entry_hospital_pk_no', $hospital_id)
            ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')
            ->get()
            ->toArray();
        $invoice_item_arr = DB::select(DB::raw("select * from labt_report_procees_vw where lab_result_final_key_ind = 1 and au_entry_hospital_pk_no = $hospital_id and trunc(invoice_date) = trunc(sysdate) and cancel_ind is null and report_rcb_ind is null"));

        return Template::loadView('admin.pathology.process.report_process', [
            'type' => $type,
            'operation' => $operation,
            'service_unit' => $service_unit,
            'invoice_item_arr' => $invoice_item_arr
        ]);
    }
    public function pathResultProcessSearch(Request $request)
    {
        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $invoice_id = $request->invoice_id;
        $patient_id = $request->patient_id;
        $admission_no = $request->admission_no;
        $dept = $request->dept;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(labt_report_procees_vw.invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($invoice_id != "") ? " $clause labt_report_procees_vw.invoice_no_fk = $invoice_id" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($patient_id != "") ? " $clause labt_report_procees_vw.patient_name = '$patient_id'" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($admission_no != "") ? " $clause labt_report_procees_vw.patient_name = '$admission_no'" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($dept != "") ? " $clause labt_report_procees_vw.service_unit_no_fk = $dept" : "";
        $hospital_id = Session::get('user.ses_hospital_no_pk');

        $result_data = DB::select(DB::raw("select labt_report_procees_vw.*,finc_invoicemst.patient_code from labt_report_procees_vw left join finc_invoicemst on finc_invoicemst.invoice_no_pk = labt_report_procees_vw.invoice_no_fk $sql_cond and labt_report_procees_vw.lab_result_final_key_ind = 1 and labt_report_procees_vw.cancel_ind is null and labt_report_procees_vw.report_rcb_ind is null and labt_report_procees_vw.au_entry_hospital_pk_no = $hospital_id "));

        return Template::loadview("admin.pathology.process.report_process_list", [
            'invoice_item_arr' => $result_data,
        ]);
    }


    //        Radiology Start Here

    public function reportProcessRadiology()
    {
        $rooms = Room::select('room_no_pk', 'room_name')->get();

        $department = DB::table("sysc_serviceunit_vw a")
            ->join("sysc_grant_su b", "a.serviceunit_no_pk", "b.su_no_fk")
            ->select("a.serviceunit_name", "a.serviceunit_no_pk")
            ->where([
                ["a.radiology_ind", "=", 1],
                ["a.status", "=", 1],
                ["b.user_no_fk", "=", Auth::id()]
            ])->get();
        $date = date("Y/m/d");
        $radiologyAppointment = DB::table('radt_report_procees_vw')
            ->where('finalize_key_ind', 1)
            ->where('img_app_dttm', date('Y-m-d'))
            ->get()

            ->toArray();
        $ind_flag = 2;
        $type = 2;
        return Template::loadview("admin.radiology.process.report_process", [
            "radiologyAppointment" => $radiologyAppointment,
            "rooms" => $rooms,
            "department" => $department,
            "ind_flag" => $ind_flag,
            "type" => $type
        ]);
    }
    public function radResultProcessSearch(Request $request)
    {

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = "$request->search_date_from"; //date('Y/m/d', strtotime($request->date_from));
            $date_to = "$request->search_date_to"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $date_from = "";
            $date_to = "";
        }
        $invoice_id = $request->invoice_id;
        $patient_id = $request->patient_id;
        $admission_no = $request->admission_no;
        $dept = $request->dept;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','DD/MM/YYYY') and TO_DATE('$date_to','DD/MM/YYYY')" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_pk = $invoice_id" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($patient_id != "") ? " $clause patient_name = '$patient_id'" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($admission_no != "") ? " $clause patient_name = '$admission_no'" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($dept != "") ? " $clause SERVICEUNIT_NO_FK = $dept" : "";

        $result_data = DB::select(DB::raw("select * from radt_report_procees_vw $sql_cond and finalize_key_ind = 1"));

        $hospital_id = Session::get('user.ses_hospital_code');
        if ($hospital_id != 'UNICO') {
            return Template::loadview("admin.radiology.process.report_process_list", [
                'radiologyAppointment' => $result_data,
            ]);
        } else {
            return Template::loadview("admin.radiology.process.report_process_list_uhl", [
                'radiologyAppointment' => $result_data,
            ]);
        }
    }

    public function savePathologyUpdate(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();
        $invoice_no_pk = $request->is_paid_amount;

        for ($i = 0; $i < count($invoice_no_pk); $i++) {
            $data = array();
            $data['report_rcb_ind'] = 1;
            $data['au_update_by'] = $auth_id;
            $data['au_update_at'] = date('Y-m-d');
            $data['au_update_session'] = 'report process';
            $data['au_update_hospital_pk_no'] = $hospital_id;
            // dd($invoice_no_pk[$i]);
            $getData = DB::table('labt_testreporting')->where('report_no_pk', $invoice_no_pk[$i])->update($data);
        }
        DB::commit();
        if ($getData) {
            $message = ['msg' => 'Pathology Report Process Completed successfully.', 'title' => 'Success'];
        } else {
            $message = ['msg' => 'Pathology Report Process Failed', 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function saveRadiologyUpdate(Request $request)
    {
        $invoice_no_pk = $request->is_paid_amount;
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $auth_id = Auth::id();
        for ($i = 0; $i < count($invoice_no_pk); $i++) {
            $data = array();
            $data['report_rcb_ind'] = 1;
            $data['au_entry_by'] = $auth_id;
            $data['au_entry_at'] = date('Y-m-d');
            $data['au_entry_session'] = 'session';
            //                $data['au_entry_hospital_pk_no'] = 1;
            $getData = DB::table('radt_reporting')->where('rad_report_no_pk', $invoice_no_pk[$i])->update($data);
        }

        if ($getData) {
            $message = ['msg' => 'Radiology Report Process Completed successfully.', 'title' => 'Success'];
        } else {
            $message = ['msg' => 'Radiology Report Process Failed', 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function reportDelivery()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $todate = date('Y-m-d');
        if (Session::get('user.ses_hospital_code') == "IMPERIAL") {
            $pathology_data = DB::select(DB::raw("select * from pat_report_del_vw
            where admission_uid is null and report_rcb_ind = 1 and invoice_date between '$todate' and to_char (sysdate + 1) order by invoice_date desc"));

            $radiology_data = db::select(db::raw("select * from RADT_REPORT_PROCEES_VW where admission_uid  is null and report_rcb_ind = 1 and invoice_date between '$todate' and to_char (sysdate + 1)"));
        } else {
            $pathology_data = []; // DB::select(DB::raw("select * from pat_report_del_vw where admission_uid  is null and report_rcb_ind = 1  and invoice_date between to_char (sysdate - 7) and to_char (sysdate + 1) order by invoice_date desc"));
            $radiology_data = []; // db::select(db::raw("select * from RADT_REPORT_PROCEES_VW where admission_uid  is null and report_rcb_ind = 1 and invoice_date between to_char (sysdate - 7) and to_char (sysdate + 1)"));
        }
        // dd( $pathology_data);
        $ind_flag = 2;
        $type = 2;

        return Template::loadView('admin.radiology.report_delivery.report_delivery', [
            'pathology' => $pathology_data,
            'radiology' => $radiology_data,
            'ind_flag' => $ind_flag,
            'type' => $type
        ]);
    }

    public function deliveryAllData(Request $request)
    {
        $tab_type = $request->tab_type;

        //            receive Data
        if ($tab_type == 1) {
            $service_unit = DB::table('sysc_serviceunit')
                ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')
                ->get()
                ->toArray();
            $pathology_data = DB::table('labt_report_procees_vw')
                ->where('report_rcb_ind', 1)
                ->whereNull('cancel_ind')
                ->where('report_deli_pending_ind', null)
                ->get()
                ->toArray();
            $rooms = Room::select('room_no_pk', 'room_name')->get();
            $radiology_data = DB::table('radt_report_procees_vw')
                ->where('radt_report_rcb_ind', 1)
                ->where('delivery_pending_ind', null)
                ->get()
                ->toArray();
            return Template::loadView('admin.radiology.process.delivery_receive', [
                'service_unit' => $service_unit,
                'pathology' => $pathology_data,
                'radiology' => $radiology_data,
                'rooms' => $rooms
            ]);
        }
        //            delivery Pending
        if ($tab_type == 2) {
            $service_unit = DB::table('sysc_serviceunit')
                ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')
                ->get()
                ->toArray();
            $pathology_data = DB::table('labt_report_procees_vw')
                ->where('report_deli_pending_ind', 1)
                ->whereNull('cancel_ind')
                ->where('report_delivered_ind', null)
                ->get()
                ->toArray();
            $rooms = Room::select('room_no_pk', 'room_name')->get();
            $radiology_data = DB::table('radt_report_procees_vw')
                ->where('delivery_pending_ind', 1)
                ->where('radt_delivered_ind', null)
                ->get()
                ->toArray();
            return Template::loadView('admin.radiology.process.delivery_pending', [
                'service_unit' => $service_unit,
                'pathology' => $pathology_data,
                'radiology' => $radiology_data,
                'rooms' => $rooms
            ]);
        }
        //            Delivered
        if ($tab_type == 3) {
            $service_unit = DB::table('sysc_serviceunit')
                ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')
                ->get()
                ->toArray();
            $pathology_data = DB::table('labt_report_procees_vw')
                ->where('report_delivered_ind', 1)
                ->whereNull('cancel_ind')
                ->get()
                ->toArray();
            $rooms = Room::select('room_no_pk', 'room_name')->get();
            $radiology_data = DB::table('radt_report_procees_vw')
                ->where('radt_delivered_ind', 1)
                ->get()
                ->toArray();
            return Template::loadView('admin.radiology.process.report_delivered', [
                'service_unit' => $service_unit,
                'pathology' => $pathology_data,
                'radiology' => $radiology_data,
                'rooms' => $rooms
            ]);
        }
        //            Status
        if ($tab_type == 4) {
            $service_unit = DB::table('sysc_serviceunit')
                ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')
                ->get()
                ->toArray();
            $pathology_data = DB::table('labt_report_procees_vw')
                ->where('report_rcb_ind', 1)
                ->whereNull('cancel_ind')
                ->get()
                ->toArray();
            $rooms = Room::select('room_no_pk', 'room_name')->get();
            $radiology_data = DB::table('radt_report_procees_vw')
                ->where('radt_report_rcb_ind', 1)
                ->get()
                ->toArray();
            return Template::loadView('admin.radiology.process.report_status', [
                'service_unit' => $service_unit,
                'pathology' => $pathology_data,
                'radiology' => $radiology_data,
                'rooms' => $rooms
            ]);
        }
    }

    //        All Search Here

    public function receiveDataSearch(Request $request)
    {
        // dd($request->all());
        $ses_hospital_id = Session::get('user.ses_hospital_code');

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = $request->search_date_from != "" ? date('Y-m-d', strtotime($request->search_date_from)) : ''; //"$request->search_date_from";
            $date_to = $request->search_date_to != "" ? date('Y-m-d', strtotime($request->search_date_to)) : ''; // "$request->search_date_to";

        } else {
            $date_from = "";
            $date_to = "";
        }
        // dd($date_from  ,$date_to);
        $invoice_id = $request->invoice_id;
        $patient_id = $request->patient_id;
        $admission_no = $request->hdn_admission_id;
        $dept = $request->dept;
        $tab_type = $request->type;
        //  $patient_status = $request->patient_status;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','YYYY-MM-DD') and TO_DATE('$date_from','YYYY-MM-DD')" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_pk = $invoice_id" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($patient_id != "") ? " $clause lab.patient_name = '$patient_id'" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($admission_no != "") ? " $clause ADMISSION_UID = '$admission_no'" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($dept != "") ? " $clause service_unit_no_fk = $dept" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= " $clause admission_uid  is null";


        if (in_array($ses_hospital_id, ['EWMCH', 'IMPERIAL', 'UNICO', 'DMHL'])) {
            $pathology_data = DB::select(DB::raw("SELECT report_no_fk,
                                    report_delivered_ind,
                                    invoice_no_pk,
                                    invoice_date,
                                    patient_name,
                                    sc_sample_coll_keyed_time,
                                    item_name,
                                    report_delivered_ind,
                                    delivered_by,
                                    delivered_by,
                                    report_delivered_time,
                                    report_deli_pending_ind,
                                    received_by,
                                    report_rcb_keyed_time,
                                    report_rcb_ind,
                                    due
                            FROM pat_report_del_vw $sql_cond"));
        } else {
            $pathology_data = DB::select(DB::raw("select *
                                              from labt_report_procees_vw
                                             where admission_uid is null and invoice_date between to_char (sysdate - 7) and to_char (sysdate)
                                                   and report_rcb_ind = 1
                                                and cancel_ind is null"));
        }

        //  dd($pathology_data);
        // echo "select * from pat_report_del_vw $sql_cond";
        if (in_array($ses_hospital_id, ['EWMCH', 'IMPERIAL', 'UNICO', 'DMHL'])) {
            $radiology_data = db::select(db::raw("SELECT invoice_no_pk,
            radt_delivered_ind,
            rad_report_no_pk,
            radt_delivered_ind,
            delivery_pending_ind,
            patient_name,
            invoice_date,
            au_entry_at,
            item_name,
            delivered_by,
            report_delivered_time,
            delivery_pending_ind,
            received_by,
            report_rcb_keyed_time,
            radt_report_rcb_ind,
            radinvoicedtl_no_pk,
            due
       FROM radt_report_procees_vw $sql_cond"));
        } else {
            $radiology_data = DB::select(DB::raw(" select * from radt_report_procees_vw where admission_uid is null and invoice_date between to_char (sysdate - 7) and to_char (sysdate) and radt_report_rcb_ind = 1 AND cancel_ind IS NULL"));
        }


        $ind_flag = 2;
        $type = 2;
        return Template::loadView('admin.radiology.process.delivery_receive_list', [
            'pathology' => $pathology_data,
            'radiology' => $radiology_data,
            'ind_flag' => $ind_flag,
            'type' => $type
        ]);
    }

    //    Save Report Delivery Data
    //Save Pathology
    public function savePatDeliveryData(Request $request)
    {
        $tab_type = $request->type;
        $panding_tab_type = $request->Pendingtype;
        $invoice_no_fk = $request->is_paid_amount;

        $dt = new DateTime('now', new \DateTimeZone('Asia/Dhaka'));
        $date = $dt->format('Y-m-d H:i');

        DB::beginTransaction();
        try {

            if (trim($tab_type) == 'Receive') {
                for ($i = 0; $i < count($invoice_no_fk); $i++) {
                    $data = array();
                    $data['report_deli_pending_ind'] = 1;
                    $data['au_entry_by'] = Auth::id();
                    $data['report_rcb_keyed_by'] = Auth::id();
                    $data['au_entry_at'] = $date;
                    $data['report_rcb_keyed_time'] = $date;
                    $data['au_entry_session'] = 'session';
                    $getData = DB::table('labt_testreporting')->where('report_no_pk', $invoice_no_fk[$i])->update($data);
                }

                for ($j = 0; $j < count($invoice_no_fk); $j++) {
                    $data2 = array();
                    $data2['delivery_pending_ind'] = 1;
                    $data2['au_entry_by'] = Auth::id();
                    $data2['report_rcv_by'] = Auth::id();
                    $data2['au_entry_at'] = $date;
                    $data2['report_rcv_time'] = $date;
                    $data2['au_entry_session'] = 'session';
                    DB::table('radt_reporting')->where('rad_report_no_pk', $invoice_no_fk[$j])->update($data2);
                }
            }

            //        delivery pending
            if (trim($tab_type) == 'Pending') {
                for ($i = 0; $i < count($invoice_no_fk); $i++) {
                    $data = array();
                    $data['report_delivered_ind'] = 1;
                    $data['au_entry_by'] = Auth::id();
                    $data['report_delivered_keyed_by'] = Auth::id();
                    $data['REPORT_DELIVERED_TIME'] = $date;
                    $data['au_entry_session'] = 'session';
                    $getData = DB::table('labt_testreporting')->where('report_no_pk', $invoice_no_fk[$i])->update($data);
                }

                for ($j = 0; $j < count($invoice_no_fk); $j++) {
                    $data2 = array();
                    $data2['delivered_ind'] = 1;
                    $data2['au_entry_by'] = Auth::id();
                    $data2['delivered_keyed_by'] = Auth::id();
                    $data2['au_entry_at'] = $date;
                    $data2['delivered_time'] = $date;
                    $data2['au_entry_session'] = 'session';
                    DB::table('radt_reporting')->where('rad_report_no_pk', $invoice_no_fk[$j])->update($data2);
                }
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function reportDeliveryFromList(Request $request)
    {
        $report_id = $request->report_id;


        $dt = new DateTime('now', new \DateTimeZone('Asia/Dhaka'));
        $date = $dt->format('Y-m-d H:i');

        DB::beginTransaction();
        try {
            // dd( $report_id);
            $data = array();
            $data['report_delivered_ind'] = 1;
            $data['au_entry_by'] = Auth::id();
            $data['report_delivered_keyed_by'] = Auth::id();
            $data['REPORT_DELIVERED_TIME'] = $date;
            $data['au_entry_session'] = 'session';
            $getData = DB::table('labt_testreporting')->where('report_no_pk', $report_id)->update($data);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function reportDeliveryFromListRad(Request $request)
    {
        $invoice_no_fk = $request->is_paid_amount;

        $dt = new DateTime('now', new \DateTimeZone('Asia/Dhaka'));
        $date = $dt->format('Y-m-d H:i');

        DB::beginTransaction();
        try {
            // dd( $report_id);
            $data = array();
            $data['delivered_ind'] = 1;
            $data['au_entry_by'] = '1';
            $data['au_entry_at'] = date('Y-m-d');
            $data['au_entry_session'] = 'session';
            $getData = DB::table('radt_reporting')->where('rad_report_no_pk', $invoice_no_fk[$i])->update($data);

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    //Save Radiology
    public function saveRadDeliveryData(Request $request)
    {
        $tab_type = $request->type;
        $invoice_no_fk = $request->is_paid_amount;

        //        Receive
        if ($tab_type == 'Receive') {
            for ($i = 1; $i < count($invoice_no_fk); $i++) {
                $data = array();
                $data['delivery_pending_ind'] = 1;
                $data['au_entry_by'] = '1';
                $data['au_entry_at'] = date('Y-m-d');
                $data['au_entry_session'] = 'session';
                $getData = DB::table('radt_reporting')->where('rad_report_no_pk', $invoice_no_fk[$i])->update($data);
            }
        }
        //        Pending Delivery
        if ($tab_type == 'Pending') {
            for ($i = 0; $i < count($invoice_no_fk); $i++) {
                $data = array();
                $data['delivered_ind'] = 1;
                $data['au_entry_by'] = '1';
                $data['au_entry_at'] = date('Y-m-d');
                $data['au_entry_session'] = 'session';
                $getData = DB::table('radt_reporting')->where('rad_report_no_pk', $invoice_no_fk[$i])->update($data);
            }
        }
        DB::commit();
        if ($getData) {
            $message = ['msg' => 'Radiology Report Process Completed successfully.', 'title' => 'Success'];
        } else {
            $message = ['msg' => 'Radiology Report Process Failed', 'title' => 'Error'];
        }
        return response()->json($message);
    }
    public function labelPrint($invoice_no, Request $request)
    {

        $appointment = DB::table('radt_invoicedtl_app_wl_vw')
            ->leftJoin('patient_info_vw as pat', 'pat.PATIENT_NO_PK', '=', 'radt_invoicedtl_app_wl_vw.patient_no_fk')
            ->select('radt_invoicedtl_app_wl_vw.*', DB::raw('pat_age(pat.dob, NVL(pat.dod, SYSDATE)) AS pat_age'))
            ->where('radinvoicedtl_no_pk', $invoice_no)
            ->first();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();

        if (Session::get('user.ses_hospital_code') != "UNICO") {
            $pdf = PDF::loadView("admin.radiology.process.radiology_label_pdf", ['appointment' => $appointment, 'po_hospital_details' => $po_hospital_details]);

            // return $pdf->download('radiology-Label-card.pdf');
            return $pdf->stream("radiology-Label-card.pdf");
        } else {
            return view("admin.radiology_v2.result.radiology_label_pdf_v2", ['appointment' => $appointment, 'po_hospital_details' => $po_hospital_details]);
        }
        // return view("admin.radiology.process.radiology_label_pdf", ['appointment' => $appointment, 'po_hospital_details' => $po_hospital_details]);




    }
    public function labelPrintAll($report_id)
    {

        $report_id_exp = explode('_', $report_id);
        $report_id_arr = array_filter($report_id_exp);

        $appointment = [];
        for ($i = 0; $i < count($report_id_arr); $i++) {
            $appointment[] = DB::table('radt_report_procees_vw')
                ->where('radinvoicedtl_no_pk', $report_id_arr[$i])
                ->first();
        }


        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        // return response()->json([ $appointment, $po_hospital_details]);
        $pdf = PDF::loadView("admin.radiology.process.radiology_label_pdf", ['appointment' => $appointment, 'po_hospital_details' => $po_hospital_details]);

        return $pdf->download('radiology-Label-card.pdf');
    }


    public function labelPathologyPrint($invoice_no, Request $request)
    {
        $appointment = DB::table('labt_report_procees_vw')
            ->where('invoice_no_fk', $invoice_no)
            ->first();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pdf = PDF::loadView("admin.pathology.process.pathology_label_pdf", ['appointment' => $appointment, 'po_hospital_details' => $po_hospital_details]);


        return $pdf->download('radiology-Pathology-card.pdf');
    }
    public function labelPathologyPrintAll($report_id)
    {
        $report_id_exp = explode('_', $report_id);
        $report_id_arr = array_filter($report_id_exp);

        $appointment = [];
        for ($i = 0; $i < count($report_id_arr); $i++) {
            $appointment[] = DB::table('labt_report_procees_vw')
                ->where('invoice_no_fk', $report_id_arr[$i])
                ->first();
        }
        // dd($appointment);

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $pdf = PDF::loadView("admin.pathology.process.pathology_label_pdf", ['appointment' => $appointment, 'po_hospital_details' => $po_hospital_details]);

        return $pdf->download('radiology-Pathology-card.pdf');
    }

    public function printForm($id)
    {
        $print_id = $id;
        return Template::loadView('admin.radiology.process.printForm', ['print_id' => $print_id]);
    }
    public function skipVerify(Request $request)
    {
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();
        try {
            $report_data = [
                'verify_key_ind' => 1,
                'verify_keyed_time' => date("y-m-d"),
                'finalize_key_ind' => 1,
                'finalize_keyed_time' => date("y-m-d"),
                "verify_keyed_by" => $auth_id,
                "finalize_keyed_by" => $auth_id,
                'au_entry_hospital_pk_no' => $ses_hospital_id
            ];
            $invoice_data = [
                'result_final_key_ind' => 1,
                'result_final_keyed_by' => $auth_id,
                'result_final_keyed_time' => date("y-m-d"),
                'result_verify_key_ind' => 1,
                'result_verify_keyed_by' => $auth_id,
                'result_verify_keyed_time' => date("y-m-d"),
                'au_entry_hospital_no_fk' => $ses_hospital_id
            ];
            DB::table('radt_invoicedtl')->where('radinvoicedtl_no_pk', $request->hid_value)->update($report_data);
            DB::table('radt_reporting')->where('rad_report_no_pk', $request->hid_value)->update($invoice_data);
            DB::commit();
            $message = ['msg' => 'Data saved successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // dd($data);
        return response()->json($message);
    }
    public function patientBillInfoJson(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_code');

        // $account_info = DB::table('finc_voucherwise_vw')
        //     ->where('invoice_code', $request->invoice_code)
        //     ->first();

        if ($request->type != 1) {



            if ($ses_hospital_id == 'EWMCH' || $ses_hospital_id == 'IMPERIAL') {
                $pathology_data = DB::select(DB::raw("SELECT report_no_fk,
                                        report_delivered_ind,
                                        invoice_no_pk,
                                        invoice_date,
                                        patient_name,
                                        sc_sample_coll_keyed_time,
                                        item_name,
                                        report_delivered_ind,
                                        delivered_by,
                                        delivered_by,
                                        report_delivered_time,
                                        report_deli_pending_ind,
                                        received_by,
                                        report_rcb_keyed_time,
                                        report_rcb_ind
                                FROM pat_report_del_vw where invoice_no_pk = $request->invoice_code"));
            } else {
                $pathology_data = DB::select(DB::raw("select *
                                                  from labt_report_procees_vw
                                                 where invoice_date between to_char (sysdate - 7) and to_char (sysdate)
                                                       and report_rcb_ind = 1
                                                    and cancel_ind is null"));
            }


            if ($ses_hospital_id == 'EWMCH' || $ses_hospital_id == 'IMPERIAL') {
                $radiology_data = db::select(db::raw("SELECT invoice_no_pk,
                radt_delivered_ind,
                rad_report_no_pk,
                radt_delivered_ind,
                delivery_pending_ind,
                patient_name,
                invoice_date,
                au_entry_at,
                item_name,
                delivered_by,
                report_delivered_time,
                delivery_pending_ind,
                received_by,
                report_rcb_keyed_time,
                radt_report_rcb_ind,
                radinvoicedtl_no_pk
           FROM radt_report_procees_vw where invoice_no_pk = $request->invoice_code"));
            } else {
                $radiology_data = DB::select(DB::raw(" select * from radt_report_procees_vw where invoice_date between to_char (sysdate - 7) and to_char (sysdate) and radt_report_rcb_ind = 1 AND cancel_ind IS NULL"));
            }
        }
        $account_info = DB::table('finc_voucherwise_vw')
            ->select('patient_name', 'patient_code', 'age', 'gender_txt', 'mobile1', DB::raw('sum(sales) as sales'), DB::raw('sum(discount) as discount'), DB::raw('sum(collection) as collection'))
            ->where('invoice_code', $request->invoice_code)
            ->groupBy('patient_name', 'age', 'gender_txt', 'mobile1', 'patient_code')
            ->get();
        // dd( $account_info);
        if (!empty($account_info)) {
            // $account_info = array(
            //     'patient_name' => $account_info->patient_name,
            //     'age' => $account_info->age,
            //     'gender' => $account_info->gender_txt,
            //     'mobile1' => $account_info->mobile1,
            //     'amount' => $account_info->sales,
            //     'paid' => $account_info->net_sales,
            //     'discount' => $account_info->discount,
            //     'payable' => $account_info->net_sales,
            //     'due' => $account_info->due,
            //     'pathology'     =>  $pathology_data,
            //     'radiology'     =>  $radiology_data,

            // );
            if ($request->type != 1) {
                $account_info = array(
                    'patient_name' => $account_info[0]->patient_name,
                    'patient_code' => $account_info[0]->patient_code,
                    'age' => $account_info[0]->age,
                    'gender' => $account_info[0]->gender_txt,
                    'mobile1' => $account_info[0]->mobile1,
                    'amount' => $account_info[0]->sales,
                    'paid' => $account_info[0]->collection,
                    'discount' => $account_info[0]->discount,
                    'payable' => $account_info[0]->sales - $account_info[0]->discount,
                    'due' => ($account_info[0]->sales - $account_info[0]->discount) - $account_info[0]->collection,
                    'pathology' => $pathology_data,
                    'radiology' => $radiology_data,

                );
            } else {
                $account_info = array(
                    'patient_name' => $account_info[0]->patient_name,
                    'patient_code' => $account_info[0]->patient_code,
                    'age' => $account_info[0]->age,
                    'gender' => $account_info[0]->gender_txt,
                    'mobile1' => $account_info[0]->mobile1,
                    'amount' => $account_info[0]->sales,
                    'paid' => $account_info[0]->collection,
                    'discount' => $account_info[0]->discount,
                    'payable' => $account_info[0]->sales - $account_info[0]->discount,
                    'due' => ($account_info[0]->sales - $account_info[0]->discount) - $account_info[0]->collection,
                    // 'pathology'     =>  $pathology_data,
                    // 'radiology'     =>  $radiology_data,

                );
            }

            //    dd( $account_info);

            return $account_info;
        }
    }



    public function ipdPatientReportDelivery()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $todate = date('Y-m-d');
        if (Session::get('user.ses_hospital_code') == "IMPERIAL") {
            $pathology_data = DB::select(DB::raw("select pat_report_del_ipd_vw.*, 0 as due from pat_report_del_ipd_vw
            where report_rcb_ind = 1 and invoice_date between '$todate' and to_char (sysdate + 1) order by invoice_date desc"));

            $radiology_data = db::select(db::raw("select RADT_REPORT_PROCEES_IPD_VW.*, 0 as due from RADT_REPORT_PROCEES_IPD_VW where report_rcb_ind = 1 and invoice_date between '$todate' and to_char (sysdate + 1)"));
        } else {
            $pathology_data = []; // DB::select(DB::raw("select pat_report_del_ipd_vw.*, 0 as due from pat_report_del_ipd_vw where report_rcb_ind = 1 and invoice_date between to_char (sysdate - 7) and to_char (sysdate + 1) order by invoice_date desc"));

            $radiology_data = []; // db::select(db::raw("select RADT_REPORT_PROCEES_IPD_VW.*, 0 as due from RADT_REPORT_PROCEES_IPD_VW where report_rcb_ind = 1 and invoice_date between to_char (sysdate - 7) and to_char (sysdate + 1)"));
        }

        $ind_flag = 2;
        $type = 2;

        return Template::loadView('admin.radiology.report_delivery.ipd_patient_report_delivery', [
            'pathology' => $pathology_data,
            'radiology' => $radiology_data,
            'ind_flag' => $ind_flag,
            'type' => $type
        ]);
    }

    public function ipdPatientreceiveDataSearch(Request $request)
    {
        // dd($request->all());
        $ses_hospital_id = Session::get('user.ses_hospital_code');

        if (!empty($request->search_date_from) && !empty($request->search_date_to)) {

            $date_from = $request->search_date_from != "" ? date('Y-m-d', strtotime($request->search_date_from)) : ''; //"$request->search_date_from";
            $date_to = $request->search_date_to != "" ? date('Y-m-d', strtotime($request->search_date_to)) : ''; // "$request->search_date_to";

        } else {
            $date_from = "";
            $date_to = "";
        }
        // dd($date_from  ,$date_to);
        $invoice_id = $request->invoice_id;
        $patient_id = $request->patient_id;
        $admission_no = $request->hdn_admission_id;
        $dept = $request->dept;
        $tab_type = $request->type;
        //  $patient_status = $request->patient_status;

        $sql_cond = "";
        $clause = ($sql_cond == "") ? " where" : " and";
        $sql_cond .= ($date_from != "") ? " $clause trunc(invoice_date) between TO_DATE('$date_from','YYYY-MM-DD') and TO_DATE('$date_from','YYYY-MM-DD')" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($invoice_id != "") ? " $clause invoice_no_pk = $invoice_id" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($patient_id != "") ? " $clause lab.patient_name = '$patient_id'" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($admission_no != "") ? " $clause ADMISSION_UID = '$admission_no'" : "";

        $clause = ($sql_cond == "") ? " where" : "and";
        $sql_cond .= ($dept != "") ? " $clause service_unit_no_fk = $dept" : "";
        if (in_array($ses_hospital_id, ['EWMCH', 'IMPERIAL', 'UNICO', 'DMHL'])) {
            $pathology_data = DB::select(DB::raw("SELECT report_no_fk,
                                    report_delivered_ind,
                                    invoice_no_pk,
                                    invoice_date,
                                    patient_name,
                                    sc_sample_coll_keyed_time,
                                    item_name,
                                    report_delivered_ind,
                                    delivered_by,
                                    delivered_by,
                                    report_delivered_time,
                                    report_deli_pending_ind,
                                    received_by,
                                    report_rcb_keyed_time,
                                    report_rcb_ind,
                                    0 as due
                            FROM PAT_REPORT_DEL_IPD_VW $sql_cond"));
        } else {
            $pathology_data = DB::select(DB::raw("select labt_report_procees_vw.*, 0 as due
                                              from labt_report_procees_vw
                                             where invoice_date between to_char (sysdate - 7) and to_char (sysdate)
                                                   and report_rcb_ind = 1
                                                and cancel_ind is null"));
        }

        //  dd($pathology_data);
        // echo "select * from PAT_REPORT_DEL_IPD_VW $sql_cond";
        if (in_array($ses_hospital_id, ['EWMCH', 'IMPERIAL', 'UNICO', 'DMHL'])) {
            $radiology_data = db::select(db::raw("SELECT invoice_no_pk,
            radt_delivered_ind,
            rad_report_no_pk,
            radt_delivered_ind,
            delivery_pending_ind,
            patient_name,
            invoice_date,
            au_entry_at,
            item_name,
            delivered_by,
            report_delivered_time,
            delivery_pending_ind,
            received_by,
            report_rcb_keyed_time,
            radt_report_rcb_ind,
            radinvoicedtl_no_pk,
            0 as due
            FROM RADT_REPORT_PROCEES_IPD_VW $sql_cond"));
        } else {
            $radiology_data = DB::select(DB::raw(" select RADT_REPORT_PROCEES_IPD_VW.*, 0 as due from RADT_REPORT_PROCEES_IPD_VW where invoice_date between to_char (sysdate - 7) and to_char (sysdate) and radt_report_rcb_ind = 1 AND cancel_ind IS NULL"));
        }


        $ind_flag = 2;
        $type = 2;
        return Template::loadView('admin.radiology.process.delivery_receive_list', [
            'pathology' => $pathology_data,
            'radiology' => $radiology_data,
            'ind_flag' => $ind_flag,
            'type' => $type
        ]);
    }

    public function radiologyUserWiseRoom()
    {
        $user_name = DB::table("wsec_user")->select('user_no_pk', 'person_no_fk', 'user_fullname', 'email')->where('status', '1')->get();
        $department_name = DB::table('sysc_serviceunit')->where('radiology_ind', '1')->where('status', '1')->get();
        $room_no = DB::select("SELECT ROOM_NO_PK, ROOM_CODE, ROOM_NAME
                    FROM    sysc_room room
                        JOIN
                            sysc_serviceunit unit
                        ON ROOM.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                    WHERE UNIT.RADIOLOGY_IND = 1 and unit.status = 1");
        // dd($room_no);
        return Template::loadview("admin.radiology.userwiseroom.user_wise_room", ["user_name" => $user_name, "department_name" => $department_name, "room_no" => $room_no]);
    }
    public function radiologyUserWiseRoomScheduleForm()
    {
        $user_name = DB::table("wsec_user")->select('user_no_pk', 'person_no_fk', 'user_fullname', 'email')->where('status', '1')->get();
        $department_name = DB::table('sysc_serviceunit')->where('radiology_ind', '1')->where('status', '1')->get();
        $room_no = DB::select("SELECT ROOM_NO_PK, ROOM_CODE, ROOM_NAME
                    FROM    sysc_room room
                        JOIN
                            sysc_serviceunit unit
                        ON ROOM.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                    WHERE UNIT.RADIOLOGY_IND = 1 and unit.status = 1");
        // dd($room_no);
        return Template::loadview("admin.radiology.userwiseroom.user_wise_room_form", ["user_name" => $user_name, "department_name" => $department_name, "room_no" => $room_no]);
    }

    public function radiologyUserWiseRoomScheduleEdit($id)
    {
        // dd($id);
        // $schedule_dt = $this->model3->show($id);

        $schedule_dt = DB::table('radt_room_shedulesetup_uhl')->where('room_shedsetup_no_pk', $id)->first();
        $department_name = DB::table('sysc_serviceunit')->where('radiology_ind', '1')->where('status', '1')->get();
        $room_no = DB::select("SELECT ROOM_NO_PK, ROOM_CODE, ROOM_NAME
                    FROM    sysc_room room
                        JOIN
                            sysc_serviceunit unit
                        ON ROOM.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                    WHERE UNIT.RADIOLOGY_IND = 1 and unit.status = 1");
        $items = DB::table('sysc_serviceitem')
            ->where('item_type', 'RAD')
            ->where('STATUS', 1)
            ->get();
        return Template::loadview("admin.radiology_v2.setup.item_wise_room_form", ["items" => $items, 'schedule_dt' => $schedule_dt, "department_name" => $department_name, "room_no" => $room_no]);
    }

    public function storeRadiologyUserWiseRoomList(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $id = $request->id;
        $auth_id = Auth::id();
        DB::beginTransaction();
        try {
            $data = [
                'person_no_fk' => $request->user_no_fk,
                'su_no_fk' => $request->su_no_fk,
                'room_no_fk' => $request->room_no_fk,
                'start_time' => date("H:i", strtotime($request->start_time)),
                'end_time' => date("H:i", strtotime($request->end_time)),
                'avg_time' => $request->avg_time,
                'status' => 1,
                'au_entry_hospital_no_fk' => $ses_hospital_id,
            ];
            if ($id == "") {
                $data['au_entry_by'] = $auth_id;
                $this->model3->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $this->model3->update($data, $id);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        // dd($data);
        return response()->json($message);
    }

    public function radiologyValueSearch(Request $request)
    {
        // Get the search query parameter from the request
        $query = $request->input('query', '');

        // Trim the query if it starts with [[ and ends with ]]
        if (str_starts_with($query, '[[')) {
            // Remove the [[ and ]] from the query
            $query = trim($query, '[[');
        }

        // Retrieve data from the database with partial matching
        $data = DB::table('radt_tempplate_text_autocomplete')
            ->select('temp_text_ac_no_pk as id', 'text_name as name', 'text_content_clob as text_content', 'text_content_clob as report_value')
            ->where('text_name', 'like', $query . '%') // Use 'like' for partial matching
            ->get();
        // dd($data);

        // Map the result to include 'fullName' if needed
        $dataArray = $data->map(function ($item) {
            return [
                'id' => $item->id,
                'title' => $item->name, // Adjust field name if necessary
                'text_content' => $item->text_content, // Adjust field name if necessary
                'description' => $item->report_value // Assuming 'report_value' is the display name
            ];
        })->toArray();

        // Return the data as JSON
        return response()->json($dataArray);
    }

    public function radiologyUserWiseRoomSchedule()
    {
        return Template::loadview("admin.radiology.userwiseroom.user_wise_schedule_list");
    }

    public function radiologyEditorAutocomplete()
    {
        return Template::loadview("admin.radiology.radiology_editor_autocomplete");
    }
    public function radiologyEditorAutocompleteForm()
    {
        return Template::loadview("admin.radiology.radiology_editor_autocomplete_form");
    }

    public function radiologyUserWiseRoomScheduleList(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        // $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'radt_room_shedulesetup_vw';
        // Table's primary key
        $primaryKey = 'room_shedsetup_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'user_fullname', 'dt' => 1),
            array('db' => 'serviceunit_name', 'dt' => 2),
            array('db' => 'room_name', 'dt' => 3),
            array('db' => 'start_time', 'dt' => 4),
            array('db' => 'end_time', 'dt' => 5),
            array('db' => 'avg_time', 'dt' => 6),
            array('db' => 'status', 'dt' => 7),
            array('db' => 'room_shedsetup_no_pk', 'dt' => 8),
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }
    public function RadiologyAllAutocomplete(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'radt_tempplate_text_autocomplete';
        // Table's primary key
        $primaryKey = 'temp_text_ac_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'text_name', 'dt' => 1),
            array('db' => 'text_content_clob', 'dt' => 2),
            array('db' => 'status', 'dt' => 3),
            array('db' => 'temp_text_ac_no_pk', 'dt' => 4),
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }

        //         $columns = array(
        //             'sl',
        //             'rownum',
        //             'text_name',
        //             'text_content_clob',
        //             'status',
        //             'temp_text_ac_no_pk',
        //         );

        //         $yes = '<span class="badge badge-md badge-success "> Yes</span>';
        //         $no = '<span class="badge badge-md badge-secondary"> No</span>';
        //         $sql = "SELECT '' AS sl,
        //        ROWNUM,
        //        text_name,
        //        text_content_clob,
        //        CASE WHEN status = 1 THEN '$yes' ELSE '$no' END AS status,
        //        temp_text_ac_no_pk
        //   FROM RADT_TEMPPLATE_TEXT_AUTOCOMPLETE";


        //         $order_by_column = "temp_text_ac_no_pk";


        //         $json_data = $this->datatable($request, $sql, $order_by_column, 'DESC', $columns);
        //         echo json_encode($json_data);
    }

    public function storeRadiologyAutocomplete(Request $request)
    {
        //   return $request;
        $id = $request->id;
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');

        $auth_id = Auth::id();

        DB::beginTransaction();
        try {

            $data = [
                'temp_text_ac_code' => $request->tem_name,
                'text_name' => $request->tem_name,
                'text_content_clob' => $request->editor_content,
                // 'text_content' => $request->template_description,
                'status' => 1,
                'au_entry_session' => 'session',
                'au_entry_hospital_pk_no' => $ses_hospital_id,
            ];
            if ($id == null) {
                // AU_ENTRY_BY
                $data['au_entry_by'] = $auth_id;
                // return $data;
                $this->model4->create($data);
            } else {
                // AU_UPDATE_BY
                $data['au_update_by'] = $auth_id;
                $data['au_entry_by'] = $auth_id;
                // $this->model4->update($data, $id);
                DB::table('radt_tempplate_text_autocomplete')->where('temp_text_ac_no_pk', $id)->update($data);
            }


            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }
    public function editRadiologyAutocomplete($id)
    {
        $autocompleteDt = $this->model4->show($id);
        return Template::loadview("admin.radiology.radiology_editor_autocomplete_form", ["autocompleteDt" => $autocompleteDt]);
    }







    // ***********************RADIOLOGY V2 STARTED FROM HERE **********************************

    public function radiologyCreateAppointmentv2()
    {

        $doctors = Doctor::select('person_no_pk', 'full_name')->where("status", 1)->where("doctor_ind", 1)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->get();
        $priority = $this->getLookupListByCode("PRIORITY");
        $specialist = $this->getLookupListByCode("DOCSPL");
        // $app = DB::table('radt_invoicedtl_app_wl_vw')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();
        $app = [];
        // $rooms = DB::table("sys_user_room_privs_vw")
        //     ->where('user_no_fk', Auth::user()->user_no_pk)
        //     ->get();
        return Template::loadview("admin.radiology_v2.appointment.create_appointment_v2", [
            'doctors' => $doctors,
            'specialist' => $specialist,
            "priority" => $priority,
            "app" => $app
        ]);
    }

    public function generateIntervalsV2(Request $request)
    {
        // Fetch the latest room selection
        $today = date("Y/m/d");
        $roomSelection = DB::table('RADT_ROOM_SHEDULESETUP_UHL')
            ->select('room_no_fk')
            ->where('su_no_fk', $request->dept_id)
            ->orderByDesc('au_entry_at')
            ->first();
        // dd($roomSelection);

        if (!$roomSelection) {
            return response()->json(['error' => 'No room found for the given department'], 404);
        }

        $roomNoFk = (int) $roomSelection->room_no_fk;
        // Fetch the schedule based on the room and item
        $schedule = DB::table('RADT_ROOM_SHEDULESETUP_UHL')
            ->select('start_time', 'end_time', 'avg_time', 'duration_time', 'item_no_fk')
            ->where('room_no_fk', $roomNoFk)
            // ->where('item_no_fk', $request->item_id)
            ->first();
        //    dd($schedule);

        if (!$schedule) {
            return response()->json(['error' => 'No schedule found for the given item'], 404);
        }

        $lsdata = db::table('radt_invoicedtl')
            ->select('img_app_sl_no', 'img_app_dttm')
            ->leftjoin('finc_invoicemst', 'invoice_no_pk', '=', 'invoice_no_fk')
            // ->where('img_app_dttm', $today)
            ->whereRaw(DB::raw("trunc(INVOICE_DATE) ='$today'"))
            ->where('room_no_fk', $roomNoFk)
            ->orderbydesc('invoice_no_fk')
            ->first();

        // Check if $lsdata is null and set default values if it is
        if (!$lsdata) {
            $img_app_sl_no = 0;
            $img_app_dttm = 'n/a';
        } else {
            $img_app_sl_no = $lsdata->img_app_sl_no;
            $img_app_dttm = $lsdata->img_app_dttm;
        }
        // $scheduleData = [
        //     'start_time' => $schedule->start_time,
        //     'end_time' => $schedule->end_time,
        //     'avg_time' => $schedule->avg_time,
        //     'duration_time' => $schedule->duration_time, // Corrected key
        //     'item_no_fk' => $schedule->item_no_fk,
        // ];

        // Pass data to view
        return Template::loadView('admin.radiology_v2.appointment.radiology_schedule_v2', [
            'start_time' => $request->query('start_time'),
            'end_time' => $request->query('end_time'),
            'schedule' => $schedule,
            'img_app_sl_no' => $img_app_sl_no,
            'img_app_dttm' => $img_app_dttm,
            // 'scheduleData' => $scheduleData
            // Add other necessary data if needed
        ]);
    }

    public function radiologySearchPatientInvestigationV2(Request $request)
    {

        $invoice_id = $request->invoice_id;
        $hospital_id = Session::get('user.ses_hospital_code');

        $test_info = DB::table("radt_invoicedtl_app_wl_vw a")
            ->select('item.item_no_pk', 'a.item_name', 'a.invoice_date', 'a.img_app_dttm', 'a.room_name', 'a.serviceunit_no_fk', 'a.radinvoicedtl_no_pk', 'a.invoice_no_pk')
            ->leftJoin("PAT_REGISTRATION_WL_VW b", "a.PATIENT_NO_FK", "=", "b.PATIENT_NO_PK")
            ->join('sysc_serviceitem item', 'a.item_code', 'item.item_code')
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("invoice_no_pk", $invoice_id)
            ->whereNull('cancel_ind')
            ->get();

        return Template::loadview("admin.radiology_v2.appointment.radiology_search_data_v2", ["test_info" => $test_info]);
    }

    public function dateWiseGenerateIntervalsV2(Request $request)
    {
        // Fetch the latest room selection
        $roomSelection = DB::table('RADT_ROOM_SHEDULESETUP_UHL')
            ->select('room_no_fk')
            ->where('su_no_fk', $request->dept_id)
            ->orderByDesc('au_entry_at')
            ->first();
        // dd($roomSelection);

        if (!$roomSelection) {
            return response()->json(['error' => 'No room found for the given department'], 404);
        }

        $roomNoFk = $roomSelection->room_no_fk;

        // Fetch the schedule based on the room and item
        $schedule = DB::table('RADT_ROOM_SHEDULESETUP_UHL')
            ->select('start_time', 'end_time', 'avg_time', 'duration_time', 'item_no_fk')
            ->where('room_no_fk', $roomNoFk)
            ->where('item_no_fk', $request->item_id)
            ->first();
        // dd($schedule);

        if (!$schedule) {
            return response()->json(['error' => 'No schedule found for the given item'], 404);
        }

        // $scheduleData = [
        //     'start_time' => $schedule->start_time,
        //     'end_time' => $schedule->end_time,
        //     'avg_time' => $schedule->avg_time,
        //     'duration_time' => $schedule->duration_time, // Corrected key
        //     'item_no_fk' => $schedule->item_no_fk,
        // ];

        $lsdata = db::table('radt_invoicedtl')
            ->select('img_app_sl_no', 'img_app_dttm')
            ->orderbydesc('invoice_no_fk')
            ->first();

        // Check if $lsdata is null and set default values if it is
        if (!$lsdata) {
            $img_app_sl_no = 0;
            $img_app_dttm = 'n/a';
        } else {
            $img_app_sl_no = $lsdata->img_app_sl_no;
            $img_app_dttm = $lsdata->img_app_dttm;
        }
        // Pass data to view
        return Template::loadView('admin.radiology_v2.appointment.radiology_schedule_v2', [
            'start_time' => $request->query('start_time'),
            'end_time' => $request->query('end_time'),
            'schedule' => $schedule,
            'img_app_sl_no' => $img_app_sl_no,
            'img_app_dttm' => $img_app_dttm,
            // 'scheduleData' => $scheduleData
            // Add other necessary data if needed
        ]);
    }

    public function get_appointment_card_print_v2($radinvoicedtl_no_pk)
    {
        $invoice_data = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->leftjoin('radt_pat_shedule radt', 'a.radinvoicedtl_no_pk', 'radt.radinvoicedtl_no_fk')
            ->select(
                // "a.appoint_code",
                "b.patient_name",
                "a.patient_no_fk",
                "a.invoicedtl_no_fk",
                "a.invoice_code",
                "a.invoice_date",
                "a.room_name",
                "a.item_name",
                "a.img_app_sl_no",
                "a.img_app_dttm",
                "a.radinvoicedtl_no_pk",
                "b.patient_code",
                "a.serviceunit_name",
                "a.accession_id",
                "b.present_addr",
                'b.gender_txt',
                'b.service_number',
                'radt.shed_str_time',
                'b.age'
            )
            ->where("a.radinvoicedtl_no_pk", $radinvoicedtl_no_pk)
            ->first();

        $schedule_id = DB::table('RADT_PAT_SHEDULE')
            ->select('pat_shedule_no_pk')
            ->where('invoice_no_fk', $invoice_data->invoice_code)
            ->first()->pat_shedule_no_pk;

        $appointment = db::table('radt_pat_shedule as rps')
            ->select(
                'rps.pat_shedule_no_pk',
                'rps.appoint_date',
                'rps.shed_str_time',
                'rps.shed_end_time',
                'piv.patient_name',
                'rps.patient_no_fk',
                'piv.patient_code',
                'rps.radt_app_sl',
                'sr.room_name',
                'ssi.item_name',
                'rrsu.pre_requisition'
            )
            ->leftjoin('patient_info_vw as piv', 'piv.patient_no_pk', '=', 'rps.patient_no_fk')
            ->leftjoin('sysc_room as sr', 'sr.room_no_pk', '=', 'rps.room_no_fk')
            ->leftjoin('sysc_serviceitem as ssi', 'ssi.item_no_pk', '=', 'rps.item_no_fk')
            ->join('radt_room_shedulesetup_uhl as rrsu', 'rrsu.item_no_fk', '=', 'rps.item_no_fk')
            ->where('rps.pat_shedule_no_pk', $schedule_id)
            ->first();

        $app_barcode = '';
        $barcode = new BarcodeGenerator();
        $barcode->setText($invoice_data->invoice_code);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $app_barcode = $barcode->generate();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        // dd($appointment);
        return View("admin.radiology_v2.appointment.appointment_card_print_v2", ['app_barcode' => $app_barcode, 'appointment' => $appointment, 'po_hospital_details' => $po_hospital_details, 'invoice_data' => $invoice_data]);

        // return $pdf->stream('radiology-appointment-card.pdf');
    }
    public function get_appointment_card_print_notbill($secheduleId)
    {
        // $appointment = DB::table("radt_invoicedtl_app_wl_vw a")
        //     ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
        //     ->leftjoin('radt_pat_shedule radt', 'a.radinvoicedtl_no_pk', 'radt.radinvoicedtl_no_fk')
        //     ->select(
        //         // "a.appoint_code",
        //         "b.patient_name",
        //         "a.patient_no_fk",
        //         "a.invoicedtl_no_fk",
        //         "a.invoice_code",
        //         "a.invoice_date",
        //         "a.room_name",
        //         "a.item_name",
        //         "a.img_app_sl_no",
        //         "a.img_app_dttm",
        //         "a.radinvoicedtl_no_pk",
        //         "b.patient_code",
        //         "a.serviceunit_name",
        //         "a.accession_id",
        //         "b.present_addr",
        //         'b.gender_txt',
        //         'b.service_number',
        //         'radt.shed_str_time',
        //         'b.age'
        //     )
        //     ->where("a.radinvoicedtl_no_pk", $radinvoicedtl_no_pk)
        //     ->first();
        //  dd($appointment);

        $appointment = db::table('radt_pat_shedule as rps')
            ->select(
                'rps.pat_shedule_no_pk',
                'rps.appoint_date',
                'rps.shed_str_time',
                'rps.shed_end_time',
                'piv.patient_name',
                'rps.patient_no_fk',
                'piv.patient_code',
                'rps.radt_app_sl',
                'sr.room_name',
                'ssi.item_name',
                'rrsu.pre_requisition'
            )
            ->leftjoin('patient_info_vw as piv', 'piv.patient_no_pk', '=', 'rps.patient_no_fk')
            ->leftjoin('sysc_room as sr', 'sr.room_no_pk', '=', 'rps.room_no_fk')
            ->leftjoin('sysc_serviceitem as ssi', 'ssi.item_no_pk', '=', 'rps.item_no_fk')
            ->join('radt_room_shedulesetup_uhl as rrsu', 'rrsu.item_no_fk', '=', 'rps.item_no_fk')
            ->where('rps.pat_shedule_no_pk', $secheduleId)
            ->first();

        $app_barcode = '';
        $barcode = new BarcodeGenerator();
        $barcode->setText($secheduleId);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $app_barcode = $barcode->generate();

        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();


        // dd($appointment);
        return View("admin.radiology_v2.appointment.appointment_card_print_uhl_a5", ['app_barcode' => $app_barcode, 'po_hospital_details' => $po_hospital_details, 'appointment' => $appointment]);

        // return $pdf->stream('radiology-appointment-card.pdf');
    }

    public function radiologyImageCaptureV2(Request $request)
    {

        $serviceunit = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            ->where('serviceunit_code', $request->route('type'))
            ->first();
        $menutype = $serviceunit->serviceunit_name;
        $type = $serviceunit->serviceunit_no_pk;
        $today = date("d-m-Y", strtotime("+1 days"));
        $sevenDaysAgo = date("d-m-Y", strtotime("-7 days"));

        $radiologyAppointment = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->select(
                "a.admission_no_pk",
                "a.invoice_date",
                "a.radinvoicedtl_no_pk",
                "a.item_name",
                "a.prescription_no_fk",
                "a.patient_no_fk",
                "b.gender_txt",
                "b.patient_name",
                "b.patient_photo",
                "b.patient_code",
                "a.serviceunit_name",
                "a.room_name",
                "a.img_app_sl_no",
                "a.img_app_dttm",
                "a.img_app_sl_no",
                'a.ic_image_capture_key_ind',
                'a.invoice_code',
                'a.ic_image_capture_keyed_by',
                'a.ic_image_capture_keyed_time',
                'a.delivery_dttm',
                'a.bed_name',
            )
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('a.serviceunit_no_fk', $serviceunit->serviceunit_no_pk)
            ->whereRaw(
                "a.invoice_date BETWEEN to_date(?, 'DD-MM-YYYY') AND to_date(?, 'DD-MM-YYYY')",
                [$sevenDaysAgo, $today]
            )
            ->orderBy('a.radinvoicedtl_no_pk', "DESC")
            ->get();
        // $radiologyAppointment = [];

        $image_capture = DB::table("radt_reporting_img")->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))->select("radinvoicedtl_no_pk")->get();

        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $department = DB::table("sysc_serviceunit_vw a")
            // ->join("sysc_grant_su b", "a.serviceunit_no_pk", "b.su_no_fk")
            ->select("a.serviceunit_name", "a.serviceunit_no_pk")
            ->where([
                ["a.radiology_ind", "=", 1],
                ["a.status", "=", 1],
                ["a.au_entry_hospital_pk_no", "=", $hospital_id]
            ])->get();

        $rooms = Room::select('room_no_pk', 'room_name')->where("au_entry_hospital_no_fk", $hospital_id)->get();

        return Template::loadview("admin.radiology_v2.image_capture.image_capture_v2", ["radiologyAppointment" => $radiologyAppointment, "department" => $department, "rooms" => $rooms, 'image_capture' => $image_capture, 'type' => $type, 'menutype' => $menutype]);
    }
    public function radiologyImageCaptureCollected(Request $request)
    {

        $type = $request->type;
        $today = date("d-m-Y");
        $radiologyAppointment = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->select("a.invoice_date", "a.radinvoicedtl_no_pk", "a.item_name", "a.prescription_no_fk", "a.patient_no_fk", "b.patient_name", "a.serviceunit_name", "a.room_name", "a.img_app_sl_no", "a.img_app_dttm", "a.img_app_sl_no", 'a.ic_image_capture_key_ind', 'a.invoice_code', 'a.ic_image_capture_keyed_by', 'a.ic_image_capture_keyed_time', 'a.delivery_dttm')
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('ic_image_capture_key_ind', 1)
            ->where('a.serviceunit_no_fk', $type)
            ->whereNull('a.admission_no_pk')
            // ->whereRaw("a.img_app_dttm = to_date('$today','DD-MM-YYYY')")
            ->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();

        return Template::loadview("admin.radiology_v2.image_capture.image_capture_table_collected", ["radiologyAppointment" => $radiologyAppointment]);
    }
    public function radiologyImageCapturePending(Request $request)
    {
        $type = $request->type;
        $today = date("d-m-Y");
        $radiologyAppointment = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->select("a.invoice_date", "a.radinvoicedtl_no_pk", "a.item_name", "a.prescription_no_fk", "a.patient_no_fk", "b.patient_name", "a.serviceunit_name", "a.room_name", "a.img_app_sl_no", "a.img_app_dttm", "a.img_app_sl_no", 'a.ic_image_capture_key_ind', 'a.invoice_code', 'a.ic_image_capture_keyed_by', 'a.ic_image_capture_keyed_time', 'a.delivery_dttm')
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereNull('ic_image_capture_key_ind')
            ->where('a.serviceunit_no_fk', $type)
            ->whereNull('a.admission_no_pk')
            // ->whereRaw("a.img_app_dttm = to_date('$today','DD-MM-YYYY')")
            ->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();

        return Template::loadview("admin.radiology_v2.image_capture.image_capture_table_pending", ["radiologyAppointment" => $radiologyAppointment]);
    }
    public function radiologyImageCaptureIpdPending(Request $request)
    {

        $type = $request->type;
        $today = date("d-m-Y");
        $radiologyAppointment = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->select("a.invoice_date", "a.admission_no_pk", "a.radinvoicedtl_no_pk", "a.item_name", "a.prescription_no_fk", "a.patient_no_fk", "b.patient_name", "a.serviceunit_name", "a.room_name", "a.img_app_sl_no", "a.img_app_dttm", "a.img_app_sl_no", 'a.ic_image_capture_key_ind', 'a.invoice_code', 'a.ic_image_capture_keyed_by', 'a.ic_image_capture_keyed_time', 'a.delivery_dttm')
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereNull('ic_image_capture_key_ind')
            ->where('a.item_type', $type)
            ->whereNotNull('a.admission_no_pk')
            // ->whereRaw("a.img_app_dttm = to_date('$today','DD-MM-YYYY')")
            ->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();

        return Template::loadview("admin.radiology_v2.image_capture.image_capture_table_ipd_pending", ["radiologyAppointment" => $radiologyAppointment]);
    }
    public function radiologyImageCaptureIpdCollected(Request $request)
    {

        $type = $request->type;
        $today = date("d-m-Y");
        $radiologyAppointment = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->select("a.invoice_date", "a.admission_no_pk", "a.radinvoicedtl_no_pk", "a.item_name", "a.prescription_no_fk", "a.patient_no_fk", "b.patient_name", "a.serviceunit_name", "a.room_name", "a.img_app_sl_no", "a.img_app_dttm", "a.img_app_sl_no", 'a.ic_image_capture_key_ind', 'a.invoice_code', 'a.ic_image_capture_keyed_by', 'a.ic_image_capture_keyed_time', 'a.delivery_dttm')
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('ic_image_capture_key_ind', 1)
            ->where('a.item_type', $type)
            ->whereNotNull('a.admission_no_pk')
            // ->whereRaw("a.img_app_dttm = to_date('$today','DD-MM-YYYY')")
            ->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();

        return Template::loadview("admin.radiology_v2.image_capture.image_capture_table_ipd_collected", ["radiologyAppointment" => $radiologyAppointment]);
    }

    public function radiologyImageCaptureCollection(Request $request)
    {
        $type = $request->type;
        $today = date("d-m-Y");
        $radiologyAppointment = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->select("a.invoice_date", "a.radinvoicedtl_no_pk", "a.item_name", "a.prescription_no_fk", "a.patient_no_fk", "b.patient_name", "a.serviceunit_name", "a.room_name", "a.img_app_sl_no", "a.img_app_dttm", "a.img_app_sl_no", 'a.ic_image_capture_key_ind', 'a.invoice_code', 'a.ic_image_capture_keyed_by', 'a.ic_image_capture_keyed_time', 'a.delivery_dttm')
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('a.item_type', $type)
            // ->whereRaw("a.img_app_dttm = to_date('$today','DD-MM-YYYY')")
            ->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();

        return Template::loadview("admin.radiology_v2.image_capture.image_capture_table_collection", ["radiologyAppointment" => $radiologyAppointment]);
    }

    public function radiologyImageSampleCollectionV2(Request $request)
    {
        $auth_id = Auth::id();

        $radiology_update = Radiology::where('radinvoicedtl_no_pk', '=', $request->id)
            ->update([
                'ic_image_capture_key_ind' => 1,
                'ic_image_capture_keyed_by' => $auth_id,
                // 'ic_image_capture_keyed_time' => date('Y-m-d', strtotime(now()))
                'ic_image_capture_keyed_time' => new DateTime('now')
            ]);
        DB::commit();
        $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        return response()->json($message);
    }

    public function radiologyResultEntryWorklistV2(Request $request, $type)
    {
        // $rooms = DB::table("SYS_USER_ROOM_PRIVS_VW")
        // ->where('user_no_fk', "=", Auth::user()->user_no_pk)->get();
        $serviceunit = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            ->where('serviceunit_code', $request->route('type'))
            ->first();
        $menutype = $serviceunit->serviceunit_name;
        $type = $serviceunit->serviceunit_no_pk;

        $rooms = DB::select('SELECT ROOM.ROOM_NO_PK, ROOM.ROOM_NAME
        FROM    sysc_room room
            JOIN
                sysc_serviceunit unit
            ON ROOM.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
        WHERE UNIT.RADIOLOGY_IND = 1');
        $department = DB::table("sysc_serviceunit_vw a")
            ->join("sysc_grant_su b", "a.serviceunit_no_pk", "b.su_no_fk")
            ->select("a.serviceunit_name", "a.serviceunit_no_pk")
            ->where([
                ["a.radiology_ind", "=", 1],
                ["a.status", "=", 1],
                ["b.user_no_fk", "=", Auth::id()],
                ["a.au_entry_hospital_pk_no", "=", Session::get('user.ses_hospital_no_pk')]
            ])->get();
        // dd($department);
        $date = date("Y/m/d");
        $radiologyAppointment = DB::table("radt_invoicedtl_app_wl_vw a")
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->select(
                "a.invoice_code",
                "a.item_code",
                "a.item_name",
                "a.radinvoicedtl_no_pk",
                "a.patient_no_fk",
                "b.gender_txt",
                "b.patient_name",
                "b.patient_photo",
                "b.patient_code",
                "a.serviceunit_name",
                "a.room_name",
                "a.img_app_sl_no",
                "a.ic_image_capture_keyed_time",
                "a.delivery_dttm",
                "a.ic_image_capture_key_ind",
                'a.verify_key_ind',
                'a.result_prepared_key_ind',
                'a.finalize_key_ind',
                'a.finalize_keyed_by',
                'a.invoice_no_pk',
                'a.invoice_date',
                'a.admission_no_pk',
                'a.bed_name',
            )
            ->whereRaw(DB::raw("trunc(ic_image_capture_keyed_time) ='$date'"))
            ->where("ic_image_capture_key_ind", 1)
            ->where('a.serviceunit_no_fk', $serviceunit->serviceunit_no_pk)
            ->whereNull("finalize_key_ind")
            ->whereNull("verify_key_ind")
            ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
            ->orderBy('a.radinvoicedtl_no_pk', "DESC")->get();
        $ind_flag = 1;
        $template_name = [];

        return Template::loadview("admin.radiology_v2.result.radiology_result_entry_v2", ["radiologyAppointment" => $radiologyAppointment, "rooms" => $rooms, "ind_flag" => $ind_flag, "department" => $department, 'template_name' => $template_name, 'type' => $type, 'menutype' => $menutype]);
    }

    public function radiologyResultTabWorklistV2(Request $request, $type)
    {
        $serviceunit = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            ->where('serviceunit_no_pk', $type)
            ->first();
        $menutype = $serviceunit->serviceunit_name;
        $type = $serviceunit->serviceunit_no_pk;
        $userHospitalNo = Session::get('user.ses_hospital_no_pk');
        $todayDate = now()->format('Y-m-d'); // Use Carbon for date handling
        // Fetch rooms
        $rooms = DB::table('sysc_room')
            ->join('sysc_serviceunit', 'sysc_room.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
            ->where('sysc_serviceunit.radiology_ind', 1)
            ->select('sysc_room.room_no_pk', 'sysc_room.room_name')
            ->get();

        // Fetch departments
        $department = DB::table('sysc_serviceunit_vw')
            ->join('sysc_grant_su', 'sysc_serviceunit_vw.serviceunit_no_pk', '=', 'sysc_grant_su.su_no_fk')
            ->where([
                ['sysc_serviceunit_vw.radiology_ind', '=', 1],
                ['sysc_serviceunit_vw.status', '=', 1],
                ['sysc_grant_su.user_no_fk', '=', Auth::id()],
                ['sysc_serviceunit_vw.au_entry_hospital_pk_no', '=', $userHospitalNo]
            ])
            ->select('sysc_serviceunit_vw.serviceunit_name', 'sysc_serviceunit_vw.serviceunit_no_pk')
            ->get();

        // Determine appointment query based on request value
        $query = DB::table('radt_invoicedtl_app_wl_vw')
            ->join('pat_registration_wl_vw', 'radt_invoicedtl_app_wl_vw.patient_no_fk', '=', 'pat_registration_wl_vw.patient_no_pk')
            ->select(
                'radt_invoicedtl_app_wl_vw.invoice_code',
                'radt_invoicedtl_app_wl_vw.item_code',
                'radt_invoicedtl_app_wl_vw.item_name',
                "pat_registration_wl_vw.patient_photo",
                'radt_invoicedtl_app_wl_vw.radinvoicedtl_no_pk',
                'radt_invoicedtl_app_wl_vw.patient_no_fk',
                'pat_registration_wl_vw.patient_name',
                'pat_registration_wl_vw.gender_txt',
                'radt_invoicedtl_app_wl_vw.bed_name',
                'pat_registration_wl_vw.patient_code',
                'radt_invoicedtl_app_wl_vw.serviceunit_name',
                'radt_invoicedtl_app_wl_vw.ic_image_capture_keyed_time',
                'radt_invoicedtl_app_wl_vw.room_name',
                'radt_invoicedtl_app_wl_vw.img_app_sl_no',
                'radt_invoicedtl_app_wl_vw.img_app_dttm',
                'radt_invoicedtl_app_wl_vw.delivery_dttm',
                'radt_invoicedtl_app_wl_vw.ic_image_capture_key_ind',
                'radt_invoicedtl_app_wl_vw.verify_key_ind',
                'radt_invoicedtl_app_wl_vw.result_prepared_key_ind',
                'radt_invoicedtl_app_wl_vw.finalize_key_ind',
                'radt_invoicedtl_app_wl_vw.finalize_keyed_by',
                'radt_invoicedtl_app_wl_vw.invoice_no_pk',
                'radt_invoicedtl_app_wl_vw.invoice_date',
                'radt_invoicedtl_app_wl_vw.admission_no_pk'
            )
            ->whereDate('radt_invoicedtl_app_wl_vw.ic_image_capture_keyed_time', $todayDate)
            ->where('radt_invoicedtl_app_wl_vw.serviceunit_no_fk', $serviceunit->serviceunit_no_pk)
            ->where('radt_invoicedtl_app_wl_vw.ic_image_capture_key_ind', 1)
            ->where('radt_invoicedtl_app_wl_vw.au_entry_hospital_pk_no', $userHospitalNo);


        // if ($request->value == 1) {
        //     $query->whereNull('radt_invoicedtl_app_wl_vw.finalize_key_ind')
        //           ->whereNull('radt_invoicedtl_app_wl_vw.verify_key_ind');
        // } else {
        $query->where('radt_invoicedtl_app_wl_vw.verify_key_ind', 1)
            ->whereNull('radt_invoicedtl_app_wl_vw.finalize_key_ind');
        // }

        $radiologyAppointment = $query->orderBy('radt_invoicedtl_app_wl_vw.radinvoicedtl_no_pk', 'DESC')->get();

        // Fetch templates
        // $template_name = DB::table('rads_resulttemplate')
        //     ->where('au_entry_hospital_no_fk', $userHospitalNo)
        //     ->orderByDesc('au_entry_at')
        //     ->select('template_name', 'result_template_no_pk', 'report_text_html')
        //     ->get();

        // Return view with data

        return view('admin.radiology_v2.result.radiology_result_verified_v2', [
            'radiologyAppointment' => $radiologyAppointment,
            'rooms' => $rooms,
            'ind_flag' => 1,
            'type' => $type,
            'menutype' => $menutype,
            'department' => $department,
            // 'template_name' => $template_name
        ]);
    }


    public function radiologyResultEntryV2($radinvoicedtl_no_pk = "", $type = "", Request $request)
    {
        ini_set('max_execution_time', 0);
        $radiology_appointment_data = DB::table("radt_invoicedtl_app_wl_vw")->select("item_name", "invoice_no_pk", 'serviceunit_no_fk', 'finalize_key_ind', 'ic_image_capture_key_ind', 'ic_image_capture_keyed_time', 'result_entry_key_ind')
            ->where("radinvoicedtl_no_pk", $radinvoicedtl_no_pk)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();

        $invoice_code = isset($radiology_appointment_data) ? $radiology_appointment_data->invoice_no_pk : "";

        $radiology_result_data = DB::table("radt_reporting")
            ->select('rad_report_no_pk', 'result0', 'result_prepared_keyed_by', 'result_verify_keyed_by', 'result_final_keyed_by', 'result_final_key_ind')
            ->where("radinvoicedtl_no_fk", $radinvoicedtl_no_pk)
            ->where("au_entry_hospital_no_fk", Session::get('user.ses_hospital_no_pk'))
            ->first();
        $patient_info = DB::table("FINC_INVOICEMST a")
            ->select("b.patient_no_pk", "b.patient_code", "b.patient_name", "b.age", "b.gender_txt", "b.blood_group_txt", "b.marital_status_txt", "b.patient_photo", "b.mobile1", DB::raw('pat_age(b.dob,nvl(dod,sysdate))pat_age'),)
            ->Join("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
            ->where("a.invoice_no_pk", $invoice_code)
            ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
            ->first();
        // dd($invoice_code);

        $image_capture = DB::table("radt_reporting_img")
            ->select("radinvoicedtl_no_pk", "resultimg_path", "image_caption", "rad_report_imgno_pk")
            ->where("au_entry_hospital_no_fk", Session::get('user.ses_hospital_no_pk'))
            ->where("radinvoicedtl_no_pk", $radinvoicedtl_no_pk)->get();


        $prepared_by = $this->getRadiologyResultEntryByUser("save_ind");
        $verified_by = $this->getRadiologyResultEntryByUser("verify_ind");
        $finalize_by = $this->getRadiologyResultEntryByUser("finalize_ind");
        //    dd($finalize_by);
        $user_id = Auth::id();
        $template_name = DB::table("rads_resulttemplate")->select("template_name", "result_template_no_pk", "report_text_html")
            // ->where("su_no_fk", $radiology_appointment_data->serviceunit_no_fk)
            ->where('au_entry_by', $user_id)
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->orderByDesc('au_entry_at')
            ->get();


        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $patient_id = $patient_info->patient_no_pk;

        return Template::loadview(
            "admin.radiology_v2.result.result_entry_v2",
            [
                "patient_info" => $patient_info,
                "patient_id" => $patient_id,
                "prepared_by" => $prepared_by,
                "verified_by" => $verified_by,
                "finalize_by" => $finalize_by,
                "template_name" => $template_name,
                "type" => $type,
                "radinvoicedtl_no_pk" => $radinvoicedtl_no_pk,
                "radiology_result_data" => $radiology_result_data,
                "image_capture" => $image_capture,
                "radiology_appointment_data" => $radiology_appointment_data,
            ]
        );
    }
    public function radiologyResultEntryV3($radinvoicedtl_no_pk = "", $type = "", Request $request)
    {
        ini_set('max_execution_time', 0);
        $radiology_appointment_data = DB::table("radt_invoicedtl_app_wl_vw")->select("item_name", "invoice_no_pk", 'serviceunit_no_fk', 'finalize_key_ind', 'ic_image_capture_key_ind', 'ic_image_capture_keyed_time', 'result_entry_key_ind')
            ->where("radinvoicedtl_no_pk", $radinvoicedtl_no_pk)->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->first();

        $invoice_code = isset($radiology_appointment_data) ? $radiology_appointment_data->invoice_no_pk : "";

        $radiology_result_data = DB::table("radt_reporting")
            ->select('rad_report_no_pk', 'result0', 'result_prepared_keyed_by', 'result_verify_keyed_by', 'result_final_keyed_by', 'result_final_key_ind')
            ->where("radinvoicedtl_no_fk", $radinvoicedtl_no_pk)
            ->where("au_entry_hospital_no_fk", Session::get('user.ses_hospital_no_pk'))
            ->first();
        $patient_info = DB::table("FINC_INVOICEMST a")
            ->select("b.patient_no_pk", "b.patient_code", "b.patient_name", "b.age", "b.gender_txt", "b.blood_group_txt", "b.marital_status_txt", "b.patient_photo", "b.mobile1", DB::raw('pat_age(b.dob,nvl(dod,sysdate))pat_age'),"pres.ipd_advice")
            ->Join("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
            ->leftJoin("psn_t_prescription pres", "pres.prescription_no_pk", "=", "a.prescription_no_fk")
            ->where("a.invoice_no_pk", $invoice_code)
            ->where("a.au_entry_hospital_pk_no", Session::get('user.ses_hospital_no_pk'))
            ->first();
        // dd($patient_info);

        $image_capture = DB::table("radt_reporting_img")
            ->select("radinvoicedtl_no_pk", "resultimg_path", "image_caption", "rad_report_imgno_pk")
            ->where("au_entry_hospital_no_fk", Session::get('user.ses_hospital_no_pk'))
            ->where("radinvoicedtl_no_pk", $radinvoicedtl_no_pk)->get();


        $prepared_by = $this->getRadiologyResultEntryByUser("save_ind");
        $verified_by = $this->getRadiologyResultEntryByUser("verify_ind");
        $finalize_by = $this->getRadiologyResultEntryByUser("finalize_ind");
        //    dd($finalize_by);
        $user_id = Auth::id();
        $template_name = DB::table("rads_resulttemplate")->select("template_name", "result_template_no_pk", "report_text_html")
            // ->where("su_no_fk", $radiology_appointment_data->serviceunit_no_fk)
            ->where('au_entry_by', $user_id)
            ->where('au_entry_hospital_no_fk', Session::get('user.ses_hospital_no_pk'))
            ->orderByDesc('au_entry_at')
            ->get();


        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $patient_id = $patient_info->patient_no_pk;

        return Template::loadview(
            "admin.radiology_v2.result.result_entry_v3",
            [
                "patient_info" => $patient_info,
                "patient_id" => $patient_id,
                "prepared_by" => $prepared_by,
                "verified_by" => $verified_by,
                "finalize_by" => $finalize_by,
                "template_name" => $template_name,
                "type" => $type,
                "radinvoicedtl_no_pk" => $radinvoicedtl_no_pk,
                "radiology_result_data" => $radiology_result_data,
                "image_capture" => $image_capture,
                "radiology_appointment_data" => $radiology_appointment_data,
            ]
        );
    }

    public function resultEntryPdfV2($radinvoicedtl_no_pk)
    {
        try {
            $radiology_appointment_data = DB::table("radt_invoicedtl_app_wl_vw a")
                ->join("radt_reporting b", "a.radinvoicedtl_no_pk", "b.radinvoicedtl_no_fk")
                ->select(
                    "a.patient_code",
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
                    "finalize_keyed_time",
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
                    'a.admission_no_pk',
                    'a.ward_name',
                    'a.bed_name',
                    'a.invoice_date',
                    'a.ic_image_capture_keyed_time',
                    'a.fin_digital_signature_ind',
                    'a.fin_doctor_signature_image',
                    'a.finalize_key_ind',
                    'a.item_code'
                )
                ->where("a.radinvoicedtl_no_pk", $radinvoicedtl_no_pk)->first();
            $patient_info = DB::table("finc_voucherwise_vw a")
                ->select("a.invoice_code", "b.patient_code", "b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "a.first_ref_doc_name", "b.salutation", "b.passport_no", DB::raw('pat_age(b.dob,nvl(dod,sysdate))pat_age'))
                ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                ->where("a.invoice_code", $radiology_appointment_data->invoice_code)->first();

            $po_hospital_details = DB::table("wsec_hospital")->first();
            $app_barcode = '';
            $invoice_barcode = '';
            $admission_barcode = '';

            if (empty($radiology_appointment_data)) {
                return view("admin.components.error_alert");
            }

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
            $barcode2 = new BarcodeGenerator();
            $barcode2->setText($radiology_appointment_data->admission_no_pk);
            $barcode2->setType(BarcodeGenerator::Code128);
            $barcode2->setScale(1);
            $barcode2->setLabel('');
            $barcode2->setThickness(25);
            $barcode2->setFontSize(10);
            $admission_barcode = $barcode2->generate();

            $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => Auth::id(),
                'result_print_keyed_time' => date('Y-m-d h:i'),
            ];
            DB::table('radt_reporting')->where('radinvoicedtl_no_fk', $radinvoicedtl_no_pk)->update($data);


            return view("admin.radiology_v2.reports.radiology_report_v2", [
                "app_barcode" => $app_barcode,
                "admission_barcode" => $admission_barcode,
                "invoice_barcode" => $invoice_barcode,
                "patient_info" => $patient_info,
                "radiology_appointment_data" => $radiology_appointment_data,
                "po_hospital_details" => $po_hospital_details
            ]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'title' => 'Error']);
        };
    }

    public function resultEntryPdfV3($radinvoicedtl_no_pk)
    {
        try {
            $radiology_appointment_data = DB::table("radt_invoicedtl_app_wl_vw a")
                ->join("radt_reporting b", "a.radinvoicedtl_no_pk", "b.radinvoicedtl_no_fk")
                ->select(
                    "a.patient_code",
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
                    "finalize_keyed_time",
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
                    'a.admission_no_pk',
                    'a.ward_name',
                    'a.bed_name',
                    'a.invoice_date',
                    'a.ic_image_capture_keyed_time',
                    'a.fin_digital_signature_ind',
                    'a.fin_doctor_signature_image',
                    'a.finalize_key_ind',
                    'a.item_code'
                )
                ->where("a.radinvoicedtl_no_pk", $radinvoicedtl_no_pk)->first();
            $patient_info = DB::table("finc_voucherwise_vw a")
                ->select("a.invoice_code", "b.patient_code", "b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "a.first_ref_doc_name", "b.salutation", "b.passport_no", DB::raw('pat_age(b.dob,nvl(dod,sysdate))pat_age'))
                ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                ->where("a.invoice_code", $radiology_appointment_data->invoice_code)->first();

            $po_hospital_details = DB::table("wsec_hospital")->first();
            $app_barcode = '';
            $invoice_barcode = '';
            $admission_barcode = '';

            if (empty($radiology_appointment_data)) {
                return view("admin.components.error_alert");
            }

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
            $barcode2 = new BarcodeGenerator();
            $barcode2->setText($radiology_appointment_data->admission_no_pk);
            $barcode2->setType(BarcodeGenerator::Code128);
            $barcode2->setScale(1);
            $barcode2->setLabel('');
            $barcode2->setThickness(25);
            $barcode2->setFontSize(10);
            $admission_barcode = $barcode2->generate();

            $data = [
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => Auth::id(),
                'result_print_keyed_time' => date('Y-m-d h:i'),
            ];
            DB::table('radt_reporting')->where('radinvoicedtl_no_fk', $radinvoicedtl_no_pk)->update($data);


            return view("admin.radiology_v2.reports.radiology_report_v3", [
                "app_barcode" => $app_barcode,
                "admission_barcode" => $admission_barcode,
                "invoice_barcode" => $invoice_barcode,
                "patient_info" => $patient_info,
                "radiology_appointment_data" => $radiology_appointment_data,
                "po_hospital_details" => $po_hospital_details
            ]);
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'title' => 'Error']);
        };
    }

    public function radiologyResultFinalizeWorklistV2(Request $request, $type)
    {

        $serviceunit = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')
            ->where('serviceunit_no_pk', $type)
            ->first();
        $menutype = $serviceunit->serviceunit_name;
        $type = $serviceunit->serviceunit_no_pk;
        $serviceunit_code = $serviceunit->serviceunit_code;
        $userHospitalNo = Session::get('user.ses_hospital_no_pk');
        $todayDate = now()->format('Y-m-d'); // Use Carbon for date handling

        // Fetch rooms
        $rooms = DB::table('sysc_room')
            ->join('sysc_serviceunit', 'sysc_room.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
            ->where('sysc_serviceunit.radiology_ind', 1)
            ->select('sysc_room.room_no_pk', 'sysc_room.room_name')
            ->get();

        // Fetch departments
        $department = DB::table('sysc_serviceunit_vw')
            ->join('sysc_grant_su', 'sysc_serviceunit_vw.serviceunit_no_pk', '=', 'sysc_grant_su.su_no_fk')
            ->where([
                ['sysc_serviceunit_vw.radiology_ind', '=', 1],
                ['sysc_serviceunit_vw.status', '=', 1],
                ['sysc_grant_su.user_no_fk', '=', Auth::id()],
                ['sysc_serviceunit_vw.au_entry_hospital_pk_no', '=', $userHospitalNo]
            ])
            ->select('sysc_serviceunit_vw.serviceunit_name', 'sysc_serviceunit_vw.serviceunit_no_pk')
            ->get();

        // Determine appointment query based on request value
        $query = DB::table('radt_invoicedtl_app_wl_vw')
            ->join('pat_registration_wl_vw', 'radt_invoicedtl_app_wl_vw.patient_no_fk', '=', 'pat_registration_wl_vw.patient_no_pk')
            ->select(
                'radt_invoicedtl_app_wl_vw.invoice_code',
                'radt_invoicedtl_app_wl_vw.item_name',
                'radt_invoicedtl_app_wl_vw.item_code',
                'radt_invoicedtl_app_wl_vw.radinvoicedtl_no_pk',
                'radt_invoicedtl_app_wl_vw.patient_no_fk',
                'pat_registration_wl_vw.patient_name',
                'pat_registration_wl_vw.patient_code',
                'radt_invoicedtl_app_wl_vw.serviceunit_name',
                'radt_invoicedtl_app_wl_vw.room_name',
                'radt_invoicedtl_app_wl_vw.img_app_sl_no',
                'radt_invoicedtl_app_wl_vw.ic_image_capture_keyed_time',
                'radt_invoicedtl_app_wl_vw.delivery_dttm',
                'radt_invoicedtl_app_wl_vw.ic_image_capture_key_ind',
                'radt_invoicedtl_app_wl_vw.verify_key_ind',
                'radt_invoicedtl_app_wl_vw.result_prepared_key_ind',
                'radt_invoicedtl_app_wl_vw.finalize_key_ind',
                'radt_invoicedtl_app_wl_vw.invoice_date',
                'radt_invoicedtl_app_wl_vw.admission_no_pk'
            )
            ->whereDate('radt_invoicedtl_app_wl_vw.ic_image_capture_keyed_time', $todayDate)
            ->where('radt_invoicedtl_app_wl_vw.serviceunit_no_fk', $serviceunit->serviceunit_no_pk)
            ->where('radt_invoicedtl_app_wl_vw.ic_image_capture_key_ind', 1)
            ->where('radt_invoicedtl_app_wl_vw.au_entry_hospital_pk_no', $userHospitalNo);

        // if ($request->value == 1) {
        //     $query->whereNull('radt_invoicedtl_app_wl_vw.finalize_key_ind')
        //           ->whereNull('radt_invoicedtl_app_wl_vw.verify_key_ind');
        // } else {
        $query->where('radt_invoicedtl_app_wl_vw.verify_key_ind', 1)
            ->whereNull('radt_invoicedtl_app_wl_vw.finalize_key_ind');
        // }

        $radiologyAppointment = $query->orderBy('radt_invoicedtl_app_wl_vw.radinvoicedtl_no_pk', 'DESC')->get();

        // Fetch templates
        // $template_name = DB::table('rads_resulttemplate')
        //     ->where('au_entry_hospital_no_fk', $userHospitalNo)
        //     ->orderByDesc('au_entry_at')
        //     ->select('template_name', 'result_template_no_pk', 'report_text_html')
        //     ->get();

        // Return view with data
        $ind_flag = 2;

        return Template::loadview('admin.radiology_v2.result.radiology_result_finalize_v2', [
            'radiologyAppointment' => $radiologyAppointment,
            'rooms' => $rooms,
            'ind_flag' => 2,
            'type' => $type,
            'serviceunit_code' => $serviceunit_code,
            'menutype' => $menutype,
            'department' => $department,
            // 'template_name' => $template_name
        ]);
    }

    public function radiologyResultFinalizedWorklistV2(Request $request, $type)
    {
        $serviceunit = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_name', 'serviceunit_code')
            ->where('serviceunit_code', $request->route('type'))
            ->first();
        $menutype = $serviceunit->serviceunit_name;
        $type = $serviceunit->serviceunit_no_pk;
        $serviceCode = $serviceunit->serviceunit_code;

        $userHospitalNo = Session::get('user.ses_hospital_no_pk');
        $date = date("Y/m/d");

        // Fetch rooms
        $rooms = DB::table('sysc_room')
            ->join('sysc_serviceunit', 'sysc_room.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
            ->where('sysc_serviceunit.radiology_ind', 1)
            ->select('sysc_room.room_no_pk', 'sysc_room.room_name')
            ->get();

        // Fetch departments
        $department = DB::table('sysc_serviceunit_vw')
            ->join('sysc_grant_su', 'sysc_serviceunit_vw.serviceunit_no_pk', '=', 'sysc_grant_su.su_no_fk')
            ->where([
                ['sysc_serviceunit_vw.radiology_ind', '=', 1],
                ['sysc_serviceunit_vw.status', '=', 1],
                ['sysc_grant_su.user_no_fk', '=', Auth::id()],
                ['sysc_serviceunit_vw.au_entry_hospital_pk_no', '=', $userHospitalNo]
            ])
            ->select('sysc_serviceunit_vw.serviceunit_name', 'sysc_serviceunit_vw.serviceunit_no_pk')
            ->get();

        // Determine appointment query based on request value
        $query = DB::table('radt_invoicedtl_app_wl_vw')
            ->join('pat_registration_wl_vw', 'radt_invoicedtl_app_wl_vw.patient_no_fk', '=', 'pat_registration_wl_vw.patient_no_pk')
            ->select(
                'radt_invoicedtl_app_wl_vw.invoice_code',
                'radt_invoicedtl_app_wl_vw.item_name',
                'radt_invoicedtl_app_wl_vw.item_code',
                'radt_invoicedtl_app_wl_vw.radinvoicedtl_no_pk',
                'radt_invoicedtl_app_wl_vw.patient_no_fk',
                'pat_registration_wl_vw.patient_name',
                'pat_registration_wl_vw.patient_code',
                'pat_registration_wl_vw.patient_photo',
                'pat_registration_wl_vw.gender_txt',
                'radt_invoicedtl_app_wl_vw.serviceunit_name',
                'radt_invoicedtl_app_wl_vw.room_name',
                'radt_invoicedtl_app_wl_vw.img_app_sl_no',
                'radt_invoicedtl_app_wl_vw.ic_image_capture_keyed_time',
                'radt_invoicedtl_app_wl_vw.delivery_dttm',
                'radt_invoicedtl_app_wl_vw.ic_image_capture_key_ind',
                'radt_invoicedtl_app_wl_vw.verify_key_ind',
                'radt_invoicedtl_app_wl_vw.result_prepared_key_ind',
                'radt_invoicedtl_app_wl_vw.finalize_key_ind',
                'radt_invoicedtl_app_wl_vw.finalize_keyed_by',
                'radt_invoicedtl_app_wl_vw.invoice_no_pk',
                'radt_invoicedtl_app_wl_vw.invoice_date',
                'radt_invoicedtl_app_wl_vw.admission_no_pk',
                'radt_invoicedtl_app_wl_vw.bed_name',
            )
            ->whereRaw(DB::raw("trunc(radt_invoicedtl_app_wl_vw.ic_image_capture_keyed_time) ='$date'"))
            ->where('radt_invoicedtl_app_wl_vw.serviceunit_no_fk', $serviceunit->serviceunit_no_pk)
            ->where('radt_invoicedtl_app_wl_vw.ic_image_capture_key_ind', 1)
            ->where('radt_invoicedtl_app_wl_vw.au_entry_hospital_pk_no', $userHospitalNo);

        // if ($request->value == 1) {
        //     $query->whereNull('radt_invoicedtl_app_wl_vw.finalize_key_ind')
        //           ->whereNull('radt_invoicedtl_app_wl_vw.verify_key_ind');
        // } else {
        $query->where('radt_invoicedtl_app_wl_vw.verify_key_ind', 1)
            ->where('radt_invoicedtl_app_wl_vw.finalize_key_ind', 1);
        // }

        $radiologyAppointment = $query->orderBy('radt_invoicedtl_app_wl_vw.radinvoicedtl_no_pk', 'DESC')->get();

        // Fetch templates
        $template_name = DB::table('rads_resulttemplate')
            ->where('au_entry_hospital_no_fk', $userHospitalNo)
            ->orderByDesc('au_entry_at')
            ->select('template_name', 'result_template_no_pk', 'report_text_html')
            ->get();

        // Return view with data
        $ind_flag = 2;

        return Template::loadview('admin.radiology_v2.result.radiology_result_finalized_v2', [
            'radiologyAppointment' => $radiologyAppointment,
            'rooms' => $rooms,
            'ind_flag' => 2,
            'type' => $type,
            'menutype' => $menutype,
            'serviceCode' => $serviceCode,
            'department' => $department,
            'template_name' => $template_name
        ]);
    }

    public function radiologyItemWiseRoom()
    {
        $department_name = DB::table('sysc_serviceunit')->where('radiology_ind', '1')->where('status', '1')->get();
        $room_no = DB::select("SELECT ROOM_NO_PK, ROOM_CODE, ROOM_NAME
                    FROM    sysc_room room
                        JOIN
                            sysc_serviceunit unit
                        ON ROOM.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                    WHERE UNIT.RADIOLOGY_IND = 1 and unit.status = 1");
        $items = DB::table('sysc_serviceitem')
            ->where('item_type', 'RAD')
            ->where('STATUS', 1)
            ->get();
        // dd($room_no);
        return Template::loadview("admin.radiology_v2.setup.item_wise_room", ["items" => $items, "department_name" => $department_name, "room_no" => $room_no]);
    }

    public function storeRadiologyItemWiseRoom(Request $request)
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $id = $request->id;
        $auth_id = Auth::id();
        DB::beginTransaction();

        try {
            // Data to be inserted or updated
            $data = [
                'item_no_fk' => $request->item,
                'su_no_fk' => $request->su_no_fk,
                'room_no_fk' => $request->room_no_fk,
                'start_time' => date("H:i", strtotime($request->start_time)),
                'end_time' => date("H:i", strtotime($request->end_time)),
                'duration_time' => $request->duration,
                'avg_time' => $request->avg_time,
                'pre_requisition' => $request->prerequisition,
                'status' => 1,
                'au_entry_hospital_no_fk' => $ses_hospital_id,
            ];

            // Check if the item already exists
            $existingRecord = DB::table('RADT_ROOM_SHEDULESETUP_UHL')
                ->where('item_no_fk', $request->item)
                ->where('room_no_fk', $request->room_no_fk)
                // ->where('start_time', date("H:i", strtotime($request->start_time)))
                // ->where('end_time', date("H:i", strtotime($request->end_time)))
                ->first();

            if ($existingRecord) {
                // If record exists, return a message indicating it is already available
                DB::rollback();
                $message = ['msg' => 'Record already exists', 'title' => 'Error'];
                return response()->json($message);
            }

            // Proceed to insert or update if record does not exist
            if ($id == "") {
                $data['au_entry_by'] = $auth_id;
                $this->model5->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->model5->update($data, $id);
            }

            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }

        return response()->json($message);
    }

    public function itemChecked(Request $request)
    {
        // Validate the request
        $request->validate([
            'item_id' => 'required|integer'
        ]);

        // Use parameter binding to prevent SQL injection
        $item = DB::table('RADT_ROOM_SHEDULESETUP_UHL')
            ->where('item_no_fk', $request->item_id)
            ->first();

        $dept = DB::select("SELECT SERVICEUNIT_NO_FK, SERVICEUNIT_NAME FROM SYSC_SERVICEITEM_VW WHERE item_no_pk = $request->item_id");

        if ($item) {
            // Item is available
            return response()->json([
                'status' => 'error',
                'message' => 'Item already available'
            ]);
        } else {
            // Item is not available
            return response()->json([
                'status' => 'success',
                'message' => 'Item not available',
                'dept' => $dept // Ensure dept is an array
            ]);
        }
    }


    public function radiologyItemWiseRoomSchedule()
    {
        return Template::loadview("admin.radiology_v2.setup.item_wise_schedule_list");
    }

    public function radiologyitemrWiseRoomScheduleForm()
    {
        $department_name = DB::table('sysc_serviceunit')->where('radiology_ind', '1')->where('status', '1')->get();
        $room_no = DB::select("SELECT ROOM_NO_PK, ROOM_CODE, ROOM_NAME
                    FROM    sysc_room room
                        JOIN
                            sysc_serviceunit unit
                        ON ROOM.SERVICEUNIT_NO_FK = UNIT.SERVICEUNIT_NO_PK
                    WHERE UNIT.RADIOLOGY_IND = 1 and unit.status = 1");
        $items = DB::table('sysc_serviceitem')
            ->where('item_type', 'RAD')
            ->where('STATUS', 1)
            ->get();
        return Template::loadview("admin.radiology_v2.setup.item_wise_room_form", ["items" => $items, "department_name" => $department_name, "room_no" => $room_no]);
    }


    public function radiologyItemWiseRoomScheduleList(Request $request)
    {
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $sql_cond = "au_entry_hospital_pk_no = '$hospital_id'";
        // $where = "au_entry_hospital_pk_no = $hospital_id";
        $table = 'RADT_ROOM_SHEDULESETUP_UHL_VW';
        // Table's primary key
        $primaryKey = 'room_shedsetup_no_pk';

        $columns = array(
            array('db' => 'rownum', 'dt' => 0),
            array('db' => 'item_name', 'dt' => 1),
            array('db' => 'serviceunit_name', 'dt' => 2),
            array('db' => 'room_name', 'dt' => 3),
            array('db' => 'start_time', 'dt' => 4),
            array('db' => 'end_time', 'dt' => 5),
            array('db' => 'avg_time', 'dt' => 6),
            array('db' => 'duration_time', 'dt' => 7),
            array('db' => 'status', 'dt' => 8),
            array('db' => 'room_shedsetup_no_pk', 'dt' => 9),
        );

        if (!empty($where)) {
            echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        } else {

            echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        }
    }

    public function searchResultEntryListV2(Request $request)
    {
        $typeInput = $request->typeInput;
        // Initialize the query builder
        $appointment_query = DB::table("radt_invoicedtl_app_wl_vw as a")
            ->join("pat_registration_wl_vw as b", "a.patient_no_fk", "b.patient_no_pk")
            ->select(
                "a.invoice_code",
                "a.item_code",
                "a.item_name",
                "a.radinvoicedtl_no_pk",
                "a.patient_no_fk",
                "b.gender_txt",
                "b.patient_name",
                "b.patient_photo",
                "b.patient_code",
                "a.serviceunit_name",
                "a.room_name",
                "a.img_app_sl_no",
                "a.ic_image_capture_keyed_time",
                "a.delivery_dttm",
                "a.ic_image_capture_key_ind",
                'a.verify_key_ind',
                'a.result_prepared_key_ind',
                'a.finalize_key_ind',
                'a.finalize_keyed_by',
                'a.invoice_no_pk',
                'a.invoice_date',
                'a.admission_no_pk',
                'a.bed_name',
            )
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('a.serviceunit_no_fk', $typeInput)
            ->where("a.ic_image_capture_key_ind", 1);

        // Apply filters based on the request type

        switch ($request->type) {
            case 'PENDING':
                $appointment_query->whereNull("verify_key_ind")
                    ->whereNull("finalize_key_ind");
                break;
            case 'VERIFY':
                $appointment_query->where('verify_key_ind', 1)
                    ->whereNull('finalize_key_ind');
                break;
            case 'FINALIZE':
                $appointment_query->where("verify_key_ind", 1)
                    ->whereNull("finalize_key_ind");
                break;
            case 'FINALIZED':
                $appointment_query->where("verify_key_ind", 1)
                    ->where("finalize_key_ind", 1);
                break;
            case 'FINALIZEDPRINT':
                $appointment_query->where("verify_key_ind", 1)
                    ->where("finalize_key_ind", 1);
                break;
        }

        // Handle date range filtering
        $from_date = $request->appointment_list_form;
        $to_date = $request->appointment_list_to;

        if ($from_date && $to_date) {
            $appointment_query->whereRaw("TRUNC(a.ic_image_capture_keyed_time) BETWEEN TRUNC(TO_DATE(?, 'DD/MM/YYYY')) AND TRUNC(TO_DATE(?, 'DD/MM/YYYY'))", [$from_date, $to_date]);
        }


        // Handle room filter
        $appointment_list_room = $request->room_no_fk;
        if ($appointment_list_room) {
            $appointment_query->where('a.room_no_fk', $appointment_list_room);
        }

        // Handle department filter
        $appointment_list_department = $request->appointment_list_department;
        if ($appointment_list_department !== "0") {
            $appointment_query->where('a.serviceunit_no_fk', $appointment_list_department);
        }

        // Handle voucher number filter
        $voucher_no = $request->invoice_id;
        if ($voucher_no) {
            $appointment_query->where('a.invoice_no_pk', (int) $voucher_no);
        }

        // Handle voucher number filter
        $hdn_patient_id = $request->hdn_patient_id;
        if ($hdn_patient_id) {
            $appointment_query->where('a.patient_no_fk', $hdn_patient_id);
        }

        // Execute the query and get results
        $radiologyAppointment = $appointment_query->orderBy('a.invoice_date', "DESC")->get();
        // dd($radiologyAppointment,(int)$voucher_no);
        // Prepare the view with the results

        if ($request->type == 'FINALIZEDPRINT') {
            $ind_flag = 3;
        } else {
            $ind_flag = 1;
        }
        // admin.radiology_v2.result.radiology_result_entry_list_v2
        return Template::loadview("admin.radiology_v2.result.radiology_result_entry_list_v2", [
            "radiologyAppointment" => $radiologyAppointment,
            "ind_flag" => $ind_flag
        ]);
    }


    public function resultFinalizedPrint(Request $request)
    {
        //    dd($request->route('type'));
        $serviceunit = DB::table('sysc_serviceunit')
            ->select('serviceunit_no_pk', 'serviceunit_name')
            ->where('serviceunit_code', $request->route('type'))
            ->first();
        $menutype = $serviceunit->serviceunit_name;
        $type = $serviceunit->serviceunit_no_pk;
        $userHospitalNo = Session::get('user.ses_hospital_no_pk');
        $todayDate = now()->format('Y-m-d'); // Use Carbon for date handling

        // Fetch rooms
        $rooms = DB::table('sysc_room')
            ->join('sysc_serviceunit', 'sysc_room.serviceunit_no_fk', '=', 'sysc_serviceunit.serviceunit_no_pk')
            ->where('sysc_serviceunit.radiology_ind', 1)
            ->select('sysc_room.room_no_pk', 'sysc_room.room_name')
            ->get();

        // Fetch departments
        $department = DB::table('sysc_serviceunit_vw')
            ->join('sysc_grant_su', 'sysc_serviceunit_vw.serviceunit_no_pk', '=', 'sysc_grant_su.su_no_fk')
            ->where([
                ['sysc_serviceunit_vw.radiology_ind', '=', 1],
                ['sysc_serviceunit_vw.status', '=', 1],
                ['sysc_grant_su.user_no_fk', '=', Auth::id()],
                ['sysc_serviceunit_vw.au_entry_hospital_pk_no', '=', $userHospitalNo]
            ])
            ->select('sysc_serviceunit_vw.serviceunit_name', 'sysc_serviceunit_vw.serviceunit_no_pk')
            ->get();

        // Determine appointment query based on request value
        $query = DB::table('radt_invoicedtl_app_wl_vw')
            ->join('pat_registration_wl_vw', 'radt_invoicedtl_app_wl_vw.patient_no_fk', '=', 'pat_registration_wl_vw.patient_no_pk')
            ->select(
                'radt_invoicedtl_app_wl_vw.invoice_code',
                'radt_invoicedtl_app_wl_vw.item_name',
                'radt_invoicedtl_app_wl_vw.item_code',
                'radt_invoicedtl_app_wl_vw.radinvoicedtl_no_pk',
                'radt_invoicedtl_app_wl_vw.patient_no_fk',
                'pat_registration_wl_vw.patient_name',
                'pat_registration_wl_vw.patient_code',
                'radt_invoicedtl_app_wl_vw.serviceunit_name',
                'radt_invoicedtl_app_wl_vw.room_name',
                'radt_invoicedtl_app_wl_vw.img_app_sl_no',
                'radt_invoicedtl_app_wl_vw.ic_image_capture_keyed_time',
                'radt_invoicedtl_app_wl_vw.delivery_dttm',
                'radt_invoicedtl_app_wl_vw.ic_image_capture_key_ind',
                'radt_invoicedtl_app_wl_vw.verify_key_ind',
                'radt_invoicedtl_app_wl_vw.result_prepared_key_ind',
                'radt_invoicedtl_app_wl_vw.finalize_key_ind',
                'radt_invoicedtl_app_wl_vw.invoice_date',
                'radt_invoicedtl_app_wl_vw.invoice_no_pk',
                'radt_invoicedtl_app_wl_vw.finalize_keyed_by ',
                'radt_invoicedtl_app_wl_vw.admission_no_pk'
            )
            ->whereDate('radt_invoicedtl_app_wl_vw.ic_image_capture_keyed_time', $todayDate)
            ->where('radt_invoicedtl_app_wl_vw.serviceunit_no_fk', $serviceunit->serviceunit_no_pk)
            ->where('radt_invoicedtl_app_wl_vw.ic_image_capture_key_ind', 1)
            ->where('radt_invoicedtl_app_wl_vw.au_entry_hospital_pk_no', $userHospitalNo);

        // if ($request->value == 1) {
        //     $query->whereNull('radt_invoicedtl_app_wl_vw.finalize_key_ind')
        //           ->whereNull('radt_invoicedtl_app_wl_vw.verify_key_ind');
        // } else {
        $query->where('radt_invoicedtl_app_wl_vw.finalize_key_ind', 1);
        // }

        $radiologyAppointment = $query->orderBy('radt_invoicedtl_app_wl_vw.radinvoicedtl_no_pk', 'DESC')->get();

        // Fetch templates
        // $template_name = DB::table('rads_resulttemplate')
        //     ->where('au_entry_hospital_no_fk', $userHospitalNo)
        //     ->orderByDesc('au_entry_at')
        //     ->select('template_name', 'result_template_no_pk', 'report_text_html')
        //     ->get();

        // Return view with data
        $ind_flag = 2;

        return Template::loadview('admin.radiology_v2.result.radiology_result_finalize_finalized_print', [
            'radiologyAppointment' => $radiologyAppointment,
            'rooms' => $rooms,
            'ind_flag' => 3,
            'type' => $type,
            'menutype' => $menutype,
            'department' => $department,
            // 'template_name' => $template_name
        ]);
    }

    public function reportListMenu()
    {
        $dept = ServiceUnit::select('serviceunit_code', 'serviceunit_name', 'serviceunit_no_pk')->where('radiology_ind', 1)->get();
        $allMenus = Menu::select('menu_no_pk', 'parent_menu_no_fk', 'menu_code', 'menu_icon', 'menu_name', 'menu_link', 'sl_no')
            ->where('parent_menu_no_fk', 0)
            ->orderBy('sl_no', 'asc')
            ->get();
        $features = DB::table('MENU_FEATURE_VW')
            ->select(
                DB::raw("'' AS sl"),
                'module',
                'MENU_FEATURE_VW.features_code',
                'MENU_FEATURE_VW.features_name',
                'MENU_FEATURE_VW.sl_no',
                'MENU_FEATURE_VW.page_url',
                'MENU_FEATURE_VW.features_no_pk',
                DB::raw('ROWNUM AS rownumber'),
                'MENU_FEATURE_VW.au_update_at',
                'MENU_FEATURE_VW.au_entry_at',
                'WSEC_MENUFEATURES.AU_entry_SESSION'
            )
            ->leftJoin('wsec_menufeatures', 'MENU_FEATURE_VW.features_no_pk', '=', 'wsec_menufeatures.features_no_pk')
            ->where('WSEC_MENUFEATURES.AU_entry_SESSION', '=', 'RADIOLOGYENTRY')
            ->get();
        $groupedFeatures = $features->groupBy('module');
        return Template::loadview('admin.radiology_v2.reportEntry.report_list', compact('allMenus', 'dept', 'groupedFeatures'));
    }




    // Report Setup Part
    public function reportEntryPage(Request $request)
    {
        $dept = ServiceUnit::select('serviceunit_code', 'serviceunit_name', 'serviceunit_no_pk')->where('radiology_ind', 1)->get();
        $allMenus = Menu::select('menu_no_pk', 'parent_menu_no_fk', 'menu_code', 'menu_icon', 'menu_name', 'menu_link', 'sl_no')
            ->where('parent_menu_no_fk', 0)
            ->orderBy('sl_no', 'asc')
            ->get();
        return Template::loadview('admin.radiology_v2.reportEntry.report_entry_form', compact('allMenus', 'dept'));
    }
    public function getRadiologyReport()
    {
        $data = DB::table('MENU_FEATURE_VW')
            ->select(
                DB::raw("'' AS sl"),
                'module',
                'MENU_FEATURE_VW.features_code',
                'MENU_FEATURE_VW.features_name',
                'MENU_FEATURE_VW.sl_no',
                'MENU_FEATURE_VW.page_url',
                'MENU_FEATURE_VW.features_no_pk',
                DB::raw('ROWNUM AS rownumber'),
                'MENU_FEATURE_VW.au_update_at',
                'MENU_FEATURE_VW.au_entry_at',
                'WSEC_MENUFEATURES.AU_entry_SESSION'
            )
            ->leftJoin('wsec_menufeatures', 'MENU_FEATURE_VW.features_no_pk', '=', 'wsec_menufeatures.features_no_pk')
            ->where('WSEC_MENUFEATURES.AU_entry_SESSION', '=', 'RADIOLOGYENTRY')
            ->get();
        return response()->json(['data' => $data], 200);
    }

    public function getRadiologyMenuList()
    {
        // Fetch features from the database, ensuring to join the required tables and filter as needed.
        $features = DB::table('MENU_FEATURE_VW')
            ->select(
                DB::raw("'' AS sl"),  // For the serial number column (will be handled in JS)
                'module',
                'MENU_FEATURE_VW.features_code',
                'MENU_FEATURE_VW.features_name',
                'MENU_FEATURE_VW.sl_no',
                'MENU_FEATURE_VW.page_url',
                'MENU_FEATURE_VW.features_no_pk',
                DB::raw('ROWNUM AS rownumber'),
                'MENU_FEATURE_VW.au_update_at',
                'MENU_FEATURE_VW.au_entry_at',
                'WSEC_MENUFEATURES.AU_entry_SESSION'
            )
            ->leftJoin('wsec_menufeatures', 'MENU_FEATURE_VW.features_no_pk', '=', 'wsec_menufeatures.features_no_pk')
            ->where('WSEC_MENUFEATURES.AU_entry_SESSION', '=', 'RADIOLOGYENTRY')
            ->get();

        // Group the features by the 'module' field
        $groupedFeatures = $features->groupBy('module');

        // dd($groupedFeatures);

        // return response()->json([
        //     'data' => $groupedFeatures
        // ], 200);
    }

    public function storeEntryReport(Request $request)
    {
        $request->validate([
            'menu' => 'required'
        ]);


        try {

            if (!$this->isSelectStatement($request->sql_query)) {
                return response()->json(['success' => false, 'message' => 'Only Select Statement allowed', 'title' => 'Failed'], 422);
            }
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $seq = $this->getSequence('MIS_REPORTMST_SEQ');
            DB::beginTransaction();
            $data = [
                'report_no_pk' => $seq,
                'report_code' => $seq,
                'report_setup_date' => $au_entry_at,
                'report_name' => $request->report_name,
                'report_name_show' => $request->report_name_show,
                'menu_no_fk' => $request->menu,
                'sql_based_ind' => 1,
                'sql_query_text' => $request->sql_query,
                'sql_query_clob' => $request->sql_query,
                'status' => 1,
                'au_entry_at' => $au_entry_at,
                'au_entry_by' => Auth::id(),
                'au_entry_session' => $entry_session,
                'au_entry_hospital_no_fk' => $hospital_pk_no
            ];

            DB::table('mis_reportmst')->insert($data);
            $lastInsertedId = DB::table('mis_reportmst')->orderByDesc('report_no_pk')->value('report_no_pk');
            //Column Entry
            foreach ($request->column_heading_name as $key => $value) {
                $sequence = $this->getSequence('mis_reportchd_seq');
                $serviceunitcode = DB::table('sysc_serviceunit')->select('serviceunit_code')->where('serviceunit_no_pk', $request->department_id)->first()->serviceunit_code;

                $child = [
                    'reportchd_no_pk' => $sequence,
                    'reportchd_code' => $sequence,
                    'reportchd_setup_date' => $au_entry_at,
                    'column_heading_name' => $request->column_heading_name[$key],
                    'column_name_actual' => $request->column_name_actual[$key],
                    'value_type' => $request->value_type[$key],
                    'alignment_type' => $request->alignment_type[$key],
                    'sum_ind' => $request->sum_ind[$key],
                    'show_ind' => $request->show_ind[$key],
                    'sl' => $request->sl[$key],
                    'report_no_fk' => $lastInsertedId,
                    'status' => 1,
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_no_fk' => $hospital_pk_no
                ];

                if (!empty($child['column_name_actual']) && !empty($child['column_heading_name'])) {
                    DB::table('MIS_REPORTCHD')->insert($child);
                }
            }

            //Parameter Entry
            foreach ($request->reportparam_name as $key => $value) {
                $sequence = $this->getSequence('MIS_REPORT_PARAM_SEQ');

                $value_list_sql = $request->value_list_sql[$key];
                if (!empty($request->value_list_sql[$key])) {
                    if (!$this->isSelectStatement($request->value_list_sql[$key])) {
                        $value_list_sql = '';
                    }
                }
                $child = [
                    'reportparam_no_pk' => $sequence,
                    'reportparam_code' => $sequence,
                    'numeric_ind' => $request->parameter_type[$key] == 1 ? 1 : 0,
                    'date_ind' => $request->parameter_type[$key] == 2 ? 1 : 0,
                    'text_type_ind' => $request->parameter_type[$key] == 3 ? 1 : 0,
                    'value_list_ind' => $request->parameter_type[$key] == 4 ? 1 : 0,
                    'reportparam_name' => $value,
                    'parameter_label' => $request->parameter_label[$key],
                    'value_list_sql' => $value_list_sql,
                    'status' => 1,
                    'report_no_fk' => $lastInsertedId,
                    'status' => 1,
                    'reportparam_setup_date' => $au_entry_at,
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_no_fk' => $hospital_pk_no
                ];

                if (!empty($value)) {
                    DB::table('MIS_REPORT_PARAM')->insert($child);
                }
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Successfully Saved', 'title' => 'Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage(), 'title' => 'Failed'], 422);
        }
    }
    public function reportDetatils($id)
    {
        $data = $this->reportInfo($id);
        return Template::loadView("admin.mis_report.modal.report_info", compact('data'));
    }
    public function reportEntryEdit($id)
    {
        $data = $this->reportInfo($id);

        $allMenus = Menu::select('menu_no_pk', 'parent_menu_no_fk', 'menu_code', 'menu_icon', 'menu_name', 'menu_link', 'sl_no')
            ->where('parent_menu_no_fk', 0)
            ->orderBy('sl_no', 'asc')
            ->get();
        return Template::loadview('admin.mis_report.edit_mis_report', compact('allMenus', 'data'));
    }

    public function updateReport(Request $request)
    {
        $request->validate([
            'menu' => 'required',
            'report_no_pk' => 'required',
        ]);


        try {

            if (!$this->isSelectStatement($request->sql_query)) {
                return response()->json(['success' => false, 'message' => 'Only Select Statement allowed', 'title' => 'Failed'], 422);
            }
            $au_entry_at = Carbon::now();
            $au_entry_at = $au_entry_at->toDateString();
            $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
            $entry_session = Session()->get('user.ses_user_pk_no');
            $report_no_pk = $request->report_no_pk;
            DB::beginTransaction();
            $data = [
                'report_setup_date' => $au_entry_at,
                'report_name' => $request->report_name,
                'report_name_show' => $request->report_name_show,
                'menu_no_fk' => $request->menu,
                'sql_query_text' => $request->sql_query,
                'sql_query_clob' => $request->sql_query,
                'au_update_at' => $au_entry_at,
                'au_update_by' => Auth::id(),
                'au_update_session' => $entry_session,
                'au_update_hospital_no_fk' => $hospital_pk_no
            ];

            DB::table('mis_reportmst')->where('report_no_pk', $report_no_pk)->update($data);
            $lastInsertedId = $report_no_pk;

            //Column Entry
            DB::table('MIS_REPORTCHD')->where('report_no_fk', $report_no_pk)->delete();
            foreach ($request->column_heading_name as $key => $value) {
                $sequence = $this->getSequence('mis_reportchd_seq');

                $child = [
                    'reportchd_no_pk' => $sequence,
                    'reportchd_code' => $sequence,
                    'reportchd_setup_date' => $au_entry_at,
                    'column_heading_name' => $request->column_heading_name[$key],
                    'column_name_actual' => $request->column_name_actual[$key],
                    'value_type' => $request->value_type[$key],
                    'alignment_type' => $request->alignment_type[$key],
                    'sum_ind' => $request->sum_ind[$key],
                    'show_ind' => $request->show_ind[$key],
                    'sl' => $request->sl[$key],
                    'report_no_fk' => $lastInsertedId,
                    'status' => 1,
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_no_fk' => $hospital_pk_no
                ];

                if (!empty($child['column_name_actual']) && !empty($child['column_heading_name'])) {
                    DB::table('MIS_REPORTCHD')->insert($child);
                }
            }

            //Parameter Entry
            DB::table('MIS_REPORT_PARAM')->where('report_no_fk', $report_no_pk)->delete();
            foreach ($request->reportparam_name as $key => $value) {
                $sequence = $this->getSequence('MIS_REPORT_PARAM_SEQ');

                $value_list_sql = $request->value_list_sql[$key];
                if (!empty($request->value_list_sql[$key])) {
                    if (!$this->isSelectStatement($request->value_list_sql[$key])) {
                        $value_list_sql = '';
                    }
                }
                $child = [
                    'reportparam_no_pk' => $sequence,
                    'reportparam_code' => $sequence,
                    'numeric_ind' => $request->parameter_type[$key] == 1 ? 1 : 0,
                    'date_ind' => $request->parameter_type[$key] == 2 ? 1 : 0,
                    'text_type_ind' => $request->parameter_type[$key] == 3 ? 1 : 0,
                    'value_list_ind' => $request->parameter_type[$key] == 4 ? 1 : 0,
                    'reportparam_name' => $value,
                    'parameter_label' => $request->parameter_label[$key],
                    'value_list_sql' => $value_list_sql,
                    'status' => 1,
                    'report_no_fk' => $lastInsertedId,
                    'status' => 1,
                    'reportparam_setup_date' => $au_entry_at,
                    'au_entry_at' => $au_entry_at,
                    'au_entry_by' => Auth::id(),
                    'au_entry_session' => $entry_session,
                    'au_entry_hospital_no_fk' => $hospital_pk_no
                ];

                if (!empty($value)) {
                    DB::table('MIS_REPORT_PARAM')->insert($child);
                }
            }
            DB::commit();
            return response()->json(['success' => true, 'message' => 'Successfully Updated', 'title' => 'Success'], 200);
        } catch (\Throwable $th) {
            DB::rollBack();
            return response()->json(['success' => false, 'message' => $th->getMessage(), 'title' => 'Failed'], 422);
        }
    }



    public function saveMenuRoute(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $auth_id = Auth::id();
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        DB::beginTransaction();


        try {
            $data = [];
            $counter = 1;
            foreach ($request->routes as $route) {
                $sequence = DB::getSequence();
                $features_no_pk_seq = $sequence->nextValue('features_no_pk_seq');
                $serviceunitcode = DB::table('sysc_serviceunit')
                    ->where('serviceunit_no_pk', $request->department_id)
                    ->value('serviceunit_code');
                $data[] = [
                    'features_no_pk' => $features_no_pk_seq,
                    'menu_no_pk' => $request->menuId,
                    'features_code' => $request->menuId . '-' . $features_no_pk_seq,
                    'features_name' => $route['feature_name'],
                    'sl_no' => $counter++,
                    'page_url' => $route['route_name'] . $serviceunitcode,
                    'status' => $route['status'] ? 1 : null,
                    'au_entry_hospital_pk_no' => $ses_hospital_id,
                    'au_entry_by' => $id ? null : $auth_id,
                    'au_update_by' => $id ? $auth_id : null,
                    'au_entry_at' => date('Y-m-d'),
                    'au_entry_session' => 'RADIOLOGYENTRY',
                ];
            }

            // Insert all records at once
            DB::table('wsec_menufeatures')->insert($data);
            DB::commit();
            return response()->json(['msg' => 'Data Saved Successfully', 'title' => 'Success']);
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['msg' => $e->getMessage(), 'title' => 'Error']);
        }
    }

    public function radiologyAppointmentStatusList()
    {
        return Template::loadview('admin.radiology_v2.appointment.appointment_list_status');
    }
    public function radiologyAdvanceApointment()
    {
        return Template::loadview('admin.radiology_v2.appointment.appointment_advance_apointment');
    }

    // InvoiceController.php
    public function getBookedItems($radinvoicedtl_no_pk, $itemId)
    {
        // Retrieve booked items and their scheduled start and end times from the RADT_PAT_SHEDULE table
        return DB::table('RADT_PAT_SHEDULE')
            ->select('item_no_fk', 'shed_str_time', 'shed_end_time')
            ->where('radinvoicedtl_no_fk', $radinvoicedtl_no_pk)
            ->where('item_no_fk', $itemId)
            ->get();  // Use get() to return the full data (instead of pluck)
    }


    public function searchByInvoiceWiseItem(Request $request)
    {
        // Get the invoice ID from the request
        $invoice_id = $request->invoice_id;

        // Query the invoice details and item information
        $test_info = DB::table("radt_invoicedtl_app_wl_vw as a")
            ->select(
                'item.item_no_pk',
                'a.item_name',
                'a.invoice_date',
                'a.img_app_dttm',
                'a.room_name',
                'a.serviceunit_no_fk',
                'a.radinvoicedtl_no_pk',
                'a.invoice_no_pk',
                'a.room_no_fk'
            )
            ->join('sysc_serviceitem as item', 'a.item_code', '=', 'item.item_code')
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where("invoice_no_pk", $invoice_id)
            ->whereNull('cancel_ind')
            ->get();

        // Group items by item_id and room, and check if they are booked
        $groupedItems = [];

        foreach ($test_info as $row) {
            $itemId = (int) $row->item_no_pk;
            $radinvoicedtl_no_pk = (int) $row->radinvoicedtl_no_pk;

            // Check if the item is already booked for this invoice
            $bookedItems = $this->getBookedItems($radinvoicedtl_no_pk, $itemId);
            // If there are booked items, we need to set `is_booked` and add the booking times
            $isBooked = count($bookedItems) > 0 ? true : false;

            if (!isset($groupedItems[$itemId])) {
                $groupedItems[$itemId] = [
                    'item_no_pk' => $row->item_no_pk,
                    'radinvoicedtl_no_pk' => $radinvoicedtl_no_pk,
                    'item_name' => $row->item_name,
                    'rooms' => [],
                    'is_booked' => $isBooked,
                    'bookings' => []  // Array to hold booking details (start and end times)
                ];
            }

            // Add booking details to the grouped items
            foreach ($bookedItems as $bookedItem) {
                $groupedItems[$itemId]['bookings'][] = [
                    'start_time' => $bookedItem->shed_str_time,
                    'end_time' => $bookedItem->shed_end_time
                ];
            }

            // Add room details to the grouped items
            $groupedItems[$itemId]['rooms'][] = [
                'room_no_fk' => $row->room_no_fk,
                'name' => $row->room_name,
                'blockedSlots' => [] // Placeholder for future slot block functionality
            ];
        }
        // Return grouped items in the response
        return response()->json([
            'success' => true,
            'items' => array_values($groupedItems)  // Re-index array to remove associative keys
        ]);
    }


    public function bookSlot(Request $request)
    {
        DB::beginTransaction();

        try {
            // 1️⃣ Validate incoming request
            $request->validate([
                // 'id' => 'required|numeric',
                'start' => 'required',
                'end' => 'required',
                // 'app_id' => 'required',
                // 'selectedInvoiceHidden' => 'required'
            ]);

            // 2️⃣ Safe date parsing
            $appoint_date = now()->format('Y/m/d'); // Default today

            if (!empty($request->radio_appointment_date)) {
                $appoint_date = date('Y/m/d', strtotime($request->radio_appointment_date));
            } elseif (!empty($request->date)) {
                $appoint_date = date('Y/m/d', strtotime($request->date));
            }

            // 3️⃣ Fetch appointment details (with error handling)
            if ($request->app_id != '') {

                $details_data = DB::table('RADT_INVOICEDTL_APP_WL_VW')
                    ->select(
                        'patient_no_fk',
                        'patient_name',
                        'serviceunit_no_fk',
                        'radinvoicedtl_no_pk',
                    )
                    ->where('invoice_code', $request->app_id)
                    ->first();

                if (!$details_data) {
                    return response()->json(['success' => false, 'message' => '❌ Appointment details not found'], 404);
                }
            }

            // 4️⃣ Prepare values
            $sequence = DB::getSequence();
            $pat_shedule_no_pk_seq = $sequence->nextValue('pat_shedule_no_pk_seq');
            if ($request->app_id != '') {
                $insertData = [
                    'pat_shedule_no_pk' => $pat_shedule_no_pk_seq,
                    'pat_shedule_uid' => $pat_shedule_no_pk_seq,
                    'radt_app_sl' => $request->serial,
                    'shed_str_time' => $request->start,
                    'shed_end_time' => $request->end,
                    'patient_no_fk' => $details_data->patient_no_fk,
                    'patient_name' => $details_data->patient_name,
                    'su_no_fk' => $details_data->serviceunit_no_fk,
                    'room_no_fk' => $request->roomId,
                    'appoint_date' => $appoint_date,
                    'radinvoicedtl_no_fk' => $request->radinvoicedtl_no_pk,
                    'invoice_no_fk' => $request->selectedInvoiceHidden,
                    'item_no_fk' => $request->selectedItemId,
                ];
            } else {
                $insertData = [
                    'pat_shedule_no_pk' => $pat_shedule_no_pk_seq,
                    'pat_shedule_uid' => $pat_shedule_no_pk_seq,
                    'radt_app_sl' => $request->serial,
                    'shed_str_time' => $request->start,
                    'shed_end_time' => $request->end,
                    'room_no_fk' => $request->roomId,
                    'appoint_date' => $appoint_date,
                    'item_no_fk' => $request->selectedItemId,
                    'patient_no_fk' => $request->patentIdHidden,
                ];
            }


            // 5️⃣ Insert into schedule table
            DB::table('radt_pat_shedule')->insert($insertData);

            DB::commit();

            if ($request->app_id != '') {
                return response()->json(['success' => true, 'message' => '✅ Schedule booked successfully!', 'insert_id' => $details_data->radinvoicedtl_no_pk]);
            } else {
                return response()->json(['success' => true, 'message' => '✅ Schedule booked successfully!', 'insert_id' => $pat_shedule_no_pk_seq, 'notbiller' => $pat_shedule_no_pk_seq]);
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['success' => false, 'message' => '❌ Error: ' . $e->getMessage()], 500);
        }
    }

    public function fetchRoomWiseSlots(Request $request)
    {
        $itemId = $request->item_no_pk;
        $invoiceNo = $request->selectedInvoiceHidden;
        $scheduleDate = $request->scheduleDate ?? Carbon::today()->toDateString();
        $radinvoicedtl_no_pk = '';
        if ($invoiceNo) {
            $radinvoicedtl_no_pk = DB::table("radt_invoicedtl_app_wl_vw as a")
                ->select(
                    'a.radinvoicedtl_no_pk'
                )
                ->join('sysc_serviceitem as item', 'a.item_code', '=', 'item.item_code')
                ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->where("invoice_no_pk", $invoiceNo)
                ->where("item.item_no_pk", $itemId)
                ->whereNull('cancel_ind')
                ->first()->radinvoicedtl_no_pk;
        }



        // === Get All Rooms for Item ===
        $schedules = DB::table("RADT_ROOM_SHEDULESETUP_UHL")
            ->where('item_no_fk', $itemId)
            ->join('sysc_room', 'room_no_fk', 'room_no_pk')
            ->select('room_no_fk', 'room_name', 'start_time', 'end_time', 'avg_time')
            ->get();

        if ($schedules->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'No schedule found for selected item'
            ]);
        }

        $rooms = [];

        foreach ($schedules as $schedule) {
            $startTime = $schedule->start_time;
            $endTime = $schedule->end_time;
            $avg_interval = $schedule->avg_time;

            $start = Carbon::createFromFormat('H:i', $startTime);
            $end = Carbon::createFromFormat('H:i', $endTime);

            $intervals = [];

            // === Create Time Intervals ===
            while ($start < $end) {
                $nextStart = $start->copy()->addMinutes($avg_interval);
                if ($nextStart > $end) {
                    break;
                }

                $intervals[] = [
                    'time' => $start->format('H:i'),
                    'label' => $start->format('h:i A') . ' - ' . $nextStart->format('h:i A')
                ];

                $start = $nextStart;
            }

            // === Fetch Booked Slots for Each Room ===
            $date = date('Y-m-d');
            $bookedSlots = DB::table('RADT_PAT_SHEDULE')
                ->where('room_no_fk', $schedule->room_no_fk)
                ->where('item_no_fk', $itemId)
                ->where('appoint_date', $scheduleDate)
                // ->where('radinvoicedtl_no_fk', $invoiceNo)  // Uncomment if needed
                ->select('SHED_STR_TIME', 'SHED_END_TIME')
                ->get();

            // === Mark Slots as Blocked or Available ===
            $slots = array_map(function ($interval) use ($bookedSlots) {
                $isBlocked = false;

                // Check if the slot time falls within any of the booked time ranges
                foreach ($bookedSlots as $bookedSlot) {
                    $bookedStart = Carbon::createFromFormat('H:i', $bookedSlot->shed_str_time);
                    $bookedEnd = Carbon::createFromFormat('H:i', $bookedSlot->shed_end_time);
                    $slotTime = Carbon::createFromFormat('H:i', $interval['time']);

                    // FIX: Only block if slot starts inside booking range (end exclusive)
                    if ($slotTime >= $bookedStart && $slotTime < $bookedEnd) {
                        $isBlocked = true;
                        break;
                    }
                }

                return [
                    'time' => $interval['label'],
                    'blocked' => $isBlocked
                ];
            }, $intervals);

            // Add room information to the response
            $rooms[] = [
                'room_name' => $schedule->room_name,
                'room_no_fk' => $schedule->room_no_fk,
                'radinvoicedtl_no_pk' => $radinvoicedtl_no_pk,
                'slots' => $slots
            ];
        }

        // Return JSON Response with room and slot data
        return response()->json([
            'success' => true,
            'rooms' => $rooms
        ]);
    }


    public function fetchBookedSlots(Request $request)
    {
        $itemId = $request->item_id;
        $invoice = $request->inv_voucher_no;
        $date = $request->appointment_date;

        // ধরুন আপনি RadiologyAppointment model এ item_id, inv_voucher_no, appointment_date এই data আছে
        $bookedSlots = RadiologyAppointment::where('item_id', $itemId)
            ->where('inv_voucher_no', $invoice)
            ->where('appointment_date', $date)
            ->pluck('start_time') // ধরুন start_time = "09:15"
            ->toArray();

        return response()->json([
            'booked_slots' => $bookedSlots
        ]);
    }


    public function getRoomScheduleByItem(Request $request)
    {
        // Assuming $test_info is provided from a DB query or passed in
        $groupedItems = [];

        foreach ($test_info as $row) {
            $itemName = $row->item_name;
            $itemId = (int) $row->item_no_pk;
            $radinvoicedtl_no_pk = (int) $row->radinvoicedtl_no_pk;

            // Check if the item is already booked for this invoice
            $bookedItems = $this->getBookedItems($radinvoicedtl_no_pk, $itemId);
            $isBooked = count($bookedItems) > 0;

            if (!isset($groupedItems[$itemName])) {
                $groupedItems[$itemName] = [
                    'item_name' => $itemName,
                    'item_no_pk' => $itemId,
                    'radinvoicedtl_no_pk' => $radinvoicedtl_no_pk,
                    'rooms' => [],
                    'is_booked' => $isBooked,
                    'bookings' => []
                ];
            }

            // Add booking details
            foreach ($bookedItems as $bookedItem) {
                $groupedItems[$itemName]['bookings'][] = [
                    'start_time' => $bookedItem->shed_str_time,
                    'end_time' => $bookedItem->shed_end_time
                ];
            }

            // Add room details
            $groupedItems[$itemName]['rooms'][] = [
                'room_no_fk' => $row->room_no_fk,
                'name' => $row->room_name,
                'blockedSlots' => []
            ];
        }

        return response()->json([
            'success' => true,
            'items' => array_values($groupedItems)
        ]);
    }

    public function getPrerequisition(Request $request)
    {
        $item_id = $request->input('item_id');

        // প্রি-রিকুইজিশন তথ্য আনছি
        $data = DB::table('RADT_ROOM_SHEDULESETUP_UHL')
            ->where('ITEM_NO_FK', $item_id)
            ->first();

        if ($data) {
            return response()->json([
                'success' => true,
                'pre_requisition' => $data->pre_requisition ?? []
            ]);
        } else {
            return response()->json([
                'success' => false,
                'message' => 'No pre-requisition found for this item.'
            ]);
        }
    }

    public function getRoomSchedule(Request $request)
    {
        $itemId = $request->item_id;
        $scheduleDate = $request->schedule_date ?? Carbon::today()->toDateString();

        $schedules = DB::table("RADT_ROOM_SHEDULESETUP_UHL")
            ->where('item_no_fk', $itemId)
            ->whereDate('appoint_date', $scheduleDate) // ✅ Must be present in your table
            ->join('sysc_room', 'room_no_fk', '=', 'room_no_pk')
            ->select('room_no_fk', 'room_name', 'start_time', 'end_time', 'avg_time')
            ->get();

        return response()->json([
            'success' => true,
            'data' => $schedules
        ]);
    }

    // Radiology Server-side DataTables
    public function radiologyDeliveryV3(Request $request)
    {
        // dd($request->all());
        $invoice_id = $request->invoice_id;
        $service_unit = $request->service_unit;
        $hdn_admission_id = $request->hdn_admission_id;

        // Build query
        $item_list = DB::table('radt_invoicedtl_app_wl_vw as a')
            ->join('pat_registration_wl_vw as b', 'a.patient_no_fk', '=', 'b.patient_no_pk')
            ->leftJoin('WSEC_HOSPITAL', 'a.au_entry_hospital_pk_no', '=', 'WSEC_HOSPITAL.HOSPITAL_NO_pK')
            ->select(
                'a.radinvoicedtl_no_pk',
                'a.invoice_no_pk',
                'a.invoice_code',
                'a.admission_no_pk',
                'a.item_name',
                'a.ic_image_capture_keyed_time',
                'a.delivery_dttm',
                'a.status',
                'a.finalize_key_ind',
                'a.verify_key_ind',
                'a.result_prepared_key_ind',
                'b.patient_name',
                // 'a.sms_ind',
                // 'a.mail_ind',
                // 'a.email'
            )
            ->where('a.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('a.finalize_key_ind', 1)
            ->whereNull('a.cancel_ind')
            ->orderBy('a.invoice_no_pk', 'desc');

        if (!empty($invoice_id)) {
            $item_list->where('a.invoice_code', $invoice_id);
        }
        if (!empty($service_unit)) {
            $item_list->where('a.service_unit_no_fk', $service_unit);
        }
        if (!empty($hdn_admission_id)) {
            $item_list->where('a.admission_no_pk', $hdn_admission_id);
        }

        $data = $item_list->get();

        // Inject due amounts
        $dueService = app('App\Http\Controllers\EMRController');
        $totalDue = $dueService->dueCalculate($invoice_id);
        // Map rows for DataTables
        $data = $data->map(function ($row, $index) {
            $rowClass = $row->status == 2 ? 'bg-warning text-black' : '';
            $statusBadge = '';
            if ($row->finalize_key_ind) $statusBadge = '<span class="badge bg-success">Finalized</span>';
            else if ($row->verify_key_ind) $statusBadge = '<span class="badge bg-primary">Verified</span>';
            else if ($row->result_prepared_key_ind) $statusBadge = '<span class="badge bg-warning text-dark">Prepared</span>';
            else $statusBadge = '<span class="badge bg-secondary">Pending</span>';

            return [
                'DT_RowIndex' => $index + 1,
                'select_checkbox' => '<input type="checkbox" value="' . $row->radinvoicedtl_no_pk . '"/>',
                'invoice_code' => $row->invoice_code,
                'admission_no_pk' => $row->admission_no_pk,
                'item_name' => $row->item_name,
                'receive_by' => $row->ic_image_capture_keyed_time ?? '-',
                'delivery_by' => $row->delivery_dttm ?? '-',
                'status' => $statusBadge,
                'patient_name' => $row->patient_name,
                // 'email' => $row->email,
                'radinvoicedtl_no_pk' => $row->radinvoicedtl_no_pk,
                'rowClass' => $rowClass
            ];
        });

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $data->count(),
            'totalDue' => $totalDue,
            'recordsFiltered' => $data->count(),
            'data' => $data
        ]);
    }

    public function radiologyAppointmentStatusData()
    {
        //  $table = 'RADT_SCHEDULE_STATUS_VW';
        // // Table's primary key
        // $primaryKey = 'invoice_no_pk';
        // $to_date = date('Y-m-d');
        // $hospital_id =  Session::get('user.ses_hospital_no_pk');
        // $where = "trunc(INVOICE_DATE) = '$to_date' and au_entry_hospital_pk_no =$hospital_id  "; //and module_code in ('OPD','OPDC','HSPOS') and (not serviceunit_name='IPD')and module_code in ('OPD','OPDC','HSPOS') and (not serviceunit_name='IPD')

        // $columns = array(
        //     array('db' => 'patient_code', 'dt' => 0),
        //     array('db' => 'patient_name', 'dt' => 1),
        //     array('db' => 'img_app_dttm', 'dt' => 2),
        //     array('db' => 'shed_str_time', 'dt' => 3),
        //     array('db' => 'item_name', 'dt' => 4),
        //     array('db' => 'room_name', 'dt' => 4),
        //     array('db' => 'serviceunit_name', 'dt' => 4),
        //     array('db' => 'age', 'dt' => 5),
        //     array('db' => 'gender_txt', 'dt' => 6),
        //     array('db' => 'RADT_APP_SL', 'dt' => 7),
        //     array('db' => 'report_status', 'dt' => 8),

        // );

        // if (!empty($where)) {
        //     echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
        // } else {

        //     echo json_encode(DataTableClass::simple($request, $table, $primaryKey, $columns));
        // }
        $data = DB::table('RADT_SCHEDULE_STATUS_VW')
            ->select(
                'patient_code',
                'patient_name',
                'img_app_dttm',
                'shed_str_time',
                'item_name',
                'room_name',
                'serviceunit_name',
                'age',
                'gender_txt',
                'RADT_APP_SL',
                'report_status',
                'appoint_date'
            )
            ->whereBetween(DB::raw('TRUNC(appoint_date)'), [
                Carbon::now()->subDays(6)->toDateString(), // আজ থেকে ৬ দিন আগে
                Carbon::now()->toDateString()              // আজকের তারিখ
            ])
            ->get();

        return response()->json($data);
    }

    public function radiologyLifeCycle(Request $request)
    {
        return Template::loadview("admin.investigation_cancel.v1.radiology_sample_collection_life_cycle_list_v1");
    }

    public function radiologyLifeCyclegetData(Request $request)
    {
        $table = 'RADT_INVOICEDTL_STEP_CAN_VW';
        $primaryKey = 'radinvoicedtl_no_pk';
        $hospital_id = Session::get('user.ses_hospital_no_pk');
        $where = "nvl(CANCEL_IND,0) = 0";

        $columns = [
            ['db' => 'invoice_code', 'dt' => 0],
            ['db' => 'patient_name', 'dt' => 1],
            ['db' => 'patient_code', 'dt' => 2],
            ['db' => 'item_name', 'dt' => 3],
            ['db' => 'ic_image_capture_keyed_time', 'dt' => 4],
            ['db' => 'report_rcv_by', 'dt' => 5],
            ['db' => 'result_ent_keyed_time', 'dt' => 6],
            ['db' => 'result_verify_keyed_time', 'dt' => 7],
            ['db' => 'result_final_keyed_time', 'dt' => 8],
            ['db' => 'report_delivary_date', 'dt' => 9],
            ['db' => 'report_delivary_date', 'dt' => 10], // for receive at delivery
            ['db' => 'report_delivary_date', 'dt' => 11], // for report delivery
        ];

        echo json_encode(DataTableClass::complex($request, $table, $primaryKey, $columns, null, $where));
    }


    protected function formatDate($dateString)
    {
        $myDateTime = DateTime::createFromFormat('d/m/Y', $dateString);
        return $myDateTime->format('Y-m-d');
    }

    /**
     * Filter Laboratory Life Cycle
     */
    public function radiologyLifeCyclefilter(Request $request)
    {
        $invoice_id = $request->input('invoice_id');
        $patient_code = $request->input('patient_code');
        $lab_id = $request->input('lab_id');
        $search_date_from = $request->input('search_date_from') != "" ? $this->formatDate($request->input('search_date_from')) : '';
        $search_date_to = $request->input('search_date_to') != "" ? $this->formatDate($request->input('search_date_to')) : '';

        $items = DB::table('RADT_INVOICEDTL_STEP_CAN_VW')
            ->select(
                'invoice_code',
                'patient_name',
                'patient_code',
                'item_name',
                'ic_image_capture_keyed_time',
                'report_rcv_by',
                'result_ent_keyed_time',
                'result_verify_keyed_time',
                'result_final_keyed_time',
                'report_delivary_date',
                'report_delivary_date',
                'report_delivary_date'
            );

        if (!empty($invoice_id)) {
            $items->where('invoice_code', $invoice_id);
        }

        if (!empty($patient_code)) {
            $items->where('radt_invoicedtl_step_can_vw.patient_code', $patient_code);
        }

        if (!empty($lab_id)) {
            $items->where('lab_code', $lab_id);
        }

        if (!empty($search_date_from)) {
            $items->whereDate('invoice_date', '>=', $search_date_from);
        }

        if (!empty($search_date_to)) {
            $items->whereDate('invoice_date', '<=', $search_date_to);
        }

        $items = $items
            ->whereRaw('nvl(CANCEL_IND,0) = 0')
            ->orderByDesc('invoice_date')
            ->get();

        return Template::loadview("admin.investigation_cancel.v1.path_sample_collection_life_cycle_table_filter_v1", ['items' => $items]);
    }

    // Report Setup Part
    // View Load Function
    public function labelPrintPage()
    {
        return Template::loadview('admin.radiology_v2.reportEntry.label_print');
    }

    // Ajax Data Load Function
    public function fetchLabelPrintData(Request $request)
    {
        $query = DB::table('radt_invoicedtl_app_wl_vw a')
            ->join("pat_registration_wl_vw b", "a.patient_no_fk", "b.patient_no_pk")
            ->select(
                'a.invoice_code',
                'a.invoice_no_pk',
                'a.patient_no_fk',
                'a.radinvoicedtl_no_pk',
                "b.gender_txt",
                "b.patient_name",
                "b.patient_photo",
                "b.patient_code",
                'a.serviceunit_name',
                'a.item_name'
            );

        if ($request->filled('invoice_id')) {
            $query->where('a.invoice_code', $request->invoice_id);
        } else {
            $query->limit(100)->orderByDesc('invoice_no_pk');
        }

        $items = $query->get();
        return response()->json($items);
    }



    public function lPrintSearch(Request $request)
    {
        $invoice_id = $request->invoice_id;
        $items = DB::table('RADT_INVOICEDTL_STEP_CAN_VW')
            ->select(
                'invoice_code',
                'patient_name',
                'patient_code',
                'item_name',
                'ic_image_capture_keyed_time',
                'report_rcv_by',
                'result_ent_keyed_time',
                'result_verify_keyed_time',
                'result_final_keyed_time',
                'report_delivary_date',
                'sms_ind'
            )->join('wsec_hostpital', 'AU_ENTRY_HOSPITAL_NO_FK', 'AU_ENTRY_HOSPITAL_NO_pK')
            ->where('invoice_code', $invoice_id)
            ->get();
        return response()->json($items);
    }

    public function getTrnId($inv_id)
    {
        $t_id = DB::table('FINC_LEDGERMST')->select('ledgertrn_no_fk')->where('invoice_no_fk', $inv_id)->first();
        $t_id = $t_id->ledgertrn_no_fk;
        return $t_id;
    }


    public function ReportDeliveryv3()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $todate = date('Y-m-d');
        if (Session::get('user.ses_hospital_code') == "IMPERIAL") {
            $pathology_data = DB::select(DB::raw("select * from pat_report_del_vw
            where admission_uid is null and report_rcb_ind = 1 and invoice_date between '$todate' and to_char (sysdate + 1) order by invoice_date desc"));

            $radiology_data = db::select(db::raw("select * from RADT_REPORT_PROCEES_VW where admission_uid  is null and report_rcb_ind = 1 and invoice_date between '$todate' and to_char (sysdate + 1)"));
        } else {
            $pathology_data = []; // DB::select(DB::raw("select * from pat_report_del_vw where admission_uid  is null and report_rcb_ind = 1  and invoice_date between to_char (sysdate - 7) and to_char (sysdate + 1) order by invoice_date desc"));
            $radiology_data = []; // db::select(db::raw("select * from RADT_REPORT_PROCEES_VW where admission_uid  is null and report_rcb_ind = 1 and invoice_date between to_char (sysdate - 7) and to_char (sysdate + 1)"));
        }
        // dd( $pathology_data);
        $ind_flag = 2;
        $type = 2;

        return Template::loadView('admin.radiology.report_delivery.report_deliveryv3', [
            'pathology' => $pathology_data,
            'radiology' => $radiology_data,
            'ind_flag' => $ind_flag,
            'type' => $type
        ]);
    }

    public function pathologyDeliveryV3(Request $request)
    {
        $hospital_pk = Session::get('user.ses_hospital_no_pk');

        // Input Parameters
        $invoice_id = $request->input('invoice_id');
        $hdn_admission_id = $request->input('hdn_admission_id');
        $patient_id = $request->input('patient_id');
        $from_date = $request->input('search_date_from');
        $to_date = $request->input('search_date_to');
        // Format Dates
        $from = $from_date ? \Carbon\Carbon::createFromFormat('d-m-Y', $from_date)->startOfDay() : \Carbon\Carbon::now()->subDays(30)->startOfDay();
        $to = $to_date ? \Carbon\Carbon::createFromFormat('d-m-Y', $to_date)->endOfDay() : \Carbon\Carbon::now()->endOfDay();

        $table = 'labt_invoicedtl_vw';

        // Build base query
        $query = DB::table($table)
            ->select('labt_invoicedtl_vw.*', 'finc_invoicemst.patient_code', 'finc_invoicemst.customer_name as patient_name', 'labt_testreporting.report_delivered_ind')
            ->leftJoin('finc_invoicemst', 'finc_invoicemst.invoice_no_pk', '=', 'labt_invoicedtl_vw.invoice_no_fk')
            ->leftjoin('labt_testreporting', 'labt_testreporting.report_no_pk', '=', 'labt_invoicedtl_vw.report_no_fk')
            ->where('labt_invoicedtl_vw.au_entry_hospital_pk_no', $hospital_pk)
            ->where('labt_invoicedtl_vw.lab_result_final_key_ind', 1)
            ->whereNull('labt_invoicedtl_vw.cancel_ind')
            ->whereBetween('labt_invoicedtl_vw.lab_result_final_keyed_time', [$from, $to]);

        if (!empty($invoice_id)) {
            $query->where('labt_invoicedtl_vw.invoice_no_fk', $invoice_id);
        }
        if (!empty($patient_id)) {
            $query->where('labt_invoicedtl_vw.patient_no_fk', $patient_id);
        }
        if (!empty($hdn_admission_id)) {
            $query->where('labt_invoicedtl_vw.admission_no_pk', $hdn_admission_id);
        }

        $data = $query->orderBy('labt_invoicedtl_vw.lab_result_final_keyed_time', 'desc')->get();
        // Inject due amounts
        $dueService = app('App\Http\Controllers\EMRController');
        $totalDue = $dueService->dueCalculate($invoice_id);

        // Inject full route URL
        foreach ($data as $row) {
            if (!empty($row->report_url) && !empty($row->report_no_fk)) {
                // Generate Laravel route directly
                $row->print_url = route($row->report_url, $row->report_no_fk);
            } else {
                $row->print_url = null;
            }
        }

        return response()->json([
            'draw' => intval($request->input('draw')),
            'recordsTotal' => $data->count(),
            'recordsFiltered' => $data->count(),
            'total_due' => $totalDue,
            'data' => $data
        ]);
    }
    public function resultEntryMultiplePdf(Request $request)
    {
        try {
            $radinvoicedtl_ids = $request->input('ids', []);

            // যদি string আসে, explode করে array বানানো
            if (!is_array($radinvoicedtl_ids)) {
                $radinvoicedtl_ids = explode(',', $radinvoicedtl_ids);
            }

            if (empty($radinvoicedtl_ids)) {
                return response()->json(['status' => 'error', 'message' => 'No reports selected']);
            }

            $pdfFiles = [];

            foreach ($radinvoicedtl_ids as $reportId) {
                $reportId = trim($reportId);

                // 🔹 Fetch report & appointment data
                $report = DB::table("radt_invoicedtl_app_wl_vw as a")
                    ->join("radt_reporting as b", "a.radinvoicedtl_no_pk", "b.radinvoicedtl_no_fk")
                    ->where("a.radinvoicedtl_no_pk", $reportId)
                    ->first();

                // $patient_info = DB::table('patn_registration')
                //     ->where('patient_no_pk', $report->patient_no_fk)
                //     ->first();
                $patient_info = DB::table("finc_voucherwise_vw a")
                    ->select("a.invoice_code", "b.patient_code", "b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "a.first_ref_doc_name", "b.salutation", "b.passport_no", DB::raw('pat_age(b.dob,nvl(dod,sysdate))pat_age'))
                    ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                    ->where("a.invoice_code", $report->invoice_code)->first();


                $po_hospital_details = DB::table("wsec_hospital")->first();

                // 🔹 Generate barcodes
                $barcode = new BarcodeGenerator();
                $barcode->setText($report->rad_report_uid);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $app_barcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setLabel('');
                $barcode1->setScale(1);
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_barcode = $barcode1->generate();
                // 🔹 Generate PDF
                $filePath = storage_path("app/reports/radiology_{$reportId}_" . uniqid() . ".pdf");

                SnappyPDF::loadView('admin.radiology.reports.radiology_report_v1', [
                    'radiology_appointment_data' => $report,
                    'app_barcode' => $app_barcode,
                    'invoice_barcode' => $invoice_barcode,
                    'patient_info' => $patient_info,
                    'po_hospital_details' => $po_hospital_details
                ])
                    ->setOption('encoding', 'UTF-8')
                    ->setOption('enable-local-file-access', true)
                    ->setOption('margin-top', 90)       // header height
                    ->setOption('margin-bottom', 30)
                    ->setOption('margin-left', 10)
                    ->setOption('margin-right', 10)
                    ->setOption('header-html', view('pdf.rad_header', [
                        'radiology_appointment_data' => $report,
                        'app_barcode' => $app_barcode,
                        'invoice_barcode' => $invoice_barcode,
                        'patient_info' => $patient_info,
                        'po_hospital_details' => $po_hospital_details
                    ])->render())
                    ->setOption('header-spacing', 10)
                    ->setOption('footer-html', view('pdf.rad_footer')->render())
                    ->setPaper('a4')
                    ->save($filePath);

                $pdfFiles[] = $filePath;
            }

            if (empty($pdfFiles)) {
                return response()->json(['status' => 'error', 'message' => 'No PDFs generated'], 400);
            }
            $mergedFile = storage_path("app/reports/radiology_merged_" . time() . ".pdf");
            $fpdi = new \setasign\Fpdi\Fpdi();

            foreach ($pdfFiles as $file) {
                $pageCount = $fpdi->setSourceFile($file);
                for ($pageNo = 1; $pageNo <= $pageCount; $pageNo++) {
                    $tplId = $fpdi->importPage($pageNo);
                    $size = $fpdi->getTemplateSize($tplId);
                    $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
                    $fpdi->AddPage($orientation, [$size['width'], $size['height']]);
                    $fpdi->useTemplate($tplId);
                }
            }

            $fpdi->Output($mergedFile, 'F');

            return response()->download($mergedFile, 'radiology_merged.pdf');
        } catch (\Exception $e) {
            return response()->json(['msg' => $e->getMessage(), 'title' => 'Error']);
        }
    }

    public function resultEntryMultipleEmail(Request $request)
    {
        try {
            $reportIds = $request->input('ids', []);
            if (!is_array($reportIds)) {
                $reportIds = explode(',', $reportIds);
            }

            if (empty($reportIds)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No reports selected'
                ]);
            }

            $pdfFiles = [];
            $patients = [];
            $po_hospital_details = DB::table("wsec_hospital")->first();
            foreach ($reportIds as $reportId) {
                $report = DB::table("radt_invoicedtl_app_wl_vw as a")
                    ->join("radt_reporting as b", "a.radinvoicedtl_no_pk", "b.radinvoicedtl_no_fk")
                    ->where("a.radinvoicedtl_no_pk", $reportId)
                    ->first();


                if (!$report) continue;

                $patient_info = DB::table("finc_voucherwise_vw a")
                    ->select("b.patient_no_pk", "a.invoice_code", "b.email", "b.patient_code", "b.patient_name", "b.age", "b.gender_txt", "b.blood_group", "b.marital_status_txt", "b.patient_photo", "a.first_ref_doc_name", "b.salutation", "b.passport_no", DB::raw('pat_age(b.dob,nvl(dod,sysdate))pat_age'))
                    ->leftJoin("pat_registration_wl_vw b", "a.patient_no_fk", "=", "b.patient_no_pk")
                    ->where("patient_no_pk", $report->patient_no_fk)
                    ->first();
                if (!$patient_info || empty($patient_info->email)) continue;

                // 🔹 Generate barcodes
                $barcode = new BarcodeGenerator();
                $barcode->setText($report->rad_report_uid);
                $barcode->setType(BarcodeGenerator::Code128);
                $barcode->setLabel('');
                $barcode->setScale(1);
                $barcode->setThickness(25);
                $barcode->setFontSize(10);
                $app_barcode = $barcode->generate();

                $barcode1 = new BarcodeGenerator();
                $barcode1->setText($report->invoice_code);
                $barcode1->setType(BarcodeGenerator::Code128);
                $barcode1->setLabel('');
                $barcode1->setScale(1);
                $barcode1->setThickness(25);
                $barcode1->setFontSize(10);
                $invoice_barcode = $barcode1->generate();

                $patients[$patient_info->patient_no_pk] = $patient_info;

                // 🔹 Generate individual PDF with Snappy
                $pdf = SnappyPDF::loadView('admin.radiology.reports.radiology_report_v1', [
                    'radiology_appointment_data' => $report,
                    'patient_info' => $patient_info,
                    'app_barcode' => $app_barcode,
                    'invoice_barcode' => $invoice_barcode,
                    'po_hospital_details' => $po_hospital_details
                ])
                    ->setOption('encoding', 'UTF-8')
                    ->setOption('enable-local-file-access', true)
                    ->setOption('margin-top', 90)       // header height
                    ->setOption('margin-bottom', 30)
                    ->setOption('margin-left', 10)
                    ->setOption('margin-right', 10)
                    ->setOption('header-html', view('pdf.rad_header', [
                        'radiology_appointment_data' => $report,
                        'app_barcode' => $app_barcode,
                        'invoice_barcode' => $invoice_barcode,
                        'patient_info' => $patient_info,
                        'po_hospital_details' => $po_hospital_details
                    ])->render())
                    ->setOption('header-spacing', 10)
                    ->setOption('footer-html', view('pdf.rad_footer')->render())
                    ->setPaper('a4');

                $pdfPath = storage_path("app/reports/rad_report_{$report->radinvoicedtl_no_pk}_" . uniqid() . ".pdf");

                $pdf->save($pdfPath);

                if (file_exists($pdfPath)) {
                    $pdfFiles[$patient_info->patient_no_pk][] = $pdfPath;
                }
            }
            if (empty($pdfFiles)) {
                return response()->json([
                    'status' => 'error',
                    'message' => 'No PDFs generated'
                ]);
            }

            // 🔹 Merge PDFs with FPDI and send email per patient
            foreach ($patients as $patientId => $patient_info) {
                if (!isset($pdfFiles[$patientId])) continue;

                $mergedPdfPath = storage_path("app/reports/radiology_merged_{$patientId}_" . uniqid() . ".pdf");
                $fpdi = new \setasign\Fpdi\Fpdi();

                foreach ($pdfFiles[$patientId] as $file) {
                    if (!file_exists($file)) continue;

                    $pageCount = $fpdi->setSourceFile($file);
                    for ($i = 1; $i <= $pageCount; $i++) {
                        $tplId = $fpdi->importPage($i);
                        $size = $fpdi->getTemplateSize($tplId);
                        $orientation = $size['width'] > $size['height'] ? 'L' : 'P';
                        $fpdi->AddPage($orientation, [$size['width'], $size['height']]);
                        $fpdi->useTemplate($tplId);
                    }
                }

                $fpdi->Output($mergedPdfPath, 'F');

                if (!file_exists($mergedPdfPath)) continue;

                // 🔹 Send email
                $subject = "Your Radiology Reports from {$po_hospital_details->hospital_name}";
                $messageBody = "Dear Patient,<br><br>
                Your radiology report(s) are ready. Please find attached.<br><br>
                Regards,<br>
                {$po_hospital_details->hospital_name}";

                Mail::raw($messageBody, function ($message) use ($patient_info, $subject, $mergedPdfPath) {
                    $message->to($patient_info->email)
                        ->subject($subject)
                        ->attach($mergedPdfPath, [
                            'as' => 'Radiology_Reports.pdf',
                            'mime' => 'application/pdf'
                        ]);
                });
            }

            return response()->json(['status' => 'success', 'message' => 'Emails sent successfully']);
        } catch (\Exception $e) {
            return response()->json(['status' => 'error', 'message' => $e->getMessage()]);
        }
    }

    public function batchPrint(Request $request)
    {
        $reportIds = explode(',', $request->reports);
        $invoice_id = '';
        if (!empty($reportIds)) {
            $invoice_id = DB::table('labt_invoicedtl')
                ->where('REPORT_NO_FK', $reportIds[0])
                ->value('invoice_no_fk');
        }

        $auth_id = Auth::id();
        $to_date = date('Y-m-d');
        $po_hospital_details = DB::table("wsec_hospital")->first();
        $report_header_arr = [];

        $report_url_sig = DB::select("select REPORT_NO_FK, REPORT_URL from labt_invoicedtl_vw where invoice_no_fk = ?", [$invoice_id]);

        try {
            $report_headers = DB::select("select INVOICE_CODE, PATIENT_CODE, REPORT_NO_PK, REPORT_CODE, PATIENT_NAME, AGE, DOB, GENDER_TXT, REF_DOC_NAME, REF_DOC_NAME_DEGREE1, REF_DOC_NAME_DEGREE2, REF_DOC_NAME_DEGREE3, WARD_NAME, BED_NAME, PASSPORT_NO, SAM_NAME, ADMISSION_NO_PK, LAB_CODE, ORDER_DATE, ITEM_CODE_LIST, REPORT_TEST_NAME_LIST, SC_SAMPLE_COLL_KEYED_TIME, SERVICEUNIT_NAME, ANALYZER_DESC, TEST_METHOD, INTERPRETATION, COMMENTS_TEXT, NOTE_TEXT, PREPARED_BY, PR_DIGITAL_SIGNATURE_IND, PR_DOCTOR_SIGNATURE_IMAGE, PR_DOCTOR_SIGNATURE, VERIFIED_BY, RESULT_FINAL_KEYED_TIME, VR_DIGITAL_SIGNATURE_IND, VR_DOCTOR_SIGNATURE_IMAGE, VR_DOCTOR_SIGNATURE, FINALIZED_BY, FIN_DIGITAL_SIGNATURE_IND, FIN_DOCTOR_SIGNATURE_IMAGE, FIN_DOCTOR_SIGNATURE, ENT_DIGITAL_SIGNATURE_IND, ENT_DOCTOR_SIGNATURE_IMAGE, ENT_DOCTOR_SIGNATURE, histro_lab_id, histro_report_header from LABT_TESTREPORTRESULTPRINT_VW where INVOICE_CODE = ? and RESULT_FINAL_KEY_IND = 1", [$invoice_id]);

            if (!empty($report_headers)) {
                foreach ($report_headers as $r_header) {

                    // Fetch all report URLs for this report
                    $all_report_url = DB::select("select REPORT_NO_FK, REPORT_URL from labt_invoicedtl_vw where REPORT_NO_FK = ?", [$r_header->report_no_pk]);

                    // Normal report data
                    $report_data = DB::table("labt_testresultstruct_vw")
                        ->where('report_no_fk', $r_header->report_no_pk)
                        ->where('show_in_rep', 1)
                        ->whereNull('cancel_ind')
                        ->orderBy('sl_no', 'ASC')
                        ->orderBy('group_seq', 'ASC')
                        ->get();

                    // Microbiology report data
                    $report_data_mic = DB::table("LABT_TESTRESULTSTRUCT_MICRO_VW")
                        ->select('attr', 'result0', 'result1', 'result2')
                        ->where('report_no_fk', $r_header->report_no_pk)
                        ->where('show_in_rep', 1)
                        ->orderBy('teststruct_no_fk', 'ASC')
                        ->get()->toArray();

                    // Special report data
                    $report_data_1 = DB::table("LABT_TESTRESULTSTRUCT_MICRO_VW")
                        ->select('attr', 'result0', 'result1', 'result2')
                        ->where('report_no_fk', $r_header->report_no_pk)
                        ->where('show_in_rep', 1)
                        ->where('result0', 'S')
                        ->orderBy('sl_no', 'ASC')
                        ->get()->toArray();

                    $report_data_2 = DB::table("LABT_TESTRESULTSTRUCT_MICRO_VW")
                        ->select('attr', 'result0', 'result1', 'result2')
                        ->where('report_no_fk', $r_header->report_no_pk)
                        ->where('show_in_rep', 1)
                        ->where('result0', 'R')
                        ->orderBy('sl_no', 'ASC')
                        ->get()->toArray();

                    $report_data_3 = DB::table("labt_testresultstruct_vw")
                        ->where('report_no_fk', $r_header->report_no_pk)
                        ->where('show_in_rep', 1)
                        ->whereNull('cancel_ind')
                        ->orderBy('sl_no', 'ASC')
                        ->orderBy('group_seq', 'ASC')
                        ->get();

                    $report_label_query = DB::table("labt_testresultstruct_vw as labtvw")
                        ->join("sysc_serviceitem as sysvw", 'sysvw.item_code', '=', 'labtvw.analyzer_desc')
                        ->where('report_no_fk', $r_header->report_no_pk)
                        ->where('show_in_rep', 1)
                        ->orderBy('sl_no', 'ASC')
                        ->orderBy('group_seq', 'ASC')
                        ->first();

                    // Last report grouping
                    $report_data_last = DB::table("labt_testresultstruct_vw")
                        ->where('report_no_fk', $r_header->report_no_pk)
                        ->where('show_in_rep', 1)
                        ->skip(19)->take(32)
                        ->orderBy('sl_no', 'ASC')
                        ->get()->toArray();

                    $report_data_last_gmc = DB::table("labt_testresultstruct_vw")
                        ->where('report_no_fk', $r_header->report_no_pk)
                        ->where('show_in_rep', 1)
                        ->take(19)
                        ->orderBy('sl_no', 'ASC')
                        ->get()->toArray();

                    // Incubation / Micro data
                    $incuvation_dt = DB::select(DB::raw("SELECT dt1.lookupdata_name incubation_temp,
                        dt2.lookupdata_name incubation_condition,
                        dt3.lookupdata_name colony_count,
                        dt10.lookupdata_name colony_count_a,
                        dt11.lookupdata_name colony_count_b,
                        dt4.lookupdata_name incubation_time,
                        dt6.lookupdata_name sensitivity,
                        dt7.lookupdata_name biochemical_test,
                        dt8.lookupdata_name gram_stain_smear,
                        dt9.lookupdata_name microscope_examination,
                        lab.rbc,
                        lab.epithelialv,
                        lab.pus_cells,
                        lab.candida,
                        lab.comments_text
                   FROM labt_testreporting lab
                   LEFT JOIN sysc_lookupdata dt1 ON lab.incubation_temp = dt1.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt2 ON lab.incubation_condition = dt2.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt3 ON lab.colony_count = dt3.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt4 ON lab.incubation_time = dt4.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt6 ON lab.sensitivity = dt6.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt7 ON lab.biochemical_test = dt7.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt8 ON lab.gram_stain_smear = dt8.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt9 ON lab.microscope_examination = dt9.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt10 ON lab.COLONY_COUNT_A = dt10.lookupdata_no_pk
                   LEFT JOIN sysc_lookupdata dt11 ON lab.COLONY_COUNT_B = dt11.lookupdata_no_pk
                   WHERE lab.report_no_pk = :report_no"), ['report_no' => $r_header->report_no_pk]);

                    $note_text_clob = DB::table('labt_testreporting')
                        ->where('report_no_pk', $r_header->report_no_pk)
                        ->value('note_text_clob');

                    $attr_group = [];
                    foreach ($report_data as $value) {
                        $attr_group[$value->item_no_fk . '_' . $value->item_name . '_' . $value->item_code][$value->test_group_no_fk . '_' . $value->group_txt][] = $value;
                    }

                    $attr_group_last = [];
                    foreach ($report_data_last as $value_last) {
                        $attr_group_last[$value_last->test_group_no_fk . '_' . $value_last->group_txt][] = $value_last;
                    }

                    $attr_group_last_gmc = [];
                    foreach ($report_data_last_gmc as $value_last) {
                        $attr_group_last_gmc[$value_last->test_group_no_fk . '_' . $value_last->group_txt][] = $value_last;
                    }

                    // Barcode generation
                    $barcode = new BarcodeGenerator();
                    $barcode->setText($r_header->report_code);
                    $barcode->setType(BarcodeGenerator::Code128);
                    $barcode->setLabel('');
                    $barcode->setScale(1);
                    $barcode->setThickness(25);
                    $barcode->setFontSize(10);
                    $report_varcode = $barcode->generate();

                    $barcode1 = new BarcodeGenerator();
                    $barcode1->setText($r_header->invoice_code);
                    $barcode1->setType(BarcodeGenerator::Code128);
                    $barcode1->setLabel('');
                    $barcode1->setScale(1);
                    $barcode1->setThickness(25);
                    $barcode1->setFontSize(10);
                    $app_barcode = $barcode1->generate();

                    $barcode2 = new BarcodeGenerator();
                    $barcode2->setText($r_header->patient_code);
                    $barcode2->setType(BarcodeGenerator::Code128);
                    $barcode2->setLabel('');
                    $barcode2->setScale(1);
                    $barcode2->setThickness(25);
                    $barcode2->setFontSize(10);
                    $patient_varcode = $barcode2->generate();

                    $report_header_arr[] = [
                        'header' => $r_header,
                        'report_varcode' => $report_varcode,
                        'app_barcode' => $app_barcode,
                        'patient_varcode' => $patient_varcode,
                        'report_data' => $report_data,
                        'report_label_query' => $report_label_query,
                        'report_label' => $report_label_query->plain_text ?? '',
                        'attr_group' => $attr_group,
                        'all_report_url' => $all_report_url,
                        'po_hospital_details' => $po_hospital_details,
                        'report_data_1' => $report_data_1,
                        'report_data_2' => $report_data_2,
                        'incuvation_dt' => $incuvation_dt,
                        'attr_group_last' => $attr_group_last,
                        'report_data_mic' => $report_data_mic,
                        'report_data_3' => $report_data_3,
                        'result_organism' => DB::table('labt_testreporting')->where('report_no_pk', $r_header->report_no_pk)->first(),
                        'note_text_clob' => $note_text_clob,
                        'attr_group_last_gmc' => $attr_group_last_gmc,
                    ];
                    // Update print status
                    DB::table('labt_testreporting')->where('report_no_pk', $r_header->report_no_pk)->update([
                        'result_print_key_ind' => 1,
                        'result_print_keyed_by' => $auth_id,
                        'result_print_keyed_time' => $to_date,
                        'au_update_by' => $auth_id,
                        'au_update_hospital_pk_no' => Session::get('user.ses_hospital_no_pk')
                    ]);
                }
            } else {
                return view("admin.prescription.no_item_message");
            }
        } catch (\Exception $e) {
            DB::rollback();
            return response()->json(['error' => $e->getMessage()]);
        }

        $pdf = SnappyPdf::loadView(
            'admin.pathology.reports.pathology_all_report_print',
            compact('report_header_arr', 'report_url_sig')
        )
            ->setOption('page-size', 'A4')
            ->setOption('orientation', 'Portrait')
            ->setOption('encoding', 'UTF-8')
            ->setOption('margin-top', '30mm')   // space for header
            ->setOption('margin-bottom', '5mm') // enough space for footer
            ->setOption('margin-left', '5mm');

        return $pdf->stream('Pathology.pdf');
        // return view('admin.pathology.reports.pathology_all_report_print', [
        //     'report_header_arr' => $report_header_arr,
        //     'report_url_sig' => $report_url_sig
        // ]);
    }

    public function resultEntryMultipleEmailPath(Request $request)
    {
        $auth_id = auth()->id();
        $to_date = now();
        $reportIds = $request->input('ids'); // array of report_no_pk

        if (empty($reportIds) || !is_array($reportIds)) {
            return response()->json(['status' => 'error', 'message' => 'No reports selected']);
        }

        // 🔹 Get first report's invoice
        $invoice_id = DB::table('labt_invoicedtl')
            ->where('REPORT_NO_FK', $reportIds[0])
            ->value('invoice_no_fk');

        // 🔹 Get hospital details
        $hospitalDetails = DB::table('wsec_hospital')
            ->where('hospital_no_pk', Session::get('user.ses_hospital_no_pk'))
            ->first();

        // 🔹 Get patient info from first report
        $patientInfo = DB::table('labt_invoicedtl_vw')
            ->select('email', 'patient_name', 'patient_code')
            ->where('REPORT_NO_FK', $reportIds[0])
            ->first();

        if (!$patientInfo || empty($patientInfo->email)) {
            return response()->json(['status' => 'error', 'message' => 'Patient email not found']);
        }

        $pdfFiles = [];

        foreach ($reportIds as $reportId) {

            // Step 1: Route name fetch
            $reportRouteName = DB::table('labt_invoicedtl_vw')
                ->where('REPORT_NO_FK', $reportId)
                ->value('REPORT_URL'); // Example: 'path.bc-report-pdf-mic'

            if (!$reportRouteName) continue;

            // Step 2: Route object
            $route = Route::getRoutes()->getByName($reportRouteName);
            if (!$route) continue;

            // Step 3: Controller@method
            $controllerAction = $route->getActionName();

            // Step 4: Internal call
            $html = app()->call($controllerAction, [
                'report_id' => $reportId,
                'draft' => '',
                'customCss' => 'padding-top: 30px;'
            ]);

            // Step 5: Save individual PDF
            $path = storage_path("app/reports/report_{$reportId}_" . uniqid() . ".pdf");
            $html = '<body style="padding-top:15px;font-size:12px;">' . $html . '</body>';

            Pdf::loadHTML($html)
                ->setPaper('A4', 'portrait')
                ->save($path);

            $pdfFiles[] = $path;
        }

        if (empty($pdfFiles)) {
            return response()->json(['status' => 'error', 'message' => 'No PDFs generated']);
        }

        // Step 6: Merge PDFs using FPDI
        $pdf = new \setasign\Fpdi\Fpdi();
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

        // Step 7: Save merged file
        $mergedFile = storage_path("app/reports/invoice_{$invoice_id}_merged.pdf");
        $pdf->Output($mergedFile, 'F');

        // Step 8: Update print status for all reports
        DB::table('labt_testreporting')
            ->whereIn('report_no_pk', $reportIds)
            ->update([
                'result_print_key_ind' => 1,
                'result_print_keyed_by' => $auth_id,
                'result_print_keyed_time' => $to_date,
                'au_update_by' => $auth_id,
                'au_update_hospital_pk_no' => Session::get('user.ses_hospital_no_pk')
            ]);

        // Step 9: Prepare email
        $subject = "Your Medical Report from {$hospitalDetails->hospital_name}";
        $messageBody = "
        <p>Dear {$patientInfo->patient_name},</p>
        <p>Your report(s) for Patient ID <strong>{$patientInfo->patient_code}</strong> are ready.</p>
        <p>Attached is your merged report.</p>
        <p>Regards,<br>{$hospitalDetails->hospital_name}</p>
    ";

        $pdfContent = file_get_contents($mergedFile); // Or $pdf->output() if in memory

        Mail::send([], [], function ($message) use ($patientInfo, $subject, $messageBody, $pdfContent) {
            $message->to($patientInfo->email)
                ->subject($subject)
                ->setBody($messageBody, 'text/html');

            // Attach PDF content
            $message->attachData($pdfContent, 'MergedReport.pdf', [
                'mime' => 'application/pdf',
            ]);
        });
        return response()->json(['status' => 'success', 'message' => 'Email sent successfully']);
    }
}
