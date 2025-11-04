 <!DOCTYPE html>
 <html>

 <head>
     <meta charset="utf-8">
     <meta http-equiv="X-UA-Compatible" content="IE=edge">
     <title>Journal Voucher Report</title>
     <!-- Tell the browser to be responsive to screen width -->
     <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
     {{-- <link rel="stylesheet" href="{{ public_path().'/css/print.css' }}" media="print"> --}}
     <style>
         @page {
             margin: .5cm .6cm;
             width: 100%;
             height: 100%
         }

         @font-face {
             font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
             font-weight: normal;
             font-size: 10px;
             font-style: normal;
             font-variant: normal;
             src: url("font url");
         }


         /** Define the header rules **/
         header {
             position: fixed;
             top: 0;
             height: 2cm;
             border-bottom: 1px solid;
             padding: 0 1cm;
         }

         header img {
             /*width: 80px;*/
         }

         /** Define now the real margins of every page in the PDF **/
         body {
             margin-top: 2cm;
             margin-left: .3cm;
             margin-right: .3cm;
             margin-bottom: 2cm;
             font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
             font-size: 11px;
         }

         footer {
             position: fixed;
             bottom: 0cm;
             left: 0cm;
             right: 0cm;
             height: .7cm;
             text-align: center;
             padding: 0 1cm;
             border-top: 1px solid;
         }

         .signature_ {
             position: fixed;
             /* bottom: 2cm; */
             left: .8cm;
             right: .8cm;
             width: 100%;
             /* text-align: center; */

             /* border-top: 1px solid; */
         }

         tfoot tr td {
             font-weight: bold;
         }

         .page-break {
             page-break-after: always;
         }

         .mt-5 {
             margin-top: 5px;
         }

         .mt-10 {
             margin-top: 10px;
         }

         .mt-20 {
             margin-top: 20px;
         }

         .mb-0 {
             margin-bottom: 0;
         }

         .mb-5 {
             margin-bottom: 15px;
         }

         .pb-0 {
             padding-bottom: 0;
         }

         table {
             border: 1px solid #222;
             border-spacing: 0;
         }

         td {
             border-bottom: 1px solid #222;
             border-right: 1px solid #222;
         }

         table td:last-child {
             border-right: 0px solid transparent;
         }

         th {
             border-top: 1px solid #222;
         }
     </style>

@if(!empty($report_data[0]->finalized_by))
    <style>
        .signature_ {bottom: 2cm;}
    </style>
@else
    <style>
        .signature_ {bottom: 1.6cm;}
    </style>
