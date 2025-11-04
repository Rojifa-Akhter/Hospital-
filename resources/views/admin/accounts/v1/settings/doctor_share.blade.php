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
                            <h5 class="mt-2 mb-0">Docotor Share Setup</h5>
                            <small>Accounts / Docotor Share Setup</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="post" id="doctorShareSave" class="doctorShareSave">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">
                                    <div class="col-md-6 col-12 px-0 py-0">
                                        <div class="col-12">
                                            <div class="form-group form-row">
                                                <label for="person_no_fk" class="col-sm-4 col-form-label">Doctor
                                                    Name<span style="color:red">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="doctor_name" name="doctor_name" placeholder="Doctor Name"
                                                         required />
                                                    <input type="hidden" name="hdn_doctor_id" id="hdn_doctor_id">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-12">
                                            <div class="form-group form-row">
                                                <label for="itemtype_no_fk" class="col-sm-4 col-form-label">Item Type<span style="color:red">*</span></label>
                                                <div class="col-sm-8" >
                                                    <select
                                                    class="form-control form-control-sm select2"
                                                    id="itemtype_no_fk" name="itemtype_no_fk"
                                                    required>
                                                    <option value="" selected>Select Item Type</option>
                                                    @if (isset($item_type))
                                                        @foreach ($item_type as $val)
                                                            <option
                                                                value="{{ $val->itemtype_no_pk }}"
                                                                >
                                                                {{ ucwords(strtolower($val->item_type_name)) }}
                                                            </option>
                                                        @endforeach
                                                    @endif

                                                </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-12">
                                            <div class="form-group form-row">
                                                <label for="share_per" class="col-sm-4 col-form-label">Share %<span style="color:red">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="number" class="form-control form-control-sm" id="share_per" name="share_per" placeholder="%" minlength="0" maxlength="100" required/>
                                                </div>
                                            </div>
                                        </div>

                                                                             
                                    </div>
                                    <div class="col-md-6 col-12 px-0 py-0">

                                        <div class="col-12">
                                            <div class="form-group form-row">
                                                <label for="start_date" class="col-sm-4 col-form-label">Start Date<span style="color:red">*</span></label>
                                                <div class="col-sm-8">
                                                    <input type="date" class="form-control form-control-sm" id="start_date" name="start_date" required/>
                                                </div>
                                            </div>
                                        </div> 
                                        
                                        {{-- <div class="col-12">
                                            <div class="form-group form-row">
                                                <label for="end_date" class="col-sm-4 col-form-label"> End Date </label>
                                                <div class="col-sm-8">
                                                    <input class="form-control form-control-sm" type="date" id="end_date" name="end_date" >
                                                </div>
                                            </div>
                                        </div>                                     --}}
                                        <div class="col-12">
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
                </div>

                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="" onclick="doctorShareSaveForm()">Save</button>
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
                                <table class="table table-striped table-bordered table-hover accounts_type_v1" id="doctorShareDataTable">
                                    <thead class="global-uhl-table-bg">
                                        <tr>
                                            <th class="text-center">SL No</th>
                                            <th class="text-center">Doctor Name</th>
                                            <th class="text-center">Item Type</th>
                                            <th class="text-center">Share %</th>
                                            <th class="text-center">Start Date</th>
                                            <th class="text-center">End Date</th>
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
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $("#doctorShareSave").validate({
        rules:{
            doctor_name:{
                required:true, 
            },
            itemtype_no_fk:{
                required:true,
            },
            share_per:{
                min:0,
                max:100,
            },
        },
        messages:{
            doctor_name:{
                required: "Doctor Name Required", 
            },
            itemtype_no_fk:{
                required: "Item Type Required",
            },
            share_per:{
                required: "share per Required min 0 and max 100",
            }
        }
    });
</script>

<script>

        
        // openDoctorAutocomplete("#doctor_name", 'hdn_doctor_id');
        openDoctorAutocomplete('#doctor_name', 'hdn_doctor_id', 'doctor_ind', '1,2');


        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': $('meta[name="csrf-token"]').attr('content')
                }
        });

        <!-- Fetch Table Data -->
            getDoctorShare();

            function getDoctorShare(){
                    $.ajax({
                    url: "{{route('v1.accounts.get-doctor-share')}}",
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

            $('#doctorShareDataTable').DataTable({
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
       function doctorShareSaveForm(){
   
            if($('#doctorShareSave').valid()){ 
                let formElement = document.querySelector('#doctorShareSave');
                let formData = new FormData(formElement);
                $.ajax({
                    url:"{{route('v1.accounts.save-doctor-share')}}",
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
                        $('#doctorfeemst_no_pk').val(null).trigger('change');
                        $('#doctorShareSave').trigger('reset');
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
            $('.accounts_type_v1 tbody').empty();          
            var rows = [];
            var table = $('#doctorShareDataTable').DataTable();
            var status = "";
            data.forEach(function(item, index) {
                  if((item.status) == '1')
                        status = '<span class="badge badge-success">Active</span>';
                    else
                        status = '<span class="badge badge-danger">Inactive</span>';
                let startDate = item.start_date ? item.start_date.substring(0,10) : '';
                let endDate   = item.end_date ? item.end_date.substring(0,10) : '';

                var rowData = [
                    ++index,
                    item.full_name,
                    item.item_type_name,
                    item.share_per,
                    startDate,
                    endDate,
                    status,
                    '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.accounts.edit-doctor-share','')}}/'+item.doctorfeemst_no_pk+'" data-modal="common-modal-sm" data-title="Edit Account Type" title="Edit Doctor Share" data-id="'+item.doctorfeemst_no_pk+'"><i class="fas fa-edit"></i></span>',
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
            
        }
        function emptyTable(){
            $('.accounts_type_v1 tbody').empty();
            $('.accounts_type_v1 tbody').append(`
                <tr>
                    <td colspan="8" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);

        }
</script>
