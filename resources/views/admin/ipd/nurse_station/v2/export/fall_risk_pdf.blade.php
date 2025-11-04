<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">
    <title>Modified Morse Fall Risk</title>


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

        .header>tbody>tr>td {
            border: none;
        }

        body {
            margin-bottom: 0.6cm;
            margin-left: 1cm;
        }

        .footer-table {
            margin-top: 10px;
        }

        td {
            page-break-inside: avoid
        }
    </style>
</head>

<body onload="window.print()">

    <table class="table header">
        <tbody>
            <tr>
                <td style="width:65%">
                    <ul style="list-style: none; padding-left: 0; display:inline-block;">
                        <li><b>IP
                                No:</b>&nbsp;<span>{{ isset($admission_info->admission_no_pk) ? $admission_info->admission_no_pk : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $invoice_barcode }} "></li>
                        <li><span><b>Name:</b>{{ isset($patient_info->patient_name) ? $patient_info->patient_name : '' }}</span>
                            &nbsp;<span><b>Age:</b>{{ isset($patient_info->age) ? $patient_info->age : '' }}</span>
                            &nbsp;<b>Gender:</b><span>{{ isset($patient_info->gender_txt) ? $patient_info->gender_txt : '' }}</span>
                            &nbsp;<b>Bed:</b>&nbsp;<span>{{ isset($admission_info->bed_name) ? $admission_info->bed_name : '' }}</span>
                        </li>
                        <li><b>Con. Number :</b>&nbsp;<span>{{ $patient_info->mobile1 }}</span></li>
                        <li><b>Consultant Name:</b>&nbsp;<span>{{ $admission_info->primary_doctor_name }}</span></li>
                    </ul>
                </td>
                <td style="text-align:right;width:35%">
                    <ul style="list-style: none; padding-left: 0;">
                        <li><b>UHID:</b>&nbsp;<span>{{ isset($patient_info->patient_code) ? $patient_info->patient_code : '' }}</span>
                        </li>
                        <li><img style="" src="data:image/png;base64, {{ $pat_barcode }} "></li>
                        <li><b>Phone:</b>&nbsp;<span>{{ isset($patient_info->mobile1) ? $patient_info->mobile1 : '' }}</span>
                        </li>
                        <li><b>IP
                                Date:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->admission_date)) }}</span>
                        </li>
                        @if (!empty($admission_info->dis_datetime))
                            <li><b>Date of
                                    Discharge:</b>&nbsp;<span>{{ date('d/m/Y h:i a', strtotime($admission_info->dis_datetime)) }}</span>
                            </li>
                        @endif

                    </ul>
                </td>
            </tr>
        </tbody>
    </table>

    <div
        style="padding: 7px; border-top:1px dotted black; border-bottom:1px dotted black;text-align:center;margin-top:10px; margin-bottom:20px">
        <span style="font-size: 16px;text-transform:uppercase"><b>Modified Morse Fall Risk</b></span>
    </div>

    <div class="table-responsive">
        <table class="table table-bordered">
            <thead>
                <tr>
                    <th class="text-left border-right-0" style="width:50%">PARAMETERS</th>
                    <th class="text-center border-left-0" style="width: 30%">SCALE</th>
                    <th class="text-center border-left-0" style="width:20%">CORE</th>

                </tr>
            </thead>

            <tbody>


                <tr>
                    <td class="text-left">History of fall(immediate/within 3 months)
                        <input type="hidden" class="custom-form" id="patient_no_fk" name="patient_no_fk"
                            value="{{ @$patient_info->patient_no_pk }}">
                        <input type="hidden" class="custom-form" id="admission_no_fk" name="admission_no_fk"
                            value="{{ @$patient_info->admission_no_pk }}">
                    </td>
                    <td class="text-center">
                        {{ @$data->his_fall == 0 ? 'No' : '' }}
                        {{ @$data->his_fall == 25 ? 'Yes' : '' }}
                    </td>
                    <td class="text-center"><span id="his_fall_text">{{ @$data->his_fall }}</span></td>
                </tr>

                <tr>
                    <td class="text-left">Age > 65 years /</td>
                    <td class="text-center">
                        {{ @$data->age == 0 ? 'No' : '' }}
                        {{ @$data->age == 15 ? 'Yes' : '' }}
                    </td>
                    <td class="text-center"><span id="age_text">{{ @$data->age }}</span></td>
                </tr>
                <tr>
                    <td class="text-left">Secondary diagnosis (if more than one diagnosis)</td>
                    <td class="text-center">
                        {{ @$data->sec_diagnosis == 0 ? 'No' : '' }}
                        {{ @$data->sec_diagnosis == 15 ? 'Yes' : '' }}
                    </td>
                    <td class="text-center"><span id="sec_diagnosis_text">{{ @$data->sec_diagnosis }}</span></td>
                </tr>

                <tr>

                    <td class="text-left">Ambulatory aids</td>
                    <td class="text-center">
                        {{ @$data->ambulatory_aids == 30 ? 'Furniture' : '' }}
                        {{ @$data->ambulatory_aids == 15 ? 'Crutches/cane/Walker' : '' }}
                        {{ @$data->ambulatory_aids == 0 && @$data->ambulatory_aids != null ? 'None/Bed Rest/nurse assist' : '' }}
                    </td>
                    <td class="text-center"><span id="ambulatory_aids_text">{{ @$data->ambulatory_aids }}</span></td>
                </tr>

                <tr>
                    <td class="text-left">Invasive Lines-Peripheral/central</td>
                    <td class="text-center">
                        {{ @$data->invasive_lines == 0 ? 'No' : '' }}
                        {{ @$data->invasive_lines == 20 ? 'Yes' : '' }}
                    </td>
                    <td class="text-center"><span id="invasive_lines_text">{{ @$data->invasive_lines }}</span></td>
                </tr>

                <tr>
                    <td class="text-left">Gait/Transferring</td>
                    <td class="text-center">
                        {{ @$data->gaint == 20 ? 'Impaired' : '' }}
                        {{ @$data->gaint == 10 ? 'Weak' : '' }}
                        {{ @$data->gaint == 0 ? 'Normal/Bed rest/immobile' : '' }}
                    </td>
                    <td class="text-center"><span id="gaint_text">{{ @$data->gaint }}</span></td>
                </tr>

                <tr>
                    <td class="text-left">Mental/Neurological status</td>
                    <td class="text-center">
                        {{ @$data->memtal == 20 ? 'Impaired vision/Impaired hearing' : '' }}
                        {{ @$data->memtal == 15 ? 'Forget limitations/ Dizziness/ Vertigo' : '' }}
                        {{ @$data->memtal == 0 ? 'Oriented to own ability' : '' }}
                    </td>
                    <td class="text-center"><span id="memtal_text">{{ @$data->memtal }}</span></td>
                </tr>

                <tr>
                    <td class="text-left">
                        <b>Medication Use</b>
                        Antihypertensive/hypoglycemic/

                        agents/Diuretics/

                        anticonvulsants/psychotropic/

                        antianxiety/narcotics/2hr post

                        sedation/Anesthesia
                    </td>
                    <td class="text-center">
                        {{ @$data->medication_use == 0 ? 'No' : '' }}
                        {{ @$data->medication_use == 25 ? 'Yes' : '' }}
                    </td>
                    <td class="text-center"><span id="medication_use_text">{{ @$data->medication_use }}</span></td>
                </tr>

                <tr>
                    <td class="text-right" colspan="2"><b>TOTAL SCORE</b></td>
                    <td class="text-center">
                        @php $total_score = @$data->his_fall +  @$data->age + @$data->sec_diagnosis + @$data->ambulatory_aids +  @$data->invasive_lines + @$data->gaint + @$data->memtal + @$data->medication_use ; @endphp
                        <span id="total_score"> <b>{{ $total_score }} </b></span>
                    </td>
                </tr>

                <tr>
                    <td class="text-left" colspan="3"><b>Fall prevention measures</b></td>
                    <td class="text-center"><span id="his_fall_text"></span></td>
                </tr>
                @php
                    $selectedValues = explode(',', $data->ipd_fall_preven_measures ?? '');
                @endphp
                <tr>
                    <td class="text-left" colspan="3">
                        <div>
                            @if (in_array(1, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="fall_prevention" value="1"
                                        name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="fall_prevention">Patient and family education
                                        on fall prevention
                                    </label>
                                </div>
                            @endif
                            @if (in_array(2, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="discuss_demonstrate"
                                        value="2" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="discuss_demonstrate">Discuss, demonstrate the
                                        use of call bell and keep the call bell within reach
                                    </label>
                                </div>
                            @endif
                            @if (in_array(3, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="keep_rails" value="3"
                                        name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="keep_rails">Keep the side rails up and
                                        instruct the patient not to climb over or between the rails.
                                    </label>
                                </div>
                            @endif
                            @if (in_array(4, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="keep_bed" value="4"
                                        name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="keep_bed">Keep bed wheels locked and in low
                                        position.
                                    </label>
                                </div>
                            @endif
                            @if (in_array(5, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="instruct_patient"
                                        value="5" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="instruct_patient">Instruct the patient about
                                        the use of grab bar and call bell in the toilet.
                                    </label>
                                </div>
                            @endif
                            @if (in_array(6, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="provide_adequate"
                                        value="6" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="provide_adequate">Provide adequate lighting
                                    </label>
                                </div>
                            @endif
                            @if (in_array(7, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="patient_unattended"
                                        value="7" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="patient_unattended">Don’t leave the patient
                                        unattended
                                    </label>
                                </div>
                            @endif
                            @if (in_array(8, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="while_transferring"
                                        value="8" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="while_transferring">While transferring,
                                        ensure the wheels of the stretcher/wheelchair are locked and safety belts are
                                        put on.
                                    </label>
                                </div>
                            @endif
                            @if (in_array(9, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="instruct_patient_get"
                                        value="9" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="instruct_patient_get">Instruct the patient to
                                        get up slowly and sit for a while. if you feel dizziness or weak, call for help
                                    </label>
                                </div>
                            @endif
                            @if (in_array(10, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="instruct_patient_hold"
                                        value="10" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="instruct_patient_hold">Instruct the patient
                                        not to hold cardiac table for support, as it is on wheels
                                    </label>
                                </div>
                            @endif
                            @if (in_array(11, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="instruct_patient_inform"
                                        value="11" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="instruct_patient_inform">Instruct the patient
                                        to inform staff, if any spill happens for immediate cleaning.
                                    </label>
                                </div>
                            @endif
                            @if (in_array(12, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="Keep_floor_neat"
                                        value="12" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="Keep_floor_neat">Keep the floor neat, clean
                                        and hazard free
                                    </label>
                                </div>
                            @endif
                        </div>
                        <div id="low_risk">
                            @if (in_array(13, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="keep_items" value="13"
                                        name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="keep_items"> Keep the items within easy
                                        reach. eg: water, phone, spectacles etc.
                                    </label>
                                </div>
                            @endif
                            @if (in_array(14, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="Instruct_bed" value="14"
                                        name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="Instruct_bed">Instruct the patient to call
                                        for help, if you want to get in or out of bed
                                    </label>
                                </div>
                            @endif
                            @if (in_array(15, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="instruct_barefoot"
                                        value="15" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="instruct_barefoot"> Instruct not to walk in
                                        barefoot and wear appropriate size slippers /shoes with non -skid soles
                                    </label>
                                </div>
                            @endif
                            @if (in_array(16, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="accompany" value="16"
                                        name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="accompany">Accompany the patient to the
                                        bathroom
                                        /toilet and keep the door unlocked.
                                    </label>
                                </div>
                            @endif
                        </div>
                        <div id="high_risk">
                            @if (in_array(17, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="possible_allot"
                                        value="17" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="possible_allot"> If possible, allot the
                                        room/bed
                                        near to the nurse’s station
                                    </label>
                                </div>
                            @endif
                            @if (in_array(18, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="frequent_observation"
                                        value="18" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="frequent_observation">Frequent observation of
                                        the
                                        patient
                                    </label>
                                </div>
                            @endif
                            @if (in_array(19, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="patient_high_risk"
                                        value="19" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="patient_high_risk">If patient is getting any
                                        high-risk medication or after any procedure, instruct the patient not to get up
                                        alone.
                                    </label>
                                </div>
                            @endif
                            @if (in_array(20, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="patient_agitated"
                                        value="20" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="patient_agitated">If the patient is agitated,
                                        can
                                        be put on restraint with doctor’s order.
                                    </label>
                                </div>
                            @endif
                            @if (in_array(21, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="restrict_patient"
                                        value="21" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="restrict_patient"> Restrict the patient
                                        movement
                                        to toilet by offering bed pan/urinal.
                                    </label>
                                </div>
                        </div>
                        @endif
                        <div id="no_risk">
                            @if (in_array(22, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="call_needed" value="22"
                                        name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="call_needed">Call for help if needed.
                                    </label>
                                </div>
                            @endif
                            @if (in_array(23, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="assist_comfortable"
                                        value="23" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="assist_comfortable">Assist the patient back
                                        to
                                        bed and make the patient comfortable.
                                    </label>
                                </div>
                            @endif
                            @if (in_array(24, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="inspect_consciousness"
                                        value="24" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="inspect_consciousness">Inspect for injury and
                                        reassess the patient’s vital signs and level of consciousness.
                                    </label>
                                </div>
                            @endif
                            @if (in_array(25, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="patient_high_risk"
                                        value="25" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="inform_simultaneously">Inform the doctor
                                        simultaneously and carry out order as per doctors’ instructions
                                    </label>
                                </div>
                            @endif
                            @if (in_array(26, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="fill_up" value="26"
                                        name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="fill_up">Fill up an incident form.
                                    </label>
                                </div>
                            @endif
                            @if (in_array(27, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="reassess" value="27"
                                        name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="reassess"> Reassess the fall risk and
                                        reeducate
                                        the patient and family.
                                    </label>
                                </div>
                            @endif
                            @if (in_array(28, $selectedValues))
                                <div class="form-check pl-4">
                                    <input class="form-check-input" type="checkbox" id="document_condition"
                                        value="28" name="fall_prevention[]" checked>
                                    <label class="form-check-label" for="document_condition">Document the patient
                                        condition after fall in daily nursing record.
                                    </label>
                                </div>
                            @endif
                        </div>
                    </td>
                </tr>

                {{-- @if ($total_score > 51)
                <tr>
                    <td class="text-center" colspan="2">High risk >51 High risk fall prevention measures provided</td>
                    <td class="text-center"><span id="his_fall_text"></span></td>
                </tr>
                @elseif($total_score > 25 && $total_score < 50)
                <tr>
                    <td class="text-center" colspan="2">Low risk 25-50 Low risk fall prevention measures provided</td>
                    <td class="text-center"><span id="his_fall_text"></span></td>
                </tr>
                
                @elseif($total_score > 0 && $total_score < 24)
                <tr>
                    <td class="text-center" colspan="2">No risk 0-24 Standard fail prevention measures provided</td>
                    <td class="text-center"><span id="his_fall_text"></span></td>
                </tr>
                @endif --}}
                <tr>
                    <td class="text-right" colspan="2"><b>R/N:</b></td>
                    <td>{{ @$data->asmnt_rn_no }}</td>
                </tr>
                <tr>
                    <td class="text-right" colspan="2"><b>Sign:</b></td>
                    <td>
                        {{ @$data->sign_name }}
                    </td>
                </tr>
                <tr>
                    <td class="text-right" colspan="2"><b>EMP. ID:</b></td>
                    <td>
                        {{ @$data->emp_name }}
                    </td>
                </tr>

            </tbody>
        </table>
    </div>

    <section class="footer-table">
        @php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
            $date = $dt->format('g:i A');
        @endphp

        <table style="width:100%" class="table">
            <tbody>
                <tr>
                    <td style="text-align:left;border:none;width:70%">Staff ID: {{ @$userInfo->user_code }}, Printing
                        Date & Time: {{ date('d/m/Y h:ia') }}</td>
                    <td style="text-align:right;border:none;width:30%">Powered By: NEXTGEN IT</td>
                </tr>
            </tbody>
        </table>
    </section>
</body>

</html>
