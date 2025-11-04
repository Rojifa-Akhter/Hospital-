<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" />
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/buttons.dataTables.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}" />
<div class="container-fluid">
    <div class="row bg-white sticky-top shadow-xs py-1 align-items-center">
        <div class="col-md-2">
            <h5 class="mb-0">  @if($type == 'hr')All Employee Roster @else Departmental Employee Roster @endif</h5>
            <small style="font-size:11px">HRM/Roster/@if($type == 'hr')All Employee Roster @else Departmental Employee Roster @endif</small>
        </div>
        <div class="col-md-10">
            <form action=" {{ route('roster.all.employee.search.print') }}" method="post" target="_blank"
            id="employee-search-create">
            <input type="hidden" value="{{$type}}" name="type">
            @csrf
            <input type="hidden" name="id" value="" />
            <div class="form-row pb-2">
                <div class="col-md-2">
                    <label for="personal_id" class=" col-form-label col-form-label-sm">Card No</label>
                    <input type="text" class="form-control form-control-sm " id="personal_id"
                        name="personal_id" placeholder="Card no">
                    <input type="hidden" name="hidn_personal" id="hidn_personal">

                </div>

                <div class="col-sm-2">
                    {{-- <label for="service_unit"  class="col-form-label col-form-label-sm ">Department @if($type == null)<span style="color:red"> *</span> @endif </label> --}}
                    <label for="service_unit"  class="col-form-label col-form-label-sm ">Department</label>
                    <select class="form-control form-control-sm select2" name="service_unit"
                        id="service_unit">
                        {{-- @if($type == 'hr') --}}
                            <option value="">Select</option>
                        {{-- @endif --}}
                        @if (!empty($service_unit))
                            @foreach ($service_unit as $value)
                                <option value="{{ $value->serviceunit_no_fk_dept }}">
                                    {{ $value->serviceunit_name }}</option>
                            @endforeach
                        @endif
                    </select>
                </div>
                <div class="col-sm-2">
                    <label for="unit" class="col-form-label col-form-label-sm ">Units @if($type == null)<span style="color:red"> *</span> @endif </label>
                    <select class="form-control form-control-sm select2" name="unit" id="unit">
                        @if($type == 'hr')
                            <option value="">Select</option>
                        @endif
                            @if (!empty($units))
                                @foreach ($units as $value)
                                    <option value="{{ $value->serviceunit_no_fk }}">
                                        {{ $value->serviceunit_name }}</option>
                                @endforeach
                            @endif
                    </select>
                </div>
                <div class="col-md-1">
                    <label for="user_expire_date"
                        class="col-form-label col-form-label-sm ">Month</label>
                    <select class="form-control font_size_12  " id="month" name="month"
                        width="200px" required>
                        <option value="">Select Month</option>
                        <option value="01" selected>January</option>
                        <option value="02">February</option>
                        <option value="03">March</option>
                        <option value="04">April</option>
                        <option value="05">May</option>
                        <option value="06">June</option>
                        <option value="07">July</option>
                        <option value="08">August</option>
                        <option value="09">September</option>
                        <option value="10">October</option>
                        <option value="11">November</option>
                        <option value="12">December</option>
                    </select>
                </div>
                <div class="col-md-1">
                    <label for="year" class=" col-form-label col-form-label-sm ">Year</label>
                    <select class="form-control font_size_12 " id="year" name="year" required>
                        <option value="">Select</option>
                        @php
                            $date = date('Y');
                        @endphp

                        @for ($i = $date - 2; $i < $date + 3; $i++)
                            <option value="{{ $i }}"
                                @if ($date == $i) selected @endif>{{ $i }}
                            </option>
                        @endfor
                    </select>
                </div>
                <div class="col-md-4">
                    @if($type == null)
                        <button type="button" class="btn btn-md btn-primary mt-4" id="search"
                        onclick="validateAndSearch()">Search</button>
                    @else
                        <button type="button" class="btn btn-md btn-primary mt-4" id="search"
                            onclick="generateSearch( this, 'employee-search-create', '{{ route('roster.all.employee.search') }}', 'employee-search-data' )">Search</button>
                    @endif
                    <button type="submit" class="btn btn-md btn-primary mt-4" id="search">Export
                        PDF</button>
                    <button type="button" class="btn btn-md btn-primary mt-4" id="carry_forward">Carry Forward</button>
                </div>
            </div>

        </form>


        </div>
    </div>

    {{-- <div class="col-md-12">
        <div class="form-row">
            <div class="col-12">
                <div class="card shadow-xs">
                    <div class="card-header">
                        <h5>Search</h5>
                    </div>
                    <div class="card-body">

                    </div>
                </div>
            </div>
        </div>
    </div> --}}

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
        "bAutoWidth": false,
        "searching": false
    });

    $(".select2").select2();
    $('.date_picker').datepicker({
        format: 'dd-mm-yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true,
    });
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
    function getUnits(thisElement) { 
        let department_id = thisElement.value;
        
        $.ajax({
            url: "{{ route('v1.hrm.employees.get-units-by-department') }}",
            type: 'POST',
            data: {
                department_id: department_id
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                let unitDropdown = $('#unit'); // Select the dropdown
                unitDropdown.empty(); // Clear existing options
                unitDropdown.append('<option value="">Select</option>'); // Add default option
                
                if (data.length > 0) {
                    $.each(data, function(index, unit) {
                        unitDropdown.append('<option value="' + unit.serviceunit_no_pk + '">' + unit.serviceunit_name + '</option>');
                    });
                } else {
                    unitDropdown.append('<option value="">No units found</option>'); // If no data available
                }

                // Reinitialize Select2 (if using Select2 plugin)
                unitDropdown.select2();
            },
            complete: function() {
                $.unblockUI();
            }
        });
    };

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
    
    function validateAndSearch() {
        // const department = document.getElementById('service_unit').value;
        const unit = document.getElementById('unit').value;
        // if (!department) {
        //     alert('Please select department !!');
        //     return;
        // }
        if (!unit) {
            alert('Please select unit !!');
            return;
        }
        // Proceed with the original function if valid
        generateSearch(
            document.getElementById('search'),
            'employee-search-create',
            '{{ route('roster.all.employee.search') }}',
            'employee-search-data'
        );
    }
</script>
{{-- Session::get('user.ses_hospital_code') == 'DMHL' --}}
