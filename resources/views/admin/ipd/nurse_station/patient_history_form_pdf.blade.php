<html>

<head>
    <meta charset="utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge" />
    <title>H360 - Pathology Report</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport" />
    <link rel="stylesheet" href="css/invoice.css" media="all" />
    <style type="text/css">
        @page {
            size: A4 portrait;
            margin-top: 1.2cm;
            margin-bottom: 1.2cm;
            margin-left: 1cm;
            margin-right: 1cm;
            height: 29.7cm;
            width: 21cm;
        }

        body {
            margin-top: 0cm;
            margin-left: 0cm;
            margin-right: 0cm;
            margin-bottom: 0cm;
            font-family: "Roboto", sans-serif;
        }

        .cleafix::after{
            content: " ";
            clear: both;
            display: table;
        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 1cm;
            right: 1cm;
            height: 1.1cm;
            vertical-align: text-bottom;
            padding-top: 10px;
            font-size: 9px;
            bottom: 0px;
        }

        .footer_2 {
            position: fixed;
            z-index: 999999999;
            bottom: 0cm;
            left: 1cm;
            right: 1cm;
            height: 6.5cm;
            vertical-align: text-bottom;
            padding-bottom: 100px;
        }

        header {
            top: 1cm;
            height: 2.5cm;
            border-bottom: none !important;
            text-align: center;
        }

        table tr th {
            border: 0px;
            background-color: white;
            color: #222;
            border-collapse: collapse;
        }


        table tr td {
            border: 0px;
            border-collapse: collapse;
        }

        table {
            border: 0px;
            border-collapse: collapse;
        }

        #test {
            border-radius: 10px !important;
        }

        .tabcontent {
            padding-top: 50px;
            padding-bottom: 10px;
            height: 100%;
        }

        label,
        h4,
        p,
        li {
            font-family: "Roboto", sans-serif;
            font-size: 16px;

        }

        #luthaTable li {

            list-style-type: none;
            font-size: 12px;
            font-weight: 400;
            margin-bottom: 5px
        }

        #luthaTable ul {
            margin: 0;
            padding-left: 0;
        }

        #luthaTable,
        #luthaTable th,
        #luthaTable td {
            border: 1px solid black;
            padding: 10px 5px;
        }

        #luthaTable td {
            font-size: 12px;
            font-weight: 400;
        }

        .row {
            display: flex;
            flex-flow: row wrap;
            margin-left: auto;
            margin-right: auto;
        }

        .heading_patient {
            display: inline-block;
            text-align: left;
            font-weight: 600;
            text-decoration: underline;
            line-height: 30px;
            font-size: 18px;
        }

        .mb-0 {
            margin-bottom: 0px;
        }

        .mt-0 {
            margin-top: 0px;
        }
    </style>
</head>
{{-- onload="window.print()" --}}

