@php
$item = isset($item) && !empty($item) ? $item : [];
$item_no_pk = $item ? $item->item_no_pk : '';
$sales_price = $item ? $item->sales_price : '';
$purchase_price = $item ? $item->purchase_price : '';
$item_status = $item ? $item->status : '';
@endphp

<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<div class="col-sm-12 col-lg-5 col-xl-12">
    <form action="{{ route('rate.management-update') }}" method="post" id="rate_management_update">
        @csrf
        <input type="hidden" name="id" value="{{ $item_no_pk }}">

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

        <div class="form-group row ">
            <div class="col-md-6">
                <label for="status" class="">Status</label>
                <div class="">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="status" id="status" value="1"
                            {{ $item_status == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>
                </div>
            </div>
        </div>


        <div class="modal-footer">
            @php
                $response_action = route('rate.management/general');
            @endphp
            <button class="btn btn-success btn-md"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                Save</button>
            <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
            <a href="{{ route('rate.management/general') }}" class="btn btn-danger btn-md" rel="tab"
                title="Click here to go back to Dashboard">Exit</a>
        </div>
    </form>
</div>


<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $('.select2').select2({});

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
