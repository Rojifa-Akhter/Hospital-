<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<style>
    .sorting {
        background-image: none !important;
    }

    .table th,
    .table td {
        padding: 5px;
        vertical-align: text-top;
    }

    input {
        outline: none;
        border: none;
    }
</style>

<section id="report_section">
    <div class="container-fluid p-20">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Medical Examination Report</h5>
                <small>Pathology / Medical Examination Report</small>
            </div>
        </div>

        <div class="text-center">
            <div class="w-20">
                <form id="frmFinancialSearch" method="post" action="" target="_blank">
                    @csrf

                    <table>
                        <tr>

                            <td>Invoice ID <input type="text" class="form-control " name="invoice_id" id="invoice_id"
                                    autocomlete="off" placeholder="Invoice ID" />
                            </td>
                            <td>
                                <button type="button" id="finc_report_search"
                                    class="btn btn-md btn-success  mt-4">Search</button>

                            </td>
                        </tr>
                    </table>

                    {{-- <label for="invoice_id">Invoice ID</label>
                    <input type="text" class="form-control " name="invoice_id" id="invoice_id" autocomlete="off"
                        placeholder="Invoice ID" />

                    <button type="button" id="finc_report_search"
                        class="btn btn-sm btn-success form-control mt-4">Search</button> --}}
                </form>

            </div>

        </div>


        <form id="medicalExamination" method="post" action="{{ route('medical-examination-report-store') }}"
           >
            @csrf

            <div class="card">
                <div class="card-header ">
                    <h5><i class="fa fa-search"></i>Patient Information</h5>
                </div>
                <div class="card-body pt-2 bg-light">
                    <div class="col-md-12 medical_examination_pat_info">
                        @include('admin.pathology.medical_examination_pat_info')
                    </div>

                </div>

            </div>

            <div class="card">
                <div class="card-header ">
                    <h5>Patient History / Test</h5>
                </div>
                <div class="card-body">
                    <div class="mt-2" id="">
                        {{-- <form action="" method="post" id="medicalExm"> --}}

                        {{-- <form method="post" id="medicalExm" action="{{ route('medical-examination-report-store') }}"
                            enctype="multipart/form-data">
                            @csrf --}}
                            <table width="100%" class="table">
                                <tr>
                                    <td style="">
                                        <table width="100%" border="1">
                                            <tr>
                                                <th>SL</th>
                                                <th>Name</th>
                                                <th>Yes</th>
                                                <th style="text-align: center">If yes, give brief details</th>
                                            </tr>
                                            <tr>
                                                <td style="width:10px">1</td>
                                                <td style="width:200px"><input type="hidden" name="mental_illness_yes"
                                                        value="Mental illness"> Mental illness</td>
                                                <td style="width:15px"><input type="checkbox"
                                                        name="mental_illness_yes_ind" id="mental_illness_yes_ind"
                                                        onclick="deasis_yes(this)" value="1">
                                                </td>
                                                <td style=""><input type="text" style="width: 100%"
                                                        placeholder="Write here..." class="d-none "
                                                        name="mental_illness_brief" id="mental_illness_brief"></td>

                                            </tr>
                                            <tr>
                                                <td style="width:10px">2</td>
                                                <td style="width:200px"> <input type="hidden" name="epilepsy_yes"
                                                        value="Epilepsy"> Epilepsy</td>
                                                <td style="width:15px"><input type="checkbox" name="epilepsy_yes_ind"
                                                        id="epilepsy_yes_ind" onclick="deasis_yes(this)" value="1">
                                                </td>
                                                <td style=""><input type="text" tyle="width: 100%"
                                                        placeholder="Write here..." class="d-none "
                                                        name="epilepsy_yes_brief" id="epilepsy_yes_brief"></td>

                                            </tr>
                                            <tr>
                                                <td style="width:10px">3</td>
                                                <td style="width:200px"> <input type="hidden" name="chronic_asthma_yes"
                                                        value="Chronic Asthma"> Chronic Asthma</td>
                                                <td style="width:15px"><input type="checkbox"
                                                        name="chronic_asthma_yes_ind" id="chronic_asthma_yes_ind"
                                                        onclick="deasis_yes(this)" value="1">
                                                </td>
                                                <td style=""><input type="text" tyle="width: 100%"
                                                        placeholder="Write here..." class="d-none "
                                                        name="chronic_asthma_yes_brief" id="chronic_asthma_yes_brief">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td style="width:10px">4</td>
                                                <td style="width:200px"> <input type="hidden"
                                                        name="diabetes_mellitus_yes" value="Diabetes Mellitus">
                                                    Diabetes Mellitus</td>
                                                <td style="width:15px"><input type="checkbox"
                                                        name="diabetes_mellitus_yes_ind"
                                                        id="diabetes_mellitus_yes_ind" onclick="deasis_yes(this)"
                                                        value="1">
                                                </td>
                                                <td style=""><input type="text" tyle="width: 100%"
                                                        placeholder="Write here..." class="d-none "
                                                        name="diabetes_mellitus_yes_brief"
                                                        id="diabetes_mellitus_yes_brief">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td style="width:10px">5</td>
                                                <td style="width:200px"> <input type="hidden"
                                                        name="hypertension_yes" value="Hypertension"> Hypertension
                                                </td>
                                                <td style="width:15px"><input type="checkbox"
                                                        name="hypertension_yes_ind" id="hypertension_yes_ind"
                                                        onclick="deasis_yes(this)" value="1">
                                                </td>
                                                <td style=""><input type="text" tyle="width: 100%"
                                                        placeholder="Write here..." class="d-none "
                                                        name="hypertension_yes_brief" id="hypertension_yes_brief">
                                                </td>

                                            </tr>
                                        </table>
                                    </td>
                                    <td>
                                        <table width="100%" border="1">
                                            <tr>
                                                <th>SL</th>
                                                <th>Name</th>
                                                <th>Yes</th>
                                                <th style="text-align: center">If yes, give brief details</th>
                                            </tr>
                                            <tr>
                                                <td style="width:10px">6</td>
                                                <td style="width:200px"> <input type="hidden"
                                                        name="tuberculosis_yes" value="Tuberculosis"> Tuberculosis
                                                </td>
                                                <td style="width:15px"><input type="checkbox"
                                                        name="tuberculosis_yes_ind" id="tuberculosis_yes_ind"
                                                        onclick="deasis_yes(this)" value="1">
                                                </td>
                                                <td style=""><input type="text" tyle="width: 100%"
                                                        placeholder="Write here..." class="d-none "
                                                        name="tuberculosis_yes_brief" id="tuberculosis_yes_brief">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td style="width:10px">7</td>
                                                <td style="width:200px"> <input type="hidden"
                                                        name="heart_disease_yes" value="Heart Disease"> Heart Disease
                                                </td>
                                                <td style="width:15px"><input type="checkbox"
                                                        name="heart_disease_yes_ind" id="heart_disease_yes_ind"
                                                        onclick="deasis_yes(this)" value="1">
                                                </td>
                                                <td style=""><input type="text" tyle="width: 100%"
                                                        placeholder="Write here..." class="d-none "
                                                        name="heart_disease_yes_brief" id="heart_disease_yes_brief">
                                                </td>

                                            </tr>
                                            <tr>
                                                <td style="width:10px">8</td>
                                                <td style="width:200px"> <input type="hidden" name="malaria_yes"
                                                        value="Malaria"> Malaria</td>
                                                <td style="width:15px"><input type="checkbox" name="malaria_yes_ind"
                                                        id="malaria_yes_ind" onclick="deasis_yes(this)"
                                                        value="1"></td>
                                                <td style=""><input type="text" tyle="width: 100%"
                                                        placeholder="Write here..." class="d-none "
                                                        name="malaria_yes_brief" id="malaria_yes_brief"></td>

                                            </tr>
                                            <tr>
                                                <td style="width:10px">9</td>
                                                <td style="width:200px"> <input type="hidden" name="operations_yes"
                                                        value="Operations"> Operations</td>
                                                <td style="width:15px"><input type="checkbox"
                                                        name="operations_yes_ind" id="operations_yes_ind"
                                                        onclick="deasis_yes(this)" value="1">
                                                </td>
                                                <td style=""><input type="text" tyle="width: 100%"
                                                        placeholder="Write here..." class="d-none "
                                                        name="operations_yes_brief" id="operations_yes_brief"></td>

                                            </tr>
                                        </table>

                                    </td>
                                </tr>
                            </table>
                        {{-- </form> --}}
                    </div>
                </div>
            </div>


            <div class="card">
                <div class="card-header ">
                    <h5>Examinations / Test</h5>
                </div>
                <div class="card-body">
                    <h2>Clinical Examination</h2>
                    <table width="100%" border="1" class="table">
                        <tr>
                            <th style="width: 20px">SL</th>
                            <th>Clinical Examination</th>
                            <th style="width: 20px">Abnormal</th>
                        </tr>
                        <tr>
                            <td> <strong> 1 </strong><br>a</td>
                            <td>
                                <strong> Cardiovascular System</strong><br>
                                <input type="hidden" name="bp_result" value="Blood Pressure"> Blood Pressure <br>
                                Systolic : <br>
                                Diastolic :
                            </td>
                            <td class="text-center"><input type="checkbox" name="bp_result_ind" id="bp_result_ind">
                            </td>
                        </tr>
                        <tr>
                            <td>b</td>
                            <td>
                                <input type="hidden" name="heart_disease_result" value="Heart Disease">
                                Heart Disease
                            </td>
                            <td class="text-center"><input type="checkbox" name="heart_disease_result_ind"
                                    id="heart_disease_result_ind"> </td>
                        </tr>
                        <tr>
                            <td>c</td>
                            <td>
                                <input type="hidden" name="ecg_result"
                                    value="ECG ( compulsory for male Thai workers & others above age 50, and in younger applicants
                            where it
                            is indicated, e.g. persons with cardic murmurs or symptoms suggestive of Myocardial
                            ischaemia)">
                                ECG ( compulsory for male Thai workers & others above age 50, and in younger applicants
                                where it
                                is indicated, e.g. persons with cardic murmurs or symptoms suggestive of Myocardial
                                ischaemia)
                            </td>
                            <td class="text-center"><input type="checkbox" name="ecg_result_ind"
                                    id="ecg_result_ind"> </td>
                        </tr>
                        <tr>
                            <td>d</td>
                            <td> <input type="hidden" name="severe_varicose_result" value="Servere varicose veins">
                                Servere varicose veins</td>
                            <td class="text-center"><input type="checkbox" name="severe_varicose_result_ind"
                                    id="severe_varicose_result_ind"> </td>
                        </tr>
                        <tr>
                            <td> <strong> 2</strong></td>
                            <td> <input type="hidden" name="anaemia_result"
                                    value="Anaemia (if clinically anaemic) do HB:"> Anaemia (if clinically anaemic) do
                                HB: <input type="text" class="" name="anaemia_text" id="anaemia_text"
                                    placeholder="Write here..."> g%</td>
                            <td class="text-center"><input type="checkbox" name="anaemia_result_ind"
                                    id="anaemia_result_ind">
                            </td>
                        </tr>
                        <tr>
                            <td> <strong> 3</strong></td>
                            <td> <input type="hidden" name=respiratory_result"" value="Respiratory System">
                                Respiratory System</td>
                            <td class="text-center"><input type="checkbox" name="respiratory_result_ind"
                                    id="respiratory_result_ind"> </td>
                        </tr>
                        <tr>
                            <td> <strong> 4 </strong> <br> a </td>
                            <td>
                                <strong>Abdomen</strong><br>
                                <input type="hidden" name="hernia_result" value="Hernia"> Hernia

                            </td>
                            <td class="text-center"><input type="checkbox" name="hernia_result_ind"
                                    id="hernia_result_ind">
                            </td>
                        </tr>
                        <tr>
                            <td>b</td>
                            <td> <input type="hidden" name="enlarger_liver_result" value="Enlarged Liver"> Enlarged
                                Liver </td>
                            <td class="text-center"><input type="checkbox" name="enlarger_liver_result_ind"
                                    id="enlarger_liver_result_ind"> </td>
                        </tr>
                        <tr>
                            <td>c</td>
                            <td> <input type="hidden" name="enlarged_spleen_result" value="Enlarged Spleen">
                                Enlarged Spleen</td>
                            <td class="text-center"><input type="checkbox" name="enlarged_spleen_result_ind"
                                    id="enlarged_spleen_result_ind"> </td>
                        </tr>
                        <tr>
                            <td>d</td>
                            <td> <input type="hidden" name="genito_urinary_result" value="Genito-Urinary System">
                                Genito-Urinary System</td>
                            <td class="text-center"><input type="checkbox" name="genito_urinary_result_ind"
                                    id="genito_urinary_result_ind"> </td>
                        </tr>
                        <tr>
                            <td> <strong> 5</strong></td>
                            <td> <input type="hidden" name="skin_chronic_result"
                                    value="Skin-Chronic Disease (e.g. leprosy, widespread eczema , psoriasis, etc)">
                                Skin-Chronic Disease (e.g. leprosy, widespread eczema , psoriasis, etc)</td>
                            <td class="text-center"><input type="checkbox" name="skin_chronic_result_ind"
                                    id="skin_chronic_result_ind"> </td>
                        </tr>
                        <tr>
                            <td><strong> 6 </strong> <br>a</td>
                            <td>
                                <strong>Locomotor/Neurological</strong> <br>
                                <input type="hidden" name="significant_limb_result"
                                    value="Significant limb amputation ori deformity"> Significant limb amputation ori
                                deformity
                            </td>
                            <td class="text-center"><input type="checkbox" name="significant_limb_result_ind"
                                    id="significant_limb_result_ind"> </td>
                        </tr>
                        <tr>
                            <td>b</td>
                            <td> <input type="hidden" name="limb_movement_result"
                                    value="Limb movement and co-ordination"> Limb movement and co-ordination </td>
                            <td class="text-center"><input type="checkbox" name="limb_movement_result_ind"
                                    id="limb_movement_result_ind"> </td>
                        </tr>
                        <tr>
                            <td>c</td>
                            <td> <input type="hidden" name="significant_spinal_result"
                                    value="Significant spinal deformity."> Significant spinal deformity. </td>
                            <td class="text-center"><input type="checkbox" name="significant_spinal_result_ind"
                                    id="significant_spinal_result_ind"> </td>
                        </tr>
                        <tr>
                            <td>d</td>
                            <td> <input type="hidden" name="singificant_abnormalitis_result"
                                    value="Other significant abnormalities (in relation to the work required to be performed)">
                                Other significant abnormalities (in relation to the work required to be performed) </td>
                            <td class="text-center"><input type="checkbox" name="singificant_abnormalitis_result_ind"
                                    id="singificant_abnormalitis_result_ind"> </td>
                        </tr>
                        <tr>
                            <td> <strong> 7 </strong></td>
                            <td> <input type="hidden" name="e ndocrine_disorders_result"
                                    value="Endocrine disorders, e.g. thyrotoxicosis"> Endocrine disorders, e.g.
                                thyrotoxicosis</td>
                            <td class="text-center"><input type="checkbox" name="e ndocrine_disorders_result_ind"
                                    id="e ndocrine_disorders_result_ind"> </td>
                        </tr>
                        <tr>
                            <td> <strong> 8 </strong></td>
                            <td> <input type="hidden" name="mental_state_result" value="Mental state"> Mental state
                            </td>
                            <td class="text-center"><input type="checkbox" name="mental_state_result_ind"
                                    id="mental_state_result_ind"> </td>
                        </tr>
                    </table>
                    <h2>Others Test</h2>
                    <table width="100%" border="1" style="margin-top: 20px" class="table">
                        <tr>
                            <th style="width: 20px">SL</th>
                            <th>Others Test</th>
                            <th style="width: 20px">Abnormal</th>
                        </tr>
                        <tr>
                            <td> <strong> 1 </strong><br>a</td>
                            <td>
                                <input type="hidden" name="chest_x_ray"
                                    value="Chest X-ray - to be taken in Singapore (*For any abnormalities and other findings
                            including no active lung lesion, please state here and attach the chest radiological
                            report
                            to this form.)">
                                <strong> Chest X-ray - to be taken in Singapore (*For any abnormalities and other
                                    findings
                                    including no active lung lesion, please state here and attach the chest radiological
                                    report
                                    to this form.)</strong><br>
                            </td>
                            <td class="text-center"><input type="checkbox" name="chest_x_ray_ind"
                                    id="chest_x_ray_ind"> </td>
                        </tr>
                        <tr>
                            <td> <strong> 2 </strong></td>
                            <td>
                                <input type="hidden" name="hbsag" value="HBsAg"> HBsAg
                            </td>
                            <td class="text-center"><input type="checkbox" name="hbsag_ind" id="hbsag_ind"> </td>
                        </tr>
                        <tr>
                            <td> <strong> 3</strong></td>
                            <td>
                                <input type="hidden" name="ecg" value="ECG"> ECG
                            </td>
                            <td class="text-center"><input type="checkbox" name="ecg_ind" id="ecg_ind"> </td>
                        </tr>
                        <tr>
                            <td> <strong> 4 </strong></td>
                            <td> <input type="hidden" name="urine" value="Urine"> Urine</td>
                            <td class="text-center"><input type="checkbox" name="urine_ind" id="urine_ind"> </td>
                        </tr>
                        <tr>
                            <td> a </td>
                            <td> <input type="hidden" name="albumin" value="Albumin"> Albumin</td>
                            <td class="text-center"><input type="checkbox" name="albumin_ind" id="albumin_ind">
                            </td>
                        </tr>
                        <tr>
                            <td> b</td>
                            <td> <input type="hidden" name="sugar" value="Sugar"> Sugar</td>
                            <td class="text-center"><input type="checkbox" name="sugar_ind" id="sugar_ind"> </td>
                        </tr>
                        <tr>
                            <td> c </td>
                            <td>
                                <strong> <input type="hidden" name="pregnancy" value="Pregnancy"> Pregnancy</strong>


                            </td>
                            <td class="text-center"><input type="checkbox" name="pregnancy_ind" id="pregnancy_ind">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>5</strong></td>
                            <td> <input type="hidden" name="vdrl" value="VDRL"> VDRL </td>
                            <td class="text-center"><input type="checkbox" name="vdrl_ind" id="vdrl_ind"> </td>
                        </tr>
                        <tr>
                            <td><strong>6</strong></td>
                            <td> <input type="hidden" name="hearing_unable"
                                    value="Hearing - unable to hear ordinary conversation at 2m"> Hearing - unable to
                                hear ordinary conversation at 2m</td>
                            <td class="text-center"><input type="checkbox" name="hearing_unable_ind"
                                    id="hearing_unable_ind">
                            </td>
                        </tr>
                        <tr>
                            <td><strong>7</strong></td>
                            <td> <input type="hidden" name="vision"
                                    value="Vision (should be at least 6/12 in both eyes with or without glasses)">
                                Vision (should be at least 6/12 in both eyes with or without glasses)</td>
                            <td class="text-center"><input type="checkbox" name="vision_ind" id="vision_ind"> </td>
                        </tr>
                        <tr>
                            <td> a</td>
                            <td> <input type="hidden" name="vision_acuity" value="Vision Acuity"> Vision Acuity</td>
                            <td class="text-center"><input type="checkbox" name="vision_acuity_ind"
                                    id="vision_acuity_ind">
                            </td>
                        </tr>
                        <tr>
                            <td>i</td>
                            <td>
                                <input type="hidden" name="right_eye" value="Right eye"> Right eye
                            </td>
                            <td class="text-center"><input type="checkbox" name="right_eye_ind" id="right_eye_ind">
                            </td>
                        </tr>
                        <tr>
                            <td>ii</td>
                            <td> <input type="hidden" name="left_eye" value="Left eye"> Left eye</td>
                            <td class="text-center"><input type="checkbox" name="left_eye_ind" id="left_eye_ind">
                            </td>
                        </tr>
                        <tr>
                            <td>b</td>
                            <td> <input type="hidden" name="color_vision"
                                    value="Color Vision (for electricians & drivers only)"> Color Vision (for
                                electricians & drivers only) </td>
                            <td class="text-center"><input type="checkbox" name="color_vision_ind"
                                    id="color_vision_ind"> </td>
                        </tr>
                        <tr>
                            <td>c</td>
                            <td> <input type="hidden" name="any_organic_eye_disease"
                                    value="Any organic eye disease, e.g. Trachoma"> Any organic eye disease, e.g.
                                Trachoma </td>
                            <td class="text-center"><input type="checkbox" name="any_organic_eye_disease_ind"
                                    id="any_organic_eye_disease_ind"> </td>
                        </tr>
                        <tr>
                            <td> <strong> 9 </strong></td>
                            <td> <input type="hidden" name="hiv" value="HIV (AIDS)"> HIV (AIDS)</td>
                            <td class="text-center"><input type="checkbox" name="hiv_inv" id="hiv_inv"> </td>
                        </tr>

                    </table>
                </div>
                <div class="cord">
                    <div class="card-header">
                        <div>Dortor Information</div>
                        <div class="card-body">
                            <input type="text" class="form-control" id="doctor_code" name="doctor_name"
                                placeholder="Code/Name/Mobile/SPL."
                                title="Search by Code/ Name/ Mobile/ Specialization">
                            <input type="hidden" class="form-control" id="hdn_doctor_id" name="hdn_doctor_id"
                                value="">
                        </div>
                    </div>
                </div>

            </div>
            <div class="float-right mb-4">
                {{-- <button type="submit" class="btn btn-success m-10">Save</button> --}}

                @php
                    $response_url = url('medical-examination-report');
                @endphp
                <button class="btn btn-md btn-success" id="save_update" data-func=""
                    data-response-url="{{ $response_url }}"
                    title="Click here to save Medical Examination Information">Save</button>
                <button type="button" class="btn btn-md btn-danger " data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-md btn-info " data-dismiss="modal">Exit</button>
            </div>

        </form>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1,2');

    function deasis_yes(element) {
        if ($(element).is(':checked')) {
            $(element).closest('td').next('td').find('input').removeClass('d-none');
        } else {
            $(element).closest('td').next('td').find('input').addClass('d-none');
        }
    }
    openInvoiceAutocomplete("#invoice_id");


    // $('.select2').select2();
    // 	$(document).ready(function () {
    //         $(function() {
    //             $('.date_picker').datepicker({
    //                 todayHighlight: true,
    //                 format: 'dd-mm-yyyy',
    //                 clearBtn: true,
    //                 autoclose: true,
    //                 endDate: '+0d',
    //             });
    //         });

    // 		$("#sidebar-left").addClass("active");
    // 		$("#content").addClass("active");

    // 		openPatientAutocomplete('#patient_id');
    // 		openInvoiceAutocomplete('#invoice_id');
    // 		openDoctorAutocomplete('#first_referral', 'hdn_first_referral_id', 'Y');




    $(document).on("click", "#finc_report_search", function(e) {
        if ($('#invoice_id').val() == "") {
            alert('Please Enter Invoice No');
            return;
        }
        var formID = $("#frmFinancialSearch").attr("id");
        var formMethod = $("#frmFinancialSearch").attr("method");
        // $("#frmFinancialSearch").attr('action',"{{ url('pharmacy/financial-list') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('madical-examination-pat-info') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $('.date_picker').datepicker({
                    todayHighlight: true,
                    format: 'dd-mm-yyyy',
                    // clearBtn: true,
                    // autoclose: true,
                    // endDate: '+0d',
                });
                $(".medical_examination_pat_info").html(data);
                console.log(data);
                // $("#frmFinancialSearch").attr('action',"{{ route('report.pharmacy-invoice-print') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });


    // });
</script>
