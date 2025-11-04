<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Purchase Requisition Assign</h5>
                            <small>Inventory / Purchase Requisition Assign</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('v2.pr-asign-pdf') }}" method="post" id="searchPR" class="searchPR">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="pr_no" class="col-form-label">PR</label>
                                            <div>
                                                <input type="text" class="form-control form-control-sm" id="pr_no" name="pr_no" placeholder="PR No" value="" />
                                                <input type="hidden" id="report_type" name="report_type" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="department" class="col-form-label">Department</label>
                                            <div>
                                                <select class="form-control form-control-sm" id="department" name="department">
                                                    <option value="">All</option>
                                                    @foreach($main_store_list as $item)
                                                    <option value="{{$item->serviceunit_no_pk}}">{{$item->serviceunit_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12">
                                        <div class="form-group form-row">
                                            <label for="from_date" class="col-form-label">From/To Date</label>
                                            <div>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm sevenDaysAgo" id="from_date" name="from_date" placeholder="From Date" value="" />
                                                    <input type="text" class="form-control form-control-sm date_picker" id="to_date" name="to_date" placeholder="To Date" value="" />
                                                </div>                                              
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12" id="assign_to">
                                        <label for="pr_no" class="col-form-label">Assign To</label>
                                        <div >
                                            <input type="text" class="form-control form-control-sm" id="emp_name_search" name="emp_name_search" placeholder="Employee Name" value="" />
                                            <input type="hidden" id="emp_id_search" name="emp_id_search" value="">
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <label for="pr_no" class="col-form-label">Action</label>
                                        <div>
                                            <button type="button" class="btn btn-secondary btn-md uhl_save_btn" id="" onclick="searchPR(true)">Search</button>                               
                                            <button type="button" id="btnReportGRN" class="btn btn-warning btn-md-global" target="_blank" onclick="print(this)" reportType="PDF">
                                            <i class="fa fa-download"></i> PDF</button>
                                            <button type="submit" class="btn btn-primary btn-md-global" target="_blank" reportType="EXCEL" onclick="print(this)">
                                                <i class="fa fa-download text-white"></i> Excel
                                            </button>
                                        </div>
                                        
                                    </div>

                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </form>

            <div class="row">
                <div class="col-md-12">
                    <div class="card">
                        <div class="card-body">


                            <div class="row">
                                <div class="col-md-12">
                                    <ul class="nav nav-tabs justify-content-center" id="myTab" role="tablist">
                                        <li class="nav-item">
                                            <a class="nav-link active" id="not-pr-assigned" data-toggle="tab" href="#not-assigned" role="tab" aria-controls="not-assigned" aria-selected="true" onclick="searchPR('not')">Not Assigned <span class="badge badge-secondary"></span></a>
                                        </li>
        
                                        <li class="nav-item">
                                            <a class="nav-link " id="assigned-pr" data-toggle="tab" href="#assigned" role="tab" aria-controls="not-assigned" aria-selected="true" onclick="searchPR('assinged')">Assigned<span class="badge badge-secondary"></span></a>
                                        </li>

                                        <li class="nav-item">
                                            <a class="nav-link " id="assigned-pr-status" data-toggle="tab" href="#assignedPrStatus" role="tab" aria-controls="assigned-pr-status" aria-selected="true" onclick="searchPRAssignStatus()">Assigned Status</a>
                                        </li>
            
                                    </ul>



                                    <div class="tab-content p-0" id="myTabContent">   
                                        <!-- Not Assigned PR -->                       
                                        <div class="tab-pane fade show active" id="not-assigned" role="tabpanel" aria-labelledby="not-pr-assigned">
                                          
                                                <form action="#" method="post" id="assignPR" class="assignPR">
                                                    @csrf



                                                    <div class="row py-2 justify-content-center" id="employee_field" style="display:none">
                                                        <div class="col-2">
                                                            <label for="" class="float-end">Assign To</label>
                                                        </div>
                                                        <div class="col-4">
                                                            <input type="text" class="form-control form-control-sm w-100" title="Type Employee Name" name="emp_name" id="emp_name" placeholder="Employee Name" />
                                                            <input type="hidden" name="emp_id" id="emp_id">
                                                        </div>
                                                        <div class="col-2">
                                                            <button type="button" class="btn btn-secondary btn-md btn-primary uhl_common_btn w-100" id="" onclick="assignPR()">Assign</button> 
                                                        </div>
                                                    </div>

                                                    <div class="table-responsive pt-2">
                                                        <table class="table table-striped table-bordered table-hover pr_not_assigned_table">
                                                            <thead class="global-uhl-table-bg">
                                                                <tr>
                                                                    <th class="text-center" style="width:5%">#SL</th>
                                                                    <th class="text-center" style="width:11%">Department</th>
                                                                    <th class="text-center" style="width:6%">PR No</th>
                                                                    <th class="text-center" style="width:8%">PR Date</th>
                                                                    <th class="text-center" style="width:36%">Remarks</th>
                                                                    <th class="text-center" style="width:10%">Approval Status</th>
                                                                    <th class="text-center" style="width:8%">No Of Item</th>
                                                                    <th class="text-center" style="width:7%">Assign</th>
                                                                    <th class="text-center" style="width:9%">Action</th>
                                                                </tr>
                                                            </thead>
                        
                                                            <tbody>
                                                                <tr>
                                                                    <td colspan="9" class="text-center">Data Fetching ...</td>
                                                                </tr>
                                                            </tbody>
                                                        </table>
                                                    </div>

                                                    
                                                </form>
                                            
                                        </div>

                                        <!-- Assigned PR -->
                                        <div class="tab-pane fade " id="assigned" role="tabpanel" aria-labelledby="assigned-pr">
                                            <div style="overflow-x: auto">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover pr_assigned_table">
                                                        <thead class="global-uhl-table-bg">
                                                            <tr>
                                                                <th class="text-center" style="width:5%">#SL</th>
                                                                <th class="text-left" style="width:20%">Department</th>
                                                                <th class="text-left" style="width:35%">Assigned Employee</th>
                                                                <th class="text-center" style="width:8%">PR No</th>
                                                                <th class="text-center" style="width:8%">PR Date</th>
                                                                <th class="text-center" style="width:8%">Assign Date</th>
                                                                <th class="text-center" style="width:8%">PR Status</th>
                                                                <th class="text-center" style="width:8%">Action</th>                 
                                                            </tr>
                                                        </thead>
                    
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="8" class="text-center">Data Fetching ...</td>
                                                            </tr>
                                                        </tbody>
                                                    </table>
                                                </div>
                                            </div>
                                        </div>


                                        <!-- Assigned PR Status -->
                                        <div class="tab-pane fade" id="assignedPrStatus" role="tabpanel" aria-labelledby="assigned-pr-status">
                                            <div style="overflow-x: auto">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover pr_assigned_status_table">
                                                        <thead class="global-uhl-table-bg">
                                                            <tr>
                                                                <th class="text-center" style="width:5%">#SL</th>
                                                                <th class="text-center" style="width:14%">Department</th>
                                                                <th class="text-left" style="width:15%">Assigned Employee</th>
                                                                <th class="text-center" style="width:7%">PR No</th>
                                                                <th class="text-center" style="width:7%">PR Date</th>
                                                                <th class="text-center" style="width:7%">Assign Date</th>
                                                                <th class="text-center" style="width:28%">Item Name</th>
                                                                <th class="text-center" style="width:9%">Revoke Status</th>
                                                                <th class="text-center" style="width:8%">PO Status</th>
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
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
     openDoctorAutocomplete('#emp_name', 'emp_id', "employee_ind", 1);
     openDoctorAutocomplete('#emp_name_search', 'emp_id_search', "employee_ind", 1);
    $(document).ready(function(){

        var currentDate = new Date();
        var sevenDaysAgo = new Date();
            sevenDaysAgo.setDate(currentDate.getDate() - 7);
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy',
        }).datepicker('setDate', currentDate);

        $('.sevenDaysAgo').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy',
        }).datepicker('setDate', sevenDaysAgo);


        searchPR();
    })
