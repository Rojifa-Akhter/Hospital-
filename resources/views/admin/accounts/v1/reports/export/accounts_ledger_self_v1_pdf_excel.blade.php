

<style>
    table{
        border-collapse: collapse;
    }
    table td {
        font-size: 11px;
        padding-right:3px;
        border:1px solid black;
        line-height: 8px;
    }
     .table th {
        font-size: 14px !important;
    }
    .nowrap{
        white-space: nowrap
    }
</style>

    <h4 style="margin-top: 20px; text-align:center; margin-bottom:0px" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>

    <div style="text-align:center;">
        <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; margin-bottom:0px">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h6>
        <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; font-size:12px"><b>GL</b>: <span style="font-style:italic;">{{$leder_of_code}}-{{$leder_of}}</span></h6>
    </div>


    @php
        $sum_outflow = 0;
        $sum_inflow = 0;
    @endphp

    @if(!empty($self_ledger))
            <table style="width: 100%;" cellspacing="0">
                <thead>
                    <tr style="background-color: #003B61;color:white">                                    
                        <td style="text-align:left; padding:3px; font-weight:bold;">Date</td>
                        <td style="text-align:center; padding:3px; font-weight:bold;">Journal Id</td>
                        <td style="text-align:left; padding:3px; font-weight:bold;">Journal Type</td>
                        <td style="text-align:left; padding:3px; font-weight:bold;">Particulars</td>  
                        <td style="text-align:left; padding:3px; font-weight:bold;">Sub Ledger Name</td>
                        <td style="text-align:left; padding:3px; font-weight:bold;">Debit</td>
                        <td style="ext-align:left; padding:3px; font-weight:bold;">Credit</td>
                        <td style="ext-align:left; padding:3px; font-weight:bold;">Balance</td>
                        <td style="ext-align:left; padding:3px; font-weight:bold;" class="nowrap">Naration</td>
                        <td style="ext-align:left; padding:3px; font-weight:bold;">Note</td>
                        <td style="ext-align:left; padding:3px; font-weight:bold;">Entry By</td>
                    </tr>
                </thead>
            
                <tbody>
                    @if(empty($self_ledger))
                        <tr>
                            <td colspan="11" class="text-center">No Data Found</td>
                        </tr>
                    @else
                    @php
                        $balance = 0;
                        $total_dr = 0;
                        $total_cr = 0;
                    @endphp
        
                    <tr>
                        <td style="padding-left: 30px; padding-top:3px;padding-bottom: 3px; font-weight:bold;text-align:center;background-color:#003aff42" colspan="7">Opeing Balance</td>
                        <td style="text-align: right; padding-top:3px;padding-bottom: 3px; font-style:italic;">@if($self_ledger->getData()->opening_bal[0]->opening_bal > 0) {{number_format(abs($self_ledger->getData()->opening_bal[0]->opening_bal),2)}} @else {{number_format($self_ledger->getData()->opening_bal[0]->opening_bal,2)}} @endif</td>
                        <td colspan="3"></td>

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
                            <td style="text-align: left; padding-bottom: 3px;">{{date("d/m/Y",strtotime($root->journal_date))}}</td>
                            <td style="text-align: left; padding-bottom: 3px;"><a target="new" href="{{route('view_journal')}}?journal_id={{$root->journal_code}}">{{$root->journal_code}}</a></td>
                            <td style="padding-left: 3px; padding-bottom: 3px;">{{ucwords(strtolower($root->voucher_type_name))}}</td>
                            <td style="padding-left: 3px; padding-bottom: 3px;"><a target="new" style="text-decoration: none; color:#333;" href="#">{{$root->opposite_head}}</a></td>                                     
                            <td style="text-align: left; padding-bottom: 3px; font-style:italic;">{{$root->subledger_name}}</td>
                            <td style="text-align: right; padding-bottom: 3px; font-style:italic;">{{number_format($root->dr,2)}}</td>
                            <td style="text-align: right; padding-bottom: 3px; font-style:italic;">{{number_format($root->cr,2)}}</td>
                            <td style="text-align: right; padding-bottom: 3px; font-style:italic;">@if($balance >= 0) {{number_format($balance,2)}} @else {{ '('.number_format(abs($balance),2).')'}} @endif</td>
                            <td style="padding-left: 3px; padding-bottom: 3px;">{{$root->narration_text}}</td>
                            <td style="padding-left: 3px; padding-bottom: 3px;">{{$root->voucher_remarks}}</td>
                            <td style="padding-left: 3px; padding-bottom: 3px;">{{$root->prepare_by}}</td> 
                        </tr>
                    @endforeach

                    <tr>
                        <td style="font-weight: bold; padding:3px;" colspan="5">Total</td>
                        <td style="padding:3px;text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">{{number_format($total_dr,2)}}</span></td>
                        <td style="padding:3px; text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">{{number_format($total_cr,2)}}</span></td>
                        <td style="padding:3px; text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">@if($balance >= 0) {{number_format($balance,2)}} @else {{ '('.number_format(abs($balance),2).')'}} @endif</span></td>
                        <td colspan="3" style="border-bottom:0px;border-right:0px"></td>
                    </tr>                                                                                                      
                    @endif       
                </tbody>
            </table>
    @endif


