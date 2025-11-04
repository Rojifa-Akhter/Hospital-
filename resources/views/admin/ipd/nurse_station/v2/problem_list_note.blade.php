<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd.save-problem-list-note') }}" method="post" id="followup_notes">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">



    <div class="form-group row">
        <div class="col-md-4 ">
            <strong> Patient Name </strong>
        </div>
        <div class="col-md-5">: {{ @$patient_info->patient_name }}</div>
        <div class="col-md-3"> <a class="btn btn-md btn-warning" target="_blank"
                href="{{ route('ipd.problem-list-notes-pdf', [$patient_no_fk, $admission_id]) }}">Export PDF</a>
        </div>
    </div>


    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="notes" class="">Problem List</strong>
        </div>
        <div class="col-md-12">
            <textarea id="notes" name="notes" class="form-control" rows="7" placeholder="write here ..."></textarea>
        </div>
    </div>
    <div class="form-group mb-0">
        <label for="doctor_name_0" class="col-form-label col-form-label-sm">Noted By<span
                class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass"
            id="visitby" name="visitby" placeholder="name" value="" required />
        <input type="hidden" id="h_visitby" name="h_visitby" />
    </div>

    <div class="modal-footer">
        @php
            $response_action = route('v2.ipd.nurse-note', $admission_id);
        @endphp
        <button class="btn btn-success btn-md"
            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
        <button type="reset" class="btn btn-info btn-md" title="Click here to Clear form data">Clear</button>
    </div>
</form>



<table class="table table-striped table-bordered table-hover">
    <thead class="global-uhl-table-bg">
        <tr>
            <td style="width:23%"><b>Date & Time</b></td>
            <td style="width:50%"><b>Problem List</b></td>
            <td><b>Noted By</b></td>
            <td><b>Entry By</b></td>

        </tr>
    </thead>
    <tbody>
        @forelse ($follow_notes as $item)
            <tr>
                <td>
                    @if (!empty($item->followup_date))
                        {{ date('d/m/Y h:i:s A', strtotime($item->followup_date)) }}
                    @endif
                </td>
                <td>{{ $item->followup_notes }}</td>
                <td>{{ $item->visitby }}</td>
                 <td>{{$item->user_fullname}}</td>

            </tr>
        @empty
            <tr>
                <td colspan="4" class="text-align:center;color:red">Data Not Found</td>
            </tr>
        @endforelse
    </tbody>
</table>


<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    openDoctorAutocomplete('#visitby', 'h_visitby', 'employee_ind', '1');
</script>
