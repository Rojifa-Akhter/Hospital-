<link rel="stylesheet" href="{{ asset('dashboardv2_assets/plugins/charts-c3/c3-chart.css') }}" />
<!-- Animate css -->
<link rel="stylesheet" href="{{ asset('dashboardv2_assets/WOW-master/css/libs/animate.css') }}" />

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<!-- Font Awesome CDN -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0-beta3/css/all.min.css">

<style>
    /* New 3:2 aspect ratio for Today's data */

    /* Slightly darker background for "Today" row */
    .today-row {
        background-color: #eaf1fd;
    }

    /* Table hover effect */
    .table-hover tbody tr:hover {
        background-color: #f4f4f4;
    }

    /* Table responsive design */
    .table-responsive {
        margin-top: 20px;
    }

    /* Table header styling */
    .table thead th {
        background-color: #322F78;
        color: white;
        font-weight: bold;
        font-size: 18px;
    }

    /* Improved table row design */
    .table td,
    .table th {
        padding: 20px;
        text-align: center;
        vertical-align: middle;
        border: 2px solid #ddd;
    }

    /* More modern card shadow */
    .card {
        box-shadow: 0 6px 30px rgba(0, 0, 0, 0.1);
    }

    /* Enhanced hover effect for rows */
    .table-hover tbody tr:hover {
        background-color: #f4f4f4;
    }

    .total-bed {
        display: flex;
        gap: 30px;
        background: #F7F9FB;
        padding: 15px;
        border-bottom: 3px solid #535673;
    }

    .bed-icon i {
        font-size: 50px;
        color: #322F78;
    }

    .bed-details h3 {
        color: #322F78;
        font-weight: 700;
        font-size: 24px;
        text-transform: uppercase;
        letter-spacing: 0.1px;
        margin-bottom: 0;
    }

    .bed-details span {
        font-weight: 700;
        font-size: 48px;
        color: #322F78;
        letter-spacing: 0.1px;
    }

    .bed-icon.bg-green i {
        color: #07BE6E;
    }

    .bed-details.green-txt h3 {
        color: #07be6e;
    }

    .bed-details.green-txt h3 {
        color: #07be6e;
    }

    .bed-icon.bg--blue i {
        color: #0177FB;
    }

    .bed-details.blue--txt h3 {
        color: #0177fb;
    }

    .bed-details.blue--txt .month_wise {
        padding: 0;
        margin-top: 15px;
    }

    .bed-details.blue--txt .month_wise li {
        list-style: none;
    }

    .bed-details.blue--txt .month_wise li {
        display: flex;
        justify-content: space-between;
    }

    .month_wise li h5 {
        color: #4E4E4E;
        font-size: 18px;
        font-weight: 700;
    }

    .month_wise li h6 {
        color: #0177FB;
        font-size: 18px;
        font-weight: 700;
    }

    .today-data-container {
        margin-bottom: 20px;
        padding: 20px;
        background-color: #f7f9fc;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .today-block {
        padding: 20px;
        background-color: #322F78;
        border-radius: 10px;
        color: white;
        text-align: center;
    }

    .today-header {
        font-size: 22px;
        margin-bottom: 15px;
    }

    .today-content {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .today-item {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 15px;
        text-align: center;
        font-size: 20px;
        color: #322F78;
        transition: background-color 0.3s ease, box-shadow 0.3s ease;
    }

    .today-item:hover {
        background-color: #f1f1f1;
        cursor: pointer;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
    }

    .today-item-header {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .today-item-content {
        font-size: 24px;
        font-weight: bold;
        color: #007bff;
    }

    .today-item-revenue {
        font-size: 14px;
        color: #28a745;
        font-weight: bold;
    }

    .today-item-collection {
        font-size: 14px;
        color: #ff5733;
        font-weight: bold;
    }

    .today-data-container {
        margin-bottom: 20px;
        padding: 20px;
        background-color: #f7f9fc;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
    }

    .today-block {
        padding: 20px;
        background-color: #322F78;
        border-radius: 10px;
        color: white;
        text-align: center;
    }

    .today-header {
        font-size: 22px;
        margin-bottom: 15px;
    }

    .today-content {
        display: grid;
        grid-template-columns: repeat(3, 1fr);
        gap: 15px;
    }

    .today-item {
        background-color: #ffffff;
        border-radius: 10px;
        box-shadow: 0 4px 10px rgba(0, 0, 0, 0.1);
        padding: 15px;
        text-align: center;
        font-size: 20px;
        color: #322F78;
        transition: all 0.3s ease;
    }

    .today-item:hover {
        background-color: #f1f1f1;
        /* Light background change */
        cursor: pointer;
        box-shadow: 0 6px 15px rgba(0, 0, 0, 0.15);
        /* Deep shadow */
        transform: scale(1.05);
        /* Slightly enlarges the item */
    }

    .today-item-header {
        font-size: 16px;
        font-weight: bold;
        color: #333;
        margin-bottom: 5px;
    }

    .today-item-content {
        font-size: 24px;
        font-weight: bold;
        color: #007bff;
    }

    .today-item-revenue {
        font-size: 14px;
        color: #28a745;
        font-weight: bold;
    }

    .today-item-collection {
        font-size: 14px;
        color: #ff5733;
        font-weight: bold;
    }

    .table th,
    .table td {
        vertical-align: middle;
    }

    .card {
        border-radius: 10px;
        overflow: hidden;
    }

    .card-header {
        border-bottom: none;
    }

    .table-hover tbody tr:hover {
        background-color: #f1f1f1;
    }

    .chartsh {
        min-height: 300px;
    }

    .same-height {
        min-height: 400px;
        display: flex;
        flex-direction: column;
    }

    .same-height .card-body {
        flex-grow: 1;
    }

    .custom-table th {
        background-color: #0177FB !important;
        color: white !important;
        font-weight: bold;
    }

    .table-scroll {
        max-height: 350px;
        overflow-y: auto;
    }

    .table-hover tbody tr:hover {
        background-color: rgba(0, 123, 255, 0.1);
        transition: all 0.3s ease-in-out;
    }

    /* Scrollbar Customization */
    .table-scroll::-webkit-scrollbar {
        width: 8px;
    }

    .table-scroll::-webkit-scrollbar-thumb {
        background-color: #0177FB;
        border-radius: 10px;
    }

    .table-scroll::-webkit-scrollbar-track {
        background: #f1f1f1;
    }
</style>
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm p-2">
        <div class="col-md-3">
            <h5 class="mb-0">Managment Dashboard</h5>
            <small>Managment / Managment Dashboard</small>
        </div>

        {{-- <div class="col-md-9">
            <div class="form-row justify-content-end mt-2">
                <div class="col-md-2">
                    <a href="#" class="btn btn-success btn-block btn-md"><i class="fa fa-sync"></i> Refresh</a>
                </div>
            </div>
        </div> --}}
    </div>


    <div class="row">
        <div class="col-md-12 mt-3">
            <!-- Today Data Section - Big and Outside of Table -->
            <div class="today-data-container">
                <div class="today-block">
                    <div class="today-header">Today's Hospital Summary</div>
                    <div class="today-content">

                        <!-- OPD Consultation -->
                        <div class="today-item">
                            <div class="today-item-header">
                                <i class="fas fa-hospital-user"></i> OPD Consultation
                            </div>
                            <div class="today-item-content">
                                {{ isset($hospital_summary_opd[0]->today) ? $hospital_summary_opd[0]->today : '0' }}
                            </div>
                            <div class="today-item-revenue">Revenue:
                                ৳{{ number_format($opd_consultation_sales->revenue ?? 0, 2) }}</div>
                            <div class="today-item-collection">Collection:
                                ৳{{ number_format($opd_consultation_sales->collection ?? 0, 2) }}</div>
                        </div>

                        <!-- OPD Service -->
                        <div class="today-item">
                            <div class="today-item-header">
                                <i class="fas fa-cogs"></i> OPD Service
                            </div>
                            <div class="today-item-content">
                                {{ isset($total_opd_service) ? $total_opd_service : '0' }}
                            </div>
                            <div class="today-item-revenue">Revenue:
                                ৳{{ number_format($opd_service_sales->revenue ?? 0, 2) }}</div>
                            <div class="today-item-collection">Collection:
                                ৳{{ number_format($opd_service_sales->collection ?? 0, 2) }}</div>
                        </div>

                        <!-- IPD -->
                        <div class="today-item">
                            <div class="today-item-header">
                                <i class="fas fa-bed"></i> IPD
                            </div>
                            <div class="total-admission-label" style="color: #f39c12; font-weight: bold;">
                                Total Admission:
                                {{ isset($today_admission_ipd) ? $today_admission_ipd : '0' }}
                            </div>
                            <div class="today-item-content">
                                {{ isset($ipd_sales_dt->total_service) ? $ipd_sales_dt->total_service : '0' }}
                            </div>
                            <div class="today-item-revenue">Revenue:
                                ৳{{ number_format(($ipd_sales_dt_rev->revenue ?? 0) + ($ipd_sales_dt_rev->revenue ?? 0), 2) }}
                            </div>
                            <div class="today-item-collection">Collection:
                                ৳{{ number_format(($ipd_sales_dt->collection ?? 0) + ($ipd_sales_dt->collection ?? 0), 2) }}
                            </div>
                        </div>

                        <!-- Discharge patient -->
                        <div class="today-item">
                            <div class="today-item-header">
                                <i class="fas fa-eject"></i> Discharge Patient
                            </div>
                            <div class="total-admission-label" style="color: #f39c12; font-weight: bold;">
                                Total Discharge:
                                {{ isset($today_discharge_ipd) ? $today_discharge_ipd : '0' }}
                            </div>
                            {{-- <div class="today-item-content">
                                {{ isset($ipd_sales_dt->total_service) ? $ipd_sales_dt->total_service : '0' }}
                            </div>
                            <div class="today-item-revenue">Revenue:
                                ৳{{ number_format(($ipd_sales_dt_rev->revenue ?? 0) + ($ipd_sales_dt_rev->revenue ?? 0), 2) }}
                            </div>
                            <div class="today-item-collection">Collection:
                                ৳{{ number_format(($ipd_sales_dt->collection ?? 0) + ($ipd_sales_dt->collection ?? 0), 2) }}
                            </div> --}}
                        </div>



                        <!-- Emergency -->
                        <div class="today-item">
                            <div class="today-item-header">
                                <i class="fas fa-first-aid"></i> Emergency
                            </div>
                            <div class="total-admission-label" style="color: #f39c12; font-weight: bold;">
                                Total IP Patient:
                                {{ isset($today_admission_emr) ? $today_admission_emr : '0' }}
                            </div>
                            <div class="today-item-content">
                                {{ isset($emr_sales_dt->total_service) ? $emr_sales_dt->total_service : '0' }}
                            </div>
                            <div class="today-item-revenue">Revenue:
                                ৳{{ number_format($emr_sales_dt->revenue ?? 0, 2) }}
                            </div>
                            <div class="today-item-collection">Collection:
                                ৳{{ number_format($emr_sales_dt->collection ?? 0, 2) }}</div>
                        </div>

                        <div class="today-item">
                            <div class="today-item-header">
                                <i class="fas fa-procedures"></i> OPD Emergency
                            </div>
                            <div class="total-admission-label" style="color: #f39c12; font-weight: bold;">
                                Total OP Patient:
                                {{ isset($today_admission_emr_opd) ? $today_admission_emr_opd : '0' }}
                            </div>
                            <div class="today-item-content">
                                {{ isset($emr_sales_opd_dt->total_service) ? $emr_sales_opd_dt->total_service : '0' }}
                            </div>
                            <div class="today-item-revenue">
                                Revenue: ৳{{ number_format($emr_sales_opd_dt->revenue ?? 0, 2) }}
                            </div>
                            <div class="today-item-collection">
                                Collection: ৳{{ number_format($emr_sales_opd_dt->collection ?? 0, 2) }}
                            </div>
                        </div>



                        <!-- Pharmacy -->
                        <div class="today-item">
                            <div class="today-item-header">
                                <i class="fas fa-pills"></i> Pharmacy
                            </div>
                            <div class="today-item-content">
                                {{ isset($total_phr_service) ? $total_phr_service : '0' }}
                            </div>
                            <div class="today-item-revenue">Revenue:
                                ৳{{ number_format($pharmacy_sales->revenue ?? 0, 2) }}</div>
                            <div class="today-item-collection">Collection:
                                ৳{{ number_format($pharmacy_sales->collection ?? 0, 2) }}</div>
                        </div>

                        <!-- IPD Pharmacy -->
                        <div class="today-item">
                            <div class="today-item-header">
                                <i class="fas fa-capsules"></i> IPD Pharmacy
                            </div>
                            <div class="today-item-content">
                                {{ isset($total_ipd_service) ? $total_ipd_service : '0' }}
                            </div>
                            <div class="today-item-revenue">Revenue:
                                ৳{{ number_format($ipd_pharmacy_sales->revenue ?? 0, 2) }}</div>
                            <div class="today-item-collection">Collection:
                                ৳{{ number_format($ipd_pharmacy_sales->collection ?? 0, 2) }}</div>
                        </div>

                        <!-- Physiotherapy -->
                        <div class="today-item">
                            <div class="today-item-header">
                                <i class="fas fa-dumbbell"></i> Physiotherapy
                            </div>
                            <div class="today-item-content">
                                {{ isset($hospital_summary_physiotherapy[0]->today) ? number_format($hospital_summary_physiotherapy[0]->today, 2) : '0' }}
                            </div>
                            <div class="today-item-revenue">Revenue:
                                ৳{{ number_format($physiotherapy_sales->revenue ?? 0, 2) }}</div>
                            <div class="today-item-collection">Collection:
                                ৳{{ number_format($physiotherapy_sales->collection ?? 0, 2) }}</div>
                        </div>

                        <!-- Cafeteria/Coffeeshop -->
                        <div class="today-item">
                            <div class="today-item-header">
                                <i class="fas fa-coffee"></i> Cafeteria/Coffeeshop
                            </div>
                            <div class="today-item-content">
                                {{ isset($total_cofee_shop_service) ? $total_cofee_shop_service : '0' }}
                            </div>
                            <div class="today-item-revenue">Revenue:
                                ৳{{ number_format($cafeteria_sales->revenue ?? 0, 2) }}</div>
                            <div class="today-item-collection">Collection:
                                ৳{{ number_format($cafeteria_sales->collection ?? 0, 2) }}</div>
                        </div>

                        <!-- Optical Shop -->
                        @if (Session::get('user.ses_hospital_code') == 'DMHL')
                            <div class="today-item">
                                <div class="today-item-header">
                                    <i class="fas fa-glasses"></i> Optical Shop
                                </div>
                                <div class="today-item-content">
                                    {{ isset($total_opt_service) ? $total_opt_service : '0' }}
                                </div>
                                <div class="today-item-revenue">Revenue:
                                    ৳{{ number_format($optical_shop_sales->revenue ?? 0, 2) }}</div>
                                <div class="today-item-collection">Collection:
                                    ৳{{ number_format($optical_shop_sales->collection ?? 0, 2) }}</div>
                            </div>
                        @endif



                    </div>
                </div>
            </div>






            <!-- Hospital Summary Table -->
            <div class="card mb-4 shadow-sm">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-0">Hospital Summary</h5>
                </div>
                <div class="card-body p-3">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover">
                            <thead>
                                <tr>
                                    <th class="table-left-border-radius" colspan="2">OPD Doctor Consultation</th>
                                    <th colspan="2">IPD Patient Admission</th>
                                    {{-- <th colspan="2">IPD Doctor Consultation</th> --}}
                                    <th colspan="2">Pharmacy Collection</th>
                                    <th colspan="2">OT</th>
                                    <th class="table-right-border-radius" colspan="2">Emergency</th>
                                </tr>
                            </thead>
                            <tbody>
                                <!-- Yesterday Section -->
                                <tr>
                                    <td class="text-left">Yesterday</td>
                                    <td class="text-center">{{ $hospital_summary_opd[0]->yesterday }}</td>
                                    {{-- <td>Yesterday</td> --}}
                                    {{-- <td class="text-center">{{ $hospital_summary_ipd[0]->yesterday }}</td> --}}
                                    <td>Yesterday</td>
                                    <td class="text-center">{{ $hospital_summary_ipd_cons[0]->yesterday }}</td>
                                    <td>Yesterday</td>
                                    <td class="text-center">{{ number_format($hospital_summary_phr[0]->yesterday, 2) }}
                                    </td>
                                    <td>Yesterday</td>
                                    <td class="text-center">{{ $hospital_summary_ot[0]->yesterday }}</td>
                                    <td>Yesterday</td>
                                    <td class="text-center">{{ $hospital_summary_emergency[0]->yesterday }}</td>
                                </tr>

                                <!-- This Month Section -->
                                <tr>
                                    <td class="text-left">This Month</td>
                                    <td class="text-center">{{ $hospital_summary_opd[0]->this_month }}</td>
                                    {{-- <td>This Month</td>
                                    <td class="text-center">{{ $hospital_summary_ipd[0]->this_month }}</td> --}}
                                    <td>This Month</td>
                                    <td class="text-center">{{ $hospital_summary_ipd_cons[0]->this_month }}</td>
                                    <td>This Month</td>
                                    <td class="text-center">
                                        {{ number_format($hospital_summary_phr[0]->this_month, 2) }}</td>
                                    <td>This Month</td>
                                    <td class="text-center">{{ $hospital_summary_ot[0]->this_month }}</td>
                                    <td>This Month</td>
                                    <td class="text-center">{{ $hospital_summary_emergency[0]->this_month }}</td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>



    {{-- <div class="col-md-8">
            <div class="card">
                <div class="card-header">
                    <h5>Comparison</h5>
                </div>
                <h5 class="ml-3"><strong> Month Wise Comparision (Last 3 Months)</strong></h5>
                <div class="card-body p-0">
                    <div id="month-wise-conversion" class="chartsh h-300"></div>

                </div>
            </div>
        </div> --}}
    <div class="row">
        <!-- Table Section -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-1">Conversion To IPD</h5>
                    <p class="small mb-0">Month-wise Comparison (Last 3 Months)</p>
                </div>
                <div class="card-body p-0">
                    <div class="table-responsive">
                        <table class="table table-hover text-center">
                            <thead class="bg-primary text-white">
                                <tr>
                                    <th>Month</th>
                                    <th>OPD</th>
                                    <th>Month</th>
                                    <th>Emergency</th>
                                    <th>Month</th>
                                    <th>General</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ipd_conversation as $data)
                                    <tr>
                                        <td>{{ optional($data)->month }}</td>
                                        <td>{{ optional($data)->opd }}</td>
                                        <td>{{ optional($data)->month }}</td>
                                        <td>{{ optional($data)->emr }}</td>
                                        <td>{{ optional($data)->month }}</td>
                                        <td>{{ optional($data)->others }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Chart Section -->
        <div class="col-md-6">
            <div class="card shadow-sm border-0">
                <div class="card-header bg-primary text-white">
                    <h5 class="mb-1">Conversion to IPD (Last 3 Months)</h5>
                </div>
                <div class="card-body p-3">
                    <div id="conversion-to-ipd" class="chartsh h-300"></div>
                </div>
            </div>
        </div>
    </div>

    {{-- <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header">
                    <h5>Location Wise Patient(10 Location Last 3 Month)</h5>
                </div>
                <div class="card-body p-0">
                    <div id="location-wise-patient" class="chartsh "></div>
                </div>
            </div>
        </div>
    </div> --}}


    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header bg-primary">
                    <h5>Pharmacy</h5>
                </div>
                <div class="card-body p-0">
                    {{-- <img class="img-fluid w-100" src="{{ asset('images/bar-chart.png') }}"> --}}
                    <div id="phr-type-data" class="chartsh "></div>
                </div>
            </div>
        </div>
    </div>

    <div class="row">
        <!-- IPD Consultation By Department -->
        <div class="col-md-6">
            <div class="card shadow-lg border-0 same-height">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">IPD Consultation By Department</h5>
                    <i class="fas fa-hospital-user"></i>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive table-scroll">
                        <table id="ipd-table" class="table table-hover text-center custom-table datatable">
                            <thead class="bg-primary ">
                                <tr>
                                    <th>Department</th>
                                    <th>{{ $ipd_conversation[0]->month ?? 'N/A' }}</th>
                                    <th>{{ $ipd_conversation[1]->month ?? 'N/A' }}</th>
                                    <th>{{ $ipd_conversation[2]->month ?? 'N/A' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($ipd_dt ?? [] as $value)
                                    <tr>
                                        <td>{{ ucfirst($value->serviceunit_name) }}</td>
                                        <td>{{ $value->current_month }}</td>
                                        <td>{{ $value->pre_month }}</td>
                                        <td>{{ $value->last_month }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- OPD Consultation By Department -->
        <div class="col-md-6">
            <div class="card shadow-lg border-0 same-height">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">OPD Consultation By Department</h5>
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive table-scroll">
                        <table id="opd-table" class="table table-hover text-center custom-table datatable">
                            <thead class="bg-primary ">
                                <tr>
                                    <th>Department</th>
                                    <th>{{ $ipd_conversation[0]->month ?? 'N/A' }}</th>
                                    <th>{{ $ipd_conversation[1]->month ?? 'N/A' }}</th>
                                    <th>{{ $ipd_conversation[2]->month ?? 'N/A' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($opd_dt ?? [] as $value)
                                    <tr>
                                        <td>{{ ucfirst($value->serviceunit_name) }}</td>
                                        <td>{{ $value->current_month }}</td>
                                        <td>{{ $value->pre_month }}</td>
                                        <td>{{ $value->last_month }}</td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div class="row">
        <!-- Doctor Performance by OPD -->
        <div class="col-md-6">
            <div class="card shadow-lg border-0 same-height">
                <div class="card-header bg-primary text-white d-flex justify-content-between align-items-center">
                    <h5 class="mb-0">Doctor Performance by OPD</h5>
                    <i class="fas fa-user-md"></i>
                </div>
                <div class="card-body p-2">
                    <div class="table-responsive table-scroll">
                        <table id="doctor-table" class="table table-hover text-center custom-table datatable">
                            <thead class="bg-primary ">
                                <tr>
                                    <th>Doctor Name</th>
                                    <th>{{ $ipd_conversation[0]->month ?? 'N/A' }}</th>
                                    <th>{{ $ipd_conversation[1]->month ?? 'N/A' }}</th>
                                    <th>{{ $ipd_conversation[2]->month ?? 'N/A' }}</th>
                                </tr>
                            </thead>
                            <tbody>
                                @foreach ($doctor_dt ?? [] as $value)
                                <tr>
                                    <td class="d-flex align-items-center">
                                        <img src="{{ asset('images/no-photo.png') }}" class="doctor-img" style="width: 35px;height:35px">
                                        <span class="ml-3">{{ $value->doctor_name }}</span>
                                    </td>
                                    <td>{{ $value->current_month }}</td>
                                    <td>{{ $value->pre_month }}</td>
                                    <td>{{ $value->last_month }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        <!-- Bed Occupancy -->
        <div class="col-md-6">
            <div class="card" >
                <div class="card-header bg-primary">
                    <h5>Bed occupancy</h5>
                </div>

                <div class="card-body p-0">
                    <div class="total-bed">
                        <div class="bed-icon">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div class="bed-details">
                            <h3>TOTAL BED</h3>
                            <span>{{ $total_bed_count[0]->no_of_bed }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="total-bed">
                        <div class="bed-icon bg-green">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div class="bed-details green-txt">
                            <h3>BEd occupied</h3>
                            <span>{{ $occupied_bed_count[0]->no_of_bed }}</span>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    <div class="total-bed">
                        <div class="bed-icon bg--blue">
                            <i class="fas fa-bed"></i>
                        </div>
                        <div class="bed-details blue--txt">
                            <h3>BEd occupied Ratio</h3>

                            <ul class="month_wise">
                                <li>
                                    <h5>{{ isset($ipd_bed_ocupancy[0]) ? ucfirst($ipd_bed_ocupancy[0]->month) : '' }}
                                    </h5>
                                    <h6>{{ isset($ipd_bed_ocupancy[0]) ? $ipd_bed_ocupancy[0]->no_of_bed : '' }}</h6>
                                </li>
                                <li>
                                    <h5>{{ isset($ipd_bed_ocupancy[1]) ? ucfirst($ipd_bed_ocupancy[1]->month) : '' }}
                                    </h5>
                                    <h6>{{ isset($ipd_bed_ocupancy[1]) ? $ipd_bed_ocupancy[1]->no_of_bed : '' }}</h6>
                                </li>
                                <li>
                                    <h5>{{ isset($ipd_bed_ocupancy[2]) ? ucfirst($ipd_bed_ocupancy[2]->month) : '' }}
                                    </h5>
                                    <h6>{{ isset($ipd_bed_ocupancy[2]) ? $ipd_bed_ocupancy[2]->no_of_bed : '' }}</h6>
                                </li>

                            </ul>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</div>




{{-- <script type="application/javascript" src="{{ asset('dashboard/vendors/chart.js/dist/Chart.min.js') }}"></script> --}}
<!--INTERNAL Flot Charts js-->
<script src="{{ asset('dashboardv2_assets/plugins/flot/jquery.flot.js') }}"></script>
<script src="{{ asset('dashboardv2_assets/plugins/flot/jquery.flot.fillbetween.js') }}"></script>
<script src="{{ asset('dashboardv2_assets/plugins/flot/jquery.flot.pie.js') }}"></script>
{{-- <script src="{{ asset('dashboardv2_assets/js/flot.js') }}"></script> --}}

<!-- INTERNAL c3.js Charts js-->
<script src="{{ asset('dashboardv2_assets/plugins/charts-c3/d3.v5.min.js') }}"></script>
<script src="{{ asset('dashboardv2_assets/plugins/charts-c3/c3-chart.js') }}"></script>
<script src="{{ asset('dashboardv2_assets/js/charts.js') }}"></script>



<!-- Animate js-->
<script src="{{ asset('dashboardv2_assets/WOW-master/dist/wow.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>

<script>
    // SideBar Collapse
    $("body").addClass("sidebar-collapse");
    $("#sidebar-left").addClass("active");
    $("#content").addClass("active");



    $('.datatable2').DataTable({
        "lengthMenu": [
            [3],
            [3]
        ],
    });

    /*month-wise-conversion*/
    //     setTimeout(function() {
    //     if (chart) {
    //         chart.unload();
    //     }

    //     chart = c3.generate({
    //         bindto: '#month-wise-conversion',
    //         size: {
    //             height: 510,
    //             width: 1000
    //         },
    //         data: {
    //             columns: [
    //                 ['data1', @json($opdc_cons)],
    //                 ['data2', @json($ipdc_cons)],
    //                 ['data3', @json($emergency_cons)],
    //                 ['data4', @json($adm_cons)],
    //             ],
    //             labels: true,
    //             type: 'bar',
    //             bar: {
    //                 width: {
    //                     ratio: 0.5
    //                 }
    //             },
    //             names: {
    //                 'data1': 'OPDC',
    //                 'data2': 'IPDC',
    //                 'data3': 'Emergency',
    //                 'data4': 'Admission',
    //             }
    //         },
    //         axis: {
    //             x: {
    //                 type: 'category',
    //                 categories: @json([$opdc_month1, $opdc_month2, $opdc_month3])
    //             }
    //         },
    //         legend: {
    //             show: true
    //         },
    //         tooltip: {
    //             grouped: false
    //         },
    //         zoom: {
    //             enabled: true
    //         },
    //         padding: {
    //             bottom: 0,
    //             top: 0
    //         }
    //     });
    // }, 2000);



    // patient-count-patient-type
    var chart = c3.generate({
        bindto: '#location-wise-patient',
        data: {
            columns: [
                ['Location', {{ $loc }}]
            ],
            type: 'bar'
        },
        bar: {
            width: {
                ratio: 0.5 // this makes bar width 50% of length between ticks
            }
            // or
            //width: 100 // this makes bar width 100px
        },
        axis: {
            x: {
                type: 'category',
                // name of each category
                categories: ['ASHULIYA',
                    'BAMNARTAK',
                    'DHOUR',
                    'DIYA BARI',
                    'KAMARPARA',
                    'MUDAFA',
                    'NOYANAGAR',
                    'Others',
                    'RAJABARI',
                    'TONGI',
                ]
            },
        },
        names: {

            'Location': 'Location'
        },
        legend: {
            show: true, //hide legend
        },
        padding: {
            bottom: 0,
            top: 0
        }
    });


    // patient-count-patient-type
    var chart = c3.generate({
        bindto: '#phr-type-data',
        data: {
            columns: [
                ['OPD Pharmacy', {{ $phr }}],
                ['IPD Pharmacy', {{ $phr_i }}],
                ['Emergency Pharmacy', {{ $phr_e }}],
                ['Daycare Pharmacy', {{ $phr_d }}],
                ['OT Pharmacy', {{ $phr_dy }}],
            ],
            type: 'bar'
        },
        bar: {
            width: {
                ratio: 0.5 // this makes bar width 50% of length between ticks
            }
            // or
            //width: 100 // this makes bar width 100px
        },
        axis: {
            x: {
                type: 'category',
                // name of each category
                categories: ['{{ $opdc_month1 }}', '{{ $opdc_month2 }}', '{{ $opdc_month3 }}']
            },
        },
        legend: {
            show: true, //hide legend
        },
        padding: {
            bottom: 0,
            top: 0
        }
    });


    // conversion-to-ipd
    var chart = c3.generate({
        bindto: '#conversion-to-ipd',
        data: {
            columns: [
                ['OPD', {{ $opd_lst }}],
                ['Emergency', {{ $emr_lst }}],
                ['General', {{ $others_lst }}],
            ],
            type: 'donut',
            onclick: function(d, i) {
                console.log("onclick", d, i);
            },
            onmouseover: function(d, i) {
                console.log("onmouseover", d, i);
            },
            onmouseout: function(d, i) {
                console.log("onmouseout", d, i);
            }
        },
        donut: {
            title: "Conversion to IPD"
        },
        axis: {
            x: {
                type: 'category',
                // name of each category
                categories: ['Last 1 Week', 'Last 2 Week', 'Last 3 Week', 'Last 4 Week',
                    'Last 5 Week', 'Last 6 Week', 'Last 7 Week'
                ]
            },
        },
        legend: {
            show: true, //hide legend
        },
        padding: {
            bottom: 0,
            top: 0
        }
    });
</script>
