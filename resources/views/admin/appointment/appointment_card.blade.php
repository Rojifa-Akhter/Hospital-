@php
$appointment_card = isset($appointment_card) && !empty($appointment_card) ? $appointment_card : [];

$appointment_no_pk = $appointment_card ? $appointment_card->appoint_no_pk : '';
$doctor_name = $appointment_card ? $appointment_card->full_name : '';
$patient_name = $appointment_card ? $appointment_card->patient_name : '';
$appointment_code = $appointment_card ? $appointment_card->appoint_code : '';
$patient_code = $appointment_card ? $appointment_card->patient_code : '';
$patient_age = $appointment_card ? $appointment_card->age : '';
$salutation = ($appointment_card) ? $appointment_card->salutation : '';
$appointment_date = $appointment_card ? $appointment_card->appoint_date : '';
$slot_sl = $appointment_card ? $appointment_card->slot_sl : '';
$appointment_day = date('D', strtotime($appointment_date));
// $trx_id =   array_unique($bill_id->invoice_trn_list);
// dd( $bill_id);
$trx_id = !empty($bill_id->invoice_trn_list) ? explode(', ',$bill_id->invoice_trn_list) : "";
// dd(implode(array_unique($trx_id)));
// $patient_dob = ($appointment_card) ? $appointment_card->dob : '';
// $patient_gender = ($appointment_card) ? $appointment_card->ld_gender_name : '';
@endphp

<link href="{{ asset('css/app.css') }}" rel="stylesheet" media="print">
<link href="{{ asset('css/all.min.css') }}" rel='stylesheet' media="print" />
<link href="{{ asset('css/font-css.css') }}" rel="stylesheet" media="print">
<style>
    @page {
        margin: 0cm 0cm;
    }

    @font-face {
        font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
        font-weight: normal;
        font-size: 11px;
        font-style: normal;
        font-variant: normal;
        src: url("font url");
    }

    @media print {
        .noprint {
            display: none;
        }

        #appointment_card {
            display: block;
            text-align: center;
            font-family: IBM Plex Sans, Helvetica, Arial, sans-serif;
            /*width: 50px;*/
        }

        table {
            margin: auto !important;
            text-align: center !important;
        }

        .text-right {
            text-align: right;
        }

        .text-left {
            text-align: left;
        }

        .text-center {
            text-align: center !important;
        }

        table tr td {
            text-align: center !important;
        }

        .mt-2 {
            margin-top: 5px;
        }

        table tr td h5 {
            margin-bottom: 0px;
        }

        .day {
            font-size: 12px;
            margin-bottom: 0px;
        }
    }
