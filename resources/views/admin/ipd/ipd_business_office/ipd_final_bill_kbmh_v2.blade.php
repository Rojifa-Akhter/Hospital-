

<style>
    table tr {
        border-bottom: none;
    }
    .nested-table {
        border-collapse: collapse
    }
    .nested-table>tbody>tr>td {
        border: none;
        text-align: left;
    }
    footer {
        position: fixed;
        z-index: 999999999;
        left: 0;
        right: 0;
        height: 2cm;
        text-align: center;
        font-size: 9px;
        bottom: -80px;
        border-top: 1px solid black;
        padding-top: 5px;
       
    }
    body {
        margin-left: 0cm;
        margin-right: 0cm;
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-size: 9px;
        margin-top: 5.5cm;
    }
    table {
        border-collapse: collapse;
        width: 100%;
    }
    table tr td,
    table tr th {
        font-size: 10px;
        border: 0;
        padding: 2px;
    }
    .border-0 {
        border: 0px;
    }
    .text-center {
        text-align: center !important;
    }
    .text-left {
        text-align: left !important;
    }
    .text-right {
        text-align: right !important;
    }
    .align-items-center {
        align-items: center;
    }
    .border-bottom {
        border-bottom: 1px solid #333;
    }
    .signature {
        width: 100%;
        height: 30px;
        margin-top: 20px;
        margin-bottom: 10px;
    }

    .table-bordered td,
    .table-bordered th {
        border-bottom: 1px dotted #333;
    }
    .pb-2 {
        padding-bottom: 2px;
    }
    .mb-10 {
        margin-bottom: 5px;
    }
    .mt-10{
        margin-top: 10px;
    }
    .mb-0 {
        margin-bottom: 0px;
    }
    .mt-0 {
        margin-top: 0px
    }

    @page{
        margin-top:5px;
    }
      #hospitalInfo{
         position: fixed;
            left: 0;
            right: 0;          
            font-size: 9px;
            padding-top: 10px;
            z-index: 999999999;
            
            
    }
    @if (Session::get('user.ses_hospital_code') == "KPJ")
        #patInfo {
            position: fixed;
            left: 0;
            right: 0;
            font-size: 9px;
            padding-top: 10px;
            z-index: 999999999;
            margin-top: 60px;
        }
    @else
        #patInfo {
            position: fixed;
            left: 0;
            right: 0;
            font-size: 9px;
            padding-top: 10px;
            z-index: 999999999;
            margin-top: 50px;
        }
    @endif
  
</style>





@php
$imagePath = isset($po_hospital_details->logo)
        ? 'images/uploads/hospital_images/' . $po_hospital_details->logo
        : 'images/kbmh.jpg';
