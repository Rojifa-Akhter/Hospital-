<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Marketing Team Performance Report </h5>
                <small>Corporate / Marketing Team Performance Report </small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('reports/corporate-marketing-report-pdf') }}" id="searchFormMarketing"
                    method="post">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="col-md-6">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="search_date_from">Date</label>
                                <div class="input-group">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">From</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                                        id="search_date_from" name="search_date_from" value="{{ date('m/Y', strtotime('-3 month')) }}"
                                        placeholder="dd/mm/yyyy" autocomplete="off">
                                    <div class="input-group-prepend">
                                        <div class="input-group-text">To</div>
                                    </div>
                                    <input type="text" class="form-control form-control-sm m-0 date_picker_1"
                                        id="search_date_to" name="search_date_to" value="{{ date('m/Y') }}"
                                        placeholder="dd/mm/yyyy" autocomplete="off">
                                </div>
                            </div>
                        </div>


                        <div class="col-md-4">
                            <div class="btn-group btn-block" role="group">
                                <input type="hidden" id="print_type" name="print_type">
                                <button type="button" id="corporate_marketing_search"
                                    class="btn btn-md btn-success btn-block mt-4">Search</button>
                                <button type="submit" id="corporate"
                                    class="btn btn-md btn-primary btn-block mt-4 print pdf_excel" target="_blank"
                                    data-type="PDF"> Export
                                    PDF</button>

                                <button type="submit" title="Print corporate List " target="_blank"
                                    class="btn btn-md btn-success btn-block mt-4 pdf_excel"
                                    data-type="EXCEL">Excel</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="corporate_data_marketing">
                        @include('admin.corporate.reports.corporate_marketing_data')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="text/javascript">
    $('.select2').select2();
    $(document).on('click', '.pdf_excel', function() {
        console.log($(this).attr("data-type"));
        var pdf = $(this).attr("data-type");
        $('#print_type').val(pdf);


    });

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '-3m',
            // maxDate: '-3M',
            'format': 'mm/yyyy'
        });
         $('.date_picker_1').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            // maxDate: '-3M',
            'format': 'mm/yyyy'
        });
    });


    $(document).on("click", "#corporate_marketing_search", function(e) {
        var formID = $("#searchFormMarketing").attr("id");
        var formMethod = $("#searchFormMarketing").attr("method");
        $("#searchFormMarketing").attr('action', "{{ url('reports/corporate-marketing-report-data') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('reports/corporate-marketing-report-data') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#corporate_data_marketing").html(data);
                $("#searchFormMarketing").attr('action',
                    "{{ route('reports/corporate-marketing-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
