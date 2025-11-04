<style>
    .bed-icon {
        width: 50px;
        margin: auto;
    }

    .bed {
        margin: 5px;
        border: 1px solid #004b7b;
        padding: 5px;
        position: relative;
        overflow: hidden;
        min-height: 77px;
        background-color: #9e9d9d33;
    }

    .bed-availability {
        content: '';
        height: 50px;
        width: 50px;
        position: absolute;
        top: -32px;
        left: -32px;
        transform: rotate(45deg);
        /*background-color: #222;*/
        overflow: hidden;
    }

    .nowrap {
        white-space: nowrap;
    }
</style>
<div class="custom-card-header">
    <ul class="list-inline">
        <li class="list-inline-item text-secondary">Total Bed <span
                class="badge badge-primary">{{ $bedStats['total_beds'] }}</span></li>
        <li class="list-inline-item text-secondary">Available <span
                class="badge badge-success">{{ $bedStats['available'] }}</span></li>
        <li class="list-inline-item text-secondary">Occupied <span
                class="badge badge-danger">{{ $bedStats['occupied'] }}</span></li>
        <li class="list-inline-item text-secondary">Not Ready<span
                class="badge badge-warning">{{ $bedStats['not_ready'] }}</span></li>
    </ul>
</div>


<div class="form-row pt-2">
    <div class="col-6">
        <h6><strong>Patient Name: </strong>{{ @$patient_info->patient_name }}</h6>
    </div>
    <div class="col-6">
        <h6><strong>IP No: </strong>{{ @$patient_info->admission_no_pk }}</h6>
    </div>
</div>



<div class="form-row">
    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label col-form-label-sm" for="ward">Ward Name</label>
            <input type = "hidden" class="form-control form-control-sm" id="ward" name="ward"
                value="{{ $ward_name }}" disabled>
            <input type = "hidden" id= "ward_no" name="ward_no" value="{{ $ward_no }}">
            <input type = "hidden" id= "admission_no" name="admission_no" value="{{ $admission_no }}">
            <input type = "hidden" id= "bed_no" name="bed_no" value="{{ $bed_no }}">

            <select name="ipd_ward_no" id="ipd_ward_no" class="form-control form-control-sm select2"
                onchange="fetchBeds()">
                <option value=" " selected>All</option>
                @foreach ($ipds_ward as $key => $item)
                    <option value="{{ $item->ward_no_pk }}">{{ $item->ward_name }}</option>
                @endforeach
            </select>


        </div>
    </div>

    <div class="col-md-6">
        <div class="form-group">
            <label class="col-form-label col-form-label-sm " for="bed_status">Bed Status</label>
            <select class="form-control form-control-sm" id="bed_status" name="bed_status" onchange="fetchBeds()">
                <option value="0">All Beds</option>
                <option value="1" selected>Available</option>
                <option value="2">Occupied</option>
                <option value="3">Not Ready</option>
            </select>
        </div>
    </div>
</div>

<div class="beds align-items-center clearfix " id="bed_show">
    <h6 class="text-center py-2">Fetching Bed ... </h6>
</div>


<div class="m-0 pt-2 mt-2 text-right border-top">
    <button type="button" class="btn btn-primary btn-sm update-assign-bed-btn" onclick="bedTransfer(1)"><i
            class="fa fa-save"></i>Transfer & Retain</button>
    <button type="button" class="btn btn-success btn-sm update-assign-bed-btn" onclick="bedTransfer()"><i
            class="fa fa-save"></i>Transfer</button>
    <a style="cursor:pointer" class="btn btn-md btn-primary w-15 text-white mt-1 open-modal"
        data-modal="common-modal-md" data-title="Consultant Change"
        data-action="{{ route('ipd.consultant-change', [@$patient_info->patient_no_fk, @$patient_info->admission_uid]) }}">
        Consultant Change
    </a>


</div>


