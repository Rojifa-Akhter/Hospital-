<form action="#">
    <div class="modal-body">
        <div class="card bg-light-blue mt-0">
            <div class="card-body p-2">
                <div class="form-row">
                    <span><b>Generic:</b> {{ !empty($item_dt->item_name) ? ucwords($item_dt->item_name) : 'N/A' }},
                        &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Brand:</b>
                        {{ !empty($item_dt->supplier_name) ? ucwords($item_dt->supplier_name) : 'N/A' }}
                        , &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;<b>Route:</b>
                        {{ !empty($route) ? ucwords($route) : 'N/A' }}</span>
                </div>
            </div>
        </div>

        <div class="card bg-light-blue">
            <div class="card-body p-2">
                <table class="table border-0 mt-2 mb-0">
                    <thead>
                        <tr class="">
                            <th class="border-0">Dose </th>
                            <th class="border-0">Duration</th>
                            {{-- <th class="border-0">Qty.</th> --}}
                            <th class="border-0">Instruction</th>
                            <th class="border-0"></th>
                        </tr>
                    </thead>

                    <tbody id="data-append-to">
                        <input type="hidden" name="item_id" value="{{ $item_dt->item_no_pk }}" id="item_id">
                        <input type="hidden" name="item_name" value="{{ $item_dt->item_name }}" id="item_name">
                        <input type="hidden" name="data_row_id" value="{{ $data_row_id }}" id="data_row_id">

                        <tr class="border-0" id="0">
                            <td class="p-0 px-1 border-0">
                                {{-- <select class="form-control form-control-sm select2 m-0 p-0 medicine_dose"
                                    id="medicine_dose_0" name="medicine_dose[]"
                                    prescriptionFunc.calculateMedicineQnty(this);">
                                    <option value="0">Select</option>
                                    @if (!empty($dose))
                                        @foreach ($dose as $key => $dmu)
                                            <option data-qnty="">
                                                {{ $dmu['data'] }}</option>
                                        @endforeach
                                    @endif
                                </select> --}}
                                <div class="" id="doseID" style="display: flex">
                                    <div>


                                        <select class="form-control m-0 p-0 medicine_dose doseEdit select2"
                                            id="medicine_dose_0" name="medicine_dose[]"
                                            onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose');prescriptionFunc.calculateMedicineQnty(this)">
                                            <option value="0">Select</option>
                                            <option data-qnty="0" data-dropdown_option="add_more"
                                                data-popup_header="Medicine Dose" data-input_label="Dose"
                                                data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                                value="0">Add More</option>
                                            @if (!empty($dose))
                                                @foreach ($dose as $key => $dmu)
                                                    <option value="{{ $key }}">{{ $dmu['data'] }}</option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                    <div class="editDosButton" id="medicine_dose_0" style="display:none;"
                                        onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editDosButton');"
                                        data-qnty="0" data-dropdown_option_edit="edit_option_dose"
                                        data-popup_header="Medicine Dose" data-input_label="Dose"
                                        data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                        value="0">
                                        <span class="btn btn-success btn-sm" type="button"
                                            style="padding: 2px 2px 2px 2px !important"> <i class="fa fa-edit"></i></span>
                                    </div>
                                </div>
                            </td>






                            <td class="p-0 px-1 border-0">
                                <div class="input-group">


                                    <input type="text"
                                        class="form-control form-control-sm m-0 p-0 medicine_duration number_only"
                                        id="medicine_duration_type_0" name="medicine_duration_type[]"
                                        onkeyup="prescriptionFunc.calculateMedicineQnty(this)">

                                    <select class="form-control medicine_duration_mu" id="medicine_duration_mu_0"
                                        name="medicine_duration_mu[]">
                                        @if (!empty($meddurmu))
                                            @foreach ($meddurmu as $key => $dmu)
                                                <option value="{{ strtoupper($key) }}">
                                                    @if ($dmu['data'] == 'Day')
                                                        দিন
                                                    @elseif($dmu['data'] == 'Hour')
                                                        ঘন্টা
                                                    @elseif($dmu['data'] == 'Week')
                                                        সপ্তাহ
                                                    @else
                                                        মাস
                                                    @endif
                                                </option>
                                            @endforeach
                                        @endif
                                    </select>
                                </div>
                            </td>
                            {{-- <td class="p-0 px-1 border-0">
                                <div class="input-group">
                                    <input type="text" class="form-control form-control-sm m-0 p-0 medicine_quantity"
                                        id="medicine_quantity_0" name="medicine_quantity[]">

                                </div>
                            </td> --}}
                            <td class="p-0 px-1 border-0">
                                <select class="form-control form-control-sm select2 m-0 p-0 medicine_instruction"
                                    id="instruction_0" name="instruction[]">
                                    <option value="0">Select</option>
                                    @if (!empty($instructions))
                                        @foreach ($instructions as $key => $dmu)
                                            <option value="{{ $key }}">{{ $dmu['data'] }}</option>
                                        @endforeach
                                    @endif
                                </select>
                            </td>

                            <td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_td_action_0">
                                <span class="btn btn-success btn-sm" id="med_span" onclick="addMedRow(this)"> <i
                                        class="fa fa-plus"></i> </span>

                                {{-- <span class="btn btn-success btn-sm" id="med_span"
                                data-multidose-action="{{route("add-multidose")}}"
                                onclick="prescriptionFunc.addMedRow(this)"> <i class="fa fa-plus"></i> </span> --}}
                            </td>
                            {{-- <td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_td_action_0">
                            <span class="btn btn-success btn-sm" id="med_span"
                                onclick="addMedRow(this)"> <i class="fa fa-plus"></i> </span>
                        </td> --}}
                        </tr>



                        @if (!empty($med_dt))
                            @php $i=1 @endphp
                            @foreach ($med_dt as $med_row)
                                <?php
                                $dose_data = explode('~', $med_row);

                                ?>
                                @if ($dose_data >= 0)
                                    <tr class="border-0" id="{{ $i }}">

                                        <td class="p-0 px-1 border-0">
                                            <select class="form-control form-control-sm select2 m-0 p-0 medicine_dose"
                                                id="medicine_dose_{{ $i }}" name="medicine_dose[]"
                                                prescriptionFunc.calculateMedicineQnty(this);">
                                                <option value="0">Select</option>

                                                @if (!empty($dose))
                                                    @foreach ($dose as $key => $dmu)
                                                        @if ($dose_data[0] == $key)
                                                            <option data-qnty="" value="{{ $key }}"
                                                                selected="selected">{{ $dmu['data'] }}</option>
                                                        @else
                                                            <option data-qnty="" value="{{ $key }}">
                                                                {{ $dmu['data'] }}</option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>

                                        <td class="p-0 px-1 border-0">
                                            <div class="input-group">
                                                <input type="text"
                                                    class="form-control form-control-sm m-0 p-0 medicine_duration"
                                                    id="medicine_duration_type_{{ $i }}"
                                                    name="medicine_duration_type[]"
                                                    onkeyup="prescriptionFunc.calculateMedicineQnty(this)"
                                                    value="{{ $dose_data[1] }}">

                                                <select class="form-control medicine_duration_mu"
                                                    id="medicine_duration_mu_{{ $i }}"
                                                    name="medicine_duration_mu[]"
                                                    onchange="prescriptionFunc.calculateMedicineQnty(this)">
                                                    @if (!empty($meddurmu))
                                                        @foreach ($meddurmu as $key => $dmu)
                                                            @if ($dose_data[2] == strtoupper($key))
                                                                <option value="{{ strtoupper($key) }}"
                                                                    selected="selected"> দিন</option>
                                                            @else
                                                                <option value="{{ strtoupper($key) }}">
                                                                    @if ($dmu['data'] == 'Day')
                                                                        দিন
                                                                    @elseif($dmu['data'] == 'Hour')
                                                                        ঘন্টা
                                                                    @elseif($dmu['data'] == 'Week')
                                                                        সপ্তাহ
                                                                    @else
                                                                        মাস
                                                                    @endif
                                                                </option>
                                                            @endif
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>
                                        </td>

                                        {{-- <td class="p-0 px-1 border-0">
                                            <input type="text"
                                                class="form-control form-control-sm m-0 p-0 medicine_quantity"
                                                id="medicine_quantity_{{ $i }}" name="medicine_quantity[]"
                                                value="{{ $dose_data[3] }}">
                                        </td> --}}


                                        <td class="p-0 px-1 border-0">
                                            <select
                                                class="form-control form-control-sm select2 m-0 p-0 medicine_instruction"
                                                id="instruction_{{ $i }}" name="instruction[]"">
                                                <option value="0">Select</option>
                                                @if (!empty($instructions))
                                                    @foreach ($instructions as $key => $dmu)
                                                        @if ($dose_data[4] == $key)
                                                            <option value="{{ $key }}" selected="selected">
                                                                {{ $dmu['data'] }}</option>
                                                        @else
                                                            <option value="{{ $key }}">{{ $dmu['data'] }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @endif

                                            </select>
                                        </td>

                                        <td class="p-0 px-1 border-0" style="vertical-align: top;"
                                            id="med_td_action_{{ $i }}">
                                            <span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i
                                                    class='fa fa-times'></i> </span>
                                        </td>
                                    </tr>
                                    @php
                                        $i++;
                                    @endphp
                                @endif
                            @endforeach
                        @endif
                    </tbody>
                </table>

            </div>
        </div>
    </div>
    <div class="modal-footer py-1">
        <div class="row">
            <div class="col-md-12 text-right">
                <button type="button" class="btn btn-sm btn-secondary" data-dismiss="modal">Close</button>
                <button type="button" class="btn btn-sm btn-primary" onclick="setDose(this)"> Add Doses</button>
            </div>
        </div>
    </div>
</form>

<script>
    var setDoses = [];

    function addMedRow(thisElement) {
        var lookup_code = $(thisElement).attr("data-lookup-code");


        var item_id = item_name = "";
        var item_id = $("#item_id").val();
        var item_name = $("#item_name").val();
        if (lookup_code == "MED") {
            var item_id = $("#item_id").val();
            var item_name = $("#item_name").attr("data-item-name");

            var data_route_med = $(thisElement).attr("data-route-med");
            var data_dose_med = $(thisElement).attr("data-dose-med");
            var data_duration_med = $(thisElement).attr("data-duration-med");
            var data_duration_mu_med = $(thisElement).attr("data-duration-mu-med");
            var data_quantity_med = $(thisElement).attr("data-quantity-med");
            var data_instruction_med = $(thisElement).attr("data-instruction-med");

            thisElement = $("#med_td_action_0 span");
        }
        var row = $(thisElement).parents("tr").clone();

        var newId = $(thisElement).parents("#data-append-to").find("tr").length;
        var oldId = Number($(thisElement).parents("tr").attr("id"));

        row.find('#med_td_action_' + oldId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );
        row.attr('id', newId);
        row.find('#hdn_report_serial_med_' + oldId).attr('id', 'hdn_report_serial_med_' + newId);
        row.find('#hdn_medicine_item_id_' + oldId).attr('id', 'hdn_medicine_item_id_' + newId);
        row.find('#medicine_item_' + oldId).attr('id', 'medicine_item_' + newId).css({
            "background-color": "#ffffff",
            "border": "0px"
        });
        row.find('#med_favourit_' + oldId).attr('id', 'med_favourit_' + newId);
        row.find('#medicine_dose_' + oldId).attr('id', 'medicine_dose_' + newId);
        row.find('#medicine_duration_mu_' + oldId).attr('id', 'medicine_duration_mu_' + newId);
        row.find('#medicine_duration_type_' + oldId).attr('id', 'medicine_duration_type_' + newId);
        row.find('#medicine_quantity_' + oldId).attr('id', 'medicine_quantity_' + newId);
        row.find('#instruction_' + oldId).attr('id', 'instruction_' + newId);
        row.find('#medicine_route_' + oldId).attr('id', 'medicine_route_' + newId);
        row.find('#is_continue_' + oldId).attr('id', 'is_continue_' + newId);
        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);

        var interaction_route = $("#hdn_interaction_url").val();
        var hdn_patient_id = $("#hdn_patient_id").val();
        if (lookup_code == "MED") {
            row.find('#hdn_medicine_item_id_' + newId).val(item_id);
            row.find('#medicine_item_' + newId).val(item_name);
            row.find('#medicine_route_' + newId).val(data_route_med).change();
        }

        row.find('#is_continue_' + newId).val(newId);

        row.find('#hdn_report_serial_med_' + newId).val($(thisElement).parents('tbody').find('#hdn_report_serial_med_' +
            oldId).val());
        row.find('#medicine_dose_' + newId).val($(thisElement).parents('tbody').find('#medicine_dose_' + oldId).val());
        row.find('#medicine_duration_type_' + newId).val($(thisElement).parents('tbody').find(
            '#medicine_duration_type_' + oldId).val());
        row.find('#instruction_' + newId).val($(thisElement).parents('tbody').find('#instruction_' + oldId).val());
        row.find('#medicine_route_' + newId).val($(thisElement).parents('tbody').find('#medicine_route_' + oldId)
            .val());
        row.find('#medicine_duration_mu_' + newId).val($(thisElement).parents('tbody').find('#medicine_duration_mu_' +
            oldId).val());

        $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');
        $(thisElement).parents('tbody').find('#hdn_medicine_item_id_' + oldId).val('');
        $(thisElement).parents('tbody').find('#medicine_item_' + oldId).val('');
        // $(thisElement).parents('tbody').find('#medicine_dose_' + oldId).val('0');

        // $(thisElement).parents('tbody').find('#medicine_dose_' + oldId).select2("val", "0");
        $(thisElement).parents('tbody').find('#medicine_duration_mu_' + oldId).val('DAY');


        $(thisElement).parents('tbody').find('#medicine_duration_type_' + oldId).val('0');
        $(thisElement).parents('tbody').find('#medicine_quantity_' + oldId).val('');
        // $(thisElement).parents('tbody').find('#instruction_' + oldId).val('0');
        // $(thisElement).parents('tbody').find('#instruction_' + oldId).select2("val", "0");
        // $(thisElement).parents('tbody').find('#medicine_route_' + oldId).val('0');
        // $(thisElement).parents('tbody').find('#medicine_route_' + oldId).select2("val", "0");

        var add_fav_list_action = $(thisElement).attr("data-favourit-action");
        var data_multidose_action = $(thisElement).attr("data-multidose-action");
        var med_item_id = row.find('#hdn_medicine_item_id_' + newId).val();
        var med_item_name = row.find('#medicine_item_' + newId).val();


        var med_dose = row.find('#medicine_dose_' + newId).val();
        var med_route = row.find('#medicine_route_' + newId).val();
        var med_duration = row.find('#medicine_duration_type_' + newId).val();
        // var med_quantity = row.find('#medicine_quantity_' + newId).val();
        var med_quantity = '';
        var med_continue = row.find('#is_continue_' + newId).val();
        var med_instruction = row.find('#instruction_' + newId).val();
        var med_duration_type = row.find('#medicine_duration_mu_' + newId).val();


        row.find('#med_favourit_' + newId).html(
            '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
            add_fav_list_action + '" data-id="' + med_item_id + '" data-name="' + med_item_name +
            '" data-type="MED" data-duration="' + med_duration + '" data-route="' + med_route + '" data-dose="' +
            med_dose + '" data-quantity="' + med_quantity + '" data-continue="' + med_continue +
            '" data-instruction="' + med_instruction + '" data-duration-type="' + med_duration_type +
            '"><i class="fa fa-star text-primary"></i></span> <br />  <span class="float-right text-secondary mr-1 cursor-pointer" data-modal="common-modal-xl" style="font-size:11px;" title="Add Multidose Medicine" onclick="prescriptionFunc.addMultidoseList(this)" data-action="' +
            data_multidose_action + '" data-id="' + med_item_id + '" data-name="' + med_item_name +
            '" data-type="MED" data-duration="' + med_duration + '" data-route="' + med_route + '" data-dose="' +
            med_dose + '" data-quantity="' + med_quantity + '" data-continue="' + med_continue +
            '" data-instruction="' + med_instruction + '" data-duration-type="' + med_duration_type +
            '"><i class="fa fa-angle-double-right text-danger"></i></span>');

        var item_id = row.find('#hdn_medicine_item_id_' + newId).val();
        var interaction_result = '';

        $(thisElement).parents("#data-append-to").append(row);
        $("#medicine_item_0").typeahead("destroy");
        // openItemAutocompleteWithStock($("#medicine_item_0"), 'MED', '#hdn_medicine_item_id_0', '#medicine_item_0');
        openItemAutocomplete($("#medicine_item_0"), "MED", "#hdn_medicine_item_id_0", "#medicine_item_0");
        $("#medicine_item_0").focus();

        setDoses.push(med_dose + '~' + med_duration + '~' + med_duration_type + '~' + med_quantity + '~' +
            med_instruction);




    }



    function setDose(element) {

        var id = $('#data_row_id').val();
        console.log(id)

        $('#tr_id_' + id).find('td:first-child').append(
            `<span><input type="hidden" id="hidden_multidose_id_${id}" value="${setDoses.join()}" name="multidose[]"><span class="badge bg-secondary text-white">${setDoses.join()}</span> <span class="btn btn-danger btn-sm" onclick="removeDose(this)"> <i class="fa fa-times"></i> </span></span>`
        );


        // $('#tr_id_'+id).find('td:first-child').append(`<span>${setDoses.join()} <span class="btn btn-danger btn-sm" onclick="removeDose(this)"> <i class="fa fa-times"></i> </span></span>`);

        console.log(setDoses.join());

        $('.exampleModal ').modal('hide');
        // setDoses=[];
    }










    function med_add() {

        var item_id = $('#hd_item_id').val();
        var batch_name = $('#batch_no').val();
        var exp_date = $('#exp_date').val();
        var qty = $('#qty').val();
        var item_p = $('#hidn_item_price').val();
        var item_uom_no_fk = $('#hidn_item_uom_no_fk').val();
        var item_conversion = $('#hidn_item_conversion').val();
        if (qty != "") {
            $('#myTable tr:last').after("<tr class='data_class' data-batch_name='" + batch_name + "' data-exp_date='" +
                exp_date + "' data-qty='" + qty + "' data-item_prices='" + item_p +
                "' data-uom='" + item_uom_no_fk + "'data-conversion='" + item_conversion +
                "'><td ><input type='text' style='border:none;' name='edit_batch_name[]' id='edit_batch_name' readonly='readonly'  value='" +
                batch_name +
                "'></td><td ><input type='text' name='edit_exp_date[]' id='edit_exp_date' readonly='readonly'  class='w-100 date_picker' style='border: none;' value='" +
                exp_date +
                "'></td><td  ><input type='text' name='edit_qty[]' id='edit_sales_qty'  class='text-right w-100 edit_sales_qty' style='border: none;' value='" +
                qty +
                "'></td><td class='text-right' ><span class='btn btn-sm btn-danger' data-id='' onclick='removeTableRowOnly(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></span><input type='hidden' name='item_prices[]' value='" +
                item_p + "'><input type='hidden' id='item_uoms_" + item_id +
                "' name='item_uoms[]' class='item_uoms' value='" +
                item_uom_no_fk + "'><input type='hidden' id='conversion_" + item_id +
                "' name='conversion[]' class='conversion' value='" +
                item_conversion + "'></td></tr>");

            $('#batch_no').val('');
            $('#exp_date').val('');
            $('#qty').val('');
        } else {
            alert("Invalid value ");
            return;
        }

    }
</script>
