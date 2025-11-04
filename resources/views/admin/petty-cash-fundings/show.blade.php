<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Petty Cash Reimbursement Report</title>
    
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

        {{-- <header class="mb-3 text-center">
            <h1>PETTY CASH REIMBURSEMENT</h1>
        </header> --}}

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

        <div class="text-center mb-3">
            <h3 class="mb-0" style="font-size: 18px;">Petty Cash Fund Transfer Voucher</h3>
        </div>

        <hr class="dashed-line" />

        <section class="d-flex justify-content-between mb-2">
            <span>
                Journal Code: <strong>{{ $pettyCashFunding->journal_code }}</strong>
            </span>
            <span>
                Date: <strong>{{ $pettyCashFunding->journal_date ? \Carbon\Carbon::parse($pettyCashFunding->journal_date)->format('d/m/Y') : '-' }}</strong>
            </span>
        </section>

        <hr class="dashed-line" />

        <div class="mb-2">
            <div class="d-flex mb-1">
                <div class="me-3" style="min-width: 150px;">Bank Account:</div>
                <div><strong>{{ $pettyCashFunding->bank_account_no_fk }} - {{ $pettyCashFunding->bankAccount->account_name ?? '-' }}</strong></div>
            </div>
            <div class="d-flex mb-1">
                <div class="me-3" style="min-width: 150px;">Petty Cash Account:</div>
                <div><strong>{{ $pettyCashFunding->petty_account_no_fk }} - {{ $pettyCashFunding->pettyAccount->account_name ?? '-' }}</strong></div>
            </div>

            <div class="d-flex mb-1">
                <div class="me-3" style="min-width: 150px;">Cheque Number:</div>
                <div><strong>{{ $pettyCashFunding->cheque_no ?? '-' }}</strong></div>
            </div>

            <div class="d-flex mb-1">
                <div class="me-3" style="min-width: 150px;">Cheque Issue Date:</div>
                <div><strong>{{ $pettyCashFunding->cheque_issue_date ? \Carbon\Carbon::parse($pettyCashFunding->cheque_issue_date)->format('d/m/Y') : '-' }}</strong></div>
            </div>
        </div>

        <section>
            <h4 class="my-3">Fund Transfer Summary</h4>
            <p>
                BDT {{ number_format($pettyCashFunding->amount, 2) }} has been credited to 
                <strong>{{ $pettyCashFunding->pettyAccount->account_name ?? '-' }} (Account No: {{ $pettyCashFunding->pettyAccount->account_code ?? '-' }})</strong> 
                from 
                <strong>{{ $pettyCashFunding->bankAccount->account_name ?? '-' }} (Account No: {{ $pettyCashFunding->bankAccount->account_code ?? '-' }})</strong>
                via Cheque No: <strong>{{ $pettyCashFunding->cheque_no ?? '-' }}</strong>.
            </p>
            
            <div class="d-flex mb-3">
                <div class="me-2 fw-bold">Remarks:</div>
                <div class="flex-grow-1" style="min-height: 100px;">
                    {{ $pettyCashFunding->remarks ?? '' }}
                </div>
            </div>
        </section>

        <hr class="dashed-line" />

        <section class="d-flex justify-content-between mb-2 fw-bold">
            <span>BANGLADESH TAKA (BDT):</span>
            <span>Total</span>
            <span>{{ number_format($pettyCashFunding->amount, 2) }}</span>
        </section>

        <hr class="dashed-line" />

        {{-- <section class="d-flex justify-content-center mt-5">
            <div class="text-center fs-6">
                <p class="mb-3 fw-bold">Prepared By:</p>
                <p class="fw-bold mb-1">
                    {{ $pettyCashFunding->createdBy ? $pettyCashFunding->createdBy->user_fullname : '-' }}
                </p>
            </div>
        </section> --}}

        <section class="d-flex justify-content-between mt-5">
            <div class="text-center fs-6">
                <p class="mb-5 fw-bold">Prepared By:</p>
                <p class="fw-bold mb-1">
                    {{ $pettyCashFunding->createdBy ? \Illuminate\Support\Str::upper($pettyCashFunding->createdBy->user_fullname) : '-' }}
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
