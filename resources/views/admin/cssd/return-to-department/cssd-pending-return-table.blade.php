<table class="table table-striped table-bordered table-hover data_table" id="dataTable">
    <thead class="global-uhl-table-bg">
        <tr>
            {{-- <th class="text-center" style="width: 3%;">
                <input type="checkbox" name="checkAll" class="checkAll" />
            </th> --}}
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
        @forelse($items as $index => $item)
        <tr>
            {{-- <td>
                <input type="checkbox" name="check" value="{{ $item->reqmst_no_pk }}" class="check" {{ $item->rtn_ind == 1 ? 'disabled' : '' }} />
            </td> --}}

            <td onClick="showDetails('{{ $item->reqmst_no_pk }}')">{{ ++$index }}</td>
            <td onClick="showDetails('{{ $item->reqmst_no_pk }}')">{{ $item->reqmst_no_pk }}</td>
            <td onClick="showDetails('{{ $item->reqmst_no_pk }}')">{{ $item->serviceunit_name }}</td>
            <td onClick="showDetails('{{ $item->reqmst_no_pk }}')">{{ !is_null($item->req_date) ? date('d/m/Y', strtotime($item->req_date)) : 'N/A' }}</td>
            <td onClick="showDetails('{{ $item->reqmst_no_pk }}')">{{ $item->remarks }}</td>
            <td onClick="showDetails('{{ $item->reqmst_no_pk }}')">
                @if($item->rtn_ind == 1 && $item->rtnrcv_ind == 1)
                    <span class="badge badge-warning">Received by Dept.</span>
                @elseif($item->rtn_ind == 1 && $item->rtnrcv_ind == 0)
                    <span class="badge badge-info">Send to Dept.</span>
                @else
                    <span class="badge badge-warning">Pending Return</span>
                @endif
            </td>
            <td>
                {{-- <span class="btn btn-sm btn-info btn-md-global open-modal btnView" onClick="showDetails('{{ $item->reqmst_no_pk }}')"><i class="fas fa-eye"></i></span> --}}
                <a href="{{ route('cssd.print', ['id' => $item->reqmst_no_pk]) }}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>
            </td>
        </tr>
        @empty
        <tr>
            <td colspan="7">No data available</td>
        </tr>
        @endforelse
    </tbody>
</table>

<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [1, 2, 3, 4, 6], className: 'text-center' },
                    { targets: [5], className: 'text-left' }
                ],
                "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
                "pageLength": 5
            });
        $('th').addClass('text-center');
    });
</script>
