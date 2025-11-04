@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">
                    Department Wise Ipd Patient
                </h5>
                <small>Report / Department Wise Ipd Patient</small>


            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('department-wise-ipd-report-pdf') }}" id="searchFormIpdDepartment" method="post"
                    target="_blank">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="form-row justify-content-center">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                    <div class="input-group">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">Date</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="date" name="date" value="{{ date('d/m/Y') }}"
                                            placeholder="dd/mm/yyyy" autocomplete="off">
                                    </div>
                                </div>
                            </div>

                            <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                            <div class="col-md-8">
                                <div class="btn-group btn-block" role="group">
                                    <button type="button" id="ipd_dept_search" class="btn btn-success btn-md mt-4"><i
                                            class="fa fa-search"></i>
                                        Search</button>

                                    <button type="button" id="IPD" class="btn btn-info btn-md mt-4"
                                        target="_blank" onclick="exportPDFIPD()"><i class="fa fa-print"></i> Export In
                                        Report</button>

                                    <button type="button" id="exportinexcel" onclick="exportexcel(this)"
                                        class="btn btn-primary btn-md mt-4"><i
                                            class="fa
                                                     fa-file-excel"></i>
                                        Export In
                                        Excel</button>

                                </div>
                            </div>
                        </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="deptWiseIpdDt">
                        @include('admin.reports.dept.dept_wise_ipd_report_data')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#ipd_dept_search", function(e) {
        var formID = $("#searchFormIpdDepartment").attr("id");
        var formMethod = $("#searchFormIpdDepartment").attr("method");
        $("#searchFormIpdDepartment").attr('action', "{{ url('department-wise-ipd-report-search-data') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('department-wise-ipd-report-search-data') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#deptWiseIpdDt").html(data);
                $("#searchFormIpdDepartment").attr('action',
                    "{{ route('department-wise-ipd-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    function exportexcel(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#searchFormIpdDepartment").submit();
    }

    function exportPDFIPD(element) {
        console.log('exportPDFIPD')
        $("#hdn_report_type").val("PDF");
        $("#searchFormIpdDepartment").submit();
    }
</script>
