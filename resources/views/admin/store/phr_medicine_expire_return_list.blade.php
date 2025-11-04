<div>
    <h3>Total Item Qty = {{ array_sum($total_item) }} , Total Purchase Price =
        {{ number_format(array_sum($total_amt), 2) }} , Total Sales Price
        ={{ number_format(array_sum($total_sales_amt), 2) }} </h3>
    <form action="{{ route('pharmacy.expire-return-store') }}" method="post" id="returnStore">
        <label for="return_type">Return Type <span class="text-danger">*</span> : </label>
        <select name="return_type" id="return_type" required>
            <option value="">select</option>
            <option value="EXPIRED">EXPIRED</option>
            <option value="DAMAGE">DAMAGE</option>
        </select>
        {{-- <label for="store">Store <span class="text-danger">*</span> : </label>
        <select name="store" id="store" required>
            <option value="">select</option>
            @if(!empty($store_name))
            @foreach($store_name as $value)
            <option value="{{$value->serviceunit_no_pk}}">{{$value->serviceunit_name}}</option>  
            @endforeach        
            @endif
        </select> --}}
        <table class="table data-table table-bordered m-0 data-table">
            <thead class="bg-primary">
                <tr>
                    <th class="text-center " scope="col">SL</th>
                    <th class="text-center " scope="col"> <input type="checkbox" name="all_check" id="all_check"
                            onclick="all_check_calculate(this)"> </th>
                    <th class="text-center " scope="col">Stock TRN. Dtl. No</th>
                    <th class="text-center " scope="col">Item Code</th>
                    <th class="text-center " scope="col">Item Name</th>
                    <th class="text-center " scope="col">UoM</th>
                    <th class="text-center" scope="col">Batch NO</th>
                    <th class="text-center " scope="col">Expire Date</th>
                    <th class="text-center " scope="col">Purchase <br> Qty</th>
                    <th class="text-center " scope="col">Returned <br> Qty</th>
                    <th class="text-center " scope="col">Return <br> Qty</th>
                    <th class="text-center " scope="col">Supplier Name</th>
                    <th class="text-center " scope="col">Store Name</th>
                    <th class="text-right " scope="col">Sales Price</th>
                    <th class="text-right " scope="col">Purchase <br> Price</th>
                    <th class="text-right" scope="col">Total Amt.</th>

                </tr>
            </thead>
            <tbody>
                @if (!empty($expire_med_list))
                    @foreach ($expire_med_list as $value)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-left"> <input type="checkbox" name="return_check[]" class="return_check"
                                    id="return_check"
                                    value="{{ $value->item_no_fk . '_' . ' ' . '_' . $value->purchase_price }}_{{ $value->expiry_date != '' ? date('d/m/Y', strtotime($value->expiry_date)) : '' }}_{{ $value->batch_no }}_{{ $value->stocktrans_dtl_no_pk }}"
                                    onclick="amount_calculate(this)">
                                <input type="hidden" name="item_id_hdn" id="item_id_hdn"
                                    value="{{ $value->item_no_fk }}">
                            </td>
                            <td class="text-left" id="trn_no">{{ $value->stocktrans_dtl_no_pk }}</td>
                            <td class="text-left">{{ $value->item_code }}</td>
                            <td class="text-left">{{ $value->item_name }}</td>
                            <td class="text-left">{{ $value->pr_uom_name }}</td>
                            <td class="text-left" id="batch_no">{{ $value->batch_no }}</td>
                            <td class="text-left" id="exp_date">
                                {{ $value->expiry_date != '' ? date('d/m/Y', strtotime($value->expiry_date)) : '' }}
                            </td>
                            <td class="text-right" id="">{{ $value->item_qty }}</td>
                            <td class="text-right" id="">
                                <!-- {{ $value->item_qty }} -->
                            </td>
                            <td class="text-right" id=""> <input type="text" style="width: 100px"
                                    name="qty" id="qty" value="" onkeyup="priceEdit(this)"> </td>
                            <td class="text-right">
                                {{ $value->supplier_name }}
                                <input type="hidden" name="store_name" id="store_name"
                                    value="{{ $value->stock_su_no_fk }}">
                            </td>
                            <td class="text-right">{{ $value->serviceunit_name }}</td>
                            <td class="text-right">{{ number_format($value->sales_price, 2) }}</td>
                            <td class="text-right"> <input type="text" style="text-align: right; width:100px"
                                    name="p_price" id="p_price"
                                    value="{{ number_format($value->purchase_price, 2) }}" class="number_only"
                                    onkeyup="priceEdit(this)"> </td>
                            <td class="text-right" id="item_total">
                                {{-- {{ number_format($value->purchase_price * $value->item_qty, 2) }} --}}
                            </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>
                <tr>

                    <td class='text-right' colspan="15">
                        <strong> Total Amount : </strong> <br>
                        {{-- <strong> Total Dis. : </strong> <br> --}}
                        {{-- <strong> Net Amount : </strong> --}}
                    </td>
                    <td class="text-right">
                        <input type="text" name="total_amt" id="total_amt" value="0.00"
                            class="number_only text-right" readonly> <br>
                        <input type="hidden" name="total_dis_amt" id="total_dis_amt" value="0.00"
                            class="number_only text-right">
                        {{-- <input type="text" name="net_amt" id="net_amt" value="0.00"
                            class="number_only text-right" readonly> --}}
                    </td>
                </tr>

            </tfoot>
        </table>
        @php
            $redirect_url = route('pharmacy.expire-return');
        @endphp


        <button type="submit" class="btn btn-md btn-success" onclick="receiveChalan(this)"
            data-response_action="{{ $redirect_url }}">Save</button>
    </form>
</div>
