<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<style>
    .text-left {
        text-align:left;
    }
</style>

<section id="full_appointment">
    <div class="container-fluid">
        <div class="row bg-white border-bottom sticky-top shadow-sm">
            <div class="col-md-7 mb-1">
                <h5 class="mt-2 mb-0">Diet Food</h5>
                <small>Diet Food / Diet Food Listing</small>
            </div>
            <div class="col-lg-5 col-md-5 col-12 mt-2">
                <div class="text-right">
                    <button type="button" class="open-modal btn btn-success uhl_common_outline_btn" data-modal="common-modal-sm" data-title="Diet Foods Create" data-action="{{ route('dietFoods.create') }}">
                        Diet Food Create
                    </button>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-body">
                        <div class="table-responsive">
                            <table class="table table-striped table-bordered table-hover data_table" id="dataTable">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th class="text-center" style="width: 5%;">SL.</th>
                                        <th class="text-center" style="width: 5%;">ID No.</th>
                                        <th class="text-center" style="width: 20%;">Diet Time</th>
                                        <th class="text-center" style="width: 50%;">Food Name</th>
                                        <th class="text-left" style="width: 10%;">Status</th>
                                        <th class="text-center" style="width: 10%;">Action</th>
                                    </tr>
                                </thead>
                                <tbody style="cursor: pointer;">
                                    @if(isset($items))
                                        @foreach($items as $item)
                                        <tr>
                                            <td>{{ $loop->iteration }}</td>
                                            <td>{{ $item->dietfood_no_pk }}</td>
                                            <td>{{ $item->diet_name }} ({{ $item->diet_time != '' ? date('h:ia', strtotime($item->diet_time)) : '' }})</td>
                                            <td>{{ $item->food_name }}</td>
                                            <td>
                                                @if($item->status == "1")
                                                    <span class="badge badge-success">Active</span>
                                                @else
                                                    <span class="badge badge-warning">Inactive</span>
                                                @endif
                                            </td>
                                            <td>
                                                <button type="button" class="open-modal btn btn-success btn-sm" data-modal="common-modal-sm" data-title="Diet Food Update" data-action="{{ route('dietFoods.edit', ['id' => $item->dietfood_no_pk]) }}"><i class="fa fa-edit"></i></button>
                                                <button type="button" onclick="deleteDietFood({{ $item->dietfood_no_pk }})" Class="btn btn-sm btn-danger" title="Delete Diet Food"><i class="fa fa-trash"></i></a>
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
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
    $(document).ready(function() {
        $('#dataTable').DataTable({
            searching: true,
            columnDefs: [
                    { targets: [0, 1, 4, 5,], className: 'text-center' },
                    { targets: [2, 3,], className: 'text-left' }
                ],
                "lengthMenu": [[5, 10, 25, 50, 75, 100, -1], [5, 10, 25, 50, 75, 100, "All"]],
                "pageLength": 10
            });
        $('th').addClass('text-center');
    });

    function deleteDietFood(id)
    {
        var route = '{{ route("dietFoods.delete", ":id") }}';
        route = route.replace(':id', id);

        if(confirm('Are you sure to delete?')) {
            $.ajax({
                data: null,
                url: route,
                type: "DELETE",
                beforeSend: function() {
                    blockUI();
                },
                success: function(response) {
                    if(response.title == "Success") {
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html("<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html("Success");
                        $('.common-modal-notify .modal-body').html(response.msg);
                    }

                    setTimeout(() => {
                        window.location.reload();
                    }, 3000);
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }
    }
</script>
