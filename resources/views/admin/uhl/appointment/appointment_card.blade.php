@php
    $patient_no_pk = $pat_card->patient_no_pk;
    $patient_salutation = $pat_card->salutation;
    $patient_name = $pat_card->patient_name;
    $patient_code = $pat_card->patient_code;
    $patient_blood_group = $pat_card->blood_group != 0 ? $pat_card->blood_group : '';
    $patient_dob = isset($pat_card->patient_dob) ? $pat_card->patient_dob : '';
    $patient_gender = $pat_card->gender_txt;
    $patient_photo = $pat_card->patient_photo;
    $doc_name = $pat_card->full_name;
    $slot_sl = $pat_card->slot_sl;

@endphp
<style>
    @media print {
        .noprint {
            display: none;
        }
    }
</style>
<section id="patient_card">
    <div class="row">
        <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
            <div class="row">
                <div class="col-md-12">
                    <div class="row mb-3">
                        @php
                            $imageURL = isset($po_hospital_details->logo) ? '/images/uploads/hospital_images/' . $po_hospital_details->logo : '/images/login_page_logo.png';
                            $backgroundColor = isset($po_hospital_details->logo_background_color) ? $po_hospital_details->logo_background_color : 'white';

                        @endphp
                        <div class="col-md-12">
                            <div class="hosital_logo m-auto"
                                style="border-radius: 0px;background-color: {{ $backgroundColor }};height:100%; display: flex;align-items: center;margin-right: 10px!important;">
                                <img class="hospital-logo" style="width:100%; border:0px;" src="{{ asset($imageURL) }}"
                                    alt="">
                            </div>
                            <div class="hospital_info">

                                <h5>{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                </h5>
                                <span>
                                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                                    <h6> <strong> Appointment Card </strong></h6>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card_info text-left">
                        <div id="appointment_card">
                            <div class="patient_info">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-8 col-md-8 col-lg-8 col-xl-8">
                                        <table class="">
                                            <tr>
                                                <th class="text-left ">Name</th>
                                                <th class="text-left px-3">:</th>
                                                <th class="text-left "> {{ $patient_salutation }}
                                                    {{ $patient_name }}</th>
                                            </tr>

                                            <tr>
                                                <th class="text-left ">UHID</th>
                                                <th class="text-left px-3">:</th>
                                                <th class="text-left ">{{ $patient_code }}</th>
                                            </tr>

                                            {{-- <tr>
                                                <th class="text-left ">Blood Group</th>
                                                <th class="text-left px-3">:</th>
                                                <th class="text-left ">{{ $patient_blood_group }}</th>
                                            </tr> --}}

                                            <tr>
                                                <th class="text-left ">DOB</th>
                                                <th class="text-left px-3">:</th>
                                                <th class="text-left ">
                                                    {{ $patient_dob != '' ? date('d-M-Y', strtotime($patient_dob)) : '' }}
                                                </th>
                                            </tr>

                                            <tr>
                                                <th class="text-left ">Gender</th>
                                                <th class="text-left px-3">:</th>
                                                <th class="text-left ">{{ $patient_gender }}</th>
                                            </tr>
                                            <tr>
                                                <th class="text-left ">Doctor Name</th>
                                                <th class="text-left px-3">:</th>
                                                <th class="text-left ">{{ $doc_name }}</th>
                                            </tr>
                                            {{-- <tr>
                                                <th class="text-left ">SL No</th>
                                                <th class="text-left px-3">:</th>
                                                <th class="text-left ">{{ $slot_sl }}</th>
                                            </tr> --}}
                                        </table>
                                    </div>
                                    <div class="col-xs-12 col-sm-4 col-md-4 col-lg-4 col-xl-4">
                                        <div class="patient_img m-auto">
                                            @if ($patient_photo != '')
                                                <img class="rounded"
                                                    src="{{ asset('images/uploads/patient_images/thumb/' . $patient_photo) }}">
                                            @else
                                                @if ($patient_gender == 'Male')
                                                    <img class="rounded w-100"
                                                        src="{{ asset('images/pt-patient.png') }}">
                                                @else
                                                    <img class="rounded w-100" src="{{ asset('images/female.jpg') }}">
                                                @endif
                                            @endif
                                        </div>
                                    </div>
                                </div>

                            </div>

                            <div class="card_footer">
                                <div class="row align-items-center py-2">
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-left">
                                        <div class="foot_time">
                                            <strong class="">Appointment Date : <?php echo date('d/m/Y', strtotime($pat_card->appoint_date)); ?></strong>
                                        </div>
                                    </div>
                                    <div class="col-xs-12 col-sm-6 col-md-6 col-lg-6 col-xl-6 text-right">
                                        <div class="foot_bar_code">
                                            <img class="w-100" src="{{ asset('images/barcode.gif') }}" alt="">
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                        <hr />

                        {{-- <button class="btn btn-outline-primary btn-sm bg-none cursor-pointer" target="_blank" data-action="{{ route('patient-registration-print',$patient_no_pk) }}" data-title="Patient card" title="Patient card" data-modal="common-modal-sm"><i class="fa fa-pdf"></i>Print</button> --}}

                        <a href="{{ route('patient-appointment-print', $pat_card->appoint_no_pk) }}"
                            class="btn btn-primary btn-md cursor-pointer" target="_blank"
                            data-id="{{ $pat_card->appoint_no_pk }}" id="patient_card" title="Print Patient Card"><i
                                class="fa fa-file-print"></i>Print</a>

                        @if (isset($invoice_no))
                            <a href='{{ route('bill-invoice-print-A5', $invoice_no) }}' target="_blank"
                                Class="btn btn-primary btn-md cursor-pointer" title="Print">Invoice Print</a>
                        @endif

                        <a href="{{ route('registration.index') }}" data-dismiss="modal" class="btn btn-info btn-md"
                            rel="tab" title="Click here to go to Patient List">Patient List</a>
                        <button class="btn btn-md btn-danger" data-dismiss="modal"
                            title="Click here to Clear form data">Close</button>
                    </div>
                </div>
            </div>
        </div>
    </div>
</section>

<script type="text/javascript">
    function printDiv(divName) {
        var printContents = document.getElementById(divName).innerHTML;
        var originalContents = document.body.innerHTML;

        document.body.innerHTML = printContents;

        window.print();

        document.body.innerHTML = originalContents;
    }
</script>
