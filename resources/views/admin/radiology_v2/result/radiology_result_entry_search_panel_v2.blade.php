<form id="frmSearch" action="{{ route('radiology.search-result-entry-list-v2') }}" method="POST">

    @csrf
    <input type="hidden" value="VERIFY" name="type" id="type" >
    <input type="hidden" value="{{$type}}" name="typeInput" id="typeInput" >
    <div class="form-row">
        <div class="col-md-2">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm"
                    for="appointment_list_department">Department</label>
                <select class="form-control form-control-sm select2"
                    id="appointment_list_department" name="appointment_list_department"
                    onchange="getRoom(this.value)">
                    <option value="0">Select Department</option>
                    @if (!empty($department))
                        @foreach ($department as $depart)
                            <option value="{{ $depart->serviceunit_no_pk }}">
                                {{ $depart->serviceunit_name }}</option>
                        @endforeach
                    @endif
                </select>
            </div>
        </div>

        {{-- <div class="col-md-2">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm"
                    for="appointment_list_room">Room</label>
                <div id="search_data">
                    <select class="form-control form-control-sm select2" id="appointment_list_room"
                        name="room_no_fk">
                        <option value="0">Select Room</option>
                        @if (!empty($rooms))
                            @foreach ($rooms as $record)
                                <option value="{{ $record->room_no_pk }}">{{ $record->room_name }}
                                </option>
                            @endforeach
                        @endif
                    </select>
                </div>

            </div>
        </div> --}}
        <div class="col-md-4">
            <div class="form-group">
                <label class="col-form-label col-form-label-sm"
                    for="appointment_list_form">Invoice Date</label>
                <div class="input-group">
                    <div class="input-group-prepend">
                        <div class="input-group-text">From</div>
                    </div>
                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                        id="appointment_list_form" name="appointment_list_form"
                        value="" placeholder="From Date">
                    <div class="input-group-prepend">
                        <div class="input-group-text">To</div>
                    </div>
                    <input type="text" class="form-control form-control-sm m-0 date_picker"
                        id="appointment_list_to" name="appointment_list_to"
                        value="" placeholder="To Date">
                </div>
            </div>
        </div>


        <div class="col-md-2">
            <div class="form-group">
                <label for="app_id" class="col-form-label col-form-label-sm">Invoice
                    ID</label>
                <div class="input-group date_picker_range">
                    <input type="text" class="form-control form-control-sm m-0" id="invoice_id"
                        name="invoice_id" maxlength="50" value="" placeholder="Enter Invoice. ID" />
                </div>
            </div>
        </div>

        <div class="col-md-2">
            <div class="form-group">
                <label for="app_id" class="col-form-label col-form-label-sm">UHID</label>
                <div class="input-group date_picker_range">
                    <input type="text" class="form-control form-control-sm"
                    id="uhid" name="uhid" placeholder="Enter UHID." />
                    <input type="hidden" class="form-control" id="hdn_patient_id" name="hdn_patient_id" value="" >
                </div>
            </div>
        </div>

        {{--     <div class="col-md-4">
    <div class="form-group">
        <label class="col-form-label col-form-label-sm" for="image_capture_date_form">Appointment Date</label>
        <div class="input-group">
            <div class="input-group-prepend">
                <div class="input-group-text">From</div>
            </div>
            <input type="text" class="form-control date_picker" style="margin-bottom: 0 !important;" name="appointment_list_form" value="{{ date('d-m-Y')}}">
            <div class="input-group-prepend"><div class="input-group-text">To</div>
        </div>
        <input type="text" class="form-control date_picker" style="margin-bottom: 0 !important;" name="appointment_list_to" value="{{ date('d-m-Y')}}"></div>
    </div>
</div> --}}

        <div class="col-md-2">
            <button type="button" class="btn btn-block btn-success btn-md mt-4 btn-md-global"
                id="btnSearchAppointment">Search
            </button>

        </div>
    </div>
</form>
