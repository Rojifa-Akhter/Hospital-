@php

$bed = (isset($bed) && (!empty($bed))) ? $bed : [];

$bed_no_pk = ($bed) ? $bed->bed_no_pk : '';
$bed_uid = ($bed) ? $bed->bed_uid : '';
$bed_sl_no = ($bed) ? $bed->bed_sl_no : '';

$serviceunit_name = ($bed) ? $bed->su_no_fk : '';
$serviceItem_name = ($bed) ? $bed->bed_charge_item_no_fk : '';
$admission_fee_item_no_fk = ($bed) ? $bed->admission_fee_item_no_fk : '';
$bed_charge_item_no_fk = ($bed) ? $bed->bed_charge_amount : '';
$service_charge_item_no_fk = ($bed) ? $bed->service_charge_item_no_fk : '';
$others_charge_item_no_fk = ($bed) ? $bed->others_charge_item_no_fk : '';
$minimum_deposit_amount = ($bed) ? $bed->minimum_deposit_amount : '';
$remarks = ($bed) ? $bed->remarks : '';
$status = ($bed) ? $bed->status : '';

$bed_name = ($bed) ? $bed->bed_name : '';
$bed_status = ($bed) ? $bed->bed_status : '';
$bed_status = ($bed) ? $bed->bed_status : '';

$item = (isset($item) && (!empty($item))) ? $item : [];
$authorized_bed_ind = ($item) ? $item->authorized_bed_ind : '';
@endphp
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css')}}">

