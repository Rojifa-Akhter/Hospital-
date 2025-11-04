{{-- <table style="font-size:10px; width: 100%; border: none; font-weight: bold; margin-top: 20px;"
                cellpadding="0" cellspacing="0" id="advice-table">
                <tbody>
                    <tr>
                        <td style="width: 100%; text-align: left;border: none;">
                            <strong>Advice: </strong>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 100%; text-align: left;border: none;"> * Please go through carefully all
                            the
                            instructions and advice mentioned in this certificate.</td>
                    </tr>
                    <tr>
                        <td style="width: 100%; text-align: left;border: none;"> * If needed in an emergency,
                            contact
                            us or your consultant (as mentioned on the first page of this certificate).</td>
                    </tr>
                    <tr>
                        <td style="width: 100%; text-align: left;border: none;"> * Please preserve this certificate
                            and
                            any other papers relating to treatment for further reference.</td>
                    </tr>
                </tbody>
            </table>

            @if (isset($medicine_details) && $medicine_details->isNotEmpty())
                    <div style="margin-top: 10px; font-family: Arial, sans-serif;">
                        <div style="margin-bottom: 12px; font-weight: bold;">
                            Medication
                        </div>

                        @foreach ($medicine_details as $index => $value)
                            <div style="margin-bottom: 2px; line-height: 1.2;">
                                <strong>{{ $index + 1 }}.</strong>
                                <span>{{ $value->brand_name }}</span>
                                <span>{{ $value->dosage }}</span>,
                                <span>{{ $value->duration . ' ' . $value->duration_mu }}</span>,
                                <span>({{ $instructions[$value->instruction_take] ?? 'N/A' }})</span>
                            </div>
                        @endforeach
                    </div>
                @endif--}}
@php
    $today_date_time = date('d/m/Y H:i:s A');
    $printed_by = Session::get('user.ses_user_name');
@endphp
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
        @font-face {
            font-family: 'IBM Plex Sans', sans-serif;
            font-weight: normal;
            src: url("your-font-url-here");
        }

        body {
            margin-left: 0.4cm;
            margin-right: 0.4cm;
            padding-left: 15px;
            /* padding-right: 30px; */
            font-family: 'Roboto', sans-serif;
            font-size: 16px;
        }

        @media print {
            .signature {
                page-break-inside: avoid;
            }

        }

        .report-data {
            font-size: 13px;
            width: 100%;
        }

        .hospital-logo {
            width: 70px;
        }

        .barcode {
            width: 120px;
        }

        .item-name {
            width: 100%;
            font-size: 16px;
            padding: 2px;
            border-bottom: 1px solid rgb(29, 27, 27);
        }

        .print_footer {
            font-size: 8px;
        }

        /* Existing styles... */

        .watermark {
            position: fixed;
            top: 50%;
            left: 50%;
            transform: translate(-50%, -50%) rotate(-45deg);
            font-size: 100px;
            color: rgba(0, 0, 0, 0.1);
            z-index: 0;
            pointer-events: none;
            user-select: none;
            white-space: nowrap;
        }

        @media print {
            .watermark {
                display: block;
            }
        }


        @media print {

            @page {

                margin-top: 3.0cm;

                margin-bottom: 2.2cm;
                margin-left: 10mm;
                margin-right: 1cm;
                /* margin-left: 0cm;
                margin-right: 0cm; */

                @bottom-left {
                    content: "Printed: {{ $today_date_time }} by {{ $printed_by }}";
                    font-size: 10px;
                    margin-bottom: 15px;
                }

                @bottom-center {
                    content: "Powered By: [NEXTGEN]";
                    margin-bottom: 15px;
                    font-size: 10px;
                }

                @bottom-right {
                    content: "Page " counter(page) " of " counter(pages);
                    font-size: 10px;
                    margin-bottom: 15px;
                }

            }

            @page: first {
                margin-top: 3cm;

                @top-right {
                    content: none;
                    /* Hide header on page 1 */

                }


            }

            .result-data {
                font-size: 12px;
            }

        }

        .signature-content p {
            margin: 0;
            /* Adjust the values as needed */
        }
    </style>
