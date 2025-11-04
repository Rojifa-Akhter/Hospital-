<div class="row">
    <div class="col-md-12">
        <div class="card">
            <div class="card-header" style="padding-bottom: 0px !important;">
                <ul class="nav nav-pills" id="pills-tab" role="tablist">
                    <li class="nav-item">
                        <a class="nav-link active" id="pills-mum-tab" data-toggle="pill" href="#pills-mum" role="tab"
                            aria-controls="pills-mum" aria-selected="true" data-tab_type="0"
                            onclick="changeTab(this)">Most Used Medicine</a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" id="pills-group-tab" data-toggle="pill" href="#pills-group" role="tab"
                            aria-controls="pills-group" aria-selected="false" data-tab_type="1"
                            onclick="changeTab(this)">Favorite Medicine</a>
                    </li>
                </ul>
            </div>

            <div class="card">
                <div class="card-body">

                    <div class="tab-content" id="pills-tabContent">
                        <div class="tab-pane fade show active" id="pills-mum" role="tabpanel"
                            aria-labelledby="pills-mum-tab">
                            <div class="" id="most_used_medicine">
                                <div class="card">
                                    <div class="card-header">
                                        <div class="row">
                                            <div class="col-md-6">
                                                <h5>Most Used Medicine List List </h5>
                                            </div>
                                            <div class="col-md-6">
                                                <input type="text" class="float-right form-control" name=""
                                                    id="" placeholder="Enter Medicine Name"
                                                    onkeyup="searchMUM(this)" data-input-id="" data-row-id="">
                                            </div>
                                        </div>

                                    </div>

                                    {{-- {{ dd($item_list) }} --}}
                                    <div class="card-body" style="max-height: 350px;overflow:scroll;">
                                        <div class="row" id="itemData">
                                            @include('admin.prescription.most_used_items_data')
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>


                        <div class="tab-pane fade" id="pills-group" role="tabpanel" aria-labelledby="pills-group-tab">
                            <div class="" id="Group">
                                GROUP MUM
                            </div>
                        </div>
                    </div>

                    {{-- <div class="card">
                        <div class="card-header">
                            <h4>R<sub>x</sub></h4>
                        </div> --}}

                    {{-- <div class="card-body">
                            <div class="row">
                                <div class="col-md-12">
                                    <table class="table border-0 mt-2 mb-0">
                                        <thead>
                                            <tr class="border-0">
                                                <th class="p-0 border-0 w-35" colspan="3">Medicine</th>
                                                <th class="p-0 px-1 border-0 w-12">Dose</th>
                                                <th class="p-0 px-1 border-0 w-12">Route</th>
                                                <th class="p-0 px-1 border-0">Instruction</th>
                                                <th class="p-0 px-1 border-0 w-20">Duration</th>
                                                <th class="p-0 px-1 border-0">Continue</th>
                                                <th class="p-0 px-1 border-0"></th>
                                            </tr>
                                        </thead> --}}
                    {{-- <tbody id="presMedicineData">

                                        </tbody> --}}
                    {{-- </table> --}}

                    {{-- <div class="modal-footer mt-1">
                                        <div class="col-md-12 mt-4">
                                            <button type="submit" class="btn btn-md btn-success float-right"
                                                onclick="setMedicine(this)">Set
                                                Medicine</button>
                                        </div>
                                    </div> --}}
                    {{-- </div>
                            </div>
                        </div> --}}

                    {{-- </div> --}}
                </div>

            </div>
        </div>
    </div>

    <script>
        var setMedicines = [];

        function mostUsedItemData(thisElement) {
            $(thisElement).addClass('bg-primary');
            var item_id = $(thisElement).attr('data-alt-id');
            $.ajax({
                data: {
                    item_id: item_id
                },
                url: "{{ url('prescription-most-used-medicine-data') }}",
                type: 'get',
                beforeSend: function() {
                    // blockUI();
                },
                success: function(data) {

                    // $("#presMedicineData").html(data);
                    var oldId = $("#data-append-to tr").length;
                    var dose = $("#doseID").html();
                    var route = $("#routeId").html();
                    var instruction = $("#instructionId").html();
                    var duration = $("#durationId").html();
                    console.log(data)
                    $("#data-append-to").append(
                        `<tr id="tr_id_${oldId}" class="border-0">
                        <td class="p-0 border-0" style="width: 25%;">
                            <input type='text' class="form-control form-control-sm m-0 p-0 item_element text-capitalize"
                                id="medicine_item_${oldId}" name="medicine_item[]"  readonly="readonly" value='${data.generic_name}'/>
                            <input type="hidden" id="hdn_medicine_item_id_${oldId}"
                                            name="hdn_medicine_item_id[]" value="${data.item_no_fk}">
                            <input type="hidden" id="hdn_report_serial_med_${oldId}"
                                            name="hdn_report_serial_med[]" value="${oldId}">
                            <input type="hidden" id="hidden_multidose_id_${oldId}" name="multidose[]" value="">

                        <td class="p-0 border-0" id="alternative_id_${oldId}" style="vertical-align: top;"></td>
                        <td class="p-0 border-0" id="med_favourit_${oldId}" style="vertical-align: top;"></td>
                        <td>${dose}</td><td class="p-0 px-1 border-0" hidden>
                            <input type="text" class="form-control form-control-sm m-0 p-0 medicine_quantity"
                                id="medicine_quantity_${oldId}" name="medicine_quantity[]">
                        </td>
                        <td>${route}</td>
                        <td>${instruction}</td>
                        <td><div class="input-group">${duration}</div></td>
                        <td class="p-0 px-1 border-0 text-center"><input type="checkbox" id="is_continue_${oldId}"
                                                name="is_continue[]"
                                                onchange="prescriptionFunc.setContinueDuration(this)"
                                                value="${oldId}" checked="${data.continue_ind == 1 ? 'checked':''}"></td><td> <span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i
                                                class='fa fa-times'></i> </span></td>
                    </tr>`
                    );

                    $("#tr_id_" + oldId).find('.medicine_dose').val(data.dosage != null ? data.dosage : 0)

                    $("#tr_id_" + oldId).find('.medicine_route').val(data.route != null ? data.route : 0)
                    $("#tr_id_" + oldId).find('.medicine_instruction').val(data.instruction_take != null ? data
                        .instruction_take : 0)
                    $("#tr_id_" + oldId).find('.medicine_duration').val(data.duration != null ? data.duration :
                        0)
                    $("#tr_id_" + oldId).find('.medicine_duration_mu').val(data.duration_mu != null ? data
                        .duration_mu : 'DAY')


                },


                complete: function() {
                    // $.unblockUI();
                }
            });
        }


        function searchMUM(thisElement) {
            console.log($(thisElement).val())
            var searchDt = $(thisElement).val();
            $.ajax({
                data: {
                    searchDt: searchDt
                },
                url: "{{ url('prescription-mum-search-data') }}",
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
