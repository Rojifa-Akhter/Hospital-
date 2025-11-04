<table class="table table-striped table-bordered table-hover data_table" id="dataTable">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center" style="width: 5%;">SL.</th>
            <th class="text-center" style="width: 5%;">ID No.</th>
            <th class="text-center" style="width: 40%;">Chart Name</th>
            <th class="text-left" style="width: 20%;">Diet Note</th>
            <th class="text-left" style="width: 10%;">Price</th>
            <th class="text-left" style="width: 10%;">Status</th>
            <th class="text-center" style="width: 10%;">Action</th>
        </tr>
    </thead>
    <tbody style="cursor: pointer;">
        @if(isset($items))
            @foreach($items as $item)
                <tr>
                    <td>{{ $loop->iteration }}</td>
                    <td>{{ $item->diet_chart_no_pk }}</td>
                    <td>{{ $item->diet_chart_name }}</td>
                    <td>{{ $item->note }}</td>
                    <td>{{ $item->price }}</td>
                    <td>
                        @if($item->status == "1")
                            <span class="badge badge-success">Active</span>
                        @else
                            <span class="badge badge-warning">Inactive</span>
                        @endif
                    </td>
                    <td>
                        <button type="button" class="open-modal btn btn-success btn-sm" data-modal="common-modal-xl" data-title="Diet Chart Details" data-action="{{ route('dietChart.details', ['id' => $item->diet_chart_no_pk]) }}"><i class="fa fa-eye"></i></button>
                        {{-- <button type="button" class="open-modal btn btn-success btn-sm" data-modal="common-modal-sm" data-title="Diet Chart Update" data-action="{{ route('dietChart.edit', ['id' => $row->diet_chart_no_pk]) }}"><i class="fa fa-edit"></i></button> --}}
                        {{-- <button type="button" onclick="deleteDietFood({{ $item->dietfood_no_pk }})" Class="btn btn-sm btn-danger" title="Delete Diet Chart"><i class="fa fa-trash"></i></a> --}}
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [0, 1, 4, 5, 6,], className: 'text-center' },
                    { targets: [2, 3,], className: 'text-left' }
                ],
                "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
                "pageLength": 10
            });
        $('th').addClass('text-center');
    });


</script>
