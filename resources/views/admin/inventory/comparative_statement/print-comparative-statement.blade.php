<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/buttons.dataTables.min.css') }}">
<style type="text/css">
    table {
        border-spacing: 0;
    }

    .table th {
        vertical-align: middle;
        font-size: 16px;
    }

    .table td {
        vertical-align: middle;

    }

    .print_cs th {
        font-size: 14px !important;
        font-weight: 900 !important;
    }

    .rec_td {
        font-size: 14 !important;
    }

    /* td,
    th {
        border: 1px solid black;
    } */
</style>

<main style="margin-top: 10px;">
    <h3 style="text-align: center;">{{ Session::get('user.hospital_name') }} <br> Comparative Statement of
        {{ $comparative_statement[0]->item_name }}</h3>
    <div style="display: flex; justify-content: space-between;">
        <p style="font-weight: 900;">Dept: </p>
        <p style="font-weight: 900;">Date: {{ date('d.m.Y', strtotime($comparative_statement[0]->au_entry_at)) }}</p>
    </div>
    <table class="table table-bordered table-hover print_cs" cellpadding="0"
        style="margin: 0 auto; border: 1px solid #333; padding: 0px; width: 100%;">
        <thead class="global-uhl-table-bg" cellpadding="0" cellspacing=""0">
            <tr>
                <th class="text-center" style="background-color: cornsilk; border-bottom: 1px solid #333;">SL</th>
                <th class="text-center " style="background-color: cornsilk; border-bottom: 1px solid #333;">Req. No.
                </th>
                <th class="text-center" style="background-color: cornsilk; border-bottom: 1px solid #333;">Product</th>
                <th class="text-center" style="background-color: cornsilk; border-bottom: 1px solid #333;">
                    <table style="width: 50%;">
                        <thead>
                            <tr>
                                <th style="font-weight: 900; padding: 4px; text-align:left;">Vendor</th>
                                <th style="font-weight: 900; padding: 4px; text-align:left;">QTY.</th>
                                <th style="font-weight: 900; padding: 4px; text-align:left;">UOM</th>
                                <th style="font-weight: 900; padding: 4px; text-align:left; width: 200px;">Product
                                    Description</th>
                                <th style="font-weight: 900; padding: 4px; text-align:left;">Amount</th>
                                {{-- <th style="font-weight: 900; padding: 4px; text-align:left;"></th> --}}
                            </tr>
                        </thead>
                    </table>
                </th>

            </tr>
        </thead>
        <tbody id="comparative_list">
            @foreach ($comparative_statement as $comparative)
                <tr>
                    <th class="text-center ">{{ $loop->iteration }}</th>
                    <th class="text-center ">{{ $comparative->requisition_no_fk }}</th>
                    <th class="text-center" style="padding: 10px !important;">
                        {{ $comparative->item_name }}</th>
                    <th class="text-center">
                        @if (isset($comparative->cs_vendor_item_list))
                            <table style="width: 100%;">
                                <tbody>
                                    @foreach (json_decode($comparative->cs_vendor_item_list) as $vendor_details)
                                        <tr
                                            @if (isset($vendor_details->status) && $vendor_details->status == 1) style="background-color: rgb(44, 236, 101);" @endif>
                                            <td style="padding: 4px; border-bottom: 1px solid #333; border-left: 1px solid #333; word-wrap: break-word;"
                                                class="rec_td">{{ $vendor_details->supplier_name }}</td>
                                            <td style="padding: 4px; border-bottom: 1px solid #333;" class="rec_td">
                                                {{ $vendor_details->prd_qty }}</td>
                                            <td style="padding: 4px; border-bottom: 1px solid #333;" class="rec_td">
                                                {{ $vendor_details->prd_uom }}</td>
                                            <td style="padding: 4px; border-bottom: 1px solid #333; width: 200px;"
                                                class="rec_td">{{ $vendor_details->prd_description }}</td>
                                            <td style="padding: 4px; border-bottom: 1px solid #333;" class="rec_td">
                                                {{ $vendor_details->prd_amount }}</td>
                                            <td
                                                style="padding: 10px !important; border-bottom: 1px solid #333; border-right: 1px solid #333;">
                                                @if (isset($comparative->cs_vendor_services))
                                                    <table style="width: 100%;">
                                                        <thead>

                                                            <tr>
                                                                <th
                                                                    style="padding: 4px; font-weight: 900; text-align:center; border: 1px solid #333;">
                                                                    Service Name</th>
                                                                <th
                                                                    style="padding: 4px; font-weight: 900; text-align:center; border: 1px solid #333;">
                                                                    QTY.</th>
                                                                <th
                                                                    style="padding: 4px; font-weight: 900; text-align:center; border: 1px solid #333;">
                                                                    UOM</th>
                                                                <th
                                                                    style="padding: 4px; font-weight: 900; text-align:center; border: 1px solid #333;">
                                                                    Time / Duration</th>

                                                            </tr>
                                                        </thead>
                                                        <tbody>
                                                            @foreach (collect(json_decode($comparative->cs_vendor_services))->where('supplier_name', $vendor_details->supplier_name)->where('req_no', $comparative->requisition_no_fk) as $vendor_service)
                                                                <tr>
                                                                    <td style="padding: 4px; text-align: left; border: 1px solid #333;"
                                                                        class="rec_td">
                                                                        {{ $vendor_service->supplier_service }}</td>
                                                                    <td style="padding: 4px; text-align: center; border: 1px solid #333;"
                                                                        class="rec_td">
                                                                        {{ $vendor_service->service_qty }}</td>
                                                                    <td style="padding: 4px; text-align: center; border: 1px solid #333;"
                                                                        class="rec_td">
                                                                        {{ $vendor_service->service_uom }}</td>
                                                                    <td style="padding: 4px; text-align: center; border: 1px solid #333;"
                                                                        class="rec_td">
                                                                        {{ $vendor_service->service_amount }}</td>
                                                                </tr>
                                                            @endforeach
                                                        </tbody>
                                                    </table>
                                                @endif
                                            </td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                        @endif
                    </th>
                </tr>
            @endforeach
        </tbody>
    </table>
    <div style="display: flex; justify-content: space-between; width: 100%; margin-top: 50px;">
        <div>
            <h4 style="border-top: 1px solid #333;">Prepared By</h4>
        </div>
        <div>
            <h4 style="border-top: 1px solid #333;">Checked By</h4>
        </div>
        <div>
            <h4 style="border-top: 1px solid #333;">Approved By</h4>
        </div>

    </div>
</main>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/dataTables.buttons.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/buttons.colVis.min.js') }}"></script>
