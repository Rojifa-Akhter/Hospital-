<style>
    .approved_medicine_table>thead>tr>th {
        font-size: 15px !important;
    }

    .approved_medicine_table>tbody>tr>td {
        font-size: 15px !important;
    }

    .pending_medicine_table>thead>tr>th {
        font-size: 15px !important;
    }

    .pending_medicine_table>tbody>tr>td {
        font-size: 15px !important;
    }

    .position-center {
        /* margin-bottom: -30px  */
    }

    .admission_pres_same_selected {
        background-color: rgb(203, 210, 210) !important;
    }
</style>
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div
                        class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Pharmacy Indent Worklist</h5>
                            <small>IPD / Nurse Station / Pharmacy Indent Worklist </small>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12">

                                    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="received-patient" data-toggle="tab"
                                                href="#pending_medicine" role="tab" aria-controls="pending_medicine"
                                                aria-selected="true" onclick="getPendingMedicine(true)">Pending Medicine
                                                <span class="badge badge-secondary"></span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link " id="receive-request" data-toggle="tab"
                                                href="#approved_medicine" role="tab"
                                                aria-controls="pending_medicine" aria-selected="true"
                                                onclick="getMedcineDelivery(true)">Medicine Delivery<span
                                                    class="badge badge-secondary"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " id="receive-delivery" data-toggle="tab"
                                                href="#delivered_medicine" role="tab"
                                                aria-controls="delivered_medicine" aria-selected="true"
                                                onclick="getMedicineDelivered(true)">Medicine Delivered<span
                                                    class="badge badge-secondary"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " id="receive-return" data-toggle="tab"
                                                href="#medicine_return" role="tab" aria-controls="medicine_return"
                                                aria-selected="true" onclick="getMedcineReturn(true)">Medicine Return
                                                Request<span class="badge badge-secondary"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " id="receive-returned" data-toggle="tab"
                                                href="#medicine_returned" role="tab"
                                                aria-controls="medicine_returned" aria-selected="true"
                                                onclick="getMedcineReturned(true)">Medicine Returned Worklist<span
                                                    class="badge badge-secondary"></span></a>
                                        </li>
                                    </ul>

                                    <div class="tab-content p-0" id="myTabContent">
                                        <!-- Pending Medicine -->
                                        <div class="tab-pane fade show active" id="pending_medicine" role="tabpanel"
                                            aria-labelledby="received-patient">

                                            <div class="table-responsive pt-2">
                                                <table
                                                    class="table table-striped table-bordered table-hover pending_medicine_table">
                                                    <thead class="global-uhl-table-bg">
                                                        <tr>
                                                            <th class="text-center" style="width:3%">#SL</th>
                                                            <th class="text-left" style="width:6%">Indent No</th>
                                                            <th class="text-left" style="width:20%">Patient Name</th>
                                                            <th class="text-center" style="width:5%">UHID</th>
                                                            <th class="text-center" style="width:8%">IP Date</th>
                                                            <th class="text-center" style="width:6%">IP No</th>
                                                            <th class="text-left" style="width:15%">Bed Category</th>
                                                            <th class="text-center" style="width:8%">Bed No</th>
                                                            <th class="text-left" style="width:17%">Consultant</th>
                                                            <th class="text-center" style="width:8%">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td colspan="10" class="text-center">Data Fetching ...
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                        <div class="tab-pane fade " id="approved_medicine" role="tabpanel"
                                            aria-labelledby="receive-request">

                                            <div class="table-responsive pt-2">
                                                <table
                                                    class="table table-striped table-bordered table-hover delivery_medicine_table">
                                                    <thead class="global-uhl-table-bg">
                                                        <tr>
                                                            <th class="text-center" style="width:3%">#SL</th>
                                                            <th class="text-left" style="width:6%">Indent No</th>
                                                            <th class="text-left" style="width:20%">Patient Name</th>
                                                            <th class="text-center" style="width:5%">UHID</th>
                                                            <th class="text-center" style="width:7%">IP Date</th>
                                                            <th class="text-center" style="width:6%">IP No</th>
                                                            <th class="text-left" style="width:15%">Bed Category</th>
                                                            <th class="text-center" style="width:8%">Bed No</th>
                                                            <th class="text-left" style="width:17%">Consultant</th>
                                                            <th class="text-center" style="width:8%">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td colspan="10" class="text-center">Data Fetching ...
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>

                                        {{-- Delivered medicine --}}
                                        <div class="tab-pane fade " id="delivered_medicine" role="tabpanel"
                                            aria-labelledby="receive-delivery">

                                            <div class="table-responsive pt-2">
                                                <table
                                                    class="table table-striped table-bordered table-hover delivery_medicine_table">
                                                    <thead class="global-uhl-table-bg">
                                                        <tr>
                                                            <th class="text-center" style="width:3%">#SL</th>
                                                            <th class="text-left" style="width:6%">Indent No</th>
                                                            <th class="text-left" style="width:20%">Patient Name</th>
                                                            <th class="text-center" style="width:5%">UHID</th>
                                                            <th class="text-center" style="width:7%">IP Date</th>
                                                            <th class="text-center" style="width:6%">IP No</th>
                                                            <th class="text-left" style="width:15%">Bed Category</th>
                                                            <th class="text-center" style="width:8%">Bed No</th>
                                                            <th class="text-left" style="width:17%">Consultant</th>
                                                            <th class="text-center" style="width:8%">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td colspan="10" class="text-center">Data Fetching ...
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>

                                        </div>


                                        <!-- Medicine Return -->
                                        <div class="tab-pane fade " id="medicine_return" role="tabpanel"
                                            aria-labelledby="medicine-return">
                                            <div class="table-responsive pt-2">
                                                <table
                                                    class="table table-striped table-bordered table-hover return_medicine_table">
                                                    <thead class="global-uhl-table-bg">
                                                        <tr>
                                                            <th class="text-center" style="width:3%">#SL</th>
                                                            <th class="text-left" style="width:22%">Patient Name</th>
                                                            <th class="text-center" style="width:5%">UHID</th>
                                                            <th class="text-center" style="width:7%">IP Date</th>
                                                            <th class="text-center" style="width:6%">IP No</th>
                                                            <th class="text-left" style="width:17%">Bed Category</th>
                                                            <th class="text-center" style="width:10%">Bed No</th>
                                                            <th class="text-left" style="width:20%">Consultant</th>
                                                            <th class="text-center" style="width:5%">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td colspan="9" class="text-center">Data Fetching ...
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Medicine Returned -->
                                        <div class="tab-pane fade " id="medicine_returned" role="tabpanel"
                                            aria-labelledby="medicine-returned">
                                            <div class="table-responsive pt-2">
                                                <table
                                                    class="table table-striped table-bordered table-hover returned_medicine_table">
                                                    <thead class="global-uhl-table-bg">
                                                        <tr>
                                                            <th class="text-center" style="width:3%">#SL</th>
                                                            <th class="text-left" style="width:22%">Patient Name</th>
                                                            <th class="text-center" style="width:5%">UHID</th>
                                                            <th class="text-center" style="width:7%">IP Date</th>
                                                            <th class="text-center" style="width:6%">IP No</th>
                                                            <th class="text-left" style="width:17%">Bed Category</th>
                                                            <th class="text-center" style="width:10%">Bed No</th>
                                                            <th class="text-left" style="width:20%">Consultant</th>
                                                            <th class="text-center" style="width:5%">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td colspan="9" class="text-center">Data Fetching ...
                                                            </td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

        </div>
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    $(document).ready(function() {
        getPendingMedicine();
    })
