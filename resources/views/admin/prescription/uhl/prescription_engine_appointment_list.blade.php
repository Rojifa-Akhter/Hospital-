<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style type="text/css">
    #prescription_engin .card {
        border: 0 !important;
    }

    table.dataTable thead th,
    table.dataTable thead td {
        padding: 1px 10px !important;
    }

    .dataTables_filter {
        display: none;
    }

    .mb-0 {
        margin-bottom: 0 !important;
    }

    #presc_details .fa {
        font-size: 9px;
    }
</style>

<section id="prescription_engin">
    <div class="container-fluid">
        <div class="row bg-white border-bottom shadow-sm">
            <div class="col">
                <h5 class="mt-2 mb-0"> Prescription Entry {{ $department_id == '' ? ' - External Hospital' : '' }}
                </h5>
                <small>Prescription / Prescription Entry</small>
            </div>
            <div class="col-8">

            </div>
        </div>
        <div class="col-md-12 col-sm-12 p-1 bg-white border-right mt-3">
            <div class="card border-0">
                <div class="card-body">
                    <nav>
                        <div class="nav nav-tabs" id="nav-tab" role="tablist">
                            <a class="nav-link active" id="home-tab" data-toggle="tab" href="#pending" role="tab"
                                aria-controls="home" aria-selected="true">
                                Pending &nbsp;
                                <span class="badge badge-warning">{{ $pending_ind }}</span>
                            </a>
                            <a class="nav-link" id="home-tab" data-toggle="tab" href="#completed" role="tab"
                                aria-controls="home" aria-selected="true">
                                Completed &nbsp;
                                <span class="badge badge-success">{{ $prescription_ind }}</span>
                            </a>
                            <div class="ml-auto">
                                <input type="text" class="form-control" style="margin-bottom: 0 !important;"
                                    id="txtSearchPat" placeholder="Search Patient" aria-label="PatientName"
                                    aria-describedby="basic-addon1">
                            </div>
                        </div>
                    </nav>
                </div>


                <div class="tab-content p-0 ml-2 mr-2 mt-0" id="nav-tabContent" style="">
                    <div class="tab-pane fade show active border-bottom" id="pending" role="tabpanel"
                        aria-labelledby="pending-tab">

                        <form method="post" id="receive_list_form" action="">
                            @csrf

                            <div class="card mt-2">
                                <div class="card-header">
                                    <h5> <i class="fa fa-search"></i> Search</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">

                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="patient_code" class="col-form-label col-form-label-sm">
                                                    UHID</label>
                                                <input class="form-control form-control-sm " type="text"
                                                    id="patient_code" name="patient_code" value=""
                                                    placeholder="UHID">
                                                <input type="hidden" class="form-control" id="hdn_patient_id"
                                                    name="hdn_patient_id" />
                                            </div>
                                        </div>
                                        {{-- @if (Session::get('user.ses_hospital_code') == 'UNICO') --}}
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="col-form-label col-form-label-sm"
                                                        for="search_date_from">Date</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">From</div>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 date_picker"
                                                            id="search_date_from" name="search_date_from"
                                                            value="{{ date('d-m-Y') }}" placeholder="dd-mm-yyyy"
                                                            autocomplete="off" required>
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">To</div>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 date_picker"
                                                            id="search_date_to" name="search_date_to"
                                                            value="{{ date('d-m-Y') }}" placeholder="dd-mm-yyyy"
                                                            autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- @endif --}}
                                        <div class="col-3">
                                            <span class="btn btn-md btn-success mt-4" id="receive_list_search"
                                                tab_type='Prescribed' onclick="searchAppPatinet()"> <i
                                                    class="fa fa-search mr-1"></i> Search</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="patient_name"></div>
                        <div id="appointed_list">
                            @include('admin.prescription.uhl.doctor_appoinment_search_list')
                        </div>
                    </div>
                    <div class="tab-pane fade border-bottom" id="completed" role="tabpanel"
                        aria-labelledby="completed-tab">
                        {{-- @if (Session::get('user.ses_hospital_code') == 'UNICO') --}}
                        <form method="post" id="receive_list_formcom" action="">
                            @csrf
