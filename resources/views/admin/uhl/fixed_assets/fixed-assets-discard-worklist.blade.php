<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">
<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<main id="page-content">
    <form action="#" id="" method="post">
        <section class="hr_payroll">
            <div class="container-fluid">
                <div class="row bg-white border-bottom sticky-top shadow-sm">
                    <div class="col-md-12">
                        <h5 class="mt-2 mb-0">Fixed Assets Discard Work List</h5>
                        <small>Fixed Assets / Fixed Assets Discard Work List</small>
                    </div>
                </div>

                <form action="" id="searchDiscardAsset" method="post">
                    @csrf
                    <div class="row">
                        <div class="col-md-12">
                            <div class="card">
                                <div class="card-header bg-success">
                                    <h5><i class="fas fa-search"></i> Search</h5>
                                </div>
                                <div class="card-body">
                                    <div class="form-row">
                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="discard_uid" class="col-form-label">Discard UID</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="discard_uid" name="discard_uid" placeholder="" value="" />
                                            </div>
                                        </div>

                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="asset_tag" class="col-form-label">Asset Tag</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="asset_tag" name="asset_tag" placeholder="" value="" />
                                            </div>
                                        </div>
                                        <div class="col-lg-2 col-md-6 col-12">
                                            <div class="form-group">
                                                <label for="item_name" class="col-form-label">Item Name</label>
                                                <input type="text" class="form-control form-control-sm"
                                                    id="item_name" name="item_name" placeholder="" value="" />
                                            </div>
                                        </div>

                                        <div class="col-lg-3 col-md-6 col-12">
                                            <div class="form-group">
                                                <label class="col-form-label col-form-label-sm" for="date_from">Discard
                                                    Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">From</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm date_picker" id="date_from"
                                                        name="date_from" value="" placeholder="" />
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm date_picker" id="date_to"
                                                        name="date_to" placeholder="" />
                                                </div>
                                            </div>
                                        </div>

                                        <div class="col-md-3 form-group">
                                            <button type="button" id="searchDiscardAssetButton"
                                                class="btn btn-md btn-success mt-4 btn-md-global"><i
                                                class="fa fa-search"></i>Search</button>
                                            <button type="reset" id="resetbtn"
                                                class="btn btn-info btn-md mt-4 btn-md-global"><i
                                                    class="fa fa-redo"></i>
                                                Reset</button>
                                        </div>



                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>

                </form>


                <div class="row">
                    <div class="col-md-12">
                        <div class="card">
                            <div class="card-body">
                                <div class="table-responsive">
                                    <table class="table table-striped table-bordered table-hover">
                                        <thead class="global-uhl-table-bg">
                                            <tr>
                                                <th>SL#</th>
                                                <th class="text-left">Discard No.</th>
                                                <th class="text-left">Discard UID</th>
                                                <th class="text-left">Item Name</th>
                                                <th class="text-left">Discard Date</th>
                                                {{-- <th class="text-left">Date of Discard</th> --}}
                                                <th class="text-left">Assets Register UID</th>
                                                <th class="text-left">Asset Tag UID</th>
                                                <th class="text-left">Asset Item No</th>
                                                <th class="text-left">Discard Cost Price</th>
                                                <th class="text-left">Discard Reasons</th>
                                                <th class="text-left">Sales To</th>
                                                <th class="text-left">Sales Price</th>
                                                <th class="text-left">Sales Qty</th>
                                                <th class="text-left">Total</th>
                                                <th class="text-left">Final Remarks</th>
                                                <th class="text-left">Discard Item Pic</th>
                                                <th class="text-left">Discard Approval Pic</th>
                                                <th class="text-center" style="width:120px;">Action</th>
                                            </tr>
                                        </thead>
                                        <tbody id="discardAssetList">
                                            {{-- @include('admin.uhl.fixed_assets.fixed-asset-discard-worklist-search-table') --}}
                                            @if (!empty($discard_data))
                                                @foreach ($discard_data as $data)
                                                    <tr>
                                                        <td class="text-left">{{ $loop->iteration }}</td>
                                                        <td class="text-left">{{ $data->discard_no_pk }}</td>
                                                        <td class="text-left">{{ $data->discard_uid }}</td>
                                                        <td class="text-left">{{ $data->item_name }}</td>
                                                        <td class="text-left">
                                                            {{ date('d/m/Y', strtotime($data->discard_date)) }}</td>
                                                        {{-- <td class="text-left"></td> --}}
                                                        <td class="text-left">{{ $data->ast_register_uid }}</td>
                                                        <td class="text-left">{{ $data->asset_tag_uid }}</td>
                                                        <td class="text-left">{{ $data->item_no_fk }}</td>
                                                        <td class="text-left"></td>
                                                        <td class="text-left">{{ $data->discard_reasons }}</td>
                                                        <td class="text-left">{{ $data->sales_to_text }}</td>
                                                        <td class="text-left">{{ $data->sales_price }}</td>
                                                        <td class="text-left">{{ $data->sales_qty }}</td>
                                                        <td class="text-left">
                                                            {{ $data->sales_price * $data->sales_qty }}</td>
                                                        <td class="text-left">{{ $data->discard_final_remarks }}
                                                        </td>

                                                        <td class="text-center">
                                                            @if (isset($data->discarded_item_pic))
                                                                <a href="{{ asset('images/uploads/discardImages/' . $data->discarded_item_pic) }}"
                                                                    target="_blank"><i class="fa fa-paperclip"
                                                                        aria-hidden="true"></i></a>
                                                            @endif
                                                        </td>
                                                        <td class="text-center">
                                                            @if (isset($data->discard_auth_letter_pic))
                                                                <a href="{{ asset('images/uploads/discardImages/' . $data->discard_auth_letter_pic) }}"
                                                                    target="_blank"><i class="fa fa-paperclip"
                                                                        aria-hidden="true"></i></a>
                                                            @endif
                                                        </td>
                                                        <td>
                                                            <a href="{{ isset($data->discard_no_pk) ? route('v1.fix-asset-discard-print', $data->discard_no_pk) : '' }}"
                                                                target="_blank" class="btn btn-sm btn-primary"><i
                                                                    class="fas fa-print"></i></a>
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
    </form>
</main>

<script src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>

<script>
    $(document).ready(function() {
        $('.select2').select2();

        $("body").addClass("sidebar-collapse");
        $(".date_picker").datepicker({
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true
        });
    });


    $(document).on("click", "#searchDiscardAssetButton", function(e) {
        $.ajax({
            data: {
                'asset_tag': $("#asset_tag").val(),
                'discard_uid': $("#discard_uid").val(),
                'item_name': $("#item_name").val(),
                'date_from': $("#date_from").val(),
                'date_to': $("#date_to").val(),

            },
            url: "{{ route('v1.discard-fixed-asset-search') }}",
            type: "post",
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                // console.log(data);
                $("#discardAssetList").html(data);
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });
</script>
