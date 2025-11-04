<script type="application/javascript">
    function addPermanetItem(thisElement, typehead_element){
        var typehead_id = $(thisElement).parents(".twitter-typeahead").find(".tt-input").attr("id");
        var typehead_text_format = $("#" + typehead_id).typeahead('val');
        var typehead_text = typehead_text_format.replace("'", "’");
        var lookup_id = $(thisElement).parents(".twitter-typeahead").find(".tt-input").attr("data-lookup-id");
        var lookup_code = $(thisElement).parents(".twitter-typeahead").find(".tt-input").attr("data-lookup-code");
        $.ajax({
            url: "{{ route('prescription-lookup-data.store-prescription-lookup-item') }}",
            type: 'POST',
            data: {
                typehead_text: typehead_text,
                lookup_id: lookup_id,
                lookup_code: lookup_code
            },
            dataType: 'json',
            success: function(result) {
                //return processAsync(result);
            }
        });

        var lookup_data = "<li><input type='hidden' name='item_dtl_val[]' value=''><input type='hidden' name='item_id[]' value='' readonly='readonly'><input class='left-element' type='hidden' name='item_name[]' value='" + typehead_text + "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" + lookup_id + "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" + lookup_code + "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='' readonly='readonly'><input type='hidden' name='session_duration[]' value=''><input type='hidden' name='session_mu[]'><input type='hidden' name='no_of_session[]'><input type='hidden' name='unit_intensity_mu[]'><input type='hidden' name='unit_intensity[]'><input type='hidden' name='frequency[]'><input type='hidden' name='mode[]'><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><i class='fa fa-angle-double-right'></i> " + typehead_text + "&nbsp;&nbsp;<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;</li>";

        $(thisElement).parents(".twitter-typeahead").siblings().find("ul").append(lookup_data);
        $("#" + typehead_id).typeahead('val', '');
    }
    function addPermanetItemLab(thisElement, typehead_element){
        var typehead_id = $(thisElement).parents(".twitter-typeahead").find(".tt-input").attr("id");
        var typehead_text = $("#" + typehead_id).typeahead('val');
        var lookup_id = $(thisElement).parents(".twitter-typeahead").find(".tt-input").attr("data-lookup-id");
        var lookup_code = $(thisElement).parents(".twitter-typeahead").find(".tt-input").attr("data-lookup-code");
        $.ajax({
            url: "{{ route('prescription-free-text') }}",
            type: 'POST',
            data: {
                typehead_text: typehead_text,
                lookup_id: lookup_id,
                lookup_code: lookup_code
            },
            dataType: 'json',
            success: function(result) {
                //return processAsync(result);
            }
        });

        var lookup_data = "<li><input type='hidden' name='item_dtl_val[]' value=''><input type='hidden' name='item_id[]' value='' readonly='readonly'><input class='left-element' type='hidden' name='item_name[]' value='" + typehead_text + "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" + lookup_id + "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" + lookup_code + "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='' readonly='readonly'><input type='hidden' name='session_duration[]' value=''><input type='hidden' name='session_mu[]'><input type='hidden' name='no_of_session[]'><input type='hidden' name='unit_intensity_mu[]'><input type='hidden' name='unit_intensity[]'><input type='hidden' name='frequency[]'><input type='hidden' name='mode[]'><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><i class='fa fa-angle-double-right'></i> " + typehead_text + "&nbsp;&nbsp;<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;</li>";

        $(thisElement).parents(".twitter-typeahead").siblings().find("ul").append(lookup_data);
        $("#" + typehead_id).typeahead('val', '');
    }

    function openInvoiceAutocomplete(element_id) {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('invoice-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'invoice_code',
            templates: {

                suggestion: function(item) {
                    $("#hdn_invoice_id").val('');

                    if (item.gender == 'Male') {
                        var img_path = "{{ asset('images/boy.jpg') }}";
                    } else {
                        var img_path = "{{ asset('images/girl.jpg') }}";
                    }
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-2 float-right mrv-2" width="48"><strong>Voucher No: ' +
                        item.invoice_code +
                        '</strong></div><div style="display:block"><strong>Patient Code: ' + item
                        .patient_code + '</strong></div><div>Patient Name: ' + item.patient_name +
                        '</div><div><small>G: ' + item.gender + '</small>, <small>Age: ' + item.age +
                        '</small>, <small>Ph: ' + item.mobile + '</small></div></div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            $("#hdn_invoice_id").val(item.invoice_id);
            var invoice_info = "<strong>Voucher No: " + item.invoice_code + " </strong>";
            $("#invoice_info").html(invoice_info);
            obj.stopImmediatePropagation();
        });
    }
    function openInvoiceAutocompleteOp(element_id) {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('invoice-info-autocomplete-op') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'invoice_code',
            templates: {

                suggestion: function(item) {
                    $("#hdn_invoice_id").val('');

                    if (item.gender == 'Male') {
                        var img_path = "{{ asset('images/boy.jpg') }}";
                    } else {
                        var img_path = "{{ asset('images/girl.jpg') }}";
                    }
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-2 float-right mrv-2" width="48"><strong>Voucher No: ' +
                        item.invoice_code +
                        '</strong></div><div style="display:block"><strong>Patient Code: ' + item
                        .patient_code + '</strong></div><div>Patient Name: ' + item.patient_name +
                        '</div><div><small>G: ' + item.gender + '</small>, <small>Age: ' + item.age +
                        '</small>, <small>Ph: ' + item.mobile + '</small></div></div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            $("#hdn_invoice_id").val(item.invoice_id);
            var invoice_info = "<strong>Voucher No: " + item.invoice_code + " </strong>";
            $("#invoice_info").html(invoice_info);
            obj.stopImmediatePropagation();
        });
    }

    function openPosInvoiceAutocomplete(element_id) {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('pos-invoice-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'invoice_code',
            templates: {

                suggestion: function(item) {
                    $("#hdn_invoice_id").val('');
                    $("#admission_no").val('');

                    if (item.gender == 'Male') {
                        var img_path = "{{ asset('images/boy.jpg') }}";
                    } else {
                        var img_path = "{{ asset('images/girl.jpg') }}";
                    }
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-2 float-right mrv-2" width="48"><strong>Voucher No: ' +
                        item.invoice_code +
                        '</strong></div><div style="display:block"><strong>Patient Code: ' + item
                        .patient_code + '</strong></div><div>Patient Name: ' + item.patient_name +
                        '</div><div><small>G: ' + item.gender + '</small>, <small>Age: ' + item.age +
                        '</small>, <small>Ph: ' + item.mobile + '</small></div></div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            $("#hdn_invoice_id").val(item.invoice_id);
            $("#admission_no").val(item.admission_no_pk);
            var invoice_info = "<strong>Voucher No: " + item.invoice_code + " </strong>";
            $("#invoice_info").html(invoice_info);
            obj.stopImmediatePropagation();
        });
    }
    function openCafeInvoiceAutocomplete(element_id) {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('cafe-invoice-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'invoice_code',
            templates: {

                suggestion: function(item) {
                    $("#hdn_invoice_id").val('');

                    if (item.gender == 'Male') {
                        var img_path = "{{ asset('images/boy.jpg') }}";
                    } else {
                        var img_path = "{{ asset('images/girl.jpg') }}";
                    }
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-2 float-right mrv-2" width="48"><strong>Voucher No: ' +
                        item.invoice_code +
                        '</strong></div><div style="display:block"><strong>Patient Code: ' + item
                        .patient_code + '</strong></div><div>Patient Name: ' + item.patient_name +
                        '</div><div><small>G: ' + item.gender + '</small>, <small>Age: ' + item.age +
                        '</small>, <small>Ph: ' + item.mobile + '</small></div></div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            $("#hdn_invoice_id").val(item.invoice_id);
            var invoice_info = "<strong>Voucher No: " + item.invoice_code + " </strong>";
            $("#invoice_info").html(invoice_info);
            obj.stopImmediatePropagation();
        });
    }

    function openAppointmentAutocomplete(element_id) {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('appoint-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'appoint_code',
            templates: {

                suggestion: function(item) {
                    $("#hdn_appoint_id").val('');
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>Appoint Code: ' + item.appoint_code +
                        '</strong></div></div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            $("#hdn_appoint_id").val(item.appoint_id);
            var appoint_info = "<strong>Appoint Code: " + item.appoint_code + " </strong>";
            $("#appoint_info").html(appoint_info);
            obj.stopImmediatePropagation();
        });
    }


    function openDoctorDegreeAutocomplete(element_id) {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('doctor-degree') }}",
                    type: 'POST',
                    data: {
                        query: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'doctor_degree',
            templates: {

                suggestion: function(item) {
                    $("#hdn_degree_id").val('');
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>Degree: ' + item.doctor_degree +
                        '</strong></div></div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            $("#hdn_degree_id").val(item.doctor_degree);
            var degree_info = "<strong>Degree: " + item.doctor_degree + " </strong>";
            $("#degree_info").html(degree_info);
            obj.stopImmediatePropagation();
        });
    }

    function openItemAutocomplete(element_id, item_type = "", item_id_element = "", item_name_element = "", lookup_id =
        "", lookupData_code = "") {
         console.log(element_id );
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('get-item-name') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {
                suggestion: function(item) {
                console.log(item)
                    var generic_name  = item.generic_name!= null ? "( "+ item.generic_name+")" :'';
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_code + '</strong> - ' + item
                        .item_name +' '+ generic_name +'  </div></div>';
                },

                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ` in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" data-element_id="${element_id}" data-item_id_element="${item_id_element}" onclick="prescriptionFunc.addNotFoundMedItem(event,this)"> + Add for this Prescription only</div></div>`
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (item_id_element == "") {
                $(element_id).parent("span").siblings('input').val(item.item_id);
            } else {
                $(element_id).parent("span").siblings(item_id_element).val(item.item_id);
                // $(element_id).parent("span").siblings(item_name_element).val(item.item_name);
                // $(element_id).parent("span").siblings('#hdn_lookupdata_code_1').val(lookupData_code);
                // $(element_id).parent("span").siblings('#hdn_lookup_id_1').val(lookup_id);
                console.log(item.item_id + 'test')
            }
            obj.stopImmediatePropagation();
        });
    }

    function openItemAutocompleteDischarge(element_id, item_type = "", item_id_element = "", item_name_element = "", lookup_id =
        "", lookupData_code = "") {
         console.log(element_id );
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('get-item-name') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {
                suggestion: function(item) {
                console.log(item)
                    var generic_name  = item.generic_name!= null ? "( "+ item.generic_name+")" :'';
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_code + '</strong> - ' + item
                        .item_name +' '+ generic_name +'  </div></div>';
                },

                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ` in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" data-element_id="${element_id}" data-item_id_element="${item_id_element}" onclick="prescriptionFunc.addNotFoundMedItemDischare(event,this)"> + Add for this Prescription only</div></div>`
                        );
                    }
                }
            }

        })
    }


    function openItemAutocompleteACUP(element_id, item_type = "", item_id_element = "", item_name_element = "",
        lookup_id = "", lookupData_code = "") {
        // console.log(element_id );
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 20,
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('get-item-name') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {

                suggestion: function(item) {
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_code + '</strong> - ' + item
                        .item_name + '</div></div>';
                },

                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ` in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" data-element_id="${element_id}" data-item_id_element="${item_id_element}" onclick="prescriptionFunc.addNotFoundAcupItem(event,this)"> + Add for this Prescription only</div></div>`
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (item_id_element == "") {
                element_id.parent("span").siblings('input').val(item.item_id);
            } else {
                element_id.parent("span").siblings(item_id_element).val(item.item_id);
                element_id.parent("span").siblings(item_name_element).val(item.item_name);
                element_id.parent("span").siblings('#hdn_lookupdata_code_1').val(lookupData_code);
                element_id.parent("span").siblings('#hdn_lookup_id_1').val(lookup_id);
                console.log(lookup_id, lookupData_code)
            }
            obj.stopImmediatePropagation();
        });
    }


    function openItemAutocompletePTET(element_id, item_type = "", item_id_element = "", item_name_element = "",
        lookup_id = "", lookupData_code = "") {
        // console.log(element_id );
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 20,
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('get-item-name') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {

                suggestion: function(item) {
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_code + '</strong> - ' + item
                        .item_name + '</div></div>';
                },

                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ` in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" data-element_id="${element_id}" data-item_id_element="${item_id_element}" onclick="prescriptionFunc.addNotFoundPhyElecItem(event,this)"> + Add for this Prescription only</div></div>`
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (item_id_element == "") {
                element_id.parent("span").siblings('input').val(item.item_id);
            } else {
                element_id.parent("span").siblings(item_id_element).val(item.item_id);
                element_id.parent("span").siblings(item_name_element).val(item.item_name);
                element_id.parent("span").siblings('#et_hdn_lookupdata_code_1').val(lookupData_code);
                element_id.parent("span").siblings('#et_hdn_lookup_id_1').val(lookup_id);
                console.log(lookup_id, lookupData_code)
            }
            obj.stopImmediatePropagation();
        });
    }

    function openItemAutocompletePTTE(element_id, item_type = "", item_id_element = "", item_name_element = "",
        lookup_id = "", lookupData_code = "") {
        // console.log(element_id );
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 20,
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('get-item-name') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {

                suggestion: function(item) {
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_code + '</strong> - ' + item
                        .item_name + '</div></div>';
                },

                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ` in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" data-element_id="${element_id}" data-item_id_element="${item_id_element}" onclick="prescriptionFunc.addNotFoundPhyTheraputItem(event,this)"> + Add for this Prescription only</div></div>`
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (item_id_element == "") {
                element_id.parent("span").siblings('input').val(item.item_id);
            } else {
                element_id.parent("span").siblings(item_id_element).val(item.item_id);
                element_id.parent("span").siblings(item_name_element).val(item.item_name);
                element_id.parent("span").siblings('#te_hdn_lookupdata_code_1').val(lookupData_code);
                element_id.parent("span").siblings('#te_hdn_lookup_id_1').val(lookup_id);
                console.log(lookup_id, lookupData_code)
            }
            obj.stopImmediatePropagation();
        });
    }

    function openBillingItemAutocomplete(element_id, item_type = "", item_type_void = "", onclickCallback = "",
        su_no_id = "", corporate_id = "", patient_type = "" , admission_id="",patient_id="") {
            console.log(patient_type+'_____patient_type')
          var su_no_ids ='';
        $(element_id).each(function() {
            var input_type = $(this).attr("id");
            $(this).typeahead({
                hint: true,
                highlight: true,
                minLength: 2
            }, {
                limit: 'Infinity',
                async: true,
                source: function(query, processSync, processAsync) {
                    su_no_ids =$('#service_unit :selected').val();
                    return $.ajax({
                        url: "{{ route('get-item-name') }}",
                        type: 'POST',
                        data: {
                            query: query,
                            item_type: item_type,
                            item_type_void: item_type_void,
                            su_no_id: su_no_ids,
                            corporate_id: corporate_id,
                            patient_type: patient_type,
                            admission_id: admission_id,
                            patient_id: patient_id,
                        },
                        dataType: 'json',
                        success: function(result) {
                            return processAsync(result);
                        }
                    });
                },
                display: 'item_name',
                templates: {
                    suggestion: function(item) {
                        if (input_type == "item_code") {
                            return '<div id="user-selection" class="clearfix border-bottom">' +
                                '<div style="display:block"><strong>' + item.item_code +
                                '</strong> - ' + item.item_name +' ( '+item.item_rate+' TK ) '+ '</div></div>';
                        } else {
                            return '<div id="user-selection" class="clearfix border-bottom">' +
                                '<div style="display:block">' + item.item_name + ' - <strong>' +
                                item.item_code +' ( '+item.item_rate+' TK ) '+ '</strong>' + '</div></div>';
                        }
                    },
                    empty: function(context) {

                        if ($(element_id).typeahead('val') != "") {
                            var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                                "label").text();
                            $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                                '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                            );
                        }
                    }
                }

            }).bind("typeahead:selected", function(obj, item, name) {

                if (onclickCallback != '') {
                    onclickCallback(item, obj)
                }

                obj.stopImmediatePropagation();
            });
        });
    }
    function openBillingItemAutocompleteV1(element_id, item_type = "", item_type_void = "", onclickCallback = "",
        su_no_id = "", corporate_id = "", patient_type = "" , admission_id="") {
            console.log(admission_id+"_admi");
        $(element_id).each(function() {
            var input_type = $(this).attr("id");
            var su_no_id = $("#service_unit").val();
            // let corporate_id=$('#corporate_no_hdn').val();
            // console.log(corporate_id + 'pat_name');
            $(this).typeahead({
                hint: true,
                highlight: true,
                minLength: 2
            }, {
                limit: 'Infinity',
                async: true,
                source: function(query, processSync, processAsync) {
                    // corporate_id=641;
                     patient_type=$('#patient_type option:selected').attr('data-type_code');
                     patient_id=$('#hdn_patient_id').val();
                    
                    console.log(corporate_id + 'pat_name');
                    return $.ajax({
                        url: "{{ route('get-item-name-v1') }}",
                        type: 'POST',
                        data: {
                            query: query,
                            item_type: item_type,
                            item_type_void: item_type_void,
                            su_no_id: su_no_id,
                            corporate_id: corporate_id,
                            patient_type: patient_type,
                            admission_id: admission_id,
                            patient_id: patient_id,
                        },
                        dataType: 'json',
                        success: function(result) {
                            return processAsync(result);
                        }
                    });
                },
                display: 'item_name',
                templates: {
                    suggestion: function(item) {
                        if (input_type == "item_code") {
                            return '<div id="user-selection" class="clearfix border-bottom">' +
                                '<div style="display:block"><strong>' + item.item_code +
                                '</strong> - ' + item.item_name +' ( '+item.item_rate+' TK ) '+ '</div></div>';
                        } else {
                            return '<div id="user-selection" class="clearfix border-bottom">' +
                                '<div style="display:block">' + item.item_name + ' - <strong>' +
                                item.item_code +' ( '+item.item_rate+' TK ) '+ '</strong>' + '</div></div>';
                        }
                    },
                    empty: function(context) {

                        if ($(element_id).typeahead('val') != "") {
                            var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                                "label").text();
                            $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                                '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                            );
                        }
                    }
                }

            }).bind("typeahead:selected", function(obj, item, name) {
                console.log('ITEM_', item);
                if (onclickCallback != '') {
                    onclickCallback(item, obj)
                }

                obj.stopImmediatePropagation();
            });
        });
    }

    function openItemAutocompleteWithList(element_id, item_type = "", append_to = "", lookup_id, lookup_code) {
        console.log("test");
        $(element_id).typeahead({
            hint: false,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('get-item-name') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {

                suggestion: function(item) {
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_code + '</strong> - ' + item
                        .item_name + '</div></div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ' in this Prescription. Click the below button to add. </div> <div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="prescriptionFunc.addNotFoundInvItem(event,this)"> + Add for this Prescription only</div></div>'
                            // ' in this Prescription. Click the below button to add. </div> <div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="addPermanetItemLab(this)"> + Add for this Permanently</div>&nbsp; <div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="prescriptionFunc.addNotFoundInvItem(event,this)"> + Add for this Prescription only</div></div>'

                            );
                        $('.tt-menu').css({
                            'padding': '15px'
                        });
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            var action_url = "{{ route('add-pres-favourit-list') }}";
            var parent_element = "li";
            var lookup_data = "<li id='item-" + item.item_id +
                "'><input type='hidden' class='oreder_item_no' name='item_id[]' value='" + item.item_id +
                "' readonly='readonly'><input type='hidden' class='oreder_item_name' name='item_name[]' value='" + item.item_name +
                "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
                lookup_id + "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
                lookup_code + "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
                item.itemtype_code +
                "' readonly='readonly'><input type='hidden' class='' id='' name='unit_intensity[]'><input type='hidden' class='' id='' name='session_duration[]'>  <input type='hidden' class='' id='' name='no_of_session[]'> <input type='hidden' class='' id='' name='session_mu[]'> <input type='hidden' class='' id='' name='frequency[]'> <input type='hidden' class='' id='' name='mode[]'><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><i class='fa fa-angle-double-right'></i> " +
                item
                .item_name +
                "&nbsp;&nbsp;<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;<span class='float-right text-secondary mr-1 cursor-pointer' style='font-size:11px;' title='Add To Bookmark' onclick='prescriptionFunc.addToPresFavouritList(this)' data-url='" +
                action_url + "' data-id='" + item.item_id + "' data-name='" + item.item_name + "' data-type='" +
                lookup_code + "'><i class='fa fa-star'></i></span></li>";
            $(append_to).append(lookup_data);
            $(element_id).typeahead('val', '');
            obj.stopImmediatePropagation();
        });
    }
    function openItemAutocompleteWithListImpala(element_id, item_type = "", append_to = "", lookup_id, lookup_code) {
console.log("testtt");
    $(element_id).typeahead({
        hint: true,
        highlight: true,
        minLength: 3
    }, {
        limit: 20,
        async: true,
        source: function(query, processSync, processAsync) {
            return $.ajax({
                url: "{{ route('lookup-pres-data-autocomplete') }}",
                // url: "{{ route('get-item-name') }}",
                type: 'POST',
                data: {
                    query: query,
                    item_type: item_type,
                    _token: $('meta[name="csrf-token"]').attr('content')
                },
                dataType: 'json',
                success: function(result) {
                    return processAsync(result);
                }
            });
        },
        display: 'item_name',
        templates: {

            suggestion: function(item) {
                return '<div id="user-selection" class="clearfix border-bottom">' +
                    '<div style="display:block"><strong>' + item.item_code + '</strong> - ' + item
                    .item_name + '</div></div>';
            },
            empty: function(context) {
                if ($(element_id).typeahead('val') != "") {
                    var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                        .text();
                    $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                        '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                        ' not found.</span><div class="border-top pt-2">You can use this as ' +
                        search_label +
                        ' in this Prescription. Click the below button to add. </div> <div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="prescriptionFunc.addNotFoundInvItem(event,this)"> + Add for this Prescription only</div></div>'
                        // ' in this Prescription. Click the below button to add. </div> <div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="addPermanetItemLab(this)"> + Add for this Permanently</div>&nbsp; <div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="prescriptionFunc.addNotFoundInvItem(event,this)"> + Add for this Prescription only</div></div>'

                        );
                    $('.tt-menu').css({
                        'padding': '15px'
                    });
                }
            }
        }

    }).bind("typeahead:selected", function(obj, item, name) {
        var action_url = "{{ route('add-pres-favourit-list') }}";
        var parent_element = "li";
        var lookup_data = "<li id='item-" + item.item_id +
            "'><input type='hidden' name='item_id[]' value='" + item.item_id +
            "' readonly='readonly'><input type='hidden' name='item_name[]' value='" + item.item_name +
            "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" +
            lookup_id + "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" +
            lookup_code + "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" +
            item.itemtype_code +
            "' readonly='readonly'><input type='hidden' class='' id='' name='unit_intensity[]'><input type='hidden' class='' id='' name='session_duration[]'>  <input type='hidden' class='' id='' name='no_of_session[]'> <input type='hidden' class='' id='' name='session_mu[]'> <input type='hidden' class='' id='' name='frequency[]'> <input type='hidden' class='' id='' name='mode[]'><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><i class='fa fa-angle-double-right'></i> " +
            item
            .item_name +
            "&nbsp;&nbsp;<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;<span class='float-right text-secondary mr-1 cursor-pointer' style='font-size:11px;' title='Add To Bookmark' onclick='prescriptionFunc.addToPresFavouritList(this)' data-url='" +
            action_url + "' data-id='" + item.item_id + "' data-name='" + item.item_name + "' data-type='" +
            lookup_code + "'><i class='fa fa-star'></i></span></li>";
        $(append_to).append(lookup_data);
        $(element_id).typeahead('val', '');
        obj.stopImmediatePropagation();
    });
}


    function openItemAutocompleteWithStock(element_id, item_type = "", item_id_element = "", item_name_element = "",
        onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('get-item-with-stock') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {
                suggestion: function(item) {
                    console.log(item)
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var current_stock = item.current_stock != null ? item.current_stock : '';
                    var purchase_price = item.purchase_price != null ? parseFloat(item.purchase_price) : 0;
                    var item_rate = item.item_rate != null ? item.item_rate : 0;
                    var vat_percent = item.vat_percent != null ? parseFloat(item.vat_percent) : 0;
                    var vat_amt = (purchase_price * vat_percent) / 100;
                    var vat_rate = (purchase_price + vat_amt).toFixed(2);
                    var status_badge = lp_txt = "";
                    var supplier_name = item.supplier_name !=null ? item.supplier_name :'';
                    console.log(vat_amt , purchase_price)
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_id + '</strong> - ' + item
                        .item_name + ' ( '+item.generic_name +' ) '+'</div><div style="display:block"><span><strong>Stock : </strong>' +
                        current_stock + '</span> </div><div><strong>Purchase Price : ' + vat_rate +
                        '</strong></div><div><strong>Sales Price : ' + item_rate + '</strong></div><div><strong>Supplier Name : ' + supplier_name + '</strong></div></div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ` in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" data-element_id="${element_id}" data-item_id_element="${item_id_element}" onclick="prescriptionFunc.addNotFoundMedItem(event,this)"> + Add for this Prescription only</div></div>`
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            if (item_id_element == "") {
                element_id.parent("span").siblings('input').val(item.item_id);
            } else {
                console.log(item)
                console.log(item_id_element + item.current_stock);
                $(this).parent("span").siblings(item_id_element).val(item.item_id);
                $(this).parent("span").siblings(item_id_element).attr('name','hdn_item_id_'+item.item_id);
                $(this).parent("span").parent("span").parent("td").parent("tr").find('#stock_qty').html(item.current_stock);
              var checkData=  $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val();
              var qty=  $(this).parent("span").parent("span").parent("td").parent("tr").children('td').children('input').attr('name','issue_quantity_'+item.item_id).val();
              console.log(qty)
              if (checkData !="") {
                var checkDataSplit=checkData.split('_');
                var reArange=checkDataSplit[0]+'_'+item.item_id+'_'+checkDataSplit[2]+'_'+checkDataSplit[3]+'_'+qty;
                  $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').attr('name','indent_approval[]').val(reArange);
                console.log(checkDataSplit)
              }

              $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').prop("disabled", false);

                console.log($(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val()+'__________bellal')
                if (item_name_element !='') {
                    $(element_id).parent("span").siblings(item_name_element).val(item.item_name);
                }
            }

            obj.stopImmediatePropagation();
        });
    }
    function openItemAutocompleteWithStockV2(element_id, item_type = "", item_id_element = "", item_name_element = "",
        onclickCallback = '',su_no='',sub_store='',patient_no='') {
            console.log(sub_store +'___sub_store');


        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
               var admission_id = $('#hdn_admission_id').val() ? $('#hdn_admission_id').val() :'';
                patient_no = patient_no !='' ? patient_no : $('#hdn_patient_id').val();
                return $.ajax({
                    url: "{{ route('get-item-with-stock-v2') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        sub_store: sub_store,
                        patient_no: patient_no,
                        admission_id: admission_id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {
                suggestion: function(item) {
                    console.log(item)
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var current_stock = item.current_stock != null ? item.current_stock : '';
                    var purchase_price = item.purchase_price != null ? parseFloat(item.purchase_price) : 0;
                    var item_rate = item.item_rate != null ? item.item_rate : 0;
                    var vat_percent = item.vat_percent != null ? parseFloat(item.vat_percent) : 0;
                    var vat_amt = (purchase_price * vat_percent) / 100;
                    var vat_rate = (purchase_price + vat_amt).toFixed(2);
                    var status_badge = lp_txt = "";
                    var supplier_name = item.supplier_name !=null ? item.supplier_name :'';
                    console.log(vat_amt , purchase_price)
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_id + '</strong> - ' + item
                        .item_name + ' ( '+item.generic_name +' ) '+'</div><div style="display:block"><span><strong>Stock : </strong>' +
                        current_stock + '</span> </div><div><strong>Purchase Price : ' + vat_rate +
                        '</strong></div><div><strong>Sales Price : ' + item_rate + '</strong></div><div><strong>Supplier Name : ' + supplier_name + '</strong></div></div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ` in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" data-element_id="${element_id}" data-item_id_element="${item_id_element}" onclick="prescriptionFunc.addNotFoundMedItem(event,this)"> + Add for this Prescription only</div></div>`
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            if (item_id_element == "") {
                element_id.parent("span").siblings('input').val(item.item_id);
            } else {
                console.log(item)
                console.log(item_id_element + item.current_stock);
                $(this).parent("span").siblings(item_id_element).val(item.item_id);
                $(this).parent("span").siblings(item_id_element).attr('name','hdn_item_id_'+item.item_id);
                $(this).parent("span").parent("span").parent("td").parent("tr").find('#stock_qty').html(item.current_stock);
              var checkData=  $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val();
              var qty=  $(this).parent("span").parent("span").parent("td").parent("tr").children('td').children('input').attr('name','issue_quantity_'+item.item_id).val();
              console.log(qty)
              if (checkData !="") {
                var checkDataSplit=checkData.split('_');
                var reArange=checkDataSplit[0]+'_'+item.item_id+'_'+checkDataSplit[2]+'_'+checkDataSplit[3]+'_'+qty;
                  $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').attr('name','indent_approval[]').val(reArange);
                console.log(checkDataSplit)
              }

              $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').prop("disabled", false);

                console.log($(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val()+'__________bellal')
                if (item_name_element !='') {
                    $(element_id).parent("span").siblings(item_name_element).val(item.item_name);
                }
            }

            obj.stopImmediatePropagation();
        });
    }
    function openCafeItemAutocompleteWithStock(element_id, item_type = "", item_id_element = "", item_name_element = "",
        onclickCallback = '', service_unit) {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                let empId=$('#emp_id').val()??'';
                return $.ajax({
                    url: "{{ route('get-cafe-item-with-stock') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        service_unit:  $('#service_point').val(),
                        empId:  empId,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {

                suggestion: function(item) {
                    console.log(item)
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var current_stock = item.current_stock != null ? item.current_stock : '';
                    var purchase_price = item.purchase_price != null ? parseFloat(item.purchase_price) : 0;
                    var item_rate = item.item_rate != null ? item.item_rate : 0;
                    var vat_percent = item.vat_percent != null ? parseFloat(item.vat_percent) : 0;
                    var vat_amt = (purchase_price * vat_percent) / 100;
                    var vat_rate = (purchase_price + vat_amt).toFixed(2);
                    var status_badge = lp_txt = "";
                    var supplier_name = item.supplier_name !=null ? item.supplier_name :'';
                    console.log(vat_amt , purchase_price)
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_id + '</strong> - ' + item
                        .item_name + '</div><div style="display:block"><span><strong>Stock : </strong>' +
                        current_stock + '</span> </div><div><strong>Sales Price : ' + item_rate + '</strong></div></div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ` in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" data-element_id="${element_id}" data-item_id_element="${item_id_element}" onclick="prescriptionFunc.addNotFoundMedItem(event,this)"> + Add for this Prescription only</div></div>`
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)


            }

            if (item_id_element == "") {
                // element_id.parent("span").siblings('input').val(item.item_id);
            } else {
                console.log(item)
                console.log(item_id_element + item.current_stock);
                $(this).parent("span").siblings(item_id_element).val(item.item_id);
                $(this).parent("span").siblings(item_id_element).attr('name','hdn_item_id_'+item.item_id);
                $(this).parent("span").parent("span").parent("td").parent("tr").find('#stock_qty').html(item.current_stock);
              var checkData=  $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val();
              var qty=  $(this).parent("span").parent("span").parent("td").parent("tr").children('td').children('input').attr('name','issue_quantity_'+item.item_id).val();
              console.log(qty)
              if (checkData !="") {
                var checkDataSplit=checkData.split('_');
                var reArange=checkDataSplit[0]+'_'+item.item_id+'_'+checkDataSplit[2]+'_'+checkDataSplit[3]+'_'+qty;
                  $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').attr('name','indent_approval[]').val(reArange);
                console.log(checkDataSplit)
              }

              $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').prop("disabled", false);

                console.log($(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val()+'__________bellal')
                if (item_name_element !='') {
                    $(element_id).parent("span").siblings(item_name_element).val(item.item_name);
                }
            }
            // if (item_id_element == "") {
            //     element_id.parent("span").siblings('input').val(item.item_id);
            // } else {
            //     element_id.parent("span").siblings(item_id_element).val(item.item_id);
            //     element_id.parent("span").siblings(item_name_element).val(item.item_name);
            //     element_id.parent("span").siblings('#hdn_lookupdata_code_1').val(lookupData_code);
            //     element_id.parent("span").siblings('#hdn_lookup_id_1').val(lookup_id);
            //     console.log(lookup_id, lookupData_code)
            // }
            obj.stopImmediatePropagation();
        });
    }
    function openItemAutocompleteWithStockImpala(element_id, item_type = "", item_id_element = "", item_name_element = "",
        onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('get-item-with-stock') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {

                suggestion: function(item) {
                console.log(item)
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var current_stock = item.current_stock != null ? item.current_stock : '';
                    var purchase_price = item.purchase_price != null ? parseFloat(item.purchase_price) : 0;
                    var item_rate = item.item_rate != null ? item.item_rate : 0;
                    var vat_percent = item.vat_percent != null ? parseFloat(item.vat_percent) : 0;
                    var vat_amt = (purchase_price * vat_percent) / 100;
                    var vat_rate = (purchase_price + vat_amt).toFixed(2);
                    var status_badge = lp_txt = "";
                    var supplier_name = item.supplier_name !=null ? item.supplier_name :'';
                    // console.log(item.supplier_name)
                    // console.log(vat_amt+'_'+vat_rate);
                    // if (item.stock_status_text != '') {
                    //     if (item.stock_status_text == "Sufficient") {
                    //         status_badge = "badge badge-success";
                    //     } else if (item.stock_status_text == "Low Stock") {
                    //         status_badge = "badge badge-info";
                    //     } else if (item.stock_status_text == "0 Stock") {
                    //         status_badge = "badge badge-danger";
                    //         lp_txt = " - LP";
                    //     } else {
                    //         status_badge = "badge badge-danger";
                    //     }
                    // }
                    // <span class="badge ' + status_badge + '">' +stock_status_text  + ' ' + lp_txt + '</span>
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_id + '</strong> - ' + item
                        .item_name + '</div><div style="display:block"><span><strong>Stock : </strong>' +
                        current_stock + '</span> </div><div><strong>Purchase Price : ' + vat_rate +
                        '</strong></div><div><strong>Sales Price : ' + item_rate + '</strong></div><div><strong>Supplier Name : ' + supplier_name + '</strong></div></div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ` in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" data-element_id="${element_id}" data-item_id_element="${item_id_element}" onclick="prescriptionFunc.addNotFoundMedItem(event,this)"> + Add for this Prescription only</div></div>`
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)


            }

            if (item_id_element == "") {
                element_id.parent("span").siblings('input').val(item.item_id);
            } else {
                console.log(item_id_element + item.current_stock);
                $(this).parent("span").siblings(item_id_element).val(item.item_id);
                $(this).parent("span").parent("span").parent("td").parent("tr").find('#stock_qty').html(item.current_stock);
                console.log($(this).parent("span").parent("span").parent("td").parent("tr").find('#stock_qty').html())
                if (item_name_element !='') {
                    $(element_id).parent("span").siblings(item_name_element).val(item.item_name);
                }
            }
            // if (item_id_element == "") {
            //     element_id.parent("span").siblings('input').val(item.item_id);
            // } else {
            //     element_id.parent("span").siblings(item_id_element).val(item.item_id);
            //     element_id.parent("span").siblings(item_name_element).val(item.item_name);
            //     element_id.parent("span").siblings('#hdn_lookupdata_code_1').val(lookupData_code);
            //     element_id.parent("span").siblings('#hdn_lookup_id_1').val(lookup_id);
            //     console.log(lookup_id, lookupData_code)
            // }
            obj.stopImmediatePropagation();
        });
    }


    function openItemAutocompleteWithStockSubStoreWise(element_id, item_type = "", item_id_element = "", item_name_element = "", onclickCallback = '',su_no='',sub_store='') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
           
                return $.ajax({
                    url: "{{ route('get-item-with-stock-sub-store-wise') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        sub_store:sub_store,// $("#service_point").val(),
                        patient_id: $("#hdn_patient_id").val(),
                        admission_id: $("#hdn_admission_id").val(),
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {
                suggestion: function(item) {
                    console.log(item)
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var current_stock = item.current_stock != null ? item.current_stock : '';
                    var purchase_price = item.purchase_price != null ? parseFloat(item.purchase_price) : 0;
                    var item_rate = item.item_rate != null ? item.item_rate : 0;
                    var vat_percent = item.vat_percent != null ? parseFloat(item.vat_percent) : 0;
                    var vat_amt = (purchase_price * vat_percent) / 100;
                    var vat_rate = (purchase_price + vat_amt).toFixed(2);
                    var status_badge = lp_txt = "";
                    var supplier_name = item.supplier_name !=null ? item.supplier_name :'';
                    console.log(vat_amt , purchase_price)
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_id + '</strong> - ' + item
                        .item_name + ' ( '+item.generic_name +' ) '+'</div><div style="display:block"><span><strong>Stock : </strong>' +
                        current_stock + '</span> </div><div><strong>Purchase Price : ' + vat_rate +
                        '</strong></div><div><strong>Sales Price : ' + item_rate + '</strong></div><div><strong>Supplier Name : ' + supplier_name + '</strong></div></div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ` in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" data-element_id="${element_id}" data-item_id_element="${item_id_element}" onclick="prescriptionFunc.addNotFoundMedItem(event,this)"> + Add for this Prescription only</div></div>`
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            if (item_id_element == "") {
                element_id.parent("span").siblings('input').val(item.item_id);
            } else {
                console.log(item)
                console.log(item_id_element + item.current_stock);
                $(this).parent("span").siblings(item_id_element).val(item.item_id);
                $(this).parent("span").siblings(item_id_element).attr('name','hdn_item_id_'+item.item_id);
                $(this).parent("span").parent("span").parent("td").parent("tr").find('#stock_qty').html(item.current_stock);
              var checkData=  $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val();
              var qty=  $(this).parent("span").parent("span").parent("td").parent("tr").children('td').children('input').attr('name','issue_quantity_'+item.item_id).val();
              console.log(qty)
              if (checkData !="") {
                var checkDataSplit=checkData.split('_');
                var reArange=checkDataSplit[0]+'_'+item.item_id+'_'+checkDataSplit[2]+'_'+checkDataSplit[3]+'_'+qty;
                  $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').attr('name','indent_approval[]').val(reArange);
                console.log(checkDataSplit)
              }

              $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').prop("disabled", false);

                console.log($(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val()+'__________bellal')
                if (item_name_element !='') {
                    $(element_id).parent("span").siblings(item_name_element).val(item.item_name);
                }
            }

            obj.stopImmediatePropagation();
        });
    }


    var teeth_autocomplete = {
        "init": function() {
            $(".teeth_find").typeahead({
                hint: true,
                highlight: true,
                minLength: 3
            }, {
                limit: 'Infinity',
                async: true,
                source: function(query, processSync, processAsync) {
                    return $.ajax({
                        url: "{{ route('lookup-pres-data-autocomplete') }}",
                        type: 'POST',
                        data: {
                            search_data: query,
                            lookup_code: 'TEETHFIND'
                        },
                        dataType: 'json',
                        success: function(result) {
                            return processAsync(result);
                        }
                    });
                },
                display: 'pres_lookupdata_name',
                templates: {

                    suggestion: function(item) {
                        return '<div id="user-selection" class="clearfix border-bottom">' +
                            '<div style="display:block">' + item.pres_lookupdata_name +
                            '</div></div>';
                    },
                    empty: function(context) {
                        if ($(this).typeahead('val') != "") {
                            var search_label = $(this).parents(".twitter-typeahead").siblings(
                                "label").text();
                            $(this).siblings(".tt-menu").find(".tt-dataset").html(
                                '<div id="empty-tt"><span class="text-danger">Searched ' +
                                search_label +
                                ' not found.</span><div class="border-top pt-2">You can use this as ' +
                                search_label +
                                ' in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="prescriptionFunc.addNotFoundItem(this)"> + Add for this Prescription only</div></div>'
                            );
                        }
                    }
                }

            }).bind("typeahead:selected", function(obj, item, name) {
                var hdn_add_pres_favourit_url = $("#hdn_add_pres_favourit_url").val();
                var favourit_btn =
                    "<span class='text-secondary mr-1 cursor-pointer' style='font-size:11px;'' title='Add To Favourite List' onclick='prescriptionFunc.addToPresFavouritList(this)' data-url='" +
                    hdn_add_pres_favourit_url + "' data-id='" + item.pres_lookupdata_id +
                    "' data-name='" + item.pres_lookupdata_name +
                    "' data-type='TEETHFIND'><i class='fa fa-star text-primary'></i></span>";
                $(this).parents(".selected-teeth-item").find("#item_id").val(item.pres_lookupdata_id);
                $(this).parents(".selected-teeth-item").find("#item_name").val(item
                    .pres_lookupdata_name);
                $(this).parents(".selected-teeth-item").find("#lookup_id").val(item.pres_lookup_no_pk);
                $(this).parents(".selected-teeth-item").find(".fav_btn").html(favourit_btn);
            });
        },
        "destroy": function() {
            $('.teeth_find').typeahead('destroy');
        }
    }

    function openPatientAutocomplete(element_id, display = 'patient_name', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('patient-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    $("#hdn_patient_id").val('');
                    if (item.patient_photo != null) {
                        var img_path = "{{ asset('images/uploads/patient_images/thumb/') }}/" + item
                            .patient_photo;
                    } else {
                        if (item.gender == 'Male') {
                            var img_path = "{{ asset('images/boy.jpg') }}";
                        } else {
                            var img_path = "{{ asset('images/girl.jpg') }}";
                        }
                    }
                    var age = (item.age != null) ? item.pat_age : '';
                    // var age = (item.age != null) ? item.age : '';
                    var mobile = (item.phone_mobile != null) ? item.phone_mobile : '';
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-2 float-left mrv-2" width="60" ><strong>' +
                        item.patient_code + '</strong><div>' + item.patient_name + ' (' + item
                        .patient_type_code + ')' + '</div><div><small>G: ' +
                        item.gender + '</small>, <small>Age: ' + age + '</small>, <small>Ph: ' + mobile +
                        '</small></div></div>' +
                        '</div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span></div>');
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }

            $("#hdn_patient_id").val(item.patient_id);
            obj.stopImmediatePropagation();
        });
    }
    function openPatientAutocompleteByPhoneNo(element_id, display = 'patient_name', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('patient-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    // $("#hdn_patient_id").val('');
                    if (item.patient_photo != null) {
                        var img_path = "{{ asset('images/uploads/patient_images/thumb/') }}/" + item
                            .patient_photo;
                    } else {
                        if (item.gender == 'Male') {
                            var img_path = "{{ asset('images/boy.jpg') }}";
                        } else {
                            var img_path = "{{ asset('images/girl.jpg') }}";
                        }
                    }
                    var age = (item.age != null) ? item.pat_age : '';
                    // var age = (item.age != null) ? item.age : '';
                    var mobile = (item.phone_mobile != null) ? item.phone_mobile : '';
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-2 float-left mrv-2" width="60" ><strong>' +
                        item.patient_code + '</strong><div>' + item.patient_name + ' (' + item
                        .patient_type_code + ')' + '</div><div><small>G: ' +
                        item.gender + '</small>, <small>Age: ' + age + '</small>, <small>Ph: ' + mobile +
                        '</small></div></div>' +
                        '</div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span></div>');
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }

            // $("#hdn_patient_id").val(item.patient_id);
            obj.stopImmediatePropagation();
        });
    }
    function openPatientAutocompleteByPhoneNoV2(element_id, display = 'phone_mobile', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('patient-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    // $("#hdn_patient_id").val('');
                    if (item.patient_photo != null) {
                        var img_path = "{{ asset('images/uploads/patient_images/thumb/') }}/" + item
                            .patient_photo;
                    } else {
                        if (item.gender == 'Male') {
                            var img_path = "{{ asset('images/boy.jpg') }}";
                        } else {
                            var img_path = "{{ asset('images/girl.jpg') }}";
                        }
                    }
                    var age = (item.age != null) ? item.pat_age : '';
                    // var age = (item.age != null) ? item.age : '';
                    var mobile = (item.phone_mobile != null) ? item.phone_mobile : '';
                    return '<div class="tt-suggestion not-clickable clearfix border-bottom">' +
            '<div style="display:block"><img src="' + img_path +
            '" alt="doctor image" class="rounded border mr-2 float-left mrv-2" width="60" ><strong>' +
            item.patient_code + '</strong><div>' + item.patient_name + ' (' + item
            .patient_type_code + ')' + '</div><div><small>G: ' +
            item.gender + '</small>, <small>Age: ' + age + '</small>, <small>Ph: ' + mobile +
            '</small></div></div>' +
            '</div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span></div>');
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            $("#mobile_no").val(mobile)

            obj.stopImmediatePropagation();
        });
    }
    function openDonorAutocomplete(element_id, hidden_id, display = 'donor_name', onclickCallback = '') {

        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 1,

        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                console.log(query.length+'____query')
                if (query.length<=3) {
                    $("#" + hidden_id).val('');
                }
                return $.ajax({
                    url: "{{ route('donor-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    var mobile = (item.donor_mobile != null) ? item.donor_mobile : '';
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<strong>' +item.donor_no_pk + '</strong><div>' + item.donor_name + '</div><div><small>G: ' +
                        item.donor_gender + '</small>, <small>Ph: ' + mobile +
                        '</small></div></div>' +
                        '</div>';
                    // return '<div id="user-selection" class="clearfix border-bottom">' +
                    //     '<strong>' +item.donor_uid + '</strong><div>' + item.donor_name + '</div><div><small>G: ' +
                    //     item.donor_gender + '</small>, <small>Ph: ' + mobile +
                    //     '</small></div></div>' +
                    //     '</div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span></div>');
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            $("#" + hidden_id).val(item.donor_no_pk);
            obj.stopImmediatePropagation();
        });
        
        
        
        // .bind("typeahead:selected", function(obj, item, name) {

        //     if (onclickCallback != '') {
        //         onclickCallback(item, obj)
        //     }

        //     $("#hidden_donor_id").val(item.donor_no_pk);
        //     obj.stopImmediatePropagation();
        // });
    }

    function openDoctorAutocomplete(element_id, hidden_id, personnel_ind_name = '', personnel_ind = '',
        onclickCallback = '', designation_code='') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {                
                
                return $.ajax({
                    url: "{{ route('doctor-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        personnel_ind_name: personnel_ind_name,
                        personnel_ind: personnel_ind,
                        designation_code: designation_code
                    },
                    dataType: 'json',

                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'full_name',
            templates: {

                suggestion: function(item) {
                    //alert($(element_id).val())
                    if ($(element_id).val() == '') {
                        $("#" + hidden_id).val('');
                    }
                    var img_path = "{{ asset('images/doctor.png') }}";
                    var spec = item.specialization != null ? item.specialization + "," : "";
                    var ghender = item.gender_txt != null ? item.gender_txt + "," : "";
                    var phone = item.phone_mobile != null ? item.phone_mobile : "";
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-1 float-left mrv-2" width="35" ><strong>' +
                        item.person_code + ' : </strong>' + item.full_name + '<div><i>' + spec +
                        '</i> <small>G: ' + ghender + '</small> <small>Ph: ' + phone +
                        '</small></div></div></div>' +
                        '</div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            $("#" + hidden_id).val(item.doctor_id);
            obj.stopImmediatePropagation();
        });
        $(element_id).on('input', function() {
            if ($(this).val().trim() === '') {
                $("#" + hidden_id).val('');
            }
        });
    }
    function openDoctorAutocompleteAll(element_id, hidden_id, personnel_ind_name = '', personnel_ind = '',
        onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('doctor-info-autocomplete-all') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        personnel_ind_name: personnel_ind_name,
                        personnel_ind: personnel_ind
                    },
                    dataType: 'json',

                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'full_name',
            templates: {

                suggestion: function(item) {
                    //alert($(element_id).val())
                    if ($(element_id).val() == '') {
                        $("#" + hidden_id).val('');
                    }
                    var img_path = "{{ asset('images/doctor.png') }}";
                    var spec = item.specialization != null ? item.specialization + "," : "";
                    var ghender = item.gender_txt != null ? item.gender_txt + "," : "";
                    var phone = item.phone_mobile != null ? item.phone_mobile : "";
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-1 float-left mrv-2" width="35" ><strong>' +
                        item.person_code + ' : </strong>' + item.full_name + '<div><i>' + spec +
                        '</i> <small>G: ' + ghender + '</small> <small>Ph: ' + phone +
                        '</small></div></div></div>' +
                        '</div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            $("#" + hidden_id).val(item.doctor_id);
            obj.stopImmediatePropagation();
        });
    }
    function openDoctorAutocompletev3(element_id, hidden_id, personnel_ind_name = '', personnel_ind = '',
        onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('doctor-info-autocomplete-v3') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        personnel_ind_name: personnel_ind_name,
                        personnel_ind: personnel_ind
                    },
                    dataType: 'json',

                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'full_name',
            templates: {

                suggestion: function(item) {
                    //alert($(element_id).val())
                    if ($(element_id).val() == '') {
                        $("#" + hidden_id).val('');
                    }
                    var img_path = "{{ asset('images/doctor.png') }}";
                    var spec = item.specialization != null ? item.specialization + "," : "";
                    var ghender = item.gender_txt != null ? item.gender_txt + "," : "";
                    var phone = item.phone_mobile != null ? item.phone_mobile : "";
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-1 float-left mrv-2" width="35" ><strong>' +
                        item.person_code + ' : </strong>' + item.full_name + '<div><i>' + spec +
                        '</i> <small>G: ' + ghender + '</small> <small>Ph: ' + phone +
                        '</small></div></div></div>' +
                        '</div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            $("#" + hidden_id).val(item.doctor_id);
            obj.stopImmediatePropagation();
        });
    }
    function openDoctorAutocompleteV1(element_id, hidden_id, personnel_ind_name = '', personnel_ind = '',
        onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('doctor-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        personnel_ind_name: personnel_ind_name,
                        personnel_ind: personnel_ind
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'full_name',
            templates: {

                suggestion: function(item) {
                    $(this).parent("span").siblings(hidden_id).val('');
                    // $(element_id).parents(".twitter-typeahead").siblings(hidden_id).val('');
                    // $(element_id).parents('span').parents('td').parents('tr').find("." + hidden_id).val('');
                    var img_path = "{{ asset('images/doctor.png') }}";
                    var spec = item.specialization != null ? item.specialization + "," : "";
                    var ghender = item.gender_txt != null ? item.gender_txt + "," : "";
                    var phone = item.phone_mobile != null ? item.phone_mobile : "";
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-1 float-left mrv-2" width="35" ><strong>' +
                        item.person_code + ' : </strong>' + item.full_name + '<div><i>' + spec +
                        '</i> <small>G: ' + ghender + '</small> <small>Ph: ' + phone +
                        '</small></div></div></div>' +
                        '</div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            // $(element_id).parents("sapn").siblings(hidden_id).val(item.doctor_id);
            // console.log(  $(element_id).parents(".twitter-typeahead").siblings(hidden_id).val());

            if (hidden_id == "") {
                // element_id.parent("span").siblings('input').val(item.item_id);
            } else {
                console.log(hidden_id +'****item_id');
                $(this).parent("span").siblings(hidden_id).val(item.doctor_id);
                if (element_id !='') {
                    $(element_id).parent("span").siblings(element_id).val(item.full_name);
                }
            }


            obj.stopImmediatePropagation();
        });
    }
    function openDoctorAutocompleteV2(element_id, hidden_id, personnel_ind_name = '', personnel_ind = '',
        onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('doctor-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        personnel_ind_name: personnel_ind_name,
                        personnel_ind: personnel_ind
                    },
                    dataType: 'json',

                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'full_name',
            templates: {

                suggestion: function(item) {

                    $(this).parents("span").siblings(hidden_id).val('');
                    // $(element_id).parents('span').parents('td').parents('tr').find("." + hidden_id).val('');
                    var img_path = "{{ asset('images/doctor.png') }}";
                    var spec = item.specialization != null ? item.specialization + "," : "";
                    var ghender = item.gender_txt != null ? item.gender_txt + "," : "";
                    var phone = item.phone_mobile != null ? item.phone_mobile : "";
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-1 float-left mrv-2" width="35" ><strong>' +
                        item.person_code + ' : </strong>' + item.full_name + '<div><i>' + spec +
                        '</i> <small>G: ' + ghender + '</small> <small>Ph: ' + phone +
                        '</small></div></div></div>' +
                        '</div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            $(this).parents("span").siblings(hidden_id).val(item.doctor_id);
            console.log(  $(this).parents("span").siblings(hidden_id).val());
            obj.stopImmediatePropagation();
        });
    }

    function openPolicyAutocomplete(element_id, hidden_id) {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('policy-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'policy_desc',
            templates: {
                suggestion: function(item) {
                    $("#" + hidden_id).val('');
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.policy_code + '</strong> - ' + item
                        .policy_desc + '</div></div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            $("#" + hidden_id).val(item.policy_id);
            $("#hdn_policy_code").val(item.policy_code);

            if (item.policy_id != "") {
                $.ajax({
                    async: true,
                    type: 'post',
                    url: "{{ route('policy.get-policy-details') }}",
                    data: {
                        policy_id: item.policy_id
                    },
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(data) {
                        $('#policy-details').html(data);

                    },
                    complete: function(data) {
                        $.unblockUI();
                    }
                });
            }
            obj.stopImmediatePropagation();
        });
    }

    /**
     * param element_id
     */
    function openLookupAutocomplete(element_id, action, lookup_type, lookup_code, append_to = "") {
        console.log(lookup_code)
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('lookup-pres-data-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        lookup_code: lookup_code,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'pres_lookupdata_name',
            templates: {

                suggestion: function(item) {
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block">' + item.pres_lookupdata_name + '</div></div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ' in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="prescriptionFunc.addNotFoundItem(this)"> + Add for this Prescription only</div></div>'
                        );
                        // $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                        //     '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                        //     ' not found.</span><div class="border-top pt-2">You can use this as ' +
                        //     search_label +
                        //     ' in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="addPermanetItem(this)"> + Add for this Permanently</div>&nbsp;<div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="prescriptionFunc.addNotFoundItem(this)"> + Add for this Prescription only</div></div>'
                        // );
                        $('.tt-menu').css({
                            'padding': '15px'
                        });
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (append_to != "") {
                if(lookup_code != 'INSTRUCTION'){
                // for instruction
                var action_url = "{{ route('add-pres-favourit-list') }}";
                var parent_element = "li";
                var lookup_data = "<li id='item-" + item.pres_lookupdata_id +
                    "'><input type='hidden' class='left-element' name='item_id[]' value='" + item
                    .pres_lookupdata_id +
                    "' readonly='readonly'><input type='text' class='' style='width: 90%;' name='item_name[]' value='" + item
                    .pres_lookupdata_name +
                    "' ><input type='hidden' name='lookup_id[]' value='" + item
                    .pres_lookup_no_pk +
                    "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" + item
                    .pres_lookup_code +
                    "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" + item
                    .pres_lookupdata_code +
                    "' readonly='readonly'><input type='hidden' class='' id='' name='unit_intensity[]'><input type='hidden' class='' id='' name='session_duration[]'>  <input type='hidden' class='' id='' name='no_of_session[]'> <input type='hidden' class='' id='' name='session_mu[]'> <input type='hidden' class='' id='' name='frequency[]'> <input type='hidden' class='' id='' name='mode[]'><input type='hidden' name='item_dtl_val[]' value=''><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;<span class='float-right text-secondary mr-1 cursor-pointer' style='font-size:11px;' title='Add To Bookmark' onclick='prescriptionFunc.addToPresFavouritList(this)' data-url='" +
                    action_url + "' data-id='" + item.pres_lookupdata_id + "' data-name='" + item
                    .pres_lookupdata_name + "' data-type='" + item.pres_lookup_code + "' data-lookup-id='" +
                    item.pres_lookup_no_pk + "'><i class='fa fa-star'></i></span></li>";

                $(element_id).typeahead('val', '');
                $(append_to).append(lookup_data);

                // end
                }else{

                    console.log($('#element_id').parents('td'))
                    // for instruction
                var action_url = "{{ route('add-pres-favourit-list') }}";
                var parent_element = "li";
                var lookup_data = "<li id='item-" + item.pres_lookupdata_id +
                    "'><input type='hidden' class='left-element' name='item_id[]' value='" + item
                    .pres_lookupdata_id +
                    "' readonly='readonly'><input type='hidden' name='item_name[]' value='" + item
                    .pres_lookupdata_name +
                    "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" + item
                    .pres_lookup_no_pk +
                    "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" + item
                    .pres_lookup_code +
                    "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" + item
                    .pres_lookupdata_code +
                    "' readonly='readonly'><input type='hidden' class='' id='' name='unit_intensity[]'><input type='hidden' class='' id='' name='session_duration[]'>  <input type='hidden' class='' id='' name='no_of_session[]'> <input type='hidden' class='' id='' name='session_mu[]'> <input type='hidden' class='' id='' name='frequency[]'> <input type='hidden' class='' id='' name='mode[]'><input type='hidden' name='item_dtl_val[]' value=''><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><i class='fa fa-angle-double-right'></i> " +
                    item.pres_lookupdata_name +
                    "&nbsp;";

                $(element_id).typeahead('val', '');
                $(append_to).append(lookup_data);

                // end
                    $('#instruction_0').hide()
                }

            } else {
                $(element_id).parents("td").find("#hdn_item_id").val(item.pres_lookupdata_id);
                $(element_id).parents("td").find("#hdn_item_name").val(item.pres_lookupdata_name);
                $(element_id).parents("td").find("#hdn_lookup_id").val(item.pres_lookup_no_pk);
                $(element_id).parents("td").find("#hdn_lookup_code").val(item.pres_lookup_code);
                $(element_id).parents("td").find("#hdn_lookupdata_code").val(item.pres_lookupdata_code);
                $("#hdn_disease_id").val(item.pres_lookupdata_id);
                $("#hdn_disease_name").val(item.pres_lookupdata_name);
            }
            obj.stopImmediatePropagation();
        });

    }

    function openLookupAutocompleteV2(element_id, action, lookup_type, lookup_code, append_to = "") {
        console.log(lookup_code)
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('lookup-pres-data-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        lookup_code: lookup_code,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'pres_lookupdata_name',
            templates: {

                suggestion: function(item) {
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block">' + item.pres_lookupdata_name + '</div></div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ' in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="prescriptionFunc.addNotFoundItemV2(this)"> + Add for this Prescription only</div></div>'
                        );
                        // $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                        //     '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                        //     ' not found.</span><div class="border-top pt-2">You can use this as ' +
                        //     search_label +
                        //     ' in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="addPermanetItem(this)"> + Add for this Permanently</div>&nbsp;<div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="prescriptionFunc.addNotFoundItem(this)"> + Add for this Prescription only</div></div>'
                        // );
                        $('.tt-menu').css({
                            'padding': '15px'
                        });
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (append_to != "") {
                if(lookup_code != 'INSTRUCTION'){
                // for instruction
                var action_url = "{{ route('add-pres-favourit-list') }}";
                var parent_element = "li";
                var lookup_data = "<li id='item-" + item.pres_lookupdata_id +
                    "'><input type='hidden' class='left-element' name='item_id[]' value='" + item
                    .pres_lookupdata_id +
                    "' readonly='readonly'><input type='text' class='' style='width: 90%;' name='item_name[]' value='" + item
                    .pres_lookupdata_name +
                    "' ><input type='hidden' name='lookup_id[]' value='" + item
                    .pres_lookup_no_pk +
                    "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" + item
                    .pres_lookup_code +
                    "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" + item
                    .pres_lookupdata_code +
                    "' readonly='readonly'><input type='hidden' class='' id='' name='unit_intensity[]'><input type='hidden' class='' id='' name='session_duration[]'>  <input type='hidden' class='' id='' name='no_of_session[]'> <input type='hidden' class='' id='' name='session_mu[]'> <input type='hidden' class='' id='' name='frequency[]'> <input type='hidden' class='' id='' name='mode[]'><input type='hidden' name='item_dtl_val[]' value=''><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;<span class='float-right text-secondary mr-1 cursor-pointer' style='font-size:11px;' title='Add To Bookmark' onclick='prescriptionFunc.addToPresFavouritList(this)' data-url='" +
                    action_url + "' data-id='" + item.pres_lookupdata_id + "' data-name='" + item
                    .pres_lookupdata_name + "' data-type='" + item.pres_lookup_code + "' data-lookup-id='" +
                    item.pres_lookup_no_pk + "'><i class='fa fa-star'></i></span></li>";

                $(element_id).typeahead('val', '');
                $(append_to).append(lookup_data);

                // end
                }else{

                    console.log($('#element_id').parents('td'))
                    // for instruction
                var action_url = "{{ route('add-pres-favourit-list') }}";
                var parent_element = "li";
                var lookup_data = "<li id='item-" + item.pres_lookupdata_id +
                    "'><input type='hidden' class='left-element' name='item_id[]' value='" + item
                    .pres_lookupdata_id +
                    "' readonly='readonly'><input type='hidden' name='item_name[]' value='" + item
                    .pres_lookupdata_name +
                    "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" + item
                    .pres_lookup_no_pk +
                    "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" + item
                    .pres_lookup_code +
                    "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" + item
                    .pres_lookupdata_code +
                    "' readonly='readonly'><input type='hidden' class='' id='' name='unit_intensity[]'><input type='hidden' class='' id='' name='session_duration[]'>  <input type='hidden' class='' id='' name='no_of_session[]'> <input type='hidden' class='' id='' name='session_mu[]'> <input type='hidden' class='' id='' name='frequency[]'> <input type='hidden' class='' id='' name='mode[]'><input type='hidden' name='item_dtl_val[]' value=''><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><i class='fa fa-angle-double-right'></i> " +
                    item.pres_lookupdata_name +
                    "&nbsp;";

                $(element_id).typeahead('val', '');
                $(append_to).append(lookup_data);

                // end
                    $('#instruction_0').hide()
                }

            } else {
                $(element_id).parents("td").find("#hdn_item_id").val(item.pres_lookupdata_id);
                $(element_id).parents("td").find("#hdn_item_name").val(item.pres_lookupdata_name);
                $(element_id).parents("td").find("#hdn_lookup_id").val(item.pres_lookup_no_pk);
                $(element_id).parents("td").find("#hdn_lookup_code").val(item.pres_lookup_code);
                $(element_id).parents("td").find("#hdn_lookupdata_code").val(item.pres_lookupdata_code);
                $("#hdn_disease_id").val(item.pres_lookupdata_id);
                $("#hdn_disease_name").val(item.pres_lookupdata_name);
            }
            obj.stopImmediatePropagation();
        });

    }


    function openItemAutocompleteGeneric(element_id, hdn_id,onclickCallback = '') {
        //element_id, action, lookup_type, lookup_code, append_to = ""
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('generic-item-data-autocomplete') }}",
                    type: 'POST',
                    beforeSend: function() {
                        $(hdn_id).val('');
                    },
                    data: {
                        search_data: query,

                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'generic_name',
            templates: {

                suggestion: function(item) {

                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block">' + item.generic_name + '</div></div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ' in this generic name. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="addNotFoundGenericItem(this)"> + Add Generic Name</div></div>'
                        );
                        $('.tt-menu').css({
                            'padding': '15px'
                        });
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {


            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            $(element_id).typeahead('val', item.generic_name);
            $(hdn_id).val(item.generic_no_pk);
            $($('#generic_name')).val(item.generic_name);

            obj.stopImmediatePropagation();
        });

    }

    function openAccountsAutocomplete(element_id, hdn_id) {
        // element_id, action, lookup_type, lookup_code, append_to = ""
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ url('accounts-intregration/search/item') }}",
                    type: 'get',
                    data: {
                        crAccount: query,

                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'generic_name',
            templates: {

                suggestion: function(item) {
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block">' + item.account_name + '</div></div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ' in this generic name. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="addNotFoundGenericItem(this)"> + Add Generic Name</div></div>'
                        );
                        $('.tt-menu').css({
                            'padding': '15px'
                        });
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            $(element_id).typeahead('val', item.account_name);
            $(hdn_id).val(item.account_no_pk);

            obj.stopImmediatePropagation();
        });

    }

    /**
     * param element_id
     */


    function openPrescriptionAutocomplete(element_id) {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('presc-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'prescription_code',
            templates: {
                suggestion: function(item) {

                    $("#hdn_presc_id").val('');
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block">' + item.prescription_code + '</div></div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            $("#hdn_presc_id").val(item.prescription_code);
            obj.stopImmediatePropagation();
        });
    }



    function openAdmissionAutocomplete(element_id, display = 'patient_name', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            // minLength: 4
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('admission-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    $("#hdn_admission_id").val('');
                    if (item.patient_photo != null) {
                        var img_path = "{{ asset('img/uploads/patient_images/thumb/') }}/" + item
                            .patient_photo;
                    } else {
                        if (item.gender == 'Male') {
                            var img_path = "{{ asset('images/boy.jpg') }}";
                        } else {
                            var img_path = "{{ asset('images/girl.jpg') }}";
                        }
                    }
                    var age = (item.age != null) ? item.age : '';
                    var mobile = (item.phone_mobile != null) ? item.phone_mobile : '';
                    var date = new Date(item.admission_date);
                    date = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date
                            .getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) +
                        '/' + date.getFullYear()

                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-2 float-right mrv-2" width="48" ><div><strong>Admission ID: ' +
                        item.admission_no_pk + '</strong></div> <div><strong>Admission Date: ' + date +
                        '</strong>  </div> <div> <strong>' + item.patient_code +
                        '</strong>  </div>   <div>Patient Name: ' + item.patient_name + '(' + item
                        .patient_type_code + ')' +
                        '</div><div><small>G: ' + item.gender + '</small>, <small>Age: ' + age +
                        '</small>, <small>Ph: ' + mobile + '</small></div> <div><small>Ward Name: ' + item
                        .bed_name + '</small>, <small>Bed Name: ' + item.ward_name +
                        '</small></div></div>' +
                        '</div>';

                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span></div>');
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }

            $("#hdn_admission_id").val(item.admission_no_pk);
            $("#hdn_patient_id").val(item.patient_id);
            obj.stopImmediatePropagation();
        });
    }

    function openPrescriptionAutocomplete(element_id, display = 'patient_name', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 7
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('prescription-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    console.log(item);
                    $("#hdn_prescription_id").val('');
                    if (item.patient_photo != null) {
                        var img_path = "{{ asset('img/uploads/patient_images/thumb/') }}/" + item
                            .patient_photo;
                    } else {
                        if (item.gender == 'Male') {
                            var img_path = "{{ asset('images/boy.jpg') }}";
                        } else {
                            var img_path = "{{ asset('images/girl.jpg') }}";
                        }
                    }
                    var age = (item.age != null) ? item.age : '';
                    var mobile = (item.phone_mobile != null) ? item.phone_mobile : "";
                    var date = new Date(item.prescription_date);
                    // console.log(mobile + '_ ' + 'bbb');
                    date = ((date.getDate() > 9) ? date.getDate() : ('0' + date.getDate())) + '/' + ((date
                            .getMonth() > 8) ? (date.getMonth() + 1) : ('0' + (date.getMonth() + 1))) +
                        '/' + date.getFullYear()

                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-2 float-right mrv-2" width="48" ><div><strong>Prescription ID: ' +
                        item.prescription_uid + '</strong></div> <div><strong>Prescription Date: ' + date +
                        '</strong>  </div> <div> <strong>' + item.patient_code +
                        '</strong>  </div>   <div>Patient Name: ' + item.patient_name + '(' + item
                        .patient_type_code + ')' +
                        '</div><div><small>G: ' + item.gender + '</small>, <small>Age: ' + age +
                        '</small>, <small>Ph: ' + mobile + '</small></div> </div>' +
                        '</div>';

                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span></div>');
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }

            $("#hdn_prescription_id").val(item.prescription_no_pk);
            // $("#hdn_patient_id").val(item.patient_id);
            obj.stopImmediatePropagation();
        });
    }


    function openReceiveItemAutocomplete(element_id, itemtype = "",display = 'item_name', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('item-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        item_type: itemtype,
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    //console.log(item)
                    var current_stock = item.current_stock != null ? item.current_stock : 0;
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var status_badge = lp_txt = "";
                    if (item.stock_status_text != '') {
                        if (item.stock_status_text == "Sufficient") {
                            status_badge = "badge badge-success";
                        } else if (item.stock_status_text == "Low Stock") {
                            status_badge = "badge badge-info";
                        } else if (item.stock_status_text == "0 Stock") {
                            status_badge = "badge badge-danger";
                            lp_txt = " - LP";
                        } else {
                            status_badge = "badge badge-danger";
                        }
                    }
                    if (item.supplier_name == null) {
                        var supplier = "N/A";
                    } else {
                        var supplier = item.supplier_name;
                    }


                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name +' ( '+ item.generic_name+' ) '+'</strong> - <strong>' +
                        item.item_code + '</strong><div><small>UOM: ' + item.uom_name +
                        '</small>, <small>Item Code: ' + item.item_code +
                        '</small></div><div style="display:block"><span>' + '</span> </div><div><strong>Purchase Price : ' + item
                        .purchase_price + '</strong></div><div><strong>Sales Price : ' + item.item_rate +
                        '</strong></div><div><strong>Supplier Name : ' + supplier +
                        '</strong></div></div>' +
                        '</div>';
                        // <strong>Stock : </strong>' +
                        // current_stock
                },
                empty: function(context) {

                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                            "label").text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                        );
                    }
                }
            }
        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }

    function inventory_autocomplete_iteminfo_by_item_name(element_id, display = 'item_name', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('inventory-item-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    //console.log(item)
                    var current_stock = item.current_stock != null ? item.current_stock : 0;
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var status_badge = lp_txt = "";
                    if (item.stock_status_text != '') {
                        if (item.stock_status_text == "Sufficient") {
                            status_badge = "badge badge-success";
                        } else if (item.stock_status_text == "Low Stock") {
                            status_badge = "badge badge-info";
                        } else if (item.stock_status_text == "0 Stock") {
                            status_badge = "badge badge-danger";
                            lp_txt = " - LP";
                        } else {
                            status_badge = "badge badge-danger";
                        }
                    }
                    if (item.supplier_name == null) {
                        var supplier = "N/A";
                    } else {
                        var supplier = item.supplier_name;
                    }


                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name + '</strong> - <strong>' +
                        item.item_code + '</strong><div><small>UOM: ' + item.uom_name +
                        '</small>, <small>Item Code: ' + item.item_code +
                        '</small></div><div style="display:block"><span><strong>Stock : </strong>' +
                        current_stock + '</span> </div><div><strong>Purchase Price : ' + item
                        .purchase_price + '</strong></div><div><strong>Sales Price : ' + item.item_rate +
                        '</strong></div><div><strong>Supplier Name : ' + supplier +
                        '</strong></div></div>' +
                        '</div>';
                },
                empty: function(context) {

                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                            "label").text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                        );
                    }
                }
            }
        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }
    function inventory_autocomplete_iteminfo_by_item_code(element_id, display = 'item_code', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('inventory-item-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {

                    var current_stock = item.current_stock != null ? item.current_stock : 0;
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var status_badge = lp_txt = "";
                    if (item.stock_status_text != '') {
                        if (item.stock_status_text == "Sufficient") {
                            status_badge = "badge badge-success";
                        } else if (item.stock_status_text == "Low Stock") {
                            status_badge = "badge badge-info";
                        } else if (item.stock_status_text == "0 Stock") {
                            status_badge = "badge badge-danger";
                            lp_txt = " - LP";
                        } else {
                            status_badge = "badge badge-danger";
                        }
                    }
                    if (item.supplier_name == null) {
                        var supplier = "N/A";
                    } else {
                        var supplier = item.supplier_name;
                    }


                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name + '</strong> - <strong>' +
                        item.item_code + '</strong><div><small>UOM: ' + item.uom_name +
                        '</small>, <small>Item Code: ' + item.item_code +
                        '</small></div><div style="display:block"><span><strong>Stock : </strong>' +
                        current_stock + '</span> </div><div><strong>Purchase Price : ' + item
                        .purchase_price + '</strong></div><div><strong>Sales Price : ' + item.item_rate +
                        '</strong></div><div><strong>Supplier Name : ' + supplier +
                        '</strong></div></div>' +
                        '</div>';
                },
                empty: function(context) {

                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                            "label").text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }
    function pharmacy_autocomplete_iteminfo_by_item_name(element_id, display = 'item_name', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('pharmacy-item-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    //console.log(item)
                    var current_stock = item.current_stock != null ? item.current_stock : 0;
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var status_badge = lp_txt = "";
                    if (item.stock_status_text != '') {
                        if (item.stock_status_text == "Sufficient") {
                            status_badge = "badge badge-success";
                        } else if (item.stock_status_text == "Low Stock") {
                            status_badge = "badge badge-info";
                        } else if (item.stock_status_text == "0 Stock") {
                            status_badge = "badge badge-danger";
                            lp_txt = " - LP";
                        } else {
                            status_badge = "badge badge-danger";
                        }
                    }
                    if (item.supplier_name == null) {
                        var supplier = "N/A";
                    } else {
                        var supplier = item.supplier_name;
                    }


                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name+ '</strong> - <strong>' +
                        item.item_code +' ( '+ item.generic_name +' ) '+ '</strong><div><small>UOM: ' + item.uom_name +
                        '</small>, <small>Item Code: ' + item.item_code +
                        '</small></div><div style="display:block"><span>'+ '</span> </div><div><strong>Purchase Price : ' + item
                        .purchase_price + '</strong></div><div><strong>Sales Price : ' + item.item_rate +
                        '</strong></div><div><strong>Supplier Name : ' + supplier +
                        '</strong></div><div><strong>Stock Information : </strong>'+item.item_store_stock+'</div></div>' +
                        '</div>';
                        // <strong>Stock : </strong>' +
                        // current_stock
                },
                empty: function(context) {

                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                            "label").text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                        );
                    }
                }
            }
        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }
    function pharmacy_autocomplete_iteminfo_by_item_code(element_id, display = 'item_code', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('pharmacy-item-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {

                    var current_stock = item.current_stock != null ? item.current_stock : 0;
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var status_badge = lp_txt = "";
                    if (item.stock_status_text != '') {
                        if (item.stock_status_text == "Sufficient") {
                            status_badge = "badge badge-success";
                        } else if (item.stock_status_text == "Low Stock") {
                            status_badge = "badge badge-info";
                        } else if (item.stock_status_text == "0 Stock") {
                            status_badge = "badge badge-danger";
                            lp_txt = " - LP";
                        } else {
                            status_badge = "badge badge-danger";
                        }
                    }
                    if (item.supplier_name == null) {
                        var supplier = "N/A";
                    } else {
                        var supplier = item.supplier_name;
                    }


                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name + '</strong> - <strong>' +
                        item.item_code + '</strong><div><small>UOM: ' + item.uom_name +
                        '</small>, <small>Item Code: ' + item.item_code +
                        '</small></div><div style="display:block"><span><strong>Stock : </strong>' +
                        current_stock + '</span> </div><div><strong>Purchase Price : ' + item
                        .purchase_price + '</strong></div><div><strong>Sales Price : ' + item.item_rate +
                        '</strong></div><div><strong>Supplier Name : ' + supplier +
                        '</strong></div></div>' +
                        '</div>';
                },
                empty: function(context) {

                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                            "label").text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }


    function openReceiveItemCodeAutocomplete(element_id, display = 'item_code', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('item-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {

                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_code + '</strong> - <strong>' +
                        item.item_name + '</strong><div><small>UOM: ' + item.uom_name +
                        '</small>, <small>Item Code: ' + item.item_code + '</small></div></div>' +
                        '</div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }

    // Referral Policy Autocomplete

    function referalPolicyAutocomplete(element_id, display = 'referal_policy', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({

                    url: "{{ route('referral.referal-policy-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {

                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {

                    //console.log(item);

                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.policy_name +
                        '</strong><div><small>REFERRALPOLICY_CODE: ' + item.referralpolicy_code +
                        '</small></div></div>' +
                        '</div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }

            // $('#referal_policy_hidden').val(item.referralpolicy_code);
            // $('#referal_policy').val(item.referralpolicy_code);
            obj.stopImmediatePropagation();
        });
    }

    // Referral discount Autocomplete

    // function referaldisCountAutocomplete(element_id, display = 'discount_policy', onclickCallback = '') {
    // 	$(element_id).typeahead({
    // 		hint: true,
    // 		highlight: true,
    // 		minLength: 1
    // 	}, {
    // 		limit: 'Infinity',
    // 		async: true,
    // 		source: function(query, processSync, processAsync) {
    // 			return $.ajax({

    // 				url: "{{ route('referral.discount-policy-autocomplete') }}",
    // 				type: 'POST',
    // 				data: {
    // 					search_data: query
    // 				},
    // 				dataType: 'json',
    // 				success: function(result) {

    // 					return processAsync(result);
    // 				}
    // 			});
    // 		},
    // 		display: display,
    // 		templates: {


    // 			suggestion: function(item) {

    // 				return '<div id="user-selection" class="clearfix border-bottom">' +
    // 				'<div style="display:block"><strong>' + item.item_code + '</strong> - <strong>' + item.item_name + '</strong><div><small>UOM: ' + item.uom_name + '</small>, <small>Item Code: ' + item.item_code + '</small></div></div>' +
    // 				'</div>';
    // 			}
    // 		}

    // 	}).bind("typeahead:selected", function(obj, item, name) {

    // 		if (onclickCallback != '') {
    // 			onclickCallback(item, obj)
    // 		}
    // 		obj.stopImmediatePropagation();
    // 	});
    // }
    //                 //console.log(item);

    //                 return '<div id="user-selection" class="clearfix border-bottom">' +
    //                 '<div style="display:block"><strong>' + item.discount_name+ '</strong><div><small>REFERRALPOLICY_CODE: ' + item.dispolicy_code + '</small></div></div>' +
    //                 '</div>';
    //             }
    //         }

    //     }).bind("typeahead:selected", function(obj, item, name) {

    //     	if (onclickCallback != '') {
    //     		onclickCallback(item, obj)
    //     	}
    //     	obj.stopImmediatePropagation();
    //     });
    // }

    // Referral Policy Autocomplete

    function openCashierAutocomplete(element_id, display = 'Cashier_name', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({

                    url: "{{ route('cashier-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {

                        return processAsync(result);
                    }
                });
            },
            display: 'full_name',
            templates: {

                suggestion: function(item) {

                    //console.log(item);

                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.full_name +
                        '</strong><div><small>Cashier Code: ' + item.person_id + '</small></div></div>' +
                        '</div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }

            $('#card_no').val(item.full_name);
            console.log(item.full_name);
            $('#card_hidn').val(item.person_id);
            obj.stopImmediatePropagation();
        });
    }

    // Added By Nazmul
    function openPtaItemAutocomplete(element_id, display = 'item_name', item_type = "", onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('pta.item-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        item_type: item_type
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_code + '</strong> - ' + item
                        .item_name + '</div></div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }

    // Added By nazmul 30.6.2021
    function openPatientAndBillingAutocomplete(element_id, display = 'voucher_id', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('patient-and-billing-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    $("#hdn_patient_id").val('');
                    if (item.patient_photo != null) {
                        var img_path = "{{ asset('img/uploads/patient_images/thumb/') }}/" + item
                            .patient_photo;
                    } else {
                        if (item.gender == 'Male') {
                            var img_path = "{{ asset('images/boy.jpg') }}";
                        } else {
                            var img_path = "{{ asset('images/girl.jpg') }}";
                        }
                    }
                    var age = (item.age != null) ? item.age : '';
                    var mobile = (item.phone_mobile != null) ? item.phone_mobile : '';
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block">' +
                        '<img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-2 float-left mrv-2" width="60" >' +
                        '<div><strong>Voucher No:</strong>' + item.voucher_id + '</div><div>' + item
                        .patient_name + '</div><div><small>G: ' + item.gender + '</small>, <small>Age: ' +
                        age + '</small>, <small>Ph: ' + mobile + '</small></div></div>' +
                        '</div>' + '<div><strong>Account:</strong>' + item.account + ' </div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span></div>');
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }

            $("#hdn_patient_biling_id").val(item.patient_id);
            obj.stopImmediatePropagation();
        });
    }

    //autocomplete for Lab Id in Pathology 06/09/2021
    function openPathologyLabIdAutoComplete(element_id, display = "lab_uid", onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3,
        }, {
            Limit: "Infinity",
            async: true,
            source: function(query, processSync, ProcessAsync) {
                return $.ajax({
                    url: "{{ route('pathology-lab-id-autocomplete') }}",
                    type: "POST",
                    data: {
                        search_data: query
                    },
                    dataType: 'Json',
                    success: function(result) {
                        return ProcessAsync(result);
                    }
                });
            },
            display: 'lab_uid',
            templates: {
                suggestion: function(item) {
                    $("#hdn_lab_id").val('');
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.lab_uid +
                        '</strong><div><small>Item Name: ' + item.item_name + '</small></div></div>' +
                        '</div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            $("#hdn_lab_id").val(item.lab_uid);
            obj.stopImmediatePropagation();
        });
    }

    // Suppiler autocomplete Added By Nazmul Date 14/11/2021

    function openSupplierAutocomplete(element_id, display = 'supplier_name', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 1,
        }, {

            Limit: "Infinity",
            async: true,
            source: function(query, processSync, ProcessAsync) {
                return $.ajax({
                    url: "{{ route('supplier-info-autocomplete') }}",
                    type: "POST",
                    data: {
                        search_data: query
                    },
                    dataType: 'Json',
                    success: function(result) {
                        return ProcessAsync(result);
                    }
                });
            },
            display: display,
            templates: {
                suggestion: function(item) {

                    // $("#hdn_supplier_id").val('');
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong> Code : ' + item.supplier_uid +
                        '</strong><div><small>Supplier Name: ' + item.supplier_name +
                        '</small></div></div>' +
                        '</div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            // $('#supplier_id').val(item.supplier_name);
            $("#hdn_supplier_id").val(item.supplier_no_pk);
            obj.stopImmediatePropagation();
        });
    }

    function openCorporateAutocomplete(element_id, display = 'ccm_client_name', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3,
        }, {

            Limit: "Infinity",
            async: true,
            source: function(query, processSync, ProcessAsync) {
                return $.ajax({
                    url: "{{ route('corporate-info-autocomplete') }}",
                    type: "POST",
                    data: {
                        search_data: query
                    },
                    dataType: 'Json',
                    success: function(result) {
                        return ProcessAsync(result);
                    }
                });
            },
            display: display,
            templates: {
                suggestion: function(item) {

                    // $("#hdn_supplier_id").val('');
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong> Code : ' + item.ccm_client_code +
                        '</strong><div><small>Client Name: ' + item.ccm_client_name +
                        '</small></div></div>' +
                        '</div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            // $('#supplier_id').val(item.supplier_name);
            $("#hdn_corporate_id").val(item.ccm_client_no_pk);
            obj.stopImmediatePropagation();
        });
    }


    function openPatientAreaInfoAutocomplete(element_id, onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('patient-area-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'lookupdata_name',
            templates: {

                suggestion: function(item) {
                    console.log(item)
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>Area Code: ' + item
                        .lookupdata_code + '</strong></div><div>Area Name: ' + item.lookupdata_name +
                        '</div></div>';
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            $("#hdn_area_code").val(item.lookupdata_no_pk);
            $("#hdn_area_name").val(item.lookupdata_name);

            obj.stopImmediatePropagation();
        });
    }

    function openChartOfAccountAutocomplete(element_id, display = 'patient_name', hidden_id, onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('chart-of-accounts-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    console.log(hidden_id);
                    $(hidden_id).val('');


                    return '<div id="user-selection" class="clearfix border-bottom">' + item.account_name +
                        '</div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span></div>');
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }

            $(hidden_id).val(item.account_no_pk);
            obj.stopImmediatePropagation();
        });
    }


    function addNotFoundGenericItem(thisElement, typehead_element) {
        var typehead_id = $(thisElement).parents(".twitter-typeahead").find(".tt-input").attr("id");
        var typehead_text = $("#" + typehead_id).typeahead('val');

        $.ajax({
            async: true,
            data: {
                generic_name: typehead_text
            },
            url: "{{ route('add-new-item') }}",
            type: "post",


            beforeSend: function () {
                blockUI();
            },
            success: function (item) {
                // $(element_id).typeahead('val', typehead_text);
                // console.log(item)
                $('#item_generic_id').val(item.insert_id);

            },
            complete: function () {
                $.unblockUI();
            },

        });
    }

    function openIPDAutocomplete(element_id, action, lookup_type, lookup_code, append_to = "") {

        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('lookup-pres-data-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        lookup_code: lookup_code,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'pres_lookupdata_name',
            templates: {

                suggestion: function(item) {
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block">' + item.pres_lookupdata_name + '</div></div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ' in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="addPermanetItem(this)"> + Add for this Permanently</div>&nbsp;<div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="prescriptionFunc.addNotFoundItem(this)"> + Add for this Prescription only</div></div>'
                        );
                        $('.tt-menu').css({
                            'padding': '15px'
                        });
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {
            if (append_to != "") {
                var action_url = "{{ route('add-pres-favourit-list') }}";
                var parent_element = "li";
                var lookup_data = "<li id='item-" + item.pres_lookupdata_id +
                    "'><input type='hidden' class='left-element' name='item_id[]' value='" + item
                    .pres_lookupdata_id +
                    "' readonly='readonly'><input type='hidden' name='item_name[]' value='" + item
                    .pres_lookupdata_name +
                    "' readonly='readonly'><input type='hidden' name='lookup_id[]' value='" + item
                    .pres_lookup_no_pk +
                    "' readonly='readonly'><input type='hidden' name='lookup_code[]' value='" + item
                    .pres_lookup_code +
                    "' readonly='readonly'><input type='hidden' name='lookupdata_code[]' value='" + item
                    .pres_lookupdata_code +
                    "' readonly='readonly'><input type='hidden' class='' id='' name='unit_intensity[]'><input type='hidden' class='' id='' name='session_duration[]'>  <input type='hidden' class='' id='' name='no_of_session[]'> <input type='hidden' class='' id='' name='session_mu[]'> <input type='hidden' class='' id='' name='frequency[]'> <input type='hidden' class='' id='' name='mode[]'><input type='hidden' name='item_dtl_val[]' value=''><input type='hidden' name='in_m_duration[]'><input type='hidden' name='in_m_repetition[]'><input type='hidden' name='in_e_location[]'><i class='fa fa-angle-double-right'></i> " +
                    item.pres_lookupdata_name +
                    "&nbsp;&nbsp;<span class='float-right text-danger cursor-pointer' title='Remove This Item' onclick='removeParentElement(this)'><i class='fa fa-times'></i></span>&nbsp;<span class='float-right text-secondary mr-1 cursor-pointer' style='font-size:11px;' title='Add To Bookmark' onclick='prescriptionFunc.addToPresFavouritList(this)' data-url='" +
                    action_url + "' data-id='" + item.pres_lookupdata_id + "' data-name='" + item
                    .pres_lookupdata_name + "' data-type='" + item.pres_lookup_code + "' data-lookup-id='" +
                    item.pres_lookup_no_pk + "'><i class='fa fa-star'></i></span></li>";

                $(element_id).typeahead('val', '');
                $(append_to).append(lookup_data);
            } else {
                $("#hdn_item_id").val(item.pres_lookupdata_id);
                $("#hdn_item_name").val(item.pres_lookupdata_name);
                $("#hdn_lookup_id").val(item.pres_lookup_no_pk);
                $("#hdn_lookup_code").val(item.pres_lookup_code);
                $("#hdn_lookupdata_code").val(item.pres_lookupdata_code);
                $("#hdn_disease_id").val(item.pres_lookupdata_id);
                $("#hdn_disease_name").val(item.pres_lookupdata_name);
            }
            obj.stopImmediatePropagation();
        });

    }


    function openPatientAutocompleteForBilling(element_id, display = 'patient_name', onclickCallback = '') {
        var hos_code=$('#hospital_code').val();
        var minLength=11;
        if (['IMPERIAL', 'IMPALA', 'AMCSH','JKMH','SSG','DMHL','RLHL'].indexOf('<?php echo Session::get('user.ses_hospital_code'); ?>') !== -1) {
             minLength=  3;
        } else {
             minLength=  11;
        }

        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: minLength
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('patient-billing-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    $("#hdn_patient_id").val('');
                    if (item.patient_photo != null) {
                        var img_path = "{{ asset('images/uploads/patient_images/thumb/') }}/" + item
                            .patient_photo;
                    } else {
                        if (item.gender == 'Male') {
                            var img_path = "{{ asset('images/boy.jpg') }}";
                        } else {
                            var img_path = "{{ asset('images/girl.jpg') }}";
                        }
                    }
                    var age = (item.age != null) ? item.pat_age : '';
                    // var age = (item.age != null) ? item.age : '';
                    var mobile = (item.phone_mobile != null) ? item.phone_mobile : '';
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-2 float-left mrv-2" width="60" ><strong>' +
                        item.patient_code + '</strong><div>' + item.patient_name + ' (' + item
                        .patient_type_code + ')' + '</div><div><small>G: ' +
                        item.gender + '</small>, <small>Age: ' + age + '</small>, <small>Ph: ' + mobile +
                        '</small></div></div>' +
                        '</div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span></div>');
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }

            $("#hdn_patient_id").val(item.patient_id);
            obj.stopImmediatePropagation();
        });
    }
    function openAppointmentPatientAutocompleteForBilling(element_id, display = 'patient_name', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 4
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('patient-appointment-billing-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    $("#hdn_patient_id").val('');
                    if (item.patient_photo != null) {
                        var img_path = "{{ asset('images/uploads/patient_images/thumb/') }}/" + item
                            .patient_photo;
                    } else {
                        if (item.gender == 'Male') {
                            var img_path = "{{ asset('images/boy.jpg') }}";
                        } else {
                            var img_path = "{{ asset('images/girl.jpg') }}";
                        }
                    }
                    var age = (item.age != null) ? item.pat_age : '';
                    // var age = (item.age != null) ? item.age : '';
                    var mobile = (item.phone_mobile != null) ? item.phone_mobile : '';
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><img src="' + img_path +
                        '" alt="doctor image" class="rounded border mr-2 float-left mrv-2" width="60" ><strong>' +
                        item.patient_code + '</strong><div>' + item.patient_name + ' (' + item
                        .patient_type_code + ')' + '</div><div><small>G: ' +
                        item.gender + '</small>, <small>Age: ' + age + '</small>, <small>Ph: ' + mobile +
                        '</small></div></div>' +
                        '</div>';
                },
                empty: function(context) {
                    // console.log(context+'_________context')
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span></div>');
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }

            $("#hdn_patient_id").val(item.patient_id);
            obj.stopImmediatePropagation();
        });
    }


    //Item Autocomplete store wise

    function item_name_autocomplete_store_wise(element_id, display = 'item_name', onclickCallback = '') {
        console.log($("#department_to").val())
        $(element_id).typeahead({
            hint: false,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {

                return $.ajax({
                    url: "{{ route('v1.item-autocomplete-store-wise') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        store_id : $("#main_store_id").val(),
                        suppiler_id : $("#supplier_id").val(),
                        minor_group_no : $("#minor_group").val(),
                        department_from : $("#department_to").val(),
                        group : $("#item_type").val()
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });

            },
            display: display,
            templates: {

                suggestion: function(item) {

                    // console.log(item)
                    var current_stock = item.current_stock != null ? item.current_stock : 0;
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var status_badge = lp_txt = "";
                    if (item.stock_status_text != '') {
                        if (item.stock_status_text == "Sufficient") {
                            status_badge = "badge badge-success";
                        } else if (item.stock_status_text == "Low Stock") {
                            status_badge = "badge badge-info";
                        } else if (item.stock_status_text == "0 Stock") {
                            status_badge = "badge badge-danger";
                            lp_txt = " - LP";
                        } else {
                            status_badge = "badge badge-danger";
                        }
                    }
                    if (item.supplier_name == null) {
                        var supplier = "N/A";
                    } else {
                        var supplier = item.supplier_name;
                    }

                        var generic_name=item.generic_name !=null ? '('+ item.generic_name +')' :'';
                    // return '<div id="user-selection" class="clearfix border-bottom">' +
                    //     '<div style="display:block"><strong>' + item.item_name+ '</strong> - <strong>' +
                    //     item.item_code +' ( '+ item.generic_name +' ) '+ '</strong><div><small>UOM: ' + item.uom_name +
                    //     '</small>, <small>Item Code: ' + item.item_code +
                    //     '</small></div><div style="display:block"><span>'+ '</span> </div><div><strong>Purchase Price : ' + item
                    //     .purchase_price + '</strong></div><div><strong>Sales Price : ' + item.item_rate +
                    //     '</strong></div><div><strong>Supplier Name : ' + supplier +
                    //     '</strong></div></div>' +
                    //     '</div>';

                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name+
                         generic_name + '</strong><div><small>UOM: <strong>' + item.uom_name +
                        '</strong></small>, <small>Item Code: ' + item.item_code +
                        '</small><small>, Main Store Stock: ' + item.stock_qty +
                        '</small><small>, Sub Store Stock: ' + item.stock_store +
                        '</small></div>';
                        // <div style="display:block"><span>'+ '</span> </div><div><strong>Purchase Price : ' + item
                        // .purchase_price + '</strong></div><div><strong>Sales Price : ' + item.item_rate +
                        // '</strong></div><div><strong>Supplier Name : ' + supplier +
                        // '</strong></div></div>' +
                        // '</div>';
                        // <strong>Stock : </strong>' +
                        // current_stock

                },
                empty: function(context) {

                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                            "label").text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                        );
                    }
                }
            }
        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }
    function item_name_autocomplete_store_wise_gatepass(element_id, display = 'item_name',item_type="", onclickCallback = '') {

        $(element_id).typeahead({
            hint: false,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('v1.item-autocomplete-store-wise-gatepass') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        store_id : $("#main_store_id").val(),
                        item_type: item_type,
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });

            },
            display: display,
            templates: {

                suggestion: function(item) {

                    // console.log(item)
                    var current_stock = item.current_stock != null ? item.current_stock : 0;
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var status_badge = lp_txt = "";
                    if (item.stock_status_text != '') {
                        if (item.stock_status_text == "Sufficient") {
                            status_badge = "badge badge-success";
                        } else if (item.stock_status_text == "Low Stock") {
                            status_badge = "badge badge-info";
                        } else if (item.stock_status_text == "0 Stock") {
                            status_badge = "badge badge-danger";
                            lp_txt = " - LP";
                        } else {
                            status_badge = "badge badge-danger";
                        }
                    }
                    if (item.supplier_name == null) {
                        var supplier = "N/A";
                    } else {
                        var supplier = item.supplier_name;
                    }


                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name+ '</strong> - <strong>' +
                        item.item_code +' ( '+ item.generic_name +' ) '+ '</strong><div><small>UOM: ' + item.uom_name +
                        '</small>, <small>Item Code: ' + item.item_code +
                        '</small></div><div style="display:block"><span>'+ '</span> </div><div><strong>Purchase Price : ' + item
                        .purchase_price + '</strong></div><div><strong>Sales Price : ' + item.item_rate +
                        '</strong></div><div><strong>Supplier Name : ' + supplier +
                        '</strong></div></div>' +
                        '</div>';
                        // <strong>Stock : </strong>' +
                        // current_stock

                },
                empty: function(context) {

                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                            "label").text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                        );
                    }
                }
            }
        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }

    //Item Autocomplete store and supplier wise
    function item_info_autocomplete_store_supplier_wise(element_id, display = 'item_name', store = '', supplier, onclickCallback = '', store_ind='') {


        // var store_id = store !='' ? $(store).val() :'';

        $(element_id).typeahead({
            hint: false,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,

            source: function(query, processSync, processAsync) {

                console.log('store', $(store).val());

                if (store_ind == 1 && $(store).val() =='') {
                    alert("Select Store");
                    return false;
                }
                return $.ajax({
                    url: "{{ route('v1.item-autocomplete-store-supplier-wise') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        store_id : $(store).val(),
                        supplier_id: $(supplier).val(),
                        store_ind:store_ind
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    //console.log(item)
                    var current_stock = item.current_stock != null ? item.current_stock : 0;
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var status_badge = lp_txt = "";
                    if (item.stock_status_text != '') {
                        if (item.stock_status_text == "Sufficient") {
                            status_badge = "badge badge-success";
                        } else if (item.stock_status_text == "Low Stock") {
                            status_badge = "badge badge-info";
                        } else if (item.stock_status_text == "0 Stock") {
                            status_badge = "badge badge-danger";
                            lp_txt = " - LP";
                        } else {
                            status_badge = "badge badge-danger";
                        }
                    }
                    if (item.supplier_name == null) {
                        var supplier = "N/A";
                    } else {
                        var supplier = item.supplier_name;
                    }


                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name+ '</strong> - <strong>' +
                        item.item_code +' ( '+ item.generic_name +' ) '+ '</strong><div><small>UOM: ' + item.uom_name +
                        '</small>, <small>Item Code: ' + item.item_code +
                        '</small></div><div style="display:block"><span>'+ '</span> </div><div><strong>Purchase Price : ' + item
                        .purchase_price + '</strong></div><div><strong>Sales Price : ' + item.item_rate +
                        '</strong></div><div><strong>Supplier Name : ' + supplier +
                        '</strong></div></div>' +
                        '</div>';
                        // <strong>Stock : </strong>' +
                        // current_stock
                },
                empty: function(context) {

                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                            "label").text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                        );
                    }
                }
            }
        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }
    function item_info_autocomplete_store_supplier_wise_cafe(element_id, display = 'item_name', store = '', supplier, onclickCallback = '', store_ind='',item_type='',stock_type='') {


        // var store_id = store !='' ? $(store).val() :'';

        $(element_id).typeahead({
            hint: false,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,

            source: function(query, processSync, processAsync) {


                if (store_ind == 1 && $(store).val() =='') {
                    alert("Select Store");
                    return false;
                }
                store_id= $(store).val();
                let  store_fnb_ind= '';
                let item_type_data='';
                let stock_type_data='';
                if ($("input[name='inlineRadioOptions']:checked").val() == 'TRANSIN') {
                    store_fnb_ind= '';
                    item_type_data=item_type;
                    stock_type_data=stock_type;
                }else{
                    store_fnb_ind= 1;
                    item_type_data ='';
                    stock_type_data ='';
                }
                console.log(store_id+'__'+$("input[name='inlineRadioOptions']:checked").val())
                return $.ajax({
                    url: "{{ route('v1.item-autocomplete-store-supplier-wise-cafe') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        store_id : store_id,
                        store_fnb_ind : store_fnb_ind,
                        supplier_id: $(supplier).val(),
                        store_ind:store_ind,
                        item_type:item_type_data,
                        stock_type_data:stock_type_data,
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    //console.log(item)
                    var current_stock = item.current_stock != null ? item.current_stock : 0;
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var status_badge = lp_txt = "";
                    if (item.stock_status_text != '') {
                        if (item.stock_status_text == "Sufficient") {
                            status_badge = "badge badge-success";
                        } else if (item.stock_status_text == "Low Stock") {
                            status_badge = "badge badge-info";
                        } else if (item.stock_status_text == "0 Stock") {
                            status_badge = "badge badge-danger";
                            lp_txt = " - LP";
                        } else {
                            status_badge = "badge badge-danger";
                        }
                    }
                    if (item.supplier_name == null) {
                        var supplier = "N/A";
                    } else {
                        var supplier = item.supplier_name;
                    }


                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name+ '</strong> - <strong>' +
                        item.item_code +' ( '+ item.generic_name +' ) '+ '</strong><div><small>UOM: ' + item.uom_name +
                        '</small>, <small>Item Code: ' + item.item_code +
                        '</small></div><div style="display:block"><span>'+ '</span> </div><div><strong>Purchase Price : ' + item
                        .purchase_price + '</strong></div><div><strong>Sales Price : ' + item.item_rate +
                        '</strong></div><div><strong>Supplier Name : ' + supplier +
                        '</strong></div></div>' +
                        '</div>';
                        // <strong>Stock : </strong>' +
                        // current_stock
                },
                empty: function(context) {

                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                            "label").text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                        );
                    }
                }
            }
        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }
    function item_info_autocomplete_store_add_out(element_id, display = 'item_name', store = '', supplier, onclickCallback = '', store_ind='') {


        // var store_id = store !='' ? $(store).val() :'';

        $(element_id).typeahead({
            hint: false,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,

            source: function(query, processSync, processAsync) {

                console.log('store', $(store).val());

                if (store_ind == 1 && $(store).val() =='') {
                    alert("Select Store");
                    return false;
                }
                return $.ajax({
                    url: "{{ route('v1.item-autocomplete-store-add-out') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        store_id : $(store).val(),
                        supplier_id: $(supplier).val(),
                        store_ind:$('input[name="inlineRadioOptions"]:checked').val()
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    console.log(item)
                    var current_stock = item.current_stock != null ? item.current_stock : 0;
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var status_badge = lp_txt = "";
                    if (item.stock_status_text != '') {
                        if (item.stock_status_text == "Sufficient") {
                            status_badge = "badge badge-success";
                        } else if (item.stock_status_text == "Low Stock") {
                            status_badge = "badge badge-info";
                        } else if (item.stock_status_text == "0 Stock") {
                            status_badge = "badge badge-danger";
                            lp_txt = " - LP";
                        } else {
                            status_badge = "badge badge-danger";
                        }
                    }
                    if (item.supplier_name == null) {
                        var supplier = "N/A";
                    } else {
                        var supplier = item.supplier_name;
                    }


                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name+ '</strong> - <strong>' +
                        item.item_code +' ( '+ item.generic_name +' ) '+ '</strong><div><small>UOM: ' + item.uom_name +
                        '</small>, <small>Item Code: ' + item.item_code +
                        '</small></div><div style="display:block"><span>'+ '</span> </div><div><strong>Purchase Price : ' + item
                        .purchase_price + '</strong></div><div><strong>Sales Price : ' + item.item_rate +
                        '</strong></div><div><strong>Supplier Name : ' + supplier +
                        '</strong></div></div>' +
                        '</div>';
                        // <strong>Stock : </strong>' +
                        // current_stock
                },
                empty: function(context) {

                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                            "label").text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                        );
                    }
                }
            }
        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }
    function item_info_autocomplete_store_to_store(element_id, display = 'item_name', store='', supplier, onclickCallback = '',store_ind='') {
        console.log(store.val()+"___store_ind")
        $(element_id).typeahead({
            hint: false,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,

            source: function(query, processSync, processAsync) {
                console.log(store.val()+"___store_ind")
                if (store_ind == 1 && store.val() =='') {
                    alert("Select Store");
                    return false;
                }
                return $.ajax({
                    url: "{{ route('v1.item-autocomplete-store-store-to-store') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        store_id : $(store).val(),
                        supplier_id: $(supplier).val()
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    //console.log(item)
                    var current_stock = item.current_stock != null ? item.current_stock : 0;
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var status_badge = lp_txt = "";
                    if (item.stock_status_text != '') {
                        if (item.stock_status_text == "Sufficient") {
                            status_badge = "badge badge-success";
                        } else if (item.stock_status_text == "Low Stock") {
                            status_badge = "badge badge-info";
                        } else if (item.stock_status_text == "0 Stock") {
                            status_badge = "badge badge-danger";
                            lp_txt = " - LP";
                        } else {
                            status_badge = "badge badge-danger";
                        }
                    }
                    if (item.supplier_name == null) {
                        var supplier = "N/A";
                    } else {
                        var supplier = item.supplier_name;
                    }


                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name+ '</strong> - <strong>' +
                        item.item_code +' ( '+ item.generic_name +' ) '+ '</strong><div><small>UOM: ' + item.uom_name +
                        '</small>, <small>Item Code: ' + item.item_code +
                        '</small></div><div style="display:block"><span>'+ '</span> </div><div><strong>Purchase Price : ' + item
                        .purchase_price + '</strong></div><div><strong>Sales Price : ' + item.item_rate +
                        '</strong></div><div><strong>Supplier Name : ' + supplier +
                        '</strong></div></div>' +
                        '</div>';
                        // <strong>Stock : </strong>' +
                        // current_stock
                },
                empty: function(context) {

                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                            "label").text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                        );
                    }
                }
            }
        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }
    function item_info_autocomplete_sub_store_supplier_wise(element_id, display = 'item_name', store, supplier, onclickCallback = '',store_ind="") {
        console.log($(supplier).find(':selected').val()+"_____servive");
        $(element_id).typeahead({
            hint: false,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,

            source: function(query, processSync, processAsync) {
                if (store_ind == 1 && store.val() =='') {
                    alert("Select Store");
                    return false;
                }
                return $.ajax({
                    url: "{{ route('v1.item-autocomplete-sub-store-supplier-wise') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        store_id : $(store).val(),
                        supplier_id: $(supplier).val()
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {
                    //console.log(item)
                    var current_stock = item.current_stock != null ? item.current_stock : 0;
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var status_badge = lp_txt = "";
                    if (item.stock_status_text != '') {
                        if (item.stock_status_text == "Sufficient") {
                            status_badge = "badge badge-success";
                        } else if (item.stock_status_text == "Low Stock") {
                            status_badge = "badge badge-info";
                        } else if (item.stock_status_text == "0 Stock") {
                            status_badge = "badge badge-danger";
                            lp_txt = " - LP";
                        } else {
                            status_badge = "badge badge-danger";
                        }
                    }
                    if (item.supplier_name == null) {
                        var supplier = "N/A";
                    } else {
                        var supplier = item.supplier_name;
                    }


                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name+ '</strong> - <strong>' +
                        item.item_code +' ( '+ item.generic_name +' ) '+ '</strong><div><small>UOM: ' + item.uom_name +
                        '</small>, <small>Item Code: ' + item.item_code +
                        '</small></div><div style="display:block"><span>'+ '</span> </div><div><strong>Purchase Price : ' + item
                        .purchase_price + '</strong></div><div><strong>Sales Price : ' + item.item_rate +
                        '</strong></div><div><strong>Supplier Name : ' + supplier +
                        '</strong></div></div>' +
                        '</div>';
                        // <strong>Stock : </strong>' +
                        // current_stock
                },
                empty: function(context) {

                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                            "label").text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                        );
                    }
                }
            }
        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }

    function item_code_autocomplete_store_wise(element_id, display = 'item_code', onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('pharmacy-item-info-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {

                    var current_stock = item.current_stock != null ? item.current_stock : 0;
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var status_badge = lp_txt = "";
                    if (item.stock_status_text != '') {
                        if (item.stock_status_text == "Sufficient") {
                            status_badge = "badge badge-success";
                        } else if (item.stock_status_text == "Low Stock") {
                            status_badge = "badge badge-info";
                        } else if (item.stock_status_text == "0 Stock") {
                            status_badge = "badge badge-danger";
                            lp_txt = " - LP";
                        } else {
                            status_badge = "badge badge-danger";
                        }
                    }
                    if (item.supplier_name == null) {
                        var supplier = "N/A";
                    } else {
                        var supplier = item.supplier_name;
                    }


                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name + '</strong> - <strong>' +
                        item.item_code + '</strong><div><small>UOM: ' + item.uom_name +
                        '</small>, <small>Item Code: ' + item.item_code +
                        '</small></div><div style="display:block"><span><strong>Stock : </strong>' +
                        current_stock + '</span> </div><div><strong>Purchase Price : ' + item
                        .purchase_price + '</strong></div><div><strong>Sales Price : ' + item.item_rate +
                        '</strong></div><div><strong>Supplier Name : ' + supplier +
                        '</strong></div></div>' +
                        '</div>';
                },
                empty: function(context) {

                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                            "label").text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }
    function openEventAutocomplete(element_id, hdn_id,lookup_code ,onclickCallback = '') {
        // element_id, action, lookup_type, lookup_code, append_to = ""
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('v1.get-event-list') }}",
                    type: 'POST',
                    beforeSend: function() {
                        $(hdn_id).val('');
                    },
                    data: {
                        search_data: query,
                        lookup_code: lookup_code,

                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'lookupdata_name',
            templates: {

                suggestion: function(item) {

                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block">' + item.lookupdata_name + '</div></div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ' in this generic name. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="addNotFoundGenericItem(this)"> + Add Generic Name</div></div>'
                        );
                        $('.tt-menu').css({
                            'padding': '15px'
                        });
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {


            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            $(element_id).typeahead('val', item.lookupdata_name);
            $(hdn_id).val(item.lookupdata_no_pk);

            obj.stopImmediatePropagation();
        });

    }


    function item_name_autocomplete_store_wise_stock(element_id, display = 'item_name', onclickCallback = '') {
        $(element_id).typeahead({
            hint: false,
            highlight: true,
            minLength: 3,

        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                var store_id = $('#department_from').val();
                return $.ajax({
                    url: "{{ route('v1.item-autocomplete-store-wise-stock') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        store_id: store_id
                    },
                    dataType: 'json',
                    success: function(result) {

                        return processAsync(result);
                    }
                });
            },
            display: display,
            templates: {

                suggestion: function(item) {

                    // console.log(item)
                    var current_stock = item.current_stock != null ? item.current_stock : 0;
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var status_badge = lp_txt = "";
                    if (item.stock_status_text != '') {
                        if (item.stock_status_text == "Sufficient") {
                            status_badge = "badge badge-success";
                        } else if (item.stock_status_text == "Low Stock") {
                            status_badge = "badge badge-info";
                        } else if (item.stock_status_text == "0 Stock") {
                            status_badge = "badge badge-danger";
                            lp_txt = " - LP";
                        } else {
                            status_badge = "badge badge-danger";
                        }
                    }
                    if (item.supplier_name == null) {
                        var supplier = "N/A";
                    } else {
                        var supplier = item.supplier_name;
                    }



                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name+ '</strong> - <strong>' +
                        item.item_code +'</strong><div><small>UOM: ' + item.uom_name +
                        '</small></div><div style="display:block"><span>'+ '</span> </div><div><strong>Store Name: ' + item
                        .store_name + '</strong></div><div><strong>Stock : ' + item.current_stock +
                        '</strong></div><div></div></div>' +
                        '</div>';


                        // <strong>Stock : </strong>' +
                        // current_stock

                },
                empty: function(context) {

                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings(
                            "label").text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched Item not found.</span><div class="border-top pt-2">This Item is not found in the System.</div></div>'
                        );
                    }
                }
            }
        }).bind("typeahead:selected", function(obj, item, name) {
            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            obj.stopImmediatePropagation();
        });
    }

    // Added By Nazmul 01.01.20123

    function openChequeAutocomplete(element_id, hdn_id,lookup_code ,onclickCallback = '') {
        // element_id, action, lookup_type, lookup_code, append_to = ""
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('cheque-info-autocomplete') }}",
                    type: 'POST',
                    beforeSend: function() {
                        $(hdn_id).val('');
                    },
                    data: {
                        search_data: query,
                        lookup_code: lookup_code,

                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'lookupdata_name',
            templates: {

                suggestion: function(item) {

                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block">' + item.lookupdata_name + '</div></div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ' in this generic name. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" onclick="addNotFoundGenericItem(this)"> + Add Generic Name</div></div>'
                        );
                        $('.tt-menu').css({
                            'padding': '15px'
                        });
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {


            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }
            $(element_id).typeahead('val', item.lookupdata_name);
            $(hdn_id).val(item.lookupdata_no_pk);

            obj.stopImmediatePropagation();
        });

    }

