
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
    .error{
        color:red;
        font-size: 12px
    }
  
</style>
@endpush

@section('content')
<main id="page-content">
    <div class="container-fluid">
        <div class="card">
            <div class="card-body p-2">
                <div class="row">
                    <div class="col-md-12">
                        <h4 style="margin-top: 20px; text-align:center; margin-bottom:0px" >{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h4>            
                        <div style="text-align:center;">
                            <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; margin-bottom:0px">From Date: {{date("d/m/Y",strtotime(@$from_date))}}, To Date: {{date("d/m/Y",strtotime(@$to_date))}}</h6>
                            <h6 class="mb" style="text-transform: uppercase;margin-top: 8px; font-size:12px"><b>GL</b>: <span style="font-style:italic;">{{$leder_of_code}}-{{$leder_of}}</span></h6>
                        </div>
                    </div>
                </div>
                @if(!empty($self_ledger))
                    <div class="row mt-4">
                        <div class="col-md-2">  
                        </div>
                        <div class="col-md-8">
                            <form action="#" id="ledgerDetails" class="ledgerDetails" method="post">
                                <div class="row justify-content-center">
                                    <div class="col-3">
                                        <input type="text" class="form-control form_date_picker" name="from_date" id="from_date" value="{{$f_date}}" required>
                                    </div>
                                    <div class="col-3">                               
                                        <input type="text" class="form-control to_date_picker" name="to_date" id="to_date" value="{{$t_date}}" required>                                                                           
                                    </div>
                                    
                                    <div class="col-2">
                                        <button type="button" class="btn btn-md btn-success" onclick="searchLedgerDetails()">Search</button>
                                    </div>
                                </div>
                            </form>
                        </div>
                        
                        <div class="col-md-2">                                                                           
                            <div class="end">
                                <a href="{{ route('v1.accounts.show-ledger-statement-pdf', ['hid_acc_code' => $leder_of_code, 'from_date' => $from_date, 'to_date' => $to_date]) }}" style="padding-right: 10px" class="summary-details-v1-pdf"><i class="fas fa-file-pdf pdf-icon"></i></a>
                                <a href="{{ route('v1.accounts.show-ledger-statement-excel', ['hid_acc_code' => $leder_of_code, 'from_date' => $from_date, 'to_date' => $to_date]) }}" class="summary-details-v1-excel"><i class="fas fa-file-excel excel-icon"></i></a>
                            </div>                            
                        </div>
                    </div>
                @endif

                <div class="row">
                    <div class="col-md-12">
                        <ul class="nav nav-tabs" id="myTab" role="tablist">
                            <li class="nav-item">
                                <a class="nav-link active" id="gl-details-report-tab-v1" data-toggle="tab"
                                    href="#gl-reports-tab" role="tab" aria-controls="gl-reports-tab"
                                    aria-selected="true" onclick="changeUrl('details')">Details Report</a>
                            </li>
    
                            <li class="nav-item">
                                <a class="nav-link" id="gl-summary-report-tab-v1" data-toggle="tab" href="#gl-summary-report"
                                    role="tab" aria-controls="gl-summary-report" aria-selected="true" onclick="changeUrl('summary')">Summary Report</a>
                            </li>   
                        </ul>

                        <!-- tabs -->
                        <div class="tab-content p-0" id="myTabContent">
                        
                            <div class="tab-pane fade show active" id="gl-reports-tab" role="tabpanel" aria-labelledby="gl-details-report-tab-v1">
                                <div style="overflow-x: auto">
                                    <table class="table" style="width: 100%;" cellspacing="0">
                                        <thead>
                                            <tr style="background-color: #003B61;color:white">                                       
                                                <th style="text-align:left; padding:3px; font-weight:bold;" >Date</th>
                                                <th style="text-align:center; padding:3px; font-weight:bold;white-space:nowrap" >Journal Id</th>
                                                <th style="text-align:left; padding:3px; font-weight:bold;white-space:nowrap" >Journal Type</th>
                                                <th style="text-align:left; padding:3px; font-weight:bold;white-space:nowrap" >Particulars</th>                                       
                                                <th style="text-align:left; padding:3px; font-weight:bold;white-space:nowrap" >Sub Ledger Name</th>
                                                <th style="text-align:left; padding:3px; font-weight:bold;">Debit</th>
                                                <th style="ext-align:left; padding:3px; font-weight:bold;">Credit</th>
                                                <th style="ext-align:left; padding:3px; font-weight:bold;">Balance</th>
                                                <th style="ext-align:left; padding:3px; font-weight:bold;">Naration</th>
                                                <th style="ext-align:left; padding:3px; font-weight:bold;">Note</th>
                                                <th style="ext-align:left; padding:3px; font-weight:bold;white-space:nowrap">Entry By</th>
                                            </tr>
                                        </thead>
                                    
                                        <tbody>
        
                                            @php
                                                $balance = 0;
                                                $total_dr = 0;
                                                $total_cr = 0;
                                            @endphp
                                
                                            <tr>
                                                <td style="padding-left: 30px; padding-top:3px;padding-bottom: 3px; font-weight:bold;text-align:center;background-color:#003aff42" colspan="7">Opeing Balance</td>
                                                <td style="text-align: right; padding-top:3px;padding-bottom: 3px; font-style:italic;">@if($self_ledger->getData()->opening_bal[0]->opening_bal >= 0) {{number_format($self_ledger->getData()->opening_bal[0]->opening_bal,2)}} @else {{"(".number_format(abs($self_ledger->getData()->opening_bal[0]->opening_bal),2).")"}} @endif</td>
                                                <td colspan="3"></td>
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
                                                    
                                                    <td style="text-align: left; padding-bottom: 3px;white-space:nowrap">{{date("d/m/Y",strtotime($root->journal_date))}}</td>
                                                    <td style="text-align: left; padding-bottom: 3px;white-space:nowrap"><a target="new" href="{{route('view_journal')}}?journal_id={{$root->journal_code}}">{{$root->journal_code}}</a></td>
                                                    <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap">{{ucwords(strtolower($root->voucher_type_name))}}</td>
                                                    <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap">{{$root->opposite_head}}</td>                                     
                                                    <td style="text-align: left; padding-bottom: 3px; font-style:italic;white-space:nowrap"><a target="new" href="{{route('v1.accounts.subledger-report-by-id-date-individual')}}?journal_code={{$root->journal_code}}&hid_acc_code={{$leder_of_code}}&subledger_id={{$root->acct_subledger_no_fk}}&from_date={{@$from_date}}&&to_date={{@$to_date}}">{{$root->sub_ledger_opposite_head}}</a></td>
                                                    <td style="text-align: right; padding-bottom: 3px; font-style:italic;">{{number_format($root->dr,2)}}</td>
                                                    <td style="text-align: right; padding-bottom: 3px; font-style:italic;">{{number_format($root->cr,2)}}</td>
                                                    <td style="text-align: right; padding-bottom: 3px; font-style:italic;">@if($balance >= 0) {{number_format($balance,2)}} @else {{ '('.number_format(abs($balance),2).')'}} @endif</td>
                                                    <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap">{{$root->narration_text}}</td>
                                                    <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap">{{$root->voucher_remarks}}</td>
                                                    <td style="padding-left: 3px; padding-bottom: 3px;white-space:nowrap">{{$root->prepare_by}}</td>
                                                    
                                                </tr>
                                                @empty
                                                <tr>
                                                    <td colspan="11" class="text-center">No Data Found</td>
                                                </tr> 
                                            @endforelse
        
                                            <tr>
                                                <td style="font-weight: bold; padding:3px;" colspan="5">Total</td>
                                                <td style="padding:3px;text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">{{number_format($total_dr,2)}}</span></td>
                                                <td style="padding:3px; text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">{{number_format($total_cr,2)}}</span></td>
                                                <td style="padding:3px; text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">@if($balance >= 0) {{number_format($balance,2)}} @else {{ '('.number_format(abs($balance),2).')'}} @endif</span></td>
                                                <td colspan="3" style="border-bottom:0px;border-right:0px"></td>
                                            </tr>                                                                                                                                                         
                                        </tbody>
                                    </table>
                                </div>
                            </div>

                            <div class="tab-pane fade" id="gl-summary-report" role="tabpanel" aria-labelledby="gl-summary-report-tab-v1">
                                <table class="table" style="width: 100%;" cellspacing="0">
                                    <thead>
                                        <tr style="background-color: #003B61;color:white">                                       
                                            <th style="text-align:left; padding:3px; font-weight:bold;width:50%">Sub Ledger Name</th>
                                            <th style="text-align:left; padding:3px; font-weight:bold;width:15%" >Opening BL</th>
                                            <th style="text-align:left; padding:3px; font-weight:bold;width:10%" >Debit</th>
                                            <th style="text-align:left; padding:3px; font-weight:bold;width:10%" >Credit</th>                                       
                                            <th style="text-align:left; padding:3px; font-weight:bold;width:15%" >Closing BL</th>
                                        </tr>
                                    </thead>
                                
                                    <tbody>
    
                                        @php
                                            $balance = 0;
                                            $total_dr = 0;
                                            $total_cr = 0;
                                            $final_opening_balance = 0;
                                            $final_closing_balance = 0;
                                        @endphp
                              
                                        @forelse($self_ledger_summary->getData()->ledger_details as $root)
                                            @php
                                                $balance += ($root->dr-$root->cr);
                                                $total_dr += $root->dr;
                                                $total_cr += $root->cr;
                                                $local_closing = (($root->opening_bal + $root->dr) - $root->cr);

                                                $final_opening_balance += $root->opening_bal;
                                                $final_closing_balance += $local_closing;
                                            @endphp
                                            <tr>                                               
                                                <td style="text-align: left;  padding-bottom: 3px;white-space:nowrap"><a target="new" href="{{route('v1.accounts.subledger-report-by-id-date')}}?hid_acc_code={{$leder_of_code}}&subledger_id={{$root->acct_subledger_no_fk}}&from_date={{@$from_date}}&&to_date={{@$to_date}}">{{$root->subledger_name}}</a></td>
                                                <td style="text-align: right; padding-bottom: 3px;">@if($root->opening_bal >= 0) {{number_format($root->opening_bal,2)}} @else {{'('.number_format(abs($root->opening_bal),2).')'}} @endif</td>
                                                <td style="text-align: right; padding-left: 3px; padding-bottom: 3px;">@if($root->dr >= 0){{ number_format($root->dr,2) }} @else {{ '0.00'}} @endif</td>
                                                <td style="text-align: right; padding-left: 3px; padding-bottom: 3px;">@if($root->cr >= 0){{ number_format($root->cr,2) }} @else {{ '0.00'}} @endif</td>  
                                                <td style="text-align: right; padding-bottom: 3px; font-style:italic;">@if($local_closing >= 0) {{number_format($local_closing,2)}} @else {{'('.number_format(abs($local_closing),2).')'}} @endif</td>                                               
                                            </tr>
                                            @empty
                                            <tr>
                                                <td colspan="5" class="text-center">No Data Found</td>
                                            </tr> 
                                        @endforelse
    
                                        <tr>
                                            <td style="font-weight: bold; padding:3px;" >Total</td>
                                            <td style="padding:3px;text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">@if($final_opening_balance >= 0) {{number_format($final_opening_balance,2)}} @else {{ '('.number_format(abs($final_opening_balance),2).')'}} @endif</span></td>
                                            <td style="padding:3px;text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">{{number_format($total_dr,2)}}</span></td>
                                            <td style="padding:3px; text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">{{number_format($total_cr,2)}}</span></td>
                                            <td style="padding:3px; text-align:right;padding-right:3px"> <span style="font-weight: bold; font-style:italic;">@if($final_closing_balance >= 0) {{number_format($final_closing_balance,2)}} @else {{ '('.number_format(abs($final_closing_balance),2).')'}} @endif</span></td>                   
                                        </tr>                                                                                                                                                         
                                    </tbody>
                                </table>
                            </div>

                        </div> 
                        <!-- close tabs -->


                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection
@push('scripts')
    <script>
        $(document).ready(function() {
            $("#ledgerDetails").validate({
                rules:{
                    from_date:{
                        required:true,
                    },
                    to_date:{
                        required:true,
                    },

                },
                messages:{
                    from_date:{
                        required:'From Date Required'
                    },
                    to_date:{
                        required: 'To Date Required'
                    }      
                }
            })
        })
    </script>

    <script>
        function searchLedgerDetails(){
            var hid_acc_code = '<?php echo $leder_of_code ?>'
            var acc_pk     = '<?php echo $acc_pk ?>';
            var from_dates = $('#from_date').val();
            var parts = from_dates.split('/');
            var formattedFromDate = parts[2] + '-' + parts[1] + '-' + parts[0];
            var to_dates = $('#to_date').val();
            var parts = to_dates.split('/');
            var formattedToDate = parts[2] + '-' + parts[1] + '-' + parts[0];

            if($('#ledgerDetails').valid()){ 
                window.open("{{ route('v1.accounts.show-ledger-statement') }}?acc_pk="+acc_pk+"&hid_acc_code="+hid_acc_code+"&from_date="+formattedFromDate+"&to_date="+formattedToDate, "_blank");
             }
        }
    </script>

    <script>
        $('.form_date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd/mm/yyyy',
            changeMonth: true,
            changeYear: true,
        })

        $('.to_date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            format: 'dd/mm/yyyy',
            changeMonth: true,
            changeYear: true,
        })
    </script>

    <script>
        function changeUrl(type){
            if(type == 'details'){
                var details_pdf = '{!!route('v1.accounts.show-ledger-statement-pdf',['hid_acc_code'=>$leder_of_code,'from_date'=>$from_date,'to_date'=>$to_date])!!}';
                var details_excel = '{!! route('v1.accounts.show-ledger-statement-excel', ['hid_acc_code'=>$leder_of_code,'from_date'=>$from_date,'to_date'=>$to_date]) !!}';
                $('.summary-details-v1-pdf').attr('href',details_pdf);
                $('.summary-details-v1-excel').attr('href',details_excel);
            }
            else if(type == 'summary'){
                var summary_pdf = '{!! route('v1.accounts.show-ledger-statement-summary-pdf', ['hid_acc_code'=>$leder_of_code,'from_date'=> $from_date,'to_date'=>$to_date]) !!}';
                var summary_excel = '{!! route('v1.accounts.show-ledger-statement-summary-excel', ['hid_acc_code'=>$leder_of_code,'from_date'=>$from_date,'to_date'=>$to_date]) !!}';
                $('.summary-details-v1-pdf').attr('href',summary_pdf);
                $('.summary-details-v1-excel').attr('href',summary_excel);
            }          
        }
    </script>

@endpush