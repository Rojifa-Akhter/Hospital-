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
                            <th class="text-center" style="width: 30%; text-align: center;">Instrument</th>
                            <th class="text-center" style="width: 5%;">Qty</th>
                            <th class="text-left" style="width: 15%;">Status</th>
                            <th class="text-center" style="width: 40%;">Remarks</th>
                        </tr>
                    </thead>
                    <tbody>
                        @foreach($itemDetails as $index => $itemDetail)
                            <tr>
                                <td>
                                    <input type="checkbox" name="check" value="{{ $itemDetail->requsitiondtl_no_pk }}" class="check" 
                                        {{ $itemDetail->requsitiondtl_no_fk != null ? 'disabled' : '' }}
                                    />
                                </td>
                                <td class="text-center">{{ ++$index }}</td>
                                <td>{{ $itemDetail->item_name }}</td>
                                <td class="text-center">{{ $itemDetail->item_qty }}</td>
                                <td class="text-left">
                                    @if($itemDetail->requsitiondtl_no_fk == null) {{ 'Pending Return' }}
                                    @elseif($itemDetail->requsitiondtl_no_fk && $itemDetail->rtnrcv_ind) {{ 'Received by Dept.' }}
                                    @elseif($itemDetail->requsitiondtl_no_fk && $itemDetail->rtnrcv_ind == null) {{ 'Pending Receive by Dept.' }}
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
