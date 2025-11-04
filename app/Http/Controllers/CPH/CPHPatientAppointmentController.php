<?php

namespace App\Http\Controllers\CPH;
use App\Library\Template;
use Illuminate\Http\Request;
use App\CPHPatientAppointment;
use Illuminate\Support\Facades\DB;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use \PDF;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class CPHPatientAppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        return Template::loadView("admin.cph.patient_appointment.create_appointment");
    }

    public function AddNewOthersPatient(){
        return Template::loadView("admin.cph.patient_appointment.create_new_appointment_popup");
    }

    public function SavePatientAppointmentCPH(){
        return Template::loadView("admin.cph.patient_appointment.queue_preview");
    }

    public function QueuePreview(){
        $barcode = new BarcodeGenerator();
        $barcode->setText('160461');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(8);
        $barcode_no = $barcode->generate();
        
        return Template::loadView("admin.cph.patient_appointment.queue_preview", ['barcode_no' => $barcode_no]);
    }

    public function QueuePrint(){
        $po_hospital_details = DB::table("WSEC_HOSPITAL")->first();
        $userInfo = Auth::user();
        $barcode = new BarcodeGenerator();
        $barcode->setText('160461');
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(8);
        $barcode_no = $barcode->generate();
        $pdf = PDF::loadView("admin.cph.patient_appointment.queue_print", ['barcode_no' => $barcode_no, 'po_hospital_details' => $po_hospital_details, 'userInfo' => $userInfo, ]);
        return $pdf->stream("medicine_packet_print.pdf");
    }

    public function AppointmentedPatientList(){
        return Template::loadView("admin.cph.patient_appointment.appointed_patient_list");
    }

    public function OpdNurseStationCPH(){
        return Template::loadView("admin.cph.patient_appointment.opd_nurse_station");
    }

    public function DoctorEntryPageCPH(){
        return Template::loadView("admin.cph.patient_appointment.doctor_entry_page_cph");
    }

    public function DoctorDashboardCPH(){
        return Template::loadView("admin.cph.patient_appointment.doctor_dashboard_cph");
    }

    public function TodaySerialCPH(){
        return Template::loadView("admin.cph.patient_appointment.today_serial_cph");
    }

    public function PrescriptionEngineDoctorWiseCPH(){
        return Template::loadView("admin.cph.patient_appointment.prescription_engine_doctor_wise_cph");
    }

    public function PrescriptionWorklistCPH(){
        return Template::loadView("admin.cph.patient_appointment.prescription_worklist_cph");
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
        //
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\CPHPatientAppointment  $cPHPatientAppointment
     * @return \Illuminate\Http\Response
     */
    public function show(CPHPatientAppointment $cPHPatientAppointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\CPHPatientAppointment  $cPHPatientAppointment
     * @return \Illuminate\Http\Response
     */
    public function edit(CPHPatientAppointment $cPHPatientAppointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\CPHPatientAppointment  $cPHPatientAppointment
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, CPHPatientAppointment $cPHPatientAppointment)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\CPHPatientAppointment  $cPHPatientAppointment
     * @return \Illuminate\Http\Response
     */
    public function destroy(CPHPatientAppointment $cPHPatientAppointment)
    {
        //
    }
}
