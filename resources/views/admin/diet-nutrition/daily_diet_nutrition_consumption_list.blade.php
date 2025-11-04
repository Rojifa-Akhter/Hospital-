<div class="">
    <div class="col-md-12" id="">
        <div class="table-responsive">
            <table class="table table-bordered table-hover table-striped data-table" id="dataTable">
                <thead class="global-uhl-table-bg">
                    <tr class="text-center">
                        <th>SL</th>
                        <th>Food Name</th>
                        <th>Quantity</th>
                    </tr>
                </thead>
                <tbody>
                    @if (isset($items))
                        @foreach ($items as $index => $item)
                            <tr>
                                <td class="text-center">{{ $loop->iteration }}</td>
                                <td class="text-left">{{ $item->food_name }}</td>
                                <td class="text-center">{{ $item->total_quantity }}</td>
                            </tr>
                        @endforeach
                    @endif
                </tbody>
            </table>
        </div>
    </div>
</div>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            ordering: true,
            bPaginate: true,
            bLengthChange: true,
            bAutoWidth: false,
            columnDefs: [{
                    targets: [0, 2, ],
                    className: 'text-center'
                },
                {
                    targets: [1, ],
                    className: 'text-left'
                }
            ],
            "lengthMenu": [
                [5, 10, 25, 50, 75, 100, -1],
                [5, 10, 25, 50, 75, 100, "All"]
            ],
            "pageLength": 10,
        });
        $('th').addClass('text-center');
    });
</script>
