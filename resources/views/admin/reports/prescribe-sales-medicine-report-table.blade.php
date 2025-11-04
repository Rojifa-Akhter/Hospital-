<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-md-6">
                <div class="card-header">Prescribe Medicine</div>
                @foreach($prescribeMedicine as $idx => $items)
                    <div class="table-responsive mt-2">
                        <h4 class="text-center" style="border-bottom: 1px solid gray;">Doctor Name: {{ $idx }}</h4>
                        <table class="table table-striped table-bordered table-hover data_table_prescribe_medicine table" id="dataTablePrescribeMedicine">
                            <thead class="global-uhl-table-bg">
                                <tr>
                                    <th class="text-center" style="width: 5%;">SL.</th>
                                    <th class="text-left" style="width: 65%;">Generic Name</th>
                                    <th class="text-left" style="width: 30%;">Brand Name</th>
                                </tr>
                            </thead>
                            <tbody style="cursor: pointer;" id="tableBody">
                                @foreach($items as $index => $item)
                                <tr>
                                    <td class="text-center" style="width: 5%;">{{ ++$index }}</td>
                                    <td class="text-left" style="width: 65%;">{{ substr($item->generic_name, 0, 60) }}</td>
                                    <td class="text-left" style="width: 30%;">{{ $item->item_name }}</td>
                                </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                @endforeach
            </div>
            <div class="col-md-6">
                <div class="card-header">Sales Medicine</div>
                <div class="table-responsive mt-3">
                    <table class="table table-striped table-bordered table-hover data_table" id="dataTableSalesMedicine">
                        <thead class="global-uhl-table-bg">
                            <tr>
                                <th class="text-left" style="width: 75%;">Generic Name</th>
                                <th class="text-left" style="width: 25%;">Brand Name</th>
                            </tr>
                        </thead>
                        <tbody style="cursor: pointer;" id="tableBody">
                            @foreach($salesMedicine as $item)
                            <tr>
                                <td class="text-left" style="width: 75%;">{{ substr($item->generic_name, 0, 70) }}</td>
                                <td class="text-left" style="width: 25%;">{{ $item->item_name }}</td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('.data_table_prescribe_medicine').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [0], className: 'text-center' },
                    { targets: [1, 2], className: 'text-left' }
                ],
                "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
                "pageLength": 10
            });
        $('th').addClass('text-center');

        $('#dataTableSalesMedicine').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [], className: 'text-center' },
                    { targets: [0, 1], className: 'text-left' }
                ],
                "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
                "pageLength": 25
            });
        $('th').addClass('text-center');
    });
</script>
