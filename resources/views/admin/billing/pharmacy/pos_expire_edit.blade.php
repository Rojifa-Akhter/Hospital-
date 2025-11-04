<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<?php
$date = date('d-m-Y');
?>
<div class="row">


  <div class="col-sm-12 col-lg-12 col-xl-12">
    <table width="100%">
      <tr>
        <td>Item Name : <strong> {{$item_name->item_name}} </strong></td>
        <td style="text-align: right;">Sales qty : <strong> {{$sales_qty}}</strong></td>
        <input type="hidden" id="sales_qty" name="sales_qty" value="{{$sales_qty}}">
      </tr>
    </table>
    <form action="{{ route('loan.store') }}" method="post" id="loan-form">
      @csrf
      <input type="hidden" name="id" value="">



      <table id="myTable">
        <thead>
          <tr>
            <td>Batch No</td>
            <td class="w-25">Exp. Date</td>
            <td class="w-15">QTY</td>
            <!-- <td class="w-15">Sales QTY</td> -->
            <td class="text-right">Action</td>
          </tr>
          <tr>
            <td>
              <select class="form-control select2 keep_me" id="batch_name" name="batch_name" onchange="changeBatch(this)">
                <option value="">Select Batch No</option>

                @if(!empty($batch))
                @foreach($batch as $value)
                <option value="{{$value->batch_no}}"> {{$value->batch_no}}</option>

                @endforeach
                @endif
              </select>
            </td>
            <td>
              <input type="text" class="form-control form-control-sm m-0 " id="exp_date" name="exp_date" required placeholder="dd-mm-yyyy" value="" />
            </td>
            <td>

              <input type="text" class="form-control form-control-sm number_only text-right" id="qty" name="qty" value="" placeholder="Enter QTY">
            </td>
            </td>
            <!-- <td>
              <input type="text" class="form-control form-control-sm number_only text-right" id="qty" name="sales_qty" value="" placeholder="Sales QTY">
            </td> -->
            <td class="text-right"><button class="btn btn-sm btn-info" type="button" onclick="expAdd()">Add</button></td>
          </tr>
        </thead>
        <tbody id="tbody_exp">
          <input type="hidden" id="item_id" name="" value="{{$id}}">
          @if(!empty($exp))
          @php
          $expiry=$exp;
          $expiry_count=count($expiry);

          $i=0;
          @endphp

          @for($i=0; $i < $expiry_count; $i++ ) @php 
          $exp_data=explode(',' , $expiry[$i]); 
          @endphp
           <tr class="data_class" data-batch_name='{{$exp_data[0]}}' data-exp_date='{{$exp_data[1]}}' data-qty='{{$exp_data[2]}}'>
            <td><input type='text' style='border:none;' name='edit_batch_name[]' id='edit_batch_name' readonly='readonly' value='{{$exp_data[0]}}'></td>
            <td><input type='text' name='edit_exp_date[]' id='edit_exp_date' readonly='readonly' class='w-100' style='border: none;' value='{{$exp_data[1]}}'></td>
            
            <!-- <td><input type='text' name='edit_qty[]' id='edit_qty' class='text-right w-100 edit_qty' style='border: none;' value='{{$exp_data[2]}}'></td> -->
            <td><input type='text' name='edit_sales_qty[]' id='edit_sales_qty' class='text-right w-100 edit_sales_qty' style='border: none;' value='{{$exp_data[2]}}'></td>
            <td class='text-right'><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span></td>
            </tr>

            @endfor
            @endif
        </tbody>
      </table>

      <div class="text-left mt-5">
        <button type="button" class="btn btn-md btn-success" data-dismiss="modal" onclick="saveData(this)">
          Save
        </button>
        <button type="reset" class="btn btn-md btn-info " data-dismiss="modal">Clear</button>
        <button type="button" class="btn btn-md btn-danger" data-dismiss="modal">Exit</button>
      </div>
    </form>
  </div>
