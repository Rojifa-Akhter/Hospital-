<table id="datatable"
class="table data-table table-bordered table-hover table-striped bill-list">
<thead class="bg-primary">
    <tr>
        <th class="text-center w-5" scope="">SL</th>
        <th class="text-left " scope="">Invoice Info</th>
        <th class="text-left" scope="col">Patient Info</th>
        <th style="text-align: left" scope="col">Item Info</th>
        <th class="text-right " scope="col">Sales Amt.</th>
        {{-- <th class="text-right " scope="col">Discount Amt.</th>
        <th class="text-right " scope="col">Payment Amt.</th>
        <th class="text-right " scope="col">Due</th>
        <th class="text-right " scope="col">Refunt</th> --}}
        <th class="text-center " scope="col">Action</th>
    </tr>
</thead>
<tbody>
    @php
        $sl = 1;
        $net_sales = 0;
        $sales_cancel_amt = 0;
        $sales = 0;
        $refunt_amt = 0;
        $dis = 0;
        $payment = 0;
        $due = 0;
        $refund = 0;
        $payable = 0;
        $total_sales = 0;
        $total_sales_cancel_amt = 0;
        $total_net_sales = 0;
        $total_refund_amt = 0;
        $total_dis = 0;
        $total_payment = 0;
        $total_payable = 0;
        $total_due = 0;
        $total_refund = 0;
    @endphp
    @if (!empty($bill_info))

        @foreach ($bill_info as $value)
            @php
                $net_sales = $value->ledger_amt_sales != '' ? $value->ledger_amt_sales : 0;
                $sales_cancel_amt = $value->sales_cancel != '' ? $value->sales_cancel : 0;
                $sales = $value->sales != '' ? $value->sales : 0;
                $refunt_amt = $value->refund != '' ? $value->refund : 0;
                $dis = $value->discount != '' ? $value->discount : 0;
                $payment = $value->collection != '' ? $value->collection : 0;
                $payable = (($sales - $dis) - $refunt_amt) - $payment;
                $due = $payable >= 0 ? $payable : 0;
                $refund = $refunt_amt > 0 ? abs($refunt_amt) :0;
            @endphp
            <tr>
                <td class="text-center " scope="col">{{ $sl++ }}</td>
                <td class="text-left" scope="">
                    Invoice Id = {{ $value->invoice }} <br>
                    Invoice Date =
                    {{ $value->invoice_date != '' ? date('d/m/Y', strtotime($value->invoice_date)) : '' }}
                    <br>
                    Invoice time
                    ={{ $value->au_entry_time != '' ? date('h:i:s a', strtotime($value->au_entry_time)) : '' }}
                </td>
                <td class="text-left " scope="col">
                    Admission Id = {{ $value->admission_no_pk }} <br>
                    {{ $value->patient_code }} <br>
                    {{ $value->patient_name }} <br>
                    {{ $value->patient_gender }} <br>
                    {{ $value->mobile1 }} {{   $refunt_amt }}
                </td>
                <td style="text-align: left" scope="col">

                    @if (!empty($item_info))
                        @php
                            $no = 1;
                        @endphp
                         <table style="width: 100%">
                            <tr>
                                <th style="width: 5%"></th>
                                <th style="width: 65%;text-align:left">Name</th>
                                <th style="width: 10%;text-align:right">Qty</th>
                                <th style="width: 10%;text-align:right">Cx. Qty</th>
                                <th style="width: 20%;text-align:right">Amt.</th>
                            </tr>
                        @foreach ($item_info as $item)
                            @if ($value->invoice == $item->invoice_no_fk)
                                    <tr>
                                        <td style="width: 5%">{{ $no++ }}</td>
                                        <td style="width: 65%;">{{ $item->item_name }}</td>
                                        <td style="width: 10%;text-align:right">{{ $item->item_qty }}</td>
                                        <td style="width: 10%;text-align:right">{{ $item->cancel_qty }}</td>
                                        <td style="width: 20%;text-align:right">{{ $item->total_item_amt }}</td>
                                    </tr>

                            @endif
                        @endforeach
                    </table>
                    @endif

                </td>
                <td class="text-right " scope="col">{{ number_format(round($net_sales),2) }}</td>
                {{-- <td class="text-right " scope="col">{{ number_format($dis ,2)}}</td>
                <td class="text-right " scope="col">{{ number_format($payment,2) }}</td>
                <td class="text-right " scope="col">{{ number_format($due,2) }}</td>
                <td class="text-right " scope="col">{{ number_format($refund,2) }}</td> --}}
                <td class="text-center " scope="col">
                    <span Class="btn btn-sm btn-success open-modal btnView" data-action="{{route("pos-due-colletion-invoice", $value->invoice)}}" data-modal="common-modal-md" data-title="Invoice Details" title="View Invoice Details" data-id="{{$value->invoice}}"><i class="fa fa-eye"></i></span>
				<a href="{{route("due-invoice-pos-print-pos", $value->invoice)}}" target="_blank"Class="btn btn-sm btn-warning" title="Print">POS</a>
				<a href="{{route("pos-due-invoice-print", $value->invoice)}}" target="_blank"Class="btn btn-sm btn-warning" title="Print"><i class="fa fa-print"></i></a>
                </td>
            </tr>

            @php
            $total_net_sales += $net_sales;

            $total_sales +=  $sales;
            $total_sales_cancel_amt +=  $sales_cancel_amt;
            $total_refund_amt +=  $refunt_amt;
            $total_dis += $dis;
            $total_payment += $payment;
            $total_payable +=$payable;
            $total_due += $due;
            $total_refund +=  $refund;

        @endphp
        @endforeach

        <tr>
            <td class="text-right" colspan="4">

                <strong>  Sales Amt </strong> <br>
                <strong>  Cancel Amt </strong> <br>
                <strong> Net Sales Amt </strong> <br>
                <strong> Total Discount </strong><br>
                {{-- <strong> Total Refund </strong><br> --}}
                <strong> Total Payment </strong><br>
                <strong> Total Due</strong><br>
                <strong> Total Refund</strong>

            </td>
            <td class="text-right " scope="col" >
                @php
                //   $total_payment = $total_payment ;
                  $total_payment = $total_payment -abs($total_refund_amt);
                //   dd( $total_payment , $total_refund_amt);
                    $due_refunt=($total_net_sales - $total_dis)  - $total_payment ;
                    // dd($total_net_sales , $total_dis ,$total_payment );
                @endphp
                {{-- @dd(   (($total_net_sales - $total_dis) ) - $total_payment ) --}}
                {{-- @dd(   (($total_net_sales - $total_dis) - $total_refund_amt) - $total_payment ) --}}
                <strong>{{ number_format($total_sales, 2) }} </strong><br>
                <strong>{{ number_format($total_sales_cancel_amt, 2) }} </strong><br>
                <strong>{{ number_format( $total_net_sales, 2) }} </strong><br>
                <strong>{{ number_format($total_dis, 2) }} </strong><br>
                {{-- <strong>{{ number_format($total_refund_amt, 2) }} </strong><br> --}}
                <strong>{{ number_format($total_payment, 2) }} </strong><br>
                <strong>{{ $due_refunt >=0?  number_format($due_refunt, 2) : 0 }} </strong><br>
                <strong>{{ $due_refunt < 0?  number_format(abs($due_refunt), 2) : 0}} </strong>

            </td>
            {{-- <td class="text-right " scope="col"> <strong> {{ number_format($total_dis,2) }} </strong> </td>
            <td class="text-right " scope="col"> <strong> {{ number_format($total_payment,2) }} </strong> </td>
            <td class="text-right " scope="col"> <strong> {{ number_format($total_due,2) }} </strong> </td>
            <td class="text-right " scope="col"> <strong>{{ number_format($total_refund,2) }} </strong> </td> --}}

        </tr>
    @endif


</tbody>
</table>
