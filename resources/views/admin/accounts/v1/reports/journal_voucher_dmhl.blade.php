<style type="text/css">
    body {
        font-family: IBM Plex Sans, Helvetica, Arial, sans-serif;
        font-size:11px;
    }
    @page{
        margin-bottom: 30px
    }
    h2,h3,h4 {
        margin:0;
    }
    .mt {
        margin-top:10px;
    }
    .mb {
        margin-top:10px;
    }
    .text_align_center {
        text-align: center;
    }
    .head_td {
        border: 1px solid #666;
        margin: 0;
        padding: 3px;
    }

    .head_td_rec {
        margin: 0;
        padding: 2px;
    }
    .text-right{
        text-align: right;
    }

    .text-left{
        text-align: left;
    }

    .head_td_total_double_line {
        margin: 0;
        padding: 3px;
        border-bottom: 5px double #333;
        border-top: 2px solid #333;
    }
    .container {
        margin: 10px 10px 10px 10px;
    }

    .voucher_title{
        margin: 3px 0 0 0;
        font-size: 14px;
    }
    .td-border{
        border: 1px solid #333;
    }
    .footer-table{
        position: fixed;
        left:0px;
        right:0px;
        bottom: 20px;
        width: 100%;
    }
    .footer-text-height{
        line-height: 10px;
    }
    .title-narration{
        line-height: 12px;
        text-align: justify;
    }
    .signature{
        margin-top: 80px;
        height:150px;
    }
