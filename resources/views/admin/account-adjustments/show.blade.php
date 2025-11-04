<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Account Adjustment Report</title>
    
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

            img, table {
                page-break-inside: avoid;
            }

            tr, td, th {
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

        <header class="mb-3 text-center">
            <h1>ACCOUNT ADJUSTMENT REPORT</h1>
        </header>

        <hr class="dashed-line" />

        <section class="d-flex justify-content-between mb-2">
            <span>
                Journal Code: <strong>{{ $journalHeader->journal_code }}</strong>
            </span>
            <span>
                Date: <strong>{{ $journalHeader->journal_date ? \Carbon\Carbon::parse($journalHeader->journal_date)->format('d/m/Y') : '-' }}</strong>
            </span>
        </section>

        <section class="d-flex justify-content-between mb-2">
            <span>
                Adjustment Type: <strong>{{ ucfirst($journalHeader->adjustmentDetails->first()->adjustment_type ?? '-') }}</strong>
            </span>
            <span>
                Document Date: <strong>{{ $journalHeader->doc_date ? \Carbon\Carbon::parse($journalHeader->doc_date)->format('d/m/Y') : '-' }}</strong>
            </span>
        </section>

        <hr class="dashed-line" />

        <section>
            <h4 class="my-3">Debit Entries</h4>

            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Account</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($debitEntries as $debitEntry)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $debitEntry->account->account_name ?? '-' }}</td>
                            <td>{{ number_format($debitEntry->dr_amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-end pe-1"><strong>Total</strong></td>
                        <td class="text-end">{{ number_format($journalHeader->dr_account_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </section>

        <section>
            <h4 class="my-3">Credit Entries</h4>

            <table class="table table-sm">
                <thead>
                    <tr>
                        <th scope="col">#</th>
                        <th scope="col">Account</th>
                        <th scope="col">Amount</th>
                    </tr>
                </thead>
                <tbody>
                    @foreach ($creditEntries as $creditEntry)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $creditEntry->account->account_name ?? '-' }}</td>
                            <td>{{ number_format($creditEntry->cr_amount, 2) }}</td>
                        </tr>
                    @endforeach
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-end pe-1"><strong>Total</strong></td>
                        <td class="text-end">{{ number_format($journalHeader->cr_account_amount, 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </section>

        <hr class="dashed-line" />

        <section class="d-flex justify-content-between mb-2 fw-bold">
            <span>BANGLADESH TAKA (BDT):</span>
            <span>Total</span>
            <span>{{ number_format($journalHeader->cr_account_amount, 2) }}</span>
        </section>

        <hr class="dashed-line" />

        {{-- <section class="d-flex justify-content-between mt-5">

            <div class="text-center fs-6">
                <p class="mb-3 fw-bold">Prepared By:</p>
                <p class="fw-bold mb-1">
                    {{ $journalHeader->createdBy ? $journalHeader->createdBy->user_fullname : '-' }}
                </p>
                <p><small>(Chief Finance Officer)</small></p>
            </div>

            <div class="text-center fs-6">
                <p class="mb-3 fw-bold">Checked By:</p>
                <p class="fw-bold mb-1">Place Holder</p>
                <p><small>(Chief Finance Officer)</small></p>
            </div>

            <div class="text-center fs-6">
                <p class="mb-3 fw-bold">Authorized By:</p>
                <p class="fw-bold mb-1">Place Holder</p>
                <p><small>(Chief Executive Officer)</small></p>
            </div>

        </section> --}}

        <section class="d-flex justify-content-center mt-5">
            <div class="text-center fs-6">
                <p class="mb-3 fw-bold">Prepared By:</p>
                <p class="fw-bold mb-1">
                    {{ $journalHeader->createdBy ? $journalHeader->createdBy->user_fullname : '-' }}
                </p>
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
