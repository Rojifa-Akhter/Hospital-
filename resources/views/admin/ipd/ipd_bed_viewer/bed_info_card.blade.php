@php
    $ipds_bed = (isset($data) && (!empty($data))) ? $data : [];

    $bed_name = ($ipds_bed) ? $ipds_bed->bed_name : '';
    $ward_name = ($ipds_bed) ? $ipds_bed->ward_name : '';
    $serviceunit_name = ($ipds_bed) ? $ipds_bed->serviceunit_name : '';
    $bed_status = ($ipds_bed) ? $ipds_bed->bed_status : '';

    $admission_fee_item_no_fk = ($ipds_bed) ? $ipds_bed->admission_fee_item_no_fk : '';
    $bed_charge_item_no_fk = ($ipds_bed) ? $ipds_bed->bed_charge_item_no_fk : '';
    $others_charge_item_no_fk = ($ipds_bed) ? $ipds_bed->others_charge_item_no_fk : '';
    $minimum_deposit_amount = ($ipds_bed) ? $ipds_bed->minimum_deposit_amount : '';
    $service_charge_item_no_fk = ($ipds_bed) ? $ipds_bed->service_charge_item_no_fk : '';
@endphp
<style>
    @media print
    {
        .noprint {display:none;}
    }
</style>
<section id="patient_card">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="row">
                        <div class="col-md-12">
                            <div class="hosital_logo m-auto">
                                <img class="w-100" src="{{ asset('images/uploads/hospital_images/'.$po_hospital_details->logo) }}" alt="">
                            </div>

                            <div class="hospital_info" >
                                <h5> {{isset($po_hospital_details->hospital_name )? $po_hospital_details->hospital_name : ""}} </h5>
                                <span>  {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : ""}}</span>
								<h6>Bed Information</h6>
                            </div>
                        </div>
                    </div>
                    <hr>
                    <div class="card_info text-left">
                        <div class="patient_info">
                            <div class="row">
                                <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                    <table class="">

                                        <tr>
                                            <th class="text-left ">Bed Name</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left "> {{ $bed_name }} </th>
                                        </tr>

                                        <tr>
                                            <th class="text-left ">Ward Name</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left ">{{ $ward_name }}</th>
                                        </tr>

                                        <tr>
                                            <th class="text-left ">Department Name</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left ">{{ $serviceunit_name }}</th>
                                        </tr>

                                        <tr>
                                            <th class="text-left ">Bed Status</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left ">
                                                @if ($data->bed_status == 1)
                                                    <span class="badge badge-info p-2">Available</span>
                                                @elseif($data->bed_status == 2)
                                                    <span class="badge badge-secondary p-2">Occupied</span>
                                                @elseif($data->bed_status == 3)
                                                    <span class="badge badge-warning p-2">Not Ready</span>
                                                @endif
                                            </th>
                                        </tr>
                                    </table>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="patient_img m-auto">
                                            <img class="rounded" style="width: 100% !important;" src="{{ asset('images/ipd.png') }}">

                                    </div>
                                </div>
                            </div>

                        </div>

                        <hr />


                        <div class="bed_info">
                            <div class="row">
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <table class="">
                                        <tr>
                                            <th class="text-left ">Admission Fee</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left "> {{ $admission_fee_item_no_fk}}</th>
                                        </tr>
                                        <tr>
                                            <th class="text-left ">Service Charged</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left "> {{ $service_charge_item_no_fk }} </th>

                                        </tr>
                                        <tr>
                                            <th class="text-left ">Other Charged</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left "> {{ $others_charge_item_no_fk }} </th>

                                        </tr>
                                    </table>
                                </div>
                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">
                                    <table class="">
                                        <tr>

                                            {{--                                            <th class="text-left "> {{ $doctor_salutation }} {{ $doctor_name }}</th>--}}
                                            <th class="text-left ">Bed Charge</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left "> {{ $bed_charge_item_no_fk }}</th>

                                        </tr>
                                        <tr>
                                            <th class="text-left ">Minimum Deposit</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left "> {{ $minimum_deposit_amount }} </th>

                                        </tr>
                                    </table>
                                </div>
                            </div>

                        </div>
                        <hr>



                        <div class="card">
                            <div class="card-header">Bed Occupied Details</div>
                            <div class="card-body">
                                @include('admin.ipd.ipd_bed_viewer.admission_bed_details')

                            </div>
                        </div>

{{--                        <button class="btn btn-md btn-success noprint" onclick="window.print();return false;"><i class="fas fa-print"></i> Print</button>--}}
                        <button class="btn btn-md btn-danger mt-2" data-dismiss="modal" title="Click here to Clear form data">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

