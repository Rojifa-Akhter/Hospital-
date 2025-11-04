<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<section id="full_lookup_list">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-8 mb-1">
                <h5 class="mt-2 mb-0">Dashboard Item Setup List</h5>
                <small>Settings / Dashboard Setup / Dashboard Item Setup List</small>
            </div>
            <div class="col-md-4 mt-3">
                <button class="btn bg-navy text-white btn-md float-right open-modal" data-modal="common-modal-sm"
                    data-action="{{ route('dashboard-item-setup.create') }}"
                    data-title="Create New Dashboard Item">Create
                    Item Setup</button>
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
                                    <th class="text-center" scope="col">Card Ind</th>
                                    <th class="text-center" scope="col">Chart Ind</th>
                                    <th class="text-center" scope="col">Text Ind</th>
                                    <th class="text-center" scope="col">Dril Down Ind</th>
                                    <th class="text-center" scope="col">Status</th>
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
                                                @if ($item->card_ind == 1)
                                                    <span class="badge  badge-success">Yes</span>
                                                @else
                                                    <span class="badge  badge-danger">No</span>
                                                @endif
                                            </td>
                                            <td  class="text-center">
                                                @if ($item->chart_ind == 1)
                                                    <span class="badge  badge-success">Yes</span>
                                                @else
                                                    <span class="badge  badge-danger">No</span>
                                                @endif
                                            </td>
                                            <td  class="text-center">
                                                @if ($item->text_ind == 1)
                                                    <span class="badge  badge-success">Yes</span>
                                                @else
                                                    <span class="badge  badge-danger">No</span>
                                                @endif
                                            </td>
                                            <td  class="text-center">
                                                @if ($item->drill_down_ind == 1)
                                                    <span class="badge  badge-success">Yes</span>
                                                @else
                                                    <span class="badge  badge-danger">No</span>
                                                @endif
                                            </td>
                                            <td  class="text-center">
                                                @if ($item->status == 1)
                                                    <span class="badge  badge-success">Yes</span>
                                                @else
                                                    <span class="badge  badge-danger">No</span>
                                                @endif
                                            </td>
                                            <td  class="text-center">
                                                <span Class="btn btn-sm btn-primary open-modal" data-id="{{ $item->dash_board_item_set_no_pk }}"
                                                    data-action="{{ route('dashboard-item-setup.edit',$item->dash_board_item_set_no_pk ) }}" data-modal="common-modal-sm" data-title="Edit Item"
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
