<link rel="stylesheet" href="{{ asset('uhl_assets/css/uhl_style.css') }}" />
<link href="{{ asset('node_modules/datatables/media/css/jquery.dataTables.min.css') }}" rel="stylesheet">
<main id="page-content">
    <form action="{{ route('carparking.policy-store') }}" method="post" id="car-parking-id">
        @csrf
        <section class="paitent__registration_details">
            <div class="container-fluid">
                <div class="row">
                    <div class="col-md-12">
                        <div class="row bg-white border-bottom sticky-top shadow-sm">
                            <div class="col-md-12">
                                <h5 class="mt-2 mb-0">Car Parking Policy</h5>
                                <small>Car Parking / Car Parking Policy</small>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>Car Parking Policy</h5>
                            </div>


                            <table class="table table-striped table-bordered table-hover">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th>Vehicle Type</th>
                                        <th>Minimum Rate</th>
                                        <th>Minimum Hr</th>
                                        <th>Hourly Rate</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="data-append-to">
                                    <tr id="0">
                                        <td>
                                            <select class="form-control form-control-sm" id="vehicle_type"
                                                name="vehicle_type">
                                                <option value="0">Select Type</option>
                                                @if (!empty($vehicle_data))
                                                    @foreach ($vehicle_data as $record)
                                                        <option value="{{ $record->lookupdata_name }}">
                                                            {{ $record->lookupdata_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm number_only"
                                                id="minimum_rate" name="minimum_rate" />
                                        </td>

                                        <td>
                                            <input type="text" class="form-control form-control-sm number_only"
                                                id="minimum_hr" name="minimum_hr" />
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm number_only"
                                                id="hourly_rate" name="hourly_rate" />
                                        </td>
                                        <td>
                                            @php
                                                $response_action = route('v1.car-parking-policy');
                                            @endphp
                                            <button class="btn btn-secondary uhl_save_btn"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                                Save</button>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>

                <div class="card">
                    <div class="card-body">
                        <div class="row mt-2">
                            <div class="col-md-12 table-responsive">
                                <table id="datatable" class="table table-bordered table-hover table-striped data-table">
                                    <thead class="bg-primary">
                                        <tr>
                                            <th class="text-center" scope="col">Sl#</th>
                                            <th class="text-center" scope="col">Policy Code</th>
                                            <th class="text-center" scope="col">Vehicle Type</th>
                                            <th class="text-center" scope="col">Minimum Rate</th>
                                            <th class="text-center" scope="col">Minimum Hour</th>
                                            <th class="text-center" scope="col">Hourly Rate</th>
                                            <th class="text-center" scope="col">Actions</th>
                                        </tr>
                                    </thead>
                                    <tbody id="all_data">

                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </section>
    </form>
</main>
<script type="application/javascript"
    src="{{ asset('node_modules/datatables/media/js/jquery.dataTables.min.js') }}"></script>

<script>
    $("body").addClass("sidebar-collapse");

    $(document).ready(function() {
        var datatable = $('.data-table').DataTable({
            "ordering": false,
            "searching": true,
            "language": {
                "infoFiltered": ""
            },
            "processing": true,
            "serverSide": true,
            "ajax": {
                "url": "{{ url('carparking/policy-list') }}",
                "dataType": "json",
                "type": "POST",
                "data": {
                    _token: "{{ csrf_token() }}"
                }
            },
            "columnDefs": [
                    {
                        "targets": -1,
                        "data": "Edit",
                        "render": function(data, type, row, meta) {
                            var edit_action = '{{ route('carparking.policy-edit', ':id') }}';
                            edit_action = edit_action.replace(':id', row[6]);

                            var delete_action = "{{ route('carparking.policy-delete', ':id') }}";
                            delete_action = delete_action.replace(':id', row[6]);

                            return '<span Class="btn btn-sm btn-primary open-modal mr-2" data-id="' +
                            row[6] + '" data-action="' + edit_action +
                            '" data-modal="common-modal-md" data-title="Edit Car Parking Policy" title="Edit"><i class="fa fa-pencil-alt"></i></span><span Class="btn btn-sm btn-danger" data-id="' +
                                row[6] + '" data-action="' + delete_action +
                                '" data-title="Delete Policy" title="Delete" onclick="removeCarParkingPolicy(this)"><i class="fa fa-trash-alt"></i></span>';
                        }
                    },
                    {
                        className: 'text-center',
                        targets: '_all'
                    }
            ]
        });
    });

    function removeCarParkingPolicy(thisElement) {
        var formAction = $(thisElement).attr("data-action");
        var policy_id = $(thisElement).attr("data-id");
        if (confirm("Are you sure?")) {
            $.ajax({
                async: true,
                url: formAction,
                type: "get",
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-body').html(
                        "<i class='fas fa-stroopwafel fa-spin'></i>");
                    $('.common-modal-notify .modal-title').html("Success");
                    $('.common-modal-notify .modal-body').html(
                        "Data Deleted Successfully");

                },
                complete: function() {
                    $(thisElement).parents("tr").remove();
                    $.unblockUI();
                }
            });

        }

        event.stopImmediatePropagation();
        return;
    }
</script>
