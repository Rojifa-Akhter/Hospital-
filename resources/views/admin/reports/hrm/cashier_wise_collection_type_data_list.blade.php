<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    th{
        vertical-align: top !important;
    }
</style>

<table class="table table-bordered table-striped mb-0 data-table">
    <thead>
        <tr class="bg-primary">
            <th class="text-center" rowspan="2">SL#</th>
            <th class="text-left" rowspan="2">Cashier</th>
            <th class="text-left" rowspan="2">Card No</th>
            <th colspan="6">Received</th>
            <th class="text-right" rowspan="2">Net Amount</th>
        </tr>
        <tr class="bg-primary">    
            <th class="text-right">Cash</th>
            <th class="text-right">Card</th>
            <th class="text-right">Mobile Banking</th>
            <th class="text-right">Cheque</th>
            <th class="text-right">Sub Total</th>
            <th class="text-right">Refund Amt</th>        
        </tr>
    </thead>
    <tbody>
    <div style="display: none">
        {{ $cash = 0 }}
        {{ $card = 0 }}
        {{ $mobile_banking = 0 }}
        {{ $cheque = 0 }}
        {{ $refund = 0 }}
        {{ $sub_total_amt = 0 }}
        {{ $net_amount_total = 0 }}
    </div>
  
    @if(!empty($data))
        @foreach($data as $row)
        @php
        $sub_totel=$row->cash + $row->card + $row->mbanking + $row->cheque ;
        $net_amount= $sub_totel-$row->refund ;
        @endphp
        <tr>
            <td class="text-center">{{$loop->iteration}}</td>
            <td class="text-left">{{$row->user_fullname}}</td>
            <td class="text-left">{{$row->user_code}}</td>
            <td class="text-right">{{$row->cash}}</td>
            <td class="text-right">{{$row->card}}</td>
            <td class="text-right">{{$row->mbanking}}</td>
            <td class="text-right">{{$row->cheque}}</td>
            <td class="text-right">{{$sub_totel}}</td>
            <td class="text-right">{{$row->refund}}</td>
            <td class="text-right">{{$net_amount}}</td>
        </tr>
        @php
            $cash += $row->cash;
            $card += $row->card;
            $mobile_banking += $row->mbanking;
            $cheque += $row->cheque;
            $refund += $row->refund;
            $sub_total_amt += $sub_totel;
            $net_amount_total += $net_amount;
        @endphp
        @endforeach
        <tr>
            <td colspan="3" class="text-right"><strong>Total = </strong></td>
            <td class="text-right"><strong>{{$cash}}</strong></td>
            <td class="text-right"><strong>{{$card}}</strong></td>
            <td class="text-right"><strong>{{$mobile_banking}}</strong></td>
            <td class="text-right"><strong>{{$cheque}}</strong></td>
            <td class="text-right"><strong>{{$sub_total_amt}}</strong></td>
            <td class="text-right"><strong>{{$refund}}</strong></td>
            <td class="text-right"><strong>{{$net_amount_total}}</strong></td>
        </tr>
    @endif
    </tbody>
  
</table>
<script type="application/javascript"
        src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
