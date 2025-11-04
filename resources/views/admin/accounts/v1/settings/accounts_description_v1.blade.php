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
$data = collect($account_type->getData()->data)->sortBy('acc_3grouptype_code')->values();


@endphp
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Account Description</h5>
                            <small>Accounts / Account Description</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="post" id="accountsDescriptionSave" class="accountsDescriptionSave">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="acc_4type_no_fk" class="col-sm-4 col-form-label">Acc. Type Name<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm select2" name="acc_4type_no_fk" id="acc_4type_no_fk">
                                                    <option value="" disabled selected>Select one</option>
                                                    @foreach ($data as $item)
                                                        @if($item->status == 1)
                                                            <option value="{{$item->acc_4type_no_pk}}">{{ $item->acc_4type_code}} - {{ $item->acc_4type_name }} @if(!empty($item->acc_code_range_4_start) && ($item->acc_code_range_4_end)) ( {{$item->acc_code_range_4_start}} - {{ $item->acc_code_range_4_end}} ) @endif</option>
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
                                            <label for="account_description_name" class="col-sm-4 col-form-label">Acc. Description Name<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="account_description_name" name="account_description_name" placeholder="Account Description Name" value="" />
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
                                            <label for="account_description_code" class="col-sm-4 col-form-label">Acc. Description Code<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="account_description_code" name="account_description_code" placeholder="Account Description Code" value="" />
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
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="" onclick="accountsDescriptionSaveForm()">Save</button>
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
                                <table class="table table-striped table-bordered table-hover accounts_description_v1" id="accountsGroupTypeDataTable">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center" style="width:5%">SL No</th>
                                            <th class="text-center" style="width:27%">Account Type Name</th>
                                            <th class="text-center" style="width:27%">Account Description Name</th>
                                            <th class="text-center" style="width:15%">Account Description Code</th>
                                            <th class="text-center" style="width:8%">Start Range </th>
                                            <th class="text-center" style="width:8%">End Range </th>
                                            <th class="text-center" style="width:15%">Status</th>
                                            <th class="text-center" style="width:15%">Action</th>
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
    $("#accountsDescriptionSave").validate({
        rules:{
            acc_4type_no_fk:{
                required:true, 
            },
            account_description_name:{
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
            account_description_code:{
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
            acc_4type_no_fk:{
                required: "Account Type Name Required", 
            },
            account_description_name:{
                required: "Account Description Required",
            },
            account_description_code:{
                required: "Account Description Code Required",
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
            getAccountsDescription();

            function getAccountsDescription(){
                    $.ajax({
                    url: "{{route('v1.accounts.get-accounts-description')}}",
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

            $('#accountsGroupTypeDataTable').DataTable({
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
        function accountsDescriptionSaveForm(){
            if($('#accountsDescriptionSave').valid()){ 
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
                let formElement = document.querySelector('#accountsDescriptionSave');
                let formData = new FormData(formElement);
                $.ajax({
                    url:"{{route('v1.accounts.save-accounts-description')}}",
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
                        $('#acc_4type_no_fk').val(null).trigger('change');
                        $('#accountsDescriptionSave').trigger('reset');
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
            $('.accounts_description_v1 tbody').empty();          
            var rows = [];
            var table = $('#accountsGroupTypeDataTable').DataTable();
            var status = "";
            data.forEach(function(item, index) {
                  if((item.status) == '1')
                        status = '<span class="badge badge-success">Active</span>';
                    else
                        status = '<span class="badge badge-danger">Inactive</span>';

                var rowData = [
                    ++index,
                    '<span>'+item.acc_4type_code+' - '+item.acc_4type_name+'</span>',
                    item.acc_5type_description,
                    item.type_code,
                    item.acc_code_range_5_start,
                    item.acc_code_range_5_end,
                    status,
                    '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.accounts.edit-accounts-description','')}}/'+item.acc_5typedescription_no_pk+'" data-modal="common-modal-sm" data-title="Edit Account Description" title="Edit Account Description" data-id="'+item.acc_5typedescription_no_pk+'"><i class="fas fa-edit"></i></span>',
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            
        }
        function emptyTable(){
            $('.accounts_description_v1 tbody').empty();
            $('.accounts_description_v1 tbody').append(`
                <tr>
                    <td colspan="8" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>
