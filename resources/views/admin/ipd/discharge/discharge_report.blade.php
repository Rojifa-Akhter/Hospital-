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

        @page {
            /* margin: 0.8cm; */
            /*width: 450px;*/
            /* padding: 0px; */
        }

        .clearfix:after {
            content: "";
            display: table;
            clear: both;
        }


        body {
            /*position: relative;*/
            margin-top: 2.5cm;
            margin-bottom: 0cm;
            color: black;
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

        #logo {
            float: left;
            margin-top: 8px;
        }

        #logo img {
            width: 70px;
        }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 20px;
            border: 1px solid #222;
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

        table tr th {
            border: 1px solid #222;
        }

        td {
            padding: 0px 5px 0px 5px;
        }
    </style>
</head>

<body>

    <header class="clearfix">

        <div style="float: left; width: 20%; ">
            @if (!empty($po_hospital_details->logo))
            @if (!file_exists($po_hospital_details->logo))
            <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" alt="No Logo Found" width="70px" />
            @else
            <img src="images/kbmh.jpg" />
            @endif
            @else
            <img src="images/kbmh.jpg" />
            @endif
        </div>
        <div style="float: left; text-align: center; width: 60%;">
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
            <span style="">Prepared By: {{ $userInfo->user_fullname }}</span> &nbsp;
            <span style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
            <span>Powered By: NEXTGEN IT</span>
        </div>
    </footer>

    <main>

        <div style="text-align: center;margin-bottom:5px;padding:5px; font-size:20px">
            <strong>Discharge Certificate</strong>
        </div>
        <table style=" width: 100%; border:darkgrey solid 1px ; ">

            <tr style="">
                <td style="border: none;text-align: left;width: 100%; padding-top:5px"> <img style="" src="data:image/png;base64, {{ $barcode_no }} " style="width: 150px; " /></td>
                <td style="border: none;text-align: left;width: 100%;"></td>
                <td style="border: none;text-align: left;width: 100%;"></td>
                <td style="border: none;text-align: right;width: 100%; "> <img style="" src="data:image/png;base64, {{ $patient_barcode_no }} " style="width: 150px; padding-top:5px" /> </td>
            </tr>
            <tr>

                <td style="border: none;text-align: left;width: 100%;">
                    <span class="reg-name" style="width:100%;"> <strong> Reg. No </strong><span style="color: #3b8ab8;  "> </span>
                </td>
                <td style="border: none;text-align: left;width: 100%;">
                    @if (!empty($discharge_data[0]->admission_uid))
                    : {{ $discharge_data[0]->admission_uid }}
                    @else
                    .................
                    @endif
                </td>
                <td style="border: none;text-align: right;width: 100%;">
                    <span class="reg-name" style="width:100%;"> <strong> Patient Id </strong> <span style="color: #3b8ab8;  "> </span>
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
            <tr>
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

            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 100%;"><strong> Address </strong> </td>
                <td style="border: none;text-align: left;width: 100%;"> : {{ $discharge_data[0]->present_addr }}</td>
                <td style="border: none;text-align: right;width: 100%;"> <strong> Cabin/Bed No </strong> </td>
                <td style="border: none;text-align: left;width: 100%;">: {{ $discharge_data[0]->bed_name }}</td>

            </tr>

            <tr>

                <td style="border: none;text-align: left;width: 100%;"> <strong> Admited Date </strong></td>
                <td style="border: none;text-align: left;width: 100%;"> : {{ date('d/m/Y', strtotime($discharge_data[0]->admission_date)) }}</td>
                <td style="border: none;text-align: right;width: 100%;"> <strong> Discharge Date </strong></td>
                <td style="border: none;text-align: left;width: 100%;"> : {{ isset($discharge_data[0]->dis_date) ? date('d/m/Y', strtotime($discharge_data[0]->dis_date)) : '' }}
                </td>
            </tr>
            <tr>

                <td style="border: none;text-align: left;width: 100%;"><strong> Doctor Name </strong> </td>
                <td style="border: none;text-align: left;width: 100%; word-wrap: break-word;" colspan="3"> : {{ $discharge_data[0]->primary_doctor_name }}</td>
            </tr>
        </table>

        @if ($admission_details->discharge_summary_note || !$investigation_data->isEmpty() || $admission_details->discharge_advice)
        <div style=""><strong>Discharge summary note : </strong>
            <table style="table-layout: fixed; width: 100%; border:darkgrey solid 1px ;">
                <tr>
                    <td style="border: none;text-align: left;width: 100%;"> <?php echo $admission_details->discharge_summary_note; ?></td>
                </tr>
            </table>
        </div>
        @endif

        @if (!$med_data->isEmpty())
        <div style="margin-top:5px;">
            <div style="width:100%;">
                <strong style="">Treatment On Discharge With Advice : </strong>
            </div>
        </div>

        @if (!$med_data->isEmpty() || !$investigation_data->isEmpty() || $admission_details->discharge_advice != '')
        <div style="text-align: center;"> <strong> Medicine list </strong></div>
        <table style="width: 100%; margin-top:5px">
            <tr style="">
                <th width="10px">SL</th>
                <th style="text-align: left;">Medicine Name</th>
                <th style="text-align: left;">Instruction</th>
                <th>Dosage</th>
                <th style="text-align: left;">Duration</th>
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
                <td style="text-align: center;">{{ $value->dosage }}</td>
                <td>{{ $value->duration ? $value->duration . ' ' . 'Days' : '' }}</td>
            </tr>
            @endforeach

        </table>
        @endif

        @if (!$investigation_data->isEmpty())
        <div style="text-align: center;"> <strong> Investigation list </strong></div>
        <table style="width: 100%; margin-top:5px;
              ">
            <thead>
                <tr style="">
                    <th width="10px">SL</th>
                    <th style="text-align: left;"> Name</th>
                    <th width="" style="table-layout: fixed; word-wrap: break-word;text-align: left;">Findings</th>
                    <th style="text-align: left;">Investigation note</th>
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
        <div style="text-align: center;"> <strong> Advice </strong></div>
        <table style="width: 100%; margin-top:5px">
            <tr>
                <td width="100%">
                    <?php
                    echo $admission_details->discharge_advice;
                    ?>
                </td>
            </tr>
        </table>
        @endif
        @endif


        @if (!$receive_med_data->isEmpty() || !$receive_investigation_data->isEmpty())
        <div style="">
            <div style=" margin-bottom:5px; margin-top:5px;  ">
                <strong class="report-name">Treatment Received : </strong>
            </div>

            @if (!$receive_med_data->isEmpty())
            <div style="text-align: center;"> <strong> Medicine list </strong></div>
            <table style="width: 100%; margin-top:5px">
                <tr style="">
                    <th width="10px">SL</th>
                    <th style="text-align: left;">Medicine Name</th>
                    <th style="text-align: left;">Instruction</th>
                    <th>Dosage</th>
                    <th style="text-align: left;">Duration</th>
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
                    <td style="text-align: center;">{{ $value->dosage }}</td>
                    <td>{{ $value->duration ? $value->duration . ' ' . 'Days' : '' }}</td>
                </tr>
                @endforeach

            </table>
            @endif

            @if (!$receive_investigation_data->isEmpty())
            <div style="text-align: center;"> <strong> Investigation list </strong></div>
            <table style="width: 100%; margin-top:5px">
                <tr style="">
                    <th width="10px">SL</th>
                    <th style="text-align: left;"> Name</th>
                    <th style="text-align: left;">Findings</th>
                    <th style="text-align: left;">Investigation note</th>
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
            <div style="margin-bottom:5px; margin-top:5px;  ">
                <strong class="report-name" style="">Operation Note : </strong>
            </div>
            @if (!empty($discharge_data[0]->pre_ot_date))
            <div style="text-align: center;"> <strong> OT Details </strong></div>
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
                        {{ $discharge_data[0]->pre_anaesthesia_doc_name }}
                    </td>

                </tr>
                <tr>
                    <td style="border: none;text-align: left;width: 25%;"> <strong> Surgeon Name </strong></td>
                    <td style="border: none;text-align: left;width: 100%;"> :
                        {{ $discharge_data[0]->pre_surgeon_doc_name }}
                    </td>
                </tr>
                <tr>
                    <td style="border: none;text-align: left;width: 25%;"> <strong> Anaesthetist Name </strong>
                    </td>
                    <td style="border: none;text-align: left;width: 100%;"> :
                        {{ $discharge_data[0]->pre_anaesthetist_doc_name }}
                    </td>
                </tr>
                <tr>
                    <td style="border: none;text-align: left;width: 25%;"><strong> OT Operation </strong></td>
                    <td style="border: none;text-align: left;width: 100%;"> :
                        {{ $discharge_data[0]->pre_ot_operation }}
                    </td>

                </tr>

                <tr>
                    <td style="border: none;text-align: left;width: 25%;"><strong> OT Indication </strong>
                    </td>
                    <td style="border: none;text-align: left;width: 100%;"> :
                        {{ $discharge_data[0]->pre_ot_indication }}
                    </td>
                </tr>
            </table>
            @endif
            @if ($admission_details->pre_ot_note)
            <div style="text-align: center;">
                <strong> OT Note </strong>
            </div>
            <table style="width:100%">

                <tr>
                    <td style="border: none;width: 10%;"> Pre OT Note <span style="float:right">:</span></td>
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
            {{-- @if (!empty($discharge_data[0]->post_ot_date))

                <div style="text-align: center;"> <strong> Post OT </strong></div>
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
                    {{ $discharge_data[0]->post_anaesthesia_doc_name }}
                </td>

            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 25%;"> <strong> Surgeon Name </strong></td>
                <td style="border: none;text-align: left;width: 100%;"> :
                    {{ $discharge_data[0]->post_surgeon_doc_name }}
                </td>
            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 25%;"> <strong> Anaesthetist Name </strong></td>
                <td style="border: none;text-align: left;width: 100%;"> :
                    {{ $discharge_data[0]->post_anaesthetist_doc_name }}
                </td>
            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 25%;"><strong> OT Operation </strong></td>
                <td style="border: none;text-align: left;width: 100%;"> :
                    {{ $discharge_data[0]->post_ot_operation }}
                </td>

            </tr>

            <tr>
                <td style="border: none;text-align: left;width: 25%;"><strong> OT Indication </strong> </td>
                <td style="border: none;text-align: left;width: 100%;"> :
                    {{ $discharge_data[0]->post_ot_indication }}
                </td>
            </tr>
            </table>
            @endif --}}


            {{-- <div style="text-align: center;"><strong>Post OT Note </strong>
                </div> --}}
        </div>
        @endif


        @if (!empty($admission_details->cc_text) ||!empty($admission_details->oe_admission) || !empty($admission_details->oe_discharge))
        <div style="margin-bottom:5px; margin-top:5px;  ">
            <strong class="report-name" style="">Case Summary : </strong>
        </div>
        <table style="table-layout: fixed; width: 100%; border:darkgrey solid 1px ;">
            <tr>
                <td style="border: none;text-align: left;width: 25%;"><strong>CC</strong> </td>
                <td style="border: none;text-align: left;width: 100%;"> : {{ $admission_details->cc_text }}</td>
            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 25%;"><strong>O/E Admission</strong> </td>
                <td style="border: none;text-align: left;width: 100%;"> : {{ $admission_details->oe_admission }}
                </td>
            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 25%;"><strong>O/E Discharge</strong> </td>
                <td style="border: none;text-align: left;width: 100%;"> : {{ $admission_details->oe_discharge }}
                </td>
            </tr>
        </table>
        @endif
        @if ($discharge_data[0]->first_baby_birthdate != null || $discharge_data[0]->second_baby_birthdate != null)
        <div style="">
            <div style="margin-bottom:5px; margin-top:20px;  ">
                <strong class="report-name" style=""> Baby Info : </strong>
            </div>
            <div>
                @if ($discharge_data[0]->first_baby_birthdate)
                <div style="text-align: center;"> <strong> First Baby Note </strong></div>
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
                            {{ $discharge_data[0]->first_baby_gender_text }}
                        </td>

                    </tr>

                    <tr>
                        <td style="border: none;text-align: left;width: 30%;"> <strong> First baby WT </strong>
                        </td>
                        <td style="border: none;text-align: left;width: 100%;">:
                            {{ $discharge_data[0]->first_baby_wt }}
                        </td>

                    </tr>


                    <tr>
                        <td style="border: none;text-align: left;width: 30%;"> <strong> First baby A/S
                            </strong>
                        </td>
                        <td style="border: none;text-align: left;width: 100%;">:
                            {{ $discharge_data[0]->first_baby_as }}
                        </td>

                    </tr>

                    <tr>
                        <td style="border: none;text-align: left;width: 30%;"> <strong> First baby note
                            </strong></td>
                        <td style="border: none;text-align: left;width: 70%;">: <?php echo $admission_details->first_baby_note; ?></td>

                    </tr>

                </table>
                @endif
                @if ($discharge_data[0]->second_baby_birthdate)
                <div style="text-align: center;"> <strong> Second Baby Note </strong></div>
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
                            {{ $discharge_data[0]->second_baby_gender_text }}
                        </td>
                    </tr>
                    <tr>

                        <td style="border: none;text-align: left;width: 30%;"><strong>
                                {{ $discharge_data[0]->second_baby_wt ? '  Second baby WT  ' : '' }}</strong>
                        </td>
                        <td style="border: none;text-align: left;width: 100%;"> :
                            {{ $discharge_data[0]->second_baby_wt }}
                        </td>
                    </tr>
                    <tr>

                        <td style="border: none;text-align: left;width: 30%;">
                            <strong>{{ $discharge_data[0]->second_baby_as ? '  Second baby A/S  ' : '' }}</strong>
                        </td>
                        <td style="border: none;text-align: left;width: 100%;"> :
                            {{ $discharge_data[0]->second_baby_as }}
                        </td>
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


    </main>



</body>

</html>