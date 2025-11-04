@extends('admin.patient-portal.layouts.app')

@section('title', 'Prescription')

@section('patient-portal-content')
    <main class="mb-5">
        <div class="container ">
            <div class="heading-title p-2 my-2">
                <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Prescription</a></span>
            </div>
            <div class="row mt-4">
                <div class="col-12">
                    <div class="card">
                        <div class="card-header">
                            <div class="table-head"><i class="fas fa-search me-1"></i>Search Panel</div>
                        </div>
                        <div class="card-body table-card-body p-3">
                            <form action="{{ route('patientPortal.prescription') }}" method="GET" class="getAttendanceData">
                                <div class="row">
                                    <div class="col-md-5 col-12 mb-2">
                                        <label for="name">From Date <span class="text-danger">*</span> </label>
                                        <input type="text" name="from_date" value="{{ request()->query('from_date') }}" class="datepicker form-control custom-form-control form-control-sm shadow-none @error('from_date') is-invalid @enderror" id="from_date" autocomplete="off">
                                        @error('from_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>

                                    <div class="col-md-5 col-12 mb-2">
                                        <label for="class"> To Date <span class="text-danger">*</span> </label>
                                        <input type="text" name="to_date" value="{{ request()->query('to_date') }}" class="datepicker form-control custom-form-control form-control-sm shadow-none @error('to_date') is-invalid @enderror" id="to_date" autocomplete="off">
                                        @error('to_date')
                                            <span class="invalid-feedback" role="alert">
                                                <strong>{{ $message }}</strong>
                                            </span>
                                        @enderror
                                    </div>   
                                    <div class="col-md-2 col-6 mt-3">
                                        <button type="submit" class="btn btn-sm btn-primary py-1 mt-2">Search</button>
                                        <a href="{{ route('patientPortal.prescription') }}" class="btn btn-sm btn-danger py-1 mt-2">Reset</a>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
            <div class="row mt-4">
                <div class="col-12 mt-md-0 mt-2">
                        <div class="card">
                            <div class="card-header">
                                <div class="table-head"><i class="fas fa-table me-1"></i>Prescription</div>
                            </div>
                            <div class="card-body table-card-body p-3">
                                <table class="table table-striped attandance_table table-sm">
                                    <thead class="text-center bg-light">
                                        <tr>
                                            <th>SL</th>
                                            <th>Prescription No.</th>
                                            <th>Doctor Name</th>
                                            <th>Department</th>
                                            <th>Date</th>
                                            <th>Action</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @forelse($result as $index => $item)
                                        <tr>
                                            <td class="text-center">{{ $index + $result->firstItem() }}</td>
                                            <td class="text-center">{{ $item->prescription_no_pk }}</td>
                                            <td class="text-center">{{ $item->full_name }}</td>
                                            <td class="text-center">{{ $item->su_name }}</td>
                                            <td class="text-center">{{ $item->appoint_date != "" ? date('d/m/y', strtotime($item->appoint_date)) : 'N/A' }}</td>
                                            <td class="text-center">
                                                @if($item->prescription_no_pk != "")
                                                {{-- <a href="{{ route('patientPortal.opd_prescription_print_pdf', ['prescription_id' => $item->prescription_no_pk]) }}" class="btn btn-sm btn-warning" target="_blank">Print</a> --}}
                                                <a href="{{ route('patientPortal.prescriptionReport', ['prescription_id' => $item->prescription_no_pk]) }}" class="btn btn-sm btn-warning" target="_blank">Print</a>
                                                @else
                                                    <button class="btn btn-sm btn-warning" disabled>Print</button>
                                                @endif
                                            </td>
                                        </tr>
                                        @empty
                                        <tr class="text-center">
                                            <td colspan="6" class="text-center">No Data Found</td>
                                        </tr>
                                        @endforelse
                                    </tbody>
                                </table>
                                <span class="float-right">{{ $result->appends($_GET)->links() }}<span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
@endsection

@push('admin-js')
<script>
    $( function() {
        var currentDate = new Date();
            $( ".datepicker" ).datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            dateFormat: 'dd-mm-yy',
        })
        // .datepicker('setDate', currentDate);
    });
</script>
@endpush
