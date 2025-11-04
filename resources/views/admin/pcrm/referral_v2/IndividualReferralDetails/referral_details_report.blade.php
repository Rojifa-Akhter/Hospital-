<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Referral Details
                    Report</h5>
                <small>PCRP / Report  / Referral Details
                    Report</small>
            </div>
        </div>
        <div class="card mt-2" style="width: 90%; margin: auto">
            <div class="card-header ">
                <h5> Search</h5>
            </div>

            <div class="card-body ">
                <div class="form-row mt-2">
                    <div class="col-md-12 ">
                        <form method="post" id="frmRefDtlSearch" action="{{ route('pcrm.referral-details-report-pdf') }}"
                            data-response-action="">
                            @csrf
                            <div class="form-group  form-row">
                                <input type="hidden" name="id" value="">


                                <div class=" col-md-2">
                                    <label for="card_no" class=" col-form-label col-form-label-sm ">Referral code</label>
                                    <input type="text" class="form-control form-control-sm " id="card_no" name="card_no" value="" placeholder="Card no / Name" >
                                    <input type="hidden" name="card_hidn" id="card_hidn">

                                </div>

                                <div class=" col-md-2">
                                    <label for="user_expire_date" class=" col-form-label col-form-label-sm ">From Date</label>
									<input type="text" class="form-control form-control-sm date_picker" id="date_pic" name="date_pic" value="" autocomplete="off" placeholder="DD-MM-YYYY">
									<span class="focus_input"></span>
								</div>

								<div class=" col-md-2">
                                    <label for="user_expire_date" class=" col-form-label col-form-label-sm ">To Date</label>
									<input type="text" class="form-control form-control-sm date_picker" id="date_pic2" name="date_pic2" value="" autocomplete="off" placeholder="DD-MM-YYYY">
									<span class="focus_input"></span>
								</div>

								{{-- <div class=" col-md-2">
                                    <label for="user_expire_date" class=" col-form-label col-form-label-sm ">Service Unit</label>
                                    <select class="form-control form-control-sm select2" name="service_unit" id="service_unit">
                                        <option value="">select</option>
                                        @if ($service_unit)
                                        @foreach ($service_unit as $value)
                                        <option value="{{$value->serviceunit_no_pk.'_'.$value->serviceunit_name}}">{{$value->serviceunit_name}}</option>
                                        @endforeach
                                        @endif

                                    </select>

								</div> --}}
                                <div class="col-md-3 mt-4">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-sm btn-success btn-block mt-0"
                                            id="detailsReferralReport" onclick=""> <i class="fas fa-search"></i>
                                            Search</button>

                                        <button type='submit' class="btn btn-info btn-block btn-md mt-0 " target="_blank"
                                            value="2"> Export PDF</button>
                                    </div>
                                </div>

                            </div>
                        </form>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="container-fluid">

        <div class="card">
            <!-- <div class="card-header"> Monthly Salary Report</div> -->
            <div class="card-body">

                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="referral_details_report_list">
                        @include('admin.pcrm.referral_v2.IndividualReferralDetails.referral_details_report_list')
                    </div>
                </div>
            </div>
        </div>
    </div>



    </div>
</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    openDoctorAutocomplete("#card_no", 'card_hidn');
    $("body").addClass("sidebar-collapse");
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
	$('.select2').select2();
    $(document).on("click", "#detailsReferralReport", function(e) {
        // if ($('#card_hidn').val() =="") {
        //     alert('Enter Referral Code');
        //     return;
        // }

        var formID = $("#frmRefDtlSearch").attr("id");
        var formMethod = $("#frmRefDtlSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('pcrm.referral-details-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#referral_details_report_list").html(data);


            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

$(document).on('keyup','#card_no',function(){
    if($(this).val() ==''){

        $('#card_hidn').val('');
    }
})

    // $(document).on("click", ".print", function(e) {
    //     var print = $(this).val();

    //     if (print == 1) {
    //         $('form').attr('action', "{{ route('hrm.monthly_salary_print') }}");
    //     }
    //     if (print == 2) {
    //         $('form').attr('action', "{{ route('hrm.monthly_salary_print_bank_wise') }}");
    //     }
    // });

    // delete

</script>
