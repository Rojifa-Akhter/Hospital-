


<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    table{
        border-collapse: collapse
    }
    @media (min-width: 1600px){
        .table td, .table th {
        font-size: unset !important;
        }
    }
    .table td, .table th {
        font-size: 12px !important;
    }
    .table>thead>tr>td{
        white-space: nowrap;
    }
    .table>tr>td{
        border: 1px solid #333;
    }
    .header-table{
        margin-top:40px;
    }
    .header-table tr td {
        font-size: 12px;
        line-height: 10px;
    }
</style>

@php 
    $amounts = array_column($voucher_details, 'trn_dr_account_amount');
    $total_debit = array_sum($amounts);
    $cr_amounts = array_column($voucher_details, 'trn_cr_account_amount');
    $total_credit = array_sum($cr_amounts);
@endphp

<div class="row">
    <div class="col-md-12">
        <table style="width: 100%;border-collapse: collapse" class="header-table">
            <tr>
                <td class="text-left" style="padding-left:5px"><strong>Posting ID</strong></td>
                <td class="text-left" style="padding-left:5px">{{$voucher_no}}</td>
                <td class="text-left" style="padding-left:5px"><strong>Total Dr</strong></td>
                <td class="text-left" style="padding-left:5px">{{number_format($total_debit,2)}}</strong></td>
            </tr>
            <tr>
                <td class="text-left" style="padding-left:5px"><strong>Document Date</strong></td>
                <td class="text-left" style="padding-left:5px">{{date("d/m/Y", strtotime($doc_date))}}</td>
                <td class="text-left" style="padding-left:5px"><strong>Total Cr</strong></td>
                <td class="text-left" style="padding-left:5px">{{number_format($total_credit,2)}}</td>
            </tr>
            <tr>
                <td class="text-left" style="padding-left:5px"><strong>Posting Date</strong></td>
                <td class="text-left" style="padding-left:5px">{{date("d/m/Y", strtotime($journal_date))}}</td>
            </tr>
            @if(is_array($voucher_details))

                @if($voucher_details[0]->file_path1 != '')
                <tr>
                    <td class="text-left" style="padding-left:5px"><strong>Attachment 1</strong></td>
                    <td class="text-left" style="padding-left:5px"><a href="{{asset('uploads/journal_post_documents/')}}/{{$voucher_details[0]->file_path1}}" download>{{$voucher_details[0]->file_path1}}</a></td>
                </tr>
                @endif
                @if($voucher_details[0]->file_path2 != '')
                <tr>
                    <td class="text-left" style="padding-left:5px"><strong>Attachment 2</strong></td>
                    <td class="text-left" style="padding-left:5px"><a href="{{asset('uploads/journal_post_documents/')}}/{{$voucher_details[0]->file_path2}}" download>{{$voucher_details[0]->file_path2}}</a></td>
                </tr>
                @endif
                @if($voucher_details[0]->file_path3 != '')
                <tr>
                    <td class="text-left" style="padding-left:5px"><strong>Attachment 3</strong></td>
                    <td class="text-left" style="padding-left:5px"><a href="{{asset('uploads/journal_post_documents/')}}/{{$voucher_details[0]->file_path3}}" download>{{$voucher_details[0]->file_path3}}</a></td>
                </tr>
                @endif
            @endif
            

            <tr>
                <td class="text-left" style="padding-left:5px"><strong>In Word</strong></td>
                @php
                    $numtoword = new NumberToWords\NumberToWords();
                    $numtowordtrans = $numtoword->getNumberTransformer('en');
                    $amounts = array_column($voucher_details, 'trn_dr_account_amount');
                    $total_debit = array_sum($amounts);
                    $text_total = $numtowordtrans->toWords($total_debit);
                @endphp
                <td class="text-left" style="padding-left:5px">{{Str::ucfirst($text_total)}}</td>   
            </tr>
        </table>
    </div>
</div>

