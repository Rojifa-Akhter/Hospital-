<!-- Custom CSS for larger badges -->
<style>
    .badge-lg {
        font-size: 1.1rem;
        padding: 0.6em 1em;
        font-weight: 500;
        border-radius: 0.5rem;
        cursor: pointer;
    }
</style>

<div class="row">
    <div class="col-md-12">
        <div class="card mb-4">
            <div class="card-header pb-0">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item" role="presentation">
                        <button class="nav-link active" id="pills-mum-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-mum" type="button" role="tab" aria-controls="pills-mum"
                            aria-selected="false" data-tab_type="0">
                            Most Used Medicine
                        </button>
                    </li>
                    <li class="nav-item" role="presentation">
                        <button class="nav-link " id="pills-group-tab" data-bs-toggle="pill"
                            data-bs-target="#pills-group" type="button" role="tab" aria-controls="pills-group"
                            aria-selected="true" data-tab_type="1">
                            Group Medicine
                        </button>
                    </li>
                </ul>
            </div>

            <div class="card-body">
                <div class="tab-content" id="pills-tabContent">
                    <!-- Most Used Medicine Tab -->
                    <div class="tab-pane fade show active" id="pills-mum" role="tabpanel"
                        aria-labelledby="pills-mum-tab">
                        <div id="most_used_medicine">
                            <div class="row mb-3">
                                <div class="col-md-6">
                                    <h5>Most Used Medicine List</h5>
                                </div>
                                <div class="col-md-6">
                                    <input type="text" class="form-control" placeholder="Enter Medicine Name"
                                        onkeyup="searchMumUhl(this)">
                                </div>
                            </div>

                            <hr class="my-3" style="border-top: 2px solid #28a745; opacity: 1;">

                            <div class="card-body" style="max-height: 350px; overflow-y: auto;">
                                <div class="row" id="itemData">
                                    @if (!empty($item_list))
                                        @foreach ($item_list as $record)
                                            <div class="col-md-4 mb-3">
                                                <span class="badge badge-lg bg-success text-white rounded-pill"
                                                    onclick="mostUsedItemData(this)"
                                                    data-alt-id="{{ $record->item_no_fk }}"
                                                    data-alt-name="{{ $record->brand_name }}"
                                                    id="item_name_{{ $record->item_no_fk }}">
                                                    {{ $record->brand_name }}
                                                </span>
                                            </div>
                                        @endforeach
                                    @else
                                        <div class="col-12">
                                            <p class="text-muted">No medicines found.</p>
                                        </div>
                                    @endif
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Group Medicine Tab -->
                    <div class="tab-pane fade" id="pills-group" role="tabpanel" aria-labelledby="pills-group-tab">
                        <div id="Group">
                            {{-- Content for Group Medicine goes here --}}
                            {{-- Example: --}}
                            {{-- <p>List of grouped medicines will be displayed here.</p> --}}
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>