@endif
 </head>

 <body>
     <header>
         <table style="width: 100%; border:none;" class="signature">
             <tr>
                 <td style="width: 15%; border:none;">
                 @if(!empty($po_hospital_details->logo) && !file_exists(asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo)))
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"
                        alt="">
                @endif
                 </td>
                 <td style="text-align:center; border:none;">
                     <span style="font-size: 15px;"> <strong>
                             {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                         </strong></span>
                     <br>
                     Address:
                     <span>
                         {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                     Phone No:
                     <span>
                         {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                 </td>
                 <td style=" text-align:right; width: 15%;  border:none;">
                     <div style="">
                         <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                     </div>

                 </td>
             </tr>
         </table>
     </header>


     <div class="signature_">
         <table style="width: 100%;border-spacing: 0; border:none !important;" cellpadding="1">
             
            @if(!empty($report_data[0]->finalized_by))
                <tr>
                    <td style="text-align: left; border:none;"></td>
                    <td style="text-align: center; border:none;"></td>
                    <td style="text-align: center; border:none;"></td>
                    <td style="text-align: right; border:none;">@if(!empty($report_data[0]->finalized_by)) {{$report_data[0]->finalized_by}} @endif </td>
                </tr>
            @endif

            <tr class="table-tr">
                 <td style="text-align:left; border:none;">
                     <span style="padding:5px; border-top: black solid 1px;"> Prepared By
                     </span>
                 </td>
                 <td style="text-align:center; border:none;">
                     <span style="padding:5px; border-top: black solid 1px;"> Received By </span>
                 </td>

                 <td style="text-align:center; border:none;">
                     <span style="padding:5px; border-top: black solid 1px;"> Checked By</span>
                 </td>
                 <td style="text-align:right; border:none;">
                     <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
                 </td>
             </tr>
         </table>
     </div>



     <footer style="position: fixed;">
         <div class="footer">
             <div class="container">
                 <table style="width: 100%; padding:3px; margin: 0;border:none;">
                     <tr>
                         <td style="font-size: 9px; text-align:left;border:none;">Print Date & Time: <strong>
                                 <?php
                                 $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                 $date = $dt->format('g:i A');
                                 ?>
                                 {{ date('d/m/Y') }} {{ $date }}
                             </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                         <td style="font-size: 9px; text-align: right; border:none;"><strong>Powered By - H360
                                 [NextGen]
                             </strong></td>

                     </tr>
                 </table>
             </div>
         </div>
     </footer>


     <main>
         <div class="wrapper">
             <div style=" text-align:center; margin-bottom:5px; margin-top:20px  " class="mb-2">
                 <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  "> Journal Voucher
                     Report</span>
             </div>

             <div class="container">
                 <table style="width: 100%; padding:3px; margin: 0;border:none;">
                     <tr>
                         <td style="border:none;text-align:left"> <span>Transaction date:
                                 <strong>{{ date('d/m/Y', strtotime($report_data[0]->journal_date)) }}</strong></span>
                         </td>
                         <td style="border:none;text-align:center"> <span>Pay Mode:
                                 <strong>{{ $report_data[0]->voucher_type_name }}</strong></span></td>
                         <td style="border:none;text-align:right"><span>Voucher No:
                                 <strong>{{ $report_data[0]->journal_code }}</strong></span></td>

                     </tr>

                     @php
                         $paid_amount = 0;
                         foreach ($report_data as $value) {
                             $paid_amount += $value->trn_dr_account_amount;
                         }
                         
                     @endphp

                     <tr>
                         <td style="border:none;text-align:right" colspan="3"><span>Paid Amount:
                                 <strong>{{ number_format($paid_amount,2) }}</strong></span></td>

                     </tr>
                 </table>
             </div>


             <section id="lp-items">
                 <div class="container">
                     <table style="width: 100%;border-spacing: 0;" cellpadding="1">

                         <thead>
                             <tr class="table-tr" style="background-color: #111; color:white;">
                                 <th rowspan="2" class="table-td" scope="col" style="text-align: center;"> A/C
                                     Code
                                 </th>
                                 <th rowspan="2" class="table-td" scope="col" style="text-align: center;">Name
                                     of
                                     Account</th>
                                 <th rowspan="2" class="table-td" scope="col" style="text-align: center;">Cheque
                                     No.</th>
                                 <th rowspan="2" class="table-td" scope="col" style="text-align: center;">Sub
                                     Account/Cost Center</th>
                                 <th class="table-td" scope="col" colspan="2" style="text-align: center;">Amount
                                 </th>
                             </tr>
                             <tr class="thead-dark">
                                 <th class="table-td" scope="col" style="text-align: center;">Debit</th>
                                 <th class="table-td" scope="col" style="text-align: center;">Credit</th>
                             </tr>
                         </thead>
                         <br>
                         <tbody>
                             @php
                                 $debit = $credit = 0;
                             @endphp
                             @if (!empty($report_data))
                                 @foreach ($report_data as $value)
                                     <tr class="table-tr">
                                         <td class="table-td" style="text-align: center;" scope="col">
                                             <strong>{{ $value->trn_account_code }}</strong>
                                         </td>
                                         <td class="table-td" style="text-align: left;" scope="col">
                                             {{ !empty($value->account_name) ? ucfirst($value->account_name) : 'N/A' }}
                                         </td>
                                         <td class="table-td" style="text-align: center;" scope="col">
                                             {{ !empty($value->bank_cheq_number) ? ucfirst($value->bank_cheq_number) : 'N/A' }}
                                         </td>

                                         <td class="table-td" style="text-align: center;" scope="col">
                                             {{ !empty($value->voucher_type_name) ? $value->voucher_type_name : 'N/A' }}
                                         </td>

                                         <td class="table-td" style="text-align: right;" scope="col">
                                             {{ !empty($value->trn_dr_account_amount) ? number_format($value->trn_dr_account_amount, 2) : '' }}
                                         </td>
                                         <td class="table-td" style="text-align: right;" scope="col">
                                             {{ !empty($value->trn_cr_account_amount) ? number_format($value->trn_cr_account_amount, 2) : '' }}
                                         </td>
                                         <div style="display: none">{{ $debit += $value->trn_dr_account_amount }}
                                         </div>
                                         <div style="display: none">{{ $credit += $value->trn_cr_account_amount }}
                                         </div>

                                     </tr>
                                 @endforeach
                             @endif
                         </tbody>
                         @php
                             $locale = 'en_US';
                             $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                             $in_words = numfmt_format($fmt, $paid_amount);
                         @endphp
                         <tfoot>
                             <tr>
                                 <th class="table-td" style="text-align: right;" scope="col" colspan="4">
                                     Total
                                     =</th>
                                 <th class="table-td" style="text-align: right;" scope="col">
                                     {{ number_format($debit, 2) }}</th>
                                 <th class="table-td" style="text-align: right;" scope="col">
                                     {{ number_format($credit, 2) }}</th>
                             </tr>
                             <tr>
                                 <td class="table-td" style="text-align: right;" scope="col"> <strong>
                                         Narration:</strong></td>
                                 <td class="table-td" style="text-align: left;" scope="col" colspan="5">
                                     {{ !empty($report_data[0]->narration_text) ? ucwords($report_data[0]->narration_text) : '' }}
                                 </td>
                             </tr>
                             <tr>
                                 <td class="table-td" style="text-align: right;" scope="col"> <strong>In
                                         Word:</strong></td>
                                 <td class="table-td" style="text-align: left;" scope="col" colspan="5">
                                     {{ $in_words }}</td>
                             </tr>
                         </tfoot>
                     </table>
                 </div>
             </section>
         </div>
     </main>
 </body>
 </html>
