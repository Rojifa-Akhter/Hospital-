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
    @if(Session::get('user.ses_hospital_code') == "UNICO")
        <title>Face Sheet</title>
    @else
        <title>IPD Admission Form</title>
    @endif

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

        .bed_transfer_table{
            width:100%;
            border-collapse: collapse;
        }

        .bed_transfer_table>thead>tr>th, .bed_transfer_table>tbody>tr>td{
           border:1px solid black;
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
                                        style="width: 90%;height:90%" alt="">
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
                            @if(Session::get('user.ses_hospital_code') == "UNICO")
                                <strong>FACE SHEET</strong>
                            @else
                                <strong>Admission Form</strong>
                            @endif

                            <br>

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
                    <td><strong> @if (Session::get('user.ses_hospital_code')=="KPJ") MRN  @else UHID ID @endif</strong></td>
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
                    <td><strong>Sex</strong></td>
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
                    <td><strong> Patient Category </strong></td>
                    <td style="padding-bottom: 10px"> : {{ $admission_pat->patient_type_code }}</td>
                </tr>

                <tr>
                    <td colspan="4" style="text-align: left; font-size:15px; padding-bottom:15px"> <strong> <span
                                style="border-bottom: 1px solid black"> Admission Details </span> </strong></td>
                </tr>
                <tr>
                    <td><strong>Admission Date </strong></td>
                    <td> : {{ date('d/m/Y h:i:s a', strtotime($admission_pat->admission_date)) }}</td>
                    {{-- <td><strong> Admitted Department</strong></td>
                    <td> :
                        </strong>{{ $admission_pat->admitted_dept != '' ? $admission_pat->admitted_dept : '' }}
                    </td> --}}
                    <td><strong> @if(Session::get('user.ses_hospital_code')=="UNICO") Nurse Station @else  Department Name @endif</strong></td>
                    <td colspan="3"> :
                        </strong> @foreach($bed_history as $item)
                        @if($loop->first)
                            {{ $item->serviceunit_name }}
                        @endif
                    @endforeach
                    </td>
                </tr>

                <tr>
                    <td><strong> Admitted Consultant</strong></td>
                    <td> : <strong>{{ $admission_pat->primary_doctor_name }} </strong></td>
                    <td><strong>Ward Name </strong></td>
                    <td> :  @foreach($bed_history as $item)
                        @if($loop->first)
                            {{ $item->ward_name }}
                        @endif
                    @endforeach
                    </td>
                </tr>

                <tr>
                    <td><strong> Admitted Department</strong></td>

                    <td> : @foreach($bed_history as $item)
                        @if($loop->first)
                            {{ $item->serviceunit_name }}
                        @endif
                    @endforeach</td>

                    <td><strong>Bed Name </strong></td>
                    <td> :
                        @foreach($bed_history as $item)
                        @if($loop->first)
                            {{ $item->bed_name }}
                        @endif
                    @endforeach
                    </td>
                    </td>
                </tr>

                <tr>
                    <td colspan="4" style="text-align: left; font-size:15px; padding-bottom:15px"> <strong> <span
                                style="border-bottom: 1px solid black"> Additional Info </span> </strong></td>
                </tr>



                <tr>
                    <td><strong>National ID/Passport No.</strong></td>
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
                    <td colspan=""> : {{ $admission_pat->second_ref_doctor_name }}</td>
                    <td><strong>Covid Vaccination</strong></td>
                    <td> : {{ !empty($admission_pat->covid_vaccinated_ind == 1) ? 'Yes' : 'No' }}</td>
                </tr>
                <tr>
                    <td><strong>Remarks </strong></td>
                    <td> : {{ $admission_pat->remarks }}</td>

                </tr>

                {{-- <tr>
                    <td><strong>Discharge Date  </strong></td>
                    <td rowspan="3"> : </td>
                </tr> --}}

            </table>

            {{-- @dd($bed_history); --}}

            @if(Session::get('user.ses_hospital_code') != "UNICO")
                <h4 class="text-center mt-2"><b>Bed Transfer History</b></h4>

                <table class="table bed_transfer_table">
                    <thead class="global-uhl-table-bg">
                        <tr>
                            <th class="text-center" style="width: 5%">SL</th>
                            <th class="text-center" style="width: 12%">IP No</th>
                            <th class="text-left" style="width: 19%">Bed Name</th>
                            <th class="text-left" style="width: 17%">Bed Category</th>
                            <th class="text-left" style="width: 19%">Start Time</th>
                            <th class="text-left" style="width: 19%">End Time</th>
                            <th class="text-center" style="width: 11%">Bed Status</th>
                        </tr>
                    </thead>
                    <tbody>
                        @forelse($bed_history as $key => $item)
                            <tr>
                                <td class="text-center">{{++$key}}</td>
                                <td class="text-center">{{$item->admission_no_fk}}</td>
                                <td class="text-left">{{$item->bed_no_fk}} - {{$item->bed_name}}</td>
                                <td class="text-left">{{$item->ward_no_fk}} - {{$item->ward_name}}</td>
                                <td class="text-left">
                                    @if(!empty($item->start_time))
                                        {{date('d/m/Y h:i:s a',strtotime($item->start_time))}}
                                    @endif
                                </td>
                                <td class="text-left">
                                    @if(!empty($item->end_time))
                                        {{date('d/m/Y h:i:s a',strtotime($item->end_time))}}
                                    @endif
                                </td>

                                <td class="text-center">
                                    @if(empty($item->end_time))
                                        <span class="badge badge-primary">Active</span>
                                    @else
                                        <span class="badge badge-danger">Inactive</span>
                                    @endif
                                </td>
                            </tr>
                        @empty
                            <tr>
                                <td colspan="7" class="text-center text-danger">Data Not Found</td>
                            </tr>
                        @endforelse
                    </tbody>
                </table>
            @endif

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
