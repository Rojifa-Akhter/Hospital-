<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Processed List</h5>
                <small>Pcrm / Processed List</small>
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
                                <label class="col-form-label col-form-label-sm" for="agent_referral">Agent</label>
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
                                <input type="text" class="form-control" id="patient_id" name="patient_id"
                                    placeholder="Patient ID/Name/Mobile" title="Search By Patient ID/ Name/ Mobile" />
                                <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
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
                        <div class="col-md-2 mt-4">
                            {{-- <div class="custom-control custom-radio custom-control-inline text-center">
								<input type="radio"  id="all" name="process" class="custom-control-input" >
								<label class="custom-control-label" for="all">All</label>
							</div> --}}

                            <div class="custom-control custom-radio custom-control-inline text-center">
                                <input type="radio" id="Paid" name="process" class="custom-control-input"
                                    value="PAID">
                                <label class="custom-control-label" for="Paid">Paid</label>
                            </div>

                            <div class="custom-control custom-radio custom-control-inline text-center">
                                <input type="radio" id="Unpaid" name="process" class="custom-control-input"
                                    value="UNPAID">
                                <label class="custom-control-label" for="Unpaid">Unpaid</label>
                            </div>
                        </div>

                        <div class="col-md-2">
                            <button type="button" id="btnSearch" class="btn btn-success btn-md  mt-4"><i
                                    class="fa fa-search fa-fw"></i> Search</button>
                            <button type="reset" id="" class="btn btn-danger btn-md  mt-4"><i
                                    class="fa fa-search fa-fw"></i> Clear</button>
                        </div>
                    </div>
            </div>


            </form>
        </div>
    </div>

    <div class="card">
        <div class="card-header ">
            <h5>Pocessed List</h5>
        </div>
        <div class="card-body">
            <div class="mt-2 table-responsive" id="processed-list">
                @include('admin.pcrm.referral_v2.processed_list_data')
            </div>
        </div>
    </div>
    </div>
</section>



<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>


<script>
    $("body").addClass("sidebar-collapse");



    openBillingItemAutocomplete("#item_id", "", "");
    openInvoiceAutocomplete("#voucher_no");

    // openPatientAutocomplete('#patient_code', '#hdn_patient_id', ipdAdmission.SearchPatient);
    openPatientAutocomplete('#patient_id');
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

    $(document).on("click", "#btnSearch", function(e) {
        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");


        // console.log( $('#' + formID).serialize());
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('pcrm/referral-payment-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                console.log('ok')
                $("#processed-list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

//     if ( $("#hdn_admission_id").val() === "" ) {
// } else {
//   alert("Function called...");
// }

$(document).ready(function(){
    // Get value on button click and show alert
    $("#btnSearch").click(function(){
       // for admission
       var hdn_admission_id = $('#hdn_admission_id').val();

       $('#admid').val(hdn_admission_id)
        console.log(hdn_admission_id)
    });
});
</script>
