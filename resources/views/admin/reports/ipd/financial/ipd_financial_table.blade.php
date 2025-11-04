<div class="table-responsive border-top border-right">
    <table class="table table-bordered table-hover mb-0">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center" scope="col">SL</th>
{{--                <th class="text-center" scope="col">Voucher</th>--}}
                <th class="text-center" scope="col" style="width:62px;">Date</th>
                <th class="text-center" scope="col">Patient</th>
                <th class="text-center" scope="col">Age</th>
                <th class="text-center" scope="col">Gender</th>
                <th class="text-center" scope="col">Contact</th>
                <th class="text-center" scope="col">Doctor</th>
                {{--                <th class="text-left" scope="col">Referral</th>--}}
                <th scope="col" class="text-right global-uhl-table-bg">Payable</th>
                <th scope="col" class="text-right global-uhl-table-bg">Discount</th>
                <th scope="col" class="text-right global-uhl-table-bg">Net Payable</th>
                <th scope="col" class="text-right global-uhl-table-bg">Paid</th>
                <th scope="col" class="text-right global-uhl-table-bg">Due</th>
                <th scope="col" class="text-right global-uhl-table-bg">Refund</th>
                <th class="text-center" scope="col" style="width: 80px;">Action</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total_payable = $total_discount = $total_net_payable = $total_paid = $total_due = $total_refund = 0;
            @endphp
            @if(!empty($report_data))
            @foreach($report_data as $key=>$row)
            @php
             $refund=0;
             $due=0;
            if($row->due >= 0){
            $due=$row->due;
             }else{
              $refund=abs($row->due);
            }

        @endphp

        <tr>
            <td class="text-center global-uhl-table-bg">{{ $loop->iteration }}</td>
            <td class="text-left" width="80px">
                <div>{{ date("d/m/Y",strtotime($row->invc_date)) }}</div>
                <div>{{ date("h:m A",strtotime($row->invc_date)) }}</div>
            </td>
            <td class="text-left"><strong>{{ $row->patient_code }}</strong>  {{ $row->patient_name }}</td>
            <td class="text-left" style="word-break: break-all; width: 60px;">{{ $row->age }}</td>
            <td class="text-left">{{ $row->gender_txt }}</td>
            <td class="text-left">{{ $row->mobile1 }}</td>
            {{--                <td class="text-left">{{ $row->prescribed_physio_name }}</td>--}}
            <td class="text-left">{{ $row->doctor_name }}</td>
            <td class="text-right global-uhl-table-bg">{{ number_format($row->ledger_amt_sales, 2,".","") }}</td>
            <td class="text-right global-uhl-table-bg">{{ number_format($row->ledger_amt_discount, 2,".","") }}</td>
            <td class="text-right global-uhl-table-bg">{{ number_format($row->net_payable, 2,".","") }}</td>
            <td class="text-right global-uhl-table-bg">{{ number_format($row->ledger_amt_payment, 2,".","") }}</td>
            <td class="text-right global-uhl-table-bg" id="due">{{number_format($due, 2,".","")  }}</td>
            <td class="text-right global-uhl-table-bg" id="refund">{{  number_format($refund, 2,".","")  }}</td>
            <td style="width: 80px;">
{{--                <span Class="btn btn-sm btn-success open-modal btnView" data-action="{{route("ipd.ipd-final-bill-print",$row->admission_no_pk)}}" data-modal="common-modal-md" data-title="Invoice Details" title="View Invoice Details" data-id="{{ $row->admission_no_pk }}"><i class="fa fa-eye"></i></span>--}}
                <a href="{{route("ipd.ipd-final-bill-print",$row->admission_no_pk)}}" target="_blank" Class="btn btn-sm btn-warning" title="Print"><i class="fa fa-print"></i></a>
            </td>
        </tr>
        @php
        $total_payable += $row->ledger_amt_sales;
        $total_discount += $row->ledger_amt_discount;
        $total_net_payable += $row->net_payable;
        $total_paid += $row->ledger_amt_payment;
        $total_due += $due;
        $total_refund += $refund;
        @endphp
        @endforeach
        @else
        <tr>
            <th class="text-center" scope="col" colspan="16">No Data Available</th>
        </tr>
        @endif
    </tbody>
    <tfoot>
        <tr>
            <th class="text-right" scope="col" colspan="7">Total = </th>
            <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_payable,2,".","") }}</th>
            <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_discount,2,".","") }}</th>
            <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_net_payable,2,".","") }}</th>
            <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_paid,2,".","") }}</th>
            <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_due,2,".","") }}</th>
            <th scope="col" class="text-right global-uhl-table-bg">{{ number_format($total_refund,2,".","") }}</th>
            <th class="text-center" scope="col" style="width: 80px;"></th>
        </tr>
    </tfoot>
</table>
</div>

