<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

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
    .position-center{
       /* margin-bottom:-30px  */
    }
</style>
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Cost Center Setup</h5>
                            <small>Accounts / Cost Center Setup</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="post" id="costCenterSave" class="costCenterSave">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="" class="col-sm-4 col-form-label">Department<span style="color:red">*</span></label>
                                            <div class="col-sm-8">                                           
                                                <select name="department" id="department" class="form-control form-control-sm select2">
                                                    <option value="" disabled selected>Select One</option>
                                                    @foreach ($data->getData()->data as $item)
                                                        @if($item->status == 1)
                                                        <option value="{{$item->serviceunit_no_pk}}">{{$item->serviceunit_name}} - {{$item->serviceunit_code}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="cost_center_name" class="col-sm-4 col-form-label">Cost Center Name<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="cost_center_name" name="cost_center_name" placeholder="Cost Center Name" value="" />
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="sub_ledger_type_code" class="col-sm-4 col-form-label">Cost Center Code<span style="color:red">*</span> </label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="cost_center_code" name="cost_center_code" placeholder="Cost Center Code" value="" />
                                            </div>
                                        </div>
                                    </div>
                           
                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
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
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="" onclick="costCenterSaveForm()">Save</button>
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

                            <div class="row justify-content-center position-center">
                                <div class="col-6">
                                    <div class="form-group form-row">
                                        <label for="" class="col-sm-4 col-form-label">Search by Department<span style="color:red">*</span></label>
                                        <div class="col-sm-8">                                           
                                            <select name="department_search" id="department_search" class="form-control form-control-sm searchByDept">
                                                <option value=""  selected>All</option>
                                                @foreach ($data->getData()->data as $item)
                                                    @if($item->status == 1)
                                                    <option value="{{$item->serviceunit_no_pk}}">{{$item->serviceunit_name}} - {{$item->serviceunit_code}}</option>
                                                    @endif
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <div class="row">
                                <div class="col-12">
                                    <div class="table-responsive">
                                        <table class="table table-striped table-bordered table-hover cost_center_v1">
                                            <thead class="global-uhl-table-bg">
                                                <tr>
                                                    <th class="text-center">SL No</th>
                                                    <th class="text-center">Department Name</th>
                                                    <th class="text-center">Cost Center Name</th>
                                                    <th class="text-center">Cost Center Code</th>
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
            </div>

        </div>
    </section>
</main>
{{-- <script src="{{ asset('js/typeahead.bundle.js') }}"></script> --}}
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $("#costCenterSave").validate({
        rules:{
            department:{
                required:true,
            },
            cost_center_name:{
                required:true,
                minlength:5,
                maxlength:50,
                notOnlySpaces: true
            },
            cost_center_code:{
                required:true,
                minlength:1,
                maxlength:50,
                notOnlySpaces: true
            },
            notes:{
                maxlength:500,
            }
        },
        messages:{
            department:{
                required: "Department Name Required"
            },
            cost_center_name:{
                required: "Cost Center Name Required"
            },
            cost_center_code:{
                required: "Cost Center Code Required"
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

        $(document).ready(function(){
            $('.select2').select2();
            $('.selectCostCenter').select2();
            $('.searchByDept').select2();
            <!-- Fetch Table Data -->
            getCostCenter();
            function getCostCenter(){

                    var su_no = $("#department_search").val();
                    $.ajax({
                    url: "{{route('v1.accounts.get-cost-center')}}",
                    method: "get",
                    data:{su_no:su_no},
                    success: function(response){
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
                    }
                })
            }

            $('#department_search').on('change', function () {
                getCostCenter();
            });

            $('.cost_center_v1').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 3, 4,5], className: 'text-center' },
                        { targets: [1, 2], className: 'text-left' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            $('th').addClass('text-center')

        })

        <!-- Submit Form Data -->
         function costCenterSaveForm(){
            if($('#costCenterSave').valid()){ 
                let formElement = document.querySelector('#costCenterSave');
                let formData = new FormData(formElement);
                $.ajax({
                    url:"{{route('v1.accounts.save-cost-center')}}",
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

                        $('#costCenterSave').trigger('reset');
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.message);
                    },
                    error:function(err){
                        // console.log('error',err.message);
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

        // Update Cost Center
        function CostCenterFunc(){           
            $.ajax({
                    url: "{{route('v1.accounts.get-cost-center')}}",
                    method: "get",
                    success: function(response){
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
                    }
                })
        }
        <!-- Set Table Data -->
        function setTableData(data){
            $('.cost_center_v1 tbody').empty();
            var rows = [];
            var table = $('.cost_center_v1').DataTable();
            var status = "";
            data.forEach(function(item, index) {
                  if((item.status) == '1')
                        status = '<span class="badge badge-success">Active</span>';
                    else
                        status = '<span class="badge badge-danger">Inactive</span>';

                var rowData = [
                    ++index,
                    item.serviceunit_name,
                    item.costcenter_name,
                    item.costcenter_code,
                    status,
                    '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.accounts.edit-cost-center','')}}/'+item.costcenter_no_pk+'" data-modal="common-modal-sm" data-title="Edit Cost Center" title="Edit Cost Center" data-id="'+item.costcenter_no_pk+'"><i class="fas fa-edit"></i></span>',
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
        }
        
        function emptyTable(){
            $('.cost_center_v1 tbody').empty();
            $('.cost_center_v1 tbody').append(`
                <tr>
                    <td colspan="6" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>
