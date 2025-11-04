<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd.save-progress-note') }}" method="post" id="progress_notes">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <div class="form-group row">
        <div class="col-md-3">
            <strong> Patient Name </strong>
        </div>
        <div class="col-md-6">: {{ @$patient_info->patient_name }}</div>
        <div class="col-md-3"> <a class="btn btn-md btn-warning" target="_blank"
                href="{{ route('v2.ipd.download-progress-note', [$patient_no_fk, $admission_id]) }}">Export
                PDF</a>
        </div>
    </div>
    <div class="form-group row">
        <div class="col-md-12 ">
            <strong for="progress_notes" class="">Progress Notes</strong>
        </div>
        <div class="col-md-12">
            <textarea id="progress_notes" name="progress_notes" class="form-control" rows="7" placeholder="write here ..."></textarea>
        </div>
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
            <td style="width:50%"><b>Details</b></td>
            <td><b>Name with Emp.ID</b></td>

        </tr>
    </thead>
   
    <tbody>
        @forelse ($progress_notes as $item)
            <tr>
                <td>
                    @if (!empty($item->progress_date))
                        {{ date('d/m/Y h:i:s A', strtotime($item->progress_date)) }}
                    @endif
                </td>
                <td>{{ $item->progress_notes }}</td>
                <td>{{ $item->user_fullname }} ({{ $item->user_code }})</td>

            </tr>
        @empty
            <tr>
                <td colspan="3" class="text-align:center;color:red">Data Not Found</td>
            </tr>
        @endforelse
    </tbody>
</table>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

