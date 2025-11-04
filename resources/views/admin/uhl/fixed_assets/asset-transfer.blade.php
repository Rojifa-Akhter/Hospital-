<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
{{-- <style>
    tr th,
    tr td {
        white-space: nowrap;
    }
</style> --}}
<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <form action="#">
        <section class="fixed_assets">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div
                            class="row justify-content-between align-items-center bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-6">
                                <h5 class="mt-2 mb-0">Equipment Transfer</h5>
                                <small>Equipment / Equipment Transfer</small>
                            </div>
                            <div class="col-md-6">
                                <div class="custom__radio">
                                    <form>
                                        <label class="radio-inline">
                                            <input type="radio" name="optradio" id="requested" value="requested"
                                                onchange="search_list()" checked>Requested
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="optradio" id="transferred" value="transferred"
                                                onchange="search_list()">Transferred
                                        </label>
                                        <label class="radio-inline">
                                            <input type="radio" name="optradio" id="all" value="all"
                                                onchange="search_list()">All
                                        </label>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </div>


                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-header">
                                <h5><i class="fa fa-search"></i> Search</h5>
                            </div>
                            <div class="card-body">
                                <form action="" id="asset_search_form" method="post">
                                    @csrf

                                    <input type="hidden" id="input_type" name="status" value="requested">
                                    <div class="form-row justify-content-center">
                                        <div class="col-md-3">
                                            <label class="col-form-label col-form-label-sm" for="asset_tag">Asset
                                                Tag</label>
                                            <input type="text" class="form-control form-control-sm m-0 "
                                                id="asset_tag" name="asset_tag" value="" placeholder="Asset Tag">
                                        </div>
                                        <div class="col-md-6">
                                            <div class="form-group">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="search_date_from">Transfer Req. date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">From</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="search_date_from" name="search_date_from"
                                                        value="{{ date('d/m/Y') }}" placeholder="dd/mm/yyyy"
                                                        autocomplete="off">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="search_date_to" name="search_date_to"
                                                        value="{{ date('d/m/Y') }}" placeholder="dd/mm/yyyy"
                                                        autocomplete="off">
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-md-2 mt-2">
                                            <div class="btn-group btn-block" role="group">
                                                <button type="button" id="asset_register_search"
                                                    class="btn btn-md btn-success mt-3">Search</button>
                                            </div>
                                        </div>
                                    </div>
                                </form>
                            </div>
                        </div>
                    </div>



                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">

                                            <tr>
                                                <th>SL#</th>
                                                <th>Asset Tag</th>
                                                <th>Transfer Req. date</th>
                                                <th>Asset Age</th>
                                                <th>Asset ID</th>
                                                <th>Description</th>
                                                {{-- <th>Asset Type</th> --}}
                                                {{-- <th>Category</th>
                                                <th>Class</th> --}}
                                                <th>Acquisition Date</th>
                                                {{-- <th>Current Store</th> --}}
                                                <th>Current Location </th>
                                                <!-- <th>Person Incharge</th> -->
                                                {{-- <th>To Store</th> --}}
                                                <th>To Location</th>
                                                <!-- <th>To Department</th> -->
                                                {{-- <th>Under Department</th> --}}
                                                <th>To Person Incharge</th>
                                                <th>Status</th>
                                                <th>Action</th>
                                            </tr>


                                        </thead>
                                        <tbody id="asset_transfer_list">
                                            @include('admin.uhl.fixed_assets.asset-transfer-list')

                                        </tbody>
                                    </table>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>

</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    $('.select2').select2();
    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    });

    function search_list() {

        var inputType = $('input[name="optradio"]:checked').val();
        $('#input_type').val(inputType)
        console.log($('input[name="optradio"]:checked').val())
        $.ajax({
            url: "{{ route('v1.asset-transfer-conform-search') }}",
            type: "POST",
            data: {
                status: $('input[name="optradio"]:checked').val(),
                // asset_type: $('#asset_type').val(),
                // department_asset: $('#department_asset').val(),
                // class_asset: $('#class_asset').val(),
                // category_asset: $('#category_asset').val(),
                // current_store: $('#current_store').val(),
                // received_date_from: $('#received_date_from').val(),
                // received_date_to: $('#received_date_to').val(),
                // asset_location: $('#asset_location').val(),
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                console.log(data);
                $("#asset_transfer_list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }


    $(document).on("click", "#asset_register_search", function(e) {
        var formID = $("#asset_search_form").attr("id");
        var formMethod = $("#asset_search_form").attr("method");

        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ route('v1/asset-transfer-conform-search-form') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#asset_transfer_list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