</script>

<script>
    $.ajaxSetup({
        headers: {
            'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
        }
    });

    function getPendingMedicine(search = null) {
        $.ajax({
            url: "{{ route('v2.ipd.get-medicine-indent-from-pharmacy') }}",
            method: "post",
            data: {
                medicine_approval: 1
            },
            beforeSend: function() {
                if (search != null) {
                    blockUI();
                }
            },
            success: function(response) {
                $.unblockUI();
                if (response.data.length != 0) {
                    setPendingMedicine(response.data);
                } else {
                    emptyTable();
                }
            },
            error: function(err) {
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        })
    }


    function setPendingMedicine(data) {
        $('.pending_medicine_table tbody').empty();

        var rows = [];
        if ($.fn.DataTable.isDataTable('.pending_medicine_table')) {
            $('.pending_medicine_table').DataTable().destroy();
        }

        var table = $('.pending_medicine_table').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 1, 3, 4, 5, 7],
                    className: 'text-center'
                },
                {
                    targets: [2, 6],
                    className: 'text-left'
                }
            ],
            "lengthMenu": [
                [15, 25, 50, 75, 100, -1],
                [15, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 15
        });

        var button_group = ``;
        data.forEach(function(item, index) {
            var admission_date = '';
            var pres_date = '';

            if (item.admission_date != '') {
                var date = new Date(item.admission_date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                admission_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }

            button_group = `<a style="cursor:pointer" class="open-modal btn btn-sm btn-info text-white mr-1"
                                        data-action="{{ route('v2.ipd.get-prescription-wise-pending-medicine-pharmacy', '') }}/${item.med_req_id}"
                                        data-id="${item.med_req_id}" data-modal="common-modal-sm"
                                        data-title="Medicine Details" title="Medicine Details">
                                        <i class="fa fa-eye"></i>
                                    </a>`;

            button_group += `<a class="btn btn-sm btn-primary" style="cursor:pointer" href="{{ route('v2.billing.pharmacy-indent-bill-generate', ['', '']) }}/${item.med_req_id}" title="Bill Generate">
                                        <i class="fa fa-money-bill"></i>
                                </a>`;

            var admission_pres_same = '';
            var today = moment().format('DD/MM/YYYY');
            if (admission_date == pres_date == today) {
                admission_pres_same = 'admission_pres_same';
            }
            var rowData = [
                `<span class="${admission_pres_same}">${++index}</span>`,
                item.med_req_id,
                item.patient_name,
                item.uhid,
                admission_date,
                item.admission_no_pk,
                item.ward_name,
                item.bed_name,
                item.doctor_name,
                button_group,
            ];
            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw();

        $(".admission_pres_same").parent().parent().addClass('admission_pres_same_selected');
    }

    function getApprovedMedcine() {

    }

    function emptyTable() {
        $('.pending_medicine_table tbody').empty();
        $('.pending_medicine_table tbody').append(`
                <tr>
                    <td colspan="10" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
    }

    function emptyTableMedicineDelivery() {
        $('.delivery_medicine_table tbody').empty();
        $('.delivery_medicine_table tbody').append(`
                <tr>
                    <td colspan="10" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
    }

    // Medicine Delivery
    function getMedcineDelivery(search = null) {

        $.ajax({
            url: "{{ route('v2.ipd.get-medicine-indent-delivery') }}",
            method: "post",
            data: {
                delivered: 0
            },
            beforeSend: function() {
                if (search != null) {
                    blockUI();
                }
            },
            success: function(response) {
                $.unblockUI();
                if (response.data.length != 0) {
                    setMedicineDelivery(response.data);
                } else {
                    emptyTableMedicineDelivery();
                }
            },
            error: function(err) {
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        })
    }


    function setMedicineDelivery(data) {
        $('.delivery_medicine_table tbody').empty();

        var rows = [];
        if ($.fn.DataTable.isDataTable('.delivery_medicine_table')) {
            $('.delivery_medicine_table').DataTable().destroy();
        }

        var table = $('.delivery_medicine_table').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 1, 3, 4, 5, 7],
                    className: 'text-center'
                },
                {
                    targets: [2, 6],
                    className: 'text-left'
                }
            ],
            "lengthMenu": [
                [15, 25, 50, 75, 100, -1],
                [15, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 15
        });

        var button_group = ``;
        data.forEach(function(item, index) {
            var admission_date = '';
            var pres_date = '';

            if (item.admission_date != '') {
                var date = new Date(item.admission_date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                admission_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }

            if (item.prescription_date != '') {
                var date = new Date(item.admission_date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                pres_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }

            var dose_url = "{{ route('dose-print-ipd', [':invoice', ':prescription_id']) }}";
            dose_url = dose_url.replace(':invoice', item.invoice_no_fk);
            dose_url = dose_url.replace(':prescription_id', item.med_req_id);

            button_group = `<a style="cursor:pointer" class="open-modal btn btn-sm btn-info text-white mr-1"
                                        data-action="{{ route('v2.ipd.get-prescription-wise-pending-medicine-delivered', '') }}/${item.med_req_id}"
                                        data-id="${item.invoice_no_fk}" data-modal="common-modal-sm"
                                        data-title="Medicine Details" title="Medicine Details">
                                        <i class="fa fa-eye"></i>
                                    </a>`;

            button_group += `<a class="btn btn-sm btn-primary text-white" style="cursor:pointer" onclick="deliveryMedicine('${item.med_req_id}', '${item.invoice_no_fk}')" data-invoice="${item.invoice_no_fk}" title="Click to Delivery">
                                        <i class="fa fa-paper-plane text-white"></i>
                                </a>`;
            button_group +=
                `<a href="${dose_url}" target="_blank" class="btn btn-sm btn-warning mx-1" title="dose"><i class="fas fa-pills"></i></a>`;


            if (item.invoice_no_fk && item.ledgertrn_no_fk) {
                button_group += ` <a class="btn btn-sm btn-primary text-white" style="cursor:pointer" href="{{ url('bill-invoice-pos-print-v2/${item.invoice_no_fk}/pos/${item.ledgertrn_no_fk}') }}" target="_blank" title="Invoice">
                                        <i class="fa fa-file text-white"></i>
                                    </a>`;
            }

            var admission_pres_same = '';
            var today = moment().format('DD/MM/YYYY');
            if (admission_date == pres_date == today) {
                admission_pres_same = 'admission_pres_same';
            }

            var rowData = [
                `<span class="${admission_pres_same}">${++index}</span>`,
                item.med_req_id,
                item.patient_name,
                item.uhid,
                admission_date,
                item.admission_no_pk,
                item.ward_name,
                item.bed_name,
                item.doctor_name,
                button_group,
            ];
            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw();

        $(".admission_pres_same").parent().parent().addClass('admission_pres_same_selected');
    }


    function deliveryMedicine(id, invoice_no_fk) {
        $.ajax({
            url: "{{ route('v2.ipd.medicine-delivery') }}",
            method: "post",
            data: {
                id: id,
                invoice_no_fk: invoice_no_fk
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                getMedcineDelivery();
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-title').html('Success');
                $('.common-modal-notify .modal-body').html(response.message);
            },
            error: function(err) {
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        })
    }


    function padZero(number) {
        return number < 10 ? "0" + number : number;
    }

    // Medicine Delivered
    function getMedicineDelivered(search = null) {

        $.ajax({
            url: "{{ route('v2.ipd.get-medicine-indent-delivered') }}",
            method: "post",
            data: {
                delivered: 1
            },
            beforeSend: function() {
                if (search != null) {
                    blockUI();
                }
            },
            success: function(response) {
                $.unblockUI();
                if (response.data.length != 0) {
                    setMedicineDelivered(response.data);
                } else {
                    emptyTableMedicineDelivery();
                }
            },
            error: function(err) {
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        })
    }

    function setMedicineDelivered(data) {
        $('.delivery_medicine_table tbody').empty();

        var rows = [];
        if ($.fn.DataTable.isDataTable('.delivery_medicine_table')) {
            $('.delivery_medicine_table').DataTable().destroy();
        }

        var table = $('.delivery_medicine_table').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 1, 3, 4, 5, 7],
                    className: 'text-center'
                },
                {
                    targets: [2, 6],
                    className: 'text-left'
                }
            ],
            "lengthMenu": [
                [15, 25, 50, 75, 100, -1],
                [15, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 15
        });

        var button_group = ``;
        data.forEach(function(item, index) {
            var admission_date = '';
            var pres_date = '';

            if (item.admission_date != '') {
                var date = new Date(item.admission_date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                admission_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }

            if (item.prescription_date != '') {
                var date = new Date(item.admission_date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                pres_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }

            button_group = `<a style="cursor:pointer" class="open-modal btn btn-sm btn-info text-white mr-1"
                                        data-action="{{ route('v2.ipd.get-prescription-wise-pending-medicine-delivered-complated', '') }}/${item.med_req_id}"
                                        data-id="${item.invoice_no_fk}" data-modal="common-modal-sm"
                                        data-title="Medicine Details" title="Medicine Details">
                                        <i class="fa fa-eye"></i>
                                    </a>`;


            if (item.invoice_no_fk && item.ledgertrn_no_fk) {
                button_group += ` <a class="btn btn-sm btn-primary text-white" style="cursor:pointer" href="{{ url('bill-invoice-pos-print-v2/${item.invoice_no_fk}/pos/${item.ledgertrn_no_fk}') }}" target="_blank" title="Invoice">
                                        <i class="fa fa-file text-white"></i>
                                    </a>`;
            }

            var admission_pres_same = '';
            var today = moment().format('DD/MM/YYYY');
            if (admission_date == pres_date == today) {
                admission_pres_same = 'admission_pres_same';
            }

            var rowData = [
                `<span class="${admission_pres_same}">${++index}</span>`,
                item.med_req_id,
                item.patient_name,
                item.uhid,
                admission_date,
                item.admission_no_pk,
                item.ward_name,
                item.bed_name,
                item.doctor_name,
                button_group,
            ];
            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw();

        $(".admission_pres_same").parent().parent().addClass('admission_pres_same_selected');
    }
    // Medicine Return Request

    function getMedcineReturn(search = null) {

        $.ajax({
            url: "{{ route('v2.ipd.return-medicine-from-pharmacy') }}",
            method: "post",
            data: {},
            beforeSend: function() {
                if (search != null) {
                    blockUI();
                }
            },
            success: function(response) {
                $.unblockUI();
                if (response.data.length != 0) {
                    setMedicineReturn(response.data);
                } else {
                    emptyMedicineReturnTable();
                }
            },
            error: function(err) {
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        })
    }

    function setMedicineReturn(data) {
        $('.return_medicine_table tbody').empty();

        var rows = [];
        if ($.fn.DataTable.isDataTable('.return_medicine_table')) {
            $('.return_medicine_table').DataTable().destroy();
        }

        var table = $('.return_medicine_table').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 2, 3, 4, 6, 8],
                    className: 'text-center'
                },
                {
                    targets: [1, 5, 7],
                    className: 'text-left'
                }
            ],
            "lengthMenu": [
                [15, 25, 50, 75, 100, -1],
                [15, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 15
        });

        var button_group = ``;
        var admission_date = ``;
        data.forEach(function(item, index) {

            if (item.admission_date != '') {
                var date = new Date(item.admission_date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                admission_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }

            button_group = `<a style="cursor:pointer" class="open-modal btn btn-sm btn-info text-white mr-1"
                                        data-action="{{ route('v2.ipd.get-patient-wise-medicine-return-request', ['', '']) }}/${item.patient_no_fk}/${item.admission_no_pk}"
                                        data-id="${item.admission_no_pk}" data-modal="common-modal-sm"
                                        data-title="Medicine Details" title="Medicine Details">
                                        <i class="fa fa-eye"></i>
                                    </a>
                                                                      
                                   `;
            var rowData = [
                `${++index}`,
                item.patient_name,
                item.patient_code,
                admission_date,
                item.admission_no_pk,
                item.ward_name,
                item.bed_name,
                item.primary_doctor_name,
                button_group

            ];
            rows.push(rowData);

        });
        table.clear();
        table.rows.add(rows);
        table.draw();


    }

    function emptyMedicineReturnTable() {
        $('.return_medicine_table tbody').empty();
        $('.return_medicine_table tbody').append(`
                    <tr>
                        <td colspan="9" class="text-danger text-center">Data Not Found</td>
                    </tr>
                `);
    }



    // Returned Medicine

    function getMedcineReturned(search = null) {

        $.ajax({
            url: "{{ route('v2.ipd.returned-medicine-from-pharmacy') }}",
            method: "post",
            data: {},
            beforeSend: function() {
                if (search != null) {
                    blockUI();
                }
            },
            success: function(response) {
                $.unblockUI();
                if (response.data.length != 0) {
                    setMedicineReturned(response.data);
                } else {
                    emptyMedicineReturnedTable();
                }
            },
            error: function(err) {
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        })
    }

    function setMedicineReturned(data) {
        $('.returned_medicine_table tbody').empty();

        var rows = [];
        if ($.fn.DataTable.isDataTable('.returned_medicine_table')) {
            $('.returned_medicine_table').DataTable().destroy();
        }

        var table = $('.returned_medicine_table').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 2, 3, 4, 6, 8],
                    className: 'text-center'
                },
                {
                    targets: [1, 5, 7],
                    className: 'text-left'
                }
            ],
            "lengthMenu": [
                [15, 25, 50, 75, 100, -1],
                [15, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 15
        });

        var button_group = ``;
        data.forEach(function(item, index) {



            if (item.admission_date != '') {
                var date = new Date(item.admission_date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                admission_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }

            button_group = `<a style="cursor:pointer" class="open-modal btn btn-sm btn-info text-white mr-1"
                                    data-action="{{ route('v2.ipd.get-patient-wise-medicine-returned-list', ['', '']) }}/${item.patient_no_fk}/${item.admission_no_pk}"
                                    data-id="${item.admission_no_pk}" data-modal="common-modal-md"
                                    data-title="Medicine Details" title="Medicine Details">
                                    <i class="fa fa-eye"></i>
                                </a>`;
            var rowData = [
                `${++index}`,
                item.patient_name,
                item.patient_code,
                admission_date,
                item.admission_no_pk,
                item.ward_name,
                item.bed_name,
                item.primary_doctor_name,
                button_group
            ];
            rows.push(rowData);

        });
        table.clear();
        table.rows.add(rows);
        table.draw();
    }

    function emptyMedicineReturnedTable() {
        $('.returned_medicine_table tbody').empty();
        $('.returned_medicine_table tbody').append(`
                <tr>
                    <td colspan="10" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
    }
</script>
