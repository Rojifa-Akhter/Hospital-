<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />




<table class="table data-table table-bordered m-0 data-table">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center " scope="col">SL</th>
            <th class="text-center "  scope="col">Adj. Date</th>
            <th class="text-center "width="20%" scope="col">Adj. By</th>
            <th class="text-left " scope="col">Store Name</th>
            <th class="text-left " scope="col">Item Name
            </th>
            <th class="text-right " scope="col">Adj.Qty</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($consumption_data))
            @foreach ($consumption_data as $data)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    {{-- <td class="text-left">{{ $stock->supplier_name }}</td> --}}
                    <td class="text-center">{{ date('d/m/Y',strtotime($data->trans_date)) }}</td>

                    <td class="text-left">{{ $data->user_fullname }}</td>
                    <td class="text-left">{{ $data->serviceunit_name }}</td>
                    <td class="text-left">{{ $data->item_name }}</td>

                    <td class="text-right">{{ $data->item_qty }}</td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
    </script>
<script>
    $(document).ready(function() {
        var table = $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": true,
            "bLengthChange": false,
            "bAutoWidth": false
        });

    });
</script>
