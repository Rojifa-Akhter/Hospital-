<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">Item Return</h5>
            <small>Store / Item Return Worklist</small>
        </div>
        <div class="col-md-3">
            <div id="top-action">
            </div>
        </div>
    </div>
    <input type="hidden" id="tab_name" value="8">
    <div class="row mt-3">
        <div class="col-12">
            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="received-by-item">
                    <div class="row">
                        <div class="col-12 px-0">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fa fa-search"></i> Search Panel</h5>
                                </div>
                                <div class="card-body border-bottom-3 p-2">
                                    <form action="#" method="POST" id="item-receive-search">
                                        <input type="hidden" name="receive_type" value="item">
                                        <div class="form-row">
                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="received-by-item-challan-no">Challan No</label>
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="received-by-item-challan-no" name="search_chalan_no" value=""
                                                    placeholder="Challan No">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="received-by-item-date-from">Challan Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Form</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="received-by-item-date-from" name="search_chalan_date_from"
                                                        value="" placeholder="yyyy-mm-dd">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="received-by-item-date-to" name="search_chalan_date_to"
                                                        value="" placeholder="yyyy-mm-dd">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="received-by-item-year">PO</label>
                                                <select class="form-control " id="received-by-item-year"
                                                    name="search_year">
                                                    <option value="">Select</option>
                                                    @if (!empty($search_fiscal_year))
                                                        @foreach ($search_fiscal_year as $key => $sfy)
                                                            <option value="{{ $key }}">{{ $sfy['data'] }}
                                                            </option>
                                                        @endforeach
                                                    @endif
                                                </select>
                                            </div>


                                            <div class="col-md-3">
                                                <div class="btn-group btn-block" role="group">
                                                    <button type="button"
                                                        onclick="generateSearch( this, 'item-receive-search', ' {{ route('inventory.serach_return_item') }}', 'irl' )"
                                                        class="btn btn-success btn-block btn-md mt-4"><i
                                                            class="fa fa-search"></i> Search</button>
                                                    <a href=" route('inventory.item_return') }}"
                                                        class="btn btn-info btn-block btn-md mt-4"><i
                                                            class="fa fa-redo"></i> Reset</a>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card" id="irl">
                                @include("admin.store.item_return_list_table")
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>

</div>

<script type="application/javascript"
src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {
        $.fn.dataTable.ext.search.push(
            function(settings, searchData, index, rowData, counter) {

                var offices = $('input:checkbox[name="deli_status"]:checked').map(function() {
                    return this.value;
                }).get();


                if (offices.length === 0) {
                    return true;
                }
                var tblindex = $('#tab_name').val()

                if (offices.indexOf(searchData[tblindex]) !== -1) {
                    return true;
                }

                return false;
            }
        );

        var table = $('.data-table').DataTable({
            "ordering": false,
            "bPaginate": true,
            "bLengthChange": false,
            "bAutoWidth": false
        });


        $('input:checkbox').on('change', function() {
            table.draw();

        });
        $(document).on('click', '.page-tab', function(e) {
            e.preventDefault()

            if ($(this).attr('id') == 'received-by-challan-tab') {
                $('#tab_name').val(7)
            }
            if ($(this).attr('id') == 'received-by-item-tab') {
                $('#tab_name').val(8)
            }
            table.draw();
        })
        $('.date_picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
        $('.select2').select2({});
    })
</script>
