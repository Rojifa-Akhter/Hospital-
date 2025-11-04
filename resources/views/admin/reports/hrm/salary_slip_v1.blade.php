<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Pay Slip</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <style>
        @page {
            margin: .2cm .2cm;
            width: 100%;
            height: 100%
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        header {
            position: fixed;
            top: 0;
            height: 2cm;
            border-bottom: 1px solid;
            padding: 0 1cm;
        }

        body {
            margin-top: .5cm;
            margin-left: .3cm;
            margin-right: .3cm;
            margin-bottom: .5cm;
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 11px;
        }

        footer {
            position: fixed;
            bottom: 0cm;
            left: 0cm;
            right: 0cm;
            height: .7cm;
            text-align: center;
            padding: 0 1cm;
            border-top: 1px solid;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
        }

        tfoot tr td {
            font-weight: bold;
        }

        .page-break {
            page-break-after: always;
        }

        .mt-5 {
            margin-top: 5px;
        }

        .mt-10 {
            margin-top: 10px;
        }

        .mt-20 {
            margin-top: 20px;
        }

        .mb-0 {
            margin-bottom: 0;
        }

        .mb-5 {
            margin-bottom: 15px;
        }

        .pb-0 {
            padding-bottom: 0;
        }
    </style>
</head>

<body>
    <main class="mt-5" style="">
        <div class="wrapper">
            <section id="lp-items">
                <div class="container" style="">
                    @if (isset($data))
                        <table style=" width: 100%;">
                            <tr>
                                <td>
                                    <div style="margin:0 auto;">
                                        <table style="width: 100%; border-collapse:collapse;" cellpadding="1"
                                            cellspacing="0" border="1">
                                            <tr class="table-tr">
                                                <td colspan="4">
                                                    <table class="" style="width:  100%">
                                                        <tr>
                                                            <td style="width:40px">
                                                                @if ($po_hospital_details->logo != '')
                                                                    <img class="hospital-logo"
                                                                        src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                                                        width="60" alt="">
                                                                @endif
                                                            </td>
                                                            <td style="text-align:center;">
                                                                <span style="font-size: 15px"> <strong>
                                                                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                                                    </strong></span> <br>
                                                                <span style="font-size: 8px"> <strong>
                                                                        {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}
                                                                    </strong></span><br>
                                                                <span> Pay slip for the month of {{isset($outputDate) ?  $outputDate : ""}}<br>
                                                                </span>

                                                            </td>
                                                            <td style=" text-align:right; width:60px">
                                                                {{-- <img src="data:image/png;base64, {{ $barcode_no }} "
                                                                    style="width:60px" /> --}}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr class="table-tr">
                                                <td colspan="2">
                                                    <table style="width:100%">
                                                        <tr class="table-tr">
                                                            <td style="width: 100px; font-weight:bold">Name</td>
                                                            <td style="font-weight:bold"> {{ $data->full_name }}</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td> Employee ID</td>
                                                            <td> {{ $data->card_no }}</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td> Designation</td>
                                                            <td> {{ $data->designation_name }}</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td> Joining Date: </td>
                                                            <td>
                                                                {{ isset($data->join_date) ? date('d/m/Y', strtotime($data->join_date)) : '' }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td> Department</td>
                                                            <td>{{ $data->servicedept_name }}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td colspan="2" style="vertical-align:top;">
                                                    <table style="width:  100%">
                                                        <tr class="table-tr">
                                                            <td style="width: 100px"> GMS Payable</td>
                                                            <td>{{ isset($data->gms_payable) ? $data->gms_payable : 0 }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Bank Name</td>
                                                            <td>{{ isset($data->bank_name) ? $data->bank_name : '' }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td> Bank A/C no.</td>
                                                            <td>{{ $data->bank_acc_no }}</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td> Payable Days</td>
                                                            <td>{{ $data->designation_name }}</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr class="table-tr">
                                                <td style="font-weight:bold">
                                                    Earning
                                                </td>
                                                <td style="font-weight:bold; text-align:center">
                                                    Amount(TK)
                                                </td>
                                                <td style="font-weight:bold">
                                                    Deduction
                                                </td>
                                                <td style="font-weight:bold; text-align:center">
                                                    Amount(TK)
                                                </td>
                                            </tr>
                                            <tr class="table-tr">
                                                <td style="width:30%">
                                                    <table style="width: 100%; vertical-align:top;">
                                                        <tr class="table-tr">
                                                            <td>Basic Salary</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>House Rent</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Medical Allowance</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Transport Allowance</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Revision</td>
                                                        </tr>
                                                        {{-- <tr class="table-tr">
                                                            <td>Mobile Allowance</td>
                                                        </tr> --}}
                                                        <tr class="table-tr">
                                                            <td>Arrear Salary</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>OT</td>
                                                        </tr>
                                                        {{-- <tr class="table-tr">
                                                            <td>Bonus</td>
                                                        </tr> --}}
                                                        <tr class="table-tr">
                                                            <td>Others</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                @php
                                                    $gross = $data->basic_salary + $data->house_rent + $data->medical_allowance + $data->medical_allowance + $data->add_revision + $data->add_arrear + $data->add_ot;
                                                    $deduction = $data->ded_ait + $data->ded_food_bill + $data->ded_pf + $data->ded_adv + $data->ded_med_bill + $data->ded_salary + $data->ded_lwp + $data->ded_emb + $data->ded_others;
                                                @endphp
                                                <td style="width:20%">
                                                    <table style="width: 100%; vertical-align:top">
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->basic_salary) ? $data->basic_salary : 0 }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->house_rent) ? $data->house_rent : 0 }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->medical_allowance) ? $data->medical_allowance : 0 }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->medical_allowance) ? $data->medical_allowance : 0 }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->add_revision) ? $data->add_revision : 0 }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->add_arrear) ? $data->add_arrear : 0 }}
                                                            </td>
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->add_ot) ? $data->add_ot : 0 }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                0
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="width:30%; vertical-align:top;">
                                                    <table style="width:  100%">
                                                        <tr class="table-tr">
                                                            <td> Income Tax </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Food Deduction</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Provident Fund</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Advance</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Medical Bill</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Salary Deduction</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Leave without pay</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Extra Mobile bill</td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td>Other Deduction</td>
                                                        </tr>
                                                    </table>
                                                </td>
                                                <td style="width:20%; vertical-align:top;">
                                                    <table style="width: 100%;">
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->ded_ait) ? $data->ded_ait : 0 }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->ded_food_bill) ? $data->ded_food_bill : 0 }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->ded_pf) ? $data->ded_pf : 0 }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->ded_adv) ? $data->ded_adv : 0 }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->ded_med_bill) ? $data->ded_med_bill : 0 }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->ded_salary) ? $data->ded_salary : 0 }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->ded_lwp) ? $data->ded_lwp : 0 }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->ded_emb) ? $data->ded_emb : 0 }}
                                                            </td>
                                                        </tr>
                                                        <tr class="table-tr">
                                                            <td style="text-align: right;">
                                                                {{ isset($data->ded_others) ? $data->ded_others : 0 }}
                                                            </td>
                                                        </tr>
                                                    </table>
                                                </td>
                                            </tr>
                                            <tr class="table-tr">
                                                <td style="font-weight:bold">
                                                    Gross
                                                </td>
                                                <td style="font-weight:bold; text-align:right">
                                                    {{ isset($gross) ? number_format($gross, 2) : '' }}
                                                </td>
                                                <td style="font-weight:bold">
                                                    Total Deduction
                                                </td>
                                                <td style="font-weight:bold; text-align:right">
                                                    {{ isset($deduction) ? number_format(round($deduction), 2) : '' }}
                                                </td>
                                            </tr>
                            </tr>
                            <tr class="table-tr">
                                <td style="font-weight:bold">
                                    Refund
                                </td>
                                <td style="font-weight:bold; text-align:right">
                                </td>
                                <td style="font-weight:bold">
                                    Net Pay
                                </td>
                                <td style="font-weight:bold; text-align:right">
                                    {{ isset($salary) ? number_format(round($salary), 2) : '' }}
                                </td>
                            </tr>
                            <tr class="table-tr">
                                <td colspan="2">
                                </td>
                                <td>
                                    Paid through Bank A/C
                                </td>
                                <td style="font-weight:bold; text-align:right">
                                </td>
                            </tr>
                            <tr class="table-tr">
                                <td colspan="4" style="padding: 5px; font-weight:bold">
                                    @php
                                        $locale = 'en_US';
                                        $fmt = numfmt_create($locale, NumberFormatter::SPELLOUT);
                                        $in_words = numfmt_format($fmt, $salary);
                                    @endphp
                                    <p style="margin-bottom:20px"><b>In Word :</b> {{ ucwords($in_words) }} Taka Only
                                    </p>
                                    <p style="margin-bottom:20px">Remarks: Income tax deduction of {{isset($outputDate) ?  $outputDate : ""}} Tk.=  {{ isset($data->ded_ait) ? $data->ded_ait : 0 }}</p>
                                    <p style="margin-bottom:20px">Note: Figures showing in this statement will be
                                        considered correct if there is no query within 5 days.</p>
                                    <p style="text-align:right; margin-bottom:20px">
                                        <span>Issued by</span><br>
                                        <span>Finance & Accounts Department</span><br>
                                        <span>Unico Hospitals PLC</span><br>
                                    </p>
                                    <p style="text-align:center">This is computer generated pay slip, doesn't require
                                        any signature</p>
                                </td>
                            </tr>
                        </table>
                </div>
                </td>
                </tr>
                </table>



                @endif
        </div>
        </section>
        </div>
    </main>