@endphp
<table class="border-bottom" style="width:100%" id="hospitalInfo">
    <tr>
        <td style="width:15%">
            @if(!empty($po_hospital_details->logo))
			 <img src="{{ $imagePath }}" width="80px" />
                          @endif
        </td>
        <td style="width:85%; text-align:center;padding-right:100px;">
            <h1 class="mb-0 mt-0">{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h1>
            <p class="mb-0 mt-0">{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</p>
            <p class="mb-0 mt-0">{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</p>
        </td>
    </tr>
</table>

<table style="border: 1px dotted #dee2e6;  padding:5px;" id="patInfo">
    <tbody>
        <tr>
           
            <td style="width:68%">
                <ul style="list-style: none; padding-left: 0; display:inline-block;">
                    <li><b>Admission ID:</b>&nbsp;<span>{{ isset($admission_info->admission_no_pk) ? $admission_info->admission_no_pk : '' }}</span></li>
                    <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} "></li>
                    <li><span><b>Name:</b>{{ isset($paitent_info->patient_name) ? $paitent_info->patient_name : '' }}</span>
                        &nbsp;<span><b>Age:</b>{{ isset($paitent_info->age) ? $paitent_info->age : '' }}</span>
                        &nbsp;<b>Gender:</b><span>{{ isset($paitent_info->gender_txt) ? $paitent_info->gender_txt : '' }}</span>
                        &nbsp;<b>Bed Category:</b>&nbsp;<span>{{ isset($admission_info->new_ward_name) ? $admission_info->new_ward_name : '' }}</span>
                      
                    </li>
                    <li> <b>Bed No:</b>&nbsp;<span>{{ isset($admission_info->new_bed_name) ? $admission_info->new_bed_name : '' }}</span></li>
                    <li><b>Contact Number :</b>&nbsp;<span>{{ $paitent_info->mobile1 }}</span></li>
                    <li><b>Doctor Name:</b>&nbsp;<span>{{$admission_info->primary_doctor_name}}</span></li>
                    <li><b>Department:</b>&nbsp;<span>{{$admission_info->doc_dept}}</span></li>
                </ul>
            </td>
            <td style="text-align:right;width:32%">
                <ul style="list-style: none; padding-left: 0;">
                    <li>
                        <b>
                            @if (Session::get('user.ses_hospital_code') == "KPJ")
                                                    MRN :
                                                @else
                                                    UHID :
                            @endif
                        </b>&nbsp;<span>{{ isset($paitent_info->patient_code) ? $paitent_info->patient_code : '' }}</span></li>
                    <li><img style="" src="data:image/png;base64, {{ $pat_barcode }} "></li>
                    <li><b>Phone:</b>&nbsp;<span>{{ isset($paitent_info->mobile1) ? $paitent_info->mobile1 : '' }}</span></li>
                    <li><b>Date Of Admission:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->admission_date)) }}</span></li>
                    @if(!empty($admission_info->dis_datetime))<li><b>Date of Discharge:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->dis_datetime)) }}</span></li>@endif
                    <li><b>BILL STATUS:</b>&nbsp;<span>FINAL</span></li>
                    @if(Session::get('user.ses_hospital_code') != 'KPJ')
                    <li><strong>MUSHAK : </strong>6.3</li>
                    <li><strong>BIN NO :</strong> 000995938-0201</li>

                    @endif
                </ul>
            </td>
        </tr>
    </tbody>
</table>