</div>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
  function changeBatch(element) {
    var batch_id = $(element).val();
    if (batch_id != "") {
      $.ajax({
        data: {
          batch_id: batch_id
        },
        url: "{{route('billing.show-batch-no-dropdown')}}",
        type: "post",
        beforeSend: function() {
          blockUI();
        },
        success: function(data) {

          var result = jQuery.parseJSON(data);

          if (result != "") {
            var exp_date = result.expiry_date;
            var qty = result.recieve_qty;

            $('#exp_date').val(exp_date);
            $('#qty').val(qty);

          } else {
            $('#exp_date').val('');
            $('#qty').val('');
          }


          $.unblockUI();

        },
        complete: function() {
          $.unblockUI();
        },
        error: function(data) {

          $.unblockUI();
        }
      })
    } else {
      $('#exp_date').val('');
      $('#qty').val('');
      return;
    }
  }

  function expAdd() {

    var batch_name = $('#batch_name').val();
    var exp_date = $('#exp_date').val();
    var qty = $('#qty').val();
    if (qty != "") {
      $('#myTable tr:last').after("<tr class='data_class' data-batch_name='" + batch_name + "' data-exp_date='" + exp_date + "' data-qty='" + qty + "'><td ><input type='text' style='border:none;' name='edit_batch_name[]' id='edit_batch_name' readonly='readonly'  value='" + batch_name + "'></td><td ><input type='text' name='edit_exp_date[]' id='edit_exp_date' readonly='readonly'  class='w-100' style='border: none;' value='" + exp_date + "'></td><td  ><input type='text' name='edit_qty[]' id='edit_sales_qty'  class='text-right w-100 edit_sales_qty' style='border: none;' value='"+qty+"'></td><td class='text-right' ><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span></td></tr>");

      $('#batch_name').val('');
      $('#exp_date').val('');
      $('#qty').val('');
    } else {
      alert("Invalid value ");
      return;
    }

  }

  function removeTableRowOnly(thisElement) {
    if (confirm("Are you sure?")) {
      $(thisElement).parents("tr").remove();
    }
    // billingEngine.calculateTotal(this);
    // billingEngine.calculatePayment(this);
    return;
  }
  $('.date_picker').datepicker({
    format: 'dd-mm-yyyy',
    autoclose: true,
    todayHighlight: true,
    clearBtn: true
  });
  openDoctorAutocomplete("#employee_code", 'hdn_item_item_id_0');
  // function calculateItemTotal(thisElement) {
	// 	var item_id = $(thisElement).parents("tr").find(".item_id").val();
	// 	var item_qnty = $("#hdn_item_qnty_" + item_id).val() * 1;
	// 	var item_rate = parseFloat($("#hdn_item_rate_" + item_id).attr('item_rate')) * 1;
	// 	$("#hdn_item_total_qnty_" + item_id).val(item_qnty * item_rate);
	// 	$("#exp_item_total" + item_id).html("");
	// 	$("#exp_item_total" + item_id).html(item_qnty * item_rate);

	// }

  function saveData(element) {
    let total_qty = 0;
    let sales_qty = $('#sales_qty').val();

    $('.data_class').each(function(tr) {
      let qty = parseFloat($(this).children("td").find(".edit_sales_qty").val());
      // parseFloat($(this).attr('data-qty'));
      var s_qty=parseFloat(qty);
      total_qty += s_qty;

    });
 

    if (sales_qty == total_qty) {
      var Data = $('#tbody_exp').children('tr');
      let batch_name = [];
      $('.data_class').each(function(tr) {
        // batch_name +=$(this).attr('data-batch_name')+"_"+$(this).attr('data-exp_date')+"_"+$(this).attr('data-qty')+'^';
        batch_name += $(this).attr('data-batch_name') + "_" + $(this).attr('data-exp_date') + "_" + $(this).children("td").find(".edit_sales_qty").val() + '^';
      });


      $.ajax({
        data: {
          batch_name: batch_name
        },
        url: "{{route('billing.save-expire-date')}}",
        type: "post",
        beforeSend: function() {
          blockUI();
        },
        success: function(data) {
          var item_id = $('#item_id').val();
          var eventstring = new String();
          eventstring = data.toString().replace(/"/g, "");
          eventstring = data.toString().replace("[", " ").replace("]", " ").replace(/"/g, "");

          var exp = eventstring.split(',');

          var edit_reple = '';
          edit_reple = eventstring.replace(/,/g, '|');
          var exp_length = exp.length;
          var exp_data = '';
          var exp_rep = '';
          var eventstr = '';
          var i;
          var add_qty = 0;
          var edit_action = '{{ route("billing.pos-expire-edit", ":id") }}';
          edit_action = edit_action.replace(':id', sales_qty + ':' + item_id + '^' + edit_reple);
          for (i = 0; i < exp_length; i++) {
            eventstr = exp[i].split('_');
            // exp_rep=exp[i].toString().replace("_", ",");
            exp_data += "<span class='btn btn-outline-primary bg-primary btn-sm mt-2 mr-2'>" + exp[i].toString().replace("_", ",").replace("_", ",") + "</span><input type='hidden' name='txt_expire_date[]' value='" + '' + item_id + '_' + eventstr[1] + "'><input type='hidden' name='txt_batch[]' value='" + item_id + '_' + eventstr[0] + "'><input type='hidden' name='batch_qty[]' value='" + item_id + '_' + eventstr[2] + "'>";
            var total_expi_qty = parseFloat(eventstr[2]);
            add_qty += total_expi_qty;
          }

          var edit = "<span Class='btn btn-sm btn-primary open-modal mt-2 mr-2'' data-id='' data-action='" + edit_action + "' data-modal='common-modal-sm' data-title='Edit Expire' title='Edit'><i class='fa fa-pencil-alt'></i></span>";
          $('#exp_show_' + item_id).html(exp_data + edit);
          $('#hdn_item_qnty_' + item_id).val(add_qty);
          // $('#hdn_item_qnty_' + item_id).attr('readonly', true);

          // calculateItemTotal(element);
					// billingEngine.calculateTotal(element);
         

          $('.modal-dialog').modal('hide');

          $.unblockUI();

        },
        complete: function() {
          $.unblockUI();
        },
        error: function(data) {
          var errors = jQuery.parseJSON(data.responseText).errors;
          error_messages = "";
          for (messages in errors) {
            var field_name = $("#" + messages).siblings("label").html();
            error_messages += "<div class='alert alert-danger' role='alert'>" + errors[messages] + "</div>";
          }

          $('.common-modal-notify-error').modal('show');
          $('.common-modal-notify-error .modal-title').html("Validation Error");
          $('.common-modal-notify-error .modal-body').html(error_messages);

          $.unblockUI();
        }
      })
    } else {
      alert("Invalid quantity");
      event.stopImmediatePropagation();
    }
  }
</script>