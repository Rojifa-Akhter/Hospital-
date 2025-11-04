<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .text-left{
        text-align:left;
    }
</style>

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-10 mb-1">
                <h5 class="mt-2 mb-0">Ambulance Trip Worklist</h5>
                <small>Ambulance  / Trip Worklist</small>
            </div>
        </div>
        <div class="card">
            <div class="card-header ">
                {{-- <h5>Trip Worklist</h5> --}}
                 
            </div>
        <nav>
            <div class="nav nav-tabs" id="nav-tab" role="tablist">
                <button class="nav-link active" id="nav-home-tab" data-toggle="tab" data-target="#nav-home" type="button" role="tab" aria-controls="nav-home" aria-selected="true" onclick="getData()">Trip Worklist</button>
                <button class="nav-link" id="nav-profile-tab" data-toggle="tab" data-target="#nav-profile" type="button" role="tab" aria-controls="nav-profile" aria-selected="false" onclick="getCompletedData()">Trip Completed Worklist</button>
              </div>
        </nav>
        <div class="tab-content" id="nav-tabContent">
            <div class="tab-pane fade show active" id="nav-home" role="tabpanel" aria-labelledby="nav-home-tab">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover data_table" id="dataTable">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center">SL.</th>
                                    <th class="text-center">Trip No</th>
                                    <th class="text-center">Ambulance name</th>
                                    <th class="text-center">Ambulance no</th>
                                    <th class="text-center">Driver Name</th>
                                    <th class="text-center">Patient Name</th>
                                    <th class="text-center">Patient UHID</th>
                                    <th class="text-center">Patient Type</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Start / End Location</th>
                                    <th class="text-center">Start / End Time</th>
                                    <th class="text-center">Total Bill</th>
                                    <th class="text-center">Invoice No</th>
                                    <th class="text-center">Status</th>
                                    <th class="text-center">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
            <div class="tab-pane fade" id="nav-profile" role="tabpanel" aria-labelledby="nav-profile-tab" >
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover data_table_2" id="dataTable">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center">SL.</th>
                                    <th class="text-center">Trip No</th>
                                    <th class="text-center">Ambulance name</th>
                                    <th class="text-center">Ambulance no</th>
                                    <th class="text-center">Driver Name</th>
                                    <th class="text-center">Patient Name</th>
                                    <th class="text-center">Patient UHID</th>
                                    <th class="text-center">Patient Type</th>
                                    <th class="text-center">Phone</th>
                                    <th class="text-center">Start / End Location</th>
                                    <th class="text-center">Start / End Time</th>
                                    <th class="text-center">Total Bill</th>
                                    <th class="text-center">Invoice No</th>
                                    <th class="text-center">Status</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>

        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
   $("body").addClass("sidebar-collapse");
    $(document).ready(function() {
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
            }
        });
    });
    <!-- Fetch Table Data -->
    getData();

    function getData() {
        $.ajax({
            url: "{{ route('ambulance.ambulance-trip-get-data') }}",
            method: "GET",
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                console.log(response.data);
                // return false;
                if(response.data.length != 0) {
                    setTableData(response.data);
                }
                else {
                    emptyTable();
                }
            },
            error:function(err) {
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

    <!-- Set Table Data -->
    function setTableData(data) {
        // Destroy Datatable if exists
        if($.fn.DataTable.isDataTable('.data_table')) {
            $('.data_table').DataTable().destroy();
        }
        if($.fn.DataTable.isDataTable('.data_table_2')) {
            $('.data_table_2').DataTable().destroy();
        }
        $('.data_table tbody').empty();
        $('.data_table_2 tbody').empty();
        var rows = [];
        var table = $('.data_table').DataTable({
            searching: true,
            columnDefs: [
                    // { targets: [11], className: 'text-right' },
                    // { targets: [13], className: 'text-center' },
                    { targets: [12], className: 'text-left' }
                ],
                "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
                "pageLength": 10
            });

        data.forEach(function(item, index) {
            let status = null;
            // if(item.end_time != null) {
            //     status = '<span class="badge badge-success">Free</span>';
            // }else
             if((item.ledger_amt_sales-item.ledger_amt_discount)-item.ledger_amt_payment <= 0) {
                status = '<span class="badge badge-success">Paid</span>';
            }else {
                status = '<span class="badge badge-warning">Due</span>';
            }
            let tripEditUrl = "{{ route('ambulance.ambulance-trip-edit', ['id' => ':id']) }}";
            tripEditUrl = tripEditUrl.replace(':id', item.ambt_trip_no_pk);

            let ambBilling = "{{ route('ambulance.ambulance-billing', ['id' => ':id']) }}";
            ambBilling = ambBilling.replace(':id', item.ambt_trip_no_pk);
            // uniformAllocationRoute = uniformAllocationRoute.replace(':designation_id', item.designation_no_pk);

            let tripEdit = ` <span class="btn btn-sm btn-warning  open-modal" data-id="${item.ambt_trip_no_pk}" data-action="${tripEditUrl}" data-modal="common-modal-xl" data-title="Edit" title="Edit"><i class="fa fa-pencil-alt"></i></span>`;
            // `<a href="${tripEditUrl}" target="_blank"><i class="fas fa-edit"></i></a>`;

            let bill =item.invoice_no_fk ==null ? `<a href="${ambBilling}" class="p-2" target="_blank"><i class="fas fa-money-bill"></i></a>`:'';
            let startEndLocation=`${item.start_from_location} / ${item.ended_to_location}`;
            let startEndTimeDate=`${item.start_time} / ${item.end_time??''}`;
            let billInfo=`Payable=${item.ledger_amt_sales?? 0}<br>Discount=${item.ledger_amt_discount?? 0}<br>Paid=${item.ledger_amt_payment?? 0}<br>Due=${(item.ledger_amt_sales-item.ledger_amt_discount)-item.ledger_amt_payment}`;
            const rowData = [
                ++index,
                item.ambt_trip_no_pk,
                item.ambs_ambulance_name,
                item.no_plate,
                item.driver_name,
                item.patient_name,
                item.patient_code,
                item.trip_patient_type,
                item.phone_mobile,
                startEndLocation,
                startEndTimeDate,
                billInfo,
                item.invoice_code,
                status,
                tripEdit + bill,
            ];
            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw();
    }
    // getCompletedData();

    function getCompletedData() {
        $.ajax({
            url: "{{ route('ambulance.ambulance-trip-get-completed-data') }}",
            method: "GET",
            beforeSend: function() {
                blockUI();
            },
            success: function(response) {
                console.log(response.data);
                // return false;
                if(response.data.length != 0) {
                    setTable2Data(response.data);
                }
                else {
                    emptyTable2();
                }
            },
            error:function(err) {
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

    <!-- Set Table Data -->
    function setTable2Data(data) {
        // Destroy Datatable if exists
        if($.fn.DataTable.isDataTable('.data_table_2')) {
            $('.data_table_2').DataTable().destroy();
        }
        if($.fn.DataTable.isDataTable('.data_table')) {
            $('.data_table').DataTable().destroy();
        }
        $('.data_table_2 tbody').empty();
        $('.data_table tbody').empty();
        var rows = [];
        var table = $('.data_table_2').DataTable({
            searching: true,
            columnDefs: [
                    // { targets: [11], className: 'text-right' },
                    { targets: [13], className: 'text-center' },
                    { targets: [11], className: 'text-left' }
                ],
                "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
                "pageLength": 10
            });

        data.forEach(function(item, index) {
            let status = null;
            if((item.ledger_amt_sales-item.ledger_amt_discount)-item.ledger_amt_payment <= 0) {
                status = '<span class="badge badge-success">Paid</span>';
            }else{
                status = '<span class="badge badge-warning">Due</span>';
            }
            //  if(item.invoice_no_fk !=null) {
            //     status = '<span class="badge badge-success">Paid</span>';
            // }else {
            //     status = '<span class="badge badge-danger">Unpaid</span>';
            // }
            // let uniformAllocationRoute = "{{ route('uniformWorklist.allocate', ['id' => ':id', 'designation_id' => ':designation_id']) }}";
            // uniformAllocationRoute = uniformAllocationRoute.replace(':id', item.person_no_pk);
            // uniformAllocationRoute = uniformAllocationRoute.replace(':designation_id', item.designation_no_pk);

            // const uniformAllocation = '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="'+uniformAllocationRoute+'" data-modal="common-modal-md" data-title="Allocate Uniform" title="Allocate Uniform" data-id="'+item.person_no_pk+'"><i class="fas fa-edit"></i></span>';
            // const allocationHistory = '<span class="btn btn-sm btn-warning btn-md-global open-modal btnView" data-action="{{ route('uniformWorklist.allocationHistory','')}}/'+item.person_no_pk+'" data-modal="common-modal-sm" data-title="Uniform Allocation History" title="Uniform Allocation History" data-id="'+item.person_no_pk+'"><i class="fas fa-history"></i></span>';
            let bill = '<span class="badge badge-info">Go for Bill</span>';
            let startEndLocation=`${item.start_from_location} / ${item.ended_to_location}`;
            let startEndTimeDate=`${item.start_time} / ${item.end_time??''}`;
         
            let billInfo=`Payable=${item.ledger_amt_sales?? 0}<br>Discount=${item.ledger_amt_discount?? 0}<br>Paid=${item.ledger_amt_payment?? 0}<br>Due=${(item.ledger_amt_sales-item.ledger_amt_discount)-item.ledger_amt_payment}`;
            const rowData = [
                ++index,
                item.ambt_trip_no_pk,
                item.ambs_ambulance_name,
                item.no_plate,
                item.driver_name,
                item.patient_name,
                item.patient_code,
                item.trip_patient_type,
                item.phone_mobile,
                startEndLocation,
                startEndTimeDate,
                billInfo,
                item.invoice_code,
                status,
            ];
            rows.push(rowData);
        });
        table.clear();
        table.rows.add(rows);
        table.draw();
    }

    function emptyTable() {
        $('.data_table tbody').empty();
        $('.data_table tbody').append(`
            <tr>
                <td colspan="15" class="text-danger text-center">Data Not Found</td>
            </tr>
        `);
    }
    function emptyTable2() {
        $('.data_table_2 tbody').empty();
        $('.data_table_2 tbody').append(`
            <tr>
                <td colspan="14" class="text-danger text-center">Data Not Found</td>
            </tr>
        `);
    }
</script>
