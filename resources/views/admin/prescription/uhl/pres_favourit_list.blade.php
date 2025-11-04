@if (!empty($favourit_data))
    @php $medHeaderPrinted = false; @endphp
    <table class="outer-table" width="100%">
        @foreach ($favourit_data as $row)
            @if ($row->item_type_lookup_code == 'MED' && !$medHeaderPrinted)
                @php $medHeaderPrinted = true; @endphp
                <thead>
                    <tr>
                        <th width="50%">Name</th>
                        <th>Dose</th>
                        <th>Route</th>
                        <th>Duration</th>
                    </tr>
                </thead>
            @endif
        @endforeach
        <tbody>
            @foreach ($favourit_data as $row)
                <tr>
                    @if ($row->item_type_lookup_code == 'MED')
                        <td class="p-0 p-1 text-left" data-id="{{ $row->pres_fav_no_pk }}">
                            {{ $row->favourite_name }}
                        </td>
                        <td>{{ $row->dosage }}</td>
                        <td>{{ $row->route }}</td>
                        <td>{{ $row->duration }} {{ $row->duration_mu }}</td>
                    @else
                        <td class="p-0 p-1 text-left w-75" data-id="{{ $row->pres_fav_no_pk }}">{{ $row->favourite_name }}
                        </td>
                        <td></td>
                        <td></td>
                        <td></td>
                    @endif
                    <td class="p-0 p-1 text-center">
                        @php
                            $item_type_arr = ['SERVICE', 'SUR', 'RAD', 'LAB', 'MED', 'PTET', 'PTTE', 'ACUP'];
                            $item_id = $row->favourite_item_no_fk;
                            $item_code = $row->item_type_lookup_code;
                        @endphp
                        @if ($row->item_type_lookup_code == 'MED')
                            <input type="checkbox" class="favourit_list_item" data-item-name="{{ $row->favourite_name }}"
                                value="{{ $item_id }}" data-lookup-code="{{ $item_code }}"
                                data-lookup-id="{{ $row->pres_lookup_no_fk }}" data-route-med="{{ $row->route }}"
                                data-dose-med="{{ $row->dosage }}" data-duration-med="{{ $row->duration }}"
                                data-duration-mu-med="{{ $row->duration_mu }}"
                                data-quantity-med="{{ $row->item_qty }}"
                                data-instruction-med="{{ $row->med_instruction }}"
                                data-lookup-data-code="{{ $row->psn_lookupdata_uid }}"
                                onchange="addMedRow(this); previewTab()">
                        @elseif ($row->item_type_lookup_code == 'ACUP')
                            <input type="checkbox" class=" favourit_list_item"
                                onchange="addRowAcup(this, 'ACUP'); previewTab()"
                                data-item-name="{{ $row->favourite_name }}" value="{{ $item_id }}"
                                data-lookup-code="{{ $item_code }}" data-lookup-id="242"
                                data-lookup-data-code="{{ $row->psn_lookupdata_uid }}">
                        @elseif ($row->item_type_lookup_code == 'PTET')
                            <input type="checkbox" class=" favourit_list_item"
                                onchange="addRowPtet(this, 'ETHER'); previewTab()"
                                data-item-name="{{ $row->favourite_name }}" value="{{ $item_id }}"
                                data-lookup-code="{{ $item_code }}" data-lookup-id="202"
                                data-lookup-data-code="{{ $row->psn_lookupdata_uid }}">
                        @elseif ($row->item_type_lookup_code == 'PTTE')
                            <input type="checkbox" class=" favourit_list_item"
                                onchange="addRowPtte(this, 'THRPEX'); previewTab()"
                                data-item-name="{{ $row->favourite_name }}" value="{{ $item_id }}"
                                data-lookup-code="{{ $item_code }}" data-lookup-id="203"
                                data-lookup-data-code="{{ $row->psn_lookupdata_uid }}">
                        @elseif(in_array($row->item_type_lookup_code, ['INVFIND']))
                            <input type="checkbox" class="favourit_list_item"
                                data-item-name="{{ $row->favourite_name }}" value="{{ $item_id }}"
                                data-lookup-code="INVFIND" data-lookup-id="121"
                                data-lookup-data-code="{{ $row->item_type }}"
                                onchange="prescriptionFunc.addFromFavouritList(this); previewTab()">
                        @else
                            @if (isset($su_info->dental_ind) && $su_info->dental_ind == 1)
                                <input type="checkbox" class="favourit_list_item"
                                    data-item-name="{{ $row->favourite_name }}" value="{{ $item_id }}"
                                    data-lookup-code="{{ $item_code }}"
                                    data-lookup-id="{{ $row->pres_lookup_no_fk }}"
                                    data-lookup-data-code="{{ $row->psn_lookupdata_uid }}"
                                    onchange="prescriptionFunc.addTeethFindingsFromFavouritList(this)">
                            @endif
                            <input type="checkbox" class="favourit_list_item"
                                data-item-name="{{ $row->favourite_name }}" value="{{ $item_id }}"
                                data-lookup-code="{{ $item_code }}" data-lookup-id="{{ $row->pres_lookup_no_fk }}"
                                data-lookup-data-code="{{ $row->psn_lookupdata_uid }}"
                                onchange="prescriptionFunc.addFromFavouritList(this); previewTab()">
                        @endif
                    </td>
                    @if ($row->item_type_lookup_code == 'MED')
                        <td class="p-0 p-1 text-center" valign="top" data-favourit-id="{{ $row->pres_fav_no_pk }}"
                            data-lookup-code="{{ $item_code }}"
                            data-action="{{ route('remove-from-pres-favourit-list') }}"
                            onclick="prescriptionV2.removeFromPresFavouritListV2(this, '#pres-favourit-list-med')"><i
                                class="fa fa-times text-danger pt-0"></i>
                        </td>
                    @endif
                    @if ($row->item_type_lookup_code == 'CHIEFCOM')
                        <td class="p-0 p-1 text-center" valign="top" data-favourit-id="{{ $row->pres_fav_no_pk }}"
                            data-lookup-code="{{ $item_code }}"
                            data-action="{{ route('remove-from-pres-favourit-list') }}"
                            onclick="prescriptionV2.removeFromPresFavouritListV2(this, '#pres-favourit-list-chief_complaint')">
                            <i class="fa fa-times text-danger pt-0"></i>
                        </td>
                    @endif

                    @if ($row->item_type_lookup_code == 'CLINICHIST')
                        <td class="p-0 p-1 text-center" valign="top" data-favourit-id="{{ $row->pres_fav_no_pk }}"
                            data-lookup-code="{{ $item_code }}"
                            data-action="{{ route('remove-from-pres-favourit-list') }}"
                            onclick="prescriptionV2.removeFromPresFavouritListV2(this, '#pres-favourit-list-history_of_objective')">
                            <i class="fa fa-times text-danger pt-0"></i>
                        </td>
                    @endif

                    @if ($row->item_type_lookup_code == 'ADVICE')
                        <td class="p-0 p-1 text-center" valign="top" data-favourit-id="{{ $row->pres_fav_no_pk }}"
                            data-lookup-code="{{ $item_code }}"
                            data-action="{{ route('remove-from-pres-favourit-list') }}"
                            onclick="prescriptionV2.removeFromPresFavouritListV2(this, '#pres-favourit-list-advice')">
                            <i class="fa fa-times text-danger pt-0"></i>
                        </td>
                    @endif

                    @if ($row->item_type_lookup_code == 'ICD')
                        <td class="p-0 p-1 text-center" valign="top" data-favourit-id="{{ $row->pres_fav_no_pk }}"
                            data-lookup-code="{{ $item_code }}"
                            data-action="{{ route('remove-from-pres-favourit-list') }}"
                            onclick="prescriptionV2.removeFromPresFavouritListV2(this, '#pres-favourit-list-icd')">
                            <i class="fa fa-times text-danger pt-0"></i>
                        </td>
                    @endif

                    @if ($row->item_type_lookup_code == 'INVFIND' || $row->item_type_lookup_code == 'FINDINGS')
                        <td class="p-0 p-1 text-center" valign="top" data-favourit-id="{{ $row->pres_fav_no_pk }}"
                            data-lookup-code="{{ $item_code }}"
                            data-action="{{ route('remove-from-pres-favourit-list') }}"
                            onclick="prescriptionV2.removeFromPresFavouritListV2(this, '#pres-favourit-list-investigation')">
                            <i class="fa fa-times text-danger pt-0"></i>
                        </td>
                    @endif

                </tr>
            @endforeach
        </tbody>
    </table>
