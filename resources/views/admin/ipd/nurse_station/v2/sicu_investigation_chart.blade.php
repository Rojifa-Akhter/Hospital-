<style>
    .custom-form {
        width: 100%;
        border: none;
        outline: none;
    }

    .border-left-0 {
        border-left: none !important;
    }

    .border-right-0 {
        border-right: none !important;
    }

    .medicine_thead {
        background-color: #e1e1e5;
    }

    .w-15 {
        width: 15%;
    }

    .w-25 {
        width: 25%;
    }

    .w-8 {
        width: 8%;
    }

    .w-6 {
        width: 6%;
    }

    .w-16 {
        width: 16%;
    }

    .remove_row {
        cursor: pointer;
        background-color: white;
    }

    .fa-star {
        display: none;
    }

    thead {
        position: sticky;
        top: 0px;
        left: 0px;
        right: 0px;
        background-color: white;
    }

    .fs-12 {
        font-size: 14px;
    }

    .pdf-icon {
        font-size: 22px;
        color: red
    }

    .add-btn {

        margin: 5px 2px;
        padding: 2px 4px;
        cursor: pointer;
        background: #008CBA;
        color: #fff;
        border: none;
        border-radius: 3px;

    }

    #medTable input,
    #painTable input,
    #monitorTable input {
        width: 100%;

    }

    #medTable th,
    #painTable th,
    #monitorTable th {
        font-size: 14px
    }

    #medTable th,
    #painTable th,
    #monitorTable th #medTable td,
    #painTable td,
    #monitorTable td {
        text-align: center;
    }


    .add-col-btn:hover {
        color: darkgreen;
        transform: scale(1.2);
    }

    .remove-col-btn {
        cursor: pointer;
        background: #CF5C46;
        color: white;
        border: none;
        padding: 2px 5px;
        font-size: 12px;
    }
    .blood-gas-table input[type="text"] {
        width: 100%;
        padding: 2px;
        font-size: 12px;
        text-align: center;
    }
    textarea {
        width: 100%;
        height: 100%;
        font-size: 12px;
    }
