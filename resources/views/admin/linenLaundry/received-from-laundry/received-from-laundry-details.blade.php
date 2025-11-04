@if(isset($itemDetails))
    <div class="card">
        <div class="card-header text-center" style="border-bottom: 1px solid black;">
            <h4>Department: {{ $itemDetails[0]->serviceunit_name }}</h4>
            <h5>ID: {{ $itemDetails[0]->reqmst_no_pk }}</h5>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover data_table_details" id="dataTableDetails">
                    <thead class="global-uhl-table-bg">
                        <tr>
                            <th class="text-center" style="width: 5%;">SL.</th>
                            <th class="text-center" style="width: 20%; text-align: center;">Laundry Items</th>
                            <th class="text-center" style="width: 5%;">Total Qty</th>
                            <th class="text-center" style="width: 10%;">Total Received</th>
                            <th class="text-center" style="width: 10%;">Pending Receive</th>
                            <th class="text-center" style="width: 10%;">Pending Return</th>
                            <th class="text-center" style="width: 10%;">Status</th>
                            <th class="text-left" style="width: 30%;">Remarks</th>
                        </tr>
                    </thead>
                    <tbody style="cursor: pointer;">
                        @foreach($itemDetails as $index => $itemDetail)
                            <tr>
                                <td>{{ ++$index }}</td>
                                <td>{{ $itemDetail->item_name }}</td>
                                <td class="text-center">{{ $itemDetail->item_qty }}</td>
                                <td class="text-center">{{ $itemDetail->alreadyrtn_qty ?? 0 }}</td>
                                <td class="text-center">{{ $itemDetail->pending_rcv_by_dept_qty ?? 0 }}</td>
                                <td class="text-center">{{ $itemDetail->item_qty - ($itemDetail->alreadyrtn_qty + $itemDetail->pending_rcv_by_dept_qty) }}</td>
                                <td class="text-center">
                                    @if($itemDetail->item_qty == $itemDetail->alreadyrtn_qty)
                                        <span class="btn btn-sm btn-success">Received</span>
                                    @elseif($itemDetail->alreadyrtn_qty == null && $itemDetail->pending_rcv_by_dept_qty == null)
                                        <span class="btn btn-sm btn-danger">Not Sent Yet</span>
                                    @elseif($itemDetail->pending_rcv_by_dept_qty > 0)
                                        <span class="btn btn-sm btn-primary">Pending Receive</span>
                                    @else
                                        <span class="btn btn-sm btn-warning">Partially Received</span>
                                    @endif
                                </td>
                                <td>{{ $itemDetail->remarks }}</td>
                            </tr>
                        @endforeach
                    </tbody>
                </table>
            </div>
        </div>
    </div>
@endif

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTableDetails').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [0, 3,], className: 'text-center' },
                    { targets: [1, 2, 4,], className: 'text-left' }
                ],
                "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
                "pageLength": 5
            });
        $('th').addClass('text-center');
    });
</script>
