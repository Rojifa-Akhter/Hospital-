<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd.save-consultant-change') }}" method="post" id="consultantchange">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <div class="form-group row">
        <div class="col-md-6">
            <strong>Patient Name:</strong> {{ @$patient_info->patient_name }}
        </div>
        <div class="col-md-6">
            <strong>Consultant Name:</strong> {{ $admission_info->primary_doctor_name }}
        </div>
    </div> <br> <br>

    <div class="form-group mb-0">
        <label class="col-form-label col-form-label-sm">New Consultant<span class="text-danger">*</span></label>
        <input type="text" class="form-control form-control-sm m-0 p-0 item_element  mb-0 resetClass" id="new_cname"
            name="new_cname" placeholder="name" value="" required />
        <input type="hidden" id="h_new_cname" name="h_new_cname" />

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
            <th>Date</th>
            <th><b>Consultant</b></th>
            {{-- <th><b>Department</b></th> --}}
            <th><b>Entry By</b></th>
        </tr>
    </thead>

    <tbody>
        @forelse ($consultant as $item)
            <tr>
                <td>
                    @if (!empty($item->change_date))
                        {{ date('d/m/Y h:i:s A', strtotime($item->change_date)) }}
                    @endif
                </td>
                <td>{{ $item->primary_doctor_name}}</td>
                {{-- <td>{{ $item->doc_dept}}</td> --}}
                <td>{{ $item->user_fullname}}</td>

            </tr>

        @empty
            <tr>
                <td colspan="4" style="text-align: center">Data Not Found !</td>
            </tr>
        @endforelse

    </tbody>

</table>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#new_cname', 'h_new_cname', 'employee_ind', '1');
    openDoctorAutocomplete('#h_pre_doc', 'h_pre_doc', 'employee_ind', '1');
</script>
