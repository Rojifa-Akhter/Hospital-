<style type="text/css">
    body {
        font-family: IBM Plex Sans, Helvetica, Arial, sans-serif;
        font-size: 11px;
    }

    table td {
        font-size: 12px;
        border: 1px solid #333;
    }
    .text-right{
        text-align: right;
    }
    td, th{
        white-space: nowrap;
    }
</style>


    <div style="text-align: center;">
    <h2>{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h2>

    </div>
    <div class="voucher_title" style="margin-top: 0px; text-align:center;">
        <h3 style="margin-bottom: 10px; text-transform:uppercase;">
            General Ledger Wise Report
        </h3>
        <h3 class="mb" style="text-transform: uppercase">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h3>
        <h4 class="mb">{!!@$search_type!!}</h4>
    </div>
 



<table style="width: 100%;" cellspacing="0" id="trialBalanceDatatable">
    <thead>
        <th class="text-left" style="width:7%">Date</th>
        <th class="text-left" style="width:8%">Journal Id</th>
        <th class="text-left" style="width:8%">Journal Type</th>
        <th class="text-left" style="width:10%">Sub Ledger Name</th>
        <th class="text-left" style="width:8%">Debit</th>
        <th class="text-left" style="width:8%">Credit</th>
        <th class="text-left" style="width:10%">Balance</th>
        <th class="text-left" style="width:7%">Cheque No</th>
        <th class="text-left" style="width:7%">Cheque Date</th>
        <th class="text-left" style="width:10%">Naration</th>
        <th class="text-left" style="width:7%">Note</th>
        <th class="text-left" style="width:10%">Entry By</th>
    </thead>

    <tbody>
        <tr>
            <td colspan="6" class="text-center">Opening Balance</td>
            <td class="text-right">{{$opening_balance}}</td>
            <td colspan="5"></td>
        </tr>
       @forelse($data as $item)
            @php 
                $balance = floatVal($item->dr) - floatVal($item->cr);
                
                $journal_date = '';
                if(!empty($item->journal_date)){
                    $dateTime = DateTime::createFromFormat('Y-m-d', substr($item->journal_date,0,10)); 
                    $journal_date = $dateTime->format('d/m/Y'); 
                }

                $cheque_date = '';
                if(!empty($item->bank_cheq_date)){
                    $dateTime = DateTime::createFromFormat('Y-m-d', substr($item->bank_cheq_date,0,10)); 
                    $cheque_date = $dateTime->format('d/m/Y'); 
                }
            @endphp

            <tr>
                <td>{{$journal_date}}</td>
                <td><a target="new" href="{{route('view_journal')}}?journal_id={{$item->journal_code}}">{{$item->journal_code}}</a></td>
                <td>{{$item->voucher_type_name}}</td>
                <td>{{$item->subledger_name}}</td>
                <td style="text-align:right">{{number_format($item->dr, 2)}}</td>
                <td style="text-align:right">{{number_format($item->cr, 2)}}</td>
                <td style="text-align:right">{{number_format($balance, 2)}}</td>
                <td>{{$item->bank_cheq_number}}</td>
                <td>{{$cheque_date}}</td>
                <td>{{$item->narration_text}}</td>
                <td>{{$item->voucher_remarks}}</td>
                <td>{{$item->prepare_by}}</td>
            </tr>
       @empty
        <tr>
             <td colspan="12" class="text-danger text-center">Data Not Found</td>
        </tr>
       @endforelse

        @php 
            $total_dr = collect($data)->sum('dr');
            $total_cr = collect($data)->sum('cr');

            $total_balance = floatVal($total_dr) - floatVal($total_cr);
            $total_balance+= floatVal($opening_balance);
        @endphp

        @if(count($data) > 0)
            <tr>
                <td colspan="4" style="text-align: right"><b>Total</b></td>
                <td style="text-align:right">{{number_format($total_dr, 2)}}</td>
                <td style="text-align:right">{{number_format($total_cr, 2)}}</td>
                <td style="text-align:right">{{number_format($total_balance, 2)}}</td>
                <td colspan="5"></td>
            </tr>
       @endif
       
    </tbody>


</table>