<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('bed.store-bed') }}" method="post" id="bed-create">
        @csrf
        <input type="hidden" name="id" value="{{ $bed_no_pk }}">
        @if(!empty($item_data))
            @foreach($item_data as $item)
            <input type="hidden" name="service_id" value="{{$item->item_no_pk}}">
            @endforeach
        @endif
        <div class="form-group row">
            <div class="col-md-6">
                <label for="su_name" class="">Service Item  <span class="text-danger">*</span></label>
                <div class="">
                   
                    <select class="form-control font_size_12 m-auto select2" onchange="bedCharge(this)" id="item_name" name="item_name" required>
                        <option selected="selected" data-price="0" value="">Select Service Item</option>
                        @foreach ($service_item as $record)
                        <option value="{{$record->item_no_pk}}" data-price="{{ $record->sales_price }}" {{$record->item_no_pk == $serviceItem_name ? 'selected' : ''}}>{{ $record->item_name }}</option>
                        @endforeach
                    </select>
                </div>
            </div>
            <div class="col-md-6">
                    <label for="su_name" class="">Service Unit</label>
                    <div class="">
                        <select class="form-control font_size_12 m-auto select2" onchange="bed.GetWard(this)" id="su_name" name="su_name" >
                            <option selected="selected" value="">Select Service Unit</option>
                            @foreach ($service as $record)
                            <option value="{{ $record->serviceunit_no_pk }}" {{$record->serviceunit_no_pk == $serviceunit_name ? 'selected' : ''}}>{{ $record->serviceunit_name }}</option>
                            @endforeach
                        </select>
                    </div>
            </div>

            {{--            <div class="col-md-6">--}}
                {{--                <label for="bad_cat" class="">Bed Category</label>--}}
                {{--                <div class="">--}}
                    {{--                    <select class="form-control font_size_12 m-auto select2" id="bad_cat" name="bad_cat">--}}
                        {{--                        <option selected="selected" value="">Select Bed</option>--}}
                        {{--                        @if(!empty($bed_cat))--}}
                        {{--                            @foreach($bed_cat as $pk => $patcon)--}}
                        {{--                                <option value="{{ $pk }}">{{ $patcon }}</option>--}}
                        {{--                            @endforeach--}}
                        {{--                        @endif--}}
                    {{--                    </select>--}}
                {{--                </div>--}}
            {{--            </div>--}}
            <div class="col-md-6">
                <label for="ward_no_fk" class="">Ward name</label>
                <div class="" id="ward_no_fk">
                    @include('admin.settings.bed.ward')
                </div>
            </div>
            <div class="col-md-6">
                <label for="su_name" class="">Serial No.<span class="text-danger">*</span></label>
                <div class="">
                    <input type="number" class="form-control form-control-sm" id="bed_sl_no" name="bed_sl_no" value="{{ $bed_sl_no }}" placeholder="Enter Order No." @if(Session::get('user.ses_hospital_code') == 'IMPERIAL') required @endif>

                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="bed_uid" class="">Bed Code <span class="text-danger">*</span></label>
                <div class="">
                    <input type="text" class="form-control form-control-sm" id="bed_uid" name="bed_uid" value="{{ $bed_uid }}" placeholder="Enter Bed Code" required>
                </div>
            </div>
            <div class="col-md-6">
                <label for="bed_name" class="">Bed Name <span class="text-danger">*</span></label>
                <div class="">
                    <input type="text" class="form-control form-control-sm" id="bed_name" name="bed_name" value="{{ $bed_name }}" placeholder="Enter Bed Name" required>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="admission_fee" class="">Admission fee</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="admission_fee" name="admission_fee" value="{{ $admission_fee_item_no_fk }}" placeholder="Enter Admission Fee" >
                </div>
            </div>
            <div class="col-md-6">
                <label for="bed_charge" class="">Bed Charge<span class="text-danger">*</span></label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" readonly="readonly" id="bed_charge" name="bed_charge" value="{{ $bed_charge_item_no_fk }}" placeholder="Enter Bed Charge" required>
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="other_charge" class="">Other Charge</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="other_charge" name="other_charge" value="{{ $others_charge_item_no_fk }}" placeholder="Enter Other Charge" >
                </div>
            </div>
            <div class="col-md-6">
                <label for="service_charge" class="">Service Charge</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="service_charge" name="service_charge" value="{{ $service_charge_item_no_fk}}" placeholder="Enter Service Charge" >
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="m_d_ammount" class="">Minimum Deposit Ammount</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="m_d_ammount" name="m_d_ammount" value="{{ $minimum_deposit_amount }}" placeholder="Enter Minimum Deposit Ammount" >
                </div>
            </div>
            <div class="col-md-6">
                <label for="bed_status" class="">Bed Status</label>
                <div class="">
                    <select class="form-control font_size_12 m-auto select2" id="bed_status" name="bed_status">
                        <option selected="selected" value="">Bed Status</option>
                        <option value="1" {{1 == $bed_status ? 'selected' : ''}}>Available</option>
                        <option value="2" {{2 == $bed_status ? 'selected' : ''}}>Occupied</option>
                        <option value="3" {{3 == $bed_status ? 'selected' : ''}}>Not Ready</option>
                    </select>
                </div>
            </div>
        </div>
        <div class="form-group row ">
            <div class="col-md-12">
                <label for="remark" class="">Remarks</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm" id="remark" name="remark" value="{{ $remarks }}" placeholder="Enter Remarks" >
                </div>
            </div>

        </div>

        <div class="form-row">
            <div class="col-md-6">
                <label for="active_beds" class="">Authorized Bed</label>
                <div class="">
                    <div class="form-check form-check-inline">
                        {{--                        <input class="form-check-input" type="checkbox" name="status" id="status" value="1" >--}}
                        <input class="form-check-input" type="checkbox" name="active_beds" id="active_beds" value="1" {{$authorized_bed_ind == '1' ? 'checked':''}}>
                        <label class="form-check-label" for="active_beds">Active</label>
                    </div>
                </div>
            </div>
            <div class="col-md-6">
                <label for="status" class="">Status</label>
                <div class="">
                    <div class="form-check form-check-inline">
                        {{--                        <input class="form-check-input" type="checkbox" name="status" id="status" value="1" >--}}
                        <input class="form-check-input" type="checkbox" name="status" id="status" value="1" {{$status == '1' ? 'checked':''}}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
            </div>
        </div>


        {{--<div class="form-group row">
            <div class="col-md-6">
                <div class="col-md-12">
                    <div class="form-check form-check-inline">
                       <input class="form-check-input" type="checkbox" name="confirm" id="confirm" value="1" >
                       <label class="form-check-label" for="confirm">Confirm</label>
                   </div>
               </div>
           </div>
       </div>--}}

       <div class="modal-footer">
        @php
        $response_action = route('bed.index');
        @endphp
        <button class="btn btn-success btn-md" onclick="btnSaveUpdate(this,'','','','', getBedList,'{{ $response_action }}')"> Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
        <button type="button" class="btn btn-danger btn-md" data-dismiss="modal">Close</button>
    </div>
</form>
</div>


<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
<script>
    $('.select2').select2({});

    var bed = {
        GetWard:function (thisElement) {
            var dept = $('#su_name').val();

            $.ajax({
                url:"{{route('bed.ward-list')}}",
                type:'POST',
                data: {
                   dept:dept
                },
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    $('#ward_no_fk').html(data);
                },
                complete: function () {
                    $.unblockUI();
                }
            });
        },
    };


    function bedCharge(element){
        // alert($(element option:selected).attr("data-price"));

        var price = $('option:selected', element).attr('data-price');
        $('#bed_charge').val(price);

    }

</script>
