

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
            <span class="name" style="font-size: 24px;">Khwaja Badrudduja Modern Hospital</span> <br>
            <span style="font-size: 12px;">Block -D, Holding - 10/1, Aziz Mansion, Shafipur, Kaliakair, Gazipur</span> <br>
            <span style="font-size: 12px;">(602) 519-0450</span> <br>
            <span style="font-size: 12px;"><a href="#">company@example.com</a></span>
         </div>
      </header>
      <main>
         <div id="details" class="clearfix">
            <div id="client">
               <div style="margin-bottom: 10px;">
                  <img style="" src="data:image/png;base64, {{ $pat_barcode  }} " />
               </div>
               <div class="name">
                  <strong> Paitent ID :</strong> {{ $invoice_mst_info->patient_code }}
               </div>
               <h2 class="name">
                  <strong> Paitent Name :</strong> {{ $invoice_mst_info->patient_name }}
               </h2>
               <div class="name">
                  <strong>Age : </strong> {{ ($invoice_mst_info->age ==0 )? "N/A" : $invoice_mst_info->age  }},&nbsp;&nbsp;&nbsp;&nbsp;<strong>Gender : </strong> {{ $invoice_mst_info->gender_txt }},&nbsp;&nbsp;&nbsp;&nbsp;<strong>Contact : </strong> {{ $invoice_mst_info->mobile1 }}
               </div>
               <div class="name">
                  <strong>Ref. Doctor :</strong> {{ $invoice_mst_info->doctor_name }}
               </div>
               <div class="name">
                  <strong>Address :</strong>  {{ !empty($invoice_mst_info->present_addr) ? $invoice_mst_info->present_addr : "N/A" }}
               </div>
            </div>
            <div>
               <strong style="border: 1px solid black; border-left: 1px solid black;padding: 5px 10px 5px 10px">Invoice</strong>
            </div>
            <div id="invoice">
               <span>  <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " />  </span> <br>
               <span style="font-size: 24px;">{{str_pad($invoice_mst_info->invoice_code, 10, "0", STR_PAD_LEFT) }}</span> <br>
               <span style="font-size: 10px;" class="date">Date of Invoice: {{ date("d/m/Y", strtotime($invoice_mst_info->au_entry_at)) }}</span> <br>
               <span class="date" style="font-size: 10px; margin-top: 20px; display: inline-block; margin-left: 65px;">Customer Copy</span>
            </div>
         </div>
         <div >
            <table >
               <thead>
                  <tr>
                     <th class="text-center">#SL</th>
                     <th class="text-left" >Item Description</th>
                     <th class="text-center" style="width:30px">Delivery Date</th>
                     <th class="text-right" style="width: 30px">Delivery Status</th>
                     <th class="text-right" style="width: 30px">Rate</th>
                     <th class="text-right" style="width: 30px">Quantity</th>
                     <th class="text-right" style="width: 30px">Cancel Quantity</th>
                     <th class="text-right" style="width: 30px">Amount (<small>BDT</small>)</th>
                  </tr>
               </thead>
               <tbody>
                  @php
                  $total = 0;
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
                     <td class="text-center bg-light">{{ $loop->iteration }}</td>
                     <td class="text-left"><strong>{{ $row->item_code }}: </strong> {{ $row->item_name }}</td>
                     <td class="text-center">
                        {{ ($row->report_delivery_date == '1970-01-01 00:00:00')? " ": date("d/m/Y",strtotime($row->report_delivery_date)) }}
                     </td>
                     @if($row->delivery_status_lookup_no_fk == 1)
                     <td></td>
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
                     <td class=" text-right">{{ number_format($item_rate,2,".","") }}</td>
                     <td class=" text-right" style="border-left: 1px solid #f1f1f1;">{{ $row->item_qty }}</td>
                     <td class=" text-right" style="border-left: 1px solid #f1f1f1;">{{ $row->cancel_qty }}</td>
                     <td class= "text-right bg-light">{{ number_format($row->item_qty*$item_rate,2,".","") }}</td>
                  </tr>
                  @php
                  $total +=  ($row->cancel_qty*$item_rate);
                  $cancel_dic += ($row->cancel_qty*$item_rate * $row->disc_perc / 100) ;
                  $cancel_fee += ($row->cancel_qty * $row->urgent_fee ) ;
                  @endphp
                  @endforeach
                  @endif
               </tbody>
               @php
               // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);
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
               $total_amt=$invoice_mst_info->ledger_amt_sales;
               $net_payable=number_format($total_amt - ($total + $total_dis  ),2,".","");
               $paid_amount= number_format($invoice_mst_info->ledger_amt_payment ,2,".","");
               $due_refund=number_format($net_payable - $paid_amount , 2, ".", "");
               $in_words = numfmt_format($fmt, $due_refund);
               @endphp
               <tfoot>
                  <tr>
                     <td class="border-0" colspan="5"></td>
                     <td class="border-0" colspan="1" >Total Item Amount</td>
                     <td class="border-0 text-right bg-light">{{ number_format($invoice_mst_info->ledger_amt_sales,2,".","") }} </td>
                  </tr>
                  <tr>
                     <td class="border-0" colspan="5"></td>
                     <td class="border-0" colspan="1" >Total Cancel Amount</td>
                     <td class="border-0 text-right bg-light"> {{  number_format($total,2,".","") }} </td>
                  </tr>
                  <tr>
                     <td class="border-0" colspan="5"></td>
                     <td class="border-0" colspan="1" >(-) Discount</td>
                     <td class="border-0 text-right"> {{ number_format($cancel_dic,2,".","") }} </td>
                  </tr>
                  <tr>
                     <td class="border-0" colspan="5"></td>
                     <td class="border-0" colspan="1" >Urgent Fee</td>
                     <td class="border-0 text-right bg-light">{{ number_format($cancel_fee,2,".","") }}</td>
                  </tr>
                  <tr>
                     <td class="border-0" colspan="5" style="text-align: center">
                        <div style="font-size: 18px;border:1px solid black;padding: 5px 10px 5px 10px">
                           @if($due_refund <= 0)
                           <strong >Refund</strong> 
                           @else
                           <strong >DUE</strong>
                           @endif
                        </div>
                     </td>
                     <td class="border-0" colspan="1" >Net Cancel Amount</td>
                     <td class="border-0 text-right">{{ number_format($total - $cancel_dic + $cancel_fee,2,".","") }} </td>
                  </tr>
                  <tr>
                     <td class="border-0" colspan="5" style="text-align: left">  <strong style="font-size: 12px;">In Word: {{ strtoupper($in_words) }} TAKA ONLY  </strong> </td>
                     <td class="border-0" colspan="1">Discounted Amount</td>
                     <td class="border-0">{{number_format($invoice_mst_info->ledger_amt_discount - $cancel_dic,2,".","") }}</td>
                  </tr>
                  <tr>
                     <td class="border-0" colspan="5"></td>
                     <td class="border-0" colspan="1">Net Payable</td>
                     <td class="border-0">{{number_format($total_amt - ($total + $total_dis  ),2,".","") }}</td>
                  </tr>
                  <tr>
                     <td class="border-0" colspan="5"></td>
                     <td class="border-0" colspan="1">Paid Amount</td>
                     <td class="border-0">{{number_format($invoice_mst_info->ledger_amt_payment ,2,".","") }}</td>
                  </tr>
                  @if($due_refund <= 0 ){
                  <tr>
                     <td class="border-0" colspan="5"></td>
                     <td class="border-0" colspan="1">Refund Amount</td>
                     <td class="border-0">{{number_format($due_refund ,2,".","") }}</td>
                  </tr>
                  }@else{
                  <tr>
                     <td class="border-0" colspan="5"></td>
                     <td class="border-0" colspan="1">Due Amount</td>
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
      <footer style="margin-top: 10em;">
         <!-- <hr style="border: 0.5px solid #000000"> -->
         <div class="">
            <span style="float:left">Printing Date & Time: {{ date('d/m/Y H:i:s') }} &nbsp; Prepared By: {{ $userInfo->user_fullname }} </span>
            <span style="float:right" >Powered By: NEXTGEN IT</span>
         </div>
      </footer>
   </body>
</html>























   var cancelItem = $(element).data("cancelitem");
      var this_can_qty= $(element).val() + cancelItem;
      var qty= $(element).data("qty");
      alert(this_can_qty);
      alert(qty);