<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="report_section">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Corporate Performance Report </h5>
                <small>Corporate / Corporate Performance Report </small>
            </div>
        </div>

        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i> Search</h5>
            </div>
            <div class="card-body">
                <form action="{{ route('reports.corporate-performance-report-pdf-v2') }}" id="searchFormMarketing"
                    method="post">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="corporate_name" class=" col-form-label col-form-label-sm">Client
                                    Name</label>
                                <select class="form-control form-control-sm select2" id="corporate_name"
                                    name="corporate_name">
                                    <option value="">Select Corporate</option>
                                    @if (!empty($corporate_names))
                                        @foreach ($corporate_names as $rd)
                                            <option value="{{ $rd->ccm_client_no_pk }}">
                                                {{ $rd->ccm_client_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>


                        <div class="col-md-2">
                            <div class="form-group">
                                <label for="card_no" class=" col-form-label col-form-label-sm">Employee Name</label>
                                <select class="form-control form-control-sm select2" id="signatory_name"
                                    name="signatory_name">
                                    <option value="">Select Employee</option>
                                    @if (!empty($signatory_names))
                                        @foreach ($signatory_names as $rd)
                                            <option value="{{ $rd->signatory_name }}">
                                                {{ $rd->signatory_name }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>
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


                        <div class="col-md-4">
                            <div class="btn-group btn-block" role="group">
                                <input type="hidden" id="print_type" name="print_type">
                                <button type="button" id="corporate_performance_search"
                                    class="btn btn-md btn-success btn-block mt-4">Search</button>
                                <button type="submit" id="corporate"
                                    class="btn btn-md btn-primary btn-block mt-4 print " target="_blank"
                                    data-type="PDF"> Export
                                    PDF</button>

                                {{-- <button type="submit" title="Print corporate List " target="_blank"
                                    class="btn btn-md btn-success btn-block mt-4 pdf_excel"
                                    data-type="EXCEL">Excel</button> --}}

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-body p-2">
                <div class="form-row">
                    <div class="col-md-12" id="corporate_performance_data">
                        @include('admin.corporate.reports.corporate_performance_data')
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    $('.select2').select2();
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');
    // $(document).on('click', '.pdf_excel', function() {
    //     console.log($(this).attr("data-type"));
    //     var pdf = $(this).attr("data-type");
    //     $('#print_type').val(pdf);


    // });

    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            endDate: '+0d',
            'format': 'dd/mm/yyyy'
        });
    });


    $(document).on("click", "#corporate_performance_search", function(e) {
        var formID = $("#searchFormMarketing").attr("id");
        var formMethod = $("#searchFormMarketing").attr("method");
        $("#searchFormMarketing").attr('action', "{{ url('reports/corporate-performance-report-data-v2') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('reports/corporate-performance-report-data-v2') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#corporate_performance_data").html(data);
                $("#searchFormMarketing").attr('action',
                    "{{ route('reports.corporate-performance-report-pdf-v2') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