</head>

    <body onload="window.print()">

        <main>
            <div style="text-align: center;margin-bottom:5px;padding:5px; font-size:20px; text-transform: uppercase;">
                <strong style="border-bottom: 1px solid black;">Discharge Summary</strong>
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

                    <td width="20%" style="padding-left:20px;padding-right:20px; border: none;"><strong>UHID</strong>
                    </td>
                    <td width="2%" style="padding-left:10px;padding-right:10px; border: none;">:</td>
                    <td style="text-align: left;padding-left:10px;padding-right:10px; border: none;">
                        {{ $discharge_data[0]->patient_code }}
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

                    <td width="15%" style="padding-left:20px;padding-right:20px; border: none;"><strong>Admission
                            No</strong></td>
                    <td width="2%" style="padding-left:10px;padding-right:10px; border: none;">:</td>
                    <td width="30%" style="text-align: left;padding-left:10px;padding-right:10px; border: none;">
                        {{ $discharge_data[0]->admission_no_pk }}
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
                    <td width="15%" style="padding-left:20px;padding-right:20px; border: none; white-space: nowrap;">
                        <strong>Date of Admission</strong>
                    </td>
                    <td width="2%" style="padding-left:10px;padding-right:10px; border: none;">:</td>
                    <td style="text-align: left;padding-left:10px;padding-right:10px; border: none; white-space: nowrap;">
                        {{ isset($discharge_data[0]->admission_date) ? date('d/m/Y H:i:s', strtotime($discharge_data[0]->admission_date)) : '' }}

                    </td>

                </tr>
                <tr>

                    <td width="15%"
                        style="text-align: left;padding-left:20px;padding-right:20px; border: none; white-space: nowrap;">
                        <strong>Company(Corporate Client) </strong>
                    </td>
                    <td width="2%" style="padding-left:10px;padding-right:10px; border: none;">:</td>
                    <td width="30%" style="text-align: left;padding-left:10px;padding-right:10px; border: none;">
                        {{ $discharge_data[0]->ccm_client_name }}
                    </td>
                    <td width="15%" style="padding-left:20px;padding-right:20px; border: none;"><strong>Date of
                            Discharge</strong></td>
                    <td width="2%" style="padding-left:10px;padding-right:10px; border: none;">:</td>
                    <td style="text-align: left;padding-left:10px;padding-right:10px; border: none; white-space: nowrap;">
                        {{ isset($discharge_data[0]->dis_date) ? date('d/m/Y H:i:s', strtotime($discharge_data[0]->dis_date)) : '' }}

                    </td>

                </tr>
                

            </table>

            <div>
                <div style="text-align: center;margin-bottom:5px;padding:5px; font-size:16px; text-transform: uppercase;">
                    <strong style="border-bottom: 1px solid black;">Department of
                        {{ $discharge_data[0]->doc_dept }}</strong>
                </div>

                <div style="font-family: Arial, sans-serif; font-size: 14px;">
                    @if (isset($discharge_data[0]->primary_doctor_name) && !empty($discharge_data[0]->primary_doctor_name))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Primary Consultant:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $discharge_data[0]->primary_doctor_name }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->referral_doctor_name) && !empty($admission_details->referral_doctor_name))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Referral Consultant:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ strip_tags($admission_details->referral_doctor_name) }}
                            </span>
                        </div>
                    @endif

                    @if (isset($admission_details->diagnosis) && !empty($admission_details->diagnosis))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold;  color: black; display: inline;">
                                Diagnosis:
                            </span>
                            <span style="color:#333; display:inline; white-space: pre-line;">
                                    {!! html_entity_decode(strip_tags($admission_details->diagnosis)) !!}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->inv_with_finding) && !empty($admission_details->inv_with_finding))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Investigations with finding:
                            </span>
                            <span style="color:#333; display:inline; white-space: pre-line;">
                                {{ $admission_details->inv_with_finding }}
                                    
                            </span>
                        </div>
                    @endif

                    @if (isset($admission_details->pat_current_cli_history) && !empty($admission_details->pat_current_cli_history))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: block;">
                                Patient Current Clinical History:
                            </span>
                            <span style="color:#333; display:inline; white-space: pre-line;">
                                    {!! html_entity_decode(strip_tags($admission_details->pat_current_cli_history)) !!}
                            </span>
                        </div>
                    @endif


                    @if (isset($admission_details->adm_form_past_med_hist) && !empty($admission_details->adm_form_past_med_hist))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: block;">
                                Past Medical History:
                            </span>
                            <span style="color:#333; display:inline; white-space: pre-line;">
                                    {!! html_entity_decode(strip_tags($admission_details->adm_form_past_med_hist)) !!}
                            </span>
                        </div>
                    @endif



                    @if (isset($admission_details->clinical_examination) && !empty($admission_details->clinical_examination))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: block;">
                                Clinical Examination:
                            </span>
                            <span style="color:#333; display:inline; white-space: pre-line;">
                                    {!! html_entity_decode(strip_tags($admission_details->clinical_examination)) !!}
                            </span>
                        </div>
                    @endif

                    @if (isset($admission_details->local_examination) && !empty($admission_details->local_examination))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: block;">
                                Local Examination:
                            </span>
                            <span style="color: #333; display: block;">
                                {{ $admission_details->local_examination ?? 'N/A' }}
                            </span>
                        </div>
                    @endif

                    @php
                        // Menstrual fields
                        $hasMenstrualData =
                            !empty($admission_details->cycle) ||
                            !empty($admission_details->flow_duration) ||
                            !empty($admission_details->lmp) ||
                            !empty($admission_details->edd);

                        // Obstetric fields
                        $hasObstetricData =
                            !empty($admission_details->married_for) ||
                            !empty($admission_details->gravida) ||
                            !empty($admission_details->para) ||
                            !empty($admission_details->alc);
                    @endphp
                    @if ($discharge_data[0]->gender_txt === 'Female' && ($hasMenstrualData || $hasObstetricData))
                        <div class="card mb-3 shadow-sm border-0">
                            <div class="card-body p-3">
                                @if ($hasMenstrualData)
                                    <h3 class="fw-bold text-primary mb-2"><u>Menstrual History</u></h3>
                                    <div class="row mb-3">
                                        @if (!empty($admission_details->cycle))
                                            <div class="col-md-3">
                                                <p class="mb-1"><strong>Cycle:</strong>
                                                    {{ $admission_details->cycle ?? 'N/A' }}</p>
                                            </div>
                                        @endif
                                        @if (!empty($admission_details->flow_duration))
                                            <div class="col-md-3">
                                                <p class="mb-1"><strong>Flow & Duration:</strong>
                                                    {{ $admission_details->flow_duration ?? 'N/A' }}</p>
                                            </div>
                                        @endif
                                        @if (!empty($admission_details->lmp))
                                            <div class="col-md-3">
                                                <p class="mb-1"><strong>LMP:</strong>
                                                    {{ !empty($admission_details->lmp) ? date('d-m-Y', strtotime($admission_details->lmp)) : '' }}
                                                </p>
                                            </div>
                                        @endif
                                        @if (!empty($admission_details->edd))
                                            <div class="col-md-3">
                                                <p class="mb-1"><strong>EDD:</strong>
                                                    {{ !empty($admission_details->edd) ? date('d-m-Y', strtotime($admission_details->edd)) : '' }}
                                                </p>
                                            </div>
                                        @endif
                                    </div>
                                @endif
                                <h3 class="fw-bold text-primary mb-2"><u>Obstetric History</u></h3>
                                <div class="row">
                                    @if (!empty($admission_details->married_for))
                                        <div class="col-md-3">
                                            <p class="mb-1"><strong>Married for:</strong>
                                                {{ $admission_details->married_for ?? 'N/A' }}</p>
                                        </div>
                                    @endif
                                    @if (!empty($admission_details->gravida))
                                        <div class="col-md-3">
                                            <p class="mb-1"><strong>Gravida:</strong>
                                                {{ $admission_details->gravida ?? 'N/A' }}</p>
                                        </div>
                                    @endif
                                    @if (!empty($admission_details->para))
                                        <div class="col-md-3">
                                            <p class="mb-1"><strong>Para:</strong>
                                                {{ $admission_details->para ?? 'N/A' }}</p>
                                        </div>
                                    @endif
                                    @if (!empty($admission_details->alc))
                                        <div class="col-md-3">
                                            <p class="mb-1"><strong>ALC:</strong> {{ $admission_details->alc ?? 'N/A' }}
                                            </p>
                                        </div>
                                    @endif
                                </div>

                            </div>
                        </div>
                    @endif


                    @if (isset($admission_details->course_in_hospital) && !empty($admission_details->course_in_hospital))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; block: inline;">
                                Course in Hospital:
                            </span>
                            <span style="color:#333; display:inline; white-space: pre-line;">
                                    {!! html_entity_decode(strip_tags($admission_details->course_in_hospital)) !!}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->case_summary_remarks) && !empty($admission_details->case_summary_remarks))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; block: inline;">
                                Case Summary :
                            </span>
                            <span style="color:#333; display:inline; white-space: pre-line;">
                                    {!! html_entity_decode(strip_tags($admission_details->case_summary_remarks)) !!}
                            </span>
                        </div>
                    @endif


                    @if (isset($investigation_data_proc) && count($investigation_data_proc) > 0)
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: block;">
                                Procedure Name (If any):
                            </span>
                            <span style="color: #333; display: block;">
                                @foreach ($investigation_data_proc as $proc)
                                    {{ $proc->item_type ?? '' }}
                                @endforeach
                            </span>
                        </div>
                    @endif

                    @if (isset($admission_details->adm_form_allergies) && !empty($admission_details->adm_form_allergies))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: block;">
                                Allergies:
                            </span>
                            <span style="color: #333; display: block; white-space: pre-line;">
                                {{ $admission_details->adm_form_allergies }}
                            </span>
                        </div>
                    @endif

                    @if (isset($admission_details->discharge_advice) && !empty($admission_details->discharge_advice))
                        <div style="margin-bottom: 10px;">
                            <div style="margin-bottom: 10px;">
                                <span style="font-weight:bold; color:black;">
                                    Advice on discharge:
                                </span>
                                <span style="color:#333; display:inline; white-space: pre-line;">
                                    {!! html_entity_decode(strip_tags($admission_details->discharge_advice)) !!}
                                </span>
                            </div>
                        </div>
                    @endif

                    @if ($merged_med_info->isNotEmpty())
                        <div style="margin-top: 10px; font-family: Arial, sans-serif;">
                            <div style="margin-bottom: 12px; font-weight: bold;">
                                Discharge Medication
                            </div>

                            @foreach ($merged_med_info as $index => $value)
                                <div style="margin-bottom: 2px; line-height: 1.2;">
                                    <strong>{{ $index + 1 }}.</strong>

                                    <span>{{ $value->item_name ?? '' }}</span>

                                    @if (!empty($value->dosage))
                                        - <span>{{ $value->dosage }}</span>
                                    @endif
                                    @if (!empty($value->route))
                                        , <span>{{ $route[$value->route] ?? $value->route }}</span>
                                    @endif

                                    @if (!empty($value->duration) || !empty($value->duration_mu))
                                        , <span>{{ trim(($value->duration ?? '') . ' ' . ($value->duration_mu ?? '')) }}</span>
                                    @endif
                                    @if (!empty($value->med_taken_instruction))
                                        <span>(
                                            {{ $instructions[$value->med_taken_instruction] ?? $value->med_taken_instruction }}
                                        )</span>
                                    @endif
                                    @if (!empty($value->continue_ind))
                                        <span>(
                                            {{ $instructions[$value->continue_ind] ?? 'Continue' }}
                                        )</span>
                                    @endif
                                </div>
                            @endforeach
                        </div><br>
                    @endif

                    @if (isset($admission_details->pre_ot_date) && !empty($admission_details->pre_ot_date))
                    <div style="margin-bottom: 10px; margin-top: 10px;">
                        <span style="font-weight: bold; color: black; display: inline;">
                            <strong>Ot Note</strong><br>
                                Ot date:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ !empty($admission_details->pre_ot_date) ? date('d-m-Y', strtotime($admission_details->pre_ot_date)) : 'N/A' }}
                            </span>
                        </div>
                    @endif
                    @if (!empty($admission_details->pre_ot_time))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black;">OT Time:</span>
                            <span style="color: #333;">
                                {{ \Carbon\Carbon::parse($admission_details->pre_ot_time)->format('H:i A') }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->pre_ot_operation) && !empty($admission_details->pre_ot_operation))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Name of operation:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->pre_ot_operation }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->pre_ot_indication) && !empty($admission_details->pre_ot_indication))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Ot indication:
                            </span>
                            <span style="color:#333; display:inline; white-space: pre-line;">
                                    {!! html_entity_decode(strip_tags($admission_details->pre_ot_indication)) !!}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->pre_ot_anaesthetia_name) && !empty($admission_details->pre_ot_anaesthetia_name))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Ot anaesthesia:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->pre_ot_anaesthetia_name }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->pre_ot_surgeon_name ) && !empty($admission_details->pre_ot_surgeon_name ))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Ot surgeon:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->pre_ot_surgeon_name }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->pre_ot_assis_name ) && !empty($admission_details->pre_ot_assis_name ))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Ot Assistant:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->pre_ot_assis_name }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->pre_ot_anaesthetist_name) && !empty($admission_details->pre_ot_anaesthetist_name))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Ot anaesthetist:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->pre_ot_anaesthetist_name }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->pre_ot_precedure) && !empty($admission_details->pre_ot_precedure))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Ot precedure:
                            </span>
                            <span style="color:#333; display:inline; white-space: pre-line;">
                                    {!! html_entity_decode(strip_tags($admission_details->pre_ot_precedure)) !!}
                            </span>
                        </div>
                    @endif
                    @if (!empty($admission_details->pre_ot_note))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black;">Pre operation finding:</span>
                            <span style="color:#333; display:inline; white-space: pre-line;">
                                    {!! html_entity_decode(strip_tags($admission_details->pre_ot_note)) !!}
                            </span>
                        </div>
                    @endif

                    @if (isset($admission_details->procedure_note) && !empty($admission_details->procedure_note))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Procedure Note:
                            </span>
                            <span style="color:#333; display:inline; white-space: pre-line;">
                                    {!! html_entity_decode(strip_tags($admission_details->procedure_note)) !!}
                            </span>
                        </div>
                    @endif

                    @if (isset($admission_details->first_baby_birthdate) && !empty($admission_details->first_baby_birthdate))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                <strong>Baby Note</strong><br>
                                    Date of Delivery:
                                </span>
                                <span style="color: #333; display: inline;">
                                    {{ !empty($admission_details->first_baby_birthdate) ? date('d-m-Y', strtotime($admission_details->first_baby_birthdate)) : 'N/A' }}
                                </span>
                        </div>
                    @endif
                     @if (!empty($admission_details->first_baby_time))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black;">Time of Delivery:</span>
                            <span style="color: #333;">
                                {{ \Carbon\Carbon::parse($admission_details->first_baby_time)->format('H:i A') }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->first_baby_gender_no) && !empty($admission_details->first_baby_gender_no))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Gender:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $gender[$admission_details->first_baby_gender_no] ?? $admission_details->first_baby_gender_no }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->first_baby_delivery_mode) && !empty($admission_details->first_baby_delivery_mode))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Delivery Mode:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->first_baby_delivery_mode }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->first_baby_presentation) && !empty($admission_details->first_baby_presentation))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Presentation:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->first_baby_presentation }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->first_baby_gestational_age) && !empty($admission_details->first_baby_gestational_age))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Gestational Age:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->first_baby_gestational_age }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->first_baby_apgar) && !empty($admission_details->first_baby_apgar))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                APGAR:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->first_baby_apgar }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->first_baby_resuscitation) && !empty($admission_details->first_baby_resuscitation))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Resuscitation:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->first_baby_resuscitation }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->first_baby_wt) && !empty($admission_details->first_baby_wt))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                               Baby Weight:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->first_baby_wt }}
                            </span>
                        </div>
                    @endif

                    @if (isset($admission_details->first_baby_length) && !empty($admission_details->first_baby_length))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Baby Length:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->first_baby_length }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->first_baby_ofc) && !empty($admission_details->first_baby_ofc))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                OFC:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->first_baby_ofc }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->congenital_anomalies) && !empty($admission_details->congenital_anomalies))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                No Other Apparent Congenital Anomalies<br>
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->congenital_anomalies }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->mother_age) && !empty($admission_details->mother_age))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                <strong>No Other Apparent Congenital Anomalies</strong><br><br>
                                <strong>Maternal History:</strong><br>
                                Age:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->mother_age }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->maternal_gravida) && !empty($admission_details->maternal_gravida))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Gravida:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->maternal_gravida }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->maternal_para) && !empty($admission_details->maternal_para))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Para:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->maternal_para }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->maternal_antenatal_care) && !empty($admission_details->maternal_antenatal_care))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Antenatal Care:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->maternal_antenatal_care }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->maternal_blood_group) && !empty($admission_details->maternal_blood_group))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Mother's Blood Group:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->maternal_blood_group }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->maternal_vdrl_result) && !empty($admission_details->maternalp_vdrl_result))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                VDRL:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->maternal_vdrl_result }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->maternal_hbsag_result) && !empty($admission_details->maternal_hbsag_result))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                HBSAg:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->maternal_hbsag_result }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->maternal_consanguinity) && !empty($admission_details->maternal_consanguinity))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Consanguinity:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->maternal_consanguinity }}
                            </span>
                        </div>
                    @endif

                    @if (isset($admission_details->second_baby_birthdate) && !empty($admission_details->second_baby_birthdate))
                    <div style="margin-bottom: 10px;">
                        <span style="font-weight: bold; color: black; display: inline;">
                            <strong>2nd Baby Note</strong><br>
                                2nd  baby birthDate:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ !empty($admission_details->second_baby_birthdate) ? date('d-m-Y', strtotime($admission_details->second_baby_birthdate)) : 'N/A' }}
                            </span>
                        </div>
                    @endif
                     @if (!empty($admission_details->second_baby_time))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black;">2nd baby Time:</span>
                            <span style="color: #333;">
                                {{ \Carbon\Carbon::parse($admission_details->second_baby_time)->format('H:i') }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->second_baby_gender_no) && !empty($admission_details->second_baby_gender_no))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Gender:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $gender[$admission_details->second_baby_gender_no] ?? $admission_details->second_baby_gender_no }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->second_baby_wt) && !empty($admission_details->second_baby_wt))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                               2nd baby Wt:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->second_baby_wt }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->second_baby_as) && !empty($admission_details->second_baby_as))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                2nd baby A/s:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->second_baby_as }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->second_baby_note) && !empty($admission_details->second_baby_note))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                2nd baby Note:
                            </span>
                            <span style="color: #333; display: inline;">
                                 {{ trim(html_entity_decode(strip_tags($admission_details->second_baby_note))) }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->discharge_plan) && !empty($admission_details->discharge_plan))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Plan on discharge:
                            </span>
                            <span style="color:#333; display:inline; white-space: pre-line;">
                                    {!! html_entity_decode(strip_tags($admission_details->discharge_plan)) !!}
                            </span>
                        </div>
                    @endif

                    @if (isset($admission_details->status_during_discharge) && !empty($admission_details->status_during_discharge))
                        <div style="margin-bottom: 10px; margin-top: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Condition at the time of discharge:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->status_during_discharge }}
                            </span>
                        </div>
                    @endif

                    @if (isset($admission_details->contact_person) && !empty($admission_details->contact_person))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Emergency Contact Information:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->contact_person }}
                            </span>
                        </div>
                    @endif
                    @if (isset($admission_details->cc_text) && !empty($admission_details->cc_text))
                    <div style="margin-bottom: 10px;">
                        <span style="font-weight: bold; color: black; display: inline;">
                            CC:
                        </span>
                        <span style="color:#333; display:inline; white-space: pre-line;">
                            {!! html_entity_decode(strip_tags($admission_details->cc_text)) !!}
                        </span>
                    </div>
                @endif
                @if (isset($admission_details->oe_admission) && !empty($admission_details->oe_admission))
                    <div style="margin-bottom: 10px;">
                        <span style="font-weight: bold; color: black; display: inline;">
                            O/E ON ADMISSION:
                        </span>
                        <span style="color:#333; display:inline; white-space: pre-line;">
                            {!! html_entity_decode(strip_tags($admission_details->oe_admission)) !!}
                        </span>
                    </div>
                @endif

                @if (isset($admission_details->oe_discharge) && !empty($admission_details->oe_discharge))
                    <div style="margin-bottom: 10px;">
                        <span style="font-weight: bold; color: black; display: inline;">
                            O/E ON DISCHARGE / Treatment:
                        </span>
                        <span style="color:#333; display:inline; white-space: pre-line;">
                            {!! html_entity_decode(strip_tags($admission_details->oe_discharge)) !!}
                        </span>
                    </div>
                @endif


                </div>

            </div>


            <div style="font-family: Arial, sans-serif; font-size: 14px; margin-top: 10px;">

                

                
                @if (isset($admission_details->treatment_during_hospital) && !empty($admission_details->treatment_during_hospital))
                    <div style="margin-bottom: 10px;">
                        <span style="font-weight: bold; color: black; display: inline;">
                            Treatment During Hospitalization:
                        </span>
                        <span style="color:#333; display:inline; white-space: pre-line;">
                            {!! html_entity_decode(strip_tags($admission_details->treatment_during_hospital)) !!}
                        </span>
                    </div>
                @endif

                @if (isset($admission_details->special_note) && !empty($admission_details->special_note))
                    <div style="margin-bottom: 10px;">
                        <span style="font-weight: bold; color: black; display: inline;">
                            Special Note:
                        </span>
                        <span style="color:#333; display:inline; white-space: pre-line;">
                            {!! html_entity_decode(strip_tags($admission_details->special_note)) !!}
                        </span>
                    </div>
                @endif

                @if (isset($admission_details->other_note) && !empty($admission_details->other_note))
                    <div style="margin-bottom: 10px;">
                        <span style="font-weight: bold; color: black; display: inline;">
                            Other Note
                        </span>
                        <span style="color:#333; display:inline; white-space: pre-line;">
                            {!! html_entity_decode(strip_tags($admission_details->other_note)) !!}
                        </span>
                    </div>
                @endif

                @if (isset($admission_details->when_how_obtn_urgnt_care) && !empty($admission_details->when_how_obtn_urgnt_care))
                    <div style="margin-bottom: 10px;">
                        <span style="font-weight: bold; color: black; display: inline;">
                            When & how to obtain urgent care:
                        </span>
                        <span style="color:#333; display:inline; white-space: pre-line;">
                            {!! html_entity_decode(strip_tags($admission_details->when_how_obtn_urgnt_care)) !!}
                        </span>
                    </div>
                @endif

                @if (isset($admission_details->discharge_doc_name) && !empty($admission_details->discharge_doc_name))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Discharge Doctor:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->discharge_doc_name }}
                            </span>
                        </div>
                @endif
                @if (isset($admission_details->prepare_doctor_name) && !empty($admission_details->prepare_doctor_name))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Discharge summary Prepared Doctor Name:
                            </span>
                            <span style="font-size: 16px; color: #333; display: inline;">
                                {{ $admission_details->prepare_doctor_name }}
                            </span>
                        </div>
                @endif
                @if (isset($admission_details->verified_doctor_name) && !empty($admission_details->verified_doctor_name))
                        <div style="margin-bottom: 10px;">
                            <span style="font-weight: bold; color: black; display: inline;">
                                Discharge summary Verified Doctor Name:
                            </span>
                            <span style="color: #333; display: inline;">
                                {{ $admission_details->verified_doctor_name }}
                            </span>
                        </div>
                @endif
                @if (isset($admission_details->followup_date) && !empty($admission_details->followup_date))
                    <div style="margin-bottom: 10px;">
                        <span style="font-weight: bold; color: black; display: inline;">
                        Discharge Follow Up Visit Date:
                        </span>
                        <span style="color: #333; display: inline;">
                            {{ isset($admission_details->followup_date) ? date('d/m/Y', strtotime($admission_details->followup_date)) : '' }}
                        </span>
                    </div>
                @endif

            </div>


            <table
                style="width: 100%; border: none; margin-top: 20px; font-size: 12px; line-height: 18px; table-layout: fixed;">
                <tr>
                    @if (isset($admission_details->prepare_doctor_signature) && !empty($admission_details->prepare_doctor_signature))
                        <td style="width: 33%; text-align: center; vertical-align: top; padding: 5px;">
                            <strong>Prepared Doctor</strong><br><br><br>
                            <strong>{!! $admission_details->prepare_doctor_signature ?? '&nbsp;' !!}</strong>
                        </td>
                    @endif
                    @if (isset($admission_details->verify_doctor_signature) && !empty($admission_details->verify_doctor_signature))
                        <td style="width: 33%; text-align: center; vertical-align: top; padding: 5px;">
                            <strong>Verified Doctor</strong><br><br><br>
                            <strong>{!! $admission_details->verify_doctor_signature ?? '&nbsp;' !!}</strong>
                        </td>
                    @endif
                    @if (isset($doc_signature->doctor_signature) && !empty($doc_signature->doctor_signature))
                        <td style="width: 33%; text-align: center; vertical-align: top; padding: 5px;">
                            <strong>Discharge Doctor</strong><br><br><br>
                            <strong>{!! $doc_signature->doctor_signature ?? '&nbsp;' !!}</strong>
                        </td>
                    @endif
                </tr>
            </table>



        </main>

    </body>

</html>
