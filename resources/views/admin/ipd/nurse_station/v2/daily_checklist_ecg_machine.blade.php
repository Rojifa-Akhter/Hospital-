<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd.store-daily-checklist-ecg-machine') }}" method="post" id="CHECKECGMACHINE">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <div class="form-group row">
        <div class="col-md-3">
            <strong> Patient Name </strong>
        </div>
        <div class="col-md-6">: {{ @$patient_info->patient_name }}</div>
        <div class="col-md-3"> <a class="btn btn-md btn-warning" target="_blank"
                href="{{ route('ipd.daily-checklist-ecg-machine-print', [$patient_no_fk, $admission_id]) }}">Export
                PDF</a>
        </div>
    </div> <br> <br>


    <table class="table table-bordered" width="100%">

        <thead>
            <tr>
                <td colspan="2">Unit</td>
                <td colspan="2"><input type="text" name="unit" class="form-control"
                        value="{{ @$unit_month->unit }}"></td>
                <td colspan="2">Month</td>
                <td colspan="2"><input type="text" name="month" class="form-control"
                        value="{{ @$unit_month->month }}"></td>

            </tr>
            <tr>
                <th>SHIFT</th>
                <th>ON CHARGE</th>
                <th>ECG LEADES & BULB</th>
                <th>ECG GEL</th>
                <th>ECG PAPER</th>
                <th>TISSUE ROLL</th>
                <th>EMP. ID</th>
                <th>SIGN</th>
            </tr>

        </thead>
        <tbody>
            <tr>
                <td><select name="shift">
                        <option value="">Select</option>
                        <option value="M">M</option>
                        <option value="E">E</option>
                        <option value="N">N</option>
                    </select></td>
                <td>
                    <input type="text" name="mwc_a1" class="form-control">
                </td>

                <td>
                    <input type="text" name="mwc_a2" class="form-control">
                </td>
                <td>
                    <input type="text" name="mwc_a3" class="form-control">
                </td>
                <td>
                    <input type="text" name="mwc_a4" class="form-control">
                </td>
                <td>
                    <input type="text" name="mwc_a5" class="form-control">
                </td>
                <td>
                    <input type="text" name="mwc_a6" class="form-control">
                </td>

                <td><input type="text" name="msign" class="form-control"></td>

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
    <thead class="global-uhl-table-bg">
        <tr>
            <td colspan="2">Unit</td>
            <td colspan="2">{{ @$unit_month->unit }}</td>
            <td colspan="2">Month</td>
            <td colspan="3">{{ @$unit_month->month }}</td>

        </tr>
        <tr>
            <th><b>Date</b></th>
            <th>SHIFT</th>
            <th>ON CHARGE</th>
            <th>ECG LEADES & BULB</th>
            <th>ECG GEL</th>
            <th>ECG PAPER</th>
            <th>TISSUE ROLL</th>
            <th>EMP. ID</th>
            <th>SIGN</th>


        </tr>

    </thead>


    <tbody>


        @forelse ($laryngoscope as $item)
            <tr>
                <td>
                    @if (!empty($item->laryngoscope_date))
                        {{ date('d/m/Y h:i:s A', strtotime($item->laryngoscope_date)) }}
                    @endif
                </td>
                <td>{{ $item->shift }}</td>
                <td>{{ $item->mwc_a1 }}</td>
                <td>{{ $item->mwc_a2 }}</td>
                <td>{{ $item->mwc_a3 }}</td>
                <td>{{ $item->mwc_a4 }}</td>
                <td>{{ $item->mwc_a5 }}</td>
                <td>{{ $item->mwc_a6 }}</td>
                <td>{{ $item->nsign }}</td>
            </tr>

        @empty
            <tr>
                <td colspan="9" style="text-align: center">Data Not Found !</td>
            </tr>
        @endforelse


    </tbody>
</table>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script type="application/javascript" src="{{ asset('asset/timepicker/js/timepicker.js') }}"></script>
<script type="text/javascript">

</script>