<script>
    var setMedicines = [];
    var medicineDoseCount = {};


    function mostUsedItemData(thisElement) {
        // Highlight selected badge
        $(".badge").removeClass("bg-primary").addClass("bg-success");
        $(thisElement).removeClass("bg-success").addClass("bg-primary");

        var itemId = $(thisElement).attr('data-alt-id');
        var medicineItem = $(thisElement).attr('data-alt-name');

        $.ajax({
            data: {
                item_id: itemId
            },
            url: "{{ url('prescription-most-used-medicine-data') }}",
            type: 'get',
            beforeSend: function() {
                // Optional: blockUI();
            },
            success: function(data) {
                if (!data) {
                    console.error("No data received from server.");
                    return;
                }

                const oldId = $("#data-append-to tr").length;
                const dose = $("#doseID")?.html() || '';
                const route = $("#routeId")?.html() || '';
                const instruction = $("#instructionId")?.html() || '';
                const duration = $("#durationId")?.html() || '';

                const med_row = {
                    dosage: data?.dosage || '',
                    multidose_txt: data?.multidose_txt || ''
                };

                const doges = data?.doges || []; // dose options from backend
                const itemIdStr = String(itemId);

                // Track number of times the same medicine is used
                medicineDoseCount[itemIdStr] = (medicineDoseCount[itemIdStr] || 0) + 1;
                const doseNo = medicineDoseCount[itemIdStr];



                // Populate doses
               selectDoseElement =
                        `<div class="" id="doseID" style="display: flex">
                                                <div><select class="form-control form-control-sm m-0 p-0 medicine_dose doseEdit select2 select2-hidden-accessible" id="medicine_dose_${oldId + 1}" name="medicine_dose[]" onchange="prescriptionFunc.addMoreDropdownOption(this,'.medicine_dose'); prescriptionFunc.calculateMedicineQnty(this);" data-select2-id="medicine_dose_${oldId + 1}" tabindex="-1" aria-hidden="true"> <option value="0">Select</option><option data-qnty="0" data-dropdown_option="add_more" data-popup_header="Medicine Route" data-input_label="Route" data-input_placeholder="Enter medicine route (i.e., Oral, Ocular)" value="0">Add More</option>`;
                    $.each(doges, function(key, value) {
                        console.log(value.data)
                        const isDoseSelected = med_row.dosage === value.data ?
                            `<option value="${value.data}" selected>${value.data}</option>` :
                            ` <option value="${value.data}">${value.data}</option>`;

                        const text_dose = med_row.dosage != value.data ?
                            `<option value="${med_row.dosage}" selected>${med_row.dosage}</option>` :
                            '';
                        // `<option value="0" selected>${med_row.dosage}</option>`
                        // med_row.dosage === value.data
                        selectDoseElement += isDoseSelected + text_dose;
                    });
                    selectDoseElement += `</select></div> <div class="editDosButton" id="medicine_dose_${oldId + 1}"
                                                    onclick ="prescriptionFunc.addMoreDropdownOption(this,'.editDosButton');"
                                                    data-qnty="0" data-dropdown_option_edit="edit_option_dose"
                                                    data-popup_header="Medicine Dose" data-input_label="Dose"
                                                    data-input_placeholder="Enter medicine doses (i.e., 0+0+0, 0tsf+0tsf+0tsf)"
                                                    value="0">
                                                    <span class="btn btn-success btn-sm" type="button"
                                                        style="padding: 3px 5px 6px 5px !important"> <i
                                                            class="fa fa-edit"></i></span>
                                                </div></div>`;

                // Append table row
                $("#data-append-to").append(`
                <tr id="tr_id_${oldId}" class="border-0">
                    <td class="p-0 px-1 border-0" width="20%">
                        ${doseNo === 1 ? `
                            <input type="text" class="form-control form-control-sm m-0 p-0 item_element bg-white"
                                   id="medicine_item_${oldId + 1}" name="medicine_item[]"
                                   placeholder="Generic / Brand" value="${medicineItem}" style="border: none;" readonly>
                        ` : ''}
                        <input type="hidden" id="hdn_medicine_item_id_${oldId + 1}" name="hdn_medicine_item_id[]" value="${itemId}">
                        <input type="hidden" id="hdn_report_serial_med_${oldId + 1}" name="hdn_report_serial_med[]" value="1">
                        <input type="hidden" id="hidden_multidose_id_${oldId + 1}" name="multidose[]" value="${med_row.multidose_txt}">
                        ${doseNo > 1 ? `
                            <input type="hidden" class="form-control form-control-sm m-0 p-0 item_element bg-white"
                                   id="medicine_item_${oldId + 1}" name="medicine_item[]"
                                   value="${medicineItem}" readonly>
                            <span class="dose-id-display"
                                  style="color: #262323; background-color: rgba(221, 164, 152, 0.18); padding: 8px 15px;
                                         border-radius: 8px; font-weight: bold; display: inline-block;
                                         width: 98%; font-size: 14px; text-transform: uppercase;">
                                Dose No: ${doseNo}
                            </span>
                        ` : ''}
                    </td>
                    <td class="p-0 border-0" id="alternative_id_${oldId}"></td>
                    <td class="p-0 border-0" id="med_favourit_${oldId}"></td>
                    <td>${selectDoseElement}</td>
                    <td class="p-0 px-1 border-0" hidden>
                        <input type="text" class="form-control form-control-sm m-0 p-0 medicine_quantity"
                               id="medicine_quantity_${oldId}" name="medicine_quantity[]">
                    </td>
                    <td>${route}</td>
                    <td>${instruction}</td>
                    <td><div class="input-group">${duration}</div></td>
                    <td class="p-0 px-1 border-0 text-center">
                        <input type="checkbox" id="is_continue_${oldId}" name="is_continue[]"
                               onchange="prescriptionFunc.setContinueDuration(this)"
                               value="${oldId}" ${data.continue_ind == 1 ? 'checked' : ''}>
                    </td>
                    <td>
                        <span class="btn btn-danger btn-sm" onclick="removeTableRowOnly(this)">
                            <i class="fa fa-times"></i>
                        </span>
                    </td>
                </tr>
            `);
            //  $('#dose_'+(index + 1)).html(selectElement);
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
                            $option.append(` (Qty: ${dataQnty})`);
                        }

                        return $option;
                    }

                    // added new here
            },
            complete: function() {
                // Optional: $.unblockUI();
            }
        });
    }



    function searchMumUhl(thisElement) {
        console.log($(thisElement).val())
        var searchDt = $(thisElement).val();
        $.ajax({
            data: {
                searchDt: searchDt
            },
            url: "{{ url('prescription-mum-search-data-uhl') }}",
            type: 'post',
            beforeSend: function() {
                // blockUI();
            },
            success: function(data) {
                $("#itemData").html(data);
            },
            complete: function() {
                // $.unblockUI();
            }
        });
    }
</script>
