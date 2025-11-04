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
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Nursing Requisition</h5>
                            <small>IPD / Nurse Station / Nursing Requisition</small>
                        </div>
                    </div>
                </div>
            </div>


            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">
                            <div class="row">
                                <div class="col-12 pb-4 text-center">
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Patient Name: {{ @$patient_info->patient_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">UHID: {{ @$patient_info->patient_code }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">IP No: {{ @$patient_info->admission_uid }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Date: {{ date('d/m/Y', strtotime($patient_info->admission_date)) }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Admission Department: {{ $patient_info->admitted_department }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed Category: {{ $patient_info->ward_name }}</span>
                                    <span class="btn btn-outline-primary bg-primary btn-sm mt-2 mr-2">Bed No.: {{ $patient_info->bed_name }}</span>
                                </div>
                                <div class="col-md-12">

                                    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="received-patient" data-toggle="tab" href="#pending_medicine" role="tab" aria-controls="pending_medicine" aria-selected="true" onclick="getPendingMedicine(true)">Pending Indent <span class="badge badge-secondary"></span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link " id="receive-request" data-toggle="tab" href="#approved_medicine" role="tab" aria-controls="approved_medicine" aria-selected="true" onclick="getApprovedMedcine(true)">Completed Indent<span class="badge badge-secondary"></span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link " id="medicine-receive" data-toggle="tab" href="#medicine_receive" role="tab" aria-controls="medicine_receive" aria-selected="true" onclick="getMedcineReceive(true)">Medicine Receive<span class="badge badge-secondary"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " id="medicine-received" data-toggle="tab" href="#medicine_received" role="tab" aria-controls="medicine_received" aria-selected="true" onclick="getMedcineReceived(true)">Medicine Received<span class="badge badge-secondary"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " id="medicine-consumption" data-toggle="tab" href="#medicine_consumption" role="tab" aria-controls="medicine_consumption" aria-selected="true" onclick="getMedcineConsumption(true)">Medicine Consumption<span class="badge badge-secondary"></span></a>
                                        </li>
                                        <li class="nav-item">
                                            <a class="nav-link " id="medicine-return" data-toggle="tab" href="#medicine_return" role="tab" aria-controls="medicine_return" aria-selected="true" onclick="getMedcineReturn(true)">Medicine Return<span class="badge badge-secondary"></span></a>
                                        </li>
                                    </ul>

                                    <div class="tab-content p-0" id="myTabContent">

                                        <!-- Indent Medicine -->
                                        <div class="tab-pane fade show active" id="pending_medicine" role="tabpanel" aria-labelledby="received-patient">
                                            <div class="row justify-content-center">

                                                <div class="col-4 text-center mt-2">
                                                    <button style="cursor:pointer" class="open-modal btn btn-md btn-success w-50 text-white mt-1"
                                                        data-modal="common-modal-xl"
                                                        data-title="Add MSU Item"
                                                        data-action="{{ route('ipd.add-msu-item', [
                                                                        'admission_no_pk' => @$patient_info->admission_no_pk,
                                                                        'patient_no_pk' => @$patient_info->patient_no_pk,
                                                                    ]) }}">
                                                        MSU Item Indent
                                                    </button>
                                                </div>
                                                <div class="col-4 text-center mt-2">
                                                    <button type="button" class="btn btn-md btn-primary w-50" onclick="IndentRequest()">Indent Request</button>
                                                </div>
                                            </div>
                                            <div class="row">
                                                <div class="col-12">
                                                    <form action="{{route('v2.ipd.medicine-indent-request')}}" method="post" id="indentReqForm">
                                                        @csrf
                                                        <div class="table-responsive pt-2">
                                                            <table class="table table-striped table-bordered table-hover pending_medicine_table">
                                                                <thead class="global-uhl-table-bg">
                                                                    <tr>
                                                                        <th class="text-center" style="width:3%">#SL</th>
                                                                        <th class="text-left" style="width:8%">Prescription Id</th>
                                                                        <th class="text-left" style="width:8%">Approve Date</th>
                                                                        <th class="text-left" style="width:13%">Approve By</th>
                                                                        <th class="text-center" style="width:10%">Generic Name</th>
                                                                        <th class="text-center" style="width:12%">Brand Name</th>
                                                                        <th class="text-center" style="width:5%">Dosage</th>
                                                                        <th class="text-center" style="width:5%">Duration</th>
                                                                        <th class="text-left" style="width:9%">Instruction</th>
                                                                        <th class="text-center" style="width:7%">Approved Qty</th>
                                                                        <th class="text-right" style="width:8%">Indented Qty</th>
                                                                        <th class="text-left" style="width:5%">Qty</th>
                                                                        <th class="text-center" style="width:3%">
                                                                            <div style="display: flex;justify-content:center">
                                                                                <div class="mt-1"> <input type="checkbox" name="checked_all" id="checked_all" value="1" class="form-control form-control-sm" onclick="checkedAll()" /></div>
                                                                                <div><label class="form-check-label" for="checked_all">&nbsp;All</label></div>
                                                                            </div>
                                                                        </th>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="13" class="text-center">Data Fetching ...</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </form>
                                                </div>
                                            </div>

                                        </div>

                                        <!-- Completed Medicine -->
                                        <div class="tab-pane fade " id="approved_medicine" role="tabpanel" aria-labelledby="receive-request">

                                            <div class="row">
                                                <div class="col-12">
                                                    <div style="padding-top:10px">
                                                        <div class="table-responsive">
                                                            <table class="table table-striped table-bordered table-hover approved_medicine_table">
                                                                <thead class="global-uhl-table-bg">
                                                                    <tr>
                                                                    <tr>
                                                                        <th class="text-center" style="width:3%">#SL</th>
                                                                        <th class="text-center" style="width:7%">Indent No</th>
                                                                        <th class="text-left" style="width:8%">Prescription Id</th>
                                                                        <th class="text-left" style="width:8%">Approve Date</th>
                                                                        <th class="text-left" style="width:11%">Approve By</th>
                                                                        <th class="text-center" style="width:11%">Generic Name</th>
                                                                        <th class="text-center" style="width:14%">Brand Name</th>
                                                                        <th class="text-center" style="width:8%">Dosage</th>
                                                                        <th class="text-center" style="width:8%">Duration</th>
                                                                        <th class="text-left" style="width:12%">Instruction</th>
                                                                        <th class="text-right" style="width:8%">Indented Qty</th>

                                                                    </tr>
                                                                    </tr>
                                                                </thead>

                                                                <tbody>
                                                                    <tr>
                                                                        <td colspan="11" class="text-center">Data Fetching ...</td>
                                                                    </tr>
                                                                </tbody>
                                                            </table>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>



                                        </div>

                                        <!-- Medicine Receive -->
                                        <div class="tab-pane fade " id="medicine_receive" role="tabpanel" aria-labelledby="medicine-receive">
                                            <div class="table-responsive pt-2">
                                                <table class="table table-striped table-bordered table-hover receive_medicine_table">
                                                    <thead class="global-uhl-table-bg">
                                                        <tr>
                                                            <th class="text-center" style="width:3%">#SL</th>
                                                            <th class="text-left" style="width:6%">Indent No</th>
                                                            <th class="text-left" style="width:20%">Patient Name</th>
                                                            <th class="text-center" style="width:5%">UHID</th>
                                                            <th class="text-center" style="width:7%">Adm. Date</th>
                                                            <th class="text-center" style="width:6%">Adm. Id</th>
                                                            <th class="text-left" style="width:18%">Room Category</th>
                                                            <th class="text-center" style="width:8%">Bed No</th>
                                                            <th class="text-left" style="width:17%">Doctor Name</th>
                                                            <th class="text-center" style="width:8%">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td colspan="10" class="text-center">Data Fetching ...</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>

                                        <!-- Medicine Received -->
                                        <div class="tab-pane fade " id="medicine_received" role="tabpanel" aria-labelledby="medicine-received">
                                            <form action="{{route('v2.ipd.medicine-return-consumption')}}" method="post" id="medicineForm">
                                                @csrf
                                                <input type="hidden" name="consumption_return" id="consumption_return">
                                                <div class="table-responsive pt-2">
                                                    <table class="table table-striped table-bordered table-hover received_medicine_table">
                                                        <thead class="global-uhl-table-bg">
                                                            <tr>
                                                                <th class="text-center" style="width:3%">#SL</th>
                                                                <th class="text-left" style="width:6%">Indent No</th>
                                                                <th class="text-left" style="width:18%">Prescription Id</th>
                                                                <th class="text-left" style="width:16%">Generic Name</th>
                                                                <th class="text-center" style="width:17%">Brand Name</th>
                                                                <th class="text-center" style="width:9%">Dosage</th>
                                                                <th class="text-center" style="width:5%">Duration</th>
                                                                <th class="text-left" style="width:8%">Available Qty</th>
                                                                <th class="text-left" style="width:5%">Qty</th>
                                                                <th class="text-center" style="width:11%">Action</th>
                                                            </tr>
                                                        </thead>

                                                        <tbody>
                                                            <tr>
                                                                <td colspan="10" class="text-center">Data Fetching ...</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </form>
                                        </div>

                                        <!-- Medicine Consumption -->
                                        <div class="tab-pane fade " id="medicine_consumption" role="tabpanel" aria-labelledby="medicine-consumption">
                                            <div class="table-responsive pt-2">
                                                <table class="table table-striped table-bordered table-hover consumption_medicine_table">
                                                    <thead class="global-uhl-table-bg">
                                                        <tr>
                                                            <th class="text-center" style="width:3%">#SL</th>
                                                            <th class="text-left" style="width:6%">Indent No</th>
                                                            <th class="text-left" style="width:18%">Prescription Id</th>
                                                            <th class="text-left" style="width:18%">Generic Name</th>
                                                            <th class="text-center" style="width:20%">Brand Name</th>
                                                            <th class="text-center" style="width:10%">Dosage</th>
                                                            <th class="text-center" style="width:5%">Duration</th>
                                                            <th class="text-left" style="width:13%">Instruction</th>
                                                            <th class="text-right" style="width:5%">Qty</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td colspan="9" class="text-center">Data Fetching ...</td>
                                                        </tr>
                                                    </tbody>
                                                </table>
                                            </div>
                                        </div>


                                        <!-- Medicine Return -->
                                        <div class="tab-pane fade " id="medicine_return" role="tabpanel" aria-labelledby="medicine-return">
                                            <div class="table-responsive pt-2">
                                                <table class="table table-striped table-bordered table-hover return_medicine_table">
                                                    <thead class="global-uhl-table-bg">
                                                        <tr>
                                                            <th class="text-center" style="width:3%">#SL</th>
                                                            <th class="text-left" style="width:6%">Indent No</th>
                                                            <th class="text-left" style="width:14%">Prescription Id</th>
                                                            <th class="text-left" style="width:14%">Generic Name</th>
                                                            <th class="text-center" style="width:13%">Brand Name</th>
                                                            <th class="text-center" style="width:10%">Dosage</th>
                                                            <th class="text-center" style="width:5%">Duration</th>
                                                            <th class="text-left" style="width:13%">Instruction</th>
                                                            <th class="text-right" style="width:5%">Qty</th>
                                                            <th class="text-right" style="width:10%">Return Status</th>
                                                            <th class="text-right" style="width:5%">Action</th>
                                                        </tr>
                                                    </thead>

                                                    <tbody>
                                                        <tr>
                                                            <td colspan="11" class="text-center">Data Fetching ...</td>
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

        let admission_id = '{{@$patient_info->admission_no_pk}}';
        let patient_id = '{{@$patient_info->patient_no_pk}}';
        $.ajax({
            url: "{{route('v2.ipd.get-medicine-indent')}}",
            method: "post",
            data: {
                medicine_indent: 0,
                admission_id: admission_id,
                patient_id: patient_id
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

    function getApprovedMedcine(search = null) {

        let admission_id = '{{@$patient_info->admission_no_pk}}';
        let patient_id = '{{@$patient_info->patient_no_pk}}';
        $.ajax({
            url: "{{route('v2.ipd.get-completed-medicine-indent')}}",
            method: "post",
            data: {
                medicine_indent: 1,
                admission_id: admission_id,
                patient_id: patient_id
            },
            beforeSend: function() {
                if (search != null) {
                    blockUI();
                }
            },
            success: function(response) {
                $.unblockUI();
                if (response.data.length != 0) {
                    setApproved(response.data);
                } else {
                    emptyReceiveTable();
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
            paginate: false,
            columnDefs: [{
                    targets: [0, 1, 2, 6, 7, 11, 12],
                    className: 'text-center'
                },
                {
                    targets: [9, 10],
                    className: 'text-right'
                },
                {
                    targets: [3, 4, 5, 7, 6],
                    className: 'text-left'
                }
            ],
        });

        var button_group = ``;
        data.forEach(function(item, index) {
            var admission_date = '';
            var approve_date = '';

            if (item.approve_date != '') {
                var date = new Date(item.approve_date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                approve_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }

            var admission_pres_same = '';
            var today = moment().format('DD/MM/YYYY');
            if (admission_date == approve_date == today) {
                admission_pres_same = 'admission_pres_same';
            }
            var doses = item.dosage; // e.g., "1+0+1"
            var dosesPerDay = doses.split('+').reduce((sum, val) => sum + Number(val), 0);

            var avaliable_qty = Number(item.item_qty) - Number(item.intended_qty);


            // Calculate how many full days of medicine are available
            var fullDaysAvailable = Math.floor(avaliable_qty / dosesPerDay);

            if (fullDaysAvailable >= 2) {
                avaliable_qty = dosesPerDay * 2; // Limit to 2 days max
            } else if (fullDaysAvailable >= 1) {
                avaliable_qty = dosesPerDay * 1; // Allow 1 full day
            } else {
                avaliable_qty = 1; // Less than 1 day, not allowed
            }
            var rowData = [
                `<span class="${admission_pres_same}">${++index}</span>`,
                item.prescription_no_fk,
                approve_date,
                item.user_fullname,
                item.generic_name,
                item.brand_name,
                `(${item.dosage})x(${item.duration})`,
                item.duration_mu,
                item.instruction_take,
                item.item_qty,
                `${item.intended_qty}`,
                `<input type="number" oninput="checkValidForIns('${avaliable_qty}', 'pending_qty${index}')" total_qty="${item.item_qty}" intended_qty="${item.intended_qty}" value="${avaliable_qty}" name="pending_qty[]"  id="pending_qty${index}" style="text-align:right" class="form-control form-control-sm input_checked"> <input type="hidden" value="${item.prescription_med_no_pk}" id="prescription_med_pk${index}" name="prescription_med_pk[]">`,
                `<input type="checkbox" value="${item.prescription_med_no_pk}" id="pending_indent${index}" name="pending_indent[]" class="all form-control form-control-sm">`,
            ];
            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw();

        $(".admission_pres_same").parent().parent().addClass('admission_pres_same_selected');
    }

    function setApproved(data) {

        $('.approved_medicine_table tbody').empty();

        var rows = [];
        if ($.fn.DataTable.isDataTable('.approved_medicine_table')) {
            $('.approved_medicine_table').DataTable().destroy();
        }

        var table = $('.approved_medicine_table').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 1, 2, 3, 7, 8],
                    className: 'text-center'
                },
                {
                    targets: [4, 5, 6, 9],
                    className: 'text-left'
                },
                {
                    targets: [10],
                    className: 'text-right'
                }
            ],
            "lengthMenu": [
                [15, 25, 50, 75, 100, -1],
                [15, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 15
        });

        data.forEach(function(item, index) {
            var admission_date = '';
            var pres_date = '';
            var approve_date = '';
            var dosage = '';

            if (item.approve_date != null) {
                var date = new Date(item.approve_date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                approve_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }

            var admission_pres_same = '';
            var today = moment().format('DD/MM/YYYY');
            if (admission_date == approve_date == today) {
                admission_pres_same = 'admission_pres_same';
            }

            if (item.dosage != null && item.duration != null) {
                dosage = `(${item.dosage})x(${item.duration})`;
            }

            var rowData = [
                `<span class="${admission_pres_same}">${++index}</span>`,
                item.med_req_id,
                item.prescription_no_fk,
                approve_date,
                item.user_fullname,
                item.generic_name,
                item.brand_name,
                dosage,
                item.duration_mu,
                item.instruction_take,
                item.intended_qty
            ];

            rows.push(rowData);
        });

        table.clear();
        table.rows.add(rows);
        table.draw();

        $(".admission_pres_same").parent('tr').addClass('admission_pres_same_selected')
    }

    function emptyTable() {
        $('.pending_medicine_table tbody').empty();
        $('.pending_medicine_table tbody').append(`
                <tr>
                    <td colspan="13" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
    }

    function emptyReceiveTable() {
        $('.approved_medicine_table tbody').empty();
        $('.approved_medicine_table tbody').append(`
                <tr>
                    <td colspan="11" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
    }

    function padZero(number) {
        return number < 10 ? "0" + number : number;
    }

    $(document).ready(function() {
        $(document).on('click', 'a', function() {
            $(".admission_pres_same").parent().parent().addClass('admission_pres_same_selected');
            $(".row-color").parent().parent().addClass('bg-danger text-white');
        })


    })


    function IndentRequest() {
        let formElement = document.querySelector('#indentReqForm');
        let formData = new FormData(formElement);
        let hasError = false;
        let checked = '';

        $('input[name="pending_qty[]"]').each(function(index) {
            checked = $('input[name="pending_indent[]"]').eq(index).attr('id');
            if ($("#" + checked).is(':checked')) {
                if ($(this).val() == null || $(this).val() == 0) {
                    alert('Qty Required!');
                    hasError = true;
                    return false;
                }
            }
        })

        if ($('input[name="pending_indent[]"]:checked').length == 0) {
            alert('Please select at least one item!');
            return false;
        }


        if (hasError == true) {
            alert('Qty Required!');
            return false;
        }


        $.ajax({
            url: "{{route('v2.ipd.medicine-indent-request')}}",
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $.unblockUI();
                getPendingMedicine(null);
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-title').html(data.title);
                $('.common-modal-notify .modal-body').html(data.message);
            },
            error: function(err) {
                $.unblockUI();
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }


    function checkValid(avaliable_qty, id) {
        let qty = $("#" + id).val();
        if (Number(qty) > Number(avaliable_qty)) {
            alert('Qty not available');
            $("#" + id).val(avaliable_qty);
            return false;
        }
    }

    function checkValidForIns(avaliable_qty, id) {
    let qty = Number($("#" + id).val());
    let total_qty = Number($("#" + id).attr('total_qty'));
    let intended_qty = Number($("#" + id).attr('intended_qty')); 
    let remaining_qty = total_qty - intended_qty;
    $("#" + id).next(".qty-warning").remove();
    if (qty > remaining_qty) {
        alert("You cannot enter more than the remaining allowed quantity (" + remaining_qty + ").");
        $("#" + id).val(avaliable_qty); 
        return false;
    }
    if (qty > Number(avaliable_qty)) {
        $("#" + id).after('<div class="qty-warning" style="color: orange; font-size: 12px;">Note: Entered quantity exceeds available stock (' + avaliable_qty + ').</div>');
    }

    return true;
}




    function checkedAll() {
        if ($("#checked_all").is(":checked")) {
            $(".all").prop('checked', true);
            $(".input_checked").attr('readonly', false);
        } else {
            $(".all").prop('checked', false);
            $(".input_checked").attr('readonly', true);
        }
    }


    // Medicine receive
    // Medicine Delivery
    function getMedcineReceive(search = null) {
        let admission_id = '{{@$patient_info->admission_no_pk}}';
        let patient_id = '{{@$patient_info->patient_no_pk}}';
        $.ajax({
            url: "{{route('v2.ipd.receive-medicine-from-nurse-station')}}",
            method: "post",
            data: {
                delivered: 1,
                admission_id: admission_id,
                patient_id: patient_id
            },
            beforeSend: function() {
                if (search != null) {
                    blockUI();
                }
            },
            success: function(response) {
                $.unblockUI();
                if (response.data.length != 0) {
                    setMedicineReceive(response.data);
                } else {
                    emptyMedicineReceiveTable();
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



    function setMedicineReceive(data) {
        $('.receive_medicine_table tbody').empty();

        var rows = [];
        if ($.fn.DataTable.isDataTable('.receive_medicine_table')) {
            $('.receive_medicine_table').DataTable().destroy();
        }

        var table = $('.receive_medicine_table').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 1, 3, 4, 5, 6, 7],
                    className: 'text-center'
                },
                {
                    targets: [2, 8, 9],
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
                                data-action="{{ route('v2.ipd.get-prescription-wise-pending-medicine-delivered-receive', '') }}/${item.med_req_id}"
                                data-id="${item.invoice_no_fk}" data-modal="common-modal-sm"
                                data-title="Pending Medicine" title="Pending Medicine">
                                <i class="fa fa-eye"></i>
                            </a>`;

            button_group += `<a class="btn btn-sm btn-primary text-white" style="cursor:pointer" onclick="receiveMedicine('${item.med_req_id}', '${item.invoice_no_fk}')" title="Click to Received">
                                Receive
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

    function emptyMedicineReceiveTable() {
        $('.receive_medicine_table tbody').empty();
        $('.receive_medicine_table tbody').append(`
                <tr>
                    <td colspan="10" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
    }


    function receiveMedicine(med_req_id, invoice_no_fk) {
        $.ajax({
            url: "{{route('v2.ipd.medicine-receive')}}",
            method: "post",
            data: {
                med_req_id: med_req_id,
                invoice_no_fk: invoice_no_fk
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                getMedcineReceive();
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




    // Medicine Received 
    function getMedcineReceived(search = null) {
        let admission_id = '{{@$patient_info->admission_no_pk}}';
        let patient_id = '{{@$patient_info->patient_no_pk}}';
        $.ajax({
            url: "{{route('v2.ipd.received-medicine-from-nurse-station')}}",
            method: "post",
            data: {
                delivered: 1,
                admission_id: admission_id,
                patient_id: patient_id
            },
            beforeSend: function() {
                if (search != null) {
                    blockUI();
                }
            },
            success: function(response) {
                $.unblockUI();
                if (response.data.length != 0) {
                    setMedicineReceived(response.data);
                } else {
                    emptyMedicineReceivedTable();
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

    function setMedicineReceived(data) {
        $('.received_medicine_table tbody').empty();

        var rows = [];
        if ($.fn.DataTable.isDataTable('.received_medicine_table')) {
            $('.received_medicine_table').DataTable().destroy();
        }

        var table = $('.received_medicine_table').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 1, 5, 6, 7],
                    className: 'text-center'
                },
                {
                    targets: [2, 3, 4, 8, 9],
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
        var edit_btn = ``;
        data.forEach(function(item, index) {

            var approve_date = '';
            var dosage = '';

            if (item.approve_date != '') {
                var date = new Date(item.approve_date);
                var day = date.getDate();
                var month = date.getMonth() + 1;
                var year = date.getFullYear();
                approve_date = padZero(day) + "/" + padZero(month) + "/" + year;
            }

            if (item.dosage != null) {
                dosage = `(${item.dosage})x(${item.duration})`;
            }

            var avaliable_qty = Number(item.item_qty) - (Number(item.mr_qty) + Number(item.mc_qty) + Number(item.mr_pos_qty));
            if (item.discontine_ind == 1) {
                edit_btn = `<button type="button" class="btn btn-sm btn-warning  row-color" onclick="consumptionReturn(2)">Return</button>`;
            } else {
                edit_btn = `<button class="btn btn-sm btn-success pr-1" type="button" onclick="consumptionReturn(1)">Consumption</button> <button type="button" class="btn btn-sm btn-danger" onclick="consumptionReturn(2)">Return</button>`;
            }

            var rowData = [
                `${++index}`,
                item.med_req_id,
                item.prescription_no_fk,
                item.generic_name,
                item.brand_name,
                dosage,
                item.duration_mu,
                avaliable_qty,
                `<input type="number" oninput="checkValid('${avaliable_qty}', 'consReturn_qty${index}')" value="0" name="consReturn_qty[]"  id="consReturn_qty${index}" style="text-align:right" class="form-control form-control-sm input_checked"> <input type="hidden" value="${item.patmedtran_no_pk}" id="patmedtran_no_pk${index}" name="patmedtran_no_pk[]"> <input type="hidden" value="${item.ref_tran_id}" id="ref_tran_id${index}" name="ref_tran_id[]">  <input type="hidden" value="${item.med_req_id}" id="med_req_id${index}" name="med_req_id[]">`,
                edit_btn
            ];
            // if(avaliable_qty != 0 && avaliable_qty > 0){
            rows.push(rowData);
            // }
        });
        table.clear();
        table.rows.add(rows);
        table.draw();
        $(".row-color").parent().parent().addClass('bg-danger text-white');

    }

    function emptyMedicineReceivedTable() {
        $('.received_medicine_table tbody').empty();
        $('.received_medicine_table tbody').append(`
                <tr>
                    <td colspan="10" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
    }


    function consumptionReturn(ind) {
        $("#consumption_return").val(ind);
        let formElement = document.querySelector('#medicineForm');
        let formData = new FormData(formElement);
        let hasError = false;

        $.ajax({
            url: "{{route('v2.ipd.medicine-return-consumption')}}",
            type: "post",
            dataType: "json",
            data: formData,
            cache: false,
            contentType: false,
            processData: false,
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $.unblockUI();
                getMedcineReceived(null);
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-title').html(data.title);
                $('.common-modal-notify .modal-body').html(data.message);
            },
            error: function(err) {
                $.unblockUI();
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }


    // Medicine Consumption
    function getMedcineConsumption(search = null) {
        let admission_id = '{{@$patient_info->admission_no_pk}}';
        let patient_id = '{{@$patient_info->patient_no_pk}}';
        $.ajax({
            url: "{{route('v2.ipd.consumption-medicine-from-nurse-station')}}",
            method: "post",
            data: {
                admission_id: admission_id,
                patient_id: patient_id
            },
            beforeSend: function() {
                if (search != null) {
                    blockUI();
                }
            },
            success: function(response) {
                $.unblockUI();
                if (response.data.length != 0) {
                    setMedicineConsumption(response.data);
                } else {
                    emptyMedicineConsumptionTable();
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

    function setMedicineConsumption(data) {
        $('.consumption_medicine_table tbody').empty();

        var rows = [];
        if ($.fn.DataTable.isDataTable('.consumption_medicine_table')) {
            $('.consumption_medicine_table').DataTable().destroy();
        }

        var table = $('.consumption_medicine_table').DataTable({
            searching: true,
            columnDefs: [{
                    targets: [0, 1, 5, 6, 7],
                    className: 'text-center'
                },
                {
                    targets: [2, 3, 4, ],
                    className: 'text-left'
                },
                {
                    targets: [8],
                    className: 'text-right'
                }
            ],
            "lengthMenu": [
                [15, 25, 50, 75, 100, -1],
                [15, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 15
        });

        var button_group = ``;
        var dosage = ``;
        data.forEach(function(item, index) {
            dosage = '';
            if (item.dosage != null) {
                dosage = `(${item.dosage})x(${item.duration})`;
            }
            var rowData = [
                `${++index}`,
                item.med_req_id,
                item.prescription_no_fk,
                item.generic_name,
                item.brand_name,
                dosage,
                item.duration_mu,
                item.instruction_take,
                item.mc_qty

            ];
            rows.push(rowData);

        });
        table.clear();
        table.rows.add(rows);
        table.draw();


    }

    function emptyMedicineConsumptionTable() {
        $('.consumption_medicine_table tbody').empty();
        $('.consumption_medicine_table tbody').append(`
                <tr>
                    <td colspan="9" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
    }

    // Medicine Return
    function getMedcineReturn(search = null) {
        let admission_id = '{{@$patient_info->admission_no_pk}}';
        let patient_id = '{{@$patient_info->patient_no_pk}}';
        $.ajax({
            url: "{{route('v2.ipd.return-medicine-from-nurse-station')}}",
            method: "post",
            data: {
                admission_id: admission_id,
                patient_id: patient_id
            },
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
                    targets: [0, 1, 5, 6, 7, 9],
                    className: 'text-center'
                },
                {
                    targets: [2, 3, 4, ],
                    className: 'text-left'
                },
                {
                    targets: [8],
                    className: 'text-right'
                }
            ],
            "lengthMenu": [
                [15, 25, 50, 75, 100, -1],
                [15, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 15
        });

        var button_group = ``;
        var status = ``;
        var dosage = ``;
        data.forEach(function(item, index) {

            if (item.rtnrcv_ind == 1) {
                status = `<span class="badge badge-success">Received</span>`;
            } else {
                status = `<span class="badge badge-warning">Pending</span>`;
            }

            button_group = ``;
            if (item.invoice_no_fk != null && item.ledgertrn_no_fk != null) {
                button_group = `<a class="btn btn-sm btn-primary text-white" style="cursor:pointer" href="{{ url('pos-due-invoice-print/${item.invoice_no_fk}/${item.ledgertrn_no_fk}') }}" target="_blank" title="Invoice">
                                        <i class="fa fa-file text-white"></i>
                                    </a>`;
            }

            dosage = '';
            if (item.dosage != null) {
                dosage = `(${item.dosage})x(${item.duration})`;
            }
            var rowData = [
                `${++index}`,
                item.med_req_id,
                item.prescription_no_fk,
                item.generic_name,
                item.brand_name,
                dosage,
                item.duration_mu,
                item.instruction_take,
                item.mr_qty,
                status,
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
                    <td colspan="11" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
    }
</script>