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
                    <strong>{{ ($invoice_mst_info->patient_code !="" ? " Paitent ID :" :"") }}</strong> {{ $invoice_mst_info->patient_code }}
                </div>

                <h2 class="name">
                    <strong>{{ ($invoice_mst_info->patient_name !=" ") ? "Paitent Name :" : "" }}</strong> {{ ucwords($invoice_mst_info->patient_name) }}
                </h2>

                <div class="name">
                    <strong> {{ ( $invoice_mst_info->age =="") ? "" : "Age:" }} </strong> {{ ($invoice_mst_info->age == "" )? "" : $invoice_mst_info->age .","  }}<strong>{{ $invoice_mst_info->gender_txt ? "Gender :" :"" }}  </strong> {{ ($invoice_mst_info->gender_txt ? $invoice_mst_info->gender_txt : "")  }}
                </div>

                <div class="name">
                    <strong>{{ ( $invoice_mst_info->mobile1 != "") ? "Contacts:" : ""}} </strong> {{ (( $invoice_mst_info->mobile1 != "") ? $invoice_mst_info->mobile1 : "") }}
                </div>

                

                <div class="name">
                    <strong>{{($invoice_mst_info->present_addr !="  ") ? "Address:" : ""}}</strong>  {{ !empty($invoice_mst_info->present_addr) ? $invoice_mst_info->present_addr : "" }}
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

               <div class="name">
                    <strong>{{isset($discout_by->full_name ) ? "Discount By:" : ""}}</strong>  {{ isset($discout_by->full_name ) ? ucwords($discout_by->full_name) : "" }}{{ isset($ledgermst_paydisc->disc_amt_by_hosp)  && $ledgermst_paydisc->disc_amt_by_hosp !=0? "(".$ledgermst_paydisc->disc_amt_by_hosp ." "."Tk".")" : "" }} {{ isset($ledgermst_paydisc->disc_amt_by_doc ) && $ledgermst_paydisc->disc_amt_by_doc !=0 ? " , Doctor Disc. "."(".$ledgermst_paydisc->disc_amt_by_doc ." "."Tk".")" : "" }}
                </div>
                <div class="name">
                    <strong>{{ isset($ledgermst_paydisc->disc_amt_request_name )? "Disc. Request By" : "" }}</strong>
                    {{ isset($ledgermst_paydisc->disc_amt_request_name )? $ledgermst_paydisc->disc_amt_request_name  : "" }}
                </div>

            </div>
            <div id="center_invoice">
                <?php
                if ($page == "pos") {
                   $heading = "POS Invoice";
               } else {
                   $heading = "Invoice";
               }



               ?>
               <strong > &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp; <u>{{$heading}}</u></strong>
           </div>

           <div id="invoice">
            <span>  <img style="" src="data:image/png;base64, {{ $invoice_barcode }} " />  </span> <br>
            <span style="font-size: 24px;">{{ $invoice_mst_info->invoice_code }}</span> <br>
            <span style="font-size: 10px;" class="date">Date of Invoice: {{ date("d/m/Y", strtotime($invoice_mst_info->au_entry_at)) }}</span> <br>

            <span class="date" style="font-size: 10px; margin-top: 20px; display: inline-block; margin-left: 65px;">Customer Copy</span>
        </div>
    </div>

    <table>
        <thead>
            <tr>
                <th class="text-center">SL#</th>
                <th class="text-left">Item Description</th>
                <!-- <th class="text-center">Delivery Date</th> -->
                <!-- <th class="text-right">Delivery Status</th> -->
                <th class="text-right">Rate</th>
                <th class="text-right">Quantity</th>
                <th class="text-right" style="width: 50px">Amount <br> (<small>BDT</small>)</th>
            </tr>
        </thead>
        <tbody>
            @php
            $total = 0;
            @endphp

            @if(!empty($invoice_dtls_info))
            @foreach($invoice_dtls_info as $row)

            @php
            $urgent_fee=0;
            @endphp

            <tr>
                <td class="text-center bg-light">{{ sprintf("%02d", $loop->iteration)  }}</td>
                <td class="text-left"><strong>{{ $row->item_code }}: </strong> {{ $row->item_name }}</td>
                <!-- <td class="text-center">
                    {{ ($row->report_delivery_date == '1970-01-01 00:00:00')? " ": date("d/m/Y",strtotime($row->report_delivery_date)) }}
                </td> -->


                <!-- @if($row->delivery_status_lookup_no_fk == 1)
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
                @endif -->
                @php
                $item_rate = $row->item_rate;
                @endphp
                
                <td class=" text-right item_rate">{{ number_format($item_rate,2,".","") }}</td>
                <td class=" text-right" style="border-left: 1px solid #f1f1f1;">{{ $row->item_qty }}</td>
                <td class= "text-right bg-light">{{ number_format($row->item_qty*$item_rate,2,".","") }}</td>
            </tr>
            @php
            $total += ($row->item_qty*$item_rate);
            @endphp
            @endforeach
            @endif
        </tbody>
        @php
        // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);

        $vat = number_format(0,2,".","");
        $discount = number_format($total_dis->ledger_amt_discount,2,".","");
        $payment = number_format($total_sales->ledger_amt_payment,2,".","");
        $urgent_fee = number_format($invoice_mst_info->urgent_fee,2,".","");
        $payable = number_format((($total ) - $discount),2,".","");
        $due = number_format((($total) - $payment),2,".","");
        $due=  $due- $discount;

        $number = ($total ) - $discount;
        $locale = 'en_US';
        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
        $in_words = numfmt_format($fmt, $number);
        @endphp

        <tfoot>

            <tr>
                <td class="border-0 text-left" colspan="2">  

                  @if(isset($ledger_no))
                  <div style=" margin-bottom: 5px"><span style="border-bottom:1px solid black; margin-bottom: 5px">Cash Receipt In</span> </div>
                  @foreach($ledger_no as $value)

                  @if($value->paymood == "CASH")
                  CASH :{{$value->pay_amount}}  ,

                  @elseif($value->paymood == "Mbanking")
                  {{strtoupper($value->pay_mood_type)}} :{{$value->pay_amount}}  ,                                


                  @elseif($value->paymood == "CARD")
                  {{strtoupper("Card")}}  ({{strtoupper($value->pay_mood_type)}}) : {{$value->pay_amount}}  ,

                  @else 
                  OTHERS : {{$value->pay_amount}}  ,
                  @endif
                  @endforeach
                  @endif                     
              </td>
              <td class="border-0" colspan="2" >SUBTOTAL</td>
              <td class="border-0 text-right bg-light">{{ number_format($total,2,".","") }} </td>
          </tr>
