<div class="col-sm-12 col-lg-5 col-xl-12">
    <div class="card-body">
        <div class="row mt-2">
            <div class="col-md-12 table-responsive">
                <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                    <thead class="bg-primary">
                        <tr>
                            <th class="text-center" scope="col">Sl#</th>
                            <th class="text-center" scope="col">Item Name</th>
                            <th class="text-center" scope="col">Qty</th>
                            {{-- <th class="text-center width-150" scope="col">Actions</th> --}}
                        </tr>
                    </thead>
                    <tbody>
                        @if ($item_data)
                            @foreach ($item_data as $data)
                                <tr>
                                    <td class="text-center">{{ $loop->iteration }}</td>
                                    <td class="text-center">
                                        {{ !empty($data->med_name) ? $data->med_name : '' }}
                                    </td>
                                    <td class="text-right">
                                        {{ !empty($data->med_qty) ? $data->med_qty : '' }}
                                    </td>
                            @endforeach
                        @endif
                    </tbody>
                </table>
            </div>
        </div>
    </div>
</div>