<input type="hidden" name="type" value="COMPLETED" id="type">
                            <div class="card mt-2">
                                <div class="card-header">
                                    <h5> <i class="fa fa-search"></i> Search</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">

                                        <div class="col-3">
                                            <div class="form-group">
                                                <label for="patient_code_com" class="col-form-label col-form-label-sm">
                                                    UHID</label>
                                                <input class="form-control form-control-sm " type="text"
                                                    id="patient_code_com" name="patient_code_com" value=""
                                                    placeholder="UHID">
                                                <input type="hidden" class="form-control" id="hdn_patient_id_com"
                                                    name="hdn_patient_id_com" />
                                            </div>
                                        </div>
                                        {{-- @if (Session::get('user.ses_hospital_code') == 'UNICO') --}}
                                            <div class="col-6">
                                                <div class="form-group">
                                                    <label class="col-form-label col-form-label-sm"
                                                        for="search_date_from_com">Date</label>
                                                    <div class="input-group">
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">From</div>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 date_picker"
                                                            id="search_date_from_com" name="search_date_from_com"
                                                            value="{{ date('d-m-Y') }}" placeholder="dd-mm-yyyy"
                                                            autocomplete="off" required>
                                                        <div class="input-group-prepend">
                                                            <div class="input-group-text">To</div>
                                                        </div>
                                                        <input type="text"
                                                            class="form-control form-control-sm m-0 date_picker"
                                                            id="search_date_to_com" name="search_date_to_com"
                                                            value="{{ date('d-m-Y') }}" placeholder="dd-mm-yyyy"
                                                            autocomplete="off">
                                                    </div>
                                                </div>
                                            </div>
                                        {{-- @endif --}}
                                        <div class="col-3">
                                            <span class="btn btn-md btn-success mt-4" id="receive_list_search_com"
                                                tab_type='Prescribed' onclick="searchAppCompletedPatinet()"> <i
                                                    class="fa fa-search mr-1"></i> Search</span>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </form>
                        <div id="patient_name_com"></div>
                        {{-- @endif --}}
                        <table class="table data-table table-hover m-0">
                            <thead>
                                <tr>
                                    <th class="text-center w-10">Serial</th>
                                    <th class="text-left"></th>
                                    <th class="text-left">Patient</th>
                                    <th class="text-left">Date</th>
                                    <th class="text-left">App. Type</th>
                                    <th class="text-center w-10">Status</th>
                                </tr>
                            </thead>
                            <tbody id="patientContainer">
                                @include('admin.prescription.uhl.completed_prescription')
                            </tbody>
                        </table>
                    </div>
                    <div class="tab-pane fade" id="absent" role="tabpanel" aria-labelledby="absent-tab">
                        <table class="table data-table table-hover m-0">
                            <thead>
                                <tr>
                                    <th class="text-center w-10">Serial</th>
                                    <th class="text-left"></th>
                                    <th class="text-left">Patient</th>
                                    <th class="text-left">App. Type</th>
                                    <th class="text-center w-10">Status</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($appointment_rs))
                                    @php $i = 1; @endphp
                                    @foreach ($appointment_rs as $row)
                                        @if ($row->prescription_no_pk == '')
                                            @php
                                                if ($row->priority == 'Urgent') {
                                                    $bg_class = 'btn-outline-danger';
                                                } elseif ($row->priority == 'VIP') {
                                                    $bg_class = 'btn-outline-info';
                                                } else {
                                                    $bg_class = 'btn-outline-success';
                                                }

                                                if ($row->appoint_type_code != 'NEWCONS') {
                                                    $bg_class = 'btn-outline-danger';
                                                } else {
                                                    $bg_class = 'btn-outline-success';
                                                }
                                            @endphp
                                            @if ($row->appoint_status == 3)
                                                <tr>
                                                    <td class="text-center p-1 bg-light border-right"><span
                                                            class="btn btn-outline-success btn-sm bg-none cursor-pointer"
                                                            style="font-size:10px;">{{ $row->slot_sl }}</span>
                                                    </td>
                                                    <td class="text-left p-1 w-8 bg-light border-right">
                                                        <span
                                                            class="btn {{ $bg_class }} btn-sm bg-none cursor-pointer btn-block"
                                                            style="font-size:10px;">{{ $row->priority }}</span>
                                                    </td>
                                                    <td class="text-left bg-none p-1">
                                                        {{ $row->patient_name }}
                                                    </td>

                                                    <td class="text-left p-1">
                                                        @if ($row->appoint_type_code == 'NEWCONS')
                                                            <span
                                                                class="btn {{ $bg_class }} btn-sm bg-none cursor-pointer btn-block"
                                                                style="font-size:10px;">New</span>
                                                        @else
                                                            <span
                                                                class="btn {{ $bg_class }} btn-sm bg-none cursor-pointer btn-block"
                                                                style="font-size:10px;">Follow up</span>
                                                        @endif
                                                    </td>
                                                    <td class="text-center p-1 bg-light">
                                                        <span
                                                            class="btn btn-outline-primary btn-sm bg-none cursor-pointer"
                                                            data-presc="{{ $row->prescription_no_pk }}"
                                                            data-dtls-action="{{ route('get-prev-prescription-dtls', $row->patient_no_pk) }}"
                                                            data-action="{{ route('get-prescription-mst', [$row->appoint_no_pk, $row->patient_no_pk, $row->prescription_no_pk]) }}"
                                                            onclick="prescriptionFunc.patientPrescriptionDetails(this)"
                                                            title="Create New Prescription">
                                                            <i class="fa fa-prescription"></i>
                                                        </span>
                                                    </td>
                                                </tr>
                                            @endif
                                            @php $i++; @endphp
                                        @endif
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
</section>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        // endDate: '+0d',
        'format': 'dd-mm-yyyy'
    });

    function openInNewTab(element) {
        var url = element.getAttribute('data-action');
        var win = window.open(url, '_blank');
        win.focus();
    }
    // $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");

    openPatientAutocomplete('#patient_code', 'hdn_patient_id', function(item, obj) {
        $('#patient_name').html(item.patient_name);
        console.log(item)
        // var patient_info_route = "{{ route('prescription.get-patient-info') }}";

        // var dtls_action = "{{ route('get-prev-prescription-dtls', ':id') }}";
        // var dtlsAction = dtls_action.replace(':id', item.patient_id);
        // prescriptionFunc.getPatientDetails(item.patient_id, patient_info_route, dtlsAction);
        // obj.stopImmediatePropagation();
    });

    openPatientAutocomplete('#patient_code_com', 'hdn_patient_id_com', function(item, obj) {
        $('#patient_name_com').html(item.patient_name);
        console.log(item)
        // var patient_info_route = "{{ route('prescription.get-patient-info') }}";

        // var dtls_action = "{{ route('get-prev-prescription-dtls', ':id') }}";
        // var dtlsAction = dtls_action.replace(':id', item.patient_id);
        // prescriptionFunc.getPatientDetails(item.patient_id, patient_info_route, dtlsAction);
        // obj.stopImmediatePropagation();
    });

    function searchAppPatinet() {
        var patient_id = $('#hdn_patient_id').val();
        var from_date = $('#search_date_from').val();
        var to_date = $('#search_date_to').val();
        if (from_date == "") {
            alert('Enter Appointment Date.');
            return false;
        }
        $.ajax({

            data: {
                patient_id: patient_id,
                from_date: from_date,
                to_date: to_date,
            },
            url: "{{ route('appointments.search-app-list') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                console.log(data)
                $('#appointed_list').html(data);

            },

            complete: function() {
                $.unblockUI();
            }
        });

        e.stopImmediatePropagation();
    }

    function searchAppCompletedPatinet() {
        var patient_id = $('#hdn_patient_id').val();
        var from_date = $('#search_date_from_com').val();
        var to_date = $('#search_date_to_com').val();
        var type = $('#type').val();
        if (from_date == "") {
            alert('Enter Appointment Date.');
            return false;
        }
        $.ajax({
            data: {
                type: type,
                patient_id: patient_id,
                from_date: from_date,
                to_date: to_date,
            },
            url: "{{ route('appointments.search-app-list') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                console.log(data)
                $('#appointed_list').html(data);

            },

            complete: function() {
                $.unblockUI();
            }
        });

        e.stopImmediatePropagation();
    }

    $(document).on("click", ".patapp_absent", function(e) {
        var patapp_id = $(this).siblings('#patapp_hdn').val();
        if (confirm("Are you sure")) {
            $.ajax({

                data: {
                    patapp_id: patapp_id
                },
                url: "{{ route('prescription.appointment-absent') }}",
                type: "get",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    var riderect_action = $("#hdn_current_url").val();
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html("Absent successful");
                    dynamicFunc.afterSaveLoadPage(riderect_action);
                },

                complete: function() {
                    $.unblockUI();
                }
            });
        }
        e.stopImmediatePropagation();

    })

    $(document).ready(function() {
        var patTable = $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bInfo": false,
            "bAutoWidth": false
        });
        $(document).on("keyup", '#txtSearchPat', function() {
            patTable.search($(this).val()).draw();
        });

        $(document).on("keypress", "input", function(e) {
            if (e.which == 13) {
                e.preventDefault();
            }
        });

    });
</script>
