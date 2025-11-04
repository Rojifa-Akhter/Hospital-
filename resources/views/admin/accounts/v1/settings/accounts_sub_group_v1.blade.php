<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<style>
    .select2-container .select2-dropdown {
        width: 400px !important; /* Specify the desired width here */        
    }
    .select2-selection__rendered{
        text-align: left !important;     
    }
    .select2-results__option{
        font-size: 12px !important;
    }
    .text-left{
        text-align:left;
    }
</style>
@php 
$data = collect($account_group->getData()->data)->sortBy('acc_1group_code')->values();


@endphp
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Accounts Sub Group</h5>
                            <small>Accounts / Accounts Sub Group</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="post" id="accountsSubGroupSave" class="accountsSubGroupSave">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="account_group_fk" class="col-sm-4 col-form-label">Account Group Name<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm select2" name="account_group_fk" id="account_group_fk">
                                                    <option value="" disabled selected>Select one</option>
                                                    @foreach ($data as $item)
                                                        @if($item->status == 1)
                                                            <option value="{{$item->acc_1group_no_pk}}">{{ $item->acc_1group_code}} - {{ $item->acc_1group_name }} @if(!empty($item->acc_code_range_1_start) && ($item->acc_code_range_1_end)) ( {{$item->acc_code_range_1_start}} - {{ $item->acc_code_range_1_end}} ) @endif</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="start_range" class="col-sm-4 col-form-label">Start Range Code</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="number" id="start_range" name="start_range" placeholder="Start Range Code">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="account_sub_group_name" class="col-sm-4 col-form-label">Account Sub Group Name<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="account_sub_group_name" name="account_sub_group_name" placeholder="Account Sub Group Name" value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="end_range" class="col-sm-4 col-form-label">End Range Code</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="number" id="end_range" name="end_range" placeholder="End Range Code">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="account_sub_group_code" class="col-sm-4 col-form-label">Account Sub Group Code<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="account_sub_group_code" name="account_sub_group_code" placeholder="Account Sub Group Code" value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row ">
                                            <label for="status" class="col-sm-4 col-form-label">Status</label>
                                            <div class="col-sm-8">
                                                <label>
                                                    <input type="checkbox" value="1" id="status" name="status"/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                                                  
                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="notes" class="col-sm-4 col-form-label">Notes</label>
                                            <div class="col-sm-8">
                                                <textarea class="form-control custom_area" id="notes" rows="3" name="notes" placeholder="Notes"></textarea>
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
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="" onclick="accountsSubGroupSaveForm()">Save</button>
                                        </li>

                                        {{-- <li class="list-inline-item"><button type="button" class="btn btn-danger">Cancel</button></li> --}}
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
                                <table class="table table-striped table-bordered table-hover accounts_sub_group_v1" id="accountsSubGroupDataTable">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">SL No</th>
                                            <th class="text-center">Account Group Name</th>
                                            <th class="text-center">Account Sub Group Name</th>
                                            <th class="text-center">Account Sub Group Code</th>
                                            <th class="text-center">Start Range </th>
                                            <th class="text-center">End Range </th>
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
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $("#accountsSubGroupSave").validate({
        rules:{
            account_group_fk:{
                required:true, 
            },
            account_sub_group_name:{
                required:true,
                minlength:5,
                maxlength:200,
                notOnlySpaces: true
            },
            start_range:{
                maxlength:10, 
            },
            end_range:{
                maxlength:10, 
            },
            account_sub_group_code:{
                required:true,
                minlength:1,
                maxlength:50,
                notOnlySpaces: true
            },
            notes:{
                maxlength:500
            }
        },
        messages:{
            account_group_fk:{
                required: "Account Group Name Required", 
            },
            account_sub_group_name:{
                required: "Account Sub Group Name Required",
            },
            account_sub_group_code:{
                required: "Account Sub Group Code Required",
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
            getAccountsSubGroup();

            function getAccountsSubGroup(){
                    $.ajax({
                    url: "{{route('v1.accounts.get-accounts-sub-group')}}",
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
            $('.select2').select2();

            $('#accountsSubGroupDataTable').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 3, 4, 5, 6], className: 'text-center' },
                        { targets: [1, 2], className: 'text-left' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            $('th').addClass('text-center')
        })

        <!-- Submit Form Data -->
        function accountsSubGroupSaveForm(){
            if($('#accountsSubGroupSave').valid()){ 
                var start_range = $('#start_range').val();
                var end_range = $('#end_range').val();

                if(start_range != '' || end_range != ''){
                    if(start_range == ''){
                        alert('Start Range Required!');
                        return false;
                    }
                    if(end_range == ''){
                        alert('End Range Required!');
                        return false;
                    }
                }
                let formElement = document.querySelector('#accountsSubGroupSave');
                let formData = new FormData(formElement);
                $.ajax({
                    url:"{{route('v1.accounts.save-accounts-sub-group')}}",
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
                        $('#account_group_fk').val(null).trigger('change');
                        $('#accountsSubGroupSave').trigger('reset');
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
            $('.accounts_sub_group_v1 tbody').empty();          
            var rows = [];
            var table = $('#accountsSubGroupDataTable').DataTable();
            var status = "";
            data.forEach(function(item, index) {
                  if((item.status) == '1')
                        status = '<span class="badge badge-success">Active</span>';
                    else
                        status = '<span class="badge badge-danger">Inactive</span>';

                var rowData = [
                    ++index,
                    '<span>'+item.acc_1group_code+' - '+item.acc_1group_name+'</span>',
                    item.acc_2subgroup_name,
                    item.acc_2subgroup_code,
                    item.acc_code_range_2_start,
                    item.acc_code_range_2_end,
                    status,
                    '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.accounts.edit-accounts-sub-group','')}}/'+item.acc_2subgroup_no_pk+'" data-modal="common-modal-sm" data-title="Edit Account Group Name" title="Edit Account Group Name" data-id="'+item.acc_2subgroup_no_pk+'"><i class="fas fa-edit"></i></span>',
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            
        }
        function emptyTable(){
            $('.accounts_sub_group_v1 tbody').empty();
            $('.accounts_sub_group_v1 tbody').append(`
                <tr>
                    <td colspan="8" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>
