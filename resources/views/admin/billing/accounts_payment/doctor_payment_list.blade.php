<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

<section id="full_appointment">
    <div class="container-fluid pb-4">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">Doctors Payment</h5>
                <small>Billing / Doctors Payment</small>
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
                            <label for="doctor ">Doctor</label>
                            <select class="form-control select2" id="doctor" name="doctor" required>
                                <option value="">Select Doctor</option>
                                @if (!empty($doctors))
                                    @foreach ($doctors as $doctor)
                                        <option value="{{ $doctor->acct_subledger_no_pk }}">{{ $doctor->subledger_name }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-sm-2">
                            <label for="date_from">From Date <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control date_picker" name="date_from" id="date_from"
                                placeholder="From Date" autocomplete="off" required/>
                        </div>

                        <div class="col-sm-2">
                            <label for="date_to">To Date <sup class="text-danger">*</sup></label>
                            <input type="text" class="form-control date_picker" name="date_to" id="date_to"
                                placeholder="To Date" autocomplete="off" required/>
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

                                <button type="button" class="btn btn-primary btn-md btn-md-global" id="btnPdfReport">
                                    <i class="fa fa-file-pdf"></i>
                                    Export PDF
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
                        <h5 class="mt-2 mb-0">Doctors Payment List</h5>
                    </div>
                </div>
                <div class="card-body">
                    <div class="table-responsive">
                        <table id="dataTable"
                            class="table table-bordered table-hover table-striped bill-list-opd w-100">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th>SL</th>
                                    <th>Doctor Name</th>
                                    <th>Journal Code</th>
                                    <th>Date</th>
                                    <th>Amount</th>
                                    <th>Action</th>
                                </tr>
                            </thead>
                            <tbody>
                                {{-- Data will be populated by DataTables --}}
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

    $(document).ready(function() {
        const table = $('#dataTable').DataTable({
            processing: true,
            serverSide: true,
            ajax: {
                url: "{{ route('doctor.payment.datatable') }}",
                type: 'POST',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                beforeSend: function() {
                    blockUI();
                },
                complete: function() {
                    $.unblockUI();
                },
                data: function(d) {
                    d.date_from = $('#date_from').val();
                    d.date_to = $('#date_to').val();
                    d.acct_subledger_no_pk = $('#doctor').val();
                },
                error: function (xhr, error, thrown) {
                    console.error("DataTables AJAX Error:", xhr.responseText);
                    alert("Error loading data: " + xhr.status + " " + thrown);
                }
            },
            columns: [{
                    data: 'DT_RowIndex',
                    name: 'DT_RowIndex',
                    orderable: false,
                    searchable: false
                },
                {
                    data: 'subledger_name',
                    name: 'sub.subledger_name'
                },
                {
                    data: 'journal_code',
                    name: 'pay.journal_code'
                },
                {
                    data: 'payment_date',
                    name: 'pay.payment_date'
                },
                {
                    data: 'amount',
                    name: 'pay.amount',
                    className: 'text-end'
                },
                {
                    data: 'action',
                    orderable: false,
                    searchable: false
                },
            ],
            columnDefs: [{
                targets: [3],
                type: 'date-eu'
            }],
            order: [
                [3, 'desc']
            ],
        });
    });

    $('#btnSearchReport').on('click', function() {
        $('#dataTable').DataTable().ajax.reload();
    });

    $('#btnPdfReport').on('click', function() {
        let dateFrom = $('#date_from').val();
        let dateTo   = $('#date_to').val();
        let doctorId = $('#doctor').val();

        if (dateFrom === "" || dateTo === "") {
            alert('Please select date range first!');
            return;
        }

        let queryParams = new URLSearchParams({
            date_from: dateFrom,
            date_to: dateTo,
            doctor_id: doctorId
        });

        window.open("/accounts/doctor/payment-listing/report?" + queryParams.toString(), "_blank");
    });
</script>
