<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd.store-laryngoscope-checklist') }}" method="post" id="LARYNGOSCOPECHECKLIST">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <div class="form-group row">
        <div class="col-md-3">
            <strong> Patient Name </strong>
        </div>
        <div class="col-md-6">: {{ @$patient_info->patient_name }}</div>
        <div class="col-md-3"> <a class="btn btn-md btn-warning" target="_blank"
                href="{{ route('ipd.laryngoscope-checklist-print', [$patient_no_fk, $admission_id]) }}">Export
                PDF</a>
        </div>
    </div> <br> <br>


    <table class="table table-bordered" width="100%">

        <thead>
            <tr>
                <td colspan="2">Unit</td>
                <td colspan="4"><input type="text" name="unit" class="form-control" value="{{@$unit_month->unit}}"></td>
                <td colspan="2">Month</td>
                <td colspan="4"><input type="text" name="month" class="form-control" value="{{@$unit_month->month}}"></td>

            </tr>
            <tr>
                <th rowspan="2"><b>SHIFT</b></th>
                <th colspan="5"><b>Working Condition of
                        Laryngoscope adult</b></th>
                <th colspan="5"><b>Working Condition of
                        Laryngoscope adult</b>
                </th>
                <th rowspan="2"><b>Sign
                        &
                        Emp. ID</b>
                </th>

            </tr>
            <tr>

                <th><b>A1</b></th>
                <th><b>A2</b></th>
                <th><b>A3</b></th>
                <th><b>A4</b></th>
                <th><b>Extra Cell</b></th>
                <th><b>A1</b></th>
                <th><b>A2</b></th>
                <th><b>A3</b></th>
                <th><b>A4</b></th>
                <th><b>Extra Cell</b></th>



            </tr>
        </thead>
        <tbody>
            <tr>
                <td>M</td>
                <td><select name="mwc_a1">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="mwc_a2">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="mwc_a3">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="mwc_a4">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="mwc_a5">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="mwc_a6">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="mwc_a7">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="mwc_a8">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="mwc_a9">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="mwc_a10">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><input type="text" name="msign" class="form-control"></td>

            </tr>
            <tr>
                <td>E</td>
                <td><select name="ewc_a1">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="ewc_a2">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="ewc_a3">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="ewc_a4">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="ewc_a5">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="ewc_a6">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="ewc_a7">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="ewc_a8">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="ewc_a9">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="ewc_a10">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><input type="text" name="esign" class="form-control"></td>

            </tr>
            <tr>
                <td>N</td>
                <td><select name="nwc_a1">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="nwc_a2">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="nwc_a3">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="nwc_a4">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="nwc_a5">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="nwc_a6">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="nwc_a7">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="nwc_a8">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="nwc_a9">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="nwc_a10">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><input type="text" name="nsign" class="form-control"></td>

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
            <td colspan="3">Unit</td>
            <td colspan="4">{{@$unit_month->unit}}</td>
            <td colspan="2">Month</td>
            <td colspan="4">{{@$unit_month->month}}</td>

        </tr>
        <tr>
            <th rowspan="2"><b>Date</b></th>
            <th rowspan="2"><b>SHIFT</b></th>
            <th colspan="5"><b>Working Condition of
                    Laryngoscope adult</b></th>
            <th colspan="5"><b>Working Condition of
                    Laryngoscope adult</b>
            </th>
            <th rowspan="2"><b>Sign
                    &
                    Emp. ID</b>
            </th>

        </tr>
        <tr>


            <th><b>A1</b></th>
            <th><b>A2</b></th>
            <th><b>A3</b></th>
            <th><b>A4</b></th>
            <th><b>Extra Cell</b></th>
            <th><b>A1</b></th>
            <th><b>A2</b></th>
            <th><b>A3</b></th>
            <th><b>A4</b></th>
            <th><b>Extra Cell</b></th>



        </tr>
    </thead>


    <tbody>


        @forelse ($laryngoscope as $item)
            <tr>
                <td rowspan="3">
                    @if (!empty($item->laryngoscope_date))
                        {{ date('d/m/Y h:i:s A', strtotime($item->laryngoscope_date)) }}
                    @endif
                </td>
                <td style="text-align: center">M</td>
                <td>{{ $item->mwc_a1 }}</td>
                <td>{{ $item->mwc_a2 }}</td>
                <td>{{ $item->mwc_a3 }}</td>
                <td>{{ $item->mwc_a4 }}</td>
                <td>{{ $item->mwc_a5 }}</td>
                <td>{{ $item->mwc_a6 }}</td>
                <td>{{ $item->mwc_a7 }}</td>
                <td>{{ $item->mwc_a8 }}</td>
                <td>{{ $item->mwc_a9 }}</td>
                <td>{{ $item->mwc_a10 }}</td>
                <td>{{ $item->msign }}</td>
            </tr>
            <tr>
                <td>E</td>
                <td>{{ $item->ewc_a1 }}</td>
                <td>{{ $item->ewc_a2 }}</td>
                <td>{{ $item->ewc_a3 }}</td>
                <td>{{ $item->ewc_a4 }}</td>
                <td>{{ $item->ewc_a5 }}</td>
                <td>{{ $item->ewc_a6 }}</td>
                <td>{{ $item->ewc_a7 }}</td>
                <td>{{ $item->ewc_a8 }}</td>
                <td>{{ $item->ewc_a9 }}</td>
                <td>{{ $item->ewc_a10 }}</td>
                <td>{{ $item->esign }}</td>
            </tr>
            <tr>
                <td>N</td>
                <td>{{ $item->nwc_a1 }}</td>
                <td>{{ $item->nwc_a2 }}</td>
                <td>{{ $item->nwc_a3 }}</td>
                <td>{{ $item->nwc_a4 }}</td>
                <td>{{ $item->nwc_a5 }}</td>
                <td>{{ $item->nwc_a6 }}</td>
                <td>{{ $item->nwc_a7 }}</td>
                <td>{{ $item->nwc_a8 }}</td>
                <td>{{ $item->nwc_a9 }}</td>
                <td>{{ $item->nwc_a10 }}</td>
                <td>{{ $item->nsign }}</td>
            </tr>
        @empty
            <tr>
                <td colspan="13" style="text-align: center">Data Not Found !</td>
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
