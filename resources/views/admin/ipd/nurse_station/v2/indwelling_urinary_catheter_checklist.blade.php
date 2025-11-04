<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">

<form action="{{ route('indwelling-urinary-catheter-checklist-store') }}" method="post" id="INDWELLING">
    @csrf
    <input type="hidden" name="patient_no_fk" id="patient_no_fk" value="{{ $patient_no_fk }}">
    <input type="hidden" name="admission_no_fk" id="admission_no_fk" value="{{ $admission_id }}">
    <div class="form-group row">
        <div class="col-md-3">
            <strong> Patient Name </strong>
        </div>
        <div class="col-md-6">: {{ @$patient_info->patient_name }}</div>
        <div class="col-md-3"> <a class="btn btn-md btn-warning" target="_blank"
                href="{{ route('indwelling-urinary-catheter-checklist-pdf', [$patient_no_fk, $admission_id]) }}">Export
                PDF</a>
        </div>
    </div> <br> <br>


    <table class="table table-bordered" width="100%">
        <colgroup>
            <col style="width: 15%;">
            <col style="width: 15%;">
            <col style="width: 15%;">
            <col style="width: 15%;">
            <col style="width: 15%;">
            <col style="width: 25%;">

        </colgroup>

        <thead>
            <tr>
                <th><b>To relieve urinary obstruction and or acute urinary retention</b></th>
                <th><b>To monitor urine output in critically ill patients</b></th>
                <th><b>To avoid in urologic surgery</b></th>
                <th><b>Patient has urinary incontinence with open wounds and /or skin graft in sacral or perineal
                        areas</b></th>
                <th><b>To improve comfort for terminally ill patient</b></th>
                <th><b>Signature of Doctor with ID no</b></th>

            </tr>
        </thead>
        <tbody>
            <tr>

                <td style="text-align: center;">
                    <input type="checkbox" name="relive" value="1">
                </td>
                <td style="text-align: center;">
                    <input type="checkbox" name="monitor" value="1">
                </td>
                <td style="text-align: center;">
                    <input type="checkbox" name="urologic" value="1">
                </td>
                <td style="text-align: center;">
                    <input type="checkbox" name="skin" value="1">
                </td>
                <td style="text-align: center;">
                    <input type="checkbox" name="improve" value="1">
                </td>
                <td><input type="text" name="doc_name" id="doc_name" class="form-control" placeholder="name">
                    <input type="hidden" name="h_doc_name" id="h_doc_name" class="form-control" >
                    <input type="text" name="doc_id" class="form-control" placeholder="Emp. ID">
                </td>

            </tr>
        </tbody>
    </table>



    <div class="modal-footer">
        @php
            $response_action = route('indwelling-urinary-catheter-checklist', $admission_id);
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
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 10%;">
        <col style="width: 20%;">
        <col style="width: 10%;">


    </colgroup>
    <thead class="global-uhl-table-bg">
        <tr>
            <th><b>Date & Time</b></th>
            <th><b>Indication</b></th>
            <th><b>To relieve urinary obstruction and or acute urinary retention</b></th>
            <th><b>To monitor urine output in critically ill patients</b></th>
            <th><b>To avoid in urologic surgery</b></th>
            <th><b>Patient has urinary incontinence with open wounds and /or skin graft in sacral or perineal
                    areas</b></th>
            <th><b>To improve comfort for terminally ill patient</b></th>
            <th><b>Signature of Doctor with ID no</b></th>
            <th><b>Entry By</b></th>
        </tr>
    </thead>

    <tbody>


        @forelse ($urinary_catheter as $item)
            <tr>
                <td>
                    @if (!empty($item->urinary_date))
                        {{ date('d/m/Y h:i:s A', strtotime($item->urinary_date)) }}
                    @endif
                </td>
                <td>DAY {{ $loop->iteration }}</td>
                <td style="text-align: center;">
                    {!! $item->relive == 1 ? '&#10003;' : '' !!}
                </td>
                <td style="text-align: center;">
                    {!! $item->monitor == 1 ? '&#10003;' : '' !!}
                </td>
                <td style="text-align: center;">
                    {!! $item->urologic == 1 ? '&#10003;' : '' !!}
                </td>
                <td style="text-align: center;">
                    {!! $item->skin == 1 ? '&#10003;' : '' !!}
                </td>
                <td style="text-align: center;">
                    {!! $item->improve == 1 ? '&#10003;' : '' !!}
                </td>
                <td>{{ $item->doc_name }} &nbsp; {{ $item->doc_id }}</td>
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


</script>
