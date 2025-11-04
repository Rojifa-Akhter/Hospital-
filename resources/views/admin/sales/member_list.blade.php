<link rel="stylesheet" href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.css') }}">
<link rel="stylesheet" href="{{ asset('datepicker/dist/css/bootstrap-datepicker.min.css') }}">
<link rel="stylesheet" href="{{ asset('node_modules/select2/dist/css/select2.min.css') }}">

<div class="container-fluid">
    <div class="row bg-white border-bottom sticky-top shadow-sm">
        <div class="col-md-12 mb-1">
            <h5 class="mt-2 mb-0">Generated Sales Team List</h5>
            <small>Settings / Sales Team /Generated Sales Team List</small>
        </div>
    </div>
    <input type="hidden" id="tab_name" value="7">
    <div class="row mt-3">
        <div class="col-12">
            <ul class="nav nav-tabs" id="myTab" role="tablist">
                <li class="nav-item" role="presentation">
                    <a class="nav-link active page-tab" id="received-by-challan-tab"
                        href="{{ route('sales-team-members') }}" rel="tab">Generated Sales Team List</a>
                </li>

                <li class="nav-item" role="presentation">
                    <a class="nav-link page-tab" id="received-by-item-tab" href="{{ route('members-by-team') }}"
                        rel="tab">Team Members</a>
                </li>
                {{-- <li class="ml-auto bg-none">
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="pending" name="deli_status"
                            value="Pending">
                        <label class="custom-control-label" for="pending">Pending</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="partial_received" name="deli_status"
                            value="Partial Received">
                        <label class="custom-control-label" for="partial_received">Partial Received</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="received" name="deli_status"
                            value="Received">
                        <label class="custom-control-label" for="received">Received</label>
                    </div>
                    <div class="custom-control custom-checkbox custom-control-inline">
                        <input type="checkbox" class="custom-control-input" id="closed" name="deli_status"
                            value="Closed">
                        <label class="custom-control-label" for="closed">Closed</label>
                    </div>
                </li> --}}

            </ul>

            <div class="tab-content" id="myTabContent">
                <div class="tab-pane fade show active" id="received-by-challan">
                    <div class="row">
                        <div class="col-12 px-0">
                            {{-- <div class="card">
                                <div class="card-header">
                                    <h5><i class="fa fa-search"></i> Search Panel</h5>
                                </div>
                                <div class="card-body border-bottom-3 p-2">
                                    <form action="{{ route('inventory.serach_receive') }}" method="POST"
                                        id="chalan-receive-search">
                                        <input type="hidden" name="type" value="chalan">
                                        <div class="form-row">
                                            <div class="form-group col-md-1">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="received-by-challan-challan-no">Challan No</label>
                                                <input type="text" class="form-control form-control-sm m-0"
                                                    id="received-by-challan-challan-no" name="search_chalan_no" value=""
                                                    placeholder="Challan No">
                                            </div>

                                            <div class="form-group col-md-4">
                                                <label class="col-form-label col-form-label-sm"
                                                    for="received-by-challan-date-form">Challan Date</label>
                                                <div class="input-group">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">Form</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="received-by-challan-date-from"
                                                        name="search_chalan_date_from" value=""
                                                        placeholder="dd-mm-yyyy">
                                                    <div class="input-group-prepend">
                                                        <div class="input-group-text">To</div>
                                                    </div>
                                                    <input type="text"
                                                        class="form-control form-control-sm m-0 date_picker"
                                                        id="received-by-challan-date-to" name="search_chalan_date_to"
                                                        value="" placeholder="dd-mm-yyyy">
                                                </div>
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="po_data">Purchase
                                                    Order</label>
                                                <input type="text" class="form-control form-control-sm m-0" id="po_data"
                                                    name="po_data" value="" placeholder="Search">
                                            </div>

                                            <div class="form-group col-md-2">
                                                <label class="col-form-label col-form-label-sm" for="po_date">Purchase
                                                    Date</label>
                                                <input type="text" class="form-control form-control-sm m-0 date_picker"
                                                    id="po_date" name="search_po_date" value=""
                                                    placeholder="dd-mm-yyyy">
                                            </div>


                                            <div class="col-md-2">
                                                <div class="btn-group btn-block" role="group">
                                                    <div class="btn-group btn-block" role="group">
                                                        <button type="button"
                                                            onclick="generateSearch( this, 'chalan-receive-search', '{{ route('pharmacy.serach_receive') }}', 'crl' )"
                                                            class="btn btn-success btn-block btn-sm mt-4"><i
                                                                class="fa fa-search"></i> Search</button>
                                                        <!-- <a href="{{ route('inventory.item_receive') }}"
                                                            class="btn btn-info btn-block btn-md mt-4"><i
                                                                class="fa fa-redo"></i> Reset</a> -->

                                                        <button id="btnreset" type="button"
                                                            class="btn btn-info btn-sm mt-4"
                                                            onclick="btnresetData(this)"><i class="fa fa-redo"></i>
                                                            Reset </button>
                                                    </div>
                                                </div>
                                            </div>
                                    </form>
                                </div>
                            </div> --}}

                            <div class="card" id="crl">
                                <div class="card-body mt-3">
                                    <div class="row">
                                        <div class="col-12 table-responsive">
                                            <table class="table data-table table-striped table-bordered table-hover">
                                                <thead class="bg-primary">
                                                    <tr>
                                                        <th class="text-center" scope="col">Sl#</th>
                                                        <th class="text-left" scope="col">Team Name</th>
                                                        <th class="text-left" scope="col">No Of Members</th>
                                                        <th class="text-center width-150" scope="col">Action</th>
                                                    </tr>
                                                </thead>

                                                <tbody>
                                                    @if(!empty($unique_team))
                                                    @foreach( $unique_team as $key => $data)
                                                    @php
                                                     $team_no_pk = $data["team_no_pk"];
                                                    @endphp
                                                    @if($team_no_pk)
                                                    <tr>
                                                        <td>{{ $loop->iteration }}</td>
                                                        <td><span style="cursor: pointer" class="open-modal" data-id="{{$data["team_no_pk"]}}" data-action="{{route('team-build.show', $data["team_no_pk"])}}" data-modal="common-modal-sm" data-title="Member Details" title="Member Details">{{ucfirst(strtolower($key))}}</span></td>

                                                        <td>{{ isset($data["no_of_members"])? $data["no_of_members"] : ''}}</td>

                                                        <td><span class="btn btn-md btn-primary open-modal" data-id="{{$data["team_no_pk"]}}" data-action="{{route('team-build.edit', $data["team_no_pk"])}}" data-modal="common-modal-md" data-title="Add Team Member" title="Add Team Member"><i class="fas fa-plus"></i></span>
                                                            </td>

                                                    </tr>
                                                    @endif
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
                </div>
            </div>
        </div>
    </div>

