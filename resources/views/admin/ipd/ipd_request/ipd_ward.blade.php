
@php
$ipd_admission = isset($ipd) && !empty($ipd) ? $ipd : [];
$admission_no_pk = $ipd_admission ? $ipd_admission->admission_no_pk : '';
$admission_uid = $ipd_admission ? $ipd_admission->admission_uid : '';
$admission_date = $ipd_admission ? $ipd_admission->admission_date : '';
$primary_doctor_no_fk = $ipd_admission ? $ipd_admission->primary_doctor_no_fk : '';
$duty_doc_person_no_fk = $ipd_admission ? $ipd_admission->duty_doc_person_no_fk : '';
$initial_bed_no_fk = $ipd_admission ? $ipd_admission->initial_bed_no_fk : '';
$curr_bed_no_fk = $ipd_admission ? $ipd_admission->curr_bed_no_fk : '';
$old_bed_no_fk = $ipd_admission ? $ipd_admission->old_bed_no_fk : '';
$curr_ward_no_fk = $ipd_admission ? $ipd_admission->curr_ward_no_fk : '';
$reg_type_no_fk = $ipd_admission ? $ipd_admission->reg_type_no_fk : '';
$su_no_fk = $ipd_admission ? $ipd_admission->su_no_fk : '';
$prescription_no_fk = $ipd_admission ? $ipd_admission->prescription_no_fk : '';
$prescription_uid = $ipd_admission ? $ipd_admission->prescription_uid : '';
$appointment_no_fk = $ipd_admission ? $ipd_admission->appointment_no_fk : '';
$opd_department_su_no_fk = $ipd_admission ? $ipd_admission->opd_department_su_no_fk : '';
$opd_department_name = $ipd_admission ? $ipd_admission->opd_department_name : '';
$status = $ipd_admission ? $ipd_admission->status : '';
$first_ref_doc_person_no_fk = $ipd_admission ? $ipd_admission->first_ref_doc_person_no_fk : '';
$second_ref_doc_person_no_fk = $ipd_admission ? $ipd_admission->second_ref_doc_person_no_fk : '';
$ref_doc_person_no_fk = $ipd_admission ? $ipd_admission->ref_doc_person_no_fk : '';
$patient_no_fk = $ipd_admission ? $ipd_admission->patient_no_fk : '';

$IpdAdmissionDetails = isset($IpdAdmissionDetails) && !empty($IpdAdmissionDetails) ? $IpdAdmissionDetails : [];
$admission_no_pk = $IpdAdmissionDetails ? $IpdAdmissionDetails->admission_no_pk : '';
$pat_condition = $IpdAdmissionDetails ? $IpdAdmissionDetails->pat_condition : '';
$arrival_mode = $IpdAdmissionDetails ? $IpdAdmissionDetails->arrival_mode : '';
$accompanied_by = $IpdAdmissionDetails ? $IpdAdmissionDetails->accompanied_by : '';
$cause_of_admission = $IpdAdmissionDetails ? $IpdAdmissionDetails->cause_of_admission : '';
$contact_person = $IpdAdmissionDetails ? $IpdAdmissionDetails->contact_person : '';
$contact_person_mobile = $IpdAdmissionDetails ? $IpdAdmissionDetails->contact_person_mobile : '';
$contact_relaion = $IpdAdmissionDetails ? $IpdAdmissionDetails->contact_relaion : '';
$ward_no_fk = $ipd_admission ? $ipd_admission->new_ward_no_fk : '';
$remarks = $IpdAdmissionDetails ? $IpdAdmissionDetails->remarks : '';
$pat_valuable_accessories = $IpdAdmissionDetails ? $IpdAdmissionDetails->pat_valuable_accessories : '';

@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

@if(Route::currentRouteName() != 'ipd.admission-list-edit')
<label class="col-form-label col-form-label-sm"
    for="destination_ward">{{ Session::get('user.ses_hospital_code') != 'IMPERIAL' ? 'Ward' : 'Ward/Cabin' }} <span
        class="text-danger">*</span></label>
<select class="form-control form-control-sm select2" id="destination_ward" name="destination_ward" onchange="bedViewer.getBedByWard(this)" required>
    <option value="">Select One</option>
    @foreach ($destinationWards as $dw)
    <option value="{{ $dw->ward_no_pk }}" {{ !empty($dw->ward_no_pk == $ward_no_fk) ? 'selected' : '' }}> {{ $dw->ward_name }} <strong>({{ !empty($dw->bed_count) ? $dw->bed_count : 0 }})</strong></option>
    @endforeach

</select>
@else
{{-- <input type="text" class="form-control form-control-sm" value="{{ $ward_name }}" readonly> --}}
<!-- <input type="hidden" name="destination_ward" id="destination_ward" value="{{ $ward_no_fk }}"> -->
@endif
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>


<script>
    $('.select2').select2();

    $("#destination_ward").on('change', function() {
        var bed_value = $('#destination_ward').val();
        var bed_data = $('#destination_ward').val();
        $.ajax({
            url: "{{ route('ipd.get-bed-by-ward-count') }}",
            type: 'POST',
            data: {
                bed_value: bed_value,
                bed_data: bed_data
            },
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                console.log(data)
                $(".all_bed_count").html(data[0]);
                $(".avalable_bed_count").html(data[1]);
                $(".occupied_bed_count").html(data[2]);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    })
</script>