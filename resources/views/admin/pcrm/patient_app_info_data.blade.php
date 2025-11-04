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
                                <h6>Patient Appointment Information</h6>
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
                                            <th class="text-left " style="width: 102px;">Patient Name</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left "> {{$patient_info_data[0]->patient_name}} </th>
                                        </tr>

                                        <tr>
                                            <th class="text-left ">Mobile Number</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left ">  {{$patient_info_data[0]->mobile_no}} </th>
                                        </tr>

                                        <tr>
                                            <th class="text-left ">
                                                @if($patient_info_data[0]->sms_ind == 1)
                                                   Sms Text
                                                @elseif($patient_info_data[0]->call_ind == 1)
                                                    Call Text
                                                @elseif($patient_info_data[0]->email_ind == 1)
                                                    Email Text
                                                @endif
                                            </th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left ">
                                                @if($patient_info_data[0]->sms_ind == 1)
                                                    {{$patient_info_data[0]->sms_text}}
                                                @elseif($patient_info_data[0]->call_ind == 1)
                                                    {{$patient_info_data[0]->note_text}}
                                                @elseif($patient_info_data[0]->email_ind == 1)
                                                    {{$patient_info_data[0]->email_text}}
                                                @endif

                                            </th>
                                        </tr>

                                        <tr>
                                            <th class="text-left ">Tracking Time</th>
                                            <th class="text-left px-3">:</th>
                                            <th class="text-left ">  {{date('d/m/Y H:i',strtotime($patient_info_data[0]->traking_date))}} </th>
                                        </tr>


                                    </table>
                                </div>
                                <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                    <div class="patient_img m-auto">
                                        <img class="rounded" style="width: 100% !important;" src="{{ asset('images/patient.png') }}">

                                    </div>
                                </div>
                            </div>

                        </div>

                        <hr />


{{--                        <div class="bed_info">--}}
{{--                            <div class="row">--}}
{{--                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">--}}
{{--                                    <table class="">--}}
{{--                                        <tr>--}}
{{--                                            <th class="text-left ">Admission Fee</th>--}}
{{--                                            <th class="text-left px-3">:</th>--}}
{{--                                            <th class="text-left "> {{ $admission_fee_item_no_fk}}</th>--}}
{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <th class="text-left ">Service Charged</th>--}}
{{--                                            <th class="text-left px-3">:</th>--}}
{{--                                            <th class="text-left "> {{ $service_charge_item_no_fk }} </th>--}}

{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <th class="text-left ">Other Charged</th>--}}
{{--                                            <th class="text-left px-3">:</th>--}}
{{--                                            <th class="text-left "> {{ $others_charge_item_no_fk }} </th>--}}

{{--                                        </tr>--}}
{{--                                    </table>--}}
{{--                                </div>--}}
{{--                                <div class="col-xs-6 col-sm-6 col-md-6 col-lg-6 col-xl-6">--}}
{{--                                    <table class="">--}}
{{--                                        <tr>--}}

{{--                                            --}}{{--                                            <th class="text-left "> {{ $doctor_salutation }} {{ $doctor_name }}</th>--}}
{{--                                            <th class="text-left ">Bed Charge</th>--}}
{{--                                            <th class="text-left px-3">:</th>--}}
{{--                                            <th class="text-left "> {{ $bed_charge_item_no_fk }}</th>--}}

{{--                                        </tr>--}}
{{--                                        <tr>--}}
{{--                                            <th class="text-left ">Minimum Deposit</th>--}}
{{--                                            <th class="text-left px-3">:</th>--}}
{{--                                            <th class="text-left "> {{ $minimum_deposit_amount }} </th>--}}

{{--                                        </tr>--}}
{{--                                    </table>--}}
{{--                                </div>--}}
{{--                            </div>--}}

{{--                        </div>--}}
{{--                        <hr>--}}



{{--                        <div class="card">--}}
{{--                            <div class="card-header">Bed Occupied Details</div>--}}
{{--                            <div class="card-body">--}}
{{--                                @include('admin.ipd.ipd_bed_viewer.admission_bed_details')--}}

{{--                            </div>--}}
{{--                        </div>--}}

                        {{--                        <button class="btn btn-md btn-success noprint" onclick="window.print();return false;"><i class="fas fa-print"></i> Print</button>--}}
                        <button class="btn btn-md btn-danger mt-2" data-dismiss="modal" title="Click here to Clear form data">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

