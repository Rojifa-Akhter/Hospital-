<!DOCTYPE html>
<html>

<head>
    <meta charset="utf-8">
    <meta http-equiv="Content-Type" content="text/html; charset=utf-8" />
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <title>Doctor Share Report</title>
    <meta content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no" name="viewport">
    <link rel="stylesheet" href="" />
    <!-- custom style -->
    <style>
        @page {
            /* padding-bottom: 100px; */
        }

        @font-face {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-weight: normal;
            font-size: 10px;
            font-style: normal;
            font-variant: normal;
            src: url("font url");
        }

        body {
            font-family: 'IBM Plex Sans,Helvetica,Arial,sans-serif';
            font-size: 12px;
        }

        footer {
            bottom: 0;
            left: 0cm;
            right: 0cm;
        }

        .signature_ {
            position: fixed;
            bottom: 1.6cm;
            left: .8cm;
            right: .8cm;
            width: 100%;
        }

        .tr_border td,
        .tr_border th {
            border: 1px solid #222;
        }
    </style>

</head>

<body>

    <table style="width: 100%;border-collapse:collapse;" cellpadding="1" cellspacing="0">
        <thead>
            <tr>
                <td colspan="12" style="">
                    <table style="width: 100%; border:none;" class="signature">
                        <tr>
                            <td style="width: 15%; border:none;">
                                <img class="hospital-logo"
                                    src="{{ asset('images/uploads/hospital_images/thumb/' . $po_hospital_details->logo) }}"
                                    width="60" alt="">
                            </td>
                            <td style="text-align:center; border:none;">
                                <span style="font-size: 15px;"> <strong>
                                        {{ isset($po_hospital_details->hospital_name) ? $po_hospital_details->hospital_name : '' }}
                                    </strong></span>
                                <br>
                                Address:
                                <span>
                                    {{ isset($po_hospital_details->addrress1) ? $po_hospital_details->addrress1 : '' }}</span><br>
                                Phone No:
                                <span>
                                    {{ isset($po_hospital_details->telephone1) ? $po_hospital_details->telephone1 : '' }}</span>
                            </td>
                            <td style=" text-align:right; width: 15%;  border:none;">
                                {{-- <div style="">
                                    <img src="data:image/png;base64, {{ $barcode_no }} " width="100" />
                                </div> --}}

                            </td>
                        </tr>
                    </table>
                    <div style="text-align: center;"> <strong>Doctor Share Report</strong> </div>

                </td>
            </tr>
            <tr class="tr_border">
                <th class="text-left" style="text-align: center;" scope="col">
                    <strong>SL</strong>
                </th>

                <th class="text-left" style="text-align: center;" scope="col">
                    <strong>Doctor Code</strong>
                </th>
                <th class="text-left" style="text-align: left; width:250px;" scope="col">
                    <strong>Doctor Name</strong>
                </th>
                <th class="text-left" style="text-align: left;" scope="col">
                    <strong>Item Code</strong>
                </th>
                <th class="text-left" style="text-align: left;" scope="col">
                    <strong>Item Name</strong>
                </th>
                <th class="text-left" style="text-align: left;width:100px;" scope="col">
                    <strong>Effective Date </strong>
                </th>
                <th class="text-left" style="text-align: left;" scope="col">
                    <strong>Doctor percent(%) </strong>
                </th>
                <th class="text-left" style="text-align: left;" scope="col">
                    <strong>Staff percent(%)</strong>
                </th>
                <th class="text-left" style="text-align: left;" scope="col">
                    <strong>Patient Type</strong>
                </th>
            </tr>
        </thead>
        <tbody class="tr_border">

            @if (isset($doctorPaymentData))
                @foreach ($doctorPaymentData as $data)
                    <tr class="tr_border">
                        <td class="text-left" style="text-align: center;" scope="col">
                            <strong>{{ $loop->iteration }}</strong>
                        </td>
                        <td class="text-left" style="text-align: left;" scope="col">{{ $data->person_code }}
                        </td>
                        <td class="text-left" style="text-align: left;" scope="col">{{ $data->full_name }}
                        </td>
                        <td class="text-left" style="text-align: left;" scope="col">
                            {{ $data->item_code }}</td>
                        <td class="text-left" style="text-align: left;" scope="col">
                            {{ $data->item_name }}</td>
                        <td class="text-left" style="text-align: left;" scope="col">
                            {{ isset($data->effdate) ? date('d-m-Y', strtotime($data->effdate)) : '' }}</td>
                        <td class="text-left" style="text-align: left;" scope="col">
                            {{ $data->drprcnt }}</td>
                        <td class="text-left" style="text-align: left;" scope="col">{{ $data->stfpercent }}
                        </td>
                        <td class="text-left" style="text-align: left;" scope="col">
                            {{ $data->pat_type }}</td>
                    </tr>
                @endforeach
            @endif
        </tbody>

       
    </table>
    <script>
        window.onload = function() {
            window.print();
        }
    </script>
</body>

</html>
