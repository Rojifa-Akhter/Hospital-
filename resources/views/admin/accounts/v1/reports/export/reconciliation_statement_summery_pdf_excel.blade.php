

<style>
    .journalReport table td {
        font-size: 12px !important;
        border: 1px solid #e9e8eb ;
        white-space: nowrap; 
        padding: 2px 4px !important;
    }
    .end{
        display: flex;
        justify-content: end;
    }
    .list-group-item{
        border:none !important;
        padding: 5px 5px !important;
        padding-bottom: 0px !important;
        background-color: unset;
    }
    .pdf-icon{
        font-size: 22px;
        color: red
    }
    .excel-icon{
        font-size: 22px;
        color:green
    }
    .list-group-item.active {
     background-color: unset !important;
    }
    .journalReport{
        overflow-x:auto;
    }  
    .journalReport table>thead>tr{
        background-color: #98a2b3 !important;
        color:white;
    }  
    .journalReport table>thead>tr>td{
        padding-right:20px !important;
    } 
    .top-table{
        width:100%;
        margin-bottom: 20px;
    } 

    .top-table td{
        border:none !important;
        padding: 0px 0px !important;
        font-size: 13px !important ;
    } 

</style>

@php
      $hospital_code = DB::table('WSEC_HOSPITAL')->first()->hospital_code;
