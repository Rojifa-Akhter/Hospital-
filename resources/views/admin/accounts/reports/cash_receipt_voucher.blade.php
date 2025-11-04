<style type="text/css">
    body {
        font-family: IBM Plex Sans, Helvetica, Arial, sans-serif;
        font-size:11px;
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

    .voucher_title{
        margin: 3px 0 0 0;
    }

    .td-border{
        border: 1px solid #333;
    }
</style>
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="text_align_center">
            <h2>{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h2>
            <h4>{{ isset($org_info->addrress1) ? $org_info->addrress1 : ""}}</h4>
            <h4>{{isset($org_info->telephone1) ? $org_info->telephone1 : "" }}</h4>
            <div class="voucher_title" style="margin-top: 10px;">
                <h3 style="margin-bottom: 10px;">
                    @php
                        switch($voucher_type) {
                            case 'CASH RECEIPT':
                                echo "Receive Voucher";
                                $voucher = 'Cash';
                                break;
                            case 'BANK RECEIPT':
                                echo "Receive Voucher";
                                $voucher = 'Bank';
                                break;
                            case 'CASH PAYMENT':
                                echo "Payment Voucher";
                                $voucher = 'Cash';
                                break;
                            case 'BANK PAYMENT':
                                echo "Payment Voucher";
                                $voucher = 'Bank';
                                break;
                            case 'JOURNAL':
                                echo "Journal Voucher";
                                $voucher = 'Journal';
                                break;
                            default:
                                echo "Journal Voucher";
                                $voucher = 'Journal';
                        }
                    @endphp
                </h3>
                <h3>@if($voucher_contra == 1) Contra @else {{$voucher}} @endif</h3>
            </div>
            </div>
        </div>
    </div>
    <div class="row mb">
        <table style="width: 100%;">
            <tr>
                <td class="text-left">Voucher Date: <strong>{{date("d/m/Y", strtotime($journal_date))}}</strong></td>
                <td class="text-right">Voucher No: <strong>{{$voucher_no}}</strong></td>
            </tr>
            <tr>
                <td></td>
                <td class="text-right">Print Date: <strong>{{date("d/m/Y", strtotime(date("Y/m/d")))}}</strong></td>
            </tr>
        </table>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table style="width:100%" class="mt" cellspacing="0">
                <thead>
                    <tr>
                        <th class="head_td head_td_first">GL</th>
                        <th class="head_td head_td_first">Sub Ledger</th>
                        <th class="head_td head_td_first">Cost Center</th>
                        <th class="head_td text-right">Amount.</th>
                    </tr>
                </thead>
                <tbody>
                    @php
                        $total_debit = 0;
                        $total_credit = 0;
                        $journal_date = '';
                    @endphp

                    @foreach($voucher_details as $voucher)
                        @if($voucher->trn_dr_account_amount > 0)
                            <tr>
                                <td class="head_td_rec head_td_first">
                                    <strong>{{$voucher->trn_account_code}}-{{ucwords(strtolower($voucher->account_name))}}</strong>
                                    <p style="font-style: italic; font-size:10px;">{{$narration}}@if(! empty($voucher->bank_cheq_number))<br>{{$voucher->bank_cheq_number}} Cheque Date: {{date("Y-m-d",strtotime($voucher->bank_cheq_date))}} @endif</p>
                                </td>
                                <td></td>
                                <td></td>
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

                    @foreach($voucher_details as $voucher)
                        @if($voucher->trn_cr_account_amount > 0)
                            <tr>
                                <td class="head_td_rec head_td_first">
                                    <strong>{{$voucher->trn_account_code}}-{{ucwords(strtolower($voucher->account_name))}}</strong>
                                    <p style="font-style: italic; font-size:11px;">{{$narration}}@if(! empty($voucher->bank_cheq_number))<br>{{$voucher->bank_cheq_number}} Cheque Date: {{date("Y-m-d",strtotime($voucher->bank_cheq_date))}} @endif</p>
                                </td>
                                <td></td>
                                <td></td>
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
                    <td colspan="4" style="padding-top: 5px; padding-bottom:5px; padding-left: 20px;">
                        @php
                            $numtoword = new NumberToWords\NumberToWords();
                            $numtowordtrans = $numtoword->getNumberTransformer('en');
                            $text_total = $numtowordtrans->toWords($total_debit);
                        @endphp
                        <strong>In Word: {{Str::ucfirst($text_total)}} @if(! empty($total_debit)) taka @endif only</strong>
                    </td>
                </tr>
                <tr>
                    <td style="padding: 10px 0px 10px 10px;" colspan="2">Cheque No: <span style="width: 100%; border-bottom: 1px solid #333;">{{$voucher->bank_cheq_number}}</span></td>
                    <td style="padding: 10px 0px 10px 10px; text-align: right;" colspan="2">Cheque Date: <span style="width: 100%; border-bottom: 1px solid #333;">@if(! empty($voucher->bank_cheq_number)){{date("Y-m-d",strtotime($voucher->bank_cheq_date))}} @endif</span></td>
                   
                </tr>
            </table>
        </div>
    </div>

</div>