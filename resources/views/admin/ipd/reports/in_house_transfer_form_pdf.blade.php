<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>in house transfer form</title>


    <style>
        .fs-12 {
            font-size: 14px;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .table-bordered {
            border: 1px solid #333;
        }

        td {
            font-size: 13px;
            border: 1px solid #333;
            padding-right: 3px;
        }


        .form-check {
            position: relative;
            display: block;
            padding-left: 1.25rem;
        }

        .form-check-inline {
            display: inline-block !important;
            margin-right: 1rem;
        }

        .form-check-input {
            position: static;
            margin-top: 0.3rem;
            margin-left: -1.25rem;
        }

        .form-check-label {
            margin-bottom: 0px !important;
        }

        .w-16 {
            width: 16%;
        }

        .w-8 {
            width: 8%;
        }

        .w-15 {
            width: 15%;
        }

        .w-25 {
            width: 25%;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center;
        }

        .text-right {
            text-align: right;
        }

        .header>tbody>tr>td,
        .header>thead>tr>td {
            border: none;
        }

        body {
            /* margin-top: 4cm; */
            margin-bottom: 0.6cm;
            margin-left: 1cm;
        }

        .footer-table {
            /* position: absolute;
            bottom: 0px;
            width: 100%; */

            margin-top: 10px;
        }

        td {
            page-break-inside: avoid
        }

        .removeMargin p {
            margin: 0;
        }
    </style>
</head>

<body onload="window.print()">

    <table class="table header">
        <thead>
            <tr>
                <td style="width:65%">
                    <ul style="list-style: none; padding-left: 0; display:inline-block;">
                        <li><b>IP
                                No:</b>&nbsp;<span>{{ isset($pat_info->admission_no_pk) ? $pat_info->admission_no_pk : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} "></li>
                        <li><span><b>Name:</b>{{ isset($pat_info->patient_name) ? $pat_info->patient_name : '' }}</span>
                            &nbsp;<span><b>Age:</b>{{ isset($pat_info->age) ? $pat_info->age : '' }}</span>
                            &nbsp;<b>Gender:</b><span>{{ isset($pat_info->gender_txt) ? $pat_info->gender_txt : '' }}</span>
                            &nbsp;<b>Bed:</b>&nbsp;<span>{{ isset($pat_info->bed_name) ? $pat_info->bed_name : '' }}</span>
                        </li>
                        <li><b>Con. Number :</b>&nbsp;<span>{{ $pat_info->mobile1 }}</span></li>
                        <li><b>Consultant Name:</b>&nbsp;<span>{{ @$pat_info->primary_doctor_name }}</span></li>
                    </ul>
                </td>
                <td style="text-align:right;width:35%">
                    <ul style="list-style: none; padding-left: 0;">
                        <li><b>UHID:</b>&nbsp;<span>{{ isset($pat_info->patient_code) ? $pat_info->patient_code : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $pat_barcode }} "></li>
                        <li><b>Phone:</b>&nbsp;<span>{{ isset($pat_info->mobile1) ? $pat_info->mobile1 : '' }}</span>
                        </li>
                        <li><b>IP
                                Date:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($pat_info->admission_date)) }}</span>
                        </li>
                        @if (!empty($pat_info->dis_datetime))
                            <li><b>Date of
                                    Discharge:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($pat_info->dis_datetime)) }}</span>
                            </li>
                        @endif

                    </ul>
                </td>
            </tr>
        </thead>


        <tbody>
            <tr>
                <td colspan="2">
                    <div
                        style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
                        <span style="font-size: 16px;"><b>IN HOUSE TRANSFER FORM</b></span>

                    </div>
                    <table width="100%" class="table table-bordered">
                        <tbody>
                            <tr>
                                <td colspan="8"><strong>Date of
                                        transfer: </strong>{{ @$inHouseTransferFormData->date_of_transfer }}</td>
                            </tr>
                            <tr>
                                <td colspan="8"><strong>Vitals</strong></td>
                            </tr>
                            <tr>
                                <td colspan="3"><strong>Temp:</strong> {{ @$inHouseTransferFormData->vital_temp }} F
                                </td>

                                <td colspan="3"><strong>Pules:</strong> {{ @$inHouseTransferFormData->vital_pulse }}
                                    /mt</td>

                                <td colspan="2"><strong>Resp:</strong>
                                    {{ @$inHouseTransferFormData->vital_resp }}/mt</td>


                            </tr>

                            <tr>
                                <td colspan="3"><strong>SPo2:</strong> {{ @$inHouseTransferFormData->vital_spo2 }} %
                                </td>


                                <td colspan="3"><strong>BP:</strong> {{ @$inHouseTransferFormData->vital_bp }} v
                                </td>


                                <td colspan="2"><strong>Pain Score:</strong>
                                    {{ @$inHouseTransferFormData->vital_painscore }}
                                    /10</td>


                            </tr>
                            <tr>
                                <td colspan="4"><strong>Allergies: </strong> @php
                                    $allergies = @$inHouseTransferFormData->allergies;
                                    $allergiesText = $allergies == '1' ? 'No' : ($allergies == '2' ? 'Yes' : 'N/A');
                                @endphp
                                    <span>{{ $allergiesText }}</span>





                                </td>
                                <td colspan="4">
                                    <span>If Yes, Specify:</span>
                                    <span>{{ @$inHouseTransferFormData->allergies_specify }}</span>
                                </td>


                            </tr>

                            <tr>
                                <td colspan="4"><strong>Diet advice: </strong>
                                    {{ @$inHouseTransferFormData->diet_advice }}</td>

                                <td colspan="4"><strong>Informed dietry:</strong> @php
                                    $informed_dietry = @$inHouseTransferFormData->informed_dietry;
                                    $informedText =
                                        $informed_dietry == '1' ? 'No' : ($informed_dietry == '2' ? 'Yes' : 'N/A');
                                @endphp
                                    {{ $informedText }}</td>


                            </tr>

                            <tr>

                                <td colspan="8"><strong>Invasive lines and infusions: </strong>
                                    {{ @$inHouseTransferFormData->invasive_lines_infus }}</td>

                            </tr>
                            <tr>
                                <td class="text-left" colspan="4"><strong>a. Peripheral:</strong> @php
                                    $peripheral = @$inHouseTransferFormData->peripheralnother;
                                    $peripheralText = 'N/A';
                                    if ($peripheral === 'cental') {
                                        $peripheralText = 'Cental';
                                    } elseif ($peripheral === 'PICC') {
                                        $peripheralText = 'PICC';
                                    } elseif ($peripheral === 'chemo_port') {
                                        $peripheralText = 'Chemo Port';
                                    } elseif (strtolower($peripheral) === 'other') {
                                        $peripheralText = 'Other';
                                    }
                                @endphp
                                    {{ $peripheralText }}</td>

                                <td class="text-left" colspan="4">
                                    <strong>Site:</strong>
                                    @php
                                        $site = @$inHouseTransferFormData->peripheralnother_site;
                                        $siteText = $site == '1' ? 'Right' : ($site == '2' ? 'Left' : 'N/A');
                                    @endphp
                                    {{ $siteText }}
                                </td>
                            </tr>


                            <tr>
                                <td class="text-left" colspan="4"><strong>b. Infusions:</strong>
                                    {{ @$inHouseTransferFormData->infusions }}</td>

                                <td class="text-left" colspan="4"><strong>Rate:</strong>
                                    {{ @$inHouseTransferFormData->infusions_rate }}</td>

                            </tr>

                            <tr>
                                <td class="text-left" colspan="4"><Strong>Tubes/Drains:
                                        {{ @$inHouseTransferFormData->tubes_drains_amount }}</Strong>
                                </td>

                                <td class="text-left" colspan="4"><strong>a. Chest: </strong> @php
                                    $chestDrain = @$inHouseTransferFormData->tube_drain_chest;
                                    $chestDrainText = $chestDrain == '1' ? 'No' : ($chestDrain == '2' ? 'Yes' : 'N/A');
                                @endphp
                                    {{ $chestDrainText }}</td>

                            </tr>

                            <tr>
                                <td class="text-left" colspan="4"><strong>b. Abdomen:</strong>
                                    {{ @$inHouseTransferFormData->tube_drain_abdomen == '1'
                                        ? 'No'
                                        : (@$inHouseTransferFormData->tube_drain_abdomen == '2'
                                            ? 'Yes'
                                            : 'N/A') }}
                                </td>


                                <td class="text-left" colspan="4"><strong>d. Foleys: </strong>
                                    {{ @$inHouseTransferFormData->tube_drain_foleys == '1'
                                        ? 'No'
                                        : (@$inHouseTransferFormData->tube_drain_foleys == '2'
                                            ? 'Yes'
                                            : 'N/A') }}
                                </td>

                            </tr>




                            <tr>
                                <td class="text-left" colspan="4"><strong>c. NG tube: </strong> @php
                                    $ngTubeDrain = @$inHouseTransferFormData->tube_drain_ngtube;
                                    $ngTubeDrainText =
                                        $ngTubeDrain == '1' ? 'No' : ($ngTubeDrain == '2' ? 'Yes' : 'N/A');
                                @endphp
                                    {{ $ngTubeDrainText }}</td>

                                <td class="text-left" colspan="4"><strong>Other:</strong>
                                    {{ @$inHouseTransferFormData->tube_drain_other }}</td>

                            </tr>

                            <tr>
                                <td class="text-left" colspan="4"><Strong>Intake: </Strong>
                                    {{ @$inHouseTransferFormData->intake }}</td>

                                <td class="text-left" colspan="4">
                                    <Strong>Output:</Strong>{{ @$inHouseTransferFormData->output }}
                                </td>

                            </tr>

                            <tr>
                                <td class="text-left" colspan="4"><strong>Transfer request placed
                                        in HIS and intimated to operation staff</strong></td>
                                <td class="text-left" colspan="4">
                                    @php
                                        $transferReq = @$inHouseTransferFormData->transfer_req_placed_staff;
                                        $transferReqText =
                                            $transferReq == '1' ? 'No' : ($transferReq == '2' ? 'Yes' : 'N/A');
                                    @endphp
                                    {{ $transferReqText }}
                                </td>

                            </tr>

                            <tr>
                                <td colspan="3" class="text-left">
                                    <strong>Patient transfer and equipment requirement informed next unit:</strong>
                                </td>
                                <td colspan="2" class="text-left">
                                    @php
                                        $equipment = @$inHouseTransferFormData->pat_transfer_info_nxt_unit;

                                        switch ($equipment) {
                                            case 'infusion_pump':
                                                $equipmentText = 'Infusion pump';
                                                break;
                                            case 'syringe_pump':
                                                $equipmentText = 'Syringe pump';
                                                break;
                                            case 'cardiac_monitor':
                                                $equipmentText = 'Cardiac monitor';
                                                break;
                                            case 'pulse_oximete_DVT_pump':
                                                $equipmentText = 'Pulse oximete DVT pump';
                                                break;
                                            case 'air_mattress':
                                                $equipmentText = 'Air Mattress';
                                                break;
                                            case 'BiPAP':
                                                $equipmentText = 'BiPAP';
                                                break;
                                            case 'etc.':
                                                $equipmentText = 'etc.';
                                                break;
                                            default:
                                                $equipmentText = 'N/A';
                                                break;
                                        }
                                    @endphp
                                    {{ $equipmentText }}
                                </td>

                                <td colspan="2" class="text-left">
                                    @php
                                        $unitDropdown = @$inHouseTransferFormData->unit_dropdown;
                                        $unitDropdownText =
                                            $unitDropdown == '1' ? 'No' : ($unitDropdown == '2' ? 'Yes' : 'N/A');
                                    @endphp
                                    {{ $unitDropdownText }}
                                </td>

                                <td colspan="1" class="text-left">
                                    {{ @$inHouseTransferFormData->pat_transfer_by_whom ?? 'N/A' }}
                                </td>
                            </tr>



                            <tr>
                                <td class="text-left" colspan="4">
                                    <strong>Before shifting, enquired room and equipment readiness:</strong>
                                </td>
                                <td class="text-left" colspan="4">
                                    @php
                                        $beforeShifting = @$inHouseTransferFormData->before_shitting_chk;
                                        $beforeShiftingText =
                                            $beforeShifting == '1' ? 'No' : ($beforeShifting == '2' ? 'Yes' : 'N/A');
                                    @endphp
                                    {{ $beforeShiftingText }}
                                </td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="4">
                                    <strong>Transfer informed to patient room and bystander:</strong>
                                </td>
                                <td class="text-left" colspan="4">
                                    @php
                                        $transferInfo = @$inHouseTransferFormData->transfer_info_pat_bystander;
                                        $transferInfoText =
                                            $transferInfo == '1' ? 'No' : ($transferInfo == '2' ? 'Yes' : 'N/A');
                                    @endphp
                                    {{ $transferInfoText }}
                                </td>
                            </tr>

                            <tr>
                                <td class="text-left" colspan="2"><strong>During Transfer, Availability of
                                        bystander:</strong></td>
                                <td class="text-left" colspan="2">
                                    @php
                                        $bystander = @$inHouseTransferFormData->transfer_info_pat_bystander;
                                        $bystanderText = $bystander == '1' ? 'No' : ($bystander == '2' ? 'Yes' : 'N/A');
                                    @endphp
                                    {{ $bystanderText }}
                                </td>

                                <td class="text-left" colspan="2"><strong>Patient and family education
                                        given:</strong></td>
                                <td class="text-left" colspan="2">
                                    @php
                                        $familyEdu = @$inHouseTransferFormData->pat_family_edu_given;
                                        $familyEduText = $familyEdu == '1' ? 'No' : ($familyEdu == '2' ? 'Yes' : 'N/A');
                                    @endphp
                                    {{ $familyEduText }}
                                </td>
                            </tr>
                            <tr>
                                <td class="text-left" colspan="3"><strong>Patient belongings:</strong></td>
                                <td class="text-left" colspan="3">
                                    @php
                                        $belonging = @$inHouseTransferFormData->patient_belongings;
                                        switch ($belonging) {
                                            case 'dentures':
                                                $belongingText = 'Dentures';
                                                break;
                                            case 'lens':
                                                $belongingText = 'Lens';
                                                break;
                                            case 'cloth':
                                                $belongingText = 'Cloth';
                                                break;
                                            case 'others':
                                                $belongingText = 'Others';
                                                break;
                                            default:
                                                $belongingText = 'N/A';
                                        }
                                    @endphp
                                    {{ $belongingText }}
                                </td>

                                <td class="text-left" colspan="2">
                                    @php
                                        $belongingSpecify = @$inHouseTransferFormData->pat_belongings_secify;
                                        $belongingSpecifyText =
                                            $belongingSpecify == '1'
                                                ? 'No'
                                                : ($belongingSpecify == '2'
                                                    ? 'Yes'
                                                    : 'N/A');
                                    @endphp
                                    {{ $belongingSpecifyText }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="8"><strong>Item handed over</strong></td>
                            </tr>

                            <tr>
                                <td colspan="2"><strong>a. Debulk file:</strong></td>
                                <td class="text-left" colspan="2">
                                    @php
                                        $debulk = @$inHouseTransferFormData->debulk_inv_files;
                                        switch ($debulk) {
                                            case 'ECG':
                                                $debulkText = 'ECG';
                                                break;
                                            case 'doppler':
                                                $debulkText = 'Doppler';
                                                break;
                                            case 'x-ray':
                                                $debulkText = 'X-ray';
                                                break;
                                            case 'CT':
                                                $debulkText = 'CT';
                                                break;
                                            case 'MRI':
                                                $debulkText = 'MRI';
                                                break;
                                            case 'USG':
                                                $debulkText = 'USG';
                                                break;
                                            case 'CD':
                                                $debulkText = 'CD';
                                                break;
                                            default:
                                                $debulkText = 'N/A';
                                        }
                                    @endphp
                                    {{ $debulkText }}
                                </td>

                                <td colspan="2"><strong>Others:</strong></td>
                                <td class="text-left" colspan="2">
                                    {{ @$inHouseTransferFormData->debulk_inv_files_specify ?? 'N/A' }}
                                </td>
                            </tr>


                            <tr>
                                <td colspan="2"><strong>b. Thermometer:</strong></td>
                                <td class="text-left" colspan="2">
                                    @php
                                        $thermoItem = @$inHouseTransferFormData->thermometer_hand_rub_etc;
                                        switch ($thermoItem) {
                                            case 'han_rub':
                                                $thermoText = 'Han rub';
                                                break;
                                            case '02_mask':
                                                $thermoText = 'O2 Mask';
                                                break;
                                            case 'bedpan':
                                                $thermoText = 'Bedpan';
                                                break;
                                            case 'nasal_prongs':
                                                $thermoText = 'Nasal prongs';
                                                break;
                                            case 'sputum_cup':
                                                $thermoText = 'Sputum cup';
                                                break;
                                            case 'basin':
                                                $thermoText = 'Basin';
                                                break;
                                            default:
                                                $thermoText = 'N/A';
                                        }
                                    @endphp
                                    {{ $thermoText }}
                                </td>

                                <td colspan="2"><strong>Others:</strong></td>
                                <td class="text-left" colspan="2">
                                    N/A {{-- এখানে যদি ভবিষ্যতে `others` এর জন্য আলাদা ফিল্ড যুক্ত করো, সেই অনুযায়ী value বসিয়ে নিও --}}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="2"><strong>Skin integrity:</strong> Intake</td>
                                <td class="text-left" colspan="2">
                                    @php
                                        $skinIntact = @$inHouseTransferFormData->skin_integrity_intact;
                                        $skinIntactText =
                                            $skinIntact == '1' ? 'Yes' : ($skinIntact == '2' ? 'No' : 'N/A');
                                    @endphp
                                    {{ $skinIntactText }}
                                </td>

                                <td colspan="4"><strong>If No: details: </strong>
                                    {{ @$inHouseTransferFormData->skin_int_intact_detail ?? 'N/A' }}</td>

                            </tr>

                            <tr>
                                <td colspan="3"></td>
                                <td colspan="2"><strong>Signature of Assigned Nurse</strong></td>
                                <td colspan="2"><strong>Signature of HN</strong></td>
                                <td colspan="2"><strong>Signature of TL</strong></td>
                            </tr>

                            <tr>
                                <td colspan="3">
                                    <strong>Check before leaving the unit</strong>
                                </td>
                                <td colspan="2">
                                    @php
                                        $nurseSign = @$inHouseTransferFormData->leaving_unit_nurse_sigh ?? 'N/A';
                                    @endphp
                                    <strong>Nurse:</strong> {{ $nurseSign }}
                                </td>
                                <td colspan="2">
                                    @php
                                        $hnSign = @$inHouseTransferFormData->leaving_unit_hn_sigh ?? 'N/A';
                                    @endphp
                                    <strong>HN:</strong> {{ $hnSign }}
                                </td>
                                <td colspan="2">
                                    @php
                                        $tlSign = @$inHouseTransferFormData->leaving_unit_tl_sigh ?? 'N/A';
                                    @endphp
                                    <strong>TL:</strong> {{ $tlSign }}
                                </td>
                            </tr>

                            <tr>
                                <td colspan="3">
                                    <strong>Checked by receiving unit</strong>
                                </td>
                                <td colspan="2">
                                    @php
                                        $receiveNurseSign = @$inHouseTransferFormData->receive_unit_nurse_sigh ?? 'N/A';
                                    @endphp
                                    <strong>Nurse:</strong> {{ $receiveNurseSign }}
                                </td>
                                <td colspan="2">
                                    @php
                                        $receiveHN = @$inHouseTransferFormData->receive_unit_hn_sigh ?? 'N/A';
                                    @endphp
                                    <strong>HN:</strong> {{ $receiveHN }}
                                </td>
                                <td colspan="2">
                                    @php
                                        $receiveTL = @$inHouseTransferFormData->receive_unit_tl_sigh ?? 'N/A';
                                    @endphp
                                    <strong>TL:</strong> {{ $receiveTL }}
                                </td>
                            </tr>


                            <tr>
                                <td colspan="6"><strong>Skin related issues informed to nursing quality
                                        department:</strong></td>
                                <td colspan="2">
                                    @php
                                        $skinRelated = @$inHouseTransferFormData->skin_related_issues;
                                        $skinRelatedText =
                                            $skinRelated == '1' ? 'No' : ($skinRelated == '2' ? 'Yes' : 'N/A');
                                    @endphp
                                    {{ $skinRelatedText }}
                                </td>
                            </tr>
                            <tr>
                                <td colspan="8"> <strong> * Any difference in opinion to be the
                                        immediate in charge / on duty supervisor</strong>
                                </td>
                            </tr>

                            <tr>
                                <td colspan="8"><strong>Any other remarks: </strong>
                                    {{ @$inHouseTransferFormData->any_other_remarks }}</td>

                            </tr>

                            <tr>
                                <td colspan="2">

                                </td>
                                <td colspan="3">
                                    <strong> Handed over accompanying RN
                                    </strong>
                                </td>
                                <td colspan="3">
                                    <strong>Taken Over Receiving RN</strong>
                                </td>


                            </tr>


                            <tr>
                                <td colspan="2">
                                    <strong> Signature</strong>
                                </td>
                                <td colspan="3">
                                    {{ @$inHouseTransferFormData->sign_handed_over_rn }}
                                </td>
                                <td colspan="3">
                                    {{ @$inHouseTransferFormData->sign_receivingr_rn }}
                                </td>


                            </tr>

                            <tr>
                                <td colspan="2">
                                    <strong>EMP. ID</strong>
                                </td>
                                <td colspan="3">
                                    {{ @$inHouseTransferFormData->empid_handed_over_rn }}
                                </td>
                                <td colspan="3">
                                    {{ @$inHouseTransferFormData->empid_receiving_rn }}
                                </td>

                            </tr>

                            <tr>
                                <td colspan="2"><strong>Date/Time </strong></td>
                                <td colspan="3">
                                    {{ isset($inHouseTransferFormData->datetime_handed_over_rn) ? \Carbon\Carbon::parse($inHouseTransferFormData->datetime_handed_over_rn)->format('d-m-Y H:i') : 'N/A' }}
                                </td>
                                <td colspan="3">
                                    {{ isset($inHouseTransferFormData->datetime_receiving_rn) ? \Carbon\Carbon::parse($inHouseTransferFormData->datetime_receiving_rn)->format('d-m-Y H:i') : 'N/A' }}
                                </td>
                            </tr>

                            {{-- // end  --}}

                        </tbody>
                    </table>
</body>

</html>
