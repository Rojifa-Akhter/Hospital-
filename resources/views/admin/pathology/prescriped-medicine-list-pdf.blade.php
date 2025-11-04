<!DOCTYPE html>
<html>

<head>
    <style>
        @page {

           margin-top: 80px;

                margin-left: 40px;
                margin-right: 20px;
                margin-right: 0cm;
            margin-bottom: 30px;
        }

        /* body {
            margin-left: 0cm;
            margin-right: 0cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 12px;
        } */

        table {
            border-collapse: collapse;
            width: 100%;
        }

        table tr td,
        table tr th {
            font-size: 12px;
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

            margin: 0;
            padding: 0;
            font-family: 'Roboto', sans-serif;
            color: black;

        }

        footer {
            position: fixed;
            z-index: 999999999;
            left: 0;
            right: 0;
            /* height: 3cm; */
            text-align: center;
            font-size: 9px;
            margin-top: 30px;
            /* bottom: -85px; */
        }

        /* header {
            position: fixed;
            z-index: 999999999;
            margin-top:0px;
            padding-top:0px;

        } */
        header {
            /* position: fixed;
            left: 0;
            right: 0;
            font-size: 9px; */

            position: relative;
            top: 0;
            left: 0;
            right: 0;
            height: 10px;
            /* background: white; */


        }

        .print-body-start {
            margin-top: 125px;
        }



    </style>
</head>




