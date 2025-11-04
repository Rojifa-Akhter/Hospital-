<div class="row">
    <div class="col-12 table-responsive mt-3">
        <table class="table data-table table-striped table-bordered table-hover">
            <thead class="bg-primary">
                <tr>
                    <th class="text-center ">SL</th>
                    <th class="text-center">Issue From</th>
                    <th class="text-center">Issue To</th>
                    <th class="text-center">Description</th>
                    <th class="text-center">Referance</th>
                    <th class="text-center">Item Name</th>
                    <th class="text-center ">UoM</th>
                    <th class="text-center ">Item Quantity</th>

                </tr>
            </thead>
            <tbody id="adjust_worklist">
                @if (!empty($issue_worklist))
                    @foreach ($issue_worklist as $row)
                        <tr>
                            <td>{{ $loop->iteration }}</td>
                            <td>{{ $row->su_name_from }}</td>
                            <td>{{ ucfirst($row->issue_to) }}</td>
                            <td>
                                @if ($row->issue_to == 'EVENT')
                                    {{ $row->event_name }}
                                @elseif($row->issue_to=="STORE")
                                    {{ $row->su_name_to }}
                                @else
                                    {{ $row->patient_name_rank }}
                                @endif
                            </td>
                            <td>{{ $row->itemissue_uid }}</td>
                            <td>{{ $row->item_name }}</td>
                            <td>{{ $row->uom_name }}</td>
                            <td>{{ $row->item_qty }} {{ $row->uom_name }}</td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
        </table>
    </div>
</div>
