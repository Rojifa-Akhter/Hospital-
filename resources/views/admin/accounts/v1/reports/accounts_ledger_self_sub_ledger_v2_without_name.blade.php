
@extends('admin.layouts.master')
@push('css_custom')
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    table{
        border-collapse: collapse;
    }
    table td {
        font-size: 13px;
        padding-right:3px;
        border:1px solid #B4B5B6;
    }
    @media (min-width: 1600px){
        .table td, .table th {
            font-size: 13px !important;
        }
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
        color: red;
        cursor: pointer;
    }
    .excel-icon{
        font-size: 22px;
        color:green;
        cursor: pointer;
    }

    .top-table{
        width:100%;
        margin-bottom: 20px;
    } 

    .top-table td{
        border:none !important;
        padding: 1px 20px !important;
        font-size: 13px !important ;
    } 
    a{
        padding: 0px;
    }
</style>
@endpush
@php 

$route = Route::currentRouteName();
@endphp

@section('content')
<main id="page-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-md-12">
                        <h4 style="margin-top: 20px; text-align:center; margin-bottom:0px" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>            
                        <h5 style="margin-top: 10px; text-align:center; margin-bottom:0px" >Supplier Report</h5>        
                        <div style="text-align:center;">
                            <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; margin-bottom:0px">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h6>
                            <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; font-size:12px"><span style="font-style:italic;"><b></b>
                                @if($route == 'v1.accounts.sub-ledger-report-by-id-date-v2')
                                   <b>Supplier: </b> {{$leder_of_code}} - {{$leder_of}}
                                @else
                                {!!@$title!!}
                            @endif
                            </span></h6>
                        </div>
                    </div>
                </div>
                

                @if(!empty($self_ledger))
                    <div class="row">
                        <div class="col-md-12">                                                                           
                            <div class="end">
                                <a style="padding-right: 10px" class="summary-details-v1-pdf" onclick="downloadSubLedgerLedger('pdf')"><i class="fas fa-file-pdf pdf-icon"></i></a>
                                <a class="summary-details-v1-excel" onclick="downloadSubLedgerLedger('excel')"><i class="fas fa-file-excel excel-icon"></i></a>
                            </div>                            
                        </div>
                    </div>
                @endif

                @php
                    $opening_balance = collect($self_ledger->getData()->ledger_details)->sum('opening_bal');
                    $dr = collect($self_ledger->getData()->ledger_details)->sum('dr');
                    $cr = collect($self_ledger->getData()->ledger_details)->sum('cr');
                    $closing_balance = (floatVal($opening_balance) + floatVal($dr)) - floatVal($cr);
                @endphp
                <div class="row">
                    <div class="col-6">
                        <table class="top-table">
                            <tr>
                                <td><strong>Total Dr</strong></td>
                                <td colspan="13" style="text-align:right">@if($dr>0) {{number_format($dr,2)}} @else {{"(".number_format(abs($dr),2).")"}} @endif</td>                               
                            </tr>
                            <tr>
                                <td><strong>Total Cr</strong></td>
                                <td colspan="13" style="text-align:right">@if($cr>0) {{number_format($cr,2)}} @else {{"(".number_format(abs($cr),2).")"}} @endif</td>                               
                            </tr>
                            <tr>
                                <td><strong>Opening Balance</strong></td>
                                <td colspan="13" style="text-align:right">@if($opening_balance>0) {{number_format($opening_balance,2)}} @else {{"(".number_format(abs($opening_balance),2).")"}} @endif</td>                               
                            </tr>
                            <tr>
                                <td><strong>Closing Balance</strong></td>
                                <td colspan="13" style="text-align:right">@if($closing_balance>0) {{number_format($closing_balance,2)}} @else {{"(".number_format(abs($closing_balance),2).")"}} @endif</td>                               
                            </tr>
                            
                        </table>
                    </div>
                </div>


                <div class="row">
                    <div class="col-md-12">
                        <div style="overflow-x: auto">
                            <table class="table" style="width: 100%;" cellspacing="0" id="journalReportDatatable">
                                <thead>
                                    <tr style="background-color: #003B61;color:white">                                       
                                        <th style="text-align:left; padding:3px; font-weight:bold;white-space:nowrap">Code</th>
                                        <th style="text-align:center; padding:3px; font-weight:bold;white-space:nowrap">Subledger Name</th>
                                        <th style="text-align:left; padding:3px; font-weight:bold;white-space:nowrap">Opening Balance</th>                                                                       
                                        <th style="text-align:left; padding:3px; font-weight:bold;">Debit</th>
                                        <th style="ext-align:left; padding:3px; font-weight:bold;">Credit</th>
                                        <th style="ext-align:left; padding:3px; font-weight:bold;white-space:nowrap">Closing Balance</th>
                                    </tr>
                                </thead>
                            
                                <tbody>
                                    @forelse($self_ledger->getData()->ledger_details as $root)

                                        <tr>                       
                                            <td style="padding-left: 3px; padding: 2px;white-space:nowrap"> {{$root->subledger_code}}</td>
                                            <td style="padding-left: 3px; padding: 2px;white-space:nowrap"><a target="new" href="{{route('v1.accounts.sub-ledger-report-by-id-date-v2')}}?hid_acc_code={{$leder_of_code}}&subledger_id={{$root->acct_subledger_no_fk}}&from_date={{@$from_date}}&&to_date={{@$to_date}}">{{$root->subledger_name}}</a></td>
                                            <td style="text-align: right; padding: 2px; font-style:italic;">@if($root->opening_bal > 0) {{number_format($root->opening_bal,2)}} @else {{"(".number_format(abs($root->opening_bal),2).")"}} @endif</td>
                                            <td style="text-align: right; padding: 2px; font-style:italic;">{{number_format($root->dr,2)}}</td>
                                            <td style="text-align: right; padding: 2px; font-style:italic;">{{number_format($root->cr,2)}}</td>
                                            @php 
                                                $closing_bal = (floatVal($root->opening_bal) + floatVal($root->dr)) - floatVal($root->cr);
                                            @endphp
                                            <td style="text-align: right; padding: 2px; font-style:italic;">@if($closing_bal > 0) {{number_format($closing_bal,2)}} @else {{"(".number_format(abs($closing_bal),2).")"}} @endif</td>
                                        </tr>
                                        @empty
                                        <tr>
                                            <td colspan="6" class="text-center">No Data Found</td>
                                        </tr> 
                                    @endforelse                                                                                                                                                      
                                </tbody>
                            </table>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#journalReportDatatable').DataTable({
            paging: false,
            searching: true,
        });
    })



    function downloadSubLedgerLedger(type){
            var from_date = '<?php echo json_encode($from_date); ?>';
            var to_date = '<?php echo json_encode($to_date); ?>';
            var subledger_type = '<?php echo json_encode($subledger_type); ?>';
            var general_ledger = '<?php echo json_encode($gl_code); ?>';

            from_date = JSON.parse(from_date);
            to_date = JSON.parse(to_date);
            subledger_type = JSON.parse(subledger_type);
            general_ledger = JSON.parse(general_ledger);

            if(type == 'excel'){
                var url = '{{route('v1.accounts.subledger-report-type-v2-excel')}}';
            }
            else if(type == 'pdf'){
                var url = '{{route('v1.accounts.subledger-report-type-v2-pdf')}}';
            }
            $.ajax({
            url: url,
            method: 'post',
            data:{from_date:from_date,to_date:to_date,subledger_type:subledger_type,general_ledger:general_ledger},
    
            xhrFields: {
                responseType: 'blob' 
            },
            success: function(data) {
                var downloadLink = document.createElement('a');
                var url = window.URL.createObjectURL(new Blob([data]));
                downloadLink.href = url;
                if(type == 'excel')
                    downloadLink.setAttribute('download', 'supplier_report.xls');

                else if(type == 'pdf')                     
                    downloadLink.setAttribute('download', 'supplier_report.pdf');
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