<body>
    <header>

        {{-- <table width="100%">
        <tr>
            <td style="width: 15%;">
                @if (!empty($po_hospital_details->logo))
                    <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                        width="60px" />
                @endif
            </td>
            <td>
                <span style="font-size: 13px;">
                    <strong> {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                    </strong>
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
    </table> --}}



        <div style="text-align: center;font-size: 12px; font-style:bold">
            <span>Medicine Order</span>
        </div>
        <div class=""
            style="border: 1px solid #93a8bd; border-radius: 2px; height: 126px; padding: 5px; margin-top: -20px; font-size:10px !important;margin-right:10px !important;">
            <div class="patient-information d-flex align-items-center">
                <table width="100%" style="border-collapse: separate; border-spacing: 0; margin: 0; padding: 0;">
                    <tbody style="margin: 0; padding: 0;">
                        {{-- <tr style="margin: 0; padding: 0;">
                        <td class="text-left" style="vertical-align: top; margin: 0; padding: 0;">
                            <div style="margin: 0; padding: 0;">
                                <ul style="list-style: none; margin: 0; padding: 0;">
                                    <li
                                        style="display: inline-flex; flex-direction: column; align-items: left; margin: 0; padding: 0;">
                                        <img src="data:image/png;base64,{{ $patient_barcode }}"
                                            style="max-width: 150px; width: auto; height: auto; margin: 0; padding: 0;" />
                                        <figcaption
                                            style="display: block; margin: 4px 0 0; padding: 0; font-size: 10px; color: #000; text-align: left;">
                                            <b>
                                                @php
                                                    if (strtoupper(Session::get('user.ses_hospital_code')) == 'MCARE') {
                                                        echo 'Customer Id:';
                                                    } else {
                                                        echo 'UHID :';
                                                    }
                                                @endphp
                                            </b>&nbsp;{{ $prescription_mst->patient_code }}
                                        </figcaption>
                                    </li>


                                    @if ($prescription_mst->admission_no_fk != '' && $prescription_mst->admission_no_fk != 0)
                                        <li style="margin: 4px 0 0; padding: 0;">
                                            <b>Admission ID
                                                :</b>&nbsp;<span>{{ $prescription_mst->admission_no_fk }}</span>
                                        </li>
                                    @endif

                                    <li style="margin: 4px 0 0; padding: 0;">
                                        <b>Name
                                            :</b>&nbsp;<span>{{ ucwords($prescription_mst->patient_name) }}</span>
                                    </li>
                                    <li style="margin: 4px 0 0; padding: 0;">
                                        <b>Age / Sex:</b>&nbsp;<span>{{ $prescription_mst->age }} /
                                            {{ $prescription_mst->gender_txt }}</span>
                                    </li>
                                    <li style="margin: 4px 0 0; padding: 0;">
                                        <b>Contact:</b>&nbsp;<span>{{ $prescription_mst->mobile1 }}</span>
                                    </li>
                                </ul>
                            </div>
                        </td>

                        <td class="text-right" style="vertical-align: top; margin: 0; padding: 0;">
                            <div style="margin: 0; padding: 0;">
                                <ul style="list-style: none; margin: 0; padding: 0;">
                                    <li
                                        style="display: flex; flex-direction: column; align-items: flex-end; margin: 0; padding: 0;">
                                        <img src="data:image/png;base64,{{ $prescription_barcode }}"
                                            style="max-width: 150px; height: auto; margin: 0; padding: 0;" />
                                        <span style="font-size: 10px; color: #000; margin-top: 4px;">
                                            <b>Prescription ID
                                                :</b>&nbsp;{{ $prescription_med[0]->prescription_uid ?? '' }}
                                        </span>
                                    </li>

                                    <li style="margin: 4px 0 0; padding: 0;">
                                        <b>Prescription Date :</b>&nbsp;
                                        <span>{{ date('d/m/Y H:i A', strtotime($prescription_mst->prescription_date)) }}</span>
                                    </li>
                                    <li style="margin: 4px 0 0; padding: 0;">
                                        <b>Consultant Name
                                            :</b>&nbsp;<span>
                                            {{ $prescription_mst->doctor_name != '' ? ucwords($prescription_mst->doctor_name) : '' }}
                                            <div style="margin: 4px 0 0; padding: 0;">
                                                {{ $prescription_mst->degree_name != '' ? $prescription_mst->degree_name : '' }}
                                            </div>
                                        </span>
                                    </li>
                                </ul>
                            </div>
                        </td>
                    </tr> --}}
                        <tr>
                            <td colspan="2">
                                <table style="width:100%;border-collapse:collapse">
                                    <tbody>
                                        <tr>
                                            <td width="25%" class="text-left"><img
                                                    src="data:image/png;base64,{{ @$patient_barcode }} " /></td>
                                            <td width="50%" style="text-align:center" colspan="2">
                                            </td>
                                            <td width="25%" class="text-right"><img
                                                    src="data:image/png;base64, {{ @$prescription_barcode }} " /></td>
                                        </tr>
                                        <tr>
                                            <td width="15%" class="text-left"><strong>UHID</strong></td>
                                            <td width="35%" class="text-left">:<strong>
                                                    {{ strtoupper(@$prescription_mst->patient_code) }}</strong></td>
                                            <td width="25%" class="text-left"><strong>Prescription ID</strong></td>
                                            <td width="25%" class="text-left" style="white-space:nowrap;">:
                                                {{ @$prescription_mst->prescription_uid }}<span
                                                    style="font-size: 10px !important;">({{ @$prescription_mst->patient_type_code }})</span>
                                            </td>
                                        </tr>
                                        <tr>
                                            <td width="15%" class="text-left"><strong>Name</strong></td>
                                            <td width="35%" class="text-left">: {{ @$prescription_mst->salutation }}
                                                {{ ucwords(strtolower(@$prescription_mst->patient_name)) }}</td>
                                            <td width="25%" class="text-left" style="font-size: 11px;">
                                                <strong>Prescription Date</strong>
                                            </td>
                                            @if (Session::get('user.ses_hospital_code') == 'IMPALA')
                                                <td width="25%" class="text-left">:@if (!empty(@$prescription_mst->au_entry_at))
                                                        {{ date('d/m/Y h:i a', strtotime(@$prescription_mst->au_entry_at)) }}
                                                    @endif
                                                </td>
                                            @else
                                                <td width="25%" class="text-left">:@if (!empty(@$prescription_mst->prescription_date))
                                                        {{ date('d/m/Y h:i a', strtotime(@$prescription_mst->prescription_date)) }}
                                                    @endif
                                                </td>
                                            @endif
                                        </tr>

                                        <tr>
                                            <td width="15%"><strong>Age / Sex</strong></td>
                                            <td width="35%" style="font-size: 10px !important;">:
                                                {{ $prescription_mst->pat_age }}
                                                / @if ($prescription_mst->gender_txt == 'Female')
                                                    F
                                                @elseif ($prescription_mst->gender_txt == 'Male')
                                                    M
                                                @endif

                                            </td>
                                            <td width="25%"><strong>Department</strong></td>
                                            <td width="25%">: {{ $prescription_mst->specialization }}</td>
                                        </tr>
                                        <tr>
                                            <td width="15%"><strong>Consultant Name</strong></td>
                                            <td width="85%" colspan="3">:
                                                {{ $prescription_mst->doctor_name . ',' . $prescription_mst->degree_name }}
                                            </td>
                                        </tr>
                                    </tbody>
                                </table>
                            </td>
                        </tr>
                    </tbody>
                </table>


            </div>

        </div>
    </header>
    <div class="print-body-start">


        @php
            // dd($pres_med);
            $search_array = [
                '1',
                '2',
                '3',
                '4',
                '5',
                '6',
                '7',
                '8',
                '9',
                '0',
                'Jan',
                'Feb',
                'Mar',
                'Apr',
                'May',
                'Jun',
                'Jul',
                'Aug',
                'Sep',
                'Oct',
                'Nov',
                'Dec',
                ':',
                ',',
                'DAY',
                'MONTH',
                'WEEK',
                'YEAR',
                'HOUR',
            ];
            $replace_array = [
                '১',
                '২',
                '৩',
                '৪',
                '৫',
                '৬',
                '৭',
                '৮',
                '৯',
                '০',
                'জানুয়ারি',
                'ফেব্রুয়ারী',
                'মার্চ',
                'এপ্রিল',
                'মে',
                'জুন',
                'জুলাই',
                'আগষ্ট',
                'সেপ্টেম্বর',
                'অক্টোবর',
                'নভেম্বর',
                'ডিসেম্বর',
                ':',
                ',',
                'দিন',
                'মাস ',
                'সপ্তাহ ',
                'বছর',
                'ঘন্টা',
            ];
        @endphp
        <h3 style="padding: 0px;margin:0;font-size:18px !important;"><strong>R<sub>x</sub></strong></h3>
         @if (!empty($pres_med))
                        <table>
                            @foreach ($pres_med as $brand_name => $med_list)
                            <tr>
                                <td valign="top" width="20">{{ $loop->iteration }}.</td>
                                <td valign="top">
                                    <strong>{{ strtoupper($brand_name) }}</strong>

                                    @foreach ($med_list as $multidose)
                                    @php
                                    $medDate = $multidose->duration;
                                    $medDay = $multidose->duration_mu;

                                    $bn_medDate = str_replace($search_array, $replace_array, $medDate);
                                    $bn_medDay = str_replace($search_array, $replace_array, $medDay);
                                    @endphp

                                    <ul style="font-size:13px; margin-bottom: 4px;">
                                        <li>
                                            {{ $multidose->dosage }}
                                            {{ $multidose->route ? '- ' . strtoupper($multidose->route) . ' -' : '' }}

                                            @if ($multidose->continue_ind == '1' || $multidose->duration == 'Continue')
                                            @if (!empty($multidose->instruction_take))
                                            ({{ strtoupper($multidose->instruction_take) }})
                                            @endif
                                            <strong>- Continue</strong>
                                            @else
                                            @if (!empty($multidose->instruction_take))
                                            ({{ strtoupper($multidose->instruction_take) }})
                                            @endif
                                            <strong>- [{{ $medDate }} {{ $medDay }}]</strong>
                                            @endif
                                        </li>
                                    </ul>
                                    @endforeach
                                </td>
                            </tr>
                            @endforeach
                        </table>
                        @endif
    </div>
    <footer>
        <table style="border:0px; ">
            <?php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date = $dt->format('g:i A');
            ?>
            <tr>
                <td style="border: 0px; padding-top: 5px; text-align: left;">
                    Print : {{ Session::get('user.user_code') }} / <span> {{ date('d-m-Y') }} /
                        {{ $date }}</span>

                </td>
                <td style="border: 0px; padding-top: 5px;">Powered By: NEXTGEN IT</td>
            </tr>
        </table>

        {{-- <script type="text/php">
        $font = $fontMetrics->getFont("Arial", "normal");
        $pdf->page_text(530, 800, "Page {PAGE_NUM} of {PAGE_COUNT}", $font, 7, array(0, 0, 0));
    </script> --}}
    </footer>
</body>

<script>
    window.onload = function() {
        window.print();
    };

    window.onafterprint = function() {
        window.close(); // Close the window after printing
    }
</script>

</html>
