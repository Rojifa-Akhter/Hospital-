<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Profit & Loss</title>
    <style>

        table td {
            font-size: 15px;
            border-top: 1px solid #B4B5B6;
            border-left:none;
            border-right:none;
            padding:2px 20px;
            white-space: nowrap
        }
        .end{
            display: flex;
            justify-content: end;
        }
        .list-group-item{
            border:none !important;
            padding: 5px 5px !important;
            padding-bottom: 0px !important;
            background-color: unset;
        }
        .pdf-icon{
            font-size: 22px;
            color: red
        }
        .excel-icon{
            font-size: 22px;
            color:green
        }
        .list-group-item.active {
        background-color: unset !important;
        }
        details {
            border: none;
        }
        .gl-level{
            padding-left: 50px;
            border-top:1px solid #B4B5B6;
            border-bottom:1px solid #B4B5B6;
            border-left:none;
            border-right:none;
            font-size: 12px;
        }
        .description-level{
            padding:3px 0px;
            padding-left:20px; 
            font-size: 12px;
        }
        .first_row{
            border:none;
            padding-left: 50px
        }
        .head-title{
            border-left:none;
            border-right:none;
            text-align: left;
        }
        .border-top-none{
            border-top:none;
        }
    </style>
</head>

<body>
    @php 
        $income = collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->sum('cr');
        $expense = collect($profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->sum('dr');
        $operating_gain_loss_dr = collect($profit_loss->getData()->data)->where('bal_inc_tag','=','NONOPGL')->sum('dr');
        $operating_gain_loss_cr = collect($profit_loss->getData()->data)->where('bal_inc_tag','=','NONOPGL')->sum('cr');
        $operating_gain_loss = floatVal($operating_gain_loss_dr) - floatVal($operating_gain_loss_cr);
        
        if($operating_gain_loss < 0){
            $expense += abs($operating_gain_loss);
        }
        else{
            $income += $operating_gain_loss;
        }
        
        $retained_earnings = floatVal($income) - floatVal($expense); 
    @endphp

    <div class="row">
        <div class="col-md-12">
            <h4 style="margin-top: 20px; text-align:center;" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>           
            <div class="voucher_title" style="margin-top: 20px; text-align:center;">
                <h5 style="margin-bottom: 10px; text-transform:uppercase;">
                    Statement of Profit or Loss
                </h5>
                <h6 class="mb"><b>Date: @if(!empty(@$from_date)) {{date("d/m/Y", strtotime(@$from_date))}} - @endif @if(!empty(@$to_date))  {{date("d/m/Y", strtotime(@$to_date))}} @endif</b></h6>

            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-12">
            <div class="table-responsive">
                <table style="width: 100%;border-spacing: 0px;" cellpadding="1" class="table table-bordered table-hover table-striped">
                    <thead class="bg-primary">
                        <tr>
                            <td class="text-left"><b>Particulars</b></td>
                            @foreach ($asc_months as $key => $item)
                                <td  class="text-right"><b>{{@$key}}</b></td>
                            @endforeach
                        </tr>
                    </thead>
                    <tbody>                   
                        @if(!empty($profit_loss))
                        <!-- Income -->
                            <tr>
                                <td colspan="{{collect($profit_loss->getData()->data)->groupBy('journal_date_formatted')->count() + 1}}" class="head-title" style="border-top: 1px solid #B4B5B6;text-align:left"><strong>Income</strong></td>
                            </tr>
                            
                            @foreach(collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->groupBy('acc_4type_name') as $key => $value)                                          
                                <tr>
                                    <td class="first_row text-left">                                                     
                                        <span style="padding-left: 30px;font-size:12px">{{$key}}</span>                                                                                                                    
                                    </td>
                                    
                                    @foreach ($asc_months as $item)
                                        @php 
                                            $type_price = (collect($value)->where('journal_date_formatted',$item[0]->journal_date_formatted)->sum('cr'));    
                                        @endphp
                                        <td class="text-right" style="font-size:12px; padding-left:20px !important">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</td>
                                    @endforeach
                                </tr>
                            @endforeach   
                            
                                                                            
                            <!-- Operating Expense -->    
                                <tr>
                                    <td class="first_row text-left">                                                     
                                        <span style="padding-left: 30px;font-size:12px">Operating Gain</span>                                                                                                                    
                                    </td>
                                    @foreach ($asc_months as $item)
                                        @php 
                                            $type_price = (collect($item)->where('bal_inc_tag','=','NONOPGL')->sum('dr'));    
                                        @endphp
                                        <td class="text-right" style="font-size:12px; padding-left:20px !important">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</td>
                                    @endforeach

                                </tr>
                                <tr><td class="head-title" colspan="{{collect($profit_loss->getData()->data)->groupBy('journal_date_formatted')->count() + 1}}"></td></tr>                                                                               
                        
                            <!-- Close Operating Expense -->
                                                                                                                                
                            <tr>
                                @php 
                                $net_income_ammount = collect($profit_loss->getData()->data)->where('income_exp_type','INCOME')->where('bal_inc_tag','!=','NONOPGL')->sum('cr');
                                if($operating_gain_loss > 0){
                                    $net_income_ammount+= $operating_gain_loss;
                                }
                                
                                @endphp
                                <td class="head-title  border-top-none text-left"><small> <strong>Net Income</strong> </small></td>
                                <td class="text-right border-top-none" colspan="{{collect($profit_loss->getData()->data)->groupBy('journal_date_formatted')->count()}}"><strong>@if($net_income_ammount >= 0) {{number_format($net_income_ammount,2)}} @else {{"(".number_format(abs($net_income_ammount),2).")"}} @endif</strong></td>
                            </tr>
                        <!-- Close Income -->

                        <!-- Expenses -->
                            <tr>
                                <td colspan="{{collect($profit_loss->getData()->data)->groupBy('journal_date_formatted')->count() + 1}}" class="head-title text-left" style="padding-top: 15px"><strong>Expenses</strong></td>
                            </tr>
                            @foreach(collect($profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->groupBy('acc_4type_name') as $key => $value)                                          
                                <tr>
                                    <td class="first_row text-left">                                                     
                                        <span style="padding-left: 30px;font-size:12px">{{$key}}</span>                                                                                                                    
                                    </td>
                                    
                                    @foreach ($asc_months as $item)
                                        @php 
                                            $type_price = (collect($value)->where('journal_date_formatted',$item[0]->journal_date_formatted)->sum('dr'));    
                                        @endphp
                                        <td class="text-right" style="font-size:12px; padding-left:20px !important">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</td>
                                    @endforeach
                                </tr>
                            @endforeach                                                                                    
                            

                            <!-- Operating Expense -->
                                                
                                <tr>
                                    <td class="first_row text-left">                                                     
                                        <span style="padding-left: 30px;font-size:12px">Operating Loss</span>                                                                                                                    
                                    </td>
                                    @foreach ($asc_months as $item)
                                        @php 
                                            $type_price = (collect($item)->where('bal_inc_tag','=','NONOPGL')->sum('cr'));    
                                        @endphp
                                        <td class="text-right" style="font-size:12px; padding-left:20px !important">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif</td>
                                    @endforeach
                                </tr>    
                                <tr><td class="head-title" colspan="{{collect($profit_loss->getData()->data)->groupBy('journal_date_formatted')->count() + 1}}"></td></tr>
                            
                            <!-- Close Operating Expense -->
                            
                            <tr>
                                @php 
                                    $net_expense = collect($profit_loss->getData()->data)->where('income_exp_type','EXPENSES')->where('bal_inc_tag','!=','NONOPGL')->sum('dr');
                                    if($operating_gain_loss < 0){
                                    $net_expense+= floatVal(abs($operating_gain_loss));
                                    }
                                    
                                @endphp
                                <td class="head-title text-left"><small><strong>Net Expense</strong></small></td>
                                <td class="text-right " colspan="{{collect($profit_loss->getData()->data)->groupBy('journal_date_formatted')->count()}}"><strong>@if($net_expense >=0) @if($net_expense >= 0) {{number_format($net_expense,2)}} @else {{"(".number_format(abs($net_expense),2).")"}} @endif @else {{"(".number_format(abs($net_expense),2).")"}} @endif</strong></td>
                            </tr>

                            <tr>                           
                                <td class="head-title border-top-none" style="padding-top:20px; text-align:right"><strong>@if($retained_earnings >= 0) {{ 'Net Profit' }} @else {{ 'Net Loss' }} @endif</strong></td>
                                <td class="text-right border-top-none" style="padding-top:20px" colspan="{{collect($profit_loss->getData()->data)->groupBy('journal_date_formatted')->count()}}"><strong>@if($retained_earnings >= 0) {{number_format($retained_earnings,2)}} @else {{"(".number_format(abs($retained_earnings),2).")"}} @endif</strong></td>
                            </tr>
                            
                        <!-- Close Owners Equity -->

                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</body>
</html>

