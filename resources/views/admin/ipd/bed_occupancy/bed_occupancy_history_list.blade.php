<div class="table-responsive border-top border-right">
    <table class="table table-bordered table-hover mb-0">
        <thead class="bg-light-blue">
            <tr>
                <th class="text-center" scope="col">SL</th>
                <th class="text-center" style="width: 30%;" scope="col">Bed</th>
                <th class="text-center" style="width: 30%;" scope="col">Ward</th>
                <th class="text-center" style="width: 20%;" scope="col">Occupied Date</th>
                <th class="text-center" style="width: 20%;" scope="col">Average Length of Stay</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($data))
                @foreach ($data as $key => $row)
                    <tr>
                        <td class="text-center bg-light">{{ $loop->iteration }}</td>
                        <td class="text-center">{{ $row->bed }} </td>
                        <td class="text-center">{{ $row->word }}</td>
                        <td class="text-center">
                            {{ $row->total_patient }}</td>
                        <td class="text-center">{{ $row->avg_length_of_stay }}</td>
                    </tr>
                @endforeach
            @else
                <tr>
                    <th class="text-center" scope="col" colspan="5">No Data Available</th>
                </tr>
            @endif
        </tbody>
    </table>
</div>
