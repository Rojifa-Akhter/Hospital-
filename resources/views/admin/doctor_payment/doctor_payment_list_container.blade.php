<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<div>
    <table class="table data-table table-bordered table-hover table-striped">
        <thead class="global-uhl-table-bg">
            <tr>
                <th class="text-left">SL#</th>
                <th class="text-left">Doctor Code</th>
                <th class="text-left">Doctor Name</th>
                <th class="text-left">Item Code</th>
                <th class="text-left">Item Name</th>
                <th class="text-left">Effective Date</th>
                <th class="text-left">Doctor percent(%)</th>
                <th class="text-left">Staff percent(%)</th>
                <th class="text-left">Patient Type</th>
                <th class="text-center">Action</th>
            </tr>
        </thead>
        <tbody>
            @if (isset($doctorPaymentData))
                @foreach ($doctorPaymentData as $data)
                    <tr>
                        <td class="text-left">{{ $loop->iteration }}</td>
                        <td class="text-left">{{ $data->person_code }}</td>
                        <td class="text-left">{{ $data->full_name }}</td>
                        <td class="text-left">{{ $data->item_code }}</td>
                        <td class="text-left">{{ $data->item_name }}</td>
                        <td class="text-left">
                            {{ isset($data->effdate) ? date('d-m-Y', strtotime($data->effdate)) : '' }}</td>
                        <td class="text-left">{{ $data->drprcnt }}</td>
                        <td class="text-left">{{ $data->stfpercent }}</td>
                        <td class="text-left">{{ $data->pat_type }}</td>
                        <td>
                            <a class="btn btn-sm btn-primary" href="{{route('doctor-payment-setup', $data->docershare_no_pk)}}"  title="Edit"><i class="fa fa-pencil-alt"></i></a>
                        </td>

                    </tr>
                @endforeach
            @endif
        </tbody>
    </table>
</div>
<script type="application/javascript"
    src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script>
    $('.data-table').DataTable({
        pageLength: 15,
        lengthMenu: [ [15, 30, 50, 100], [15, 30, 50, 100] ]
    });
</script>
