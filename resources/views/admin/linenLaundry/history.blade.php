@if(isset($history))
    <div class="card">
        <div class="card-header text-center" style="border-bottom: 1px solid black;">
            <h4>Receive History</h4>
        </div>
        <div class="card-body">
            <div class="table-responsive">
                <table class="table table-striped table-bordered table-hover data_table_history" id="dataTableHistory">
                    <thead class="global-uhl-table-bg">
                        <tr>
                            <th class="text-center" style="width: 5%;">SL.</th>
                            <th class="text-center" style="width: 20%; text-align: center;">Instrument</th>
                            <th class="text-center" style="width: 10%;">Received Qty</th>
                            <th class="text-center" style="width: 10%;">Received by</th>
                            <th class="text-center" style="width: 15%;">Received Date</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($history as $index => $item)
                            <tr class="return-to-department-history">
                                <td class="text-center">{{ ++$index }}</td>
                                <td>{{ $item->item_name }}</td>
                                <td>{{ $item->issue_qty }}</td>
                                <td>{{ $item->user_name ?? "---" }}</td>
                                <td>{{ $item->rtnrcv_date != "" ? date('d/m/Y', strtotime($item->rtnrcv_date)) : "---" }}</td>
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
        $('#dataTableHistory').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [0, 2, 4,], className: 'text-center' },
                    { targets: [1, 3,], className: 'text-left' }
                ],
                "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
                "pageLength": 5
            });
        $('th').addClass('text-center');
    });
</script>