@endif



<script>
    function addMedRow(thisElement) {

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
            thisElement = $("#med_span");
        }
        console.log(item_id)

        var row = $(thisElement).parents("tr").clone();
        var newId = $(thisElement).parents("#data-append-to").find("tr").length;
        var oldId = Number($(thisElement).parents("tr").attr("id"));
        if (newId > 0) {
            newId = $(thisElement)
                .closest('#data-append-to')
                .find('tr:last')
                .find('input[name="hdn_report_serial_med[]"]')
                .val();
            newId++;
            // alert(newId)
        } else {
            newId = 1;
        }
        row.attr("id", "tr_id_" + newId);
        row.find('#hdn_report_serial_med_' + oldId).attr('id', 'hdn_report_serial_med_' + newId);
        row.find('#hdn_genetic_id_' + oldId).attr('id', 'hdn_genetic_id_' + newId);
        row.find('#hdn_medicine_item_id_' + oldId).attr('id', 'hdn_medicine_item_id_' + newId);
        row.find('#medicine_item_' + oldId)
    .attr('id', 'medicine_item_' + newId)
    .css({
        "background-color": "#ffffff",
        "border": "0px"
    })
    .prop("readonly", true);


        row.find('#med_favourit_' + oldId).attr('id', 'med_favourit_' + newId);
        row.find('#medicine_dose_' + oldId).attr('id', 'medicine_dose_' + newId);
        row.find('#medicine_duration_mu_' + oldId).attr('id', 'medicine_duration_mu_' + newId);
        row.find('#medicine_duration_type_' + oldId).attr('id', 'medicine_duration_type_' + newId);
        row.find('#medicine_quantity_' + oldId).attr('id', 'medicine_quantity_' + newId);
        row.find('#instruction_' + oldId).attr('id', 'instruction_' + newId);
        row.find('#medicine_route_' + oldId).attr('id', 'medicine_route_' + newId);
        row.find('#is_continue_' + oldId).attr('id', 'is_continue_' + newId);
        row.find('#med_td_action_' + oldId).attr('id', 'med_td_action_' + newId);
        row.find('#hidden_multidose_id_' + oldId).attr('id', 'hidden_multidose_id_' + newId);
        row.find('#alternative_id_' + oldId).attr('id', 'alternative_id_' + newId);

        var interaction_route = $("#hdn_interaction_url").val();
        var hdn_patient_id = $("#hdn_patient_id").val();

        if (lookup_code == "MED") {
            row.find('#hdn_medicine_item_id_' + newId).val(item_id);
            row.find('#medicine_item_' + newId).val(item_name);
            row.find('#hdn_genetic_id_' + newId).val(item_name);

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
                if (data_route_med == 0) {
                    row.find('#medicine_route_' + newId).val(0);
                } else {
                    row.find('#medicine_route_' + newId).val(data_route_med);
                }
                if (data_dose_med == 0) {
                    row.find('#medicine_dose_' + newId).val(0);
                } else {
                    row.find('#medicine_dose_' + newId).val(data_dose_med);
                }
                row.find('#medicine_quantity_' + newId).val(data_quantity_med);
                row.find('#hdn_report_serial_med_' + newId).val(newId);
                row.find('#hidden_multidose_id_' + newId).val();
                if (data_duration_med == 'Continue') {
                    // Check the checkbox
                    row.find('#is_continue_' + newId).prop("checked", true);
                    row.find('#medicine_quantity_' + newId).val('Continue');
                    row.find('input, select').prop('readonly', true);
                    row.find('#is_continue_' + newId).prop('readonly', false);
                }

            }, 1000);

        }

        if (data_duration_med == 'Continue') {
            row.find('#is_continue_' + newId).val(1);
        } else {
            row.find('#is_continue_' + newId).val(0);
        }

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
            '" data-type="MED"><i class="fa fa-star text-primary"></i></span>'
        );


        var item_id = row.find('#hdn_medicine_item_id_' + newId).val();
        var interaction_result = '';


        $(thisElement).parents("#data-append-to").append(row);
        $("#medicine_item_0").typeahead("destroy");
        openItemAutocompleteWithStockPrescription($("#medicine_item_0"), 'MED', '#hdn_medicine_item_id_0',
            '#medicine_item_0');
        $("#medicine_item_0").focus();
        $("#med_td_action_" + newId).html(
            "<div class='btn-group' role='group' aria-label='Button group'>" +
            "<span class='btn btn-danger btn-md remove_item' onclick='removeTableRowOnly(this)'>" +
            "<i class='fa fa-times'></i>" +
            "</span>" +
            "<button type='button' class='btn btn-primary btn-md add-multidose ml-3' onclick='prescriptionFunc.addMultiDoseRow(this); previewTab()'>" +
            "<i class='fa fa-clone'></i>" +
            "</button>" +
            "</div>"
        );
        var hospital_code = $('#hospital_code').val();


        if (hospital_code == 'UNICO' || hospital_code == 'DMHL') {
            setTimeout(() => {
                previewTab();
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
            }, 1000);

        }


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

            $(thisElement).parents('tbody').find('#session_duration_' + oldId).val('');
            $(thisElement).parents('tbody').find('#unit_intensity_mu_' + oldId).val('0');
            $(thisElement).parents('tbody').find('#unit_intensity_' + oldId).val('');

            $(thisElement).parents('tbody').find('#frequency_' + oldId).val('');
            $(thisElement).parents('tbody').find('#mode_' + oldId).val('');
            $(thisElement).parents('tbody').find('#session_mu_' + oldId).val('0');

            var add_fav_list_action = $(thisElement).attr("data-favourit-action");
            var med_item_id = row.find('#hdn_item_id_' + newId).val();
            var med_item_name = row.find('#hdn_item_name_' + newId).val();

            row.find('#acup_favourit_' + newId).html(
                '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
                add_fav_list_action + '" data-id="' + med_item_id + '" data-name="' + med_item_name +
                '" data-type="ACUP"><i class="fa fa-star text-primary"></i></span>');
        }

        $(thisElement).parents("#data-append-to").append(row);

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
            $(thisElement).parents('tbody').find('#session_mu_' + oldId).val('0');

            var add_fav_list_action = $(thisElement).attr("data-favourit-action");
            var med_item_id = row.find('#hdn_item_id_' + newId).val();
            var med_item_name = row.find('#hdn_item_name_' + newId).val();

            row.find('#ptet_favourit_' + newId).html(
                '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
                add_fav_list_action + '" data-id="' + med_item_id + '" data-name="' + med_item_name +
                '" data-type="PTET"><i class="fa fa-star text-primary"></i></span>');
        }

        $(thisElement).parents("#data-append-to").append(row);

        if (type == 'ETHER') {
            openItemAutocomplete($("#et_item_name_" + newId), 'PT', "#hdn_item_id_" + newId, "#hdn_item_name_" + newId,
                "202", "PTET"); // 3 = SERVICE ITEM TYPE
            $('#et_td_action_' + newId).html(
                "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
            );
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
            $(thisElement).parents('tbody').find('#session_duration_' + oldId).val('');
            $(thisElement).parents('tbody').find('#unit_intensity_mu_' + oldId).val('0');
            $(thisElement).parents('tbody').find('#unit_intensity_' + oldId).val('');

            $(thisElement).parents('tbody').find('#session_mu_' + oldId).val('0');

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



    $('.medicine_duration').on('input change', function() {
        previewTab();
    });
</script>
