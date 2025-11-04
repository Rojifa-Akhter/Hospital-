<div>
<table class="table data-table table-bordered m-0 data-table">
    <thead class="bg-primary">
        <tr>
            <th class="text-center " scope="col">SL</th>
            <th class="text-center " scope="col">Scrap No</th>
            <th class="text-left " scope="col">Scrap Date</th>
            <th class="text-left " scope="col">Supplier Name</th>
            <th class="text-left " scope="col">Store</th>
            <th class="text-center " scope="col">No of Item</th>
            <th class="text-center " scope="col">Status</th>
            <th class="text-center " scope="col">Action</th>
        </tr>
    </thead>
    <tbody>
        @if (!empty($disposal_mst))
            @foreach ($disposal_mst as $stock)
                <tr>
                    <td class="text-center">{{ $loop->iteration }}</td>
                    <td class="text-center">{{ $stock->disposalmst_no_pk }}</td>
                    <td class="text-left">{{ $stock->disposalmst_date !=""? date('d/m/Y',strtotime($stock->disposalmst_date)):'' }}</td>
                    <td class="text-left">{{ $stock->supplier_name }}</td>
                    <td class="text-left">{{ $stock->serviceunit_name }}</td>
                    <td class="text-center">{{ $stock->item_count }}</td>
                    <td class="text-center">
                        @if ($stock->post_ind == 1)
                            <span class="badge bg-success ">Posted</span>
                        @else
                            <span class="badge bg-warning ">Draft</span>
                        @endif
                    </td>                
                    <td class="text-center">
                        @php
                            $disabled=$stock->post_ind ==1 ? 'disabled' :'';
                        @endphp
                        <a  href="{{route('pharmacy.expired_medicine_disposal',$stock->disposalmst_no_pk)}}" target="_blank" {{$disabled}}><i class="fas fa-edit"></i></a>

                        <a  href="{{route('pharmacy.expired_medicine_disposal_report_print',$stock->disposalmst_no_pk)}}" target="_blank"><i class="fa fa-print" aria-hidden="true"></i></a>
                    </td>
                </tr>
            @endforeach
        @endif
    </tbody>
</table>
</div>
