<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd.store-daily-checklist-crash-cart') }}" method="post" id="CHECKECGMACHINE">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <div class="form-group row">
        <div class="col-md-3">
            <strong> Patient Name </strong>
        </div>
        <div class="col-md-6">: {{ @$patient_info->patient_name }}</div>
        <div class="col-md-3"> <a class="btn btn-md btn-warning" target="_blank"
                href="{{ route('ipd.daily-checklist-crash-cart-print', [$patient_no_fk, $admission_id]) }}">Export
                PDF</a>
        </div>
    </div> <br> <br>


    <table class="table table-bordered" width="100%">

        <thead>
            <tr>
                <td colspan="3">Unit</td>
                <td colspan="4"><input type="text" name="unit" class="form-control"
                        value="{{ @$unit_month->unit }}"></td>
                <td colspan="3">Crash Cart No</td>
                <td colspan="5"><input type="text" name="month" class="form-control"
                        value="{{ @$unit_month->month }}"></td>

            </tr>
            <tr>
                <th rowspan="2">SHIFT</th>
                <th colspan="2">Crash Cart Seal</th>
                <th colspan="2">Defibilator</th>
                <th colspan="4">Working Condition of Adult Laryngoscope</th>
                <th colspan="3">Working Condition of Pediatric Laryngoscope</th>
                <th colspan="2">Ambu Bag With Mask</th>
                <th rowspan="2">SIGN</th>
            </tr>
            <tr>

                <th>Intact</th>
                <th>Serial no of seal</th>
                <th>On Charge</th>
                <th>Working</th>
                <th>A1</th>
                <th>A2</th>
                <th>A3</th>
                <th>A4</th>
                <th>P00</th>
                <th>P0</th>
                <th>P1</th>
                <th>Adult</th>
                <th>Peads</th>

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

                <td><select name="mwc_a1">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td>
                    <input type="text" name="mwc_a2" class="form-control">
                </td>


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
                <td><select name="mwc_a11">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="mwc_a12">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>
                <td><select name="mwc_a13">
                        <option value="">Select</option>
                        <option value="Yes">Yes</option>
                        <option value="No">No</option>
                    </select></td>

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
            <td colspan="3"><b>Unit</b></td>
            <td colspan="5">{{ @$unit_month->unit }}</td>
            <td colspan="3"><b>Cash Cart No</b></td>
            <td colspan="5">{{ @$unit_month->month }}</td>

        </tr>
        <tr>    <th rowspan="2"><b>Date</b></th>
                <th rowspan="2"><b>SHIFT</b></th>
                <th colspan="2"><b>Crash Cart Seal</b></th>
                <th colspan="2"><b>Defibilator</b></th>
                <th colspan="4"><b>Working Condition of Adult Laryngoscope</b></th>
                <th colspan="3"><b>Working Condition of Pediatric Laryngoscope</b></th>
                <th colspan="2"><b>Ambu Bag With Mask</b></th>
                <th rowspan="2"><b>SIGN</b></th>
            </tr>
            <tr>

                <th>Intact</th>
                <th>Serial no of seal</th>
                <th>On Charge</th>
                <th>Working</th>
                <th>A1</th>
                <th>A2</th>
                <th>A3</th>
                <th>A4</th>
                <th>P00</th>
                <th>P0</th>
                <th>P1</th>
                <th>Adult</th>
                <th>Peads</th>

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
                <td>{{ $item->mwc_a7 }}</td>
                <td>{{ $item->mwc_a8 }}</td>
                <td>{{ $item->mwc_a9 }}</td>
                <td>{{ $item->mwc_a10 }}</td>
                <td>{{ $item->mwc_a11 }}</td>
                <td>{{ $item->mwc_a12 }}</td>
                <td>{{ $item->mwc_a13 }}</td>
                <td>{{ $item->msign }}</td>
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
<script type="text/javascript"></script>
