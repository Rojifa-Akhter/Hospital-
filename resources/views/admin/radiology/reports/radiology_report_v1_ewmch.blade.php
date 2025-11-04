<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Radiology Report</title>

    <style>
        @page {
            margin-top: 3.9cm;
            margin-bottom: 2.3cm;
            margin-left: 0cm;
            margin-right: 0cm;
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }
        body {
            margin-left: 0.8cm;
            margin-right: 0.7cm;
            padding-left:30px;
            padding-right: 30px;
            font-family: 'Roboto', sans-serif;
            font-size: 18px;
        }

        @media print {
          
            .signature {
                    page-break-inside: avoid;
                }
        }
        
        .report-data{
            font-size: 14px;
            width:100%;
        }
    </style>
</head>
<body onload="window.print()">
    <table style="width: 100%;">
        <thead>
            <tr>
                <th>
                    @if ($po_hospital_details->report_header_image_prshde_ind == 1)
                        <table style="width: 100%;">
                            <tbody>
                                <tr>
                                    <td style="width: 10%;"><img class="hospital-logo" src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" style="background-color: {{ $po_hospital_details->logo_background_color }}; width:70px " alt=""></td>
                                    <td style="text-align:center;">
                                        <span style="font-size: 15px;"><strong>{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span> <br>
                                        Address: <span>{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                                        Phone No: <span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                                    </td>
                                </tr>
                            </tbody>
                        </table>
                    @endif

                    <table width="100%" style="padding: 0px;">
                        <tr>
                            <td style="text-align:left" width="30%"> 
                                <div><img style="" src="data:image/png;base64,{{ $app_barcode }} " style="width: 120px; " /></div>
                                <div style="padding-top: 1px;"><strong>Report ID</strong>:{{ $radiology_appointment_data->rad_report_no_pk }}</div>
                            </td>
                            <td style="text-align: center">
                                <h2 style="text-align: center; margin: 0 auto; padding: 5px; width: 100%; font-size: 20px">{{ strtoupper($radiology_appointment_data->serviceunit_name) }} REPORT</h2>
                            </td>
                            <td style="text-align: right" width="30%">
                                <div><img style="" src="data:image/png;base64, {{ $invoice_barcode }} " style="width: 120px; " /></div>
                                <div style="padding-top: 1px;"><strong>Invoice ID</strong>: {{ $radiology_appointment_data->invoice_code }}</div>
                            </td>
                        </tr>
                    </table>
                
                    <table style="width: 100%; border:1px solid #999; border-radius:10px; font-size: 14px; ">
                        <tr>
                            <td width="20%" style="padding-left:20px;text-align: left;"><strong>Patient Name</strong></td>
                            <td width="2%" style="text-align:center">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;" width="40%">{{ !empty($patient_info->salutation) ? ucfirst($patient_info->salutation) : '' }} {{ $patient_info->patient_name }}</td>

                            <td width="20%" style="text-align:left"><strong>Patient ID</strong></td>
                            <td width="2%" style="text-align:center">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;width:16%">{{ $radiology_appointment_data->patient_no_fk }}</td>
                        </tr>
                        <tr>
                            <td width="20%" style="padding-left:20px;text-align:left"><strong>Age </strong></td>
                            <td width="2%" style="text-align:center">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;width:16%" >{{ $patient_info->pat_age }}</td>

                            <td width="20%" style="text-align:left"><strong>Accession ID</strong></td>
                            <td width="2%" style="text-align:center">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;width:16%">{{ $radiology_appointment_data->accession_id }}</td>
                        </tr>
                        <tr>


                            <td width="20%" style="text-align: left;padding-left:20px;"><strong>Gender </strong></td>
                            <td width="2%" style="text-align:center">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;width:40%">{{ $patient_info->gender_txt }}</td>

                            <td width="20%" style="text-align:left"><strong>Report Date</strong></td>
                            <td width="2%" style="text-align:center">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;width:16%">{{ !empty($radiology_appointment_data->img_app_dttm) ? date('d/m/Y', strtotime($radiology_appointment_data->img_app_dttm)) : date('d/m/Y') }}</td>

                        </tr>

                        <tr>
                            <td width="10%" style="text-align: left;padding-left:20px;"><strong>Ref By</strong></td>
                            <td width="2%" style="text-align:center">:</td>
                            <td style="text-align: left;padding-left:10px;padding-right:10px;" colspan="5">{{ $radiology_appointment_data->ref_doc_name }}</td>
                        </tr>

                        @if (!empty($patient_info->passport_no))
                            <tr>
                                <td width="20%" style="text-align: left;padding-left:20px;"><strong>Passport No</strong></td>
                                <td width="2%" style="text-align:center">:</td>
                                <td style="text-align: left;padding-left:10px;padding-right:10px;" colspan="4">{{ $patient_info->passport_no }}</td>
                            </tr>
                        @endif
                    </table>
                </th>
            </tr>
            <tr><th><br></th></tr>
        </thead>
        <tbody>
            @if(strtoupper($radiology_appointment_data->serviceunit_name != 'ECHO'))
                <tr>
                    <td style="text-align:center;">
                        <span style="width:100%; font-size: 18px; padding:2px; border-bottom: 1px solid rgb(29, 27, 27) ;"><strong>{{ $radiology_appointment_data->item_name }}</strong></span><br>
                    </td>
                </tr>
            @endif 

            <tr>
                <td class="report-data">{!! $radiology_appointment_data->result0 !!}</td> 
            </tr>

            <!-- Signature -->
            <tr>
                <td class="signature">
                        <table style="width: 100%; font-size: 13px;">
                            <tbody>
                                <tr>
                                    <td width="55%" class="text-left" style="vertical-align: top">
                                        @if($radiology_appointment_data->prepared_full_name != '')
                                            <div>Prepared By</div>
                                            <div style="padding-top:40px">{!!$radiology_appointment_data->doctor_signature_pr!!}</div>
                                        @endif
                                    </td>    
                                    <td width="45%" style="text-align: left; vertical-align: top;">
                                        <div style="float: right">
                                            @if ($radiology_appointment_data->final_full_name != '')
                                                <div style="color:transparent">Name</div>
                                                <div style="padding-top:40px">{!!$radiology_appointment_data->doctor_signature_fin !!}</div>
                                            @endif
                                        </div>
                                    </td>
                                </tr>

                                <tr>
                                    <td style="border: 0px; padding-top: 5px; text-align: left; font-size:8px">
                                        <div class="print_footer"> 
                                            @php
                                            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));      
                                            $date = $dt->format('g:i A');
                                        @endphp                        
                                        {{ Session::get('user.ses_user_name') }}, Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }}, &nbsp;Powered By: [NEXTGEN]
                                        </div>
                                    </td>
                                </tr>

                            </tbody>
                        </table>
                </td>
            </tr>
        </tbody>
    </table>
</body>
</html>



