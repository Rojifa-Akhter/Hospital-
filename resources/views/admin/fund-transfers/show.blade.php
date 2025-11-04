<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <title>Fund Transfer Report</title>

    <link rel="stylesheet" href="{{ asset('css/normalize.css') }}">
    <link rel="stylesheet" href="{{ asset('css/utilities.css') }}">

    <style>
        main {
            max-width: 800px;
            margin: 40px auto;
            background-color: #fff;
            padding: 30px;
            box-shadow: 0 0 10px rgba(0, 0, 0, 0.1);
            position: relative;
        }

        .table {
            width: 100%;
            border-collapse: collapse;
            margin: 1rem 0;
            font-size: 14px;
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

        .dashed-line {
            border-top: 1px dashed #333;
            margin: 10px 0;
        }

        .print-btn {
            position: fixed;
            top: 20px;
            right: 20px;
            padding: 10px 24px;
            background-color: transparent;
            color: #333;
            border: 1px solid #333;
            cursor: pointer;
            font-size: 13px;
            z-index: 1000;
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
            .print-btn {
                display: none;
            }
        }
    </style>
</head>

<body>
    <main>
        <button onclick="window.print()" class="print-btn">Print/Save</button>

        <div class="d-flex align-items-center justify-content-between mb-3">

            <div class="flex-shrink-0">
                @if ($hospital->logo)
                    <img src="{{ asset('images/uploads/hospital_images/' . $hospital->logo) }}"
                        alt="Hospital Logo" class="img-fluid" style="width: 90px; max-height: 60px; object-fit: contain;">
                @endif
            </div>

            <div class="text-center flex-grow-1" style="line-height: 1.4;">
                <h2 class="mb-0 text-uppercase fs-5 fw-bold">
                    {{ $hospital->hospital_name ?? '' }}
                </h2>
                <p class="my-1" style="font-size: 13px;">
                    {{ $hospital->addrress1 ?? '' }}
                </p>
                <p class="my-1" style="font-size: 13px;">
                    <strong>Phone:</strong> {{ $hospital->telephone1 ?? '' }}
                </p>
            </div>

            <div style="width: 90px;"></div>
        </div>

        @php
            use App\Enums\FundTransferType;
            $headerTitle = FundTransferType::getLabel($masterFundTransfer->transfer_type) ?? 'Fund Transfer';
        @endphp

        <div class="text-center mb-3">
            <h3 class="mb-0" style="font-size: 18px;">{{ $headerTitle }} Voucher</h3>
        </div>

        <hr class="dashed-line" />

        <section class="d-flex justify-content-between mb-2">
            <span>
                Journal Code:
                <strong>{{ $masterFundTransfer->voucher_code ?? '-' }}</strong>
            </span>
            <span>
                Date:
                <strong>
                    {{ $masterFundTransfer->transfer_date ? \Carbon\Carbon::parse($masterFundTransfer->transfer_date)->format('d/m/Y') : '-' }}
                </strong>
            </span>
        </section>

        <hr class="dashed-line" />

        {{-- Debit Entries Table --}}
        <section>
            <h4 class="my-3">Debit Entries</h4>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Account No</th>
                        <th>Debit Amount (BDT)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($debitEntries as $entry)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $entry->account_fk ?? '-' }}</td>
                            <td class="text-end">{{ number_format($entry->dr_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted">No Debit Entries</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-right">Total</td>
                        <td class="text-end">{{ number_format($debitEntries->sum('dr_amount'), 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </section>

        {{-- Credit Entries Table --}}
        <section>
            <h4 class="my-3">Credit Entries</h4>
            <table class="table table-sm">
                <thead>
                    <tr>
                        <th>#</th>
                        <th>Account No</th>
                        <th>Credit Amount (BDT)</th>
                    </tr>
                </thead>
                <tbody>
                    @forelse ($creditEntries as $entry)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $entry->account_fk ?? '-' }}</td>
                            <td class="text-end">{{ number_format($entry->cr_amount, 2) }}</td>
                        </tr>
                    @empty
                        <tr><td colspan="3" class="text-center text-muted">No Credit Entries</td></tr>
                    @endforelse
                </tbody>
                <tfoot>
                    <tr>
                        <td colspan="2" class="text-right">Total</td>
                        <td class="text-end">{{ number_format($creditEntries->sum('cr_amount'), 2) }}</td>
                    </tr>
                </tfoot>
            </table>
        </section>

        <hr class="dashed-line" />

        <section class="d-flex justify-content-between mb-2 fw-bold">
            <span>BANGLADESH TAKA (BDT):</span>
            <span>Total</span>
            <span>{{ number_format($masterFundTransfer->total_amount, 2) }}</span>
        </section>

        <hr class="dashed-line" />

        <section class="d-flex justify-content-between mt-5">
            <div class="text-center fs-6">
                <p class="mb-5 fw-bold">Prepared By:</p>
                <p class="fw-bold mb-1">
                    {{ $masterFundTransfer->createdBy ? \Illuminate\Support\Str::upper($masterFundTransfer->createdBy->user_fullname) : '-' }}
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
        document.addEventListener('DOMContentLoaded', function () {
            window.print();
        });
    </script>
</body>
</html>