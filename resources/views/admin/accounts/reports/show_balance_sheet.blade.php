<style type="text/css">
    body {
        font-family: IBM Plex Sans, Helvetica, Arial, sans-serif;
        font-size: 11px;
    }

    table td {
        font-size: 11px;
    }

</style>
<div class="row">
    <div class="col-md-12">
        <div style="text-align: center;">
        <h2>{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h2>
        <h4>{{ isset($org_info->addrress1) ? $org_info->addrress1 : ""}}</h4>
        <h4>{{isset($org_info->telephone1) ? $org_info->telephone1 : "" }}</h4>

        </div>
        <div class="voucher_title" style="margin-top: 10px; text-align:center;">
            <h3 style="margin-bottom: 30px; text-transform:uppercase;">
                Balance Sheet
            </h3>
            <h3 class="mb" style="text-transform: uppercase">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h3>
        </div>
    </div>

</div>
@php

    $sum_prl_outflow = 0;
    $sum_prl_inflow = 0;
    $total_sum_dr = 0;
    $total_sum_cr = 0;
    $net_profit_loss = 0;

    $net_profit = 0;
    $net_loss = 0;

@endphp

        @if(empty($profit_loss))

        @else

                        @php
                            $root_prl_exist = "";
                            $prl_t = 0;
                            $prl_c = 0;


                        @endphp
                        @foreach(collect($profit_loss->getData()->data)->whereIn('root_head3',['expense','Cost of Goods Sold']) as $root)

                                @foreach(collect($profit_loss->getData()->data)->where('root_head4',$root->root_head4) as $root)
                                    @php
                                        $inroot_prl_sum = collect($profit_loss->getData()->data)->where('root_head4',$root->root_head4)->sum("dr");
                                        $total_dr = collect($profit_loss->getData()->data)->where('root_head4',$root->root_head4)->sum("dr");
                                        $total_cr = collect($profit_loss->getData()->data)->where('root_head4',$root->root_head4)->sum("cr");

                                    @endphp
                                    @if($prl_t == 0)
                                        @php
                                            $root_prl_arr = [];
                                            $root_prl_exist = $root->root_head4;
                                            $prl_t = 1;
                                        @endphp
                                    @endif
                                    @if($prl_c == 0)

                                        @php
                                            $prl_c = 1;
                                            $sum_prl_inflow += $inroot_prl_sum;
                                            array_push($root_prl_arr,$root->root_head4);
                                        @endphp

                                        @foreach(collect($profit_loss->getData()->data)->where('root_head4',$root_prl_exist) as $root)

                                        @php
                                            $total_sum_dr += $root->dr;
                                            $total_sum_cr += $root->cr;
                                        @endphp
                                        @endforeach
                                    @endif
                                    @if(! in_array($root->root_head4,$root_prl_arr))
                                        @php
                                            array_push($root_prl_arr, $root->root_head4);
                                            $new_prl_root = $root->root_head4;
                                        @endphp


                                        @foreach(collect($profit_loss->getData()->data)->where('root_head4',$new_prl_root) as $root)

                                            @php
                                                $total_sum_dr += $root->dr;
                                                $total_sum_cr += $root->cr;
                                            @endphp
                                        @endforeach

                                    @endif
                            @endforeach

                        @endforeach


                        @php
                            $root_prl_exist = "";
                            $prl_t = 0;
                            $prl_c = 0;


                        @endphp
                        @foreach(collect($profit_loss->getData()->data)->where('root_head3','income') as $root)

                                @foreach(collect($profit_loss->getData()->data)->where('root_head3',$root->root_head3) as $root)
                                    @php
                                        $inroot_prl_sum = collect($profit_loss->getData()->data)->where('root_head3',$root->root_head3)->sum("dr");
                                        $total_dr = collect($profit_loss->getData()->data)->where('root_head3',$root->root_head3)->sum("dr");
                                        $total_cr = collect($profit_loss->getData()->data)->where('root_head3',$root->root_head3)->sum("cr");

                                    @endphp
                                    @if($prl_t == 0)
                                        @php
                                            $root_prl_arr = [];
                                            $root_prl_exist = $root->root_head3;
                                            $prl_t = 1;
                                        @endphp
                                    @endif
                                    @if($prl_c == 0)

                                        @php
                                            $prl_c = 1;
                                            $sum_prl_inflow += $inroot_prl_sum;
                                            array_push($root_prl_arr,$root->root_head3);
                                        @endphp

                                        @foreach(collect($profit_loss->getData()->data)->where('root_head3',$root_prl_exist) as $root)

                                        @php
                                            $total_sum_dr += $root->dr;
                                            $total_sum_cr += $root->cr;
                                        @endphp
                                        @endforeach
                                    @endif
                                    @if(! in_array($root->root_head3,$root_prl_arr))
                                        @php
                                            array_push($root_prl_arr, $root->root_head3);
                                            $new_prl_root = $root->root_head3;
                                        @endphp


                                        @foreach(collect($profit_loss->getData()->data)->where('root_head3',$new_prl_root) as $root)

                                            @php
                                                $total_sum_dr += $root->dr;
                                                $total_sum_cr += $root->cr;
                                            @endphp
                                        @endforeach

                                    @endif
                            @endforeach

                        @endforeach
            @php
                $net_profit_loss = ($total_sum_cr-$total_sum_dr);
            @endphp




        @endif


@php

    $sum_outflow = 0;
    $sum_inflow = 0;
    $total_sum_amount = 0;
    $total_sum_amount_asset = 0;
    //$total_sum_cr = 0;
    //dd($balance_sheet_root['liabilities']);
@endphp
<table class="table mb-0" style="width: 100%;">
    <thead>
        <tr class="bg-primary">
            <td colspan="3"></td>
        </tr>
    </thead>
    <tbody>
        @if(empty($root_info))
            <tr>
            <td colspan="2">No Data Found</td>
            </tr>
        @else
            <tr>
                <td colspan="3" style=" padding-right: 10px; vertical-align:top;">
                    <table style="width: 100%;">
                        <tr>
                            <td colspan="2" style="font-weight:bold; font-size: 14px; padding-bottom: 10px; border-bottom:1px solid #333;">Liabilities</td>
                        </tr>
                        @php
                            $root_exist = "";
                            $t = 0;
                            $c = 0;


                        @endphp
                        @php
                            //dd($root_info->getData()->data);
                        @endphp
                        @foreach(collect($root_info->getData()->data) as $root)
                            @if (in_array($root->root_head,$balance_sheet_root['liabilities']))

                                    @php
                                        $inroot_sum = collect($root_info->getData()->data)->where('root_head',$root->root_head)->sum("amount");
                                        $total_amount = collect($root_info->getData()->data)->where('root_head',$root->root_head)->sum("amount");

                                    @endphp
                                    @if($t == 0)
                                        @php
                                            $root_arr = [];
                                            $root_exist = $root->root_head;
                                            $t = 1;
                                        @endphp
                                    @endif
                                    @if($c == 0)
                                        @php
                                            $root_sum_liability = abs($total_amount);
                                        @endphp
                                        <tr>
                                            <td style="font-weight:bold; padding-bottom: 5px; font-size:12px;">{{ucwords(strtolower($root->root_head))}}</td>
                                            <td style="font-weight:bold; text-align:right; border-bottom:5px double #333; padding-bottom: 5px; font-style:italic; font-size: 12px;">{{number_format($root_sum_liability,2)}}</td>
                                        </tr>
                                        @php
                                            $c = 1;
                                            $sum_inflow += $inroot_sum;
                                            array_push($root_arr,$root->root_head);
                                        @endphp

                                        @foreach(collect($root_info->getData()->data)->where('root_head',$root_exist) as $root)
                                        <tr>
                                            <td style="padding-left: 30px; padding-bottom: 5px;">{{ucwords(strtolower($root->tran_head))}}</td>
                                            <td style="text-align: right; padding-bottom: 5px; font-style:italic;">{{number_format(abs($root->amount),2)}}</td>
                                        </tr>
                                        @php
                                            $total_sum_amount += $root->amount;
                                        @endphp
                                        @endforeach
                                    @endif
                                    @if(! in_array($root->root_head,$root_arr))
                                        @php
                                            array_push($root_arr, $root->root_head);
                                            $new_root = $root->root_head;
                                        @endphp
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px; padding-bottom: 5px;">{{ucwords(strtolower($root->root_head))}}</td>
                                            <td style="font-weight:bold; font-size:12px; text-align:right; border-bottom:5px double #333; padding-bottom: 5px; font-style:italic;">{{number_format(abs($total_amount),2)}}</td>
                                        </tr>

                                        @foreach(collect($root_info->getData()->data)->where('root_head',$new_root) as $root)
                                            <tr>
                                                <td style="padding-left: 30px; padding-bottom: 5px;">{{ucwords(strtolower($root->tran_head))}}</td>
                                                <td style="text-align: right; padding-bottom: 5px; font-style:italic;">{{number_format(abs($root->amount),2)}}</td>
                                            </tr>
                                            @php
                                                $total_sum_amount += $root->amount;
                                            @endphp
                                        @endforeach

                                    @endif
                            @endif




                        @endforeach
                        @if ($net_profit_loss > 0)

                            <tr>
                                <td style="padding-bottom: 5px; font-weight:bold;">Retained Earnings </td>
                                @php
                                    $net_profit = $net_profit_loss;
                                @endphp
                                <td style="text-align: right; padding-bottom: 5px; font-style:italic; font-weight:bold;">{{number_format(abs($net_profit_loss),2)}}</td>
                            </tr>

                            @endif


                            @if ($net_profit_loss < 0)
                            <tr>
                                <td style="padding-bottom: 5px; font-weight:bold;">Retained Earnings </td>
                                @php
                                    $net_profit = $net_profit_loss;
                                @endphp
                                <td style="text-align: right; padding-bottom: 5px; font-style:italic; font-weight:bold;">{{"(".number_format(abs($net_profit_loss),2).")"}}</td>
                            </tr>
                            @endif

                    </table>
                </td>
                <td colspan="3" style=" padding-right: 10px; vertical-align:top;">
                    <table style="width: 100%;">
                        <tr>
                            <td colspan="2" style="font-weight:bold; font-size: 14px; padding-bottom: 5px; border-bottom:1px solid #333;">Assets</td>
                        </tr>
                        @php
                            $root_exist = "";
                            $t = 0;
                            $c = 0;


                        @endphp

                        @foreach(collect($root_info->getData()->data) as $root)
                            @if (in_array($root->root_head,$balance_sheet_root['assets']))

                                    @php
                                        $inroot_sum = collect($root_info->getData()->data)->where('root_head',$root->root_head)->sum("amount");
                                        $total_amount = collect($root_info->getData()->data)->where('root_head',$root->root_head)->sum("amount");

                                    @endphp
                                    @if($t == 0)
                                        @php
                                            $root_arr = [];
                                            $root_exist = $root->root_head;
                                            $t = 1;
                                        @endphp
                                    @endif
                                    @if($c == 0)
                                        @php
                                            $root_sum_asset = abs($total_amount);
                                        @endphp
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px; padding-bottom: 5px;">{{ucwords(strtolower($root->root_head))}}</td>
                                            <td style="font-weight:bold; font-size:12px; text-align:right; border-bottom:5px double #333; padding-bottom: 5px; font-style:italic;">{{number_format($root_sum_asset,2)}}</td>
                                        </tr>
                                        @php
                                            $c = 1;
                                            $sum_inflow += $inroot_sum;
                                            array_push($root_arr,$root->root_head);
                                        @endphp

                                        @foreach(collect($root_info->getData()->data)->where('root_head',$root_exist) as $root)
                                        <tr>
                                            <td style="padding-left: 30px; padding-bottom: 5px;">{{ucwords(strtolower($root->tran_head))}}</td>
                                            <td style="text-align: right; padding-bottom: 5px; font-style:italic;">{{number_format($root->amount,2)}}</td>
                                        </tr>
                                        @php
                                            $total_sum_amount_asset += $root->amount;
                                        @endphp
                                        @endforeach
                                    @endif
                                    @if(! in_array($root->root_head,$root_arr))
                                        @php
                                            array_push($root_arr, $root->root_head);
                                            $new_root = $root->root_head;
                                        @endphp
                                        {{dd($root->root_head)}}
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px; padding-bottom: 5px;">{{ucwords(strtolower($root->root_head))}}</td>
                                            <td style="font-weight:bold; font-size:12px; text-align:right; border-bottom:5px double #333; padding-bottom: 5px; font-style:italic;">{{number_format($total_amount,2)}}</td>
                                        </tr>

                                        @foreach(collect($root_info->getData()->data)->where('root_head',$new_root) as $root)
                                            <tr>
                                                <td style="padding-left: 30px; padding-bottom: 5px;">{{ucwords(strtolower($root->tran_head))}}</td>
                                                <td style="text-align: right; padding-bottom: 5px; font-style:italic;">{{number_format($root->amount,2)}}</td>
                                            </tr>
                                            @php
                                                $total_sum_amount_asset += $root->amount;
                                            @endphp
                                        @endforeach

                                    @endif
                            @endif
                        @endforeach


                    </table>
                </td>
            </tr>
            @php
                $total_sum_with_profit_loss = $net_profit+abs($total_sum_amount)
            @endphp
            <tr>
                <td colspan="3">
                    <table style="width: 100%;" cellspacing=0>
                        <tr>
                            <td style="border: 1px solid #333;padding: 5px;"><span style="font-weight: bold;">Grand Total</span></td>
                            <td style="border: 1px solid #333; padding:5px;"><span style="font-weight: bold;"></span> <span style="float:right; font-weight: bold; font-style:italic;">{{number_format($total_sum_with_profit_loss,2)}}</span></td>
                        </tr>
                    </table>
                </td>
                <td colspan="3">
                    <table style="width: 100%;" cellspacing=0>
                        <tr>
                            <td style="border: 1px solid #333;padding: 5px;"><span style="font-weight: bold;">Grand Total</span></td>
                            <td style="border: 1px solid #333; padding:5px;"><span style="font-weight: bold;"></span> <span style="float:right; font-weight: bold; font-style:italic;">{{number_format(abs($total_sum_amount_asset),2)}}</span></td>
                        </tr>
                    </table>
                </td>
            </tr>
        @endif



    </tbody>
</table>
