
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
                            <h5 class="mt-2 mb-0">Discharge/LAMA/Death Checklist</h5>
                            <small>IPD / Nurse Station / Discharge/LAMA/Death Checklist</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank" href="{{route('v2.ipd.download-discharge-lama',[$patient_info->patient_no_pk, $patient_info->admission_no_pk])}}">PDF Export</a>
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
                                    <form action="{{route('v2.ipd.medicine-indent-request')}}" method="post" id="assesmentForm">
                                        @csrf

                                            <div class="table-responsive">
                                                <table class="table table-bordered">
                                                    <thead>
                                                        <tr>
                                                            <th class="text-left border-right-0" style="width:5%">#SL</th>
                                                            <th class="text-left border-left-0" colspan="6">DISCHARGE</th>
                                                            <th class="text-left border-left-0" style="width:8%">Yes/No/NA</th>

                                                        </tr>
                                                    </thead>

                                                    <tbody>
             

                                                        <tr>
                                                            <td class="text-center">1</td>
                                                            <td colspan="6" class="text-left">
                                                                Patient Identification in medicine cover with right patient ,dose,frequency done						
                                                                <input type="hidden" class="custom-form" id="patient_no_fk" name="patient_no_fk" value="{{@$patient_info->patient_no_pk}}">
                                                                <input type="hidden" class="custom-form" id="admission_no_fk" name="admission_no_fk" value="{{@$patient_info->admission_no_pk}}">
                                                            </td>

                                                            <td class="text-center">
                                                                <select class="custom-form" name="pat_identified_dose" id="pat_identified_dose">
                                                                    <option value="1" {{ @$data->pat_identified_dose == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->pat_identified_dose == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->pat_identified_dose == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-center"></td>

                                                            <td  class="text-left">Verifed by TL</td>
                                                            <td  class="text-center"><input type="text" class="custom-form" name="verified_tl" id="verified_tl" value="" readonly></td>
                                                            <td  class="text-center">Name:</td>
                                                            <td  class="text-center">
                                                                <input type="text" class="custom-form" value="{{@$data->verified_tl}}" name="identified_varified_by_name" id="identified_varified_by_name">
                                                                <input type="hidden" class="custom-form" name="identified_varified_by" id="identified_varified_by" value="">
                                                            </td>
                                                            <td  class="text-center">Sign</td>
                                                            <td  class="text-center" colspan="2"><input type="text" class="custom-form" name="" id="" value="" readonly></td>

                                                        </tr>


                                                        <tr>
                                                            <td class="text-center">2</td>
                                                            <td colspan="6" class="text-left">
                                                                Discharge medication and summary explained to the patient /by stander
                                                            </td>

                                                            <td class="text-center">
                                                                <select class="custom-form" name="explainedpatient" id="explainedpatient">
                                                                    <option value="1" {{ @$data->explainedpatient == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->explainedpatient == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->explainedpatient == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">3</td>
                                                            <td colspan="6" class="text-left">
                                                                All medication ticked off in discharge summary (hosoital copy ) and acknowledgement of receipt taken from patient / relatives 

                                                            </td>

                                                            <td class="text-center">
                                                                <select class="custom-form" name="patient_rel" id="patient_rel">
                                                                    <option value="1" {{ @$data->patient_rel == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->patient_rel == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->patient_rel == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-center">4</td>
                                                            <td colspan="6" class="text-left">
                                                                PFE - Care of tubes ,lines ,drains,pressure injury prevention & management given 
                                                            </td>

                                                            <td class="text-center">
                                                                <select class="custom-form" name="pfe_care" id="pfe_care">
                                                                    <option value="1" {{ @$data->pfe_care == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->pfe_care == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->pfe_care == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">5</td>
                                                            <td colspan="6" class="text-left"> PFE - Wound care ,ostomy care,wound dressing ,etc….done </td>

                                                            <td class="text-center">
                                                                <select class="custom-form" name="pfe_wound" id="pfe_wound">
                                                                    <option value="1" {{ @$data->pfe_wound == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->pfe_wound == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->pfe_wound == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">6</td>
                                                            <td colspan="6" class="text-left"> Hospital uniform changed to own dress                                                            </td>

                                                            <td class="text-center">
                                                                <select class="custom-form" name="hos_uniform" id="hos_uniform">
                                                                    <option value="1" {{ @$data->hos_uniform == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->hos_uniform == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->hos_uniform == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">7</td>
                                                            <td colspan="6" class="text-left"> Removal of ID band  (as required )done                                                            </td>

                                                            <td class="text-center">
                                                                <select class="custom-form" name="removal_id" id="removal_id">
                                                                    <option value="1" {{ @$data->removal_id == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->removal_id == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->removal_id == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>
                                                        <tr>
                                                            <td class="text-center">8</td>
                                                            <td colspan="6" class="text-left"> IV Cannula /any other lines /tubes  removed site no bleeding, sealed with micropore .</td>

                                                            <td class="text-center">
                                                                <select class="custom-form" name="iv_cannula" id="iv_cannula">
                                                                    <option value="1" {{ @$data->iv_cannula == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->iv_cannula == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->iv_cannula == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td class="text-center">9</td>
                                                            <td colspan="6" class="text-left"> Handed over : Thermometer / Nebulisation mask / o2 mask /Urinal / Bedpan /Plastic basin /Sputum cup / Own Medicines/Fridge medicine / X-ray etc …done </td>

                                                            <td class="text-center">
                                                                <select class="custom-form" name="handed_over" id="handed_over">
                                                                    <option value="1" {{ @$data->handed_over == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->handed_over == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->handed_over == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-center">10</td>
                                                            <td colspan="6" class="text-left">Received the discharge slip and filed</td>
                                                            <td class="text-center">
                                                                <select class="custom-form" name="received_slip" id="received_slip">
                                                                    <option value="1" {{ @$data->received_slip == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->received_slip == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->received_slip == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-center">11</td>
                                                            <td colspan="6" class="text-left">Assessed for transportation assistance and arranged as required (Independent/wheel chair/trolley)</td>
                                                            <td class="text-center">
                                                                <select class="custom-form" name="assessed_for_transport" id="assessed_for_transport">
                                                                    <option value="1" {{ @$data->assessed_for_transport == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->assessed_for_transport == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->assessed_for_transport == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-center">12</td>
                                                            <td colspan="6" class="text-left">Patient discharged with supportive measures (oxygen /BIPAP/etc….......)</td>
                                                            <td class="text-center">
                                                                <select class="custom-form" name="discharge_withmeasures" id="discharge_withmeasures">
                                                                    <option value="1" {{ @$data->discharge_withmeasures == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->discharge_withmeasures == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->discharge_withmeasures == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-center">13</td>
                                                            <td colspan="6" class="text-left">Bill cleared</td>
                                                            <td class="text-center">
                                                                <select class="custom-form" name="bill_cleared" id="bill_cleared">
                                                                    <option value="1" {{ @$data->bill_cleared == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->bill_cleared == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->bill_cleared == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="8" class="text-center fs-3" style="border:none !important;"><b>LAMA</b></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-center">1</td>
                                                            <td colspan="6" class="text-left">LAMA Consent present</td>
                                                            <td class="text-center">
                                                                <select class="custom-form" name="lama_consent" id="lama_consent">
                                                                    <option value="1" {{ @$data->lama_consent == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->lama_consent == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->lama_consent == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-center">2</td>
                                                            <td colspan="6" class="text-left">LAMA Summary given</td>
                                                            <td class="text-center">
                                                                <select class="custom-form" name="lama_summary" id="lama_summary">
                                                                    <option value="1" {{ @$data->lama_summary == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->lama_summary == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->lama_summary == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td colspan="8" class="text-center fs-3" style="border:none !important"><b>DEATH</b></td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-center">1</td>
                                                            <td colspan="6" class="text-left">Death care given and labelled as per hospital protocols  </td>
                                                            <td class="text-center">
                                                                <select class="custom-form" name="death_care_given" id="death_care_given">
                                                                    <option value="1" {{ @$data->death_care_given == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->death_care_given == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->death_care_given == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td class="text-center">2</td>
                                                            <td colspan="6" class="text-left">Death certificate handed over to security along with dead body & time</td>
                                                            <td class="text-center">
                                                                <select class="custom-form" name="death_certificate_body" id="death_certificate_body">
                                                                    <option value="1" {{ @$data->death_certificate_body == 1 ? 'selected' : ''}}>No</option>
                                                                    <option value="2" {{ @$data->death_certificate_body == 2 ? 'selected' : ''}}>Yes</option>
                                                                    <option value="3" {{ @$data->death_certificate_body == 3 ? 'selected' : ''}}>NA</option>
                                                                </select>
                                                            </td>
                                                        </tr>



                                                        <tr>
                                                            <td colspan="8" class="text-left py-2" style="border-left:none; border-right:none">I have received and reviewed my discharge summary with all investigation reports and understand my medication 
                                                            </td>
                                                        </tr>

                                                        <tr>
                                                            <td colspan="8" class="text-left py-2" style="border-left:none; border-right:none">schedules ,and the above medication details ,and all the medication received ( as per the bill)
                                                            </td>
                                                        </tr>


                                                        <tr>
                                                            <td colspan="4" class="text-left">Name of the Patient /Attenders /Security with Signature </td>
                                                            <td colspan="4" class="text-left">Relationship with Patient</td>
                                                        </tr>
                                                        <tr>
                                                            <td colspan="4" class="text-left"></td>
                                                            <td colspan="4" class="text-left"><input type="text" class="custom-form" name="relation_patient" id="relation_patient" value="{{@$data->relation_patient}}"></td>
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
            openDoctorAutocomplete('#identified_varified_by_name', 'identified_varified_by');
                var currentDate = new Date();
                $('.date_picker').datepicker({
                    todayHighlight: true,
                    clearBtn: true,
                    autoclose: true,
                    format: 'dd/mm/yyyy',
                }).datepicker('setDate', currentDate);
        })


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });
    
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
                    url:"{{route('v2.ipd.nursing-discharge-lama-save')}}",
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
