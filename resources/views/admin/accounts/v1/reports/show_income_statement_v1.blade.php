
@extends('admin.layouts.master')
@push('css_custom')
<style>
    table td {
        font-size: 15px;
        border-top: 1px solid #B4B5B6;
        border-left:none;
        border-right:none;
        padding-right:3px;
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
    summary {
        cursor: pointer;
        outline: none;
        border: none
    } 
    details:not([open]) > *:not(summary) {
        display: none;
        
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
@endpush


@php 
    $operating_gain_loss_dr = collect($profit_loss->getData()->data)->where('bal_inc_tag','=','NONOPGL')->sum('dr');
    $operating_gain_loss_cr = collect($profit_loss->getData()->data)->where('bal_inc_tag','=','NONOPGL')->sum('cr');
    $operating_gain_loss = floatVal($operating_gain_loss_dr) - floatVal($operating_gain_loss_cr);
@endphp

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-md-12">
                    <h4 style="margin-top: 20px; text-align:center;" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>           
                    <div class="voucher_title" style="margin-top: 20px; text-align:center;">
                        <h5 style="margin-bottom: 10px; text-transform:uppercase;">
                            Income Statement
                        </h5>
                        @if($search_type == 'daily')
                        <h6 class="mb"><b>As at {{date("d F Y", strtotime(@$to_date))}}</b></h6>
                        @else
                            @php                             
                                $date_parts = explode('/', $date);
                                $correct_format = $date_parts[1] . '-' . $date_parts[0] . '-01';
                                $timestamp = strtotime($correct_format);
                                $formattedDate = date('F Y', $timestamp);
                            @endphp
                        <h6 class="mb" style="text-transform: uppercase"><b>As at </b>  {{date('F Y', strtotime(@$formattedDate))}}</h6>
                        @endif
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12"> 
                    @if(!empty($profit_loss))
                        @if(!empty($profit_loss))
                            <div class="end export-option my-2">
                                <ul class="list-group list-group-horizontal-sm">
                                    <li class="list-group-item"><span onclick="downloadProfitLoss('pdf-nd')" style="cursor:pointer"><button class="btn btn-sm btn-primary"> Export PDF</button></span></li>
                                    <li class="list-group-item"><span onclick="downloadProfitLoss('excel-nd')" style="cursor:pointer"><button class="btn btn-sm btn-success"> Export Excel</button></span></li>                                 
                                    <li class="list-group-item"><span onclick="downloadProfitLoss('pdf')" style="cursor:pointer"><button class="btn btn-sm btn-primary"> Export PDF (Details)</button></span></li>
                                    <li class="list-group-item"><span onclick="downloadProfitLoss('excel')" style="cursor:pointer"><button class="btn btn-sm btn-success"> Export Excel (Details)</button></span></li>                                 
                                </ul>
                            </div> 
                        @endif

                    @endif
                </div>
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
                                <td colspan="2" class="first_row">                                                     
                                    <details>
                                        @php 
                                            $type_price = (collect($item)->where('acc_4type_name',$key)->sum('cr'));    
                                        @endphp
                                        <summary style="padding: 1px;font-size:12px">{{$key}} <span style="float:right">@if($type_price >= 0) {{number_format($type_price,2)}} @else {{"(".number_format(abs($type_price),2).")"}} @endif<b></b></span></summary>
                                        <table style="width:80%">
                                            <tbody>
                                                @foreach(collect($item)->groupBy('acc_5type_description') as $key2 => $item2)
                                                <tr>
                                                    <td style="border:none">
                                                        <details>
                                                            @php 
                                                                $desc_price = (collect($item2)->where('acc_5type_description',$key2)->sum('cr'));    
                                                            @endphp
                                                            <summary class="description-level">{{$key2}}<span style="float:right">@if($desc_price >= 0) {{number_format($desc_price,2)}} @else {{"(".number_format(abs($desc_price),2).")"}} @endif<b></b></span></summary>
                                                            <table style="width:80%">
                                                                <tbody>
                                                                
                                                                    @foreach ($item2->groupBy('account_code') as $key3 => $item4)
                                                                 
                                                                    <tr>                           
                                                                        @php
                                                                            $gl_price = collect($item4)->sum('cr');                   
                                                                        @endphp
                                                                        <td class="gl-level">{{$item4[0]->account_name}} - <a href="{{route('v1.accounts.show-ledger-statement','')}}?acc_pk={{$item4[0]->account_no_pk}}&hid_acc_code={{$key3}}&from_date={{$from_date}}&to_date={{$to_date}}" target="_blank">{{$key3}}</a><span style="float:right">@if($gl_price >= 0) {{number_format($gl_price,2)}} @else {{"(".number_format(abs($gl_price),2).")"}} @endif<b></b></span></td>
                                                                    </tr> 
                                                                        
                                                                    @endforeach
                                                                    
                                                                </tbody>
                                                            </table>
                                                        </details>
                                                    </td>
                                                </tr>
                                                @endforeach
                                            </tbody>
                                        </table>
                                    </details>                                                                                                                       
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
        </div>
    </div>
</div>
@endsection
@push('scripts')
<script>
    function downloadProfitLoss(type){
            var from_date = '<?php echo json_encode($from_date); ?>';
            var to_date = '<?php echo json_encode($to_date); ?>';
            var search_type = '<?php echo json_encode($search_type); ?>';
            var date = '<?php echo json_encode($date); ?>';
            var prev_from_date = '<?php echo json_encode($prev_from_date); ?>';
            var prev_to_date = '<?php echo json_encode($prev_to_date); ?>';
            from_date = JSON.parse(from_date);
            to_date = JSON.parse(to_date);
            search_type = JSON.parse(search_type);
            date = JSON.parse(date);
            prev_from_date = JSON.parse(prev_from_date);
            prev_to_date = JSON.parse(prev_to_date);
            if(type == 'excel'){
                var url = '{{route('v1.accounts.download-income-statement-excel')}}';
            }
            else if(type == 'pdf'){
                var url = '{{route('v1.accounts.download-income-statement-pdf')}}';
            }
            else if(type == 'pdf-nd'){
                var url = '{{route('v1.accounts.download-income-statement-pdf-nd')}}';
            }
            else if(type == 'excel-nd'){
                var url = '{{route('v1.accounts.download-income-statement-excel-nd')}}';
            }
            $.ajax({
            url: url,
            method: 'post',
            data:{from_date:from_date,to_date:to_date,search_type:search_type,date:date,prev_from_date:prev_from_date,prev_to_date:prev_to_date},    
            xhrFields: {
                responseType: 'blob' 
            },
            success: function(data) {
                var downloadLink = document.createElement('a');
                var url = window.URL.createObjectURL(new Blob([data]));
                downloadLink.href = url;
                if(type == 'excel' || type == 'excel-nd')
                    downloadLink.setAttribute('download', 'income_statement.xls');

                else if(type == 'pdf' || type == 'pdf-nd')                     
                    downloadLink.setAttribute('download', 'income_statement.pdf');
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
                window.URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error);
            }
            });
        }
</script>
@endpush