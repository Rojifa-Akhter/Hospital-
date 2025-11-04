<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" />
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}" />
<div class="container-fluid">

    <select name="dep_name_dep" id="dep_name_dep" class="select2">
        <option value="">Select Shift</option>
        @foreach ($shift as $d)
            <option value="{{ $d->shift_code }}">{{ $d->shift_desc }}</option>
        @endforeach
    </select>

    <div class="row bg-white sticky-top align-items-center justify-content-between shadow-xs py-1">
        <div class="col-md-6">
            <h5 class="mb-0">All Employee Roster</h5>
            <small>Roster /All Employee Roster</small>
        </div>
        <div class="col-md-6 text-right">
            {{-- <a href="{{ route('roster.create-roster-template')}}" class="btn btn-success text-white btn-md"><i class="fa fa-plus"></i>&nbsp;Add New</a> --}}
        </div>
    </div>

    <div class="col-md-12">
        <div class="form-row">
            <div class="col-12">
                <div class="card shadow-xs">
                    <div class="card-header">
                        <h5>Employee Roster</h5>
                    </div>
                    <div class="card-body">
                        <form action=" {{ route('roster.all.employee.search.print') }}" method="post" target="_blank"
                            id="employee-search-create">
                            @csrf
                            <input type="hidden" name="id" value="" />
                            <div class="form-row justify-content-center border-bottom pb-2">
                                @if (Auth::user()->user_personal()->inv_hod_ind == 1)
                                    <div class="col-md-3 d-none">
                                        <div class="form-group">
                                            <label for="" class="col-form-label s-12">Employee Search<span
                                                    class="text-danger">*</span></label>
                                            <input type="text" id="dep_emp_search" class="form-control "
                                                name="personal_id" style="margin-bottom: 0 !important" value=""
                                                placeholder="Search Employee">
                                            <input type="hidden" id="hidn_personal" name="hidn_personal" required />
                                        </div>
                                        <div style="font-size: 10px;color:rgb(14, 14, 43);"><span
                                                id="person_code"></span><br><span id="serviceunit_name"></span></div>
                                    </div>
                                @else
                                    <div class="col-md-3  d-none">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="">Employee
                                                Search<span class="text-danger">*</span></label>
                                            <input type="text" class="form-control form-control-sm m-0"
                                                name="personal_id" id="personal_id" style="margin-bottom: 0 !important"
                                                placeholder="Employee Employee" />
                                            <input type="hidden" name="hidn_personal" id="hidn_personal" class=""
                                                required />
                                        </div>
                                        <div style="font-size: 10px;color:rgb(14, 14, 43);"><span id="person_code_hr">
                                            </span><br><span id="serviceunit_name_hr"></div>
                                    </div>
                                @endif
                                <div class="col-sm-2">
                                    <label for="doctor_code">Department</label>
                                    <select class="form-control form-control-sm select2" name="service_unit" id="service_unit">
                                        <option value="">Select</option>

                                        @if (!empty($service_unit))
                                            @foreach ($service_unit as $value)
                                                <option value="{{ $value->serviceunit_no_pk }}">
                                                    {{ $value->serviceunit_name }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-2">
                                    <label class="col-form-label col-form-label-sm" for="">Duty Area<span class="text-danger">*</span></label>
                                    <select id="duty_area_list" class="form-control" name="duty_area"
                                        style="margin:0px!important;width: 70%;">
                                        <option value="">Select
                                            Duty Area</option>
                                        @if (!empty($dutyArea))
                                            @foreach ($dutyArea as $key => $value)
                                                <option value="{{ $key }}">
                                                    {{ $value }}</option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                                <div class="col-md-6">
                                    <label class="col-form-label col-form-label-sm " for="">Date<span
                                            class="text-danger"> * </span></label>
                                    <div class="input-group input-daterange">
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">From</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker "
                                            id="roster_date_from" name="start_date" value="{{ date('d-m-Y') }}"
                                            placeholder="dd/mm/yyyy" />
                                        <div class="input-group-prepend">
                                            <div class="input-group-text">To</div>
                                        </div>
                                        <input type="text" class="form-control form-control-sm m-0 date_picker"
                                            id="roster_date_to" name="end_date" value="{{ date('d-m-Y') }}"
                                            placeholder="dd/mm/yyyy" />
                                    </div>
                                </div>
                                <div class="col-md-2">
                                    <button type="button" class="btn btn-md btn-primary mt-4" id="search"
                                        onclick="generateSearch( this, 'employee-search-create', '{{ route('roster.all.employee.search') }}', 'employee-search-data' )">Search</button>
                                    <button type="submit" class="btn btn-md btn-primary mt-4" id="search">Export
                                        PDF</button>
                                </div>
                            </div>

                        </form>


                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="form-row" id="employee-search-data">
        @include('admin.hrm.roster.all_employee_roster_details')
    </div>
</div>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/dataTables.buttons.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    function empInfo(item, obj) {
        $('#person_code_hr').html(item.person_code);
        $('#serviceunit_name_hr').html(item.su_name);
        $('#person_no').val(item.doctor_id);

    }
    // openDoctorAutocomplete("#personal_id", "hidn_personal","","",empInfo);
    openDoctorAutocomplete('#personal_id', 'hidn_personal', 'employee_ind', '1', empInfo);

    var table = $('.datatable').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });

    $(".select2").select2();
    $("#roster_date_from").datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    }).on('changeDate', function(e) {
        $('#date_from').val(e.target.value);
    });

    $("#roster_date_to").datepicker({
        format: "dd-mm-yyyy",
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    }).on('changeDate', function(e) {
        $('#date_to').val(e.target.value);

    });

    $(document).on('change', '.shift_type_list', function() {
        var shift = $(this).val();
        // $(this).parents('tr').nextAll().find('.shift_type_list').val(shift);
        // $(this).parents('tr').prevAll().find('.shift_type_list').val(shift);
        var time = $(this).val().split('_');
        //$('.shift_type_list').val(shift);
        var start_time = time[0].split(' ');
        var end_time = time[1].split(' ');
        console.log($(this).parents('tr'))
        $(this).parents('tr').find('.start_time_input').val(start_time[1]);
        $(this).parents('tr').find('.end_time_input').val(end_time[1]);
        $(this).parents('tr').find('.start_time').html(start_time[1]);
        $(this).parents('tr').find('.end_time').html(end_time[1]);
    });

    $(document).on("change", "#roster_template", function(e) {
        var roster_value = $(this).val();
        $.ajax({
            url: "{{ route('roster.employee_roster_template') }}",
            type: "GET",
            data: {
                roster_value: roster_value
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#roster_temp_list").html(data);
            },
            complete: function() {
                $.unblockUI();
            },
        });
        // alert(disct_value);
    });

    $(document).on("click", "#validate", function(e) {
        var personal_id = $("#hidn_personal").val();
        var from_date = $("#roster_date_from").val();
        var end_date = $("#roster_date_to").val();

        if (personal_id != '' && from_date != '' && end_date != '') {
            $.ajax({
                url: "{{ route('roster.validate-roster') }}",
                type: "POST",
                data: {
                    personal_id: personal_id,
                    from_date: from_date,
                    end_date: end_date
                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $("#roster_validate").html(data);
                },
                complete: function() {
                    $.unblockUI();
                },
            });
        } else {
            alert('Card no or Date Range is required.');
        }
    });

    $("#dep_emp_search").autocomplete({
        source: function(request, response) {
            $.getJSON('{{ route('roster.emp.search.dep') }}?employee=' +
                request
                .term,
                function(data) {
                    var array = $.map(data, function(row) {
                        return {
                            value: row.full_name,
                            label: row.full_name + "(" + row.person_code + ")",
                            item_id: row.person_no_pk,
                            person_code: row.person_code,
                            serviceunit_name: row.serviceunit_name
                        }
                    })
                    response($.ui.autocomplete.filter(array, request.term));

                })
        },
        select: function(event, ui) {
            $('#hidn_personal').val(ui.item.item_id);
            $('#person_code').html(ui.item.person_code);
            $('#serviceunit_name').html(ui.item.serviceunit_name);
            $('#person_no').val(ui.item.item_id);
        },
        minLength: 2,
        delay: 500

    })
    // $(document).on("click", "#validate_roster", function(e) {
    //     var formID = $("#validate_roster_form").attr("id");
    //     var formAction = $("#validate_roster_form").attr("action");
    //     var formMethod = $("#validate_roster_form").attr("method");
    //     if ( confirm('are you sure?')) {
    //         $.ajax({
    //             data: $('#' + formID).serialize(),
    //             url: formAction,
    //             type: formMethod,
    //             beforeSend: function() {
    //                 blockUI();

    //             },
    //             success: function(data) {

    //              var personal_id = $("#hidn_personal").val();
    //              var from_date = $("#roster_date_from").val();
    //              var end_date = $("#roster_date_to").val();

    //              $.ajax({
    //                 url: "{{ route('roster.validate-roster') }}",
    //                 type: "GET",
    //                 data: { personal_id: personal_id, from_date: from_date, end_date: end_date },
    //                 beforeSend: function () {

    //                 },
    //                 success: function (data) {
    //                     $("#roster_validate").html(data);
    //                 },
    //                 complete: function () {

    //                    $('.common-modal-notify').modal('show');
    //                    $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
    //                    // $('.common-modal-notify .modal-title').html(data.title);
    //                    $('.common-modal-notify .modal-body').html("success");
    //                    // blockUI();
    //                },
    //            });
    //          },
    //          complete: function() {

    //              $.unblockUI();
    //          }
    //      });
    //     }
    //     e.preventDefault();
    // });

    function resetRoster() {

        var personal_id = $("#hidn_personal").val();
        var from_date = $("#roster_date_from").val();
        var end_date = $("#roster_date_to").val();

        $.ajax({
            url: "{{ route('roster.validate-roster') }}",
            type: "POST",
            data: {
                personal_id: personal_id,
                from_date: from_date,
                end_date: end_date
            },
            beforeSend: function() {

            },
            success: function(data) {

                $("#roster_validate").html(data);
            },
            complete: function() {
                // blockUI();
            },
        });
    }
</script>
