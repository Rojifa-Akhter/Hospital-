@php
    $hospital = DB::table('wsec_hospital')
        ->where('au_entry_hospital_pk_no', Session::get('user.ses_hospital_no_pk'))
        ->first();
@endphp

<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">

<form id="item_received" action="{{ route('path.save-checkbox') }}" method="post">
    @csrf
    <table class="table table-bordered table-striped mb-0 data-table">
        <thead>
            <tr class="bg-light-blue">
                <th class="text-center">SL#</th>
                <th class="text-center">Washed No.</th>
                <th class="text-center">Item</th>
                <th class="text-center">Qty.</th>
                <th class="text-center">Wash Requested Date</th>
                <th class="text-center">Status</th>
                <th class="text-center">Requested By</th>
                <th class="text-center">Received By</th>
                <th class="text-center">Received Date</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($hk_data))
                @foreach ($hk_data as $key => $data)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ !empty($data->wash_req_uid) ? $data->wash_req_uid : '' }} </td>
                        <td class="text-center">
                            <strong>{{ !empty($data->item_name) ? ucfirst($data->item_name) : '' }}</strong>
                        </td>
                        <td class="text-center">{{ !empty($data->wash_item_qty) ? $data->wash_item_qty : '' }} </td>
                        <td class="text-center">{{ date('d/m/y', strtotime($data->wash_req_date)) }}</td>
                        <td class="text-center"><span class="badge bg-success">Received</span></td>

                        <td class="text-center">{{ !empty($data->sent_by_name) ? ucwords($data->sent_by_name) : '' }}
                        </td>
                        <td class="text-center">
                            {{ !empty($data->return_rcv_item_by_name) ? ucwords($data->return_rcv_item_by_name) : '' }}
                        </td>
                        <td class="text-center">{{ date('d/m/Y', strtotime($data->return_rcv_item_at)) }}</td>
                        <td class="text-center"> <a
                                href="{{ route('housekeeping-report-pdf-v1-id', $data->wash_req_uid) }}"
                                class="btn btn-outline-primary btn-sm bg-none cursor-pointer" target="_blank"
                                data-id="{{ $data->wash_req_uid }}" id="wash_id" title="Wash Report Print"><i
                                    class="fa fa-tag"></i></a></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</form>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="text/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
