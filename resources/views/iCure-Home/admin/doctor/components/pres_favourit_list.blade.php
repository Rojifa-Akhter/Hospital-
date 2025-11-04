@if (!empty($favourit_data))
    @foreach ($favourit_data as $row)
        <tr>
            <td class="p-0 p-1 text-left w-75" data-id="{{ $row->pres_fav_no_pk }}">{{ $row->favourite_name }}</td>
            <td class="p-0 p-1 text-center">
                @php
                    $item_type_arr = ['SERVICE', 'SUR', 'RAD', 'LAB', 'MED'];
                    if (in_array($row->item_type_lookup_code, $item_type_arr)) {
                        $item_id = $row->favourite_item_no_fk;
                        $item_code = $row->item_type_lookup_code;
                    } else {
                        $item_id = $row->pres_fav_no_pk;
                        $item_code = $row->psn_lookup_uid;
                    }
                @endphp
                @if ($row->item_type_lookup_code == 'MED')
                    <input type="checkbox" class="favourit_list_item" data-item-name="{{ $row->favourite_name }}"
                        value="{{ $item_id }}" data-lookup-code="{{ $item_code }}"
                        data-lookup-id="{{ $row->pres_lookup_no_fk }}"
                        data-lookup-data-code="{{ $row->psn_lookupdata_uid }}" onchange="addMedRow(this)">
                @else
                    @if (isset($su_info->dental_ind))
                        @if ($su_info->dental_ind == 1)
                            <input type="checkbox" class="favourit_list_item"
                                data-item-name="{{ $row->favourite_name }}" value="{{ $item_id }}"
                                data-lookup-code="{{ $item_code }}" data-lookup-id="{{ $row->pres_lookup_no_fk }}"
                                data-lookup-data-code="{{ $row->psn_lookupdata_uid }}"
                                onchange="prescriptionFunc.addTeethFindingsFromFavouritList(this)">


                        @endif
                    @endif
                    <input type="checkbox" class="favourit_list_item" data-item-name="{{ $row->favourite_name }}"
                        value="{{ $item_id }}" data-lookup-code="{{ $item_code }}"
                        data-lookup-id="{{ $row->pres_lookup_no_fk }}"
                        data-lookup-data-code="{{ $row->psn_lookupdata_uid }}"
                        onchange="prescriptionFunc.addFromFavouritList(this)">
                @endif
            </td>
            <td class="p-0 p-1 text-center" valign="top" data-favourit-id="{{ $row->pres_fav_no_pk }}"
                data-lookup-code="{{ $item_code }}" data-action="{{ route('remove-from-pres-favourit-list') }}"
                onclick="prescriptionFunc.removeFromPresFavouritList(this)"><i class="fa fa-times text-danger pt-0"></i>
            </td>
        </tr>
    @endforeach