@endphp
    <h4 style="text-align:center;" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>
    <h5 style="margin-bottom: 5px; text-transform:uppercase;text-align:center;">Bank Reconciled Report</h5>
    <h6 style="margin-bottom: 5px; margin-top: 0px; text-transform:uppercase;text-align:center;">Bank: {{$account->account_code}} - {{$account->account_name}}</h6>
    <h6 class="mb" style="text-transform: uppercase;text-align:center;margin-top: 0px;">As at {{ date("F", mktime(0, 0, 0, $month, 1))}} {{$year}}</h6>     

    @php
        $diff = 0;
        $diff = floatVal($statement_balance) - floatVal($booked_amount); 
    @endphp
    <table class="top-table" style="width:100%">
        <tr>
            <td style="width:20%"><strong>Bank Statement Balance</strong></td>
            <td style="width:20%;text-align:right">@if($statement_balance >= 0) {{number_format($statement_balance,2)}} @else {{ "(".number_format(abs($statement_balance),2).")"}} @endif</td>     
            <td style="width:60%"></td>                          
        </tr>
        <tr>
            <td style="width:20%"><strong>Bank Booked Balance</strong></td>
            <td style="width:20%;text-align:right">@if($booked_amount >= 0) {{number_format($booked_amount,2)}} @else {{ "(".number_format(abs($booked_amount),2).")"}} @endif</td>   
            <td style="width:60%"></td>                             
        </tr>
        <tr>
            <td style="width:20%"><strong>Differences</strong></td>
            <td style="width:20%;text-align:right"> @if($diff >= 0) {{number_format($diff ,2)}} @else {{ "(".number_format(abs($diff),2).")"}} @endif</td> 
            <td style="width:60%"></td>                               
        </tr>
    </table>

    <div class="journalReport">
        <table cellspacing="0" class="journalReport" id="bankReconciledDatatable" style="width:100%">
            <thead>
                <tr>
                    <td>Document Date</td>
                    <td>Reconciled Date</td>

                    <td>Journal ID</td>
                    <td>Amount (Debit)</td>
                    <td>Amount (Credit)</td>
                    <td>Cheq. No.</td>
                    <td>Reconciled</td>
                    <td>Comments</td>
                </tr>
            </thead>

            <tbody>
            @foreach($reconciled_current as $item)
                @php
                    $dateTime = DateTime::createFromFormat('Y-m-d', substr($item->journal_date,0,10)); 
                    $journal_date = $dateTime->format('d/m/Y'); 

                    $reconcile_date = '';
                    if(!empty($item->reconcile_date)){
                        $dateTime = DateTime::createFromFormat('Y-m-d', substr($item->reconcile_date,0,10)); 
                        $reconcile_date = $dateTime->format('d/m/Y');
                    }
                @endphp
                <tr>
                    <td class="text-center">{{$journal_date}}</td>
                    <td class="text-center">{{$reconcile_date}}</td>
                    <td class="text-center">
                        @if($hospital_code == 'EWMCH')
                            <a href="{{ route('account.payment-voucher-report-show', ['voucher_id' => $item->journal_code]) }}" target="_blank">{{$item->journal_code}}</a>
                        @else
                            <a href="{{route('journal_show')}}?journal_id={{$item->journal_code}}" target="_blank">{{$item->journal_code}}</a>
                        @endif
                    </td>
                    <td >{{number_format($item->trn_dr_account_amount,2)}}</td>
                    <td class="text-right">{{number_format($item->trn_cr_account_amount,2)}}</td>
                    <td class="text-center">{{$item->bank_cheq_number}}</td>
                    <td class="text-center">{{$item->finalized_entry_by}}</td>
                    <td class="text-center">{{$item->remarks}}</td>
                </tr>
            @endforeach



            <!-- prev reconciled -->
            @if($reconciled_prev->count() > 0)
                <tr>
                    <td style="border-right:none !important"><strong>Prev. Reconciled</strong></td>
                    <td style="display:none;border-left:none !important"></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                </tr>
            @endif

            @foreach($reconciled_prev as $item)
                @php
                    $dateTime = DateTime::createFromFormat('Y-m-d', substr($item->journal_date,0,10)); 
                    $journal_date = $dateTime->format('d/m/Y'); 

                    $reconcile_date = '';
                    if(!empty($item->reconcile_date)){
                        $dateTime = DateTime::createFromFormat('Y-m-d', substr($item->reconcile_date,0,10)); 
                        $reconcile_date = $dateTime->format('d/m/Y');
                    }
                @endphp
                <tr>
                    <td class="text-center">{{$journal_date}}</td>
                    <td class="text-center">{{$reconcile_date}}</td>
                    <td class="text-center">
                        @if($hospital_code == 'EWMCH')
                            <a href="{{ route('account.payment-voucher-report-show', ['voucher_id' => $item->journal_code]) }}" target="_blank">{{$item->journal_code}}</a>
                        @else
                            <a href="{{route('journal_show')}}?journal_id={{$item->journal_code}}" target="_blank">{{$item->journal_code}}</a>
                        @endif
                    </td>
                    <td >{{number_format($item->trn_dr_account_amount,2)}}</td>
                    <td class="text-right">{{number_format($item->trn_cr_account_amount,2)}}</td>
                    <td class="text-center">{{$item->bank_cheq_number}}</td>
                    <td class="text-center">{{$item->finalized_entry_by}}</td>
                    <td class="text-center">{{$item->remarks}}</td>
                </tr>
            @endforeach

            <!-- close prev reconciled  -->

            @if($non_reconciled_current->count() > 0)
                <tr>
                    <td><strong>Not Reconciled</strong></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                </tr>
            @endif


            @foreach($non_reconciled_current as $item)
                @php
                        $dateTime = DateTime::createFromFormat('Y-m-d', substr($item->journal_date,0,10)); 
                         $journal_date = $dateTime->format('d/m/Y'); 
                         $reconcile_date = '';
                        if(!empty($item->reconcile_date)){
                            $dateTime = DateTime::createFromFormat('Y-m-d', substr($item->reconcile_date,0,10)); 
                            $reconcile_date = $dateTime->format('d/m/Y');
                        }

                @endphp
                <tr>
                    <td class="text-center">{{$journal_date}}</td>
                    <td class="text-center">{{$reconcile_date}}</td>
                    <td class="text-center">
                        @if($hospital_code == 'EWMCH')
                            <a href="{{ route('account.payment-voucher-report-show', ['voucher_id' => $item->journal_code]) }}" target="_blank">{{$item->journal_code}}</a>
                        @else
                            <a href="{{route('journal_show')}}?journal_id={{$item->journal_code}}" target="_blank">{{$item->journal_code}}</a>
                        @endif
                    </td>
                    <td >{{number_format($item->trn_dr_account_amount,2)}}</td>
                    <td class="text-right">{{number_format($item->trn_cr_account_amount,2)}}</td>
                    <td class="text-center">{{$item->bank_cheq_number}}</td>
                    <td class="text-center">{{$item->finalized_entry_by}}</td>
                    <td class="text-center">{{$item->remarks}}</td>
                </tr>
            @endforeach

            <!-- Prev non reconciled -->
            @if($non_reconciled_prev->count() > 0)
                <tr>
                    <td><strong>Prev. Not Reconciled</strong></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                    <td style="display:none"></td>
                </tr>
            @endif

            @foreach($non_reconciled_prev as $item)
                @php
                    $dateTime = DateTime::createFromFormat('Y-m-d', substr($item->journal_date,0,10)); 
                    $journal_date = $dateTime->format('d/m/Y'); 

                    $reconcile_date = '';
                    if(!empty($item->reconcile_date)){
                        $dateTime = DateTime::createFromFormat('Y-m-d', substr($item->reconcile_date,0,10)); 
                        $reconcile_date = $dateTime->format('d/m/Y');
                    }

                @endphp
                <tr>
                    <td class="text-center">{{$journal_date}}</td>
                    <td class="text-center">{{$reconcile_date}}</td>
                    <td class="text-center">
                        @if($hospital_code == 'EWMCH')
                            <a href="{{ route('account.payment-voucher-report-show', ['voucher_id' => $item->journal_code]) }}" target="_blank">{{$item->journal_code}}</a>
                        @else
                            <a href="{{route('journal_show')}}?journal_id={{$item->journal_code}}" target="_blank">{{$item->journal_code}}</a>
                        @endif
                    </td>
                    <td >{{number_format($item->trn_dr_account_amount,2)}}</td>
                    <td class="text-right">{{number_format($item->trn_cr_account_amount,2)}}</td>
                    <td class="text-center">{{$item->bank_cheq_number}}</td>
                    <td class="text-center">{{$item->finalized_entry_by}}</td>
                    <td class="text-center">{{$item->remarks}}</td>
                </tr>
            @endforeach

            <!-- close prev non reconciled -->


            @if($non_reconciled_current->count() == 0 && $reconciled_current->count() == 0 && $reconciled_prev->count() == 0 && $non_reconciled_prev->count() == 0)
                <tr>
                    <td colspan="8" class="text-center text-danger">No Data Found</td>
                </tr>
            @endif
            </tbody>
        </table>   
    </div>                

 
