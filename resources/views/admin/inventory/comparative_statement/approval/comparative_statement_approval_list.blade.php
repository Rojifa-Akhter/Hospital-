<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datatables/media/css/buttons.dataTables.min.css') }}">
  <link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<style type="text/css">
    .table td,
    .table th {
        vertical-align: top;
    }
</style>
<div class="container-fluid">
    @php
        //dd($indents);
    @endphp
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm">
        <div class="col-md-9">
            <h5 class="mt-2 mb-0">Comparative Statement Worklist</h5>
            {{-- <small>Pharmacy / Comparative Statement Worklist</small> --}}
        </div>

    </div>
    <input type="hidden" id="tab_name" value="7">
    <div class="row mt-3">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active page-tab" id="indent-work-list-tab " data-toggle="tab"
                        href="#indent-work-list" role="tab" aria-controls="indent-work-list" aria-selected="false">
                        Comparative Statement Worklist</a>
                </li>


                <li class="ml-auto bg-none">

                </li>
            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="indent-work-list" role="tabpanel"
                    aria-labelledby="indent-work-list-tab">

                    <div class="row">
                        <div class="col-12 px-0">
                            <div class="card">
                                <div class="card-header">
                                    <h5><i class="fa fa-search"></i> Search Panel</h5>
                                </div>
                                <div class="card-body border-bottom-3 p-2">
                                    <form method="POST" target="_blank"
                                        action="{{ route('comparative-statement-approval-print') }}"
                                        id="statement-search">
                                        @csrf
                                        <div class="form-row">
                                            <div class="form-group col-md-4">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="indent_no">Requistion
                                                    No</label>
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="indent_no" name="indent_no" value=""
                                                    placeholder="Requistion No">
                                            </div>

                                            {{-- <div class="form-group col-md-4">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="indent_date_from">Requsition Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">From</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="indent_date_from" name="indent_date_from" value=""
                                                        placeholder="yyyy-mm-dd">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="indent_date_to" name="indent_date_to" value=""
                                                        placeholder="yyyy-mm-dd">
                                                </div>
                                            </div> --}}

                                            <div class="col-md-4">
                                                <div class="btn-group btn-block" role="group">
                                                    <button type="button" class="btn btn-success btn-block btn-md btn-md-global mt-4"
                                                        onclick="generateSearch( this, 'statement-search', '{{ route('comparative-statement-approval-search') }}', 'comparative-statement-approval-search' )">
                                                        <i class="fa fa-search"></i> Search
                                                    </button>
                                                    {{-- <a rel="tab" href="{{ route('pharmacy_indent_worklist') }}"
                                                        class="btn btn-info btn-block btn-md mt-4"><i
                                                            class="fa fa-redo"></i> Reset</a> --}}

                                                    <button type="submit" class="btn btn-success btn-block btn-md btn-md-global mt-4">
                                                        <i class="fa fa-search"></i> Print
                                                    </button>
                                                </div>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                            </div>

                            <div class="card" id="comparative-statement-approval-search">
                                @include ('admin.inventory.comparative_statement.approval.comparative_statement_list_table')
                            </div>
                        </div>
                    </div>
                </div>

                <div class="tab-pane fade " id="item-wise-indent" role="tabpanel"
                    aria-labelledby="item-wise-indent-tab">
                    {{-- <div class="row">
                        <div class="col-12 px-0">
                            <div class="custom-card-header">
                                <ul class="list-inline text-right">
                                    <li class="list-inline-item"><i class="fa fa-exclamation-triangle"></i> &nbsp;&nbsp;
                                        <b>Pending</b> &nbsp;&nbsp;&nbsp; <span
                                            class="badge badge-warning">{{ count($indent_item_pending) }}</span></li>
                                    <li class="list-inline-item"><i class="fa fa-clipboard-check"></i> &nbsp;&nbsp;
                                        <b>Received</b> &nbsp;&nbsp;&nbsp; <span
                                            class="badge badge-success">{{ count($indent_item_received) }}</span></li>
                                    <li class="list-inline-item"><i class="fa fa-times-circle"></i> &nbsp;&nbsp;
                                        <b>Closed</b> &nbsp;&nbsp;&nbsp; <span
                                            class="badge badge-danger">{{ count($indent_item_closed) }}</span></li>
                                    <li class="list-inline-item"><a rel="tab" href="{{ route('new_indent') }}"
                                            class="btn btn-success btn-md ml-auto mb-1 mt-1"> <i class="fas fa-plus">
                                            </i>&nbsp;&nbsp;New Indent</a> </li>
                                </ul>
                            </div>
                        </div>
                    </div> --}}


                </div>
            </div>
        </div>
    </div>
</div>


<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/jquery.dataTables.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/dataTables.buttons.min.js') }}"></script>
<script type="application/javascript" src="{{ asset('datatables/media/js/buttons.colVis.min.js') }}"></script>
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

        var table = $('.datatable').DataTable({
            "ordering": false,
            "bPaginate": false,
            "bLengthChange": false,
            "bAutoWidth": false
        });


        $('input:checkbox').on('change', function() {
            table.draw();

        });
        $(document).on('click', '.page-tab', function(e) {
            e.preventDefault()

            if ($(this).attr('id') == 'indent-work-list-tab') {
                $('#tab_name').val(7)
            }
            if ($(this).attr('id') == 'item-wise-indent-tab') {
                $('#tab_name').val(12)
            }
            table.draw();
        })

        $('.date_picker').datepicker({
            format: 'yyyy-mm-dd',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });

    })
</script>
