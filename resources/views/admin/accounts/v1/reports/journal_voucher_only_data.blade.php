<style type="text/css">
    .preview_table {
        font-size:12px !important;
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

    .head_td_first {
        text-align: left;
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
        border-top: 5px double #333;
    }
    .container {
        margin: 10px 10px 10px 10px;
    }
    .td-border{
        border: 1px solid #333;
    }
</style>
<div class="container preview_table">
    <div class="row mb">
        <table style="width: 100%;">
            <tr>
                <td class="text-left">Voucher Date: <strong>{{date("d/m/Y", strtotime($journal_date))}}</strong></td>
                <td class="text-right">Voucher No: <strong>{{$voucher_no}}</strong></td>
            </tr>
        </table>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table style="width:100%" class="mt" cellspacing="0" class="">
                <thead>
                    <tr>
                        <th class="head_td text-left" style="width:45%;border-left:none;border-right:none">GL</th>
                        <th class="head_td text-left" style="width:15%;border-left:none;border-right:none">Sub Ledger</th>
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
                            $numtoword = new NumberToWords\NumberToWords();
                            $numtowordtrans = $numtoword->getNumberTransformer('en');
                            $text_total = $numtowordtrans->toWords($total_debit);
                        @endphp
                        <strong>In Word (Tk.): {{Str::ucfirst($text_total)}} @if(! empty($total_debit)) taka @endif only</strong>
                    </td>
                </tr>
                <tr>
                    <td style="text-align:left;font-weight:bold" >Cheque No: <span style="width: 100%; border-bottom: 1px solid #333;">{{$voucher->bank_cheq_number}}</span></td>
                    <td style="text-align: left;font-weight:bold">Cheque Date: <span style="width: 100%; border-bottom: 1px solid #333;">@if(! empty($voucher->bank_cheq_number)){{ date('d/m/Y', strtotime($voucher->bank_cheq_date))}} @endif</span></td>
                    <td colspan="2"></td>
                </tr>
            </table>
        </div>
    </div>
</div>