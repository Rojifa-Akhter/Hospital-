@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

{{-- <div class="card">
    <div class="card-header">
        <h5><i class="fa fa-search"></i> Search</h5>
    </div>
    <div class="card-body">
        <form action="{{ route('account.general-payment-report-print') }}" id="general_searchForm" method="post">
            @csrf
            <div class="form-row justify-content-center">
                <div class="form-row justify-content-center">
                    <div class="col-md-6">
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
                    <input type="hidden" value="" name="hdn_report_type_jb" id="hdn_report_type_jb">
                    <div class="col-md-6 mt-2">
                        <div class="btn-group btn-block" role="group">
                            <button type="button" id="general_searchbtn"
                                class="btn btn-md btn-success mt-4">Search</button>
                            <button type="submit" id="pdf" class="btn btn-md btn-primary mt-4 print"
                                onclick="exportPDFpdf()"> Export PDF</button>
                            <button type="button" id="excel" class="btn btn-info btn-md mt-4"
                                onclick="exportExcel()"><i class="fa fa-print"></i> Export
                                Excel</button>

                        </div>
                    </div>
                </div>
        </form>
    </div>
</div> --}}

<div class="card">
   

    <div class="card-body p-2">
        <div class="form-row">
            <div class="col-md-12" id="unwashed_data">
                @include('admin.housekeeping.unwashed_worklist_data')
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });

    $(document).on("click", "#general_searchbtn", function(e) {
        var formID = $("#general_searchForm").attr("id");
        var formMethod = $("#general_searchForm").attr("method");
        $("#general_searchForm").attr('action', "{{ url('account/general-payment-report-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('account/general-payment-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#general_payment_search_data").html(data);
                $("#general_searchForm").attr('action',
                    "{{ route('account.general-payment-report-print') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    function exportExcel(element) {
        $("#hdn_report_type_jb").val("EXCEL");
        $("#general_searchForm").submit();
    }

    function exportPDFpdf(element) {
        $("#hdn_report_type_jb").val("PDF");
        $("#general_searchForm").submit();
    }
</script>
