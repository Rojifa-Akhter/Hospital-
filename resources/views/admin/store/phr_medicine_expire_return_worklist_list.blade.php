<div>
    {{-- <h3>Total Item Qty = {{ array_sum($total_item) }} , Total Purchase Price =
        {{ number_format(array_sum($total_amt), 2) }} , Total Sales Price
        ={{ number_format(array_sum($total_sales_amt), 2) }} </h3> --}}
        <table class="table data-table table-bordered m-0 data-table">
            <thead class="bg-primary">
                <tr>
                    <th class="text-center " scope="col">SL</th>
                    <th class="text-center " scope="col">Return No</th>
                    <th class="text-center " scope="col">Return Type</th>
                    <th class="text-left " scope="col">Supplier Name</th>
                    <th class="text-center " scope="col">No Of Item</th>
                    <th class="text-left " scope="col">Return Date</th>
                    <th class="text-center " scope="col">Action</th>

                </tr>
            </thead>
            <tbody>
                @if (!empty($expire_med_list))
                    @foreach ($expire_med_list as $value)
                        <tr>
                            <td class="text-center">{{ $loop->iteration }}</td>
                            <td class="text-center" >{{ $value->return_no }}</td>
                            <td class="text-center">{{ $value->expire_return_code }}</td>
                            <td class="text-left">{{ $value->supplier_name }}</td>
                            <td class="text-center" >{{ $value->total_item }}</td>
                            <td class="text-left"> {{ $value->au_entry_at != '' ? date('d/m/Y', strtotime($value->au_entry_at)) : '' }}</td>

                            <td class="text-center" > <a href="{{route('pharmacy.expire-return-pdf',$value->return_no)}}" target="_blank" rel="noopener noreferrer"><i class="fa fa-print" aria-hidden="true"></i>
                            </a> </td>
                        </tr>
                    @endforeach
                @endif
            </tbody>
            <tfoot>

            </tfoot>
        </table>


</div>
