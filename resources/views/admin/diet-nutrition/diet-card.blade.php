<!DOCTYPE html>
<html>

<head>
	<meta charset="utf-8">
	<meta http-equiv="X-UA-Compatible" content="IE=edge">
	<title>Diet card</title>
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
    @if(isset($result))
        @foreach($result as $key => $item)
            <div class="card" style="border-style: solid;border-width: thin; margin-bottom: 5px;">
                <header>
                    <table style="width: 100%;">
                        <tr>
                            <td style="text-align: center;">
                                <span class="hospital-name"> {{ isset($company_details->hospital_name) ? $company_details->hospital_name : '' }}</span>
                                <span class="hospital-address"> {{ isset($company_details->addrress1) ? $company_details->addrress1 : '' }}</span>
                            <div>
                                <strong class="hospital-card">DIET CARD</strong>
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
                                        <td width="100%" style="border-bottom: 1px solid #222;">
                                            <strong>{{ $patientInfo->patient_name }}</strong>
                                        </td>
                                    </tr>
                                </table>

                                <table style="width: 100%; padding-left: 10px; border-bottom: #222; ">
                                    <tr>
                                        <td width="25%">Date</td>
                                        <td width="50%" style="border-bottom: 1px solid #222;">
                                            <strong>{{ date('d/m/Y', strtotime($dietChart->diet_date)) }}</strong>
                                        </td>

                                        <td width="25%">Bed</td>
                                        <td width="50%" style="border-bottom: 1px solid #222;">
                                            <strong>{{ $patientInfo->bed_name }}</strong>
                                        </td>
                                    </tr>
                                    <tr>
                                        <td width="25%">Ward</td>
                                        <td width="50%" style="border-bottom: 1px solid #222;">
                                            <strong>{{ $patientInfo->ward_name }}</strong>
                                        </td>

                                        {{-- <td width="25%">Nurse Station</td>
                                        <td width="50%" style="border-bottom: 1px solid #222;">
                                            <strong>N/A</strong>
                                        </td> --}}
                                    </tr>
                                    <tr>
                                        <td width="25%">Time</td>
                                        <td width="50%" style="border-bottom: 1px solid #222;">
                                            <strong>{{ $key }}</strong>
                                        </td>
                                        <td width="25%">Nature</td>
                                        <td width="50%" style="border-bottom: 1px solid #222;">
                                            <strong>{{ $dietChart->diet_type }}</strong>
                                        </td>
                                    </tr>
                                </table>

                                <table style="width: 100%; padding-left: 10px; border-bottom: #222; ">
                                    <tr>
                                        <td width="25%">Meal</td>
                                        <td width="100%" style="border-bottom: 1px solid #222;">
                                            <strong>{{ implode(', ', $item) }}</strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </section>
                        <div class="footer">
                            <div class="container">
                                @php
                                    $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                    $date = $dt->format( 'd/m/Y g:i A');
                                @endphp
                                <table style="width: 100%; padding-left: 10px; margin: 0">
                                    <tr>
                                        <td width="25%">Print On</td>
                                        <td width="100%">
                                            <strong> : {{$date}} </strong>
                                        </td>
                                    </tr>
                                </table>
                            </div>
                        </div>
                    </div>
                </main>
            </div>
        @endforeach
    @endif
</body>

</html>
