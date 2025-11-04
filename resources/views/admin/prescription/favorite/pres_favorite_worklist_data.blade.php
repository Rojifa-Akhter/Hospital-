<div class="row">
    <div class="col-sm-12 col-lg-5 col-xl-12">
        <form action="{{ route('prescription.favorite-add-medicine') }}" method="post" id="medicine-create">
            @csrf

            <table style="width: 100%;border:1px solid antiquewhite">
                <thead>
                    <tr>
                        <td colspan="6" class="text-left">
                            <h5><strong> Add New Medicine Favorite</strong></h5>
                        </td>
                    </tr>
                    <tr>
                        <td><label for="item_name" class="col-sm-12 col-form-label col-form-label-sm">Item Name <span
                                    class="text-danger">*</span></label></td>
                        <td><label for="route" class="col-sm-12 col-form-label col-form-label-sm">Route</label></td>
                        <td><label for="dose" class="col-sm-12 col-form-label col-form-label-sm">Dose</label></td>
                        <td><label for="duration" class="col-sm-12 col-form-label col-form-label-sm">Duration</label>
                        </td>
                        <td><label for="instruction"
                                class="col-sm-12 col-form-label col-form-label-sm">Instruction</label></td>
                        <td><label for="action" class="col-sm-12 col-form-label col-form-label-sm">Action</label></td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="text" class="form-control item_typehead input_dissabled"
                                placeholder="Search Item by Barcode No/Item Code/ Item Name" aria-label="item_typehead"
                                aria-describedby="item_typehead" name="item_name">
                            <input type="hidden" name="hdn_medicine_item_id_0" id="hdn_medicine_item_id_0">
                            <input type="hidden" name="hdn_doctor_id_med" id="hdn_doctor_id_med"
                                value="{{ !empty($prescription_med_data[0]->user_no_fk) ? $prescription_med_data[0]->user_no_fk : '' }}">
                            {{-- <input type="text" class="form-control form-control-sm required" id="item_name"
                                name="item_name" value="" placeholder="Enter Item Name" required></td> --}}
                        <td><input type="text" class="form-control form-control-sm" id="route" name="route"
                                value="" placeholder="Enter Route"></td>
                        <td><input type="text" class="form-control form-control-sm" id="dose" name="dose"
                                value="" placeholder="Enter Dose"></td>
                        <td><input type="text" class="form-control form-control-sm" id="duration" name="duration"
                                value="" placeholder="Enter Duration"></td>
                        <td><input type="text" class="form-control form-control-sm" id="instruction"
                                name="instruction" value="" placeholder="Enter Instruction"></td>
                        <td>

                            @php
                                $response_action = route('prescription-favorite-worklist');
                            @endphp



                            <button type="submit"
                                class="btn btn-md btn-success"onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Add
                                Favorite</button>

                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
<br>



<table id="datatable" class="table table-bordered table-hover table-striped data-table">
    <thead class="bg-primary">
        <tr>
            <th class="text-center" scope="col">Sl#</th>
            <th class="text-left" scope="col">Item No</th>
            <th class="text-left" scope="col">Item Name</th>
            <th class="text-left" scope="col">Route</th>
            <th class="text-left" scope="col">Dose</th>
            <th class="text-center" scope="col">Duration</th>
            <th class="text-center" scope="col">Action</th>
        </tr>
    </thead>
    <tbody id="pres_favorite_data">
        @if (!empty($prescription_med_data))
            @foreach ($prescription_med_data as $value)
                @if ($value->item_type_lookup_code == 'MED')
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">
                            {{ !empty($value->favourite_item_no_fk) ? $value->favourite_item_no_fk : '' }}</td>
                        <td class="text-left">{{ !empty($value->favourite_name) ? $value->favourite_name : '' }}</td>
                        <td class="text-left">{{ !empty($value->route) ? $value->route : '' }}</td>
                        <td class="text-left">{{ !empty($value->med_instruction) ? $value->med_instruction : '' }}</td>
                        <td class="text-left">
                            {{ !empty($value->duration) ? $value->duration . '(' . $value->duration_mu . ')' : '' }}
                        </td>
                        <td class="text-left">

                        </td>
                    </tr>
                @endif
            @endforeach
        @else
            <tr>
                <td colspan="5" class="text-center">No Data Found</td>
            </tr>
        @endif
    </tbody>
</table>

<br>

