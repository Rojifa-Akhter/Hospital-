@extends('admin.layouts.master')
@push('css_custom')
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
.TrialBalanceReport table td {
    font-size: 12px !important;
    border: 1px solid #e9e8eb !important;
    white-space: nowrap;
    padding: 2px 4px !important;
}

.end {
    display: flex;
    justify-content: end;
}

.list-group-item {
    border: none !important;
    padding: 5px 5px !important;
    padding-bottom: 0px !important;
    background-color: unset;
}

.pdf-icon {
    font-size: 22px;
    color: red
}

.excel-icon {
    font-size: 22px;
    color: green
}

.list-group-item.active {
    background-color: unset !important;
}

/* .TrialBalanceReport {
    overflow-x: auto;
} */

.TrialBalanceReport table>thead>tr {
    background-color: #98a2b3 !important;
    color: white;
}

.TrialBalanceReport table>thead>tr>td {
    padding-right: 20px !important;
}

.top-table {
    width: 100%;
    margin-bottom: 20px;
}

.top-table td {
    border: none !important;
    padding: 1px 20px !important;
    font-size: 13px !important;
}
table {
  table-layout: fixed;
  width: 100%; 
}
thead {
  position: sticky;
  top: 0px;
  left:0px;
  right:0px;
}
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body p-2">

            <div class="row">
                <div class="col-md-12">
                    <h4 style="margin-top: 20px; text-align:center;">
                        {{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>

                    <div class="voucher_title" style="margin-top: 20px; text-align:center;">
                        <h5 style="margin-bottom: 10px; text-transform:uppercase;">
                            Trial Balance
                        </h5>
                        <h6 class="mb" style="text-transform: uppercase">From Date:
                            {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}
                        </h6>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @if(!empty($root_info))
                    <div class="end export-option my-2">
                        <ul class="list-group list-group-horizontal-sm">
                            <li class="list-group-item"><span onclick="downloadTrialBalanceReport('excel')" style="cursor:pointer"><i class="fas fa-file-excel excel-icon"></i></span></li>
                        </ul>
                    </div> 
                    <div class="TrialBalanceReport">      
                        <table cellspacing="0" class="TrialBalanceReport" id="TrialBalanceReportDatatable">
                            <thead>
                                <tr>
                                    <td style="width:30%">GL (Code & Description)</td>
                                    <td style="width:10%">Opening Balance <br> Debit</td>
                                    <td style="width:10%">Opening Balance <br> Credit</td>
                                    <td style="width:10%">Debit During The <br> Period</td>
                                    <td style="width:10%">Credit During The <br> Period</td>
                                    <td style="width:10%">Closing Balance <br> Debit</td>
                                    <td style="width:10%">Closing Balance <br> Credit</td>
                                    <td style="width:10%">Total Balance</td>               
                                </tr>
                            </thead>
                            @php
                                $sum_outflow = 0;
                                $sum_inflow = 0;
                                $total_sum_dr = 0;
                                $total_sum_cr = 0;
                                $op_total_cr = 0;
                                $op_total_dr = 0;
                                $dc_total_dr = 0;
                                $cc_total_cr = 0;
                                $total_op_sum_dr = 0;
                                $total_op_sum_cr = 0;
                                $total_total_balance = 0;

                            @endphp
                            @forelse(collect($root_info->getData()->data) as $root)
                                @php           
                                $total_closing_bal_sub_dr = ($root->opening_balance_dr +$root->dr);                         
                                $total_closing_bal_sub_cr = ($root->opening_balance_cr+$root->cr);                         
                                $total_balance = $total_closing_bal_sub_dr -  $total_closing_bal_sub_cr;
                                @endphp
                            <tr>
                                <td style="text-align:left">{{ucwords(strtolower($root->account_code))}} - {{ucwords(strtolower($root->tran_head))}}</td>
                                <td style="text-align:right;">{{number_format($root->opening_balance_dr,2)}}</td>
                                <td style="text-align:right;">{{number_format($root->opening_balance_cr,2)}}</td>
                                <td style="text-align:right;">@php $last_tran_bal_dr = $root->dr @endphp {{number_format($root->dr,2)}}</td>
                                <td style="text-align:right;">@php $last_tran_bal_cr = $root->cr @endphp {{number_format($root->cr,2)}}</td>
                                <td style="text-align:right;">@if($total_closing_bal_sub_dr >= 0) {{number_format($total_closing_bal_sub_dr,2)}} @else {{'('.number_format(abs($total_closing_bal_sub_dr)).')'}} @endif</td>
                                <td style="text-align:right;">@if($total_closing_bal_sub_cr >= 0) {{number_format($total_closing_bal_sub_cr,2)}} @else {{'('.number_format(abs($total_closing_bal_sub_cr)).')'}} @endif</td>
                                <td style="text-align:right;">@if($total_balance >= 0) {{number_format($total_balance,2)}} @else {{"(".number_format(abs($total_balance),2).")"}} @endif</td>
                            </tr>
                                @php                                   
                                    $dc_total_dr += $total_closing_bal_sub_dr;
                                    $cc_total_cr += $total_closing_bal_sub_cr;

                                    $total_op_sum_dr += $root->opening_balance_dr;
                                    $total_op_sum_cr += $root->opening_balance_cr;

                                    $total_sum_dr += $root->dr;
                                    $total_sum_cr += $root->cr;
                                    $total_total_balance += $total_balance;
                                @endphp
                            @empty
                            <tr>
                                <td colspan="8" style="text-align: center"> No Data Found</td>
                            </tr>
                            @endforelse

                            <tr>
                                <td style="border-top:1px solid black !important;border-bottom:1px solid black !important"><span style="font-weight: bold;">Grand Total</span></td>
                                <td style="border-top:1px solid black !important;border-bottom:1px solid black !important;text-align:right"><span style="font-weight: bold;"></span> <span style="float:right; font-weight: bold; font-style:italic;">@if($total_op_sum_dr >= 0){{number_format($total_op_sum_dr,2)}} @else {{ "(".number_format($total_op_sum_dr,2).")"}} @endif</span></td>
                                <td style="border-top:1px solid black !important;border-bottom:1px solid black !important;text-align:right;"><span style="font-weight: bold;">@if($total_op_sum_cr >= 0) {{number_format($total_op_sum_cr,2)}} @else {{'('.number_format(abs($total_op_sum_cr),2).')'}} @endif</span></td>

                                <td style="border-top:1px solid black !important;border-bottom:1px solid black !important;text-align:right;font-weight: bold;">@if($total_sum_dr >= 0) {{number_format($total_sum_dr,2)}} @else {{'('.number_format(abs($total_sum_dr),2).')'}} @endif</td>
                                <td style="border-top:1px solid black !important;border-bottom:1px solid black !important;text-align:right;font-weight: bold;">@if($total_sum_cr >= 0) {{number_format($total_sum_cr,2)}} @else {{'('.number_format(abs($total_sum_cr),2).')'}} @endif</td>
                                <td style="border-top:1px solid black !important;border-bottom:1px solid black !important;text-align:right;"><span style="font-weight: bold;">@if($dc_total_dr >= 0) {{number_format($dc_total_dr,2)}} @else {{'('.number_format(abs($dc_total_dr),2).')'}} @endif</span></td>           
                                <td style="border-top:1px solid black !important;border-bottom:1px solid black !important;text-align:right"><span style="font-weight: bold;"></span> <span style="float:right; font-weight: bold; font-style:italic;">{{number_format($cc_total_cr,2)}}</span></td>
                                <td style="border-top:1px solid black !important;border-bottom:1px solid black !important;text-align:right;font-weight: bold;">@if($total_total_balance >= 0) {{number_format($total_total_balance,2)}} @else {{'('.number_format(abs($total_total_balance),2).')'}} @endif</td>        
                            </tr>
                        </table>
                    </div>  
                    @endif
                </div>
            </div>

        </div>
    </div>
</div>
@endsection
@push('scripts')
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
$(document).ready(function() {
    $('#TrialBalanceReportDatatable').DataTable({
        paging: false,
        searching: true,
        "ordering": false
    });
})


function downloadTrialBalanceReport(type){

            var from_date = '<?php echo json_encode($from_date); ?>';
            var to_date = '<?php echo json_encode($to_date); ?>';
            from_date = JSON.parse(from_date);
            to_date = JSON.parse(to_date);

            if(type == 'excel'){
                var url = '{{route('v1.accounts.download-trial-balance-1-excel')}}';
            }
            else if(type == 'pdf'){
                var url = '{{route('v1.accounts.download-trial-balance-pdf')}}';
            }

            $.ajax({
            url: url,
            method: 'post',
            data:{from_date:from_date,to_date:to_date},
            xhrFields: {
                responseType: 'blob' 
            },
            success: function(data) {
                var downloadLink = document.createElement('a');
                var url = window.URL.createObjectURL(new Blob([data]));
                downloadLink.href = url;
                if(type == 'excel')
                    downloadLink.setAttribute('download', 'trial_balance_report.xls');

                else if(type == 'pdf')                     
                    downloadLink.setAttribute('download', 'trial_balance_report.pdf');
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