<div class="row">
    <div class="col-12">
        <h6 class="text-center mt-2"><b>Bed Transfer History</b></h6>
        <div class="table-responsive">
            <table class="table table-striped table-bordered table-hover">
                <thead class="global-uhl-table-bg">
                    <tr>
                        <th class="text-center nowrap" style="width: 3%">SL</th>
                        <th class="text-left nowrap" style="width: 16%">Bed Name</th>
                        <th class="text-left nowrap" style="width: 11%">Bed Category</th>
                        <th class="text-left nowrap" style="width: 14%">Start Time</th>
                        <th class="text-left nowrap" style="width: 14%">End Time</th>
                        <th class="text-left nowrap" style="width: 16%">Remarks</th>
                        <th class="text-center nowrap" style="width: 8%">Total Days</th>
                        <th class="text-left nowrap" style="width: 10%">Days</th>
                        <th class="text-center nowrap" style="width: 11%">Bed Status</th>
                    </tr>
                </thead>
                <tbody>

                    @forelse($bed_history as $key => $item)
                        <tr>
                            <td class="text-center">{{ ++$key }}</td>
                            <td class="text-left nowrap">{{ $item->bed_no_fk }} - {{ $item->bed_name }}</td>
                            <td class="text-left nowrap">{{ $item->ward_no_fk }} - {{ $item->ward_name }}</td>
                            <td class="text-left nowrap">
                                @if (!empty($item->start_time))
                                    {{ date('Y-m-d h:i:s a', strtotime($item->start_time)) }}
                                @endif
                            </td>
                            <td class="text-left nowrap">
                                @if (!empty($item->end_time))
                                    {{ date('Y-m-d h:i:s a', strtotime($item->end_time)) }}
                                @endif
                            </td>

                            <td class="text-left">{{ @$item->remarks }}</td>
                            <td class="text-center">{{ @$item->total_days }}</td>
                            <td class="text-left nowrap">
                                <input type="hidden" class="form-control form-control-sm text-right"
                                    value="{{ $item->ipd_adm_bed_no_pk }}">
                                <input type="number" class="form-control form-control-sm text-right"
                                    id="{{ $item->ipd_adm_bed_no_pk }}" name="days"
                                    value="@if ($item->calculation_ind != 1) {{ $item->days }}@else{{ $item->total_days }} @endif"
                                    @if ($item->calculation_ind == 1) {{ 'disabled' }} @endif>
                            </td>

                            <td class="text-center nowrap">

                                @if ($item->calculation_ind != 1)
                                    <button class="btn btn-sm btn-success"
                                        onclick="billGenerate('{{ $item->ipd_adm_bed_no_pk }}')">Bill
                                        Generate</button>
                                @else
                                    @if (!empty($item->invoice_no_fk) && !empty($item->ledgertrn_no_fk))
                                        @if (Session::get('user.ses_hospital_code') == 'UNICO')
                                            <a href="{{ route('due-invoice-print-v2', [$item->invoice_no_fk, $item->ledgertrn_no_fk]) }}"
                                                class="btn btn-warning btn-sm" target="_blank">Bill</a>
                                        @else
                                            <a href="{{ route('due-invoice-ipd-print', [$item->invoice_no_fk, $item->ledgertrn_no_fk]) }}"
                                                class="btn btn-warning btn-sm" target="_blank">Bill</a>
                                        @endif
                                    @endif
                                @endif
                                @if ($item->status == 1)
                                    @if (empty($item->end_time))
                                        <span class="badge badge-primary">Active</span>
                                    @endif
                                @elseif($item->status == 2)
                                    @if (empty($item->end_time))
                                        <div class="btn-group dropright">
                                            <button type="button" class="btn btn-sm btn-secondary dropdown-toggle"
                                                data-toggle="dropdown" aria-haspopup="true" aria-expanded="false">
                                                Hold
                                            </button>
                                            <div class="dropdown-menu">
                                                <a class="dropdown-item"
                                                    onclick="setActiveBed(1, '{{ $item->ipd_adm_bed_no_pk }}')">Active</a>
                                                <a class="dropdown-item"
                                                    onclick="setActiveBed(2, '{{ $item->ipd_adm_bed_no_pk }}')">Free</a>
                                            </div>
                                        </div>
                                    @endif
                                @endif
                            </td>

                        </tr>
                    @empty
                        <tr>
                            <td colspan="8" class="text-center text-danger">Data Not Found</td>
                        </tr>
                    @endforelse
                </tbody>
            </table>
        </div>
    </div>
</div>

