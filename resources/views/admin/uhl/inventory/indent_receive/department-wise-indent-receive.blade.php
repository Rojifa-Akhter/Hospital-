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
                            <h5 class="mt-2 mb-0">Department Wise Indent Receive</h5>
                            <small>Inventory / Department Wise Indent Receive</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="{{ route('v2.pr-asign-pdf') }}" method="post" id="searchIndent" class="searchIndent">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row justify-content-center">

                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="indent_no" class="col-form-label">Indent No</label>
                                            <div>
                                                <input type="text" class="form-control form-control-sm" id="indent_no" name="indent_no" placeholder="Indent No" value="" />
                                                <input type="hidden" id="report_type" name="report_type" value="">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="department" class="col-form-label">From Department</label>
                                            <div>
                                                <select class="form-control form-control-sm" id="department" name="department">
                                                    <option value="">All</option>
                                                    @foreach($grant_su as $item)
                                                    <option value="{{$item->serviceunit_no_pk}}">{{$item->serviceunit_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 col-12">
                                        <div class="form-group">
                                            <label for="from_date" class="col-form-label">From/To Date</label>
                                            <div>
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm thirtyDaysAgo" id="from_date" name="from_date" placeholder="From Date" value="" />
                                                    <input type="text" class="form-control form-control-sm date_picker" id="to_date" name="to_date" placeholder="To Date" value="" />
                                                </div>                                              
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-3 col-12">
                                        <label for="indent_no" class="col-form-label">Action</label>
                                        <div>
                                            <button type="button" class="btn btn-primary btn-md-global" id="" onclick="searchIndent(true)"><i class="fa fa-search text-white"></i>  Search</button>                               
                                            <!-- <button type="button" id="btnReportGRN" class="btn btn-warning btn-md-global" target="_blank" onclick="print(this)" reportType="PDF">
                                            <i class="fa fa-download"></i> PDF</button>
                                            <button type="submit" class="btn btn-primary btn-md-global" target="_blank" reportType="EXCEL" onclick="print(this)">
                                                <i class="fa fa-download text-white"></i> Excel
                                            </button> -->
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
                                            <a class="nav-link active" id="not-pr-assigned" data-toggle="tab" href="#not-assigned" role="tab" aria-controls="not-assigned" aria-selected="true" onclick="searchIndent('not')">Receive Pending<span class="badge badge-secondary"></span></a>
                                        </li>
        
                                        <li class="nav-item">
                                            <a class="nav-link " id="received-indent" data-toggle="tab" href="#received" role="tab" aria-controls="received-indent" aria-selected="true" onclick="searchIndent('assinged')">Received<span class="badge badge-secondary"></span></a>
                                        </li>

                                    </ul>



                                    <div class="tab-content p-0" id="myTabContent">   
                                        <!-- Not Assigned PR -->                       
                                        <div class="tab-pane fade show active" id="not-assigned" role="tabpanel" aria-labelledby="not-pr-assigned">  
                                            <div class="table-responsive pt-2">
                                                <table class="table table-striped table-bordered table-hover receive_pending_table">
                                                    <thead class="global-uhl-table-bg">
                                                        <tr>
                                                            <th class="text-center" style="width:3%">#SL</th>
                                                            <th class="text-center" style="width:5%">Indent No</th>
                                                            <th class="text-center" style="width:7%">Indent Date</th>
                                                            <th class="text-center" style="width:13%">From Dept.</th>
                                                            <th class="text-center" style="width:13%">To Dept.</th>
                                                            <th class="text-center" style="width:10%">Req. By</th>
                                                            <th class="text-center" style="width:10%">Ref. Req. No</th>
                                                            <th class="text-center" style="width:19%">Remarks</th>
                                                            <th class="text-center" style="width:5%">Is Exact</th>
                                                            <th class="text-center" style="width:5%">Status</th>
                                                            <th class="text-center" style="width:10%">Action</th>
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

                                        <!-- Assigned PR -->
                                        <div class="tab-pane fade " id="received" role="tabpanel" aria-labelledby="received-indent">
                                            <div style="overflow-x: auto">
                                                <div class="table-responsive">
                                                    <table class="table table-striped table-bordered table-hover received_table">
                                                        <thead class="global-uhl-table-bg">
                                                            <tr>
                                                                <th class="text-center" style="width:3%">#SL</th>
                                                                <th class="text-center" style="width:5%">Indent No</th>
                                                                <th class="text-center" style="width:7%">Indent Date</th>
                                                                <th class="text-center" style="width:13%">From Dept.</th>
                                                                <th class="text-center" style="width:13%">To Dept.</th>
                                                                <th class="text-center" style="width:10%">Requst By</th>
                                                                <th class="text-center" style="width:9%">Received By</th>
                                                                <th class="text-center" style="width:10%">Ref. Req. No</th>
                                                                <th class="text-center" style="width:13%">Remarks</th>
                                                                <th class="text-center" style="width:5%">Is Exact</th>
                                                                <th class="text-center" style="width:5%">Status</th>
                                                                <th class="text-center" style="width:7%">Action</th>            
                                                            </tr>
                                                        </thead>
                    
                                                        <tbody>
                                                            <tr>
                                                                <td colspan="12" class="text-center">Data Fetching ...</td>
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
<script>
    $("body").addClass("sidebar-collapse");
    $(document).ready(function(){

        var currentDate = new Date();
        var thirtyDaysAgo = new Date();
            thirtyDaysAgo.setDate(currentDate.getDate() - 30);
        $('.date_picker').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy',
        }).datepicker('setDate', currentDate);

        $('.thirtyDaysAgo').datepicker({
            todayHighlight: true,
            clearBtn: true,
            autoclose: true,
            changeMonth: true,
            changeYear: true,
            format: 'dd/mm/yyyy',
        }).datepicker('setDate', thirtyDaysAgo);


        searchIndent();
    })
