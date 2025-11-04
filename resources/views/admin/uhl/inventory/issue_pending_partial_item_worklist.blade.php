<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th>SL</th>
                <th>Indent No</th>
                <th style="text-align: left">Indent Date</th>
                <th style="text-align: left">Item Name</th>
                <th style="text-align: left">UOM</th>
                <th style="text-align: left">From Department</th>
                <th style="text-align: left">Receiving Store Stock</th>
                <th style="text-align: left">To Department</th>
                <th style="text-align: left">Stock</th>
                <th style="text-align: left">Req. By</th>
                <th>Is Urgent</th>
                <th>Is Exact</th>
                <th>Indent Qty</th>
                <th>Issue Qty</th>
                <th>Receive Qty</th>
            </tr>
          
        </thead>
        <tbody>
            @if (!empty($issued_requisition_list))
                @foreach ($issued_requisition_list as $row)  
                    <tr> 
                        <td>{{ $loop->iteration }}</td>
                        <td style="text-align: center">{{ $row->inv_requisition_no_fk }}</td>
                        <td>{{ date('d-m-Y', strtotime($row->inv_requisition_date)) }}</td>
                        <td>{{ $row->item_name }}</td>
                        <td style="text-align: center">{{ $row->uom_code }}</td>
                        <td>{{ $row->from_stor }}</td>
                        <td style="text-align: center">{{ $row->from_stock !=""? $row->from_stock :0 }}</td>
                        <td>{{ $row->to_store }}</td>
                        <td style="text-align: center">{{ $row->to_stock  !="" ? $row->to_stock :0}}</td>
                        <td>{{ $row->user_name }}</td>
                        <td style="text-align: center">
                            <span class="{{ $row->urgent_ind != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                                {{ $row->urgent_ind != 0 ? 'Yes' : 'No' }}
                            </span>
                        </td>
                        <td style="text-align: center">
                            <span class="{{ $row->exact_ind != 0 ? 'badge badge-success' : 'badge badge-danger' }}">
                                {{ $row->exact_ind != 0 ? 'Yes' : 'No' }}
                            </span>

                        </td>     
                        <td style="text-align: center">{{ $row->req_quantity }}</td>
                        <td style="text-align: center">{{ $row->issue_quantity }}</td>                  
                        <td style="text-align: center">{{ $row->recv_quantity }}</td>
                    </tr>
                    
                @endforeach

            @endif
        </tbody>
    </table>
</div>
<script>
    // $('.data-table').DataTable({
    //     "ordering": true,
    //     "bPaginate": true,
    //     "bLengthChange": true,
    //     "bAutoWidth": false
    // });
</script>