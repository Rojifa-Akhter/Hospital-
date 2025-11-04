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

    table td {
        border: 1px solid #333;
        font-size: 12px;
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
                Ledger of <span style="font-style:italic;">@if(isset($ledger_of_code))"{{$leder_of_code}}-{{$leder_of}}"@else {{$leder_of}} @endif</span>
            </h3>
            <h3 class="mb" style="text-transform: uppercase">From Date: {{date("d/m/Y", strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h3>
        </div>
    </div>
    
</div>

@php
    
    $sum_outflow = 0;
    $sum_inflow = 0;
@endphp
<table class="table mb-0" style="width: 100%;" cellspacing="0">
    <thead>
        <tr class="bg-primary">
            
            <td style="border: 1px solid #333; text-align:center; padding:5px; font-weight:bold;">Date</td>
            <td style="border: 1px solid #333; text-align:center; padding:5px; font-weight:bold;">Voucher.No</td>
            <td style="border: 1px solid #333; padding:5px; font-weight:bold;">Voucher Type</td>
            <td style="border: 1px solid #333; padding:5px; font-weight:bold;" colspan="2">Particulars</td>
            
            <td style="border: 1px solid #333; text-align:right; padding:5px; font-weight:bold;">Dr(tk).</td>
            <td style="border: 1px solid #333;text-align:right; padding:5px; font-weight:bold;">Cr(tk).</td>
            <td style="border: 1px solid #333;text-align:right; padding:5px; font-weight:bold;">Balance(tk)</td>
        </tr>
    </thead>
    <tbody>
        @if(empty($self_ledger))
            <tr>
            <td colspan="2">No Data Found</td>
            </tr>
        @else
                        @php
                            $balance = 0;
                            $total_dr = 0;
                            $total_cr = 0;
                        @endphp
            
                        <tr>
                            <td style="padding-left: 30px; padding-top:5px;padding-bottom: 5px; font-weight:bold;" colspan="7">Opeing Balance</td>
                            <td style="text-align: right; padding-top:5px;padding-bottom: 5px; font-style:italic;">@if($self_ledger->getData()->opening_bal[0]->opening_bal > 0) {{number_format(abs($self_ledger->getData()->opening_bal[0]->opening_bal),2)}} @else {{number_format($self_ledger->getData()->opening_bal[0]->opening_bal,2)}} @endif</td>
                        </tr>
                        
                                        @php
                                            $balance = $self_ledger->getData()->opening_bal[0]->opening_bal;
                                        @endphp
                                       
                                        @foreach($self_ledger->getData()->ledger_details as $root)
                                            @php
                                                $balance += ($root->dr-$root->cr);
                                                $total_dr += $root->dr;
                                                $total_cr += $root->cr;
                                            @endphp
                                            <tr>
                                                
                                                <td style="text-align: center; padding-bottom: 5px;">{{date("d/m/Y",strtotime($root->journal_date))}}</td>
                                                <td style="text-align: center; padding-bottom: 5px;"><a target="new" style="text-decoration: none; color:#333;" href="{{route('voucher',['voucher_id' => @$root->journal_code,'from_date' => $from_date, 'to_date' => $to_date])}}">{{$root->journal_code}}</a></td>
                                                <td style="padding-left: 5px; padding-bottom: 5px;">@if($root->is_contra == 1) Contra @else {{ucwords(strtolower($root->voucher_type_name))}} @endif</td>
                                                {{-- <td style="padding-left: 5px; padding-bottom: 5px;">{{ucwords(strtolower($root->voucher_type_name))}}</td> --}}
                                                @if (!empty($root->patient_name))
                                                <td style="padding-left: 5px; padding-bottom: 5px;"><a target="new" style="text-decoration: none; color:#333;" href="{{route('accounts.show-patient-ledger-statement',['hid_acc_code' => @$root->patient_no_fk,'from_date' => $from_date, 'to_date' => $to_date])}}">{{$root->patient_name}}</a></td>
                                                @elseif (!empty($root->full_name))
                                                    <td style="padding-left: 5px; padding-bottom: 5px;"><a target="new" style="text-decoration: none; color:#333;" href="{{route('accounts.show-employee-ledger-statement',['hid_acc_code' => @$root->person_no_fk,'from_date' => $from_date, 'to_date' => $to_date])}}">{{$root->full_name}}</a></td>
                                                @elseif (!empty($root->supplier_name))
                                                    <td style="padding-left: 5px; padding-bottom: 5px;"><a target="new" style="text-decoration: none; color:#333;" href="{{route('accounts.show-supplier-ledger-statement',['hid_acc_code' => @$root->supplier_no_fk,'from_date' => $from_date, 'to_date' => $to_date])}}">{{$root->supplier_name}}</a></td>
                                                @else    
                                                    <td style="padding-left: 5px; padding-bottom: 5px;"><a target="new" style="text-decoration: none; color:#333;" href="#"></a></td>
                                                
                                                    @endif
                                                <td style="padding-left: 5px; padding-bottom: 5px;"><span style="font-size:10px; font-style:italic;font-weight:bold;">{{$root->narration_text}}</span></td>
                                                {{-- <td style="padding-left: 5px; padding-bottom: 5px;">{{ucwords(strtolower($root->root_head))}}</td> --}}
                                                <td style="text-align: right; padding-bottom: 5px; font-style:italic;">{{number_format($root->dr,2)}}</td>
                                                <td style="text-align: right; padding-bottom: 5px; font-style:italic;">{{number_format($root->cr,2)}}</td>
                                                <td style="text-align: right; padding-bottom: 5px; font-style:italic;">{{number_format($balance,2)}}</td>
                                                
                                            </tr>
                                        @endforeach
                        
        @endif
            
        <tr>
            <td style="font-weight: bold; padding:5px;" colspan="5">Total</td>
            
            <td style="border-bottom: 5px double #333; padding:5px;border-top: 5px double #333;padding:  5px 0px 10px 0px; height: 40px;"> <span style="float:right; font-weight: bold; font-style:italic;">{{number_format($total_dr,2)}}</span></td>
            <td style="border-bottom: 5px double #333; padding:5px;border-top: 5px double #333;padding:  5px 0px 10px 0px; height: 40px;"> <span style="float:right; font-weight: bold; font-style:italic;">{{number_format($total_cr,2)}}</span></td>
            <td style="border-bottom: 5px double #333; padding:5px;border-top: 5px double #333;padding:  5px 0px 10px 0px; height: 40px;"> <span style="float:right; font-weight: bold; font-style:italic;">@if($balance > 0) {{number_format($balance,2)}} Dr. @else {{number_format($balance,2)}} Cr. @endif</span></td>
        </tr>
        
        <tr>
            <td style="font-weight: bold; padding:5px;" colspan="6">Closing Balance</td>
            <td colspan="2" style="border-bottom: 5px double #333; padding:5px;padding: 5px;text-align:right; "><span style="font-weight: bold;"></span> <span style="font-weight: bold; font-style:italic;">@if($balance>0) <span style="font-weight: bold;"> {{number_format(abs($balance),2)}} Dr. </span> @else <span style="font-weight: bold;"> {{number_format(abs($balance),2)}} Cr. </span> @endif</span></td>
            
        </tr>
    </tbody>
</table>