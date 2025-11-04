  <!-- Modal- Transfer-->
  <link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
  <link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
  <div class="card">
      <div class="card-body">
          <div class="transfer__req">
              <div class="list__box">
                  <div class="row">
                      <div class="col-md-5">
                          <span>Asset Tag</span>
                      </div>
                      <div class="col-md-7">
                          <span>{{ !empty($register_info->asset_tag_uid) ? $register_info->asset_tag_uid : '' }}</span>
                      </div>
                  </div>
              </div>

              <div class="list__box">
                  <div class="row">
                      <div class="col-md-5">
                          <span>Asset ID</span>
                      </div>
                      <div class="col-md-7">
                          <span>{{ !empty($register_info->item_no_fk) ? $register_info->item_no_fk : '' }}</span>
                      </div>
                  </div>
              </div>


              <div class="list__box">
                  <div class="row">
                      <div class="col-md-5">
                          <span>Asset Description</span>
                      </div>
                      <div class="col-md-7">
                          <span>{{ !empty($register_info->item_name) ? $register_info->item_name : '' }}</span>
                      </div>
                  </div>
              </div>

          </div>
      </div>
  </div>
  {{-- current location start --}}
  <div class="card">
      <div class="card-header">
          <h5>Current Location Detail</h5>
      </div>
      <div class="card-body">
          <div class="transfer__req">
              <div class="list__box">
                  <div class="row">
                      <div class="col-md-5">
                          <span>Floor/Building</span>
                      </div>
                      <div class="col-md-7">
                          <span>{{ !empty($location_info->physicalstruct_name_fl_bld) ? $location_info->physicalstruct_name_fl_bld : '' }}</span>
                      </div>
                  </div>
              </div>
              <div class="list__box">
                  <div class="row">
                      <div class="col-md-5">
                          <span>Location</span>
                      </div>
                      <div class="col-md-7">
                          <span>{{ !empty($location_info->current_room) ? $location_info->current_room : '' }}</span>
                      </div>
                  </div>
              </div>


              <div class="list__box">
                  <div class="row">
                      <div class="col-md-5">
                          <span>Serial No.</span>
                      </div>
                      <div class="col-md-7">
                          <span>{{ !empty($location_info->item_serial_number) ? $location_info->item_serial_number : '' }}</span>
                      </div>
                  </div>
              </div>

              <div class="list__box">
                <div class="row">
                    <div class="col-md-5">
                        <span>Person Incharge</span>
                    </div>
                    <div class="col-md-7">
                        <span>{{ !empty($location_info->full_name) ? $location_info->full_name : '' }}</span>
                    </div>
                </div>
            </div>
              <div class="list__box">
                  <div class="row">
                      <div class="col-md-5">
                          <span>Department</span>
                      </div>
                      <div class="col-md-7">
                          <span>{{ !empty($location_info->person_department) ? $location_info->person_department : '' }}</span>
                      </div>
                  </div>
              </div>

          </div>
      </div>
  </div>
  {{-- current location end --}}
  <form action="{{ route('v1.save_transfer') }}" method="post" id="createTransfer">
      @csrf
      <input type="hidden" name="register_no"
          value="{{ !empty($register_info->ast_register_no_pk) ? $register_info->ast_register_no_pk : '' }}">
      <input type="hidden" name="item_no"
          value="{{ !empty($register_info->item_no_fk) ? $register_info->item_no_fk : '' }}">
      <input type="hidden" name="tag_no"
          value="{{ !empty($register_info->asset_tag_uid) ? $register_info->asset_tag_uid : '' }}">

      <input type="hidden" name="current_room"
          value="{{ !empty($register_info->curr_room_no_fk) ? $register_info->curr_room_no_fk : '' }}">
      <input type="hidden" name="current_store"
          value="{{ !empty($register_info->curr_store_su_no_fk) ? $register_info->curr_store_su_no_fk : '' }}">
      <input type="hidden" name="main_store"
          value="{{ !empty($register_info->main_store_su_no_fk) ? $register_info->main_store_su_no_fk : '' }}">
      <input type="hidden" name="module_no"
          value="{{ !empty($register_info->module_no_fk) ? $register_info->module_no_fk : '' }}">
      <input type="hidden" name="receivedtl_no" value="{{ !empty($receivedtl_id) ? $receivedtl_id : '' }}">
      {{-- Transfer To start --}}
      <div class="card">
          <div class="card-header">
              <h5>Transfer To</h5>
          </div>
          <div class="card-body">
              <div class="form-row">
                  <div class="col-lg-12 col-md-12 col-12">
                      <div class="form-group form-row">
                          <label for="asset_building" class="col-sm-4 col-form-label">Building <span
                                  class="text-danger">*</span></label>
                          <div class="col-sm-8">
                              <select class="form-control form-control-sm select2" id="asset_building"
                                  name="asset_building" onchange="assetFunc.setBuildingData(this)" required>
                                  <option value="">Select Building</option>
                                  @if (!empty($building))
                                      @foreach ($building as $value)
                                          <option value="{{ $value->physicalstruct_build_no_pk }}">
                                              {{ $value->physicalstruct_build_name }}
                                              (<strong>{{ $value->physicalstruct_build_desc }}</strong>)
                                          </option>
                                      @endforeach
                                  @endif
                              </select>
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-12">
                      <div class="form-group form-row">
                          <label for="asset_floor" class="col-sm-4 col-form-label">Floor <span
                                  class="text-danger">*</span></label>
                          <div class="col-sm-8" id="asset_f">
                              @include('admin.uhl.fixed_assets.asset_register_floor')
                          </div>
                      </div>
                  </div>
                  <div class="col-lg-12 col-md-12 col-12">
                      <div class="form-group form-row">
                          <label for="asset_location" class="col-sm-4 col-form-label">Location <span
                                  class="text-danger">*</span></label>
                          <div class="col-sm-8" id="asset_loc">
                            @include('admin.uhl.fixed_assets.asset_register_location')
                          </div>
                      </div>
                  </div>

                  {{-- <div class="col-lg-12 col-md-12 col-12">
                      <div class="form-group form-row">
                          <label for="asset_store" class="col-sm-4 col-form-label">Store <span
                                  class="text-danger">*</span></label>
                          <div class="col-sm-8">
                              <select class="form-control form-control-sm select2" id="hdn_asset_store"
                                  name="hdn_asset_store" required>
                                  <option value="">Select Department</option>
                                  @if (!empty($department))
                                      @foreach ($department as $value)
                                          <option value="{{ $value->serviceunit_no_pk }}">
                                              {{ $value->serviceunit_name }}</option>
                                      @endforeach
                                  @endif
                              </select>

                          </div>
                      </div>
                  </div> --}}


                  <div class="col-lg-12 col-md-12 col-12">
                      <div class="form-group form-row">
                          <label for="person_in" class="col-sm-4 col-form-label">Person Incharge <span
                                  class="text-danger">*</span></label>
                          <div class="col-sm-8">
                              <input type="text" class="form-control form-control-sm" id="person_in"
                                  name="person_in" placeholder="" required />
                              <input type="hidden" id="hdn_person_id" name="hdn_person_id" value="">
                          </div>
                      </div>
                  </div>

                  <div class="col-lg-12 col-md-12 col-12">
                    <div class="form-group form-row">
                        <label for="manual_tag" class="col-sm-4 col-form-label">Manual Tag </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="manual_tag"
                                name="manual_tag" placeholder="Enter Manual Tag"  />
                        </div>
                    </div>
                </div>
                <div class="col-lg-12 col-md-12 col-12">
                    <div class="form-group form-row">
                        <label for="sl_no" class="col-sm-4 col-form-label">Serial No. </label>
                        <div class="col-sm-8">
                            <input type="text" class="form-control form-control-sm" id="sl_no"
                                name="sl_no" placeholder="Enter Serial No."  />
                        </div>
                    </div>
                </div>

                  <div class="col-lg-12 col-md-12 col-12">
                      <div class="form-group form-row">
                          <label for="asset_deprt" class="col-sm-4 col-form-label">Department </label>
                          <div class="col-sm-8" id="department">


                          </div>
                      </div>
                  </div>

              </div>
          </div>
      </div>
      @php
          $redirect_url = route('v1.asset-register');

      @endphp
      {{-- Transfer To end --}}
      <button type="button" class="btn btn-primary uhl_save_btn"
          onclick="btnSaveUpdate(this,'','','','', assetsSearchFunc,'{{ $redirect_url }}')">Save</button>
      <button type="button" class="btn btn-danger" data-dismiss="modal">Cancel</button>
  </form>
  <script src="{{ asset('js/typeahead.bundle.js') }}"></script>

  <script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js')}}"></script>
  <script>
      $('.select2').select2({});

      openDoctorAutocomplete('#person_in', 'hdn_person_id', 'employee_ind', '1', department);

      function department(item, obj) {
          $('#department').html(item.su_name);
      }


      var assetFunc = {
          setBuildingData: function(thisElement) {
              var building = $(thisElement).val();

              $.ajax({
                  url: "{{ route('v1.building-floor-list') }}",
                  type: 'POST',
                  data: {
                      building: building
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

              $.ajax({
                  url: "{{ route('v1.building-location-list') }}",
                  type: 'POST',
                  data: {
                      location: location
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
