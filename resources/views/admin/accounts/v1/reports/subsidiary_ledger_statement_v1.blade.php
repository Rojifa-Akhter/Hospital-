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
        padding: 5px;
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
        padding: 5px;
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
        padding: 5px;
        border-bottom: 5px double #333;
        border-top: 5px double #333;
    }

    table tr td:nth-last-child(){
        border: 0.1px solid black;
        page-break-inside: avoid !important;
    }

    td {
        border: 1px solid #333;
    }

    table td, th {
        font-size:11px;
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
                Subsidiary Ledger of <span style="font-style:italic;"> "{{$leder_of_code}}-{{$leder_of}}"</span>
            </h3>
            <h3 class="mb" style="text-transform: uppercase">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{@$to_date}}</h3>
        </div>
    </div>
    
</div>

@php
    
    $sum_outflow = 0;
    $sum_inflow = 0;
    $balance = 0;
    $total_dr = 0;
    $total_cr = 0;
    $total_balance = 0;
    $total_opb = 0;
@endphp
<table class="table mb-0" style="width: 100%;" cellspacing="0">
    <thead>
        <tr class="bg-primary">
            <td style="text-align: center; border: 1px solid #333; padding:5px; font-weight:bold;">Code</td>
            <td style="border: 1px solid #333; padding:5px; font-weight:bold;">GL Description</td>
            <td style="border: 1px solid #333; text-align:center; padding:5px; font-weight:bold;">Opening Balance</td>
            <td style="border: 1px solid #333; text-align:right; padding:5px; font-weight:bold;">Dr(tk).</td>
            <td style="border: 1px solid #333;text-align:right; padding:5px; font-weight:bold;">Cr(tk).</td>
            <td style="border: 1px solid #333;text-align:right; padding:5px; font-weight:bold;">Total Balance(tk)</td>
        </tr>
    </thead>
    <tbody>
        @if(empty($root_info))
            <tr>
            <td colspan="2">No Data Found</td>
            </tr>
        @else
            
                        
                        
                                        @foreach($root_info->getData()->data as $root)
                                            @php
                                                $total_balance += (($root->opening_balance+$root->dr)-$root->cr);
                                                $total_opb += $root->opening_balance;
                                                $total_dr += $root->dr;
                                                $total_cr += $root->cr;
                                            @endphp
                                            <tr>
                                                <td style="text-align: center; padding-bottom: 10px;padding-top:10px; font-weight:bold;">{{$root->journal_code}}</td>
                                                <td style="padding-left: 5px; padding-bottom: 10px;padding-top:10px; "><a style="text-decoration: none; color: #333;" target="_blank" href="{{route('accounts.show-ledger-statement',['hid_acc_code' => @$root->journal_code,'from_date' => $from_date,'to_date' => $to_date])}}">{{ucwords(strtolower($root->tran_head))}}</a></td>
                                                <td style="text-align: right; padding-bottom: 10px;padding-top:10px;  font-style:italic;">{{number_format($root->opening_balance,2)}}</td>
                                                
                                                <td style="text-align: right; padding-bottom: 10px;padding-top:10px;  font-style:italic;">{{number_format($root->dr,2)}}</td>
                                                <td style="text-align: right; padding-bottom: 10px;padding-top:10px;  font-style:italic;">{{number_format($root->cr,2)}}</td>
                                                <td style="text-align: right; padding-bottom: 10px;padding-top:10px;  font-style:italic;">{{number_format((($root->opening_balance+$root->dr)-$root->cr),2)}}</td>
                                            </tr>
                                        @endforeach
                        
        @endif
            
        <tr>
            <td style="text-align: center; padding-bottom: 5px; font-weight:bold;" colspan="2">Total</td>
            <td style="text-align: right; padding-bottom: 5px; font-style:italic; font-weight:bold">{{number_format($total_opb,2)}}</td>
            
            <td style="text-align: right; padding-bottom: 5px; font-style:italic; font-weight:bold">{{number_format($total_dr,2)}}</td>
            <td style="text-align: right; padding-bottom: 5px; font-style:italic; font-weight:bold">{{number_format($total_cr,2)}}</td>
            <td style="text-align: right; padding-bottom: 5px; font-style:italic; font-weight:bold">{{number_format(($total_balance),2)}}</td>
        </tr>
    </tbody>
</table>