<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<div class="table-responsive">
    <table class="table table-bordered table-hover table-striped data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th>SL</th>
                <th>Indent No</th>
                <th>Issue No</th>
                <th style="text-align: left">Issue Date</th>
                <th style="text-align: left">Issue By</th>
                <th style="text-align: left">From Department</th>
                <th style="text-align: left">To Department</th>
                <th>Action</th>

            </tr>

        </thead>
        <tbody>
            @if (!empty($issued_requisition_list))
                @foreach ($issued_requisition_list as $row)
                    <tr>
                        <td>{{ $loop->iteration }}</td>
                        <td style="text-align: center">{{ $row->indent_no }}</td>
                        <td style="text-align: center">{{ $row->issue_no }}</td>
                        <td>{{ date('d-m-Y', strtotime($row->issue_at)) }}</td>
                        <td>{{ $row->issue_by }}</td>
                        <td style="text-align: left">{{ $row->issue_from_store }}</td>
                        <td style="text-align: left">{{ $row->issue_to_store }}</td>
                        <td>
                            <a href="{{route('v1.issue-print-pdf',$row->issue_no)}}" target="_blank" class="btn btn-sm btn-primary"><i class="fas fa-print"></i></a>
                        </td>

                    </tr>

                @endforeach

            @endif
        </tbody>
    </table>
</div>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    $(document).ready(function() {
        // Initialize DataTable
        $('.data-table').DataTable({
            "ordering": true,  // Enable column sorting
            "bPaginate": true, // Enable pagination
            "bLengthChange": true, // Allow changing the number of entries per page
            "bAutoWidth": false, // Disable auto column width
            "columnDefs": [
                { "type": "date", "targets": 3 }, // Ensure Issue Date column is sorted as date
                { "orderable": true, "targets": [1, 2, 3] } // Enable sorting for Indent No, Issue No, and Issue Date columns
            ],
            "order": [[3, 'desc']] // Sort by Issue Date (3rd column) by default in descending order
        });
    });
</script>
