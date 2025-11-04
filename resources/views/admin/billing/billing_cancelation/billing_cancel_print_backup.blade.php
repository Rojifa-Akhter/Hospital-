<html>
<head>
  <meta charset="utf-8" />
  <meta http-equiv="X-UA-Compatible" content="IE=edge" />
  <title>H360 Invoice</title>
  <!-- Tell the browser to be responsive to screen width -->
  <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
  <!--<link rel="stylesheet" href="{{ asset('print/pdf.css') }}" media="all"> -->
  <link rel="stylesheet" href="css/invoice_a5.css" media="all" />
</head>
<body>
  <header class="clearfix">
   <div id="logo">
    <img src="images/kbmh.jpg" />
  </div>
  <div id="company">
    <span class="name" style="font-size: 24px;">{{isset($po_hospital_details->hospital_name )? $po_hospital_details->hospital_name : ""}}</span> <br>
    <span style="font-size: 12px;">{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : ""}}</span> <br>
    <span style="font-size: 12px;">{{isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : "" }}</span> <br>
    <!-- <span style="font-size: 12px;"><a href="#">company@example.com</a></span> -->
  </div>
</header>
<main>
 <div id="details" class="clearfix">
  <div id="client" style="width: 170px">
   <div style="margin-bottom: 10px;">
    <img style="" src="data:image/png;base64, {{ $pat_barcode  }} " />


  </div>
  <div class="name">
    <strong> Paitent ID :</strong> {{ $invoice_mst_info->patient_code }}
  </div>
  <h2 class="name">
    <strong>{{ $invoice_mst_info->patient_name !="" ?  "Paitent Name :" : ""}}</strong> {{ ucwords($invoice_mst_info->patient_name) }}
  </h2>
  <div class="name">
    <strong>{{ ($invoice_mst_info->age =="")? "" : "Age :"  }} </strong> {{ ($invoice_mst_info->age =="")? "" : $invoice_mst_info->age  }},&nbsp;&nbsp;&nbsp;&nbsp;<strong>Gender : </strong> {{ $invoice_mst_info->gender_txt }}


  </div>
  <div class="name">
   <strong>{{ $invoice_mst_info->mobile1 !="" ? "Contact :" : "" }} </strong> {{ $invoice_mst_info->mobile1 }}
 </div>
 <div class="name">
  <strong>{{ $invoice_mst_info->doctor_name !="" ? "Ref. Doctor :" : ""}}</strong> {{ $invoice_mst_info->doctor_name }}
</div>
<div class="name">
  <strong> {{ !empty($invoice_mst_info->present_addr) ? "Address :" : "" }}</strong>  {{ !empty($invoice_mst_info->present_addr) ? $invoice_mst_info->present_addr : "" }}
</div>
@if($invoice_mst_info->doctor_name !="Self" && $invoice_mst_info->doctor_name !="")
<div class="name">
  <strong>{{ ($invoice_mst_info->doctor_name !="") ? "Ref. Doctor:" : ""}}</strong> {{ ($invoice_mst_info->doctor_name != "" ? ucwords($invoice_mst_info->doctor_name) : "") }}
</div>
@endif
@if($invoice_mst_info->first_doc_name !="Self" && $invoice_mst_info->first_doc_name !=" ")
<div class="name">
  <strong>{{ ($invoice_mst_info->first_doc_name !="") ? "1st Ref:" : " "}}</strong> {{ isset($invoice_mst_info->first_doc_name)? ucwords($invoice_mst_info->first_doc_name) : " " }}
</div>
@endif
@if($invoice_mst_info->second_doc_name !="Self" && $invoice_mst_info->second_doc_name !=" ")
<div class="name">
  <strong>{{ ($invoice_mst_info->second_doc_name !="") ? "2nd Ref:" : ""}}</strong> {{ isset($invoice_mst_info->second_doc_name)? ucwords($invoice_mst_info->second_doc_name) : " " }}
</div>
@endif
</div>
<div id="center_invoice">
  <strong>&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<u>Cancel Slip</u></strong>
