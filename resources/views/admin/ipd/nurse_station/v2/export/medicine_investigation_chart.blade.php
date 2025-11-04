<!DOCTYPE html>
<html lang="bn">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta http-equiv="X-UA-Compatible" content="ie=edge">

    <style>
        body {
            font-family: Arial, sans-serif;
            margin: 0.1cm 1cm 1cm 1cm;
            color: #000;
        }

        .table {
            border-collapse: collapse;
            width: 100%;
        }

        .header-table {
            margin-top: 0;
            /* ensures table starts at top */
        }

        .table th,
        .table td {
            font-size: 13px;
            border: 1px solid #333;
            padding: 4px 6px;
            page-break-inside: avoid;
        }

        .table thead {
            background-color: #f0f0f0;
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

        .header-table td {
            border: none;
            font-size: 14px;
            line-height: 1.5;
        }

        .footer-table {
            position: absolute;
            bottom: 0px;
            width: 100%;
            left: 0px;
            right: 0px;
            font-size: 12px;
        }

        .section-title {
            padding: 7px;
            border-top: 1px dotted #000;
            border-bottom: 1px dotted #000;
            text-align: center;
            margin-top: 20px;
            margin-bottom: 20px;
            font-size: 16px;
            font-weight: bold;
        }




         table {
    border-collapse: collapse;
    width: 150px;
  }

  .diagonal-cell {
    border: 1px solid black;
    width: 60px;
    height: 80px;
    text-align: center;
    vertical-align: middle;
    position: relative;
  }





  /* Below cells: just diagonal lines */
  .diagonal-cell::before {
    content: "";
    position: absolute;
    top: 0;
    left: 0;
    width: 100%;
    height: 100%;
    background: linear-gradient(to top left, transparent 49.5%, black 50%, transparent 50.5%);
  }
    </style>
</head>

<body onload="window.print()">

    <!-- Header Section -->
    <table class="table header-table">
        <tr>
            <td style="width:65%">
                <ul style="list-style: none; padding-left: 0;">
                    <li><strong>IP No:</strong> {{ $admission_info->admission_no_pk ?? '' }}</li>
                    {{-- <li><img src="data:image/png;base64,{{ $invoice_barcode }}" alt="IP Barcode"></li> --}}
                    <li>
                        <strong>Name:</strong> {{ $patient_info->patient_name ?? '' }} &nbsp;
                        <strong>Age:</strong> {{ $patient_info->age ?? '' }} &nbsp;
                        <strong>Gender:</strong> {{ $patient_info->gender_txt ?? '' }} <br>
                        <strong>Bed:</strong> {{ $admission_info->bed_name ?? '' }}
                    </li>
                    {{-- <li><strong>Con. Number:</strong> {{ $patient_info->mobile1 ?? '' }}</li> --}}
                    <li><strong>Consultant Name:</strong> {{ $admission_info->primary_doctor_name ?? '' }}</li>
                </ul>
            </td>
            <td style="width:35%; text-align:right;">
                <ul style="list-style: none; padding-left: 0;">
                    <li><strong>UHID:</strong> {{ $patient_info->patient_code ?? '' }}</li>
                    {{-- <li><img src="data:image/png;base64,{{ $pat_barcode }}" alt="Patient Barcode"></li> --}}
                    {{-- <li><strong>Phone:</strong> {{ $patient_info->mobile1 ?? '' }}</li> --}}
                    <li><strong>IP Date:</strong> {{ date('d/m/Y h:i a', strtotime($admission_info->admission_date)) }}
                    </li>
                    @if (!empty($admission_info->dis_datetime))
                        <li><strong>Date of Discharge:</strong>
                            {{ date('d/m/Y h:i a', strtotime($admission_info->dis_datetime)) }}</li>
                    @endif
                    @if (!empty($date))
                        <li><strong>Medicine & Investigation Date:</strong> {{ date('d/m/Y', strtotime($date)) }}</li>
                    @endif
                </ul>
            </td>
        </tr>
    </table>

    <!-- Medicine Section -->
    @if (!empty($prescription_med))
        <div class="section-title">Prescribed Medicines</div>
        <div class="">
            <table class="table">
                <thead>
                    <tr>
                        <th class="text-center">SL</th>
                        <th class="text-left">Medicine</th>
                        <th class="text-left">Frequency</th>
                        <th class="text-left">Duration</th>
                        <th class="text-left">Administered and Time</th>
                        <th>
                            <span class="top-text">Given by</span>
                            <hr>
                            <span class="bottom-text">Verified by</span>
                        </th>
                        <th>
                            <span class="top-text">Given by</span>
                            <hr>
                            <span class="bottom-text">Verified by</span>
                        </th>
                        <th>
                            <span class="top-text">Given by</span>
                            <hr>
                            <span class="bottom-text">Verified by</span>
                        </th>
                        <th>
                            <span class="top-text">Given by</span>
                            <hr>
                            <span class="bottom-text">Verified by</span>
                        </th>
                        <th>
                            <span class="top-text">Given by</span>
                            <hr>
                            <span class="bottom-text">Verified by</span>
                        </th>




                    </tr>
                </thead>
                <tbody>
                    @forelse($prescription_med as $index => $medicine)
                        <tr>
                            <td class="text-center">{{ $index + 1 }}</td>
                            <td class="text-left">{{ $medicine->item_name ?? '-' }}</td>
                            <td class="text-left">{{ $medicine->dosage ?? '-' }}</td>
                            <td class="text-left">{{ $medicine->duration ?? '-' }} {{ $medicine->duration_mu ?? '' }}
                            </td>
                            <td>

                            </td>
                            <td class="diagonal-cell"></td>
                            <td class="diagonal-cell"></td>
                            <td class="diagonal-cell"></td>
                            <td class="diagonal-cell"></td>
                            <td class="diagonal-cell"></td>


                        </tr>
                    @empty
                        <tr>
                            <td colspan="6" class="text-center text-danger">
                                <small>No Medicines Found</small>
                            </td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    @endif

    <!-- Investigation Section -->
    {{-- @if (!empty($investigation))
    <div class="section-title">Prescribed Investigations</div>
    <div class="scroll-table">
        <table class="table">
            <thead>
                <tr>
                    <th class="text-center">SL</th>
                    <th class="text-left">Investigation</th>
                </tr>
            </thead>
            <tbody>
                @php $index = 1; @endphp
                @forelse ($investigation as $item)
                @if ($item->lookup_uid === 'FINDINGS' || $item->lookup_uid === 'INVFIND')
                <tr>
                    <td class="text-center">{{ $index++ }}</td>
                    <td class="text-left">{{ $item->prescrition_data ?? '-' }}</td>
                </tr>
                @endif
                @empty
                <tr>
                    <td colspan="2" class="text-center text-danger">
                        <small>No Investigations Found</small>
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
    @endif --}}


    <!-- Footer -->
    <section class="footer-table">
        @php
            $dt = new DateTime('now', new DateTimezone('Asia/Dhaka'));
        @endphp
        <table class="table" style="border: none;">
            <tr>
                <td style="border: none; text-align: left; width: 70%;">
                    Staff ID: {{ @$userInfo->user_code }}, Printing Date & Time: {{ $dt->format('d/m/Y h:i A') }}
                </td>
                <td style="border: none; text-align: right; width: 30%;">
                    Powered By: NEXTGEN IT
                </td>
            </tr>
        </table>
    </section>

</body>

</html>
