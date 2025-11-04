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



@endphp
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">TV Setup</h5>
                            <small>TV Module / TV Setup</small>
                        </div>
                    </div>
                </div>
            </div>
            
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="card">
                            <div class="card-header">TV Entry</div>
                            <div class="card-body">
                                <form action="#" method="post" id="tvSetup" class="tvSetup">
                                    @csrf
                                <div class="form-row">

                                    <div class="col-12">
                                        <div class="form-group form-row">
                                            <label for="floor_no_fk" class="col-sm-4 col-form-label">Floor Name<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm select2" name="floor_no_fk" id="floor_no_fk">
                                                    <option value="" disabled selected>Select one</option>
                                                    @foreach ($floor as $item)
                                                            <option value="{{$item->physicalstruct_no_pk}}">{{ $item->physicalstruct_name}} ({{$item->physicalstruct_desc}})</option>
                                                    @endforeach
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group form-row">
                                            <label for="code" class="col-sm-4 col-form-label">Code<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input class="form-control" type="text" id="code" name="code" placeholder="Code">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group form-row">
                                            <label for="name" class="col-sm-4 col-form-label">Name<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="name" name="name" placeholder="Name" value="" />
                                            </div>
                                        </div>
                                    </div>

                                    <div class="col-12">
                                        <div class="form-group form-row ">
                                            <label for="status" class="col-sm-4 col-form-label">Status</label>
                                            <div class="col-sm-8">
                                                <label>
                                                    <input type="checkbox" value="1" id="status" name="status" checked/>
                                                </label>
                                            </div>
                                        </div>
                                    </div>
                                                                  
                                                                                   
                                </div>

                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="" onclick="tvSetupForm()">Save</button>
                                        </li>

                                        {{-- <li class="list-inline-item"><button type="button" class="btn btn-danger">Cancel</button></li> --}}
                                    </ul>
                                </div>

                                </form>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-8 col-12">
                        <div class="card">
                            <div class="card-header">TV Information</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover tv_setup" id="tvScreenDatatable">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th class="text-center" style="width:5%">SL No</th>
                                                <th class="text-center" style="width:27%">Floor Name</th>
                                                <th class="text-center" style="width:17%">TV Code</th>
                                                <th class="text-center" style="width:41%">TV Name</th>
                                                <th class="text-center" style="width:15%">Status</th>
                                                <th class="text-center" style="width:15%">Action</th>
                                            </tr>
                                        </thead>
    
                                        <tbody>
                                            <tr>
                                                <td colspan="6" class="text-center">Data Fetching...</td>
                                            </tr>
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
    $("#tvSetup").validate({
        rules:{
            floor_no_fk:{
                required:true, 
            },
            code:{
                required:true,
                maxlength:200,
                notOnlySpaces: true
            },
            name:{
                maxlength:250,
                notOnlySpaces: true
            },
        },
        messages:{
            floor_no_fk:{
                required: "Floor Name Required", 
            },
            code:{
                required: "Code Required",
            },
            name:{
                required: "Name Required",
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
            getTVInfo();

            function getTVInfo(){
                    $.ajax({
                    url: "{{route('tv-screen.get-tv-info')}}",
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

        })

        <!-- Submit Form Data -->
        function tvSetupForm(){
            if($('#tvSetup').valid()){ 
                let formElement = document.querySelector('#tvSetup');
                let formData = new FormData(formElement);
                $.ajax({
                    url:"{{route('tv-screen.save-tv-entry')}}",
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
                        getTVInfo();
                        $('#floor_no_fk').val(null).trigger('change');
                        $('#tvSetup').trigger('reset');
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
            if($.fn.DataTable.isDataTable('.tv_setup')) {$('.tv_setup').DataTable().destroy();}  
            $('.tv_setup tbody').empty();  
            var rows = [];
            var table = $('#tvScreenDatatable').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 2, 4, 5], className: 'text-center' },
                        { targets: [1,3], className: 'text-left' }
                    ],
                    "lengthMenu": [[10, 25, 50, 75, 100, -1], [10, 25, 50, 75, 100, "All"]], 
                    "pageLength": 10 
                });
            var status = "";
            data.forEach(function(item, index) {
                  if((item.status) == '1')
                        status = '<span class="badge badge-success">Active</span>';
                    else
                        status = '<span class="badge badge-danger">Inactive</span>';

                var rowData = [
                    ++index,
                    '<span>'+item.physicalstruct_name+' - '+item.physicalstruct_desc+'</span>',
                    item.tvscreen_code,
                    item.tvscreen_name,
                    status,
                    '<span class="btn btn-sm btn-success  open-modal btnView" data-action="{{route('tv_screen.edit_tv_setup','')}}/'+item.tvscreen_no_pk+'" data-modal="common-modal-sm" data-title="Edit TV Setup" title="Edit TV Setup" data-id="'+item.tvscreen_no_pk+'"><i class="fas fa-edit"></i></span>',
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            
        }
        function emptyTable(){
            $('.tv_setup tbody').empty();
            $('.tv_setup tbody').append(`
                <tr>
                    <td colspan="6" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>
