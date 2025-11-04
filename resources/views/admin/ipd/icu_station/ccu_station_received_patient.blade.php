<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    .participent_img {
        width: 50px;
        border: 1px solid #d2d2d2;
        margin-right: 5px;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-6">
            <h5 class="mt-2 mb-0">CCU Station</h5>
            <small>IPD / CCU Station</small>
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-12 mt-2">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active" id="received-patient-tab" href="#" rel="tab"
                        role="tab" aria-controls="received-patient" aria-selected="false">Received Patient</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link" id="receive-request-tab"
                        href="{{ route('ipd.ccu-station-receive-request') }}" rel="tab" role="tab"
                        aria-controls="receive-request" aria-selected="false">Receive Request</a>
                </li>


            </ul>

            <div class="tab-content p-0 bg-transparent" id="myTabContent">
                <div class="tab-pane fade active show" id="received-patient" role="tabpanel"
                    aria-labelledby="received-patient-tab">
                    <div class="card">
                        <div class="card-header d-flex align-items-center justify-content-between">
                            <h5 class="text-primary">Receive Request</h5>
                            <div class="ml-auto">
                                <div
                                    class="custom-control custom-radio custom-control-inline text-center align-items-center">
                                    <input type="radio" id="admitted" name="pat_status"
                                        class="custom-control-input" value="0">
                                    <label class="custom-control-label text-primary" for="admitted">Admitted</label>
                                </div>

                                <div
                                    class="custom-control custom-radio custom-control-inline text-center align-items-center">
                                    <input type="radio" id="discharged_request" name="pat_status"
                                        class="custom-control-input" value="10">
                                    <label class="custom-control-label text-primary"
                                        for="discharged_request">Discharged
                                        Request</label>
                                </div>
                                <div
                                    class="custom-control custom-radio custom-control-inline text-center align-items-center">
                                    <input type="radio" id="discharged" name="pat_status"
                                        class="custom-control-input" value="10">
                                    <label class="custom-control-label text-primary" for="discharged">Discharged
                                    </label>
                                </div>
                            </div>
                        </div>
                        <div class="card-body">
                            <div class="form-row justify-content-between align-items-center border-bottom mb-2">

                                <div class="col-md-3">
                                    <div class="form-group ">
                                        <label class="col-form-label col-form-label-sm" for="nurse_station">Nurse
                                            Station</label>
                                        <select class="form-control form-control-sm select2" id="nurse_station"
                                            name="nurse_station">
                                            <option value="">Select Nurse Station</option>
                                            @if (!empty($ipds_nsds))
                                                @foreach ($ipds_nsds as $ipds_ns)
                                                    <option value="{{ $ipds_ns->nsds_no_pk }}">
                                                        {{ $ipds_ns->nsds_name }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                                >
                                <div class="col-md-6 justify-content-end d-flex">

                                    <div class="form-group mt-3">

                                        <a href="{{ route('ipd-daily-followup-list') }}"
                                            rel="tab"class="btn btn-md btn-success btn-md-global">Followup Work
                                            List</a>
                                        {{-- <a href="{{ route('ipd.medication-list') }}"
                                            rel="tab"class="btn btn-md btn-success btn-md-global">Medication
                                            List</a> --}}
                                    </div>

                                </div>
                            </div>

                            <div class="form-row">
                                <div class="col-12 table-responsive" style="overflow-x: unset;">
                                    <table
                                        class="table data-table border table-striped table-bordered table-hover mb-0">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th class="text-center">SL</th>
                                                <th class="text-center">Patient Name</th>
                                                <th class="text-center">Prescription ID</th>
                                                <th class="text-center">Adm. Date</th>
                                                <th class="text-center">Adm. ID</th>
                                                <th class="text-center">Department</th>
                                                <th class="text-center">Ward Name</th>
                                                <th class="text-center">Bed Name</th>
                                                <th class="text-center">Doctor Name</th>
                                                <th class="text-center">Med.</th>
                                                <th class="text-center">Inv.</th>
                                                <th class="text-center">Ser.</th>
                                                <th class="text-center">OT</th>
                                                <th class="text-center">Actions</th>
                                                <th class="text-center" style="display:none; width: 0px;"></th>
                                                <th class="text-center" style="display:none; width: 0px;"></th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @if (!empty($icu_rcvPatients))
                                                @foreach ($icu_rcvPatients as $rcvPat)
                                                    <tr>
                                                        <td class="text-center">{{ $loop->iteration }}</td>
                                                        <td class="text-left">
                                                            <div
                                                                class="participent_info d-flex align-items-center">
                                                                <div class="participent_img">
                                                                    @if (!empty($rcvPat->patient_photo))
                                                                        <img class="w-100"
                                                                            src="{{ asset('images/uploads/patient_images/thumb/') }}/{{ $rcvPat->patient_photo }}"
                                                                            alt="">
                                                                    @else
                                                                        <img class="w-100"
                                                                            src="{{ asset('images/doctor.png') }}"
                                                                            alt="">
                                                                    @endif
                                                                </div>

                                                                <div class="participent_details">
                                                                    <span
                                                                        class="d-block">{{ !empty($rcvPat->patient_name) ? $rcvPat->patient_name : '' }}</span>

                                                                </div>
                                                            </div>
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($rcvPat->prescription_uid) ? $rcvPat->prescription_uid : '' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($rcvPat->admission_date) ? date('d/m/Y', strtotime($rcvPat->admission_date)) : '' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($rcvPat->admission_uid) ? $rcvPat->admission_uid : '' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($rcvPat->admitted_department) ? $rcvPat->admitted_dept_name : '' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($rcvPat->ward_name) ? $rcvPat->ward_name : '' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($rcvPat->bed_name) ? $rcvPat->bed_name : 'N/A' }}
                                                        </td>
                                                        <td class="text-left">
                                                            {{ !empty($rcvPat->primary_doctor_name) ? $rcvPat->primary_doctor_name : 'N/A' }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ !empty($rcvPat->no_of_medicine) ? $rcvPat->no_of_medicine : 0 }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ !empty($rcvPat->investigation_count) ? $rcvPat->investigation_count : 0 }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ !empty($rcvPat->service_count) ? $rcvPat->service_count : 0 }}
                                                        </td>
                                                        <td class="text-right">
                                                            {{ !empty($rcvPat->ot_count) ? $rcvPat->ot_count : 0 }}
                                                        </td>
                                                        <td class="text-center btn__gap">
                                                            {{-- <a type="button" class="btn btn-success btn-sm"
                                                                data-title="Admitted Patient Details"
                                                                target="_blank"
                                                                href="{{ route('ipd.nicu-station-patient-notes', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">
                                                                NICU Notes
                                                            </a> --}}
                                                            <a type="button" class="btn btn-success btn-sm"
                                                                data-title="Admitted Patient Details"
                                                                target="_blank"
                                                                href="{{ route('ipd.nurse-station-patient-details', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">
                                                                Details
                                                            </a>

                                                            <a href="{{ route('ipd.medication-list', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}"
                                                                target="_blank"
                                                                class="btn btn-md btn-primary btn-md-global">Medication
                                                                List</a>


                                                            <button type="button"
                                                                class="btn btn-info btn-sm open-modal"
                                                                data-modal="common-modal-md"
                                                                data-title="Assign Bed"
                                                                data-action="{{ route('ipd.assign-bed', [
                                                                    'adms_no' => $rcvPat->admission_no_pk,
                                                                    'wrd_name' => $rcvPat->ward_name,
                                                                    'wrd_no' => $rcvPat->ward_no_fk,
                                                                    'bed_no' => $rcvPat->curr_bed_no_fk,
                                                                ]) }}"><i
                                                                    class="fas fa-procedures"></i> Bed</button>

                                                            <button type="button"
                                                                class="btn btn-info btn-sm open-modal"
                                                                data-modal="common-modal-sm"
                                                                data-title=" Daily Followup"
                                                                data-action="{{ route('ipd.daily-followup', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">
                                                                Daily Followup
                                                            </button>

                                                            <button type="button"
                                                                class="btn btn-info btn-sm open-modal"
                                                                data-modal="common-modal-sm"
                                                                data-title="Diabetic Input"
                                                                data-action="{{ route('ipd.input-diabetic', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">
                                                                Diabetic Input
                                                            </button>

                                                            <button type="button"
                                                                class="btn btn-info btn-sm open-modal"
                                                                data-modal="common-modal-sm"
                                                                data-title="Diet Input"
                                                                data-action="{{ route('ipd.input-diet', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">
                                                                Diet Input
                                                            </button>
                                                            <button type="button"
                                                            class="btn btn-info btn-sm open-modal"
                                                            data-modal="common-modal-sm"
                                                            data-title="Cafeteria Input"
                                                            data-action="{{ route('ipd.input-cafeteria', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">
                                                            Cafeteria Input
                                                        </button>
                                                            <button type="button"
                                                                class="btn btn-info btn-sm open-modal"
                                                                data-modal="common-modal-sm"
                                                                data-title="Diet Input"
                                                                data-action="{{ route('ipd.input-oxygen-inhaler', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">
                                                                Input Oxygen Inhaler Form
                                                            </button>


                                                            @if ($rcvPat->dis_ind == 0 && $rcvPat->dis_req_ind == 0)
                                                                <button title="Discharge the Patient"
                                                                    type="button"
                                                                    data-admission-pk="{{ $rcvPat->admission_no_pk }}"
                                                                    class="btn btn-info btn-sm pat-discharge-btn">Discharge
                                                                    Req.</button>
                                                            @endif
                                                            <button class="btn btn-sm btn-primary open-modal"
                                                                data-id="{{ $rcvPat->admission_no_pk }}"
                                                                data-action="{{ route('ipd.patient-history-form', $rcvPat->admission_no_pk) }}"
                                                                data-modal="common-modal-xl"
                                                                data-title="Patient History"
                                                                title="Financial Clearance">
                                                                <i class="fa fa-history" aria-hidden="true"></i>
                                                                Patient History
                                                            </button>

                                                            <a type="button" class="btn btn-info btn-sm "
                                                                title="Aneasthetic Record" target="_blank"
                                                                href="{{ route('ipd.anaesthetic-record-pdf', $rcvPat->admission_uid) }}">
                                                                Aneasthetic Record
                                                            </a>
                                                            <div class="btn-group" role="group">
                                                                <button id="btnGroupDrop2" type="button"
                                                                    class="btn btn-primary btn-sm dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    OT Document
                                                                </button>
                                                                <div class="dropdown-menu"
                                                                    aria-labelledby="btnGroupDrop2">

                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.operation-note-pdf', $rcvPat->admission_uid) }}">Operation
                                                                        Note</a>
                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.pre-anesthetic-checkup-pdf', $rcvPat->admission_uid) }}">Pre
                                                                        Anesthesia Checkup Form</a>
                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.pre-operative-checklist-pdf', $rcvPat->admission_uid) }}">Pre-operative
                                                                        Checklist</a>
                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.high-risk-consent-pdf', $rcvPat->admission_uid) }}">High
                                                                        Risk Consent</a>

                                                                </div>
                                                            </div>

                                                            <a type="button" class="btn btn-success btn-sm "
                                                                data-title="Admitted Patient Details"
                                                                target="_blank"
                                                                href="{{ route('ipd-intake-output.index', ['patient_id' => $rcvPat->patient_no_fk, 'admission_uid' => $rcvPat->admission_uid]) }}">
                                                                Intake Output Form
                                                            </a>
                                                            {{-- <a type="button"
                                                                class="btn btn-md btn-primary btn-md-global"
                                                                data-modal="common-modal" data-title="Vitals Form"
                                                                target="_blank"
                                                                href="{{ route('ipd.nurse-station-vital-details', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">
                                                                Vitals Form
                                                            </a> --}}
                                                            <a type="button"
                                                                class="btn btn-md btn-info btn-md-global"
                                                                data-modal="common-modal"
                                                                data-title="Supporting Chart Form" target="_blank"
                                                                href="{{ route('ipd.ipd-supporting-form', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">
                                                                Supporting Chart Form
                                                            </a>
                                                            {{-- <a type="button"
                                                                class="btn btn-md btn-primary btn-md-global"
                                                                data-modal="common-modal"
                                                                data-title="Breast Feeding Form" target="_blank"
                                                                href="{{ route('ipd.breast-feeding-form', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">
                                                                Breast Feeding Form (Nursery/NICU)
                                                            </a> --}}

                                                            <a type="button"
                                                                class="btn btn-md btn-info btn-md-global"
                                                                data-modal="common-modal" data-title="CBG Form"
                                                                target="_blank"
                                                                href="{{ route('ipd.cbg-form', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">
                                                                CBG Form
                                                            </a>

                                                            @if ($rcvPat->admitted_dept_name == 'GYNAE & OBSTETRICS')
                                                                <span type="button"
                                                                    class="btn btn-success btn-sm open-modal"
                                                                    data-id="{{ $rcvPat->admission_no_pk }}"
                                                                    data-action="{{ route('patient-birth-certificate-report', $rcvPat->admission_uid) }}"
                                                                    data-modal="common-modal-md"
                                                                    data-title="Birth Certificate"><i
                                                                        class="fa fa-baby" aria-hidden="true"></i>
                                                                    Birth
                                                                    Certificate</span>
                                                            @endif


                                                            <span type="button"
                                                                class="btn btn-danger btn-sm open-modal"
                                                                data-id="{{ $rcvPat->admission_no_pk }}"
                                                                data-action="{{ route('patient-death-certificate-report', $rcvPat->admission_uid) }}"
                                                                data-modal="common-modal-md"
                                                                data-title="Death Certificate"><i
                                                                    class="fa fa-wheelchair"
                                                                    aria-hidden="true"></i> Death
                                                                Certificate</span>


                                                            {{-- <span type="button"
                                                                class="btn btn-danger btn-sm open-modal"
                                                                data-id="{{ $rcvPat->admission_no_pk }}"
                                                                data-action="{{ route('patient-death-certificate-report', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}"
                                                                data-modal="common-modal-md"
                                                                data-title="Death Certificate"><i
                                                                    class="fa fa-wheelchair"
                                                                    aria-hidden="true"></i> Death
                                                                Certificate</span> --}}


                                                            <div class="btn-group" role="group">
                                                                <button id="btnGroupDrop1" type="button"
                                                                    class="btn btn-primary btn-sm dropdown-toggle"
                                                                    data-toggle="dropdown" aria-haspopup="true"
                                                                    aria-expanded="false">
                                                                    Reports
                                                                </button>
                                                                <div class="dropdown-menu"
                                                                    aria-labelledby="btnGroupDrop1">

                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.pat-vitals-report', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">Vital
                                                                        Report</a>

                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.patient-history-print', $rcvPat->admission_uid) }}">Patient
                                                                        History PDF</a>

                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.pat-consultant-report', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">Consultant
                                                                        Visit PDF</a>

                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.pat-medication-chart-report', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">Medication
                                                                        Chart PDF</a>

                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.pat-temperature-report', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">Temparature
                                                                        Chart PDF</a>

                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.nurse-round-list-report', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">Round
                                                                        List Report PDF</a>
                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.patient-intake-output-chart', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">Intake
                                                                        Output Chart PDF</a>

                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.patient-daily-followup-statement', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">Daily
                                                                        Followup Statement PDF</a>

                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.diabetic-chart-pdf', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">Diabetics
                                                                        PDF</a>

                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.diet-pdf', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">Diet
                                                                        PDF</a>
                                                                        <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.cafeteria-pdf', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">Cafeteria
                                                                        PDF</a>

                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.oxygen-inhaler-pdf', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">Oxygen
                                                                        Saturation
                                                                        PDF</a>

                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.doctor-patient-visit', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">Doctor
                                                                        Patient Visit PDF</a>

                                                                    {{-- <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.nicu-vitals-report', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">
                                                                        Report</a> --}}
                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.patient-intake-output-chart', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">Intake
                                                                        Output Report</a>
                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.supporting-report', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">Supporting
                                                                        Report</a>

                                                                    {{-- <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.breast-feeding-report', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">Breast
                                                                        Feeding Report</a> --}}
                                                                    <a type="button" class="dropdown-item"
                                                                        target="_blank"
                                                                        href="{{ route('ipd.cbg-report', [$rcvPat->patient_no_fk, $rcvPat->admission_uid]) }}">CBG
                                                                        Report</a>

                                                                </div>
                                                            </div>
                                                        </td>

                                                    </tr>
                                                @endforeach
                                            @endif
                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function() {
        // SideBar Collapse
        $("body").addClass("sidebar-collapse");

        var table = $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": true,
            "bLengthChange": false,
            "bAutoWidth": false
        });

        $('.date-picker').datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });

        $.fn.dataTable.ext.search.push(
            function(settings, searchData, index, rowData, counter) {

                var offices = $('input:radio[id="admitted"]:checked').map(function() {
                    return this.value;
                }).get();

                if (offices.length === 0) {
                    return true;
                }
                if (offices.indexOf(searchData[14]) !== -1) {
                    return true;
                }

                return false;
            }
        );
        $.fn.dataTable.ext.search.push(
            function(settings, searchData, index, rowData, counter) {

                var offices = $('input:radio[id="discharged_request"]:checked').map(function() {
                    return this.value;
                }).get();

                if (offices.length === 0) {
                    return true;
                }
                if (offices.indexOf(searchData[15]) !== -1) {
                    return true;
                }

                return false;
            }
        );

        $('input:radio').on('change', function() {
            table.draw();
        });

        openPatientAutocomplete('#service_id', 'service_number');
        $('.select2').select2({});


    })

    $(document).on('click', '.pat-discharge-btn', function(e) {
        e.preventDefault()
        var admissionNoPk = parseInt($(this).attr('data-admission-pk'))

        if (!confirm("Are you sure?")) {
            e.stopImmediatePropagation();
            return false
        }
        var response_action = "{{ route('ipd.nurse-station-received-patient') }}"
        $.ajax({
            async: true,
            data: {
                admission_no_pk: admissionNoPk,
            },
            url: "{{ route('ipd.doctor-station-discharge-a-patient') }}",
            type: 'post',
            beforeSend: function() {
                if (isAModalOpen)
                    $('.modal').modal('hide');
                blockUI();
            },
            success: function(data) {
                if (data.title == 'Success') {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.msg);
                }
            },
            error: function(data) {
                var errors = jQuery.parseJSON(data.responseText).errors;
                error_messages = "";
                for (messages in errors) {
                    var field_name = $("#" + messages).siblings("label").html();
                    error_messages += "<div class='alert alert-danger' role='alert'>" +
                        errors[messages] + "</div>";
                }

                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html("Validation Error");
                $('.common-modal-notify-error .modal-body').html(error_messages);

                $.unblockUI();
            }
        }).done(function() {
            $.unblockUI();
            dynamicFunc.afterSaveLoadPage(response_action);
        });
        e.stopImmediatePropagation();

    })
</script>
