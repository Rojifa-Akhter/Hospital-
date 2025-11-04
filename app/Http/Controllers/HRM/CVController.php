<?php

namespace App\Http\Controllers\HRM;

use App\Http\Controllers\Controller;
use App\Library\Template;
use App\Models\Designation;
use App\Models\ServiceUnit;
use App\Traits\LookupData;
use App\Traits\UtilitiesTrait;
use Exception;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use PDO;
use Session;
use PDF;

class CVController extends Controller
{
    use UtilitiesTrait, LookupData;
    public function cvEntry($id = "")
    {
        $circularId = $id;
        // dd($circularId);
        $current_date = date("d-m-Y");
        $job_circular = DB::table('hrms_jobcircular')->select('jobcircular_no_pk', 'position_name')->where('status', 1)->where('jobcircular_closing_date', '>=', $current_date)->get();

        $applicant_id =  $this->getAutoGenerateUID("hrms_cvapplicant", "cvapplicant_no_pk");
        $departments  = ServiceUnit::where('status', '1')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('serviceunit_no_pk', 'serviceunit_name')->orderBy('serviceunit_name', 'asc')->get();
        // dd($job_circular);
        $country      =  DB::table('sysc_country')->where('status', 1)->get();
        $divisions    =  DB::table('sysc_divisions')->where('contry_name', 'Bangladesh')->get();
        $district     =  DB::table('sysc_district')->where('division_id', 6)->orderBy('name', 'asc')->get();
        $gender       = $this->getLookupListByCode("GENDER");

        return Template::loadView("admin.v1.cv.applicant-cv-entry", [
            'applicant_id' => $applicant_id,
            'gender'       => $gender,
            'country'      => $country,
            'district'     => $district,
            'departments'  => $departments,
            'job_circular' => $job_circular,
            'circularId'   => $circularId
        ]);
    }

