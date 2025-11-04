var prescriptionV2 = {
    addDataFuncWithoutAutocomplete: function (
        thisElement,
        action_url_clinical
    ) {
        var typehead_id = $(thisElement)
            .parent("span")
            .siblings("div")
            .children("div")
            .children("div")
            .children(".twitter-typeahead")
            .find(".tt-input")
            .attr("id");

        var typehead_text = $("#" + typehead_id).typeahead("val");
        var typehead_text_format = typehead_text.replace("'", "’");

        var lookup_id = $(thisElement)
            .parent("span")
            .siblings("div")
            .children("div")
            .children("div")
            .children(".twitter-typeahead")
            .find(".tt-input")
            .attr("data-lookup-id");

        var lookup_code = $(thisElement)
            .parent("span")
            .siblings("div")
            .children("div")
            .children("div")
            .children(".twitter-typeahead")
            .find(".tt-input")
            .attr("data-lookup-code");

        // lookup_id
        var lookup_data =
            "<li><input type='hidden' name='item_dtl_val[]' value=''><input type='hidden' name='item_id[]' value='' readonly='readonly'><input class='left-element' style='width:90%;' type='text' name='item_name[]' value='" +
            typehead_text_format +
            "'><input type='hidden' name='lookup_id[]' value='" +
            lookup_id +
            "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
            lookup_code +
            "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='' readonly='readonly'><input type='hidden' name='session_duration[]' value=''><input type='hidden' name='session_mu[]'><input type='hidden' name='no_of_session[]'><input type='hidden' name='unit_intensity_mu[]'><input type='hidden' name='unit_intensity[]'><input type='hidden' name='frequency[]'><input type='hidden' name='mode[]'><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;</li>";
        if (lookup_code == "CHIEFCOM") {
            $(thisElement)
                .parent("span")
                .siblings("div")
                .children("div")
                .children("div")
                .children(".twitter-typeahead")
                .siblings("div")
                .children("div")
                .children("ul#chfcom")
                .append(lookup_data);
            $("#" + typehead_id).typeahead("val", "");
        } else if (lookup_code == "ICD") {
            $(thisElement)
                .parent("span")
                .siblings("div")
                .children("div")
                .children("div")
                .children(".twitter-typeahead")
                .siblings("div")
                .children("div")
                .children("ul#icd_con")
                .append(lookup_data);
            $("#" + typehead_id).typeahead("val", "");
        } else if (lookup_code == "PASTHI") {
            $(thisElement)
                .parent("span")
                .siblings("div")
                .children("div")
                .children("div")
                .children(".twitter-typeahead")
                .siblings("div")
                .children("div")
                .children("ul#pasthi")
                .append(lookup_data);
            $("#" + typehead_id).typeahead("val", "");
        } else if (lookup_code == "TREATMENTHISTORY") {
            $(thisElement)
                .parent("span")
                .siblings("div")
                .children("div")
                .children("div")
                .children(".twitter-typeahead")
                .siblings("div")
                .children("div")
                .children("ul#treatmenthis")
                .append(lookup_data);
            $("#" + typehead_id).typeahead("val", "");
        } else if (lookup_code == "CLINICHIST") {
            $(thisElement)
                .parent("span")
                .siblings("div")
                .children("div")
                .children("div")
                .children(".twitter-typeahead")
                .siblings("div")
                .children("div")
                .children("ul#ho")
                .append(lookup_data);
            $("#" + typehead_id).typeahead("val", "");
        }

        //Save part
        $.ajax({
            // async: true,
            data: {
                element_id: lookup_code,
                new_option: typehead_text,
                lookup_id: lookup_id,
            },
            url: action_url_clinical,
            type: "post",

            beforeSend: function () {
                blockUI();
            },
            success: function (item) {
                $("#item_generic_id").val(item.insert_id);
            },
            complete: function () {
                $.unblockUI();
            },
        });
    },

    addRow: function (thisElement, type) {
        var row = $(thisElement).parents("tr").clone();
        var newId =
            $(thisElement).parents("#data-append-to-physio").find("tr").length +
            1;
        var oldId = Number($(thisElement).parents("tr").attr("id"));

        row.attr("id", newId);
        if (type == "THRPEX") {
            row.find("#te_item_name_" + oldId).attr(
                "id",
                "te_item_name_" + newId
            );
            row.find("#te_session_mu_" + oldId).attr(
                "id",
                "te_session_mu_" + newId
            );
            row.find("#te_session_duration_" + oldId).attr(
                "id",
                "te_session_duration_" + newId
            );
            row.find("#te_session_unit_" + oldId).attr(
                "id",
                "te_session_unit_" + newId
            );
            row.find("#te_td_action_" + oldId).attr(
                "id",
                "te_td_action_" + newId
            );
            row.find("#te_hdn_item_id_" + oldId).attr(
                "id",
                "te_hdn_item_id_" + newId
            );
            row.find("#te_hdn_item_name_" + oldId).attr(
                "id",
                "te_hdn_item_name_" + newId
            );
            row.find("#te_hdn_lookup_id_" + oldId).attr(
                "id",
                "te_hdn_lookup_id_" + newId
            );
            row.find("#te_hdn_lookup_code_" + oldId).attr(
                "id",
                "te_hdn_lookup_code_" + newId
            );
            row.find("#te_hdn_lookupdata_code_" + oldId).attr(
                "id",
                "te_hdn_lookupdata_code_" + newId
            );
            row.find("#te_unit_intensity_mu_" + oldId).attr(
                "id",
                "te_unit_intensity_mu_" + newId
            );
            row.find("#te_unit_intensity_" + oldId).attr(
                "id",
                "te_unit_intensity_" + newId
            );
            row.find("#te_no_of_session_" + oldId).attr(
                "id",
                "te_no_of_session_" + newId
            );
            row.find("#ptte_favourit_" + oldId).attr(
                "id",
                "ptte_favourit_" + newId
            );
            row.find("#te_frequency_" + oldId).attr(
                "id",
                "te_frequency_" + newId
            );
            row.find("#te_mode_" + oldId).attr("id", "te_mode_" + newId);

            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                row.find("#in_t_repetition_" + oldId).attr(
                    "id",
                    "in_t_repetition_" + newId
                );
                row.find("#in_t_duration_" + oldId).attr(
                    "id",
                    "in_t_duration_" + newId
                );
                row.find("#in_e_location_for_thr_" + oldId).attr(
                    "id",
                    "in_e_location_for_thr_" + newId
                );
            }
            row.find("#te_session_mu_" + newId).val(
                $(thisElement).parents("tbody").find("#te_session_mu_1").val()
            );

            $(thisElement)
                .parents("tbody")
                .find("#te_item_name_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_session_duration_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_session_mu_" + oldId)
                .val("0");
            $(thisElement)
                .parents("tbody")
                .find("#te_session_unit_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_hdn_item_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_hdn_item_name_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_hdn_lookupdata_code_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_hdn_lookup_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_hdn_lookup_code_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_unit_intensity_mu_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_unit_intensity_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_no_of_session_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_frequency_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#te_mode_" + oldId)
                .val("");

            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                $(thisElement)
                    .parents("tbody")
                    .find("#in_t_repetition_" + oldId)
                    .val("");
                $(thisElement)
                    .parents("tbody")
                    .find("#in_t_duration_" + oldId)
                    .val("");
                $(thisElement)
                    .parents("tbody")
                    .find("#in_e_location_for_thr_" + oldId)
                    .val("");
            }

            var add_fav_list_action = $(thisElement).attr(
                "data-favourit-action"
            );
            var med_item_id = row.find("#te_hdn_item_id_" + newId).val();
            var med_item_name = row.find("#te_hdn_item_name_" + newId).val();

            row.find("#ptte_favourit_" + newId).html(
                '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
                    add_fav_list_action +
                    '" data-id="' +
                    med_item_id +
                    '" data-name="' +
                    med_item_name +
                    '" data-type="PTTE"><i class="fa fa-star text-primary"></i></span>'
            );
        }

        if (type == "ETHER") {
            row.find("#et_item_name_" + oldId).attr(
                "id",
                "et_item_name_" + newId
            );
            row.find("#et_item_name_" + oldId).attr("readonly", "readonly");
            row.find("#et_unit_intensity_mu_" + oldId).attr(
                "id",
                "et_unit_intensity_mu_" + newId
            );
            row.find("#et_session_duration_" + oldId).attr(
                "id",
                "et_session_duration_" + newId
            );
            row.find("#et_unit_intensity_" + oldId).attr(
                "id",
                "et_unit_intensity_" + newId
            );
            row.find("#et_td_action_" + oldId).attr(
                "id",
                "et_td_action_" + newId
            );
            row.find("#et_hdn_item_id_" + oldId).attr(
                "id",
                "et_hdn_item_id_" + newId
            );
            row.find("#et_hdn_item_name_" + oldId).attr(
                "id",
                "et_hdn_item_name_" + newId
            );
            row.find("#et_hdn_lookup_id_" + oldId).attr(
                "id",
                "et_hdn_lookup_id_" + newId
            );
            row.find("#et_hdn_lookup_code_" + oldId).attr(
                "id",
                "et_hdn_lookup_code_" + newId
            );
            row.find("#et_hdn_lookupdata_code_" + oldId).attr(
                "id",
                "et_hdn_lookupdata_code_" + newId
            );
            row.find("#et_session_mu_" + oldId).attr(
                "id",
                "et_session_mu_" + newId
            );
            row.find("#et_no_of_session_" + oldId).attr(
                "id",
                "et_no_of_session_" + newId
            );
            row.find("#ptet_favourit_" + oldId).attr(
                "id",
                "ptet_favourit_" + newId
            );
            row.find("#et_frequency_" + oldId).attr(
                "id",
                "et_frequency_" + newId
            );
            row.find("#et_mode_" + oldId).attr("id", "et_mode_" + newId);

            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                row.find("#in_e_location_" + oldId).attr(
                    "id",
                    "in_e_location_" + newId
                );
                row.find("#in_e_duration_" + oldId).attr(
                    "id",
                    "in_e_duration_" + newId
                );
                row.find("#in_m_repetition_loc_" + oldId).attr(
                    "id",
                    "in_m_repetition_loc_" + newId
                );
            }
            row.find("#et_unit_intensity_mu_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#et_unit_intensity_mu_" + oldId)
                    .val()
            );

            $(thisElement)
                .parents("tbody")
                .find("#et_item_name_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_session_duration_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_unit_intensity_mu_" + oldId)
                .val("0");
            $(thisElement)
                .parents("tbody")
                .find("#et_unit_intensity_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_hdn_item_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_hdn_item_name_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_hdn_lookup_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_hdn_lookup_code_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_hdn_lookupdata_code_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_session_mu_" + oldId)
                .val("0");
            $(thisElement)
                .parents("tbody")
                .find("#et_no_of_session_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_frequency_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#et_mode_" + oldId)
                .val("");

            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                $(thisElement)
                    .parents("tbody")
                    .find("#in_e_location_" + oldId)
                    .val("");
                $(thisElement)
                    .parents("tbody")
                    .find("#in_e_duration_" + oldId)
                    .val("");
                $(thisElement)
                    .parents("tbody")
                    .find("#in_m_repetition_loc_" + oldId)
                    .val("");
            }

            var add_fav_list_action = $(thisElement).attr(
                "data-favourit-action"
            );
            var med_item_id = row.find("#et_hdn_item_id_" + newId).val();
            var med_item_name = row.find("#et_hdn_item_name_" + newId).val();

            row.find("#ptet_favourit_" + newId).html(
                '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
                    add_fav_list_action +
                    '" data-id="' +
                    med_item_id +
                    '" data-name="' +
                    med_item_name +
                    '" data-type="PTET"><i class="fa fa-star text-primary"></i></span>'
            );
        }
        if (type == "ACUP") {
            row.find("#acup_item_name_" + oldId).attr(
                "id",
                "acup_item_name_" + newId
            );
            row.find("#acup_item_name_" + oldId).attr("readonly", "readonly");
            row.find("#unit_intensity_mu_" + oldId).attr(
                "id",
                "unit_intensity_mu_" + newId
            );
            row.find("#session_duration_" + oldId).attr(
                "id",
                "session_duration_" + newId
            );
            row.find("#unit_intensity_" + oldId).attr(
                "id",
                "unit_intensity_" + newId
            );
            row.find("#acup_td_action_" + oldId).attr(
                "id",
                "acup_td_action_" + newId
            );
            row.find("#hdn_item_id_" + oldId).attr(
                "id",
                "hdn_item_id_" + newId
            );
            row.find("#hdn_item_name_" + oldId).attr(
                "id",
                "hdn_item_name_" + newId
            );
            row.find("#hdn_lookup_id_" + oldId).attr(
                "id",
                "hdn_lookup_id_" + newId
            );
            row.find("#hdn_lookup_code_" + oldId).attr(
                "id",
                "hdn_lookup_code_" + newId
            );
            row.find("#hdn_lookupdata_code_" + oldId).attr(
                "id",
                "hdn_lookupdata_code_" + newId
            );
            row.find("#session_mu_" + oldId).attr("id", "session_mu_" + newId);
            row.find("#no_of_session_" + oldId).attr(
                "id",
                "no_of_session_" + newId
            );
            row.find("#acup_favourit_" + oldId).attr(
                "id",
                "acup_favourit_" + newId
            );
            row.find("#frequency_" + oldId).attr("id", "frequency_" + newId);
            row.find("#mode_" + oldId).attr("id", "mode_" + newId);

            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                row.find("#in_m_repetition_" + oldId).attr(
                    "id",
                    "in_m_repetition_" + newId
                );
                row.find("#in_m_duration_" + oldId).attr(
                    "id",
                    "in_m_duration_" + newId
                );
                row.find("#in_e_location_for_acup_" + oldId).attr(
                    "id",
                    "in_e_location_for_acup_" + newId
                );
            }
            row.find("#unit_intensity_mu_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#unit_intensity_mu_" + oldId)
                    .val()
            );

            $(thisElement)
                .parents("tbody")
                .find("#acup_item_name_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#session_duration_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#unit_intensity_mu_" + oldId)
                .val("0");
            $(thisElement)
                .parents("tbody")
                .find("#unit_intensity_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hdn_item_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hdn_item_name_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hdn_lookup_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hdn_lookup_code_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hdn_lookupdata_code_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#session_mu_" + oldId)
                .val("0");
            $(thisElement)
                .parents("tbody")
                .find("#no_of_session_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#frequency_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#mode_" + oldId)
                .val("");

            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                $(thisElement)
                    .parents("tbody")
                    .find("#in_m_repetition_" + oldId)
                    .val("");
                $(thisElement)
                    .parents("tbody")
                    .find("#in_m_duration_" + oldId)
                    .val("");
                $(thisElement)
                    .parents("tbody")
                    .find("#in_e_location_for_acup_" + oldId)
                    .val("");
            }

            var add_fav_list_action = $(thisElement).attr(
                "data-favourit-action"
            );
            var med_item_id = row.find("#hdn_item_id_" + newId).val();
            var med_item_name = row.find("#hdn_item_name_" + newId).val();

            row.find("#acup_favourit_" + newId).html(
                '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this)" data-url="' +
                    add_fav_list_action +
                    '" data-id="' +
                    med_item_id +
                    '" data-name="' +
                    med_item_name +
                    '" data-type="ACUP"><i class="fa fa-star text-primary"></i></span>'
            );
        }

        $(thisElement).parents("#data-append-to-physio").append(row);

        if (type == "THRPEX") {
            openItemAutocomplete(
                $("#te_item_name_" + newId),
                "PT",
                "#te_hdn_item_id_" + newId,
                "#te_hdn_item_name_" + newId,
                "203",
                "PTTE"
            ); // 3 = SERVICE ITEM TYPE
            $("#te_td_action_" + newId).html(
                "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
            );
            //$('#hdn_lookup_code_' + newId).val('THRPEX');
            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                row.find("#te_hdn_item_id_" + newId).attr("name", "item_id[]");
                row.find("#te_hdn_item_name_" + newId).attr(
                    "name",
                    "item_name[]"
                );
                row.find("#te_hdn_lookup_id_" + newId).attr(
                    "name",
                    "lookup_id[]"
                );
                row.find("#te_hdn_lookup_code_" + newId).attr(
                    "name",
                    "lookup_code[]"
                );
                row.find("#te_hdn_lookupdata_code_" + newId).attr(
                    "name",
                    "lookupdata_code[]"
                );
                row.find("#te_unit_intensity_" + newId).attr(
                    "name",
                    "unit_intensity[]"
                );
                row.find("#te_frequency_" + newId).attr("name", "frequency[]");
                row.find("#te_mode_" + newId).attr("name", "mode[]");
                row.find("#te_session_duration_" + newId).attr(
                    "name",
                    "session_duration[]"
                );
                row.find("#te_no_of_session_" + newId).attr(
                    "name",
                    "no_of_session[]"
                );
                row.find("#te_session_mu_" + newId).attr(
                    "name",
                    "session_mu[]"
                );

                row.find("#in_t_repetition_" + newId).attr(
                    "name",
                    "in_m_repetition[]"
                );
                row.find("#in_t_duration_" + newId).attr(
                    "name",
                    "in_m_duration[]"
                );
                row.find("#in_e_location_for_thr_" + newId).attr(
                    "name",
                    "in_e_location[]"
                );
            }
        }

        if (type == "ETHER") {
            openItemAutocomplete(
                $("#et_item_name_" + newId),
                "PT",
                "#et_hdn_item_id_" + newId,
                "#et_hdn_item_name_" + newId,
                "202",
                "PTET"
            ); // 3 = SERVICE ITEM TYPE
            $("#et_td_action_" + newId).html(
                "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
            );
            //$('#hdn_lookup_code_' + newId).val('ETHER');
            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                row.find("#et_hdn_item_id_" + newId).attr("name", "item_id[]");
                row.find("#et_hdn_item_name_" + newId).attr(
                    "name",
                    "item_name[]"
                );
                row.find("#et_hdn_lookup_id_" + newId).attr(
                    "name",
                    "lookup_id[]"
                );
                row.find("#et_hdn_lookup_code_" + newId).attr(
                    "name",
                    "lookup_code[]"
                );
                row.find("#et_hdn_lookupdata_code_" + newId).attr(
                    "name",
                    "lookupdata_code[]"
                );
                row.find("#et_no_of_session_" + newId).attr(
                    "name",
                    "no_of_session[]"
                );
                row.find("#et_frequency_" + newId).attr("name", "frequency[]");
                row.find("#et_mode_" + newId).attr("name", "mode[]");
                row.find("#et_session_duration_" + newId).attr(
                    "name",
                    "session_duration[]"
                );
                row.find("#et_unit_intensity_" + newId).attr(
                    "name",
                    "unit_intensity[]"
                );
                row.find("#et_unit_intensity_mu_" + newId).attr(
                    "name",
                    "session_mu[]"
                );

                row.find("#in_e_location_" + newId).attr(
                    "name",
                    "in_e_location[]"
                );
                row.find("#in_m_repetition_loc_" + newId).attr(
                    "name",
                    "in_m_repetition[]"
                );
                row.find("#in_e_duration_" + newId).attr(
                    "name",
                    "in_m_duration[]"
                );
            }
        }
        if (type == "ACUP") {
            openItemAutocomplete(
                $("#acup_item_name_" + newId),
                "PT",
                "#hdn_item_id_" + newId,
                "#hdn_item_name_" + newId,
                "242",
                "ACUP"
            ); // 3 = SERVICE ITEM TYPE
            $("#acup_td_action_" + newId).html(
                "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
            );
            //$('#hdn_lookup_code_' + newId).val('ETHER');
            var hospital_code = $("#hospital_code").val();
            if (hospital_code == "UNICO" || hospital_code == "DMHL") {
                row.find("#hdn_item_id_" + newId).attr("name", "item_id[]");
                row.find("#hdn_item_name_" + newId).attr("name", "item_name[]");
                row.find("#hdn_lookup_id_" + newId).attr("name", "lookup_id[]");
                row.find("#hdn_lookup_code_" + newId).attr(
                    "name",
                    "lookup_code[]"
                );
                row.find("#hdn_lookupdata_code_" + newId).attr(
                    "name",
                    "lookupdata_code[]"
                );
                row.find("#no_of_session_" + newId).attr(
                    "name",
                    "no_of_session[]"
                );
                row.find("#frequency_" + newId).attr("name", "frequency[]");
                row.find("#mode_" + newId).attr("name", "mode[]");
                row.find("#session_duration_" + newId).attr(
                    "name",
                    "session_duration[]"
                );
                row.find("#unit_intensity_" + newId).attr(
                    "name",
                    "unit_intensity[]"
                );
                row.find("#unit_intensity_mu_" + newId).attr(
                    "name",
                    "session_mu[]"
                );

                row.find("#in_m_repetition_" + newId).attr(
                    "name",
                    "in_m_repetition[]"
                );
                row.find("#in_m_duration_" + newId).attr(
                    "name",
                    "in_m_duration[]"
                );
                row.find("#in_e_location_for_acup_" + newId).attr(
                    "name",
                    "in_e_location[]"
                );
            }
        }
        console.log(type);
    },

    loadToPresFavouritListV2: function (
        thisElement,
        item_type,
        title,
        append_to,
        action_url,
        data_append_id = ""
    ) {
        $(thisElement)
            .parents("#cc-con")
            .find(".card-body")
            .removeClass("bg-light-blue");
        $(thisElement).parents("#cc-con .card-body").addClass("bg-light-blue");
        var hdn_su_no = $("#hdn_su_no").val();
        $.ajax({
            async: true,
            data: { item_type: item_type, hdn_su_no: hdn_su_no },
            url: action_url,
            type: "post",
            beforeSend: function () {
                $(".loading-img").html(
                    '<i class="spinner-border spinner-border-sm float-right"></i>'
                );
            },
            success: function (data) {
                $("#favourit_list_title").html(title + " Favourite List ");
                $("#favourit_list_title").attr("data-append-to", append_to);
                $(data_append_id).html(data);
                $("#favListSearch").attr("searcAttrvalue", item_type);
            },
            complete: function () {
                $(".loading-img").html("");
            },
        });
    },

    removeFromPresFavouritListV2: function (thisElement, append_id = "") {
        if (confirm("Are You Sure?")) {
            var favourit_id = $(thisElement).attr("data-favourit-id");
            var favourit_type = $(thisElement).attr("data-lookup-code");
            var action_url = $(thisElement).attr("data-action");

            $.ajax({
                async: true,
                data: {
                    favourit_id: favourit_id,
                    favourit_type: favourit_type,
                },
                url: action_url,
                type: "post",
                beforeSend: function () {
                    $(".loading-img").html(
                        '<i class="spinner-border spinner-border-sm float-right"></i>'
                    );
                },
                success: function (data) {
                    $(append_id).html(data);
                    // $("#pres-favourit-list").html(data);
                },
                complete: function () {
                    $(".loading-img").html("");
                },
            });
        }
    },
    addToPresFavouritListV2: function (thisElement, append_id = "") {
        console.log(append_id);
        var item_id = $(thisElement).attr("data-id");
        var item_name = $(thisElement).attr("data-name");
        var item_type = $(thisElement).attr("data-type");
        var action_url = $(thisElement).attr("data-url");

        var data_duration = $(thisElement).attr("data-duration");
        var data_route = $(thisElement).attr("data-route");
        var data_dose = $(thisElement).attr("data-dose");
        var data_quantity = $(thisElement).attr("data-quantity");
        var data_continue = $(thisElement).attr("data-continue");
        var data_instruction = $(thisElement).attr("data-instruction");
        var data_duration_type = $(thisElement).attr("data-duration-type");

        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                data: {
                    item_id: item_id,
                    item_name: item_name,
                    item_type: item_type,
                    data_duration: data_duration,
                    data_route: data_route,
                    data_dose: data_dose,
                    data_quantity: data_quantity,
                    data_continue: data_continue,
                    data_instruction: data_instruction,
                    data_duration_type: data_duration_type,
                },
                url: action_url,
                type: "post",
                beforeSend: function () {
                    $(".loading-img").html(
                        '<i class="spinner-border spinner-border-sm float-right"></i>'
                    );
                },
                success: function (data) {
                    // $("#pres-favourit-list").html(data);
                    $(append_id).html(data);
                },
                complete: function () {
                    $(".loading-img").html("");
                },
            });
        }
    },

    patientPrescriptionDetailsV2: function (thisElement) {
        $(thisElement).parents("table").find("tr").removeClass("bg-success");
        var action = $(thisElement).attr("data-action");
        var disease_action = $(thisElement).attr("data-disease_action");
        var temp = $(thisElement).attr("data-temp");
        var hdn_su_no = $("#hdn_su_no").val();
        var app_id = $("#hdn_appointment_id").val();
        $.ajax({
            url: action,
            type: "get",
            beforeSend: function () {
                blockUI();
            },
            success: function (data) {
                var chronic = data["chronic_disease"];
                var allergy = data["allergie_data"];
                var investigation = data["investigation_data"];

                var chro_dis = "";
                var chor_hdn = "";
                var chor_text = "";
                var chor_hdn_text = "";
                var allergy_text = "";
                $("#chronic_con").html("");
                chronic.forEach(function (item) {
                    var chor_text =
                        item.chronic_dis_description != null
                            ? item.chronic_dis_description
                            : "";
                    $("#chronic_con").append(
                        `<span class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1" style="font-size:10px;" onclick="prescriptionFunc.addChronicItem(this)" data-modal="common-modal-sm" data-action="${disease_action}">${item.chronic_dis_name}</span>`
                    );
                    chor_hdn +=
                        item.chronic_dis_item_pk_no_fk +
                        "_" +
                        item.chronic_dis_name +
                        "*";
                    chor_hdn_text +=
                        item.chronic_dis_item_pk_no_fk + "_" + chor_text + "*";
                });
                allergy.forEach(function (aller) {
                    $("#allergy_con").append(
                        `<span><span class="btn btn-outline-primary bg-none btn-sm mr-1 mb-1 open-modal" style="font-size:10px;" data-modal="common-modal-md" data-action=" route('add-allergy') ">${aller.allergies_name}</span> <sup><i class="fa fa-times remove_allergy cursor-pointer text-danger pr-2" data-allergyid="${aller.pat_allergies_no_pk}"></i></sup></span></span>`
                    );
                });

                // investigation start
                investigation.forEach(function (item) {
                    $("#investigation").append(
                        `<span><span >${item.prescrition_data}</span></span>`
                    );
                });

                // console.log(data["vitals"].sfh)
                // Investigation end

                $("#chrn-items").val(chor_hdn);
                $("#chronic_text").val(chor_hdn_text);

                //$("#patient_name").html('');
                var mobile = data["appointments"].mobile1 ?? "";
                var occupation = data["appointments"].occupation ?? "";
                $("#hdn_appointment_id").val(
                    data["appointments"].appoint_no_pk
                );
                $("#hdn_patient_id").val(data["appointments"].patient_no_pk);
                $("#hdn_patient_code").val(data["appointments"].patient_code);
                $("#patient_name").html(
                    "Name :" + data["appointments"].patient_name
                );
                $("#patient_age").html("Age :" + data["appointments"].age);
                $("#maritial_status").html(
                    "Marritial Status :" +
                        data["appointments"].marital_status_txt
                );
                $("#patient_mobile").html("Mobile :" + mobile);
                $("#patient_occupation").html("Occupation :" + occupation);

                var today = moment().format("DD/MM/YYYY");
                var comp = moment(
                    data["vitals"].au_entry_at,
                    "YYYY-MM-DD"
                ).format("DD/MM/YYYY");
                var todayMoment = moment(today, "DD/MM/YYYY");
                var compMoment = moment(comp, "DD/MM/YYYY");

                if (compMoment.isSame(todayMoment)) {
                    $("#txt_pulse").val(data["vitals"].pulse_val);
                    $("#txt_bp_sys").val(data["vitals"].bp_val_sys);
                    $("#txt_bp_dia").val(data["vitals"].bp_val_dia);
                    $("#txt_bp").val(data["vitals"].bp_val_sys);
                    $("#txt_temperature").val(data["vitals"].temp_val);
                    $("#txt_height").val(data["vitals"].height_val);
                    $("#txt_weight").val(data["vitals"].weight_val);
                    $("#txt_ofc").val(data["vitals"].ofc);
                    $("#txt_bmi").val(data["vitals"].bmi);
                    $("#txt_heart_rate").val(data["vitals"].bmi);
                    $("#respiration").val(data["vitals"].respiration);
                    $("#oxygen").val(data["vitals"].oxygen);
                    $("#txt_spo2_value").val(data["vitals"].spo2_value);
                }

                $("#txt_heart_rate").val(data["vitals"].heart_condition);
                $("#txt_lung_condition").val(data["vitals"].lung_condition);
                $("#txt_bowel_condition").val(data["vitals"].bowel_condition);
                $("#sfh").val(data["vitals"].sfh);
                $("#fm").val(data["vitals"].fm);
                $("#fhs").val(data["vitals"].fhs);
                $("#pr").val(data["vitals"].pr);
                $("#hq").val(data["vitals"].hq);
                $("#swelling").val(data["vitals"].swelling);
                $("#scar_work").val(data["vitals"].scar_work);
                $("#tenderness").val(data["vitals"].tenderness);
                $("#pae_note").val(data["vitals"].pae_note);

                $("#txt_bladder_condition").val(
                    data["vitals"].bladder_condition
                );

                // chronic hide show
                $("#c_diesease").hide();
                if (temp == "TEMP") {
                    $("#hdn_prescription_id").val("");
                    $("#hdn_appointment_id").val(app_id);
                } else {
                    $("#hdn_prescription_id").val(
                        data["vitals"].prescription_no_fk
                    );
                }
            },
            complete: function (data) {
                $(thisElement).parents("tr").addClass("bg-success");
                var prescription_id = $(thisElement).attr("data-presc");
                var dtls_action = $(thisElement).attr("data-dtls-action");
                var hdn_appointment_id = $("#hdn_appointment_id").val();

                // $.unblockUI();
                $.ajax({
                    data: {
                        hdn_su_no: hdn_su_no,
                        hdn_appointment_id: hdn_appointment_id,
                    },
                    url: dtls_action,
                    type: "get",
                    beforeSend: function () {
                        blockUI();
                    },
                    success: function (data) {
                        $("#presc_details_uhl").html("");
                        $("#presc_details_uhl").html(data);
                    },
                    complete: function (data) {
                        //   console.log('complete'+ data)
                        $(thisElement).parents("tr").addClass("bg-success"); //bg-light-blue
                        $.unblockUI();
                    },
                });
            },
        });
    },

    patientPrescriptionDetailsV3: function (thisElement) {
        console.log("tessssssssssss");
        console.log("tessssssssssssY");
        $(thisElement).parents("table").find("tr").removeClass("bg-success");
        var action = $(thisElement).attr("data-action");
        var disease_action = $(thisElement).attr("data-disease_action");
        var temp = $(thisElement).attr("data-temp");
        var hdn_su_no = $("#hdn_su_no").val();
        var app_id = $("#hdn_appointment_id").val();
        $(thisElement).parents("tr").addClass("bg-success");
        var prescription_id = $(thisElement).attr("data-presc");
        var dtls_action = $(thisElement).attr("data-dtls-action");
        var hdn_appointment_id = $("#hdn_appointment_id").val();

        // $.unblockUI();
        $.ajax({
            data: {
                hdn_su_no: hdn_su_no,
                hdn_appointment_id: hdn_appointment_id,
            },
            url: dtls_action,
            type: "get",
            beforeSend: function () {
                blockUI();
            },
            success: function (response) {
                console.log(response['lmp']['married_for'] + '___________________testing')
                $("#investigation_findings_txt").val(
                    response["investigation_findings_note"]
                );
                $("#global_hidden_note").val(response["global_hidden_note"]);
                $("#ipd_referred_advice").val(response["ipd_referred_advice"]);
                $("#note").val(response["management_plan_note"]);

                // lmp Part
                $("#obs").val(response["lmp"]['obs']);
                $("#married_for").val(response['lmp']['married_for']);
                $("#para").val(response["lmp"]['para']);
                $("#gravida").val(response["lmp"]['gravida']);
                $("#alc").val(response["lmp"]['alc']);
                $("#menstrual_cycle").val(response["lmp"]['menstrual_cycle']);
                $("#mp").val(response["lmp"]['mp']);
                $("#mf").val(response["lmp"]['mf']);
                $("#dysmenorrhoea").val(response["lmp"]['dysmenorrhoea']);
                $("#lmp").val(response["lmp"]['lmp']);
                $("#edd").val(response["lmp"]['edd']);
                $("#contraceptive_history").val(response["lmp"]['contraceptive_history']);


                // LMP end

                console.log(response["pr_arr"]);
                var doges = response["dose"];
                var route = response["route"];
                var duration = response["duration"];
                var instructions = response["instructions"];
                let pat_med_rs = response["pat_med_rs"];
                let meddurmu = response["meddurmu"];
                let cc_arr = response["cc_arr"];
                let ch_arr = response["ch_arr"];
                let icd_arr = response["icd_arr"];
                let lmp = response["lmp"];
                let in_arr = response["in_arr"];
                let inf_arr = response["inf_arr"];
                let find_arr = response["find_arr"];
                let adv_arr = response["ad_arr"];
                let pr_arr = response["pr_arr"];
                let acup_arr = response["acup_arr"];
                let ptet_arr = response["ptet_arr"];
                let ptte_arr = response["ptte_arr"];
                let duration_mu_phy = response["duration_mu_phy"];
                console.log(pat_med_rs + "testing");
                // $("#data-append-to").html("");

                let tableBody = $("#data-append-to");
                // $('#data-append-to tr').not(':first').remove();
                // var selectElement='';
                $("#data-append-to tr").slice(1).remove();
                // var selectElement='';
                // var medicineDoseCount = [];
                let medicineDoseCount = {};
                $.each(pat_med_rs, function (index, med_row) {



                    selectDoseElement = `<div class="" id="doseID" style="display: flex">
                                                <div><select class="form-control form-control-sm m-0 p-0 medicine_dose doseEdit select2 select2-hidden-accessible" id="medicine_dose_${
                                                    index + 1
                                                }" name="medicine_dose[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose'); prescriptionFunc.calculateMedicineQnty(this);" data-select2-id="medicine_dose_${
                        index + 1
                    }" tabindex="-1" aria-hidden="true"> <option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Route" data-input_label="Route" data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)" value="0">Add More</option>`;
                    $.each(doges, function (key, value) {
                        console.log(value.data);
                        const isDoseSelected =
                            med_row.dosage === value.data
                                ? `<option value="${value.data}" selected>${value.data}</option>`
                                : ` <option value="${value.data}">${value.data}</option>`;

                        const text_dose =
                            med_row.dosage != value.data
                                ? `<option value="${med_row.dosage}" selected>${med_row.dosage}</option>`
                                : "";
                        // `<option value="0" selected>${med_row.dosage}</option>`
                        // med_row.dosage === value.data
                        selectDoseElement += isDoseSelected + text_dose;
                    });
                    selectDoseElement += `</select></div> <div class="editDosButton" id="medicine_dose_${
                        index + 1
                    }"
                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editDosButton');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option_dose"
                                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                                    data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 3px 5px 6px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div></div>`;

                    console.log(selectDoseElement);

                    selectRouteElement = `<div class="" id="routeId" style="display: flex">
                                                <div><select class="form-control form-control-sm m-0 p-0 route_edit medicine_route select2 select2-hidden-accessible" id="medicine_route_${
                                                    index + 1
                                                }" name="medicine_route[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');" data-select2-id="medicine_route_${
                        index + 1
                    }" tabindex="-1" aria-hidden="true"><option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Route" data-input_label="Route" data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)" value="0">Add More</option>`;
                    $.each(route, function (key, value) {
                        const isRouteSelected =
                            med_row.route === value.data ? "selected" : "";
                        selectRouteElement += `<option value="${value.data}" ${isRouteSelected}>${value.data}</option>`;
                    });
                    selectRouteElement += `</select> </div>
                                                <div class="editRouteValue" id="medicine_route_${
                                                    index + 1
                                                }"
                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editRouteValue');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option_route"
                                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                                    data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 5px 5px 5px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div>
                                            </div>`;

                    selectInstructionElement = `<div class="" id="instructionId" style="display: flex">
                                                <div><select class="form-control form-control-sm m-0 p-0 instructionEdit medicine_instruction select2 select2-hidden-accessible" id="instruction_${
                                                    index + 1
                                                }" name="instruction[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');" data-select2-id="instruction_${
                        index + 1
                    }" tabindex="-1" aria-hidden="true"><option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Instruction" data-input_label="Instruction" data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal ...)" value="0">Add More</option>`;
                    $.each(instructions, function (key, value) {
                        const isInstructionSelected =
                            med_row.instruction_take === value.data
                                ? "selected"
                                : "";
                        selectInstructionElement += `<option value="${value.data}" ${isInstructionSelected}>${value.data}</option>`;
                    });
                    selectInstructionElement += `</select></div>
                                                <div class="editInsButton" id="instruction_${
                                                    index + 1
                                                }"

                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editInsButton');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option"
                                                    data-popup_header="Medicine Instruction"
                                                    data-input_label="Instruction"
                                                    data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal..)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 5px 5px 5px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div>
                                            </div>`;

                    selectDurationElement = `<select class="form-control form-control-sm m-0 p-0 medicine_instruction select2 select2-hidden-accessible" id="instruction_${
                        index + 1
                    }" name="instruction[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');" data-select2-id="instruction_${
                        index + 1
                    }" tabindex="-1" aria-hidden="true"><option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Instruction" data-input_label="Instruction" data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal ...)" value="0">Add More</option>`;
                    $.each(duration, function (key, value) {
                        const isDurationSelected =
                            med_row.duration === value.data ? "selected" : "";
                        selectDurationElement += `<option value="${value.data}" ${isDurationSelected}>${value.data}</option>`;
                    });
                    selectDurationElement += `</select>`;

                    selectDurationMuElement = `<select class="form-control medicine_duration_mu" id="medicine_duration_mu_${
                        index + 1
                    }" name="medicine_duration_mu[]" onchange="prescriptionFunc.calculateMedicineQnty(this)">`;
                    $.each(meddurmu, function (key, value) {
                       const isDurationMuSelected =
                        med_row.duration_mu?.trim().toUpperCase() === value.data?.trim().toUpperCase()
                            ? "selected"
                            : "";
                            console.log(med_row.duration_mu?.toUpperCase() + 'test' + value.data?.toUpperCase());

                        selectDurationMuElement += `<option value="${(value.data || '').toUpperCase()}" ${isDurationMuSelected}>${value.data}</option>`;
                    });
                    selectDurationMuElement += `</select>`;

                    // if (med_row.item_no_fk > 0) {

                    // Initialize medicineDoseCount if it doesn't exist
                    // Initialize the medicineDoseCount object if it doesn't already exist
                    // window.medicineDoseCount = window.medicineDoseCount || {};

                    // // Extract medicine item name and ID, defaulting to 'Unknown' and 0 respectively if not provided
                    // var medicineItem = med_row.brand_name || 'Unknown';
                    // var itemId = med_row.item_no_fk || 0;
                    // var doseNo = 0;

                    // // Convert itemId to a string to ensure consistent key handling
                    // var itemIdStr = String(itemId);

                    // // Increment the dose count for this itemId, initializing if necessary
                    // window.medicineDoseCount[itemIdStr] = (window.medicineDoseCount[itemIdStr] || 0) + 1;
                    // doseNo = window.medicineDoseCount[itemIdStr];

                    // // Log the dose number and item name, or indicate no doses to process
                    // if (doseNo > 0) {
                    //     console.log('Dose number for item ID ' + itemId + ' is: ' + doseNo);
                    //     console.log('Item Name: ' + medicineItem);
                    // } else {
                    //     console.log('No doses to process for item ID ' + itemId + '.');
                    // }

                    // var medicineItem = med_row.brand_name || "Unknown";
                    // var itemId = med_row.item_no_fk || 0;
                    // var doseNo = 0;
                    // var itemIdStr = String(itemId);

                    // // Increment the dose count for the current item
                    // medicineDoseCount[itemIdStr] =
                    //     (medicineDoseCount[itemIdStr] || 0) + 1;
                    // doseNo = medicineDoseCount[itemIdStr];
                    // Initialize outside the loop

                    const medicineItem = med_row.brand_name
                        ? med_row.brand_name.trim()
                        : "Unknown";
                    const itemId = med_row.item_no_fk || 0;
                    const generic_name = med_row && med_row.generic_name ? med_row.generic_name : '';
                    // Clean the brand name (remove spaces, lowercase)
                    const normalizedName = medicineItem
                        .toLowerCase()
                        .replace(/\s+/g, "");

                    // Unique key: itemId + brandName
                    const doseKey = `${itemId}_${normalizedName}`;

                    // Initialize count if not exist
                    if (!medicineDoseCount[doseKey]) {
                        medicineDoseCount[doseKey] = 0;
                    }

                    // Increment dose number
                    medicineDoseCount[doseKey]++;
                    const doseNo = medicineDoseCount[doseKey];

                    let $row = `<tr class="border-0" id="tr_id_${index + 1}">


                             <td class="p-0 px-1 border-0" width="20%">
    ${
        doseNo === 1
            ? `
        <input type="text"
            class="form-control form-control-sm m-0 p-0 item_element bg-white"
            id="medicine_item_${index + 1}" name="medicine_item[]"
            placeholder="Generic / Brand" value="${medicineItem}"
            style="border: 0px none;" readonly="readonly">`
            : ""
    }

    <input type="hidden" id="hdn_medicine_item_id_${index + 1}"
        name="hdn_medicine_item_id[]" value="${itemId}">
<input type="hidden" id="hdn_genetic_id_${index + 1}"
                                        name="hdn_genetic_id[]" value="${generic_name}">
    <input type="hidden" id="hdn_report_serial_med_${index + 1}"
        name="hdn_report_serial_med[]" value="1">

    <input type="hidden" id="hidden_multidose_id_${index + 1}"
        name="multidose[]" value="${med_row.multidose_txt}">

    ${
        doseNo > 1
            ? `
        <input type="hidden"
            class="form-control form-control-sm m-0 p-0 item_element bg-white"
            id="medicine_item_${index + 1}" name="medicine_item[]"
            placeholder="Generic / Brand" value="${medicineItem}"
            style="border: 0px none;" readonly="readonly">

        <span class="dose-id-display"
            style="color: #262323; background-color: rgb(221 164 152 / 18%); padding: 3px 15px; border-radius: 8px; font-weight: bold; display: inline-block; width: 100%; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
            Dose No: ${doseNo}
        </span>
        `
            : ""
    }
</td>



                            <td class="p-0 border-0" id="alternative_id_${
                                index + 1
                            }" style="vertical-align: top;"></td>

                            <td class="p-0 border-0" id="med_favourit_${
                                index + 1
                            }" style="vertical-align: top;">
                                <span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionV2.addToPresFavouritListV2(this, '#pres-favourit-list-med')" data-url="http://localhost/Nextgen/h360/public/add-pres-favourit-list" data-id="${med_row.item_no_fk}" data-name="${med_row.brand_name}" data-type="MED" data-duration="${med_row.duration}" data-route="${med_row.route}" data-dose="${med_row.dosage}" data-quantity="${med_row.quantity}" data-continue="${med_row.is_continue}" data-instruction="${med_row.instruction}" data-duration-type="${med_row.duration_type}"><i class="fa fa-star text-primary"></i></span>
                            </td>

                            <td class="p-0 px-1 border-0">
                              ${selectDoseElement}
                            </td>

                            <td class="p-0 px-1 border-0">
                              ${selectRouteElement}
                            </td>

                            <td class="p-0 px-1 border-0" hidden="">
                                <input type="text" class="form-control form-control-sm m-0 p-0 medicine_quantity" id="medicine_quantity_${
                                    index + 1
                                }" name="medicine_quantity[]" value="${
                        med_row.item_qty
                    }">
                            </td>

                            <td class="p-0 px-1 border-0">
                                ${selectInstructionElement}
                            </td>

                            <td class="p-0 px-1 border-0" style="width: 127%;">
                            <div class="input-group" style="width: 127%;">
                                <input type="text"
                                    class="form-control form-control-sm m-0 p-0 medicine_duration"
                                    id="medicine_duration_type_${index + 1}"
                                    name="medicine_duration_type[]"
                                    value="${med_row.duration}"
                                    ${med_row.continue_ind == 1 || med_row.duration == "Continue" ? "readonly" : ""}>
                               ${selectDurationMuElement.replace(
                                    '<select',
                                    `<select ${med_row.continue_ind == 1 || med_row.duration == "Continue" ? "" : ""}`
                                )}

                            </div>

                            </td>

                            <td class="p-0 px-1 border-0 text-center">

                            <input type="checkbox" id="is_continue_${
                                index + 1
                            }" name="is_continue[]" onchange="prescriptionFunc.setContinueDuration(this)" value="${
                        med_row.continue_ind
                    }"  ${med_row.continue_ind == 1 || med_row.duration == "Continue" ? "checked" : ""}>
                            </td>

                            <td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_td_action_1">
                                <div class="btn-group" role="group" aria-label="Button group">
                                    <span class="btn btn-danger btn-md" onclick="removeTableRowOnly(this)">
                                        <i class="fa fa-times"></i>
                                    </span>
                                    <button type="button" class="btn btn-primary btn-md add-multidose ml-3"
                                            style="${
                                                doseNo > 1
                                                    ? "cursor: not-allowed; background-color: rgb(204, 204, 204); pointer-events: none;"
                                                    : ""
                                            }"
                                            onclick="prescriptionFunc.addMultiDoseRow(this)">
                                        <i class="fa fa-clone"></i>
                                    </button>
                                </div>
                            </td>
                         </tr>`;

                    let tableBody = $("#data-append-to").append($row);
                    //  $('#dose_'+(index + 1)).html(selectElement);
                    $(".select2").select2();
                    $(".select2").removeClass("select2-hidden-accessible");
                    $(".select2-container").remove();
                    // $('.select2').select2({
                    //     // placeholder: "Select Value",
                    //     allowClear: true
                    // });

                    // from here
                    $(".select2").select2({
                        tags: true, // Enable adding new options
                        placeholder: "Select or type to add",
                        allowClear: true, // Allow clearing selection
                        templateResult: formatOption, // Format the display of options
                        templateSelection: formatOption, // Format the selected option
                    });
                    // Function to format the options with data attributes
                    function formatOption(option) {
                        if (!option.id) {
                            return option.text; // Return the text if it's a new tag
                        }
                        const $option = $(`<span>${option.text}</span>`);

                        // Accessing custom data attributes
                        const dataQnty = $(option.element).data("qnty");
                        if (dataQnty !== undefined) {
                            $option.append(` (Qty: ${dataQnty})`);
                        }

                        return $option;
                    }

                    // added new here

                    //   }
                });

                if (acup_arr["ACUP"] && acup_arr["ACUP"].length >= 1) {
                    $(".data-append-to-physio-acup tr").not(":first").remove();

                    $.each(acup_arr["ACUP"], function (index, acup_row) {
                        var parts = acup_row.split("_");

                        DurationMu = `<select class="form-control" id="unit_intensity_mu_${
                            index + 1
                        }" name="session_mu[]"><option value="0">Select</option>`;
                        $.each(duration_mu_phy, function (key, value) {
                            const DurationMuSelecte =
                                parts[5] == key ? "selected" : "";
                            DurationMu += `<option value="${key}" ${DurationMuSelecte}>${value}</option>`;
                        });
                        DurationMu += `</select>`;

                        physioElementACUP = `<tr class="border-0" id="${
                            index + 1
                        }">
                                        <td scope="row" class="p-0 px-1 border-0">
                                            <input type="text" class="form-control acup_item_name item_element" id="acup_item_name_${
                                                index + 1
                                            }" name="acup_item_name[]" value="${
                            parts[1]
                        }">
                                            <input type="hidden" class="form-control left-element" id="" name="item_id[]" value="${
                                                parts[0]
                                            }">
                                            <input type="hidden" class="form-control" id="" name="item_name[]" value="${
                                                parts[1]
                                            }">
                                            <input type="hidden" class="form-control" id="hdn_lookup_id_${
                                                index + 1
                                            }" name="lookup_id[]" value="${
                            parts[2]
                        }">
                                            <input type="hidden" class="form-control" id="hdn_lookup_code_${
                                                index + 1
                                            }" name="lookup_code[]" value="ACUP">
                                            <input type="hidden" class="form-control" id="hdn_lookupdata_code_${
                                                index + 1
                                            }" name="lookupdata_code[]" value="ACUP">
                                            <input type="hidden" class="form-control" id="no_of_session_${
                                                index + 1
                                            }" name="no_of_session[]">
                                        </td>
                                        <td class="border-0"></td>
                                        <td class="p-0 px-1 border-0"><input type="text" class="form-control" id="frequency_${
                                            index + 1
                                        }" name="frequency[]" value="${
                            parts[8]
                        }"></td>
                                        <td class="p-0 px-1 border-0"><input type="text" class="form-control" id="mode_${
                                            index + 1
                                        }" name="mode[]" value="${
                            parts[9]
                        }"></td>
                                        <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only" id="session_duration_${
                                            index + 1
                                        }" name="session_duration[]" value="${
                            parts[4]
                        }"></td>
                                        <td class="p-0 px-1 border-0">
                                            <input type="text" class="form-control" id="in_m_repetition_${
                                                index + 1
                                            }" name="in_m_repetition[]" value="${
                            parts[10]
                        }">
                                            <input type="hidden" class="form-control" id="in_e_location_for_acup_${
                                                index + 1
                                            }" name="in_e_location[]">
                                        </td>
                                        <td class="p-0 px-1 border-0"><input type="text" class="form-control number_only" id="unit_intensity_${
                                            index + 1
                                        }" name="unit_intensity[]" value="${
                            parts[7]
                        }"></td>
                                        <td class="p-0 px-1 border-0">
                                            ${DurationMu}
                                        </td>
                                        <td class="p-0 px-1 border-0"><input type="text" class="form-control" id="in_m_duration_${
                                            index + 1
                                        }" name="in_m_duration[]" value="${
                            parts[12]
                        }"></td>
                                        <td class="p-0 px-1 border-0" style="vertical-align: top;" id="acup_td_action_${
                                            index + 1
                                        }">
                                            <span class="btn btn-danger btn-sm" onclick="removeTableRowOnly(this)">
                                                <i class="fa fa-times"></i>
                                            </span>
                                        </td>
                                    </tr>`;
                        $(".data-append-to-physio-acup").append(
                            physioElementACUP
                        );
                    });
                }

                if (ptet_arr["PTET"] && ptet_arr["PTET"].length >= 1) {
                    $(".data-append-to-physio-ptet tr").not(":first").remove();
                    $.each(ptet_arr["PTET"], function (index, ptet_row) {
                        var parts = ptet_row.split("_");

                        DurationMu = `<select class="form-control" id="et_unit_intensity_mu_${
                            index + 1
                        }" name="session_mu[]"><option value="0">Select</option>`;
                        $.each(duration_mu_phy, function (key, value) {
                            const DurationMuSelecte =
                                parts[5] == key ? "selected" : "";
                            DurationMu += `<option value="${key}" ${DurationMuSelecte}>${value}</option>`;
                        });
                        DurationMu += `</select>`;

                        physioElementPTET = `<tr class="border-0" id="${
                            index + 1
                        }">
                                                <td scope="row" class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control et_item_name item_element" id="et_item_name_${
                                                        index + 1
                                                    }" name="et_item_name[]" value="${
                            parts[1]
                        }">
                                                    <input type="hidden" class="form-control left-element" id="" name="item_id[]" value="${
                                                        parts[0]
                                                    }">
                                                    <input type="hidden" class="form-control" id="" name="item_name[]" value="${
                                                        parts[1]
                                                    }">
                                                    <input type="hidden" class="form-control" id="et_hdn_lookup_id_${
                                                        index + 1
                                                    }" name="lookup_id[]" value="${
                            parts[2]
                        }">
                                                    <input type="hidden" class="form-control" id="et_hdn_lookup_code_${
                                                        index + 1
                                                    }" name="lookup_code[]" value="PTET">
                                                    <input type="hidden" class="form-control" id="et_hdn_lookupdata_code_${
                                                        index + 1
                                                    }" name="lookupdata_code[]" value="PTET">
                                                    <input type="hidden" class="form-control" id="et_no_of_session_${
                                                        index + 1
                                                    }" name="no_of_session[]">
                                                </td>
                                                <td class="border-0"></td>
                                                <td class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control" id="et_frequency_${
                                                        index + 1
                                                    }" name="frequency[]" value="${
                            parts[8]
                        }">
                                                </td>
                                                <td class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control" id="et_mode_${
                                                        index + 1
                                                    }" name="mode[]" value="${
                            parts[9]
                        }">
                                                </td>
                                                <td class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control number_only" id="et_session_duration_${
                                                        index + 1
                                                    }" name="session_duration[]" value="${
                            parts[4]
                        }">
                                                </td>
                                                <td class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control" id="in_e_location_${
                                                        index + 1
                                                    }" name="in_e_location[]" value="${
                            parts[11]
                        }">
                                                    <input type="hidden" class="form-control" id="in_m_repetition_loc_${
                                                        index + 1
                                                    }" name="in_m_repetition[]">
                                                </td>
                                                <td class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control number_only" id="et_unit_intensity_${
                                                        index + 1
                                                    }" name="unit_intensity[]" value="${
                            parts[7]
                        }">
                                                </td>
                                                <td class="p-0 px-1 border-0">
                                                    ${DurationMu}
                                                </td>
                                                <td class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control" id="in_e_duration_${
                                                        index + 1
                                                    }" name="in_m_duration[]" value="${12}">
                                                </td>
                                                <td class="p-0 px-1 border-0" style="vertical-align: top;" id="et_td_action_${
                                                    index + 1
                                                }">
                                                    <span class="btn btn-danger btn-sm" onclick="removeTableRowOnly(this)"><i class="fa fa-times"></i>
                                                    </span>
                                                </td>
                                            </tr>`;
                        $(".data-append-to-physio-ptet").append(
                            physioElementPTET
                        );
                    });
                }

                if (ptte_arr["PTTE"] && ptte_arr["PTTE"].length >= 1) {
                    $(".data-append-to-physio-ptte tr").not(":first").remove();
                    $.each(ptte_arr["PTTE"], function (index, ptte_row) {
                        var parts = ptte_row.split("_");
                        console.log(parts);

                        DurationMu = `<select class="form-control" id="te_session_mu_${
                            index + 1
                        }" name="session_mu[]"><option value="0">Select</option>`;
                        $.each(duration_mu_phy, function (key, value) {
                            const DurationMuSelecte =
                                parts[5] == key ? "selected" : "";
                            DurationMu += `<option value="${key}" ${DurationMuSelecte}>${value}</option>`;
                        });
                        DurationMu += `</option>`;

                        physioElementPTTE = `<tr class="border-0" id="${
                            index + 1
                        }">
                                                <td scope="row" class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control item_element" id="te_item_name_${
                                                        index + 1
                                                    }" name="te_item_name[]" value="${
                            parts[1]
                        }">
                                                    <input type="hidden" class="form-control left-element" id="te_hdn_item_id_${
                                                        index + 1
                                                    }" name="item_id[]" value="${
                            parts[0]
                        }">
                                                    <input type="hidden" class="form-control" id="te_hdn_item_name_${
                                                        index + 1
                                                    }" name="item_name[]" value="${
                            parts[1]
                        }">
                                                    <input type="hidden" class="form-control" id="te_hdn_lookup_id_${
                                                        index + 1
                                                    }" name="lookup_id[]" value="${
                            parts[2]
                        }">
                                                    <input type="hidden" class="form-control" id="te_hdn_lookup_code_${
                                                        index + 1
                                                    }" name="lookup_code[]" value="PTTE">
                                                    <input type="hidden" class="form-control" id="te_hdn_lookupdata_code_${
                                                        index + 1
                                                    }" name="lookupdata_code[]" value="PTTE">
                                                    <input type="hidden" class="form-control" id="te_unit_intensity_${
                                                        index + 1
                                                    }" name="unit_intensity[]">
                                                </td>
                                                <td class="border-0"></td>
                                                <td class="p-0 px-1 border-0"><input type="text" class="form-control" id="te_frequency_${
                                                    index + 1
                                                }" name="frequency[]" value="${
                            parts[8]
                        }">
                                                </td>
                                                <td class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control" id="te_mode_${
                                                        index + 1
                                                    }" name="mode[]" value="${
                            parts[9]
                        }">
                                                </td>
                                                <td class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control number_only" id="te_session_duration_${
                                                        index + 1
                                                    }" name="session_duration[]" value="${
                            parts[4]
                        }">
                                                </td>
                                                <td class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control" id="in_t_repetition_${
                                                        index + 1
                                                    }" name="in_m_repetition[]" value="${
                            parts[10]
                        }">
                                                    <input type="hidden" class="form-control" id="in_e_location_for_thr_${
                                                        index + 1
                                                    }" name="in_e_location[]">
                                                </td>
                                                <td class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control number_only" id="te_no_of_session_${
                                                        index + 1
                                                    }" name="no_of_session[]" value="${
                            parts[6]
                        }">
                                                    <input type="hidden" class="form-control number_only" id="unit_intensity_for_thr_${
                                                        index + 1
                                                    }" name="unit_intensity[]">

                                                </td>
                                                <td class="p-0 px-1 border-0">
                                                ${DurationMu}
                                                </td>

                                                <td class="p-0 px-1 border-0">
                                                    <input type="text" class="form-control" id="in_t_duration_${
                                                        index + 1
                                                    }" name="in_m_duration[]" value="${
                            parts[12]
                        }">
                                                </td>

                                                <td class="p-0 px-1 border-0" style="vertical-align: top;" id="te_td_action_${
                                                    index + 1
                                                }">

                                                    <span class="btn btn-danger btn-sm" onclick="removeTableRowOnly(this)"><i class="fa fa-times"></i>
                                                    </span>
                                                </td>
                                            </tr>`;
                        $(".data-append-to-physio-ptte").append(
                            physioElementPTTE
                        );
                    });
                }

                if (cc_arr["CHIEFCOM"] && cc_arr["CHIEFCOM"].length >= 1) {
                    $("#chfcom").html("");
                    $.each(cc_arr["CHIEFCOM"], function (index, cc_row) {
                        var chief_com = cc_row.split("_");
                        var cc_html_row = `<li id="item-${
                            chief_com[0]
                        }><input type="hidden" name="item_dtl_val[]" value=""><input type="hidden" name="item_id[]" value="${
                            chief_com[0] != 0 ? chief_com[0] : ""
                        }" readonly="readonly"><input class="left-element" style="width:90%;" type="text" name="item_name[]" value="${
                            chief_com[1]
                        }"><input type="hidden" name="lookup_id[]" value="${
                            chief_com[2]
                        }" readonly="readonly"><input type="hidden" name="lookup_code[]" value="CHIEFCOM" readonly="readonly"><input type="hidden" name="lookupdata_code[]" value="${
                            chief_com[3]
                        }" readonly="readonly"><input type="hidden" name="session_duration[]" value=""><input type="hidden" name="session_mu[]"><input type="hidden" name="no_of_session[]"><input type="hidden" name="unit_intensity_mu[]"><input type="hidden" name="unit_intensity[]"><input type="hidden" name="frequency[]"><input type="hidden" name="mode[]"><input type="hidden" name="in_m_duration[]"><input type="hidden" name="in_m_repetition[]"><input type="hidden" name="in_e_location[]"><span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span>&nbsp;</li>`;
                        $("#chfcom").append(cc_html_row);
                    });
                } else {
                    $("#chfcom").html("");
                }

                if (ch_arr["CLINICHIST"] && ch_arr["CLINICHIST"].length >= 1) {
                    $("#ho").html("");
                    $.each(ch_arr["CLINICHIST"], function (index, ch_row) {
                        var clinical_his = ch_row.split("_");
                        var ch_html_row = `<li id="item-${
                            clinical_his[0]
                        }><input type="hidden" name="item_dtl_val[]" value=""><input type="hidden" name="item_id[]" value="${
                            clinical_his[0] != 0 ? clinical_his[0] : ""
                        }" readonly="readonly"><input class="left-element" style="width:90%;" type="text" name="item_name[]" value="${
                            clinical_his[1]
                        }"><input type="hidden" name="lookup_id[]" value="${
                            clinical_his[2]
                        }" readonly="readonly"><input type="hidden" name="lookup_code[]" value="CLINICHIST" readonly="readonly"><input type="hidden" name="lookupdata_code[]" value="${
                            clinical_his[3]
                        }" readonly="readonly"><input type="hidden" name="session_duration[]" value=""><input type="hidden" name="session_mu[]"><input type="hidden" name="no_of_session[]"><input type="hidden" name="unit_intensity_mu[]"><input type="hidden" name="unit_intensity[]"><input type="hidden" name="frequency[]"><input type="hidden" name="mode[]"><input type="hidden" name="in_m_duration[]"><input type="hidden" name="in_m_repetition[]"><input type="hidden" name="in_e_location[]"><span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span>&nbsp;</li>`;
                        $("#ho").append(ch_html_row);
                    });
                } else {
                    $("#ho").html("");
                }

                // if (icd_arr["ICD"] && icd_arr["ICD"].length >= 1) {
                //     $("#icd_con").html("");
                //     $.each(icd_arr["ICD"], function (index, icd_row) {
                //         var icd_his = icd_row.split("_");
                //         var icd_html_row = `<li id="item-${
                //             icd_his[0]
                //         }><input type="hidden" name="item_dtl_val[]" value=""><input type="hidden" name="item_id[]" value="${
                //             icd_his[0] != 0 ? icd_his[0] : ""
                //         }" readonly="readonly"><input class="left-element" style="width:90%;" type="text" name="item_name[]" value="${
                //             icd_his[1]
                //         }"><input type="hidden" name="lookup_id[]" value="${
                //             icd_his[2]
                //         }" readonly="readonly"><input type="hidden" name="lookup_code[]" value="ICD" readonly="readonly"><input type="hidden" name="lookupdata_code[]" value="${
                //             icd_his[3]
                //         }" readonly="readonly"><input type="hidden" name="session_duration[]" value=""><input type="hidden" name="session_mu[]"><input type="hidden" name="no_of_session[]"><input type="hidden" name="unit_intensity_mu[]"><input type="hidden" name="unit_intensity[]"><input type="hidden" name="frequency[]"><input type="hidden" name="mode[]"><input type="hidden" name="in_m_duration[]"><input type="hidden" name="in_m_repetition[]"><input type="hidden" name="in_e_location[]"><span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span>&nbsp;</li>`;
                //         $("#icd_con").html(icd_html_row);
                //     });
                // } else {
                //     $("#icd_con").html("");
                // }

                if (icd_arr["ICD"] && icd_arr["ICD"].length >= 1) {
                    $("#icd_con").html(""); // clear first
                    let icd_html = "";

                    $.each(icd_arr["ICD"], function (index, icd_row) {
                        let icd_his = icd_row.split("_");

                        let item_id = icd_his[0] || "";
                        let item_name = icd_his[1] || "";
                        let lookup_id = icd_his[2] || "";
                        let lookupdata_code = icd_his[3] || "";

                        icd_html += `<li id="item-${item_id}">
                            <input type="hidden" name="item_dtl_val[]" value="">
                            <input type="hidden" name="item_id[]" value="${item_id != 0 ? item_id : ""}" readonly="readonly">
                            <input class="left-element" style="width:90%;" type="text" name="item_name[]" value="${item_name}">
                            <input type="hidden" name="lookup_id[]" value="${lookup_id}" readonly="readonly">
                            <input type="hidden" name="lookup_code[]" value="ICD" readonly="readonly">
                            <input type="hidden" name="lookupdata_code[]" value="${lookupdata_code}" readonly="readonly">
                            <input type="hidden" name="session_duration[]" value="">
                            <input type="hidden" name="session_mu[]">
                            <input type="hidden" name="no_of_session[]">
                            <input type="hidden" name="unit_intensity_mu[]">
                            <input type="hidden" name="unit_intensity[]">
                            <input type="hidden" name="frequency[]">
                            <input type="hidden" name="mode[]">
                            <input type="hidden" name="in_m_duration[]">
                            <input type="hidden" name="in_m_repetition[]">
                            <input type="hidden" name="in_e_location[]">

                            <span class="float-right text-danger cursor-pointer"
                                  title="Remove This Item"
                                  onclick="removeParentElement(this)">
                                  <i class="fa fa-times"></i>
                            </span>&nbsp;
                        </li>`;
                    });

                    // insert all rows at once
                    $("#icd_con").html(icd_html);
                } else {
                    $("#icd_con").html("");
                }


console.log(in_arr["INVFIND"] + "_____investi")

                if (in_arr["INVFIND"] && in_arr["INVFIND"].length >= 1) {
                    $("#investigation").html("");
                    $.each(in_arr["INVFIND"], function (index, inv_row) {
                        var inv_his = inv_row.split("_");
                        var inv_html_row = `<li id="item-${inv_his[0]}"><input type="hidden" name="item_id[]" value="${inv_his[0]}" readonly="readonly"><input class="left-element" type="hidden" name="item_name[]" value="${inv_his[1]}" readonly="readonly"><input type="hidden" name="lookup_id[]" value="${inv_his[2]}" readonly="readonly"><input type="hidden" name="lookup_code[]" value="INVFIND" readonly="readonly"><input type="hidden" name="lookupdata_code[]" value="${inv_his[3]}" readonly="readonly"><input type="hidden" name="unit_intensity[]"><input type="hidden" name="session_duration[]"><input type="hidden" name="no_of_session[]"><input type="hidden" name="session_mu[]"><input type="hidden" name="frequency[]"><input type="hidden" name="mode[]"><input type="hidden" name="in_m_duration[]"><input type="hidden" name="in_m_repetition[]"><input type="hidden" name="in_e_location[]"><i class="fa fa-angle-double-right"></i> ${inv_his[1]}&nbsp;&nbsp;<span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span></li>`;

                        $("#investigation").append(inv_html_row);
                    });
                } else {
                    $("#investigation").html("");
                }

                if (find_arr["FINDINGS"] && find_arr["FINDINGS"].length >= 1) {
                    $("#investigation_find_con").html("");
                    $.each(find_arr["FINDINGS"], function (index, find_row) {
                        var find_his = find_row.split("_");
                        var find_html_row = `<li id="item-${find_his[0]}"><input type="hidden" name="item_id[]" value="${find_his[0]}" readonly="readonly"><input class="left-element" type="hidden" name="item_name[]" value="${find_his[1]}" readonly="readonly"><input type="hidden" name="lookup_id[]" value="${find_his[2]}" readonly="readonly"><input type="hidden" name="lookup_code[]" value="INVFIND" readonly="readonly"><input type="hidden" name="lookupdata_code[]" value="${find_his[3]}" readonly="readonly"><input type="hidden" name="unit_intensity[]"><input type="hidden" name="session_duration[]"><input type="hidden" name="no_of_session[]"><input type="hidden" name="session_mu[]"><input type="hidden" name="frequency[]"><input type="hidden" name="mode[]"><input type="hidden" name="in_m_duration[]"><input type="hidden" name="in_m_repetition[]"><input type="hidden" name="in_e_location[]"><i class="fa fa-angle-double-right"></i> ${find_his[1]}&nbsp;&nbsp;<span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span></li>`;

                        $("#investigation_find_con").append(find_html_row);
                    });
                } else {
                    $("#investigation_find_con").html("");
                }

                if (adv_arr["ADVICE"] && adv_arr["ADVICE"].length >= 1) {
                    $("#adv").html("");
                    $.each(adv_arr["ADVICE"], function (index, adv_row) {
                        var adv_his = adv_row.split("_");
                        var adv_html_row = `<li id="item-${adv_his[0]}"><input type="hidden" name="item_id[]" value="${adv_his[0]}" readonly="readonly"><input class="left-element" type="text" style="width:90%;" name="item_name[]" value="${adv_his[1]}"><input type="hidden" name="lookup_id[]" value="${adv_his[2]}" readonly="readonly"><input type="hidden" name="lookup_code[]" value="ADVICE" readonly="readonly"><input type="hidden" name="lookupdata_code[]" value="${adv_his[3]}" readonly="readonly"><input type="hidden" name="unit_intensity[]"><input type="hidden" name="session_duration[]"><input type="hidden" name="no_of_session[]"><input type="hidden" name="session_mu[]"><input type="hidden" name="frequency[]"><input type="hidden" name="mode[]"><input type="hidden" name="in_m_duration[]"><input type="hidden" name="in_m_repetition[]"><input type="hidden" name="in_e_location[]"><span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span></li>`;

                        $("#adv").append(adv_html_row);
                    });
                } else {
                    $("#adv").html("");
                }
                console.log(pr_arr["PROCEDURE"] + "Nazmul");
                if (pr_arr["PROCEDURE"] && pr_arr["PROCEDURE"].length >= 1) {
                    $("#ot_list").html("");
                    // $('#proc').html('');
                    $.each(pr_arr["PROCEDURE"], function (index, proc_row) {
                        var proc_his = proc_row.split("_");
                        var proc_html_row = `<li id="item-${proc_his[0]}"><input type="hidden" name="item_id[]" value="${proc_his[0]}" readonly="readonly"><input class="left-element" type="text" style="width:90%;" name="item_name[]" value="${proc_his[1]}"><input type="hidden" name="lookup_id[]" value="${proc_his[2]}" readonly="readonly"><input type="hidden" name="lookup_code[]" value="PROCEDURE" readonly="readonly"><input type="hidden" name="lookupdata_code[]" value="PROCEDURE" readonly="readonly"><input type="hidden" name="unit_intensity[]"><input type="hidden" name="session_duration[]"><input type="hidden" name="no_of_session[]"><input type="hidden" name="session_mu[]"><input type="hidden" name="frequency[]"><input type="hidden" name="mode[]"><input type="hidden" name="in_m_duration[]"><input type="hidden" name="in_m_repetition[]"><input type="hidden" name="in_e_location[]"><span class="float-right text-danger cursor-pointer" title="Remove This Item" onclick="removeParentElement(this)"><i class="fa fa-times"></i></span></li>`;

                        $("#ot_list").append(proc_html_row);
                    });
                } else {
                    $("#ot_list").html("");
                    // $('#proc').html('');
                }

                if (lmp.medical_history) {
                    $("#medical_history").val(lmp.medical_history);
                } else {
                    $("#medical_history").val("");
                }

                if (lmp.family_history) {
                    $("#family_history").val(lmp.family_history);
                } else {
                    $("#family_history").val("");
                }

                if (lmp.surgical_history) {
                    $("#surgical_history").val(lmp.surgical_history);
                } else {
                    $("#surgical_history").val("");
                }

                if (lmp.past_history) {
                    $("#past_history").val(lmp.past_history);
                } else {
                    $("#past_history").val("");
                }

                if (lmp.outcome_measurement) {
                    $("#in_outcome_measurement").val(lmp.outcome_measurement);
                } else {
                    $("#in_outcome_measurement").val("");
                }
                previewTab();
            },
            complete: function (data) {
                $(thisElement).parents("tr").addClass("bg-success"); //bg-light-blue
                $.unblockUI();
            },
        });
    },

    // For Medicine
    patientPrescriptionMedicineDetails: function (thisElement) {
        console.log("For Medicine");

        $(thisElement).parents("table").find("tr").removeClass("bg-success");
        var action = $(thisElement).attr("data-action");
        var disease_action = $(thisElement).attr("data-disease_action");
        var temp = $(thisElement).attr("data-temp");
        var hdn_su_no = $("#hdn_su_no").val();
        var app_id = $("#hdn_appointment_id").val();
        $(thisElement).parents("tr").addClass("bg-success");
        var prescription_id = $(thisElement).attr("data-presc");
        var dtls_action = $(thisElement).attr("data-dtls-action");
        var hdn_appointment_id = $("#hdn_appointment_id").val();

        // $.unblockUI();
        $.ajax({
            data: {
                hdn_su_no: hdn_su_no,
                hdn_appointment_id: hdn_appointment_id,
            },
            url: dtls_action,
            type: "get",
            beforeSend: function () {
                blockUI();
            },
            success: function (response) {
                console.log(response["pr_arr"]);
                var doges = response["dose"];
                var route = response["route"];
                var duration = response["duration"];
                var instructions = response["instructions"];
                let pat_med_rs = response["pat_med_rs"];
                let meddurmu = response["meddurmu"];
                let cc_arr = response["cc_arr"];
                let ch_arr = response["ch_arr"];
                let icd_arr = response["icd_arr"];
                let lmp = response["lmp"];
                let in_arr = response["in_arr"];
                let inf_arr = response["inf_arr"];
                let find_arr = response["find_arr"];
                let adv_arr = response["ad_arr"];
                let pr_arr = response["pr_arr"];
                let acup_arr = response["acup_arr"];
                let ptet_arr = response["ptet_arr"];
                let ptte_arr = response["ptte_arr"];
                let duration_mu_phy = response["duration_mu_phy"];
                console.log(pr_arr + "testing");
                // $("#data-append-to").html("");

                let tableBody = $("#data-append-to");
                // $('#data-append-to tr').not(':first').remove();
                $("#data-append-to tr").slice(1).remove();
                // var selectElement='';
                var medicineDoseCount = [];
                $.each(pat_med_rs, function (index, med_row) {
                    selectDoseElement = `<div class="" id="doseID" style="display: flex">
                                                <div><select class="form-control form-control-sm m-0 p-0 medicine_dose doseEdit select2 select2-hidden-accessible" id="medicine_dose_${
                                                    index + 1
                                                }" name="medicine_dose[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose'); prescriptionFunc.calculateMedicineQnty(this);" data-select2-id="medicine_dose_${
                        index + 1
                    }" tabindex="-1" aria-hidden="true"> <option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Route" data-input_label="Route" data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)" value="0">Add More</option>`;
                    $.each(doges, function (key, value) {
                        console.log(value.data);
                        const isDoseSelected =
                            med_row.dosage === value.data
                                ? `<option value="${value.data}" selected>${value.data}</option>`
                                : ` <option value="${value.data}">${value.data}</option>`;

                        const text_dose =
                            med_row.dosage != value.data
                                ? `<option value="${med_row.dosage}" selected>${med_row.dosage}</option>`
                                : "";
                        // `<option value="0" selected>${med_row.dosage}</option>`
                        // med_row.dosage === value.data
                        selectDoseElement += isDoseSelected + text_dose;
                    });
                    selectDoseElement += `</select></div> <div class="editDosButton" id="medicine_dose_${
                        index + 1
                    }"
                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editDosButton');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option_dose"
                                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                                    data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 3px 5px 6px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div></div>`;

                    console.log(selectDoseElement);

                    selectRouteElement = `<div class="" id="routeId" style="display: flex">
                                                <div><select class="form-control form-control-sm m-0 p-0 route_edit medicine_route select2 select2-hidden-accessible" id="medicine_route_${
                                                    index + 1
                                                }" name="medicine_route[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_route');" data-select2-id="medicine_route_${
                        index + 1
                    }" tabindex="-1" aria-hidden="true"><option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Route" data-input_label="Route" data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)" value="0">Add More</option>`;
                    $.each(route, function (key, value) {
                        const isRouteSelected =
                            med_row.route === value.data ? "selected" : "";
                        selectRouteElement += `<option value="${value.data}" ${isRouteSelected}>${value.data}</option>`;
                    });
                    selectRouteElement += `</select> </div>
                                                <div class="editRouteValue" id="medicine_route_${
                                                    index + 1
                                                }"
                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editRouteValue');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option_route"
                                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                                    data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 5px 5px 5px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div>
                                            </div>`;

                    selectInstructionElement = `<div class="" id="instructionId" style="display: flex">
                                                <div><select class="form-control form-control-sm m-0 p-0 instructionEdit medicine_instruction select2 select2-hidden-accessible" id="instruction_${
                                                    index + 1
                                                }" name="instruction[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');" data-select2-id="instruction_${
                        index + 1
                    }" tabindex="-1" aria-hidden="true"><option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Instruction" data-input_label="Instruction" data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal ...)" value="0">Add More</option>`;
                    $.each(instructions, function (key, value) {
                        const isInstructionSelected =
                            med_row.instruction_take === value.data
                                ? "selected"
                                : "";
                        selectInstructionElement += `<option value="${value.data}" ${isInstructionSelected}>${value.data}</option>`;
                    });
                    selectInstructionElement += `</select></div>
                                                <div class="editInsButton" id="instruction_${
                                                    index + 1
                                                }"

                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editInsButton');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option"
                                                    data-popup_header="Medicine Instruction"
                                                    data-input_label="Instruction"
                                                    data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal..)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 5px 5px 5px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div>
                                            </div>`;

                    selectDurationElement = `<select class="form-control form-control-sm m-0 p-0 medicine_instruction select2 select2-hidden-accessible" id="instruction_${
                        index + 1
                    }" name="instruction[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_instruction');" data-select2-id="instruction_${
                        index + 1
                    }" tabindex="-1" aria-hidden="true"><option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Instruction" data-input_label="Instruction" data-input_placeholder="Enter instruction (i.e., After Meal, Before Meal ...)" value="0">Add More</option>`;
                    $.each(duration, function (key, value) {
                        const isDurationSelected =
                            med_row.duration === value.data ? "selected" : "";
                        selectDurationElement += `<option value="${value.data}" ${isDurationSelected}>${value.data}</option>`;
                    });
                    selectDurationElement += `</select>`;

                    selectDurationMuElement = `<select class="form-control medicine_duration_mu" id="medicine_duration_mu_${
                        index + 1
                    }" name="medicine_duration_mu[]" onchange="prescriptionFunc.calculateMedicineQnty(this)">`;
                    $.each(meddurmu, function (key, value) {
                        const isDurationMuSelected =
                            med_row.duration_mu == value.data.toUpperCase()
                                ? "selected"
                                : "";
                        selectDurationMuElement += `<option value="${value.data}" ${isDurationMuSelected}>${value.data}</option>`;
                    });
                    selectDurationMuElement += `</select>`;

                    // if (med_row.item_no_fk > 0) {

                    // Initialize medicineDoseCount if it doesn't exist
                    // window.medicineDoseCount = window.medicineDoseCount || {};
                    // var medicineItem = med_row.brand_name || 'Unknown';
                    // var itemId = med_row.item_no_fk || 0;
                    // var doseNo = 0;
                    // var itemIdStr = String(itemId);
                    // window.medicineDoseCount[itemIdStr] = (window.medicineDoseCount[itemIdStr] || 0) + 1;
                    // doseNo = window.medicineDoseCount[itemIdStr];
                    // if (doseNo > 0) {
                    //     console.log('Dose number for item ID ' + itemId + ' is: ' + doseNo);
                    //     console.log('Item Name: ' + medicineItem);
                    // } else {
                    //     console.log('No doses to process for item ID ' + itemId + '.');
                    // }
                    var medicineItem = med_row.brand_name || "Unknown";
                    var itemId = med_row.item_no_fk || 0;
                    var doseNo = 0;
                    var itemIdStr = String(itemId);

                    // Increment the dose count for the current item
                    medicineDoseCount[itemIdStr] =
                        (medicineDoseCount[itemIdStr] || 0) + 1;
                    doseNo = medicineDoseCount[itemIdStr];

                    let $row = `<tr class="border-0" id="tr_id_${index + 1}">


                             <td class="p-0 px-1 border-0" width="20%">
                                ${
                                    doseNo === 1
                                        ? `
                                    <input type="text"
                                        class="form-control form-control-sm m-0 p-0 item_element bg-white"
                                        id="medicine_item_${
                                            index + 1
                                        }" name="medicine_item[]"
                                        placeholder="Generic / Brand" value="${medicineItem}"
                                        style="border: 0px none;" readonly="readonly">
                                `
                                        : ""
                                }
                                <!-- Hidden input fields for item ID and serial number -->
                                <input type="hidden" id="hdn_medicine_item_id_${
                                    index + 1
                                }"
                                    name="hdn_medicine_item_id[]" value="${itemId}">
                                <input type="hidden" id="hdn_report_serial_med_${
                                    index + 1
                                }"
                                    name="hdn_report_serial_med[]" value="1">
                                <input type="hidden" id="hidden_multidose_id_${
                                    index + 1
                                }"
                                    name="multidose[]" value="${
                                        med_row.multidose_txt
                                    }">
                                ${
                                    doseNo > 1
                                        ? `
                                    <input type="hidden"
                                        class="form-control form-control-sm m-0 p-0 item_element bg-white"
                                        id="medicine_item_${
                                            index + 1
                                        }" name="medicine_item[]"
                                        placeholder="Generic / Brand" value="${medicineItem}"
                                        style="border: 0px none;" readonly="readonly">
                                    <span class="dose-id-display"
                                        style="color: #262323; background-color: rgb(221 164 152 / 18%); padding: 3px 15px; border-radius: 8px; font-weight: bold; display: inline-block; width: 100%; font-size: 14px; text-transform: uppercase; letter-spacing: 0.5px;">
                                        Dose No: ${doseNo}
                                    </span>
                                `
                                        : ""
                                }
                            </td>

                            <td class="p-0 border-0" id="alternative_id_${
                                index + 1
                            }" style="vertical-align: top;"></td>

                            <td class="p-0 border-0" id="med_favourit_${
                                index + 1
                            }" style="vertical-align: top;">
                                <span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionV2.addToPresFavouritListV2(this, '#pres-favourit-list-med')" data-url="http://localhost/Nextgen/h360/public/add-pres-favourit-list" data-id="${
                                    med_row.item_no_fk
                                }" data-name="${
                        med_row.brand_name
                    }" data-type="MED" data-duration="${
                        med_row.duration
                    }" data-route="${med_row.route}" data-dose="${
                        med_row.dosage
                    }" data-quantity="${med_row.quantity}" data-continue="${
                        med_row.is_continue
                    }" data-instruction="${
                        med_row.instruction
                    }" data-duration-type="${
                        med_row.duration_type
                    }"><i class="fa fa-star text-primary"></i></span> <br>
                                <span class="float-right text-secondary mr-1 cursor-pointer" data-modal="common-modal-xl" style="font-size:11px;" title="Add Multidose Medicine" onclick="prescriptionFunc.addMultidoseList(this)" data-action="http://localhost/Nextgen/h360/public/add-multidose" data-url="http://localhost/Nextgen/h360/public/add-pres-favourit-list" data-id="${
                                    med_row.item_no_fk
                                }" data-name="${
                        med_row.brand_name
                    }" data-type="MED" data-duration="${
                        med_row.duration
                    }" data-route="${med_row.route}" data-dose="${
                        med_row.dosage
                    }" data-quantity="${med_row.quantity}" data-continue="${
                        med_row.is_continue
                    }" data-instruction="${
                        med_row.instruction
                    }" data-duration-type="${
                        med_row.duration_type
                    }" data-row-id="${index}"><i class="fa fa-medkit text-danger"></i>
                                </span>
                            </td>

                            <td class="p-0 px-1 border-0">
                              ${selectDoseElement}
                            </td>

                            <td class="p-0 px-1 border-0">
                              ${selectRouteElement}
                            </td>

                            <td class="p-0 px-1 border-0" hidden="">
                                <input type="text" class="form-control form-control-sm m-0 p-0 medicine_quantity" id="medicine_quantity_${
                                    index + 1
                                }" name="medicine_quantity[]" value="${
                        med_row.item_qty
                    }">
                            </td>

                            <td class="p-0 px-1 border-0">
                                ${selectInstructionElement}
                            </td>

                            <td class="p-0 px-1 border-0" style="width: 127%;">
                            <div class="input-group" style="width: 127%;">
                                <input type="text" class="form-control form-control-sm m-0 p-0 medicine_duration" id="medicine_duration_type_${
                                    index + 1
                                }" name="medicine_duration_type[]" value="${
                        med_row.duration
                    }">
                               ${selectDurationMuElement}
                            </div>
                            </td>

                            <td class="p-0 px-1 border-0 text-center">
                            <input type="checkbox" id="is_continue_${
                                index + 1
                            }" name="is_continue[]" onchange="prescriptionFunc.setContinueDuration(this)" value="${
                        med_row.continue_ind
                    }" ${med_row.continue_ind == 1 ? "checked" : ""}>
                            </td>

                            <td class="p-0 px-1 border-0" style="vertical-align: top;" id="med_td_action_1">
                                <div class="btn-group" role="group" aria-label="Button group">
                                    <span class="btn btn-danger btn-sm" onclick="removeTableRowOnly(this)">
                                        <i class="fa fa-times"></i>
                                    </span>
                                    <button type="button" class="btn btn-primary btn-sm add-multidose ml-1"
                                            style="${
                                                doseNo > 1
                                                    ? "cursor: not-allowed; background-color: rgb(204, 204, 204); pointer-events: none;"
                                                    : ""
                                            }"
                                            onclick="prescriptionFunc.addMultiDoseRow(this)">
                                        <i class="fa fa-clone"></i>
                                    </button>
                                </div>
                            </td>

                         </tr>`;

                    let tableBody = $("#data-append-to").append($row);
                    //  $('#dose_'+(index + 1)).html(selectElement);
                    $(".select2").select2();
                    $(".select2").removeClass("select2-hidden-accessible");
                    $(".select2-container").remove();
                    // $('.select2').select2({
                    //     // placeholder: "Select Value",
                    //     allowClear: true
                    // });

                    // from here
                    $(".select2").select2({
                        tags: true, // Enable adding new options
                        placeholder: "Select or type to add",
                        allowClear: true, // Allow clearing selection
                        templateResult: formatOption, // Format the display of options
                        templateSelection: formatOption, // Format the selected option
                    });
                    // Function to format the options with data attributes
                    function formatOption(option) {
                        if (!option.id) {
                            return option.text; // Return the text if it's a new tag
                        }
                        const $option = $(`<span>${option.text}</span>`);

                        // Accessing custom data attributes
                        const dataQnty = $(option.element).data("qnty");
                        if (dataQnty !== undefined) {
                            $option.append(` (Qty: ${dataQnty})`);
                        }

                        return $option;
                    }

                    // added new here

                    //   }
                });

                previewTab();
            },
            complete: function (data) {
                $(thisElement).parents("tr").addClass("bg-success"); //bg-light-blue
                $.unblockUI();
            },
        });
    },

    doctorQuickRegExt: function (thisElement) {
        var formID = $(thisElement).parents("form").attr("id");
        var formAction = $(thisElement).parents("form").attr("action");
        var formMethod = $(thisElement).parents("form").attr("method");
        var doc_type = $(thisElement).parents("form").find("#doc_type").val();

        if (formValidation(formID) == false) {
            return;
        }

        if (confirm("Are You Sure?")) {
            $.ajax({
                data: $("#" + formID).serialize(),
                url: formAction,
                type: formMethod,
                beforeSend: function () {
                    blockUI();
                },
                success: function (data) {
                    console.log(data);
                    var last_name =
                        data.last_name != null ? data.last_name : "";
                    // if (doc_type == 1) {

                    $("#txt_referred_doctor").val(last_name);
                    $("#ref_doc_card_hidn").val(data.insert_id);

                    $(".department_name").val(data.su_name);
                    $("#department").val(data.su_name);
                    $("#doc_dept")
                        .find(":selected")
                        .val(data.serviceunit_no_fk);
                    $("#doc_dept").find(":selected").text(data.su_name);

                    // var name = data.last_name != null ? "<strong>Name: </strong>" + last_name + "," : "";
                    // var doc_phone = data.doctor_mobile != "" ? " ,<strong> Phone : </strong>" + data.doctor_mobile : "";
                    // var doctor_info = "<div id='doctorRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteDoc(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span>&nbsp; <strong>Doctor Code: " + data.doctor_code + " : </strong>" + name + doc_phone + " " + "(1st)</div>";
                    // $("#doctor_info").html(doctor_info);
                    // }
                    // if (doc_type == 2) {
                    //     $("#hdn_first_refer").val(data.insert_id);
                    //     $("#first_refer").val(data.last_name);
                    //     var name = data.last_name != null ? "<strong>Name: </strong>" + last_name + "," : "";
                    //     var doc_phone = data.doctor_mobile != "" ? " ,<strong> Phone : </strong>" + data.doctor_mobile : "";
                    //     var doctor_info = "<div id='firstRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteFirstRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>Doctor Code: " + data.doctor_code + " : </strong>" + name + doc_phone + " " + "(2nd)</div>";
                    //     $("#doctor_ref1_info").html(doctor_info);
                    // }
                    // if (doc_type == 3) {
                    //     $("#hdn_second_refer").val(data.insert_id);
                    //     $("#second_refer").val(data.last_name);
                    //     var name = data.last_name != null ? "<strong>Name: </strong>" + last_name + "," : "";
                    //     var doc_phone = data.doctor_mobile != "" ? " ,<strong> Phone : </strong>" + data.doctor_mobile : "";
                    //     var doctor_info = "<div id='secondRef'><span class='btn btn-sm btn-danger' data-id='' onclick='deleteSecRef(this)' data-url='' title='Cancel this appointment'><i class='fas fa-times'></i></i></span> &nbsp; <strong>Doctor Code: " + data.doctor_code + " : </strong>" + name + doc_phone + " " + "(3rd)</div>";
                    //     $("#doctor_ref2_info").html(doctor_info);
                    // }
                },
                complete: function () {
                    if (isAModalOpen) $(".modal").modal("hide");

                    // if (doc_type == 1) {
                    //     $("#txt_referred_doctor").focus();
                    // }
                    $.unblockUI();
                },
            });
        }
        event.stopImmediatePropagation();
    },

    // Most Used Part

     addMedRow: function (thisElement) {

        var checkEmpty = $("#medicine_item_0").val().trim();
        console.log(checkEmpty)
        if (checkEmpty === "") {
            alert("Medichine Name is Empty!");
        } else {
            var hospital_code = $("#hospital_code").val();
            var lookup_code = $(thisElement).attr("data-lookup-code");
             var item_id = $('#hdn_medicine_item_id_0').val();
             console.log(item_id + 'first')
                if(item_id == '' || item_id == 0){
                    var item_id = (item_name = "");
                }
                console.log(item_id + 'last')
            if (lookup_code == "MED") {

                console.log(item_id + 'last')
                var item_name = $(thisElement).attr("data-item-name");

                var data_route_med = $(thisElement).attr("data-route-med");
                var data_dose_med = $(thisElement).attr("data-dose-med");
                var data_duration_med =
                    $(thisElement).attr("data-duration-med");
                var data_duration_mu_med = $(thisElement).attr(
                    "data-duration-mu-med"
                );
                var data_quantity_med =
                    $(thisElement).attr("data-quantity-med");
                var data_instruction_med = $(thisElement).attr(
                    "data-instruction-med"
                );

                thisElement = $("#med_td_action_0 span");
            }
            console.log(item_id + 'datafining')
            // var hdn_item_id_alert = $("#hdn_medicine_item_id_0").val();
 // check med row
            // var same_item = false;

            //     if (
            //         hdn_item_id_alert !== '' &&
            //         hdn_item_id_alert !== 0 &&
            //         hdn_item_id_alert !== '0' &&
            //         hdn_item_id_alert !== undefined
            //         ) {
            //     $("input.same-item-id").each(function (_, elem) {
            //         if ($(elem).val() === hdn_item_id_alert) {
            //             same_item = true;
            //             return false;
            //         }
            //     });
            // } else {
            //     $("input.same-item-name").each(function (_, elem) {
            //         console.log($(elem).val())
            //         if ($(elem).val() === checkEmpty) {
            //             same_item = true;
            //             return false;
            //         }
            //     });
            // }

            // if (same_item) {
            //     alert("You have already taken this item.");
            //     $("#hdn_medicine_item_id_0").val("");
            //     $("#medicine_item_0").val("");
            //     return false;
            // }


        // var same_gen = false;
        // $("input[class=same-gen-id]").each(function (index, elem) {
        //     if ($(elem).val() == hdn_gen_name) {
        //         same_gen = true;
        //         return false;
        //     }
        // });
        // if (same_gen == true) {
        //     $("#hdn_medicine_item_id_0").val("");
        //     $("#hdn_gen_name_0").val("");
        //     $("#medicine_item_0").val("");
        //     return false;
        // }




console.log(item_id + 'datafining')
            var row = $(thisElement).parents("tr").clone();
            var newId = $(thisElement).parents("#data-append-to").find("tr").length;

        if (newId >0 ) {
             newId=$(thisElement)
            .closest('#data-append-to')
            .find('tr:last')
            .find('input[name="hdn_report_serial_med[]"]')
            .val();
                newId++;
                // alert(newId)
        }else{
            newId =1;
        }
            var oldId = Number($(thisElement).parents("tr").attr("id"));

            row.attr("id", "tr_id_" + newId);

            row.find("#hdn_report_serial_med_" + oldId).attr(
                "id",
                "hdn_report_serial_med_" + newId
            );
            row.find("#hidden_multidose_id_" + oldId).attr(
                "id",
                "hidden_multidose_id_" + newId
            );
            row.find("#hdn_medicine_item_id_" + oldId).attr(
                "id",
                "hdn_medicine_item_id_" + newId
            );

            row.find("#medicine_item_" + oldId)
                .attr("id", "medicine_item_" + newId)
                .css({ "background-color": "#ffffff", border: "0px" });
            row.find("#med_favourit_" + oldId).attr(
                "id",
                "med_favourit_" + newId
            );
            row.find("#alternative_id_" + oldId).attr(
                "id",
                "alternative_id_" + newId
            );
            row.find("#medicine_dose_" + oldId).attr(
                "id",
                "medicine_dose_" + newId
            );
             var continue_ind = $('#is_continue_0').is(':checked') ? 1 : 0;
            console.log(continue_ind + ' ___________ continue');
            // ID update
            row.find("#medicine_duration_mu_" + oldId).attr("id", "medicine_duration_mu_" + newId);
            row.find("#medicine_duration_type_" + oldId).attr("id", "medicine_duration_type_" + newId);

            // Condition check
            if (continue_ind == 1) {
                row.find("#medicine_duration_mu_" + newId)
                .val("DAY")
                .prop("readonly", true);

                row.find("#medicine_duration_type_" + newId)
                    .val("0")
                    .prop("readonly", true);
            } else {
                row.find("#medicine_duration_mu_" + newId).prop("readonly", false);
                row.find("#medicine_duration_type_" + newId).prop("readonly", false);
            }


            // row.find("#medicine_duration_mu_" + oldId).attr(
            //     "id",
            //     "medicine_duration_mu_" + newId
            // );
            // row.find("#medicine_duration_type_" + oldId).attr(
            //     "id",
            //     "medicine_duration_type_" + newId
            // );
            row.find("#medicine_quantity_" + oldId).attr(
                "id",
                "medicine_quantity_" + newId
            );
            row.find("#instruction_" + oldId).attr(
                "id",
                "instruction_" + newId
            );
            row.find("#medicine_route_" + oldId).attr(
                "id",
                "medicine_route_" + newId
            );
            row.find("#is_continue_" + oldId).attr(
                "id",
                "is_continue_" + newId
            );
            //row.find('#is_chronic_' + oldId).attr('id', 'is_chronic_' + newId);
            row.find("#med_td_action_" + oldId).attr(
                "id",
                "med_td_action_" + newId
            );

            var interaction_route = $("#hdn_interaction_url").val();
            var hdn_patient_id = $("#hdn_patient_id").val();
            if (lookup_code == "MEDDT" && item_id != '') {
                console.log(checkEmpty,item_id,newId)
                row.find("#hdn_medicine_item_id_" + newId).val(item_id);
                row.find("#medicine_item_" + newId).val(checkEmpty);
                // row.find("#medicine_item_" + newId).val(item_name);
                row.find("#medicine_route_" + newId)
                    .val(data_route_med)
                    .change();
                // row.find('#medicine_quantity_' + newId).val(data_quantity_med);
                // row.find('#medicine_duration_type_' + newId).val(data_duration_med);
            //      row.find("#hdn_medicine_item_id_" + newId).val(
            //     $(thisElement)
            //         .parents("tbody")
            //         .find("#hdn_medicine_item_id_" + oldId)
            // );
            }else{
                 row.find("#hdn_medicine_item_id_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#hdn_medicine_item_id_" + oldId)
            );
            }

            let checkbox = row.find("#is_continue_" + newId);

            // Check if checkbox is checked, assign 1 or 0
            let isChecked = checkbox.is(":checked") ? 1 : 0;

            // Set value to the checkbox (if needed)
            checkbox.val(isChecked + 'checking check' + newId);


            row.find("#is_continue_" + newId).val(isChecked);

            row.find("#hdn_report_serial_med_" + newId).val(newId);

            row.find("#hdn_report_serial_med_" + newId).val(newId);
            row.find("#hidden_multidose_id_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#hidden_multidose_id_" + oldId)
                    .val()
            );
            row.find("#medicine_dose_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#medicine_dose_" + oldId)
                    .val()
            );
            row.find("#medicine_duration_type_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#medicine_duration_type_" + oldId)
                    .val()
            );
            row.find("#instruction_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#instruction_" + oldId)
                    .val()
            );
            row.find("#medicine_route_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#medicine_route_" + oldId)
                    .val()
            );

            row.find("#medicine_duration_mu_" + newId).val(
                $(thisElement)
                    .parents("tbody")
                    .find("#medicine_duration_mu_" + oldId)
                    .val()
            );


            // row.find("#medicine_item_" + newId).val(
            //     $(thisElement)
            //         .parents("tbody")
            //         .find("#medicine_item_" + oldId)
            //         .addClass("same-item-name")
            // );
            // row.find("#hdn_medicine_item_id_" + oldId)
            //     .attr("id", "hdn_medicine_item_id_" + newId)
            //     .addClass("same-item-id");

            $(thisElement)
                .parents("tbody")
                .find("#hdn_report_serial_med_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hidden_multidose_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#hdn_medicine_item_id_" + oldId)
                .val("");
            $(thisElement)
                .parents("tbody")
                .find("#medicine_item_" + oldId)
                .val("");
            // $(thisElement).parents('tbody').find('#medicine_dose_' + oldId).val('0');

            // $(thisElement).parents('tbody').find('#medicine_dose_' + oldId).select2("val", "0");
            $(thisElement)
                .parents("tbody")
                .find("#medicine_duration_mu_" + oldId)
                .val("DAY");

            $(thisElement)
                .parents("tbody")
                .find("#medicine_duration_type_" + oldId)
                .val("0");

                $(thisElement)
                .parents("tbody")
                .find("#medicine_duration_mu_" + oldId)
                .val("DAY")
                .prop("readonly", false);

            $(thisElement)
                .parents("tbody")
                .find("#medicine_duration_type_" + oldId)
                .val("0")
                .prop("readonly", false);

            $(thisElement).parents("tbody")
            .find("#medicine_duration_mu_" + oldId).prop("readonly", false);

            $(thisElement).parents("tbody")
            .find("#medicine_duration_type_" + oldId).prop("readonly", false);
            $(thisElement)
                .parents("tbody")
                .find("#medicine_quantity_" + oldId)
                .val("");



            // $(thisElement).parents('tbody').find('#instruction_' + oldId).val('0');
            // $(thisElement).parents('tbody').find('#instruction_' + oldId).select2("val", "0");
            $(thisElement)
                .parents("tbody")
                .find("#medicine_route_" + oldId)
                .val(0);
            $(thisElement)
                .parents("tbody")
                .find("#instruction_" + oldId)
                .val(0);
            $(thisElement)
                .parents("tbody")
                .find("#medicine_dose_" + oldId)
                .val(0);
            $(thisElement)
                .parents("tbody")
                .find("#is_continue_" + oldId)
                .prop("checked", false);
                $(thisElement)
                .parents("tbody")
                .find("#is_continue_" + oldId)
                .val(0)
            // $(thisElement).parents('tbody').find('#medicine_route_' + oldId).select2("val", "0");

            var add_fav_list_action = $(thisElement).attr(
                "data-favourit-action"
            );
            var data_multidose_action = $(thisElement).attr(
                "data-multidose-action"
            );
            var data_alternative_action = $(thisElement).attr(
                "data-alternative-action"
            );
            var med_item_id = row.find("#hdn_medicine_item_id_" + newId).val();

            var med_item_name = row.find("#medicine_item_" + newId).val();

            var med_dose = row.find("#medicine_dose_" + newId).val();
            var med_route = row.find("#medicine_route_" + newId).val();
            var med_duration = row
                .find("#medicine_duration_type_" + newId)
                .val();
                med_duration = med_duration.trim() === '' ? 0 : med_duration;

            var med_quantity = row.find("#medicine_quantity_" + newId).val();
            var med_continue = row.find("#is_continue_" + newId).val();
            var med_instruction = row.find("#instruction_" + newId).val();
            var med_duration_type = row
                .find("#medicine_duration_mu_" + newId)
                .val();

           row.find("#med_favourit_" + newId).html(
                '<span class="float-right text-secondary mr-1 cursor-pointer" style="font-size:11px;" title="Add To Favourite List" onclick="prescriptionFunc.addToPresFavouritList(this,\'#pres-favourit-list-med\')" data-url="' +
                    add_fav_list_action +
                    '" data-id="' +
                    med_item_id +
                    '" data-name="' +
                    med_item_name +
                    '" data-type="MED" data-duration="' +
                    med_duration +
                    '" data-route="' +
                    med_route +
                    '" data-dose="' +
                    med_dose +
                    '" data-quantity="' +
                    med_quantity +
                    '" data-continue="' +
                    med_continue +
                    '" data-instruction="' +
                    med_instruction +
                    '" data-duration-type="' +
                    med_duration_type +
                    '"><i class="fa fa-star text-primary"></i></span> '
            );
            // if (hospital_code != "UNICO") {
            //     row.find("#alternative_id_" + newId).html(
            //         '<span class="float-right text-secondary cursor-pointer" data-modal="common-modal-md" style="font-size:11px;border: 1px solid aqua;padding: 4px;margin-top: 9px;border-radius: 5px;" title="Alternative Medicine" onclick="prescriptionFunc.alternativeMedicine(this)" data-action="' +
            //             data_multidose_action +
            //             '" data-id="' +
            //             med_item_id +
            //             '" data-name="' +
            //             med_item_name +
            //             '" data-type="MED" data-duration="' +
            //             med_duration +
            //             '" data-route="' +
            //             med_route +
            //             '" data-dose="' +
            //             med_dose +
            //             '" data-quantity="' +
            //             med_quantity +
            //             '" data-continue="' +
            //             med_continue +
            //             '" data-instruction="' +
            //             med_instruction +
            //             '" data-duration-type="' +
            //             med_duration_type +
            //             '" data-row-id="' +
            //             newId +
            //             '" data-alternative-action="' +
            //             data_alternative_action +
            //             '">ALT</span>'
            //     );
            // }

            var item_id = row.find("#hdn_medicine_item_id_" + newId).val();
            var interaction_result = "";
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

            openItemAutocompleteWithStockPrescription(
                $("#medicine_item_0"),
                "MED",
                "#hdn_medicine_item_id_0",
                "#medicine_item_0"
            );

            $("#medicine_item_0").focus();

            // $("#med_td_action_" + newId).html(
            //     "<span class='btn btn-danger btn-sm remove_item' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
            // );

            // alert('ok'+newId)
            // $("#med_td_action_"+newId).htm('');
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

            $(".select2").select2();
            $(".select2").removeClass("select2-hidden-accessible");
            $(".select2-container").remove();

            $("#hdn_genetic_id_0").val('');

            // $('.select2').select2({
            //     // placeholder: "Select Value",
            //     allowClear: true
            // });

            // from here
            $(".select2").select2({
                tags: true, // Enable adding new options
                placeholder: "Select or type to add",
                allowClear: true, // Allow clearing selection
                templateResult: formatOption, // Format the display of options
                templateSelection: formatOption, // Format the selected option
            });
            // Function to format the options with data attributes
            function formatOption(option) {
                if (!option.id) {
                    return option.text; // Return the text if it's a new tag
                }
                const $option = $(`<span>${option.text}</span>`);

                // Accessing custom data attributes
                const dataQnty = $(option.element).data("qnty");
                if (dataQnty !== undefined) {
                    $option.append(`${dataQnty}`);
                }

                return $option;
            }

            // added new here
        }
    },
};