<table class="table mb-0 mt-5" style="width: 100%;" cellspacing="0">
    <thead>
        <tr class="bg-primary">
            
            <td style="border: 1px solid #333; text-align:left; padding:3px; font-weight:bold;" width="12%">GL Code</td>
            <td style="border: 1px solid #333; text-align:left; padding:3px; font-weight:bold;" width="9%">Sub Ledger Type</td>
            <td style="border: 1px solid #333; text-align:left; padding:3px; font-weight:bold;" width="6%">Sub Ledger</td>
            <td style="border: 1px solid #333; text-align:left; padding:3px; font-weight:bold;" width="5%">Dr/Cr</td>
            <td style="border: 1px solid #333; text-align:left; padding:3px; font-weight:bold;" width="4%">Curr.</td>          
            <td style="border: 1px solid #333; text-align:left; padding:3px; font-weight:bold;" width="8%">Amount in Doc Curr.</td>
            <td style="border: 1px solid #333; text-align:left; padding:3px; font-weight:bold;" width="8%">Amount in Loc. Curr.</td>
            <td style="border: 1px solid #333;text-align:left; padding:3px; font-weight:bold;" width="10%">Company</td>
            <td style="border: 1px solid #333;text-align:left; padding:3px; font-weight:bold;" width="5%">Cost Center</td>
            <td style="border: 1px solid #333;text-align:left; padding:3px; font-weight:bold;" width="17%">Naration</td>
            <td style="border: 1px solid #333;text-align:left; padding:3px; font-weight:bold;" width="8%">Cheq. Date</td>
            <td style="border: 1px solid #333;text-align:left; padding:3px; font-weight:bold;" width="8%">Cheq. No</td>
        </tr>
    </thead>

    <tbody>
        @if(empty($voucher_details))
            <tr>
            <td colspan="12" class="text-center">No Data Found</td>
            </tr>
        @else

                        @foreach($voucher_details as $voucher)
                            <tr>
                                <td style="text-align: left; padding-bottom: 3px;"><a href="{{route('journal_show')}}?journal_id={{$voucher->journal_code}}" target="_blank"> {{$voucher->trn_account_code}}-{{ucwords(strtolower($voucher->account_name))}}</a></td>
                                <td style="text-align: left; padding-bottom: 3px;">{{$voucher->subledgertype_name}}</td>
                                <td style="text-align: left; padding-left: 3px; padding-bottom: 3px;">{{$voucher->subledger_name}}</td>
                                <td style="text-align: left; padding-left: 3px; padding-bottom: 3px;">{{$voucher->trn_dr_account_amount > 0 ? 'Debit' : 'Credit'}}</td>                                     
                                <td style="text-align: left; padding-bottom: 3px;">BDT</td>
                                <td style="text-align: right; padding-bottom: 3px;"> {{number_format($voucher->trn_dr_account_amount > 0 ? $voucher->trn_dr_account_amount : $voucher->trn_cr_account_amount,2)}}</td>
                                <td style="text-align: right; padding-bottom: 3px;"> {{number_format($voucher->trn_dr_account_amount > 0 ? $voucher->trn_dr_account_amount : $voucher->trn_cr_account_amount,2)}}</td>
                                <td style="text-align: left; padding-bottom: 3px;">{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</td>
                                <td style="padding-left: 3px; padding-bottom: 3px;">{{$voucher->costcenter_name}}</td>
                                <td style="padding-left: 3px; padding-bottom: 3px;">{{$voucher->narration_text}}</td>
                                <td style="padding-left: 3px; padding-bottom: 3px;">
                                    @if($voucher_type == 'BANK RECEIPT' || $voucher_type == 'BANK PAYMENT')
                                    {{date("Y-m-d",strtotime($voucher->bank_cheq_date))}}
                                    @endif
                                </td>
                                <td style="padding-left: 3px; padding-bottom: 3px;">
                                    @if($voucher_type == 'BANK RECEIPT' || $voucher_type == 'BANK PAYMENT')
                                        {{$voucher->bank_cheq_number}}
                                    @endif
                                </td>                               
                            </tr>
                        @endforeach
              
        @endif       
    </tbody>
</table>
