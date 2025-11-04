<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style>
    tr th,
    tr td {
        white-space: nowrap;
    }
    .description_val:hover {
        color: #1d68a7 !important;
        text-decoration: underline !important;
        cursor: pointer !important;
    }
</style>
<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <form action="#">
        <section class="fixed_assets">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-10">
                                <h5 class="mt-2 mb-0">Equipment Register</h5>
                                <small>Equipment / Equipment Register</small>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <form action="#" id="assetForm" method="post">
                            <div class="card">
                                <div class="card-body border-bottom-3 p-2">
                                    <div class="form-row">
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="asset_id" class="col-sm-4 col-form-label">Asset Id</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="asset_id" name="asset_id" placeholder="" />
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="asset_location"
                                                    class="col-sm-4 col-form-label">Location</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm select2"
                                                        id="asset_location" name="asset_location">
                                                        <option value="">Select Location</option>
                                                        @if (!empty($location))
                                                            @foreach ($location as $value)
                                                                <option value="{{ $value->room_no_pk }}">
                                                                    {{ $value->room_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="asset_type" class="col-sm-4 col-form-label">Asset
                                                    Type</label>
                                                <div class="col-sm-8"><input type="text"
                                                        class="form-control form-control-sm" id="asset_type"
                                                        name="asset_type" placeholder="" /></div>
                                            </div>
                                        </div>
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="major_group" class="col-sm-4 col-form-label">Major
                                                    Group</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm select2"
                                                        id="major_group" name="major_group">
                                                        <option value="">Select</option>
                                                        @if (!empty($major_group))
                                                            @foreach ($major_group as $value)
                                                                <option value="{{ $value->itemtype_code }}">
                                                                    {{ $value->item_type_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="minor_group" class="col-sm-4 col-form-label">Minor
                                                    Group</label>
                                                <div class="col-sm-8">

                                                    <select class="form-control form-control-sm select2"
                                                        id="minor_group" name="minor_group">
                                                        <option value="">Select</option>
                                                        @if (!empty($minor_group))
                                                            @foreach ($minor_group as $value)
                                                                <option value="{{ $value->itemtype_code }}">
                                                                    {{ $value->item_type_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="category_asset"
                                                    class="col-sm-4 col-form-label">Department</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm select2"
                                                        id="department_asset" name="department_asset">
                                                        <option value="">Select Department</option>
                                                        @if (!empty($department))
                                                            @foreach ($department as $value)
                                                                <option value="{{ $value->serviceunit_no_pk }}">
                                                                    {{ $value->serviceunit_name }}</option>
                                                            @endforeach
                                                        @endif
                                                    </select>
                                                </div>
                                            </div>
                                        </div>



                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                            <div class="form-group form-row">
                                                <label for="received_date_from" class="col-sm-4 col-form-label">Rece.
                                                    From</label>
                                                <div class="col-sm-8">


                                                    <input type="text" class="form-control date_picker"
                                                        placeholder="dd-mm-yyyy" id="received_date_from"
                                                        name="received_date_from" value="" />



                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-lg-4 col-md-12 col-sm-12">
                                            <div class="form-group form-row">
                                                <label for="received_date_to" class="col-sm-4 col-form-label">Rece.
                                                    To</label>
                                                <div class="col-sm-8">

                                                    <input type="text" class="form-control date_picker"
                                                        placeholder="dd-mm-yyyy" id="received_date_to"
                                                        name="received_date_to" value="" />

                                                </div>
                                            </div>
                                        </div>

                                        {{-- Item Name --}}
                                        <div class="col-lg-4 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="item_name" class="col-sm-4 col-form-label">Item Name</label>
                                                <div class="col-sm-8">
                                                    <input type="hidden" id="item_id_hidden" name="item_id">
                                                    <input type="text" class="form-control form-control-sm" id="item_name" name="item_name" value="" placeholder="Item Name">
                                                </div>
                                            </div>
                                        </div>
                                        
                                        <div class="col-lg-8 col-md-12 col-sm-12"></div>

                                        <div class="col-lg-3 col-md-12 col-sm-12">
                                            <div class="form-group form-row d-flex justify-content-start pl-2 mt-2">

                                                <div class="form-check pr-4">
                                                    <input class="form-check-input setup_status" type="radio"
                                                        value="all" id="all" name="setup_status" checked>
                                                    <label class="form-check-label" for="all">
                                                        All
                                                    </label>
                                                </div>
                                                <div class="form-check pr-4">
                                                    <input class="form-check-input setup_status" type="radio"
                                                        value="set" id="set" name="setup_status">
                                                    <label class="form-check-label" for="set">
                                                        Set
                                                    </label>
                                                </div>
                                                <div class="form-check pr-4 ">
                                                    <input class="form-check-input setup_status" type="radio"
                                                        value="notSet" id="notSet" name="setup_status">
                                                    <label class="form-check-label" for="notSet">
                                                        Not Set
                                                    </label>
                                                </div>

                                            </div>
                                        </div>
                                        <div class="text-right col-lg-1 mt-2">
                                            <button type="button" class="btn btn-md btn-success btn-md-global"
                                                id="assetsSearch" onclick="assetsSearchFunc()"><i
                                                    class="fa fa-search"></i> Search</button>
                                        </div>

                                    </div>
                                </div>
                            </div>
                        </form>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive" id="asset_register_list">
                                    @include('admin.uhl.fixed_assets.asset-register-list')
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
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    $("body").addClass("sidebar-collapse");
    $('.select2').select2();
    $('.date_picker').datepicker({
        todayHighlight: true,
        clearBtn: true,
        autoclose: true,
        format: 'dd-mm-yyyy'
    });

    $(document).ready(function(e) {
        openReceiveItemAutocomplete('#item_name', '', 'item_name', function(item, obj) {
            $('#item_id_hidden').val(item.item_id);
            $('#item_uom_hidden').val(item.uom_no_fk);
            $('#item_uom').val(item.uom_name);
            $('#pvms_no').val(item.pvms_no);
            obj.stopImmediatePropagation();
        });
    });

    function assetsSearchFunc() {
        var setup_status = document.querySelector('input[name="setup_status"]:checked').value;
        if ($('#department_asset').val() == '') {
            alert("Please Select Department !");
            return false;
        }
        $.ajax({
            url: "{{ route('v1.asset-register-search') }}",
            type: "POST",
            data: {
                asset_id: $('#asset_id').val(),
                asset_type: $('#asset_type').val(),
                department_asset: $('#department_asset').val(),
                major_group: $('#major_group').val(),
                minor_group: $('#minor_group').val(),
                current_store: $('#current_store').val(),
                received_date_from: $('#received_date_from').val(),
                received_date_to: $('#received_date_to').val(),
                setup_status: setup_status,
                asset_location: $('#asset_location').val(),
                item_id_hidden: $('#item_id_hidden').val(),
                item_name: $('#item_name').val(),
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                console.log(data);
                $("#asset_register_list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }
</script>
