<style type="text/css">
    body {
        font-family: IBM Plex Sans, Helvetica, Arial, sans-serif;
        font-size:11px;
    }
    h2,h3,h4 {
        margin:0;
    }
    .mt {
        margin-top:40px;
    }
    .mb {
        margin-bottom:40px;
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
        padding: 7px;
    }

    .head_td_rec {
        margin: 0;
        padding: 5px;
    }
    .text-right{
        text-align: right;
    }

    .text-left{
        text-align: left;
    }

    .text-center{
        text-align: center;
    }

    .head_td_total_double_line {
        margin: 0;
        padding: 7px;
        border-bottom: 5px double #333;
        border-top: 5px double #333;
    }
    .container {
        margin: 40px 50px 50px 40px;
    }

    .voucher_title{
        margin: 10px 0 0 0;
    }

    .td-border{
        border: 1px solid #333;
        padding: 5px;
    }

    table {
        border-bottom: 1px solid #333;
    }
    .head_td_total_double_line {
        margin: 0;
        padding: 7px;
        border-bottom: 5px double #333;
        border-top: 5px double #333;
    }

    table tr td:nth-last-child(){
        border: 0.1px solid black;
        page-break-inside: avoid !important;
    }

    table td {
        font-size:11px;
    }
    
</style>
<!-- font awesome -->
<link href="{{ asset('css/all.min.css') }}" rel='stylesheet' />

<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="text_align_center">
            <h2>{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h2>
            <h4>{{ isset($org_info->addrress1) ? $org_info->addrress1 : ""}}</h4>
            <h4>{{isset($org_info->telephone1) ? $org_info->telephone1 : "" }}</h4>
            <div class="voucher_title" style="margin-top: 30px;">
                <h3 style="margin-bottom: 30px; text-transform:uppercase;">
                    Day Book
                </h3>
                <h3 class="mb" style="text-transform: uppercase">From Date: {{date("d/m/Y", strtotime($from_date))}}, To Date: {{date("d/m/Y", strtotime($to_date))}}</h3>
            </div>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table style="width: 100%;" cellspacing="0">
                <thead>
                    <tr class="bg-primary">
                        <th class="text-center w-5 td-border">SL</th>
                        <th class="text-left w-10 td-border">Date</th>
                        <th class="text-left w-10 td-border">Voucher No</th>
                        <th class="text-left td-border">Particulars</th>
                        <th class="text-left td-border">Journal Type</th>
                        <th class="text-right w-10 td-border">Dr.(Tk)</th>
                        <th class="text-right w-10 td-border">Cr.(Tk)</th>
                        <th class="text-center w-10 td-border">Actions</th>
                    </tr>
                </thead>
                <body>
                    @php
                        $a = 0;
                        $v = 0;
                        $t = 0;
                        $j = 0;
                        $c = 0;
                        $total_dr = 0;
                        $total_cr = 0;

                    @endphp
                    @foreach($voucher_details as $key => $voucher)
                    @php
                        $total_dr += $voucher->trn_dr_account_amount;
                        $total_cr += $voucher->trn_cr_account_amount;
                        if ($v == 0) {
                            $cache_voucher_code = $voucher->journal_code;
                            // $cache_journal_no_pk = $voucher->journal_no_pk;
                            $date = date("d-m-Y",strtotime($voucher->journal_date));
                            $v = 1;
                        }

                        if ($cache_voucher_code != $voucher->journal_code) {
                            $v = 0;
                            $j = 0;
                        }


                    @endphp

                    <tr>


                        <td style="border-top: 1px solid #333; border-left: 1px solid #333;border-right: 1px solid #333; text-align:center;  ">{{$key+1}}</td>
                        @if($date != date("d-m-Y", strtotime($voucher->journal_date)))
                            <td class="text-center head_td_rec" style="border-top: 1px solid #333;border-right: 1px solid #333;">{{date("d-m-Y",strtotime($voucher->journal_date))}}</td>
                        @else
                            <td class="text-center head_td_rec" style="border-right: 1px solid #333;border-top: 1px solid #333;">
                                @if($t == 0)
                                {{date("d-m-Y",strtotime($voucher->journal_date))}}
                                @php
                                    $t = 1;
                                @endphp
                                @endif
                            </td>
                        @endif

                        @if($cache_voucher_code != $voucher->journal_code)
                            <td class="text-left head_td_rec" style="border-top: 1px solid #333; text-decoration:none;"><a  style=" text-decoration:none;" target="_blank" href="{{route('journal',['journal_id'=>$voucher->journal_code])}}">{{$voucher->journal_code}}</a></td>
                        @else

                            <td class="text-left head_td_rec" style="border-top: 1px solid #333;">

                                @if($c == 0)
                                <a target="_blank" href="{{route('journal_show',['journal_id'=>$voucher->journal_code])}}" style=" text-decoration:none;">{{$voucher->journal_code}}</a>
                                @php
                                    $c = 1;
                                @endphp
                                @endif
                            </td>
                        @endif
                        <td class="text-left head_td_rec td-border" style="border-bottom: 1px solid #333;">{{ucwords(strtolower($voucher->account_name))}}</td>
                        <td class="text-left head_td_rec td-border">@if($voucher->is_contra == 1) Contra @else {{ucwords(strtolower($voucher->voucher_type_name))}} @endif</td>
                        <td class="text-right head_td_rec td-border">{{$voucher->trn_dr_account_amount > 0 ? number_format($voucher->trn_dr_account_amount,2) : null}}</td>
                        <td class="text-right head_td_rec td-border">{{$voucher->trn_cr_account_amount > 0 ? number_format($voucher->trn_cr_account_amount,2) : null}}</td>
                        <td class="text-center head_td_rec td-border">                
                        @if($cache_voucher_code != $voucher->journal_code)
                            <a target="_blank" href="{{route('view_journal',['journal_id'=>$voucher->journal_code])}}" style=" text-decoration:none;"><i class="fa fa-eye"></i></a>
                            {{-- <a target="_blank" href="{{route('journal',['journal_id'=>$voucher->journal_code])}}" style=" text-decoration:none;"><i class="fa fa-eye"></i></a> --}}
                        @else                     
                                @if($a == 0)
                                <a target="_blank" href="{{route('view_journal',['journal_id'=>$voucher->journal_code])}}" style=" text-decoration:none;"><i class="fa fa-eye"></i></a>
                                @php $a = 1;@endphp
                                @endif
                        @endif
                        </td>
                    </tr>
                    @endforeach

                    <tr>
                        <td colspan="5" class="td-border"><strong>Total: </strong> </td>
                        <td class="td-border text-right head_td_total_double_line"><strong>{{number_format($total_dr,2)}}</strong></td>
                        <td class="td-border text-right head_td_total_double_line"><strong>{{number_format($total_cr,2)}}</strong></td>
                        <td class="td-border"></td>
                    </tr>

                </body>
            </table>
        </div>
    </div>

</div>