    public function storeCV(Request $request)
    {
        // dd($request);
        $sequence = DB::getSequence();
        $hospital_pk_no = session()->get('user.ses_hospital_no_pk');
        $entry_session = Session()->get('user.ses_user_pk_no');
        $selected = $request->selected;
        if (isset($request->hdn_applicant_id)) {
            $cvapplicant_no_pk_seq = $request->hdn_applicant_id;
        } else {
            $cvapplicant_no_pk_seq = $sequence->nextValue('cvapplicant_no_pk_seq');
        }


        $data = [
            "cvapplicant_no_pk"       => $cvapplicant_no_pk_seq,
            "cvapplicant_uid"         => isset($request->applicant_id) ? $request->applicant_id : '',
            "cvapplicant_date"        => isset($request->applicant_date) ? date('Y-m-d', strtotime($request->applicant_date)) : date("Y-m-d"),
            "full_name"               => isset($request->full_name) ? $request->full_name : '',
            "dob"                     => isset($request->dob) ? date('Y-m-d', strtotime($request->dob)) : '',
            "gender_lookup_no_fk"     => isset($request->applicant_gender) ? $request->applicant_gender : '',
            "mobile_no"               => isset($request->mobile_) ? $request->mobile_ : '',
            // "applicantion_circular"   => isset($request->applicantion_circular) ? $request->applicantion_circular : '',
            'jobcircular_no_fk'       => isset($request->applicantion_circular) ? $request->applicantion_circular : '',
            "email"                   => isset($request->email) ? $request->email : '',
            "designation"             => isset($request->designation) ? $request->designation : '',
            "post"                    => isset($request->post_) ? $request->post_ : '',
            "su_no_fk"                => isset($request->department) ? $request->department : '',
            "skill"                   => isset($request->skill_) ? $request->skill_ : '',
            "pr_address"              => isset($request->par_address) ? $request->par_address : '',
            "pr_district"             => isset($request->per_distric_city) ? $request->per_distric_city : '',
            "pr_thana"                => isset($request->thana_ps) ? $request->thana_ps : '',
            "pr_country"              => isset($request->per_country) ? $request->per_country : '',
            "pe_address"              => isset($request->pre_address) ? $request->pre_address : '',
            "pe_district"             => isset($request->pr_district) ? $request->pr_district : '',
            "pe_thana"                => isset($request->pr_thana) ? $request->pr_thana : '',
            "pe_country"              => isset($request->pr_country) ? $request->pr_country : '',
            // "selected"                => isset($request->selected) ? $request->selected : '',
            "au_entry_by"             => auth::user()->user_no_pk,
            "au_entry_at"             =>  date('Y-m-d'),
            "au_entry_session"        => $entry_session,
            "au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),
        ];

        // dd($data);

        if (isset($request->pat_photo)) {
            $fileName = time() . '.' . $request->pat_photo->extension();
            $request->pat_photo->move(public_path('uploads/cv/'), $fileName);
            $data['photo'] =   $fileName;
        }

        if (isset($request->upload_cv)) {
            $fileName = time() . '.' . $request->upload_cv->extension();
            $request->upload_cv->move(public_path('uploads/cv/'), $fileName);
            $data['upload_cv'] =   $fileName;
        }


        if (isset($request->upload_cir)) {
            $fileName = time() . '.' . $request->upload_cir->extension();
            $request->upload_cir->move(public_path('uploads/cv/'), $fileName);
            $data['upload_circuler'] =   $fileName;
        }



        if (isset($request->hdn_applicant_id)) {
            DB::table("hrms_applicant_cv")->where("cvapplicant_no_pk", $request->hdn_applicant_id)->update($data);
            DB::table("hrms_applicant_education")->where("cvapplicant_no_fk", $request->hdn_applicant_id)->delete();
            DB::table("hrms_applicant_experience")->where("cvapplicant_no_fk", $request->hdn_applicant_id)->delete();
            DB::table("hrms_applicant_cert_tr")->where("cvapplicant_no_fk", $request->hdn_applicant_id)->delete();
            //$cvapplicant_no_pk_seq = $request->hdn_applicant_id;
        } else {
            DB::table("hrms_applicant_cv")->insert($data);
        }


        // Education data process
        for ($i = 0; $i < count($request->degree_title); $i++) {
            if ($request->degree_title[$i] != "") {
                $edu_data = [
                    "education_no_pk"         => $sequence->nextValue('seq_education_no_pk'),
                    "cvapplicant_no_fk"       => $cvapplicant_no_pk_seq,
                    "degree_title"            => isset($request->degree_title[$i]) ? $request->degree_title[$i] : '',
                    "universit_board"         => isset($request->universit_board[$i]) ? $request->universit_board[$i] : '',
                    "institute_name"          => isset($request->institute_name[$i]) ? $request->institute_name[$i] : '',
                    "passing_year"            => isset($request->passing_year[$i]) ? $request->passing_year[$i] : '',
                    "result"                  => isset($request->result[$i]) ? $request->result[$i] : '',
                    "highest_education"       => isset($request->highest_education[$i]) ? $request->highest_education[$i] : '',
                    "status"                  => 1,
                    "au_entry_by"             => auth::user()->user_no_pk,
                    "au_entry_at"             =>  date('Y-m-d'),
                    "au_entry_session"        => $entry_session,
                    "au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),
                ];
                DB::table("hrms_applicant_education")->insert($edu_data);
            }
        }


        // Experience data process
        for ($i = 0; $i < count($request->company_name); $i++) {
            if ($request->company_name[$i] != "") {
                $edu_data = [
                    "experience_no_pk"        => $sequence->nextValue('experience_no_pk_seq '),
                    "cvapplicant_no_fk"       => $cvapplicant_no_pk_seq,
                    "company_name"            => isset($request->company_name[$i]) ? $request->company_name[$i] : '',
                    "company_location"        => isset($request->company_location[$i]) ? $request->company_location[$i] : '',
                    "designation"             => isset($request->old_designation[$i]) ? $request->old_designation[$i] : '',
                    "start_date"              => date("Y-m-d", strtotime($request->start_date[$i])) ?? date("Y-m-d"),
                    "end_date"                => date("Y-m-d", strtotime($request->end_date[$i])) ?? date("Y-m-d"),
                    "number_of_years"         => isset($request->number_of_years[$i]) ? $request->number_of_years[$i] : '',
                    "resign_reason"           => isset($request->resign_reason[$i]) ? $request->resign_reason[$i] : '',
                    "currentjob"              => 1,
                    "status"                  => 1,
                    "au_entry_by"             => auth::user()->user_no_pk,
                    "au_entry_at"             => date('Y-m-d'),
                    "au_entry_session"        => $entry_session,
                    "au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),

                ];
                DB::table("hrms_applicant_experience")->insert($edu_data);
            }
        }


        // Traning & certication data process
        for ($i = 0; $i < count($request->cert_tr_tittle); $i++) {
            // dd($request);
            if ($request->cert_tr_tittle[$i] != "") {
                $training_data = [
                    "cert_tr_no_pk"          => $sequence->nextValue('experience_no_pk_seq'),
                    "cvapplicant_no_fk"      => $cvapplicant_no_pk_seq,
                    "cert_tr_tittle"         => isset($request->cert_tr_tittle[$i]) ? $request->cert_tr_tittle[$i] : '',
                    "institute_name"         => isset($request->institute_name[$i]) ? $request->institute_name[$i] : '',
                    "training_from_date"     => date("Y-m-d", strtotime($request->training_from_date[$i])) ?? date("Y-m-d"),
                    "training_to_date"       => date("Y-m-d", strtotime($request->training_to_date[$i])) ?? date("Y-m-d"),
                    "training_duration"      => isset($request->training_duration[$i]) ? $request->training_duration[$i] : '',
                    "certification_date"     => date("Y-m-d", strtotime($request->certification_date[$i])) ?? date("Y-m-d"),
                    // "tr_cert_file"           =>  isset($request->tr_cert_file[$i]) ? $request->tr_cert_file[$i] : '',
                    "tr_cert_url"            =>  isset($request->tr_cert_url[$i]) ? $request->tr_cert_url[$i] : '',
                    "status"                 => 1,
                    "au_entry_by"            => auth::user()->user_no_pk,
                    "au_entry_at"            => date('Y-m-d'),
                    "au_entry_session"       => $entry_session,
                    "au_entry_hospital_pk_no" => Session::get('user.ses_hospital_no_pk'),
                ];
                // dd($request->tr_cert_file);

                if (isset($request->tr_cert_file[$i])) {
                    $fileName = time() . '.' . $request->tr_cert_file[$i]->extension();
                    $request->tr_cert_file[$i]->move(public_path('uploads/cv/'), $fileName);
                    $training_data['tr_cert_file'] = $fileName;
                }

                DB::table("hrms_applicant_cert_tr")->insert($training_data);
            }
        }



        $message = ['msg' => 'CV saved successfully.', 'title' => 'Success'];
        return response()->json($message);
    }

