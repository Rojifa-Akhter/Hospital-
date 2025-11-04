@php
$room = isset($room) && !empty($room) ? $room : [];

$room_no_pk = $room ? $room->room_no_pk : '';
$room_code = $room ? $room->room_code : '';
$room_name = $room ? $room->room_name : '';
$room_description = $room ? $room->room_description : '';
$room_capacity = $room ? $room->room_capacity : '';
$category_lookup = $room ? $room->room_category_lookup_no_fk : '';
$room_size = $room ? $room->room_size : '';
$serviceunit_no_fk = $room ? $room->serviceunit_no_fk : '';
$ipd_ind = $room ? $room->ipd_ind : '';
$opd_ind = $room ? $room->opd_ind : '';
$ot_ind = $room ? $room->ot_ind : '';
$physio_ind = $room ? $room->physio_ind : '';
$status = $room ? $room->status : '';
@endphp

<div class="card">
    <div class="card-body">
        <div class="row">
            <div class="col-sm-12 col-lg-12 col-xl-12">
                <form action="{{ route('tax-cale-store') }}" method="post" id="tax-cale-store">
                    @csrf
                    <input type="hidden" name="id" value="{{ $room_no_pk }}">
                    <div class="form-group row">

                        <div class="col-md-6">
                            <label for="payroll_breakdown_code" class="col-sm-12 col-form-label col-form-label-sm">Payroll
                                breakdown code <span class="text-danger">*</span></label>
                            <div class="col-sm-12">
                                {{-- <input type="text" class="form-control form-control-sm" id="payroll_breakdown_code"
                                    name="payroll_breakdown_code" value="{{ $room_name }}"
                                    placeholder="Enter payroll breakdown code" required> --}}
                                    <select name="payroll_breakdown_code" id="payroll_breakdown_code" class="form-control form-control-sm" required>
                                        <option value="">select</option>
                                        @if (!empty($salary_breakdown))
                                        @foreach ($salary_breakdown as $kye => $value)
                                        <option value="{{$kye}}">{{$value}}</option>
                                        @endforeach
                                        @endif
                                    </select>
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="percent_of_gross" class="col-sm-12 col-form-label col-form-label-sm ">Percent of gross
                            </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control form-control-sm number_only" id="percent_of_gross"
                                    name="percent_of_gross" value="{{ $room_capacity }}">
                            </div>
                        </div>
                    </div>


                    <div class="form-group row">
                        <div class="col-md-6">
                            <label for="taxableincome_percent" class="col-sm-12 col-form-label col-form-label-sm">Taxable income
                                percent</label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control form-control-sm number_only" id="taxableincome_percent"
                                    name="taxableincome_percent" value="{{ $room_size }}">
                            </div>
                        </div>
                        <div class="col-md-6">
                            <label for="taxableincome_loweramount" class="col-sm-12 col-form-label col-form-label-sm ">Taxable
                                income lower amount </label>
                            <div class="col-sm-12">
                                <input type="text" class="form-control form-control-sm number_only"
                                    id="taxableincome_loweramount" name="taxableincome_loweramount"
                                    value="{{ $room_capacity }}">
                            </div>
                        </div>


                    </div>

                    <div class="form-group row">

                        <div class="col-md-12 d-flex justify-content-between">
                            <div class="col-md-4">
                                <div class="form-check form-check-inline">
                                    <input class="form-check-input" type="checkbox" name="active_status" id="active_status"
                                        value="1">
                                        {{-- {{ $ipd_ind == '1' ? 'checked' : '' }} --}}
                                    <label class="form-check-label" for="active_status">Active status</label>
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="modal-footer mt-1">
                        @php
                            $response_action = url('tax-cale-list');
                        @endphp
                        {{-- <button type="button" class="btn btn-sm btn-danger mr-auto" data-dismiss="modal">Exit</button> --}}
                        <button type="submit" class="btn btn-md btn-success"
                            onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')">Save</button>
                    </div>
                </form>
            </div>
        </div>
    </div>
</div>

