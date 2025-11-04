<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0"> Doctor Referal Wise Income Summary</h5>
                <small>PCRP / Report  /  Doctor Referal Wise Income Summary</small>
            </div>
        </div>
        <div class="card mt-2" style="width:95%; margin: auto">
            <div class="card-header ">
                <h5> Search</h5>
            </div>

            <div class="card-body ">
                <div class="form-row mt-2">
                    <div class="col-md-12 ">
                        <form method="post" id="frmRefSearch" action="{{ route('pcrm.doctor-referal-wish-income-summery-pdf','PDF') }}" data-response-action="" target="_blank">
                            @csrf
                            <div class="form-group  form-row">
                                <input type="hidden" name="id" value="">

                                 <label for="card_no" class=" col-form-label col-form-label-sm ">Doctor Name / Code</label>
                                <div class=" col-md-2">
                                    <input type="text" class="form-control form-control-sm " id="card_no" name="card_no"
                                        value="" placeholder="Card no / name" >
                                    <input type="hidden" name="card_hidn" id="card_hidn">

                                </div>
                                <label for="user_expire_date" class=" col-form-label col-form-label-sm ">From Date</label>
                                <div class=" col-md-1">
									<input type="text" autocomplete="off" class="form-control form-control-sm date_picker" id="date_pic" name="date_pic" value="{{ date("d-m-Y")}}">
									<span class="focus_input"></span>
								</div>
								<label for="user_expire_date" class=" col-form-label col-form-label-sm ">To Date</label>
								<div class=" col-md-1">

									<input type="text" autocomplete="off" value="{{ date("d-m-Y")}}" class="form-control form-control-sm date_picker" id="date_pic2" name="date_pic2" value="" >
									<span class="focus_input"></span>
								</div>
                                <label for="percentage" class=" col-form-label col-form-label-sm ">Share(%)</label>
                                <div class=" col-md-1">
                                    <input type="number" min="0" oninput="this.value = Math.abs(this.value)" class="form-control form-control-sm " id="percentage" name="percentage"
                                        value="" placeholder="Percentage" >

                                </div>
                                <div class="col-md-3">
                                    <div class="btn-group btn-block" role="group">
                                        <button type="button" class="btn btn-sm btn-success btn-block mt-0"
                                            id="monthlySalarySheet" onclick=""> <i class="fas fa-search"></i>
                                            Search</button>

                                        <button type='submit' class="btn btn-info btn-block btn-sm mt-0 " target="_blank"
                                            value="1" id="PDF" onclick="print(this)"> Export PDF</button>
                                        <button type='submit' class="btn btn-info btn-block btn-sm mt-0 " target="_blank"
                                            value="2" id="EXCEL" onclick="print(this)"> Export Excel</button>
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
            <!--
            <div class="card-header">Individual Doctor wise Performance Details</div>
            -->
            <div class="card-body">

                <div class="form-row mt-2">
                    <div class="col-md-12 table-responsive" id="doctor_wish_income_summery_list">
                        @include('admin.pcrm.referral_v2.IndividualReferralDetails.doctor_wish_income_summery_list')
                    </div>
                </div>
            </div>
        </div>
    </div>



    </div>
</section>


<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>

function print(element){
    var	url = "{{ route('pcrm.doctor-referal-wish-income-summery-pdf',':id') }}";
    var print_id = $(element).attr('id');
    // var action= $(element).parent('form').attr('action');
    if (print_id == "PDF") {
        url = url.replace(":id", 'PDF');
        $(element).parent().parent().parent().parent('form').attr('action',url);
    }else{
        url = url.replace(":id", 'EXCEL');
        $(element).parent().parent().parent().parent('form').attr('action',url);
    }
}
    openDoctorAutocomplete("#card_no", 'card_hidn');
    $("body").addClass("sidebar-collapse");
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
    $(document).on('keyup','#card_no',function(){
    if($(this).val() ==''){
        $('#card_hidn').val('');
    }
})
    $(document).on("click", "#monthlySalarySheet", function(e) {
        // if ($('#card_hidn').val() =="") {
        //     alert('Enter Referral Code');
        //     return;
        // }

        var formID = $("#frmRefSearch").attr("id");
        var formMethod = $("#frmRefSearch").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('pcrm.doctor-referal-wish-income-summery-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#doctor_wish_income_summery_list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
    /*
    $(document).on("click", ".print", function(e) {

        var print = $(this).val();

        if (print == 1) {
            $('form').attr('action', "{{ route('hrm.monthly_salary_print') }}");
        }
        if (print == 2) {
            $('form').attr('action', "{{ route('hrm.monthly_salary_print_bank_wise') }}");
        }

    });
    */

    // delete

</script>
