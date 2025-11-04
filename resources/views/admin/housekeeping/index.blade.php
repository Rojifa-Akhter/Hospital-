<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('css/typeaheadjs.css') }}">
<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top-breadcrumb shadow-sm align-items-center">
        <div class="col-md-4">
            <h5 class="mt-2 mb-0">Housekeeping</h5>
            <small>Housekeeping</small>
        </div>


    </div>

    <div class="row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">
                    {{-- <form id="searchForm" action="{{ route('housekeeping-report-pdf') }}"
                        method="post" target="_blank">
                        @csrf
                        <div class="row">

                            <input type="hidden" name="print_type" id="print_type" value="">
                            <input type="hidden" name="module_code" id="module_code" value="INVENTORY">

                            <div class="col-md-12">
                                <div class="form-row justify-content-center py-2">


                                    <div class="col-md-2">
                                        <div class="form-group">
                                            <label class="col-form-label col-form-label-sm" for="item_name">Employee
                                                Name</label>
                                            <input type="text" class="form-control form-control-sm m-0"
                                                id="primary_doctor" name="primary_doctor" maxlength="50" value=""
                                                placeholder="Employee Name" />
                                            <input type="hidden" id="doctor_id" name="doctor_id" value="" />
                                            <div><strong>
                                                    <p id="autocomplete_data"></p>
                                                </strong></div>
                                        </div>
                                    </div>

                                    <div class="col-md-2 text-center">
                                        <div class="btn-group btn-block" role="group">
                                            <button id="btnSearchHousekeeping" type="button"
                                                class="btn btn-success btn-md btn-md-global mt-4"><i
                                                    class="fa fa-search"></i> Search</button>
                                            <button id="resetbtn" type="reset"
                                                class="btn btn-info btn-md btn-md-global mt-4"><i
                                                    class="fa fa-redo"></i>
                                                Reset</button>
                                        </div>
                                    </div>
                                    <div class="col-md-3 mt-4">

                                        <button type="submit"
                                            class="btn btn-md btn-md-globa btn-outline-primary bg-none"
                                            target="_blank" value="1" id="PDF" onclick="print(this)"><i
                                                class="fa fa-file-pdf"></i>&nbsp;PDF </button>
                                        <button type="submit"
                                            class="btn btn-md btn-md-globa btn-outline-primary bg-none"
                                            target="_blank" value="2" id="EXCEL" onclick="print(this)"><i
                                                class="fa fa-file-excel"></i>&nbsp;EXCEL</button>

                                    </div>

                                </div>
                            </div>


                        </div>
                    </form> --}}


                    <div class="col-md-12" id="stock_list">
                        @include('admin.housekeeping.housekeeping_data')
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>

{{-- <div class="modal" tabindex="-1" role="dialog" id="stock_detail_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Transaction Details</h5>
                <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                    <span aria-hidden="true">&times;</span>
                </button>
            </div>
            <div class="modal-body">

            </div>
            <div class="modal-footer">

                <button type="button" class="btn btn-secondary" data-dismiss="modal">Close</button>
            </div>
        </div>
    </div>
</div> --}}

<script type="application/javascript" src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}">
</script>
<script type="application/javascript" src="{{ asset('datepicker/dist/js/bootstrap-datepicker.min.js') }}"></script>
<script src="{{ asset('js/typeahead.bundle.js') }}"></script>
<script>
      $('.data-table').DataTable({
        "ordering": false,
        "bPaginate": false,
        "bLengthChange": false,
        "bAutoWidth": false
    });
    openDoctorAutocomplete('#primary_doctor', 'doctor_id');

    $(document).on("click", "#btnSearchHousekeeping", function(e) {
        var formID = $("#searchForm").attr("id");
        var formMethod = $("#searchForm").attr("method");
        $("#searchForm").attr('action', "{{ url('housekeeping-report-search') }}");
        $.ajax({
            data: $('#' + formID).serialize(),
            url: "{{ url('housekeeping-report-search') }}",
            type: formMethod,
            beforeSend: function() {
                blockUI();

            },
            success: function(data) {
                $("#cashier_report_data").html(data);
                $("#searchForm").attr('action', "{{ route('housekeeping-report-pdf') }}");
            },
            complete: function() {
                $.unblockUI();
            }
        });
    });

    function print(element) {
        var url = "{{ route('housekeeping-report-pdf') }}";
        var print_id = $(element).attr('id');
        // var action= $(element).parent('form').attr('action');
        if (print_id == "PDF") {
            url = url.replace(":id", 'PDF');
            $(element).parent().parent().parent().parent('form').attr('action', url);
        } else {
            url = url.replace(":id", 'EXCEL');
            $(element).parent().parent().parent().parent('form').attr('action', url);
        }
    }

</script>
