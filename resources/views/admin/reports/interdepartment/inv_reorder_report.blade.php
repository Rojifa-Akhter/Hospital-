@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">
                    Invoice Reorder Level Report
                </h5>
                <small>Report / Invoice Reorder Level Report</small>


            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('pharmacy.inter-department-report-pdf') }}" id="interDepartmentSearchForm"
                    method="post">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="form-row justify-content-center">
                            {{-- <div class="col-md-2">
                                <div class="form-group">
                                    <label for="card_no" class=" col-form-label col-form-label-sm">Item Name</label>
                                    <input type="text" class="form-control form-control-sm m-0  item_element "
                                        id="medicine_item" name="medicine_item" placeholder="Generic / Brand">
                                    <input type="hidden" id="hdn_medicine_item_id" name="hdn_medicine_item_id">
                                </div>
                            </div> --}}
                            <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                            <div class="col-md-4">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" id="interdepartment_search_btn"
                                        class="btn btn-md btn-success btn-block mt-4">Search</button>
                                    <button type="submit" id="cashier_report"
                                        class="btn btn-md btn-primary btn-block mt-4 print" onclick="exportPdfInterdepartment()">
                                        Export PDF</button>
                                    <button type="button" id="summary" class="btn btn-info btn-md mt-4"
                                        onclick="exportExcel()"><i class="fa fa-print"></i> Export
                                        Excel</button>

                                </div>
                            </div>
                        </div>`
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="interdepartment_search_data">
                        @include('admin.reports.inv_reorder_search_data')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript"
    src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    // SideBar Collapse
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');
    openItemAutocomplete("#medicine_item", 'GENERIC','hdn_medicine_item_id');
    $('.data-table').DataTable({
        "lengthMenu": [
            [100],
            [10]
        ]
    });

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#interdepartment_search_btn", function(e) {
        var formID = $("#interDepartmentSearchForm").attr("id");
        var formMethod = $("#interDepartmentSearchForm").attr("method");
        $("#interDepartmentSearchForm").attr('action', "{{ url('pharmacy/inter-department-report-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('pharmacy/inter-department-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#interdepartment_search_data").html(data);
                $("#interDepartmentSearchForm").attr('action',
                    "{{ route('pharmacy.inter-department-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    function exportPdfInterdepartment(element) {
        $("#hdn_report_type").val("PDF");
        $("#interDepartmentSearchForm").submit();
    }

    function exportExcel(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#interDepartmentSearchForm").submit();
    }
</script>
