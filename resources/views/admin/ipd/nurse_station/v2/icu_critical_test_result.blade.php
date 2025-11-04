<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('save-icu-critical-test-result') }}" method="post" id="ICUCRITICALTESTRESULT">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <div class="form-group row">
        <div class="col-md-3">
            <strong> Patient Name </strong>
        </div>
        <div class="col-md-6">: {{ @$patient_info->patient_name }}</div>
        <div class="col-md-3"> <a class="btn btn-md btn-warning" target="_blank"
                href="{{ route('download-icu-critical-test-result', [$patient_no_fk, $admission_id]) }}">Export
                PDF</a>
        </div>
    </div> <br> <br>


    <table class="table table-bordered" width="100%">
        <colgroup>
            <col style="width: 12%;">
            <col style="width: 12%;">
            <col style="width: 12%;">
            <col style="width: 5%;">
            <col style="width: 15%;">
            <col style="width: 15%;">
            <col style="width: 5%;">
            <col style="width: 15%;">
            <col style="width: 9%;">
        </colgroup>
        <thead>
            <tr>
                <th><b>Investigation</b></th>
                <th><b>Critical Value (Test Result)</b></th>
                <th><b>Who informed (From Lab)</b></th>
                <th><b>Written read back and confirmed (Tick Mark)</b></th>
                <th><b>Informed to Doctor (Name)</b></th>
                <th><b>Orders carryout / Action taken (If yes, please specify)</b></th>
                <th><b>Written read back & confirmed (Tick Mark)</b></th>
                <th><b>RN Name & Emp ID</b></th>
                <th><b>Doctor sign (Within 24)</b></th>
            </tr>
        </thead>
        <tbody>
            <tr>
                <td><input type="text" name="investigation" class="form-control"></td>
                <td><input type="text" name="critical_value" class="form-control"></td>
                <td><input type="text" name="lab_informed" id="lab_informed" class="form-control">
                    <input type="hidden" name="h_lab_informed" id="h_lab_informed" class="form-control">
                </td>
                <td style="text-align: center;">
                    <input type="checkbox" name="confirmed_lab" value="1">
                </td>
                <td><input type="text" name="doc_name" id="doc_name" class="form-control">
                    <input type="hidden" name="h_doc_name" id="h_doc_name" class="form-control">
                </td>
                <td><input type="text" name="action_taken" class="form-control"></td>
                <td style="text-align: center;">
                    <input type="checkbox" name="confirmed_action" value="1">
                </td>
                <td><input type="text" name="rn_name" id="rn_name" class="form-control">
                    <input type="hidden" name="h_rn_name" id="h_rn_name" class="form-control">
                </td>
                <td><input type="text" name="doc_sign" class="form-control" readonly></td>
            </tr>
        </tbody>
    </table>



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
    <colgroup>
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 2%;">
        <col style="width: 14%;">
        <col style="width: 14%;">
        <col style="width: 2%;">
        <col style="width: 14%;">
        <col style="width: 8%;">
        <col style="width: 6%;">

    </colgroup>
    <thead class="global-uhl-table-bg">
        <tr>
            <th><b>Date & Time</b></th>
            <th><b>Investigation</b></th>
            <th><b>Critical Value (Test Result)</b></th>
            <th><b>Who informed (From Lab)</b></th>
            <th><b>Written read back and confirmed (Tick Mark)</b></th>
            <th><b>Informed to Doctor (Name)</b></th>
            <th><b>Orders carryout / Action taken (If yes, please specify)</b></th>
            <th><b>Written read back & confirmed (Tick Mark)</b></th>
            <th><b>RN Name & Emp ID</b></th>
            <th><b>Doctor sign (Within 24)</b></th>
            <th><b>Entry By</b></th>
        </tr>
    </thead>

    <tbody>


        @forelse ($critical_result as $item)
            <tr>
                <td>
                    @if (!empty($item->critical_date))
                        {{ date('d/m/Y h:i:s A', strtotime($item->critical_date)) }}
                    @endif
                </td>
                <td>{{ $item->investigation }}</td>
                <td>{{ $item->critical_value }}</td>
                <td>{{ $item->lab_informed }}</td>
                <td style="text-align: center;">
                    {!! $item->confirmed_lab == 1 ? '&#10003;' : '' !!}
                </td>
                <td>{{ $item->doc_name }}</td>
                <td>{{ $item->action_taken }}</td>
                <td style="text-align: center;">
                    {!! $item->confirmed_action == 1 ? '&#10003;' : '' !!}
                </td>
                <td>
                    {{ $item->rn_name }}
                    @if (!empty($item->h_rn_name))
                        ({{ $item->h_rn_name }})
                    @endif
                </td>

                <td>{{ $item->doc_name }}</td>
                <td>{{ $item->user_fullname }}</td>




            </tr>
        @empty
            <tr>
                <td colspan="11" class="text-align:center;color:red">Data Not Found</td>
            </tr>
        @endforelse




    </tbody>
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">
    openDoctorAutocomplete('#doc_name', 'h_doc_name', 'employee_ind', '1');
    openDoctorAutocomplete('#rn_name', 'h_rn_name', 'employee_ind', '1');
    openDoctorAutocomplete('#trans_by', 'h_trans_by', 'employee_ind', '1');
    openDoctorAutocomplete('#lab_informed', 'h_lab_informed', 'employee_ind', '1');
</script>
