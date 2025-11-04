<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<?php
$date=date('d-m-Y');
?>
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <form action="{{ route('loan.store') }}" method="post" id="loan-form">
            @csrf
            <input type="hidden" name="id" value="">
            
          <!--   <div class="form-group row">
                <div class="col-md-4">
                    <label for="batch_name" class="col-form-label col-form-label-sm">Batch No</label>
                    <select class="form-control select2 keep_me" id="batch_name"
                    name="batch_name" >
                    <option value="">Select Batch No</option>

                    <option value=""> N200</option>
                    <option value=""> N155</option>

                </select>
            </div>

            <div class="col-md-3">
                <label for="date" class="col-form-label col-form-label-sm">Exp. Date </label>
                <input type="text" class="form-control form-control-sm m-0 date_picker"
                id="date"
                name="date"  required placeholder="dd-mm-yyyy" value="{{ date('d-m-Y',strtotime($date)) }}" required/>
            </div>
            <div class="col-md-3">
                <label for="interest" class="col-form-label col-form-label-sm"> QTY</label>
                <input type="text" class="form-control form-control-sm number_only" id="interest" name="interest" value=""
                placeholder="Enter QTY" required> 
            </div>
            <div class="col-md-2 mt-4">
               <button class="btn btn-sm btn-info" onclick="expAdd()">Add</button>
           </div>
       </div> -->


 
       <table id="myTable">
        <tbody>
            <tr>
                <td >Batch No</td>
                <td class="w-25">Exp. Date</td>
                <td class="w-15">QTY</td>
                <td class="text-right">Action</td>
            </tr>
            <tr>
                <td>
                    <select class="form-control select2 keep_me" id="batch_name"
                    name="batch_name" >
                    <option value="">Select Batch No</option>

                    <option value="N200"> N200</option>
                    <option value="N155"> N155</option>

                </select>
            </td>
            <td>
             <input type="text" class="form-control form-control-sm m-0 date_picker"
             id="exp_date"
             name="exp_date"  required placeholder="dd-mm-yyyy" value="{{ date('d-m-Y',strtotime($date)) }}" />
         </td>
         <td>

            <input type="text" class="form-control form-control-sm number_only text-right" id="qty" name="qty" value=""
            placeholder="Enter QTY" > 
        </td>
        <td class="text-right"><button class="btn btn-sm btn-info" type="button" onclick="expAdd()">Add</button></td>
    </tr>

   <!--  <tr><td ><input type='text' style='border:none;' name='edit_batch_name[]' id='edit_batch_name' readonly='readonly'  value='B009'></td><td ><input type='text' name='edit_exp_date[]' id='edit_exp_date' readonly='readonly'  class='w-100' style='border: none;' value='05-02-2021'></td><td  ><input type='text' name='edit_qty[]' id='edit_qty' readonly='readonly' class='text-right w-100' style='border: none;' value='50'></td><td class='text-right' ><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span></td></tr>

    <tr><td ><input type='text' style='border:none;' name='edit_batch_name[]' id='edit_batch_name' readonly='readonly'  value='B010'></td><td ><input type='text' name='edit_exp_date[]' id='edit_exp_date' readonly='readonly'  class='w-100' style='border: none;' value='15-05-2021'></td><td  ><input type='text' name='edit_qty[]' id='edit_qty' readonly='readonly' class='text-right w-100' style='border: none;' value='100'></td><td class='text-right' ><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span></td></tr> -->
   
</tbody>
</table>


@php
$response_action = route('loan.index');
@endphp

<div class="text-left mt-5">
    <button type="submit" class="btn btn-md btn-success"
    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
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
    function expAdd(){

       var batch_name=$('#batch_name').val();
       var exp_date=$('#exp_date').val();
       var qty=$('#qty').val();
         if (qty !="") {
        $('#myTable tr:last').after("<tr><td ><input type='text' style='border:none;' name='edit_batch_name[]' id='edit_batch_name' readonly='readonly'  value='"+batch_name+"'></td><td ><input type='text' name='edit_exp_date[]' id='edit_exp_date' readonly='readonly'  class='w-100' style='border: none;' value='"+exp_date+"'></td><td  ><input type='text' name='edit_qty[]' id='edit_qty' readonly='readonly' class='text-right w-100' style='border: none;' value='"+qty+"'></td><td class='text-right' ><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span></td></tr>");

        $('#batch_name').val('');
        $('#exp_date').val('');
        $('#qty').val('');
    }else{
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


</script>
