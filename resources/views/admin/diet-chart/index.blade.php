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
                <h5 class="mt-2 mb-0">Diet Chart</h5>
                <small>Diet Chart / Diet Chart Listing</small>
            </div>
            <div class="col-lg-5 col-md-5 col-12 mt-2">
                <div class="text-right">
                    {{-- <button type="button" class="open-modal btn btn-success uhl_common_outline_btn" data-modal="common-modal-sm" data-title="Diet Chart Create" data-action="{{ route('dietChart.create') }}">
                        Diet Chart Create
                    </button> --}}
                    <a rel="tab" href="{{ route('dietChart.create') }}" class="btn btn-success uhl_common_outline_btn">Create</a>
                </div>
            </div>
        </div>
        <div class="row mt-3">
            <div class="col-lg-12">
                <div class="card">
                    <div class="card-header">
                        <form action="{{ route('dietChart.reportV1') }}" method="POST" target="_blank">
                            @csrf
                            <span class="float-right">
                                <button type="submit" class="btn btn-info btn-md-global" id="downloadPdf"><i class="fa fa-file"></i> Report</button>
                            </span>
                        </form>
                    </div>
                    <div class="card-body">
                        <div class="table-responsive">
                            @include('admin.diet-chart.table')
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="text/javascript">
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
