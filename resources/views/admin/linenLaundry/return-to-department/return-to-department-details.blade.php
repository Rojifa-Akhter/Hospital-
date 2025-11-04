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
                            <th class="text-center" style="width: 5%;"></th>
                            <th class="text-center" style="width: 5%;">SL.</th>
                            <th class="text-center" style="width: 20%; text-align: center;">Instrument</th>
                            <th class="text-center" style="width: 10%;">Total Qty</th>
                            <th class="text-center" style="width: 15%;">Already Returned Qty</th>
                            <th class="text-center" style="width: 15%;">Pending Return Qty</th>
                            <th class="text-left" style="width: 30%;">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itemDetails as $index => $itemDetail)
                            @php
                                $pendingQty = $itemDetail->item_qty - $itemDetail->alreadyrtn_qty;
                            @endphp
                            <tr class="return-to-department-details">
                                <td>
                                    <input type="checkbox" name="check" value="{{ $itemDetail->requsitiondtl_no_pk }}" class="check" 
                                        {{ $pendingQty == 0 ? 'disabled' : '' }}
                                    />
                                </td>
                                <td class="text-center">{{ ++$index }}</td>
                                <td>{{ $itemDetail->item_name }}</td>
                                <td class="text-center">{{ $itemDetail->item_qty }}</td>
                                <td class="text-center">{{ $itemDetail->alreadyrtn_qty ?? 0 }}</td>
                                <td class="text-center">
                                    @if($pendingQty == 0)
                                        0
                                    @else
                                        <input type="number" class="form-control issue_qty_{{ $itemDetail->requsitiondtl_no_pk }}" id="issue_qty_{{ $itemDetail->requsitiondtl_no_pk }}" name="issue_qty" value="{{ $pendingQty }}" min="0" max="{{ $pendingQty }}" onKeyDown="return false" />
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
                    { targets: [0, 1, 3,], className: 'text-center' },
                    { targets: [2, 4,], className: 'text-left' }
                ],
                "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
                "pageLength": 5
            });
        $('th').addClass('text-center');
    });
</script>
