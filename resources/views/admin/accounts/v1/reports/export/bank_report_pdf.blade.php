

<style>
    table {
        width: 100%; 
        }
    th{
        font-size: 14px;
        border: 1px solid #333;
        padding: 3px 2px;
    }
    table{
        border-collapse: collapse
    }
    table td {
        font-size: 13px;
        border: 1px solid #333;
        padding:2px;
    }
    .mb{
        margin-bottom:0px
    }
    thead{
        vertical-align: middle;
    }
    .text-center{
        text-align: center
    }
    .text-left{
        text-align: left;
    }
    .text-right{
        text-align: right;
    }
    .text-justify{
        text-align: justify
    }
    .bank_text{
        line-height: 13px;
        padding: 2px 0px;
        margin:0px;
    }

</style>

    <div>Date: {{date('d F, Y')}}</div>
    <br>
    <div class="bank_text">The Manager <br>{{@$ledger_details[0]->account_name}} <br> {!!@$ledger_details[0]->bank_address!!}</div>
    <br>
    <br>
    <div><b><u>Subject: Positive Pay Instruction to Bank Cheque.</u> </b></div>
    <br>
    <div>
        <h5 style="margin:0px 0px; padding:0px 0px">Dear Sir,</h5>
        <p class="text-justify" style="padding: 7px 0px; margin:0px 0px; line-height:14px;">This is to inform you that we "<b>{{$hospital_name}}</b>" have been maintaining an account bearing no. {{ @$ledger_details[0]->bank_ac_no}} with your esteemed branch. We have issued below mentioned cheque(s) with the following details.</p>
    </div>


    <table style="width: 100%;">
        <thead>
            <tr>
                <th style="width:8%" class="text-center">SL No.</th>
                <th style="width:13%" class="text-center">Cheque Date</th>
                <th style="width:15%" class="text-left">Cheque No</th>
                <th style="width:30%;text-align:left">Name</th>
                <th style="width:15%;text-align:right">Amount</th>
                <th style="width:19%;text-align:left">Remarks</th>
            </tr>
        </thead>
       <tbody>
            @forelse($ledger_details as $key => $item)
            <tr>

                <td class="text-center">{{++$key}}</td>
                <td class="text-center">@if(!empty($item->bank_cheq_date)) {{date('d/m/Y',strtotime($item->bank_cheq_date))}} @endif</td>
                <td class="text-left"> {{$item->bank_cheq_number}}</td>
                <td>{{$item->subledger_name}}</td>
                <td style="text-align:right;">@if($item->dr >= 0) {{number_format($item->dr,2)}} @else {{'('.number_format(abs($item->dr),2).')'}} @endif</td>
                <td>{{$item->voucher_remarks}}</td>
            </tr>
            @empty
                <tr>
                    <td colspan="6" class="text-center text-danger">Data not found!</td>
                </tr>
            @endforelse
       </tbody>
    </table>

    <div>
        <p class="text-justify"><b>We hereby request you to consider this as our positive pay confirmation above Mentioned cheque(s)</b></p>
    </div>

    <br>
    <br>
    <div>
        <b>Yours faithfully</b>
    </div>