    public function cvlist()
    {
        $departments = ServiceUnit::where('status', '1')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('serviceunit_no_pk', 'serviceunit_name')->orderBy('serviceunit_name', 'asc')->get();
        $cvList =  DB::table("hrms_applicant_cv")
        ->leftJoin('sysc_serviceunit', 'hrms_applicant_cv.su_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
        ->select('hrms_applicant_cv.*', 'sysc_serviceunit.serviceunit_name')
        ->orderBy("cvapplicant_no_pk", "desc")
        ->get();
        // dd($cvList);
        return Template::loadView("admin.v1.cv.applicant-cv-list", [
            'cvList' => $cvList,
            'departments' => $departments
        ]);
    }

    public function cvEdit($applicant_id)
    {
        $current_date = date("d-m-Y");

        $departments = ServiceUnit::where('status', '1')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('serviceunit_no_pk', 'serviceunit_name')->orderBy('serviceunit_name', 'asc')->get();

        $job_circular = DB::table('hrms_jobcircular')->select('jobcircular_no_pk', 'position_name')->where('status', 1)->where('jobcircular_closing_date', '>=', $current_date)->get();

        $country      = DB::table('sysc_country')->where('status', 1)->get();
        $divisions    = DB::table('sysc_divisions')->where('contry_name', 'Bangladesh')->get();
        $district     = DB::table('sysc_district')->where('division_id', 6)->orderBy('name', 'asc')->get();
        $gender       = $this->getLookupListByCode("GENDER");
        $cvApplicant  = DB::table("hrms_applicant_cv")
            ->where('cvapplicant_no_pk', $applicant_id)->first();

        $cvEducation  = DB::table("hrms_applicant_education")
            ->where('cvapplicant_no_fk', $applicant_id)->get();

        $cvExperience = DB::table("hrms_applicant_experience")
            ->where('cvapplicant_no_fk', $applicant_id)->get();
        $cvTraining = DB::table("hrms_applicant_cert_tr")
            ->where('cvapplicant_no_fk', $applicant_id)->get();

        return Template::loadView("admin.v1.cv.applicant-cv-edit", [
            'cvApplicant'  => $cvApplicant,
            'cvEducation'  => $cvEducation,
            'cvExperience' => $cvExperience,
            'cvTraining'   => $cvTraining,
            'gender'       => $gender,
            'country'      => $country,
            'district'     => $district,
            'departments'  => $departments,
            'job_circular' => $job_circular
        ]);
    }

    // Method for cv searching

    public function cvSearch(Request $request)
    {
        $circuler   = $request->circuler;
        $mobile     = $request->mobile;
        $post       = $request->post;
        $name       = $request->full_name;
        $deaprtment = $request->deaprtment;

        if (isset($deaprtment)) {
            $applicantData = DB::table('hrms_applicant_cv')
            ->leftJoin('sysc_serviceunit', 'hrms_applicant_cv.su_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
            ->select('hrms_applicant_cv.*', 'sysc_serviceunit.serviceunit_name')
            ->where('su_no_fk', $deaprtment)
            ->get();
        }

        if (isset($post)) {
            $applicantData = DB::table('hrms_applicant_cv')
            ->leftJoin('sysc_serviceunit', 'hrms_applicant_cv.su_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
            ->select('hrms_applicant_cv.*', 'sysc_serviceunit.serviceunit_name')
            ->where('post', $post)
            ->get();
        }

        if (isset($name)) {
            $applicantData = DB::table('hrms_applicant_cv')
            ->leftJoin('sysc_serviceunit', 'hrms_applicant_cv.su_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
            ->select('hrms_applicant_cv.*', 'sysc_serviceunit.serviceunit_name')
            ->where('full_name', $name)
            ->get();
        }

        if (isset($mobile)) {
            $applicantData = DB::table('hrms_applicant_cv')
            ->leftJoin('sysc_serviceunit', 'hrms_applicant_cv.su_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
            ->select('hrms_applicant_cv.*', 'sysc_serviceunit.serviceunit_name')
            ->where('mobile_no', $mobile)
            ->get();
        }

        if (isset($circuler)) {
            $applicantData = DB::table('hrms_applicant_cv')
            ->leftJoin('sysc_serviceunit', 'hrms_applicant_cv.su_no_fk', 'sysc_serviceunit.serviceunit_no_pk')
            ->select('hrms_applicant_cv.*', 'sysc_serviceunit.serviceunit_name')
            ->where('applicantion_circular', $circuler)
            ->get();
        }

        // dd($applicantData);
        return Template::loadView("admin.v1.cv.applicant-cv-search-table", [
            'applicantData'           => $applicantData,
        ]);
    }

    public function cvView($id = "")
    {
        $dept = ServiceUnit::where('status', '1')->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))->select('serviceunit_no_pk', 'serviceunit_name')->orderBy('serviceunit_name', 'asc')->get();


        $singleApplicantInfo = DB::table('hrms_applicant_cv')->leftJoin('sysc_serviceunit', 'hrms_applicant_cv.su_no_fk', 'sysc_serviceunit.serviceunit_no_pk')->leftJoin('sysc_district', 'hrms_applicant_cv.pr_district', 'sysc_district.id')->leftJoin('sysc_district', 'hrms_applicant_cv.pe_district', 'sysc_district.id')->leftJoin('sysc_country', 'hrms_applicant_cv.pe_country', 'sysc_country.country_no_pk')->leftJoin('sysc_lookupdata ld', 'hrms_applicant_cv.gender_lookup_no_fk', '=', 'ld.lookupdata_no_pk')->select('hrms_applicant_cv.*', 'sysc_serviceunit.serviceunit_no_pk', 'sysc_serviceunit.serviceunit_name', 'sysc_district.name as pr_dist_name', 'sysc_district.name as pe_dist_name', 'sysc_district.id', 'ld.lookupdata_name as ld_gender_name', 'sysc_country.country_name as country_name')->where('cvapplicant_no_pk', $id)->get();

        $ApplicantEducationInfo = DB::table('hrms_applicant_education')->where('cvapplicant_no_fk', $id)->get();
        $ApplicantExperienceInfo = DB::table('hrms_applicant_experience')->where('cvapplicant_no_fk', $id)->get();
        $ApplicantTrainingInfo = DB::table('hrms_applicant_cert_tr')->where('cvapplicant_no_fk', $id)->get();
        // dd($singleApplicantInfo);
        return Template::loadView("admin.v1.cv.applicant-cv-view", [
            'singleApplicantInfo' => $singleApplicantInfo,
            'ApplicantEducationInfo' => $ApplicantEducationInfo,
            'ApplicantExperienceInfo' => $ApplicantExperienceInfo,
            'ApplicantTrainingInfo' => $ApplicantTrainingInfo,
            'dept' => $dept
        ]);
    }

    public function cvRemove(Request $request)
    {
        DB::table('hrms_applicant_cv')->where('cvapplicant_no_pk', $request->cvapplicant_no_pk)->delete();
        return Template::loadView("admin.v1.hrm.increamentmanagement.increment-processing-list-table");
    }

    public function updateInterviewStatus(Request $request)
    {
        $interview_status = $request->call_for_interview;
        DB::table('hrms_applicant_cv')
            ->where('cvapplicant_no_pk', $request->cvapplicant_no_pk)
            ->update(array('call_for_interview' => $interview_status));
    }

    public function updateSelectStatus(Request $request)
    {
        // $selected_datas = $request->selected_data;
        // dd($selected_data);

        if (isset($request->selected_data)) {
            foreach ($request->selected_data as $key => $value) {
                // dd($value['selected']);
                DB::table('hrms_applicant_cv')->where('cvapplicant_no_pk', $key)->update(['selected' => $value['selected']]);
            }
        }

        $message = ['msg' => 'Updated successfully.', 'title' => 'Success'];
        return response()->json($message);

        return Template::loadView('admin.v1.hrm.hrmselection.applicant-work-list');
    }
}
