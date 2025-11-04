<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <form action="{{ route('pcrm.refferal-payment-update') }}" method="post" id="ref-pay-edit">
            @csrf
            <input type="hidden" name="invoice_no_pk" value="{{ $invoice_id }}">
            <input type="hidden" name="type" value="{{ $type }}">
            @php
                $total = 0;
            @endphp
            <div class="form-group row">
                @if (!empty($invoice_item_list))
                    @foreach ($invoice_item_list as $invoice)
                        <div class="col-md-6">
                            <input type="hidden" name="payment_id[]" value="{{ $invoice->refinvoice_no_pk }}">
                            <label for="category_lookup"
                                class="col-sm-12 col-form-label col-form-label-sm">{{ $invoice->item_name }} (Price:
                                {{ number_format($invoice->sales_amount, '2', '.', '') }})</label>
                            <div class="col-sm-12">
                                @if ($type == 1)
                                    <input type="text" class="form-control" name="item_payment_arr[]"
                                        onkeyup="calculateTotal(this)"
                                        value="{{ number_format($invoice->referral_amount_doc, '2', '.', '') }}"
                                        data-prev="{{ number_format($invoice->referral_amount_doc, '2', '.', '') }}">
                                @endif
                                @if ($type == 2)
                                    <input type="text" class="form-control" name="item_payment_arr[]"
                                        onkeyup="calculateTotal(this)"
                                        value="{{ number_format($invoice->referral_amount_first, '2', '.', '') }}"
                                        data-prev="{{ number_format($invoice->referral_amount_first, '2', '.', '') }}">
                                @endif
                                @if ($type == 3)
                                    <input type="text" class="form-control" name="item_payment_arr[]"
                                        onkeyup="calculateTotal(this)"
                                        value="{{ number_format($invoice->referral_amount_second, '2', '.', '') }}"
                                        data-prev="{{ number_format($invoice->referral_amount_second, '2', '.', '') }}">
                                @endif
                            </div>
                        </div>
                        @php
                            if ($type == 1) {
                                $total += $invoice->referral_amount_doc;
                            }
                            if ($type == 2) {
                                $total += $invoice->referral_amount_first;
                            }
                            if ($type == 3) {
                                $total += $invoice->referral_amount_second;
                            }
                        @endphp
                    @endforeach

                @endif



                <div class="col-md-12">
                    <label for="category_lookup" class="col-sm-12 col-form-label col-form-label-sm">Total </label>
                    <div class="col-sm-12">
                        <input type="hidden" id="actual_total" value="{{ number_format($total, '2', '.', '') }}">
                        <input type="text" id="total" class="form-control"
                            value="{{ number_format($total, '2', '.', '') }}">
                    </div>
                </div>



            </div>

            <div class="modal-footer mt-1 text-right">
                @php
                    $response_action = route('pcrm.processed-list');
                @endphp
                <button type="submit" class="btn btn-md btn-success"
                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save
                    changes</button>
                <button type="button" class="btn btn-md  btn-danger " data-dismiss="modal">Exit</button>

            </div>
        </form>
    </div>
</div>

<script>
    function calculateTotal(element) {

        var actual_total = $('#actual_total').val();
        var price = $(element).val() * 1;
        var prev_price = $(element).attr('data-prev') * 1;
        var total = parseFloat(actual_total) + parseFloat(price) - parseFloat(prev_price);

        $('#total').val(total);
    }
</script>
