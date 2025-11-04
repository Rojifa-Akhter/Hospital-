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
                                <h5 class="mt-2 mb-0">Conveyance Bill</h5>
                            </div>
                        </div>
                    </div>
                </div>

                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <input type="hidden" name="hdn_conveyancebillmst_no_pk"
                            value="{{ $conv_mst->conveyancebillmst_no_pk }}">
                        <div class="card">
                            <div class="card-body border-bottom-3 p-2">
                                <div class="form-row">
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="billing_date" class="col-form-label">Billing Date</label>
                                            <input type="text" class="form-control form-control-sm date_picker"
                                                id="billing_date" name="billing_date" placeholder=""
                                                value="{{ date('d/m/y', strtotime($conv_mst->billing_date)) }}" />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="person_no_fk" class="col-form-label">Name of Person</label>
                                            <input type="text" class="form-control form-control-sm" id="person_no_fk"
                                                name="person_no_fk" placeholder="" value="{{ $conv_mst->full_name }}" />
                                            <input type="hidden" class="form-control form-control-sm"
                                                id="person_no_fkhdn" name="person_no_fkhdn" placeholder=""
                                                value="{{ $conv_mst->person_no_fk }}" />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="designation" class="col-form-label">Designation</label>
                                            <input type="text" class="form-control form-control-sm" id="designation"
                                                name="designation" placeholder="" value="{{ $conv_mst->designation }}"
                                                readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="department" class="col-form-label">Department</label>
                                            <input type="text" class="form-control form-control-sm" id="department"
                                                name="department" placeholder="" value="{{ $conv_mst->su_name }}"
                                                readonly />
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="req_by_person_no_fk" class="col-form-label">Requested By</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="req_by_person_no_fk" name="req_by_person_no_fk" placeholder=""
                                                value="{{ $requested_by_name }}" readonly />
                                            <input type="hidden" name="req_by_person_no_fk_hdn"
                                                id="req_by_person_no_fk_hdn" value="{{ $requested_by_id }}">
                                        </div>
                                    </div>

                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="req_dept" class="col-form-label">Requested Department</label>
                                            <input type="text" class="form-control form-control-sm" id="req_dept"
                                                name="req_dept" placeholder="" value="{{ $requested_by_dept }}"
                                                readonly />
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="type_name" class="col-form-label">Type of Request</label>
                                            <select class="form-control form-control-sm" id="type_name"
                                                name="type_name">
                                                <option value="">Select Type</option>
                                                <option value="Routine"
                                                    @if ($conv_mst->type_name == 'Routine') selected @endif>Routine</option>
                                                <option value="Urgent"
                                                    @if ($conv_mst->type_name == 'Urgent') selected @endif>Urgent</option>
                                            </select>
                                        </div>
                                    </div>
                                    <div class="col-lg-3 col-md-6 col-12">
                                        <div class="form-group">
                                            <label for="total_bill_amount" class="col-form-label">Total Amount</label>
                                            <input type="text" class="form-control form-control-sm"
                                                id="total_bill_amount" name="total_bill_amount" placeholder=""
                                                value="{{ $conv_mst->total_bill_amount }}" readonly />
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
                                    <thead class="global-uhl-table-bg">
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
                                    </thead>
                                    <tbody id="data-append-to3">
                                        <tr id="0">
                                            <td>
                                                <input type="text"
                                                    class="form-control form-control-sm serial-number"
                                                    name="trip_id[]" id="trip_id" value="Trip-0" readonly />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm date_picker"
                                                    name="conveyance_date[]" id="" value="" />
                                                <input type="hidden" name="hdn_conveyancebilldtl_no_pk[]"
                                                    value="">
                                            </td>
                                            <td>
                                                {{-- <input type="text" class="form-control form-control-sm"
                                                    name="transport_name[]" id="" value="" /> --}}
                                                <select name="transport_name[]" class="form-control form-control-sm"
                                                    id="select_transport">
                                                    {{-- <option value="">Select</option> --}}
                                                    @if (isset($transport_name))
                                                        @foreach ($transport_name as $key => $value)
                                                            <option value="{{ $key }}">
                                                                {{ $value }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                {{-- <input type="text" class="form-control form-control-sm"
                                                    name="from_location[]" id="" value="" /> --}}
                                                <select name="from_location[]" class="form-control form-control-sm"
                                                    id="select_from">
                                                    {{-- <option value="">Select</option> --}}
                                                    @if (isset($location_thana))
                                                        @foreach ($location_thana as $value)
                                                            <option value="{{ $value->id }}">
                                                                {{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                {{-- <input type="text" class="form-control form-control-sm"
                                                    name="to_location[]" id="" value="" /> --}}
                                                <select name="to_location[]" class="form-control form-control-sm"
                                                    id="select_to">
                                                    {{-- <option value="">Select</option> --}}
                                                    @if (isset($location_thana))
                                                        @foreach ($location_thana as $value)
                                                            <option value="{{ $value->id }}">
                                                                {{ $value->name }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                <select name="purpose_name[]" class="form-control form-control-sm"
                                                    id="">
                                                    <option value="">Select</option>
                                                    @if (isset($purposes))
                                                        @foreach ($purposes as $key => $value)
                                                            <option value="{{ $key }}">
                                                                {{ $value }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="description[]" id="" value="" />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm"
                                                    name="remarks[]" id="" value="" />
                                            </td>
                                            <td>
                                                <input type="text" class="form-control form-control-sm amount"
                                                    name="amount[]" id="" value="" />
                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="form-control"
                                                            id="attachment_name_01" name="attachment_name_01[]" />
                                                    </div>
                                                </div>

                                            </td>
                                            <td>
                                                <div class="input-group">
                                                    <div class="custom-file">
                                                        <input type="file" class="form-control"
                                                            id="attachment_name_02" name="attachment_name_02[]" />
                                                    </div>
                                                </div>

                                            </td>

                                            <td>
                                                <span type="button" id="med_td_action_0" onclick="addRow3(this)"
                                                    class="btn btn-secondary btn-sm">Add</span>
                                            </td>
                                        </tr>

                                        @if (!empty($conv_details))
                                            @foreach ($conv_details as $kye => $details)
                                                <tr id="0">
                                                    <td>
                                                        <input type="text"
                                                            class="form-control form-control-sm serial-number"
                                                            name="trip_id[]" id="trip_id"
                                                            value="{{ $details->trip_sl }}" readonly />
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control form-control-sm date_picker"
                                                            name="conveyance_date[]" id=""
                                                            value="{{ date('d/m/Y', strtotime($details->conveyance_date)) }}" />
                                                        <input type="hidden" name="hdn_conveyancebilldtl_no_pk[]"
                                                            value="{{ $details->conveyancebilldtl_no_pk }}">
                                                    </td>
                                                    <td>
                                                        {{-- <input type="text" class="form-control form-control-sm"
                                                            name="transport_name[]" id=""
                                                            value="{{ $details->transport_name }}" /> --}}
                                                        <select name="transport_name[]"
                                                            class="form-control form-control-sm"
                                                            id="select_transport">
                                                            {{-- <option value="">Select</option> --}}
                                                            @if (isset($transport_name))
                                                                @foreach ($transport_name as $key => $value)
                                                                    <option value="{{ $key }}"
                                                                        @if ($details->transport_name_lookup_data_fk == $key) selected @endif>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td>
                                                        {{-- <input type="text" class="form-control form-control-sm"
                                                            name="from_location[]" id=""
                                                            value="{{ $details->from_location }}" /> --}}
                                                        <select name="from_location[]"
                                                            class="form-control form-control-sm" id="select_from">
                                                            {{-- <option value="">Select</option> --}}
                                                            @if (isset($location_thana))
                                                                @foreach ($location_thana as $value)
                                                                    <option value="{{ $value->id }}"
                                                                        @if ($value->id == $details->from_location_lookup_data_fk) selected @endif>
                                                                        {{ $value->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td>
                                                        {{-- <input type="text" class="form-control form-control-sm"
                                                            name="to_location[]" id=""
                                                            value="{{ $details->to_location }}" /> --}}
                                                        <select name="to_location[]"
                                                            class="form-control form-control-sm" id="select_to">
                                                            {{-- <option value="">Select</option> --}}
                                                            @if (isset($location_thana))
                                                                @foreach ($location_thana as $value)
                                                                    <option value="{{ $value->id }}"
                                                                        @if ($value->id == $details->to_location_lookup_data_fk) selected @endif>
                                                                        {{ $value->name }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <select name="purpose_name[]"
                                                            class="form-control form-control-sm" id="">
                                                            <option value="">Select</option>
                                                            @if (isset($purposes))
                                                                @foreach ($purposes as $key => $value)
                                                                    <option value="{{ $key }}"
                                                                        @if ($key == $details->purpose_lookupdata_no_fk) selected @endif>
                                                                        {{ $value }}
                                                                    </option>
                                                                @endforeach
                                                            @endif
                                                        </select>
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="description[]" id=""
                                                            value="{{ $details->description }}" />
                                                    </td>
                                                    <td>
                                                        <input type="text" class="form-control form-control-sm"
                                                            name="remarks[]" id=""
                                                            value="{{ $details->remarks }}" />
                                                    </td>
                                                    <td>
                                                        <input type="text"
                                                            class="form-control form-control-sm amount"
                                                            name="amount[]" id=""
                                                            value="{{ $details->amount }}" />
                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="form-control"
                                                                    id="attachment_name_01"
                                                                    name="attachment_name_01_{{ $details->conveyancebilldtl_no_pk }}" />
                                                                <input type="hidden" class="form-control"
                                                                    id="attachment_img_name_01"
                                                                    name="attachment_img_name_01[]"
                                                                    value="{{ $details->attachment_name_01 }}" />
                                                            </div>
                                                        </div>

                                                    </td>
                                                    <td>
                                                        <div class="input-group">
                                                            <div class="custom-file">
                                                                <input type="file" class="form-control"
                                                                    id="attachment_name_02"
                                                                    name="attachment_name_02[]" />

                                                                <input type="hidden" class="form-control"
                                                                    id="attachment_img_name_02"
                                                                    name="attachment_img_name_02[]"
                                                                    value="{{ $details->attachment_name_02 }}" />
                                                            </div>
                                                        </div>

                                                    </td>

                                                    <td>
                                                        <span class='btn btn-danger btn-sm'
                                                            onclick='removeTableRowOnly(this)'> <i
                                                                class='fa fa-times'></i> </span>
                                                    </td>
                                                </tr>
                                            @endforeach

                                        @endif
                                    </tbody>
                                    <tfoot>
                                        <tr>
                                            <td colspan="8">
                                                Total Amount =
                                            </td>
                                            <td>
                                                {{-- <label for="total_bill_amount" class="col-form-label">Total
                                                    Amount</label> --}}
                                                <input type="text" class="form-control form-control-sm"
                                                    id="total_bill_amount" name="total_bill_amount" value=""
                                                    readonly />
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
                                                onclick="btnSaveUpdateUpload(this,'','','','', dynamicFunc.afterSaveLoadPage, '{{ $response_action }}')"
                                                id="">Save</button>
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
        console.log(item)
        $("#designation").val(item.designation);
        $("#department").val(item.su_name);
        $("#person_no_fkhdn").val(item.doctor_id);
    }

    $("body").addClass("sidebar-collapse");
    $(".date_picker").datepicker({
        format: 'mm/dd/yyyy',
        autoclose: true,
        todayHighlight: true,
        clearBtn: true
    });

    $(document).ready(function() {
        $('.select2').select2();
    });

    function addRow3(thisElement) {
        var am = 0;
        $('.amount').each(function(index, currentElement) {
            am += parseFloat($(this).val());
            $('#total_bill_amount').val(am);
            // console.log(am);
        });

        var row = $(thisElement).parents("tr").clone();
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        var newId = $(thisElement).parents("#data-append-to3").find("tr").length + 1;
        row.attr('id', newId);
        row.find("input").val("");

        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        $(thisElement).parents("#data-append-to3").append(row);

        $('#med_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );
        row.find(".date_picker").datepicker();

    }

    function removeTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        return;
    }
</script>
