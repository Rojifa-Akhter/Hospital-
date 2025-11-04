<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section id="full_item_list">
    <div class="container-fluid">
        <div class="card">
            <div class="card-header ">
                <h5>Item List <button class="btn btn-sm btn-primary float-right open-modal" data-modal="common-modal-md"
                        data-action="{{ route('item.item-form') }}" data-title="Create New Item">Create
                        Item</button></h5>
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col">Sl#</th>
                                    <th class="text-center" scope="col">Item Name</th>
                                    <th class="text-center" scope="col">Item Generic Name</th>
                                    <th class="text-center" scope="col">Item Type</th>
                                    <th class="text-center" scope="col">Action</th>
                                </tr>
                            </thead>
                            <tbody></tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script>
$(document).ready(function() {
    // $('.data-table').DataTable();

    var datatable = $('.data-table').DataTable({
        "processing": true,
        "serverSide": true,
        "ajax": {
            "url": "{{ url('item/item-list') }}",
            "dataType": "json",
            "type": "POST",
            "data": {
                _token: "{{csrf_token()}}"
            }
        },
        "columnDefs": [{
            "targets": -1,
            "data": "Edit",
            "render": function(data, type, row, meta) {
                var edit_action = '{{ route("item.edit", ":id") }}';
                edit_action = edit_action.replace(':id', row[4]);
                return '<span Class="btn btn-sm btn-primary open-modal" data-id="' + row[
                    4] + '" data-action="' + edit_action +
                    '" data-modal="common-modal-md" data-title="Edit Item" title="Edit"><i class="fa fa-pencil-alt"></i></span>';
            }
        }]
    });
});
</script>
