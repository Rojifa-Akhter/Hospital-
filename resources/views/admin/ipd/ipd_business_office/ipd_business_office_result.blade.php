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
            <div class="col-md-9">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="form-row">
                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="admission_id_view">IP No</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="admission_id_view"
                                        name="admission_id_view" value="{{ $admission->admission_no_pk }}"
                                        placeholder="IP No">
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
                                        name="bed_cabin_view"
                                        value="{{ $admission->new_bed_name != '' ? $admission->new_bed_name : $admission->bed_name }}"
                                        placeholder="Bed/Cabin">
                                </div>
                            </div>

                            <div class="col-md-4">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm" for="ward_view">Bed Category</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="ward_view"
                                        name="ward_view"
                                        value="{{ $admission->new_ward_name != '' ? $admission->new_ward_name : $admission->ward_name }}"
                                        placeholder="Bed Category">
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
                                    <label class="col-form-label col-form-label-sm" for="gender_view">Sex</label>
                                    <input type="text" class="form-control form-control-sm m-0" id="gender_view"
                                        name="gender_view" value="{{ $admission->gender_txt }}" placeholder="Sex">
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

                            <div class="col-md-4">
                                <div class="form-group">
                                    @if(Session::get('user.ses_hospital_code') == "UNICO")
                                    <label class="col-form-label col-form-label-sm" for="address_view">UHID</label>
                                    @elseif(Session::get('user.ses_hospital_code') == "KPJ")
                                    <label class="col-form-label col-form-label-sm" for="address_view">MRN</label>
                                    @else
                                    <label class="col-form-label col-form-label-sm" for="address_view">UHID</label>
                                    @endif

                                    <input type="text" class="form-control form-control-sm m-0"
                                    value="{{ $admission->patient_code }}"
                                    placeholder="ID">
                                </div>
                            </div>

                            <div class="col-md-4">
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
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="consultant_view" name="consultant_view"
                                        value="{{ $admission->primary_doctor_name }}" placeholder="Consultant">
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-group">
                                    <label class="col-form-label col-form-label-sm"
                                        for="consultant_view">Note</label>
                                    <input type="text" class="form-control form-control-sm m-0"
                                        id="note" name="note"
                                        value="{{ @$admission->remarks ?: 'N/A' }}" readonly>
                                </div>
                            </div>
                            <div class="col-md-12">
                                <div class="form-row">
                                    <div class="col-md-4">
                                        <label for="">House Keeping Clearance
                                            {{ $admission->housekeeping_bill_ind }} :

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

                            @if ($admission->housekeeping_bill_ind == 0)
                                <div class="col-md-3">

                                    @if (
                                        ($admission->dis_ind != 1 && Session::get('user.ses_hospital_code') == 'JKMH') ||
                                            Session::get('user.ses_hospital_code') == 'KBMH')
                                        <button
                                            data-action="{{ route('ipd.ipd-update-discharge', $admission->admission_no_pk) }}"
                                            onclick="updateDischargeInd(this)" class="btn btn-sm btn-danger mb-1 mt-2"
                                            title="Discharge" rel="tab">Discharge</button>
                                    @endif
                                </div>
                                <div class="col-md-6 text-right">
                                    @if ($admission->dis_ind == 0 && $admission->dis_req_ind == 0 && Session::get('user.ses_hospital_code') != 'JKMH')
                                        @if (Session::get('user.ses_hospital_code') != 'KBMH')
                                            <button class="btn btn-sm btn-primary mb-1 mt-2 open-modal"
                                                data-id="{{ $admission->admission_no_pk }}"
                                                data-action="{{ route('ipd.discharge-request-by-doctor', $admission->admission_no_pk) }}"
                                                data-modal="common-modal-sm" data-title="Discharge Request"
                                                title="Discharge">Discharge Request</button>
                                        @endif
                                    @endif


                                    @php
                                        $isLocked = $admission->lock_ind;
                                        $btnClass = $isLocked ? 'btn-warning' : 'btn-success';
                                        $btnText  = $isLocked ? 'Bill Unlock' : 'Bill Lock';
                                        $lock_remarks1 = $admission->lock_remarks ? $admission->lock_remarks : 'Remarks';
                                    @endphp

                                    @if (!$admission->dis_ind)
                                        <button
                                            class="btn btn-sm mb-1 mt-2 open-modal {{ $btnClass }}"
                                            data-id="{{ $admission->admission_no_pk }}"
                                            data-action="{{ route('ipd.bill-lock', [$admission->admission_no_pk, $lock_remarks1, $admission->lock_ind]) }}"
                                            data-modal="common-modal-sm"
                                            data-title="{{ $btnText }}"
                                            title="{{ $btnText }}">
                                            {{ $btnText }}
                                        </button>
                                    @endif

                                    @if ($admission->dis_ind == 1)
                                        <a class="btn btn-sm btn-info mb-1 mt-2" type="submit"
                                            href="{{ route('report.discharge', $admission->admission_no_pk) }}"
                                            target="_blank" data-id="{{ $admission->admission_no_pk }}"
                                            id="admission_id" title="Discharge Certificate">Certificate</a>
                                    @endif



                                    @if (Session::get('user.ses_hospital_code') != 'KBMH')
                                        @if ($admission->dis_ind == 0)
                                            <button class="btn btn-sm btn-primary mb-1 mt-2 open-modal"
                                                data-id="{{ $admission->admission_no_pk }}"
                                                data-modal="common-modal-xl"
                                                data-title="Bed Transfer"
                                                data-action="{{ route('v2.ipd.assign-bed', [
                                                    'adms_no' => @$admission->admission_no_pk,
                                                ]) }}"
                                                title="Bed Transfer"
                                                >Bed Transfer</button>






                                        @endif
                                    @endif

                                </div>
                                <div class="col-md-3 text-right">
                                    @if ($admission->dis_ind == 0)
                                        <form id="house_keeping_form_{{ $admission->admission_no_pk }}"
                                            action="{{ route('ipd.housekeeping-charge', [$admission->admission_no_pk, $admission->patient_no_fk, $admission->ledger_amt_sales]) }}"
                                            method="post">
                                            @csrf
                                            @php
                                                $response_action = route('idp.ipd-business-office');
                                            @endphp
                                            <button type="button"
                                                onclick="btnSaveUpdate(this,'','','','', dynamicFunc.afterSaveLoadPage,'{{ $response_action }}')"
                                                class="btn btn-sm btn-primary mb-1 mt-2">Adding House
                                                Keeping Charge</button>
                                        </form>
                                    @endif
                                </div>
                                @if (Session::get('user.ses_hospital_code') == 'EWMCH')
                                    <div class="col-md-3 text-right">
                                        <a href="{{ route('v2.ipd.ipd-approximately-print', $admission->admission_no_pk) }}"
                                            class="btn btn-sm btn-warning btn-block" target="_blank">Approximately
                                            Bill</a>
                                    </div>
                                @endif
                            @else
                                <div class="col-md-12 text-right">
                                    @if ($admission->dis_ind == 0 && $admission->dis_req_ind == 0 && Session::get('user.ses_hospital_code') != 'UNICO')
                                        <button class="btn btn-sm btn-primary mb-1 mt-2 open-modal"
                                            data-id="{{ $admission->admission_no_pk }}"
                                            data-action="{{ route('ipd.discharge-request-by-doctor', $admission->admission_no_pk) }}"
                                            data-modal="common-modal-sm" data-title="Discharge Request"
                                            title="Discharge">Discharge Request</button>
                                    @endif
                                    @if ($admission->dis_ind == 1)
                                        <a class="btn btn-sm btn-info mb-1 mt-2" type="submit"
                                            href="{{ route('report.discharge', $admission->admission_no_pk) }}"
                                            target="_blank" data-id="{{ $admission->admission_no_pk }}"
                                            id="admission_id" title="Discharge Certificate">Certificate</a>
                                    @endif
                                    @if ($admission->dis_ind != 1 && Session::get('user.ses_hospital_code') == 'JKMH')
                                        <button
                                            data-action="{{ route('ipd.ipd-update-discharge', $admission->admission_no_pk) }}"
                                            onclick="updateDischargeInd(this)" class="btn btn-sm btn-danger mb-1 mt-2"
                                            title="Discharge" rel="tab">Discharge</button>
                                    @endif

                                    @if ($admission->dis_ind == 0)
                                        <button class="btn btn-sm btn-primary mb-1 mt-2 open-modal"
                                            data-id="{{ $admission->admission_no_pk }}"
                                            data-action="{{ route('ipd.bed-transfer', $admission->admission_no_pk) }}"
                                            data-modal="common-modal-sm" data-title="Bed Transfer"
                                            title="Bed Transfer">Bed
                                            Transfer</button>

                                        <button disabled class="btn btn-sm btn-primary mb-1 mt-2">Applied House
                                            Keeping Charge</button>
                                    @endif
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-md-3">
                <div class="card">
                    <div class="card-body p-2">
                        <div class="form-row">
                             @inject('dipositAmt', 'App\Http\Controllers\IPDController')
                            @php
                                $date = isset($admission->dis_date) ? date('Y-m-d', strtotime($admission->dis_date)) : date('Y-m-d');
                                $date1 = date_create(date('Y-m-d', strtotime($admission->admission_date)));
                                $date2 = date_create($date);
                                $diff = date_diff($date1, $date2);
                                $dipositAmt=$dipositAmt->ipdDipositAmt($admission->admission_no_pk)['sum_deposit_amount'];
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
                                    <label class="col-md-6 col-form-label col-form-label-sm"
                                        for="total_bill_view">Total Bill</label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control text-right form-control-sm m-0"
                                            id="total_bill_view" name="total_bill_view"
                                            value="{{ number_format($admission->ledger_amt_sales,2) }}" placeholder="0.00"
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
                                            value="{{ number_format($admission->ledger_amt_discount,2) }}" placeholder="0.00"
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
                                            value="{{ number_format($admission->ledger_amt_payable,2) }}" placeholder="0.00"
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
                                            id="paid_view" name="paid_view" value="{{ number_format(($admission->paid_amount +  $dipositAmt),2 )}}"
                                            placeholder="0.00" style="margin-bottom: 0px !important;">
                                    </div>
                                </div>
                            </div>

                            <div class="col-md-12">
                                <div class="form-group form-row">
                                    <label class="col-md-6 col-form-label col-form-label-sm" for="due_advance_view">
                                        @if (($admission->advance_due -  $dipositAmt) >= 0)
                                            Due
                                        @else
                                            Advance
                                        @endif
                                    </label>
                                    <div class="col-md-6">
                                        <input type="text" class="form-control text-right form-control-sm m-0"
                                            id="due_advance_view" name="due_advance_view"
                                            value="{{number_format( abs(($admission->advance_due -  $dipositAmt)),2) }}" placeholder="0.00"
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
                                @if(in_array(Session::get('user.ses_hospital_code'),['UNICO','KPJ']))
                                    <a target="_blank" href="{{ route('ipd.ipd-payment-v2', $admission->admission_no_pk) }}"
                                    class="btn btn-sm btn-success btn-block mb-1 mt-2">Payment</a>
                                @else
                                    <a target="_blank" href="{{ route('ipd.ipd-payment', $admission->admission_no_pk) }}"
                                    class="btn btn-sm btn-success btn-block mb-1 mt-2">Payment</a>
                                @endif
                            </div>
                            @php
                                $hospital_code = ['GMC', 'JKMH', 'KBMH', 'AMCSH'];
                            @endphp
                            @if (Session::get('user.ses_hospital_code')!="KPJ")
                                <div class="col-md-6">

                                @if (!in_array(Session::get('user.ses_hospital_code'), $hospital_code))
                                 @if (Session::get('user.ses_hospital_code')=="UNICO")
                                        <a href="{{ route('ipd.ipd-summary-bill-print-v2', $admission->admission_no_pk) }}"
                                        class="btn btn-sm btn-success btn-block mb-1 mt-2" target="_blank">Draft Bill</a>
                                @else
                                 <a href="{{ route('v2.ipd.ipd-draft-print-new', $admission->admission_no_pk) }}"
                                        target="_blank" class="btn btn-sm btn-success btn-block mb-1 mt-2">Draft
                                        Bills</a>
                                @endif


                                @else
                                    <a href="{{ route('ipd.ipd-draft-print', $admission->admission_no_pk) }}"
                                        target="_blank" class="btn btn-sm btn-success btn-block mb-1 mt-2">Draft
                                        Bills</a>
                                @endif

                                </div>

                            @endif



                            @if (Session::get('user.ses_hospital_code')!="KPJ")
                            <div class="col-md-6">
                                <span class="btn btn-sm btn-success btn-block open-modal"
                                    data-id="{{ $admission->admission_no_pk }}"
                                    data-action="{{ route('ipd.financial-clearance', $admission->admission_no_pk) }}"
                                    data-modal="common-modal-sm" data-title="Financial Clearance"
                                    title="Financial Clearance">Finc. Clearance</span>
                            </div>
                            @endif
                            @if (Session::get('user.ses_hospital_code')!="KPJ")
                            <div class="col-md-6">
                                {{-- @if (!in_array(Session::get('user.ses_hospital_code'), $hospital_code))
                                    <a href="{{ route('v2.ipd.ipd-final-print', $admission->admission_no_pk) }}"
                                        class="btn btn-sm btn-success btn-block" target="_blank">Final Bill</a>
                                @else
                                    <a href="{{ route('ipd.ipd-final-bill-print', $admission->admission_no_pk) }}"
                                        class="btn btn-sm btn-success btn-block" target="_blank">Final Bill</a>
                                @endif --}}
                            </div>
                            @endif
                            @if ($admission->lock_ind == '')
                                <div class="col-md-6 mt-2">
                                    @if ($admission->dis_ind == 1)
                                        @if (Session::get('user.inv_auth_admin_ind') == 1)
                                            <a href="{{ route('billing.service-billing', $admission->patient_no_fk . '-' . $admission->admission_no_pk . '-' . 'ipd') }}"
                                                class="btn btn-sm btn-success btn-block" target="_blank">Service
                                                Billing</a>
                                        @endif
                                    @else
                                        @if (Session::get('user.ses_hospital_code') == "UNICO" || Session::get('user.ses_hospital_code') == "KPJ" )
                                            <a href="{{ route('uhl.billing-invoice-form', $admission->patient_no_fk . '-' . $admission->admission_no_pk . '-' . 'ipd') }}"
                                                class="btn btn-sm btn-success btn-block" target="_blank">Service Billing</a>
                                        @else
                                            <a href="{{ route('billing.service-billing', $admission->patient_no_fk . '-' . $admission->admission_no_pk . '-' . 'ipd') }}"
                                            class="btn btn-sm btn-success btn-block" target="_blank">Service Billing</a>
                                        @endif
                                    @endif
                                </div>
                            @endif
                            @php
                                $param = $admission->patient_no_fk . '_' . $admission->mobile1 . '_' . $admission->patient_name . '_' . $admission->primary_doctor_name . '_' . abs($admission->paid_amount) . '_' . $admission->ledger_amt_sales;
                            @endphp
                            <div class="col-md-6 mt-2">
                                {{-- <button type="button" data-action="{{ route('ipd-sms-modal', $param) }}"
                                data-id="" class="btn btn-sm btn-success btn-block open-modal"
                                data-modal="common-modal-sm" data-title="IPD SMS"><i class="fa fa-sms"></i>&nbsp;SMS</button> --}}
                                <a href="{{ route('ipd.ipd-final-bill-print-v2', $admission->admission_no_pk) }}"
                                    class="btn btn-sm btn-success btn-block" target="_blank">Details Bill</a>
                            </div>
                            {{-- @if (Session::get('user.ses_hospital_code')=="UNICO")
                                <div class="col-md-6 mt-2"></div>
                                <div class="col-md-6 mt-2">
                                        <a href="{{ route('ipd.ipd-summary-bill-print', $admission->admission_no_pk) }}"
                                        class="btn btn-sm btn-success btn-block" target="_blank">Summary Bill</a>
                                </div>
                            @endif                              --}}

                                <div class="col-md-6 mt-2"></div>
                                <div class="col-md-6 mt-2">
                                        <a href="{{ route('ipd.ipd-summary-bill-print', $admission->admission_no_pk) }}"
                                        class="btn btn-sm btn-success btn-block" target="_blank">Summary Bill</a>
                                </div>


                        </div>
                    </div>
                </div>
            </div>


            {{-- new ipd look start --}}


            {{-- new ipd look end --}}
        </div>
    @endforeach
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


