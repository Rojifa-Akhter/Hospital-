<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<style>
    .error{
        color:red !important;
        font-size: 12px;
    }
    .roleTable tbody td{
        vertical-align:top
    }
    .pl-second{
        padding-left:50px !important;
    }
    .pl-third{
        padding-left: 70px !important;
    }
    .second-icon{
        font-size: 14px;
        color:#5253569e;
    }
    .third-icon{
        font-size: 12px;
        color:#B4B5B6;
    }
</style>

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Check User Role Permission</h5>
            <small>Settings / Role Permission / Check User Role Permission</small>
        </div>
    </div>

    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-header text-center bg-primary text-white">
                    <div class="text-center" style="font-size:15px">Check User Role Permission</div>       
                </div>
                <div class="card-body p-2">                    
                    <div class="row justify-content-center">
                        <div class="col-md-4 col-12">
                         
                            <select id="hospital" name="hospital" class="form-control" onchange="getUsers(this.value)">
                                <option value="" selected disabled>Select Hospital</option>
                                @foreach ($hospitals as $item)
                                    @if($item->status == 1)
                                    <option value="{{$item->hospital_no_pk}}">{{$item->hospital_name}}</option>
                                    @endif
                                @endforeach
                            </select>
                        </div>

                        <div class="col-md-4 col-12">
                         
                                <select id="userlist" name="user" class="form-control select2"  onchange="getUsersPermission(this.value)">
                                    <option value="" selected disabled>Select User</option>
                                    @foreach ($users as $item)
                                        @if($item->status == 1 && !empty($item->user_fullname))
                                        <option value="{{$item->user_no_pk}}" data-role="{{$item->role_no_fk}}"> @if(!empty($item->user_code)){{$item->user_code}} - @endif {{$item->user_fullname}}  @if(!empty($item->role_name)) - {{$item->role_name}} @endif  </option>
                                        @endif
                                    @endforeach
                                </select>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<div class="container-fluid">
    <div class="row justify-content-center">
        <div class="col-md-11">
            <div class="card">
                <div class="card-body">
                    <div class="table-responsive">
                        <table class="table table-striped table-bordered table-hover check_user_permission_v1" id="checkUserPrivsDataTable">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center" style="width:7%">SL No</th>
                                    <th class="text-center" style="width:8%">Priviledge</th>
                                    <th class="text-center" style="width:25%">Feature</th>
                                    <th class="text-center" style="width:15%">Role</th>
                                    <th class="text-center" style="width:10%">Grant Date </th>
                                    <th class="text-center" style="width:29%">Grant By</th>
                                    <th class="text-center" style="width:6%">Status</th>          
                                </tr>
                            </thead>

                            <tbody>
           
                            </tbody>
                        </table>
                    </div>

                </div>
            </div>
        </div>
    </div>
</div>


<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>

<script>
    $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        $(document).ready(function() {
            $('.select2').select2();

            // $('#checkUserPrivsDataTable').DataTable({
            //     columnDefs: [
            //             { targets: [1], className: 'text-center' },
            //         ],
            //     });
        });

        function getUsers(id){
                    if(id){                       
                        $.ajax({
                        url:"{{route('v1.settings.get-user-list','')}}/"+id,
                        method: 'get',
                        beforeSend: function() {
                                blockUI();
                        },
                        success:function(res){  
                            $('#userlist').empty();
                            $('#userlist').html(res);
                        },
                        error:function(err){
                            $.unblockUI();
                            emptyTable();
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
        }


        emptyTable();
        function getUsersPermission(id){
             
                url = "{{route('v1.settings.check-user-role-permission','')}}/"+id;
                if(id != ''){
                        $.ajax({
                        url: url,
                        method: "get",
                        beforeSend: function() {
                                blockUI();
                            },
                        success: function(response){
                            $.unblockUI();
                            if(response.data.length != 0)
                                setTableData(response.data);                     
                            else
                                emptyTable();

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
        }

        function setTableData(data){
            $('.check_user_permission_v1 tbody').empty();          
            var rows = [];
            var table = $('#checkUserPrivsDataTable').DataTable();
            var status = "";

            var date = "";
            var options = "";
            var formattedDate = "";
            data.forEach(function(item, index) {
                  if((item.status) == '1')
                        status = '<span class="badge badge-success">Active</span>';
                    else
                        status = '<span class="badge badge-danger">Inactive</span>';
          
                if(item.grant_dt != null){
                    date = new Date(item.grant_dt);
                    options = { year: 'numeric', month: 'short', day: 'numeric' };
                    formattedDate = date.toLocaleDateString('en-US', options);
                }
                    
                var rowData = [
                    ++index,
                    item.privs,
                    item.features_name,
                    item.role_name,
                    formattedDate,
                    item.user_fullname,
                    status
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            
        }
        function emptyTable(){
            $('.check_user_permission_v1 tbody').empty();
            $('.check_user_permission_v1 tbody').append(`
                <tr>
                    <td colspan="7" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>

