<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th rowspan="2">SL</th>
                <th rowspan="2">PR No</th>
                <th rowspan="2">From Dept.</th>
                <th colspan="2">Req. By</th>
                <th rowspan="2">Expect Date</th>
                <th rowspan="2">Action</th>
            </tr>
            <tr>
                <th>Type</th>
                <th>Req. By</th>
            </tr>
        </thead>
        <tbody>
          
            @if (!empty($requisition_list))
                @foreach ($requisition_list as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td>{{ $row->inv_requisition_po_no_pk }}</td>
                        <td>{{ $row->from_store }}</td>
                        <td>{{ $row->req_by_name }}</td>
                        <td>{{ $row->expect_date }}</td>


                        <td>
                            <span class="{{ $row->urgent != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                                {{ $row->urgent != 0 ? 'Yes' : 'No' }}
                            </span>

                        </td>
                        <td>

                            <span class="{{ $row->exact != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                                {{ $row->exact != 0 ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td class="text-center">

                            @php
                                        $status=$row->recv_ind == 1 && $row->issue_ind == 1? 'Received' : '';
                                        $disabled=$row->recv_ind == 1 ? 'javascript:void(0)' : route('v1-item-receive.create', ['requisition_no' => $row->inv_requisition_no_pk]);
                            @endphp
                            @if ($row->indent_save_option == 'POST' && $row->recv_ind == 1 && $row->issue_ind == 1)
                            <button class="badge badge-success"> Received</button>
                            @endif
                        </td>
                        <td>

                            @if ($row->indent_save_option != 'POST')
                                <a href="{{ route('v1-department-indent.edit', $row->inv_requisition_no_pk) }} "
                                    rel="tab" class="btn btn-sm btn-primary"><i class="far fa-edit"></i></a>
                            @else
                                @if ($row->recv_ind != 1 && $row->issue_ind == 1)
                                    <a href="{{route('v1-item-receive.create', ['requisition_no' => $row->inv_requisition_no_pk])}}"
                                        rel="tab" class="btn btn-sm uhl_common_btn text-white"
                                        style="opacity: 1!important;" >Receive</a>
                                @endif
                            @endif
                            <a href="{{ route('v1.department-indent-print', $row->inv_requisition_no_pk) }}"
                                target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>
                        </td>
                    </tr>
                @endforeach

            @endif
        </tbody>
    </table>
</div>
