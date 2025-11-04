<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section id="full_doctor_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-12 mb-1">
                <h5 class="mt-2 mb-0">Employee List</h5>
                <small>Settings / Employee Setup / Employee List</small>
            </div>
        </div>
        <div class="form-row">
            <div class="col-md-4 ">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5>Available Card</h5>
                        <form action="{{ route('employee.store') }}" method="post" id="room-create">
                            @csrf
                            <input type="hidden" name="id" value="">
                            <div class="form-group d-flex align-items-center">
                                <input type="text" class="form-control mb-0" id="employee_card" name="employee_card" placeholder="Enter Card number" required="" style="margin-bottom:0px!important">
                                @php
                                $response_action = route('employee.index');
                                @endphp
                                <button type="button" class="btn btn-sm btn-success ml-2" onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save
                                </button>
                            </div>
                        </form>
                    </div>
                    <div class="card-body" id="doctor-list">
                        <div class="row mt-2">
                            <div class="col-md-12 table-responsive">
                                <table id="datatable" class="table data-table1 table-bordered table-hover table-striped">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th scope="col" class="w-5">#SL</th>
                                            <th scope="col">RF Code</th>
                                            <!-- <th scope="col" style="width:150px;">Action</th> -->
                                        </tr>
                                    </thead>
                                    <tbody></tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
            <div class="col-md-8">
                <div class="card">
                    <div class="card-header d-flex align-items-center justify-content-between">
                        <h5>Employee List</h5>
                        <form action="{{ route('employee.store') }}" method="post" id="room-create" style="text-align:right">
                            @csrf
                            <div class="form-group d-flex align-items-center">
                                <input type="hidden" name="id" value="">
                                <input type="text" class=" m-0 form-control" id="employee_code" name="employee_code" value="" placeholder="Employee Code" autocomlete="off" style="margin-bottom:0px!important">
                                <span type="button" name="employee_btn" class="btn btn-sm btn-success ml-2" id="employee_btn">Search</span>
                            </div>
                        </form>
                    </div>

                    <div class="card-body" id="doctor-list">
                        <div class="row mt-2">
                            <div class="col-md-12 table-responsive">
                                <table class="table table-bordered table-hover table-striped" border="1">
                                    <thead class="bg-primary ">
                                        <tr>
                                            <th class="text-center w-5">#SL</th>
                                            <th class="text-left">Employee Code</th>
                                            <th class="text-left">Card Holder</th>
                                            <th class="text-left"> Mobile No</th>
                                            <th class="text-center" style="width:150px;">Action</th>
                                        </tr>
                                    </thead>
                                    <tbody id="employeeId">
                                        @include('admin.settings.employee_card.employee-list')
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </div>
    </div>

</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $(document).ready(function() {

        // openDoctorAutocomplete('#employee_code', 'employee_hidden');

        var datatable = $('.data-table1').DataTable({
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('employee-card-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{csrf_token()}}"
                }
            },
        });
    });

    $(document).on("click", "#employee_btn", function(e) {
        var employee_code = $('#employee_code').val();
        $.ajax({
            data: {
                employee_code: employee_code
            },
            url: "{{ url('employee-list') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $('#employeeId').html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
