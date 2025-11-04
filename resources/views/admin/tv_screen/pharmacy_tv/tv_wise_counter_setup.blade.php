<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
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
                            <h5 class="mt-2 mb-0">TV Wise Counter Setup</h5>
                            <small>TV Module / TV Wise Counter Setup</small>
                        </div>
                    </div>
                </div>
            </div>
            
                <div class="row">
                    <div class="col-md-4 col-12">
                        <div class="card">
                            <div class="card-header">TV Wise Counter Entry</div>
                            <div class="card-body">
                                <form action="#" method="post" id="tvWiseCounter" class="tvWiseCounter">
                                    @csrf
                                <div class="form-row">

                                    <div class="col-12">
                                        <div class="form-group form-row">
                                            <label for="tv_no_fk" class="col-sm-4 col-form-label">TV Name<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm select2" name="tv_no_fk" id="tv_no_fk">
                                                    <option value="" disabled selected>Select one</option>
                                                    @foreach ($tv as $item)
                                                            <option value="{{$item->tvscreen_no_pk}}">{{$item->tvscreen_name}} - {{ $item->physicalstruct_name}}</option>
                                                    @endforeach
                                                </select>
                                                
                                            </div>
                                        </div>
                                    </div>


                                    <div class="col-12">
                                        <div class="form-group form-row">
                                            <label for="name" class="col-sm-4 col-form-label">Counter<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <select class="form-control form-control-sm" name="counter_no_fk" id="counter_no_fk">
                                                    <option value="" disabled selected>Select one</option>
                                                    @foreach ($cash_counter as $key => $item)
                                                        <option value="{{$key}}">{{ $item}}</option>
                                                    @endforeach
                                            </select>
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
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="" onclick="tvWiseCounterForm()">Save</button>
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
                            <div class="card-header">TV Wise Counter Information</div>
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover tv_setup" id="tvScreenDatatable">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th class="text-center" style="width:5%">SL No</th>
                                                <th class="text-center" style="width:27%">Floor Name</th>
                                                <th class="text-center" style="width:17%">TV Code</th>
                                                <th class="text-center" style="width:16%">TV Name</th>
                                                <th class="text-center" style="width:25%">Counter Name</th>
                                                <th class="text-center" style="width:15%">Status</th>
                                                <th class="text-center" style="width:15%">Action</th>
                                            </tr>
                                        </thead>
    
                                        <tbody>
                                            <tr>
                                                <td colspan="7" class="text-center">Data Fetching...</td>
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
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $("#tvWiseCounter").validate({
        rules:{
            tv_no_fk:{
                required:true, 
            },
            counter_no_fk:{
                required:true, 
            },
        },
        messages:{
            tv_no_fk:{
                required: "TV Required", 
            },
            counter_no_fk:{
                required: "Counter Name Required",
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
            getCounterTVInfo();

            function getCounterTVInfo(){
                    $.ajax({
                    url: "{{route('tv-screen.get-tv-wise-counter-info')}}",
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
        function tvWiseCounterForm(){
            if($('#tvWiseCounter').valid()){ 
                let formElement = document.querySelector('#tvWiseCounter');
                let formData = new FormData(formElement);
                $.ajax({
                    url:"{{route('tv-screen.save-tv-wise-counter-entry')}}",
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
                        getCounterTVInfo();
                        $('#tv_no_fk').val(null).trigger('change');
                        $('#tvWiseCounter').trigger('reset');
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
                        { targets: [0, 2, 3, 5,6], className: 'text-center' },
                        { targets: [1,4], className: 'text-left' }
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
                    `${item.lookupdata_name}`,
                    status,
                    '<span class="btn btn-sm btn-success  open-modal btnView" data-action="{{route('tv_screen.edit_tv_wise_counter_setup','')}}/'+item.tvscreendisplay_no_pk+'" data-modal="common-modal-sm" data-title="Edit TV Wise Counter Setup" title="Edit TV Wise Counter  Setup" data-id="'+item.tvscreendisplay_no_pk+'"><i class="fas fa-edit"></i></span>',
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
                    <td colspan="7" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>
