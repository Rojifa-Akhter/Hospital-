<style type="text/css">

    h2,h3,h4 {
        margin:0;
    }
    .mt {
        border-collapse: collapse;
        margin-top:30px;
    }
    .mb {
        margin-top:10px;
    }
    .footer-table{
        margin-top:120px
    }
    .overline {
        position: relative;
    }
    .overline::after {
        content: '';
        position: absolute;
        top: 0;
        left: 5px;
        right:0;
        width: 95%;
        height: 1px; /* Adjust the height to control the width of the "overline" */
        background-color: black; /* Customize the color of the "overline" */
    }
    .text_align_center {
        text-align: center;
    }

    .text-left {
        text-align: left;
    }

    .text-right{
        text-align: right;
    }
    .container {
        margin: 10px 10px 10px 10px;
    }
    /* .overline{
        text-decoration: overline;
    } */
    .voucher_title{
        margin: 3px 0 0 0;
    }
    .td-border{
        border: 1px solid #333;
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
@php $currentRouteName = Route::currentRouteName(); @endphp
@if($currentRouteName == 'view_journal')
    <style>
        .header-table tr td{
            font-size: 12px;
            line-height: 12px;
        }
        .mt thead tr th{
            border: 1px solid black;
            font-size: 12px;
            padding: 1px 2px
        }
        .mt tbody tr td{
            border: 1px solid black;
            font-size: 12px;
            line-height: 11px;
            padding: 1px 2px
        }
        .footer-table{
            font-size: 12px;
        }
    </style>
@else
    <style>
        .header-table tr td{
            font-size: 10px;
            line-height: 10px;
        }
        .mt thead tr th{
            border: 1px solid black;
            font-size: 13px;
            padding: 1px 2px
        }
        .mt tbody tr td{
            border: 1px solid black;
            font-size: 13px;
            line-height: 9px;
            padding: 1px 2px
        }
        .footer-table{
            font-size: 10px;
        }
    </style>
@endif
<!-- font awesome -->
<link href="{{ asset('css/all.min.css') }}" rel='stylesheet' />
<div class="container">
    <div class="row">
        <div class="col-md-12">
            <div class="text_align_center">
            <h2>{{isset($org_info->hospital_name )? $org_info->hospital_name : ""}}</h2>
            <h3>{{ isset($org_info->addrress1) ? $org_info->addrress1 : ""}}</h3>
            {{-- <h4>{{isset($org_info->telephone1) ? $org_info->telephone1 : "" }}</h4> --}}
            <div class="voucher_title" style="margin-top: 10px;">
                <h3 style="margin-bottom: 10px;"><u>
                    @php
                        switch($voucher_type) {
                            case 'CASH RECEIPT':
                                echo "Cash Receive Voucher";
                                $voucher = 'Cash';
                                break;
                            case 'BANK RECEIPT':
                                echo "Bank Receive Voucher";
                                $voucher = 'Bank';
                                break;
                            case 'CASH PAYMENT':
                                echo "Cash Payment Voucher";
                                $voucher = 'Cash';
                                break;
                            case 'BANK PAYMENT':
                                echo "Bank Payment Voucher";
                                $voucher = 'Bank';
                                break;
                            case 'JOURNAL':
                                echo "Journal Voucher";
                                $voucher = 'Journal';
                                break;
                            default:
                                echo $voucher_type.' VOUCHER';                              
                        }
                    @endphp
                    </u>
                </h3>
                <h3>@if($voucher_contra == 1) Contra @endif</h3>
            </div>
            </div>
        </div>
    </div>
    @php 
    $amounts = array_column($voucher_details, 'trn_dr_account_amount');
    $total_debit = array_sum($amounts);
    $cr_amounts = array_column($voucher_details, 'trn_cr_account_amount');
    $total_credit = array_sum($cr_amounts);
    
    @endphp

    @if($currentRouteName == 'view_journal')
        <div class="end" style="margin-bottom: 10px">
            <a href="{{route('journal')}}?journal_id={{$voucher_no}}" style="padding-right:10px"><i class="fas fa-file-pdf pdf-icon"></i></a>
            <a href="{{route('journal_excel')}}?journal_id={{$voucher_no}}"><i class="fas fa-file-excel excel-icon"></i></a>

        </div> 
    @endif
    <div class="row mb">
        <table style="width: 100%;border-collapse: collapse" class="header-table">
            <tr>
                <td class="text-left" style="padding: 0px;margin:0px"><strong>Posting ID</strong></td>
                <td class="text-left" style="padding: 0px;margin:0px">{{$voucher_no}}</td>
                <td class="text-left" style="padding: 0px;margin:0px"><strong>Total Dr</strong></td>
                <td class="text-left" style="padding: 0px;margin:0px">{{number_format($total_debit,2)}}</strong></td>
            </tr>
            <tr>
                <td class="text-left" style="padding: 0px;margin:0px"><strong>Document Date</strong></td>
                <td class="text-left" style="padding: 0px;margin:0px">{{date("d/m/Y", strtotime($doc_date))}}</td>
                <td class="text-left" style="padding: 0px;margin:0px"><strong>Total Cr</strong></td>
                <td class="text-left" style="padding: 0px;margin:0px">{{number_format($total_credit,2)}}</td>
            </tr>
            <tr>
                <td class="text-left" style="padding: 0px;margin:0px"><strong>Posting Date</strong></td>
                <td class="text-left" style="padding: 0px;margin:0px">{{date("d/m/Y", strtotime($journal_date))}}</td>
            </tr>
            @if(is_array($voucher_details))

                @if($voucher_details[0]->file_path1 != '')
                <tr>
                    <td class="text-left" style="padding: 0px;margin:0px"><strong>Attachment 1</strong></td>
                    <td class="text-left" style="padding: 0px;margin:0px"><a href="{{asset('uploads/journal_post_documents/')}}/{{$voucher_details[0]->file_path1}}" download>{{$voucher_details[0]->file_path1}}</a></td>
                </tr>
                @endif
                @if($voucher_details[0]->file_path2 != '')
                <tr>
                    <td class="text-left" style="padding: 0px;margin:0px"><strong>Attachment 2</strong></td>
                    <td class="text-left" style="padding: 0px;margin:0px"><a href="{{asset('uploads/journal_post_documents/')}}/{{$voucher_details[0]->file_path2}}" download>{{$voucher_details[0]->file_path2}}</a></td>
                </tr>
                @endif
                @if($voucher_details[0]->file_path3 != '')
                <tr>
                    <td class="text-left" style="padding: 0px;margin:0px"><strong>Attachment 3</strong></td>
                    <td class="text-left" style="padding: 0px;margin:0px"><a href="{{asset('uploads/journal_post_documents/')}}/{{$voucher_details[0]->file_path3}}" download>{{$voucher_details[0]->file_path3}}</a></td>
                </tr>
                @endif
            @endif
            

            <tr>
                <td class="text-left" style="padding: 0px;margin:0px"><strong>In Word</strong></td>
                @php
                    $numtoword = new NumberToWords\NumberToWords();
                    $numtowordtrans = $numtoword->getNumberTransformer('en');
                    $amounts = array_column($voucher_details, 'trn_dr_account_amount');
                    $total_debit = array_sum($amounts);
                    $text_total = $numtowordtrans->toWords($total_debit);
                @endphp
                <td class="text-left" style="padding: 0px;margin:0px">{{Str::ucfirst($text_total)}}</td>   
            </tr>
        </table>
    </div>

    <div class="row">
        <div class="col-md-12">
            <table style="width:100%" class="mt" cellspacing="0">
                <thead>
                    <tr>
                        <th class="text-left" style="width:20%">GL Code</th>
                        <th class="text-left" style="width:9%">Sub Ledger Type</th>
                        <th class="text-left" style="width:6%">Sub Ledger</th>
                        <th class="text-left" style="width:5%">Dr/Cr</th>
                        <th class="text-left" style="width:4%">Curr.</th>
                        <th class="text-left" style="width:8%">Amount in Doc Curr.</th>
                        <th class="text-left" style="width:8%">Amount in Loc. Curr.</th>
                        <th class="text-left" style="width:5%">Cost Center</th>
                        <th class="text-left" style="width:25%">Narration</th>
                        <th class="text-left" style="width:5%">Cheq. Date</th>
                        <th class="text-left" style="width:5%">Cheq. No</th>
                    </tr>
                </thead>
                {{-- @dd($voucher_details); --}}
                <tbody>
                    @foreach($voucher_details as $voucher)
                            <tr>
                                <td class="text-left">{{$voucher->trn_account_code}}-{{ucwords(strtolower($voucher->account_name))}}</td>
                                <td class="text-left">{{$voucher->subledgertype_name}}</td>
                                <td class="text-left">{{$voucher->subledger_name}}</td>
                                <td class="text-left">{{$voucher->trn_dr_account_amount > 0 ? 'Debit' : 'Credit'}}</td>
                                <td class="text-left">BDT</td>
                                <td class="text-right">{{number_format($voucher->trn_dr_account_amount > 0 ? $voucher->trn_dr_account_amount : $voucher->trn_cr_account_amount,2)}}</td>
                                <td class="text-right">{{number_format($voucher->trn_dr_account_amount > 0 ? $voucher->trn_dr_account_amount : $voucher->trn_cr_account_amount,2)}}</td>
                                <td class="text-left">{{$voucher->costcenter_name}}</td>
                                <td class="text-left">{{$voucher->narration_text}} </td>
                                <td class="text-left">
                                    @if(!empty($voucher->bank_cheq_date) )
                                    {{date("d/m/Y",strtotime($voucher->bank_cheq_date))}}
                                    @endif
                                </td>
                                <td class="text-left">
                                    @if(!empty($voucher->bank_cheq_number))
                                    {{$voucher->bank_cheq_number}}
                                    @endif
                                </td>
                            </tr>

                    @endforeach
                    
                </tbody>
            </table>

            <!-- Footer -->
            <table style="width:100%" class="footer-table">
                <tr>
                    <td class="text_align_center ">{{is_array($voucher_details) ? $voucher_details[0]->prepare_by : ''}}</td>
                    <td class="text_align_center ">{{is_array($voucher_details) ? $voucher_details[0]->verified_by : ''}}</td>
                    <td class="text_align_center ">{{is_array($voucher_details) ? $voucher_details[0]->finalized_by: ''}}</td>
                </tr>
                <tr>
                    <td class="text_align_center overline"><strong>Prepared By</strong></td>
                    <td class="text_align_center overline"><strong>Reviewed By</strong></td>
                    <td class="text_align_center overline"><strong>Approved By</strong></td>
                </tr>
            </table>
            <!-- Close Footer -->
        </div>
    </div>

</div>