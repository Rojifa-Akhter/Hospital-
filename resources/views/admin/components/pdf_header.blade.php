   <!DOCTYPE html>
   <html>

   <head>
       <meta charset="utf-8">
       <meta http-equiv="X-UA-Compatible" content="IE=edge">
       <title>Lp Report</title>
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
               bottom: 1.6cm;
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
       </style>
   </head>
   <body>
       <header>
           <table style="width: 100%;" class="signature">
               <tr>
                   <td style="width: 10%;">
                       <img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60" alt="">
                   </td>
                   <td style="">
                        <span style="font-size: 15px;"> <strong>  {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }} </strong></span> <br>
                      Address: <span> {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                       Phone No: <span> {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                   </td>
                   {{-- <td style=" text-align:right; width: 15%; ">
                    <div style="">
                       <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                    </div>

                   </td> --}}
               </tr>
           </table>
       </header>