@endif
<script>
    function addMedRow(thisElement) {
        console.log(thisElement + 'nazmul')

        var lookup_code = $(thisElement).attr("data-lookup-code");
        var item_id = item_name = "";
        if (lookup_code == "MED") {
            var item_id = $(thisElement).val();
            var item_name = $(thisElement).attr("data-item-name");
            thisElement = $("#med_span");
        }
        var row = $(thisElement).parents("tr").clone();
        var newId = $(thisElement).parents("#data-append-to").find("tr").length;
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        console.log(newId, oldId, $(thisElement).parents("tr").attr("id"));
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
        //row.find('#is_chronic_' + oldId).attr('id', 'is_chronic_' + newId);
        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);

        var interaction_route = $("#hdn_interaction_url").val();
        var hdn_patient_id = $("#hdn_patient_id").val();

        if (lookup_code == "MED") {
            row.find('#hdn_medicine_item_id_' + newId).val(item_id);
            row.find('#medicine_item_' + newId).val(item_name);
        }

        row.find('#is_continue_' + newId).val(newId);
        //row.find('#is_chronic_' + newId).val(newId);

        row.find('#hdn_report_serial_med_' + newId).val($(thisElement).parents('tbody').find(
            '#hdn_report_serial_med_' + oldId).val());
        row.find('#medicine_dose_' + newId).val($(thisElement).parents('tbody').find('#medicine_dose_' + oldId)
            .val());
        row.find('#medicine_duration_type_' + newId).val($(thisElement).parents('tbody').find(
            '#medicine_duration_type_' + oldId).val());
        row.find('#instruction_' + newId).val($(thisElement).parents('tbody').find('#instruction_' + oldId).val());
        row.find('#medicine_route_' + newId).val($(thisElement).parents('tbody').find('#medicine_route_' + oldId)
            .val());
        row.find('#medicine_duration_mu_' + newId).val($(thisElement).parents('tbody').find(
            '#medicine_duration_mu_' + oldId).val());

        $(thisElement).parents('tbody').find('#hdn_report_serial_med_' + oldId).val('');
        $(thisElement).parents('tbody').find('#hdn_medicine_item_id_' + oldId).val('');
        $(thisElement).parents('tbody').find('#medicine_item_' + oldId).val('');
        $(thisElement).parents('tbody').find('#medicine_dose_' + oldId).val('0');
        $(thisElement).parents('tbody').find('#medicine_duration_mu_' + oldId).val('DAY');
        $(thisElement).parents('tbody').find('#medicine_duration_type_' + oldId).val('0');
        $(thisElement).parents('tbody').find('#medicine_quantity_' + oldId).val('');
        $(thisElement).parents('tbody').find('#instruction_' + oldId).val('0');
        $(thisElement).parents('tbody').find('#medicine_route_' + oldId).val('0');

        var add_fav_list_action = $(thisElement).attr("data-favourit-action");
        var med_item_id = row.find('#hdn_medicine_item_id_' + newId).val();
        var med_item_name = row.find('#medicine_item_' + newId).val();
        row.find('#med_favourit_' + newId).html(
            '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
            add_fav_list_action + '" data-id="' + med_item_id + '" data-name="' + med_item_name +
            '" data-type="MED"><i class="fa fa-star text-primary"></i></span>');

        var item_id = row.find('#hdn_medicine_item_id_' + newId).val();
        var interaction_result = '';
        //Interaction hide
        // $.ajax({
        //     async: false,
        //     url: interaction_route,
        //     data: { item_id: item_id, hdn_patient_id: hdn_patient_id },
        //     type: "post",
        //     success: function (data) {
        //         if (data.result != '0') {
        //             interaction_result = '<blockquote class="blockquote"><p class="mb-0">' + data.msg + '</p><footer class="blockquote-footer"><div class="btn btn-outline-danger bg-none btn-md">' + data.seviriaty + '</div></footer></blockquote>';
        //             var msg = interaction_result + '<div class="modal-footer pl-0"><button type="button" class="btn btn-success btn-sm ml-0" id="modal-btn-si" data-dismiss="modal"><i class="fa fa-check"></i> Continue</button><button type="button" class="btn btn-danger btn-sm" id="modal-btn-no" data-dismiss="modal" onclick="prescriptionFunc.discardInteractedMedRow()"><i class="fa fa-times"></i> Discard</button></div>';

        //             $('.common-modal-notify-error').modal('show');
        //             $('.common-modal-notify-error .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
        //             $('.common-modal-notify-error .modal-title').html(data.title);
        //             $('.common-modal-notify-error .modal-body').html(msg);
        //         }
        //     }
        // });

        $(thisElement).parents("#data-append-to").append(row);
        $("#medicine_item_0").typeahead("destroy");
        openItemAutocompleteWithStock($("#medicine_item_0"), 'MED', '#hdn_medicine_item_id_0', '#medicine_item_0');
        $("#medicine_item_0").focus();
        $('#med_td_action_' + newId).html(
            "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        );
    }
</script>
