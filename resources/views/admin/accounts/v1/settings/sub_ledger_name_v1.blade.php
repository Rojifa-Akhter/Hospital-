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
</style>
<main id="page-content">
    <section class="fixed_asset">
        <div class="container-fluid">
            <div class="row">
                <div class="col-md-12">
                    <div class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                        <div class="col-md-11">
                            <h5 class="mt-2 mb-0">Sub Ledger Name</h5>
                            <small>Accounts / Sub Ledger Name</small>
                        </div>
                    </div>
                </div>
            </div>
            <form action="#" method="post" id="subLedgerTypeSave" class="subLedgerTypeSave">
                @csrf
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="form-row">

                                    <div class="col-md-6 col-12">
                                        <div class="form-group form-row">
                                            <label for="" class="col-sm-4 col-form-label">Sub Ledger  Type<span style="color:red">*</span></label>
                                            <div class="col-sm-8">                                           
                                                <select name="sub_ledger_type" id="sub_ledger_type" class="form-control form-control-sm select2">
                                                    <option value="" disabled selected>Select One</option>
                                                    @foreach ($data->getData()->data as $item)
                                                        @if($item->status == 1)
                                                        <option value="{{$item->acct_subledger_typeno_pk}}" data-code="{{$item->subledgertype_code}}">{{$item->subledgertype_name}} - {{$item->subledgertype_code}}</option>
                                                        @endif
                                                    @endforeach
                                                </select>
                                            </div>
                                        </div>

                                        <div class="form-group form-row" id="staff_shareholders">
                                            <label for="tracking_id" class="col-sm-4 col-form-label tracking_id">Tracking(Protfolio/Emp Code)</label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="tracking_id" name="tracking_id" placeholder="Tracking(Protfolio/Emp Code)" value="" />
                                            </div>
                                        </div>
                                      
                                        <div class="form-group form-row">
                                            <label for="sub_ledger_type_code" class="col-sm-4 col-form-label">Sub Ledger Code<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="sub_ledger_name_code" name="sub_ledger_name_code" placeholder="Sub Ledger Code" value="" />
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
                                            <label for="sub_ledger_name" class="col-sm-4 col-form-label">Sub Ledger  Name<span style="color:red">*</span></label>
                                            <div class="col-sm-8">
                                                <input type="text" class="form-control form-control-sm" id="sub_ledger_name" name="sub_ledger_name" placeholder="Sub Ledger Name" value="" />
                                            </div>
                                        </div>

                                        <div class="form-group form-row">
                                            <label for="status" class="col-sm-4 col-form-label">Status</label>
                                            <div class="col-sm-8">
                                                <label>
                                                    <input type="checkbox" value="1" id="status" name="status" checked/>
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
                                            <button type="button" class="btn btn-secondary uhl_save_btn" id="" onclick="subLedgerTypeSaveForm()">Save</button>
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
                                        <label for="" class="col-sm-4 col-form-label">Search by Sub Ledger Type<span style="color:red">*</span></label>
                                        <div class="col-sm-8">                                           
                                            <select name="search_sub_ledger_type" id="search_sub_ledger_type" class="form-control form-control-sm select2">
                                                <option value="" selected>All</option>
                                                @foreach ($data->getData()->data as $item)
                                                    @if($item->status == 1)
                                                    <option value="{{$item->acct_subledger_typeno_pk}}" data-code="{{$item->subledgertype_code}}">{{$item->subledgertype_name}} - {{$item->subledgertype_code}}</option>
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
                                        <table class="table table-striped table-bordered table-hover subledger_name_v1">
                                            <thead class="global-uhl-table-bg">
                                                <tr>
                                                    <th class="text-center">SL No</th>
                                                    <th class="text-center">Sub Ledger Type Name</th>
                                                    <th class="text-center">Sub Ledger Name</th>
                                                    <th class="text-center">Sub Ledger Code</th>
                                                    <th class="text-center">Tracking</th>
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
    // $('.select2').select2();
    $("#subLedgerTypeSave").validate({
        rules:{
            sub_ledger_type:{
                required:true,
            },
            sub_ledger_name:{
                required:true,
                minlength:5,
                maxlength:50,
                notOnlySpaces: true
            },
            sub_ledger_name_code:{
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
        sub_ledger_type:{
            required: "Sub Ledger Name Required"
        },
        sub_ledger_name:{
            required: "Sub Ledger Type Name Required"
        },
        sub_ledger_name_code:{
            required: "Sub Ledger Type Code Required"
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
            <!-- Fetch Table Data -->
            getSubLedgerName();
            function getSubLedgerName(){
                var subledger_type = $("#search_sub_ledger_type").val();
                    $.ajax({
                    url: "{{route('v1.accounts.get-sub-ledger-name')}}",
                    method: "get",
                    data:{subledger_type:subledger_type},
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

            $('#search_sub_ledger_type').on('change', function () {
                getSubLedgerName();
            });

            $('.subledger_name_v1').DataTable({
                searching: true,
                columnDefs: [
                        { targets: [0, 3, 4,5,6], className: 'text-center' },
                        { targets: [1, 2], className: 'text-left' }
                    ],
                    "lengthMenu": [[25, 50, 75, 100, -1], [25, 50, 75, 100, "All"]], 
                    "pageLength": 25
                });
            $('th').addClass('text-center')

        })

        <!-- Submit Form Data -->
        function subLedgerTypeSaveForm(){
            if($('#subLedgerTypeSave').valid()){ 
                let formElement = document.querySelector('#subLedgerTypeSave');
                let formData = new FormData(formElement);
                $.ajax({
                    url:"{{route('v1.accounts.save-sub-ledger-name')}}",
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
                        $('#subLedgerTypeSave').trigger('reset');
                        $('#sub_ledger_type').val(null).trigger('change');
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

        // Update Sub Ledger Name
        function subLedgerNameFunc(){           
            $.ajax({
                    url: "{{route('v1.accounts.get-sub-ledger-name')}}",
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
            $('.subledger_name_v1 tbody').empty();
            var rows = [];
            var table = $('.subledger_name_v1').DataTable();
            var status = "";
            data.forEach(function(item, index) {
                  if((item.status) == '1')
                        status = '<span class="badge badge-success">Active</span>';
                    else
                        status = '<span class="badge badge-danger">Inactive</span>';

                var rowData = [
                    ++index,
                    item.subledgertype_name,
                    item.subledger_name,
                    item.subledger_code,
                    item.sub_ledger_tracking_no,
                    status,
                    '<span class="btn btn-sm btn-success btn-md-global open-modal btnView" data-action="{{route('v1.accounts.edit-sub-ledger-name','')}}/'+item.acct_subledger_no_pk+'" data-modal="common-modal-sm" data-title="Edit Sub Ledger Name" title="Edit Sub Ledger Name" data-id="'+item.acct_subledger_no_pk+'"><i class="fas fa-edit"></i></span>',
                ];
                rows.push(rowData);
            });
            table.clear();
            table.rows.add(rows);
            table.draw();
        }

        function emptyTable(){
            $('.subledger_name_v1 tbody').empty();
            $('.subledger_name_v1 tbody').append(`
                <tr>
                    <td colspan="7" class="text-danger text-center">Data Not Found</td>
                </tr>
            `);
        }

        // function changeSubLedgerType(){
        //     var type_code = $('#sub_ledger_type option:selected').data('code');
        //     if(type_code == 'ADStaff' || type_code == 'SHD'){
        //         $(".tracking_id").text('Port Folio');
        //         $("#staff_shareholders").removeClass('d-none');
        //     }
        //     else{
        //         $(".tracking_id").text('Employee ID');
        //         $("#staff_shareholders").addClass('d-none');
        //     }
        // }
</script>
