
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
                            Trial Balance
                        </h5>
                        <h6 class="mb" style="text-transform: uppercase">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h6>
                        <h6 class="mb">{!!@$search_type!!}</h6>
                    </div>
                </div>
            </div>

            <div class="row">
    <div class="col-md-12">
        @if(!empty($root_info))
            <div class="end export-option my-2">
                <ul class="list-group list-group-horizontal-sm">
                    <li class="list-group-item"><span onclick="downloadTrialBalance('pdf')" style="cursor:pointer"><i class="fas fa-file-pdf pdf-icon"></i></span></li>
                    <li class="list-group-item"><span onclick="downloadTrialBalance('excel')" style="cursor:pointer"><i class="fas fa-file-excel excel-icon"></i></span></li>
                </ul>
            </div>
            <table style="width: 100%;" cellspacing="0" bordering="0" id="trialBalanceDatatable">
                <thead>
                    <tr>
                        <td colspan="7" class="text-right" style="border-top:0px;border-left:0px;border-right:0px"> <b>Amount (Tk.)</b></td>
                    </tr>
                    <tr>
                        <td rowspan="2" style="font-weight: 900; padding-left:3px;text-align: center;width: 8%" >Account</td>
                        <td rowspan="2" style="font-weight: 900; padding-left:3px;text-align: center;width: 5%">Type</td>
                        <td rowspan="2" style="font-weight: 900; padding-left:3px;width: 37%">Description</td>
                        <td rowspan="2" style=" font-weight: 900; text-align: right; width: 15%">Opening</td>
                        <td rowspan="2" style="font-weight: 900; text-align:right; width: 10%">DEBIT</td>
                        <td rowspan="2" style="font-weight: 900; text-align:right;width: 10%">CREDIT</td>
                        <td rowspan="2" style=" font-weight: 900; text-align: right; width: 15%">YTD</td>
                    </tr>
                </thead>
                @php
                    $total_ob_dr_sum = 0;
                    $total_ob_cr_sum = 0;
                    $total_dr_sum = 0;
                    $total_cr_sum = 0;
                    $total_closing_dr_sum = 0;
                    $total_closing_cr_sum = 0;
                    $total_ob_bal_sum = 0;
                    $total_tr_bal_sum = 0;
                    $total_cb_bal_sum = 0;
                @endphp

                {{-- Loop directly through all accounts, excluding the 'retained_earnings_ind' as before --}}
                @forelse(collect($root_info->getData()->data)->where('retained_earnings_ind','!=',1) as $account)
                    @php
                        $last_opening_dr = floatVal($account->opening_balance_dr);
                        $last_opening_cr = floatVal($account->opening_balance_cr);
                        $last_tran_bal_dr = floatVal($account->dr);
                        $last_tran_bal_cr = floatVal($account->cr);
                        $last_closing_dr = (floatVal($account->opening_balance_dr) + floatVal($account->dr));
                        $last_closing_cr = (floatVal($account->opening_balance_cr) + floatVal($account->cr));

                        $last_ob_bal = $last_opening_dr - $last_opening_cr;
                        $last_tr_bal = $last_tran_bal_dr - $last_tran_bal_cr;
                        $last_cb_bal = $last_closing_dr - $last_closing_cr;

                        // Accumulate totals for the grand total row
                        $total_ob_dr_sum += $last_opening_dr;
                        $total_ob_cr_sum += $last_opening_cr;
                        $total_dr_sum += $last_tran_bal_dr;
                        $total_cr_sum += $last_tran_bal_cr;
                        $total_closing_dr_sum += $last_closing_dr;
                        $total_closing_cr_sum += $last_closing_cr;
                        $total_ob_bal_sum += $last_ob_bal;
                        $total_tr_bal_sum += $last_tr_bal;
                        $total_cb_bal_sum += $last_cb_bal;
                    @endphp
                    <tr>
                        <td style="text-align:center; #333; font-style:italic;">{{ucwords(strtolower($account->account_code))}}</td>
                        <td style="text-align:center; #333; font-style:italic;">{{ucwords(strtolower($account->type_name))}}</td>
                        <td style="text-align:left; #333; font-style:italic;">{{ucwords(strtolower($account->tran_head))}}</td>
                        <td style="text-align:right; #333; font-style:italic;">@if($last_ob_bal >= 0) {{number_format($last_ob_bal,2)}} @else {{"(".number_format(abs($last_ob_bal),2).")"}} @endif</td>
                        <td style="text-align:right; #333; font-style:italic;">{{number_format($account->dr,2)}}</td>
                        <td style="text-align:right; #333; font-style:italic;">{{number_format(abs($account->cr),2)}}</td>
                        <td style="text-align:right; #333; font-style:italic;">@if($last_cb_bal >= 0) {{number_format($last_cb_bal,2)}} @else {{"(".number_format(abs($last_cb_bal),2).")"}} @endif</td>
                    </tr>
                @empty
                    <tr>
                        <td colspan="7" style="text-align: center"> No Data Found</td>
                    </tr>
                @endforelse

                {{-- Retained Earnings row (if it exists) --}}
                @foreach(collect($root_info->getData()->data)->where('retained_earnings_ind',1)->take(1) as $root)
                    @php
                        $last_opening_dr = floatVal($root->opening_balance_dr);
                        $last_opening_cr = floatVal($root->opening_balance_cr);
                        $last_tran_bal_dr = floatVal($root->dr);
                        $last_tran_bal_cr = floatVal($root->cr);
                        $last_closing_dr = (floatVal($root->opening_balance_dr) + floatVal($root->dr));
                        $last_closing_cr = (floatVal($root->opening_balance_cr) + floatVal($root->cr));

                        $last_ob_bal = $last_opening_dr - $last_opening_cr;
                        $last_cb_bal = $last_closing_dr - $last_closing_cr;

                        // Add Retained Earnings to the grand total
                        $total_ob_dr_sum += $last_opening_dr;
                        $total_ob_cr_sum += $last_opening_cr;
                        $total_dr_sum += $last_tran_bal_dr;
                        $total_cr_sum += $last_tran_bal_cr;
                        $total_closing_dr_sum += $last_closing_dr;
                        $total_closing_cr_sum += $last_closing_cr;
                        $total_ob_bal_sum += $last_ob_bal;
                        $total_cb_bal_sum += $last_cb_bal;
                    @endphp
                    <tr>
                        <td style="padding-left: 30px; ">{{ucwords(strtolower($root->account_code))}}</td>
                        <td style="padding-left: 30px; color: red; background-color: rgb(255, 255, 0);">{{ucwords(strtolower($root->tran_head))}}</td>
                        <td style="text-align:right; #333; font-style:italic; color: red; background-color: rgb(255, 255, 0);">@if($last_ob_bal >= 0) {{number_format($last_ob_bal,2)}} @else {{"(".number_format(abs($last_ob_bal),2).")"}} @endif</td>
                        <td style="text-align:right; #333; font-style:italic; color: red; background-color: rgb(255, 255, 0);">{{number_format($root->dr,2)}}</td>
                        <td style="text-align:right; #333; font-style:italic; color: red; background-color: rgb(255, 255, 0);">{{number_format(abs($root->cr),2)}}</td>
                        <td style="text-align:right; #333; font-style:italic; color: red; background-color: rgb(255, 255, 0);">@if($last_cb_bal >= 0) {{number_format($last_cb_bal,2)}} @else {{"(".number_format(abs($last_cb_bal),2).")"}} @endif</td>
                        <td style="text-align:right; #333; font-style:italic; color: red; background-color: rgb(255, 255, 0);">0</td>
                    </tr>
                @endforeach

                <tr>
                    <td style="padding-left: 30px; "></td>
                    <td style="border: 1px solid #333;padding: 5px;"><span style="font-weight: bold;">Grand Total</span></td>
                    <td style="padding-left: 30px; text-align:right;">@if($total_ob_bal_sum >= 0) {{number_format($total_ob_bal_sum,2)}} @else {{'('.number_format(abs($total_ob_bal_sum),2).')'}} @endif</td>
                    <td style="padding-left: 30px; text-align:right;"><span style="font-weight: bold; font-style:italic;">{{number_format($total_dr_sum,2)}}</span></td>
                    <td style="padding-left: 30px; text-align:right;"><span style="font-weight: bold; font-style:italic;">{{number_format($total_cr_sum,2)}}</span></td>
                    <td style="padding-left: 30px; text-align:right;">@if($total_cb_bal_sum >= 0) {{number_format($total_cb_bal_sum,2)}} @else {{'('.number_format(abs($total_cb_bal_sum),2).')'}} @endif</td>
                    <td style="padding-left: 30px; ">0</td>
                </tr>
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
    $("body").addClass("sidebar-collapse");
    function downloadTrialBalance(type){
            var from_date = '<?php echo json_encode($from_date); ?>';
            var to_date = '<?php echo json_encode($to_date); ?>';
            var search_type = '<?php echo json_encode($search_type); ?>';
            from_date = JSON.parse(from_date);
            to_date = JSON.parse(to_date);
            search_type = JSON.parse(search_type);
            if(type == 'excel'){
                var url = '{{route('v3.accounts.download-trial-balance-excel')}}';
            }
            else if(type == 'pdf'){
                var url = '{{route('v3.accounts.download-trial-balance-pdf')}}';
            }
            $.ajax({
            url: url,
            method: 'post',
            data:{from_date:from_date,to_date:to_date,search_type:search_type},
    
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