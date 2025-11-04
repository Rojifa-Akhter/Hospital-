<!DOCTYPE html>
<html>

<head>
    <style>
        body {
            margin-left: 0cm;
            margin-right: 0cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 9px;
        }

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table tr td,
        table tr th {
            font-size: 10px;
            border: 0;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            padding: 2px;
        }

        .text-center {
            text-align: center !important;
        }

        .text-left {
            text-align: left !important;
        }

        .text-right {
            text-align: right !important;
        }

        .d-flex {
            display: flex;
        }

        .align-items-center {
            align-items: center;
        }

        .table-bordered td,
        .table-bordered th {
            border: 1px solid #222
        }

        body {
            /* margin-bottom: 2.8cm; */
            font-family: 'Roboto', sans-serif;
            color: black;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 0;
            right: 0;
            height: 3cm;
            text-align: center;
            font-size: 9px;
            bottom: -100px;
        }

        .signature {
            position: fixed;
            z-index: 999999999;
            left: 0;
            right: 0;
            height: 6.7cm;
            text-align: center;
            font-size: 9px;
            bottom: -100px;
            margin-top: 10px;
        }

        hr {
            border-style: dotted;
            border-width: 1px;
            border-color: #000;

        }
    </style>
</head>
<header>
    <table width="100%">
        <tr>
            <td style="width: 15%;">
                @if (!empty($po_hospital_details->logo))
                <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60px" />
                @endif
            </td>
            <td>
                <span style="font-size: 13px;">
                    <strong> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }} </strong>
                </span>
                <br>
                <span>
                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                </span>
                <br>
                <span>
                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}
                </span>
            </td>
        </tr>
    </table>
    <div style="text-align: center;font-size: 15px; font-style:bold">
        <strong>Blood Requisition Form</strong>
        <p style="text-align: center; margin: 0 auto; border:1px solid #000000; padding: 5px;margin-top:10px; width: 30%; font-size:15px; border-radius: 15px; background-color:E9E8E8">
            <strong> Especially noteworthy</strong>
        </p>
    </div>

    <div class="" style=" height: 100px; padding: 10px;  font-size:13px !important">
        <p>
            Each request form should be filled with the patient's identity and the patient's blood (5 ml) should be sent in a test tube. If the patient's details are not sent correctly, it will not be accepted and mistakes can lead to serious reactions. It is recommended to have the blood prepared hours before.
        </p>
        <p>
            Special note : It is recommended to finish giving blood within 3-4 hours after starting to give blood on the patient. The doctor of blood recipient must mix everything while taking blood. Blood must be transfused within 30 minutes after it comes out of the freezer.
        </p>

    </div>
</header>