</div>

{{-- <div class="modal" tabindex="-1" role="dialog" id="challan_detail_modal">
    <div class="modal-dialog modal-lg" role="document">
        <div class="modal-content">
            <div class="modal-header">
                <h5 class="modal-title">Receive Items By Challan</h5>
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
<script type="application/javascript" src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    function btnresetData(Element) {


        $("#received-by-challan-challan-no").val("");
        $("#received-by-challan-date-from").val("");
        $("#received-by-challan-date-to").val("");
        $("#po_data").val("");
        $("#po_date").val("");
        $("#supplier_id").val("").select2({
            data: [id = "", text = "Select Supplier"]
        });
    }
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
            "bPaginate": false,
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
            format: 'dd-mm-yyyy',
            autoclose: true,
            todayHighlight: true,
            clearBtn: true,
        });
        $('.select2').select2({});
        $(document).on('click', '.challan_details', function(e) {
            e.preventDefault()
            $.ajax({
                async: true,
                data: {
                    receive_pk_no: $(this).attr('data-id')
                },
                dataType: "html",
                url: "{{ route('inventory.item-received-show-popup') }}",
                type: 'post',
                beforeSend: function() {
                    if (isAModalOpen)
                        $('.modal').modal('hide');
                    blockUI();
                },
                success: function(data) {

                    $('.modal-body').html(data)
                    $('#challan_detail_modal').modal('show')
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
</script>
