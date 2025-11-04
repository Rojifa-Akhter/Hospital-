@php
$appointment_card = (isset($data) && (!empty($data))) ? $data : [];

$appointment_no_pk = ($appointment_card) ? $appointment_card->appoint_no_pk : '';
$doctor_name = ($appointment_card) ? $appointment_card->full_name : '';
$patient_name = ($appointment_card) ? $appointment_card->patient_name : '';
$patient_type_code = ($appointment_card) ? $appointment_card->patient_type_code : '';
$appointment_code = ($appointment_card) ? $appointment_card->appoint_code : '';
$patient_code = ($appointment_card) ? $appointment_card->patient_code : '';
$patient_age = ($appointment_card) ? $appointment_card->age : '';
$salutation = ($appointment_card) ? $appointment_card->salutation : '';
$appointment_date = ($appointment_card) ? $appointment_card->appoint_date : '';
$slot_sl = ($appointment_card) ? $appointment_card->slot_sl : '';
$appointment_day = date("D",strtotime($appointment_date));
$specialization = ($appointment_card) ? $appointment_card->specialization : '';
// $patient_dob = ($appointment_card) ? $appointment_card->dob : '';
// $patient_gender = ($appointment_card) ? $appointment_card->ld_gender_name : '';
@endphp
<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Appointment card</title>
	<!-- Tell the browser to be responsive to screen width -->
	<meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
	<style>
		@page {
			/* margin: 0cm 0cm; */
            /* margin-top: 20px; */
        margin-top: 20px;
        margin-bottom: 0px;
        margin-left: 5px;
        margin-right: 5px;
			/* width: 450px; */
            size: 64mm 220mm;
            vertical-align: text-top;
		}

		@font-face {
			font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
			font-weight: normal;
			font-size: 11px;
			font-style: normal;
			font-variant: normal;
			src: url("font url");
		}


		/* Define the header rules */
		header {
			border-bottom: 1px solid #000;
			/* color: #007FD2; */
		}

		/* header img {
			width: 80px;
		} */

		/* Define now the real margins of every page in the PDF */
		body {
			/* margin-top: .5cm;
			margin-left:  .5cm;
			margin-right: .5cm;
			margin-bottom:.5cm; */
			font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
			font-size: 10px;
			border-color: #000;


		}

		/* footer {
			position: fixed;
			bottom: 0cm;
			left: 1cm;
			right: 1cm;
			height: 3cm;
			text-align: center;
			font-size: 9px;
		}

		tfoot tr td {
			font-weight: bold;
			font-size: 10px;
		}

		.page-break {
			page-break-after: always;
		}

		.tbl-header {
			background-color: #0073b7;
			color: #ffffff;
		}

		ul {
			padding: 0;
			margin: 0;
			padding-top: 5px;
		}

		ul li {
			margin-bottom: 5px;
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

		/*Appointment Serial card end*/


	</style>
</head>
@php
$company_details = $lead_unit = \App\Models\Company::where('status', 1)
->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
->first();

@endphp

<body>
	<div class="card" style="border-style: solid;border-width: thin;">
		<header>
			<table style="width: 100%;">
				<tr>
					<td style="text-align: center;">
						<span class="hospital-name"> {{ isset($company_details->hospital_name) ? $company_details->hospital_name : '' }}</span>
						<span class="hospital-address"> {{ isset($company_details->addrress1) ? $company_details->addrress1 : '' }}</span>
					<div>
                        <strong class="hospital-card">Appointment card</strong>
                    </div>
					</td>
				</tr>
			</table>
		</header>
		<main>
			<div class="wrapper">
				<section id="patient-info">
					<div class="container">
						<table style="width: 100%; padding-left: 10px; border-bottom: #222; ">
							<tr>
								<td width="25%">Name</td>
								<td width="50%" style="border-bottom: 1px solid #222;">
									<strong>{{$salutation.' '. ucwords(strtolower($patient_name))  }}</strong>
								</td>
								@if(Session::get('user.ses_hospita_code')=="UNICO")	
								<td width="25%" rowspan="3">
									
										<div style="font-size: 25px; line-height: 30px; height: 50px; width: 50px; border: 2px solid #222; text-align: center; border-radius: 50%;">
										
										{{ $slot_sl }}
										</div>									
								</td>
								@endif
							</tr>
							<tr>
								<td>UHID</td>
								<td style="border-bottom: 1px solid #222;">
									<strong>{{ $patient_code }}</strong>
								</td>
							</tr>
							<tr>
								<td>Doctor Name</td>
								<td style="border-bottom: 1px solid #222;">
									<strong>{{ $doctor_name }} </strong>({{$specialization}})
								</td>
							</tr>
						</table>
					</div>
				</section>
				<div class="footer">
					<div class="container">
						<table style="width: 100%; padding-left: 10px; margin: 0">
							<tr>
                                	@php
									$dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
									$date=$dt->format( 'd/m/Y g:i A');
									@endphp
								<td width="40%">Appointment Date</td>
								<td width="60%">
									<strong>
										: {{ date('d/m/Y',strtotime($appointment_date)) }} </strong>
								</td>
							</tr>
							<tr>
                                @if($data->start_time && $data->end_time)
                                <td> Time</td>
								<td>
									{{-- @php
									$dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
									$date=$dt->format( 'd-m-Y g:i a');
									@endphp --}}
									<strong>
										: {{ date('h:i A ',strtotime($appointment_card->start_time)) }} </strong> -  <strong>{{ date('h:i A ',strtotime($appointment_card->end_time)) }} </strong>
								</td>
                                
								<td>
									{{-- @php
									$dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
									$date=$dt->format( 'd-m-Y g:i a');
									@endphp --}}
									
								</td>
                                @else
								<td>Appointment Time</td>
								<td>
									{{-- @php
									$dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
									$date=$dt->format( 'd-m-Y g:i a');
									@endphp --}}
									<strong>
										: {{date('h:i A ',strtotime($data->au_entry_at))}} </strong>
								</td>
                                @endif
							</tr>
							<tr>
								<td>Print On</td>
								<td>
									<strong> : {{$date}} </strong>
								</td>
							</tr>
						</table>
					</div>
				</div>

			</div>
		</main>
	</div>
</body>

</html>
