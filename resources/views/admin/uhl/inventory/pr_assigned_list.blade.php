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
                            <h5 class="mt-2 mb-0">Assigned Purchase Requisition</h5>
                            <small>Inventory / Assigned Purchase Requisition</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="post" id="searchPR" class="searchPR">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-md-3 col-12">
                                        <div class="form-group form-row">
                                            <label for="pr_no" class="col-sm-4 col-form-label">PR No</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="pr_no" name="pr_no" placeholder="PR No" value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-3 col-12">
                                        <div class="form-group form-row">
                                            <label for="department" class="col-sm-4 col-form-label">Department</label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm" id="department" name="department">
                                                    <option value="">All</option>
                                                    @foreach($main_store_list as $item)
                                                    <option value="{{$item->serviceunit_no_pk}}">{{$item->serviceunit_name}}</option>
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-4 col-12">
                                        <div class="form-group form-row">
                                            <label for="from_date" class="col-sm-4 col-form-label">From/To Date</label>
                                            <div class="col-sm-8">
                                                <div class="input-group">
                                                    <input type="text" class="form-control form-control-sm sevenDaysAgo" id="from_date" name="from_date" placeholder="From Date" value="" />
                                                    <input type="text" class="form-control form-control-sm date_picker" id="to_date" name="to_date" placeholder="To Date" value="" />
                                                </div>                                              
                                            </div>
                                        </div>
                                    </div>
                                    <div class="col-md-2 col-12">
                                        <button type="button" class="btn btn-secondary btn-md uhl_save_btn w-100" id="" onclick="searchPR(true)">Search</button>                             
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
                                    <!-- Assigned PR -->                                     
                                    <div style="overflow-x: auto">
                                        <div class="table-responsive">
                                            <table class="table table-striped table-bordered table-hover pr_assigned_table">
                                                <thead class="global-uhl-table-bg">
                                                    <tr>
                                                        <th class="text-center" style="width:7%">#SL</th>
                                                        <th class="text-center" style="width:11%">Department</th>
                                                        <th class="text-center" style="width:7%">PR No</th>
                                                        <th class="text-center" style="width:10%">PR Date</th>
                                                        <th class="text-center" style="width:25%">Remarks</th>
                                                        <th class="text-center" style="width:10%">Approval Status</th>
                                                        {{-- <th class="text-center" style="width:10%">Assigned To</th> --}}
                                                        <th class="text-center" style="width:10%">Assigned At</th>
                                                        <th class="text-center" style="width:10%">Action</th>                 
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

                let formElement = document.querySelector('#searchPR');
                let formData = new FormData(formElement);

                $.ajax({
                url: "{{route('v2.search-assigned-pr-list')}}",
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
                    if(response.data.length != 0){
                        setTableData(response.data);
                    }
                    else{
                        emptyTable();
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



        function padZero(number) {
            return number < 10 ? "0" + number : number;
        }
        
        <!-- Set Table Data -->
        function setTableData(data){

            $('.pr_assigned_table tbody').empty();
            var rows = [];
            if($.fn.DataTable.isDataTable('.pr_assigned_table')) {
                $('.pr_assigned_table').DataTable().destroy();
            }
            var table = $('.pr_assigned_table').DataTable({
                        paging: false,
                        searching: true,
                        columnDefs: [
                                { targets: [0,1,2,3,5,6,7], className: 'text-center' },
                                { targets: [4], className: 'text-left' }
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
            var assign_at = '';
            data.forEach(function(item, index) {

                pr_date = '';
                if(item.req_at != null){
                    date = new Date(item.req_at);
                    day = date.getDate();
                    month = date.getMonth() + 1; 
                    year = date.getFullYear();
                    pr_date = padZero(day) + "/" + padZero(month) + "/" + year;
                }

                assign_date = '';
                if(item.assign_at != null){
                    date = new Date(item.assign_at);
                    day = date.getDate();
                    month = date.getMonth() + 1; 
                    year = date.getFullYear();
                    assign_date = padZero(day) + "/" + padZero(month) + "/" + year;
                }







                approvalLevelStatusText = item.approval_status_text;
                approvalStatusText = item.approval_status_text;

                if(approvalStatusText.indexOf('REJECTED') >= 0 || approvalStatusText.indexOf('HOLD') >= 0){
                    approve_text = `<a style="cursor:pointer" class="open-modal"
                        data-action="{{ route('v1.my.approval.level.detail-pr-list','') }}/${item.inv_requisition_po_no_pk}"
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
                    // item.assign_by,
                    assign_date,
                    `
                    
                    <a style="cursor:pointer" class="open-modal btn btn-info btn-sm text-white"
                                        data-action="{{ route('v2.revoke-pr-assign', '') }}/${item.prassignmst_no_pk}"
                                        data-id="${item.prassignmst_no_pk}" data-modal="common-modal-sm"
                                        data-title="Revoke Item" title="Revoke Item">
                                        Revoke
                    </a>
                    <a href="{{ route('v1.pr-print', '') }}/${item.inv_requisition_po_no_pk}" target="_blank" class="btn btn-sm btn-primary" Title="PR Print"><i class="fas fa-print"></i></a>
                    <a href="{{ route('v2.assigned-pr-pdf', '') }}/${item.prassignmst_no_pk}" target="_blank" class="btn btn-sm btn-info" Title="Assigned PR"><i class="fas fa-print"></i></a>
                    `,
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw(); 
        }

        // function updateSubmit(pr){
        //     if(confirm('Are you sure?')){
        //         $.ajax({
        //                 url:"{{route('v2.inventory.ready-to-post','')}}/"+`${pr}`,
        //                 type:"get",
        //                 beforeSend: function() {
        //                     blockUI();
        //                 },
        //                 success:function(response){
        //                     searchPOWorklistForm();
        //                     $('.common-modal-notify').modal('show');
        //                     $('.common-modal-notify .modal-title').html('Success');
        //                     $('.common-modal-notify .modal-body').html(response.message);
        //                 },
        //                 error:function(err){
        //                     $.unblockUI();
        //                     var error = err.responseJSON;
        //                     $('.common-modal-notify-error').modal('show');
        //                     $('.common-modal-notify-error .modal-title').html('Failed');
        //                     $('.common-modal-notify-error .modal-body').html(error.message);
        //                 },
        //                 complete: function() {
        //                 $.unblockUI();
        //             }
        //         })
        //     }
        // }
        function emptyTable(){
            $('.pr_assigned_table tbody').empty();
            $('.pr_assigned_table tbody').append(`
                <tr>
                    <td colspan="8" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }
</script>
