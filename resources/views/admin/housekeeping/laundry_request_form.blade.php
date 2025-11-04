<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <form action="{{ route('housekeeping-store-requst') }}" method="post" id="laundry-request-create">
            @csrf
            <div class="form-group row">

                <div class="col-md-12">
                    <label for="laundry_name" class="col-form-label col-form-label-sm">Laundry Name <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="laundry_name" name="laundry_name"
                        value="" placeholder="Enter Laundry Name" required>
                </div>

                <div class="col-md-6">
                    <label for="date_l" class="col-form-label col-form-label-sm">Date <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm date_picker" id="date_l" name="date_l"
                        value="" placeholder="Date" required>
                </div>

                <div class="col-md-6">
                    <label for="laundry_person" class="col-form-label col-form-label-sm">Laundry Person</label>
                    <input type="text" class="form-control form-control-sm" id="laundry_person" name="laundry_person"
                        value="" placeholder="Enter Laundry Person">
                </div>
                <div class="col-md-6">
                    <label for="laundry_contact" class="col-form-label col-form-label-sm">Laundry Contact </label>
                    <input type="text" class="form-control form-control-sm" id="laundry_contact"
                        name="laundry_contact" value="" placeholder="Enter Laundry Contact">
                </div>

                <div class="col-md-6">
                    <label for="user_name" class="col-form-label col-form-label-sm">Sent By <span
                            class="text-danger">*</span></label>
                    <input type="text" class="form-control form-control-sm" id="user_name" name="user_name"
                        value="" placeholder="Enter Laundry Contact" required>
                    <input type="hidden" id="doctor_id" name="doctor_id" value="" />
                    <div><strong>
                            <p id="autocomplete_data"></p>
                        </strong></div>
                </div>
            </div>



            <div class="modal-footer mt-1">
            </div>
            <div class="form-group row" id="loundry_item">
                <div class="card-body p-2">
                    <table class="table border-0 mt-2 mb-0">
                        <thead>
                            <tr class="">
                                <th class="border-0">Item Name </th>
                                <th class="border-0">Qty.</th>
                                <th class="border-0">Remarks</th>
                                <th class="border-0"></th>
                            </tr>
                        </thead>

                        <tbody id="data-append-to">
                            <tr class="border-0" id="0">
                                <td class="p-0 px-1 border-0">
                                    <input type="text" class="form-control form-control-sm" id="item_name_0"
                                        name="item_name[]" value="" placeholder="Enter Item Name">
                                    <input type="hidden" name="item_hidden_id[]" value="" id="item_hidden_id_0">
                                </td>
                                <td class="p-0 px-1 border-0">
                                    <input type="text" class="form-control form-control-sm number_only"
                                        id="qty_0" name="qty[]" value="" placeholder="Enter Qty.">
                                </td>
                                <td class="p-0 px-1 border-0">
                                    <input type="text" class="form-control form-control-sm" id="item_remarks_0"
                                        name="item_remarks[]" value="" placeholder="Enter Remarks">
                                </td>
                                <td class="p-0 px-1 border-0" style="vertical-align: top;" id="laundry_td_action_0">
                                    <span class="btn btn-success btn-sm" id="laundry_btn" onclick="addNewRow(this)">
                                        <i class="fa fa-plus"></i> </span>
                                </td>
                            </tr>
                        </tbody>
                    </table>
                </div>

            </div>
            @php
                $response_action = url('housekeeping/worklist');
            @endphp
            <button type="submit" class="btn btn-md btn-outline-success"
                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save
                changes</button>
        </form>
    </div>
</div>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#user_name', 'doctor_id');
    openItemAutocomplete($("#item_name_0"), "", "#item_hidden_id_0", "#item_name_0");

    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'yyyy-mm-dd',
    });

    function addNewRow(thisElement) {
        var row = $(thisElement).parents("tr").clone();

        var newId = $(thisElement).parents("#data-append-to").find("tr").length;
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        row.find('#laundry_td_action_' + oldId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );
        row.attr('id', newId);


        row.find('#item_name_' + oldId).attr('id', 'item_name_' + newId);
        row.find('#item_hidden_id_' + oldId).attr('id', 'item_hidden_id_' + newId);
        row.find('#qty_' + oldId).attr('id', 'qty_' + newId);
        row.find('#item_remarks_' + oldId).attr('id', 'item_remarks_' + newId);


        row.find('#item_name_' + newId).val($(thisElement).parents('tbody').find('#item_name_' +
            oldId).val());
        row.find('#item_hidden_id_' + newId).val($(thisElement).parents('tbody').find('#item_hidden_id_' +
            oldId).val());
        row.find('#qty_' + newId).val($(thisElement).parents('tbody').find('#qty_' +
            oldId).val());
        row.find('#item_remarks_' + newId).val($(thisElement).parents('tbody').find('#item_remarks_' +
            oldId).val());


        $(thisElement).parents('tbody').find('#item_name_' + oldId).val('');
        $(thisElement).parents('tbody').find('#item_hidden_id_' + oldId).val('');
        $(thisElement).parents('tbody').find('#qty_' + oldId).val('');
        $(thisElement).parents('tbody').find('#item_remarks_' + oldId).val('');


        $(thisElement).parents("#data-append-to").append(row);
        $("#item_name_0").typeahead("destroy");
        openItemAutocomplete($("#item_name_0"), "INV", "#item_id_0", "#item_name_0");
        $("#item_name_0").focus();
    }
</script>
