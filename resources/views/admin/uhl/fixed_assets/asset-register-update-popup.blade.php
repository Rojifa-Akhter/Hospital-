 <!-- Modal -->
 <link rel="stylesheet" href="{{ asset('asset/timepicker/css/timepicker.css') }}">
 <form action="{{ route('v1.asset_register_update') }}" method="post" id="assetUpdate">
     @csrf
     <div class="form-row">
         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">
                 <label for="asset_id" class="col-sm-1 col-form-label">Asset Id</label>
                 <div class="col-sm-5">
                     <input type="text" class="form-control form-control-sm" id="asset_id" name="asset_id"
                         value="{{ !empty($asset_register_data) ? $asset_register_data->item_no_fk : '' }}" readonly />
                     <input type="hidden" value="{{ $asset_register_data->ast_register_no_pk }}"
                         name="ast_register_no_pk">
                     <input type="hidden" value="{{ $asset_register_data->last_store_su_no_fk }}" name="store_id">
                 </div>
                 <label for="asset_name" class="col-sm-1 col-form-label">Asset Name</label>
                 <div class="col-sm-5">
                     <input type="text" class="form-control form-control-sm" id="asset_name" name="asset_name"
                         value="{{ $asset_register_data->ast_register_name }}" readonly />
                 </div>

             </div>
         </div>

         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">

                 <label for="asset_descrip" class="col-sm-1 col-form-label">Asset Desc.</label>
                 <div class="col-sm-5">
                     {{-- <input type="text" class="form-control form-control-sm" id="asset_descrip" name="asset_descrip"
                        value="{{ !empty($asset_register_data) ? $asset_register_data->item_name : '' }}" readonly /> --}}

                     <input type="text" class="form-control form-control-sm" id="asset_descrip" name="asset_descrip"
                         value="{{ $asset_register_data->refer_item_specification }}" readonly />
                 </div>

                 <label for="brand_name" class="col-sm-1 col-form-label">Brand Name</label>
                 <div class="col-sm-5">
                     <input type="text" class="form-control form-control-sm" id="brand_name" name="brand_name"
                         value="{{ $asset_register_data->asst_brand }}" />
                 </div>
             </div>
         </div>


         <div class="col-lg-12 col-md-12 col-12">
             <div class="form-group form-row">

                 <label for="assign_engr" class="col-sm-1 col-form-label">Assign Engr.</label>
                 <div class="col-sm-5">
                     <input type="text" class="form-control form-control-sm " id="assign_engr" name="assign_engr"
                         value="{{ $asset_register_data->assign_engr_name }}" placeholder="Enter Assign Engr." />
                 </div>
                 <label for="c_number" class="col-sm-1 col-form-label">Contract Number</label>
                 <div class="col-sm-5">
                     <input type="text" class="form-control form-control-sm " id="maintanance_engr_contact" name="maintanance_engr_contact"
                         value="{{ $asset_register_data->maintanance_engr_contact }}" placeholder="Enter Contract Number" />
                 </div>
             </div>
         </div>
         <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="engr_name" class="col-sm-1 col-form-label">2nd Engr. Name</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm  " id="engr_name" name="engr_name"
                        value="{{ $asset_register_data->engineer_name }}" placeholder="Enter Engr. Name" />
                </div>

                <label for="ins_date" class="col-sm-1 col-form-label">Maintenance Date</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm date_picker" id="maintanance_date"
                        name="maintanance_date" value="{{ $asset_register_data->maintanance_date ? date('d-m-Y', strtotime($asset_register_data->maintanance_date)) : "" }}" placeholder="Enter Maintenance Date" />
                </div>
            </div>
        </div>
        <div class="col-lg-12 col-md-12 col-12">
            <div class="form-group form-row">
                <label for="ins_date" class="col-sm-1 col-form-label">Next Maintenance Date</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm date_picker" id="next_maintanance_date"
                        name="next_maintanance_date" value="{{ $asset_register_data->next_maintanance_date ?  date('d-m-Y', strtotime($asset_register_data->next_maintanance_date)) : "" }}" placeholder="Enter Next Maintenance Date" />
                </div>

                <label for="ins_date" class="col-sm-1 col-form-label">Free Support Date</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm date_picker" id="free_support_date"
                        name="free_support_date" value="{{ $asset_register_data->free_support_date ? date('d-m-Y', strtotime($asset_register_data->free_support_date)) : "" }}" placeholder="Enter Free Support Date" />
                </div>
            </div>
        </div>

         <div class="col-lg-12 col-md-12 col-12">

             <div class="form-group form-row">
                 <label for="depreciation_residual_val_pct" class="col-sm-1 col-form-label">Depr. Res.Value(%)</label>
                 <div class="col-sm-5">
                     <input type="number" class="form-control form-control-sm" id="depreciation_residual_val_pct"
                         name="depreciation_residual_val_pct"
                         value="{{ $asset_register_data->depreciation_residual_val_pct }}"
                         placeholder="Depreciation Residual Value Percentage" />
                 </div>

                 <label for="depreciation_residual_val_amt" class="col-sm-1 col-form-label">Depr. Res. Value
                    Amt</label>
                <div class="col-sm-5">
                    <input type="number" class="form-control form-control-sm" id="depreciation_residual_val_amt"
                        name="depreciation_residual_val_amt"
                        value="{{ $asset_register_data->depreciation_residual_val_amt }}"
                        placeholder="Depreciation Residual Value Ammount" />
                </div>
             </div>
             <div class="form-group form-row">
                <input type="hidden" class="form-control form-control-sm" id="last_store_su_no_fk"
                    name="last_store_su_no_fk" value="" />

                <input type="hidden" class="form-control form-control-sm" id="last_room_no_fk" name="last_room_no_fk"
                    value="" />

                <label for="item_model_number" class="col-sm-1 col-form-label">Model No.</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm" id="item_model_number"
                        name="item_model_number" value="{{ $asset_register_data->item_model_number }}"
                        placeholder="Item Model Number" />
                </div>

                <label for="country_of_origin" class="col-sm-1 col-form-label">Country</label>
                <div class="col-sm-5">
                    <select class="form-control form-control-sm select2" id="country_of_origin"
                        name="country_of_origin">
                        <option value="">Select Country</option>
                        <option value="Bangladesh"
                            {{ $asset_register_data->country_of_origin == 'Bangladesh' ? 'selected' : '' }}>Bangladesh
                        </option>
                        <option value="India">India</option>
                        <option value="Pakistan"
                            {{ $asset_register_data->country_of_origin == 'Pakistan' ? 'selected' : '' }}>Pakistan
                        </option>
                        <option value="Nepal"
                            {{ $asset_register_data->country_of_origin == 'Nepal' ? 'selected' : '' }}>Nepal</option>
                        <option value="Srilanka"
                            {{ $asset_register_data->country_of_origin == 'Srilanka' ? 'selected' : '' }}>Srilanka
                        </option>
                        <option value="Japan"
                            {{ $asset_register_data->country_of_origin == 'Japan' ? 'selected' : '' }}>Japan</option>
                        <option value="England"
                            {{ $asset_register_data->country_of_origin == 'England' ? 'selected' : '' }}>England
                        </option>
                        <option value="USA"
                            {{ $asset_register_data->country_of_origin == 'USA' ? 'selected' : '' }}>USA</option>
                    </select>
                </div>
            </div>
             <div class="form-group form-row">

                <label for="item_serial_number" class="col-sm-1 col-form-label">Item Serial No.</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm" id="item_serial_number"
                        name="item_serial_number" value="{{ $asset_register_data->item_serial_number }}"
                        placeholder="Item Serial Number" />
                </div>

                 <label for="usage_status" class="col-sm-1 col-form-label">Usage Status</label>
                 <div class="col-sm-5">
                     <select class="form-control form-control-sm select2" id="usage_status" name="usage_status">
                         <option value="Using">Using</option>
                     </select>
                 </div>
             </div>

             <div class="form-group form-row">
                 <label for="ins_date" class="col-sm-1 col-form-label">Installation Date</label>
                 <div class="col-sm-5">
                     <input type="text" class="form-control form-control-sm date_picker" id="ins_date"
                         name="ins_date" value="{{ $asset_register_data->install_date ? date('d-m-Y', strtotime($asset_register_data->install_date)) : ""}}" placeholder="Enter Installation Date" />
                 </div>
                 <label for="starting_date" class="col-sm-1 col-form-label">Warranty Starting Date</label>
                 <div class="col-sm-5">
                     <input type="text" class="form-control form-control-sm date_picker" id="starting_date"
                         name="starting_date" value="{{ $asset_register_data->warrenty_start_date ? date('d-m-Y', strtotime($asset_register_data->warrenty_start_date)) : "" }}" placeholder="Enter Warranty Starting Date" />
                 </div>
             </div>
             <div class="form-group form-row">
                 <label for="warranty_yr" class="col-sm-1 col-form-label">Warranty(Year)</label>
                 <div class="col-sm-5">
                     <input type="number" class="form-control form-control-sm number_format" id="warranty_yr"
                         name="warranty_yr" value="{{ $asset_register_data->warrany_year }}" placeholder="Enter Warranty Year" />
                 </div>
                 <label for="spare_parts_list" class="col-sm-1 col-form-label">Spare Parts List</label>
                 <div class="col-sm-5">
                     {{-- <input type="text" class="form-control form-control-sm " id="spare_parts_list"
                         name="spare_parts_list" value="{{ $asset_register_data->spare_parts_list }}" placeholder="Enter Spare parts List" /> --}}
                         <textarea class="form-control form-control-sm " id="spare_parts_list"
                         name="spare_parts_list" placeholder="Enter Spare parts List" rows="5">
                            {{ $asset_register_data->spare_parts_list }}
                         </textarea>
                 </div>
             </div>

             <div class="form-group form-row">
                 <label for="L_vendor_name" class="col-sm-1 col-form-label">Vendor Name</label>
                 <div class="col-sm-5">
                     <input type="text" class="form-control form-control-sm " id="L_vendor_name"
                         name="L_vendor_name" value="{{ $asset_register_data->vendor_name }}" placeholder="Enter Vendor Name" />
                 </div>
                 <label for="c_number" class="col-sm-1 col-form-label">Contract Number</label>
                 <div class="col-sm-5">
                     <input type="text" class="form-control form-control-sm " id="c_number" name="c_number"
                         value="{{ $asset_register_data->contact_number }}" placeholder="Enter Contract Number" />
                 </div>
             </div>

             <div class="form-group form-row">
                 <label for="vendor_pm" class="col-sm-1 col-form-label">Vendor PM</label>
                 <div class="col-sm-5">
                     <input type="text" class="form-control form-control-sm " id="vendor_pm" name="vendor_pm"
                         value="{{ $asset_register_data->vendor_pm }}" placeholder="Enter Vendor PM" />
                 </div>

                 <label for="handover_date" class="col-sm-1 col-form-label">Handover Date</label>
                 <div class="col-sm-5">
                     <input type="text" class="form-control form-control-sm date_picker" id="handover_date"
                         name="handover_date" value="{{ isset($asset_register_data->handover_date) ? date('d-m-Y', strtotime($asset_register_data->handover_date)) : '' }}" placeholder="Enter Handover Date" />
                 </div>
             </div>

             <div class="form-group form-row">
                 <label for="breakdown_time" class="col-sm-1 col-form-label">Breakdown Time</label>
                 <div class="col-sm-5">
                     <input type="text" class="form-control form-control-sm  " id="breakdown_time"
                         name="breakdown_time" value="{{ $asset_register_data->breakdown_time }}" placeholder="Enter Breakdown Time" />
                 </div>
                 <label for="training_date" class="col-sm-1 col-form-label">Training Date</label>
                 <div class="col-sm-5">
                     <input type="text" class="form-control form-control-sm date_picker" id="training_date"
                         name="training_date" value="{{ $asset_register_data->training_date ? date('d-m-Y', strtotime($asset_register_data->training_date)) : "" }}" placeholder="Enter Traning Date" />
                 </div>
             </div>

             <div class="form-group form-row">
                 <label for="inhouse_pm_date" class="col-sm-1 col-form-label">Inhouse PM Date</label>
                 <div class="col-sm-5">
                     <input type="text" class="form-control form-control-sm  date_picker" id="inhouse_pm_date"
                         name="inhouse_pm_date" value="{{ $asset_register_data->inhouse_pm_date ? date('d-m-Y', strtotime($asset_register_data->inhouse_pm_date)) : ""}}" placeholder="Enter Inhouse PM Date" />
                 </div>
                 <label for="asset_building" class="col-sm-1 col-form-label">Building </label>
                 <div class="col-sm-5">
                     <select class="form-control form-control-sm select2" id="asset_building" name="asset_building"
                         onchange="assetFunc.setBuildingData(this)" disabled>
                         <option value="">Select Building</option>
                         @if (!empty($building))
                             @foreach ($building as $value)
                                 <option value="{{ $value->physicalstruct_build_no_pk }}"
                                     {{ $asset_register_data->physicalstruct_build_sl == $value->physicalstruct_build_no_pk ? 'selected' : '' }}>
                                     {{ $value->physicalstruct_build_name }}
                                     (<strong>{{ $value->physicalstruct_build_desc }}</strong>)
                                 </option>
                             @endforeach
                         @endif
                     </select>
                 </div>
             </div>

             <div class="form-group form-row">
                <label for="cmc_start_date" class="col-sm-1 col-form-label">CMC Start Date</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm date_picker " id="cmc_start_date"
                        name="cmc_start_date" value="{{ $asset_register_data->cmc_start_date ? date('d-m-Y', strtotime($asset_register_data->cmc_start_date)) : ""}}" placeholder="Enter Start Date" />
                </div>
                 <label for="asset_floor" class="col-sm-1 col-form-label">Floor</label>
                 <div class="col-sm-5" id="asset_f">
                     @include('admin.uhl.fixed_assets.asset_register_floor_edit')
                 </div>


             </div>
             <div class="form-group form-row">
                 <label for="res_person" class="col-sm-1 col-form-label">Res. Person</label>
                 <div class="col-sm-5">
                     <input type="text" class="form-control form-control-sm  " id="res_person" name="res_person"
                         value="{{$asset_register_data->responsible_person}}" placeholder="Enter Res. Person" />
                 </div>
                 <label for="asset_location" class="col-sm-1 col-form-label">Location</label>
                 <div class="col-sm-5" id="asset_f">
                     @include('admin.uhl.fixed_assets.asset_register_location_edit')
                 </div>
             </div>
             <div class="form-group form-row">
                <label for="licenance_number" class="col-sm-1 col-form-label">License Number</label>
                <div class="col-sm-5">
                    <input type="text" class="form-control form-control-sm  " id="licenance_number" name="licenance_number"
                        value="{{$asset_register_data->licenance_number}}" placeholder="Enter Res. Person" />
                </div>
            </div>

         </div>

         @php
             $redirect_url = route('v1.asset-register');

         @endphp
         <button type="submit" class="btn btn-primary uhl_save_btn mr-2"
             onclick="btnSaveUpdate(this,'','','','', assetsSearchFunc,'{{ $redirect_url }}')">Save </button>
         <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
 </form>

 <script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
 <script>
     $("body").addClass("sidebar-collapse");
     $('.select2').select2();
     $('.date_picker').datepicker({
         todayHighlight: true,
         clearBtn: true,
         autoclose: true,
         startDate: '+0d',
         format: 'dd-mm-yyyy'
     });
     $('#breakdown_time').timepicker({
         // showInputs: false,
         // showMeridian: false,
         // setTime: null

     });

     var assetFunc = {
         setBuildingData: function(thisElement) {
             var building = $(thisElement).val();
             var id = $("input[name='ast_register_no_pk']").val();
             $.ajax({
                 url: "{{ route('v1.building-floor-list-edit') }}",
                 type: 'POST',
                 data: {
                     building: building,
                     id: id
                 },
                 beforeSend: function() {
                     blockUI();
                 },
                 success: function(data) {
                     $('#asset_f').html(data);
                 },
                 complete: function() {
                     $.unblockUI();
                 }
             });
         },
         setLocationData: function(thisElement) {
             var location = $(thisElement).val();
             var id = $("input[name='ast_register_no_pk']").val();

             $.ajax({
                 url: "{{ route('v1.building-location-list-edit') }}",
                 type: 'POST',
                 data: {
                     location: location,
                     id: id
                 },
                 beforeSend: function() {
                     blockUI();
                 },
                 success: function(location_Data) {
                     console.log(location_Data)
                     $('#asset_loc').html(location_Data);
                 },
                 complete: function() {
                     $.unblockUI();
                 }
             });
         }
     }
 </script>
