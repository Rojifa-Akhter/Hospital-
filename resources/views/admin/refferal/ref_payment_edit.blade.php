<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <form action="{{ route('v1.refferal-payment-update') }}" method="post" id="ref-pay-edit">
            @csrf
            <input type="hidden" name="invoice_no_pk" value="{{ $invoice_id }}">
            <input type="hidden" name="type" value="{{ $type }}">
            @php
                $total = 0;
            @endphp
            <div class="form-group row">
                @if (!empty($invoice_item_list))
                    @foreach ($invoice_item_list as $invoice)
                        @php

                            try {

                                $sales_amount = $invoice->item_rate * ($invoice->item_qty - $invoice->cancel_qty);
                                $sales_percentage = $sales_amount / $invoice->ledger_amt_sales;
                                // dd( $sales_percentage , $invoice->ledger_amt_sales, $sales_amount);
                                $payment_amount = $invoice->ledger_amt_payment * $sales_percentage;
                                $refferal_commoission = $payment_amount * ($invoice->referral_pay_pct / 100);

                        } catch (Exception $e) {
                            $refferal_commoission = 0;
                        }

                        @endphp

                        <div class="col-md-6">
                            <input type="hidden" name="payment_id[]" value="{{ $invoice->invoicedtl_no_pk }}">
                            <label for="category_lookup"
                                class="col-sm-12 col-form-label col-form-label-sm">{{ $invoice->item_name }} </label>
                            <div class="col-sm-12">
                                @if ($type == 1)
                                    <input type="text" class="form-control" name="item_payment_arr[]"
                                        onkeyup="calculateTotal(this)"
                                        value="{{ number_format($refferal_commoission, '2', '.', '') }}"
                                        data-prev="{{ number_format($refferal_commoission, '2', '.', '') }}">
                                @endif
                                @if ($type == 2)
                                    <input type="text" class="form-control" name="item_payment_arr[]"
                                        onkeyup="calculateTotal(this)"
                                        value="{{ number_format($refferal_commoission, '2', '.', '') }}"
                                        data-prev="{{ number_format($refferal_commoission, '2', '.', '') }}">
                                @endif
                                @if ($type == 3)
                                    <input type="text" class="form-control" name="item_payment_arr[]"
                                        onkeyup="calculateTotal(this)"
                                        value="{{ number_format($refferal_commoission, '2', '.', '') }}"
                                        data-prev="{{ number_format($refferal_commoission, '2', '.', '') }}">
                                @endif
                            </div>
                        </div>
                        @php
                            if ($type == 1) {
                                $total += $refferal_commoission;
                            }
                            if ($type == 2) {
                                $total += $refferal_commoission;
                            }
                            if ($type == 3) {
                                $total += $refferal_commoission;
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
                    $response_action = route('v1.refferal-payment');
                @endphp
                <button type="submit" class="btn btn-md btn-success"
                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save
                    Changes</button>
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
        var total = parseFloat(actual_total) - parseFloat(prev_price) + parseFloat(
            price); //parseFloat(actual_total) + - parseFloat(prev_price);

        $('#total').val(total);
    }
</script>