// For Prescription Autocomplete
    function openOPDPrescriptionAutocomplete(element_id, item_type = "", item_id_element = "", item_name_element = "",
        onclickCallback = '') {
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('get-item-with-stock') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {

                suggestion: function(item) {
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    var current_stock = item.current_stock != null ? item.current_stock : '';
                    var purchase_price = item.purchase_price != null ? parseFloat(item.purchase_price) : 0;
                    var item_rate = item.item_rate != null ? item.item_rate : 0;
                    var vat_percent = item.vat_percent != null ? parseFloat(item.vat_percent) : 0;
                    var vat_amt = (purchase_price * vat_percent) / 100;
                    var vat_rate = (purchase_price + vat_amt).toFixed(2);
                    var status_badge = lp_txt = "";
                    var supplier_name = item.supplier_name !=null ? item.supplier_name :'';
                    // console.log(item.supplier_name)
                    // console.log(vat_amt+'_'+vat_rate);
                    // if (item.stock_status_text != '') {
                    //     if (item.stock_status_text == "Sufficient") {
                    //         status_badge = "badge badge-success";
                    //     } else if (item.stock_status_text == "Low Stock") {
                    //         status_badge = "badge badge-info";
                    //     } else if (item.stock_status_text == "0 Stock") {
                    //         status_badge = "badge badge-danger";
                    //         lp_txt = " - LP";
                    //     } else {
                    //         status_badge = "badge badge-danger";
                    //     }
                    // }
                    // <span class="badge ' + status_badge + '">' +stock_status_text  + ' ' + lp_txt + '</span>
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_id + '</strong> - ' + item
                        .item_name + ' ( '+item.generic_name +' ) '+'</div><div style="display:block"><span><strong>Stock : </strong>' +
                        current_stock + '</span> </div><div><strong>Purchase Price : ' + vat_rate +
                        '</strong></div><div><strong>Sales Price : ' + item_rate + '</strong></div><div><strong>Supplier Name : ' + supplier_name + '</strong></div></div>';
                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ` in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" data-element_id="${element_id}" data-item_id_element="${item_id_element}" onclick="prescriptionFunc.addNotFoundMedItem(event,this)"> + Add for this Prescription only</div></div>`
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)


            }

            if (item_id_element == "") {
                element_id.parent("span").siblings('input').val(item.item_id);
            } else {
                console.log(item_id_element + item.current_stock);
                $(this).parent("span").siblings(item_id_element).val(item.item_id);
                $(this).parent("span").siblings(item_id_element).attr('name','hdn_medicine_item_id[]');
                $(this).parent("span").parent("span").parent("td").parent("tr").find('#stock_qty').html(item.current_stock);
            //   var checkData=  $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val();
            //   if (checkData !="") {
            //     var checkDataSplit=checkData.split('_');
            //     var reArange=checkDataSplit[0]+'_'+item.item_id+'_'+checkDataSplit[2]+'_'+checkDataSplit[3];
            //       $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val(reArange);
            //     console.log(checkDataSplit)
            //   }

                console.log($(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val()+'__________bellal')
                if (item_name_element !='') {
                    $(element_id).parent("span").siblings(item_name_element).val(item.item_name);
                }
            }
            // if (item_id_element == "") {
            //     element_id.parent("span").siblings('input').val(item.item_id);
            // } else {
            //     element_id.parent("span").siblings(item_id_element).val(item.item_id);
            //     element_id.parent("span").siblings(item_name_element).val(item.item_name);
            //     element_id.parent("span").siblings('#hdn_lookupdata_code_1').val(lookupData_code);
            //     element_id.parent("span").siblings('#hdn_lookup_id_1').val(lookup_id);
            //     console.log(lookup_id, lookupData_code)
            // }
            obj.stopImmediatePropagation();
        });
    }


    function openItemAutocompleteWithStockPrescription(element_id, item_type = "", item_id_element = "", item_name_element = "",
        onclickCallback = '') {

        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('get-item-with-stock-prescription') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {

                suggestion: function(item) {
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    // var current_stock = item.current_stock != null ? '<div style="display:block"><span style="background-color:yellow;color:black"><strong>Stock : </strong>' + item.current_stock +'</span></div>': '<div style="display:block; "><span style="background-color:red;color:white"><strong>Stock : 0</strong> </span></div>';
                    var current_stock = item.current_stock != null ?
                    (item.current_stock > 0 ? '<div style="display:block"><span style="background-color:yellow;color:black"><strong>Stock : </strong>' + item.current_stock +'</span></div>' : '<div style="display:block; "><span style="background-color:red;color:white"><strong>Stock : 0</strong> </span></div>') :
                    '<div style="display:block; "><span style="background-color:red;color:white"><strong>Stock : 0</strong> </span></div>';

                    var purchase_price = item.purchase_price != null ? parseFloat(item.purchase_price) : 0;
                    var item_rate = item.item_rate != null ? item.item_rate : 0;
                    var vat_percent = item.vat_percent != null ? parseFloat(item.vat_percent) : 0;
                    var vat_amt = (purchase_price * vat_percent) / 100;
                    var vat_rate = (purchase_price + vat_amt).toFixed(2);
                    var status_badge = lp_txt = "";
                    var supplier_name = item.supplier_name != null ? item.supplier_name : '';
                    // console.log(current_stock+'_____stock');
                    // console.log(item.supplier_name)
                    // console.log(vat_amt+'_'+vat_rate);
                    // if (item.stock_status_text != '') {
                    //     if (item.stock_status_text == "Sufficient") {
                    //         status_badge = "badge badge-success";
                    //     } else if (item.stock_status_text == "Low Stock") {
                    //         status_badge = "badge badge-info";
                    //     } else if (item.stock_status_text == "0 Stock") {
                    //         status_badge = "badge badge-danger";
                    //         lp_txt = " - LP";
                    //     } else {
                    //         status_badge = "badge badge-danger";
                    //     }
                    // }
                    // <span class="badge ' + status_badge + '">' +stock_status_text  + ' ' + lp_txt + '</span>
                    var hospital_code = $('#hospital_code').val();
                   
                    // if (hospital_code != 'UNICO') {
                    //  return '<div id="user-selection" class="clearfix border-bottom">' +
                    //     '<div style="display:block"><strong>' + item.item_id + '</strong> - ' + item
                    //     .item_name + ' ( '+item.generic_name +' ) '+'</div>' +
                    //     current_stock + '<div><strong>Purchase Price : ' + vat_rate +
                    //     '</strong></div><div><strong>Sales Price : ' + item_rate + '</strong></div><div><strong>Supplier Name : ' + supplier_name + '</strong></div></div>';
                    // }else{
                    //    return '<div id="user-selection" class="clearfix border-bottom">' +
                    //     '<div style="display:block"><strong>' + item.item_name + ' ( '+item.generic_name +' ) '+'</div>' +
                    //     current_stock + '<div></div>';

                    // }
                    let allMainStock='';
                    if (item.all_main_stock !='') {
                        item.all_main_stock.forEach(element => {
                            console.log(element)
                            allMainStock +='<span class="text-primary">'+element.serviceunit_name +'='+element.balance_qty+'</span><br>';
                        });
                    }
                     return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name + ' ( '+item.generic_name +' ) '+'</div>' +
                        allMainStock ;

                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ` in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" data-element_id="${element_id}" data-item_id_element="${item_id_element}" onclick="prescriptionFunc.addNotFoundMedItem(event,this)"> + Add for this Prescription only</div></div>`
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }

            if (item_id_element == "") {
                element_id.parent("span").siblings('input').val(item.item_id);
            } else {
                console.log(item_id_element + item.current_stock);
                $(this).parent("span").siblings(item_id_element).val(item.item_id);
                $(this).parent("span").siblings(item_id_element).attr('name','hdn_medicine_item_id[]');
                $(this).parent("span").parent("span").parent("td").parent("tr").find('#stock_qty').html(item.current_stock);
            //   var checkData=  $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val();
            //   if (checkData !="") {
            //     var checkDataSplit=checkData.split('_');
            //     var reArange=checkDataSplit[0]+'_'+item.item_id+'_'+checkDataSplit[2]+'_'+checkDataSplit[3];
            //       $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val(reArange);
            //     console.log(checkDataSplit)
            //   }

                console.log($(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val()+'__________bellal')
                if (item_name_element !='') {
                    $(element_id).parent("span").siblings(item_name_element).val(item.item_name);
                }
            }
            // if (item_id_element == "") {
            //     element_id.parent("span").siblings('input').val(item.item_id);
            // } else {
            //     element_id.parent("span").siblings(item_id_element).val(item.item_id);
            //     element_id.parent("span").siblings(item_name_element).val(item.item_name);
            //     element_id.parent("span").siblings('#hdn_lookupdata_code_1').val(lookupData_code);
            //     element_id.parent("span").siblings('#hdn_lookup_id_1').val(lookup_id);
            //     console.log(lookup_id, lookupData_code)
            // }
            obj.stopImmediatePropagation();
        });
    }

    function openItemAutocompleteWithStockPrescriptionStoreWise(element_id, item_type = "", item_id_element = "", item_name_element = "", store_id = "", onclickCallback = '') {

        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('get-item-with-stock-prescription-store-wise') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        store_id: store_id,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {

                suggestion: function(item) {
                    var stock_status_text = item.stock_status_text != null ? item.stock_status_text : '';
                    // var current_stock = item.current_stock != null ? '<div style="display:block"><span style="background-color:yellow;color:black"><strong>Stock : </strong>' + item.current_stock +'</span></div>': '<div style="display:block; "><span style="background-color:red;color:white"><strong>Stock : 0</strong> </span></div>';
                    var current_stock = item.current_stock != null ?
                    (item.current_stock > 0 ? '<div style="display:block"><span style="background-color:yellow;color:black"><strong>Stock : </strong>' + item.current_stock +'</span></div>' : '<div style="display:block; "><span style="background-color:red;color:white"><strong>Stock : 0</strong> </span></div>') :
                    '<div style="display:block; "><span style="background-color:red;color:white"><strong>Stock : 0</strong> </span></div>';

                    var purchase_price = item.purchase_price != null ? parseFloat(item.purchase_price) : 0;
                    var item_rate = item.item_rate != null ? item.item_rate : 0;
                    var vat_percent = item.vat_percent != null ? parseFloat(item.vat_percent) : 0;
                    var vat_amt = (purchase_price * vat_percent) / 100;
                    var vat_rate = (purchase_price + vat_amt).toFixed(2);
                    var status_badge = lp_txt = "";
                    var supplier_name = item.supplier_name != null ? item.supplier_name : '';
                    // console.log(current_stock+'_____stock');
                    // console.log(item.supplier_name)
                    // console.log(vat_amt+'_'+vat_rate);
                    // if (item.stock_status_text != '') {
                    //     if (item.stock_status_text == "Sufficient") {
                    //         status_badge = "badge badge-success";
                    //     } else if (item.stock_status_text == "Low Stock") {
                    //         status_badge = "badge badge-info";
                    //     } else if (item.stock_status_text == "0 Stock") {
                    //         status_badge = "badge badge-danger";
                    //         lp_txt = " - LP";
                    //     } else {
                    //         status_badge = "badge badge-danger";
                    //     }
                    // }
                    // <span class="badge ' + status_badge + '">' +stock_status_text  + ' ' + lp_txt + '</span>
                    var hospital_code = $('#hospital_code').val();
                    // if (hospital_code != 'UNICO') {
                    //  return '<div id="user-selection" class="clearfix border-bottom">' +
                    //     '<div style="display:block"><strong>' + item.item_id + '</strong> - ' + item
                    //     .item_name + ' ( '+item.generic_name +' ) '+'</div>' +
                    //     current_stock + '<div><strong>Purchase Price : ' + vat_rate +
                    //     '</strong></div><div><strong>Sales Price : ' + item_rate + '</strong></div><div><strong>Supplier Name : ' + supplier_name + '</strong></div></div>';
                    // }else{
                    //    return '<div id="user-selection" class="clearfix border-bottom">' +
                    //     '<div style="display:block"><strong>' + item.item_name + ' ( '+item.generic_name +' ) '+'</div>' +
                    //     current_stock + '<div></div>';

                    // }

                      let allMainStock='';
                    if (item.all_main_stock !='') {
                        item.all_main_stock.forEach(element => {
                            console.log(element)
                            allMainStock +='<span class="text-primary">'+element.serviceunit_name +'='+element.balance_qty+'</span><br>';
                        });
                    }
                     return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_name + ' ( '+item.generic_name +' ) '+'</div>' +
                        allMainStock ;

                },
                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ` in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" data-element_id="${element_id}" data-item_id_element="${item_id_element}" onclick="prescriptionFunc.addNotFoundMedItem(event,this)"> + Add for this Prescription only</div></div>`
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (onclickCallback != '') {
                onclickCallback(item, obj)
            }

            if (item_id_element == "") {
                element_id.parent("span").siblings('input').val(item.item_id);
            } else {
                console.log(item_id_element + item.current_stock);
                $(this).parent("span").siblings(item_id_element).val(item.item_id);
                $(this).parent("span").siblings(item_id_element).attr('name','hdn_medicine_item_id[]');
                $(this).parent("span").parent("span").parent("td").parent("tr").find('#stock_qty').html(item.current_stock);
            //   var checkData=  $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val();
            //   if (checkData !="") {
            //     var checkDataSplit=checkData.split('_');
            //     var reArange=checkDataSplit[0]+'_'+item.item_id+'_'+checkDataSplit[2]+'_'+checkDataSplit[3];
            //       $(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val(reArange);
            //     console.log(checkDataSplit)
            //   }

                console.log($(this).parent("span").parent("span").parent("td").parent("tr").find('#indent_approval').val()+'__________bellal')
                if (item_name_element !='') {
                    $(element_id).parent("span").siblings(item_name_element).val(item.item_name);
                }
            }
            // if (item_id_element == "") {
            //     element_id.parent("span").siblings('input').val(item.item_id);
            // } else {
            //     element_id.parent("span").siblings(item_id_element).val(item.item_id);
            //     element_id.parent("span").siblings(item_name_element).val(item.item_name);
            //     element_id.parent("span").siblings('#hdn_lookupdata_code_1').val(lookupData_code);
            //     element_id.parent("span").siblings('#hdn_lookup_id_1').val(lookup_id);
            //     console.log(lookup_id, lookupData_code)
            // }
            obj.stopImmediatePropagation();
        });
    }


    // for Item List Only

    function openItemAutocompleteOnly(element_id, item_type = "", item_id_element = "", item_name_element = "", lookup_id =
        "", lookupData_code = "",onclickCallback = '') {
         console.log(element_id );
        $(element_id).typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                return $.ajax({
                    url: "{{ route('get-item-name') }}",
                    type: 'POST',
                    data: {
                        query: query,
                        item_type: item_type,
                        _token: $('meta[name="csrf-token"]').attr('content')
                    },
                    dataType: 'json',
                    success: function(result) {
                        return processAsync(result);
                    }
                });
            },
            display: 'item_name',
            templates: {
                suggestion: function(item) {
console.log(item)
                    var generic_name  = item.generic_name!= null ? "( "+ item.generic_name+")" :'';
                    return '<div id="user-selection" class="clearfix border-bottom">' +
                        '<div style="display:block"><strong>' + item.item_code + '</strong> - ' + item
                        .item_name +' '+ generic_name +'  </div></div>';
                },

                empty: function(context) {
                    if ($(element_id).typeahead('val') != "") {
                        var search_label = $(element_id).parents(".twitter-typeahead").siblings("label")
                            .text();
                        $(element_id).siblings(".tt-menu").find(".tt-dataset").html(
                            '<div id="empty-tt"><span class="text-danger">Searched ' + search_label +
                            ' not found.</span><div class="border-top pt-2">You can use this as ' +
                            search_label +
                            ` in this Prescription. Click the below button to add. </div><div class="btn btn-outline-primary btn-sm bg-none mt-2" data-element_id="${element_id}" data-item_id_element="${item_id_element}" onclick="prescriptionFunc.addNotFoundMedItem(event,this)"> + Add for this Prescription only</div></div>`
                        );
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            if (item_id_element == "") {
                $(element_id).parent("span").siblings('input').val(item.item_id);
            } else {
                $(element_id).parent("span").siblings(item_id_element).val(item.item_id);
                // $(element_id).parent("span").siblings(item_name_element).val(item.item_name);
                // $(element_id).parent("span").siblings('#hdn_lookupdata_code_1').val(lookupData_code);
                // $(element_id).parent("span").siblings('#hdn_lookup_id_1').val(lookup_id);
                console.log(item.item_id + 'test')
            }
            obj.stopImmediatePropagation();
        });
    }
</script>
