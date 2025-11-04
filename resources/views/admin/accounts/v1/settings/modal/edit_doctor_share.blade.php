
<form action="{{ route('v1.accounts.update-doctor-share') }}" method="post" id="updateDoctorShare"
    class="updateDoctorShare">
    @csrf
    <input type="hidden" name="doctorfeemst_no_pk" value="{{ $data->doctorfeemst_no_pk }}"> {{-- Hidden PK for update --}}

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    <div class="form-row">
                        {{-- Doctor Name --}}
                        <div class="col-md-12 col-12 px-0 py-0">
                            <div class="col-12">
                                <div class="form-group form-row">
                                    <label for="doctor_name" class="col-sm-4 col-form-label">Doctor Name<span
                                            style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="text" class="form-control form-control-sm" id="doctor_name_m"
                                            name="doctor_name_m" value="{{ $data->full_name ?? '' }}"
                                            placeholder="Doctor Name" required />
                                        <input type="hidden" name="hdn_doctor_id_m" id="hdn_doctor_id"
                                            value="{{ $data->person_no_fk }}">
                                    </div>
                                </div>
                            </div>

                            {{-- Item Type --}}
                            <div class="col-12">
                                <div class="form-group form-row">
                                    <label for="itemtype_no_fk" class="col-sm-4 col-form-label">Item Type<span
                                            style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <select class="form-control form-control-sm select2" id="itemtype_no_fk"
                                            name="itemtype_no_fk" required>
                                            <option value="">Select Item Type</option>
                                            @if (isset($item_type))
                                                @foreach ($item_type as $val)
                                                    <option value="{{ $val->itemtype_no_pk }}"
                                                        {{ $val->itemtype_no_pk == $data->itemtype_no_fk ? 'selected' : '' }}>
                                                        {{ ucwords(strtolower($val->item_type_name)) }}
                                                    </option>
                                                @endforeach
                                            @endif
                                        </select>
                                    </div>
                                </div>
                            </div>

                            {{-- Share % --}}
                            <div class="col-12">
                                <div class="form-group form-row">
                                    <label for="share_per" class="col-sm-4 col-form-label">Share %<span
                                            style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="number" class="form-control form-control-sm" id="share_per"
                                            name="share_per" value="{{ $data->share_per }}" placeholder="%"
                                            min="0" max="100" required />
                                    </div>
                                </div>
                            </div>
                            {{-- Start Date --}}
                            <div class="col-12">
                                <div class="form-group form-row">
                                    <label for="start_date" class="col-sm-4 col-form-label">Start Date<span
                                            style="color:red">*</span></label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control form-control-sm" id="start_date"
                                            name="start_date"
                                            value="{{ isset($data->start_date) ? \Carbon\Carbon::parse($data->start_date)->format('Y-m-d') : '' }}"
                                            required />
                                    </div>
                                </div>
                            </div>

                            {{-- End Date --}}
                            {{-- <div class="col-12">
                                <div class="form-group form-row">
                                    <label for="end_date" class="col-sm-4 col-form-label">End Date</label>
                                    <div class="col-sm-8">
                                        <input type="date" class="form-control form-control-sm" id="end_date"
                                            name="end_date"
                                            value="{{ isset($data->end_date) ? \Carbon\Carbon::parse($data->end_date)->format('Y-m-d') : '' }}" />
                                    </div>
                                </div>
                            </div> --}}

                            {{-- Status --}}
                            <div class="col-12">
                                <div class="form-group form-row">
                                    <label for="status" class="col-sm-4 col-form-label">Status</label>
                                    <div class="col-sm-8">
                                        <label>
                                            <input type="checkbox" value="1" id="status" name="status"
                                                {{ $data->status == 1 ? 'checked' : '' }} />
                                        </label>
                                    </div>
                                </div>
                            </div>
                        </div>


                    </div>
                </div>
            </div>
        </div>
    </div>

    @php
        $redirect_url = route('v1.accounts.doctor-share');
    @endphp

    {{-- <div class="text-center">
    <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
        onclick="btnSaveUpdate(this,'','','','',getAccountsType,'{{ $redirect_url }}')">Save</button>
    <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
</div> --}}

    {{-- Buttons --}}
    <div class="row">
        <div class="col-md-12">
            <div class="card mb-2">
                <div class="card-body text-center">
                    <button type="submit" class="btn btn-primary uhl_save_btn mt-3"
                        onclick="btnSaveUpdate(this,'','','','',getDoctorShare,'{{ $redirect_url }}')">Save</button>
                    <button type="button" class="btn btn-danger mt-3" data-dismiss="modal">Close</button>
                </div>
            </div>
        </div>
    </div>
</form>
<script>
    openDoctorAutocomplete('#doctor_name_m', 'hdn_doctor_id_m', 'doctor_ind', '1,2');
    $(document).ready(function() {
        $('.select2').select2();

        $("#updateDoctorShare").validate({
            rules: {
                doctor_name: {
                    required: true
                },
                itemtype_no_fk: {
                    required: true
                },
                share_per: {
                    min: 0,
                    max: 100
                }
            },
            messages: {
                doctor_name: {
                    required: "Doctor Name Required"
                },
                itemtype_no_fk: {
                    required: "Item Type Required"
                },
                share_per: {
                    required: "Share % between 0 and 100"
                }
            }
        });
    });
</script>
