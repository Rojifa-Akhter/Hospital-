
@extends('admin.layouts.master')
@push('css_custom')
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
        color: red
    }
    .excel-icon{
        font-size: 22px;
        color:green
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
                        <h5 style="margin-top: 10px; text-align:center; margin-bottom:0px" >Sub Ledger Report</h5>            
                        <div style="text-align:center;">
                            <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; margin-bottom:0px">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h6>
                            <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; font-size:12px"><span style="font-style:italic;"><b></b>
                                @if($route == 'v1.accounts.subledger-report-by-id-date')
                                   <b>Sub Ledger: </b> {{$leder_of_code}} - {{$leder_of}}
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

                <div class="row">
                    <div class="col-md-12">
                        <div style="overflow-x: auto">
                            <table class="table" style="width: 100%;" cellspacing="0">
                                <thead>
                                    <tr style="background-color: #003B61;color:white">                                       
                                        <th style="text-align:left; padding:3px; font-weight:bold;white-space:nowrap">Transaction Date</th>
                                        <th style="text-align:left; padding:3px; font-weight:bold;white-space:nowrap" >Particulars</th>
                                        <th style="text-align:center; padding:3px; font-weight:bold;white-space:nowrap" >Ref ID</th>
                                        <th style="text-align:left; padding:3px; font-weight:bold;white-space:nowrap" >Journal Type</th>                                                                       
                                        <th style="text-align:left; padding:3px; font-weight:bold;">Debit</th>
                                        <th style="ext-align:left; padding:3px; font-weight:bold;">Credit</th>
                                        <th style="ext-align:left; padding:3px; font-weight:bold;">Balance</th>
                                        <th style="ext-align:left; padding:3px; font-weight:bold;white-space:nowrap">Cr. or Dr. B/L</th>
                                        <th style="ext-align:left; padding:3px; font-weight:bold;">Naration</th>
                                        <th style="ext-align:left; padding:3px; font-weight:bold;">Company</th>
                                        <th style="ext-align:left; padding:3px; font-weight:bold;white-space:nowrap">PO No</th>
                                        <th style="ext-align:left; padding:3px; font-weight:bold;white-space:nowrap">GRN No</th>
                                        <th style="ext-align:left; padding:3px; font-weight:bold;">Note</th>
                                        <th style="ext-align:left; padding:3px; font-weight:bold;white-space:nowrap">Entry By</th>
                                        <th style="ext-align:left; padding:3px; font-weight:bold;white-space:nowrap">Posting Date</th>
                                        <th style="ext-align:left; padding:3px; font-weight:bold;white-space:nowrap">Cheque Date</th>
                                        <th style="ext-align:left; padding:3px; font-weight:bold;white-space:nowrap">Cheque No</th>
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
                                            
                                            <td style="text-align: left; padding-bottom: 3px;white-space:nowrap">{{date("d/m/Y",strtotime($root->doc_date))}}</td>
                                            <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap">@if(!empty($subledger_id)){{ $root->account_name}} @else {{$root->subledger_name}} @endif</td>
                                            <td style="text-align: left; padding-bottom: 3px;white-space:nowrap"><a target="new" href="{{route('view_journal')}}?journal_id={{$root->journal_code}}">{{$root->journal_code}}</a></td>
                                            <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap"> {{ucwords(strtolower($root->voucher_type_name))}}</td>
                                            <td style="text-align: right; padding-bottom: 3px; font-style:italic;">{{number_format($root->dr,2)}}</td>
                                            <td style="text-align: right; padding-bottom: 3px; font-style:italic;">{{number_format($root->cr,2)}}</td>
                                            <td style="text-align: right; padding-bottom: 3px; font-style:italic;">@if($balance >= 0) {{number_format($balance,2)}} @else {{ '('.number_format(abs($balance),2).')'}} @endif</td>
                                            <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap">@if($root->dr > 0) {{'Debit'}} @else {{'Credit'}} @endif</td>
                                            <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap">{{$root->narration_text}}</td>
                                            <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap">{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</td>
                                            <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap"></td>
                                            <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap"></td>
                                            <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap">{{$root->voucher_remarks}}</td>
                                            <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap">{{$root->prepare_by}}</td>
                                            <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap">{{date("d/m/Y",strtotime($root->journal_date))}}</td>
                                            <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap">{{$root->bank_cheq_number}}</td>
                                            <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap">@if(! empty($root->bank_cheq_date)){{ date('m/d/Y', strtotime($root->bank_cheq_date))}} @endif</td>
                                            
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
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
<script>
    function downloadSubLedgerLedger(type){
            var from_date = '<?php echo json_encode($from_date); ?>';
            var to_date = '<?php echo json_encode($to_date); ?>';
            var subledger_type = '<?php echo json_encode($subledger_type); ?>';
            var general_ledger = '<?php echo json_encode($gl_code); ?>';
            var subledger_id = '<?php echo json_encode($subledger_id); ?>';
            from_date = JSON.parse(from_date);
            to_date = JSON.parse(to_date);
            subledger_type = JSON.parse(subledger_type);
            general_ledger = JSON.parse(general_ledger);
            subledger_id = JSON.parse(subledger_id);
            if(type == 'excel'){
                var url = '{{route('v1.accounts.subledger-report-excel')}}';
            }
            else if(type == 'pdf'){
                var url = '{{route('v1.accounts.subledger-report-pdf')}}';
            }
            $.ajax({
            url: url,
            method: 'post',
            data:{from_date:from_date,to_date:to_date,subledger_type:subledger_type,general_ledger:general_ledger,subledger_id:subledger_id},
    
            xhrFields: {
                responseType: 'blob' 
            },
            success: function(data) {
                var downloadLink = document.createElement('a');
                var url = window.URL.createObjectURL(new Blob([data]));
                downloadLink.href = url;
                if(type == 'excel')
                    downloadLink.setAttribute('download', 'subledger_report.xls');

                else if(type == 'pdf')                     
                    downloadLink.setAttribute('download', 'subledger_report.pdf');
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