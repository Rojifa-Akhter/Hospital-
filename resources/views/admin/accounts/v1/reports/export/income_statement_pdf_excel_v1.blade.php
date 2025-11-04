
    <style>
        table td {
            font-size: 15px;
            border: none;
            padding: 0px 3px;
        }
        table>tbody>tr{
            padding: 2px;
            line-height: 18px;
            margin:4px 0px;
        }
        .text-left{
            text-align:left;
        }
        .text-right{
            text-align:right;
        }
        .text-center{
            text-align: center;
        }
        .lh-10{
            line-height: 10px;
        }
        .top-bottom-border{
            border-top:1px solid #000;
            border-bottom:1px solid #000;
        }
        .top-border{
            border-top:1px solid #000;
        }
        .section-gap{
            padding-top:15px;
        }

    </style>

    @php 
        $operating_gain_loss_dr = collect($profit_loss->getData()->data)->where('bal_inc_tag','=','NONOPGL')->sum('dr');
        $operating_gain_loss_cr = collect($profit_loss->getData()->data)->where('bal_inc_tag','=','NONOPGL')->sum('cr');
        $operating_gain_loss = floatVal($operating_gain_loss_dr) - floatVal($operating_gain_loss_cr);
    @endphp
    <h4 style="margin-top: 20px; text-align:center;margin-bottom:10px" >{{isset($org_info->hospital_name ) ? $org_info->hospital_name : ""}}</h4>           
    <div class="voucher_title" style="margin-top: 0px; text-align:center;">
        <h5 style="text-transform:uppercase;margin:0px 0px">
            Income Statement
        </h5>
        @if($search_type == 'daily')
       <h6 class="mb" style="margin:0px 0px"><b>As at {{date("d F Y", strtotime(@$to_date))}}</b></h6>
        @else
            @php                             
                $date_parts = explode('/', $date);
                $correct_format = $date_parts[1] . '-' . $date_parts[0] . '-01';
                $timestamp = strtotime($correct_format);
                $formattedDate = date('F Y', $timestamp);                        
            @endphp
        <h6 class="mb" style="text-transform: uppercase;margin:0px 0px"><b>As at </b>  {{date('F Y', strtotime(@$formattedDate))}}</h6>
        @endif
    </div>

    <table style="width: 100%;border-spacing: 0px;" cellpadding="1" class="balancesheet-table">
        <thead>
            <tr>
                <td class="text-left"><b>Particulars</b></td>
                <td class="text-right"><b>Current</b></td>                              
            </tr>
            <tr>
                <td style="border-top:none"></td>
                <td  class="text-right" style="border-top:none">
                    <small> 
                        @if($search_type == 'daily')
                        {{date("d/m/Y", strtotime(@$from_date))}} - {{date("d/m/Y", strtotime(@$to_date))}}
                        @else
                        {{@$date}}
                        @endif
                    </small>
                </td>
            </tr>
        </thead>
        <tbody>                   
            @if(!empty($profit_loss))
            <!-- Income -->
                <tr>
                    <td colspan="2" class="head-title" style="border-top: 1px solid #B4B5B6;"><strong>Income</strong></td>
                </tr>
                
                @foreach(collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->groupBy('acc_4type_name') as $key => $item)                                          
                    <tr>
                        <td class="first_row lh-10">                                                                        
                            @php 
                                $type_price = (collect($item)->where('acc_4type_name',$key)->sum('cr'));    
                            @endphp
                            <span style="padding: 1px;font-size:12px">{{$key}}</span>                                                                                                                    
                        </td>

                        <td class="text-right lh-10">
                           @if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif
                        </td>
                    </tr>
                @endforeach                                                                                    
                
                                                                
                <!-- Operating Expense -->
                
                @if($operating_gain_loss > 0)
                
                    <tr>
                        <td class="head-title"><strong>Operating Gain</strong></td>
                        <td class="text-right">@if($operating_gain_loss >= 0) {{number_format($operating_gain_loss,2)}} @else {{"(".number_format(abs($operating_gain_loss),2).")"}} @endif</td>
                    </tr>
                    <tr><td class="head-title" colspan="2"></td></tr>                                                                               
                @endif
                <!-- Close Operating Expense -->
                                                                                                                   
                <tr>
                    @php 
                    $net_income_ammount = collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->sum('cr');
                    if($operating_gain_loss > 0){
                        $net_income_ammount+= $operating_gain_loss;
                    }
                    
                    @endphp
                    <td class="head-title  border-top-none"><strong>Net Income</strong></td>
                    <td class="text-right border-top-none"><strong>@if($net_income_ammount >= 0) {{number_format($net_income_ammount,2)}} @else {{"(".number_format(abs($net_income_ammount),2).")"}} @endif</strong></td>
                </tr>
            <!-- Close Income -->
            @endif
        </tbody>
    </table>
