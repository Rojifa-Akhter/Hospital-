<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}" />
<link href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}" rel="stylesheet" />
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}" />
<div class="container-fluid">
    <div class="row bg-white sticky-top align-items-center justify-content-between shadow-xs py-1">
        <div class="col-md-6">
            <h5 class="mb-0">Employee Roster</h5>
            <small>Roster / Employee Roster</small>
        </div>
        <div class="col-md-6 text-right">
            {{-- <a href="{{ route('roster.create-roster-template')}}" class="btn btn-success text-white btn-md"><i class="fa fa-plus"></i>&nbsp;Add New</a> --}}
        </div>
    </div>

    <div class="form-row">
        <div class="col-md-7">
            <div class="form-row">
                <div class="col-12">
                    <div class="card shadow-xs">
                        <div class="card-header">
                            <h5>Employee Roster</h5>
                        </div>
                        <div class="card-body">
                            <form action=" {{ route('roster.store-employee-roster') }}" method="post"
                                id="grade-create">
                                @csrf
                                <input type="hidden" name="id" value="" />
                                <div class="form-row justify-content-center border-bottom pb-2">
                                    @if (Auth::user()->au_entry_hospital_pk_no != 141)

                                        @if (Auth::user()->user_personal()->inv_hod_ind == 1)
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label for="" class="col-form-label s-12">Employee
                                                        Search<span class="text-danger">*</span></label>
                                                    <input type="text" id="dep_emp_search" class="form-control "
                                                        name="personal_id" style="margin-bottom: 0 !important"
                                                        value="" placeholder="Search Employee">
                                                    <input type="hidden" id="hidn_personal" name="hidn_personal"
                                                        required />
                                                </div>
                                                <div style="font-size: 10px;color:rgb(14, 14, 43);"><span
                                                        id="person_code"></span><br><span id="serviceunit_name"></span>
                                                </div>
                                            </div>
                                        @else
                                            <div class="col-md-3">
                                                <div class="form-group">
                                                    <label class="col-form-label col-form-label-sm"
                                                        for="">Employee Search<span
                                                            class="text-danger">*</span></label>
                                                    <input type="text" class="form-control form-control-sm m-0"
                                                        name="personal_id" id="personal_id"
                                                        style="margin-bottom: 0 !important"
                                                        placeholder="Employee Employee" />
                                                    <input type="hidden" name="hidn_personal" id="hidn_personal"
                                                        class="" required />
                                                </div>
                                                <div style="font-size: 10px;color:rgb(14, 14, 43);"><span
                                                        id="person_code_hr">
                                                    </span><br><span id="serviceunit_name_hr"></div>
                                            </div>
                                        @endif
                                    @else
                                        <div class="col-md-3">
                                            <div class="form-group">
                                                <label class="col-form-label col-form-label-sm" for="">Employee
                                                    Search<span class="text-danger">*</span></label>
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    name="personal_id" id="personal_id"
                                                    style="margin-bottom: 0 !important"
                                                    placeholder="Employee Employee" />
                                                <input type="hidden" name="hidn_personal" id="hidn_personal"
                                                    class="" required />
                                            </div>
                                            <div style="font-size: 10px;color:rgb(14, 14, 43);"><span
                                                    id="person_code_hr">
                                                </span><br><span id="serviceunit_name_hr"></div>
                                        </div>

                                    @endif

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
                                        <button type="button" class="btn btn-md btn-md-global btn-primary mt-4"
                                            id="validate">Validate</button>
                                    </div>
                                </div>

                                <div class="form-row justify-content-center py-2">
                                    <div class="col-md-3">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm"
                                                for="roster_template">Roster Template</label>
                                            <select class="form-control select2" id="roster_template"
                                                name="roster_template" style="margin: 0px !important;">
                                                <option value="">Select Roster Template</option>
                                                @if (isset($roster_unique))
                                                    @foreach ($roster_unique as $value)
                                                        <option value="{{ $value->roster_temp_code }}">
                                                            {{ $value->roster_temp_code }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <div id="roster_temp_list">
                                    @include('admin.hrm.roster.roster_temp')
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <div class="col-md-5" id="roster_validate">
            @include('admin.hrm.roster.roster_validate')
        </div>
    </div>
</div>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    function empInfo(item, obj) {
        $('#person_code_hr').html(item.person_code);
        $('#serviceunit_name_hr').html(item.su_name);
        $('#person_no').val(item.doctor_id);

    }
    // openDoctorAutocomplete("#personal_id", "hidn_personal","","",empInfo);
    openDoctorAutocomplete('#personal_id', 'hidn_personal', 'employee_ind', '1', empInfo);


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
