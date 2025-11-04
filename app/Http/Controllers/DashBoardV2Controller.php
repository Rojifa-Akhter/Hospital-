<?php

namespace App\Http\Controllers;

use Auth;
use App\Library\Template;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Session;

class DashBoardV2Controller extends Controller
{
    //
    public function __invoke()
    {
        $today_appointment = DB::table('finc_doctor_income_dt_vw')
            ->select(
                DB::raw("SUM(total_appointment) as t_appointment")
            )
            ->where(DB::raw('trunc(income_date)'), date('Y-m-d'))
            ->get();

        $today_new_appointment = DB::table('finc_doctor_income_dt_vw')
            ->select(
                DB::raw("SUM(patient_new_total) as t_n_appointment")
            )
            ->where(DB::raw('trunc(income_date)'), date('Y-m-d'))
            ->get();

        $today_followup_appointment = DB::table('finc_doctor_income_dt_vw')
            ->select(
                DB::raw("SUM(patient_followup_total) as t_f_appointment")
            )
            ->where(DB::raw('trunc(income_date)'), date('Y-m-d'))
            ->get();

        $today_free_appointment = DB::table('finc_doctor_income_dt_vw')
            ->select(
                DB::raw("SUM(patient_free) as t_free_appointment")
            )
            ->where(DB::raw('trunc(income_date)'), date('Y-m-d'))
            ->get();
        // dd($today_new_appointment,$today_followup_appointment,$today_free_appointment);

        $prescribed = DB::table('psn_t_prescription')
            ->where(DB::raw('trunc(au_entry_at)'), date('Y-m-d'))
            ->whereIn('appoint_no_fk', function ($query) {
                $query->select('appoint_no_fk')
                    ->from('patn_appointment_vw')
                    ->where('appoint_status', 2)
                    ->where(DB::raw('trunc(appoint_date)'), date("Y-m-d"));
            })
            ->count();



        $total_doctor = DB::table('hrms_schedule_vw')
            ->join('employee_info_vw', 'hrms_schedule_vw.person_no_pk', '=', 'employee_info_vw.person_no_pk')
            ->where("employee_info_vw.doctor_ind", '=', 1)
            //->where("employee_info_vw.employee_ind" ,'=', 1)
            ->where(DB::raw('trunc(schedule_dt)'), date("Y-m-d"))
            ->count();

        $active_doctor = DB::table('finc_doctor_income_dt_vw')
            ->join('employee_info_vw', 'finc_doctor_income_dt_vw.person_no_pk', '=', 'employee_info_vw.person_no_pk')
            ->where("employee_info_vw.doctor_ind", '=', 1)
            ->where(DB::raw('trunc(finc_doctor_income_dt_vw.income_date)'), date('Y-m-d'))
            ->distinct()
            ->count('finc_doctor_income_dt_vw.full_name');

        $today_admission = DB::table('ipd_admitted_patlist_vw')
            ->where(DB::raw('trunc(admission_date)'), date('Y-m-d'))
            //->where('dis_ind','!=', 1)
            ->count();

        $todays_available_ipd_pat = DB::table('ipd_admitted_patlist_vw')
            // ->where(DB::raw('trunc(admission_date)'), date('Y-m-d'))
            ->where('dis_ind', '!=', 1)
            ->count();

        $todays_available_dept_pat = db::select("select admitted_department, count (su_no_fk) as su_count
                                        from ipd_admitted_patlist_vw
                                    where dis_ind != 1
                                    group by admitted_department");

        $today_discharge = DB::table('ipd_admitted_patlist_vw')
            ->where('dis_ind', 1)
            ->where(DB::raw('trunc(dis_date)'), date('Y-m-d'))
            ->count();

        // return DB::select("select  count(1) from IPD_ADMITTED_PATLIST_VW where dis_INd=1 and trunc(DISCHARGE_DATE)=trunc(sysdate)");
        $patient_ages = DB::select("select COUNT(PATIENT_NO_PK) patient_count , trunc(months_between(sysdate,dob)/12) age_yy from finc_invoicemst m join PAT_REGISTRATION_WL_VW pat
        on m.patient_no_fk=pat.patient_no_pk WHERE  PAT.AGE_YY IS NOT NULL GROUP BY trunc(months_between(sysdate,dob)/12) ");


        /**********Patient Age Chart Start*********/
        $ageNm1 = 0;
        $ageNm2 = 0;
        $ageNm3 = 0;
        $ageNm4 = 0;
        $ageNm5 = 0;
        $ageNm6 = 0;
        $ageNm7 = 0;
        $ageNm8 = 0;
        $ageNm9 = 0;
        $ageNm10 = 0;

        foreach ($patient_ages as $data) {

            if ($data->age_yy >= 0 && $data->age_yy <= 10) {
                $ageNm1 += (intval($data->patient_count));
            }

            if ($data->age_yy >= 11 && $data->age_yy <= 20) {
                $ageNm2 += (intval($data->patient_count));
            }

            if ($data->age_yy >= 21 && $data->age_yy <= 30) {
                $ageNm3 += (intval($data->patient_count));
            }

            if ($data->age_yy >= 31 && $data->age_yy <= 40) {
                $ageNm4 += (intval($data->patient_count));
            }

            if ($data->age_yy >= 41 && $data->age_yy <= 50) {
                $ageNm5 += (intval($data->patient_count));
            }

            if ($data->age_yy >= 51 && $data->age_yy <= 60) {
                $ageNm6 += (intval($data->patient_count));
            }

            if ($data->age_yy >= 61 && $data->age_yy <= 70) {
                $ageNm7 += (intval($data->patient_count));
            }

            if ($data->age_yy >= 71 && $data->age_yy <= 80) {
                $ageNm8 += (intval($data->patient_count));
            }

            if ($data->age_yy >= 81 && $data->age_yy <= 90) {
                $ageNm9 += (intval($data->patient_count));
            }

            if ($data->age_yy >= 91 && $data->age_yy <= 100) {
                $ageNm10 += (intval($data->patient_count));
            }
        }

        $age = "10,20,30,40,50,60,70,80,90,100";
        $totalAgeCount = "$ageNm1,$ageNm2,$ageNm3,$ageNm4,$ageNm5,$ageNm6,$ageNm7,$ageNm8,$ageNm9,$ageNm10";

        /**********Patient Age Chart End*********/


        /**********Patient Gender Chart Start*********/
        $patient_gender_male = DB::select("select count(1) as male_data from finc_invoicemst m join PAT_REGISTRATION_WL_VW pat
        on m.patient_no_fk=pat.patient_no_pk where UPPER(gender_txt)='MALE'");

        $patient_gender_female = DB::select("select count(1) as female_data from finc_invoicemst m join PAT_REGISTRATION_WL_VW pat
        on m.patient_no_fk=pat.patient_no_pk where UPPER(gender_txt)='FEMALE'");

        $male_data = $patient_gender_male[0]->male_data;
        $female_data = $patient_gender_female[0]->female_data;
        /**********Patient Gender Chart End*********/


        /**********Patient Visit Deprtment Chart Start*********/

        // $serviceunit_datas = DB::select("select count (  distinct patient_no_fk ) patient_visit_dept,serviceunit_name  from FINC_INVOICEDTL_VW d join finc_invoicemst s on s.invoice_no_pk=d.invoice_no_fk
        // group by serviceunit_name");

        $serviceunit_datas = DB::select("select count (  distinct patient_no_fk ) patient_visit_dept,serviceunit_name  from FINC_INVOICEDTL_VW d join finc_invoicemst s on s.invoice_no_pk=d.invoice_no_fk
        group by serviceunit_name order by  patient_visit_dept  desc");

        $haematology = "";
        $biochemistry = "";
        $radiology = "";
        $administration = "";
        $pharmacy = "";
        $oncology = "";
        $total_dpt_count = 0;

        foreach ($serviceunit_datas as $data) {

            if ($data->serviceunit_name == "HAEMATOLOGY") {
                $haematology .= $data->patient_visit_dept;
            }

            if ($data->serviceunit_name == "BIOCHEMISTRY") {
                $biochemistry .= $data->patient_visit_dept;
            }

            if ($data->serviceunit_name == "RADIOLOGY AND IMAGING") {
                $radiology .= $data->patient_visit_dept;
            }

            if ($data->serviceunit_name == "ADMINISTRATION") {
                $administration .= $data->patient_visit_dept;
            }

            if ($data->serviceunit_name == "PHARMACY") {
                $pharmacy .= $data->patient_visit_dept;
            }

            if ($data->serviceunit_name == "ONCOLOGY") {
                $oncology .= $data->patient_visit_dept;
            }

            $total_dpt_count += (intval($data->patient_visit_dept));
        }

        $orhers_dept_count = $total_dpt_count - (intval($haematology) + intval($biochemistry) + intval($radiology) + intval($administration) + intval($pharmacy) + intval($oncology));

        // dd($haematology,$biochemistry,$radiology,$administration,$pharmacy,$oncology,$orhers_dept_count);
        /**********Patient Visit Deprtment Chart End*********/


        /**********Patient Count by Week Start********************/
        $out_patient1 = DB::select('select count(PATIENT_NO_FK) out_patient_count from IPD_ADMISSION where dis_ind=1 and  trunc(DIS_DATE)>=trunc(sysdate)-7');
        $out_patient2 = DB::select('select count(PATIENT_NO_FK) out_patient_count from IPD_ADMISSION where dis_ind=1 and  trunc(DIS_DATE)>=trunc(sysdate)-14 and trunc(DIS_DATE) <=trunc(sysdate)-7');
        $out_patient3 = DB::select('select count(PATIENT_NO_FK) out_patient_count from IPD_ADMISSION where dis_ind=1 and  trunc(DIS_DATE)>=trunc(sysdate)-21 and trunc(DIS_DATE) <=trunc(sysdate)-14');
        $out_patient4 = DB::select('select count(PATIENT_NO_FK) out_patient_count from IPD_ADMISSION where dis_ind=1 and  trunc(DIS_DATE)>=trunc(sysdate)-28 and trunc(DIS_DATE) <=trunc(sysdate)-21');
        $out_patient5 = DB::select('select count(PATIENT_NO_FK) out_patient_count from IPD_ADMISSION where dis_ind=1 and  trunc(DIS_DATE)>=trunc(sysdate)-35 and trunc(DIS_DATE) <=trunc(sysdate)-28');
        $out_patient6 = DB::select('select count(PATIENT_NO_FK) out_patient_count from IPD_ADMISSION where dis_ind=1 and  trunc(DIS_DATE)>=trunc(sysdate)-42 and trunc(DIS_DATE) <=trunc(sysdate)-35');
        $out_patient7 = DB::select('select count(PATIENT_NO_FK) out_patient_count from IPD_ADMISSION where dis_ind=1 and  trunc(DIS_DATE)>=trunc(sysdate)-49 and trunc(DIS_DATE) <=trunc(sysdate)-42');

        $out_val1 = $out_patient1[0]->out_patient_count;
        $out_val2 = $out_patient2[0]->out_patient_count;
        $out_val3 = $out_patient3[0]->out_patient_count;
        $out_val4 = $out_patient4[0]->out_patient_count;
        $out_val5 = $out_patient5[0]->out_patient_count;
        $out_val6 = $out_patient6[0]->out_patient_count;
        $out_val7 = $out_patient7[0]->out_patient_count;

        $out_patient = "$out_val1,$out_val2,$out_val3,$out_val4,$out_val5,$out_val6,$out_val7";

        $in_patient1 = DB::select('select count(PATIENT_NO_FK) in_patient_count  from IPD_ADMISSION where dis_ind <> 1 and  trunc(DIS_DATE)>=trunc(sysdate)-7');
        $in_patient2 = DB::select('select count(PATIENT_NO_FK) in_patient_count  from IPD_ADMISSION where dis_ind <> 1 and  trunc(DIS_DATE)>=trunc(sysdate)-14 and trunc(DIS_DATE) <=trunc(sysdate)-7');
        $in_patient3 = DB::select('select count(PATIENT_NO_FK) in_patient_count  from IPD_ADMISSION where dis_ind <> 1 and  trunc(DIS_DATE)>=trunc(sysdate)-21 and trunc(DIS_DATE) <=trunc(sysdate)-14');
        $in_patient4 = DB::select('select count(PATIENT_NO_FK) in_patient_count  from IPD_ADMISSION where dis_ind <> 1 and  trunc(DIS_DATE)>=trunc(sysdate)-28 and trunc(DIS_DATE) <=trunc(sysdate)-21');
        $in_patient5 = DB::select('select count(PATIENT_NO_FK) in_patient_count  from IPD_ADMISSION where dis_ind <> 1 and  trunc(DIS_DATE)>=trunc(sysdate)-35 and trunc(DIS_DATE) <=trunc(sysdate)-28');
        $in_patient6 = DB::select('select count(PATIENT_NO_FK) in_patient_count  from IPD_ADMISSION where dis_ind <> 1 and  trunc(DIS_DATE)>=trunc(sysdate)-42 and trunc(DIS_DATE) <=trunc(sysdate)-35');
        $in_patient7 = DB::select('select count(PATIENT_NO_FK) in_patient_count  from IPD_ADMISSION where dis_ind <> 1 and  trunc(DIS_DATE)>=trunc(sysdate)-49 and trunc(DIS_DATE) <=trunc(sysdate)-42');

        $in_val1 = $in_patient1[0]->in_patient_count;
        $in_val2 = $in_patient2[0]->in_patient_count;
        $in_val3 = $in_patient3[0]->in_patient_count;
        $in_val4 = $in_patient4[0]->in_patient_count;
        $in_val5 = $in_patient5[0]->in_patient_count;
        $in_val6 = $in_patient6[0]->in_patient_count;
        $in_val7 = $in_patient7[0]->in_patient_count;

        $in_patient = "$in_val1,$in_val2,$in_val3,$in_val4,$in_val5,$in_val6,$in_val7";

        /**********Patient Count by Week End********************/


        /**********Addmission, Discharge & Death Start****************/
        $addmission_datas = DB::select("select count(patient_no_fk) patient_count,substr(to_char(au_entry_at,'month'),1,3) Month_name,to_char(au_entry_at,'mm') Month_number
        from ipd_admission where nvl(dis_ind,0) <> 1 and nvl(DEATH_IND,0) <> 1 and to_char(au_entry_at,'mm')>= to_char(sysdate,'mm')-5
        group by to_char(au_entry_at,'month'),to_char(au_entry_at,'mm')
        order by to_char(au_entry_at,'mm') desc");


        $last_6month = "";
        $addmission = "";

        if (!empty($addmission_datas)) {
            foreach ($addmission_datas as $addmission_data) {
                $last_6month .= ucfirst($addmission_data->month_name) . ',';
                $addmission .= isset($addmission_data->patient_count) ? $addmission_data->patient_count . ',' : '0,';
            }
        }

        $dis_crg = DB::select("select sum(case when nvl(dis_ind,0) =1 then 1 else 0 end ) patient_count,substr(to_char(au_entry_at,'month'),1,3) Month_name,to_char(au_entry_at,'mm')
        from ipd_admission where to_char(au_entry_at,'mm')>=to_char(sysdate,'mm')-5
        group by to_char(au_entry_at,'month'),to_char(au_entry_at,'mm')
        order by to_char(au_entry_at,'mm') desc");


        // return $dis_crg;

        $dis1 = $dis_crg[0]->patient_count;
        $dis2 = $dis_crg[1]->patient_count;
        $dis3 = $dis_crg[2]->patient_count;
        $dis4 = $dis_crg[3]->patient_count;
        $dis5 = $dis_crg[4]->patient_count;
        $dis6 = $dis_crg[5]->patient_count;

        $discharge = "$dis1,$dis2,$dis3,$dis4,$dis5,$dis6";

        $ptn_dth = DB::select("select sum(case when nvl(DEATH_IND,0) =1 then 1 else 0 end ) patient_count,substr(to_char(au_entry_at,'month'),1,3) Month_name,to_char(au_entry_at,'mm')
        from ipd_admission where to_char(au_entry_at,'mm')>=to_char(sysdate,'mm')-5
        group by to_char(au_entry_at,'month'),to_char(au_entry_at,'mm')
        order by to_char(au_entry_at,'mm') desc");

        $dth1 = $ptn_dth[0]->patient_count;
        $dth2 = $ptn_dth[1]->patient_count;
        $dth3 = $ptn_dth[2]->patient_count;
        $dth4 = $ptn_dth[3]->patient_count;
        $dth5 = $ptn_dth[4]->patient_count;
        $dth6 = $ptn_dth[5]->patient_count;

        $death = "$dth1,$dth2,$dth3,$dth4,$dth5,$dth6";

        /**********Addmission, Discharge & Death End****************/

        /**********Inpatient Bed Occupancy Start********************/
        $total_bed = DB::table('ipds_bed')->get()->count();
        $occupied_bed = DB::table('ipds_bed')->where('bed_status', 2)->get()->count();
        /**********Inpatient Bed Occupancy End********************/


        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        // dd($last_6month);
        //HR
        $total_manpower = DB::select(DB::raw("select count(person_no_pk) as total from employee_info_vw where status =1 and au_entry_hospital_pk_no= '$ses_hospital_id' and employee_ind =1")); // and au_entry_hospital_no_fk = '$ses_hospital_id'

        $total_doc = DB::select(DB::raw("select count(person_no_pk) as total from employee_info_vw where status =1 and au_entry_hospital_pk_no= '$ses_hospital_id' and doctor_ind =1  and employee_ind =1"));


        // $total_manpower_attend_count = DB::select(DB::raw("select count(attendance_status_text_calc) from hrms_attendance_daily_vw where trunc(attendance_date) =  trunc(sysdate) and status=1 and au_entry_hospital_pk_no = '$ses_hospital_id'
        // and upper(attendance_status_text_calc) = upper('ABNORMAL DATA') and employee_ind = 1"));

        // dd($total_manpower_attend_count);

        $total_manpower_attend = DB::select(DB::raw("select * from hrms_attendance_daily_vw where trunc(attendance_date) =  trunc(sysdate) and status=1 and au_entry_hospital_pk_no = '$ses_hospital_id'"));
        $attendence_arr = [];
        $doc_attendence_arr = [];
        if (!empty($total_manpower_attend)) {
            foreach ($total_manpower_attend as $attend) {
                if ($attend->employee_ind == 1) {
                    if (strtoupper($attend->attendance_status_text_calc) == 'ATTEND') {
                        $attendence_arr["ATTEND"] = isset($attendence_arr["ATTEND"]) ? $attendence_arr["ATTEND"] + 1 : 1;
                    }
                    if (strtoupper($attend->attendance_status_text_calc) == 'LATE') {
                        $attendence_arr["LATE"] = isset($attendence_arr["LATE"]) ? $attendence_arr["LATE"] + 1 : 1;
                    }
                    if (strtoupper($attend->attendance_status_text_calc) == 'LEAVE') {
                        $attendence_arr["LEAVE"] = isset($attendence_arr["LEAVE"]) ? $attendence_arr["LEAVE"] + 1 : 1;
                    }
                    if (strtoupper($attend->attendance_status_text_calc) == 'LWP') {
                        $attendence_arr["LWP"] = isset($attendence_arr["LWP"]) ? $attendence_arr["LWP"] + 1 : 1;
                    }
                    if (strtoupper($attend->attendance_status_text_calc) == 'ABSENT') {
                        $attendence_arr["ABSENT"] = isset($attendence_arr["ABSENT"]) ? $attendence_arr["ABSENT"] + 1 : 1;
                    }
                    if (strtoupper($attend->attendance_status_text_calc) == 'DAY OFF') {
                        $attendence_arr["DAY OFF"] = isset($attendence_arr["DAY OFF"]) ? $attendence_arr["DAY OFF"] + 1 : 1;
                    }
                    if (strtoupper($attend->attendance_status_text_calc) == 'NATION HOLIDAY') {
                        $attendence_arr["NATION HOLIDAY"] = isset($attendence_arr["NATION HOLIDAY"]) ? $attendence_arr["NATION HOLIDAY"] + 1 : 1;
                    }

                    if (strtoupper($attend->attendance_status_text_calc) == 'ABNORMAL DATA') {
                        $attendence_arr["ABNORMAL DATA"] = isset($attendence_arr["ABNORMAL DATA"]) ? $attendence_arr["ABNORMAL DATA"] + 1 : 1;
                    }
                }
                if ($attend->doctor_ind == 1) {
                    if (strtoupper($attend->attendance_status_text_calc) == 'ATTEND') {
                        $doc_attendence_arr["ATTEND"] = isset($doc_attendence_arr["ATTEND"]) ? $doc_attendence_arr["ATTEND"] + 1 : 1;
                    }
                    if (strtoupper($attend->attendance_status_text_calc) == 'LATE') {
                        $doc_attendence_arr["LATE"] = isset($doc_attendence_arr["LATE"]) ? $doc_attendence_arr["LATE"] + 1 : 1;
                    }
                    if (strtoupper($attend->attendance_status_text_calc) == 'LEAVE') {
                        $doc_attendence_arr["LEAVE"] = isset($doc_attendence_arr["LEAVE"]) ? $doc_attendence_arr["LEAVE"] + 1 : 1;
                    }
                    if (strtoupper($attend->attendance_status_text_calc) == 'LWP') {
                        $doc_attendence_arr["LWP"] = isset($doc_attendence_arr["LWP"]) ? $doc_attendence_arr["LWP"] + 1 : 1;
                    }
                    if (strtoupper($attend->attendance_status_text_calc) == 'ABSENT') {
                        $doc_attendence_arr["ABSENT"] = isset($doc_attendence_arr["ABSENT"]) ? $doc_attendence_arr["ABSENT"] + 1 : 1;
                    }
                    if (strtoupper($attend->attendance_status_text_calc) == 'DAY OFF') {
                        $doc_attendence_arr["DAY OFF"] = isset($doc_attendence_arr["DAY OFF"]) ? $doc_attendence_arr["DAY OFF"] + 1 : 1;
                    }
                    if (strtoupper($attend->attendance_status_text_calc) == 'NATION HOLIDAY') {
                        $doc_attendence_arr["NATION HOLIDAY"] = isset($doc_attendence_arr["NATION HOLIDAY"]) ? $doc_attendence_arr["NATION HOLIDAY"] + 1 : 1;
                    }

                    if (strtoupper($attend->attendance_status_text_calc) == 'ABNORMAL DATA') {
                        $doc_attendence_arr["ABNORMAL DATA"] = isset($doc_attendence_arr["ABNORMAL DATA"]) ? $doc_attendence_arr["ABNORMAL DATA"] + 1 : 1;
                    }
                }
            }
        }

        // dd($attendence_arr);
        // dd($doc_attendence_arr);



        // return  DB::table('patn_patienttype')->get();
        // return  DB::table('patn_registration')->get();

        // return DB::select("select count(1) patient_count, PATIENT_TYPE from patn_registration group by PATIENT_TYPE");
        // return DB::select("SELECT sum(case when nvl(patient_type,0) =1 then 1 else 0 end ) patient_count, PATIENT_TYPE_DESC FROM patn_registration JOIN PATN_PATIENTTYPE ON PATIENT_TYPE_NO_PK = PATIENT_TYPE WHERE trunc(patn_registration.au_entry_at)>=trunc(sysdate)-7 GROUP BY PATIENT_TYPE_DESC");
        // return DB::select("SELECT count(1) patient_count, PATIENT_TYPE_DESC FROM patn_registration JOIN PATN_PATIENTTYPE ON PATIENT_TYPE_NO_PK = PATIENT_TYPE GROUP BY PATIENT_TYPE_DESC");

        //orginal data
        // return DB::select("SELECT count(patient_no_pk) patient_count, PATIENT_TYPE_DESC FROM patn_registration JOIN PATN_PATIENTTYPE ON PATIENT_TYPE_NO_PK = PATIENT_TYPE GROUP BY PATIENT_TYPE_DESC");

        // return DB::select("SELECT count(patient_no_pk) patient_count, PATIENT_TYPE_DESC FROM patn_registration JOIN PATN_PATIENTTYPE ON PATIENT_TYPE_NO_PK = PATIENT_TYPE WHERE trunc(patn_registration.au_entry_at)>=trunc(sysdate)-7 GROUP BY PATIENT_TYPE_DESC");


        $wk1 = DB::select("SELECT a.PATIENT_TYPE_DESC, nvl( b.patient_count,0) patient_count FROM PATN_PATIENTTYPE a LEFT JOIN
                (SELECT COUNT (patient_no_pk) patient_count, PATIENT_TYPE FROM patn_registration
                WHERE TRUNC (patn_registration.au_entry_at) >= TRUNC (SYSDATE) - 7
                GROUP BY PATIENT_TYPE) b ON b.PATIENT_TYPE = a.PATIENT_TYPE_NO_PK");


        $wk2 = DB::select("SELECT a.PATIENT_TYPE_DESC, nvl( b.patient_count,0) patient_count FROM PATN_PATIENTTYPE a LEFT JOIN
                (SELECT COUNT (patient_no_pk) patient_count, PATIENT_TYPE FROM patn_registration
                WHERE TRUNC (patn_registration.au_entry_at) >= TRUNC(sysdate)-14 and TRUNC (patn_registration.au_entry_at) <= TRUNC (SYSDATE) - 7
                GROUP BY PATIENT_TYPE) b ON b.PATIENT_TYPE = a.PATIENT_TYPE_NO_PK");

        $wk3 = DB::select("SELECT a.PATIENT_TYPE_DESC, nvl( b.patient_count,0) patient_count FROM PATN_PATIENTTYPE a LEFT JOIN
                (SELECT COUNT (patient_no_pk) patient_count, PATIENT_TYPE FROM patn_registration
                WHERE TRUNC (patn_registration.au_entry_at) >= TRUNC(sysdate)-21 and TRUNC (patn_registration.au_entry_at) <= TRUNC (SYSDATE) - 14
                GROUP BY PATIENT_TYPE) b ON b.PATIENT_TYPE = a.PATIENT_TYPE_NO_PK");

        $wk4 = DB::select("SELECT a.PATIENT_TYPE_DESC, nvl( b.patient_count,0) patient_count FROM PATN_PATIENTTYPE a LEFT JOIN
                (SELECT COUNT (patient_no_pk) patient_count, PATIENT_TYPE FROM patn_registration
                WHERE TRUNC (patn_registration.au_entry_at) >= TRUNC(sysdate)-28 and TRUNC (patn_registration.au_entry_at) <= TRUNC (SYSDATE) - 21
                GROUP BY PATIENT_TYPE) b ON b.PATIENT_TYPE = a.PATIENT_TYPE_NO_PK");

        $wk5 = DB::select("SELECT a.PATIENT_TYPE_DESC, nvl( b.patient_count,0) patient_count FROM PATN_PATIENTTYPE a LEFT JOIN
                (SELECT COUNT (patient_no_pk) patient_count, PATIENT_TYPE FROM patn_registration
                WHERE TRUNC (patn_registration.au_entry_at) >= TRUNC(sysdate)-35 and TRUNC (patn_registration.au_entry_at) <= TRUNC (SYSDATE) - 28
                GROUP BY PATIENT_TYPE) b ON b.PATIENT_TYPE = a.PATIENT_TYPE_NO_PK");

        $wk6 = DB::select("SELECT a.PATIENT_TYPE_DESC, nvl( b.patient_count,0) patient_count FROM PATN_PATIENTTYPE a LEFT JOIN
                (SELECT COUNT (patient_no_pk) patient_count, PATIENT_TYPE FROM patn_registration
                WHERE TRUNC (patn_registration.au_entry_at) >= TRUNC(sysdate)-42 and TRUNC (patn_registration.au_entry_at) <= TRUNC (SYSDATE) - 35
                GROUP BY PATIENT_TYPE) b ON b.PATIENT_TYPE = a.PATIENT_TYPE_NO_PK");

        $wk7 = DB::select("SELECT a.PATIENT_TYPE_DESC, nvl( b.patient_count,0) patient_count FROM PATN_PATIENTTYPE a LEFT JOIN
                (SELECT COUNT (patient_no_pk) patient_count, PATIENT_TYPE FROM patn_registration
                WHERE TRUNC (patn_registration.au_entry_at) >= TRUNC(sysdate)-49 and TRUNC (patn_registration.au_entry_at) <= TRUNC (SYSDATE) - 42
                GROUP BY PATIENT_TYPE) b ON b.PATIENT_TYPE = a.PATIENT_TYPE_NO_PK");



        // dd($wk1,$wk2,$wk3,$wk4,$wk5,$wk6,$wk7);
        $gen1 = $wk1[0]->patient_count;
        $gen2 = $wk2[0]->patient_count;
        $gen3 = $wk3[0]->patient_count;
        $gen4 = $wk4[0]->patient_count;
        $gen5 = $wk5[0]->patient_count;
        $gen6 = $wk6[0]->patient_count;
        $gen7 = $wk7[0]->patient_count;

        $general = "$gen1,$gen2,$gen3,$gen4,$gen5,$gen6,$gen7";

        $cov1 = $wk1[1]->patient_count;
        $cov2 = $wk2[1]->patient_count;
        $cov3 = $wk3[1]->patient_count;
        $cov4 = $wk4[1]->patient_count;
        $cov5 = $wk5[1]->patient_count;
        $cov6 = $wk6[1]->patient_count;
        $cov7 = $wk7[1]->patient_count;

        $covid = "$cov1,$cov2,$cov3,$cov4,$cov5,$cov6,$cov7";

        $staf1 = $wk1[2]->patient_count;
        $staf2 = $wk2[2]->patient_count;
        $staf3 = $wk3[2]->patient_count;
        $staf4 = $wk4[2]->patient_count;
        $staf5 = $wk5[2]->patient_count;
        $staf6 = $wk6[2]->patient_count;
        $staf7 = $wk7[2]->patient_count;

        $staff = "$staf1,$staf2,$staf3,$staf4,$staf5,$staf6,$staf7";

        $corp1 = $wk1[3]->patient_count;
        $corp2 = $wk2[3]->patient_count;
        $corp3 = $wk3[3]->patient_count;
        $corp4 = $wk4[3]->patient_count;
        $corp5 = $wk5[3]->patient_count;
        $corp6 = $wk6[3]->patient_count;
        $corp7 = $wk7[3]->patient_count;

        $corporate = "$corp1,$corp2,$corp3,$corp4,$corp5,$corp6,$corp7";

        $po1 = $wk1[4]->patient_count;
        $po2 = $wk2[4]->patient_count;
        $po3 = $wk3[4]->patient_count;
        $po4 = $wk4[4]->patient_count;
        $po5 = $wk5[4]->patient_count;
        $po6 = $wk6[4]->patient_count;
        $po7 = $wk7[4]->patient_count;

        $poor = "$po1,$po2,$po3,$po4,$po5,$po6,$po7";

        $stud1 = $wk1[5]->patient_count;
        $stud2 = $wk2[5]->patient_count;
        $stud3 = $wk3[5]->patient_count;
        $stud4 = $wk4[5]->patient_count;
        $stud5 = $wk5[5]->patient_count;
        $stud6 = $wk6[5]->patient_count;
        $stud7 = $wk7[5]->patient_count;

        $student = "$stud1,$stud2,$stud3,$stud4,$stud5,$stud6,$stud7";

        $spcl1 = $wk1[6]->patient_count;
        $spcl2 = $wk2[6]->patient_count;
        $spcl3 = $wk3[6]->patient_count;
        $spcl4 = $wk4[6]->patient_count;
        $spcl5 = $wk5[6]->patient_count;
        $spcl6 = $wk6[6]->patient_count;
        $spcl7 = $wk7[6]->patient_count;

        $special = "$spcl1,$spcl2,$spcl3,$spcl4,$spcl5,$spcl6,$spcl7";
        $totalPtnType = "General,Covid Discount,Staff,Corporate,Poor,Student,Special";

        //Clinical Summary
        $total_patient = DB::table('finc_invoicemst_sum_vw')
            ->select(DB::raw("count(distinct patient_no_pk) as total_patient"))
            ->whereNotIn('module_code', ['PHR', 'PHR-I'])
            ->where(DB::raw('trunc(invoice_date)'), date('Y-m-d'))
            ->first();

        $total_opd = DB::table('finc_invoicemst_sum_vw')
            ->select(DB::raw("count(distinct patient_no_pk) as total_patient"))
            ->whereIn('module_code', ['OPD', 'OPDC'])
            ->where(DB::raw('trunc(invoice_date)'), date('Y-m-d'))
            ->first();
        $total_ipd = DB::table('finc_invoicemst_sum_vw')
            ->select(DB::raw("count(distinct patient_no_pk) as total_patient"))
            ->whereIn('module_code', ['IPD'])
            ->where(DB::raw('trunc(invoice_date)'), date('Y-m-d'))
            ->first();


        $total_phr_patient = DB::table('finc_invoicemst_sum_vw')
            ->select(DB::raw("count(distinct patient_no_pk) as total_patient"))
            ->whereIn('module_code', ['PHR', 'PHR-I'])
            ->where(DB::raw('trunc(invoice_date)'), date('Y-m-d'))
            ->first();

        $total_phr_opd = DB::table('finc_invoicemst_sum_vw')
            ->select(DB::raw("count(distinct patient_no_pk) as total_patient"))
            ->whereIn('module_code', ['PHR'])
            ->where(DB::raw('trunc(invoice_date)'), date('Y-m-d'))
            ->first();
        $total_phr_ipd = DB::table('finc_invoicemst_sum_vw')
            ->select(DB::raw("count(distinct patient_no_pk) as total_patient"))
            ->whereIn('module_code', ['PHR-I'])
            ->where(DB::raw('trunc(invoice_date)'), date('Y-m-d'))
            ->first();

        $total_inv_ipd = DB::table('finc_doctor_income_refpay_vw')
            ->select(DB::raw("sum(radiology_amt_count) as radiology_amt_count ,sum(pathology_amt_count) as pathology_amt_count, sum(radiology_amt_count+pathology_amt_count) as total "))
            ->where(DB::raw('trunc(income_date)'), date('Y-m-d'))
            ->first();
        $dept_wise_radiology = db::select(" select to_char (invoice_date, 'yyyymm') invoice_date,
                        sum (item_qty - cancel_qty) total,
                        serviceunit_name
                from finc_invoicedtl_vw
                where     trunc (invoice_date) >= trunc (sysdate)
                        and (item_qty - cancel_qty) > 0
                        and item_type = 'RAD'
            group by to_char (invoice_date, 'yyyymm'), serviceunit_name
            order by invoice_date asc");
        $total_radiology = DB::select("select sum (item_qty - cancel_qty) total
                from finc_invoicedtl_vw
               where     trunc (invoice_date) >= trunc (sysdate)
                     and (item_qty - cancel_qty) > 0
                     and item_type = 'RAD'");

        $total_pathology = DB::select("select to_char (invoice_date, 'yyyymm') invoice_date,sum (item_qty - cancel_qty ) total ,serviceunit_name
            from finc_invoicedtl_vw
           where trunc (invoice_date) >= trunc (add_months (sysdate, -6)) and  (item_qty - cancel_qty)>0 and item_type ='LAB'
        group by to_char (invoice_date, 'yyyymm'),serviceunit_name order by  invoice_date asc");
        $total_pathology_arr = [];
        if (!empty($total_pathology)) {
            foreach ($total_pathology as $row) {
                $total_pathology_arr[$row->invoice_date][$row->serviceunit_name] = $row->total;
            }
        }

        //dd($total_pathology_arr);
        //  dd( json_encode($total_pathology_arr), $total_pathology_arr);


        return Template::loadView("admin.dashboards.dashboard_v2", [
            "total_pathology_arr" => json_encode($total_pathology_arr),
            "total_patient" => $total_patient,
            "total_opd" => $total_opd,
            "total_ipd" => $total_ipd,
            "todays_available_dept_pat" => $todays_available_dept_pat,
            "total_phr_patient" => $total_phr_patient,
            "total_phr_opd" => $total_phr_opd,
            "total_phr_ipd" => $total_phr_ipd,
            "total_inv_ipd" => $total_inv_ipd,
            "dept_wise_radiology" => $dept_wise_radiology,
            "total_radiology" => $total_radiology,
            "today_appointment" => $today_appointment,
            "today_new_appointment" => $today_new_appointment,
            "today_followup_appointment" => $today_followup_appointment,
            "today_free_appointment" => $today_free_appointment,
            "prescribed" => $prescribed,
            "total_doctor" => $total_doctor,
            "active_doctor" => $active_doctor,
            "today_admission" => $today_admission,
            'todays_available_ipd_pat' => $todays_available_ipd_pat,
            "today_discharge" => $today_discharge,
            "age" => $age,
            "totalAgeCount" => $totalAgeCount,
            "male_data" => $male_data,
            "female_data" => $female_data,
            "haematology" => $haematology,
            "biochemistry" => $biochemistry,
            "radiology" => $radiology,
            "administration" => $administration,
            "pharmacy" => $pharmacy,
            "oncology" => $oncology,
            "orhers_dept_count" => $orhers_dept_count,
            "in_patient" => $in_patient,
            "out_patient" => $out_patient,
            "last_6month" => $last_6month,
            "addmission" => $addmission,
            "discharge" => $discharge,
            "death" => $death,
            "total_bed" => $total_bed,
            "occupied_bed" => $occupied_bed,

            'total_manpower' => $total_manpower,
            'total_doc' => $total_doc,
            'attendence_arr' => $attendence_arr,
            'doc_attendence_arr' => $doc_attendence_arr,
            'general' => $general,
            'covid' => $covid,
            'staff' => $staff,
            'corporate' => $corporate,
            'poor' => $poor,
            'student' => $student,
            'special' => $special
        ]);
    }

    public function getFinancialData()
    {

        //dd(Session::get('user.inv_director_admin_ind'), Session::get('user.inv_director_acc_ind'), Session::get('user.inv_auth_chairman_ind'));

        $management_ind = 0;
        if (Session::get('user.inv_auth_chairman_ind') == "1") {
            $management_ind = 1;
        } elseif (Session::get('user.inv_director_acc_ind') == "1") {
            $management_ind = 1;
        } elseif (Session::get('user.inv_director_admin_ind') == "1") {
            $management_ind = 1;
        }



        $fincData = DB::table('finc_inv_c022_sum_amount_vw')->select(
            "module_code",
            DB::raw("SUM(sales-sales_cancel) as total_sales"),
            DB::raw("SUM(discount) as total_discount"),
            DB::raw("SUM(refund) as total_refund"),
            DB::raw("SUM(net_collection) as total_collection")
        )
            ->where(DB::raw('trunc(invoice_date)'), date('Y-m-d'))
            //->where(DB::raw('trunc(ledgertrn_date)'), date('Y-m-d'))
            ->groupBy("module_code")
            ->get();


        /******** Bar Chart Start********/
        $today = date('Y-m-d');
        $from_date = date('Y-m-d', strtotime('-7 Day'));



        // $date_arr  = '';

        $opd_data = '';
        $opdc_data = '';
        $phr_data = '';
        $phri_data = '';

        $date_arr_2 = [];
        $date_arr = '';


        for ($i = 0; $i < 7; $i++) {

            $date = date('d/M/Y', strtotime(Carbon::now()->subDays($i)->toDateString()));
            $date1 = date('Y-m-d', strtotime(Carbon::now()->subDays($i)->toDateString()));

            $date_arr .= $date . ',';

            $fincData1 = DB::select("select trunc(ledgertrn_date) as ledgertrn_date , MODULE_CODE, SUM(sales) as total_sales, SUM(discount) as total_discount, SUM(refund) as total_refund, SUM(collection) as total_collection from FINC_INV_C022_SUM_AMOUNT_VW where trunc(ledgertrn_date) >= (TO_DATE('$date1','YYYY-MM-DD')) and  trunc(ledgertrn_date) <= (TO_DATE('$date1','YYYY-MM-DD')) and module_code= 'OPD' group by MODULE_CODE,trunc(ledgertrn_date) ORDER BY trunc(ledgertrn_date) DESC");

            $opd_data .= isset($fincData1[0]->total_sales) ? $fincData1[0]->total_sales . ',' : '0,';

            $fincData1 = DB::select("select trunc(ledgertrn_date) as ledgertrn_date , MODULE_CODE, SUM(sales) as total_sales, SUM(discount) as total_discount, SUM(refund) as total_refund, SUM(collection) as total_collection from FINC_INV_C022_SUM_AMOUNT_VW where trunc(ledgertrn_date) >= (TO_DATE('$date1','YYYY-MM-DD')) and  trunc(ledgertrn_date) <= (TO_DATE('$date1','YYYY-MM-DD')) and module_code= 'OPDC' group by MODULE_CODE,trunc(ledgertrn_date) ORDER BY trunc(ledgertrn_date) DESC");

            $opdc_data .= isset($fincData1[0]->total_sales) ? $fincData1[0]->total_sales . ',' : '0,';


            $fincData1 = DB::select("select trunc(ledgertrn_date) as ledgertrn_date , MODULE_CODE, SUM(sales) as total_sales, SUM(discount) as total_discount, SUM(refund) as total_refund, SUM(collection) as total_collection from FINC_INV_C022_SUM_AMOUNT_VW where trunc(ledgertrn_date) >= (TO_DATE('$date1','YYYY-MM-DD')) and  trunc(ledgertrn_date) <= (TO_DATE('$date1','YYYY-MM-DD')) and module_code= 'PHR' group by MODULE_CODE,trunc(ledgertrn_date) ORDER BY trunc(ledgertrn_date) DESC");

            $phr_data .= isset($fincData1[0]->total_sales) ? $fincData1[0]->total_sales . ',' : '0,';


            $fincData1 = DB::select("select trunc(ledgertrn_date) as ledgertrn_date , MODULE_CODE, SUM(sales) as total_sales, SUM(discount) as total_discount, SUM(refund) as total_refund, SUM(collection) as total_collection from FINC_INV_C022_SUM_AMOUNT_VW where trunc(ledgertrn_date) >= (TO_DATE('$date1','YYYY-MM-DD')) and  trunc(ledgertrn_date) <= (TO_DATE('$date1','YYYY-MM-DD')) and module_code= 'PHR-I' group by MODULE_CODE,trunc(ledgertrn_date) ORDER BY trunc(ledgertrn_date) DESC");

            $phri_data .= isset($fincData1[0]->total_sales) ? $fincData1[0]->total_sales . ',' : '0,';
            // foreach ($fincData1 as $data) {
            //     // $date_arr .= date('d/M/Y', strtotime($data->ledgertrn_date)) . ',';
            //     $date_arr_2[] = date('d/M/Y', strtotime($data->ledgertrn_date));

            //     if ($data->module_code == "OPD" && date('d/M/Y', strtotime($data->ledgertrn_date)) == $date) {
            //         $opd_data .= $data->total_sales . ',';
            //     } else {

            //         $opd_data .=  '0,';
            //     }

            //     // if ($data->module_code == "OPDC" && date('d/M/Y', strtotime($data->ledgertrn_date)) == $date) {
            //     //     $opdc_data .= $data->total_sales . ',';
            //     // } else {
            //     //     $opdc_data .=  '0,';
            //     // }

            //     // if ($data->module_code == "PHR" && date('d/M/Y', strtotime($data->ledgertrn_date)) == $date) {
            //     //     $phr_data .= $data->total_sales . ',';
            //     // } else {
            //     //     $phr_data .=  '0,';
            //     // }

            //     // if ($data->module_code == "PHR-I" && date('d/M/Y', strtotime($data->ledgertrn_date)) == $date) {
            //     //     $phri_data .= $data->total_sales . ',';
            //     // } else {
            //     //     $phri_data .=  '0,';
            //     // }
            //     // if ($data->module_code == "OPDC") {
            //     //     $opdc_data .= $data->total_sales . ',';
            //     // }

            //     // if ($data->module_code == "PHR") {
            //     //     $phr_data .= $data->total_sales . ',';
            //     // }

            //     // if ($data->module_code == "PHR-I") {
            //     //     $phri_data .= $data->total_sales . ',';
            //     // }
            // }
        }


        // dd($date_arr, $opd_data);
        // dd($date_arr_2);

        // dd($date_arr, $phri_data);
        /******** Bar Chart End********/



        //    dd($date_arr);
        //    dd($fincData1,   $date_arr);
        //    dd($fincData1,   $opd_data);
        //    dd($opd_data,   $opdc_data, $phr_data, $phri_data);

        // DB::table('finc_inv_c022_sum_amount_vw')->select(
        //     "id",
        //     "name",
        //     DB::raw("SUM(sell) as total_sell"),
        //     DB::raw("SUM(stock) as total_stock")
        // )
        // ->groupBy("module_code")
        // ->get();

        // dd($opd_data,$date_arr);

        return Template::loadView("admin.dashboards.financial_dashboard", [
            "fincData" => $fincData,
            "date_arr" => $date_arr,
            "opd_data" => $opd_data,
            "opdc_data" => $opdc_data,
            "phr_data" => $phr_data,
            "phri_data" => $phri_data,
            "management_ind" => $management_ind
        ]);
    }


    public function pathologyDashboard()
    {


        $total_inv_ipd = DB::select("select sum (item_qty - cancel_qty ) total
        from finc_invoicedtl_vw
       where trunc (invoice_date) =trunc (sysdate) and  (item_qty - cancel_qty)>0 and item_type ='LAB'");
        //add_months (-1
        $total_pathology_by_dep = DB::select("select sum (item_qty - cancel_qty ) total ,serviceunit_name
            from finc_invoicedtl_vw
           where trunc (invoice_date) =trunc (sysdate) and  (item_qty - cancel_qty)>0 and item_type ='LAB'
        group by serviceunit_name order by  serviceunit_name asc");


        $total_inv_ipd_last_month = DB::select("select sum (item_qty - cancel_qty ) total
        from finc_invoicedtl_vw
       where trunc (invoice_date) >=trunc (add_months (sysdate, -1)) and  (item_qty - cancel_qty)>0 and item_type ='LAB'");
        //add_months (-1
        $total_inv_ipd_last_month_by_dep = DB::select("select sum (item_qty - cancel_qty ) total ,serviceunit_name
            from finc_invoicedtl_vw
           where trunc (invoice_date) >=trunc (add_months (sysdate, -1)) and  (item_qty - cancel_qty)>0 and item_type ='LAB'
        group by serviceunit_name order by  serviceunit_name asc");

        $management_ind = 1;


        //    Chart Query
        $echart_data = DB::select("SELECT number_val,
                                    sale_hour,
                                    ROUND (total_sales, 2) total_sales,
                                    ROUND (total_collection, 2) total_collection
                            FROM    (SELECT number_val
                                        FROM sysc_number
                                        WHERE number_val < 25) hrs
                                    LEFT JOIN
                                    (  SELECT TO_CHAR (LEDGER_DATE, 'hh24') sale_hour,
                                                AVG (LEDGER_AMT_SALES) total_sales,
                                                AVG (LEDGER_AMT_PAYMENT) total_collection
                                            FROM FINC_LEDGERMST
                                        WHERE TRUNC (LEDGER_DATE) > TRUNC (ADD_MONTHS (SYSDATE, -3))
                                        GROUP BY TO_CHAR (LEDGER_DATE, 'hh24')) dta
                                    ON hrs.number_val = dta.sale_hour
                            ORDER BY number_val");

        $month_low_inv = DB::select(DB::raw("SELECT  finc_invoicedtl_vw.item_no_fk,finc_invoicedtl_vw.ITEM_NAME,
                    finc_invoicedtl_vw.ITEM_RATE,
                    lastInv.last_INVOICE_DATE,
                    sum(finc_invoicedtl_vw.ITEM_QTY) item_qty
                    FROM finc_invoicedtl_vw
                        left join
                        (select  ITEM_NO_FK ,  max(INVOICE_DATE) as last_INVOICE_DATE  from finc_invoicedtl_vw group by  ITEM_NO_FK  ) lastInv on lastInv.ITEM_NO_FK = finc_invoicedtl_vw.ITEM_NO_FK
                    WHERE TO_CHAR (finc_invoicedtl_vw.invoice_date, 'mm') = TO_CHAR (SYSDATE, 'mm')-3 AND finc_invoicedtl_vw.ITEM_TYPE='LAB'
                    GROUP BY finc_invoicedtl_vw.ITEM_NO_FK,
                    finc_invoicedtl_vw.ITEM_NAME,
                    finc_invoicedtl_vw.ITEM_RATE,
                    lastInv.last_INVOICE_DATE
            ORDER BY item_qty ASC"));

        $month_top_inv = DB::select(DB::raw("SELECT  finc_invoicedtl_vw.item_no_fk,finc_invoicedtl_vw.ITEM_NAME,
            finc_invoicedtl_vw.ITEM_RATE,
            lastInv.last_INVOICE_DATE,
            sum(finc_invoicedtl_vw.ITEM_QTY) item_qty
            FROM finc_invoicedtl_vw
                left join
                (select  ITEM_NO_FK ,  max(INVOICE_DATE) as last_INVOICE_DATE  from finc_invoicedtl_vw group by  ITEM_NO_FK  ) lastInv on lastInv.ITEM_NO_FK = finc_invoicedtl_vw.ITEM_NO_FK
            WHERE TO_CHAR (finc_invoicedtl_vw.invoice_date, 'mm') = TO_CHAR (SYSDATE, 'mm')-3 AND finc_invoicedtl_vw.ITEM_TYPE='LAB'
            GROUP BY finc_invoicedtl_vw.ITEM_NO_FK,
            finc_invoicedtl_vw.ITEM_NAME,
            finc_invoicedtl_vw.ITEM_RATE,
            lastInv.last_INVOICE_DATE
            ORDER BY item_qty desc"));


        $echart_chart_data = json_encode([$echart_data]);
        //dd($total_inv_ipd,$total_pathology_by_dep);
        return Template::loadview("admin.pathology.dashboard.index", [
            'total_inv_ipd' => $total_inv_ipd,
            'total_pathology_by_dep' => $total_pathology_by_dep,
            'total_inv_ipd_last_month' => $total_inv_ipd_last_month,
            'total_inv_ipd_last_month_by_dep' => $total_inv_ipd_last_month_by_dep,
            'month_low_inv' => $month_low_inv,
            'month_top_inv' => $month_top_inv,
            'management_ind' => $management_ind,
            'echart_data' => $echart_data,
        ]);
    }

    public function radiologyDashboard()
    {


        $total_inv_ipd = DB::select("select sum (item_qty - cancel_qty ) total
        from finc_invoicedtl_vw
       where trunc (invoice_date) =trunc (sysdate) and  (item_qty - cancel_qty)>0 and item_type ='RAD'");
        //add_months (-1
        $total_pathology_by_dep = DB::select("select sum (item_qty - cancel_qty ) total ,serviceunit_name
            from finc_invoicedtl_vw
           where trunc (invoice_date) =trunc (sysdate) and  (item_qty - cancel_qty)>0 and item_type ='RAD'
        group by serviceunit_name order by  serviceunit_name asc");


        $total_inv_ipd_last_month = DB::select("select sum (item_qty - cancel_qty ) total
        from finc_invoicedtl_vw
       where trunc (invoice_date) >=trunc (add_months (sysdate, -1)) and  (item_qty - cancel_qty)>0 and item_type ='RAD'");
        //add_months (-1
        $total_inv_ipd_last_month_by_dep = DB::select("select sum (item_qty - cancel_qty ) total ,serviceunit_name
            from finc_invoicedtl_vw
           where trunc (invoice_date) >=trunc (add_months (sysdate, -1)) and  (item_qty - cancel_qty)>0 and item_type ='RAD'
        group by serviceunit_name order by  serviceunit_name asc");

        $management_ind = 1;


        //    Chart Query
        $echart_data = DB::select("SELECT number_val,
                                    sale_hour,
                                    ROUND (total_sales, 2) total_sales,
                                    ROUND (total_collection, 2) total_collection
                            FROM    (SELECT number_val
                                        FROM sysc_number
                                        WHERE number_val < 25) hrs
                                    LEFT JOIN
                                    (  SELECT TO_CHAR (LEDGER_DATE, 'hh24') sale_hour,
                                                AVG (LEDGER_AMT_SALES) total_sales,
                                                AVG (LEDGER_AMT_PAYMENT) total_collection
                                            FROM FINC_LEDGERMST
                                        WHERE TRUNC (LEDGER_DATE) > TRUNC (ADD_MONTHS (SYSDATE, -3))
                                        GROUP BY TO_CHAR (LEDGER_DATE, 'hh24')) dta
                                    ON hrs.number_val = dta.sale_hour
                            ORDER BY number_val");

        $month_low_inv = DB::select(DB::raw("SELECT  finc_invoicedtl_vw.item_no_fk,finc_invoicedtl_vw.ITEM_NAME,
                    finc_invoicedtl_vw.ITEM_RATE,
                    lastInv.last_INVOICE_DATE,
                    sum(finc_invoicedtl_vw.ITEM_QTY) item_qty
                    FROM finc_invoicedtl_vw
                        left join
                        (select  ITEM_NO_FK ,  max(INVOICE_DATE) as last_INVOICE_DATE  from finc_invoicedtl_vw group by  ITEM_NO_FK  ) lastInv on lastInv.ITEM_NO_FK = finc_invoicedtl_vw.ITEM_NO_FK
                    WHERE TO_CHAR (finc_invoicedtl_vw.invoice_date, 'mm') = TO_CHAR (SYSDATE, 'mm')-3 AND finc_invoicedtl_vw.ITEM_TYPE='RAD'
                    GROUP BY finc_invoicedtl_vw.ITEM_NO_FK,
                    finc_invoicedtl_vw.ITEM_NAME,
                    finc_invoicedtl_vw.ITEM_RATE,
                    lastInv.last_INVOICE_DATE
            ORDER BY item_qty ASC"));

        $month_top_inv = DB::select(DB::raw("SELECT  finc_invoicedtl_vw.item_no_fk,finc_invoicedtl_vw.ITEM_NAME,
            finc_invoicedtl_vw.ITEM_RATE,
            lastInv.last_INVOICE_DATE,
            sum(finc_invoicedtl_vw.ITEM_QTY) item_qty
            FROM finc_invoicedtl_vw
                left join
                (select  ITEM_NO_FK ,  max(INVOICE_DATE) as last_INVOICE_DATE  from finc_invoicedtl_vw group by  ITEM_NO_FK  ) lastInv on lastInv.ITEM_NO_FK = finc_invoicedtl_vw.ITEM_NO_FK
            WHERE TO_CHAR (finc_invoicedtl_vw.invoice_date, 'mm') = TO_CHAR (SYSDATE, 'mm')-3 AND finc_invoicedtl_vw.ITEM_TYPE='RAD'
            GROUP BY finc_invoicedtl_vw.ITEM_NO_FK,
            finc_invoicedtl_vw.ITEM_NAME,
            finc_invoicedtl_vw.ITEM_RATE,
            lastInv.last_INVOICE_DATE
            ORDER BY item_qty desc"));


        $echart_chart_data = json_encode([$echart_data]);
        //dd($total_inv_ipd,$total_pathology_by_dep);
        return Template::loadview("admin.radiology.dashboard.index", [
            'total_inv_ipd' => $total_inv_ipd,
            'total_pathology_by_dep' => $total_pathology_by_dep,
            'total_inv_ipd_last_month' => $total_inv_ipd_last_month,
            'total_inv_ipd_last_month_by_dep' => $total_inv_ipd_last_month_by_dep,
            'month_low_inv' => $month_low_inv,
            'month_top_inv' => $month_top_inv,
            'management_ind' => $management_ind,
            'echart_data' => $echart_data,
        ]);
    }



    // managemnt DashboardV1
    public function managementDashboardV1()
    {
        /**********Hospital Summery Start********************/
        $hospital_summary_opd = DB::select(DB::raw("SELECT SUM (DECODE (TRUNC (appoint_date), TRUNC (SYSDATE), PATIENT_CNT_TOTAL)) today,SUM (DECODE (TRUNC (appoint_date), TRUNC (SYSDATE - 1), PATIENT_CNT_TOTAL)) yesterday, SUM (DECODE (TO_CHAR (appoint_date, 'MMYYYY'),TO_CHAR (SYSDATE, 'MMYYYY'), PATIENT_CNT_TOTAL)) this_month  FROM RPT_03_OPD_PAT_COUNT_SU_DT_VW WHERE TRUNC (appoint_date) BETWEEN TO_DATE ('01/' || TO_CHAR (SYSDATE, 'mm/yyyy'),'dd/mm/yyyy')AND TRUNC (SYSDATE) "));
        $hospital_summary_ipd = DB::select(DB::raw("SELECT SUM (DECODE (TRUNC (ADMISSION_DATE), TRUNC (SYSDATE), 1)) today, SUM (DECODE (TRUNC (ADMISSION_DATE), TRUNC (SYSDATE - 1), 1)) yesterday, SUM ( DECODE (TO_CHAR (ADMISSION_DATE, 'MMYYYY'),TO_CHAR (SYSDATE, 'MMYYYY'), 1)) this_month FROM ipd_admission WHERE TRUNC (ADMISSION_DATE) BETWEEN TO_DATE ( '01/' || TO_CHAR (SYSDATE, 'mm/yyyy'), 'dd/mm/yyyy') AND TRUNC (SYSDATE)"));
        $hospital_summary_phr = DB::select(DB::raw("select sum(decode(trunc(LEDGER_DATE),trunc(sysdate),LEDGER_AMT_PAYMENT)) today,sum(decode(trunc(LEDGER_DATE),trunc(sysdate-1),LEDGER_AMT_PAYMENT))  yesterday,sum(decode(to_char(LEDGER_DATE,'MMYYYY'),to_char(sysdate,'MMYYYY'),LEDGER_AMT_PAYMENT))  this_month from finc_ledgermst mst join sysc_module mod on mst.module_no_fk=mod.module_no_pk where trunc(LEDGER_DATE) between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy') and trunc(sysdate) and mod.MODULE_CODE in ('PHR','PHR-I')"));
        $hospital_summary_emergency = DB::select(DB::raw("select nvl(sum(decode(trunc(ADMISSION_DATE),trunc(sysdate),1)),0) today,nvl(sum(decode(trunc(ADMISSION_DATE),trunc(sysdate-1),1)),0)  yesterday,nvl(sum(decode(to_char(ADMISSION_DATE,'MMYYYY'),to_char(sysdate,'MMYYYY'),1)),0)  this_month from ipd_admission where trunc(ADMISSION_DATE)  between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy') and trunc(sysdate) and EMERGENCY_DAYCARE_IND_TXT ='EMERGENCY'"));
        $hospital_summary_daycare = DB::select(DB::raw("select nvl(sum(decode(trunc(ADMISSION_DATE),trunc(sysdate),1)),0) today,nvl(sum(decode(trunc(ADMISSION_DATE),trunc(sysdate-1),1)),0)  yesterday,nvl(sum(decode(to_char(ADMISSION_DATE,'MMYYYY'),to_char(sysdate,'MMYYYY'),1)),0)  this_month from ipd_admission where trunc(ADMISSION_DATE)  between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy') and trunc(sysdate)and EMERGENCY_DAYCARE_IND_TXT ='DAYCARE'"));
        $hospital_summary_ot = DB::select(DB::raw("select nvl(sum(decode(trunc(OT_DATE),trunc(sysdate),1)),0) today,nvl(sum(decode(trunc(OT_DATE),trunc(sysdate-1),1)),0)  yesterday,nvl(sum(decode(to_char(OT_DATE,'MMYYYY'),to_char(sysdate,'MMYYYY'),1)),0)  this_month from opt_prescribed_ot  where trunc(OT_DATE)  between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy')  and trunc(sysdate)"));
        $hospital_summary_ipd_cons = DB::select(DB::raw("select sum(decode(trunc(INVOICE_DATE),trunc(sysdate),item_qty-nvl(cancel_qty,0))) today,sum(decode(trunc(INVOICE_DATE),trunc(sysdate-1),item_qty-nvl(cancel_qty,0)))  yesterday,sum(decode(to_char(INVOICE_DATE,'MMYYYY'),to_char(sysdate,'MMYYYY'),item_qty-nvl(cancel_qty,0)))  this_month from finc_invoicedtl dtl join finc_invoicemst mst  on mst.invoice_no_pk=dtl.invoice_no_fk where trunc(INVOICE_DATE)  between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy') and trunc(sysdate) and item_name='Consultant Visit (IPD)' and nvl(ADMISSION_NO_PK,0)>0 and nvl(cancel_ind,0)=0"));

        /**********Hospital Summery end********************/

        /**********Hospital Comparison Start********************/
        // OPDC Comparison start
        $hospital_comparison_opdc = DB::select("select to_char(appoint_date,'MM') ,to_char(appoint_date,'Month') month,sum(PATIENT_CNT_TOTAL) no_of_pat
        from RPT_03_OPD_PAT_COUNT_SU_DT_VW
        where trunc(appoint_date) between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate)
        group by to_char(appoint_date,'Month'), to_char(appoint_date,'MM')
        order by 1 asc");
        // dd( $hospital_comparison_opdc);
        $opdc_val1 = isset($hospital_comparison_opdc[0]) ? $hospital_comparison_opdc[0]->no_of_pat : '';
        $opdc_val2 = isset($hospital_comparison_opdc[1]) ? $hospital_comparison_opdc[1]->no_of_pat : '';
        $opdc_val3 = isset($hospital_comparison_opdc[2]) ? $hospital_comparison_opdc[2]->no_of_pat : '';
        $opdc_cons = "$opdc_val1,$opdc_val2,$opdc_val3";

        $opdc_month1 = isset($hospital_comparison_opdc[0]) ? str_replace(' ', '', $hospital_comparison_opdc[0]->month) : '';
        $opdc_month2 = isset($hospital_comparison_opdc[1]) ? str_replace(' ', '', $hospital_comparison_opdc[1]->month) : '';
        $opdc_month3 = isset($hospital_comparison_opdc[2]) ? str_replace(' ', '', $hospital_comparison_opdc[2]->month) : '';
        $opdc_cons_month = "'$opdc_month1','$opdc_month2','$opdc_month3'";
        // OPDC Comparison END

        // OPDC Comparison start
        $hospital_comparison_ipdc = DB::select("select to_char(INVOICE_DATE,'MM'), to_char(INVOICE_DATE,'Month') month,sum(item_qty-nvl(cancel_qty,0)) no_of_item
        from finc_invoicedtl dtl join finc_invoicemst mst
        on mst.invoice_no_pk=dtl.invoice_no_fk
        where trunc(INVOICE_DATE)  between add_months(trunc(sysdate,'mm'),-2)and trunc(sysdate)
        and item_name='Consultant Visit (IPD)'
        and nvl(ADMISSION_NO_PK,0)>0
        and nvl(cancel_ind,0)=0
        group by to_char(INVOICE_DATE,'Month'),to_char(INVOICE_DATE,'MM')
        order by 1 asc");
        $ipdc_val1 = isset($hospital_comparison_ipdc[0]) ? $hospital_comparison_ipdc[0]->no_of_item : '';
        $ipdc_val2 = isset($hospital_comparison_ipdc[1]) ? $hospital_comparison_ipdc[1]->no_of_item : '';
        $ipdc_val3 = isset($hospital_comparison_ipdc[2]) ? $hospital_comparison_ipdc[2]->no_of_item : '';
        $ipdc_cons = "$ipdc_val1,$ipdc_val2,$ipdc_val3";
        $ipdc_month1 = isset($hospital_comparison_ipdc[0]) ? $hospital_comparison_ipdc[0]->month : '';
        $ipdc_month2 = isset($hospital_comparison_ipdc[1]) ? $hospital_comparison_ipdc[1]->month : '';
        $ipdc_month3 = isset($hospital_comparison_ipdc[2]) ? $hospital_comparison_ipdc[2]->month : '';
        $ipdc_cons_month = "'$ipdc_month1','$ipdc_month2','$ipdc_month3'";

        // OPDC Comparison END

        // emergency Comparison start
        $hospital_comparison_emergency = DB::select("select to_char(ADMISSION_DATE,'MM'),to_char(ADMISSION_DATE,'yymm') month,count(*) no_of_pat
          from ipd_admission
          where trunc(ADMISSION_DATE)  between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate)
          and EMERGENCY_DAYCARE_IND_TXT ='EMERGENCY'
          group by to_char(ADMISSION_DATE,'yymm'),to_char(ADMISSION_DATE,'MM')
          order by 1 asc");
        $emergency_val1 = 0;
        $emergency_val2 = 0;
        $emergency_val3 = 0;
        $emergency_cons = "$emergency_val1,$emergency_val2,$emergency_val3";

        $emergency_month1 = 0;
        $emergency_month2 = 0;
        $emergency_month3 = 0;
        $emergency_cons_month = "'$emergency_month1','$emergency_month2','$emergency_month3'";

        // emergency Comparison END

        // emergency Comparison start
        $hospital_comparison_adm = DB::select("select  to_char(ADMISSION_DATE,'MM'), to_char(ADMISSION_DATE,'Month') month,count(*) no_of_pat
          from ipd_admission
          where trunc(ADMISSION_DATE)  between add_months(trunc(sysdate,'mm'),-2)and trunc(sysdate)
          group by to_char(ADMISSION_DATE,'Month'), to_char(ADMISSION_DATE,'MM')
          order by 1 asc");
        $adm_val1 = isset($hospital_comparison_adm[0]) ? $hospital_comparison_adm[0]->no_of_pat : '';
        $adm_val2 = isset($hospital_comparison_adm[1]) ? $hospital_comparison_adm[1]->no_of_pat : '';
        $adm_val3 = isset($hospital_comparison_adm[2]) ? $hospital_comparison_adm[2]->no_of_pat : '';
        $adm_cons = "$adm_val1,$adm_val2,$adm_val3";

        $adm_month1 = isset($hospital_comparison_adm[0]) ? $hospital_comparison_adm[0]->month : '';
        $adm_month2 = isset($hospital_comparison_adm[1]) ? $hospital_comparison_adm[1]->month : '';
        $adm_month3 = isset($hospital_comparison_adm[2]) ? $hospital_comparison_adm[2]->month : '';
        $adm_cons_month = "'$adm_month1','$adm_month2','$adm_month3'";
        // emergency Comparison END

        /**********Hospital Comparison end********************/


        /**********IPD Comparison Start********************/

        $ipd_conversation = DB::select("  SELECT TO_CHAR (admission_date, 'MM'),
                TO_CHAR (admission_date, 'Month') month,
                NVL (SUM (DECODE (ref_from_emr_ind, 1, 1)), 0) emr,
                NVL (SUM (DECODE (ref_from_opd_dept, 1, 1)), 0) opd,
                SUM (
                CASE
                    WHEN NVL (ref_from_emr_ind, 0) = 0
                        AND NVL (ref_from_opd_dept, 0) = 0
                    THEN
                        1
                END)
                others
        FROM ipd_admission
        WHERE TRUNC (admission_date) BETWEEN ADD_MONTHS (TRUNC (SYSDATE, 'mm'), -2)
                                        AND TRUNC (SYSDATE)
        GROUP BY TO_CHAR (admission_date, 'Month'), TO_CHAR (admission_date, 'MM')
        ORDER BY 1 ASC");

        $total_ipd_lst = isset($ipd_conversation[2]) ? $ipd_conversation[2]->opd + $ipd_conversation[2]->emr + $ipd_conversation[2]->others : 0;
        $opd_lst = isset($ipd_conversation[2]) ? ($ipd_conversation[2]->opd / $total_ipd_lst) * 100 : 0;
        $emr_lst = isset($ipd_conversation[2]) ? ($ipd_conversation[2]->emr / $total_ipd_lst) * 100 : 0;
        $others_lst = isset($ipd_conversation[2]) ? ($ipd_conversation[2]->others / $total_ipd_lst) * 100 : 0;


        /**********PHR Start********************/
        $phr_dt = DB::select("select to_char(LEDGER_DATE,'Month') month,to_char(LEDGER_DATE,'mmyy'),sum(LEDGER_AMT_PAYMENT) collection
                from finc_ledgermst mst join
                sysc_module mod
                on mst.module_no_fk=mod.module_no_pk
                where trunc(LEDGER_DATE) between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate)
                and mod.MODULE_CODE in ('PHR')
                group by to_char(LEDGER_DATE,'Month'),to_char(LEDGER_DATE,'mmyy')
                order by 2 asc");
        $phr_i_dt = DB::select("select to_char(LEDGER_DATE,'Month') month,to_char(LEDGER_DATE,'mmyy'),sum(LEDGER_AMT_PAYMENT) collection
                from finc_ledgermst mst join
                sysc_module mod
                on mst.module_no_fk=mod.module_no_pk
                where trunc(LEDGER_DATE) between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate)
                and mod.MODULE_CODE in ('PHR-I')
                group by to_char(LEDGER_DATE,'Month'),to_char(LEDGER_DATE,'mmyy')
                order by 2 asc");

        $phr_e_dt = DB::select("select to_char(LEDGER_DATE,'Month') month,to_char(LEDGER_DATE,'mmyy'),sum(LEDGER_AMT_PAYMENT) collection
                from finc_ledgermst mst join
                sysc_module mod
                on mst.module_no_fk=mod.module_no_pk
                where trunc(LEDGER_DATE) between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate)
                and mod.MODULE_CODE in ('PHR-E')
                group by to_char(LEDGER_DATE,'Month'),to_char(LEDGER_DATE,'mmyy')
                order by 2 asc");

        $phr_d_dt = DB::select("select to_char(LEDGER_DATE,'Month') month,to_char(LEDGER_DATE,'mmyy'),sum(LEDGER_AMT_PAYMENT) collection
                from finc_ledgermst mst join
                sysc_module mod
                on mst.module_no_fk=mod.module_no_pk
                where trunc(LEDGER_DATE) between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate)
                and mod.MODULE_CODE in ('PHR-D')
                group by to_char(LEDGER_DATE,'Month'),to_char(LEDGER_DATE,'mmyy')
                order by 2 asc");

        $phr_day_dt = DB::select("select to_char(LEDGER_DATE,'Month') month,to_char(LEDGER_DATE,'mmyy'),sum(LEDGER_AMT_PAYMENT) collection
                from finc_ledgermst mst join
                sysc_module mod
                on mst.module_no_fk=mod.module_no_pk
                where trunc(LEDGER_DATE) between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate)
                and mod.MODULE_CODE in ('PHR-O')
                group by to_char(LEDGER_DATE,'Month'),to_char(LEDGER_DATE,'mmyy')
                order by 2 asc");

        $phr_value1 = isset($phr_dt[0]) ? $phr_dt[0]->collection : '';
        $phr_value2 = isset($phr_dt[1]) ? $phr_dt[1]->collection : '';
        $phr_value3 = isset($phr_dt[2]) ? $phr_dt[2]->collection : '';
        $phr = "$phr_value1,$phr_value2,$phr_value3";

        $phr_i_value1 = isset($phr_i_dt[0]) ? $phr_i_dt[0]->collection : '';
        $phr_i_value2 = isset($phr_i_dt[1]) ? $phr_i_dt[1]->collection : '';
        $phr_i_value3 = isset($phr_i_dt[2]) ? $phr_i_dt[2]->collection : '';
        $phr_i = "$phr_i_value1,$phr_i_value2,$phr_i_value3";


        $phr_e_value1 = !empty($phr_e_dt[0]->collection) ? $phr_e_dt[0]->collection : 0;
        $phr_e_value2 = !empty($phr_e_dt[1]->collection) ? $phr_e_dt[1]->collection : 0;
        $phr_e_value3 = !empty($phr_e_dt[2]->collection) ? $phr_e_dt[2]->collection : 0;
        $phr_e = "$phr_e_value1,$phr_e_value2,$phr_e_value3";

        $phr_d_value1 = !empty($phr_d_dt[0]->collection) ? $phr_d_dt[0]->collection : 0;
        $phr_d_value2 = !empty($phr_d_dt[1]->collection) ? $phr_d_dt[1]->collection : 0;
        $phr_d_value3 = !empty($phr_d_dt[2]->collection) ? $phr_d_dt[2]->collection : 0;
        $phr_d = "$phr_d_value1,$phr_d_value2,$phr_d_value3";

        $phr_dy_value1 = !empty($phr_dy_dt[0]->collection) ? $phr_dy_dt[0]->collection : 0;
        $phr_dy_value2 = !empty($phr_dy_dt[1]->collection) ? $phr_dy_dt[1]->collection : 0;
        $phr_dy_value3 = !empty($phr_dy_dt[2]->collection) ? $phr_dy_dt[2]->collection : 0;
        $phr_dy = "$phr_dy_value1,$phr_dy_value2,$phr_dy_value3";



        /**********PHR End********************/
        /**********Location Start********************/
        $location = DB::select("select nvl(PATIENT_AREA_NAME,'Others') area,count(*) no_of_patient
            from patn_registration reg , finc_invoicemst mst
            where REG.PATIENT_NO_PK=MST.PATIENT_NO_FK
            and trunc(invoice_date)between add_months(trunc(sysdate,'mm'),-2)and trunc(sysdate) and PATIENT_AREA_NAME is not null
            group by PATIENT_AREA_NAME
            order by 1 ");

        $loc_value1 = isset($location[0]->no_of_patient) ? $location[0]->no_of_patient : 0;
        $loc_value2 = isset($location[1]->no_of_patient) ? $location[1]->no_of_patient : 0;
        $loc_value3 = isset($location[2]->no_of_patient) ? $location[2]->no_of_patient : 0;
        $loc_value4 = isset($location[3]->no_of_patient) ? $location[3]->no_of_patient : 0;
        $loc_value5 = isset($location[4]->no_of_patient) ? $location[4]->no_of_patient : 0;
        $loc_value6 = isset($location[5]->no_of_patient) ? $location[5]->no_of_patient : 0;
        $loc_value7 = isset($location[6]->no_of_patient) ? $location[6]->no_of_patient : 0;
        $loc_value8 = isset($location[7]->no_of_patient) ? $location[7]->no_of_patient : 0;
        $loc_value9 = isset($location[8]->no_of_patient) ? $location[8]->no_of_patient : 0;
        $loc_value10 = isset($location[9]->no_of_patient) ? $location[9]->no_of_patient : 0;
        $loc = "$loc_value1,$loc_value2,$loc_value3,$loc_value4,$loc_value5,$loc_value6,$loc_value7,$loc_value8,$loc_value9,$loc_value10";
        /**********Location End********************/

        /**********doctor start********************/
        $doctor_dt = DB::select("select DOCTOR_NAME,nvl(count(decode(to_char(appoint_date,'mmyy'),to_char(sysdate,'mmyy'),INVOICE_NO_PK)),0) current_month ,
        nvl(count(decode(to_char(appoint_date,'mmyy'),to_char(add_months(trunc(sysdate,'mm'),-1),'mmyy'),INVOICE_NO_PK)),0) pre_month  ,
        nvl(count(decode(to_char(appoint_date,'mmyy'),to_char(add_months(trunc(sysdate,'mm'),-2),'mmyy'),INVOICE_NO_PK)),0) last_month
        from FINC_DOC_APPOINT_SUM_VW
        where trunc (appoint_date) between add_months(trunc(sysdate,'mm'),-2)and trunc (sysdate)
        and NVL (CANCEL_IND, 0) = 0 AND MODULE_CODE = 'OPDC'
        group by DOCTOR_NAME
        order by 1");
        $ipd_dt = DB::select("select SERVICEUNIT_NAME,nvl(sum(decode(to_char(INVOICE_DATE,'mmyy'),to_char(sysdate,'mmyy'),item_qty-nvl(cancel_qty,0))),0) current_month ,
                nvl(sum(decode(to_char(INVOICE_DATE,'mmyy'),to_char(add_months(trunc(sysdate,'mm'),-1),'mmyy'),item_qty-nvl(cancel_qty,0))),0) pre_month  ,
                nvl(sum(decode(to_char(INVOICE_DATE,'mmyy'),to_char(add_months(trunc(sysdate,'mm'),-2),'mmyy'),item_qty-nvl(cancel_qty,0))),0) last_month
                from finc_invoicedtl dtl join finc_invoicemst mst
                on mst.invoice_no_pk=dtl.invoice_no_fk
                join hrms_personnel doc
                on doc.PERSON_NO_PK=mst.PERSON_NO_FK
                join sysc_serviceunit dept
                on dept.SERVICEUNIT_NO_PK=doc.SERVICEUNIT_NO_FK
                where trunc(INVOICE_DATE)
                between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate) and nvl(ADMISSION_NO_PK,0)>0 and nvl(cancel_ind,0)=0
                group by SERVICEUNIT_NAME
                order by 1");
        $opd_dt = DB::select("select SERVICEUNIT_NAME,nvl(count(decode(to_char(appoint_date,'mmyy'),to_char(sysdate,'mmyy'),INVOICE_NO_PK)),0) current_month ,
        nvl(count(decode(to_char(appoint_date,'mmyy'),to_char(add_months(trunc(sysdate,'mm'),-1),'mmyy'),INVOICE_NO_PK)),0) pre_month  ,
        nvl(count(decode(to_char(appoint_date,'mmyy'),to_char(add_months(trunc(sysdate,'mm'),-2),'mmyy'),INVOICE_NO_PK)),0) last_month
        from FINC_DOC_APPOINT_SUM_VW
        where trunc (appoint_date) between add_months(trunc(sysdate,'mm'),-2)and trunc (sysdate)
        and NVL (CANCEL_IND, 0) = 0 AND MODULE_CODE = 'OPDC'
        group by SERVICEUNIT_NAME
        order by 1");
        /**********doctor End********************/

        /**********Bed occupancy********************/
        $total_bed_count = DB::select("select count(*) no_of_bed from ipds_bed where STATUS=1 and AU_ENTRY_HOSPITAL_NO_FK=AU_ENTRY_HOSPITAL_NO_FK");
        $occupied_bed_count = DB::select("select count(*) no_of_bed from ipds_bed where bed_status=2 and AU_ENTRY_HOSPITAL_NO_FK=AU_ENTRY_HOSPITAL_NO_FK");
        $ipd_bed_ocupancy = DB::select("select count(distinct CURR_BED_NO_FK ) no_of_bed,to_char(ADMISSION_DATE,'Month') month,to_char(ADMISSION_DATE,'mmyy')
        from ipd_admission
        where au_entry_hospital_no_fk=au_entry_hospital_no_fk
        and trunc(ADMISSION_DATE)between add_months(trunc(sysdate,'mm'),-2)and trunc(sysdate)
        group by to_char(ADMISSION_DATE,'Month'),to_char(ADMISSION_DATE,'mmyy')
        order by 3 asc");
        /**********Bed occupancy End********************/


        /**********Today Sales Part Start********************/

        $module_codes = [
            'opd_consultation' => 'OPDC',
            'opd_service' => 'OPD',
            'ipd' => 'IPD',
            'pharmacy' => ['PHR', 'PHR-E'],
            'ipd_pharmacy' => 'PHR-I',
            'physiotherapy' => 'PHYSIO',
            'emergency' => 'EMR',
            'cafeteria' => ['CAFE', 'COFFEE'],
            'optical_shop' => 'OPTICAL'
        ];

        $sales_data = [];

        foreach ($module_codes as $module => $codes) {
            $codes = (array) $codes; // Ensure it's always an array for whereIn

            $sales_data[$module] = DB::table('finc_ledgermst as mst')
                ->leftJoin('sysc_module as MOD', 'mst.module_no_fk', '=', 'MOD.module_no_pk')
                ->whereRaw('TRUNC(mst.LEDGER_DATE) = TRUNC(SYSDATE)')
                ->whereIn('MOD.MODULE_CODE', $codes)
                ->selectRaw('SUM(mst.LEDGER_AMT_SALES - mst.LEDGER_AMT_DISCOUNT) as revenue, SUM(mst.LEDGER_AMT_PAYMENT) as collection')
                ->first();
        }


        // Access the sales data for each module like this:
        $opd_consultation_sales = $sales_data['opd_consultation'];
        $opd_service_sales = $sales_data['opd_service'];
        $ipd_sales = $sales_data['ipd'];
        $pharmacy_sales = $sales_data['pharmacy'];
        $ipd_pharmacy_sales = $sales_data['ipd_pharmacy'];
        $physiotherapy_sales = $sales_data['physiotherapy'];
        $cafeteria_sales = $sales_data['cafeteria'];
        $optical_shop_sales = $sales_data['optical_shop'];
        $emergency = $sales_data['emergency'];

        $total_opd_service = DB::table('finc_ledgermst as mst')
            ->join('finc_ledgerdtl as dtl', 'mst.ledger_no_pk', '=', 'dtl.ledger_no_fk')
            ->join('sysc_module as MOD', 'mst.module_no_fk', '=', 'MOD.module_no_pk')
            ->whereRaw('TRUNC(mst.LEDGER_DATE) = TRUNC(SYSDATE)')
            ->whereIn('MOD.MODULE_CODE', ['OPD'])
            ->count('dtl.ITEM_NO_FK');
        $total_phr_service = DB::table('finc_ledgermst as mst')
            ->join('finc_ledgerdtl as dtl', 'mst.ledger_no_pk', '=', 'dtl.ledger_no_fk')
            ->join('sysc_module as MOD', 'mst.module_no_fk', '=', 'MOD.module_no_pk')
            ->whereRaw('TRUNC(mst.LEDGER_DATE) = TRUNC(SYSDATE)')
            ->whereIn('MOD.MODULE_CODE', ['PHR', 'PHR-E'])
            ->count('dtl.ITEM_NO_FK');
        $total_cofee_shop_service = DB::table('finc_ledgermst as mst')
            ->join('finc_ledgerdtl as dtl', 'mst.ledger_no_pk', '=', 'dtl.ledger_no_fk')
            ->join('sysc_module as MOD', 'mst.module_no_fk', '=', 'MOD.module_no_pk')
            ->whereRaw('TRUNC(mst.LEDGER_DATE) = TRUNC(SYSDATE)')
            ->whereIn('MOD.MODULE_CODE', ['CAFE', 'COFFEE'])
            ->count('dtl.ITEM_NO_FK');
        $total_ipd_service = DB::table('finc_ledgermst as mst')
            ->join('finc_ledgerdtl as dtl', 'mst.ledger_no_pk', '=', 'dtl.ledger_no_fk')
            ->join('sysc_module as MOD', 'mst.module_no_fk', '=', 'MOD.module_no_pk')
            ->whereRaw('TRUNC(mst.LEDGER_DATE) = TRUNC(SYSDATE)')
            ->whereIn('MOD.MODULE_CODE', ['PHR-I'])
            ->count('dtl.ITEM_NO_FK');
        $total_opt_service = DB::table('finc_ledgermst as mst')
            ->join('finc_ledgerdtl as dtl', 'mst.ledger_no_pk', '=', 'dtl.ledger_no_fk')
            ->join('sysc_module as MOD', 'mst.module_no_fk', '=', 'MOD.module_no_pk')
            ->whereRaw('TRUNC(mst.LEDGER_DATE) = TRUNC(SYSDATE)')
            ->whereIn('MOD.MODULE_CODE', ['OPTICAL'])
            ->count('dtl.ITEM_NO_FK');
        $emr_sales_dt = DB::table('FINC_LEDGERDTL as dtl')
            ->leftJoin('finc_ledgermst as mst', 'mst.ledger_no_pk', '=', 'dtl.ledger_no_fk')
            ->leftJoin('sysc_module as MOD', 'mst.module_no_fk', '=', 'MOD.module_no_pk')
            ->leftJoin('ipd_admission as ipd', 'mst.ADMISSION_NO_FK', '=', 'ipd.ADMISSION_NO_pK')
            ->whereRaw('TRUNC(LEDGER_DATE) = TRUNC(SYSDATE)')
            ->where('ipd.iptype_ind', 2)
            ->select(
                DB::raw('COUNT(dtl.ITEM_NO_FK) as total_service'),
                DB::raw('SUM(mst.LEDGER_AMT_SALES - mst.LEDGER_AMT_DISCOUNT) as revenue'),
                DB::raw('SUM(mst.LEDGER_AMT_PAYMENT) as collection')
            )
            ->first();
        $emr_sales_opd_dt = DB::table('FINC_LEDGERDTL as dtl')
            ->leftJoin('finc_ledgermst as mst', 'mst.ledger_no_pk', '=', 'dtl.ledger_no_fk')
            ->leftJoin('sysc_module as MOD', 'mst.module_no_fk', '=', 'MOD.module_no_pk')
            ->leftJoin('ipd_admission as ipd', 'mst.ADMISSION_NO_FK', '=', 'ipd.ADMISSION_NO_pK')
            ->whereRaw('TRUNC(LEDGER_DATE) = TRUNC(SYSDATE)')
            ->where('ipd.iptype_ind', 1)
            ->where('ipd.ref_from_emr_ind', 1)
            ->select(
                DB::raw('COUNT(dtl.ITEM_NO_FK) as total_service'),
                DB::raw('SUM(mst.LEDGER_AMT_SALES - mst.LEDGER_AMT_DISCOUNT) as revenue'),
                DB::raw('SUM(mst.LEDGER_AMT_PAYMENT) as collection')
            )
            ->first();

        $ipd_sales_dt = DB::table('FINC_LEDGERDTL as dtl')
            ->leftJoin('finc_ledgermst as mst', 'mst.ledger_no_pk', '=', 'dtl.ledger_no_fk')
            ->leftJoin('sysc_module as MOD', 'mst.module_no_fk', '=', 'MOD.module_no_pk')
            ->leftJoin('ipd_admission as ipd', 'mst.ADMISSION_NO_FK', '=', 'ipd.ADMISSION_NO_pK')
            ->whereRaw('TRUNC(LEDGER_DATE) = TRUNC(SYSDATE)')
            ->where('ipd.iptype_ind', 1)
            ->select(
                DB::raw('COUNT(dtl.ITEM_NO_FK) as total_service'),
                DB::raw('SUM(mst.LEDGER_AMT_SALES - mst.LEDGER_AMT_DISCOUNT) as revenue'),
                DB::raw('SUM(mst.LEDGER_AMT_PAYMENT) as collection')
            )
            ->first();

        $ipd_sales_dt_rev = DB::table('FINC_LEDGERDTL as dtl')
            ->leftJoin('finc_ledgermst as mst', 'mst.ledger_no_pk', '=', 'dtl.ledger_no_fk')
            ->leftJoin('sysc_module as MOD', 'mst.module_no_fk', '=', 'MOD.module_no_pk')
            ->leftJoin('ipd_admission as ipd', 'mst.ADMISSION_NO_FK', '=', 'ipd.ADMISSION_NO_pK')
            ->whereRaw('TRUNC(LEDGER_DATE) = TRUNC(SYSDATE)')
            ->where('ipd.iptype_ind', 1)
            ->where('ipd.dis_ind', 1)
            ->select(
                DB::raw('SUM(mst.LEDGER_AMT_SALES - mst.LEDGER_AMT_DISCOUNT) as revenue')
            )
            ->first();

        $today_admission_ipd = DB::table('ipd_admission')
            ->where('iptype_ind', 1)
            ->selectRaw('SUM(CASE WHEN TRUNC(ADMISSION_DATE) = TRUNC(SYSDATE) THEN 1 ELSE 0 END) as today')
            ->value('today');
        $today_discharge_ipd = DB::table('ipd_admission')
            ->where('iptype_ind', 1)
            ->where('dis_ind', 1)
            ->selectRaw('SUM(CASE WHEN TRUNC(DIS_DATE) = TRUNC(SYSDATE) THEN 1 ELSE 0 END) as today')
            ->value('today');
        $today_admission_emr = DB::table('ipd_admission')
            ->where('iptype_ind', 2)
            ->selectRaw('SUM(CASE WHEN TRUNC(ADMISSION_DATE) = TRUNC(SYSDATE) THEN 1 ELSE 0 END) as today')
            ->value('today');
        $today_admission_emr_opd = DB::table('ipd_admission')
            ->where('iptype_ind', 1)
            ->where('ref_from_emr_ind', 1)
            ->selectRaw('SUM(CASE WHEN TRUNC(ADMISSION_DATE) = TRUNC(SYSDATE) THEN 1 ELSE 0 END) as today')
            ->value('today');


        /**********Today Sales Part End********************/




        return Template::loadview("admin.uhl.management-dashboard", [
            'hospital_summary_opd' => $hospital_summary_opd,
            'hospital_summary_ipd' => $hospital_summary_ipd,
            'hospital_summary_phr' => $hospital_summary_phr,
            'hospital_summary_emergency' => $hospital_summary_emergency,
            'hospital_summary_daycare' => $hospital_summary_daycare,
            'hospital_summary_ot' => $hospital_summary_ot,
            'hospital_summary_ipd_cons' => $hospital_summary_ipd_cons,
            'opdc_cons' => $opdc_cons,
            'ipdc_cons_month' => $ipdc_cons_month,
            'ipdc_cons' => $ipdc_cons,
            'emergency_cons' => $emergency_cons,
            'adm_cons' => $adm_cons,
            'ipd_conversation' => $ipd_conversation,
            'opd_lst' => $opd_lst,
            'emr_lst' => $emr_lst,
            'others_lst' => $others_lst,
            'total_bed_count' => $total_bed_count,
            'occupied_bed_count' => $occupied_bed_count,
            'ipd_bed_ocupancy' => $ipd_bed_ocupancy,
            'phr' => $phr,
            'phr_i' => $phr_i,
            'phr_e' => $phr_e,
            'phr_d' => $phr_d,
            'phr_dy' => $phr_dy,
            'loc' => $loc,
            'doctor_dt' => $doctor_dt,
            'ipd_dt' => $ipd_dt,
            'opd_dt' => $opd_dt,
            'opdc_month1' => $opdc_month1,
            'opdc_month2' => $opdc_month2,
            'opdc_month3' => $opdc_month3,
            'opd_consultation_sales' => $opd_consultation_sales,
            'opd_service_sales' => $opd_service_sales,
            'ipd_sales' => $ipd_sales,
            'pharmacy_sales' => $pharmacy_sales,
            'ipd_pharmacy_sales' => $ipd_pharmacy_sales,
            'physiotherapy_sales' => $physiotherapy_sales,
            'cafeteria_sales' => $cafeteria_sales,
            'optical_shop_sales' => $optical_shop_sales,
            'emergency' => $emergency,
            'total_opd_service' => $total_opd_service,
            'today_admission_ipd' => $today_admission_ipd,
            'today_admission_emr' => $today_admission_emr,
            'total_phr_service' => $total_phr_service,
            'total_ipd_service' => $total_ipd_service,
            'emr_sales_dt' => $emr_sales_dt,
            'ipd_sales_dt' => $ipd_sales_dt,
            'total_cofee_shop_service' => $total_cofee_shop_service,
            'total_opt_service' => $total_opt_service,
            'ipd_sales_dt_rev' => $ipd_sales_dt_rev,
            'today_discharge_ipd' => $today_discharge_ipd,
            'today_admission_emr_opd' => $today_admission_emr_opd,
            'emr_sales_opd_dt' => $emr_sales_opd_dt,

        ]);
    }


    // Pathology Dashboard
    public function pathologyDashboardV1()
    {
        /************************Today Lab Ordered start************/
        $today_lab_dt = DB::select("SELECT sum(case when nvl(ADMISSION_NO_PK,0) >0 then ITEM_QTY-NVL(CANCEL_QTY,0) else 0 end) ipdtest,
        sum(case when nvl(ADMISSION_NO_PK,0) >0 then 1 else 0 end) ipdpat ,sum(case when nvl(ADMISSION_NO_PK,0) =0 then 1 else 0 end) opdpat,
         sum(case when nvl(ADMISSION_NO_PK,0) =0 then ITEM_QTY-NVL(CANCEL_QTY,0) else 0 end) opdtest
        FROM FINC_INVOICEDTL DTL JOIN finc_invoicemst mst
        on dtl.invoice_no_fk=mst.invoice_no_pk
        join sysc_itemtype type
        on dtl.ITEMTYPE_NO_FK=type.ITEMTYPE_NO_PK
        where trunc(invoice_date) =trunc(sysdate)
        and ITEMTYPE_CODE='LAB'");
        $yesterday_lab_dt = DB::select("SELECT sum(case when nvl(ADMISSION_NO_PK,0) >0 then ITEM_QTY-NVL(CANCEL_QTY,0) else 0 end) ipdtest,
        sum(case when nvl(ADMISSION_NO_PK,0) >0 then 1 else 0 end) ipdpat ,sum(case when nvl(ADMISSION_NO_PK,0) =0 then 1 else 0 end) opdpat,
         sum(case when nvl(ADMISSION_NO_PK,0) =0 then ITEM_QTY-NVL(CANCEL_QTY,0) else 0 end) opdtest
        FROM FINC_INVOICEDTL DTL JOIN finc_invoicemst mst
        on dtl.invoice_no_fk=mst.invoice_no_pk
        join sysc_itemtype type
        on dtl.ITEMTYPE_NO_FK=type.ITEMTYPE_NO_PK
        where trunc(invoice_date) =trunc(sysdate-1)
        and ITEMTYPE_CODE='LAB'");
        $monthly_lab_dt = DB::select("SELECT sum(case when nvl(ADMISSION_NO_PK,0) >0 then ITEM_QTY-NVL(CANCEL_QTY,0) else 0 end) ipdtest,
        sum(case when nvl(ADMISSION_NO_PK,0) >0 then 1 else 0 end) ipdpat ,sum(case when nvl(ADMISSION_NO_PK,0) =0 then 1 else 0 end) opdpat,
         sum(case when nvl(ADMISSION_NO_PK,0) =0 then ITEM_QTY-NVL(CANCEL_QTY,0) else 0 end) opdtest
        FROM FINC_INVOICEDTL DTL JOIN finc_invoicemst mst
        on dtl.invoice_no_fk=mst.invoice_no_pk
        join sysc_itemtype type
        on dtl.ITEMTYPE_NO_FK=type.ITEMTYPE_NO_PK
        where trunc(invoice_date) between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy') and trunc(sysdate)
        and ITEMTYPE_CODE='LAB'");
        $t_sample_collection_yesterday = DB::select("select count( *) tot_sam,count( ADMISSION_NO_PK) ipd_sam , count(distinct ADMISSION_NO_PK) ipd_patient ,count (distinct case when  ADMISSION_NO_PK is null then PERSON_NO_FK else null end ) opd_patient,sum ( case when  ADMISSION_NO_PK is null then 1 else 0 end ) opd_sam
        from labt_invoicedtl dtl, finc_invoicemst mst
        where trunc(sc_sample_coll_keyed_time) = trunc(sysdate-1)
        and DTL.INVOICE_NO_FK=MST.INVOICE_NO_PK");

        /************************Today Lab Ordered End************/
        /************************Today Sample Collection Start ************/
        $t_sample_collection = DB::select("select count( *) tot_sam,count( ADMISSION_NO_PK) ipd_sam , count(distinct ADMISSION_NO_PK) ipd_patient ,count (distinct case when  ADMISSION_NO_PK is null then PERSON_NO_FK else null end ) opd_patient,sum ( case when  ADMISSION_NO_PK is null then 1 else 0 end ) opd_sam
        from labt_invoicedtl dtl, finc_invoicemst mst
        where trunc(sc_sample_coll_keyed_time) = trunc(sysdate)
        and DTL.INVOICE_NO_FK=MST.INVOICE_NO_PK");
        $sample_collection_this_month = DB::select("select count( *) tot_sam,count( ADMISSION_NO_PK) ipd_sam , count(distinct ADMISSION_NO_PK) ipd_patient ,count (distinct case when  ADMISSION_NO_PK is null then PERSON_NO_FK else null end ) opd_patient,sum ( case when  ADMISSION_NO_PK is null then 1 else 0 end ) opd_sam
         from labt_invoicedtl dtl, finc_invoicemst mst
         where trunc(sc_sample_coll_keyed_time) between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy') and  trunc(sysdate)
         and DTL.INVOICE_NO_FK=MST.INVOICE_NO_PK");



        $t_report_delivery = DB::select("select count( *) tot_sam,count( ADMISSION_NO_PK) ipd_sam , count(distinct ADMISSION_NO_PK) ipd_patient ,count (distinct case when  ADMISSION_NO_PK is null then PERSON_NO_FK else null end ) opd_patient,sum ( case when  ADMISSION_NO_PK is null then 1 else 0 end ) opd_sam
         from labt_testreporting dtl, finc_invoicemst mst
         where trunc(REPORT_DELIVERED_TIME) = trunc(sysdate)
         and DTL.INVOICE_NO_FK=MST.INVOICE_NO_PK");
        $t_report_delivery_yesterday = DB::select("select count( *) tot_sam,count( ADMISSION_NO_PK) ipd_sam , count(distinct ADMISSION_NO_PK) ipd_patient ,count (distinct case when  ADMISSION_NO_PK is null then PERSON_NO_FK else null end ) opd_patient,sum ( case when  ADMISSION_NO_PK is null then 1 else 0 end ) opd_sam
         from labt_testreporting dtl, finc_invoicemst mst
         where trunc(REPORT_DELIVERED_TIME) = trunc(sysdate-1)
         and DTL.INVOICE_NO_FK=MST.INVOICE_NO_PK");
        $t_report_delivery_month = DB::select("select count( *) tot_sam,count( ADMISSION_NO_PK) ipd_sam , count(distinct ADMISSION_NO_PK) ipd_patient ,count (distinct case when  ADMISSION_NO_PK is null then PERSON_NO_FK else null end ) opd_patient,sum ( case when  ADMISSION_NO_PK is null then 1 else 0 end ) opd_sam
         from labt_testreporting dtl, finc_invoicemst mst
         where trunc(REPORT_DELIVERED_TIME) between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy') and trunc(sysdate)
         and DTL.INVOICE_NO_FK=MST.INVOICE_NO_PK");
        $top_tests = DB::select("  SELECT COUNT (*) qty, item.item_name
         FROM FINC_INVOICEDTL DTL
              JOIN finc_invoicemst mst
                 ON dtl.invoice_no_fk = mst.invoice_no_pk
              JOIN sysc_serviceitem item
                 ON ITEM.ITEM_NO_PK = DTL.ITEM_NO_FK
              JOIN sysc_itemtype TYPE
                 ON item.ITEMTYPE_NO_FK = TYPE.ITEMTYPE_NO_PK
        WHERE TRUNC (invoice_date) BETWEEN TRUNC (SYSDATE - 90) AND TRUNC (SYSDATE)
              AND ITEMTYPE_CODE = 'LAB'
              AND NVL (CONTAINER_IND, 0) = 0
     GROUP BY item_no_fk, item.item_name
     ORDER BY 1 DESC");
        $top_department = DB::select("  SELECT COUNT (*) qty, unit.SERVICEUNIT_NAME
     FROM FINC_INVOICEDTL DTL
          JOIN finc_invoicemst mst
             ON dtl.invoice_no_fk = mst.invoice_no_pk
          JOIN sysc_serviceitem item
             ON ITEM.ITEM_NO_PK = DTL.ITEM_NO_FK
          JOIN sysc_itemtype TYPE
             ON item.ITEMTYPE_NO_FK = TYPE.ITEMTYPE_NO_PK
          JOIN sysc_serviceunit unit
             ON item.SERVICEUNIT_NO_FK = unit.SERVICEUNIT_NO_PK
    WHERE TRUNC (invoice_date) BETWEEN TRUNC (SYSDATE - 90) AND TRUNC (SYSDATE)
          AND ITEMTYPE_CODE = 'LAB'
          AND NVL (CONTAINER_IND, 0) = 0
 GROUP BY unit.SERVICEUNIT_NAME
 ORDER BY 1 DESC");
        $top_referral = DB::select("SELECT count(*) qty,unit.SERVICEUNIT_NAME
     FROM FINC_INVOICEDTL DTL JOIN finc_invoicemst mst
     on dtl.invoice_no_fk=mst.invoice_no_pk
      join sysc_serviceitem item
      on ITEM.ITEM_NO_PK=DTL.ITEM_NO_FK
      join sysc_itemtype type
     on item.ITEMTYPE_NO_FK=type.ITEMTYPE_NO_PK
     join hrms_personnel doc
     on DOC.PERSON_NO_PK=MST.PERSON_NO_FK
     join sysc_serviceunit unit
     on doc.SERVICEUNIT_NO_FK=unit.SERVICEUNIT_NO_PK
     where trunc(invoice_date) between trunc(sysdate-90) and  trunc(sysdate)
     and ITEMTYPE_CODE='LAB'
     and nvl(CONTAINER_IND,0)=0
     group by unit.SERVICEUNIT_NAME
     order by 1 desc");
        $order_per_hour = DB::select("select sum( item_qty-nvl(cancel_qty,0)) opdtest,to_char(invoice_date,'hh24') hr
        from finc_invoicedtl dtl join finc_invoicemst mst
        on dtl.invoice_no_fk=mst.invoice_no_pk
        join sysc_serviceitem item
        on item.item_no_pk=dtl.item_no_fk
        and nvl(container_ind,0)=0
        join sysc_itemtype type
        on item.itemtype_no_fk=type.itemtype_no_pk
        and itemtype_code='LAB'
        where trunc(invoice_date)  = trunc(sysdate)
        group by to_char(invoice_date,'hh24')
        order by 2");

        $order_value1 = isset($order_per_hour[0]->opdtest) ? $order_per_hour[0]->opdtest : 0;
        $order_value2 = isset($order_per_hour[1]->opdtest) ? $order_per_hour[1]->opdtest : 0;
        $order_value3 = isset($order_per_hour[2]->opdtest) ? $order_per_hour[2]->opdtest : 0;
        $order_value4 = isset($order_per_hour[3]->opdtest) ? $order_per_hour[3]->opdtest : 0;
        $order_value5 = isset($order_per_hour[4]->opdtest) ? $order_per_hour[4]->opdtest : 0;
        $order_value6 = isset($order_per_hour[5]->opdtest) ? $order_per_hour[5]->opdtest : 0;
        $order_value7 = isset($order_per_hour[6]->opdtest) ? $order_per_hour[6]->opdtest : 0;
        $order_value8 = isset($order_per_hour[7]->opdtest) ? $order_per_hour[7]->opdtest : 0;
        $order_value9 = isset($order_per_hour[8]->opdtest) ? $order_per_hour[8]->opdtest : 0;
        $order_value10 = isset($order_per_hour[9]->opdtest) ? $order_per_hour[9]->opdtest : 0;
        $order_hour_test = "$order_value1,$order_value2,$order_value3,$order_value4,$order_value5,$order_value6,$order_value7,$order_value8,$order_value9,$order_value10";


        $order_value1_hr = isset($order_per_hour[0]->hr) ? $order_per_hour[0]->hr : 0;
        $order_value2_hr = isset($order_per_hour[1]->opdtest) ? $order_per_hour[1]->hr : 0;
        $order_value3_hr = isset($order_per_hour[2]->hr) ? $order_per_hour[2]->hr : 0;
        $order_value4_hr = isset($order_per_hour[3]->hr) ? $order_per_hour[3]->hr : 0;
        $order_value5_hr = isset($order_per_hour[4]->hr) ? $order_per_hour[4]->hr : 0;
        $order_value6_hr = isset($order_per_hour[5]->hr) ? $order_per_hour[5]->hr : 0;
        $order_value7_hr = isset($order_per_hour[6]->hr) ? $order_per_hour[6]->hr : 0;
        $order_value8_hr = isset($order_per_hour[7]->hr) ? $order_per_hour[7]->hr : 0;
        $order_value9_hr = isset($order_per_hour[8]->hr) ? $order_per_hour[8]->hr : 0;
        $order_value10_hr = isset($order_per_hour[9]->hr) ? $order_per_hour[9]->hr : 0;
        $order_hour_hr = "$order_value1_hr,$order_value2_hr,$order_value3_hr,$order_value4_hr,$order_value5_hr,$order_value6_hr,$order_value7_hr,$order_value8_hr,$order_value9_hr,$order_value10_hr";

        $growth_three_month = DB::select("select sum( item_qty-nvl(cancel_qty,0)) opdtest,to_char(invoice_date,'hh24') hr
     from finc_invoicedtl dtl join finc_invoicemst mst
     on dtl.invoice_no_fk=mst.invoice_no_pk
     join sysc_serviceitem item
      on item.item_no_pk=dtl.item_no_fk
      and nvl(container_ind,0)=0
      join sysc_itemtype type
     on item.itemtype_no_fk=type.itemtype_no_pk
     and itemtype_code='LAB'
     where trunc(invoice_date)  = trunc(sysdate)
     group by to_char(invoice_date,'hh24')
     order by 2");
        $growth_three_value1 = isset($growth_three_month[0]->opdtest) ? $growth_three_month[0]->opdtest : 0;
        $growth_three_value2 = isset($growth_three_month[1]->opdtest) ? $growth_three_month[1]->opdtest : 0;
        $growth_three_value3 = isset($growth_three_month[2]->opdtest) ? $growth_three_month[2]->opdtest : 0;
        $growth_three_value4 = isset($growth_three_month[3]->opdtest) ? $growth_three_month[3]->opdtest : 0;
        $growth_three_value5 = isset($growth_three_month[4]->opdtest) ? $growth_three_month[4]->opdtest : 0;
        $growth_three_value6 = isset($growth_three_month[5]->opdtest) ? $growth_three_month[5]->opdtest : 0;
        $growth_three_value7 = isset($growth_three_month[6]->opdtest) ? $growth_three_month[6]->opdtest : 0;
        $growth_three_value8 = isset($growth_three_month[7]->opdtest) ? $growth_three_month[7]->opdtest : 0;
        $growth_three_value9 = isset($growth_three_month[8]->opdtest) ? $growth_three_month[8]->opdtest : 0;
        $growth_three_value10 = isset($growth_three_month[9]->opdtest) ? $growth_three_month[9]->opdtest : 0;
        $growth_three_hour_test = "$growth_three_value1,$growth_three_value2,$growth_three_value3,$growth_three_value4,$growth_three_value5,$growth_three_value6,$growth_three_value7,$growth_three_value8,$growth_three_value9,$growth_three_value10";


        $growth_three_value1_hr = isset($growth_three_month[0]->hr) ? $growth_three_month[0]->hr : 0;
        $growth_three_value2_hr = isset($growth_three_month[1]->opdtest) ? $growth_three_month[1]->hr : 0;
        $growth_three_value3_hr = isset($growth_three_month[2]->hr) ? $growth_three_month[2]->hr : 0;
        $growth_three_value4_hr = isset($growth_three_month[3]->hr) ? $growth_three_month[3]->hr : 0;
        $growth_three_value5_hr = isset($growth_three_month[4]->hr) ? $growth_three_month[4]->hr : 0;
        $growth_three_value6_hr = isset($growth_three_month[5]->hr) ? $growth_three_month[5]->hr : 0;
        $growth_three_value7_hr = isset($growth_three_month[6]->hr) ? $growth_three_month[6]->hr : 0;
        $growth_three_value8_hr = isset($growth_three_month[7]->hr) ? $growth_three_month[7]->hr : 0;
        $growth_three_value9_hr = isset($growth_three_month[8]->hr) ? $growth_three_month[8]->hr : 0;
        $growth_three_value10_hr = isset($growth_three_month[9]->hr) ? $growth_three_month[9]->hr : 0;
        $growth_three_hour_hr = "$growth_three_value1_hr,$growth_three_value2_hr,$growth_three_value3_hr,$growth_three_value4_hr,$growth_three_value5_hr,$growth_three_value6_hr,$growth_three_value7_hr,$growth_three_value8_hr,$growth_three_value9_hr,$growth_three_value10_hr";

        /************************Today Sample Collection End************/
        return Template::loadView("admin.uhl.pathology-dashboard", [
            'today_lab_dt' => $today_lab_dt,
            'yesterday_lab_dt' => $yesterday_lab_dt,
            'monthly_lab_dt' => $monthly_lab_dt,
            't_sample_collection' => $t_sample_collection,
            't_sample_collection_yesterday' => $t_sample_collection_yesterday,
            'sample_collection_this_month' => $sample_collection_this_month,
            't_report_delivery' => $t_report_delivery,
            't_report_delivery_yesterday' => $t_report_delivery_yesterday,
            't_report_delivery_month' => $t_report_delivery_month,

            'top_tests' => $top_tests,
            'top_department' => $top_department,
            'top_referral' => $top_referral,
            'order_per_hour' => $order_per_hour,
            'growth_three_month' => $growth_three_month,
            'order_hour_test' => $order_hour_test,
            'order_hour_hr' => $order_hour_hr,
            'growth_three_hour_test' => $growth_three_hour_test,
            'growth_three_hour_hr' => $growth_three_hour_hr,

        ]);
    }

    // Radiology Dashboard
    public function radiologyDashboardV1()
    {

        /************************Today Lab Ordered start************/
        $today_lab_dt = DB::select("SELECT sum(case when nvl(ADMISSION_NO_PK,0) >0 then ITEM_QTY-NVL(CANCEL_QTY,0) else 0 end) ipdtest,
        sum(case when nvl(ADMISSION_NO_PK,0) >0 then 1 else 0 end) ipdpat ,sum(case when nvl(ADMISSION_NO_PK,0) =0 then 1 else 0 end) opdpat,
         sum(case when nvl(ADMISSION_NO_PK,0) =0 then ITEM_QTY-NVL(CANCEL_QTY,0) else 0 end) opdtest
        FROM FINC_INVOICEDTL DTL JOIN finc_invoicemst mst
        on dtl.invoice_no_fk=mst.invoice_no_pk
        join sysc_serviceitem item
         on ITEM.ITEM_NO_PK=DTL.ITEM_NO_FK
         and nvl(CONTAINER_IND,0)=0
         join sysc_itemtype type
        on item.ITEMTYPE_NO_FK=type.ITEMTYPE_NO_PK
        where trunc(invoice_date) =trunc(sysdate)
        and ITEMTYPE_CODE='RAD'");
        $yesterday_lab_dt = DB::select("SELECT sum(case when nvl(ADMISSION_NO_PK,0) >0 then ITEM_QTY-NVL(CANCEL_QTY,0) else 0 end) ipdtest,
        sum(case when nvl(ADMISSION_NO_PK,0) >0 then 1 else 0 end) ipdpat ,sum(case when nvl(ADMISSION_NO_PK,0) =0 then 1 else 0 end) opdpat,
         sum(case when nvl(ADMISSION_NO_PK,0) =0 then ITEM_QTY-NVL(CANCEL_QTY,0) else 0 end) opdtest
        FROM FINC_INVOICEDTL DTL JOIN finc_invoicemst mst
        on dtl.invoice_no_fk=mst.invoice_no_pk
        join sysc_serviceitem item
         on ITEM.ITEM_NO_PK=DTL.ITEM_NO_FK
         and nvl(CONTAINER_IND,0)=0
         join sysc_itemtype type
        on item.ITEMTYPE_NO_FK=type.ITEMTYPE_NO_PK
        where trunc(invoice_date) =trunc(sysdate-1)
        and ITEMTYPE_CODE='RAD'");
        $monthly_lab_dt = DB::select("SELECT sum(case when nvl(ADMISSION_NO_PK,0) >0 then ITEM_QTY-NVL(CANCEL_QTY,0) else 0 end) ipdtest,
        sum(case when nvl(ADMISSION_NO_PK,0) >0 then 1 else 0 end) ipdpat ,sum(case when nvl(ADMISSION_NO_PK,0) =0 then 1 else 0 end) opdpat,
         sum(case when nvl(ADMISSION_NO_PK,0) =0 then ITEM_QTY-NVL(CANCEL_QTY,0) else 0 end) opdtest
        FROM FINC_INVOICEDTL DTL JOIN finc_invoicemst mst
        on dtl.invoice_no_fk=mst.invoice_no_pk
        join sysc_serviceitem item
         on ITEM.ITEM_NO_PK=DTL.ITEM_NO_FK
         and nvl(CONTAINER_IND,0)=0
         join sysc_itemtype type
        on item.ITEMTYPE_NO_FK=type.ITEMTYPE_NO_PK
        where trunc(invoice_date) between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy') and trunc(sysdate)
        and ITEMTYPE_CODE='RAD'");
        $t_sample_collection_yesterday = DB::select("select count( *) tot_sam,count( ADMISSION_NO_PK) ipd_sam , count(distinct ADMISSION_NO_PK) ipd_patient ,count (distinct case when  ADMISSION_NO_PK is null then PERSON_NO_FK else null end ) opd_patient,sum ( case when  ADMISSION_NO_PK is null then 1 else 0 end ) opd_sam
        from radt_invoicedtl dtl, finc_invoicemst mst
        where trunc(ic_image_capture_keyed_time) = trunc(sysdate-1)
        and DTL.INVOICE_NO_FK=MST.INVOICE_NO_PK");

        /************************Today Lab Ordered End************/
        /************************Today Sample Collection Start ************/
        $t_sample_collection = DB::select("select count( *) tot_sam,count( ADMISSION_NO_PK) ipd_sam , count(distinct ADMISSION_NO_PK) ipd_patient ,count (distinct case when  ADMISSION_NO_PK is null then PERSON_NO_FK else null end ) opd_patient,sum ( case when  ADMISSION_NO_PK is null then 1 else 0 end ) opd_sam
        from radt_invoicedtl dtl, finc_invoicemst mst
        where trunc(ic_image_capture_keyed_time) = trunc(sysdate)
        and DTL.INVOICE_NO_FK=MST.INVOICE_NO_PK");
        $sample_collection_this_month = DB::select("select count( *) tot_sam,count( ADMISSION_NO_PK) ipd_sam , count(distinct ADMISSION_NO_PK) ipd_patient ,count (distinct case when  ADMISSION_NO_PK is null then PERSON_NO_FK else null end ) opd_patient,sum ( case when  ADMISSION_NO_PK is null then 1 else 0 end ) opd_sam
         from radt_invoicedtl dtl, finc_invoicemst mst
         where trunc(ic_image_capture_keyed_time) between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy') and  trunc(sysdate)
         and DTL.INVOICE_NO_FK=MST.INVOICE_NO_PK");

        $t_report_delivery = DB::select("select count( *) tot_sam,count( ADMISSION_NO_PK) ipd_sam , count(distinct ADMISSION_NO_PK) ipd_patient ,count (distinct case when  ADMISSION_NO_PK is null then PERSON_NO_FK else null end ) opd_patient,sum ( case when  ADMISSION_NO_PK is null then 1 else 0 end ) opd_sam
         from RADT_REPORTING dtl, finc_invoicemst mst
         where trunc(DELIVERED_TIME) = trunc(sysdate)
         and DTL.INVOICE_NO_FK=MST.INVOICE_NO_PK");
        $t_report_delivery_yesterday = DB::select("select count( *) tot_sam,count( ADMISSION_NO_PK) ipd_sam , count(distinct ADMISSION_NO_PK) ipd_patient ,count (distinct case when  ADMISSION_NO_PK is null then PERSON_NO_FK else null end ) opd_patient,sum ( case when  ADMISSION_NO_PK is null then 1 else 0 end ) opd_sam
         from RADT_REPORTING dtl, finc_invoicemst mst
         where trunc(DELIVERED_TIME) = trunc(sysdate-1)
         and DTL.INVOICE_NO_FK=MST.INVOICE_NO_PK");
        $t_report_delivery_month = DB::select("select count( *) tot_sam,count( ADMISSION_NO_PK) ipd_sam , count(distinct ADMISSION_NO_PK) ipd_patient ,count (distinct case when  ADMISSION_NO_PK is null then PERSON_NO_FK else null end ) opd_patient,sum ( case when  ADMISSION_NO_PK is null then 1 else 0 end ) opd_sam
         from RADT_REPORTING dtl, finc_invoicemst mst
         where trunc(DELIVERED_TIME) between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy') and trunc(sysdate)
         and DTL.INVOICE_NO_FK=MST.INVOICE_NO_PK");
        $top_tests = DB::select("SELECT count(*) ,item.item_name
         FROM FINC_INVOICEDTL DTL JOIN finc_invoicemst mst
         on dtl.invoice_no_fk=mst.invoice_no_pk
          join sysc_serviceitem item
          on ITEM.ITEM_NO_PK=DTL.ITEM_NO_FK
          join sysc_itemtype type
         on item.ITEMTYPE_NO_FK=type.ITEMTYPE_NO_PK
         where trunc(invoice_date) between trunc(sysdate-90) and  trunc(sysdate)
         and ITEMTYPE_CODE='RAD'
         and nvl(CONTAINER_IND,0)=0
         group by item_no_fk,item.item_name
         order by 1 desc");
        $top_department = DB::select("SELECT count(*) ,unit.SERVICEUNIT_NAME
     FROM FINC_INVOICEDTL DTL JOIN finc_invoicemst mst
     on dtl.invoice_no_fk=mst.invoice_no_pk
      join sysc_serviceitem item
      on ITEM.ITEM_NO_PK=DTL.ITEM_NO_FK
      join sysc_itemtype type
     on item.ITEMTYPE_NO_FK=type.ITEMTYPE_NO_PK
     join sysc_serviceunit unit
     on item.SERVICEUNIT_NO_FK=unit.SERVICEUNIT_NO_PK
     where trunc(invoice_date) between trunc(sysdate-90) and  trunc(sysdate)
     and ITEMTYPE_CODE='RAD'
     and nvl(CONTAINER_IND,0)=0
     group by unit.SERVICEUNIT_NAME
     order by 1 desc");
        $top_referral = DB::select("SELECT count(*) ,unit.SERVICEUNIT_NAME
     FROM FINC_INVOICEDTL DTL JOIN finc_invoicemst mst
     on dtl.invoice_no_fk=mst.invoice_no_pk
      join sysc_serviceitem item
      on ITEM.ITEM_NO_PK=DTL.ITEM_NO_FK
      join sysc_itemtype type
     on item.ITEMTYPE_NO_FK=type.ITEMTYPE_NO_PK
     join hrms_personnel doc
     on DOC.PERSON_NO_PK=MST.PERSON_NO_FK
     join sysc_serviceunit unit
     on doc.SERVICEUNIT_NO_FK=unit.SERVICEUNIT_NO_PK
     where trunc(invoice_date) between trunc(sysdate-90) and  trunc(sysdate)
     and ITEMTYPE_CODE='RAD'
     and nvl(CONTAINER_IND,0)=0
     group by unit.SERVICEUNIT_NAME
     order by 1 desc");
        $order_per_hour = DB::select("select sum( item_qty-nvl(cancel_qty,0)) opdtest,to_char(invoice_date,'hh24') hr
     from finc_invoicedtl dtl join finc_invoicemst mst
     on dtl.invoice_no_fk=mst.invoice_no_pk
     join sysc_serviceitem item
      on item.item_no_pk=dtl.item_no_fk
      and nvl(container_ind,0)=0
      join sysc_itemtype type
     on item.itemtype_no_fk=type.itemtype_no_pk
     and itemtype_code='RAD'
     where trunc(invoice_date)  = trunc(sysdate)
     group by to_char(invoice_date,'hh24')
     order by 2");

        $order_value1 = isset($order_per_hour[0]->opdtest) ? $order_per_hour[0]->opdtest : 0;
        $order_value2 = isset($order_per_hour[1]->opdtest) ? $order_per_hour[1]->opdtest : 0;
        $order_value3 = isset($order_per_hour[2]->opdtest) ? $order_per_hour[2]->opdtest : 0;
        $order_value4 = isset($order_per_hour[3]->opdtest) ? $order_per_hour[3]->opdtest : 0;
        $order_value5 = isset($order_per_hour[4]->opdtest) ? $order_per_hour[4]->opdtest : 0;
        $order_value6 = isset($order_per_hour[5]->opdtest) ? $order_per_hour[5]->opdtest : 0;
        $order_value7 = isset($order_per_hour[6]->opdtest) ? $order_per_hour[6]->opdtest : 0;
        $order_value8 = isset($order_per_hour[7]->opdtest) ? $order_per_hour[7]->opdtest : 0;
        $order_value9 = isset($order_per_hour[8]->opdtest) ? $order_per_hour[8]->opdtest : 0;
        $order_value10 = isset($order_per_hour[9]->opdtest) ? $order_per_hour[9]->opdtest : 0;
        $order_hour_test = "$order_value1,$order_value2,$order_value3,$order_value4,$order_value5,$order_value6,$order_value7,$order_value8,$order_value9,$order_value10";


        $order_value1_hr = isset($order_per_hour[0]->hr) ? $order_per_hour[0]->hr : 0;
        $order_value2_hr = isset($order_per_hour[1]->opdtest) ? $order_per_hour[1]->hr : 0;
        $order_value3_hr = isset($order_per_hour[2]->hr) ? $order_per_hour[2]->hr : 0;
        $order_value4_hr = isset($order_per_hour[3]->hr) ? $order_per_hour[3]->hr : 0;
        $order_value5_hr = isset($order_per_hour[4]->hr) ? $order_per_hour[4]->hr : 0;
        $order_value6_hr = isset($order_per_hour[5]->hr) ? $order_per_hour[5]->hr : 0;
        $order_value7_hr = isset($order_per_hour[6]->hr) ? $order_per_hour[6]->hr : 0;
        $order_value8_hr = isset($order_per_hour[7]->hr) ? $order_per_hour[7]->hr : 0;
        $order_value9_hr = isset($order_per_hour[8]->hr) ? $order_per_hour[8]->hr : 0;
        $order_value10_hr = isset($order_per_hour[9]->hr) ? $order_per_hour[9]->hr : 0;
        $order_hour_hr = "$order_value1_hr,$order_value2_hr,$order_value3_hr,$order_value4_hr,$order_value5_hr,$order_value6_hr,$order_value7_hr,$order_value8_hr,$order_value9_hr,$order_value10_hr";

        $growth_three_month = DB::select("select sum( item_qty-nvl(cancel_qty,0)) opdtest,
     nvl(sum(decode(to_char(invoice_date,'mmyyyy'),to_char(sysdate,'mmyyyy'), item_qty-nvl(cancel_qty,0))),0) this_month,
     nvl(sum(decode(to_char(invoice_date,'mmyyyy'),to_char(add_months(trunc(sysdate,'mm'),-1),'mmyyyy'), item_qty-nvl(cancel_qty,0))),0) last_month,
     nvl(sum(decode(to_char(invoice_date,'mmyyyy'),to_char(add_months(trunc(sysdate,'mm'),-2),'mmyyyy'), item_qty-nvl(cancel_qty,0))),0) previous,
     nvl(sum(decode(to_char(invoice_date,'mmyyyy'),to_char(add_months(trunc(sysdate,'mm'),-3),'mmyyyy'), item_qty-nvl(cancel_qty,0))),0) last_previous
     from finc_invoicedtl dtl join finc_invoicemst mst
     on dtl.invoice_no_fk=mst.invoice_no_pk
     join sysc_serviceitem item
      on item.item_no_pk=dtl.item_no_fk
      and nvl(container_ind,0)=0
      join sysc_itemtype type
     on item.itemtype_no_fk=type.itemtype_no_pk
     and itemtype_code='RAD'
     where trunc(invoice_date) between add_months(trunc(sysdate,'mm'),-3)and trunc(sysdate)");
        $growth_three_value1 = isset($growth_three_month[0]->opdtest) ? $growth_three_month[0]->opdtest : 0;
        $growth_three_value2 = isset($growth_three_month[1]->opdtest) ? $growth_three_month[1]->opdtest : 0;
        $growth_three_value3 = isset($growth_three_month[2]->opdtest) ? $growth_three_month[2]->opdtest : 0;
        $growth_three_value4 = isset($growth_three_month[3]->opdtest) ? $growth_three_month[3]->opdtest : 0;
        $growth_three_value5 = isset($growth_three_month[4]->opdtest) ? $growth_three_month[4]->opdtest : 0;
        $growth_three_value6 = isset($growth_three_month[5]->opdtest) ? $growth_three_month[5]->opdtest : 0;
        $growth_three_value7 = isset($growth_three_month[6]->opdtest) ? $growth_three_month[6]->opdtest : 0;
        $growth_three_value8 = isset($growth_three_month[7]->opdtest) ? $growth_three_month[7]->opdtest : 0;
        $growth_three_value9 = isset($growth_three_month[8]->opdtest) ? $growth_three_month[8]->opdtest : 0;
        $growth_three_value10 = isset($growth_three_month[9]->opdtest) ? $growth_three_month[9]->opdtest : 0;
        $growth_three_hour_test = "$growth_three_value1,$growth_three_value2,$growth_three_value3,$growth_three_value4,$growth_three_value5,$growth_three_value6,$growth_three_value7,$growth_three_value8,$growth_three_value9,$growth_three_value10";


        $growth_three_value1_hr = isset($growth_three_month[0]->hr) ? $growth_three_month[0]->hr : 0;
        $growth_three_value2_hr = isset($growth_three_month[1]->opdtest) ? $growth_three_month[1]->hr : 0;
        $growth_three_value3_hr = isset($growth_three_month[2]->hr) ? $growth_three_month[2]->hr : 0;
        $growth_three_value4_hr = isset($growth_three_month[3]->hr) ? $growth_three_month[3]->hr : 0;
        $growth_three_value5_hr = isset($growth_three_month[4]->hr) ? $growth_three_month[4]->hr : 0;
        $growth_three_value6_hr = isset($growth_three_month[5]->hr) ? $growth_three_month[5]->hr : 0;
        $growth_three_value7_hr = isset($growth_three_month[6]->hr) ? $growth_three_month[6]->hr : 0;
        $growth_three_value8_hr = isset($growth_three_month[7]->hr) ? $growth_three_month[7]->hr : 0;
        $growth_three_value9_hr = isset($growth_three_month[8]->hr) ? $growth_three_month[8]->hr : 0;
        $growth_three_value10_hr = isset($growth_three_month[9]->hr) ? $growth_three_month[9]->hr : 0;
        $growth_three_hour_hr = "$growth_three_value1_hr,$growth_three_value2_hr,$growth_three_value3_hr,$growth_three_value4_hr,$growth_three_value5_hr,$growth_three_value6_hr,$growth_three_value7_hr,$growth_three_value8_hr,$growth_three_value9_hr,$growth_three_value10_hr";

        /************************Today Sample Collection End************/
        return Template::loadView("admin.uhl.radiology-dashboard", [
            'today_lab_dt' => $today_lab_dt,
            'yesterday_lab_dt' => $yesterday_lab_dt,
            'monthly_lab_dt' => $monthly_lab_dt,
            't_sample_collection' => $t_sample_collection,
            't_sample_collection_yesterday' => $t_sample_collection_yesterday,
            'sample_collection_this_month' => $sample_collection_this_month,
            't_report_delivery' => $t_report_delivery,
            't_report_delivery_yesterday' => $t_report_delivery_yesterday,
            't_report_delivery_month' => $t_report_delivery_month,

            'top_tests' => $top_tests,
            'top_department' => $top_department,
            'top_referral' => $top_referral,
            'order_per_hour' => $order_per_hour,
            'growth_three_month' => $growth_three_month,
            'order_hour_test' => $order_hour_test,
            'order_hour_hr' => $order_hour_hr,
            'growth_three_hour_test' => $growth_three_hour_test,
            'growth_three_hour_hr' => $growth_three_hour_hr,
        ]);
    }


    // IPD DashboardV1
    public function ipdDashboard()
    {
        // Reports Part
        $total_bed = DB::select("select count(*) tot_bed from ipds_bed bed, ipds_ward ward,sysc_serviceunit unit where bed.STATUS=1 and BED.WARD_NO_FK=WARD.WARD_NO_PK and WARD.SERVICE_UNIT_NO_FK=UNIT.SERVICEUNIT_NO_PK and UNIT.EMERGENCY_DAYCARE_IND_TXT is null");
        $occupied_bed = DB::select("select count(*) bed_occu from ipds_bed bed, ipds_ward ward,sysc_serviceunit unit where bed.BED_STATUS=2 and BED.WARD_NO_FK=WARD.WARD_NO_PK and WARD.SERVICE_UNIT_NO_FK=UNIT.SERVICEUNIT_NO_PK and UNIT.EMERGENCY_DAYCARE_IND_TXT is null");
        $available_bed = DB::select("select count(*) availble from ipds_bed bed, ipds_ward ward,sysc_serviceunit unit where bed.BED_STATUS<>2 and BED.WARD_NO_FK=WARD.WARD_NO_PK and WARD.SERVICE_UNIT_NO_FK=UNIT.SERVICEUNIT_NO_PK and UNIT.EMERGENCY_DAYCARE_IND_TXT is null");
        $toal_appoinment = DB::select("SELECT COUNT (*) tot_admited FROM ipd_admission WHERE NVL (DIS_IND, 0) = 0 AND EMERGENCY_DAYCARE_IND_TXT IS NULL");
        $average_length = DB::select("select round(avg(nvl(DIS_DATE,sysdate)-ADMISSION_DATE)) avg_length from ipd_admission where nvl(DIS_IND,0)=0 and EMERGENCY_DAYCARE_IND_TXT is null");
        $bed_occupancy = DB::select("select round(sum(decode(BED_STATUS,2,1))/count(*)*100) rasio from ipds_bed bed, ipds_ward ward,sysc_serviceunit unit
        where bed.STATUS=1 and BED.WARD_NO_FK=WARD.WARD_NO_PK and WARD.SERVICE_UNIT_NO_FK=UNIT.SERVICEUNIT_NO_PK and UNIT.EMERGENCY_DAYCARE_IND_TXT is null");



        /**********IPD Growth Start********************/
        $dept_wise_admission = DB::select("  SELECT admitted_dept,
          fnc_serviceunitname (admitted_dept) dept_name,
          NVL (SUM (DECODE (TRUNC (admission_date), TRUNC (SYSDATE), 1)), 0)
             today,
          NVL (SUM (DECODE (TRUNC (admission_date), TRUNC (SYSDATE - 1), 1)), 0)
             yesterday,
          NVL (
             SUM (
                DECODE (TO_CHAR (admission_date, 'mmyyyy'),
                        TO_CHAR (SYSDATE, 'mmyyyy'), 1)),
             0)
             this_month,
          NVL (
             SUM (
                DECODE (
                   TO_CHAR (admission_date, 'mmyyyy'),
                   TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE, 'mm'), -1), 'mmyyyy'), 1)),
             0)
             last_month,
          NVL (
             SUM (
                DECODE (
                   TO_CHAR (admission_date, 'mmyyyy'),
                   TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE, 'mm'), -2), 'mmyyyy'), 1)),
             0)
             PREVIOUS,
          NVL (
             SUM (
                DECODE (
                   TO_CHAR (admission_date, 'mmyyyy'),
                   TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE, 'mm'), -3), 'mmyyyy'), 1)),
             0)
             last_previous
     FROM ipd_admission
    WHERE TRUNC (admission_date) BETWEEN ADD_MONTHS (TRUNC (SYSDATE, 'mm'), -3)
                                     AND TRUNC (SYSDATE)
          AND emergency_daycare_ind_txt IS NULL
 GROUP BY admitted_dept
 ORDER BY 2 ASC");
        /**********IPD Growth Start********************/

        /**********IPD Gender Start********************/
        $gender_dt = DB::select("  SELECT SUM (DECODE (gender_txt, 'Female', 1)) female,
    SUM (DECODE (gender_txt, 'Male', 1)) male
    FROM ipd_admission ipd, patn_registration reg
    WHERE ipd.patient_no_fk = reg.patient_no_pk
    AND TRUNC (admission_date) BETWEEN ADD_MONTHS (TRUNC (SYSDATE, 'mm'),
                                                -3)
                                AND TRUNC (SYSDATE)
    AND emergency_daycare_ind_txt IS NULL
    ORDER BY 2 ASC");
        $gender_female = $gender_dt[0]->female;
        $gender_male = $gender_dt[0]->male;
        /**********IPD Gender End********************/
        /**********Age Group Wise Admission start********************/
        $gender_dt = DB::select("  SELECT SUM (DECODE (gender_txt, 'Female', 1)) female,
    SUM (DECODE (gender_txt, 'Male', 1)) male
    FROM ipd_admission ipd, patn_registration reg
    WHERE ipd.patient_no_fk = reg.patient_no_pk
    AND TRUNC (admission_date) BETWEEN ADD_MONTHS (TRUNC (SYSDATE, 'mm'),
                                                -3)
                                AND TRUNC (SYSDATE)
    AND emergency_daycare_ind_txt IS NULL
    ORDER BY 2 ASC");
        /**********gender Admission End********************/
        /**********Age Group Wise Admission start********************/
        $age_dt = DB::select(" SELECT SUM (
            CASE
            WHEN REGEXP_REPLACE (
                    SUBSTR (PAT_AGE (DOB, admission_date), 1, 2),
                    '[^0-9]',
                    '') BETWEEN 0
                            AND 9
            THEN
                1
            ELSE
                0
            END)
            age0_9,
        SUM (
            CASE
            WHEN REGEXP_REPLACE (
                    SUBSTR (PAT_AGE (DOB, admission_date), 1, 2),
                    '[^0-9]',
                    '') BETWEEN 10
                            AND 19
            THEN
                1
            ELSE
                0
            END)
            age10_19,
        SUM (
            CASE
            WHEN REGEXP_REPLACE (
                    SUBSTR (PAT_AGE (DOB, admission_date), 1, 2),
                    '[^0-9]',
                    '') BETWEEN 20
                            AND 29
            THEN
                1
            ELSE
                0
            END)
            age20_29,
        SUM (
            CASE
            WHEN REGEXP_REPLACE (
                    SUBSTR (PAT_AGE (DOB, admission_date), 1, 2),
                    '[^0-9]',
                    '') BETWEEN 30
                            AND 39
            THEN
                1
            ELSE
                0
            END)
            age20_39,
        SUM (
            CASE
            WHEN REGEXP_REPLACE (
                    SUBSTR (PAT_AGE (DOB, admission_date), 1, 2),
                    '[^0-9]',
                    '') BETWEEN 40
                            AND 49
            THEN
                1
            ELSE
                0
            END)
            age40_49,
        SUM (
            CASE
            WHEN REGEXP_REPLACE (
                    SUBSTR (PAT_AGE (DOB, admission_date), 1, 2),
                    '[^0-9]',
                    '') >= 50
            THEN
                1
            ELSE
                0
            END)
            age50_abo
    FROM ipd_admission ipd, patn_registration reg
    WHERE ipd.patient_no_fk = reg.patient_no_pk
        AND TRUNC (admission_date) BETWEEN ADD_MONTHS (TRUNC (SYSDATE, 'mm'),
                                                        -3)
                                        AND TRUNC (SYSDATE)
        AND emergency_daycare_ind_txt IS NULL");
        $age0_9 = $age_dt[0]->age0_9;
        $age10_19 = $age_dt[0]->age10_19;
        $age20_29 = $age_dt[0]->age20_29;
        $age20_39 = $age_dt[0]->age20_39;
        $age40_49 = $age_dt[0]->age40_49;
        $age50_abo = $age_dt[0]->age50_abo;
        /**********Age Group Wise Admission End********************/
        /**********IPD Growth Start********************/
        $growth = DB::select("  SELECT NVL (
            SUM (
               DECODE (TO_CHAR (admission_date, 'mmyyyy'),
                       TO_CHAR (SYSDATE, 'mmyyyy'), 1)),
            0)
            this_month,
         NVL (
            SUM (
               DECODE (
                  TO_CHAR (admission_date, 'mmyyyy'),
                  TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE, 'mm'), -1), 'mmyyyy'), 1)),
            0)
            last_month,
         NVL (
            SUM (
               DECODE (
                  TO_CHAR (admission_date, 'mmyyyy'),
                  TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE, 'mm'), -2), 'mmyyyy'), 1)),
            0)
            PREVIOUS,
         NVL (
            SUM (
               DECODE (
                  TO_CHAR (admission_date, 'mmyyyy'),
                  TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE, 'mm'), -3), 'mmyyyy'), 1)),
            0)
            last_previous,
         NVL (
            SUM (
               DECODE (
                  TO_CHAR (admission_date, 'mmyyyy'),
                  TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE, 'mm'), -4), 'mmyyyy'), 1)),
            0)
            previous1,
         NVL (
            SUM (
               DECODE (
                  TO_CHAR (admission_date, 'mmyyyy'),
                  TO_CHAR (ADD_MONTHS (TRUNC (SYSDATE, 'mm'), -5), 'mmyyyy'), 1)),
            0)
            previous2
    FROM ipd_admission
   WHERE TRUNC (admission_date) BETWEEN ADD_MONTHS (TRUNC (SYSDATE, 'mm'), -5)
                                    AND TRUNC (SYSDATE)
         AND emergency_daycare_ind_txt IS NULL
ORDER BY 2 ASC");

        $growth_value1 = isset($growth[0]->this_month) ? $growth[0]->this_month : 0;
        $growth_value2 = isset($growth[0]->last_month) ? $growth[0]->last_month : 0;
        $growth_value3 = isset($growth[0]->PREVIOUS) ? $growth[0]->PREVIOUS : 0;
        $growth_value4 = isset($growth[0]->last_previous) ? $growth[0]->last_previous : 0;
        $growth_value5 = isset($growth[0]->previous1) ? $growth[0]->previous1 : 0;
        $growth_value6 = isset($growth[0]->previous2) ? $growth[0]->previous2 : 0;
        $ipd_growth = "$growth_value1,$growth_value2,$growth_value3,$growth_value4,$growth_value5,$growth_value6";
        /**********IPD Growth End********************/
        return Template::loadView("admin.uhl.ipd-dashboard", [
            'total_bed' => $total_bed,
            'occupied_bed' => $occupied_bed,
            'available_bed' => $available_bed,
            'toal_appoinment' => $toal_appoinment,
            'average_length' => $average_length,
            'bed_occupancy' => $bed_occupancy,
            'ipd_growth' => $ipd_growth,
            'dept_wise_admission' => $dept_wise_admission,
            'gender_female' => $gender_female,
            'gender_male' => $gender_male,
            'age0_9' => $age0_9,
            'age10_19' => $age10_19,
            'age20_29' => $age20_29,
            'age20_39' => $age20_39,
            'age40_49' => $age40_49,
            'age50_abo' => $age50_abo,
            'ipd_growth' => $ipd_growth,
        ]);
    }

    function dashboardV1()
    {
        $ses_hospital_id = Session::get('user.ses_hospital_no_pk');
        $appointments = DB::select(DB::raw("select app.full_name,
                                                   app.gender_txt,
                                                   app.mobile1,
                                                   app.patient_dob,
                                                   app.patient_name,
                                                   app.patient_no_pk,
                                                   app.patient_photo,
                                                   pat.call_ind,
                                                   pat.email_ind,
                                                   pat.sms_ind,app.specialization
                                              from    dash_patn_app_vw app
                                                   left join
                                                      pat_history_tracking pat
                                                   on app.patient_no_pk = pat.patient_no_fk  where app.au_entry_hospital_pk_no = $ses_hospital_id"));
        //        dd($appointments);
        $last_day_appointment = db::select(db::raw("select patient_name,

                                                          gender_txt,
                                                          patient_dob,
                                                          blood_group,
                                                          age,
                                                          mobile1,
                                                          doctor_no_fk,
                                                          full_name,
                                                          specialization,
                                                          patient_photo,
                                                          patient_no_pk
                                                     from patn_appointment_vw
                                                    where appoint_date = trunc (sysdate - 1) and au_entry_hospital_pk_no  = $ses_hospital_id "));
        $unattendant_patients = db::select(db::raw("select * from psn_unattent_pat_list where
        APPOINT_STATUS = 3 and au_entry_hospital_pk_no  = $ses_hospital_id
        and appoint_date between trunc (sysdate - 7) and trunc (sysdate)"));

        $unattendant_patients_last = db::select(db::raw("select * from psn_unattent_pat_list
         where appoint_date between trunc (sysdate - 14) and trunc (sysdate -7 ) and au_entry_hospital_pk_no  = $ses_hospital_id"));

        $follow_up = db::select(db::raw("select * from psn_followup_vw
        where trunc (next_followup_dt) between trunc (sysdate) and trunc (sysdate + 7)
        order by next_followup_dt asc"));
        $last_s_followup = db::select(db::raw("select * from psn_followup_vw  where trunc (next_followup_dt) between trunc (sysdate - 7) and trunc (sysdate) order by next_followup_dt asc"));
        $schedules_doctors = db::table('dash_doctor_schdule_vw')->where('au_entry_hospital_pk_no', $ses_hospital_id)->where('schedule_dt', carbon::today())->whereNotNull('person_no_pk')->get();
        $all_doctors = db::select("select distinct person_no_pk,full_name from dash_doctor_schdule_vw where au_entry_hospital_pk_no = $ses_hospital_id ");


        return Template::loadview("admin.uhl.dashboard", [
            'appointments' => $appointments,
            'unattendant_patients' => $unattendant_patients,
            'schedules_doctors' => $schedules_doctors,
            'all_doctors' => $all_doctors,
            'last_day_appointment' => $last_day_appointment,
            'unattendant_patients_last' => $unattendant_patients_last,
            "follow_up" => $follow_up,
            "last_s_followup" => $last_s_followup,
        ]);
    }




    // managemnt DashboardV2
    public function managementDashboardV2()
    {

        /**********Hospital Summery Start********************/
        $hospital_summary_opd = DB::select(DB::raw("SELECT SUM (DECODE (TRUNC (appoint_date), TRUNC (SYSDATE), PATIENT_CNT_TOTAL)) today,SUM (DECODE (TRUNC (appoint_date), TRUNC (SYSDATE - 1), PATIENT_CNT_TOTAL)) yesterday, SUM (DECODE (TO_CHAR (appoint_date, 'MMYYYY'),TO_CHAR (SYSDATE, 'MMYYYY'), PATIENT_CNT_TOTAL)) this_month  FROM RPT_03_OPD_PAT_COUNT_SU_DT_VW WHERE TRUNC (appoint_date) BETWEEN TO_DATE ('01/' || TO_CHAR (SYSDATE, 'mm/yyyy'),'dd/mm/yyyy')AND TRUNC (SYSDATE) "));
        $hospital_summary_ipd = DB::select(DB::raw("SELECT SUM (DECODE (TRUNC (ADMISSION_DATE), TRUNC (SYSDATE), 1)) today, SUM (DECODE (TRUNC (ADMISSION_DATE), TRUNC (SYSDATE - 1), 1)) yesterday, SUM ( DECODE (TO_CHAR (ADMISSION_DATE, 'MMYYYY'),TO_CHAR (SYSDATE, 'MMYYYY'), 1)) this_month FROM ipd_admission WHERE TRUNC (ADMISSION_DATE) BETWEEN TO_DATE ( '01/' || TO_CHAR (SYSDATE, 'mm/yyyy'), 'dd/mm/yyyy') AND TRUNC (SYSDATE)"));
        $hospital_summary_phr = DB::select(DB::raw("select sum(decode(trunc(LEDGER_DATE),trunc(sysdate),LEDGER_AMT_PAYMENT)) today,sum(decode(trunc(LEDGER_DATE),trunc(sysdate-1),LEDGER_AMT_PAYMENT))  yesterday,sum(decode(to_char(LEDGER_DATE,'MMYYYY'),to_char(sysdate,'MMYYYY'),LEDGER_AMT_PAYMENT))  this_month from finc_ledgermst mst join sysc_module mod on mst.module_no_fk=mod.module_no_pk where trunc(LEDGER_DATE) between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy') and trunc(sysdate) and mod.MODULE_CODE in ('PHR','PHR-I')"));
        $hospital_summary_emergency = DB::select(DB::raw("select nvl(sum(decode(trunc(ADMISSION_DATE),trunc(sysdate),1)),0) today,nvl(sum(decode(trunc(ADMISSION_DATE),trunc(sysdate-1),1)),0)  yesterday,nvl(sum(decode(to_char(ADMISSION_DATE,'MMYYYY'),to_char(sysdate,'MMYYYY'),1)),0)  this_month from ipd_admission where trunc(ADMISSION_DATE)  between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy') and trunc(sysdate) and EMERGENCY_DAYCARE_IND_TXT ='EMERGENCY'"));
        $hospital_summary_daycare = DB::select(DB::raw("select nvl(sum(decode(trunc(ADMISSION_DATE),trunc(sysdate),1)),0) today,nvl(sum(decode(trunc(ADMISSION_DATE),trunc(sysdate-1),1)),0)  yesterday,nvl(sum(decode(to_char(ADMISSION_DATE,'MMYYYY'),to_char(sysdate,'MMYYYY'),1)),0)  this_month from ipd_admission where trunc(ADMISSION_DATE)  between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy') and trunc(sysdate)and EMERGENCY_DAYCARE_IND_TXT ='DAYCARE'"));
        $hospital_summary_ot = DB::select(DB::raw("select nvl(sum(decode(trunc(OT_DATE),trunc(sysdate),1)),0) today,nvl(sum(decode(trunc(OT_DATE),trunc(sysdate-1),1)),0)  yesterday,nvl(sum(decode(to_char(OT_DATE,'MMYYYY'),to_char(sysdate,'MMYYYY'),1)),0)  this_month from opt_prescribed_ot  where trunc(OT_DATE)  between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy')  and trunc(sysdate)"));
        $hospital_summary_ipd_cons = DB::select(DB::raw("select sum(decode(trunc(INVOICE_DATE),trunc(sysdate),item_qty-nvl(cancel_qty,0))) today,sum(decode(trunc(INVOICE_DATE),trunc(sysdate-1),item_qty-nvl(cancel_qty,0)))  yesterday,sum(decode(to_char(INVOICE_DATE,'MMYYYY'),to_char(sysdate,'MMYYYY'),item_qty-nvl(cancel_qty,0)))  this_month from finc_invoicedtl dtl join finc_invoicemst mst  on mst.invoice_no_pk=dtl.invoice_no_fk where trunc(INVOICE_DATE)  between to_date('01/'||to_char(sysdate,'mm/yyyy'),'dd/mm/yyyy') and trunc(sysdate) and item_name='Consultant Visit (IPD)' and nvl(ADMISSION_NO_PK,0)>0 and nvl(cancel_ind,0)=0"));

        /**********Hospital Summery end********************/

        /**********Hospital Comparison Start********************/
        // OPDC Comparison start
        $hospital_comparison_opdc = DB::select("select to_char(appoint_date,'MM') ,to_char(appoint_date,'Month') month,sum(PATIENT_CNT_TOTAL) no_of_pat
 from RPT_03_OPD_PAT_COUNT_SU_DT_VW
 where trunc(appoint_date) between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate)
 group by to_char(appoint_date,'Month'), to_char(appoint_date,'MM')
 order by 1 asc");
        // dd( $hospital_comparison_opdc);
        $opdc_val1 = isset($hospital_comparison_opdc[0]) ? $hospital_comparison_opdc[0]->no_of_pat : '';
        $opdc_val2 = isset($hospital_comparison_opdc[1]) ? $hospital_comparison_opdc[1]->no_of_pat : '';
        $opdc_val3 = isset($hospital_comparison_opdc[2]) ? $hospital_comparison_opdc[2]->no_of_pat : '';
        $opdc_cons = "$opdc_val1,$opdc_val2,$opdc_val3";

        $opdc_month1 = isset($hospital_comparison_opdc[0]) ? str_replace(' ', '', $hospital_comparison_opdc[0]->month) : '';
        $opdc_month2 = isset($hospital_comparison_opdc[1]) ? str_replace(' ', '', $hospital_comparison_opdc[1]->month) : '';
        $opdc_month3 = isset($hospital_comparison_opdc[2]) ? str_replace(' ', '', $hospital_comparison_opdc[2]->month) : '';
        $opdc_cons_month = "'$opdc_month1','$opdc_month2','$opdc_month3'";
        // OPDC Comparison END

        // OPDC Comparison start
        $hospital_comparison_ipdc = DB::select("select to_char(INVOICE_DATE,'MM'), to_char(INVOICE_DATE,'Month') month,sum(item_qty-nvl(cancel_qty,0)) no_of_item
 from finc_invoicedtl dtl join finc_invoicemst mst
 on mst.invoice_no_pk=dtl.invoice_no_fk
 where trunc(INVOICE_DATE)  between add_months(trunc(sysdate,'mm'),-2)and trunc(sysdate)
 and item_name='Consultant Visit (IPD)'
 and nvl(ADMISSION_NO_PK,0)>0
 and nvl(cancel_ind,0)=0
 group by to_char(INVOICE_DATE,'Month'),to_char(INVOICE_DATE,'MM')
 order by 1 asc");
        $ipdc_val1 = isset($hospital_comparison_ipdc[0]) ? $hospital_comparison_ipdc[0]->no_of_item : '';
        $ipdc_val2 = isset($hospital_comparison_ipdc[1]) ? $hospital_comparison_ipdc[1]->no_of_item : '';
        $ipdc_val3 = isset($hospital_comparison_ipdc[2]) ? $hospital_comparison_ipdc[2]->no_of_item : '';
        $ipdc_cons = "$ipdc_val1,$ipdc_val2,$ipdc_val3";
        $ipdc_month1 = isset($hospital_comparison_ipdc[0]) ? $hospital_comparison_ipdc[0]->month : '';
        $ipdc_month2 = isset($hospital_comparison_ipdc[1]) ? $hospital_comparison_ipdc[1]->month : '';
        $ipdc_month3 = isset($hospital_comparison_ipdc[2]) ? $hospital_comparison_ipdc[2]->month : '';
        $ipdc_cons_month = "'$ipdc_month1','$ipdc_month2','$ipdc_month3'";

        // OPDC Comparison END

        // emergency Comparison start
        $hospital_comparison_emergency = DB::select("select to_char(ADMISSION_DATE,'MM'),to_char(ADMISSION_DATE,'yymm') month,count(*) no_of_pat
   from ipd_admission
   where trunc(ADMISSION_DATE)  between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate)
   and EMERGENCY_DAYCARE_IND_TXT ='EMERGENCY'
   group by to_char(ADMISSION_DATE,'yymm'),to_char(ADMISSION_DATE,'MM')
   order by 1 asc");
        $emergency_val1 = 0;
        $emergency_val2 = 0;
        $emergency_val3 = 0;
        $emergency_cons = "$emergency_val1,$emergency_val2,$emergency_val3";

        $emergency_month1 = 0;
        $emergency_month2 = 0;
        $emergency_month3 = 0;
        $emergency_cons_month = "'$emergency_month1','$emergency_month2','$emergency_month3'";

        // emergency Comparison END

        // emergency Comparison start
        $hospital_comparison_adm = DB::select("select  to_char(ADMISSION_DATE,'MM'), to_char(ADMISSION_DATE,'Month') month,count(*) no_of_pat
   from ipd_admission
   where trunc(ADMISSION_DATE)  between add_months(trunc(sysdate,'mm'),-2)and trunc(sysdate)
   group by to_char(ADMISSION_DATE,'Month'), to_char(ADMISSION_DATE,'MM')
   order by 1 asc");
        $adm_val1 = isset($hospital_comparison_adm[0]) ? $hospital_comparison_adm[0]->no_of_pat : '';
        $adm_val2 = isset($hospital_comparison_adm[1]) ? $hospital_comparison_adm[1]->no_of_pat : '';
        $adm_val3 = isset($hospital_comparison_adm[2]) ? $hospital_comparison_adm[2]->no_of_pat : '';
        $adm_cons = "$adm_val1,$adm_val2,$adm_val3";

        $adm_month1 = isset($hospital_comparison_adm[0]) ? $hospital_comparison_adm[0]->month : '';
        $adm_month2 = isset($hospital_comparison_adm[1]) ? $hospital_comparison_adm[1]->month : '';
        $adm_month3 = isset($hospital_comparison_adm[2]) ? $hospital_comparison_adm[2]->month : '';
        $adm_cons_month = "'$adm_month1','$adm_month2','$adm_month3'";
        // emergency Comparison END

        /**********Hospital Comparison end********************/


        /**********IPD Comparison Start********************/

        $ipd_conversation = DB::select("  SELECT TO_CHAR (admission_date, 'MM'),
         TO_CHAR (admission_date, 'Month') month,
         NVL (SUM (DECODE (ref_from_emr_ind, 1, 1)), 0) emr,
         NVL (SUM (DECODE (ref_from_opd_dept, 1, 1)), 0) opd,
         SUM (
         CASE
             WHEN NVL (ref_from_emr_ind, 0) = 0
                 AND NVL (ref_from_opd_dept, 0) = 0
             THEN
                 1
         END)
         others
 FROM ipd_admission
 WHERE TRUNC (admission_date) BETWEEN ADD_MONTHS (TRUNC (SYSDATE, 'mm'), -2)
                                 AND TRUNC (SYSDATE)
 GROUP BY TO_CHAR (admission_date, 'Month'), TO_CHAR (admission_date, 'MM')
 ORDER BY 1 ASC");

        $total_ipd_lst = isset($ipd_conversation[2]) ? $ipd_conversation[2]->opd + $ipd_conversation[2]->emr + $ipd_conversation[2]->others : 0;
        $opd_lst = isset($ipd_conversation[2]) ? ($ipd_conversation[2]->opd / $total_ipd_lst) * 100 : 0;
        $emr_lst = isset($ipd_conversation[2]) ? ($ipd_conversation[2]->emr / $total_ipd_lst) * 100 : 0;
        $others_lst = isset($ipd_conversation[2]) ? ($ipd_conversation[2]->others / $total_ipd_lst) * 100 : 0;


        /**********PHR Start********************/
        $phr_dt = DB::select("select to_char(LEDGER_DATE,'Month') month,to_char(LEDGER_DATE,'mmyy'),sum(LEDGER_AMT_PAYMENT) collection
         from finc_ledgermst mst join
         sysc_module mod
         on mst.module_no_fk=mod.module_no_pk
         where trunc(LEDGER_DATE) between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate)
         and mod.MODULE_CODE in ('PHR')
         group by to_char(LEDGER_DATE,'Month'),to_char(LEDGER_DATE,'mmyy')
         order by 2 asc");
        $phr_i_dt = DB::select("select to_char(LEDGER_DATE,'Month') month,to_char(LEDGER_DATE,'mmyy'),sum(LEDGER_AMT_PAYMENT) collection
         from finc_ledgermst mst join
         sysc_module mod
         on mst.module_no_fk=mod.module_no_pk
         where trunc(LEDGER_DATE) between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate)
         and mod.MODULE_CODE in ('PHR-I')
         group by to_char(LEDGER_DATE,'Month'),to_char(LEDGER_DATE,'mmyy')
         order by 2 asc");

        $phr_e_dt = DB::select("select to_char(LEDGER_DATE,'Month') month,to_char(LEDGER_DATE,'mmyy'),sum(LEDGER_AMT_PAYMENT) collection
         from finc_ledgermst mst join
         sysc_module mod
         on mst.module_no_fk=mod.module_no_pk
         where trunc(LEDGER_DATE) between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate)
         and mod.MODULE_CODE in ('PHR-E')
         group by to_char(LEDGER_DATE,'Month'),to_char(LEDGER_DATE,'mmyy')
         order by 2 asc");

        $phr_d_dt = DB::select("select to_char(LEDGER_DATE,'Month') month,to_char(LEDGER_DATE,'mmyy'),sum(LEDGER_AMT_PAYMENT) collection
         from finc_ledgermst mst join
         sysc_module mod
         on mst.module_no_fk=mod.module_no_pk
         where trunc(LEDGER_DATE) between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate)
         and mod.MODULE_CODE in ('PHR-D')
         group by to_char(LEDGER_DATE,'Month'),to_char(LEDGER_DATE,'mmyy')
         order by 2 asc");

        $phr_day_dt = DB::select("select to_char(LEDGER_DATE,'Month') month,to_char(LEDGER_DATE,'mmyy'),sum(LEDGER_AMT_PAYMENT) collection
         from finc_ledgermst mst join
         sysc_module mod
         on mst.module_no_fk=mod.module_no_pk
         where trunc(LEDGER_DATE) between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate)
         and mod.MODULE_CODE in ('PHR-O')
         group by to_char(LEDGER_DATE,'Month'),to_char(LEDGER_DATE,'mmyy')
         order by 2 asc");

        $phr_value1 = isset($phr_dt[0]) ? $phr_dt[0]->collection : '';
        $phr_value2 = isset($phr_dt[1]) ? $phr_dt[1]->collection : '';
        $phr_value3 = isset($phr_dt[2]) ? $phr_dt[2]->collection : '';
        $phr = "$phr_value1,$phr_value2,$phr_value3";

        $phr_i_value1 = isset($phr_i_dt[0]) ? $phr_i_dt[0]->collection : '';
        $phr_i_value2 = isset($phr_i_dt[1]) ? $phr_i_dt[1]->collection : '';
        $phr_i_value3 = isset($phr_i_dt[2]) ? $phr_i_dt[2]->collection : '';
        $phr_i = "$phr_i_value1,$phr_i_value2,$phr_i_value3";


        $phr_e_value1 = !empty($phr_e_dt[0]->collection) ? $phr_e_dt[0]->collection : 0;
        $phr_e_value2 = !empty($phr_e_dt[1]->collection) ? $phr_e_dt[1]->collection : 0;
        $phr_e_value3 = !empty($phr_e_dt[2]->collection) ? $phr_e_dt[2]->collection : 0;
        $phr_e = "$phr_e_value1,$phr_e_value2,$phr_e_value3";

        $phr_d_value1 = !empty($phr_d_dt[0]->collection) ? $phr_d_dt[0]->collection : 0;
        $phr_d_value2 = !empty($phr_d_dt[1]->collection) ? $phr_d_dt[1]->collection : 0;
        $phr_d_value3 = !empty($phr_d_dt[2]->collection) ? $phr_d_dt[2]->collection : 0;
        $phr_d = "$phr_d_value1,$phr_d_value2,$phr_d_value3";

        $phr_dy_value1 = !empty($phr_dy_dt[0]->collection) ? $phr_dy_dt[0]->collection : 0;
        $phr_dy_value2 = !empty($phr_dy_dt[1]->collection) ? $phr_dy_dt[1]->collection : 0;
        $phr_dy_value3 = !empty($phr_dy_dt[2]->collection) ? $phr_dy_dt[2]->collection : 0;
        $phr_dy = "$phr_dy_value1,$phr_dy_value2,$phr_dy_value3";



        /**********PHR End********************/
        /**********Location Start********************/
        $location = DB::select("select nvl(PATIENT_AREA_NAME,'Others') area,count(*) no_of_patient
     from patn_registration reg , finc_invoicemst mst
     where REG.PATIENT_NO_PK=MST.PATIENT_NO_FK
     and trunc(invoice_date)between add_months(trunc(sysdate,'mm'),-2)and trunc(sysdate) and PATIENT_AREA_NAME is not null
     group by PATIENT_AREA_NAME
     order by 1 ");

        $loc_value1 = isset($location[0]->no_of_patient) ? $location[0]->no_of_patient : 0;
        $loc_value2 = isset($location[1]->no_of_patient) ? $location[1]->no_of_patient : 0;
        $loc_value3 = isset($location[2]->no_of_patient) ? $location[2]->no_of_patient : 0;
        $loc_value4 = isset($location[3]->no_of_patient) ? $location[3]->no_of_patient : 0;
        $loc_value5 = isset($location[4]->no_of_patient) ? $location[4]->no_of_patient : 0;
        $loc_value6 = isset($location[5]->no_of_patient) ? $location[5]->no_of_patient : 0;
        $loc_value7 = isset($location[6]->no_of_patient) ? $location[6]->no_of_patient : 0;
        $loc_value8 = isset($location[7]->no_of_patient) ? $location[7]->no_of_patient : 0;
        $loc_value9 = isset($location[8]->no_of_patient) ? $location[8]->no_of_patient : 0;
        $loc_value10 = isset($location[9]->no_of_patient) ? $location[9]->no_of_patient : 0;
        $loc = "$loc_value1,$loc_value2,$loc_value3,$loc_value4,$loc_value5,$loc_value6,$loc_value7,$loc_value8,$loc_value9,$loc_value10";
        /**********Location End********************/

        /**********doctor start********************/
        $doctor_dt = DB::select("select DOCTOR_NAME,nvl(count(decode(to_char(appoint_date,'mmyy'),to_char(sysdate,'mmyy'),INVOICE_NO_PK)),0) current_month ,
 nvl(count(decode(to_char(appoint_date,'mmyy'),to_char(add_months(trunc(sysdate,'mm'),-1),'mmyy'),INVOICE_NO_PK)),0) pre_month  ,
 nvl(count(decode(to_char(appoint_date,'mmyy'),to_char(add_months(trunc(sysdate,'mm'),-2),'mmyy'),INVOICE_NO_PK)),0) last_month
 from FINC_DOC_APPOINT_SUM_VW
 where trunc (appoint_date) between add_months(trunc(sysdate,'mm'),-2)and trunc (sysdate)
 and NVL (CANCEL_IND, 0) = 0 AND MODULE_CODE = 'OPDC'
 group by DOCTOR_NAME
 order by 1");
        $ipd_dt = DB::select("select SERVICEUNIT_NAME,nvl(sum(decode(to_char(INVOICE_DATE,'mmyy'),to_char(sysdate,'mmyy'),item_qty-nvl(cancel_qty,0))),0) current_month ,
         nvl(sum(decode(to_char(INVOICE_DATE,'mmyy'),to_char(add_months(trunc(sysdate,'mm'),-1),'mmyy'),item_qty-nvl(cancel_qty,0))),0) pre_month  ,
         nvl(sum(decode(to_char(INVOICE_DATE,'mmyy'),to_char(add_months(trunc(sysdate,'mm'),-2),'mmyy'),item_qty-nvl(cancel_qty,0))),0) last_month
         from finc_invoicedtl dtl join finc_invoicemst mst
         on mst.invoice_no_pk=dtl.invoice_no_fk
         join hrms_personnel doc
         on doc.PERSON_NO_PK=mst.PERSON_NO_FK
         join sysc_serviceunit dept
         on dept.SERVICEUNIT_NO_PK=doc.SERVICEUNIT_NO_FK
         where trunc(INVOICE_DATE)
         between add_months(trunc(sysdate,'mm'),-2) and trunc(sysdate) and item_name='Consultant Visit (IPD)' and nvl(ADMISSION_NO_PK,0)>0 and nvl(cancel_ind,0)=0
         group by SERVICEUNIT_NAME
         order by 1");
        $opd_dt = DB::select("select SERVICEUNIT_NAME,nvl(count(decode(to_char(appoint_date,'mmyy'),to_char(sysdate,'mmyy'),INVOICE_NO_PK)),0) current_month ,
 nvl(count(decode(to_char(appoint_date,'mmyy'),to_char(add_months(trunc(sysdate,'mm'),-1),'mmyy'),INVOICE_NO_PK)),0) pre_month  ,
 nvl(count(decode(to_char(appoint_date,'mmyy'),to_char(add_months(trunc(sysdate,'mm'),-2),'mmyy'),INVOICE_NO_PK)),0) last_month
 from FINC_DOC_APPOINT_SUM_VW
 where trunc (appoint_date) between add_months(trunc(sysdate,'mm'),-2)and trunc (sysdate)
 and NVL (CANCEL_IND, 0) = 0 AND MODULE_CODE = 'OPDC'
 group by SERVICEUNIT_NAME
 order by 1");
        /**********doctor End********************/

        /**********Bed occupancy********************/
        $total_bed_count = DB::select("select count(*) no_of_bed from ipds_bed where STATUS=1 and AU_ENTRY_HOSPITAL_NO_FK=AU_ENTRY_HOSPITAL_NO_FK");
        $occupied_bed_count = DB::select("select count(*) no_of_bed from ipds_bed where bed_status=2 and AU_ENTRY_HOSPITAL_NO_FK=AU_ENTRY_HOSPITAL_NO_FK");
        $ipd_bed_ocupancy = DB::select("select count(distinct CURR_BED_NO_FK ) no_of_bed,to_char(ADMISSION_DATE,'Month') month,to_char(ADMISSION_DATE,'mmyy')
 from ipd_admission
 where au_entry_hospital_no_fk=au_entry_hospital_no_fk
 and trunc(ADMISSION_DATE)between add_months(trunc(sysdate,'mm'),-2)and trunc(sysdate)
 group by to_char(ADMISSION_DATE,'Month'),to_char(ADMISSION_DATE,'mmyy')
 order by 3 asc");
        /**********Bed occupancy End********************/
        return Template::loadview("admin.dashboards.management_dashboard_v4", [
            'hospital_summary_opd' => $hospital_summary_opd,
            'hospital_summary_ipd' => $hospital_summary_ipd,
            'hospital_summary_phr' => $hospital_summary_phr,
            'hospital_summary_emergency' => $hospital_summary_emergency,
            'hospital_summary_daycare' => $hospital_summary_daycare,
            'hospital_summary_ot' => $hospital_summary_ot,
            'hospital_summary_ipd_cons' => $hospital_summary_ipd_cons,
            'opdc_cons' => $opdc_cons,
            'ipdc_cons_month' => $ipdc_cons_month,
            'ipdc_cons' => $ipdc_cons,
            'emergency_cons' => $emergency_cons,
            'adm_cons' => $adm_cons,
            'ipd_conversation' => $ipd_conversation,
            'opd_lst' => $opd_lst,
            'emr_lst' => $emr_lst,
            'others_lst' => $others_lst,
            'total_bed_count' => $total_bed_count,
            'occupied_bed_count' => $occupied_bed_count,
            'ipd_bed_ocupancy' => $ipd_bed_ocupancy,
            'phr' => $phr,
            'phr_i' => $phr_i,
            'phr_e' => $phr_e,
            'phr_d' => $phr_d,
            'phr_dy' => $phr_dy,
            'loc' => $loc,
            'doctor_dt' => $doctor_dt,
            'ipd_dt' => $ipd_dt,
            'opd_dt' => $opd_dt,
            'opdc_month1' => $opdc_month1,
            'opdc_month2' => $opdc_month2,
            'opdc_month3' => $opdc_month3,
        ]);
    }
    public function managementDashboardV3()
    {
        // Fetch required values, you can modify these queries to use the values calculated earlier
        // $newRegistration = DB::table('patn_registration')
        //     ->whereDate('REG_DATE', now()->toDateString())
        //     ->count() ?? 0;

        // $opdConsultations = DB::table('patn_appointment')
        //     ->whereDate('appoint_date', now()->toDateString())
        //     ->where('CANCEL_IND', '<>', 1)
        //     ->count() ?? 0;

        // $opdHeadCount = DB::table('patn_appointment')
        //     ->whereDate('appoint_date', now()->toDateString())
        //     ->distinct()
        //     ->count('PATIENT_NO_FK') ?? 0;

        // $erVisits = DB::table('ipd_admission')
        //     ->whereDate('ADMISSION_DATE', now()->toDateString())
        //     ->where('iptype_ind', 2)
        //     ->where('ref_from_emr_ind', 1)
        //     ->selectRaw('SUM(CASE WHEN TRUNC(ADMISSION_DATE) = TRUNC(SYSDATE) THEN 1 ELSE 0 END) as today')
        //     ->value('today') ?? 0;

        // $totalAdmissions = DB::table('ipd_admission')
        //     ->whereDate('admission_date', now()->toDateString())
        //     ->where('iptype_ind', 1)
        //     ->count() ?? 0;

        // $currentIpd = DB::table('ipd_admission')
        //     ->where('DIS_IND', '<>', 1)
        //     ->count() ?? 0;

        // $totalDischarged = DB::table('ipd_admission')
        //     ->whereDate('dis_date', now()->toDateString())
        //     ->where('DIS_IND', 1)
        //     ->count() ?? 0;

        // $erConversion = DB::table('ipd_admission')
        //     ->whereDate('ADMISSION_DATE', now()->toDateString())
        //     ->where('iptype_ind', 2)
        //     ->where('ref_from_emr_ind', 1)
        //     ->selectRaw('SUM(CASE WHEN TRUNC(ADMISSION_DATE) = TRUNC(SYSDATE) THEN 1 ELSE 0 END) as today')
        //     ->value('today') ?? 0;

        // Calculate ER Conversion as percentage if needed
        // $erConversionPercentage = $totalAdmissions > 0 ? round(($erVisits / $totalAdmissions) * 100, 2) : 0;


        // Graph Part
        $opdData = [
            'newRegistration' => DB::table('patn_registration')
                ->whereDate('REG_DATE', now()->toDateString())
                ->count() ?? 0,

            'opdConsultations' => DB::table('patn_appointment')
                ->whereDate('appoint_date', now()->toDateString())
                ->where('CANCEL_IND', '<>', 1)
                ->where('CONSULT_IND', '=', 1)
                ->count() ?? 0,

            'opdHeadCount' => DB::table('patn_appointment')
                ->whereDate('appoint_date', now()->toDateString())
                ->where('CANCEL_IND', '=', 0)
                ->where('CONSULT_IND', '=', 1)
                ->distinct()
                ->count('PATIENT_NO_FK') ?? 0,

            'erVisits' => DB::table('ipd_admission')
                ->whereDate('ADMISSION_DATE', now()->toDateString())
                ->where('iptype_ind', 2)
                ->where('ref_from_emr_ind', 1)
                ->selectRaw('SUM(CASE WHEN TRUNC(ADMISSION_DATE) = TRUNC(SYSDATE) THEN 1 ELSE 0 END) as today')
                ->value('today') ?? 0,
            'totalOPDPatient' => DB::select("SELECT COUNT (DISTINCT mst.PATIENT_NO_FK) AS PATIENT_NO_FK
                    FROM finc_ledgermst lmst
                        JOIN finc_invoicemst mst ON mst.invoice_no_pk = lmst.invoice_no_fk
                    WHERE NVL (mst.admission_no_pk, 0) = 0
                        AND TRUNC (lmst.ledger_date) = TRUNC (SYSDATE)"),
        ];

        // IPD Data: Get counts of categories for each day of the week
        $ipdData = [
            'totalAdmissions' => DB::table('ipd_admission')
                ->whereDate('admission_date', now()->toDateString())
                ->where('iptype_ind', 1)
                ->count() ?? 0,

            // 'currentIpd' => DB::table('ipd_admission')
            //     ->where('DIS_IND', '<>', 1)
            //     ->count() ?? 0,

                'currentIpd' => DB::selectOne(DB::raw("SELECT 
                            SUM (
                                CASE
                                    WHEN TRUNC(ADMISSION_DATE) <= TRUNC(SYSDATE)
                                    AND TRUNC(NVL(DIS_DATE, SYSDATE + 1)) > TRUNC(SYSDATE)
                                    AND iptype_ind = 1
                                    THEN 1
                                    ELSE 0
                                END
                            ) AS count
                        FROM ipd_admission"))->count ?? 0,
                        

            'totalDischarged' => DB::table('ipd_admission')
                ->whereDate('dis_date', now()->toDateString())
                ->where('DIS_IND', 1)
                ->count() ?? 0,

            'erConversionPercentage' => DB::table('ipd_admission')
                ->whereDate('ADMISSION_DATE', now()->toDateString())
                ->where('iptype_ind', 2)
                ->where('ref_from_emr_ind', 1)
                ->selectRaw('SUM(CASE WHEN TRUNC(ADMISSION_DATE) = TRUNC(SYSDATE) THEN 1 ELSE 0 END) as today')
                ->value('today') ?? 0, // Avoid division by 0
            'totalIpdPatient' => DB::select("SELECT COUNT (DISTINCT mst.PATIENT_NO_FK) AS PATIENT_NO_FK
                    FROM finc_ledgermst lmst
                        JOIN finc_invoicemst mst ON mst.invoice_no_pk = lmst.invoice_no_fk
                    WHERE NVL (mst.admission_no_pk, 0) <> 0
                        AND TRUNC (lmst.ledger_date) = TRUNC (SYSDATE)"),
        ];

        // revinue part

        $revenueData = [
            'totalRevenueOpd' =>  DB::selectOne(DB::raw("SELECT SUM (lmst.LEDGER_AMT_sales) - SUM (lmst.LEDGER_AMT_DISCOUNT)
                        AS total_revenue
                FROM finc_ledgermst lmst
                    JOIN finc_invoicemst mst
                        ON mst.invoice_no_pk = lmst.invoice_no_fk
                    JOIN sysc_module MOD
                        ON mst.module_no_fk = MOD.module_no_pk
                WHERE     NVL (mst.admission_no_pk, 0) = 0
                    AND TRUNC (lmst.ledger_date) = TRUNC (SYSDATE)
                    AND MOD.module_code NOT IN ('PHR', 'PHR-I', 'PHR-O', 'PHR-E', 'PHR-D')"))->total_revenue ?? 0,
            'totalRevenueIpd' => DB::table('finc_ledgermst as lmst')
                ->join('finc_invoicemst as mst', 'mst.invoice_no_pk', '=', 'lmst.invoice_no_fk')
                ->join('ipd_admission as ipd', 'mst.admission_no_pk', '=', 'ipd.admission_no_pk')
                ->whereRaw('TRUNC(ipd.dis_date) = TRUNC(SYSDATE)')
                ->selectRaw('NVL(SUM(lmst.LEDGER_AMT_SALES) - SUM(lmst.LEDGER_AMT_DISCOUNT), 0) AS ip_revenue')
                ->first()->ip_revenue ?? 0,
            'totalRevenuePhr' => DB::table('finc_ledgermst as lmst')
                ->join('finc_invoicemst as mst', 'mst.invoice_no_pk', '=', 'lmst.invoice_no_fk')
                ->join('sysc_module as MOD', 'mst.module_no_fk', '=', 'MOD.module_no_pk')
                ->where(DB::raw('nvl(admission_no_pk, 0)'), '=', 0)
                ->whereIn('MOD.module_code', ['PHR', 'PHR-I', 'PHR-O', 'PHR-E', 'PHR-D'])  // Filtering by module code
                ->whereRaw('TRUNC(lmst.ledger_date) = TRUNC(SYSDATE)')  // Matching today's date (SYSDATE)
                ->selectRaw('SUM(lmst.LEDGER_AMT_SALES) - SUM(lmst.LEDGER_AMT_DISCOUNT) as phr_revenue')  // Calculate the revenue
                ->first()->phr_revenue ?? 0,
            // 'totalRevenue' => DB::table('finc_ledgermst as lmst')
            //     ->join('finc_invoicemst as mst', 'mst.invoice_no_pk', '=', 'lmst.invoice_no_fk')
            //     ->whereRaw('TRUNC(lmst.ledger_date) = TRUNC(SYSDATE)')
            //     ->selectRaw('SUM(lmst.LEDGER_AMT_SALES) - SUM(lmst.LEDGER_AMT_DISCOUNT) AS total_revenue')
            //     ->first()->total_revenue ?? 0,
            'totalRevenue' => DB::selectOne(DB::raw("         SELECT ROUND (SUM (sales), 2) total_revenue
                            FROM (SELECT NVL (SUM (lmst.LEDGER_AMT_SALES), 0)
               - NVL (SUM (lmst.LEDGER_AMT_DISCOUNT), 0)
                  AS sales
                                    FROM finc_invoicemst mst, finc_ledgermst lmst
                                    WHERE     MST.INVOICE_NO_PK = LMST.INVOICE_NO_FK
                                        AND NVL (MST.ADMISSION_no_pk, 0) = 0
                                        AND TRUNC (ledger_date) = TRUNC (SYSDATE)
                                    UNION
                                    SELECT NVL (SUM (LEDGER_AMT_SALES), 0) sales
                                    FROM finc_invoicemst mst, finc_ledgermst lmst, ipd_admission adm
                                    WHERE     MST.INVOICE_NO_PK = LMST.INVOICE_NO_FK
                                        AND MST.ADMISSION_no_pk = ADM.ADMISSION_NO_PK
                                        AND TRUNC (DIS_DATE) = TRUNC (SYSDATE))"))->total_revenue ?? 0,

        ];

        // revinue part

        $collectionData = [
            'totalCollection' => DB::selectOne(DB::raw("
                        SELECT SUM(coll) AS total_collection FROM (
                            SELECT NVL(SUM(lm.LEDGER_AMT_PAYMENT), 0) AS coll
                            FROM finc_invoicemst mst
                            JOIN finc_ledgermst lm ON mst.INVOICE_NO_PK = lm.INVOICE_NO_FK
                            WHERE NVL(mst.ADMISSION_no_pk, 0) = 0
                            AND TRUNC(lm.LEDGER_DATE) = TRUNC(SYSDATE)
                            UNION ALL
                            SELECT NVL(SUM(lm.LEDGER_AMT_PAYMENT), 0) AS coll
                            FROM finc_invoicemst mst
                            JOIN finc_ledgermst lm ON mst.INVOICE_NO_PK = lm.INVOICE_NO_FK
                            JOIN ipd_admission adm ON mst.ADMISSION_no_pk = adm.ADMISSION_NO_PK
                            WHERE TRUNC(lm.ledger_date) = TRUNC(SYSDATE)
                        )
                    "))->total_collection ?? 0,
            'totalCollectionOpd' => DB::table('finc_ledgermst as lmst')
                ->join('finc_invoicemst as mst', 'mst.invoice_no_pk', '=', 'lmst.invoice_no_fk')
                ->join('sysc_module as MOD', 'mst.module_no_fk', '=', 'MOD.module_no_pk')
                ->whereNotIn('MOD.module_code', ['PHR', 'PHR-I', 'PHR-O', 'PHR-E', 'PHR-D'])  // Filtering by module code
                ->whereRaw('NVL(mst.admission_no_pk, 0) = 0')
                ->whereRaw('TRUNC(lmst.ledger_date) = TRUNC(SYSDATE)')
                ->selectRaw('SUM(lmst.LEDGER_AMT_PAYMENT) AS opd_collection')
                ->first()->opd_collection ?? 0,
            'totalCollectionIpd' => DB::table('finc_ledgermst as lmst')
                ->join('finc_invoicemst as mst', 'mst.invoice_no_pk', '=', 'lmst.invoice_no_fk')
                ->join('ipd_admission as ipd', 'mst.admission_no_pk', '=', 'ipd.admission_no_pk')
                ->whereRaw('TRUNC(lmst.ledger_date) = TRUNC(SYSDATE)')
                ->selectRaw('NVL(SUM(lmst.LEDGER_AMT_PAYMENT), 0) AS ip_collection')
                ->first()->ip_collection ?? 0,
            'totalCollectionPhr' => DB::table('finc_ledgermst as lmst')
                ->join('finc_invoicemst as mst', 'mst.invoice_no_pk', '=', 'lmst.invoice_no_fk')
                ->join('sysc_module as MOD', 'mst.module_no_fk', '=', 'MOD.module_no_pk')
                ->whereIn('MOD.module_code', ['PHR', 'PHR-I', 'PHR-O', 'PHR-E', 'PHR-D'])  // Filtering by module code
                ->whereRaw('TRUNC(lmst.ledger_date) = TRUNC(SYSDATE)')  // Matching today's date (SYSDATE)
                ->selectRaw('SUM(lmst.LEDGER_AMT_PAYMENT) as phr_collection')  // Calculate the revenue
                ->first()->phr_collection ?? 0,
        ];
        return Template::loadview("admin.dashboards.management_dashboard_v5", compact(
            'opdData',
            'ipdData',
            'revenueData',
            'collectionData',
        ));
    }

    public function managementDashboardV3Search(Request $request)
    {
        $fromDate = "$request->from_date"; //date('Y/m/d', strtotime($request->date_from));
        $toDate = "$request->to_date"; //date('Y/m/d', strtotime($request->date_to));

        if (!empty($request->from_date) && !empty($request->to_date)) {

            $fromDate = "$request->from_date"; //date('Y/m/d', strtotime($request->date_from));
            $toDate = "$request->to_date"; //date('Y/m/d', strtotime($request->date_to));

        } else {
            $fromDate = "";
            $toDate = "";
        } // OPD Data
        $opdData = [
            'newRegistration' => DB::selectOne("SELECT COUNT(*) as count FROM patn_registration
                                            WHERE trunc(REG_DATE) BETWEEN TO_DATE('$fromDate', 'DD/MM/YYYY') AND TO_DATE('$toDate', 'DD/MM/YYYY')")->count ?? 0,

            'opdConsultations' => DB::selectOne("SELECT COUNT(*) as count FROM patn_appointment
                                             WHERE appoint_date BETWEEN TO_DATE('$fromDate', 'DD/MM/YYYY') AND TO_DATE('$toDate', 'DD/MM/YYYY')
                                             AND CANCEL_IND <> 1 and CONSULT_IND = 1")->count ?? 0,

            'opdHeadCount' => DB::selectOne("SELECT COUNT(DISTINCT PATIENT_NO_FK) as count FROM patn_appointment 
                                         WHERE appoint_date BETWEEN TO_DATE('$fromDate', 'DD/MM/YYYY') AND TO_DATE('$toDate', 'DD/MM/YYYY') AND NVL (CANCEL_IND, 0) = 0
       AND NVL (CONSULT_IND, 0) = 1")->count ?? 0,

            'erVisits' => DB::selectOne("SELECT SUM(CASE WHEN TRUNC(ADMISSION_DATE) = TRUNC(SYSDATE) THEN 1 ELSE 0 END) as today FROM ipd_admission
                                    WHERE ADMISSION_DATE BETWEEN TO_DATE('$fromDate', 'DD/MM/YYYY') AND TO_DATE('$toDate', 'DD/MM/YYYY')
                                    AND iptype_ind = 2
                                    AND ref_from_emr_ind = 1")->today ?? 0,

            'totalOPDPatient' => DB::selectOne("SELECT COUNT(DISTINCT mst.PATIENT_NO_FK) AS PATIENT_NO_FK
                                           FROM finc_ledgermst lmst
                                           JOIN finc_invoicemst mst ON mst.invoice_no_pk = lmst.invoice_no_fk
                                           WHERE NVL(mst.admission_no_pk, 0) = 0
                                           AND TRUNC(lmst.ledger_date) BETWEEN TO_DATE('$fromDate', 'DD/MM/YYYY') AND TO_DATE('$toDate', 'DD/MM/YYYY')")->PATIENT_NO_FK ?? 0,
        ];

        // IPD Data
        $ipdData = [
            'totalAdmissions' => DB::selectOne("SELECT SUM (
          CASE
             WHEN     TRUNC (ADMISSION_DATE) >=
                         TO_DATE ('$fromDate', 'dd/mm/yyyy')
                  AND TRUNC (ADMISSION_DATE) <=
                         TO_DATE ('$toDate', 'dd/mm/yyyy')
                  AND iptype_ind = 1
             THEN
                1
             ELSE
                0
          END)
          count   FROM ipd_admission")->count ?? 0,

            'currentIpd' =>  DB::selectOne(DB::raw("SELECT 
                            SUM (
                                CASE
                                    WHEN TRUNC(ADMISSION_DATE) <= TRUNC(SYSDATE)
                                    AND TRUNC(NVL(DIS_DATE, SYSDATE + 1)) > TRUNC(SYSDATE)
                                    AND iptype_ind = 1
                                    THEN 1
                                    ELSE 0
                                END
                            ) AS count
                        FROM ipd_admission"))->count ?? 0,


           'totalDischarged' => DB::selectOne(DB::raw("
                       SELECT SUM (
                            CASE
                                WHEN     TRUNC (DIS_DATE) >=
                                            TO_DATE ('01/07/2025', 'dd/mm/yyyy')
                                    AND TRUNC (DIS_DATE) <=
                                            TO_DATE ('31/07/2025', 'dd/mm/yyyy')
                                    AND iptype_ind = 1
                                THEN
                                    1
                                ELSE
                                    0
                            END)
                            count
                    FROM ipd_admission
                    "))->count ?? 0,


            'erConversionPercentage' => DB::selectOne("SELECT SUM(CASE WHEN TRUNC(ADMISSION_DATE) = TRUNC(SYSDATE) THEN 1 ELSE 0 END) as today FROM ipd_admission
                                                   WHERE ADMISSION_DATE BETWEEN TO_DATE('$fromDate', 'DD/MM/YYYY') AND TO_DATE('$toDate', 'DD/MM/YYYY')
                                                   AND iptype_ind = 2
                                                   AND ref_from_emr_ind = 1")->today ?? 0,

            'totalIpdPatient' => DB::selectOne("SELECT COUNT(DISTINCT mst.PATIENT_NO_FK) AS PATIENT_NO_FK
                                           FROM finc_ledgermst lmst
                                           JOIN finc_invoicemst mst ON mst.invoice_no_pk = lmst.invoice_no_fk
                                           WHERE NVL(mst.admission_no_pk, 0) <> 0
                                           AND TRUNC(lmst.ledger_date) BETWEEN TO_DATE('$fromDate', 'DD/MM/YYYY') AND TO_DATE('$toDate', 'DD/MM/YYYY')")->PATIENT_NO_FK ?? 0,
        ];
        // Revenue Data
        $revenueData = [
            'totalRevenueOpd' => DB::selectOne("SELECT SUM (lmst.LEDGER_AMT_sales) - SUM (lmst.LEDGER_AMT_DISCOUNT)
                        AS opd_revenue
                FROM finc_ledgermst lmst
                    JOIN finc_invoicemst mst
                        ON mst.invoice_no_pk = lmst.invoice_no_fk
                    JOIN sysc_module MOD
                        ON mst.module_no_fk = MOD.module_no_pk
                WHERE     NVL (mst.admission_no_pk, 0) = 0
                    AND TRUNC (lmst.ledger_date) BETWEEN TO_DATE('$fromDate', 'DD/MM/YYYY') AND TO_DATE('$toDate', 'DD/MM/YYYY')
                    AND MOD.module_code NOT IN ('PHR', 'PHR-I', 'PHR-O', 'PHR-E', 'PHR-D')")->opd_revenue ?? 0,
            'totalRevenueIpd' => DB::selectOne("SELECT NVL(SUM(lmst.LEDGER_AMT_SALES) - SUM(lmst.LEDGER_AMT_DISCOUNT), 0) ip_revenue
                                           FROM finc_ledgermst lmst
                                           JOIN finc_invoicemst mst ON mst.invoice_no_pk = lmst.invoice_no_fk
                                           JOIN ipd_admission ipd ON mst.admission_no_pk = ipd.admission_no_pk
                                           WHERE TRUNC(ipd.dis_date) BETWEEN TO_DATE('$fromDate', 'DD/MM/YYYY') AND TO_DATE('$toDate', 'DD/MM/YYYY')")->ip_revenue ?? 0,

            'totalRevenuePhr' => DB::selectOne("SELECT SUM(lmst.LEDGER_AMT_SALES) - SUM(lmst.LEDGER_AMT_DISCOUNT) phr_revenue
                                           FROM finc_ledgermst lmst
                                           JOIN finc_invoicemst mst ON mst.invoice_no_pk = lmst.invoice_no_fk
                                           JOIN sysc_module MOD ON mst.module_no_fk = MOD.module_no_pk
                                           WHERE MOD.module_code IN ('PHR', 'PHR-I', 'PHR-O', 'PHR-E', 'PHR-D')
                                           and NVL (mst.admission_no_pk, 0) = 0
                                           AND TRUNC(lmst.ledger_date) BETWEEN TO_DATE('$fromDate', 'DD/MM/YYYY') AND TO_DATE('$toDate', 'DD/MM/YYYY')")->phr_revenue ?? 0,

         'totalRevenue' => DB::selectOne(DB::raw("
                        SELECT ROUND(SUM(sales), 2) total_revenue
                        FROM (
                            SELECT NVL(SUM(lmst.LEDGER_AMT_SALES), 0) - NVL(SUM(lmst.LEDGER_AMT_DISCOUNT), 0) AS sales
                            FROM finc_invoicemst mst, finc_ledgermst lmst
                            WHERE mst.INVOICE_NO_PK = lmst.INVOICE_NO_FK
                            AND NVL(mst.ADMISSION_no_pk, 0) = 0
                            AND TRUNC(ledger_date) BETWEEN TO_DATE(:fromDate, 'DD/MM/YYYY') AND TO_DATE(:toDate, 'DD/MM/YYYY')

                            UNION

                            SELECT NVL(SUM(LEDGER_AMT_SALES), 0) sales
                            FROM finc_invoicemst mst, finc_ledgermst lmst, ipd_admission adm
                            WHERE mst.INVOICE_NO_PK = lmst.INVOICE_NO_FK
                            AND mst.ADMISSION_no_pk = adm.ADMISSION_NO_PK
                            AND TRUNC(DIS_DATE) BETWEEN TO_DATE(:fromDate, 'DD/MM/YYYY') AND TO_DATE(:toDate, 'DD/MM/YYYY')
                        )
                    "), [
                        'fromDate' => $fromDate,
                        'toDate' => $toDate
                    ])->total_revenue ?? 0



        ];

        $avarageRevenueOpd = $avaragePatientRevenueOpd = $totalIPDPatientCount = $avaragePatientRevenueIpd = 0;

        if ($opdData['opdHeadCount'] > 0) {
            $totalOPDPatient = $opdData['opdHeadCount'] ? $opdData['opdHeadCount'] : 0;
            $totalIPDPatient = $ipdData['totalIpdPatient'] ? $ipdData['totalIpdPatient'] : 0;
            if ($opdData['opdHeadCount'] > 0) {
                $avarageRevenueOpd = intval($revenueData['totalRevenueOpd'] / $opdData['opdHeadCount']);
            }

            if ($totalOPDPatient > 0) {
                $avaragePatientRevenueOpd = intval($revenueData['totalRevenueOpd'] / $totalOPDPatient);
            }

            if ($totalIPDPatient > 0) {
                $avaragePatientRevenueIpd = intval($revenueData['totalRevenueIpd'] / $totalIPDPatient);
            }
        }
        $arpoB = 0;
        $totalRevenueIpd = $revenueData['totalRevenueIpd'] ?? 0;
        $totalOccupiedBedDays = $ipdData['totalOccupiedBedDays'] ?? 0;

        if ($totalOccupiedBedDays > 0) {
            $arpoB = round($totalRevenueIpd / $totalOccupiedBedDays, 2);
        }

        $alos = 0;
        $totalIpdBedDays = $ipdData['totalIpdBedDays'] ?? 0;
        $totalDischargedPatients = $ipdData['totalDischarged'] ?? 0;
        if ($totalDischargedPatients > 0) {
            $alos = round($totalIpdBedDays / $totalDischargedPatients, 2);
        }
        // Send the calculated data along with the response

        $collectionData = [
            'totalCollectionOpd' => DB::selectOne("SELECT
                        SUM(lmst.LEDGER_AMT_PAYMENT) AS opd_collection
                    FROM
                        finc_ledgermst lmst
                    JOIN
                        finc_invoicemst mst
                        ON mst.invoice_no_pk = lmst.invoice_no_fk
                        JOIN 
                                    sysc_module MOD ON mst.module_no_fk = MOD.module_no_pk
                    WHERE
                        NVL(mst.admission_no_pk, 0) = 0
                        AND TRUNC(lmst.ledger_date) BETWEEN TO_DATE('$fromDate', 'DD/MM/YYYY') AND TO_DATE('$toDate', 'DD/MM/YYYY') and MOD.module_code NOT IN ('PHR', 'PHR-I', 'PHR-O', 'PHR-E', 'PHR-D')")->opd_collection ?? 0,
            'totalCollectionIpd' => DB::selectOne("SELECT SUM(lmst.ledger_amt_payment) AS ip_collection
                        FROM finc_ledgermst lmst JOIN finc_invoicemst mst ON mst.invoice_no_pk = lmst.invoice_no_fk
                        JOIN ipd_admission ipd ON mst.admission_no_pk = ipd.admission_no_pk
                        WHERE TRUNC(lmst.ledger_date) BETWEEN TO_DATE('$fromDate', 'DD/MM/YYYY') AND TO_DATE('$toDate', 'DD/MM/YYYY')")->ip_collection ?? 0,



            'totalCollectionPhr' => DB::selectOne(" SELECT 
                                    SUM(lmst.LEDGER_AMT_PAYMENT) AS phr_collection
                                FROM 
                                    finc_ledgermst lmst
                                JOIN 
                                    finc_invoicemst mst ON mst.invoice_no_pk = lmst.invoice_no_fk
                                JOIN 
                                    sysc_module MOD ON mst.module_no_fk = MOD.module_no_pk
                                WHERE TRUNC(lmst.ledger_date) BETWEEN TO_DATE('$fromDate', 'DD/MM/YYYY') AND TO_DATE('$toDate', 'DD/MM/YYYY') 
                                    and MOD.module_code IN ('PHR', 'PHR-I', 'PHR-O', 'PHR-E', 'PHR-D')")->phr_collection ?? 0,

            'totalCollection' => DB::selectOne(DB::raw("
                SELECT SUM(coll) AS total_collection FROM (
                    SELECT NVL(SUM(lm.LEDGER_AMT_PAYMENT), 0) AS coll
                    FROM finc_invoicemst mst
                    JOIN finc_ledgermst lm ON mst.INVOICE_NO_PK = lm.INVOICE_NO_FK
                    WHERE NVL(mst.ADMISSION_no_pk, 0) = 0
                    AND TRUNC(lm.LEDGER_DATE) BETWEEN TO_DATE('$fromDate', 'DD/MM/YYYY') AND TO_DATE('$toDate', 'DD/MM/YYYY')
                    UNION ALL
                    SELECT NVL(SUM(lm.LEDGER_AMT_PAYMENT), 0) AS coll
                    FROM finc_invoicemst mst
                    JOIN finc_ledgermst lm ON mst.INVOICE_NO_PK = lm.INVOICE_NO_FK
                    JOIN ipd_admission adm ON mst.ADMISSION_no_pk = adm.ADMISSION_NO_PK
                    WHERE TRUNC(lm.ledger_date) BETWEEN TO_DATE('$fromDate', 'DD/MM/YYYY') AND TO_DATE('$toDate', 'DD/MM/YYYY')
                )
            "))->total_collection ?? 0,
        ];
        $response = [
            'success' => true,
            'opdData' => $opdData,
            'collectionData' => $collectionData,
            'ipdData' => $ipdData,
            'revenueData' => $revenueData,
            'averageRevenueOpd' => $avarageRevenueOpd,
            'averagePatientRevenueOpd' => $avaragePatientRevenueOpd,
            'arpoB' => $arpoB,
            'alos' => $alos,
        ];
        return response()->json($response);
    }
}
