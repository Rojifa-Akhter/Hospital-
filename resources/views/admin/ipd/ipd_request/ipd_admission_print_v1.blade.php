@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
    // dd( $hospital);
    $body_font_size = $po_hospital_details->hospital_code == 'GMC' ? 14 : 11;
    $footer_bottom = $po_hospital_details->hospital_code == 'GMC' ? 25 : 10;
    $signature_bottom = $po_hospital_details->hospital_code == 'GMC' ? 2.6 : 1.6;
    $body_top = $po_hospital_details->hospital_code == 'GMC' ? 3.8 : 3;
    $footer_border = $po_hospital_details->hospital_code == 'GMC' ? 'none' : '1px solid #000';
    $body_top = $po_hospital_details->hospital_code == 'IMPERIAL' ? 5.0 :  $body_top ;
@endphp

<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>IPD Admission Form</title>
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
            height: 3.0cm;
            /* border-bottom: 1px solid; */
            padding-top: 10px;
        }

        header img {
            /*width: 80px;*/
        }

        /** Define now the real margins of every page in the PDF **/
        body {
            margin-top: <?=$body_top ?>cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: 2cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: <?=$body_font_size ?>px;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 10px;
            right: 10px;
            height: 0.7cm;
            text-align: center;
            font-size: 9px;
            bottom: <?=$footer_bottom ?>px;
            /*border-top: 1px solid black;*/
            /* padding-top: 5px; */
            border-top: <?=$footer_border ?>;
        }

        .signature_ {
            position: fixed;
            bottom: <?=$signature_bottom ?>cm;
            left: .8cm;
            right: 1.6cm;
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

                @if ($po_hospital_details->report_header_image != '')
                    <img class="hospital-logo"
                        src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                        width="250px" alt="">
                @else
                    @if ($po_hospital_details->hospital_code != 'KBMH')
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
                    @endif
                @endif
            @else
                @if ($po_hospital_details->hospital_code != 'GMC')

                    @if ($po_hospital_details->hospital_code == 'IMPERIAL')
                        <tr>
                            <td style="text-align: center">
                                @if ($po_hospital_details->report_header_image != '')
                                    <img class="hospital-logo"
                                        src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                        width="80%" alt="" >
                                @endif

                            </td>
                        </tr>
                    @else
                        <tr>
                            <td style="text-align: center">
                                @if ($po_hospital_details->report_header_image != '')
                                    <img class="hospital-logo"
                                        src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                        width="250px" alt="">
                                @endif
                            </td>
                        </tr>
                    @endif
                @else
                    {{-- <header>
                        <table style="width: 100%; " class="signature"> --}}
                    <tr>
                        <td style="text-align: center ">
                            {{-- @if ($po_hospital_details->report_header_image_prshde_ind == '' && $po_hospital_details->report_header_image != '')
                                        <img class="hospital-logo"
                                            src="{{ asset('images/uploads/hospital_images/' . $po_hospital_details->report_header_image) }}"
                                            width="400px" alt="">
                                    @endif --}}
                        </td>
                    </tr>
                    {{-- </table>
                    </header> --}}
                @endif

            @endif
        </table>
    </header>
    <footer style="font-size:9px;">
        <div class="footer">
            <div class="container">
                <table style="width: 100%; padding:3px; margin: 0">
                    <tr>
                        <td style="font-size: 9px; text-align:left;">Print Date: <strong>
                                @php
                                    date_default_timezone_set('Asia/Dhaka');
                                    $date = date('d/m/Y h:i:s a');
                                @endphp
                                {{ $date }}
                            </strong> Prepared By: <strong>{{ $prepared_by_info->user_fullname }}</strong>, Printed By:
                            <strong>{{ Session::get('user.ses_user_name') }}</strong>
                        </td>
                        <td style="font-size: 9px; text-align: right;"><strong>Powered By - H360 [NextGenIT] </strong>
                        </td>
                    </tr>
                </table>
            </div>
        </div>
    </footer>
    <main>
        <div class="admission_body text-center" style="margin-left:30px;">
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
                    <td colspan="4" style="text-align: left; font-size:15px; padding-bottom:15px"> <strong> <span
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

                    @php
                        $pat_dob = new \DateTime($admission_pat->dob);
                        $invoice_date = new \DateTime();
                        $interval = $invoice_date->diff($pat_dob);
                    @endphp
                    <td><strong>Age</strong></td>
                    <td> :{{ isset($interval) ? $interval->format('%yY %mM %dD') : '' }}</td>
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
                    <td> :
                        {{ isset($ipd_patient_tab_rec->address) ? $ipd_patient_tab_rec->address : $admission_pat->reg_present_addr }}
                        {{ $admission_pat->present_district != '' && $admission_pat->present_addr != '' ? ',' . $admission_pat->present_district : '' }}
                    </td>
                    <td><strong> Patient Type </strong></td>
                    <td style="padding-bottom: 10px"> : {{ $admission_pat->patient_type_code }}</td>
                </tr>

                <tr>
                    <td colspan="4" style="text-align: left; font-size:15px; padding-bottom:15px"> <strong> <span
                                style="border-bottom: 1px solid black"> Admission Details </span> </strong></td>
                </tr>
                <tr>
                    <td><strong>Admission Date & Time</strong></td>
                    <td> : {{ date('d/m/Y h:i:s a', strtotime($admission_pat->admission_date)) }}</td>
                    <td><strong> Admitted Department</strong></td>
                    <td> :
                        </strong>{{ $admission_pat->admitted_dept != '' ? $admission_pat->admitted_dept : '' }}
                    </td>
                </tr>
                <tr>

                    <td><strong>Department Name</strong></td>
                    <td colspan="3"> :
                        </strong>{{ $admission_pat->new_su_name != '' ? $admission_pat->new_su_name : $admission_pat->admitted_department }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Discharge Date </strong></td>
                    <td> :{{ $admission_pat->discharge_date != '' ? date("d-m-Y", strtotime($admission_pat->discharge_date)) : "" }}</td>
                    <td><strong>Cause of Admission </strong></td>
                    <td> :{{ $admission_pat->cause_of_admission != '' ? $admission_pat->cause_of_admission : "" }}
                    </td>
                </tr>
                <tr>
                    <td><strong>Consultant </strong></td>
                    <td> : {{ $admission_pat->refrral_doctor_name }}</td>
                    <td><strong>Ward Name </strong></td>
                    <td> :{{ $admission_pat->new_ward_name != '' ? $admission_pat->new_ward_name : $admission_pat->ward_name }}
                    </td>
                </tr>

                <tr>
                    <td><strong>Admitted Under </strong></td>

                    <td> : <strong> {{ $admission_pat->primary_doctor_name }} </strong></td>

                    <td><strong>Cabin / Bed No. </strong></td>
                    <td> :
                        {{ $admission_pat->new_bed_name != '' ? $admission_pat->new_bed_name : $admission_pat->bed_name }}
                    </td>
                </tr>



                <tr>
                    <td><strong>Admission Fees</strong></td>
                    <td> :
                        <input type="text"  style="height:20px; margin-top:10px; width:80%"/>
                    </td>
                    <td><strong>Cabin Charge</strong></td>
                    <td> :   <input type="text"  style="height:20px; margin-top:10px; width:85%; "/></td>
                </tr>
                <tr>
                    <td><strong>Advance TK.</strong></td>
                    <td> :
                        <input type="text"  style="height:20px; margin-top:10px; width:80%"/>
                    </td>
                    <td><strong>OT Charge</strong></td>
                    <td> :   <input type="text"  style="height:20px; margin-top:10px; width:85%"/></td>
                </tr>
                <tr>
                    <td ></td>
                    <td style="margin-top:-18px !important; margin-left:6px !important">
                        <input type="text"  style="height:20px; margin-top:10px; width:82%"/>
                    </td>
                    <td><strong>Post/Operative</strong></td>
                    <td> :   <input type="text"  style="height:20px; margin-top:10px; width:85%"/></td>
                </tr>
                <tr>
                    <td ></td>
                    <td style="margin-top:-46px !important; margin-left:6px !important">
                        <input type="text"  style="height:20px; margin-top:10px; width:82%"/>
                    </td>
                    <td><strong>Asst Charge</strong></td>
                    <td> :   <input type="text"  style="height:20px; margin-top:10px; width:85%"/></td>
                </tr>
                <tr>
                    <td ></td>
                    <td style="margin-top:-72px !important; margin-left:6px !important">
                        <input type="text"  style="height:20px; margin-top:10px; width:82%"/>
                    </td>
                    <td><strong>Anast Charge</strong></td>
                    <td> :   <input type="text"  style="height:20px; margin-top:10px; width:85%"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                    </td>
                    <td><strong>Child Physt</strong></td>
                    <td>: <input type="text"  style="height:20px; margin-top:10px; width:85%"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                    </td>
                    <td><strong>Baby Management</strong></td>
                    <td>:  <input type="text"  style="height:20px; margin-top:10px; width:85%"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                    </td>
                    <td><strong>Lab Machine Charge</strong></td>
                    <td> :   <input type="text"  style="height:20px; margin-top:10px; width:85%"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                    </td>
                    <td><strong>Medicine Charge</strong></td>
                    <td> :   <input type="text"  style="height:20px; margin-top:10px; width:85%"/></td>
                </tr>
                <tr>
                    <td></td>
                    <td>
                    </td>
                    <td style="width: 20% !important"><strong>Others Charge</strong></td>
                    <td> :   <input type="text"  style="height:20px; margin-top:10px; width:85%"/></td>
                </tr>
                <tr>

                    <td style="margin-top:25px !important;"> <strong>Total Deposit</strong>: <br> <input type="text"  style="height:20px; margin-top:10px; "/></td>
                    <td style="margin-top:25px !important"> <strong>Hospital Part</strong>:  <br><input type="text"  style="height:20px; margin-top:10px; "/></td>
                    <td style="margin-top:25px !important"> <strong>Surgeon Part</strong>:  <br><input type="text"  style="height:20px; margin-top:10px;"/></td>
                </tr>

                {{-- <tr>
                    <td style="margin-top:-70px !important;"><strong>Advance TK.</strong></td>
                    <td> :
                        <input type="text"  style="height:20px; margin-top:10px; width:80%"/><br>
                        <input type="text"  style="height:20px; margin-left:8px; width:80%"/><br>
                        <input type="text"  style="height:20px; margin-left:8px; width:80%; margin-top:-2px;"/><br>
                        <input type="text"  style="height:20px; margin-left:8px; width:80%; margin-top:-2px;"/><br>
                    </td>
                    <td style="margin-top:-70px !important";><strong>OT Charge</strong></td>
                    <td style="margin-top:-70px !important";> :   <input type="text"  style="height:20px; margin-top:10px; width:100%"/></td>
                </tr> --}}


            </table>

        </div>
    </main>

    <div class="signature_">
        <table style="width: 100%;">
            <tr style=" ">
                <td style="text-align:left; ">
                    <span style="padding:5px; border-top: black solid 1px;"> Signature
                    </span>
                </td>
                <!-- <td style="text-align:right; ">
                <span style="padding:5px; border-top: black solid 1px;"> Approved By </span>
            </td> -->
            </tr>
        </table>
    </div>
</body>

</html>
