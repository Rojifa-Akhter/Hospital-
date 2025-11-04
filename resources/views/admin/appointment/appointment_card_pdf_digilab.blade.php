@php
    $appointment_card = isset($data) && !empty($data) ? $data : [];

    $appointment_no_pk = $appointment_card->appoint_no_pk ?? '';
    $doctor_name = $appointment_card->full_name ?? '';
    $patient_name = $appointment_card->patient_name ?? '';
    $patient_code = $appointment_card->patient_code ?? '';
    $salutation = $appointment_card->salutation ?? '';
    $appointment_date = $appointment_card->appoint_date ?? '';
    $specialization = $appointment_card->specialization ?? '';
    $slot_sl = $appointment_card->slot_sl ?? '';
@endphp
<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Appointment Card</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        @page {
            margin-top: 20px;
            margin-bottom: 0px;
            margin-left: 5px;
            margin-right: 5px;
            size: 64mm 220mm;
        }

        body {
            font-family: 'IBM Plex Sans', Helvetica, Arial, sans-serif;
            font-size: 10px;
            border-color: #000;
        }

        header {
            border-bottom: 1px solid #000;
            text-align: center;
        }

        .hospital-name,
        .hospital-address {
            display: block;
        }

        .hospital-card {
            font-weight: bold;
            font-size: 14px;
        }

        table {
            width: 100%;
            padding-left: 10px;
            border-bottom: 1px solid #222;
        }

        table td {
            padding: 5px;
        }

        .footer {
            margin-top: 10px;
        }

        .footer table td {
            padding: 5px;
        }

        .circle {
            font-size: 25px;
            line-height: 30px;
            height: 50px;
            width: 50px;
            border: 2px solid #222;
            text-align: center;
            border-radius: 50%;
        }
    </style>
</head>

@php
    $company_details = \App\Models\Company::where('status', 1)
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<body onload="window.print()">
    <div class="card" style="border-style: solid; border-width: thin;">
        <header>
            <div class="hospital-name">
                {{ $company_details->hospital_name ?? '' }}
            </div>
            <div class="hospital-address">
                {{ $company_details->addrress1 ?? '' }}
            </div>
            <div>
                <strong class="hospital-card">Appointment Card</strong>
            </div>
        </header>
        <main>
            <section id="patient-info">
                <div class="container">
                    <table>
                        <tr>
                            <td width="25%">Name</td>
                            <td width="50%" style="border-bottom: 1px solid #222;">
                                <strong>{{ $salutation . ' ' . ucwords(strtolower($patient_name)) }}</strong>
                            </td>
                            @if (Session::get('user.ses_hospita_code') == 'UNICO')
                                <td width="25%" rowspan="3">
                                    <div class="circle">{{ $slot_sl }}</div>
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
                                <strong>{{ $doctor_name }} </strong>({{ $specialization }})
                            </td>
                        </tr>
                    </table>
                </div>
            </section>

            <div class="footer">
                <div class="container">
                    <table>
                        <tr>
                            <td width="40%">Appointment Date</td>
                            <td width="60%"><strong>: {{ date('d/m/Y', strtotime($appointment_date)) }}</strong></td>
                        </tr>
                        <tr>
                            @if ($appointment_card->start_time && $appointment_card->end_time)
                                <td> Time</td>
                                <td>
                                    <strong>: {{ date('h:i A', strtotime($appointment_card->start_time)) }} - 
                                    {{ date('h:i A', strtotime($appointment_card->end_time)) }}</strong>
                                </td>
                            @else
                                <td>Appointment Time</td>
                                <td><strong>: {{ date('h:i A', strtotime($appointment_card->appoint_date)) }}</strong></td>
                            @endif
                        </tr>
                        <tr>
                            @php
                                $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
                                $date = $dt->format('d/m/Y g:i A');
                            @endphp
                            <td>Print On</td>
                            <td><strong>: {{ $date }}</strong></td>
                        </tr>
                    </table>
                </div>
            </div>
        </main>
    </div>
</body>

<script>
    window.onload = function() {
        setTimeout(function() {
            window.print();
        }, 1000);
    };
</script>

</html>
