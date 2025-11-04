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
</style>

<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-10">
                            <h5 class="mt-2 mb-0">Pain Assessment</h5>
                            <small>IPD / Nurse Station / Pain Assessment</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('v2.ipd.download-pain-assessment', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF Export</a>
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
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Category:
                                        {{ $patient_info->ward_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.:
                                        {{ $patient_info->bed_name }}</span>
                                </div>
                                <div class="col-md-12">
                                    <form action="" method="post" id="assesmentForm">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ @$patient_info->patient_no_pk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ @$patient_info->admission_no_pk }}">
                                        <div class="table-responsive">
                                            <table class="table table-bordered">
                                                <tbody>
                                                    <tr>
                                                        <td class="text-center" colspan="11"><b>PAIN ASSESSMENT</b>
                                                        </td>
                                                    </tr>
                                                    <tr>
                                                        <td rowspan="2">Time</td>
                                                        <td colspan="6" class="text-center">Pain</td>
                                                        <td rowspan="2">Time</td>
                                                        <td rowspan="2">Intervention</td>
                                                        <td rowspan="2">Time</td>
                                                        <td rowspan="2">Post Intervention Score</td>
                                                    </tr>
                                                    <tr>
                                                        <td>Precipitating Factor</td>
                                                        <td>Type</td>
                                                        <td>Location</td>
                                                        <td>Pain Score</td>
                                                        <td>Frequency</td>
                                                        <td>Duration</td>
                                                    </tr>
                                                    <tr>
                                                        @php  $time_pain_asses = explode(" ", @$data->time_pain_asses); @endphp
                                                        <td><input type="time" class="custom-form" name="time_pain_asses"
                                                                id="" value="{{@$time_pain_asses[1]}}" autocomplete="off"></td>
                                                        <td>
                                                            <select class="custom-form" name="pain_precipitating_factor"
                                                                id="pain_precipitating_factor">
                                                                <option value="">Select</option>
                                                                <option value="1" {{@$data->pain_precipitating_factor == 1 ? 'selected' : ''}}>Position</option>
                                                                <option value="2" {{@$data->pain_precipitating_factor == 2 ? 'selected' : ''}}>Activity</option>
                                                                <option value="3" {{@$data->pain_precipitating_factor == 3 ? 'selected' : ''}}>Stress</option>
                                                                <option value="4" {{@$data->pain_precipitating_factor == 4 ? 'selected' : ''}}>Burning</option>
                                                                <option value="5" {{@$data->pain_precipitating_factor == 5 ? 'selected' : ''}}>Movement-walking</option>
                                                                <option value="6" {{@$data->pain_precipitating_factor == 6 ? 'selected' : ''}}>Standing </option>
                                                                <option value="7" {{@$data->pain_precipitating_factor == 7 ? 'selected' : ''}}>Lying</option>
                                                                <option value="8" {{@$data->pain_precipitating_factor == 8 ? 'selected' : ''}}>Bending</option>
                                                            </select>
                                                        </td>
                                                        <td>
                                                            <select class="custom-form" name="pain_type"
                                                                id="pain_type">
                                                                <option value="">Select</option>
                                                                <option value="1" {{@$data->pain_type == 1 ? 'selected' : ''}}>Sharp</option>
                                                                <option value="2" {{@$data->pain_type == 2 ? 'selected' : ''}}>Dull</option>
                                                                <option value="3" {{@$data->pain_type == 3 ? 'selected' : ''}}>Stabbing</option>
                                                                <option value="4" {{@$data->pain_type == 4 ? 'selected' : ''}}>Burning</option>
                                                                <option value="5" {{@$data->pain_type == 5 ? 'selected' : ''}}>Crushing</option>
                                                                <option value="6" {{@$data->pain_type == 6 ? 'selected' : ''}}>Cramping</option>
                                                                <option value="7" {{@$data->pain_type == 7 ? 'selected' : ''}}>Aching</option>
                                                                <option value="8" {{@$data->pain_type == 8 ? 'selected' : ''}}>Shooting</option>
                                                                <option value="9" {{@$data->pain_type == 9 ? 'selected' : ''}}>Squeezing</option>
                                                                <option value="10" {{@$data->pain_type == 10 ? 'selected' : ''}}>Pin pricking</option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" class="custom-form" name="pain_location"
                                                                id="" value="{{ @$data->pain_location }}" autocomplete="off"></td>
                                                        <td><input type="text" class="custom-form" name="pain_score"
                                                                id="" value="{{ @$data->pain_score}}" autocomplete="off"></td>
                                                        <td>
                                                            <select class="custom-form" name="pain_frequency"
                                                                id="pain_frequency">
                                                                <option value="">Select</option>
                                                                <option value="1" {{@$data->pain_type == 1 ? 'selected' : ''}}>Constant</option>
                                                                <option value="2" {{@$data->pain_type == 2 ? 'selected' : ''}}>Intermittent </option>
                                                            </select>
                                                        </td>
                                                        <td><input type="text" class="custom-form" name="pain_duration"
                                                                id="" value="{{ @$data->pain_duration}}" autocomplete="off"></td>
                                                        <td>
                                                            @php  $time_pain_intervention = explode(" ", @$data->time_pain_intervention); @endphp
                                                            <input type="time" class="custom-form" name="time_pain_intervention"
                                                                id="" value="{{@$time_pain_intervention[1]}}" autocomplete="off">
                                                        </td>
                                                        <td><input type="text" class="custom-form" name="pain_intervention"
                                                            id="" value="{{ @$data->pain_intervention}}" autocomplete="off">
                                                    </td>
                                                        <td>
                                                            @php  $time_post_intervention = explode(" ", @$data->time_post_intervention); @endphp
                                                            <input type="time" class="custom-form" name="time_post_intervention"
                                                                id="" value="{{@$time_post_intervention[1]}}" autocomplete="off">
                                                        </td>
                                                        
                                                        <td><input type="text" class="custom-form" name="post_intervention_score"
                                                                id="" value="{{ @$data->post_intervention_score}}" autocomplete="off">
                                                        </td>
                                                    </tr>

                                                    <tr>
                                                        <td colspan="3" class="text-left"><b>ORIENTATION:</b>
                                                        </td>
                                                        <td class="text-left border-left-0" colspan="8">
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="orien_side_rails" value="1" {{@$data->orien_side_rails == 1 ? 'checked' : ''}}>
                                                                <label class="form-check-label" for="walking">Side
                                                                    Rails</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="orien_own_med_policy" value="2" {{@$data->orien_own_med_policy == 2 ? 'checked' : ''}}>
                                                                <label class="form-check-label" for="wheelchair">Own
                                                                    Medication Policy</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="orien_rights_privacy_con" value="3" {{@$data->orien_rights_privacy_con == 3 ? 'checked' : ''}}>
                                                                <label class="form-check-label" for="stretcher">Rights
                                                                    of Privacy and Confidentiality</label>
                                                            </div>
                                                            <div class="form-check form-check-inline">
                                                                <input class="form-check-input" type="checkbox"
                                                                    name="orien_call_bell" value="4" {{@$data->orien_call_bell == 4 ? 'checked' : ''}}>
                                                                <label class="form-check-label" for="orien_call_bell">Call
                                                                    Bell</label>
                                                            </div>
                                                        </td>
                                                    </tr>
                                                </tbody>
                                            </table>
                                        </div>
                                        <div class="text-center">
                                            <button class="btn btn-md btn-success px-5" type="button"
                                                onclick="saveAssesment()">Save</button>
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
    function saveAssesment() {
        let formElement = document.querySelector('#assesmentForm');
        let formData = new FormData(formElement);
        if ($('#admission_no_fk').val() == '') {
            alert('Amission no required');
            return false;
        }

        if ($('#patient_no_fk').val() == '') {
            alert('Patient no required');
            return false;
        }

        $.ajax({
            url: "{{ route('v2.ipd.save-pain-assessment') }}",
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $.unblockUI();
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-title').html('Success');
                $('.common-modal-notify .modal-body').html(data.message);
            },
            error: function(err) {
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
