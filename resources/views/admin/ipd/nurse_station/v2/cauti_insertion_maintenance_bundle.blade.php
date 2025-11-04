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
                            <h5 class="mt-2 mb-0">CAUTI, INSERTION & MAINTENANCE BUNDLE</h5>
                            <small>IPD / Nurse Station / CAUTI, INSERTION & MAINTENANCE BUNDLE</small>
                        </div>
                        <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank"
                                href="{{ route('cauti-insertion-maintenance-bundle-pdf', [$patient_info->patient_no_pk, $patient_info->admission_no_pk]) }}">PDF
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
                                    <form action="{{ route('cauti-insertion-maintenance-bundle-store') }}"
                                        method="post" id="URINARYCATHETERFORM">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" value="{{ $admission_id }}">
                                        <input type="hidden" name="cauti_in_m_b_no_pk"
                                            value="{{ isset($order_form->cauti_in_m_b_no_pk) ? $order_form->cauti_in_m_b_no_pk : '' }}">

                                        <div class="card p-3 mb-3">
                                            <h5 class="text-center mb-4">CAUTI, INSERTION & MAINTENANCE BUNDLE</h5>

                                            <!-- Diagnosis + Basic Info -->
                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <label><b>Diagnosis:</b></label>
                                                    <input type="text" name="diagnosis" class="form-control"
                                                        value="{{ old('diagnosis', @$form->diagnosis) }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label><b>Location & Inserted by:</b></label>
                                                    <input type="text" name="location_inserted_by"
                                                        class="form-control"
                                                        value="{{ old('location_inserted_by', @$form->location_inserted_by) }}">
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <label><b>FC Inserted on:</b></label>
                                                    <input type="text" name="fc_inserted_on" class="form-control"
                                                        value="{{ old('fc_inserted_on', @$form->fc_inserted_on) }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label><b>Indication on:</b></label>
                                                    <input type="text" name="indication_on_insert"
                                                        class="form-control"
                                                        value="{{ old('indication_on_insert', @$form->indication_on_insert) }}">
                                                </div>
                                            </div>

                                            <div class="row mb-2">
                                                <div class="col-md-6">
                                                    <label><b>FC Removed on:</b></label>
                                                    <input type="text" name="fc_removed_on" class="form-control"
                                                        value="{{ old('fc_removed_on', @$form->fc_removed_on) }}">
                                                </div>
                                                <div class="col-md-6">
                                                    <label><b>Indication on:</b></label>
                                                    <input type="text" name="indication_on_remove"
                                                        class="form-control"
                                                        value="{{ old('indication_on_remove', @$form->indication_on_remove) }}">
                                                </div>
                                            </div>
                                        </div>

                                        <div class="table-responsive">
                                            <div class="table-responsive">
                                                <div class="table-responsive">
                                                    <table border="1" style="width:100%; text-align:center;" id="cautiTable">
                                                        <thead>
                                                            <tr>
                                                                <th colspan="13">CAUTI - Yes / No / N/A</th>
                                                                <th style="width:6%">Action</th>
                                                            </tr>
                                                            <tr>
                                                                @php
                                                                    $rows = [
                                                                        'Justification for urinary catheter insertion is documented',
                                                                        'Use complete PPE Including gown for insertion',
                                                                        'Aseptic Technique maintained throughout the procedure',
                                                                        'Closed drainage system with sampling port used',
                                                                        'Drainage bag positioned above the floor but below bladder level',
                                                                        'Catheter and collecting tube are kinks free',
                                                                        'Catheter secured in inner thigh to prevent movement of catheter',
                                                                        'Performed meatal hygiene daily /SOS',
                                                                        'Urinary bag is less than 2/3rd filled',
                                                                        'Sample obtained after cleaning the sample port with alcohol swab',
                                                                        'Sign of Assigned Staff with Emp ID',
                                                                        'Verified by with Emp ID',
                                                                    ];

                                                                    // Explode saved values into arrays
                                                                    $status_arrays = [];
                                                                    for($i=0; $i<count($rows); $i++){
                                                                        $key = 'row'.($i+1).'_status';
                                                                        $status_arrays[$i] = !empty($form->$key) ? explode(',', $form->$key) : [];
                                                                    }

                                                                    $remarks_array = !empty($form->remarks) ? explode(',', $form->remarks) : [];

                                                                    // Determine max rows to render
                                                                    $max_rows = max(count($remarks_array), ...array_map('count', $status_arrays));
                                                                    if($max_rows == 0) $max_rows = 1;
                                                                @endphp

                                                                @foreach($rows as $row)
                                                                    <th>{{ $row }}</th>
                                                                @endforeach
                                                                <th>Remarks</th>
                                                            </tr>
                                                        </thead>
                                                        <tbody id="cautiBody">
                                                            @for($i = 0; $i < $max_rows; $i++)
                                                            <tr>
                                                                @foreach($rows as $index => $row)
                                                                    @php
                                                                        $value = $status_arrays[$index][$i] ?? '';
                                                                    @endphp
                                                                    @if($index < 10)
                                                                        <td>
                                                                            <select name="row{{ $index+1 }}[]" class="form-control form-control-sm">
                                                                                <option value="Yes" {{ $value=='Yes' ? 'selected' : '' }}>Yes</option>
                                                                                <option value="No" {{ $value=='No' ? 'selected' : '' }}>No</option>
                                                                                <option value="N/A" {{ $value=='N/A' ? 'selected' : '' }}>N/A</option>
                                                                            </select>
                                                                        </td>
                                                                    @else
                                                                        <td>
                                                                            <input type="text" name="row{{ $index+1 }}" class="form-control form-control-sm" value="{{ $form->{'row'.($index+1).'_text'} ?? '' }}">
                                                                        </td>
                                                                    @endif
                                                                @endforeach

                                                                {{-- Remarks --}}
                                                                <td>
                                                                    <input type="text" name="remarks[]" class="form-control form-control-sm" value="{{ $remarks_array[$i] ?? '' }}">
                                                                </td>

                                                                <td>
                                                                    <span class="btn btn-success btn-md addcauti"><i class="fa fa-plus"></i></span>
                                                                    <button type="button" class="btn btn-md btn-danger cautideleterow"><i class="fa fa-trash"></i></button>
                                                                </td>
                                                            </tr>
                                                            @endfor
                                                        </tbody>
                                                    </table>
                                                </div>

                                            </div>

                                        </div>

                                        <div class="text-center mt-3">
                                            @php
                                                $redirect_url = route('cauti-insertion-maintenance-bundle', [
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
    openDoctorAutocomplete('#doctor_name', 'h_doctor_name', 'employee_ind', '1');
</script>


<script>
    function toggleField(divId, show) {
        document.getElementById(divId).style.display = show ? 'block' : 'none';
    }
</script>

<script>
$(document).ready(function() {
    $(document).on('click', '.addcauti', function(){
        let row = $(this).closest('tr').clone();

        // Clear inputs and selects
        row.find("input, select").val("");

        // Replace last td with delete button
        row.find("td:last").html(`
            <span class="btn btn-danger btn-md cautideleterow">
                <i class="fa fa-trash"></i>
            </span>
        `);

        $("#cautiBody").append(row);
    });

    $(document).on('click', '.cautideleterow', function(){
        $(this).closest('tr').remove();
    });
});
</script>

{{-- <script>
$(document).ready(function() {
    let colIndex = 0;

    // Add new column
    $(document).on('click', '.addColumn', function() {
        colIndex++;

        // Add header
        $("#cautiHeader .action-col").before(`
            <th class="dynamic-header" data-index="${colIndex}">
                ${colIndex}
                <button type="button" class="btn btn-danger btn-xs deleteColumn" data-index="${colIndex}">
                    <i class="fa fa-trash"></i>
                </button>
            </th>
        `);

        // Add column cells
        $("#cautiTable tbody tr").each(function(rowIndex) {
            let lastTwoRows = rowIndex >= $("#cautiTable tbody tr").length - 2;

            if (lastTwoRows) {
                // Input field for last two rows
                $(this).find('.dynamic-cols').before(`
                    <td class="dynamic-col col-${colIndex}">
                        <input type="text" class="form-control form-control-sm" 
                               name="row${rowIndex+1}_col${colIndex}"
                               value="{{ old('row'+(rowIndex+1)+'_col'+colIndex, '') }}">
                    </td>
                `);
            } else {
                // Select for other rows
                $(this).find('.dynamic-cols').before(`
                    <td class="dynamic-col col-${colIndex}">
                        <select class="form-control form-control-sm" 
                                name="row${rowIndex+1}_col${colIndex}">
                            <option value="Yes">Yes</option>
                            <option value="No">No</option>
                            <option value="N/A">N/A</option>
                        </select>
                    </td>
                `);
            }
        });
    });

    // Delete column
    $(document).on('click', '.deleteColumn', function() {
        let index = $(this).data('index');
        $(`.dynamic-header[data-index='${index}']`).remove();
        $(`.col-${index}`).remove();
    });
});
</script> --}}
