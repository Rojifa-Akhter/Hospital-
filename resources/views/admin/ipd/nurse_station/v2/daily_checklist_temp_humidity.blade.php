<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('ipd.store-daily-check-temp-humidity') }}" method="post" id="REFRIGERATOR">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <div class="form-group row">
        <div class="col-md-3">
            <strong> Patient Name </strong>
        </div>
        <div class="col-md-6">: {{ @$patient_info->patient_name }}</div>
        <div class="col-md-3"> <a class="btn btn-md btn-warning" target="_blank"
                href="{{ route('ipd.daily-check-temp-humidity-print', [$patient_no_fk, $admission_id]) }}">Export
                PDF</a>
        </div>
    </div> <br> <br>


    <table class="table table-bordered" width="100%">

        <thead>
            <tr>
                <td colspan="4"><b>References Range Temperature 15◦c to 25◦c</b></td>
                <td colspan="4"><b>References Range Humidity ≤ 70%</b></td>
                <td>UNIT:</td>
                <td colspan="2"><input type="text" name="unit" class="form-control"
                        value="{{ @$unit_month->unit }}"></td>
            </tr>
            <tr>
                <td colspan="6"><b>In case of any Variation in temperature and Humidity from Reference Range, Please
                        Call Duty Engineer on extension</b></td>
                <td colspan="2"><b>Month</b></td>
                <td colspan="3"><input type="text" name="month" class="form-control"
                        value="{{ @$unit_month->month }}"></td>

            </tr>
            <tr>
                <td colspan="7"><b> If temperature is out of range, inform your manager and leave the medicines to
                        the nearby locations</b></td>
                <td colspan="2"><b>Location name:</b></td>
                <td colspan="2"><input type="text" name="location" class="form-control"
                        value="{{ @$unit_month->location }}"></td>

            </tr>

            <tr>

                <th colspan="3">MORNING</th>
                <th colspan="3">EVENING</th>
                <th colspan="3">NIGHT</th>
                <th>COMPLAINT</th>
                <th>REPAIRED</th>
            </tr>
            <tr>

                <th>TEMP(◦C)</th>
                <th>HUMIDITY(%)</th>
                <th style="width: 10%">SIGN & EMP. ID</th>
                <th>TEMP(◦C)</th>
                <th>HUMIDITY(%)</th>
                <th style="width: 10%">SIGN & EMP. ID</th>
                <th>TEMP(◦C)</th>
                <th>HUMIDITY(%)</th>
                <th style="width: 10%">SIGN & EMP. ID</th>
                <th>DATE & TIME</th>
                <th>DATE & TIME</th>




            </tr>

        </thead>
        <tbody>
            <tr>

                <td>
                    <input type="text" name="m_fridge" class="form-control">
                </td>
                <td><input type="text" name="m_freezer" class="form-control"></td>
                <td><input type="text" name="m_sign" class="form-control"></td>
                <td>
                    <input type="text" name="e_fridge" class="form-control">
                </td>
                <td><input type="text" name="e_freezer" class="form-control"></td>
                <td><input type="text" name="e_sign" class="form-control"></td>
                <td>
                    <input type="text" name="n_fridge" class="form-control">
                </td>
                <td><input type="text" name="n_freezer" class="form-control"></td>
                <td><input type="text" name="n_sign" class="form-control"></td>
                <td><input type="text" name="complaint" class="form-control"></td>
                <td><input type="text" name="repaired" class="form-control"></td>




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
            <td colspan="5"><b>References Range Temperature 15◦c to 25◦c</b></td>
            <td colspan="4"><b>References Range Humidity ≤ 70%</b></td>
            <td>UNIT:</td>
            <td colspan="2">{{ @$unit_month->unit }}</td>
        </tr>
        <tr>
            <td colspan="7"><b>In case of any Variation in temperature and Humidity from Reference Range, Please Call
                    Duty Engineer on extension</b></td>
            <td colspan="2"><b>Month</b></td>
            <td colspan="3">{{ @$unit_month->month }}</td>

        </tr>
        <tr>
            <td colspan="8"><b> If temperature is out of range, inform your manager and leave the medicines to the
                    nearby locations</b></td>
            <td colspan="2"><b>Location name:</b></td>
            <td colspan="2">{{ @$unit_month->location }}</td>

        </tr>

        <tr>
            <th rowspan="2">DATE</th>
            <th colspan="3">MORNING</th>
            <th colspan="3">EVENING</th>
            <th colspan="3">NIGHT</th>
            <th>COMPLAINT</th>
            <th>REPAIRED</th>
        </tr>
        <tr>

            <th>TEMP(◦C)</th>
            <th>HUMIDITY(%)</th>
            <th style="width: 10%">SIGN & EMP. ID</th>
            <th>TEMP(◦C)</th>
            <th>HUMIDITY(%)</th>
            <th style="width: 10%">SIGN & EMP. ID</th>
            <th>TEMP(◦C)</th>
            <th>HUMIDITY(%)</th>
            <th style="width: 10%">SIGN & EMP. ID</th>
            <th>DATE & TIME</th>
            <th>DATE & TIME</th>




        </tr>

    </thead>

    <tbody>


        @forelse ($temp as $item)
            <tr>
                <td>
                    @if (!empty($item->ref_date))
                        {{ date('d/m/Y h:i:s A', strtotime($item->ref_date)) }}
                    @endif
                </td>
                <td>{{ $item->m_fridge }}</td>
                <td>{{ $item->m_freezer }}</td>
                <td>{{ $item->m_sign }}</td>
                <td>{{ $item->e_fridge }}</td>
                <td>{{ $item->e_freezer }}</td>
                <td>{{ $item->e_sign }}</td>
                <td>{{ $item->n_fridge }}</td>
                <td>{{ $item->n_freezer }}</td>
                <td>{{ $item->n_sign }}</td>
                <td>{{ $item->complaint }}</td>
                <td>{{ $item->repaired }}</td>

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
<script type="text/javascript"></script>
