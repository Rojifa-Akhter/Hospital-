
<style>
    @media print {
        .noprint {
            display: none;
        }
    }

</style>
@php
$ref_card = isset($data[0]) && !empty($data[0]) ? $data[0] : [];

$phone_mobile = $ref_card ? $ref_card->phone_mobile : 0;
$agent_name = $ref_card ? $ref_card->agent_name : '';
$person_code = $ref_card ? $ref_card->person_code : '';
$mpo_name = $ref_card ? $ref_card->mpo_name : '';
$agent_institute_name = $ref_card ? $ref_card->agent_institute_name : '';
$area_code = $ref_card ? $ref_card->area_code : '';
$pr_addr1 = $ref_card ? $ref_card->pr_addr1 : '';
@endphp

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
                                <img class="hospital-logo" style="width:100%; border:0px;"
                                    src="{{ asset($imageURL) }}" alt="">
                            </div>
                            <div class="hospital_info">

                                <h5>{{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                </h5>
                                <span>
                                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                                    <h6> <strong> Referral ID Card </strong></h6>
                                </span>
                            </div>
                        </div>
                    </div>
                    <div class="card_info text-left">
                        <div id="appointment_card">
                            <div class="patient_info">
                                <div class="row">
                                    <div class="col-xs-12 col-sm-12 col-md-12 col-lg-12 col-xl-12">
                                        <table class="">
                                            <tr>
                                                <th class="text-left ">Name</th>
                                                <th class="text-left px-3">:</th>
                                                <th class="text-left "> {{ ucwords(strtolower($mpo_name)) }}</th>
                                            </tr>

                                            <tr>
                                                <th class="text-left ">PC Code</th>
                                                <th class="text-left px-3">:</th>
                                                <th class="text-left ">{{ $person_code }}</th>
                                            </tr>

                                            <tr>
                                                <th class="text-left ">Phone</th>
                                                <th class="text-left px-3">:</th>
                                                <th class="text-left ">{{ '+880'.$phone_mobile }}</th>
                                            </tr>
                                            <tr>
                                                <th class="text-left ">Address</th>
                                                <th class="text-left px-3">:</th>
                                                <th class="text-left "> {{ $pr_addr1 }}</th>
                                            </tr>
                                            <tr>
                                                <th class="text-left ">Area</th>
                                                <th class="text-left px-3">:</th>
                                                <th class="text-left "> {{ $area_code }}</th>
                                            </tr>
                                            <tr>
                                                <th class="text-left ">Pharmacy / Institude Name</th>
                                                <th class="text-left px-3">:</th>
                                                <th class="text-left "> {{ $agent_institute_name }}</th>
                                            </tr>
                                        </table>
                                    </div>
                                </div>

                            </div>

                        </div>
                        <hr />
                        <a href="{{ route('referral_agent_show', $id) }}"
                            class="btn btn-primary btn-md cursor-pointer" target="_blank"
                            data-id="{{ $id}}" id="patient_card" title="Print Referral Card"><i
                                class="fa fa-file-print"></i>Print</a>


                        <a href="{{ route('referral-list') }}" data-dismiss="modal" class="btn btn-info btn-md"
                            rel="tab" title="Click here to go to Referral List">Referral List</a>
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
