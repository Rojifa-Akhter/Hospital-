
@extends('admin.layouts.master')
@push('css_custom')
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .journalReport table td {
        font-size: 12px !important;
        border: 1px solid #e9e8eb !important;
        white-space: nowrap; 
        padding: 2px 4px !important;
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
    .journalReport{
        overflow-x:auto;
    }  
    .journalReport table>thead>tr{
        background-color: #98a2b3 !important;
        color:white;
    }  
    .journalReport table>thead>tr>td{
        padding-right:20px !important;
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

</style>
@endpush
@php
      $hospital_code = DB::table('WSEC_HOSPITAL')->first()->hospital_code;
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
                           Voucher Report
                        </h5>
                        <h6 class="mb" style="text-transform: uppercase">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h6>     
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12">
                    @if(!empty($root_info))
                        @if(!empty($root_info))
                            <div class="end export-option my-2">
                                <ul class="list-group list-group-horizontal-sm">
                                    <li class="list-group-item"><span onclick="downloadJournalReport('excel')" style="cursor:pointer"><i class="fas fa-file-excel excel-icon"></i></span></li>                                 
                                </ul>
                            </div> 
                        @endif

                        <table class="top-table">
                            <tr>
                                <td><strong>Total Dr</strong></td>
                                <td colspan="13" style="text-align:left">{{number_format(collect($root_info->getData()->data)->sum('trn_dr_account_amount'),2)}}</td>                               
                            </tr>
                            <tr>
                                <td><strong>Total Cr</strong></td>
                                <td colspan="13" style="text-align:left">{{number_format(collect($root_info->getData()->data)->sum('trn_cr_account_amount'),2)}}</td>                               
                            </tr>
                            <tr>
                                <td><strong>In Word</strong></td>
                                @php 
                                    $numtoword = new NumberToWords\NumberToWords();
                                    $numtowordtrans = $numtoword->getNumberTransformer('en');
                                    $total_debit = collect($root_info->getData()->data)->sum('trn_dr_account_amount');
                                    $text_total = $numtowordtrans->toWords($total_debit);                               
                                @endphp
                                <td colspan="13" style="text-align:left">{{ucwords(strtolower($text_total))}}</td>                               
                            </tr>
                        </table>
                        <div class="journalReport">
                            <table cellspacing="0" class="journalReport" id="journalReportDatatable">
                                <thead>
                                    <tr>
                                        <td>Voucher No</td>
                                        <td>GL Code</td>
                                        <td>Sub Ledger </td>
                                        <td>Dr./Cr.</td>
                                        <td>Curr</td>
                                        <td>Amount in Doc. Curr.</td>
                                        <td>Amount in Loc. Curr.</td>
                                        <td>Company</td>
                                        <td>Document Date</td>
                                        <td>Posting Date</td>
                                        <td>Cost Center</td>
                                        <td>Narration</td>
                                        <td>Cheq. Date</td>
                                        <td>Cheq. No</td>
                                    </tr>
                                </thead>

                                @forelse(collect($root_info->getData()->data) as $voucher)
                                <tr>
                                    <td>
                                        @if($hospital_code == 'EWMCH')
                                            <a href="{{ route('account.payment-voucher-report-show', ['voucher_id' => $voucher->journal_code]) }}" target="_blank">{{$voucher->journal_code}}</a>
                                        @else
                                            <a href="{{route('journal_show')}}?journal_id={{$voucher->journal_code}}" target="_blank">{{$voucher->journal_code}}</a>
                                        @endif
                                    </td>
                                    <td>{{$voucher->trn_account_code}}-{{ucwords(strtolower($voucher->account_name))}}</td>
                                    <td>{{$voucher->subledger_name}}</td>
                                    <td>{{$voucher->trn_dr_account_amount > 0 ? 'Debit' : 'Credit'}}</td>                                     
                                    <td>BDT</td>
                                    <td class="text-right"> {{number_format($voucher->trn_dr_account_amount > 0 ? $voucher->trn_dr_account_amount : $voucher->trn_cr_account_amount,2)}}</td>
                                    <td class="text-right"> {{number_format($voucher->trn_dr_account_amount > 0 ? $voucher->trn_dr_account_amount : $voucher->trn_cr_account_amount,2)}}</td>
                                    <td>{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</td>
                                    
                                    <td>{{date('d/m/Y',strtotime($voucher->doc_date))}}</td>
                                    <td>{{date('d/m/Y',strtotime($voucher->journal_date))}}</td>

                                    <td>{{$voucher->costcenter_name}}</td>
                                    <td>{{$voucher->narration_text}}</td>
                                    <td>
                                        @if(!empty($voucher->bank_cheq_date))
                                        {{date("d/m/Y",strtotime($voucher->bank_cheq_date))}}
                                        @endif
                                    </td>
                                    <td>
                                        @if(!empty($voucher->bank_cheq_number))
                                            {{$voucher->bank_cheq_number}}
                                        @endif
                                    </td>                               
                                </tr>                               
                                @empty
                                <tr>
                                    <td colspan="14" style="text-align: center"> No Data Found</td>
                                </tr>
                                @endforelse
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
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $(document).ready(function(){
        $('#journalReportDatatable').DataTable({
            paging: false,
            searching: true,
        });
    })
    function downloadJournalReport(type){
            var from_date = '<?php echo json_encode($from_date); ?>';
            var to_date = '<?php echo json_encode($to_date); ?>';
            var journal_code = '<?php echo json_encode($journal_code); ?>';
            from_date = JSON.parse(from_date);
            to_date = JSON.parse(to_date);
            journal_code = JSON.parse(journal_code);
            var url = '{{route('v1.accounts.download-journal-report-excel')}}';
            $.ajax({
            url: url,
            method: 'post',
            data:{from_date:from_date,to_date:to_date,journal_code:journal_code},
            xhrFields: {
                responseType: 'blob' 
            },
            success: function(data) {
                var downloadLink = document.createElement('a');
                var url = window.URL.createObjectURL(new Blob([data]));
                downloadLink.href = url;
                downloadLink.setAttribute('download', 'journal_report.xls');
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
                window.URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                console.log('AJAX request error:', error);
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error);
            }
            });
        }
</script>
@endpush