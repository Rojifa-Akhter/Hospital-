

<style>
    .journalReport table td {
        font-size: 12px !important;
        border: 1px solid #000 !important;
        white-space: nowrap; 
        padding: 2px 4px !important;
    }
    .journalReport{
        overflow-x:auto;
        border-collapse: collapse;
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
    } 
    .top-table td{
        border:none !important;
        padding: 1px 20px !important;
        font-size: 13px !important ;
    } 
</style>



            <h4 style="margin-top: 20px; text-align:center;" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>
            <h5 style="margin-bottom: 10px; text-transform:uppercase;margin-top: 20px; text-align:center;">Voucher Report</h5>
            <h6 class="mb" style="text-transform: uppercase;text-align:center">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h6>

            @if(!empty($root_info))
                <table class="top-table">
                    <tr>
                        <td><strong>Total Dr</strong></td>
                        <td colspan="2">{{number_format(collect($root_info->getData()->data)->sum('trn_dr_account_amount'),2)}}</td>                               
                    </tr>
                    <tr>
                        <td><strong>Total Cr</strong></td>
                        <td colspan="2">{{number_format(collect($root_info->getData()->data)->sum('trn_cr_account_amount'),2)}}</td>                               
                    </tr>
                    <tr>
                        <td><strong>In Word</strong></td>
                        @php 
                            $numtoword = new NumberToWords\NumberToWords();
                            $numtowordtrans = $numtoword->getNumberTransformer('en');
                            $total_debit = collect($root_info->getData()->data)->sum('trn_dr_account_amount');
                            $text_total = $numtowordtrans->toWords($total_debit);                               
                        @endphp
                        <td colspan="2">{{ucwords(strtolower($text_total))}}</td>                               
                    </tr>
                </table>
                <br>
                <br>
                <div class="journalReport">
                    <table class="journalReport">
                        <thead>
                            <tr>
                                <td>Voucher No</td>
                                <td>GL Code</td>
                                <td>Sub Ledger </td>
                                <td>Dr./Cr.</td>
                                <td>Curr</td>
                                <td>Amount in Doc. Curr.</td>
                                <td>Amount in Loc. Curr.</td>
                                <td>Company</td>
                                <td>Document Date</td>
                                <td>Posting Date</td>
                                <td>Cost Center</td>
                                <td style="white-space: nowrap">Narration</td>
                                <td>Cheq. Date</td>
                                <td>Cheq. No</td>
                            </tr>
                        </thead>

                        @forelse(collect($root_info->getData()->data) as $voucher)
                        <tr>
                            <td><a href="{{route('journal_show')}}?journal_id={{$voucher->journal_code}}" target="_blank">{{$voucher->journal_code}}</a></td>
                            <td>{{$voucher->trn_account_code}}-{{ucwords(strtolower($voucher->account_name))}}</td>
                            <td>{{$voucher->subledger_name}}</td>
                            <td>{{$voucher->trn_dr_account_amount > 0 ? 'Debit' : 'Credit'}}</td>                                     
                            <td>BDT</td>
                            <td class="text-right"> {{number_format($voucher->trn_dr_account_amount > 0 ? $voucher->trn_dr_account_amount : $voucher->trn_cr_account_amount,2)}}</td>
                            <td class="text-right"> {{number_format($voucher->trn_dr_account_amount > 0 ? $voucher->trn_dr_account_amount : $voucher->trn_cr_account_amount,2)}}</td>
                            <td>{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</td>
                            
                            <td>{{date('d/m/Y',strtotime($voucher->doc_date))}}</td>
                            <td>{{date('d/m/Y',strtotime($voucher->journal_date))}}</td>

                            <td>{{$voucher->costcenter_name}}</td>
                            <td style="white-space: nowrap">{{$voucher->narration_text}}</td>
                            <td>
                                @if(!empty($voucher->bank_cheq_date))
                                {{date("d/m/Y",strtotime($voucher->bank_cheq_date))}}
                                @endif
                            </td>
                            <td>
                                @if(!empty($voucher->bank_cheq_number))
                                    {{$voucher->bank_cheq_number}}
                                @endif
                            </td>                               
                        </tr>                               
                        @empty
                        <tr>
                            <td colspan="14" style="text-align: center"> No Data Found</td>
                        </tr>
                        @endforelse
                    </table>   
                </div>                
            @endif
 