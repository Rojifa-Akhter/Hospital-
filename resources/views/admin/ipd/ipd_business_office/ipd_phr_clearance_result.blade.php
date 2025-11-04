<style>
    .heading {
        display: block;
        background: #5c5f7a1c;
        margin-bottom: 12px;
        border-radius: 2px;
        box-shadow: 0 0 5px 0 #0000000d;
    }

    .heading h5 {
        margin-bottom: 0;
        padding: 8px 5px;
        color: #5c5f7a;
        font-weight: 600;
        font-size: 16px;
        letter-spacing: 0.5px;
    }

</style>
@if (!empty($admission_info))
    @foreach ($admission_info as $admission)
         <div class="form-row">
            {{-- <div class="col-md-9">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="admission_id_view">Admission
                                        ID</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="admission_id_view"
                                        name="admission_id_view" value="{{ $admission->admission_no_pk }}"
                                        placeholder="Admission ID">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm"
                                        for="admission_date_view">Date</label>
                                    <input type="text" class="form-control form-control-sm m-0 "
                                        id="admission_date_view" name="admission_date_view"
                                        value="{{ date('d/m/Y', strtotime($admission->admission_date)) }}"
                                        placeholder="dd-mm-yyyy">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm"
                                        for="bed_cabin_view">Bed/Cabin</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="bed_cabin_view"
                                        name="bed_cabin_view" value="{{ $admission->new_bed_name }}"
                                        placeholder="Bed/Cabin">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="ward_view">Ward</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="ward_view"
                                        name="ward_view" value="{{ $admission->new_ward_name }}" placeholder="Ward">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="name_view">Name</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="name_view"
                                        name="name_view" value="{{ $admission->patient_name }}" placeholder="Name">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="age_view">Age</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="age_view"
                                        name="age_view" value="{{ $admission->age }}" placeholder="0Y-0M-0D">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="gender_view">Gender</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="gender_view"
                                        name="gender_view" value="{{ $admission->gender_txt }}" placeholder="Gender">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="blood_group_view">Blood
                                        Group</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="blood_group_view"
                                        name="blood_group_view" value="{{ $admission->blood_group_text }}"
                                        placeholder="Blood Group">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="mobile_view">Mobile</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="mobile_view"
                                        name="mobile_view"
                                        value="{{ $admission->mobile1 != null ? $admission->mobile1 : '' }}"
                                        placeholder="Mobile">
                                </div>
                            </div>

                            <div class="col-md-8">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="address_view">Address</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="address_view"
                                        name="address_view" value="{{ $admission->present_addr }}"
                                        placeholder="Address">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm"
                                        for="consultant_view">Consultant</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="consultant_view"
                                        name="consultant_view" value="{{ $admission->primary_doctor_name }}"
                                        placeholder="Consultant">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <label for="">House Keeping Clearance :

                                            @if ($admission->hk_clear_ind == 1)
                                                @php echo "<span class='badge badge-md badge-success'>Yes</span>"; @endphp
                                            @else
                                                @php echo "<span class='badge badge-md badge-danger'>No</span>"; @endphp
                                            @endif
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Food Service Clearance:
                                            @if ($admission->dk_clear_ind == 1)
                                                @php echo "<span class='badge badge-md badge-success'>Yes</span>"; @endphp
                                            @else
                                                @php echo "<span class='badge badge-md badge-danger'>No</span>"; @endphp
                                            @endif
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Cafetaria Clearance : @if ($admission->cafeteria_clear_ind == 1)
                                                @php echo "<span class='badge badge-md badge-success'>Yes</span>"; @endphp
                                            @else
                                                @php echo "<span class='badge badge-md badge-danger'>No</span>"; @endphp
                                            @endif
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Pharmacy Clearance :
                                            @if ($admission->phr_clear_ind == 1)
                                                @php echo "<span class='badge badge-md badge-success'>Yes</span>"; @endphp
                                            @else
                                                @php echo "<span class='badge badge-md badge-danger'>No</span>"; @endphp
                                            @endif
                                        </label>
                                    </div>
                                    <div class="col-md-4">
                                        <label for="">Financial Clearance : @if ($admission->fin_clear_ind == 1)
                                                @php echo "<span class='badge badge-md badge-success'>Yes</span>"; @endphp
                                            @else
                                                @php echo "<span class='badge badge-md badge-danger'>No</span>"; @endphp
                                            @endif
                                        </label>
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12 text-right">
                                @if ($admission->dis_ind == 0 && $admission->dis_req_ind == 0)
                                    <button class="btn btn-sm btn-primary mb-1 mt-2 open-modal"
                                        data-id="{{ $admission->admission_no_pk }}"
                                        data-action="{{ route('ipd.discharge-request-by-doctor', $admission->admission_no_pk) }}"
                                        data-modal="common-modal-sm" data-title="Discharge Request"
                                        title="Discharge">Discharge Request</button>
                                @endif
                                @if ($admission->dis_ind == 1)
                                    <a class="btn btn-sm btn-info mb-1 mt-2" type="submit"
                                        href="{{ route('report.discharge', $admission->admission_no_pk) }}"
                                        target="_blank" data-id="{{ $admission->admission_no_pk }}" id="admission_id"
                                        title="Discharge Certificate">Certificate</a>
                                @endif

                                @if ($admission->dis_ind == 0)
                                    <button class="btn btn-sm btn-primary mb-1 mt-2 open-modal"
                                        data-id="{{ $admission->admission_no_pk }}"
                                        data-action="{{ route('ipd.bed-transfer', $admission->admission_no_pk) }}"
                                        data-modal="common-modal-sm" data-title="Bed Transfer" title="Bed Transfer">Bed
                                        Transfer</button>
                                @endif
                            </div>
                        </div>
                    </div>
                </div>
            </div> --}}

            {{-- <div class="col-md-3">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="form-row">
                            @php
                                $date = isset($admission->dis_date) ? date('Y-m-d', strtotime($admission->dis_date)) : date('Y-m-d');
                                $date1 = date_create(date('Y-m-d', strtotime($admission->admission_date)));
                                $date2 = date_create($date);
                                $diff = date_diff($date1, $date2);

                            @endphp
                            <div class="col-md-12">
                                <div class="form-group form-row">
                                    <label class="col-md-6 col-form-label col-form-label-sm"
                                        for="admitted_days_view">Admitted Days</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control text-right form-control-sm m-0"
                                            id="admitted_days_view" name="admitted_days_view"
                                            value="{{ $admission->total_days ? $admission->total_days . ' ' . 'Day(s)' : '0 Day(s)' }} "
                                            placeholder="0 Days" style="margin-bottom: 0px !important;">
                                        <!-- {{ $diff->format('%R%a days') }} -->
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group form-row">
                                    <label class="col-md-6 col-form-label col-form-label-sm" for="total_bill_view">Total
                                        Bill</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control text-right form-control-sm m-0"
                                            id="total_bill_view" name="total_bill_view"
                                            value="{{ $admission->ledger_amt_sales }}" placeholder="0.00"
                                            style="margin-bottom: 0px !important;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group form-row">
                                    <label class="col-md-6 col-form-label col-form-label-sm"
                                        for="discount_view">Discount</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control text-right form-control-sm m-0"
                                            id="discount_view" name="discount_view"
                                            value="{{ $admission->ledger_amt_discount }}" placeholder="0.00"
                                            style="margin-bottom: 0px !important;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group form-row">
                                    <label class="col-md-6 col-form-label col-form-label-sm"
                                        for="payable_view">Payable</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control text-right form-control-sm m-0"
                                            id="payable_view" name="payable_view"
                                            value="{{ $admission->ledger_amt_payable }}" placeholder="0.00"
                                            style="margin-bottom: 0px !important;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group form-row">
                                    <label class="col-md-6 col-form-label col-form-label-sm"
                                        for="paid_view">Paid</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control text-right form-control-sm m-0"
                                            id="paid_view" name="paid_view" value="{{ $admission->paid_amount }}"
                                            placeholder="0.00" style="margin-bottom: 0px !important;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group form-row">
                                    <label class="col-md-6 col-form-label col-form-label-sm" for="due_advance_view">
                                        @if ($admission->advance_due >= 0)
                                            Due
                                        @else
                                            Advance
                                        @endif
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control text-right form-control-sm m-0"
                                            id="due_advance_view" name="due_advance_view"
                                            value="{{ abs($admission->advance_due) }}" placeholder="0.00"
                                            style="margin-bottom: 0px !important;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group form-row">
                                    <label class="col-md-6 col-form-label col-form-label-sm" for="last_paid_date">Last
                                        Paid Date</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control text-right form-control-sm m-0"
                                            id="last_paid_date" name="last_paid_date"
                                            value="{{ isset($admission->last_payment_date) && !empty($admission->last_payment_date) ? date('d-m-Y', strtotime($admission->last_payment_date)) : '' }}  "
                                            placeholder="" style="margin-bottom: 0px !important;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-6">
                                <a href="{{ route('ipd.ipd-payment', $admission->admission_no_pk) }}"
                                    class="btn btn-sm btn-success btn-block mb-1 mt-2" rel="tab">Payment</a>
                            </div>

                            <div class="col-md-6">
                                <a href="{{ route('ipd.ipd-draft-print', $admission->admission_no_pk) }}"
                                    target="_blank" class="btn btn-sm btn-success btn-block mb-1 mt-2">Draft Bills</a>
                            </div>

                            <div class="col-md-6">
                                <span class="btn btn-sm btn-success btn-block open-modal"
                                    data-id="{{ $admission->admission_no_pk }}"
                                    data-action="{{ route('ipd.financial-clearance', $admission->admission_no_pk) }}"
                                    data-modal="common-modal-sm" data-title="Financial Clearance"
                                    title="Financial Clearance">Finc. Clearance</span>
                            </div>

                            <div class="col-md-6">
                                <a href="{{ route('ipd.ipd-final-bill-print', $admission->admission_no_pk) }}"
                                    class="btn btn-sm btn-success btn-block" target="_blank">Final Bill</a>
                            </div>
                            <div class="col-md-6 mt-2">
                                <a href="{{ route('billing.service-billing', $admission->patient_no_fk . '-' . $admission->admission_no_pk . '-' . 'ipd') }}"
                                    class="btn btn-sm btn-success btn-block" target="_blank">Service Billing</a>
                            </div>
                            @php
                                $param = $admission->patient_no_fk . '_' . $admission->mobile1 . '_' . $admission->patient_name . '_' . $admission->primary_doctor_name . '_' . abs($admission->paid_amount) . '_' . $admission->ledger_amt_sales;
                            @endphp
                            <div class="col-md-6 mt-2">
                                <button type="button" data-action="{{ route('ipd-sms-modal', $param) }}" data-id=""
                                    class="btn btn-sm btn-success btn-block open-modal" data-modal="common-modal-sm"
                                    data-title="IPD SMS"><i class="fa fa-sms"></i>&nbsp;SMS</button>
                            </div>



                        </div>
                    </div>
                </div>
            </div> --}}


            {{-- new ipd look start --}}
            <div class="col-md-9">
                    <div class="card">
                        <div class="card-header" style="background: #38c172f0; color: #fff;">
                            <div class="form-row">
                                <div class="col-md-4 col-sm-4 col-6">
                                    <span>{{ $admission->patient_name }} </span>
                                </div>
                                <div class="col-md-2 col-sm-2 col-6 text-center">
                                    <span>Age: {{ $admission->age }}</span>
                                </div>
                                <div class="col-md-2 col-sm-1 col-3 text-center">
                                    <span>Gender: {{ $admission->gender_txt }}</span>
                                </div>
                                <div class="col-md-1 col-sm-1 col-3 text-center">
                                    <span>BG: B+</span>
                                </div>
                                <div class="col-md-3 col-sm-3 col-6 text-right">
                                    <span>{{ $admission->new_ward_name }} ||</span>
                                    <span>Bed: {{ $admission->new_bed_name }} </span>
                                </div>
                            </div>
                        </div>
                        <div class="card-header" style="color: #fff; background: #5c5f7a;">
                            <div class="form-row">
                                <div class="col-md-8 col-sm-8 col-8">
                                    <span>Admitted Under: {{ $admission->primary_doctor_name }}</span>
                                </div>

                                <div class="col-md-4 col-sm-4 col-4 text-right">
                                    <span>Date: {{ date('d/m/Y', strtotime($admission->admission_date)) }}</span>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-2">
                            <div class="form-row">
                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label col-form-label-sm" for="admission_id_view">Admission ID</label>
                                        <input type="text" class="form-control form-control-sm m-0" id="admission_id_view" name="admission_id_view" value="{{ $admission->admission_no_pk }}" placeholder="Admission ID" />
                                    </div>
                                </div>

                                <div class="col-md-3">
                                    <div class="form-group">
                                        <label class="col-form-label col-form-label-sm" for="mobile_view">Mobile</label>
                                        <input type="text" class="form-control form-control-sm m-0" id="mobile_view" name="mobile_view" value="{{ $admission->mobile1 != null ? $admission->mobile1 : '' }}" placeholder="+880" />
                                    </div>
                                </div>

                                <div class="col-md-6">
                                    <div class="form-group">
                                        <label class="col-form-label col-form-label-sm" for="address_view">Address</label>
                                        <input type="text" class="form-control form-control-sm m-0" id="address_view" name="address_view" value="{{ $admission->present_addr }}" placeholder="Address" />
                                    </div>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-2">
                            <div class="heading">
                                <h5>Clearance</h5>
                            </div>

                            <div class="form-row">
                                <div class="col-lg-2 col-md-4">
                                    <label for="hk" class="col-form-label col-form-label-sm">
                                        HK:
                                        @if ($admission->hk_clear_ind == 1)
                                        @php echo "<span class='badge badge-md badge-success'>Yes</span>"; @endphp
                                    @else
                                        @php echo "<span class='badge badge-md badge-danger'>No</span>"; @endphp
                                    @endif
                                    </label>
                                </div>
                                <div class="col-lg-2 col-md-4">
                                    <label for="pharmacy" class="col-form-label col-form-label-sm">
                                        Pharmacy:
                                        @if ($admission->phr_clear_ind == 1)
                                                @php echo "<span class='badge badge-md badge-success'>Yes</span>"; @endphp
                                            @else
                                                @php echo "<span class='badge badge-md badge-danger'>No</span>"; @endphp
                                            @endif
                                    </label>
                                </div>
                                <div class="col-lg-2 col-md-4">
                                    <label for="fs" class="col-form-label col-form-label-sm">
                                        Food Service:
                                        @if ($admission->dk_clear_ind == 1)
                                                @php echo "<span class='badge badge-md badge-success'>Yes</span>"; @endphp
                                            @else
                                                @php echo "<span class='badge badge-md badge-danger'>No</span>"; @endphp
                                            @endif
                                    </label>
                                </div>
                                <div class="col-lg-2 col-md-4">
                                    <label for="cafetwria" class="col-form-label col-form-label-sm">
                                        Cafeteria:
                                        @if ($admission->cafeteria_clear_ind == 1)
                                                @php echo "<span class='badge badge-md badge-success'>Yes</span>"; @endphp
                                            @else
                                                @php echo "<span class='badge badge-md badge-danger'>No</span>"; @endphp
                                            @endif
                                    </label>
                                </div>
                                <div class="col-lg-2 col-md-4">
                                    <label for="financial" class="col-form-label col-form-label-sm">
                                        Financial:
                                        @if ($admission->fin_clear_ind == 1)
                                        @php echo "<span class='badge badge-md badge-success'>Yes</span>"; @endphp
                                    @else
                                        @php echo "<span class='badge badge-md badge-danger'>No</span>"; @endphp
                                    @endif
                                    </label>
                                </div>
                                <div class="col-lg-2 col-md-4 text-right">
                                    <span class="badge badge-md badge-success">Cleared</span>
                                    <span class="badge badge-md badge-danger">Pending</span>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-2">
                            <div class="heading">
                                <h5>Discharge</h5>
                            </div>
                            <div class="form-row">
                                <div class="col-md-3">
                                    <label for="requested" class="col-form-label col-form-label-sm">
                                        Requested:
                                        @if ( $admission->dis_req_ind == 1)
                                        <span class="badge badge-md badge-success">Yes</span>
                                        @else
                                        <span class="badge badge-md badge-danger">No</span>
                                        @endif
                                    </label>
                                </div>
                                <div class="col-md-3 text-center">
                                    <strong class="col-form-label col-form-label-sm">Date:</strong>
                                    <span class="global_dis">{{$admission->dis_req_time !="" ? date('d/m/Y',strtotime($admission->dis_req_time)) : ''}}</span>
                                </div>

                                <div class="col-md-3 text-center">
                                    <strong class="col-form-label col-form-label-sm">Time:</strong>
                                    <span class="global_dis">{{$admission->dis_req_time !="" ? date('h:i:s a',strtotime($admission->dis_req_time)) : ''}}</span>
                                </div>
                                <div class="col-md-3 text-right">
                                    <strong class="col-form-label col-form-label-sm">By:</strong>
                                    <span class="global_dis">{{$admission->dis_req_doctor_name}}</span>
                                </div>
                            </div>
                        </div>

                        <div class="col-md-12 text-right mb-3">

                            {{-- @if ($admission->dis_ind == 0 && $admission->dis_req_ind == 0)
                            <button class="btn btn-sm btn-primary mb-1 mt-2 open-modal"
                                data-id="{{ $admission->admission_no_pk }}"
                                data-action="{{ route('ipd.discharge-request-by-doctor', $admission->admission_no_pk) }}"
                                data-modal="common-modal-sm" data-title="Discharge Request"
                                title="Discharge">Discharge Request</button>
                        @endif
                        @if ($admission->dis_ind == 1)
                            <a class="btn btn-sm btn-info mb-1 mt-2" type="submit"
                                href="{{ route('report.discharge', $admission->admission_no_pk) }}"
                                target="_blank" data-id="{{ $admission->admission_no_pk }}" id="admission_id"
                                title="Discharge Certificate">Certificate</a>
                        @endif

                        @if ($admission->dis_ind == 0)
                            <button class="btn btn-sm btn-primary mb-1 mt-2 open-modal"
                                data-id="{{ $admission->admission_no_pk }}"
                                data-action="{{ route('ipd.bed-transfer', $admission->admission_no_pk) }}"
                                data-modal="common-modal-sm" data-title="Bed Transfer" title="Bed Transfer">Bed
                                Transfer</button>
                        @endif --}}
                        </div>
                    </div>
                </div>

                <div class="col-md-3">
                    <div class="card">
                        <div class="card-header text-center">
                           <h2> Clearance </h2>
                        </div>
                        <div class="card-body p-2">
                            <div class="form-row">
                                @php $date = isset($admission->dis_date) ? date('Y-m-d', strtotime($admission->dis_date)) : date('Y-m-d'); $date1 = date_create(date('Y-m-d', strtotime($admission->admission_date))); $date2 = date_create($date); $diff =
                                date_diff($date1, $date2); @endphp
                                {{-- <div class="col-md-12">
                                    <div class="form-group form-row">
                                        <label class="col-md-6 col-form-label col-form-label-sm" for="admitted_days_view">Admitted Days</label>
                                        <div class="col-md-6">
                                            <input
                                                type="text"
                                                class="form-control text-right form-control-sm m-0"
                                                id="admitted_days_view"
                                                name="admitted_days_view"
                                                value="{{ $admission->total_days ? $admission->total_days .' '. 'Day(s)' : '0 Day(s)' }} "
                                                placeholder="0 Days"
                                                style="margin-bottom: 0px !important;"
                                            />
                                            <!-- {{ $diff->format('%R%a days') }} -->
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group form-row">
                                        <label class="col-md-6 col-form-label col-form-label-sm" for="total_bill_view">Total Bill</label>
                                        <div class="col-md-6">
                                            <input
                                                type="text"
                                                class="form-control text-right form-control-sm m-0"
                                                id="total_bill_view"
                                                name="total_bill_view"
                                                value="{{ $admission->ledger_amt_sales }}"
                                                placeholder="0.00"
                                                style="margin-bottom: 0px !important;"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group form-row">
                                        <label class="col-md-6 col-form-label col-form-label-sm" for="discount_view">Discount</label>
                                        <div class="col-md-6">
                                            <input
                                                type="text"
                                                class="form-control text-right form-control-sm m-0"
                                                id="discount_view"
                                                name="discount_view"
                                                value="{{ $admission->ledger_amt_discount }}"
                                                placeholder="0.00"
                                                style="margin-bottom: 0px !important;"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group form-row">
                                        <label class="col-md-6 col-form-label col-form-label-sm" for="payable_view">Payable</label>
                                        <div class="col-md-6">
                                            <input
                                                type="text"
                                                class="form-control text-right form-control-sm m-0"
                                                id="payable_view"
                                                name="payable_view"
                                                value="{{ $admission->ledger_amt_payable }}"
                                                placeholder="0.00"
                                                style="margin-bottom: 0px !important;"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group form-row">
                                        <label class="col-md-6 col-form-label col-form-label-sm" for="paid_view">Paid</label>
                                        <div class="col-md-6">
                                            <input type="text" class="form-control text-right form-control-sm m-0" id="paid_view" name="paid_view" value="{{ $admission->paid_amount }}" placeholder="0.00" style="margin-bottom: 0px !important;" />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group form-row">
                                        <label class="col-md-6 col-form-label col-form-label-sm" for="due_advance_view">
                                            @if ($admission->advance_due >= 0) Due @else Advance @endif
                                        </label>
                                        <div class="col-md-6">
                                            <input
                                                type="text"
                                                class="form-control text-right form-control-sm m-0"
                                                id="due_advance_view"
                                                name="due_advance_view"
                                                value="{{ abs($admission->advance_due) }}"
                                                placeholder="0.00"
                                                style="margin-bottom: 0px !important;"
                                            />
                                        </div>
                                    </div>
                                </div>

                                <div class="col-md-12">
                                    <div class="form-group form-row">
                                        <label class="col-md-6 col-form-label col-form-label-sm" for="last_paid_date">Last Paid Date</label>
                                        <div class="col-md-6">
                                            <input
                                                type="text"
                                                class="form-control text-right form-control-sm m-0"
                                                id="last_paid_date"
                                                name="last_paid_date"
                                                value="{{ isset($admission->last_payment_date) && !empty($admission->last_payment_date) ? date('d-m-Y', strtotime($admission->last_payment_date)) : '' }}  "
                                                placeholder=""
                                                style="margin-bottom: 0px !important;"
                                            />
                                        </div>
                                    </div>
                                </div> --}}

                                {{-- <div class="col-md-6">
                                    <a href="{{ route('ipd.ipd-payment', $admission->admission_no_pk) }}" class="btn btn-sm btn-success btn-block mb-1 mt-2" rel="tab">Payment</a>
                                </div>

                                <div class="col-md-6">
                                    <a href="{{ route('ipd.ipd-draft-print', $admission->admission_no_pk) }}" target="_blank" class="btn btn-sm btn-success btn-block mb-1 mt-2">Draft Bills</a>
                                </div> --}}

                                <div class="col-md-12 mt-2">
                                    <span
                                        class="btn btn-md btn-info btn-block open-modal"
                                        data-id="{{ $admission->admission_no_pk }}"
                                        data-action="{{ route('ipd.financial-clearance2', [$admission->admission_no_pk,'PHR']) }}"
                                        data-modal="common-modal-sm"
                                        data-title="Financial Clearance"
                                        title="Financial Clearance"
                                    >
                                    Pharmacy Clearance
                                    </span>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <span
                                        class="btn btn-md btn-info btn-block open-modal"
                                        data-id="{{ $admission->admission_no_pk }}"
                                        data-action="{{ route('ipd.financial-clearance2', [$admission->admission_no_pk,'HKC']) }}"
                                        data-modal="common-modal-sm"
                                        data-title="Financial Clearance"
                                        title="Financial Clearance"
                                    >

                                    House Keeping Clearance
                                    </span>
                                </div>

                                <div class="col-md-12 mt-2">
                                    <span
                                        class="btn btn-md btn-info btn-block open-modal"
                                        data-id="{{ $admission->admission_no_pk }}"
                                        data-action="{{ route('ipd.financial-clearance2', [$admission->admission_no_pk,'FSC']) }}"
                                        data-modal="common-modal-sm"
                                        data-title="Financial Clearance"
                                        title="Financial Clearance"
                                    >
                                    Food Service Clearance
                                    </span>
                                </div>
                                <div class="col-md-12 mt-2">
                                    <span
                                        class="btn btn-md btn-info btn-block open-modal"
                                        data-id="{{ $admission->admission_no_pk }}"
                                        data-action="{{ route('ipd.financial-clearance2', [$admission->admission_no_pk , 'CAFC']) }}"
                                        data-modal="common-modal-sm"
                                        data-title="Financial Clearance"
                                        title="Financial Clearance"
                                    >
                                    Cafetaria Clearance
                                    </span>
                                </div>

                              {{-- <div class="col-md-6">
                                    <a href="{{ route('ipd.ipd-final-bill-print', $admission->admission_no_pk) }}" class="btn btn-sm btn-success btn-block" target="_blank">Final Bill</a>
                                </div>
                                <div class="col-md-6 mt-2">
                                    <a href="{{ route('billing.service-billing', $admission->patient_no_fk . '-' . $admission->admission_no_pk . '-' . 'ipd') }}" class="btn btn-sm btn-success btn-block" target="_blank">Service Billing</a>
                                </div> --}}
                                @php $param = $admission->patient_no_fk . '_' . $admission->mobile1 . '_' . $admission->patient_name . '_' . $admission->primary_doctor_name . '_' .abs($admission->paid_amount) . '_' . $admission->ledger_amt_sales; @endphp
                                {{-- <div class="col-md-6 mt-2">
                                    <button type="button" data-action="{{ route('ipd-sms-modal', $param) }}" data-id="" class="btn btn-sm btn-success btn-block open-modal" data-modal="common-modal-sm" data-title="IPD SMS">
                                        <i class="fa fa-sms"></i>&nbsp;SMS
                                    </button>
                                </div> --}}
                            </div>
                        </div>
                    </div>
                </div>

            {{-- new ipd look end--}}
        </div>
    @endforeach
    {{ $admission_info->links() }}
@else
    <div class="form-row">
        <div class="col-md-12">
            <div class="card">
                <div class="card-body">

                    <p class="text-center mt-2"> No Patient Found </p>

                </div>
            </div>
        </div>


    </div>


@endif


</div>
