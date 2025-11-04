
<div class="container-fluid">
    <div style="border-bottom: 1px dotted #c0bebe; margin-bottom: 20px; padding-bottom: 10px;">
        <h2 class="mb-3 text-center">Issued Summary Report</h2>
    </div>
    @foreach ($issuedSummaryGroup as $supplier => $items)
        <div class="card mb-4">
            <div class="card-header bg-light">
                <strong>Supplier:</strong> {{ $supplier ?? 'N/A' }}
            </div>
            <div class="card-body p-0">
                <div class="table-responsive">
                            <table class="table table-bordered table-sm mb-0" style="table-layout: fixed; width: 100%;">
                                <thead class="thead-light">
                                    <tr>
                                        <th class="text-center" style="width: 5%;">SL</th>
                                        <th class="text-center" style="width: 10%;">Item Code</th>
                                        <th class="text-left" style="width: 30%;">Item Name</th>
                                        <th class="text-right" style="width: 10%;">Current Stock</th>
                                        <th class="text-right" style="width: 10%;">Total Issued</th>
                                        <th class="text-right" style="width: 15%;">Last 3 Months Issued</th>
                                        <th class="text-right" style="width: 10%;">Last Month Issued</th>
                                        <th class="text-right" style="width: 10%;">Avg. L3M Issued</th>
                                    </tr>
                                </thead>
                                <tbody>
                                    @foreach ($items as $index => $item)
                                        <tr>
                                            <td class="text-center">{{ $loop->iteration }}</td>
                                            <td class="text-center">{{ $item->item_no_pk }}</td>
                                            <td class="text-left" style="white-space: normal; word-wrap: break-word;">{{ $item->item_name }}</td>
                                            <td class="text-right">{{ number_format($item->current_stock, 2) }}</td>
                                            <td class="text-right">{{ number_format($item->total_issued, 2) }}</td>
                                            <td class="text-right">{{ number_format($item->l3missued, 2) }}</td>
                                            <td class="text-right">{{ number_format($item->lmissued, 2) }}</td>
                                            <td class="text-right">{{ number_format($item->l3maissued, 2) }}</td>
                                        </tr>
                                    @endforeach
                                </tbody>
                            </table>
                </div>
            </div>
        </div>
    @endforeach

</div>