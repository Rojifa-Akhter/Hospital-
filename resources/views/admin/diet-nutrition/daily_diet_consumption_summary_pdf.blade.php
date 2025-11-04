<style>
    @page {
        margin: 1.5cm;
        padding: 0;
    }

    body {
        font-family: 'IBM Plex Sans', Helvetica, Arial, sans-serif;
        font-size: 9px;
        margin: 0;
    }

    .header {
        position: fixed;
        left: 0;
        top: -120px;
        right: 0;
        text-align: center;
        font-size: 14px;
        font-weight: bold;
    }

    footer {
        position: fixed;
        bottom: 10px;
        left: 0;
        right: 0;
        text-align: center;
        font-size: 9px;
        border-top: 1px solid #222;
        padding-top: 5px;
    }

    .hospital-address {
        text-align: center;
        margin-bottom: 10px;
    }

    .hospital-address h1 {
        margin: 0;
        font-size: 18px;
    }

    .hospital-address p {
        margin: 0;
        font-size: 12px;
    }

    .title {
        text-align: center;
        font-size: 14px;
        padding: 5px;
        margin-bottom: 15px;
        background-color: #f7f7f7;
        border: 1px solid #ddd;
        font-weight: bold;
    }

    .form-body {
        margin-top: 20px;
    }

    .heading {
        text-align: center;
        margin-bottom: 20px;
    }

    table {
        width: 100%;
        border-collapse: collapse;
        margin-top: 15px;
    }

    table th, table td {
        padding: 8px;
        border: 1px solid #ddd;
        text-align: center;
        font-size: 9px;
    }

    table th {
        background-color: #f2f2f2;
    }

    .table-responsive {
        max-height: 400px;
        overflow-y: auto;
    }

    .signature {
        width: 100%;
        margin-top: 40px;
        display: flex;
        justify-content: space-between;
    }

    .signature div {
        width: 45%;
        border-top: 1px solid #000;
        text-align: center;
        padding-top: 10px;
    }

    .signature div span {
        font-size: 9px;
    }

    footer {
        position: fixed;
        bottom: 5px;
        width: 100%;
        text-align: center;
        font-size: 9px;
    }

    footer span {
        display: block;
    }
</style>

<div class="container-fluid">
    <div class="form-row justify-content-center">
        <div class="col-md-9">
            <div class="card border-0 shadow-sm">
                <div class="card-body p-4">
                    <div class="form-content">
                        <div class="header">
                            <div class="hospital-address">
                                <h1>{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}</h1>
                                <p>{{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</p>
                                <p>{{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</p>
                            </div>
                        </div>

                        <div class="form-body">
                            <div class="heading">
                                <h2>Daily Consumption Summary Report</h2>
                                <p>From: {{ $date_from }} - To: {{ $date_to }}</p>
                            </div>

                            <div class="table-responsive">
                                <table class="table table-bordered">
                                    <thead>
                                        <tr>
                                            <th>SL</th>
                                            <th>Food Name</th>
                                            <th>Quantity</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @if (isset($items))
                                            @foreach ($items as $index => $item)
                                                <tr>
                                                    <td>{{ $loop->iteration }}</td>
                                                    <td class="text-left">{{ $item->food_name }}</td>
                                                    <td>{{ $item->total_quantity }}</td>
                                                </tr>
                                            @endforeach
                                        @endif
                                    </tbody>
                                </table>
                            </div>
                        </div>

                        {{-- <div class="signature">
                            <div>
                                <span>Prepared By: {{ @$userInfo->user_fullname }}</span>
                            </div>
                            <div>
                                <span>Printing Date & Time: {{ date('d/m/Y') }}</span>
                            </div>
                            <div>
                                <span>Powered By: NEXTGEN IT</span>
                            </div>
                        </div> --}}
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<footer>
    <span>Prepared By: {{ @$userInfo->user_fullname }}</span>
    <span>Printing Date & Time: {{ date('d/m/Y') }}</span>
    <span>Powered By: NEXTGEN IT</span>
</footer>

<script>
    window.print();
    window.onafterprint = function() {
        window.close(); // Close the window after printing
    }
</script>
