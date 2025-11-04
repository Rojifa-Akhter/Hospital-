<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .text-left{
        text-align:left;
    }
</style>
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Role Setup</h5>
                            <small>Settings / Role Setup</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="post" id="roleSave" class="roleSave">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="row">


                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="role_name" class="col-sm-4 col-form-label">Role Name<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="role_name" name="role_name" placeholder="Role Name" value="" />
                                            </div>
                                        </div>

                                        <div class="form-group form-row">
                                            <label for="role_code" class="col-sm-4 col-form-label">Role Code<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="role_code" name="role_code" placeholder="Role Code" value="" />
                                            </div>
                                        </div>

                                        <div class="form-group form-row">
                                            <label for="notes" class="col-sm-4 col-form-label">Notes</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control custom_area" id="notes" rows="3" name="notes" placeholder="Notes"></textarea>
                                            </div>
                                        </div>

                                    </div>

                                    <div class="col-md-6 col-12">
                                 
                                        <div class="form-group form-row">
                                            <label for="end_range" class="col-sm-4 col-form-label">Copy Role Permission</label>
                                            <div class="col-sm-8">
                                                <select class="form-control"  id="copy_role" name="copy_role">
                                                    <option value="">--Copy Role Permission--</option>
                                                    @foreach ($roles as $item)
                                                        @if($item->status == 1)
                                                            <option value="{{$item->role_no_pk}}">{{ $item->role_name}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                

                                    
                                        <div class="form-group form-row ">
                                            <label for="status" class="col-sm-4 col-form-label">Status</label>
                                            <div class="col-sm-8">
                                                <label>
                                                    <input type="checkbox" value="1" id="status" name="status"/>
                                                </label>
                                            </div>
                                        </div>
                                     
                                    </div>                                                             
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="" onclick="roleSaveForm()">Save</button>
                                        </li>                                    
                                    </ul>
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
                            <div class="table-responsive">
                                <table class="table table-striped table-bordered table-hover role_v1" id="roleTable">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center" style="width: 10%">SL No</th>
                                            <th class="text-center">Role Name</th>
                                            <th class="text-center">Role Code</th>
                                            <th class="text-center">Status</th>
                                            <th class="text-center">Action</th>
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
    </section>
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $("#roleSave").validate({
        rules:{
            role_name:{
                required:true,
                minlength:5,
                maxlength:200,
                notOnlySpaces: true
            },
            role_code:{
                minlength:1,
                maxlength:50,
                notOnlySpaces: true
            },
            notes:{
                maxlength:500
            }
        },
        messages:{
            role_name:{
                required: "Role Name Required",
            }
        }
    });
</script>

<script>
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        <!-- Fetch Table Data -->
            getRole();

            function getRole(){
                    $.ajax({
                    url: "{{route('v1.settings.get-role')}}",
                    method: "get",
                    success: function(response){
                        if(response.data.length != 0)
                        {
                        setTableData(response.data);
                        }                       
                        else
                        {
                            emptyTable();
                        }
                        
                    },
                    error:function(err){
                        var error = err.responseJSON;
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html('Failed');
                        $('.common-modal-notify-error .modal-body').html(error.message); 
                    }
                })
            }

        $(document).ready(function(){
            $('#roleTable').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 2, 3], className: 'text-center' },
                        { targets: [1], className: 'text-left' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            $('th').addClass('text-center');
        })

        <!-- Submit Form Data -->
        function roleSaveForm(){
            if($('#roleSave').valid()){ 
                let formElement = document.querySelector('#roleSave');
                let formData = new FormData(formElement);

                $.ajax({
                    url:"{{route('v1.settings.save-role')}}",
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
                        if(data.data.length != 0)
                        setTableData(data.data);   
                        $('#roleSave').trigger('reset');
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
        }
        
        <!-- Set Table Data -->
        function setTableData(data){
            $('.role_v1 tbody').empty();          
            var rows = [];
            var table = $('#roleTable').DataTable();
            var status = "";
            data.forEach(function(item, index) {
                  if((item.status) == '1')
                        status = '<span class="badge badge-success">Active</span>';
                    else
                        status = '<span class="badge badge-danger">Inactive</span>';

                var rowData = [
                    ++index,
                    item.role_name,
                    item.role_code,
                    status,
                    '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.settings.edit-role','')}}/'+item.role_no_pk+'" data-modal="common-modal-sm" data-title="Edit Role Setup" title="Edit Role Setup" data-id="'+item.role_no_pk+'"><i class="fas fa-edit"></i></span>',
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            
        }

        function emptyTable(){
            $('.role_v1 tbody').empty();
            $('.role_v1 tbody').append(`
                <tr>
                    <td colspan="5" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>
