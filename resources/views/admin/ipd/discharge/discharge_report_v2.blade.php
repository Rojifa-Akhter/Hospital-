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
            bottom: -110px;
            border-top: 1px solid black;
            padding-top: 10px;
        }

        @page {
            /* margin: 0.8cm; 
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
        #advice-table tr td {
           border-bottom: none;
         
        }
    </style>
</head>

<body onload="window.print()">
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

                    <table style="width: 100%; border:1px solid #999; border-radius:10px; font-size: 13px;">
                        <tr>
                            <td width="20%" style="padding-left:20px;padding-right:20px; border: none;"><strong>Patient
                                    Name</strong>
                            </td>
                            <td width="2%" style="padding-left:10px;padding-right:10px; border: none;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px; border: none;" width="40%">
                                {{ $discharge_data[0]->patient_name }}
                            </td>

                            <td width="20%" style="padding-left:20px;padding-right:20px; border: none;"><strong>Patient
                                    ID</strong></td>
                            <td width="2%" style="padding-left:10px;padding-right:10px; border: none;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px; border: none;">
                                {{ $discharge_data[0]->patient_no_fk }}
                            </td>
                        </tr>



                        <tr>
                            <td width="10%" style="padding-left:20px;padding-right:20px; border: none;"><strong>Age
                                </strong>
                            </td>
                            <td width="2%" style="padding-left:10px;padding-right:10px; border: none;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px; border: none;">
                                {{ $discharge_data[0]->age }}
                            </td>

                            <td width="15%" style="padding-left:20px;padding-right:20px; border: none; white-space: nowrap;"><strong>Date of Admission</strong></td>
                            <td width="2%" style="padding-left:10px;padding-right:10px; border: none;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px; border: none;">
                                {{ date('d/m/Y', strtotime($discharge_data[0]->admission_date)) }}
                            </td>

                        </tr>
                        <tr>


                            <td width="15%" style="text-align: left;padding-left:20px;padding-right:20px; border: none;">
                                <strong>Gender </strong>
                            </td>
                            <td width="2%" style="padding-left:10px;padding-right:10px; border: none;">:</td>
                            <td width="15%" style="text-align: left;padding-left:10px;padding-right:10px; border: none;">
                                {{ $discharge_data[0]->gender_txt }}
                            </td>

                            <td width="15%" style="padding-left:20px;padding-right:20px; border: none;"><strong>Date of Discharge</strong></td>
                            <td width="2%" style="padding-left:10px;padding-right:10px; border: none;">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px; border: none; white-space: nowrap;">
                                @if(!empty($discharge_data[0]->dis_date))
                                    {{ \Carbon\Carbon::parse($discharge_data[0]->dis_date)->format('d/m/Y') }}
                                @else
                                    Not Discharged
                                @endif

                            </td>
                            

                        </tr>
                       <tr>
                        <td width="15%" style="text-align: left;padding-left:20px;padding-right:20px; border: none;">
                            <strong>Doctor Name</strong>
                        </td>
                        <td width="2%" style="padding-left:10px;padding-right:10px; border: none;">:</td>
                        <td width="30%" style="text-align: left;padding-left:10px;padding-right:10px; border: none;">
                            {{ $discharge_data[0]->primary_doctor_name }}
                        </td>

                        <td width="20%" style="padding-left:20px;padding-right:20px; border: none;"><strong>Admission No</strong></td>
                        <td width="2%" style="padding-left:10px;padding-right:10px; border: none;">:</td>
                        <td width="30%" style="text-align: left;padding-left:10px;padding-right:10px; border: none;">
                            {{ $discharge_data[0]->admission_no_pk }}
                        </td>
                        </tr>
                        <tr>
                        <td width="35%" style="text-align: left;padding-left:20px;padding-right:20px; border: none;">
                            <strong>Company(Corporate Client) </strong>
                        </td>
                        <td width="2%" style="padding-left:10px;padding-right:10px; border: none;">:</td>
                        <td width="30%" style="text-align: left;padding-left:10px;padding-right:10px; border: none;">
                            {{-- {{ $discharge_data[0]-> }} --}}
                        </td>

                        </tr>

                    </table>
                    <table style="width: 100%; border:1px solid #999; border-radius:10px; font-size: 13px;">
                        <tr>
                            <td width="20%" style="padding-left:20px;padding-right:20px; border: none; ">
                                <strong>Treating Doctor’s Information:</strong>
                            </td>
                            <td width="2%" style="padding-left:10px;padding-right:10px; border: none;">:</td>
                            <td style="text-align: left; padding-left:10px; padding-right:10px; border: none;">
                                {{ strip_tags($discharge_data[0]->primary_doctor_signature) }}
                            </td>

                        </tr>

                    </table>
        
        <table style="width: 100%; border:black solid 1px ; font-weight: bold;  border-collapse: collapse;">
            <h2>Name of treating Department </h2>
            <tr>
                <td style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Diagnosis: {{ $admission_details->diagnosis }}</td>
            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Allergies: {{ $admission_details->adm_form_allergies }}</td>
            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Patient Current Clinical History: {{ $admission_details->adm_form_past_med_hist }}</td>
            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Local Examination: {{ $admission_details->pat_condition }}</td>
            </tr>
             <tr>
                <td style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Operative notes (if surgery patient): {{ $admission_details->adm_form_illness_surgery }}</td>
            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Advice on discharge:  {{ $admission_details->discharge_advice }}</td>
            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Plan on discharge: </td>
            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Condition at the time of discharge: </td>
            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">When & how to obtain urgent care: </td>
            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Discharge summary Prepared Doctor’s name & sign: </td>
            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Discharge summary Verified Doctor Name & sign: </td>
            </tr>
            <tr>
                <td style="border: none;text-align: left;width: 50%; padding-top:0px; font-size: 14px; padding-left: 8px;">Emergency Contact Information: {{ $admission_details->contact_person }}</td>
            </tr>
        </table> 

        <table style="width: 100%; border:black solid 1px ; marign-bottom: 0px !important;  border-collapse: collapse;">
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

        <table style="width: 100%; border:black solid 1px ; font-weight: bold;  border-collapse: collapse;">
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
            <table style="width: 100%; margin-top:5px; border-collapse: collapse;">
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
                    <td style="text-align: center;">{{ $value->duration . ' ' . $value->duration_mu}}</td>
                    {{-- <td>{{ $value->med_taken_instruction != "0" ? $value->med_taken_instruction : "N/A" }}</td> --}}
                    <td> {{ isset($instructions[$value->med_taken_instruction]) ? $instructions[$value->med_taken_instruction] : "N/A" }}</td>
                </tr>
                @endforeach
            </table>
        <div>
      
        <div>
            <table style="width: 100%; border: none; font-weight: bold;" cellpadding="0" cellspacing="0" id="advice-table">
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