<body>
    <div style="padding: 10px;">
        <table class="" style="font-size:13px !important;width:100%">
            <tbody>
                @if (isset($blood_requisition_data))
                <tr>
                    <td class="text-left" style="width: 150px;"> <strong>Patient Name</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->patient_name }}</td>
                    <td class="text-left" style="width: 150px;"> <strong> Admission Date</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->admission_date !="" ? date('d/m/Y',strtotime($blood_requisition_data->admission_date)):"" }} </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 150px;"> <strong> Patient Id</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->patient_code }}</td>
                    <td class="text-left" style="width: 150px;"> <strong> Age</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->patient_age  }} </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 150px;"> <strong> Bed/Cabin</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->bed_cabin_name }}</td>
                    <td class="text-left" style="width: 150px;"> <strong> Blood Bag Qty</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->blood_bag_qty .' ('. $blood_requisition_data->blood_type .')'}} </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 150px;"> <strong> Transmission Date</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->transmission_date !="" ? date('d/m/Y',strtotime($blood_requisition_data->transmission_date)):""}}</td>
                    <td class="text-left" style="width: 150px;"> <strong> Transmission Time</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->trensmission_time !="" ? date('h:i a',strtotime($blood_requisition_data->trensmission_time)):""}} </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 150px;"> <strong> Blood Taken Type</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->blood_taken_type }}</td>
                    <td class="text-left" style="width: 150px;"> <strong> Blood Group</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->blood_group  }} </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 150px;"> <strong> Hemoglobin</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->hemoglobin }}</td>
                    <td class="text-left" style="width: 150px;"> <strong> BP</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->bp  }} </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 150px;"> <strong> Pulse</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->pulse }}</td>
                    <td class="text-left" style="width: 150px;"> <strong> Temperature</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->tamprature  }} </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 150px;"> <strong> Exam Type</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->exam_type }}</td>
                </tr>

                @if($blood_requisition_data->prev_trensmission_date !="")
                <tr>
                    <td colspan="4" style="font-size: 17px !important; padding:5px 0px 5px 0px">
                        <strong>Details of blood taken previously</strong>
                    </td>
                </tr>
                <tr>
                    <td class="text-left" style="width: 150px;"> <strong>Pre-Transmission Date</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->prev_trensmission_date !="" ? date('d/m/Y',strtotime($blood_requisition_data->prev_trensmission_date)) :'' }}</td>
                    <td class="text-left" style="width: 150px;"> <strong> Side Effects</strong></td>
                    <td class="text-left">: {{ $blood_requisition_data->last_blood_sideeffect  }} </td>
                </tr>
                @endif

                @endif
            </tbody>
        </table>
        <table style="width: 100%;padding-top:30px;padding-bottom:10px">
            <tr>
                <td style="border: #000000 1px solid;width:60%">
                    <p style="font-size:13px !important;text-align:center;"><strong> Own Blood Donor Pledge: </strong></p>
                    <p style="font-size:13px !important;padding-bottom:20px;text-align:center;">I donated blood for the above patient. This blood will be given to another patient if that patient does not need it.</p>
                    <p> <span style="font-size:13px !important;border-top:#000000 1px dotted;padding-left:5px">Signature of the blood donor</span>
                        <span style="font-size:13px !important;float:right;border-top:#000000 1px dotted;padding-right:5px">Signature of blood collector</span>
                    </p>
                </td>
                <td style="font-size:13px !important;text-align:center;width:40%;vertical-align:bottom">
                    <p> <?php echo $blood_requisition_data->doctor_signature; ?></p>
                </td>
            </tr>
        </table>
        <?php
        $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        $date = $dt->format('g:i A');
        ?>
        <div class="" style=" border-top: 1px solid black;">
            <span style="">printed By: {{ $userInfo->user_fullname }}</span> &nbsp; <span style="">Printing Date & Time: {{ date('d/m/Y') }} , {{ $date }} </span>&nbsp;
            <span>Powered By: NEXTGEN IT</span>
        </div>
        <p style="padding-bottom:10px"> <strong> After collecting the patient's blood in a dry sterile test tube, fill the lower part and apply glue on the test tube and send it.</strong></p>
        <hr>
        <table style="width: 100%;padding-top:10px;font-size:13px !important;">
            <tr>
                <td class="text-left" style="width: 150px;"> <strong>Patitent Name</strong></td>
                <td class="text-left">: {{ $blood_requisition_data->patient_name }}</td>
                <td class="text-left" style="width: 150px;"> <strong> Patient Id</strong></td>
                <td class="text-left">: {{ $blood_requisition_data->patient_code }} </td>
            </tr>
            <tr>
                <td class="text-left" style="width: 150px;"> <strong> Age</strong></td>
                <td class="text-left">: {{ $blood_requisition_data->patient_age }} </td>
                <td class="text-left" style="width: 150px;"> <strong>Gender</strong></td>
                <td class="text-left">: {{ $blood_requisition_data->patient_gender }}</td>

            </tr>
            <tr>
                <td class="text-left" style="width: 150px;"> <strong> Bed/Cabin</strong></td>
                <td class="text-left">: {{ $blood_requisition_data->bed_cabin_name }} </td>
                <td class="text-left" style="width: 150px;"> <strong> Transmission Date</strong></td>
                <td class="text-left">: {{ $blood_requisition_data->trensmission_date !="" ? date('d/m/Y',strtotime($blood_requisition_data->trensmission_date)):"" }} </td>
            </tr>
            <tr>
                <td style="" colspan="3"></td>
                <td style="text-align:center;vertical-align:bottom;padding-top:35px">
                    <p> <?php echo $blood_requisition_data->doctor_signature; ?></p>
                </td>

            </tr>
        </table>
    </div>
</body>

</html>