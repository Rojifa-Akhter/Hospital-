<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Cheque Print</title> <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        * {
            margin: 5px;
            padding: 0;
        }

        /* @page { margin-top: 2cm; margin-right: 3cm; margin-bottom: 2.5cm; margin-left: 3.5cm; } */
    </style>
</head>

<body>
    <main class="">
        <div class="left-side" style="float:left; width:325px;">
            <h4
                style="margin-top:20px; width:22%; @if ($chedetails->chq_account_pay_ind == 1) border-top:2px dotted #0c0c4c; border-bottom:2px dotted #0c0c4c; -ms-transform: rotate(-8deg); /* IE 9 */   transform: rotate(-25deg); color:#0c0c4c; @else border-top:2px dotted #fff; border-bottom:2px dotted #fff; -ms-transform: rotate(-8deg); /* IE 9 */   transform: rotate(-25deg); color:#fff; @endif margin-left:203px;">
                A/c. Payee</h4>
            <p class="content_header"style="font-size: 14px; margin-left:203px; margin-top:42px; @if($chedetails->chq_date == "") color: white @endif">
                {{ date('d/m/Y', strtotime($chedetails->chq_date)) }}</p>
            <p
                class="content_header"style="font-size: 10px; padding-left:161px; margin-top:-3px; line-height:11px; word-spacing: -2px; height:43px; word-wrap:break-word;">
                 <span style="color: white">Ruppi</span>
                 {{-- {{ Illuminate\Support\Str::limit($chedetails->chq_pay_to, 46, '') }} --}}
                 {{ (strlen($chedetails->chq_pay_to) > 46) ? substr($chedetails->chq_pay_to,0,46).'' : $chedetails->chq_pay_to}}
                </p>
            <p
                class="content_header"style="font-size: 10px;margin-left:165px; line-height:11px; word-spacing: -2px; height:43px; word-wrap:break-word;">
                {{-- {{ Illuminate\Support\Str::limit($chedetails->remarks, 58, '') }} --}}
                {{ (strlen($chedetails->remarks) > 58) ? substr($chedetails->remarks,0,58).'' : $chedetails->remarks}}
            </p>
            <p class="content_header"style="font-size: 14px; margin-left:188px; margin-top:7px; line-height:11px;">
                {{-- {{number_format($chedetails->chq_amount,2)}} --}} {{ bangladeshiFormat($chedetails->chq_amount, 2) }}
            </p>
        </div>
        <div class="middle-side" style="float:left;">
            <h4
                style="margin-top:20px; border-top:2px dotted #0c0c4c; border-bottom:2px dotted #0c0c4c; width:19%; @if ($chedetails->chq_account_pay_ind == 1) border-top:2px dotted #0c0c4c; border-bottom:2px dotted #0c0c4c; -ms-transform: rotate(-8deg); /* IE 9 */   transform: rotate(-25deg); color:#0c0c4c; @else border-top:2px dotted #fff; border-bottom:2px dotted #fff; -ms-transform: rotate(-8deg); /* IE 9 */   transform: rotate(-25deg); color:#fff; @endif">
                A/c. Payee</h4>
            <p class="content_header"style="letter-spacing: 14px; font-size: 15px; margin-left:433px; margin-top:-5px; @if($chedetails->chq_date == "") color: white @endif">
                {{ str_replace('-', '', date('d-m-Y', strtotime($chedetails->chq_date))) }}</p>
            <p class="content_header"style="font-size: 12px; padding-top:26px; margin-left:45px; font-weight:bold">
                {{-- {{ Illuminate\Support\Str::limit($chedetails->chq_pay_to, 80, '') }} --}}
                {{ (strlen($chedetails->chq_pay_to) > 80) ? substr($chedetails->chq_pay_to,0,80).'' : $chedetails->chq_pay_to}}

            </p>
            <p class="content_header"style="font-size: 12px; word-spacing: -2px; width:40%; float:left;"> <span
                    style="color: white">Eight Crore Fifg</span> {{ getBangladeshCurrency($chedetails->chq_amount) }}
            </p>
            <p class="content_header"style="font-size: 18px; margin-left:428px; margin-top:14px"><strong>
                    {{ bangladeshiFormat($chedetails->chq_amount, 2) }}</strong></p>
        </div>
    </main>
</body>

</html>
