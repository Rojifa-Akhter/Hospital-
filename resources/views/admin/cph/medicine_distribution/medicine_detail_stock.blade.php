<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Medicine Stcok Detail</h5>
                <small>Medicine / Medicine Stcok Detail</small>
            </div>
        </div>
        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="date_cashier_wise_data">
                        @include('admin.cph.medicine_distribution.medicine_detail_stock_list')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="text/javascript">
    $('.select2').select2({})
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            // endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');

    $(document).on("click", "#btnSearchReport", function(e) {
        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");

        $("#searchForm").attr('action', "{{ url('report/date-cashier-wise-report-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('report/date-cashier-wise-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#date_cashier_wise_data").html(data);
                $("#searchForm").attr('action',
                    "{{ route('report.date-cashier-wise-report-print') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
