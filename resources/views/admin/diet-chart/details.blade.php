<table class="table table-striped table-bordered table-hover data_table" id="dataTable">
    <tbody style="cursor: pointer;">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center" style="width: 20%;">Diet Time</th>
                <th class="text-center" style="width: 80%;">Foods</th>
            </tr>
        </thead>
        @if(isset($result))
            @foreach($result as $idx => $item)
            <tr>
                <td style="width: 20%" class="text-left">{{ $idx }}</td>
                <td style="width: 80%" class="text-left">{{ implode(", ", $item) }}</td>
            </tr>
            @endforeach
        @endif
    </tbody>
</table>
