<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <span><strong>Batch No:</strong>{{ $hk_data->batch_no }},<strong>Item
                Name:</strong>{{ $hk_data->item_name }}<strong>,Stock Qty:</strong>{{ $hk_data->item_qty }}</span>
        <div class="modal-footer mt-1" style="width:100%;">
        </div>
        <form action="{{ route('consumption-store') }}" method="POST" id="housekeeping-consumption">
            @csrf
           <input type="hidden" class="form-control" id="hdn_generic_id" name="hdn_generic_id" value="" />
                <input type="hidden" value="{{ $hk_data->item_no_fk }}" class="item_id_hidden" name="item_id_hidden[]">
                {{-- <input type="hidden" value="rim" name="item_uom[]"> --}}
                <input type="hidden" value="{{ $hk_data->item_no_fk }}" name="uom_no_fk[]">
                <input type="hidden" value="{{ $hk_data->batch_no }}" name="item_batch_fk[]">
                <input type="hidden" value="{{ $hk_data->expiry_date }}" name="item_expire_date[]">
                <input type="hidden" value="{{ $hk_data->purchase_price }}" name="purchase_price[]">
                <input type="hidden" value="{{ $hk_data->sales_price }}" name="sales_price[]">
                 @php
                    $sales_price=$hk_data->sales_price;
                    // $internal_batch_no .= $hk_data->internal_batch_no_uq."<br>";
                    // $exp_date .=$hk_data->expiry_date."<br>";
                    // $batch_date .=$hk_data->batch_no."<br>";
                    // $cost_price .=$hk_data->sales_price."<br>";
                @endphp
<input type="hidden" class="hidden_batch_no_qty" id="hidden_batch_no_qty" name="hidden_batch_no_qty[]" value="{{$hk_data->internal_batch_no_uq.'_'.$hk_data->batch_no.'_'.$hk_data->expiry_date.'_'.$hk_data->item_no_fk.'_'.'0'.'_'.$hk_data->purchase_price.'_'.$sales_price.'_'.$hk_data->uom_no_fk.'_'.'0'.'_'.'0'}}">
{{-- <input type="hidden" class="hidden_batch_no_qty" id="hidden_batch_no_qty" name="hidden_batch_no_qty[]" value="10"> --}}
<input type="hidden" name="stockQty" value="{{ $hk_data->item_qty }}" id="stockQty">

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="document_date" class="col-form-label col-form-label-sm">Consumption
                        Date</label>
                    <input type="text" class="form-control form-control-sm date_picker" id="document_date"
                        name="document_date" placeholder="" required value="{{ date('d-m-Y') }}" />
                </div>

                <div class="col-md-6">
                    <label for="type" class="col-form-label">Type</label>
                    <select name="type" id="" class="form-control form-control-sm">
                        <option value="">Select One</option>
                        @if (!empty($constype))
                            @foreach ($constype as $key => $data)
                                <option value="{{ $key }}">
                                    {{ $data }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-md-6">
                    <label for="remarks_" class="col-form-label col-form-label-sm">Remarks</label>
                    <input type="text" class="form-control form-control-sm" id="remarks_" name="remarks_"
                        placeholder="Enter Remarks" />
                </div>
                 <div class="col-md-6">
                    <label for="consumption_qty" class="col-form-label col-form-label-sm">Consumption Qty <span class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="consumption_qty" name="consumption_qty"
                        placeholder="Enter Consumption Qty" onkeyup="consumptionqty(this)" required/>
                </div>

                <div class="col-md-12">
                    <label for="location_" class="col-form-label">Consumption
                        To</label>
                    <select class="form-control form-control-sm" id="" onchange="showHide(this.value)"
                        name="">
                        <option value="">Select One</option>
                        <option value="Patient">Patient</option>
                        <option value="Employee">Employee</option>
                        <option value="Event">Event</option>
                    </select>
                </div>
                <div class="modal-footer mt-1" style="width:100%;">
                </div>

                <div class="col-sm-12" id="pat_dev">
                    <input type="text" class="form-control form-control-sm" id="patient_id" name="patient_id"
                        placeholder="Patient Name" />
                    <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id"
                        value="" />
                </div>
                <div class="col-sm-12 d-none" id="emp_dev">
                    <input type="text" class="form-control form-control-sm" id="emp_id" name="emp_id"
                        placeholder="Employee Name" />
                    <input type="hidden" class="form-control" id="emp_id" name="hdn_doctor_id"
                        value="" />
                </div>

                <div class="col-sm-12 d-none" id="event_dev">
                    <input type="text" class="form-control form-control-sm" id="event_id" name="event_id"
                        placeholder="Event Name" />
                    <input type="hidden" class="form-control" id="hdn_event_id" name="hdn_event_id"
                        value="" />
                </div>

            </div>

            <div class="modal-footer mt-1" style="width:100%;">
            </div>
            @php
                $response_action = url('housekeeping.index');
            @endphp
            <button type="submit" class="btn btn-md btn-outline-success"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save
                changes</button>
        </form>
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openPatientAutocomplete('#patient_id', 'patient_name');
    openDoctorAutocomplete('#emp_id', 'hdn_doctor_id', 'employee_ind', '1');
    openEventAutocomplete('#event_id', '#hdn_event_id', 'EVENT');

    $(".date_picker").datepicker({
        format: 'dd-mm-yyyy',
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
    })


    function showHide(value) {
        console.log(value);
        if (value == 'Patient') {
            $('#pat_dev').removeClass('d-none');
            $('#emp_dev').addClass('d-none');
            $('#event_dev').addClass('d-none');
        }
        if (value == 'Event') {
            $('#pat_dev').addClass('d-none');
            $('#emp_dev').addClass('d-none');
            $('#event_dev').removeClass('d-none');
        }
        if (value == 'Employee') {
            $('#pat_dev').addClass('d-none');
            $('#emp_dev').removeClass('d-none');
            $('#event_dev').addClass('d-none');
        }
    }
    function consumptionqty(thisElement){
        var qty = $(thisElement).val();
        if(stockQty < qty){
alert('Stock Qty is less then Enter Qty')
return;
        }else{
            var hdn_value = $("#hidden_batch_no_qty").val();
        var split_val = hdn_value.split("_");
        console.log(split_val)
        $("#hidden_batch_no_qty").val(split_val[0]+'_'+split_val[1]+'_'+split_val[2]+'_'+split_val[3]+'_'+qty+'_'+split_val[5]+'_'+split_val[6]+'_'+split_val[7]+'_'+split_val[8]+'_'+split_val[9])

        }

    }
</script>
