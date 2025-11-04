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
            height: 2.5cm;
            border-bottom: 1px solid;
            /* padding: 0 1cm; */
            padding-top: 10px;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: 3cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 12px;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height: 0.7cm;
            text-align: center;
            font-size: 9px;
            bottom: 10px;
            /*border-top: 1px solid black;*/
            /* padding-top: 5px; */
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

        @page {
            margin: 0cm 0cm;
        }

        @font-face {
            font-family: 'Helvetica';
            font-weight: normal;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }


        .page-break {
            page-break-after: always;
        }

        /*body part */
        .border-bottom {
            border-bottom: 1px solid #000;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .w-100 {
            width: 100%;
        }

        .w-50 {
            width: 50%;
        }

        .w-70 {
            width: 70%;
        }

        .w-30 {
            width: 30%;
        }

    </style>
</head>

<body>
    {{-- <header style=" margin-top:20px">
           <table style="width: 100%;" class="signature">
               <tr>
                   <td style="width: 10%;">
                    @if (!empty($po_hospital_details->logo))
                    <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}" width="60"/>
                @endif
                   </td>
                   <td style="">
                        <span style="font-size: 15px;"> <strong>   {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }} </strong></span> <br>
                      Address: <span>  {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                       Phone No: <span> {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                   </td>

               </tr>
           </table>
       </header> --}}
    <header>
        <table style="width: 100%; border:5px solid transparent !important" class="signature">
            @if ($po_hospital_details->report_header_image_prshde_ind == 1)
                <tr style="">
                    <td style="width: 15%; border-right:1px solid transparent!important">
                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                            width="60" alt="">
                    </td>
                    <td style="text-align:center;">
                        <span style="font-size: 15px;"> <strong>
                                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</strong></span>
                        <br>
                        Address:<span>
                            {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                        Phone
                        No:<span>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                    </td>
                </tr>
            @else
                <tr>
                    <td style="text-align: center">

                        <img class="hospital-logo"
                            src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                            width="250px" alt="">
                    </td>
                </tr>
            @endif
        </table>
    </header>
    <footer style="">

        <div class="footer">
            <div class="container">
                <div class="signature_">
                    <table style="width: 100%;">
                        <tr style=" ">
                            <td style="text-align:left; ">
                                <span style="padding:5px; border-top: black solid 1px;font-size: 12px;">Signature
                                </span>
                            </td>
                        </tr>
                    </table>
                </div>
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y h:i a');
                                @endphp
                                {{ $date }}
                            </strong> Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong></td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
    <main>
        <div class="admission_body text-center" style="margin-left:30px;margin-right:30px;">
            <table width="100%; border-collapse: collapse;">
                <tr style="">
                    <td style="text-align:left" width="30%"> <img style=""
                            src="data:image/png;base64, {{ $barcode_pat_no }} " style="width: 120px; " />
                        <br>
                        {{ $admission_pat->patient_code }}
                    </td>
                    <td class="text-center" colspan="2">
                        <div class="first_part text-center" style="font-size: 20px; margin-bottom: 10px;">
                            <strong>Admission Form</strong> <br>

                        </div>
                    </td>

                    <td style="text-align: right; padding-right:30px" width="30%">
                        <img style="" src="data:image/png;base64, {{ $barcode_admission_no }} "
                            style="width: 120px; " /> <br>
                        {{ $admission_pat->admission_uid }}
                    </td>

                </tr>
            </table>
            <table width="100%; border-collapse: collapse;" style="margin-top: 15px;">
                <tr>
                    <td colspan="4" style="text-align: left; font-size:15px;"> <strong> <span
                                style="border-bottom: 1px solid black"> Patient Info</span> </strong></td>
                </tr>
                <tr>
                    <td><strong>Patient Id </strong></td>
                    <td> : {{ $admission_pat->patient_code }}</td>
                    <td><strong>Admission No </strong></td>
                    <td> : {{ $admission_pat->admission_uid }}</td>

                </tr>
                <tr>
                    <td><strong>Patient Name</strong></td>
                    <td> : <strong> {{ $admission_pat->patient_name }} </strong></td>
                    <td><strong>Mobile No</strong></td>
                    <td> : <strong> {{ $admission_pat->mobile1 }} </strong></td>
                </tr>
                <tr>
                    {{-- <td><strong>Patient Valueable Accesories</strong></td>
                <td>: {{ $admission_pat->pat_valuable_accessories }}</td> --}}
                    <td><strong>Age</strong></td>
                    <td> : {{ $admission_pat->age }}</td>
                    <td><strong>Gender</strong></td>
                    <td> : {{ $admission_pat->gender_txt }}</td>
                </tr>
                <tr>
                    <td><strong>DoB</strong></td>
                    <td> : {{ $admission_pat->dob != '' ? date('d/m/Y', strtotime($admission_pat->dob)) : '' }}</td>
                    <td><strong>Accompanied By</strong></td>
                    <td> : {{ $admission_pat->accompanied_by }}</td>
                </tr>
                <tr>
                    <td><strong>Relation </strong></td>
                    <td> : {{ $admission_pat->contact_relaion }}</td>
                    <td><strong>Contact </strong></td>
                    <td> : {{ $admission_pat->contact_person_mobile }}</td>
                </tr>
                <tr>
                    <td><strong>Father's Name </strong></td>
                    <td> : {{ $admission_pat->father_name }}</td>
                    <td><strong>Mother's Name </strong></td>
                    <td> : {{ $admission_pat->mother_name }}</td>
                </tr>
                <tr>
                    <td><strong>Marital Status </strong></td>
                    <td> : {{ $admission_pat->marital_status_txt }}</td>
                    <td><strong>Spouse Name </strong></td>
                    <td> : {{ $admission_pat->spouse_name }}</td>
                </tr>

                <tr>
                    <td><strong> Address </strong></td>
                    <td> : {{ $admission_pat->present_addr }}
                        {{ $admission_pat->present_district != '' && $admission_pat->present_addr != ''? ',' . $admission_pat->present_district: '' }}
                    </td>
                    <td><strong> Patient Type </strong></td>
                    <td style="padding-bottom: 10px"> : {{ $admission_pat->patient_type_code }}</td>
                </tr>

                <tr>
                    <td colspan="4" style="text-align: left; font-size:15px;padding-top:15px">
                        <strong> <span style="border-bottom: 1px solid black"> Admission Details </span> </strong>
                    </td>
                </tr>
                <tr>
                    <td><strong>Admission Date & Time</strong></td>
                    <td> : {{ date('d/m/Y H:i a', strtotime($admission_pat->admission_date)) }}</td>
                    <td><strong>Department Name</strong></td>
                    <td> : {{ $admission_pat->admitted_department }}</td>
                </tr>
                <tr>
                    <td><strong>Consultant </strong></td>
                    <td> : {{ $admission_pat->refrral_doctor_name }}</td>
                    <td><strong>Ward Name </strong></td>
                    <td> : {{ $admission_pat->ward_name }}</td>
                </tr>

                <tr>
                    <td><strong>Admitted Under </strong></td>
                    <td> : <strong> {{ $admission_pat->primary_doctor_name }} </strong></td>
                    <td><strong>Bed Name </strong></td>
                    <td> : {{ $admission_pat->bed_name }}</td>
                </tr>

                <tr>
                    <td colspan="4" style="text-align: left; font-size:15px;padding-top:15px">
                        <strong> <span style="border-bottom: 1px solid black"> Additional Info </span> </strong>
                    </td>
                </tr>



                <tr>
                    <td><strong>National Id</strong></td>
                    <td> : {{ $admission_pat->national_id }}</td>
                    <td><strong>Email</strong></td>
                    <td> : {{ $admission_pat->email }}</td>
                </tr>
                <tr>
                    <td><strong>Arrival Mode</strong></td>
                    <td> : {{ $admission_pat->arrival_mode_txt }}</td>
                    <td><strong>Patient Condition</strong></td>
                    <td> : {{ $admission_pat->patient_condition_txt }}</td>
                </tr>
                <tr>
                    <td><strong>Valuable Accessories</strong></td>
                    <td> : {{ $admission_pat->pat_valuable_accessories }}</td>
                    <td><strong>Cause Of Admission</strong></td>
                    <td> : {{ $admission_pat->cause_of_admission }}</td>
                </tr>
                <tr>
                    <td><strong>First Referral </strong></td>
                    <td> : {{ $admission_pat->first_ref_doctor_name }}</td>
                    <td><strong>Referred From</strong></td>
                    <td> : {{ $admission_pat->external_hospital }}</td>
                </tr>
                <tr>
                    <td><strong>Second Referral </strong></td>
                    <td colspan="3"> : {{ $admission_pat->second_ref_doctor_name }}</td>

                </tr>
                <tr>
                    <td><strong>Remarks </strong></td>
                    <td colspan="3"> : {{ $admission_pat->remarks }}</td>

                </tr>

            </table>
        </div>


        <div class="admission_body text-center" style="margin-left:30px;margin-right:30px; padding-bottom:50px;">
            <div style="text-align: left; font-size:15px; padding-top:15px">
                @if (isset($admission_pat->adm_form_past_med_hist))
                <strong> <span style="border-bottom: 1px solid black">Past Medical History</span></strong><br>

                   <span style="font-size:12px;"> {{ $admission_pat->adm_form_past_med_hist }}</span>
                @endif
            </div>
            <div style="text-align: left; font-size:15px;padding-top:15px">
                @if (isset($admission_pat->adm_form_illness_surgery))
                <strong> <span style="border-bottom: 1px solid black">Illness or Surgery(If any)</span></strong><br>

                   <span style="font-size:12px;"> {{ $admission_pat->adm_form_illness_surgery }}</span>
                @endif
            </div>
            <div style="text-align: left; font-size:15px;padding-top:15px">
                @if (isset($admission_pat->adm_form_allergies))
                <strong> <span style="border-bottom: 1px solid black">Allergies</span></strong><br>

                   <span style="font-size:12px;"> {{ $admission_pat->adm_form_allergies }}</span>
                @endif
            </div>
            <div style="text-align: left; font-size:15px;padding-top:15px">
                @if (isset($admission_pat->adm_form_relevent_hist))
                <strong> <span style="border-bottom: 1px solid black">Relevant History(Medical,Socila,Family)</span></strong><br>

                   <span style="font-size:12px;"> {{ $admission_pat->adm_form_relevent_hist }}</span>
                @endif
            </div>

        </div>
    </main>


</body>

</html>