<?php $final_total = $final_vat = $final_disc = $final_net_total = $final_advance = $final_received_amt = 0; ?>


    <table class="table table-bordered border-bottom" style="margin-top:10px;">
        <thead>
            <tr>
                <th class="text-center">SL</th>
                <th class="text-center">Invoice No</th>
                <th class="text-center">Date</th>
                <th class="text-center">Item Code</th>
                <th class="text-left">Particulars.</th>
                <th class="text-left">Doctor Name</th>
                <th class="text-center">Qty.</th>
                <th class="text-right">Rate</th>
                <th class="text-right">Amount</th>
                <th class="text-right">Discount</th>
                <th class="text-right">Net Amount</th>
            </tr>
        </thead>
        <tbody>
            <?php $final_total = $final_vat = $final_disc = $final_net_total = $final_advance = $final_received_amt = $advance = 0;  $in_words =  ''; ?>
           
                @foreach ($report_dt as $key => $dt)
                    <tr>
                        <td colspan="11" style="font-size: 14px; padding:5px 0px"><strong>{{ ucfirst($key) }}</strong></td>
                    </tr>
                    @php
                        $subTotal=0;
                    @endphp

                    <?php $total = 0;?>
                        @foreach ($dt as $key1 => $row)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-center">{{ $row->invoice_no_pk }}</td>
                                <td class="text-center">{{ date('d/m/Y g:i A', strtotime($row->invoice_datetime)) }}</td>
                                <td class="text-center">{{ $row->item_code }}</td>
                                <td class="text-left">{{ $row->item_name }}</td>
                                <td class="text-left">{{$row->item_type == "CONS" ?$row->full_name :''}}</td>
                                <td class="text-center">{{ $row->qty }}</td>
                             
                                {{-- <td class="text-center">{{ !empty($row->cancel_qty)?$row->cancel_qty:0 }}</td> --}}
                                <td class="text-right"> {{ number_format($row->rate, 2) }}</td>
                                <td class="text-right"> {{ number_format(($row->qty - $row->cancel_qty) * $row->rate, 2) }}</td>
                                <td class="text-right"> {{ number_format($row->net_discount, 2) }}</td>
                                <td class="text-right">{{ number_format((($row->qty - $row->cancel_qty) * $row->rate) - $row->net_discount, 2) }}</td>
                            </tr> 
                            @php 
                            $total += ($row->qty - $row->cancel_qty) * $row->rate;
                            $subTotal += (($row->qty - $row->cancel_qty) * $row->rate) - $row->net_discount;
                            @endphp
                        @endforeach
                        
                        <tr>
                          
                            <td style="text-align: right" colspan="11"><strong>{{ number_format($subTotal,2)}}</strong></td>
                        </tr>
                    @php
                            $final_received_amt += $total; 
                            $advance += $row->amount; 
                    @endphp
                @endforeach
                @inject('dipositAmt', 'App\Http\Controllers\IPDController')
                @php 
                $dipositAmt=$dipositAmt->ipdDipositAmt($admission_info->admission_no_pk)['sum_deposit_amount'];
                $advancePayment +=$dipositAmt;
                    $locale = 'en_US';
                    $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                    $net_total = $final_received_amt - isset($discount[0]->discount) ? number_format(( $final_received_amt - $advancePayment) -  $discount[0]->discount, 2, '.', '') : 0 ;
                    
                    $in_words = numfmt_format($fmt, abs($net_total));
                 @endphp
            





            <tr>
               
                <td colspan="5"><b>In Word :</b>
                    {{ strtoupper($in_words) }} TAKA ONLY</td>
                <td colspan="6">

                    <table>
                        <tbody>
                            <tr style="border:1px solid #000;">
                                <td class="text-right" style="width:50%"><b>Total :</b></td>
                                <td class="text-right" style="width:50%">{{ number_format($final_received_amt, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-right" style="width:50%"><b>Vat :</b></td>
                                <td class="text-right" style="width:50%">{{ number_format(0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-right" style="width:50%"><b>Discount :</b></td>
                                <td class="text-right" style="width:50%">{{ number_format(isset($discount[0]->discount) ? $discount[0]->discount : 0, 2) }} </td>
                            </tr>

                             <tr>
                                <td class="text-right" style="width:50%"><b>Advance Payment  :</b></td>
                                <td class="text-right" style="width:50%">{{ number_format($advancePayment, 2) }}</td>
                            </tr>
                             <tr>
                                <td class="text-right" style="width:50%"><b>Advance Allocation  :</b></td>
                                <td class="text-right" style="width:50%">{{ number_format(0, 2) }}</td>
                            </tr>
                            <tr>
                                <td class="text-right" style="width:50%"><b>Net Due :</b></td>
                                <td class="text-right" style="width:50%">{{ number_format( ($final_received_amt - $advancePayment) - (isset($discount[0]->discount) ? $discount[0]->discount : 0), 2) }}</td>
                            </tr>
                
                           
                        </tbody>
                    </table>
                </td>
            </tr>
            
      

            

        </tbody>
    </table>


<div style="margin-top: 50px;">
    <span style="float: left;"><strong>Authorised Signature</strong></span>
    <span style="float: right"><strong>Accounts</strong></span>
</div>
@if(Session::get('user.ses_hospital_code') != 'KPJ')
<footer>
    @php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
    @endphp
    <table style="border:none">
        <tbody>
            <tr>
                <td class="text-left" style="border:none; font-weight: 400;"> Print By: {{ Auth::user()->user_fullname }}, Print Date: {{ date('d/m/Y h:i:s a') }} </td>
                    <td class="text-right" style="border:none;  font-weight: 400;">Powered By: NEXTGEN IT</td>
                
                {{-- <td class="text-right" style="border:none;  font-weight: 400;">Powered By: NEXTGEN IT</td> --}}
            </tr>
        </tbody>
    </table>

</footer>
@endif