</div>


<div id="invoice">
 <span>  <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " />  </span> <br>
 <span style="font-size: 24px;">{{$invoice_mst_info->invoice_code }}</span> <br>
 <span style="font-size: 10px;" class="date">Date of Invoice: {{ date("d/m/Y", strtotime($invoice_mst_info->au_entry_at)) }}</span> <br>
 <span class="date" style="font-size: 10px; margin-top: 20px; display: inline-block; margin-left: 65px;">Customer Copy</span>
</div>
</div>
<div >

  <table >
   <thead>
    <tr>
     <th class="text-center">SL#</th>
     <th class="text-left" >Item Description</th>
     <th class="text-center" >Delivery  Date</th>
     <th class="text-right" >Delivery  Status</th>
     <th class="text-right" >Rate</th>
     <th class="text-right">Qty</th>
     <th class="text-right">Cancel  Qty</th>
     <th class="text-right" >Amount (<small>BDT</small>)</th>
   </tr>
 </thead>
 <tbody>
  @php
  $total = 0;
  $total_item_rate = 0;
  $cancel_dic = 0;
  @endphp
  @if(!empty($invoice_dtls_info))
  @foreach($invoice_dtls_info as $row)
  @php
  $urgent_fee=0;
  $item_rate =0;
  $cancel_fee =0;
  @endphp
  <tr>
   <td class=" bg-light">{{ sprintf("%02d", $loop->iteration)  }}</td>
   <td class=""><strong>{{ $row->item_code }}: </strong> {{ $row->item_name }}</td>
   <td class="">
    {{ ($row->report_delivery_date == '1970-01-01 00:00:00')? " ": date("d/m/Y",strtotime($row->report_delivery_date)) }}
  </td>
  @if($row->delivery_status_lookup_no_fk == 1)
  <td class=" text-right"> Routine </td>
  @php
  $item_rate = $row->item_rate;
  @endphp
  @elseif($row->delivery_status_lookup_no_fk == 2)
  <td class=" text-right"> Urgent </td>
  @php
  $urgent_fee=isset($row->urgent_fee)?$row->urgent_fee : "0" ;
  $item_rate = $row->item_rate+ $urgent_fee;
  @endphp
  @else
  <td></td>
  @php
  $item_rate = $row->item_rate;
  @endphp
  @endif
  <td class=" text-right item_rate">{{ number_format($item_rate,2,".","") }}</td>
  <td class=" text-right" style="border-left: 1px solid #f1f1f1;">{{ $row->item_qty }}</td>
  <td class=" text-right" style="border-left: 1px solid #f1f1f1;">{{ $row->cancel_qty }}</td>
  <td class= "text-right bg-light">{{ number_format($row->cancel_qty*$item_rate,2,".","") }}</td>
</tr>
@php
$total +=  ($row->cancel_qty*$item_rate);
$total_item_rate +=  ($item_rate);
$cancel_dic += ($row->cancel_qty*$item_rate * $row->disc_perc / 100) ;
$cancel_fee += ($row->cancel_qty * $row->urgent_fee ) ;
@endphp
@endforeach
@endif
</tbody>
@php
// $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);
$calcel_discount=$c_dis_cancelation->disc_amount ;

$vat = number_format(0,2,".","");
$discount = number_format($invoice_mst_info->ledger_amt_discount,2,".","");
$payment = number_format($invoice_mst_info->ledger_amt_payment,2,".","");
$urgent_fee = number_format($invoice_mst_info->urgent_fee,2,".","");
$payable = number_format((($total ) - $discount),2,".","");
$due = number_format((($total) - $payment),2,".","");
$due=  $due- $discount;
$number = ($total ) - $discount;
$locale = 'en_US';
$fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
$total_dis=$invoice_mst_info->ledger_amt_discount;
$total_amt=$total_item_rate;
$net_payable=number_format($total_amt - ($total + $c_discount->disc_amount - $calcel_discount ),2,".","");
$paid_amount= number_format($total_sales->ledger_amt_payment ,2,".","");
$due_refund=number_format($net_payable - $paid_amount , 2, ".", "");


