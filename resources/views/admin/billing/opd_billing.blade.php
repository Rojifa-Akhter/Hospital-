    <!-- datepicker -->
    <link href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" rel="stylesheet">
    <link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet">
    <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
    <style>
    	.total_amounts .form-group input{
    		padding: 3px;
    		font-size: 14px;
    	}

    	.total_amounts .col-form-label {
    		display: inline-block;
    		padding-top: calc(3px + 1px);
    		padding-bottom: calc(8px + 1px);
    	}

    	.form-group label{
    		display: inline-block;
    		font-size: 13px;
    	}

    	.bottom_mid .form-group input{
    		display: inline-block;
    		padding: 3px;
    		font-size: 14px;
    	}

    	.bottom_mid .col-form-label {
    		padding-top: calc(3px + 1px);
    		padding-bottom: calc(8px + 1px);
    	}

    	.mb-0 { margin-bottom: 0 !important; }
    	.qnty-width{ width: 6% !important; }
    	.border-bottom-3 { border-bottom: 2px solid #38C172 !important; }
    	.doctor_info img{
    		padding: 5px;
    		width: 40px;
    		float: left;
    		border: 1px solid #222;
    		border: 1px solid #95e0b3;
    		margin-left: 5px;
    	}

    	.doctor_info .doctor_info_data{
    		float: left;
    		margin-left: 10px;
    	}

    	.doctor_info .doctor_info_data ul{
    		margin: 0px;
    	}

    	.invoice-title h2, .invoice-title h3 {
    		display: inline-block;
    	}

    	.table > tbody > tr > .no-line {
    		border-top: none;
    	}

    	.table > thead > tr > .no-line {
    		border-bottom: none;
    	}

    	.table > tbody > tr > .thick-line {
    		border-top: 2px solid;
    	}
    	.table-borderless tr th,.table-borderless tr td{ border-top:none !important; padding: 2px 5px !important; }

    </style>

    <section id="full_registration">
    	<form method="post" action="{{ route('billing.store') }}" id="frmBilling" onsubmit="">
    		<div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12 mb-1">
                        <h5 class="mt-2 mb-0">Create New Bill</h5>
                        <small>Billing / New Bill</small>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                       <div class="card">
                          <div class="card-header"><h5>Billing Entry</h5></div>
                          <div class="card-body border-bottom-3 p-2">
                             <div class="row">
                                <div class="col-sm-6">
                                   <div class="form-row">
                                      <div class="form-group col-md-4">
                                         <label for="patient_type">Patient Type</label>
                                         <select class="form-control" id="patient_type" name="patient_type">
                                            <option value="0">Select Patient Type</option>
                                            <option value="1">Registered Patient</option>
                                            <option value="2">Non-Registered Patient</option>
                                        </select>
                                    </div>
                                    <div class="form-group col-md-4">
                                     <label for="patient_id">Patient ID </label> <span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-md" data-action="{{ route('registration.quickcreate') }}" data-title="Create New Patient">+ Add New</span>
                                     <input type="text" class="form-control" id="patient_id" name="patient_id" placeholder="Patient ID/Name/Mobile" title="Search By Patient ID/ Name/ Mobile" required="required" />
                                     <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" />
                                 </div>
                                 <div class="form-group col-md-4">
                                     <label for="prescription_id">Prescription ID</label>
                                     <input type="text" class="form-control " id="prescription_id" name="prescription_id" value="" placeholder="Prescription ID">
                                 </div>
                             </div>
                             <div id="patient_info"></div>
                         </div>
                         <div class="col-sm-6 border-left">
                           <div class="row">
                              <div class="col-md-4">
                                 <div class="form-group">
                                    <label for="doctor_code">Doctor Code</label>
                                    <span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-sm" data-action="{{ route('doctor.createquickregistration') }}" data-title="Add New Doctor">+ Add New</span>
                                    <input type="text" class="form-control" id="doctor_code" name="doctor_code" placeholder="Code/Name/Mobile/SPL." title="Search by Code/ Name/ Mobile/ Specialization" required="required">
                                    <input type="hidden" class="form-control" id="hdn_doctor_id" name="hdn_doctor_id" >
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="first_referral">1st Referral</label>
                                    <span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-sm" data-action="{{ route('doctor.createquickregistration','referral1') }}" data-title="Add New First Referral Doctor">+ Add New</span>
                                    <input type="text" class="form-control" id="first_referral" name="first_referral" placeholder="MPO">
                                    <input type="hidden" name="hdn_first_referral" class="hdn_first_referral" id="hdn_first_refer">
                                </div>
                            </div>
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label for="second_referral">2nd Referral</label>
                                    <span class="badge badge-primary cursor-pointer open-modal" data-modal="common-modal-sm" data-action="{{ route('doctor.createquickregistration','referral2') }}" data-title="Add New Second Referral Doctor">+ Add New</span>
                                    <input type="text" class="form-control" id="second_referral" name="second_referral" placeholder="MPO">
                                    <input type="hidden" name="hdn_second_referral" class="hdn_second_referral" id="hdn_second_referral">
                                </div>
                            </div>
                        </div>
                        <div id="doctor_info"></div>
                    </div>
                </div>
            </div>
        </div>
        <div class="card">
          <div class="card-body">
             <div class="billing_table mt-2">
                <div class="form-group">
                   <input type="text" class="form-control bg-light" id="item_name" name="item_name" autocomplete="off" placeholder="Write Item Code or Item Name here" />
               </div>
               <table id="billing_table" class="table table-bordered table-striped table-hover fixed_header mt-2">
                   <thead class="">
                      <tr>
                         <th class="min-width-30 bg-primary text-center" scope="col">#SL</th>
                         <th class="min-width-80 bg-primary text-center" scope="col">Department</th>
                         <th class="min-width-100 bg-primary text-center" scope="col">Item Description</th>
                         <th class="min-width-60 bg-primary text-right" scope="col">Rate</th>
                         <th class="min-width-70 bg-primary text-center" scope="col">Quantity</th>
                         <th class="min-width-100 bg-primary text-center" scope="col">Delivery Status</th>
                         <th class="min-width-100 bg-primary text-center" scope="col">Delivery Date Time</th>
                         <th class="min-width-60 bg-primary text-center" scope="col">Item Total</th>
                         <th class="min-width-30 bg-primary text-center" scope="col"></th>
                     </tr>
                 </thead>

                 <tbody id="billing_table-body"></tbody>
             </table>
         </div>
     </div>
 </div>
</div>
</div>
</div>
</div>
</div>

<div class="container-fluid">
   <div class="row">
      <div class="col-xs-12 col-sm- 12 col-md-6 col-lg-8 col-xl-8">
         <div class="card pt-1 border">
            <div class="card-body">
               <div class="form-row">
                <div class="form-group col-md-4 pl-0">
                  <div class="form-group">
                     <div class="input-group">
                        <div class="input-group-prepend">
                           <label class="input-group-text" for="cmb_discount">Discount&nbsp;&nbsp;</label>
                       </div>
                       <select class="custom-select" id="cmb_discount" name="cmb_discount">
                           <option value="0">Discount Type</option>
                           @if(!empty($disctype))
                           @foreach($disctype as $key => $dtype)
                           <option value="{{ $key }}" {{ ($key==206)?"selected":"" }}>{{ $dtype }}</option>
                           @endforeach
                           @endif
                       </select>
                   </div>
               </div>
           </div>
           <div class="form-group col-md-2">
             <div class="input-group">
                <div class="input-group-prepend">
                   <span class="input-group-text" id="basic-addon1">%</span>
               </div>
               <input type="text" class="form-control text-right number_only hospital_disc" id="discount_percent_hospital" name="discount_percent_hospital" placeholder="Hospital" onkeyup="calculate_total(this)" />
           </div>
       </div>
       <div class="form-group col-md-2">
         <input type="text" class="form-control text-right number_only hospital_disc" id="discount_amount_hospital" name="discount_amount_hospital" placeholder="Amount" readonly="readonly">
     </div>

     <div class="form-group col-md-2">
        <div class="input-group">
            <div class="input-group-prepend">
                <span class="input-group-text" id="basic-addon1">%</span>
            </div>
            <input type="text" class="form-control text-right number_only doctor_disc" id="discount_percent_doctor" name="discount_percent_doctor" placeholder="Doctor" onkeyup="calculate_total(this)" />
        </div>
    </div>
    <div class="form-group col-md-2">
        <input type="text" class="form-control text-right number_only doctor_disc" id="discount_amount_doctor" name="discount_amount_doctor" placeholder="Amount" readonly="readonly">
    </div>
</div>
<div class="form-row">
  <div class="form-group">
     <div class="input-group">
        <div class="input-group-prepend">
           <label class="input-group-text" for="pay_mode">Pay Mode</label>
       </div>
       <select class="custom-select" id="pay_mode" name="pay_mode">
           <option value="0">Select Pay Mode</option>
           @if(!empty($paymodes))
           @foreach($paymodes as $key => $paymode)
           <option value="{{ $key }}">{{ $paymode }}</option>
           @endforeach
           @endif
       </select>
   </div>
</div>
<div class="form-group col-md-6">
 <div class="input-group">
    <input type="text" class="form-control number_only" id="pay_amount" name="pay_amount" placeholder="Pay Amount" onkeyup="calculate_payment(this)" />
    <input type="text" class="form-control number_only" id="given_amount" name="given_amount" placeholder="Given Amount" onkeyup="calculate_payment(this)">
    <input type="text" class="form-control number_only" id="change_amount" name="change_amount" placeholder="Chagne Amount" disabled="disabled" >
</div>
</div>
</div>
<div class="form-row">
  <div class="w-100">
     <div class="input-group">
        <div class="input-group-prepend">
           <span class="input-group-text" id="inputGroup-sizing-sm">Remarks</span>
       </div>
       <input type="text" class="form-control" id="discount_remarks" name="discount_remarks" >
   </div>
</div>
</div>
</div>
</div>
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
       <div class="card">
          <div class="card-body">
             <div class="row pt-2">
                <div class="col-md-4">
                   @php
                   $bill_id="";
                   $response_url = route('bill-invoice-appointment',$bill_id); @endphp
                   <button class="btn btn-sm btn-block btn-success" id="btnCreateBill" data-response_action="{{ $response_url }}" >Create Bill</button>
               </div>

               <div class="col-md-4">
                <a href="{{ route('billing.create') }}"  class="btn btn-sm btn-block btn-danger" rel="tab">New Bill</a>
            </div>
        </div>
    </div>
</div>
</div>
</div>
</div>
<div class="col-xs-12 col-sm- 12 col-md-6 col-lg-4 col-xl-4">
 <table class="table table-borderless">
    <tbody>
       <tr>
          <td scope="row" class="w-50 text-right"><label for="item_total" class="col-form-label col-form-label-sm pt-0">Amount</label></td>
          <td><input type="text" class="form-control mb-0" id="item_total" name="item_total" value="" placeholder="0.00" disabled="disabled"></td>
      </tr>
      <tr>
          <td scope="row" class="w-50 text-right"><label for="item_total" class="col-form-label col-form-label-sm pt-0">VAT</label></td>
          <td><input type="text" class="form-control mb-0 number_only" id="item_vat" name="item_vat" value="" placeholder="0.00" onkeyup='calculate_total()'></td>
      </tr>
      <tr>
          <td scope="row" class="w-50 text-right"><label for="item_total" class="col-form-label col-form-label-sm pt-0">Discount</label></td>
          <td><input type="text" class="form-control mb-0" id="total_discount_amount" name="total_discount_amount" value="" placeholder="0.00" readonly="readonly"></td>
      </tr>
      <tr>
          <td scope="row" class="w-50 text-right"><label for="urgent_fee" class="col-form-label col-form-label-sm pt-0">Urgent Fee</label></td>
          <td><input type="text" class="form-control mb-0 number_only" id="urgent_fee" name="urgent_fee" value="" placeholder="0.00" onkeyup='calculate_total()'></td>
      </tr>
      <tr>
          <td scope="row" class="w-50 text-right"><label for="s_charge" class="col-form-label col-form-label-sm pt-0">S. Charge</label></td>
          <td><input type="text" class="form-control mb-0 number_only" id="s_charge" name="s_charge" value="" placeholder="0.00" onkeyup='calculate_total()'></td>
      </tr>
      <tr>
          <td scope="row" class="w-50 text-right"><label for="total_payable" class="col-form-label col-form-label-sm pt-0">Payable</label></td>
          <td><input type="text" class="form-control mb-0" id="total_payable" name="total_payable" value="" placeholder="0.00" disabled="disabled"></td>
      </tr>
      <tr>
          <td scope="row" class="w-50 text-right"><label for="total_payment" class="col-form-label col-form-label-sm pt-0">Payment</label></td>
          <td><input type="text" class="form-control mb-0" id="total_payment" name="total_payment" value="" placeholder="0.00"></td>
      </tr>
      <tr>
          <td scope="row" class="w-50 text-right"><label for="total_due" class="col-form-label col-form-label-sm text-danger pt-0">Due</label></td>
          <td><input type="text" class="form-control mb-0" id="total_due" name="total_due" value="" placeholder="0.00"></td>
      </tr>
  </tbody>
</table>
</div>
</div>
</form>
</section>
<!-- datepicker -->
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script type="text/javascript">
	function calculate_total(){
		if($("#billing_table-body tr").length > 0)
		{
			var item_total=0;
			$( "#billing_table-body tr" ).each(function() {
				item_total += $(this).find(".item_total_amt").val()*1;
			});
			$("#item_total").val(item_total.toFixed(2));

			var discount_perc_hos = $("#discount_percent_hospital").val()*1;
			var discount_amt_hos = (item_total*discount_perc_hos)/100;
			$("#discount_amount_hospital").val(discount_amt_hos.toFixed(2));

            var discount_perc_doc = $("#discount_percent_doctor").val()*1;
            var discount_amt_doc = (item_total*discount_perc_doc)/100;
            $("#discount_amount_doctor").val(discount_amt_doc.toFixed(2));

            var after_disc_amt = (item_total - (discount_amt_hos + discount_amt_doc));
            $("#total_discount_amount").val((discount_amt_hos + discount_amt_doc).toFixed(2));

            var item_vat 	= $("#item_vat").val()*1;
            var urgent_fee 	= $("#urgent_fee").val()*1;
            var s_charge 	= $("#s_charge").val()*1;

            var total_payable = (after_disc_amt+item_vat+urgent_fee+s_charge);
            $("#total_payable").val(total_payable.toFixed(2));
        }
        else
        {
         alert("You did not selected any Item.");
         return;
     }
 }

 function calculate_item_total(thisElement){
  var item_id = $(thisElement).parents("tr").find(".item_id").val();
  var item_qnty = $("#hdn_item_qnty_"+item_id).val()*1;
  var item_rate = $("#hdn_item_rate_"+item_id).val()*1;
  $("#hdn_item_total_qnty_"+item_id).val(item_qnty*item_rate);
}

function calculate_payment(thisElement){
    var pay_amount   = $("#pay_amount").val()*1;
    var given_amount = $("#given_amount").val()*1;
    if(pay_amount > 0)
    {
        $("#total_payment").val(pay_amount);
        $("#change_amount").val(pay_amount-given_amount);
        $("#total_due").val($("#total_payable").val()*1-$("#total_payment").val()*1);
    }
}

$(function() {

  $("#patient_type").focus();
  $('.select2').select2();
  $('.date_picker').datepicker();
  $(document).on("keypress","input", function(e){
     if(e.which == 13) {
        e.preventDefault();
    }
});

  $(document).on("click","#resetForm", function(e){
     $("#frmBilling").find("input").val('');
 });

  openPatientAutocomplete('#patient_id');
  openDoctorAutocomplete('#doctor_code', 'hdn_doctor_id');
  openDoctorAutocomplete('#first_referral', 'hdn_first_referral_id', 'N');
  openDoctorAutocomplete('#second_referral', 'hdn_second_referral_id', 'N');


  $('#item_name').typeahead({
     hint: true,
     highlight: true,
     minLength: 1
 },
 {
     limit: 'Infinity',
     async: true,
     source: function (query, processSync, processAsync) {
        return $.ajax({
           url: "{{ route('get-item-name') }}",
           type: 'POST',
           data: {query: query},
           dataType: 'json',
           success: function (result) {
              return processAsync(result);
          }
      });
    },
    display: 'item_name',
    templates: {
        suggestion: function(item){
           return  '<div id="user-selection" class="clearfix border-bottom">' +
           '<div style="display:block"><strong>' + item.item_code + '</strong> - ' + item.item_name+'</div></div>' ;
       }
   }

}).bind("typeahead:selected", function(obj, item, name) {
 var total = item.item_rate;
 var sl = $("#billing_table-body tr").length + 1
 var table_row = "<tr><td class='text-center' style='width:2%'>"+sl+"<input class='item_id' type='hidden' name='hdn_item_id[]' value='"+item.item_id+"' ><input class='hdn_item_name' type='hidden' name='hdn_item_name[]' value='"+item.item_name+"'><input class='hdn_item_type' type='hidden' name='hdn_item_type[]' value='"+item.item_type+"'> </td><td style='width:12%'>"+item.item_dept+"<input type='hidden' name='hdn_item_dept_id[]' value='"+item.item_dept+"' ></td><td class='text-left'><strong>"+item.item_code+" - </strong> "+item.item_name+"</td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right' name='item_rate[]' id='item_rate_"+item.item_id+"' value='"+item.item_rate+"' disabled='disabled' ><input type='hidden' class='form-control mb-0 text-right' name='hdn_item_rate[]' id='hdn_item_rate_"+item.item_id+"' value='"+item.item_rate+"' readonly='readonly' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right' onkeyup='calculate_item_total(this);calculate_total()' id='hdn_item_qnty_"+item.item_id+"' name='hdn_item_qnty[]' value='1' ></td><td class='text-center' style='width:9%'><select class='form-control mb-0' id='item_delivery_status' name='item_delivery_status[]'><option value='0'>Select</option><option value='1'>Normal</option></select></td><td class='text-center' style='width:9%'><input type='text' class='form-control date_picker mb-0' name='hdn_item_deli_date[]' ></td><td class='text-center qnty-width'><input type='text' class='form-control mb-0 text-right item_total_amt disabled' name='hdn_item_total_qnty[]' id='hdn_item_total_qnty_"+item.item_id+"' value='"+total+"' disabled='disabled' ></td><td class='text-center' style='width:3%'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='oi oi-circle-x'></i></span></td></tr>";

 if($("#billing_table-body tr").length >= 1)
 {
    $("#billing_table-body").append(table_row);
}
else
{
    $("#billing_table-body").html(table_row);
}
$('.date_picker').datepicker();
calculate_total();
$('#item_name').typeahead('val','');
});

$(document).on("click","#btnCreateBill", function(e){
 var action = $(this).attr("data-response_action");
 if($("#billing_table-body tr").length == 0)
 {
    alert("You did not select any Item");
    e.preventDefault();
    return;
}

formValidation("frmBilling");

btnSaveUpdate($(this),'afterSaveModal', action, 'common-modal', 'Bill Invoice');
});

});

$(document).on("click", "#quickRegisterReferral1",function(){
  var formID      = $(this).parents("form").attr("id");
  var formAction  = $(this).parents("form").attr("action");
  var formMethod  = $(this).parents("form").attr("method");


  $.ajax({
     data: $('#'+formID).serialize(),
     url: formAction,
     type: formMethod,
     beforeSend:function(){
        blockUI();
    },
    success: function (data) {
				// console.log(data);
				$("#hdn_first_referral").val(data.insert_id);
				$("#first_referral").val(data.last_name);

				// $(".second_refer_div > .hdn_second_refer").val(data.insert_id);
				// $(".second_refer_div > .second_refer").val(data.last_name);
				// $("#appointment-list").html('').append(data.html);

				$('#doctor_quick_reg_form')[0].reset();
				$('#exampleModal').modal('hide');
			},
			complete:function(){
				$.unblockUI();
			}
		});
});

$(document).on("click", "#quickRegisterReferral2",function(){
  var formID      = $(this).parents("form").attr("id");
  var formAction  = $(this).parents("form").attr("action");
  var formMethod  = $(this).parents("form").attr("method");


  $.ajax({
     data: $('#'+formID).serialize(),
     url: formAction,
     type: formMethod,
     beforeSend:function(){
        blockUI();
    },
    success: function (data) {
				// console.log(data);
				$("#hdn_second_referral").val(data.insert_id);
				$("#second_referral").val(data.last_name);

				// $(".second_refer_div > .hdn_second_refer").val(data.insert_id);
				// $(".second_refer_div > .second_refer").val(data.last_name);
				// $("#appointment-list").html('').append(data.html);

				$('#doctor_quick_reg_form')[0].reset();
				$('#exampleModal').modal('hide');
			},
			complete:function(){
				$.unblockUI();
			}
		});
});

$(document).on("click", "#quickRegisterReferral",function(){
  var formID      = $(this).parents("form").attr("id");
  var formAction  = $(this).parents("form").attr("action");
  var formMethod  = $(this).parents("form").attr("method");


  $.ajax({
     data: $('#'+formID).serialize(),
     url: formAction,
     type: formMethod,
     beforeSend:function(){
        blockUI();
    },
    success: function (data) {
				// console.log(data);
				$("#hdn_doctor_id").val(data.insert_id);
				$("#doctor_code").val(data.last_name);

				// $(".second_refer_div > .hdn_second_refer").val(data.insert_id);
				// $(".second_refer_div > .second_refer").val(data.last_name);
				// $("#appointment-list").html('').append(data.html);

				$('#doctor_quick_reg_form')[0].reset();
				$('#exampleModal').modal('hide');
			},
			complete:function(){
				$.unblockUI();
			}
		});
});

</script>
