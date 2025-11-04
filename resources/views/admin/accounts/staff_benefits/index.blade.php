<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<style>
    #total_due:disabled {
        cursor: not-allowed;
        color: #333;
    }

    #btnPayment {
        transition: all 0.2s ease-in-out;
    }

    #btnPayment:hover {
        transform: translateY(-2px);
        box-shadow: 0 4px 10px rgba(0, 128, 0, 0.2);
    }
</style>

<section id="full_appointment">
    <div class="container-fluid pb-4">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">Staff Benefits</h5>
                <small>Accounts / Staff Benefits</small>
            </div>
            @php
                $invoice_ref_edit_ind = Session::get('user.ses_invoice_ref_edit_ind');
                $hospital_code = Session::get('user.ses_hospital_code');
            @endphp
        </div>
        <input type="hidden" name="invoice_ref_edit_ind" id="invoice_ref_edit_ind" value="{{ $invoice_ref_edit_ind }}">

        <input type="hidden" name="hospital_code" id="hospital_code"
            value="{{ Session::get('user.ses_hospital_code') }}">

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2">
                <form id="frmSearch" method="post" action="{{ route('appointments.appointments_list_print') }}">
                    @csrf

                    <input type="hidden" id="page-view-type" name="page_view_type">

                    <div class="form-group form-row">

                        <div class="col-sm-2">
                            <label for="corporate_name ">Corporate</label>
                            <select class="form-control select2" id="corporate_name" name="corporate_name">
                                <option value="">Select Corporate</option>
                                @if (isset($corporate_info))
                                    @foreach ($corporate_info as $value)
                                        <option value="{{ $value->ccm_client_no_pk }}">{{ $value->ccm_client_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        {{-- <div class="col-sm-2">
                            <label for="service_point ">Service Point</label>
                            <select class="form-control select2" id="service_point" name="service_point" required>
                                <option disabled value="">Select Service Point</option>
                                @if (!empty($service_point))
                                    @foreach ($service_point as $value)
                                        <option value="{{ $value->serviceunit_no_pk }}">{{ $value->serviceunit_name }}
                                        </option>
                                    @endforeach
                                @endif
                            </select>
                        </div> --}}

                        <div class="col-sm-2">
                            <label for="patient_id">Patient </label>
                            <input type="text" class="form-control" id="patient_id" name="patient_id"
                                placeholder="MRN/Name/Mobile" title="Search By MRN/ Name/ Mobile" />
                            <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                        </div>

                        <div class="col-sm-2">
                            <label for="admission_id">Admission</label>
                            <input type="text" class="form-control" id="admission_id" name="admission_id"
                                placeholder="Admission Code" title="Admission Code" />
                        </div>

                        <div class="col-sm-2">
                            <label for="doctor_code">Doctor</label>
                            <input type="text" class="form-control" id="doctor_code" name="doctor_code"
                                placeholder="Code/Name/Mobile/SPL."
                                title="Search by Code/ Name/ Mobile/ Specialization">
                            <input type="hidden" class="form-control" id="hdn_doctor_id" name="hdn_doctor_id">
                        </div>

                        <div class="col-sm-2">
                            <label for="app_date">Invoice ID</label>
                            <input type="text" class="form-control " name="invoice_id" id="app_date"
                                autocomlete="off" placeholder="Invoice ID" />
                        </div>

                        <div class="col-sm-2">
                            <label for="date_from">From Date</label>
                            <input type="text" class="form-control date_picker" name="date_from" id="date_from"
                                placeholder="From Date" autocomplete="off" />
                        </div>

                        <div class="col-sm-2">
                            <label for="date_to">To Date</label>
                            <input type="text" class="form-control date_picker" name="date_to" id="date_to"
                                placeholder="To Date" autocomplete="off" />
                        </div>

                        <div class="col-sm-2">
                            <label for="bill_type ">Bill Type</label>
                            <select class="form-control select2" id="bill_type" name="bill_type">
                                <option value="">Select Bill Type</option>
                                <option value="all_paid">All Bill</option>
                                <option value="full_paid">Full Paid</option>
                                <option value="due_bill">Due Bill</option>
                            </select>
                        </div>

                        <div class="col-sm-4 mt-4">
                            <div class="d-flex" style="gap: 10px">
                                <button type="button" class="btn btn-success btn-md btn-md-global"
                                    id="btnSearchReport">
                                    <i class="fa fa-search"></i>
                                    Search
                                </button>

                                <button type="reset" class="btn btn-info btn-md btn-md-global" id="btnReset"
                                    onclick="window.location.reload();">
                                    <i class="fa fa-redo"></i>
                                    Reset
                                </button>

                                <button type="button" class="btn btn-primary btn-md btn-md-global"
                                    id="btnPdfReport">
                                    <i class="fa fa-file-pdf"></i>
                                    Export PDF
                                </button>
                            </div>
                        </div>
                    </div>
                    <div class="form-group form-row">
                        <div class="col-sm-4">
                            <label for="op_due">OP Due</label>
                            <input type="text" class="form-control" id="op_due" name="op_due"
                                placeholder="OP Due" title="OP " disabled
                                style="background-color: #dbdbdb !important" />
                        </div>

                        <div class="col-sm-4">
                            <label for="ip_due">IP Due</label>
                            <input type="text" class="form-control" id="ip_due" name="ip_due"
                                placeholder="IP Due" title="IP Due" disabled
                                style="background-color: #dbdbdb !important" />
                        </div>

                        <div class="col-sm-4">
                            <label for="er_due">ER Due</label>
                            <input type="text" class="form-control" id="er_due" name="er_due"
                                placeholder="ER Due" title="ER Due" disabled
                                style="background-color: #dbdbdb !important" />
                        </div>
                    </div>

                    <div class="form-group form-row align-items-end mt-3">
                        <!-- Total Due -->
                        <div class="col-sm-6 col-md-4">
                            <label for="total_due" class="font-weight-bold mb-1">Total Due</label>
                            <div class="input-group">
                                <span class="input-group-text bg-light border-end-0">
                                    <span class="text-success">৳</span>
                                </span>
                                <input type="text" class="form-control border-start-0" id="total_due"
                                    name="total_due" placeholder="Total Due" title="Total Due" disabled
                                    style="background-color: #f9f9f9 !important; font-weight: 600;" />
                            </div>
                        </div>

                        <!-- Save Button -->
                        <div class="col-sm-6 col-md-4 mt-3 mt-sm-0">
                            <button type="button" class="btn btn-success btn-md btn-md-global w-100 shadow-sm"
                                id="btnPayment" onclick="savePayment()" disabled>
                                <i class="fa fa-save me-1"></i> Create Credit Note
                            </button>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <ul class="nav nav-tabs nav-fill mt-4 mb-2 pt-0 pb-0" id="myTab" role="tablist">
            <li class="nav-item">
                <a class="nav-link active" id="opd-tab" data-toggle="tab" href="#opd" role="tab">OPD</a>
            </li>
            <li class="nav-item">
                <a class="nav-link" id="ipd-tab" data-toggle="tab" href="#ipd" role="tab">IPD</a>
            </li>
        </ul>

        <div class="tab-content mt-0 mb-0 pt-0 pb-0" id="myTabContent">
            <!-- OPD -->
            <div class="tab-pane fade show active" id="opd" role="tabpanel" aria-labelledby="opd-tab">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="mt-2 mb-0">OPD Enquiry Activities List</h5>

                            <div style="text-align: center;">
                                <input type="checkbox" id="checkAllOPD" />
                                <label for="checkAllOPD" style="margin-left: 5px;">Check All</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="opdTable"
                                class="table table-bordered table-hover table-striped bill-list-opd w-100">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th>SL</th>
                                        <th>Corporate</th>
                                        <th>MRN</th>
                                        <th>Admission ID</th>
                                        <th>Patient</th>
                                        <th>Invoice No</th>
                                        <th>Invoice Date</th>
                                        <th>Sales</th>
                                        <th>Discount</th>
                                        <th>Collection</th>
                                        <th>Due</th>
                                        <th>Check Box</th>
                                        <th>AMT</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>

            <!-- IPD -->
            <div class="tab-pane fade" id="ipd" role="tabpanel" aria-labelledby="ipd-tab">
                <div class="card">
                    <div class="card-header">
                        <div class="d-flex justify-content-between">
                            <h5 class="mt-2 mb-0">IPD Enquiry Activities List</h5>

                            <div style="text-align: center;">
                                <input type="checkbox" id="checkAllIPD" />
                                <label for="checkAllIPD" style="margin-left: 5px;">Check All</label>
                            </div>
                        </div>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            <table id="ipdTable" class="table table-bordered table-hover table-striped w-100">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th>SL</th>
                                        <th>Corporate</th>
                                        <th>MRN</th>
                                        <th>Admission ID</th>
                                        <th>Admission Date</th>
                                        <th>Patient Name</th>
                                        <th>Bed Name</th>
                                        <th>Discharge Date</th>
                                        <th>Sales</th>
                                        <th>Payment</th>
                                        <th>Discount</th>
                                        <th>Due</th>
                                        <th>Check Box</th>
                                        <th>AMT</th>
                                        <th>Action</th>
                                    </tr>
                                </thead>
                                <tbody>

                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="//cdn.datatables.net/plug-ins/1.10.11/sorting/date-eu.js" type="text/javascript"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
@php
    $p_route = isset($row->patient_no_pk) ? route('patient-card', $row->patient_no_pk) : '#';
@endphp

<script>
    openInvoiceAutocomplete("#app_date");

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    });

    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });

    $('.select2').select2();
    openPatientAutocomplete('#patient_id');
    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id');

    var date = new Date();
    var today = new Date(date.getFullYear(), date.getMonth(), date.getDate());

    function numberWithCommas(x) {
        return x.toString().replace(/\B(?=(\d{3})+(?!\d))/g, ",");
    }

    var edit_ind = "";

    $(document).ready(function() {
        let opdDatatable = $('#opdTable').DataTable({
            "searching": true,
            "processing": true,
            "serverSide": true,
            "lengthMenu": [500, 600, 700, 800, 900, 1000],
            "order": [
                [3, "desc"]
            ],
            "ajax": {
                "url": "{{ route('staff-benefits.opd-list') }}",
                "dataType": "json",
                "type": "post",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": getOpdColumnDefs(),
        });

        let ipdDatatable = $('#ipdTable').DataTable({
            "searching": true,
            "processing": true,
            "serverSide": true,
            "lengthMenu": [500, 600, 700, 800, 900, 1000],
            "order": [
                [3, "desc"]
            ],
            "ajax": {
                "url": "{{ route('staff-benefits.ipd-list') }}",
                "dataType": "json",
                "type": "post",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": getIpdColumnDefs(),
        });

        $('a[data-toggle="tab"]').on('shown.bs.tab', function(e) {
            let target = $(e.target).attr("href");

            $('.row-checkbox').prop('checked', false);
            $('.row-input').val('');

            $('#checkAllOPD').prop('checked', false);
            $('#checkAllIPD').prop('checked', false);

            $('#btnSaveOPD').prop('disabled', true);
            $('#btnSaveIPD').prop('disabled', true);
            $('#btnPayment').prop('disabled', true);
            $('#total_due').val('');

            if (target === "#opd") {
                $('#opdTable').DataTable().columns.adjust();
                updateTotalDue('opd');
            } else if (target === "#ipd") {
                $('#ipdTable').DataTable().columns.adjust();
                updateTotalDue('ipd');
            }

            $('#btnSearchReport').trigger('click');
        });

        function getOpdColumnDefs() {
            return [{
                    "targets": 0,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `${meta.row + 1}`;
                    }
                },
                {
                    "targets": 1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return row[29] != null ? row[29] : '';
                    }
                },
                {
                    "targets": 2,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `<div style="text-align: center;"><strong>${row[4]}</strong></div>`;
                    }
                },
                {
                    "targets": 3,
                    "type": 'date',
                    "render": function(data, type, row, meta) {
                        return '';
                    }
                },
                {
                    "targets": 4,
                    "type": 'date',
                    "render": function(data, type, row, meta) {
                        return row[5];
                    }
                },
                {
                    "targets": 5,
                    "type": 'date',
                    "render": function(data, type, row, meta) {
                        return `<div style="text-align: center;">${row[2]}</div>`;
                    }
                },
                {
                    "targets": 6,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var date = new Date(row[3]);
                        var date_str = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
                        return `${date_str}`;
                    }
                },
                {
                    "targets": 7,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `<div style="text-align:right;">${row[35]}</div>`;
                    }
                },
                {
                    "targets": 8,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `<div style="text-align:right;">${row[25]}</div>`;
                    }
                },
                {
                    "targets": 9,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `<div style="text-align:right;">${row[14]}</div>`;
                    }
                },
                {
                    "targets": 10,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `<div style="text-align:right;">${row[15]}</div>`;
                    }
                },
                {
                    "targets": 11,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[15] > 0) {
                            let servicePoint = $('#service_point').val() || '';
                            let corporateName = $('#corporate_name').val() || '';

                            return `<div style="text-align: center;">
                                <input type="checkbox" class="row-checkbox"
                                data-row="${meta.row}"
                                data-patient-id="${row[8]}"
                                data-invoice-id="${row[2]}"
                                data-admission-id="null"
                                data-service-point="${servicePoint}"
                                data-cor-client-id="${corporateName}"
                                data-total-payment="${row[15]}"
                                data-value="${row[15]}"
                                data-tab="opd"/>
                            </div>`;
                        } else {
                            return '';
                        }
                    }
                },
                {
                    "targets": 12,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[15] > 0) {
                            return `<input type="text" class="form-control row-input" data-row="${meta.row}" placeholder=""/>`;
                        } else {
                            return '';
                        }
                    }
                },
            ];
        }

        function getIpdColumnDefs() {
            return [{
                    "targets": 0,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `${meta.row + 1}`;
                    }
                },
                {
                    "targets": 1,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return row[11] != null ? row[11] : '';
                    }
                },
                {
                    "targets": 2,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `<div style="text-align: center;"><strong>${row[9]}</strong></div>`;
                    }
                },
                {
                    "targets": 3,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `<div style="text-align: center;">${row[3]}</div>`;
                    }
                },
                {
                    "targets": 4,
                    "data": "date",
                    "render": function(data, type, row, meta) {
                        var date = new Date(row[0]);
                        var date_str = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
                        return `${date_str}`;
                    }
                },
                {
                    "targets": 5,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return row[2];
                    }
                },
                {
                    "targets": 6,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return row[10];
                    }
                },
                {
                    "targets": 7,
                    "type": 'Edit',
                    "render": function(data, type, row, meta) {
                        if (row[4] == null || row[4] == '') {
                            return '';
                        }
                        var date = new Date(row[4]);
                        var date_str = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
                        return `${date_str}`;
                    }
                },
                {
                    "targets": 8,
                    "type": 'Edit',
                    "render": function(data, type, row, meta) {
                        return `<div style="text-align:right;">${row[5]}</div>`;
                    }
                },
                {
                    "targets": 9,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `<div style="text-align:right;">${row[6]}</div>`;
                    }
                },
                {
                    "targets": 10,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `<div style="text-align:right;">${row[8]}</div>`;
                    }
                },
                {
                    "targets": 11,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        let number = parseFloat(row[7]).toFixed(2);
                        return `<div style="text-align:right;">${number}</div>`;
                    }
                },
                {
                    "targets": 12,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[7] > 0) {
                            let servicePoint = $('#service_point').val() || '';
                            let corporateName = $('#corporate_name').val() || '';

                            return `<div style="text-align: center;">
                                <input type="checkbox" class="row-checkbox"
                                data-row="${meta.row}"
                                data-patient-id="${row[1]}"
                                data-invoice-id="null"
                                data-admission-id="${row[3]}"
                                data-service-point="${servicePoint}"
                                data-cor-client-id="${corporateName}"
                                data-total-payment="${row[7]}"
                                data-value="${row[7]}"
                                data-tab="ipd"/>
                            </div>`;
                        } else {
                            return '';
                        }
                    }
                },
                {
                    "targets": 13,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        if (row[7] > 0) {
                            return `<input type="text" class="form-control row-input" data-row="${meta.row}" placeholder=""/>`;
                        } else {
                            return '';
                        }
                    }
                },
                {
                    "targets": 14,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        var url = "{{ route('ipd.ipd-summary-bill-print', ':id') }}";
                        url = url.replace(':id', row[3]);
                        return `<a href="${url}" class="btn btn-primary btn-sm" target="_blank" role="button"><i class="fa fa-file-alt"></i></a>`;
                    }
                },
            ];
        }

        function getOutstanding(current_patient_id, corporate_name) {
            $.ajax({
                url: "{{ route('get-mrn-outstanding') }}",
                type: 'POST',
                data: {
                    hdn_patient_id: current_patient_id,
                    corporate_client_id: corporate_name,
                    _token: '{{ csrf_token() }}'
                },
                success: function(data) {
                    console.log(data);
                    $('#op_due').val(data.op_amount);
                    $('#ip_due').val(data.ip_amount);
                    $('#er_due').val(data.er_amount);
                },
                error: function(xhr, status, error) {
                    console.error(error);
                    alert('Something went wrong while fetching outstanding amounts.');
                },
            });
        }

        function getSearchParams() {
            return {
                invoice_id: $('input[name="invoice_id"]').val(),
                hdn_patient_id: $('input[name="hdn_patient_id"]').val(),
                hdn_doctor_id: $('input[name="hdn_doctor_id"]').val(),
                admission_id: $('input[name="admission_id"]').val(),
                patient_type_no: $('#deptor_type').find(":selected").val(),
                bill_type: $('#bill_type').val(),
                date_to: $('input[name="date_to"]').val(),
                date_from: $('input[name="date_from"]').val(),
                corporate_name: $('#corporate_name').find(":selected").val(),
                full_paid: $('#full_paid').is(':checked') ? $('input[name="full_paid"]').val() : '',
                due_bill: $('#due_bill').is(':checked') ? $('input[name="due_bill"]').val() : '',
                all_paid: $('#all_paid').is(':checked') ? $('input[name="all_paid"]').val() : '',
                _token: "{{ csrf_token() }}"
            };
        }

        function reloadOpdTable() {
            $('#opdTable').DataTable().destroy();
            $('#opdTable').DataTable({
                searching: true,
                processing: true,
                serverSide: true,
                lengthMenu: [500, 600, 700, 800, 900, 1000],
                order: [
                    [3, "desc"]
                ],
                ajax: {
                    url: "{{ route('staff-benefits.opd-list') }}",
                    type: "post",
                    data: getSearchParams(),
                    beforeSend: function() {
                        blockUI();
                    },
                    complete: function() {
                        $.unblockUI();
                    }
                },
                columnDefs: getOpdColumnDefs(),
                drawCallback: function() {
                    $('#checkAllOPD').prop('checked', false);
                    $('#checkAllOPD').prop('indeterminate', false);
                }
            });
        }

        function reloadIpdTable() {
            $('#ipdTable').DataTable().destroy();
            $('#ipdTable').DataTable({
                searching: true,
                processing: true,
                serverSide: true,
                lengthMenu: [500, 600, 700, 800, 900, 1000],
                order: [
                    [3, "desc"]
                ],
                ajax: {
                    url: "{{ route('staff-benefits.ipd-list') }}",
                    type: "post",
                    data: getSearchParams(),
                    beforeSend: function() {
                        blockUI();
                    },
                    complete: function() {
                        $.unblockUI();
                    }
                },
                columnDefs: getIpdColumnDefs(),
                drawCallback: function() {
                    $('#checkAllIPD').prop('checked', false);
                    $('#checkAllIPD').prop('indeterminate', false);
                }
            });
        }

        $('body').on('click', '#btnSearchReport', function() {
            let current_patient_id = $('input[name="hdn_patient_id"]').val();
            let corporate_name = $('#corporate_name').find(":selected").val();

            if ((current_patient_id != null && current_patient_id != '') || (corporate_name != null &&
                    corporate_name != '')) {
                getOutstanding(current_patient_id, corporate_name);
            }

            let activeTab = $('#myTab .nav-link.active').attr('id');

            if (activeTab === "opd-tab") {
                reloadOpdTable();
            } else if (activeTab === "ipd-tab") {
                reloadIpdTable();
            }
        });

        // function toggleSaveButton() {
        //     let activeTab = $('#myTab .nav-link.active').attr('id');

        //     if (activeTab === "opd-tab") {
        //         if ($('#opdTable .row-checkbox:checked').length > 0) {
        //             $('#btnSaveOPD').prop('disabled', false);
        //         } else {
        //             $('#btnSaveOPD').prop('disabled', true);
        //         }
        //         $('#btnSaveIPD').prop('disabled', true);
        //     } else if (activeTab === "ipd-tab") {
        //         if ($('#ipdTable .row-checkbox:checked').length > 0) {
        //             $('#btnSaveIPD').prop('disabled', false);
        //         } else {
        //             $('#btnSaveIPD').prop('disabled', true);
        //         }
        //         $('#btnSaveOPD').prop('disabled', true);
        //     }
        // }

        $('#checkAllOPD').on('change', function() {
            let isChecked = $(this).is(':checked');

            $('#opdTable tbody .row-checkbox').each(function() {
                let $checkbox = $(this);
                let rowIndex = $checkbox.data('row');
                let value = parseFloat($checkbox.data('value')).toFixed(2);
                let $input = $(`.row-input[data-row="${rowIndex}"]`);

                if (value > 0) {
                    $checkbox.prop('checked', isChecked);

                    if (isChecked) {
                        $input.val(value);
                    } else {
                        $input.val('');
                    }
                }
            });

            updateTotalDue('opd');
            // toggleSaveButton();
            togglePaymentButton();
        });

        $('#checkAllIPD').on('change', function() {
            let isChecked = $(this).is(':checked');

            $('#ipdTable tbody .row-checkbox').each(function() {
                let $checkbox = $(this);
                let rowIndex = $checkbox.data('row');
                let value = parseFloat($checkbox.data('value')).toFixed(2);
                let $input = $(`.row-input[data-row="${rowIndex}"]`);

                if (value > 0) {
                    $checkbox.prop('checked', isChecked);

                    if (isChecked) {
                        $input.val(value);
                    } else {
                        $input.val('');
                    }
                }
            });

            updateTotalDue('ipd');
            // toggleSaveButton();
            togglePaymentButton();
        });

        $(document).on('change', '.row-checkbox', function() {
            let activeTab = $('#myTab .nav-link.active').attr('id');

            if (activeTab === "opd-tab") {
                updateCheckAllStatus('opd');
            } else if (activeTab === "ipd-tab") {
                updateCheckAllStatus('ipd');
            }

            let rowIndex = $(this).data('row');
            let value = $(this).data('value');
            let input = $(`.row-input[data-row="${rowIndex}"]`);
            let tab = activeTab === "opd-tab" ? 'opd' : 'ipd';

            if ($(this).is(':checked')) {
                input.val(value);
            } else {
                input.val('');
            }

            updateTotalDue(tab);
            // toggleSaveButton();
            togglePaymentButton();
        });

        function updateTotalDue(tab = 'opd') {
            let total = 0;

            $('.row-checkbox:checked').each(function() {
                total += parseFloat($(this).data('value')) || 0;
            });

            if (tab === 'opd') {
                $('#total_due').val("");
                $('#opdTotalDue').text("Total Due: " + total.toLocaleString());
                $('#total_due').val(parseFloat(total).toFixed(2));
            } else if (tab === 'ipd') {
                $('#total_due').val("");
                $('#ipdTotalDue').text("Total Due: " + total.toLocaleString());
                $('#total_due').val(parseFloat(total).toFixed(2));
            }
        }
    });

    function updateCheckAllStatus(tab) {
        let tableId = tab === 'opd' ? '#opdTable' : '#ipdTable';
        let checkAllId = tab === 'opd' ? '#checkAllOPD' : '#checkAllIPD';

        let totalCheckboxes = $(`${tableId} tbody .row-checkbox`).length;
        let checkedCheckboxes = $(`${tableId} tbody .row-checkbox:checked`).length;

        if (totalCheckboxes === 0) {
            $(checkAllId).prop('indeterminate', false);
            $(checkAllId).prop('checked', false);
        } else if (checkedCheckboxes === 0) {
            $(checkAllId).prop('indeterminate', false);
            $(checkAllId).prop('checked', false);
        } else if (checkedCheckboxes === totalCheckboxes) {
            $(checkAllId).prop('indeterminate', false);
            $(checkAllId).prop('checked', true);
        } else {
            $(checkAllId).prop('indeterminate', true);
            $(checkAllId).prop('checked', false);
        }
    }

    // function saveTableData(tableId, tabType) {
    //     let selectedRows = [];

    //     $(`#${tableId} tbody tr`).each(function() {
    //         let checkbox = $(this).find('.row-checkbox');
    //         if (checkbox.is(':checked')) {
    //             let rowInput = $(this).find('.row-input');
    //             selectedRows.push({
    //                 patient_id: checkbox.data('patient-id'),
    //                 invoice_id: checkbox.data('invoice-id'),
    //                 admission_id: checkbox.data('admission-id'),
    //                 patient_id: checkbox.data('patient-id'),
    //                 total_payment: checkbox.data('total-payment'),
    //                 service_point: checkbox.data('service-point'),
    //                 corporate_client_id: checkbox.data('cor-client-id'),
    //                 tab_type: tabType,
    //             });
    //         }
    //     });

    //     if (selectedRows.length === 0) {
    //         alert(`No rows selected in ${tabType.toUpperCase()}!`);
    //         return;
    //     }

    //     $.ajax({
    //         url: "{{ route('billing.due-bill.store') }}",
    //         type: "POST",
    //         data: {
    //             _token: "{{ csrf_token() }}",
    //             rows: selectedRows
    //         },
    //         beforeSend: function() {
    //             blockUI();
    //         },
    //         success: function(response) {
    //             $('.common-modal-notify').modal('show');
    //             $('.common-modal-notify .modal-title').html('Success!!');
    //             $('.common-modal-notify .modal-body').html(response.msg);

    //             if (tabType === 'opd') {
    //                 $('#opdTable').DataTable().ajax.reload(null, false);
    //                 $('#opdTotalDue').text("Total Due: 0");
    //                 $('#total_due').val("");
    //             } else if (tabType === 'ipd') {
    //                 $('#ipdTable').DataTable().ajax.reload(null, false);
    //                 $('#ipdTotalDue').text("Total Due: 0");
    //                 $('#total_due').val("");
    //             }
    //         },
    //         error: function(err) {
    //             let error = err.responseJSON;
    //             $('.common-modal-notify-error').modal('show');
    //             $('.common-modal-notify-error .modal-title').html('Failed');
    //             $('.common-modal-notify-error .modal-body').html(error.message);
    //         },
    //         complete: function() {
    //             $.unblockUI();
    //         }
    //     });
    // }

    $('#btnPdfReport').on('click', function() {
        // let activeTab = $('#myTab .nav-link.active').attr('id');
        // let billType;

        // if (activeTab === "opd-tab") {
        //     billType = 'opd';
        // } else if (activeTab === "ipd-tab") {
        //     billType = 'ipd';
        // } else {
        //     alert('Please select a tab first!');
        //     return;
        // }

        let activeTab = $('#myTab .nav-link.active').attr('id');
        let billType;

        if (activeTab === "opd-tab") {
            billType = 'opd';
        } else if (activeTab === "ipd-tab") {
            billType = 'ipd';
        } else {
            alert('Please select a tab first!');
            return;
        }

        // Get search parameters
        let corporateName = $('#corporate_name').val() || '';
        let patientId = $('#hdn_patient_id').val() || '';

        // Build query string
        let queryParams = new URLSearchParams({
            corporate_name: corporateName,
            patient_id: patientId
        });

        // window.open("/billing/due-bill/" + billType + "/report", "_blank");
        // Open PDF report in new tab with parameters
        window.open("/billing/due-bill/" + billType + "/report?" + queryParams.toString(), "_blank");
    });

    // Calculate total paid amount from all payment methods
    function savePayment() {
        let selectedRows = [];
        let activeTab = $('#myTab .nav-link.active').attr('id');
        let tabType = activeTab === "opd-tab" ? 'opd' : 'ipd';
        let tableId = tabType === 'opd' ? 'opdTable' : 'ipdTable';

        // Collect selected rows data
        $(`#${tableId} tbody tr`).each(function() {
            let checkbox = $(this).find('.row-checkbox');
            if (checkbox.is(':checked')) {
                let rowInput = $(this).find('.row-input');
                let paymentAmount = parseFloat(rowInput.val()) || 0;

                if (paymentAmount > 0) {
                    selectedRows.push({
                        patient_id: checkbox.data('patient-id'),
                        invoice_id: checkbox.data('invoice-id'),
                        admission_id: checkbox.data('admission-id'),
                        service_point: checkbox.data('service-point'),
                        corporate_client_id: checkbox.data('cor-client-id'),
                        total_payment: checkbox.data('total-payment'),
                        payment_amount: paymentAmount,
                        tab_type: tabType,
                    });
                }
            }
        });

        if (selectedRows.length === 0) {
            alert('No rows selected for payment or payment amounts are zero!');
            return;
        }

        // Get payment method data
        // let paymentData = getPaymentMethodData();
        // if (!paymentData) {
        //     return; // Validation failed
        // }

        // Calculate totals
        let totalSelectedAmount = selectedRows.reduce((sum, row) => sum + row.payment_amount, 0);
        // let totalPaidAmount = getTotalPaidAmount(paymentData);

        if (!confirm(`Are you sure you want to save staff benefits?`)) {
            return;
        }
        // Send payment data to server
        $.ajax({
            url: "{{ route('staff-benefits.store') }}",
            type: "POST",
            data: {
                _token: "{{ csrf_token() }}",
                rows: selectedRows,
                // payment_data: paymentData,
                total_amount: totalSelectedAmount,
                // paid_amount: totalPaidAmount,
                tab_type: tabType
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                console.log(response);
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-title').html('Success!!');
                $('.common-modal-notify .modal-body').html(response.msg);

                // Reload the table
                if (tabType === 'opd') {
                    $('#opdTable').DataTable().ajax.reload(null, false);
                    $('#opdTotalDue').text("Total Due: 0");
                    $('#total_due').val("");
                } else {
                    $('#ipdTable').DataTable().ajax.reload(null, false);
                    $('#ipdTotalDue').text("Total Due: 0");
                    $('#total_due').val("");
                }

                // Reset form
                resetPaymentForm();

                // let invoiceNo = response.invoice_no;
                // window.open("/ar-receive-listing/" + invoiceNo + "/details", "_blank");
            },
            error: function(xhr) {
                let error = xhr.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    function resetPaymentForm() {
        $('#total_due').val('');

        $('.row-checkbox').prop('checked', false);
        $('.row-input').val('');
        $('#checkAllOPD').prop('checked', false);
        $('#checkAllIPD').prop('checked', false);
        $('#btnPayment').prop('disabled', true);
    }

    function togglePaymentButton() {
        let hasSelectedRows = $('.row-checkbox:checked').length > 0;
        $('#btnPayment').prop('disabled', !(hasSelectedRows));
    }

    function updateTotalDue(tab = 'opd') {
        let total = 0;

        $('.row-checkbox:checked').each(function() {
            let rowIndex = $(this).data('row');
            let inputValue = parseFloat($(`.row-input[data-row="${rowIndex}"]`).val()) || 0;
            total += inputValue;
        });

        if (tab === 'opd') {
            $('#total_due').val("");
            $('#opdTotalDue').text("Total Due: " + total.toLocaleString());
            $('#total_due').val(parseFloat(total).toFixed(2));
        } else if (tab === 'ipd') {
            $('#total_due').val("");
            $('#ipdTotalDue').text("Total Due: " + total.toLocaleString());
            $('#total_due').val(parseFloat(total).toFixed(2));
        }

        togglePaymentButton();
    }

    $(document).on('input', '.row-input', function() {
        let tab = $('#myTab .nav-link.active').attr('id') === "opd-tab" ? 'opd' : 'ipd';
        updateTotalDue(tab);
    });

    $(document).on('input', '.cash_amount, .check_amount, .card_amount, .mBank_amount', function() {
        togglePaymentButton();
    });
</script>