<script src="{{ asset('node_modules/select2/dist/js/select2.min.js') }}"></script>
<script>
    $(document).ready(function() {

        $('.select2').select2({
            placeholder: "Select Ward",
            // allowClear: true
        });

        var curr_bed_no = parseInt($("#bed_no").val())



        $(document).on('click', 'input[type="checkbox"]', function() {
            $('input[type="checkbox"]').not(this).prop('checked', false);
            $("input:checkbox[name=select_bed]:checked").each(function() {
                curr_bed_no = parseInt($(this).val());
            });
        });


    });

    function bedTransfer(ind = null) {
        var curr_bed = $("input[name='select_bed']:checked").val();
        if (curr_bed == null) {
            alert('please select a bed!');
            return false;
        }
        var old_bed = $("#bed_no").val();

        if (isNaN(curr_bed)) {
            alert('Please, Select a bed.');
            return false;
        }
        if (!confirm("Are you sure?")) {
            return false;
        }

        $.ajax({
            async: true,
            data: {
                prev_bed_no_fk: old_bed,
                curr_bed_no_fk: curr_bed,
                admission_no_pk: parseInt($("#admission_no").val()),
                ward_no_fk: parseInt($("#ipd_ward_no").val()),
                transfer_hold: ind,
            },
            url: "{{ route('v2.ipd.update-assign-bed') }}",
            type: 'post',
            beforeSend: function() {
                if (isAModalOpen)
                    $('.modal').modal('hide');
                blockUI();
            },
            success: function(data) {
                if (isAModalOpen)
                    $('.modal').modal('hide');
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-title').html(data.title);
                $('.common-modal-notify .modal-body').html(data.message);
            },
            error: function(err) {
                $.unblockUI();
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            }
        }).done(function() {
            $.unblockUI();
        });
    }

    function billGenerate(ipd_adm_bed_no_pk) {
        var curr_bed = $("input[name='select_bed']:checked").val();
        var qty = $("#" + ipd_adm_bed_no_pk).val();
        console.log(curr_bed, qty)

        // if (isNaN(qty) || qty <= 0) {
        // 	alert('Qty Required');
        // 	return false;
        // }
        if (!confirm("Are you sure?")) {
            return false;
        }

        $.ajax({
            async: true,
            data: {
                ipd_adm_bed_no_pk: ipd_adm_bed_no_pk,
                days: qty,

            },
            url: "{{ route('v2.ipd.bed-bill-generate') }}",
            type: 'post',
            beforeSend: function() {
                if (isAModalOpen)
                    $('.modal').modal('hide');
                blockUI();
            },
            success: function(data) {
                if (isAModalOpen)
                    $('.modal').modal('hide');
                $('.common-modal-notify').modal('show');
                $('.common-modal-notify .modal-title').html(data.title);
                $('.common-modal-notify .modal-body').html(data.message);
            },
            error: function(err) {
                $.unblockUI();
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            }
        }).done(function() {
            $.unblockUI();
        });
    }


    function setActiveBed(ind, ipd_adm_bed_no_pk) {
        if (confirm("Are you sure?")) {
            $.ajax({
                async: true,
                data: {
                    ipd_adm_bed_no_pk: ipd_adm_bed_no_pk,
                    active_free: ind,
                },
                url: "{{ route('v2.ipd.update-assign-bed-active-free') }}",
                type: 'post',
                beforeSend: function() {
                    blockUI();
                },
                success: function(data) {
                    $.unblockUI();
                    if (isAModalOpen)
                        $('.modal').modal('hide');

                    $('#exampleModal').modal('hide')
                    $('.common-modal-notify').modal('show');
                    $('.common-modal-notify .modal-title').html(data.title);
                    $('.common-modal-notify .modal-body').html(data.message);
                },
                error: function(err) {
                    $.unblockUI();
                    var error = err.responseJSON;
                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html('Failed');
                    $('.common-modal-notify-error .modal-body').html(error.message);
                }
            })

        }
    }

    fetchBeds();

    function fetchBeds() {
        $.ajax({
            async: true,
            data: {
                bed_status: parseInt($("#bed_status").val()),
                ward_no_fk: parseInt($("#ipd_ward_no").val()),
            },
            url: "{{ route('v2.ipd.get-bed-list-by-ward') }}",
            type: 'post',
            beforeSend: function() {
                blockUI();
            },
            success: function(data) {
                $.unblockUI();
                bedShow(data.ipds_beds);
            },
            error: function(err) {
                $.unblockUI();
                var error = err.responseJSON;
                $('.common-modal-notify-error').modal('show');
                $('.common-modal-notify-error .modal-title').html('Failed');
                $('.common-modal-notify-error .modal-body').html(error.message);
            }
        }).done(function() {
            $.unblockUI();
        });
    }


    function bedShow(data) {
        var bed = `<div class="row gx-1">`;
        var bed_no = '{{ $bed_no }}';
        data.forEach(element => {
            bed += `<div class="col-md-2 col-6 p-1">`;
            bed += `<div class="bed text-center bed-status-${element.bed_status}">`;
            if (element.bed_status == 1) {
                bed += `<div class="bed-availability bg-success"></div>`;
            } else if (element.bed_status == 2) {
                bed += `<div class="bed-availability bg-danger"></div>`;
            } else if (element.bed_status == 3) {
                bed += `<div class="bed-availability bg-warning"></div>`;
            }

            bed += `<div class="bed-icon">`;
            bed += `<img class="w-100" src="{{ asset('images/hospital-bed.png') }}" alt="">`;
            bed += `</div>`;
            bed += `<div class="bed-name">`;
            bed += `<h6 class="mb-0">${element.bed_name}</h6>`;
            bed += `</div>`;
            if (element.bed_status == 1) {
                if (element.bed_no_pk == bed_no) {
                    bed +=
                        `<input type="checkbox" class="d-flex" name="select_bed" value="${element.bed_no_pk}" checked>`;
                } else {
                    bed +=
                        `<input type="checkbox" class="d-flex" name="select_bed" id="bed_status${element.bed_no_pk}" value="${element.bed_no_pk}">`;
                }
            } else {
                if (element.bed_no_pk == bed_no) {
                    bed += `<input type = "checkbox" class="d-flex" name="select_bed" checked disabled>`;

                }
            }

            bed += `</div>`;
            bed += `</div>`;


        });
        bed += `</div>`;

        $("#bed_show").html(bed)

    }
</script>
