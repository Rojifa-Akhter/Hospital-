@if (!empty($favourit_data))
    @foreach ($favourit_data as $row)
        <tr>
            <td class="p-0 p-1 text-left w-75" data-id="{{ $row->pres_fav_no_pk }}">{{ $row->favourite_name }}</td>
            <td class="p-0 p-1 text-center">
                @php
                    $item_type_arr = ['SERVICE', 'SUR', 'RAD', 'LAB', 'MED', 'PTET', 'PTTE', 'ACUP', 'ADVICE'];
                    if (in_array($row->item_type_lookup_code, $item_type_arr)) {
                        $item_id = $row->favourite_item_no_fk;
                        $item_code = $row->item_type_lookup_code;
                    } else {
                        $item_id = $row->favourite_item_no_fk;
                        $item_code = $row->item_type_lookup_code;
                    }

                @endphp
                @if ($row->item_type_lookup_code == 'MED')
                    <input type="checkbox" class="favourit_list_item" data-item-name="{{ $row->favourite_name }}"
                        value="{{ $item_id }}" data-lookup-code="{{ $item_code }}"
                        data-lookup-id="{{ $row->pres_lookup_no_fk }}" data-route-med="{{ $row->route }}"
                        data-dose-med="{{ $row->dosage }}" data-duration-med="{{ $row->duration }}"
                        data-duration-mu-med="{{ $row->duration_mu }}" data-quantity-med="{{ $row->item_qty }}"
                        data-instruction-med="{{ $row->med_instruction }}"
                        data-lookup-data-code="{{ $row->psn_lookupdata_uid }}" onchange="addMedRow(this)">
                @elseif ($row->item_type_lookup_code == 'ACUP')
                    <input type="checkbox" class=" favourit_list_item" onchange="addRowAcup(this, 'ACUP')"
                        data-item-name="{{ $row->favourite_name }}" value="{{ $item_id }}"
                        data-lookup-code="{{ $item_code }}" data-lookup-id="242"
                        data-lookup-data-code="{{ $row->psn_lookupdata_uid }}">
                @elseif ($row->item_type_lookup_code == 'PTET')
                    <input type="checkbox" class=" favourit_list_item" onchange="addRowPtet(this, 'ETHER')"
                        data-item-name="{{ $row->favourite_name }}" value="{{ $item_id }}"
                        data-lookup-code="{{ $item_code }}" data-lookup-id="202"
                        data-lookup-data-code="{{ $row->psn_lookupdata_uid }}">
                @elseif ($row->item_type_lookup_code == 'PTTE')
                    <input type="checkbox" class=" favourit_list_item" onchange="addRowPtte(this, 'THRPEX')"
                        data-item-name="{{ $row->favourite_name }}" value="{{ $item_id }}"
                        data-lookup-code="{{ $item_code }}" data-lookup-id="203"
                        data-lookup-data-code="{{ $row->psn_lookupdata_uid }}">
                @elseif(in_array($row->item_type_lookup_code, ['INVFIND']))
                    <input type="checkbox" class="favourit_list_item" data-item-name="{{ $row->favourite_name }}"
                        value="{{ $item_id }}" data-lookup-code="INVFIND" data-lookup-id="121"
                        data-lookup-data-code="{{ $row->item_type }}"
                        onchange="prescriptionFunc.addFromFavouritList(this)">
                 @elseif(in_array($row->item_type_lookup_code, ['ADVICE']))
                    <input type="checkbox" class="favourit_list_item" data-item-name="{{ $row->favourite_name }}"
                        value="{{ $item_id }}" data-lookup-code="ADVICE" data-lookup-id="7"
                        data-lookup-data-code="{{ $row->psn_lookupdata_uid }}"
                        onchange="prescriptionFunc.addFromFavouritList(this)">
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
        // console.log(thisElement);
        var lookup_code = $(thisElement).attr("data-lookup-code");
        var item_id = item_name = "";
        if (lookup_code == "MED") {
            var item_id = $(thisElement).val();
            var item_name = $(thisElement).attr("data-item-name");

            var data_route_med = $(thisElement).attr("data-route-med");
            var data_dose_med = $(thisElement).attr("data-dose-med");
            var data_duration_med = $(thisElement).attr("data-duration-med");
            var data_duration_mu_med = $(thisElement).attr("data-duration-mu-med");
            var data_quantity_med = $(thisElement).attr("data-quantity-med");
            var data_instruction_med = $(thisElement).attr("data-instruction-med");

            var data_multidose_action = "{{ route('add-multidose') }}";
            var data_alternative_action = "{{ route('alternative-medicine') }}";
            // console.log(data_duration_mu_med);
            // console.log(data_route_med + data_dose_med + data_duration_med + data_duration_mu_med + data_quantity_med + data_instruction_med)
            thisElement = $("#med_span");
        }
        var row = $(thisElement).parents("tr").clone();
        var newId = $(thisElement).parents("#data-append-to").find("tr").length;
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        //    console.log(newId, oldId, $(thisElement).parents("tr").attr("id"));
        // row.attr('id', newId);
        row.attr("id", "tr_id_" + newId);
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
        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        row.find('#hidden_multidose_id_' + oldId).attr('id', 'hidden_multidose_id_' + newId);
        row.find('#alternative_id_' + oldId).attr('id', 'alternative_id_' + newId);

        var interaction_route = $("#hdn_interaction_url").val();
        var hdn_patient_id = $("#hdn_patient_id").val();

        if (lookup_code == "MED") {
            console.log(data_duration_med)
            // alert("MED");
            row.find('#hdn_medicine_item_id_' + newId).val(item_id);
            row.find('#medicine_item_' + newId).val(item_name);


            // row.find('#instruction_1 option[value=Before Meal]').prop('selected','selected').change();
            // row.find('#instruction_' + newId).text(data_instruction_med);
            // row.find('#instruction_' + newId +'option:eq(data_instruction_med)').prop('selected',true);

            setTimeout(() => {

                if (data_instruction_med == 0) {
                    row.find('#instruction_' + newId).val(0);
                } else {
                    row.find('#instruction_' + newId).val(data_instruction_med);
                }
                // row.find('#instruction_' + newId).val(data_instruction_med);
                if (data_duration_mu_med == null || data_duration_mu_med == 0) {
                    row.find('#medicine_duration_mu_' + newId).val('DAY');
                } else {
                    row.find('#medicine_duration_mu_' + newId).val(data_duration_mu_med);
                }
                // row.find('#medicine_duration_mu_' + newId).val(data_duration_mu_med);
                if (data_duration_med == 0) {
                    row.find('#medicine_duration_type_' + newId).val(0); 
                } else {
                    row.find('#medicine_duration_type_' + newId).val(data_duration_med);
                }
                // row.find('#medicine_duration_type_' + newId).val(data_duration_med);
                if (data_route_med == 0) {
                    row.find('#medicine_route_' + newId).val(0);
                } else {
                    row.find('#medicine_route_' + newId).val(data_route_med);
                }
                // row.find('#medicine_route_' + newId).val(data_route_med);
                if (data_dose_med == 0) {
                    row.find('#medicine_dose_' + newId).val(0);
                } else {
                    row.find('#medicine_dose_' + newId).val(data_dose_med);
                }
                // row.find('#medicine_dose_' + newId).val(data_dose_med);
                row.find('#medicine_quantity_' + newId).val(data_quantity_med);
                row.find('#hidden_multidose_id_' + newId).val();
                if (data_duration_med == 'Continue') {
                    row.find('#is_continue_' + newId).prop("checked", true);
                    row.find('#medicine_quantity_' + newId).val('Continue');
                }


                // $('#medicine_route_' + newId).find('td span:last-child').remove();
                // select2-selection select2-selection--single


                // console.log(row.find('#medicine_route_' + newId).value(data_route_med) + data_route_med)
            }, 1000);

            // console.log(data_route_med + data_dose_med + data_duration_med + data_duration_mu_med + data_quantity_med +
            //     data_instruction_med)
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
            '" data-type="MED"><i class="fa fa-star text-primary"></i></span> <br />  <span class="float-right text-secondary mr-1 cursor-pointer" data-modal="common-modal-xl" style="font-size:11px;" title="Add Multidose Medicine" onclick="prescriptionFunc.addMultidoseList(this)" data-action="' +
            data_multidose_action +
            '" data-id="' +
            med_item_id +
            '" data-name="' +
            med_item_name +
            '" data-type="MED" data-duration="' +
            data_duration_med +
            '" data-route="' +
            data_route_med +
            '" data-dose="' +
            data_dose_med +
            '" data-quantity="' +
            data_quantity_med +
            '" data-instruction="' +
            data_instruction_med +
            '" data-row-id="' +
            newId +
            '"><i class="fa fa-medkit text-danger"></i></span>'
        );

        row.find("#alternative_id_" + newId).html(
            '<span class="float-right text-secondary cursor-pointer" data-modal="common-modal-md" style="font-size:11px;border: 1px solid aqua;padding: 4px;margin-top: 9px;border-radius: 5px;" title="Alternative Medicine" onclick="prescriptionFunc.alternativeMedicine(this)" data-id="' +
            med_item_id +
            '" data-name="' +
            med_item_name +
            '" data-type="MED" data-duration="' +
            data_duration_med +
            '" data-route="' +
            data_route_med +
            '" data-dose="' +
            data_dose_med +
            '" data-quantity="' +
            data_quantity_med +
            '" data-instruction="' +
            data_instruction_med +
            '" data-row-id="' +
            newId +
            '" data-alternative-action="' +
            data_alternative_action +
            '">ALT</span>'
        );

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
        $(thisElement).parents("#data-append-to").children('tr').last().children('td').last().html("<span class='btn btn-danger btn-sm remove_item' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>")
       
        $("#medicine_item_0").typeahead("destroy");
        // openOPDPrescriptionAutocomplete($("#medicine_item_0"), 'MED', '#hdn_medicine_item_id_0', '#medicine_item_0');
        // $("#medicine_item_0").focus();
        openItemAutocompleteWithStockPrescription($("#medicine_item_0"), 'MED', '#hdn_medicine_item_id_0','#medicine_item_0');
     
        $("#medicine_item_0").focus();
        // $('#med_td_action_' + newId).html(
        //     "<span class='btn btn-danger btn-sm remove_item' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        // );

        setTimeout(() => {
            $(".select2").select2();
            $('.select2').removeClass('select2-hidden-accessible');
            $('.select2-container').remove();
            // $('.select2').select2({
            //     // placeholder: "Select Value",
            //     allowClear: true
            // });

            // from here 
            $('.select2').select2({
                tags: true, // Enable adding new options
                placeholder: 'Select or type to add',
                allowClear: true, // Allow clearing selection
                templateResult: formatOption, // Format the display of options
                templateSelection: formatOption // Format the selected option
            });
              // Function to format the options with data attributes
            function formatOption(option) {
                if (!option.id) {
                    return option.text; // Return the text if it's a new tag
                }
                const $option = $(
                    `<span>${option.text}</span>`
                );

                // Accessing custom data attributes
                const dataQnty = $(option.element).data('qnty');
                if (dataQnty !== undefined) {
                    $option.append(`${dataQnty}`);
                }

                return $option;
            }

            // added new here 
        }, 2000);

    }

    function addRowAcup(thisElement, type) {

        var lookup_code = $(thisElement).attr("data-lookup-code");
        var item_id = item_name = "";
        if (lookup_code == "ACUP") {
            var item_id = $(thisElement).val();
            var item_name = $(thisElement).attr("data-item-name");
            thisElement = $("#acup_span");
        }

        var row = $(thisElement).parents("tr").clone();
        var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
        var oldId = Number($(thisElement).parents("tr").attr("id"));

        row.attr('id', newId);
        if (type == 'ACUP') {
            row.find('#acup_item_name_' + oldId).attr('id', 'acup_item_name_' + newId);
            row.find('#acup_item_name_' + oldId).attr('readonly', 'readonly');
            row.find('#unit_intensity_mu_' + oldId).attr('id', 'unit_intensity_mu_' + newId);
            row.find('#session_duration_' + oldId).attr('id', 'session_duration_' + newId);
            row.find('#unit_intensity_' + oldId).attr('id', 'unit_intensity_' + newId);
            row.find('#acup_td_action_' + oldId).attr('id', 'acup_td_action_' + newId);

            row.find('#hdn_item_id_' + oldId).attr('id', 'hdn_item_id_' + newId);
            row.find('#hdn_item_name_' + oldId).attr('id', 'hdn_item_name_' + newId);
            row.find('#hdn_lookup_id_' + oldId).attr('id', 'hdn_lookup_id_' + newId);
            row.find('#hdn_lookup_code_' + oldId).attr('id', 'hdn_lookup_code_' + newId);
            row.find('#hdn_lookupdata_code_' + oldId).attr('id', 'hdn_lookupdata_code_' + newId);
            row.find('#session_mu_' + oldId).attr('id', 'session_mu_' + newId);
            row.find('#no_of_session_' + oldId).attr('id', 'no_of_session_' + newId);
            row.find('#acup_favourit_' + oldId).attr('id', 'acup_favourit_' + newId);

            row.find('#frequency_' + oldId).attr('id', 'frequency_' + newId);
            row.find('#mode_' + oldId).attr('id', 'mode_' + newId);

            row.find('#unit_intensity_mu_' + newId).val($(thisElement).parents('tbody').find('#unit_intensity_mu_' +
                oldId).val());
            if (lookup_code == "ACUP") {
                row.find('#acup_item_name_' + newId).val(item_name);
                row.find('#hdn_item_id_' + newId).val(item_id);
                row.find('#hdn_item_name_' + newId).val(item_name);
                row.find('#hdn_lookup_id_' + newId).val(242);
                row.find('#hdn_lookupdata_code_' + newId).val('ACUP');
            }
            row.find('#hdn_lookupdata_code_' + oldId).val('ACUP');

            // $(thisElement).parents('tbody').find('#acup_item_name_' + oldId).val('');
            $(thisElement).parents('tbody').find('#session_duration_' + oldId).val('');
            $(thisElement).parents('tbody').find('#unit_intensity_mu_' + oldId).val('0');
            $(thisElement).parents('tbody').find('#unit_intensity_' + oldId).val('');

            $(thisElement).parents('tbody').find('#frequency_' + oldId).val('');
            $(thisElement).parents('tbody').find('#mode_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_item_id_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_item_name_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_lookup_id_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_lookup_code_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_lookupdata_code_' + oldId).val('');
            $(thisElement).parents('tbody').find('#session_mu_' + oldId).val('0');
            // $(thisElement).parents('tbody').find('#no_of_session_' + oldId).val('');

            var add_fav_list_action = $(thisElement).attr("data-favourit-action");
            var med_item_id = row.find('#hdn_item_id_' + newId).val();
            var med_item_name = row.find('#hdn_item_name_' + newId).val();

            row.find('#acup_favourit_' + newId).html(
                '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
                add_fav_list_action + '" data-id="' + med_item_id + '" data-name="' + med_item_name +
                '" data-type="ACUP"><i class="fa fa-star text-primary"></i></span>');
        }

        // if (type == 'ETHER') {
        //     row.find('#et_item_name_' + oldId).attr('id', 'et_item_name_' + newId);
        //     row.find('#et_item_name_' + oldId).attr('readonly', 'readonly');
        //     row.find('#unit_intensity_mu_' + oldId).attr('id', 'unit_intensity_mu_' + newId);
        //     row.find('#session_duration_' + oldId).attr('id', 'session_duration_' + newId);
        //     row.find('#unit_intensity_' + oldId).attr('id', 'unit_intensity_' + newId);
        //     row.find('#et_td_action_' + oldId).attr('id', 'et_td_action_' + newId);

        //     row.find('#hdn_item_id_' + oldId).attr('id', 'hdn_item_id_' + newId);
        //     row.find('#hdn_item_name_' + oldId).attr('id', 'hdn_item_name_' + newId);
        //     row.find('#hdn_lookup_id_' + oldId).attr('id', 'hdn_lookup_id_' + newId);
        //     row.find('#hdn_lookup_code_' + oldId).attr('id', 'hdn_lookup_code_' + newId);
        //     row.find('#hdn_lookupdata_code_' + oldId).attr('id', 'hdn_lookupdata_code_' + newId);
        //     row.find('#session_mu_' + oldId).attr('id', 'session_mu_' + newId);
        //     row.find('#no_of_session_' + oldId).attr('id', 'no_of_session_' + newId);
        //     row.find('#ptet_favourit_' + oldId).attr('id', 'ptet_favourit_' + newId);

        //     row.find('#unit_intensity_mu_' + newId).val($(thisElement).parents('tbody').find('#unit_intensity_mu_' +
        //         oldId).val());

        //     if (lookup_code == "PTET") {
        //         row.find('#et_item_name_' + newId).val(item_name);
        //         row.find('#hdn_item_id_' + newId).val(item_id);
        //         row.find('#hdn_item_name_' + newId).val(item_name);
        //         row.find('#hdn_lookup_id_' + newId).val(202);
        //         row.find('#hdn_lookupdata_code_' + newId).val('PTET');
        //     }

        //     row.find('#hdn_lookupdata_code_' + oldId).val('PTET');
        //     // $(thisElement).parents('tbody').find('#et_item_name_' + oldId).val('');
        //     $(thisElement).parents('tbody').find('#session_duration_' + oldId).val('');
        //     $(thisElement).parents('tbody').find('#unit_intensity_mu_' + oldId).val('0');
        //     $(thisElement).parents('tbody').find('#unit_intensity_' + oldId).val('');

        //     // $(thisElement).parents('tbody').find('#hdn_item_id_' + oldId).val('');
        //     // $(thisElement).parents('tbody').find('#hdn_item_name_' + oldId).val('');
        //     // $(thisElement).parents('tbody').find('#hdn_lookup_id_' + oldId).val('');
        //     // $(thisElement).parents('tbody').find('#hdn_lookup_code_' + oldId).val('');
        //     // $(thisElement).parents('tbody').find('#hdn_lookupdata_code_' + oldId).val('');
        //     $(thisElement).parents('tbody').find('#session_mu_' + oldId).val('0');
        //     // $(thisElement).parents('tbody').find('#no_of_session_' + oldId).val('');

        //     var add_fav_list_action = $(thisElement).attr("data-favourit-action");
        //     var med_item_id = row.find('#hdn_item_id_' + newId).val();
        //     var med_item_name = row.find('#hdn_item_name_' + newId).val();

        //     row.find('#ptet_favourit_' + newId).html(
        //         '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
        //         add_fav_list_action + '" data-id="' + med_item_id + '" data-name="' + med_item_name +
        //         '" data-type="PTET"><i class="fa fa-star text-primary"></i></span>');
        // }

        $(thisElement).parents("#data-append-to").append(row);

        // if (type == 'THRPEX') {
        //     openItemAutocomplete($("#te_item_name_" + newId), 'PT', "#hdn_item_id_" + newId, "#hdn_item_name_" + newId,
        //         "203", "PTTE"); // 3 = SERVICE ITEM TYPE
        //     $('#te_td_action_' + newId).html(
        //         "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        //     );
        //     //$('#hdn_lookup_code_' + newId).val('THRPEX');
        // }

        // if (type == 'ETHER') {
        //     openItemAutocomplete($("#et_item_name_" + newId), 'PT', "#hdn_item_id_" + newId, "#hdn_item_name_" + newId,
        //         "202", "PTET"); // 3 = SERVICE ITEM TYPE
        //     $('#et_td_action_' + newId).html(
        //         "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        //     );
        //     //$('#hdn_lookup_code_' + newId).val('ETHER');
        // }
        if (type == 'ACUP') {
            openItemAutocomplete($("#acup_item_name_" + newId), 'PT', "#hdn_item_id_" + newId, "#hdn_item_name_" +
                newId, "242", "ACUP"); // 3 = SERVICE ITEM TYPE
            $('#acup_td_action_' + newId).html(
                "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
            );
            //$('#hdn_lookup_code_' + newId).val('ETHER');
        }
    }

    function addRowPtet(thisElement, type) {

        var lookup_code = $(thisElement).attr("data-lookup-code");
        var item_id = item_name = "";
        if (lookup_code == "PTET") {
            var item_id = $(thisElement).val();
            var item_name = $(thisElement).attr("data-item-name");
            thisElement = $("#ptet_span");
        }

        var row = $(thisElement).parents("tr").clone();
        var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
        var oldId = Number($(thisElement).parents("tr").attr("id"));

        row.attr('id', newId);
        // if (type == 'THRPEX') {

        //     row.find('#te_item_name_' + oldId).attr('id', 'te_item_name_' + newId);
        //     row.find('#session_mu_' + oldId).attr('id', 'session_mu_' + newId);
        //     row.find('#session_duration_' + oldId).attr('id', 'session_duration_' + newId);
        //     row.find('#session_unit_' + oldId).attr('id', 'session_unit_' + newId);
        //     row.find('#te_td_action_' + oldId).attr('id', 'te_td_action_' + newId);

        //     row.find('#hdn_item_id_' + oldId).attr('id', 'hdn_item_id_' + newId);
        //     row.find('#hdn_item_name_' + oldId).attr('id', 'hdn_item_name_' + newId);
        //     row.find('#hdn_lookup_id_' + oldId).attr('id', 'hdn_lookup_id_' + newId);
        //     row.find('#hdn_lookup_code_' + oldId).attr('id', 'hdn_lookup_code_' + newId);
        //     row.find('#hdn_lookupdata_code_' + oldId).attr('id', 'hdn_lookupdata_code_' + newId);
        //     row.find('#unit_intensity_mu_' + oldId).attr('id', 'unit_intensity_mu_' + newId);
        //     row.find('#unit_intensity_' + oldId).attr('id', 'unit_intensity_' + newId);
        //     row.find('#ptte_favourit_' + oldId).attr('id', 'ptte_favourit_' + newId);

        //     row.find('#session_mu_' + newId).val($(thisElement).parents('tbody').find('#session_mu_1').val());

        //     $(thisElement).parents('tbody').find('#te_item_name_' + oldId).val('');
        //     $(thisElement).parents('tbody').find('#session_duration_' + oldId).val('');
        //     $(thisElement).parents('tbody').find('#session_mu_' + oldId).val('0');
        //     $(thisElement).parents('tbody').find('#session_unit_' + oldId).val('');

        //     $(thisElement).parents('tbody').find('#hdn_item_id_' + oldId).val('');
        //     $(thisElement).parents('tbody').find('#hdn_item_name_' + oldId).val('');
        //     $(thisElement).parents('tbody').find('#hdn_lookupdata_code_' + oldId).val('');
        //     $(thisElement).parents('tbody').find('#hdn_lookup_id_' + oldId).val('');
        //     $(thisElement).parents('tbody').find('#hdn_lookup_code_' + oldId).val('');
        //     $(thisElement).parents('tbody').find('#unit_intensity_mu_' + oldId).val('');
        //     $(thisElement).parents('tbody').find('#unit_intensity_' + oldId).val('');
        //     $(thisElement).parents('tbody').find('#no_of_session_' + oldId).val('');

        //     var add_fav_list_action = $(thisElement).attr("data-favourit-action");
        //     var med_item_id = row.find('#hdn_item_id_' + newId).val();
        //     var med_item_name = row.find('#hdn_item_name_' + newId).val();

        //     row.find('#ptte_favourit_' + newId).html(
        //         '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
        //         add_fav_list_action + '" data-id="' + med_item_id + '" data-name="' + med_item_name +
        //         '" data-type="PTTE"><i class="fa fa-star text-primary"></i></span>');
        // }

        if (type == 'ETHER') {
            row.find('#et_item_name_' + oldId).attr('id', 'et_item_name_' + newId);
            row.find('#et_item_name_' + oldId).attr('readonly', 'readonly');
            row.find('#unit_intensity_mu_' + oldId).attr('id', 'unit_intensity_mu_' + newId);
            row.find('#session_duration_' + oldId).attr('id', 'session_duration_' + newId);
            row.find('#unit_intensity_' + oldId).attr('id', 'unit_intensity_' + newId);
            row.find('#et_td_action_' + oldId).attr('id', 'et_td_action_' + newId);

            row.find('#hdn_item_id_' + oldId).attr('id', 'hdn_item_id_' + newId);
            row.find('#hdn_item_name_' + oldId).attr('id', 'hdn_item_name_' + newId);
            row.find('#hdn_lookup_id_' + oldId).attr('id', 'hdn_lookup_id_' + newId);
            row.find('#hdn_lookup_code_' + oldId).attr('id', 'hdn_lookup_code_' + newId);
            row.find('#hdn_lookupdata_code_' + oldId).attr('id', 'hdn_lookupdata_code_' + newId);
            row.find('#session_mu_' + oldId).attr('id', 'session_mu_' + newId);
            row.find('#no_of_session_' + oldId).attr('id', 'no_of_session_' + newId);
            row.find('#ptet_favourit_' + oldId).attr('id', 'ptet_favourit_' + newId);
            row.find('#frequency_' + oldId).attr('id', 'frequency_' + newId);
            row.find('#mode_' + oldId).attr('id', 'mode_' + newId);
            row.find('#unit_intensity_mu_' + newId).val($(thisElement).parents('tbody').find('#unit_intensity_mu_' +
                oldId).val());

            if (lookup_code == "PTET") {
                row.find('#et_item_name_' + newId).val(item_name);
                row.find('#hdn_item_id_' + newId).val(item_id);
                row.find('#hdn_item_name_' + newId).val(item_name);
                row.find('#hdn_lookup_id_' + newId).val(202);
                row.find('#hdn_lookupdata_code_' + newId).val('PTET');
            }

            row.find('#hdn_lookupdata_code_' + oldId).val('PTET');
            // $(thisElement).parents('tbody').find('#et_item_name_' + oldId).val('');
            $(thisElement).parents('tbody').find('#session_duration_' + oldId).val('');
            $(thisElement).parents('tbody').find('#unit_intensity_mu_' + oldId).val('0');
            $(thisElement).parents('tbody').find('#unit_intensity_' + oldId).val('');
            $(thisElement).parents('tbody').find('#frequency_' + oldId).val('');
            $(thisElement).parents('tbody').find('#mode_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_item_id_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_item_name_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_lookup_id_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_lookup_code_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_lookupdata_code_' + oldId).val('');
            $(thisElement).parents('tbody').find('#session_mu_' + oldId).val('0');
            // $(thisElement).parents('tbody').find('#no_of_session_' + oldId).val('');

            var add_fav_list_action = $(thisElement).attr("data-favourit-action");
            var med_item_id = row.find('#hdn_item_id_' + newId).val();
            var med_item_name = row.find('#hdn_item_name_' + newId).val();

            row.find('#ptet_favourit_' + newId).html(
                '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
                add_fav_list_action + '" data-id="' + med_item_id + '" data-name="' + med_item_name +
                '" data-type="PTET"><i class="fa fa-star text-primary"></i></span>');
        }

        $(thisElement).parents("#data-append-to").append(row);

        // if (type == 'THRPEX') {
        //     openItemAutocomplete($("#te_item_name_" + newId), 'PT', "#hdn_item_id_" + newId, "#hdn_item_name_" + newId,
        //         "203", "PTTE"); // 3 = SERVICE ITEM TYPE
        //     $('#te_td_action_' + newId).html(
        //         "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
        //     );
        //     //$('#hdn_lookup_code_' + newId).val('THRPEX');
        // }

        if (type == 'ETHER') {
            openItemAutocomplete($("#et_item_name_" + newId), 'PT', "#hdn_item_id_" + newId, "#hdn_item_name_" + newId,
                "202", "PTET"); // 3 = SERVICE ITEM TYPE
            $('#et_td_action_' + newId).html(
                "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
            );
            //$('#hdn_lookup_code_' + newId).val('ETHER');
        }
    }

    function addRowPtte(thisElement, type) {

        var lookup_code = $(thisElement).attr("data-lookup-code");
        var item_id = item_name = "";
        if (lookup_code == "PTTE") {
            var item_id = $(thisElement).val();
            var item_name = $(thisElement).attr("data-item-name");
            thisElement = $("#ptte_span");
        }

        var row = $(thisElement).parents("tr").clone();
        var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
        var oldId = Number($(thisElement).parents("tr").attr("id"));

        row.attr('id', newId);
        if (type == 'THRPEX') {

            row.find('#te_item_name_' + oldId).attr('id', 'te_item_name_' + newId);
            row.find('#session_mu_' + oldId).attr('id', 'session_mu_' + newId);
            row.find('#session_duration_' + oldId).attr('id', 'session_duration_' + newId);
            row.find('#session_unit_' + oldId).attr('id', 'session_unit_' + newId);
            row.find('#te_td_action_' + oldId).attr('id', 'te_td_action_' + newId);

            row.find('#hdn_item_id_' + oldId).attr('id', 'hdn_item_id_' + newId);
            row.find('#hdn_item_name_' + oldId).attr('id', 'hdn_item_name_' + newId);
            row.find('#hdn_lookup_id_' + oldId).attr('id', 'hdn_lookup_id_' + newId);
            row.find('#hdn_lookup_code_' + oldId).attr('id', 'hdn_lookup_code_' + newId);
            row.find('#hdn_lookupdata_code_' + oldId).attr('id', 'hdn_lookupdata_code_' + newId);
            row.find('#unit_intensity_mu_' + oldId).attr('id', 'unit_intensity_mu_' + newId);
            row.find('#unit_intensity_' + oldId).attr('id', 'unit_intensity_' + newId);
            row.find('#ptte_favourit_' + oldId).attr('id', 'ptte_favourit_' + newId);
            row.find('#frequency_' + oldId).attr('id', 'frequency_' + newId);
            row.find('#mode_' + oldId).attr('id', 'mode_' + newId);
            row.find('#session_mu_' + newId).val($(thisElement).parents('tbody').find('#session_mu_1').val());


            if (lookup_code == "PTTE") {
                row.find('#te_item_name_' + newId).val(item_name);
                row.find('#hdn_item_id_' + newId).val(item_id);
                row.find('#hdn_item_name_' + newId).val(item_name);
                row.find('#hdn_lookup_id_' + newId).val(202);
                row.find('#hdn_lookupdata_code_' + newId).val('PTTE');
            }

            // $(thisElement).parents('tbody').find('#te_item_name_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#session_duration_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#session_mu_' + oldId).val('0');
            // $(thisElement).parents('tbody').find('#session_unit_' + oldId).val('');

            // $(thisElement).parents('tbody').find('#hdn_item_id_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_item_name_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_lookupdata_code_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_lookup_id_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_lookup_code_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#unit_intensity_mu_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#unit_intensity_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#no_of_session_' + oldId).val('');

            var add_fav_list_action = $(thisElement).attr("data-favourit-action");
            var med_item_id = row.find('#hdn_item_id_' + newId).val();
            var med_item_name = row.find('#hdn_item_name_' + newId).val();

            row.find('#ptte_favourit_' + newId).html(
                '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
                add_fav_list_action + '" data-id="' + med_item_id + '" data-name="' + med_item_name +
                '" data-type="PTTE"><i class="fa fa-star text-primary"></i></span>');
        }

        if (type == 'ETHER') {
            row.find('#et_item_name_' + oldId).attr('id', 'et_item_name_' + newId);
            row.find('#et_item_name_' + oldId).attr('readonly', 'readonly');
            row.find('#unit_intensity_mu_' + oldId).attr('id', 'unit_intensity_mu_' + newId);
            row.find('#session_duration_' + oldId).attr('id', 'session_duration_' + newId);
            row.find('#unit_intensity_' + oldId).attr('id', 'unit_intensity_' + newId);
            row.find('#et_td_action_' + oldId).attr('id', 'et_td_action_' + newId);

            row.find('#hdn_item_id_' + oldId).attr('id', 'hdn_item_id_' + newId);
            row.find('#hdn_item_name_' + oldId).attr('id', 'hdn_item_name_' + newId);
            row.find('#hdn_lookup_id_' + oldId).attr('id', 'hdn_lookup_id_' + newId);
            row.find('#hdn_lookup_code_' + oldId).attr('id', 'hdn_lookup_code_' + newId);
            row.find('#hdn_lookupdata_code_' + oldId).attr('id', 'hdn_lookupdata_code_' + newId);
            row.find('#session_mu_' + oldId).attr('id', 'session_mu_' + newId);
            row.find('#no_of_session_' + oldId).attr('id', 'no_of_session_' + newId);
            row.find('#ptet_favourit_' + oldId).attr('id', 'ptet_favourit_' + newId);

            row.find('#unit_intensity_mu_' + newId).val($(thisElement).parents('tbody').find('#unit_intensity_mu_' +
                oldId).val());

            if (lookup_code == "PTET") {
                row.find('#et_item_name_' + newId).val(item_name);
                row.find('#hdn_item_id_' + newId).val(item_id);
                row.find('#hdn_item_name_' + newId).val(item_name);
                row.find('#hdn_lookup_id_' + newId).val(202);
                row.find('#hdn_lookupdata_code_' + newId).val('PTET');
            }

            row.find('#hdn_lookupdata_code_' + oldId).val('PTET');
            // $(thisElement).parents('tbody').find('#et_item_name_' + oldId).val('');
            $(thisElement).parents('tbody').find('#session_duration_' + oldId).val('');
            $(thisElement).parents('tbody').find('#unit_intensity_mu_' + oldId).val('0');
            $(thisElement).parents('tbody').find('#unit_intensity_' + oldId).val('');

            // $(thisElement).parents('tbody').find('#hdn_item_id_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_item_name_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_lookup_id_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_lookup_code_' + oldId).val('');
            // $(thisElement).parents('tbody').find('#hdn_lookupdata_code_' + oldId).val('');
            $(thisElement).parents('tbody').find('#session_mu_' + oldId).val('0');
            // $(thisElement).parents('tbody').find('#no_of_session_' + oldId).val('');

            var add_fav_list_action = $(thisElement).attr("data-favourit-action");
            var med_item_id = row.find('#hdn_item_id_' + newId).val();
            var med_item_name = row.find('#hdn_item_name_' + newId).val();

            row.find('#ptet_favourit_' + newId).html(
                '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
                add_fav_list_action + '" data-id="' + med_item_id + '" data-name="' + med_item_name +
                '" data-type="PTET"><i class="fa fa-star text-primary"></i></span>');
        }

        $(thisElement).parents("#data-append-to").append(row);

        if (type == 'THRPEX') {
            openItemAutocomplete($("#te_item_name_" + newId), 'PT', "#hdn_item_id_" + newId, "#hdn_item_name_" + newId,
                "203", "PTTE"); // 3 = SERVICE ITEM TYPE
            $('#te_td_action_' + newId).html(
                "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
            );
            //$('#hdn_lookup_code_' + newId).val('THRPEX');
        }

        if (type == 'ETHER') {
            openItemAutocomplete($("#et_item_name_" + newId), 'PT', "#hdn_item_id_" + newId, "#hdn_item_name_" + newId,
                "202", "PTET"); // 3 = SERVICE ITEM TYPE
            $('#et_td_action_' + newId).html(
                "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
            );
            //$('#hdn_lookup_code_' + newId).val('ETHER');
        }
    }
</script>
