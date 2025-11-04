<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered table-hover table-striped">
    <thead class="bg-primary">
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-center">Invoice No</th>
            <th class="text-center">Invoice Date</th>
            <th class="text-left">Doctor Name</th>
            <th class="text-left">First Ref.Doctor Name</th>
            <th class="text-left">Second Ref.Doctor Name</th>
            <th class="text-left">Item Name</th>
            <th class="text-center">Ledger Amt Sales</th>
            <th class="text-center">Ledger Amt Discount</th>
            <th class="text-center">Ledger Amt Payment</th>
            <th class="text-center">Ledger Amt Sales Net</th>
            <th class="text-center">Referral Amount Doc</th>
            <th class="text-center">Referral Amount First</th>
            <th class="text-center">Refferral Amount Second</th>
            <th class="text-center">Paid Amount</th>
            <th class="text-center">Ref. Inv. Date</th>
        </tr>
    </thead>
    <tbody>

        {{-- @if (isset($referral_arr))
        @php
        $total_item_rate = 0;
        $total_referral_amount = 0;
        $total_discount_amt_by_hos = 0;
        $total_discount_amt_by_doc = 0;
        $grand_total_referral_amount = 0;
        @endphp
        @foreach ($referral_arr as $key => $value)
        @php

        if( $card_no ==null)
        $col_span=11;
        else
        $col_span=10;
        @endphp
        <tr>
            <td class="" style="text-align: left" colspan="{{$col_span}}"> <strong>{{ $key }}
                </strong> </td>
        </tr>
        @php
        $item_rate = 0;
        $referral_amount = 0;
        $discount_amt_by_hos = 0;
        $discount_amt_by_doc = 0;
        $sub_total_referral_amount = 0;
        @endphp
        @foreach ($value as $data)

        @php
        $item_rate += $data->item_rate;
        $referral_amount += $data->referral_amount;
        $discount_amt_by_hos += $data->discount_amt_by_hos;
        $discount_amt_by_doc += $data->discount_amt_by_doc;
        $sub_total_referral_amount += number_format(number_format($data->referral_amount, 2) - number_format($data->discount_amt_by_doc, 2), 2);

        $total_item_rate += $data->item_rate;
        $total_referral_amount += $data->referral_amount;
        $total_discount_amt_by_hos += $data->discount_amt_by_hos;
        $total_discount_amt_by_doc += $data->discount_amt_by_doc;
        $grand_total_referral_amount += number_format(number_format($data->referral_amount, 2) - number_format($data->discount_amt_by_doc, 2), 2) ;
        @endphp
        <tr>
            <td class="text-center">{{ $loop->iteration }}</td>
            <td class="text-left">{{ $data->invoice_no_pk }}</td>
            <td class="text-left">
                {{ $data->invoice_date ? date('d/m/Y', strtotime($data->invoice_date)) : '' }}
            </td>
            @if( $card_no ==null)
            <td class="text-left">
                @if($data->full_name !=null && $data->full_name !="Self" )
                {{ $data->full_name }}
                @endif
                @if($data->first_ref_doc_name !=null)
                @if($data->full_name !=null && $data->full_name !="Self")
                <br>
                @endif
                {{ $data->first_ref_doc_name }}
                @endif

                @if($data->second_ref_doc_name !=null)
                @if($data->full_name !=null && $data->full_name !="Self" || $data->first_ref_doc_name !=null)
                <br>
                @endif
                {{ $data->second_ref_doc_name }}
                @endif

            </td>
            @endif

            <td class="text-left">{{ $data->item_name }}</td>

            <td class="text-right">{{ number_format($data->item_rate, 2) }}</td>
            <td class="text-right">{{ number_format($data->referral_amount, 2) }}</td>
            <td class="text-right">{{ number_format($data->discount_amt_by_hos, 2) }}</td>
            <td class="text-right">{{ number_format($data->discount_amt_by_doc, 2) }}</td>
            <td class="text-right">{{ number_format(number_format($data->referral_amount, 2) - number_format($data->discount_amt_by_doc, 2),2)  }}</td>
            <td class="text-right"></td>

        </tr>

        @endforeach

        @php
        if( $card_no ==null)
        $col_span=5;
        else
        $col_span=4;
        @endphp
        <tr>
            <td colspan="{{$col_span}}" class="text-right"> <strong>Department-wise sub total </strong> </td>
            <td class="text-right"> <strong>{{ number_format($item_rate, 2) }} </strong> </td>
            <td class="text-right"> <strong>{{ number_format($referral_amount, 2) }} </strong> </td>
            <td class="text-right"> <strong>{{ number_format($discount_amt_by_hos, 2) }} </strong> </td>
            <td class="text-right"> <strong>{{ number_format($discount_amt_by_doc, 2) }} </strong> </td>
            <td class="text-right"> <strong>{{number_format($sub_total_referral_amount,2)}}</strong> </td>
            <td></td>

        </tr>
        @endforeach
        <tr>
            <td colspan="{{$col_span}}" class="text-right"> <strong>Referral-wise grand total </strong> </td>
            <td class="text-right"> <strong>{{ number_format($total_item_rate, 2) }} </strong> </td>
            <td class="text-right"> <strong>{{ number_format($total_referral_amount, 2) }} </strong> </td>
            <td class="text-right"> <strong>{{ number_format($total_discount_amt_by_hos, 2) }} </strong> </td>
            <td class="text-right"> <strong>{{ number_format($total_discount_amt_by_doc, 2) }} </strong> </td>
            <td class="text-right"><strong>{{number_format($grand_total_referral_amount,2)}}</strong></td>
            <td></td>
        </tr>
        @endif --}}

		@if (!empty($referral_arr))
		@foreach ($referral_arr as $data)
		<tr>
			<td class="text-center">{{ $loop->iteration }}</td>
			<td class="text-center">{{ $data->invoice_no_pk }}</td>
			{{-- <td class="text-center">{{ $data->purchase_uid }}</td> --}}
			<td class="text-center">{{ date('d/m/Y', strtotime($data->invoice_date)) }}</td>
			<td class="text-left">{{ $data->doctor_name }}</td>
			<td class="text-left">{{ $data->first_ref_doc_name }}</td>
			<td class="text-left">{{ $data->sec_ref_doc_name}}</td>
			<td class="text-left">{{ $data->item_name }}</td>
			<td class="text-right">{{ number_format($data->ledger_amt_sales,2) }}</td>
			<td class="text-right">{{ number_format($data->ledger_amt_discount,2) }}</td>
			<td class="text-right">{{ number_format($data->ledger_amt_payment,2) }}</td>
			<td class="text-right">{{ number_format($data->ledger_amt_sales_net,2) }}</td>
			<td class="text-right">{{number_format($data->referral_amount_doc,2) }}</td>
			<td class="text-right">{{ number_format($data->referral_amount_first,2) }}</td>
			<td class="text-right">{{ number_format($data->referral_amount_second,2) }}</td>
			<td class="text-right">{{ number_format($data->paid_amount,2) }}</td>
			<td class="text-center">{{ date('d/m/Y', strtotime($data->refinvoice_date)) }}</td>
			{{-- <td class="text-left">{{ $data->po_status }}</td> --}}
			{{-- <td class="text-left">
				<form method="GET" action="{{ route('inventory.purchase_order_print', $data->purchaseorder_no_pk) }}"
					data-response-action="">
					@csrf
					<button class="btn btn-sm btn-primary text-left" type='submit' target="_blank">PO Pdf
					</button>
				</form>
				<button class="btn btn-sm btn-primary open-modal" data-id="{{$data->purchaseorder_no_pk}}" data-action="{{route('pcrm.po-no',$data->purchaseorder_no_pk)}}" data-modal="common-modal-sm" data-title="Supplier Wise PO Payment Report" data-dismiss="modal" aria-label="Close">Payment
				</button>
			</td> --}}

		</tr>
		@endforeach
		@endif
    </tbody>
</table>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $('.data-table').DataTable({
        "lengthMenu": [
            [50],
            [50]
        ],
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