<script>
    function updateDischargeInd(element) {
        var action = $(element).attr("data-action");
        if (confirm("Are You Sure?")) {
            $.ajax({
                async: true,
                url: action,
                type: "GET",
                beforeSend: function() {

                    blockUI();
                },
                success: function(data) {
                    if (data.title == 'Success') {
                        $('.common-modal-notify').modal('show');
                        $('.common-modal-notify .modal-body').html(
                            "<i class='fas fa-stroopwafel fa-spin'></i>");
                        $('.common-modal-notify .modal-title').html(data.title);
                        $('.common-modal-notify .modal-body').html(data.msg);
                    } else {
                        $('.common-modal-notify-error').modal('show');
                        $('.common-modal-notify-error .modal-title').html(data.title);
                        $('.common-modal-notify-error .modal-body').html(data.msg);
                    }
                    $.ajax({
                        async: false,
                        url: "{{ route('idp.ipd-business-office') }}",
                        type: "get",
                        beforeSend: function() {
                            //blockUI();
                            //$('.data-table').DataTable().destroy();
                        },
                        success: function(data) {
                            $('#page-content').html(data);
                        },
                        complete: function(data) {
                            //$.unblockUI();
                        }
                    });

                },
                complete: function() {


                },
                error: function(data) {
                    var errors = jQuery.parseJSON(data.responseText).errors;
                    error_messages = "";
                    for (messages in errors) {
                        var field_name = $("#" + messages).siblings("label").html();
                        error_messages += "<div class='alert alert-danger' role='alert'>" + errors[
                            messages] + "</div>";
                    }

                    $('.common-modal-notify-error').modal('show');
                    $('.common-modal-notify-error .modal-title').html("Validation Error");
                    $('.common-modal-notify-error .modal-body').html(error_messages);

                    $.unblockUI();
                }
            }).done(function() {
                $.unblockUI();

                if (callback != "")
                    callback(callbackparam);
            });
        }
    }
</script>