if($due_refund <= 0 ){
$in_words = numfmt_format($fmt,abs($net_payable));
}else{
$in_words = numfmt_format($fmt,$net_payable);
}

@endphp
<tfoot>
  <tr>
   <td class="border-0" colspan="4"></td>
   <td class="border-0" colspan="3" >Total Item Amount</td>
   <td class="border-0 text-right bg-light">{{ number_format($total_item_rate,2,".","") }} </td>
 </tr>
 <tr>
   <td class="border-0" colspan="4"></td>
   <td class="border-0" colspan="3" >Total Cancel Amount</td>
   <td class="border-0 text-right bg-light"> {{  number_format($total,2,".","") }} </td>
 </tr>
<!--  <tr>
   <td class="border-0" colspan="4"></td>
   <td class="border-0" colspan="3" >(-) Discount</td>
   <td class="border-0 text-right"> {{ number_format($calcel_discount,2,".","") }} </td>
 </tr> -->
 <tr>
   <td class="border-0" colspan="4"></td>
   <td class="border-0" colspan="3" >Urgent Fee</td>
   <td class="border-0 text-right bg-light">0.00
     <!-- {{ number_format($cancel_fee,2,".","") }} -->
   </td>
 </tr>
 <tr>
   <td class="border-0" colspan="4" style="text-align: center">
    <div style="font-size: 18px;border:1px solid black;padding: 5px 10px 5px 10px">
     @if($due_refund <= 0)
     <strong >Refund</strong> 
     @else
     <strong >DUE</strong>
     @endif
   </div>
 </td>
 <td class="border-0" colspan="3" >Net Cancel Amount</td>
 <td class="border-0 text-right">{{ number_format($total - $calcel_discount ,2,".","") }} </td>
</tr>
<tr>
 <td class="border-0" colspan="4" style="text-align: left">  <strong style="font-size: 12px;">In Word: {{ strtoupper($in_words) }} TAKA ONLY  </strong> </td>
 <td class="border-0" colspan="3">Discounted Amount</td>
 <td class="border-0">{{number_format($c_discount->disc_amount - $calcel_discount ,2,".","") }}</td>
</tr>
<tr>
 <td class="border-0" colspan="4"></td>
 <td class="border-0" colspan="3">Net Payable</td>
 <td class="border-0">{{number_format($total_amt - ($total + $c_discount->disc_amount - $calcel_discount ),2,".","") }}</td>
</tr>
<tr>
 <td class="border-0" colspan="4"></td>
 <td class="border-0" colspan="3">Paid Amount</td>
 <td class="border-0">{{number_format($paid_amount ,2,".","") }}</td>
</tr>
@if($due_refund < 0 ){
<tr>
 <td class="border-0" colspan="4"></td>
 <td class="border-0" colspan="3">Refund Amount</td>
 <td class="border-0">{{number_format(abs($due_refund) ,2,".","") }}</td>
</tr>
}@else{
<tr>
 <td class="border-0" colspan="4"></td>
 <td class="border-0" colspan="3">Due Amount</td>
 <td class="border-0">{{number_format($due_refund ,2,".","") }}</td>
</tr>
}
@endif
</tfoot>
</table>
</div>

</main>
{{--             
  <div id="notices">
   <div>NOTICE:</div>
   <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
 </div>
 --}}
 <footer style="margin-top: 10em; position: fixed;">
   <!-- <hr style="border: 0.5px solid #000000"> -->
   <div class="">
     <?php 
     $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
     $date= $dt->format('g:i A');
     ?>
     <span style="float:left">  Prepared By: {{ $userInfo->user_fullname }} &nbsp;  Date & Time: {{ date('d/m/Y') }} , {{ $date}} </span>
     <span style="float:right" >Powered By: NEXTGEN IT</span>
   </div>
 </footer>
</body>
</html>

