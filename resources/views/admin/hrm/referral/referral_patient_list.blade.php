<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<main id="page-content">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Referral Patient List</h5>
                        <small>Settings / Referral Setup / Referral Patient List</small>
                    </div>
                </div>
                <form method="post" id="searchReferralPatientForm">
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
                                                    autocomplete="off" placeholder="From Date"  value="{{date('d-m-Y')}}"/>
                                                    <input type="text" class="form-control date_picker" name="date_to"
                                                    autocomplete="off" placeholder="To Date"  value="{{date('d-m-Y')}}" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="patient_id" class="col-form-label">Patient ID / Name </label>
                                                <input type="text" class="form-control" id="patient_id" name="patient_id" placeholder="Enter Patient ID"  />
                                                <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                                            </div>
                                        </div>
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="mobile_no" class="col-form-label">Mobile No.</label>
                                                <input type="text" class="form-control" name="mobile_no"
                                                    autocomplete="off" placeholder="Enter Mobile No."  />
                                            </div>
                                        </div>
                                        <div class="col-md-2">
                                            <button type="button"  id="searchReferralPatientStatus"class="btn btn-md btn-secondary mt-4 btn-md-global">Search</button>
                                        </div>
                                        <div class="col-lg-1 col-md-6 col-12"></div>
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
                                <div class="table-responsive" id="referral-patient-list-table">
                                    @include('admin.hrm.referral.referral_patient_list_table')
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
        $(document).on("click", "#searchReferralPatientStatus", function(e) {

        var formID = $("#searchReferralPatientForm").attr("id");
        var formMethod = $("#searchReferralPatientForm").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('search-referral-patient') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#referral-patient-list-table").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    </script>
