<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<table class="table data-table table-bordered">
    <thead class="global-uhl-table-bg">
        <tr>
            <th class="text-center" style="width:3%">Sl#</th>
            <th class="text-left" style="width:10%">Store</th>
            <th class="text-center" style="width:15%">Supplier</th>
            <th class="text-center" style="width:5%">Header SL</th>
            <th class="text-center" style="width:15%">Header</th>
            <th class="text-center" style="width:5%">Terms SL</th>
            <th class="text-center" style="width:32%">Terms & Condition</th>
            <th class="text-center" style="width:5%">Status</th>
            <th class="text-center" style="width:5%">Is Default</th>
            <th class="text-center width-150" style="width:5%">Actions</th>
        </tr>
    </thead>

    @if (isset($po_terms_worklist))
        @foreach ($po_terms_worklist as $data)
            <tr>
                <td>{{ $loop->iteration }}</td>
                <td class="text-left">{{$data->store_name}}</td>
                <td class="text-left">{{$data->supplier_name}}</td>
                <td class="text-center">{{$data->header_sl}}</td>
                <td class="text-left">{{$data->termscon_header}}</td>
                <td class="text-center">{{$data->terms_sl}}</td>
                <td class="text-left">{{$data->termscon_text1}}</td>
                <td class="text-center">
                    @if($data->status == 1)
                        <span class="badge badge-primary">Active</span>
                    @else
                        <span class="badge badge-danger">Inactive</span>
                    @endif

                </td>
                <td class="text-center">
                    @if(isset($data->default_terms_ind))
                        @if($data->default_terms_ind == 1)
                            <span class="badge badge-success">Yes</span>
                        @else
                            <span class="badge badge-warning">No</span>
                        @endif
                    @endif

                </td>
                <td class="text-center">
                    <a href="{{ route('v1.edit-po-terms-conditions', $data->termscon_no_pk) }}"
                    class="btn btn-sm btn-success" title="Edit" ><i class="fas fa-edit"></i></a>
                    <span class="btn btn-sm btn-danger" data-id="{{ $data->termscon_no_pk }}" onclick="removeById(this)" data-url="{{ route('v1.delete-po-terms-conditions',$data->termscon_no_pk) }}" title="Delete"><i class="fas fa-trash"></i></span>

                </td>
            </tr>
        @endforeach
    @endif
</table>

<script type="application/javascript"
    src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script type="application/javascript">
    $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
</script>
