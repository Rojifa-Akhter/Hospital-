<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}" rel="stylesheet">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<main id="page-content">
    <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
    <form action="#">
        <section class="fixed_assets">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-10">
                                <h5 class="mt-2 mb-0">Asset Received</h5>
                                <small>Fixed Assets / Asset Received</small>
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
                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="asset_id" class="col-sm-4 col-form-label">Asset Id</label>
                                                <div class="col-sm-8">
                                                    <input type="text" class="form-control form-control-sm"
                                                        id="asset_id" name="asset_id" placeholder="" />
                                                </div>
                                            </div>
                                        </div>


                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="department_asset"
                                                    class="col-sm-4 col-form-label">Department</label>
                                                <div class="col-sm-8">
                                                    <select class="form-control form-control-sm select2"
                                                        id="department_asset" name="department_asset">
                                                        <option value="">select Category</option>
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

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="major_group" class="col-sm-4 col-form-label">Major
                                                    Group</label>
                                                <div class="col-sm-8">

                                                    <select class="form-control form-control-sm select2"
                                                        id="major_group" name="major_group">
                                                        <option value="">select</option>
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

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group form-row">
                                                <label for="minor_group" class="col-sm-4 col-form-label">Minor
                                                    Group</label>
                                                <div class="col-sm-8">

                                                    <select class="form-control form-control-sm select2"
                                                        id="minor_group" name="minor_group">
                                                        <option value="">select</option>
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



                                        <div class="col-lg-3 col-md-12 col-sm-12">
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

                                        <div class="col-lg-3 col-md-12 col-sm-12">
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


                                        <button type="button" class="btn btn-md btn-success btn-md-global"
                                            id="assetsSearch" onclick="assetsSearchFunc()"><i class="fa fa-search"></i>
                                            Search</button>


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
                                <div class="table-responsive">
                                    <table class="table table-bordered table-hover table-striped">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th>SL#</th>
                                                <th class="text-left">Item Id</th>
                                                <th class="text-left">Rece. Date</th>
                                                <th class="text-left">Rece./By dept.</th>
                                                <th class="text-left">Description</th>
                                                {{-- <th class="text-left">Category</th>
                                                <th class="text-left">Tax Code</th>
                                                <th class="text-left">Class</th> --}}
                                                <th class="text-left">Major Group</th>
                                                <th class="text-left">Minor Group</th>
                                                <th class="text-center">GRN Qty</th>
                                                <th class="text-center">Tag Qty</th>
                                                <th class="text-center">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="asset-receive-list">
                                            @include('admin.uhl.fixed_assets.asset-received-list')
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
    <!-- Modal -->
    <!-- <div class="modal fade" id="exampleModal" tabindex="-1" role="dialog" aria-labelledby="exampleModalLabel" aria-hidden="true">
      <div class="modal-dialog" role="document">
        <div class="modal-content">
          <div class="modal-header">
            <h5 class="modal-title" id="exampleModalLabel">Create Tag</h5>
            <button type="button" class="close" data-dismiss="modal" aria-label="Close">
              <span aria-hidden="true">&times;</span>
            </button>
          </div>
          <div class="modal-body">
            <form action="#">
                <div class="form-row">
                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group form-row">
                            <label for="asset_id" class="col-sm-4 col-form-label">Asset Id</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="asset_id" name="asset_id" placeholder="" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group form-row">
                            <label for="asset_descrip" class="col-sm-4 col-form-label">Asset Description</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="asset_descrip" name="asset_descrip" placeholder="" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group form-row">
                            <label for="current_qty" class="col-sm-4 col-form-label">Current Qty</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="current_qty" name="current_qty" placeholder="" />
                            </div>
                        </div>
                    </div>

                    <div class="col-lg-12 col-md-12 col-12">
                        <div class="form-group form-row">
                            <label for="existing_qty" class="col-sm-4 col-form-label">Existing Qty</label>
                            <div class="col-sm-8">
                                <input type="text" class="form-control form-control-sm" id="existing_qty" name="existing_qty" placeholder="" />
                            </div>
                        </div>
                    </div>

                    <div class="col-12 text-center my-2">
                        <button type="button" class="btn btn-md btn-success uhl_common_btn">Generate Tag</button>
                    </div>


                </div>
            </form>
            <div class="form-row">
                <div class="col-md-6">
                 <div class="table-responsive">
                     <table class="table table-bordered table-hover table-striped">
                        <h5 class="table__heading">Existing</h5>
                         <thead class="global-uhl-table-bg">
                             <tr>
                                 <th>Sl No</th>
                                 <th>Tag Number</th>
                                 <th></th>
                                 
                             </tr>
                         </thead>
                         <tbody>
                             <tr>
                                <td>1</td>
                                <td>0523641</td>
                                <td><i class="fas fa-print"></i></td>
                               
                             </tr>
                         </tbody>
                     </table>
                 </div>
                </div>
                <div class="col-md-6">
                  <div class="table-responsive">
                      <table class="table table-bordered table-hover table-striped">
                         <h5 class="table__heading">Current</h5>
                          <thead class="global-uhl-table-bg">
                              <tr>
                                  <th>Sl No</th>
                                  <th>Tag Number</th>
                                  <th></th>
                                  
                              </tr>
                          </thead>
                          <tbody>
                              <tr>
                                 <td>2</td>
                                 <td>56243</td>
                                 <td><i class="fas fa-print"></i></td>
                                
                              </tr>
                          </tbody>
                      </table>
                  </div>
                </div>
            </div>
          </div>
          <div class="modal-footer">
            <button type="button" class="btn btn-primary uhl_save_btn">Save</button>
            <button type="button" class="btn btn-danger" data-dismiss="modal">Close</button>
          </div>
        </div>
      </div>
    </div> -->
</main>
<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
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

    function assetsSearchFunc() {
        $.ajax({
            url: "{{ route('v1.asset-received-search') }}",
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
            },
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#asset-receive-list").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    }

    $(document).on("click", "#generate_tag", function(e) {
        if ($('#current_qty').val() < 0 || $('#current_qty').val() == "") {
            alert('Enter Qty');
            return;
        }
        if (confirm('Are you sure ?')) {
            $.ajax({
                url: "{{ route('v1.generate-tag') }}",
                type: "POST",
                data: {
                    current_qty: $('#current_qty').val(),

                },
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {

                    if (data.length > 0) {
                        var sl = 1;
                        var current_tag = '';
                        data.forEach(element => {
                            console.log(element)
                            current_tag +=
                                `<tr><td>${sl++}</td><td><input type="hidden" name="current_tag_no[]" value="${element}">${element}</td></tr>`;
                        });
                        $('#current_tag').html(current_tag);
                    }
                },
                complete: function() {
                    $.unblockUI();
                }
            });
        }

    });
</script>
