<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd.store-btype-oxyzen-cylinder') }}" method="post" id="OXYZENCYLINDER">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <div class="form-group row">
        <div class="col-md-3">
            <strong> Patient Name </strong>
        </div>
        <div class="col-md-6">: {{ @$patient_info->patient_name }}</div>
        <div class="col-md-3"> <a class="btn btn-md btn-warning" target="_blank"
                href="{{ route('ipd.btype-oxyzen-cylinder-print', [$patient_no_fk, $admission_id]) }}">Export
                PDF</a>
        </div>
    </div> <br> <br>


    <table class="table table-bordered" width="100%">

        <thead>
            <tr>
                <td colspan="2"><b>Unit</b></td>
                <td colspan="4"><input type="text" name="unit" class="form-control" value="{{@$unit_month->unit}}"></td>
                <td colspan="2"><b>Month</b></td>
                <td colspan="4"><input type="text" name="month" class="form-control" value="{{@$unit_month->month}}"></td>

            </tr>
            <tr>
                <td colspan="12"><b>Oxygen Cylinder to Be Replaced If Pressure &lt;30Kg/cm<sup>2</sup></b></td>
            </tr>
            <tr><th colspan="12"><b>SHIFT</b></th></tr>

            <tr>

                <th colspan="4"><b>MORNING</b></th>
                <th colspan="4"><b>EVENING</b></th>
                <th colspan="4"><b>NIGHT</b></th>

            </tr>
            <tr>
                <th colspan="2">READING(KG/CM<sup>2</sup>)</th>
                <th colspan="2">Sign & EMP.ID</th>
                <th colspan="2">READING(KG/CM<sup>2</sup>)</th>
                <th colspan="2">Sign & EMP.ID</th>
                <th colspan="2">READING(KG/CM<sup>2</sup>)</th>
                <th colspan="2">Sign & EMP.ID</th>

            </tr>

        </thead>
        <tbody>
            <tr>
                <td colspan="2"><input type="text" name="m_reading" class="form-control" required></td>
                <td colspan="2"><input type="text" name="m_sign" class="form-control" required></td>
                <td colspan="2"><input type="text" name="e_reading" class="form-control" required></td>
                <td colspan="2"><input type="text" name="e_sign" class="form-control" required></td>
                <td colspan="2"><input type="text" name="n_reading" class="form-control" required></td>
                <td colspan="2"><input type="text" name="n_sign" class="form-control" required></td>

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
                <td colspan="2"><b>Unit</b></td>
                <td colspan="4">{{@$unit_month->unit}}</td>
                <td colspan="2"><b>Month</b></td>
                <td colspan="4">{{@$unit_month->month}}</td>

            </tr>
            <tr>
                <td colspan="12"><b>Oxygen Cylinder to Be Replaced If Pressure &lt;30Kg/cm<sup>2</sup></b></td>
            </tr>


            <tr>

                <th><b>Shift</b></th>
                <th colspan="3"><b>MORNING</b></th>
                <th colspan="4"><b>EVENING</b></th>
                <th colspan="4"><b>NIGHT</b></th>

            </tr>
            <tr>
                <th><b>Date</b></th>
                <th><b>READING(KG/CM<sup>2</sup>)</b></th>
                <th colspan="2"><b>Sign & EMP.ID</b></th>
                <th colspan="2"><b>READING(KG/CM<sup>2</sup>)</b></th>
                <th colspan="2"><b>Sign & EMP.ID</b></th>
                <th colspan="2"><b>READING(KG/CM<sup>2</sup>)</b></th>
                <th colspan="2"><b>Sign & EMP.ID</b></th>

            </tr>

        </thead>


    <tbody>


        @forelse ($oxyzen as $item)
            <tr>
                <td>
                    @if (!empty($item->laryngoscope_date))
                        {{ date('d/m/Y h:i:s A', strtotime($item->laryngoscope_date)) }}
                    @endif
                </td>
                <td>{{ $item->m_reading }}</td>
                <td colspan="2">{{ $item->m_sign }}</td>
                <td colspan="2">{{ $item->e_reading }}</td>
                <td colspan="2">{{ $item->e_sign }}</td>
                <td colspan="2">{{ $item->n_reading }}</td>
                <td colspan="2">{{ $item->n_sign }}</td>
            </tr>

        @empty
            <tr>
                <td colspan="12" style="text-align: center">Data Not Found !</td>
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
