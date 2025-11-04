@php
$appointment_card = isset($appointment_card) && !empty($appointment_card) ? $appointment_card : [];

$radinvoicedtl_no_pk = $appointment_card ? $appointment_card->radinvoicedtl_no_pk : '';
$invoice_code = $appointment_card ? $appointment_card->invoice_code : '';
$patient_name = $appointment_card ? $appointment_card->patient_name : '';
$su_name = $appointment_card ? $appointment_card->serviceunit_name : '';
$room_name = $appointment_card ? $appointment_card->room_name : '';
$img_app_sl_no = $appointment_card ? $appointment_card->img_app_sl_no : '';
$img_app_dttm = $appointment_card ? $appointment_card->img_app_dttm : '';
$department = $appointment_card ? $appointment_card->item_name : '';
$patient_code = $appointment_card ? $appointment_card->patient_code : '';
$accession_id = $appointment_card ? $appointment_card->accession_id : '';
//$slot_sl = ($appointment_card) ? $appointment_card->slot_sl : '';
//$appointment_day = date("D",strtotime($appointment_date));
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


    }

</style>
@php
$company_details = $lead_unit = \App\Models\Company::where('status', 1)->first();

@endphp
<section>
    <div class="row" id="appointment_card" style="width: ">
        <div class="col-md-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="hospital_info text-center">
                        <h5 class="mb-0"
                            style="font-family: IBM Plex Sans,Helvetica,Arial,sans-serif; font-size: 24px; font-weight: 500; margin-bottom: 5px;">
                            {{ isset($company_details->hospital_name) ? $company_details->hospital_name : '' }}</h5>
                        <small
                            style="font-family: IBM Plex Sans,Helvetica,Arial,sans-serif; margin-bottom: 10px; font-size: 14px;">
                            {{ isset($company_details->addrress1) ? $company_details->addrress1 : '' }}
                        </small>
                    </div>
                </div>
            </div>
            <div class="card_info text-left">
                <div class="patient_info">
                    <div class="row">
                        <div class="col-md-12">
                            <table class="table table-borderless" style="margin: auto;">
                                <tr class="border-bottom" style="border-bottom: 1px solid #dee2e6;">
                                    <th class="text-center mt-2" colspan="2">
                                        <strong>RADIOLOGY APPOINTMENT CARD </strong>
                                    </th>
                                </tr>

                                <tr class="border-bottom">
                                    <td class="text-center mt-2" colspan="2" style="font-size: 0.80rem;"><strong>Invoice
                                            Id : </strong>{{ $invoice_code }}</td>
                                </tr>
                                @if (isset($accession_id))
                                    <tr class="border-bottom">
                                        <td class="text-center mt-2" colspan="2" style="font-size: 0.80rem;">
                                            <strong>Addmission
                                                Id : </strong>{{ $accession_id }}</td>
                                    </tr>
                                @endif

                                <tr class="border-bottom">
                                    <td class="text-center mt-2" colspan="2" style="font-size: 0.80rem;"><strong>Patient
                                            Name : </strong>{{ $patient_name }}</td>

                                    <!-- <td class="text-left mt-2" style="font-size: 0.80rem;"><strong>Relation : </strong>{{ $patient_name }}</td> -->
                                </tr>

                                <tr class="border-top">
                                    <td class="text-right mt-2" style="font-size: 0.80rem;">
                                        <strong>Room No : </strong>{{ $room_name }}
                                    </td>

                                    <td class="text-left mt-2" style="font-size: 0.80rem;">
                                        <strong>Department : </strong> {{ $su_name }}
                                    </td>
                                </tr>
                                <tr class="border-top">
                                    <td class="text-center mt-2" colspan="2" style="font-size: 0.80rem;">
                                        <strong>Investigation Name : </strong> {{ $department }}
                                    </td>
                                </tr>

                                <tr class="border-top">
                                    <td class="text-center mt-2" colspan="2" style="font-size: 0.80rem;"><strong>Date :
                                        </strong>{{ date('d/m/Y', strtotime($img_app_dttm)) }}</td>
                                </tr>

                                <tr class="border-top">
                                    <th class="text-center mt-2 text-danger" colspan="2" style="color:#e3342f;">
                                        <h5 style="margin-bottom: 0px; font-size: 1.4rem;">Serial :
                                            {{ $img_app_sl_no }}</h5>
                                    </th>
                                </tr>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="border-top pt-2">
        <!-- <button class="btn btn-sm btn-success noprint" onclick="appointmentEngine.printAppointmentCarrd(this);return false;"><i class="fas fa-print"></i> Print Appointment Card</button> -->

        @if (Session::get('user.ses_hospital_code') == "UNICO")
        <a href="{{ route('radiology-appointment-card-print-v2', $radinvoicedtl_no_pk) }}"
        class="btn btn-sm btn-success noprint" target="_blank"><i class="fas fa-print"></i> Print Appointment
        Card</a>
        @else
        <a href="{{ route('radiology-appointment-card-print', $radinvoicedtl_no_pk) }}"
        class="btn btn-sm btn-success noprint" target="_blank"><i class="fas fa-print"></i> Print Appointment
        Card</a>
        @endif

    </div>
</section>
