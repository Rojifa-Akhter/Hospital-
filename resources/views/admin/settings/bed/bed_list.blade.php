<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">

<style>
    .bed_list_data_table>tbody>tr>td{
        font-size: 12px !important;
    }
    .bed_list_data_table>thead>tr>th{
        font-size: 12px !important;
        padding: 5px 2px;
    }
</style>
<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
            <div class="col-md-12">
                <div class="float-left">
                    <h5 class="mt-2 mb-0">Bed List</h5>
                    <small>Settings / Bed setup / Bed List ssss</small>
                </div>
                <div id="top-action">
                    <button class="btn btn-outline-primary btn-md float-right open-modal mt-2"
                        data-modal="common-modal-sm" data-action="{{ route('bed.create') }}"
                        data-title="Create New Bed"><i class="fa fa-plus"></i> Create New Bed</button>
                </div>
            </div>
        </div>

        <div class="card">
            <div class="card-header"><h5><i class="fa fa-search"></i> Search</h5></div>
            <div class="card-body">
                <form action="{{ route('bed.bed-search') }}" id="searchForm" method="post">
                    @csrf
                    <div class="form-row justify-content-center">
                        <div class="col-md-3">
                            <div class="form-group">
                                <label class="col-form-label col-form-label-sm" for="bed_type">Bed Status</label>
                                <select class="form-control form-control-sm select2" id="bed_type" name="bed_type">
                                    <option value="">Select Item Type</option>
                                            <option value="1">Available</option>
                                            <option value="2">Occupied</option>
                                            <option value="3">Not Ready</option>
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3">
                            <div class="" >
                                <label class="col-form-label col-form-label-sm" for="request_department">Department
                                </label>
                                <select class="form-control form-control-sm select2" onchange="bedViewer.getWard(this)" id="request_department" name="request_department">
                                    <option value="">select department</option>
                                    @if (!empty($requestDepts))
                                    @foreach ($requestDepts as $rd)
                                    <option value="{{ $rd->serviceunit_no_pk }}">
                                        {{ $rd->serviceunit_name }}
                                    </option>
                                    @endforeach
                                    @endif
                                </select>
                            </div>
                        </div>

                        <div class="col-md-3" id="ward_container">
                            @include('admin.settings.bed.ipd_ward_bed_name')
                        </div>

                        <div class="col-md-3" id="bed_container">
                            @include('admin.settings.bed.ipd_bed_viewer_bed_setup')
                        </div>
                        <div class="col-md-2">
                            <div class="btn-group btn-block" role="group">
                                <button type="button"  onclick="getBedList()" class="btn btn-md btn-success btn-block mt-4">Search</button>

                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>




        <div class="card">
            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped bed_list_data_table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" style="width:3%">Sl#</th>
                                    <th class="text-left" style="width:6%">Serviceunit name</th>
                                    <th class="text-center" style="width:5%">Bed Code</th>
                                    <th class="text-center" style="width:8%">Bed Name</th>
                                    <th class="text-center" style="width:14%">Ward Name</th>
                                    <th class="text-center" style="width:7%">Admission Fee (TK)</th>
                                    <th class="text-center" style="width:7%">Bad Charge (TK)</th>
                                    <th class="text-center" style="width:7%">Service Charge (TK)</th>
                                    <th class="text-center" style="width:7%">Other Charge (TK)</th>
                                    <th class="text-center" style="width:7%">Minimum Diposit Amount (TK)</th>
                                    <th class="text-center" style="width:7%">Remarks</th>
                                    <th class="text-center" style="width:5%">Authorized Beds</th>
                                    <th class="text-center" style="width:8%">Bed Status</th>
                                    <th class="text-center" style="width:4%">Serial No.</th>
                                    <th class="text-center" style="width:5%">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                <tr>
                                    <td colspan="15" class="text-center">Data Fetching ... </td>
                                </tr>
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    $(document).ready(function() {
        getBedList(true);
    });

    function getBedList(ind = null){
        $.ajax({
            url:"{{ route('bed.bed-search') }}",
            type:"post",
            data: {
                _token: "{{ csrf_token() }}",
                bed_type: $('#bed_type').val(),
                request_department: $('#request_department').val(),
                destination_ward: $('#destination_ward').val(),
                destination_bed: $('#destination_bed').val(),
            },
            beforeSend: function() {
                if(ind == null){
                    blockUI();
                }
            },
            success:function(data){  
                $.unblockUI();
                    if(data.data.length > 0)
                        setTableData(data.data); 
                    else
                        emptyTableData();

            },
            error:function(err){
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


    function  setTableData(data){
        if($.fn.DataTable.isDataTable('.bed_list_data_table')) {$('.bed_list_data_table').DataTable().destroy();}  
            $('.bed_list_data_table tbody').empty();
            var rows = [];
            var table = $('.bed_list_data_table').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0,10,11,12,13,14], className: 'text-center' },
                        { targets: [1,2,3,4], className: 'text-left' },
                        { targets: [5,6,7,8,9], className: 'text-right' },
                    ],
                "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                "pageLength": 10 
                });


            var edit_link = ``;
            var status = '';
            data.forEach(function(item, index) {

                    status = '';
                    if(item.authorized_bed_ind == 1){
                        status = '<span class="badge badge-primary">Yes</span';
                    }else{
                        status = '<span class="badge badge-danger">No</span';
                    }

                    edit_link = `<span Class="btn btn-sm btn-primary open-modal" data-id="${item.bed_no_pk}" data-action="{{ route('bed.edit-bed-setup', '') }}/${item.bed_no_pk}" data-modal="common-modal-sm" data-title="Edit Bed" title="Edit"><i class="fa fa-pencil-alt"></i></span>`;
                    var rowData = [
                        ++index,
                        item.serviceunit_name,
                        item.bed_uid,
                        item.bed_name,
                        item.ward_name,
                        numberFormat(item.admission_fee_item_no_fk, 2, '.', ','),
                        numberFormat(item.bed_charge_amount, 2, '.', ','),
                        numberFormat(item.service_charge_item_no_fk, 2, '.', ','),
                        numberFormat(item.others_charge_item_no_fk, 2, '.', ','),
                        numberFormat(item.minimum_deposit_amount, 2, '.', ','),
                        item.remarks,
                        status,
                        item.bed_status,
                        item.bed_sl_no,
                        edit_link
                    ];
                    rows.push(rowData); 

            });
            table.clear();
            table.rows.add(rows);
            table.draw();
    }

    function emptyTableData(){
        $('.bed_list_data_table tbody').html(`
                <tr>
                    <td colspan="15" class="text-center">Data Not Found</td>
                </tr>`
            );
    }

    var bedViewer = {
        getBedByWard: function(thisElement) {
            var bed_value = $(thisElement).val();
            var bed_data = $(thisElement).val();
            if ($(thisElement).val() !="") {
                $.ajax({
                url: "{{ route('ipd.get-bed-by-ward-search') }}",
                type: 'POST',
                data: {
                    bed_value: bed_value,
                    bed_data: bed_data
                },
                beforeSend: function() {
                    blockUI();

                },
                success: function(data) {
                    $("#bed_container").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
            }else{
                return;
            }

        },
        filterBed: function(thisElement) {
            var bed_status = $(thisElement).attr("value");
            var ward_id = $("#destination_ward").val();

            //for bed data
            if (bed_status == 1) {
                $('#bedAndPatientData').addClass('d-none');
            } else if (bed_status == 2) {
                $('#bedAndPatientData').addClass('d-none');
            } else if (bed_status == 3) {
                $('#bedAndPatientData').addClass('d-none');
            }
            // alert(bed_value)
            $.ajax({
                url: "{{ route('get_bed_data') }}",
                type: 'GET',
                data: {
                    bed_status: bed_status,
                    ward_id: ward_id
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#bed_container").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
        getBedDetails: function(thisElement) {
            var bed_id = $(thisElement).attr("id");
            var bed_status = $(thisElement).attr('data-status');
            if (bed_status == 1) {
                $('#bedAndPatientData').removeClass('d-none');
                $("#bed_id").val(bed_id);
                $.ajax({
                    url: "{{ route('ipd.get-patient-bed-info') }}",
                    type: 'GET',
                    data: {
                        bed_id: bed_id,
                        bed_status: bed_status
                    },
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(data) {

                        $("#bedAndPatientData").html(data);
                    },
                    complete: function() {
                        $.unblockUI();
                    }
                });
            } else if (bed_status == 2) {
                alert('This Bed Is Unavailable');
                $('#bedAndPatientData').removeClass('d-none');
                return;
            } else if (bed_status == 3) {
                alert('This Bed Is Not Ready');
                $('#bedAndPatientData').removeClass('d-none');
                return;
            }
        },
        getIdforStore: function(thisElement) {
            var bed_id = $('#bed_id').attr("id");
            $.ajax({
                url: "{{ route('ipd.store-quick-admission') }}",
                type: 'POST',
                data: {
                    bed_id: bed_id
                },
                beforeSend: function() {
                    blockUI();
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        },
        getWard: function(thisElement) {
            var ward_data = $('#request_department').val();

            if ($(thisElement).val() !="") {
                $.ajax({
                url: "{{ route('ipd.get-ward-search') }}",
                type: 'POST',
                data: {
                    ward_data: ward_data
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#ward_container").html(data);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
            }else{
                return;
            }

        },
    };

</script>
