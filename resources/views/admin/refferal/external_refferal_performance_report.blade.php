<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<main id="page-content">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">External Referral Performance Report</h5>
                        <small>Referral / External Referral Performance Report</small>
                    </div>
                </div>
                <form method="post" id="searchExternalReferralPerformanceForm" action="">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-body p-2">
                                    <div class="form-row">
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label for="date" class="col-form-label">Date</label>
                                                <div class="input-group">
                                                    <input type="text" class="form-control date_picker" name="date_from"
                                                    autocomplete="off" placeholder="From Date" value="{{date('d-m-Y')}}"/>
                                                    <input type="text" class="form-control date_picker" name="date_to"
                                                    autocomplete="off" placeholder="To Date"  value="{{date('d-m-Y')}}"/>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="referral_id" class="col-form-label">Referral Name</label>
                                                <select class="form-control form-control-sm  select2"
                                                id="referral_id" name="referral_id">
                                                <option value="">Select Referral Name</option>
                                                @if (!empty($agent_info))
                                                    @foreach ($agent_info as $data)
                                                        <option value="{{ $data->person_no_pk }}">
                                                            {{ $data->full_name }}({{ $data->person_code }})
                                                        </option>
                                                    @endforeach
                                                @endif
                                                </select>
                                            </div>
                                        </div>
                                        <div class="col-md-4">
                                                <div class="btn-group btn-block mt-4" role="group">
                                                    <button type="button" class="btn btn-md btn-success btn-md-global btn-block mt-0"
                                                        id="searchExternalReferralPerformanceStatus" onclick=""> <i class="fas fa-search"></i>
                                                        Search</button>
                                                    <button type='submit' class="btn btn-info btn-block btn-md btn-md-global mt-0 print" ><i class="fa fa-file-pdf"></i> Export PDF</button>
                                                </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </form>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body p-2">
                                <div class="table-responsive" id="external_refferal_performance_table">
                                    @include('admin.refferal.external_refferal_performance_table')
                                </div>
                            </div>
                        </div>
                    </div>
            </div>
        </section>
</main>
    <script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
    <script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
    <script src="{{ asset('js/typeahead.bundle.js') }}"></script>
    <script>
    $("body").addClass("sidebar-collapse");
    $('.select2').select2();
    $(function() {
            $('.date_picker').datepicker({
                todayHighlight: true,
                clearBtn: true,
                autoclose: true,
                // endDate: '+0d',
                format: 'dd-mm-yyyy',
            });
        });
        openPatientAutocomplete('#patient_id', 'patient_name');
        $(document).on("click", "#searchExternalReferralPerformanceStatus", function(e) {

        var formID = $("#searchExternalReferralPerformanceForm").attr("id");
        var formMethod = $("#searchExternalReferralPerformanceStatus").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.search-external-referral-performance') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#external_refferal_performance_table").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on("click", ".print", function(e) {
            $('form').attr('action', "{{ route('v1.external-referral-performance-report-print') }}");
    });

    </script>
