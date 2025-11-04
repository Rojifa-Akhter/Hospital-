<style type="text/css">
    body {
        font-family: IBM Plex Sans, Helvetica, Arial, sans-serif;
        font-size: 11px;
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
        text-align: left;
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
                Receipt & Payment Statement    
            </h3>
            <h3 class="mb" style="text-transform: uppercase">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h3>
        </div>
    </div>
    
</div>

@php
    
    $sum_outflow = 0;
    $cash_sum_outflow = 0;
    $bank_sum_outflow = 0;
    $sum_inflow = 0;
    $cash_sum_inflow = 0;
    $bank_sum_inflow = 0;
    $total_sum_inflow = 0;
    $balance_cd =  0;
    
@endphp
<table class="table mb-0" style="width: 100%;">
    <thead>
        <tr class="bg-primary">
            <td style="border-bottom: 1px solid #333; font-weight:900; text-transform: uppercase;">Receipt</td>
            <td style="border-bottom: 1px solid #333; font-weight:900; text-transform: uppercase;">Payment</td>
        </tr>
    </thead>
    <tbody>
        @if(empty($root_info))
            <tr>
            <td colspan="2">No Data Found</td>
            </tr>
        @else
            <tr>
                <td style="border-right: 1px solid #333; padding-right: 10px; vertical-align:top;">
                    <table style="width: 100%;">
                        @php
                            $root_exist = "";
                            $t = 0;
                            $c = 0;
                            $head_arr = [];
                            //dd($root_info->getData()->data[0]->opbal[0]->balance);
                        @endphp
                        <tr>
                            <td style="font-weight: 900;"></td>
                            <td style="font-weight: 900; text-align:right; font-style:italic; border-bottom: 5px double #333;">{{number_format(($root_info->getData()->data[0]->opbal[0]->balance+$root_info->getData()->data[0]->bnkopbal[0]->balance),2)}}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 900;">To Balance b/d<div  style="padding-left: 30px;">Cash In Hand</div></td>
                            <td style="font-weight: 900; text-align:right; font-style:italic;">{{number_format($root_info->getData()->data[0]->opbal[0]->balance,2)}}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 900;"><div  style="padding-left: 30px;">Cash at Bank</div></td>
                            <td style="font-weight: 900; text-align:right; font-style:italic;">{{number_format($root_info->getData()->data[0]->bnkopbal[0]->balance,2)}}</td>
                        </tr>
                        @foreach(collect($root_info->getData()->data)->unique('root_head')->where('type','inflow') as $root)
                                
                               
                                    @php
                                        $inroot_sum = collect($root_info->getData()->data)->where('type','inflow')->where('root_head',$root->root_head)->sum("dr");
                                        $cash_sum = collect($root_info->getData()->data)->where('type','inflow')->where('root_head',$root->root_head)->where('cashtype','cash')->sum("dr");
                                        $bank_sum = collect($root_info->getData()->data)->where('type','inflow')->where('root_head',$root->root_head)->where('cashtype','bank')->sum("dr");
                                        
                                    @endphp
                                    
                                    <tr>
                                        <td style="font-weight: 900; padding-bottom: 10px;">{{$root->root_head}}</td>
                                        <td style="font-weight: 900; text-align:right; border-bottom:5px double #333; border-top: 5px double #333; padding-bottom: 10px; font-style:italic;">{{number_format($inroot_sum,2)}}</td>
                                    </tr>
                                    @php
                                        $c = 1;
                                        $sum_inflow += $inroot_sum;
                                        $cash_sum_inflow += $cash_sum;
                                        $bank_sum_inflow += $bank_sum;

                                    @endphp
                                    @foreach(collect($root_info->getData()->data)->where('type','inflow')->where('root_head',$root->root_head) as $root)
                                        <tr>
                                            <td style="padding-left: 30px; padding-bottom: 10px;">{{ucwords(strtolower($root->tran_head))}}</td>
                                            <td style="text-align: right; padding-bottom: 10px; font-style:italic;">{{number_format($root->dr,2)}}</td>
                                        </tr>
                                    @endforeach
                                        
                                   
                        @endforeach
                        
                    </table>
                </td>
                @php
                    //dd(collect($root_info->getData()->data)->where('type','outflow')->where('cashtype','bank'));
                @endphp
                <td style="vertical-align: top;">
                    <table style="width: 100%;">
                        @php
                            $root_exist_1 = "";
                            $tt = 0;
                            $cc = 0;
                            //dd(collect($root_info->getData()->data)->unique('root_head')->where('type','outflow'));
                            
                        @endphp
                        @foreach(collect($root_info->getData()->data_one)->unique('root_head')->where('type','outflow') as $root)
                                

                                    @php
                                        
                                        $inroot_sum = collect($root_info->getData()->data_one)->where('type','outflow')->where('root_head',$root->root_head)->sum("cr");
                                        $cash_sum = collect($root_info->getData()->data_one)->where('type','outflow')->where('root_head',$root->root_head)->where('cashtype','cash')->sum("cr");
                                        $bank_sum = collect($root_info->getData()->data_one)->where('type','outflow')->where('root_head',$root->root_head)->where('cashtype','bank')->sum("cr");
                                    @endphp
                                    
                                        
                                    <tr>
                                        <td style="font-weight: 900; padding-bottom: 10px;">{{$root->root_head}}</td>
                                        <td style="font-weight: 900; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic;">{{number_format($inroot_sum,2)}}</td>
                                    </tr>
                                    @php
                                        $cc = 1;
                                        $sum_outflow += $inroot_sum;
                                        $cash_sum_outflow += $cash_sum;
                                        $bank_sum_outflow += $bank_sum;
                                    @endphp
                                    @foreach(collect($root_info->getData()->data_one)->where('type','outflow')->where('root_head',$root->root_head) as $root)
                                        <tr>
                                            <td style="padding-left: 30px; padding-bottom: 10px;">{{ucwords(strtolower($root->tran_head))}}</td>
                                            <td style="text-align: right; padding-bottom: 10px; font-style:italic;">{{number_format($root->cr,2)}}</td>
                                        </tr>
                                    @endforeach
                                    
                                    
                        @endforeach
                        @php
                            //dd($head_arr);
                            $total_sum_inflow = $sum_inflow+$root_info->getData()->data[0]->opbal[0]->balance+$root_info->getData()->data[0]->bnkopbal[0]->balance;
                            //$total_sum_outflow = $sum_outflow-$root_info->getData()->data[0]->opbal[0]->balance
                            //dd($bank_sum_inflow,$bank_sum_outflow);
                            $balance_cd = $total_sum_inflow-$sum_outflow;
                            $cash_in_hand_cl = ($cash_sum_inflow+$root_info->getData()->data[0]->opbal[0]->balance)-$cash_sum_outflow;
                            $cash_at_bank_cl = ($bank_sum_inflow+$root_info->getData()->data[0]->bnkopbal[0]->balance)-$bank_sum_outflow;
                        @endphp
                        <tr>
                            <td style="font-weight: 900; padding-bottom: 10px;">By Balance c/d</td>
                            <td style="font-weight: 900;text-align: right; padding-bottom: 10px; font-style:italic;">{{number_format($balance_cd,2)}}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 900;padding-left: 30px; padding-bottom: 10px;">Cash in Hand</td>
                            <td style="font-weight: 900;text-align: right; padding-bottom: 10px; font-style:italic;">{{number_format($cash_in_hand_cl,2)}}</td>
                        </tr>
                        <tr>
                            <td style="font-weight: 900;padding-left: 30px; padding-bottom: 10px;">Cash at Bank</td>
                            <td style="font-weight: 900;text-align: right; padding-bottom: 10px; font-style:italic;">{{number_format($cash_at_bank_cl,2)}}</td>
                        </tr>
                        
                    </table>
                </td>
            </tr>
        @endif
        
            
        <tr>
            <td style="border: 1px solid #333;padding: 5px;font-weight: bold;"><span style="font-weight: bold;">Total</span> <span style="font-weight: bold;float:right; font-weight: bold; font-style:italic;">{{number_format($total_sum_inflow,2)}}</span></td>
            <td style="border: 1px solid #333; padding:5px;font-weight: bold;"><span style="font-weight: bold;">Total</span> <span style="font-weight: bold;float:right; font-weight: bold; font-style:italic;">{{number_format(($balance_cd+$sum_outflow),2)}}</span></td>
        </tr>
        @php
            $cash_status = ($sum_inflow-$sum_outflow);
        @endphp
        {{-- <tr>

            <td colspan="2" style="border: 1px solid #333;padding: 5px;text-align:center; "><span style="font-weight: bold;"></span> <span style="font-weight: bold; font-style:italic;">@if($cash_status>0) <span style="font-weight: bold;">Net Inflow</span> @else <span style="font-weight: bold;">Net Outflow</span> @endif {{number_format($cash_status,2)}}</span></td>
            
        </tr> --}}
    </tbody>
</table>