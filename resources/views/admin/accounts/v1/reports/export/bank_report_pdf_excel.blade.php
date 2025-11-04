

<style>
    table {
        width: 100%; 
        }
    table td {
        font-size: 13px;
        border: 1px solid #333;
        padding-right:3px;
        white-space: nowrap;
    }
    .mb{
        margin-bottom:0px
    }
    thead{
        background-color: #5C5F7A ;
        vertical-align: middle;
        color:white;
    }
</style>

    <h4 style="text-align:center;margin-bottom:5px" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>
    <div class="voucher_title" style="margin-top: 0px; text-align:center;">
        <h5 style="text-transform:uppercase;margin:0px 0px">Bank Report</h5>
        <h6 style="margin:0px 0px;font-size:12px">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h6>
        <h6 style="margin:5px 0px;">{{@$ledger_details[0]->account_name}}</h6>

    </div>

    @if(!empty($ledger_details))
    <table style="width: 100%;" cellspacing="0" id="trialBalanceDatatable" class="table table-bordered table-hover table-striped">
        <thead class="bg-primary">
            <tr>
                <td style="width:10%" class="text-left">Cheque No</td>
                <td style="width:8%" class="text-center">Cheque Date</td>
                <td style="width:30%">Vendor Name</td>
                <td style="width:15%">Dr. Amount</td>
                <td style="width:47%">Remarks</td>
            </tr>
        </thead>
       <tbody>
        <tr>
            <td colspan="3" class="text-center"><b>Opening Balance</b></td>
            <td class="text-right">@if($opening_bal >= 0) {{number_format($opening_bal,2)}} @else {{'('.number_format(abs($opening_bal),2).')'}} @endif</td>
            <td></td>
        </tr>
        @forelse($ledger_details as $item)
        <tr>
            {{-- <td><a target="new" href="{{route('view_journal')}}?journal_id={{$item->journal_code}}">{{$item->journal_code}}</a></td>
            <td class="text-center">@if(!empty($item->journal_date)) {{date('d/m/Y',strtotime($item->journal_date))}} @endif</td> --}}
            <td class="text-left"> {{$item->bank_cheq_number}}</td>
            <td class="text-center">@if(!empty($item->bank_cheq_date)) {{date('d/m/Y',strtotime($item->bank_cheq_date))}} @endif</td>
            <td>{{$item->subledger_name}}</td>
            <td style="text-align:right;">@if($item->dr >= 0) {{number_format($item->dr,2)}} @else {{'('.number_format(abs($item->dr),2).')'}} @endif</td>
            <td>{{$item->voucher_remarks}}</td>
        </tr>
        @empty
            <tr>
                <td colspan="5" class="text-center text-danger">Data not found!</td>
            </tr>
        @endforelse

        <tr>
            @php  $total_amount = collect($ledger_details)->sum('dr') + $opening_bal @endphp
            <td colspan="3" class="text-center"><b>Total</b></td>
            <td class="text-right">@if($total_amount >= 0) {{number_format($total_amount,2)}} @else {{'('.number_format(abs($total_amount),2).')'}} @endif</td>
            <td></td>
        </tr>
       </tbody>
    </table>
    @endif
