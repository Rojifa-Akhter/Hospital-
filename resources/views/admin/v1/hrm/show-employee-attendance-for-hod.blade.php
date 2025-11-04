<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-12">
            <div class="float-left ">
                <h5 class="mt-2 mb-0">Attendance List</h5>
                <small>Attendance List</small>
            </div>
        </div>
    </div>
    {{-- Search Panel Start --}}
   <div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header">
                <h5><i class="fa fa-search"></i>Search Panel</h5>
            </div>
            <div class="card-body pt-2 bg-light">
                <form action="#" id="searchAttendanceforhod" method="post">
                    @csrf
                    <div class="form-group row">
                        <div class="col-md-12">
                            <div class="form-row">

                                <div class="col-lg-5 col-md-6 col-12">
                                    <div class="form-group">
                                        <label class="col-form-label col-form-label-sm"
                                            for="search">Attendance Date</label>
                                        <div class="input-group">
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">From</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="search_date_from" name="search_date_from" value="{{date('d-m-Y', strtotime('-1 day'))}}"/>
                                            <div class="input-group-prepend">
                                                <div class="input-group-text">To</div>
                                            </div>
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="search_date_to" name="search_date_to" value="{{date('d-m-Y')}}"/>
                                        </div>
                                    </div>
                                </div>

                                {{-- <div class="col-md-2">
                                    <div class="form-group">
                                    <label for="card_no" class="col-form-label col-form-label-sm">Card No.</label>
                                    <input type="text" class="form-control" name="card_no" id="card_no">
                                </div>
                             </div> --}}
                                <div class="col-md-2 ">
                                    <label for="card_no" class="col-form-label col-form-label-sm ">Card No</label>
                                    <input type="text" class="form-control form-control-sm " id="card_no"
                                        name="card_no" value="" placeholder="Card no">
                                    <input type="hidden" name="card_hidn" id="card_hidn">

                                </div>
                                <div class="col-md-1">
                                    <button type="button" id="showAttendenceSearch" class="btn btn-md btn-md-global btn-success mt-4">Search</button>
                                </div>
                            </div>
                        </div>

                    </div>
                </form>
            </div>
        </div>
    </div>
   </div>
    {{-- Search Panel end --}}
    <div class="card">
        <div class="card-body">
            <div class="row mt-2">
                <div class="col-md-12">
                    <div class="table-responsive">
                        <table class="table table-bordered table-hover table-striped data-table">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center">Sl</th>
                                    <th style="width: 80px" class="text-center">Card No.</th>
                                    <th style="width: 190px" class="text-left">Employee Name</th>
                                    <th class="text-center">Contact No.</th>
                                    <th class="text-center">Department</th>
                                    <th class="text-left">Duty Roster Type</th>
                                    <th class="text-center">Attendance Date</th>
                                    <th class="text-center">In Time</th>
                                    <th class="text-center">Out Time</th>
                                </tr>
                            </thead>
                            <tbody id="searchEmployeeAttendenceTable">
                                @if (!empty($data))
                                    @foreach ($data as $attn_data)
                                    <tr>
                                        <td class="text-center">{{ $loop->iteration }}</td>
                                        <td class="text-center">{{ $attn_data->card_no }}</td>
                                        <td class="text-left">{{ $attn_data->full_name }}</td>
                                        <td class="text-center">{{ $attn_data->contact_number }}</td>
                                        <td class="text-left">{{ $attn_data->serviceunit_name }}</td>
                                        <td class="text-left">{{ $attn_data->duty_roster_type }}</td>
                                        <td class="text-center">{{ $attn_data->att_date ? date('d-m-Y', strtotime($attn_data->att_date)) : '' }}</td>
                                        <td class="text-center">{{ $attn_data->in_time ? date('H:i', strtotime($attn_data->in_time)) : '' }}</td>
                                        <td class="text-center">{{ $attn_data->out_time ? date('H:i', strtotime($attn_data->out_time)) : '' }}</td>
                                    </tr>
                                    @endforeach
                                @endif
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script>
    $('.select2').select2({});
    openDoctorAutocomplete("#card_no", 'card_hidn');
</script>

<script type="text/javascript">
   
     $('.data-table').DataTable({
            "ordering": false,
            "searching": true,
            "pageLength": 10,

        });

        $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
    $(document).on("click", "#showAttendenceSearch", function(e) {
        var formID = $("#searchAttendanceforhod").attr("id");
        var formMethod = $("#searchAttendanceforhod").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1.hrm.search-attendance-list-for-hod') }}",
            type: "post",
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $('.data-table').DataTable().destroy();
                $("#searchEmployeeAttendenceTable").html(data);

                $('.data-table').DataTable({
                    "ordering": false,
                    "searching": true,
                    "pageLength": 10,
                });
            },
            complete: function() {
                $.unblockUI();
                $("#searchAttendanceforhod").reset();
            }
        });
    });
</script>

