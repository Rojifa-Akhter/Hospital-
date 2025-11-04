<link rel="stylesheet" href="http://localhost/baf-hmis/public/css/typeaheadjs.css">
<div class="form-row justify-content-center">
<div class="col-sm-12 col-lg-5 col-xl-5">
        <div class="card">
            <div class="card-header">
                <h5> Favourite Item</h5>
            </div>
            <div class="card-body">
            <form action="{{ route('favourite-item.favourite-item-store') }}" method="post" id="serviceunit-create">
                @csrf
                <input type="hidden" name="id" value="">
                <div class="form-group row">
                    <label for="service_unit_id" class="col-sm-12 col-form-label col-form-label-sm">Department <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-12">
                        <select class="form-control font_size_12 m-auto" id="department_name" name="department_name"
                            required>
                            <option value="0">Select Department</option>
                            @if(isset($department) && $department->count() > 0 )
                            @foreach($department as $value)
                            <option value="{{$value->su_no_pk}}">
                                {{$value->su_name}}
                            </option>
                            @endforeach
                            @endif
                        </select>
                        <span class="focus_input"></span>
                    </div>

                    <label for="parent_service_unit" class="col-sm-12 col-form-label col-form-label-sm">User
                        Name</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-control-sm" id="doctor_name" name="doctor_name"
                            value="" placeholder="Enter Service Name" required>
                        <input type="hidden" name="doctor_id" id="doctor_id">
                        <span class="focus_input"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="service_name" class="col-sm-12 col-form-label col-form-label-sm">Favourit Type <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-12">
                        <select class="form-control font_size_12 m-auto" id="favourit_type" name="favourit_type"
                            required>
                            <option value="0">Select Favourit Type</option>
                            @if(isset($lookup_id_arr) )
                            @foreach($lookup_id_arr as $key => $value)
                            <option value="{{$key}}">
                                {{$key}}
                            </option>
                            @endforeach
                            @endif
                        </select>
                        <span class="focus_input"></span>
                    </div>

                    <label for="service_report_header" class="col-sm-12 col-form-label col-form-label-sm">Favourit Item
                    </label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-control-sm favourit-item" id="cheif_complaint"
                            name="cheif_complaint" value="" placeholder="Enter Service Name" required>
                        <input type="hidden" name="hdn_item_id" id="hdn_item_id">
                        <input type="hidden" name="hdn_item_name" id="hdn_item_name">
                        <input type="hidden" name="hdn_lookup_id" id="hdn_lookup_id">
                        <input type="hidden" name="hdn_lookup_code" id="hdn_lookup_code">
                        <input type="hidden" name="hdn_lookupdata_code" id="hdn_lookupdata_code">
                        <span class="focus_input"></span>
                    </div>
                </div>

                <div class="form-group row">
                    <label for="service_unit_hod" class="col-sm-12 col-form-label col-form-label-sm">Medicine </label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-control-sm" id="medicine_item_0"
                            name="medicine_item_0" value="" placeholder="medicine item">
                        <input type="hidden" id="hdn_medicine_item_id_0" name="hdn_medicine_item_id" value="">
                        <span class="focus_input"></span>
                    </div>
                </div>
                <div class="form-row">

                    <div class="col-md-4">
                        <label for="status" class="d-block col-form-label col-form-label-sm">Status</label>
                        <div class="form-check form-check-inline">
                            <input class="form-check-input" type="checkbox" name="status" id="status" value="1">
                            <label class="form-check-label" for="status">Active</label>
                        </div>

                    </div>
                </div>

                <div class="modal-footer">
                    @php
                    $response_action = route('favourite-item.favourite-item-table');
                    @endphp
                    <button class="btn btn-success btn-md"
                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                        Save
                    </button>
                    <button type="reset" class="btn btn-info btn-md"
                        title="Click here to Clear form data">Clear</button>
                    <a href="{{ route('dashboard') }}" class="btn btn-danger btn-md" rel="tab"
                        title="Click here to go back to Dashboard">Exit</a>
                </div>
            </form>
            </div>
        </div>

    </div>
</div>
        <script src="http://localhost/baf-hmis/public/js/typeahead.bundle.js"></script>
        <script>
        openDoctorAutocomplete("#doctor_name", "doctor_id");
        openItemAutocomplete($("#medicine_item_0"), 'MED', '#hdn_medicine_item_id_0', '#medicine_item_0');
        $(".favourit-item").typeahead({
            hint: true,
            highlight: true,
            minLength: 3
        }, {
            limit: 'Infinity',
            async: true,
            source: function(query, processSync, processAsync) {
                var lookup_code = $("#favourit_type").val();
                return $.ajax({
                    url: "{{ route('favourite-item.favourite-item-data-autocomplete') }}",
                    type: 'POST',
                    data: {
                        search_data: query,
                        lookup_code: lookup_code
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
                            ' not found.</span></div>');
                    }
                }
            }

        }).bind("typeahead:selected", function(obj, item, name) {

            $("#hdn_item_id").val(item.pres_lookupdata_id);
            $("#hdn_item_name").val(item.pres_lookupdata_name);
            $("#hdn_lookup_id").val(item.pres_lookup_no_pk);
            $("#hdn_lookup_code").val(item.pres_lookup_code);
            $("#hdn_lookupdata_code").val(item.pres_lookupdata_code);

            obj.stopImmediatePropagation();
        });
        </script>