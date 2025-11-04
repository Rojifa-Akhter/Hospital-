<style type="text/css">
    body {
        font-family: IBM Plex Sans, Helvetica, Arial, sans-serif;
        font-size:11px;
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
        <div class="voucher_title" style="margin-top: 30px; text-align:center;">
            <h3 style="margin-bottom: 30px; text-transform:uppercase;">
                Profit & Loss Statement
            </h3>
            <h3 class="mb" style="text-transform: uppercase">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h3>
        </div>
    </div>
    
</div>

@php
    
    $sum_outflow = 0;
    $sum_inflow = 0;
    $total_sum_exp_dr = 0;
    $total_sum_exp_cr = 0;
    $total_sum_inc_dr = 0;
    $total_sum_inc_cr = 0;
    $grand_total_dr = 0;
    $grand_total_cr = 0;

    //dd(collect($root_info->getData()->data)->whereIn('root_head',['EXPENSE','INCOME']));
@endphp
<table class="table" style="width: 100%;">
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
                            <td colspan="2" style="font-weight:bold; font-size: 14px; padding-bottom: 10px; border-bottom:1px solid #333;">Particulars</td>
                            
                        </tr>
                        @php
                            $root_exist = "";
                            $t = 0;
                            $c = 0;
                            
                            
                        @endphp
                        @foreach(collect($root_info->getData()->data)->whereIn('root_head3',['expense','Cost of Goods Sold']) as $root)
                                
                                @foreach(collect($root_info->getData()->data)->where('root_head4',$root->root_head4) as $root)
                                    @php
                                        $inroot_sum = collect($root_info->getData()->data)->where('root_head4',$root->root_head4)->sum("dr");
                                        $total_dr = collect($root_info->getData()->data)->where('root_head4',$root->root_head4)->sum("dr");
                                        $total_cr = collect($root_info->getData()->data)->where('root_head4',$root->root_head4)->sum("cr");
                                        
                                    @endphp
                                    @if($t == 0)
                                        @php
                                            $root_arr = [];
                                            $root_exist = $root->root_head4;
                                            $t = 1;
                                        @endphp
                                    @endif
                                    @if($c == 0)
                                        <tr>
                                            <td style="font-weight:bold; font-size: 12px; padding-bottom: 10px;">{{ucwords(strtolower($root->root_head4))}}</td>
                                            <td style="font-weight:bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic;">{{number_format(($total_dr-$total_cr),2)}}</td>
                                        </tr>
                                        @php
                                            $c = 1;
                                            $sum_inflow += $inroot_sum;
                                            array_push($root_arr,$root->root_head4);
                                        @endphp

                                        @foreach(collect($root_info->getData()->data)->where('root_head4',$root_exist) as $root)
                                        <tr>
                                            <td style="padding-left: 30px; padding-bottom: 10px;">{{ucwords(strtolower($root->tran_head))}}</td>
                                            <td style="text-align: right; padding-bottom: 10px; font-style:italic;">{{number_format(($root->dr-$root->cr),2)}}</td>
                                        </tr>
                                        @php
                                            $total_sum_exp_dr += $root->dr;
                                            $total_sum_exp_cr += $root->cr;
                                        @endphp
                                        @endforeach
                                    @endif
                                    @if(! in_array($root->root_head4,$root_arr))
                                        @php
                                            array_push($root_arr, $root->root_head4);
                                            $new_root = $root->root_head4;
                                        @endphp
                                        <tr>
                                            <td style="font-weight:bold; font-size: 12px; padding-bottom: 10px;">{{ucwords(strtolower($root->root_head4))}}</td>
                                            <td style="font-weight:bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic;">{{number_format(($total_dr-$total_cr),2)}}</td>
                                        </tr>

                                        @foreach(collect($root_info->getData()->data)->where('root_head4',$new_root) as $root)
                                            <tr>
                                                <td style="padding-left: 30px; padding-bottom: 10px;">{{ucwords(strtolower($root->tran_head))}}</td>
                                                <td style="text-align: right; padding-bottom: 10px; font-style:italic;">{{number_format(($root->dr-$root->cr),2)}}</td>
                                            </tr>
                                            @php
                                                $total_sum_exp_dr += $root->dr;
                                                $total_sum_exp_cr += $root->cr;
                                            @endphp
                                        @endforeach

                                    @endif
                            @endforeach

                        @endforeach
                        
                    </table>
                </td>

                <td colspan="3" style=" padding-right: 10px;vertical-align: top;">
                    <table style="width: 100%;">
                        <tr>
                            <td colspan="2" style="font-weight:bold; font-size: 14px; padding-bottom: 10px; border-bottom:1px solid #333;">Particulars</td>
                        </tr>
                        @php
                            $root_exist = "";
                            $t = 0;
                            $c = 0;
                            
                            
                        @endphp
                        @foreach(collect($root_info->getData()->data)->where('root_head3','income') as $root)
                                
                                @foreach(collect($root_info->getData()->data)->where('root_head3',$root->root_head3) as $root)
                                    @php
                                        $inroot_sum = collect($root_info->getData()->data)->where('root_head3',$root->root_head3)->sum("dr");
                                        $total_dr = collect($root_info->getData()->data)->where('root_head3',$root->root_head3)->sum("dr");
                                        $total_cr = collect($root_info->getData()->data)->where('root_head3',$root->root_head3)->sum("cr");
                                        
                                    @endphp
                                    @if($t == 0)
                                        @php
                                            $root_arr = [];
                                            $root_exist = $root->root_head3;
                                            $t = 1;
                                        @endphp
                                    @endif
                                    @if($c == 0)
                                        <tr>
                                            <td style="font-weight:bold; font-size:12px; padding-bottom: 10px;">{{ucwords(strtolower($root->root_head4))}}</td>
                                            <td style="font-weight:bold; font-size:12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic;">{{number_format(($total_cr-$total_dr),2)}}</td>
                                        </tr>
                                        @php
                                            $c = 1;
                                            $sum_inflow += $inroot_sum;
                                            array_push($root_arr,$root->root_head3);
                                        @endphp

                                        @foreach(collect($root_info->getData()->data)->where('root_head3',$root_exist) as $root)
                                        <tr>
                                            <td style="padding-left: 30px; padding-bottom: 10px;">{{ucwords(strtolower($root->tran_head))}}</td>
                                            <td style="text-align: right; padding-bottom: 10px; font-style:italic;">{{number_format(($root->cr-$root->dr),2)}}</td>
                                        </tr>
                                        @php
                                            $total_sum_inc_dr += $root->dr;
                                            $total_sum_inc_cr += $root->cr;
                                        @endphp
                                        @endforeach
                                    @endif
                                    @if(! in_array($root->root_head3,$root_arr))
                                        @php
                                            array_push($root_arr, $root->root_head3);
                                            $new_root = $root->root_head3;
                                        @endphp
                                        <tr>
                                            <td style="font-weight:bold; font-size: 12px; padding-bottom: 10px;">{{ucwords(strtolower($root->root_head4))}}</td>
                                            <td style="font-weight:bold; font-size: 12px; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic;">{{number_format(($total_cr-$total_dr),2)}}</td>
                                        </tr>

                                        @foreach(collect($root_info->getData()->data)->where('root_head3',$new_root) as $root)
                                            <tr>
                                                <td style="padding-left: 30px; padding-bottom: 10px;">{{ucwords(strtolower($root->tran_head))}}</td>
                                                <td style="text-align: right; padding-bottom: 10px; font-style:italic;">{{number_format(($root->cr-$root->dr),2)}}</td>
                                            </tr>
                                            @php
                                                $total_sum_inc_dr += $root->dr;
                                                $total_sum_inc_cr += $root->cr;
                                            @endphp
                                        @endforeach

                                    @endif
                            @endforeach

                        @endforeach
                       
                    </table>
                </td>
               
            </tr>
            @php
                $exp_total = ($total_sum_exp_dr-$total_sum_exp_cr);
                $inc_total = ($total_sum_inc_cr-$total_sum_inc_dr);
                $net_profit_loss = ($inc_total-$exp_total);

                if ($exp_total > $inc_total) {
                    $grand_total_dr = $exp_total;
                    $grand_total_cr = abs($net_profit_loss)+$inc_total;
                }

                if($inc_total > $exp_total) {
                    $grand_total_cr = $inc_total;
                    $grand_total_dr = abs($net_profit_loss)+$exp_total;
                }


            @endphp
            <tr>
                <td colspan="3">
                    <table style="width: 100%;">
                        <tr>
                        @if ($net_profit_loss > 0)
                        <td style="padding-left: 30px; padding-bottom: 10px; font-weight:bold; font-size: 12px;">Net Profit</td>
                        <td style="text-align: right; padding-bottom: 10px; font-style:italic; font-weight:bold; font-size: 12px;">{{number_format(abs($net_profit_loss),2)}}</td>
                        @php
                            //$grand_total_dr += abs($net_profit_loss);
                        @endphp
                        @endif
                        </tr>
                    </table>
                </td>

                <td colspan="3">
                    <table style="width: 100%;">
                        <tr>
                        @if ($net_profit_loss < 0)
                        <td style="padding-left: 30px; padding-bottom: 10px; font-weight:bold; font-size: 12px;">Net Loss</td>
                        <td style="text-align: right; padding-bottom: 10px; font-style:italic; font-weight:bold; font-size: 12px;">{{number_format(abs($net_profit_loss),2)}}</td>
                        @php
                            //$grand_total_cr += abs($net_profit_loss);
                        @endphp
                        @endif
                        </tr>
                    </table>
                </td>
            </tr>

            <tr>
                <td colspan="3">
                    <table style="width: 100%;">
                        <tr>
                            <td><span style="font-weight: bold;">Grand Total: </span></td>
                            <td style="border: 1px solid #333; padding:5px; text-align:right"><span style="font-weight: bold;"></span> <span style="font-weight: bold; font-style:italic;">{{number_format($grand_total_dr,2)}}</span></td>
                        </tr>
                    </table>
                </td>

                <td colspan="3">
                    <table style="width: 100%;">
                        <tr>
                            <td colspan="2" style="border: 1px solid #333; padding:5px; text-align:right;"><span style="font-weight: bold;"></span> <span style="font-weight: bold; font-style:italic;">{{number_format($grand_total_cr,2)}}</span></td>
                        </tr>
                    </table>
                </td>
            </tr>


            
            
        @endif
            
        
       
    </tbody>
</table>