</script>

<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        
        function searchIndent(search = null){
            
                let formElement = document.querySelector('#searchIndent');
                let formData = new FormData(formElement);
                $.ajax({
                url: "{{route('v1.department-wise-indent')}}",
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
                    if(response.receive_indent.length != 0){
                        setTableReceiveIndent(response.receive_indent);
                    }
                    else{
                        emptyTableReceiveIndent();
                    }

                    if(response.received_indent.length != 0){
                        setTableReceivedIndent(response.received_indent);
                    }
                    else{
                        emptyTableReceivedIndent();
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
       function receiveRequest(){
                let formElement = document.querySelector('#receiveRequest');
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
                        searchIndent();
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
        function setTableReceiveIndent(data){
            console.log('receive_indent', data);
            $('.receive_pending_table tbody').empty();
            var rows = [];
            if($.fn.DataTable.isDataTable('.receive_pending_table')) {
                $('.receive_pending_table').DataTable().destroy();
            }
            var table = $('.receive_pending_table').DataTable({
                        paging: true,
                        searching: true,
                        columnDefs: [
                                { targets: [0,1,2,6, 8,9,10], className: 'text-center' },
                                { targets: [3,4,5,7], className: 'text-left' }
                            ]
                    });

            var status = "";
            var date = '';
            var day = '';
            var month = '';
            var year = '';
            var indent_date = '';
            var actions = ``;
            data.forEach(function(item, index) {
                indent_date = '';
                if(item.req_at != null){
                    date = new Date(item.req_at);
                    day = date.getDate();
                    month = date.getMonth() + 1; 
                    year = date.getFullYear();
                    indent_date = padZero(day) + "/" + padZero(month) + "/" + year;
                }


                actions = `<a href="{{ route('v1.department-received-print', '') }}/${item.inv_requisition_no_pk }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>`;
                actions+= `<a href="{{ route('v1-item-receive.create', '') }}?requisition_no=${item.inv_requisition_no_pk}" rel="tab" class="ml-1 btn btn-sm uhl_common_btn text-white" style="opacity: 1!important;" >Receive</a>`;

                var rowData = [
                    ++index,
                    item.inv_requisition_uid,
                    indent_date,
                    item.from_stor,
                    item.to_store,
                    // item.req_type,
                    item.user_name,
                    item.ref_indent_no_fk != 0 ? item.ref_indent_no_fk : 'N/A',
                    item.indent_remarks,
                    `<span class="badge ${item.urgent != 0 ? 'badge-success' : 'badge-danger'}">${item.urgent != 0 ? 'Yes' : 'No'}</span>`,
                    `<span class="badge ${item.exact != 0 ? 'badge-success' : 'badge-danger'}">${item.exact != 0 ? 'Yes' : 'No'}</span>`,
                    actions,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
        }

        function emptyTableReceiveIndent(){
            $('.receive_pending_table tbody').empty();
            $('.receive_pending_table tbody').append(`
                <tr>
                    <td colspan="11" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }

        function padZero(number) {
            return number < 10 ? "0" + number : number;
        }

        function setTableReceivedIndent(data){
            console.log('received_indent', data);
            $('.received_table tbody').empty();
            var rows = [];
            if($.fn.DataTable.isDataTable('.received_table')) {
                $('.received_table').DataTable().destroy();
            }
            var table = $('.received_table').DataTable({
                        paging: true,
                        searching: true,
                        columnDefs: [
                                { targets: [0,1,2,7,9,10,11], className: 'text-center' },
                                { targets: [3,4,5,6,8], className: 'text-left' }
                            ]
                    });

            var status = "";
            var date = '';
            var day = '';
            var month = '';
            var year = '';
            var indent_date = '';
            var actions = ``;
            data.forEach(function(item, index) {
                indent_date = '';
                if(item.req_at != null){
                    date = new Date(item.req_at);
                    day = date.getDate();
                    month = date.getMonth() + 1; 
                    year = date.getFullYear();
                    indent_date = padZero(day) + "/" + padZero(month) + "/" + year;
                }

                actions = `<a href="{{ route('v1.department-received-print', '') }}/${item.inv_requisition_no_pk }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>`;
                actions+= `<a href="{{ route('v1-item-receive.create', '') }}?requisition_no=${item.inv_requisition_no_pk}" rel="tab" class="ml-1 btn btn-sm uhl_common_btn text-white" style="opacity: 1!important;" >Received</a>`;

                var rowData = [
                    ++index,
                    item.inv_requisition_uid,
                    indent_date,
                    item.from_stor,
                    item.to_store,
                    // item.req_type,
                    item.user_name,
                    item.recv_by_name,
                    item.ref_indent_no_fk != 0 ? item.ref_indent_no_fk : 'N/A',
                    item.indent_remarks,
                    `<span class="badge ${item.urgent != 0 ? 'badge-success' : 'badge-danger'}">${item.urgent != 0 ? 'Yes' : 'No'}</span>`,
                    `<span class="badge ${item.exact != 0 ? 'badge-success' : 'badge-danger'}">${item.exact != 0 ? 'Yes' : 'No'}</span>`,
                    actions,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw(); 
        }

        function emptyTableReceivedIndent(){
            $('.received_table tbody').empty();
            $('.received_table tbody').append(`
                <tr>
                    <td colspan="12" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }

        $('.print-button').on('click', function() {
            print(this);
        });

        function print(element) {
            var url = "{{ route('v2.pr-asign-pdf') }}";
            var print_id = $(element).attr('reportType');
             url = url.replace(":type", print_id);
            $('#report_type').val(print_id);
            $(element).closest('form').attr('action', url);
            $('#searchIndent').submit();
        }


</script>
