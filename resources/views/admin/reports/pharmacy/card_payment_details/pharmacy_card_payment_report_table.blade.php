<div class="table-responsive border-top border-right">
    <table class="table table-bordered table-hover mb-0">
        <thead class="bg-light-blue">
        <tr>
            <th class="text-center" scope="col">SL</th>
            <th class="text-center" scope="col">Invoice Id</th>
            <th class="text-center" scope="col" style="width:62px;">Invoice Date</th>
            <th class="text-center" scope="col">Patient</th>
            <th class="text-center" scope="col">Age</th>
            <th class="text-center" scope="col">Gender</th>
            <th class="text-center" scope="col">Contact</th>
            <th class="text-center" scope="col">Doctor</th>
            <th scope="col" class="text-right bg-light-blue">Payable</th>
            <th scope="col" class="text-right bg-light-blue">Discount</th>
            <th scope="col" class="text-right bg-light-blue">Net Payable</th>
            <th scope="col" class="text-right bg-light-blue">Card Description</th>
            <th scope="col" class="text-right bg-light-blue">Card Paid</th>
            <th scope="col" class="text-right bg-light-blue">Service Charge</th>
            <th scope="col" class="text-right bg-light-blue">Net Collection</th>
            <th class="text-center" scope="col" style="width: 80px;">Action</th>
        </tr>
        </thead>
        <tbody>
        @php
            $total_payable = $total_discount = $total_net_payable= $total_card_paid = $service_charge = $total_net_collection = 0;
        @endphp
        @if(!empty($report_data))
            @foreach($report_data as $key=>$row)
                <tr>
                    <td class="text-center bg-light">{{ $loop->iteration }}</td>
                    <td class="text-center">{{$row->invoice_code}} </td>
                    <td class="text-center" width="80px">{{ date("d/m/Y",strtotime($row->invoice_date)) }}</td>
                    <td class="text-center"><strong>{{ $row->patient_name }}</strong></td>
                    <td class="text-center" style="word-break: break-all; width: 60px;">{{ $row->age }}</td>
                    <td class="text-center">{{ $row->gender_txt }}</td>
                    <td class="text-center">{{ $row->mobile1 }}</td>
                    <td class="text-center">{{ $row->doctor_name }}</td>
                    <td class="text-right bg-light">{{ number_format($row->ledger_amt_sales, 2,".","") }}</td>
                    <td class="text-right bg-light">{{ number_format($row->ledger_amt_discount, 2,".","") }}</td>
{{--                    <td class="text-right bg-light">{{ number_format($row->net_payable, 2,".","") }}</td>--}}
                    <?php $net_payable = number_format($row->ledger_amt_sales, 2,".","") - number_format($row->ledger_amt_discount, 2,".",""); ?>
                    <td class="text-right">{{ number_format($net_payable, 2,".","") }}</td>
                    <td class="text-right">
                        <div><strong>Pay Mode:</strong>{{!empty($row->pay_mood_type)?$row->pay_mood_type:''}}</div>
                        <div><strong>Bank Name:</strong>{{$row->bank_name}}</div>
                        <div><strong>Transaction Id:</strong>{{$row->transaction_id}}</div>
                        <div><strong>Acc. Holder Name:</strong>{{$row->acc_holder_name}}</div>
                    </td>
                    <td>{{ number_format($row->card_payment, 2,".","")}}</td>
                    <td class="text-right bg-light">{{ number_format($row->bank_service_charge, 2,".","") }}</td>
                    <?php $net_collection = number_format($row->card_payment, 2,".","") - number_format($row->bank_service_charge, 2,".",""); ?>
                    <td class="text-right bg-light">{{ number_format($net_collection, 2,".","") }} </td>
                    <td style="width: 80px;">
                        <span Class="btn btn-sm btn-success open-modal btnView" data-action="{{ route('pos-invoice',$row->invoice_no_fk) }}" data-modal="common-modal-md" data-title="Invoice Details" title="View Invoice Details" data-id="{{ $row->invoice_no_fk }}"><i class="fa fa-eye"></i></span>

                        <a href="{{ route('bill-invoice-pos-print',$row->invoice_no_fk) }}" target="_blank" Class="btn btn-sm btn-warning" title="Print"><i class="fa fa-print"></i></a>
                    </td>
                </tr>
                @php
                    $total_payable += $row->ledger_amt_sales;
                    $total_discount += $row->ledger_amt_discount;
                    $total_net_payable += $row->ledger_amt_sales - $row->ledger_amt_discount;
                    $total_net_collection += $row->card_payment - $row->bank_service_charge;
                    $service_charge += $row->bank_service_charge;
                    $total_card_paid += $row->card_payment;
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
            <th class="text-right" scope="col" colspan="8">Total = </th>
            <th scope="col" class="text-right bg-light-blue">{{ number_format($total_payable,2,".","") }}</th>
            <th scope="col" class="text-right bg-light-blue">{{ number_format($total_discount,2,".","") }}</th>
            <th scope="col" class="text-right bg-light-blue">{{ number_format($total_net_payable,2,".","") }}</th>
            <th scope="col" class="text-right bg-light-blue" colspan="2">{{ number_format($total_card_paid,2,".","") }}</th>
            <th scope="col" class="text-right bg-light-blue" >{{ number_format($service_charge,2,".","") }}</th>
            <th scope="col" class="text-right bg-light-blue">{{ number_format($total_net_collection,2,".","") }}</th>
            <th class="text-center" scope="col" style="width: 80px;"></th>
        </tr>
        </tfoot>
    </table>
</div>