</style>

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">SICU INVESTIGATION CHART</h5>
                            <small>IPD / Nurse Station / sicu investigation chart form</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('sicu-investigation-chart-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
                                Export</a>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body pt-2">
                            <div class="row">

                                <div class="col-12 pb-4 text-center">
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Patient Name:
                                        {{ @$patient_info->patient_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">UHID:
                                        {{ @$patient_info->patient_code }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No:
                                        {{ @$patient_info->admission_uid }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date:
                                        {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission
                                        Department: {{ $patient_info->admitted_department }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Age:
                                        {{ $patient_info->age }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Gender:
                                        {{ $patient_info->gender_txt }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                                        {{ $patient_info->bed_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Consultant Name:
                                        {{ $admission_info->primary_doctor_name }}</span>
                                </div>

                                <div class="col-md-12">
                                    <form action="{{ route('sicu-investigation-chart-store') }}" method="post"
                                        id="SICUINVESTIGATION">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="sicu_investigation_no_pk"
                                            value="{{ isset($sicu_chart->sicu_investigation_no_pk) ? $sicu_chart->sicu_investigation_no_pk : '' }}">


                                        <div class="table-responsive">
                                            <table border="1" cellspacing="0" cellpadding="4"
                                                style="border-collapse:collapse; width:100%; text-align:center; table-layout:fixed; font-size:12px;">

                                                <thead>
                                                    <tr style="font-weight:700;">
                                                        <th colspan="3">HEMATOLOGY</th>
                                                        <th colspan="2">CARDIAC ENZYMES</th>
                                                        <th colspan="3">BIOCHEMICAL</th>

                                                    </tr>

                                                    <tr style="font-weight:700;">

                                                        <th>TIME</th>
                                                        <th>Pre-op</th>
                                                        <th></th>
                                                        <th>Troponin-I</th>
                                                        <th></th>
                                                        <th>Time</th>
                                                        <th>Pre-op</th>
                                                        <th></th>
                                                    </tr>
                                                </thead>

                                                <tbody>

                                                    <tr>
                                                        <td>HB</td>
                                                        <td><input type="text" name="hema_hb" value="{{@$sicu_chart->hema_hb}}"></td>
                                                        <td><input type="text" name="hema_hb2" value="{{@$sicu_chart->hema_hb2}}"></td>
                                                        <td>Time</td>
                                                        <td><input type="text" name="cardiac_time" value="{{@$sicu_chart->cardiac_time}}"></td>
                                                        <td>GLU Random/Fasting</td>
                                                        <td><input type="text" name="bio_glu" value="{{@$sicu_chart->bio_glu}}"></td>
                                                        <td><input type="text" name="bio_glu2" value="{{@$sicu_chart->bio_glu2}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td>PCV</td>
                                                        <td><input type="text" name="hema_pcv" value="{{@$sicu_chart->hema_pcv}}"></td>
                                                        <td><input type="text" name="hema_pcv2" value="{{@$sicu_chart->hema_pcv2}}"></td>
                                                        <td>SGOT(AST)</td>
                                                        <td><input type="text" name="cardiac_sgot" value="{{@$sicu_chart->cardiac_sgot}}"></td>
                                                        <td>UREA</td>
                                                        <td><input type="text" name="bio_urea" value="{{@$sicu_chart->bio_urea}}"></td>
                                                        <td><input type="text" name="bio_urea2" value="{{@$sicu_chart->bio_urea2}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td>WBC</td>
                                                        <td><input type="text" name="hema_wbc" value="{{@$sicu_chart->hema_wbc}}"></td>
                                                        <td><input type="text" name="hema_wbc2" value="{{@$sicu_chart->hema_wbc2}}"></td>
                                                        <td>CPK</td>
                                                        <td><input type="text" name="cardiac_cpk" value="{{@$sicu_chart->cardiac_cpk}}"></td>
                                                        <td>CREATININE</td>
                                                        <td><input type="text" name="bio_creatinine" value="{{@$sicu_chart->bio_creatinine}}"></td>
                                                        <td><input type="text" name="bio_creatinine2" value="{{@$sicu_chart->bio_creatinine2}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td>Platelet Count</td>
                                                        <td><input type="text" name="hema_platelet" value="{{@$sicu_chart->hema_platelet}}"></td>
                                                        <td><input type="text" name="hema_platelet2" value="{{@$sicu_chart->hema_platelet2}}"></td>
                                                        <td>CPKMB</td>
                                                        <td><input type="text" name="cardiac_cpkmb" value="{{@$sicu_chart->cardiac_cpkmb}}"></td>
                                                        <td>Sr. URIC ACID</td>
                                                        <td><input type="text" name="bio_acid" value="{{@$sicu_chart->bio_acid}}"></td>
                                                        <td><input type="text" name="bio_acid2" value="{{@$sicu_chart->bio_acid2}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td>ESR</td>
                                                        <td><input type="text" name="hema_esr" value="{{@$sicu_chart->hema_esr}}"></td>
                                                        <td><input type="text" name="hema_esr2" value="{{@$sicu_chart->hema_esr2}}"></td>
                                                        <td>LDH</td>
                                                        <td><input type="text" name="cardiac_ldh" value="{{@$sicu_chart->cardiac_ldh}}"></td>
                                                        <td>K+(eGFR)</td>
                                                        <td><input type="text" name="bio_egfr" value="{{@$sicu_chart->bio_egfr}}"></td>
                                                        <td><input type="text" name="bio_egfr2" value="{{@$sicu_chart->bio_egfr2}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td>Neutrophil</td>
                                                        <td><input type="text" name="hema_neutrophil" value="{{@$sicu_chart->hema_neutrophil}}"></td>
                                                        <td><input type="text" name="hema_neutrophil2" value="{{@$sicu_chart->hema_neutrophil2}}"></td>
                                                        <td colspan="2"><strong>CARDIOLOGY</strong></td>
                                                        <td>Na+/Cl-</td>
                                                        <td><input type="text" name="bio_na" value="{{@$sicu_chart->bio_na}}"></td>
                                                        <td><input type="text" name="bio_na2" value="{{@$sicu_chart->bio_na2}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td>Lymphocyte</td>
                                                        <td><input type="text" name="hema_lymphocyte" value="{{@$sicu_chart->hema_lymphocyte}}"></td>
                                                        <td><input type="text" name="hema_lymphocyte2" value="{{@$sicu_chart->hema_lymphocyte}}"></td>
                                                        <td colspan="2">ECG</td>
                                                        <td>BILIRUBIN. T.</td>
                                                        <td><input type="text" name="bio_t" value="{{@$sicu_chart->bio_t}}"></td>
                                                        <td><input type="text" name="bio_t2" value="{{@$sicu_chart->bio_t2}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td>Eosinophil</td>
                                                        <td><input type="text" name="hema_nophil" value="{{@$sicu_chart->hema_nophil}}"></td>
                                                        <td><input type="text" name="hema_nophil2" value="{{@$sicu_chart->hema_nophil2}}"></td>
                                                        <td colspan="2" rowspan="3">
                                                            <textarea name="car_ecg" id="" cols="45" rows="5">{{@$sicu_chart->car_ecg}}</textarea>
                                                        </td>

                                                        <td>BILIRUBIN. D.</td>
                                                        <td><input type="text" name="bio_d" value="{{@$sicu_chart->bio_d}}"></td>
                                                        <td><input type="text" name="bio_d2" value="{{@$sicu_chart->bio_d2}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td>Monocyte</td>
                                                        <td><input type="text" name="hema_monocyte" value="{{@$sicu_chart->hema_monocyte}}"></td>
                                                        <td><input type="text" name="hema_monocyte2" value="{{@$sicu_chart->hema_monocyte2}}"></td>

                                                        <td>BILIRUBIN. I.</td>
                                                        <td><input type="text" name="bio_i" value="{{@$sicu_chart->bio_i}}"></td>
                                                        <td><input type="text" name="bio_i2" value="{{@$sicu_chart->bio_i2}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td>Basophil</td>
                                                        <td><input type="text" name="hema_basophil" value="{{@$sicu_chart->hema_basophil}}"></td>
                                                        <td><input type="text" name="hema_basophil2" value="{{@$sicu_chart->hema_basophil2}}"></td>

                                                        <td>ALK.PHOS</td>
                                                        <td><input type="text" name="bio_phos" value="{{@$sicu_chart->bio_phos}}"></td>
                                                        <td><input type="text" name="bio_phos2" value="{{@$sicu_chart->bio_phos2}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="3"><strong>BIOCHEMISTRY</strong></td>
                                                        <td colspan="2">Echo</td>
                                                        <td>SGPT(ALT)</td>
                                                        <td><input type="text" name="bio_alt" value="{{@$sicu_chart->bio_alt}}"></td>
                                                        <td><input type="text" name="bio_alt2" value="{{@$sicu_chart->bio_alt2}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2">Cholesterol</td>
                                                        <td rowspan="2"><input type="text" name="bioche_cholesterol"
                                                                value="{{@$sicu_chart->bioche_cholesterol}}"></td>
                                                        <td rowspan="2"><input type="text" name="bioche_cholesterol2"
                                                                value="{{@$sicu_chart->bioche_cholesterol2}}"></td>
                                                        <td colspan="2" rowspan="3">
                                                            <textarea name="car_echo" id="" cols="45" rows="5">{{@$sicu_chart->car_echo}}</textarea>
                                                        </td>
                                                        <td>SGOT (AST)</td>
                                                        <td><input type="text" name="bio_ast" value="{{@$sicu_chart->bio_ast}}"></td>
                                                        <td><input type="text" name="bio_ast2" value="{{@$sicu_chart->bio_ast2}}"></td>

                                                    </tr>
                                                    <tr>

                                                        <td>ALBUMIN</td>
                                                        <td><input type="text" name="bio_albumin" value="{{@$sicu_chart->bio_albumin}}"></td>
                                                        <td><input type="text" name="bio_albumin2" value="{{@$sicu_chart->bio_albumin2}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2">Triglyceride</td>
                                                        <td rowspan="2"><input type="text" name="bioche_trigly"
                                                                value="{{@$sicu_chart->bioche_trigly}}"></td>
                                                        <td rowspan="2"><input type="text" name="bioche_trigly2"
                                                                value="{{@$sicu_chart->bioche_trigly2}}"></td>
                                                        <td>TOTAL PROTEIN</td>
                                                        <td><input type="text" name="bio_protein" value="{{@$sicu_chart->bio_protein}}"></td>
                                                        <td><input type="text" name="bio_protein2" value="{{@$sicu_chart->bio_protein2}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td colspan="2">CARDIAC CATH</td>
                                                        <td>CALCIUM</td>
                                                        <td><input type="text" name="bio_calcium" value="{{@$sicu_chart->bio_calcium}}"></td>
                                                        <td><input type="text" name="bio_calcium2" value="{{@$sicu_chart->bio_calcium2}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2">HDL</td>
                                                        <td rowspan="2"><input type="text" name="bioche_hdl"
                                                                value="{{@$sicu_chart->bioche_hdl}}"></td>
                                                        <td rowspan="2"><input type="text" name="bioche_hdl2"
                                                                value="{{@$sicu_chart->bioche_hdl2}}"></td>
                                                        <td colspan="2" rowspan="4">
                                                            <textarea name="car_cath" id="" cols="45" rows="5">{{@$sicu_chart->car_cath}}</textarea>
                                                        </td>
                                                        <td>Sr. INOR. PHOS/Mg++</td>
                                                        <td><input type="text" name="bio_mg" value="{{@$sicu_chart->bio_mg}}"></td>
                                                        <td><input type="text" name="bio_mg2" value="{{@$sicu_chart->bio_mg2}}"></td>

                                                    </tr>
                                                    <tr>

                                                        <td>FT4</td>
                                                        <td><input type="text" name="bio_ft" value="{{@$sicu_chart->bio_ft}}"></td>
                                                        <td><input type="text" name="bio_ft2" value="{{@$sicu_chart->bio_ft2}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2">LDL</td>
                                                        <td rowspan="2"><input type="text" name="bioche_ldl"
                                                                value="{{@$sicu_chart->bioche_ldl}}"></td>
                                                        <td rowspan="2"><input type="text" name="bioche_ldl2"
                                                                value="{{@$sicu_chart->bioche_ldl2}}"></td>
                                                        <td>FT3</td>
                                                        <td><input type="text" name="bio_ft3" value="{{@$sicu_chart->bio_ft3}}"></td>
                                                        <td><input type="text" name="bio_ft4" value="{{@$sicu_chart->bio_ft4}}"></td>

                                                    </tr>
                                                    <tr>

                                                        <td>TSH</td>
                                                        <td><input type="text" name="bio_tsh" value="{{@$sicu_chart->bio_tsh}}"></td>
                                                        <td><input type="text" name="bio_tsh2" value="{{@$sicu_chart->bio_tsh2}}"></td>

                                                    </tr>




                                                </tbody>
                                            </table> <br>
                                            <table border="1" cellspacing="0" cellpadding="4"
                                                style="border-collapse:collapse; width:100%; text-align:center; table-layout:fixed; font-size:12px;">
                                                <thead>
                                                    <tr style="font-weight:700;">
                                                        <th colspan="5">COAGULATION PROFILE</th>
                                                        <th colspan="2">RADIOLOGY</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>TIME</td>
                                                        <td><input type="text" name="profile_time" value="{{@$sicu_chart->profile_time}}"></td>
                                                        <td><input type="text" name="profile_time2" value="{{@$sicu_chart->profile_time2}}"></td>
                                                        <td><input type="text" name="profile_time3" value="{{@$sicu_chart->profile_time3}}"></td>
                                                        <td><input type="text" name="profile_time4" value="{{@$sicu_chart->profile_time4}}"></td>
                                                        <td colspan="2">X-Ray</td>

                                                    </tr>
                                                    <tr>
                                                        <td>PT</td>
                                                        <td><input type="text" name="profile_pt" value="{{@$sicu_chart->profile_pt}}"></td>
                                                        <td><input type="text" name="profile_pt2" value="{{@$sicu_chart->profile_pt2}}"></td>
                                                        <td><input type="text" name="profile_pt3" value="{{@$sicu_chart->profile_pt3}}"></td>
                                                        <td><input type="text" name="profile_pt4" value="{{@$sicu_chart->profile_pt4}}"></td>
                                                        <td colspan="2" rowspan="4">
                                                            <textarea name="xray" cols="45" rows="4">{{@$sicu_chart->xray}}</textarea>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>APTT</td>
                                                        <td><input type="text" name="profile_aptt" value="{{@$sicu_chart->profile_aptt}}"></td>
                                                        <td><input type="text" name="profile_aptt2" value="{{@$sicu_chart->profile_aptt2}}"></td>
                                                        <td><input type="text" name="profile_aptt3" value="{{@$sicu_chart->profile_aptt3}}"></td>
                                                        <td><input type="text" name="profile_aptt4" value="{{@$sicu_chart->profile_aptt4}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td>INR</td>
                                                        <td><input type="text" name="profile_inr" value="{{@$sicu_chart->profile_inr}}"></td>
                                                        <td><input type="text" name="profile_inr2" value="{{@$sicu_chart->profile_inr2}}"></td>
                                                        <td><input type="text" name="profile_inr3" value="{{@$sicu_chart->profile_inr3}}"></td>
                                                        <td><input type="text" name="profile_inr4" value="{{@$sicu_chart->profile_inr4}}"></td>


                                                    </tr>
                                                    <tr>
                                                        <td>PLATELET COUNT</td>
                                                        <td><input type="text" name="profile_count" value="{{@$sicu_chart->profile_count}}"></td>
                                                        <td><input type="text" name="profile_count2" value="{{@$sicu_chart->profile_count2}}"></td>
                                                        <td><input type="text" name="profile_count3" value="{{@$sicu_chart->profile_count3}}"></td>
                                                        <td><input type="text" name="profile_count4" value="{{@$sicu_chart->profile_count4}}"></td>


                                                    </tr>
                                                    <tr>
                                                        <td>B.T</td>
                                                        <td><input type="text" name="profile_bt" value="{{@$sicu_chart->profile_bt}}"></td>
                                                        <td><input type="text" name="profile_bt2" value="{{@$sicu_chart->profile_bt2}}"></td>
                                                        <td><input type="text" name="profile_bt3" value="{{@$sicu_chart->profile_bt3}}"></td>
                                                        <td><input type="text" name="profile_bt4" value="{{@$sicu_chart->profile_bt4}}"></td>
                                                        <td colspan="2">OTHERS</td>


                                                    </tr>
                                                    <tr>
                                                        <td>C.T</td>
                                                        <td><input type="text" name="profile_ct" value="{{@$sicu_chart->profile_ct}}"></td>
                                                        <td><input type="text" name="profile_ct2" value="{{@$sicu_chart->profile_ct2}}"></td>
                                                        <td><input type="text" name="profile_ct3" value="{{@$sicu_chart->profile_ct3}}"></td>
                                                        <td><input type="text" name="profile_ct4" value="{{@$sicu_chart->profile_ct4}}"></td>
                                                        <td colspan="2" rowspan="4">
                                                            <textarea name="rd_other" cols="45" rows="4">{{@$sicu_chart->rd_other}}</textarea>
                                                        </td>

                                                    </tr>
                                                    <tr>
                                                        <td>D.DIMER</td>
                                                        <td><input type="text" name="profile_dimer" value="{{@$sicu_chart->profile_dimer}}"></td>
                                                        <td><input type="text" name="profile_dimer2" value="{{@$sicu_chart->profile_dimer2}}"></td>
                                                        <td><input type="text" name="profile_dimer3" value="{{@$sicu_chart->profile_dimer3}}"></td>
                                                        <td><input type="text" name="profile_dimer4" value="{{@$sicu_chart->profile_dimer4}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td>FIBRINOGEN</td>
                                                        <td><input type="text" name="profile_fib" value="{{@$sicu_chart->profile_fib}}"></td>
                                                        <td><input type="text" name="profile_fib2" value="{{@$sicu_chart->profile_fib2}}"></td>
                                                        <td><input type="text" name="profile_fib3" value="{{@$sicu_chart->profile_fib3}}"></td>
                                                        <td><input type="text" name="profile_fib4" value="{{@$sicu_chart->profile_fib4}}"></td>


                                                    </tr>
                                                    <tr>
                                                        <td>FDP</td>
                                                        <td><input type="text" name="profile_fdp" value="{{@$sicu_chart->profile_fdp}}"></td>
                                                        <td><input type="text" name="profile_fdp2" value="{{@$sicu_chart->profile_fdp2}}"></td>
                                                        <td><input type="text" name="profile_fdp3" value="{{@$sicu_chart->profile_fdp3}}"></td>
                                                        <td><input type="text" name="profile_fdp4" value="{{@$sicu_chart->profile_fdp4}}"></td>


                                                    </tr>


                                                </tbody>

                                            </table> <br>
                                             <table border="1" cellspacing="0" cellpadding="4" class="blood-gas-table"
                                                style="border-collapse:collapse; width:100%; text-align:center; table-layout:fixed; font-size:12px;">
                                                <thead>
                                                    <tr style="font-weight:700;">
                                                        <th colspan="10">BLOOD GAS ANALYSIS</th>
                                                        <th colspan="2">OTHERS INVESTIGATION</th>


                                                    </tr>
                                                </thead>
                                                <tbody>
                                                    <tr>
                                                        <td>TIME</td>
                                                        <td><input type="text" name="blood_time" value="{{@$sicu_chart->blood_time}}"></td>
                                                        <td><input type="text" name="blood_time2" value="{{@$sicu_chart->blood_time2}}"></td>
                                                        <td><input type="text" name="blood_time3" value="{{@$sicu_chart->blood_time3}}"></td>
                                                        <td><input type="text" name="blood_time4" value="{{@$sicu_chart->blood_time4}}"></td>
                                                        <td><input type="text" name="blood_time5" value="{{@$sicu_chart->blood_time5}}"></td>
                                                        <td><input type="text" name="blood_time6" value="{{@$sicu_chart->blood_time6}}"></td>
                                                        <td><input type="text" name="blood_time7" value="{{@$sicu_chart->blood_time7}}"></td>
                                                        <td><input type="text" name="blood_time8" value="{{@$sicu_chart->blood_time8}}"></td>
                                                        <td><input type="text" name="blood_time9" value="{{@$sicu_chart->blood_time9}}"></td>
                                                        <td colspan="2" rowspan="10"><textarea name="investigation" cols="30" rows="25">{{@$sicu_chart->investigation}}</textarea></td>


                                                    </tr>
                                                    <tr>
                                                        <td>PH</td>
                                                        <td><input type="text" name="blood_ph" value="{{@$sicu_chart->blood_ph}}"></td>
                                                        <td><input type="text" name="blood_ph2" value="{{@$sicu_chart->blood_ph2}}"></td>
                                                        <td><input type="text" name="blood_ph3" value="{{@$sicu_chart->blood_ph3}}"></td>
                                                        <td><input type="text" name="blood_ph4" value="{{@$sicu_chart->blood_ph4}}"></td>
                                                        <td><input type="text" name="blood_ph5" value="{{@$sicu_chart->blood_ph5}}"></td>
                                                        <td><input type="text" name="blood_ph6" value="{{@$sicu_chart->blood_ph6}}"></td>
                                                        <td><input type="text" name="blood_ph7" value="{{@$sicu_chart->blood_ph7}}"></td>
                                                        <td><input type="text" name="blood_ph8" value="{{@$sicu_chart->blood_ph8}}"></td>
                                                        <td><input type="text" name="blood_ph9" value="{{@$sicu_chart->blood_ph9}}"></td>


                                                    </tr>
                                                    <tr>
                                                       <td>PCO2</td>
                                                        <td><input type="text" name="blood_pco" value="{{@$sicu_chart->blood_pco}}"></td>
                                                        <td><input type="text" name="blood_pco2" value="{{@$sicu_chart->blood_pco2}}"></td>
                                                        <td><input type="text" name="blood_pco3" value="{{@$sicu_chart->blood_pco3}}"></td>
                                                        <td><input type="text" name="blood_pco4" value="{{@$sicu_chart->blood_pco4}}"></td>
                                                        <td><input type="text" name="blood_pco5" value="{{@$sicu_chart->blood_pco5}}"></td>
                                                        <td><input type="text" name="blood_pco6" value="{{@$sicu_chart->blood_pco6}}"></td>
                                                        <td><input type="text" name="blood_pco7" value="{{@$sicu_chart->blood_pco7}}"></td>
                                                        <td><input type="text" name="blood_pco8" value="{{@$sicu_chart->blood_pco8}}"></td>
                                                        <td><input type="text" name="blood_pco9" value="{{@$sicu_chart->blood_pco9}}"></td>


                                                    </tr>
                                                    <tr>
                                                         <td>PO2</td>
                                                        <td><input type="text" name="blood_po" value="{{@$sicu_chart->blood_po}}"></td>
                                                        <td><input type="text" name="blood_po2" value="{{@$sicu_chart->blood_po2}}"></td>
                                                        <td><input type="text" name="blood_po3" value="{{@$sicu_chart->blood_po3}}"></td>
                                                        <td><input type="text" name="blood_po4" value="{{@$sicu_chart->blood_po4}}"></td>
                                                        <td><input type="text" name="blood_po5" value="{{@$sicu_chart->blood_po5}}"></td>
                                                        <td><input type="text" name="blood_po6" value="{{@$sicu_chart->blood_po6}}"></td>
                                                        <td><input type="text" name="blood_po7" value="{{@$sicu_chart->blood_po7}}"></td>
                                                        <td><input type="text" name="blood_po8" value="{{@$sicu_chart->blood_po8}}"></td>
                                                        <td><input type="text" name="blood_po9" value="{{@$sicu_chart->blood_po9}}"></td>


                                                    </tr>
                                                    <tr>
                                                         <td>HCO3</td>
                                                        <td><input type="text" name="blood_hco" value="{{@$sicu_chart->blood_hco}}"></td>
                                                        <td><input type="text" name="blood_hco2" value="{{@$sicu_chart->blood_hco2}}"></td>
                                                        <td><input type="text" name="blood_hco3" value="{{@$sicu_chart->blood_hco3}}"></td>
                                                        <td><input type="text" name="blood_hco4" value="{{@$sicu_chart->blood_hco4}}"></td>
                                                        <td><input type="text" name="blood_hco5" value="{{@$sicu_chart->blood_hco5}}"></td>
                                                        <td><input type="text" name="blood_hco6" value="{{@$sicu_chart->blood_hco6}}"></td>
                                                        <td><input type="text" name="blood_hco7" value="{{@$sicu_chart->blood_hco7}}"></td>
                                                        <td><input type="text" name="blood_hco8" value="{{@$sicu_chart->blood_hco8}}"></td>
                                                        <td><input type="text" name="blood_hco9" value="{{@$sicu_chart->blood_hco9}}"></td>


                                                    </tr>
                                                    <tr>
                                                         <td>BE</td>
                                                        <td><input type="text" name="blood_be" value="{{@$sicu_chart->blood_be}}"></td>
                                                        <td><input type="text" name="blood_be2" value="{{@$sicu_chart->blood_be2}}"></td>
                                                        <td><input type="text" name="blood_be3" value="{{@$sicu_chart->blood_be3}}"></td>
                                                        <td><input type="text" name="blood_be4" value="{{@$sicu_chart->blood_be4}}"></td>
                                                        <td><input type="text" name="blood_be5" value="{{@$sicu_chart->blood_be5}}"></td>
                                                        <td><input type="text" name="blood_be6" value="{{@$sicu_chart->blood_be6}}"></td>
                                                        <td><input type="text" name="blood_be7" value="{{@$sicu_chart->blood_be7}}"></td>
                                                        <td><input type="text" name="blood_be8" value="{{@$sicu_chart->blood_be8}}"></td>
                                                        <td><input type="text" name="blood_be9" value="{{@$sicu_chart->blood_be9}}"></td>


                                                    </tr>

                                                    <tr>
                                                         <td>O2SAT</td>
                                                        <td><input type="text" name="blood_sat" value="{{@$sicu_chart->blood_sat}}"></td>
                                                        <td><input type="text" name="blood_sat2" value="{{@$sicu_chart->blood_sat2}}"></td>
                                                        <td><input type="text" name="blood_sat3" value="{{@$sicu_chart->blood_sat3}}"></td>
                                                        <td><input type="text" name="blood_sat4" value="{{@$sicu_chart->blood_sat4}}"></td>
                                                        <td><input type="text" name="blood_sat5" value="{{@$sicu_chart->blood_sat5}}"></td>
                                                        <td><input type="text" name="blood_sat6" value="{{@$sicu_chart->blood_sat6}}"></td>
                                                        <td><input type="text" name="blood_sat7" value="{{@$sicu_chart->blood_sat7}}"></td>
                                                        <td><input type="text" name="blood_sat8" value="{{@$sicu_chart->blood_sat8}}"></td>
                                                        <td><input type="text" name="blood_sat9" value="{{@$sicu_chart->blood_sat9}}"></td>

                                                    </tr>
                                                    <tr>
                                                         <td>Hb</td>
                                                        <td><input type="text" name="blood_hb" value="{{@$sicu_chart->blood_hb}}"></td>
                                                        <td><input type="text" name="blood_hb2" value="{{@$sicu_chart->blood_hb2}}"></td>
                                                        <td><input type="text" name="blood_hb3" value="{{@$sicu_chart->blood_hb3}}"></td>
                                                        <td><input type="text" name="blood_hb4" value="{{@$sicu_chart->blood_hb4}}"></td>
                                                        <td><input type="text" name="blood_hb5" value="{{@$sicu_chart->blood_hb5}}"></td>
                                                        <td><input type="text" name="blood_hb6" value="{{@$sicu_chart->blood_hb6}}"></td>
                                                        <td><input type="text" name="blood_hb7" value="{{@$sicu_chart->blood_hb7}}"></td>
                                                        <td><input type="text" name="blood_hb8" value="{{@$sicu_chart->blood_hb8}}"></td>
                                                        <td><input type="text" name="blood_hb9" value="{{@$sicu_chart->blood_hb9}}"></td>

                                                    </tr>
                                                    <tr>
                                                         <td>NA/CL</td>
                                                        <td><input type="text" name="blood_na" value="{{@$sicu_chart->blood_na}}"></td>
                                                        <td><input type="text" name="blood_na2" value="{{@$sicu_chart->blood_na2}}"></td>
                                                        <td><input type="text" name="blood_na3" value="{{@$sicu_chart->blood_na3}}"></td>
                                                        <td><input type="text" name="blood_na4" value="{{@$sicu_chart->blood_na4}}"></td>
                                                        <td><input type="text" name="blood_na5" value="{{@$sicu_chart->blood_na5}}"></td>
                                                        <td><input type="text" name="blood_na6" value="{{@$sicu_chart->blood_na6}}"></td>
                                                        <td><input type="text" name="blood_na7" value="{{@$sicu_chart->blood_na7}}"></td>
                                                        <td><input type="text" name="blood_na8" value="{{@$sicu_chart->blood_na8}}"></td>
                                                        <td><input type="text" name="blood_na9" value="{{@$sicu_chart->blood_na9}}"></td>

                                                    </tr>
                                                    <tr>
                                                        <td>K</td>
                                                        <td><input type="text" name="blood_k" value="{{@$sicu_chart->blood_k}}"></td>
                                                        <td><input type="text" name="blood_k2" value="{{@$sicu_chart->blood_k2}}"></td>
                                                        <td><input type="text" name="blood_k3" value="{{@$sicu_chart->blood_k3}}"></td>
                                                        <td><input type="text" name="blood_k4" value="{{@$sicu_chart->blood_k4}}"></td>
                                                        <td><input type="text" name="blood_k5" value="{{@$sicu_chart->blood_k5}}"></td>
                                                        <td><input type="text" name="blood_k6" value="{{@$sicu_chart->blood_k6}}"></td>
                                                        <td><input type="text" name="blood_k7" value="{{@$sicu_chart->blood_k7}}"></td>
                                                        <td><input type="text" name="blood_k8" value="{{@$sicu_chart->blood_k8}}"></td>
                                                        <td><input type="text" name="blood_k9" value="{{@$sicu_chart->blood_k9}}"></td>


                                                    </tr>
                                                    <tr>
                                                         <td>SUGAR</td>
                                                        <td><input type="text" name="blood_sugar" value="{{@$sicu_chart->blood_sugar}}"></td>
                                                        <td><input type="text" name="blood_sugar2" value="{{@$sicu_chart->blood_sugar2}}"></td>
                                                        <td><input type="text" name="blood_sugar3" value="{{@$sicu_chart->blood_sugar3}}"></td>
                                                        <td><input type="text" name="blood_sugar4" value="{{@$sicu_chart->blood_sugar4}}"></td>
                                                        <td><input type="text" name="blood_sugar5" value="{{@$sicu_chart->blood_sugar5}}"></td>
                                                        <td><input type="text" name="blood_sugar6" value="{{@$sicu_chart->blood_sugar6}}"></td>
                                                        <td><input type="text" name="blood_sugar7" value="{{@$sicu_chart->blood_sugar7}}"></td>
                                                        <td><input type="text" name="blood_sugar8" value="{{@$sicu_chart->blood_sugar8}}"></td>
                                                        <td><input type="text" name="blood_sugar9" value="{{@$sicu_chart->blood_sugar9}}"></td>
                                                        <td colspan="2"><input type="text" name="sign" id="sign" class="form-control" placeholder="Signature" value="{{@$sicu_chart->sign}}">
                                                        <input type="hidden" name="h_sign" value="h_sign"></td>

                                                    </tr>


                                                </tbody>

                                            </table>


                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('sicu-investigation-chart', [
                                                    'patient_no_fk' => $patient_no_fk,
                                                    'admission_id' => $admission_id,
                                                ]);
                                            @endphp

                                            <button type="submit" class="btn btn-success btn-lg m-3 float-right"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $redirect_url }}')">Save</button>
                                        </div>


                                    </form>
                                </div>
                            </div>

                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>



<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#sign', 'h_sign', 'employee_ind', '1');
</script>
