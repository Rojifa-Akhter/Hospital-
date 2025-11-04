<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

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
                            <label for="debtor_code ">Debtor Code</label>
                            <select class="form-control select2" id="debtor_code" name="debtor_code" required>
                                <option value="">Select Debtor Code</option>
                                @if (!empty($staffBenefitsDtlGroups))
                                    @foreach ($staffBenefitsDtlGroups as $value)
                                        <option value="{{ $value->debtor_code }}">{{ $value->debtor_code }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <label for="debtor_name ">Debtor Name</label>
                            <select class="form-control select2" id="debtor_name" name="debtor_name" required>
                                <option value="">Select Debtor Name</option>
                                @if (!empty($staffBenefitsDtlGroups))
                                    @foreach ($staffBenefitsDtlGroups as $value)
                                        <option value="{{ $value->debtor_code }}">{{ $value->debtor_name }}</option>
                                    @endforeach
                                @endif
                            </select>
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
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="tab-content mt-0 mb-0 pt-0 pb-0" id="myTabContent">
            <div class="card">
                <div class="card-header">
                    <div class="d-flex justify-content-between">
                        <h5 class="mt-2 mb-0">Staff Benefits List</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable"
                            class="table table-bordered table-hover table-striped bill-list-opd w-100">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th>SL</th>
                                    <th>Debtor Code</th>
                                    <th>Debtor Name</th>
                                    <th>Invoice No</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Data populated by Datatable --}}
                            </tbody>
                        </table>
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
        let dataTable = $('#dataTable').DataTable({
            "searching": true,
            "processing": true,
            "serverSide": true,
            "lengthMenu": [25, 50, 75, 100, 200, 300],
            "order": [
                [4, "desc"]
            ],
            "ajax": {
                "url": "{{ route('staff-benefits.listing.data') }}",
                "dataType": "json",
                "type": "post",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": getColumnDefs(),
        });

        function getColumnDefs() {
            return [{
                    "targets": 0,
                    "data": "Edit",
                    "render": function(data, type, row, meta) {
                        return `${meta.row + 1}`;
                    }
                },
                {
                    "targets": 1,
                    "type": 'date',
                    "render": function(data, type, row, meta) {
                        return `<div style="text-align: center; font-weight: bold;">${row[3] === null ? '' : row[3]}</div>`;
                    }
                },
                {
                    "targets": 2,
                    "type": 'date',
                    "render": function(data, type, row, meta) {
                        return `<div>${row[4] === null ? '' : row[4]}</div>`;
                    }
                },
                {
                    "targets": 3,
                    "type": 'date',
                    "render": function(data, type, row, meta) {
                        return `<div style="text-align: center;">${row[0] === null ? '' : row[0]}</div>`;
                    }
                },
                {
                    "targets": 4,
                    "type": 'date',
                    "render": function(data, type, row, meta) {
                        var date = new Date(row[1]);
                        var date_str = ('0' + date.getDate()).slice(-2) + '/' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '/' + date.getFullYear();
                        return `<div style="text-align: center;">${date_str}</div>`;
                    }
                },
                {
                    "targets": 5,
                    "type": 'date',
                    "render": function(data, type, row, meta) {
                        return `<div style="text-align: right;">${row[2] === null ? '' : Number(row[2]).toFixed(2)}</div>`;
                    }
                },
                {
                    "targets": 6,
                    "type": 'date',
                    "render": function(data, type, row, meta) {
                        let url = "{{ route('staff-benefits.listing.details', ':id') }}";
                        url = url.replace(':id', row[0]);

                        let html = `<a href="${url}" target="_blank" class="btn btn-sm btn-success">
                            <i class="fa fa-eye"></i>
                        </a>`;
                        return html;
                    }
                },
            ];
        }

        $('body').on('click', '#btnSearchReport', function() {
            fetchTableData();
        });

        function fetchTableData() {
            $('#dataTable').DataTable().destroy();
            $('#dataTable').DataTable({
                "searching": true,
                "processing": true,
                "serverSide": true,
                "lengthMenu": [25, 50, 75, 100, 200, 300],
                "order": [
                    [4, "desc"]
                ],
                ajax: {
                    url: "{{ route('staff-benefits.listing.data') }}",
                    type: "post",
                    data: getSearchParams(),
                    beforeSend: function() {
                        blockUI();
                    },
                    complete: function() {
                        $.unblockUI();
                    }
                },
                columnDefs: getColumnDefs(),
            });
        }

        function getSearchParams() {
            return {
                date_to: $('input[name="date_to"]').val(),
                date_from: $('input[name="date_from"]').val(),
                debtor_code: $('#debtor_code').find(":selected").val(),
                debtor_name: $('#debtor_name').find(":selected").val(),
                _token: "{{ csrf_token() }}"
            };
        }
    });
</script>
