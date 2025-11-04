<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">

<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-12">
            <h5 class="mt-2 mb-0">Stock Issue Worklist</h5>
            <small>Store / Stock Issue Worklist</small>
        </div>
    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-header d-flex justify-content-between align-items-center">
                    <h5>Stock Issue Worklist</h5>

                </div>
                <div class="card-body">
                    <div class="row">
                        <div class="col-md-12">
                            <form id="search_stock_issue" action="{{ route('export_stock_issue') }}" target="_blank" method="post">
                                @csrf
                                <div class="form-row justify-content-center	py-2">
                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="select_store">Issue
                                                From</label>
                                            <select class="form-control form-control-sm" id="store_id" name="store_id">
                                                <option value="">Select Store</option>
                                                @if (!empty($stores))
                                                    @foreach ($stores as $store)
                                                        @if ($store->med_store_ind == 1)
                                                            <option value="{{ $store->su_no_fk }}">
                                                                {{ $store->su_name }}
                                                            </option>
                                                        @endif
                                                    @endforeach
                                                @endif
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="pack_type">Issue to
                                            </label>
                                            <select class="form-control form-control-sm" id="issue_to" name="issue_to">
                                                <option value="">Select</option>
                                                <option value="STORE">Store</option>
                                                <option value="EVENT">Event</option>
                                                <option value="PATIENT">Patient</option>
                                            </select>
                                        </div>
                                    </div>

                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="fm_date">Date
                                                From</label>
                                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                                id="fm_date" name="fm_date" value="" autocomplete="off"
                                                placeholder="yyyy-mm-dd">
                                        </div>
                                    </div>



                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="to_date">Date
                                                To</label>
                                            <input type="hidden" id="item_id_hidden" name="item_id">
                                            <input type="text" class="form-control form-control-sm m-0 date_picker"
                                                id="to_date" name="to_date" value="" autocomplete="off"
                                                placeholder="yyyy-mm-dd">
                                        </div>
                                    </div>
                                     <input type="hidden" id="type" name="type" value="">
                                    <div class="col-md-4 text-center">
                                        <div class="btn-group btn-block" role="group">
                                            <button onclick="search_stock_issue_list()" type="button"
                                                class="btn btn-success btn-md mt-4"><i class="fa fa-search"></i>
                                            </button>

                                            <button type="reset" class="btn btn-info btn-md mt-4" title="Reset"><i
                                                    class="fa fa-redo"></i> </button>
                                            <button onclick="assignType(1)"
                                                type="submit" class="btn btn-info btn-md mt-4" title="Export In PDF"><i
                                                    class="fa fa-file-pdf"></i> </button>
                                            {{-- <button onclick="assignType(2)"
                                                type="submit" class="btn btn-info btn-md mt-4"
                                                title="Export In Excel"><i class="fa fa-file-excel"></i></button> --}}

                                            {{-- <a href="{{route('store_stock_ledger')}}"  class="btn btn-info btn-md mt-4"><i class="fa fa-redo"></i> Reset</a> --}}
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>


                        <div class="col-md-12" id="issue_list">
                            @include("admin.store.stock_consumption.item_issue_worklist_table")
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

<script type="application/javascript" src="{{ asset('datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/dataTables.buttons.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>

<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
    function assignType(value){
        $("#type").val(value);
    }
    $(document).ready(function() {


        var table = $('.data-table').DataTable();

        $('.date_picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });

        openReceiveItemAutocomplete('#pvms_no', 'pvms_no', function(item, obj) {
            $('#item_id_hidden').val(item.item_id);
            $('#item_name').val(item.item_name);
            obj.stopImmediatePropagation();

        });
        openReceiveItemAutocomplete('#item_name', 'item_name', function(item, obj) {
            $('#item_id_hidden').val(item.item_id);
            $('#pvms_no').val(item.pvms_no);
            obj.stopImmediatePropagation();
        });

        $(document).on('click', '.stock_detail', function(e) {
            e.preventDefault()
            $.ajax({
                async: true,
                data: {
                    store_id: $(this).attr('data-store_id'),
                    item_id: $(this).attr('data-item_id'),
                    item_name: $(this).attr('data-item_name'),
                    store_name: $(this).attr('data-store_name'),
                    opening_qty: $(this).attr('data-opening_qty'),
                },
                dataType: "html",
                url: "{{ route('phr_stock_details') }}",
                type: 'post',
                beforeSend: function() {
                    if (isAModalOpen)
                        $('.modal').modal('hide');
                    blockUI();
                },
                success: function(data) {

                    $('.modal-body').html(data)
                    $('#stock_detail_modal').modal('show')
                    $('.data_table').DataTable({
                        "ordering": false,
                        "bPaginate": false,
                        "bLengthChange": false,
                        "bAutoWidth": false
                    });

                },
                complete: function() {
                    $.unblockUI();
                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" +
                            errors[messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            });
            e.stopImmediatePropagation();
        })
    })

    function search_stock_issue_list() {
        $.ajax({
            data: $("#search_stock_issue").serialize(),
            url: "{{ route('search_stock_issue_worklist') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $("#issue_list").html(data);
                var table = $('.data-table').DataTable();
            },
            complete: function() {
                $.unblockUI();
            }
        });


    }
</script>