<body>
    <!-- headrer -->
    <header>
        <div style="margin-top: 25px; align-items: center;">
            <table style="width: 100%;">
                <tr>
                    <td style="width: 15%; border-right: 1px solid transparent !important;">
                        @if (!empty($po_hospital_details->logo))
                            <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                width="80px" />
                        @endif
                    </td>

                    <td>
                        <h3 style="margin-bottom: 5px;">
                            {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                        </h3>
                        <p class="mt-0 mb-0">Address:
                            {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</p>
                        <p class="mt-0 mb-0">Phone No:
                            {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</p>
                    </td>
                </tr>
            </table>
            <table style="width: 100%; margin: 10px 0px;">
                <tr>
                    <td colspan="2" style="text-align:center; margin: 10px 0px;">
                        <h3>Patient History Form</h3>
                    </td>
                </tr>
            </table>
        </div>
    </header>
    <!-- headrer -->
    <section id="full_appointment">
        <div class="container">
            <!--Particulars of the patient start  -->
            <div class="row">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">Particulars of the patient </span>
                </div>
            </div>
            <div class="row" style="margin-top: 5px; align-items: center;">
                <div class="col-md-6" style="width: 50%;">
                    <table style="width: 98%;">
                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Admission No</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}</td>
                        </tr>

                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Name</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ isset($pat_info->patient_name) ? $pat_info->patient_name : '' }}</td>
                        </tr>
                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Age</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ isset($pat_info->age) ? $pat_info->age : '' }}</td>
                        </tr>

                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Sex</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : '' }}</td>
                        </tr>

                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Occupation</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ isset($pat_info->occupation_name) ? $pat_info->occupation_name:'' }}</td>
                        </tr>

                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Address</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ isset($pat_info->present_addr) ? $pat_info->present_addr:'' }}</td>
                        </tr>

                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Height</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ isset($pat_info->weight) ? $pat_info->weight:'' }}"</td>
                        </tr>
                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Ward Name</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ isset($pat_info->ward_name) ? $pat_info->ward_name:'' }}</td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6" style="width: 50%;">
                    <table style="width: 98%;">
                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                PID</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ isset($pat_info->patient_code) ? $pat_info->patient_code:''  }}</td>
                        </tr>

                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Date of Admission</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ isset($pat_info->admission_date) ? date('d/m/Y', strtotime($pat_info->admission_date)) : '' }}
                            </td>
                        </tr>

                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Date of Examination</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ isset($pat_info->admission_date) ? date('d/m/Y', strtotime($pat_info->admission_date)) : '' }}
                            </td>
                        </tr>

                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Marital status</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ isset($pat_info->marital_status_txt) ? $pat_info->marital_status_txt:''}}</td>
                        </tr>

                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Weight</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">{{ isset($pat_info->weight) ? $pat_info->weight:'' }}
                            </td>
                        </tr>

                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Bed Name</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ isset($pat_info->bed_name) ? $pat_info->bed_name:'' }}</td>
                        </tr>

                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Religion</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ isset($pat_info->religion_txt) ? $pat_info->religion_txt:'' }}</td>
                        </tr>

                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                BMI</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ isset($pat_history->bmi) ? $pat_history->bmi : '' }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!--Particulars of the patient end  -->
            <!-- Chief Complaints start -->
            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">Chief Complaints : </span>
                </div>

                <div class="col-lg-12" style="width: 99%;">
                    <table style="width: 80%; margin-left: auto;">
                        <tr>
                            @php
                                $height = isset($pat_history->chief_complaints) ? '' : 'height:250px;';
                            @endphp
                            <td style="font-size: 12px;  padding: 3px;{{ $height }}">
                                {{ isset($pat_history->chief_complaints) ? $pat_history->chief_complaints :"" }}</td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- Chief Complaints end -->
            <!-- History of present illness start -->
            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">History of present illness : </span>
                </div>

                <div class="col-lg-12" style="width: 99%;">
                    <table style="width: 80%; margin-left: auto;">
                        <tr>
                            @php
                                $height = isset($pat_history->history_of_present_illness) ? '' : 'height:400px;';
                            @endphp
                            <td style="font-size: 12px;  padding: 3px;{{ $height }}">
                                {{ !empty($pat_history->history_of_present_illness) ? $pat_history->history_of_present_illness : '' }}
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">History of past illness : </span>
                </div>

                <div class="col-lg-12" style="width: 99%;">
                    <table style="width: 80%; margin-left: auto;">
                        <tr>
                            @php
                                $height = isset($pat_history->history_of_past_illness) ? '' : 'height:400px;';
                            @endphp
                            <td style="font-size: 12px;  padding: 3px;{{ $height }}">
                                {{ !empty($pat_history->history_of_past_illness) ? $pat_history->history_of_past_illness : '' }}
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <!-- History of present illness end -->

            <!-- History of past illness start -->
            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">History of past illness : </span>
                </div>
                <div class="col-lg-12" style="width: 99%;">
                    @php
                        $height = isset($pat_history->past_fam_history) ? '' : 'height:400px;';
                    @endphp
                    <table style="width: 98%; margin-left: auto;">
                        <tr>
                            <th style="width: 30%; text-align: left; font-size: 14px;font-weight:600;">Family History
                            </th>
                            <td style="font-size: 12px;  padding: 3px;">
                                :
                                {{ !empty($pat_history->past_fam_history) ? $pat_history->past_fam_history : '' }}
                            </td>
                        </tr>
                        @php
                            $height = isset($pat_history->past_fam_drug_history) ? '' : 'height:400px;';
                        @endphp
                        <tr>
                            <th style="width: 30%; text-align: left; font-size: 14px;font-weight:600;">Drug History
                            </th>
                            <td style="font-size: 12px;  padding: 3px; ">
                                :
                                {{ !empty($pat_history->past_fam_drug_history) ? $pat_history->past_fam_drug_history : '' }}
                            </td>
                        </tr>
                        @php
                            $height = isset($pat_history->past_fam_personal_histotry) ? '' : 'height:400px;';
                        @endphp
                        <tr>
                            <th style="width: 30%; text-align: left; font-size: 14px;font-weight:600;">Personal History
                            </th>
                            <td style="font-size: 12px;  padding: 3px; ">
                                :
                                {{ !empty($pat_history->past_fam_personal_histotry) ? $pat_history->past_fam_personal_histotry : '' }}
                            </td>
                        </tr>
                        @php
                            $height = isset($pat_history->contrac_previous_history) ? '' : 'height:400px;';
                        @endphp

                        <tr>
                            <th style="width: 30%; text-align: left; font-size: 14px;font-weight:600;">Contraceptive
                                History</th>
                            <td style="font-size: 12px;  padding: 3px; ">
                                :
                                {{ !empty($pat_history->contrac_previous_history) ? $pat_history->contrac_previous_history : '' }}
                            </td>
                        </tr>
                        @php
                            $height = isset($pat_history->socio_econmic_history) ? '' : 'height:400px;';
                        @endphp

                        <tr>
                            <th style="width: 30%; text-align: left; font-size: 14px;font-weight:600;">Socio-economic
                                History</th>
                            <td style="font-size: 12px;  padding: 3px;">
                                :
                                {{ !empty($pat_history->socio_econmic_history) ? $pat_history->socio_econmic_history : '' }}
                            </td>
                        </tr>
                        @php
                            $height = isset($pat_history->allergic_history) ? '' : 'height:400px;';
                        @endphp
                        <tr>
                            <th style="width: 30%; text-align: left; font-size: 14px;font-weight:600;">Allergic History
                            </th>
                            <td style="font-size: 12px;  padding: 3px;">
                                :{{ !empty($pat_history->allergic_history) ? $pat_history->allergic_history : '' }}
                            </td>
                        </tr>
                        @php
                            $height = isset($pat_history->immunaizations_history) ? '' : 'height:400px;';
                        @endphp
                        <tr>
                            <th style="width: 30%; text-align: left; font-size: 14px;font-weight:600;">Immunization
                                History</th>
                            <td style="font-size: 12px;  padding: 3px;">
                                :
                                {{ !empty($pat_history->immunaizations_history) ? $pat_history->immunaizations_history : '' }}
                            </td>
                        </tr>

                        <tr>
                            <th
                                style=" margin-bottom: 5px; display: block; text-align: left; font-size: 14px;font-weight:600;">
                                Menstrual history</th>

                        </tr>
                        <tr>
                            <td colspan="2">
                                <table style="width: 100%; margin-left: auto;">
                                    <tr>
                                        <th
                                            style="width: 30%; text-align: left; font-weight:700; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                            Menarche</th>
                                        <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                            :{{ !empty($pat_history->menstrual_history_menarche) ? $pat_history->menstrual_history_menarche : '' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th
                                            style="width: 30%; text-align: left; font-weight:700; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                            MC/ MF</th>
                                        <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">:
                                            {{ !empty($pat_history->menstrual_history_mc_mf) ? $pat_history->menstrual_history_mc_mf : '' }}
                                        </td>
                                    </tr>


                                    <tr>
                                        <th
                                            style="width: 30%; text-align: left; font-weight:700; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                            Married For</th>
                                        <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">:
                                            {{ !empty($pat_history->mensrual_history_married) ? $pat_history->mensrual_history_married : '' }}
                                        </td>
                                    </tr>
                                </table>

                            </td>
                        </tr>




                        <tr>
                            <th
                                style=" margin: 5px 0px; display: block; text-align: left; font-size: 14px;font-weight:600;">
                                Obstetrics History</th>

                        </tr>
                        <tr>
                            <td colspan="2">
                                <table style="width: 100%; margin-left: auto;">
                                    <tr>
                                        <th
                                            style="width: 30%; text-align: left; font-weight:700; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                            Para</th>
                                        <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                            :{{ !empty($pat_history->obs_hist_para) ? $pat_history->obs_hist_para : '' }}
                                        </td>
                                    </tr>

                                    <tr>
                                        <th
                                            style="width: 30%; text-align: left; font-weight:700; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                            LMP</th>
                                        <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">:
                                            {{ !empty($pat_history->obs_hist_lmp) ? $pat_history->obs_hist_lmp : '' }}
                                        </td>
                                    </tr>


                                    <tr>
                                        <th
                                            style="width: 30%; text-align: left; font-weight:700; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                            ALC</th>
                                        <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">:
                                            {{ !empty($pat_history->obs_hist_alc) ? $pat_history->obs_hist_alc : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th
                                            style="width: 30%; text-align: left; font-weight:700; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                            Gravida</th>
                                        <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">:
                                            {{ !empty($pat_history->obs_hist_gravida) ? $pat_history->obs_hist_gravida : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th
                                            style="width: 30%; text-align: left; font-weight:700; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                            EDD</th>
                                        <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                            :{{ !empty($pat_history->obs_hist_edd) ? $pat_history->obs_hist_edd : '' }}
                                        </td>
                                    </tr>
                                    <tr>
                                        <th
                                            style="width: 30%; text-align: left; font-weight:700; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                            Mode of Previous Delivery</th>
                                        <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">:
                                            {{ !empty($pat_history->obs_hist_mode_prev_delivery) ? $pat_history->obs_hist_mode_prev_delivery : '' }}
                                        </td>
                                    </tr>
                                </table>

                            </td>
                        </tr>

                    </table>
                </div>



            </div>
            <!-- History of past illness end -->
            &nbsp;
            &nbsp;
            &nbsp;
            <!-- general examination start -->
            <div class="row">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">General Examination</span>
                </div>
            </div>
            <div class="row" style="margin-top: 5px;">
                <div class="col-md-6" style="width: 50%;">
                    <table style="width: 98%;">
                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Appearance</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_appearance) ? $pat_history->gen_exm_appearance : '' }}
                            </td>
                        </tr>

                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Decubitus</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_decuvitus) ? $pat_history->gen_exm_decuvitus : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Co-operation</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_co_operation) ? $pat_history->gen_exm_co_operation : '' }}
                            </td>
                        </tr>

                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Body built</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_body_build) ? $pat_history->gen_exm_body_build : '' }}
                            </td>
                        </tr>

                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Nutritional Status</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_nutritional_status) ? $pat_history->gen_exm_nutritional_status : '' }}
                            </td>
                        </tr>

                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Anemia</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_anemia) ? $pat_history->gen_exm_anemia : '' }}</td>
                        </tr>

                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Jaundice</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_jaundice) ? $pat_history->gen_exm_jaundice : '' }}</td>
                        </tr>
                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Cyanosis</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_cyanosis) ? $pat_history->gen_exm_cyanosis : '' }}</td>
                        </tr>
                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Clubbing</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_clubbing) ? $pat_history->gen_exm_clubbing : '' }}</td>
                        </tr>
                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Koilonychia</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_koilonychia) ? $pat_history->gen_exm_koilonychia : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th
                                style="width: 30%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Lung </th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->lung) ? $pat_history->lung : '' }}
                            </td>
                        </tr>
                    </table>
                </div>
                <div class="col-md-6" style="width: 50%;">
                    <table style="width: 98%;">
                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Leukonychia</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_leukonychia) ? $pat_history->gen_exm_leukonychia : '' }}
                            </td>
                        </tr>

                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Oedema</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_oedema) ? $pat_history->gen_exm_oedema : '' }}</td>
                        </tr>

                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Lymph Node</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_lymph_node) ? $pat_history->gen_exm_lymph_node : '' }}
                            </td>
                        </tr>

                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Dehydration</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_dehydration) ? $pat_history->gen_exm_dehydration : '' }}
                            </td>
                        </tr>

                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Thyroid Gland</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_thyroid_gland) ? $pat_history->gen_exm_thyroid_gland : '' }}
                            </td>
                        </tr>

                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Pulse</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_pulse) ? $pat_history->gen_exm_pulse : '' }}</td>
                        </tr>

                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                BP</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_bp) ? $pat_history->gen_exm_bp : '' }}</td>
                        </tr>

                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Temperature</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_temperature) ? $pat_history->gen_exm_temperature : '' }}
                            </td>
                        </tr>


                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Resp. Rate</th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->gen_exm_resp_rate) ? $pat_history->gen_exm_resp_rate : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Heart </th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->heart) ? $pat_history->heart : '' }}
                            </td>
                        </tr>
                        <tr>
                            <th
                                style="width: 40%; background: rgba(217, 225, 242, 1); text-align: left; font-size: 12px; border: 1px solid #999; padding: 3px;">
                                Liver  </th>
                            <td style="font-size: 12px; border: 1px dashed #999; padding: 3px;">
                                {{ !empty($pat_history->liver) ? $pat_history->liver : '' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <!-- general examination end  -->


            <!-- Local Examination start -->
            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">Local Examination : </span>
                </div>
                @php
                    $height = isset($pat_history->local_examination) ? '' : 'height:300px;';
                @endphp

                <div class="col-lg-12" style="width: 99%;">
                    <table style="width: 80%; margin-left: auto;">
                        <tr>
                            <td style="font-size: 12px;  padding: 3px;{{ $height }}">
                                {{ !empty($pat_history->local_examination) ? $pat_history->local_examination : '' }}
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <!--Local Examination end -->




            <!-- Cardiovascular System start -->
            <div class="row" style="margin-top: 5px;">
                {{-- <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">Systemic Examination : </span>
                </div> --}}
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">Cardiovascular System : </span>
                </div>
                @php
                    $height = isset($pat_history->cardiovascular_system) ? '' : 'height:100px;';
                @endphp

                <div class="col-lg-12" style="width: 99%;">
                    <table style="width: 80%; margin-left: auto;">
                        <tr>
                            <td style="font-size: 12px;  padding: 3px;{{ $height }}">
                                {{ !empty($pat_history->cardiovascular_system) ? $pat_history->cardiovascular_system : '' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <!--Cardiovascular System end -->

            <!-- Gastrointestinal System start -->
            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">Gastrointestinal System : </span>
                </div>
                @php
                    $height = isset($pat_history->cardiovascular_system) ? '' : 'height:100px;';
                @endphp
                <div class="col-lg-12" style="width: 99%;">
                    <table style="width: 80%; margin-left: auto;">
                        <tr>
                            <td style="font-size: 12px;  padding: 3px; {{ $height }}">
                                {{ !empty($pat_history->gastrointestinal_system) ? $pat_history->gastrointestinal_system : '' }}
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <!--Gastrointestinal System end -->

            <!-- Respiratory System start -->
            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">Respiratory System : </span>
                </div>
                @php
                    $height = isset($pat_history->cardiovascular_system) ? '' : 'height:100px;';
                @endphp
                <div class="col-lg-12" style="width: 99%;">
                    <table style="width: 80%; margin-left: auto;">
                        <tr>
                            <td style="font-size: 12px;  padding: 3px; {{ $height }}">
                                {{ !empty($pat_history->respiratory_system) ? $pat_history->respiratory_system : '' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <!--Respiratory System end -->

            <!-- Nervous System start -->
            @php
                $height = isset($pat_history->cardiovascular_system) ? '' : 'height:100px;';
            @endphp
            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">Nervous System : </span>
                </div>

                <div class="col-lg-12" style="width: 99%;">
                    <table style="width: 80%; margin-left: auto;">
                        <tr>
                            <td style="font-size: 12px;  padding: 3px; {{ $height }}">
                                {{ !empty($pat_history->nervous_system) ? $pat_history->nervous_system : '' }}
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <!--Nervous System end -->
            @php
                $height = isset($pat_history->cardiovascular_system) ? '' : 'height:100px;';
            @endphp
            <br>
            <!-- Musculoskeletal System start -->
            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">Musculoskeletal System : </span>
                </div>

                <div class="col-lg-12" style="width: 99%;">
                    <table style="width: 80%; margin-left: auto;">
                        <tr>
                            <td style="font-size: 12px;  padding: 3px; {{ $height }}">
                                {{ !empty($pat_history->musculoskeletal_system) ? $pat_history->musculoskeletal_system : '' }}
                            </td>
                        </tr>
                    </table>
                </div>
            </div>
            <!--Musculoskeletal System end -->


            <!--Reproductive System start  -->
            <div class="row">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">Reproductive System : </span>
                </div>
            </div>
            <div class="row" style="margin-top: 5px; align-items: center;">
                <div class="col-md-12" style="width: 100%;">
                    <table style="width: 100%;" id="luthaTable">
                        <thead>
                            <tr>
                                <th>Per Abdominal Examination</th>
                                <th>Presentation</th>
                                <th>Pelvic Examination</th>
                                <th>Per Speculum Examination</th>
                            </tr>
                        </thead>

                        <tbody>
                            <tr>
                                <td>Inspection :
                                    {{ !empty($pat_history->inspectation) ? $pat_history->inspectation : '' }}</td>
                                <td>{{ !empty($pat_history->engaged) ? $pat_history->engaged : '' }}</td>
                                <td>Inspection of vulva & vagina :
                                    {{ !empty($pat_history->inspectation_vulva_vagina) ? $pat_history->inspectation_vulva_vagina : '' }}
                                </td>
                                <td>Cervix : {{ !empty($pat_history->cervix) ? $pat_history->cervix : '' }} </td>
                            </tr>


                            <tr>
                                <td rowspan="2">Palpation :
                                    {{ !empty($pat_history->palpation) ? $pat_history->palpation : '' }}</td>
                                <td rowspan="2">Liquor Seems to be :
                                    {{ !empty($pat_history->liquor_seems) ? $pat_history->liquor_seems : '' }} </td>
                                <td rowspan="3"> </td>
                                <td></td>
                            </tr>

                            <tr>
                                <td>
                                    <strong>Bimanual:
                                        {{ !empty($pat_history->bimanual) ? $pat_history->bimanual : '' }}</strong>
                                </td>
                            </tr>



                            <tr>
                                <td>
                                    <ul>
                                        <li>Fundal Height:
                                            {{ !empty($pat_history->fundal_height) ? $pat_history->fundal_height : '' }}
                                        </li>
                                        <li>Ascultation:
                                            {{ !empty($pat_history->ascultation) ? $pat_history->ascultation : '' }}
                                        </li>
                                        <li>FHR: {{ !empty($pat_history->fhr) ? $pat_history->fhr : '' }}</li>
                                    </ul>
                                </td>
                                <td></td>
                                <td>
                                    <ul>
                                        <li>Uterine Size:
                                            {{ !empty($pat_history->uterine_size) ? $pat_history->uterine_size : '' }}"
                                        </li>
                                        <li>A/V or R/V: {{ !empty($pat_history->av) ? $pat_history->av : '' }}</li>
                                        <li>CET: {{ !empty($pat_history->cet) ? $pat_history->cet : '' }}</li>
                                        <li>Fornics: {{ !empty($pat_history->fornics) ? $pat_history->fornics : '' }}
                                        </li>
                                    </ul>
                                </td>

                            </tr>


                        </tbody>
                    </table>
                </div>
            </div>
            <!--Reproductive System end  -->


            <!-- note start -->

            <div class="row" style="margin-top: 20px;">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">Salient Feature :</span>
                </div>
                @php
                    $height = isset($pat_history->salient_feature) ? '' : 'height:600px;';
                @endphp
                <div class="col-lg-12" style="width: 99%;">
                    <table style="width: 80%; margin-left: auto;{{ $height }}">
                        <tr>
                            <td style="font-size: 12px;  padding: 3px;">
                                {{ !empty($pat_history->salient_feature) ? $pat_history->salient_feature : '' }}
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <!-- note end -->


            <!-- Provisional Diagnosis start -->

            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">Provisional Diagnosis :</span>
                </div>

                <div class="col-lg-12" style="width: 99%;">
                    <table style="width: 80%; margin-left: auto;">
                        <tr>
                            <td style="font-size: 12px;  padding: 3px;">
                                {{ !empty($pat_history->provisional_diagnosis) ? $pat_history->provisional_diagnosis : '' }}
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <!-- Provisional Diagnosis end -->

            <!-- Differential Diagnosis start -->

            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">Differential Diagnosis :</span>
                </div>

                <div class="col-lg-12" style="width: 99%;">
                    <table style="width: 80%; margin-left: auto;">
                        <tr>
                            <td style="font-size: 12px;  padding: 3px;">
                                {{ !empty($pat_history->differential_diagnosis) ? $pat_history->differential_diagnosis : '' }}
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <!-- Differential Diagnosis end -->

            <!-- Investigations start -->

            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">Investigations :</span>
                </div>

                <div class="col-lg-12" style="width: 99%;">
                    <table style="width: 80%; margin-left: auto;">
                        <tr>
                            <td style="font-size: 12px;  padding: 3px;">
                                {{ !empty($pat_history->investigations) ? $pat_history->investigations : '' }}
                            </td>
                        </tr>

                    </table>
                </div>
            </div>
            <!-- Investigations end -->

            <!-- Confirmed Diagnosis  start -->

            <div class="row" style="margin-top: 5px;">
                <div class="col-lg-12" style="width: 100%;">
                    <span class="heading_patient">Confirmed Diagnosis :</span>
                </div>
                @php
                    $height = isset($pat_history->confirmed_diagnosis) ? '' : 'height:100px;';
                @endphp
                <div class="col-lg-12" style="width: 99%;">
                    <table style="width: 80%; margin-left: auto;">
                        <tr>
                            <td style="font-size: 12px;  padding: 3px;{{  $height }}">
                                {{ !empty($pat_history->confirmed_diagnosis) ? $pat_history->confirmed_diagnosis : '' }}
                            </td>
                        </tr>


                    </table>
                </div>
            </div>
            <!-- Confirmed Diagnosis end -->
            <div class="row " style="margin-top: 5px; justify-content:end;">
                <div class="col-lg-6 cleafix" style="width: 50%;">
                    <div class="signing__box" style="float:right;">
                        <div class="divided" style="border-top: 1px solid #333;"></div>
                        <p>Name & Sign of Receiving Doctor</p>
                    </div>

                </div>
            </div>
        </div>
    </section>
</body>

</html>
