<table class="table chrn-data-table table-hover m-0">
    <thead>
        <tr>
            <th class="text-center w-10">#SL</th>
            <th class="text-left">Chronic Disease</th>
            <th class="text-left">Chronic Disease Details</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($chronic_diseases))
        @php
        $sl=0;
        $chor_date=[];
        @endphp
            @foreach ($chronic_diseases as $chrn_dis)
                @php
                    $checked = in_array($chrn_dis->pres_lookupdata_no_pk, $item_arr) ? "checked='checked'" : '';

                $chor_date =in_array($chrn_dis->pres_lookupdata_no_pk, $item_arr) ?  $chronicarr[$sl] :"" ;

                @endphp
                <tr>
                    <td class="text-center w-10">{{ $loop->iteration }}</td>
                    <td class="text-left">
                        <div class="custom-control custom-checkbox">
                            <input type="checkbox" class="custom-control-input chronic-item"
                                onchange="prescriptionFunc.selectChronicItem(this)"
                                id="chrn_dis_{{ $chrn_dis->pres_lookupdata_no_pk }}"
                                value="{{ $chrn_dis->pres_lookupdata_no_pk }}"
                                data-name="{{ $chrn_dis->pres_lookupdata_name }}" {{ $checked }}>
                            <label class="custom-control-label"
                                for="chrn_dis_{{ $chrn_dis->pres_lookupdata_no_pk }}">{{ $chrn_dis->pres_lookupdata_name }}</label>
                        </div>
                    </td>
                    <td>
                        <input type="text" class="form-control" placeholder=""  id="chrn_dtls_{{ $chrn_dis->pres_lookupdata_no_pk }}" value="{{$chor_date}}">
                    </td>
                </tr>
            @endforeach
            @php
                $sl =+1;
            @endphp
        @endif
    </tbody>
</table>
<div class="modal-footer">

    <button type="button" onclick="prescriptionFunc.saveChronicItem(this);" class="btn btn-success btn-md"  data-dismiss="modal" aria-label="Close">Save</button>
    <button type="reset" class="btn btn-danger btn-md" title="Click here to close the window"
        data-dismiss="modal">Close</button>
</div>
<script>
    $('.chrn-data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bInfo": false,
        "bAutoWidth": false
    });
</script>
