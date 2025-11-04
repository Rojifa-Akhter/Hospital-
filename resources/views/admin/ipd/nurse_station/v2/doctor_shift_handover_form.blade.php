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
                            <h5 class="mt-2 mb-0">Doctor Shift Handover</h5>
                            <small>IPD / Nurse Station / Doctor Shift Handover</small>
                        </div>
                        {{-- <div class="col-md-2">
                            <a class="btn btn-md btn-warning" target="_blank" href="{{route('ipd.doctor-shift-handover-form-print',[$patient_info->patient_no_pk, $patient_info->admission_no_pk])}}">PDF Export</a>
                        </div> --}}
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
                                    <form action="{{ route('ipd.store-doctor-shift-handover') }}" method="post"
                                        id="docShiftHandoverForm">
                                        @csrf
                                        <input type="hidden" name="patient_no_fk" id="patient_no_fk"
                                            value="{{ $patient_no_fk }}">
                                        <input type="hidden" name="admission_no_fk" id="admission_no_fk"
                                            value="{{ $admission_id }}">

                                        <input type="hidden" name="ipd_docshift_handover_no_pk"
                                            value="{{ $doc_handover->ipd_docshift_handover_no_pk ?? '' }}">

                                        <div class="table-responsive">

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td colspan="4">
                                                        <h5>Clinical Summary:</h5>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <textarea class="form-control" name="clinical_summary" rows="5">{{ @$doc_handover->clinical_summary ? $doc_handover->clinical_summary : '' }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <h5>Current Condition:</h5>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong> Stable</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="stable"
                                                            value="{{ @$doc_handover->stable ? $doc_handover->stable : '' }}"
                                                            placeholder="" />
                                                    </td>
                                                    <td>
                                                        <strong> Improving</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="improving"
                                                            value="{{ @$doc_handover->improving ? $doc_handover->improving : '' }}"
                                                            placeholder="" />

                                                    </td>

                                                    <td>
                                                        <strong> Deteriorating</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="deterior"
                                                            value="{{ @$doc_handover->deterior ? $doc_handover->deterior : '' }}"
                                                            placeholder="" />

                                                    </td>
                                                    <td>
                                                        <strong>Critical</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="critical"
                                                            value="{{ @$doc_handover->critical ? $doc_handover->critical : '' }}"
                                                            placeholder="" />

                                                    </td>


                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong> Vital signs trend</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="vital_sign"
                                                            value="{{ @$doc_handover->vital_sign ? $doc_handover->vital_sign : '' }}"
                                                            placeholder="" />
                                                    </td>
                                                    <td>
                                                        <strong>Oxygen requirement</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="oxygen"
                                                            value="{{ @$doc_handover->oxygen ? $doc_handover->oxygen : '' }}"
                                                            placeholder="" />

                                                    </td>


                                                    <td colspan="2">
                                                        <strong>Consciousness</strong>
                                                        <select name="consciousness" class="form-select form-select-sm">
                                                            <option
                                                                value="Alert"{{ @$doc_handover->consciousness == 'Alert' ? 'selected' : '' }}>
                                                                Alert</option>
                                                            <option
                                                                value="Drowsy"{{ @$doc_handover->consciousness == 'Drowsy' ? 'selected' : '' }}>
                                                                Drowsy</option>
                                                            <option
                                                                value="Unconscious"{{ @$doc_handover->consciousness == 'Unconscious' ? 'selected' : '' }}>
                                                                Unconscious</option>

                                                        </select>
                                                    </td>



                                                </tr>



                                            </table> <br>

                                            @php
                                                $med_therap = json_decode($doc_handover->med_therap ?? '[]');
                                                $dose_route = json_decode($doc_handover->dose_route ?? '[]');
                                                $frequency = json_decode($doc_handover->frequency ?? '[]');
                                                $s_date = json_decode($doc_handover->s_date ?? '[]');
                                                $comments = json_decode($doc_handover->comments ?? '[]');

                                                $hasData =
                                                    !empty($med_therap) &&
                                                    is_array($med_therap) &&
                                                    count($med_therap) > 0;
                                            @endphp

                                            <h5>Ongoing Treatments</h5>
                                            <table width="100%" border="1" style="margin-bottom: 10px">
                                                <thead>
                                                    <tr>
                                                        <th>Medication / Therapy</th>
                                                        <th>Dose & Route</th>
                                                        <th>Frequency</th>
                                                        <th>Start Date</th>
                                                        <th>Comments</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="medBody">
                                                    @if ($hasData)
                                                        @for ($i = 0; $i < count($med_therap); $i++)
                                                            <tr>
                                                                <td><input type="text" name="med_therap[]"
                                                                        value="{{ $med_therap[$i] ?? '' }}"
                                                                        class="form-control" /></td>
                                                                <td><input type="text" name="dose_route[]"
                                                                        value="{{ $dose_route[$i] ?? '' }}"
                                                                        class="form-control" /></td>
                                                                <td><input type="text" name="frequency[]"
                                                                        value="{{ $frequency[$i] ?? '' }}"
                                                                        class="form-control" /></td>
                                                                <td>
                                                                    <input type="date" name="s_date[]"
                                                                        value="{{ isset($s_date[$i]) ? date('Y-m-d', strtotime($s_date[$i])) : '' }}"
                                                                        class="form-control" />
                                                                </td>

                                                                <td><input type="text" name="comments[]"
                                                                        value="{{ $comments[$i] ?? '' }}"
                                                                        class="form-control" /></td>
                                                                <td>
                                                                    <button type="button"
                                                                        class="btn btn-danger btn-sm removeRow">Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    @else
                                                        {{-- Show one empty row --}}
                                                        <tr>
                                                            <td><input type="text" name="med_therap[]"
                                                                    class="form-control" /></td>
                                                            <td><input type="text" name="dose_route[]"
                                                                    class="form-control" /></td>
                                                            <td><input type="text" name="frequency[]"
                                                                    class="form-control" /></td>
                                                            <td><input type="date" name="s_date[]"
                                                                    class="form-control" /></td>
                                                            <td><input type="text" name="comments[]"
                                                                    class="form-control" /></td>
                                                            <td>
                                                                <button type="button"
                                                                    class="btn btn-danger btn-sm removeRow">Remove</button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5" class="text-center">
                                                            <button type="button" class="btn btn-primary btn-md"
                                                                id="addMedicationRow">
                                                                +Add More
                                                            </button>
                                                        </td>

                                                    </tr>
                                                </tfoot>
                                            </table> <br>

                                            @php
                                                $test_name = json_decode($doc_handover->test_name ?? '[]');
                                                $date_order = json_decode($doc_handover->date_order ?? '[]');
                                                $result = json_decode($doc_handover->result ?? '[]');
                                                $remarks = json_decode($doc_handover->remarks ?? '[]');

                                                $hasTestData =
                                                    !empty($test_name) && is_array($test_name) && count($test_name) > 0;
                                            @endphp

                                            <h5>Pending Investigations / Reportd</h5>
                                            <table width="100%" border="1" style="margin-bottom: 10px">
                                                <thead>
                                                    <tr>
                                                        <th>Test Name</th>
                                                        <th>Date Ordered</th>
                                                        <th>Result Available</th>
                                                        <th>Remarks</th>
                                                        <th>Action</th>
                                                    </tr>
                                                </thead>
                                                <tbody id="repBody">
                                                    @if ($hasTestData)
                                                        @for ($i = 0; $i < count($test_name); $i++)
                                                            <tr>
                                                                <td><input type="text" name="test_name[]"
                                                                        value="{{ $test_name[$i] ?? '' }}"
                                                                        class="form-control" /></td>
                                                                <td><input type="text" name="date_order[]"
                                                                        value="{{ $date_order[$i] ?? '' }}"
                                                                        class="form-control" /></td>
                                                                <td>
                                                                    <select name="result[]"
                                                                        class="form-select form-select-sm">
                                                                        <option value="YES"
                                                                            {{ isset($result[$i]) && $result[$i] === 'YES' ? 'selected' : '' }}>
                                                                            YES</option>
                                                                        <option value="NO"
                                                                            {{ isset($result[$i]) && $result[$i] === 'NO' ? 'selected' : '' }}>
                                                                            NO</option>
                                                                    </select>
                                                                </td>
                                                                <td><input type="text" name="remarks[]"
                                                                        value="{{ $remarks[$i] ?? '' }}"
                                                                        class="form-control" /></td>
                                                                <td><button type="button"
                                                                        class="btn btn-danger btn-sm removeRow">Remove</button>
                                                                </td>
                                                            </tr>
                                                        @endfor
                                                    @else
                                                        {{-- One empty row if no data --}}
                                                        <tr>
                                                            <td><input type="text" name="test_name[]"
                                                                    class="form-control" /></td>
                                                            <td><input type="text" name="date_order[]"
                                                                    class="form-control" /></td>
                                                            <td>
                                                                <select name="result[]"
                                                                    class="form-select form-select-sm">
                                                                    <option value="YES">YES</option>
                                                                    <option value="NO">NO</option>
                                                                </select>
                                                            </td>
                                                            <td><input type="text" name="remarks[]"
                                                                    class="form-control" /></td>
                                                            <td><button type="button"
                                                                    class="btn btn-danger btn-sm removeRow">Remove</button>
                                                            </td>
                                                        </tr>
                                                    @endif
                                                </tbody>
                                                <tfoot>
                                                    <tr>
                                                        <td colspan="5" class="text-center">
                                                            <button type="button" class="btn btn-primary btn-md"
                                                                id="addReports">+Add
                                                                More</button>
                                                        </td>
                                                    </tr>
                                                </tfoot>
                                            </table> <br>

                                            <table width="100%" border="1" style="margin-top:10px">
                                                <tr>
                                                    <td colspan="4">
                                                        <h5>Planned Interventions / Instructions:</h5>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <textarea class="form-control" name="planned_intervention" rows="5">{{ @$doc_handover->planned_intervention ? $doc_handover->planned_intervention : '' }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <h5>Important Clinical Alerts:</h5>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td>
                                                        <strong>Allergy (Specify)</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="allergy"
                                                            value="{{ @$doc_handover->allergy ? $doc_handover->allergy : '' }}"
                                                            placeholder="" />
                                                    </td>
                                                    <td>
                                                        <strong>DNR Status</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="dna"
                                                            value="{{ @$doc_handover->dna ? $doc_handover->dna : '' }}"
                                                            placeholder="" />

                                                    </td>


                                                    <td>
                                                        <strong>Infectious Disease Precautions</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="disease"
                                                            value="{{ @$doc_handover->disease ? $doc_handover->disease : '' }}"
                                                            placeholder="" />

                                                    </td>
                                                    <td>
                                                        <strong>Fall Risk / Pressure Ulcer Risk</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="fall_risk"
                                                            value="{{ @$doc_handover->fall_risk ? $doc_handover->fall_risk : '' }}"
                                                            placeholder="" />

                                                    </td>


                                                </tr>

                                                <tr>
                                                    <td colspan="4">
                                                        <h5>To-Do for Next Doctor:</h5>

                                                    </td>
                                                </tr>

                                                <tr>
                                                    <td colspan="4">
                                                        <textarea class="form-control" name="next_doc" rows="5">{{ @$doc_handover->next_doc ? $doc_handover->next_doc : '' }}</textarea>
                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="4">
                                                        <h5>Shift Handover Details:</h5>

                                                    </td>
                                                </tr>
                                                <tr>
                                                    <td colspan="2">
                                                        <strong>Outgoing Doctor Name</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="out_doc" id="out_doc"
                                                            value="{{ @$doc_handover->out_doc ? $doc_handover->out_doc : '' }}"
                                                            placeholder="" />
                                                        <input type="hidden" name="h_out_doc" id="h_out_doc"
                                                            value="{{ @$doc_handover->h_out_doc ? $doc_handover->h_out_doc : '' }}">
                                                    </td>
                                                    <td>
                                                        <strong>Signature</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="out_doc_sign"
                                                            value="{{ @$doc_handover->out_doc_sign ? $doc_handover->out_doc_sign : '' }}"
                                                            placeholder="" />

                                                    </td>

                                                    <td>
                                                        <strong>Date/Time</strong>
                                                        <input type="datetime-local" class="form-control"
                                                            name="out_doc_date"
                                                            value="{{ isset($doc_handover->out_doc_date) ? date('Y-m-d\TH:i', strtotime($doc_handover->out_doc_date)) : '' }}"
                                                            placeholder="Enter date and time" />

                                                    </td>

                                                </tr>

                                                <tr>
                                                    <td colspan="2">
                                                        <strong>Incoming Doctor Name</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="in_doc" id="in_doc"
                                                            value="{{ @$doc_handover->in_doc ? $doc_handover->in_doc : '' }}"
                                                            placeholder="" />
                                                        <input type="hidden" name="h_in_doc" id="h_in_doc"
                                                            value="{{ @$doc_handover->h_in_doc ? $doc_handover->h_in_doc : '' }}">
                                                    </td>
                                                    <td>
                                                        <strong>Signature</strong>
                                                        <input type="text" class="form-control form-control"
                                                            name="in_doc_sign"
                                                            value="{{ @$doc_handover->in_doc_sign ? $doc_handover->in_doc_sign : '' }}"
                                                            placeholder="" />

                                                    </td>

                                                    <td>
                                                        <strong>Date/Time: </strong>
                                                        <input type="datetime-local" class="form-control"
                                                            name="in_doc_date"
                                                            value="{{ isset($doc_handover->in_doc_date) ? date('Y-m-d\TH:i', strtotime($doc_handover->in_doc_date)) : '' }}"
                                                            placeholder="Enter date and time" />
                                                    </td>
                                                </tr>




                                            </table> <br>

                                        </div>



                                        <div class="text-center">
                                            @php
                                                $redirect_url = route('v2.ipd.nurse-note', $admission_id);
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
    openDoctorAutocomplete('#out_doc', 'h_out_doc', 'doctor_ind', '1,2');
    openDoctorAutocomplete('#in_doc', 'h_in_doc', 'doctor_ind', '1,2');


    $(document).ready(function() {
        $('#addMedicationRow').click(function() {
            let newRow = `
        <tr>
            <td><input type="text" name="med_therap[]" class="form-control" /></td>
            <td><input type="text" name="dose_route[]" class="form-control" /></td>
            <td><input type="text" name="frequency[]" class="form-control" /></td>
            <td><input type="date" name="s_date[]" class="form-control" /></td>
            <td><input type="text" name="comments[]" class="form-control" /></td>
            <td><button type="button" class="btn btn-danger btn-sm removeRow">Remove</button></td>
        </tr>`;
            $('#medBody').append(newRow);
        });

        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
        });

    });



    $(document).ready(function() {
        $('#addReports').click(function() {
            let newRow = `
        <tr>
            <td><input type="text" name="test_name[]" class="form-control" /></td>
            <td><input type="text" name="date_order[]" class="form-control" /></td>
            <td>
                <select name="result[]" class="form-select form-select-sm">
                    <option value="YES">YES</option>
                    <option value="NO">NO</option>
                </select>
            </td>
            <td><input type="text" name="remarks[]" class="form-control" /></td>
            <td><button type="button" class="btn btn-danger btn-sm removeRow">Remove</button></td>
        </tr>`;
            $('#repBody').append(newRow);
        });

        $(document).on('click', '.removeRow', function() {
            $(this).closest('tr').remove();
        });
    });
</script>
