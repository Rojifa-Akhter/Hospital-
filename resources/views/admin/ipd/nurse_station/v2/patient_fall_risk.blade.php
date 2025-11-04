
<style>

    .custom-form{
        width:100%;
        border:none;
        outline: none;
    }
    .border-left-0{
        border-left:none !important;
    }
    .border-right-0{
        border-right:none !important;
    }
    .medicine_thead{
        background-color: #e1e1e5;
    }
    .w-15{
        width:15%;
    }
    .w-25{
        width:25%;
    }
    .w-8{
        width:8%;
    }
    .w-6{
        width:6%;
    }
    .w-16{
        width:16%;
    }
    .remove_row{
        cursor: pointer;
        background-color: white;
    }
    .fa-star{
        display:none;
    }
    thead {
        position: sticky;
        top: 0px;
        left:0px;
        right:0px;
        background-color: white;
    }
    .fs-12{
        font-size: 14px;
    }
    .pdf-icon{
        font-size: 22px;
        color: red
    }
</style>

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">Modified Morse Fall Risk</h5>
                            <small>IPD / Nurse Station / Modified Morse Fall Risk</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank" href="{{route('v2.ipd.download-fall-risk',[$patient_info->patient_no_pk, $patient_info->admission_no_pk])}}">PDF Export</a>
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
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Patient Name: {{ @$patient_info->patient_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">UHID: {{ @$patient_info->patient_code }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No: {{ @$patient_info->admission_uid }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date: {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Department: {{ $patient_info->admitted_department }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Category: {{ $patient_info->ward_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.: {{ $patient_info->bed_name }}</span>
                                </div>
                                <div class="col-md-12">
                                    <form action="" method="post" id="assesmentForm">
                                        @csrf

                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left border-right-0" style="width:50%">PARAMETERS</th>
                                                            <th class="text-left border-left-0" style="width: 30%">SCALE</th>
                                                            <th class="text-center border-left-0" style="width:20%">CORE</th>

                                                        </tr>
                                                    </thead>

                                                    <tbody>
             

                                                        <tr>
                                                            <td class="text-left">History of fall(immediate/within 3 months)
                                                                <input type="hidden" class="custom-form" id="patient_no_fk" name="patient_no_fk" value="{{@$patient_info->patient_no_pk}}">
                                                                <input type="hidden" class="custom-form" id="admission_no_fk" name="admission_no_fk" value="{{@$patient_info->admission_no_pk}}">
                                                            </td>
                                                            <td class="text-center">
                                                                <select class="custom-form dropdown_value" name="his_fall" id="his_fall" onchange="changeFalRisk(this.value, 'his_fall_text')">
                                                                    <option value="" selected>select one</option>
                                                                    <option value="0" {{ @$data->his_fall == 0 ? 'selected' : ''}}>No</option>
                                                                    <option value="25" {{ @$data->his_fall == 25 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                            <td class="text-center"><span id="his_fall_text">{{@$data->his_fall}}</span></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-left">Age > 65 years /</td>
                                                            <td class="text-center">
                                                                <select class="custom-form dropdown_value" name="age" id="age"  onchange="changeFalRisk(this.value, 'age_text')">
                                                                    <option value="" selected>select one</option>
                                                                    <option value="0" {{ @$data->age == 0 ? 'selected' : ''}}>No</option>
                                                                    <option value="15" {{ @$data->age == 15 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                            <td class="text-center"><span id="age_text">{{@$data->age}}</span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-left">Secondary diagnosis (if more than one diagnosis)</td>
                                                            <td class="text-center">
                                                                <select class="custom-form dropdown_value" name="sec_diagnosis" id="sec_diagnosis"  onchange="changeFalRisk(this.value, 'sec_diagnosis_text')">
                                                                    <option value="" selected>select one</option>
                                                                    <option value="0" {{ @$data->sec_diagnosis == 0 ? 'selected' : ''}}>No</option>
                                                                    <option value="15" {{ @$data->sec_diagnosis == 15 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                            <td class="text-center"><span id="sec_diagnosis_text">{{@$data->sec_diagnosis}}</span></td>
                                                        </tr>

                                                        <tr>
                                                            
                                                            <td class="text-left">Ambulatory aids</td>
                                                            <td class="text-center">
                                                                <select class="custom-form dropdown_value" name="ambulatory_aids" id="ambulatory_aids"  onchange="changeFalRisk(this.value, 'ambulatory_aids_text')">
                                                                    <option value="" selected>select one</option>
                                                                    <option value="30" {{ @$data->ambulatory_aids == 30 ? 'selected' : ''}}>Furniture</option>
                                                                    <option value="15" {{ @$data->ambulatory_aids == 15 ? 'selected' : ''}}>Crutches/cane/Walker</option>
                                                                    <option value="0" {{ @$data->ambulatory_aids == 0 &&  @$data->ambulatory_aids != null ? 'selected' : ''}}>None/Bed Rest/nurse assist</option>
                                                                </select>
                                                            </td>
                                                            <td class="text-center"><span id="ambulatory_aids_text">{{@$data->ambulatory_aids}}</span></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-left">Invasive Lines-Peripheral/central</td>
                                                            <td class="text-center">
                                                                <select class="custom-form dropdown_value" name="invasive_lines" id="invasive_lines"  onchange="changeFalRisk(this.value, 'invasive_lines_text')">
                                                                    <option value="" selected>select one</option>
                                                                    <option value="0" {{ @$data->invasive_lines == 0 ? 'selected' : ''}}>No</option>
                                                                    <option value="20" {{ @$data->invasive_lines == 20 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                            <td class="text-center"><span id="invasive_lines_text">{{@$data->invasive_lines}}</span></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-left">Gait/Transferring</td>
                                                            <td class="text-center">
                                                                <select class="custom-form dropdown_value" name="gaint" id="gaint"  onchange="changeFalRisk(this.value, 'gaint_text')">
                                                                    <option value="" selected>select one</option>
                                                                    <option value="20" {{ @$data->gaint == 20 ? 'selected' : ''}}>Impaired</option>
                                                                    <option value="10" {{ @$data->gaint == 10 ? 'selected' : ''}}>Weak</option>
                                                                    <option value="0" {{ @$data->gaint == 0 ? 'selected' : ''}}>Normal/Bed rest/immobile</option>
                                                                </select>
                                                            </td>
                                                            <td class="text-center"><span id="gaint_text">{{@$data->gaint}}</span></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-left">Mental/Neurological status</td>
                                                            <td class="text-center">
                                                                <select class="custom-form dropdown_value" name="memtal" id="memtal"  onchange="changeFalRisk(this.value, 'memtal_text')">
                                                                    
                                                                    <option value="" selected>select one</option>

                                                                    <option value="20" {{ @$data->memtal == 20 ? 'selected' : ''}}>Impaired vision/Impaired hearing</option>
                                                                    {{-- <option value="15" {{ @$data->memtal == 15 ? 'selected' : ''}}>Dizziness/Vertigo</option> --}}
                                                                    <option value="15" {{ @$data->memtal == 15 ? 'selected' : ''}}>Forget limitations/ Dizziness/ Vertigo</option>
                                                                    <option value="0" {{ @$data->memtal == 0 ? 'selected' : ''}}>Oriented to own ability</option>
                                                                </select>
                                                            </td>
                                                            <td class="text-center"><span id="memtal_text">{{@$data->memtal}}</span></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-left">
                                                                <b>Medication Use</b>
                                                                Antihypertensive/hypoglycemic/

                                                                agents/Diuretics/

                                                                anticonvulsants/psychotropic/

                                                                antianxiety/narcotics/2hr post

                                                                sedation/Anesthesia
                                                            </td>
                                                            <td class="text-center">
                                                                <select class="custom-form dropdown_value" name="medication_use" id="medication_use" onchange="changeFalRisk(this.value, 'medication_use_text')">
                                                                    <option value="0" {{ @$data->medication_use == 0 ? 'selected' : ''}}>No</option>
                                                                    <option value="25" {{ @$data->medication_use == 25 ? 'selected' : ''}}>Yes</option>
                                                                </select>
                                                            </td>
                                                            <td class="text-center"><span id="medication_use_text">{{@$data->medication_use }}</span></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-right" colspan="2"><b>TOTAL SCORE</b></td>
                                                            <td>
                                                                <span id="total_score"></span>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-left" colspan="3"><b>Fall prevention measures</b></td>
                                                            <td class="text-center"><span id="his_fall_text"></span></td>
                                                        </tr>
                                                        @php
                                                            $selectedValues = explode(',',$data->ipd_fall_preven_measures ?? '');
                                                        @endphp
                                                        <tr>
                                                            <td class="text-left" colspan="3">
                                                                <div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="fall_prevention" value="1" name="fall_prevention[]" {{ in_array(1, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="fall_prevention">Patient and family education on fall prevention		

                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="discuss_demonstrate" value="2" name="fall_prevention[]" {{ in_array(2, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="discuss_demonstrate">Discuss, demonstrate the use of call bell and keep the call bell within reach
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="keep_rails" value="3" name="fall_prevention[]" {{ in_array(3, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="keep_rails">Keep the side rails up and instruct the patient not to climb over or between the rails.
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="keep_bed" value="4" name="fall_prevention[]" {{ in_array(4, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="keep_bed">Keep bed wheels locked and in low position.
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="instruct_patient" value="5" name="fall_prevention[]" {{ in_array(5, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="instruct_patient">Instruct the patient about the use of grab bar and call bell in the toilet.
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="provide_adequate" value="6" name="fall_prevention[]" {{ in_array(6, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="provide_adequate">Provide adequate lighting
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="patient_unattended" value="7" name="fall_prevention[]" {{ in_array(7, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="patient_unattended">Don’t leave the patient unattended
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="while_transferring" value="8" name="fall_prevention[]" {{ in_array(8, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="while_transferring">While transferring, ensure the wheels of the stretcher/wheelchair are locked and safety belts are put on.
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="instruct_patient_get" value="9" name="fall_prevention[]" {{ in_array(9, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="instruct_patient_get">Instruct the patient to get up slowly and sit for a while. if you feel dizziness or weak, call for help
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="instruct_patient_hold" value="10" name="fall_prevention[]" {{ in_array(10, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="instruct_patient_hold">Instruct the patient not to hold cardiac table for support, as it is on wheels
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="instruct_patient_inform" value="11" name="fall_prevention[]" {{ in_array(11, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="instruct_patient_inform">Instruct the patient to inform staff, if any spill happens for immediate cleaning.	
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="Keep_floor_neat" value="12" name="fall_prevention[]" {{ in_array(12, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="Keep_floor_neat">Keep the floor neat, clean and hazard free	
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div id="low_risk" style="display: none">
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="keep_items" value="13" name="fall_prevention[]" {{ in_array(13, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="keep_items"> Keep the items within easy reach. eg : water, phone, spectacles etc.
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="Instruct_bed" value="14" name="fall_prevention[]" {{ in_array(14, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="Instruct_bed">Instruct the patient to call for help, if you want to get in or out of bed 
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="instruct_barefoot" value="15" name="fall_prevention[]" {{ in_array(15, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="instruct_barefoot"> Instruct not to walk in barefoot and wear appropriate size slippers /shoes with non -skid soles
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="accompany" value="16" name="fall_prevention[]" {{ in_array(16, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="accompany">Accompany the patient to the bathroom /toilet and keep the door unlocked.				
                                                                        </label>
                                                                    </div> 
                                                                </div>
                                                                <div id="high_risk" style="display: none">
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="possible_allot" value="17" name="fall_prevention[]" {{ in_array(17, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="possible_allot"> If possible, allot the room/bed near to the nurse’s station	
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="frequent_observation" value="18" name="fall_prevention[]" {{ in_array(18, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="frequent_observation">Frequent observation of the patient	
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="patient_high_risk" value="19" name="fall_prevention[]" {{ in_array(19, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="patient_high_risk">If patient is getting any high-risk medication or after any procedure, instruct the patient not to get up alone.			
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="patient_agitated" value="20" name="fall_prevention[]" {{ in_array(20, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="patient_agitated">If the patient is agitated, can be put on restraint with doctor’s order.	
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="restrict_patient" value="21" name="fall_prevention[]" {{ in_array(21, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="restrict_patient"> Restrict the patient movement to toilet by offering bed pan/urinal.		
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                                <div id="no_risk" style="display: none">
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="call_needed" value="22" name="fall_prevention[]" {{ in_array(22, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="call_needed">Call for help if needed.
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="assist_comfortable" value="23" name="fall_prevention[]" {{ in_array(23, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="assist_comfortable">Assist the patient back to bed and make the patient comfortable.	
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="inspect_consciousness" value="24" name="fall_prevention[]" {{ in_array(24, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="inspect_consciousness">Inspect for injury and reassess the patient’s vital signs and level of consciousness.
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="patient_high_risk" value="25" name="fall_prevention[]" {{ in_array(25, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="patient_high_risk">Inform the doctor simultaneously and carry out order as per doctors’ instructions	
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="fill_up" value="26" name="fall_prevention[]" {{ in_array(26, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="fill_up">Fill up an incident form.
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="reassess" value="27" name="fall_prevention[]" {{ in_array(27, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="reassess"> Reassess the fall risk and reeducate the patient and family.	
                                                                        </label>
                                                                    </div>
                                                                    <div class="form-check pl-4">
                                                                        <input class="form-check-input" type="checkbox" id="document_condition" value="28" name="fall_prevention[]" {{ in_array(28, $selectedValues) ? 'checked' : '' }}>
                                                                        <label class="form-check-label" for="document_condition">Document the patient condition after fall in daily nursing record.
                                                                        </label>
                                                                    </div>
                                                                </div>
                                                            </td>
                                                        </tr>
                                                        {{-- <tr>
                                                            <td class="text-center" colspan="2">Low risk 25-50 Low risk fall prevention measures provided</td>
                                                            <td class="text-center"><span id="his_fall_text"></span></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center" colspan="2">No risk 0-24 Standard fail prevention measures provided</td>
                                                            <td class="text-center"><span id="his_fall_text"></span></td>
                                                        </tr> --}}

                                                        <tr>
                                                            <td class="text-right" colspan="2"><b>R/N:</b></td>
                                                            <td><input type="text" class="custom-form" name="asmnt_rn_no" id="asmnt_rn_no"></td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right" colspan="2"><b>Sign:</b></td>
                                                            <td>
                                                                <input type="text" class="custom-form" name="sign_name" id="sign_name">
                                                                <input type="hidden" class="custom-form" name="sign_id" id="sign_id">
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-right" colspan="2"><b>EMP. ID:</b></td>
                                                            <td>
                                                                <input type="text" class="custom-form" name="emp_name" id="emp_name">
                                                                <input type="hidden" class="custom-form" name="emp_id" id="emp_id">
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                            <div class="text-center">
                                                <button class="btn btn-md btn-success px-5" type="button" onclick="saveAssesment()">Save</button>
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


<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
        $(document).ready(function(){
            openDoctorAutocomplete('#sign_name', 'sign_id');
            openDoctorAutocomplete('#emp_name', 'emp_id');

                // total score calculate
                var sum = 0;
                $(".dropdown_value").each(function () {
                    sum += parseFloat($(this).val()) || 0;
                });
                if (sum >= 0 && sum <= 24) {
                    $('#no_risk').css('display', 'block');
                    $('#low_risk').css('display', 'none');
                    $('#high_risk').css('display', 'none');
                    $('#low_risk input[type="checkbox"]').prop('checked', false);
                    $('#high_risk input[type="checkbox"]').prop('checked', false);
                } else if (sum >= 25 && sum <= 50) {
                    $('#low_risk').css('display', 'block');
                    $('#no_risk').css('display', 'none');
                    $('#high_risk').css('display', 'none');
                    $('#no_risk input[type="checkbox"]').prop('checked', false);
                    $('#high_risk input[type="checkbox"]').prop('checked', false);
                } else {
                    $('#high_risk').css('display', 'block');
                    $('#no_risk').css('display', 'none');
                    $('#low_risk').css('display', 'none');
                    $('#no_risk input[type="checkbox"]').prop('checked', false);
                    $('#low_risk input[type="checkbox"]').prop('checked', false);
                }

                $("#total_score").text(sum);
        })


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
    


        function changeFalRisk(value, id){
            $("#"+id).text(value);
            var sum = 0;
            $(".dropdown_value").each(function () {
                sum += parseFloat($(this).val()) || 0;
            });
            if (sum >= 0 && sum <= 24) {
                $('#no_risk').css('display', 'block');
                $('#low_risk').css('display', 'none');
                $('#high_risk').css('display', 'none');
                $('#low_risk input[type="checkbox"]').prop('checked', false);
                $('#high_risk input[type="checkbox"]').prop('checked', false);
            } else if (sum >= 25 && sum <= 50) {
                $('#low_risk').css('display', 'block');
                $('#no_risk').css('display', 'none');
                $('#high_risk').css('display', 'none');
                $('#no_risk input[type="checkbox"]').prop('checked', false);
                $('#high_risk input[type="checkbox"]').prop('checked', false);
            } else {
                $('#high_risk').css('display', 'block');
                $('#no_risk').css('display', 'none');
                $('#low_risk').css('display', 'none');
                $('#no_risk input[type="checkbox"]').prop('checked', false);
                $('#low_risk input[type="checkbox"]').prop('checked', false);
            }
            $("#total_score").text(sum);
        } 


        function saveAssesment(){
            let formElement = document.querySelector('#assesmentForm');
            let formData = new FormData(formElement);
            if($('#admission_no_fk').val() == ''){
                alert('Amission no required');
                return false;
            }

            if($('#patient_no_fk').val() == ''){
                alert('Patient no required');
                return false;
            }

            $.ajax({
                    url:"{{route('v2.ipd.save-patient-fall-risk')}}",
                    type:"post",
                    dataType:"json",
                    data:formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        blockUI();
                    },
                    success:function(data){  
                        $.unblockUI();
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html('Success');
                        $('.common-modal-notify .modal-body').html(data.message);
                    },
                    error:function(err){
                        $.unblockUI();
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message);
                    },
                    complete: function() {
                        $.unblockUI();
                    }
            });
        }
                                                        
</script>
