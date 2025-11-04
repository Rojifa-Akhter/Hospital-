<?php

namespace App\Traits;

use App\Models\Doctor;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Session;

trait DoctorData
{
    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function doctorInfoByCodeJson(Request $request)
    {
        $doctor_info = db::table("doctor_info_vw")->where('person_code', $request->doctor_code)->first(['person_no_pk', 'person_code', 'full_name', 'specialization', 'gender_txt', 'marital_status', 'phone_mobile']);
        $doctor_data = [];
        if (!empty($doctor_info)) {
            $doctor_data = array(
                'person_no_pk' => $doctor_info->person_no_pk,
                'person_code' => $doctor_info->person_code,
                'full_name' => $doctor_info->full_name,
                'specialization' => $doctor_info->specialization,
                'gender_txt' => $doctor_info->gender_txt,
                'marital_status' => $doctor_info->marital_status,
                'phone_mobile' => $doctor_info->phone_mobile,
            );

            return $doctor_data;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $specialization_id
     * @return \Illuminate\Http\Response
     */
    public function getDoctorsBySpecl(Request $request)
    {
        $doctor_info = Doctor::where("specialization_lookup_no_fk", "=", $request->element_id)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->where('doctor_ind', 1)
            ->orderByRaw("lower(full_name) asc")
            ->get();
        // dd($doctor_info );
        $doctor_arr = [];
        if (!empty($doctor_info)) {
            foreach ($doctor_info as $doctor) {
                // $doctor_arr =[
                //     'doctor_id' => $doctor->person_no_pk,
                //     'doctor_name' => $doctor->full_name,
                // ];
                array_push($doctor_arr, [
                    'doctor_id' => $doctor->person_no_pk,
                    'doctor_name' => $doctor->full_name,
                ]);
            }

            $doctors = array(
                'list_arr' => $doctor_arr,
            );
        }

        return json_encode($doctors);
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $specialization_id
     * @return \Illuminate\Http\Response
     */
    public function getDoctorsListBySpecl(Request $request)
    {
        $doctor_info = DB::table("doctor_info_vw")
            ->where("specialization_lookup_no_fk", $request->specialization_id)
            ->where("status", 1)
            ->get();

        if (!empty($doctor_info)) {
            $doctor_list = "";
            $doctor_list .= '    <table id="data-table">
            <thead>
            <tr>
            <th class="text-center">Doctor List</th>
            </tr>
            </thead>
            <tbody>';

            foreach ($doctor_info as $doctor) {

                $edit_action = route('doctor.show', $doctor->person_no_pk);
                $doctor_list .= "
                <tr><td>
                <div class='custom-card'>
                <div class='row no-gutters' id='doctor_list'>
                <div class='col-md-4 text-center'>
                <div class='doctor_img'>
                <img class='w-100' src='../../public/images/doctor.png' alt=''>
                </div>
                </div>
                <div class='col-md-8'>
                <div class='custom-card-body p-0'>
                <div class='informations text-left'>
                <span class='doctor_name'><strong>$doctor->person_code : </strong>$doctor->full_name</span>
                <span class='doctor_address'>$doctor->phone_mobile</span>
                <span class='doc_specialist'>$doctor->specialization</span>
                </div>
                <div class='doc_actions text-center'>
                <span class='badge badge-sm badge-primary cursor-pointer open-modal p-1' data-id='$doctor->person_no_pk' data-action='$edit_action' data-modal='common-modal' data-title='Doctor Information' title='View Doctor Information'><i class='fa fa-eye'></i> Profile</span>
                <span class='badge badge-sm badge-success cursor-pointer doctor_select p-1' data-doc-id='$doctor->person_no_pk'><i class='fa fa-calendar'></i> Book Appointment</span>
                </div>
                </div>
                </div>
                </div>
                </div>
                </td>
                </tr>";
            }

            $doctor_list .= '</tbody>
            </table>';
        }

        return $doctor_list;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $specialization_id
     * @return \Illuminate\Http\Response
     */
    public function getActiveDoctorsList()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $doctor_info = DB::table("doctor_info_vw")
            ->where("status", 1)
            ->where("job_type", "DR")
            ->where("au_entry_hospital_pk_no",  $ses_hospital_id)
            ->orderBy("full_name", "asc")
            ->get();

        return $doctor_info;
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $specialization_id
     * @return \Illuminate\Http\Response
     */
    public function getActiveDoctorsAppointmentCount()
    {
        $doctor_info = DB::table("doctor_appointment_stat_vw")
            ->orderBy("total_appointment", "desc")
            ->get();

        return $doctor_info;
    }

    public function getDoctorDegreeAutocomplete(Request $request)
    {
        // return $request;
        $doctor_degree = DB::table('sysc_lookupdata')
            ->where('lookup_no_fk', '=', 241)
            // ->where('lookupdata_code', 'like', '%'.$request->query.'%')
            ->select('lookupdata_code', 'lookupdata_name')
            ->get();
        // return $doctor_degree;

        $degree_data = [];
        if (!empty($doctor_degree)) {
            foreach ($doctor_degree as $degree) {
                $degree_data[] = array(
                    'doctor_degree' => $degree->lookupdata_code,
                    'degree_name' => $degree->lookupdata_name,
                );
            }
            return $degree_data;
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $id
     * @return \Illuminate\Http\Response
     */
    public function getDoctorAutocompleteList(Request $request)
    {
        $keyword = strtoupper($request->search_data);
        $personnel_ind_name = strtoupper($request->personnel_ind_name);
        $personnel_ind = strtoupper($request->personnel_ind);
        $designation_code=$request->designation_code !=''? " AND DESIGNATION_CODE = '".addslashes($request->designation_code)."'" :'';
        $personnel_cond = ($personnel_ind != "") ? " and $personnel_ind_name in ($personnel_ind) $designation_code" : "";
      
        // $patient_info = db::table("employee_info_vw")
        //     ->select('person_no_pk', 'person_code', 'full_name', 'phone_mobile', 'specialization_lookup_no_fk', 'specialization', 'serviceunit_no_fk', 'su_name', 'gender_txt', 'referal_ind')
        //     ->where('status', 1)
        //     ->whereRaw(DB::raw("(upper(person_code) like '$keyword%' or upper(full_name) like '%$keyword%'
        //         or upper(phone_mobile) like '$keyword%' or upper(specialization) like '$keyword%') $personnel_cond "))
        //     ->get();
        $patient_info = db::table("employee_info_vw")
            ->select(
                'person_no_pk',
                'person_code',
                'full_name',
                'phone_mobile',
                'specialization_lookup_no_fk',
                'specialization',
                'serviceunit_no_fk',
                'su_name',
                'designation',
                'jobtitle_lookup_no_fk',
                'doctor_signature',
                'gender_txt',
                'referal_ind',
                'su_name',
                'gender',
                "marital_status_id",
                "marital_status",
                'age',
                'join_date'
            )
            ->where('status', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereRaw(DB::raw("(upper(person_code) = '$keyword' ) $personnel_cond"))
            ->get();
           
        if ($patient_info->isEmpty()) {
            $patient_info = db::table("employee_info_vw")
                ->select(
                    'person_no_pk',
                    'person_code',
                    'full_name',
                    'phone_mobile',
                    'specialization_lookup_no_fk',
                    'specialization',
                    'serviceunit_no_fk',
                    'su_name',
                    'designation',
                    'jobtitle_lookup_no_fk',
                    'doctor_signature',
                    'gender_txt',
                    'referal_ind',
                    'su_name',
                    'gender',
                    "marital_status_id",
                    "marital_status",
                    'age',
                    'join_date'
                )
                ->where('status', 1)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->whereRaw(DB::raw("(upper(full_name) like '%$keyword%' or phone_mobile like '%$keyword%')  $personnel_cond"))
                ->get();
        }
        // dd($personnel_ind_name, $personnel_ind, $patient_info);
        $patient_data = [];
        if (!empty($patient_info)) {
            foreach ($patient_info as $patient) {

                $date1 = date_create(date('Y-m-d',strtotime($patient->join_date)));
                $date2 = date_create(date('Y-m-d'));
                $diff = date_diff($date1, $date2);



                $patient_data[] = array(
                    'doctor_id'             => $patient->person_no_pk,
                    'referal_ind'           => $patient->referal_ind,
                    'person_code'           => $patient->person_code,
                    'full_name'             => $patient->full_name,
                    'specialization'        => $patient->specialization,
                    'gender'                => $patient->gender,
                    'gender_txt'            => $patient->gender_txt,
                    'marital_status_id'     => $patient->marital_status_id,
                    'marital_status'        => $patient->marital_status,
                    'age'                   => $patient->age,
                    'phone_mobile'          => $patient->phone_mobile,
                    'serviceunit_no_fk'     => $patient->serviceunit_no_fk,
                    'jobtitle_lookup_no_fk' => $patient->jobtitle_lookup_no_fk,
                    'su_name'               => $patient->su_name,
                    'designation'           => $patient->designation,
                    'doctor_signature'      => $patient->doctor_signature,
                    'join_date'             =>($patient->join_date!="")?  date("d-m-Y",strtotime($patient->join_date)):"",
                    'lenght_service'        => ($patient->join_date!="")?  $diff->format("%y").'Y ' . $diff->format("%m").'M '. $diff->format("%d").'D ':"",
                );
            }
            return $patient_data;
        }
    }

    public function getDoctorAutocompleteListAll(Request $request)
    {
        $keyword = strtoupper($request->search_data);
        $personnel_ind_name = strtoupper($request->personnel_ind_name);
        $personnel_ind = strtoupper($request->personnel_ind);
        $personnel_cond = ($personnel_ind != "") ? " and $personnel_ind_name in ($personnel_ind)" : "";
      
        // $patient_info = db::table("employee_info_vw")
        //     ->select('person_no_pk', 'person_code', 'full_name', 'phone_mobile', 'specialization_lookup_no_fk', 'specialization', 'serviceunit_no_fk', 'su_name', 'gender_txt', 'referal_ind')
        //     ->where('status', 1)
        //     ->whereRaw(DB::raw("(upper(person_code) like '$keyword%' or upper(full_name) like '%$keyword%'
        //         or upper(phone_mobile) like '$keyword%' or upper(specialization) like '$keyword%') $personnel_cond "))
        //     ->get();
        $patient_info = db::table("employee_info_vw")
            ->select(
                'person_no_pk',
                'person_code',
                'full_name',
                'phone_mobile',
                'specialization_lookup_no_fk',
                'specialization',
                'serviceunit_no_fk',
                'su_name',
                'designation',
                'jobtitle_lookup_no_fk',
                'doctor_signature',
                'gender_txt',
                'referal_ind',
                'su_name',
                'gender',
                "marital_status_id",
                "marital_status",
                'age',
                'join_date'
            )
            ->where('status', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereRaw(DB::raw("(upper(person_code) = '$keyword' ) $personnel_cond"))
            ->get();
           
        if ($patient_info->isEmpty()) {
            $patient_info = db::table("employee_info_vw")
                ->select(
                    'person_no_pk',
                    'person_code',
                    'full_name',
                    'phone_mobile',
                    'specialization_lookup_no_fk',
                    'specialization',
                    'serviceunit_no_fk',
                    'su_name',
                    'designation',
                    'jobtitle_lookup_no_fk',
                    'doctor_signature',
                    'gender_txt',
                    'referal_ind',
                    'su_name',
                    'gender',
                    "marital_status_id",
                    "marital_status",
                    'age',
                    'join_date'
                )
                ->where('status', 1)
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->whereRaw(DB::raw("(upper(full_name) like '%$keyword%' or phone_mobile like '%$keyword%')  $personnel_cond"))
                ->get();
        }
        // dd($personnel_ind_name, $personnel_ind, $patient_info);
        $patient_data = [];
        if (!empty($patient_info)) {
            foreach ($patient_info as $patient) {

                $date1 = date_create(date('Y-m-d',strtotime($patient->join_date)));
                $date2 = date_create(date('Y-m-d'));
                $diff = date_diff($date1, $date2);



                $patient_data[] = array(
                    'doctor_id'             => $patient->person_no_pk,
                    'referal_ind'           => $patient->referal_ind,
                    'person_code'           => $patient->person_code,
                    'full_name'             => $patient->full_name,
                    'specialization'        => $patient->specialization,
                    'gender'                => $patient->gender,
                    'gender_txt'            => $patient->gender_txt,
                    'marital_status_id'     => $patient->marital_status_id,
                    'marital_status'        => $patient->marital_status,
                    'age'                   => $patient->age,
                    'phone_mobile'          => $patient->phone_mobile,
                    'serviceunit_no_fk'     => $patient->serviceunit_no_fk,
                    'jobtitle_lookup_no_fk' => $patient->jobtitle_lookup_no_fk,
                    'su_name'               => $patient->su_name,
                    'designation'           => $patient->designation,
                    'doctor_signature'      => $patient->doctor_signature,
                    'join_date'             =>($patient->join_date!="")?  date("d-m-Y",strtotime($patient->join_date)):"",
                    'lenght_service'        => ($patient->join_date!="")?  $diff->format("%y").'Y ' . $diff->format("%m").'M '. $diff->format("%d").'D ':"",
                );
            }
            return $patient_data;
        }
    }

    public function getDoctorAutocompleteListv3(Request $request)
    {
        $keyword = strtoupper($request->search_data);
        $personnel_ind_name = strtoupper($request->personnel_ind_name);
        $personnel_ind = strtoupper($request->personnel_ind);
        $personnel_cond = ($personnel_ind != "") ? " and $personnel_ind_name in ($personnel_ind)" : "";

        // $patient_info = db::table("employee_info_vw")
        //     ->select('person_no_pk', 'person_code', 'full_name', 'phone_mobile', 'specialization_lookup_no_fk', 'specialization', 'serviceunit_no_fk', 'su_name', 'gender_txt', 'referal_ind')
        //     ->where('status', 1)
        //     ->whereRaw(DB::raw("(upper(person_code) like '$keyword%' or upper(full_name) like '%$keyword%'
        //         or upper(phone_mobile) like '$keyword%' or upper(specialization) like '$keyword%') $personnel_cond "))
        //     ->get();
        $patient_info = db::table("employee_info_vw")
            ->select(
                'person_no_pk',
                'person_code',
                'full_name',
                'phone_mobile',
                'specialization_lookup_no_fk',
                'specialization',
                'serviceunit_no_fk',
                'su_name',
                'designation',
                'jobtitle_lookup_no_fk',
                'doctor_signature',
                'gender_txt',
                'referal_ind',
                'su_name',
                'gender',
                "marital_status_id",
                "marital_status",
                'age',
                'join_date'
            )
            ->where('status', 1)
            ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->whereRaw(DB::raw("(upper(person_code) = '$keyword' ) $personnel_cond"))
            ->get();

        if ($patient_info->isEmpty()) {
            $patient_info = db::table("employee_info_vw")
                ->select(
                    'person_no_pk',
                    'person_code',
                    'full_name',
                    'phone_mobile',
                    'specialization_lookup_no_fk',
                    'specialization',
                    'serviceunit_no_fk',
                    'su_name',
                    'designation',
                    'jobtitle_lookup_no_fk',
                    'doctor_signature',
                    'gender_txt',
                    'referal_ind',
                    'su_name',
                    'gender',
                    "marital_status_id",
                    "marital_status",
                    'age',
                    'join_date'
                )
                ->where('status', 1)
                ->where('serviceunit_no_fk_dept', Session::get('user.serviceunit_no_fk_dept'))
                ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
                ->whereRaw(DB::raw("(upper(full_name) like '%$keyword%' or phone_mobile like '%$keyword%' or person_code like '%$keyword%')  $personnel_cond"))
                ->get();
        }

        $patient_data = [];
        if (!empty($patient_info)) {
            foreach ($patient_info as $patient) {

                $date1 = date_create(date('Y-m-d',strtotime($patient->join_date)));
                $date2 = date_create(date('Y-m-d'));
                $diff = date_diff($date1, $date2);



                $patient_data[] = array(
                    'doctor_id'             => $patient->person_no_pk,
                    'referal_ind'           => $patient->referal_ind,
                    'person_code'           => $patient->person_code,
                    'full_name'             => $patient->full_name,
                    'specialization'        => $patient->specialization,
                    'gender'                => $patient->gender,
                    'gender_txt'            => $patient->gender_txt,
                    'marital_status_id'     => $patient->marital_status_id,
                    'marital_status'        => $patient->marital_status,
                    'age'                   => $patient->age,
                    'phone_mobile'          => $patient->phone_mobile,
                    'serviceunit_no_fk'     => $patient->serviceunit_no_fk,
                    'jobtitle_lookup_no_fk' => $patient->jobtitle_lookup_no_fk,
                    'su_name'               => $patient->su_name,
                    'designation'           => $patient->designation,
                    'doctor_signature'      => $patient->doctor_signature,
                    'join_date'             =>($patient->join_date!="")?  date("d-m-Y",strtotime($patient->join_date)):"",
                    'lenght_service'        => ($patient->join_date!="")?  $diff->format("%y").'Y ' . $diff->format("%m").'M '. $diff->format("%d").'D ':"",
                );
            }
            return $patient_data;
        }
    }

    public function getDoctorsListBySpeclDate(Request $request)
    {
        $today_id = $request->today ? $request->today : "";

        $tommorow_id = $request->tomorrow ? date('Y-m-d', strtotime($request->tomorrow . "+1 days")) : "";
        $date = $request->appoint_dt;

        $specialization_id = $request->specialization_id;

        $query = DB::table('doctor_info_vw d')
            ->join('hrms_schedule p', 'p.doctor_person_no_fk', 'd.person_no_pk');
        if (!empty($specialization_id)) {

            $query->where('d.specialization_lookup_no_fk', $specialization_id);
        }
        if (!empty($date)) {

            $query->where(DB::raw("trunc(p.schedule_dt)"), '=', date('Y-m-d', strtotime($date)));
        }
        if (!empty($tommorow_id)) {
            $query->where(DB::raw("trunc(p.schedule_dt)"), '=', $tommorow_id);
        }
        if (!empty($today_id)) {

            $query->where(DB::raw("trunc(p.schedule_dt)"), '=', date('Y-m-d', strtotime($today_id)));
        }
        $doctor_info = $query
            ->where('d.status', 1)
            ->where('d.au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
            ->select('d.person_no_pk', 'd.full_name', 'd.person_code', 'd.phone_mobile', 'd.specialization')
            ->groupBy('d.person_no_pk', 'd.full_name', 'd.person_code', 'd.phone_mobile', 'd.specialization')
            ->orderByRaw("lower(d.full_name) asc")
            ->get();


        // $doctor_info = DB::table("doctor_info_vw")
        // ->where("specialization_lookup_no_fk", $request->specialization_id)
        // ->where("status", 1)
        // ->get();
        $doctor_list = "";
        if (isset($request->type)) {
            $doctor_list .= "<option value=''>Select</option>";
            foreach ($doctor_info as $doctor) {
                $doctor_list .= "<option value= '" . $doctor->person_no_pk . "'>" . $doctor->full_name . "</option>";
            }
        } else {

            if (isset($doctor_info)) {

                $doctor_list .= '    <table id="data-table">
        <thead>
        <tr>
        <th class="text-center">Doctor List</th>
        </tr>
        </thead>
        <tbody>';

                foreach ($doctor_info as $doctor) {

                    $edit_action = route('doctor.show', $doctor->person_no_pk);
                    $doctor_schedule = route('doctor.apointment-shedule', $doctor->person_no_pk);
                    $doctor_list .= "
            <tr><td>
            <div class='custom-card'>
            <div class='row no-gutters' id='doctor_list'>
            <div class='col-md-4 text-center'>
            <div class='doctor_img'>
            <img class='w-100' src='../../public/images/doctor.png' alt=''>
            </div>
            </div>
            <div class='col-md-8'>
            <div class='custom-card-body p-0'>
            <div class='informations text-left'>
            <span class='doctor_name'><strong>$doctor->person_code : </strong>$doctor->full_name</span>
            <span class='doctor_address'>$doctor->phone_mobile</span>
            <span class='doc_specialist'>$doctor->specialization</span>
            </div>
            <div class='doc_actions text-center'>
            <span class='badge badge-sm badge-primary cursor-pointer open-modal p-1' data-id='$doctor->person_no_pk' data-action='$edit_action' data-modal='common-modal' data-title='Doctor Information' title='View Doctor Information'><i class='fa fa-eye'></i> Profile</span>
            <span class='badge badge-sm badge-secondary cursor-pointer open-modal p-1' data-id='$doctor->person_no_pk' data-action='$doctor_schedule' data-modal='common-modal' data-title='Doctor Schedule Information' title='Doctor Schedule Information '><i class='far fa-clock'></i> View Schedule</span>
            <span class='badge badge-sm badge-success cursor-pointer doctor_select p-1' data-doc-id='$doctor->person_no_pk'><i class='fa fa-calendar'></i> Book Appointment</span>
            </div>
            </div>
            </div>
            </div>
            </div>
            </td>
            </tr>";
                }

                $doctor_list .= '</tbody>
        </table>';
            }
        }
        return $doctor_list;
    }

    public function getDoctorsListBySpeclOnline(Request $request)
    {
        $today_id = $request->today ? $request->today : "";

        $tommorow_id = $request->tomorrow ? date('Y-m-d', strtotime($request->tomorrow . "+1 days")) : "";
        $date = $request->appoint_dt;

        $specialization_id = $request->specialization_id;

        $query = DB::table('hrms_schedule p')
            ->leftjoin('doctor_info_vw d', 'p.doctor_person_no_fk', 'd.person_no_pk');
        if (!empty($specialization_id)) {

            $query->where('d.specialization_lookup_no_fk', $specialization_id);
        }
        if (!empty($date)) {

            $query->where(DB::raw("trunc(p.schedule_dt)"), '=', date('Y-m-d', strtotime($date)));
        }
        if (!empty($tommorow_id)) {
            $query->where(DB::raw("trunc(p.schedule_dt)"), '=', $tommorow_id);
        }
        if (!empty($today_id)) {

            $query->where(DB::raw("trunc(p.schedule_dt)"), '=', date('Y-m-d', strtotime($today_id)));
        }
        $doctor_info = $query
            ->where('d.status', 1)
            ->select('d.person_no_pk', 'd.full_name', 'd.person_code', 'd.phone_mobile', 'd.specialization')
            ->groupBy('d.person_no_pk', 'd.full_name', 'd.person_code', 'd.phone_mobile', 'd.specialization')
            ->get()
            ->toArray();

        if (!empty($doctor_info)) {
            $doctor_list = "";
            $doctor_list .= '    <table id="data-table">
            <thead>
            <tr>
            <th class="text-center">Doctor List</th>
            </tr>
            </thead>
            <tbody>';

            foreach ($doctor_info as $doctor) {

                $edit_action = route('doctor.show', $doctor->person_no_pk);
                $doctor_schedule = route('doctor.apointment-shedule', $doctor->person_no_pk);
                $doctor_list .= "
                    <tr>
                        <td>
                            <div class='custom-card'>
                                <div class='d-flex align-items-center shadow-sm' id='doctor_list'>
                                    <div class='w-25 mr-2'>
                                        <div class='doctor-img' style='width: 100% !important;'>
                                            <img class='w-100' src='../public/images/doctor.png' alt='' />
                                        </div>
                                    </div>
                                    <div class='w-75'>
                                        <div class='custom-card-body p-0'>
                                            <div class='informations text-left'>
                                                <span class='doctor_name'><strong>$doctor->person_code : </strong>$doctor->full_name</span> </br>
                                                <span class='doctor_address'>$doctor->phone_mobile</span> <br />
                                                <span class='badge badge-sm badge-secondary text-white'>$doctor->specialization</span>
                                            </div>
                                            <div class='btn-group mt-1' role='group' aria-label='Basic example'>

                                                <button type='button' class='btn btn-sm btn-info text-white btn-warning open-modal'data-action='$doctor_schedule' data-modal='common-modal' data-doc-id='$doctor->person_no_pk' data-title='Doctor Schedule Information' title='Doctor Schedule Information ' title='Book Appointment'><i class='far fa-calendar-alt'></i></button>
                                                <button type='button' class='btn btn-sm btn-info text-white doctor_select' data-doc-id='$doctor->person_no_pk' title='Book Appointment'><i class='far fa-calendar-check'></i></button>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </td>
                    </tr>
                ";
            }

            $doctor_list .= '</tbody>
            </table>';
        }

        return $doctor_list;
    }

    //    Date 22/09/2021
    public function getDoctorsListBycover(Request $request)
    {
        $today_id = $request->today ? $request->today : "";
        $available_status_id = $request->available_status_id;
        $apointment_type_id = $request->apointment_type_id;
        $tommorow_id = $request->tomorrow ? date('Y-m-d', strtotime($request->tomorrow . "+1 days")) : "";
        $date = $request->appoint_dt;

        $specialization_id = $request->specialization_id;

        $query = DB::table('hrms_schedule p')
            ->leftjoin('doctor_info_vw d', 'p.doctor_person_no_fk', 'd.person_no_pk');
        if (!empty($specialization_id)) {

            $query->where('d.specialization_lookup_no_fk', $specialization_id);
        }
        if (!empty($available_status_id)) {

            $query->where('p.active_status', $available_status_id);
        }
        if (!empty($apointment_type_id)) {

            $query->where('p.active_status', $apointment_type_id);
        }
        if (!empty($date)) {

            $query->where(DB::raw("trunc(p.schedule_dt)"), '=', date('Y-m-d', strtotime($date)));
        }
        if (!empty($tommorow_id)) {
            $query->where(DB::raw("trunc(p.schedule_dt)"), '=', $tommorow_id);
        }
        if (!empty($today_id)) {

            $query->where(DB::raw("trunc(p.schedule_dt)"), '=', date('Y-m-d', strtotime($today_id)));
        }
        $doctor_info = $query
            ->where('d.status', 1)
            ->where(DB::raw("trunc(p.schedule_dt)"), '>=', date('Y-m-d'))
            ->where(DB::raw("trunc(p.schedule_dt)"), '<=', date('Y-m-d', strtotime('+6 days')))
            ->select(DB::raw("LISTAGG(to_char(p.schedule_dt,'dd-mm-yyyy'),',') within GROUP (ORDER BY d.person_no_pk) schedule_dt,d.full_name, d.person_code, d.phone_mobile, d.specialization,d.doctor_fee,d.person_no_pk")) //p.start_time
            //->select('d.person_no_pk',DB::raw("LISTAGG(p.schedule_dt,':') within GROUP (ORDER BY p.schedule_dt) schedule_dt)", 'd.full_name', 'd.person_code', 'd.phone_mobile', 'd.specialization','d.doctor_fee','p.start_time')
            ->groupBy('d.person_no_pk', 'd.full_name', 'd.person_code', 'd.phone_mobile', 'd.specialization', 'd.doctor_fee') //'p.start_time'
            //->where(date(')

            // ->orderBy('p.start_time', 'desc')
            ->get()->toArray();
        //->toSql();
        //dd($doctor_info);
        //        return $doctor_list;
        return json_encode($doctor_info);
    }
}
