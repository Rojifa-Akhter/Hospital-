<h3 class="text-center">{{ $items->first()->full_name ?? 'Data not available' }}</h3>

<table class="table table-bordered" border="1">
    <thead class="global-uhl-table-bg">
        <tr>
            <td class="text-center" scope="col">#SL</td>
            <td class="text-center" scope="col">Uniform Type</td>
            <td class="text-center" scope="col">Qty</td>
        </tr>
    </thead>
    <tbody>
        @forelse ($items as $data)
            <tr>
                <td class="text-center" scope="col">{{ $loop->iteration }}</td>
                <td class="text-center" scope="col">{{ $data->item_short_name }}</td>
                <td class="text-center" scope="col">{{ $data->qty }}</td>
            </tr>            
        @empty
            <tr>
                <td colspan="3" class="text-center text-danger">No Data Found</td>
            </tr>
        @endforelse
    </tbody>
</table>
