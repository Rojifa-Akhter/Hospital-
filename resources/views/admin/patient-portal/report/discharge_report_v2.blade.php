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
            <span style="">Printed By: {{ $userInfo->user_fullname }}</span> &nbsp;
            <span style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
            <span>Powered By: NEXTGEN IT</span>
        </div>
    </footer>

    <main>
        <div style="text-align: center;margin-bottom:5px;padding:5px; font-size:20px; text-transform: uppercase;">
            <strong style="border-bottom: 1px solid black;">Discharge Certificate</strong>
        </div>

        <div style="text-align: center;margin-bottom:5px;padding:5px; font-size:20px; text-transform: uppercase; margin-bottom: 10px; border: 1px solid black;">
            <strong>Department of {{ $discharge_data[0]->new_su_name }}</strong>
        </div>

        <table style="width: 100%; border:black solid 1px ; font-weight: bold; marign-bottom: 0px !important;">
            <tr style="line-height: 16px;">
                <td style="border: 1px solid black;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 10px;">Name of Consultant</td>
                <td style="border: 1px solid black;text-align: left;width: 100%; font-size: 14px; padding-left: 10px; padding-bottom: 2px;">{!! $discharge_data[0]->primary_doctor_signature !!}</td>
            </tr>
            <tr>
                <td colspan="2" style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding: 2px auto; padding-left: 10px;">Patient's Name: {{ $discharge_data[0]->patient_name }}. Age: {{ $discharge_data[0]->age }}yrs, Sex: {{ $discharge_data[0]->gender_txt }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding: 1px auto; padding-left: 10px;">Religion: {{ $discharge_data[0]->religion_txt }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding: 1px auto; padding-left: 10px;">Bed No: {{ $discharge_data[0]->bed_name }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding: 1px auto; padding-left: 10px;">Reg No: {{ $admission_details->admission_no_pk }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding: 1px auto; padding-left: 10px;">Address: {{ $admission_details->address }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding: 1px auto; padding-left: 10px;">Date of Admission: {{ date('d/m/Y', strtotime($discharge_data[0]->admission_date)) }}</td>
            </tr>
            <tr>
                <td colspan="2" style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding: 1px auto; padding-left: 10px;">Date of Discharge: {{ isset($discharge_data[0]->dis_date) ? date('d/m/Y', strtotime($discharge_data[0]->dis_date)) : '' }}</td>
            </tr>
        </table>
        
        <table style="width: 100%; border:black solid 1px ; font-weight: bold;">
            <tr>
                <td style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Diagnosis: {{ $admission_details->diagnosis }}</td>
            </tr>
        </table>

        <table style="width: 100%; border:black solid 1px ; marign-bottom: 0px !important;">
            <tr>
                <td style="border: 1px solid black;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px; font-weight: bold;">Patient's Status During Discharge</td>
                <td style="border: 1px solid black;text-align: left;width: 50%; font-size: 14px; padding-left: 8px; font-weight: bold;">Discharge Type</td>
            </tr>
            <tr>
                <td style="border: 1px solid black;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">{{ $admission_details->status_during_discharge }}</td>
                <td style="border: 1px solid black;text-align: left;width: 50%; font-size: 14px; padding-left: 8px;">{{ $admission_details->discharge_type }}</td>
            </tr>
            <tr>
                <td colspan="2" style="height: 40px; text-align: left;width: 100%; padding-top:0px; font-size: 14px; padding-left: 8px;"></td>
            </tr>
            <tr>
                <td colspan="2" style="border-bottom: none; height: 20px; text-align: center;width: 100%; padding-top:0px; font-size: 18px; font-weight: bold; padding-left: 8px;"><span style="border-bottom: 1px solid black;">Case Summary</span></td>
            </tr>
            <tr>
                <td colspan="2" style="border-top: none; height: 20px; text-align: left;width: 100%; padding-top:0px; font-size: 12px; padding-left: 8px;">
                    {!! $admission_details->case_summary_remarks !!}
                </td>
            </tr>
        </table>

        <table style="width: 100%; border:black solid 1px ; font-weight: bold;">
            <tr>
                <td style="border: 1xp solid black; text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Investiagation: 
                    {{ implode(", ", $investigation_data->pluck('investigation_name')->toArray()) }}
                </td>
            </tr>
            <tr>
                <td style="border: 1xp solid black; text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Treatment during hospitalization: {{ $admission_details->treatment_during_hospital }}</td>
            </tr>
            <tr>
                <td style="border: 1xp solid black; text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Conservative treatment given: {{ $admission_details->conservative_treatment }}</td>
            </tr>
            <tr>
                <td style="border: 1xp solid black; text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Special Note: {{ $admission_details->special_note }}</td>
            </tr>
            <tr>
                <td style="border: 1xp solid black; text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">{{ $admission_details->other_note }}</td>
            </tr>
        </table>

        <div>
            <div style="text-align: center;"> <strong style="border-bottom: 1px solid black;"> Treatment on Discharge: </strong></div>
            <div style=" margin-bottom:5px; margin-top:5px;">
                <strong class="report-name">Diet : </strong>
            </div>
            <table style="width: 100%; margin-top:5px">
                <tr>
                    <th width="10px">SL</th>
                    <th style="text-align: center;">Drugs</th>
                    <th style="text-align: center;">Frequency</th>
                    <th style="text-align: center;">Duration</th>
                    <th style="text-align: center;">Instruction</th>
                </tr>
                @foreach ($med_data as $index => $value)
                <tr>
                    <td style="text-align: center;">{{ ++$index }}</td>
                    <td style="text-align: left;">{{ $value->item_name }}</td>
                    <td style="text-align: center;">{{ $value->dosage }}</td>
                    <td style="text-align: center;">{{ $value->duration }}</td>
                    <td>{{ $value->med_taken_instruction != "0" ? $value->med_taken_instruction : "N/A" }}</td>
                </tr>
                @endforeach
            </table>
        <div>
      
        <div>
            <table style="width: 100%; border: none; font-weight: bold;" cellpadding="0" cellspacing="0">
                <tbody>
                    <tr>
                        <td style="width: 100%; text-align: left;border: none;">
                            <strong>Advice: </strong>
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

        <table style="width: 100%; border: none; font-weight: bold; marign-bottom: 0px !important; margin-top: 350px;">
            <tr style="line-height: 20px;">
                <td style="border: none;text-align: left;width: 100%; padding-top:0px; font-size: 14px; padding-left: 10px;">Doctor's Name: _________________________</td>
                <td style="border: none;text-align: left;width: 100%; font-size: 14px; padding-left: 10px; padding-bottom: 0px;">Counter Sign: _________________________</td>
            </tr>
            <tr style="line-height: 20px;">
                <td style="border: none;text-align: left;width: 100%; padding-top:0px; font-size: 14px; padding-left: 10px;">Signature & Date: _________________________</td>
                <td style="border: none;text-align: left;width: 100%; font-size: 14px; padding-left: 10px; padding-bottom: 0px;"></td>
            </tr>
        </table>
    </main>
</body>
</html>