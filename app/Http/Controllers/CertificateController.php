<?php

namespace App\Http\Controllers;

use \PDF;
use DateTime;
use App\Library\Template;
use App\Traits\LookupData;
use App\Models\IpdAdmission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Models\BirthCertificateModel;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Validator;
use App\Repositories\BaseRepository as Repo;
use CodeItNow\BarcodeBundle\Utils\BarcodeGenerator;

class CertificateController extends Controller
{
    public function __construct(IpdAdmission $IpdAdmission, BirthCertificateModel $BirthCertificateModel)
    {
        $this->middleware('auth');
        $this->model = new Repo($IpdAdmission);
        $this->BirthCertificateModel = new Repo($BirthCertificateModel);
    }


    public function patBirthCertificate($admission_id)
    {
        return Template::loadview("admin.certificates.birth_certificate", [
            // 'patient_id' => $patient_id,
            'admission_id' => $admission_id,
            'patientdata' => DB::table('ipd_admission ipd')
                ->select('admission_no_pk', 'admission_uid', 'admission_date', 'patient_no_pk', 'patient_name', 'gender', 'gender_txt', 'marital_status', 'marital_status_txt', 'age_yy', 'patient_code', 'present_addr')
                ->join('patn_registration pat', 'ipd.patient_no_fk', 'pat.patient_no_pk')
                ->where('admission_no_pk', $admission_id)->first(),
                'certificate_list' => db::table('ipd_patient_certificates')->where('admission_no_fk',$admission_id)->where('status',1)->orderby('certificate_pk_no','asc')->get()
        ]);
    }
    public function patBirthCertificatestore(Request $request)
    {
        // dd($request->all());
        $id = $request->id;
        $auth_id = Auth::id();
        $admission_no_pk = $request->admission_no_pk;
        $admission_uid = $request->admission_uid;
        $admission_date = $request->admission_date;
        $patient_no_pk = $request->patient_no_pk;
        $patient_id = $request->patient_id;
        $patient_name = $request->patient_name;
        $wo = $request->wo;
        $age = $request->age;
        $address = $request->address;
        $baby_name = $request->baby_name;
        $birth_date = $request->birth_date;
        $birth_time = $request->birth_time;
        DB::beginTransaction();
        try {
            $data = [
                'certificate_json' => $admission_no_pk . ':' . $admission_uid . ':' . $patient_no_pk . ':' . $admission_date . ':' . $patient_id . ':' . $patient_name . ':' . $wo . ':' . $age . ':' . $address . ':' . $baby_name . ':' . $birth_date . ':' . $birth_time,
                'admission_no_fk' => $admission_no_pk,
                'certificate_date' => date('y/m/d'),
                'certificate_name' => 'birth certificate',
                'certificate_uid' => 'c-' . $admission_no_pk,
                // 'delivered_mobile' => $admission_no_pk,
                'patient_no_fk' => $patient_no_pk,
                'status' => 1,
                'au_entry_session' => 'Session',
            ];
            if ($id == "") {
                $data['au_entry_by'] = $auth_id;
                $this->BirthCertificateModel->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->BirthCertificateModel->update($data, $id);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }

    public function patBirthCertificatePrint($certificate_id, $admission_id)
    {
        $report_header = DB::table('ipd_admission ipd')
            ->select('admission_no_pk', 'admission_uid', 'admission_date', 'patient_no_pk', 'patient_name', 'gender', 'gender_txt', 'marital_status', 'marital_status_txt', 'age_yy', 'patient_code', 'present_addr')
            ->join('patn_registration pat', 'ipd.patient_no_fk', 'pat.patient_no_pk')
            ->where('admission_uid', $admission_id)
            ->first();
        $barcode = new BarcodeGenerator();
        $barcode->setText($report_header->admission_uid);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $admission_id = $barcode->generate();


        $barcode2 = new BarcodeGenerator();
        $barcode2->setText($report_header->patient_code);
        $barcode2->setType(BarcodeGenerator::Code128);
        $barcode2->setScale(1);
        $barcode2->setLabel('');
        $barcode2->setThickness(25);
        $barcode2->setFontSize(10);
        $patient_varcode = $barcode2->generate();

        $po_hospital_details = DB::table("wsec_hospital")->first();
        $report_data = DB::table('ipd_patient_certificates')->select('certificate_json')->where('certificate_name','birth certificate')->where('certificate_pk_no', $certificate_id)->first();


        return view('admin.certificates.birth_certificate_print', [
            'po_hospital_details' => $po_hospital_details,
            'admission_id' => $admission_id,
            'patient_varcode' => $patient_varcode,
            'report_header' => $report_header,
            'report_data' => $report_data,
        ])->render();
        // return @\PDF::loadHTML($html, 'utf-8')->stream();
    }

    public function patDeathCertificate($admission_id)
    {
        return Template::loadview("admin.certificates.death_certificate", [
            'admission_id' => $admission_id,
            'patientdata' => DB::table('ipd_admission ipd')
                ->select('admission_no_pk', 'admission_uid', 'admission_date', 'patient_no_pk', 'patient_name', 'gender', 'gender_txt', 'marital_status', 'marital_status_txt', 'age_yy', 'patient_code', 'present_addr')
                ->join('patn_registration pat', 'ipd.patient_no_fk', 'pat.patient_no_pk')
                ->where('admission_no_pk', $admission_id)->first(),
                'certificate_list' => db::table('ipd_patient_certificates')->where('admission_no_fk',$admission_id)->where('status',2)->orderby('certificate_pk_no','asc')->get()
        ]);
    }

    public function patDeathCertificatestore(Request $request)
    {
        $id = $request->id;
        $auth_id = Auth::id();
        $admission_no_pk = $request->admission_no_pk;
        $admission_uid = $request->admission_uid;
        $admission_date = $request->admission_date;
        $patient_no_pk = $request->patient_no_pk;
        $patient_id = $request->patient_id;
        $patient_name = $request->patient_name;
        $wo = $request->wo;
        $age = $request->age;
        $address = $request->address;
        $disease_name = $request->disease_name;
        $cause_of_death = $request->cause_of_death;
        $death_date = $request->death_date;
        $death_time = $request->death_time;
        $gender_txt = $request->gender_txt;
        $hdn_icu_doctor = $request->hdn_icu_doctor;
        $hdn_death_declared_doctor = $request->hdn_death_declared_doctor;
        $sequence = DB::getSequence();
        $death_seq_no_pk = $sequence->nextValue('death_no_pk_seq');
        DB::beginTransaction();
        try {
            $data = [
                'certificate_json' => $admission_no_pk . '^' . $admission_uid . '^' . $patient_no_pk . '^' . $admission_date . '^' . $patient_id . '^' . $patient_name . '^' . $wo . '^' . $age . '^' . $address . '^' . $disease_name. '^' . $cause_of_death . '^' . $death_date . '^' . $death_time. '^' . $gender_txt,
                'admission_no_fk' => $admission_no_pk,
                'certificate_date' => date('Y-m-d'),
                'certificate_name' => 'Death certificate',
                'certificate_uid' => 'DC-' . date("Ymd").$admission_no_pk,
                // 'delivered_mobile' => $admission_no_pk,
                'patient_no_fk' => $patient_no_pk,
                'status' => 2,
                'au_entry_session' => 'Session',
            ];

            $death_data = [
                'death_no_pk' => $death_seq_no_pk,
                'patient_no_fk' => $patient_no_pk,
                'icu_doctor' => $hdn_icu_doctor,
                'death_declare_doc' => $hdn_death_declared_doctor,
                'cause_of_death' => $cause_of_death,
            ];

            DB::table('patn_death')->where('patient_no_fk',$patient_no_pk)->insert($death_data);



            if ($id == "") {
                $data['au_entry_by'] = $auth_id;
                $this->BirthCertificateModel->create($data);
            } else {
                $data['au_update_by'] = $auth_id;
                $this->BirthCertificateModel->update($data, $id);
            }
            DB::commit();
            $message = ['msg' => 'Data Saved Successfully', 'title' => 'Success'];
        } catch (\Exception $e) {
            DB::rollback();
            $message = ['msg' => $e->getMessage(), 'title' => 'Error'];
        }
        return response()->json($message);
    }


    public function patDeathCertificatePrint($certificate_id, $admission_id)
    {
        $report_header = db::table('ipd_admitted_patlist_vw ipd')
        ->select('ipd.*','icu_doc.full_name as icu_doctor_name','declare_doc.full_name as death_declared_doctor','pat.pr_addr_country as pat_country','pat.email as pat_email','ser.serviceunit_name','deathser.serviceunit_name as deathserdept')
                ->join('patn_registration pat', 'ipd.patient_no_fk', 'pat.patient_no_pk')
                ->leftjoin('hrms_personnel per','ipd.primary_doctor_no_fk','per.person_no_pk')
                ->leftjoin('sysc_serviceunit ser','per.serviceunit_no_fk','ser.serviceunit_no_pk')
                ->leftjoin('patn_death', 'ipd.patient_no_fk', 'patn_death.patient_no_fk')
                ->leftjoin('hrms_personnel icu_doc','patn_death.icu_doctor','icu_doc.person_no_pk')
                ->leftjoin('hrms_personnel declare_doc','patn_death.death_declare_doc','declare_doc.person_no_pk')
                ->leftjoin('sysc_serviceunit deathser','declare_doc.serviceunit_no_fk','deathser.serviceunit_no_pk')
                ->where('admission_uid', $admission_id)
                ->first();
        $barcode = new BarcodeGenerator();
        $barcode->setText($report_header->admission_uid);
        $barcode->setType(BarcodeGenerator::Code128);
        $barcode->setLabel('');
        $barcode->setScale(1);
        $barcode->setThickness(25);
        $barcode->setFontSize(10);
        $admission_id = $barcode->generate();


        $barcode2 = new BarcodeGenerator();
        $barcode2->setText($report_header->patient_code);
        $barcode2->setType(BarcodeGenerator::Code128);
        $barcode2->setScale(1);
        $barcode2->setLabel('');
        $barcode2->setThickness(25);
        $barcode2->setFontSize(10);
        $patient_varcode = $barcode2->generate();

        $po_hospital_details = DB::table("wsec_hospital")->first();
        // dd($po_hospital_details);
        $report_data = DB::table('ipd_patient_certificates')->select('certificate_json')->where('certificate_pk_no', $certificate_id)->first();
// dd($report_data);
        return view('admin.certificates.death_certificate_print', [
            'po_hospital_details' => $po_hospital_details,
            'admission_id' => $admission_id,
            'patient_varcode' => $patient_varcode,
            'report_header' => $report_header,
            'report_data' => $report_data,
        ])->render();
        // return @\PDF::loadHTML($html, 'utf-8')->stream();
    }


    public function patDeathCertificateV2($admission_id)
    {


        $patData = DB::table('ipd_admission ipd')
                            ->select('admission_no_pk', 'admission_uid', 'admission_date', 'patient_no_pk', 'patient_name', 'gender', 'gender_txt', 'marital_status', 'marital_status_txt', 'age_yy', 'patient_code', 'present_addr')
                            ->join('patn_registration pat', 'ipd.patient_no_fk', 'pat.patient_no_pk')
                            ->where('admission_no_pk', $admission_id)->first();

       $certificate_list = DB::table('ipd_patient_certificates')->where('admission_no_fk',$admission_id)->where('status',2)->orderby('certificate_pk_no','asc')->get();
       
       return Template::loadview("admin.certificates.v2.death_certificate_v2", [
                    'admission_id' => $admission_id,
                    'patientdata' => $patData,
                    'certificate_list' => $certificate_list
                ]);
    }
}
