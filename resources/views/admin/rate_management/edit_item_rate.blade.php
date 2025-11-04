@php
$item = isset($item) && !empty($item) ? $item : [];
$item_no_pk = $item ? $item->item_no_pk : '';
$sales_price = $item ? $item->sales_price : '';
$purchase_price = $item ? $item->purchase_price : '';
$item_status = $item ? $item->status : '';
$dealer_price = $item ? $item->dealer_sales_price : '';
$vat = $item ? $item->vat_percent : '';
$default_discount = $item ? $item->default_discount_pct : '';
$urgent_fee = $item ? $item->urgent_fee_pct : '';
$dis_inapplicable = $item ? $item->disc_aplicable : '';
$serviceunit_no_fk = $item ? $item->accounts_mapping_su_no_fk : '';
$non_stock_ind = $item ? $item->non_stock_ind : '';
$ipd_urg_pct = $item ? $item->ipd_urg_pct : '';
$max_disc_pct = $item ? $item->max_disc_pct : '';
@endphp

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('rate.management-update') }}" method="post" id="rate_management_update">
        @csrf
        <input type="hidden" name="id" id="item_id_pr" class="item_id_pr" value="{{ $item_no_pk }}">
        <input type="hidden" name="EditType" id="EditType" value="{{ isset($type) ? $type :'' }}">

        <div class="form-group row">
            <div class="col-md-6">
                <label for="sele_price" class="">Sales Price</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="sele_price"
                        name="item_sales_price" value="{{ $sales_price }}" placeholder="Enter Sales Price">
                </div>
            </div>

            <div class="col-md-6">
                <label for="purchase_price" class="">Purchase Price</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="purchase_price"
                        name="item_purchase_price" value="{{ $purchase_price }}" placeholder="Enter Purchase Price">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="dealer_sales_price" class="">Dealer Sales Price</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="dealer_price"
                        name="dealer_price" value="{{ $dealer_price }}" placeholder="Enter Dealer Sales Price">
                </div>
            </div>

            <div class="col-md-6">
                <label for="vat" class="">Vat</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="vat" name="vat"
                        value="{{ $vat }}" placeholder="Enter Vat">
                </div>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="default_discount" class="">Default Discount</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="default_discount"
                        name="default_discount" value="{{ $default_discount }}" placeholder="Enter Default Discount">
                </div>
            </div>

            <div class="col-md-6">
                <label for="urgent_fee" class="">Urgent fee</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="urgent_fee"
                        name="urgent_fee" value="{{ $urgent_fee }}" placeholder="Enter Urgent Fee">
                </div>
            </div>
            <div class="col-sm-6">
                <label for="accounts_service_unit" class="">Accounts Mapping SU</label>
                <select class="select2" id="accounts_service_unit" name="accounts_service_unit">
                    <option value="">Select Service Unit</option>
                    @if (isset($service_unit))
                        @foreach ($service_unit as $val)
                            <option value="{{ $val->serviceunit_no_pk }}"
                                {{ $serviceunit_no_fk == $val->serviceunit_no_pk ? 'selected' : '' }}>
                                {{ $val->serviceunit_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
            <div class="col-sm-6">
                <label for="accounts_service_unit" class="">Stock Type</label>
                <select class="form-control font_size_12 m-auto select2" id="stock_type" name="stock_type">
                    <option value="">Select One</option>
                    <option value="1" {{ $non_stock_ind == 1 ? 'selected' : '' }}>Non Stockable </option>

                    <option value="2" {{ $non_stock_ind == 2 ? 'selected' : '' }}>Stock </option>
                </select>
            </div>
        </div>
        <div class="form-group row">
            <div class="col-md-6">
                <label for="ipd_urg_pct" class="">IPD Charge (%)</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="ipd_urg_pct"
                        name="ipd_urg_pct" value="{{ $ipd_urg_pct }}" placeholder="Enter IPD Charge in percent">
                </div>
            </div>
            <div class="col-md-6">
                <label for="max_discount" class="">M. Value(%)</label>
                <div class="">
                    <input type="text" class="form-control form-control-sm number_only" id="max_discount"
                        name="max_discount" value="{{ $max_disc_pct }}" placeholder="Enter Max Discount percent">
                </div>
            </div>
        </div>

        <div class="form-group row ">
            <div class="col-sm-6">
                <label for="dis_inapplicable" class=" col-form-label col-form-label-sm mr-2"> Dis Inapplicable </label>
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="dis_inapplicable" id="dis_inapplicable"
                        value="1" {{ $dis_inapplicable == '1' ? 'checked' : '' }}>

                </div>
            </div>
            <div class="col-md-6">
                <label for="status" class="">Status</label>
                {{-- <div class=""> --}}
                <div class="form-check form-check-inline">
                    <input class="form-check-input" type="checkbox" name="status" id="status" value="1"
                        {{ $item_status == '1' ? 'checked' : '' }}>
                    {{-- <label class="form-check-label" for="status">Active</label> --}}
                </div>
                {{-- </div> --}}
            </div>

        </div>


        <div class="modal-footer">
         @php
                $dpr_exp= !empty($type)? explode('_',$type):null;
                //dd($dpr_exp);
         @endphp
            @if(isset($type) && !empty($type) && $dpr_exp[0]=="DPR")
            @php
                //dd(2);
            @endphp
            <button class="btn btn-success btn-md"
                onclick="btnSaveUpdate(this,'','','','', setItemRate());">
                Save</button>

            @else
            @php

              $response_action = route('rate.management/general');

             @endphp
            <button type="button" class="btn btn-success btn-md"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                Save</button>
            @endif
            <button type="button" class="btn btn-md btn-danger " data-dismiss="modal">Close</button>
            <a href="{{ route('home') }}" class="btn btn-info btn-md" rel="tab"
                title="Click here to go back to Dashboard" data-dismiss="modal">Exit</a>
        </div>
    </form>
</div>


<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2({});
        function setItemRate() {
            // setTimeout(function(){
                var item_id =$('.item_id_pr').val();
            var type =$('#EditType').val();
            var type_exp=type !=null ? type.split('_'):null;

            console.log(type_exp[0] +'_'+type_exp[1] +'_____dollar___Rate_type')

            var dollar_rate=type_exp !=null && type_exp[1] !='' ? type_exp[1] :0;
        //    alert(dollar_rate)

            var p_price_dollar =   dollar_rate > 0  ? (Number($('#purchase_price').val()) /dollar_rate) : Number($('#purchase_price').val()) ;

            var p_price = Number($('#purchase_price').val()) ;
            console.log(dollar_rate , p_price_dollar+'_____dollar___Rate')

        //   console.log(item_id ,type, p_price+'___________editRate')
            if (type!=null) {

                $('#last_pp_'+item_id).val(p_price);
                $('#item_rate_'+item_id).html(p_price_dollar.toFixed(2));
                return;
            }


            // },1000)

        }

    var bed = {
        GetWard: function(thisElement) {
            var dept = $('#su_name').val();

            $.ajax({
                url: "{{ route('bed.ward-list') }}",
                type: 'POST',
                data: {
                    dept: dept
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $('#ward_no_fk').html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
    };


    function bedCharge(element) {
        // alert($(element option:selected).attr("data-price"));

        var price = $('option:selected', element).attr('data-price');
        $('#bed_charge').val(price);

    }
</script>
