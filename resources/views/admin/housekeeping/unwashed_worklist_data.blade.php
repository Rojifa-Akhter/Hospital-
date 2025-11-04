@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

 <div class="card-header">
        <h5>Washing Request List <button class="btn btn-md btn-outline-primary float-right open-modal"
                data-modal="common-modal-sm" data-action="{{ route('create-loundry-requst') }}"
                data-title="Create Lanudry Request">Lanudry Request</button></h5>
    </div>


<form id="item_received" action="{{ route('housekeeping-store-item') }}" method="post">
    @csrf
    <table class="table table-bordered table-striped mb-0 data-table">
        <thead>
            <tr class="bg-light-blue">
                <th class="text-center">SL#</th>
                <th class="text-center">Washed No.</th>
                <th class="text-center">Item</th>
                <th class="text-center">Qty.</th>
                <th class="text-center">Wash Request Date</th>
                {{-- <th class="text-center">By</th> --}}
                {{-- <th class="text-center">Received Ind</th> --}}
                <th class="text-center">Requested By</th>
                {{-- <th class="text-center">Requested Date</th> --}}
                <th class="text-center"><input type="checkbox" id="allItemSelect" /></th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($hk_data))
                @foreach ($hk_data as $key => $data)
                    <tr>
                        <input type="hidden" name="wash_req_uid[]" value="{{$data->wash_req_uid}}">
                        <input type="hidden" name="wash_reqdtl_no_pk[]" value="{{$data->wash_reqdtl_no_pk}}">
                        <input type="hidden" name="wash_req_qty[]" value="{{ !empty($data->wash_item_qty) ? $data->wash_item_qty :0 }}">
                        <input type="hidden" name="wash_req_date[]" value="{{ date('d/m/y', strtotime($data->wash_req_date)) }}">
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ !empty($data->wash_req_uid) ? $data->wash_req_uid : '' }} </td>
                        <td class="text-center">
                            <strong>{{ !empty($data->item_name) ? ucfirst($data->item_name) : '' }}</strong>
                        </td>
                        <td class="text-center">{{ !empty($data->wash_item_qty) ? $data->wash_item_qty : 0 }} </td>
                        <td class="text-center">{{ date('d/m/y', strtotime($data->wash_req_date)) }}</td>
                        {{-- <td class="text-center"> </td> --}}
                        <td class="text-center">{{ !empty($data->sent_by_name) ? ucwords($data->sent_by_name) : '' }}
                        </td>

                        {{-- <td class="text-center">{{ date('d/m/Y', strtotime($data->return_rcv_item_at)) }}</td> --}}
                        <td class="text-center"><input type="checkbox" class="is_check is_check_path"
                                name="is_received[]" id="checkBOx" value="{{ $data->wash_req_uid }}">

                                <a href="{{ route('housekeeping-report-pdf-v1-id', $data->wash_req_uid) }}"
                                    class="btn btn-outline-primary btn-sm bg-none cursor-pointer" target="_blank"
                                    data-id="{{ $data->wash_req_uid }}" id="wash_id" title="Wash Report Print"><i
                                        class="fa fa-tag"></i></a>





                            </td>
                    </tr>
                @endforeach
            @endif
        </tbody>

        <tfoot>
            <tr>
                <td class="text-center" colspan="6"></td>
                <td class="text-center">
                    @php
                        $response_action = route('housekeeping.worklist');
                    @endphp
                    <button class="btn btn-sm btn-success"
                        onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Received
                    </button>


                </td>
            </tr>
        </tfoot>
    </table>
</form>
{{-- <script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script> --}}

<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });

    $('#allItemSelect').click(function(e) {
        if ($('#allItemSelect').is(':checked')) {
            $('.is_check_path').prop('checked', true);
        } else {
            $('.is_check_path').prop('checked', false);
        }
    });
</script>
