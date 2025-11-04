<table class="table table-striped table-bordered table-hover data_table" id="dataTable">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center" style="width: 3%;">
                {{-- <input type="checkbox" name="checkAll" class="checkAll" /> --}}
            </th>
            <th class="text-center" style="width: 5%;">SL.</th>
            <th class="text-center" style="width: 5%;">ID No.</th>
            <th class="text-center" style="width: 20%;">Department</th>
            <th class="text-left" style="width: 10%;">Date</th>
            <th class="text-left" style="width: 40%;">Remarks</th>
            <th class="text-center" style="width: 5%;">Status</th>
            <th class="text-center" style="width: 10%;">Action</th>
        </tr>
    </thead>
    <tbody style="cursor: pointer;" id="tableBody">
        @foreach($items as $index => $item)
        <tr>
            <td>
                <input type="checkbox" name="check" value="{{ $item->reqmst_no_pk }}" class="check" {{ $item->rcv_ind == 1 ? 'disabled' : '' }} />
            </td>
            <td onClick="showDetails('{{ $item->reqmst_no_pk }}')">{{ ++$index }}</td>
            <td onClick="showDetails('{{ $item->reqmst_no_pk }}')">{{ $item->reqmst_no_pk }}</td>
            <td onClick="showDetails('{{ $item->reqmst_no_pk }}')">{{ $item->serviceunit_name }}</td>
            <td onClick="showDetails('{{ $item->reqmst_no_pk }}')">{{ !is_null($item->req_date) ? date('d/m/Y', strtotime($item->req_date)) : 'N/A' }}</td>
            <td onClick="showDetails('{{ $item->reqmst_no_pk }}')">{{ $item->remarks }}</td>
            <td onClick="showDetails('{{ $item->reqmst_no_pk }}')">
                @if($item->rcv_ind == 1)
                    <span class="badge badge-info">Received</span>
                @else
                    <span class="badge badge-warning">Receive Pending</span>
                @endif    
            </td>
            <td>
                {{-- <span class="btn btn-sm btn-info btn-md-global open-modal btnView" onClick="showDetails('{{ $item->reqmst_no_pk }}')"><i class="fas fa-eye"></i></span> --}}
                <span class="btn btn-sm btn-info open-modal btnView" onClick="showHistory('{{ $item->reqmst_no_pk }}')"><i class="fas fa-history"></i></span>
                <a href="{{ route('linenLaundry.print', ['id' => $item->reqmst_no_pk]) }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>
            </td>
        </tr>
        @endforeach
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [1, 2, 4, 6], className: 'text-center' },
                    { targets: [5], className: 'text-left' }
                ],
                "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
                "pageLength": 5
            });
        $('th').addClass('text-center');
    });
</script>