</script>

<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        
        function searchPR(search = null){


                if($('#assignedPrStatus').hasClass('active')){
                    searchPRAssignStatus();
                    return false;
                }
                $(".employee").hide();
                let formElement = document.querySelector('#searchPR');
                let formData = new FormData(formElement);

                $.ajax({
                url: "{{route('v2.search-pr-list')}}",
                method: "post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    if(search != null){
                        blockUI();
                    }
                   
                },
                success: function(response){
                    if(response.not_assigned_data.length != 0){
                        setTableNotAssignedData(response.not_assigned_data);
                    }
                    else{
                        emptyTable();
                    }
                    if(response.assigned_data.length != 0){
                        setTableAssignedData(response.assigned_data);
                    }
                    else{
                        emptyAssignedTable();
                    }
                },
                error:function(err){
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


        function searchPRAssignStatus(){
                let formElement = document.querySelector('#searchPR');
                let formData = new FormData(formElement);

                $.ajax({
                url: "{{route('v2.show-pr-assign-status')}}",
                method: "post",
                dataType:"json",
                data:formData,
                cache: false,
                contentType: false,
                processData: false,
                beforeSend: function() {
                    blockUI(); 
                },
                success: function(response){
                    if(response.data.length != 0){
                        setTablePRStatusData(response.data);
                    }
                    else{
                        emptyPRStatusTable();
                    }
       
                },
                error:function(err){
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

        <!-- Submit Form Data -->
       function assignPR(){

                if($("#emp_id").val() == null || $("#emp_id").val() == ""){
                    alert("please select an employee");
                    return false;
                }
                if($("#emp_name").val() == null || $("#emp_name").val() == ""){
                    alert("please select an employee");
                    return false;
                }
                if($("input[type=checkbox]:checked").length == 0){
                    alert("please select at least one PR");
                    return false;
                }

                let formElement = document.querySelector('#assignPR');
                let formData = new FormData(formElement);
                $.ajax({
                    url:"{{route('v2.assign-pr-employee')}}",
                    type:"post",
                    dataType:"json",
                    data:formData,
                    cache: false,
                    contentType: false,
                    processData: false,
                    beforeSend: function() {
                        blockUI();
                    },
                    success:function(data){
                        searchPR();
                        $("#emp_name").val("");
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);
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

        <!-- Set Table Data -->
        function setTableNotAssignedData(data){
            $('.pr_not_assigned_table tbody').empty();
            var rows = [];
            if($.fn.DataTable.isDataTable('.pr_not_assigned_table')) {
                $('.pr_not_assigned_table').DataTable().destroy();
            }
            var table = $('.pr_not_assigned_table').DataTable({
                        paging: true,
                        searching: true,
                        columnDefs: [
                                { targets: [0,2,3,5,6,7,8], className: 'text-center' },
                                { targets: [1,4], className: 'text-left' }
                            ]
                    });

            var status = "";
            var approvalStatus = "";
            var approve_text = "";
            var approval_status = "";
            var date = '';
            var day = '';
            var month = '';
            var year = '';
            var pr_date = '';
            data.forEach(function(item, index) {
                pr_date = '';
                if(item.req_at != null){
                    date = new Date(item.req_at);
                    day = date.getDate();
                    month = date.getMonth() + 1; 
                    year = date.getFullYear();
                    pr_date = padZero(day) + "/" + padZero(month) + "/" + year;
                }


                approvalLevelStatusText = item.approval_status_text;
                approvalStatusText = item.approval_status_text;

                if(approvalStatusText.indexOf('REJECTED') >= 0 || approvalStatusText.indexOf('HOLD') >= 0){
                    approve_text = `<a style="cursor:pointer" class="open-modal"
                        data-action="{{ route('v1.my.approval.level.detail-pr-list','') }}/${item.inv_requisition_po_no_fk}"
                        data-id="${item.inv_requisition_po_no_pk}" data-modal="common-modal-sm"
                        data-title="Level Detail" title="Level Detail">
                        <span class="badge badge-warning">(${item.approval_level_status_text})</span>
                    </a>
                    <span class="text-danger">${approvalStatusText.indexOf('HOLD') >= 1 ? 'Hold' : 'Rejected'}</span>`;
                }
                else{
                    if(item.approval_level_status_text != ''){
                            var lavel = item.approval_level_status_text.split('/');
                               approval_status = lavel[0] == lavel[1] ? 'Approved' : 'Pending'; 
                        }
                }

                var rowData = [
                    ++index,
                    item.serviceunit_name,
                    item.inv_requisition_po_no_pk,
                    pr_date,
                    item.req_po_remarks,
                    approve_text+`<span>${approval_status}</span>`,
                    item.item_count,
                    `<input name="assigned[]" type="checkbox" class="" value="${item.inv_requisition_po_no_pk}">`,
                    `<a style="cursor:pointer" class="open-modal btn btn-info btn-sm text-white"
                                        data-action="{{ route('v2.partial-pr-assign', '') }}/${item.inv_requisition_po_no_pk}"
                                        data-id="${item.inv_requisition_po_no_pk}" data-modal="common-modal-sm"
                                        data-title="Partial PR Assign" title="Partial PR Assign">
                                        Assign
                                    </a>
                                    
                                    
                    <a href="{{ route('v1.pr-print', '') }}/${item.inv_requisition_po_no_pk}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>`,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            $("#employee_field").show();
        }

        function padZero(number) {
            return number < 10 ? "0" + number : number;
        }

        function setTableAssignedData(data){

            $('.pr_assigned_table tbody').empty();
            var rows = [];
            if($.fn.DataTable.isDataTable('.pr_assigned_table')) {
                $('.pr_assigned_table').DataTable().destroy();
            }
            var table = $('.pr_assigned_table').DataTable({
                        paging: true,
                        searching: true,
                        columnDefs: [
                                { targets: [0,3,4,5,6], className: 'text-center' },
                                { targets: [1,2], className: 'text-left' }
                            ]
                    });

            var status = "";
            var date = '';
            var day = '';
            var month = '';
            var year = '';
            var pr_date = '';
            var assign_date = '';
            data.forEach(function(item, index) {
                pr_date = '';
                assign_date = '';
                if(item.inv_requisition_po_date != null){
                    date = new Date(item.inv_requisition_po_date);
                    day = date.getDate();
                    month = date.getMonth() + 1; 
                    year = date.getFullYear();
                    pr_date = padZero(day) + "/" + padZero(month) + "/" + year;
                }
                if(item.assign_at != null){
                    date = new Date(item.assign_at);
                    day = date.getDate();
                    month = date.getMonth() + 1; 
                    year = date.getFullYear();
                    assign_date = padZero(day) + "/" + padZero(month) + "/" + year;
                }

                var rowData = [
                    ++index,
                    item.department_name,
                    item.emp_name,
                    item.inv_requisition_po_no_fk,
                    pr_date,
                    assign_date,

                    `<a style="cursor:pointer" class="open-modal btn btn-info btn-sm text-white"
                                        data-action="{{ route('v2.partial-pr-status', '') }}/${item.inv_requisition_po_no_fk}"
                                        data-id="${item.inv_requisition_po_no_fk}" data-modal="common-modal-md"
                                        data-title="Assign Details" title="Assign Detailsn">
                                       <i class="fas fa-eye"></i>
                                    </a>
                    `,
                    `
                        <a href="{{ route('v1.pr-print', '') }}/${item.inv_requisition_po_no_fk}" target="_blank" class="btn btn-sm btn-primary" Title="PR Print"><i class="fas fa-print"></i></a>
                    `,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw(); 
        }

        function setTablePRStatusData(data){

            $('.pr_assigned_status_table tbody').empty();
            var rows = [];
            if($.fn.DataTable.isDataTable('.pr_assigned_status_table')) {
                $('.pr_assigned_status_table').DataTable().destroy();
            }
            var table = $('.pr_assigned_status_table').DataTable({
                        paging: true,
                        searching: true,
                        columnDefs: [
                                { targets: [0,3,4,5,7], className: 'text-center' },
                                { targets: [1,2,6], className: 'text-left' }
                            ]
                    });

            var status = "";
            var date = '';
            var day = '';
            var month = '';
            var year = '';
            var pr_date = '';
            var assigned_date = '';
            var revoked = '';
            var po_ind = '';
            data.forEach(function(item, index) {
                pr_date = '';
                if(item.inv_requisition_po_date != null){
                    date = new Date(item.inv_requisition_po_date);
                    day = date.getDate();
                    month = date.getMonth() + 1; 
                    year = date.getFullYear();
                    pr_date = padZero(day) + "/" + padZero(month) + "/" + year;
                }

                assigned_date = '';
                if(item.assign_at != null){
                    date = new Date(item.assign_at);
                    day = date.getDate();
                    month = date.getMonth() + 1; 
                    year = date.getFullYear();
                    assigned_date = padZero(day) + "/" + padZero(month) + "/" + year;
                }


                revoked = '';
                po_ind = '';

                if((item.revoked_ind) == '1')
                        revoked = '<span class="badge badge-success">Yes</span>';
                else
                        revoked = '<span class="badge badge-danger">No</span>';


                if((item.po_ind) == '1')
                    po_ind = '<span class="badge badge-success">Yes</span>';
                else
                    po_ind = '<span class="badge badge-danger">No</span>';


                var rowData = [
                    ++index,
                    item.department_name,
                    item.emp_name,
                    item.inv_requisition_po_no_fk,
                    pr_date,
                    assigned_date,
                    item.item_name,
                    revoked,
                    po_ind,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw(); 
        }

        function emptyPRStatusTable(){
    
            $('.pr_assigned_status_table tbody').empty();
            $('.pr_assigned_status_table tbody').append(`
                <tr>
                    <td colspan="9" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }
        function emptyTable(){
            $("#employee_field").hide();
            $('.pr_not_assigned_table tbody').empty();
            $('.pr_not_assigned_table tbody').append(`
                <tr>
                    <td colspan="9" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }

        function emptyAssignedTable(){
            $('.pr_assigned_table tbody').empty();
            $('.pr_assigned_table tbody').append(`
                <tr>
                    <td colspan="8" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }

        $('.print-button').on('click', function() {
            print(this);
        });

        function print(element) {
            if($('#assignedPrStatus').hasClass('active')){
                assignedPRPDF($(element).attr('reportType'));
                return false;
            }

            var url = "{{ route('v2.pr-asign-pdf') }}";
            var print_id = $(element).attr('reportType');
             url = url.replace(":type", print_id);
            $('#report_type').val(print_id);
            $(element).closest('form').attr('action', url);
            $('#searchPR').submit();
        }

        function assignedPRPDF(type){

            var pr_no = $("#pr_no").val();
            var from_date = $("#from_date").val();
            var to_date = $("#to_date").val();
            var department = $("#department").val();
            var emp_name_search = $("#emp_name_search").val();
            var emp_id_search = $("#emp_id_search").val();

            if(type == 'EXCEL'){
                var url = '{{route('v2.pr-status-excel')}}';
            }
            else if(type == 'PDF'){
                var url = '{{route('v2.pr-status-pdf')}}';
            }
            $.ajax({
            url: url,
            method: 'post',
            data:{from_date:from_date,to_date:to_date,department:department,emp_name_search:emp_name_search,emp_id_search:emp_id_search},
    
            xhrFields: {
                responseType: 'blob' 
            },
            success: function(data) {
                var downloadLink = document.createElement('a');
                var url = window.URL.createObjectURL(new Blob([data]));
                downloadLink.href = url;
                if(type == 'EXCEL')
                    downloadLink.setAttribute('download', 'assigned_status.xls');
                else if(type == 'PDF')                     
                    downloadLink.setAttribute('download', 'assigned_status.pdf');
                document.body.appendChild(downloadLink);
                downloadLink.click();
                document.body.removeChild(downloadLink);
                window.URL.revokeObjectURL(url);
            },
            error: function(xhr, status, error) {
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error);
            }
            });
        }
</script>
