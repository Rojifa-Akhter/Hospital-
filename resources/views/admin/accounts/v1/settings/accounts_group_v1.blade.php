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
                            <h5 class="mt-2 mb-0">Accounts Group</h5>
                            <small>Accounts / Accounts Group</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="post" id="accountsGroupSave" class="accountsGroupSave">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="account_group_name" class="col-sm-4 col-form-label">Account Group Name<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="account_group_name" name="account_group_name" placeholder="Account Group Name" value="" />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="account_group_code" class="col-sm-4 col-form-label">Account Group Code<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="account_group_code" name="account_group_code" placeholder="Account Group Code" value="" />
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
                                            <label for="end_range" class="col-sm-4 col-form-label">End Range Code</label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="number" id="end_range" name="end_range" placeholder="End Range Code">
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
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="" onclick="accountsGroupSaveForm()">Save</button>
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
                                <table class="table table-striped table-bordered table-hover accounts_group_v1" id="accountsGroupDataTable">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">SL No</th>
                                            <th class="text-center">Account Group Name</th>
                                            <th class="text-center">Account Group Code</th>
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
<script>
    $("#accountsGroupSave").validate({
        rules:{
            account_group_name:{
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
            account_group_code:{
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
            account_group_name:{
                required: "Account Group Name Required",
            },
            account_group_code:{
                required: "Account Group Code Required",
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
            getAccountsGroup();

            function getAccountsGroup(){
                    $.ajax({
                    url: "{{route('v1.accounts.get-accounts-group')}}",
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
            $('#accountsGroupDataTable').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 2, 3, 4, 5], className: 'text-center' },
                        { targets: [1], className: 'text-left' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]],
                    "pageLength": 10
                });
            $('th').addClass('text-center');
        })

        <!-- Submit Form Data -->
        function accountsGroupSaveForm(){
            if($('#accountsGroupSave').valid()){
                let formElement = document.querySelector('#accountsGroupSave');
                let formData = new FormData(formElement);

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

                $.ajax({
                    url:"{{route('v1.accounts.save-accounts-group')}}",
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

                        $('#accountsGroupSave').trigger('reset');
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
            $('.accounts_group_v1 tbody').empty();
            var rows = [];
            var table = $('#accountsGroupDataTable').DataTable();
            var status = "";
            data.forEach(function(item, index) {
                  if((item.status) == '1')
                        status = '<span class="badge badge-success">Active</span>';
                    else
                        status = '<span class="badge badge-danger">Inactive</span>';

                var rowData = [
                    ++index,
                    item.acc_1group_name,
                    item.acc_1group_code,
                    item.acc_code_range_1_start,
                    item.acc_code_range_1_end,
                    status,
                    '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.accounts.edit-accounts-group','')}}/'+item.acc_1group_no_pk+'" data-modal="common-modal-sm" data-title="Edit Account Group Name" title="Edit Account Group Name" data-id="'+item.acc_1group_no_pk+'"><i class="fas fa-edit"></i></span>',
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();

        }
        function emptyTable(){
            $('.accounts_group_v1 tbody').empty();
            $('.accounts_group_v1 tbody').append(`
                <tr>
                    <td colspan="7" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>
