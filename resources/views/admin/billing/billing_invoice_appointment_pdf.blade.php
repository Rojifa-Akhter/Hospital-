<html>
<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>H360 Appointment Invoice</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="{{ asset('print/pdf.css') }}" media="all">
    
 
    <link rel="stylesheet" href="css/invoice.css" media="all" />
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
                <span style="font-size: 12px;" class="date">Date of Invoice: {{ date("d/m/Y", strtotime($invoice_mst_info->au_entry_at)) }}</span> <br>

                <span class="date" style="font-size: 12px; margin-top: 20px; display: inline-block; margin-left: 65px;">Customer Copy</span>
            </div>
        </div>
        <div class="invoice_body">
            <table >
                <thead >
                    <tr>
                        <th class="">SL#</th>
                        <th class="text-left">Code</th>
                        <th class="text-left">Service Name</th>
                        <th class="text-left"></th>
                        <th class="text-right">Price (<small>Tk</small>)</th>
                    </tr>
                </thead>

                <tbody>
                    @php
                    $total = 0;
                    @endphp

                    @if(!empty($invoice_dtls_info))
                    @foreach($invoice_dtls_info as $row)
                    <tr>
                        <td class="text-left">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $row->item_code }}</td>
                        <td class="text-left">{{ $row->item_name }}</td>
                        <td class=""></td>
                        <td class="text-right">{{ number_format($row->item_qty*$row->item_rate,2,".","") }}</td>
                    </tr>
                    @php
                    $total += ($row->item_qty*$row->item_rate);
                    @endphp
                    @endforeach
                    @endif
                </tbody>
                @php
                // $amt_in_word = new \NumberFormatter( 'en_US', \NumberFormatter::SPELLOUT);

                $discount = number_format(0,2,".","");
                $payment = number_format($invoice_mst_info->ledger_amt_payment,2,".","");
                $payable = number_format(($total - $discount),2,".","");
                $due = number_format(($total - $payment),2,".","");
                @endphp

                <tfoot>
                    {{-- <tr>
                        <td class="border-0" colspan="3"><strong>Remarks:</strong></td>
                        <td class="border-0 text-right"><strong>Amount</strong></td>
                        <td class="border-0 text-right bg-light">{{ number_format($total,2,".","") }}</td>
                    </tr> --}}

                    {{-- <tr>
                        <td class="border-0" colspan="3"><strong>Delivery Date:</strong></td>
                        <td class="border-0 text-right"><strong>VAT</strong></td>
                        <td class="border-0 text-right bg-light">{{ number_format($discount,2,".","") }}</td>
                    </tr> --}}

                    {{-- <tr>
                        <td class="border-0" colspan="3"></td>
                        <td class="border-0 text-right"><strong>(-) Discount</strong></td>
                        <td class="border-0 text-right bg-light">{{ number_format($discount,2,".","") }}</td>
                    </tr> --}}

                    {{-- <tr>
                        <td class="border-0" colspan="3"></td>
                        <td class="border-0 text-right"><strong>Urgent Fee</strong></td>
                        <td class="border-0 text-right bg-light">{{ number_format($invoice_mst_info->urgent_fee,2,".","") }}</td>
                    </tr> --}}

                    {{-- <tr>
                        <td class="border-0" colspan="3"></td>
                        <td class="border-0 text-right"><strong>S. Charge</strong></td>
                        <td class="border-0 text-right bg-light">{{ number_format($invoice_mst_info->service_charge,2,".","") }}</td>
                    </tr> --}}

                    <tr>
                        <td class="border-0"></td>
                        <td class="border-0 text-right"></td>
                        <td class="border-0 text-left" colspan=""></td>
                        <td class="border-0 text-right"><strong>Payable</strong></td>
                        <td class="border-0 text-right bg-light">{{ number_format($payable,2,".","") }}</td>
                        {{-- <td class="border-0 text-right"><strong>Payment</strong></td>
                        <td class="border-0 text-right bg-light">{{ number_format($payment,2,".","") }}</td> --}}
                    </tr>
                    <tr>
                        <td class="border-0"></td>
                        <td class="border-0"></td>
                        <td class="border-0"></td>
                        <td class="border-0 text-right"><strong>Payment</strong></td>
                        <td class="border-0 text-right bg-light">{{ number_format($payment,2,".","") }}</td>
                    </tr>

                    <tr>
                        <td class="border-0"></td>
                        <td class="border-0"></td>
                        <td class="border-0"></td>
                        <td class="border-0 text-right"><strong>Due</strong></td>
                        <td class="border-0 text-right bg-light">{{ number_format($due,2,".","") }}</td>
                    </tr>
                </tfoot>
            </table>

            {{-- <table class="table table-bordered w-50" >
                <thead>
                    <tr>
                        <th class="text-center bg-light">Payment Type</th>
                        <th class="text-left bg-light">Collected By</th>
                        <th class="text-center bg-light">Mode</th>
                        <th class="text-right bg-light">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td class="text-center">Initial Collection</td>
                        <td class="text-left">ADMIN</td>
                        <td class="text-center"></td>
                        <td class="text-right">{{ number_format($payment,2,".","") }}</td>
                    </tr>
                </tbody>
            </table> --}}
        </div>
    </main>
    <footer>
        <hr style="border: 0.5px solid #000000">
        <div class="">
            <span style="float:left">Printing Date & Time: {{ date('d/m/Y H:i:s') }}</span>
            <span style="float:right" >Powered By: NEXTGENiT Ltd.</span>
        </div>
    </footer>
</body>

</html>