</style>
@php
$company_details = $lead_unit = \App\Models\Company::where('status', 1)
->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
->first();
@endphp
<section>
    <div class="row" id="appointment_card" style="width: ">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="hospital_info text-center">
                        <h5 class="mb-0" style="font-family: IBM Plex Sans,Helvetica,Arial,sans-serif; font-size: 20px; font-weight: 500; margin-bottom: 5px;">
                            {{ isset($company_details->hospital_name) ? $company_details->hospital_name : '' }}
                        </h5>
                        <small style="font-family: IBM Plex Sans,Helvetica,Arial,sans-serif; margin-bottom: 10px; font-size: 14px;">
                            {{ isset($company_details->addrress1) ? $company_details->addrress1 : '' }}</small>
                    </div>
                </div>
            </div>
            <div class="card_info text-left">
                <div class="patient_info">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-borderless" style="margin: auto; font-family: IBM Plex Sans,Helvetica,Arial,sans-serif;">
                                <tr class="border-bottom" style="border-bottom: 1px solid #dee2e6;">
                                    <th class="text-center mt-2" colspan="2"><strong style="margin-bottom: 20px;">APPOINTMENT CARD  </strong></th>
                                </tr>
                                <?php $app_dt = strtoupper(date(
                                    'D',
                                    strtotime($appointment_card->appoint_date)
                                )); ?>
                                <tr>
                                    <th class="text-center mt-2" colspan="2">
                                        <span class="day">
                                            @if ($app_dt == 'SAT')<span class='text-danger'>&#10003;</span> @else
                                            &#9744; @endif SAT
                                        </span> &nbsp;
                                        <span class="day">
                                            @if ($app_dt == 'SUN')<span class='text-danger'>&#10003;</span> @else
                                            &#9744; @endif SUN
                                        </span> &nbsp;
                                        <span class="day">
                                            @if ($app_dt == 'MON')<span class='text-danger'>&#10003;</span> @else
                                            &#9744; @endif MON
                                        </span> &nbsp;
                                        <span class="day">
                                            @if ($app_dt == 'TUE')<span class='text-danger'>&#10003;</span> @else
                                            &#9744; @endif TUE
                                        </span> &nbsp;
                                        <span class="day">
                                            @if ($app_dt == 'WED')<span class='text-danger'>&#10003;</span> @else
                                            &#9744; @endif WED
                                        </span> &nbsp;
                                        <span class="day">
                                            @if ($app_dt == 'THU')<span class='text-danger'>&#10003;</span> @else
                                            &#9744; @endif THU
                                        </span> &nbsp;
                                        <span class="day">
                                            @if ($app_dt == 'FRI')<span class='text-danger'>&#10003;</span> @else
                                            &#9744; @endif FRI
                                        </span> &nbsp;

                                    </th>
                                </tr>
                                <tr style="display: flex; justify-content: center; flex-wrap: wrap;">
                                    <td  style="text-align: center; border-bottom: 1px solid #dee2e6; font-size: 12px;">
                                        <strong>Date : </strong>{{ date('d/m/Y', strtotime($appointment_date)) }}
                                    </td>
                                    @if($appointment_card->start_time && $appointment_card->end_time)
                                    <td class="text-left " style="text-align: center; border-bottom: 1px solid #dee2e6; font-size: 12px;">

                                        <strong>Start Time : </strong>{{ date('h:i A ',strtotime($appointment_card->start_time)) }}
                                        <strong>End Time : </strong>{{ date('h:i A ',strtotime($appointment_card->end_time)) }}
                                    </td>
                                    @else
                                    <td  style="text-align: center; border-bottom: 1px solid #dee2e6; font-size: 12px;">

                                        <strong>Time : </strong>{{ date('h:i A ',strtotime($appointment_card->au_entry_at)) }}
                                    </td>
                                    @endif

                                </tr>
                                <tr class="border-top">
                                    <td class="text-center mt-2" style="text-align: center; font-size: 12px;" colspan="2"><strong>Doctor : </strong style="">{{ $doctor_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center mt-2" style="text-align: center; border-bottom: 1px solid #dee2e6; font-size: 12px;" colspan="2"><strong>Patient : </strong>{{$salutation.' '. $patient_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center mt-2 text-danger" style="text-align: center; color:#e3342f; font-size: 24px; border-bottom: 1px solid #dee2e6;" colspan="2">
                                        <h5 style="margin-bottom: 0px;"><strong>Serial : </strong>{{ $slot_sl }}
                                        </h5>
                                    </td>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>

    </div>
    <div class="border-top pt-2">
        <a href="{{ route('patient-appointment-print', $appointment_no_pk) }}" class="btn btn-sm btn-success noprint" target="_blank" data-id="{{ $appointment_no_pk }}" id="apointment_card" title=" Print Appointment Card"><i class="fa fa-file-print"></i>Print Appointment Card</a>
        @if(!empty($bill_id->invoice_no_pk) && $trx_id !="")
        <a href='{{route("bill-invoice-app-print", [$bill_id->invoice_no_pk ,1 ,implode(array_unique($trx_id))])}}' target="_blank"Class="btn btn-sm btn-warning" title="Print">Invoice Print</a>
        @endif

        <a href="{{ route('blank-prescription-form', $appointment_no_pk) }}" class="btn btn-sm btn-success noprint" target="_blank" data-id="{{ $appointment_no_pk }}" id="blank_prescription" title=" Print Blank Prescription"><i class="fa fa-file-print"></i>Print Blank Prescription</a>
        {{-- <button class="btn btn-sm btn-success noprint" onclick="appointmentEngine.printAppointmentCarrd(this);return false;"><i class="fas fa-print"></i> Print Appointment Card</button> --}}
    </div>
</section>
