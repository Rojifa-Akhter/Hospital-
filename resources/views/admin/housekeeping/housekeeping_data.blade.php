<div>
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <table class="table data-table table-bordered m-0 data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center " scope="col">SL</th>
                {{-- <th class="text-center " scope="col">Supplier Name</th> --}}
                <th class="text-center " scope="col">Item Name</th>
                <th class="text-center " scope="col">Stock Qty</th>
                <th class="text-center " scope="col">Batch No.</th>
                <th class="text-center " scope="col">Expiry Date</th>
                <th class="text-center " scope="col">Department Name</th>
                <th class="text-center " scope="col">Consumption</th>
            </tr>
        </thead>
        <tbody>
            @if (!empty($hk_data))
                @foreach ($hk_data as $data)
                    <tr>
                        <td class="text-center">{{ $loop->iteration }}</td>
                        {{-- <td class="text-left">{{ $stock->supplier_name }}</td> --}}
                        <td class="text-center">{{ $data->item_name }}</td>
                        <td class="text-center">{{ $data->item_qty }}</td>
                        <td class="text-center">{{ $data->batch_no }}</td>
                        <td class="text-center">{{ date('d/m/y', strtotime($data->expiry_date)) }}</td>
                        <td class="text-center">{{ $data->serviceunit_name }}</td>
                        <td class="text-center"><button class="btn btn-md btn-outline-primary open-modal"
                                data-modal="common-modal-sm" data-action="{{ route('create-consumption',$data->item_no_fk) }}"
                                data-title="Consumption Form">Consumption</button></td>
                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
