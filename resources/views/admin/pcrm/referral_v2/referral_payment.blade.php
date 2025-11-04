<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<!-- <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}"> -->
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Voucher List (For Process)</h5>
                <small>Pcrm / Voucher List</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                <h5><i class="fa fa-search"></i> Search Panel</h5>
            </div>
            <div class="card-body pt-2 pb-0">
                <form action="" id="searchForm" method="post">
                    <div class="form-row">
                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="referral_doctor">Referral
                                    Doctor</label>

                                <input type="text" class="form-control" name="referral_doctor" id="referral_doctor"
                                    placeholder="Referral Doctor">
                                <input type="hidden" id="doctor_id" name="doctor_id" />
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="agent_referral">First Referral
                                    (Agent)</label>
                                <input type="text" class="form-control" name="agent_referral" id="agent_referral"
                                    placeholder="Agent">
                                <input type="hidden" id="ref_agent" name="ref_agent" />
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="second_referral">2nd Referral
                                    Doctor</label>
                                <input type="text" class="form-control" name="second_referral" id="second_referral"
                                    placeholder="2nd Referral Doctor">
                                <input type="hidden" id="second_ref" name="second_ref" />
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="item_id">Item</label>
                                <input type="text" class="form-control" name="item_id" id="item_id"
                                    placeholder="Enter Item Code/Name">
                                <input type="hidden" id="item_number" name="item_number">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="patient_code">Patient Code</label>
                                <input type="text" class="form-control form-control-sm patient_id" id="patient_code"
                                    name="patient_code"
                                    placeholder="Search Patient by Patient Code, Name and Phone Number">
                                <input type="hidden" id="hdn_patient_id" name="hdn_patient_id" value="">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="admission">Admission:</label>
                                <input type="text" class="form-control" name="admission" id="admission"
                                    placeholder="Admission">
                                <input type="hidden" name="hdn_admission_id" id="hdn_admission_id">
                            </div>
                        </div>

                        <div class="col-sm-2">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="voucher">Voucher</label>
                                <input type="text" class="form-control" name="voucher" id="voucher_no"
                                    placeholder="Voucher">
                                <input type="hidden" name="hdn_invoice_id" id="hdn_invoice_id">
                            </div>
                        </div>


                        <div class="form-group col-md-4">
                            <label class="col-form-label col-form-label-sm" for="voucher_date_from">Date</label>
                            <div class="input-group">
                                <div class="input-group-prepend">
                                    <div class="input-group-text">From</div>
                                </div>
                                <input type="text" class="form-control form-control-sm m-0 date_picker"
                                    id="voucher_date_from" name="search_date_from" value=""
                                    placeholder="dd-mm-yyyy">

                                <div class="input-group-prepend">
                                    <div class="input-group-text">To</div>
                                </div>
                                <input type="text" class="form-control form-control-sm m-0 date_picker"
                                    id="voucher_date_to" name="search_date_to" value=""
                                    placeholder="dd-mm-yyyy">
                            </div>
                        </div>
                        <div class="col-md-3 mt-4">
                            <div class="custom-control custom-radio custom-control-inline text-center">
                                <input type="radio" id="all" name="all" class="custom-control-input">
                                <label class="custom-control-label" for="all">All</label>
                            </div>

                            <div class="custom-control custom-radio custom-control-inline text-center">
                                <input type="radio" id="referral_ind" name="referral_ind" checked="checked"
                                    class="custom-control-input">
                                <label class="custom-control-label" for="referral_ind">Referral</label>
                            </div>

                            <div class="custom-control custom-radio custom-control-inline text-center">
                                <input type="radio" id="not_processed" name="not_processed"
                                    class="custom-control-input">
                                <label class="custom-control-label" for="not_processed">Not Processed</label>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <button type="button" id="pcrmBtnSearch" class="btn btn-success btn-md  mt-4"><i
                                    class="fa fa-search fa-fw"></i> Search</button>
                            <button type="reset" id="" class="btn btn-danger btn-md  mt-4"><i
                                    class="fa fa-remove"></i> Clear</button>
                            <button type="button" id="pcrmBtnProcess" class="btn btn-success btn-md  mt-4"> Monthly
                                Process</button>

                        </div>

                        {{-- <div class="col-md-2">

                            <a href="{{route('pcrm.admission-refferal-payment-update')}}"
                                class="btn btn-primary btn-md cursor-pointer"
                                data-id="" id="process_id"
                                title="Ipd process"><i class="fa fa-file-pdf"></i> Process</a>


                        </div> --}}


                    </div>
                </form>
            </div>
        </div>

        <div class="card">
            <div class="card-header ">
                <h5>Voucher List</h5>
            </div>
            <div class="card-body">
                <div class="mt-2 table-responsive" id="pcrm-voucher-list">
                    @include('admin.pcrm.referral_v2.referral_payment_search_data')
                </div>
            </div>
        </div>
    </div>
</section>



<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<!-- <script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script> -->

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>



<script>
    $("body").addClass("sidebar-collapse");
    $(document).on("click", "#pcrmBtnSearch", function(e) {

        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('pcrm/referral-policy-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#pcrm-voucher-list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    $(document).on("click", "#pcrmBtnProcess", function(e) {

        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('pcrm.monthly-process-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                //$("#pcrm-voucher-list").html(data);

                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-body').html(
                    "<i class='fas fa-stroopwafel fa-spin'></i>");
                $('.common-modal-notify .modal-title').html(data.title);
                $('.common-modal-notify .modal-body').html(data.msg);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
    openInvoiceAutocomplete("#voucher_no");
    openBillingItemAutocomplete("#item_id", "", "");

    openPatientAutocomplete('#patient_code');
    openDoctorAutocomplete('#referral_doctor', 'doctor_id');
    openDoctorAutocomplete('#agent_referral', 'ref_agent');
    openDoctorAutocomplete('#second_referral', 'second_ref');
    openAdmissionAutocomplete('#admission', 'patient_name', '');
    $(function() {
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd-mm-yyyy'
        });
    });
</script>
