@extends('admin.patient-portal.layouts.app')

@section('patient-portal-content')
<main class="">
    <div class="container-fluid">
        <div class="heading-title p-2">
            <span class="my-3 heading "><i class="fas fa-home"></i> <a class="" href="">Dashboard</a></span>
        </div>

        <div class="row row-cols-md-4 row-cols-1 mt-3 g-2">
            <div class="col">
                <div class="card dashboard-card" style="background-color: #fcba03;">
                    <div class="card-body">
                        <a href="{{ route('patientPortal.invoice') }}" style="text-decoration:none">
                            <div class="text-center">
                                <button type="button" class="btn position-relative" style="background-color:white">
                                    <i class="fas fa-file-invoice" style="font-size: 18px"></i>
                                </button>
                            </div>
                            <div class="dashboard-title">Invoice List</div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card dashboard-card" style="background-color: #fc035a;">
                    <div class="card-body">
                        <a href="{{ route('patientPortal.prescription') }}" style="text-decoration:none">
                            <div class="text-center">
                                <button type="button" class="btn position-relative" style="background-color:white">
                                    <i class="fas fa-prescription" style="font-size: 18px"></i>
                                </button>
                            </div>
                            <div class="dashboard-title">Prescription</div>
                        </a>
                    </div>
                </div>
            </div>
            <div class="col">
                <div class="card dashboard-card" style="background-color: #03befc">
                    <div class="card-body">
                        <a href="{{ route('patientPortal.ipd') }}" style="text-decoration:none">
                            <div class="text-center">
                                <button type="button" class="btn position-relative" style="background-color:white">
                                    <i class="fas fa-notes-medical text-danger" style="font-size: 18px"></i>
                                </button>
                            </div>
                            <div class="dashboard-title">IPD</div>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</main>
@endsection