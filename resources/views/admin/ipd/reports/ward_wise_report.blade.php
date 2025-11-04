<style>
    .sticky_header {
        position: sticky;
        top: 90px;

    }
</style>



@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">
                    Ward Wise Report
                </h5>
                <small>Report / Ward Wise Report</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('ward-wise-report-pdf') }}" id="wardSearchForm" method="post" target="_blank">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="col-md-2">
                            <label for="pat_type">Report Type</label>
                            <select class="form-control font_size_12  " id="pat_type" name="pat_type" width="200px">
                                <option value='1'> Admitted Patient </option>
                                <option value='2'> Discharge Patient </option>
                                {{-- <option value='3'> Discharge Request Patient </option> --}}

                            </select>
                        </div>

                        <div class="col-md-2">
                            <label for="ward_name">Ward Name</label>
                            <select class="form-control font_size_12  " id="ward_name" name="ward_name" width="200px">
                                <option value=''> Select Ward </option>
                                @if (!empty($ward))
                                    @foreach ($ward as $key => $data)
                                        <option value='{{ $data->ward_no_pk }}'> {{ $data->ward_name }} </option>
                                    @endforeach
                                @endif
                            </select>
                        </div>
                        <div class="col-md-4">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="search_date_from" name="search_date_from" value="{{ date('d/m/Y') }}"
                                        placeholder="dd/mm/yyyy" autocomplete="off">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="search_date_to" name="search_date_to" value="{{ date('d/m/Y') }}"
                                        placeholder="dd/mm/yyyy" autocomplete="off">
                                </div>
                            </div>
                        </div>
                        <input type="hidden" value="" name="hdn_report_type" id="hdn_report_type">
                        <div class="col-md-4">
                            <div class="btn-group btn-block" role="group">
                                <button type="button" id="ward_search_report_btn"
                                    class="btn btn-md btn-success mt-4"><i class="fa fa-search"></i> Search</button>
                                <button type="submit" id="cashier_report" class="btn btn-md btn-primary mt-4 print"
                                    onclick="exportPDF()">
                                    <i class="fa fa-print"></i> Export PDF</button>
                                <button type="button" id="summary" class="btn btn-info btn-md mt-4"
                                    onclick="exportExcel()"><i class="fa fa-file-excel"></i> Export Excel</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="ward_search_data">
                        @include('admin.ipd.reports.ward_wise_report_worklist')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
    $('#ward_name').select2();
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#ward_search_report_btn", function(e) {
        var formID = $("#wardSearchForm").attr("id");
        var formMethod = $("#wardSearchForm").attr("method");
        $("#wardSearchForm").attr('action', "{{ url('ward-wise-report-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('ward-wise-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#ward_search_data").html(data);
                $("#wardSearchForm").attr('action', "{{ route('ward-wise-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    function exportPDF(element) {
        $("#hdn_report_type").val("PDF");
        $("#wardSearchForm").submit();
    }

    function exportExcel(element) {
        $("#hdn_report_type").val("EXCEL");
        $("#wardSearchForm").submit();
    }
</script>
