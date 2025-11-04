<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <title>Payment Receipt Report</title>
    <style>
        @page {
            margin: .5cm .6cm;
        }

        body {
            font-family: 'Helvetica', Arial, sans-serif;
            font-size: 11px;
            margin: 2cm .3cm 2cm .3cm;
        }

        header {
            position: fixed;
            top: 0cm;
            left: 0cm;
            right: 0cm;
            height: 2cm;
            border-bottom: 1px solid;
            text-align: center;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: 1cm;
            border-top: 1px solid;
            font-size: 9px;
            text-align: center;
        }

        table {
            border-collapse: collapse;
            width: 100%;
            font-size: 10px;
        }

        th, td {
            border: 1px solid #222;
            padding: 4px;
        }

        th {
            background: #e3e3e3;
            font-weight: bold;
        }

        .text-right {
            text-align: right;
        }

        .text-center {
            text-align: center;
        }

        .text-left {
            text-align: left;
        }

        .total-row th {
            font-weight: bold;
        }
    </style>
</head>

<body>
    <header>
        <table style="width: 100%; border:none;">
            <tr>
                <td style="width: 15%; text-align:left; border:none;">
                    <img src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                         width="60" alt="">
                </td>
                <td style="text-align:center; border:none;">
                    <strong style="font-size:14px;">
                        {{ $po_hospital_details->hospital_name ?? '' }}
                    </strong><br>
                    Address: {{ $po_hospital_details->addrress1 ?? '' }}<br>
                    Phone: {{ $po_hospital_details->telephone1 ?? '' }}
                </td>
                <td style="width: 15%; border:none;"></td>
            </tr>
        </table>
    </header>

    <footer>
        Print Date & Time:
        {{ date('d/m/Y g:i A') }} |
        Printed By: <strong>{{ Session::get('user.ses_user_name') }}</strong>
    </footer>

    <main>
        <div style="text-align:center; margin:10px 0;">
            <span style="border:1px solid #000; padding:5px;">
                Payment Receipt Report
            </span>
        </div>
        <div style="text-align:center; margin-bottom:10px;">
            From: <strong>{{ $from_date }}</strong> - To: <strong>{{ $to_date }}</strong>
        </div>

        <table>
            <thead>
                <tr>
                    <th class="text-center">Sl</th>
                    <th class="text-left">Deposit Date</th>
                    <th class="text-left">Deposit No</th>
                    <th class="text-left">MRN</th>
                    <th class="text-left">Patient Name</th>
                    <th class="text-left">Admission No</th>
                    <th class="text-left">Invoice No</th>
                    <th class="text-left">Cashier Name</th>
                    <th class="text-right">Pay Amount</th>
                    <th scope="col" class="text-left">Status</th>
                </tr>
            </thead>
            <tbody>
                @php $total_amount = 0; @endphp
                @forelse ($report_data as $row)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ date('d/m/Y', strtotime($row->au_entry_at)) }}</td>
                        <td class="text-left">{{ $row->deposit_no_pk }}</td>
                        <td class="text-left">{{ $row->patient_code }}</td>
                        <td class="text-left">{{ $row->patient_name }}</td>
                        <td class="text-left">{{ $row->admission_no_fk }}</td>
                        
                        <td class="text-left">{{ $row->invoice_no_fk }}</td>
                        <td class="text-left">{{ $row->cashier_name ?? $row->au_entry_by }} ({{ $row->cashier_code }})</td>
                        <td class="text-right">{{ number_format($row->pay_amount, 2) }}</td>
                        <td class="text-left">
                            @if(empty($row->admission_no_fk) && !empty($row->re_invoice_no_fk) && $row->pay_amount < 0)
                                refund ({{ $row->re_invoice_no_fk }})
                           
                            @elseif(empty($row->admission_no_fk) && !empty($row->re_invoice_no_fk) && $row->pay_amount > 0)
                                cancel ({{ $row->re_invoice_no_fk }})
                          
                            @elseif(!empty($row->admission_no_fk))
                                allocate
                            @else
                                unallocate
                            @endif
                        </td>
                    </tr>
                    @php $total_amount += $row->pay_amount; @endphp
                @empty
                    <tr>
                        <td colspan="9" class="text-center">No Data Available</td>
                    </tr>
                @endforelse
            </tbody>
            <tfoot>
                <tr class="total-row">
                    <th colspan="8" class="text-right">Total =</th>
                    <th class="text-right">{{ number_format($total_amount, 2, '.', '') }}</th>
                    <th></th>
                </tr>
            </tfoot>
        </table>
    </main>
</body>
</html>
