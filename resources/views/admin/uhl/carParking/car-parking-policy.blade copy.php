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
                                <h5 class="mt-2 mb-0">Car Parking</h5>
                                <small>Car Parking / Car Parking Policy</small>
                            </div>
                        </div>
                    </div>
                </div>


                <div class="row">
                    <div class="col-sm-12 col-lg-12">
                        <div class="card">
                            <div class="card-header">
                                <h5>CARPARKING POLICY</h5>
                            </div>


                            <table class="table table-striped table-bordered table-hover">
                                <thead class="global-uhl-table-bg">
                                    <tr>
                                        <th>Vehicle Type</th>
                                        {{-- <th>First</th> --}}
                                        <th>HRS</th>
                                        <th>Rate</th>
                                        <th>Total</th>
                                        <th></th>
                                    </tr>
                                </thead>
                                <tbody id="data-append-to">
                                    <tr id="0">
                                        <td>
                                            <select class="form-control form-control-sm" id="vehicle_type_0"
                                                name="vehicle_type[]">
                                                <option value="0">Select Type</option>
                                                @if (!empty($vicicle_data))
                                                    @foreach ($vicicle_data as $record)
                                                        <option value="{{ $record->lookupdata_name }}">
                                                            {{ $record->lookupdata_name }}</option>
                                                    @endforeach
                                                @endif
                                            </select>
                                            <span class="text-danger vehicle_span_0"></span>
                                        </td>
                                        {{-- <td>
                                            <input type="text" class="form-control form-control-sm number_only" id="first_hr_0"
                                                name="first_hr[]" placeholder="Enter First Hour" value="" />
                                            <span class="text-danger first_hr_span_0"></span>
                                        </td> --}}
                                        <td>
                                            <input type="text" class="form-control form-control-sm number_only"
                                                id="hrs_0" name="hrs[]" placeholder="Enter First Hours"
                                                value="" onkeyup="totalAmountHours(this)" />
                                            <span class="text-danger hrs_span_0"></span>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm number_only"
                                                id="rate_0" name="rate[]" placeholder="0" value=""
                                                onkeyup="totalAmountMoney(this)" />
                                            <span class="text-danger rate_span_0"></span>
                                        </td>
                                        <td>
                                            <input type="text" class="form-control form-control-sm number_only"
                                                id="Total_0" name="Total[]" placeholder="0" value="" readonly />
                                            <span class="text-danger Total_span_0"></span>
                                        </td>
                                        <td>
                                            <span id="car_td_action_0" onclick="addNewCarparking(this)"
                                                class="btn btn-md btn-success"> +Add </span>
                                        </td>
                                    </tr>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
                <div class="row">
                    <div class="col-md-12">
                        <div class="card mb-2">
                            <div class="card-body">
                                <div class="form-group">
                                    <ul class="list-inline btn__box">
                                        <li class="list-inline-item">
                                            @php
                                                $response_action = route('v1.car-parking-policy');
                                            @endphp
                                            <button class="btn btn-secondary uhl_save_btn"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">
                                                Save</button>
                                        </li>
                                    </ul>
                                </div>
                            </div>
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
                                            <th class="text-center" scope="col">Policy Date</th>
                                            <th class="text-center" scope="col">Total Hour</th>
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

    function addNewCarparking(thisElement) {
        console.log($(thisElement).parents('tbody').find('#vehicle_type_0').val() + '____________test')

        const vehicle_type = $(thisElement).parents('tbody').find('#vehicle_type_0').val()
        const first_hr = $(thisElement).parents('tbody').find('#first_hr_0').val();
        const hrs = $(thisElement).parents('tbody').find('#hrs_0').val();
        const rate = $(thisElement).parents('tbody').find('#rate_0').val();
        if (vehicle_type == 0) {
            $('.vehicle_span_0').html('Pls Enter Vehicle Type')
            return;
        } else if (first_hr == '') {
            $('.first_hr_span_0').html('Pls Enter First Name')
            return;
        } else if (hrs == '') {
            $('.hrs_span_0').html('Pls Enter Total Hours')
            return;
        } else if (rate == '') {
            $('.rate_span_0').html('Pls Enter Rate')
            return;
        } else {
            var row = $(thisElement).parents("tr").clone();
            var oldId = Number($(thisElement).parents("tr").attr("id"));
            var newId = $(thisElement).parents("#data-append-to").find("tr").length + 1;
            row.attr('id', newId);
            console.log(newId)

            row.find('#vehicle_type_' + oldId).attr('id', 'vehicle_type_' + newId).val($(thisElement).parents('tbody')
                .find(
                    '#vehicle_type_' + oldId).val());
            $(thisElement).parents('tbody').find('#first_hr_' + oldId).attr('placeholder', 'Enter Next Hour');
            $(thisElement).parents('tbody').find('#hrs_' + oldId).attr('placeholder', 'Enter Next Hours');
            $(thisElement).parents('tbody').find('#rate_' + oldId).val(0);
            $(thisElement).parents('tbody').find('#Total_' + oldId).val(0);



            $('.vehicle_span_0').html('')
            $('.first_hr_span_0').html('')
            $('.hrs_span_0').html('')
            $('.rate_span_0').html('')

            $(thisElement).parents('tbody').find('#vehicle_span_' + newId).html('');
            $(thisElement).parents('tbody').find('#first_hr_span_' + newId).html('');
            $(thisElement).parents('tbody').find('#hrs_span_' + newId).html('');
            $(thisElement).parents('tbody').find('#rate_span_' + newId).html('');



            row.find('#car_td_action_' + oldId).attr('id', 'car_td_action_' + newId);
            $(thisElement).parents("#data-append-to").append(row);
            $('#car_td_action_' + newId).html(
                "<span class='btn btn-danger btn-sm' onclick='removeTableRowOnly(this)'> <i class='fa fa-times'></i> </span>"
            );

        }
    }

    function removeTableRowOnly(thisElement) {
        if (confirm("Are you sure?")) {
            $(thisElement).parents("tr").remove();
        }
        return;
    }

    function totalAmountHours(thisElement) {
        const total_hours = $(thisElement).val()
        const total_rate = $(thisElement).parents('tbody').find('#rate_0').val() * 1
        $('#Total_0').val(total_hours * total_rate)
        console.log($(thisElement).parents('tbody').find('#rate_0').val() + '__________' + total_hours)
    }

    function totalAmountMoney(thisElement) {
        const total_rate = $(thisElement).parents('tbody').find('#hrs_0').val() * 1
        const total_hours = $(thisElement).val()
        $('#Total_0').val(total_hours * total_rate)
        console.log($(thisElement).parents('tbody').find('#rate_0').val() + '__________' + total_hours)
    }


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
            "columnDefs": [{
                "targets": -1,
                "data": "Edit",
                "render": function(data, type, row, meta) {

                    var delete_action = "{{ route('carparking/policy-delete', ':id') }}";
                    delete_action = delete_action.replace(':id', row[14]);

                    return '<span Class="btn btn-sm btn-danger" data-id="' +
                        row[14] + '" data-action="' + delete_action +
                        ' data-title="Delete Policy" title="Delete"><i class="fa fa-trash-alt"></i></span>';
                },
                "targets": 3,
                "data": "Edit",
                "render": function(data, type, row, meta) {
                    var date = new Date(row[3]);

                    var policy_date = ('0' + date.getDate()).slice(-2) + '-' + ('0' + (date
                            .getMonth() + 1)).slice(-2) + '-' + date.getFullYear() ;

                    return `
				<strong>${policy_date} </strong>`;
                }
            }]
        });
    });
</script>
