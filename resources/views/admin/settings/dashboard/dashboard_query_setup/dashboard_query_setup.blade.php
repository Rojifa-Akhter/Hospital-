<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-8 mb-1">
                <h5 class="mt-2 mb-0">Dashboard Item Query Setup List</h5>
                <small>Settings / Dashboard Setup / Dashboard Item Query Setup List</small>
            </div>
            <div class="col-md-4 mt-3">
                <button class="btn bg-navy text-white btn-md float-right open-modal" data-modal="common-modal-md"
                    data-action="{{ route('dashboard-item-query-setup.create') }}"
                    data-title="Create New Dashboard Query Setup">Create
                    Item Query Setup</button>
            </div>

        </div>
        <div class="card">
            <div class="card-header">
                <h5>Dashboard Item Setup
            </div>

            <div class="card-body">
                <div class="row mt-2">
                    <div class="col-md-12 table-responsive">
                        <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                            <thead class="bg-primary">
                                <tr>
                                    <th class="text-center" scope="col">Sl#</th>
                                    <th class="text-left" scope="col">Dashboard Items
                                    </th>
                                    <th class="text-left" scope="col">Dashboard Items Query
                                    </th>
                                    <th class="text-center" scope="col">Where Cluase</th>
                                    <th class="text-center" scope="col">Where Clause Column</th>
                                    <th class="text-center" scope="col">Detail Query</th>
                                    <th class="text-center" scope="col">No of Detail Column</th>
                                    <th class="text-center width-150" scope="col">Actions</th>
                                </tr>
                            </thead>
                            <tbody>
                                @if (!empty($item_list))
                                    @foreach ($item_list as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->dashboard_items }}</td>
                                            <td>
                                                {{ $item->dash_board_item_query }}
                                            </td>
                                            <td  class="text-center">
                                                {{ $item->where_clause }}
                                            </td>
                                            <td  class="text-center">
                                                {{ $item->where_clause_column }}
                                            </td>
                                            <td  class="text-center">
                                                {{ $item->detail_query }}
                                            </td>
                                            <td  class="text-center">
                                                {{ $item->no_of_detail_column }}
                                            </td>
                                            <td  class="text-center">
                                                <span Class="btn btn-sm btn-primary open-modal" data-id="{{ $item->dash_board_item_query_no_pk }}"
                                                    data-action="{{ route('dashboard-item-query-setup.edit',$item->dash_board_item_query_no_pk ) }}" data-modal="common-modal-md" data-title="Edit Item"
                                                    title="Edit"><i class="fa fa-pencil-alt"></i></span>
                                            </td>
                                        </tr>
                                    @endforeach
                                @endif

                            </tbody>
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
        var datatable = $('.data-table').DataTable();
    });
</script>
