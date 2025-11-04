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
                Cashflow Statement
            </h3>
            <h3 class="mb" style="text-transform: uppercase">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h3>
        </div>
    </div>
    
</div>

@php
    
    $sum_outflow = 0;
    $sum_inflow = 0;
@endphp
<table class="table mb-0" style="width: 100%;">
    <thead>
        <tr class="bg-primary">
            <td style="font-weight: 900;border-bottom: 1px solid #333;">INFLOW</td>
            <td style="font-weight: 900;border-bottom: 1px solid #333;">OUTFLOW</td>
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
                            
                        @endphp
                        @foreach(collect($root_info->getData()->data)->where('type','inflow') as $root)
                       
                                
                                    @php
                                        $inroot_sum = collect($root_info->getData()->data)->where('type','inflow')->where('root_head',$root->root_head)->sum("dr");
                                        
                                    @endphp
                                    @if($t == 0)
                                        @php
                                            $root_exist = $root->root_head;
                                            $t = 1;
                                        @endphp
                                    @endif
                                    @if($c == 0)
                                        <tr>
                                            <td style="font-weight: 900; padding-bottom: 10px;">{{ucwords(strtolower($root->root_head))}}</td>
                                            <td style="font-weight: 900; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic;">{{number_format($inroot_sum,2)}}</td>
                                        </tr>
                                        @php
                                            $c = 1;
                                            $sum_inflow += $inroot_sum;
                                        @endphp
                                        @foreach(collect($root_info->getData()->data)->where('type','inflow')->where('root_head',$root->root_head) as $root)
                                            <tr>
                                                <td style="padding-left: 30px; padding-bottom: 10px;">{{ucwords(strtolower($root->tran_head))}}</td>
                                                <td style="text-align: right; padding-bottom: 10px; font-style:italic;">{{number_format($root->dr,2)}}</td>
                                            </tr>
                                        @endforeach
                                        
                                    @endif

                                    @if(!empty($root)&& $root_exist != $root->root_head)
                       
                                        <tr>
                                            <td style="font-weight: 900; padding-bottom: 10px;">{{$root->root_head}}</td>
                                            <td style="font-weight: 900; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic;">{{number_format($inroot_sum,2)}}</td>
                                        </tr>
                                        @php
                                            $t = 0;
                                            $sum_inflow += $inroot_sum;
                                        @endphp
                                        @foreach(collect($root_info->getData()->data)->where('type','inflow')->where('root_head',$root->root_head) as $root)
                                    
                                            <tr>
                                                <td style="padding-left: 30px; padding-bottom: 10px;">{{ucwords(strtolower($root->tran_head))}}</td>
                                                <td style="text-align: right; padding-bottom: 10px; font-style:italic;">{{number_format($root->dr,2)}}</td>
                                            </tr>
                                        @endforeach
                                    @endif
                                    
                        @endforeach
                       
                        
                        
                    </table>
                </td>
                <td style="vertical-align: top;">
                    <table style="width: 100%;">
                        @php
                            $root_exist = "";
                            $t = 0;
                            $c = 0;
                            
                        @endphp
                        @foreach(collect($root_info->getData()->data)->where('type','outflow') as $root)
                                
                                    @php
                                        $inroot_sum = collect($root_info->getData()->data)->where('type','outflow')->where('root_head',$root->root_head)->sum("cr");
                                        
                                    @endphp
                                    @if($t == 0)
                                        @php
                                            $root_exist = $root->root_head;
                                            $t = 1;
                                        @endphp
                                    @endif
                                    @if($c == 0)
                                        <tr>
                                            <td style="font-weight: 900; padding-bottom: 10px;">{{ucwords(strtolower($root->root_head))}}</td>
                                            <td style="font-weight: 900; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic;">{{number_format($inroot_sum,2)}}</td>
                                        </tr>
                                        @php
                                            $c = 1;
                                            $sum_outflow += $inroot_sum;
                                        @endphp
                                        @foreach(collect($root_info->getData()->data)->where('type','outflow')->where('root_head',$root->root_head) as $root)
                                            <tr>
                                                <td style="padding-left: 30px; padding-bottom: 10px;">{{ucwords(strtolower($root->tran_head))}}</td>
                                                <td style="text-align: right; padding-bottom: 10px; font-style:italic;">{{number_format($root->cr,2)}}</td>
                                            </tr>
                                        @endforeach
                                    @endif


                        @if( !empty($root) && $root_exist != $root->root_head)
                            <tr>
                                <td style="font-weight: 900; padding-bottom: 10px;">{{$root->root_head}}</td>
                                <td style="font-weight: 900; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic;">{{number_format($inroot_sum,2)}}</td>
                            </tr>
                            @php
                                $t = 0;
                                $sum_outflow += $inroot_sum;
                            @endphp
                            @foreach(collect($root_info->getData()->data)->where('type','outflow')->where('root_head',$root->root_head) as $root)
                                <tr>
                                    <td style="padding-left: 30px; padding-bottom: 10px;">{{ucwords(strtolower($root->tran_head))}}</td>
                                    <td style="text-align: right; padding-bottom: 10px; font-style:italic;">{{number_format($root->cr,2)}}</td>
                                </tr>
                            @endforeach
                        @endif
                                    
                                    
                        @endforeach

                        {{-- @if( !empty($root) && $root_exist != $root->root_head)
                            <tr>
                                <td style="padding-left: 30px; padding-bottom: 10px;">{{$root->root_head}}</td>
                                <td style="font-weight: 900; text-align:right; border-bottom:5px double #333; padding-bottom: 10px; font-style:italic;">{{number_format($inroot_sum,2)}}</td>
                            </tr>
                            @php
                                $t = 0;
                                $sum_outflow += $inroot_sum;
                            @endphp
                            @foreach(collect($root_info->getData()->data)->where('type','outflow')->where('root_head',$root->root_head) as $root)
                                <tr>
                                    <td style="padding-left: 30px; padding-bottom: 10px;">{{ucwords(strtolower($root->tran_head))}}</td>
                                    <td style="text-align: right; padding-bottom: 10px; font-style:italic;">{{number_format($root->cr,2)}}</td>
                                </tr>
                            @endforeach
                        @endif --}}
                        
                    </table>
                </td>
            </tr>
           
        @endif
            
        <tr>
            <td style="border: 1px solid #333;padding: 5px;"><span style="font-weight: bold;">Total</span> <span style="float:right; font-weight: bold; font-style:italic;">{{number_format($sum_inflow,2)}}</span></td>
            <td style="border: 1px solid #333; padding:5px;"><span style="font-weight: bold;">Total</span> <span style="float:right; font-weight: bold; font-style:italic;">{{number_format($sum_outflow,2)}}</span></td>
        </tr>
        @php
            $cash_status = ($sum_inflow - $sum_outflow);
        @endphp
        <tr>

            <td colspan="2" style="border: 1px solid #333;padding: 5px;text-align:center; "><span style="font-weight: bold;"></span> <span style="font-weight: bold; font-style:italic;">@if($cash_status>0) <span style="font-weight: bold;">Net Inflow</span> @else <span style="font-weight: bold;">Net Outflow</span> @endif {{number_format($cash_status,2)}}</span></td>
            
        </tr>
    </tbody>
</table>