<!--                 <tr>
                    <td class="border-0" colspan="2"></td>
                    <td class="border-0" colspan="2" >VAT</td>
                    <td class="border-0 text-right bg-light"> {{ number_format($vat,2,".","") }} </td>
                </tr> -->
                <tr>
                    <td class="border-0" colspan="2"></td>
                    <td class="border-0" colspan="2" >Urgent Fee</td>
                    <td class="border-0 text-right"> {{ number_format($invoice_mst_info->urgent_fee,2,".","") }} </td>
                </tr>
<!--                 <tr>
                    <td class="border-0" colspan="2"></td>
                    <td class="border-0" colspan="2" >S. Charge</td>
                    <td class="border-0 text-right bg-light">{{ number_format($invoice_mst_info->service_charge,2,".","") }} </td>
                </tr> -->
                <tr>
                    <td class="border-0" colspan="2" style="text-align: center">
                        <div style="font-size: 18px;border:1px solid black;padding: 5px 10px 5px 10px">
                            @if($due == 0)
                            <strong >FULL PAID</strong> 
                            @else
                            <strong >DUE</strong>
                            @endif
                        </div>


                    </td>
                    <td class="border-0" colspan="2" >Discount</td>
                    <td class="border-0 text-right">{{ number_format($discount,2,".","") }} </td>
                </tr>

                <tr>
                    <td class="border-0" colspan="2" style="text-align: left;  word-wrap: break-word; ">  <strong style="font-size: 11px;">In Word: {{ strtoupper($in_words) }} TAKA ONLY  </strong> </td>
                    <td class="border-0" colspan="2">Bill Amount</td>
                    <td class="border-0">{{ number_format($payable,2,".","") }}</td>
                </tr>

            <!--     <tr>
                    <td class="border-0" colspan="2"></td>
                    <td class="border-0" colspan="2">Payment</td>
                    <td class="border-0">{{ number_format($ledger_pay_amount->pay_amount,2,".","") }}</td>
                </tr> -->
                <tr>
                    <td class="border-0" colspan="2"></td>
                    <td class="border-0" colspan="2"> Paid</td>
                    <td class="border-0">{{ number_format($payment,2,".","") }}</td>
                </tr>
                <tr>
                    <td class="border-0" colspan="2"></td>
                    <td class="border-0" colspan="2">Due</td>
                    <td class="border-0">{{ number_format($due,2,".","") }}</td>
                </tr>
            </tfoot>
        </table>
        <!-- <strong>Note: Please collect your reports within 30 days.</strong> -->
    </main>
    {{--             <div id="notices">
        <div>NOTICE:</div>
        <div class="notice">A finance charge of 1.5% will be made on unpaid balances after 30 days.</div>
    </div> --}}
    <footer style="  position: fixed;">
        <!-- <hr style="border: 0.5px solid #000000"> -->
        <div class="">
            <?php 
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date= $dt->format('g:i A');
            ?>
            <span style="float:left">Prepared By: {{ $userInfo->user_fullname }} &nbsp;  Date & Time: {{ date('d/m/Y') }} , {{ $date}} </span>
            <span style="float:right" >Powered By: NEXTGEN IT</span>
        </div>
    </footer>
</body>
</html>
