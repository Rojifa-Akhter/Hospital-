<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Payment Voucher Report</title>

    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/utilities.css') }}">
    <style>
        main {
            max-width: 800px;
            margin: 40px auto;
            background-color: white;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            border-bottom: 2px solid #000;
            padding-bottom: 15px;
        }

        .header h1 {
            margin: 0;
            font-size: 24px;
            font-weight: bold;
        }

        .header p {
            margin: 5px 0;
            font-size: 13px;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            font-size: 14px;
            line-height: 1.4;
            border: 1px solid #000;
        }

        .table th,
        .table td {
            border: 1px solid #000;
            padding: 6px 8px;
            vertical-align: middle;
        }

        .table thead th {
            font-weight: 600;
        }

        .table tfoot td {
            font-weight: bold;
            border-top: 2px solid #000;
        }

        .table-sm thead th,
        .table-sm tbody td,
        .table-sm tfoot td {
            padding: 4px 6px;
        }

        .dashed-line {
            border-top: 1px dashed #333;
            margin: 10px 0;
        }

        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 12px 24px;
            background-color: transparent;
            color: #333;
            border: 1px solid #333;
            border-radius: 0;
            cursor: pointer;
            font-size: 13px;
            font-weight: 400;
            letter-spacing: 0.5px;
            text-transform: uppercase;
            z-index: 1000;
            transition: all 0.2s ease;
            box-shadow: none;
        }

        .print-btn:hover {
            background-color: #333;
            color: #fff;
        }

        @media print {
            @page {
                size: A4 portrait;
                margin: 10mm;
            }

            main {
                width: 210mm;
                margin: 0 auto;
                padding: 10mm;
                box-shadow: none;
                background: none;
            }

            img,
            table {
                page-break-inside: avoid;
            }

            tr,
            td,
            th {
                page-break-inside: avoid;
                page-break-after: auto;
            }

            .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <main>
        <button onclick="window.print()" class="print-btn">Print/Save</button>

        @php
            $org_info = DB::table('WSEC_HOSPITAL')->first();
        @endphp

        <div class="row" style="margin-bottom: 10px;">
            <div class="col-md-12">
                <div style="display: flex; align-items: center; justify-content: space-between;">

                    {{-- Left: Logo --}}
                    <div style="flex: 0 0 auto;">
                        @if (isset($org_info->logo) && !empty($org_info->logo))
                            <img src="{{ asset('images/uploads/hospital_images/' . $org_info->logo) }}"
                                alt="Hospital Logo" style="width: 90px; height: auto; object-fit: contain;">
                        @endif
                    </div>

                    {{-- Center: Hospital Info --}}
                    <div style="flex: 1; text-align: center; line-height: 1.4;">
                        <h2 style="margin: 0; font-size: 20px; font-weight: bold; text-transform: uppercase;">
                            {{ $org_info->hospital_name ?? '' }}
                        </h2>
                        <p style="margin: 3px 0; font-size: 13px;">
                            {{ $org_info->addrress1 ?? '' }}
                        </p>
                        <p style="margin: 2px 0; font-size: 13px;">
                            <strong>Phone:</strong> {{ $org_info->telephone1 ?? '-' }}
                        </p>
                    </div>

                    {{-- Right: Empty Space for Balance --}}
                    <div style="flex: 0 0 90px;"></div>
                </div>

                {{-- Title --}}
                <div style="text-align: center; margin-top: 10px;">
                    <h3 style="font-size: 18px; font-weight: bold; margin: 0;">Payment Voucher</h3>
                </div>
            </div>
        </div>

        <hr class="dashed-line" />
        <section class="d-flex justify-content-between mb-2">
            <span>
                Voucher Code: <strong>{{ $journalHeader->journal_code }}</strong>
            </span>
            <span>
                Date:
                <strong>{{ $journalHeader->payment_date ? \Carbon\Carbon::parse($journalHeader->payment_date)->format('d/m/Y') : '-' }}</strong>
            </span>
        </section>
        <hr class="dashed-line" />
        <section>
            <p>
                <span class="me-2 fw-bold">Payee Name:</span>
                <span>{{ $journalHeader->sub_ledger_name ?? '-' }}</span>
            </p>

            <p>
                <span class="me-2 fw-bold">Payee Address:</span>
                <span>{{ $journalHeader->holder_address ?? '-' }}</span>
            </p>

            <p>
                <span class="me-2 fw-bold">Bank A/C No:</span>
                <span>{{ $journalHeader->holder_bank_account_no ?? '-' }}</span>
            </p>

            <p>
                <span class="me-2 fw-bold">Phone No:</span>
                <span>{{ $journalHeader->holder_mobile_no ?? '-' }}</span>
            </p>

            <p>
                <span class="me-2 fw-bold">DOJ:</span>
                <span>{{ $journalHeader->holder_joining_date ? \Carbon\Carbon::parse($journalHeader->holder_joining_date)->format('d/m/Y') : '-' }}</span>
            </p>
        </section>
        <section>
            <h5>MR/MRS</h5>

            <p>
                Enclosed, Dutch-Bangla Bank Limited {{ $journalHeader->payment_type == 'cheque' ? 'Cheque' : 'FT' }}
                number {{ $journalHeader->cheque_no }} being payment for the following Kindly issue
                official receipt and indicate our payment voucher number for reference.
            </p>
        </section>
        <section>
            <h4 class="my-3">Document Details</h4>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">#SL</th>
                        <th scope="col">Description</th>
                        <th scope="col">Remarks</th>
                        <th scope="col">DR Amount</th>
                        <th scope="col">CR Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($paymentDetails as $payDetails)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $payDetails->journal_code_dtl }}</td>
                            <td>{{ $payDetails->remarks }}</td>
                            <td>{{ number_format($payDetails->dr_amount, 2) }}</td>
                            <td>{{ number_format($payDetails->cr_amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="3" class="text-end pe-1"><strong>Total</strong></td>
                        <td class="text-end">{{ number_format(collect($paymentDetails)->sum('dr_amount'), 2) }}</td>
                        <td class="text-end">{{ number_format(collect($paymentDetails)->sum('cr_amount'), 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </section>
        <p><strong>Remarks:</strong> {{ $journalHeader->remarks ?? '-' }}</p>
        <hr class="dashed-line" />

        @php
            $number = $journalHeader->amount;
            $locale = 'en_US';
            $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
            $in_words = numfmt_format($fmt, $number);
        @endphp

        <section class="d-flex justify-content-end mb-2 fw-bold">
            <span>Total : &nbsp;</span>
            <span class="text-end"> {{ number_format($journalHeader->amount, 2) }}</span>
        </section>

        <hr class="dashed-line" />

        <section class="d-flex justify-content-between mb-2 fw-bold">
            <span>In Words: {{ ucwords($in_words) }}</span>
        </section>

        <section class="d-flex justify-content-between mt-5">
            <div class="text-center fs-6">
                <p class="mb-5 fw-bold">Prepared By:</p>
                <p class="fw-bold mb-1">
                    {{ strtoupper($journalHeader->user_name) }}
                </p>
            </div>

            <div class="text-center fs-6">
                <p class="mb-5 fw-bold">Checked By:</p>
                <p class="fw-bold mb-1">AMIT KUMAR DHALI</p>
                <p class="fw-bold mb-1">ACCOUNTANT</p>
            </div>

            <div class="text-center fs-6">
                <p class="mb-5 fw-bold">Confirmed By:</p>
                <p class="fw-bold mb-1">NURADILAH BINTI SHUIB</p>
                <p class="fw-bold mb-1">CHIEF FINANCE OFFICER</p>
            </div>

            <div class="text-center fs-6">
                <p class="mb-5 fw-bold">Received By:</p>
            </div>
        </section>

        <section class="d-flex justify-content-center mt-5 gap-5">
            <div class="text-center fs-6 mr-5">
                <p class="mb-5 fw-bold">Authorized By:</p>
                <p class="fw-bold mb-1">MOHD. TAUFIK BIN ISMAIL</p>
                <p class="fw-bold mb-1">CHIEF EXECUTIVE OFFICER</p>
            </div>

            <div class="text-center fs-6">
                <p class="mb-5 fw-bold">Authorized By:</p>
                <p class="fw-bold mb-1">DR. RAZEEB HASSAN</p>
                <p class="fw-bold mb-1">MEDICAL DIRECTOR</p>
            </div>
        </section>
    </main>

    <script>
        document.addEventListener('DOMContentLoaded', function(e) {
            window.print();
        })
    </script>
</body>

</html>
