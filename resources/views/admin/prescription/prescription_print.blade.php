@php
$company_details = $lead_unit = \App\Models\Company::where('status', 1)->first();
$imageURL = isset($company_details->logo) ? '/images/uploads/hospital_images/' . $company_details->logo : 'images/login_page_logo.png';
$backgroundColor = isset($company_details->logo_background_color) ? $company_details->logo_background_color : 'white';
$width = isset($company_details->width_logo) ? $company_details->width_logo : '100 px';

@endphp



<div class="wrapper">
    <div class="row">
        <div class="col-md-12 border-bottom">
            <table style="width: 100%;" class="signature">
                <tr>
                    <td style="width: 10%;" >
                        <img class="hospital-logo" style="background-color:{{ $backgroundColor }};width:100px"
                            src="{{ asset($imageURL) }}"
                            alt="">
                    </td>
                    <td style="text-align:center;">
                        <span style="font-size: 15px;"> <strong>
                                {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                            </strong></span> <br>
                        Address: <span>
                            {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                        Phone No: <span>
                            {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                    </td>
                </tr>
            </table>
        </div>
    </div>
    <section id="prescription">
        <div class="container">

            <table style="width: 100%">
                <tr>
                    <td colspan="2" class="text-left"><img src="data:image/png;base64, {{ $patient_barcode }} " />
                    </td>
                    <td colspan="2" class="text-left"><img
                            src="data:image/png;base64, {{ $prescription_barcode }} " /></td>
                </tr>
                <tr>
                    <td width="10%" class="text-left"><strong>PID</strong></td>
                    <td width="55%" class="text-left">: {{ $prescription_mst->patient_code }}</td>
                    <td width="15%" class="text-left"><strong>Prescription ID</strong></td>
                    <td class="text-left">: {{ $prescription_mst->prescription_code }}</td>
                </tr>
                <tr>
                    <td><strong>Name</strong></td>
                    <td>: {{ $prescription_mst->patient_name }}</td>
                    <td><strong>Visit Date & Time</strong></td>
                    <td>: {{ date('d/m/Y h:i a', strtotime($prescription_mst->prescription_date)) }}</td>
                </tr>
                <tr>
                    <td><strong>Age</strong></td>
                    <td>: {{ $prescription_mst->age }}</td>
                    <td><strong>Gender</strong></td>
                    <td>: {{ $prescription_mst->gender_txt }}</td>
                </tr>
            </table>

            <table style="width: 100%; height: 300px; border-top:1px solid;" class="mt-2">
                <tr>
                    <td width="40%" valign="top" style="border-right: 1px solid; padding: 10px;">
                        <div class="mb-2">
                            @if (!empty($cc_inv_adv_arr))
                                @foreach ($cc_inv_adv_arr as $id => $cc_inv_adv)
                                    <u><strong>{{ $cc_inv_adv }}</strong></u>
                                    @if (isset($cc_inv_adv_item_arr[$id]))
                                        <ul class="ml-4">
                                            @foreach ($cc_inv_adv_item_arr[$id] as $cc_inv_adv_item)
                                                <li>{{ $cc_inv_adv_item }}</li>
                                            @endforeach
                                        </ul>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                    </td>
                    <td class="text-left" valign="top" style="padding: 10px;">
                        <h5>R<sub>x</sub></h5>
                        <div class="mb-2 mt-3">
                            @if (!empty($cc_electro_arr))
                                @foreach ($cc_electro_arr as $id => $electro_row)
                                    <u><strong>{{ $electro_row }}</strong></u>
                                    @if (isset($cc_electro_item_arr[$id]))
                                        @php $i=1; @endphp
                                        <ol class="ml-4">
                                            @foreach ($cc_electro_item_arr[$id] as $electro_row_item)
                                                @php
                                                    $electro_item = explode('_', $electro_row_item);
                                                @endphp
                                                <li>
                                                    <div>{{ $electro_item[0] }}</div>
                                                    <small>{{ isset($electro_item[1]) ? $electro_item[1] : '' }}
                                                        {{ isset($electro_item[2]) ? $electro_item[2] : '' }}
                                                        {{ isset($electro_item[3]) ? $electro_item[3] . ' Unit/Intensity' : '' }}</small>
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                @endforeach
                            @endif
                        </div>

                        <div class="mb-2">
                            @if (!empty($cc_therapeutic_arr))
                                @foreach ($cc_therapeutic_arr as $id => $therapeutic_row)
                                    <u><strong>{{ $therapeutic_row }}</strong></u>
                                    @if (isset($cc_therapeutic_item_arr[$id]))
                                        <ol class="ml-4">
                                            @foreach ($cc_therapeutic_item_arr[$id] as $therapeutic_row_item)
                                                @php
                                                    $therapeutic_item = explode('_', $therapeutic_row_item);
                                                @endphp
                                                <li>
                                                    <div>{{ $therapeutic_item[0] }}</div>
                                                    <small>{{ isset($therapeutic_item[1]) ? $therapeutic_item[1] : '' }}
                                                        {{ isset($therapeutic_item[2]) ? $therapeutic_item[2] : '' }}
                                                        {{ isset($therapeutic_item[3]) ? $therapeutic_item[3] . ' Session' : '' }}</small>
                                                </li>
                                            @endforeach
                                        </ol>
                                    @endif
                                @endforeach
                            @endif
                        </div>
                        <div class="mb-2">
                            @if (!empty($prescription_med))
                                <div class="mt-10">
                                    <u><strong>Medicine</strong></u>
                                    <ol class="ml-4">
                                        @foreach ($prescription_med as $med_row_item)
                                            <li>
                                                {{ $med_row_item->brand_name }}
                                                <div><small>{{ $med_row_item->dosage }} [
                                                        {{ $med_row_item->duration }}
                                                        {{ $med_row_item->duration_mu }} ]


                                                        {{-- Qty
                                                        {{ $med_row_item->item_qty }} --}}


                                                    </small></div>
                                            </li>
                                        @endforeach
                                    </ol>
                                </div>
                            @endif
                        </div>
                    </td>
                </tr>
            </table>
        </div>
        <div class="modal-footer mt-2">
            <a href="{{ route('prescription-print-pdf', $prescription_mst->prescription_no_pk) }}"
                class="btn btn-warning btn-md" target="_blank" data-id="{{ $prescription_mst->prescription_no_pk }}"
                title="Print Prescription"><i class="fas fa-print"></i> Print</a>
            <button class="btn btn-delete btn-md" data-dismiss="modal"> Close </button>
        </div>
    </section>
</div>
