<style>
    input[type="file"] {
        line-height: 1.0 !important;
    }
</style>
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <form action="{{ route('conveyance-bill-save') }}" id="conveyance-bill-form" method="post"
        enctype="multipart/form-data">
        @csrf
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Conveyance Request</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <input type="hidden" name="hdn_conveyancebillmst_no_pk"
                            value="{{ !empty($conv_mst) ? $conv_mst->conveyancebillmst_no_pk : '' }}">
                        <div class="card">
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="billing_date" class="col-form-label">Request Date<span style="color:red;">*</span></label>
                                            <input type="text" class="form-control form-control-sm" id="billing_date"
                                                name="billing_date" placeholder="" value="{{ date('d/m/Y') }}" required
                                                readonly />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="req_by_person_no_fk" class="col-form-label">Requested By</label>
                                            <input type="text" class="form-control form-control-sm" id="req_by_person_no_fk" name="req_by_person_no_fk" placeholder=""
                                                value="{{ $requested_by_name->user_fullname }}" readonly />
                                            <input type="hidden" name="req_by_person_no_fk_hdn" id="req_by_person_no_fk_hdn" value="{{ $requested_by_name->person_no_pk }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="req_dept" class="col-form-label">Department</label>
                                            <input type="text" class="form-control form-control-sm" id="req_dept" name="req_dept" placeholder=""
                                                value="{{ $requested_by_name->serviceunit_name }}" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg-2 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="req_desig" class="col-form-label">Designation</label>
                                            <input type="text" class="form-control form-control-sm" id="req_desig" name="req_desig" placeholder=""
                                                value="{{ $requested_by_name->designation_name }}" readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="type_name" class="col-form-label">Type of Request</label>
                                            <select class="form-control form-control-sm" id="type_name" name="type_name">
                                                <option value="">Select Type</option>
                                                <option value="Routine"
                                                    @if (isset($conv_mst) && $conv_mst->type_name == 'Routine') selected @endif>Routine</option>
                                                <option value="Urgent"
                                                    @if (isset($conv_mst) && $conv_mst->type_name == 'Urgent') selected @endif>Urgent</option>

                                            </select>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>

                    </div>
                </div>

                <div class="card" id="">
                    <div class="card-body mt-3">
                        <div class="row">
                            <div class="col-12 table-responsive">
                                <table class="table table-striped table-bordered table-hover">
                                    <thead class="global-uhl-table-bg" id="table_head">
                                        <tr>
                                            <th>Trip No</th>
                                            <th>Trip Date</th>
                                            <th>Transport Name</th>
                                            <th>From</th>
                                            <th>To</th>
                                            <th>Purpose</th>
                                            <th>Address</th>
                                            <th>Remarks</th>
                                            <th>Amount</th>
                                            <th>Attachment 1</th>
                                            <th>Attachment 2</th>
                                            <th></th>
                                        </tr>
                                        <tr id="0">
                                            <td>
                                                <input type="text" class="form-control form-control-sm serial-number" name="trip_id[]" id="trip_id" value="Trip-0" readonly />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm date_picker" name="conveyance_date[]" id="ddd" />
                                            </td>
                                            <td>
                                                <select name="transport_name[]" class="form-control form-control-sm"
                                                    id="select_transport">
                                                    @if (isset($transport))
                                                        @foreach ($transport as $value)
                                                            <option value="{{ $value->trans_lookup_no_fk }}">
                                                                {{ $value->transport_name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                {{-- <select name="from_location[]" class="form-control form-control-sm"
                                                    id="select_from">
                                                    @if (isset($location_thana))
                                                        @foreach ($location_thana as $value)
                                                            <option value="{{ $value->id }}">
                                                                {{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select> --}}
                                                <input type="text" name="from_location[]" id="select_from" autocomplete="off" class="form-control form-control-sm">
                                            </td>
                                            <td>
                                                {{-- <select name="to_location[]" class="form-control form-control-sm"
                                                    id="select_to">
                                                    @if (isset($location_thana))
                                                        @foreach ($location_thana as $value)
                                                            <option value="{{ $value->id }}">
                                                                {{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select> --}}
                                                <input type="text" name="to_location[]" id="select_to" autocomplete="off" class="form-control form-control-sm">

                                            </td>
                                            <td>
                                                {{-- <select name="purpose_name[]" class="form-control form-control-sm"
                                                    id="select_purpose">
                                                    @if (isset($purposes))
                                                        @foreach ($purposes as $key => $value)
                                                            <option value="{{ $key }}">{{ $value }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select> --}}
                                                <input type="text" name="purpose_name[]" autocomplete="off" class="form-control form-control-sm"
                                                    id="select_purpose">
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="description[]" id="" value="" />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" name="remarks[]" id="" value="" />
                                            </td>
                                            <td>
                                                <input type="number" class="form-control form-control-sm amount" name="amount[]" id="aaa" />
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="form-control form-control-sm" id="attachment_name_01" name="attachment_name_01[]" />

                                                    </div>
                                                </div>
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="form-control" id="attachment_name_02" name="attachment_name_02[]" />
                                                    </div>
                                                </div>

                                            </td>
                                            @php
                                                $approval_condition = '';
                                                if (!empty($conv_details)) {
                                                    foreach ($conv_details as $details) {
                                                        $approval_condition = $details->approval_level_status_text;
                                                    }
                                                }
                                            @endphp

                                            <td class="remove_0">
                                                @unless ($approval_condition == '2/2')
                                                    <span type="button" id="med_td_action_0" onclick="addRow3(this)"
                                                        class="btn btn-secondary btn-sm">Add</span>
                                                @endunless
                                            </td>
                                        </tr>
                                    </thead>
                                    <tbody id="data-append-to3">
                                        @if (!empty($conv_details))
                                            @foreach ($conv_details as $details)
                                                <tr id="0">
                                                    <td>
                                                        <input type="hidden" name="hdn_conveyancebilldtl_no_pk[]" value="{{ $details->conveyancebilldtl_no_pk }}">
                                                        <input type="text" class="form-control form-control-sm serial-number" name="trip_id[]" id="trip_id"
                                                            value="{{ $details->trip_sl }}" readonly />
                                                    </td>
                                                    <td>
                                                        @if ($details->approval_level_status_text == '2/2')
                                                            <input type="text" class="form-control form-control-sm date_picker" name="conveyance_date[]" id="ddd"
                                                                value="{{ $details->conveyance_date ? date('d/m/Y', strtotime($details->conveyance_date)) : '' }}"
                                                                readonly />
                                                        @else
                                                            <input type="text" class="form-control form-control-sm date_picker" name="conveyance_date[]" id="ddd"
                                                                value="{{ $details->conveyance_date ? date('d/m/Y', strtotime($details->conveyance_date)) : '' }}" />
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if ($details->approval_level_status_text == '2/2')
                                                            <select name="transport_name[]"
                                                                class="form-control form-control-sm"
                                                                id="select_transport">
                                                                @if (isset($transport))
                                                                    @foreach ($transport as $value)
                                                                        @if ($value->trans_lookup_no_fk == $details->transport_name_lookup_data_fk)
                                                                            <option
                                                                                value="{{ $value->trans_lookup_no_fk }}"
                                                                                selected>
                                                                                {{ $value->transport_name }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        @else
                                                            <select name="transport_name[]"
                                                                class="form-control form-control-sm"
                                                                id="select_transport">
                                                                @if (isset($transport))
                                                                    @foreach ($transport as $value)
                                                                        <option
                                                                            value="{{ $value->trans_lookup_no_fk }}"
                                                                            @if ($value->trans_lookup_no_fk == $details->transport_name_lookup_data_fk) selected @endif>
                                                                            {{ $value->transport_name }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select>
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if ($details->approval_level_status_text == '2/2')
                                                            {{-- <select name="from_location[]"
                                                                class="form-control form-control-sm" id="select_from">
                                                                @if (isset($location_thana))
                                                                    @foreach ($location_thana as $value)
                                                                        @if ($value->id == $details->from_location_lookup_data_fk)
                                                                            <option value="{{ $value->id }}"
                                                                                selected>
                                                                                {{ $value->name }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select> --}}
                                                            <input type="text" name="from_location[]" id="select_from" autocomplete="off" class="form-control form-control-sm" value="{{ $details->from_location }}" readonly>
                                                        @else
                                                            {{-- <select name="from_location[]"
                                                                class="form-control form-control-sm" id="select_from">
                                                                @if (isset($location_thana))
                                                                    @foreach ($location_thana as $value)
                                                                        <option value="{{ $value->id }}"
                                                                            @if ($value->id == $details->from_location_lookup_data_fk) selected @endif>
                                                                            {{ $value->name }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select> --}}
                                                            <input type="text" name="from_location[]" id="select_from" autocomplete="off" class="form-control form-control-sm" value="{{ $details->from_location }}">
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if ($details->approval_level_status_text == '2/2')
                                                            {{-- <select name="to_location[]"
                                                                class="form-control form-control-sm" id="select_to">
                                                                @if (isset($location_thana))
                                                                    @foreach ($location_thana as $value)
                                                                        @if ($value->id == $details->to_location_lookup_data_fk)
                                                                            <option value="{{ $value->id }}"
                                                                                selected>
                                                                                {{ $value->name }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select> --}}
                                                            <input type="text" name="to_location[]" id="select_to" autocomplete="off" class="form-control form-control-sm" readonly value="{{ $details->to_location }}">
                                                        @else
                                                            {{-- <select name="to_location[]"
                                                                class="form-control form-control-sm" id="select_to">
                                                                @if (isset($location_thana))
                                                                    @foreach ($location_thana as $value)
                                                                        <option value="{{ $value->id }}"
                                                                            @if ($value->id == $details->to_location_lookup_data_fk) selected @endif>
                                                                            {{ $value->name }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select> --}}
                                                            <input type="text" name="to_location[]" id="select_to" autocomplete="off" class="form-control form-control-sm" value="{{ $details->to_location }}">
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if ($details->approval_level_status_text == '2/2')
                                                            {{-- <select name="purpose_name[]"
                                                                class="form-control form-control-sm"
                                                                id="select_purpose">
                                                                @if (isset($purposes))
                                                                    @foreach ($purposes as $key => $value)
                                                                        @if ($key == $details->purpose_lookupdata_no_fk)
                                                                            <option value="{{ $key }}"
                                                                                selected>
                                                                                {{ $value }}
                                                                            </option>
                                                                        @endif
                                                                    @endforeach
                                                                @endif
                                                            </select> --}}
                                                            <input type="text" name="purpose_name[]" autocomplete="off" class="form-control form-control-sm"
                                                            id="select_purpose" readonly value="{{ $details->purpose_name }}">
                                                        @else
                                                            {{-- <select name="purpose_name[]"
                                                                class="form-control form-control-sm"
                                                                id="select_purpose">
                                                                @if (isset($purposes))
                                                                    @foreach ($purposes as $key => $value)
                                                                        <option value="{{ $key }}"
                                                                            @if ($key == $details->purpose_lookupdata_no_fk) selected @endif>
                                                                            {{ $value }}
                                                                        </option>
                                                                    @endforeach
                                                                @endif
                                                            </select> --}}
                                                            <input type="text" name="purpose_name[]" autocomplete="off" class="form-control form-control-sm"
                                                            id="select_purpose" value="{{ $details->purpose_name }}">
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if ($details->approval_level_status_text == '2/2')
                                                            <input type="text" class="form-control form-control-sm" name="description[]" id="" value="{{ $details->description }}" readonly />
                                                        @else
                                                            <input type="text" class="form-control form-control-sm" name="description[]" id="" value="{{ $details->description }}" />
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if ($details->approval_level_status_text == '2/2')
                                                            <input type="text" class="form-control form-control-sm" name="remarks[]" id="" value="{{ $details->remarks }}" readonly />
                                                        @else
                                                            <input type="text" class="form-control form-control-sm" name="remarks[]" id="" value="{{ $details->remarks }}" />
                                                        @endif

                                                    </td>
                                                    <td>
                                                        @if ($details->approval_level_status_text == '2/2')
                                                            <input type="number" class="form-control form-control-sm amount" name="amount[]" id="aaa"
                                                                value="{{ $details->amount }}" readonly />
                                                        @else
                                                            <input type="number" class="form-control form-control-sm amount"
                                                                name="amount[]" id="aaa" value="{{ $details->amount }}" />
                                                        @endif

                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="form-control form-control-sm" id="attachment_name_01" name="attachment_name_01[]" />
                                                                <input type="hidden" class="form-control form-control-sm" id="" name="hdn_attachment_name_01[]"
                                                                    value="{{ isset($details->attachment_name_01) ? $details->attachment_name_01 : '' }}" />
                                                                    
                                                                    @if(!empty($details->attachment_name_01))
                                                                        @php 
                                                                                $image_path = asset('uploads/conveyance_bill/')."/".$details->attachment_name_01;
                                                                                $image_check_path = public_path('uploads/conveyance_bill/')."/".$details->attachment_name_01;
                                                                        @endphp
                                                                        @if(file_exists($image_check_path))
                                                                            <div class="input-group-append">
                                                                                         
                                                                                    <a href="{{$image_path}}" class="btn btn-md btn-primary" target="_blank"><i class="fas fa-eye"></i></a> 
                                                                                
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="form-control" id="attachment_name_02" name="attachment_name_02[]" />
                                                                <input type="hidden" class="form-control" id="" name="hdn_attachment_name_02[]"
                                                                    value="{{ isset($details->attachment_name_02) ? $details->attachment_name_02 : '' }}" />


                                                                    @if(!empty($details->attachment_name_02))
                                                                        @php 
                                                                                $image_path = asset('uploads/conveyance_bill/')."/".$details->attachment_name_02;
                                                                                $image_check_path = public_path('uploads/conveyance_bill/')."/".$details->attachment_name_02;
                                                                        @endphp
                                                                        @if(file_exists($image_check_path))
                                                                            <div class="input-group-append">
                                                                                         
                                                                                    <a href="{{$image_path}}" class="btn btn-md btn-primary" target="_blank"><i class="fas fa-eye"></i></a> 
                                                                                
                                                                            </div>
                                                                        @endif
                                                                    @endif
                                                            </div>
                                                        </div>

                                                    </td>
                                                    @unless ($approval_condition == '2/2')
                                                        <td class="remove_0"><span class='btn btn-danger btn-sm'
                                                                onclick='removeTableRowOnly(this)'><i
                                                                    class='fa fa-times'></i></span>
                                                        </td>
                                                    @endunless

                                                </tr>
                                            @endforeach

                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="8">
                                                <b>Total Amount =</b>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm" id="total_bill_amount" name="total_bill_amount"
                                                    value="{{ !empty($conv_mst) ? $conv_mst->total_bill_amount : '' }}" readonly />
                                            </td>
                                        </tr>
                                    </tfoot>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>

                @php
                    $response_action = route('conveyance-bill-worklist');
                @endphp
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            <button type="button" class="btn btn-secondary uhl_save_btn"
                                                id="save_btn">Save</button>
                                                {{-- onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage, '{{ $response_action }}')" --}}
                                        </li>
                                    </ul>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

            </div>
        </section>
    </form>
</main>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openDoctorAutocomplete('#person_no_fk', 'emp_id', "employee_ind", 1, personInfo);

    function personInfo(item, obj) {
        $("#designation").val(item.designation);
        $("#department").val(item.su_name);
        $("#person_no_fkhdn").val(item.doctor_id);
    }

    $("body").addClass("sidebar-collapse");
    $(".date_picker").datepicker({
        format: 'dd/mm/yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    $(document).ready(function() {
        $('.select2').select2();
    });

    $('#type_name').on('change', function() {
        var type_value = $(this).val();
        $.ajax({
            type: "GET",
            data: {
                'type_value': type_value
            },
            url: "{{ route('urgent-trasport') }}",
            success: function(data) {
                $('#select_transport').empty();
                $.each(data, function(key, value) {
                    $('#select_transport').append($('<option>', {
                        value: key,
                        text: value
                    }));
                });
            },
        });
    });


    calculateTotalAndSerialNumbers();

    $('.amount').on('keyup', function() {
        calculateTotalAndSerialNumbers();

        $('.amount').each(function(index, currentElement) {
            var sl_no = index + 2;
            $(currentElement).parents('tr').find('.serial-number').val('Trip' + '-' + sl_no);
        });
    });

    function calculateTotalAndSerialNumbers() {
        var am = 0;
        $('.amount').each(function(index, currentElement) {
            am += $(this).val() != "" ? parseFloat($(this).val()) : 0;
        });
        $('#total_bill_amount').val(am);
    }

    function addRow3(thisElement) {
        var date_val = $("#ddd").val();
        var amount_val = $("#aaa").val();
        if (date_val === "" && amount_val === "") {
            alert("Please fill in date and amount!");
            return;
        }
        if (date_val === "") {
            alert("Please fill in date!");
            return;
        }
        if (amount_val === "") {
            alert("Please fill in amount!");
            return;
        }

        var am = 0;
        $('.amount').each(function(index, currentElement) {
            am += parseFloat($(this).val());
            $('#total_bill_amount').val(am);
            $(currentElement).parents('tr').find('.serial-number').val(index + 2);
        });

        var parentRow = $(thisElement).parents("tr");
        var newRow = parentRow.clone();
        var newRowId = $(thisElement).parents("#data-append-to3").find("tr").length + 1;

        newRow.attr("id", newRowId);
        newRow.find("[class^='remove_']").attr("class", "remove_" + newRowId);

        newRow.find(".remove_" + newRowId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'><i class='fa fa-times'></i></span>"
        );

        var select_transport = parentRow.find("#select_transport").val();
        var select_from = parentRow.find("#select_from").val();
        var select_to = parentRow.find("#select_to").val();
        var select_purpose = parentRow.find("#select_purpose").val();
        // serialNumber++;

        // newRow.find("#trip_id").val(serialNumber);

        parentRow.find("input[type='text']").val('');
        parentRow.find("input[type='number']").val(null);
        parentRow.find("input[type='file']").val(null);
        // parentRow.find("select").val('');


        // parentRow.after(newRow);
        $('#data-append-to3').append(newRow);
        $('.serial-number').each(function(index, sl) {
            var sl_no = index++;
            $(sl).val('Trip' + '-' + sl_no);
        });
        newRow.find("#select_transport").val(select_transport);
        newRow.find("#select_from").val(select_from);
        newRow.find("#select_to").val(select_to);
        newRow.find("#select_purpose").val(select_purpose);

        newRow.find(".date_picker").datepicker();
    }

    function removeTableRowOnly(thisElement) {
        var row = $(thisElement).parents("tr");
        row.remove();
        var am = 0;
        $('.amount').each(function(index, currentElement) {
            am += $(this).val() != "" ? parseFloat($(this).val()) : 0;
            // console.log(am, $(this).val());
            $('#total_bill_amount').val(am);
            var sl_no = index++;
            $(currentElement).parents('tr').find('.serial-number').val('Trip' + '-' + sl_no);
        });

    }

     $('#save_btn').click(function() {
        var trip_date = $("#table_head tr:nth-child(2)").find('.date_picker').val();
        console.log(trip_date);
        var check_record = $("#data-append-to3 tr").length;
        // console.log(check_record);
        if (check_record > 0 && trip_date == '') {
            // btnSaveUpdate($('#save_btn'), '', '', '', '', search_list);
            btnSaveUpdateUpload($('#save_btn'), '', '', '', '', dynamicFunc.afterSaveLoadPage, "{{route('conveyance-bill-worklist')}}");
        } else {
            alert("Please enter data")
        }
    })


</script>
