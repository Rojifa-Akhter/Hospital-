<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    body {
        display: flex;
        flex: 1;
    }

    th {
        text-orientation: downright;
        writing-mode: vertical-rl;
        flex-wrap: wrap-reverse;
    }

    .bc-head-txt-label,.dt {
        left: calc(50% - .5rem);
        line-height: 1;
        padding-top: .5rem;
        position: relative;
        -webkit-transform: rotate(180deg);
        transform: rotate(180deg);
        white-space: nowrap;
        -webkit-writing-mode: vertical-rl;
        writing-mode: vertical-rl;
    }
</style>

<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Employee Performance Report</h5>
                <small>Report / Employee Performance Report</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <form id="empPerformanceReport" method="post" {{-- action="{{ route('report.Item-Type-Wise-Financial-Report-print') }}" --}}>
                    @csrf
                    <div class="form-group row justify-content-center">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="card_no" class=" col-form-label col-form-label-sm">Cashier Name</label>
                                <input type="text" class="form-control form-control-sm m-0" id="primary_doctor"
                                    name="primary_doctor" maxlength="50" value="" placeholder="Cashier Name" />
                                <input type="hidden" id="doctor_id" name="doctor_id" value="" />
                                <div><strong>
                                        <p id="autocomplete_data"></p>
                                    </strong></div>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <label for="patient_id">Department </label>
                            <select class="form-control font_size_12 m-auto select2" id="dept" name="dept">
                                <option value="">Select Department</option>
                                @if (isset($dept))
                                    @foreach ($dept as $val)
                                        <option value="{{ $val->serviceunit_no_pk }}">
                                            {{ ucwords(strtolower($val->serviceunit_name)) }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="patient_id">Item Type </label>
                            <select class="form-control font_size_12 m-auto select2" id="item_type" name="item_type">
                                <option value="">Select Item Type</option>
                                @if (isset($item_type))
                                    @foreach ($item_type as $val)
                                        <option value="{{ $val->itemtype_no_pk }}">
                                            {{ ucwords(strtolower($val->item_type_name)) }}</option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-3">
                            <div class="row">
                                <div class="col-md-6" style="margin-right: -30px;">
                                    <label for="type">From</label>
                                    <input type="text" class="form-control date_picker" name="date_from"
                                        id="date_from" value="" autocomlete="off" placeholder="From Date" />
                                </div>
                                <div class="col-md-6">
                                    <label for="type">To </label>
                                    <input type="text" class="form-control date_picker" name="date_to" id="date_to"
                                        value="" autocomlete="off" placeholder="To Date" />
                                </div>
                            </div>
                        </div>
                        <div class="col-md-3">
                            <button type="button" id="employee_search_btn"
                                class="btn btn-md btn-success mt-4">Search</button>
                            <button type="submit" id="item_type_wise_report" class="btn btn-md btn-primary mt-4 print"
                                value="1">
                                Export PDF</button>

                            <button type="submit" id="item_type_wise_report_monthly"
                                class="btn btn-md btn-primary mt-4 print" value="2">
                                Export Monthly PDF</button>

                        </div>
                    </div>
                </form>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5>Employee Performance Report List</h5>
            </div>
            <div class="card-body">
                <div class="mt-2" id="emp_table_list">
                    @include('admin.reports.financial.emp_performance_report_table')
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {
        $(function() {
            $('.date_picker').datepicker({
                todayHighlight: true,
                clearBtn: true,
                autoclose: true,
                format: 'dd/mm/yyyy',
                endDate: '+0d',
            });
        });

        $(".select2").select2();
        $("#sidebar-left").addClass("active");
        $("#content").addClass("active");
        openDoctorAutocomplete('#primary_doctor', 'doctor_id');


        $(document).on("click", "#employee_search_btn", function(e) {
            var formID = $("#empPerformanceReport").attr("id");
            var formMethod = $("#empPerformanceReport").attr("method");
            $("#empPerformanceReport").attr('action',
                "{{ url('employee-performance-report-list') }}");
            $.ajax({
                data: $('#' + formID).serialize(),
                url: "{{ url('employee-performance-report-list') }}",
                type: formMethod,
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#emp_table_list").html(data);
                    // $("#empPerformanceReport").attr('action',
                    //     "{{ route('employee-performance-report-pdf') }}");
                    // $("#empPerformanceReport").attr('action',
                    //     "{{ route('employee-performance-report-pdf') }}");
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        });



        $(document).on("click", ".print", function(e) {
            var print = $(this).val();

            if (print == 1) {
                $('form').attr('action',
                    "{{ route('employee-performance-report-pdf') }}");
            }
            if (print == 2) {
                $('form').attr('action',
                    "{{ route('employee-performance-report-pdf-monthly') }}");
            }
        });


    });
</script>
