<link href="{{ asset('css/app.css') }}" rel="stylesheet" media="print">
<link href="{{ asset('css/all.min.css') }}" rel='stylesheet' media="print" />
<link href="{{ asset('css/font-css.css') }}" rel="stylesheet" media="print">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">


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
$company_details = $lead_unit = \App\Models\Company::where('status', 1)->first();
@endphp
<section>
    <form action="{{ route('update-appointment-date-and-time') }}" id="update-appoint-date-and-time-form" method="post">
        @csrf
        <input type="hidden" name ="id" value="{{$appointment_card->appoint_no_pk}}">
        <input type="hidden" name ="slot_ind" value="1">

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
                                    <th class="text-center mt-2" colspan="2"><strong style="margin-bottom: 20px;">Change Date </strong></th>
                                </tr>


                                <tr>
                                    <td class="text-left" style="text-align: center; border-bottom: 1px solid #dee2e6; font-size: 12px;">
                                        <strong>Date : </strong>{{--{{$appointment_card->appoint_date ?  date('d/m/Y', strtotime($appointment_card->appoint_date) ) : "" }} --}}
						<input type="text" autocomplete="off" class="form-control form-control-sm date_picker" id="date_pic" name="date_pic" value="{{ $appointment_card->appoint_date ? date('d-m-Y', strtotime($appointment_card->appoint_date)) : ""}}" placeholder="DD-MM-YYYY">

                                    </td>

                                    <td class="text-left " style="text-align: center; border-bottom: 1px solid #dee2e6; font-size: 12px;">

                                        <strong> Start Time : </strong>
												<input type="time" id="shift_start_time" name="shift_start_time" class="form-control required" placeholder="Start Time" value="{{ $appointment_card->start_time ? date('H:i',strtotime($appointment_card->start_time)) : "" }}">

                                    </td>

                                    <td class="text-left " style="text-align: center; border-bottom: 1px solid #dee2e6; font-size: 12px;">

                                        <strong> End Time : </strong>
												<input type="time" id="shift_end_time" name="shift_end_time" class="form-control required" placeholder="End Time" value="{{ $appointment_card->end_time ? date('H:i',strtotime($appointment_card->end_time)) : "" }}">

                                    </td>
                                </tr>
                                <tr class="border-top">
                                    <td class="text-center mt-2" style="text-align: center; font-size: 12px;" colspan="4"><strong>Doctor : </strong style="">{{$appointment_card->full_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center mt-2" style="text-align: center; border-bottom: 1px solid #dee2e6; font-size: 12px;" colspan="4"><strong>Patient : </strong>{{ $appointment_card->patient_name }}</td>
                                </tr>
                                <tr>
                                    <td class="text-center mt-2 text-danger" style="text-align: center; color:#e3342f; font-size: 24px; border-bottom: 1px solid #dee2e6;" colspan="4">
                                        <h5 style="margin-bottom: 0px;"><strong>Serial : </strong>{{ $appointment_card->slot_sl }}
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

    <div class="modal-footer border-top pt-2">
        @php
        $response_action = route('appointments.list-view');
        @endphp
        {{-- <a href="{{ route('patient-appointment-print', $appointment_card->appoint_no_pk) }}" class="btn btn-sm btn-success noprint" target="_blank" data-id="{{ $appointment_card->appoint_no_pk }}" id="apointment_card" title=" Print Appointment Card"><i class="fa fa-file-print"></i>Print Appointment Card</a> --}}

        {{-- <button class="btn btn-sm btn-success noprint" onclick="appointmentEngine.printAppointmentCarrd(this);return false;"><i class="fas fa-print"></i> Print Appointment Card</button> --}}
        <button class="btn btn-sm btn-success noprint float-right" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">save</button>
    </div>
    </form>
</section>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">
	$(function() {

		$('.select2').select2();
		$('.timepicker').timepicker({});

	});
	$('.date_picker').datepicker({
		format: 'dd-mm-yyyy',
		autoclose: true,
		todayHighlight: true,
		clearBtn: true,
	});

</script>
