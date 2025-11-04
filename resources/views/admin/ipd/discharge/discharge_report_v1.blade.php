<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>Discharge Certificate</title>
    <!-- Tell the browser to be responsive to screen width -->
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <!--<link rel="stylesheet" href="{{ asset('print/pdf.css') }}" media="all"> -->
    <!-- <link rel="stylesheet" href="css/invoice.css" media="all" /> -->
    <style type="text/css">
        /* footer {
            padding-bottom: 0px;
            position: fixed;
            bottom: 10;
        } */
        .footer {
            position: fixed;
            z-index: 999999999;

            left: 0;
            right: 0;
            height: 3.5cm;
            text-align: center;
            font-size: 9px;
            bottom: -130px;
            border-top: 1px solid black;
            padding-top: 10px;
        }

        .tank_you {
            padding-top: 450px;
        }

        .main_data {
            width: 100%;
        }

        .w-30 {
            width: 30%;
        }

        .w-20 {
            width: 20%;
        }

        .w-50 {
            width: 50%;
        }

        .w-100 {
            width: 100%;
        }

        .w-25 {
            width: 25%;
        }

        .w-40 {
            width: 40%;
        }

        /*@font-face {
  font-family: SourceSansPro;
  src: url(SourceSansPro-Regular.ttf);
}
*/
        @page {
            margin: 0.8cm;
            /*width: 450px;*/
            padding: 0px;
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }

        a {
            color: #60c57f;
            text-decoration: none;
        }

        body {
            /*position: relative;*/
            margin-top: 2.5cm;
            margin-bottom: 0cm;
            color: #555555;
            background: #ffffff;
            font-size: 14px;
            font-family: "IBM Plex Sans,Helvetica,Arial,sans-serif";
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            padding-bottom: 5px;
            border-bottom: 1px solid #222;
        }

        footer {
            /*position: fixed;*/
            bottom: 0.3cm;
            left: 0cm;
            right: 0cm;
            border-top: 1px solid #222;
            padding: 10px 0px;
            font-size: 12px;
        }

        #logo {
            float: left;
            margin-top: 8px;
        }

        #logo img {
            width: 70px;
        }

        #company {
            float: right;
            text-align: right;
            color: #fff;
        }

        #details {
            margin-bottom: 20px;
        }

        #client {
            padding-left: 10px;
            border-left: 4px solid #60c57f;
            float: left;
        }

        .name {
            font-size: 12px;
            margin: 2px 0px;
        }

        h2.name {
            font-size: 13px;
            font-weight: normal;
            margin: 0;
        }

        #invoice {
            float: right;
            text-align: right;
            /*background-color: #222;*/
        }

        /*
#invoice h1 {
  color: #fff;
  font-size: 2.4em;
  line-height: 1em;
  font-weight: normal;
  margin: 0  0 10px 0;
}
*/

        #company .name {
            color: #60c57f;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 0 0;
        }

        #company span {
            font-size: 1.1em;
            color: #222;
        }

        #invoice span {
            color: #60c57f;
            font-size: 2.4em;
            line-height: 1em;
            font-weight: normal;
            margin: 0 0 10px 0;
        }

        #invoice .date {
            font-size: 1.1em;
            color: #222;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #222;
            /* word-wrap: break-word;
            table-layout: fixed; */

        }

        table th {
            padding: 2px 5px;
            text-align: center;
            border: 1px solid #222;
            font-size: 12px;
        }

        table td {
            /* padding: 2px 5px; */
            /* text-align: center; */
            border: 1px solid #222;
            font-size: 12px;
        }

        table tr {
            border-bottom: 1px solid #222;

        }

        table th {
            /* white-space: nowrap; */
            /* background-color: gainsboro; */
            color: black;
            border-color: #222;
            padding: 2px 5px;
            /*font-weight: normal;*/
        }

        table td {
            /* text-align: right; */
            /* border-spacing: 10px; */
            /* padding: 0px 10px 0px 10px; */
        }

        table td h3 {
            color: #57b223;
            font-size: 1em;
            font-weight: normal;
            margin: 0 0 0.2em 0;
        }

        table .no {
            color: #ffffff;
            font-size: 1em;
            background: #57b223;
        }

        table .desc {
            text-align: left;
        }

        table .unit {
            background: #dddddd;
        }

        table .qty {}

        table .total {
            background: #57b223;
            color: #ffffff;
        }

        /*table td.unit,
table td.qty,
table td.total {
  font-size: 1em;
}
*/
        /*table tbody tr:last-child td {
    border: none;
    }*/

        table tfoot td {
            padding: 2px 5px;
            background: #ffffff;
            font-size: 12px;
            white-space: nowrap;
            /* border-top: 1px solid #AAAAAA; */
        }

        /*table tfoot tr:first-child {
    border-top: 1px solid #222;
    }*/
        /*

table tfoot tr:last-child td {
  color: #57B223;
  font-size: 1.4em;
  border-top: 1px solid #57B223;

}

table tfoot tr td:first-child {
  border: none;
  }*/

        .border-0 {
            border: 0px !important;
        }

        #thanks {
            font-size: 2em;
            margin-bottom: 50px;
        }

        #notices {
            padding-left: 6px;
            border-left: 6px solid #60c57f;
        }

        #notices .notice {
            font-size: 1.2em;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .text-center {
            text-align: center !important;
        }

        p {
            padding: 0px !important;
            margin: 0px !important;
            text-align: left !important;
            width: auto !important;

        }

        td {
            padding: 0px 5px 0px 5px;
        }
    </style>
