

<style>
    table{
        border-collapse: collapse;
    }
    table td {
        font-size: 13px;
        padding-right:3px;
        border:1px solid #B4B5B6;
    }

     .table th {
        font-size: 13px !important;
        border:1px solid #B4B5B6;
    }
    .end{
        display: flex;
        justify-content: end;
    }
    .pdf-icon{
        font-size: 22px;
        color: red
    }
    .excel-icon{
        font-size: 22px;
        color:green
    }
  
</style>


<h4 style="margin-top: 20px; text-align:center; margin-bottom:0px" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>            
<h5 style="margin-top: 10px; text-align:center; margin-bottom:0px" >Sub Ledger Report</h5>            
<div style="text-align:center;">
    <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; margin-bottom:0px">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h6>
    <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; font-size:12px;margin-bottom:0px"><b>Sub Ledger</b>: <span style="font-style:italic;">{{$leder_of_code}}-{{$leder_of}}</span></h6>
    <h6 class="mb" style="text-transform: uppercase;margin-top: 0px; font-size:12px"><b>GL: </b><span style="font-style:italic;"> {{@$hid_acc_code}} - {{@$self_ledger->getData()->ledger_details[0]->account_name}}</span></h6>
</div>

<table class="table" style="width: 100%;" cellspacing="0">
    <thead>
        <tr style="background-color: #003B61;color:white">                                       
            <th style="text-align:left; padding:3px; font-weight:bold;" style="width:5%">Transaction Date</th>
            <th style="text-align:left; padding:3px; font-weight:bold;" style="width:10%">Particulars</th>
            <th style="text-align:center; padding:3px; font-weight:bold;" style="width:5%">Ref ID</th>
            <th style="text-align:left; padding:3px; font-weight:bold;" style="width:5%">Journal Type</th>                                                                       
            <th style="text-align:left; padding:3px; font-weight:bold;"style="width:5%">Debit</th>
            <th style="ext-align:left; padding:3px; font-weight:bold;"style="width:5%">Credit</th>
            <th style="ext-align:left; padding:3px; font-weight:bold;"style="width:5%">Balance</th>
            <th style="ext-align:left; padding:3px; font-weight:bold;" style="width:5%">Cr./Dr.</th>
            <th style="ext-align:left; padding:3px; font-weight:bold;"style="width:21%">Naration</th>
            <th style="ext-align:left; padding:3px; font-weight:bold;"style="width:3%">Company</th>
            <th style="ext-align:left; padding:3px; font-weight:bold;"style="width:3%">PO No</th>
            <th style="ext-align:left; padding:3px; font-weight:bold;"style="width:3%">GRN No</th>
            <th style="ext-align:left; padding:3px; font-weight:bold;"style="width:5%">Note</th>
            <th style="ext-align:left; padding:3px; font-weight:bold;"style="width:5%">Entry By</th>
            <th style="ext-align:left; padding:3px; font-weight:bold;"style="width:5%">Posting Date</th>
            <th style="ext-align:left; padding:3px; font-weight:bold;"style="width:5%">Cheque Date</th>
            <th style="ext-align:left; padding:3px; font-weight:bold;"style="width:5%">Cheque No</th>
        </tr>
    </thead>

    <tbody>

        @php
            $balance = 0;
            $total_dr = 0;
            $total_cr = 0;
        @endphp

        <tr>
            <td style="padding-left: 30px; padding-top:3px;padding-bottom: 3px; font-weight:bold;text-align:center;background-color:#003aff42" colspan="6">Opeing Balance</td>
            <td style="text-align: right; padding-top:3px;padding-bottom: 3px; font-style:italic;">@if($self_ledger->getData()->opening_bal[0]->opening_bal >= 0) {{number_format(abs($self_ledger->getData()->opening_bal[0]->opening_bal),2)}} @else {{'('.number_format(abs($self_ledger->getData()->opening_bal[0]->opening_bal),2).')'}} @endif</td>
            <td>@if($self_ledger->getData()->opening_bal[0]->opening_bal >= 0) {{'Debit'}} @else {{'Credit'}} @endif</td>
            <td colspan="9"></td>
        </tr>
        
        @php
            $balance = $self_ledger->getData()->opening_bal[0]->opening_bal;
        @endphp
        
        @forelse($self_ledger->getData()->ledger_details as $root)
            @php
                $balance += ($root->dr-$root->cr);
                $total_dr += $root->dr;
                $total_cr += $root->cr;
            @endphp
            <tr>
                
                <td style="text-align: left; padding-bottom: 3px;">{{date("d/m/Y",strtotime($root->doc_date))}}</td>
                <td style="padding-left: 3px; padding-bottom: 3px;">{{$root->account_name}}</td>
                <td style="text-align: left; padding-bottom: 3px;"><a target="new" href="{{route('view_journal')}}?journal_id={{$root->journal_code}}">{{$root->journal_code}}</a></td>
                <td style="padding-left: 3px; padding-bottom: 3px;"> {{ucwords(strtolower($root->voucher_type_name))}}</td>
                <td style="text-align: right; padding-bottom: 3px; font-style:italic;">{{number_format($root->dr,2)}}</td>
                <td style="text-align: right; padding-bottom: 3px; font-style:italic;">{{number_format($root->cr,2)}}</td>
                <td style="text-align: right; padding-bottom: 3px; font-style:italic;">@if($balance >= 0) {{number_format($balance,2)}} @else {{ '('.number_format(abs($balance),2).')'}} @endif</td>
                <td style="padding-left: 3px; padding-bottom: 3px;">@if($root->dr > 0) {{'Debit'}} @else {{'Credit'}} @endif</td>
                <td style="padding-left: 3px; padding-bottom: 3px;">{{$root->narration_text}}</td>
                <td style="padding-left: 3px; padding-bottom: 3px;">{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</td>
                <td style="padding-left: 3px; padding-bottom: 3px;"></td>
                <td style="padding-left: 3px; padding-bottom: 3px;"></td>
                <td style="padding-left: 3px; padding-bottom: 3px;">{{$root->voucher_remarks}}</td>
                <td style="padding-left: 3px; padding-bottom: 3px;">{{$root->prepare_by}}</td>
                <td style="padding-left: 3px; padding-bottom: 3px;">{{date("d/m/Y",strtotime($root->journal_date))}}</td>
                <td style="padding-left: 3px; padding-bottom: 3px;">{{$root->bank_cheq_number}}</td>
                <td style="padding-left: 3px; padding-bottom: 3px;">@if(! empty($root->bank_cheq_date)){{ date('m/d/Y', strtotime($root->bank_cheq_date))}} @endif</td>
                
            </tr>
            @empty
            <tr>
                <td colspan="17" class="text-center">No Data Found</td>
            </tr> 
        @endforelse

        <tr>
            <td style="font-weight: bold; padding:3px;" colspan="4">Total</td>
            <td style="padding:3px;text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">{{number_format($total_dr,2)}}</span></td>
            <td style="padding:3px; text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">{{number_format($total_cr,2)}}</span></td>
            <td style="padding:3px; text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">@if($balance >= 0) {{number_format($balance,2)}} @else {{ '('.number_format(abs($balance),2).')'}} @endif</span></td>
            <td colspan="10"></td>
        </tr>                                                                                                                                                         
    </tbody>
</table>
