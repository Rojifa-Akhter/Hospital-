
@extends('admin.layouts.master')
@push('css_custom')
<style>
    table {
        /* table-layout: fixed; */
        width: 100%; 
        }
    thead {
        position: sticky;
        top: 40px;
        left:0px;
        right:0px;
        background-color: white;
    }
    table td {
        font-size: 13px;
        border: 1px solid #333;
        padding-right:3px;
        white-space: nowrap;
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
    
</style>
@endpush

@section('content')
<div class="container-fluid">
    <div class="card">
        <div class="card-body p-2">
            <div class="row">
                <div class="col-md-12">
                    <h4 style="margin-top: 20px; text-align:center;" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>
            
                    <div class="voucher_title" style="margin-top: 20px; text-align:center;">
                        <h5 style="margin-bottom: 10px; text-transform:uppercase;">
                          Bank Report
                        </h5>
                        <h6 class="mb" style="text-transform: uppercase">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h6>
                        <h6 class="mb">{{@$ledger_details[0]->account_name}}</h6>
                    </div>
                </div>
            </div>

            <div class="row">
                <div class="col-md-12"> 
                    @if(!empty($ledger_details))
                        @if(!empty($ledger_details))
                            <div class="end export-option my-2">
                                <ul class="list-group list-group-horizontal-sm">
                                    <li class="list-group-item"><span onclick="downloadTrialBalance('pdf')" style="cursor:pointer"><i class="fas fa-file-pdf pdf-icon"></i></span></li>
                                    <li class="list-group-item"><span onclick="downloadTrialBalance('excel')" style="cursor:pointer"><i class="fas fa-file-excel excel-icon"></i></span></li>                                 
                                </ul>
                            </div> 
                        @endif
                        <table style="width: 100%;" cellspacing="0" id="trialBalanceDatatable" class="table table-bordered table-hover table-striped">
                            <thead class="bg-primary">
                                <tr>
                                    <td style="width:10%" class="text-left">Cheque No</td>
                                    <td style="width:8%" class="text-center">Cheque Date</td>
                                    <td style="width:30%">Vendor Name</td>
                                    <td style="width:15%">Dr. Amount</td>
                                    <td style="width:47%">Remarks</td>
                                </tr>
                            </thead>
                           <tbody>
                            <tr>
                                <td colspan="3" class="text-center"><b>Opening Balance</b></td>
                                <td class="text-right">@if($opening_bal >= 0) {{number_format($opening_bal,2)}} @else {{'('.number_format(abs($opening_bal),2).')'}} @endif</td>
                                <td></td>
                            </tr>
                            @forelse($ledger_details as $item)
                            <tr>
                                {{-- <td><a target="new" href="{{route('view_journal')}}?journal_id={{$item->journal_code}}">{{$item->journal_code}}</a></td>
                                <td class="text-center">@if(!empty($item->journal_date)) {{date('d/m/Y',strtotime($item->journal_date))}} @endif</td> --}}
                                <td class="text-left"> {{$item->bank_cheq_number}}</td>
                                <td class="text-center">@if(!empty($item->bank_cheq_date)) {{date('d/m/Y',strtotime($item->bank_cheq_date))}} @endif</td>
                                <td>{{$item->subledger_name}}</td>
                                <td style="text-align:right;">@if($item->dr >= 0) {{number_format($item->dr,2)}} @else {{'('.number_format(abs($item->dr),2).')'}} @endif</td>
                                <td>{{$item->voucher_remarks}}</td>
                            </tr>
                            @empty
                                <tr>
                                    <td colspan="5" class="text-center text-danger">Data not found!</td>
                                </tr>
                            @endforelse

                            <tr>
                                @php  $total_amount = collect($ledger_details)->sum('dr') + $opening_bal @endphp
                                <td colspan="3" class="text-center"><b>Total</b></td>
                                <td class="text-right">@if($total_amount >= 0) {{number_format($total_amount,2)}} @else {{'('.number_format(abs($total_amount),2).')'}} @endif</td>
                                <td></td>
                            </tr>
                           </tbody>
                        </table>
                    @endif
                </div>
            </div>

        </div>
    </div>

</div>
@endsection
@push('scripts')
<script>
    function downloadTrialBalance(type){
            var from_date = '<?php echo json_encode($from_date); ?>';
            var to_date = '<?php echo json_encode($to_date); ?>';
            var gl_code = '<?php echo json_encode($gl_code); ?>';
            from_date = JSON.parse(from_date);
            to_date = JSON.parse(to_date);
            gl_code = JSON.parse(gl_code);
            if(type == 'excel'){
                var url = '{{route('accounts.download-bank-report-excel')}}';
            }
            else if(type == 'pdf'){
                var url = '{{route('accounts.download-bank-report-pdf')}}';
            }
            $.ajax({
            url: url,
            method: 'post',
            data:{from_date:from_date,to_date:to_date,gl_code:gl_code},
    
            xhrFields: {
                responseType: 'blob' 
            },
            success: function(data) {
                var downloadLink = document.createElement('a');
                var url = window.URL.createObjectURL(new Blob([data]));
                downloadLink.href = url;
                if(type == 'excel')
                    downloadLink.setAttribute('download', 'bank_report.xls');

                else if(type == 'pdf')                     
                    downloadLink.setAttribute('download', 'bank_report.pdf');
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