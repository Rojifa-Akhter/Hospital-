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
                            <h5 class="mt-2 mb-0">EPIDURAL MONITORING CHART</h5>
                            <small>IPD / Nurse Station / Epidural Monitoring Chart</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('ipd.epidural-monitoring-chart-print', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('ipd.store-epidural-monitoring-chart') }}" method="post"
                                        id="EMC">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">
                                        <input type="hidden" name="epidural_mc_no_pk"
                                            value="{{ isset($epidural->epidural_mc_no_pk) ? $epidural->epidural_mc_no_pk : '' }}">


                                        <div>
                                            <div class="row">


                                                @php
                                                    $time_list = !empty($epidural->dt_time)
                                                        ? json_decode($epidural->dt_time, true)
                                                        : [];
                                                    $lb = !empty($epidural->lb) ? json_decode($epidural->lb, true) : [];
                                                    $pr = !empty($epidural->pr) ? json_decode($epidural->pr, true) : [];
                                                    $llb = !empty($epidural->llb)
                                                        ? json_decode($epidural->llb, true)
                                                        : [];
                                                    $rswe = !empty($epidural->rswe)
                                                        ? json_decode($epidural->rswe, true)
                                                        : [];
                                                @endphp


                                                <div class="col-md-12">
                                                    <table class="table table-bordered text-center">
                                                        <thead>
                                                            <tr>
                                                                <th>Date & Time</th>
                                                                <th>Level of Block</th>
                                                                <th>Paresthesia</th>
                                                                <th>Lower Limb Mobility</th>
                                                                <th>RN Sign With Emp ID</th>
                                                                <th>Action</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="vitalsTable">
                                                            @if (!empty($time_list))
                                                                @foreach ($time_list as $i => $time)
                                                                    <tr>
                                                                        <td>
                                                                            <input type="datetime-local"
                                                                                name="dt_time[]"
                                                                                value="{{ $time }}"
                                                                                style="width:100%">
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="lb[]"
                                                                                value="{{ $lb[$i] ?? '' }}"
                                                                                style="width:100%">
                                                                        </td>
                                                                        <td>
                                                                            <select name="pr[]" style="width:100%">
                                                                                <option value="">Select</option>
                                                                                <option value="1"
                                                                                    {{ isset($pr[$i]) && $pr[$i] == 1 ? 'selected' : '' }}>
                                                                                    Yes</option>
                                                                                <option value="2"
                                                                                    {{ isset($pr[$i]) && $pr[$i] == 2 ? 'selected' : '' }}>
                                                                                    No</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <select name="llb[]" style="width:100%">
                                                                                <option value="">Select</option>
                                                                                <option value="1"
                                                                                    {{ isset($llb[$i]) && $llb[$i] == 1 ? 'selected' : '' }}>
                                                                                    Full</option>
                                                                                <option value="2"
                                                                                    {{ isset($llb[$i]) && $llb[$i] == 2 ? 'selected' : '' }}>
                                                                                    Partial</option>
                                                                                <option value="3"
                                                                                    {{ isset($llb[$i]) && $llb[$i] == 3 ? 'selected' : '' }}>
                                                                                    Nill</option>
                                                                            </select>
                                                                        </td>
                                                                        <td>
                                                                            <input type="text" name="rswe[]"
                                                                                value="{{ $rswe[$i] ?? '' }}"
                                                                                style="width:100%">
                                                                        </td>
                                                                        <td>
                                                                            <span
                                                                                class="btn btn-success btn-md addvt"><i
                                                                                    class="fa fa-plus"></i></span>
                                                                            <button type="button"
                                                                                class="btn btn-md btn-danger vtdeleterow"><i
                                                                                    class="fa fa-trash"></i></button>
                                                                        </td>
                                                                    </tr>
                                                                @endforeach
                                                            @else
                                                                <tr>
                                                                    <td><input type="datetime-local" name="dt_time[]"
                                                                            style="width:100%"></td>
                                                                    <td><input type="text" name="lb[]"
                                                                            style="width:100%"></td>
                                                                    <td>
                                                                        <select name="pr[]" style="width:100%">
                                                                            <option value="">Select</option>
                                                                            <option value="1">Yes</option>
                                                                            <option value="2">No</option>
                                                                        </select>
                                                                    </td>
                                                                    <td>
                                                                        <select name="llb[]" style="width:100%">
                                                                            <option value="">Select</option>
                                                                            <option value="1">Full</option>
                                                                            <option value="2">Partial</option>
                                                                            <option value="3">Nill</option>
                                                                        </select>
                                                                    </td>
                                                                    <td><input type="text" name="rswe[]"
                                                                            style="width:100%"></td>
                                                                    <td><span class="btn btn-success btn-md addvt"><i
                                                                                class="fa fa-plus"></i></span></td>
                                                                </tr>
                                                            @endif
                                                        </tbody>
                                                    </table>

                                                </div>

                                                <div class="col-md-12">
                                                    <label><b>If any one of these are seen:</b></label>

                                                </div>

                                                <div class="col-md-12">
                                                    <p>
                                                        1. Hypotension (BP &lt;90&#x2f;50mm of Hg) <br>
                                                        2. Bradycardia (Pulse
                                                        &lt;60b&#x2f;mt) <br>
                                                        3. Breathing difficulty <br>
                                                        4. Inability to
                                                        move lower limb of paresthesia of numberless <br>
                                                        5. Pain Relief
                                                        is inadequate <br>
                                                        6. Fetal Distress <br>
                                                        7. Patient unresponsive <br>
                                                        8.
                                                        Desaturation <br>
                                                        9. Headache <br>
                                                        10. Seizures </p>
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="checkbox" name="ca" value="1"
                                                        {{ @$epidural->ca == 1 ? 'checked' : '' }}>
                                                    <b>Call Anesthetist</b>
                                                </div>

                                                <div class="col-md-3">
                                                    <input type="checkbox" name="se" value="1"
                                                        {{ @$epidural->se == 1 ? 'checked' : '' }}>
                                                    <b>Stop epidural</b>
                                                </div>




                                            </div>

                                        </div>



                                        <div class="text-center">

                                            @php
                                                $redirect_url = route('ipd.epidural-monitoring-chart', [
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
    openDoctorAutocomplete('#doc', 'h_doc', 'employee_ind', '1');
    openDoctorAutocomplete('#nurse', 'h_nurse', 'employee_ind', '1');

    $(function() {
        const makeRow = () => `
        <tr>
            <td><input type="datetime-local" name="dt_time[]" style="width:100%"></td>
            <td><input type="text" name="lb[]" style="width:100%"></td>
            <td>
                <select name="pr[]">
                <option value="">Select</option>
                <option value="1">Yes</option>
                <option value="2">No</option>
                </select>
            </td>
            <td><select name="llb[]">
                <option value="">Select</option>
                <option value="1">Full</option>
                <option value="2">Partial</option>
                <option value="2">Nill</option>
                </select></td>
            <td><input type="text" name="rswe[]" style="width:100%"></td>
            <td>
                <button type="button" class="btn btn-md btn-danger vtdeleterow"><i class="fa fa-trash"></i></button>
            </td>
        </tr>`;

        // Prevent duplicate bindings
        $(document).off('click', '.addvt').on('click', '.addvt', function(e) {
            e.preventDefault();
            $("#vitalsTable").append(makeRow());
        });

        $(document).off('click', '.vtdeleterow').on('click', '.vtdeleterow', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
