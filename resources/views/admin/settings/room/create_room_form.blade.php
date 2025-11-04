@php

    $room = isset($room) && !empty($room) ? $room : [];

    $room_no_pk = $room ? $room->room_no_pk : '';
    $room_code = $room ? $room->room_code : '';
    $room_name = $room ? $room->room_name : '';
    $room_description = $room ? $room->room_description : '';
    $room_capacity = $room ? $room->room_capacity : '';
    $category_lookup = $room ? $room->room_category_lookup_no_fk : '';
    $room_size = $room ? $room->room_size : '';
    $serviceunit_no_fk = $room ? $room->serviceunit_no_fk : '';
    $ipd_ind = $room ? $room->ipd_ind : '';
    $opd_ind = $room ? $room->opd_ind : '';
    $ot_ind = $room ? $room->ot_ind : '';
    $physio_ind = $room ? $room->physio_ind : '';
    $store_location_ind = $room ? $room->store_location_ind : '';
    $open_loction_ind = $room ? $room->open_location_ind : '';
    $status = $room ? $room->status : '';
    $physicalstrucure_no_fk = $room ? $room->physicalstrucure_no_fk : '';
    $asset_location_ind = $room ? $room->asset_location_ind : '';
    $duty_location_ind = $room ? $room->duty_location_ind : '';
@endphp
<div class="row">
    <div class="col-sm-12 col-lg-12 col-xl-12">
        <form action="{{ route('room.store') }}" method="post" id="room-create">
            @csrf
            <input type="hidden" name="id" value="{{ $room_no_pk }}">
            <div class="form-group row">
                <div class="col-md-6">
                    <label for="category_lookup" class="col-sm-12 col-form-label col-form-label-sm">Room Category <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-12">
                        <select class="form-control font_size_12 m-auto" id="category_lookup" name="category_lookup"
                            required>
                            <option selected="selected" value="">Select Room Category</option>
                            @if (isset($category_lookup))
                                @foreach ($category as $key => $value)
                                    <option value="{{ $key }}"
                                        @if ($category_lookup == $key) selected @endif>{{ $value }}</option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="room_code" class="col-sm-12 col-form-label col-form-label-sm">Room Code <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-control-sm" id="room_code" name="room_code"
                            value="{{ $room_code }}" placeholder="Enter Room Code" required>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="room_name" class="col-sm-12 col-form-label col-form-label-sm">Room Name <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-control-sm" id="room_name" name="room_name"
                            value="{{ $room_name }}" placeholder="Enter Room Name" required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="serviceunit_no_fk" class="col-sm-12 col-form-label col-form-label-sm">Service Unit <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-12">
                        <select class="form-control font_size_12 m-auto select2" id="serviceunit_no_fk"
                            name="serviceunit_no_fk" required>
                            <option selected="selected" value="">Select Service Unit</option>
                            @foreach ($service_unit as $record)
                                <option value="{{ $record->serviceunit_no_pk }}"
                                    @if ($serviceunit_no_fk == $record->serviceunit_no_pk) selected @endif>{{ $record->serviceunit_name }}
                                </option>
                            @endforeach
                        </select>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="room_capacity" class="col-sm-12 col-form-label col-form-label-sm">Room Capacity <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-control-sm" id="room_capacity"
                            name="room_capacity" value="{{ $room_capacity }}" placeholder="Enter Room Capacity"
                            required>
                    </div>
                </div>

                <div class="col-md-6">
                    <label for="room_size" class="col-sm-12 col-form-label col-form-label-sm">Room Size <span
                            class="text-danger">*</span></label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-control-sm" id="room_size" name="room_size"
                            value="{{ $room_size }}" placeholder="Enter Room Size" required>
                    </div>
                </div>
            </div>

            <div class="form-group row">
                <div class="col-md-6">
                    <label for="room_description" class="col-sm-12 col-form-label col-form-label-sm">Room
                        Description</label>
                    <div class="col-sm-12">
                        <input type="text" class="form-control form-control-sm" id="room_description"
                            name="room_description" value="{{ $room_description }}"
                            placeholder="Enter Room Description">
                    </div>
                </div>
                <div class="col-md-6">
                    <label for="room_size" class="col-sm-12 col-form-label col-form-label-sm">Floor </label>
                    <div class="col-sm-12">
                        <select class="form-control font_size_12 m-auto select2" id="physicalstruct_no_pk"
                            name="physicalstruct_no_pk" >
                            <option selected="selected" value="">Select Floor</option>
                            @if (!empty($floorWiseRoom))
                                @foreach ($floorWiseRoom as $record)
                                    <option value="{{ $record->physicalstruct_no_pk }}"
                                        @if ($physicalstrucure_no_fk == $record->physicalstruct_no_pk) selected @endif>
                                        {{-- {{ $record->physicalstruct_name_fl_bld }} --}}
                                        {{ $record->physicalstruct_name }} ({{ $record->physicalstruct_desc }}) [{{ $record->physicalstruct_building_no_fk }}]
                                    </option>
                                @endforeach
                            @endif
                        </select>
                    </div>
                </div>



                <div class="col-md-12">
                    <label class="col-sm-12 col-form-label col-form-label-sm">Room Status</label>
                </div>

                <div class="col-md-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="ipd" id="ipd"
                            value="1" {{ $ipd_ind == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ipd">IPD</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="opd" id="opd"
                            value="1" {{ $opd_ind == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="opd">OPD</label>
                    </div>
                </div>
                <div class="col-md-4">
                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="ot" id="ot"
                            value="1" {{ $ot_ind == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="ot">OT</label>
                    </div>
                </div>


                <div class="col-md-4">

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="physio" id="physio"
                            value="1" {{ $physio_ind == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="physio">Physio</label>
                    </div>

                </div>
                <div class="col-md-4">

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="store_location" id="store_location"
                            value="1" {{ $store_location_ind == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="store_location">Store Location</label>
                    </div>

                </div>
                <div class="col-md-4">

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="open_loction" id="open_loction"
                            value="1" {{ $open_loction_ind == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="open_loction">Open Location</label>
                    </div>

                </div>



                <div class="col-md-4">

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="asset_location_ind" id="asset_location_ind"
                            value="1" {{ $asset_location_ind == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="asset_location_ind">Asset Location</label>
                    </div>

                </div>
                <div class="col-md-4">

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name="duty_location_ind" id="duty_location_ind"
                            value="1" {{ $duty_location_ind == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="duty_location_ind">Duty Location</label>
                    </div>

                </div>





                <div class="col-md-12">
                    <label for="status" class="col-sm-12 col-form-label col-form-label-sm">Status</label>

                    <div class="form-check form-check-inline">
                        <input class="form-check-input" type="checkbox" name=" status" id="status"
                            value="1" {{ $status == '1' ? 'checked' : '' }}>
                        <label class="form-check-label" for="status">Active</label>
                    </div>

                </div>
            </div>

            <div class="modal-footer mt-1">
                @php
                    $response_action = url('/room');
                @endphp
                <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button>
                <button type="submit" class="btn btn-sm btn-success"
                    onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save
                    changes</button>
            </div>
        </form>
    </div>
</div>
