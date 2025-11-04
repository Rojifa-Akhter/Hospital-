<style>
    .upload_label {
        position: absolute;
        left: 50%;
        top: 100%;
        transform: translate(-50%, 0%);
    }

    label.custom-file-label.form-control.upload_app_label {
        line-height: 1.7;
    }

    .btn-md-global {
        margin-right: 15px;
    }

    .btn-md-global:last-child {
        margin-right: 0;
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <section class="cashier_report">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-9">
                            <h5 class="mt-2 mb-0">Consultant Daily Charge Listing</h5>
                            <small>Reports / Consultant Daily Charge Listing</small>
                        </div>
                    </div>
                </div>
            </div>

            <form action="{{ route('print-doctor-payment-ledger-listing') }}" id="frmSearch" method="post"
                enctype="multipart/form-data" target="_blank">
                @csrf
                <div class="card shadow-sm" style="">
                    <div class="card-body py-3 px-4">
                        <div class="row align-items-end g-2">
                            @php $current_date = date('d-m-Y'); @endphp

                            <div class="col-md-3 col-sm-6">
                                <label for="from_date" class="col-form-label-sm">From Date</label>
                                <input type="text" class="form-control form-control-sm date_picker"
                                    id="from_date" name="from_date" value="{{ $current_date }}">
                            </div>

                            <div class="col-md-3 col-sm-6">
                                <label for="to_date" class="col-form-label-sm">To Date</label>
                                <input type="text" class="form-control form-control-sm date_picker"
                                    id="to_date" name="to_date" value="{{ $current_date }}">
                            </div>

                            @php
                                $primary_doctor_no_fk = '';
                                $primary_doctor_name = '';
                            @endphp

                            <div class="col-md-2 col-sm-6">
                                <label for="doctor_code" class="col-form-label-sm">Doctor Name <span class="text-danger">*</span></label>
                                <input type="hidden" id="hdn_doctor_id" name="doctor_id" value="{{ $primary_doctor_no_fk }}">
                                <input type="text" class="form-control form-control-sm"
                                    id="doctor_code" name="primary_doctor"
                                    value="{{ $primary_doctor_name }}" placeholder="Enter doctor name" required>
                            </div>

                            <div class="col-md-2 col-sm-6">
                                <label for="itemtype_no_fk" class="col-form-label-sm">Item Type</label>
                                <select name="itemtype_no_fk" id="itemtype_no_fk"
                                    class="form-control form-control-sm select2">
                                    <option value="">All</option>
                                    @foreach($itemTypes as $type)
                                        <option value="{{ $type->itemtype_no_fk }}">{{ $type->item_type_name }}</option>
                                    @endforeach
                                </select>
                            </div>
                            <div class="col-md-2 col-sm-6">
                                <label for="doc_pay_status" class="col-form-label-sm">Status</label>
                                <select name="doc_pay_status" id="doc_pay_status"
                                    class="form-control form-control-sm select2">
                                    <option value="">All</option>
                                    <option value="1">Paid</option>
                                    <option value="2">Due</option>
                                </select>
                            </div>
                        </div>

                        <div class="text-right mt-3">
                            <button type="button" class="btn btn-sm btn-success me-2" id="searCashierReport">Search</button>
                            <button type="submit" class="btn btn-sm btn-info me-2" id="PDF" name="PDF" value="PDF">Export PDF</button>
                            <button type="submit" class="btn btn-sm btn-dark" name="Excel" value="Excel">Export Excel</button>
                        </div>
                    </div>
                </div>
            </form>

            <form action="#" id="" method="post">
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="table-responsive" id="cashier_report_list">
                                    @include('admin.reports.payment_container_listing')
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>
        </div>
        </div>
    </section>
</main>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();
    });

    $('.data-table').DataTable({
        "ordering": true,
        "searching": true,
        "lengthMenu": [10, 20, 50, 75, 100],
        "pageLength": 20, // Number of entries to display per page

    });

    // $("body").addClass("sidebar-collapse");
    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    $(document).on("click", "#searCashierReport", function(e) {

        // Get doctor name and ID values
        var doctorName = $("#doctor_code").val().trim();
        var doctorId = $("#hdn_doctor_id").val().trim();

        // Basic validation
        if (!doctorName || !doctorId) {
            alert("Please select a Doctor Name before searching.");
            return; // Stop AJAX if validation fails
        }

        var formID = $("#frmSearch").attr("id");
        var formMethod = $("#frmSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('/doctor-payment-ledger-listing-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#cashier_report_list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
        e.stopImmediatePropagation();
    });


    openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id', 'doctor_ind', '1,2');
</script>
