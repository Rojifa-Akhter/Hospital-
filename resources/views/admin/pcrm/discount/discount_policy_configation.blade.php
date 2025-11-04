<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<section id="create_lookup">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Discount Policy Configuration</h5>
                <small>Pcrm / Discount Policy Configuration</small>
            </div>
        </div>

        <div class="card">
            <div class="card-header ">
                <h5> Discount Policy</h5>
            </div>

            <div id="discount_policy_form" style="width:100% !important;">
                @include('admin.pcrm.discount.discount_policy_popup')
            </div>
        </div>

        <div class="card">
            <div class="card-header ">
                <h5>Discount List</h5>
            </div>
            <div class="card-body">
                <div class="mt-2 table-responsive" id="voucher-list">
                    @include('admin.pcrm.discount.discount_policy_data')
                </div>
            </div>
        </div>
    </div>
</section>

{{-- <script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>


<script>
	openBillingItemAutocomplete("#item_id", "", "");
	openInvoiceAutocomplete("#voucher_no");
	openPatientAutocomplete('#patient_code');
	openDoctorAutocomplete('#referral_doctor', 'doctor_id');
    openDoctorAutocomplete('#agent_referral', 'ref_agent');
    openDoctorAutocomplete('#second_referral', 'second_ref');
    $(function() {
		$('.date_picker').datepicker({
			todayHighlight: true,
			clearBtn: true,
			autoclose: true,
		});
	});

	$(document).on("click", "#btnSearch", function(e) {
		var formID = $("#searchForm").attr("id");
		var formMethod = $("#searchForm").attr("method");
		$.ajax({
			data: $('#' + formID).serialize(),
			url:"{{ url('pcrm/referral-policy-search') }}",
			type: formMethod,
			beforeSend: function() {
				blockUI();

			},
			success: function(data) {
				$("#voucher-list").html(data);
			},
			complete: function() {
				$.unblockUI();
			}
		});
	});
</script> --}}

<script>
    function editDiscountPolicy(element) {
        var action = $(element).attr("data-action");
        $.ajax({
            url: action,
            type: 'get',
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#discount_policy_form").html(data);
            },
            complete: function() {

                $.unblockUI();

            }
        });

    }

    // doc_ref
    // $(function() {
    //     consultationPercent();
    //     $("#consultation_ind").click(consultationPercent);
    // });

    // function consultationPercent() {
    //     if (this.checked) {
    //         $("input.consultation_ind").removeAttr("disabled");
    //     } else {
    //         $("input.consultation_ind").attr("disabled", true);
    //     }
    // }


    $(document).on('click','#consultation_ind',function(){
        if($(this).is(':checked')){
            $("input.consultation_percent").prop("disabled",false);
        }else{
            $("input.consultation_percent").prop("disabled",true);
        }
    });
    $(document).on('click','#general_billing_ind',function(){
        if($(this).is(':checked')){
            $("input#general_billing").prop("disabled",false);
        }else{
            $("input#general_billing").prop("disabled",true);
        }
    });
    $(document).on('click','#ot_ind',function(){
        if($(this).is(':checked')){
            $("input#ot").prop("disabled",false);
        }else{
            $("input#ot").prop("disabled",true);
        }
    });
    $(document).on('click','#pathology_ind',function(){
        if($(this).is(':checked')){
            $("input.pathology").prop("disabled",false);
        }else{
            $("input.pathology").prop("disabled",true);
        }
    });
    $(document).on('click','#radiology_ind',function(){
        if($(this).is(':checked')){
            $("input#radiology").prop("disabled",false);
        }else{
            $("input#radiology").prop("disabled",true);
        }
    });
    $(document).on('click','#ipd_bed_ind',function(){
        if($(this).is(':checked')){
            $("input.ipd_bed").prop("disabled",false);
        }else{
            $("input.ipd_bed").prop("disabled",true);
        }
    });
</script>