</head>

<body>
    <header class="clearfix">

        {{-- <div style="float: left; width:20%; ">
            @if (!empty($po_hospital_details->logo))
                @if (!file_exists($po_hospital_details->logo))
                    <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        alt="No Logo Found" width="70px" />
                @else
                    <img src="images/kbmh.jpg" />
                @endif
            @else
                <img src="images/kbmh.jpg" />
            @endif
        </div> --}}
        <div style="float: left; text-align: center;width:100%; ">

            <span class="name" style="font-size: 20px; color: green;">{{ $po_hospital_details->hospital_name }}</span>
            <br>
            <span style="font-size: 10px;">Address: {{ $po_hospital_details->addrress1 }}</span> <br>
            <span style="font-size: 12px;">Phone No: {{ $po_hospital_details->telephone1 }}</span> <br>
        </div>


    </header>
    <footer class="footer">

        <?php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
        ?>
        <div class="">
            <span style=" float:left;">Prepared By: {{ $userInfo->user_fullname }}</span> &nbsp;
            <span style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
            <span style="float:right">Powered By: NEXTGEN IT</span>
        </div>
    </footer>

    <main style="width: 100%;">
        <div class="">
            {{-- <div style=" text-align: center; width:100%; margin-bottom:5px;">
                <span class="" style=" padding:25px; border:solid black 1px; border-left:1px solid black">
                    Discharge
                    Certificate
                </span>

            </div> --}}

            <div style="width:100%; margin-bottom:5px;"">
                <span class="" style=" padding:25px; border:solid black 1px; border-left:1px solid black">
                    Discharge
                    Certificate
                </span>
            </div>



            <table style=" width: 100%; border:darkgrey solid 1px ; ">

                <tr style="">
                    <td style="border: none;text-align: left;width: 100%; padding-top:5px"> <img style=""
                            src="data:image/png;base64, {{ $barcode_no }} " style="width: 150px; " /></td>
                    <td style="border: none;text-align: left;width: 100%;"></td>
                    <td style="border: none;text-align: left;width: 100%;"></td>
                    <td style="border: none;text-align: right;width: 100%; "> <img style=""
                            src="data:image/png;base64, {{ $patient_barcode_no }} "
                            style="width: 150px; padding-top:5px" /> </td>
                </tr>
                <tr>

                    <td style="border: none;text-align: left;width: 100%;">
                        <span class="reg-name" style="width:100%;"> <strong> Reg. No </strong><span
                                style="color: #3b8ab8;  "> </span>
                    </td>
                    <td style="border: none;text-align: left;width: 100%;">
                        @if (!empty($discharge_data[0]->admission_uid))
                            : {{ $discharge_data[0]->admission_uid }}
                        @else
                            .................
                        @endif
                    </td>
                    <td style="border: none;text-align: right;width: 100%;">
                        <span class="reg-name" style="width:100%;"> <strong> Patient Id </strong> <span
                                style="color: #3b8ab8;  "> </span>
                    </td>
                    <td style="border: none;text-align: left;width: 100%;">
                        @if (!empty($discharge_data[0]->patient_code))
                            : {{ $discharge_data[0]->patient_code }}
                        @else
                            .................
                        @endif
                    </td>
                </tr>
                <tr>
                    <td style="border: none;text-align: left;width: 100%;"> <strong> Patient Name </strong></td>
                    <td style="border: none;text-align: left;width: 100%;"> : {{ $discharge_data[0]->patient_name }}
                    </td>
                    <td style="border: none;text-align: right;width: 100%;"><strong> Gender </strong></td>
                    <td style="border: none;text-align: left;width: 100%;">: {{ $discharge_data[0]->gender_txt }}
                    </td>
                </tr>
                {{-- <tr>
                    @php
                        $gardian = '';
                        if ($discharge_data[0]->father_name != '') {
                            $gardian = $discharge_data[0]->father_name;
                        } elseif ($discharge_data[0]->father_name == '') {
                            $gardian = $discharge_data[0]->mother_name;
                        }
                    @endphp
                    <td style="border: none;text-align: left;width: 100%;"><strong> S/0. D/0. W/0 </strong> </td>
                    <td style="border: none;text-align: left;width: 100%;">: {{ $gardian }}</td>
                    <td style="border: none;text-align: right;width: 100%;"><strong> Age </strong> </td>
                    <td style="border: none;text-align: left;width: 100%;">: {{ $discharge_data[0]->age }}</td>

                </tr> --}}
                <tr>
                    <td style="border: none;text-align: left;width: 100%;"><strong> Address </strong> </td>
                    <td style="border: none;text-align: left;width: 100%;"> : {{ $discharge_data[0]->present_addr }}
                    </td>
                    <td style="border: none;text-align: right;width: 100%;"> <strong> Cabin/Bed No </strong> </td>
                    <td style="border: none;text-align: left;width: 100%;">: {{ $discharge_data[0]->bed_name }}</td>

                </tr>



                <tr>
                    <td style="border: none;text-align: left;width: 100%;"> <strong>Chief Complain</strong> </td>
                    <td style="border: none;text-align: left;width: 100%;">: {{ $discharge_data[0]->cc_text }}</td>
                    <td style="border: none;text-align: right;width: 100%;"> <strong> Admited Date </strong></td>
                    <td style="border: none;text-align: left;width: 100%;">:
                        {{ date('d/m/Y', strtotime($discharge_data[0]->admission_date)) }}</td>

                </tr>
                <tr>
                    <td style="border: none;text-align: left;width: 100%;"><strong> Doctor Name </strong> </td>
                    <td style="border: none;text-align: left;width: 100%;   word-wrap: break-word;"> :
                        {{ $discharge_data[0]->primary_doctor_name }} </td>
                    <td style="border: none;text-align: right;width: 100%;"> <strong> Discharge Date </strong></td>
                    <td style="border: none;text-align: left;width: 100%;">:
                        {{ isset($discharge_data[0]->dis_date) ? date('d/m/Y', strtotime($discharge_data[0]->dis_date)) : '' }}
                    </td>

                </tr>
            </table>

            @if ($admission_details->discharge_summary_note)

            <div style="   margin-top:5px;  margin-bottom:5px;">
                <div style="width:100%; ">
                    <span style="border:solid black 1px; border-left:solid black 1px;  padding:35px !important;  ">
                        Discharge summary note</span>
                </div>
            </div>

            <table style="table-layout: fixed; width: 100%; border:darkgrey solid 1px ;">
                <tr>

                    <td style="border: none;text-align: left !important;width: 100%;"> <?php echo $admission_details->discharge_summary_note; ?></td>
                </tr>
            </table>
            @endif

            @if (!$med_data->isEmpty())
                <div style="   margin-top:5px;  ">
                    <div style="width:100%; ">
                        <span style="border:solid black 1px; border-left:solid black 1px; padding:5px;left:0; ">Treatment On
                            Discharge With Advice</span>
                    </div>
                </div>

                @if (!$med_data->isEmpty() || !$investigation_data->isEmpty() || $admission_details->discharge_advice != '')
                    {{-- <div style=""> <strong> Medicine list </strong></div> --}}
                    <div style="   margin-top:5px;  margin-bottom:5px;  ">
                        <div style="width:100%; ">
                            <span style="border:solid black 1px; border-left:solid black 1px; padding:35px !important;">
                                Medicine list </span>
                        </div>
                    </div>
                    <table style="width: 100%; margin-top:5px">
                        <tr style="">
                            <th width="10px">SL</th>
                            <th>Medicine Name</th>
                            <th>Instruction</th>
                            <th>Dosage</th>
                            <th>Duration</th>
                        </tr>


                        @php
                            $sl = 1;
                        @endphp
                        @foreach ($med_data as $value)
                            <tr>
                                <td style="text-align: center ;">{{ $sl++ }}</td>
                                <td>{{ $value->item_name }}</td>
                                <td>
                                    @if (!empty($instructions))
                                        @foreach ($instructions as $key => $data)
                                            @if ($value->med_taken_instruction == $key)
                                                {{ $data }}
                                            @endif
                                        @endforeach
                                    @endif
                                </td>
                                <td>{{ $value->dosage }}</td>
                                <td>{{ $value->duration ? $value->duration . ' ' . 'Days' : '' }}</td>
                            </tr>
                        @endforeach

                    </table>
                @endif

                @if (!$investigation_data->isEmpty())


                    <div style="   margin-top:5px;  margin-bottom:5px;  ">
                        <div style="width:100%; ">
                            <span style="border:solid black 1px; border-left:solid black 1px; padding:35px !important;">
                                Investigation list</span>
                        </div>
                    </div>


                    <table style="width: 100%; margin-top:5px;
              ">
                        <thead>
                            <tr style="">
                                <th width="10px">SL</th>
                                <th> Name</th>
                                <th width="" style="table-layout: fixed; word-wrap: break-word">Findings</th>
                                <th width="">Investigation note</th>
                            </tr>
                        </thead>
                        <tbody>
                            @php
                                $sl = 1;
                            @endphp
                            @foreach ($investigation_data as $value)
                                <tr>
                                    <td style="text-align: center;">{{ $sl++ }}</td>
                                    <td>{{ $value->investigation_name }}</td>
                                    <td>{{ $value->findings_text }}</td>
                                    <td>{{ $value->investigation_note }}</td>
                                </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif
                @if ($admission_details->discharge_advice != '')
                    {{-- <div style=""> <strong> Advice </strong></div> --}}
                    <div style="   margin-top:5px;  margin-bottom:5px;  ">
                        <div style="width:100%; ">
                            <span style="border:solid black 1px; border-left:solid black 1px; padding:35px !important;">
                                Advice </span>
                        </div>
                    </div>
                    <table style="width: 100%; margin-top:5px">
                        <tr>
                            <td>
                                <div  style="text-align: left !important;">
                                    <?php
                                    echo $admission_details->discharge_advice;
                                    ?>
                                </div>

                            </td>
                        </tr>
                    </table>
                @endif
            @endif


            @if (!$receive_med_data->isEmpty() || $receive_investigation_data->isEmpty())
                <div style="">
                    <div style="margin-bottom:5px; margin-top:5px;  ">
                        <span class="report-name"
                            style="width:70%; border:solid black 1px; padding:25px; border-left:solid black 1px; padding:25px;  ">
                            Treatment Received
                        </span>
                    </div>

                    @if (!$receive_med_data->isEmpty())
                        <div style="text-align: center;"> <strong> Medicine list </strong></div>
                        <table style="width: 100%; margin-top:5px">
                            <tr style="">
                                <th width="10px">SL</th>
                                <th>Medicine Name</th>
                                <th>Instruction</th>
                                <th>Dosage</th>
                                <th>Duration</th>
                            </tr>


                            @php
                                $sl = 1;
                            @endphp
                            @foreach ($receive_med_data as $value)
                                <tr>
                                    <td style="text-align: center;">{{ $sl++ }}</td>
                                    <td>{{ $value->item_name }}</td>
                                    <td>
                                        @if (!empty($instructions))
                                            @foreach ($instructions as $key => $data)
                                                @if ($value->med_taken_instruction == $key)
                                                    {{ $data }}
                                                @endif
                                            @endforeach
                                        @endif
                                    </td>
                                    <td>{{ $value->dosage }}</td>
                                    <td>{{ $value->duration ? $value->duration . ' ' . 'Days' : '' }}</td>
                                </tr>
                            @endforeach

                        </table>
                    @endif

                    @if (!$receive_investigation_data->isEmpty())
                        {{-- <div style=""> <strong> Investigation list </strong></div> --}}
                        <div style="   margin-top:5px;  margin-bottom:5px;  ">
                            <div style="width:100%; ">
                                <span style="border:solid black 1px; border-left:solid black 1px; padding:35px !important;">
                                    Investigation list  </span>
                            </div>
                        </div>
                        <table style="width: 100%; margin-top:5px">
                            <tr style="">
                                <th width="10px">SL</th>
                                <th> Name</th>
                                <th width="">Findings</th>
                                <th width="">Investigation note</th>
                            </tr>

                            @php
                                $sl = 1;
                            @endphp
                            @foreach ($receive_investigation_data as $value)
                                <tr>
                                    <td style="text-align: center;">{{ $sl++ }}</td>
                                    <td>{{ $value->item_name }}</td>
                                    <td></td>
                                    <td></td>
                                </tr>
                            @endforeach
                        </table>
                    @endif
            @endif

            @if (!empty($discharge_data[0]->pre_ot_date) || !empty($discharge_data[0]->post_ot_date))
                <div style=" margin-bottom:5px; margin-top:5px;  ">
                    <span class="report-name"
                        style="width:70%; border:solid black 1px; border-left:solid black 1px; padding:25px; ">
                        Operation
                        Note
                    </span>
                </div>
                @if (!empty($discharge_data[0]->pre_ot_date))
                    {{-- <div style="text-align: center;"> <strong> OT Details </strong></div> --}}
                    <div style="   margin-top:5px;  margin-bottom:5px;  ">
                        <div style="width:100%; ">
                            <span style="border:solid black 1px; border-left:solid black 1px; padding:35px !important;">
                                OT Details </span>
                        </div>
                    </div>

                    <table style="width:100%;">

                        <tr>
                            <td style="border: none;text-align: left;width: 25%;"> <strong> OT Date </strong></td>
                            <td style="border: none;text-align: left;width: 100%;"> :
                                {{ $discharge_data[0]->pre_ot_date ? date('d-m-Y', strtotime($discharge_data[0]->pre_ot_date)) : '' }}
                            </td>


                        </tr>
                        <tr>
                            <td style="border: none;text-align: left;width: 25%;"><strong> OT Time </strong> </td>
                            <td style="border: none;text-align: left;width: 100%;"> :
                                {{ $discharge_data[0]->pre_ot_time ? date('h:i A', strtotime($discharge_data[0]->pre_ot_time)) : '' }}
                            </td>

                        </tr>

                        <tr>
                            <td style="border: none;text-align: left;width: 25%;"> <strong> Anaesthesia Name </strong>
                            </td>
                            <td style="border: none;text-align: left;width: 100%;"> :
                                {{ $discharge_data[0]->pre_anaesthesia_doc_name }}</td>

                        </tr>
                        <tr>
                            <td style="border: none;text-align: left;width: 25%;"> <strong> Surgeon Name </strong></td>
                            <td style="border: none;text-align: left;width: 100%;"> :
                                {{ $discharge_data[0]->pre_surgeon_doc_name }}</td>
                        </tr>
                        <tr>
                            <td style="border: none;text-align: left;width: 25%;"> <strong> Anaesthetist Name </strong>
                            </td>
                            <td style="border: none;text-align: left;width: 100%;"> :
                                {{ $discharge_data[0]->pre_anaesthetist_doc_name }}</td>
                        </tr>
                        <tr>
                            <td style="border: none;text-align: left;width: 25%;"><strong> OT Operation </strong></td>
                            <td style="border: none;text-align: left;width: 100%;"> :
                                {{ $discharge_data[0]->pre_ot_operation }}</td>

                        </tr>

                        <tr>
                            <td style="border: none;text-align: left;width: 25%;"><strong> OT Indication </strong>
                            </td>
                            <td style="border: none;text-align: left;width: 100%;"> :
                                {{ $discharge_data[0]->pre_ot_indication }} </td>
                        </tr>
                    </table>
                @endif
                @if ($admission_details->pre_ot_note)
                    {{-- <div style="">
                        <strong> OT Note </strong>
                    </div> --}}

                    <div style="   margin-top:5px;  margin-bottom:5px;  ">
                        <div style="width:100%; ">
                            <span style="border:solid black 1px; border-left:solid black 1px; padding:35px !important;">
                                OT Note </span>
                        </div>
                    </div>
                    <table style="width:100%">

                        <tr>
                            <td style="border: none;width: 10%;"> Pre OT Note</td>
                            <td style="border: none;width: 80%;">

                                <?php echo $admission_details->pre_ot_note; ?>
                            </td>
                        </tr>
                        @if ($admission_details->post_ot_note)
                            <tr>

                                <td style="border: none;width: 10%;"> Post OT Note</td>
                                <td style="border: none;width: 80%;">

                                    <?php echo $admission_details->post_ot_note; ?>
                                </td>
                            </tr>
                        @endif

                    </table>
                @endif
                {{-- Commented --}}
                @if (!empty($discharge_data[0]->post_ot_date))

                {{-- <div style="text-align: center;"> <strong> Post OT </strong></div> --}}
                <div style="   margin-top:5px;  margin-bottom:5px;  ">
                    <div style="width:100%; ">
                        <span style="border:solid black 1px; border-left:solid black 1px; padding:35px !important;">
                            Post OT </span>
                    </div>
                </div>


                <table style="width:100% ;">
                    <tr>
                        <td style="border: none;text-align: left;width: 25%;"> <strong> OT Date </strong></td>
                        <td style="border: none;text-align: left;width: 100%;"> :
                            {{ $discharge_data[0]->post_ot_date ? date('d-m-Y', strtotime($discharge_data[0]->post_ot_date)) : '' }}
                        </td>


                    </tr>
                    <tr>
                        <td style="border: none;text-align: left;width: 25%;"><strong> OT Time </strong> </td>
                        <td style="border: none;text-align: left;width: 100%;"> :
                            {{ $discharge_data[0]->post_ot_time ? date('h:i A', strtotime($discharge_data[0]->post_ot_time)) : '' }}
                        </td>

                    </tr>

                    <tr>
                        <td style="border: none;text-align: left;width: 25%;"> <strong> Anaesthesia Name </strong> </td>
                        <td style="border: none;text-align: left;width: 100%;"> :
                            {{ $discharge_data[0]->post_anaesthesia_doc_name }}</td>

                    </tr>
                    <tr>
                        <td style="border: none;text-align: left;width: 25%;"> <strong> Surgeon Name </strong></td>
                        <td style="border: none;text-align: left;width: 100%;"> :
                            {{ $discharge_data[0]->post_surgeon_doc_name }}</td>
                    </tr>
                    <tr>
                        <td style="border: none;text-align: left;width: 25%;"> <strong> Anaesthetist Name </strong></td>
                        <td style="border: none;text-align: left;width: 100%;"> :
                            {{ $discharge_data[0]->post_anaesthetist_doc_name }}</td>
                    </tr>
                    <tr>
                        <td style="border: none;text-align: left;width: 25%;"><strong> OT Operation </strong></td>
                        <td style="border: none;text-align: left;width: 100%;"> :
                            {{ $discharge_data[0]->post_ot_operation }}</td>

                    </tr>

                    <tr>
                        <td style="border: none;text-align: left;width: 25%;"><strong> OT Indication </strong> </td>
                        <td style="border: none;text-align: left;width: 100%;"> :
                            {{ $discharge_data[0]->post_ot_indication }} </td>
                    </tr>
                </table>
            @endif


                {{-- <div style="text-align: center;"><strong>Post OT Note </strong>
                </div> --}}

            @endif

        </div>

        @if ($discharge_data[0]->first_baby_birthdate != null || $discharge_data[0]->second_baby_birthdate != null)
            <div style="">
                <div style=" margin-bottom:5px; margin-top:20px;  ">
                    <span class="report-name"
                        style="width:70%; border:solid black 1px; border-left:solid black 1px; padding:25px;"> Baby
                        Info
                    </span>
                </div>
                <div>
                    @if ($discharge_data[0]->first_baby_birthdate)
                        {{-- <div style="text-align: center;"> <strong> First Baby Note </strong></div> --}}


                        <div style="   margin-top:5px;  margin-bottom:5px;  ">
                            <div style="width:100%; ">
                                <span style="border:solid black 1px; border-left:solid black 1px; padding:35px !important;">
                                    First Baby Note </span>
                            </div>
                        </div>
                        <table style="table-layout: fixed; width: 100%; border:darkgrey solid 1px ;">
                            <tr>
                                <td style="border: none;text-align: left;width: 30%;"> <strong> First baby birth date
                                    </strong></td>
                                <td style="border: none;text-align: left;width: 100%;"> :
                                    {{ $discharge_data[0]->first_baby_birthdate ? date('d-m-Y', strtotime($discharge_data[0]->first_baby_birthdate)) : '' }}
                                </td>

                            </tr>
                            <tr>
                                <td style="border: none;text-align: left;width: 30%;"> <strong> First baby birth time
                                    </strong></td>
                                <td style="border: none;text-align: left;width: 100%;">:
                                    {{ $discharge_data[0]->first_baby_time ? date('h:i A', strtotime($discharge_data[0]->first_baby_time)) : '' }}
                                </td>

                            </tr>
                            <tr>
                                <td style="border: none;text-align: left;width: 30%;"> <strong> First baby gender
                                    </strong></td>
                                <td style="border: none;text-align: left;width: 100%;">:
                                    {{ $discharge_data[0]->first_baby_gender_text }}</td>

                            </tr>
                            <tr>
                                <td style="border: none;text-align: left;width: 30%;"> <strong> First baby WT </strong>
                                </td>
                                <td style="border: none;text-align: left;width: 100%;">:
                                    {{ $discharge_data[0]->first_baby_wt }}</td>

                            </tr>
                            <tr>
                                <td style="border: none;text-align: left;width: 30%;"> <strong> First baby A/S
                                    </strong>
                                </td>
                                <td style="border: none;text-align: left;width: 100%;">:
                                    {{ $discharge_data[0]->first_baby_as }}</td>

                            </tr>
                            <tr>
                                <td style="border: none;text-align: left;width: 30%;"> <strong> First baby note
                                    </strong></td>
                                <td style="border: none;text-align: left;width: 100%;">: <?php echo $admission_details->first_baby_note; ?></td>

                            </tr>

                        </table>
                    @endif
                    @if ($discharge_data[0]->second_baby_birthdate)
                        {{-- <div style=""> <strong> Second Baby Note </strong></div> --}}
                        <div style="   margin-top:5px;  margin-bottom:5px;  ">
                            <div style="width:100%; ">
                                <span style="border:solid black 1px; border-left:solid black 1px; padding:35px !important;">
                                    Second Baby Note</span>
                            </div>
                        </div>
                        <table style="table-layout: fixed; width: 100%; border:darkgrey solid 1px ;">
                            <tr>

                                <td style="border: none;text-align: left;width: 30%;">
                                    <strong>{{ $discharge_data[0]->second_baby_birthdate ? '  Second baby birth date  ' : '' }}</strong>
                                </td>
                                <td style="border: none;text-align: left;width: 100%;"> :
                                    {{ $discharge_data[0]->second_baby_birthdate ? date('d-m-Y', strtotime($discharge_data[0]->second_baby_birthdate)) : '' }}
                                </td>
                            </tr>
                            <tr>

                                <td style="border: none;text-align: left;width: 30%;"><strong>
                                        {{ $discharge_data[0]->second_baby_time ? '  Second baby birth time   ' : '' }}</strong>
                                </td>
                                <td style="border: none;text-align: left;width: 100%;"> :
                                    {{ $discharge_data[0]->second_baby_time ? date('H:i A', strtotime($discharge_data[0]->second_baby_time)) : '' }}
                                </td>
                            </tr>
                            <tr>

                                <td style="border: none;text-align: left;width: 30%;">
                                    <strong>{{ $discharge_data[0]->second_baby_gender_no ? '  Second baby gender  ' : '' }}
                                    </strong>
                                </td>
                                <td style="border: none;text-align: left;width: 100%;"> :
                                    {{ $discharge_data[0]->second_baby_gender_text }}</td>
                            </tr>
                            <tr>

                                <td style="border: none;text-align: left;width: 30%;"><strong>
                                        {{ $discharge_data[0]->second_baby_wt ? '  Second baby WT  ' : '' }}</strong>
                                </td>
                                <td style="border: none;text-align: left;width: 100%;"> :
                                    {{ $discharge_data[0]->second_baby_wt }}</td>
                            </tr>
                            <tr>

                                <td style="border: none;text-align: left;width: 30%;">
                                    <strong>{{ $discharge_data[0]->second_baby_as ? '  Second baby A/S  ' : '' }}</strong>
                                </td>
                                <td style="border: none;text-align: left;width: 100%;"> :
                                    {{ $discharge_data[0]->second_baby_as }}</td>
                            </tr>
                            <tr>

                                <td style="border: none;text-align: left;width: 30%;">
                                    <strong>{{ $admission_details->second_baby_note ? '  Second baby note  ' : '' }}</strong>
                                </td>
                                <td style="border: none;text-align: left;width: 100%;"> : <?php echo $admission_details->second_baby_note; ?></td>
                            </tr>

                        </table>
                    @endif
                </div>
            </div>
        @endif


        @if (
            !empty($admission_details->cc_text) ||
                !empty($admission_details->oe_admission) ||
                !empty($admission_details->oe_discharge))
            <div style=" margin-bottom:5px; margin-top:5px;  ">
                <span class="report-name"
                    style="width:70%; border:solid black 1px; padding:25px; border-left:solid black 1px; padding:25px; ">
                    Case Summary & Investigation
                </span>
            </div>


            <table style="table-layout: fixed; width: 100%; border:darkgrey solid 1px ;">
                <tr>
                    <td style="border: none;text-align: left;width: 35%;"><strong>CC</strong> </td>
                    <td style="border: none;text-align: left;width: 100%;"> : {{ $admission_details->cc_text }}</td>
                </tr>
                <tr>
                    <td style="border: none;text-align: left;width: 35%;"><strong>O/E Admission</strong> </td>
                    <td style="border: none;text-align: left;width: 100%;"> : {{ $admission_details->oe_admission }}
                    </td>
                </tr>
                <tr>
                    <td style="border: none;text-align: left;width: 35%;"><strong>O/E ON Discharge/Treatment</strong>
                    </td>
                    <td style="border: none;text-align: left;width: 100%;"> : {{ $admission_details->oe_discharge }}
                    </td>
                </tr>
                <tr>
                    <td style="border: none;text-align: left;width: 35%;"><strong>Diagnosis / Disease</strong> </td>
                    <td style="border: none;text-align: left;width: 100%;"> : {{ $admission_details->disesase_name }}
                    </td>
                </tr>
            </table>
        @endif


        <div>
            <table style="width: 100%; border: none; " cellpadding="0" cellspacing="0">
                <tbody>

                    <tr>
                        <td style="width: 100%; text-align: left;border: none;">
                            <strong>Important Notes</strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%; text-align: left;border: none;"> * Please go through carefully all the
                            instructions and advice mentioned in this certificate.</td>
                    </tr>
                    <tr>
                        <td style="width: 100%; text-align: left;border: none;"> * If needed in an emergency, contact
                            us or your consultant (as mentioned on the first page of this certificate).</td>
                    </tr>
                    <tr>
                        <td style="width: 100%; text-align: left;border: none;"> * Please preserve this certificate and
                            any other papers relating to treatment for further reference.</td>
                    </tr>
                </tbody>
            </table>
        </div>

<br>
<br>
<br>
<br>
<br>
<br>

        <div>
            <table style="width: 100%; border: none; " cellpadding="0" cellspacing="0">
                <tbody>

                    <tr>
                        <td style="width: 100%; text-align: right;border: none;">
                            <strong>Signature Of Medical Officer</strong>
                        </td>
                    </tr>
                </tbody>
            </table>
        </div>

        </div>
    </main>



</body>

</html>
