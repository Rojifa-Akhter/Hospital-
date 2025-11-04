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
                   <td style="width: 15%;">
                     @if(!empty($po_hospital_details->logo))
                     <img src="{{ asset('images/uploads/hospital_images/'.$po_hospital_details->logo) }}" width="60"/>
                     @endif
                 </td>
                 <td style="text-align:center;">
                    <span style="font-size: 15px;"> <strong> {{isset($po_hospital_details->hospital_name )? $po_hospital_details->hospital_name : ""}} </strong></span> <br>
                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : ""}}<br>
                    {{isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : "" }}
                </td>
                <td style=" text-align:right; width: 15%; ">
                    <div style="">
                       <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                   </div>

               </td>
           </tr>
       </table>
   </header>
   <div style="width: 100%;">
    <div style=" text-align:center; margin-bottom:5px; margin-top:15px  ">
        <span class="report-name" style="width:70%; border:solid black 1px; padding:10px;  ">Test Attribute Report</span>
    </div>
    <div style=" text-align:center;  width:100%; margin-bottom:5px" class="mb-2">



    </div>
</div>
<div class="signature_">
    <table style="width: 100%;">
        <tr style=" ">
            <td style="text-align:left; ">
                <span style="padding:5px; border-top: black solid 1px;"> Authorized signer
                </span>
            </td>

            <!-- <td style="text-align:left; ">
                <span style="padding:5px; border-top: black solid 1px;"> HR & ADMIN
                </span>
            </td>
            <td style=" ">
                <span style="padding:5px; border-top: black solid 1px;"> MANAGER (HOSPITAL SERVICE)
                </span>
            </td>
            <td style=" ">
                <span style="padding:5px; border-top: black solid 1px;"> ACCOUNT OFFICER
                </span>
            </td>
            <td style=" ">
                <span style="padding:5px; border-top: black solid 1px;"> GENERAL MANAGER
                </span>
            </td>
            <td style="text-align:right; ">
                <span style="padding:5px; border-top: black solid 1px;"> MANAGING DIRECTOR </span>
            </td> -->
        </tr>
    </table>
</div>

<footer>
    <div class="footer">
        <div class="container">
            <table style="width: 100%; padding:3px; margin: 0">
                <tr>
                    <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                        @php
                        date_default_timezone_set('Asia/Dhaka');
                        $date = date('d/m/Y H:m:s');
                        @endphp
                        {{ $date }}
                    </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                    <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong></td>
                </tr>
            </table>
        </div>
    </div>
</footer>
<main style="height: 80%;">
    <div class="wrapper">

        <section id="lp-items">
            <div class="container">
                <table style="width:100%;border-collapse:collapse;" cellpadding="1" cellspacing="0" border="1">
                    <thead style="">
                        <tr class="table-tr" style="background-color: #E3E3E3; ">
                            <th class=" table-td" > <strong>SL# </strong></th>
                            <th class=" table-td" > <strong>TEST STRUCT No Pk </strong></th>
                            <th class=" table-td" > <strong>TEST STRUCT CODE </strong></th>
                            <th class=" table-td" width="150px"> <strong>ATTR </strong></th>
                            <th class=" table-td" width="60px"> <strong>UNIT </strong></th>
                            <th class=" table-td" > <strong>DEFAULT VALUE </strong></th>
                            <!-- <th class=" table-td" > <strong>TEST GROUP PK NO </strong></th> -->
                            <th class=" table-td" > <strong>GROUP SEQ </strong></th>
                            <th class=" table-td" > <strong>SHOW  </strong></th>
                            <th class=" table-td" > <strong>HIDE </strong></th>
                            <th class=" table-td" > <strong>GRH </strong></th>
                            <!-- <th class=" table-td" > <strong>TEST GROUP ID </strong></th> -->
                            <th class=" table-td" > <strong>STATUS </strong></th>
                        </tr>


                    </thead>
                    <tbody>
                        @php
                        $listSl = 0;@endphp
                        @if (!empty($attr_list))

                        @foreach ($attr_list as $item => $item_data)

                        @php
                        $item_details=explode('_',$item);
                        $item_name = 0;
                        @endphp
                        @foreach ($item_data as $attr_data => $data)

                        @php
                        $des = 0;
                        $listSl++;
                        $item_name++;
                        @endphp
                        @if ($item_name == 1)

                        <tr class="">
                            <td class="border-0" colspan="11">
                                <strong> Test No pk = </strong>{{ $item_details[1] }}, &nbsp;
                                <strong> Test Code = </strong>{{$item_details[2] }}, &nbsp;
                                <strong> Test Name = </strong>{{$item_details[0] }}, &nbsp;
                                <strong> Sample = </strong>{{$item_details[3] }}, &nbsp;
                                <strong> Container = </strong>{{$item_details[4] }}, &nbsp;
                                <strong> Template = </strong>{{$item_details[5] }}, &nbsp;
                                <strong> Single Test = </strong>{{$item_details[6] !="" ? "Yes" : "" }}, &nbsp;
                                <strong> Service Unit = </strong>{{$item_details[7] }} &nbsp;


                            </td>
                        </tr>
                        @endif

                        <tr class="table-tr">
                            <td class="table-td" style="text-align: center;" style="text-align: center;"
                            scope="col"><strong>{{$data->sl_no }}</strong></td>
                            <td class="table-td" style="text-align: left;">{{ $data->teststruct_no_pk }} </td>
                            <td class="table-td" style="text-align: left;">{{ $data->teststruct_code }} </td>
                            <td class="table-td" style="text-align: left;">{{ $data->attr }}</td>
                            <td class="table-td" style=""> {{ $data->unit }}</td>
                            <td class="table-td" style=""> {{ $data->default_value }}</td>
                            <!-- <td class="table-td" style=""> {{ $data->test_group_pk_no }}</td> -->
                            <td class="table-td" style="">{{ $data->group_seq }}</td>
                            <td class="table-td" style=""> {{$data->show_ind }}</td>
                            <td class="table-td" style="">{{ $data->hide_permanent }}</td>
                            <td class="table-td" style=""> {{ $data->graph_ind }}</td>
                            <!-- <td class="table-td" style=""> {{$data->test_group_id }}</td> -->
                            <td class="table-td" style="">{{$data->status ==1 ? "active" : "Inactive" }}</td>

                        </tr>
                        @endforeach
                        @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </section>
    </div>
</main>
</body>
</html>
