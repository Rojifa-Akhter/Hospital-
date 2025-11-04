<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<style>
    .report-date-btn {
        display: block;
        width: 100%;
        padding: 1rem 0;
        border-radius: 0.375rem;
        font-weight: 600;
        cursor: pointer;
        transition: background-color 0.3s ease, color 0.3s ease;
        text-align: center;
        border: none;
        color: #fff;
    }

    .report-date-btn.primary {
        background-color: #007bff;
    }

    .report-date-btn.success {
        background-color: #28a745;
    }

    .report-date-btn:hover {
        background-color: #0056b3 !important;
        color: #fff !important;
        text-decoration: none;
    }

    .patient-info-card {
        margin-bottom: 2rem;
    }

    .patient-info-label {
        font-weight: 700;
        color: #495057;
    }

    .export-btn {
        white-space: nowrap;
    }
</style>

@php
$report_dates = collect($report_dates)->sortByDesc(fn($value) => $value)->values();
@endphp

<div class="container">
    <!-- Patient Info Card -->
    <div class="card patient-info-card shadow-sm">
        <div class="card-body d-flex flex-wrap align-items-center justify-content-between">
            <div class="d-flex flex-wrap flex-grow-1">
                <div class="mr-4 mb-2">
                    <div class="patient-info-label">Name</div>
                    <div>{{ $patient_info->patient_name ?? '-' }}</div>
                </div>
                <div class="mr-4 mb-2">
                    <div class="patient-info-label">IP No</div>
                    <div>{{ $patient_info->admission_uid ?? '-' }}</div>
                </div>
                <div class="mr-4 mb-2">
                    <div class="patient-info-label">Admission Date</div>
                    <div>
                        {{ isset($admission_info->admission_date) ? \Carbon\Carbon::parse($admission_info->admission_date)->format('d/m/Y') : '-' }}
                    </div>
                </div>
            </div>

            <div class="mb-2">
                <a
                    href="{{ route('ipd.download-intake-output-chart', [$patient_no_fk, $admission_id]) }}"
                    target="_blank"
                    rel="noopener noreferrer"
                    class="btn btn-warning export-btn">
                    Export PDF
                </a>
            </div>
        </div>
    </div>

    <!-- Reports Header -->
    <div class="mb-4 text-center">
        <h4 class="font-weight-bold">Daily Medicine & Investigation</h4>
        <p class="text-muted">Click on a date to view/download the report</p>
    </div>

    <!-- Reports Grid -->
    <div class="row">
        @forelse($report_dates as $key => $item)
        <div class="col-md-3 col-sm-4 col-6 mb-3">
            <a
                href="{{ route('daily-medicine-investigation-chart', [$patient_no_fk, $admission_id, $item]) }}"
                target="_blank"
                rel="noopener noreferrer"
                class="report-date-btn {{ $key % 2 == 0 ? 'primary' : 'success' }}"
                title="Click to Download Intake Output Report">
                {{ \Carbon\Carbon::parse($item)->format('d/m/Y') }}
            </a>
        </div>
        @empty
        <div class="col-12">
            <div class="alert alert-danger text-center">No Report Dates Found!</div>
        </div>
        @endforelse
    </div>
</div>






<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