</style>
<div class="container">
    <table style="width: 100%;">
            <tr>
                <td style="width:20%">
                    <div>
                        @if(!empty($voucher_hospital_details->logo))
                            <img src="{{ asset('images/uploads/hospital_images/thumb/' . $voucher_hospital_details->logo) }}" width="80px" />
                        @endif
                    </div>
                </td>
                <td style="width:80%">    
                    <div class="text_align_center">
                        <h1>{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h1>
                        <h3>{{ isset($org_info->addrress1) ? $org_info->addrress1 : ""}}</h3>            
                        <div class="voucher_title" style="margin-top: 10px;">
                            <h3 style="margin-bottom: 10px;text-decoration:underline">
                                @php
                                    switch($voucher_type) {
                                        case 'CASH RECEIPT':
                                            echo "Cash Receive Voucher";
                                            $voucher = 'Cash';
                                            break;
                                        case 'BANK RECEIPT':
                                            echo "Bank Receive Voucher";
                                            $voucher = 'Bank';
                                            break;
                                        case 'CASH PAYMENT':
                                            echo "Cash Payment Voucher";
                                            $voucher = 'Cash';
                                            break;
                                        case 'BANK PAYMENT':
                                            echo "Bank Payment Voucher";
                                            $voucher = 'Bank';
                                            break;
                                        case 'JOURNAL':
                                            echo "Journal Voucher";
                                            $voucher = 'Journal';
                                            break;               
                                        default:
                                            $voucher =  ucwords(strtolower($voucher_type.' VOUCHER'));
                                            echo $voucher;                               
                                    }
                                @endphp
                            </h3>
                        
                        </div>
                    </div>
                </td>
                <td style="width:20%"></td>
            </tr>
            
    </table>
    <div class="row mb">
        <table style="width: 100%;">
            <tr>
                <td class="text-left">Voucher No: <strong>{{$voucher_no}}</strong></td>
                <td class="text-center">Posting Date: <strong>{{date('d/m/Y', strtotime($journal_date))}}</strong></td>
                <td class="text-right">Document Date: <strong>{{date('d/m/Y', strtotime($doc_date))}}</strong></td>
            </tr>
        </table>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table style="width:100%" class="mt" cellspacing="0">
                <thead>
                    <tr>
                        <th class="head_td text-left" style="width:38%;border-left:none;border-right:none">GL</th>
                        <th class="head_td text-left" style="width:22%;border-left:none;border-right:none">Sub Ledger</th>
                        <th class="head_td text-left" style="width:20%;border-left:none;border-right:none">Cost Center</th>
                        <th class="head_td text-right" style="width:20%;border-left:none;border-right:none">Amount (Tk.)</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_debit = 0;
                        $total_credit = 0;
                        $journal_date = '';
                    @endphp

                    @foreach($voucher_details as $key => $voucher)
                        @if($voucher->trn_dr_account_amount > 0)
                            @if($key == 0)
                                <tr>
                                    <td colspan="4" style="padding-top:10px"><strong>Debit</strong></td>
                                </tr>
                            @endif
                            <tr>
                                <td class="head_td_rec text-left">
                                    <strong class="title-narration">{{$voucher->trn_account_code}}-{{ucwords(strtolower($voucher->account_name))}}</strong>
                                    <p style="font-style: italic; font-size:10px;margin-top:0px" class="title-narration">{{$voucher->narration_text}}@if(! empty($voucher->bank_cheq_number))<br> Cheque No: {{$voucher->bank_cheq_number}} @endif @if(!empty($voucher->bank_cheq_date))Cheque Date: {{date('d/m/Y',strtotime($voucher->bank_cheq_date))}} @endif</p>
                                </td>
                                <td>{{ $voucher->subledger_name}}</td>
                                <td>{{ $voucher->costcenter_name}}</td>
                                <td class="head_td_rec text-right">{{number_format($voucher->trn_dr_account_amount,2)}}</td>
                            </tr>
                            @php
                                $total_debit += $voucher->trn_dr_account_amount;                               
                            @endphp
                        @endif
                    @endforeach
                    <tr>
                        <td style="text-align: right; font-weight:bold;" colspan="3">
                            Total Debit(TK.)
                        </td>
                        <td class="head_td_total_double_line text-right font-weight-bold">{{number_format($total_debit,2)}}</td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>
                    <tr>
                        <td></td>
                        <td></td>
                        <td></td>
                        <td></td>
                    </tr>

                    @foreach($voucher_details as $key2 => $voucher)
                        @if($key2 == 0)
                                <tr>
                                    <td colspan="4"><strong>Credit</strong></td>
                                </tr>
                        @endif
                        @if($voucher->trn_cr_account_amount > 0)
                            
                            <tr>
                                <td class="head_td_rec text-left">
                                    <strong class="title-narration">{{$voucher->trn_account_code}}-{{ucwords(strtolower($voucher->account_name))}}</strong>
                                    <p style="font-style: italic; font-size:11px;margin-top:0px" class="title-narration">{{$voucher->narration_text}}@if(! empty($voucher->bank_cheq_number))<br>Cheque No: {{$voucher->bank_cheq_number}} @endif @if(!empty($voucher->bank_cheq_date))Cheque Date: {{date('d/m/Y',strtotime($voucher->bank_cheq_date))}} @endif</p>
                                </td>
                                <td>{{ $voucher->subledger_name}}</td>
                                <td>{{ $voucher->costcenter_name}}</td>
                                <td class="head_td_rec text-right">{{number_format($voucher->trn_cr_account_amount,2)}}</td>
                            </tr>

                            @php
                                $total_credit += $voucher->trn_cr_account_amount          
                            @endphp
                        @endif
                    @endforeach
                    <tr>
                        <td style="text-align: right; font-weight:bold;" colspan="3">
                            Total Credit(TK.)
                        </td>
                        <td class="head_td_total_double_line text-right font-weight-bold">{{number_format($total_credit,2)}}</td>
                    </tr>
                </tbody>
                
                <tr>
                    <td colspan="4" style="padding-top: 5px; padding-bottom:5px;">
                        @php
                            // $numtoword = new NumberToWords\NumberToWords();
                            // $numtowordtrans = $numtoword->getNumberTransformer('en');
                            // $text_total = $numtowordtrans->toWords($total_debit);
                            $text_total = getBangladeshCurrency($total_debit);
                        @endphp
                        <strong>In Word (Tk.): {{Str::ucfirst($text_total)}}</strong>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:left;font-weight:bold" >Cheque No: <span style="width: 100%; border-bottom: 1px solid #333;">{{$voucher->bank_cheq_number}}</span></td>
                    <td style="text-align: center;font-weight:bold" colspan="3">Cheque Date: <span style="width: 100%; border-bottom: 1px solid #333;">@if(! empty($voucher->bank_cheq_date)){{ date('d/m/Y', strtotime($voucher->bank_cheq_date))}}@endif</span></td>                    
                </tr>

            </table>






            <div class="signature">
                <table  style="width:100%">
                    <tbody>
                        <tr class="footer-text-height">
                            <td class="text-left" style="padding:0px;text-decoration:overline"><strong>Prepared By</strong></td>
                            <td class="text_align_center" style="padding:0px;text-decoration:overline"><strong>Checked By</strong></td>
                            <td class="text-right" style="padding:0px;text-decoration:overline"><strong>Approved By</strong></td>
                        </tr>
                        <tr class="footer-text-height">
                            <td class="text-left" style="padding:0px">{{is_array($voucher_details) ? $voucher_details[0]->prepare_by : ''}}</td>
                            <td class="text_align_center" style="padding:0px">{{is_array($voucher_details) ? $voucher_details[0]->verified_by : ''}}</td>
                            <td class="text-right" style="padding:0px">{{is_array($voucher_details) ? $voucher_details[0]->finalized_by: ''}}</td>
                        </tr>
        
        
                        <tr>
                            <td colspan="3" style="padding: 50px"></td>
                        </tr>
        
                        <tr class="footer-text-height">
                            <td class="text-left" style="padding:0px;text-decoration:overline"><strong>Paid By</strong></td>
                            <td class="text_align_center" style="padding:0px;text-decoration:overline"><strong>Received By</strong></td>
                            <td class="text-right" style="padding:0px;text-decoration:overline"><strong>Approved By</strong></td>
                        </tr>
                    </tbody>
                </table>
                
            </div>

            <!-- Footer -->
            <table style="width:100%" class="footer-table">
                <tr>                   
                    <td colspan="3" class="text-left">Print Date & Time: {{ date('j/n/Y g:i:s A') }}</td>
                </tr>
            </table>
            <!-- Close Footer -->

        </div>
    </div>

</div>