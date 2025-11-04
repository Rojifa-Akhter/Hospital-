<div>


    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />

    <table class="table data-table table-bordered m-0 data-table">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-center " scope="col">SL</th>
                <th class="text-left " scope="col">Item Name</th>
                <!-- <th class="text-left " scope="col">Internal Batch No</th>
                <th class="text-left " scope="col"> Batch No</th>
                <th class="text-left " scope="col"> Expired Date</th> -->
                <th class="text-center " scope="col">Qty</th>
                <th class="text-center " scope="col">Re Order label</th>
                <th class="text-center " scope="col">UoM</th>
                <!-- <th class="text-right " scope="col">Purchase Price</th> -->
                <th class="text-left " scope="col">Department</th>
                <!-- <th class="text-center " scope="col">Action</th> -->
            </tr>
        </thead>
        <tbody>
           
            @if (!empty($data))
            @foreach ($data as $value)
           
            <tr>

                <td class="text-center " scope="col">{{$loop->iteration}}</td>
                <td class="text-left " scope="col"> {{$value->item_name}}</td>
                <td class="text-center " scope="col">{{$value->item_qty}}</td>
                <td class="text-center " scope="col">{{$value->re_order_level}}</td>
                <td class="text-center " scope="col">{{$value->uom_code}}</td>            
                <td class="text-left " scope="col">{{$value->serviceunit_name}}</td>            
            </tr>
            @endforeach
            @endif
        </tbody>
    </table>
</div>