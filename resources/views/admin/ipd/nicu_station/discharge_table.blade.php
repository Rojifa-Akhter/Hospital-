<form action="{{ route('ipd.nicu-notes-store') }}" method="post" id="discharge_notes_id">@csrf
    <input type="hidden" id="hdn_patient_no_fk" name="hdn_patient_no_fk"
    value="{{ $patient_info->patient_no_pk }}">
    <input type="hidden" id="hdn_admission_no_pk" name="hdn_admission_no_pk"
        value="{{ $patient_info->admission_no_pk }}">
    <input type="hidden" id="hdn_admission_uid" name="hdn_admission_uid"
        value="{{ $patient_info->admission_uid }}">
    <input type="hidden" id="nicu_chart_type" name="nicu_chart_type"
    value="discharge">
    <div class="form-row border-bottom pb-3">
        <div class="col-md-12">
            <div class="form-group mb-0">
                <label for="plan" class="col-form-label col-form-label-sm">Discharge Notes
                </label>
                <textarea class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass" name="notes" id="notes"
                    rows="10"></textarea>

            </div>
        </div>
    </div>
    <div class="m-0 mt-3 mb-2 mr-2 text-right mb-4">
        @php
            $patient_no_pk = $patient_info->patient_no_pk;
            $admission_no_pk = $patient_info->admission_no_pk;
            $response_url_page = route('ipd.nicu-station-patient-notes', [$patient_no_pk, $admission_no_pk]);

        @endphp

        <button
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_url_page }}')"
            type="button" class="btn btn-success btn-md"><i
                class="fa fa-save"></i>
            Save</button>
        {{-- <button type="reset" class="btn btn-info btn-sm"
            title="Click here to Clear form data">Clear</button> --}}
    </div>
</form>
<div class="card border-0 shadow-xs mt-0">
    <div class="card-header"><h5>Discharge Note List</h5></div>
    <div class="card-body card-collapse-body mt-0">
        <table class="table border table-striped table-bordered table-hover mb-0">
            <thead>
                <tr>
                    <th class="text-left" style="width: 5%">SN#</th>
                    <th class="text-left" style="width: 15%">Date</th>
                    <th class="text-left" style="width: 15%">Time</th>
                    <th class="text-left">Notes</th>
                    <th class="text-left" style="width: 13%">Action</th>
                </tr>
            </thead>
            <tbody>
                @if(!empty($nicuDischargeData))
                    @foreach($nicuDischargeData as $data)
                    <tr>
                        <td class="text-left">{{ $loop->iteration}}</td>
                        <td class="text-left">{{ !empty($data->au_entry_at) ? date('d/m/Y', strtotime($data->au_entry_at)): '' }}</td>
                        <td class="text-left">{{ !empty($data->au_entry_at) ? date('h:i:s a', strtotime($data->au_entry_at)): '' }}</td>
                        <td class="text-left">{{ !empty($data->notes)? $data->notes : '' }}</td>
                        <td class="text-left">  <button title="Receive the Patient" type="button" nicu_no_pk="{{ $data->nicu_no_pk }}" class="btn btn-danger btn-sm nicu-btn" data-url="{{ route('ipd.nicu-station-patient-notes', [$patient_no_pk, $admission_no_pk]) }}">Delete</button>
                        <button  type="button" class="btn btn-sm btn-outline-success mb-1 mt-1 open-modal" data-action="{{ route('ipd.nicu-notes-edit',$data->nicu_no_pk) }}" data-id="{{ $data->nicu_no_pk }}" data-modal="common-modal-xl" data-title="Discharge Notes"  title="Edit">Edit</button>
                        <a href="{{route("ipd.nicu-notes-print", $data->nicu_no_pk)}}"
                            class="btn btn-success btn-sm cursor-pointer"
                            target="_blank"
                            title="Print"><i class="fa fa-tag"></i>
                            Print</a>
                        </td>
                    </tr>
                    @endforeach
                @else
                    <td class="" colspan="2">No Data Found</td>
                @endif
            </tbody>
        </table>
    </div>
</div>
