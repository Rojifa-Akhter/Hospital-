
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<form action="{{ route('ipd.save-msu-item') }}" method="post" id="dietCreate">
    @csrf

    <div class="row">
        <div class="col-md-2">


            <select class="form-control" id="service_point" name="service_point">
                @if(!empty($service_point))
                    @foreach ($service_point as $value)
                            <option selected value="{{ $value->serviceunit_no_pk }}" {{ $value->default_ind == 1 ? 'selected' : ''}}>{{ $value->serviceunit_name }}</option>
                    @endforeach
                @endif
            </select>
 
        </div>
        <div class="col-md-6">
            <input type="text" id="medicine_item" name="medicine_item" class="form-control form-control-sm" placeholder="Search Item">
            <input type="hidden" name="hdn_medicine_item_id" id="hdn_medicine_item_id" value="">
            <input type="hidden" name="patient_no_pk" id="patient_no_pk" value="{{ $patient_no_pk }}">
            <input type="hidden" name="admission_no_pk" id="admission_no_pk" value="{{ $admission_no_pk }}">
        </div>
        <div class="col-md-2">
            <input type="number" step="0.001" id="qty" name="qty" class="form-control form-control-sm text-right" placeholder="Qty" value="1">
        </div>

        <div class="col-md-2">
            <button type="button" class="btn btn-md btn-primary w-100" onclick="addItem()">Add</button>
        </div>
    </div>

    <div class="row mt-4">
        <div class="col-12">
            <table class="table medicine_add_cart">
                <thead>
                    <tr>
                        <th class="text-center" style="width:5%">#Sl</th>
                        <th class="text-center" style="width:15%">Item Code</th>
                        <th class="text-left" style="width:55%">Item Name</th>
                        <th class="text-left" style="width:10%">Qty</th>
                        <th class="text-center" style="width:15%">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr class="emptyCart">
                        <td class="text-center text-danger" colspan="5">Your cart is empty</td>
                    </tr>
                </tbody>
            </table>
        </div>
    </div>

    <div class="modal-footer">
        @php
            $response_action = route('ipd.patient-nursing-requisition', [$patient_no_pk, $admission_no_pk]);
        @endphp
        <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', '','{{ $response_action }}')">Indent Request</button>
 
    </div>
</form>


<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>

    $(document).ready(function() {
        openItemAutocompleteWithStockPrescriptionStoreWise($("#medicine_item"), 'MED,LIQ,TAB,INV', '#hdn_medicine_item_id','#medicine_item',  $('#service_point :selected').val());
    });
    function addItem(){
        $("tr.emptyCart").remove();
        var item_id = $("#hdn_medicine_item_id").val();
        var item_name = $("#medicine_item").val();
        var qty = $("#qty").val();

        if(item_id == null || item_id == ''){
            alert('Please select item');
            return false;
        }
        
        if(qty == 0 || qty == ''){
            alert('Please input qty');
            return false;
        }




        var count = $('.medicine_add_cart tbody tr').length;

        count+=1;
        tbl = `<tr class="border-0" id="tbl${count}">
                    <td class="py-1 px-1 border-0 text-center">
                        ${count}
                    </td>
                    <td class="py-1 border-0 text-center">
                        <input type="hidden" class="form-control form-control-sm m-0 p-0 item_element" id="item_id${count}" name="item_id[]" placeholder="Item Name" value="${item_id}">
                        ${item_id}
                    </td>
                    <td class="py-1 border-0 text-left">${item_name}</td>
                    <td class="py-1 px-1 border-0">
                        <input type="number" class="form-control form-control-sm" name="item_qty[]" value="${qty}">
                    </td>
                    <td class="py-1 px-1 border-0 text-center" id="med_td_action_${count}">
                        <span class="remove_row" onclick="removeRow('tbl${count}')"><i class="fas fa-trash" style="color:red"></i></span>
                    </td>
                </tr>`;

        $('.medicine_add_cart tbody').append(tbl);

        resetCart();
    }

    function removeRow(id){
        if(confirm('Are you sure ?')){
            $("#"+id).remove();

            if($('.medicine_add_cart tbody tr').length == 0){
                emptyTable();
            }
        }
    }

    function resetCart(){
        $("#hdn_medicine_item_id").val('');
        $("#medicine_item").val('');
        $("#qty").val(1);
    }
</script>

