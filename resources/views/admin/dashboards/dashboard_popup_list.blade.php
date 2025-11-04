<table class="table table-bordered table-hover mb-0 table-responsive inv_list">
    <thead class="bg-flat-color-13">
        <tr>
            <th class="text-center">SL#</th>
            <th class="text-left">Date</th>
            <th class="text-left">Investigation</th>
            <th class="text-left">Doctor</th>
            <th class="text-left">Department</th>
            <th class="text-right">Sale Amount</th>
            <th class="text-center">Discount</th>
            {{-- <th class="text-right">Amount</th> --}}
        </tr>
    </thead>

    <tbody>

        <?php
        // $total_sales = $total_amount = $total_discount = 0 ;
        ?>

        {{-- @if (!empty($pop_up_list_data))
        @foreach ($pop_up_list_data as $data)
                <tr>
                    <td class="text-center">{{$loop->iteration}}</td>
                    <td class="text-left">{{ date("d/m/y", strtotime($data->ledger_date)) }}</td>
                    <td class="text-left">{{$data->item_name}}</td>
                    <td class="text-left">{{$data->full_name}}</td>
                    <td class="text-left">{{$data->serviceunit_name}}</td>
                    <td class="text-right">{{number_format($data->sales,2)}}</td>
                    <td class="text-center">{{number_format($data->discount,2)}}</td>
                    <td class="text-right">{{number_format($data->amount,2)}}</td>
                    <div style="display: none;"> {{$total_sales += $data->sales }} </div>
                    <div style="display: none;"> {{$total_amount += $data->amount }} </div>
                    <div style="display: none;"> {{$total_discount += $data->discount }} </div>
                </tr>
    @endforeach
    @endif --}}


        {{-- <tfoot>
    <tr class="bg-flat-color-13">
        <th class="text-right" colspan="5">Total&nbsp;:</th>
        <th class="text-right">{{number_format($total_sales,2)}}</th>
        <th class="text-right">{{number_format($total_discount,2)}}</th>
        <th class="text-right">{{number_format($total_amount,2)}}</th>
    </tr>
    </tfoot> --}}
    </tbody>
</table>



<script>
    // Server Side Redering
    $(document).ready(function() {
        var id = $('#type').val();
        var datatable = $('.inv_list').DataTable({
            "processing": true,
            "serverSide": true,
            "pageLength": 20,
            "order": [
                [0, "desc"]
            ],
            "ajax": {
                "url": "{{ route('dashboard.investigation-popup-data') }}",
                "dataType": "json",
                "type": "get",
                "data": {
                    id: id,
                    // _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [{
                    "targets": 0,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {


                        return `${meta.row + 1}`;
                    }
                },
                {
                    "targets": 1,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[1]}`;
                    }
                },
                {
                    "targets": 2,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[2]}`;
                    }
                },
                {
                    "targets": 3,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[3]}`;
                    }
                },
                {
                    "targets": 4,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[4]}`;
                    }
                },
                {
                    "targets": 5,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[5]}`;
                    }
                },
                {
                    "targets": 6,
                    // "data": "Edit",
                    "render": function(data, type, row, meta) {

                        return ` ${row[6]}`;
                    }
                },
            ]
        });
    });
</script>