<div class="row">
    <div class="col-sm-12 col-lg-5 col-xl-12">
        <form action="{{ route('prescription.favorite-add-service') }}" method="post" id="others-create">
            @csrf

            <table style="width: 100%;border:1px solid antiquewhite">
                <thead>
                    <tr>
                        <td colspan="3" class="text-left">
                            <h5><strong> Add New Others Favorite</strong></h5>
                        </td>
                    </tr>
                    <tr>
                        <td style="width: 300px;"><label for="item_name"
                                class="col-sm-12 col-form-label col-form-label-sm">Item Type <span
                                    class="text-danger">*</span></label></td>
                        <td style="width: 1130px;"><label for="description"
                                class="col-sm-12 col-form-label col-form-label-sm">Description</label>
                        </td>
                        <td><label for="action" class="col-sm-12 col-form-label col-form-label-sm">Action</label>
                        </td>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td>
                            <input type="hidden" name="hdn_doctor_id_oth" id="hdn_doctor_id_oth"
                                value="{{ !empty($prescription_med_data[0]->user_no_fk) ? $prescription_med_data[0]->user_no_fk : '' }}">



                            {{-- <input type="text" class="form-control form-control-sm required" id="type"
                                name="type" value="" placeholder="Enter Item Type" required> --}}
                            <select class="form-control font_size_12 m-auto  required " id="item_type"
                                name="item_type" required>
                                <option selected="selected" value="" disabled>Select Item Type</option>
                                <option value="RAD">Radiology</option>
                                <option value="LAB">Pathology</option>
                                <option value="INVFIND">Investigation Findings</option>
                                <option value="ADVICE">Advice</option>
                            </select>

                        </td>
                        <td><input type="text" class="form-control form-control-sm item_class"
                                id="description" name="description" value="" placeholder="Enter Description">
                        </td>
                        <td>
                            <input type="hidden" name="hdn_medicine_item_id_0_lab" id="hdn_medicine_item_id_0_lab">
                            @php
                                $response_action = route('prescription-favorite-worklist');
                            @endphp



                            <button type="submit"
                                class="btn btn-md btn-success"onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Add
                                Favorite</button>

                        </td>
                    </tr>
                </tbody>
            </table>
        </form>
    </div>
</div>
<br>
<table id="datatable" class="table table-bordered table-hover table-striped data-table">
    <thead class="bg-primary">
        <tr>
            <th class="text-center" scope="col">Sl#</th>
            <th class="text-left" scope="col">Item no</th>
            <th class="text-left" scope="col">Description</th>
            <th class="text-left" scope="col">Type</th>
            <th class="text-center" scope="col">Action</th>
        </tr>
    </thead>
    <tbody id="pres_favorite_data">
        @if (!empty($prescription_med_data))
            @foreach ($prescription_med_data as $value)
                @if ($value->item_type_lookup_code != 'MED')
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-left">
                            {{ !empty($value->favourite_item_no_fk) ? $value->favourite_item_no_fk : '' }}</td>
                        <td class="text-left">{{ !empty($value->favourite_name) ? $value->favourite_name : '' }}</td>
                        <td class="text-left">
                            {{ !empty($value->item_type_lookup_code) ? $value->item_type_lookup_code : '' }}</td>
                        <td class="text-left">

                        </td>
                    </tr>
                @endif
            @endforeach
        @else
            <tr>
                <td colspan="5" class="text-center">No Data Found</td>
            </tr>
        @endif
    </tbody>
</table>
<script>
    openItemAutocomplete(".item_typehead", "MED,LIQ,TAB", '#hdn_medicine_item_id_0');
    openItemAutocomplete(".item_class", "LAB,RAD,SER", '#hdn_medicine_item_id_0_lab');

    //immunization
    function addMedicine(thisElement) {
        event.preventDefault();
        var patient_id = $("#hdn_patient_id").val();
        if (patient_id == "") {
            $('.common-modal-notify-error').modal('show');
            $('.common-modal-notify-error .modal-title').html("Validation Error");
            $('.common-modal-notify-error .modal-body').html("You did not select any Patient.");
        } else {
            var formID = $(thisElement).parents("form").attr("id");
            var formAction = $(thisElement).parents("form").attr("action");
            var formMethod = $(thisElement).parents("form").attr("method");

            var equipment_name = $("#equipment_name").val();
            var date_of_engage = $("#date_of_engage").val();
            var discharge_date = $("#date_of_discharge").val();
            var start_time_of_engage = $("#start_time_of_engage").val();
            var end_time_of_engage = $("#end_time_of_engage").val();
            if (confirm("Are You Sure?")) {
                $.ajax({
                    async: true,
                    data: $('#' + formID).serialize(),
                    url: formAction,
                    type: formMethod,
                    beforeSend: function() {
                        blockUI();
                    },
                    success: function(data) {
                        var sl = $("#current_table tr").length;
                        var action_btn = $("#current_equiment_container").append(
                            "<tr><td class='text-center'>" + sl +
                            "</td><td class='text-center'>" + equipment_name +
                            "</td><td class='text-center'>" + date_of_engage +
                            "</td><td class='text-center'>" + start_time_of_engage +
                            "</td><td class='text-center'>" + discharge_date +
                            "</td><td class='text-center'>" + end_time_of_engage +
                            "</td></tr>");

                        $("#" + formID).find("input, textarea").not('.keep_me').val("");

                    },
                    complete: function() {
                        $.unblockUI();
                    }
                });


            }
        }
        event.stopImmediatePropagation();
    }
</script>
